<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<!--<script src="<?php echo base_url(); ?>js/jquery.mask.min.js"></script>-->
<!--<script src="<?php echo base_url(); ?>js/maskmoney.js"></script>-->
<!--<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.10.2.min.js"></script>-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">


<!--<body onload="calculaSubTotal();">-->

<body onLoad="calculaSubTotal();">
	<!--<form action="<?php echo base_url() ?>index.php/orcamentos/adicionarorcamento" id="formOrcamento" method="post"  >-->

	<div align='right'>
		<script type="text/javascript">
			window.addEventListener('keydown', function(e) {
				if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
					if (e.target.nodeName == 'INPUT' && e.target.type == 'text') {
						e.preventDefault();
						return false;
					}
				}
			}, true);
		</script>
		<script>
			//document.addEventListener("keydown", function(e) {
			// if(e.keyCode === 13) {

			// e.preventDefault();

			//}
			//});
		</script>
		<form action="<?php echo base_url() ?>index.php/orcamentos/orcCustom" method="get" target="_blank" id='form'>
			<button class="btn btn-inverse tip-top"><i class="icon-print icon-white"></i></button>
			Data:<input type='date' name='dataInicial' value='' class="span2" class="control-group">
			<input type='hidden' name='idOrcamentos' value='<?php echo $result->idOrcamentos; ?>'>
			<?php
			if ($result->status_orc == 0) {


				if ($this->permission->checkPermission($this->session->userdata('permissao'), 'APOrcamento')) {
					echo '<a href="' . base_url() . 'index.php/orcamentos/aprovar/' . $result->idOrcamentos . '" style="margin-right: 1%" class="btn btn-success tip-top" ><i class="icon-ok icon-white"></i>Aprovar</a>';
				}
			}
			?>
		</form>

	</div>
	<div class="row-fluid" style="margin-top:0">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="icon-tags"></i>
					</span>
					<h5>Editar de Orçamento - Data Orçamento: <?php echo date("d/m/Y H:i:s", strtotime($result->data_abertura)); ?></h5>



				</div>
				<form action="<?php echo current_url(); ?>" id="formOrcamento" method="post">
					<div class="widget-content nopadding">


						<div class="span12" id="divProdutosServicos" style="padding: 0.2%; margin-left: 0">
							<ul class="nav nav-tabs">
								<li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes do orçamento <b>NÚMERO: <?php echo $result->idOrcamentos; ?></b></a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab1">

									<div class="span12" id="divCadastrarOs">
										<?php if ($custom_error != '') {
											echo '<div class="alert alert-danger">' . $custom_error . '</div>';
										} ?>



										<div class="span12" style="padding: 0.2%; margin-left: 0">
											<div class="span4" class="control-group">
												<label for="idEmitente" class="control-label"><span class="required">*</span>Emitente:</label>

												<select class="span12 form-control" name="idEmitente">

													<?php foreach ($dados_emitente as $e) { ?>

														<option value="<?php echo $e->id; ?>" <?php if ($e->id == $result->idEmitente) {
																									echo "selected='selected'";
																								} ?>><?php echo $e->nome; ?></option>
													<?php } ?>

												</select>
											</div>
											<div class="span6" class="control-group">

												<label for="cliente"><span class="required">*</span>Cliente</label>
												<input id="cliente" class="span12" class="controls" type="text" name="cliente" value="<?php echo $result->nomeCliente; ?> | CNPJ:<?php echo $result->documento; ?>" size='50' />
												<input id="clientes_id" type="hidden" name="clientes_id" value="<?php echo $result->idClientes; ?>" />
											</div>
											<div class="span2" class="control-group">

												<label for="idSolicitante" class="control-label"><span class="required">*</span>Solicitante:</label>

												<select class="span12 recebe-solici" class="controls" name="idSolicitante" id="idSolicitante">
													<?php foreach ($dados_solicitante as $so) { ?>

														<option value="<?php echo $so->idSolicitante; ?>" <?php if ($so->idSolicitante == $result->idSolicitante) {
																												echo "selected='selected'";
																											} ?>><?php echo $so->nome; ?></option>
													<?php } ?>




												</select>
											</div>
										</div>
										<div class="span12" style="padding: 0.2%; margin-left: 0">
											<div class="span3" class="control-group">
												<label for="idstatusOrcamento" class="control-label"><span class="required">*</span>Status Orçamento:</label>

												<select class="span12 form-control" name="idstatusOrcamento">

													<?php foreach ($dados_statusorcamento as $o) { ?>

														<option value="<?php echo $o->idstatusOrcamento; ?>" <?php if ($o->idstatusOrcamento == $result->idstatusOrcamento) {
																													echo "selected='selected'";
																												} ?>><?php echo $o->nome_status_orc; ?></option>
													<?php } ?>

												</select>
											</div>
											<div class="span2" class="control-group">

												<label for="idVendedor" class="control-label"><span class="required">*</span>Vendedor:</label>

												<select class="span12 form-control" name="idVendedor">

													<?php foreach ($dados_vendedor as $v) { ?>

														<option value="<?php echo $v->idVendedor; ?>" <?php if ($v->idVendedor == $result->idVendedor) {
																											echo "selected='selected'";
																										} ?>><?php echo $v->nomeVendedor; ?></option>
													<?php } ?>

												</select>
											</div>
											<div class="span2" class="control-group">
												<label for="idGerente" class="control-label"><span class="required">*</span>Gerente:</label>

												<select class="span12 form-control" name="idGerente">

													<?php foreach ($dados_gerente as $g) { ?>

														<option value="<?php echo $g->idGerente; ?>" <?php if ($g->idGerente == $result->idGerente) {
																											echo "selected='selected'";
																										} ?>><?php echo $g->nome; ?></option>
													<?php } ?>

												</select>

											</div>

											<div class="span2" class="control-group">
												<label for="idGrupoServico" class="control-label"><span class="required">*</span>Grupo Serviço:</label>

												<select class="span12 form-control" name="idGrupoServico">

													<?php foreach ($dados_gruposervico as $gs) { ?>

														<option value="<?php echo $gs->idGrupoServico; ?>" <?php if ($gs->idGrupoServico == $result->idGrupoServico) {
																												echo "selected='selected'";
																											} ?>><?php echo $gs->nome; ?></option>
													<?php } ?>

												</select>
											</div>
											<div class="span3" class="control-group">
												<label for="idNatOperacao" class="control-label"><span class="required">*</span>Nat. Operação:</label>

												<select class="span12 form-control" name="idNatOperacao">

													<?php foreach ($dados_natoperacao as $nt) { ?>

														<option value="<?php echo $nt->idNatOperacao; ?>" <?php if ($nt->idNatOperacao == $result->idNatOperacao) {
																												echo "selected='selected'";
																											} ?>><?php echo $nt->nome; ?></option>
													<?php } ?>

												</select>
											</div>
										</div>

										<div class="span12" style="padding: 0.2%; margin-left: 0">

											<div class="span1" class="control-group">

												<label for="referencia" class="control-label">Val. Prop.:</label>

												<input id="validade" class="span12" type="text" name="validade" value="<?php echo $result->validade; ?>" size='15' />
											</div>


											<div class="span3" class="control-group">
												<label for="cond_pgto" class="control-label">Condição Pagamento:</label>

												<input class="span12" id="cond_pgto" type="text" name="cond_pgto" value="<?php echo $result->cond_pgto; ?>" size="50" />
											</div>
											<div class="span2" class="control-group">
												<label for="cond_pgto" class="control-label">Garantia Serv.</label>

												<input class="span12" id="garantia_servico" type="text" name="garantia_servico" value="<?php echo $result->garantia_servico; ?>" size="50" />
											</div>
											<div class="span3" class="control-group">
												<label for="entrega" class="control-label">Entrega: <input style="margin: 0px;" type="radio" name="entrega" <?php if ($result->entrega == 'FOB') {
																						echo "checked='yes'";
																					} ?> VALUE="FOB" />FOB
												<input style="margin: 0px;" type="radio" name="entrega" <?php if ($result->entrega == 'CIF') {
																						echo "checked='yes'";
																					} ?> VALUE="CIF" />CIF
												<input style="margin: 0px;" type="radio" name="entrega" VALUE="OUTRO" <?php if ($result->entrega == 'OUTRO') {
																										echo "checked='yes'";
																									} ?> />Outro</label>

												 <input class="span12" id="entregaoutros" type="text" name="entregaoutros" value="<?php echo $result->entregaoutros; ?>" size="50" />
											</div>
											<div class="span3" class="control-group">

												<label for="referencia" class="control-label">Referência:</label>

												<input id="referencia" class="span12" type="text" name="referencia" value="<?php echo $result->referencia; ?>" />
											</div>
										</div>
										<div class="span12" style="padding: 0.2%; margin-left: 0">
											<div class="span2" class="control-group">
												<label for="num_pedido" class="control-label">Num. Pedido:</label>

												<input id="num_pedido" class="span12" type="text" name="num_pedido" value="<?php echo $result->num_pedido; ?>" />
											</div>


											<div class="span2" class="control-group">
												<label for="num_nf" class="control-label">Num. Nota Fiscal:</label>

												<input id="num_nf" type="text" name="num_nf" class="span12" value="<?php echo $result->num_nf; ?>" />
												<input id="idOrcamentos" type="hidden" name="idOrcamentos" value="<?php echo $result->idOrcamentos; ?>" />
											</div>
											<div class="span8" class="control-group">
												<label for="obs" class="control-label">OBS</label>

												<textarea id="obs" rows="5" cols="100" class="span12" name="obs"><?php echo $result->obs; ?></textarea>
											</div>
										</div>



									</div>

								</div>

							</div>

						</div>


						.

					</div>

			</div>
		</div>
	</div>

	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-user"></i>
			</span>
			<h5>Cadastro de Itens </h5>
			<!--<a href="#" onclick="duplicarCampos();calculaSubTotal();" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Itens</a>-->
			<a href="#modal-adicionaritem" style="margin-right: 1%" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-plus icon-white"></i>Adicionar Itens</a>
			<b>ORÇAMENTO NÚMERO: <?php echo $result->idOrcamentos; ?></b>																						

		</div>

		<div class="widget-content nopadding">


			<table class="table table-bordered ">
				<tbody>


					<?php
					$contador_local_autocomplete = 0;
					foreach ($dados_item as $orc_item) {
						if ($contador_local_autocomplete > 0) {
							//echo '<div class="span12" style="/*! border: 1px solid; */padding: 0.2%; margin-left: 0;border-bottom:  1px solid #cdcdcd;margin-bottom: 20px;"></div>';
						}
						$produtoInsumo = $this->producao_model->getCustoInsumoPorPN($orc_item->idProdutos);	
						if (empty($produtoInsumo)) {							
							$resultIns = 0;
						}else{
							$resultIns = $produtoInsumo->somaInsumos/$produtoInsumo->qtd_os;
						}			
						$produtoHrMaq = $this->producao_model->getCustoHrMaqPorPN($orc_item->idProdutos);
						if (!empty($produtoHrMaq)) {
							$horas = 0;
							foreach ($produtoHrMaq as $r) {
								$hrEntrFab = new DateTime($r->horaEntradaFabricacao);
								$hrSaidFab = new DateTime($r->horaSaidaFabricacao);
								$diffDataFabricacao = $hrSaidFab->diff($hrEntrFab);
								//$e = new DateTime('00:00');
								$minutos = $diffDataFabricacao->i / 60;
								$horas = $minutos + $diffDataFabricacao->h + $horas;


								$hrEntrPre = new DateTime($r->horaEntradaPreparacao);
								$hrSaidPre = new DateTime($r->horaSaidaPreparacao);
								$diffDataPreparacao = $hrSaidPre->diff($hrEntrPre);
								//$e = new DateTime('00:00');
								$minutos = $diffDataPreparacao->i / 60;
								$horas = $minutos + $diffDataPreparacao->h + $horas;
							}
							$valor = $horas * 300;
							$valor = $valor / $result[0]->qtd_os;
						} else {
							$valor = 0;
						}
						$produtoIcms = $this->producao_model->getCustoICMSPorPN($orc_item->idProdutos);
						if (empty($produtoIcms)) {
							$resultIcms = 0;
						}else{
							$resultIcms = $produtoIcms->somaIcms/$produtoIcms->qtd_os;	
						}
						$produtoFrete = $this->producao_model->getCustoFretePorPN($orc_item->idProdutos);
						$valorFrete = 0;
						foreach ($produtoFrete as $r) {
							$valorFrete = $valorFrete + (($r->frete / $r->quantidadeProdutos) * $r->quantidadeProdutosOs);
						}
						if (isset($produtoFrete[0]->qtd_os)) {
							$somaFrete = number_format((float)$valorFrete / $produtoFrete[0]->qtd_os, '2', ',', '.');
						} else {
							$somaFrete = 0;
						}
						$possuiEscopo = false;
						if($orc_item->tipoOrc == "serv"){
							$statusEscopo = "";
							$escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($orc_item->idOrcamento_item);
							if(!empty($escopo)){
								$possuiEscopo = true;
								$statusEscopo = $escopo->descricaoPeritagem;
								$escopoItens = $this->peritagem_model->itensPeritagem($escopo->idOrcServicoEscopo);
							}else{
								$escopo = $this->peritagem_model->getEscopoByIdProdutoAndTipoProd($orc_item->tipoProd,$orc_item->idProdutos);
								echo '<script>console.log('.json_encode($escopo).')</script>';
								if(!empty($escopo)){
									$escopoItens = $this->peritagem_model->getEscopoItensByIdEscopo($escopo[0]->idServicoEscopo);
								}else{
									if($orc_item->tipoOrc == 'serv' && $orc_item->tipoProd == 'cil'){
										$escopo = 1;
										$escopoItens = $this->peritagem_model->getEscopoItensByIdEscopo(1);
									}
								}
								$statusEscopo = "Não Selecionado.";
							}
						}
						
						$catalogoCheck = $this->peritagem_model->getCatalogoAtivosByIdProduto($orc_item->idProdutos);
						if(!empty($catalogoCheck)){
							$checklistProdu = $this->peritagem_model->getCatalogoItensByIdCatalogo($catalogoCheck[0]->idCatalogoProduto);									
						}
						echo '<tr class="trpai'.$contador_local_autocomplete.'">';
							echo '<td onclick="openclose(this,'.$contador_local_autocomplete.')" style="text-align: center; /* padding: 75px 5px 75px 5px */ display: table-cell;min-height: 10em;vertical-align: middle;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';							
							echo '<td style="/* padding: 50px 5px 50px 5px */ "><div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">';
								echo '<input type="hidden" id="id_orc_item_' . $contador_local_autocomplete . '" name="id_orc_item[]"   value="' . $orc_item->idOrcamento_item . '"/>' .
									'<div class="span12" style="padding: 0.2%; margin-left: 0">' .
									'<div class="span2">' .
									'<label><b>PN </b> (master):</label>' .
									'<input type="text" class="span12" id="pn_' . $contador_local_autocomplete . '" name="pn[]" value="' . $orc_item->pn . '" />' .
									'<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>' .
									'<input type="hidden" id="idProdutos_' . $contador_local_autocomplete . '" name="idProdutos[]" size="3"   value="' . $orc_item->idProdutos . '"/>' .
									'<input type="hidden" id="idChecklist_' . $contador_local_autocomplete . '" name="idChecklist[]" size="3"   value="' . $orc_item->idCatalogo . '"/>' .
									'</div>' .
									'<div class="span1">' .
									'<label>Orç.:</label>' .
									'<select id="orc_' . $contador_local_autocomplete . '" onchange="verificarEscopo(' . $contador_local_autocomplete . ')" name="orc[]" class="span12">';
								if ($orc_item->tipoOrc == 'fab') {
									echo '<option selected value="fab">FAB</option>';
								} else {
									echo '<option value="fab">FAB</option>';
								}
								if ($orc_item->tipoOrc == 'serv') {
									echo '<option selected value="serv">SERV</option>';
								} else {
									echo '<option value="serv">SERV</option>';
								}
		
								echo '</select>' .
									'</div>' .
									'<div class="span2">' .
									'<label>Tipo de Prod.:</label>' .
									'<select id="tipo_prod_' . $contador_local_autocomplete . '" onchange="verificarEscopo(' . $contador_local_autocomplete . ')" name="tipo_prod[]" class="span12">';
								if ($orc_item->tipoProd == 'cil') {
									echo '<option selected value="cil">Cilindro</option>';
								} else {
									echo '<option value="cil">Cilindro</option>';
								}
								if ($orc_item->tipoProd == 'maq') {
									echo '<option selected value="maq">Máquina</option>';
								} else {
									echo '<option value="maq">Máquina</option>';
								}
								if ($orc_item->tipoProd == 'pec') {
									echo '<option selected value="pec" >Peça</option>';
								} else {
									echo '<option value="pec">Peça</option>';
								}
								if ($orc_item->tipoProd == 'sub') {
									echo '<option selected value="sub">Subconjunto</option>';
								} else {
									echo '<option value="sub">Subconjunto</option>';
								}
		
								echo '</select>' .
									'</div>' .									
									'<div class="span5">' .
									'<label>Descrição:</label>' .
									'<input type="text" class="span12" id="descricao_item_' . $contador_local_autocomplete . '" name="descricao_item[]"  value="' . $orc_item->descricao_item . '" />' .
									'</div>' .
									'<div class="span1">' .
									'<label>Tag:</label>' .
									'<input type="text" class="span12" id="tag_' . $contador_local_autocomplete . '" name="tag[]"  value="' . $orc_item->tag . '" />' .
									'</div>' .
									'<div class="span1">' .
									'<label><b>Qtd. Estq.</b>:</label>' .
									'<input type="text" class="span12" id="qtdest_' . $contador_local_autocomplete . '" name="qtdest[]"  value="" disabled/>' .
									'</div>' .
									'</div>' ;
							echo '</div></td>';
							echo '<td style="text-align: center; /* padding: 75px 5px 75px 5px */ display: table-cell;min-height: 10em;vertical-align: middle;">';
								echo '<a href="#modal-excluir" role="button" data-toggle="modal" produto="'.$orc_item->idOrcamento_item.'" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>';
							//echo '<a href="#"  onclick="removerCampos(this,'.$contador_local_autocomplete.');" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>' ;
							echo '</td>';
						echo '</tr>';
						echo '<tr class="trfilho'.$contador_local_autocomplete.'" style="display:none">';
							echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;"> ';								
							echo '</td>';
							echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">';
								echo '<div >';
									echo '<div class="span12" style="padding: 0.2%; margin-left: 0">' .
										'<div class="span2">' .
										'<label>Ultima O.S.:</label>' .
										'<input type="text" class="span12" id="cOs_' . $contador_local_autocomplete . '" name="cOs[]" value="" disabled/> ' .
										'</div>' .
										'<div class="span2">' .
										'<label>Custo Insumo:</label>' .
										'<input type="text" class="span12" id="custoIns_' . $contador_local_autocomplete . '" name="custoIns[]"  value="' . number_format($resultIns, 2, ",", ".") . '" disabled/>' .
										'</div>' .
										'<div class="span2">' .
										'<label>Custo HR/Maq</label>' .
										'<input type="text" class="span12" id="custoFab_' . $contador_local_autocomplete . '" name="custoFab[]"  value="' . number_format((float)$valor, 2, ",", ".") . '" disabled/>' .
										'</div>' .
										'<div class="span2">' .
										'<label>Custo Impostos</label>' .
										'<input type="text" class="span12" id="custoIcms_' . $contador_local_autocomplete . '" name="custoIcms[]"  value="' . number_format((float)$resultIcms, 2, ",", ".") . '" disabled/>' .
										'</div>' .
										'<div class="span2">' .
										'<label>Custo Frete</label>' .
										'<input type="text" class="span12" id="custoFrete_' . $contador_local_autocomplete . '" name="custoFrete[]"  value="' . number_format((float)$somaFrete, 2, ",", ".") . '" disabled/>' .
										'</div>' .
										'<div class="span2">' .
										'<label>Custo Total</label>' .
										'<input type="text" class="span12" id="custoTotal_' . $contador_local_autocomplete . '" name="custoTotal[]"  value="' . number_format((($resultIns) + $valor + ($resultIcms) + $somaFrete) * $orc_item->qtd, 2, ",", ".") . '" disabled/>' .
										'</div>' .
										'</div>' .
										'<div class="span12" style="padding: 0.2%; margin-left: 0">' .
										'<div class="span1">' .
										'<label>QTD:</label>' .
										'<input type="text" class="span12" id="qtd_' . $contador_local_autocomplete . '" name="qtd[]" onblur="calculaSubTotal(' . $contador_local_autocomplete . ');" onclick="this.select();" value="' . $orc_item->qtd . '" />' .
										'</div>' .
										'<div class="span2">' .
										'<label>Vl.Unit.:</label>' .
										'<input type="text" class="span12" id="val_unit_' . $contador_local_autocomplete . '" name="val_unit[]" onKeyUp="calculaSubTotal(' . $contador_local_autocomplete . ');"   onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" value="' . number_format($orc_item->val_unit, 2, ",", ".") . '"/> ' .
										'</div>' .
										'<div class="span2">' .
										'<label>Sub.Tot.:</label>' .
										'<input type="text" class="span12" id="subtot_' . $contador_local_autocomplete . '" name="subtot[]" value="' . number_format($orc_item->subtot, 2, ",", ".") . '" readonly/>' .
										'</div>' .
										'<div class="span1">' .
										'<label>Prazo:</label>' .
										'<input type="text" class="span12" id="prazo_' . $contador_local_autocomplete . '" name="prazo[]" onclick="this.select()"; value="' . $orc_item->prazo . '" /> ' .
										'</div> ' .
										'<div class="span1">' .
										'<label>Frete:</label>' .
										'<input type="text" class="span12" id="frete_' . $contador_local_autocomplete . '" name="frete[]" value="' . number_format($orc_item->frete, 2, ",", ".") . '" onKeyUp="calculaSubTotal(' . $contador_local_autocomplete . ');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />' .
										'</div>' .
										'<div class="span2">' .
										'<label>Desconto:</label>' .
										'<input type="text" class="span12" id="desconto_' . $contador_local_autocomplete . '" name="desconto[]" value="' . number_format($orc_item->desconto, 2, ",", ".") . '" onKeyUp="calculaSubTotal(' . $contador_local_autocomplete . ');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />' .
										'</div>' .
										'<div class="span1">' .
										'<label>IPI%:</label>' .
										'<input type="text" class="span12" id="val_ipi_' . $contador_local_autocomplete . '" name="val_ipi[]" value="' . number_format($orc_item->val_ipi, 2, ",", ".") . '" onKeyUp="calculaSubTotal(' . $contador_local_autocomplete . ');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />' .
										'</div>' .
										'<div class="span2">' .
										'<label>Valor Tot.:</label>' .
										'<input type="text" class="span12" id="vlr_total_' . $contador_local_autocomplete . '" name="vlr_total[]" value="' . number_format($orc_item->valor_total, 2, ",", ".") . '" />' .
										'</div>' .
										'</div>' .
										'<div class="span12" style="padding: 0.2%; margin-left: 0">' .
										'<div class="span8">' .
										'<label>Detalhamento: </label>' .
										'<textarea id="detalhe_' . $contador_local_autocomplete . '"  cols="50" value="' . $orc_item->detalhe . '" class="span12" name="detalhe[]"></textarea>' .
										'</div>'.										
										'<div class="span4" id="divSelectFab_'.$contador_local_autocomplete.'">'; /*
										if ($orc_item->tipoOrc == 'fab') {
											echo '<label>Checklist</label>'.
												'<select id="catalogoProduto_'.$contador_local_autocomplete.'" class="span12" onchange="buscarCatalogo(this,'.$contador_local_autocomplete.')">'.
												'<option value=""> Selecione um checklist</option>';
											foreach($orc_item->catalogoItens as $b){
												if($b->idCatalogoProduto == $orc_item->idCatalogo){
													echo '<option selected value="'.$b->idCatalogoProduto.'">'.$b->descricaoCatalogo.'</option>';
												}else{
													echo '<option value="'.$b->idCatalogoProduto.'">'.$b->descricaoCatalogo.'</option>';
												}
												
											}
											echo '</select>';
										}*/
										echo '</div>';									
										
										if ($orc_item->tipoOrc == 'serv') {
											echo '<div class="span4" "style="margin-top: 20px;">' .
												'<label>Status Escopo</label>'.
												'<input class="span6" type="text" readonly value="'.$statusEscopo.'"></br>';
												$orcServicoEscopo2 = $this->peritagem_model->getOrcEscopoActiveByOrcItem($orc_item->idOrcamento_item);
											if(!empty($orcServicoEscopo2)){
												
												echo '<div style="margin-top: 5px"><a href="'.base_url().'index.php/orcamentos/escopo/'.$orc_item->idOrcamento_item.'/'.$orcServicoEscopo2->idServicoEscopo.'" role="button" class="btn btn-success"  class="span12" >Escopo</a>' ;
											}else{
												echo '<div style="margin-top: 5px"><a href="#modal-escopo-' . $contador_local_autocomplete . '" role="button" data-toggle="modal" class="btn btn-warning"  class="span12" >Escopo</a>' ;
											}											
											echo '<a href="' . base_url() . 'index.php/peritagem/laudofotografico/' . $orc_item->idOrcamento_item . '" role="button" data-toggle="modal" class="btn btn-warning"  class="span12" style="margin-left: 10px;">Laudo Fotográfico</a><a href="#modal-desenho-' . $contador_local_autocomplete . '" role="button" data-toggle="modal" style="margin-left: 10px;" class="btn btn-warning"  class="span12" >Anexo desenho</a></div>' .
												'</div>';
										}
									echo '</div>' .
										'</div> ';
								echo '</div>';
								
								echo '<div id="escopo_'.$contador_local_autocomplete.'">';
									
										if(!empty($escopo)){
											echo '<h5>Checklist</h5>';
											echo '<table class="table table-bordered ">'.
												'<thead>'.
													'<tr>'.
														'<th>PN</th>'.
														'<th>DESCRIÇÃO</th>'.
														'<th>CLASSE</th>'.
														'<th>QTD</th>'.
														'<th>Ø EXT.</th>'.
														'<th>Ø INT.</th>'.
														'<th>COMP.</th>'.
														'<th>OBS.</th>'.
														'<th>Valor Unit.</th>'.
														'<th>Valor Total</th>'.
													'</tr>'.                            
												'</thead>'.
												'<tbody>';
												foreach($escopoItens as $r){
													if(!empty($r->idOrcServicoEscopo)){
														echo '<tr>'.
															'<input type="hidden" name="idOrcEscopo[]" value="'.$orc_item->idOrcamento_item.'">'.
															'<input type="hidden" name="idOrcServicoEscopo[]" value="'.$r->idOrcServicoEscopo.'">'.
															'<td>'.$r->pn.'</td>'.
															'<td>'.$r->descricaoServicoItens.'</td>'.
															'<td>'.$r->descricaoClasse.'</td>';            
																echo '<td>'.$r->quantidade.'</td>';               
																echo '<td>'.$r->dimenExt.'</td>';             
																echo '<td>'.$r->dimenInt.'</td>';         
																echo '<td>'.$r->dimenComp.'</td>';   
																echo '<td>'.$r->obs.'</td>';
																echo '<td style="width:10%"><input type="text" class="money span12" name="valorOrcItem[]" id="valor" readonly value="'.number_format($r->valorUnitario, 2, ",", ".").'"></td>';
																echo '<td>R$ '.number_format($r->valorUnitario*$r->quantidade, 2, ",", ".").'</td>';
														'</tr>';
													}else if(!empty($escopoItens)){
														echo '<tr>'.
															'<input type="hidden" name="idNovoOrcEscopo[]" value="'.$orc_item->idOrcamento_item.'">'.
															'<td>'.$r->pn.'</td>'.
															'<td>'.$r->descricaoServicoItens.'<input type="hidden" name="idServicoEscopoItens[]" id="idServicoEscopoItens'.$r->idServicoEscopoItens.'" value="'.$r->idServicoEscopoItens.'"></td></td>'.
															'<td>'.$r->descricaoClasse.'</td>';															
																echo '<td></td>';															
																echo '<td></td>';
																echo '<td></td>';															
																echo '<td></td>';															
																echo '<td></td>';
																echo '<td style="width:10%"><input type="text" class="money span12" name="valorOrcItem[]" id="valor" readonly value="0,00"></td>';															
																echo '<td>R$ 0,00</td>';															
														'</tr>';
													}
													 
												}
												echo '</tbody>'.
											'</table>';	
										}else if(!empty($checklistProdu)){
											echo '<h5>Checklist</h5>';
											echo '<table class="table table-bordered ">'.
												'<thead>'.
													'<tr>'.
														'<th>PN</th>'.
														'<th>DESCRIÇÃO</th>'.
														'<th>QTD</th>'.
													'</tr>'.                            
												'</thead>'.
												'<tbody>';
											foreach($checklistProdu as $r){
												echo '<tr>
														<td>'.$r->pn.'</td>
														<td>'.$r->descricao.'</td>
														<td>'.$r->quantidade.'</td>
													</tr>';
											}
												echo '</tbody>';
											echo '</table>';
										}
                        		echo '</div>';
							echo '</td>';
							echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;"> ';
								
							echo '</td>';
						echo '</tr>';
						
						


					?>

						<script type="text/javascript">
							$(document).ready(function() {
								//alert(<?php echo $contador_local_autocomplete; ?>);
								//var contador_local_autocomplete=contador_global_autocomplete;
								console.log('#idProdutos_' + <?php echo $contador_local_autocomplete; ?>);
								/*$("#pn_"+<?php echo $contador_local_autocomplete; ?>).autocomplete({
									source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
									minLength: 1,
									select: function( event, ui ) {
										$('#idProdutos_'+<?php echo $contador_local_autocomplete; ?>).val(ui.item.id);

									}
								});*/
								$("#pn_" + <?php echo $contador_local_autocomplete; ?>).autocomplete({
									source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN_2",
									minLength: 1,
									select: function(event, ui) {
										$('#idProdutos_' + <?php echo $contador_local_autocomplete; ?>).val(ui.item.id);
										$('#descricao_item_' + <?php echo $contador_local_autocomplete; ?>).val(ui.item.no);
										if($( "#orc_"+<?php echo $contador_local_autocomplete; ?> ).val() == "serv"){
											$("#idChecklist_"+<?php echo $contador_local_autocomplete; ?>).val("");
										}else if($( "#orc_"+<?php echo $contador_local_autocomplete; ?> ).val() == "fab"){
											$.ajax({
												url: "<?php echo base_url(); ?>index.php/peritagem/getcatalogoproduto",
												type: 'POST',
												dataType: 'json',
												data: {
													idProduto: ui.item.id
												},
												success: function(data) {
													$("#escopo_"+<?php echo $contador_local_autocomplete; ?>).empty();
													if(data.resultado.length > 0){
														var variavel = {value:data.resultado[0].idCatalogoProduto}
														buscarCatalogo(variavel,<?php echo $contador_local_autocomplete; ?>);
														$("#idChecklist_"+<?php echo $contador_local_autocomplete; ?>).val(variavel.value);
													}
													//preencherTabelaCatalogo(pos,data.resultado);
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
									}
								});
								/*
		$("#btnEscopo<?php echo $contador_local_autocomplete; ?>").click(function(){
			document.getElementById("formEscopo<?php echo $contador_local_autocomplete; ?>").submit();
    	})*/


								$(document).on('click', 'a', function(event) {

									var produto = $(this).attr('produto');
									$('#item_produt').val(produto);

								});

							});




						</script>

					<?php
						$contador_local_autocomplete++;
					}

					?>
					<!--
					<div id="destino" class="span12" style="padding: 0.2%; margin-left: 0"></div>

					<a href="#modal-adicionaritem" style="margin-right: 1%" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-plus icon-white"></i>Adicionar Itens</a>-->
					<script type="text/javascript">
						var contador_global_autocomplete = <?php echo $contador_local_autocomplete; ?>;

						var contador_local_autocomplete = contador_global_autocomplete;

					</script>

				</tbody>
			</table>

		</div>

	</div>

	<div class="widget-box" class="span12">

		<table align='right' border='0' width='40%'>
			<tr>
				<td align='right'>
					SUBTOTAL R$:
				</td>
				<td align='center'>
					<input name="subtotal_calculo" type="text" id="subtotal_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
				</td>


			</tr>
			<tr>
				<td align='right'>
					DESCONTO R$:
				</td>
				<td align='center'>
					<input name="desconto_calculo" type="text" id="desconto_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
				</td>
			</tr>
			<tr>
				<td align='right'>
					VALOR IPI R$:
				</td>
				<td align='center'>
					<input name="ipi_calculo" type="text" id="ipi_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
				</td>
			</tr>
			<tr>
				<td align='right'>
					<B>TOTAL ORÇAMENTO R$:</B>
				</td>
				<td align='center'>
					<B>
						<input name="total_calculo" type="text" id="total_calculo" style="font-family: Arial; font-weight: bold; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">

					</B>
				</td>
			</tr>
		</table>
	</div><br><br><br>
	<div class="form-actions" align='center'>

		<button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Salvar</button>
		<a href="<?php echo base_url() ?>index.php/orcamentos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>

	</div>


	</form>
	


	<script type="text/javascript">
		$(document).ready(function() {

			<?php
			// $contador_local_autocomplete = 0;
			//$i = 0;
			//foreach ($dados_item as $orc_item) { 

			//$valorunita = corrigiValorBancoJavasScript($orc_item->val_unit);
			//$sub = corrigiValorBancoJavasScript($orc_item->subtot);
			//echo "alert('".$sub."')" ;

			?>


			//var contador_local_autocomplete=contador_global_autocomplete;

			/*var cloneDiv = '<div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">' +
	'<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>'+
	'<input type="text" id="id_orc_item_'+contador_local_autocomplete+'" name="id_orc_item[]"   value="'+<?php echo $orc_item->idOrcamento_item; ?>+'"/>'+
	'<input type="hidden" id="idProdutos_'+contador_local_autocomplete+'" name="idProdutos[]" size="3"   value="'+<?php echo $orc_item->idProdutos; ?>+'"/>'+
	'Cod. | Descrição | <b>PN</b>:&nbsp;<input type="text" id="pn_'+contador_local_autocomplete+'" name="pn[]" size="97" ref="autocomplete"  value="Cod.: <?php echo $orc_item->idProdutos; ?> | Descrição: <?php echo $orc_item->descricao; ?> | PN: <?php echo $orc_item->pn; ?>" />'+
	'<br>'+
	'QTD:&nbsp;<input type="text" onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete; ?>+')" id="qtd_'+contador_local_autocomplete+'" name="qtd[]" size="1"  value="'+<?php echo $orc_item->qtd; ?>+'" onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete; ?> +')"/>&nbsp;&nbsp;&nbsp;'+
	'Vl.Unit.:&nbsp;<input type="text" id="val_unit_'+contador_local_autocomplete+'" name="val_unit[]" size="8"  onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete; ?> +')" value="'+<?php echo $orc_item->val_unit; ?> +'" class="money"/>&nbsp;&nbsp;&nbsp;'+
	'Sub.Tot.:&nbsp;<input type="text" id="subtot_'+contador_local_autocomplete+'" name="subtot[]" size="8"  value="'+<?php echo $orc_item->subtot; ?>+'" class="money" readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'Prazo:&nbsp;<input type="text" id="prazo_'+contador_local_autocomplete+'" name="prazo[]" size="1"  value="'+<?php echo $orc_item->prazo; ?>+'"/>&nbsp;&nbsp;&nbsp;'+
	'Desconto.:&nbsp;<input type="text" id="desconto_'+contador_local_autocomplete+'" name="desconto[]" size="8"  value="'+<?php echo $orc_item->desconto; ?>+'" class="money"  onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete; ?>+')"/>&nbsp;&nbsp;&nbsp;'+
	'IPI%:&nbsp;<input type="text" id="val_ipi_'+contador_local_autocomplete+'" name="val_ipi[]" size="1"  value="'+<?php echo $orc_item->val_ipi; ?>+'"   onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete; ?>+')"/>&nbsp;&nbsp;&nbsp;'+
	'Valor Tot.:&nbsp;<input type="text" id="vlr_total_'+contador_local_autocomplete+'" name="vlr_total[]" size="8"  value="'+<?php echo $orc_item->valor_total; ?>+'"  readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'<br>	'+
	'Detalhamento: <textarea id="detalhe_'+contador_local_autocomplete+'" rows="5" cols="50" class="span10" name="detalhe[]"><?php echo $orc_item->detalhe; ?></textarea>'+	
	'<a href="#modal-excluir" role="button" data-toggle="modal" produto="'+<?php echo $orc_item->idOrcamento_item; ?>+'" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>'+
	'<hr>'+
	'</div>';
	

	
   
	$("#destino").append(cloneDiv);*/

			/*console.log('#idProdutos_'+contador_global_autocomplete);
	$("#pn_"+contador_global_autocomplete).autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutos_'+contador_local_autocomplete).val(ui.item.id);

		}
	});
	
	   $(document).on('click', 'a', function(event) {
        
        var produto = $(this).attr('produto');
        $('#item_produt').val(produto);

    });*/





			//contador_global_autocomplete = contador_global_autocomplete+1;

			//calculaSubTotal();





			<?php
			//$contador_local_autocomplete ++;
			?>



			<?php

			//}


			//if ( count($dados_item) == $contador_local_autocomplete) {
			?>
			//alert(<?= $contador_local_autocomplete ?>)
			//calculaSubTotal();

			<?php
			//}


			?>



			//calculaSubTotal();




			$("#cliente").autocomplete({
				source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteCliente",
				minLength: 1,
				select: function(event, ui) {

					$("#clientes_id").val(ui.item.id);

					getValor(ui.item.id);

				}
			});



			//duplicarCampos();


			/*$("#pn_0").autocomplete({
            source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
            minLength: 1,
            select: function( event, ui ) {

                 $("#idProdutos_0").val(ui.item.id);
                 
                
					

            }
      });*/



		});

		function numberToReal(numero) {
			var numero = numero.toFixed(2).split('.');
			numero[0] = "" + numero[0].split(/(?=(?:...)*$)/).join('');
			return numero.join(',');
		}

		function calculaSubTotal_(x) {
			var total_calculo = 0;
			var ipi_calculo = 0;
			var desconto_calculo = 0;
			var subtotal_calculo = 0;
			for (i = 0; i < contador_global_autocomplete; i++) {
				//alert($('#val_unit_'+i).val());
				if ($('#val_unit_' + i).val() != undefined) {

					$.ajax({

						url: '<?php echo base_url('index.php/orcamentos/calculartotais') ?>',
						dataType: 'json',
						type: 'POST',
						data: 'valorunit=' + $('#val_unit_' + i).val() + '&desconto=' + $('#desconto_' + i).val() + '&valoripi=' + $('#val_ipi_' + i).val() + '&qtd=' + $('#qtd_' + i).val() + '',
						success: function($json) {

							console.log($json);


							$('#subtot_' + i).val($json.subtot);
							$('#vlr_total_' + i).val($json.vlr_total);

							//alert($json.vlr_total);

							subtotal_calculo = subtotal_calculo + $json.total1;

							ipi_calculo = ipi_calculo + $json.total2;
							desconto_calculo = desconto_calculo + $json.desconto;
							total_calculo = total_calculo + $json.total1 + $json.total2 - desconto_calculo;

						}

					});



				}

			}
			$("#subtotal_calculo").text(subtotal_calculo).toLocaleString();
			$("#total_calculo").text(total_calculo).toLocaleString();
			$("#ipi_calculo").text(ipi_calculo).toLocaleString();
			$("#desconto_calculo").text(desconto_calculo).toLocaleString();
		}

		function Formata_Moeda(valor) {
			// Remove todos os .
			valor = valor.replace(/\./g, "");

			// Troca todas as , por .
			valor = valor.replace(",", ".");

			// Converte para float
			valor = parseFloat(valor);
			valor = parseFloat(valor) || 0.0;

			return valor;
		}

		function Formata_Dinheiro(n) {
			return n.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
		}


		function calculaSubTotal(x) {
			//alert('contunit'+contador_global_autocomplete);
			var total_calculo = 0;
			var ipi_calculo = 0;
			var desconto_calculo = 0;
			var subtotal_calculo = 0;
			for (i = 0; i < contador_global_autocomplete; i++) {

				//alert(contador_global_autocomplete);
				var valorunit = $('#val_unit_' + i).val();
				//valorunit = valorunit.toString().replace( ".", "" );
				//valorunit = valorunit.toString().replace( ",", "." );

				valorunit = Formata_Moeda(valorunit);

				/*valorunit=	valorunit.replace(/\./g, "");
				valorunit=	valorunit.replace(/,/g, ".");*/

				var desconto = $('#desconto_' + i).val();
				//desconto = desconto.toString().replace( ".", "" );
				///desconto = desconto.toString().replace( ",", "." );
				/*desconto=	desconto.replace(/\./g, "");
				desconto=	desconto.replace(/,/g, ".");*/

				desconto = Formata_Moeda(desconto);

				var valoripi = $('#val_ipi_' + i).val();
				//valoripi = valoripi.toString().replace( ".", "" );
				//valoripi = valoripi.toString().replace( ",", "." );
				/*desconto=	desconto.replace(/\./g, "");
				desconto=	desconto.replace(/,/g, ".");*/

				valoripi = Formata_Moeda(valoripi);
				//valoripi=valoripi+'';
				/*if(valoripi.indexOf('.')<0)
				{ 
					valoripi=valoripi+".00";
				}
				else
				{ 
					dp_impostoex=valoripi.split(".");
					if(dp_impostoex[1].length==1)
					{
						valoripi=valoripi+"0";
					}
					else if(dp_impostoex[1].length>=2)
					{
						dp_impostoexex=dp_impostoex[1].split("");
						campo0=parseInt(dp_impostoexex[0]);
						campo1=parseInt(dp_impostoexex[1]);
						campo2=parseInt(dp_impostoexex[2]);
						//if(campo2>5){ campo1++; }
						valoripi=dp_impostoex[0]+'.'+campo0+campo1;
					}
				}*/




				var qtd = $('#qtd_' + i).val();


				//var total = ((valorunit * qtd) - desconto) *  valoripi / 100;
				var total1 = (valorunit * qtd);
				var total2 = total1 * valoripi / 100;

				//total1=parseFloat(total1);	
				//total2=parseFloat(total2);	
				var total3 = total1 + total2 - desconto;

				//total3=parseFloat(total3);	


				//alert(total3);
				subtotal_calculo = subtotal_calculo + total1;
				ipi_calculo = ipi_calculo + total2;
				desconto_calculo = desconto_calculo + desconto;

				//desconto_calculo=parseFloat(desconto_calculo);
				total_calculo = total_calculo + total3;

				/*total3 = parseFloat(total3.toFixed(2));
				total3=(total3).toLocaleString(); 
				
				total1 = parseFloat(total1.toFixed(2));
				total1=(total1).toLocaleString(); */



				$('#subtot_' + i).val(Formata_Dinheiro(total1));
				$('#vlr_total_' + i).val(Formata_Dinheiro(total3));





			}
			//document.getElementByID("desconto_calculo").innerHTML += desconto_calculo

			$('#subtotal_calculo').val(Formata_Dinheiro(subtotal_calculo));
			$('#total_calculo').val(Formata_Dinheiro(total_calculo));
			$('#ipi_calculo').val(Formata_Dinheiro(ipi_calculo));
			$('#desconto_calculo').val(Formata_Dinheiro(desconto_calculo));


			/*$("#subtotal_calculo").text(subtotal_calculo).toLocaleString();
			$("#total_calculo").text(total_calculo).toLocaleString();
			$("#ipi_calculo").text(ipi_calculo).toLocaleString();
			$("#desconto_calculo").text(desconto_calculo).toLocaleString();
			*/


			//alert(subtotal_calculo);

		}



		function getValor(cliente) {
			$.ajax({
				/*url: 'http://localhost/sgi/index.php/orcamentos/autoCompleteSolicitante',
				type: 'POST',
				data: {id: cliente},
				dataType: 'json',
				success: function(json) {*/

				url: '<?php echo base_url('index.php/orcamentos/autoCompleteSolicitante') ?>?id=' + cliente,
				dataType: 'json',
				success: function(json) {
					/*type:'POST',
                url : '<?php echo base_url('index.php/orcamentos/autoCompleteSolicitante/') ?>/' + cliente,
                success: function(json){*/
					var txt_solicitante = "<option value=''>--Selecione--</option>";
					$.each(json, function(index, solici) {
						txt_solicitante += "<option value='" + solici.idSolicitante + "'>" + solici.nome + "</option>";
					});
					$(".recebe-solici").html(txt_solicitante);

				}
			});


		}


		$(document).ready(function() {
			// $(".money").maskMoney();
			//$('.dinheiro').mask('#.##0,00', {reverse: true});
			$('#formOrcamento').validate({
				rules: {
					idEmitente: {
						required: true
					},
					cliente: {
						required: true
					},
					idSolicitante: {
						required: true
					},
					idstatusOrcamento: {
						required: true
					},
					idGerente: {
						required: true
					},
					idVendedor: {
						required: true
					},
					idGrupoServico: {
						required: true
					},
					idNatOperacao: {
						required: true
					}
					/*estado:{ required: true},
					cep:{ required: true}*/
				},
				messages: {
					idEmitente: {
						required: 'Campo Requerido.'
					},
					cliente: {
						required: 'Campo Requerido.'
					},
					idSolicitante: {
						required: 'Campo Requerido.'
					},
					idstatusOrcamento: {
						required: 'Campo Requerido.'
					},
					idGerente: {
						required: 'Campo Requerido.'
					},
					idVendedor: {
						required: 'Campo Requerido.'
					},
					idGrupoServico: {
						required: 'Campo Requerido.'
					},
					idNatOperacao: {
						required: 'Campo Requerido.'
					}
					/*cep:{ required: 'Campo Requerido.'}*/

				},

				errorClass: "help-inline",
				errorElement: "span",
				highlight: function(element, errorClass, validClass) {
					$(element).parents('.control-group').addClass('error');
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).parents('.control-group').removeClass('error');
					$(element).parents('.control-group').addClass('success');
				}
			});


		});
	</script>

	<script type="text/javascript">
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
		/*
		jQuery.browser
		=
		{};
		(function
		()
		{
		jQuery.browser.msie
		=
		false;
		jQuery.browser.version
		=
		0;
		if
		(navigator.userAgent.match(/MSIE
		([0 - 9] + )\. / ))
		{
		jQuery.browser.msie
		=
		true;
		jQuery.browser.version
		=
		RegExp.$1;
		}
		})();
		*/
		function
		duplicarCampos() {
		//var
		clone
		=
		$("#origem").clone();
		//clone.find("input").val("");
		//$("#destino").append(clone);
		var	contador_local_autocomplete = contador_global_autocomplete;
		//alert('duplicarlocal'+contador_global_autocomplete);
		var	cloneDiv ='';
		if (contador_global_autocomplete > 0) {
			cloneDiv='<div class="span12" style="/*! border: 1px solid; */padding: 0.2%; margin-left: 0;border-bottom: 1px solid grey;margin-bottom: 20px;"></div>';
		}
	cloneDiv +='<div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">'+
		'<div class="span12" style="text-align: end;">'+
			'<a href="#" onclick="removerCampos(this);" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>'+
			'</div>'+
		'<div class="span12" style="padding: 0.2%; margin-left: 0">'+
			'<div class="span1">'+
				'<label>Orç.:</label>'+
				'<select id="orc_'+contador_local_autocomplete+'" name="orc[]" class="span12">'+
					'<option value="fab">FAB</option>'+
					'<option value="serv">SERV</option>'+
					'</select>'+
				'</div>'+
			'<div class="span2">'+
				'<label>Tipo de Prod.:</label>'+
				'<select id="tipo_prod_'+contador_local_autocomplete+'" name="tipo_prod[]" class="span12">'+
					'<option value="cil">Cilindro</option>'+
					'<option value="maq">Máquina</option>'+
					'<option value="pec" selected>Peça</option>'+
					'<option value="sub">Subconjunto</option>'+
					'</select>'+
				'</div>'+
			'<div class="span2">'+
				'<label>PN:</label>'+
				'<input type="text" class="span12" id="pn_'+contador_local_autocomplete+'" name="pn[]" value="" />'+
				'<input type="hidden" id="item[]" name="item[]" value="" size="1" />'+
				'<input type="hidden" id="idProdutos_'+contador_local_autocomplete+'" name="idProdutos[]" size="3" value="" />'+
				'</div>'+
			'<div class="span5">'+
				'<label>Descrição:</label>'+
				'<input type="text" class="span12" id="descricao_item_'+contador_local_autocomplete+'" name="descricao_item[]" value="" readonly />'+
				'</div>'+
			'<div class="span1">'+
				'<label>Tag:</label>'+
				'<input type="text" class="span12" id="tag_'+contador_local_autocomplete+'" name="tag[]" value="" />'+
				'</div>'+
			'<div class="span2">'+
				'<label>Qtd. Estq.:</label>'+
				'<input type="text" class="span12" id="qtdest_'+contador_local_autocomplete+'" name="qtdest[]" value="" disabled />'+
				'</div>'+
			'</div>'+
		'<div class="span12" style="padding: 0.2%; margin-left: 0">'+
			'<div class="span2">'+
				'<label>Ultima O.S.:</label>'+
				'<input type="text" class="span12" id="cOs_'+contador_local_autocomplete+'" name="cOs[]" value="" disabled /> '+
				'</div>'+
			'<div class="span2">'+
				'<label>Custo Insumo:</label>'+
				'<input type="text" class="span12" id="custoIns_'+contador_local_autocomplete+'" name="custoIns[]" value="" disabled />'+
				'</div>'+
			'<div class="span2">'+
				'<label>Custo HR/Maq</label>'+
				'<input type="text" class="span12" id="custoFab_'+contador_local_autocomplete+'" name="custoFab[]" value="" disabled />'+
				'</div>'+
			'<div class="span2">'+
				'<label>Custo Impostos</label>'+
				'<input type="text" class="span12" id="custoIcms_'+contador_local_autocomplete+'" name="custoIcms[]" value="" disabled />'+
				'</div>'+
			'<div class="span2">'+
				'<label>Custo Frete</label>'+
				'<input type="text" class="span12" id="custoFrete_'+contador_local_autocomplete+'" name="custoFrete[]" value="" disabled />'+
				'</div>'+
			'<div class="span2">'+
				'<label>Custo Total</label>'+
				'<input type="text" class="span12" id="custoTotal_'+contador_local_autocomplete+'" name="custoTotal[]" value="" disabled />'+
				'</div>'+
			'</div>'+
		'<div class="span12" style="padding: 0.2%; margin-left: 0">'+
			'<div class="span1">'+
				'<label>QTD:</label>'+
				'<input type="text" class="span12" id="qtd_'+contador_local_autocomplete+'" name="qtd[]" onblur="calculaSubTotal('+contador_local_autocomplete+');" onclick="this.select();" value="" />'+
				'</div>'+
			'<div class="span2">'+
				'<label>Vl.Unit.:</label>'+
				'<input type="text" class="span12" id="val_unit_'+contador_local_autocomplete+'" name="val_unit[]" value="0,00" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');" onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" /> '+
				'</div>'+
			'<div class="span2">'+
				'<label>Sub.Tot.:</label>'+
				'<input type="text" class="span12" id="subtot_'+contador_local_autocomplete+'" name="subtot[]" value="0,00" readonly />'+
				'</div>'+
			'<div class="span2">'+
				'<label>Prazo:</label>'+
				'<input type="text" class="span12" id="prazo_'+contador_local_autocomplete+'" name="prazo[]" onclick="this.select(); value="" /> '+                             
						'</div> '+ 
						'<div class=" span2">'+
				'<label>Desconto:</label>'+
				'<input type="text" class="span12" id="desconto_'+contador_local_autocomplete+'" name="desconto[]" value="0,00" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');" onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />'+
				'</div>'+
			'<div class="span1">'+
				'<label>IPI%:</label>'+
				'<input type="text" class="span12" id="val_ipi_'+contador_local_autocomplete+'" name="val_ipi[]" value="0,00" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');" onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />'+
				'</div>'+
			'<div class="span2">'+
				'<label>Valor Tot.:</label>'+
				'<input type="text" class="span12" id="vlr_total_'+contador_local_autocomplete+'" name="vlr_total[]" value="0,00" />'+
				'</div>'+
			'</div>'+
		'<div class="span12" style="padding: 0.2%; margin-left: 0">'+
			'<div class="span10">'+
				'<label>Detalhamento: </label>'+
				'<textarea id="detalhe_'+contador_local_autocomplete+'" cols="50" class="span10" name="detalhe[]"></textarea>'+
				'</div>'+
			'</div>'+
		'</div> ';

	$("#destino").append(cloneDiv);

	console.log('#idProdutos_'+contador_global_autocomplete);
	prod = '#idProdutos_'+contador_local_autocomplete;
	desc = '#descricao_item_'+contador_local_autocomplete;
	$("#pn_"+contador_global_autocomplete).autocomplete({
	source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN_2",
	minLength: 1,
	select: function( event, ui ) {
		$(prod).val(ui.item.id);
		$(desc).val(ui.item.no);
		if($( "#orc_"+contador_local_autocomplete ).val() == "serv"){
			$("#idChecklist_"+contador_local_autocomplete).val("");
		}else if($( "#orc_"+contador_local_autocomplete ).val() == "fab"){
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/peritagem/getcatalogoproduto",
				type: 'POST',
				dataType: 'json',
				data: {
					idProduto: ui.item.id
				},
				success: function(data) {
					$("#escopo_"+contador_local_autocomplete).empty();
					if(data.resultado.length > 0){
						var variavel = {value:data.resultado[0].idCatalogoProduto}
						buscarCatalogo(variavel,contador_local_autocomplete);
						$("#idChecklist_"+contador_local_autocomplete).val(variavel.value);
					}
					//preencherTabelaCatalogo(pos,data.resultado);
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
		


	}
	});




	contador_global_autocomplete = contador_global_autocomplete+1;



	calculaSubTotal();







	}

	$(function() {
	$(document).on('click', 'input[type=text][id=example1]', function() {
	this.select();
	});
	});


	function removerCampos(obj,pos){
		var div = $(obj).parent();
		valor = div.find("input:eq(0)").val();

		contador_global_autocomplete=contador_global_autocomplete-1;
		$(obj).parent().parent().remove();
		$('.trfilho'+pos).remove();
	}
	function verificarEscopo(pos){
		var orc = document.querySelector('#orc_'+pos).value;
		var tipo_prod = document.querySelector('#tipo_prod_'+pos).value;
		var idProduto = document.querySelector('#idProdutos_'+pos).value;
		if(tipo_prod && orc == "serv" && idProduto){
			$("#idChecklist"+pos).val("");
			$("#divSelectFab_"+pos).empty();
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/peritagem/getescopobyidproduto",
				type: 'POST',
				dataType: 'json',
				data: {
					idProduto: idProduto,
					tipo_prod: tipo_prod,
					orc: orc
				},
				success: function(data) {
					$("#escopo_"+pos).empty();
					if(data.resultado.length > 0)
						preencherTabela(pos,data.resultado);
				},
				error: function(xhr, textStatus, error) {
					console.log("4");
					console.log(xhr.responseText);
					console.log(xhr.statusText);
					console.log(textStatus);
					console.log(error);
				},
			})
		}  else{
			if(idProduto){
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/peritagem/getcatalogoproduto",
					type: 'POST',
					dataType: 'json',
					data: {
						idProduto: idProduto,
						tipo_prod: tipo_prod,
						orc: orc
					},
					success: function(data) {
						$("#divSelectFab_"+pos).empty();
						if(data.resultado.length>0){
							var variavel = {value:data.resultado[0].idCatalogoProduto}
							buscarCatalogo(variavel,pos);
							$("#idChecklist_"+pos).val(variavel.value);
						}
						//preencherSelect(pos,data.resultado)
					},
					error: function(xhr, textStatus, error) {
						console.log("4");
						console.log(xhr.responseText);
						console.log(xhr.statusText);
						console.log(textStatus);
						console.log(error);
					},
				})
			}else{
				$("#idChecklist"+pos).val("");
			}
			
        }                    
	}
	function preencherSelect(pos,resultado){
		html = '<option value=""> Selecione um checklist</option>';
		resultado.forEach((elemento)=>{
			html += '<option value="'+elemento.idCatalogoProduto+'">'+elemento.descricaoCatalogo+'</option>'
		})
		div = '<label>Checklist</label>'+
			'<select id="catalogoProduto_'+pos+'" class="span12" onchange="buscarCatalogo(this,'+pos+')">'+
				html+
			'</select>';
		//$("#divSelectFab_"+pos).append(div);
		
	}
	function preencherTabela(pos,resultado){
		html = '';
		resultado.forEach((elemento)=>{
		if(elemento.pn == null)
			elemento.pn = "";
		html += '<tr>'+
				'<td>'+elemento.pn+'</td>'+                            
				'<td>'+elemento.descricaoServicoItens+'</td>'+
				'<td>'+elemento.descricaoClasse+'</td>'+                            
				'<td></td>'+                                                                                                    
				'<td></td>'+                                
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
				'<td></td>'+
			'</tr>';          
		})
		table = '<h5>Checklist</h5>'+
				'<table class="table table-bordered ">'+
					'<thead>'+
						'<tr>'+
							'<th>PN</th>'+
							'<th>DESCRIÇÃO</th>'+
							'<th>CLASSE</th>'+
							'<th>QTD</th>'+
							'<th>Ø EXT.</th>'+
							'<th>Ø INT.</th>'+
							'<th>COMP.</th>'+
							'<th>OBS.</th>'+
							'<th>Valor Unit.</th>'+
							'<th>Valor Total</th>'+
						'</tr>'+                            
					'</thead>'+
					'<tbody>'+
							html+                                                                                                                                                                                             
					'</tbody>'+
				'</table>';
		$("#escopo_"+pos).append(table);
	}
	
	function preencherTabelaCatalogo(pos,resultado){
		$("#escopo_"+pos).empty();
		html = '';
		resultado.forEach((elemento)=>{
			if(elemento.pn == null)
			elemento.pn = "";
		html += '<tr>'+
				'<td>'+elemento.pn+'</td>'+                            
				'<td>'+elemento.descricao+'</td>'+
				'<td>'+elemento.quantidade+'</td>'+
			'</tr>';          
		})
		table = '<h5>Checklist</h5>'+
				'<table class="table table-bordered ">'+
					'<thead>'+
						'<tr>'+
							'<th>PN</th>'+
							'<th>DESCRIÇÃO</th>'+
							'<th>QTD</th>'+
						'</tr>'+                            
					'</thead>'+
					'<tbody>'+
							html+                                                                                                                                                                                             
					'</tbody>'+
				'</table>';
		$("#escopo_"+pos).append(table);
	}
	function buscarCatalogo(select,pos){
		$("#escopo_"+pos).empty();
		if(select.value){
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/peritagem/getcatalogoitens",
				type: 'POST',
				dataType: 'json',
				data: {
					idCatalogo: select.value
				}, 
				success: function(data) {
					preencherTabelaCatalogo(pos,data.resultado)
				},
				error: function(xhr, textStatus, error) {
					console.log("4");
					console.log(xhr.responseText);
					console.log(xhr.statusText);
					console.log(textStatus);
					console.log(error);
				},
			})
		}else{

		}/*
		idOrcItem = document.querySelector('#id_orc_item_'+pos).value
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/orcamentos/alterarcatalogoorc",
			type: 'POST',
			dataType: 'json',
			data: {
				idCatalogo: select.value,
				idOrcItem:idOrcItem
			}, 
			success: function(data) {
				alert('Checklist alterado com sucesso.');
			},
			error: function(xhr, textStatus, error) {
				console.log("4");
				console.log(xhr.responseText);
				console.log(xhr.statusText);
				console.log(textStatus);
				console.log(error);
			},
		})*/
	}
	function retorna_formatado(num) {

		x = 0;

		if(num<0) { num=Math.abs(num); x=1; } if(isNaN(num)) num="0" ; cents=Math.floor((num*100+0.5)%100); num=Math.floor((num*100+0.5)/100).toString(); if(cents < 10) cents="0" + cents; for (var i=0; i < Math.floor((num.length-(1+i))/3); i++) num=num.substring(0,num.length-(4*i+3))+'.' +num.substring(num.length-(4*i+3)); ret=num + ',' + cents; if (x==1) ret=' - ' + ret;return ret; } function FormataValor2(objeto, teclapres, tammax, decimais) { var tecla=teclapres.keyCode; var tamanhoObjeto=objeto.value.length; if ((tecla==8) && (tamanhoObjeto==tammax)) tamanhoObjeto=tamanhoObjeto - 1 ; if (( tecla==8 || tecla==88 || tecla>= 48 && tecla <= 57 || tecla>= 96 && tecla <= 105 ) && ((tamanhoObjeto+1) <=tammax)) { vr=objeto.value; vr=vr.replace( "/" , "" ); vr=vr.replace( "/" , "" ); vr=vr.replace( "," , "" ); vr=vr.replace( "." , "" ); vr=vr.replace( "." , "" ); vr=vr.replace( "." , "" ); vr=vr.replace( "." , "" ); tam=vr.length; if (tam < tammax && tecla !=8) tam=vr.length + 1 ; if ((tecla==8) && (tam> 1)){
				tam = tam - 1 ;
				vr = objeto.value;
				vr = vr.replace( "/", "" );
				vr = vr.replace( "/", "" );
				vr = vr.replace( ",", "" );
				vr = vr.replace( ".", "" );
				vr = vr.replace( ".", "" );
				vr = vr.replace( ".", "" );
				vr = vr.replace( ".", "" );
				}

				//Cálculo para casas decimais setadas por parametro
				if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla>= 96 && tecla <= 105 ) { if (decimais> 0) {
						if ( (tam <= decimais) ) objeto.value=("0," + vr) ; if( (tam==(decimais + 1)) && (tecla==8)) objeto.value=vr.substr( 0, (tam - decimais)) + ',' + vr.substr( tam - (decimais), tam ) ; if ( (tam> (decimais + 1)) && (tam <= (decimais + 3)) && ((vr.substr(0,1))=="0" )) objeto.value=vr.substr( 1, (tam - (decimais+1))) + ',' + vr.substr( tam - (decimais), tam ) ; if ( (tam> (decimais + 1)) && (tam <= (decimais + 3)) && ((vr.substr(0,1)) !="0" )) objeto.value=vr.substr( 0, tam - decimais ) + ',' + vr.substr( tam - decimais, tam ) ; if ( (tam>= (decimais + 4)) && (tam <= (decimais + 6)) ) objeto.value=vr.substr( 0, tam - (decimais + 3) ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ; if ( (tam>= (decimais + 7)) && (tam <= (decimais + 9)) ) objeto.value=vr.substr( 0, tam - (decimais + 6) ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ; if ( (tam>= (decimais + 10)) && (tam <= (decimais + 12)) ) objeto.value=vr.substr( 0, tam - (decimais + 9) ) + '.' + vr.substr( tam - (decimais + 9), 3 ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ; if ( (tam>= (decimais + 13)) && (tam <= (decimais + 15)) ) objeto.value=vr.substr( 0, tam - (decimais + 12) ) + '.' + vr.substr( tam - (decimais + 12), 3 ) + '.' + vr.substr( tam - (decimais + 9), 3 ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ; } else if(decimais==0) { if ( tam <=3 ) objeto.value=vr ; if ( (tam>= 4) && (tam <= 6) ) { if(tecla==8) { objeto.value=vr.substr(0, tam); window.event.cancelBubble=true; window.event.returnValue=false; } objeto.value=vr.substr(0, tam - 3) + '.' + vr.substr( tam - 3, 3 ); } if ( (tam>= 7) && (tam <= 9) ) { if(tecla==8) { objeto.value=vr.substr(0, tam); window.event.cancelBubble=true; window.event.returnValue=false; } objeto.value=vr.substr( 0, tam - 6 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ); } if ( (tam>= 10) && (tam <= 12) ) { if(tecla==8) { objeto.value=vr.substr(0, tam); window.event.cancelBubble=true; window.event.returnValue=false; } objeto.value=vr.substr( 0, tam - 9 ) + '.' + vr.substr( tam - 9, 3 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ); } if ( (tam>= 13) && (tam <= 15) ){ if(tecla==8) { objeto.value=vr.substr(0, tam); window.event.cancelBubble=true; window.event.returnValue=false; } objeto.value=vr.substr( 0, tam - 12 ) + '.' + vr.substr( tam - 12, 3 ) + '.' + vr.substr( tam - 9, 3 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ) ; } } } } else if((window.event.keyCode !=8) && (window.event.keyCode !=9) && (window.event.keyCode !=13) && (window.event.keyCode !=35) && (window.event.keyCode !=36) && (window.event.keyCode !=46)) { window.event.cancelBubble=true; window.event.returnValue=false; } } </script>

							<!-- Modal -->
							<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form action="<?php echo base_url() ?>index.php/orcamentos/excluir_item" method="post">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h5 id="myModalLabel">Excluir Item</h5>
									</div>
									<div class="modal-body">
										<input type="hidden" id="item_produt" name="id" value="" />
										<input type="hidden" id="orc_item" name="orc_item" value="<?php echo $result->idOrcamentos; ?>" />
										<h5 style="text-align: center">Deseja realmente excluir este item?</h5>
									</div>
									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
										<button class="btn btn-danger">Excluir</button>
									</div>
								</form>
							</div>

							<div id="modal-adicionaritem" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form action="<?php echo base_url() ?>index.php/orcamentos/adicionaritem" method="post">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h5 id="myModalLabel">Inserir mais um item para esse orçamento</h5>
									</div>
									<div class="modal-body">
										<input id="idOrcamentositem" type="hidden" name="idOrcamentositem" value="<?php echo $result->idOrcamentos; ?>" />


										<h5 style="text-align: center">Deseja adicionar item ao orçamento: <?php echo $result->idOrcamentos; ?>?</h5>
									</div>
									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
										<button class="btn btn-danger">Adicionar</button>
									</div>
								</form>
							</div>
							<?php
							$contador_local_autocomplete2 = 0;
							foreach ($dados_item as $orc_item) {
								if ($orc_item->tipoOrc == 'serv') {
									$anexoItens = $this->orcamentos_model->getAnexoDesenhoByIdOrcItem($orc_item->idOrcamento_item);	
									?>													
									<div id="modal-desenho-<?php echo $contador_local_autocomplete2; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h5 id="myModalLabel">Anexo Desenho</h5>
											</div>
											<div class="modal-body">
												<form action="<?php echo base_url() ?>index.php/orcamentos/adicionaranexo" method="post" enctype="multipart/form-data">																							
													<div class="span12">
														<div class="span2" class="control-group">
															<label for="idGrupoServico" class="control-label">Nome Arquivo: </label>
															<input type="text" class="span12" value="" name="nomeArquivo" />
															<input type="hidden" class="span12" value="<?php echo $orc_item->idOrcamentos; ?>"  name="idOrc"/>
															<input type="hidden" class="span12" value="<?php echo $orc_item->idOrcamento_item; ?>"  name="idOrcItem"/>
														</div>
														<div class="span10" class="control-group">
															<label for="idGrupoServico" class="control-label">Arquivo: </label>
															<input id="arquivo" type="file" name="userfile" class="span12"   />
														</div>
													</div>
													<div class="span12" style="margin-left:0px">
														<div class="span12" class="control-group" style="text-align:right">
															<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
															<button class="btn btn-success">Adicionar</button>
														</div>
													</div>
												</form>
												<?php if(!empty($anexoItens)){ ?>
												<div class="row-fluid" style="margin-top:0">
													<div class="span12">
														<div class="widget-box">																									
															<div class="widget-content nopadding">
																<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
																	<div class="tab-content">
																		<div class="tab-pane active" id="tab1">
																			<div class="span12" id="divCadastrarOs">                                
																				<div class="widget-box" style="margin-top:0px">                                        
																					<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
																						<thead>
																							<tr>
																								<th>Arquivo</th>
																								<th>Status</th>
																								<th>Usuário</th>
																							</tr>
																						</thead>
																						<tbody>
																							<?php foreach($anexoItens as $r){
																								echo '<tr>';
																									echo '<td><a href='.base_url() . $r->caminho . $r->imagem.' target="_blank">'.$r->nomeArquivo . $r->extensao.'</a></td>';
																									echo '<td>'.($r->statusAnexo == 1 ? 'Aguardando Verificação' : ($r->statusAnexo == 2 ? 'Aprovado' : 'Rejeitado')).'</td>';
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
												<?php } ?>
											</div>
											<div class="modal-footer"><!--
												<button type="submit" class="btn btn-success" name="btnDesenho<?php echo $contador_local_autocomplete2; ?>" id="btnDesenho<?php echo $contador_local_autocomplete2; ?>" value="btnAlterar">Avançar</button> -->
											</div>													
								
									</div>
									<?php 
									$orcServicoEscopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($orc_item->idOrcamento_item); ?>
									<div id="modal-escopo-<?php echo $contador_local_autocomplete2; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form id='formEscopo<?php echo $contador_local_autocomplete2; ?>' action="<?php echo base_url() ?>index.php/orcamentos/escopo/<?php echo $orc_item->idOrcamento_item; ?>" method="post">

											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h5 id="myModalLabel">Selecione o escopo adequado para esse Orçamento</h5>
											</div>
											<div class="modal-body">
												<select name="valueEscopo" id="valueEscopo" <?php if (isset($orcServicoEscopo)) {
																								if (!empty($orcServicoEscopo)) {
																									echo '';
																								}
																							} ?>>
													<?php
													$escopoProd = $this->peritagem_model->getEscopoByIdProduto($orc_item->idProdutos, $orc_item->tipoProd);
													$allId = "4";
													if (!empty($escopoProd)) { ?>
														<option <?php if (isset($orcServicoEscopo)) {
																	if (!empty($orcServicoEscopo)) {
																		if ($orcServicoEscopo->idServicoEscopo == $escopoProd->idServicoEscopo) {
																			echo 'selected';
																		}
																	}
																} ?> value="<?php echo $escopoProd->idServicoEscopo; ?>"><?php echo $escopoProd->nomeServicoEscopo; ?></option>
													<?php
														if($orc_item->tipoProd != 'pec'){
															$allId = $escopoProd->idServicoEscopo . ",";
														}
													} else {
														echo '<option value="novo">Criar um novo escopo para esse produto</option>';
													}
													?>

													<?php if ($orc_item->tipoProd == 'cil') { ?>
														<option value="1" <?php if (isset($orcServicoEscopo)) {
																				if (!empty($orcServicoEscopo)) {
																					if ($orcServicoEscopo->idServicoEscopo == 1) {
																						echo 'selected';
																					}
																				}
																			} ?>>Padrão Cilindro</option>
													<?php
														$allId = $allId . "1";
													} else if ($orc_item->tipoProd == 'sub') { ?>
														<option value="2" <?php if (isset($orcServicoEscopo)) {
																				if (!empty($orcServicoEscopo)) {
																					if ($orcServicoEscopo->idServicoEscopo == 2) {
																						echo 'selected';
																					}
																				}
																			} ?>>Padrão Subconjunto</option>
													<?php
														$allId = $allId . "2";
													} else if ($orc_item->tipoProd == 'maq') { ?>
														<option value="3" <?php if (isset($orcServicoEscopo)) {
																				if (!empty($orcServicoEscopo)) {
																					if ($orcServicoEscopo->idServicoEscopo == 3) {
																						echo 'selected';
																					}
																				}
																			} ?>>Padrão Máquina</option>
													<?php
														$allId = $allId . "3";
													}
														
													?>
													<?php 
													//echo '<script>console.log('.$allId.')</script>';
													$escopoProd2 = $this->peritagem_model->getEscopoByTipoServico($orc_item->tipoProd, $allId);
													echo '<script>console.log('.json_encode($escopoProd2).')</script>';
													/*if (!empty($escopoProd2)) {
														foreach ($escopoProd2 as $r) { ?>
															<option <?php if (isset($orcServicoEscopo)) {
																		if (!empty($orcServicoEscopo)) {
																			if ($orcServicoEscopo->idServicoEscopo == $r->idServicoEscopo) {
																				echo 'selected';
																			}
																		}
																	} ?> value="<?php echo $r->idServicoEscopo; ?>"><?php echo $r->nomeServicoEscopo; ?></option>
													<?php
														}
													} */
													?>
												</select>
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-success" name="btnEscopo<?php echo $contador_local_autocomplete2; ?>" id="btnEscopo<?php echo $contador_local_autocomplete2; ?>" value="btnAlterar">Avançar</button>
											</div>
										</form>
									</div>
								<?php
								}
								$contador_local_autocomplete2++;
							}
							?>


							<!--https://pt.stackoverflow.com/questions/9548/como-clonar-um-elemento-com-jquery-e-adicionar-um-novo-name-->