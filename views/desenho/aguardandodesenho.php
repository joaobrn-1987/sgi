<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->



<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Filtro</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: #F9F9F9;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <form action="<?php echo base_url() ?>index.php/desenho/aguardandodesenho/1" method="post" name="form1" id="form1">
                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                            <input type="text" class="span12" value="" name="idOrcamento" />
                                        </div><!--
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento Item: </label>
                                            <input type="text" class="span12" value="" name="idOrcamentoItem" />
                                        </div>-->
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">O.S.: </label>
                                            <input type="text" class="span12" value="" name="idOs" />
                                        </div>
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">PN: </label>
                                            <input type="text" class="span12" value="" name="pn" />
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Descrição: </label>
                                            <input type="text" class="span12" value="" name="descricaoOrc" />
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Status Desenho: </label>
                                            <select class="span12 form-control" name="statusDesenho">
                                                <option value=""></option>
                                                <option value="1">Aguardando Desenho</option>
                                                <option value="2">Incompleto</option>
                                                <option value="3">Finalizado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <button type="submit" class="btn btn-success"><i class="icon-white"></i>Filtrar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>Aguardando desenho</h5>

    </div>

    <div class="widget-content nopadding">
        <!--
            <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Orcamentos">Excel</a> -->
        <table class="table table-bordered " id="tableAguardandoDesenho">
            <thead>
                <tr>

                    <th>Nº Orçamento</th>
                    <th>Cliente</th>
                    <th>Data orçamento</th>
                    <th>Itens</th><!--
                    <th>Status orçamento</th>-->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $r) {
                    
                    echo '<tr>';
                    echo '<td >' . $r->idOrcamentos . '</td>';
                    echo '<td >' . $r->nomeCliente . '</td>';
                    echo '<td >' . date("d/m/Y H:i:s", strtotime($r->data_abertura)) . '</td>';
                    echo '<td> ';
                    //$this->data['results2'] = $this->orcamentos_model->getorc_item4($r->idOrcamentos);
                    $count = 1;
                    $tot = count(explode(";",$r->idOrcamento_item));
                    $dist = explode(";",$r->idOrcamento_item);
                    $qtd = explode(";",$r->pn);
                    $dtCad = explode(";",$r->descricao_item);
                    $nome = explode(";",$r->nomeVendedor);
                    //foreach ($this->data['results2'] as $orcitem) {
                    for($x = 0;$x < $tot;$x++){
                        $orcitem = $this->orcamentos_model->getOrcItemDetailsById($dist[$x]);
                        $color = "";
                        if($orcitem->idStatusPeritagem == 6){
                            $color = "style='color:red'";
                        }
                        $this->data['results3'] = $this->orcamentos_model->getos_item($orcitem->idOrcamento_item);
                        if ($orcitem->statusDesenho == 3) {
                            $des = '<a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>';
                        } else if ($orcitem->statusDesenho == 2) {
                            $des = '<a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>';
                        } else {
                            $des = '<a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a>';
                        }
                        if (!empty($this->data['results3'])) {

                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                                $ositem = '<font color="red"><a target="_blank" href="' . base_url() . 'index.php/os/visualizar/' . $this->data['results3']->idOs . '" style="color: red;" onMouseOver="this.style.color=\'blue\'"
                                    onMouseOut="this.style.color=\'red\'"><b> OS:</b>' . $this->data['results3']->idOs . '</a></font>';
                            } else {
                                $ositem = "<font color='red'><b> OS:</b>" . $this->data['results3']->idOs . "</font>";
                            }
                        } else {
                            $ositem = '';
                        }
                        $dataSol = ""; 
                        $nf_cliente = "";
                        if(!empty($orcitem->data_solicitar_desenho)){
                            $dataSol = " | Data Sol. Des.: ".date("d/m/Y H:i", strtotime($orcitem->data_solicitar_desenho));
                        }
                        if(!empty($orcitem->nf_cliente)){
                            $nf_cliente = " | NF: ".$orcitem->nf_cliente;
                        }
                        echo "<div $color><b>" . $count . "- </b>" . $orcitem->descricao_item . $ositem ." | Des.: ".$des. $dataSol. $nf_cliente." <br> </div>\n";
                        $count++;
                    }
                    //}

                    echo '</td>';/*
                    echo '<td >' . $r->nome_status_orc . '</td>';*/
                    echo '<td>';
                    echo '<a href="' . base_url() . 'index.php/desenho/visualizardesenhos/' . $r->idOrcamentos . '/'.str_replace(";","_",$r->idOrcamento_item).'" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
                    echo '</td>';
                    echo '</tr>';
                } ?>
                <tr>

                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    function openclose(td, valor) {
        var tr = document.querySelector(".trfilho" + valor);

        if (tr.style.display == "table-row" || tr.style.display == "") {
            $(".trfilho" + valor).hide('fast');
            $(td).parent('tr').css('background-color', '');
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");
        } else {
            $(".trfilho" + valor).show('fast');
            $(td).parent('tr').css('background-color', '#efefef');
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }
    }
    
    $(document).ready(function() {/*
        $('#tableAguardandoDesenho').DataTable({
            'columnDefs': [{ // column index (start from 0)
                'orderable': true, // set orderable false for selected columns
            }],
            "paging": false, //Dont want paging                
            "bPaginate": false, //Dont want paging 
            "searching": false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "sProcessing": "Procesando...",
                "sZeroRecords": "Sem resultados",
                "sInfo": "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros de 0 a 0 de um total de 0 registros",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });*/

    });
</script>