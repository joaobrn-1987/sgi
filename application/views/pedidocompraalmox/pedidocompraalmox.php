<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>


<?php


echo "<br>";
echo "<br>";	

?>
 
 <div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Buscar Pedido de compra</h5>
            </div>
            <div class="widget-content nopadding">
                

                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Filtro OS</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                 
                              <form class="form-inline" action="<?php echo base_url() ?>index.php/pedidocompraalmox" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

               

                                   
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3" class="control-group">
                                            <label for="idOs" class="control-label">Cod. OS.:</label><br>(P/ vários separar por virgula)
                       <input class="form-control" type="text" name="idOs" value="" autofocus class="span12">
                       
                                        </div>
										<div class="span3" class="control-group">
                                            <label for="idPedidoCompra" class="control-label">Pedido Compra:</label><br>(P/ vários separar por virgula)
                       <input class="form-control" type="text" name="idPedidoCompra" value="" class="span12">
                       
                                        </div>
										 <div class="span6" class="control-group">
                                            <label for="fornecedor" class="control-label">Fornecedor:</label>
            <input class="span12" class="form-control" id="fornecedor"  type="text" name="fornecedor" value=""  />
		<input id="fornecedor_id"  type="hidden" name="fornecedor_id" value=""  />
                                        </div>
										<!--<div class="span3" class="control-group">
                                            <label for="idPedidoCotacao" class="control-label">Cotaçao:</label>
                       <input class="form-control" type="text" name="idPedidoCotacao" value="" class="span12">
                       
                                        </div>-->
										 
                                     
                                       

                                        
                                    </div>

                                   
								   <div class="span12" style="padding: 1%; margin-left: 0">
								   <div class="span12" class="control-group">
                                             
											
                                  <label for="idGrupoServico" class="control-label">Status Ordem Compra:</label><!--&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll22();">&nbsp;Marcar/Desmarcar todos-->
 <br>
 <table width='100%'><tr>
										  <?php 
										  $i = 0;
										  foreach ($dados_statuscompra as $so) 
										  
										  {


										if($so->idStatuscompras <> 1 )
										{
											  ?>
											  <td>
										<input type = "checkbox"  name = "idStatuscompras[]"   class='check' value = "<?php echo $so->idStatuscompras; ?>" > &nbsp;<?php echo $so->nomeStatus; ?>
										</td>
										 <?php 
										 if ( ($i+1) % 4 == 0)
												echo "</tr>";
										 
										 $i++;
										  }
										 } 
										 
										 
										 ?> 
										 
										 
								 </table>
											 
                                        </div>
								   
								   
								   
								   
								   
								   
										
										
										</div>

										
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                       <div class="span3" class="control-group">
                                            <label for="idOs" class="control-label">NF Fornec.:</label><br>(P/ vários separar por virgula)
                       <input class="form-control" type="text" name="nf_fornecedor" value="" autofocus class="span12">
                       
                                        </div>
                                        </div>

 <div class="span12" style="padding: 1%; margin-left: 0">
								   <div class="span12" class="control-group">
                                             
											
                                  <label for="idGrupoServico" class="control-label">Grupo:</label><!--&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll22();">&nbsp;Marcar/Desmarcar todos-->
 <br>
 <table width='100%'><tr>
										  <?php 
										  $i = 0;
										  foreach ($dados_statusgrupo as $so) 
										  
										  {


										
											  ?>
											  <td>
										<input type = "checkbox"  name = "idgrupo[]"   class='check' value = "<?php echo $so->idgrupo; ?>" > &nbsp;<?php echo $so->nomegrupo; ?>
										</td>
										 <?php 
										 if ( ($i+1) % 4 == 0)
												echo "</tr>";
										 
										 $i++;
										  
										 } 
										 
										 
										 ?> 
										 
										 
								 </table>
											 
                                        </div>
								   
								   
								   
								   
								   
								   
										
										
										</div>


										 <div class="span12" class="control-group">
                                             
                       <br>
                             <input class="btn btn-default" type="submit" name="filter" value="Filtrar">
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
        <h5>Montar Pedido de compra</h5>

     </div>

<div class="widget-content nopadding">

 <form class="form-inline" action="<?php echo base_url() ?>index.php/pedidocompraalmox/montarpedidocompra" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<table class="table table-bordered ">
    <thead>
        <tr>
        
                        <th></th>
                        <th>OS</th>
                        <th>Qtd.</th>
                       <th>Descrição</th>
                        
                        <th>OBS</th>
                       <!-- <th>Data que gerou Status:<br>Aguardando orçamento</th>-->
                        <th>Status</th>
                        <th>Grupo</th>
                        <!--<th>Cotação</th>-->
                        <th>O.C.</th>
                        <th>Data Pedido Gerado</th>
						
                        <th>Fornecedor / NF</th>
                        <th>OBS</th>
                        <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
			$color = '';
			
			
			?>
           <tr>
  <td><?php if($r->idPedidoCompraItens == null) { 
  ?><?php //echo $r->idCotacaoItens;?>
  <input type='checkbox' value='<?php echo $r->idCotacaoItens;?>' name='idCotacaoItens_[]'>
  
  <?
  
  } ;?></td>
           <td><?php echo $r->idOs;?></td>
           <td><?php echo $r->quantidade;?></td>
           <td><font size='1'><?php echo $r->descricaoInsumo." ".$r->dimensoes;?></font></td>
           
           <td><font size='1'><?php echo $r->obs;?></font></td>
           <!-- <td><?php echo date("d/m/Y H:i:s", strtotime($r->data_cadastro));?></td>-->
            <td><font size='1'><?php echo $r->nomeStatus;?>
			<?php if(!empty($r->datastatusentregue))
			{
				echo " ".date("d/m/Y", strtotime($r->datastatusentregue));
			}
			?>
			</font>
			</td>
           <td><font size='1'><?php echo $r->nomegrupo;?></font></td>
           <!--<td><?php echo $r->idPedidoCotacao;?></td>-->
           
           <td><?php echo $r->idPedidoCompra;?>
		    <?
		   if($r->idPedidoCompra <> '')
			 {
				if($r->idStatuscompras <> 7)
				{					
			if($this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
				?>
				 <a href="#modal-editarpedidocompra2" style="margin-right: 1%" role="button" data-toggle="modal" itempedidocompra="<?php echo $r->idPedidoCompraItens;?>" class="btn btn-info tip-top" ><i class="icon-pencil icon-white"></i></a>
				 <?
                 
            }
			 }
			 }
			 ?>
		   
		   
		   </td>
		   <td><font size='1'><?php 
		   if(!empty($r->cadpedgerado))
		   {
			   echo date("d/m/Y H:i:s", strtotime($r->cadpedgerado));
		   }
		   else{
		   }
		   ?></font>
		   </td>
		   
           <td><font size='1'><?php echo $r->nomeFornecedor;?> / <b><?php echo $r->notafiscal;?></font></b></td>
           <td><font size='1'><?php echo $r->obscompras;?> </font></td>
		   <td>
		   <a href="#modal-usuario<?php echo $r->idPedidoCompraItens; ?>" style="margin-right: 1%" role="button" data-toggle="modal" idPedidoCompraItens_1="<?php echo $r->idPedidoCompraItens; ?>" class="btn tip-top" ><i class="icon icon-user"></i></a>
		   
		   
		   </td>
		   
            <?
            echo '<td>';
			
			if($r->idPedidoCompra <> '')
			 {
			if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
				echo '<a href="'.base_url().'index.php/pedidocompra/imprimir_pedido/'.$r->idPedidoCompra.'" style="margin-right: 1%" class="btn tip-top"  target="_blank"><i class="icon-print icon-white"></i></a>'; 
				
			}  
            }
	
			

           


			
?>


<?
            
            echo '</td>';
			 echo '<td>';
			 if($r->idPedidoCompra <> '')
			 {
			if($this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
				?> 
				 <a href="<?php echo base_url().'index.php/pedidocompra/editarpedido/'.$r->idPedidoCompra ?>" style="margin-right: 1%" role="button" data-toggle="modal" cotacao="<?php echo $r->idPedidoCompra;?>" class="btn btn-info tip-top" ><i class="icon-pencil icon-white"></i></a>
				 <?
                 
            }
			 }
			
			 echo '</td>';
			 echo '<td>';
			 if($r->idPedidoCompraItens <> '')
			 {
				 if($r->idStatuscompras <> 8 && $r->idStatuscompras <> 9 && $r->idStatuscompras <> 7)
				{
			if($this->permission->checkPermission($this->session->userdata('permissao'),'dPedCompra')){
				?>
				 <a href="#modal-excluiritempedido" style="margin-right: 1%" role="button" data-toggle="modal" idPedidoCompraItens_1="<?php echo $r->idPedidoCompraItens; ?>" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a>
				 <?
                 
            }
				}
			 }
			
			 echo '</td>';
            echo '</tr>';
			
			?>
		
	

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
		
			
			<?
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
<?php //echo $this->pedidocompra->estoque_atual(1); ?>
 <div class="form-actions" align='center'>
                        
           <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Gerar Pedido</button>
                               
                           
                    </div>  
</form>
</div>
</div>
<?php echo $this->pagination->create_links();?>
<div id="modal-editarpedidocompra2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form  action="<?php echo base_url() ?>index.php/pedidocompraalmox/editarpc" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

 
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar número do pedido</h5>
  </div>
  <div class="modal-body">
     <!--<input type="hidden" id="idPedidoCompra" name="idPedidoCompra" value="<?php echo $r->idPedidoCompra; ?>" />
     <input type="hidden" id="idCotacaoItens" name="idCotacaoItens" value="<?php echo $r->idCotacaoItens; ?>" />
    --><input type="hidden" id="idPedidoCompraItens_" name="idPedidoCompraItens_" value="" />
    Enviar item para o pedido de compra número:<input type="text" id="idPedidoCompra_n" name="idPedidoCompra_n" value="" />
    
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Salvar</button>
  </div>
  </form>
</div>




<div id="modal-excluiritempedido" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/pedidocompraalmox/excluir_itempedido" method="post" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Item da Cotação</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idPedidoCompraItens_nn" name="idPedidoCompraItens_nn" value="" />
   <!-- idCotacaoItens<input type="text" id="idCotacaoItens" name="idCotacaoItens" value="<?php echo $r->idCotacaoItens; ?>" />
    idDistribuir<input type="text" id="idDistribuir" name="idDistribuir" value="<?php echo $r->idDistribuir; ?>" />
  -->
    <h5 style="text-align: center">Deseja realmente excluir este item do pedido?</h5>
	Para excluir o pedido de compra  INTEIRO com todos os itens, selecione SIM, caso deseja excluir somente esse item do pedido seleciona NÃO: <select name='todos'>
	<option value='nao' selected>Não</option>
	<option value='sim'>sim</option>
     </select>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>	

<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var itempedidocompra = $(this).attr('itempedidocompra');
        $('#idPedidoCompraItens_').val(itempedidocompra);

    });
	
	 $(document).on('click', 'a', function(event) {
        
        var idPedidoCompraItens_1 = $(this).attr('idPedidoCompraItens_1');
        $('#idPedidoCompraItens_nn').val(idPedidoCompraItens_1);

    });
	
	
	
	

});

$("#fornecedor").autocomplete({
            source: "<?php echo base_url(); ?>index.php/pedidocompraalmox/autoCompletefornecedor",
            minLength: 1,
            select: function( event, ui ) {

                 $("#fornecedor_id").val(ui.item.id);
                
					

            }
      });
	  
	  
</script>
<script>
ok2=false;
function CheckAll22() {
    if(!ok2){
      for (var i=0;i<document.form1.elements.length;i++) {
        var x = document.form1.elements[i];
        if (x.name == 'idStatuscompras[]') {        
                x.checked = true;
                ok2=true;
            }
        }
    }
    else{
    for (var i=0;i<document.form1.elements.length;i++) {
        var x = document.form1.elements[i];
        if (x.name == 'idStatuscompras[]') {        
                x.checked = false;
                ok2=false;
            }
        }    
    }
}
</script>