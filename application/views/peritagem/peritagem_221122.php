<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<!--
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Filtros</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                        <input type="text" class="span12" value=""  />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Cliente: </label>
                                        <input type="text" class="span12" value=""  />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Solicitante: </label>
                                        <input type="text" class="span12" value=""  />
                                    </div>
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                        <input type="text" class="span12" value=""  />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Descrição Produto: </label>
                                        <input type="text" class="span12" value=""  />
                                    </div>
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Ref.: </label>
                                        <input type="text" class="span12" value=""  />
                                    </div>
                                    <div class="span3" class="control-group">
                                        <label for="idGrupoServico" class="control-label">TAG: </label>
                                        <input type="text" class="span12" value=""  />
                                    </div>
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <a class="btn btn-warning" class="span12" >Limpar</a>
                                        <a class="btn btn-success" class="span12" >Filtrar</a>
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
                <h5>Aguardando Peritagem</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs">                                
                                <div class="widget-box" style="margin-top:0px">                                        
                                    <table id="tableAguardandoPeritagem" class="table table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>Orç. Item</th>
                                                <th>Descrição</th>
                                                <th>Status Perit.</th>
                                                <th>Status Des.</th>
                                                <th>Data Solicitação</th>  
                                                <th></th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach($aguardandoPer as $r){
                                                    echo '<tr>';
                                                        echo '<td>'.$r->idOrcamento_item.'</td>';
                                                        echo '<td>'.$r->descricao_item.'</td>';
                                                        echo '<td>'.$r->descricaoEscopo.'</td>';  
                                                        echo '<td>'.($r->statusDesenho == 1 ? 'AGUARDANDO DESENHO' : ($r->statusDesenho == 2 ? 'INCOMPLETO' : 'FINALIZADO')).'</td>';                                       
                                                        echo '<td>'.date("d/m/Y H:i:s", strtotime($r->data_cadastro)).'</td>';
                                                        echo '<td>';
                                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'vPeritagem')){
                                                            echo '<a href="' . base_url() . 'index.php/peritagem/escopoperitagem/' . $r->idOrcServicoEscopo . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open""></i></a>';
                                                        }
                                                        echo '</td>';
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#tableAguardandoPeritagem').DataTable({
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