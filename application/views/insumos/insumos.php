<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>

<!--
<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aInsumo')){ ?>
    <a href="#modalCadastrar" data-toggle="modal" role="button" class="btn btn-success">Cadastrar Insumo</a>    
<?php } ?>
<div id="modalCadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/insumos/cadastrarInsumo" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">SGI - Cadastrar Insumos</h3>
        </div>
        <div class="modal-body">
            
            <div class="control-group">
                            
                <div class="span12 controls" >
                    Categoria e Subcategoria<br>
                    <select class="span12 form-control" name="idSubcategoria" >
                        <option selected="selected" disabled="disabled" value="">Escolher</option>
                        <?php foreach ($dsubcat as $pd) { 
                            
                        ?>
                        <option value="<?php echo $pd->idSubcategoria; ?>"><?php echo 'Cat.: '.$pd->descricaoCategoria.' | Subcat.:'.$pd->descricaoSubcategoria; ?></option>
                        <?php } ?>
                    </select>
                        <?php ?>
                </div>
            </div>    
                        
            <div class="control-group">
                <div class="span12 controls">Insumo<br>
                    <input id="descricaoInsumo" type="text" name="descricaoInsumo" value=""  class="span12"/>
                </div>
                            
            </div>
                    
            <div class="control-group">
                <div class="span12 controls">Estoque minimo<br>
                    <input id="estoqueminimo" type="text" name="estoqueminimo" value="0" class="span12" />
                </div>
                            
            </div>

            <div class="control-group">
                <div class="span12 controls">Pn Insumo<br>
                    <input id="pn_insumo" type="text" name="pn_insumo" value="" class="span12" />
                </div>
                            
            </div>

            <div class="control-group">
                        
                <div class="span12 controls"> Localização no Estoque<br>
                    <input id="localizacao" type="text" name="localizacao" value="" class="span12" />
                </div>
                            
            </div>					

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <button class="btn btn-success">Cadastrar</button>
        </div>
    </form>
</div>-->
<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aInsumo')){ ?>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Cadastro Insumos</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <div class="span12" id="divCadastrarOs">
                  <form class="form-inline"  >
                    <div class="span12" style="padding: 1%; margin-left: 0">
                        <div class="span2" class="control-group">
                            <label for="cliente" class="control-label">Categoria:</label>
                            <input class="span12" class="form-control" id="categoriaEntrada"  type="text" name="categoriaEntrada" value=""  />
                            <input id="idCategoriaEntrada"  type="hidden" name="idCategoriaEntrada" value=""  />
                        </div>
                        <div class="span2" class="control-group">
                            <label for="cliente" class="control-label">Subcategoria:</label>
                            <input class="span12" class="form-control" id="subcategoriaEntrada"  type="text" name="subcategoriaEntrada" value=""  />
                            <input id="idSubcategoria"  type="hidden" name="idSubcategoria" value=""  />
                        </div>
                        <div class="span3" class="control-group">
                            <label for="cliente" class="control-label">Descrição Insumo:</label>
                            <input class="span12" class="form-control" id="descricaoInsumo"  type="text" name="prod" value=""  />
                        </div>
                        <div class="span2" class="control-group" >
                            <label for="cliente" class="control-label">PN:</label>
                            <input class="span12" class="form-control" id="pn_insumo2"  type="text" name="pn_insumo2" value=""  />
                        </div>
                        <div class="span2" class="control-group">
                            <label for="cliente" class="control-label"></label>
                            <a class="btn btn-success" class="form-control" style="justify-content: flex-end; display: table;" onclick="verificarInsumoCategoriaSubcategoria()">Cadastrar</a>
                        </div>
                    </div>
                        <!--
                        <div class="span1" class="control-group">
                            <label for="cliente" class="control-label">Estoque Min.:</label>
                            <input class="span12" class="form-control" id="estoqueminimo"  type="text" name="estoqueminimo" value="0"  />
                        </div>
                        
                        <div class="span2" class="control-group" style="margin-left: 35px">
                            <label for="cliente" class="control-label">Localização:</label>
                            <input class="span12" class="form-control" id="localizacao"  type="text" name="localizacao" value=""  />
                        </div>
-->
                      
                   <!--
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      
                    </div>-->
                  </form>    
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
  <?php } ?><!--
<?php
//if(!$dados){?>

<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>SubCategoria</h5>

    </div>

    <div class="widget-content nopadding">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>SubCategoria</th>
                    <th>Insumo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5">Nenhuma SubCategoria Cadastrada</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php //} else {
//echo "<br>";
//echo "<br>";	

?>-->
<br>
<br>
<div>
    <form class="form-inline" action="<?php echo base_url() ?>index.php/insumos/insumos" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <select class="form-control" name="field">
            <option  disabled="disabled" value="">Filtrar por</option>
            <option value="descricaoCategoria">Categoria</option>
            <option value="descricaoSubcategoria">Subcategoria</option>
            <option selected="selected" value="descricaoInsumo">Insumo</option>
            
            
        </select>
        <input class="form-control" type="text" name="search" value="" placeholder="Search...">
        <input class="btn btn-default" type="submit" name="filter" value="Filtrar">
    </form>


</div>
<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>Insumos</h5>

    </div>

    <div class="widget-content nopadding">


        <table class="table table-bordered " id="tableInsumo">
            <thead>
                <tr>
           
            
                <th>COD. insumo</th>
                <th>Categoria/subcategoria</th>
                
                <th>Insumo</th><!--             
                <th>Estoq. Min.</th>    -->         
                <th>Pn Insumo</th> <!--            
                <th>Localização</th>  -->           
                <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados as $r) {
                echo '<tr>';
                    echo '<td>'.$r->idInsumos.'</td>';
                    echo '<td>'.$r->descricaoCategoria.' / '.$r->descricaoSubcategoria.'</td>';
                
                    echo '<td>'.$r->descricaoInsumo.'</td>';
                   // echo '<td>'.$r->estoqueminimo.'</td>';
                    echo '<td>'.$r->pn_insumo.'</td>';
                   // echo '<td>'.$r->localizacao.'</td>';
                
                    echo '<td>';
                    /* if($this->permission->checkPermission($this->session->userdata('permissao'),'vCategoria')){
                        echo '<a href="'.base_url().'index.php/clientes/visualizar/'.$r->idSubcategoria.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
                    }*/
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eInsumo')){
                        ?>

                        <a href="#modalAlterar<?php echo $r->idInsumos; ?>" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a>
                    <?php
                    // echo '<a href="'.base_url().'index.php/insumos/editar/'.$r->idSubcategoria.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Cliente"><i class="icon-pencil icon-white"></i></a>'; 
                    }
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'dInsumo')){
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" categoria ="'.$r->idInsumos.'" style="margin-right: 1%" class="btn btn-danger tip-top" "><i class="icon-remove icon-white"></i></a>'; 
                        
                    }

                    
                    echo '</td>';
                echo '</tr>';
                ?>
                <!-- modal alterar -->
                <div id="modalAlterar<?php echo $r->idInsumos; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <form action="<?php echo base_url(); ?>index.php/insumos/editarinsumos" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="">SGI - Editar Dados Categoria</h3>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <div >Categoria e Subcategoria<br>
                                    <select name="idSubcategoria"  class="span12">
                                    
                                        <?php foreach ($dsubcat as $pd) { 
                                            ?>
                                        <option value="<?php echo $pd->idSubcategoria; ?>" <?php if($pd->idSubcategoria == $r->idSubcategoria) { echo 'selected="selected"'; }  ?>><?php echo 'Cat.: '.$pd->descricaoCategoria.' | Subcat.:'.$pd->descricaoSubcategoria; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                    
                            </div>
                                
                            <div class="modal-body">
                                        
                                <div >Insumo<br>
                                    <input id="descricaoInsumo" type="text" name="descricaoInsumo" value="<?php echo $r->descricaoInsumo; ?>" class='span12' />
                                    <input id="idInsumos" type="hidden" name="idInsumos" value="<?php echo $r->idInsumos; ?>"  />
                                </div>
                            </div>
                                
                            <div class="modal-body">
                                <div class="span12 controls">Estoque minimo<br>
                                    <input id="estoqueminimo" type="text" name="estoqueminimo" value="<?php echo $r->estoqueminimo; ?>" class="span12" />
                                </div>
                                        
                            </div>

                            <div class="modal-body">
                                <div >Pn Insumo<br>
                                    <input id="pn_insumo" type="text" name="pn_insumo" value="<?php echo $r->pn_insumo; ?>" class="span12" />
                                </div>
                                                    
                            </div>

                            <div class="modal-body">
                                    
                                <div > Localização no Estoque<br>
                                    <input id="localizacao" type="text" name="localizacao" value="<?php echo $r->localizacao; ?>" class="span12" />
                                </div>
                                        
                            </div>	

                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
                            <button class="btn btn-primary">Alterar</button>
                        </div>
                    </form>
                </div>          
                <?php
                }?>
                <tr>
            
                </tr>
            </tbody>
        </table>
    </div>
</div><!--
<?php // echo $this->pagination->create_links();}?>-->



 <!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/insumos/excluirinsumo" method="post" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Insumo</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idcat" name="idcat" value="" />
            <h5 style="text-align: center">Deseja realmente excluir este insumo?</h5>
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
        
        var categoria = $(this).attr('categoria');
        $('#idcat').val(categoria);

    });

});

</script>


<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
    var categoriaEntrada = document.getElementById('categoriaEntrada');

categoriaEntrada.onkeydown = function() {
    var key = event.keyCode || event.charCode;

    if( key == 8 || key == 46 ){      
      categoriaEntrada.querySelector("#idCategoriaEntrada").value = "";
      document.querySelector("#idSubcategoria").value = "";
      document.querySelector("#subcategoriaEntrada").value = "";
    }
};
categoriaEntrada.onkeyup = function() { 
    var key = event.keyCode || event.charCode;    
    if(key != 9){
        document.querySelector("#idCategoriaEntrada").value = "";
        document.querySelector("#idSubcategoria").value = "";
        document.querySelector("#subcategoriaEntrada").value = "";
    }
    
};

var subcategoriaEntrada = document.getElementById('subcategoriaEntrada');

subcategoriaEntrada.onkeydown = function() {
    var key = event.keyCode || event.charCode;

    if( key == 8 || key == 46 ){      
      document.querySelector("#idSubcategoria").value = "";
    }
};
subcategoriaEntrada.onkeyup = function() {  
    var key = event.keyCode || event.charCode; 
    if(key != 9){
        document.querySelector("#idSubcategoria").value = "";
    }   
    
};

function insertInFirstRow(e){
    var table = document.getElementById("tableInsumo");
    // Insere uma linha no fim da tabela.
    var newRow = table.insertRow(1);

    newCell = newRow.insertCell(0);   
    newCell.innerHTML = e[0].descricaoCategoria+' / '+e[0].descricaoSubcategoria;
    newCell = newRow.insertCell(1);   
    newCell.innerHTML = e[0].descricaoInsumo;
    newCell = newRow.insertCell(2); 
    newCell.innerHTML = e[0].pn_insumo;  
    newCell = newRow.insertCell(3);   
    
    <?php
    if($this->permission->checkPermission($this->session->userdata('permissao'),'eInsumo')){
        ?>
         //newCell.innerHTML = '<a href="#modalAlterar'+e[0].idInsumos+'" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a>';
        <?php
    }?>
    <?php
    if($this->permission->checkPermission($this->session->userdata('permissao'),'dInsumo')){
        ?>
         newCell.innerHTML = newCell.innerHTML +'<a href="#modal-excluir" role="button" data-toggle="modal" categoria ="'+e[0].idInsumos+'" style="margin-right: 1%" class="btn btn-danger tip-top" "><i class="icon-remove icon-white"></i></a>'; 
        <?php
    }?>
    
}

function verificarInsumoCategoriaSubcategoria(){
    var descricaoInsumo = document.querySelector('#descricaoInsumo').value;
    var idSubcategoria = document.querySelector('#idSubcategoria').value;
    var subcategoriaEntrada = document.querySelector('#subcategoriaEntrada').value;
    var categoriaEntrada = document.querySelector('#categoriaEntrada').value;
    var idCategoriaEntrada = document.querySelector('#idCategoriaEntrada').value;
    //var estoqueminimo = document.querySelector('#estoqueminimo').value;
    var pn_insumo = document.querySelector('#pn_insumo2').value;
    //var localizacao = document.querySelector('#localizacao').value;
    if(typeof descricaoInsumo != "UNDEFINED" && descricaoInsumo != null && descricaoInsumo != "" && 
    typeof categoriaEntrada != "UNDEFINED" && categoriaEntrada != null && categoriaEntrada != "" && 
    typeof subcategoriaEntrada != "UNDEFINED" && subcategoriaEntrada != null && subcategoriaEntrada != "" /*&&
    typeof estoqueminimo != "UNDEFINED" && estoqueminimo != null && estoqueminimo != ""*/){
        console.log(pn_insumo);
        if(idCategoriaEntrada == ""){            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/insumos/cadastrarCatESubcat2",
                type: 'POST',
                dataType: 'json',
                data: {
                    nomeCategoria: categoriaEntrada,
                    subCategoria: subcategoriaEntrada
                },
                success: function(data) {
                    idCatEntrada = data.idCategoria;
                    idSubcatEntrada = data.idSubcategoria;
                    document.querySelector('#idSubcategoria').value = data.idSubcategoria;
                    document.querySelector('#idCategoriaEntrada').value = data.idCategoria;
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/insumos/cadastrarInsumos2",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            descricao: descricaoInsumo,
                            estoquemin: 1,
                            subcat: idSubcatEntrada,
                            pn: pn_insumo
                        },
                        success: function(dataI) {
                            if(dataI.result == true){
                                pn = dataI.idInsumo;
                                if(dataI.msg == true){
                                    alert(dataI.msggg);
                                }else{
                                    insertInFirstRow(dataI.insumo);
                                    alert("Insumo cadastrado com sucesso");
                                }
                                document.querySelector('#descricaoInsumo').value= "";
                            }else{
                                alert(dataI.msggg);
                            }
                        },
                        error: function(xhr, textStatus, error) {
                            console.log("4");
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        },
                    });
                    console.log("Z");
                },
                error: function(xhr, textStatus, error) {
                    console.log("3");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },
            });
        }else if(idSubcategoria == ""){
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/insumos/cadastrarSubcat2",
                type: 'POST',
                dataType: 'json',
                data: {
                    nomeCategoria: categoriaEntrada,
                    subCategoria: subcategoriaEntrada,
                    idCategoria: idCategoriaEntrada
                },
                success: function(dataS) {
                    idCatEntrada = dataS.idCategoria;
                    idSubcatEntrada = dataS.idSubcategoria;
                    document.querySelector('#idSubcategoria').value = dataS.idSubcategoria;
                    console.log("X");   
                    $.ajax({
                    url: "<?php echo base_url(); ?>index.php/insumos/cadastrarInsumos2",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        descricao: descricaoInsumo,
                        estoquemin: 1,
                        subcat: idSubcatEntrada,
                        pn: pn_insumo
                    },
                    success: function(dataI) {
                        if(dataI.result == true){
                            pn = dataI.idInsumo;
                            if(dataI.msg == true){
                                alert(dataI.msggg);
                            }else{
                                insertInFirstRow(dataI.insumo);
                                alert("Insumo cadastrado com sucesso");
                            }
                            document.querySelector('#descricaoInsumo').value= "";
                        }else{
                        alert(dataI.msggg);
                        }
                    
                        
                    },
                    error: function(xhr, textStatus, error) {
                        console.log("2");
                        console.log(xhr.responseText);
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(error);
                    },
                                    
                    });
                },
                error: function(xhr, textStatus, error) {
                    console.log("1");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },         
            });
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/insumos/cadastrarInsumos2",
                type: 'POST',
                dataType: 'json',
                data: {
                    descricao: descricaoInsumo,
                    estoquemin: 1,
                    subcat: idSubcategoria,
                    pn: pn_insumo
                },
                success: function(dataI) {
                    if(dataI.result == true){
                        pn = dataI.idInsumo;
                        if(dataI.msg == true){
                            alert(dataI.msggg);
                        }else{
                            insertInFirstRow(dataI.insumo);
                            alert("Insumo cadastrado com sucesso");
                        }
                        document.querySelector('#descricaoInsumo').value= "";
                    }else{
                        alert(dataI.msggg);
                    }
                
                    
                },
                error: function(xhr, textStatus, error) {
                    console.log("2");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },
                                
            });
        }
    }
}
    
$(document).ready(function(){

  


    $("#formCadastrar").validate({
      rules:{
        idSubcategoria: {required:true},
        descricaoInsumo: {required:true}
      },
      messages:{
       

        idSubcategoria: {required:'Campo Requerido.'},
        descricaoInsumo: {required:'Campo Requerido.'}
      },

        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
            $(element).parents('.control-group').removeClass('success');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
   });


    $("#formAlterar").validate({
      rules:{
        idSubcategoria: {required:true},
        descricaoInsumo: {required:true}
      },
      messages:{
        idSubcategoria: {required:'Campo Requerido.'},
        descricaoInsumo: {required:'Campo Requerido.'}
      },

        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
            $(element).parents('.control-group').removeClass('success');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
   });

});
$(document).ready(function(){
	
	$("#categoriaEntrada").autocomplete({
    source: "<?php echo base_url(); ?>index.php/insumos/autoCompleteCategoriaSubCategoria",
		minLength: 1,
		select: function( event, ui ) {
			$('#idSubcategoria').val(ui.item.id);
            $('#subcategoriaEntrada').val(ui.item.descricaoSubcategoria);
            $('#idCategoriaEntrada').val(ui.item.idCategoria); 

		}
	});	  
   
});
$(document).ready(function(){
	
	$("#subcategoriaEntrada").autocomplete({
    source: "<?php echo base_url(); ?>index.php/insumos/autoCompleteSubcategoria",
		minLength: 1,
		select: function( event, ui ) {
			$('#idSubcategoria').val(ui.item.id);
            $('#categoriaEntrada').val(ui.item.descricaoCategoria);
            $('#idCategoriaEntrada').val(ui.item.idCategoria); 

		}
	});	  
   
});
    
</script>