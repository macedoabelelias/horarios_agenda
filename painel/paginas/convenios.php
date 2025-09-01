<?php 
$pag = 'convenios';
if(@$convenios == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}
 ?>

<div class="breadcrumb-header justify-content-between">
<a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-plus me-1"></i>
				Adicionar <?php echo ucfirst($pag); ?></a>
	
	<big><a class="btn btn-danger" href="#" onclick="deletarSel()" title="Excluir" id="btn-deletar"
				style="display:none"><i class="fe fe-trash-2"></i> Deletar</a></big>

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
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Convênio" required>							
						</div>
						<div class="col-md-4">							
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone do Convênio" >							
						</div>
						
												
					</div>
					<div class="row">
						<div class="col-md-6">						
								<label>Comissão da Clínica %</label>
								<input type="number" class="form-control" id="comissao" name="comissao" placeholder="Se Houver">							
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
	<!-- Modal Arquivos -->
	<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="nome-arquivo"></span></h4>
				<button id="btn-fechar-arquivos" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span
						class="text-white" aria-hidden="true">&times;</span></button>
			</div>
				<form id="form-arquivos" method="post">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-8">						
								<div class="form-group"> 
									<label>Arquivo</label> 
									<input class="form-control" type="file" name="arquivo_conta" onChange="carregarImgArquivos();" id="arquivo_conta">
								</div>	
							</div>
							<div class="col-md-4" style="margin-top:-10px">	
								<div id="divImgArquivos">
									<img src="images/arquivos/sem-foto.png"  width="60px" id="target-arquivos">									
								</div>					
							</div>
						</div>
						<div class="row" >
							<div class="col-md-8">
								<input type="text" class="form-control" name="nome-arq"  id="nome-arq" placeholder="Nome do Arquivo * " required>
							</div>
							<div class="col-md-4">										 
								<button type="submit" class="btn btn-primary">Inserir</button>
							</div>
						</div>
						<hr>
						<small><div id="listar-arquivos"></div></small>
						<br>
						<small><div align="center" id="mensagem-arquivo"></div></small>
						<input type="hidden" class="form-control" name="id-arquivo"  id="id-arquivo">
					</div>
				</form>
			</div>
		</div>
	<script type="text/javascript">var pag = "<?=$pag?>"</script>
	<script src="js/ajax.js"></script>
<script type="text/javascript">
			function carregarImgArquivos() {
				var target = document.getElementById('target-arquivos');
				var file = document.querySelector("#arquivo_conta").files[0];
				var arquivo = file['name'];
				resultado = arquivo.split(".", 2);
				if(resultado[1] === 'pdf'){
					$('#target-arquivos').attr('src', "images/pdf.png");
					return;
				}
				if(resultado[1] === 'rar' || resultado[1] === 'zip'){
					$('#target-arquivos').attr('src', "images/rar.png");
					return;
				}
				if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
					$('#target-arquivos').attr('src', "images/word.png");
					return;
				}
				if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
					$('#target-arquivos').attr('src', "images/excel.png");
					return;
				}
				if(resultado[1] === 'xml'){
					$('#target-arquivos').attr('src', "images/xml.png");
					return;
				}
				var reader = new FileReader();
				reader.onloadend = function () {
					target.src = reader.result;
				};
				if (file) {
					reader.readAsDataURL(file);
				} else {
					target.src = "";
				}
			}
		</script>
		<script type="text/javascript">
			$("#form-arquivos").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					url: 'paginas/' + pag + "/arquivos.php",
					type: 'POST',
					data: formData,
					success: function (mensagem) {
						$('#mensagem-arquivo').text('');
						$('#mensagem-arquivo').removeClass()
						if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#nome-arq').val('');
						$('#arquivo_conta').val('');
						$('#target-arquivos').attr('src','images/arquivos/sem-foto.png');
						listarArquivos();
					} else {
						$('#mensagem-arquivo').addClass('text-danger')
						$('#mensagem-arquivo').text(mensagem)
					}
				},
				cache: false,
				contentType: false,
				processData: false,
			});
			});
		</script>
		<script type="text/javascript">
			function listarArquivos(){
				var id = $('#id-arquivo').val();	
				$.ajax({
					url: 'paginas/' + pag + "/listar-arquivos.php",
					method: 'POST',
					data: {id},
					dataType: "text",
					success:function(result){
						$("#listar-arquivos").html(result);
					}
				});
			}
		</script>
