<?php 
require_once("verificar.php");
require_once("../conexao.php");
$pag = 'agendamentos';
$data_atual = date('Y-m-d');
//verificar se ele tem a permissão de estar nessa página
if(@$agendamentos == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
	exit();
}
?>


	<div class="row" style="margin-top: 20px">
		<div class="col-md-4">
			<a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-plus me-1"></i>
				Novo Agendamento</a>
	
		</div>
		<?php 
					if($atendimento_usuario == 'Sim' and $nivel_usuario != 'Administrador'){
						$id_func = $id_usuario;
						$ocultar_select = 'ocultar';
					}else{
						$id_func = '';
						$ocultar_select = '';
					}
				?>
		<div class="col-md-3 <?php echo $ocultar_select ?>">
			<div class="form-group">			
				<select class="sel200" id="funcionario" name="funcionario" style="width:100%;" onchange="mudarFuncionario()"> 
					<?php if($id_func == ""){ ?>
					<option value="">Selecione um Profissional</option>
								
					<?php 
					$query = $pdo->query("SELECT * FROM usuarios where atendimento = 'Sim' ORDER BY id desc");
					$res = $query->fetchAll(PDO::FETCH_ASSOC);
					$total_reg = @count($res);
					if($total_reg > 0){
						for($i=0; $i < $total_reg; $i++){
							foreach ($res[$i] as $key => $value){}
								echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
						}
					}
					}else{
										echo '<option value="'.$id_usuario.'">'.$nome_usuario.'</option>';
										}
					?>
				</select> 
			</div> 	
		</div>
		<div class="col-md-3 ">
			<div class="form-group">			
				<select class="form-select" id="table" name="table" style="width:100%; " onchange="listar()"> 
					
					<option value="tabela">Mostrar Tabela</option>
					<option value="card">Mostrar Card</option>			
					<option value="horarios">Horários Disponíveis</option>	
				</select> 
				  
			</div> 	
		</div>
	</div>


<input type="hidden" name="data_agenda" id="data_agenda" value="<?php echo date('Y-m-d') ?>"> 
<div class="row" style="margin-top: 15px">
	<div class="col-md-4 agile-calendar">
		<div class="calendar-widget">
			<!-- grids -->
			<div class="agile-calendar-grid">
				<div class="page">
					<div class="w3l-calendar-left">
						<div class="calendar-heading">
						</div>
						<div class="monthly" id="mycalendar"></div>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-md-8 bs-example widget-shadow" style="padding:10px 5px; margin-top: 0px;" id="listar">
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span
						class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form method="post" id="form-text">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Paciente</label> 
								<div id="listar_pacientes"></div>								
							</div>		
								
						</div>	
						<div class="col-md-1" style="margin-top: 27px; margin-left: -10px">
							<button id="btn_cliente" type="button" data-bs-toggle="modal" data-bs-target="#modalPacientes" class="btn btn-primary"> <i class="fa fa-plus"></i> </button>		
						</div>
						<div class="col-md-4 ">
							<div class="form-group">
							<label>Profissional </label> 			
								<select class="form-control sel2" id="funcionario_modal" name="funcionario" style="width:100%;" onchange="mudarFuncionarioModal()"> 
									<?php if($id_func == ""){ ?>
									<option value="">Selecione um Profissional</option>
									<?php 
									$query = $pdo->query("SELECT * FROM usuarios where atendimento = 'Sim' ORDER BY id desc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){
										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){}
												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
										}
									}
								}else{
									echo '<option value="'.$id_usuario.'">'.$nome_usuario.'</option>';
									}
									?>
								
								</select>   
							</div> 	
						</div>
						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Procedimento</label> 
								<select class="form-control sel3" id="servico" name="servico" style="width:100%;" required> 									
								</select>    
							</div>						
						</div>
					</div>
					<div class="row">						
						<div class="col-md-3" id="nasc">						
							<div class="form-group"> 
								<label>Data </label> 
								<input type="date" class="form-control" name="data" id="data-modal" onchange="mudarData()"> 
							</div>						
						</div>
					<div class="col-md-7">						
						<div class="form-group"> 
							<label>OBS <small>(Máx 100 Caracteres)</small></label> 
							<input maxlength="100" type="text" class="form-control" name="obs" id="obs">
						</div>						
					</div>
					<div class="col-md-2 ">
							<div class="form-group">
							<label>Retorno</label> 			
								<select class="form-select" id="retorno" name="retorno"  >
									<option value="Não">Não</option>
									<option value="Sim">Sim</option>
								</select>   
							</div> 	
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12" id="nasc">						
							<div class="form-group"> 								
								<div id="listar-horarios">
									<small>Selecione um Profissional ou um Procedimento</small>
								</div>
							</div>						
						</div>					
					</div>
					<hr>
				
					<br>
					<input type="hidden" name="id" id="id">
					<input type="hidden" name="id_funcionario" id="id_funcionario" value="<?php echo $id_func ?>"> 
					<input type="hidden" name="pago_editar" id="pago_editar">
					<small><div id="mensagem" align="center" class="mt-3"></div></small>					
				</div>
				<div class="modal-footer">
					<button id="btn_salvar" type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>




<!-- Modal -->
<div class="modal fade" id="modalServico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
				<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="procedimento"></span><span id="titulo_servico"></span></h4>
				<button id="btn-fechar-servico" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span
						class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			
			<form method="post" id="form-servico">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-5">						
							<div class="form-group"> 
								<label>Funcionário</label> 
								<select class="form-control sel4" id="funcionario_agd" name="funcionario_agd" style="width:100%;" required> 
									<?php 
									$query = $pdo->query("SELECT * FROM usuarios where atendimento = 'Sim' ORDER BY nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){
										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){}
												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
										}
									}
									?>
								</select>    
							</div>						
						</div>
						<div class="col-md-3" id="nasc">						
							<div class="form-group"> 
								<label>Valor </label> 
								<input type="text" class="form-control" name="valor_serv_agd" id="valor_serv_agd"> 
							</div>						
						</div>
						<div class="col-md-4" id="nasc">						
							<div class="form-group"> 
								<label>Data PGTO</label> 
								<input type="date" class="form-control" name="data_pgto" id="data_pgto" value="<?php echo $data_atual ?>"> 
							</div>						
						</div>	
					</div>
					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Forma PGTO</label> 
								<select class="form-select" id="pgto" name="pgto" style="width:100%;"> 
									<option value="Convênio">Convênio</option>
									<?php 
									$query = $pdo->query("SELECT * FROM formas_pgto");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){
										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){}
												echo '<option value="'.$res[$i]['nome'].'">'.$res[$i]['nome'].'</option>';
										}
									}
									?>
								</select>    
							</div>						
						</div>
						<div class="col-md-8" id="div_convenio">						
							<div class="form-group"> 
								<label>Convênio </label> 
								<select class="form-select" id="convenio" name="convenio" style="width:100%;" onchange="calcularValor()">
								<option value="">Selecione um Convênio</option> 
									<?php 
									$query = $pdo->query("SELECT * FROM convenios");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){
										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){}
												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
										}
									}
									?>
								</select>  
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group"> 
								<label>Número do Convênio</label> 
								<input type="text" class="form-control" name="numero_convenio" id="numero_convenio" placeholder="Número do convênio"> 
							</div>		
						</div>
					</div>
					<br>
					
					<input type="hidden" name="id_agd" id="id_agd"> 
					<input type="hidden" name="cliente_agd" id="cliente_agd"> 
					<input type="hidden" name="servico_agd" id="servico_agd">
					<input type="hidden" name="descricao_serv_agd" id="descricao_serv_agd">
					
					<small><div id="mensagem-servico" align="center" class="mt-3"></div></small>					
				</div>
				<div class="modal-footer">
					<button id="btn_salvar_servico" type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Pacientes -->
<div class="modal fade" id="modalPacientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="overflow: scroll; max-height:600px; scrollbar-width: thin;">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel">Novo Paciente</h4>
				<button id="btn-fechar-pacientes" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button" onclick="inserir()"><span
						class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form-pacientes">
				<div class="modal-body">
					


					<div class="row">
						<div class="col-md-6 mb-2 col-6 needs-validation was-validated">
							<label>Nome <span class="text-danger" style="font-size: 9px">(Obrigatório)</span></label>
							<div class="form-group has-success mg-b-0">
								<input class="form-control" id="nome" name="nome" placeholder="Digite o Nome" required type="text"
									value="">
							</div>
						</div>

						<div class="col-md-3 col-6">
							<label>Telefone</label>
							<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Digite o Telefone">
						</div>

						<div class="col-md-3 mb-2">
							<label>Nascimento</label>
							<input type="date" class="form-control" id="data_nasc" name="data_nasc" placeholder="">
						</div>


					</div>



					<div class="row">

						<div class="col-md-3 mb-2 col-6">
							<label>Pessoa</label>
							<select name="tipo_pessoa" id="tipo_pessoa" class="form-select" onchange="mudarPessoa()">
								<option value="Física">Física</option>
								<option value="Jurídica">Jurídica</option>
							</select>
						</div>

						<div class="col-md-3 mb-2 col-6">
							<label>CPF / CNPJ</label>
							<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF">
						</div>

						<div class="col-md-1 col-1" style="margin-top: 28px; margin-left: -10px">
							<a title="Buscar CNPJ" class="btn btn-primary" href="#" onclick="buscarCNPJ()" class="btn btn-primary"> <i
									class="bi bi-search"></i> </a>
						</div>



						<div class="col-md-5">
							<label>Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Digite o Email">
						</div>


					</div>

					<div class="row">

						<div class="col-md-2 mb-2">
							<label>CEP</label>
							<input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o CEP"
								onblur="pesquisacep(this.value);">
						</div>



						<div class="col-md-5 mb-2">
							<label>Rua</label>
							<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Ex. Rua Central">
						</div>

						<div class="col-md-2 mb-2">
							<label>Número</label>
							<input type="text" class="form-control" id="numero" name="numero" placeholder="1500">
						</div>

						<div class="col-md-3 mb-2">
							<label>Complemento</label>
							<input type="text" class="form-control" id="complemento" name="complemento" placeholder="Bloco B AP 104">
						</div>


					</div>


					<div class="row">

						<div class="col-md-4 mb-2">
							<label>Bairro</label>
							<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro">
						</div>

						<div class="col-md-5 mb-2">
							<label>Cidade</label>
							<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade">
						</div>

						<div class="col-md-3 mb-2">
							<label>Estado</label>
							<select class="form-select" id="estado" name="estado">
								<option value="">Selecionar</option>
								<option value="AC">Acre</option>
								<option value="AL">Alagoas</option>
								<option value="AP">Amapá</option>
								<option value="AM">Amazonas</option>
								<option value="BA">Bahia</option>
								<option value="CE">Ceará</option>
								<option value="DF">Distrito Federal</option>
								<option value="ES">Espírito Santo</option>
								<option value="GO">Goiás</option>
								<option value="MA">Maranhão</option>
								<option value="MT">Mato Grosso</option>
								<option value="MS">Mato Grosso do Sul</option>
								<option value="MG">Minas Gerais</option>
								<option value="PA">Pará</option>
								<option value="PB">Paraíba</option>
								<option value="PR">Paraná</option>
								<option value="PE">Pernambuco</option>
								<option value="PI">Piauí</option>
								<option value="RJ">Rio de Janeiro</option>
								<option value="RN">Rio Grande do Norte</option>
								<option value="RS">Rio Grande do Sul</option>
								<option value="RO">Rondônia</option>
								<option value="RR">Roraima</option>
								<option value="SC">Santa Catarina</option>
								<option value="SP">São Paulo</option>
								<option value="SE">Sergipe</option>
								<option value="TO">Tocantins</option>
								<option value="EX">Estrangeiro</option>
							</select>
						</div>


					</div>


					<div class="row">
						<div class="col-md-3 mb-2">
							<label>Tipo Sanguíneo</label>
							<input type="text" class="form-control" id="tipo_sanguineo" name="tipo_sanguineo" placeholder="Tipo Sanguineo">
						</div>

						<div class="col-md-2 mb-2">
							<label>Sexo</label>
							<select class="form-select" id="sexo" name="sexo">
								<option value="M">Masculino</option>
								<option value="F">Feminino</option>								
							</select>
						</div>

						<div class="col-md-4 mb-2">
							<label>Profissão</label>
							<input type="text" class="form-control" id="profissao" name="profissao" placeholder="Tipo Sanguineo">
						</div>

						<div class="col-md-3 mb-2">
							<label>Estado Civil</label>
							<select class="form-select" id="estado_civil" name="estado_civil">
								<option value="Solteiro(a)">Solteiro(a)</option>
								<option value="Casado(a)">Casado(a)</option>		
								<option value="Divorciado(a)">Divorciado(a)</option>		
								<option value="Viúvo(a)">Viúvo(a)</option>								
							</select>
						</div>
					</div>


					<div class="row">
						<div class="col-md-2 mb-2">
							<label>Convênio</label>
							<select class="form-select" name="convenio" id="convenio">
									<option value="0">Nenhum</option>
									<?php 
									$query = $pdo->query("SELECT * from convenios order by id asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$linhas = @count($res);
									if($linhas > 0){
										for($i=0; $i<$linhas; $i++){
											?>
											<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
										<?php } } ?>
									</select>	
						</div>

							<div class="col-md-4 mb-2">
							<label>Responsável</label>
							<input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel" placeholder="Se Houver preencha">
						</div>


						<div class="col-md-3 mb-2">
							<label>CPF Responsável</label>
							<input type="text" class="form-control" id="cpf_responsavel" name="cpf_responsavel" placeholder="CPF Resposnável">
						</div>

						<div class="col-md-3 mb-2">
							<label>Telefone 2</label>
							<input type="text" class="form-control" id="telefone2" name="telefone2" placeholder="Outro Telefone">
						</div>
					</div>



								
						<br>
						<small><div id="mensagem_pacientes" align="center"></div></small>
					</div>
					<div class="modal-footer">       
						<button id="btn_salvar_pacientes" type="submit" class="btn btn-primary">Salvar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>




<!-- calendar -->
<script type="text/javascript" src="js/monthly.js"></script>
<script type="text/javascript">
	$(window).load( function() {
		$('#mycalendar').monthly({
			mode: 'event',
		});
		$('#mycalendar2').monthly({
			mode: 'picker',
			target: '#mytarget',
			setWidth: '250px',
			startHidden: true,
			showTrigger: '#mytarget',
			stylePast: true,
			disablePast: true
		});
		switch(window.location.protocol) {
			case 'http:':
			case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
	}
});
</script>
<!-- //calendar -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		listarPacientes()
		var atend = "<?=$atendimento_usuario?>";
		if(atend == 'Sim'){
			$('#funcionario').val("<?=$id_usuario?>").change();
		}
		
		mudarFuncionarioModal()
		
		$('.sel3').select2({
			dropdownParent: $('#modalForm')
		});
		$('.sel200').select2({
			//dropdownParent: $('#modalForm')
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2').select2({
			
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		
		$('.sel4').select2({
			dropdownParent: $('#modalServico')
		});
	});
</script>
<script>
	$("#form-text").submit(function () {
		$('#mensagem').text('Carregando...');
		$('#btn_salvar').hide();
		event.preventDefault();
		
		var formData = new FormData(this);
		$.ajax({
			url: 'paginas/' + pag +  "/inserir.php",
			type: 'POST',
			data: formData,
			success: function (mensagem) {
				
				$('#mensagem').text('');
				$('#mensagem').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {                    
					$('#btn-fechar').click();
					$('#pago_editar').val('');
					listar();
					listarHorarios();
					sucesso();
				} else {
					$('#mensagem').addClass('text-danger')
					$('#mensagem').text(mensagem)
				}
				$('#btn_salvar').show();
			},
			cache: false,
			contentType: false,
			processData: false,
		});
	});
</script>
<script type="text/javascript">
	function listar(){
		var funcionario = $('#funcionario_modal').val();
		var tabela = $("#table").val();	
	
		var data = $("#data_agenda").val();	
		$("#data-modal").val(data);
		$.ajax({
			url: 'paginas/' + pag + "/listar.php",
			method: 'POST',
			data: {data, funcionario, tabela},
			dataType: "text",
			success:function(result){
				$("#listar").html(result);
			}
		});
		if(tabela != 'horarios'){
			return;
		}
		if(funcionario == ""){
			alert("Selecione um Funcionário");
			return;
		}
	setTimeout(() => {
		$.ajax({
        url: 'paginas/' + pag + "/listar_horarios_vagos.php",
        method: 'POST',
        data: {funcionario, data},
        dataType: "html",
        success:function(result){
        	//alert(result)
            $("#listar_horarios_disp").html(result);           
        }
    });
  
	}, "200");
	
	
	}
</script>
<script type="text/javascript">
	
	function limparCampos(){
		$('#id').val('');		
		$('#obs').val('');
		$('#hora').val('');				
		$('#data').val('<?=$data_atual?>');	
	}
</script>
<script type="text/javascript">
	function atualizarCalendario(){
		//atualizar calendario
		
		$('#mycalendar').empty()
		$('#mycalendar').monthly({
			mode: 'event',
		});
	}
	
	function mudarFuncionario(){		
		
		var funcionario = $('#funcionario').val();
		$('#id_funcionario').val(funcionario);	
		$('#funcionario_modal').val(funcionario).change();
		listar();	
		listarHorarios();
		listarServicos(funcionario);
		
	}
</script>
<script type="text/javascript">
	
	function mudarFuncionarioModal(){	
		var func = $('#funcionario_modal').val();	
		listar();	
		listarHorarios();
		listarServicos(func);
	}
</script>
<script type="text/javascript">
	
	function mudarData(){
		var data = $('#data-modal').val();			
		$('#data_agenda').val(data).change();
		listar();	
		listarHorarios();
	}
</script>
<script type="text/javascript">
	function listarHorarios(hora){
		var funcionario = $('#funcionario_modal').val();		
		var data = $('#data_agenda').val();	
		$.ajax({
			url: 'paginas/' + pag + "/listar-horarios.php",
			method: 'POST',
			data: {funcionario, data, hora},
			dataType: "html",
			success:function(result){
				
				$("#listar-horarios").html(result);
			}
		});
	}
</script>
<script>
	$("#form-servico").submit(function () {
		event.preventDefault();
		
		var formData = new FormData(this);
		var convenio = $('#convenio').val();
		var pgto = $('#pgto').val();
		if(pgto == "Convênio" && convenio == ""){
			alert("Selecione um Convênio ou uma forma de pagamento");
			return;
		}
		$.ajax({
			url: 'paginas/' + pag +  "/inserir-servico.php",
			type: 'POST',
			data: formData,
			success: function (mensagem) {
				$('#mensagem-servico').text('');
				$('#mensagem-servico').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {                    
					$('#btn-fechar-servico').click();
					listar();
				} else {
					$('#mensagem-servico').addClass('text-danger')
					$('#mensagem-servico').text(mensagem)
				}
			},
			cache: false,
			contentType: false,
			processData: false,
		});
	});
</script>
<script type="text/javascript">
	function listarServicos(func){	
		var serv = $("#servico").val();
		
		$.ajax({
			url: 'paginas/' + pag +  "/listar-servicos.php",
			method: 'POST',
			data: {func},
			dataType: "text",
			success:function(result){
				$("#servico").html(result);
			}
		});
	}
	function calcularValor(){
		var convenio = $("#convenio").val();
		var id_agd = $("#id_agd").val();
		$.ajax({
			url: 'paginas/' + pag +  "/calcular.php",
			method: 'POST',
			data: {id_agd, convenio},
			dataType: "text",
			success:function(result){				
				$("#valor_serv_agd").val(result);
			}
		});
	}
</script>
<script>
	$("#form-pacientes").submit(function () {
		$('#mensagem_pacientes').text('Carregando...');
		$('#btn_salvar_pacientes').hide();
		event.preventDefault();
		
		var formData = new FormData(this);
		$.ajax({
			url: 'paginas/clientes/salvar.php',
			type: 'POST',
			data: formData,
			success: function (mensagem) {
				
								
				$('#mensagem_pacientes').text('');
				$('#mensagem_pacientes').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {                    
					$('#btn-fechar-pacientes').click();
					//listar();			
					sucesso();	
					$('#modalForm').modal('show');	
                	listarPacientes('1');

				} else {
					$('#mensagem_pacientes').addClass('text-danger')
					$('#mensagem_pacientes').text(mensagem)
				}
				$('#btn_salvar_pacientes').show();
			},
			cache: false,
			contentType: false,
			processData: false,
		});
	});
</script>
<script type="text/javascript">
	function listarPacientes(valor){
	$.ajax({
        url: 'paginas/' + pag + "/listar_pacientes.php",
        method: 'POST',
        data: {valor},
        dataType: "html",
        success:function(result){
            $("#listar_pacientes").html(result);           
        }
    });
}
function abrirModal(hora){
	listarHorarios(hora);
	inserir();
}
</script>

<script type="text/javascript">
	function mudarPessoa() {
		var pessoa = $('#tipo_pessoa').val();
		if (pessoa == 'Física') {
			$('#cpf').mask('000.000.000-00');
			$('#cpf').attr("placeholder", "Insira CPF");
		} else {
			$('#cpf').mask('00.000.000/0000-00');
			$('#cpf').attr("placeholder", "Insira CNPJ");
		}
	}
</script>


<script>

	function limpa_formulário_cep() {
		//Limpa valores do formulário de cep.
		document.getElementById('endereco').value = ("");
		document.getElementById('bairro').value = ("");
		document.getElementById('cidade').value = ("");
		document.getElementById('estado').value = ("");
		//document.getElementById('ibge').value=("");
	}

	function meu_callback(conteudo) {
		if (!("erro" in conteudo)) {
			//Atualiza os campos com os valores.
			document.getElementById('endereco').value = (conteudo.logradouro);
			document.getElementById('bairro').value = (conteudo.bairro);
			document.getElementById('cidade').value = (conteudo.localidade);
			document.getElementById('estado').value = (conteudo.uf);
			//document.getElementById('ibge').value=(conteudo.ibge);
		} //end if.
		else {
			//CEP não Encontrado.
			limpa_formulário_cep();
			alert("CEP não encontrado.");
		}
	}

	function pesquisacep(valor) {

		//Nova variável "cep" somente com dígitos.
		var cep = valor.replace(/\D/g, '');

		//Verifica se campo cep possui valor informado.
		if (cep != "") {

			//Expressão regular para validar o CEP.
			var validacep = /^[0-9]{8}$/;

			//Valida o formato do CEP.
			if (validacep.test(cep)) {

				//Preenche os campos com "..." enquanto consulta webservice.
				document.getElementById('endereco').value = "...";
				document.getElementById('bairro').value = "...";
				document.getElementById('cidade').value = "...";
				document.getElementById('estado').value = "...";
				//document.getElementById('ibge').value="...";

				//Cria um elemento javascript.
				var script = document.createElement('script');

				//Sincroniza com o callback.
				script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

				//Insere script no documento e carrega o conteúdo.
				document.body.appendChild(script);

			} //end if.
			else {
				//cep é inválido.
				limpa_formulário_cep();
				alert("Formato de CEP inválido.");
			}
		} //end if.
		else {
			//cep sem valor, limpa formulário.
			limpa_formulário_cep();
		}
	};

</script>



<script>
	function buscarCNPJ() {

		var cnpj = $('#cpf').val().replace(/\D/g, ''); // Remover tudo que não for número
		if (cnpj.length === 14) { // Verifica se o CNPJ tem 14 dígitos
			$.ajax({
				url: 'https://www.receitaws.com.br/v1/cnpj/' + cnpj,
				type: 'GET',
				dataType: 'jsonp', // A API retorna um JSONP para evitar CORS
				success: function (dados) {
					if (dados.status === "ERROR") {
						alert("CNPJ inválido ou não encontrado!");
					} else {
						$('#nome').val(dados.nome);
						//$('#atividade_principal').html("Atividade Principal: " + dados.atividade_principal[0].text);
						$('#cep').val(dados.cep);
						$('#telefone').val(dados.telefone);
						$('#email').val(dados.email);
						$('#endereco').val(dados.logradouro);
						$('#bairro').val(dados.bairro);
						$('#numero').val(dados.numero);
						$('#cidade').val(dados.municipio);
						$('#complemento').val(dados.complemento);
						$('#estado').val(dados.uf);
					}
				},
				error: function () {
					alert("Erro ao buscar os dados do CNPJ.");
				}
			});
		} else {
			alert("Por favor, insira um CNPJ válido com 14 dígitos.");
		}
	}
</script>