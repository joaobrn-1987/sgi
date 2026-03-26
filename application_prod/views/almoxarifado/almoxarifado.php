<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.buttonLoader.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/buttonLoader.css" rel="stylesheet">

<style type="text/css">
.tamanho{
  display: none
}
.volume{
  display: none
}
.peso{
  display: none
}
.dimensoes{
  display: none
}

.tamanhoe{
  display: none
}
.volumee{
  display: none
}
.pesoe{
  display: none
}
.dimensoese{
  display: none
}
.entradaRelatorio{
  display: block
}
.saidaRelatorio{
  display: none
}
.entradaRelatorioTAB{
  display: block
}
.saidaRelatorioTAB{
  display: none
}
</style><!--
<div class="btn-group">
    <a class="btn dropdown-toggle" data-toggle="dropdown" role="button">
        Cadastro
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <?php foreach($dados_departamento as $r){
            if($r->idAlmoEstoqueDep == 1){
            ?>
            <li><a tabindex="-1" 'href="#produtos" role="button"
                onclick="showDiv<?php echo $r->idAlmoEstoqueDep ?>()"><?php echo $r->descricaoDepartamento ?></a></li>
                <?php
            }else{?>
            <li><a tabindex="-1" 'href="#insumos" role="button"
                onclick="showDiv<?php echo $r->idAlmoEstoqueDep ?>()"><?php echo $r->descricaoDepartamento ?></a></li>
                <?php
            }?>
        
        
        <?php
        }?>
        <li class="divider"></li>
        <li><a tabindex="-1" 'href="#usuario" role="button" onclick="showDivUsuario()">USUÁRIO</a></li>
    </ul>
</div>-->

<div>
  
</div>



<div id="insumos" style="display:<?php if($dados_departamento[0]->idAlmoEstoqueDep == 1){echo "none";}else{echo "block";}?>">
    <div class="tabbable" style="margin-top: 30px;">
        <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Entrada</a></li>
            <li><a href="#tab2" data-toggle="tab">Saída</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">


                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5 style="    padding-right: 0px;">Entrada de Produtos</h5>
                                <input class="span12" class="form-control" id="departamento2"
                                                                type="text" name="departamento2" value="<?php if($dados_departamento[0]->idAlmoEstoqueDep != 1){echo $dados_departamento[0]->descricaoDepartamento;}?>" disabled style="border:0px;width:50%;margin:3px" />
                            </div>
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="span12" id="divCadastrarOs">
                                                <form class="form-inline">
                                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                                        <div class="span2" class="control-group">
                                                            <div class="btn-group">
                                                                <a class="btn dropdown-toggle" data-toggle="dropdown" role="button">
                                                                    Departamento
                                                                    <span class="caret"></span>
                                                                </a>
                                                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="position: relative">
                                                                    <?php foreach($dados_departamento as $r){
                                                                        if($r->idAlmoEstoqueDep == 1){
                                                                        ?>
                                                                        <li><a tabindex="-1" 'href="#produtos" role="button"
                                                                            onclick="showDiv<?php echo $r->idAlmoEstoqueDep ?>()"><?php echo $r->descricaoDepartamento ?></a></li>
                                                                            <?php
                                                                        }else{?>
                                                                        <li><a tabindex="-1" 'href="#insumos" role="button"
                                                                            onclick="showDiv<?php echo $r->idAlmoEstoqueDep ?>()"><?php echo $r->descricaoDepartamento ?></a></li>
                                                                            <?php
                                                                        }?>
                                                                    
                                                                    
                                                                    <?php
                                                                    }?><!--
                                                                    <li class="divider"></li>
                                                                    <li><a tabindex="-1" 'href="#usuario" role="button" onclick="showDivUsuario()">USUÁRIO</a></li>-->
                                                                </ul>
                                                            </div>
                                                            <input class="span12" class="form-control" id="departamento"
                                                                type="text" name="departamento" value="<?php if($dados_departamento[0]->idAlmoEstoqueDep != 1){echo $dados_departamento[0]->descricaoDepartamento;}?>" disabled />
                                                            <input id="idDepartamento" type="hidden" name="idDepartamento"
                                                                value="<?php if($dados_departamento[0]->idAlmoEstoqueDep != 1){echo $dados_departamento[0]->idAlmoEstoqueDep;}?>" />
                                                        </div>                                 
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente"
                                                                class="control-label">Categoria:</label>
                                                            <input class="span12" class="form-control"
                                                                id="categoriaEntrada" type="text"
                                                                name="categoriaEntrada" value=""  />
                                                            <input id="idCategoriaEntrada" type="hidden"
                                                                name="idCategoriaEntrada" value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente"
                                                                class="control-label">Subcategoria:</label>
                                                            <input class="span12" class="form-control"
                                                                id="subcategoriaEntrada" type="text"
                                                                name="subcategoriaEntrada" value=""  />
                                                            <input id="idSubcategoriaEntrada" type="hidden"
                                                                name="idSubcategoriaEntrada" value="" />
                                                        </div>
                                                        <div class="span2" class="control-group">
                                                            <label for="cliente"
                                                                class="control-label">Descrição:</label>
                                                            <input class="span12" class="form-control" id="prod"
                                                                type="text" name="prod" value="" />
                                                            <input id="idProdutos" type="hidden" name="idProdutos"
                                                                value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">PN:</label>
                                                            <input class="span12" class="form-control" id="pn"
                                                                type="text" name="pn" value="" />
                                                                <input class="span12" class="form-control" id="pn4"
                                                                type="hidden" name="pn4" value="" />
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
                                                                <option value="4">Unidade/Dimensões</option>
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
                                                        <div class="dimensoes">
                                                            <div class="span2" class="control-group"
                                                                style="margin-left: 35px">
                                                                <label for="cliente"
                                                                    class="control-label">Dimensões(mm):</label>
                                                                <div class="span12">
                                                                  <input class="span4" class="form-control" id="dimensoesL"
                                                                      type="text" name="dimensoesL" value="" placeholder='Largura'/>
                                                                  <input class="span4" class="form-control" id="dimensoesC"
                                                                      type="text" name="dimensoesC" value="" placeholder='Comp.'/>
                                                                  <input class="span4" class="form-control" id="dimensoesA"
                                                                      type="text" name="dimensoesA" value="" placeholder='Altura'/>
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                                        <div class="span1" class="control-group"
                                                            style="margin-left: 0px">
                                                            <label for="cliente"
                                                                class="control-label">Qtd. Est.:</label>
                                                            <input disabled class="span12" class="form-control" id="qtdEst"
                                                                type="text" name="qtdEst" value="" />
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
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">Valor U.:</label>
                                                            <input class="span12" class="form-control" id="valorUnit"
                                                                type="text" name="valorUnit" value=""
                                                                onKeyPress="FormataValor2(this,event,10,3);" />
                                                            <input id="nf" type="hidden" name="nf" value="" />
                                                        </div>
                                                        <div class="span3" class="control-group">
                                                            <label for="idEmpresa"
                                                                class="control-label">Empresa:</label>
                                                            <select class="span12 form-control" name="idEmpresa"
                                                                id="idEmpresa" onchange="alterarLocal2(this.value)">
                                                                <?php foreach($dados_emitente as $r){
                                                                ?>
                                                                <option value="<?php echo $r->id ?>">
                                                                    <?php echo $r->nome ?> </option>
                                                                <?php
                                                                }?>

                                                            </select>
                                                        </div><!--
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
                                                            <label for="cliente" class="control-label"></label><!--
                                                            <a class="btn"
                                                                onclick="inserirLinhaTabela()"
                                                                style="justify-content: flex-end; display: table;">Adicionar</a>-->
                                                                <a class="btn" type="button" name="aEntradaI" id="aEntradaI"
                                                                onclick="verificarInsumoCategoriaSubcategoria()"
                                                                style="justify-content: flex-end; display: table;">Adicionar</a>
                                                                
                                                            <?php } ?>
                                                        </div>
                                                        <div class="span1" class="control-group"
                                                            style="margin-left:10px">
                                                            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){ ?>
                                                            <label for="cliente" class="control-label"></label>
                                                            <a class="btn btn-success"
                                                                onclick="verificarTableEntrada()" name="fEntradaI" id="fEntradaI"
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

                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-user"></i>
                        </span>
                        <h5>Produtos Adicionados</h5>
                    </div>

                    <div class="widget-content nopadding" id="divTableInsert">
                        <form action="<?php echo base_url() ?>index.php/almoxarifado/cadastrarEntradas"
                            id="formEntradas" enctype="multipart/form-data" method="post">
                            <div class="buttons">
                        
                              <a id="imprimir3" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                              <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="CadastroEntradas">Excel</a>
                            </div>
                            <table class="table table-bordered " id="tableInsert" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	                              font-size:10px;" border="1">
                                <thead>
                                    <tr>

                                        <th>PN.</th>
                                        <th>Descrição</th>
                                        <th>Tamanho(cm)</th>
                                        <th>Volume(ml)</th>
                                        <th>Peso(gm)</th>
                                        <th>Dimensões(mm)</th>
                                        <th>Quantidade</th>
                                        <th>Empresa</th>
                                        <th>Departamento</th>
                                        <th>Local</th>
                                        <th>Nota Fiscal</th>
                                        <th>Valor Unit.</th>
                                        <th>Valor Total</th>
                                        <th>OS</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $tabelaEntrada = [];
                            if(isset($_COOKIE['tabelaEntrada']))
                            $tabelaEntrada = json_decode($_COOKIE['tabelaEntrada']);
                                if(isset($tabelaEntrada))
                                foreach($tabelaEntrada as $r){?>
                                    <tr>
                                        <td><?php echo $r->pn4?><input value=<?php echo $r->pn?> name='idProdutoTD_[]'
                                                id='idProdutoTD_[]' type='hidden' /></td><input
                                                value=<?php echo $r->medicao?> name='idMedicaoTD_[]' id='idMedicaoTD_[]'
                                                type='hidden' />
                                        <td><?php echo $r->prod?></td>
                                        <td><?php echo $r->tamanho?><input value=<?php echo $r->tamanho?>
                                                name='tamanhoTD_[]' id='tamanhoTD_[]' type='hidden' /></td>
                                        <td><?php echo $r->volume?><input value=<?php echo $r->volume?>
                                                name='volumeTD_[]' id='volumeTD_[]' type='hidden' /></td>
                                        <td><?php echo $r->peso?><input value=<?php echo $r->peso?> name='pesoTD_[]'
                                                id='pesoTD_[]' type='hidden' /></td>
                                        <td><?php echo $r->dimensoes?><input value=<?php echo $r->dimensoes?> name='dimensoesTD_[]'
                                                id='dimensoesTD_[]' type='hidden' /></td>
                                        <td><?php echo $r->qtd?><input value=<?php echo $r->qtd?> name='qtdTD_[]'
                                                id='qtdTD_[]' type='hidden' /></td>
                                        <td><?php echo $r->nomeEmpresa?><input
                                                value=<?php echo $r->idEmpresa?> name='idEmpresaTD_[]'
                                                id='idEmpresaTD_[]' type='hidden' /></td>
                                        <td><?php echo $r->nomeDep?><input
                                                value=<?php echo $r->idDepartamento?> name='idDepartamento_[]'
                                                id='idDepartamento_[]' type='hidden' /></td>
                                        <td><?php echo $r->localp?><input
                                                value=<?php echo $r->idLocalp?> name='idLocalpTD_[]' id='idEmpresaTD_[]'
                                                type='hidden' /></td>
                                        <td><?php echo $r->nf?><input value=<?php echo $r->nf?> name='nFTD_[]'
                                                id='nFTD_[]' type='hidden' /></td>
                                        <td>R$ <?php echo $r->valorUnit?><input value=<?php echo $r->valorUnit?>
                                                name='valorUnit_[]' id='valorUnit_[]' type='hidden' /></td>
                                        <td>R$ <?php echo str_replace(".",",",($r->valorUnit*$r->qtd))?></td>
                                        <td><?php echo $r->idOs?><input value=<?php echo $r->idOs?> name='idOsTD_[]'
                                                id='idOsTD_[]' type='hidden' /></td>
                                        <td> <button style="margin-right: 1%" data-toggle="modal"
                                                class="btn btn-danger tip-top " class="excluir"
                                                onclick="deleteRow(this.parentNode.parentNode.rowIndex)">
                                                <font size=1>Excluir</font>
                                            </button></td>
                                    </tr><?php
                                }?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>


            </div>
            <div class="tab-pane" id="tab2">
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5 style="padding-right: 0px;">Saída de Produtos</h5><input class="span12" class="form-control" id="departamentoS2"
                                                                type="text" name="departamentoS2" value="<?php if($dados_departamento[0]->idAlmoEstoqueDep != 1){echo $dados_departamento[0]->descricaoDepartamento;}?>" disabled style="border:0px;width:50%;margin:3px" />
                            </div>
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="span12" id="divCadastrarOs">
                                                <form class="form-inline">                                                    
                                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                                      <div class="span2" class="control-group"><!--
                                                          <label for="idEmpresa"
                                                              class="control-label">Departamento:</label>--> 
                                                          <div class="btn-group">
                                                            <a class="btn dropdown-toggle" data-toggle="dropdown" role="button">
                                                                Departamento
                                                                <span class="caret"></span>
                                                            </a>
                                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="position: relative">
                                                                <?php foreach($dados_departamento as $r){
                                                                    if($r->idAlmoEstoqueDep == 1){
                                                                    ?>
                                                                    <li><a tabindex="-1" 'href="#produtos" role="button"
                                                                        onclick="showDiv<?php echo $r->idAlmoEstoqueDep ?>()"><?php echo $r->descricaoDepartamento ?></a></li>
                                                                        <?php
                                                                    }else{?>
                                                                    <li><a tabindex="-1" 'href="#insumos" role="button"
                                                                        onclick="showDiv<?php echo $r->idAlmoEstoqueDep ?>()"><?php echo $r->descricaoDepartamento ?></a></li>
                                                                        <?php
                                                                    }?>
                                                                
                                                                
                                                                <?php
                                                                }?><!--
                                                                <li class="divider"></li>
                                                                <li><a tabindex="-1" 'href="#usuario" role="button" onclick="showDivUsuario()">USUÁRIO</a></li>-->
                                                            </ul>
                                                          </div>
                                                          <input class="span12" class="form-control" id="departamentoS"
                                                              type="text" name="departamentoS" value="<?php if($dados_departamento[0]->idAlmoEstoqueDep != 1){echo $dados_departamento[0]->descricaoDepartamento;}?>" disabled/>
                                                          <input id="idDepartamentoS" type="hidden"
                                                              name="idDepartamentoS" value="<?php if($dados_departamento[0]->idAlmoEstoqueDep != 1){echo $dados_departamento[0]->idAlmoEstoqueDep;}?>" />                                                            
                                                      </div> 
                                                      <div class="span1" class="control-group">
                                                          <label for="cliente" class="control-label">PN:</label>
                                                          <input class="span12" class="form-control" id="pnS"
                                                              type="text" name="pnS" value="" />
                                                              <input class="span12" class="form-control" id="pnS4"
                                                              type="hidden" name="pnS4" value="" />
                                                      </div>
                                                      <div class="span2" class="control-group">
                                                          <label for="cliente"
                                                              class="control-label">Descrição:</label>
                                                          <input class="span12" class="form-control" id="prodS"
                                                              type="text" name="prodS" value="" />
                                                          <input id="idAlmoEstoqueS" type="hidden"
                                                              name="idAlmoEstoqueS" value="" />
                                                      </div>                                                  
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">Estoque:</label>
                                                            <input class="span12" class="form-control" id="qtdestS"
                                                                type="text" name="qtdestS" value="" disabled />
                                                            <input id="qtdestS" type="hidden" name="qtdestS" value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">Qtd.
                                                                Saída:</label>
                                                            <input class="span12" class="form-control" id="qtdS"
                                                                type="text" name="qtdS" value="" />
                                                            <input id="qtdS" type="hidden" name="qtdS" value="" />
                                                        </div>
                                                        
                                                       
                                                        <div class="span2" class="control-group">
                                                            <label for="idEmpresa"
                                                                class="control-label">Empresa:</label>
                                                            <select class="span12 form-control" name="idEmpresaS"
                                                                id="idEmpresaS" onchange="alterarEstoque(this.value)">
                                                                <?php foreach($dados_emitente as $r){
                                                                ?>
                                                                <option value="<?php echo $r->id ?>">
                                                                    <?php echo $r->nome ?> </option>
                                                                <?php
                                                                }?>

                                                            </select>
                                                        </div><!--
                                                        <div class="span1" class="control-group">
                                                          <label for="idEmpresa"
                                                                class="control-label"></label>
                                                          
                                                        </div>-->
                                                         
                                                        <div class="span2" class="control-group">
                                                            <label for="localp" class="control-label">Local:</label>
                                                            <input class="span12" class="form-control" id="localS"
                                                                type="text" name="localS" value="" disabled />
                                                            <input id="idLocalS" type="hidden" name="idLocalS"
                                                                value="" />
                                                        </div>                                                        
                                                    </div>

                                                    <div class="span12" style="padding: 1%; margin-left: 0"> 
                                                        <div class="span1" class="control-group">
                                                                <label for="idOs" class="control-label">Cod. OS:</label>
                                                                <input class="span7" class="form-control" id="idOsS"
                                                                    type="text" name="idOsS" value="" />
                                                                <input class="span4" class="icon-search" class="form-control" id="pesqOsS"
                                                                    type="button" onclick="pesquisarOs()" name="pesqOsS" value="" />
                                                        </div>                                                       
                                                        <div class="span3" class="control-group">
                                                            <label for="idEmpresa" class="control-label">Empresa
                                                                Destino:</label>
                                                            <select class="span12 form-control" name="idEmpresaDestS"
                                                                id="idEmpresaDestS">
                                                                <?php foreach($dados_emitente as $r){
                                                                ?>
                                                                <option value="<?php echo $r->id ?>">
                                                                    <?php echo $r->nome ?> </option>
                                                                <?php
                                                                }?>
                                                            </select>
                                                        </div><!--
                                                        <div class="span2" class="control-group">
                                                            <label for="idEmpresa" class="control-label">Setor:</label>
                                                            <select class="span12 form-control" name="idSetor"
                                                                id="idSetor" onchange="alterarSetor2(this.value)">
                                                                <?php foreach($dados_setor as $r){
                                                                ?>
                                                                <option value="<?php echo $r->id_setor ?>">
                                                                    <?php echo $r->nomesetor ?> </option>
                                                                <?php
                                                                }?>

                                                            </select>
                                                        </div>-->
                                                        <div class="span2" class="control-group">
                                                            <label for="cliente" class="control-label">Usuário:</label>
                                                            <input class="span12" class="form-control" id="userS"
                                                                type="text" name="userS" value="" />
                                                                <input class="span12" class="form-control" id="userS2"
                                                                type="hidden" name="userS2" value="" />
                                                            <input id="idUserS" type="hidden" name="idUserS" value="" />
                                                        </div> 
                                                        <div class="span2" class="control-group">
                                                            <label for="cliente" class="control-label">Setor:</label>
                                                            <input class="span12" class="form-control" id="nomeSetor"
                                                                type="text" name="nomeSetor" value="" disabled/>
                                                            <input id="idSetor" type="hidden" name="idSetor" value="" />
                                                        </div>                                                       
                                                        <div class="span2" class="control-group">
                                                            <label for="localp" class="control-label">OBS.:</label>
                                                            <input class="span12" class="form-control" id="obsS"
                                                                type="text" name="obsS" value="" />
                                                        </div>

                                                        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){ ?>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label"></label>
                                                            <a class="btn" class="form-control" class="btn-add-saida"
                                                                onclick="inserirLinhaTabelaSaida()" name='aSaidaI' id='aSaidaI'
                                                                style="justify-content: flex-end; display: table;">Adicionar</a>
                                                        </div>
                                                        <div class="span1" class="control-group"
                                                            style="margin-left:10px">
                                                            <label for="cliente" class="control-label"></label>
                                                            <a class="btn btn-success" class="form-control"
                                                                onclick="verificarTableSaida();" name='fSaidaI' id='fSaidaI'
                                                                style="justify-content: flex-end; display: table;">Finalizar</a>
                                                        </div> <?php
                                                                }?>
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

                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-user"></i>
                        </span>
                        <h5>Produtos</h5>
                    </div>

                    <div class="widget-content nopadding" id="divTableSaida">
                        <form action="<?php echo base_url() ?>index.php/almoxarifado/cadastrarSaidas" id="formSaidas"
                            enctype="multipart/form-data" method="post">
                            <div class="buttons">
                        
                              <a id="imprimir2" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                              <a href=javascript:; class="export2-csv btn btn-mini btn-inverse" data-filename="CadastroSaidas">Excel</a>
                            </div>
                            <table class="table table-bordered " id="tableSaida" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	                            font-size:10px;" border="1">
                                <thead>
                                    <tr>
                                        <th>PN</th>
                                        <th>Descrição</th>
                                        <th>Quantidade</th>
                                        <th>Local Estoque</th>
                                        <th>Empresa Destino</th>
                                        <th>Setor</th>
                                        <th>Usuário</th>
                                        <th>OS</th>
                                        <th>OBS</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            if(isset($_COOKIE['tabelaSaida'])){
                              $tabelaSaida = json_decode($_COOKIE['tabelaSaida']);
                            }              
                            if(isset($tabelaSaida)){
                            foreach($tabelaSaida as $r){
                                ?><tr>
                                        <td><?php echo $r->pnS4 ?><input value=<?php echo $r->idAlmoEstoque ?>
                                                name='idAlmoEstoque_[]' id='idAlmoEstoque_[]' type='hidden' /></td>
                                        <td><?php echo $r->nomeProduto ?></td>
                                        <td><?php echo $r->qtd ?><input value=<?php echo $r->qtd ?> name='qtd_[]'
                                                id='qtd_[]' type='hidden' /></td>
                                        <td><?php echo $r->local ?></td>
                                        <td><?php echo $r->nomeEmpresaS ?><input value=<?php echo $r->idEmpresaS ?>
                                                name='idEmitenteDest_[]' id='idEmitenteDest_[]' type='hidden' /></td>
                                        <td><?php echo $r->nomeSetor ?><input value=<?php echo $r->idSetor ?>
                                                name='idSetor_[]' id='idSetor_[]' type='hidden' /></td>
                                        <td><?php echo $r->userNome ?><input value=<?php echo $r->user ?> name='user_[]'
                                                id='user_[]' type='hidden' /></td>
                                        <td><?php echo $r->idOs ?><input value=<?php echo $r->idOs ?> name='idOs_[]'
                                                id='idOs_[]' type='hidden' />
                                        <td><?php echo $r->obs ?><input value=<?php echo $r->obs ?> name='obs_[]'
                                                id='obs_[]' type='hidden' />
                                        <td><button style="margin-right: 1%" data-toggle="modal"
                                                class="btn btn-danger tip-top " class="excluir"
                                                onclick="deleteRow2(this.parentNode.parentNode.rowIndex)">
                                                <font size=1>Excluir</font>
                                            </button></td>
                                      </tr>
                                        <?php
                                        
                                        }
                                        }
                                        ?>
                                    
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="produtos" style="display:<?php if($dados_departamento[0]->idAlmoEstoqueDep == 1){echo "block";}else{echo "none";}?>;">
    <div class="tabbable" style="margin-top: 30px;">
        <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab3" data-toggle="tab">Entrada</a></li>
            <li><a href="#tab4" data-toggle="tab">Saída</a></li>
        </ul><!--
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          This is a success alert—check it out!
        </div>-->
        <div class="tab-content">
            <div class="tab-pane active" id="tab3">

                
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5>Entrada de Produtos</h5>
                                <input class="span12" class="form-control" id="departamento2Prod"
                                                                type="text" name="departamento2Prod" value="<?php if($dados_departamento[0]->idAlmoEstoqueDep != 1){echo $dados_departamento[0]->descricaoDepartamento;}?>" disabled style="border:0px;width:50%;margin:3px" />
                            </div>
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="span12" id="divCadastrarOs">
                                                <form class="form-inline">
                                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                                        <div class="span2" class="control-group"><!--
                                                            <label for="idEmpresa"
                                                                class="control-label">Departamento:</label>--> 
                                                            <div class="btn-group">
                                                              <a class="btn dropdown-toggle" data-toggle="dropdown" role="button">
                                                                  Departamento
                                                                  <span class="caret"></span>
                                                              </a>
                                                              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="position: relative">
                                                                  <?php foreach($dados_departamento as $r){
                                                                      if($r->idAlmoEstoqueDep == 1){
                                                                      ?>
                                                                      <li><a tabindex="-1" 'href="#produtos" role="button"
                                                                          onclick="showDiv<?php echo $r->idAlmoEstoqueDep ?>()"><?php echo $r->descricaoDepartamento ?></a></li>
                                                                          <?php
                                                                      }else{?>
                                                                      <li><a tabindex="-1" 'href="#insumos" role="button"
                                                                          onclick="showDiv<?php echo $r->idAlmoEstoqueDep ?>()"><?php echo $r->descricaoDepartamento ?></a></li>
                                                                          <?php
                                                                      }?>
                                                                  
                                                                  
                                                                  <?php
                                                                  }?><!--
                                                                  <li class="divider"></li>
                                                                  <li><a tabindex="-1" 'href="#usuario" role="button" onclick="showDivUsuario()">USUÁRIO</a></li>-->
                                                              </ul>
                                                            </div>
                                                            <input class="span12" class="form-control" id="departamentoProd"
                                                                type="text" name="departamentoProd" value="<?php echo $dados_departamento[0]->descricaoDepartamento;?>" disabled />
                                                            <input id="idDepartamentoProd" type="hidden" name="idDepartamentoProd"
                                                                value="<?php echo $dados_departamento[0]->idAlmoEstoqueDep;?>" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">PN:</label>
                                                            <input class="span12" class="form-control" id="pnprod"
                                                                type="text" name="pnprod" value="" />
                                                                <input class="span12" type="hidden" class="form-control" id="pnprod2"
                                                                type="text" name="pnprod2" value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">Ref.:</label>
                                                            <input class="span12" class="form-control" id="refprod"
                                                                type="text" name="refprod" value="" />
                                                                <input class="span12" type="hidden" class="form-control" id="refprod2"
                                                                type="text" name="refprod2" value="" />
                                                        </div>
                                                        <div class="span2" class="control-group">
                                                            <label for="cliente"
                                                                class="control-label">Descrição:</label>
                                                            <input class="span12" class="form-control" id="prodprod"
                                                                type="text" name="prodprod" value="" />
                                                                <input class="span12" class="form-control" type="hidden" id="prodprod2"
                                                                type="text" name="prodprod2" value="" />
                                                            <input id="idProdutosProd" type="hidden" name="idProdutosProd"
                                                                value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">Qtd.
                                                                Est.:</label>
                                                            <input class="span12" disabled class="form-control" id="qtdestprod"
                                                                type="text" name="qtdestprod" value="" />
                                                        </div>
                                                   
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">Qtd.
                                                                ent.:</label>
                                                            <input class="span12" class="form-control" id="qtdprod"
                                                                type="text" name="qtdprod" value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">N.
                                                                Fiscal:</label>
                                                            <input class="span12" class="form-control" id="nfprod"
                                                                type="text" name="nfprod" value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">Valor U.:</label>
                                                            <input class="span12" class="form-control" id="valorUnitprod"
                                                                type="text" name="valorUnitprod" value=""
                                                                onKeyPress="FormataValor2(this,event,10,2);" />
                                                        </div>
                                                        <div class="span2" class="control-group">
                                                            <label for="idEmpresa"
                                                                class="control-label">Status:</label>
                                                            <select class="span12 form-control" name="idStatusProd"
                                                                id="idStatusProd" >
                                                                <?php foreach($dados_statusProduto as $r){
                                                                ?>
                                                                <option value="<?php echo $r->idStatusProduto ?>">
                                                                    <?php echo $r->descricaoStatusProduto?> </option>
                                                                <?php
                                                                }?>

                                                            </select>
                                                        </div>
                                                        
                                                        
                                                    </div>

                                                    <div class="span12" style="padding: 1%; margin-left: 0"><!--
                                                        <div class="span1" class="control-group">
                                                          <label for="idEmpresa" class="control-label"></label>                                                          
                                                        </div>-->
                                                        <div class="span2" class="control-group">
                                                            <label for="idEmpresa"
                                                                class="control-label">Empresa:</label>
                                                            <select class="span12 form-control" name="idEmpresaProd"
                                                                id="idEmpresaProd" onchange="alterarLocal2(this.value)">
                                                                <?php foreach($dados_emitente as $r){
                                                                ?>
                                                                <option value="<?php echo $r->id ?>">
                                                                    <?php echo $r->nome ?> </option>
                                                                <?php
                                                                }?>

                                                            </select>
                                                        </div>
                                                        
                                                        <div class="span2" class="control-group">
                                                            <label for="localp" class="control-label">Local:</label>
                                                            <input class="span12" class="form-control" id="localpProd"
                                                                type="text" name="localpProd" value="" />
                                                            <input id="idLocalpProd" type="hidden" name="idLocalpProd"
                                                                value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="idOs" class="control-label">Cod. OS:</label>
                                                            <input class="span12" class="form-control" id="idOsProd"
                                                                type="text" name="idOsProd" value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){ ?>
                                                            <label for="cliente" class="control-label"></label>
                                                            <a class="btn"
                                                                onclick="verificarCadastroLocalProduto()" name="aEntradaP" id="aEntradaP"
                                                                style="justify-content: flex-end; display: table;">Adicionar</a>

                                                            <?php } ?>
                                                        </div>
                                                        <div class="span1" class="control-group"
                                                            style="margin-left:10px">
                                                            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){ ?>
                                                            <label for="cliente" class="control-label"></label>
                                                            <a class="btn btn-success"
                                                              onclick="cadastrarEntradaEstoqueProduto()" name="fEntradaP" id="fEntradaP"
                                                              style="justify-content: flex-end; display: table;">Finalizar</a>

                                                            <?php } ?>
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
                </div>
                                                                   
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-user"></i>
                        </span>
                        <h5>Produtos Adicionados</h5>
                    </div>

                    <div class="widget-content nopadding">
                        <form action="<?php echo base_url() ?>index.php/almoxarifado/cadastrarEntradas"
                            id="formEntradas" enctype="multipart/form-data" method="post">
                            <table class="table table-bordered " id="tableInsertProd">
                                <thead>
                                    <tr>

                                        <th>PN.</th>
                                        <th>Descrição</th>                                        
                                        <th>Quantidade</th>
                                        <th>Status</th>
                                        <th>Empresa</th>
                                        <th>Departamento</th>
                                        <th>Local</th>
                                        <th>Nota Fiscal</th>
                                        <th>Valor Unit.</th>
                                        <th>Valor Total</th>
                                        <th>OS</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $tabelaEntradaProduto = [];
                            if(isset($_COOKIE['tabelaEntradaProduto']))
                            $tabelaEntradaProduto = json_decode($_COOKIE['tabelaEntradaProduto']);
                                if(isset($tabelaEntradaProduto))
                                foreach($tabelaEntradaProduto as $r){?>
                                    <tr>
                                        <td><?php echo $r->pn?><input value='<?php echo $r->idProd?>' name='idProdutoTDProd_'
                                                id='idProdutoTDProd_' type='hidden' /></td>
                                        <td><?php echo $r->prod?></td>                                        
                                        <td><?php echo $r->qtd?><input value='<?php echo $r->qtd?>' name='qtdTDProd_'
                                                id='qtdTDProd_' type='hidden' /></td>
                                        <td><?php echo $r->nomeStatusProduto?><input
                                                value='<?php echo $r->idStatusProduto?>' name='idStatusProdutoTDProd_'
                                                id='idStatusProdutoTDProd_' type='hidden' /></td>
                                        <td><?php echo $r->nomeEmpresa?><input
                                                value='<?php echo $r->idEmpresa?>' name='idEmpresaTDProd_'
                                                id='idEmpresaTDProd_' type='hidden' /></td>
                                        <td><?php echo $r->nomeDep?><input
                                                value='<?php echo $r->idDepartamento?>' name='idDepartamentoProd_'
                                                id='idDepartamentoProd_' type='hidden' /></td>
                                        <td><?php echo $r->localp?><input
                                                value='<?php echo $r->idLocalp?>' name='idLocalpTDProd_' id='idLocalpTDProd_'
                                                type='hidden' /></td>
                                        <td><?php echo $r->nf?><input value='<?php echo $r->nf?>' name='nFTDProd_'
                                                id='nFTDProd_' type='hidden' /></td>
                                        <td>R$ <?php echo $r->valorUnit?><input value='<?php echo $r->valorUnit?>'
                                                name='valorUnitProd_' id='valorUnitProd_' type='hidden' /></td>
                                        <td>R$ <?php echo $r->valorUnit*$r->qtd?></td>
                                        <td><?php echo $r->idOs?><input value='<?php echo $r->idOs?>' name='idOsTDProd_'
                                                id='idOsTDProd_' type='hidden' /></td>
                                        <td> <button style="margin-right: 1%" data-toggle="modal"
                                                class="btn btn-danger tip-top " class="excluir"
                                                onclick="deleteRow3(this.parentNode.parentNode.rowIndex)">
                                                <font size=1>Excluir</font>
                                            </button></td>
                                    </tr><?php
                                }?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>


            </div>
            <div class="tab-pane" id="tab4">                
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5>Saída de Produtos</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="span12" id="divCadastrarOs">
                                                <form class="form-inline">
                                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                                        <div class="span2" class="control-group"><!--
                                                            <label for="idEmpresa"
                                                                class="control-label">Departamento:</label>-->
                                                            <div class="btn-group">
                                                              <a class="btn dropdown-toggle" data-toggle="dropdown" role="button">
                                                                  Departamento
                                                                  <span class="caret"></span>
                                                              </a>
                                                              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="position: relative">
                                                                  <?php foreach($dados_departamento as $r){
                                                                      if($r->idAlmoEstoqueDep == 1){
                                                                      ?>
                                                                      <li><a tabindex="-1" 'href="#produtos" role="button"
                                                                          onclick="showDiv<?php echo $r->idAlmoEstoqueDep ?>()"><?php echo $r->descricaoDepartamento ?></a></li>
                                                                          <?php
                                                                      }else{?>
                                                                      <li><a tabindex="-1" 'href="#insumos" role="button"
                                                                          onclick="showDiv<?php echo $r->idAlmoEstoqueDep ?>()"><?php echo $r->descricaoDepartamento ?></a></li>
                                                                          <?php
                                                                      }?>
                                                                  
                                                                  
                                                                  <?php
                                                                  }?><!--
                                                                  <li class="divider"></li>
                                                                  <li><a tabindex="-1" 'href="#usuario" role="button" onclick="showDivUsuario()">USUÁRIO</a></li>-->
                                                              </ul>
                                                            </div>
                                                            <input class="span12" class="form-control" id="departamentoSProd"
                                                                type="text" name="departamentoSProd" value="<?php echo $dados_departamento[0]->descricaoDepartamento;?>" disabled />
                                                            <input id="idDepartamentoSProd" type="hidden" name="idDepartamentoSProd"
                                                                value="<?php echo $dados_departamento[0]->idAlmoEstoqueDep;?>" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente"
                                                                class="control-label">PN:</label>
                                                            <input class="span12" class="form-control" id="pnSProd"
                                                                type="text" name="pnSProd" value="" />
                                                            <input class="span12" type="hidden" id="pnSProd2"
                                                                type="text" name="pnSProd2" value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente"
                                                                class="control-label">Ref.:</label>
                                                            <input class="span12" class="form-control" id="refSProd"
                                                                type="text" name="refSProd" value="" />
                                                            <input class="span12" type="hidden" id="refSProd2"
                                                                type="text" name="refSProd2" value="" />
                                                        </div>
                                                        <div class="span2" class="control-group">
                                                            <label for="cliente"
                                                                class="control-label">Descrição:</label>
                                                            <input class="span12" class="form-control" id="prodSProd"
                                                                type="text" name="prodSProd" value="" />
                                                            <input id="idAlmoEstoqueSProd" type="hidden"
                                                                name="idAlmoEstoqueSProd" value="" />
                                                            <input id="prodSProd2" type="hidden"
                                                                name="prodSProd2" value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">Estoque:</label>
                                                            <input class="span12" class="form-control" id="qtdestSProd"
                                                                type="text" name="qtdestSProd" value="" disabled />
                                                            <input id="qtdestS" type="hidden" name="qtdestS" value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label">Qtd.
                                                                Saída:</label>
                                                            <input class="span12" class="form-control" id="qtdSProd"
                                                                type="text" name="qtdSProd" value="" />
                                                            <input id="qtdS" type="hidden" name="qtdS" value="" />
                                                        </div>
                                                        <div class="span2" class="control-group">
                                                            <label for="localp" class="control-label">Local:</label>
                                                            <input class="span12" class="form-control" id="localSProd"
                                                                type="text" name="localSProd" value="" disabled />
                                                            <input id="idLocalSProd" type="hidden" name="idLocalSProd"
                                                                value="" />
                                                        </div>
                                                        <div class="span2" class="control-group">
                                                            <label for="idEmpresa"
                                                                class="control-label">Empresa:</label>
                                                            <select class="span12 form-control" name="idEmpresaSProd"
                                                                id="idEmpresaSProd" onchange="alterarEstoque3(this.value)">
                                                                <?php foreach($dados_emitente as $r){
                                                                ?>
                                                                <option value="<?php echo $r->id ?>">
                                                                    <?php echo $r->nome ?> </option>
                                                                <?php
                                                                }?>

                                                            </select>
                                                        </div><!--
                                                        <div class="span1" class="control-group">
                                                          <label for="idEmpresa"
                                                                class="control-label"></label>
                                                          
                                                        </div>-->
                                                        
                                                        
                                                        
                                                        
                                                    </div>

                                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                                       
                                                        <div class="span3" class="control-group">
                                                            <label for="idEmpresa" class="control-label">Empresa
                                                                Destino:</label>
                                                            <select class="span12 form-control" name="idEmpresaDestSProd"
                                                                id="idEmpresaDestSProd">
                                                                <?php foreach($dados_emitente as $r){
                                                                ?>
                                                                <option value="<?php echo $r->id ?>">
                                                                    <?php echo $r->nome ?> </option>
                                                                <?php
                                                                }?>

                                                            </select>
                                                        </div><!--
                                                        <div class="span2" class="control-group">
                                                            <label for="idEmpresa" class="control-label">Setor:</label>
                                                            <select class="span12 form-control" name="idSetorProd"
                                                                id="idSetorProd" onchange="alterarSetor4(this.value)">
                                                                <?php foreach($dados_setor as $r){
                                                                ?>
                                                                <option value="<?php echo $r->id_setor ?>">
                                                                    <?php echo $r->nomesetor ?> </option>
                                                                <?php
                                                                }?>

                                                            </select>
                                                        </div>-->
                                                        <div class="span2" class="control-group">
                                                            <label for="cliente" class="control-label">Usuário:</label>
                                                            <input class="span12" class="form-control" id="userSProd"
                                                                type="text" name="userSProd" value="" />
                                                                <input class="span12" class="form-control" id="userSProd2"
                                                                type="hidden" name="userSProd2" value="" />
                                                            <input id="idUserSProd" type="hidden" name="idUserSProd" value="" />
                                                        </div>
                                                        <div class="span2" class="control-group">
                                                            <label for="cliente" class="control-label">Setor:</label>
                                                            <input class="span12" class="form-control" id="nomeSetorProd"
                                                                type="text" name="nomeSetorProd" value="" disabled/>
                                                            <input id="idSetorProd" type="hidden" name="idSetorProd" value="" />
                                                        </div>
                                                        <div class="span1" class="control-group">
                                                            <label for="idOs" class="control-label">Cod. OS:</label>
                                                            <input class="span12" class="form-control" id="idOsSProd"
                                                                type="text" name="idOsSProd" value="" />
                                                        </div>
                                                        <div class="span2" class="control-group">
                                                            <label for="localp" class="control-label">OBS.:</label>
                                                            <input class="span12" class="form-control" id="obsSProd"
                                                                type="text" name="obsSProd" value="" />
                                                        </div>
                                                        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){ ?>
                                                        <div class="span1" class="control-group">
                                                            <label for="cliente" class="control-label"></label>
                                                            <a class="btn" class="form-control"
                                                                onclick="inserirLinhaTabelaSaidaProduto()" name="aSaidaP" id="aSaidaP"
                                                                style="justify-content: flex-end; display: table;">Adicionar</a>
                                                        </div>
                                                        <div class="span1" class="control-group"
                                                            style="margin-left:10px">
                                                            <label for="cliente" class="control-label"></label>
                                                            <a class="btn btn-success" class="form-control"
                                                                onclick="cadastrarSaidaEstoqueProduto()" name="fSaidaP" id="fSaidaP"
                                                                style="justify-content: flex-end; display: table;">Finalizar</a>
                                                        </div> <?php
                                                                }?>
                                                    </div>
                                              
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-user"></i>
                        </span>
                        <h5>Produtos</h5>
                    </div>

                    <div class="widget-content nopadding">
                        <form action="<?php echo base_url() ?>index.php/almoxarifado/cadastrarSaidas" id="formSaidas"
                            enctype="multipart/form-data" method="post">
                            <table class="table table-bordered " id="tableSaidaProd">
                                <thead>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Descrição</th>
                                        <th>Status</th>
                                        <th>Quantidade</th>
                                        <th>Local Estoque</th>
                                        <th>Empresa Destino</th>
                                        <th>Setor</th>
                                        <th>Usuário</th>
                                        <th>OS</th>
                                        <th>OBS</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                      if(isset($_COOKIE['tabelaSaidaProduto'])){
                                      $tabelaSaidaProduto = json_decode($_COOKIE['tabelaSaidaProduto']);
                                      }              
                                      if(isset($tabelaSaidaProduto)){
                                      foreach($tabelaSaidaProduto as $r){
                                          ?>
                                      <tr>
                                        <td><?php echo $r->idEstoque ?><input value='<?php echo $r->idEstoque ?>'
                                                name='idEstoqueTDSProd_' id='idEstoqueTDSProd_' type='hidden' /></td>
                                        <td><?php echo $r->prod ?><input value='<?php echo $r->qtd ?>' name='qtdTDSProd_'
                                                id='qtdTDSProd_' type='hidden' /></td>
                                        <td></td>
                                        <td><?php echo $r->qtd ?></td>
                                        <td><?php echo $r->localp ?></td>
                                        <td><?php echo $r->nomeEmpresaDest ?><input value='<?php echo $r->idEmpresaDest ?>'
                                                name='idEmpresaTDSProd_' id='idEmpresaTDSProd_' type='hidden' /></td>
                                        <td><?php echo $r->nomeSetor ?><input value='<?php echo $r->idSetor ?>'
                                                name='idSetorProd_' id='idSetorProd_' type='hidden' /></td>
                                        <td><?php echo $r->nomeUser ?><input value='<?php echo $r->idUser ?>' name='idUserProd_'
                                                id='idUserProd_' type='hidden' /></td>
                                        <td><?php echo $r->idOs ?><input value='<?php echo $r->idOs ?>' name='idOsTDSProd_'
                                                id='idOsTDSProd_' type='hidden' />
                                        <td><?php echo $r->obs ?><input value='<?php echo $r->obs ?>' name='obsTDSProd_'
                                                id='obsTDSProd_' type='hidden' />
                                        <td><button style="margin-right: 1%" data-toggle="modal"
                                                class="btn btn-danger tip-top " class="excluir"
                                                onclick="deleteRow4(this.parentNode.parentNode.rowIndex)">
                                                <font size=1>Excluir</font>
                                            </button></td>
                                      </tr>
                                        <?php
                                        }
                                        }
                                        
                                        ?>
                                    
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

<div id="usuario" style="display:none;">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Cadastro Usuário</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            
            <div class="span12" id="divCadastrarOs">
              <form class="form-inline" >
                <div class="span12" style="padding: 1%; margin-left: 0">
                  <div class="span3" class="control-group">
                    <label for="cliente" class="control-label">Nome: </label>
                    <input class="span12" class="form-control" id="nomeUser"  type="text" name="nomeUser" value=""  />
                  </div>                       
                  <div class="span3" class="control-group">
                    <label for="cliente" class="control-label">CPF:</label>
                    <input class="span12" class="form-control" id="cpfUser"  type="text" name="cpfUser" value=""  />
                  </div>
                  <div class="span3" class="control-group">
                    <label for="idEmpresa" class="control-label">Empresa</label>
                    <select class="span12 form-control" name="idEmpresaUser" id="idEmpresaUser">
                      <?php foreach($dados_emitente as $r){
                        ?>
                        <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                        <?php
                      }?>                            
                    </select>
                  </div>
                  <div class="span3" class="control-group">
                    <label for="idEmpresa" class="control-label">Setor:</label>
                    <select class="span12 form-control" name="idSetorUser" id="idSetorUser">
                      <option value="0"></option>
                      <?php foreach($dados_setor as $r){
                      ?>
                        <option value="<?php echo $r->id_setor ?>"><?php echo $r->nomesetor ?> </option>
                      <?php
                      }?>
                      
                    </select>
                  </div>                   
                </div>
                <div class="span12" style="padding: 1%; margin-left: 0">
                  <div class="span12" class="control-group">
                    <a class="btn btn-success" id="cadastrouser" name="cadastrouser" value="Cadastrar">Cadastrar</a>
                    <!-- <input class="btn btn-default"  id="cadastrolocal" name="cadastrolocal" value="Cadastrar" >-->
                  </div>
                </div>
              </form>    
            </div>             
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="widget-box">
    <div class="widget-title">
      <span class="icon">
          <i class="icon-user"></i>
        </span>
      <h5>Usuário Cadastrados</h5>
    </div>
    <div class="widget-title" style="height:73px">
      <div class="span2" class="control-group" style="padding:12px">
        <label for="Filtro" class="control-label" >Filtro:</label>
        <input class="span12" class="form-control" id="filtroUser"  type="text" name="filtroUser" value=""  />
      </div>
    </div>
    <div class="widget-content nopadding">
      <table class="table table-bordered " id="tableUser">
        <thead>
          <tr>          
            <th>Cód.</th>
            <th>Nome</th>
            <th>CPF</th>                  
            <th>Empresa</th>
            <th>Setor</th>
          </tr>
        </thead>
        <tbody id="tbUser">
            
        <?php
            if(!empty($dados_usuario)){
              foreach($dados_usuario as $r){
                ?>
                <tr>
                  <td><?php 
                    echo $r->idAlmoEstoqueUsuario;?>
                    <input type='hidden' value='<?php echo $r->idAlmoEstoqueUsuario;?>' name='idAlmoEstoqueUsuario_[]'>
                  </td>
                  <td><?php 
                    echo $r->nome ;?>
                  </td>
                  <td><?php 
                    echo $r->cpf ;?>
                  </td>
                  <td><?php 
                    echo $r->nomeempresa ;?>
                  </td>
                  <td><?php 
                    echo $r->nomesetor ;?>
                  </td>
                </tr>
              
                <?php
              }
            }?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div id="modal-editarprodutoestoque" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterar item: <input disabled type="text"  name="itemModal" id="itemModal"
          value="" style="border: 0px; background-color: #efefef; width: 60%;"/></h5>
    </div>
    <div class="modal-body">
    <input type="hidden" name="idLocalModal" id="idLocalModal" value="" />
      Alterar Local:<input type="text"  name="localModal" id="localModal"
          value="" />
    <input type="hidden" name="idAlmoEstoqueModal" id="idAlmoEstoqueModal" value="" />
      Alterar Quantidade:<input type="text" name="quantidadeModal" id="quantidadeModal"
          value="" />

    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
      <button class="btn btn-danger" data-dismiss="modal"  name="alterarLocalQtd" id="alterarLocalQtd">Salvar</button>
    </div>
</div>

<div id="modal-excluiritempedido" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/almoxarifado/excluir_Local" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Local</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idAlmoEstoqueLocais" name="idAlmoEstoqueLocais" value="" />
            <!-- idCotacaoItens<input type="text" id="idCotacaoItens" name="idCotacaoItens" value="<?php echo $r->idAlmoEstoqueLocais; ?>" />
    idDistribuir<input type="text" id="idDistribuir" name="idDistribuir" value=" />
  -->
            <h5 style="text-align: center">Deseja realmente excluir este Local?</h5>    
            Para excluir o local, é necessário que não possua produtos em estoque vinculados à ele.       
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Excluir</button>
        </div>
    </form>
</div>

<div id="modal-cadastrarCategoria" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Cadastrar Categoria</h5>
        </div>
        <div class="modal-body">
          <label for="Filtro" class="control-label" >Categoria:</label>
          <input type="text" id="nomeCategoria" name="nomeCategoria" value="" />
  
            
        </div>
        <div class="modal-body">
          <label for="Filtro" class="control-label" >Subcategoria:</label>
          <input type="text" id="subCategoria" name="subCategoria" value="" />
  
            
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" data-dismiss="modal" aria-hidden="true" id="cadastrarSubcatECat" name="cadastrarSubcatECat">Cadastrar</a>
        </div>
</div>

<div id="modal-cadastrarSubcategoria" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Cadastrar Subcategoria</h5>
    </div>
    <div class="modal-body">
      <label for="idEmpresa" class="control-label">Categoria</label>
      <select class="span3 form-control" name="idCategoriaSelect" id="idCategoriaSelect">
        <?php foreach($dados_categoria as $r){
          ?>
          <option value="<?php echo $r->idCategoria ?>"><?php echo $r->descricaoCategoria ?> </option>
          <?php
        }?>                            
      </select>

        
    </div>
    <div class="modal-body">
      <label for="Filtro" class="control-label" >Subcategoria:</label>
      <input type="text" id="subCategoriaa" name="subCategoriaa" value="" />

        
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <a class="btn btn-success" data-dismiss="modal" aria-hidden="true" id="cadastrarSubcatt" name="cadastrarSubcatt">Cadastrar</a>
    </div>
</div>

<div id="modal-itensOs" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Itens da O.S.: <input disabled type="text"  name="itemOs" id="itemOs"
          value="" style="border: 0px; background-color: #efefef; width: 60%;"/></h5>
    </div>
    <div class="modal-body">
      <div class="span4" class="control-group">
          <label for="idEmpresa" class="control-label">Empresa
              Destino:</label>
          <select class="span12 form-control" name="idEmpresaDestSp"
              id="idEmpresaDestSp">
              <?php foreach($dados_emitente as $r){
              ?>
              <option value="<?php echo $r->id ?>">
                  <?php echo $r->nome ?> </option>
              <?php
              }?>
          </select>
      </div>
      <div class="span3" class="control-group">
          <label for="cliente" class="control-label">Usuário:</label>
          <input class="span12" class="form-control" id="userpS"
              type="text" name="userpS" value="" />
              <input class="span12" class="form-control" id="userpS2"
              type="hidden" name="userpS2" value="" />
          <input id="idUserpS" type="hidden" name="idUserpS" value="" />
      </div> 
      <div class="span2" class="control-group">
          <label for="cliente" class="control-label">Setor:</label>
          <input class="span12" class="form-control" id="nomeSetorp"
              type="text" name="nomeSetorp" value="" disabled/>
          <input id="idSetorp" type="hidden" name="idSetorp" value="" />
      </div>
      <div class="span3" class="control-group">
          <label for="localp" class="control-label">OBS.:</label>
          <input class="span12" class="form-control" id="obspS"
              type="text" name="obspS" value="" />
      </div>
      <div></div>
      <div class="span12" class="widget-box" style="margin-top:15px;margin-left: 0px;">
          <div class="widget-title">
              <span class="icon">
                  <i class="icon-user"></i>
              </span>
              <h5>Itens</h5>
          </div>

          <div class="widget-content nopadding" id="divTableOs">
            <table class="table table-bordered " id="tableOs" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
              font-size:10px;" border="1">
                <thead>
                    <tr>
                        <th></th>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>Local Estoque</th>
                        <th>Empresa</th>
                    </tr>
                </thead>
                <tbody>
                    
                    
                </tbody>
            </table>
          </div>
      </div>
      

    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
      <button class="btn btn-danger" onclick="adicionarItensTabelaSaida()">Salvar</button>
    </div>



</div>

<script type="text/javascript">
  /*
    $('.btn-add-saida').click(function () {

      var btn = $(this);
      $(btn).buttonLoader('start');
      setTimeout(function () {
        $(btn).buttonLoader('stop');
      }, 5000);

    });*/
    //function showDiv - produto e insumo
    <?php foreach($dados_departamento as $r) {
            ?>
        function showDiv<?php echo $r->idAlmoEstoqueDep ?> () {
            <?php if($r->idAlmoEstoqueDep == 1){?>
                document.getElementById('produtos').style.display = "block";       
                document.getElementById('insumos').style.display = "none";
                document.getElementById('usuario').style.display = "none";
                document.querySelector("#departamentoProd").value = "<?php echo $r->descricaoDepartamento ?>";
                document.querySelector("#idDepartamentoProd").value = "<?php echo $r->idAlmoEstoqueDep ?>";
                document.querySelector("#departamento2Prod").value = "<?php echo $r->descricaoDepartamento ?>";
                document.querySelector("#departamentoSProd").value = "<?php echo $r->descricaoDepartamento ?>";
                document.querySelector("#idDepartamentoSProd").value = "<?php echo $r->idAlmoEstoqueDep ?>";
            <?php
            }else{?>
                document.getElementById('produtos').style.display = "none";       
                document.getElementById('insumos').style.display = "block";
                document.getElementById('usuario').style.display = "none";
                document.querySelector("#departamento").value = "<?php echo $r->descricaoDepartamento ?>";
                document.querySelector("#departamento2").value = "<?php echo $r->descricaoDepartamento ?>";
                document.querySelector("#idDepartamento").value = "<?php echo $r->idAlmoEstoqueDep ?>";
                document.querySelector("#departamentoS").value = "<?php echo $r->descricaoDepartamento ?>";
                document.querySelector("#departamentoS2").value = "<?php echo $r->descricaoDepartamento ?>";
                document.querySelector("#idDepartamentoS").value = "<?php echo $r->idAlmoEstoqueDep ?>";
                
            <?php
            }?>
            alterarEstoque2('<?php echo $r->idAlmoEstoqueDep ?>');
            alterarEstoque1('<?php echo $r->idAlmoEstoqueDep ?>');
            alterarLocal22('<?php echo $r->idAlmoEstoqueDep ?>'); 
        
        }
    <?php
    }?>
    
    function showDivUsuario(){
        document.getElementById('produtos').style.display = "none";       
        document.getElementById('insumos').style.display = "none";
        document.getElementById('usuario').style.display = "block";
    }

    var descricao = document.getElementById('prod');

    descricao.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#idProdutos").value = "";
          document.querySelector("#pn4").value = "";
          //document.querySelector("#idCategoriaEntrada").value = "";
          //document.querySelector("#categoriaEntrada").value = "";
          //document.querySelector("#idSubcategoriaEntrada").value = "";
          //document.querySelector("#subcategoriaEntrada").value = "";
        }
    };

    descricao.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#idProdutos").value = "";  
        document.querySelector("#pn4").value = "";
        //document.querySelector("#idCategoriaEntrada").value = "";
        //document.querySelector("#categoriaEntrada").value = "";
        //document.querySelector("#idSubcategoriaEntrada").value = "";
        //document.querySelector("#subcategoriaEntrada").value = "";  
      }
    };

    var categoriaEntrada = document.getElementById('categoriaEntrada');

    categoriaEntrada.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#idCategoriaEntrada").value = "";
          document.querySelector("#idSubcategoriaEntrada").value = "";
          document.querySelector("#subcategoriaEntrada").value = "";
          document.querySelector("#idProdutos").value = "";
          document.querySelector("#prod").value = "";
        }
    };
    
    categoriaEntrada.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#idCategoriaEntrada").value = "";
        document.querySelector("#idSubcategoriaEntrada").value = "";
        document.querySelector("#subcategoriaEntrada").value = "";
        document.querySelector("#idProdutos").value = "";
        document.querySelector("#prod").value = "";
      }
    };

    var subcategoriaEntrada = document.getElementById('subcategoriaEntrada');

    subcategoriaEntrada.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#idSubcategoriaEntrada").value = "";
          document.querySelector("#idProdutos").value = "";
          document.querySelector("#prod").value = "";
        }
    };

    subcategoriaEntrada.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#idSubcategoriaEntrada").value = "";
        document.querySelector("#idProdutos").value = "";
        document.querySelector("#prod").value = "";
      }
    };




    var locaisp = document.getElementById('localp');

    locaisp.onkeydown = function() {
      var key = event.keyCode || event.charCode;
      if( key == 8 || key == 46 ){      
        document.querySelector("#idLocalp").value = "";
      }
    };

    locaisp.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#idLocalp").value = "";
      }
    };


    var prodS = document.getElementById('prodS');

    prodS.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#localS").value = "";
          document.querySelector("#qtdestS").value = "";
          document.querySelector("#idAlmoEstoqueS").value = "";
        }
    };

    prodS.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){ 
        document.querySelector("#localS").value = "";
        document.querySelector("#qtdestS").value = "";
        document.querySelector("#idAlmoEstoqueS").value = "";
      }
        
    };

    var userSS = document.getElementById('userS');

    userSS.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#idUserS").value = "";
          document.querySelector("#idSetor").value = "";
          document.querySelector("#nomeSetor").value = "";
        }
    };

    userSS.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#idUserS").value = "";
        document.querySelector("#nomeSetor").value = "";
        document.querySelector("#idSetor").value = "";
      }
        
    };

    var userSProd = document.getElementById('userSProd');

    userSProd.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#idUserSProd").value = "";
          document.querySelector("#idSetorProd").value = "";
          document.querySelector("#nomeSetorProd").value = "";
        }
    };

    userSProd.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#idUserSProd").value = "";
        document.querySelector("#nomeSetorProd").value = "";
        document.querySelector("#idSetorProd").value = "";
      }
        
    };



    var pnprod = document.getElementById('pnprod');
    pnprod.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#pnprod2").value = "";
          document.querySelector("#prodprod2").value = "";
          document.querySelector("#prodprod").value = "";
          document.querySelector("#idProdutosProd").value = "";
          document.querySelector("#refprod2").value = "";
          document.querySelector("#refprod").value = "";
        }
    };

    pnprod.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#pnprod2").value = "";
        document.querySelector("#prodprod2").value = "";
        document.querySelector("#prodprod").value = "";
        document.querySelector("#idProdutosProd").value = "";
        document.querySelector("#refprod2").value = "";
        document.querySelector("#refprod").value = "";
      }
    
    };

    var refprod = document.getElementById('refprod');
    refprod.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#pnprod2").value = "";
          document.querySelector("#prodprod2").value = "";
          document.querySelector("#prodprod").value = "";
          document.querySelector("#idProdutosProd").value = "";
          document.querySelector("#refprod2").value = "";
          document.querySelector("#pnprod").value = "";
        }
    };

    refprod.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#pnprod2").value = "";
        document.querySelector("#prodprod2").value = "";
        document.querySelector("#prodprod").value = "";
        document.querySelector("#idProdutosProd").value = "";
        document.querySelector("#refprod2").value = "";
        document.querySelector("#pnprod").value = "";
      }
    
    };

    var prodprod = document.getElementById('prodprod');
    prodprod.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#pnprod2").value = "";
          document.querySelector("#prodprod2").value = "";
          document.querySelector("#pnprod").value = "";
          document.querySelector("#idProdutosProd").value = "";
          document.querySelector("#refprod2").value = "";
          document.querySelector("#refprod").value = "";
        }
    };

    prodprod.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#pnprod2").value = "";
        document.querySelector("#prodprod2").value = "";
        document.querySelector("#pnprod").value = "";
        document.querySelector("#idProdutosProd").value = "";
        document.querySelector("#refprod2").value = "";
        document.querySelector("#refprod").value = "";
      }
        
    };

    var pnSProd = document.getElementById('pnSProd');
    pnSProd.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#pnSProd2").value = "";
          document.querySelector("#prodSProd2").value = "";
          document.querySelector("#prodSProd").value = "";
          document.querySelector("#idAlmoEstoqueSProd").value = "";
          document.querySelector("#qtdestSProd").value = "";
          document.querySelector("#refSProd2").value = "";
          document.querySelector("#refSProd").value = "";
        }
    };

    pnSProd.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#pnSProd2").value = "";
        document.querySelector("#prodprod2").value = "";
        document.querySelector("#prodprod").value = "";
        document.querySelector("#idAlmoEstoqueSProd").value = "";
        document.querySelector("#qtdestSProd").value = "";
        document.querySelector("#refSProd2").value = "";
        document.querySelector("#refSProd").value = "";
      }
        
    };

    var prodSProd = document.getElementById('prodSProd');
    prodSProd.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#pnSProd2").value = "";
          document.querySelector("#prodSProd2").value = "";
          document.querySelector("#pnSProd").value = "";
          document.querySelector("#idAlmoEstoqueSProd").value = "";
          document.querySelector("#qtdestSProd").value = "";
          document.querySelector("#refSProd2").value = "";
          document.querySelector("#refSProd").value = "";
        }
    };

    prodSProd.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#pnSProd2").value = "";
        document.querySelector("#prodSProd2").value = "";
        document.querySelector("#pnSProd").value = "";
        document.querySelector("#idAlmoEstoqueSProd").value = "";
        document.querySelector("#qtdestSProd").value = "";
        document.querySelector("#refSProd2").value = "";
        document.querySelector("#refSProd").value = "";
      }
        
    };

    var refSProd = document.getElementById('refSProd');
    refSProd.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#pnSProd2").value = "";
          document.querySelector("#prodSProd2").value = "";
          document.querySelector("#pnSProd").value = "";
          document.querySelector("#idAlmoEstoqueSProd").value = "";
          document.querySelector("#qtdestSProd").value = "";
          document.querySelector("#refSProd2").value = "";
          document.querySelector("#prodSProd").value = "";
        }
    };

    refSProd.onkeyup = function() {
      var key = event.keyCode || event.charCode; 
      if(key != 9){
        document.querySelector("#pnSProd2").value = "";
        document.querySelector("#prodSProd2").value = "";
        document.querySelector("#pnSProd").value = "";
        document.querySelector("#idAlmoEstoqueSProd").value = "";
        document.querySelector("#qtdestSProd").value = "";
        document.querySelector("#refSProd2").value = "";
        document.querySelector("#prodSProd").value = "";
      }
        
    };

    


    function inserirLinhaTabelaSaida(){
      var a = document.querySelector("#aSaidaI");
      if(a.disabled == true){
        return;
      }else{
        a.disabled =true;
      }
      var table = document.getElementById("tableSaida");

      var idAlmoEstoque = document.querySelector("#idAlmoEstoqueS").value;  
      var nomeProduto = document.querySelector("#prodS").value;
      var pnS4 = document.querySelector("#pnS4").value;

      var empresap = document.getElementById('idEmpresaS');
      var idEmpresa = empresap.options[empresap.selectedIndex].value;
      var nomeEmpresa = empresap.options[empresap.selectedIndex].text;
      var empresaS = document.getElementById('idEmpresaDestS');
      var idEmpresaS = empresaS.options[empresaS.selectedIndex].value;
      var nomeEmpresaS = empresaS.options[empresaS.selectedIndex].text;
      var idOs = document.querySelector("#idOsS").value;
      //var setor = document.getElementById('idSetor');
      var idSetor = document.querySelector("#idSetor").value;
      var nomeSetor = document.querySelector("#nomeSetor").value;
      var local =  document.querySelector("#localS").value; 
      var qtd = document.querySelector("#qtdS").value;
      var qtdEst = document.querySelector("#qtdestS").value;
      var user = document.querySelector("#idUserS").value;
      var userNome = document.querySelector("#userS2").value;
      var obs = document.querySelector("#obsS").value;
      
      
      if(table.rows.length == null || typeof table.rows.length == "undefined"){
        var numOfRows = 0;
      } else {
        var numOfRows = table.rows.length;
      }
      if(typeof idAlmoEstoque != "undefined" && idAlmoEstoque != null && idAlmoEstoque != "" && 
      typeof nomeProduto != "undefined" && nomeProduto != null && nomeProduto != "" &&
      typeof idEmpresa != "undefined" && idEmpresa != null && idEmpresa != "" &&
      typeof idEmpresaS != "undefined" && idEmpresaS != null && idEmpresaS != "" &&
      typeof idSetor != "undefined" && idSetor != null && idSetor != "" &&
      typeof qtd != "undefined" && qtd != null && qtd != "" &&
      typeof user != "undefined" && user != null && user != ""){
        if(isNaN(qtd) == true){
          a.disabled = false;
          return alert("A quantidade informada não é um número inteiro.");
        }
        if(!verificarItensSaida(idAlmoEstoque,qtd,qtdEst)){
          a.disabled = false;
          return alert("A quantidade informada é maior que a quantidade em estoque.");
        }
        if(idOs != null){
          if(isNaN(idOs)== true){
            a.disabled = false;
            return alert("O campo OS deve possuir apenas numeros.");
          }
        }
        //console.log(typeof qtd);
        
        arrayTabelaSaida = {
          "idAlmoEstoque":idAlmoEstoque,
          "pnS4":pnS4,
          "nomeProduto":nomeProduto,
          "idEmpresa":idEmpresa,
          "nomeEmpresa":nomeEmpresa,
          "idEmpresaS":idEmpresaS,
          "nomeEmpresaS":nomeEmpresaS,
          "idOs":idOs,
          "idSetor":idSetor,
          "nomeSetor":nomeSetor,
          "local":local,
          "volume":volume,
          "qtd":qtd,
          "qtdEst":qtdEst,
          "user":user,
          "obs":obs,
          "userNome":userNome
        };
        // Captura a quantidade de colunas da última linha da tabela
        var numOfCols = table.rows[numOfRows-1].cells.length;
        // Insere uma linha no fim da tabela.
        var newRow = table.insertRow(numOfRows);
        newCell = newRow.insertCell(0);   
        newCell.innerHTML = pnS4+"<input value='"+idAlmoEstoque+"' name='idAlmoEstoque_[]' id='idAlmoEstoque_[]' type='hidden'/>";
        newCell.value = idAlmoEstoque;
        newCell = newRow.insertCell(1);   
        newCell.innerHTML = nomeProduto;
        newCell = newRow.insertCell(2);   
        newCell.innerHTML = qtd +"<input value='"+qtd+"' name='qtd_[]' id='qtd_[]' type='hidden'/>";
        newCell.value = qtd;
        newCell = newRow.insertCell(3);   
        newCell.innerHTML = local;
        newCell = newRow.insertCell(4);   
        newCell.innerHTML = nomeEmpresaS+"<input value='"+idEmpresaS+"' name='idEmitenteDest_[]' id='idEmitenteDest_[]' type='hidden'/>";
        newCell = newRow.insertCell(5);   
        newCell.innerHTML = nomeSetor+"<input value='"+idSetor+"' name='idSetor_[]' id='idSetor_[]' type='hidden'/>";
        newCell = newRow.insertCell(6);   
        newCell.innerHTML = userNome+"<input value='"+user+"' name='user_[]' id='user_[]' type='hidden'/>";
        newCell = newRow.insertCell(7);   
        newCell.innerHTML = idOs+"<input value='"+idOs+"' name='idOs_[]' id='idOs_[]' type='hidden'/>";
        newCell = newRow.insertCell(8);   
        newCell.innerHTML = obs+"<input value='"+obs+"' name='obs_[]' id='obs_[]' type='hidden'/>";
        newCell = newRow.insertCell(9);
        newCell.innerHTML = '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow2(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button>'
        
        
        document.querySelector("#qtdS").value = "";
        document.querySelector("#qtdestS").value = "";
        document.querySelector("#localS").value = "";
        document.querySelector("#prodS").value = "";
        document.querySelector("#pnS").value = "";
        document.querySelector("#idAlmoEstoqueS").value = "";
        if(getCookie('tabelaSaida') == ""){
          var arrayList = [];
          arrayList.push(arrayTabelaSaida);    
        }else{
          var arrayList = JSON.parse(getCookie('tabelaSaida'));
          arrayList.push(arrayTabelaSaida);
        }
        document.cookie = 'tabelaSaida ='+JSON.stringify(arrayList)+";path=/";;
        a.disabled = false;
      } else {
        a.disabled = false;
        return alert("Os campos descrição, quantidade, empresa, local, empresa destino, setor e usuário são obrigatórios.");
      }
      
    }

    function verificarInsumoCategoriaSubcategoria() {
      var a = document.querySelector("#aEntradaI");
      if(a.disabled==true){
        return;
      }else{
        a.disabled = true;
      }
      var table = document.getElementById("tableInsert");
      // Captura a quantidade de linhas já existentes na tabela
      
      var pn = document.querySelector("#idProdutos").value;
      var pn2 = document.querySelector("#pn").value;
      
      var prod = document.querySelector("#prod").value;
      var catEntrada = document.querySelector("#categoriaEntrada").value;
      var idCatEntrada = document.querySelector("#idCategoriaEntrada").value;
      var subcatEntrada = document.querySelector("#subcategoriaEntrada").value;
      var idSubcatEntrada = document.querySelector("#idSubcategoriaEntrada").value;

      var select = document.getElementById('idMedicao');
      var medicao = select.options[select.selectedIndex].value;
      var nomemedicao = select.options[select.selectedIndex].text;
      
      var empresap = document.getElementById('idEmpresa');
      var idEmpresa = empresap.options[empresap.selectedIndex].value;
      var nomeEmpresa = empresap.options[empresap.selectedIndex].text;
      // var localp = document.querySelector("#localp").value;
      // var idLocalp = document.querySelector("#idLocalp").value;
      var idOs = document.querySelector("#idOs").value;
      var tamanho = document.querySelector("#tamanho").value;
      var volume = document.querySelector("#volume").value;
      var peso = document.querySelector("#peso").value;
      var nf = document.querySelector("#nf").value;
      var qtd = document.querySelector("#qtd").value;
      var valorUnit = document.querySelector("#valorUnit").value;
      var arrayTabelaEntrada= {}
      

      
      if(typeof idDepartamento != "UNDEFINED" && idDepartamento != null && idDepartamento != "" && typeof subcatEntrada != "UNDEFINED" && subcatEntrada != null && subcatEntrada != "" && typeof catEntrada != "UNDEFINED" && catEntrada != null && catEntrada != "" && typeof prod != "UNDEFINED" && prod != null && prod != "" && typeof idMedicao != "UNDEFINED" && idMedicao != null && idMedicao != ""  && typeof qtd != "UNDEFINED" && qtd != null  && typeof valorUnit != "UNDEFINED" && valorUnit != null && valorUnit != "")
      {
        if(medicao == 1 && (tamanho == null || tamanho == "" || typeof tamanho == "undefined")){
          a.disabled = false;
          return alert("Digite o comprimento da unidade em centímetros para poder adicionar.");
        }

        if(medicao == 2 && (volume == null || volume == "" || typeof volume == "undefined")){
          a.disabled = false;
          return alert("Digite o volume da unidade em mililitros para poder adicionar.");
        }
        if(medicao == 3 && (peso == null || peso == "" || typeof peso == "undefined")){
          a.disabled = false;
          return alert("Digite o peso da unidade em gramas para poder adicionar.");
        }
        if(pn == ""){
          if(idCatEntrada == ""){
            $.ajax({
              url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarCatESubcat2",
              type: 'POST',
              dataType: 'json',
              data: {
                nomeCategoria: catEntrada,
                subCategoria: subcatEntrada
              },
              success: function(data) {
                idCatEntrada = data.idCategoria;
                idSubcatEntrada = data.idSubcategoria; 
                console.log("Z");
                $.ajax({
                  url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarInsumos2",
                  type: 'POST',
                  dataType: 'json',
                  data: {
                      descricao: prod,
                      estoquemin: 1,
                      subcat: idSubcatEntrada,
                      pn: pn2
                  },
                  success: function(dataI) {
                    if(dataI.result == true){
                      pn = dataI.idInsumo;
                      verificarCadastroLocal(pn);
                    }else{
                      alert(dataI.msggg);
                      a.disabled = false;
                    }
                  
                    
                  },
                  error: function(xhr, textStatus, error) {
                    console.log("4");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                    a.disabled = false;
                  },
                                
                });   
              },
              error: function(xhr, textStatus, error) {
                console.log("3");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
                a.disabled = false;
              },
            });
          }else if (idSubcatEntrada == ""){
            $.ajax({
              url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarSubcat2",
              type: 'POST',
              dataType: 'json',
              data: {
                nomeCategoria: catEntrada,
                subCategoria: subcatEntrada,
                idCategoria: idCatEntrada
              },
              success: function(dataS) {
                idCatEntrada = dataS.idCategoria;
                idSubcatEntrada = dataS.idSubcategoria;
                console.log("X");   
                $.ajax({
                  url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarInsumos2",
                  type: 'POST',
                  dataType: 'json',
                  data: {
                      descricao: prod,
                      estoquemin: 1,
                      subcat: idSubcatEntrada,
                      pn: pn2
                  },
                  success: function(dataI) {
                    if(dataI.result == true){
                      pn = dataI.idInsumo;
                      verificarCadastroLocal(pn);
                    }else{
                      alert(dataI.msggg);
                      a.disabled = false;
                    }
                  
                    
                  },
                  error: function(xhr, textStatus, error) {
                    console.log("2");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                    a.disabled = false;
                  },
                                
                });
              },
              error: function(xhr, textStatus, error) {
                console.log("1");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
                a.disabled = false;
              },                          
            });
          } else {
            $.ajax({
              url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarInsumos2",
              type: 'POST',
              dataType: 'json',
              data: {
                  descricao: prod,
                  estoquemin: 1,
                  subcat: idSubcatEntrada,
                  pn: pn2
              },
              success: function(data) {
                if(data.result == true){
                  
                  pn = data.idInsumo;
                  verificarCadastroLocal(pn);
                }else{
                  alert(data.msggg);
                  a.disabled = false;
                }
              
                
              },
                            
            });
          }
        }else{
          verificarCadastroLocal(pn);

        }
      } else{
        console.log("B");        
        a.disabled = false;
        alertaAdicionar();
      }
    }

    function verificarCadastroLocal(pn){
      var a = document.querySelector("#aEntradaI")
      var localp = document.querySelector("#localp").value;
      var idLocalp = document.querySelector("#idLocalp").value;
      if(typeof localp != 'undefined' && localp != ''){
        var empresap = document.getElementById('idEmpresa');
        var idEmpresa = empresap.options[empresap.selectedIndex].value;
        var nomeEmpresa = empresap.options[empresap.selectedIndex].text;
        var idDepartamento = document.querySelector("#idDepartamento").value;
        console.log("data")
        $.ajax({
          url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarLocal2",
          type: 'POST',
          dataType: 'json',
          data: {
              local: localp,
              depart: idDepartamento,
              empresa: idEmpresa
          },
          success: function(data) {
            if(data.result == true){
              console.log(data)
              document.querySelector("#idLocalp").value = data.idLocal;
              inserirLinhaTabela(pn);
            }else{
              alert(data.msggg);              
              a.disabled = false;
            }
          
            
          },
                        
        });
      }else{
        inserirLinhaTabela(pn);
      }
    }

    function verificarCadastroLocalProduto(){
      var a = document.querySelector("#aEntradaP");
      if(a.disabled == true){
        return;
      }else{
        a.disabled = true;
      }
      var localp = document.querySelector("#localpProd").value;
      var idLocalp = document.querySelector("#idLocalpProd").value;
      if(typeof localp != 'undefined' && localp != ''){
        
        var empresap = document.getElementById('idEmpresaProd');
        var idEmpresa = empresap.options[empresap.selectedIndex].value;
        var nomeEmpresa = empresap.options[empresap.selectedIndex].text;
        var idDepartamento = document.querySelector("#idDepartamentoProd").value;
        $.ajax({
          url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarLocal2",
          type: 'POST',
          dataType: 'json',
          data: {
              local: localp,
              depart: idDepartamento,
              empresa: idEmpresa
          },
          success: function(data) {
            console.log(data)
            if(data.result == true){
              
              document.querySelector("#idLocalpProd").value = data.idLocal;
              inserirLinhaTabelaEntradaProduto();
            }else{
              alert(data.msggg);
              a.disabled = false;
            }
          
            
          },
          error: function(xhr, textStatus, error) {
            console.log("4");
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
            a.disabled = false;
          },          
        });
      }else{
        inserirLinhaTabelaEntradaProduto();
      }
    }

    function verificarTableEntrada(){
      var a = document.querySelector("#fEntradaI");
      if(a.disabled==true){
        return;
      }else{
        a.disabled = true;
      }
      var table = document.getElementById("tableInsert");
      if(table.rows.length == null || typeof table.rows.length == "undefined" || table.rows.length == 1){
        alert("Não existem dados na tabela para serem cadastrados.");
        a.disabled = false;
      }else{
        document.getElementById('formEntradas').submit();
      }
    }

    function verificarTableSaida(){
      var a = document.querySelector("#fSaidaI");
      if(a.disabled==true){
        return;
      }else{
        a.disabled = true;
      }
      var table = document.getElementById("tableSaida");
      if(table.rows.length == null || typeof table.rows.length == "undefined" || table.rows.length == 1){
        alert("Não existem dados na tabela para serem cadastrados.");
        a.disabled = false;
      }else{
        document.getElementById('formSaidas').submit();
      }
    }    

    function inserirLinhaTabela(pn){
      var a = document.querySelector("#aEntradaI")
      var table = document.getElementById("tableInsert");
      // Captura a quantidade de linhas já existentes na tabela


      //var pn = document.querySelector("#idProdutos").value;
      
      var prod = document.querySelector("#prod").value;
      var pn4 = document.querySelector("#pn4").value;

      var select = document.getElementById('idMedicao');
      var medicao = select.options[select.selectedIndex].value;
      var nomemedicao = select.options[select.selectedIndex].text;

      var empresap = document.getElementById('idEmpresa');
      var idEmpresa = empresap.options[empresap.selectedIndex].value;
      var nomeEmpresa = empresap.options[empresap.selectedIndex].text;
      var localp = document.querySelector("#localp").value;
      var idLocalp = document.querySelector("#idLocalp").value;
      var idOs = document.querySelector("#idOs").value;

      var selectDep = document.getElementById('idDepartamento');
      var idDepartamento = document.querySelector("#idDepartamento").value;
      var nomeDep =  document.querySelector("#departamento").value;

      var tamanho = document.querySelector("#tamanho").value;
      var volume = document.querySelector("#volume").value;
      var peso = document.querySelector("#peso").value;
      var dimensoesL = document.querySelector("#dimensoesL").value;
      var dimensoesC = document.querySelector("#dimensoesC").value;
      var dimensoesA = document.querySelector("#dimensoesA").value;
      var nf = document.querySelector("#nf").value;
      var qtd = document.querySelector("#qtd").value;
      var valorUnit = document.querySelector("#valorUnit").value.replace(".","");
      var arrayTabelaEntrada = {};



      if(typeof idDepartamento != "UNDEFINED" && idDepartamento != null && idDepartamento != "" && typeof pn != "UNDEFINED" && pn != null && pn != "" && typeof prod != "UNDEFINED" && prod != null && prod != "" && typeof idMedicao != "UNDEFINED" && idMedicao != null && idMedicao != ""  && typeof qtd != "UNDEFINED" && qtd != null && qtd != "" && typeof valorUnit != "UNDEFINED" && valorUnit != null && valorUnit != "" && typeof pn != "UNDEFINED" && pn != null && pn != "")
      {
        if(medicao == 1 && (tamanho == null || tamanho == "" || typeof tamanho == "undefined" || isNaN(tamanho.replace(',','.')) == true)){
          a.disabled = false;
          return alert("Digite o comprimento da unidade em centímetros para poder adicionar.");
        }
        //valorUnit = valorUnit.replace(".","");
        console.log(valorUnit);
        if(medicao == 2 && (volume == null || volume == "" || typeof volume == "undefined" || isNaN(volume.replace(',','.')) == true)){
          a.disabled = false;
          return alert("Digite o volume da unidade em mililitros para poder adicionar.");
        }
        if(medicao == 3 && (peso == null || peso == "" || typeof peso == "undefined" || isNaN(peso.replace(',','.')) == true)){
          a.disabled = false;
          return alert("Digite o peso da unidade em gramas para poder adicionar.");
        }
        if(medicao == 4 && (dimensoesL == null || dimensoesL == "" || typeof dimensoesL == "undefined" || isNaN(dimensoesL.replace(',','.')) == true) && (dimensoesC == null || dimensoesC == "" || typeof dimensoesC == "undefined" || isNaN(dimensoesC.replace(',','.')) == true) && (dimensoesA == null || dimensoesA == "" || typeof dimensoesA == "undefined" || isNaN(dimensoesA.replace(',','.')) == true)){
          a.disabled = false;
          return alert("Digite as dimensões da unidade em milimetros para poder adicionar.");
        }
        if(isNaN(qtd)== true){
          a.disabled = false;
          return alert("O campo quantidade deve possuir apenas numeros.");
        }
        if(isNaN(valorUnit.replace(',','.'))== true){
          a.disabled = false;
          return alert("O campo valor unitário deve possuir apenas numeros.");
        }
        if(idOs != null){
          if(isNaN(idOs)== true){
            a.disabled = false;
            return alert("O campo OS deve possuir apenas numeros.");
          }
        }
        if(nf != null){
          if(isNaN(nf)== true){
            a.disabled = false;
            return alert("O campo NF deve possuir apenas numeros.");
          }
        }

        arrayTabelaEntrada = {
          "pn":pn,
          "pn4":pn4,
          "prod":prod,
          "medicao":medicao,
          "nomemedicao":nomemedicao,
          "idEmpresa":idEmpresa,
          "nomeEmpresa":nomeEmpresa,
          "localp":localp,
          "idLocalp":idLocalp,
          "idOs":idOs,
          "tamanho":tamanho,
          "volume":volume,
          "peso":peso,          
          "dimensoes":dimensoesL+' X '+dimensoesC+' X '+dimensoesA,
          "nf":nf,
          "qtd":qtd,
          "valorUnit":valorUnit.replace(',','.'),
          "idDepartamento": idDepartamento,
          "nomeDep":nomeDep

        };
        
        if(table.rows.length == null || typeof table.rows.length == "undefined"){
          var numOfRows = 0;
        } else {
          var numOfRows = table.rows.length;
        }
        
        // Captura a quantidade de colunas da última linha da tabela
        var numOfCols = table.rows[numOfRows-1].cells.length;
        // Insere uma linha no fim da tabela.
        var newRow = table.insertRow(numOfRows);
        newCell = newRow.insertCell(0);   
        newCell.innerHTML = pn4+"<input value='"+pn+"' name='idProdutoTD_[]' id='idProdutoTD_[]' type='hidden'/><input value='"+medicao+"' name='idMedicaoTD_[]' id='idMedicaoTD_[]' type='hidden'/>";
        
        newCell = newRow.insertCell(1);     
        newCell.innerHTML = prod;
        newCell.value = prod 


        newCell = newRow.insertCell(2);     
        newCell.innerHTML = tamanho+"<input value='"+tamanho+"' name='tamanhoTD_[]' id='tamanhoTD_[]' type='hidden'/>";
        

        newCell = newRow.insertCell(3);     
        newCell.innerHTML = volume+"<input value='"+volume+"' name='volumeTD_[]' id='volumeTD_[]' type='hidden'/>";
        

        newCell = newRow.insertCell(4);     
        newCell.innerHTML = peso+"<input value='"+peso+"' name='pesoTD_[]' id='pesoTD_[]' type='hidden'/>";

         newCell = newRow.insertCell(5);     
        newCell.innerHTML = dimensoesL+'mm X '+dimensoesC+'mm X '+dimensoesA+'mm'+"<input value='"+dimensoesL+'x'+dimensoesC+'x'+dimensoesA+"' name='dimensoesTD_[]' id='dimensoesTD_[]' type='hidden'/>";

        newCell = newRow.insertCell(6);     
        newCell.innerHTML = qtd+"<input value='"+qtd+"' name='qtdTD_[]' id='qtdTD_[]' type='hidden'/>";
      
        newCell = newRow.insertCell(7);     
        newCell.innerHTML = nomeEmpresa+"<input value='"+idEmpresa+"' name='idEmpresaTD_[]' id='idEmpresaTD_[]' type='hidden'/>";

        newCell = newRow.insertCell(8);     
        newCell.innerHTML = nomeDep+"<input value='"+idDepartamento+"' name='idDepartamento_[]' id='idDepartamento_[]' type='hidden'/>";
        

        newCell = newRow.insertCell(9);     
        newCell.innerHTML = localp+"<input value='"+idLocalp+"' name='idLocalpTD_[]' id='idLocalpTD_[]' type='hidden'/>";

        newCell = newRow.insertCell(10);     
        newCell.innerHTML = nf+"<input value='"+nf+"' name='nFTD_[]' id='nFTD_[]' type='hidden'/>";  

        newCell = newRow.insertCell(11);     
        newCell.innerHTML = "R$ "+valorUnit+"<input value='"+valorUnit+"' name='valorUnit_[]' id='valorUnit_[]' type='hidden'/>";

        newCell = newRow.insertCell(12); 
        total = valorUnit.replace(',','.')*qtd;
        newCell.innerHTML = "R$ "+total.toString().replace('.',',');    
        

        newCell = newRow.insertCell(13);     
        newCell.innerHTML = idOs+"<input value='"+idOs+"' name='idOsTD_[]' id='idOsTD_[]' type='hidden'/>"; 
        
        newCell = newRow.insertCell(14);
        newCell.innerHTML = '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button>'
        
        document.querySelector("#idProdutos").value = "";
        document.querySelector("#prod").value = "";
        
        document.querySelector("#tamanho").value = "";
        document.querySelector("#volume").value = "";
        document.querySelector("#nf").value = "";
        document.querySelector("#qtd").value = "";
        document.querySelector("#valorUnit").value = "";
        document.querySelector("#pn").value = "";
        document.querySelector("#categoriaEntrada").value = "";
        document.querySelector("#idCategoriaEntrada").value = "";
        document.querySelector("#subcategoriaEntrada").value = "";
        document.querySelector("#idSubcategoriaEntrada").value = "";
        document.querySelector("#dimensoesL").value = "";
        document.querySelector("#dimensoesC").value = "";
        document.querySelector("#dimensoesA").value = "";
        //document.querySelector("#pn").value = "";
        
        if(getCookie('tabelaEntrada') == ""){
          var arrayList = [];
          arrayList.push(arrayTabelaEntrada);    
        }else{
          var arrayList = JSON.parse(getCookie('tabelaEntrada'));
          arrayList.push(arrayTabelaEntrada);
        }
        document.cookie = 'tabelaEntrada ='+JSON.stringify(arrayList)+";path=/";
        a.disabled = false;
      } else{
        a.disabled = false;
        console.log("A")
        alertaAdicionar();
      }
    }

    function inserirLinhaTabelaEntradaProduto(){

      var table = document.getElementById("tableInsertProd").getElementsByTagName('tbody')[0];
      // Captura a quantidade de linhas já existentes na tabela


      var prod = document.querySelector("#prodprod2").value;
      var pn = document.querySelector("#pnprod2").value;
      var idProd = document.querySelector("#idProdutosProd").value;

      var empresap = document.getElementById('idEmpresaProd');
      var idEmpresa = empresap.options[empresap.selectedIndex].value;
      var nomeEmpresa = empresap.options[empresap.selectedIndex].text;

      var select = document.getElementById('idStatusProd');
      var idStatusProduto = select.options[select.selectedIndex].value;
      var nomeStatusProduto = select.options[select.selectedIndex].text;
      var localp = document.querySelector("#localpProd").value;
      var idLocalp = document.querySelector("#idLocalpProd").value;
      var idOs = document.querySelector("#idOsProd").value;

      var idDepartamento = document.querySelector("#idDepartamentoProd").value;
      var nomeDep =  document.querySelector("#departamentoProd").value;

      var nf = document.querySelector("#nfprod").value;
      var qtd = document.querySelector("#qtdprod").value;
      var valorUnit = document.querySelector("#valorUnitprod").value.replace(".","");
      var arrayTabelaEntrada = {};



      if(typeof idDepartamento != "UNDEFINED" && idDepartamento != null && idDepartamento != "" && typeof pn != "UNDEFINED" && pn != null && pn != "" && typeof prod != "UNDEFINED" && prod != null && prod != "" && typeof idMedicao != "UNDEFINED" && idMedicao != null && idMedicao != ""  && typeof qtd != "UNDEFINED" && qtd != null && qtd != "" )
      {
        if(isNaN(qtd)== true){
          a.disabled = false;
          return alert("O campo quantidade deve possuir apenas numeros.");
        }
        if(isNaN(valorUnit.replace(',','.'))== true){
          a.disabled = false;
          return alert("O campo valor unitário deve possuir apenas numeros.");
        }
        if(idOs != null){
          if(isNaN(idOs)== true){
            a.disabled = false;
            return alert("O campo OS deve possuir apenas numeros.");
          }
        }
        if(nf != null){
          if(isNaN(nf)== true){
            a.disabled = false;
            return alert("O campo NF deve possuir apenas numeros.");
          }
        }
        arrayTabelaEntrada = {
          "pn":pn,
          "prod":prod,
          "idProd":idProd,
          "idEmpresa":idEmpresa,
          "idStatusProduto":idStatusProduto,
          "nomeStatusProduto":nomeStatusProduto,
          "nomeEmpresa":nomeEmpresa,
          "localp":localp,
          "idLocalp":idLocalp,
          "idOs":idOs,
          "nf":nf,
          "qtd":qtd,
          "valorUnit":valorUnit.replace(',','.'),
          "idDepartamento": idDepartamento,
          "nomeDep":nomeDep

        };
        
        if(table.rows.length == null || typeof table.rows.length == "undefined"){
          var numOfRows = 0;
        } else {
          var numOfRows = table.rows.length;
        }
        
        // Captura a quantidade de colunas da última linha da tabela
        // var numOfCols = table.rows[numOfRows-1].cells.length;
        // Insere uma linha no fim da tabela.
        var newRow = table.insertRow(numOfRows);
        newCell = newRow.insertCell(0);   
        newCell.innerHTML = pn+"<input value='"+idProd+"' name='idProdutoTDProd_' id='idProdutoTDProd_' type='hidden'/>";
        
        newCell = newRow.insertCell(1);     
        newCell.innerHTML = prod;
        newCell.value = prod 


        //newCell = newRow.insertCell(2);     
        

        newCell = newRow.insertCell(2);     
        newCell.innerHTML = qtd+"<input value='"+qtd+"' name='qtdTDProd_' id='qtdTDProd_' type='hidden'/>";

        newCell = newRow.insertCell(3);     
        newCell.innerHTML = nomeStatusProduto+"<input value='"+idStatusProduto+"' name='idStatusProdutoTDProd_' id='idStatusProdutoTDProd_' type='hidden'/>";

        newCell = newRow.insertCell(4);     
        newCell.innerHTML = nomeEmpresa+"<input value='"+idEmpresa+"' name='idEmpresaTDProd_' id='idEmpresaTDProd_' type='hidden'/>";

        newCell = newRow.insertCell(5);     
        newCell.innerHTML = nomeDep+"<input value='"+idDepartamento+"' name='idDepartamentoProd_' id='idDepartamentoProd_' type='hidden'/>";
        

        newCell = newRow.insertCell(6);     
        newCell.innerHTML = localp+"<input value='"+idLocalp+"' name='idLocalpTDProd_' id='idLocalpTDProd_' type='hidden'/>";

        newCell = newRow.insertCell(7);     
        newCell.innerHTML = nf+"<input value='"+nf+"' name='nFTDProd_' id='nFTDProd_' type='hidden'/>";  

        newCell = newRow.insertCell(8);     
        newCell.innerHTML = "R$ "+valorUnit+"<input value='"+valorUnit+"' name='valorUnitProd_' id='valorUnitProd_' type='hidden'/>";

        newCell = newRow.insertCell(9); 
        total = valorUnit.replace(',','.')*qtd;
        newCell.innerHTML = "R$ "+total.toString().replace('.',',');    
        

        newCell = newRow.insertCell(10);     
        newCell.innerHTML = idOs+"<input value='"+idOs+"' name='idOsTDProd_' id='idOsTDProd_' type='hidden'/>"; 
        
        newCell = newRow.insertCell(11);
        newCell.innerHTML = '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow3(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button>'
        
        document.querySelector("#prodprod2").value = "";
        document.querySelector("#pnprod").value = "";
        document.querySelector("#prodprod").value = "";
        document.querySelector("#pnprod2").value = "";
        
        document.querySelector("#idProdutosProd").value = "";
        document.querySelector("#localpProd").value = "";
        document.querySelector("#idLocalpProd").value = "";
        document.querySelector("#idOsProd").value = "";
        document.querySelector("#valorUnitprod").value = "";
        document.querySelector("#nfprod").value = "";
        document.querySelector("#qtdprod").value = "";
        document.querySelector("#idSubcategoriaEntrada").value = "";
        //document.querySelector("#pn").value = "";
        
        if(getCookie('tabelaEntradaProduto') == ""){
          var arrayList = [];
          arrayList.push(arrayTabelaEntrada);    
        }else{
          var arrayList = JSON.parse(getCookie('tabelaEntradaProduto'));
          arrayList.push(arrayTabelaEntrada);
        }
        a.disabled = false;
        document.cookie = 'tabelaEntradaProduto = '+JSON.stringify(arrayList)+";path=/";
      } else{
        console.log("A")
        a.disabled = false;
        alertaAdicionar();
      }
    }

    function inserirLinhaTabelaSaidaProduto(){
      var a = document.querySelector("#aSaidaP");
      if(a.disabled == true){
        return;
      }else{
        a.disabled = true;
      }
      var table = document.getElementById("tableSaidaProd").getElementsByTagName('tbody')[0];
      // Captura a quantidade de linhas já existentes na tabela


      var prod = document.querySelector("#prodSProd2").value;
      var pn = document.querySelector("#pnSProd2").value;
      var idEstoque = document.querySelector("#idAlmoEstoqueSProd").value;

      var empresap = document.getElementById('idEmpresaSProd');
      var idEmpresa = empresap.options[empresap.selectedIndex].value;
      var nomeEmpresa = empresap.options[empresap.selectedIndex].text;

      var select = document.getElementById('idEmpresaDestSProd');
      var idEmpresaDest = select.options[select.selectedIndex].value;
      var nomeEmpresaDest = select.options[select.selectedIndex].text;
      var localp = document.querySelector("#localSProd").value;
      var idLocalp = document.querySelector("#idLocalSProd").value;
      var idOs = document.querySelector("#idOsSProd").value;

      //var select2 = document.getElementById('idSetorProd');
      var idSetor = document.querySelector("#idSetorProd").value;
      var nomeSetor = document.querySelector("#nomeSetorProd").value;

      var idDepartamento = document.querySelector("#idDepartamentoSProd").value;
      var nomeDep =  document.querySelector("#departamentoSProd").value;

      var qtdEst = document.querySelector("#qtdestSProd").value;
      var qtd = document.querySelector("#qtdSProd").value;
      var obs = document.querySelector("#obsSProd").value;

      var idUser = document.querySelector("#idUserSProd").value;
      var nomeUser = document.querySelector("#userSProd2").value;
      var arrayTabelaEntrada = {};



      if(typeof idDepartamento != "UNDEFINED" && idDepartamento != null && idDepartamento != "" && typeof pn != "UNDEFINED" && pn != null && pn != "" && typeof prod != "UNDEFINED" && prod != null && prod != "" && typeof idMedicao != "UNDEFINED" && idMedicao != null && idMedicao != ""  && typeof qtd != "UNDEFINED" && qtd != null && qtd != "" && typeof idUser != "UNDEFINED" && idUser != null && idUser != "")
      {
        if(isNaN(qtd)== true){
          a.disabled = false;
          return alert("O campo quantidade deve possuir apenas numeros.");
        }
        if(!verificarEstoqueProduto(idEstoque,qtd,qtdEst)){
          a.disabled = false;
          return alert("Quantidade informada é maior que a quantia em estoque.");
        }
        if(idOs != null){
          if(isNaN(idOs)== true){
            a.disabled = false;
            return alert("O campo OS deve possuir apenas numeros.");
          }
        }

        
        
        arrayTabelaEntrada = {
          "pn":pn,
          "prod":prod,
          "idEstoque":idEstoque,
          "idEmpresa":idEmpresa,
          "idEmpresaDest":idEmpresaDest,
          "nomeEmpresaDest":nomeEmpresaDest,
          "nomeEmpresa":nomeEmpresa,
          "localp":localp,
          "idLocalp":idLocalp,
          "idOs":idOs,
          "obs":obs,
          "idUser":idUser,
          "idSetor":idSetor,
          "nomeSetor":nomeSetor,
          "nomeUser":nomeUser,
          "qtd":qtd,
          "idDepartamento": idDepartamento,
          "nomeDep":nomeDep

        };
        
        if(table.rows.length == null || typeof table.rows.length == "undefined"){
          var numOfRows = 0;
        } else {
          var numOfRows = table.rows.length;
        }
        
        // Captura a quantidade de colunas da última linha da tabela
        // var numOfCols = table.rows[numOfRows-1].cells.length;
        // Insere uma linha no fim da tabela.
        var newRow = table.insertRow(numOfRows);
        newCell = newRow.insertCell(0);   
        newCell.innerHTML = idEstoque+"<input value='"+idEstoque+"' name='idEstoqueTDSProd_' id='idEstoqueTDSProd_' type='hidden'/>";
        
        newCell = newRow.insertCell(1);     
        newCell.innerHTML = prod+"<input value='"+qtd+"' name='qtdTDSProd_' id='qtdTDSProd_' type='hidden'/>";
        newCell.value = prod 


        newCell = newRow.insertCell(2);     
        

        newCell = newRow.insertCell(3);     
        newCell.innerHTML = qtd;

        newCell = newRow.insertCell(4);     
        newCell.innerHTML = localp;

        //newCell.innerHTML = nomeStatusProduto+"<input value='"+idStatusProduto+"' name='idStatusProdutoTDSProd_' id='idStatusProdutoTDSProd_' type='hidden'/>";

        newCell = newRow.insertCell(5);     
        newCell.innerHTML = nomeEmpresaDest+"<input value='"+idEmpresaDest+"' name='idEmpresaTDSProd_' id='idEmpresaTDSProd_' type='hidden'/>";

        newCell = newRow.insertCell(6);     
        newCell.innerHTML = nomeSetor+"<input value='"+idSetor+"' name='idSetorProd_' id='idSetorProd_' type='hidden'/>";
        

        newCell = newRow.insertCell(7);   
        newCell.innerHTML = nomeUser+"<input value='"+idUser+"' name='idUserProd_' id='idUserProd_' type='hidden'/>";  
        
        newCell = newRow.insertCell(8);     
        newCell.innerHTML = idOs+"<input value='"+idOs+"' name='idOsTDSProd_' id='idOsTDSProd_' type='hidden'/>";  

        newCell = newRow.insertCell(9);     
        newCell.innerHTML = obs+"<input value='"+obs+"' name='obsTDSProd_' id='obsTDSProd_' type='hidden'/>";  
        
        newCell = newRow.insertCell(10);
        newCell.innerHTML = '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow4(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button>'
        
        document.querySelector("#prodSProd2").value = "";
        document.querySelector("#pnSProd2").value = "";
        document.querySelector("#prodSProd").value = "";
        document.querySelector("#pnSProd").value = "";
        
        document.querySelector("#localSProd").value = "";
        document.querySelector("#idLocalSProd").value = "";
        document.querySelector("#idOsSProd").value = "";
        document.querySelector("#idOsProd").value = "";
        document.querySelector("#qtdestSProd").value = "";
        //document.querySelector("#pn").value = "";
        
        if(getCookie('tabelaSaidaProduto') == ""){
          var arrayList = [];
          arrayList.push(arrayTabelaEntrada);    
        }else{
          var arrayList = JSON.parse(getCookie('tabelaSaidaProduto'));
          arrayList.push(arrayTabelaEntrada);
        }
        a.disabled = false;
        document.cookie = 'tabelaSaidaProduto = '+JSON.stringify(arrayList)+";path=/";
      } else{
        a.disabled = false;
        alertaAdicionar();
      }
    }

    function cadastrarEntradaEstoqueProduto(){
      var a = document.querySelector("#fEntradaP");
      if(a.disabled == true){
        return;
      }else{
        a.disabled = true;
      }
      var idProdutoTDProd_ = Array.apply(null,document.querySelectorAll("#idProdutoTDProd_"));
      var qtdTDProd_ = Array.apply(null,document.querySelectorAll("#qtdTDProd_"));
      var idEmpresaTDProd_ = Array.apply(null,document.querySelectorAll("#idEmpresaTDProd_"));
      var idStatusProdutoTDProd_ = Array.apply(null,document.querySelectorAll("#idStatusProdutoTDProd_"));
      var idDepartamentoProd_ = Array.apply(null,document.querySelectorAll("#idDepartamentoProd_"));
      var idLocalpTDProd_ = Array.apply(null,document.querySelectorAll("#idLocalpTDProd_"));
      var nFTDProd_ = Array.apply(null,document.querySelectorAll("#nFTDProd_"));
      var valorUnitProd_ = Array.apply(null,document.querySelectorAll("#valorUnitProd_"));
      var idOsTDProd_ = Array.apply(null,document.querySelectorAll("#idOsTDProd_"));
      var data = new Array();
      var obj = {};
      for(var x=0;x<idProdutoTDProd_.length;x++){
        obj = {};
        obj={
          'idProdutoTDProd':idProdutoTDProd_[x].value,
          'qtdTDProd':qtdTDProd_[x].value,
          'idEmpresaTDProd':idEmpresaTDProd_[x].value,
          'idStatusProdutoTDProd':idStatusProdutoTDProd_[x].value,
          'idDepartamentoProd':idDepartamentoProd_[x].value,
          'idLocalpTDProd':idLocalpTDProd_[x].value,
          'nFTDProd':nFTDProd_[x].value,
          'valorUnitProd':valorUnitProd_[x].value.replace(",","."),
          'idOsTDProd':idOsTDProd_[x].value
        }
        data.push(obj);
      }
      $.ajax({
        url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarEntradasProdutos",
        type: 'POST',
        dataType: 'json',
        data: {
          arrayEntradas: data
        },
        success: function(data2) {
          if(data2.result){
            //var arrayList = JSON.parse(getCookie('tabelaEntradaProduto'));
            arrayList = { };
            $('#tableInsertProd tbody').empty();
            //document.cookie = 'tabelaEntradaProduto ='+JSON.stringify(arrayList)+";path=/";
            a.disabled = false;
            alert("Itens cadastrados com sucesso.");
          }
        },
        error: function(xhr, textStatus, error) {
          console.log("4");
          console.log(xhr.responseText);
          console.log(xhr.statusText);
          console.log(textStatus);
          console.log(error);
          a.disabled = false;
        },

      })
     
     
     
      //console.log(data);
      

    }

    function cadastrarSaidaEstoqueProduto(){
      var a = document.querySelector("#fSaidaP");
      if(a.disabled == true){
        return;
      }else{
        a.disabled = true;
      }
      var idEstoqueTDSProd_ = Array.apply(null,document.querySelectorAll("#idEstoqueTDSProd_"));
      var qtdTDSProd_ = Array.apply(null,document.querySelectorAll("#qtdTDSProd_"));
      var idEmpresaTDSProd_ = Array.apply(null,document.querySelectorAll("#idEmpresaTDSProd_"));
      var idSetorProd_ = Array.apply(null,document.querySelectorAll("#idSetorProd_"));
      var idUserProd_ = Array.apply(null,document.querySelectorAll("#idUserProd_"));
      var idOsTDSProd_ = Array.apply(null,document.querySelectorAll("#idOsTDSProd_"));
      var obsTDSProd_ = Array.apply(null,document.querySelectorAll("#obsTDSProd_"));
      var obj = {};
      var data = new Array();
      for(var x=0;x<idEstoqueTDSProd_.length;x++){
        obj = {};
        obj={
          'idEstoqueTDSProd_':idEstoqueTDSProd_[x].value,
          'qtdTDSProd_':qtdTDSProd_[x].value,
          'idEmpresaTDSProd_':idEmpresaTDSProd_[x].value,
          'idSetorProd_':idSetorProd_[x].value,
          'idUserProd_':idUserProd_[x].value,
          'idOsTDSProd_':idOsTDSProd_[x].value,
          'obsTDSProd_':obsTDSProd_[x].value
        }
        data.push(obj);
      }
      $.ajax({
        url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarSaidasProdutos",
        type: 'POST',
        dataType: 'json',
        data: {
          arraySaidas: data
        },
        success: function(data2) {
          if(data2.result){
            var arrayList = [];
            $('#tableSaidaProd tbody').empty();
            document.cookie = 'tabelaSaidaProduto ='+JSON.stringify(arrayList)+";path=/";
            a.disabled = false;
            alert("Saídas cadastradas com sucesso.");
          } else {
            a.disabled = false;
            alert(data2.msggg);
          }
        },
        error: function(xhr, textStatus, error) {
          console.log("4");
          console.log(xhr.responseText);
          console.log(xhr.statusText);
          console.log(textStatus);
          console.log(error);
          a.disabled = false;
        },

      })
     
     
     
      //console.log(data);
      

    }

    function getCookie(cname){
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(';');
      for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    function alertaAdicionar(){
      alert("Os campos Descrição, Quantidade, Departamento e Valor Unit. não podem ser vazios.");
    }


    function verificar(value){
      
      var tamanho = document.querySelector('.tamanho');
      var volume = document.querySelector('.volume');
      var peso = document.querySelector('.peso');
      var dimensoes = document.querySelector('.dimensoes');
      document.querySelector("#tamanho").value = "";
      document.querySelector("#volume").value = "";
      document.querySelector("#peso").value = "";
      document.querySelector("#dimensoesL").value = "";
      document.querySelector("#dimensoesC").value = "";
      document.querySelector("#dimensoesA").value = "";

      if(value == 0){
        tamanho.style.display = "none";
        volume.style.display = "none";
        peso.style.display = "none";
        dimensoes.style.display = "none";
      }else if(value == 1){
        tamanho.style.display = "block";
        volume.style.display = "none";
        peso.style.display = "none";
        dimensoes.style.display = "none";
      }else if(value == 2){
        tamanho.style.display = "none";
        volume.style.display = "block";
        peso.style.display = "none";
        dimensoes.style.display = "none";
      }else if(value == 3){
        tamanho.style.display = "none";
        volume.style.display = "none";
        peso.style.display = "block";
        dimensoes.style.display = "none";
      }else if(value == 4){
        tamanho.style.display = "none";
        volume.style.display = "none";
        peso.style.display = "none";
        dimensoes.style.display = "block";
      }
    };

    function verificarE(value){
      
      var tamanho = document.querySelector('.tamanhoe');
      var volume = document.querySelector('.volumee');
      var peso = document.querySelector('.pesoe');
      var dimensoes = document.querySelector('.dimensoese');
      document.querySelector("#tamanhoe").value = "";
      document.querySelector("#volumee").value = "";
      document.querySelector("#pesoe").value = "";
      document.querySelector("#dimensoese").value = "";

      if(value == 1 || value == 0){
        tamanho.style.display = "none";
        volume.style.display = "none";
        peso.style.display = "none";
        dimensoes.style.display = "none";
      }else if(value == 2){
        tamanho.style.display = "block";
        volume.style.display = "none";
        peso.style.display = "none";
        dimensoes.style.display = "none";
      }else if(value == 3){
        tamanho.style.display = "none";
        volume.style.display = "block";
        peso.style.display = "none";
        dimensoes.style.display = "none";
      }else if(value == 4){
        tamanho.style.display = "none";
        volume.style.display = "none";
        peso.style.display = "block";
        dimensoes.style.display = "none";
      }else if(value == 4){
        tamanho.style.display = "none";
        volume.style.display = "none";
        peso.style.display = "none";
        dimensoes.style.display = "block";
      }
    };

    function alterarLocal(){
      var selectdois = document.getElementById('idEmpresa');
      var empresadois = selectdois.options[selectdois.selectedIndex].value;
      
      return empresadois;
    };

    function alterarLocal1(){
      var selectdois = document.querySelector('idDepartamento');
      var idDepartamento = selectdois.value;
      
      return idDepartamento;
    };

    function alterarSetor(){
      var selectdois = document.getElementById('idSetor');
      var setor = selectdois.options[selectdois.selectedIndex].value;
      
      return setor;
    };
    function alterarSetor3(){
      var selectdois = document.getElementById('idSetorProd');
      var setor = selectdois.options[selectdois.selectedIndex].value;
      
      return setor;
    };

    function alterarLocal2(value){
      var idDepartamento = document.querySelector('idDepartamento').value;
      $("#localp").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteLocais/"+value+"/"+idDepartamento,
        minLength: 1,
        select: function( event, ui ) {
          $('#idLocalp').val(ui.item.id);
        }
      });
      document.querySelector("#localp").value = "";
      document.querySelector("#idLocalp").value = "";
    };

    function alterarLocal22(value){
      var select = document.getElementById('idEmpresa');
      var idEmpresa = select.options[select.selectedIndex].value;
      $("#localp").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteLocais/"+idEmpresa+"/"+value,
        minLength: 1,
        select: function( event, ui ) {
          $('#idLocalp').val(ui.item.id);
        }
      });
      document.querySelector("#localp").value = "";
      document.querySelector("#idLocalp").value = "";
    };

    function alterarSetor2(value){
      $("#userS").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteFunc/"+value,
        minLength: 1,
        select: function( event, ui ) {
          $('#idUserS').val(ui.item.id);
          $('#idSetor').val(ui.item.idSetor);
          $('#nomeSetor').val(ui.item.nomeSetor);
        }
      });
      document.querySelector("#userS").value = "";
      document.querySelector("#idUserS").value = "";
    };

    function alterarSetor4(value){
      $("#userSProd").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteFunc/"+value,
        minLength: 1,
        select: function( event, ui ) {
          $('#idUserSProd').val(ui.item.id);
        }
      });
    };

    function alterarEstoque(value){
      var select = document.querySelector('#idDepartamentoS');
      var idDepartamento = select.value;
      $("#prodS").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteEstoqueSaida/"+value+'/'+idDepartamento,
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueS').val(ui.item.id);
          $('#localS').val(ui.item.local);
          $('#pnS4').val(ui.item.pn);
          $('#pnS').val(ui.item.pn);
          $('#qtdestS').val(ui.item.quantidade);
          $('#prodS').val(ui.item.nome);
          

        }
      });
      document.querySelector("#prodS").value = "";
      document.querySelector("#idAlmoEstoqueS").value = "";
      document.querySelector("#localS").value = "";
      document.querySelector("#qtdestS").value = "";
    };

    function alterarEstoque1(value){
      var select = document.getElementById('idEmpresaS');
      var idEmpresa = select.options[select.selectedIndex].value;
      $("#prodS").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteEstoqueSaida/"+idEmpresa+'/'+value,
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueS').val(ui.item.id);
          $('#localS').val(ui.item.local);
          $('#pnS4').val(ui.item.pn);
          $('#pnS').val(ui.item.pn);
          $('#qtdestS').val(ui.item.quantidade);
          $('#prodS').val(ui.item.nome);
          

        }
      });
      $("#pnS").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteInsumosPN/"+idEmpresa+'/'+value,
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueS').val(ui.item.id);
          $('#prodS').val(ui.item.nome);
          $('#pnS4').val(ui.item.pn);
          $('#localS').val(ui.item.local);
          $('#qtdestS').val(ui.item.quantidade);

        }
      });
      document.querySelector("#prodS").value = "";
      document.querySelector("#idAlmoEstoqueS").value = "";
      document.querySelector("#localS").value = "";
      document.querySelector("#qtdestS").value = "";
    };

    function alterarEstoque2(value){
      var select = document.getElementById('idEmpresaSProd');
      var idEmpresa = select.options[select.selectedIndex].value;
      $("#prodSProd").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProdEstoque/"+idEmpresa+"/"+value,
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueSProd').val(ui.item.id);
          $('#pnSProd').val(ui.item.pn);
          $('#pnSProd2').val(ui.item.pn);
          $('#prodSProd2').val(ui.item.nome);
          $('#qtdestSProd').val(ui.item.quantidade);
          $('#localSProd').val(ui.item.local);
          //$('#pnSProd').val(ui.item.pn);
        }
      });	
      $("#pnSProd").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompletePnEstoque/"+idEmpresa+"/"+value,
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueSProd').val(ui.item.id);
          $('#prodSProd').val(ui.item.nome);
          $('#prodSProd2').val(ui.item.nome);
          $('#pnSProd2').val(ui.item.pn);
          $('#qtdestSProd').val(ui.item.quantidade);
          $('#localSProd').val(ui.item.local);
          //$('#pnSProd').val(ui.item.pn);
        }
      });	  
    };

    function alterarEstoque3(value){
      //var select = document.getElementById('idDepartamentoS');
      //var idDepartamento = select.options[select.selectedIndex].value;
      var idDepartamento = document.querySelector('#idDepartamentoSProd').value;
      console.log(idDepartamento);
      $("#prodSProd").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProdEstoque/"+value+'/'+idDepartamento,
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueSProd').val(ui.item.id);
          $('#pnSProd').val(ui.item.pn);
          $('#pnSProd2').val(ui.item.pn);
          $('#prodSProd2').val(ui.item.nome);
          $('#qtdestSProd').val(ui.item.quantidade);
          $('#localSProd').val(ui.item.local);
          $('#refSProd').val(ui.item.referencia);
          $('#refSProd2').val(ui.item.referencia);
          

        }
      });
      $("#pnSProd").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompletePnEstoque/"+value+'/'+idDepartamento,
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueSProd').val(ui.item.id);
          $('#prodSProd').val(ui.item.nome);
          $('#prodSProd2').val(ui.item.nome);
          $('#pnSProd2').val(ui.item.pn);
          $('#qtdestSProd').val(ui.item.quantidade);
          $('#localSProd').val(ui.item.local);
          $('#refSProd').val(ui.item.referencia);
          $('#refSProd2').val(ui.item.referencia);

        }
      });
      $("#refSProd").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteREFEstoque/"+value+"/"+idDepartamento,
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueSProd').val(ui.item.id);
          $('#prodSProd').val(ui.item.nome);
          $('#prodSProd2').val(ui.item.nome);
          $('#pnSProd2').val(ui.item.pn);
          $('#pnSProd').val(ui.item.pn);
          $('#qtdestSProd').val(ui.item.quantidade);
          $('#localSProd').val(ui.item.local);          
          $('#refSProd2').val(ui.item.referencia);  
          //$('#pnSProd').val(ui.item.pn);
        }
      });	
    };

    function getidEmpresaS(){
      var select = document.getElementById('idEmpresaS');
      var idEmpresa = select.options[select.selectedIndex].value;
      return idEmpresa;
    }

    function getidEmpresaS2(){
      var select = document.getElementById('idEmpresaSProd');
      var idEmpresa = select.options[select.selectedIndex].value;
      return idEmpresa;
    }

    function getidDepartamentoS(){
      var idDepartamentoS = document.querySelector('#idDepartamentoS').value;
      return idDepartamentoS;
    }

    function getidDepartamentoS2(){
      var idDepartamentoS = document.querySelector('#idDepartamentoSProd').value;
      return idDepartamentoS;
    }

    function alterarLocale(){
      var selectdois = document.getElementById('idEmpresae');
      var empresadois = selectdois.options[selectdois.selectedIndex].value;
      
      return empresadois;
    };

    function alterarLocal2e(value){
      $("#locale").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteLocais/"+value,
        minLength: 1,
        select: function( event, ui ) {
          $('#idLocale').val(ui.item.id);
        }
      });
      document.querySelector("#locale").value = "";
      document.querySelector("#idLocale").value = "";
    };


    function deleteRow(i){
        document.getElementById('tableInsert').deleteRow(i)
        var arrayList = JSON.parse(getCookie('tabelaEntrada'));
        arrayList.splice(i-1,1);
        document.cookie = 'tabelaEntrada ='+JSON.stringify(arrayList)+";path=/";
    }

    function deleteRow2(i){
        document.getElementById('tableSaida').deleteRow(i)
        var arrayList = JSON.parse(getCookie('tabelaSaida'));
        arrayList.splice(i-1,1);
        document.cookie = 'tabelaSaida ='+JSON.stringify(arrayList)+";path=/";
    }
    function deleteRow3(i){
        document.getElementById('tableInsertProd').deleteRow(i)
        var arrayList = JSON.parse(getCookie('tabelaEntradaProduto'));
        arrayList.splice(i-1,1);
        document.cookie = 'tabelaEntradaProduto ='+JSON.stringify(arrayList)+";path=/";
    }

    function deleteRow4(i){
        document.getElementById('tableSaidaProd').deleteRow(i)
        var arrayList = JSON.parse(getCookie('tabelaSaidaProduto'));
        arrayList.splice(i-1,1);
        document.cookie = 'tabelaSaidaProduto ='+JSON.stringify(arrayList)+";path=/";
    }

    function verificarItensSaida(id,qtd,qtdEstoq){
      var table = document.getElementById("tableSaida");
      if(table.rows.length == null || typeof table.rows.length == "undefined"){
          var numOfRows = 0;
      } else {
          var numOfRows = table.rows.length;
      }
      var colum;
      var somQtd = eval(qtd);
      for(var x=0;x<numOfRows;x++){
        colum = table.rows[x].cells; 
        if(typeof colum[0] != "undefined"){
          if(typeof colum[0].innerHTML != "undefined"){      
            //console.log(colum[2].value);
            if(colum[0].value==id){          
              somQtd = eval(somQtd) + eval(colum[2].value);
            }  
          }   
        }       
      }  
      if(somQtd > qtdEstoq){
        return false;    
      }
      return true;
    }

    function verificarEstoqueProduto(id,qtd,qtdEstoq){
      var table = document.getElementById("tableSaidaProd").getElementsByTagName('tbody')[0];
      if(table.rows.length == null || typeof table.rows.length == "undefined"){
          var numOfRows = 0;
      } else {
          var numOfRows = table.rows.length;
      }
      var colum;
      var somQtd = eval(qtd);
      for(var x=0;x<numOfRows;x++){
        colum = table.rows[x].cells; 
        if(typeof colum[0] != "undefined"){
          if(typeof colum[0].innerHTML != "undefined"){      
            //console.log(colum[2].value);
            if(colum[0].value==id){          
              somQtd = eval(somQtd) + eval(colum[2].value);
            }  
          }   
        }       
      }  
      if(somQtd > qtdEstoq){
        return false;    
      }
      return true;
    }

    function alterarRelatorio(valor){
      var entradaRelatorio = document.querySelector('.entradaRelatorio');
      var entradaRelatorioTAB = document.querySelector('.entradaRelatorioTAB');
      var saidaRelatorio = document.querySelector('.saidaRelatorio');
      var saidaRelatorioTAB = document.querySelector('.saidaRelatorioTAB');
      if(valor == "Entrada"){
        entradaRelatorio.style.display = "block";
        saidaRelatorio.style.display = "none";
        entradaRelatorioTAB.style.display = "block";
        saidaRelatorioTAB.style.display = "none";
      } else if(valor == "Saida"){
        entradaRelatorio.style.display = "none";
        saidaRelatorio.style.display = "block";
        entradaRelatorioTAB.style.display = "none";
        saidaRelatorioTAB.style.display = "block";
      }
    }

    function FormataValor2(objeto, teclapres, tammax, decimais) {
      var tecla			= teclapres.keyCode;
      var tamanhoObjeto	= objeto.value.length;

      

      if ((tecla == 8) && (tamanhoObjeto == tammax))
        tamanhoObjeto = tamanhoObjeto - 1 ;



      if (( tecla == 8 || tecla == 88 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ) && ((tamanhoObjeto+1) <= tammax)) {
        
        vr	= objeto.value;
        vr	= vr.replace( "/", "" );
        vr	= vr.replace( "/", "" );
        vr	= vr.replace( ",", "" );
        vr	= vr.replace( ".", "" );
        vr	= vr.replace( ".", "" );
        vr	= vr.replace( ".", "" );
        vr	= vr.replace( ".", "" );
        tam	= vr.length;
        
        if (tam < tammax && tecla != 8)
          tam = vr.length + 1 ;

        if ((tecla == 8) && (tam > 1)){
          tam = tam - 1 ;
          vr = objeto.value;
          vr = vr.replace( "/", "" );
          vr = vr.replace( "/", "" );
          vr = vr.replace( ",", "" );
          vr = vr.replace( ".", "" );
          vr = vr.replace( ".", "" );
          vr = vr.replace( ".", "" );
          vr = vr.replace( ".", "" );
          }
      
        //Cálculo para casas decimais setadas por parametro
        if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ) {
          if (decimais > 0) {
            if ( (tam <= decimais) )
              objeto.value = ("0," + vr) ;
              
            if( (tam == (decimais + 1)) && (tecla == 8))
              objeto.value = vr.substr( 0, (tam - decimais)) + ',' + vr.substr( tam - (decimais), tam ) ;	
              
            if ( (tam > (decimais + 1)) && (tam <= (decimais + 3)) &&  ((vr.substr(0,1)) == "0"))
              objeto.value = vr.substr( 1, (tam - (decimais+1))) + ',' + vr.substr( tam - (decimais), tam ) ;
              
            if ( (tam > (decimais + 1)) && (tam <= (decimais + 3)) &&  ((vr.substr(0,1)) != "0"))
                objeto.value = vr.substr( 0, tam - decimais ) + ',' + vr.substr( tam - decimais, tam ) ; 
              
            if ( (tam >= (decimais + 4)) && (tam <= (decimais + 6)) )
              objeto.value = vr.substr( 0, tam - (decimais + 3) ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

            if ( (tam >= (decimais + 7)) && (tam <= (decimais + 9)) )
              objeto.value = vr.substr( 0, tam - (decimais + 6) ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

            if ( (tam >= (decimais + 10)) && (tam <= (decimais + 12)) )
              objeto.value = vr.substr( 0, tam - (decimais + 9) ) + '.' + vr.substr( tam - (decimais + 9), 3 ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

            if ( (tam >= (decimais + 13)) && (tam <= (decimais + 15)) )
              objeto.value = vr.substr( 0, tam - (decimais + 12) ) + '.' + vr.substr( tam - (decimais + 12), 3 ) + '.' + vr.substr( tam - (decimais + 9), 3 ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

          }
          else if(decimais == 0) {
            if ( tam <= 3 )
              objeto.value = vr ;
              
            if ( (tam >= 4) && (tam <= 6) ) {
              if(tecla == 8) {
                objeto.value = vr.substr(0, tam);
                window.event.cancelBubble = true;
                window.event.returnValue = false;
                }
              objeto.value = vr.substr(0, tam - 3) + '.' + vr.substr( tam - 3, 3 ); 
              }
              
            if ( (tam >= 7) && (tam <= 9) ) {
              if(tecla == 8) {
                objeto.value = vr.substr(0, tam);
                window.event.cancelBubble = true;
                window.event.returnValue = false;
                }
              objeto.value = vr.substr( 0, tam - 6 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ); 
              }

            if ( (tam >= 10) && (tam <= 12) ) {
              if(tecla == 8) {
                objeto.value = vr.substr(0, tam);
                window.event.cancelBubble = true;
                window.event.returnValue = false;
                }
              objeto.value = vr.substr( 0, tam - 9 ) + '.' + vr.substr( tam - 9, 3 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ); 
              }

            if ( (tam >= 13) && (tam <= 15) ){
              if(tecla == 8) {
                objeto.value = vr.substr(0, tam);
                window.event.cancelBubble = true;
                window.event.returnValue = false;
                }
              objeto.value = vr.substr( 0, tam - 12 ) + '.' + vr.substr( tam - 12, 3 ) + '.' + vr.substr( tam - 9, 3 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ) ;
              }			
            }
          }
        }
      else if((window.event.keyCode != 8) && (window.event.keyCode != 9) && (window.event.keyCode != 13) && (window.event.keyCode != 35) && (window.event.keyCode != 36) && (window.event.keyCode != 46)) {
          window.event.cancelBubble = true;
          window.event.returnValue = false;
          }
    }

    function adicionarUsuarioTabelaUser(cod,empresa, setor, nome, cpf){
      var table = document.getElementById("tableUser");
      if(table.rows.length == null || typeof table.rows.length == "undefined"){
        var numOfRows = 0;
      } else {
        var numOfRows = table.rows.length;
      }
      newRow = table.insertRow(1);

      newCell = newRow.insertCell(0); 
      newCell.innerHTML = cod;

      newCell = newRow.insertCell(1); 
      newCell.innerHTML = nome;

      newCell = newRow.insertCell(2); 
      newCell.innerHTML = cpf;

      newCell = newRow.insertCell(3); 
      newCell.innerHTML = empresa;

      newCell = newRow.insertCell(4); 
      newCell.innerHTML = setor;
    }

    function pesquisarOs(){
      var idDepartamento = document.querySelector('#idDepartamentoS').value;
      var select2 = document.getElementById('idEmpresaS');
      var idEmpresa = select2.options[select2.selectedIndex].value;
      var idOs = document.querySelector('#idOsS').value;
      var table = document.getElementById("tableOs").getElementsByTagName('tbody')[0];
      $('#tableOs tbody').empty();
      var newRow
      if(table.rows.length == null || typeof table.rows.length == "undefined"){
          var numOfRows = 0;
      } else {
        var numOfRows = table.rows.length;
      }
      table
      $.ajax({
        url: "<?php echo base_url(); ?>index.php/almoxarifado/getItensOs/"+idOs+"/"+idEmpresa+"/"+idDepartamento,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          if(data.result == true){
            if(data.resultado.length > 0){
              document.querySelector('#itemOs').value = idOs;
              for(x=0;x<data.resultado.length;x++){
                newRow = table.insertRow(numOfRows+x);
                newCell = newRow.insertCell(0);   
                newCell.innerHTML = "<input value='"+data.resultado[x].idAlmoEstoque+"' name='idAlmoEstoqueP' id='idAlmoEstoqueP' type='checkbox'/>";
                newCell = newRow.insertCell(1);   
                newCell.innerHTML = data.resultado[x].descricaoInsumo+"<input value='"+data.resultado[x].descricaoInsumo+"' name='descricaoInsumoP' id='descricaoInsumoP' type='hidden'/>";
                newCell = newRow.insertCell(2);   
                newCell.innerHTML = "<input value='"+data.resultado[x].quantidade+"' class='span12' name='quantidadeP' id='quantidadeP' type='text'/>"+"<input value='"+data.resultado[x].quantidade+"' name='quantidadeRealP' id='quantidadeRealP' type='hidden'/>";;
                newCell = newRow.insertCell(3);   
                newCell.innerHTML = data.resultado[x].local+"<input value='"+data.resultado[x].local+"' name='descricaoLocalP' id='descricaoLocalP' type='hidden'/>";
                newCell = newRow.insertCell(4);   
                newCell.innerHTML = data.resultado[x].nome+"<input value='"+data.resultado[x].nome+"' name='descricaoEmitenteP' id='descricaoEmitenteP' type='hidden'/>";
              }

              $('#modal-itensOs').modal('show');
            }else{
              alert('Não foi encontrado materiais reservados para essa O.S.');
            }
          }else{
            
          }
        
        },
      })
    }
    function adicionarItensTabelaSaida(){
      if(document.querySelector('#idUserpS').value == "" || document.querySelector('#idSetorp').value == ""){
        return alert('Informe o usuário que está retirando o(s) item(ns)');
      }
      idAlmoEstoque = Array.apply(null,document.querySelectorAll('#idAlmoEstoqueP'));
      quantidadeP = Array.apply(null,document.querySelectorAll('#quantidadeP'));
      quantidadeRealP = Array.apply(null,document.querySelectorAll('#quantidadeRealP'));
      descricaoInsumoP = Array.apply(null,document.querySelectorAll('#descricaoInsumoP'));
      descricaoLocalP = Array.apply(null,document.querySelectorAll('#descricaoLocalP'));
      descricaoEmitenteP = Array.apply(null,document.querySelectorAll('#descricaoEmitenteP'));
      var user = document.querySelector("#idUserpS").value;
      var userNome = document.querySelector("#userpS2").value;
      var idSetor = document.querySelector("#idSetorp").value;
      var nomeSetor = document.querySelector("#nomeSetorp").value;
      var itemOs = document.querySelector("#itemOs").value;
      var obs = document.querySelector("#obspS").value;
      var empresaDoc = document.getElementById("idEmpresaDestSp");
      var idEmpresa = empresaDoc.options[empresaDoc.selectedIndex].value;
      var descEmpresa = empresaDoc.options[empresaDoc.selectedIndex].key;
      itemSel = false;
      for(x=0;x<idAlmoEstoque.length;x++){
        if(idAlmoEstoque[x].checked){
          itemSel = true;
          if(isNaN(quantidadeP[x].value) == true){
            return alert("A quantidade informada não é um número inteiro.");
          }
          if(!verificarItensSaida(idAlmoEstoque[x].value,quantidadeP[x].value,quantidadeRealP[x].value)){
            return alert("A quantidade informada é maior que a quantidade em estoque.");
          }
        }
      }
      if(itemSel == false){
        return alert('Nenhum item foi selecionado.');
      }
      var table = document.getElementById("tableSaida");
      if(table.rows.length == null || typeof table.rows.length == "undefined"){
        var numOfRows = 0;
      } else {
        var numOfRows = table.rows.length;
      }
      var newRow
      for(x=0;x<idAlmoEstoque.length;x++){
        if(idAlmoEstoque[x].checked){
          // Insere uma linha no fim da tabela.
          newRow = table.insertRow(numOfRows+x);
          newCell = newRow.insertCell(0);   
          newCell.innerHTML = "<input value='"+idAlmoEstoque[x].value+"' name='idAlmoEstoque_[]' id='idAlmoEstoque_[]' type='hidden'/>";
          newCell.value = idAlmoEstoque[x].value;
          newCell = newRow.insertCell(1);   
          newCell.innerHTML = descricaoInsumoP[x].value;
          newCell = newRow.insertCell(2);   
          newCell.innerHTML = quantidadeP[x].value +"<input value='"+quantidadeP[x].value+"' name='qtd_[]' id='qtd_[]' type='hidden'/>";
          newCell.value = quantidadeP[x].value;
          newCell = newRow.insertCell(3);   
          newCell.innerHTML = descricaoLocalP[x].value;
          newCell = newRow.insertCell(4);   
          newCell.innerHTML = descEmpresa+"<input value='"+idEmpresa+"' name='idEmitenteDest_[]' id='idEmitenteDest_[]' type='hidden'/>";
          newCell = newRow.insertCell(5);   
          newCell.innerHTML = nomeSetor+"<input value='"+idSetor+"' name='idSetor_[]' id='idSetor_[]' type='hidden'/>";
          newCell = newRow.insertCell(6);   
          newCell.innerHTML = userNome+"<input value='"+user+"' name='user_[]' id='user_[]' type='hidden'/>";
          newCell = newRow.insertCell(7);   
          newCell.innerHTML = itemOs+"<input value='"+itemOs+"' name='idOs_[]' id='idOs_[]' type='hidden'/>";
          newCell = newRow.insertCell(8);   
          newCell.innerHTML = obs+"<input value='"+obs+"' name='obs_[]' id='obs_[]' type='hidden'/>";
          newCell = newRow.insertCell(9);
          newCell.innerHTML = '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow2(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button>'
        
        }
      }
    }

    $('#cadastrolocal').click(function() {
      var empresa = document.querySelector("#idEmpresaDescLocal").value;
      var departamento = document.querySelector("#idDepartamentoLocal").value;
      var local = document.querySelector("#descLocal").value;
      //console.log(empresa);
      $.ajax({
          url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarLocal",
          type: 'POST',
          dataType: 'json',
          data: {
              empresa: empresa,
              departamento: departamento,
              local: local
          },
          success: function(data) {
            if(data.result == true){
              document.querySelector("#descLocal").value = "";
              alert('Local Cadastrado!');
            }else if(data.result == false){
              alert(data.msggg);
            }        
            
          },
                        
      });
    })

    $('#cadastrouser').click(function() {
      var empresa = document.querySelector("#idEmpresaUser").value;
      var setor = document.querySelector("#idSetorUser").value;
      var nome = document.querySelector("#nomeUser").value;
      var cpf = document.querySelector("#cpfUser").value;
      var select = document.getElementById('idEmpresaUser');
      var empresa2 = select.options[select.selectedIndex].text;
      var select = document.getElementById('idSetorUser');
      var setor2 = select.options[select.selectedIndex].text;
      //console.log(empresa);
      $.ajax({
          url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarUsuario",
          type: 'POST',
          dataType: 'json',
          data: {
              empresa: empresa,
              setor: setor,
              nome: nome,
              cpf: cpf
          },
          success: function(data) {
            if(data.result == true){
              document.querySelector("#nomeUser").value = "";
              document.querySelector("#cpfUser").value = "";
              adicionarUsuarioTabelaUser(data.cod,empresa2,setor2,nome,cpf);
              alert('Usuário Cadastrado!');
            }else if(data.result == false){
              alert(data.msggg);
            }        
            
          },
                        
      });
    })

    $('#cadastroinsumos').click(function() {
      var descricaoInsumos = document.querySelector("#descricaoInsumos").value;
      var idCategoriaSubCat = document.querySelector("#idCategoriaSubCat").value;
      var estoqueMinimo = document.querySelector("#estoqueMinimo").value;
      var pnInsumo = document.querySelector("#pnInsumo").value;
      
      var subcat = idCategoriaSubCat;
      $.ajax({
          url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarInsumos",
          type: 'POST',
          dataType: 'json',
          data: {
              descricao: descricaoInsumos,
              estoquemin: estoqueMinimo,
              pn: pnInsumo,
              subcat: subcat
          },
          success: function(data) {
            if(data.result == true){
              document.querySelector("#descricaoInsumos").value = "";
              document.querySelector("#estoqueMinimo").value = "";
              document.querySelector("#pnInsumo").value = "";
              alert('Insumo Cadastrado!');
            }else if(data.result == false){
              alert(data.msggg);
            }        
            
          },
                        
      });/**/
    })

    $('#cadastrarSubcatECat').click(function() {
      var nomeCategoria = document.querySelector("#nomeCategoria").value;
      var subCategoria = document.querySelector("#subCategoria").value;
      
      $.ajax({
          url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarCatESubcat",
          type: 'POST',
          dataType: 'json',
          data: {
            nomeCategoria: nomeCategoria,
            subCategoria: subCategoria
          },
          success: function(data) {
            console.log("nomeCategoria");

            $('#idCategoriaSubCat').val(data.idSubcategoria);
            $('#categoriaSubcategoria').val(data.descricaoCategoria+" | "+data.descricaoSubcategoria);
            
            if(data.result == true){
              alert('Categoria Cadastrado!');
            }else if(data.result == false){
              alert(data.msggg);
            }       
            
          },          
      });/**/
    })

    $('#cadastrarSubcatt').click(function() {
      var select = document.getElementById('idCategoriaSelect');
      var idCategoria = select.options[select.selectedIndex].value;
      var nomeCategoria = select.options[select.selectedIndex].text;  
      var subCategoria = document.querySelector("#subCategoriaa").value;
      
      $.ajax({
          url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarSubcat",
          type: 'POST',
          dataType: 'json',
          data: {
            nomeCategoria: nomeCategoria,
            subCategoria: subCategoria,
            idCategoria: idCategoria
          },
          success: function(data) {
            console.log("nomeCategoria");

            $('#idCategoriaSubCat').val(data.idSubcategoria);
            $('#categoriaSubcategoria').val(data.descricaoCategoria+" | "+data.descricaoSubcategoria);
            
            if(data.result == true){
              alert('Subcategoria Cadastrado!');
            }else if(data.result == false){
              alert(data.msggg);
            }       
            
          },
                        
      });/**/
    })

    $(document).ready(function(){
		  $("#cpfUser").mask("999.999.999-99");
	  });

    $(document).ready(function(){


      $("#pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompletePN",
        minLength: 1,
        select: function( event, ui ) {
            $('#idProdutos').val(ui.item.id);
            $('#prod').val(ui.item.descricao);
            $('#pn4').val(ui.item.pn);
            $('#qtdEst').val(ui.item.qtdEst);
            $('#idSubcategoriaEntrada').val(ui.item.idSubcat);
            $('#categoriaEntrada').val(ui.item.descricaoCategoria);
            $('#idCategoriaEntrada').val(ui.item.idCategoria);
            $('#subcategoriaEntrada').val(ui.item.descricaoSubcategoria);
            

        }
      });
      
      
    });

    $(document).ready(function(){


      $("#pnprod").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompletePN2",
        minLength: 1,
        select: function( event, ui ) {
            $('#idProdutosProd').val(ui.item.id);
            $('#prodprod').val(ui.item.produtos); 
            $('#prodprod2').val(ui.item.produtos);            
            $('#qtdestprod').val(ui.item.qtdEstt); 
            $('#pnprod2').val(ui.item.pn); 
            $('#refprod2').val(ui.item.referencia);  
            $('#refprod').val(ui.item.referencia);            
        }
      });


    });

    

    $(document).ready(function(){


      $("#refprod").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteREF2",
        minLength: 1,
        select: function( event, ui ) {
            $('#idProdutosProd').val(ui.item.id);
            $('#prodprod').val(ui.item.produtos);
            $('#qtdestprod').val(ui.item.qtdEstt);             
            $('#prodprod2').val(ui.item.produtos); 
            $('#pnprod2').val(ui.item.pn); 
            $('#pnprod').val(ui.item.pn); 
            $('#refprod2').val(ui.item.referencia);  
            $('#refprod').val(ui.item.referencia);            
        }
      });


    });

    $(document).ready(function(){


      $("#prodprod").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd",
        minLength: 1,
        select: function( event, ui ) {
            $('#idProdutosProd').val(ui.item.id);
            $('#pnprod').val(ui.item.pn); 
            $('#qtdestprod').val(ui.item.qtdEstt);
            $('#pnprod2').val(ui.item.pn); 
            $('#prodprod2').val(ui.item.produtos); 
            $('#refprod2').val(ui.item.referencia);  
            $('#refprod').val(ui.item.referencia); 

        }
      });


    });

    $(document).ready(function(){


      $("#pnS").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteInsumosPN/"+getidEmpresaS()+"/"+getidDepartamentoS(),
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueS').val(ui.item.id);
          $('#prodS').val(ui.item.nome);
          $('#pnS4').val(ui.item.pn);
          $('#localS').val(ui.item.local);
          $('#qtdestS').val(ui.item.quantidade);

        }
      });


    });

    $(document).ready(function(){
      

      $("#prod").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteInsumos",
        minLength: 1,
        select: function( event, ui ) {
          $('#idProdutos').val(ui.item.id);
          $('#pn4').val(ui.item.pn);
          $('#pn').val(ui.item.pn);
          $('#idSubcategoriaEntrada').val(ui.item.idSubcat);
          $('#categoriaEntrada').val(ui.item.descricaoCategoria);
          $('#idCategoriaEntrada').val(ui.item.idCategoria);
          $('#subcategoriaEntrada').val(ui.item.descricaoSubcategoria);
          $('#qtdEst').val(ui.item.qtdEst);
        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#prodS").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteEstoqueSaida/"+getidEmpresaS2()+"/"+getidDepartamentoS2(),
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueS').val(ui.item.id);
          $('#pnS4').val(ui.item.pn);
          $('#pnS').val(ui.item.pn);
          $('#localS').val(ui.item.local);
          $('#qtdestS').val(ui.item.quantidade);
          $('#prodS').val(ui.item.nome);		 

        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#prodSProd").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProdEstoque/"+getidEmpresaS2()+"/"+getidDepartamentoS2(),
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueSProd').val(ui.item.id);
          $('#pnSProd').val(ui.item.pn);
          $('#pnSProd2').val(ui.item.pn);
          $('#prodSProd2').val(ui.item.nome);
          $('#qtdestSProd').val(ui.item.quantidade);
          $('#localSProd').val(ui.item.local);
          
          $('#refSProd2').val(ui.item.referencia);  
          $('#refSProd').val(ui.item.referencia);  
          //$('#pnSProd').val(ui.item.pn);
        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#pnSProd").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompletePnEstoque/"+getidEmpresaS2()+"/"+getidDepartamentoS2(),
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueSProd').val(ui.item.id);
          $('#prodSProd').val(ui.item.nome);
          $('#prodSProd2').val(ui.item.nome);
          $('#pnSProd2').val(ui.item.pn);
          $('#qtdestSProd').val(ui.item.quantidade);
          $('#localSProd').val(ui.item.local);          
          $('#refSProd2').val(ui.item.referencia);  
          $('#refSProd').val(ui.item.referencia);  
          //$('#pnSProd').val(ui.item.pn);
        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#refSProd").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteREFEstoque/"+getidEmpresaS2()+"/"+getidDepartamentoS2(),
        minLength: 1,
        select: function( event, ui ) {
          $('#idAlmoEstoqueSProd').val(ui.item.id);
          $('#prodSProd').val(ui.item.nome);
          $('#prodSProd2').val(ui.item.nome);
          $('#pnSProd2').val(ui.item.pn);
          $('#pnSProd').val(ui.item.pn);
          $('#qtdestSProd').val(ui.item.quantidade);
          $('#localSProd').val(ui.item.local);          
          $('#refSProd2').val(ui.item.referencia);  
          //$('#pnSProd').val(ui.item.pn);
        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#prode").autocomplete({
        source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
        minLength: 1,
        select: function( event, ui ) {
          $('#idProdutose').val(ui.item.id);
          

        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#prodL").autocomplete({
        source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
        minLength: 1,
        select: function( event, ui ) {
          $('#idProdutosL').val(ui.item.id);
          

        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#descRel").autocomplete({
        source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
        minLength: 1,
        select: function( event, ui ) {
          $('#idDescRel').val(ui.item.id);
          

        }
      });	  
      
    });
    /*
    $(document).ready(function(){
      
      $("#localp").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteLocais/"+alterarLocal()+"/"+alterarLocal1(),
        minLength: 1,
        select: function( event, ui ) {
          $('#idLocalp').val(ui.item.id);
          

        }
      });	  
      
    });*/
    $(document).ready(function(){
      
      $("#locale").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteLocais/"+alterarLocal(),
        minLength: 1,
        select: function( event, ui ) {
          $('#idLocale').val(ui.item.id);
          

        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#userpS").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteFunc",
        minLength: 1,
        select: function( event, ui ) {
          $('#idUserpS').val(ui.item.id);
          $('#idSetorp').val(ui.item.idSetor);
          $('#nomeSetorp').val(ui.item.nomeSetor);
          $('#userpS2').val(ui.item.nome);
        }
      });
      $("#userS").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteFunc",
        minLength: 1,
        select: function( event, ui ) {
          $('#idUserS').val(ui.item.id);
          $('#idSetor').val(ui.item.idSetor);
          $('#nomeSetor').val(ui.item.nomeSetor);
          $('#userS2').val(ui.item.nome);
        }
      });
      $("#userSProd").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteFunc",
        minLength: 1,
        select: function( event, ui ) {
          $('#idUserSProd').val(ui.item.id);
          $('#idSetorProd').val(ui.item.idSetor);
          $('#nomeSetorProd').val(ui.item.nomeSetor);
          $('#userSProd2').val(ui.item.nome);

        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#categoriaSubcategoria").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteCategoriaSubCategoria",
        minLength: 1,
        select: function( event, ui ) {
          $('#idCategoriaSubCat').val(ui.item.id);
          

        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#user").autocomplete({
        source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteUsuario",
        minLength: 1,
        select: function( event, ui ) {
          $('#idUser').val(ui.item.id);
        }
      });
    });

    $(document).ready(function(){
      
      $("#categoriaEntrada").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteCategoriaSubCategoria",
        minLength: 1,
        select: function( event, ui ) {
          $('#idSubcategoriaEntrada').val(ui.item.id);
          $('#subcategoriaEntrada').val(ui.item.descricaoSubcategoria);
          $('#idCategoriaEntrada').val(ui.item.idCategoria); 

        }
      });	  
      
    });

    $(document).ready(function(){
      
      $("#subcategoriaEntrada").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteSubcategoria",
        minLength: 1,
        select: function( event, ui ) {
          $('#idSubcategoriaEntrada').val(ui.item.id);
          $('#categoriaEntrada').val(ui.item.descricaoCategoria);
          $('#idCategoriaEntrada').val(ui.item.idCategoria); 

        }
      });	  
      
    });

    $(document).ready(function() {
        $("#filtroInsumo").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tbInsumos tr").filter(function() {
                $(this).toggle($(this).text()
                .toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function() {
        $("#filtroLocais").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tbLocais tr").filter(function() {
                $(this).toggle($(this).text()
                .toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function() {
        $("#filtroUser").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tbUser tr").filter(function() {
                $(this).toggle($(this).text()
                .toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function() {
      $(document).on('click', 'a', function(event) {

        var almoEstoqueId = $(this).attr('almoEstoqueId');
        $('#idAlmoEstoqueLocais').val(almoEstoqueId);

      });
      
    });
    
    $(document).ready(function(){
      $("#imprimir").click(function(){         
        PrintElem('#divEstoque');
      })

      $("#imprimir2").click(function(){         
        PrintElem('#divTableSaida');
      })

      $("#imprimir3").click(function(){         
        PrintElem('#divTableInsert');
      })

      function PrintElem(elem)
      {
        Popup($(elem).html());
      }

      function Popup(data){
        var mywindow = window.open('', 'SGI', 'height=600,width=800');
        mywindow.document.write('<html><head><title>SGI</title>');
        /* mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap.min.css' /><link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap-responsive.min.css' />");*/
        mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/tableimprimir.css' />");


        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        //mywindow.location.reload(false);
        //mywindow.close();

        return true;
      }

    });

    $(function () {
      $(".export-csv").on('click', function (event) {
          // CSV
          var filename = $(".export-csv").data("filename")
          var args = [$('#tableInsert'), filename + ".csv", 0];
          exportTableToCSV.apply(this, args);
      });
      $(".export2-csv").on('click', function (event) {
          // CSV
          var filename = $(".export2-csv").data("filename")
          var args = [$('#tableSaida'), filename + ".csv", 0];
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

    $(document).ready(function(){      
      jQuery(".data").mask("99/99/9999");
    });
     
    
    $(document).ready( function () {
        $('#tableLocais').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
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
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });
        
    });

    $(document).ready( function () {
        $('#tableUser').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
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
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });
        
    });

    $(document).ready( function () {
        $('#tableInsumos').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
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
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });
        
    });
</script>