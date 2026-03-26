<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tableimprimir.css" />

<?php
$data_atual = date('d/m/Y');
if (!$results) {

?>


    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>OS</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>

                        <td align='center'>Orç.</td>

                        <td align='center'>Data Orc.</td>
                        <td align='center'>Vencimento</td>
                        <td align='center'>Cliente</td>
                        <td align='center'>Vendedor</td>
                        <?php
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                        ?>
                            <td align='center'>Total</td>
                        <?php
                        }
                        ?>
                        <td align='center'>Status</td>
                        <td align='center'>Descrição</td>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhuma OS Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php } else {

$data_inicial = $data_entrega["data_ini"];

$data_atual = $data_entrega["data_final"];

$data_atual_sistem = date('d/m/Y H:i:s');
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

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">

                                <div class="span12" id="divCadastrarOs">

                                    <form class="form-inline" action="<?php echo base_url() ?>index.php/relatorios/rel_orcamento_itens" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">




                                        <div class="span12" style="padding: 1%; margin-left: 0">

                                            <div class="span3" class="control-group">
                                                <label for="idOrcamentos" class="control-label">Cod. Orc.:</label>
                                                <input class="span12 form-control" type="text" name="idOrcamentos" value="" class="span12">
                                            </div>
                                            <div class="span3" class="control-group">
                                                Referência: <input id="referencia" type="text" name="referencia" value="" />
                                            </div>
                                            <div class="span3" class="control-group">
                                                Num. Pedido:<input id="num_pedido" type="text" name="num_pedido" value="" />
                                            </div>
                                            <div class="span3" class="control-group">
                                                Num. Nota Fiscal:<input id="num_nf" type="text" name="num_nf" value="" />
                                            </div>
                                            <!-- <div class="span1" class="control-group">
                                            <label for="cliente" class="control-label">Cliente:</label>
                      <input class="span12" class="span12 form-control" id="cliente"  type="text" name="cliente" value=""  />
		<input id="clientes_id"  type="hidden" name="clientes_id" value=""  />
                                        </div>-->






                                        </div>

                                        <div class="span12" style="padding: 1%; margin-left: 0">




                                            <div class="span6" class="control-group">
                                                <label for="numpedido_os" class="control-label">Data cadastro:</label><br>

                                                De: <input id="dataInicialcad" class="data" type="text" name="dataInicialcad" value="<?php echo $data_inicial; ?>" /> | Até:<input id="dataFinalcad" class="data" type="text" name="dataFinalcad" value="<?php echo $data_atual; ?>" />
                                            </div>
                                            <div class="span6" class="control-group">
                                                <label for="num_pedido" class="control-label">PN:</label>
                                                <input type="hidden" id="idProdutos" name="idProdutos" size="3" value="" />
                                                <input id="pn" class="span12" type="text" name="pn" value="" ref="autocomplete" />
                                            </div>
                                            <!--<div class="span6" class="control-group">
									   Status:<select class="form-control" name="status_orc">
                        <option value=""></option>
                        
                        <option value="0">Ativo</option>
                        <option value="1">Excluido</option>
                       
                       
                        </select>	
									</div>	-->
                                        </div>
                                        <div class="span12" style="padding: 1%; margin-left: 0">

                                            <div class="span5">
                                                <label for="cliente" class="control-label">Cliente:</label>
                                                <div style="overflow: auto; width: 1000px; height: 200px; border:solid 0px">
                                                    <table>
                                                        <tr>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($dados_clientes as $cli) {

                                                            ?>
                                                                <td>
                                                                    <input type="checkbox" name="clientes_id[]" value="<?php echo $cli->idClientes; ?>"> <?php echo $cli->nomeCliente; ?>
                                                                </td>
                                                            <?php
                                                                if ($i % 2) {
                                                                    echo "</tr><tr>";
                                                                }
                                                                $i++;
                                                            }
                                                            ?>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>




                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span12" class="control-group">
                                                Nat. Operação:
                                                <table width='100%'>
                                                    <tr>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($dados_natoperacao as $nt) {
                                                        ?>
                                                            <td>
                                                                <input type="checkbox" name="idNatOperacao[]" class='check' value="<?php echo $nt->idNatOperacao; ?>"> &nbsp;<?php echo $nt->nome; ?>
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
                                            <div class="span12" class="control-group">
                                                Grupo Serviço:

                                                <table width='100%'>
                                                    <tr>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($dados_gruposervico as $gs) {
                                                        ?>
                                                            <td>
                                                                <input type="checkbox" name="idGrupoServico[]" class='check' value="<?php echo $gs->idGrupoServico; ?>"> &nbsp;<?php echo $gs->nome; ?>
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
                                            <div class="span12" class="control-group">


                                                Status Orçamento:
                                                <table width='100%'>
                                                    <tr>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($dados_statusorcamento as $o) {
                                                        ?>
                                                            <td>
                                                                <input type="checkbox" name="idstatusOrcamento[]" class='check' value="<?php echo $o->idstatusOrcamento; ?>"> &nbsp;<?php echo $o->nome_status_orc; ?>
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
                                        <div class="span12" style="padding: 1%; margin-left:0">
                                            <label for="idGrupoServico" class="control-label">Vendedor: </label>
                                            <?php 
                                            foreach ($dados_vendedor as $for) {

                                                ?>
                                                <td>
                                                


                                                    <input type="checkbox" name="idVendedores[]" <?php if(isset($idVendedores)){foreach($idVendedores as $r){if($r == $for->idVendedor){echo 'checked';}}} ?> value="<?php echo $for->idVendedor; ?>"> <?php echo $for->nomeVendedor; ?>
                                                </td>
                                                <?php
                                                if ($i == 1){
                                                    echo "</tr><tr>";
                                                    $i=0;
                                                }
                                                $i++;
                                            }?>
                                        </div>


                                        <div class="span12" style="padding: 1%; margin-left: 0">

                                            <div class="span12" class="control-group">
                                                <br>

                                                <input class="btn btn-default" type="submit" name="filter" value="Filtrar">
                                            </div>

                                        </div>



                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>


                    .

                </div>

            </div>
        </div>
    </div>








    <div class="widget-box"><!--
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Orçamento</h5>

        </div> -->
        <div class="buttons">

            <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
            <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Rel-Orcamento">Excel</a>
        </div>
        <div class="widget-content nopadding" id="printOs" style="display:none">


            <table style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	            font-size:10px;" border="1" width='100%' id="fixed_table">

                <tr>
                    <td colspan='13' align='center'>
                        RELATÓRIO CARTEIRA DE ORÇAMENTO
                    </td>
                </tr>
                
                <tr>


                    <td align='center'>Orç.</td>

                    <td align='center'>Data Orc.</td>
                    <td align='center'>Vencimento</td>
                    <td align='center'>Cliente</td>
                    <td align='center'>Vendedor</td>
                    <?php
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                    ?>
                        <td align='center'>Total</td>
                    <?php
                    }
                    ?>
                    <td align='center'>Status</td>
                    <td align='center'>O.S.</td>
                    <td align='center'>PN</td>
                    <td align='center'>Descrição</td>
                    <td align='center'>Qtd.</td>
                    <td align='center'>Nat. Ope.</td>
                    <td align='center'>Grupo Serv.</td>

                </tr>


                <?php
                $totalos = 0;
                $somatorio = 0;

                $ultimoorc = 0;
                foreach ($results as $r) {
                    $color = '';

                    $orca_item = $this->relatorios_model->tabela('orcamento_item', 'idOrcamentos =' . $r->idOrcamentos);



                    $desc_banco = '';
                    $valor_orc = 0;
                    $count = 1;
                    


                    $data_cad = date("Y/m/d", strtotime($r->data_abertura));

                    $vencimento = date('d/m/Y', strtotime('+' . $r->validade . ' days', strtotime($data_cad)));


                    echo '<tr>';

                    echo '<td align="center">' . $r->idOrcamentos . '</td>';


                    echo '<td align="center">' . date("d/m/Y", strtotime($r->data_abertura)) . '</td>';
                    echo '<td align="right">' . $vencimento . '</td>';
                    echo '<td>' . $r->nomeCliente . '</td>';
                    echo '<td>' . $r->nomeVendedor . '</td>';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {

                        echo '<td align="right">' . number_format($r->valor_total, 2, ",", ".") . '</td>';
                    }
                    if (!empty($r->motivo)) {
                        $motivo = " Motivo: " . $r->motivo;
                    } else {
                        $motivo = '';
                    }
                    echo '<td>' . $r->nome_status_orc . $motivo . '</td>';


                    echo '<td>' . $r->idOs . '</td>';
                    echo '<td>' . $r->pn . '</td>';
                    echo '<td>' . $r->descricao_item . '</td>';
                    echo '<td>' . $r->qtd . '</td>';

                    echo '<td>' . $r->nomenat . '</td>';
                    echo '<td>' . $r->nomeserv . '</td>';




                    $somatorio = $somatorio + $valor_orc;

                    echo '</tr>';

                    if ($ultimoorc <> $r->idOrcamentos) {

                        $totalos++;
                    }

                    $ultimoorc = $r->idOrcamentos;
                }
                ?>

                <tr>
                    <?php
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                    ?>
                        <td colspan='5' align='right'>
                            Total:
                        </td>
                        <td>
                            <?php

                            echo number_format($somatorio, 2, ",", ".");

                            ?>
                        </td>
                    <?php
                    }
                    ?>
                    <td colspan='13' align='right'>Total de Orçamento: <?php echo $totalos; ?></td>
                </tr>

            </table>



        </div>
        <div class="widget-content nopadding">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Orçamentos</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table id="rel_table" class="table table-bordered ">
                                                    <thead>
                                                        <tr>


                                                            <td align='center'>Orç.</td>

                                                            <td align='center'>Data Orc.</td>
                                                            <td align='center'>Vencimento</td>
                                                            <td align='center'>Cliente</td>
                                                            <td align='center'>Vendedor</td>
                                                            <?php
                                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                                                            ?>
                                                                <td align='center'>Total</td>
                                                            <?php
                                                            }
                                                            ?>
                                                            <td align='center'>Status</td>
                                                            <td align='center'>O.S.</td>
                                                            <td align='center'>PN</td>
                                                            <td align='center'>Descrição</td>
                                                            <td align='center'>Qtd.</td>
                                                            <td align='center'>Nat. Ope.</td>
                                                            <td align='center'>Grupo Serv.</td>

                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                    
                                                        <?php
                                                        $totalos = 0;
                                                        $somatorio = 0;

                                                        $ultimoorc = 0;
                                                        foreach ($results as $r) {
                                                            $color = '';
                                                            $desc_banco = '';
                                                            $valor_orc = 0;
                                                            $count = 1;
                                                            


                                                            $data_cad = date("Y/m/d", strtotime($r->data_abertura));

                                                            $vencimento = date('d/m/Y', strtotime('+' . $r->validade . ' days', strtotime($data_cad)));


                                                            echo '<tr>';

                                                            echo '<td align="center">' . $r->idOrcamentos . '</td>';


                                                            echo '<td align="center">' . date("d/m/Y", strtotime($r->data_abertura)) . '</td>';
                                                            echo '<td align="right">' . $vencimento . '</td>';
                                                            echo '<td>' . $r->nomeCliente . '</td>';
                                                            echo '<td>' . $r->nomeVendedor . '</td>';
                                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {

                                                                echo '<td align="right">' . number_format($r->valor_total, 2, ",", ".") . '</td>';
                                                            }
                                                            if (!empty($r->motivo)) {
                                                                $motivo = " Motivo: " . $r->motivo;
                                                            } else {
                                                                $motivo = '';
                                                            }
                                                            echo '<td>' . $r->nome_status_orc . $motivo . '</td>';


                                                            //echo '<td>'.$desc_banco.$rest.'</td>';
                                                            echo '<td>' . $r->idOs . '</td>';
                                                            echo '<td>' . $r->pn . '</td>';
                                                            echo '<td>' . $r->descricao_item . '</td>';
                                                            echo '<td>' . $r->qtd . '</td>';

                                                            echo '<td>' . $r->nomenat . '</td>';
                                                            echo '<td>' . $r->nomeserv . '</td>';




                                                            $somatorio = $somatorio + $valor_orc;

                                                            echo '</tr>';

                                                            if ($ultimoorc <> $r->idOrcamentos) {

                                                                $totalos++;
                                                            }

                                                            $ultimoorc = $r->idOrcamentos;
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
        <?php
        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
        ?>
            <div>

            </div>
        <?php
        }
        ?>



    </div>
<?php echo $this->pagination->create_links();
} ?>








<script type="text/javascript">
    $(document).ready(function() {

        jQuery(".data").mask("99/99/9999");
    });

    $(document).ready(function() {



        $(document).on('click', 'a', function(event) {

            var orc = $(this).attr('orc');
            $('#idorc').val(orc);

        });


        $(document).on('click', 'a', function(event) {

            var orc2 = $(this).attr('orc2');
            $('#idorc2').val(orc2);

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
    console.log('#idProdutos');
    $("#pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
        minLength: 1,
        select: function(event, ui) {
            $('#idProdutos').val(ui.item.id);

        }
    });
</script>
<script>
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
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#imprimir").click(function() {
            PrintElem('#printOs');
        })

        function PrintElem(elem) {
            Popup($(elem).html());
        }

        function Popup(data) {
            var mywindow = window.open('', 'SGI', 'height=600,width=800');
            mywindow.document.write('<html><head><title>SGI</title>');
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

    });/*
    $(document).ready(function () {
      tabelaSaida = $('#rel_table').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "order": [[ 0, "desc" ]],
            "paging": true,//Dont want paging                
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
        
    } );*/
</script>