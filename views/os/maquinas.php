<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<?php

  //echo $date = date('Y-m-d H:i:s');

$data=date("d/m/Y");

 $hora = date("H:i:s");?>


			
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Maquinas usuarios OS</h5>
				
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
<?php echo date("d/m/Y", strtotime($result->data_abertura));  ?>


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
        <h5>Cadastrar HR/Máquinas OS</h5>
<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eHoramaquinas')){ ?>
<a href="#modalinserir" data-toggle="modal" role="button" class="btn btn-success" title="Inserir"><i class="icon-plus icon-white"></i> Cadastrar</a>
<br>
<br>
       
<?php } ?>
     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
        
                       
                       
                        <th>Máquina</th>
                        <th>Usuário</th>
                       <th>OBS</th>
                        
                        <th>Data/Hr Inicio</th>
                        <th>Data/Hr final</th>
                        <th>Tempo execução</th>
                        
                       
                        <th></th>
                        <th></th>
        </tr>
    </thead>
    <tbody>



<?
 foreach ($hrmaquina_os as $dist) {
	 
	 if($dist->horainicio <> '')
			{
				$horainicio = date("d/m/Y H:i:s", strtotime($dist->horainicio));
				$datahorainicio = date("d/m/Y", strtotime($dist->horainicio));
				$tempohrinicio = date("H:i:s", strtotime($dist->horainicio));
			}
			else
			{
				$horainicio = "";
				$tempohrinicio = "";
			}
			
			 if($dist->horafim <> '')
			{
				$horafim = date("d/m/Y H:i:s", strtotime($dist->horafim));
				$tempohrfim = date("H:i:s", strtotime($dist->horafim));
			}
			else
			{
				$horafim = "";
				$tempohrfim = "";
			}
			


		
	 ?>
	 <tr>
	 
	
	 <td>
	 <?php echo $dist->nome;?>
	 </td>
	  <td>
	 <?php echo $dist->nome_UserMaquinas;?>
	 </td>
	 
	  <td>
	 <?php echo $dist->obs;?>
	 </td>
	  
	  <td>
	 <?php echo $horainicio;?>
	 </td>
	
		 <td>
	 <?php echo $horafim;?>
	 </td>			
		<td>
<?	



if(!empty($horafim))
{
	echo $this->os_model->calculadif($tempohrinicio, $tempohrfim );
}
else
{
	echo "-";
}
 ?>
	 </td>
	<?
 if($this->permission->checkPermission($this->session->userdata('permissao'),'eHoramaquinas')){
	 	 
?>
<td>
<a href="#modalAlterarpedido<?php echo $dist->idHoramaquinas; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar Hr/Máquinas"><i class="icon-pencil icon-white"></i></a>
	 
 <?
 
 if(empty($horafim))

 {
 ?>
 
                   
                         <a href="#modal-excluirmaterial" style="margin-right: 1%" role="button" data-toggle="modal" idHoramaquinas_="<?php echo $dist->idHoramaquinas; ?>" class="btn btn-danger tip-top" title="Excluir material"><i class="icon-remove icon-white"></i></a>
						 
						 <?
 }
 ?>
						 </td>
					 
						 
						 </tr>
                    <?
					}
					

?>	
<!-- alterar -->
<div id="modalAlterarpedido<?php echo $dist->idHoramaquinas; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar Hr/Máquinas: OS = <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/editar_hrmaquinas" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
    					
 <div >
Inicio Data: <input id="horainiciod" class='data' type="text" name="horainiciod" value="<?php echo $datahorainicio;?>" class='span12' />

Hora:<input id="horainicioh" type="text" class='hora' name="horainicioh" value="<?php echo $tempohrinicio;?>"  />
	
</div> 
 

 <div >
 <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
 <input id="idHoramaquinas" type="hidden" name="idHoramaquinas" value="<?php echo $dist->idHoramaquinas; ?>"  />
Finalização Data: <input id="datafinal" class='data' type="text" name="datafinal" value="<?php echo $data;?>" class='span12' />

Hora:<input id="horafinal" type="text" class='hora' name="horafinal" value="<?php echo $hora;?>"  />
	
</div> 
                      
                       
						
                        <div >
						OBS <textarea id="obs" rows="5" cols="100" class="span12" name="obs"></textarea>
						
                   
                           
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
			//alert($('#idInsumos').val(ui.item.id));
			 $('#idInsumos'+<?php echo $dist->idDistribuir; ?>).val(ui.item.id);

		}
	});
	
	
	
	
	
	

  
     
   
});
 
</script>




				
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




        </div>

    </div>
</div>
</div>



<!-- cadastgrar nf -->


<div id="modalinserir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Cadastrar Hr/Máquinas: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/cad_horamaquina" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   
   
					
<div >
Máquina <input id="term2" type="text" name="term2" value="" class='span12' />


	<input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
	<input id="idMaquinas2" type="hidden" name="idMaquinas2" value=""  />
</div>
 
 <div >
Usuario Máquina <input id="term3" type="text" name="term3" value="" class='span12' />


	
	<input id="idUserMaquinas2" type="hidden" name="idUserMaquinas2" value=""  />
</div>

 <div >
Inicio Data: <input id="horainiciod" class='data' type="text" name="horainiciod" value="<?php echo $data;?>" class='span12' />
<!--<input id="horainicioh" type="time" name="horainicioh" value="<?php echo $hora;?>"  />-->
Hora:<input id="horainicioh" type="text" class='hora' name="horainicioh" value="<?php echo $hora;?>"  />
	
</div> 
                      
                       
						
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

<div id="modal-excluirmaterial" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/os/excluir_hmaquina" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir H/Maquina OS</h5>
  </div>
  <div class="modal-body">
    
    <input type="hidden" id="horamaquina2" name="horamaquina2" value="" />
    <input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
    
    
    <h5 style="text-align: center">Deseja realmente excluir este item?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>


<script type="text/javascript">
$(document).ready(function(){
	
jQuery(".data").mask("99/99/9999");





   });
   
$(document).ready(function(){
	
jQuery(".hora").mask("99:99:99");
   });
   

$(document).ready(function(){
	
 $(document).on('click', 'a', function(event) {
      
        var idHoramaquinas_ = $(this).attr('idHoramaquinas_');
        $('#horamaquina2').val(idHoramaquinas_);

    });
});	
	
$(document).ready(function(){
	
	//console.log();
	$("#term2").autocomplete({
		
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteMaquina",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idMaquinas2').val(ui.item.id);

		}
	});
	
	//console.log('#idInsumos2');
	$("#term3").autocomplete({
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteMaquinauser",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idUserMaquinas2').val(ui.item.id);

		}
	});
	
  
   
});
 
</script>