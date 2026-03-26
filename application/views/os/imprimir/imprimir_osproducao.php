<!--<script>
    window.print();
    window.addEventListener("afterprint", function(event) { window.close(); });
    window.onafterprint();
</script>-->
<?php


$dat = $this->input->get('dataInicial');
if ($dat == '') {
	$dataimpri = date("d/m/Y");
} else {

	$dataimpri =  date("d/m/Y", strtotime($result[0]->data_abert_orc));
}



?>


<head>
	<title>SGI</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
	<!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/fullcalendar.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/blue.css" class="skin-color" />
    <script type="text/javascript"  src="<?php echo base_url(); ?>js/jquery-1.10.2.min.js"></script>-->
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


					<div class="widget-content nopadding">
						<div align='center'>
							<form>
								<input type="button" value="Imprimir" onClick="window.print()" />
							</form>
						</div>
						<!--<table class="table table-bordered">-->
						<table width='100%' align='center' border='0' class='comBordas'>

							<tr>
								<td style="text-align: center; width: 20%" rowspan='3'><strong><img src=" <?php echo base_url() . $result[0]->url_logoemi . $result[0]->imagememi; ?> " width='55%' height='30%'=></strong></td>
								<td align='center'>
									<font size='4'><b><?php echo $result[0]->nomeemi; ?></b></font> <br> <br>
									<font size='3'>Ordem de Serviço</font>
								</td>
								<td align='center'>
									<font size='3'>Data: <?php echo  date("d/m/Y"); ?><br> Hora:<?php echo date("H:i:s"); ?>
									</font>
								</td>


							</tr>
						</table>
						<table align='center' width='100%' border='1'>


							<tr>
								<td>
									Nº Ordem Serviço: </td>
								<td>
									<b><?php echo $result[0]->idOs; ?> </b>
								</td>
								<td>
									Cod. Orçamento: </td>
								<td>
									<b><?php echo $result[0]->idOrcamentos; ?> </b>
								</td>


							</tr>

							<tr>
								<td>
									Data Lancto O.S.: </td>
								<td>
									<b><?php echo  date("d/m/Y", strtotime($result[0]->data_abertura)); ?> </b>
								</td>
								<td>
									Tipo de Serviço: </td>
								<td>
									<b><?php echo $result[0]->grupo; ?> </b>
								</td>

							</tr>
							<tr>
								<td>
									Data Entrega:
								</td>
								<td><b>
										<?php
										echo  date("d/m/Y", strtotime($result[0]->data_entrega));

										?></b>
								</td>


								<td>Unidade Execução:</td>
								<td><b><?php echo $result[0]->status_execucao; ?></b></td>
							</tr>
							<tr>
								<td>
									Data Agendada:
								</td>
								<td><b>
										<?php
										if ($result[0]->data_reagendada <> null) {
											echo  date("d/m/Y", strtotime($result[0]->data_reagendada));
										} else {
											echo "-";
										}

										?></b>
								</td>
								<td>Unidade Faturamento:</td>
								<td> <b><?php echo $result[0]->status_faturamento; ?></b></td>
							</tr>
							<tr>
								<td>
									Status:
								</td>
								<td><b>
										<?php echo $result[0]->nomeStatusOs; ?></b>
								</td>
								<td>Nº Pedido:<b><?php echo $result[0]->numpedido_os; ?></b></td>
								<td>Tag:<b><?php echo $result[0]->tag; ?></b></td>
							</tr>
							<tr>
								<td colspan='4'>
									<table><br>
										<fieldset>
											<legend align='center'><b>Descrição Serviço</b></legend>
											<?php if(!empty($resultSimplex->response->atividade->qr_code)){?>
												<div style="width: 120px; height:120px">
													<?php echo $resultSimplex->response->atividade->qr_code;?>
												</div>
												<div><?php echo 'O.S.: '. $result[0]->idOs ?></div>
												<?php
												
											}?>
											
											<br>
											<table class="style1" border='0'>
												<tr>
													<td>
														<b>Quantidade: </b> <?php echo $result[0]->qtd_os; ?>
													</td>

												</tr>
												<tr>
													<td>
														<b>Descrição Serviço:</b>


														<?php echo $result[0]->descricao_item; ?> - PN: <?php echo $result[0]->pn; ?> - <?php echo $result[0]->descricao; ?>
													</td>
												</tr>

												<tr>
													<td><br>
														<b>Possuí Desenho:</b>


														<?php if ($result[0]->desenhoTrue) {
															echo "Sim";
														} else {
															echo "Não";
														} ?>
													</td>
												</tr>

												<tr>
													<td colspan='2'>
														<table width='100%' border='0'>

															<tr>
																<td><br>
																	<b>Detalhamento do Serviço:</b><br>
																	<?php echo nl2br($result[0]->detalhe); ?>
																</td>
															</tr>
															<tr>

																<td><br><b>OBS: </b> </td>
																<td><br><b>OBS Setor de Controle: </b> </td>
																<td><br><b>OBS Desenho: </b> </td>
															</tr>
															<tr>
																<td><?php echo $result[0]->obs_os; ?></td>
																<td><?php echo $result[0]->obs_controle; ?></td>
																<td><?php echo $result[0]->obsDesenho; ?></td>

															</tr>




														</table>
													</td>
												</tr>
											</table>
										</fieldset>
									</table>
								</td>
							</tr>
						</table>






					</div>

				</div>


			</div>



		</div>



	</div>




	<!-- Arquivos js-->

	<!-- <script src="<?php echo base_url(); ?>js/excanvas.min.js"></script>
            <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
            <script src="<?php echo base_url(); ?>js/jquery.flot.min.js"></script>
            <script src="<?php echo base_url(); ?>js/jquery.flot.resize.min.js"></script>
            <script src="<?php echo base_url(); ?>js/jquery.peity.min.js"></script>
            <script src="<?php echo base_url(); ?>js/fullcalendar.min.js"></script>
            <script src="<?php echo base_url(); ?>js/sosmc.js"></script>
            <script src="<?php echo base_url(); ?>js/dashboard.js"></script>-->
</body>

</html>