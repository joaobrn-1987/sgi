
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
                <h5>Pedido de Compra - Número: <?php echo $this->uri->segment(3); ?> | Data abertura: <?php echo date("d/m/Y H:i:s", strtotime($results[0]->data_cadastro));?></h5><div>
			<h5><?
			if($results[0]->idEmitente <> ''&& $results[0]->idFornecedores <> '')
			{
			if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
				echo '<a href="'.base_url().'index.php/pedidocompra/imprimir_pedido/'.$this->uri->segment(3).'" style="margin-right: 1%" class="class="btn btn-mini btn-info" title="Imprimir pedido" target="_blank"><button class="btn btn-mini btn-info" title="Imprimir PDF"><i class="icon-print icon-white"> Imprimir</i></button></a>'; 
				
			} 
			}			
			?></h5>
			</div>
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
											
											<?php if(isset($results[0]->idEmitente))
											{
												?>
<input id="emitente" onclick="this.select();" class="span12" class="controls" type="text" name="emitente" value="<?php echo $results[0]->nome; ?>" size='50' />
<input id="emitente_id"  type="hidden" name="emitente_id" value="<?php echo $results[0]->idEmitente; ?>"  />
							 
							 <?
											}
											else
											{
												?>
												
											<input id="emitente" class="span12" class="controls" type="text" name="emitente" value="" size='50' />
<input id="emitente_id"  type="hidden" name="emitente_id" value=""  />	
												<?
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
							 					   
					    <?
											}
											else
											{
												?>
												
												<input id="fornecedor" class="span12" class="controls" type="text" name="fornecedor" value="" size='50' />
<input id="fornecedor_id"  type="hidden" name="fornecedor_id" value=""  />

<?
											}
											?>
					   
					 
                                        </div>
                                        </div>
										
										 
                                      

                                   
									<div  style="padding: 1%; margin-left: 0">
                                        
                                        <div class="span2" class="control-group">
                                            <label for="previsao_entrega" class="control-label">Previsão de Entrega:</label><br>
											<?
											if(isset($results[0]->previsao_entrega))
											{
												$previsao_entrega =  date("d/m/Y", strtotime($results[0]->previsao_entrega));
											}
											else
											{
												$previsao_entrega = '';
											}
											?>
											
<input id="idPedidoCompra"  type="hidden" name="idPedidoCompra" value="<?php echo $results[0]->idPedidoCompra; ?>"  />
											<input id="previsao_entrega" class="span12 data" type="text" name="previsao_entrega" value="<?php echo $previsao_entrega;  ?>" onclick="this.select();"/>
											
                      
                       
                                        </div>
										<div class="span2" class="control-group">
										<label for="prazo_entrega" class="control-label">Prazo entrega:</label>
										<br>
										<input class="span8 form-control" onclick="this.select();" type="text" name="prazo_entrega" value="<?php echo $results[0]->prazo_entrega;  ?>"  >dias
										
										 </div>
										<div class="span4" class="control-group">
                                            <label for="idFornecedores" class="control-label">Pagamento:</label><br>
                        <select class="span12 recebe-solici" class=" controls" name="idCondPgto" id="idCondPgto">
							 <option value="" selected='selected'></option>
							<?php foreach ($dados_statuscondicao as $cond) { 
							if(isset($results[0]->idCondPgto))
							{
							
							?>
                       
 <option value="<?php echo $cond->id_status_cond_pgt; ?>" <?php if($cond->id_status_cond_pgt == $results[0]->idCondPgto){ echo "selected='selected'";}?>><?php echo $cond->nome_status_cond_pgt; ?></option>
					  
                        <?php 
							}
							else{
								?>
								
								<option value="<?php echo $cond->id_status_cond_pgt; ?>"><?php echo $cond->nome_status_cond_pgt; ?></option>
								
								<?
							}
						
						} ?>
                       
					    
                            </select>
                       
                                        </div>
										
										 <div class="span4" class="control-group">
                                            <label for="cod_pgto" class="control-label">Condição de pagamento:
											</label><br>
										<?
if(isset($results[0]->cod_pgto))
							{
								$cod_pgto = $results[0]->cod_pgto;
							}
							else
							{
								$cod_pgto = '';
							}
							
							?>										
											
       <input class="span12 form-control" onclick="this.select();" type="text" name="cod_pgto" value="<?php echo $cod_pgto; ?>"  >
                       
                                        </div> 
                                      

                                        
                                    </div>
									
									
 <div  style="padding: 1%; margin-left: 0">
                                        
                                 <?
if(isset($results[0]->ipi))
							{
								$ipi = number_format($results[0]->ipi, 2, ",", ".") ;
							}
							else
							{
								$ipi = '0,00';
							}
	
if(isset($results[0]->icms))
							{
								$icms = number_format($results[0]->icms, 2, ",", ".") ;
							}
							else
							{
								$icms = '0,00';
							}
if(isset($results[0]->frete))
							{
								$frete = number_format($results[0]->frete, 2, ",", ".") ;
							}
							else
							{
								$frete = '0,00';
							}
if(isset($results[0]->desconto))
							{
								$desconto = number_format($results[0]->desconto, 2, ",", ".") ;
							}
							else
							{
								$desconto = '0,00';
							}
if(isset($results[0]->outros))
							{
								$outros = number_format($results[0]->outros, 2, ",", ".") ;
							}
							else
							{
								$outros = '0,00';
							}
if(isset($results[0]->obs))
							{
								$obs = $results[0]->obs;
							}
							else
							{
								$obs = '0,00';
							}							
							
							
							?>			      
										<div class="span2" class="control-group">
                                            <label for="ipi" class="control-label">IPI:</label>
                      <input class="span12 form-control" onclick="this.select();" onKeyPress="FormataValor2(this,event,10,2);" type="text" name="ipi"  id="ipi" value="<?php echo $ipi; ?>" onKeyUp="calculaSubTotal();" >
                       
                                        </div>
										
										 <div class="span2" class="control-group">
                                            <label for="icms" class="control-label">ICMS:</label>
                      <input class="span12 form-control" onclick="this.select();" onKeyPress="FormataValor2(this,event,10,2);"  type="text" name="icms" id="icms" value="<?php echo $icms; ?>"  onKeyUp="calculaSubTotal();">
                       
                                        </div>
										<div class="span2" class="control-group">
                                            <label for="frete" class="control-label">Frete:</label>
                      <input class="span12 form-control" onclick="this.select();" onKeyPress="FormataValor2(this,event,10,2);" type="text" name="frete" id="frete" value="<?php echo $frete; ?>" onKeyUp="calculaSubTotal();" >
                       
                                        </div>
										<div class="span2" class="control-group">
                                            <label for="desconto" class="control-label">Desconto:</label>
                      <input class="span12 form-control" onclick="this.select();" onKeyPress="FormataValor2(this,event,10,2);" type="text" name="desconto" id="desconto" value="<?php echo $desconto; ?>" onKeyUp="calculaSubTotal();" >
                       
                                        </div>
                                      
<div class="span4" class="control-group">
                                            <label for="outros" class="control-label">Outros:</label>
                     
                        <input class="span12 form-control" onclick="this.select();" onKeyPress="FormataValor2(this,event,10,2);" type="text" name="outros" id="outros" onKeyUp="calculaSubTotal();" value="<?php echo $outros; ?>"  >
                                        </div>
                                        
                                    </div>
							
 <div  style="padding: 1%; margin-left: 0">
                                        
                                       <?
									   
if(isset($results[0]->obscompras))
							{
								$obs = $results[0]->obscompras;
							}
							else
							{
								$obs = '';
							}
							
							?>			
										<div class="span12" class="control-group">
                                            <label for="obs" class="control-label">OBS:</label>
                      <textarea id="obs" rows="5" cols="100" class="span12" name="obs"><?php echo $obs; ?></textarea>
                       
                                        </div>
										
										
										
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


 
 
 
 
 
 
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Itens Pedido de compra</h5>

     </div>

<div class="widget-content nopadding">

 <form class="form-inline" action="<?php echo base_url() ?>index.php/pedidocompra/salvaritemcompra" method="post">
<table class="table table-bordered ">
    <thead>
        <tr>
        
                        
                        <th>Nº OS</th>
                        <th>Qtd./Editar</th>
                       <th>Descrição</th>
                        <th>Dimensões</th>
                        <th>OBS</th>
                        
                        <th>Status</th>
                        <th>QTD recebida</th>
                        <th>Valor Unit.</th>
                        <th>Valor total</th>
                        
        </tr>
    </thead>
    <tbody>
        <?php 
		$contador = 0;
		foreach ($results as $r) {
			$color = '';
			
			
			?>
			
           <tr>
	
  <input id="idPedidoCompraItens"  type="hidden" name="idPedidoCompraItens[]" value="<?php echo $r->idPedidoCompraItens;?>"  />
  <input id="idCotacaoItens"  type="hidden" name="idCotacaoItens[]" value="<?php echo $r->idCotacaoItens;?>"  />
  <input type="hidden" id="item<?php echo $contador;?>" name="item[]"  value="" size="1"/>
           <td><?php echo $r->idOs;?></td>
           <td><input id="quantidade<?php echo $contador;?>"  type="hidden" name="quantidade[]" value="<?php echo $r->quantidade;?>"  /><?php echo $r->quantidade;?> -
<?
if($r->liberado_edit_compras == 0 )
{
	?>
	 <a href="#modal-editar_1" style="margin-right: 1%" role="button" data-toggle="modal" id_disti1="<?php echo $r->idDistribuir; ?>"  title="Destravar para editar"><font color='red'><i class="icon-remove icon-white"></i></font></a>
	
	<?
}
else
{
	?>
	 <a href="#modal-editar_0" style="margin-right: 1%" role="button" data-toggle="modal" id_disti2="<?php echo $r->idDistribuir;?>" title="Travar edição"><font color='blue'><i class="icon-pencil icon-white"></i></font></a>
	 <?
}

?>		   
		  
		   
		  
		   </td>
           <td><?php echo $r->descricaoInsumo;?></td>
           <td><?php echo $r->dimensoes;?></td>
           <td><?php echo $r->obs;?></td>
            
            <td>
			 <select class="recebe-solici" class="controls" name="idStatuscompras[]" id="idStatuscompras">
							 
							<?php foreach ($dados_statuscompra as $so) { ?>
                       
                        <option value="<?php echo $so->idStatuscompras; ?>" <?php if($so->idStatuscompras == $r->idStatuscompras){ echo "selected='selected'";}?>><?php echo $so->nomeStatus; ?></option>
                        <?php } ?>
                       
					    
                            </select>
			
			
			
			
			
			</td>
           <td><input class="span12 form-control" onclick="this.select();" type="text" name="qtdrecebida[]" value="<?php echo $r->qtdrecebida; ?>" ></td>
           
           <td><input class="span12 form-control" onclick="this.select();" onKeyPress="FormataValor2(this,event,10,2);" type="text" id="valor_unitario<?php echo $contador;?>"  name="valor_unitario[]" value="<?php echo number_format($r->valor_unitario, 2, ",", "."); ?>"  onKeyUp="calculaSubTotal(<?php echo $contador; ?>);"> </td>
           
           <td> <?
 
 

?>	
<input type="text" id="valor_produtos<?php echo $contador;?>" name="valor_produtos[]" size="8"  value="<?php echo number_format($r->valor_total, 2, ",", "."); ?>" readonly="true"/>

	   </td>
         <?
			
			 
            echo '</tr>';
			
			?>
	
	
		
			
			<?
			$contador ++;
        }
		
		?>
        <tr>
          <input id="idPedidoCompra"  type="hidden" name="idPedidoCompra" value="<?php echo $results[0]->idPedidoCompra; ?>"  />
        </tr>
    </tbody>
</table>
 <div class="span12" style="padding: 1%; margin-left: 0">
                                       
										 <div class="form-actions" align='center'>
                        
           <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Salvar</button>
                               
                           
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
TOTAL ORDEM COMPRA R$: <input name="valor_total_" type="text" id="valor_total_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
</div>
<?php echo $this->pagination->create_links();}?>



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
		
  	for (i = 0; i < contador_global_autocomplete; i++) {
		
		
			var valorunit = $('#valor_unitario'+i).val();
			valorunit = valorunit.toString().replace( ".", "" );
			valorunit = valorunit.toString().replace( ",", "." );
		
			valorunit=parseFloat(valorunit);	
			
			/*valorunit=	valorunit.replace(/\./g, "");
			valorunit=	valorunit.replace(/,/g, ".");*/
					
			
			var qtd = $('#quantidade'+i).val();
			//alert(qtd);
			
			//var total = ((valorunit * qtd) - desconto) *  valoripi / 100;
			var total1 = (valorunit * qtd);
			
			
			total1=parseFloat(total1);	
				
			
			
			valor_itemprodutos = valor_itemprodutos + total1;
			
			 
			
			
			
			$('#valor_produtos'+i).val(retorna_formatado(total1));
			
			
			 
			   
			
			
	}	
	
	var desconto = $('#desconto').val();
			desconto = desconto.toString().replace( ".", "" );
			desconto = desconto.toString().replace( ",", "." );
		
			desconto=parseFloat(desconto);
	
  var ipi = $('#ipi').val();
			ipi = ipi.toString().replace( ".", "" );
			ipi = ipi.toString().replace( ",", "." );
		
			ipi=parseFloat(ipi);
			
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
	var tot = valor_itemprodutos - desconto + ipi + icms + outros + frete;
	//alert($('#desconto').val());
		$('#valor_produtos_').val(retorna_formatado(valor_itemprodutos));
		$('#valor_total_').val(retorna_formatado(tot));
		
		$('#desconto_').val(retorna_formatado(desconto));
		$('#ipi_').val(retorna_formatado(ipi));
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
