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
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <form action="<?php echo base_url() ?>index.php/os/ossemmateriais" method="get" name="form1" id="form1">
                                <div class="span12" >
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                            <input type="text" class="span12" value=""  name="idOrcamento"/>
                                            <input type="hidden" class="span12" value="1"  name="verificar"/>
                                        </div>
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">O.S.: </label>
                                            <input type="text" class="span12" value=""  name="idOs"/>
                                        </div>
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">PN: </label>
                                            <input type="text" class="span12" value=""  name="pn"/>
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Descrição: </label>
                                            <input type="text" class="span12" value=""  name="descricaoOrc"/>
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
                                        <div class="span12" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Status OS:</label>&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll2();">&nbsp;Marcar/Desmarcar todos
                                            <br>
                                            <table width='100%'>
                                                <tr>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($status_os as $e) {



                                                    ?>
                                                        <td>
                                                            <input type="checkbox" name="idStatusOs[]" class='check' value="<?php echo $e->idStatusOs; ?>" <?php if ($e->carteirapadrao == 1) {
                                                                                                                                                                echo "checked";
                                                                                                                                                            }   ?>> &nbsp;<?php echo $e->nomeStatusOs; ?>
                                                        </td>
                                                    <?php
                                                        if (($i + 1) % 5 == 0)
                                                            echo "</tr>";

                                                        $i++;
                                                    }


                                                    ?>


                                            </table>

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
<div class="buttons">

    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
    <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="os_sem_lancamento">Excel</a>
</div>
<div class="row-fluid" style="margin-top:0" >
    <div class="span12" id="scrollIdtest" style="width: 100%; overflow-y: scroll;" onmousemove="scrollDetect(this,event)">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>OS</h5>
                <h5>Legenda:</h5>
                <div style="padding:8px">
                    Completo <a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>|
                    Incompleto <a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>|
                    Sem desenho <a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a>
                </div>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="span12" >                                
                        <div class="widget-box" style="margin-top:0px">                                        
                            <table  class="table table-bordered ">
                                <thead>
                                    <tr>

                                        <th>Nº OS</th>
                                        <th>Cliente</th>
                                        <th>QTD</th>
                                        <th>Descrição</th>

                                        <?php
                                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                                        ?>

                                            <th>Valor</th>

                                        <?php
                                        }
                                        ?>
                                        <th>Status</th>
                                        <th>PN</th>
                                        <th>Data Criação</th>
                                        <th>Data OS</th>
                                        <th>Data entrega</th>
                                        <th>Data reagendada</th>
                                        <th>Unid. Exec.</th>
                                        <th>Desenho</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $valor = '';

                                    foreach ($results as $r) {
                                        $color = '';
                                        if ($r->data_entrega <> '') {
                                            $data_entrega = date("d/m/Y", strtotime($r->data_entrega));
                                        } else {
                                            $data_entrega = "";
                                        }

                                        if ($r->data_reagendada <> '') {
                                            $data_reagendada = date("d/m/Y", strtotime($r->data_reagendada));
                                        } else {
                                            $data_reagendada = "";
                                        }

                                        if ($r->data_abertura <> '') {
                                            $data_abertura = date("d/m/Y", strtotime($r->data_abertura));
                                        } else {
                                            $data_abertura = "";
                                        }
                                        if($r->data_insert <> ''){
                                            $data_insert = date("d/m/Y", strtotime($r->data_insert));
                                        }else if($r->data_abertura_real <> ''){
                                            $data_insert = date("d/m/Y", strtotime($r->data_abertura_real));
                                        }else{
                                            $data_insert = "";
                                        }


                                        echo '<tr>';

                                        echo '<td><font size="1,8">' . $r->idOs . '</font></td>';
                                        echo '<td><font size="1">' . $r->nomeCliente . '</font></td>';
                                        echo '<td><font size="1">' . $r->qtd_os .' '.$r->descricaoTipoQtd. '</font></td>';
                                        echo '<td>' . $r->descricao_item . '</font></td>';
                                        $calc = $r->qtd_os * $r->val_unit_os - $r->desconto_os;
                                        $ipicalc = $r->val_ipi_os / 100 * $calc;
                                        $result = $calc + $ipicalc;
                                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {

                                            echo '<td><font size="1">' . number_format($result, 2, ",", ".") . '</td>';
                                        }

                                        echo '<td><font size="1">' . $r->nomeStatusOs . '</font></td>';
                                        echo '<td style="word-wrap:break-word; max-width:70px;"><font size="1">' . $r->pn . '</font></td>';
                                        echo '<td><font size="1">' . $data_insert . '</font></td>';
                                        echo '<td><font size="1">' . $data_abertura . '</font></td>';
                                        echo '<td><font size="1">' . $data_entrega . '</font></td>';
                                        echo '<td><font size="1">' . $data_reagendada . '</font></td>';
                                        echo '<td><font size="1">' . $r->status_execucao . '</font></td>';
                                        if ($r->statusDesenho == 3) {
                                            echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a></div></font></td>';
                                        } else if ($r->statusDesenho == 2) {
                                            echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a></div></font></td>';
                                        } else {
                                            echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a></div></font></td>';
                                        }
                                        
                                        

                                        echo '<td><font size="1">';
                                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                                            echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
                                        }
                                        echo '</font></td>';
                                    ?>


                                    <?php

                                        
                                        echo '<td><font size="1">';
                                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
                                            echo '<a href="' . base_url() . 'index.php/os/distribuiros/' . $r->idOs . '" style="margin-right: 1%" class="btn btn-info tip-top" ><i class="icon-shopping-cart"></i></a>';
                                        /**/}
                                        echo '</font></td>';
                                        echo '</tr>';
                                        $valor = $valor + $result;
                                    }
                                    ?><!--
                                    <tr>
                                        <td colspan='7' align='right'>
                                            
                                        </td>
                                    </tr>     -->                                                                              
                                </tbody>
                            </table>
                        </div>                                
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<div style="display:none">
    <div class="row-fluid" style="margin-top:0">
        <div class="span12" id="scrollIdtest" style="width: 100%; overflow-y: scroll;" onmousemove="scrollDetect(this,event)">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>OS</h5>
                    <h5>Legenda:</h5>
                    <div style="padding:8px">
                        Completo <a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>|
                        Incompleto <a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>|
                        Sem desenho <a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a>
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="span12" id="divCadastrarOs">                                
                            <div class="widget-box" style="margin-top:0px">                                        
                                <table id="fixed_table" class="table table-bordered ">
                                    <thead>
                                        <tr>

                                            <th>Nº OS</th>
                                            <th>Cliente</th>
                                            <th>QTD</th>
                                            <th>Descrição</th>

                                            <?php
                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                                            ?>

                                                <th>Valor</th>

                                            <?php
                                            }
                                            ?>
                                            <th>Status</th>
                                            <th>PN</th>
                                            <th>Data Criação</th>
                                            <th>Data OS</th>
                                            <th>Data entrega</th>
                                            <th>Data reagendada</th>
                                            <th>Unid. Exec.</th>
                                            <th>Desenho</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $valor = '';

                                        foreach ($results as $r) {
                                            $color = '';
                                            if ($r->data_entrega <> '') {
                                                $data_entrega = date("d/m/Y", strtotime($r->data_entrega));
                                            } else {
                                                $data_entrega = "";
                                            }

                                            if ($r->data_reagendada <> '') {
                                                $data_reagendada = date("d/m/Y", strtotime($r->data_reagendada));
                                            } else {
                                                $data_reagendada = "";
                                            }

                                            if ($r->data_abertura <> '') {
                                                $data_abertura = date("d/m/Y", strtotime($r->data_abertura));
                                            } else {
                                                $data_abertura = "";
                                            }
                                            if($r->data_insert <> ''){
                                                $data_insert = date("d/m/Y", strtotime($r->data_insert));
                                            }else if($r->data_abertura_real <> ''){
                                                $data_insert = date("d/m/Y", strtotime($r->data_abertura_real));
                                            }else{
                                                $data_insert = "";
                                            }


                                            echo '<tr>';

                                            echo '<td><font size="1,8">' . $r->idOs . '</font></td>';
                                            echo '<td><font size="1">' . $r->nomeCliente . '</font></td>';
                                            echo '<td><font size="1">' . $r->qtd_os .' '.$r->descricaoTipoQtd. '</font></td>';
                                            echo '<td>' . $r->descricao_item . '</font></td>';
                                            $calc = $r->qtd_os * $r->val_unit_os - $r->desconto_os;
                                            $ipicalc = $r->val_ipi_os / 100 * $calc;
                                            $result = $calc + $ipicalc;
                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {

                                                echo '<td><font size="1">' . number_format($result, 2, ",", ".") . '</td>';
                                            }

                                            echo '<td><font size="1">' . $r->nomeStatusOs . '</font></td>';
                                            echo '<td style="word-wrap:break-word; max-width:70px;"><font size="1">' . $r->pn . '</font></td>';
                                            echo '<td><font size="1">' . $data_insert . '</font></td>';
                                            echo '<td><font size="1">' . $data_abertura . '</font></td>';
                                            echo '<td><font size="1">' . $data_entrega . '</font></td>';
                                            echo '<td><font size="1">' . $data_reagendada . '</font></td>';
                                            echo '<td><font size="1">' . $r->status_execucao . '</font></td>';
                                            if ($r->statusDesenho == 3) {
                                                echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a></div></font></td>';
                                            } else if ($r->statusDesenho == 2) {
                                                echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a></div></font></td>';
                                            } else {
                                                echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a></div></font></td>';
                                            }
                                            
                                            

                                        ?>


                                        <?php

                                            
                                        
                                            echo '</tr>';
                                            $valor = $valor + $result;
                                        }
                                        ?><!--
                                        <tr>
                                            <td colspan='7' align='right'>
                                                
                                            </td>
                                        </tr>     -->                                                                              
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

<script type="text/javascript">
    ok = false;

    function CheckAll2() {
        if (!ok) {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'idStatusOs[]') {
                    x.checked = true;
                    ok = true;
                }
            }
        } else {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'idStatusOs[]') {
                    x.checked = false;
                    ok = false;
                }
            }
        }
    }

    $(function() {
        $(".export-csv").on('click', function(event) {
            // CSV
            var filename = $(".export-csv").data("filename")
            var args = [$('#fixed_table'), filename + ".csv", 0];
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

                $(this)
                    .attr({
                        'download': filename,
                        'href': csvData,
                        'target': '_blank'
                    });
            }
        }

    });
    $(document).ready(function() {
        $("#imprimir").click(function() {
            PrintElem('#divCadastrarOs');
        })

        function PrintElem(elem) {
            Popup($(elem).html());
        }

        function Popup(data) {
            var mywindow = window.open('', 'SGI', 'height=600,width=800');
            mywindow.document.write('<html><head><title>SGI</title><meta charset="UTF-8" />');
            /* mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/bootstrap.min.css' /><link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css' />");*/
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/tableimprimir.css' />");
            mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />');
            mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />');
            mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />');
            mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />');
            mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />');


            mywindow.document.write('</head><body >');
            mywindow.document.write(data);
            mywindow.document.write('</body></html>');
            
            /*
            setTimeout(function(){
                executarPrint(mywindow)}
            , 1000);*/
            mywindow.print();
            
            //mywindow.close();

            return true;
        }
        function executarPrint(objeto){
            objeto.print()
        }
    })
</script>