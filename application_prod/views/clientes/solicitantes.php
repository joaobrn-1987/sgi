<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){ ?>
    <a href="#modalCadastrar" data-toggle="modal" role="button" class="btn btn-success">Cadastrar Solicitante</a>    
<?php } ?>
<div id="modalCadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/clientes/cadastrarSolicitante" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">SGI - Cadastrar Solicitante</h3>
  </div>
  <div class="modal-body">
        
        
                    <div class="control-group">
                        <label for="nome" class="control-label">Solicitante<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" type="text" name="nome" value=""  />
                        </div>
                    </div>
					 <div class="control-group">
                        <label for="email_solici" class="control-label">Email<span class="required">*</span></label>
                        <div class="controls">
                            <input id="email_solici" type="text" name="email_solici" value=""  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="idClientes" class="control-label">Cliente<span class="required">*</span></label>
                        <div class="controls">
                        <select class="form-control" name="idClientes">
                        <option selected="selected" disabled="disabled" value="">Escolher</option>
                        <?php foreach ($dados_cliente as $p) { ?>
                        
                        <option value="<?php echo $p->idClientes; ?>"><?php echo $p->nomeCliente; ?>| CNPJ: <?php echo $p->documento; ?></option>
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
            <h5>Solicitante</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                       
                       
                        <th>Cliente</th>
                        <th>Solicitante</th>
                        <th>Email</th>
                        
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum solicitante Cadastrado</td>
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
<form class="form-inline" action="<?php echo base_url() ?>index.php/clientes/solicitantes" method="post">
        <select class="form-control" name="field">
            <option selected="selected" disabled="disabled" value="">Filtrar por</option>
            <option value="nomeCliente">Cliente</option>
            <option value="nome">Solicitante</option>
            <option value="email_solici">Email Solicitante</option>
           
            
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
        <h5>Solicitante</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
           
            
        
        <th>Cliente</th>
        <th>Solicitante</th>
        <th>Email Solicitante</th>
                        
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dados as $r) {
            echo '<tr>';
            echo '<td>Cod.: '.$r->idClientes.' - '.$r->nomeCliente.'</td>';
            echo '<td>Cod.:'.$r->idSolicitante.' - '.$r->nome.'</td>';
            echo '<td>'.$r->email_solici.'</td>';
           
           
            echo '<td>';
           /* if($this->permission->checkPermission($this->session->userdata('permissao'),'vCategoria')){
                echo '<a href="'.base_url().'index.php/clientes/visualizar/'.$r->idSubcategoria.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }*/
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
                ?>

                <a href="#modalAlterar<?php echo $r->idSolicitante; ?>" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a>
<?php
               // echo '<a href="'.base_url().'index.php/insumos/editar/'.$r->idSubcategoria.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Cliente"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dCliente')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" solicitante ="'.$r->idSolicitante.'" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Solicitante"><i class="icon-remove icon-white"></i></a>'; 
               
            }

              
            echo '</td>';
            echo '</tr>';
            ?>
            <!-- modal alterar -->
<div id="modalAlterar<?php echo $r->idSolicitante; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url(); ?>index.php/clientes/editarsolicitante" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">SGI - Editar Dados Solicitante</h3>
  </div>
  <div class="modal-body">
        

                    <div class="control-group">
                        <label for="nome" class="control-label">Solicitante<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" type="text" name="nome" value="<?php echo $r->nome; ?>"  />
                            <input id="idSolicitante" type="hidden" name="idSolicitante" value="<?php echo $r->idSolicitante; ?>"  />
                        </div>
                    </div>
					 <div class="control-group">
                        <label for="email_solici" class="control-label">Email<span class="required">*</span></label>
                        <div class="controls">
                            <input id="email_solici" type="text" name="email_solici" value="<?php echo $r->email_solici; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="idClientes" class="control-label">Cliente<span class="required">*</span></label>
                        <div class="controls">
						<select class="form-control" name="idClientes">
                       
                        <?php foreach ($dados_cliente as $dc) { ?>
                        
                        <option value="<?php echo $dc->idClientes; ?>" <?php if($dc->idClientes ==  $r->idClientes) { echo "selected='selected'"; }  ?>><?php echo $dc->nomeCliente; ?></option>
                        <?php } ?>
                        </div>
                        </select>
						
                       
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
  <form action="<?php echo base_url() ?>index.php/clientes/excluirsolicitante" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Solicitante</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idcat" name="idcat" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este solicitante?</h5>
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
        
        var solicitante = $(this).attr('solicitante');
        $('#idcat').val(solicitante);

    });

});

</script>


<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
    
$(document).ready(function(){

  


    $("#formCadastrar").validate({
      rules:{
        idClientes: {required:true},
          nome: {required:true},
          email_solici: {required:true}
      },
      messages:{
        idClientes: {required:'Campo Requerido.'},
        nome: {required:'Campo Requerido.'},
        email_solici: {required:'Campo Requerido.'}
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
        idClientes: {required:true},
          nome: {required:true},
          email_solici: {required:true}
      },
      messages:{
        idClientes: {required:'Campo Requerido.'},
        nome: {required:'Campo Requerido.'},
        email_solici: {required:'Campo Requerido.'}
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