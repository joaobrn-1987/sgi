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
                            <form action="<?php echo base_url() ?>index.php/almoxarifado/linhadotempo" method="post" name="form1" id="form1">
                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Data: </label>
                                            <input type="text" class="data datepicker span12" value="" name="data"/>
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idEmpresa" class="control-label">Empresa:</label>                        
                                            <select class="span12 form-control" name="idEmpresa" id="idEmpresaRelSai">
                                            <option value="">Todos</option>
                                            <?php foreach($dados_emitente as $r){
                                            ?>
                                                <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                                            <?php
                                            }?>                          
                                            </select>
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idEmpresa" class="control-label">Departamento:</label>
                                            <select class="span12 form-control" name="idDepartamento" id="idDepartamentoRelSai">      
                                            <option value="">Todos</option>   
                                            <?php foreach($dados_departamento as $r){
                                            ?>
                                                <option value="<?php echo $r->idAlmoEstoqueDep ?>"><?php echo $r->descricaoDepartamento ?> </option>
                                            <?php
                                            }?>
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
				<h5>Estoque no dia <b><?php echo $datahjexib;?></b></h5>
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
                                                <th>PN</th>
												<th>Descrição</th>
												<th>Qtd</th>   
                                                <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vvalorOs')){?>
												<th>Média Val. Unit.</th>  
												<th>Valor</th>   
                                                <?php }?>
												<th>Empresa</th>
												<th>Departamento</th>
											</tr>
										</thead>
										<tbody>
                                            <?php 
                                            $total = 0;
                                                foreach($result as $r){
                                                    $total += (float)$r->mediaValorUnit*((float)$r->quantidade_entrada-(float)$r->quantidade_saida);
                                                    echo '<tr>';
                                                        echo '<td>'.$r->pn.'</td>';
                                                        echo '<td>'.$r->descricaoInsumo.'</td>';
                                                        echo '<td>'.($r->quantidade_entrada-$r->quantidade_saida).'</td>';
                                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'vvalorOs')){
                                                            echo '<td>'.number_format($r->mediaValorUnit,2,",",".").'</td>';
                                                            echo '<td>'.number_format($r->mediaValorUnit*($r->quantidade_entrada-$r->quantidade_saida),2,",",".").'</td>';
                                                        }
                                                        echo '<td>'.$r->nome.'</td>';
                                                        echo '<td>'.$r->descricaoDepartamento.'</td>';
                                                    echo '</tr>';
                                                }
                                            ?>                                                 
											 																		   
										</tbody>
                                        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vvalorOs')){?>
                                        <tbody>
                                            <tr>
                                                <td colspan="4">Total</td>
                                                <td><?php echo number_format($total,2,",",".");?></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tbody>
                                        <?php }?>
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
    console.log("Com valor:  <?php echo $comvalor?> Itens")
    console.log("Sem valor:  <?php echo $semvalor?> Itens")
    $(document).ready(function(){
      
      jQuery(".data").mask("99/99/9999");
    });
    $(document).ready(function(){
      $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy', language: 'pt-BR', locale: 'pt-BR' });
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