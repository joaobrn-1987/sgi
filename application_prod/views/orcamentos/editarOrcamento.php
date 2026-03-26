<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<!--<script src="<?php echo base_url();?>js/jquery.mask.min.js"></script>-->
<!--<script src="<?php echo base_url();?>js/maskmoney.js"></script>-->
<!--<script type="text/javascript" src="<?php echo base_url()?>js/jquery-1.10.2.min.js"></script>-->


<!--<body onload="calculaSubTotal();">-->
<body onLoad="calculaSubTotal();" >
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
 <button class="btn btn-inverse tip-top" ><i class="icon-print icon-white"></i></button>
Data:<input type='date' name='dataInicial' value='' class="span2" class="control-group">
<input type='hidden' name='idOrcamentos' value='<?php echo $result->idOrcamentos;?>'>
<?php
if($result->status_orc == 0)
{
           

			 if($this->permission->checkPermission($this->session->userdata('permissao'),'APOrcamento')){
                echo '<a href="'.base_url().'index.php/orcamentos/aprovar/'.$result->idOrcamentos.'" style="margin-right: 1%" class="btn btn-success tip-top" ><i class="icon-ok icon-white"></i>Aprovar</a>'; 
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
                <h5>Editar de Orçamento - Data Orçamento: 	<?php echo date("d/m/Y H:i:s", strtotime($result->data_abertura));?></h5> 
				


            </div>
			<form action="<?php echo current_url(); ?>" id="formOrcamento" method="post"  >
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
                                        <div class="span4"  class="control-group">
                                            <label for="idEmitente" class="control-label"><span class="required">*</span>Emitente:</label>
                        
                        <select class="form-control" name="idEmitente">
                        
                        <?php foreach ($dados_emitente as $e) { ?>
                        
                        <option value="<?php echo $e->id; ?>" <?php if($e->id == $result->idEmitente){ echo "selected='selected'";}?>><?php echo $e->nome; ?></option>
                        <?php } ?>
                        
                        </select>
                                        </div>
                                        <div class="span6" class="control-group">
                                           
                             <label for="cliente"><span class="required">*</span>Cliente</label>
                               <input id="cliente" class="span12" class="controls" type="text" name="cliente" value="<?php echo $result->nomeCliente; ?> | CNPJ:<?php echo $result->documento; ?>" size='50' />
							 <input id="clientes_id"  type="hidden" name="clientes_id" value="<?php echo $result->idClientes; ?>"  />
                                        </div>
										<div class="span2" class="control-group">
										
							 <label for="idSolicitante" class="control-label"><span class="required">*</span>Solicitante:</label>
                          
                            <select class="recebe-solici" class="controls" name="idSolicitante" id="idSolicitante">
							<?php foreach ($dados_solicitante as $so) { ?>
                        
                        <option value="<?php echo $so->idSolicitante; ?>" <?php if($so->idSolicitante == $result->idSolicitante){ echo "selected='selected'";}?>><?php echo $so->nome; ?></option>
                        <?php } ?>
                       
					   
							
                           
                            </select>
										</div>
                                    </div>
                                    <div class="span12" style="padding: 0.2%; margin-left: 0">
                                        <div class="span3" class="control-group">
                                            <label for="idstatusOrcamento" class="control-label"><span class="required">*</span>Status Orçamento:</label>
                       
                        <select class="form-control" name="idstatusOrcamento">
                      
                        <?php foreach ($dados_statusorcamento as $o) { ?>
                        
                        <option value="<?php echo $o->idstatusOrcamento; ?>" <?php if($o->idstatusOrcamento == $result->idstatusOrcamento){ echo "selected='selected'";}?>><?php echo $o->nome_status_orc; ?></option>
                        <?php } ?>
                       
                        </select>
                                        </div>
                                        <div class="span2" class="control-group">
                                           
										   <label for="idVendedor" class="control-label"><span class="required">*</span>Vendedor:</label>
                        
                        <select class="form-control" name="idVendedor">
                        
                        <?php foreach ($dados_vendedor as $v) { ?>
                        
                        <option value="<?php echo $v->idVendedor; ?>" <?php if($v->idVendedor == $result->idVendedor){ echo "selected='selected'";}?>><?php echo $v->nomeVendedor; ?></option>
                        <?php } ?>
                       
                        </select> 
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="idGerente" class="control-label"><span class="required">*</span>Gerente:</label>
                        
                        <select class="form-control" name="idGerente">
                        
                        <?php foreach ($dados_gerente as $g) { ?>
                        
                        <option value="<?php echo $g->idGerente; ?>" <?php if($g->idGerente == $result->idGerente){ echo "selected='selected'";}?>><?php echo $g->nome; ?></option>
                        <?php } ?>
                        
                        </select>
										   
                                        </div>

                                        <div class="span2 class="control-group">
                                         <label for="idGrupoServico" class="control-label"><span class="required">*</span>Grupo Serviço:</label>
                       
                        <select class="form-control" name="idGrupoServico">
                        
                        <?php foreach ($dados_gruposervico as $gs) { ?>
                        
                        <option value="<?php echo $gs->idGrupoServico; ?>" <?php if($gs->idGrupoServico == $result->idGrupoServico){ echo "selected='selected'";}?>><?php echo $gs->nome; ?></option>
                        <?php } ?>
                       
                        </select>   
                                        </div>
										 <div class="span2" class="control-group">
										 <label for="idNatOperacao" class="control-label"><span class="required">*</span>Nat. Operação:</label>
                       
                        <select class="form-control" name="idNatOperacao">
                       
                        <?php foreach ($dados_natoperacao as $nt) { ?>
                        
                        <option value="<?php echo $nt->idNatOperacao; ?>" <?php if($nt->idNatOperacao == $result->idNatOperacao){ echo "selected='selected'";}?>><?php echo $nt->nome; ?></option>
                        <?php } ?>
                       
                        </select>
						                  </div>
                                    </div>

                                    <div class="span12" style="padding: 0.2%; margin-left: 0">

                                        <div class="span1" class="control-group">
                                           
                        <label for="referencia" class="control-label">Val. Prop.:</label>
                      
                            <input id="validade" class="span7" type="text" name="validade" value="<?php echo $result->validade; ?>"  size='15'/>
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
                                             <label for="entrega" class="control-label">Entrega:</label>
                       
                        <input type="radio" name="entrega" <?php if($result->entrega == 'FOB'){ echo "checked='yes'";}?>  VALUE="FOB"/>FOB
                        <input type="radio" name="entrega" <?php if($result->entrega == 'CIF'){ echo "checked='yes'";}?>  VALUE="CIF"/>CIF
                        <input type="radio" name="entrega"  VALUE="OUTRO" <?php if($result->entrega == 'OUTRO'){ echo "checked='yes'";}?>/>Outro <input class="span6" id="entregaoutros" type="text" name="entregaoutros" value="<?php echo $result->entregaoutros; ?>"  size="50"/>
                                        </div>
										<div class="span2" class="control-group">
                                           
                        <label for="referencia" class="control-label">Referência:</label>
                      
                            <input id="referencia" class="span12" type="text" name="referencia" value="<?php echo $result->referencia; ?>"  />
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 0.2%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <label for="num_pedido" class="control-label">Num. Pedido:</label>
                       
                            <input id="num_pedido" class="span12" type="text" name="num_pedido" value="<?php echo $result->num_pedido; ?>"  />
                                        </div>
                                        
										 
										 <div class="span2" class="control-group">
                                             <label for="num_nf" class="control-label">Num. Nota Fiscal:</label>
                       
                            <input id="num_nf" type="text" name="num_nf" class="span12" value="<?php echo $result->num_nf; ?>"  />
                            <input id="idOrcamentos" type="hidden" name="idOrcamentos"  value="<?php echo $result->idOrcamentos; ?>"  />
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
       <h5>Cadastro de Itens </h5> <!--<a href="#" onclick="duplicarCampos();calculaSubTotal();" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Itens</a>-->
	   <a href="#modal-adicionaritem" style="margin-right: 1%" role="button" data-toggle="modal"    class="btn btn-success"><i class="icon-plus icon-white"></i>Adicionar Itens</a>
	   

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
	
	<div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">
	
	</div>
	
	 <?php 
	 $contador_local_autocomplete = 0;
	 foreach ($dados_item as $orc_item) { ?>
	<div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">
	<input type="hidden" id="item<?php echo $contador_local_autocomplete;?>" name="item[]"  value="" size="1"/>
	<input type="hidden" id="id_orc_item_<?php echo $contador_local_autocomplete;?>" name="id_orc_item[]"   value="<?php echo $orc_item->idOrcamento_item;?>"/>
	<input type="hidden" id="idProdutos_<?php echo $contador_local_autocomplete;?>" name="idProdutos[]" size="3"   value="<?php echo $orc_item->idProdutos;?>"/>
	Descrição:&nbsp;<input type="text" id="descricao_item_<?php echo $contador_local_autocomplete;?>" name="descricao_item[]" size="80" value="<?php echo $orc_item->descricao_item;?>" onclick="this.select();"/>
	
		
	
	&nbsp;PN:&nbsp;<input type="text" id="pn_<?php echo $contador_local_autocomplete;?>" name="pn[]" size="65" ref="autocomplete"  value="<?php echo $orc_item->pn;?> | Descrição: <?php echo $orc_item->descricao;?>" onclick="this.select();"/>
	<br>
	QTD:&nbsp;<input type="text" id="qtd_<?php echo $contador_local_autocomplete;?>" name="qtd[]"  size="1"  value="<?php echo $orc_item->qtd;?>" onKeyUp="calculaSubTotal(<?php echo $contador_local_autocomplete; ?>);" onclick="this.select();"/>&nbsp;&nbsp;&nbsp;
	Vl.Unit.:&nbsp;<input type="text" id="val_unit_<?php echo $contador_local_autocomplete;?>" name="val_unit[]" size="8"  value="<?php echo number_format($orc_item->val_unit, 2, ",", ".");?>" onclick="this.select();" onKeyUp="calculaSubTotal(<?php echo $contador_local_autocomplete; ?>);"  onKeyPress="FormataValor2(this,event,12,2);"/>&nbsp;&nbsp;&nbsp;
	Sub.Tot.:&nbsp;<input type="text" id="subtot_<?php echo $contador_local_autocomplete;?>" name="subtot[]" size="8"  value="<?php echo number_format($orc_item->subtot, 2, ",", ".") ?>" readonly="true"/>&nbsp;&nbsp;&nbsp;
	Prazo:&nbsp;<input type="text" id="prazo_<?php echo $contador_local_autocomplete;?>" name="prazo[]" size="1"  value="<?php echo $orc_item->prazo;?>" onclick="this.select();"/>&nbsp;&nbsp;&nbsp;
	Desconto.:&nbsp;<input type="text" id="desconto_<?php echo $contador_local_autocomplete;?>" name="desconto[]" size="8"  value="<?php echo number_format($orc_item->desconto, 2, ",", ".");?>" onclick="this.select();" onKeyUp="calculaSubTotal(<?php echo $contador_local_autocomplete; ?>);"  onKeyPress="FormataValor2(this,event,12,2);" />&nbsp;&nbsp;&nbsp;
	IPI%:&nbsp;<input type="text" id="val_ipi_<?php echo $contador_local_autocomplete;?>" name="val_ipi[]" size="1"  value="<?php echo number_format($orc_item->val_ipi, 2, ",", ".");?>"  onKeyUp="calculaSubTotal(<?php echo $contador_local_autocomplete; ?>);" onclick="this.select();" onKeyPress="FormataValor2(this,event,12,2);"/>&nbsp;&nbsp;&nbsp;
	Valor Tot.:&nbsp;<input type="text" id="vlr_total_<?php echo $contador_local_autocomplete;?>" name="vlr_total[]" size="8"  value="<?php echo $orc_item->valor_total;?>"  readonly="true"/>&nbsp;&nbsp;&nbsp;
	<br>
	Detalhamento: <textarea id="detalhe_<?php echo $contador_local_autocomplete;?>" cols="50" class="span10" name="detalhe[]"><?php echo $orc_item->detalhe;?></textarea>		
	<a href="#modal-excluir" role="button" data-toggle="modal" produto="<?php echo $orc_item->idOrcamento_item;?>" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a>
	 	
	<hr>
	</div>
	 
	
	
	<script type="text/javascript">
	$(document).ready(function(){
		//alert(<?php echo $contador_local_autocomplete;?>);
	//var contador_local_autocomplete=contador_global_autocomplete;
	console.log('#idProdutos_'+<?php echo $contador_local_autocomplete;?>);
	/*$("#pn_"+<?php echo $contador_local_autocomplete;?>).autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutos_'+<?php echo $contador_local_autocomplete;?>).val(ui.item.id);

		}
	});*/
	$("#pn_"+<?php echo $contador_local_autocomplete;?>).autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN_2",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutos_'+<?php echo $contador_local_autocomplete;?>).val(ui.item.id);
			 $('#descricao_item_'+<?php echo $contador_local_autocomplete;?>).val(ui.item.no);

		}
	});
	
	
	
	
	   $(document).on('click', 'a', function(event) {
        
        var produto = $(this).attr('produto');
        $('#item_produt').val(produto);

    });
	
	});
		
	
	
	
	//contador_global_autocomplete = contador_global_autocomplete+1;
	</script>
	
		<?php
		 $contador_local_autocomplete ++;
		}
		
		?>
		
       <div id="destino" class="span12" style="padding: 0.2%; margin-left: 0"></div>
	   
<a href="#modal-adicionaritem" style="margin-right: 1%" role="button" data-toggle="modal"    class="btn btn-success"><i class="icon-plus icon-white"></i>Adicionar Itens</a>
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
	<!--<div id="subtotal_calculo">
	
	</div>-->
	<input name="subtotal_calculo" type="text" id="subtotal_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
</td>
	
	
	</tr> 
	<tr>
	<td align='right'>
	DESCONTO R$:
	</td>
	<td align='center'>
	<!--<div id="desconto_calculo">
	</div>-->
	<input name="desconto_calculo" type="text" id="desconto_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
	</td>
	</tr> 
<tr>
	<td align='right'>
	VALOR IPI R$:
	</td>
	<td align='center'>
	<!--<div id="ipi_calculo">
	</div>-->
	<input name="ipi_calculo" type="text" id="ipi_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
	</td>
	</tr> 
<tr>
	<td align='right'>
	<B>TOTAL ORÇAMENTO R$:</B>
	</td>
	<td align='center'>
	<B>
	<!--<div id="total_calculo"></div>-->
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
	
	/*var cloneDiv = '<div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">' +
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
		
		
		
		<?php
		 
		//}
		
		
		//if ( count($dados_item) == $contador_local_autocomplete) {
			?>
			//alert(<?=$contador_local_autocomplete?>)
//calculaSubTotal();
		
<?php
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
		

function calculaSubTotal(x){
	//alert('contunit'+contador_global_autocomplete);
		 var total_calculo = 0;
		 var ipi_calculo = 0;
		 var desconto_calculo = 0;
		 var subtotal_calculo = 0;
  	for (i = 0; i < contador_global_autocomplete; i++) {
		
		//alert(contador_global_autocomplete);
			var valorunit = $('#val_unit_'+i).val();
			//valorunit = valorunit.toString().replace( ".", "" );
			//valorunit = valorunit.toString().replace( ",", "." );
		
			valorunit=Formata_Moeda(valorunit);	
			
			/*valorunit=	valorunit.replace(/\./g, "");
			valorunit=	valorunit.replace(/,/g, ".");*/
			
			var desconto = $('#desconto_'+i).val();
			//desconto = desconto.toString().replace( ".", "" );
			///desconto = desconto.toString().replace( ",", "." );
			/*desconto=	desconto.replace(/\./g, "");
			desconto=	desconto.replace(/,/g, ".");*/
			
			desconto=Formata_Moeda(desconto);	
			
			var valoripi = $('#val_ipi_'+i).val();
			//valoripi = valoripi.toString().replace( ".", "" );
			//valoripi = valoripi.toString().replace( ",", "." );
			/*desconto=	desconto.replace(/\./g, "");
			desconto=	desconto.replace(/,/g, ".");*/
			
			valoripi=Formata_Moeda(valoripi);	
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
			
			
			
			
			var qtd = $('#qtd_'+i).val();
			
			
			//var total = ((valorunit * qtd) - desconto) *  valoripi / 100;
			var total1 = (valorunit * qtd);
			var total2 = total1 * valoripi/100;
			
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
			
			
			
			$('#subtot_'+i).val(Formata_Dinheiro(total1));
			$('#vlr_total_'+i).val(Formata_Dinheiro(total3));
			
			 
			   
			
			
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
	
	
$(document).ready(function(){
	// $(".money").maskMoney();
	 //$('.dinheiro').mask('#.##0,00', {reverse: true});
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
	//alert('duplicarlocal'+contador_global_autocomplete);
	
	var cloneDiv = '<div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">' +
	'<input type="hidden" id="item'+contador_local_autocomplete+'" name="item[]"  value="" size="1"/>'+
	'<input type="hidden" id="id_orc_item_'+contador_local_autocomplete+'" name="id_orc_item[]"   value="0"/>'+
	'<input type="hidden" id="idProdutos_'+contador_local_autocomplete+'" name="idProdutos[]" size="3"   value=""/>'+
	'Descrição:&nbsp;<input type="text" id="descricao_item_'+contador_local_autocomplete+'" name="descricao_item[]" size="80" value="" />'+
	'&nbsp;&nbsp;&nbsp;PN:&nbsp;<input type="text" id="pn_'+contador_local_autocomplete+'" name="pn[]" size="65" ref="autocomplete"  value="" onclick="this.select();" />'+
	'<br>'+
	'QTD:&nbsp;<input type="text" id="qtd_'+contador_local_autocomplete+'" name="qtd[]" size="1"  value="1" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');" onclick="this.select();"/>&nbsp;&nbsp;&nbsp;'+
	'Vl.Unit.:&nbsp;<input type="text" id="val_unit_'+contador_local_autocomplete+'" name="val_unit[]" size="8"  value="0,00" onclick="this.select();" onKeyPress="FormataValor2(this,event,10,2);" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"/>&nbsp;&nbsp;&nbsp;'+
	'Sub.Tot.:&nbsp;<input type="text" id="subtot_'+contador_local_autocomplete+'" name="subtot[]" size="8"  value=""  readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'Prazo:&nbsp;<input type="text" id="prazo_'+contador_local_autocomplete+'" name="prazo[]" size="1"  value="20" onclick="this.select();"/>&nbsp;&nbsp;&nbsp;'+
	'Desconto.:&nbsp;<input type="text" id="desconto_'+contador_local_autocomplete+'" name="desconto[]" size="8"  value="0,00" onKeyPress="FormataValor2(this,event,10,2);"  onKeyUp="calculaSubTotal('+contador_local_autocomplete+');" onclick="this.select();"/>&nbsp;&nbsp;&nbsp;'+
	'IPI%:&nbsp;<input type="text" id="val_ipi_'+contador_local_autocomplete+'" name="val_ipi[]" size="1"  value="0,00"  onKeyUp="calculaSubTotal('+contador_local_autocomplete+');" onKeyPress="FormataValor2(this,event,10,2);" onclick="this.select();"/>&nbsp;&nbsp;&nbsp;'+
	'Valor Tot.:&nbsp;<input type="text" id="vlr_total_'+contador_local_autocomplete+'" name="vlr_total[]" size="8"  value=""  readonly="true"/>&nbsp;&nbsp;&nbsp;'+
	'<br>	'+
	
	'Detalhamento: <textarea id="detalhe_'+contador_local_autocomplete+'" cols="50" class="span10" name="detalhe[]"></textarea>'+		
	'<a href="#" onclick="removerCampos(this);" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a>	'+
	 	
	'<hr>'+
	'</div>';
	
	$("#destino").append(cloneDiv);

	console.log('#idProdutos_'+contador_global_autocomplete);
	$("#pn_"+contador_global_autocomplete).autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN_2",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutos_'+contador_local_autocomplete).val(ui.item.id);
			 $('#descricao_item_'+contador_local_autocomplete).val(ui.item.no);


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
 
 
function removerCampos(obj){
	 var div = $(obj).parent();
	valor = div.find("input:eq(0)").val();
	
	contador_global_autocomplete=contador_global_autocomplete-1;
	$(obj).parent().remove();
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


function copiarOrcamento(){
	$('#modal-copiar').modal('show');
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
<div id="modal-copiar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="<?php echo base_url() ?>index.php/orcamentos/copiarorcamento" method="post">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5 id="myModalLabel">Copiar Orçamento</h5>
		</div>
		<div class="modal-body">
			<div class="widget-content nopadding">
				<div class="span12" id="divProdutosServicos" style="margin-left: 0">
					<div class="span12" id="divCadastrarOs">                                
						<div class="widget-box" style="margin-top:0px">    
							<input type="hidden" name="idOrcCopiar" value="<?php echo $result->idOrcamentos; ?>">                                    
							<table id="table_id" class="table table-bordered ">
								<thead>
									<tr>
										<th></th>
										<th>PN</th>
										<th>Descrição</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach($dados_item as $item){
											echo '<tr>';
												echo '<td><input type="checkbox" name="copiarOrc[]" value="'.$item->idOrcamento_item.'"></td>';
												echo '<td>'.$item->pn.'</td>';
												echo '<td>'.$item->descricao_item.'</td>';
											echo '</tr>';
										}
									?>
																															
								</tbody>
							</table>
						</div>                                
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button class="btn btn-danger" >Confirmar</a>
		</div>
	</form>
</div>
<div id="modal-adicionaritem" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/orcamentos/adicionaritem" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Inserir mais um item para esse orçamento</h5>
  </div>
  <div class="modal-body">
  <input id="idOrcamentositem"  type="hidden" name="idOrcamentositem" value="<?php echo $result->idOrcamentos;?>"  />
 
      
    <h5 style="text-align: center">Deseja adicionar item ao orçamento: <?php echo $result->idOrcamentos;?>?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Adicionar</button>
  </div>
  </form>
</div>
		
         
<!--https://pt.stackoverflow.com/questions/9548/como-clonar-um-elemento-com-jquery-e-adicionar-um-novo-name-->