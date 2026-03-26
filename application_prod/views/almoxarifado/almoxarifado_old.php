<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>


<?php

if(!$results){
		
?>


        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>OS</h5>
<a href="#modalinserir" data-toggle="modal" role="button" class="btn btn-success" title="Inserir"><i class="icon-plus icon-white"></i> Cadastrar Materiais Almoxarifado</a>
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
 
 <div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Buscar Item da OS</h5>
				<h5> <a href="#modal-statuscompra"  role="button" data-toggle="modal"  title="Editar status"><font color='red'>Definições de status</font></a></h5>
            </div>
            <div class="widget-content nopadding">
                

                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Filtro OS</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                 
        <form class="form-inline" action="<?php echo base_url() ?>index.php/almoxarifado" method="post">
               

                                   
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span4" class="control-group">
                                            <label for="idOs" class="control-label">Cod. OS.:</label>
                       <input class="form-control" type="text" name="idOs" value="" autofocus class="span12">
                       
                                        </div>
										<div class="span4" class="control-group">
                                            <label for="idPedidoCotacao" class="control-label">Cotaçao:</label>
                       <input class="form-control" type="text" name="idPedidoCotacao" value="" class="span12">
                       
                                        </div>
										 
                                      <div class="span4" class="control-group">
                                            <label for="idStatuscompras" class="control-label">Status:</label>
                       
                        <select class="recebe-solici" class="controls" name="idStatuscompras" id="idStatuscompras">
							 <option value="" selected='selected'></option>
							<?php foreach ($dados_statuscompra as $so) { ?>
                       
                       <!-- <option value="<?php echo $so->idStatuscompras; ?>" <?php if($so->idStatuscompras == $result->idStatuscompras){ echo "selected='selected'";}?>><?php echo $so->nomeStatus; ?></option>-->
					   <option value="<?php echo $so->idStatuscompras; ?>" ><?php echo $so->nomeStatus; ?></option>
                        <?php } ?>
                       
					    
                            </select>
                                        </div>  
                                       

                                        
                                    </div>

                                   
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                       
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
        <h5>Montar cotação</h5>

<?php //if($this->permission->checkPermission($this->session->userdata('permissao'),'eDistribuirOs')){ ?>

<a href="#modalinserir" data-toggle="modal" role="button" class="btn btn-success" title="Inserir"><i class="icon-plus icon-white"></i> Cadastrar Materiais Almoxarifado</a>
     </div>

<div class="widget-content nopadding">

 <form class="form-inline" action="<?php echo base_url() ?>index.php/cotacao/montarcotacao/1" method="post">
<table class="table table-bordered ">
    <thead>
        <tr>
        
                        <th></th>
                        <th>Nº OS</th>
                        <th>Qtd. - Editar</th>
                       <th>Descrição</th>
                       <!-- <th>Dimensões</th>-->
                        <th>OBS</th>
                        <th>Grupo</th>
                        <th>Data Cadastro</th>
                        <th>Status</th>
                        <!--<th>Cotação</th>-->
                        <th>Pedido Compra</th>
                        <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
			$color = '';
			
			
			?>
           <tr>
  <td><?php if($r->idStatuscompras == 1) { 
  ?><?php echo $r->idDistribuir;?>
  <input type='checkbox' value='<?php echo $r->idDistribuir;?>' name='idDistribuir_[]'>
  <?php
  
  } ;?></td>
           <td>
		   <?php
		   if($r->idOs == 3)
		   {
			   $emp = "UBERTEC";
		   }
		   if($r->idOs == 2)
		   {
			   $emp = "PETROL.";
		   }
		   if($r->idOs == 1)
		   {
			   $emp = "KRMB";
		   }
		    
		   
		   
		   ?>
		   <?php echo $r->idOs." - ".$emp;?></td>
           <td><?php echo $r->quantidade;?> 

		   
		   </td>
           <td><?php echo $r->descricaoInsumo." ".$r->dimensoes;?></td>
          
           <td><?php echo $r->obs;?></td>
           <td><?php echo $r->nomegrupo;?></td>
            <td><?php echo date("d/m/Y H:i:s", strtotime($r->data_cadastro));?></td>
            <td><?php echo $r->nomeStatus;
			/*if($r->idStatuscompras == 2)
			{
			if($this->permission->checkPermission($this->session->userdata('permissao'),'eAlmoxarifado')){
				?>
				 <a href="#modal-editaritemcotstatus" style="margin-right: 1%" role="button" data-toggle="modal" idCotacaoItens__edista="<?php echo $r->idCotacaoItens;?>" class="btn btn-info tip-top" title="Editar status"><i class="icon-pencil icon-white"></i></a>
				 <?
                 
            }
			}*/
			?></td>
          <!-- <td><?php echo $r->idPedidoCotacao;?></td>-->
           
           <td><?php echo $r->idPedidoCompra;?></td>
           
            <?php
            echo '<td>';
			if($r->idStatuscompras <> 6)
			{
			if($r->idPedidoCotacao <> '')
			 {
			if($this->permission->checkPermission($this->session->userdata('permissao'),'vAlmoxarifado')){
                echo '<a href="'.base_url().'index.php/cotacao/visualizarimprimir/'.$r->idPedidoCotacao.'" style="margin-right: 1%" class="btn tip-top" title="Imprimir cotação" ><i class="icon-eye-open"></i></a>'; 
            }
		}
		}
			

         


			
?>


<?php
            
            echo '</td>';
			 echo '<td>';
			 if($r->idStatuscompras <> 6)
			{
			  if($r->idPedidoCompra == null || $r->liberado_edit_compras == 1)
			  {
			
			if($this->permission->checkPermission($this->session->userdata('permissao'),'eAlmoxarifado')){
				
				echo '<a href="'.base_url().'index.php/almoxarifado/almoxarifadoeditar/'.$r->idDistribuir.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar cotação" ><i class="icon-pencil icon-white"></i></a>'; 
				
				
				?>
				<!--<a href="#" onclick="window.open('<?php echo base_url() ?>index.php/almoxarifado/editar_distribuiros/<?php echo $r->idDistribuir; ?>', 'Alterar item', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=770, HEIGHT=400');" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>-->
				
				
				
				 
				 <?php
                 
            }
			 
		}
		}
			
			 echo '</td>';
			 echo '<td>';
			 if($r->idPedidoCompra == null)
			 {
				  
				if(!empty($r->idCotacaoItens))
				{					
			if($this->permission->checkPermission($this->session->userdata('permissao'),'dAlmoxarifado')){
				?>
				 <a href="#modal-excluiritemcot" style="margin-right: 1%" role="button" data-toggle="modal" idCotacaoItens__="<?php echo $r->idCotacaoItens; ?>" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a>
				 <?php
                 
            }
			 }
			 else
			 {
				 
				 ?>
				 <a href="#modal-excluiritemdistribuir" style="margin-right: 1%" role="button" data-toggle="modal" idCotacaoItens3__="<?php echo $r->idDistribuir; ?>" class="btn btn-danger tip-top" title="Excluir item"><i class="icon-remove icon-white"></i></a>
				 <?php
			 }
			 }
			
			 echo '</td>';
            echo '</tr>';
			
			?>
			
	<div id="modalAlterarpedido<?php echo $r->idDistribuir; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar Material: OS = <?php echo $r->idOs." - ".$emp; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/almoxarifado/editar_distribuiros" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
    
                        <div class="controls">
						Descrição <input id="term<?php echo $r->idDistribuir; ?>" type="text" name="term<?php echo $r->idDistribuir; ?>" value="<?php echo $r->descricaoInsumo; ?>" class='span12' />
						
                   
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $r->idOs; ?>"  />
                            <input id="idInsumos<?php echo $r->idDistribuir; ?>" type="hidden" name="idInsumos" value="<?php echo $r->idInsumos; ?>" class='span12' />
                        </div>
						
                        <div class="controls">
						 Quantidade<input id="quantidade<?php echo $r->idDistribuir; ?>" type="text" name="quantidade" value="<?php echo $r->quantidade; ?>"  class='span12'/>
						 </div>
                       
                        <div class="controls">
						 Dimensões<input id="dimensoes<?php echo $r->idDistribuir; ?>" type="text" name="dimensoes" value="<?php echo $r->dimensoes; ?>"  class='span12'/>
						
     <input id="idDistribuir<?php echo $r->idDistribuir; ?>" type="hidden" name="idDistribuir" value="<?php echo $r->idDistribuir; ?>"  />
                           
                        </div>
						
						
                        <div class="controls">
						OBS<textarea id="obs<?php echo $r->idDistribuir; ?>" rows="5" cols="100" class="span12" name="obs"><?php echo $r->obs; ?></textarea>
						
                   
				   	
    
                        </div>
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button>
  </div>
     </form>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function(){
	
	//console.log('#idInsumos2');
	$("#term"+<?php echo $r->idDistribuir; ?>).autocomplete({
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
		minLength: 1,
		select: function( event, ui ) {
			//alert($('#idInsumos').val(ui.item.id));
			 $('#idInsumos'+<?php echo $r->idDistribuir; ?>).val(ui.item.id);

		}
	});
	
	
	
	
	
	
	$("#pna2"+<?php echo $dist->idDistribuir; ?>).autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutosa2'+<?php echo $dist->idDistribuir; ?>).val(ui.item.id);

		}
	});

  
     
   
});
 
</script>
	
			
			<?php
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
 <div class="form-actions" align='center'>
                        
           <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Gerar cotação</button>
                               
                           
                    </div>  
</form>
</div>
</div>
<?php echo $this->pagination->create_links();}?>


<div id="modal-editar_1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/almoxarifado/editar_1" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Liberar item para editar quantidade</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="id_item_pc1" name="id_item_pc1" value="" />
   
     
    <h5 style="text-align: center">Deseja realmente liberar este item para edição?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Liberar</button>
  </div>
  </form>
</div>
<div id="modal-editar_0" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/almoxarifado/editar_0" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Travar item para edição de quantidade</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="id_item_pc2" name="id_item_pc2" value="" />
 
    <h5 style="text-align: center">Deseja travar edição?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Confirmar</button>
  </div>
  </form>
</div>
 <!-- excluir -->
 
<div id="modal-excluiritemcot" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/cotacao/excluir_itemcotacao/1" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Item da Cotação</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCotacaoItens2" name="idCotacaoItens2" value="" />
  
    
    <h5 style="text-align: center">Deseja realmente excluir este item?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>

<div id="modal-excluiritemdistribuir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/almoxarifado/excluir_itemdist" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Item</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCotacaoItens22" name="idCotacaoItens22" value="" />
  
    
    <h5 style="text-align: center">Deseja realmente excluir este item?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>



<!-- editar -->

<div id="modal-editaritemcot" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form  action="<?php echo base_url() ?>index.php/cotacao/montarcotacao_editar/1" method="post">
 
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar número da cotação</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCotacaoItens_edi5" name="idCotacaoItens_edi5" value="" />
Enviar item para a cotação de número:<input type="text" id="idPedidoCotacao_n2" name="idPedidoCotacao_n2" value="" />
    
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Salvar</button>
  </div>
  </form>
</div>
<!-- editar -->
<div id="modal-editaritemcotstatus" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form  action="<?php echo base_url() ?>index.php/almoxarifado/montarcotacao_editar_status" method="post">
 
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar número da cotação</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idCotacaoItens_edis" name="idCotacaoItens_edis" value="" />
Alterar Status para cancelado?<input type="hidden" id="idStatuscompras_n" name="idStatuscompras_n" value="6" />
    
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Alterar</button>
  </div>
  </form>
</div>		
<div id="modal-statuscompra" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Definições dos status</h5>
  </div>
  <div class="modal-body">
    <table border='1'>
<tr>
<td>Nome Status
</td>
<td>Definicão
</td>
</tr>
<?php foreach ($dados_statuscompra as $so) { ?>

<tr>
<td><?php echo $so->nomeStatus; ?>
</td>
<td><?php echo $so->descricao_status; ?>
</td>
</tr>
           


		   
                      
                        <?php } ?> 



						</table>
    
  </div>
  <div class="modal-footer">
    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Fechar</button>
    
  </div>
  
</div>	
<script type="text/javascript">
$(document).ready(function(){

$(document).on('click', 'a', function(event) {
        
        var id_disti1 = $(this).attr('id_disti1');
        $('#id_item_pc1').val(id_disti1);

    });

$(document).on('click', 'a', function(event) {
        
        var id_disti2 = $(this).attr('id_disti2');
        $('#id_item_pc2').val(id_disti2);

    });	

   $(document).on('click', 'a', function(event) {
        
        var idCotacaoItens__ = $(this).attr('idCotacaoItens__');
        $('#idCotacaoItens2').val(idCotacaoItens__);

    });
	
	$(document).on('click', 'a', function(event) {
        
        var idCotacaoItens3__ = $(this).attr('idCotacaoItens3__');
        $('#idCotacaoItens22').val(idCotacaoItens3__);

    });
	
	 $(document).on('click', 'a', function(event) {
        
        var idCotacaoItens__edista = $(this).attr('idCotacaoItens__edista');
        $('#idCotacaoItens_edis').val(idCotacaoItens__edista);

    });
	
	
	
	$(document).on('click', 'a', function(event) {
        
        var idCotacaoItens__edi = $(this).attr('idCotacaoItens__edi');
        $('#idCotacaoItens_edi5').val(idCotacaoItens__edi);

    });

});



</script>

<div id="modalinserir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Cadastrar Item Almoxarifado</h5>
  </div>
  
   <form action="<?php echo base_url(); ?>index.php/os/cad_distribuir" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   
 <div class="modal-body">	
	<div >
OS: <br><select class="recebe-solici" class='span12' name="idOs" id="idOs">
							 <option value="3" selected>OS 3 - UBERTEC</option>
							 <option value="2" >OS 2 - PETROL.</option>
							 <option value="1" >OS 1 - KRMB</option>
							 
							 </select>
	
	

</div>				
<div >
Descrição: <input id="dados2" type="text" name="dados2" value="" class='span12' />

<input id="almoxarifado" type="hidden" name="almoxarifado" value="1"  />
	<input id="idInsumos__2" type="hidden" name="idInsumos__2" value=""  />
</div>

 
<div >
Quantidade: <input id="quantidade" type="text" name="quantidade" value="" class='span12' />


   
</div>
                        
                        <div >
						Dimensões: <input id="dimensoes" type="text" name="dimensoes" value="" class='span12' />
						
                   
                           
                        </div>
						<div >PN<font size='1'>(digitar o PN especifico da peça que esta comprando o material acima)</font> 
						<input type="hidden" id="idProdutos" name="idProdutos" size="3"   value="0"/>
			<input type="text" id="pn" name="pn" size="97" ref="autocomplete" class="span12" value=""/>
						
						</div>
						<div >Especifique o Grupo
						<select class="recebe-solici" class="controls" style="font-size: 10px;" name="idgrupo" id="idgrupo">
							<option value="0">---</option> 
							<?php foreach ($dados_statusgrupo as $so) { ?>
                       
                        <option value="<?php echo $so->idgrupo; ?>"><?php echo $so->nomegrupo; ?></option>
                        <?php } ?>
                       
					    
                            </select></div>
                        <div >
						OBS <textarea id="obs" rows="5" cols="100" class="span12" name="obs"></textarea>
						
                   
                           
                        </div>
						 
						
                  
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Cadastrar</button>
  </div>
     </form>
  
 
 
</div>
</div>
<script type="text/javascript">

$(document).ready(function(){
	
	//console.log('#idInsumos2');
	$("#dados2").autocomplete({
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
		minLength: 1,
		select: function( event, ui ) {
			//alert($('#idInsumos').val(ui.item.id));
			 $('#idInsumos__2').val(ui.item.id);

		}
	});
	
	
	
	
	
	

  
     
   
});
 $(document).ready(function(){
	
	//console.log('#idInsumos2');
	$("#pn").autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutos').val(ui.item.id);
			
			 

		}
	});
	
	  
   
});
 
</script>
