<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<!--<script src="<?php echo base_url();?>js/jquery.mask.min.js"></script>-->
<!--<script src="<?php echo base_url();?>js/maskmoney.js"></script>-->
<!--<script type="text/javascript" src="<?php echo base_url()?>js/jquery-1.10.2.min.js"></script>-->


<!--<body onload="calculaSubTotal();">-->
<body onLoad="calculaSubTotal();" >
 <!--<form action="<?php echo base_url() ?>index.php/orcamentos/adicionarorcamento" id="formOrcamento" method="post"  >-->
 <form action="<?php echo current_url(); ?>" id="formOrcamento" method="post"  >
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Editar de Orçamento</h5>
            </div>
            <div class="widget-content nopadding">
                

                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes do orçamento: <b><?php echo $result->idOrcamentos; ?></b></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                 <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                              
               

                                    <div class="span12" style="padding: 1%">
                                        <div class="span3"  class="control-group">
                                            <label for="idEmitente" class="control-label"><span class="required">*</span>Emitente:</label>
                        
                        <select class="form-control" name="idEmitente">
                        
                        <?php foreach ($dados_emitente as $e) { ?>
                        
                        <option value="<?php echo $e->id; ?>" <?php if($e->id == $result->idEmitente){ echo "selected='selected'";}?>><?php echo $e->nome; ?></option>
                        <?php } ?>
                        
                        </select>
                                        </div>
                                        <div class="span6" class="control-group">
                                           
                             <label for="cliente"><span class="required">*</span>Cliente</label>
                               <input id="cliente" class="span12" class="controls" type="text" name="cliente" value="<?php echo $result->nomeCliente; ?> | ID:<?php echo $result->idClientes; ?>" size='50' />
							 <input id="clientes_id"  type="hidden" name="clientes_id" value="<?php echo $result->idClientes; ?>"  />
                                        </div>
										<div class="span3" class="control-group">
										
							 <label for="idSolicitante" class="control-label"><span class="required">*</span>Solicitante:</label>
                          
                            <select class="recebe-solici" class="controls" name="idSolicitante" id="idSolicitante">
							<?php foreach ($dados_solicitante as $so) { ?>
                        
                        <option value="<?php echo $so->idSolicitante; ?>" <?php if($so->idSolicitante == $result->idSolicitante){ echo "selected='selected'";}?>><?php echo $so->nome; ?></option>
                        <?php } ?>
                       
					   
							
                           
                            </select>
										</div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3" class="control-group">
                                            <label for="idstatusOrcamento" class="control-label"><span class="required">*</span>Status Orçamento:</label>
                       
                        <select class="form-control" name="idstatusOrcamento">
                      
                        <?php foreach ($dados_statusorcamento as $o) { ?>
                        
                        <option value="<?php echo $o->idstatusOrcamento; ?>" <?php if($o->idstatusOrcamento == $result->idstatusOrcamento){ echo "selected='selected'";}?>><?php echo $o->nome_status_orc; ?></option>
                        <?php } ?>
                       
                        </select>
                                        </div>
                                        <div class="span3" class="control-group">
                                           
										   <label for="idVendedor" class="control-label"><span class="required">*</span>Vendedor:</label>
                        
                        <select class="form-control" name="idVendedor">
                        
                        <?php foreach ($dados_vendedor as $v) { ?>
                        
                        <option value="<?php echo $v->idVendedor; ?>" <?php if($v->idVendedor == $result->idVendedor){ echo "selected='selected'";}?>><?php echo $v->nomeVendedor; ?></option>
                        <?php } ?>
                       
                        </select> 
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGerente" class="control-label"><span class="required">*</span>Gerente:</label>
                        
                        <select class="form-control" name="idGerente">
                        
                        <?php foreach ($dados_gerente as $g) { ?>
                        
                        <option value="<?php echo $g->idGerente; ?>" <?php if($g->idGerente == $result->idGerente){ echo "selected='selected'";}?>><?php echo $g->nome; ?></option>
                        <?php } ?>
                        
                        </select>
										   
                                        </div>

                                        <div class="span3" class="control-group">
                                         <label for="idGrupoServico" class="control-label"><span class="required">*</span>Grupo Serviço:</label>
                       
                        <select class="form-control" name="idGrupoServico">
                        
                        <?php foreach ($dados_gruposervico as $gs) { ?>
                        
                        <option value="<?php echo $gs->idGrupoServico; ?>" <?php if($gs->idGrupoServico == $result->idGrupoServico){ echo "selected='selected'";}?>><?php echo $gs->nome; ?></option>
                        <?php } ?>
                       
                        </select>   
                                        </div>
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">

                                        <div class="span3" class="control-group">
										 <label for="idNatOperacao" class="control-label"><span class="required">*</span>Nat. Operação:</label>
                       
                        <select class="form-control" name="idNatOperacao">
                       
                        <?php foreach ($dados_natoperacao as $nt) { ?>
                        
                        <option value="<?php echo $nt->idNatOperacao; ?>" <?php if($nt->idNatOperacao == $result->idNatOperacao){ echo "selected='selected'";}?>><?php echo $nt->nome; ?></option>
                        <?php } ?>
                       
                        </select>
						                  </div>
                                        <div class="span3" class="control-group">
                                           
                        <label for="referencia" class="control-label">Referência:</label>
                      
                            <input id="referencia" class="span12" type="text" name="referencia" value="<?php echo $result->referencia; ?>"  />
                                        </div>
										
										 <div class="span6" class="control-group">
                                            <label for="cond_pgto" class="control-label">Condição Pagamento:</label>
                       
                            <input class="span12" id="cond_pgto" type="text" name="cond_pgto" value="<?php echo $result->cond_pgto; ?>" size="50" />
                                        </div>

                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3" class="control-group">
                                            <label for="num_pedido" class="control-label">Num. Pedido:</label>
                       
                            <input id="num_pedido" class="span12" type="text" name="num_pedido" value="<?php echo $result->num_pedido; ?>"  />
                                        </div>
                                        <div class="span5" class="control-group">
                                             <label for="entrega" class="control-label">Entrega:</label>
                       
                        <input type="radio" name="entrega" <?php if($result->entrega == 'FOB'){ echo "checked='yes'";}?>  VALUE="FOB"/>FOB
                        <input type="radio" name="entrega" <?php if($result->entrega == 'CIF'){ echo "checked='yes'";}?>  VALUE="CIF"/>CIF
                        <input type="radio" name="entrega"  VALUE="OUTRO" <?php if($result->entrega == 'OUTRO'){ echo "checked='yes'";}?>/>Outro <input class="span8" id="entregaoutros" type="text" name="entregaoutros" value="<?php echo $result->entregaoutros; ?>"  size="50"/>
                                        </div>
										 <div class="span4" class="control-group">
                                             <label for="num_nf" class="control-label">Num. Nota Fiscal:</label>
                       
                            <input id="num_nf" type="text" name="num_nf" class="span12" value="<?php echo $result->num_nf; ?>"  />
                            <input id="idOrcamentos" type="hidden" name="idOrcamentos"  value="<?php echo $result->idOrcamentos; ?>"  />
                                        </div>
                                    </div>
									  <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span12" class="control-group">
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
       <h5>Cadastro de Itens </h5> <a href="#" onclick="duplicarCampos();" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Itens</a>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <!--<thead>
        <tr>
		
        
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>PN</th>
                        <th>QTD</th>
                        <th>Vlr. Unit.</th>
                        <th>Desconto</th>
                        <th>IPI%</th>
                        <th>Prazo</th>
                        <th>Sub Total</th>
                        
                        <th></th>
        </tr>
    </thead>-->
    <tbody>
	
	<br>  
	
	<div id="origem" class="span12" style="padding: 1%; margin-left: 0">
	
	</div>
	
	 <?php 
	 $contador_local_autocomplete = 0;
	 foreach ($dados_item as $orc_item) { ?>
	<div id="origem" class="span12" style="padding: 1%; margin-left: 0">
	<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>
	<input type="text" id="id_orc_item_<?php echo $contador_local_autocomplete;?>" name="id_orc_item[]"   value="<?php echo $orc_item->idOrcamento_item;?>"/>
	<input type="hidden" id="idProdutos_<?php echo $contador_local_autocomplete;?>" name="idProdutos[]" size="3"   value="<?php echo $orc_item->idProdutos;?>"/>
	Cod. | Descrição | <b>PN</b>:&nbsp;<input type="text" id="pn_<?php echo $contador_local_autocomplete;?>" name="pn[]" size="97" ref="autocomplete"  value="Cod.: <?php echo $orc_item->idProdutos;?> | Descrição: <?php echo $orc_item->descricao;?> | PN: <?php echo $orc_item->pn;?>" />
	<br>
	QTD:&nbsp;<input type="text" id="qtd_<?php echo $contador_local_autocomplete;?>" name="qtd[]"  size="1"  value="<?php echo $orc_item->qtd;?>" onKeyUp="calculaSubTotal(<?php echo $contador_local_autocomplete; ?>);"/>&nbsp;&nbsp;&nbsp;
	Vl.Unit.:&nbsp;<input type="text" id="val_unit_<?php echo $contador_local_autocomplete;?>" name="val_unit[]" size="8"  value="<?php echo number_format($orc_item->val_unit, 2, ",", ".");?>" onKeyUp="calculaSubTotal(<?php echo $contador_local_autocomplete; ?>);"  onKeyPress="FormataValor2(this,event,10,2);"/>&nbsp;&nbsp;&nbsp;
	Sub.Tot.:&nbsp;<input type="text" id="subtot_<?php echo $contador_local_autocomplete;?>" name="subtot[]" size="8"  value="<?php echo number_format($orc_item->subtot, 2, ",", ".") ?>" readonly="true"/>&nbsp;&nbsp;&nbsp;
	Prazo:&nbsp;<input type="text" id="prazo_<?php echo $contador_local_autocomplete;?>" name="prazo[]" size="1"  value="<?php echo $orc_item->prazo;?>"/>&nbsp;&nbsp;&nbsp;
	Desconto.:&nbsp;<input type="text" id="desconto_<?php echo $contador_local_autocomplete;?>" name="desconto[]" size="8"  value="<?php echo number_format($orc_item->desconto, 2, ",", ".");?>" onKeyUp="calculaSubTotal(<?php echo $contador_local_autocomplete; ?>);"  onKeyPress="FormataValor2(this,event,10,2);" />&nbsp;&nbsp;&nbsp;
	IPI%:&nbsp;<input type="text" id="val_ipi_<?php echo $contador_local_autocomplete;?>" name="val_ipi[]" size="1"  value="<?php echo number_format($orc_item->val_ipi, 2, ",", ".");?>"  onKeyUp="calculaSubTotal(<?php echo $contador_local_autocomplete; ?>);" />&nbsp;&nbsp;&nbsp;
	Valor Tot.:&nbsp;<input type="text" id="vlr_total_<?php echo $contador_local_autocomplete;?>" name="vlr_total[]" size="8"  value="<?php echo $orc_item->valor_total;?>"  readonly="true"/>&nbsp;&nbsp;&nbsp;
	<br>
	Detalhamento: <textarea id="detalhe_<?php echo $contador_local_autocomplete;?>" rows="5" cols="50" class="span10" name="detalhe[]"><?php echo $orc_item->detalhe;?></textarea>		
	<a href="#modal-excluir" role="button" data-toggle="modal" produto="<?php echo $orc_item->idOrcamento_item;?>" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>
	 	
	<hr>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
		//alert(<?php echo $contador_local_autocomplete;?>);
	//var contador_local_autocomplete=contador_global_autocomplete;
	console.log('#idProdutos_'+<?php echo $contador_local_autocomplete;?>);
	$("#pn_"+<?php echo $contador_local_autocomplete;?>).autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutos_'+<?php echo $contador_local_autocomplete;?>).val(ui.item.id);

		}
	});
	
	   $(document).on('click', 'a', function(event) {
        
        var produto = $(this).attr('produto');
        $('#item_produt').val(produto);

    });
	
	});
		
	
	
	
	//contador_global_autocomplete = contador_global_autocomplete+1;
	</script>
	
		<?
		 $contador_local_autocomplete ++;
		}
		
		?>
		
       <div id="destino" class="span12" style="padding: 1%; margin-left: 0"></div>
	   

<script type="text/javascript">
	var contador_global_autocomplete = <?php echo $contador_local_autocomplete;?>;
	
	var contador_local_autocomplete=contador_global_autocomplete;
	
	//alert('contglobal'+contador_global_autocomplete);
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
	<div id="subtotal_calculo">
	
	</div>
	<!--<input name="subtotal_calculo" type="text" id="subtotal_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">-->
</td>
	
	
	</tr> 
	<tr>
	<td align='right'>
	DESCONTO R$:
	</td>
	<td align='center'>
	<div id="desconto_calculo">
	</div>
	<!--<input name="desconto_calculo" type="text" id="desconto_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">-->
	</td>
	</tr> 
<tr>
	<td align='right'>
	VALOR IPI R$:
	</td>
	<td align='center'>
	<div id="ipi_calculo">
	</div>
	<!--<input name="ipi_calculo" type="text" id="ipi_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">-->
	</td>
	</tr> 
<tr>
	<td align='right'>
	<B>TOTAL ORÇAMENTO R$:</B>
	</td>
	<td align='center'>
	<B>
	<div id="total_calculo"></div>
	<!--<input name="total_calculo" type="text" id="total_calculo" style="font-family: Arial; font-weight: bold; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
	-->
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




$(document).ready(function(){

	<?php 
	// $contador_local_autocomplete = 0;
	 //$i = 0;
	 //foreach ($dados_item as $orc_item) { 
	 
		//$valorunita = corrigiValorBancoJavasScript($orc_item->val_unit);
		//$sub = corrigiValorBancoJavasScript($orc_item->subtot);
		//echo "alert('".$sub."')" ;
					
	 ?>
	

	//var contador_local_autocomplete=contador_global_autocomplete;
	
	/*var cloneDiv = '<div id="origem" class="span12" style="padding: 1%; margin-left: 0">' +
	'<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>'+
	'<input type="text" id="id_orc_item_'+contador_local_autocomplete+'" name="id_orc_item[]"   value="'+<?php echo $orc_item->idOrcamento_item;?>+'"/>'+
	'<input type="hidden" id="idProdutos_'+contador_local_autocomplete+'" name="idProdutos[]" size="3"   value="'+<?php echo $orc_item->idProdutos;?>+'"/>'+
	'Cod. | Descrição | <b>PN</b>:&nbsp;<input type="text" id="pn_'+contador_local_autocomplete+'" name="pn[]" size="97" ref="autocomplete"  value="Cod.: <?php echo $orc_item->idProdutos;?> | Descrição: <?php echo $orc_item->descricao;?> | PN: <?php echo $orc_item->pn;?>" />'+
	'<br>'+
	'QTD:&nbsp;<input type="text" onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete;?>+')" id="qtd_'+contador_local_autocomplete+'" name="qtd[]" size="1"  value="'+<?php echo $orc_item->qtd;?>+'" onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete;?> +')"/>&nbsp;&nbsp;&nbsp;'+
	'Vl.Unit.:&nbsp;<input type="text" id="val_unit_'+contador_local_autocomplete+'" name="val_unit[]" size="8"  onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete;?> +')" value="'+<?php echo $orc_item->val_unit;?> +'" class="money"/>&nbsp;&nbsp;&nbsp;'+
	'Sub.Tot.:&nbsp;<input type="text" id="subtot_'+contador_local_autocomplete+'" name="subtot[]" size="8"  value="'+<?php echo $orc_item->subtot; ?>+'" class="money" readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'Prazo:&nbsp;<input type="text" id="prazo_'+contador_local_autocomplete+'" name="prazo[]" size="1"  value="'+<?php echo $orc_item->prazo;?>+'"/>&nbsp;&nbsp;&nbsp;'+
	'Desconto.:&nbsp;<input type="text" id="desconto_'+contador_local_autocomplete+'" name="desconto[]" size="8"  value="'+<?php echo $orc_item->desconto;?>+'" class="money"  onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete;?>+')"/>&nbsp;&nbsp;&nbsp;'+
	'IPI%:&nbsp;<input type="text" id="val_ipi_'+contador_local_autocomplete+'" name="val_ipi[]" size="1"  value="'+<?php echo $orc_item->val_ipi;?>+'"   onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete;?>+')"/>&nbsp;&nbsp;&nbsp;'+
	'Valor Tot.:&nbsp;<input type="text" id="vlr_total_'+contador_local_autocomplete+'" name="vlr_total[]" size="8"  value="'+<?php echo $orc_item->valor_total;?>+'"  readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'<br>	'+
	'Detalhamento: <textarea id="detalhe_'+contador_local_autocomplete+'" rows="5" cols="50" class="span10" name="detalhe[]"><?php echo $orc_item->detalhe;?></textarea>'+	
	'<a href="#modal-excluir" role="button" data-toggle="modal" produto="'+<?php echo $orc_item->idOrcamento_item;?>+'" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>'+
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
		
		
		
		<?
		 
		//}
		
		
		//if ( count($dados_item) == $contador_local_autocomplete) {
			?>
			//alert(<?=$contador_local_autocomplete?>)
//calculaSubTotal();
		
<?
//}

		
		?>
	
		 
	
		//calculaSubTotal();
	



      $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteCliente",
            minLength: 1,
            select: function( event, ui ) {

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

function calculaSubTotal_(x)
{
	var total_calculo = 0;
	var ipi_calculo = 0;
	var desconto_calculo = 0;
	var subtotal_calculo = 0;
	for (i = 0; i < contador_global_autocomplete; i++)
	{
		//alert($('#val_unit_'+i).val());
		if($('#val_unit_'+i).val() != undefined){
			
			 $.ajax({
				
                url: '<?php echo base_url('index.php/orcamentos/calculartotais') ?>',
                dataType: 'json',
				type:  'POST',
				data: 'valorunit='+$('#val_unit_'+i).val()+'&desconto='+$('#desconto_'+i).val()+'&valoripi='+$('#val_ipi_'+i).val()+'&qtd='+$('#qtd_'+i).val()+'',
				success: function($json)  {
				
					console.log($json);
					
					
					$('#subtot_'+i).val($json.subtot);
					$('#vlr_total_'+i).val($json.vlr_total);
					
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
	
		

function calculaSubTotal(x){
	//alert('contunit'+contador_global_autocomplete);
		 var total_calculo = 0;
		 var ipi_calculo = 0;
		 var desconto_calculo = 0;
		 var subtotal_calculo = 0;
  	for (i = 0; i < contador_global_autocomplete; i++) {
		
		//alert(contador_global_autocomplete);
			var valorunit = $('#val_unit_'+i).val();
			valorunit = valorunit.toString().replace( ".", "" );
			valorunit = valorunit.toString().replace( ",", "." );
		
			valorunit=parseFloat(valorunit);	
			
			/*valorunit=	valorunit.replace(/\./g, "");
			valorunit=	valorunit.replace(/,/g, ".");*/
			
			var desconto = $('#desconto_'+i).val();
			desconto = desconto.toString().replace( ".", "" );
			desconto = desconto.toString().replace( ",", "." );
			/*desconto=	desconto.replace(/\./g, "");
			desconto=	desconto.replace(/,/g, ".");*/
			
			desconto=parseFloat(desconto);	
			
			var valoripi = $('#val_ipi_'+i).val();
			valoripi=parseFloat(valoripi);	
			
			var qtd = $('#qtd_'+i).val();
			
			
			//var total = ((valorunit * qtd) - desconto) *  valoripi / 100;
			var total1 = (valorunit * qtd);
			var total2 = total1 * valoripi/100;
			
			total1=parseFloat(total1);	
			total2=parseFloat(total2);	
			var total3 = total1 + total2 - desconto;
			
			
			
			 subtotal_calculo = subtotal_calculo + total1;
			 ipi_calculo = ipi_calculo + total2;
			 desconto_calculo = desconto_calculo + desconto;
			 desconto_calculo=parseFloat(desconto_calculo);
			 total_calculo = total_calculo + total1 + total2 - desconto_calculo;
			
			/*total3 = parseFloat(total3.toFixed(2));
			total3=(total3).toLocaleString(); 
			
			total1 = parseFloat(total1.toFixed(2));
			total1=(total1).toLocaleString(); */
			
			
			
			$('#subtot_'+i).val(retorna_formatado(total1));
			$('#vlr_total_'+i).val(retorna_formatado(total3));
			
			 
			   
			
			
	}	
	//document.getElementByID("desconto_calculo").innerHTML += desconto_calculo
	
	/*$('#subtotal_calculo'+i).val(retorna_formatado(subtotal_calculo));
	$('#total_calculo'+i).val(retorna_formatado(total_calculo));
	$('#ipi_calculo'+i).val(retorna_formatado(ipi_calculo));
	$('#desconto_calculo'+i).val(retorna_formatado(desconto_calculo));
	*/
	
			$("#subtotal_calculo").text(subtotal_calculo).toLocaleString();
			$("#total_calculo").text(total_calculo).toLocaleString();
			$("#ipi_calculo").text(ipi_calculo).toLocaleString();
			$("#desconto_calculo").text(desconto_calculo).toLocaleString();
			
			
			
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
	
	
$(document).ready(function(){
	// $(".money").maskMoney();
	 $('.dinheiro').mask('#.##0,00', {reverse: true});
           $('#formOrcamento').validate({      
            rules :{
                  idEmitente:{ required: true},
                  cliente:{ required: true},
                  idSolicitante:{ required: true},
                  idstatusOrcamento:{ required: true},
                  idGerente:{ required: true},
                  idVendedor:{ required: true},
                  idGrupoServico:{ required: true},
                  idNatOperacao:{ required: true}
                  /*estado:{ required: true},
                  cep:{ required: true}*/
            },
            messages:{
                  idEmitente :{ required: 'Campo Requerido.'},
                  cliente :{ required: 'Campo Requerido.'},
                  idSolicitante:{ required: 'Campo Requerido.'},
                  idstatusOrcamento:{ required: 'Campo Requerido.'},
                  idGerente:{ required: 'Campo Requerido.'},
                  idVendedor:{ required: 'Campo Requerido.'},
                  idGrupoServico:{ required: 'Campo Requerido.'},
              idNatOperacao:{ required: 'Campo Requerido.'}
                  /*cep:{ required: 'Campo Requerido.'}*/

            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
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
 <!-- '<?php echo form_textarea(array("name" =>"detalheo[]","id"=>"detalheo_'+contador_local_autocomplete+'","class"=>"ckeditor")); ?>'+'<br>	'+-->
	
 /* jQuery.browser = {}; (function () { jQuery.browser.msie = false; jQuery.browser.version = 0; if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) { jQuery.browser.msie = true; jQuery.browser.version = RegExp.$1; } })(); */
 

 
function duplicarCampos(){
	//var clone = $("#origem").clone();
	//clone.find("input").val("");
	//$("#destino").append(clone);
	
	
	var contador_local_autocomplete=contador_global_autocomplete;
	//alert('duplicarlocal'+contador_local_autocomplete);
	
	var cloneDiv = '<div id="origem" class="span12" style="padding: 1%; margin-left: 0">' +
	'<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>'+
	'<input type="hidden" id="id_orc_item_'+contador_local_autocomplete+'" name="id_orc_item[]"   value="0"/>'+
	'<input type="hidden" id="idProdutos_'+contador_local_autocomplete+'" name="idProdutos[]" size="3"   value=""/>'+
	'Cod. | Descrição | <b>PN</b>:&nbsp;<input type="text" id="pn_'+contador_local_autocomplete+'" name="pn[]" size="97" ref="autocomplete"  value="" />'+
	'<br>'+
	'QTD:&nbsp;<input type="text" id="qtd_'+contador_local_autocomplete+'" name="qtd[]" size="1"  value="" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"/>&nbsp;&nbsp;&nbsp;'+
	'Vl.Unit.:&nbsp;<input type="text" id="val_unit_'+contador_local_autocomplete+'" name="val_unit[]" size="8"  value="" onKeyPress="FormataValor2(this,event,10,2);" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"/>&nbsp;&nbsp;&nbsp;'+
	'Sub.Tot.:&nbsp;<input type="text" id="subtot_'+contador_local_autocomplete+'" name="subtot[]" size="8"  value=""  readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'Prazo:&nbsp;<input type="text" id="prazo_'+contador_local_autocomplete+'" name="prazo[]" size="1"  value=""/>&nbsp;&nbsp;&nbsp;'+
	'Desconto.:&nbsp;<input type="text" id="desconto_'+contador_local_autocomplete+'" name="desconto[]" size="8"  value="" onKeyPress="FormataValor2(this,event,10,2);" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"/>&nbsp;&nbsp;&nbsp;'+
	'IPI%:&nbsp;<input type="text" id="val_ipi_'+contador_local_autocomplete+'" name="val_ipi[]" size="1"  value=""  onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"/>&nbsp;&nbsp;&nbsp;'+
	'Valor Tot.:&nbsp;<input type="text" id="vlr_total_'+contador_local_autocomplete+'" name="vlr_total[]" size="8"  value=""  readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'<br>	'+
	
	'Detalhamento: <textarea id="detalhe_'+contador_local_autocomplete+'" rows="5" cols="50" class="span10" name="detalhe[]"></textarea>'+		
	'<a href="#" onclick="removerCampos(this);" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>	'+
	 	
	'<hr>'+
	'</div>';
	
	$("#destino").append(cloneDiv);

	console.log('#idProdutos_'+contador_global_autocomplete);
	$("#pn_"+contador_global_autocomplete).autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutos_'+contador_local_autocomplete).val(ui.item.id);

		}
	});
	
	
	
	
	contador_global_autocomplete = contador_global_autocomplete+1;

	
	
		//calculaSubTotal();
		
	
	
   


	
}
	
 
	
	
function removerCampos(obj){
	 var div = $(obj).parent();
	valor = div.find("input:eq(0)").val();
	
	contador_global_autocomplete=contador_global_autocomplete-1;
	$(obj).parent().remove();
}


function soma_totalitem(x){
	var y = x;
	var tk;
	var val_unit;
	var desconto;

	for(x=0;x < contador_global_autocomplete; x++){
		
		
		if(document.getElementById('qtd_['+x+']').value==''){ document.getElementById('qtd_['+x+']').value=1; }
		qtd=document.getElementById('qtd_['+x+']').value;

		if(document.getElementById('val_unit_['+x+']').value==''){ document.getElementById('val_unit_['+x+']').value='0'; }		
		val_unit=document.getElementById('val_unit_['+x+']').value;
		
		if(document.getElementById('desconto_['+x+']').value==''){ document.getElementById('desconto_['+x+']').value='0'; }		
		desconto=document.getElementById('desconto_['+x+']').value;
			
		val_unit = val_unit.toString().replace( ".", "" );
		val_unit = val_unit.toString().replace( ",", "." );
		
		desconto = desconto.toString().replace( ".", "" );
		desconto = desconto.toString().replace( ",", "." );
		
		desconto=parseFloat(desconto);	
		
		val_unit=parseFloat(val_unit);	
		total=qtd*val_unit-desconto;
		total=total+'';
		
		//alert("vlr"+val_unit);
		
		//alert("vlr"+total);
				
		
		//total = total.toString().replace( ".", "," );	
				
		/*total = total.toString().replace( ",", "." );
		total = retorna_formatado(total);*/
		document.getElementById('vlr_total_['+x+']').value=retorna_formatado(total);
		
	}	
	soma_total();
	mostra_total2(y);
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
function soma_total(){
	var valor;
	
	var valor_desc;
	var total=0;
	var tot_desconto = 0;
	var totalex;
	var totalex2;
	var totalexex;	
	var totalexex2;
	for(x=0;x < contador_global_autocomplete ;x++){
		valor=document.getElementById('vlr_total_['+x+']').value;
		valor_desc=document.getElementById('desconto_['+x+']').value;
		
		valor = valor.replace('.','');
		valor = valor.replace(',','.');
		
		valor_desc = valor_desc.replace('.','');
		valor_desc = valor_desc.replace(',','.');
		
		if(valor==''){ valor=0; }	
		
		valor=parseFloat(valor);
		total=total+valor;
		
		if(valor_desc==''){ valor_desc=0; }	
		
		valor_desc=parseFloat(valor_desc);
		tot_desconto=tot_desconto+valor_desc;
	}
	total=total+'';
	tot_desconto=tot_desconto+'';
	
	if(total.indexOf('.')<0){ 
		total=total+".00";
		
	}
	else{
		totalex=total.split(".");
				
		if(totalex[1].length==1){
			total=totalex[0]+'.'+totalex[1]+'0';
		}
		else if(totalex[1].length>=2){
			totalexex=totalex[1].split("");
			campo0=parseInt(totalexex[0]);
			campo1=parseInt(totalexex[1]);
			campo2=parseInt(totalexex[2]);
			//if(campo2>5){ campo1++; }
			total=totalex[0]+'.'+campo0+campo1;
		}
	}
	
	if(tot_desconto.indexOf('.')<0){ 
		tot_desconto=tot_desconto+".00";
		
	}
	else{
		totalex2=tot_desconto.split(".");
				
		if(totalex2[1].length==1){
			tot_desconto=totalex2[0]+'.'+totalex2[1]+'0';
		}
		else if(totalex2[1].length>=2){
			totalexex2=totalex2[1].split("");
			campo00=parseInt(totalexex2[0]);
			campo11=parseInt(totalexex2[1]);
			campo22=parseInt(totalexex2[2]);
			//if(campo2>5){ campo1++; }
			tot_desconto=totalex2[0]+'.'+campo00+campo11;
		}
	}
	
	
	document.getElementById('total').value=total;
	document.getElementById('total_desconto').value=tot_desconto;
	
	mostra_total();
}
function mostra_total(){
	
	var total=document.getElementById('total').value;
	var imposto=document.getElementById('imposto').value;
	var total_desconto=document.getElementById('total_desconto').value;
	
	
	
	imposto1=imposto;
	if(imposto1==''){ imposto1='0'; }
	document.getElementById('mostra_imposto').value=imposto1;
	//document.getElementById('mostra_imposto2').value=imposto1;
	total_desconto1=total_desconto;
	if(total_desconto1==''){ total_desconto1='0'; }
document.getElementById('dp_mostra_desc').value=total_desconto1;

	var dp_sub_total=parseFloat(total);
	var dp_imposto=dp_sub_total*imposto/100;
	var dp_valor_total=parseFloat(dp_sub_total)+parseFloat(dp_imposto);
	var dp_total_desconto = total_desconto;
	
	//----------------
	dp_imposto=dp_imposto+'';
	if(dp_imposto.indexOf('.')<0){ 
		dp_imposto=dp_imposto+".00";
	}
	else{ 
		dp_impostoex=dp_imposto.split(".");
		if(dp_impostoex[1].length==1){
			dp_imposto=dp_imposto+"0";
		}
		else if(dp_impostoex[1].length>=2){
			dp_impostoexex=dp_impostoex[1].split("");
			campo0=parseInt(dp_impostoexex[0]);
			campo1=parseInt(dp_impostoexex[1]);
			campo2=parseInt(dp_impostoexex[2]);
			//if(campo2>5){ campo1++; }
			dp_imposto=dp_impostoex[0]+'.'+campo0+campo1;
		}
	}
	//------------------

	//----------------
	dp_valor_total=dp_valor_total+'';
	if(dp_valor_total.indexOf('.')<0){ 
		dp_valor_total=dp_valor_total+".00";
		
	}
	else{ 
		dp_valor_totalex=dp_valor_total.split(".");
		
		if(dp_valor_totalex[1].length==1){
			dp_valor_total=dp_valor_total+"0";
		}
		else if(dp_valor_totalex[1].length>=2){
			dp_valor_totalexex=dp_valor_totalex[1].split("");
			campo0_=parseInt(dp_valor_totalexex[0]);
			campo1_=parseInt(dp_valor_totalexex[1]);
			campo2_=parseInt(dp_valor_totalexex[2]);
			//if(campo2_>5){ campo1_++; }
			dp_valor_total=dp_valor_totalex[0]+'.'+campo0_+campo1_;
		}
	}
	
	//------------------
	
	
	
	
	
	
	document.getElementById('dp_sub_total').value=retorna_formatado(total);
	document.getElementById('dp_imposto').value=retorna_formatado(dp_imposto);
	document.getElementById('dp_valor_total').value=retorna_formatado(dp_valor_total);
	document.getElementById('dp_mostra_desc').value=retorna_formatado(dp_total_desconto);
}
function mostra_total2(x){
	if(document.getElementById('vlr_total['+x+']').value==''){ document.getElementById('vlr_total['+x+']').value='0'; }		
		
		
	var total=document.getElementById('vlr_total['+x+']').value
	
	var imposto=document.getElementById('imposto').value;
		
	var dp_sub_total=total;
	dp_sub_total = dp_sub_total.toString().replace( ".", "" );
	dp_sub_total = dp_sub_total.toString().replace( ",", "." );
	dp_sub_total = parseFloat(dp_sub_total)
	var dp_imposto=dp_sub_total*imposto/100;
	var dp_valor_total=parseFloat(dp_sub_total)+parseFloat(dp_imposto);

	//----------------
	dp_imposto=dp_imposto+'';
	if(dp_imposto.indexOf('.')<0)
	{ 
		dp_imposto=dp_imposto+".00";
	}
	else
	{ 
		dp_impostoex=dp_imposto.split(".");
		if(dp_impostoex[1].length==1)
		{
			dp_imposto=dp_imposto+"0";
		}
		else if(dp_impostoex[1].length>=2)
		{
			dp_impostoexex=dp_impostoex[1].split("");
			campo0=parseInt(dp_impostoexex[0]);
			campo1=parseInt(dp_impostoexex[1]);
			campo2=parseInt(dp_impostoexex[2]);
			//if(campo2>5){ campo1++; }
			dp_imposto=dp_impostoex[0]+'.'+campo0+campo1;
		}
	}
	//------------------

	//----------------
	dp_valor_total=dp_valor_total+'';
	if(dp_valor_total.indexOf('.')<0)
	{ 
		dp_valor_total=dp_valor_total+".00";
	}
	else
	{ 
		dp_valor_totalex=dp_valor_total.split(".");
		if(dp_valor_totalex[1].length==1)
		{
			dp_valor_total=dp_valor_total+"0";
		}
		else if(dp_valor_totalex[1].length>=2)
		{
			dp_valor_totalexex=dp_valor_totalex[1].split("");
			campo0_=parseInt(dp_valor_totalexex[0]);
			campo1_=parseInt(dp_valor_totalexex[1]);
			campo2_=parseInt(dp_valor_totalexex[2]);
			//if(campo2_>5){ campo1_++; }
			dp_valor_total=dp_valor_totalex[0]+'.'+campo0_+campo1_;
		}
	}
	//------------------
	
document.getElementById('dp_valor_total2['+x+']').value=retorna_formatado(dp_valor_total);
}


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





</script>   

<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/orcamentos/excluir_item" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Item</h5>
  </div>
  <div class="modal-body">
     <input type="text" id="item_produt" name="id" value="" />
    <input type="text" id="orc_item" name="orc_item" value="<?php echo $result->idOrcamentos; ?>" />
    <h5 style="text-align: center">Deseja realmente excluir este item?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>


		
         
<!--https://pt.stackoverflow.com/questions/9548/como-clonar-um-elemento-com-jquery-e-adicionar-um-novo-name-->