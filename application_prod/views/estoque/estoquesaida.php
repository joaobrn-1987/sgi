<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aEstoque')){ ?>
    <a href="#modalCadastrar" data-toggle="modal" role="button" class="btn btn-success">Entrada Estoque</a>    
<?php } ?>

<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'sEstoque')){ ?>
    <a href="#modalsaida" data-toggle="modal" role="button" class="btn btn-warning tip-top">Saída Estoque em lote</a>    
<?php } ?>


<div id="modalCadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/estoque/cadastrarestoque" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">SGI - Cadastrar Item para Estoque</h3>
  </div>
  <div class="modal-body">
  <div class="control-group"><br>Empresa
						 <select class="form-control" name="idEmitente">
                        
                        <?php foreach ($dados_emitente as $e) { ?>
                        
                        <option value="<?php echo $e->id; ?>" <?php if($e->id == 1){ echo "selected='selected'";}?>><?php echo $e->nome; ?></option>
                        <?php } ?>
                        
                        </select></div>

						
<div class="control-group">
Descrição: <input id="term2" type="text" name="term2" value="" class='span12' />


	<input id="idInsumos2" type="hidden" name="idInsumos2" value=""  />
</div>
<div class="">
Quantidade em Estoque: 
<input id="estoque" type="text" name="estoque" value=""  readonly/><br>
<!--<font red='red' size='1'>*Se a qtd solicitada for maior que o estoque, será gerado 2 itens automaticamente, 1 para solicitar ao estoque outro para solicitar compra</font>-->

</div>
						
           
   

<div class="control-group">
                        <div class="span6">Quantidade:
                            <input id="quantidade" type="text" name="quantidade" value="" class="span6" />
                        </div>
						
                    </div>
<div class="control-group">
 <div class="span6"> Valor Unitario:
                            <input id="vlrunit" type="text" name="vlrunit" value="" class="span6" onKeyPress="FormataValor2(this,event,12,2);"/>
                        </div>					
                        </div>					

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-success">Cadastrar</button>
  </div>
  </form>
</div>



<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-truck"></i>
         </span>
        <h5>Estoque</h5>

     </div>



<div class="widget-content nopadding">
 <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                 
                              <form class="form-inline" action="<?php echo base_url() ?>index.php/estoque/estoquesaida" method="post" name="form1" id="form1">
               

 <div class="span12" style="padding: 1%; margin-left: 0">                                  
    <div class="control-group">
Descrição: <input id="term22a" type="text" name="term22a" value="" class='span12' />


	<input id="idInsumos22a" type="hidden" name="idInsumos22a" value=""  />
</div>                              
</div>                              

<div class="span12" style="padding: 1%; margin-left: 0"> 
  <div class="span5" class="control-group">
Código: <input id="codigo" type="text" name="codigo" value="" class='span12' />


</div> 

 <div class="span5" class="control-group"> 
                                            <label  class="control-label">Período:</label><br>
                       
         De: <input id="dataInicialcad" class="data" type="text" name="dataInicialcad" value=""/>   Até:<input id="dataFinalcad" class="data" type="text" name="dataFinalcad" value=""/>
                                        </div>
                                        </div>
										

					
<div class="span12" style="padding: 1%; margin-left: 0">
								   <div class="span12" class="control-group">
                                             
											
                                  <label for="idGrupoServico" class="control-label">Categoria:</label><!--&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll22();">&nbsp;Marcar/Desmarcar todos-->
								   <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#adm" aria-expanded="false" aria-controls="collapseExample">
    Mostrar/ocultar
  </button>
 <br>
  <div class="collapse" id="adm">
  <div class="card card-body">
 <table width='100%'><tr>
										  <?php 
										  $i = 0;
										  foreach ($categoria as $cat) 
										  
										  {


										
											  ?>
											  <td>
										<input type = "checkbox"  name = "cat[]"   class='check' value = "<?php echo $cat->	idCategoria; ?>" > &nbsp;<?php echo $cat->descricaoCategoria; ?>
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






<table class="table table-bordered ">
    <thead>
        <tr>
          
                             <!--<th>Categoria/Subcategoria</th>-->
                             <th>Categoria / <b>Descrição Insumo</b></th>
							 <th>Dimensao</th>
                        <th>Est. <br>mínimo</th>
                        <th>Código</th>
                        <th>Local</th>
                        <th>Qtd</th>
						<?php  if($this->permission->checkPermission($this->session->userdata('permissao'),'valorEstoque')){  ?>
                        <th>Vlr. <br>Unit</th>
						<?php
						}
						?>
                        <th>User Cad.</th>
                        <th>Data Cad.</th>
                      
                        <th>User Saida.</th>
                        <th>Data Saida.</th>
                        <th>Ação</th>
                                   
            <th></th>
        </tr>
    </thead>
    
        <?php 
		$valorto = 0;
		$qtdtotal = 0;
		foreach ($results as $r) {
			
			$usercad1 = $this->estoque_model->getuser($r->usercad);
			
			
			$usercad = $usercad1[0]->nome;
			
			if(!empty($r->usersaida))
			{
			$usersaida1 = $this->estoque_model->getuser($r->usersaida);
			$usersaida = $usersaida1[0]->nome;
			}
			else{
				$usersaida = '-';
			}
			
			/*$saida = $this->estoque_model->getestoquesaida($r->idInsumos);
			if(!empty($saida))
			{
			$estsaida = $saida[0]->qtdsaida;
			}
			else
			{
				$estsaida = 0;
			}*/
			 
			if(empty($r->id_estoque_saida) && $r->id_estoque_saida == 0)
			{
				$color = '#000000'; 
				
				
			}
			else
			{
				$color = '#8e8a8a';
				
			}
			
			//$atual =$r->qtd - $r->qtd_saida; 
			
			if(!empty($r->data_saida))
			{
				$saida = date("d/m/Y H:i:s", strtotime($r->data_saida));
			}
			else{
				$saida = '';
			}
            echo '<tr>';
            //echo '<td>'.$r->descricaoCategoria.' / '.$r->descricaoSubcategoria.'</td>';
           
           // echo '<td><font color='.$color.'>'.$r->idInsumos.'-'.$r->descricaoCategoria.' | <b>'.$r->descricaoInsumo.'</b></font></td>';
			 echo '<td><font color='.$color.'>'.$r->descricaoCategoria.' | <b>'.$r->descricaoInsumo.'</b></font></td>';
            echo '<td><font color='.$color.'>'.$r->dimensao.'</font></td>';
            echo '<td><font color='.$color.'>'.$r->estoqueminimo.'</font></td>';
			 echo '<td><font color='.$color.'>'.$r->pn_insumo.'</font></td>';
			   echo '<td><font color='.$color.'>'.$r->localizacao.'</font></td>';
            echo '<td><font color='.$color.'>'.$r->qtd.'</font></td>';
			 if($this->permission->checkPermission($this->session->userdata('permissao'),'valorEstoque')){ 
			 echo '<td><font color='.$color.'>'.number_format($r->vlr_unit, 2, ",", ".").'</font></td>';
			 }
            echo '<td><font color='.$color.'>'.$usercad.'</font></td>';
            echo '<td><font color='.$color.'>'.date("d/m/Y H:i:s", strtotime($r->data_entrada)).'</font></td>';
            echo '<td><font color='.$color.'>'.$usersaida.'</font></td>';
            echo '<td><font color='.$color.'>'.$saida.'</font></td>';
			echo '<td><font color='.$color.'>';
           if(empty($r->id_estoque_saida) && $r->id_estoque_saida == 0)
		   {
          if($this->permission->checkPermission($this->session->userdata('permissao'),'sEstoque')){ ?>
    <a href="#modalsaida2" data-toggle="modal" role="button" identrada="<?php echo $r->idestoque_entrada ;?>" class="btn btn-warning tip-top"><?php //echo $r->idestoque_entrada ;?>Saída Estoque</a>    
<?php } 
         
		   }
		   else
		   {
			   echo "-";
		   }
           echo "</font></td>";
          $valorto  = $valorto + $r->vlr_unit;
          $qtdtotal  = $qtdtotal + $r->qtd;
            echo '</tr>';
			
		}
            ?>
         

       
    
</table>
</div>

</div>
<!--<div align='right' class='span11'>
Total: <b><?php //echo number_format($valorto, 2, ",", ".");?></b>
</div>-->
<div align='right' class='span11'>
Quantidade Total: <b><?php echo $qtdtotal;?></b> Unid.
</div>

<?php echo $this->pagination->create_links();?>

<div id="modalsaida2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/estoque/saidaestoque" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">SGI - Saída Item para Estoque</h3>
  </div>
  <div class="modal-body">
  <input type="hidden" id="id_entra" name="id_entra" value="" />
  <div class="control-group"><br>Empresa
						 <select class="form-control" name="idEmitente2">
                        
                        <?php foreach ($dados_emitente as $e) { ?>
                        
                        <option value="<?php echo $e->id; ?>" <?php if($e->id == 1){ echo "selected='selected'";}?>><?php echo $e->nome; ?></option>
                        <?php } ?>
                        
                        </select></div>

						


						
           
   			
<div class="control-group">
 <div class="span6"> O.S.:  
                            <input id="id_os" type="text" name="id_os" value="" class="span6" />
                        </div>					
                        </div>
<div class="control-group">
 <div class="span6"> Setor:
  <select class="form-control" name="id_setor">
                        <option value="" ></option>
                        <?php foreach ($dados_setor as $e) { ?>
                        
                        <option value="<?php echo $e->id_setor; ?>" ><?php echo $e->nomesetor; ?></option>
                        <?php } ?>
                        
                        </select>
						
						
                           
                        </div>					
                        </div>



						
  </div>
  
  
  
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-success" id="saida3">Cadastrar</button>
  </div>
  </form>
</div>




<div id="modalsaida" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/estoque/saidaestoque" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">SGI - Saída Item para Estoque</h3>
  </div>
  <div class="modal-body">
  
  <div class="control-group"><br>Empresa
						 <select class="form-control" name="idEmitente2">
                        
                        <?php foreach ($dados_emitente as $e) { ?>
                        
                        <option value="<?php echo $e->id; ?>" <?php if($e->id == 1){ echo "selected='selected'";}?>><?php echo $e->nome; ?></option>
                        <?php } ?>
                        
                        </select></div>

						
<div class="control-group">
Descrição: <input id="term22" type="text" name="term22" value="" class='span12' />


	<input id="idInsumos22" type="hidden" name="idInsumos22" value=""  />
</div>
<div class="">
Quantidade em Estoque: 
<input id="estoque2" type="text" name="estoque2" value=""  readonly/><br>
<!--<font red='red' size='1'>*Se a qtd solicitada for maior que o estoque, será gerado 2 itens automaticamente, 1 para solicitar ao estoque outro para solicitar compra</font>-->

</div>
						
           
   

<div class="control-group">
                        <div class="span6">Quantidade:
              <input id="quantidade2" type="text" name="quantidade2" value="" class="span6" onblur="verifica();"/>
                        </div>
						
                    </div>
<!--<div class="control-group">
 <div class="span6"> Valor Unitario:
                            <input id="vlrunit2" type="text" name="vlrunit2" value="" class="span6" onKeyPress="FormataValor2(this,event,12,2);"/>
                        </div>					
                        </div>	-->				
<div class="control-group">
 <div class="span6"> O.S.:  
                            <input id="id_os" type="text" name="id_os" value="" class="span6" />
                        </div>					
                        </div>
<div class="control-group">
 <div class="span6"> Setor:
  <select class="form-control" name="id_setor">
                        <option value="" ></option>
                        <?php foreach ($dados_setor as $e) { ?>
                        
                        <option value="<?php echo $e->id_setor; ?>" ><?php echo $e->nomesetor; ?></option>
                        <?php } ?>
                        
                        </select>
						
						
                           
                        </div>					
                        </div>



						
  </div>
  
  
  
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-success" id="saida" disabled>Cadastrar</button>
  </div>
  </form>
</div>






<script type="text/javascript">
$(document).ready(function(){
	
jQuery(".data").mask("99/99/9999");
   });
   
   
function verifica()
{
	var qtd = $('#quantidade2').val(); 1
	var esto = $('#estoque2').val(); 1
	var restante;
	restante = esto - qtd;
	

if( restante >= 0 )
{
	
	document.getElementById("saida").disabled = false;
}
else
{
	
	document.getElementById("saida").disabled = true;
}	

}

$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var categoria = $(this).attr('categoria');
        $('#idcat').val(categoria);

    });

});

$(document).ready(function(){
	
	//console.log('#idInsumos2');
	$("#term2").autocomplete({
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idInsumos2').val(ui.item.id);
			 $('#estoque').val(ui.item.estoque);

		}
	});
   
});

$(document).ready(function(){
	
	//console.log('#idInsumos2');
	$("#term22").autocomplete({
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idInsumos22').val(ui.item.id);
			 $('#estoque2').val(ui.item.estoque);
		

				}
	});
   
});

$(document).ready(function(){
	
	//console.log('#idInsumos2');
	$("#term22a").autocomplete({
		source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idInsumos22a').val(ui.item.id);
			
		

				}
	});
   
});


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

<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var identrada = $(this).attr('identrada');
        $('#id_entra').val(identrada);

    });

});

</script>

