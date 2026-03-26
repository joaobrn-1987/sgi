<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5 style="    padding-right: 0px;">Entrada de Produtos</h5>
                <input class="span12" class="form-control" id="departamento2"
                                                type="text" name="departamento2" value="" disabled style="border:0px;width:50%;margin:3px" />
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs">
                                <form class="form-inline">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span1" class="control-group">
                                            <label for="cliente" class="control-label">PN:</label>
                                            <input class="span12" class="form-control" id="pn"
                                                type="text" name="pn" value="" />
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="cliente"
                                                class="control-label">Descrição:</label>
                                            <input class="span12" class="form-control" id="prod"
                                                type="text" name="prod" value="" />
                                            <input id="idProdutos" type="hidden" name="idProdutos"
                                                value="" />
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="cliente"
                                                class="control-label">Categoria:</label>
                                            <input class="span12" class="form-control"
                                                id="categoriaEntrada" type="text"
                                                name="categoriaEntrada" value="" />
                                            <input id="idCategoriaEntrada" type="hidden"
                                                name="idCategoriaEntrada" value="" />
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="cliente"
                                                class="control-label">Subcategoria:</label>
                                            <input class="span12" class="form-control"
                                                id="subcategoriaEntrada" type="text"
                                                name="subcategoriaEntrada" value="" />
                                            <input id="idSubcategoriaEntrada" type="hidden"
                                                name="idSubcategoriaEntrada" value="" />
                                        </div>

                                        <div class="span2" class="control-group">
                                            <label for="idMedicao"
                                                class="control-label">Unidade:</label>
                                            <select class="span12 form-control" name="idMedicao"
                                                id="idMedicao" onchange="verificar(this.value)">
                                                <option value="0">Unidade</option>
                                                <option value="1">Unidade/Comprimento</option>
                                                <option value="2">Unidade/Volume</option>
                                                <option value="3">Unidade/Peso</option>
                                            </select>
                                        </div>
                                        <div class="tamanho">
                                            <div class="span1" class="control-group"
                                                style="margin-left: 35px">
                                                <label for="cliente"
                                                    class="control-label">Comprimento(cm):</label>
                                                <input class="span12" class="form-control" id="tamanho"
                                                    type="text" name="tamanho" value="" />
                                                <input id="tamanho" type="hidden" name="tamanho"
                                                    value="" />
                                            </div>
                                        </div>
                                        <div class="volume">
                                            <div class="span1" class="control-group"
                                                style="margin-left: 35px">
                                                <label for="cliente"
                                                    class="control-label">Volume(ml):</label>
                                                <input class="span12" class="form-control" id="volume"
                                                    type="text" name="volume" value="" />
                                                <input id="volume" type="hidden" name="volume"
                                                    value="" />
                                            </div>
                                        </div>
                                        <div class="peso">
                                            <div class="span1" class="control-group"
                                                style="margin-left: 35px">
                                                <label for="cliente"
                                                    class="control-label">Peso(g):</label>
                                                <input class="span12" class="form-control" id="peso"
                                                    type="text" name="peso" value="" />
                                                <input id="peso" type="hidden" name="peso" value="" />
                                            </div>
                                        </div>
                                        <div class="span1" class="control-group">
                                            <label for="cliente" class="control-label">Qtd.
                                                ent.:</label>
                                            <input class="span12" class="form-control" id="qtd"
                                                type="text" name="qtd" value="" />
                                            <input id="qtd" type="hidden" name="qtd" value="" />
                                        </div>
                                        <div class="span1" class="control-group">
                                            <label for="cliente" class="control-label">N.
                                                Fiscal:</label>
                                            <input class="span12" class="form-control" id="nf"
                                                type="text" name="nf" value="" />
                                            <input id="nf" type="hidden" name="nf" value="" />
                                        </div>
                                        
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span1" class="control-group">
                                            <label for="cliente" class="control-label">Valor U.:</label>
                                            <input class="span12" class="form-control" id="valorUnit"
                                                type="text" name="valorUnit" value=""
                                                onKeyPress="FormataValor2(this,event,10,3);" />
                                            <input id="nf" type="hidden" name="nf" value="" />
                                        </div>
                                        <!--
                                        <div class="span1" class="control-group">
                                        <label for="idEmpresa"
                                                class="control-label"></label>
                                        
                                        </div>-->
                                        
                                        
                                        <div class="span2" class="control-group">
                                            <label for="localp" class="control-label">Local:</label>
                                            <input class="span12" class="form-control" id="localp"
                                                type="text" name="localp" value="" />
                                            <input id="idLocalp" type="hidden" name="idLocalp"
                                                value="" />
                                        </div>
                                        <div class="span1" class="control-group">
                                            <label for="idOs" class="control-label">Cod. OS:</label>
                                            <input class="span12" class="form-control" id="idOs"
                                                type="text" name="idOs" value="" />
                                        </div>
                                        <div class="span1" class="control-group">
                                            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){ ?>
                                            <label for="cliente" class="control-label"></label>
                                            <a class="btn"
                                                onclick="verificarInsumoCategoriaSubcategoria()"
                                                style="justify-content: flex-end; display: table;">Adicionar</a>

                                            <?php } ?>
                                        </div>
                                        <div class="span1" class="control-group"
                                            style="margin-left:10px">
                                            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){ ?>
                                            <label for="cliente" class="control-label"></label>
                                            <a class="btn btn-success"
                                                onclick="verificarTableEntrada()"
                                                style="justify-content: flex-end; display: table;">Finalizar</a>

                                            <?php } ?>
                                        </div>

                                    </div>
                                    <!--
                        <div class="span12" style="padding: 1%; margin-left: 0">
                        
                        </div>-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>