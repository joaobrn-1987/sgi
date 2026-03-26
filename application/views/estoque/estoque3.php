
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/moment.js"></script><!--
<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />

<!--
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script><!--
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
<link href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css" rel="stylesheet">
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
                    } else if($r->metrica == 2){
                      ?> | <?php echo $r->volume; ?> ML<?php
                    }else if($r->metrica == 3){
                      ?> | <?php echo $r->peso; ?> G<?php
                    }else if($r->metrica == 4){
                      ?> | <?php echo $r->dimensoesL.'mm X '.$r->dimensoesC.'mm X '.$r->dimensoesA.'mm'; ?> <?php
                    }
                      ?>
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
            }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
