<style>
	table.comBordas {
		border: 0px solid White;
	}

	table.comBordas td {
		border: 1px solid grey;
	}
</style>
<div class="widget-box">
	<div class="widget-title">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#tab1">Dados do Orcamento</a></li>
			<!--<li><a data-toggle="tab" href="#tab2">Ordens de Serviço</a></li>-->
			<div class="buttons">
				<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOrcamento')) {
					echo '<a title="Icon Title" class="btn btn-mini btn-info" href="' . base_url() . 'index.php/orcamentos/editar/' . $result->idOrcamentos . '"><i class="icon-pencil icon-white"></i> Editar</a>';
				} ?>

			</div>
		</ul>
	</div>

	<form action="<?php echo base_url() ?>index.php/orcamentos/aprovar_os" method="post" id="formOS">

		<div class="container-fluid">

			<table width='50%'>
				<tr>
					<td>CLIENTE: &nbsp;&nbsp;<?php echo $dados_clientes->nomeCliente; ?></td>
				</tr>
				<tr>
					<td>
						Orçamento número: &nbsp;&nbsp;<font size='3'><?php echo $result->idOrcamentos ?>&nbsp;&nbsp;&nbsp;&nbsp;</font> <b>|</b> &nbsp;&nbsp;&nbsp;&nbsp;Data: <?php echo date('d/m/Y',  strtotime($result->data_abertura)) ?></b>
					</td>
					<td>
					</td>
				</tr>
				</td>
				<?php $validade = date('d/m/Y', strtotime('+' . $result->validade . 'days', strtotime($result->data_abertura))); ?>
				<td>Validade da Proposta: <?php echo $result->validade; ?> dias - <?php echo $validade; ?></td>
				</tr>
				<tr>
					<td>

						Status Orçamento:&nbsp;&nbsp;&nbsp;&nbsp; <?php foreach ($dados_statusorcamento as $o) {
																		if ($o->idstatusOrcamento == $result->idstatusOrcamento) {
																			echo "<b>" . $o->nome_status_orc . "</b>";
																		}
																	}
																	?>
					</td>
				</tr>
				<!--
<tr>
<td><br>
Novo Status Orçamento: <select class="form-control" name="idstatusOrcamento">
                      
                        <?php foreach ($dados_statusorcamento as $o) { ?>
                        
                        <option value="<?php echo $o->idstatusOrcamento; ?>" <?php if ($o->idstatusOrcamento == 4) {
																					echo "selected='selected'";
																				} ?>><?php echo $o->nome_status_orc; ?></option>
                        <?php } ?>
                       
                        </select>
</td>
</tr>-->
			</table>



			<div class="row-fluid">
				<div class="span12">

					<div class="widget-box">

						<div class="widget-content nopadding">

							<table align='center' width='100%'>
								<tr>


									<td><b>Status OS:</b>
										<select class="form-control" name="idStatusOs">

											<?php foreach ($status_os as $e) { ?>

												<option value="<?php echo $e->idStatusOs; ?>" <?php if ($e->idStatusOs == 5) {
																									echo "selected='selected'";
																								} ?>><?php echo $e->nomeStatusOs; ?></option>
											<?php } ?>

										</select>
									</td>
									<td><b>Unid. Exec.</b>
										<select class="form-control" name="unid_execucao">
											<!--<option value="" selected='selected'></option>-->
											<?php foreach ($unid_exec as $exec) { ?>

												<option value="<?php echo $exec->id_unid_exec; ?>" <?php if ($exec->id_unid_exec == 2) {
																										echo "selected='selected'";
																									} ?>><?php echo $exec->status_execucao; ?></option>
											<?php } ?>

										</select>
									</td>
									<td><b>Unid. Fat.</b>
										<select class="form-control" name="unid_faturamento">
											<!--<option value="" selected='selected'></option>-->
											<?php foreach ($unid_fat as $fat) { ?>

												<option value="<?php echo $fat->id_unid_fat; ?>" <?php if ($fat->id_unid_fat == 2) {
																										echo "selected='selected'";
																									} ?>><?php echo $fat->status_faturamento; ?></option>
											<?php } ?>

										</select>
									</td>
									<td><b>Tipo</b>
										<select class="form-control" name="id_tipo">
											<!--<option value="" selected='selected'></option>-->
											<?php foreach ($tipo_os as $ostipo) { ?>

												<option value="<?php echo $ostipo->id_tipo; ?>" <?php if ($ostipo->id_tipo == 1) {
																									echo "selected='selected'";
																								} ?>><?php echo $ostipo->nome_tipo; ?></option>
											<?php } ?>

										</select>
									</td>
									<td><b>Contrato</b>
										<select name="contrato">
											<option value="Não" selected="selected">Não</option>
											<option value="Sim">Sim</option>
										</select>
									</td>

								</tr>
							</table>
							<table class='comBordas' width='100%'>
								<thead>
									<tr>
										<td></td>
										<td align='center'><b>Item</b></td>
										<td align='center'><b>Qtde</b></td>

										<td><b>Descrição</b></td>
										<td><b>PN</b></td>
										<td align='center'><b>Prazo Entr.</b></td>
										<td align='center'><b>Valor Unit.</b></td>

										<td align='center'><b>Sub. Total</b></td>
										<td align='center'><b>Frete</b></td>
										<td align='center'><b>Desconto</b></td>
										<td align='center'><b>IPI</b></td>
										<td align='center'><b>Total</b></td>
										<!--<td align='center'><b>Status OS</b></td>
										<td align='center'><b>Tipo Serv.</b></td>
										<td align='center'><b>Unid. Exec.</b></td>
										<td align='center'><b>Unid. Fat.</b></td>
										
										<td align='center'><b>Contrato</b></td>-->

									</tr>

								</thead>

								<tbody>

									<?php
									$valorsub = 0;
									$valortot = 0;
									$valoripi = 0;
									$valordesconto = 0;

									$count_item = 1;

									foreach ($itens_orcamento as $item) {

										$valoripi = ($item->val_ipi / 100 * $item->subtot) + $valoripi;
										$valordesconto = $item->desconto + $valordesconto;
										$valorsub = $item->subtot + $valorsub;
										$valortot = $valorsub + $valoripi;


										//$verifica = $this->orcamentos_model->getos_item($item->idOrcamento_item);

										$this->data['os_itens'] = $this->orcamentos_model->getos_item($item->idOrcamento_item);

										/*if($this->data['os_itens'] == true)
										{
											echo $this->data['os_itens']->idOs;
										}*/

										//echo json_encode($item);


									?>

										<tr>
											<td>
												<?php

												if ($item->status_item == 0) {

												?>
													<input name="item[]" type="checkbox" value="<?php echo $item->idOrcamento_item; ?>" checked>
											</td>
										<?php
												} else {
													echo "-";
												}
										?>
										<input name="idOrcamentos" type="hidden" value="<?php echo $item->idOrcamentos; ?>">
										<input name="num_pedido" type="hidden" value="<?php echo $item->num_pedido; ?>">

										<td align='center'><?php echo $count_item; ?></td>
										<td align='center'><?php echo $item->qtd; ?></td>

										<td><?php echo $item->descricao_item; ?> </td>
										<td><?php echo $item->pn; ?></td>

										<td align='center'><?php echo $item->prazo; ?></td>

										<td align='center'><?php echo number_format($item->val_unit, 2, ",", "."); ?></td>
										<td align='center'><?php echo number_format($item->subtot, 2, ",", "."); ?></td>
										<td align='center'><?php echo number_format($item->frete, 2, ",", "."); ?></td>
										<td align='center'><?php echo number_format($item->desconto, 2, ",", "."); ?></td>
										<td align='center'><?php echo number_format($item->val_ipi, 2, ",", "."); ?></td>
										<td align='center'><?php echo number_format($item->valor_total, 2, ",", "."); ?></td>





										<td align='center'>
											<?php

											if ($this->data['os_itens'] == false) {

											?>

											<?php
											} else {
												echo "Código da OS: <b>" . $this->data['os_itens']->idOs . "</b>";
												if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
													echo '<a href="#modal-excluir" role="button" data-toggle="modal" os="' . $this->data['os_itens']->idOs . '" orc="' . $result->idOrcamentos . '" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir OS"><i class="icon-remove icon-white"></i></a>';
												}
											}

											?>
										</td>
										<!--<td>
					   <?php

										if ($this->data['os_itens'] == false) {

						?>
					   <select name="tiposervico[]"> 
					   <option value="1" selected="selected">Fabricação</option>
					  <option value="2">Serviço</option>
					
					  </select>
					  <?php
										}
						?>
					   </td>-->






										</tr>


									<?php
										$count_item++;
									}
									?>

								</tbody>

							</table>






						</div>

					</div>


				</div>



			</div>

			<div align='center'>
				<button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Aprovar</button>
				<a href="<?php echo base_url() ?>index.php/orcamentos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>

			</div>
		</div>

	</form>




</div>


<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="<?php echo base_url() ?>index.php/orcamentos/excluir_os" method="post">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5 id="myModalLabel">Excluir OS</h5>
		</div>
		<div class="modal-body">

			<input type="hidden" id="id_os" name="id_os" value="" />
			<input type="hidden" id="idOrc" name="idOrc" value="" />

			<h5 style="text-align: center">Deseja realmente excluir esta OS?</h5>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button class="btn btn-danger">Excluir</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {


		$(document).on('click', 'a', function(event) {

			var os = $(this).attr('os');
			var orc = $(this).attr('orc');
			$('#id_os').val(os);
			$('#idOrc').val(orc);

		});




	});
</script>