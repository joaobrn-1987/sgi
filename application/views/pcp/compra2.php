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
</div>
<form action="<?php echo base_url() ?>index.php/pcp/informarvalores" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div align='center' style="margin-top:10px">
        <button type="submit" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Valor</button>
    </div>
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Itens</h5>
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
                                                    <th></th>
                                                    <th>O.S.</th>
                                                    <th>Data Alteração</th>
                                                    <th>Qtd</th>
                                                    <th>Descrição</th>
                                                    <th>OBS</th> 
                                                    <th>Data Cadastro</th> 
                                                    <th>Status</th>
                                                    <th>Usuário</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($result as $r){
                                                        echo '<tr>';
                                                            echo '<td>';
                                                                echo '<input type="checkbox" name="distribuiros[]" id="distribuiros[]" value="'.$r->idDistribuir.'">';
                                                            echo '</td>';
                                                            echo '<td>';
                                                                echo $r->idOs;
                                                            echo '</td>';
                                                            echo '<td>';
                                                                if(!empty($r->data_alteracao)){ 
                                                                    $date = new DateTime( $r->data_alteracao );
                                                                    echo $date-> format( 'd/m/Y' );
                                                                }
                                                            echo '</td>';
                                                            echo '<td>';
                                                                echo $r->quantidade;
                                                            echo '</td>';
                                                            echo '<td>';
                                                                $html = $r->descricaoInsumo;
                                                                if(!empty($r->dimensoes)){
                                                                    $html.=" ".$r->dimensoes;
                                                                } 
                                                                if(!empty($r->comprimento)){
                                                                    $html.=" ".$r->comprimento." cm";
                                                                } 
                                                                if(!empty($r->volume)){
                                                                    $html.=" ".$r->volume." ml";
                                                                } 
                                                                if(!empty($r->peso)){
                                                                    $html.=" ".$r->peso." g";
                                                                } 
                                                                
                                                                if(!empty($r->dimensoesL)){
                                                                    $html .= " Largura: ".$r->dimensoesL." mm";
                                                                }
                                                                if(!empty($r->dimensoesC)){
                                                                    $html .= " Comp.: ".$r->dimensoesC." mm";
                                                                }
                                                                if(!empty($r->dimensoesA)){
                                                                    $html .= " Altura: ".$r->dimensoesA." mm";
                                                                }
                                                                echo $html;
                                                            echo '</td>';
                                                            echo '<td>';
                                                                echo $r->obs;
                                                            echo '</td>';
                                                            echo '<td>';
                                                                if(!empty($r->data_dist)){ 
                                                                    $date = new DateTime( $r->data_dist );
                                                                    echo $date-> format( "d/m/Y" );
                                                                }
                                                            echo '</td>';
                                                            echo '<td>';
                                                                echo $r->nomeStatus;
                                                            echo '</td>';
                                                            echo '<td>';
                                                                echo $r->nome;
                                                            echo '</td>';
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

</form>

