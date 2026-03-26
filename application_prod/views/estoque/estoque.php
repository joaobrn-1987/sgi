
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/moment.js"></script><!--
<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />

<style >
html,
body,
.intro {
  height: 100%;
}

table td,
table th {
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
  min-width: 200px;
  max-width: 200px;
}

tbody td {
  font-weight: 500;
  color: #999999;
}
</style>
<section class="intro">
  <div class="bg-image h-100" >
    <div class="mask d-grid align-items-center h-100" style="background-color: rgba(0,0,0,.85);">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12" style="background-color: #ffffff36;padding-bottom: 15px;">
            <div style="text-align:right">
              <a class="btn btn-outline-secondary" style="color:white" href="<?php echo base_url();?>index.php/mapos/sair">Logout</a>         

            </div>
            <div class="text-center my-4" style="background-color:white;padding:20px;border-radius: 15px;"><!--
                <span style="/*! width: auto; *//*! height: auto; */display: inline-block;/*! padding: 25px; */background-color: white;border-radius: 50%;width: 120px;height: 120px;vertical-align: middle;">-->
                    <img src="<?php echo base_url()?>assets5_2/img/logo/ubertec_logo.png" alt="logo" height="72" style="margin-right: 60px;">
                <!--</span>  	
                <span style="/*! width: auto; *//*! height: auto; */display: inline-block;/*! padding: 25px; */background-color: white;border-radius: 50%;width: 120px;height: 120px;vertical-align: middle;">
                    <img src="<?php echo base_url()?>img/logo/ubertec_logo.png" alt="logo" width="100" style="margin-top: 20px;">
                </span>	
                <span> --> 
                    <img src="<?php echo base_url()?>assets5_2/img/logo/caraiba.png" alt="logo" height="72" 'style="margin-top: 20px;"><!--
                </span>	-->
                
			</div>
            <div class="text-left my-2">
                <a style="color:white;font-size: 20px; margin-right: 15px;">Estoque atual Ubertec</a>     
                <a id="imprimir" title="Imprimir" class="btn btn-dark" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                <a href=javascript:; class="export-csv btn btn-dark" data-filename="EstoqueAtual">Excel</a>           
            </div><!--
            <div class="buttons">  -->                  
              <!--
            </div>-->
            
            <div class="input-group mb-3">
                <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Procure por PN ou Descrição" title="Procure por PN ou Descrição">
            </div><!--
             -->
            <div class="table-responsive bg-white" data-mdb-perfect-scrollbar="true" style="position: relative; height: 445px;" id="divEstoque">
              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th scope="col">PN</th>
                    <th scope="col">DESCRIÇÃO</th>
                    <th scope="col">QUANTIDADE</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach($estoque as $r){
                        echo '<tr>';
                        echo '<td scope="row" style="color: #666666;">'.$r->pn.'</td>';
                        echo '<td style="color: #666666;">'.$r->descricao.'</td>';
                        echo '<td style="color: #666666;">'.$r->quantidade.'</td>';
                        echo '</tr>';
                    }?>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    td2 = tr[i].getElementsByTagName("td")[1];
    if (td || td2) {
      txtValue = td.textContent || td.innerText;
      txtValue2 = td2.textContent || td2.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
$(document).ready(function(){
  $("#imprimir").click(function(){         
    PrintElem('#divEstoque');
  })
  
  function PrintElem(elem)
  {
    Popup($(elem).html());
  }

  function Popup(data)
  {
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
      var args = [$('#myTable'), filename + ".csv", 0];
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