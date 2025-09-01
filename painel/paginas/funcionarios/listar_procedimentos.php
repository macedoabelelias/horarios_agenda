<?php 
$tabela = 'func_proc';
require_once("../../../conexao.php");

$usuario = $_POST['id'];
$query = $pdo->query("SELECT * from $tabela where funcionario = '$usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover table-bordered text-nowrap border-bottom dt-responsive" id="" style="width:100%">
	<thead> 
	<tr> 
	<th>Procedimento</th>		
	<th>Excluir</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$procedimento = $res[$i]['procedimento'];
	$query2 = $pdo->query("SELECT * from procedimentos where id = '$procedimento'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_procedimento = $res2[0]['nome']; 	
echo <<<HTML
<tr>
<td class="" width="75%">{$nome_procedimento}</td>
<td>

<div class="dropdown" style="display: inline-block;">                      
                        <a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fe fe-trash-2 text-danger"></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluirProcedimento('{$id}', '{$usuario}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>
</td>
</tr>
HTML;
}
echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;
}else{
	echo '<small>Nenhum Registro Encontrado!</small>';
}
?>
<script type="text/javascript">
	function excluirProcedimento(id, usuario){
		    	
    	$.ajax({
        url: 'paginas/' + pag + "/excluir_procedimento.php",
        method: 'POST',
        data: {id},
        dataType: "html",
        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {
                listarProcedimentos(usuario);
            } 
        }
    });
	}
	
	
</script>