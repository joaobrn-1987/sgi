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
                            <form action="<?php echo base_url() ?>index.php/relatorios/infoHoras" method="post" name="form1" id="form1">
                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                            <input type="text" class="span12" value=""  name="idOrcamento"/>
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
<div class="row-fluid" style="margin-top:0">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-tags"></i>
				</span>
				<h5>Tempo das etapas por O.S.</h5>
			</div>
            <div class="buttons">

                <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Rel-Orcamento">Excel</a>
            </div>
			<div class="widget-content nopadding">
				<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
							<div class="span12" id="divCadastrarOs">                                
								<div class="widget-box" style="margin-top:0px" id="printOs">                                        
									<table id="tableHistVale" class="table table-bordered ">
										<thead>
											<tr>
												<th>Orç.</th>
												<th>O.S.</th>                                                
												<th>Qtd</th><!--
                                                <th>Tempo </br> Comercial</th> -->
												<th>Tempo </br> Receb./Entrada</th>
												<th>Tempo </br> Desmontagem</th>
												<th>Tempo Desenho</th>
												<th>Tempo Peritagem</th>
												<th>Tempo P/<br>Iniciar PCP</th>
												<th>Média Tempo P/<br>Gerar O.C.</th>
												<th>Tempo Estimado <br> P/ Finalizar a O.S.</th>
											</tr>
										</thead>
										<tbody>
                                            <?php 
                                                foreach($result as $r){
                                                    echo '<tr>'.
                                                        '<td>'.$r->idOrcamentos.'</td>'.
                                                        '<td>'.$r->idOs.'</td>'.
                                                        '<td>'.$r->qtd_os.'</td>'./*
                                                        '<td>'.$r->horasComercial.'</td>'.*/
                                                        '<td>'.$r->horasArmazenar.'</td>'.
                                                        '<td>'.$r->horasDesmontagem.'</td>'.
                                                        '<td>'.$r->horasGastaDesenho.'</td>'.
                                                        '<td>'.$r->horasGastaPeritagem.'</td>'.
                                                        '<td>'.$r->horasInicioPCP.'</td>'.
                                                        '<td>'.$r->horasPedidoSup.'</td>'.
                                                        '<td>'.$r->horasOs.'</td>'.
                                                    '</tr>';
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
<script type="text/javascript">
    $(function() {
        $(".export-csv").on('click', function(event) {
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
            PrintElem('#printOs');
        })

        function PrintElem(elem) {
            Popup($(elem).html());
        }

        function Popup(data) {
            var mywindow = window.open('', 'SGI', 'height=600,width=800');
            mywindow.document.write('<html><head><title>SGI</title><meta charset="UTF-8" />');
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
</script>