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

                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <form action="<?php echo base_url() ?>index.php/mapos/gerarsubos" method="post" name="form1" id="form1">
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Gerar SubOs: </label>
                                            <input type="text" name="idOs" id="idOs" >
                                            <button >Gerar</button>
                                        </div>
                                        
                                    </form>
                                    <form  action="<?php echo base_url() ?>index.php/mapos/gerarescopo" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Gerar Escopo: </label>
                                            <input type="file" name="userfile" id="arquivo" class="form-control" accept=".csv">
                                            <button >Gerar</button>
                                        </div>
                                    </form>
                                    <form  action="<?php echo base_url() ?>index.php/mapos/carregarPlanilhaMP" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Carregar Estq. MP: </label>
                                            <input type="file" name="userfile" id="arquivo" class="form-control" accept=".csv">
                                            <button >Gerar</button>
                                        </div>
                                    </form>
                                    <form  action="<?php echo base_url() ?>index.php/mapos/substituirEscopoPadraoCilindro" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Recarregar Escopo </label>
                                            <button>Gerar</button>
                                        </div>
                                    </form>
                                    <!--
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
                                        </div> -->
                                </div>
                                <!--
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <button type="submit" class="btn btn-success"><i class="icon-white"></i>Filtrar</button>
                                        </div>
                                    </div> -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
<div class="row-fluid" style="margin-top:0">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-tags"></i>
				</span>
				<h5>Histórico Vale</h5>
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
												<th>Data</th>
												<th>O.S. Origem</th>
												<th>O.S. Destino</th>
												<th>Item</th>                                                
												<th>Qtd</th> 
												<th>Usuário</th>
											</tr>
										</thead>
										<tbody>                                                    
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
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
</div>-->