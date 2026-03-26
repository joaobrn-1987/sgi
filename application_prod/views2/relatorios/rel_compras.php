<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />
<script src="<?php echo base_url()?>js/jquery.inputmask.bundle.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Relatório de Compras</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="span12">
                                <form class="form-inline" action="<?php echo base_url() ?>index.php/relatorios/relcompras/1" method="post" name="form1" id="form1">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span4" class="control-group">
                                            <label for="idOs" class="control-label">Data da compra</label></br>
                                            De: <input class="data" type="text" name="dataInicial" class="span4" value="<?php if(isset($dataInicial)){echo $dataInicial;} ?>"/> |  Até:<input class="data" type="text" name="dataFinal" class="span4" value="<?php if(isset($dataFinal)){echo $dataFinal;} ?>"/>
                                        </div>
                                        <div class="span5" class="control-group">
                                            <label for="idOs" class="control-label">Por:</label></br>
                                            <table >
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" id='checkFornecedores' name="agrupar[]" class='check' value="fornecedores" <?php $forn = false;if(isset($agrupar)){foreach($agrupar as $r){if($r=='fornecedores'){echo 'checked';$forn = true;}}} ?>> &nbsp;Fornecedores
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id='checkClientes' name="agrupar[]" class='check' value="clientes" <?php $cli = false;if(isset($agrupar)){foreach($agrupar as $r){if($r=='clientes'){echo 'checked';$cli = true;}}} ?>> &nbsp;Clientes
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id='checkOs' name="agrupar[]" class='check' value="os" <?php $os2 = false;if(isset($agrupar)){foreach($agrupar as $r){if($r=='os'){echo 'checked';$os2 = true;}}} ?>> &nbsp;O.S.
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id='checkPC' name="agrupar[]" class='check' value="pc" <?php $pc2 = false;if(isset($agrupar)){foreach($agrupar as $r){if($r=='pc'){echo 'checked';$pc2 = true;}}} ?>> &nbsp;O.C.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" id='checkCategorias' name="agrupar[]" class='check' value="categorias" <?php $categorias2 = false;if(isset($agrupar)){foreach($agrupar as $r){if($r=='categorias'){echo 'checked';$categorias2 = true;}}} ?>> &nbsp;Categoria
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id='checkInsumos' name="agrupar[]" class='check' value="insumos" <?php $insumos2 = false;if(isset($agrupar)){foreach($agrupar as $r){if($r=='insumos'){echo 'checked';$insumos2 = true;}}} ?>> &nbsp;Insumos
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id='checkGrupoCompra' name="agrupar[]" class='check' value="grupoCompra" <?php $grupoCompra2 = false;if(isset($agrupar)){foreach($agrupar as $r){if($r=='grupoCompra'){echo 'checked';$grupoCompra2 = true;}}} ?>> &nbsp;Grupo Compra
                                                    </td>
                                                </tr>
                                            </table>
                                        </div> 
                                        <div class="span2" class="control-group" style="display:<?php if($os2){echo 'block';}else{echo 'none';}?>; " id="divOS">
                                            <label for="idOs" class="control-label">OS - (Separe as O.S. com vírgulas)</label></br>
                                            <input  type="text" name="listOs" class="span12" value="<?php if(isset($listOs)){echo $listOs;} ?>"/>
                                        </div>
                                        <div class="span2" class="control-group" style="display:<?php if($pc2){echo 'block';}else{echo 'none';}?>; " id="divPC">
                                            <label for="idOs" class="control-label">OC - (Separe as O.C. com vírgulas)</label></br>
                                            <input  type="text" name="listPc" class="span12" value="<?php if(isset($listPc)){echo $listPc;} ?>"/>
                                        </div>   
                                        <div class="span2" class="control-group" style="padding-left:30px">
                                            <br>

                                            <button href="#" onClick="document.getElementById('form1').submit();" style=" border: 0px;"><i class="icon-search" style="font-size:30px; float: right; margin-right:50% "></i></button>
                                        </div>                        
                                    </div>
                                    <div class="span12" style="margin-left: 0px" >
                                        <div class="span3" style="display:<?php if($forn){echo 'block';}else{echo 'none';}?>; " id="divFornecedores">
                                            <label for="fornecedor" class="control-label">Fornecedor:</label>
                                            
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
                                                            foreach ($fornecedores as $for) {

                                                                ?>
                                                                <td>
                                                                    <!--checked-->


                                                                    <input type="checkbox" name="idFornecedores[]" <?php if(isset($idFornecedores)){foreach($idFornecedores as $r){if($r == $for->idFornecedores){echo 'checked';}}} ?> value="<?php echo $for->idFornecedores; ?>"> <?php echo $for->nomeFornecedor; ?>
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
                                        <div class="span3" style="display:<?php if($cli){echo 'block';}else{echo 'none';}?>; " id="divClientes">
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
                                        <div class="span3" style="display:<?php if($categorias2){echo 'block';}else{echo 'none';}?>; " id="divCategorias">
                                            <label for="categoria" class="control-label">Categoria de Insumos:</label>
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
                                                            foreach ($categorias as $for) {

                                                            ?>
                                                                <td>
                                                                    <!--checked-->


                                                                    <input type="checkbox" name="idCategorias[]" <?php if(isset($idCategorias)){foreach($idCategorias as $r){if($r == $for->idCategoria){echo 'checked';}}} ?> value="<?php echo $for->idCategoria; ?>"> <?php echo $for->descricaoCategoria; ?>
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
                                        <div class="span3" style="display:<?php if($insumos2){echo 'block';}else{echo 'none';}?>; " id="divInsumos">
                                            <label for="categoria" class="control-label">Insumos:</label>
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
                                                            foreach ($insumos as $for) {

                                                            ?>
                                                                <td>
                                                                    <!--checked-->


                                                                    <input type="checkbox" name="idInsumos[]" <?php if(isset($idInsumos)){foreach($idInsumos as $r){if($r == $for->idInsumos){echo 'checked';}}} ?> value="<?php echo $for->idInsumos; ?>"> <?php echo $for->descricaoInsumo; ?>
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
                                        <div class="span3" style="display:<?php if($grupoCompra2){echo 'block';}else{echo 'none';}?>; " id="divGrupoCompra">
                                            <label for="categoria" class="control-label">Grupo de compra:</label>
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
                                                            foreach ($grupocompra as $for) {

                                                                ?>
                                                                <td>
                                                                    <!--checked-->


                                                                    <input type="checkbox" name="idGrupocompras[]" <?php if(isset($idGrupocompras)){foreach($idGrupocompras as $r){if($r == $for->idgrupo){echo 'checked';}}} ?> value="<?php echo $for->idgrupo; ?>"> <?php echo $for->nomegrupo; ?>
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
                                    </div><!--
                                    <div class="span12" style="margin-left: 0px" >
                                        
                                    </div>-->
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
        <h5>Relatório</h5>
        
    </div>
    <div class="buttons">                    
      <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
      <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="RelatorioCompra">Excel</a>
    </div>
    <div class="widget-content nopadding" id="divRelatorio" style="text-align:center">
            <?php /*if((isset($dataInicial) && isset($dataFinal))||(isset($dataEntInicial) && isset($dataEntFinal))){ echo ' - ';}*/if(isset($dataInicial) && isset($dataFinal)){echo 'Data de Compra: '.$dataInicial.' à '.$dataFinal;} ?> 
            <?php if((isset($dataInicial) && isset($dataFinal))&&(isset($dataEntInicial) && isset($dataEntFinal))){ echo ' | ';}if(isset($dataEntInicial) && isset($dataEntFinal)){echo 'Data da Entrega: '.$dataEntInicial.' à '.$dataEntFinal;} ?>

                                                      
      <table class="table table-bordered " id="table_relatorio" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	      font-size:10px;" border="1">
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
                        if($d == 'Total das compras realizadas' || $d == 'ICMS' || $d == 'IPI'){
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
        <div style="text-align:right">
          <?php
          if(isset($relatorio[0])){
            echo '<tr>';
            $colun = count($arrayKeys);     
            $colun = $colun +1  ; 
                echo '<td colspan="'.$colun.'" style="text-align:center" >TOTAL: R$ '.number_format((float)$soma+$somaICMS+$somaIPI, 2, ',', '.').'</td>';                
            echo '</tr>'; 
          }
            
          ?>
        </div>
      </table>
      
    </div>
  </div>
  <script type="text/javascript">
    
    $('.data').inputmask("date",{
        inputFormat: "dd/mm/yyyy",
        placeholder: "DD/MM/AAAA"
    });
    $('#checkClientes').click(function() {
        if(this.checked){
            document.getElementById('divClientes').style.display = "block";
        }else{
            document.getElementById('divClientes').style.display = "none";
        }
    });
    $('#checkFornecedores').click(function() {
        if(this.checked){
            document.getElementById('divFornecedores').style.display = "block";
        }else{
            document.getElementById('divFornecedores').style.display = "none";
        }
    });
    $('#checkCategorias').click(function() {
        if(this.checked){
            document.getElementById('divCategorias').style.display = "block";
        }else{
            document.getElementById('divCategorias').style.display = "none";
        }
    });
    $('#checkInsumos').click(function() {
        if(this.checked){
            document.getElementById('divInsumos').style.display = "block";
        }else{
            document.getElementById('divInsumos').style.display = "none";
        }
    });
    $('#checkOs').click(function() {
        if(this.checked){
            document.getElementById('divOS').style.display = "block";
        }else{
            document.getElementById('divOS').style.display = "none";
        }
    });
    $('#checkPC').click(function() {
        if(this.checked){
            document.getElementById('divPC').style.display = "block";
        }else{
            document.getElementById('divPC').style.display = "none";
        }
    });
    $('#checkGrupoCompra').click(function() {
        if(this.checked){
            document.getElementById('divGrupoCompra').style.display = "block";
        }else{
            document.getElementById('divGrupoCompra').style.display = "none";
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
    $(document).ready(function () {
       $('#table_relatorio').DataTable({
            'columnDefs': [ { // column index (start from 0)
                "type": "num" 
            }],
            "order": [[ 0, "asc" ]],
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
    $(document).ready(function(){
      $(".data" ).datepicker({ dateFormat: 'dd/mm/yy', language: 'pt-BR', locale: 'pt-BR' });
    })
    jQuery(function($){
        $.datepicker.regional['pt-BR'] = {
                closeText: 'Fechar',
                prevText: '&#x3c;Anterior',
                nextText: 'Pr&oacute;ximo&#x3e;',
                currentText: 'Hoje',
                monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                'Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
    });
  </script>