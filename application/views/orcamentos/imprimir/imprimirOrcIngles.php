<?php


$dat = $this->input->get('dataInicial');
if ($dat == '') {
	$dataimpri =  date("d/m/Y H:i:s");
} else {
	$dataimpri =  date("d/m/Y", strtotime($dat));
}



?>


<head>
	<title>SGI</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body style="background-color: transparent">
	<style type="text/css">
		table.comBordas {
			border: 0px solid White;

		}

		table.comBordas td {
			border: 1px solid grey;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 10px;
		}

		table.comBordastitu td {

			font-family: Arial, Helvetica, sans-serif;
			font-size: 10px;
		}
	</style>


	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">

				<div class="widget-box">
					<?php
					if ($result[0]->status_orc == 1) {
					?>
						<div align='center'>
							<font size='5' color='red'>QUOTE DISABLED</font>
						</div>
					<?php
					}
					?>
					<div class="widget-content nopadding">

						<!--<table class="table table-bordered">-->
						<table width='100%' align='center' border='0' class='comBordastitu'>

							<tr>
								<td style="text-align: center; width: 20%" rowspan='3'><strong><img src=" <?php echo base_url() . $result[0]->url_logoemi . $result[0]->imagememi; ?> " width='55%' height='30%'=></strong></td>
								<td align='center'>
									<table width='100%' border='0'>
										<tr>
											<td colspan='2' align='center' height='50'>
												<b>
													<font size='4'><?php echo $result[0]->nomeemi; ?></font>
												</b>
											</td>
										</tr>
										<tr>
											<td>
												<font size='1'>CNPJ: <?php echo $result[0]->cnpjemi; ?></font>
											</td>
											<td>
												<font size='1'>STATE REGISTRATION: <?php echo $result[0]->ieemi; ?></font> </br>
											</td>

										</tr>
										<tr>
											<td>
												<font size='1'>ADDRESS: <?php echo $result[0]->numeroemi; ?>, <?php echo $result[0]->ruaemi; ?> </font>
											</td>
											<td>
												<font size='1'>DISTRICT: <?php echo $result[0]->bairroemi; ?></font>
											</td>
										</tr>
										<tr>
											<td>
												<font size='1'>CITY: <?php echo $result[0]->cidadeemi; ?> </font>
											</td>
											<td>
												<font size='1'>STATE: <?php echo $result[0]->ufemi; ?></font>
											</td>
										<tr>
											<td>
												<font size='1'>E-MAIL: <?php echo $result[0]->emailemi; ?></font>
											</td>
											<td>
												<font size='1'>PHONE: <?php echo $result[0]->telefoneemi; ?></font>
											</td>
										</tr>
									</table>
								</td>
								<!--<td rowspan='3'><table><tr><td>Orçamento Nº: <b><?php echo $result[0]->idorc ?></b></td></tr>
						<tr><td>Data Emissão: <b><?php echo date('d/m/Y',  strtotime($result[0]->data_abert_orc)) ?></b></td></tr>
						</table></td>-->

							</tr>

						</table>






					</div>

				</div>


			</div>



		</div>
		<br>
		<table class='comBordas' width='36%' align='right'>
			<tr>
				<td align='center'>
					QUOTE #: <font size='1'><?php echo $result[0]->idorc ?></font>
				</td>
				<td align='center'>
					DATE:<?php echo $dataimpri; ?>
				</td>
			</tr>
		</table>
		<div align="left">
			<b style="font-size:18px">PROFORMA INVOICE</b>
		</div>
		<div class="row-fluid">
			<div class="span12">

				<div class="widget-box">

					<div class="widget-content nopadding">

						<!--<table class="table table-bordered">-->
						<table width='100%' border='0' style="border-style:solid; border: 1px solid grey;
							font-family:Arial, Helvetica, sans-serif;
							font-size:12px;">
							<tr>
								<td>
									<table width='100%' border='0' style="font-family:Arial, Helvetica, sans-serif;
										font-size:12px;">
										<tr>
											<!--<td align='center'>Código<br><?php echo $result[0]->idcli; ?></td>-->
											<td align='left'>CUSTOMER:</td>
											<td width='45%'><?php echo $result[0]->nomecli; ?></td>
											<td align='left'>CUSTOMER ID:</td>
											<td><?php echo $result[0]->documentocli; ?></td>
										</tr>
										<tr>
											<td align='left' width='13%'>REQUESTER: </td>
											<td><?php echo $result[0]->nomesolici; ?></td>
											<td align='left' width='20%'>REQUESTER E-MAIL: </td>
											<td><?php echo $result[0]->emailsolicitante; ?></td>
										</tr>
										<tr>
											<td align='left'>PHONE:</td>
											<td><?php echo $result[0]->telefonecli; ?></td>
											<td align='left'>REFERENCE:</td>
											<td><?php echo $result[0]->referencia; ?></td>

										</tr>
										
									</table>
								</td>
							</tr>


						</table>



      </div>


<!-- acaba cliente-->
<!-- acaba produtos--> <br> 
<div>WE PRESENT OUR QUOTE FOR THE SUPPLY OF THE FOLLOWING ITEM(s):</div> <br>	
<div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                     
                      <div class="widget-content nopadding">

                  <!--<table class="table table-bordered">-->
                  <table class='comBordas' width='100%'>
                      <thead>
                          <tr>
					   <td align='center'><b>Item</b></td>
					   <td align='center'><b>Qty</b></td><!--
					   <td align='center'><b>Unid.</b></td> -->
					   <td><b>Description</b></td>
					   <td><b>PN</b></td>
					   <td align='center'><b>Lead Time (Days)</b></td>
					   <td align='center'><b>Unit Price</b></td>
					   <td align='center'><b>Subtotal</b></td>
					   <td align='center'><b>Total</b></td>
					   
					</tr>
					
				  </thead>
                     
					  <tbody>
					
					  <?php 
					  $valorsub = 0;
					  $valortot = 0;
					  $valoripi = 0;
					  $valordesconto = 0;
					  
					  $count_item = 1;
					  //foreach ($itens_orcamento as $item) {
					  foreach ($result as $item) {

						$valoripi = ($item->val_ipi/100 * $item->subtot) + $valoripi;
						$valordesconto = $item->desconto + $valordesconto;
						$valorsub = $item->subtot + $valorsub;
						$valortot = $valorsub + $valoripi - $valordesconto;
						
						?>
						
						<tr>
						<td align='center'><?php echo $count_item; //$item->idProdutos;?></td>
							<td align='center'><?php echo $item->qtd;?></td><!--
						<td align='center'>un</td>-->
						<td><?php echo (!empty($item->descricao_item_imprimir)?$item->descricao_item_imprimir:$item->descricao_item);?></td>
						<td><?php echo $item->pn;?></td>
						
						<td align='center'><?php echo $item->prazo;?></td>
						
						<td align='center'><?php echo number_format($item->val_unit/$result[0]->valorCotacao, 2, ".", " ");?></td>
						<td align='center'><?php echo number_format($item->subtot/$result[0]->valorCotacao, 2, ".", " ");?></td>
						<td align='center'><?php echo number_format($item->valor_total/$result[0]->valorCotacao, 2, ".", " ");?></td>
						
						
						
						</tr>
						
						<?php 

								$escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($item->idOrcamento_item);

								if(!empty($escopo)){
									$escopo->itensEscopo = $this->peritagem_model->itensPeritagemSelected2($escopo->idOrcServicoEscopo);
								?><?php 
								if(!empty($escopo->itensEscopo)){?>
								<tr>
									<td colspan="10">
									<div class="widget-content nopadding">

										<table class='comBordas' width='100%'>
											<thead>
												<tr>
													<td align='center'><b>Item</b></td>
													<td align='center'><b>Description</b></td>
													<td align='center'><b>Classe</b></td>
													<td align='center'><b>Qty.</b></td><!---->
													<?php if($exibirvalor){?>
													<td align='center'><b>Unit Price</b></td>
													<td align='center'><b>Total</b></td>
													<?php }?>

												</tr>

											</thead>
											<tbody>
												<?php $counta = 1;foreach($escopo->itensEscopo as $v){
													echo '<tr>';
														echo '<td>';
															echo $count_item.".".$counta;
														echo '</td>';
														echo '<td>';
															echo $v->descricaoServicoItens;
														echo '</td>';
														echo '<td>';
															echo $v->descricaoClasse;
														echo '</td>';
														echo '<td>';
															echo $v->quantidade;
														echo '</td>';
														if($exibirvalor){
														echo '<td>';
															echo $result[0]->moedaCotacao.' '.number_format($v->valorUnitario/$result[0]->valorCotacao,2,',','.');
														echo '</td>';
														echo '<td>';
															echo $result[0]->moedaCotacao.' '.number_format($v->valorUnitario*$v->quantidade/$result[0]->valorCotacao,2,',','.');
														echo '</td>';
														}/**/

													echo '</tr>';
													$counta++;
												}?>
											</tbody>
										</table>
										</div>
									</td>

									
								</tr>
								<?php
								}
								
							
						?>
								<?php
								}
								
							
						?>
						
						<tr>
						<td colspan='9'><?php echo nl2br($item->detalhe);?></td>
						
						
						</tr>
						
						<?php
						$count_item ++;
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



		<!-- acaba produtos-->
		<!-- observaçao--> <br>
		<div class="row-fluid">
			<div class="span12">

				<div class="widget-box">

					<div class="widget-content nopadding">

						<!--<table class="table table-bordered">-->
						<table width='100%' border='0'>

							<tr>
								<td style="width:65%">
									<table width='100%' class='comBordas'>
										<tr>
											<td colspan='2'><b>OBSERVATION:</b> <br><?php echo nl2br($result[0]->obs); ?></td>

										</tr>

										<tr>
											<td><b>Payment Terms</b></td>
											<td><?php echo $result[0]->cond_pgto; ?></td>

										</tr>
										<tr>
											<td><b>Validity (days)</b></td>
											<td><?php echo $result[0]->validade; ?></td>


										</tr>

										<tr>
											<td><b>INCOTERM</b></td>
											<td><?php
												
													echo  $result[0]->descricaoTipoEntrega;
												

												?>

											</td>

										</tr>
										<tr>
											<td><b>Nature of Transaction</b></td>
											<td>SALES<?php //echo $result[0]->nomenat; ?></td>

										</tr>
										<tr>
											<td><b>Lead Time</b></td>
											<td>
												<font size='1'><?php echo $result[0]->prazo;?> DAYS.
											</td>

										</tr>
										<?php
										if (!empty($result[0]->garantia_servico)) {
										?>
											<tr>
												<td><b>Service guarantee</b></td>
												<td>
													<font size='1'><?php echo $result[0]->garantia_servico; ?>
												</td>

											</tr>

										<?php

										}

										?>
									</table>
								</td>
								<td  style="width:35%">
									<table width='100%'>
										<tr>
											<td align='right'>
												<table width='100%' class='comBordas'>

													<tr>
														<td align='left'>SUB TOTAL:</td>
														<td> <?php echo $result[0]->moedaCotacao." ".number_format($valorsub/$result[0]->valorCotacao, 2, ".", " "); ?></td>
													</tr>

													<tr>
														<td align='rigth'><b>TOTAL:</td>
														<td><b> <?php echo $result[0]->moedaCotacao." ".number_format($valortot/$result[0]->valorCotacao, 2, ".", " "); ?></b></td>
													</tr>


												</table>
											</td>
										</tr>
										<tr>
											<td> <!--
												<table width='100%' class='comBordas'>
													<tr>

														<td align='center'>
															Impostos Inclusos<br>
															Para Fabricação :<br>
															Para Serviço :
														</td>
														<td align='center'><br>
															ICMS e DARF<br>
															ISS e DARF
														</td>


													</tr>
												</table> -->
											</td>
										</tr>
									</table>
								</td>
							</tr>




						</table>






					</div>

				</div>


			</div>

		</div>


		<br>
		<table class='comBordas' width='100%'>
			<tr>
				<td>
					<div align="center">IT IS NOT A TAX DOCUMENT - IT IS NOT VALID AS A RECEIPT AND AS A GUARANTEE OF GOODS - IT DOES NOT PROVE PAYMENT.
					</div>
				</td>
			</tr>
		</table>


	

		<br>

		<table class='comBordas' width='100%' align='rigth'>
			<tr>
				<td>After the quote expiration date, our price and delivery time will be subject to change.</td>
			</tr>

		</table>
		<div><b><br>Yours sincerely,</b></div>
		<table width='50%' align='center'>
			<tr>
				<td align="center">
					<img src=" <?php echo base_url() . "assets/gerente/leonardo.png"; ?> " style="height: 195px;">
					<br>_______________________________<br>Leonardo Sampaio<br>International Business Manager
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td align="center">
					<img src=" <?php echo base_url() . "assets/gerente/karina.png"; ?> " style="height: 195px;">
					<br>_______________________________<br>Karina Nunes<br>Chief Administrative Officer
				</td>
			</tr>
			<tr>
				<td align="center" colspan='3'><br><br>_______________________________<br>
                    Customer approval

				</td>
			</tr>

		</table>

		<br> <br>


	</div>




	
</body>

</html>