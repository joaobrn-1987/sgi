<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>

<?php 
    //$this->load->view('almoxarifado/gerencia/menugerencia');
?>

<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Liberar PCP</a></li>
    <li><a href="#tab2" data-toggle="tab">Histórico</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab1">
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Liberar PCP</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="<?php echo base_url() ?>index.php/almoxarifado/gerencia3" method="post">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                    <div class="tab-pane active">
                                        <div class="span12" id="divCadastrarOs">
                                            <div class="span12" style="padding: 1%; margin-left: 0">
                                                <div class="span2" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">O.S.: </label>
                                                    <input type="text" class="span12" value="" name="os"/>
                                                </div>
                                                <div class="span5" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">Cliente: </label>
                                                    <input type="text" class="span12" value="" id="cliente" name="cliente"/>
                                                </div>
                                                <div class="span2" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">Vendedor: </label>
                                                    <input type="text" class="span12" value="" id="vendedor" name="vendedor"/>
                                                </div><!--
                                                <div class="span3" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">TAG: </label>
                                                    <input type="text" class="span12" value="" readonly />
                                                </div> -->
                                                <div class="span2" class="control-group">
                                                    <button type="submit" style="background-color: #f9f9f9; border: 0px;"><i class="icon-search" style="font-size:30px; float: right;"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>O.S. Bloqueadas para solicitação de compra</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">                                
                                        <div class="widget-box" style="margin-top:0px">                                        
                                            <table id="tableBloqueados" class="table table-bordered " >
                                                <thead>
                                                    <tr>
                                                        <th>OS</th>
                                                        <th>Cliente</th>
                                                        <th>QTD.</th>    
                                                        <th>Descrição</th>
                                                        <th>Data Abertura</th>
                                                        <th>Unid. Exec.</th>
                                                        <th>Vendedor</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($itens as $r){
                                                        if(!empty($r->data_abertura)){ 
                                                            $date = new DateTime( $r->data_abertura);
                                                            //echo $date-> format( 'Y-m-d H:i:s' );
                                                        }
                                                        echo '<tr>';
                                                            echo '<td>'.$r->idOs.'</td>';
                                                            echo '<td>'.$r->nomeCliente.'</td>';
                                                            echo '<td>'.$r->qtd_os.'</td>';
                                                            echo '<td>'.$r->descricao_item.'</td>';
                                                            echo '<td><span style="display:none">'.$r->data_abertura.'</span>'.$date->format( 'd/m/Y' ).'</td>';
                                                            echo '<td>'.$r->status_execucao.'</td>';
                                                            echo '<td>'.$r->nomeVendedor.'</td>';
                                                            if($this->permission->checkPermission($this->session->userdata('permissao'),'eLiberarpcp')){
                                                                echo '<td><a id="destravar" idOs="' . $r->idOs . '" nomecliente="' . $r->nomeCliente . '" qtd_os="'.$r->qtd_os.'" descricao_item="'.$r->descricao_item.'" data_abertura="'.$r->data_abertura.'" status_execucao = "'.$r->status_execucao.'" nomeVendedor = "'.$r->nomeVendedor.'" href="#modal-destravar" style="margin-right: 1%" role="button" data-toggle="modal" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a></td>';
                                                            }else{
                                                                echo '<td></td>';
                                                            }
                                                        echo '</tr>';
                                                    } ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>

    </div>
    <div class="tab-pane" id="tab2"> <!--
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Orçamento</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                <div class="tab-pane active">
                                    <div class="span12" id="divCadastrarOs">
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                            <div class="span5" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Cliente: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                            <div class="span5" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Solicitante: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                        </div>
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">PN: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                            <div class="span5" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Descrição Produto: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Ref.: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                            <div class="span3" class="control-group">
                                                <label for="idGrupoServico" class="control-label">TAG: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Histórico Liberar PCP</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">                                
                                        <div class="widget-box" style="margin-top:0px">                                        
                                            <table id="tableHistLiberar" class="table table-bordered " >
                                                <thead>
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>O.S.</th>
                                                        <th>Descrição</th>                                            
                                                        <th>Usuário</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($historico as $r){
                                                        if(!empty($r->data_insert)){ 
                                                            $date = new DateTime( $r->data_insert);
                                                            //echo $date-> format( 'Y-m-d H:i:s' );
                                                        }
                                                        echo '<tr>';
                                                            echo '<td><span style="display:none">'.$r->data_insert.'</span>'.$date->format( 'd/m/Y' ).'</td>';
                                                            echo '<td>'.$r->idOs.'</td>';
                                                            echo '<td>'.$r->descricao_item.'</td>';
                                                            echo '<td>'.$r->nome.'</td>';  
                                                        echo '</tr>';

                                                    }
                                                    ?>                                                                                      
                                                </tbody>
                                            </table>
                                        </div>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<div id="modal-destravar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/almoxarifado/destravar" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>               
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">Liberar O.S. para a solicitação de compra de materiais?</h5>
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>OS</th>
                        <th>Cliente</th>
                        <th>QTD.</th>    
                        <th>Descrição</th>
                        <th>Data Abertura</th>
                        <th>Unid. Exec.</th>
                        <th>Vendedor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" value="" class="span12" id="idOs2" name="idOs2" readonly></td>
                        <td><input type="text" value="" class="span12" id="nomecliente2" name="nomecliente2" readonly></td>
                        <td><input type="text" value="" class="span12" id="qtd_os2" name="qtd_os2" title="" readonly></td>
                        <td><input type="text" value="" class="span12" id="descricao_item2" name="descricao_item2" readonly></td>
                        <td><input type="text" value="" class="span12" id="data_abertura2" name="data_abertura2" readonly></td>
                        <td><input type="text" value="" class="span12" id="status_execucao2" name="status_execucao2" readonly></td>
                        <td><input type="text" value="" class="span12" id="nomeVendedor2" name="nomeVendedor2" readonly></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <h5 style="text-align: center">O.S.</h5>
                <div class="span12" style=" margin-left: 0">
                    <div class="span4">
                        <label for="idGrupoServico" class="control-label">Motivo: </label>
                        <select class="span12" id="motivoLib" name="motivoLib">  
                            <option value="">Selecione um motivo</option>
                            <?php foreach($motivos as $r){
                                echo '<option value="'.$r->idMotivoLib.'">'.$r->descricaoMotivoLib.'</option>';
                            } ?>
                        </select>
                    </div> <!--
                    <div class="span4">
                        <label for="idGrupoServico" class="control-label">Motivo: </label>
                    </div>-->
                    

                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success">Liberar</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteCliente",
            minLength: 1,
            select: function( event, ui ) {
                

            }
        });
        $("#vendedor").autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteVendedor",
            minLength: 1,
            select: function( event, ui ) {
                

            }
        });

        $(document).on('click', 'a', function(event) {

            var idOs = $(this).attr('idOs');
            $('#idOs2').val(idOs);

            var nomecliente = $(this).attr('nomecliente');
            $('#nomecliente2').val(nomecliente);

            var qtd_os = $(this).attr('qtd_os');
            $('#qtd_os2').val(qtd_os);

            var descricao_item = $(this).attr('descricao_item');
            $('#descricao_item2').val(descricao_item);

            var data_abertura = $(this).attr('data_abertura');
            $('#data_abertura2').val(data_abertura);

            var nomeVendedor = $(this).attr('nomeVendedor');
            $('#nomeVendedor2').val(nomeVendedor);

            var status_execucao = $(this).attr('status_execucao');
            $('#status_execucao2').val(status_execucao);

        });
    });
    $(document).ready(function () {
        $('#tableBloqueados').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "paging": false,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "sProcessing":    "Procesando...",
                "sZeroRecords":   "Sem resultados",
                "sInfo":          "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
                "sInfoEmpty":     "Mostrando registros de 0 a 0 de um total de 0 registros",
                "sInfoFiltered":  "(filtrado de um total de _MAX_ registros)",
                "sInfoPostFix":   "",
                "sUrl":           "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });
        
    } );
    $(document).ready(function () {
        $('#tableHistLiberar').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "paging": false,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "sProcessing":    "Procesando...",
                "sZeroRecords":   "Sem resultados",
                "sInfo":          "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
                "sInfoEmpty":     "Mostrando registros de 0 a 0 de um total de 0 registros",
                "sInfoFiltered":  "(filtrado de um total de _MAX_ registros)",
                "sInfoPostFix":   "",
                "sUrl":           "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });
        
    } );

</script>