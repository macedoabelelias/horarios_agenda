<?php 
$tabela = 'convenios';
require_once("../../../conexao.php");
$query = $pdo->query("SELECT * from $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr>
	<th></th>
	<th>Nome</th>
	<th>Telefone</th>	
	<th>Pacientes</th>
	<th>Comissão %</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$comissao = $res[$i]['comissao'];
	$telefone = $res[$i]['telefone'];
$query2 = $pdo->query("SELECT * from clientes where convenio = '$id' ");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_acessos = @count($res2);
		
echo <<<HTML
<tr>
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>
<td>
{$nome}
</td>
<td class="esc">{$telefone}</td>
<td class="esc">{$total_acessos}</td>
<td class="esc">{$comissao}%</td>
<td>
	<big><a href="#" class="btn btn-info-light btn-sm" onclick="editar('{$id}','{$nome}','{$comissao}','{$telefone}')" title="Editar Dados"><i class="fa fa-edit "></i></a></big>
	
	<a href="#" class="btn btn-danger-light btn-sm" onclick="excluir('{$id}')" title="Excluir"><i class="fa fa-trash-can "></i></a>

<big><a href="#" class="btn btn-primary-light btn-sm" onclick="arquivo('{$id}', '{$nome}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o "></i></a></big>
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
	$(document).ready( function () {		
    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true
    });
} );
</script>
<script type="text/javascript">
	function editar(id, nome, comissao, telefone){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');
    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#comissao').val(comissao);
    	$('#telefone').val(telefone);
    
    	$('#modalForm').modal('show');
	}
	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
   		 $('#comissao').val('');
   		 $('#telefone').val('');
    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}
	function selecionar(id){
		var ids = $('#ids').val();
		if($('#seletor-'+id).is(":checked") == true){
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', '');
			$('#ids').val(retirar);
		}
		var ids_final = $('#ids').val();
		if(ids_final == ""){
			$('#btn-deletar').hide();
		}else{
			$('#btn-deletar').show();
		}
	}
	function deletarSel(){
		var ids = $('#ids').val();
		var id = ids.split("-");
		
		for(i=0; i<id.length-1; i++){
			excluir(id[i]);			
		}
		limparCampos();
	}
	function arquivo(id, nome){
    $('#id-arquivo').val(id);    
    $('#nome-arquivo').text(nome);
    $('#modalArquivos').modal('show');
    $('#mensagem-arquivo').text(''); 
    listarArquivos();   
}
</script>