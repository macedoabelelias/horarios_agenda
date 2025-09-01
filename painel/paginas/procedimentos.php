<?php 
$pag = 'procedimentos';
if(@$procedimentos == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}
 ?>

<div class="breadcrumb-header justify-content-between">
	<form method="POST" action="rel/procedimentos_class.php" style="position:absolute; right:30px" target="_blank">
	<button type="submit" class="btn btn-success"><span class="fa fa-file-pdf-o"></span> Relatório</button>
	<input type="hidden" name="exame" id="filtro_exame">
	</form>

	<a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-user-plus me-1"></i>
				Adicionar <?php echo ucfirst($pag); ?></a>

	
	<li class="dropdown head-dpdn2" style="display: inline-block;">		
			<a href="#" data-toggle="dropdown"  class="btn btn-danger dropdown-toggle" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>
			<ul class="dropdown-menu">
			<li>
			<div class="notification_desc2">
			<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
			</div>
			</li>										
			</ul>
	</li>

</div>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">
</div>


<input type="hidden" id="ids">

<!-- Modal Perfil -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span
						class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form">
			<div class="modal-body">
				
					<div class="row">
						<div class="col-md-8">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Procedimento" required>							
						</div>
						<div class="col-md-4">							
								<label>Valor</label>
								<input type="text" class="form-control" id="valor" name="valor" placeholder="Valor"  required>							
						</div>
						
						
					</div>

					<div class="row">
					<div class="col-md-6">							
								<label>Tempo</label>
								<input type="number" class="form-control" id="tempo" name="tempo" placeholder="Minutos"  required>							
						</div>
						
					<div class="col-md-6">	
								<label>Aceita Convênio</label>
								<select class="form-select" name="convenio" id="convenio">
									<option value="Sim">Sim</option>
									<option value="Não">Não</option>	
								</select>						
							</div>	

							
							
				</div>

					<div class="row">
						<div class="col-md-12">							
								<label>Preparo</label>
								<input type="text" class="form-control" id="preparo" name="preparo" placeholder="(x horas em jejum... etc)" >							
						</div>
					</div>

					
					<input type="hidden" class="form-control" id="id" name="id">					
				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>



<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>
<script type="text/javascript">
	function buscar(exame){
		$('#filtro_exame').val(exame);
		listar(exame)
	}
</script>
