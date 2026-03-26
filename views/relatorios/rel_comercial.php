<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
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
                            <form  action="<?php echo base_url() ?>index.php/relatorios/relcomercial/1" method="post" name="form1" id="form1">
                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Data de Orçamento: </label>
                                            <input class="span5 datap" type="text" name="dataOrcInicial" 'class="" value="" placeholder="Inicio"/> - <input class="span5 datap" type="text" name="dataOrcFinal"  value="" placeholder="Fim" />
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Data de Abertura O.S. </label>
                                            <input class="span5 datap" type="text" name="dataAberInicial" 'class="" value="" placeholder="Inicio"/> - <input class="span5 datap" type="text" name="dataAberFinal"  value="" placeholder="Fim" />
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Data de Faturamento </label>
                                            <input class="span5 datap" type="text" name="dataFatInicial" 'class="" value="" placeholder="Inicio"/> - <input class="span5 data" type="text" name="dataFatFinal"  value="" placeholder="Fim" />
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Data de Entrega</label>
                                            <input class="span5 datap" type="text" name="dataEntrInicial" 'class="" value="" placeholder="Inicio"/> - <input class="span5 data" type="text" name="dataEntrFinal"  value="" placeholder="Fim" />
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3" class="control-group">
                                            <label for="idOs" class="control-label">Por:</label></br>
                                            <table>
                                                <tr>      
                                                    <td>
                                                        <input type="checkbox" id='checkVendedores' name="agrupar[]" class='check' value="vendedores" > &nbsp;Vendedor
                                                    </td>                                          
                                                    <td>
                                                        <input type="checkbox" id='checkClientes' name="agrupar[]" class='check' value="clientes" > &nbsp;Clientes
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id='checkOs' name="agrupar[]" class='check' value="os" > &nbsp;O.S.
                                                    </td><!--
                                                    <td>
                                                        <input type="checkbox" id='checkOrc' name="agrupar[]" class='check' value="orc" > &nbsp;Orç.
                                                    </td>-->
                                                </tr>
                                                <tr>                                                
                                                    <td>
                                                        <input type="checkbox" id='checkStatusOs' name="agrupar[]" class='check' value="statusOs" > &nbsp;Status O.S.
                                                    </td>
                                                </tr><!--
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" id='checkCategorias' name="agrupar[]" class='check' value="categorias" > &nbsp;Categoria
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id='checkInsumos' name="agrupar[]" class='check' value="insumos" > &nbsp;Insumos
                                                    </td>
                                                </tr>-->
                                            </table>
                                        </div>
                                        <div class="span2" class="control-group" style="display:none; " id="divOS">
                                            <label for="idOs" class="control-label">OS - (Separe as O.S. com vírgulas)</label></br>
                                            <input  type="text" name="listOs" class="span12" value="<?php if(isset($listOs)){echo $listOs;} ?>"/>
                                        </div>
                                        <div class="span2" class="control-group" style="padding-left:30px">
                                           
                                            <button href="#" onClick="document.getElementById('form1').submit();" style=" border: 0px;margin-top: 28px;"><i class="icon-search" style="font-size:30px; float: right; "></i></button>
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span4" style="display:none; border: 1px solid #ccc; padding: 5px 0px 0px 5px;" id="divClientes">
                                            <label for="fornecedor" class="control-label">Clientes:</label>
                                            <div  id="adm">
                                                <div class="card card-body" style="overflow: scroll;height: 300px">
                                                    <table >
                                                        <tr>
                                                            <!--
                                                            <input type="checkbox" name="todasf" id="todasf" onClick="CheckAll22f();">&nbsp;<b>Marcar/Desmarcar todos</b>
                                                            <br><br>
                                                            -->

                                                            <?php
                                                            $i = 1;
                                                            foreach ($clientes as $for) {

                                                            ?>
                                                                <td>
                                                                    <!--checked-->


                                                                    <input type="checkbox" name="idClientes[]" <?php if(isset($idClientes)){foreach($idClientes as $r){if($r == $for->idClientes){echo 'checked';}}} ?> value="<?php echo $for->idClientes; ?>"> <?php echo $for->nomeCliente; ?>
                                                                </td>
                                                            <?php
                                                                if ($i == 1) {
                                                                    echo "</tr><tr>";
                                                                    $i=0;
                                                                }
                                                                $i++;
                                                            }
                                                            ?>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4" style="display:none; border: 1px solid #ccc; padding: 5px 0px 0px 5px;" id="divVendedor" >
                                            <label for="fornecedor" class="control-label">Vendedores:</label>
                                            <div  id="adm">
                                                <div class="card card-body" style="overflow: scroll;height: 300px">
                                                    <table >
                                                        <tr>
                                                            

                                                            <?php
                                                            $i = 1;
                                                            foreach ($vendedores as $for) {

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
                                                            }
                                                            ?>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4" style="display:none; border: 1px solid #ccc; padding: 5px 0px 0px 5px;" id="divStatusOs">
                                            <label for="fornecedor" class="control-label">Status O.S.:</label>
                                            <div  id="adm">
                                                <div class="card card-body" style="overflow: scroll;height: 300px">
                                                    <table >
                                                        <tr>
                                                            <!--
                                                            <input type="checkbox" name="todasf" id="todasf" onClick="CheckAll22f();">&nbsp;<b>Marcar/Desmarcar todos</b>
                                                            <br><br>
                                                            -->

                                                            <?php
                                                            $i = 1;
                                                            foreach ($statusOs as $for) {

                                                            ?>
                                                                <td>
                                                                    <!--checked-->


                                                                    <input type="checkbox" name="idStatusOs[]" <?php if(isset($idStatusOs)){foreach($idStatusOs as $r){if($r == $for->idStatusOs){echo 'checked';}}} ?> value="<?php echo $for->idStatusOs; ?>"> <?php echo $for->nomeStatusOs; ?>
                                                                </td>
                                                                <?php
                                                                if ($i == 1) {
                                                                    echo "</tr><tr>";
                                                                    $i=0;
                                                                }
                                                                $i++;
                                                            }
                                                            ?>

                                                    </table>
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
                <h5>Relatório</h5>
            </div>
            <div class="buttons">                    
                <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="RelatorioCompra">Excel</a>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs">
                                <div class="widget-box" style="margin-top:0px" id="divRelatorio">
                                    <table  class="table table-bordered " id="table_relatorio">
                                        <thead>
                                        <tr>          
                                            <?php 
                                            if(isset($relatorio[0])){
                                                $arrayKeys = array_keys((array)$relatorio[0]);
                                                //echo json_encode($arrayKeys);
                                                foreach($arrayKeys as $r){
                                                    echo '<th>'.$r.'</th>';
                                                }
                                            }else{
                                                echo '<h4 style="text-align:center">Sem resultados</h4>';
                                            }
                                            
                                            ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $soma = 0;
                                                $somaICMS = 0;
                                                $somaIPI = 0;
                                                foreach($relatorio as $r){
                                                    echo '<tr>';
                                                        foreach($arrayKeys as $d){
                                                            if($d == 'Valor Orc.' || $d == 'Valor O.S.' || $d == 'IPI'){
                                                                echo '<td> <span style="display:none">'.$r->$d.'</span> R$ '. number_format((float)$r->$d, 2, ',', '.').'</td>';
                                                                if($d == 'Total das compras realizadas'){
                                                                    $soma = $soma + $r->$d;
                                                                }
                                                                if($d == 'ICMS'){
                                                                    $somaICMS = $somaICMS + $r->$d;
                                                                }
                                                                if($d == 'IPI'){
                                                                    $somaIPI = $somaIPI + $r->$d;
                                                                }
                                                                //echo '<td>'.$r->$d.'</td>';
                                                            }else{
                                                                echo '<td>'.$r->$d.'</td>';
                                                            }
                                                            
                                                        }
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
<script>
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
    $('#checkClientes').click(function() {
        if(this.checked){
            document.getElementById('divClientes').style.display = "block";
        }else{
            document.getElementById('divClientes').style.display = "none";
        }
    });
    $('#checkVendedores').click(function() {
        if(this.checked){
            document.getElementById('divVendedor').style.display = "block";
        }else{
            document.getElementById('divVendedor').style.display = "none";
        }
    });
    $('#checkStatusOs').click(function() {
        if(this.checked){
            document.getElementById('divStatusOs').style.display = "block";
        }else{
            document.getElementById('divStatusOs').style.display = "none";
        }
    });
    $('#checkOs').click(function() {
        if(this.checked){
            document.getElementById('divOS').style.display = "block";
        }else{
            document.getElementById('divOS').style.display = "none";
        }
    });
    $(document).ready(function(){
      $("#imprimir").click(function(){         
        PrintElem('#divRelatorio');
      })      
      function PrintElem(elem)
      {
        Popup($(elem).html());
      }

      function Popup(data){
        var mywindow = window.open('', 'SGI', 'height=600,width=800');
        mywindow.document.write('<html><head><title>SGI</title>');
        /* mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap.min.css' /><link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap-responsive.min.css' />");*/
        mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/tableimprimir.css' />");


        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        //mywindow.close();

        return true;
      }

    });


    $(function () {
      $(".export-csv").on('click', function (event) {
          // CSV
          var filename = $(".export-csv").data("filename")
          var args = [$('#table_relatorio'), filename + ".csv", 0];
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
              csv = startQuote + $rows.map(function (i, row) {
                  var $row = $(row),
                      $cols = $row.find('td,th');
                  return $cols.map(function (j, col) {
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
              
              var blob = new Blob([decodeURIComponent(BOM+csv)], {
                  type: 'text/csv;charset=utf8'
              });

                window.navigator.msSaveBlob(blob, filename);

          } else if (window.Blob && window.URL) {
              // HTML5 Blob        
              var blob = new Blob([BOM+csv], { type: 'text/csv;charset=utf8' });
              var csvUrl = URL.createObjectURL(blob);

              $(this)
                  .attr({
                      'download': filename,
                      'href': csvUrl
                  });
          } else {
              // Data URI
              var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(BOM+csv);

              $(this)
                  .attr({
                      'download': filename,
                      'href': csvData,
                      'target': '_blank'
                  });
          }
      }

    });
    jQuery(function($) {
        $.datepicker.regional['pt-BR'] = {
            closeText: 'Fechar',
            prevText: '&#x3c;Anterior',
            nextText: 'Pr&oacute;ximo&#x3e;',
            currentText: 'Hoje',
            monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
            ],
            dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
    });
</script>