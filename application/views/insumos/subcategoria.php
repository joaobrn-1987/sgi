<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aSubcategoria')){ ?>
    <a href="#modalCadastrar" data-toggle="modal" role="button" class="btn btn-success">Cadastrar SubCategoria</a>    
<?php } ?>
<div id="modalCadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/insumos/cadastrarSubCategoria" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">SGI - Cadastrar SubCategoria</h3>
  </div>
  <div class="modal-body">
        
        
                   <div class="modal-body">
                        <label for="descricaoSubcategoria" >Subcategoria<span class="required">*</span></label>
                        <div >
                            <input id="descricaoSubcategoria" type="text" name="descricaoSubcategoria" value="" class='span12' />
                        </div>
                    </div>
                   <div class="modal-body">
                        <label for="idCategoria" >Nome Categoria<span class="required">*</span></label>
                        <div >
                        <select  name="idCategoria" class='span12'>
                        <option selected="selected" disabled="disabled" value="">Escolher</option>
                        <?php foreach ($dados_cat as $p) { ?>
                        
                        <option value="<?php echo $p->idCategoria; ?>"><?php echo $p->descricaoCategoria; ?></option>
                        <?php } ?>
                        </div>
                        </select>
                        </div>
                    </div>
               

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-success">Cadastrar</button>
  </div>
  </form>
</div>
<?php
if(!$dados){?>

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
                       
                       
                        <th>Nome Categoria</th>
                        <th>Nome SubCategoria</th>
                        
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

<?php }else{
echo "<br>";
echo "<br>";	

?>
<div>
<form class="form-inline" action="<?php echo base_url() ?>index.php/insumos/subcategoria" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <select class="form-control" name="field">
            <option selected="selected" disabled="disabled" value="">Filtrar por</option>
            <option value="descricaoCategoria">Nome Categoria</option>
            <option value="descricaoSubcategoria">Nome Subcategoria</option>
           
            
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
        <h5>Subcategoria</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
           
            
        
        <th>Nome Categoria</th>
        <th>Nome SubCategoria</th>
                        
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dados as $r) {
            echo '<tr>';
            //echo '<td>Cod.: '.$r->idCategoria.' - '.$r->descricaoCategoria.'</td>';
            echo '<td>'.$r->descricaoCategoria.'</td>';
            echo '<td>'.$r->descricaoSubcategoria.'</td>';
           
           
            echo '<td>';
           /* if($this->permission->checkPermission($this->session->userdata('permissao'),'vCategoria')){
                echo '<a href="'.base_url().'index.php/clientes/visualizar/'.$r->idSubcategoria.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }*/
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eSubcategoria')){
                ?>

                <a href="#modalAlterar<?php echo $r->idSubcategoria; ?>" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a>
<?php
               // echo '<a href="'.base_url().'index.php/insumos/editar/'.$r->idSubcategoria.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Cliente"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dSubcategoria')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" categoria ="'.$r->idSubcategoria.'" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a>'; 
               
            }

              
            echo '</td>';
            echo '</tr>';
            ?>
            <!-- modal alterar -->
<div id="modalAlterar<?php echo $r->idSubcategoria; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/insumos/editarsubcat" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">SGI - Editar Dados SubCategoria</h3>
  </div>
  <div class="modal-body">
        

                    <div class="control-group">
                        <label for="idCategoria" class="control-label">Categoria<span class="required">*</span></label>
                        <div class="controls">
                        <select class="form-control" name="idCategoria" class='span12'>
                       
                        <?php foreach ($dados_cat as $dc) { ?>
                        
                        <option value="<?php echo $dc->idCategoria; ?>" <?php if($dc->idCategoria ==  $r->idCategoria) { echo "selected='selected'"; }  ?>><?php echo $dc->descricaoCategoria; ?></option>
                        <?php } ?>
                        </div>
                        </select>
                        </div>
                    
                        <div class="control-group">
                        <label for="descricaoSubcategoria" class="control-label">Subcategoria<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descricaoSubcategoria" type="text" name="descricaoSubcategoria" value="<?php echo $r->descricaoSubcategoria; ?>"  class='span12'/>
                            <input id="idSubcategoria" type="hidden" name="idSubcategoria" value="<?php echo $r->idSubcategoria; ?>"  />
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
</div>
<?php echo $this->pagination->create_links();}?>



 <!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/insumos/excluirsubcat" method="post" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir SubCategoria</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idcat" name="idcat" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta subcategoria?</h5>
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
    
$(document).ready(function(){

  


    $("#formCadastrar").validate({
      rules:{
        idCategoria: {required:true},
          descricaoSubcategoria: {required:true}
      },
      messages:{
        idCategoria: {required:'Campo Requerido.'},
        descricaoSubcategoria: {required:'Campo Requerido.'}
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
        idCategoria: {required:true},
        descricaoSubcategoria: {required:true}
      },
      messages:{
        idCategoria: {required:'Campo Requerido.'},
        descricaoSubcategoria: {required:'Campo Requerido.'}
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
    
</script>