<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aFornecedor')){ ?>
    <a href="<?php echo base_url();?>index.php/fornecedores/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Fornecedor</a>    
<?php } ?>

<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Fornecedores</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>CPF/CNPJ</th>
                        <th>Telefone</th>
						<th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Fornecedor Cadastrado</td>
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
<form class="form-inline" action="<?php echo base_url() ?>index.php/fornecedores" method="post">
        <select class="form-control" name="field">
            <option selected="selected" disabled="disabled" value="">Filtrar por</option>
            <option value="nomeFornecedor">Nome</option>
            <option value="email">Email</option>
            <option value="documento">CNPJ</option>
            
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
        <h5>Fornecedores</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
			 <th>Rua</th>
            <th>CPF/CNPJ</th>
            <th>Telefone</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            echo '<tr>';
            echo '<td>'.$r->idFornecedores.'</td>';
            echo '<td>'.$r->nomeFornecedor.'</td>';
			echo '<td>'.$r->rua.'</td>';
            echo '<td>'.$r->documento.'</td>';
            echo '<td>'.$r->telefone.'</td>';
			
			
			
            echo '<td>';
            if($this->permission->checkPermission($this->session->userdata('permissao'),'vFornecedor')){
                echo '<a href="'.base_url().'index.php/fornecedores/visualizar/'.$r->idFornecedores.'" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>'; 
            }

			
			if($this->permission->checkPermission($this->session->userdata('permissao'),'eFornecedor') && ($r->tipofor == '1')) {
				
			    echo '<a href="'.base_url().'index.php/fornecedores/editar/'.$r->idFornecedores.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Fornecedor"><i class="icon-pencil icon-white"></i></a>';

					
			} 
			if ($this->permission->checkPermission($this->session->userdata('permissao'),'eFornecedor') && ($r->tipofor == null)) {
				
					 echo '<a href="'.base_url().'index.php/fornecedores/editar/'.$r->idFornecedores.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Fornecedor"><i class="icon-pencil icon-white"></i></a>';
			}
			
			if ($this->permission->checkPermission($this->session->userdata('permissao'),'eFornecedor') && ($r->tipofor == '2')) {
				
				echo '<a href="'.base_url().'index.php/fornecedores/editarInt/'.$r->idFornecedores.'" style="margin-right: 1%" class="btn btn-info tip-top" title="Editar Fornecedor"><i class="icon-pencil icon-white"></i></a>';
			} 




			
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dFornecedor')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" fornecedor="'.$r->idFornecedores.'" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Fornecedor"><i class="icon-remove icon-white"></i></a>'; 
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
  <form action="<?php echo base_url() ?>index.php/fornecedores/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Fornecedor</h5> 
  </div>
  <div class="modal-body">
    <input type="hidden" id="idFornecedor" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este fornecedor?</h5>
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
        
        var fornecedor = $(this).attr('fornecedor');
        $('#idFornecedor').val(fornecedor);

    });

});

</script>
