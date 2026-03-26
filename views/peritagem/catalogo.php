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
                <h5>Catálogo</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Cliente: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Solicitante: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Descrição Produto: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Ref.: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    <div class="span3" class="control-group">
                                        <label for="idGrupoServico" class="control-label">TAG: </lzabel>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</br>
<div align='center'>
    <a name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success" href="<?php echo base_url().'index.php/peritagem/adicionarcatalogo' ?>"><i class="icon-plus icon-white"></i>Adicionar Catálogo</a>
</div>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Checklist</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
					<div class="span12" id="divCadastrarOs">                                
						<div class="widget-box" style="margin-top:0px">                                        
							<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
								<thead>
									<tr>
										<th>PN</th>
										<th>Descrição</th>
                                        <th>Data cadastro</th>
										<th>Autor</th> 
                                        <th></th>    
									</tr>
								</thead>
								<tbody>
                                    <?php foreach($catalogos as $r){
                                        echo '<tr>';
                                            echo '<td>'.$r->pn.'</td>';
                                            echo '<td>'.$r->descricao.'</td>';
                                            echo '<td>'.date("d/m/Y", strtotime($r->data_cadastro)).'</td>';
                                            echo '<td>'.$r->nome.'</td>';
                                            echo '<td><a href="'.base_url().'index.php/peritagem/visualizarcatalogo/'.$r->idCatalogoProduto.'" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a></td>';
                                        echo'</tr>';
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
<div align='center'>
    <a name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success" href="<?php echo base_url().'index.php/peritagem/adicionarcatalogo' ?>"><i class="icon-plus icon-white"></i>Adicionar Catálogo</a>
</div>