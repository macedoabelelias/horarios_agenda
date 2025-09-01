<?php 

include('../../conexao.php');
include('data_formatada.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

date_default_timezone_set('America/Sao_Paulo');



$id = $_GET['id'];


$query = $pdo->query("SELECT * FROM agendamentos where id = '$id'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

if(@count($res) > 0){
$funcionario = $res[0]['funcionario'];
$cliente = $res[0]['paciente'];
$hora = $res[0]['hora'];
$data = $res[0]['data'];
$usuario = $res[0]['usuario'];
$data_lanc = $res[0]['data_lanc'];
$obs = $res[0]['obs'];
$status = $res[0]['status'];
$servico = $res[0]['servico'];
$pago = $res[0]['pago'];
$st = $res[0]['status_cor'];
$tipo_pagamento = $res[0]['tipo_pagamento'];
$retorno = $res[0]['retorno'];
$novo_status = $res[0]['status_cor'];
$numero_convenio = $res[0]['numero_convenio'];
$valor_agd = $res[0]['valor'];
$convenio = $res[0]['convenio'];

$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", strtotime($hora));
$data_lancF = implode('/', array_reverse(explode('-', $data_lanc)));

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu = $res2[0]['nome'];
}else{
	$nome_usu = 'Sem Usuário';

}


if($status == 'Agendado'){
	$cor_status = 'red';
}

if($status == 'Confirmado'){
	$cor_status = 'blue';
}

if($status == 'Finalizado'){
	$cor_status = 'green';
}


if($pago == 'Sim'){
	$cor_pago = 'green';
}else{
	$cor_pago = 'red';
}

if($retorno == 'Sim'){
	$cor_pago = '';
}


$query2 = $pdo->query("SELECT * FROM procedimentos where id = '$servico'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){
	$nome_serv = $res2[0]['nome'];
	$valor_serv = $res2[0]['valor'];
	$aceita_convenio = $res2[0]['convenio'];

}else{

	$nome_serv = 'Não Lançado';
	$valor_serv = '';
	$aceita_convenio = @$res2[0]['convenio'];

}


if($valor_agd == ""){
	$valor_agd = $valor_serv;
}

$valor_agdF = number_format($valor_agd, 2, ',', '.');

$query2 = $pdo->query("SELECT * FROM clientes where id = '$cliente'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_paciente = $res2[0]['nome'];

	$telefone_paciente = $res2[0]['telefone'];	

	$nome_paciente = $res2[0]['nome'];

	$endereco_paciente = $res2[0]['endereco'];

	$data_nasc = $res2[0]['data_nasc'];

	$tipo_sanguineo = $res2[0]['tipo_sanguineo'];

	$nome_responsavel = $res2[0]['nome_responsavel'];
	

	$sexo = $res2[0]['sexo'];

	$obs_paciente = '';

	$cpf_paciente = $res2[0]['cpf'];

	$cpf_responsavel = $res2[0]['cpf_responsavel'];

	$profissao = $res2[0]['profissao'];

	$estado_civil = $res2[0]['estado_civil'];

	

}else{

	$nome_cliente = 'Sem Paciente';

	

}



$query2 = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_func = $res2[0]['nome'];

	

}else{

	$nome_func = '';

	

}



	//idade do paciente

	// separando yyyy, mm, ddd

    list($ano, $mes, $dia) = explode('-', $data_nasc);

    // data atual

    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

    // Descobre a unix timestamp da data de nascimento do fulano

    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

    // cálculo

    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);



    

	$data_nascF = implode('/', array_reverse(explode('-', $data_nasc)));

	

	$query2 = $pdo->query("SELECT * from convenios where id = '$convenio'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

$linhas2 = @count($res2);

if($linhas2 > 0){

	$nome_convenio = $res2[0]['nome'];

}else{

	$nome_convenio = 'Particular';

}



}





?>

<!DOCTYPE html>

<html>

<head>



<style>



@import url('https://fonts.cdnfonts.com/css/tw-cen-mt-condensed');

@page { margin: 145px 20px 25px 20px; }

#header { position: fixed; left: 0px; top: -110px; bottom: 100px; right: 0px; height: 35px; text-align: center; padding-bottom: 100px; }

#content {margin-top: 0px;}

#footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 80px; }

#footer .page:after {content: counter(page, my-sec-counter);}

body {font-family: 'Tw Cen MT', sans-serif;}



.marca{

	position:fixed;

	left:50;

	top:130;

	width:80%;

	opacity:10%;

}



</style>



</head>

<body>

<?php 

if($marca_dagua == 'Sim'){ ?>

<img class="marca" src="<?php echo $url_sistema ?>img/logo.jpg">	

<?php } ?>





<div id="header" >



	<div style="border-style: solid; font-size: 10px; height: 50px;">

		<table style="width: 100%; border: 0px solid #ccc;">

			<tr>

				<td style="border: 1px; solid #000; width: 20%; text-align: left;">

					<img style="margin-top: 5px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="140px">

				</td>

				<td style="width: 20%; text-align: left; font-size: 13px;">

				

				</td>

				<td style="width: 5%; text-align: center; font-size: 13px;">

				

				</td>

				<td style="width: 55%; text-align: right; font-size: 9px;padding-right: 10px;">

						<b><big>FICHA DE ATENDIMENTO</big></b><br>



						<br>

						 <?php echo @mb_strtoupper($data_hoje) ?>

				</td>

			</tr>		

		</table>

	</div>



<br>
	
	<p style="text-align:center; font-size:13px"><b>
		<?php if($retorno == 'Sim'){ echo 'RETORNO '; } ?>
		<?php echo $nome_serv ?></b> (<?php echo $nome_func ?>)</p>
			


		<table id="" style="border-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top:10px;">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#f2f0f0">

					<td colspan="8" style="width:100%; font-size: 10px"><b>DADOS DO PACIENTE</b> </td>					

				</tr>

				<tr >

					<td style="width:5%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">NOME: </td>

					<td style="width:35%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($nome_paciente) ?>

					</td>

					

					<td style="width:5%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">CPF: </td>

					<td style="width:13%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">

						<?php echo @mb_strtoupper($cpf_paciente) ?>

					</td>





					<td style="width:9%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">TELEFONE: </td>

					<td style="width:13%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">

						<?php echo @mb_strtoupper($telefone_paciente) ?>

					</td>



					<td style="width:5%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">SEXO: </td>

					<td style="width:5%; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($sexo) ?>

					</td>

    			</tr>





    			<tr >

					<td style="width:8%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">CONVÊNIO: </td>

					<td style="width:30%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($nome_convenio) ?>

					</td>

					

					<td style="width:5%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">IDADE: </td>

					<td style="width:11%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">

						<?php echo @mb_strtoupper($idade) ?> Anos

					</td>





					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">NASCIMENTO: </td>

					<td style="width:13%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">

						<?php echo @mb_strtoupper($data_nascF) ?>

					</td>



					<td style="width:13%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">TIPO SANGUÍNEO: </td>

					<td style="width:5%; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($tipo_sanguineo) ?>

					</td>

    			</tr>





    			<tr >

					<td style="width:8%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">PROFISSÃO </td>

					<td colspan="3" style="width:30%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($profissao) ?>

					</td>

					

					





					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">ESTADO CIVIL: </td>

					<td colspan="3" style="width:13%; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($estado_civil) ?>

					</td>



					

    			</tr>





    			<tr >

					<td style="width:8%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">OBS </td>

					<td colspan="3" style="width:30%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($obs_paciente) ?>

					</td>

					

					





					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">ENDEREÇO: </td>

					<td colspan="3" style="width:13%; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($endereco_paciente) ?>

					</td>



					

    			</tr>





    			<?php if($nome_responsavel != ""){ ?>

    				<tr >

					<td style="width:8%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">RESP </td>

					<td colspan="3" style="width:30%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($nome_responsavel) ?>

					</td>

					

					





					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">CPF RESP: </td>

					<td colspan="3" style="width:13%; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($cpf_responsavel) ?>

					</td>



					

    			</tr>



    			<?php } ?>

    			

			</thead>

		</table>







			<table id="" style="border-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top:10px;">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#f2f0f0">

					<td colspan="8" style="width:100%; font-size: 10px"><b>DADOS DA CONSULTA</b> </td>					

				</tr>



				<tr>
					<td style="width:15%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">PROCEDIMENTO: </td>

					<td style="width:35%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($nome_serv) ?>

					</td>					

					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">DATA: </td>

					<td style="width:15%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">

						<?php echo @mb_strtoupper($dataF) ?>

					</td>


					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">HORA: </td>

					<td style="width:15%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">

						<?php echo @mb_strtoupper($horaF) ?>

					</td>					

    			</tr>



    			<tr>
					<td style="width:15%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">PROFISSIONAL: </td>

					<td style="width:35%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($nome_func) ?>

					</td>					

					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">STATUS: </td>

					<td style="width:15%; border-bottom: : 1px solid #000; border-right: 1px solid #000; color:<?php echo $cor_status ?>">

						<?php echo @mb_strtoupper($status) ?>

					</td>


					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">PAGO: </td>

					<td style="width:15%; border-bottom: : 1px solid #000; border-right: 1px solid #000; color:<?php echo $cor_pago ?>">

						<?php echo @mb_strtoupper($pago) ?>

					</td>					

    			</tr>




    			<tr>
					<td style="width:15%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">FORMA PAGAMENTO: </td>

					<td style="width:35%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($tipo_pagamento) ?>

					</td>					

					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">VALOR: </td>

					<td style="width:15%; border-bottom: : 1px solid #000; border-right: 1px solid #000; color:<?php echo $cor_pago ?>">

						<?php echo @mb_strtoupper($valor_agdF) ?>

					</td>


					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">RETORNO: </td>

					<td style="width:15%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">

						<?php echo @mb_strtoupper($retorno) ?>

					</td>					

    			</tr>





    				<tr>
					<td style="width:15%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">CONVÊNIO: </td>

					<td style="width:35%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">

						<?php echo @mb_strtoupper($nome_convenio) ?>

					</td>					

					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">Nº CONVÊNIO: </td>

					<td colspan="3" style="width:35%; border-bottom: : 1px solid #000; border-right: 1px solid #000; ">

						<?php echo @mb_strtoupper($numero_convenio) ?>

					</td>


								

    			</tr>




    				<tr>
					<td style="width:15%; border-right: 1px solid #000;">AGENDADO POR: </td>

					<td style="width:35%; border-right: : 1px solid #000; ">

						<?php echo @mb_strtoupper($nome_usu) ?>

					</td>					

					<td style="width:10%; border-right: 1px solid #000;">LANÇADO EM: </td>

					<td colspan="3" style="width:35%;  border-right: 1px solid #000; ">

						<?php echo @mb_strtoupper($data_lancF) ?>

					</td>


								

    			</tr>


    			

			</thead>

		</table>


		<?php if($obs != ""){
			echo '<p style="text-align:left; font-size:11px"><b>Observações</b><br>';
			echo $obs;
			echo '</p>';
		} ?>


</div>



<div id="footer" class="row">

<hr style="margin-bottom: 0;">

	<table style="width:100%;">

		<tr style="width:100%;">

			<td style="width:60%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> / Telefone: <?php echo $telefone_sistema ?> / Email: <?php echo $email_sistema ?></td>

			<td style="width:40%; font-size: 10px; text-align: right;"><p class="page">Página  </p></td>

		</tr>

	</table>

</div>



</body>



</html>





