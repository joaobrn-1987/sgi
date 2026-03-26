<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
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
                            <form action="<?php echo base_url() ?>index.php/peritagem/listaperitagem" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            
                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                            <input type="hidden" class="span12" name="verificarForm" value="1"/>
                                            <input type="text" class="span12" value=""  name="idOrcamento"/>
                                        </div> <!--
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento Item: </label>
                                            <input type="text" class="span12" value=""  name="idOrcamentoItem"/>
                                        </div> -->
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
                                            <label for="idGrupoServico" class="control-label">Status Peritagem: </label>
                                            <select class="span12 form-control" name="statusPeritagem">
                                                <option value=""></option>
                                                <?php
                                                    foreach($statusPeritagem as $r){
                                                        echo '<option value="'.$r->idStatusPeritagem.'">'.$r->descricaoPeritagem.'</option>';
                                                    }
                                                ?>

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

<ul class="nav nav-tabs">
    <?php 
    $contador = 0;
    $marcador = null;
    foreach($aguardandoPer as $c){
        if($c->unid_execucao){
            if($contador == 0){
                echo '<li class="active"><a href="#tab'.$c->unid_execucao.'" data-toggle="tab">'.$c->status_execucao.'</a></li>';
                $contador = 1;
                $marcador = $c->unid_execucao;
            }else{
                echo '<li><a href="#tab'.$c->unid_execucao.'" data-toggle="tab">'.$c->status_execucao.'</a></li>';
            }
        }else{
            echo '<li><a href="#tab0" data-toggle="tab">Não definido</a></li>';
        }
        
    }
    if($aguardandoPer){
        echo '<li><a href="#tabtodos" data-toggle="tab">Todos</a></li>';
    }
    ?>
</ul>

<div class="tab-content">
<?php 
    foreach($aguardandoPer as $c){
        if($c->unid_execucao){
            if($marcador == $c->unid_execucao){
                echo '<div class="tab-pane active" id="tab'.$c->unid_execucao.'">';
            }else{
                echo '<div class="tab-pane" id="tab'.$c->unid_execucao.'">';
            }
        }else{
            echo '<div class="tab-pane" id="tab0">';
        }?>
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5><?php foreach($statusPeritagem as $r){
                    if($idStatusPeritagem2 == $r->idStatusPeritagem){
                        echo $r->descricaoPeritagem;
                    }      
                    }?></h5>

            </div>
            <div class="buttons">

                <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
            </div>
            <div class="widget-content nopadding" id="printOs2">
                <table class="table table-bordered " id="tableInsert">
                    <thead>
                        <tr>

                            <th>Nº Orçamento</th>
                            <th>Cliente</th>
                            <th>Data orçamento</th>
                            <th>Itens</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($c->objOrcamento as $r) {


                            echo '<tr>';
                            echo '<td >' . $r->idOrcamentos . '</td>';
                            echo '<td >' . $r->nomeCliente . '</td>';
                            echo '<td >' . date("d/m/Y H:i:s", strtotime($r->data_abertura)) . '</td>';
                            echo '<td> ';
                            $count = 1;
                            $tot = count(explode(";",$r->idOrcamento_item));
                            $dist = explode(";",$r->idOrcamento_item);
                            $qtd = explode(";",$r->pn);
                            $dtCad = explode(";",$r->descricao_item);
                            $nome = explode(";",$r->nomeVendedor);
                            for($x = 0;$x < $tot;$x++){
                                $orcitem = $this->orcamentos_model->getOrcItemDetailsById($dist[$x]);
                                $this->data['results3'] = $this->orcamentos_model->getos_item($dist[$x]);
                                $color = "";
                                $des = "";
                                if (!empty($this->data['results3'])) {                            
                                    if($orcitem->idStatusPeritagem == 5){
                                        $color = "style='color:red'";
                                    }
                                    if ($orcitem->statusDesenho == 3) {
                                        $des = '<a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>';
                                    } else if ($orcitem->statusDesenho == 2) {
                                        $des = '<a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>';
                                    } else {
                                        $des = '<a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a>';
                                    }

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
                                if(!empty($orcitem->data_finalizado_desenho)){
                                    $dataSol = " | Data Sol. Perit.: ".date("d/m/Y H:i", strtotime($orcitem->data_solicitar_desenho));
                                }
                                if(!empty($orcitem->nf_cliente)){
                                    $nf_cliente = " | NF: ".$orcitem->nf_cliente;
                                }
                                echo "<div $color><b>" . $count . "- </b>" . $orcitem->descricao_item . $ositem ." | Des.: ".$des. $dataSol.$nf_cliente."<b>".(!empty($color)?" | PERITAGEM RECUSADA ":"")."</b><br></div>\n";
                                $count++;
                            }

                            echo '</td>';
                            echo '<td>';
                                echo '<a href="' . base_url().'index.php/peritagem/escopoperitagem/'.$r->idOrcamentos . '/'.str_replace(";","_",$r->idOrcamento_item).'" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        } ?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        echo '</div>';
    }?>
    <div class="tab-pane" id="tabtodos">
        
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5><?php foreach($statusPeritagem as $r){
                    if($idStatusPeritagem2 == $r->idStatusPeritagem){
                        echo $r->descricaoPeritagem;
                    }      
                    }?></h5>

            </div>
            <div class="buttons">

                <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
				<a href="javascript:;" class="export-csv btn btn-mini btn-inverse" data-filename="AguardandoPeritagem">csv</a>
				<a href="javascript:;" class="export-xls btn btn-mini btn-inverse" data-filename="AguardandoPeritagem">xls</a>				
            </div>
            <div class="widget-content nopadding" id="printOs2">
                <table class="table table-bordered " id="tableInsert3">
                    <thead>
                        <tr>

                            <th>Nº Orçamento</th>
                            <th>Cliente</th>
                            <th>Data orçamento</th>
                            <th>Itens</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($aguardandoPer as $c){
                            foreach ($c->objOrcamento as $r) {


                            echo '<tr>';
                            echo '<td >' . $r->idOrcamentos . '</td>';
                            echo '<td >' . $r->nomeCliente . '</td>';
                            echo '<td >' . date("d/m/Y H:i:s", strtotime($r->data_abertura)) . '</td>';
                            echo '<td> ';
                            $count = 1;
                            $tot = count(explode(";",$r->idOrcamento_item));
                            $dist = explode(";",$r->idOrcamento_item);
                            $qtd = explode(";",$r->pn);
                            $dtCad = explode(";",$r->descricao_item);
                            $nome = explode(";",$r->nomeVendedor);
                            for($x = 0;$x < $tot;$x++){
                                $orcitem = $this->orcamentos_model->getOrcItemDetailsById($dist[$x]);
                                $this->data['results3'] = $this->orcamentos_model->getos_item($dist[$x]);
                                $color = "";
                                $des = "";
                                if (!empty($this->data['results3'])) {                            
                                    if($orcitem->idStatusPeritagem == 5){
                                        $color = "style='color:red'";
                                    }
                                    if ($orcitem->statusDesenho == 3) {
                                        $des = '<a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>';
                                    } else if ($orcitem->statusDesenho == 2) {
                                        $des = '<a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>';
                                    } else {
                                        $des = '<a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a>';
                                    }

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
                                if(!empty($orcitem->data_finalizado_desenho)){
                                    $dataSol = " | Data Sol. Perit.: ".date("d/m/Y H:i", strtotime($orcitem->data_solicitar_desenho));
                                }
                                if(!empty($orcitem->nf_cliente)){
                                    $nf_cliente = " | NF: ".$orcitem->nf_cliente;
                                }
                                echo "<div $color><b>" . $count . "- </b>" . $orcitem->descricao_item . $ositem ." | Des.: ".$des. $dataSol.$nf_cliente."<b>".(!empty($color)?" | PERITAGEM RECUSADA ":"")."</b><br></div>\n";
                                $count++;
                            }

                            echo '</td>';
                            echo '<td>';
                                echo '<a href="' . base_url().'index.php/peritagem/escopoperitagem/'.$r->idOrcamentos . '/'.str_replace(";","_",$r->idOrcamento_item).'" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        } }?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





<script type="text/javascript">
$(document).ready(function() {
    $("#imprimir").click(function() {
        PrintElem('#printOs2');
    })

    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
        var mywindow = window.open('', 'SGI', 'height=600,width=800');
        mywindow.document.write('<html><head><title>SGI</title><meta charset="UTF-8" />');
         //mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" /><link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />');
        mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/tableimprimir.css' />");
        mywindow.document.write("<style>table, td, th {  border: 1px solid;} table {  width: 100%;  border-collapse: collapse;}</style>");

        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        //mywindow.close();

        return true;
    }

});
function openclose(td,valor){
    var tr = document.querySelector(".trfilho"+valor);
    
    if(tr.style.display == "table-row" || tr.style.display == ""){
        $(".trfilho"+valor).hide('fast');
        $(td).parent('tr').css('background-color', '');
        $(td).find("a > i").removeClass("fa-minus");
        $(td).find("a > i").addClass("fa-plus");            
    }else{
        $(".trfilho"+valor).show('fast');
        $(td).parent('tr').css('background-color', '#efefef');
        $(td).find("a > i").removeClass("fa-plus");
        $(td).find("a > i").addClass("fa-minus");
    }       
}

    $(document).ready(function () {
        $('#tableAguardandoPeritagem').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
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
	
	 $(function () {
      $(".export-csv").on('click', function (event) {
          // CSV
          var filename = $(".export-csv").data("filename")
          var args = [$('#tableInsert3'), filename + ".csv", 0];
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
	
	
  $(function () {
    // Função para exportar como Excel
    $(".export-xls").on('click', function () {
      var filename = $(".export-xls").data("filename");
      exportTableToExcel($('#tableInsert3'), filename + ".xls");
    });

    // Função para exportar a tabela como Excel
    function exportTableToExcel($table, filename) {
      // Criar um novo arquivo de planilha
      var wb = XLSX.utils.table_to_book($table[0], { sheet: "Sheet1" });
      
      // Gerar o arquivo Excel
      XLSX.writeFile(wb, filename);
    }
  });	
</script>
