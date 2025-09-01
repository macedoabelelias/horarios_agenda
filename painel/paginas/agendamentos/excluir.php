<?php 
$tabela = 'agendamentos';
require_once("../../../conexao.php");

$id = $_POST['id'];
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cliente = $res[0]['paciente'];
$usuario = $res[0]['funcionario'].'';
$data = $res[0]['data'];
$hora = $res[0]['hora'];
$hash = $res[0]['hash'];
$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", strtotime($hora));


$query = $pdo->query("SELECT * FROM clientes where id = '$cliente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_cliente = $res[0]['nome'];
$telefone = $res[0]['telefone'];


$pdo->query("DELETE FROM horarios_agd where agendamento = '$id'");
$pdo->query("DELETE FROM $tabela where id = '$id'");
echo 'Excluído com Sucesso';


if($token_whatsapp != ""){
	
		$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
		$mensagem_whatsapp = '*'.$nome_sistema.'* %0A';
		$mensagem_whatsapp .= '_Agendamento Cancelado_ %0A';
		$mensagem_whatsapp .= '*Data:* '.$dataF.' %0A';	
		$mensagem_whatsapp .= '*Hora:* '.$horaF.' %0A%0A';			
		require_once("../../apis/texto.php");
	
}	
if($hash != ""){
	require("../../apis/cancelar_agendamento.php");
}
?>