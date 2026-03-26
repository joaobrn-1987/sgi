<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>

 
 
 
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
         </span>
        <h5>Editar dados do item OS: <?php echo $r[0]->idOs; ?></h5>

<?php //if($this->permission->checkPermission($this->session->userdata('permissao'),'eDistribuirOs')){ ?>

     </div>

<div class="widget-content nopadding">

 <form class="form-inline" action="<?php echo base_url() ?>index.php/almoxarifado/editar_distribuiros" method="post">
<table class="table table-bordered ">
 
 
  
   <div class="controls">
						Descrição <input id="term" type="text" name="term" value="<?php echo $r[0]->descricaoInsumo; ?>" class='span12' />
						
                   
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $r[0]->idOs; ?>"  />
                            <input id="idInsumos" type="hidden" name="idInsumos" value="<?php echo $r[0]->idInsumos; ?>" class='span12' />
                        </div>
						
                        <div class="controls">
						 Quantidade<input id="quantidade" type="text" name="quantidade" value="<?php echo $r[0]->quantidade; ?>"  class='span12'/>
						 </div>
                       
                        <div class="controls">
						 Dimensões<input id="dimensoes" type="text" name="dimensoes" value="<?php echo $r[0]->dimensoes; ?>"  class='span12'/>
						
     <input id="idDistribuir" type="hidden" name="idDistribuir" value="<?php echo $r[0]->idDistribuir; ?>"  />
                           
                        </div>
						<div class="controls"><br>PN<font size='1'>(digitar o PN especifico da peça que esta comprando o material acima)</font> 
<input type="hidden" id="idProdutosa2" name="idProdutosa2" size="3"   value="<?php echo $r[0]->idProdutos; ?>"/>
<input type="text" id="pna2" name="pna2<?php echo $r[0]->idDistribuir; ?>" size="97" ref="autocomplete" class="span12" value="<?php echo $r[0]->pn; ?> | Descrição: <?php echo $r[0]->descricao; ?>"/> 
						
						</div>
						<div class="controls"><br>Especifique o Grupo
						<select class="recebe-solici" class="controls" style="font-size: 10px;" name="idgrupo" id="idgrupo">
							<option value="0">---</option>
							<?php foreach ($dados_statusgrupo as $so) { ?>
                       
                        <option value="<?php echo $so->idgrupo; ?>" <?php if($so->idgrupo == $r[0]->id_status_grupo){ echo "selected='selected'";}?>><?php echo $so->nomegrupo; ?></option>
                        <?php } ?>
                       
					    
                            </select></div>
						
                        <div class="controls">
						OBS<textarea id="obs" rows="5" cols="100" class="span12" name="obs"><?php echo $r[0]->obs; ?></textarea>
						
                   
				   	
    
                        </div>
      
	

<script type="text/javascript">

$(document).ready(function(){
	
	//console.log('#idInsumos2');
	$("#term").autocomplete({
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
		minLength: 1,
		select: function( event, ui ) {
			//alert($('#idInsumos').val(ui.item.id));
			 $('#idInsumos').val(ui.item.id);

		}
	});
	
	
	
		$("#pna2").autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutosa2').val(ui.item.id);

		}
	});
	
	

  
     
   
});
 
</script>
	
			
		
 <div class="form-actions" align='center'>
                        
           <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Editar</button>
                               
                           
                    </div>  
</form>
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

$(document).ready(function(){
	
	//console.log('#idInsumos2');
	$("#term2").autocomplete({
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idInsumos2').val(ui.item.id);

		}
	});
	
	
	
	
	
	

  
     
   
});

</script>


