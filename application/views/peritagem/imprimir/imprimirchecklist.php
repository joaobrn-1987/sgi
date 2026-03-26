<?php


$dat = $this->input->get('dataInicial');
if ($dat == '') {
	$dataimpri =  date("d/m/Y", strtotime($infoOrc->data_abertura));
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


	<div class="container-fluid" style="padding-left:5px; padding-right:5px;">
		<div class="row-fluid">
			<div class="span12">

				<div class="widget-box">
					
					<div class="widget-content nopadding">

						<!--<table class="table table-bordered">-->
						<table width='100%' align='center' border='0' class='comBordastitu'>

							<tr>
								<td style="text-align: center; width: 20%" rowspan='3'><strong><img src=" <?php echo base_url() . $dados_emitente->url_logo. $dados_emitente->imagem; ?> " width='55%' height='30%'=></strong></td>
								<td align='center'>
									<table width='100%' border='0'>
										<tr>
											<td colspan='2' align='center' height='50'>
												<b>
													<font size='4'><?php echo $dados_emitente->nome; ?></font>
												</b>
											</td>
										</tr>
										<tr>
											<td>
												<font size='1'>CNPJ: <?php echo $dados_emitente->cnpj; ?></font>
											</td>
											<td>
												<font size='1'>INSCRIÇÃO ESTADUAL: <?php echo $dados_emitente->ie; ?></font> </br>
											</td>

										</tr>
										<tr>
											<td>
												<font size='1'>ENDEREÇO: <?php echo $dados_emitente->rua; ?> Nº: <?php echo $dados_emitente->numero; ?></font>
											</td>
											<td>
												<font size='1'>BAIRRO: <?php echo $dados_emitente->bairro; ?></font>
											</td>
										</tr>
										<tr>
											<td>
												<font size='1'>CIDADE: <?php echo $dados_emitente->cidade; ?> </font>
											</td>
											<td>
												<font size='1'>ESTADO: <?php echo $dados_emitente->uf; ?></font>
											</td>
										<tr>
											<td>
												<font size='1'>E-MAIL: <?php echo $dados_emitente->email; ?></font>
											</td>
											<td>
												<font size='1'>TELEFONE: <?php echo $dados_emitente->telefone; ?></font>
											</td>
										</tr>
									</table>
								</td>
								<!--<td rowspan='3'><table><tr><td>Orçamento Nº: <b><?php echo $dados_emitente->idorc ?></b></td></tr>
								<tr><td>Data Emissão: <b><?php echo date('d/m/Y',  strtotime($dados_emitente->data_abert_orc)) ?></b></td></tr>
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
					ORÇAMENTO Nº: <font size='1'><?php echo $infoOrc->idOrcamentos ?></font>
				</td>
				<td align='center'>
					DATA:<?php echo $dataimpri; ?>
				</td>
			</tr>
		</table>
		<!--<div align="center">Dados Cliente</div>--><br><br>
		<!--  cliente   -->
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
											<!--<td align='center'>Código<br><?php echo $infoOrc->idClientes; ?></td>-->
											<td align='left'>CLIENTE:</td>
											<td width='45%'><?php echo $infoOrc->nomeCliente; ?></td>
											<td align='left'>CNPJ:</td>
											<td><?php echo $infoOrc->documento; ?></td>
										</tr>
										<tr>
											<td align='left' width='13%'>SOLICITANTE: </td>
											<td><?php echo $infoOrc->nome; ?></td>
											<td align='left' width='20%'>E-MAIL SOLICITANTE: </td>
											<td><?php echo $infoOrc->email_solici; ?></td>
										</tr>
										<tr>
											<td align='left'>TELEFONE:</td>
											<td><?php echo $infoOrc->telefone; ?></td>
											<td align='left'>REFERÊNCIA:</td>
											<td><?php echo $infoOrc->referencia; ?></td>

										</tr>
										
									</table>
								</td>
							</tr>


						</table>
						<table width='100%' border='0' style="border-style:solid; border: 1px solid grey;font-family:Arial, Helvetica, sans-serif;font-size:12px;">
							<thead>
								<tr>
									<th rowspan="2"  style="border-style:solid; border: 1px solid grey;">
										PN
									</th>
									<th rowspan="2" style="border-style:solid; border: 1px solid grey;">
										DESCRIÇÃO
									</th>
									<th rowspan="2" style="border-style:solid; border: 1px solid grey;">
										QTD
									</th>
									<th colspan="3" style="border-style:solid; border: 1px solid grey;">
										DIMENSÕES
									</th>
									<th rowspan="2" style="border-style:solid; border: 1px solid grey;">
										OBS/MATERIAL
									</th>
								</tr>
								<tr>
									<th style="border-style:solid; border: 1px solid grey;">
										Ø EXT.
									</th>
									<th style="border-style:solid; border: 1px solid grey;">
										Ø INT.
									</th>
									<th style="border-style:solid; border: 1px solid grey;">
										COMP.
									</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									foreach($orc_escopo_itens as $r){
										$tipoServico = $this->peritagem_model->getTipoServicoByIdOrcItem($r->idOrcServicoEscopoItens);   
										echo '<tr>'.
											'<td  style="border-style:solid; border: 1px solid grey;">'.
												$r->pn.
											'</td>'.
											'<td style="border-style:solid; border: 1px solid grey; height: 25px;">'.
												$r->descricaoServicoItens.
											'</td>'.
											'<td style="border-style:solid; border: 1px solid grey;">';
											if($r->tipoCampo == "input"){
												echo $r->quantidade;
											}
											if($r->tipoCampo == "check"){
												echo '<input type="checkbox" disabled style="width: 20px;" '.($r->checkbox == 1?"checked":"").'>';
											}
											if($r->tipoCampo == "radio"){
												echo ($r->checkbox == 1?"Sim":"Não");
											}												
											echo '</td>'.
											'<td style="border-style:solid; border: 1px solid grey;">'.
												$r->dimenExt.
											'</td>'.
											'<td style="border-style:solid; border: 1px solid grey;">'.
												$r->dimenInt.
											'</td>'.
											'<td style="border-style:solid; border: 1px solid grey;">'.
												$r->dimenComp.
											'</td>'.
											'<td style="border-style:solid; border: 1px solid grey;">'.
												$r->obs.
											'</td>'.
										'</tr>';
										                                                                                     
										if(!empty($tipoServico)){
											foreach($tipoServico as $c){
													echo '<tr>';
														echo '<td style="border-top: 1px solid whitesmoke;">';
														echo '</td>';
														echo '<td style="border-top: 1px solid whitesmoke; padding-left: 20px;">';
															echo $c->descricaoTiposServico;
														echo '</td>';
														echo '<td style="border-top: 1px solid whitesmoke;">';
															echo '<input type="checkbox" width: 20px; disabled '.($c->selecionado == 1?"checked":"").'>';
														echo '</td>';
														echo '<td style="border-top: 1px solid whitesmoke;">';
														echo '</td>';
														echo '<td style="border-top: 1px solid whitesmoke;">';
														echo '</td>';
														echo '<td style="border-top: 1px solid whitesmoke;">';
														echo '</td>';
														echo '<td style="border-top: 1px solid whitesmoke;">';
														echo '</td>';				
													echo '</tr>';
											}
											echo '<tr style="border: 0px; heigth:10px; border-top:1px solid black"></tr>';
										}
									}
								?>
								
							</tbody>
						</table>
					</div>

				</div>


			</div>



		</div>


		
		<br> <br>


	</div>




	
</body>

</html>