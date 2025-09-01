<?php 
$tabela = 'agendamentos';
require_once("../../../conexao.php");
@session_start();
$usuario_logado = @$_SESSION['id'].'';
$cliente = @$_POST['cliente'];
$data = @$_POST['data'];
$hora = @$_POST['hora'];
$obs = @$_POST['obs'];
$id = @$_POST['id'];
$funcionario = @$_POST['funcionario'];
$servico = @$_POST['servico'];
$data_agd = @$_POST['data'];
$hash = '';
$retorno = @$_POST['retorno'];
$hora_do_post = @$_POST['hora'];
$id_trat = @$_POST['id_trat'];
$val_agg = @$_POST['val_agg'];
$pago_agd = @$_POST['pago_agd'];
$tipo_pagamento = @$_POST['tipo_pago_agd'];
$pago_editar = @$_POST['pago_editar'];
if($pago_agd == ""){
	$pago_agd = 'Não';
}
if($pago_editar == "Sim"){
	$pago_agd = 'Sim';
}
if(@$hora == "" and $id == ""){
	echo 'Selecione um Horário antes de agendar!';
	exit();
}
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0 and $hora == ""){
    $hora = $res[0]['hora'];
}
if($retorno == 'Sim'){
	$procedimento = 'Retorno';
}else{
	$procedimento = 'Procedimento';
}
$hora_do_agd = @$hora;
$query = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$intervalo = $res[0]['intervalo'];
$nome_profissional = $res[0]['nome'];
$query = $pdo->query("SELECT * FROM procedimentos where id = '$servico'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$tempo = $res[0]['tempo'];
$nome_servico = $res[0]['nome'];
$preparo = $res[0]['preparo'];
$hora_minutos = @strtotime("+$tempo minutes", strtotime($hora));
$hora_final_servico = date('H:i:s', $hora_minutos);
$nova_hora = $hora;
$diasemana = array("Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sabado");
$diasemana_numero = date('w', strtotime($data));
$dia_procurado = $diasemana[$diasemana_numero];
//percorrer os dias da semana que ele trabalha
$query = $pdo->query("SELECT * FROM dias where funcionario = '$funcionario' and dia = '$dia_procurado'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) == 0){
	$query= $pdo->query("SELECT * FROM dias where funcionario = '$funcionario' and data = '$data_agd'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0){
		$inicio = $res[0]['inicio'];
		$final = $res[0]['final'];
		$inicio_almoco = $res[0]['inicio_almoco'];
		$final_almoco = $res[0]['final_almoco'];
	}else{
		echo 'Este Funcionário não trabalha neste Dias!';
	exit();
	}
	
}else{
	$inicio = $res[0]['inicio'];
	$final = $res[0]['final'];
	$inicio_almoco = $res[0]['inicio_almoco'];
	$final_almoco = $res[0]['final_almoco'];
	if(@strtotime($nova_hora) > strtotime($final)){
		echo 'Neste Dia o profissional não trabalha este horário!';
		exit();
	}
}
$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", @strtotime($hora));
while (@strtotime($nova_hora) < @strtotime($hora_final_servico)){		
		$hora_minutos = @strtotime("+$intervalo minutes", strtotime($nova_hora));			
		$nova_hora = date('H:i:s', $hora_minutos);
		
		//VERIFICAR NA TABELA HORARIOS AGD SE TEM O HORARIO NESSA DATA
		$query_agd = $pdo->query("SELECT * FROM horarios_agd where data = '$data' and funcionario = '$funcionario' and horario = '$nova_hora'");
		$res_agd = $query_agd->fetchAll(PDO::FETCH_ASSOC);
		if(@count($res_agd) > 0 and $hora_do_post != ""){
			echo 'Este serviço demora cerca de '.$tempo.' minutos, precisa escolher outro horário, pois neste horários não temos disponibilidade devido a outros agendamentos!'.$nova_hora;
			exit();
		}
		//VERIFICAR NA TABELA AGENDAMENTOS SE TEM O HORARIO NESSA DATA e se tem um intervalo entre o horario marcado e o proximo agendado nessa tabela
		$query_agd = $pdo->query("SELECT * FROM agendamentos where data = '$data' and funcionario = '$funcionario' and hora = '$nova_hora'");
		$res_agd = $query_agd->fetchAll(PDO::FETCH_ASSOC);
		if(@count($res_agd) > 0){
			if($tempo <= $intervalo){
			}else{
				if($hora_final_servico == $res_agd[0]['hora']){
					
				}else{
					echo 'Este serviço demora cerca de '.$tempo.' minutos, precisa escolher outro horário, pois neste horários não temos disponibilidade devido a outros agendamentos!';
						exit();
				}
				
			}
			
		}
		if(strtotime($nova_hora) > strtotime($inicio_almoco) and strtotime($nova_hora) < strtotime($final_almoco)){
		echo 'Este serviço demora cerca de '.$tempo.' minutos, precisa escolher outro horário, pois neste horários não temos disponibilidade devido ao horário de almoço!';
			exit();
	}
}
//validar horario
$query = $pdo->query("SELECT * FROM $tabela where data = '$data' and hora = '$hora' and funcionario = '$funcionario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'Este horário não está disponível!';
	exit();
}
//VERIFICAR NA TABELA HORARIOS AGD SE TEM O HORARIO NESSA DATA
		$query_agd = $pdo->query("SELECT * FROM horarios_agd where data = '$data' and funcionario = '$funcionario' and horario = '$hora'");
		$res_agd = $query_agd->fetchAll(PDO::FETCH_ASSOC);
		if(@count($res_agd) > 0){
			echo 'Já possui agendamento nesse horário para este profissional!';
			exit();
		}
if($id != ""){
	$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$hash = $res[0]['hash'];
	if($hora_do_post == ""){
		$hora = $res[0]['hora'];
	}
	
	$hora_do_agd = $res[0]['hora'];
	$pdo->query("DELETE FROM $tabela where id = '$id'");
	$pdo->query("DELETE FROM horarios_agd where agendamento = '$id'");
	$texto_mensagem = 'Agendamento Editado';
	if($hash != ""){
		require("../../apis/excluir.php");
	}
}else{
	$texto_mensagem = 'Novo Agendamento';
}
//pegar nome do cliente
$query = $pdo->query("SELECT * FROM clientes where id = '$cliente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_cliente = $res[0]['nome'];
$telefone = $res[0]['telefone'];

if($token_whatsapp != ""){
//agendar o alerta de confirmação
$hora_atual = date('H:i:s');
$data_atual = date('Y-m-d');
//$hora_minutos = strtotime("-$minutos_aviso minutes", strtotime($hora));
//$nova_hora = date('H:i:s', $hora_minutos);
$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
$mensagem_whatsapp = '*'.$nome_sistema.'*%0A';
$mensagem_whatsapp .= '_'.$texto_mensagem.'_ %0A %0A';
$mensagem_whatsapp .= '*Paciente:* '.$nome_cliente.'%0A';
$mensagem_whatsapp .= '*'.$procedimento.':* '.$nome_servico.'%0A';
$mensagem_whatsapp .= '*Data:* '.$dataF.'%0A';
$mensagem_whatsapp .= '*Hora:* '.$horaF.'%0A';
$mensagem_whatsapp .= '*Profissional:* '.$nome_profissional.'%0A';
if($obs != ""){
$mensagem_whatsapp .= '*OBS:* '.$obs.'%0A';
}
if($preparo != ""){
$mensagem_whatsapp .= '%0A*Atenção:* '.$preparo.'%0A';
}
require_once("../../apis/texto.php");
}
if ($id_trat != '') {
	$query = $pdo->prepare("INSERT INTO $tabela SET funcionario = '$funcionario', paciente = '$cliente', hora = '$hora', data = '$data_agd', usuario = '$usuario_logado', status = 'Agendado', obs = :obs, data_lanc = curDate(), servico = '$servico', hash = '$hash', pago = '$pago_agd', convenio = '0', retorno = '$retorno', id_tratamento = '$id_trat', valor = '$val_agg', tipo_pagamento = '$tipo_pagamento'");
}else{
	$query = $pdo->prepare("INSERT INTO $tabela SET funcionario = '$funcionario', paciente = '$cliente', hora = '$hora', data = '$data_agd', usuario = '$usuario_logado', status = 'Agendado', obs = :obs, data_lanc = curDate(), servico = '$servico', hash = '$hash', pago = '$pago_agd', convenio = '0', retorno = '$retorno'");
}
$query->bindValue(":obs", "$obs");
$query->execute();
$ult_id = $pdo->lastInsertId();
while (strtotime($hora) < strtotime($hora_final_servico)){
		
		$hora_minutos = strtotime("+$intervalo minutes", strtotime($hora));			
		$hora = date('H:i:s', $hora_minutos);
		if(strtotime($hora) < strtotime($hora_final_servico)){
			$query = $pdo->query("INSERT INTO horarios_agd SET agendamento = '$ult_id', horario = '$hora', funcionario = '$funcionario', data = '$data_agd'");
		}
	
}
if($api_whatsapp == 'wm'){
	//MENSAGEM DE CONFIRMAÇÃO DO AGENDAMENTO
	if($horas_confirmacao > 0 and $token_whatsapp != ""){
		$mensagem_whatsapp = '*Confirmação de Agendamento* ';
		$mensagem_whatsapp .= '                              _(Digite o número com a opção desejada)_';
		$mensagem_whatsapp .= '                              1.  Digite 1️⃣ para confirmar ✅';		
		$mensagem_whatsapp .= '                              2.  Digite 2️⃣ para Cancelar ❌';
		$id_envio = $ult_id;
		$data_envio = $data_agd.' '.$hora_do_agd;
		
		require("../../apis/confirmacao.php");
		$id_agd = $id;		
		$pdo->query("UPDATE $tabela SET hash = '$id_agd' WHERE id = '$ult_id'");
	}
}else{
	
	if($horas_confirmacao > 0 and $token_whatsapp != ""){		
		$mensagem_whatsapp = '*Confirmação de Agendamento* %0A';
		$mensagem_whatsapp .= '_(Digite o número com a opção desejada)_ %0A';
		$mensagem_whatsapp .= '1.  Digite 1️⃣ para confirmar ✅ %0A';
		$mensagem_whatsapp .= '2.  Digite 2️⃣ para Cancelar ❌ %0A';
		$id_envio = $ult_id;
		$data_envio = $data_agd.' '.$hora_do_agd;
		$data_agd = date('Y-m-d H:i:s', strtotime("-$horas_confirmacao hours",strtotime($data_envio)));
		
		require("../../apis/agendar.php");
		$id_agd = $id;		
		$pdo->query("UPDATE $tabela SET hash = '$hash' WHERE id = '$ult_id'");
	}
}
	
echo 'Salvo com Sucesso'; 
?>