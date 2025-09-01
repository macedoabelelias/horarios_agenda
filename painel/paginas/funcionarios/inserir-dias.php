<?php 
require_once("../../../conexao.php");
$tabela = 'dias';
$id = $_POST['id'];
$id_dias = $_POST['id_d'];
$dias = $_POST['dias'];
$inicio = $_POST['inicio'];
$final = $_POST['final'];
$inicio_almoco = $_POST['inicio_almoco'];
$final_almoco = $_POST['final_almoco'];
$data = $_POST['data'];
if($data == "" and $dias == ""){
	echo 'Selecione um dia ou uma data!';
	exit();
}
if($data == ""){
	$data_sql = "";
}else{
	$data_sql = ", data = '$data'";
}
if($id_dias == ''){
	$pdo->query("INSERT INTO $tabela SET dia = '$dias',  inicio = '$inicio',  final = '$final', funcionario = '$id', inicio_almoco = '$inicio_almoco', final_almoco = '$final_almoco' $data_sql");
}else{
	$pdo->query("UPDATE $tabela SET dia = '$dias',  inicio = '$inicio',  final = '$final', funcionario = '$id', inicio_almoco = '$inicio_almoco', final_almoco = '$final_almoco' $data_sql WHERE id = '$id_dias'");
}
echo 'Salvo com Sucesso';
 ?>