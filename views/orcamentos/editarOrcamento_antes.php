<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<!--<script src="<?php echo base_url();?>js/jquery.mask.min.js"></script>-->
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url()?>js/jquery-1.10.2.min.js"></script>-->

<script type="text/javascript">
	var contador_global_autocomplete = 0;
</script>

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
	<!--<div id="origem" class="span12" style="padding: 1%; margin-left: 0">
	<input type="hidden" id="idOrcamento_item[]" name="idOrcamento_item[]"  value="<?php echo $orc_item->idOrcamento_item; ?>" size='1'/>
	<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>
	<input type="hidden" id="idProdutos_<?php echo $contador_local_autocomplete;?>" name="idProdutos[]" size="3"   value="<?php echo $orc_item->idProdutos; ?>"/>
	Cod. | Descrição | <b>PN</b>:&nbsp;<input type="text" id="pn_<?php echo $contador_local_autocomplete;?>" name="pn[]" size="97" ref="autocomplete"  value="<?php echo $orc_item->pn; ?>" />
	<br>
	QTD:&nbsp;<input type="text" id="qtd_<?php echo $contador_local_autocomplete;?>" name="qtd[]" size="1"  value="<?php echo $orc_item->qtd; ?>" class="calcula"/>&nbsp;&nbsp;&nbsp;
	Vl.Unit.:&nbsp;<input type="text" id="val_unit_<?php echo $contador_local_autocomplete;?>" name="val_unit[]" size="8"  value="<?php echo $orc_item->val_unit; ?>" class="dinheiro calcula"/>&nbsp;&nbsp;&nbsp;
	Sub.Tot.:&nbsp;<input type="text" id="subtot_<?php echo $contador_local_autocomplete;?>" name="subtot[]" size="8"  value="<?php echo $orc_item->subtot; ?>" class="dinheiro" readonly="true"/>&nbsp;&nbsp;&nbsp;
	Prazo:&nbsp;<input type="text" id="prazo_<?php echo $contador_local_autocomplete;?>" name="prazo[]" size="1"  value="<?php echo $orc_item->prazo; ?>"/>&nbsp;&nbsp;&nbsp;
	Desconto.:&nbsp;<input type="text" id="desconto_'+contador_local_autocomplete+'" name="desconto[]" size="8"  value="<?php echo $orc_item->desconto; ?>" class="dinheiro calcula"/>&nbsp;&nbsp;&nbsp;
	IPI%:&nbsp;<input type="text" id="val_ipi_<?php echo $contador_local_autocomplete;?>" name="val_ipi[]" size="1"  value="<?php echo $orc_item->val_ipi; ?>" class="calcula"/>&nbsp;&nbsp;&nbsp;
	Valor Tot.:&nbsp;<input type="text" id="vlr_total_<?php echo $contador_local_autocomplete;?>" name="vlr_total[]" size="8"  value="<?php echo $orc_item->valor_total; ?>" class="dinheiro" readonly="true"/>&nbsp;&nbsp;&nbsp;
	<br>	
	Detalhamento: <textarea id="detalhe_<?php echo $contador_local_autocomplete;?>" rows="5" cols="50" class="span10" name="detalhe[]"><?php echo $orc_item->detalhe; ?></textarea>		
	<a href="#" onclick="removerCampos(this);" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>	
	 	
	<hr>
	</div>-->
		<?
		 $contador_local_autocomplete ++;
		}
		
		?>
		
       <div id="destino" class="span12" style="padding: 1%; margin-left: 0"></div>
	   

	   
	
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
	</td>
	</div>

	
	
	</tr> 
	<tr>
	<td align='right'>
	DESCONTO R$:
	</td>
	<td align='center'>
	<div id="desconto_calculo">
	</div>
	</td>
	</tr> 
<tr>
	<td align='right'>
	VALOR IPI R$:
	</td>
	<td align='center'>
	<div id="ipi_calculo">
	</div>
	</td>
	</tr> 
<tr>
	<td align='right'>
	<B>TOTAL ORÇAMENTO R$:</B>
	</td>
	<td align='center'>
	<B>
	<div id="total_calculo"></div></B>
	</td>
	</tr> 
</table>	
	</div><br><br><br>
 <div class="form-actions" align='center'>
                        
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Salvar</button>
                                <a href="<?php echo base_url() ?>index.php/orcamentos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                           
                    </div>    


</form> 

<?php 
	function corrigiValorBancoJavasScript($valor){
		//$valor = str_replace(".00",".00",$valor);
		//$valor = str_replace(".80","",$valor);
		//echo "alert('".$valorunita."')" ;
		//
		/*if(strpos($valor, ".") > 0 ){
			//echo "alert('".$valorunita."')";
			$valor = str_replace(".","",$valor);
		}*/
		
		return $valor;
	}
?>

<script type="text/javascript">




$(document).ready(function(){

	<?php 
	 $contador_local_autocomplete = 0;
	 $i = 0;
	 foreach ($dados_item as $orc_item) { 
	 
		$valorunita = corrigiValorBancoJavasScript($orc_item->val_unit);
		$sub = corrigiValorBancoJavasScript($orc_item->subtot);
		//echo "alert('".$sub."')" ;
					
	 ?>
	

	var contador_local_autocomplete=contador_global_autocomplete;
	
	var cloneDiv = '<div id="origem" class="span12" style="padding: 1%; margin-left: 0">' +
	'<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>'+
	'<input type="text" id="id_orc_item_'+contador_local_autocomplete+'" name="id_orc_item[]"   value="'+<?php echo $orc_item->idOrcamento_item;?>+'"/>'+
	'<input type="hidden" id="idProdutos_'+contador_local_autocomplete+'" name="idProdutos[]" size="3"   value="'+<?php echo $orc_item->idProdutos;?>+'"/>'+
	'Cod. | Descrição | <b>PN</b>:&nbsp;<input type="text" id="pn_'+contador_local_autocomplete+'" name="pn[]" size="97" ref="autocomplete"  value="Cod.: <?php echo $orc_item->idProdutos;?> | Descrição: <?php echo $orc_item->descricao;?> | PN: <?php echo $orc_item->pn;?>" />'+
	'<br>'+
	'QTD:&nbsp;<input type="text" onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete;?>+')" id="qtd_'+contador_local_autocomplete+'" name="qtd[]" size="1"  value="'+<?php echo $orc_item->qtd;?>+'" onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete;?> +')"/>&nbsp;&nbsp;&nbsp;'+
	'Vl.Unit.:&nbsp;<input type="text" id="val_unit_'+contador_local_autocomplete+'" name="val_unit[]" size="8"  onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete;?> +')" value="'+<?php echo $valorunita;?> +'" class="money"/>&nbsp;&nbsp;&nbsp;'+
	'Sub.Tot.:&nbsp;<input type="text" id="subtot_'+contador_local_autocomplete+'" name="subtot[]" size="8"  value="'+<?php echo $sub; ?>+'" class="money" readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'Prazo:&nbsp;<input type="text" id="prazo_'+contador_local_autocomplete+'" name="prazo[]" size="1"  value="'+<?php echo $orc_item->prazo;?>+'"/>&nbsp;&nbsp;&nbsp;'+
	'Desconto.:&nbsp;<input type="text" id="desconto_'+contador_local_autocomplete+'" name="desconto[]" size="8"  value="'+<?php echo $orc_item->desconto;?>+'" class="money"  onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete;?>+')"/>&nbsp;&nbsp;&nbsp;'+
	'IPI%:&nbsp;<input type="text" id="val_ipi_'+contador_local_autocomplete+'" name="val_ipi[]" size="1"  value="'+<?php echo $orc_item->val_ipi;?>+'"   onBlur="calculaSubTotal('+<?php echo $contador_local_autocomplete;?>+')"/>&nbsp;&nbsp;&nbsp;'+
	'Valor Tot.:&nbsp;<input type="text" id="vlr_total_'+contador_local_autocomplete+'" name="vlr_total[]" size="8"  value="'+<?php echo $orc_item->valor_total;?>+'"  readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'<br>	'+
	'Detalhamento: <textarea id="detalhe_'+contador_local_autocomplete+'" rows="5" cols="50" class="span10" name="detalhe[]"><?php echo $orc_item->detalhe;?></textarea>'+	
	'<a href="#modal-excluir" role="button" data-toggle="modal" produto="'+<?php echo $orc_item->idOrcamento_item;?>+'" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>'+
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
	
	   $(document).on('click', 'a', function(event) {
        
        var produto = $(this).attr('produto');
        $('#item_produt').val(produto);

    });
	
		
	
	
	
	contador_global_autocomplete = contador_global_autocomplete+1;
	
		//calculaSubTotal();
		
	
		
	
		
		<?php
		 $contador_local_autocomplete ++;
		?>
		
		
		
		<?
		 
		}
		
		
		if ( count($dados_item) == $contador_local_autocomplete) {
			?>
			//alert(<?=$contador_local_autocomplete?>)
calculaSubTotal2();
		
<?
}

		
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

function calculaSubTotal2(x)
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
				data: 'valorunit='+$('#val_unit_'+i).val()+'&desconto='+$('#desconto_'+i).val()+'&valoripi='+$('#val_ipi_'+i).val()+'&quant='+$('#qtd_'+i).val()+'',
				success: function($json)  {
				
					console.log($json);
					
					
					$('#subtot_'+i).val($json.subtot);
					$('#vlr_total_'+i).val($json.vlr_total);
					
					alert($json.vlr_total);
					
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
		 var total_calculo = 0;
		 var ipi_calculo = 0;
		 var desconto_calculo = 0;
		 var subtotal_calculo = 0;
  	for (i = 0; i < contador_global_autocomplete; i++) {
		
		
			var valorunit = $('#val_unit_'+i).val();
			valorunit=	valorunit.replace(/\./g, "");
			valorunit=	valorunit.replace(/,/g, ".");
			
			var desconto = $('#desconto_'+i).val();
			desconto=	desconto.replace(/\./g, "");
			desconto=	desconto.replace(/,/g, ".");
			
			var valoripi = $('#val_ipi_'+i).val();
			var quant = $('#qtd_'+i).val();
			
			
			//var total = ((valorunit * quant) - desconto) *  valoripi / 100;
			var total1 = (valorunit * quant);
			var total2 = total1 * valoripi/100;
			var total3 = total1 + total2 - desconto;
			
			
			 subtotal_calculo = subtotal_calculo + total1;
			 ipi_calculo = ipi_calculo + total2;
			 desconto_calculo = desconto_calculo + desconto;
			 total_calculo = total_calculo + total1 + total2 - desconto_calculo;
			
			total3 = parseFloat(total3.toFixed(2));
			total3=(total3).toLocaleString(); 
			
			total1 = parseFloat(total1.toFixed(2));
			total1=(total1).toLocaleString(); 

			$('#subtot_'+i).val(total1);
			$('#vlr_total_'+i).val(total3);
			
			 
			   
			
			
	}	
	//document.getElementByID("total_calculo").innerHTML += total3
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
	 $(".money").maskMoney();
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
 
//$('.dinheiro').mask('#.##0,00', {reverse: true});
 
function duplicarCampos(){
	//var clone = $("#origem").clone();
	//clone.find("input").val("");
	//$("#destino").append(clone);
	
	//alert(contador_global_autocomplete);
	var contador_local_autocomplete=contador_global_autocomplete;
	var cloneDiv = '<div id="origem" class="span12" style="padding: 1%; margin-left: 0">' +
	'<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>'+
	'<input type="hidden" id="id_orc_item_'+contador_local_autocomplete+'" name="id_orc_item[]"   value="0"/>'+
	'<input type="hidden" id="idProdutos_'+contador_local_autocomplete+'" name="idProdutos[]" size="3"   value=""/>'+
	'Cod. | Descrição | <b>PN</b>:&nbsp;<input type="text" id="pn_'+contador_local_autocomplete+'" name="pn[]" size="97" ref="autocomplete"  value="" />'+
	'<br>'+
	'QTD:&nbsp;<input type="text" id="qtd_'+contador_local_autocomplete+'" name="qtd[]" size="1"  value=""  onBlur="calculaSubTotal('+contador_local_autocomplete+')"/>&nbsp;&nbsp;&nbsp;'+
	'Vl.Unit.:&nbsp;<input type="text" id="val_unit_'+contador_local_autocomplete+'" name="val_unit[]" size="8"  value="" class="dinheiro" onBlur="calculaSubTotal('+contador_local_autocomplete+')"/>&nbsp;&nbsp;&nbsp;'+
	'Sub.Tot.:&nbsp;<input type="text" id="subtot_'+contador_local_autocomplete+'" name="subtot[]" size="8"  value="" class="dinheiro" readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'Prazo:&nbsp;<input type="text" id="prazo_'+contador_local_autocomplete+'" name="prazo[]" size="1"  value=""/>&nbsp;&nbsp;&nbsp;'+
	'Desconto.:&nbsp;<input type="text" id="desconto_'+contador_local_autocomplete+'" name="desconto[]" size="8"  value="" class="dinheiro" onBlur="calculaSubTotal('+contador_local_autocomplete+')"/>&nbsp;&nbsp;&nbsp;'+
	'IPI%:&nbsp;<input type="text" id="val_ipi_'+contador_local_autocomplete+'" name="val_ipi[]" size="1"  value=""  onBlur="calculaSubTotal('+contador_local_autocomplete+')"/>&nbsp;&nbsp;&nbsp;'+
	'Valor Tot.:&nbsp;<input type="text" id="vlr_total_'+contador_local_autocomplete+'" name="vlr_total[]" size="8"  value="" class="dinheiro" readonly="true"/>&nbsp;&nbsp;&nbsp;'+
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
	
	//contador_global_autocomplete=contador_global_autocomplete-1;
	$(obj).parent().remove();
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