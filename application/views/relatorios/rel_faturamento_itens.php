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
                            <form action="<?php echo base_url() ?>index.php/relatorios/relfaturamentoitens" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Unidade Exec.: </label><!--
                                            <input type="text" class="span12" value=""  name="idOrcamento"/> -->
                                            <?php foreach ($unid_exec as $exec) { ?>
                                                <input type="checkbox" name="unid_execucao[]" class='check' value="<?php echo $exec->id_unid_exec; ?>"> &nbsp;<?php echo $exec->status_execucao; ?>
                                            <?php } ?>
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Cliente: </label>
                                            <input type="text" class="span12" value=""  name="cliente" id="cliente"/>
                                            <input type="hidden" class="span12" value=""  name="idCliente" id="idCliente"/>
                                        </div>
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Vendedor: </label>
                                            <select class="span12 form-control" name="idVendedor">
                                                <option value="">Todos</option>
                                                <?php foreach ($vendedores as $v) { ?>

                                                    <option value="<?php echo $v->idVendedor; ?>" <?php if ($v->idVendedor == 1) {
                                                                                                        //echo "selected='selected'";
                                                                                                    } ?>><?php echo $v->nomeVendedor; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Periodo: </label>
                                            <input type="text" class="span5 datap" value=""  name="data_inicio" id="data_inicio" placeholder="Inicio"/> a
                                            <input type="text" class="span5 datap" value=""  name="data_fim" id="data_fim" placeholder="Fim"/>
                                        </div>
                                        <div class="span2">
                                            <label for="idGrupoServico" class="control-label">Contrato: </label> 
                                            <select class="span12 form-control" name="contrato">
                                                <option value="">Todos</option>
                                                <option value="Sim">Sim</option>
                                                <option value="Não">Não</option>
                                            </select>
                                        </div>
                                        <div class="span1">
                                            <label for="idGrupoServico" class="control-label">Encerrado: </label> 
                                            <select class="span12 form-control" name="encerrado">
                                                <option value="Sim">Sim</option>
                                                <option selected value="">Não</option>
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

<div class="buttons" align='center' style="margin-top:15px">
    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
    <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Rel-Orcamento" id="btnExport">Excel</a>
</div>

<div id="imprimirTable">
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Histórico faturamento</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs">                                
                                    <div class="widget-box" style="margin-top:0px">   
                                        <?php 
                                            $valor = array(array());
                                            $linha = 1;
                                            $coluna = 1;
                                            $valor[0][0] = "CONTRATO";

                                            $valor2 = array(array());
                                            $linha2 = 1;
                                            $coluna2 = 1;
                                            $valor2[0][0] = "CONTRATO";

                                            $valor3 = array(array());
                                            $linha3 = 1;
                                            $coluna3 = 1;
                                            $valor3[0][0] = "CONTRATO";

                                            $totalOrc = 0;
                                            $totalOS = 0;
                                            $totalInsumo = 0;
                                        ?>
                                        <table id="tableHistVale" class="table table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>Data Fat.</th>
                                                    <th>O.S.</th>
                                                    <th>Unid. exec.</th>
                                                    <th>Contrato.</th>
                                                    <th>Descrição</th>
                                                    <th>Cliente</th>
                                                    <th>Valor Orç</th>
                                                    <th>Valor O.S.</th>
                                                    <th>Descrição (Insumo/MP)</th>
                                                    <th>Quantidade (Insumo/MP)</th>
                                                    <th>Valor Unit. (Insumo/MP)</th>
                                                    <th>Valor Total (Insumo/MP)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $osAtual=0;
                                                    foreach($listOs as $r){
                                                        echo '<tr>';
                                                            $date = new DateTime( $r->data_faturado );

                                                            echo '<td>'.$date-> format( 'd/m/Y' ).'</td>';
                                                            echo '<td>'.$r->idOs.'</td>';
                                                            echo '<td>'.$r->status_execucao.'</td>';
                                                            echo '<td>'.$r->contrato.'</td>';
                                                            echo '<td>'.$r->descricao_item.'</td>';
                                                            echo '<td>'.$r->nomeCliente.'</td>';
                                                            echo '<td style="text-align:right"><div style="text-align:left" class="span1">'.($osAtual!=$r->idOs?"R$":"").'</div><spam >'.($osAtual!=$r->idOs?number_format($r->valorOrc,2,",","."):'').'</spam></td>';
                                                            echo '<td style="text-align:right"><div style="text-align:left" class="span1">'.($osAtual!=$r->idOs?"R$":"").'</div>'.($osAtual!=$r->idOs?number_format($r->valorOS,2,",","."):'').'</td>';
                                                            echo '<td>'.$r->descricao_insumo.'</td>';
                                                            echo '<td>'.$r->qtd_insumo.'</td>';
                                                            echo '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div>'.number_format($r->val_unit_ins,2,",",".").'</td>';
                                                            echo '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div>'.number_format($r->val_total_ins,2,",",".").'</td>';
                                                        echo '</tr>';
                                                        if($osAtual!=$r->idOs){
                                                            $totalOS += $r->valorOS;
                                                            $totalOrc += $r->valorOrc;
                                                            $osAtual = $r->idOs;
                                                        }
                                                        $totalInsumo += $r->val_total_ins;
                                                    }
                                                ?>
                                                <tr>
                                                    <td colspan="11"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Total:</td>
                                                    <td >R$<?php echo number_format($totalOrc,2,",",".");?></td>
                                                    <td >R$<?php echo number_format($totalOS,2,",",".");?></td>
                                                    <td colspan="3"></td>
                                                    <td>R$</br><?php echo number_format($totalInsumo,2,",",".");?></td>
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
    $(document).ready(function() {
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteCliente2",
            minLength: 1,
            select: function(event, ui) {
                $("#idCliente").val(ui.item.id);
            }
        });
    });
    /*
    $("#btnExport").click(function(e) {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('imprimirTable');
        
        $(table_div).prepend("<meta charset='UTF-8' /><style type='text/css'>"+
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
        var table_html = encodeURIComponent(table_div.outerHTML.replaceAll('<div style="text-align:left" class="span1">R$</div>',""));
        a.href = data_type + ', ' + table_html;
        console.log(data_type + ', ' + table_html)
        a.download = 'filename.xls';
        a.click();
        e.preventDefault();
    });*/
    
    $("#btnExport").click(function(e) {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('imprimirTable');
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
        var table_html = table_div.outerHTML.replaceAll('<div style="text-align:left" class="span1">R$</div>',"");
        
        mywindow.document.write(table_html);
        mywindow.document.write('</body></html>');
        a.href = data_type + ', ' + encodeURIComponent(mywindow.document.firstChild.outerHTML);
        console.log(data_type + ', ' + table_html)
        a.download = 'filename.xls';
        a.click();
        mywindow.close();
        e.preventDefault();
        
    });
    
    $(document).ready(function() {
        $("#imprimir").click(function() {
            PrintElem('#imprimirTable');
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

            mywindow.print();
            //mywindow.close();

            return true;
        }

    });
</script>