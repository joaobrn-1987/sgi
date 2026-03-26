<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aCategoria')){ ?>
    <a href="#modalCadastrar" data-toggle="modal" role="button" class="btn btn-success">Cadastrar Categoria</a>    
<?php } ?>
<div id="modalCadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/insumos/cadastrarCategoria" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">SGI - Cadastrar Categoria</h3>
  </div>
 
        
        
                   <div class="modal-body">
                        <label for="descricaoCategoria" >Nome Categoria<span class="required">*</span></label>
                        <div >
                            <input id="descricaoCategoria" type="text" name="descricaoCategoria" value="" class='span12' />
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
            <h5>Categoria</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                       
                        <th>Código</th>
                        <th>Nome Categoria</th>
                        
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhuma Categoria Cadastrada</td>
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
<form class="form-inline" action="<?php echo base_url() ?>index.php/insumos/categoria" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <select class="form-control" name="field">
            <option selected="selected" disabled="disabled" value="">Filtrar por</option>
            <option value="idCategoria">Cod. Categoria</option>
            <option value="descricaoCategoria">Nome Categoria</option>
           
            
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
        <h5>Categoria</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
           
            
            <th width='10%'>Cod. Categoria</th>
            <th>Nome Categoria</th>
                        
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dados as $r) {
            echo '<tr>';
            echo '<td>'.$r->idCategoria.'</td>';
            echo '<td>'.$r->descricaoCategoria.'</td>';
          
            echo '<td>';
           /* if($this->permission->checkPermission($this->session->userdata('permissao'),'vCategoria')){
                echo '<a href="'.base_url().'index.php/clientes/visualizar/'.$r->idCategoria.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }*/
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eCategoria')){
                ?>

                <a href="#modalAlterar<?php echo $r->idCategoria; ?>" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a>
<?php
               // echo '<a href="'.base_url().'index.php/insumos/editar/'.$r->idCategoria.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Cliente"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dCategoria')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" categoria ="'.$r->idCategoria.'" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a>'; 
               
            }

              
            echo '</td>';
            echo '</tr>';
            ?>
            <!-- modal alterar -->
<div id="modalAlterar<?php echo $r->idCategoria; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/insumos/editarcat" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">SGI - Editar Dados Categoria</h3>
  </div>
  <div class="modal-body">
        
        
                    <div class="control-group">
                        <label for="descricaoCategoria" class="control-label">Categoria<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descricaoCategoria" type="text" name="descricaoCategoria" value="<?php echo $r->descricaoCategoria; ?>" class='span12' />
                            <input id="idCategoria" type="hidden" name="idCategoria" value="<?php echo $r->idCategoria; ?>"  />
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
  <form action="<?php echo base_url() ?>index.php/insumos/excluircat" method="post" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Categoria</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idcat" name="idcat" value="" />
    <h5 style="text-align: center">Deseja realmente excluir esta categoria?</h5>
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
        
        descricaoCategoria: {required:true}
      },
      messages:{
         
         descricaoCategoria: {required:'Campo Requerido.'}
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
         
         descricaoCategoria: {required:true}
      },
      messages:{
         
        descricaoCategoria: {required:'Campo Requerido.'}
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