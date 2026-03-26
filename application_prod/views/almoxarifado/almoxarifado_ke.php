<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<style type="text/css">

<?php 
if(isset($relatorio)){
  if($relatorio){ ?>
      .btn-estoque{
      background-color: white;
      color: black
    }
    .btn-entrada{
      background-color: white;
      color: black
    }
    .btn-saida{
      background-color: white;
      color: black
    }
    .btn-relatorio{
      background-color: #49afcd;
      color: white
    }
    .btn-local{
      background-color: white;
      color: black
    }

    .estoque{
      display: none
    }
    .entrada{
      display: none
    }
    .saida{
      display: none
    }
    .relatorio{
      display: block
    }
    .cadastrarLocal{
      display:none
    }
  <?php 
  }else {
  ?>
    .btn-estoque{
      background-color: #faa732;
      color: white
    }
    .btn-entrada{
      background-color: white;
      color: black
    }
    .btn-saida{
      background-color: white;
      color: black
    }
    .btn-relatorio{
      background-color: white;
      color: black
    }
    .btn-local{
      background-color: white;
      color: black
    }
    .estoque{
      display: block
    }
    .entrada{
      display: none
    }
    .saida{
      display: none
    }
    .relatorio{
      display: none
    }
    .cadastrarLocal{
      display:none
    }
  <?php
  }
} else if(isset($local)){?>
  .btn-estoque{
    background-color: white;
    color: black
  }
  .btn-entrada{
    background-color: white;
    color: black
  }
  .btn-saida{
    background-color: white;
    color: black
  }
  .btn-relatorio{
    background-color: white;
    color: black
  }
  .btn-local{
    background-color: #49afcd;
    color: white
  }

  .estoque{
    display: none
  }
  .entrada{
    display: none
  }
  .saida{
    display: none
  }
  .relatorio{
    display: none
  }
  .cadastrarLocal{
    display: block
  }
  <?php
}else{
  ?>
  .btn-estoque{
    background-color: #faa732;
    color: white
  }
  .btn-entrada{
    background-color: white;
    color: black
  }
  .btn-saida{
    background-color: white;
    color: black
  }
  .btn-relatorio{
    background-color: white;
    color: black
  }
  .btn-local{
    background-color: white;
    color: black
  }

  .estoque{
    display: block
  }
  .entrada{
    display: none
  }
  .saida{
    display: none
  }
  .relatorio{
    display: none
  }
  .cadastrarLocal{
    display:none
  }
  <?php
}
?>

.cadastrarUsuario{
  display:none
}

.cadastrarInsumos{
  display:none
}

.btn-usuario{
  background-color: white;
  color: black
}

.btn-insumos{
  background-color: white;
  color: black
}

.tamanho{
  display: none
}
.volume{
  display: none
}
.peso{
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
</style>

<div>
  <a style="margin-right: 1%" role="button"  idDistribuir="" class="btn btn-estoque tip-top" title="Estoque" id="btn_estoque">Estoque</a>

  <a style="margin-right: 1%" role="button"  idDistribuir="" class="btn btn-entrada tip-top" title="Entrada" id="btn_entrada">Entrada</a>

  <a style="margin-right: 1%" role="button" idDistribuir="" class="btn btn-saida tip-top" title="Saída" id="btn_saida"> Saída</a> 
    
  <a style="margin-right: 1%" role="button" idDistribuir="" class="btn btn-relatorio tip-top" title="Relatório" id="btn_relatorio">Relatório</a>

  <a style="margin-right: 1%; float: right" role="button" idDistribuir="" class="btn btn-local tip-top" title="Local" id="btn_local">Cadastrar Local</a>

  <a style="margin-right: 1%; float: right" role="button" idDistribuir="" class="btn btn-usuario tip-top" title="Cadastrar Usuário" id="btn_usuario">Cadastrar Usuário</a>

  <a style="margin-right: 1%; float: right" role="button" idDistribuir="" class="btn btn-insumos tip-top" title="Local" id="btn_insumos">Cadastrar Insumos</a>
</div>

<div class="estoque">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Estoque</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <div class="span12" id="divCadastrarOs">
                  <form class="form-inline" name="formEstoque" id="formEstoque" action="<?php echo base_url();?>index.php/almoxarifado/Busca_Estoque_Filtro" enctype="multipart/form-data" method="post">
                    <div class="span12" style="padding: 1%; margin-left: 0">                      
                      <div class="span3" class="control-group">
                        <label for="cliente" class="control-label">Descrição:</label>
                        <input class="span12" class="form-control" id="prode"  type="text" name="prode" value=""  />
                        <input id="idProdutose"  type="hidden" name="idProdutose" value=""  />
                      </div>
                      <div class="span3" class="control-group">
                        <label for="idMedicaoe" class="control-label"></label>
                        <select class="span12 form-control" name="idMedicaoe" id="idMedicaoe" onchange="verificarE(this.value)">
                          <option value="0"></option>
                          <option value="1">Unidade</option>
                          <option value="2">Unidade/Comprimento</option>
                          <option value="3">Unidade/Volume</option>
                          <option value="4">Unidade/Peso</option>
                        </select>
                      </div>
                      <div class="tamanhoe">
                        <div class="span1" class="control-group" style="margin-left: 35px">
                          <label for="cliente" class="control-label">Comprimento(cm):</label>
                          <input class="span12" class="form-control" id="tamanhoe"  type="text" name="tamanhoe" value=""  />
                          <input id="tamanhoe"  type="hidden" name="tamanhoe" value=""  />
                        </div>
                      </div>   
                      <div class = "volumee">
                        <div class="span1" class="control-group" style="margin-left: 35px">
                          <label for="cliente" class="control-label">Volume(ml):</label>
                          <input class="span12" class="form-control" id="volumee"  type="text" name="volumee" value=""  />
                          <input id="volumee"  type="hidden" name="volumee" value=""  />
                        </div>
                      </div>
                      <div class = "pesoe">
                        <div class="span1" class="control-group" style="margin-left: 35px">
                          <label for="cliente" class="control-label">Peso(g):</label>
                          <input class="span12" class="form-control" id="pesoe"  type="text" name="pesoe" value=""  />
                          <input id="pesoe"  type="hidden" name="pesoe" value=""  />
                        </div>
                      </div>

                      <div class="span3" class="control-group">
                        <label for="idEmpresa" class="control-label">Empresa:</label>
                        <select class="span12 form-control" name="idEmpresae" id="idEmpresae" onchange="alterarLocal2e(this.value)">
                          <option value="0"> </option>
                          <?php foreach($dados_emitente as $r){
                          ?>
                            <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                          <?php
                          }?>
                          
                        </select>
                      </div>
                      <div class="span2" class="control-group">
                        <label for="localp" class="control-label">Local:</label>
                        <input class="span12" class="form-control" id="locale"  type="text" name="locale" value=""  />
                        <input id="idLocale"  type="hidden" name="idLocale" value=""  />
                      </div>
                    </div>
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span12" class="control-group">
                        <br>
                        <input class="btn btn-default" type="submit" name="filter" value="Filtrar">
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
      <h5>Produtos Estoque</h5>
    </div>

    <div class="widget-content nopadding">
      <table class="table table-bordered " id="table_estoque">
        <thead>
          <tr>
          
            <th>Cód.</th>
            <th>Descrição</th>
            <th>Quantidade</th>
            <th>Empresa</th>
            <th>Local</th>         
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(isset($result))
            foreach($result as $r){?>
              <tr>
                  <td>
                    <?php echo $r->idAlmoEstoque;?>
                    <input type='hidden' value='<?php echo $r->idAlmoEstoque;?>' name='idAlmoEstoque_[]'>
                  </td>
                  <td>
                    <?php echo $r->descricaoInsumo;?>
                  </td>
                  <td>
                    <?php echo $r->quantidade;?> Unid.<?php
                    if($r->metrica == 1){
                      ?> | <?php echo $r->comprimento; ?> CM<?php
                    } else if($r->metrica == 2){
                      ?> | <?php echo $r->volume; ?> ML<?php
                    }else if($r->metrica == 3){
                      ?> | <?php echo $r->peso; ?> G<?php
                    }
                      ?>
                  </td>
                  <td>
                    <?php echo $r->nome;?>
                  </td>
                  <td>
                    <?php echo $r->local;?>
                  </td>
                  <td></td>
              </tr>
            <?php 
            }?>
        </tbody>
      </table>
    </div>
  </div>
</div>



<div class="entrada">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Entrada de Produtos</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <div class="span12" id="divCadastrarOs">
                  <form class="form-inline"  >
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span4" class="control-group">
                        <label for="cliente" class="control-label">Descrição:</label>
                        <input class="span12" class="form-control" id="prod"  type="text" name="prod" value=""  />
                        <input id="idProdutos"  type="hidden" name="idProdutos" value=""  />
                      </div>
                      <div class="span3" class="control-group">
                        <label for="idMedicao" class="control-label"></label>
                        <select class="span12 form-control" name="idMedicao" id="idMedicao" onchange="verificar(this.value)">
                          <option value="0">Unidade</option>
                          <option value="1">Unidade/Comprimento</option>
                          <option value="2">Unidade/Volume</option>
                          <option value="3">Unidade/Peso</option>
                        </select>
                      </div>
                      <div class="span1" class="control-group">
                        <label for="cliente" class="control-label">Quantidade:</label>
                        <input class="span12" class="form-control" id="qtd"  type="text" name="qtd" value=""  />
                        <input id="qtd"  type="hidden" name="qtd" value=""  />
                      </div>
                      <div class="tamanho">
                        <div class="span2" class="control-group" style="margin-left: 35px">
                          <label for="cliente" class="control-label">Comprimento(cm):</label>
                          <input class="span12" class="form-control" id="tamanho"  type="text" name="tamanho" value=""  />
                          <input id="tamanho"  type="hidden" name="tamanho" value=""  />
                        </div>
                      </div>   
                      <div class = "volume">
                        <div class="span2" class="control-group" style="margin-left: 35px">
                          <label for="cliente" class="control-label">Volume(ml):</label>
                          <input class="span12" class="form-control" id="volume"  type="text" name="volume" value=""  />
                          <input id="volume"  type="hidden" name="volume" value=""  />
                        </div>
                      </div>
                      <div class = "peso">
                        <div class="span2" class="control-group" style="margin-left: 35px">
                          <label for="cliente" class="control-label">Peso(g):</label>
                          <input class="span12" class="form-control" id="peso"  type="text" name="peso" value=""  />
                          <input id="peso"  type="hidden" name="peso" value=""  />
                        </div>
                      </div>
                      <div class="span2" class="control-group">
                        <label for="cliente" class="control-label">Nota Fiscal:</label>
                        <input class="span12" class="form-control" id="nf"  type="text" name="nf" value=""  />
                        <input id="nf"  type="hidden" name="nf" value=""  />
                      </div> 
                      <div class="span2" class="control-group">
                        <label for="cliente" class="control-label">Valor Unit.:</label>
                        <input class="span12" class="form-control" id="valorUnit"  type="text" name="valorUnit" value="" onKeyPress="FormataValor2(this,event,10,3);" />
                        <input id="nf"  type="hidden" name="nf" value=""  />
                      </div> 
                    </div>

                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span3" class="control-group">
                        <label for="idEmpresa" class="control-label">Empresa:</label>
                        <select class="span12 form-control" name="idEmpresa" id="idEmpresa" onchange="alterarLocal2(this.value)">
                          <?php foreach($dados_emitente as $r){
                          ?>
                            <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                          <?php
                          }?>
                          
                        </select>
                      </div>
                      <div class="span2" class="control-group">
                        <label for="localp" class="control-label">Local:</label>
                        <input class="span12" class="form-control" id="localp"  type="text" name="localp" value=""  />
                        <input id="idLocalp"  type="hidden" name="idLocalp" value=""  />
                      </div>
                      <div class="span2" class="control-group">
                        <label for="idOs" class="control-label">Cod. OS:</label>
                        <input class="span12" class="form-control" id="idOs"  type="text" name="idOs" value=""  />
                      </div>
                    </div>
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span12" class="control-group">
                        <a class="btn" onclick="inserirLinhaTabela()">Adicionar</a>
                        <a class="btn btn-success" onClick="document.getElementById('formEntradas').submit();" >Finalizar</a>
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
      <form action="<?php echo base_url() ?>index.php/almoxarifado/cadastrarEntradas" id="formEntradas" enctype="multipart/form-data" method="post">
        <table class="table table-bordered " id="tableInsert">
          <thead>
            <tr>
            
              <th>Cod.</th>
              <th>Descrição</th>            
              <th></th>
              <th>Tamanho(cm)</th>
              <th>Volume(ml)</th>    
              <th>Peso(gm)</th>
              <th>Quantidade</th>
              <th>Empresa</th>
              <th>Local</th>
              <th>Nota Fiscal</th>
              <th>Valor Unit.</th>
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
              <td><?php echo $r->pn?><input value=<?php echo $r->pn?> name='idProdutoTD_[]' id='idProdutoTD_[]' type='hidden'/></td>
              <td><?php echo $r->prod?></td>              
              <td><?php echo $r->medicao." | ".$r->nomemedicao?><input value=<?php echo $r->medicao?> name='idMedicaoTD_[]' id='idMedicaoTD_[]' type='hidden'/></td>
              <td><?php echo $r->tamanho?><input value=<?php echo $r->tamanho?> name='tamanhoTD_[]' id='tamanhoTD_[]' type='hidden'/></td>
              <td><?php echo $r->volume?><input value=<?php echo $r->volume?> name='volumeTD_[]' id='volumeTD_[]' type='hidden'/></td>
              <td><?php echo $r->peso?><input value=<?php echo $r->peso?> name='pesoTD_[]' id='pesoTD_[]' type='hidden'/></td>
              <td><?php echo $r->qtd?><input value=<?php echo $r->qtd?> name='qtdTD_[]' id='qtdTD_[]' type='hidden'/></td>
              <td><?php echo $r->idEmpresa." | ".$r->nomeEmpresa?><input value=<?php echo $r->idEmpresa?> name='idEmpresaTD_[]' id='idEmpresaTD_[]' type='hidden'/></td>
              <td><?php echo $r->idLocalp." | ".$r->localp?><input value=<?php echo $r->idLocalp?> name='idLocalpTD_[]' id='idEmpresaTD_[]' type='hidden'/></td>
              <td><?php echo $r->nf?><input value=<?php echo $r->nf?> name='nFTD_[]' id='nFTD_[]' type='hidden'/></td>
              <td><?php echo $r->valorUnit?><input value=<?php echo $r->valorUnit?> name='valorUnit_[]' id='valorUnit_[]' type='hidden'/></td>
              <td><?php echo $r->idOs?><input value=<?php echo $r->idOs?> name='idOsTD_[]' id='idOsTD_[]' type='hidden'/></td>
              <td> <button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button></td>
            </tr><?php
            }?>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>



<div class="saida">
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
                  <form class="form-inline"  >
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span3" class="control-group">
                        <label for="idEmpresa" class="control-label">Empresa:</label>
                        <select class="span12 form-control" name="idEmpresaS" id="idEmpresaS" onchange="alterarEstoque(this.value)">
                          <?php foreach($dados_emitente as $r){
                          ?>
                            <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                          <?php
                          }?>
                          
                        </select>
                      </div>
                      <div class="span4" class="control-group">
                        <label for="cliente" class="control-label">Descrição:</label>
                        <input class="span12" class="form-control" id="prodS"  type="text" name="prodS" value=""  />
                        <input id="idAlmoEstoqueS"  type="hidden" name="idAlmoEstoqueS" value=""  />
                      </div>
                      <div class="span2" class="control-group">
                        <label for="cliente" class="control-label">Qtd. estoque:</label>
                        <input class="span12" class="form-control" id="qtdestS"  type="text" name="qtdestS" value="" disabled />
                        <input id="qtdestS"  type="hidden" name="qtdestS" value=""  />
                      </div>
                      <div class="span3" class="control-group">
                        <label for="localp" class="control-label">Local:</label>
                        <input class="span12" class="form-control" id="localS"  type="text" name="localS" value=""  disabled/>
                        <input id="idLocalS"  type="hidden" name="idLocalS" value=""/>
                      </div>
                    </div>

                    <div class="span12" style="padding: 1%; margin-left: 0">                      
                      <div class="span2" class="control-group">
                        <label for="cliente" class="control-label">Quantidade:</label>
                        <input class="span12" class="form-control" id="qtdS"  type="text" name="qtdS" value=""/>
                        <input id="qtdS"  type="hidden" name="qtdS" value=""  />
                      </div>
                      <div class="span3" class="control-group">
                        <label for="idEmpresa" class="control-label">Empresa Destino:</label>
                        <select class="span12 form-control" name="idEmpresaDestS" id="idEmpresaDestS">
                          <?php foreach($dados_emitente as $r){
                          ?>
                            <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                          <?php
                          }?>
                          
                        </select>
                      </div>
                      <div class="span3" class="control-group">
                        <label for="idEmpresa" class="control-label">Setor:</label>
                        <select class="span12 form-control" name="idSetor" id="idSetor" onchange="alterarSetor2(this.value)">
                          <?php foreach($dados_setor as $r){
                          ?>
                            <option value="<?php echo $r->id_setor ?>"><?php echo $r->nomesetor ?> </option>
                          <?php
                          }?>
                          
                        </select>
                      </div>
                      <div class="span2" class="control-group">
                        <label for="cliente" class="control-label">Usuário:</label>
                        <input class="span12" class="form-control" id="userS"  type="text" name="userS" value=""  />
                        <input id="idUserS"  type="hidden" name="idUserS" value=""  />
                      </div>                      
                      <div class="span2" class="control-group">
                        <label for="idOs" class="control-label">Cod. OS:</label>
                        <input class="span12" class="form-control" id="idOsS"  type="text" name="idOsS" value=""  />
                      </div>
                    </div>
                    
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span12" class="control-group">
                        <a class="btn" onclick="inserirLinhaTabelaSaida()">Adicionar</a>
                        <a class="btn btn-success" onClick="document.getElementById('formSaidas').submit();" >Finalizar</a>
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
      <h5>Produtos</h5>
    </div>

    <div class="widget-content nopadding">
      <form action="<?php echo base_url() ?>index.php/almoxarifado/cadastrarSaidas" id="formSaidas" enctype="multipart/form-data" method="post">
        <table class="table table-bordered " id="tableSaida">
          <thead>
            <tr>            
              <th>Cod.</th>
              <th>Descrição</th>
              <th>Quantidade</th>
              <th>Local Estoque</th>
              <th>Empresa Destino</th>
              <th>Setor</th>
              <th>Usuário</th>
              <th>OS</th>      
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr><?php
            if(isset($_COOKIE['tabelaSaida'])){
              $tabelaSaida = json_decode($_COOKIE['tabelaSaida']);
            }              
            if(isset($tabelaSaida)){
              foreach($tabelaSaida as $r){
                ?>
                <td><?php echo $r->idAlmoEstoque ?><input value=<?php echo $r->idAlmoEstoque ?> name='idAlmoEstoque_[]' id='idAlmoEstoque_[]' type='hidden'/></td>
                <td><?php echo $r->nomeProduto ?></td>
                <td><?php echo $r->qtd ?><input value=<?php echo $r->qtd ?> name='qtd_[]' id='qtd_[]' type='hidden'/></td>
                <td><?php echo $r->local ?></td>
                <td><?php echo $r->nomeEmpresaS ?><input value=<?php echo $r->idEmpresaS ?> name='idEmitenteDest_[]' id='idEmitenteDest_[]' type='hidden'/></td>
                <td><?php echo $r->nomeSetor ?><input value=<?php echo $r->idSetor ?> name='idSetor_[]' id='idSetor_[]' type='hidden'/></td>
                <td><?php echo $r->userNome ?><input value=<?php echo $r->user ?> name='user_[]' id='user_[]' type='hidden'/></td>
                <td><?php echo $r->idOs ?><input value=<?php echo $r->idOs ?> name='idOs_[]' id='idOs_[]' type='hidden'/>
                <td><button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow2(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button></td>
                <?php
              }
            }
            ?>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>

<div class="relatorio">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Relatórios</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <div class="span12" id="divCadastrarOs">
                  <form class="form-inline"  action="<?php echo base_url() ?>index.php/almoxarifado/relatorio" enctype="multipart/form-data" method="post" id="formRelat">
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span1" class="control-group">
                        <label for="idEmpresa" class="control-label">Relatório:</label>                        
                        <select class="span12 form-control" name="relatorio" id="relatorio" onchange="alterarRelatorio(this.value)">
                          <option value="Entrada">Entrada</option>
                          <option value="Saida">Saída</option>                                                 
                        </select>
                      </div>
                      <div class="span3" class="control-group">
                        <label for="idEmpresa" class="control-label">Empresa:</label>                        
                        <select class="span12 form-control" name="idEmpresaRel" id="idEmpresaRel" onchange="alterarEstoque(this.value)">
                          <option value=""></option>
                          <?php foreach($dados_emitente as $r){
                          ?>
                            <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                          <?php
                          }?>                          
                        </select>
                      </div>
                      <div class="span4" class="control-group">
                        <label for="cliente" class="control-label">Descrição:</label>
                        <input class="span12" class="form-control" id="descRel"  type="text" name="descRel" value=""  />
                        <input id="idDescRel"  type="hidden" name="idDescRel" value=""  />
                      </div>
                      <div class="span2" class="control-group">
                        <label for="cliente" class="control-label">Usuário Cad.:</label>
                        <input class="span12" class="form-control" id="usuCad"  type="text" name="usuCad" value=""/>
                        <input id="idUsuCad"  type="hidden" name="idUsuCad" value=""  />
                      </div>
                    </div>

                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="saidaRelatorio">
                        <div class="span3" class="control-group">
                          <label for="idEmpresa" class="control-label">Empresa Destino:</label>
                          <select class="span12 form-control" name="idEmpresaDestRel" id="idEmpresaDestRel">
                            <option value=""></option>
                            <?php foreach($dados_emitente as $r){
                              ?>
                              <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                              <?php
                            }?>                            
                          </select>
                        </div>
                        <div class="span3" class="control-group">
                          <label for="idEmpresa" class="control-label">Setor:</label>
                          <select class="span12 form-control" name="idSetorRel" id="idSetorRel" onchange="alterarLocal2(this.value)">
                            <option value=""></option>
                            <?php foreach($dados_setor as $r){
                              ?>
                              <option value="<?php echo $r->id_setor ?>"><?php echo $r->nomesetor ?> </option>
                              <?php
                            }?>
                            
                          </select>
                        </div>
                        <div class="span2" class="control-group">
                          <label for="cliente" class="control-label">Usuário:</label>
                          <input class="span12" class="form-control" id="userSolRel"  type="text" name="userSolRel" value=""  />
                          <input id="idUserSolRel"  type="hidden" name="idUserSolRel" value=""  />
                        </div>
                        <div class="span2" class="control-group">
                          <label for="idOs" class="control-label">Cod. OS:</label>
                          <input class="span12" class="form-control" id="idOsRelSa"  type="text" name="idOsRelSa" value=""  />
                        </div>
                      </div>
                      <div class="entradaRelatorio">
                        <div class="span12" style="margin-left: 0">
                          <div class="span2" class="control-group">
                            <label for="cliente" class="control-label">Nota Fiscal:</label>
                            <input class="span12" class="form-control" id="nfRel"  type="text" name="nfRel" value=""  />
                            <input id="nf"  type="hidden" name="nf" value=""  />
                          </div>
                          <div class="span2" class="control-group">
                            <label for="idOs" class="control-label">Cod. OS:</label>
                            <input class="span12" class="form-control" id="idOsRel"  type="text" name="idOsRel" value=""  />
                          </div>
                        </div>
                      </div>   
                    </div>                    
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span12" class="control-group">                        
                        <a class="btn btn-success" onClick="document.getElementById('formRelat').submit();">Filtrar</a>
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
      <h5>Produtos</h5>
    </div>

    <div class="widget-content nopadding">
      <form>
        <div class="entradaRelatorioTAB">
          <table class="table table-bordered " id="table_rel_entrada">
            <thead>
              <tr>            
                <th>Cod.</th>
                <th>Data Entrada</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Empresa</th>
                <th>Local Estoque</th>
                <th>Usuário</th>
                <th>OS</th>
                <th>NF</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if(isset($dados_entrada)){
                foreach($dados_entrada as $entrada){
                  ?>
                  <tr>
                  <td><?php echo $entrada->idAlmoEstoqueEnt?></td>
                  <?php
                  ?>
                  <td><?php 
                  if(!empty($entrada->data_entrada)){
                    $date = new DateTime( $entrada->data_entrada);
                    echo $date-> format( 'd-m-Y H:i:s' );
                  }?></td>
                  <?php
                  ?>
                  <td><?php echo $entrada->descricaoInsumo?></td>
                  <?php
                  ?>
                  <td><?php if($entrada->metrica==0){
                      echo $entrada->quantidade;
                    }else if($entrada->metrica==1){
                      echo $entrada->quantidade." | ".$entrada->comprimento." cm";
                    }else if($entrada->metrica==2){
                      echo $entrada->quantidade." | ".$entrada->volume." ml";
                    }else if($entrada->metrica==3){
                      echo $entrada->quantidade." | ".$entrada->peso." g";
                    }?></td>
                  <?php
                  ?>
                  <td><?php echo $entrada->nomeEmpresa?></td>
                  <?php
                  ?>
                  <td><?php echo $entrada->local?></td>
                  <?php
                  ?>
                  <td><?php echo $entrada->username?></td>
                  <?php
                  ?>
                  <td><?php echo $entrada->idOs?></td>
                  <?php
                  ?>
                  <td><?php echo $entrada->nf?></td>
                  <td></td>
                  </tr>
                  <?php
                }  
              }?>
              
              
            </tbody>
          </table>
        </div>
        <div class="saidaRelatorioTAB">
          <table class="table table-bordered " id="table_rel_saida">
            <thead>
              <tr>            
                <th>Cod.</th>
                <th>Data Saída</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Empresa</th>
                <th>Empresa Destino</th>
                <th>Setor</th>
                <th>Usuário</th>
                <th>OS</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if(isset($dados_saida)){
                foreach($dados_saida as $saida){
                  ?>
                  <tr>
                  <td><?php echo $saida->idAlmoEstoqueSaida?></td>
                  <?php
                  ?>
                  <td><?php if(!empty($saida->data_saida)){
                    $date = new DateTime( $saida->data_saida);
                    echo $date-> format( 'd-m-Y H:i:s' );
                  } ?></td>
                  <?php
                  ?>
                  <td><?php echo $saida->descricaoInsumo?></td>
                  <?php
                  ?>
                  <td><?php if($saida->metrica==0){
                      echo $saida->quantidade;
                    }else if($saida->metrica==1){
                      echo $saida->quantidade." | ".$saida->comprimento." cm";
                    }else if($saida->metrica==2){
                      echo $saida->quantidade." | ".$saida->volume." ml";
                    }else if($saida->metrica==3){
                      echo $saida->quantidade." | ".$saida->peso." g";
                    }?></td>
                  <?php
                  ?>
                  <td><?php echo $saida->nome." | Local: ".$saida->local?></td>
                  <?php
                  ?>
                  <td><?php echo $saida->destinoNome?></td>
                  <?php
                  ?>
                  <td><?php echo $saida->nomesetor?></td>
                  <?php
                  ?>
                  <td><?php echo $saida->username?></td>
                  <?php
                  ?>
                  <td><?php echo $saida->idOs?></td>
                  <td></td>
                  </tr>
                  <?php
                  
                }  
              }?>
              
              
            </tbody>
          </table>
        </div>
        
      </form>
    </div>
  </div>
</div>

<div class="cadastrarInsumos">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Insumos</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <div class="span12" id="divCadastrarOs">
                  <form class="form-inline" >
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span3" class="control-group">
                        <label for="cliente" class="control-label">Descrição: </label>
                        <input class="span12" class="form-control" id="descricaoInsumos"  type="text" name="descricaoInsumos" value=""  />
                      </div>
                      <div class="span3" class="control-group">
                        <label for="cliente" class="control-label">Categoria e Subcategoria: </label>
                        <input class="span12" class="form-control" id="categoriaSubcategoria"  type="text" name="categoriaSubcategoria" value=""/>
                        <input id="idCategoriaSubCat"  type="hidden" name="idCategoriaSubCat" value=""  />
                      </div>
                      
                      
                      <!--
                      <div class="span3" class="control-group">
                        <label for="idEmpresa" class="control-label">Categoria e Subcategoria</label>
                        <select class="span12 form-control" name="idCategoriaSubCat" id="idCategoriaSubCat">
                          <?php foreach($dados_categoria as $r){
                            ?>
                            <option value="<?php echo $r->idCategoria."-".$r->idSubcategoria ?>"><?php echo $r->descricaoCategoria." | ".$r->descricaoSubcategoria ?> </option>
                            <?php
                          }?>                            
                        </select>
                      </div>-->                     
                      <div class="span3" class="control-group">
                        <label for="cliente" class="control-label">Estoque Mínimo:</label>
                        <input class="span12" class="form-control" id="estoqueMinimo"  type="text" name="estoqueMinimo" value="0"  />
                      </div>
                      <div class="span3" class="control-group">
                        <label for="cliente" class="control-label">PN:</label>
                        <input class="span12" class="form-control" id="pnInsumo"  type="text" name="pnInsumo" value=""  />
                      </div>
                     
                                    
                    </div>
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span12" class="control-group">
                        <br>
                        <a class="btn btn-success" id="cadastroinsumos" name="cadastroinsumos" value="Cadastrar">Cadastrar</a>
                       <!-- <input class="btn btn-default"  id="cadastrolocal" name="cadastrolocal" value="Cadastrar" >-->
                       <a href="#modal-cadastrarSubcategoria" role="button" data-toggle="modal" style="float: right" class="btn btn-success" id="cadastrarSubcategoria" name="cadastrarSubcategoria" value="Cadastrar">Cadastrar Subcategoria</a>
                       <a href="#modal-cadastrarCategoria" role="button" data-toggle="modal" style="float: right; margin-right: 20px;" class="btn btn-success" id="cadastrarCategoria" name="cadastrarCategoria" value="Cadastrar">Cadastrar Categoria</a>
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
      <h5>Insumos Cadastrados</h5>
    </div>
    <div class="widget-title" style="height:73px">
      <div class="span2" class="control-group" style="padding:12px">
        <label for="Filtro" class="control-label" >Filtro:</label>
        <input class="span12" class="form-control" id="filtroInsumo"  type="text" name="filtroInsumo" value=""  />
      </div>
    </div>

    <div class="widget-content nopadding">
      <table class="table table-bordered " id="tableInsumos">
        <thead>
          <tr>          
            <th>Cód.</th>
            <th>Descrição</th>
            <th>Categoria</th>                  
            <th>Subcategoria</th>
            <th>PN</th>
          </tr>
        </thead>
        <tbody id="tbInsumos">
            
        <?php
            if(!empty($dados_insumos)){
              foreach($dados_insumos as $r){
                ?>
                <tr>
                  <td><?php 
                    echo $r->idInsumos;?>
                    <input type='hidden' value='<?php echo $r->idInsumos;?>' name='idInsumos_[]'>
                  </td>
                  <td><?php 
                    echo $r->descricaoInsumo;?>
                  </td>
                  <td><?php 
                    echo $r->descricaoCategoria;?>
                  </td>
                  <td><?php 
                    echo $r->descricaoSubcategoria;?>
                  </td>
                  <td><?php 
                    echo $r->pn_insumo ;?>
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

<div class="cadastrarUsuario">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Usuário</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
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
                        <br>
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

<div class="cadastrarLocal">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Locais</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <div class="span12" id="divCadastrarOs">
                  <form class="form-inline">
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span3" class="control-group">
                        <label for="idEmpresa" class="control-label">Empresa:</label>
                        <select class="span12 form-control" name="idEmpresaDescLocal" id="idEmpresaDescLocal" >                         
                          <?php foreach($dados_emitente as $r){
                          ?>
                            <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                          <?php
                          }?>                          
                        </select>
                      </div>                       
                      <div class="span3" class="control-group">
                        <label for="cliente" class="control-label">Descrição local:</label>
                        <input class="span12" class="form-control" id="descLocal"  type="text" name="descLocal" value=""  />
                      </div>                     
                    </div>
                    <div class="span12" style="padding: 1%; margin-left: 0">
                      <div class="span12" class="control-group">
                        <br>
                        <a class="btn btn-success" id="cadastrolocal" name="cadastrolocal" value="Cadastrar">Cadastrar</a>
                        <!--<input class="btn btn-default"  id="cadastrolocal" name="cadastrolocal" value="Cadastrar" >-->
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
      <h5>Locais Cadastrados</h5>
    </div>
    <div class="widget-title" style="height:73px">
      <div class="span2" class="control-group" style="padding:12px">
        <label for="Filtro" class="control-label" >Filtro:</label>
        <input class="span12" class="form-control" id="filtroLocais"  type="text" name="filtroLocais" value=""  />
      </div>
    </div>
    <div class="widget-content nopadding">
      <table class="table table-bordered " id="tableLocais">
        <thead>
          <tr>          
            <th>Cód.</th>
            <th>Empresa</th>
            <th>Descrição</th>                  
            <th></th>
          </tr>
        </thead>
        <tbody id="tbLocais">
            <?php
            if(!empty($dados_locais)){
              foreach($dados_locais as $r){
                ?>
                <tr>
                  <td><?php 
                    echo $r->idAlmoEstoqueLocais;?>
                    <input type='hidden' value='<?php echo $r->idAlmoEstoqueLocais;?>' name='idAlmoEstoqueLocais_[]'>
                  </td>
                  <td><?php 
                    echo $r->nome ;?>
                  </td>
                  <td><?php 
                    echo $r->local ;?>
                  </td>
                  <td><?php
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'dAlmoxarifado')){
                    ?>
                         <a href="#modal-excluiritempedido" style="margin-right: 1%" role="button" data-toggle="modal"
                            almoEstoqueId="<?php echo $r->idAlmoEstoqueLocais; ?>"
                            class="btn btn-danger tip-top"><i class="icon-remove icon-white"></i></a>
                        <?php
            
                    }?>
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

<script type="text/javascript">

var btn_entrada = document.getElementById('btn_entrada');
var estoque = document.querySelector('.estoque');
var estoquebtt = document.querySelector('.btn-estoque');
var btn_estoque = document.getElementById('btn_estoque');
var entrada = document.querySelector('.entrada');
var entradabtt = document.querySelector('.btn-entrada');
var btn_saida = document.getElementById('btn_saida');
var saida= document.querySelector('.saida');
var saidabtt= document.querySelector('.btn-saida');
var btn_relatorio = document.getElementById('btn_relatorio');
var relatorio= document.querySelector('.relatorio');
var relatoriobtt= document.querySelector('.btn-relatorio');
var cadastrarLocal = document.querySelector('.cadastrarLocal');
var localbtt = document.querySelector('.btn-local');
var btn_local = document.getElementById('btn_local');
var cadastrarUsuario = document.querySelector('.cadastrarUsuario');
var usuariobtt = document.querySelector('.btn-usuario');
var btn_usuario = document.getElementById('btn_usuario');
var cadastrarInsumos = document.querySelector('.cadastrarInsumos');
var insumosbtt = document.querySelector('.btn-insumos');
var btn_insumos = document.getElementById('btn_insumos');

btn_entrada.addEventListener('click', function() {
  estoque.style.display = "none";
  entrada.style.display = "block";
  saida.style.display = "none";
  relatorio.style.display = "none";
  cadastrarLocal.style.display = "none";
  cadastrarUsuario.style.display = "none";
  entradabtt.style.backgroundColor = "#5bb75b";
  entradabtt.style.color = "white";
  estoquebtt.style.backgroundColor = "white";
  estoquebtt.style.color = "black";
  saidabtt.style.backgroundColor = "white";
  saidabtt.style.color = "black";
  relatoriobtt.style.backgroundColor = "white";
  relatoriobtt.style.color = "black";  
  usuariobtt.style.backgroundColor = "white";
  usuariobtt.style.color = "black";
  localbtt.style.backgroundColor = "white";
  localbtt.style.color = "black";
  cadastrarInsumos.style.display = "none";
  insumosbtt.style.backgroundColor = "white";
  insumosbtt.style.color = "black";
});
btn_estoque.addEventListener('click', function() {
  estoque.style.display = "block";
  entrada.style.display = "none";
  saida.style.display = "none";
  relatorio.style.display = "none";
  cadastrarLocal.style.display = "none";
  cadastrarUsuario.style.display = "none";
  entradabtt.style.backgroundColor = "white";
  entradabtt.style.color = "black";
  estoquebtt.style.backgroundColor = "#faa732";
  estoquebtt.style.color = "white";
  saidabtt.style.backgroundColor = "white";
  saidabtt.style.color = "black";
  relatoriobtt.style.backgroundColor = "white";
  relatoriobtt.style.color = "black";
  usuariobtt.style.backgroundColor = "white";
  usuariobtt.style.color = "black";
  localbtt.style.backgroundColor = "white";
  localbtt.style.color = "black";  
  cadastrarInsumos.style.display = "none";
  insumosbtt.style.backgroundColor = "white";
  insumosbtt.style.color = "black";
});
btn_saida.addEventListener('click', function() {
  estoque.style.display = "none";
  entrada.style.display = "none";
  saida.style.display = "block";
  relatorio.style.display = "none";
  cadastrarLocal.style.display = "none";
  cadastrarUsuario.style.display = "none";
  entradabtt.style.backgroundColor = "white";
  entradabtt.style.color = "black";
  estoquebtt.style.backgroundColor = "white";
  estoquebtt.style.color = "black";
  saidabtt.style.backgroundColor = "#da4f49";
  saidabtt.style.color = "white";
  relatoriobtt.style.backgroundColor = "white";
  relatoriobtt.style.color = "black";  
  usuariobtt.style.backgroundColor = "white";
  usuariobtt.style.color = "black";
  localbtt.style.backgroundColor = "white";
  localbtt.style.color = "black";
  cadastrarInsumos.style.display = "none";
  insumosbtt.style.backgroundColor = "white";
  insumosbtt.style.color = "black";
});
btn_relatorio.addEventListener('click', function() {
  estoque.style.display = "none";
  entrada.style.display = "none";
  saida.style.display = "none";
  relatorio.style.display = "block";
  cadastrarLocal.style.display = "none";
  cadastrarUsuario.style.display = "none";
  entradabtt.style.backgroundColor = "white";
  entradabtt.style.color = "black";
  estoquebtt.style.backgroundColor = "white";
  estoquebtt.style.color = "black";
  saidabtt.style.backgroundColor = "white";
  saidabtt.style.color = "black";
  relatoriobtt.style.backgroundColor = "#49afcd";
  relatoriobtt.style.color = "white";
  usuariobtt.style.backgroundColor = "white";
  usuariobtt.style.color = "black";
  localbtt.style.backgroundColor = "white";
  localbtt.style.color = "black";
  cadastrarInsumos.style.display = "none";
  insumosbtt.style.backgroundColor = "white";
  insumosbtt.style.color = "black";
});
btn_usuario.addEventListener('click', function() {
  estoque.style.display = "none";
  entrada.style.display = "none";
  saida.style.display = "none";
  relatorio.style.display = "none";
  cadastrarLocal.style.display = "none";
  cadastrarUsuario.style.display = "block";
  entradabtt.style.backgroundColor = "white";
  entradabtt.style.color = "black";
  estoquebtt.style.backgroundColor = "white";
  estoquebtt.style.color = "black";
  saidabtt.style.backgroundColor = "white";
  saidabtt.style.color = "black";
  relatoriobtt.style.backgroundColor = "white";
  relatoriobtt.style.color = "black";
  localbtt.style.backgroundColor = "white";
  localbtt.style.color = "black";
  usuariobtt.style.backgroundColor = "#49afcd";
  usuariobtt.style.color = "white";
  cadastrarInsumos.style.display = "none";
  insumosbtt.style.backgroundColor = "white";
  insumosbtt.style.color = "black";
});
btn_local.addEventListener('click', function() {
  estoque.style.display = "none";
  entrada.style.display = "none";
  saida.style.display = "none";
  relatorio.style.display = "none";
  cadastrarLocal.style.display = "block";
  cadastrarUsuario.style.display = "none";
  entradabtt.style.backgroundColor = "white";
  entradabtt.style.color = "black";
  estoquebtt.style.backgroundColor = "white";
  estoquebtt.style.color = "black";
  saidabtt.style.backgroundColor = "white";
  saidabtt.style.color = "black";
  relatoriobtt.style.backgroundColor = "white";
  relatoriobtt.style.color = "black";
  usuariobtt.style.backgroundColor = "white";
  usuariobtt.style.color = "black";
  localbtt.style.backgroundColor = "#49afcd";
  localbtt.style.color = "white";
  cadastrarInsumos.style.display = "none";
  insumosbtt.style.backgroundColor = "white";
  insumosbtt.style.color = "black";
});
btn_insumos.addEventListener('click', function() {
  estoque.style.display = "none";
  entrada.style.display = "none";
  saida.style.display = "none";
  relatorio.style.display = "none";
  cadastrarLocal.style.display = "none";
  cadastrarUsuario.style.display = "none";
  entradabtt.style.backgroundColor = "white";
  entradabtt.style.color = "black";
  estoquebtt.style.backgroundColor = "white";
  estoquebtt.style.color = "black";
  saidabtt.style.backgroundColor = "white";
  saidabtt.style.color = "black";
  relatoriobtt.style.backgroundColor = "white";
  relatoriobtt.style.color = "black";
  usuariobtt.style.backgroundColor = "white";
  usuariobtt.style.color = "black";
  localbtt.style.backgroundColor = "white";
  localbtt.style.color = "black";
  cadastrarInsumos.style.display = "block";
  insumosbtt.style.backgroundColor = "#49afcd";
  insumosbtt.style.color = "white";
});


var descricao = document.getElementById('prod');

descricao.onkeydown = function() {
    var key = event.keyCode || event.charCode;

    if( key == 8 || key == 46 ){      
      document.querySelector("#idProdutos").value = "";
    }
};
descricao.onkeyup = function() {     
    document.querySelector("#idProdutos").value = "";    
};




var locaisp = document.getElementById('localp');

locaisp.onkeydown = function() {
    var key = event.keyCode || event.charCode;

    if( key == 8 || key == 46 ){      
      document.querySelector("#idLocalp").value = "";
    }
};
locaisp.onkeyup = function() {
          
  document.querySelector("#idLocalp").value = "";
    
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
          
  document.querySelector("#localS").value = "";
  document.querySelector("#qtdestS").value = "";
  document.querySelector("#idAlmoEstoqueS").value = "";
    
};

var userSS = document.getElementById('userS');

userSS.onkeydown = function() {
    var key = event.keyCode || event.charCode;

    if( key == 8 || key == 46 ){      
      document.querySelector("#idUserS").value = "";
    }
};
userSS.onkeyup = function() {
  document.querySelector("#idUserS").value = "";
    
};

function inserirLinhaTabelaSaida(){
  var table = document.getElementById("tableSaida");

  var idAlmoEstoque = document.querySelector("#idAlmoEstoqueS").value;  
  var nomeProduto = document.querySelector("#prodS").value;

  var empresap = document.getElementById('idEmpresaS');
	var idEmpresa = empresap.options[empresap.selectedIndex].value;
  var nomeEmpresa = empresap.options[empresap.selectedIndex].text;
  var empresaS = document.getElementById('idEmpresaDestS');
	var idEmpresaS = empresaS.options[empresaS.selectedIndex].value;
  var nomeEmpresaS = empresaS.options[empresaS.selectedIndex].text;
  var idOs = document.querySelector("#idOsS").value;
  var setor = document.getElementById('idSetor');
	var idSetor = setor.options[setor.selectedIndex].value;
  var nomeSetor = setor.options[setor.selectedIndex].text;
  var local =  document.querySelector("#localS").value; 
  var qtd = document.querySelector("#qtdS").value;
  var qtdEst = document.querySelector("#qtdestS").value;
  var user = document.querySelector("#idUserS").value;
  var userNome = document.querySelector("#userS").value;
  
  
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
    if(!verificarItensSaida(idAlmoEstoque,qtd,qtdEst)){
      return alert("A quantidade informada é maior que a quantidade em estoque.");
    }
    arrayTabelaSaida = {
      "idAlmoEstoque":idAlmoEstoque,
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
      "userNome":userNome
    };
    // Captura a quantidade de colunas da última linha da tabela
    var numOfCols = table.rows[numOfRows-1].cells.length;
    // Insere uma linha no fim da tabela.
    var newRow = table.insertRow(numOfRows);
    newCell = newRow.insertCell(0);   
    newCell.innerHTML = idAlmoEstoque+"<input value='"+idAlmoEstoque+"' name='idAlmoEstoque_[]' id='idAlmoEstoque_[]' type='hidden'/>";
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
    newCell.innerHTML = '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow2(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button>'
    
    
    document.querySelector("#qtdS").value = "";
    document.querySelector("#qtdestS").value = "";
    document.querySelector("#localS").value = "";
    document.querySelector("#prodS").value = "";
    document.querySelector("#idAlmoEstoqueS").value = "";
    if(getCookie('tabelaSaida') == ""){
      var arrayList = [];
      arrayList.push(arrayTabelaSaida);    
    }else{
      var arrayList = JSON.parse(getCookie('tabelaSaida'));
      arrayList.push(arrayTabelaSaida);
    }
    document.cookie = 'tabelaSaida ='+JSON.stringify(arrayList)+";path=/";;
  } else {
    return alert("Os campos descrição, quantidade, empresa, local, empresa destino, setor e usuário são obrigatórios.");
  }
  
}

function inserirLinhaTabela() {

  var table = document.getElementById("tableInsert");
  // Captura a quantidade de linhas já existentes na tabela
  
  var pn = document.querySelector("#idProdutos").value;
  
  var prod = document.querySelector("#prod").value;
  var select = document.getElementById('idMedicao');
	var medicao = select.options[select.selectedIndex].value;
  var nomemedicao = select.options[select.selectedIndex].text;

  var empresap = document.getElementById('idEmpresa');
	var idEmpresa = empresap.options[empresap.selectedIndex].value;
  var nomeEmpresa = empresap.options[empresap.selectedIndex].text;
  var localp = document.querySelector("#localp").value;
  var idLocalp = document.querySelector("#idLocalp").value;
  var idOs = document.querySelector("#idOs").value;
 
  var tamanho = document.querySelector("#tamanho").value;
  var volume = document.querySelector("#volume").value;
  var peso = document.querySelector("#peso").value;
  var nf = document.querySelector("#nf").value;
  var qtd = document.querySelector("#qtd").value;
  var valorUnit = document.querySelector("#valorUnit").value;
  var arrayTabelaEntrada= {}
  
  if(typeof pn != "UNDEFINED" && pn != null && pn != "" && typeof prod != "UNDEFINED" && prod != null && prod != "" && typeof idMedicao != "UNDEFINED" && idMedicao != null && idMedicao != ""  && typeof qtd != "UNDEFINED" && qtd != null && typeof idLocalp != "UNDEFINED" && idLocalp != null && idLocalp != "" && typeof valorUnit != "UNDEFINED" && valorUnit != null && valorUnit != "")
  {
    if(medicao == 1 && (tamanho == null || tamanho == "" || typeof tamanho == "undefined")){
      return alert("Digite o comprimento da unidade em centímetros para poder adicionar.");
    }

    if(medicao == 2 && (volume == null || volume == "" || typeof volume == "undefined")){
      return alert("Digite o volume da unidade em mililitros para poder adicionar.");
    }
    if(medicao == 3 && (peso == null || peso == "" || typeof peso == "undefined")){
      return alert("Digite o peso da unidade em gramas para poder adicionar.");
    }
    arrayTabelaEntrada = {
      "pn":pn,
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
      "nf":nf,
      "qtd":qtd,
      "valorUnit":valorUnit
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
    newCell.innerHTML = pn+"<input value='"+pn+"' name='idProdutoTD_[]' id='idProdutoTD_[]' type='hidden'/>";
    
   

    newCell = newRow.insertCell(1);     
    newCell.innerHTML = prod;
    newCell.value = prod

    newCell = newRow.insertCell(2);     
    newCell.innerHTML = medicao+"| "+nomemedicao+"<input value='"+medicao+"' name='idMedicaoTD_[]' id='idMedicaoTD_[]' type='hidden'/>";  
  

    newCell = newRow.insertCell(3);     
    newCell.innerHTML = tamanho+"<input value='"+tamanho+"' name='tamanhoTD_[]' id='tamanhoTD_[]' type='hidden'/>";
    

    newCell = newRow.insertCell(4);     
    newCell.innerHTML = volume+"<input value='"+volume+"' name='volumeTD_[]' id='volumeTD_[]' type='hidden'/>";
    

    newCell = newRow.insertCell(5);     
    newCell.innerHTML = peso+"<input value='"+peso+"' name='pesoTD_[]' id='pesoTD_[]' type='hidden'/>";

    newCell = newRow.insertCell(6);     
    newCell.innerHTML = qtd+"<input value='"+qtd+"' name='qtdTD_[]' id='qtdTD_[]' type='hidden'/>";
   
    newCell = newRow.insertCell(7);     
    newCell.innerHTML = idEmpresa+"| "+nomeEmpresa+"<input value='"+idEmpresa+"' name='idEmpresaTD_[]' id='idEmpresaTD_[]' type='hidden'/>";
    

    newCell = newRow.insertCell(8);     
    newCell.innerHTML = idLocalp+"| "+localp+"<input value='"+idLocalp+"' name='idLocalpTD_[]' id='idLocalpTD_[]' type='hidden'/>";
   
    

    newCell = newRow.insertCell(9);     
    newCell.innerHTML = nf+"<input value='"+nf+"' name='nFTD_[]' id='nFTD_[]' type='hidden'/>";  

    newCell = newRow.insertCell(10);     
    newCell.innerHTML = valorUnit+"<input value='"+valorUnit+"' name='valorUnit_[]' id='valorUnit_[]' type='hidden'/>";  
    

    newCell = newRow.insertCell(11);     
    newCell.innerHTML = idOs+"<input value='"+idOs+"' name='idOsTD_[]' id='idOsTD_[]' type='hidden'/>"; 
    
    newCell = newRow.insertCell(12);
    newCell.innerHTML = '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button>'
    
    document.querySelector("#idProdutos").value = "";
    document.querySelector("#prod").value = "";
    
    document.querySelector("#tamanho").value = "";
    document.querySelector("#volume").value = "";
    document.querySelector("#nf").value = "";
    document.querySelector("#qtd").value = "";
    //document.querySelector("#pn").value = "";
    
    if(getCookie('tabelaEntrada') == ""){
      var arrayList = [];
      arrayList.push(arrayTabelaEntrada);    
    }else{
      var arrayList = JSON.parse(getCookie('tabelaEntrada'));
      arrayList.push(arrayTabelaEntrada);
    }
    document.cookie = 'tabelaEntrada ='+JSON.stringify(arrayList)+";path=/";
  } else{
    alertaAdicionar();
  }
}

function getCookie(cname) {
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

function alertaAdicionar()
{
  alert("Os campos Descrição, Quantidade, Local e Valor Unit. não podem ser vazios.");
}


function verificar(value){
	
  var tamanho = document.querySelector('.tamanho');
  var volume = document.querySelector('.volume');
  var peso = document.querySelector('.peso');
  document.querySelector("#tamanho").value = "";
  document.querySelector("#volume").value = "";
  document.querySelector("#peso").value = "";

  if(value == 0){
    tamanho.style.display = "none";
    volume.style.display = "none";
    peso.style.display = "none";
  }else if(value == 1){
    tamanho.style.display = "block";
    volume.style.display = "none";
    peso.style.display = "none";
  }else if(value == 2){
    tamanho.style.display = "none";
    volume.style.display = "block";
    peso.style.display = "none";
  }else if(value == 3){
    tamanho.style.display = "none";
    volume.style.display = "none";
    peso.style.display = "block";
  }

 
};
function verificarE(value){
	
  var tamanho = document.querySelector('.tamanhoe');
  var volume = document.querySelector('.volumee');
  var peso = document.querySelector('.pesoe');
  document.querySelector("#tamanhoe").value = "";
  document.querySelector("#volumee").value = "";
  document.querySelector("#pesoe").value = "";

  if(value == 1 || value == 0){
    tamanho.style.display = "none";
    volume.style.display = "none";
    peso.style.display = "none";
  }else if(value == 2){
    tamanho.style.display = "block";
    volume.style.display = "none";
    peso.style.display = "none";
  }else if(value == 3){
    tamanho.style.display = "none";
    volume.style.display = "block";
    peso.style.display = "none";
  }else if(value == 4){
    tamanho.style.display = "none";
    volume.style.display = "none";
    peso.style.display = "block";
  }
};

function alterarLocal(){
	var selectdois = document.getElementById('idEmpresa');
	var empresadois = selectdois.options[selectdois.selectedIndex].value;
  
  return empresadois;
};

function alterarSetor(){
	var selectdois = document.getElementById('idSetor');
	var setor = selectdois.options[selectdois.selectedIndex].value;
  
  return setor;
};

function alterarLocal2(value){
	$("#localp").autocomplete({
    source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteLocais/"+value,
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
		}
	});
  document.querySelector("#userS").value = "";
  document.querySelector("#idUserS").value = "";
};

function alterarEstoque(value){
	$("#prodS").autocomplete({
    source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteEstoqueSaida/"+value,
		minLength: 1,
		select: function( event, ui ) {
			 $('#idAlmoEstoqueS').val(ui.item.id);
       $('#localS').val(ui.item.local);
       $('#qtdestS').val(ui.item.quantidade);
       $('#prodS').val(ui.item.nome);
			 

		}
	});
  document.querySelector("#prodS").value = "";
  document.querySelector("#idAlmoEstoqueS").value = "";
  document.querySelector("#localS").value = "";
  document.querySelector("#qtdestS").value = "";
};

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
}

function deleteRow2(i){
    document.getElementById('tableSaida').deleteRow(i)
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

$('#cadastrolocal').click(function() {
  var empresa = document.querySelector("#idEmpresaDescLocal").value;
  var local = document.querySelector("#descLocal").value;
  //console.log(empresa);
  $.ajax({
      url: "<?php echo base_url(); ?>index.php/almoxarifado/cadastrarLocal",
      type: 'POST',
      dataType: 'json',
      data: {
          empresa: empresa,
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


  $("#pn").autocomplete({
    source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
    minLength: 1,
    select: function( event, ui ) {
        $('#idProdutos').val(ui.item.id);
        $('#prod').val(ui.item.descricao);
        

    }
  });
  
   
});
$(document).ready(function(){
	

	$("#prod").autocomplete({
    source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutos').val(ui.item.id);

		}
	});	  
   
});

$(document).ready(function(){
	
	$("#prodS").autocomplete({
    source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteEstoqueSaida/1",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idAlmoEstoqueS').val(ui.item.id);
       $('#localS').val(ui.item.local);
       $('#qtdestS').val(ui.item.quantidade);
       $('#prodS').val(ui.item.nome);		 

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
$(document).ready(function(){
	
	$("#localp").autocomplete({
    source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteLocais/"+alterarLocal(),
		minLength: 1,
		select: function( event, ui ) {
			 $('#idLocalp').val(ui.item.id);
			 

		}
	});	  
   
});
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
	
	$("#userS").autocomplete({
    source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteFunc/"+alterarSetor(),
		minLength: 1,
		select: function( event, ui ) {
			 $('#idUserS').val(ui.item.id);
			 

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
$(document).ready( function () {
    $('#table_estoque').DataTable({
        'columnDefs': [ { // column index (start from 0)
        'orderable': false, // set orderable false for selected columns
        }],
        "paging": true,//Dont want paging                
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
    
} );
$(document).ready( function () {
    $('#table_rel_entrada').DataTable({
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
    
} );
$(document).ready( function () {
    $('#table_rel_saida').DataTable({
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
    
} );
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
    
} );
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
    
} );
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
    
} );
</script>
