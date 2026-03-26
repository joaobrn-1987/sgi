<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<?php

//echo $date = date('Y-m-d H:i:s');

$data = date("d-m-y");

$hora = date("H:i:s"); ?>

<style type="text/css">
	.tamanho0 {
		display: none
	}
	.diametro0 {
		display: block
	}

	.volume0 {
		display: none
	}

	.peso0 {
		display: none
	}
	.dimensoes0 {
		display: none
	}

	.tamanhoe {
		display: none
	}

	.volumee {
		display: none
	}

	.pesoe {
		display: none
	}

	.dimensoese {
		display: none
	}

	.livree {
		display: none
	}

	.entradaRelatorio {
		display: block
	}

	.saidaRelatorio {
		display: none
	}

	.entradaRelatorioTAB {
		display: block
	}

	.saidaRelatorioTAB {
		display: none
	}
	table.comBordas {
		border: 0px solid White;
	}

	table.comBordas td {
		border: 1px solid grey;
	}
	.infoEstoque{
		width: 700px;
		padding: 20px;
		background-color: white;
		border: 1px #cecece solid;
	}
</style>
<style type="text/css">
	.switch {
		position: relative;
		display: inline-block;
		width: 40px;
		height: 20px;
	}

	/* Hide default HTML checkbox */
	.switch input {
		opacity: 0;
		width: 0;
		height: 0;
	}

	/* The slider */
	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 12px;
		width: 12px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .slider {
		background-color: #51a351;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px #51a351;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(20px);
		-ms-transform: translateX(20px);
		transform: translateX(20px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}
</style>
<div class="row-fluid">
	<form action="<?php echo base_url(); ?>index.php/os/redirectDistribuirOs" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
		<div class="span12">
			<div class="span1" class="control-group">
				<input type="text" id="idOs" name="idOs" class="span12" placeholder="Informe a O.S." />
				<input type="hidden" id="idOsAtual" name="idOsAtual" class="span12" value="<?php echo $result->idOs; ?>" />
			</div>
			<div class="span1" class="control-group">
				<button class="btn btn-success" class="span12">Buscar</button>
			</div>
		</div>
	</form>
</div>


<div class="row-fluid" style="margin-top:0">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-content nopadding">
				<div class="span12" id="divProdutosServicos" style=" margin-left: 0;background-color: #f9f9f9;">
					<div class="container-fluid" style="margin-top: 20px;">
						<table class='comBordas' width='36%' align='left'>
							<tr>
								<td align='center'>
									O.S. Número: <font size='5'><?php echo $result->idOs ?></font>
								</td>
								<td align='center'>
									Data:<?php echo date('d/m/Y',  strtotime($result->data_abertura)) ?></b></td>
								<td align='center'>
									Unid. Exec.: <?php foreach($unid_exec as $r){if($r->id_unid_exec==$result->unid_execucao){ echo $r->status_execucao;}} ?></b></td>
								<td align='center'>
									Cronômetro <span id="hour"></span>:<span id="minute"></span>:<span id="second"></span></td>
									
								</table>	
									
							<!--------------------------------------------------------------------------------------------------------------------->			
									
								
								
								<table>
								<form action="<?php echo base_url() ?>index.php/os/planejadoPCP" id="planejadoPCP" method="post"  > 							
									<td align='center'>
										<li class="active vertical-center" id="">									
									
											<span> <strong>    OS PLANEJADA: </strong> </span> 
											<input style="width:60px" type="checkbox" name="planejadoPCP" class='check span12' value="1" title="Marque esta opção se OS foi planejada" />
											 
													<?php if($result->planejadoPCP == 1) { echo 'checked'; } else { echo ''; } ?>  
													 <?php //echo $result->planejadoPCP; ?>
											
													     <input type="text" name="idOs" value="<?php echo $result->idOs ?>" />
														 <input type="text" name="idStatusOs" value="<?php echo $result->idStatusOs ?>" />
														 <input type="text" name="idOrcamento_item" value="<?php echo $result->idOrcamento_item ?>" />
														 <input type="text" name="idOrcamentos" value="<?php echo $result->idOrcamentos ?>" />
														  <input type="text" name="unidade_execucao" value="<?php echo $result->unid_execucao ?>" />
														   <input type="text" name="unid_faturamento" value="<?php echo $result->unid_faturamento ?>" />
														   <input type="text" name="contrato" value="<?php echo $result->contrato ?>" />
														    <input type="text" name="val_unit_os" value="<?php echo $result->val_unit_os ?>" />
															<input type="text" name="desconto_os" value="<?php echo $result->desconto_os ?>" />
															<input type="text" name="qtd_os" value="<?php echo $result->qtd_os ?>" />
															<input type="text" name="subtot_os" value="<?php echo $result->subtot_os ?>" />
															<input type="text" name="exported_queryfactory_at" value="<?php echo $result->exported_queryfactory_at ?>" />
															

													<div class="span1" class="control-group">
												
														<button type="submit"  class="btn btn-success"><i class="icon-plus icon-white"></i> Salvar</button>
													</div>
										</li>	
									</td>
								</form> 			
								</table>
							</tr>
						
					
						
						

						<!--------------------------------------------------------------------------------------------------------------------->
						<div class="row-fluid">
							<div class="span12">

								<div class="widget-box">

									<div class="widget-content nopadding">

										<table width='100%' border='0' style="border-style:solid; border: 1px solid grey;
											font-family:Arial, Helvetica, sans-serif;
											font-size:12px;">
											<tr>
												<td align='center'>
													<table width='100%' border='0' style="font-family:Arial, Helvetica, sans-serif;
														font-size:12px;   line-height: 20px;">


														<tr>
															<td align='left'>Descrição:</td>
															<td style="width: 50%"><?php echo $itens_orcamento->descricao_item; ?></td>
															<td align='left'>Cliente:</td>
															<td ><?php echo $orcamento->nomeCliente; ?></td>
														</tr>

														<tr>
															<td align='left' width='13%'> Qtd.: </td>
															<td><?php echo $result->qtd_os; ?></td>
															<td align='left' width='13%'>Orçamento: </td>
															<td><?php echo $result->idOrcamentos; ?></td>

														</tr>
														<tr>
															<td align='left'><h5>PN (MASTER):</h5></td>
															<td><h5><?php echo $itens_orcamento->pn; ?><h5></td>
															<?php if(!empty($result->data_reagendada)){ ?>
																<td align='left'>Data Reagendada:</td>
																<td colspan='3'><?php if ($result->data_reagendada <> '') {
																	echo date("d/m/Y", strtotime($result->data_reagendada));
																} ?></td>
															<?php }else{ ?>
																<td align='left'>Data Reagendada:</td>
																<td colspan='3'><?php echo date("d/m/Y", strtotime($result->data_entrega));  ?></td>
															<?php } ?>
														
														
											</tr>
										</table>
										</td>
										</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div >
						<div >
							<!--
							<div class="span12 well" style="padding: 1%; margin-left: 0">
								<div class="span2" class="control-group">
									<label for="item" class="control-label">Cod. OS: <?php echo $result->idOs; ?></label>
								</div>
								<div class="span3" class="control-group">
									<label for="item" class="control-label">Cliente: <?php echo $orcamento->nomeCliente; ?></label>
								</div>
								<div class="span3" class="control-group">
									<label for="item" class="control-label">Orçamento: <?php echo $result->idOrcamentos; ?></label>
								</div>
								<div class="span3" class="control-group">
									<label for="item" class="control-label">Data O.S.:
										<?php echo date("d/m/Y", strtotime($result->data_abertura));  ?>
								</div>

							</div>

							<div class="span12 well" style="padding: 1%; margin-left: 0">
								<div class="span1" class="control-group">
									<label for="item" class="control-label">Qtd.:</label>
									<?php echo $result->qtd_os; ?>

								</div>
								<div class="span6" class="control-group">
									<label for="item" class="control-label">Descrição:</label>
									<input id="descricao_os" class="span12" type="text" onclick="this.select();" name="descricao_os" value="<?php echo $itens_orcamento->descricao_item; ?>" />
								</div>
								<div class="span1" class="control-group">
									<label for="item" class="control-label">PN:</label>
									<?php echo $itens_orcamento->pn; ?>
								</div>
								<div class="span2" class="control-group">
									<label for="item" class="control-label">Data Entrega:</label>

									<input id="data_entrega" class="span12 data" type="text" name="data_entrega" value="<?php echo date("d/m/Y", strtotime($result->data_entrega));  ?>" onclick="this.select();" />
								</div>
								<div class="span2" class="control-group">
									<label for="item" class="control-label">Data Reprog.:</label>
									<input id="data_reagendada" class="span12 data" onclick="this.select();" type="text" name="data_reagendada" value="<?php if ($result->data_reagendada <> '') {
																																							echo date("d/m/Y", strtotime($result->data_reagendada));
																																						} ?>" />
								</div>

							</div> -->
							<form id="formExibicao" class="form-inline" action="<?php echo base_url() ?>index.php/os/distribuiros/<?php echo $result->idOs ?>" method="post">

								<div class="span12 well" style="padding: 1%; margin-left: 0">
									<div class="span2" class="control-group">
										<label for="item" class="control-label">Exibir:</label>
										<select class="recebe-solici" class="controls" style="font-size: 10px; width:62%" name="exibirLista" id="exibirLista">
											<option value="1">
												TODOS
											</option>
											<option value="150">
												150
											</option>
										</select>
									</div>
									<div class="span2" class="control-group">
										<label for="item" class="control-label">Status:</label>
										<select class="recebe-solici" class="controls" style="font-size: 10px; width:62%" name="statusCompra" id="statusCompra">
											<option value="">
											</option>
											<?php foreach ($dados_statuscompra as $r) {
												echo '<option value="' . $r->idStatuscompras . '">' . $r->nomeStatus . '</option> ';
											} ?>



										</select>
									</div>
									<div class="span2" class="control-group">
										<br>
										<input class="btn btn-default" type="submit" name="filter" value="Filtrar">
									</div>

								</div>
							</form>
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab1" data-toggle="tab">Sub OS</a></li>
								<li><a href="#tab7" data-toggle="tab">Suprimentos</a></li>
								<li><a href="#tab2" data-toggle="tab">Almoxarifado</a></li>
							</ul>
							
								<!--
							<div class="widget-box">
								<div class="widget-title">
									<span class="icon">
										<i class="icon-user"></i>
									</span>
									<h5>Cadastrar Material</h5>
									<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs') && $result->fechadoPCP == 0) { ?>
											<?php echo 'não exibir 363'; ?>

									<?php } ?>
								</div>

								<div class="widget-content nopadding">


									<table class="table table-bordered ">
										<thead>
											<tr>

												<th>ID</th>

												<th>Qtd.</th>
												<th>Material&nbsp;&nbsp;&nbsp;<a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/produtos.descricao-asc"; ?>'><i class="icon-arrow-up"></i></a>&nbsp; <a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/produtos.descricao-desc"; ?>'><i class="icon-arrow-down"></i></a></th>

												<th>Dimensões</th>
												<th>Grupo&nbsp;&nbsp;&nbsp;<a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/status_grupo_compra.nomegrupo-asc"; ?>'><i class="icon-arrow-up"></i></a>&nbsp; <a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/status_grupo_compra.nomegrupo-desc"; ?>'><i class="icon-arrow-down"></i></a></th>
												<th>PN</th>

												<th>OBS</th>
												<th>N° NF</th>
												<th>Previsão Entrega</th>
												<th>Data cad. Item &nbsp;&nbsp;&nbsp;<a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/distribuir_os.data_cadastro-asc"; ?>'><i class="icon-arrow-up"></i></a>&nbsp; <a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/distribuir_os.data_cadastro-desc"; ?>'><i class="icon-arrow-down"></i></a></th>
												<th>Data Alt. Item&nbsp;&nbsp;&nbsp;<a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/distribuir_os.data_alteracao-asc"; ?>'><i class="icon-arrow-up"></i></a>&nbsp; <a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/distribuir_os.distribuir_os.data_alteracao-desc"; ?>'><i class="icon-arrow-down"></i></a></th>
												<th>User&nbsp;&nbsp;&nbsp;<a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/usuarios.nome-asc"; ?>'><i class="icon-arrow-up"></i></a>&nbsp; <a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/usuarios.nome-desc"; ?>'><i class="icon-arrow-down"></i></a>

												</th>
												<th>Status&nbsp;&nbsp;&nbsp;<a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/statuscompras.nomeStatus-asc"; ?>'><i class="icon-arrow-up"></i></a>&nbsp; <a href=' <?php echo base_url() . "index.php/os/distribuiros/" . $result->idOs . "/statuscompras.nomeStatus-desc"; ?>'><i class="icon-arrow-down"></i></a></th>

												<th></th>
												<th></th>
											</tr>
										</thead>
										<tbody style="font-size: 12px;">



											<?php
											foreach ($distribuir_os as $dist) {

												if ($dist->data_alteracao <> '') {
													$data_alteracao = date("d/m/Y H:i:s", strtotime($dist->data_alteracao));
												} else {
													$data_alteracao = "";
												}
												if ($dist->idStatuscompras == 6) {
													$color = "#ff0000";
												} else {
													$color = "#000000";
												}
												?>

												<tr>
													<td>
														 
															<?php echo $dist->idDistribuir; ?>
													</td>
													

													<td>
														
															<?php echo $dist->quantidade; ?>
													</td>
												
													<td>
														
															<?php echo $dist->descricaoInsumo; ?>
													</td>
												
													<td>
														
															<?php
															if (!empty($dist->dimensoes)) {
																echo $dist->dimensoes;
															}
															if (!empty($dist->comprimento)) {
																echo $dist->comprimento . " mm";
															}
															if (!empty($dist->volume)) {
																echo $dist->volume . " ml";
															}
															if (!empty($dist->peso)) {
																echo $dist->peso . " g";
															}
															$html = "";
															if (!empty($dist->dimensoesL)) {
																$html .= " L: " . $dist->dimensoesL . " mm |";
															}
															if (!empty($dist->dimensoesC)) {
																$html .= " C: " . $dist->dimensoesC . " mm |";
															}
															if (!empty($dist->dimensoesA)) {
																$html .= " A: " . $dist->dimensoesA . " mm";
															}
															echo $html; ?>
													</td>
													
													<td>
														
															<?php echo $dist->nomegrupo; ?>
													</td>
													
													<td>
														
															<?php echo $dist->pn; ?> - <?php echo $dist->descricao; ?>
													</td>
												

													<td>
														
															<?php echo $dist->obs; ?>
													</td>
												
													<td>
														
															<?php echo $dist->notafiscal; ?>
													</td>
												
													<td>
														
															<?php
															if (!empty($dist->previsao_entrega)) {
																echo date("d/m/Y", strtotime($dist->previsao_entrega));
															} ?>
													</td>
												
													<td>
														
															<?php echo date("d/m/Y H:i:s", strtotime($dist->datacadastro));  ?>

													</td>
												
													<td>
														
															<?php echo $data_alteracao; ?>
													</td>
												
													<td>
														
															<?php echo $dist->nome; ?>
													</td>
												
													<td>
														
															<?php echo $dist->nomeStatus; ?>
													</td>
												




													<?php
													if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
														if ($dist->idStatuscompras == 1 || $dist->idStatuscompras == 2) {
													?>
															<td>
																<a href="#modalAlterarpedido<?php echo $dist->idDistribuir; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top">
																	<font size='1'>Editar</font>
																</a>

															</td>
															<td>

																<a href="#modal-excluirmaterial<?php echo $dist->idDistribuir; ?>" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuir="<?php echo $dist->idDistribuir; ?>" class="btn btn-danger tip-top">
																	<font size='1'>Excluir</font>
																</a>
															</td>
														<?php
														} elseif ($dist->liberado_edit_compras == 1) {
														?>

															<td>
																<a href="#modalAlterarpedido<?php echo $dist->idDistribuir; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>

															</td>
															<td>

																<a href="#modal-cancelarmaterial<?php echo $dist->idDistribuir; ?>" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuircancelar="<?php echo $dist->idDistribuir; ?>" class="btn btn-danger tip-top">
																	<font size='1'>Cancelar</font>
																</a>
															</td>

														<?php
														}
														?>


												</tr>
											<?php
													}


											?>
											
										<?php


											}
										?>


										</tbody>
									</table>
								</div>
							</div> -->
							<div class="tab-content" onmousemove="scrollDetect(this,event)">
								<div class="tab-pane active" id="tab1">
									<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs') && $result->fechadoPCP == 0) { ?> <?php echo 'não exibir 572'; ?>
										<div align='center' style="margin-top: 15px;"><!--
											<a href="#modalinserir" data-toggle="modal" role="button" class="btn btn-warning"><i class="icon-plus icon-white"></i> Cadastrar Materiais OS</a>-->
											<!--
											<a href="#modalCriarSubOs" data-toggle="modal" role="button" class="btn btn-warning"><i class="icon-plus icon-white"></i> Criar Sub O.S.</a>
											<a href="#modalFinalizar" data-toggle="modal" role="button" class="btn btn-success"><i class="icon-plus icon-white"></i> Finalizar</a>-->
										</div>
									<?php } ?>
									<div class="widget-box">
										<div class="widget-title">
											<span class="icon">
												<i class="icon-tags"></i>
											</span>
											<h5>Sub O.S.</h5>
										</div>
										<div class="widget-content nopadding">
											<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
												<div class="span12" id="divCadastrarOs">                                
													<div class="widget-box" style="margin-top:0px;margin-bottom:0px">                                        
														<table id="table_id" class="table table-bordered " id="dadosTlbOsOc" style="border-bottom: 1px solid #ddd;">
															<thead>
																<tr>
																	<th>Insumos</th>
																	<th>Sub O.S.</th>
																	<th>Tipo</th>
																	<th>PN</th>    
																	<th>Descrição</th>
																	<th>Qtd.</th>  
																	<th>Ø EXT</th> 
																	<th>Ø INT</th> 
																	<th>COMP</th> 
																	<th>OBS</th> 
																	<th>Item</br>Comercial</th>
																	<th>Des.</th> 
																	<th></th>                                            
																</tr>
															</thead>
															<tbody>
																<?php foreach($subOs as $a){
																	if($a->posicao == 0){
																		$getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoByIdOsSubAndPos0($a->idOsSub,$a->idOs);
																	}else{
																		$getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoByIdOsSub($a->idOsSub);
																	}
																	 
																	 $verifyAnexo = 0;
																	 $verifyAnexoAguardando = 0;
																	 $verifyAnexoPossui = 0;
																	 foreach($getAnexoOrcItem as $k){
																		 if($k->statusAnexo == 1){
																			 $verifyAnexoAguardando = 1;
																		 }
																		 if($k->statusAnexo == 2){
																			 $verifyAnexoPossui = 1;
																		 }
																	 }
																	 if($verifyAnexoAguardando ==1){
																		 $verifyAnexo = 1;
																	 }else if($verifyAnexoPossui ==1){
																		 $verifyAnexo = 2;
																	 } else if($verifyAnexo==0){
																		if(!empty($getAnexoOrcItem)){
																			if($result->statusDesenho == 3){
																				$verifyAnexo = 2;
																			}else{
																				$verifyAnexo = 1;
																			}
																		}
																	 }
																	echo '<tr class="trpai'.$a->idOsSub.'">';
																		if(count($a->distribuiros)>0 || count($a->sugestaoDistribuir)>0){
																			echo '<td onclick="openclose(this,'.$a->idOsSub.')" style="text-align: center;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';
																		}else{
																			echo '<td></td>';
																		}
																		
																		echo '<td style="text-align: center;">'.$result->idOs.'.'.$a->posicao.'</td>';
																		echo '<td>'.$a->nomeClasse.'</td>';
																		echo '<td>'.$a->pn.'</td>';
																		echo '<td>'.$a->descricaoOsSub.'</td>';
																		echo '<td>'.$a->quantidade.'</td>';
																		echo '<td>'.$a->dimenExt.'</td>';
																		echo '<td>'.$a->dimenInt.'</td>';
																		echo '<td>'.$a->dimenComp.'</td>';
																		echo '<td>'.$a->obs.'</td>';
																		if($a->item_comercial == 1){
																			echo '<td><input type="checkbox" class="span12" disabled checked></td>';
																		}else{
																			echo '<td><input type="checkbox" class="span12" disabled ></td>';
																		}
																		echo '<td style="text-align: center;">'.'<a href="#modal-imagem_'.$a->idOs.'_'.$a->idOsSub.'" role="button" data-toggle="modal" style="margin-right: 1%;width: 15px;height: 15px; padding-top: 8px;" class="btn tip-top" ><i class="'.($verifyAnexo == 1 ?"fas fa-exclamation-triangle":($verifyAnexo == 2 ?"icon-ok":"icon-ban-circle")).'" style="color:'.($verifyAnexo == 1 ?"orange":($verifyAnexo == 2 ?"green":"grey")).'"></i></a>'.
																			'<div id="modal-imagem_'.$a->idOs.'_'.$a->idOsSub.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
																				'<div class="modal-header">'.
																					'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
																					'<h5 id="myModalLabel">Desenho PN: '.$a->pn.' | Descrição: '.$a->descricaoOsSub.'</h5>'.
																				'</div>'.
																				'<div class="modal-body">';
																					if($getAnexoOrcItem){
																						echo '<div class="span12" style="margin-left:0px">'. 
																							'<div class="row-fluid" style="margin-top:0">'.
																								'<div class="span12">'.
																									'<div class="widget-box">'.
																										'<div class="widget-title">'.
																											'<span class="icon">'.
																												'<i class="icon-tags"></i>'.
																											'</span>'.
																											'<h5>Anexos </h5>'.
																										'</div>'.
																										'<div class="widget-content nopadding">'.
																											'<div class="span12" id="divProdutosServicos" style=" margin-left: 0">'.
																												'<div class="span12" id="divCadastrarOs">  '.                             
																													'<div class="widget-box" style="margin-top:0px">' .                                       
																														'<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">'.
																															'<thead>'.
																																'<tr>'.
																																	'<th>Arquivo</th>'.
																																	'<th>Status Desenho</th>'.
																																	'<th></th>'.
																																	'<th></th>' .            
																																'</tr>'.
																															'</thead>'.
																															'<tbody>';  
																																foreach($getAnexoOrcItem as $anex){
																																	echo '<tr>';
																																	echo '<td><a href="' . base_url() .  $anex->caminho . $anex->imagem . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>
																																	<a href=' . base_url() . $anex->caminho . $anex->imagem . ' target="_blank">' . $anex->nomeArquivo . $anex->extensao . '</a></td>'.
																																		'<td>' . ($anex->statusAnexo == 1 ? 'Aguardando Verificação' : ($anex->statusAnexo == 2 ? 'Aprovado' : 'Rejeitado')) . '</td>'.
																																		'<td></td>'.
																																		'<td></td>';
																																	echo '</tr>';
																																}                                                                                
																															echo '</tbody>'.
																														'</table>'.
																													'</div>'.                               
																												'</div>'.
																											'</div>'.
																										'</div>'.
																									'</div>'.
																								'</div>'.    
																							'</div>'. 
																						'</div>';
																					}                                                                                                                                                                                           
																				echo '</div>'.
																			'</div>'. 
																		'</td>';
																		
																		echo '<td>';
																		//if($result->statusDesenho == 3){
																			if (($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs') && $result->fechadoPCP == 1 && $result->planejadoPCP == 0)||$result->idOs == 1||$result->idOs == 2||$result->idOs == 3||$result->idOs == 6) {
																				echo '<font size="1"><a "href="#modalinserir" onclick="abrirModalInserir('.$a->idOsSub.','.$a->posicao.')" data-toggle="modal" role="button" style="margin-right: 1%;padding: 5px;" class="btn btn-info tip-top" ><i class="icon-shopping-cart"></i></a></font>';
																			}
																			if (($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs') && $result->fechadoPCP == 1 && $result->planejadoPCP == 1)||$result->idOs == 1||$result->idOs == 2||$result->idOs == 3||$result->idOs == 6) {
																				echo '';
																			}																			
																		//}
																			
																		echo '</td>';
																	echo '</tr>';
																	
																	
																	echo '<tr class="trfilho'.$a->idOsSub.'" style="display:none">';
																		echo '<td colspan=13 style="background-color: #efefef;padding-top: 0px;">';
																		if(count($a->distribuiros)>0){
																			echo '<div style="margin: 20px;margin-top: 0px;">';
																				echo '<table class="table table-bordered ">';
																					echo '<thead>';
																					echo '<tr>';
																						echo '<th colspan=16>Materiais Cadastrados</th>';
																					echo '</tr>';
																					echo '<tr>';
																						echo '<th>ID</th>';
																						echo '<th>Cod. Forn.</th>';
																						echo '<th>Qtd.</th>';
																						echo '<th>Material</th>';
																						echo '<th>Dimensões</th>';
																						echo '<th>Grupo</th>';
																						echo '<th>PN</th>';
																						echo '<th>OBS</th>';
																						echo '<th>Nº NF</th>';
																						echo '<th>Previsão Entrega</th>';
																						echo '<th>Data cad. Item</th>';
																						echo '<th>Data Alt. item</th>';
																						echo '<th>User</th>';
																						echo '<th>Status</th>';
																						echo '<th></th>';
																						echo '<th></th>';
																					echo '</tr>';
																						
																					echo '</thead>';
																					echo '<tbody>';
																						foreach($a->distribuiros as $d){
																							echo '<tr>';
																								echo '<td style="text-align: center;">'.$d->idDistribuir.'</td>';
																								echo '<td>'.$d->cod_fornecedor.'</td>';                               
																								echo '<td>'.$d->quantidade.'</td>';                                                                                                                                                     
																								echo '<td>'.$d->descricaoInsumo.'</td>';
																								$html = "";
																								if (!empty($d->dimensoes)) {
																									$html.= $d->dimensoes;
																								}
																								if (!empty($d->comprimento)) {
																									$html.=  $d->comprimento . " mm";
																								}
																								if (!empty($d->volume)) {
																									$html.=  $d->volume . " ml";
																								}
																								if (!empty($d->peso)) {
																									$html.=  $d->peso . " g";
																								}
																								if (!empty($d->dimensoesL)) {
																									$html .= " Largura: " . $d->dimensoesL . " mm";
																								}
																								if (!empty($d->dimensoesC)) {
																									$html .= " Comp.: " . $d->dimensoesC . " mm";
																								}
																								if (!empty($d->dimensoesA)) {
																									$html .= " Altura: " . $d->dimensoesA . " mm";
																								}
																								echo '<td>'.$html.'</td>';
																								echo '<td>'.$d->nomegrupo.'</td>';
																								echo '<td>'.$d->pn.' - '.$d->descricao.'</td>';
																								echo '<td>'.$d->obs.'</td>';
																								echo '<td>'.$d->notafiscal.'</td>';
																								$dataEntrega = "";
																								if (!empty($d->previsao_entrega)) {
																									$dataEntrega = date("d/m/Y", strtotime($d->previsao_entrega));
																								}
																								echo '<td>'.$dataEntrega.'</td>';
																								$dataCadastro = date("d/m/Y", strtotime($d->datacadastro));
																								echo '<td>'.$dataCadastro.'</td>';
																								if ($d->data_alteracao <> '') {
																									$data_alteracao = date("d/m/Y H:i:s", strtotime($d->data_alteracao));
																								} else {
																									$data_alteracao = "";
																								}
																								echo '<td>'.$data_alteracao.'</td>';
																								echo '<td>'.$d->nome.'</td>';
																								echo '<td>'.$d->nomeStatus.'</td>';
																								if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
																									if ($d->idStatuscompras == 1 || $d->idStatuscompras == 2) {
																									?>
																										<td>
																											<a href="#modalAlterarpedido<?php echo $d->idDistribuir; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top">
																												<font size='1'>Editar</font>
																											</a>
											
																										</td>
																										<td>
											
																											<a href="#modal-excluirmaterial<?php echo $d->idDistribuir; ?>" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuir="<?php echo $d->idDistribuir; ?>" class="btn btn-danger tip-top">
																												<font size='1'>Excluir</font>
																											</a>
																										</td>
																									<?php
																									} else if ($d->liberado_edit_compras == 1) {
																									?>
											
																										<td>
																											<a href="#modalAlterarpedido<?php echo $d->idDistribuir; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>
											
																										</td>
																										<td>
											
																											<a href="#modal-cancelarmaterial<?php echo $d->idDistribuir; ?>" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuircancelar="<?php echo $d->idDistribuir; ?>" class="btn btn-danger tip-top">
																												<font size='1'>Cancelar</font>
																											</a>
																										</td>
											
																									<?php
																									}else{
																										echo '<td></td>';
																										echo '<td></td>';
																									}
																										?>
												
												
																								</tr>
																								<?php
																								}else{
																									echo '<td></td>';
																									echo '<td></td>';
																								}
																								/*
																								echo '<td></td>';
																								echo '<td></td>';*/
																							echo '</tr>';
																						}									
																					echo '</tbody>';
																				echo '</table>';
																			echo '</div>';
																		}
																		if(count($a->sugestaoDistribuir)>0){
																			echo '<div style="margin: 20px;margin-top: 0px;">';
																				echo '<table class="table table-bordered ">';
																					echo '<thead>';
																						echo '<tr>';
																							echo '<th colspan=6>Materiais Sugeridos</th>';
																						echo '</tr>';
																						echo '<tr>';
																							echo '<th></th>';
																							echo '<th>Descrição</th>';
																							echo '<th>Dimensões</th>';
																							echo '<th>Qtd.</th>';
																							echo '<th>Grupo</th>';
																							echo '<th>OBS</th>';
																							//echo '<th></th>';
																							//echo '<th></th>';
																						echo '</tr>';																						
																					echo '</thead>';
																					echo '<tbody>';
																						foreach($a->sugestaoDistribuir as $d){
																							echo '<tr>';
																								echo '<td> <input type="checkbox" id="check_'.$d->idOsSub.'" value="'.$d->idDistribuirSugestao.'" name="idDistribuir_[]"></td>';
																								echo '<td>'.$d->descricaoInsumo.'</td>';
																								$html = "";
																								if (!empty($d->dimensoes)) {
																									$html.= $d->dimensoes;
																								}
																								if (!empty($d->comprimento)) {
																									$html.=  $d->comprimento . " mm";
																								}
																								if (!empty($d->volume)) {
																									$html.=  $d->volume . " ml";
																								}
																								if (!empty($d->peso)) {
																									$html.=  $d->peso . " g";
																								}
																								if (!empty($d->dimensoesL)) {
																									$html .= " L: " . $d->dimensoesL . " mm |";
																								}
																								if (!empty($d->dimensoesC)) {
																									$html .= " C: " . $d->dimensoesC . " mm |";
																								}
																								if (!empty($d->dimensoesA)) {
																									$html .= " A: " . $d->dimensoesA . " mm |";
																								}
																								echo '<td>'.$html.'</td>';
																								echo '<td>'.$d->quantidade.'</td>';
																								echo '<td>'.$d->nomegrupo.'</td>';
																								echo '<td>'.$d->obs.'</td>';
																								//echo '<td style="text-align:center"><a onclick="adicionarMaterial('.$d->idDistribuirSugestao.',this)" class="btn btn-success"><i class="icon icon-white"></i> Adicionar</a></td>';
																								//echo '<td style="text-align:center"><a onclick="rejeitarMaterial('.$d->idDistribuirSugestao.',this)" class="btn btn-danger"><i class="icon icon-white"></i> Rejeitar</a></td>';
																							echo '</tr>';
																						}		
																							echo '<tr>';
																								echo '<td colspan="6">';
																									echo '<a onclick="adicionarMaterial(\'check_'.$d->idOsSub.'\')" class="btn btn-success"><i class="icon icon-white"></i> Adicionar </a>';
																									echo '<a onclick="rejeitarMaterial(\'check_'.$d->idOsSub.'\')" class="btn btn-danger" style="margin-left:5px"><i class="icon icon-white"></i> Rejeitar </a>';
				
																								echo '</td>';

																							echo '</tr>';
																					echo '</tbody>';
																				echo '</table>';
																			echo '</div>';
																			echo '<div align="left" style="margin-top: 20px;">';
																			echo '</div>';
																		}
																		echo '</td>';
																	echo '</tr>';
																		
																	
																}
																	
																?>								
															</tbody>
														</table>
													</div>                                
												</div>
											</div>
										</div>
									</div>
									
									<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs') && $result->fechadoPCP == 0) { ?> <?php echo 'não exibir 942'; ?>
										<div align='center' style="margin-top: 20px;"><!--
											<a href="#modalinserir" data-toggle="modal" role="button" class="btn btn-warning"><i class="icon-plus icon-white"></i> Cadastrar Materiais OS</a>-->
											<!--
											<a href="#modalCriarSubOs" data-toggle="modal" role="button" class="btn btn-warning"><i class="icon-plus icon-white"></i> Criar Sub O.S.</a>
											<a href="#modalFinalizar" data-toggle="modal" role="button" class="btn btn-success"><i class="icon-plus icon-white"></i> Finalizar</a>-->
										</div>
									<?php } ?>
								</div>
								<div class="tab-pane" id="tab2">
									<ul class="nav nav-tabs" style="margin-top: 15px;">
										<li class="active"><a href="#tab3" data-toggle="tab">Reservados p/ O.S.</a></li>
										<li><a href="#tab4" data-toggle="tab">Entrada</a></li>
										<li><a href="#tab5" data-toggle="tab">Saída</a></li>
										<li><a href="#tab6" data-toggle="tab">Vale</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab3">
											<div class="row-fluid" style="margin-top:0">
												<div class="span12">
													<div class="widget-box">
														<div class="widget-title">
															<span class="icon">
																<i class="icon-tags"></i>
															</span>
															<h5></h5>
														</div>
														<div class="buttons" align='center' style="margin-top:15px">
															<a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
														</div>
														<div class="widget-content nopadding">
															<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
																<div class="span12" id="pcpItens">                                
																	<div class="widget-box" style="margin-top:0px">                                        
																		<table id="table_id" class="table table-bordered " id="dadosTlbOsOc" style="border-bottom: 1px solid #ddd;">
																			<thead>
																				<tr>
																					<th>Descrição</th>
																					<th>Quantidade</th>
																					<th>Empresa</th>
																					<th>Departamento</th>
																					<th>Local</th>       
																					<th></th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				foreach($almoxarifado_reservados as $r){
																					echo '<tr>';
																						echo '<td>'.$r->descricaoInsumo.'</td>';
																						echo '<td>'.$r->quantidade.'</td>';
																						echo '<td>'.$r->nome.'</td>';
																						echo '<td>'.$r->descricaoDepartamento.'</td>';
																						echo '<td>'.$r->local.'</td>';
																						echo '<td></td>';
																					echo '</tr>';
																				} ?>
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="tab4">
											<div class="row-fluid" style="margin-top:0">
												<div class="span12">
													<div class="widget-box">
														<div class="widget-title">
															<span class="icon">
																<i class="icon-tags"></i>
															</span>
															<h5></h5>
														</div>
														<div class="widget-content nopadding">
															<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
																<div class="span12" id="divCadastrarOs">                                
																	<div class="widget-box" style="margin-top:0px">                                        
																		<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
																			<thead>
																				<tr>
																					<th>Data</th>
																					<th>Descrição</th>
																					<th>Quantidade</th>
																					<th>Empresa</th>
																					<th>Departamento</th>
																					<th>Local</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php foreach($almoxarifado_entrada as $r){
																					$date = new DateTime( $r->data_entrada);
																					echo '<tr>';
																						echo '<td>'.$date-> format( 'd/m/Y' ).'</td>';
																						echo '<td>'.$r->descricaoInsumo.'</td>';
																						echo '<td>'.$r->quantidade.'</td>';
																						echo '<td>'.$r->nomeEmpresa.'</td>';                                            
																						echo '<td>'.$r->descricaoDepartamento.'</td>';
																						echo '<td>'.$r->local.'</td>';
																					echo '</tr> ';

																				} ?>                                                                                    
																			</tbody>
																		</table>
																	</div>                                
																</div>
															</div>
														</div>
													</div>
												</div>    
											</div>
										</div>
										<div class="tab-pane" id="tab5">
											<div class="row-fluid" style="margin-top:0">
												<div class="span12">
													<div class="widget-box">
														<div class="widget-title">
															<span class="icon">
																<i class="icon-tags"></i>
															</span>
															<h5></h5>
														</div>
														<div class="widget-content nopadding">
															<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
																<div class="span12" id="divCadastrarOs">                                
																	<div class="widget-box" style="margin-top:0px">                                        
																		<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
																			<thead>
																				<tr>
																					<th>Data</th>
																					<th>Descrição</th>
																					<th>Quantidade</th>                                                
																					<th>Empresa Orig.</th> 
																					<th>Departamento</th>                                          
																					<th>Empresa Dest.</th> 
																					<th>Retirado Por:</th> 
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																					foreach($almoxarifado_saida as $r){
																						$date = new DateTime( $r->data_saida);
																						echo '<tr>';
																							echo '<td>'.$date->format( 'd/m/Y' ).'</td>';
																							echo '<td>'.$r->descricaoInsumo.'</td>';
																							echo '<td>'.$r->quantidade.'</td>';
																							echo '<td>'.$r->nome.'</td>';                                            
																							echo '<td>'.$r->descricaoDepartamento.'</td>';
																							echo '<td>'.$r->destinoNome.'</td>';
																							echo '<td>'.$r->getUsernome.'</td>';
																						echo '</tr>';
																					}
																				?>
																				                                                                                     
																			</tbody>
																		</table>
																	</div>                                
																</div>
															</div>
														</div>
													</div>
												</div>    
											</div>
										</div>
										<div class="tab-pane" id="tab6">
											<div class="row-fluid" style="margin-top:0">
												<div class="span12">
													<div class="widget-box">
														<div class="widget-title">
															<span class="icon">
																<i class="icon-tags"></i>
															</span>
															<h5></h5>
														</div>
														<div class="widget-content nopadding">
															<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
																<div class="span12" id="divCadastrarOs">                                
																	<div class="widget-box" style="margin-top:0px">                                        
																		<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
																			<thead>
																				<tr>
																					<th>O.S. Orig</th>
																					<th>O.S. Dest</th>
																					<th>Descrição</th>
																					<th>Quantidade</th>                                                
																					<th>Data</th> 
																					<th>Usuário</th>
																				</tr>
																			</thead>
																			<tbody><?php
																				foreach($vale as $r){
																					$date = new DateTime( $r->data_insert);
																					if($r->idOsOrig == $result->idOs){
																						$color = "#ff00005c";
																						$font = "#700";
																					}else{
																						$color = "#00800070";
																						$font = "#013700";
																					}
																					echo '<tr style="color: '.$font.';background-color:'.$color.'">';
																						echo '<td>'.$r->idOsOrig.'</td>';
																						echo '<td>'.$r->idOsDest.'</td>';
																						echo '<td>'.$r->descricaoInsumo.'</td>';
																						echo '<td>'.$r->quantidade.'</td>';                                            
																						echo '<td>'.$date-> format( 'd/m/Y' ).'</td>';
																						echo '<td>'.$r->nome.'</td>';
																					echo '</tr>';

																				}?>                                                                                    
																			</tbody>
																		</table>
																	</div>                                
																</div>
															</div>
														</div>
													</div>
												</div>    
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab7">
									<div class="row-fluid" style="margin-top:0">
										<div class="span12">
											<div class="widget-box">
												<div class="widget-title">
													<span class="icon">
														<i class="icon-tags"></i>
													</span>
													<h5>Suprimentos</h5>
												</div>
												<div class="widget-content nopadding">
													<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
														<div class="tab-content">
															<div class="tab-pane active" id="tab1">
																<div class="span12" id="divCadastrarOs">                                
																	<div class="widget-box" style="margin-top:0px">                                        
																		<table id="tableHistVale" class="table table-bordered ">
																			<thead>
																				<?php
																					echo '<tr>';
																						echo '<th>ID</th>';
																						echo '<th>Cod. Forn.</th>';
																						echo '<th>Qtd.</th>';
																						echo '<th>Material</th>';
																						echo '<th>Dimensões</th>';
																						echo '<th>Grupo</th>';
																						echo '<th>PN</th>';
																						echo '<th>OBS</th>';
																						echo '<th>Nº NF</th>';
																						echo '<th>Previsão Entrega</th>';
																						echo '<th>Data cad. Item</th>';
																						echo '<th>Data Alt. item</th>';
																						echo '<th>User</th>';
																						echo '<th>Status</th>';
																						echo '<th></th>';
																						echo '<th></th>';
																					echo '</tr>';
																				?>
																			</thead>
																			<tbody>                                                    
																				<?php 
																				foreach($distribuir_os as $d){
																					echo '<tr>';
																						echo '<td style="text-align: center;">'.$d->idDistribuir.'</td>';
																						echo '<td>'.$d->cod_fornecedor.'</td>';                             
																						echo '<td>'.$d->quantidade.'</td>';                                                                                                                                                     
																						echo '<td>'.$d->descricaoInsumo.'</td>';
																						$html = "";
																						if (!empty($d->dimensoes)) {
																							$html.= $d->dimensoes;
																						}
																						if (!empty($d->comprimento)) {
																							$html.=  $d->comprimento . " mm";
																						}
																						if (!empty($d->volume)) {
																							$html.=  $d->volume . " ml";
																						}
																						if (!empty($d->peso)) {
																							$html.=  $d->peso . " g";
																						}
																						if (!empty($d->dimensoesL)) {
																							$html .= " Largura: " . $d->dimensoesL . " mm";
																						}
																						if (!empty($d->dimensoesC)) {
																							$html .= " Comp.: " . $d->dimensoesC . " mm";
																						}
																						if (!empty($d->dimensoesA)) {
																							$html .= " Altura: " . $d->dimensoesA . " mm";
																						}
																						echo '<td>'.$html.'</td>';
																						echo '<td>'.$d->nomegrupo.'</td>';
																						echo '<td>'.$d->pn.' - '.$d->descricao.'</td>';
																						echo '<td>'.$d->obs.'</td>';
																						echo '<td>'.$d->notafiscal.'</td>';
																						$dataEntrega = "";
																						if (!empty($d->previsao_entrega)) {
																							$dataEntrega = date("d/m/Y", strtotime($d->previsao_entrega));
																						}
																						echo '<td>'.$dataEntrega.'</td>';
																						$dataCadastro = date("d/m/Y", strtotime($d->datacadastro));
																						echo '<td>'.$dataCadastro.'</td>';
																						if ($d->data_alteracao <> '') {
																							$data_alteracao = date("d/m/Y H:i:s", strtotime($d->data_alteracao));
																						} else {
																							$data_alteracao = "";
																						}
																						echo '<td>'.$data_alteracao.'</td>';
																						echo '<td>'.$d->nome.'</td>';
																						echo '<td>'.$d->nomeStatus.'</td>';
																						if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
																							if ($d->idStatuscompras == 1 || $d->idStatuscompras == 2 || $d->idStatuscompras == 19) {
																							?>
																									<td>
																										<a href="#modalAlterarpedido<?php echo $d->idDistribuir; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top">
																											<font size='1'>Editar</font>
																										</a>
										
																									</td>
																									<td>
										
																										<a href="#modal-excluirmaterial<?php echo $d->idDistribuir; ?>" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuir="<?php echo $d->idDistribuir; ?>" class="btn btn-danger tip-top">
																											<font size='1'>Excluir</font>
																										</a>
																									</td>
																								<?php
																								} else if ($d->liberado_edit_compras == 1) {
																								?>
										
																									<td>
																										<a href="#modalAlterarpedido<?php echo $d->idDistribuir; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>
										
																									</td>
																									<td>
										
																										<a href="#modal-cancelarmaterial<?php echo $d->idDistribuir; ?>" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuircancelar="<?php echo $d->idDistribuir; ?>" class="btn btn-danger tip-top">
																											<font size='1'>Cancelar</font>
																										</a>
																									</td>
										
																								<?php
																								}else{
																									echo '<td></td>';
																									echo '<td></td>';
																								}
																								?>
										
										
																						</tr>
																						<?php
																						}else{
																							echo '<td></td>';
																							echo '<td></td>';
																						}
																						/*
																						echo '<td></td>';
																						echo '<td></td>';*/
																					echo '</tr>';
																				}
																				?>                                                  
																																								
																			</tbody>
																		</table>
																	</div>                                
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>    
									</div>
								</div>
							</div>
							
							


							<?php
								foreach ($distribuir_os as $dist) { ?>
											<style type="text/css">
												
												.tamanho<?php echo $dist->idDistribuir; ?> {
													display: <?php echo ($dist->metrica == 1? "block": "none")?>
												}

												.volume<?php echo $dist->idDistribuir; ?> {
													display: <?php echo ($dist->metrica == 2? "block": "none")?>
												}

												.peso<?php echo $dist->idDistribuir; ?> {
													display: <?php echo ($dist->metrica == 3? "block": "none")?>
												}

												.dimensoes<?php echo $dist->idDistribuir; ?> {
													display: <?php echo ($dist->metrica == 4? "block": "none")?>
												}
												.livre<?php echo $dist->idDistribuir; ?> {
													display: <?php echo ($dist->metrica == 0? "block": "none")?>
												}
											</style>
											<div id="modalAlterarpedido<?php echo $dist->idDistribuir; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h5 id="myModalLabel">Alterar Material: OS = <?php echo $result->idOs; ?></h5>
												</div>
												
													<form action="<?php echo base_url(); ?>index.php/os/editar_distribuiros" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
													<div class="modal-body">
														<div class="span12">
															<div class="span6">
																<label>Descrição</label>
																<input id="term<?php echo $dist->idDistribuir; ?>" type="text" name="term<?php echo $dist->idDistribuir; ?>" value="<?php echo $dist->descricaoInsumo; ?>" class='span12' />
																<input id="idOs" type="hidden"  name="idOs" value="<?php echo $result->idOs; ?>" />
																<input id="idDistribuir<?php echo $dist->idDistribuir; ?>" type="hidden" name="idDistribuir" value="<?php echo $dist->idDistribuir; ?>" />
																<input id="idInsumos<?php echo $dist->idDistribuir; ?>" type="hidden" name="idInsumos" value="<?php echo $dist->idInsumos; ?>" class='span12' />

															</div>
															<div class="span3">
																<label>Unidade</label>
																<select class="span12" name="idMedicao" id="idMedicao<?php echo $dist->idDistribuir; ?>" onchange="verificar(this.value,<?php echo $dist->idDistribuir; ?>)">
																	<option value="0">Unidade</option>
																	<option value="1">Unidade/Comprimento</option>
																	<option value="2">Unidade/Volume</option>
																	<option value="3">Unidade/Peso</option>
																	<option value="4">Unidade/Dimensões</option>
																</select>
															</div>
															<div class="span3">
																<div class="livre<?php echo $dist->idDistribuir; ?>" >
																	<?php if(!empty($dist->dimensoes)){?>
																		<label>Dimensões:</label>
																		<input class="span12 number" id="livre<?php echo $dist->idDistribuir; ?>" type="text" name="livre" value="<?php echo $dist->dimensoes; ?>" />
																	
																	<?php } ?>
																</div>
																<div class="tamanho<?php echo $dist->idDistribuir; ?>" >
																	
																	<label>Comprimento(mm):</label>
																	<input class="span12 number" id="tamanho<?php echo $dist->idDistribuir; ?>" type="text" name="tamanho" value="<?php echo $dist->comprimento; ?>" />
																	
																</div>
																<div class="volume<?php echo $dist->idDistribuir; ?>">
																	
																	<label>Volume(ml):</label>
																		<input class="span12 number" id="volume<?php echo $dist->idDistribuir; ?>" type="text" name="volume" value="<?php echo $dist->volume; ?>" />
																	
																</div>
																<div class="peso<?php echo $dist->idDistribuir; ?>">
																	
																	<label>Peso(g):</label>
																	<input class="span12 number" id="peso<?php echo $dist->idDistribuir; ?>" type="text" name="peso" value="<?php echo $dist->peso; ?>" />
																	
																</div>
																<div class="dimensoes<?php echo $dist->idDistribuir; ?>">
																	
																	<label>Dimensões(mm):</label>
																		
																	<input class="span4 number" id="dimensoesL<?php echo $dist->idDistribuir; ?>" type="text" name="dimensoesL" value="<?php echo $dist->dimensoesL; ?>" placeholder='Largura' />
																	<input class="span4 number" id="dimensoesC<?php echo $dist->idDistribuir; ?>" type="text" name="dimensoesC" value="<?php echo $dist->dimensoesC; ?>" placeholder='Comp.' />
																	<input class="span4 number" id="dimensoesA<?php echo $dist->idDistribuir; ?>" type="text" name="dimensoesA" value="<?php echo $dist->dimensoesA; ?>" placeholder='Altura' />
																		
																	
																</div>
															</div>
														</div>
														<?php 
															if($this->permission->checkPermission($this->session->userdata('permissao'),'desenvolvedor')){
																echo '<div class="span12" style="margin-left:0px">';
																	echo '<label>O.S.</label><input class="span12" id="idOs" type="text"  name="idOs" value="'.$result->idOs.'" />';
																echo '</div>';
															}
														?>
														<div class="span12" style="margin-left:0px">
															<div class="span4">
																<label>Item Comercial:<div style="display: contents;"><input <?php if($dist->itemcomercial == 1){echo "checked";}?> type="checkbox" name="itemcomercial" id="itemcomercial<?php echo $dist->idDistribuir; ?>" class="span1"></div></label>
																
															</div>	
														</div>
														<div class="span12" style="margin-left:0px">
															<div class="span2">
																<label>Qtd.</label>
																<input id="quantidade<?php echo $dist->idDistribuir; ?>" type="text" name="quantidade" value="<?php echo $dist->quantidade; ?>" class='span12' />															
															</div>
															<div class="span3">
																<label>Cod. Forn.</label>
																<input type="text" id="codforn<?php echo $dist->idDistribuir; ?>" name="codforn" class="span12" value="<?php echo $dist->cod_fornecedor; ?>">
															</div>
															<div class="span3">
																<label>PN</label>
																<input type="hidden" id="idProdutosa2<?php echo $dist->idDistribuir; ?>" name="idProdutosa2" size="3" value="<?php echo $dist->idProdutos; ?>" />
																<input type="text" id="pna2<?php echo $dist->idDistribuir; ?>" name="pna2<?php echo $dist->idDistribuir; ?>" size="97" ref="autocomplete" class="span12" value="<?php echo $dist->descricao; ?>" />
															</div>
															<div class="span4">
																<label>Especifique o Grupo</label>
																<select class="span12 recebe-solici" class="controls" style="font-size: 10px;" name="idgrupo" id="idgrupo">
																	<option value="0">---</option>
																	<?php foreach ($dados_statusgrupo as $so) { ?>

																		<option value="<?php echo $so->idgrupo; ?>" <?php if ($so->idgrupo == $dist->id_status_grupo) {
																														echo "selected='selected'";
																													} ?>><?php echo $so->nomegrupo; ?></option>
																	<?php } ?>


																</select>
																
															</div>
														</div>
														<div class="span12" style="margin-left:0px">
															<label>OBS</label>
															<textarea id="obs<?php echo $dist->idDistribuir; ?>" rows="5" cols="100" class="span12" name="obs"><?php echo $dist->obs; ?></textarea>
														</div><!--
														<div class="control-group">
															
															<div class="controls" style="margin-left:0px">
																Descrição <input id="term<?php echo $dist->idDistribuir; ?>" type="text" name="term<?php echo $dist->idDistribuir; ?>" value="<?php echo $dist->descricaoInsumo; ?>" class='span12' />


																<input id="idOs" type="hidden"  name="idOs" value="<?php echo $result->idOs; ?>" />
																<input id="idDistribuir<?php echo $dist->idDistribuir; ?>" type="hidden" name="idDistribuir" value="<?php echo $dist->idDistribuir; ?>" />
																<input id="idInsumos<?php echo $dist->idDistribuir; ?>" type="hidden" name="idInsumos" value="<?php echo $dist->idInsumos; ?>" class='span12' />

															</div>
															<?php 
															if($this->permission->checkPermission($this->session->userdata('permissao'),'desenvolvedor')){
																echo '<div class="controls" style="margin-left:0px">';
																	echo 'O.S.<input id="idOs" type="text"  name="idOs" value="'.$result->idOs.'" />';
																echo '</div>';
															}
															?>-->
															<!--<div class=""  style="margin-left:0px">
															
																
																Quantidade em Estoque:
																<input id="estoque<?php echo $dist->idDistribuir; ?>" type="text" name="estoque" value="" readonly /> -->
																<!--<font red='red' size='1'>*Se a qtd solicitada for maior que o estoque, será gerado 2 itens automaticamente, 1 para solicitar ao estoque outro para solicitar compra</font>
																 - Compra PCP: <input type="checkbox" name="checkbox" id="checkbox" <?php if($dist->responsabilidadePCP == 1){echo "checked";}?> value="1"><br>
															</div>
															<div class="controls"  style="margin-left:0px">
																Quantidade de Itens<input id="quantidade<?php echo $dist->idDistribuir; ?>" type="text" name="quantidade" value="<?php echo $dist->quantidade; ?>" class='span12' />
															</div>
															<div class="control-group"  style="margin-left:0px"><br>
																Unidade:
																<select class=" form-control" name="idMedicao" id="idMedicao<?php echo $dist->idDistribuir; ?>" onchange="verificar(this.value,<?php echo $dist->idDistribuir; ?>)">
																	<option value="0">Unidade</option>
																	<option value="1">Unidade/Comprimento</option>
																	<option value="2">Unidade/Volume</option>
																	<option value="3">Unidade/Peso</option>
																	<option value="4">Unidade/Dimensões</option>
																</select>
															</div>
															<div class="livre<?php echo $dist->idDistribuir; ?>" >
																<?php if(!empty($dist->dimensoes)){?>

															
																<div class="control-group">
																	Dimensões:
																	<input  class="form-control number" id="livre<?php echo $dist->idDistribuir; ?>" type="text" name="livre" value="<?php echo $dist->dimensoes; ?>" />
																</div>
																<?php } ?>
															</div>
															<div class="tamanho<?php echo $dist->idDistribuir; ?>" >
																<div class="control-group">
																	Comprimento(mm):
																	<input class="form-control number" id="tamanho<?php echo $dist->idDistribuir; ?>" type="text" name="tamanho" value="<?php echo $dist->comprimento; ?>" />
																</div>
															</div>
															<div class="volume<?php echo $dist->idDistribuir; ?>">
																<div class="control-group">
																	Volume(ml):
																	<input class="form-control number" id="volume<?php echo $dist->idDistribuir; ?>" type="text" name="volume" value="<?php echo $dist->volume; ?>" />
																</div>
															</div>
															<div class="peso<?php echo $dist->idDistribuir; ?>">
																<div class="control-group"><br>
																	Peso(g):
																	<input class="form-control number" id="peso<?php echo $dist->idDistribuir; ?>" type="text" name="peso" value="<?php echo $dist->peso; ?>" />
																</div>
															</div>
															<div class="dimensoes<?php echo $dist->idDistribuir; ?>">
																<div class="control-group"><br>
																	Dimensões(mm):
																	<div class="">
																		<input class="form-control number" id="dimensoesL<?php echo $dist->idDistribuir; ?>" type="text" name="dimensoesL" value="<?php echo $dist->dimensoesL; ?>" placeholder='Largura' />
																		<input class="form-control number" id="dimensoesC<?php echo $dist->idDistribuir; ?>" type="text" name="dimensoesC" value="<?php echo $dist->dimensoesC; ?>" placeholder='Comp.' />
																		<input class="form-control number" id="dimensoesA<?php echo $dist->idDistribuir; ?>" type="text" name="dimensoesA" value="<?php echo $dist->dimensoesA; ?>" placeholder='Altura' />
																	</div>
																</div>
															</div>-->
															<!--
															<div class="controls">
																Dimensões<input id="dimensoes<?php echo $dist->idDistribuir; ?>" type="text" name="dimensoes" value="<?php echo $dist->dimensoes; ?>" class='span12' />

																<input id="idDistribuir<?php echo $dist->idDistribuir; ?>" type="hidden" name="idDistribuir" value="<?php echo $dist->idDistribuir; ?>" />

															</div>

															<div class="control-group"><br>PN / Referência Fornecedor<font size='1'> ( digitar o PN especifico da peça que esta comprando o material acima )</font>
																<input type="hidden" id="idProdutosa2<?php echo $dist->idDistribuir; ?>" name="idProdutosa2" size="3" value="<?php echo $dist->idProdutos; ?>" />
																<input type="text" id="pna2<?php echo $dist->idDistribuir; ?>" name="pna2<?php echo $dist->idDistribuir; ?>" size="97" ref="autocomplete" class="span12" value="<?php echo $dist->descricao; ?>" />

															</div>
															<div class="control-group"><br>Especifique o Grupo
																<select class="recebe-solici" class="controls" style="font-size: 10px;" name="idgrupo" id="idgrupo">
																	<option value="0">---</option>
																	<?php foreach ($dados_statusgrupo as $so) { ?>

																		<option value="<?php echo $so->idgrupo; ?>" <?php if ($so->idgrupo == $dist->id_status_grupo) {
																														echo "selected='selected'";
																													} ?>><?php echo $so->nomegrupo; ?></option>
																	<?php } ?>


																</select>
															</div>

															<div class="controls">
																OBS<textarea id="obs<?php echo $dist->idDistribuir; ?>" rows="5" cols="100" class="span12" name="obs"><?php echo $dist->obs; ?></textarea>
															</div>
														</div>-->
													</div>
													<div class="modal-footer">
														<button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
														<button class="btn btn-primary">Alterar</button>
													</div>
													
												</form>												
											</div>

											<script type="text/javascript">
												$(document).ready(function() {

													//console.log('#idInsumos2');
													$("#term" + <?php echo $dist->idDistribuir; ?>).autocomplete({
														source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir3",
														minLength: 1,
														select: function(event, ui) {
															//alert($('#idInsumos').val(ui.item.id));
															$('#idInsumos' + <?php echo $dist->idDistribuir; ?>).val(ui.item.id);
															if (ui.item.estoque != null && ui.item.estoque != "") {
																$('#spanAlterar<?php echo $dist->idDistribuir; ?>').append('<a href="<?php echo base_url(); ?>  " style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>');
															} else {
																$('#spanAlterar<?php echo $dist->idDistribuir; ?>').append('Não possuí item no estoque');
															}

														}
													});


													$("#pna2" + <?php echo $dist->idDistribuir; ?>).autocomplete({
														source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
														minLength: 1,
														select: function(event, ui) {
															$('#idProdutosa2' + <?php echo $dist->idDistribuir; ?>).val(ui.item.id);

														}
													});


												});
											</script>




											<div id="modal-excluirmaterial<?php echo $dist->idDistribuir; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form action="<?php echo base_url() ?>index.php/os/excluir_item" method="post">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h5 id="myModalLabel">Excluir Material OS</h5>
													</div>
													<div class="modal-body">
														<input type="hidden" id="idDistribuir" name="idDistribuir" value="<?php echo $dist->idDistribuir; ?>" />
														<input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
														<h6 style="text-align: center"><?php echo $dist->quantidade." - ".$dist->descricaoInsumo;?></h6>
														<h5 style="text-align: center">Deseja realmente excluir este item?</h5>
													</div>
													<div class="modal-footer">
														<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
														<button class="btn btn-danger">Excluir</button>
													</div>
												</form>
											</div>


											<div id="modal-cancelarmaterial<?php echo $dist->idDistribuir; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form action="<?php echo base_url() ?>index.php/os/excluir_item_cancelar" method="post">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h5 id="myModalLabel">Cancelar Material OS</h5>
													</div>
													<div class="modal-body">
														<input type="hidden" id="idDistribuircancelar" name="idDistribuircancelar" value="<?php echo $dist->idDistribuir; ?>" />
														<input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />

														<h5 style="text-align: center">Deseja realmente cancelar este item? Esse item não será excluido definitivo, apenas ficara como cancelado, e o setor de suprimentos não prosseguira com o processo de compra.</h5>
													</div>
													<div class="modal-footer">
														<button class="btn" data-dismiss="modal" aria-hidden="true">Desistir</button>
														<button class="btn btn-danger">OK, CANCELAR ITEM</button>
													</div>
												</form>
											</div>
												<?php } ?>



						</div><!-- div principal ao entrar -->




						<!--<div class="widget-content" id="printOs">
                <div class="invoice-content">
                  ddd
              
                </div>
            	</div>-->
					</div>

				</div>


				

			</div>

		</div>
	</div>
</div>
<div id="modalFinalizar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="<?php echo base_url(); ?>index.php/os/finalizarpcp"  enctype="multipart/form-data" method="post" class="form-horizontal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Cadastro de materiais</h3>
		</div>
		<div class="modal-body">
			<input id="idOsDis" name="idOsDis" type="hidden" value="<?php echo $result->idOs; ?>">
			<div class="control-group">
				<h5>Deseja finalizar o cadastro de materiais?</h5>
				<p>(Após finalizar o cadastro, somente será possível adicionar materiais mediante a autorização do responsável pelo almoxarifado.)</p>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
			<button class="btn btn-success">Finalizar</button>
		</div>
	</form>
</div>
<!-- cadastgrar nf -->
<div id="modalinserir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
	<form action="<?php echo base_url(); ?>index.php/os/cad_distribuir" id="formCadastrar" enctype="multipart/form-data" method="post" >
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabelCadastrarOs">Cadastrar Item OS: <?php echo $result->idOs; ?></h3>
			<a  'href="#modal-cadastrarInsumo" role="button" 'data-toggle="modal" onclick="openmodal()" class="btn btn-success" style="height: 20px"><i class="icon-plus icon-white"></i> Cadastrar Insumo</a>
		</div>
		<div class="modal-body">
			<div class="span12">
				<div class="span6">
					<label>Descrição</label>
					<input id="term2" type="text" name="term2" value="" class='span12' />
					<input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
					<input id="idOsSub" type="hidden" name="idOsSub" value="" />
					<input id="idInsumos2" type="hidden" name="idInsumos2" value="" />
				</div>	
				<div class="span3">
					<label>Unidade</label>
					<select class="span12" name="idMedicao" id="idMedicao0" onchange="verificar(this.value,0)">
						<option value="0">Unidade</option>
						<option value="1">Unidade/Comprimento</option>
						<option value="2">Unidade/Volume</option>
						<option value="3">Unidade/Peso</option>
						<option value="4">Unidade/Dimensões</option>
					</select>
				</div>
				<div class="span3">
					<div class="livre0">
						<label></label>
					</div>
					<div class="tamanho0">
						<label>Comprimento(mm):</label>
						<input  class="span12 number" id="tamanho0" type="text" name="tamanho" value="" />
					</div>
					<div class="volume0">
						<label>Volume(ml):</label>
						<input  class="span12 number" id="volume0" type="text" name="volume" value="" />
					</div>
					<div class="peso0">
						<label>Peso(g):</label>
						<input  class="span12 number" id="peso0" type="text" name="peso" value="" />
					</div>
					<div class="dimensoes0">
						<label>Dimensões(mm):</label>
						<input  class="span4 number" id="dimensoesL0" type="text" name="dimensoesL" value="" placeholder='Largura' />
						<input  class="span4 number" id="dimensoesC0" type="text" name="dimensoesC" value="" placeholder='Comp.' />
						<input  class="span4 number" id="dimensoesA0" type="text" name="dimensoesA" value="" placeholder='Altura' />
					</div>
				</div>
				
			</div>
			
			<div class="span12" style="margin-left:0px">
				
				
				<div class="span12">
					<label><b>Verificar Estoque / Reserva:</b><span style="font-size:16px;" id="spanInserir"></span></label>
					<div style="position: absolute; display:none" id="divInserir" >
						<div class="infoEstoque">
							<span align="center">Res.: RESERVADO</span>
							<div class="row-fluid" style="margin-top:0">
								<div class="span12">
									<div class="widget-box">
										<div class="widget-title">
											<span class="icon">
												<i class="icon-tags"></i>
											</span>
											<h5>Estoque</h5>
											
										</div>
										<div class="widget-content nopadding">
											<div class="span12" style=" margin-left: 0">
												<div class="tab-content">
													<div class="tab-pane active" >
														<div class="span12" >                                
															<div class="widget-box" style="margin-top:0px">                                        
																<table id="tableinfoEstqInsert" class="table table-bordered ">
																	<thead>
																		<tr>
																			<th>Res.</th>
																			<th>Item</th>
																			<th>Qtd.</th>
																			<th>Empresa</th>
																		</tr>
																	</thead>
																	<tbody>                                                  
																																						
																	</tbody>
																</table>
															</div>                                
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>    
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="span12" style="margin-left:0px">
				<div class="span4">
					<label>Item Comercial:<div style="display: contents;"><input type="checkbox" name="itemcomercial" id="itemcomercial" class="span1"></div></label>
					
				</div>		
				
			</div>

			<div class="span12" style="margin-left:0px">
				<div class="span2">
					<label>Qtd.</label>
					<input id="quantidade" type="text" name="quantidade" value="" class='span12' />
				</div>
				<div class="span3">
					<label>Cod. Forn.</label>
					<input type="text" id="codforn" name="codforn" class="span12" value="">
				</div>
				<div class="span3">
					<label>PN</label>
					<input type="hidden" id="idProdutos" name="idProdutos" size="3" value="0" />
					<input type="text" id="pn" name="pn" size="97" ref="autocomplete" class="span12" value="" />
				</div>
				<div class="span4">
					<label>Especifique o Grupo</label>
					<select class="span12 recebe-solici" style="font-size: 10px;" name="idgrupo" id="idgrupo0">
						<option value="0">---</option>
						<?php foreach ($dados_statusgrupo as $so) { ?>

							<option value="<?php echo $so->idgrupo; ?>"><?php echo $so->nomegrupo; ?></option>
						<?php } ?>


					</select>
				</div>

			</div>
			<div class="span12" style="margin-left:0px">
				<label>OBS</label> 
				<textarea id="obs" rows="5" cols="5" class="span12" name="obs"></textarea>
				
			</div>
			<!--
			<div class="control-group">
				Descrição <input id="term2" type="text" name="term2" value="" class='span12' />


				<input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
				<input id="idOsSub" type="hidden" name="idOsSub" value="" />
				<input id="idInsumos2" type="hidden" name="idInsumos2" value="" />

			</div>
			<div class="control-group">
				Item comercial <input type="checkbox" name="itemcomercial">
			</div>
			<div class="control-group">
				<span style="font-size:16px"><b>Verificar Estoque / Reserva:</b></span> <span style="font-size:16px;" id="spanInserir"></span>
				 <div style="position: absolute; display:none" id="divInserir" >
					<div class="infoEstoque">
						<span align="center">Res.: RESERVADO</span>
						<div class="row-fluid" style="margin-top:0">
							<div class="span12">
								<div class="widget-box">
									<div class="widget-title">
										<span class="icon">
											<i class="icon-tags"></i>
										</span>
										<h5>Estoque</h5>
										
									</div>
									<div class="widget-content nopadding">
										<div class="span12" style=" margin-left: 0">
											<div class="tab-content">
												<div class="tab-pane active" >
													<div class="span12" >                                
														<div class="widget-box" style="margin-top:0px">                                        
															<table id="tableinfoEstqInsert" class="table table-bordered ">
																<thead>
																	<tr>
																		<th>Res.</th>
																		<th>Item</th>
																		<th>Qtd.</th>
																		<th>Empresa</th>
																	</tr>
																</thead>
																<tbody>                                                  
																																					
																</tbody>
															</table>
														</div>                                
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>    
						</div>
					</div>
				</div>
			</div>

			<div class="control-group"><br>
				Quantidade de Itens: <input id="quantidade" type="text" name="quantidade" value="" class='' />

			</div>
			<div class="control-group"><br>
				Unidade:
				<select class=" form-control" name="idMedicao" id="idMedicao0" onchange="verificar(this.value,0)">
					<option value="0">Unidade</option>
					<option value="1">Unidade/Comprimento</option>
					<option value="2">Unidade/Volume</option>
					<option value="3">Unidade/Peso</option>
					<option value="4">Unidade/Dimensões</option>
				</select>
			</div> -->
			
			<!--<div class="livre0">
				<div class="control-group"><br>
					Dimensões:
					<input class="" class="form-control" id="livre0" type="text" name="livre" value="" />
				</div>
			</div>-->
			<!--
			<div class="tamanho0">
				<div class="control-group"><br>
					Comprimento(mm):
					<input  class="form-control number" id="tamanho0" type="text" name="tamanho" value="" />
				</div>
			</div>
			<div class="volume0">
				<div class="control-group"><br>
					Volume(ml):
					<input  class="form-control number" id="volume0" type="text" name="volume" value="" />
				</div>
			</div>
			<div class="peso0">
				<div class="control-group"><br>
					Peso(g):
					<input class="form-control number" id="peso0" type="text" name="peso" value="" />
				</div>
			</div>
			<div class="dimensoes0">
				<div class="control-group"><br>
					Dimensões(mm):
					<div class="">
						<input  class="form-control number" id="dimensoesL0" type="text" name="dimensoesL" value="" placeholder='Largura' />
						<input  class="form-control number" id="dimensoesC0" type="text" name="dimensoesC" value="" placeholder='Comp.' />
						<input  class="form-control number" id="dimensoesA0" type="text" name="dimensoesA" value="" placeholder='Altura' />
					</div>


				</div>
			</div> -->

			<!--
			<div class="control-group"><br>PN / Referência Fornecedor<font size='1'> ( digitar o PN especifico da peça que esta comprando o material acima )</font>
				<input type="hidden" id="idProdutos" name="idProdutos" size="3" value="0" />
				<input type="text" id="pn" name="pn" size="97" ref="autocomplete" class="span12" value="" />

			</div>
			<div class="control-group"><br>Especifique o Grupo
				<select class="recebe-solici" class="controls" style="font-size: 10px;" name="idgrupo" id="idgrupo0">
					<option value="0">---</option>
					<?php foreach ($dados_statusgrupo as $so) { ?>

						<option value="<?php echo $so->idgrupo; ?>"><?php echo $so->nomegrupo; ?></option>
					<?php } ?>


				</select>
			</div>
			<div class="control-group">
				<br>OBS <textarea id="obs" rows="5" cols="5" class="span6" name="obs"></textarea>



			</div>-->

		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
			<a class="btn btn-success" onclick="verificarDadosMateriais()">Cadastrar</a>
		</div>
	</form>
</div>

<div id="modalCriarSubOs" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="<?php echo base_url(); ?>index.php/os/criarSubOs" id="formCadastrarSubOs" enctype="multipart/form-data" method="post" class="form-horizontal">
		<div class="modal-header">
			<input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabelCadastrarOs">Cadastrar Sub O.S.: <?php echo $result->idOs; ?></h3>
		</div>
		<div class="modal-body">
			<div class="span12" style="padding: 1%; margin-left: 0">
				<div class="span2" class="control-group">
					<label>PN:</label>
					<input type="text" id="pn2" name="pn" size="97" class="span12" value="" >
					<input type="hidden" id="idProdutos2" name="idProdutos" class="span12" value="" >
				</div>
				<div class="span4" class="control-group">
					<label>Descrição:</label>
					<input type="text" id="descricao2" name="descricao" class="span12" value="" >
				</div>
				<div class="span2" class="control-group">
					<label>Quantidade:</label>
					<input type="text" id="quantidade2" name="quantidade"  class="span12" value="" >
				</div>
				<div class="span4" class="control-group">
					<label>Tipo:</label>
					<select class="span12" name="tipoClasse">
						<?php foreach($classe as $r){
							echo '<option value="'.$r->idClasse.'">'.$r->nomeClasse.'</option>';
						}?>
					</select>
				</div>
			</div>			
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
			<button class="btn btn-success">Finalizar</button>
		</div>
	</form>
</div>

<div id="modalCadastrarItens" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="<?php echo base_url(); ?>index.php/os/cad_distribuir2" id="formCadastrarSubOs" enctype="multipart/form-data" method="post" class="form-horizontal">
		<div class="modal-header">
			<input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabelCadastrarMateriaisOs">Cadastrar Itens OS: <?php echo $result->idOs; ?></h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid" style="margin-top:0">
				<div class="span12">
					<div class="widget-box">						
						<div class="widget-content nopadding">
							<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
								
								<div class="span12" id="divCadastrarOs">                                
									<div class="widget-box" style="margin-top:0px">                                        
										<table id="tableCadastrarMateriais" class="table table-bordered ">
											<thead>
												<tr>
													<th>Descrição</th>
													<th>Dimensões</th>                                            
													<th style="width: 50px;">Qtd.</th>
													<th>Grupo</th>
													<th>OBS</th>
												</tr>
											</thead>
											<tbody>
																														
											</tbody>
										</table>
									</div>                                
								</div>
							</div>
						</div>
					</div>
				</div>    
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
			<button class="btn btn-success">Confirmar</button>
		</div>
	</form>
</div>
<div id="modalRejeitaItens" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form action="<?php echo base_url(); ?>index.php/os/rej_distribuir" id="formCadastrarSubOs" enctype="multipart/form-data" method="post" class="form-horizontal">
		<div class="modal-header">
			<input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabelRejeitarMateriaisOs">Rejeitar Itens OS: <?php echo $result->idOs; ?></h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid" style="margin-top:0">
				<div class="span12">
					<div class="widget-box">						
						<div class="widget-content nopadding">
							<div class="span12" id="divProdutosServicos" style=" margin-left: 0">								
								<div class="span12" id="divCadastrarOs">                                
									<div class="widget-box" style="margin-top:0px">                                        
										<table id="tableRejeitarMateriais" class="table table-bordered ">
											<thead>
												<tr>
													<th>Descrição</th>
													<th>Dimensões</th>                                            
													<th style="width: 50px;">Qtd.</th>
													<th>Grupo</th>
													<th>OBS</th>
												</tr>
											</thead>
											<tbody>
																																
											</tbody>
										</table>
									</div>                                
								</div>
							</div>
						</div>
					</div>
				</div>    
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
			<button class="btn btn-success">Confirmar</button>
		</div>
	</form>
</div>



<div id="modal-cadastrarInsumo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Cadastrar Insumo: <?php echo $result->idOs; ?></h3>	
	</div>
	<div class="modal-body">
		<div class="span12">
			<div class="span3">
				<label>Categoria</label>
				<input name="cadastrarCategoria" type="text" id="cadastrarCategoria" class="span12">
				<input name="cadastrarIdCategoria" type="hidden" id="cadastrarIdCategoria" class="span12">
			</div>			
			<div class="span3">
				<label>Sub Categoria</label>
				<input name="cadastrarSubcategoria" type="text" id="cadastrarSubcategoria" class="span12">
				<input name="cadastrarIdSubcategoria" type="hidden" id="cadastrarIdSubcategoria" class="span12">
			</div>
			<div class="span3">
				<label>Descrição</label>
				<input name="cadastrarDescricao" type="text" id="cadastrarDescricao" class="span12">
			</div>
			<div class="span3">
				<label>PN</label>
				<input name="cadastrarPN" type="text" id="cadastrarPN" class="span12">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
		<a 'href="#modal-cadastrarInsumo" role="button" 'data-toggle="modal" onclick="cadastrarinsumo()" class="btn btn-success" style="height: 20px"><i class="icon-plus icon-white"></i> Confirmado</a>
	</div>
</div>


<script type="text/javascript">
	$(function(){
        $(".number").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });
	var categoriaEntrada = document.getElementById('cadastrarCategoria');

	categoriaEntrada.onkeydown = function() {
		var key = event.keyCode || event.charCode;

		if( key == 8 || key == 46 ){      
		document.querySelector("#cadastrarIdCategoria").value = "";
		document.querySelector("#cadastrarIdSubcategoria").value = "";
		document.querySelector("#cadastrarSubcategoria").value = "";
		}
	};
	categoriaEntrada.onkeyup = function() { 
		var key = event.keyCode || event.charCode;    
		if(key != 9){
			document.querySelector("#cadastrarIdCategoria").value = "";
			document.querySelector("#cadastrarIdSubcategoria").value = "";
			document.querySelector("#cadastrarSubcategoria").value = "";
		}
		
	};

	var subcategoriaEntrada = document.getElementById('cadastrarSubcategoria');

	subcategoriaEntrada.onkeydown = function() {
		var key = event.keyCode || event.charCode;

		if( key == 8 || key == 46 ){      
		document.querySelector("#cadastrarIdSubcategoria").value = "";
		}
	};
	subcategoriaEntrada.onkeyup = function() {  
		var key = event.keyCode || event.charCode; 
		if(key != 9){
			document.querySelector("#cadastrarIdSubcategoria").value = "";
		}   
		
	};

	$(document).ready(function(){
		
		$("#cadastrarCategoria").autocomplete({
			source: "<?php echo base_url(); ?>index.php/insumos/autoCompleteCategoriaSubCategoria2",
			minLength: 1,
			select: function( event, ui ) {				
				$('#cadastrarIdCategoria').val(ui.item.idCategoria); 

			}
		});	  
	
	});
	$(document).ready(function(){
		
		$("#cadastrarSubcategoria").autocomplete({
			source: "<?php echo base_url(); ?>index.php/insumos/autoCompleteSubcategoria2",
			minLength: 1,
			select: function( event, ui ) {
				$('#cadastrarIdSubcategoria').val(ui.item.id);
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/insumos/getCategoriaByIdSubcategoria",
					type: 'POST',
					dataType: 'json',
					data:{
						idSubcategoria:ui.item.id
					},
					success: function(data) {
						$('#cadastrarCategoria').val(data.categoria[0].descricaoCategoria);
						$('#cadastrarIdCategoria').val(data.categoria[0].idCategoria); 
						
					},
					error: function(xhr, textStatus, error) {
						console.log("4");
						console.log(xhr.responseText);
						console.log(xhr.statusText);
						console.log(textStatus);
						console.log(error);
					},
				})

			}
		});	  
	
	});

	function cadastrarinsumo(){
		var categoria = document.querySelector('#cadastrarCategoria').value;
		var idcategoria = document.querySelector('#cadastrarIdCategoria').value;
		var subcategoria = document.querySelector("#cadastrarSubcategoria").value;
		var idsubcategoria = document.querySelector("#cadastrarIdSubcategoria").value;
		var descricao = document.querySelector("#cadastrarDescricao").value;
		var pn = document.querySelector("#cadastrarPN").value;
		if(!categoria || !subcategoria || !descricao){
			alert("Informe a categoria, subcategoria e a descrição do material.");
			return
		}
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/insumos/cadastrarDescricaoMaterial",
			type: 'POST',
			dataType: 'json',
			data: {
				categoria: categoria,
				idCategoria: idcategoria,
				subCategoria: subcategoria,
				idSubcategoria: idsubcategoria,
				descricao:descricao,
				pn:pn
			},
			success: function(data) {
				alert(data.msg);
				if(data.result){
					$('#idInsumos2').val(data.insumo);
					$('#term2').val(descricao);
					$('#estoque').val(0);
					document.querySelector('#cadastrarCategoria').value = "";
					document.querySelector('#cadastrarIdCategoria').value = "";
					document.querySelector("#cadastrarSubcategoria").value = "";
					document.querySelector("#cadastrarIdSubcategoria").value = "";
					document.querySelector("#cadastrarDescricao").value = "";
					document.querySelector("#cadastrarPN").value = "";
					$('#modal-cadastrarInsumo').modal('hide');
					$('#modalinserir').modal('show');
				}
				
			},
			error: function(xhr, textStatus, error) {
				console.log("4");
				console.log(xhr.responseText);
				console.log(xhr.statusText);
				console.log(textStatus);
				console.log(error);
				a.disabled = false;
			},
		})



	}

	function openmodal(){
		$('#modalinserir').modal('hide');
		$('#modal-cadastrarInsumo').modal('show');
	}
	$(document).ready(function() {
		jQuery(".data").mask("99/99/9999");
	});


	$(function() {
		$(document).on('click', 'input[type=text][id=example1]', function() {
			this.select();
		});
	});

	$(document).ready(function() {

		//console.log('#idInsumos2');
		$("#term2").autocomplete({
			source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir3",
			minLength: 1,
			select: function(event, ui) {
				$('#idInsumos2').val(ui.item.id);
				if (ui.item.estoque != null && ui.item.estoque != "" && ui.item.estoque > 0) {
					buscarInfoInsumo(ui.item.id);
					$('#spanInserir').empty()
					$('#spanInserir').append('<a onmouseover="$(\'#divInserir\').show()" onmouseout="$(\'#divInserir\').hide()" style="height: 15px;margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>');
				} else {
					$('#spanInserir').empty()
					$('#spanInserir').append('Não possuí item no estoque');
				}



			}
		});



	});
	function buscarInfoInsumo(idInsumo){
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/almoxarifado/carregarInfoInsumo",
			type: 'POST',
			dataType: 'json',
			async:false,
			data: {
				idInsumo: idInsumo
			},
			success: function(data){
				carregarInfoInsumo(data.obj);
			}
		})
	}
	function carregarInfoInsumo(itens){
		var html = "";
		for(x=0;x<itens.length;x++){
			html += "<tr>";
				html += "<td>";
					if(itens[x].reservado == 1)
					html += "SIM"
					if(itens[x].reservado == 0)
					html += "NÃO"
				html += "</td>";
				html += "<td>";
					html += itens[x].descricaoInsumo+" "+(itens[x].metrica == 1?itens[x].comprimento+" MM":"")+(itens[x].metrica == 2?itens[x].volume+" ML":"")+(itens[x].metrica == 3?itens[x].peso+" G":"")+(itens[x].metrica == 4 && itens[x].dimensoesL?" L: "+itens[x].dimensoesL+" MM":"")+(itens[x].metrica == 4 && itens[x].dimensoesC?" C: "+itens[x].dimensoesC+" MM":"")+(itens[x].metrica == 4 && itens[x].dimensoesA?" A: "+itens[x].dimensoesA+" MM":"");
				html += "</td>";
				html += "<td>";
					html += itens[x].quantidade;
				html += "</td>";
				html += "<td>";
					html += itens[x].nome
				html += "</td>";
			html += "</tr>";
		}
		$('#tableinfoEstqInsert tbody').empty();
		$('#tableinfoEstqInsert tbody').append(html);
	}
	$(document).ready(function() {

		//console.log('#idInsumos2');
		$("#pn").autocomplete({
			source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
			minLength: 1,
			select: function(event, ui) {
				$('#idProdutos').val(ui.item.id);


			}
		});

		$("#pn2").autocomplete({
			source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
			minLength: 1,
			select: function(event, ui) {
				$('#idProdutos2').val(ui.item.id);
			}
		});


	});

	

	function verificar(value, pos) {

		var livre = document.querySelector('.livre' + pos);
		var tamanho = document.querySelector('.tamanho' + pos);
		var volume = document.querySelector('.volume' + pos);
		var peso = document.querySelector('.peso' + pos);
		var dimensoes = document.querySelector('.dimensoes' + pos);
		//document.querySelector("#livre" + pos).value = "";
		document.querySelector("#tamanho" + pos).value = "";
		document.querySelector("#volume" + pos).value = "";
		document.querySelector("#peso" + pos).value = "";
		document.querySelector("#dimensoesL" + pos).value = "";
		document.querySelector("#dimensoesC" + pos).value = "";
		document.querySelector("#dimensoesA" + pos).value = "";
		/**/
		if (value == 0) {
			tamanho.style.display = "none";
			volume.style.display = "none";
			peso.style.display = "none";
			dimensoes.style.display = "none";
			//livre.style.display = "block";
		} else if (value == 1) {
			tamanho.style.display = "block";
			volume.style.display = "none";
			peso.style.display = "none";
			dimensoes.style.display = "none";
			livre.style.display = "none";
		} else if (value == 2) {
			tamanho.style.display = "none";
			volume.style.display = "block";
			peso.style.display = "none";
			dimensoes.style.display = "none";
			//livre.style.display = "none";
		} else if (value == 3) {
			tamanho.style.display = "none";
			volume.style.display = "none";
			peso.style.display = "block";
			dimensoes.style.display = "none";
			//livre.style.display = "none";
		} else if (value == 4) {
			tamanho.style.display = "none";
			volume.style.display = "none";
			peso.style.display = "none";
			dimensoes.style.display = "block";
			//livre.style.display = "none";
		}
	}
	function openclose(td,valor){
        var tr = document.querySelector(".trfilho"+valor);
        
        if(tr.style.display == "table-row" || tr.style.display == ""){
            $(".trfilho"+valor).hide('fast');
            $(td).parent('tr').css('background-color', '');
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");            
        }else{
            $(".trfilho"+valor).show('fast');
            $(td).parent('tr').css('background-color', '#efefef');
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }       
    }
	function verificarDadosMateriais(){
		var idInsumos2 = document.querySelector('#idInsumos2');
		var term2 = document.querySelector('#term2');
		var quantidade = document.querySelector('#quantidade');
		var idMedicao0 = document.querySelector('#idMedicao0');
		var tamanho0 = document.querySelector('#tamanho0');
		var livre0 = document.querySelector('#livre0');
		var volume0 = document.querySelector('#volume0');
		var peso0 = document.querySelector('#peso0');
		var dimensoesL0 = document.querySelector('#dimensoesL0');
		var dimensoesC0 = document.querySelector('#dimensoesC0');
		var dimensoesA0 = document.querySelector('#dimensoesA0');
		var idgrupo = document.querySelector('#idgrupo0');

		var idMedicaoValue = idMedicao0.options[idMedicao0.selectedIndex].value;
		var idgrupoValue = idgrupo.options[idgrupo.selectedIndex].value;

		var verificar = true;

		if(!idInsumos2.value){
			$(term2).css('border-color','red');
			verificar = false;
		}
		if(!quantidade.value){
			$(quantidade).css('border-color','red');
			verificar = false;
		}
		if(!idgrupoValue || idgrupoValue=="0"){
			$(idgrupo).css('border-color','red');
			verificar = false;
		}
		if(idMedicaoValue && idMedicaoValue!="0"){
			if(idMedicaoValue == 1 && !tamanho0.value){
				$(tamanho0).css('border-color','red');
				verificar = false;
			}else if(idMedicaoValue == 1 && isNaN(tamanho0.value)){
				$(tamanho0).css('border-color','red');
				alert("O campo COMPRIMENTO só aceita números")
				verificar = false;
			}
			if(idMedicaoValue == 2 && !volume0.value){
				$(volume0).css('border-color','red');
				verificar = false;
			}else if(idMedicaoValue == 2 && isNaN(volume0.value)){
				$(tamanho0).css('border-color','red');
				alert("O campo VOLUME só aceita números")
				verificar = false;
			}
			if(idMedicaoValue == 3 && !peso0.value){
				$(peso0).css('border-color','red');
				verificar = false;
			}else if(idMedicaoValue == 3 && isNaN(peso0.value)){
				$(tamanho0).css('border-color','red');
				alert("O campo PESO só aceita números")
				verificar = false;
			}
			if(idMedicaoValue == 4 && !dimensoesL0.value && !dimensoesC0.value && !dimensoesA0.value){
				$(dimensoesL0).css('border-color','red');
				$(dimensoesC0).css('border-color','red');
				$(dimensoesA0).css('border-color','red');
				verificar = false;
			}else if(idMedicaoValue == 4 && (isNaN(dimensoesL0.value) ||isNaN(dimensoesC0.value) || isNaN(dimensoesA0.value))){
				$(tamanho0).css('border-color','red');
				alert("Os campos DIMENSÕES só aceitam números")
				verificar = false;
			}
		}
		if(verificar){
			$( "#formCadastrar" ).submit();
			
		}else{
			alert("Verifique as informaçõs dos campos destacados.");
		}
		

	}
	function abrirModalInserir(idOsSub,posicao){
		var h3 = "Cadastrar Item OS: <?php echo $result->idOs; ?>."+posicao;

		document.querySelector("#idOsSub").value = idOsSub;
		$("#myModalLabelCadastrarOs").empty();
		$("#myModalLabelCadastrarOs").append(h3);
		$('#modalinserir').modal('show');
	}
	function verificarSubOs(){
		var pn = document.querySelector("#pn2");
		var idProdutos = document.querySelector("#idProdutos2");
		var descricao = document.querySelector("#descricao2");
		var quantidade = document.querySelector("#quantidade2");
		var verificar = true;

		if(!pn.value){
			$(pn).css('border-color','red');
			verificar = false;
		}
		if(!idProdutos.value){
			$(pn).css('border-color','red');
			verificar = false;
		}
		if(!descricao.value){
			$(descricao).css('border-color','red');
			verificar = false;
		}
		if(!quantidade.value){
			$(quantidade).css('border-color','red');
			verificar = false;
		}
		if(verificar){
			$( "#formCadastrarSubOs" ).submit();			
		}else{
			alert("Verifique as informaçõs dos campos destacados.");
		}

	}

	function carregarModalAdicionar(data){
		console.log(data)
		var h3 = "Cadastrar Itens OS: <?php echo $result->idOs; ?>."+data.posicao;
		$("#myModalLabelCadastrarMateriaisOs").empty();
		$("#myModalLabelCadastrarMateriaisOs").append(h3);
		var html="";
		
			html += "<tr>";
				html += "<td>";
					html += '<input type="hidden" name="idDistribuirSugestao[]" value="'+data.idDistribuirSugestao+'"/>';
					html += data.descricaoInsumo
				html += "</td>";
				dimen = "";
				if (data.dimensoes) {
					dimen+= data.dimensoes;
				}
				if (data.comprimento) {
					dimen+= data.comprimento + " mm";
				}
				if (data.volume) {
					dimen+=  data.volume + " ml";
				}
				if (data.peso) {
					dimen+=  data.peso + " g";
				}
				if (data.dimensoesL) {
					dimen+= " L: " + data.dimensoesL + " mm |";
				}
				if (data.dimensoesC) {
					dimen+=" C: " + data.dimensoesC + " mm |";
				}
				if (data.dimensoesA) {
					dimen+= " A: " + data.dimensoesA + " mm |";
				}
				html += "<td>";
					html +=dimen
				html += "</td>";
				html += "<td>";
					html += '<input class="span12" type="text" name="quantidade[]" value="'+data.quantidade+'"/>';
				html += "</td>";
				html += "<td>";
					html +=data.nomegrupo
				html += "</td>";
				html += "<td>";
					html +=data.obs
				html += "</td>";
			html += "</tr>";
		
		var table = document.getElementById("tableCadastrarMateriais").getElementsByTagName('tbody')[0];
		//$(table).empty();

		$(table).append(html);
		

	}

	function carregarModalRejeitar(data){
		console.log(data)
		var h3 = "Rejeitar Itens OS: <?php echo $result->idOs; ?>."+data.posicao;
		$("#myModalLabelRejeitarMateriaisOs").empty();
		$("#myModalLabelRejeitarMateriaisOs").append(h3);
		var html="";
		
		html += "<tr>";
			html += "<td>";
				html += '<input type="hidden" name="idDistribuirSugestao[]" value="'+data.idDistribuirSugestao+'"/>';
				html += data.descricaoInsumo
			html += "</td>";
			dimen = "";
			if (data.dimensoes) {
				dimen+= data.dimensoes;
			}
			if (data.comprimento) {
				dimen+= data.comprimento + " cm";
			}
			if (data.volume) {
				dimen+=  data.volume + " ml";
			}
			if (data.peso) {
				dimen+=  data.peso + " g";
			}
			if (data.dimensoesL) {
				dimen+= " Largura: " + data.dimensoesL + " mm";
			}
			if (data.dimensoesC) {
				dimen+=" Comp.: " + data.dimensoesC + " mm";
			}
			if (data.dimensoesA) {
				dimen+= " Altura: " + data.dimensoesA + " mm";
			}
			html += "<td>";
				html +=dimen
			html += "</td>";
			html += "<td>";
				html += data.quantidade;
			html += "</td>";
			html += "<td>";
				html +=data.nomegrupo
			html += "</td>";
			html += "<td>";
				html +=data.obs
			html += "</td>";
		html += "</tr>";
	
		var table = document.getElementById("tableRejeitarMateriais").getElementsByTagName('tbody')[0];
		$(table).append(html);
	}
	
	function adicionarMaterial(idCheckbox){	
		var concatId = "#"+idCheckbox	
		var listCheckbox = Array.apply(null,document.querySelectorAll(concatId));
		var table = document.getElementById("tableCadastrarMateriais").getElementsByTagName('tbody')[0];
		$(table).empty();

		//console.log(listCheckbox);
		for(x=0;x<listCheckbox.length;x++){
			if(listCheckbox[x].checked){
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/os/getInforDistribuirSugestao",
					type: 'POST',
					dataType: 'json',
					data: {
						idDistribuirSugestao:listCheckbox[x].value
					},
					success: function(data) {
						//console.log(data);
						if(data.result){
							carregarModalAdicionar(data.dados);
						}else{
							alert("Itens não econtrados.");
						}
					},
					error: function(xhr, textStatus, error) {
						console.log(xhr.responseText);
						console.log(xhr.statusText);
						console.log(textStatus);
						console.log(error);
					},
				})
			}			
		}
		$('#modalCadastrarItens').modal('show');
	}
	function rejeitarMaterial(idCheckbox){
		var concatId = "#"+idCheckbox	
		var listCheckbox = Array.apply(null,document.querySelectorAll(concatId));
		var table = document.getElementById("tableRejeitarMateriais").getElementsByTagName('tbody')[0];
		$(table).empty();
		for(x=0;x<listCheckbox.length;x++){
			if(listCheckbox[x].checked){
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/os/getInforDistribuirSugestao",
					type: 'POST',
					dataType: 'json',
					data: {
						idDistribuirSugestao:listCheckbox[x].value
					},
					success: function(data) {
						//console.log(data);
						if(data.result){
							carregarModalRejeitar(data.dados);
						}else{
							alert("Itens não econtrados.");
						}
					},
					error: function(xhr, textStatus, error) {
						console.log(xhr.responseText);
						console.log(xhr.statusText);
						console.log(textStatus);
						console.log(error);
					},
				})
			}			
		}
		$('#modalRejeitaItens').modal('show');
	}
	//$(document).ready(function(){	
		let distribuir = 0;	
		<?php 
			$hora = 0;
			$minutos = 0;
			$segundos = 0;
			$milisegundos = 0;
			$distribuir = $this->os_model->getDistribuirByIdOs($result->idOs);
			if(!empty($distribuir)){
				$inicio = ($itens_orcamento->tipoOrc == "serv"? new DateTime($itens_orcamento->data_abertura): new DateTime($itens_orcamento->data_finalizado_desenho));
				$fim = new DateTime($distribuir[0]->data_cadastro);
				$diffDataComercial = $fim->diff($inicio);
				$diasHoras = 0;
				if($diffDataComercial->m>0){
					$diasHoras = ($diffDataComercial->m*30*24);
				}
				if($diffDataComercial->d>0){
					$diasHoras = ($diffDataComercial->d*24) + $diasHoras;
				}
				?> 
					distribuir = 1;
				<?php 
				$hora = ($diffDataComercial->h+$diasHoras);
				$minutos = $diffDataComercial->i;
				$segundos = $diffDataComercial->s;
			}else{
				$inicio = ($itens_orcamento->tipoOrc == "serv"? new DateTime($itens_orcamento->data_abertura): new DateTime($itens_orcamento->data_finalizado_desenho));
				$fim = new DateTime(date('Y-m-d H:i:s'));
				$diffDataComercial = $fim->diff($inicio);
				$diasHoras = 0;
				if($diffDataComercial->m>0){
					$diasHoras = ($diffDataComercial->m*30*24);
				}
				if($diffDataComercial->d>0){
					$diasHoras = ($diffDataComercial->d*24) + $diasHoras;
				}
				$hora = ($diffDataComercial->h+$diasHoras);
				$minutos = $diffDataComercial->i;
				$segundos = $diffDataComercial->s;
				
			}
			
		?>
		let hour = <?php echo $hora?>;
		let minute = <?php echo $minutos?>;
		let second = <?php echo $segundos?>;
		let millisecond = 0;
		let cron;
		if(second != 0 || minute!=0 || hour!=0 && distribuir!=1){
			cron = setInterval(() => { timer(); }, 10);
		}else if(distribuir==1){
			document.getElementById('hour').innerText = returnData(hour);
			document.getElementById('minute').innerText = returnData(minute);
			document.getElementById('second').innerText = returnData(second);
		}else{
			document.getElementById('hour').innerText = returnData(hour);
			document.getElementById('minute').innerText = returnData(minute);
			document.getElementById('second').innerText = returnData(second);
		}
		

		function timer() {
			if ((millisecond += 15) >= 1000) {
				millisecond = 0;
				second++;
			}
			if (second == 60) {
				second = 0;
				minute++;
			}
			if (minute == 60) {
				minute = 0;
				hour++;
			}
			document.getElementById('hour').innerText = returnData(hour);
			document.getElementById('minute').innerText = returnData(minute);
			document.getElementById('second').innerText = returnData(second);
		}

		function returnData(input) {
			return input > 10 ? input : `0${input}`
		}
		function scrollLeft0(input){
			//console.log("foi")
			divScroll = $(input).parent(".tab-content");
			//divScroll.scrollLeft(divScroll[0].scrollWidth)
			divScroll.animate({scrollLeft:divScroll[0].scrollWidth},500)
		}
		function scrollRight0(input){
			//console.log("foi")
			divScroll = $(input).parent(".tab-content");
			//divScroll.scrollLeft(divScroll[0].scrollWidth)
			divScroll.animate({scrollLeft:0},500)
		}/**/
		function scrollDetect(input,event){
			//var tamanhoReal = event.pageX - $(input).width()
			if(input.className == "tab-content"){
				if($(input).width() -100 < (event.pageX - $(input).offset().left) && $(input).width() > (event.pageX - $(input).offset().left)){
					$(input).animate({scrollLeft:input.scrollWidth},100)
				}
				if(0 < (event.pageX - $(input).offset().left) && 100 > (event.pageX - $(input).offset().left)){
					$(input).animate({scrollLeft:0},100)
				}
			}else{
				divScroll = $(input).parent(".tab-content");
				if($(divScroll.context).width() -100 < (event.pageX - $(divScroll.context).offset().left) && $(divScroll.context).width() > (event.pageX - $(divScroll.context).offset().left)){
					$(divScroll.context).animate({scrollLeft:divScroll.context.scrollWidth},100)
				}
				if(0 < (event.pageX - $(divScroll.context).offset().left ) && 100 > (event.pageX - $(divScroll.context).offset().left)){
					$(divScroll.context).animate({scrollLeft:0},100)
				}
			}
			
		}
		$(document).ready(function() {
			$("#imprimir").click(function() {
				PrintElem('#pcpItens');
			})

			function PrintElem(elem) {
				Popup($(elem).html());
			}

			function Popup(data) {
				var mywindow = window.open('', 'SGI', 'height=600,width=800');
				mywindow.document.write('<html><head><title>SGI</title><meta charset="UTF-8" />');
				/* mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/bootstrap.min.css' /><link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css' />");*/
				mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/tableimprimir.css' />");
				mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />');
				mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />');
				mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />');
				mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />');
				mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />');


				mywindow.document.write('</head><body >');
				mywindow.document.write(data);
				mywindow.document.write('</body></html>');

				mywindow.print();
				//mywindow.close();

				return true;
			}

		});
	//})
</script>