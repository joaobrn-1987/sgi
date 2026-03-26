<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<?php

//echo $date = date('Y-m-d H:i:s');

$data = date("d-m-y");

$hora = date("H:i:s"); ?>



<div class="row-fluid" style="margin-top:0">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-tags"></i>
				</span>
				<h5>Distribuir OS</h5>

			</div>
			<div class="widget-content nopadding">


				<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
					<ul class="nav nav-tabs">
						<li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da OS</a></li>
						<!--<li id="tabProdutos"><a href="#tab2" data-toggle="tab">Anexo NF</a></li>
                        <li id="tabServicos"><a href="#tab3" data-toggle="tab">Insumos</a></li>
                        <li id="tabAnexos"><a href="#tab4" data-toggle="tab">Anexos</a></li>-->
					</ul>
					<div class="tab-content">




						<div class="tab-pane active" id="tab1">

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

							</div>
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
											<!--  
											<option value="500">
												500
											</option>       -->

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



							<div class="widget-box">
								<div class="widget-title">
									<span class="icon">
										<i class="icon-user"></i>
									</span>
									<h5>Cadastrar Material</h5>
									<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) { ?>
										<a href="#modalinserir" data-toggle="modal" role="button" class="btn btn-success"><i class="icon-plus icon-white"></i> Cadastrar Materiais OS</a>
										<br>
										<br>

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
														<font color='<?php echo $color; ?>'>
															<?php echo $dist->idDistribuir; ?>
													</td>
													</font>

													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo $dist->quantidade; ?>
													</td>
													</font>
													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo $dist->descricaoInsumo; ?>
													</td>
													</font>
													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo $dist->dimensoes; ?>
													</td>
													</font>
													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo $dist->nomegrupo; ?>
													</td>
													</font>
													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo $dist->pn; ?> - <?php echo $dist->descricao; ?>
													</td>
													</font>

													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo $dist->obs; ?>
													</td>
													</font>
													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo $dist->notafiscal; ?>
													</td>
													</font>
													<td>
														<font color='<?php echo $color; ?>'>
														
															<?php  if(!empty($dist->previsao_entrega)){echo date("d/m/Y", strtotime($dist->previsao_entrega));} ?>
													</td>
													</font>
													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo date("d/m/Y H:i:s", strtotime($dist->datacadastro));  ?>

													</td>
													</font>
													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo $data_alteracao; ?>
													</td>
													</font>
													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo $dist->nome; ?>
													</td>
													</font>
													<td>
														<font color='<?php echo $color; ?>'>
															<?php echo $dist->nomeStatus; ?>
													</td>
													</font>




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
											<div id="modalAlterarpedido<?php echo $dist->idDistribuir; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h5 id="myModalLabel">Alterar Material: OS = <?php echo $result->idOs; ?></h5>
												</div>
												<div class="modal-body">
													<form action="<?php echo base_url(); ?>index.php/os/editar_distribuiros" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
														<div class="control-group">

															<div class="controls">
																Descrição <input id="term<?php echo $dist->idDistribuir; ?>" type="text" name="term<?php echo $dist->idDistribuir; ?>" value="<?php echo $dist->descricaoInsumo; ?>" class='span12' />


																<input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
																<input id="idInsumos<?php echo $dist->idDistribuir; ?>" type="hidden" name="idInsumos" value="<?php echo $dist->idInsumos; ?>" class='span12' />

															</div>
															<div class="">
																Quantidade em Estoque:
																<input id="estoque<?php echo $dist->idDistribuir; ?>" type="text" name="estoque" value="" readonly /><br>
																<!--<font red='red' size='1'>*Se a qtd solicitada for maior que o estoque, será gerado 2 itens automaticamente, 1 para solicitar ao estoque outro para solicitar compra</font>-->

															</div>
															<div class="controls">
																Quantidade<input id="quantidade<?php echo $dist->idDistribuir; ?>" type="text" name="quantidade" value="<?php echo $dist->quantidade; ?>" class='span12' />
															</div>

															<div class="controls">
																Dimensões<input id="dimensoes<?php echo $dist->idDistribuir; ?>" type="text" name="dimensoes" value="<?php echo $dist->dimensoes; ?>" class='span12' />

																<input id="idDistribuir<?php echo $dist->idDistribuir; ?>" type="hidden" name="idDistribuir" value="<?php echo $dist->idDistribuir; ?>" />

															</div>

															<div class="control-group"><br>PN <font size='1'> (digitar o PN especifico da peça que esta comprando o material acima)</font>
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
														</div>
														<div class="modal-footer">
															<button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
															<button class="btn btn-primary">Alterar</button>
														</div>
													</form>
												</div>
											</div>

											<script type="text/javascript">
												$(document).ready(function() {

													//console.log('#idInsumos2');
													$("#term" + <?php echo $dist->idDistribuir; ?>).autocomplete({
														source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
														minLength: 1,
														select: function(event, ui) {
															//alert($('#idInsumos').val(ui.item.id));
															$('#idInsumos' + <?php echo $dist->idDistribuir; ?>).val(ui.item.id);
															$('#estoque' + <?php echo $dist->idDistribuir; ?>).val(ui.item.estoque);

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
										<?php


											}
										?>


										</tbody>
									</table>
								</div>
							</div>







						</div><!-- div principal ao entrar -->




						<!--<div class="widget-content" id="printOs">
                <div class="invoice-content">
                  ddd
              
                </div>
            </div>-->
					</div>

				</div>


				.

			</div>

		</div>
	</div>
</div>





<!-- cadastgrar nf -->
<div id="modalinserir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="<?php echo base_url(); ?>index.php/os/cad_distribuir" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Cadastrar Item OS: <?php echo $result->idOs; ?></h3>			
			<a  'href="#modal-cadastrarInsumo" role="button" 'data-toggle="modal" onclick="openmodal()" class="btn btn-success" style="height: 20px"><i class="icon-plus icon-white"></i> Cadastrar Insumo</a>							
		</div>
		<div class="modal-body">

			<div class="control-group">
				Descrição <input id="term2" type="text" name="term2" value="" class='span12' />


				<input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
				<input id="idInsumos2" type="hidden" name="idInsumos2" value="" />

			</div>
			<div class="control-group">
				Quantidade em Estoque:
				<input id="estoque" type="text" name="estoque" value="" readonly /><br>
				<!--<font red='red' size='1'>*Se a qtd solicitada for maior que o estoque, será gerado 2 itens automaticamente, 1 para solicitar ao estoque outro para solicitar compra</font>-->

			</div>

			<div class="control-group"><br>
				Quantidade:<input id="quantidade" type="text" name="quantidade" value="" class='' />

				Dimensões: <input id="dimensoes" type="text" name="dimensoes" value="" class='span6' />

			</div>
			<div class="control-group">




			</div>


			<div class="control-group"><br>PN <font size='1'> (digitar o PN especifico da peça que esta comprando o material acima)</font>
				<input type="hidden" id="idProdutos" name="idProdutos" size="3" value="0" />
				<input type="text" id="pn" name="pn" size="97" ref="autocomplete" class="span12" value="" />

			</div>
			<div class="control-group"><br>Especifique o Grupo
				<select class="recebe-solici" class="controls" style="font-size: 10px;" name="idgrupo" id="idgrupo">
					<option value="0">---</option>
					<?php foreach ($dados_statusgrupo as $so) { ?>

						<option value="<?php echo $so->idgrupo; ?>"><?php echo $so->nomegrupo; ?></option>
					<?php } ?>


				</select>
			</div>
			<div class="control-group">
				<br>OBS <textarea id="obs" rows="5" cols="5" class="span6" name="obs"></textarea>



			</div>

		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
			<button class="btn btn-success">Cadastrar</button>
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
			},
		})



	}

	function openmodal(){
		$('#modalinserir').modal('hide');
		$('#modal-cadastrarInsumo').modal('show');
	}

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
			source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
			minLength: 1,
			select: function(event, ui) {
				$('#idInsumos2').val(ui.item.id);
				if(ui.item.estoque){
					$('#estoque').val(ui.item.estoque);
				}else{
					$('#estoque').val(0);
				}
				


			}
		});



	});

	$(document).ready(function() {

		//console.log('#idInsumos2');
		$("#pn").autocomplete({
			source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
			minLength: 1,
			select: function(event, ui) {
				$('#idProdutos').val(ui.item.id);



			}
		});


	});
</script>