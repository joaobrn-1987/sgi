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
                            <form action="<?php echo base_url() ?>index.php/pcp/backlog" method="post" name="form1" id="form1">
                                <input type="hidden" value="1" name="ehfiltro">
                                <div class="span12" id="divCadastrarOs" style="margin-left: 0">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3" class="control-group">
                                            <label>O.S.</label>
                                            <input class="span12" type="text" name="idOs" id="idOs">
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label>O.C.</label>
                                            <input class="span12" type="text" name="idPedidoCompra" id="idPedidoCompra">
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span12" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Status Ordem Compra:</label>&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll22();">&nbsp;Marcar/Desmarcar todos
                                            <br>
                                            <table width='100%'>
                                                <tr>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($dados_statuscompra as $so) {
                                                    ?>
                                                        <td>
                                                            <input type="checkbox" name="idStatuscompras[]" class='check' value="<?php echo $so->idStatuscompras; ?>" checked> &nbsp;<?php echo $so->nomeStatus; ?>
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
                                            <label for="idGrupoServico" class="control-label">Status OS:</label>&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll2();">&nbsp;Marcar/Desmarcar todos
                                            <br>
                                            <table width='100%'>
                                                <tr>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($status_os as $e) {
                                                    ?>
                                                        <td>
                                                            <input type="checkbox" name="idStatusOs[]" class='check' value="<?php echo $e->idStatusOs; ?>" <?php if ($e->idStatusOs == 5) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>> &nbsp;<?php echo $e->nomeStatusOs; ?>
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
                                            <label for="idGrupoServico" class="control-label">Usuarios:</label>
                                            <table width='100%'>
                                                <tr>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($usuarios_dados as $so) {

                                                    ?>
                                                        <td>
                                                            <input type="checkbox" name="idUsuarios[]" class='check' value="<?php echo $so->idUsuarios; ?>" <?php if ($so->idUsuarios == $this->session->userdata('idUsuarios')) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                            &nbsp;<?php echo $so->nome; ?>
                                                        </td>
                                                    <?php
                                                        if (($i + 1) % 7 == 0)
                                                            echo "</tr>";

                                                        $i++;
                                                    }

                                                    ?>


                                            </table>

                                        </div>
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span4" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Unid. Execuçao O.S.:</label>


                                            <?php foreach ($unid_exec as $exec) { ?>
                                                <input type="checkbox" name="unid_execucao[]" class='check' value="<?php echo $exec->id_unid_exec; ?>"> &nbsp;<?php echo $exec->status_execucao; ?>

                                            <?php } ?>


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

<div align='center'>
    <a href="#modal-justificativaPedidoCompra" role="button" data-toggle="modal" class="btn btn-success" style="height: 20px"><i class="icon-plus icon-white"></i> Justificativa O.C.</a>
</div>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Backlog</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs">
                                <div class="widget-box" style="margin-top:0px">
                                    <div class="buttons">
                                        <!--
                                        <a id="imprimir3" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>-->
                                        <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="pcpBacklog">Excel</a>
                                    </div>
                                    <table id="tableHistVale" class="table table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>Resp. PCP</th>
                                                <th>Descrição O.S.</th>
                                                <th>PN</th>
                                                <th>O.S.</th>
                                                <th>Descrição Insumo</th>
                                                <th>Qtde</th>
                                                <th>O.C.</th>
                                                <?php 
                                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){ ?>
                                                        <th>Valor Unit.</th>
                                                        <th>Valor Total</th><?php
                                                    }
                                                ?>
                                                <th>Data Lanç.</th>
                                                <th>Previsão Ent.</th>
                                                <th>Data Ent.</th>
                                                <th>Status</th>
                                                <th>Fornecedor</th>
                                                <th>Contato</th>
                                                <th>Data Reprog.</th>
                                                <th>Justificativa</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as  $r) {
                                                echo '<tr>';
                                                echo '<td>' . $r->nome . '</td>';
                                                echo '<td>' . $r->descricao_item . '</td>';
                                                echo '<td>' . $r->pn . '</td>';
                                                echo '<td>' . $r->idOs . '</td>';
                                                echo '<td>' . $r->descricaoInsumo ." ".$r->dimensoes. '</td>';
                                                echo '<td>' . $r->quantidade . '</td>';
                                                echo '<td>'. $r->idPedidoCompra.'</td>';
                                                if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
                                                    echo '<td>'.number_format($r->valor_unitario, 2, ",", ".").'</td>';
                                                    echo '<td>'.number_format($r->valor_unitario*$r->quantidade, 2, ",", ".").'</td>';
                                                }
                                                echo '<td>' . (!empty($r->data_dist) ? date("d/m/Y", strtotime($r->data_dist)) : "") . '</td>';
                                                echo '<td>' . (!empty($r->previsao_entrega) ? date("d/m/Y", strtotime($r->previsao_entrega)) : "") . '</td>';
                                                echo '<td>' . (!empty($r->datastatusentregue) ? date("d/m/Y", strtotime($r->datastatusentregue)) : "") . '</td>';
                                                echo '<td>' . $r->nomeStatus . '</td>';
                                                echo '<td>' . $r->nomeFornecedor . '</td>';
                                                echo '<td>' . $r->telefone . '</td>';
                                                echo '<td>'.(!empty($r->data_reagendada) ? date("d/m/Y", strtotime($r->data_reagendada)) : "").'</td>';
                                                echo '<td>'.$r->ultJustificativa.'</td>';
                                                echo '<td><a onclick="abrirObservacao(' . $r->idDistribuir. ')" style="margin-right: 3%" class="btn tip-top"><i class="icon-list-alt icon-black"></i></a></td>';
                                                echo '</tr>';
                                            } ?>


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

<div id="modal-justificativa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/pcp/addjusificativa" method="post" id="formObservacoes">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Adicionar Justificativa</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span3">
                    <label>Data Reprog.</label>
                    <input type="text" name="data_rep" id="data_rep" class="span12 data">
                    <input type="hidden" name="idDistribuir" id="idDistribuir" >
                    <input type="hidden" name="histJustficativa" id="histJustficativa" >
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span12">
                    <label>Justificativa</label>
                    <textarea name="justificativa" id="justificativa" class="span12" style="resize:none;height: 150px;"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success">Cadastrar</button>
        </div>
        <div class="modal-body" style="padding:0px">
            <div class="span12">
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box" style="margin-top:0px">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-list-alt"></i>
                                </span>
                                <h5>Justificativas</h5>
                            </div>
                            <div class="widget-content nopadding" >
                                <div id="vObservacao" style="margin:35px;word-wrap: break-word">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-justificativaPedidoCompra" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/pcp/addjusificativaPedidoCompra" method="post" id="formObservacoes">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Adicionar Justificativa</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span3">
                    <label>Data Reprog.</label>
                    <input type="text" name="data_rep" id="data_rep" class="span12 data">
                </div>
                <div class="span3">
                    <label>Ordem de Compra</label>
                    <input type="text" name="idPedidoCompra" id="idPedidoCompra" class="span12">
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span12">
                    <label>Justificativa</label>
                    <textarea name="justificativa" id="justificativa" class="span12" style="resize:none;height: 150px;"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success">Cadastrar</button>
        </div><!--
        <div class="modal-body" style="padding:0px">
            <div class="span12">
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box" style="margin-top:0px">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-list-alt"></i>
                                </span>
                                <h5>Justificativas</h5>
                            </div>
                            <div class="widget-content nopadding" >
                                <div id="vObservacao" style="margin:35px;word-wrap: break-word">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </form>
</div>
<script type="text/javascript">
    $('.data').inputmask("date",{
        inputFormat: "dd/mm/yyyy",
        placeholder: "DD/MM/AAAA"
    });
    function abrirObservacao(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/pcp/getDistribuirById",
            type: 'POST',
            dataType: 'json',
            data: {
                idDistribuir: id
            },
            success: function(data) {
                atualizarModalObservacao(data.obj);
            },
            error: function(xhr, textStatus, error) {
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }
    function atualizarModalObservacao(item) {
        $("#idDistribuir").val(item.idDistribuir);
        $("#histJustficativa").val(item.justificativa);
        $("#vObservacao").empty();
        $("#vObservacao").append(item.justificativa);
        $("#modal-justificativa").modal('show');
    }
    $(function () {
      $(".export-csv").on('click', function (event) {
          // CSV
          var filename = $(".export-csv").data("filename")
          var args = [$('#tableHistVale'), filename + ".csv", 0];
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
</script>