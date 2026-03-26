<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aProduto')){ ?>
    <a href="<?php echo base_url();?>index.php/produtos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Produto PN</a>
<?php } ?>

<?php

if(!$results){?>
	<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Produtos PN</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th>#</th>
            <th>Descrição</th>
            <th>PN</th>
            <th>Referencia</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="5">Nenhum Produto PN Cadastrado</td>
        </tr>
    </tbody>
</table>
</div>
</div>

<?php } else{?>
    <div>
<form class="form-inline" action="<?php echo base_url() ?>index.php/produtos" method="post">
        <select class="form-control" name="field">
           
            <option value="descricao">Descricao</option>
            <option value="pn" selected="selected" >PN</option>
            <option value="referencia">Referência</option>
            
        </select>
        <input class="form-control" type="text" name="search" value="" placeholder="Search..." autofocus>
        <input class="btn btn-default" type="submit" name="filter" value="Filtrar">
    </form>


</div>
</br></br>
<div class="buttons">
    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
    <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Rel-Orcamento">Excel</a>
</div>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-barcode"></i>
         </span>
        <h5>Produtos PN</h5>

     </div>

    <div class="widget-content nopadding">
        <table class="table table-bordered ">
            <thead>
                <tr style="backgroud-color: #2D335B">
                    <th>PN</th>
                    <th>Descrição</th>
                    
                    <th>Referencia</th>
                    <th>Fornecedor Orig.</th>
                    <th>Equipamento</th>
                    <th>Subconjunto</th>
                    <th>Modelo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $r) {
                    echo '<tr>';
                        echo '<td>'.$r->pn.'</td>';
                        echo '<td>'.$r->descricao.'</td>';
                        echo '<td>'.$r->referencia.'</td>';
                        echo '<td>'.$r->fornecedor_original.'</td>';
                        echo '<td>'.$r->equipamento.'</td>';
                        echo '<td>'.$r->subconjunto.'</td>';
                        echo '<td>'.$r->modelo.'</td>';
                    
                        //echo '<td>'.number_format($r->precoVenda,2,',','.').'</td>';
                        
                        echo '<td>';
                        /*if($this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){
                            echo '<a style="margin-right: 1%" href="'.base_url().'index.php/produtos/visualizar/'.$r->idProdutos.'" class="btn tip-top" title="Visualizar Produto PN"><i class="icon-eye-open"></i></a>  '; 
                        }*/
                        if($this->permission->checkPermission($this->session->userdata('permissao'),'eProduto')){
                            echo '<a style="margin-right: 1%" href="'.base_url().'index.php/produtos/editar/'.$r->idProdutos.'" class="btn btn-info tip-top" title="Editar Produto PN"><i class="icon-pencil icon-white"></i></a>'; 
                        }
                        if($this->permission->checkPermission($this->session->userdata('permissao'),'dProduto')){
                            echo '<a href="#modal-excluir" role="button" data-toggle="modal" produto="'.$r->idProdutos.'" class="btn btn-danger tip-top" title="Excluir Produto PN"><i class="icon-remove icon-white"></i></a>'; 
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
  <form action="<?php echo base_url() ?>index.php/produtos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Produto PN</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idProduto" name="id" value="" />
    <h5 style="text-align: center">Deseja realmente excluir este produto PN?</h5>
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
        var produto = $(this).attr('produto');
        $('#idProduto').val(produto);
    });
    $("#imprimir").click(function() {
        //PrintElem('#printOs2');
    })

    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
        var mywindow = window.open('', 'SGI', 'height=600,width=800');
        mywindow.document.write('<html><head><title>SGI</title><meta charset="UTF-8" />');
        /* mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/bootstrap.min.css' /><link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css' />");*/
        mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/tableimprimir.css' />");


        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        //mywindow.close();

        return true;
    }
});

</script>