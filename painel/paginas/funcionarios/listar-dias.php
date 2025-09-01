<?php 
require_once("../../../conexao.php");
$tabela = 'dias';
$id_func = $_POST['func'];
$query = $pdo->query("SELECT * FROM $tabela where funcionario = '$id_func' ORDER BY id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<small><small>
	<table class="table table-hover">
	<thead> 
	<tr> 
	<th>Dia</th>	
	<th>Jornada</th>	
	<th class="esc">Almoço</th>		
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
	$id = $res[$i]['id'];
	$dia = $res[$i]['dia'];
	$inicio = $res[$i]['inicio'];
	$final = $res[$i]['final'];
	$inicio_almoco = $res[$i]['inicio_almoco'];
	$final_almoco = $res[$i]['final_almoco'];
	$data = $res[$i]['data'];
	$dataF = implode('/', array_reverse(@explode('-', $data)));
	if($inicio_almoco == '00:00:00'){
		$inicio_almoco = 'Não Lançado';
	}
	if($final_almoco == '00:00:00'){
		$final_almoco = 'Não Lançado';
	}
	if($dia == ""){
		$dia_data = $dataF;
	}else{
		$dia_data = $dia;
	}
	
echo <<<HTML
<tr class="">
<td class="">{$dia_data}</td>
<td class="">{$inicio} / {$final}</td>
<td class="esc">{$inicio_almoco} / {$final_almoco}</td>
<td>
		
		<div class="dropdown" style="display: inline-block;">                      
                        <a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fe fe-trash-2 text-danger"></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluirDias('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>

		<big><a href="#" onclick="editarHorarios('{$id}','{$dia}', '{$inicio}', '{$final}', '{$inicio_almoco}', '{$final_almoco}', '{$data}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>
		</td>
</tr>
HTML;
}
echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-dias-excluir"></div></small>
</table>
</small></small>
HTML;
}else{
	echo '<small><small>Não possui nenhum Dia Cadastrado!</small></small>';
}
?>
<script type="text/javascript">
	function excluirDias(id){
    $.ajax({
        url: 'paginas/' + pag + "/excluir-dias.php",
        method: 'POST',
        data: {id},
        dataType: "text",
        success: function (mensagem) {            
            if (mensagem.trim() == "Excluído com Sucesso") {   
            	var func = $("#id_dias").val();             
                listarDias(func);                
            } else {
                $('#mensagem-dias-excluir').addClass('text-danger')
                $('#mensagem-dias-excluir').text(mensagem)
            }
        },      
    });
}
function editarHorarios(id, dia, inicio, final, inicio_almoco, final_almoco, data){
		$('#id_d').val(id);
		$('#dias').val(dia).change();
		$('#inicio').val(inicio);
		$('#final').val(final);
		$('#inicio_almoco').val(inicio_almoco);
		$('#final_almoco').val(final_almoco);	
		$('#data_exp').val(data);	
	}
	function limparCamposHorarios(){
		$('#id_d').val('');
		
	}
</script>