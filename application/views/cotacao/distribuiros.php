<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<?php

  //echo $date = date('Y-m-d H:i:s');

$data=date("d-m-y");

 $hora = date("H:i:s");?>


			
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Distribuir OS</h5>
				
            </div>
            <div class="widget-content nopadding">


                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da OS</a></li>
                        <!--<li id="tabProdutos"><a href="#tab2" data-toggle="tab">Anexo NF</a></li>
                        <li id="tabServicos"><a href="#tab3" data-toggle="tab">Insumos</a></li>
                        <li id="tabAnexos"><a href="#tab4" data-toggle="tab">Anexos</a></li>-->
                    </ul>
                    <div class="tab-content">
                        
								
			
			
<div class="tab-pane active" id="tab1">			
		
<div class="span12 well" style="padding: 1%; margin-left: 0">		
<div class="span2"  class="control-group">
<label for="item" class="control-label">Cod. OS: <?php echo $result->idOs; ?></label>
</div>
<div class="span3"  class="control-group">
<label for="item" class="control-label">Cliente: <?php echo $orcamento->nomeCliente; ?></label>
</div>	
<div class="span3"  class="control-group">
<label for="item" class="control-label">Orçamento: <?php echo $result->idOrcamentos; ?></label>
</div>
<div class="span3"  class="control-group">
<label for="item" class="control-label">Data O.S.: 
<?php echo date("d/m/Y", strtotime($result->data_abertura_editada));  ?>


</div>
				
</div>			
			 
<div class="span12 well" style="padding: 1%; margin-left: 0">	
<div class="span1"  class="control-group">
	<label for="item" class="control-label">Qtd.:</label>
	<?php echo $result->qtd_os; ?>

</div>
<div class="span4"  class="control-group">
	<label for="item" class="control-label">Descrição:</label>
	<input id="descricao_os" class="span12" type="text" onclick="this.select();" name="descricao_os" value="<?php echo $itens_orcamento->descricao_item; ?>" />
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">PN:</label>
	 <?php echo $itens_orcamento->pn;?>
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Data Entrega:</label>
	
	<input id="data_entrega" class="span12 data" type="text" name="data_entrega" value="<?php echo date("d/m/Y", strtotime($result->data_entrega));  ?>" onclick="this.select();"/>
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Data Reprog.:</label>
	<input id="data_reagendada" class="span12 data" onclick="this.select();" type="text" name="data_reagendada" value="<?php if($result->data_reagendada <> '') { echo date("d/m/Y", strtotime($result->data_reagendada)); } ?>" />
</div>

</div>



 
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Cadastrar Material</h5>
<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eDistribuirOs')){ ?>
<a href="#modalinserir" data-toggle="modal" role="button" class="btn btn-success" title="Inserir"><i class="icon-plus icon-white"></i> Cadastrar Materiais OS</a>
<br>
<br>
       
<?php } ?>
     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
        
                        <th>ID</th>
                       
                        <th>Qtd.</th>
                        <th>Material</th>
                       <th>Dimensões</th>
                        <th>OBS</th>
                        <th>Data Cadastro</th>
                        <th>Data Alteração</th>
                        <th>Status</th>
                       
                        <th></th>
                        <th></th>
        </tr>
    </thead>
    <tbody>



<?
 foreach ($distribuir_os as $dist) {
	 
	 if($dist->data_alteracao <> '')
			{
				$data_alteracao = date("d/m/Y H:i:s", strtotime($dist->data_alteracao));
			
			}
			else
			{
				$data_alteracao = "";
			}
			
	 ?>
	 <tr>
	 <td>
	 <?php echo $dist->idDistribuir;?>
	 </td>
	
	 <td>
	 <?php echo $dist->quantidade;?>
	 </td>
	  <td>
	 <?php echo $dist->descricaoInsumo;?>
	 </td>
	  <td>
	 <?php echo $dist->dimensoes;?>
	 </td>
	  <td>
	 <?php echo $dist->obs;?>
	 </td>
	  <td>
	  <?php echo date("d/m/Y H:i:s", strtotime($dist->data_cadastro));  ?>
	 
	 </td>
	  <td>
	 <?php echo $data_alteracao;?>
	 </td>
	 <td>
	 <?php echo $dist->nomeStatus;?>
	 </td>

					
					
	
	<?
 if($this->permission->checkPermission($this->session->userdata('permissao'),'eDistribuirOs')){
	 if($dist->idStatuscompras == 1)
	 {	 
?>
<td>
<a href="#modalAlterarpedido<?php echo $dist->idDistribuir; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar Material"><i class="icon-pencil icon-white"></i></a>
	 
 </td>
<td> 
                   
                         <a href="#modal-excluirmaterial<?php echo $dist->idDistribuir; ?>" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuir="<?php echo $dist->idDistribuir; ?>" class="btn btn-danger tip-top" title="Excluir material"><i class="icon-remove icon-white"></i></a>
						 </td>
		<?
 }
?> 
						 
						 
						 </tr>
                    <?
					}
					

?>	
	<div id="modalAlterarpedido<?php echo $dist->idDistribuir; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar Material:<?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/editar_distribuiros" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

   <div class="control-group">
    <label for="obs_controle" class="control-label">Descrição</label>
                        <div class="controls">
						 <input id="term<?php echo $dist->idDistribuir; ?>" type="text" name="term<?php echo $dist->idDistribuir; ?>" value="<?php echo $dist->descricaoInsumo; ?>"  />
						
                   
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                            <input id="idInsumos" type="hidden" name="idInsumos" value="<?php echo $dist->idInsumos; ?>"  />
                        </div>
						 <label for="obs_controle" class="control-label">Quantidade</label>
                        <div class="controls">
						 <input id="quantidade" type="text" name="quantidade" value="<?php echo $dist->quantidade; ?>"  />
						 </div>
                        <label for="obs_controle" class="control-label">Dimensões</label>
                        <div class="controls">
						 <input id="dimensoes" type="text" name="dimensoes" value="<?php echo $dist->dimensoes; ?>"  />
						
     <input id="idDistribuir" type="hidden" name="idDistribuir" value="<?php echo $dist->idDistribuir; ?>"  />
                           
                        </div>
						<label for="obs_controle" class="control-label">OBS</label>
                        <div class="controls">
						 <textarea id="obs" rows="5" cols="100" class="span12" name="obs"><?php echo $dist->obs; ?></textarea>
						
                   
				   	
    
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
	$("#term"+<?php echo $dist->idDistribuir; ?>).autocomplete({
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idInsumos').val(ui.item.id);

		}
	});
	
	
	
	
	
	

  
     
   
});
 
</script>




<div id="modal-excluirmaterial<?php echo $dist->idDistribuir; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/os/excluir_item" method="post" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Material OS</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idDistribuir" name="idDistribuir" value="<?php echo $dist->idDistribuir; ?>" />
    <input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
    
    <h5 style="text-align: center">Deseja realmente excluir este item?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>				
					<?

					
 }
					?>


</tbody>
</table>
</div>
</div>








</div><!-- div principal ao entrar -->



		
            <!--<div class="widget-content" id="printOs">
                <div class="invoice-content">
                  ddd
              
                </div>
            </div>-->
              </div>

                </div>


.

        </div>

    </div>
</div>
</div>





<!-- cadastgrar nf -->
<div id="modalinserir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Cadastrar Item OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/cad_distribuir" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

   <div class="control-group">
   
					 <label for="obs_controle" class="control-label">Descrição</label>
                        <div class="controls">
						 <input id="term" type="text" name="term" value=""  />
						
                   
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                            <input id="idInsumos2" type="hidden" name="idInsumos2" value=""  />
                        </div>
						 <label for="obs_controle" class="control-label">Quantidade</label>
                        <div class="controls">
						 <input id="quantidade" type="text" name="quantidade" value=""  />
						
                   
                           
                        </div>
                        <label for="obs_controle" class="control-label">Dimensões</label>
                        <div class="controls">
						 <input id="dimensoes" type="text" name="dimensoes" value=""  />
						
                   
                           
                        </div>
						<label for="obs_controle" class="control-label">OBS</label>
                        <div class="controls">
						 <textarea id="obs" rows="5" cols="100" class="span12" name="obs"></textarea>
						
                   
                           
                        </div>
						 
						
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
	
jQuery(".data").mask("99/99/9999");
   });
   

$(function() {
   $(document).on('click', 'input[type=text][id=example1]', function() {
     this.select();
   });
 });

$(document).ready(function(){
	
	//console.log('#idInsumos2');
	$("#term").autocomplete({
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idInsumos2').val(ui.item.id);

		}
	});
	
	
	
	
	
	

  
     
   
});
 
</script>