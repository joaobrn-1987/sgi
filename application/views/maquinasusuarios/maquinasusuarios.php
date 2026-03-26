<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aMaquinausuario')){ ?>
    <a href="<?php echo base_url()?>index.php/maquinasusuarios/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Usuario Maquina</a>
<?php } ?>

<?php

if(!$results){?>

    <div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-wrench"></i>
         </span>
        <h5>Usuario Maquinas</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome</th>
            <th>OBS</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="5">Nenhum Usuario Maquina Cadastrada</td>
        </tr>
    </tbody>
</table>
</div>
</div>



<?php }
else{ ?>

<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-wrench"></i>
         </span>
        <h5>Maquinas Usuario</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th>#</th>
            <th>Nome</th>
           
            <th>OBS</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->idUserMaquinas.'</td>';
            echo '<td>'.$r->nome_UserMaquinas.'</td>';
           
            echo '<td>'.$r->descricao_UserMaquinas.'</td>';
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eMaquinausuario')){
                echo '<a style="margin-right: 1%" href="'.base_url().'index.php/maquinasusuarios/editar/'.$r->idUserMaquinas.'" class="btn btn-info tip-top" title="Editar Serviço"><i class="icon-pencil icon-white"></i></a>'; 
            }
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dMaquinausuario')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" servico="'.$r->idUserMaquinas.'" class="btn btn-danger tip-top" title="Excluir Serviço"><i class="icon-remove icon-white"></i></a>  '; 
            }    
                      
                      
            echo '</td>';
            echo '</tr>';
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
  <form action="<?php echo base_url() ?>index.php/maquinasusuarios/excluir" method="post" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Usuario Maquina</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idServico" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este usuario maquina
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
        
        var servico = $(this).attr('servico');
        $('#idServico').val(servico);

    });

});

</script>