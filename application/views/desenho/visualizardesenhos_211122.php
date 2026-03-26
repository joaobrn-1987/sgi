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
                <h5>Informações O.S. / Orç.</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                        <input type="text" class="span12" value="<?php echo $orcam->idOrcamentos ?>" readonly />
                                    </div>
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Orç. Item: </label>
                                        <input type="text" class="span12" value="<?php echo $orcam->idOrcamento_item ?>" readonly />
                                    </div>
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">O.S.: </label>
                                        <input type="text" class="span12" value="<?php echo $orcam->idOs ?>" readonly />
                                    </div>
                                    <div class="span6" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Cliente: </label>
                                        <input type="text" class="span12" value="<?php echo $orcam->nomeCliente ?>" readonly />
                                    </div>
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                        <input type="text" class="span12" value="<?php echo $orcam->pn ?>" readonly />
                                    </div>
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Ref.: </label>
                                        <input type="text" class="span12" value="<?php echo $orcam->referencia ?>" readonly />
                                    </div>
                                    <div class="span8" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Descrição Produto: </label>
                                        <input type="text" class="span12" value="<?php echo $orcam->descricao_item ?>" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- -->
<form action="<?php echo base_url() ?>index.php/desenho/finalizar"
            method="post" name="form1" id="form1">    
            <input type="hidden" id="idOrcItem2" name="idOrcItem2" value="<?php echo $orcam->idOrcamento_item?>">
    <div align='center'> 
        </br>
        <button type="submit" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success"><i class="icon-plus icon-white"></i> Finalizar</button>
    </div>
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Desenhos</h5>
                    <a href="#modal_cad_desenho" data-toggle="modal" role="button" class="btn btn-success span2"><i class="icon-plus icon-white"> Adicionar</i> </a>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs">
                                    <div class="widget-box" style="margin-top:0px">
                                        <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                            <thead>
                                                <tr>
                                                    <!--
                                                    <th>Orç. Item</th>
                                                    <th>PN</th>
                                                    <th>Descrição</th>-->
                                                    <th>Arquivo</th>
                                                    <th>Status Desenho</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($result as $r) {
                                                    echo '<tr>';/*
                                                        echo '<td>' . $r->idOrcamento_item . '</td>';
                                                        echo '<td>' . $r->pn . '</td>';
                                                        echo '<td>' . $r->descricao_item . '</td>'; */
                                                    echo '<td><a href="' . base_url() .  $r->caminho . $r->imagem . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>
                                                                <a href=' . base_url() . $r->caminho . $r->imagem . ' target="_blank">' . $r->nomeArquivo . $r->extensao . '</a>
                                                                </td>';
                                                    echo '<td>' . ($r->statusAnexo == 1 ? 'Aguardando Verificação' : ($r->statusAnexo == 2 ? 'Aprovado' : 'Rejeitado')) . '</td>';
                                                    if ($r->statusAnexo != 1) {
                                                        if($r->statusAnexo == 2){
                                                            echo '<td></td>';
                                                            echo '<td style="text-align: center;"><a href="#modalReprovar" idAnexo = "' . $r->idAnexo . '" tipoa = "2" linkdesenho = "' . base_url() . $r->caminho . $r->imagem . '" nomedesenho="' . $r->nomeArquivo . $r->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';

                                                        }
                                                        if($r->statusAnexo == 3){
                                                            
                                                            echo '<td style="text-align: center;"><a href="#modalAprovar" idAnexo = "' . $r->idAnexo . '" tipoa = "1" linkdesenho = "' . base_url() . $r->caminho . $r->imagem . '" nomedesenho="' . $r->nomeArquivo . $r->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                            echo '<td></td>';
                                                            
                                                        }
                                                        
                                                    } else {
                                                        echo '<td style="text-align: center;"><a href="#modalAprovar" idAnexo = "' . $r->idAnexo . '" tipoa = "1" linkdesenho = "' . base_url() . $r->caminho . $r->imagem . '" nomedesenho="' . $r->nomeArquivo . $r->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                        echo '<td style="text-align: center;"><a href="#modalReprovar" idAnexo = "' . $r->idAnexo . '" tipoa = "2" linkdesenho = "' . base_url() . $r->caminho . $r->imagem . '" nomedesenho="' . $r->nomeArquivo . $r->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
                                                    }
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
    <div align='center'> 
        <button type="submit" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success"><i class="icon-plus icon-white"></i> Finalizar</button>
    </div>
</form>
<div id="modalAprovar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/desenho/aprovardesenho" method="post" enctype="multipart/form-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Deseja aprovar esse desenho? </h5>
        </div>
        <div class="modal-body">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">
                                            <div class="widget-box" style="margin-top:0px">
                                                <input id="idAnexo2" name="idAnexo2" value="" type="hidden">
                                                <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                                    <thead>
                                                        <tr>
                                                            <th>Arquivo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><a href=" " id="aAprovar" target="_blank"></a></td>
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
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success">Adicionar</button>
        </div>
    </form>
</div>
<div id="modalReprovar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/desenho/reprovardesenho" method="post" enctype="multipart/form-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Deseja reprovar esse desenho? </h5>
        </div>
        <div class="modal-body">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">
                                            <div class="widget-box" style="margin-top:0px">
                                                <input id="idAnexo3" name="idAnexo3" value="" type="hidden">
                                                <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                                    <thead>
                                                        <tr>
                                                            <th>Arquivo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><a href=" " id="aAprovar2" target="_blank"></a></td>
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
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success">Adicionar</button>
        </div>
    </form>
</div>
<div id="modal_cad_desenho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Cadastrar Desenho </h5>
    </div>
    <div class="modal-body">
        <form action="<?php echo base_url(); ?>index.php/desenho/cad_desenho" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
            <div class="control-group">
                <label for="obs_controle" class="control-label">Nome arquivo</label>
                <div class="controls">
                    <input id="nomeArquivo" type="text" name="nomeArquivo" value="" />
                    <input id="idOrcItem" type="hidden" name="idOrcItem" value="<?php echo $orcam->idOrcamento_item;?>" />
                </div><!--
                <label for="obs_controle" class="control-label">Tipo</label>
                <div class="controls">
                    <select name="tipo" id="tipo">
                        <option value="CATÁLOGO">Catálogo</option>
                        <?php
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'adesenhoOs')) { ?>
                            <option value="DESENHO" <?php if ($this->session->userdata('permissao') == "7") {
                                                        echo 'selected';
                                                    } ?>>Desenho</option>
                        <?php } ?>
                        <?php
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aPeritagem')) { ?>
                            <option value="PERITAGEM">Peritagem</option>
                        <?php } ?>

                        <option value="OUTROS">Outros</option>
                    </select>
                </div> -->

                <label for="arquivo" class="control-label"><span class="required">Arquivo</span></label>
                <div class="controls">
                    <input id="arquivo" type="file" name="userfile" />
                </div>


            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
                <button class="btn btn-primary">Cadastrar</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var tipoa = $(this).attr('tipoa');
            var idAnexo = $(this).attr('idAnexo');
            $('#idAnexo2').val(idAnexo);
            $('#aAprovar').attr('href', $(this).attr('linkdesenho'));
            $('#aAprovar').append($(this).attr('nomedesenho'));

            $('#idAnexo3').val(idAnexo);
            $('#aAprovar2').attr('href', $(this).attr('linkdesenho'));
            $('#aAprovar2').append($(this).attr('nomedesenho'));

        });
    });
</script>