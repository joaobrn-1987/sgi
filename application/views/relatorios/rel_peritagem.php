<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<!--
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
                <div class="span12" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <form action="<?php echo base_url() ?>index.php/desenho/aguardandodesenho/1" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                            <input type="text" class="span12" value=""  name="idOrcamento"/>
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento Item: </label>
                                            <input type="text" class="span12" value=""  name="idOrcamentoItem"/>
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
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Status Desenho: </label>
                                            <select class="span12 form-control" name="statusDesenho">
                                                <option value=""></option>
                                                <option value="1">Aguardando Desenho</option>
                                                <option value="2">Incompleto</option>
                                                <option value="3">Finalizado</option>
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
</div>-->
<div class="buttons">

    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
    <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="peritagem_andamento">Excel</a>
</div>
<div class="row-fluid" style="margin-top:0" id="divTop">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-tags"></i>
				</span>
				<h5>O.S. em peritagem</h5>
			</div>
            <div id="fixed_table_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="fixed_table"></label></div>
			<div class="widget-content nopadding">
				<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
							<div class="span12" id="divCadastrarOs">                                
								<div class="widget-box" style="margin-top:0px">                                        
									<table id="fixed_table" class="table table-bordered " style="font-size: 12px;line-height:normal">
										<thead>
											<tr>
												<th>O.S.</th>
												<th>Orç.</th>
												<th>Cliente</th>
												<th>Vendedor</th>                                                
												<th>Data O.S.</th> 
												<th>NF Cliente</th>
												<th>Qtd.</th>
												<th>Item - Descrição</th>
												<th>PN</th>
												<th>Valor</th>
												<th>Data Ent.</th>
												<th>Reprogr.</th>
                                                
											</tr>
										</thead>
										<tbody>   
                                            <?php 
                                            $valorTotal = 0;
                                            foreach($result as $b){
                                                $valorTotal += $b->val_unit*$b->qtd_os;
                                                echo '<tr>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.$b->idOs.'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.$b->idOrcamentos.'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.(strlen($b->nomeCliente)>32?substr($b->nomeCliente,0,32)."(...)":$b->nomeCliente).'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.$b->nomeVendedor.'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.(!empty($b->data_abertura)?date("d/m/Y", strtotime($b->data_abertura)):"").'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.$b->nf_cliente.'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.$b->qtd_os.'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.(strlen($b->descricao_item)>40?substr($b->descricao_item,0,40)."(...)":$b->descricao_item).'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.(strlen($b->pn)>10?substr($b->pn,0,10)."(...)":$b->pn).'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')?"R$ </br>".number_format((float) $b->val_unit*$b->qtd_os , 2, ",", "."):"Oculto").'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.(!empty($b->data_entrega)?date("d/m/Y", strtotime($b->data_entrega)):"").'</td>'.
                                                    '<td style="padding:0px; height:31px; line-height:normal">'.(!empty($b->data_reagendada)?date("d/m/Y", strtotime($b->data_reagendada)):"").'</td>'.
                                                '</tr> ';
                                            }
                                            
                                            ?>                                                 
											                                                 
																															   
										</tbody>
									</table>
								</div>     
                                <?php if($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')){
                                    echo "Total R$ ".number_format((float) $valorTotal , 2, ",", ".");
                                } ?>                           
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

    });
    $(document).ready(function() {
        $("#imprimir").click(function() {
            PrintElem('#divTop');
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
            
            /*
            setTimeout(function(){
                executarPrint(mywindow)}
            , 1000);*/
            mywindow.print();
            
            //mywindow.close();

            return true;
        }
        function executarPrint(objeto){
            objeto.print()
        }
    })
    $(document).ready( function () {
        
        $('#fixed_table').DataTable({
            'columnDefs': [ {
                'targets': [0], // column index (start from 0)
                'orderable': true, // set orderable false for selected columns
            }],
            "order": [[0, "asc"]],
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
                    "sFirst":    "Primeiro",
                    "sLast":    "Último",
                    "sNext":    "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });
        
        
    } );
</script>