<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/moment.js"></script><!--
<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />
<!---->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
<link href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css" rel="stylesheet">


<div class="btn-group">
    <a class="btn dropdown-toggle" data-toggle="dropdown" role="button">
        Relatórios
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li><a tabindex="-1" 'href="#estoqueAtual" role="button"  onclick="showDivEstoqueAtual()">Estoque Atual</a></li>
        <li><a tabindex="-1" 'href="#estoqueGeral" role="button"  onclick="showDivEstoqueGeral()">Estoque Geral</a></li>
        <li><a tabindex="-1" 'href="#relatorio" role="button" onclick="showDivRelatorio()">Entradas</a></li>
        <li><a tabindex="-1" 'href="#relatorio" role="button" onclick="showDivRelatorio2()">Saídas</a></li><!--
        <li class="divider"></li>
        <li><a tabindex="-1" 'href="#" role="button" onclick="showDivRelatorioDetalhado()">Relatório Detalhado</a></li>-->
        <!--
        <li><a tabindex="-1" href="#"></a></li>
        <li class="divider"></li>
        <li><a tabindex="-1" href="#">Separated link</a></li>-->
    </ul>
</div>

<div id="estoqueAtual" style="display:block">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Estoque Atual</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            
                <div class="span12" id="divCadastrarOs">
                  <form >
                    <div class="span12" style="padding: 1%; margin-left: 0">  
                      <div class="span2" class="control-group">
                        <label for="cliente" class="control-label">O.S.:</label>
                        <input class="span12" class="form-control" id="idOse"  type="text" name="idOse" value=""  />
                      </div>   
                      <div class="span2" class="control-group">
                        <label for="cliente" class="control-label">PN:</label>
                        <input class="span12" class="form-control" id="pne"  type="text" name="pne" value=""  />
                      </div>                   
                      <div class="span2" class="control-group">
                        <label for="cliente" class="control-label">Descrição:</label>
                        <input class="span12" class="form-control" id="prode"  type="text" name="prode" value=""  />
                        <input id="idProdutose"  type="hidden" name="idProdutose" value=""  />
                      </div><!--
                      <div class="span1" class="control-group">
                        <label for="idMedicaoe" class="control-label">Unidade:</label>
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
                      </div>-->

                      <div class="span2" class="control-group">
                        <label for="idEmpresa" class="control-label">Empresa:</label>
                        <select class="span12 form-control" name="idEmpresae" id="idEmpresae" 'onchange="alterarLocal2e(this.value)">
                          <option value="0">Todos </option>
                          <?php foreach($dados_emitente as $r){
                          ?>
                            <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                          <?php
                          }?>
                          
                        </select>
                      </div>
                      <div class="span2" class="control-group">
                        <label for="idEmpresa" class="control-label">Departamento:</label>
                        <select class="span12 form-control" name="idDepartamentoe" id="idDepartamentoe">
                          <option value="0">Todos </option>
                          <?php foreach($dados_departamento as $r){
                          ?>
                            <option value="<?php echo $r->idAlmoEstoqueDep ?>"><?php echo $r->descricaoDepartamento ?> </option>
                          <?php
                          }?>
                          
                        </select>
                      </div>
                      <div class="span2" class="control-group" >
                        <label for="idEmpresa" class="control-label">Local:</label>
                        <input class="span12" type="text" name="localatual" id="localatual">
                      </div>
                      <div class="span2" class="control-group" style="margin-left:0px">
                        <label for="idEmpresa" class="control-label">Unid. Exec.:</label>
                        <?php foreach ($unid_exec as $exec) { ?>
                            <input type="checkbox" name="unid_execucaoe" id="unid_execucaoe" class='check' value="<?php echo $exec->id_unid_exec; ?>"> &nbsp;<?php echo $exec->status_execucao; ?>

                        <?php } ?>
                      </div>
                      <div class="span1" class="control-group">
                        <br>
                        <a class="btn btn-default" role="button" name="filter" onclick="filterEstoqueAtual()">Filtrar</a>
                      </div>
                      <!--

                      <div class="span2" class="control-group">
                        <label for="localp" class="control-label">Local:</label>
                        <input class="span12" class="form-control" id="locale"  type="text" name="locale" value=""  />
                        <input id="idLocale"  type="hidden" name="idLocale" value=""  />
                      </div>-->
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

  <div class="widget-box">
    <div class="widget-title">
      <span class="icon">
          <i class="icon-user"></i>
        </span>
      <h5>Produtos Estoque</h5>
    </div>
    <div class="buttons">                    
      <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
      <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="EstoqueAtual">Excel</a>
    </div>
    <div class="widget-content nopadding" id="divEstoque">
      <table class="table table-bordered " id="table_estoque" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	      font-size:10px;" border="1">
        <thead>
          <tr>
          
            <th>PN.</th>
            <th>Descrição</th>
            <th>Status</th>
            <th>Quantidade</th>
            <th>O.S.</th>
            <th>Empresa</th>
            <th>Departamento</th>
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
                    <?php echo $r->pn_insumo;?>
                    
                  </td>
                  <td>
                    <?php echo $r->descricaoInsumo;?><input type='hidden' value='<?php echo $r->idAlmoEstoque;?>' name='idAlmoEstoque_[]'>
                  </td>
                  <td>
                    <?php echo $r->descricaoStatusProduto;?>
                  </td>
                  <td>
                    <?php echo $r->quantidade;?> Unid.<?php
                    if($r->metrica == 1){
                      ?> | <?php echo $r->comprimento; ?> CM<?php
                    }else if($r->metrica == 2){
                      ?> | <?php echo $r->volume; ?> ML<?php
                    }else if($r->metrica == 3){
                      ?> | <?php echo $r->peso; ?> G<?php
                    }else if($r->metrica == 4){
                      ?> | <?php echo $r->dimensoesL.'mm X '.$r->dimensoesC.'mm X '.$r->dimensoesA.'mm'; ?> <?php
                    }
                      ?>
                  </td>
                  <td>
                    <?php echo (!empty($r->idOs)?$r->idOs:"");?>
                  </td>
                  <td>
                    <?php echo $r->nome;?>
                  </td>
                  <td>
                    <?php echo $r->descricaoDepartamento;?>
                  </td>
                  <td>
                    <?php echo $r->local;?>
                  </td>
                    <?php 
                    $contt = 0;
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eAlmoxarifado')){
                    foreach($dados_emitente2 as $emit){ 
                      foreach($dados_departamento2 as $depart){
                        if($emit->id == $r->id && $depart->idAlmoEstoqueDep == $r->idDepartamento){
                          $contt =1;?>
                    <td> <a href="#modal-editarprodutoestoque" style="margin-right: 1%" role="button" 
                    data-toggle="modal" departamentoAlterar="<?php echo $r->idDepartamento ?>" almoxarifadoAlterar="<?php echo $r->tabela ?>" insumoAlterar = "<?php echo $r->descricaoInsumo; ?>" idAlmoEstoqueAlterar = "<?php echo $r->idAlmoEstoque; ?>" localAlterar = "<?php echo $r->local; ?>"
                    quantidadeAlterar = "<?php echo $r->quantidade; ?>" 
                    class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a></td>
                 <?php }
                      }
                    }
                  }
                    if($contt == 0){
                      echo "<td></td>";
                    }
                    ?>
                  
              </tr>
            <?php 
            }
            ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div id="estoqueGeral" style="display:none">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Estoque Geral</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            
            <div class="span12" id="divCadastrarOs">
              <form class="form-inline" name="formEstoque" id="formEstoque" action="<?php echo base_url();?>index.php/almoxarifado/Busca_Estoque_Filtro" enctype="multipart/form-data" method="post">
                <div class="span12" style="padding: 1%; margin-left: 0">
                  <div class="span2" class="control-group">
                    <label for="cliente" class="control-label">PN:</label>
                    <input class="span12" class="form-control" id="png"  type="text" name="png" value=""  />
                  </div>                      
                  <div class="span2" class="control-group">
                    <label for="cliente" class="control-label">Descrição:</label>
                    <input class="span12" class="form-control" id="prodg"  type="text" name="prodg" value=""  />
                    <input id="idProdutosg"  type="hidden" name="idProdutosg" value=""  />
                  </div>

                  <div class="span2" class="control-group">
                    <label for="idEmpresa" class="control-label">Empresa:</label>
                    <select class="span12 form-control" name="idEmpresag" id="idEmpresag">
                      <option value="0">Todos </option>
                      <?php foreach($dados_emitente as $r){
                      ?>
                        <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                      <?php
                      }?>
                      
                    </select>
                  </div>
                  <div class="span2" class="control-group">
                    <label for="idEmpresa" class="control-label">Departamento:</label>
                    <select class="span12 form-control" name="idDepartamentog" id="idDepartamentog">
                      <option value="0">Todos </option>
                      <?php foreach($dados_departamento as $r){
                      ?>
                        <option value="<?php echo $r->idAlmoEstoqueDep ?>"><?php echo $r->descricaoDepartamento ?> </option>
                      <?php
                      }?>
                      
                    </select>
                  </div>
                  <div class="span1" class="control-group">
                    <br>
                    <a class="btn btn-default" role="button" name="filter" value="Filtrar" onclick="filterEstoqueGeral()">Filtrar</a>
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
      <h5>Produtos Estoque</h5>
    </div>
    <div class="buttons">
                    
      <a id="imprimir4" title="Imprimir4" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
      <a href=javascript:; class="export2-csv btn btn-mini btn-inverse" data-filename="EstoqueGeral">Excel</a>
    </div>
    <div class="widget-content nopadding" id="divEstoqueGeral">
      <table class="table table-bordered " id="table_estoqueGeral" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	      font-size:10px;" border="1">
        <thead>
          <tr>
            <th>PN</th>
            <th>Descrição</th>
            <th>Valor Unit. Médio</th>
            <th>Valor Total Entrada</th>
            <th>Valor Total Saída</th>
            <th>Valor Total Estoque</th>
            <th>Quantidade Entrada</th>
            <th>Quantidade Saída</th>
            <th>Quantidade Atual</th>
            <th>Empresa</th>
            <th>Departamento</th>       
          </tr>
        </thead>
        <tbody>
        <?php 
          if(isset($dadosRelatorio2)){
            $totalEntrada = 0;
            $totalSaida = 0;
            $total = 0;
            foreach($dadosRelatorio2 as $r){?>
              <tr>
                <td><?php echo $r->pn_insumo?></td>
                <td><?php echo $r->descricaoInsumo?></td>
                <td>R$ <?php echo str_replace(".",",",round($r->valor_unit_medio,3))?></td>
                <td>R$ <?php echo str_replace(".",",",round($r->valor_total_entrada,3))?></td>
                <td>R$ <?php echo str_replace(".",",",round($r->valor_total_saida,3))?></td>
                <td>R$ <?php echo str_replace(".",",",round($r->valor_total,3))?></td>
                <td><?php echo $r->quantidade_entrada?></td>
                <td><?php echo $r->quantidade_saida?></td>
                <td><?php echo $r->quantidade_total?></td>
                <td><?php echo $r->nome?></td>
                <td><?php echo $r->descricaoDepartamento?></td>
              </tr>
        
            <?php
            $totalEntrada = $totalEntrada+$r->valor_total_entrada;
            $totalSaida = $totalSaida+$r->valor_total_saida;
            $total = $total+$r->valor_total;
            }
          }?>
        </tbody>
        <tbody>
          <tr>
            <td>TOTAL:</td>
            <td></td>
            <td> </td>
            <td>R$ <?php echo str_replace(".",",",round($totalEntrada,3))?></td>
            <td>R$ <?php echo str_replace(".",",",round($totalSaida,3))?></td>
            <td>R$ <?php echo str_replace(".",",",round($total,3))?></td>
            <td></td>
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

<div id="relatorio2" style="display:none">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Relatórios de Saídas</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <div class="span12" id="divCadastrarOs">
              <form class="form-inline"  action="<?php echo base_url() ?>index.php/almoxarifado/relatorio" enctype="multipart/form-data" method="post" id="formRelat">
                <div class="span12" style="padding: 1%; margin-left: 0">                  
                  <div class="span3" class="control-group">
                    <label for="idEmpresa" class="control-label">Empresa:</label>                        
                    <select class="span12 form-control" name="idEmpresaRelSai" id="idEmpresaRelSai">
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
                    <select class="span12 form-control" name="idDepartamentoRelSai" id="idDepartamentoRelSai">      
                      <option value="">Todos</option>   
                      <?php foreach($dados_departamento as $r){
                      ?>
                        <option value="<?php echo $r->idAlmoEstoqueDep ?>"><?php echo $r->descricaoDepartamento ?> </option>
                      <?php
                      }?>
                    </select>
                  </div>
                  <div class="span1" class="control-group">
                    <label for="cliente" class="control-label">PN:</label>
                    <input class="span12" class="form-control" id="pnRelSai"  type="text" name="pnRelSai" value=""  />
                  </div>
                  <div class="span3" class="control-group">
                    <label for="cliente" class="control-label">Descrição:</label>
                    <input class="span12" class="form-control" id="descRelSai"  type="text" name="descRelSai" value=""  />
                    <input id="idDescRelSai"  type="hidden" name="idDescRelSai" value=""  />
                  </div>
                  <div class="span2" class="control-group" >
                    <label for="cliente" class="control-label">Usuário Cad.:</label>
                    <input class="span12" class="form-control" id="usuCadSai"  type="text" name="usuCadSai" value=""/>
                    <input id="idUsuCadSai"  type="hidden" name="idUsuCadSai" value=""  />
                  </div>                  
                </div>

                <div class="span12" style="padding: 1%; margin-left: 0">
                  <div >
                    <div class="span6" class="control-group" style="width: 380px">
                      <label for="numpedido_os" class="control-label">Data:</label><br>
                        De: <input class="data datepicker" type="text" id="dataInicialSai" name="dataInicialSai" class="span5" /> |  Até:<input class="data datepicker" type="text" id="dataFinalSai" name="dataFinalSai" class="span5" />
                    </div>
                    <div class="span3" class="control-group">
                      <label for="idEmpresa" class="control-label">Empresa Destino:</label>
                      <select class="span12 form-control" name="idEmpresaDestRelSai" id="idEmpresaDestRelSai">
                        <option value="">Todos</option>
                        <?php foreach($dados_emitente as $r){
                          ?>
                          <option value="<?php echo $r->id ?>"><?php echo $r->nome ?> </option>
                          <?php
                        }?>                            
                      </select>
                    </div>
                    <div class="span2" class="control-group">
                      <label for="idEmpresa" class="control-label">Setor:</label>
                      <select class="span12 form-control" name="idSetorRelSai" id="idSetorRelSai" >
                        <option value="">Todos</option>
                        <?php foreach($dados_setor as $r){
                          ?>
                          <option value="<?php echo $r->id_setor ?>"><?php echo $r->nomesetor ?> </option>
                          <?php
                        }?>
                        
                      </select>
                    </div>
                    <div class="span2" class="control-group">
                      <label for="cliente" class="control-label">Usuário:</label>
                      <input class="span12" class="form-control" id="userSolRelSai"  type="text" name="userSolRelSai" value=""  />
                      <input id="idUserSolRelSai"  type="hidden" name="idUserSolRelSai" value=""  />
                    </div>
                    <div class="span1" class="control-group">
                      <label for="idOs" class="control-label">Cod. OS:</label>
                      <input class="span12" class="form-control" id="idOsRelSai"  type="text" name="idOsRelSai" value=""  />
                    </div>
                  </div><!--
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
                  </div> -->
                </div>                    
                <div class="span12" style="padding: 1%; margin-left: 0">
                  <div class="span12" class="control-group">                        
                    <a class="btn btn-success" onclick="filtrarSaidas()">Filtrar</a>
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
      <h5>Produtos</h5>
    </div>
    
    <div class="widget-content nopadding" >
      <form>        
        <div>
          <div class="buttons">                        
            <a id="imprimir3" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
            <a href=javascript:; class="export3-csv btn btn-mini btn-inverse" data-filename="Rel-Saidas">Excel</a>
          </div>
          <div id="divRelSaida">
            <table class="table table-bordered " id="table_rel_saida" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
              font-size:10px;" border="1">
              <thead>
                <tr> 
                  <th>Data Saída</th>
                  <th>PN</th>
                  <th>Descrição</th>
                  <th>Qtd.</th>
                  <th>Empresa</th>
                  <th>Depart.</th>
                  <th>Empresa Destino</th>
                  <th>Setor</th>
                  <th>Usuário Retirada</th>
                  <th>Usuário Cad.</th>
                  <th>OS</th>
                  <th>Obs.</th>
                </tr>
              </thead>
              <tbody>
                <?php /*
                if(isset($dados_saida)){
                  foreach($dados_saida as $saida){
                    ?>
                    <tr>
                      <td>
                        <span style="display:none"><?php if(!empty($saida->data_saida)){ 
                          $date = new DateTime( $saida->data_saida);
                            echo $date-> format( 'Y-m-d H:i:s' );
                        }
                        ?></span>
                        <?php if(!empty($saida->data_saida)){
                        
                        $date = new DateTime( $saida->data_saida);
                        echo $date-> format( 'd-m-Y H:i:s' );
                      } ?></td>
                      <td><?php echo $saida->pn_insumo?></td>
                      <td><?php echo $saida->descricaoInsumo?></td>
                      <td><?php if($saida->metrica==0){
                          echo $saida->quantidade;
                        }else if($saida->metrica==1){
                          echo $saida->quantidade." | ".$saida->comprimento." cm";
                        }else if($saida->metrica==2){
                          echo $saida->quantidade." | ".$saida->volume." ml";
                        }else if($saida->metrica==3){
                          echo $saida->quantidade." | ".$saida->peso." g";
                        }else if($saida->metrica==4){
                          echo $saida->quantidade." | ".$saida->dimensoesL." mm X ".$saida->dimensoesC." mm X ".$saida->dimensoesA." mm";
                        }?></td>
                      <td><?php echo $saida->nome." | Local: ".$saida->local?></td>
                      <td><?php echo $saida->descricaoDepartamento?></td>
                      <td><?php echo $saida->destinoNome?></td>
                      <td><?php echo $saida->nomesetor?></td>
                      <td><?php echo $saida->getUsernome?></td>
                      <td><?php echo $saida->username?></td>
                      <td><?php echo $saida->idOs?></td>
                      <td><?php echo $saida->obs?></td>
                    </tr>
                    <?php
                    
                  }  
                  
            
                } */?>
                
                
              </tbody>
            </table>
          </div>
        </div>
        
      </form>
    </div>
  </div>
</div>

<div id="modal-editarprodutoestoque" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterar item: <input disabled type="text"  name="itemModal" id="itemModal"
          value="" style="border: 0px; background-color: #efefef; width: 60%;"/></h5>
    </div>
    <div class="modal-body">
    <input type="hidden" name="idLocalModal" id="idLocalModal" value="" />
    <input type="hidden" name="almoxarifadoModal" id="almoxarifadoModal" value="" />
    <input type="hidden" name="departamentoModal" id="departamentoModal" value="" />
      Alterar Local:<input type="text"  name="localModal" id="localModal"
          value="" />
    <input type="hidden" name="idAlmoEstoqueModal" id="idAlmoEstoqueModal" value="" />
      Quantidade:<!---->
      <input type="text" name="quantidadeModal" id="quantidadeModal"
          value="" />

    </div>
    <div class="modal-footer">
      <button class="btn" class="close" data-dismiss="modal" name='cancelarAlterarLocalQtd' id='cancelarAlterarLocalQtd' aria-hidden="true">Cancelar</button>
      <button class="btn btn-danger" data-dismiss="modal"  name="alterarLocalQtd" id="alterarLocalQtd">Salvar</button>
    </div>
</div>

<div id="relatorio" style="display:none">
  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Relatório de Entradas</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            
            <div class="span12" id="divCadastrarOs">
              <form>
                <div class="span12" style="padding: 1%; margin-left: 0">                  
                  <div class="span3" class="control-group">
                    <label for="idEmpresa" class="control-label">Empresa:</label>                        
                    <select class="span12 form-control" name="idEmpresaRelEntr" id="idEmpresaRelEntr">
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
                    <select class="span12 form-control" name="idDepartamentoRelEntr" id="idDepartamentoRelEntr">      
                      <option value="">Todos</option>   
                      <?php foreach($dados_departamento as $r){
                      ?>
                        <option value="<?php echo $r->idAlmoEstoqueDep ?>"><?php echo $r->descricaoDepartamento ?> </option>
                      <?php
                      }?>
                    </select>
                  </div>
                  <div class="span1" class="control-group">
                    <label for="cliente" class="control-label">PN:</label>
                    <input class="span12" class="form-control" id="pnRelEntr"  type="text" name="pnRelEntr" value=""  />
                  </div>
                  
                  <div class="span3" class="control-group">
                    <label for="cliente" class="control-label">Descrição:</label>
                    <input class="span12" class="form-control" id="descRelEntr"  type="text" name="descRelEntr" value=""  />
                    <input id="idDescRelEntr"  type="hidden" name="idDescRelEntr" value=""  />
                  </div>
                  <div class="span2" class="control-group" >
                    <label for="cliente" class="control-label">Usuário Cad.:</label>
                    <input class="span12" class="form-control" id="usuCadEntr"  type="text" name="usuCadEntr" value=""/>
                    <input id="idUsuCadEntr"  type="hidden" name="idUsuCadEntr" value=""  />
                  </div>                  
                </div>

                <div class="span12" style="padding: 1%; margin-left: 0">
                  
                  <div>
                    <div class="span12" style="margin-left: 0">
                      <div class="span6" class="control-group" style="width: 380px;">
                        <label for="numpedido_os" class="control-label">Data:</label>
                        De: <input class="data datepicker" type="text" id="dataInicialEntr" name="dataInicialEntr" value="" /> |  Até:<input class="data datepicker" type="text" name="dataFinalEntr" id="dataFinalEntr"  value=""/>
                      </div>
                      <div class="span2" class="control-group">
                        <label for="cliente" class="control-label">Nota Fiscal:</label>
                        <input class="span12" class="form-control" id="nfRelEntr"  type="text" name="nfRelEntr" value=""  />
                        <input id="nf"  type="hidden" name="nf" value=""  />
                      </div>
                      <div class="span2" class="control-group">
                        <label for="idOs" class="control-label">Cod. OS:</label>
                        <input class="span12" class="form-control" id="idOsRelEntr"  type="text" name="idOsRelEntr" value=""  />
                      </div>
                    </div>
                  </div>   
                </div>                    
                <div class="span12" style="padding: 1%; margin-left: 0">
                  <div class="span12" class="control-group">                        
                    <a class="btn btn-success" onclick="filtrarEntradas()">Filtrar</a>
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
      <h5>Produtos</h5>
    </div>
    
    <div class="widget-content nopadding" >
      <form>
        <div>
          <div class="buttons">
                      
            <a id="imprimir2" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
            <a href=javascript:; class="export4-csv btn btn-mini btn-inverse" data-filename="Rel-Entradas">Excel</a>
          </div>
          <div id="divRelEntrada">
            <table class="table table-bordered " id="table_rel_entrada" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
              font-size:10px;" border="1">
              <thead>
                <tr>     <!--      
                  <th>Cod.</th>-->
                  <th>Data Entrada</th>
                  <th>PN</th>
                  <th>Descrição</th>
                  <th>Status</th>
                  <th>Qtd.</th>
                  <th>Empresa</th>
                  <th>Departamento</th>
                  <th>Local Estoque</th>
                  <th>Usuário</th>
                  <th>OS</th>
                  <th>NF</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php /*
                if(isset($dados_entrada)){
                  foreach($dados_entrada as $entrada){
                    ?>
                    <tr><!--
                    <td><?php echo $entrada->idAlmoEstoqueEnt?></td>     -->             
                    <td>
                    <span style="display:none"><?php if(!empty($entrada->data_entrada)){ 
                        $date = new DateTime( $entrada->data_entrada);
                            echo $date-> format( 'Y-m-d H:i:s' );
                    }
                    ?></span>
                      <?php 
                    if(!empty($entrada->data_entrada)){
                      $date = new DateTime( $entrada->data_entrada);
                      echo $date-> format( 'd-m-Y H:i:s' );
                    }?></td>                  
                    <td><?php echo $entrada->pn_insumo?></td> 
                    <td><?php echo $entrada->descricaoInsumo?></td> 
                    <td><?php echo $entrada->descricaoStatusProduto?></td>                  
                    <td><?php if($entrada->metrica==0){
                        echo $entrada->quantidade;
                      }else if($entrada->metrica==1){
                        echo $entrada->quantidade." | ".$entrada->comprimento." cm";
                      }else if($entrada->metrica==2){
                        echo $entrada->quantidade." | ".$entrada->volume." ml";
                      }else if($entrada->metrica==3){
                        echo $entrada->quantidade." | ".$entrada->peso." g";
                      }else if($entrada->metrica==4){
                        echo $entrada->quantidade." | ".$entrada->dimensoesL." mm X ".$entrada->dimensoesC." mm X ".$entrada->dimensoesA." mm";
                      }?></td>                  
                    <td><?php echo $entrada->nomeEmpresa?></td> 
                    <td><?php echo $entrada->descricaoDepartamento?></td>                   
                    <td><?php echo $entrada->local?></td>                  
                    <td><?php echo $entrada->username?></td>
                    <td><?php echo $entrada->idOs?></td>
                    <td><?php echo $entrada->nf?></td>
                    <td></td>
                    </tr>
                    <?php
                  }  
                } */?>
                
                
              </tbody>
            </table>
          </div>
        </div>      
        
      </form>
    </div>
  </div>
</div>

<div id="relatorioDetalhado" style="display:none">
  <div class="container" style="width: auto">
  
    <table
        id="table"
        data-toggle="table"
        data-toolbar="#toolbar"
        data-filter-control="false"
        data-show-footer="false"
        data-detail-formatter="detailFormatter"
        data-detail-view="true"
        data-hide-unused-select-options="true">
        <thead>
            <tr><!--
            <th data-field="state" data-checkbox="false"></th>-->
            <th data-field="Insumo" data-filter-control="select">Insumo</th>
            <th data-field="ValorUnitMedio" data-filter-control="select">Valor Unit. Medio</th>
            <th data-field="ValorTotalEntrada" data-filter-control="select">Valor Total Entrada</th>
            <th data-field="ValorTotalSaida" data-filter-control="select">Valor Total Saida</th>
            <th data-field="ValorTotal" data-filter-control="select">Valor Total Estoque</th>
            <th data-field="QuantidadeTotalEntrada" data-filter-control="select">Quantidade Entrada</th>
            <th data-field="QuantidadeTotalSaida" data-filter-control="select">Quantidade Saída</th>
            <th data-field="QuantidadeTotal" data-filter-control="select">Quantidade Total</th>
            <th data-field="id" data-filter-control="select" data-visible="false">id</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(isset($dadosRelatorio)){
                foreach($dadosRelatorio as $r){?>
                    <tr>
                        <td><?php echo $r->descricaoInsumo?></td>
                        <td>R$ <?php echo str_replace(".",",",round($r->valor_unit_medio,3))?></td>
                        <td>R$ <?php echo str_replace(".",",",round($r->valor_total_entrada,3))?></td>
                        <td>R$ <?php echo str_replace(".",",",round($r->valor_total_saida,3))?></td>
                        <td>R$ <?php echo str_replace(".",",",round($r->valor_total,3))?></td>
                        <td><?php echo $r->quantidade_entrada?></td>
                        <td><?php echo $r->quantidade_saida?></td>
                        <td><?php echo $r->quantidade_total?></td>
                        <td><?php echo $r->idInsumos?></td>
                    </tr>
            
                <?php
                }
            }?>
            
        </tbody>
    </table>
  </div>
</div>

</div>
<script type="text/javascript">
    function showDivEstoqueAtual(){
        document.getElementById('estoqueAtual').style.display = "block";
        document.getElementById('relatorio').style.display = "none";
        document.getElementById('estoqueGeral').style.display = "none";
        document.getElementById('relatorio2').style.display = "none";
        document.getElementById('relatorioDetalhado').style.display = "none";
    }
    function showDivEstoqueGeral(){
        document.getElementById('estoqueGeral').style.display = "block";
        document.getElementById('estoqueAtual').style.display = "none";
        document.getElementById('relatorio').style.display = "none";
        document.getElementById('relatorio2').style.display = "none";
        document.getElementById('relatorioDetalhado').style.display = "none";
    }
    function showDivRelatorio(){
        document.getElementById('estoqueAtual').style.display = "none";
        document.getElementById('estoqueGeral').style.display = "none";
        document.getElementById('relatorio').style.display = "block";
        document.getElementById('relatorio2').style.display = "none";
        document.getElementById('relatorioDetalhado').style.display = "none";
    }
    function showDivRelatorioDetalhado(){
        document.getElementById('estoqueAtual').style.display = "none";
        document.getElementById('estoqueGeral').style.display = "none";
        document.getElementById('relatorioDetalhado').style.display = "block";
        document.getElementById('relatorio2').style.display = "none";
        document.getElementById('relatorio').style.display = "none";
    }
    function showDivRelatorio2(){
        document.getElementById('estoqueAtual').style.display = "none";
        document.getElementById('estoqueGeral').style.display = "none";
        document.getElementById('relatorio2').style.display = "block";
        document.getElementById('relatorio').style.display = "none";
        document.getElementById('relatorioDetalhado').style.display = "none";
    }
    function filterEstoqueAtual(){
        var selectE = document.getElementById('idEmpresae');
        var idEmpresae = selectE.options[selectE.selectedIndex].value;
        var select = document.getElementById('idDepartamentoe');
        var idDepartamentoe = select.options[select.selectedIndex].value;
        var prode = document.querySelector("#prode").value;
        var pne = document.querySelector("#pne").value;
        var idOse = document.querySelector("#idOse").value;
        var local = document.querySelector("#localatual").value;
        var unid_execu = Array.apply(null,document.querySelectorAll("#unid_execucaoe"));
        var unidades = "";
        for(var x=0;x<unid_execu.length;x++){
          if(unid_execu[x].checked){
            if(unidades != ""){
              unidades += ","+unid_execu[x].value
            }else{
              unidades += unid_execu[x].value
            }
          }
        }
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/almoxarifado/Busca_Estoque_Filtro",
            type: 'POST',
            dataType: 'json',
            data: {
                prode: prode,
                idDepartamentoe: idDepartamentoe,
                pn: pne,
                idEmpresae: idEmpresae,
                idOs:idOse,
                local: local,
                unidades: unidades
            },
            success: function(data) {
            if(data.result == true){
                //$('#table_estoque tbody').empty();
                preencherTabelaEstoqueAtual(data.resultado)
            }else{
                alert(data.msggg);
            }
            
            
            },
            error: function(xhr, textStatus, error) {
            console.log("4");
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
            },
        });
    }
    
    
    function preencherTabelaEstoqueAtual(resultado){
      
      
      var table = document.getElementById("table_estoque").getElementsByTagName('tbody')[0];
      tabelaEstoqueAtual.destroy();
      $('#table_estoque tbody').empty();
      if(table.rows.length == null || typeof table.rows.length == "undefined"){
        var numOfRows = 0;
      } else {
        var numOfRows = table.rows.length;
      } 
      var newRow;
      for(y=0;y<resultado.length;y++){
        x=y;
        newRow = table.insertRow(x);
       
        newCell = newRow.insertCell(0);   
        newCell.innerHTML = resultado[x].pn_insumo;

        newCell = newRow.insertCell(1); 
        newCell.innerHTML = resultado[x].descricaoInsumo+"<input type='hidden' value='"+resultado[x].idAlmoEstoque+"' name='idAlmoEstoque_[]'>";

        newCell = newRow.insertCell(2);   
        newCell.innerHTML = resultado[x].descricaoStatusProduto;

        newCell = newRow.insertCell(3); 
        if(resultado[y].metrica == 0){
            newCell.innerHTML = resultado[y].quantidade+" Unid.";
        } else if(resultado[y].metrica == 1){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].comprimento+" CM";
        }else if(resultado[y].metrica == 2){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].volume+" ML";
        }else if(resultado[y].metrica == 3){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].peso+" G";
        }else if(resultado[y].metrica == 4){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].dimensoesL+" mm X "+resultado[y].dimensoesC+" mm X "+resultado[y].dimensoesA+" mm";
        }

        newCell = newRow.insertCell(4);
        newCell.innerHTML = (resultado[x].idOs != 0 && resultado[x].idOs != ""?resultado[x].idOs:"");

        newCell = newRow.insertCell(5);
        newCell.innerHTML = resultado[x].nome;

        newCell = newRow.insertCell(6);
        newCell.innerHTML = resultado[x].descricaoDepartamento;

        newCell = newRow.insertCell(7);   
        if(resultado[x].local == null){
            newCell.innerHTML = ""
        }else{
            newCell.innerHTML = resultado[x].local;
        }       
        
        newCell = newRow.insertCell(8);
        html2 = '<a href="#modal-editarprodutoestoque" style="margin-right: 1%" role="button" data-toggle="modal" departamentoAlterar = "'+resultado[y].idDepartamento+'" almoxarifadoAlterar = "' +resultado[y].tabela+ '" insumoAlterar = "' +resultado[y].descricaoInsumo+ '" idAlmoEstoqueAlterar = "'+resultado[y].idAlmoEstoque+'" localAlterar = "'+resultado[y].local+'" quantidadeAlterar = "'+resultado[y].quantidade+'" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>';
        <?php 
        if($this->permission->checkPermission($this->session->userdata('permissao'),'eAlmoxarifado')){
          foreach($dados_emitente2 as $emit){
            foreach($dados_departamento2 as $depart){
              echo "if($emit->id == resultado[x].id && $depart->idAlmoEstoqueDep == resultado[x].idDepartamento){newCell.innerHTML = html2}";
            }
          }
        }?>
        
       
        
      }
      tabelaEstoqueAtual = $('#table_estoque').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "paging": false,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página " + todosAtual,
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
      
      
    }


    function filterEstoqueGeral(){
        var selectE = document.getElementById('idEmpresag');
        var empresa = selectE.options[selectE.selectedIndex].value;
        var select = document.getElementById('idDepartamentog');
        var departamento = select.options[select.selectedIndex].value;
        var descricao = document.querySelector("#prodg").value;
        var png = document.querySelector("#png").value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/almoxarifado/busca_estoqueGeral_filtro",
            type: 'POST',
            dataType: 'json',
            data: {
                descricao: descricao,
                departamento: departamento,
                pn:png,
                empresa: empresa
            },
            success: function(data) {
            if(data.result == true){
                $('#table_estoqueGeral tbody').empty();
                preencherTabelaEstoqueGeral(data.resultado)
            }else{
                alert(data.msggg);
            }
            
            
            },
            error: function(xhr, textStatus, error) {
            console.log("4");
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
            },
        });
    }

    function preencherTabelaEstoqueGeral(resultado){
      console.log(resultado);
      var table = document.getElementById("table_estoqueGeral").getElementsByTagName('tbody')[0];
      tabelaEstoqueGeral.destroy();
      $('#table_estoqueGeral tbody').empty();
      if(table.rows.length == null || typeof table.rows.length == "undefined"){
        var numOfRows = 0;
      } else {
        var numOfRows = table.rows.length;
      }
      var newRow;
      var total_estoque = 0;
      var total_saida = 0;
      var total_entrada = 0;
      for(y=0;y<resultado.length;y++){
        x=y;
        newRow = table.insertRow(x);

        newCell = newRow.insertCell(0);   
        newCell.innerHTML = resultado[x].pn_insumo;

        newCell = newRow.insertCell(1);   
        newCell.innerHTML = resultado[x].descricaoInsumo;

        

        newCell = newRow.insertCell(2);
        if(resultado[x].valor_unit_medio == null){
          newCell.innerHTML = "R$ 0"
        }else{
          newCell.innerHTML = "R$ "+Number(resultado[x].valor_unit_medio).toFixed(2).replace(".",",");
        }   
        

        newCell = newRow.insertCell(3); 
        if(resultado[x].valor_total_entrada == null){
          newCell.innerHTML = "R$ 0"
        }else{  
          total_entrada += Number(resultado[x].valor_total_entrada);
          newCell.innerHTML = "R$ "+Number(resultado[x].valor_total_entrada).toFixed(2).replace(".",",");
        }

        newCell = newRow.insertCell(4);
        if(resultado[x].valor_total_saida == null){
          newCell.innerHTML = "R$ 0"
        }else{
          total_saida += Number(resultado[x].valor_total_saida);
          newCell.innerHTML = "R$ "+Number(resultado[x].valor_total_saida).toFixed(2).replace(".",",");
        }

        newCell = newRow.insertCell(5);
        if(resultado[x].valor_total == null){
          newCell.innerHTML = "R$ 0"
        }else{   
          total_estoque += Number(resultado[x].valor_total);
          newCell.innerHTML = "R$ "+Number(resultado[x].valor_total).toFixed(2).replace(".",",");
        }

        newCell = newRow.insertCell(6);   
        newCell.innerHTML = resultado[x].quantidade_entrada;

        newCell = newRow.insertCell(7);   
        newCell.innerHTML = resultado[x].quantidade_saida;

        newCell = newRow.insertCell(8);   
        newCell.innerHTML = resultado[x].quantidade_total;

        newCell = newRow.insertCell(9);   
        newCell.innerHTML = resultado[x].nome;

        newCell = newRow.insertCell(10);   
        newCell.innerHTML = resultado[x].descricaoDepartamento;  
      }
      $('#table_estoqueGeral').append("<tbody> <tr>"+
            "<td>TOTAL:</td>"+
            "<td></td>"+
            "<td> </td>"+
            "<td>R$ "+Number(total_entrada).toFixed(2).replace(".",",")+"</td>"+
            "<td>R$ "+Number(total_saida).toFixed(2).replace(".",",")+"</td>"+
            "<td>R$ "+Number(total_estoque).toFixed(2).replace(".",",")+"</td>"+
            "<td></td>"+
            "<td></td>"+
            "<td></td>"+
            "<td></td>"+
            "<td></td>"+
          "</tr> </tbody>");
      tabelaEstoqueGeral =  $('#table_estoqueGeral').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "order": [[ 1, "asc" ]],
            "paging": true,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "lengthMenu": [
                [10, 25, 50, 100,500, -1],
                [10, 25, 50, 100,500,'Todos'],
            ],
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
      
    }

    function filtrarEntradas(){
        var selectE = document.getElementById('idEmpresaRelEntr');
        var empresa = selectE.options[selectE.selectedIndex].value;
        var select = document.getElementById('idDepartamentoRelEntr');
        var departamento = select.options[select.selectedIndex].value;
        var descricao = document.querySelector("#descRelEntr").value;
        var usuCadEntr = document.querySelector("#usuCadEntr").value;
        var dataInicialEntr = document.querySelector("#dataInicialEntr").value;
        var dataFinalEntr = document.querySelector("#dataFinalEntr").value;
        var nfRelEntr = document.querySelector("#nfRelEntr").value;
        var pnRelEntr = document.querySelector("#pnRelEntr").value;
        var idOsRelEntr = document.querySelector("#idOsRelEntr").value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/almoxarifado/filtrarEntradas",
            type: 'POST',
            dataType: 'json',
            data: {
                empresa: empresa,
                departamento: departamento,
                usuCadEntr: usuCadEntr,
                dataInicialEntr: dataInicialEntr,
                dataFinalEntr: dataFinalEntr,
                pn: pnRelEntr,
                nfRelEntr: nfRelEntr,
                idOsRelEntr: idOsRelEntr,
                descricao: descricao
            },
            success: function(data) {
                if(data.result == true){
                  //console.log(data);
                    //$('#table_rel_entrada tbody').empty();
                    preencherTabelaEntradas(data.resultado)
                } else {
                }
            
                
            },
        })

    }

    function preencherTabelaEntradas(resultado){
      console.log(resultado);
     
      var table = document.getElementById("table_rel_entrada").getElementsByTagName('tbody')[0];
      tabelaEntrada.destroy();
      $('#table_rel_entrada tbody').empty();
      if(table.rows.length == null || typeof table.rows.length == "undefined"){
        var numOfRows = 0;
      } else {
        var numOfRows = table.rows.length;
      } 
      var newRow;
      for(y=0;y<resultado.length;y++){
        x=y;
        newRow = table.insertRow(x);

        newCell = newRow.insertCell(0);   
        test = resultado[y].data_entrada.split(" ");
        data = test[0].split("-");
        newCell.innerHTML = '<span style="display:none">'+resultado[y].data_entrada+'</span>'+data[2]+"-"+data[1]+"-"+data[0]+" "+test[1];
        
        newCell = newRow.insertCell(1);
        newCell.innerHTML = resultado[y].pn_insumo ; 

        newCell = newRow.insertCell(2);
        newCell.innerHTML = resultado[y].descricaoInsumo ; 
         
        newCell = newRow.insertCell(3); 
        newCell.innerHTML = resultado[y].descricaoStatusProduto;     

        newCell = newRow.insertCell(4);
        if(resultado[y].metrica == 0){
            newCell.innerHTML = resultado[y].quantidade;
        } else if(resultado[y].metrica == 1){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].comprimento+" cm";
        }else if(resultado[y].metrica == 2){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].volume+" ml";
        }else if(resultado[y].metrica == 3){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].peso+" g";
        }else if(resultado[y].metrica == 4){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].dimensoesL+" mm X "+resultado[y].dimensoesC+" mm X "+resultado[y].dimensoesA+" mm";
        }
        
        newCell = newRow.insertCell(5);          
        newCell.innerHTML =resultado[y].nomeEmpresa

        newCell = newRow.insertCell(6);   
        newCell.innerHTML = resultado[y].descricaoDepartamento;

        newCell = newRow.insertCell(7);   
        newCell.innerHTML = resultado[y].local;

        newCell = newRow.insertCell(8);   
        newCell.innerHTML = resultado[y].username;

        newCell = newRow.insertCell(9);   
        newCell.innerHTML = resultado[y].idOs;

        newCell = newRow.insertCell(10);   
        newCell.innerHTML = resultado[y].nf;
        
        newCell = newRow.insertCell(11);   
        newCell.innerHTML = '';

      }
      tabelaEntrada = $('#table_rel_entrada').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "paging": true,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "lengthMenu": [
                [10, 25, 50, 100, 500, -1],
                [10, 25, 50, 100, 500,'Todos'],
            ],
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
      
    }

    function filtrarSaidas(){
        var selectE = document.getElementById('idEmpresaRelSai');
        var empresa = selectE.options[selectE.selectedIndex].value;
        var select = document.getElementById('idDepartamentoRelSai');
        var departamento = select.options[select.selectedIndex].value;
        var selectD = document.getElementById('idEmpresaDestRelSai');
        var empresaDestino = selectD.options[selectD.selectedIndex].value;
        var selectS = document.getElementById('idSetorRelSai');
        var setor = selectS.options[selectS.selectedIndex].value;
        var descricao = document.querySelector("#descRelSai").value;
        var usuCadSai = document.querySelector("#usuCadSai").value;
        var dataInicialSai = document.querySelector("#dataInicialSai").value;
        var dataFinalSai = document.querySelector("#dataFinalSai").value;
        var userSolRelSai = document.querySelector("#userSolRelSai").value;
        var idOsRelSai = document.querySelector("#idOsRelSai").value;
        var pnRelSai = document.querySelector("#pnRelSai").value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/almoxarifado/filtrarSaidas",
            type: 'POST',
            dataType: 'json',
            data: {
                empresa: empresa,
                departamento: departamento,
                empresaDestino: empresaDestino,
                setor: setor,
                pn: pnRelSai,
                usuCadSai: usuCadSai,
                dataInicialSai: dataInicialSai,
                dataFinalSai: dataFinalSai,
                userSolRelSai: userSolRelSai,
                idOsRelSai: idOsRelSai,
                descricao: descricao
            },
            success: function(data) {
                if(data.result == true){
                    $('#table_rel_saida tbody').empty();
                    preencherTabelaSaida(data.resultado);
                } else {
                }
            
                
            },
        })
    }

    function preencherTabelaSaida(resultado){
        
        var table = document.getElementById("table_rel_saida").getElementsByTagName('tbody')[0];
        tabelaSaida.destroy();
        $('#table_rel_saida tbody').empty();
        if(table.rows.length == null || typeof table.rows.length == "undefined"){
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        } 
        var newRow;
        for(y=0;y<resultado.length;y++){
            x=y;
            newRow = table.insertRow(x);

            newCell = newRow.insertCell(0);   
            test = resultado[y].data_saida.split(" ");
            data = test[0].split("-");
            newCell.innerHTML = '<span style="display:none">'+resultado[y].data_saida+'</span>'+data[2]+"-"+data[1]+"-"+data[0]+" "+test[1];

            newCell = newRow.insertCell(1);
            newCell.innerHTML = resultado[y].pn_insumo;
            
            newCell = newRow.insertCell(2); 
            newCell.innerHTML = resultado[y].descricaoInsumo;        

            newCell = newRow.insertCell(3);
            if(resultado[y].metrica == 0){
                newCell.innerHTML = resultado[y].quantidade;
            } else if(resultado[y].metrica == 1){
                newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].comprimento+" cm";
            }else if(resultado[y].metrica == 2){
                newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].volume+" ml";
            }else if(resultado[y].metrica == 3){
                newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].peso+" g";
            }else if(resultado[y].metrica == 4){
                newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].dimensoesL+" mm X "+resultado[y].dimensoesC+" mm X "+resultado[y].dimensoesA+" mm";
            }
            
            newCell = newRow.insertCell(4);
            if(resultado[y].local == null){
                newCell.innerHTML =resultado[y].nome
            } else {
                newCell.innerHTML =resultado[y].nome+" | Local: "+resultado[y].local;
            } 
            
            newCell = newRow.insertCell(5);   
            newCell.innerHTML = resultado[y].descricaoDepartamento;

            newCell = newRow.insertCell(6);   
            newCell.innerHTML = resultado[y].destinoNome;

            newCell = newRow.insertCell(7);   
            newCell.innerHTML = resultado[y].nomesetor;

            newCell = newRow.insertCell(8);   
            newCell.innerHTML = resultado[y].getUsernome;

            newCell = newRow.insertCell(9);   
            newCell.innerHTML = resultado[y].username;

            newCell = newRow.insertCell(10);   
            newCell.innerHTML = resultado[y].idOs;

            newCell = newRow.insertCell(11);   
            newCell.innerHTML = resultado[y].obs;

        }
        tabelaSaida = $('#table_rel_saida').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "order": [[ 0, "desc" ]],
            "paging": true,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "lengthMenu": [
                [10, 25, 50, 100,500, -1],
                [10, 25, 50, 100,500,'Todos'],
            ],
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
        
    }

    function mostrarTodosRegistros(){
        var selectE = document.getElementById('idEmpresae');
        var idEmpresae = selectE.options[selectE.selectedIndex].value;
        var select = document.getElementById('idDepartamentoe');
        var idDepartamentoe = select.options[select.selectedIndex].value;
        var prode = document.querySelector("#prode").value;
        var pne = document.querySelector("#pne").value;
        var idOs = document.querySelector("#idOse").value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/almoxarifado/Busca_Estoque_Filtro",
            type: 'POST',
            dataType: 'json',
            data: {
                prode: prode,
                idDepartamentoe: idDepartamentoe,
                pn: pne,
                idEmpresae: idEmpresae,
                idOs:idOs
            },
            success: function(data) {
            if(data.result == true){
                //$('#table_estoque tbody').empty();
                mostrarTodosRegistrosX(data.resultado)
            }else{
                alert(data.msggg);
            }
            
            
            },
            error: function(xhr, textStatus, error) {
            console.log("4");
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
            },
        });
    }

    function mostrarTodosRegistrosX(resultado){
      
      
      var table = document.getElementById("table_estoque").getElementsByTagName('tbody')[0];
      tabelaEstoqueAtual.destroy();
      $('#table_estoque tbody').empty();
      if(table.rows.length == null || typeof table.rows.length == "undefined"){
        var numOfRows = 0;
      } else {
        var numOfRows = table.rows.length;
      } 
      var newRow;
      for(y=0;y<resultado.length;y++){
        x=y;
        newRow = table.insertRow(x);
       
        newCell = newRow.insertCell(0);   
        newCell.innerHTML = resultado[x].pn_insumo;

        newCell = newRow.insertCell(1); 
        newCell.innerHTML = resultado[x].descricaoInsumo+"<input type='hidden' value='"+resultado[x].idAlmoEstoque+"' name='idAlmoEstoque_[]'>";

        newCell = newRow.insertCell(2);   
        newCell.innerHTML = resultado[x].descricaoStatusProduto;

        newCell = newRow.insertCell(3); 
        if(resultado[y].metrica == 0){
            newCell.innerHTML = resultado[y].quantidade+" Unid.";
        } else if(resultado[y].metrica == 1){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].comprimento+" CM";
        }else if(resultado[y].metrica == 2){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].volume+" ML";
        }else if(resultado[y].metrica == 3){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].peso+" G";
        }else if(resultado[y].metrica == 4){
            newCell.innerHTML = resultado[y].quantidade+" | "+resultado[y].dimensoesL+" mm X "+resultado[y].dimensoesC+" mm X "+resultado[y].dimensoesA+" mm";
        }

        newCell = newRow.insertCell(4);
        newCell.innerHTML = resultado[x].nomeExibicao;

        newCell = newRow.insertCell(5);
        newCell.innerHTML = resultado[x].descricaoDepartamento;

        newCell = newRow.insertCell(6);   
        if(resultado[x].local == null){
            newCell.innerHTML = ""
        }else{
            newCell.innerHTML = resultado[x].local;
        }       
        
        newCell = newRow.insertCell(7);
        html2 = '<a href="#modal-editarprodutoestoque" style="margin-right: 1%" role="button" data-toggle="modal" departamentoAlterar = "'+resultado[y].idDepartamento+'" almoxarifadoAlterar = "' +resultado[y].tabela+ '" insumoAlterar = "' +resultado[y].descricaoInsumo+ '" idAlmoEstoqueAlterar = "'+resultado[y].idAlmoEstoque+'" localAlterar = "'+resultado[y].local+'" quantidadeAlterar = "'+resultado[y].quantidade+'" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>';
        <?php 
        if($this->permission->checkPermission($this->session->userdata('permissao'),'eAlmoxarifado')){
        foreach($dados_emitente2 as $emit){
          foreach($dados_departamento2 as $depart){
            echo "if($emit->id == resultado[x].id && $depart->idAlmoEstoqueDep == resultado[x].idDepartamento){newCell.innerHTML = html2}";
          }
          }
        }?>
        
       
        
      }
      tabelaEstoqueAtual = $('#table_estoque').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "paging": true,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "lengthMenu": [
                [10, 25, 50, 100,500, -1],
                [10, 25, 50, 100,500,'Todos'],
            ],
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página " + todosAtual,
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
      
      
    }

    $('#cancelarAlterarLocalQtd').click(function(){
      $( ".modal-backdrop" ).remove();
    })
    $('#alterarLocalQtd').click(function(){
      var quantidadeModal = document.querySelector("#quantidadeModal").value;
      var idAlmoEstoqueModal = document.querySelector("#idAlmoEstoqueModal").value;
      var localModal = document.querySelector("#localModal").value;
      var idLocalModal = document.querySelector("#idLocalModal").value;
      var almoxarifadoModal = document.querySelector("#almoxarifadoModal").value;
      var departamentoModal = document.querySelector("#departamentoModal").value;
      console.log('ok');
      $.ajax({
        url: "<?php echo base_url(); ?>index.php/almoxarifado/alterarLocalQtd",
        type: 'POST',
        dataType: 'json',
        data: {
          quantidade: quantidadeModal,
          idAlmoEstoque: idAlmoEstoqueModal,
          idLocal: idLocalModal,
          local: localModal,
          departamento: departamentoModal,
          almoxarifado: almoxarifadoModal
        },
        success: function(data) {
          console.log(data.result);
          $( ".modal-backdrop" ).remove();
          if(data.result == true){
            filterEstoqueAtual();
            alert(data.msggg);
          }else{
            alert(data.msggg);
          }
        },
        error: function(xhr, textStatus, error) {
          console.log("4");
          console.log(xhr.responseText);
          console.log(xhr.statusText);
          console.log(textStatus);
          console.log(error);
        },
                        
      })
    })
    $(document).ready(function(){
      
      jQuery(".data").mask("99/99/9999");
    });
    $(document).ready(function() {
      $(document).on('click', 'a', function(event) {

        var idAlmoEstoqueAlterar = $(this).attr('idAlmoEstoqueAlterar');
        $('#idAlmoEstoqueModal').val(idAlmoEstoqueAlterar);

        var localAlterar = $(this).attr('localAlterar');
        $('#localModal').val(localAlterar);

        var quantidadeAlterar = $(this).attr('quantidadeAlterar');
        $('#quantidadeModal').val(quantidadeAlterar);

        var insumoAlterar = $(this).attr('insumoAlterar');
        $('#itemModal').val(insumoAlterar);

        var almoxarifadoAlterar = $(this).attr('almoxarifadoAlterar');
        $('#almoxarifadoModal').val(almoxarifadoAlterar);

        var departamentoAlterar = $(this).attr('departamentoAlterar');
        $('#departamentoModal').val(departamentoAlterar);
        
      });
      
    });
    var tabelaEstoqueAtual;
    var todosAtual = "<a class='btn btn-mini' style='background-color: #4CAF50; color: #fff' role='button' name='filter' onclick='mostrarTodosRegistros()'>MOSTRAR TODOS</a>";
    $(document).ready(function () {
      tabelaEstoqueAtual =  $('#table_estoque').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "paging": false,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "lengthMenu": [
              [10, 25, 50, 100,500, -1],
              [10, 25, 50, 100,500,'Todos'],
          ],
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página " + todosAtual,
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
    var tabelaEstoqueGeral;
    $(document).ready(function () {
      tabelaEstoqueGeral =  $('#table_estoqueGeral').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "order": [[ 1, "asc" ]],
            "paging": true,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "lengthMenu": [
            [10, 25, 50, 100,500, -1],
            [10, 25, 50, 100,500,'Todos'],
        ],
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
    var tabelaEntrada;
    $(document).ready(function () {
      tabelaEntrada = $('#table_rel_entrada').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "order": [[ 0, "desc" ]],
            "paging": true,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "lengthMenu": [
            [10, 25, 50, 100,500, -1],
            [10, 25, 50, 100,500,'Todos'],
        ],
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
    var tabelaSaida;
    $(document).ready(function () {
      tabelaSaida = $('#table_rel_saida').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "order": [[ 0, "desc" ]],
            "paging": true,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "lengthMenu": [
            [10, 25, 50, 100,500, -1],
            [10, 25, 50, 100,500,'Todos'],
        ],
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
    $(document).ready(function(){
      $("#imprimir").click(function(){         
        PrintElem('#divEstoque');
      })
      
      $("#imprimir2").click(function(){         
        PrintElem('#divRelEntrada');
      })

      $("#imprimir3").click(function(){         
        PrintElem('#divRelSaida');
      })

      $("#imprimir4").click(function(){         
        PrintElem('#divEstoqueGeral');
      })

      function PrintElem(elem)
      {
        Popup($(elem).html());
      }

      function Popup(data)
      {
        var mywindow = window.open('', 'SGI', 'height=600,width=800');
        mywindow.document.write('<html><head><title>SGI</title>');
        /* mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap.min.css' /><link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap-responsive.min.css' />");*/
        mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/tableimprimir.css' />");


        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        //mywindow.close();

        return true;
      }

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
    
    $(function () {
      $(".export-csv").on('click', function (event) {
          // CSV
          var filename = $(".export-csv").data("filename")
          var args = [$('#table_estoque'), filename + ".csv", 0];
          exportTableToCSV.apply(this, args);
      });
      $(".export2-csv").on('click', function (event) {
          // CSV
          var filename = $(".export2-csv").data("filename")
          var args = [$('#table_estoqueGeral'), filename + ".csv", 0];
          exportTableToCSV.apply(this, args);
      });
      $(".export3-csv").on('click', function (event) {
          // CSV
          var filename = $(".export3-csv").data("filename")
          var args = [$('#table_rel_saida'), filename + ".csv", 0];
          exportTableToCSV.apply(this, args);
      });
      $(".export4-csv").on('click', function (event) {
          // CSV
          var filename = $(".export4-csv").data("filename")
          var args = [$('#table_rel_entrada'), filename + ".csv", 0];
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

    <?php if(isset($dadosRelatorio)){
        foreach($dadosRelatorio as $r){?>
      var sub_data<?php echo $r->idInsumos ?> = [
        <?php if(isset($r->detalheEstoqueEmpresas)){
            $tot = count($r->detalheEstoqueEmpresas);
            foreach($r->detalheEstoqueEmpresas as $ru){
                $contador = 0;
                $contador = $contador+1;?>
        {
        "insumos": '<?php echo str_replace("'","\'",$ru->descricaoInsumo);?>',
        "empresa": '<?php echo $ru->nome;?>',
        "quantidade": '<?php echo $ru->quantidade_total;?>',
        "quantidade_entrada": '<?php echo $ru->quantidade_entrada;?>',
        "quantidade_saida": '<?php echo $ru->quantidade_saida;?>',
        "valor_unit": '<?php echo $ru->valor_unit_medio;?>',
        "valor_total_entrada": '<?php echo $ru->valor_total_entrada;?>',
        "valor_total_saida": '<?php echo $ru->valor_total_saida;?>',
        "valor_total": '<?php echo $ru->valor_total;?>',
        }<?php if($contador != $tot){ echo ",";}?>
    <?php }
    }?>
    ];
    <?php }
    }?>


    <?php if(isset($dadosRelatorio)){
        foreach($dadosRelatorio as $r){?>
        var sub_entrada<?php echo $r->idInsumos ?> = [
        <?php if(isset($r->entradas)){
            $tot2 = count($r->entradas);
            foreach($r->entradas as $ru){
                $contador2 = 0;
                $contador2 = $contador2+1;?>
        {
        "insumos": '<?php echo $ru->descricaoInsumo;?>',
        "empresa": '<?php echo $ru->nome;?>',
        "quantidade": '<?php echo $ru->quantidade_total;?>',
        //"valor_unit": "",
        "valor_total": '<?php echo $ru->valor_total;?>',
        }<?php if($contador2 != $tot2){ echo ",";}?>
    <?php }
    }?>
    ];
    <?php }
    }?>

<?php if(isset($dadosRelatorio)){
        foreach($dadosRelatorio as $r){?>
        var sub_saida<?php echo $r->idInsumos ?> = [
        <?php if(isset($r->saidas)){
            $tot3 = count($r->saidas);
            foreach($r->saidas as $ru){
                $contador3 = 0;
                $contador3 = $contador3+1;?>
        {
        "insumos": '<?php echo $ru->descricaoInsumo;?>',
        "empresa": '<?php echo $ru->nome;?>',
        "quantidade": '<?php echo $ru->quantidade_total;?>',
        //"valor_unit": "",
        "valor_total": '<?php echo $ru->valor_total;?>',
        }<?php if($contador3 != $tot3){ echo ",";}?>
    <?php }
    }?>
    ];
    <?php }
    }?>
    function build_sub_table(subData, table) {
        var data = JSON.parse(JSON.stringify(eval(subData)))

        $('#'+table).bootstrapTable({
            columns: [{
            title: 'Insumos',
            field: 'insumos',
            sortable: true,
            },{
            title: 'Empresa',
            field: 'empresa',
            sortable: true,
            },{
            title: 'Quantidade',
            field: 'quantidade',
            sortable: true,
            },{
            title: 'Valor Unit.',
            field: 'valor_unit',
            sortable: true,
            },{
            title: 'Valor Total.',
            field: 'valor_total',
            sortable: true,
            }],
            data: data
        })
    
    };

    function detailFormatter(index, row, element){ 
        var html = []
        var data = JSON.parse(JSON.stringify(eval("sub_data"+row.id)))
        var data2 = JSON.parse(JSON.stringify(eval("sub_entrada"+row.id)))
        var data3 = JSON.parse(JSON.stringify(eval("sub_saida"+row.id)))
        var htmlA = "";
        var htmlB = "";
        var htmlC = "";

        for(var x=0;x<data.length;x++){
            htmlA = htmlA + 
            '<tr>'+
                '<td >'+data[x].insumos+'</td>'+
                '<td >'+data[x].empresa+'</td>'+
                '<td >'+data[x].quantidade+'</td>'+
                '<td >'+data[x].quantidade_entrada+'</td>'+
                '<td >'+data[x].quantidade_saida+'</td>'+
                '<td >R$ '+Number(data[x].valor_unit).toFixed(3).replace(".",",")+'</td>'+
                '<td >R$ '+Number(data[x].valor_total_entrada).toFixed(3).replace(".",",")+'</td>'+
                '<td >R$ '+Number(data[x].valor_total_saida).toFixed(3).replace(".",",")+'</td>'+
                '<td >R$ '+Number(data[x].valor_total).toFixed(3).replace(".",",")+'</td>'+
            '</tr>'
        }
        for(var x=0;x<data2.length;x++){
            htmlB = htmlB + 
            '<tr>'+
                '<td >'+data2[x].insumos+'</td>'+
                '<td >'+data2[x].empresa+'</td>'+
                '<td >'+data2[x].quantidade+'</td>'+
                '<td >'+data2[x].valor_total.replace(".",",")+'</td>'+
            '</tr>'
        }
        for(var x=0;x<data3.length;x++){
            htmlC = htmlC + 
            '<tr>'+
                '<td >'+data3[x].insumos+'</td>'+
                '<td >'+data3[x].empresa+'</td>'+
                '<td >'+data3[x].quantidade+'</td>'+
                '<td >'+data3[x].valor_total.replace(".",",")+'</td>'+
            '</tr>'
        }
        html.push('<div class="ui one column grid" style="margin-bottom:30px">'+
            '<div >'+
                //'<label for="sub_table"'+row.id+' style= "text-align: center;margin-top: 5px">Estoque por Empresa</label>'+
                '<table class="ui very compact table" id="sub_table"'+row.id+' >'+
                    '<thead>'+
                        '<tr>'+
                            '<th data-field="insumos">Insumos</th>'+
                            '<th data-field="empresa">Empresa</th>'+
                            '<th data-field="quantidade">Quantidade</th>'+
                            '<th data-field="quantidade_entrada">Quantidade Entrada</th>'+
                            '<th data-field="quantidade_saida">Quantidade Saída</th>'+
                            '<th data-field="valor_unit">Valor Unit.</th>'+
                            '<th data-field="valor_total_entrada">Valor Total Entrada</th>'+
                            '<th data-field="valor_total_saida">Valor Total Saída</th>'+
                            '<th data-field="valor_total">Valor Total Estoque</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+                        
                        htmlA+
                    '</tbody>'+
                '</table>'+
            '</div>'+
        '</div>');  /*
        html.push('<div class="ui one column grid" style="margin-bottom:30px">'+
            '<div >'+
                '<label for="sub_tableEntrada"'+row.id+' style= "text-align: center;margin-top: 5px">Entradas por Empresa</label>'+
                '<table class="ui very compact table" id="sub_tableEntrada"'+row.id+' >'+
                    '<thead>'+
                        '<tr>'+
                            '<th data-field="insumos">Insumos</th>'+
                            '<th data-field="empresa">Empresa</th>'+
                            '<th data-field="quantidade">Quantidade</th>'+
                            '<th data-field="valor_total">Valor Total</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+                        
                        htmlB+
                    '</tbody>'+
                '</table>'+
            '</div>'+
        '</div>');  
        html.push('<div class="ui one column grid" style="margin-bottom:30px">'+
            '<div >'+
                '<label for="sub_tableSaida"'+row.id+' style= "text-align: center;margin-top: 5px">Saídas por Empresa</label>'+
                '<table class="ui very compact table" id="sub_tableSaida"'+row.id+' >'+
                    '<thead>'+
                        '<tr>'+
                            '<th data-field="insumos">Insumos</th>'+
                            '<th data-field="empresa">Empresa</th>'+
                            '<th data-field="quantidade">Quantidade</th>'+
                            '<th data-field="valor_total">Valor Total</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+                        
                        htmlC+
                    '</tbody>'+
                '</table>'+
            '</div>'+
        '</div>'); */

        return html.join('')
        //return childDetail(index,row)
    };
        

    function childDetail(index,row){
        var row1 = document.createElement("div");
        row1.setAttribute('class','ui one column grid'); 
        var button = document.createElement("button");
        button.setAttribute('onclick','build_sub_table("sub_data'+row.id+'", "sub_table'+row.id+'")')  
        button.textContent="Detalhes"
        row1.append(button);
        
        var row2 = document.createElement("div");
        row1.setAttribute('class','ui one column grid');
        
        var table = document.createElement('table');
        table.setAttribute('class','ui very compact table');
        table.setAttribute('id','sub_table'+row.id);


        row2.append(table);
        build_sub_table("sub_data"+row.id, "sub_table"+row.id)
        row1.append(row2);
        return row1;
    };
</script>