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
                            <form action="<?php echo base_url() ?>index.php/relatorios/relfaturamento" method="post" name="form1" id="form1">
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
				<h5>Histórico faturamento</h5>
			</div>
			<div class="widget-content nopadding">
				<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
							<div class="span12" id="divCadastrarOs">                                
								<div class="widget-box" style="margin-top:0px">                                        
									<table id="tableHistVale" class="table table-bordered ">
										<thead>
											<tr>
												<th>O.S.</th>
                                                <th>Unid. exec.</th>
                                                <th>Contrato.</th>
                                                <th>Descrição</th>
                                                <th>Cliente</th>
												<th>Valor Orç</th>
												<th>Valor O.S.</th>
												<th>Valor Insumo</th>
											</tr>
										</thead>
										<tbody>
                                            <?php 
                                                foreach($listOs as $r){
                                                    echo '<tr>';
                                                        echo '<td>'.$r->idOs.'</td>';
                                                        echo '<td>'.$r->status_execucao.'</td>';
                                                        echo '<td>'.$r->contrato.'</td>';
                                                        echo '<td>'.$r->descricao_item.'</td>';
                                                        echo '<td>'.$r->nomeCliente.'</td>';
                                                        echo '<td>'.$r->valorOrc.'</td>';
                                                        echo '<td>'.$r->valorOS.'</td>';
                                                        echo '<td>'.$r->valorInsumos.'</td>';
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
</script>