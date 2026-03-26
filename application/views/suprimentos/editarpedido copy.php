
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>

<?php

if(!$results){
		
?>


        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>OS</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        
                        <th>Nº OS</th>
                        <th>Qtd.</th>
                        <th>Descrição</th>
                        <th>Dimensões</th>
                        <th>OBS</th>
                        <th>Data Cadastro</th>
                        <th>Status</th>
                        <th>Pedido Cotação</th>
                        <th>Pedido Compra</th>
                        <th>Data Entregue</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Item Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{
echo "<br>";
echo "<br>";	

?>
 <body onLoad="calculaSubTotal();" >
 <div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Pedido de Compra - Número: <?php echo $this->uri->segment(3); ?> | Data abertura: <?php echo date("d/m/Y H:i:s", strtotime($results[0]->data_cadastro));?></h5>
			<?php
			if($results[0]->idEmitente <> ''&& $results[0]->idFornecedores <> '')
			{
			if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
				echo '<a href="'.base_url().'index.php/pedidocompra/imprimir_pedido/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'" style="margin-right: 1%" class="class="btn btn-mini btn-info" title="Imprimir pedido" target="_blank"><button class="btn btn-mini btn-info" title="Imprimir PDF"><i class="icon-print icon-white"> Imprimir</i></button></a>'; 
				
				
				echo'<a href="#modal-imprimiritem" style="margin-right: 1%" role="button" data-toggle="modal" title="Imprimir Parcial"><font color="blue"><i class="icon-print icon-white">Imprimir Parcial</i></font></a>';
				
			} 
			}			
			?>
			
            </div>
			
            <div class="widget-content nopadding">
                

                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Dados Pedido</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                 
                              <form class="form-inline" action="<?php echo base_url() ?>index.php/pedidocompra/editarpedidocompra" method="post">
               

                                   
									<div  style="padding: 1%; margin-left: 1">    
                                        <div class="span6" class="control-group">
                                            <label for="idEmitente" class="control-label">Empresa:</label>
<input id="idPedidoCompra"  type="hidden" name="idPedidoCompra" value="<?php echo $results[0]->idPedidoCompra; ?>"  />											
											<?php if(isset($results[0]->idEmitente))
											{
												?>
<input id="emitente" onclick="this.select();" class="span12" class="controls" type="text" name="emitente" value="<?php echo $results[0]->nome; ?>" size='50' />
<input id="emitente_id"  type="hidden" name="emitente_id" value="<?php echo $results[0]->idEmitente; ?>"  />
							 
							 <?php
											}
											else
											{
												?>
												
											<input id="emitente" class="span12" class="controls" type="text" name="emitente" value="" size='50' />
<input id="emitente_id"  type="hidden" name="emitente_id" value=""  />	
												<?php
											}
											?>
											
                
                       
                                        </div>
										<div class="span6" class="control-group">
                                            <label for="idFornecedores" class="control-label">Fornecedor:</label>
 <?php if(isset($results[0]->idFornecedores))
											{
												?>                      
<input id="fornecedor" onclick="this.select();" class="span12" class="controls" type="text" name="fornecedor" value="<?php echo $results[0]->nomeFornecedor; ?>" size='50' />
<input id="fornecedor_id"  type="hidden" name="fornecedor_id" value="<?php echo $results[0]->idFornecedores; ?>"  />
							 					   
					    <?php
											}
											else
											{
												?>
												
												<input id="fornecedor" class="span12" class="controls" type="text" name="fornecedor" value="" size='50' />
<input id="fornecedor_id"  type="hidden" name="fornecedor_id" value=""  />

<?php
											}
											?>
					   
					 
                                        </div>
                                        </div>
										
										 
                                      

                                   
									
										<div class="span12" class="control-group"><br><b>Dados NF Vinculada a essa OC:</b>
										<table width='100%'>
										<?php 
		$somatoria = 1;
		$descontoitem = '';
		$icmsitem = '';
		$outrositem = '';
		$freteitem = '';
		foreach ($resultsnf as $rnf) {
			
			echo "<tr><td><font color='red'>DADOS ".$somatoria.":</font></td></tr>"; 
			?>
			<tr><td>
			 Prazo Entrega:<b><?php echo $rnf->prazo_entrega; ?></b> dias</td>
			  <td>Previsão Entrega:<b><?php if(!empty($rnf->previsao_entrega)) { echo date("d/m/Y", strtotime($rnf->previsao_entrega));}; ?></b></td>
			  <td colspan='2'> Forma de pagamento:<b><?php echo $rnf->nome_status_cond_pgt; ?></b></td>
			   <td colspan='2'> Condição de pagamento:<b><?php echo $rnf->cod_pgto; ?></b></td></tr>
				
				 <tr><td>Desconto:<b><?php echo number_format($rnf->desconto, 2, ",", ".") ; ?></b></td>
				<td> ICMS:<b><?php echo number_format($rnf->icms, 2, ",", ".") ;  ?></b></td>
				<td> Outros:<b><?php echo number_format($rnf->outros, 2, ",", ".") ;  ?></b></td>
				<td> Frete:<b><?php echo number_format($rnf->frete, 2, ",", ".") ;  ?></b></td>
			 <td>Data NF:<b><?php if(!empty($rnf->datanf)) { echo date("d/m/Y", strtotime($rnf->datanf));}; ?></b></td>
   <td>Nº NF:<b><?php echo $rnf->notafiscal; ?></b></td></tr>
   <tr><td colspan='8'> OBS:<br><b><?php echo nl2br($rnf->obscompras); ?></b></td></tr>
   <br><br>
		<?php	
		$somatoria ++;
		$descontoitem = $descontoitem + $rnf->desconto;
		$icmsitem = $icmsitem + $rnf->icms;
		$outrositem = $outrositem + $rnf->outros;
		$freteitem = $freteitem + $rnf->frete;
			
		
		}
		?>
		</table>
		<input  type="hidden" name="icms" id="icms" value="<?php echo number_format($icmsitem, 2, ",", ".") ;?>"  >
<input type="hidden" name="frete" id="frete" value="<?php echo number_format($freteitem, 2, ",", ".");?>"  >
<input  type="hidden" name="desconto" id="desconto" value="<?php echo number_format($descontoitem, 2, ",", ".");?>"  >
 <input type="hidden" name="outros" id="outros"  value="<?php echo number_format($outrositem, 2, ",", ".");?>"  >
 
 
									<!--<div class="span2" class="control-group">
<label for="previsao_entrega" class="control-label">Nota fiscal Fornecedor:</label><br>									<?php
									   
if(isset($results[0]->notafiscal))
							{
								$notafiscal = $results[0]->notafiscal;
							}
							else
							{
								$notafiscal = '';
							}
							
							?>
										 <input class="span12 form-control" onclick="this.select();" type="text" name="notafiscal" value="<?php echo $notafiscal; ?>"  >
										
                                        </div>
<div class="span2" class="control-group">
                                            <label for="datanf" class="control-label">Data Nota fiscal:</label><br>
											<?php
											if(isset($results[0]->datanf))
											{
												$datanf =  date("d/m/Y", strtotime($results[0]->datanf));
											}
											else
											{
												$datanf = '';
											}
											?>
											
<input id="idPedidoCompra"  type="hidden" name="idPedidoCompra" value="<?php echo $results[0]->idPedidoCompra; ?>"  />
											<input id="datanf" class="span12 data" type="text" name="datanf" value="<?php echo $datanf;  ?>" onclick="this.select();"/>
											
                      
                       
                                        </div>	-->									
										
										
										
                                        </div>

										
                                   
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                       
										 <div class="form-actions" align='center'>
                        
           <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Salvar</button>
                               
                           
                    </div> 
										
                                    </div>
									
									
                                    
                          </form>    
                            </div>

                        </div>

                    </div>

                </div>

                
.
             
        </div>
        
    </div>
</div>
</div>

<div class='span12'>
Filtrar: <b>Status Compra:</b><select  class="controls" name="idStatuscompras2_" id="idStatuscompras2_">
						<option value=''></option> 
							<option value='<?php echo base_url() ?>index.php/pedidocompra/editarpedido/<?php echo $results[0]->idPedidoCompra;?>'>TODOS</option> 
							<?php foreach ($dados_statuscompra as $so) { ?>
                       
                        <option value="<?php echo base_url() ?>index.php/pedidocompra/editarpedido/<?php echo $results[0]->idPedidoCompra;?>/st-<?php echo $so->idStatuscompras; ?>" ><?php echo $so->nomeStatus; ?></option>
                        <?php } ?>
                       
					    
                            </select>
						<b>	Nota Fiscal:</b><select  class="controls" name="nto" id="nto">
						<option value=''></option> 
							<option value='<?php echo base_url() ?>index.php/pedidocompra/editarpedido/<?php echo $results[0]->idPedidoCompra;?>'>TODOS</option> 
							<?php foreach ($resultsnf as $gg) {?>
                       
                        <option value="<?php echo base_url() ?>index.php/pedidocompra/editarpedido/<?php echo $results[0]->idPedidoCompra;?>/nf-<?php echo $gg->notafiscal; ?>" ><?php echo $gg->notafiscal; ?></option>
                        <?php } ?>
                       
					    
                            </select>
					<b>	OS:</b><select  class="controls" name="os_" id="os_">
						<option value=''></option> 
							<option value='<?php echo base_url() ?>index.php/pedidocompra/editarpedido/<?php echo $results[0]->idPedidoCompra;?>'>TODOS</option> 
							<?php foreach ($resultsosf as $os) {?>
                       
                        <option value="<?php echo base_url() ?>index.php/pedidocompra/editarpedido/<?php echo $results[0]->idPedidoCompra;?>/os-<?php echo $os->idOs; ?>" ><?php echo $os->idOs; ?></option>
                        <?php } ?>
                       
					    
                            </select>		
							
</div>
 </form>
 
 
 <script>
$('#idStatuscompras2_').change(function() {
    window.location = $(this).val();
});
$('#nto').change(function() {
    window.location = $(this).val();
});
$('#os_').change(function() {
    window.location = $(this).val();
});

</script>
 
 
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Itens Pedido de compra</h5><a href="#modal-dadosnotafiscal" style="margin-right: 1%" role="button" data-toggle="modal" title="Dados Nota Fiscal"><font color="blue"><i class="icon-pencil icon-white"> <b>INSERIR DADOS NOTA FISCAL DOS ITENS ABAIXO:</b></i></font></a>
		<br>

							
							
     </div>
	 
<div >

<form  action="<?php echo base_url() ?>index.php/pedidocompra/salvaritemcompra" method="post">
	<table class="table table-bordered">
   
        <tr>        
                        
			<th>Nº OS </th>
			<th>Qtd<br>Editar</th>
			<th>Descrição</th>
			
			<th width='100'>OBS</th>
			
			<th>Status<a href="#modal-ipi" style="margin-right: 1%" role="button" data-toggle="modal"   title="Editar IPI"><font color='red'><i class="icon-pencil icon-white"></i></font></a></th>
			<th>Data <br>Entregue<a href="#modal-ipi" style="margin-right: 1%" role="button" data-toggle="modal"   title="Editar IPI"><font color='red'><i class="icon-pencil icon-white"></i></font></a></th>
			<th>Grupo</th>
			<th width='15'>QTD<br>recebida</th>
			<th>Valor Unit.</th>
			<th width='35'>IPI% <a href="#modal-ipi" style="margin-right: 1%" role="button" data-toggle="modal"   title="Editar IPI"><font color='red'><i class="icon-pencil icon-white"></i></font></a></th>
			<th>Valor <br>total</th>
			
			<th>N° NF <a href="#modal-ipi" style="margin-right: 1%" role="button" data-toggle="modal"   title="Editar IPI"><font color='red'><i class="icon-pencil icon-white"></i></font></a></th>
						
                        
        </tr>
    
         <?php 
		$contador = 0;
		foreach ($results as $r) {
			$color = '';
			
			
		 ?>
			
           <tr>
	
			<input id="idPedidoCompraItens"  type="hidden" name="idPedidoCompraItens[]" value="<?php echo $r->idPedidoCompraItens;?>"  />
			<input id="idCotacaoItens"  type="hidden" name="idCotacaoItens[]" value="<?php echo $r->idCotacaoItens;?>"  />
			<input type="hidden" id="item<?php echo $contador;?>" name="item[]"  value="" size="1"/>
           <td><a href="#modal-usuario<?php echo $r->idPedidoCompraItens; ?>" style="margin-right: 1%" role="button" data-toggle="modal" class="btn tip-top" ><i class="icon icon-user"></i></a><font size='1'><?php echo $r->idOs;?></font></td>
           <td><input id="quantidade<?php echo $contador;?>"  type="hidden" name="quantidade[]" value="<?php echo $r->quantidade;?>"  /><?php echo $r->quantidade;?> -
			<?php
			if($r->liberado_edit_compras == 0 )
			{
				if($r->idStatuscompras <> 7)
				{
				?>
				<a href="#modal-editar_1" style="margin-right: 1%" role="button" data-toggle="modal" id_disti1="<?php echo $r->idDistribuir; ?>"  title="Destravar para editar"><font color='red'><i class="icon-remove icon-white"></i></font></a>
				
				
				
				<?php
				}
			}
			else
			{
				?>
				<a href="#modal-editar_0" style="margin-right: 1%" role="button" data-toggle="modal" id_disti2="<?php echo $r->idDistribuir;?>" title="Travar edição"><font color='blue'><i class="icon-pencil icon-white"></i></font></a>
			<?php
			}

			?>		   
		  
		   
		  
		   </td> 
           <td><font size='1'><?php echo $r->descricaoInsumo." ".$r->dimensoes;?></font></td>
           
           <td width='10'><font size='1'><?php echo $r->obs;?></font></td>
            
            <td>
			 <select class="recebe-solici" class="controls" style="font-size: 10px;" name="idStatuscompras[]" id="idStatuscompras">
							 
							<?php foreach ($dados_statuscompra as $so) { ?>
                       <?php
					   if($r->idOs <= 19999)
					   {
							?>
						  <option value="<?php echo $so->idStatuscompras; ?>" <?php if($so->idStatuscompras == $r->idStatuscompras){ echo "selected='selected'";}?>><?php echo $so->nomeStatus; ?></option>
						   <?php
					   }
					   else
					   {
						   if($so->idStatuscompras <> 8)
						   {
						   ?>
						  <option value="<?php echo $so->idStatuscompras; ?>" <?php if($so->idStatuscompras == $r->idStatuscompras){ echo "selected='selected'";}?>><?php echo $so->nomeStatus; ?></option>
						   <?php
						   }
					   }
					   ?>
                        
                        <?php } ?>
                       
					    
                            </select>
			
			</td>
				<td> 
			<font size='1'>	
			<?php 
			$hratu = date("H:i:s");
			if(!empty($r->datastatusentregue))
			{
				echo $dataentr = date("d/m/Y", strtotime($r->datastatusentregue));
					//$dataentr1 = date("d/m/Y", strtotime($r->datastatusentregue));
					//$dataentr2 = date("H:i:s", strtotime($r->datastatusentregue));
				
				?>
					<input id="dataentregue" class="data span14" type="hidden" name="dataentregue[]" value="<?php echo $dataentr;?>"/>
					<!--<input id="dataentregue" class="data span14" type="hidden" name="dataentregue[]" value="<?php echo $dataentr1;?>"/>
					<input id="horaentregue" class="data span14" type="hidden" name="horaentregue[]" value="<?php echo $dataentr2;?>"/>-->
				<?php
			}
			else
			{
				?>
				
			<input id="dataentregue" class="data span14" type="text" name="dataentregue[]" value="" style="font-size: 10px;" size='17'/> 
			<!--<input id="horaentregue" class="data span14" type="hidden" name="horaentregue[]" value="<?php echo $hratu;?>"/>-->
				<?php
			}
			?>
			</font>   
				
			</td>
				
				<td>
				<font size='1'>
				<?php echo $r->nomegrupo;?></font>
				
				<?php
			if( $r->idgrupo == 5)
			{
				
				$entrada = $this->pedidocompra_model->gettable2("estoque_entrada","estoque_entrada.idPedidoCompraItens",$r->idPedidoCompraItens);
				if(count($entrada) == 0)
				{
					?>
					<a href="#modalsaida2" data-toggle="modal" role="button" idInsumos_e="<?php echo $r->idInsumos ;?>" idPedidoCompra_e="<?php echo $r->idPedidoCompra ;?>" idPedidoCompraItens_e="<?php echo $r->idPedidoCompraItens ;?>" quantidade_e="<?php echo $r->quantidade ;?>" dimensoes_e="<?php echo $r->dimensoes ;?>" valor_unitario_e="<?php echo $r->valor_unitario ;?>" idEmitente_e="<?php echo $r->idEmitente ;?>"><img src="<?php echo base_url()?>assets/img/sign-in.png" title="Dar Entrada" /></a>
					
				
				<?php  
				}
				else{
				//$r->idInsumos    $r->idPedidoCompra  $r->idPedidoCompraItens  $r->quantidade   $r->dimensoes   $r->valor_unitario   $r->idEmitente   
				?>
				<img src="<?php echo base_url()?>assets/img/check.png" title="Ad. Estoque" />
				<?php
				}
			}
			?>
				
				
				</td>
			<td><input class="span8" onclick="this.select();" type="text" style="font-size: 10px;" name="qtdrecebida[]" value="<?php echo $r->qtdrecebida; ?>" ></td>
			
			<td>
			<!--
			<input style="font-size: 10px;" class="span12" onclick="this.select();" onKeyPress="FormataValor2(this,event,10,4);" type="text" id="valor_unitario<?php echo $contador;?>"  name="valor_unitario[]" value="<?php echo number_format($r->valor_unitario, 4, ",", "."); ?>"  onKeyUp="calculaSubTotal(<?php echo $contador; ?>);"> -->
			<input style="font-size: 10px;" class="span12" onclick="this.select();"  type="text" id="valor_unitario<?php echo $contador;?>"  name="valor_unitario[]" value="<?php echo number_format($r->valor_unitario, 4, ",", "."); ?>"  onKeyUp="calculaSubTotal(<?php echo $contador; ?>);">
			</td>
			<td>
			<input style="font-size: 10px;" class="span12" onclick="this.select();"  type="text" id="ipi_valor<?php echo $contador;?>" onKeyPress="FormataValor2(this,event,10,2);"  name="ipi_valor[]" value="<?php echo number_format($r->ipi_valor, 2, ",", "."); ?>"  onKeyUp="calculaSubTotal(<?php echo $contador; ?>);">
			</td>
			<td> <?php
	
	

			?>	
			<input style="font-size: 10px;" type="text" id="valor_produtos<?php echo $contador;?>" name="valor_produtos[]"   value="<?php echo number_format($r->valor_total, 2, ",", "."); ?>" readonly="true" class='span12'/>

			</td>
				
			<td>

			 	 <?php
				if($r->notafiscal){
				 ?>
					<a href="#modal-nfdata<?php echo $r->idPedidoCompraItens; ?>" style="margin-right: 1%" role="button" data-toggle="modal" class="btn tip-top" ><font size='1'><?php echo $r->notafiscal; ?></font></a>
				 <?php
				}else{
				 ?>	
					<input class="span8" type="text" style="font-size: 10px;" name="nNotaFiscal[]" value="<?php echo $r->notafiscal; ?>" readonly="true"/>
				 <?php
				}
				 ?>
			

			<!--<i class="icon icon-file"></i>-->
			</td>
					
					<div id="modal-usuario<?php echo $r->idPedidoCompraItens; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 id="myModalLabel">Histórico de Usuario</h5>
			</div>
			<div class="modal-body">
				Informação do usuario que cadastrou e sequencia de alterações realizadas:<br>
				<?php echo $r->histo_alteracao; ?>
			</div>
	
	
			</div>
			<div id="modal-nfdata<?php echo $r->idPedidoCompraItens; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 id="myModalLabel">Dados NF Status</h5>
			</div>
			<div class="modal-body">
	
			<?php 
			
				
			?>

			<div style="float:right; size:20px">
				
				<font size="3">
					<input class="span8" name="linhaNF" value ="<?php echo $contador ?>" type="hidden"/>
					<input class="span8" type="text" style="font-size: 10px;" name="nNotaFiscal" value="<?php echo $r->notafiscal; ?>"/>
					<input class="span8" type="text" style="font-size: 10px;" name="dataNotaFiscal" value="<?php echo $r->notafiscal; ?>"/>
					Nº NF:<b><?php echo $r->notafiscal; ?></b><br>
					Data NF:<b><?php if(!empty($r->datanf)) { echo date("d/m/Y", strtotime($r->datanf));}; ?></b><br>
				</font>	
			</div>
				
			Prazo Entrega:<b><?php echo $r->prazo_entrega; ?></b> dias<br>
			Previsão Entrega:<b><?php if(!empty($r->previsao_entrega)) { echo date("d/m/Y", strtotime($r->previsao_entrega));}; ?></b><br>
			Forma de pagamento:<b><?php echo $r->nome_status_cond_pgt; ?></b><br>
			Condição de pagamento:<b><?php echo $r->cod_pgto; ?></b><br>

			Desconto:<b><?php echo number_format($r->desconto, 2, ",", ".") ; ?></b><br>
			ICMS:<b><?php echo number_format($r->icms, 2, ",", ".") ;  ?></b><br>
			Outros:<b><?php echo number_format($r->outros, 2, ",", ".") ;  ?></b><br>
			Frete:<b><?php echo number_format($r->frete, 2, ",", ".") ;  ?></b><br>			
			OBS:<b><?php echo nl2br($r->obscompras); ?></b><br>

			
			
			</div>
	
	
			</div>	
			<?php
				
				
				echo '</tr>';
				
				?>
		
		
			
				
			<?php
			$contador ++;
        }
		
		?>
        <tr>
          <input id="idPedidoCompra"  type="hidden" name="idPedidoCompra" value="<?php echo $results[0]->idPedidoCompra; ?>"  />
        </tr>
   
		</table>
 		<div class="span12" style="padding: 1%; margin-left: 0">
                                       
										 <div class="form-actions" align='center'>
                        
           <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> SALVAR ITENS</button>
                               
                           
                    </div> 
										
                                    </div>
</form>
</div>
</div>

<div align='right' >
 VALOR DOS PRODUTOS R$:<input name="valor_produtos_" type="text" id="valor_produtos_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0,00" size="12" readonly="true">
</div>
<div align='right'>
IPI R$: <input name="ipi_" type="text" id="ipi_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
</div>
<div align='right'>
DESCONTO R$: <input name="desconto_" type="text" id="desconto_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
</div>
<div align='right'>
OUTROS R$: <input name="outros_" type="text" id="outros_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
</div>
<div align='right'>
FRETE R$: <input name="frete_" type="text" id="frete_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
</div>
<div align='right'>
ICMS R$: <input name="icms_" type="text" id="icms_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
</div>
<div align='right'>
TOTAL R$: <input name="valor_total_" type="text" id="valor_total_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
</div>


	 





<?php echo $this->pagination->create_links();}?>





<div id="modal-imprimiritem" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/pedidocompra/imprimiritem" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Marcar itens para imprimir</h5>
  </div>
  <div class="modal-body">
  <input id="idPedidoCompraipi"  type="hidden" name="idPedidoCompraipi" value="<?php echo $results[0]->idPedidoCompra; ?>"  />
 
	
							<br><br>
  <b>Qtd ***** Descrição</b><br>
  <?php 
		$contadoripi = 0;
		foreach ($results as $novo) {
			$color = '';
			
			
			?>
			
          
		 <input name="idPedidoCompraItensipi[]" type="checkbox"  value="<?php echo $novo->idPedidoCompraItens;?>" checked>
 
  <?php echo $novo->quantidade;?> ***** <php echo $novo->descricaoInsumo." ".$novo->dimensoes;?>
  <br>
  <?php
		}
		?>
    
      
   
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Imprimir</button>
  </div>
  </form>
</div>	

<div id="modal-ipi" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/pedidocompra/editar_ipi" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Informar o valor nos campos e selecionar todos que irão alterar:</h5>
  </div>
  <div class="modal-body">
  <input id="idPedidoCompraipi"  type="hidden" name="idPedidoCompraipi" value="<?php echo $results[0]->idPedidoCompra; ?>"  />
  Valor IPI%:<input id="valoripi" onKeyPress="FormataValor2(this,event,10,2);" onclick="this.select();"  type="text" name="valoripi" value=""  />% ex.:5,00<br><br>
  Status Compra:<select class="recebe-solici" class="controls" name="idStatuscompras2" id="idStatuscompras2">
							<option value=''></option> 
							<?php foreach ($dados_statuscompra as $so) { ?>
                       
                        <option value="<?php echo $so->idStatuscompras; ?>" ><?php echo $so->nomeStatus; ?></option>
                        <?php } ?>
                       
					    
                            </select>	<br><br>					
							
							
 <!--<select class="recebe-solici" class="controls" name="idgrupo" id="idgrupo">
							<option value='0'></option> 
							<?php foreach ($dados_statusgrupo as $so) { ?>
                       
                        <option value="<?php echo $so->idgrupo; ?>" ><?php echo $so->nomegrupo; ?></option>
                        <?php } ?>
                       
					    
                            </select>-->
	Data entregue:<input id="dataentregue2" class="data" type="text" name="dataentregue2" value="" style="font-size: 10px;" size='17'/><br><br>
	N° NF: <input id="nNotaFiscal2" type="text" name="nNotaFiscal2" value="" style="font-size: 10px;" size='17'/>

							<br><br>
  <b>Qtd ***** Descrição</b><br>
  <?php 
		$contadoripi = 0;
		foreach ($results as $novo) {
			$color = '';
			
			
			?>
			
          
		 <input name="idPedidoCompraItensipi[]" type="checkbox"  value="<?php echo $novo->idPedidoCompraItens;?>">
 
  <?php echo $novo->quantidade;?> ***** <?php echo $novo->descricaoInsumo." ".$novo->dimensoes;?>
  <br>
  <?php
		}
		?>
    
      
    <h5 style="text-align: center">Deseja alterar os itens selecionados para os valores informado?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Alterar</button>
  </div>
  </form>
</div>
<div id="modal-dadosnotafiscal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form action="<?php echo base_url() ?>index.php/pedidocompra/editar_notafiscal" method="post" >
  		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		<h5 id="myModalLabel">Informar o valor nos campos e selecionar todos que irão alterar:</h5>
  		</div>
  <div class="modal-body">


	<?php
	/*
		foreach($results as $r_dadosNota){
			$e_dta_prev_entrega = $r_dadosNota->previsao_entrega;
			if($e_dta_prev_entrega){
				$e_prev_entrega = date('d-m-Y', strtotime($e_dta_prev_entrega));
			}else{
				$e_prev_entrega = '';
			}
			print_r($e_prev_entrega);
			$e_praz_entrega = $r_dadosNota->prazo_entrega;
			$e_idCondPgt = $r_dadosNota->idCondPgto; 
			$e_nom_status_cond_pgt = $r_dadosNota->nome_status_cond_pgt;
			$e_condPag = $r_dadosNota->cod_pgto;
			$e_icms = $r_dadosNota->icms;
			$e_frete = $r_dadosNota->frete;
			$e_desconto = $r_dadosNota->desconto;
			$e_outros = $r_dadosNota->outros;
			$e_dta_datanf = $r_dadosNota->datanf;
			if($e_dta_datanf){
				$e_datanf = date('d-m-Y', strtotime($e_dta_datanf));
			}else{
				$e_datanf = '';
			}
			$e_notafiscal = $r_dadosNota->notafiscal;
			$e_obscompras = $r_dadosNota->obscompras;
		}
	*/
	?>

  <table>
	<tr>
		<td> 
			<input id="idPedidoCompraipi"  type="hidden" name="idPedidoCompraipi" value="<?php echo $results[0]->idPedidoCompra; ?>" />
			Previsão de entrega:<input size='6' id="previsao_entrega" class=" data" type="date" name="previsao_entrega" value="<?php //if($e_prev_entrega){echo $e_prev_entrega;} ?>" placeholder="<?php //if($e_prev_entrega){echo $e_prev_entrega;} ?>"/>

		</td>
		<td>
			Prazo de entrega:<input size='3' class="span8 form-control"  type="text" name="prazo_entrega" value="<?php //if($e_prev_entrega != ''){echo $e_praz_entrega;} ?>" placeholder="<?php //if($e_praz_entrega){echo $e_praz_entrega;} ?>"  />dias
		</td>
  		<td>
			Pagamento:
			<select class=" recebe-solici" class=" controls" name="idCondPgto" id="idCondPgto">
							 <option value="" <?php if(!$e_idCondPgt){echo 'selected';} ?>></option>
							<?php foreach ($dados_statuscondicao as $cond) { 
							if(isset($results[0]->idCondPgto))
							{
							
							?>
                       
 					<option value="<?php echo $cond->id_status_cond_pgt;?>" <?php //if($cond->id_status_cond_pgt == $e_idCondPgt){echo 'selected="true"' ;} ?> ><?php //echo $cond->nome_status_cond_pgt; ?></option>
					  
                        <?php 
							}
							else{
								?>
								
								<option value="<?php echo $cond->id_status_cond_pgt; ?>" <?php //if($cond->id_status_cond_pgt == $e_idCondPgt){echo 'selected="true"' ;} ?>><?php //echo $cond->nome_status_cond_pgt; ?></option>
								
								<?php
							}
						
						} ?>
                       
					    
                            </select></td>
							
  		<td>
			Condição de pagamento:
 			<input class=" form-control" size='50' type="text" name="cod_pgto" value="<?php if($e_condPag){echo $e_condPag;} ?>" placeholder="<?php if($e_condPag){echo $e_condPag;} ?>" />
		</td>
  
  		</tr>
  <tr>
  <td colspan='4'>ICMS:
<input class=" form-control" size='7' onKeyPress="FormataValor2(this,event,10,2);"  type="text" name="icmsit" id="icmsit" value="<?php if($e_icms){echo $e_icms;} ?>" placeholder="<?php if($e_icms){echo $e_icms;} ?>" />Frete:
<input class=" form-control" size='7' onKeyPress="FormataValor2(this,event,10,2);" type="text" name="freteit" id="freteit" value="<?php if($e_frete){echo $e_frete;} ?>" placeholder="<?php if($e_frete){echo $e_frete;} ?>" />Desconto:
 <input class=" form-control"  size='7'onKeyPress="FormataValor2(this,event,10,2);" type="text" name="descontoit" id="descontoit" value="<?php if($e_desconto){echo $e_desconto;} ?>" placeholder="<?php if($e_desconto){echo $e_desconto;} ?>" />Outros:
 <input class=" form-control" size='7' onKeyPress="FormataValor2(this,event,10,2);" type="text" name="outrosit" id="outrosit" value="<?php if($e_outros){echo $e_outros;} ?>" placeholder="<?php if($e_outros){echo $e_outros;} ?>" />Data NF:<input id="datanf" size='7' class="data" type="text" name="datanf" style="font-size: 10px;" size='17' value="<?php if($e_datanf){echo $e_datanf;} ?>" placeholder="<?php if($e_datanf){echo $e_datanf;} ?>" />Nº NF:<input id="nf" size='7'  type="text" name="nf" style="font-size: 10px;" size='17' value="<?php if($e_notafiscal){echo $e_notafiscal;} ?>" placeholder="<?php if($e_notafiscal){echo $e_notafiscal;} ?>" /></td>
  </tr>
  <tr><td colspan='6'>OBS:
 <textarea id="obs" rows="5" cols="100" class="" name="obs"><?php if($e_obscompras){echo $e_obscompras;} ?></textarea></td></tr>

 
  </table>
 
  

	
							<br><br>
  <b>Qtd ***** Descrição</b><br>
  <?php 
		$contadoripi = 0;
		foreach ($results as $novo) {
			$color = '';
			
			
			?>
			
          
		 <input name="idPedidoCompraItensipi[]" type="checkbox"  value="<?php echo $novo->idPedidoCompraItens;?>">

		 <input id="idCotacaoItens2"  type="hidden" name="idCotacaoItens2[]" value="<?php echo $novo->idCotacaoItens;?>"  />
 
  <?php echo $novo->quantidade;?> ***** <?php echo $novo->descricaoInsumo." ".$novo->dimensoes;?>
  <br>
  <?php
		}
		?>
    
      
    <h5 style="text-align: center">Deseja alterar os itens selecionados para os valores informado?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Alterar</button>
  </div>
  </form>
</div>
<div id="modal-editar_1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/pedidocompra/editar_1" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Liberar item para editar quantidade</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="id_item_pc1" name="id_item_pc1" value="" />
   
      <input id="idPedidoCompra"  type="hidden" name="idPedidoCompra" value="<?php echo $results[0]->idPedidoCompra; ?>"  />
    <h5 style="text-align: center">Deseja realmente liberar este item para edição?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Liberar</button>
  </div>
  </form>
</div>

<div id="modal-editar_0" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/pedidocompra/editar_0" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Travar item para edição de quantidade</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="id_item_pc2" name="id_item_pc2" value="" />
    <input id="idPedidoCompra"  type="hidden" name="idPedidoCompra" value="<?php echo $results[0]->idPedidoCompra; ?>"  />
    <h5 style="text-align: center">Deseja travar edição?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Confirmar</button>
  </div>
  </form>
</div>

<script type="text/javascript">
	var contador_global_autocomplete = <?php echo $contador;?>;
	
	var contador_local_autocomplete=contador_global_autocomplete;
	
	//alert('contglobal'+contador_global_autocomplete);
</script>


<div id="modalsaida2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/estoque/cadastrarestoque" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">SGI - Entrada Item para Estoque</h3>
  </div>
  <div class="modal-body">
 
  <input type="hidden" id="compra" name="compra" value="1" />
  <input type="hidden" id="idInsumos_e1" name="idInsumos_e1" value="" />
  <input type="hidden" id="idPedidoCompra_e1" name="idPedidoCompra_e1" value="" />
  <input type="hidden" id="idPedidoCompraItens_e1" name="idPedidoCompraItens_e1" value="" />
  <input type="hidden" id="quantidade_e1" name="quantidade_e1" value="" />
  <input type="hidden" id="dimensoes_e1" name="dimensoes_e1" value="" />
  <input type="hidden" id="valor_unitario_e1" name="valor_unitario_e1" value="" />
  <input type="hidden" id="idEmitente_e1" name="idEmitente_e1" value="" />
	Você confirma dar entrada no estoque desse item?					
  </div>
  
  
  
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-success" id="saida3">Cadastrar Estoque</button>
  </div>
  </form>
</div>

<script type="text/javascript">
$(document).ready(function(){




   $(document).on('click', 'a', function(event) {
        
        var idInsumos_e = $(this).attr('idInsumos_e');
        var idPedidoCompra_e = $(this).attr('idPedidoCompra_e');
        var idPedidoCompraItens_e = $(this).attr('idPedidoCompraItens_e');
        var quantidade_e = $(this).attr('quantidade_e');
        var dimensoes_e = $(this).attr('dimensoes_e');
        var valor_unitario_e = $(this).attr('valor_unitario_e');
        var idEmitente_e = $(this).attr('idEmitente_e');
        $('#idInsumos_e1').val(idInsumos_e);
        $('#idPedidoCompra_e1').val(idPedidoCompra_e);
        $('#idPedidoCompraItens_e1').val(idPedidoCompraItens_e);
        $('#quantidade_e1').val(quantidade_e);
        $('#dimensoes_e1').val(dimensoes_e);
        $('#valor_unitario_e1').val(valor_unitario_e);
        $('#idEmitente_e1').val(idEmitente_e);

    });

});

</script>

<script type="text/javascript">



$(document).ready(function(){
	
jQuery(".data").mask("99/99/9999");
   });
   

$(function() {
   $(document).on('click', 'input[type=text][id=example1]', function() {
     this.select();
   });
 });
 
 
$(document).on('click', 'a', function(event) {
        
        var id_disti1 = $(this).attr('id_disti1');
        $('#id_item_pc1').val(id_disti1);

    });

$(document).on('click', 'a', function(event) {
        
        var id_disti2 = $(this).attr('id_disti2');
        $('#id_item_pc2').val(id_disti2);

    });	
	
 $("#emitente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/pedidocompra/autoCompleteEmitente",
            minLength: 1,
            select: function( event, ui ) {

                 $("#emitente_id").val(ui.item.id);
                
					

            }
      });
	  
$("#fornecedor").autocomplete({
            source: "<?php echo base_url(); ?>index.php/pedidocompra/autoCompletefornecedor",
            minLength: 1,
            select: function( event, ui ) {

                 $("#fornecedor_id").val(ui.item.id);
                
					

            }
      });
	  
/*$(document).ready(function(){

      $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteInsumo",
            minLength: 1,
            select: function( event, ui ) {

                 $("#idInsumos").val(ui.item.id);
                
					//getValor(ui.item.id);

            }
      });
  
     
   
});*/

function FormataValor2(objeto, teclapres, tammax, decimais) {
	var tecla			= teclapres.keyCode;
	var tamanhoObjeto	= objeto.value.length;

	

	if ((tecla == 8) && (tamanhoObjeto == tammax))
		tamanhoObjeto = tamanhoObjeto - 1 ;



	if (( tecla == 8 || tecla == 88 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ) && ((tamanhoObjeto+1) <= tammax)) {
		
		vr	= objeto.value;
		vr	= vr.replace( "/", "" );
		vr	= vr.replace( "/", "" );
		vr	= vr.replace( ",", "" );
		vr	= vr.replace( ".", "" );
		vr	= vr.replace( ".", "" );
		vr	= vr.replace( ".", "" );
		vr	= vr.replace( ".", "" );
		tam	= vr.length;
		
		if (tam < tammax && tecla != 8)
			tam = vr.length + 1 ;

		if ((tecla == 8) && (tam > 1)){
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
		if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ) {
			if (decimais > 0) {
				if ( (tam <= decimais) )
					objeto.value = ("0," + vr) ;
					
				if( (tam == (decimais + 1)) && (tecla == 8))
					objeto.value = vr.substr( 0, (tam - decimais)) + ',' + vr.substr( tam - (decimais), tam ) ;	
					
				if ( (tam > (decimais + 1)) && (tam <= (decimais + 3)) &&  ((vr.substr(0,1)) == "0"))
					objeto.value = vr.substr( 1, (tam - (decimais+1))) + ',' + vr.substr( tam - (decimais), tam ) ;
					
				if ( (tam > (decimais + 1)) && (tam <= (decimais + 3)) &&  ((vr.substr(0,1)) != "0"))
				    objeto.value = vr.substr( 0, tam - decimais ) + ',' + vr.substr( tam - decimais, tam ) ; 
					
				if ( (tam >= (decimais + 4)) && (tam <= (decimais + 6)) )
			 		objeto.value = vr.substr( 0, tam - (decimais + 3) ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

			 	if ( (tam >= (decimais + 7)) && (tam <= (decimais + 9)) )
			 		objeto.value = vr.substr( 0, tam - (decimais + 6) ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

				if ( (tam >= (decimais + 10)) && (tam <= (decimais + 12)) )
			 		objeto.value = vr.substr( 0, tam - (decimais + 9) ) + '.' + vr.substr( tam - (decimais + 9), 3 ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

				if ( (tam >= (decimais + 13)) && (tam <= (decimais + 15)) )
			 		objeto.value = vr.substr( 0, tam - (decimais + 12) ) + '.' + vr.substr( tam - (decimais + 12), 3 ) + '.' + vr.substr( tam - (decimais + 9), 3 ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

			}
			else if(decimais == 0) {
				if ( tam <= 3 )
			 		objeto.value = vr ;
					
				if ( (tam >= 4) && (tam <= 6) ) {
					if(tecla == 8) {
						objeto.value = vr.substr(0, tam);
						window.event.cancelBubble = true;
						window.event.returnValue = false;
						}
					objeto.value = vr.substr(0, tam - 3) + '.' + vr.substr( tam - 3, 3 ); 
					}
					
				if ( (tam >= 7) && (tam <= 9) ) {
					if(tecla == 8) {
						objeto.value = vr.substr(0, tam);
						window.event.cancelBubble = true;
						window.event.returnValue = false;
						}
					objeto.value = vr.substr( 0, tam - 6 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ); 
					}

				if ( (tam >= 10) && (tam <= 12) ) {
			 		if(tecla == 8) {
						objeto.value = vr.substr(0, tam);
						window.event.cancelBubble = true;
						window.event.returnValue = false;
						}
					objeto.value = vr.substr( 0, tam - 9 ) + '.' + vr.substr( tam - 9, 3 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ); 
					}

				if ( (tam >= 13) && (tam <= 15) ){
					if(tecla == 8) {
						objeto.value = vr.substr(0, tam);
						window.event.cancelBubble = true;
						window.event.returnValue = false;
						}
					objeto.value = vr.substr( 0, tam - 12 ) + '.' + vr.substr( tam - 12, 3 ) + '.' + vr.substr( tam - 9, 3 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ) ;
					}			
				}
			}
		}
	else if((window.event.keyCode != 8) && (window.event.keyCode != 9) && (window.event.keyCode != 13) && (window.event.keyCode != 35) && (window.event.keyCode != 36) && (window.event.keyCode != 46)) {
			window.event.cancelBubble = true;
			window.event.returnValue = false;
			}
}

function calculaSubTotal(x){
	//alert('contunit'+contador_global_autocomplete);
		 var qtd = 0;
		 var valorunit = 0;
		 
		 var valor_itemprodutos = 0;
		 var valor_tot_pedido = 0;
		 var valor_tot_ipi = 0;
		
  	for (i = 0; i < contador_global_autocomplete; i++) {
		
		
			var valorunit = $('#valor_unitario'+i).val();
			valorunit = valorunit.toString().replace( ".", "" );
			valorunit = valorunit.toString().replace( ",", "." );
		
			valorunit=parseFloat(valorunit);

var ipivalor = $('#ipi_valor'+i).val();
			ipivalor = ipivalor.toString().replace( ".", "" );
			ipivalor = ipivalor.toString().replace( ",", "." );
		
			ipivalor=parseFloat(ipivalor);

			
			
			/*valorunit=	valorunit.replace(/\./g, "");
			valorunit=	valorunit.replace(/,/g, ".");*/
					
			
			var qtd = $('#quantidade'+i).val();
			//alert(qtd);
			var calc_ipi = valorunit * qtd * (ipivalor/100) ;
			//var total = ((valorunit * qtd) - desconto) *  valoripi / 100;
			var total1 = (valorunit * qtd) + calc_ipi;
			var total2 = (valorunit * qtd);
			
			
			total1=parseFloat(total1);	
			total2=parseFloat(total2);	
				
			
			
			valor_itemprodutos = valor_itemprodutos + total2;
			valor_tot_ipi = valor_tot_ipi + calc_ipi;
			
			 
		
			
			
			$('#valor_produtos'+i).val(retorna_formatado(total1));
			
			
			 
			   
			
			
	}	
	
	var desconto = $('#desconto').val();
			desconto = desconto.toString().replace( ".", "" );
			desconto = desconto.toString().replace( ",", "." );
		
			desconto=parseFloat(desconto);
	
  /*var ipi = $('#ipi').val();
			ipi = ipi.toString().replace( ".", "" );
			ipi = ipi.toString().replace( ",", "." );
		
			ipi=parseFloat(ipi);*/
			
	 var icms = $('#icms').val();
			icms = icms.toString().replace( ".", "" );
			icms = icms.toString().replace( ",", "." );
		
			icms=parseFloat(icms);		
			
	var outros = $('#outros').val();
			outros = outros.toString().replace( ".", "" );
			outros = outros.toString().replace( ",", "." );
		
			outros=parseFloat(outros);			
			
			
			var frete = $('#frete').val();
			frete = frete.toString().replace( ".", "" );
			frete = frete.toString().replace( ",", "." );
		
			frete=parseFloat(frete);	
	/*		
	var compra = valor_itemprodutos - desconto;*/
	var tot = valor_itemprodutos - desconto + valor_tot_ipi + outros + frete;
	//alert($('#desconto').val());
		$('#valor_produtos_').val(retorna_formatado(valor_itemprodutos));
		$('#valor_total_').val(retorna_formatado(tot));
		
		$('#desconto_').val(retorna_formatado(desconto));
		$('#ipi_').val(retorna_formatado(valor_tot_ipi));
		$('#icms_').val(retorna_formatado(icms));
		$('#outros_').val(retorna_formatado(outros));
		$('#frete_').val(retorna_formatado(frete));
	 
		
	
	
	
	
	
			
	
}
function retorna_formatado(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }

   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));

   ret = num + ',' + cents;

   if (x == 1) ret = ' - ' + ret;return ret;

}
</script>
