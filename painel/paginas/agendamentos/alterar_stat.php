<?php 
$tabela = 'agendamentos';
require_once("../../../conexao.php");
$id = $_POST['id'];
$status = $_POST['status'];
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cliente = $res[0]['paciente'];
$usuario = $res[0]['funcionario'].'';
$data = $res[0]['data'];
$hora = $res[0]['hora'];
$hash = $res[0]['hash'];
$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", strtotime($hora));
$pdo->query("UPDATE $tabela SET status_cor = '$status' where id = '$id'");
echo 'Alterado com Sucesso';
?>