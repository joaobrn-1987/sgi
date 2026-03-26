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
                            <form action="<?php echo base_url() ?>index.php/relatorios/relvendas/pesquisa" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">                                        
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Data Abertura: </label>
                                            <input type="text" class="span5 datap" value="<?php echo $data_inicial?>"  name="data_inicial" id="data_inicio" placeholder="Inicio"/> a
                                            <input type="text" class="span5 datap" value="<?php echo $data_final?>"  name="data_final" id="data_fim" placeholder="Fim"/>
                                        </div>
                                        <div class="span9" style="padding: 1%; margin-left:0">
                                            <label for="idGrupoServico" class="control-label">Vendedor: </label>
                                            <?php  $i=0;
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
<ul class="nav nav-tabs" style="margin-top:20px" id="myTab">
    <li><a href="#tab1" data-toggle="tab">OS</a></li>
    <li><a href="#tab2" data-toggle="tab">Clientes/Vendedores</a></li><!--
    <li><a href="#tab3" data-toggle="tab">Vendedores</a></li>-->
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab1" >
        
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box" style="margin-top:0px">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Relatório de Vendas - O.S.</h5>
                        <div class="buttons" align='center' >
                            <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse"  href=""><i class="icon-print icon-white"></i> Imprimir</a>
                            <a href=javascript:; class="export-csv2 btn btn-mini btn-inverse" tabela="imprimirTable" data-filename="Relelatorio_vendas_OS" id="btnExport">Excel</a>
                            <a href=javascript:; class="export-csv btn btn-mini btn-inverse" tabela="table" data-filename="Relelatorio_vendas_OS">CSV - Excel</a>
                        </div>
                    </div>
                    
                    <div class="widget-content nopadding"  id="imprimirTable">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">                                
                                        <div class="widget-box" style="margin-top:0px">                                        
                                            <table id="table" class="table table-bordered ">
                                                <thead>
                                                    <tr>
                                                        <th>O.S.</th>
                                                        <th>Clientes</th>
                                                        <th>Vendedor</th>
                                                        <th>Data O.S.</th>                                                
                                                        <th>Item -Descrição</th> 
                                                        <th>Valor</th>
                                                        <th>Data Ent</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $totalOs = 0;
                                                        foreach($result as $r){
                                                            $totalOs += $r->valorOs;
                                                            echo '<tr>'.
                                                                '<td>'.$r->idOs.'</td>'.
                                                                '<td>'.$r->nomeCliente.'</td>'.
                                                                '<td>'.$r->nomeVendedor.'</td>'. 
                                                                '<td>'.(!empty($r->data_abertura)?(new DateTime( $r->data_abertura ))-> format( 'd/m/Y' ):"").'</td>'.
                                                                '<td>'.$r->descricao_item.'</td>'.
                                                                '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div>'.number_format($r->valorOs,2,",",".").'</td>'.
                                                                '<td>'.(!empty($r->data_reagendada)?(new DateTime( $r->data_reagendada))-> format( 'd/m/Y' ):(!empty($r->data_entrega)?(new DateTime( $r->data_entrega))-> format( 'd/m/Y' ):"")).'</td>'.
                                                            '</tr>';
                                                        }
                                                        
                                                    ?>                                                
                                                    <tr>
                                                        <td colspan="7"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">Total: </td>
                                                        <td style="text-align:right;min-width: 130px"><div style="text-align:left" class="span1">R$</div><?php echo number_format($totalOs,2,",",".")?></td>
                                                        <td></td>
                                                    </tr>                                                                              
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
    <div class="tab-pane" id="tab2">
        <div class="row-fluid" style="margin-top:0">
            <!-- clientes -->
            <div class="span6">
                <div class="widget-box" style="margin-top:0px">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Relatório de Vendas - Clientes</h5>
                        <div class="buttons" align='center' >
                            <a id="imprimir2" title="Imprimir" class="btn btn-mini btn-inverse"  href=""><i class="icon-print icon-white"></i> Imprimir</a>
                            <a href=javascript:; class="export-csv2 btn btn-mini btn-inverse" tabela="imprimirTable2" data-filename="Relelatorio_vendas_clientes" id="btnExport">Excel</a>
                            <a href=javascript:; class="export-csv btn btn-mini btn-inverse" tabela="table2" data-filename="Relelatorio_vendas_clientes">CSV - Excel</a>
                        </div>
                    </div>
                    <div class="widget-content nopadding" id="imprimirTable2">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">                                
                                        <div class="widget-box" style="margin-top:0px">                                        
                                            <table id="table2" class="table table-bordered ">
                                                <thead>
                                                    <tr>
                                                        <th>Vendedor</th>
                                                        <th>Cliente</th>
                                                        <th>Valor Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
                                                    <?php 
                                                        $totalClientes = 0;
                                                        foreach($result_cliente as $r){
                                                            $totalClientes += $r->total;
                                                            echo '<tr>'.
                                                                '<td>'.$r->nomeVendedor.'</td>'.
                                                                '<td>'.$r->nomeCliente.'</td>'.
                                                                '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div>'.number_format($r->total,2,",",".").'</td>'.                                                                
                                                            '</tr>';
                                                        }
                                                        
                                                    ?>                                                    
                                                    <tr>
                                                        <td colspan="3"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Total: </td>
                                                        <td style="text-align:right;min-width: 130px"><div style="text-align:left" class="span1">R$</div><?php echo number_format($totalClientes,2,",",".")?></td>
                                                    </tr>                                                                              
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
            <!-- Vendedores -->
            <div class="span6">
                <div class="widget-box" style="margin-top:0px">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Relatório de Vendas - Vendedores</h5>
                        <div class="buttons" align='center' >
                            <a id="imprimir3" title="Imprimir" class="btn btn-mini btn-inverse"  href=""><i class="icon-print icon-white"></i> Imprimir</a>
                            <a href=javascript:; class="export-csv2 btn btn-mini btn-inverse" tabela="imprimirTable3" data-filename="Relelatorio_vendas_vendedores" id="btnExport">Excel</a>
                            <a href=javascript:; class="export-csv btn btn-mini btn-inverse" tabela="table3" data-filename="Relelatorio_vendas_vendedores">CSV - Excel</a>
                        </div>
                    </div>
                    <div class="widget-content nopadding" id="imprimirTable3">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">                                
                                        <div class="widget-box" style="margin-top:0px">                                        
                                            <table id="table3" class="table table-bordered ">
                                                <thead>
                                                    <tr>
                                                        <th>Vendedores</th>
                                                        <th>Valor Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
                                                    <?php 
                                                        $totalVendedores = 0;
                                                        foreach($result_vendedor as $r){
                                                            $totalVendedores += $r->total;
                                                            echo '<tr>'.
                                                                '<td>'.$r->nomeVendedor.'</td>'.
                                                                '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div>'.number_format($r->total,2,",",".").'</td>'.                                                                
                                                            '</tr>';
                                                        }
                                                        
                                                    ?>                                                    
                                                    <tr>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total: </td>
                                                        <td style="text-align:right;min-width: 130px"><div style="text-align:left" class="span1">R$</div><?php echo number_format($totalVendedores,2,",",".")?></td>
                                                    </tr>                                                                        
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
    <div class="tab-pane" id="tab3">

    </div>
</div>

<script type="text/javascript">
    $('.datap').inputmask("date", {
        inputFormat: "dd/mm/yyyy",
        placeholder: "DD/MM/AAAA"
    });
    $(document).ready(function() {
        $(".datap").datepicker({
            dateFormat: 'dd/mm/yy',
            language: 'pt-BR',
            locale: 'pt-BR'
        });
    })
    
    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('click', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }else{
            $('#myTab a[href="#tab1"]').tab('show');
        }
    });

    $(".export-csv2").click(function(e) {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById($(this).attr("tabela"));
        var mywindow = window.open('', 'SGI', 'height=600,width=800');
        mywindow.document.write('<html><head><title>SGI</title><meta charset="UTF-8" />')
        mywindow.document.write('</head><body >');
        mywindow.document.write("<style type='text/css'>"+
            "table {"+
            "margin: 0 auto;"+
            "}"+
            "table {"+
                "color: #333;"+
                "background: white;"+
                "border: 1px solid grey;"+
                "font-size: 12pt;"+
                "border-collapse: collapse;"+
                "}"+
                "table thead th,"+
                "table tfoot th {"+
            " color: #777;"+
            "background: rgba(0,0,0,.1);"+
            "}"+
            "table caption {"+
                "padding:.5em;"+
                "}"+
                "table th,"+
                "table td {"+
                    "padding: .5em;"+
                    "border: 1px solid lightgrey;"+
                    "}"+

                    "[data-table-theme*=zebra] tbody tr:nth-of-type(odd) {"+
                        "background: rgba(0,0,0,.05);"+
                        "}"+
                        "[data-table-theme*=zebra][data-table-theme*=dark] tbody tr:nth-of-type(odd) {"+
                            "background: rgba(255,255,255,.05);"+
                            "}"+

                            "[data-table-theme*=dark] {"+
                                "color: #ddd;"+
                                " background: #333;"+
                                "font-size: 12pt;"+
                                "border-collapse: collapse;"+
                                "}"+
                                "[data-table-theme*=dark] thead th,"+
                                "[data-table-theme*=dark] tfoot th {"+
                                    "color: #aaa;"+
                                    "background: rgba(0255,255,255,.15);"+
                                    "}"+
                                    "[data-table-theme*=dark] caption {"+
                                        "padding:.5em;"+
                                        "}"+
                                        "[data-table-theme*=dark] th,"+
                                        "[data-table-theme*=dark] td {"+
                                            "padding: .5em;"+
                                            "border: 1px solid grey;"+
                                            "}</style>");
        //var table_html = table_div.outerHTML.replace(/ /g, '%20');
        var table_html = table_div.outerHTML;
        
        mywindow.document.write(table_html);
        mywindow.document.write('</body></html>');
        a.href = data_type + ', ' + encodeURIComponent(mywindow.document.firstElementChild.innerHTML.replaceAll('<div style="text-align:left" class="span1">R$</div>','<div style="text-align:left" class="span1"></div>'));
        console.log(data_type + ', ' + table_html)
        a.download = $(this).data("filename")+'.xls';
        a.click();
        mywindow.close();
        e.preventDefault();
        
    });
    
    $(document).ready(function() {/**/
        $("#imprimir").click(function() {
            PrintElem('#imprimirTable');
        })
        $("#imprimir2").click(function() {
            PrintElem('#imprimirTable2');
        })
        
        $("#imprimir3").click(function() {
            PrintElem('#imprimirTable3');
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
            mywindow.document.write(data.replaceAll('<div style="text-align:left" class="span1">R$</div>',"R$ "));
            mywindow.document.write('</body></html>');

            mywindow.print();
            //mywindow.close();

            return true;
        }

    });
    $(function() {
        $(".export-csv").on('click', function(event) {
            // CSV
            var filename = $(this).data("filename")
            var args = [$('#'+$(this).attr("tabela")), filename + ".csv", 0];
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

</script>