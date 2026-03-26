<?php

    //var_dump($results); exit;

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aOrcamento')) { ?>
    <a href="<?php echo base_url(); ?>index.php/orcamentos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Orcamento</a>
<?php } ?>


<?php

?>
    

<?php 
    echo "<br>";
    echo "<br>";

?>

    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Filtro Orçamento</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content" style="background-color: #F9F9F9;border: 1px #cdcdcd solid;">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs" style="padding: 1%;">
                                    <form action="<?php echo base_url() ?>index.php/orcamentos" method="post">
                                        <div class="span12" >
                                            <div class="span1" >
                                                <label for="idstatusOrcamento" class="control-label">Cod. Orc.:</label>
                                                <input class="span12 " type="text" name="cod_orc" value="" autofocus class="span12">
                                            </div>
                                            <div class="span1" >
                                                <label for="idstatusOrcamento" class="control-label">Cod. O.S.:</label>
                                                <input class="span12 " type="text" name="cod_os" value="" autofocus class="span12">
                                            </div>
                                            <div class="span4" >
                                                <label for="cliente" class="control-label">Cliente:</label>
                                                <input class="span12"  id="cliente" type="text" name="cliente" value="" />
                                                <input id="clientes_id" type="hidden" name="clientes_id" value="" />
                                            </div>
                                            <div class="span3" >
                                                <label for="idGerente" class="control-label">Status Orçamento:</label>
                                                <select class="span12 " name="idstatusOrcamento">
                                                    <option value=""></option>
                                                    <?php foreach ($dados_statusorcamento as $o) { ?>
                                                        <option value="<?php echo $o->idstatusOrcamento; ?>"><?php echo $o->nome_status_orc; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="span3" >
                                                <label for="idNatOperacao" class="control-label">Nat. Operação:</label>
                                                <select class="span12" name="idNatOperacao">
                                                    <option value=""></option>
                                                    <?php foreach ($dados_natoperacao as $nt) { ?>

                                                        <option value="<?php echo $nt->idNatOperacao; ?>"><?php echo $nt->nome; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="span12" style=" margin-left: 0">
                                            <div class="span3">
                                                <label for="status_orc" class="control-label">Status:</label>
                                                <select class="span12" name="status_orc">
                                                    <option value=""></option>
                                                    <option value="0">Ativo</option>
                                                    <option value="1">Excluido</option>
                                                </select>
                                            </div>                                            
                                            <div class="span3">
                                                <label for="referencia" class="control-label">Referência:</label>
                                                <input id="referencia" class="span12" type="text" name="referencia" value="" />
                                            </div>
                                            <div class="span2">
                                                <label for="num_pedido" class="control-label">Num. Pedido:</label>

                                                <input id="num_pedido" class="span12" type="text" name="num_pedido" value="" />
                                            </div>
                                            <div class="span2">
                                                <label for="idGrupoServico" class="control-label">Grupo Serviço:</label>

                                                <select class="span12 " name="idGrupoServico">
                                                    <option value=""></option>
                                                    <?php foreach ($dados_gruposervico as $gs) { ?>
                                                        <option value="<?php echo $gs->idGrupoServico; ?>"><?php echo $gs->nome; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="span2">
                                                <label for="num_nf" class="control-label">Num. Nota Fiscal:</label>
                                                <input id="num_nf" class='span12' type="text" name="num_nf" class="span12" value="" />
                                            </div>
                                        </div>
                                        <div class="span12" style=" margin-left: 0">
                                            <div class="span2">
                                                <label for="num_pedido" class="control-label">PN:</label>
                                                <input type="hidden" id="idProdutos" name="idProdutos" size="3" value="" />
                                                <input id="pn" class="span12" type="text" name="pn" value="" ref="autocomplete" />
                                            </div>
                                            <div class="span4">
                                                Descrição <input id="descricao_item" class="span12" type="text" name="descricao_item" value="" />
                                            </div>
                                            <div class="span6">
                                                <br>
                                                <input class="btn btn-success" type="submit" name="filter" value="Filtrar">
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
    </div>








    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Orcamentos</h5>

        </div>

        <div class="widget-content nopadding">

            <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Orcamentos">Excel</a>
            <table class="table table-bordered " id="tableInsert">
                <thead>
                    <tr>

                        <th>Nº Orçamento</th>
                        <th>Grupo de Serviço</th>
                        <th>Cliente</th>
                        <th>Data orçamento</th>
                        <th>Itens</th>
                        <th>Status do Cliente</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $r) {
                        $color = '';
                        
                        if ($r->status_orc == 1) {
                            //$color = "bgcolor='#fb9d9d'";
                            
                        }
                        if ($r->idstatusOrcamento == 4) {
                            //$color = "bgcolor='#fb9d9d'";
                            $color = "style='color:green'";
                        }
                        if ($r->idstatusOrcamento == 11) {
                            //$color = "bgcolor='#fb9d9d'";
                            $color = "style='color:red;'";
                        }
                        if ($r->idstatusOrcamento == 12) {
                            //$color = "bgcolor='#fb9d9d'";
                            $color = "style='color:#4a4949'";
                        }
                        if ($r->idstatusOrcamento == 13) {
                            //$color = "bgcolor='#fb9d9d'";
                            $color = "style='color:black'";
                        }
                        //echo json_encode($results);
                        echo '<tr>';
                        echo '<td ' . $color . '>' . $r->id_Orcam . '</td>';
                        echo '<td ' . $color . '>' . $r->nomeGrupoServ . '</td>';
                        echo '<td ' . $color . '>' . $r->nomeCliente . '</td>';
                        echo '<td ' . $color . '>' . date("d/m/Y H:i:s", strtotime($r->data_abertura)) . '</td>';
                        echo '<td ' . $color . '> ';
                        $this->data['results2'] = $this->orcamentos_model->getorc_itemB($r->id_Orcam);
                        
                        //var_dump($this->data['results2']); exit;
                        echo '<div>';
                        echo '<table style="width: 100%;">';
                        $count = 1;
                        foreach ($this->data['results2'] as $orcitem) {
                            
                            echo '<tr>';
                            echo '<td style="border-left: 0px;width: 70%;border-top: 0px;padding: 0px;">';
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
                                    onMouseOut="this.style.color=\'red\'"><b> OS:</b>' . $this->data['results3']->idOs .'</a></font>';
                                }else{
                                    $ositem = "<font color='red'><b> OS:</b>" . $this->data['results3']->idOs . "</font>";
                                }
                            } else {
                                $ositem = '';
                            }
                            echo "<b>" . $count . "- </b>" . $orcitem->descricao_item . $ositem . " | Des.: ".$des." <br>\n";
                            $count++;
                            echo '</td>';
                            echo '<td  style="border-left: 0px;width: 30%;border-top: 0px;padding: 0px;">';
                                if(!empty($orcitem->nomeStatusOs)){
                                    echo $orcitem->nomeStatusOs;
                                }
                            echo '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        echo '</div>';
                        echo '</td>';
                        echo '<td ' . $color . '>' . $r->nome_status_orc . '</td>';
                        echo '<td>';
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOrcamento')) {
                            echo '<a href="' . base_url() . 'index.php/orcamentos/visualizar/' . $r->id_Orcam . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
                        }

                        if ($r->status_orc == 0) {
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOrcamento')) {
                                echo '<a href="' . base_url() . 'index.php/orcamentos/editar/' . $r->id_Orcam . '" style="margin-right: 1%" class="btn btn-info tip-top" ><i class="icon-pencil icon-white"></i></a>';
                            }

                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'APOrcamento')) {
                                echo '<a href="' . base_url() . 'index.php/orcamentos/aprovar/' . $r->id_Orcam . '" style="margin-right: 1%" class="btn btn-success tip-top" ><i class="icon-ok icon-white"></i></a>';
                            }
                        }
                        if ($r->status_orc == 0) {
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOrcamento')) {
                                echo '<a href="#modal-excluir" role="button" data-toggle="modal" orc="' . $r->id_Orcam . '" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a>';
                            }
                        } else {
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOrcamento')) {
                                echo '<a href="#modal-excluir_editar" role="button" data-toggle="modal" orc2="' . $r->id_Orcam . '" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a>';
                            }
                        }

                    ?>

                        
                    <?php

                        echo '</td>';
                        echo '<td style="width: 175px;">'; ?>
                            <form action="<?php echo base_url() ?>index.php/orcamentos/orcCustom" method="get" target="_blank">
                                <button class="btn btn-inverse tip-top"><i class="icon-print icon-white"></i></button>
                                Data:<input type='date' name='dataInicial' value='' class="span8" class="control-group">
                                <input type='hidden' name='id_Orcam' value='<?php echo $r->id_Orcam; ?>'>
                            </form><?php
                        echo '</td>';
                        echo '</tr>';
                    } ?>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php echo $this->pagination->create_links();
 ?>




<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/orcamentos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Desativar orçamento: <b id="bExcluir"></b></h5>
        </div>
        <div class="modal-body">
            Motivo:<select class="form-control" name="idMotivo">
                <option value=""></option>
                <?php foreach ($dados_motivo as $gs) { ?>

                    <option value="<?php echo $gs->idMotivo; ?>"><?php echo $gs->motivo; ?></option>
                <?php } ?>

            </select>
            <input type="hidden" id="idorc" name="idorc" value="" />

            <h5 style="text-align: center">Deseja realmente desativar este orçamento?</h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Desativar</button>
        </div>
    </form>
</div>

<!-- Modal -->
<div id="modal-excluir_editar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/orcamentos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Desfazer cancelamento de orçamento: <b id="bDesfazer"></b></h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="reativar" name="reativar" value="1" />
            <input type="hidden" id="idorc2" name="idorc2" value="" />
            <h5 style="text-align: center">Deseja realmente reativar este orçamento?</h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Reativar</button>
        </div>
    </form>
</div>




<script type="text/javascript">
    $(document).ready(function() {


        $(document).on('click', 'a', function(event) {

            var orc = $(this).attr('orc');
            $('#idorc').val(orc);
            $('#bExcluir').empty();
            $('#bExcluir').append(orc);

        });


        $(document).on('click', 'a', function(event) {

            var orc2 = $(this).attr('orc2');
            $('#idorc2').val(orc2);
            $('#bDesfazer').empty();
            $('#bDesfazer').append(orc2);

        });

    });
    $(document).ready(function() {

        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {

                $("#clientes_id").val(ui.item.id);

                //getValor(ui.item.id);

            }
        });



    });
    $("#pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
        minLength: 1,
        select: function(event, ui) {
            $('#idProdutos').val(ui.item.id);

        }
    });
    $(function() {
        $(".export-csv").on('click', function(event) {
            // CSV
            var filename = $(".export-csv").data("filename")
            var args = [$('#tableInsert'), filename + ".csv", 0];
            exportTableToCSV.apply(this, args);
        });

        function exportTableToCSV($table, filename, type) {
            var startQuote = type == 0 ? '"' : '';
            console.log(type);
            var $rows = $table.find('tr').not(".no-csv"),
                // Temporary delimiter characters unlikely to be typed by keyboard
                // This is to avoid accidentally splitting the actual contents
                tmpColDelim = String.fromCharCode(11), // vertical tab character
                tmpRowDelim = String.fromCharCode(0), // null character
                // actual delimiter characters for CSV/Txt format
                colDelim = type == 0 ? '";"' : '\t',
                rowDelim = type == 0 ? '"\r\n"' : '\r\n',
                // Grab text from table into CSV/txt formatted string
                csv = startQuote + $rows.map(function(i, row) {
                    var $row = $(row),
                        $cols = $row.find('td,th');
                    return $cols.map(function(j, col) {
                        var $col = $(col),
                            text = $col.text().trim().indexOf("is in cohort") > 0 ? $(this).attr('title') : $col.text().trim();
                        text = text.replace(/\r\n/, "\n");
                        return text.replace(/"/g, '""'); // escape double quotes

                    }).get().join(tmpColDelim);

                }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + startQuote;
            // Deliberate 'false', see comment below
            var BOM = "\uFEFF";
            if (false && window.navigator.msSaveBlob) {

                var blob = new Blob([decodeURIComponent(BOM + csv)], {
                    type: 'text/csv;charset=utf8'
                });

                window.navigator.msSaveBlob(blob, filename);

            } else if (window.Blob && window.URL) {
                // HTML5 Blob        
                var blob = new Blob([BOM + csv], {
                    type: 'text/csv;charset=utf8'
                });
                var csvUrl = URL.createObjectURL(blob);

                $(this)
                    .attr({
                        'download': filename,
                        'href': csvUrl
                    });
            } else {
                // Data URI
                var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(BOM + csv);

                $(this).attr({
                    'download': filename,
                    'href': csvData,
                    'target': '_blank'
                });
            }
        }

    });
</script>