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
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="span12" id="divCadastrarOs">

                        <div class="span12" id="divCadastrarOs">
                        <div class="span12" style="padding: 1%; margin-left: 0">
                            <div class="span3" class="control-group">
                                <label for="dataOrcInicial" class="control-label">Data de Orçamento:</label>
                                <input class="span5 datap" type="text" name="dataOrcInicial" value="<?php echo isset($_POST['dataOrcInicial']) ? htmlspecialchars($_POST['dataOrcInicial']) : ''; ?>" placeholder="Inicio" /> - 
                                <input class="span5 datap" type="text" name="dataOrcFinal" value="<?php echo isset($_POST['dataOrcFinal']) ? htmlspecialchars($_POST['dataOrcFinal']) : ''; ?>" placeholder="Fim" />
                            </div>

                            <div class="span3" class="control-group">
                                <label for="dataAberInicial" class="control-label">Data de Abertura O.S.</label>
                                <input class="span5 datap" type="text" name="dataAberInicial" value="<?php echo isset($_POST['dataAberInicial']) ? htmlspecialchars($_POST['dataAberInicial']) : ''; ?>" placeholder="Inicio" /> - 
                                <input class="span5 datap" type="text" name="dataAberFinal" value="<?php echo isset($_POST['dataAberFinal']) ? htmlspecialchars($_POST['dataAberFinal']) : ''; ?>" placeholder="Fim" />
                            </div>

                            <div class="span3" class="control-group">
                                <label for="dataFatInicial" class="control-label">Data de Faturamento</label>
                                <input class="span5 datap" type="text" name="dataFatInicial" value="<?php echo isset($_POST['dataFatInicial']) ? htmlspecialchars($_POST['dataFatInicial']) : ''; ?>" placeholder="Inicio" /> - 
                                <input class="span5 datap" type="text" name="dataFatFinal" value="<?php echo isset($_POST['dataFatFinal']) ? htmlspecialchars($_POST['dataFatFinal']) : ''; ?>" placeholder="Fim" />
                            </div>

                            <div class="span3" class="control-group">
                                <label for="dataEntrInicial" class="control-label">Data de Entrega</label>
                                <input class="span5 datap" type="text" name="dataEntrInicial" value="<?php echo isset($_POST['dataEntrInicial']) ? htmlspecialchars($_POST['dataEntrInicial']) : ''; ?>" placeholder="Inicio" /> - 
                                <input class="span5 datap" type="text" name="dataEntrFinal" value="<?php echo isset($_POST['dataEntrFinal']) ? htmlspecialchars($_POST['dataEntrFinal']) : ''; ?>" placeholder="Fim" />
                            </div>
                        </div>
						
                                   <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6" class="control-group">
                                            <label for="idOs" class="control-label">Por:</label></br>
                                            <table width="100%">
                                                <tr>      
                                                    <td>
                                                        <input type="checkbox" id='checkVendedores' name="agrupar[]" class='check' value="vendedores" > &nbsp;Gerente
                                                    </td>   
                                                    <td>
                                                        <input type="checkbox" id='checkVendedoresAux' name="agrupar[]" class='check' value="vendedoresAux" > &nbsp;Vendedor Auxiliar
                                                    </td>
   													<td>
                                                        <input type="checkbox" id='checkRegiao' name="agrupar[]" class='check' value="regiao" > &nbsp;Região
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
                                        <div class="span4" class="control-group" style="display:none; " id="divOS">
                                            <label for="idOs" class="control-label">OS - (Separe as O.S. com vírgulas)</label></br>
                                            <input  type="text" name="listOs" class="span12" value="<?php if(isset($listOs)){echo $listOs;} ?>"/>
                                        </div>
                                        <div class="span2" class="control-group" style="padding-left:30px">
                                           
                                            <button href="#" onClick="document.getElementById('form1').submit();" style=" border: 0px;margin-top: 28px;"><i class="icon-search" style="font-size:30px; float: right; "></i></button>
                                        </div>
                                    </div>
									
									
									
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        
                                        <div class="span4" style="display:none; border: 1px solid #ccc; padding: 5px 0px 0px 5px;" id="divVendedor" >
                                            <label for="fornecedor" class="control-label">Gerentes:</label>
                                            <div  id="adm">
                                                <div class="card card-body" style="overflow: scroll;height: 300px">
                                                    <table>
                                                        <tr>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($vendedores as $for) {
																if (in_array($for->idVendedor, [2, 3, 4, 6, 7])) {
																	continue; // Pula os vendedores com IDs 2, 3, 4, 6, 7
																}
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
 <div class="span4" style="display:none; border: 1px solid #ccc; padding: 5px 0px 0px 5px;" id="divVendedorAux">
    <label for="fornecedor" class="control-label">Vendedor Auxiliar:</label>
    <div id="adm">
        <div class="card card-body" style="overflow: scroll;height: 300px">
		
		
<!-- Certifique-se de que $idVendedores está sendo passado -->
<?php
$vendedoresAux = $this->data['idVendedores'];
$currentVendedor = null;
?>

<table>
    <?php
    // Verifique se $vendedoresAux é um array
    if (is_array($vendedoresAux)) {
        foreach ($vendedoresAux as $aux) {
			
	if (in_array($aux->idVendedorAuxiliar, [1, 2, 3, 4])) {
	continue; // Pula os vendedores com IDs 2, 3, 4, 6, 7
		}
            if ($currentVendedor !== $aux->nomeVendedorPrincipal) {
                // Novo vendedor principal
                $currentVendedor = $aux->nomeVendedorPrincipal;
                ?>
                <tr>
                    <td colspan="2"><strong><?php echo $currentVendedor; ?></strong></td>
                </tr>
                <?php
            }
            // Vendedor auxiliar
            ?>
            <tr>
                <td>
                    <input type="checkbox" name="idVendedoresAux[]" <?php if (isset($idVendedoresAux)) { foreach ($idVendedoresAux as $r) { if ($r == $aux->idVendedorAuxiliar) { echo 'checked'; } } } ?> value="<?php echo $aux->idVendedorAuxiliar; ?>">
                    <?php echo $aux->nomeUsuario; ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</table>





        </div>
    </div>
</div>

<?php 
$todas_regioes = isset($this->data['todas_regioes']) && is_array($this->data['todas_regioes']) ? $this->data['todas_regioes'] : []; 
$regioes_selecionadas = isset($this->data['regioes_selecionadas']) && is_array($this->data['regioes_selecionadas']) ? $this->data['regioes_selecionadas'] : []; 
?>

<div class="span4" style="display:none; border: 1px solid #ccc; padding: 5px 0px 0px 5px;" id="divRegiao">
    <label for="fornecedor" class="control-label">Região:</label>
    <div id="adm">
        <div class="card card-body" style="overflow: auto; height: 300px;">
            <table>
                <tr>
                <?php 
                $i = 1;
                if (!empty($todas_regioes)) {
                    foreach ($todas_regioes as $regiao) { ?>
                        <td>
                            <input type="checkbox" name="regiao[]" 
                                value="<?php echo htmlspecialchars($regiao['regiao']); ?>" 
                                <?php 
                                if (in_array($regiao['regiao'], $regioes_selecionadas)) { 
                                    echo 'checked';
                                }
                                ?>> 
                            <?php echo htmlspecialchars($regiao['regiao']); ?>
                        </td>
                        <?php if ($i % 2 == 0) { 
                            echo "</tr><tr>"; 
                        } 
                        $i++; 
                    } 
                } else {
                    echo "<td>Nenhuma região encontrada.</td>";
                }
                ?>
                </tr>
            </table>
        </div>
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
    <div id="adm">
        <div class="card card-body" style="overflow: scroll;height: 300px">
            <table>
                <tr>
                    <!--
                    <input type="checkbox" name="todasf" id="todasf" onClick="CheckAll22f();">&nbsp;<b>Marcar/Desmarcar todos</b>
                    <br><br>
                    -->

                    <?php
                    $i = 1;
                    $statusIds = array(90, 28, 6, 5, 86, 30, 89, 85, 87, 225, 9, 213, 8); // Array com os IDs a serem marcados
                    foreach ($statusOs as $for) {
                    ?>
                        <td>
                            <input type="checkbox" name="idStatusOs[]" value="<?php echo $for->idStatusOs; ?>" <?php if (in_array($for->idStatusOs, $statusIds)) echo 'checked'; ?>> <?php echo $for->nomeStatusOs; ?>
                        </td>
                        <?php
                        if ($i == 1) {
                            echo "</tr><tr>";
                            $i = 0;
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
                <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="RelatorioComercial">Excel</a>
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
        if (isset($relatorio[0])) {
            $arrayKeys = array_keys((array)$relatorio[0]);
            foreach ($arrayKeys as $r) {
                echo '<th>' . htmlspecialchars($r) . '</th>';
            }
            // Adicionar colunas para as datas selecionadas
            echo '<th>Data Orçamento Inicial</th>';
            echo '<th>Data Orçamento Final</th>';
            echo '<th>Data Abertura O.S. Inicial</th>';
            echo '<th>Data Abertura O.S. Final</th>';
            echo '<th>Data Faturamento Inicial</th>';
            echo '<th>Data Faturamento Final</th>';
            echo '<th>Data Entrega Inicial</th>';
            echo '<th>Data Entrega Final</th>';
        } else {
            echo '<h4 style="text-align:center">Sem resultados</h4>';
        }
        ?>
    </tr>
                                        </thead>
<tbody>
    <?php 
    // Primeiro trecho de código original
    $soma = 0;
    $somaICMS = 0;
    $somaIPI = 0;

    foreach ($relatorio as $r) {
        echo '<tr>';
        foreach ($arrayKeys as $d) {
            $valor = isset($r->$d) ? (float)$r->$d : 0;

            if (in_array($d, ['Valor Orc.', 'Valor O.S.', 'IPI'])) {
                //echo '<td><span style="display:none">' . number_format($valor, 2, '.', '') . '</span> R$ ' . number_format($valor, 2, ',', '.') . '</td>';
				$valorFormatado = number_format($valor, 2, ',', '.');
				echo "<td>R$ $valorFormatado</td>";
                if ($d === 'Total das orçamentos realizadas') {
                    $soma += $valor;
                }
                if ($d === 'ICMS') {
                    $somaICMS += $valor;
                }
                if ($d === 'IPI') {
                    $somaIPI += $valor;
                }
            } else {
                echo '<td>' . htmlspecialchars($r->$d) . '</td>';
            }
        }
        
        // Adicionar valores das datas enviadas
        echo '<td>' . htmlspecialchars(isset($this->data['dataOrcInicial']) ? $this->data['dataOrcInicial'] : '-') . '</td>';
        echo '<td>' . htmlspecialchars(isset($this->data['dataOrcFinal']) ? $this->data['dataOrcFinal'] : '-') . '</td>';
        echo '<td>' . htmlspecialchars(isset($this->data['dataAberInicial']) ? $this->data['dataAberInicial'] : '-') . '</td>';
        echo '<td>' . htmlspecialchars(isset($this->data['dataAberFinal']) ? $this->data['dataAberFinal'] : '-') . '</td>';
        echo '<td>' . htmlspecialchars(isset($this->data['dataFatInicial']) ? $this->data['dataFatInicial'] : '-') . '</td>';
        echo '<td>' . htmlspecialchars(isset($this->data['dataFatFinal']) ? $this->data['dataFatFinal'] : '-') . '</td>';
        echo '<td>' . htmlspecialchars(isset($this->data['dataEntrInicial']) ? $this->data['dataEntrInicial'] : '-') . '</td>';
        echo '<td>' . htmlspecialchars(isset($this->data['dataEntrFinal']) ? $this->data['dataEntrFinal'] : '-') . '</td>';
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
    $('#checkVendedoresAux').click(function() {
        if(this.checked){
            document.getElementById('divVendedorAux').style.display = "block";
        }else{
            document.getElementById('divVendedorAux').style.display = "none";
        }
    });	
    $('#checkRegiao').click(function() {
        if(this.checked){
            document.getElementById('divRegiao').style.display = "block";
        }else{
            document.getElementById('divRegiao').style.display = "none";
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