<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script><!--
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script> -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->

<!-- assinatura--><?php /* 
<style>
    .wrapper {
  position: relative;
  width: 400px;
  height: 200px;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
img {
  position: absolute;
  left: 0;
  top: 0;
}

.signature-pad {
  position: absolute;
  left: 0;
  top: 0;
  width:400px;
  height:200px;
}
</style>
<div class="wrapper">
  <img src="<?php echo base_url();?>assets/img/assinatura" width=400 height=200 />
  <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
</div>
<script type="text/javascript">
    var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
  backgroundColor: 'rgba(255, 255, 255, 0)',
  penColor: 'rgb(0, 0, 0)'
});
var saveButton = document.getElementById('save');
var cancelButton = document.getElementById('clear');

saveButton.addEventListener('click', function (event) {
  var data = signaturePad.toDataURL('image/png');

// Send data to server instead...
  window.open(data);
});

cancelButton.addEventListener('click', function (event) {
  signaturePad.clear();
});
</script>
<!-- /assinatura-->
*/ ?>
<div>
    <ul class="nav nav-tabs">
        <li class="active" id="tabRecebimento"><a href="#tab4" data-toggle="tab">
            <font>Recebimento</font>
        </a></li>
        <li id="tabEntrada"><a href="#tab2" data-toggle="tab">
            <font>Entrada</font>
        </a></li>
        <li id="tabSaida"><a href="#tab3" data-toggle="tab">
            <font>Saída</font>
        </a></li>
        <li  id="tabGeral"><a href="#tab1" data-toggle="tab">
            <font>Acompanhamento</font>
        </a></li>
        <li  id="tabCancelados"><a href="#tab5" data-toggle="tab">
            <font>Cancelados</font>
        </a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="tab1">
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
                                        <form id="formFiltrar">
                                            <div class="span12" id="divCadastrarOs">
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                                        <input type="text" class="span12" value="" name="idOrcamento" id="idOrcamento" />
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">O.S.: </label>
                                                        <input type="text" class="span12" value="" name="idOs" id="idOs" />
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                                        <input type="text" class="span12" value="" name="pn" id="pn" />
                                                    </div>
                                                    <div class="span3" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Descrição: </label>
                                                        <input type="text" class="span12" value="" name="descricaoItem" id="descricaoItem" />
                                                    </div>
                                                    <div class="span3" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Etapa serviço: </label>
                                                        <select class="span12 form-control" id="statusServico">
                                                            <option value="">Todos</option>
                                                            <?php foreach ($statusEtapa as $r) {
                                                                echo '<option value="' . $r->idStatusEtapasServico . '">' . $r->descricaoStatusEtapaServico . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span2" class="control-group">
                                                        <a onclick="carregarItens()" class="btn btn-success"><i class="icon-white"></i>Filtrar</a>
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
                            <h5>Itens</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">
                                            <div class="widget-box" style="margin-top:0px">
                                                <table id="tableItens" class="table table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Data cad.:</th>
                                                            <th>Orç.:</th>
                                                            <th>O.S.</th>
                                                            <th>PN</th>
                                                            <th>Descrição</th>
                                                            <th>Qtd</th>
                                                            <th>Etapa</th>
                                                            <th>Local</th>
                                                            <th>Usuário</th>
                                                            <th>Funções</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
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
        </div> <!---->
        
        <!--
        <div class="tab-pane" id="tab2">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Entrada</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                    <div class="tab-pane active">
                                        <form name="formEntrada" id="formEntrada">
                                            <div class="span12" id="divCadastrarOs">
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                                        <input type="text" class="span12" value="" name="idOrcamento" id="idOrcamento" />
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">O.S.: </label>
                                                        <input type="text" class="span12" value="" name="idOs" id="idOs"/>
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                                        <input type="text" class="span12" value="" name="pn" id="pn"/>
                                                        <input type="hidden" class="span12" value="" name="idControleEtapa" id="idControleEtapa" />
                                                    </div>
                                                    <div class="span3" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Descrição: </label>
                                                        <input type="text" class="span12" value="" name="descricaoItem" id="descricaoItem"/>
                                                    </div>
                                                </div>
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span2" class="control-group">
                                                        <a onclick="procurarEntrada()" class="btn btn-success"><i class="icon-white"></i>Procurar</a>
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
            <form action="<?php echo base_url() ?>index.php/controle/getDetailProduto" method="post" target="_blank">
                <div align='center' style="margin-top: 20px;">
                    <button 'onclick="carregarModalEntrada()" type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                </div>

                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5>Itens Entrada</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="span12" id="divCadastrarOs">
                                                <div class="widget-box" style="margin-top:0px">
                                                    <table id="tableEntrada" class="table table-bordered ">
                                                        <tbody>

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
        </div> -->

        <div class="tab-pane" id="tab2">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Entrada</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                    <div class="tab-pane active">
                                        <form name="formEntrada" id="formEntrada">
                                            <div class="span12" id="divCadastrarOs">
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                                        <input type="text" class="span12" value="" name="idOrcamento" id="idOrcamento" />
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">O.S.: </label>
                                                        <input type="text" class="span12" value="" name="idOs" id="idOs"/>
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                                        <input type="text" class="span12" value="" name="pn" id="pn"/>
                                                        <input type="hidden" class="span12" value="" name="idControleEtapa" id="idControleEtapa" />
                                                    </div>
                                                    <div class="span3" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Descrição: </label>
                                                        <input type="text" class="span12" value="" name="descricaoItem" id="descricaoItem"/>
                                                    </div>
                                                </div>
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span2" class="control-group">
                                                        <a onclick="procurarEntrada()" class="btn btn-success"><i class="icon-white"></i>Procurar</a>
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
            <form action="<?php echo base_url() ?>index.php/controle/getDetailProduto" method="post" target="_blank"><!--
                <div align='center' style="margin-top: 20px;">
                    <button 'onclick="carregarModalEntrada()" type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                </div> -->

                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5>Itens Entrada</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="span12" id="divCadastrarOs">
                                                <div class="widget-box" style="margin-top:0px">
                                                    <table id="tableEntrada" class="table table-bordered ">
                                                        <tbody>

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
        </div>

        <!--
        <div class="tab-pane" id="tab3">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Saída</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                    <div class="tab-pane active">
                                        <form name="formSaida" id="formSaida">
                                            <div class="span12" id="divCadastrarOs">
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                                        <input type="text" class="span12" value="" name="idOrcamento" id="idOrcamento" />
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">O.S.: </label>
                                                        <input type="text" class="span12" value="" name="idOs" id="idOs"/>
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                                        <input type="text" class="span12" value="" name="pn" id="pn"/>
                                                        <input type="hidden" class="span12" value="" name="idControleEtapa" id="idControleEtapa" />
                                                    </div>
                                                    <div class="span3" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Descrição: </label>
                                                        <input type="text" class="span12" value="" name="descricaoItem" id="descricaoItem"/>
                                                    </div>
                                                </div>
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span2" class="control-group">
                                                        <a onclick="procurarSaida()" class="btn btn-success"><i class="icon-white"></i>Procurar</a>
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
            <form action="<?php echo base_url() ?>index.php/controle/getDetailProduto2" method="post" target="_blank">
                <div align='center' style="margin-top: 20px;">
                    <button 'onclick="carregarModalEntrada()" type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                </div>
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5>Itens Saída</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="span12" id="divCadastrarOs">
                                                <div class="widget-box" style="margin-top:0px">
                                                    <table id="tableSaida" class="table table-bordered ">                                                    
                                                        <tbody>

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
        </div> -->
        <div class="tab-pane" id="tab3">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Saída</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                    <div class="tab-pane active">
                                        <form name="formSaida" id="formSaida">
                                            <div class="span12" id="divCadastrarOs">
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                                        <input type="text" class="span12" value="" name="idOrcamento" id="idOrcamento" />
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">O.S.: </label>
                                                        <input type="text" class="span12" value="" name="idOs" id="idOs"/>
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                                        <input type="text" class="span12" value="" name="pn" id="pn"/>
                                                        <input type="hidden" class="span12" value="" name="idControleEtapa" id="idControleEtapa" />
                                                    </div>
                                                    <div class="span3" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Descrição: </label>
                                                        <input type="text" class="span12" value="" name="descricaoItem" id="descricaoItem"/>
                                                    </div>
                                                </div>
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span2" class="control-group">
                                                        <a onclick="procurarSaida()" class="btn btn-success"><i class="icon-white"></i>Procurar</a>
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
            <form action="<?php echo base_url() ?>index.php/controle/getDetailProduto2" method="post" target="_blank">
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5>Itens Saída</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="span12" id="divCadastrarOs">
                                                <div class="widget-box" style="margin-top:0px">
                                                    <table id="tableSaida" class="table table-bordered ">                                                    
                                                        <tbody>

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
        </div>
        <div class="tab-pane active" id="tab4">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Recebimento</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                    <div class="tab-pane active">
                                        <form  name="formRecebimento" id="formRecebimento">
                                            <div class="span12" id="divCadastrarOs">
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                                        <input type="text" class="span12" value="" id="idOrcamento"  name="idOrcamento"/>
                                                    </div>
                                                    <div class="span2" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Orçamento Item: </label>
                                                        <input type="text" class="span12" value="" id="idOrcamentoItem"  name="idOrcamentoItem"/>
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">O.S.: </label>
                                                        <input type="text" class="span12" value=""  id="idOs"  name="idOs"/>
                                                    </div>
                                                    <div class="span1" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                                        <input type="text" class="span12" value=""  id="pn"  name="pn"/>
                                                    </div>
                                                    <div class="span3" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Descrição: </label>
                                                        <input type="text" class="span12" value=""  id="descricaoOrc" name="descricaoOrc"/>
                                                    </div>
                                                    <div class="span3" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Status Desenho: </label>
                                                        <select class="span12 form-control"  id="statusDesenho" name="statusDesenho">
                                                            <option value=""></option>
                                                            <option value="1">Aguardando Desenho</option>
                                                            <option value="2">Incompleto</option>
                                                            <option value="3">Finalizado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                    <div class="span2" class="control-group">
                                                        <a type="submit" class="btn btn-success" onclick="carregarItensRecebimento()"><i class="icon-white"></i>Filtrar</a>
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
                            <h5>Itens à receber</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table id="tableRecebimento" class="table table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº Orçamento</th>
                                                            <th>NF</th>
                                                            <th>Cliente</th>
                                                            <th>Data orçamento</th>
                                                            <th>Previsão Chegada</th>
                                                            <th>Itens</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                                                                                                        
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

        <div class="tab-pane" id="tab5">
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
                                        <form  name="formCancelados" id="formCancelados">
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
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Itens cancelados</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table id="tableCancelado" class="table table-bordered ">                                                    
                                                    <tbody>

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
    </div>
</div>


<div id="modal-adicionaritem" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formAdicionar">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Adicionar item para controle</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span2">
                    <label for="cliente" class="control-label">Orçamento:</label>
                    <input class="span12" class="form-control" id="idOrcamento" type="text" name="idOrcamento" value="" />
                </div>
                <div class="span2">
                    <label for="cliente" class="control-label">O.S.:</label>
                    <input class="span12" class="form-control" id="idOs" type="text" name="idOs" value="" />
                </div>
                <div class="span2">
                    <label for="cliente" class="control-label">PN:</label>
                    <input class="span12" class="form-control" id="pn" type="text" name="pn" value="" />
                    <input id="idPn" type="hidden" name="idPn" value="" />
                </div>
                <div class="span3">
                    <label for="cliente" class="control-label">Descrição Item:</label>
                    <input class="span12" class="form-control" id="descricaoItem" type="text" name="descricaoItem" value="" />
                </div>
                <div class="span1">
                    <label for="cliente" class="control-label">Qtd.:</label>
                    <input class="span12" class="form-control" id="qtd" type="text" name="qtd" value="" />
                </div>
                <div class="span2">
                    <label for="cliente" class="control-label">Local:</label>
                    <input class="span12" class="form-control" id="local" type="text" name="local" value="" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" onclick="cadastrarItem()">Adicionar</a>
        </div>
    </form>
</div>

<div id="modal-editaritem" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formEditar">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Editar item.</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span1">
                    <label for="cliente" class="control-label">Orç.:</label>
                    <input class="span12" class="form-control" readonly id="idOrcamento" type="text" name="idOrcamento" value="" />
                </div>
                <div class="span1">
                    <label for="cliente" class="control-label">O.S.:</label>
                    <input class="span12" class="form-control" readonly id="idOs" type="text" name="idOs" value="" />
                </div>
                
                <div class="span2">
                    <label for="cliente" class="control-label">NF Cliente:</label>
                    <input class="span12" class="form-control" id="nf_cliente" type="text" name="nf_cliente" value="" />
                </div>
                <div class="span2">
                    <label for="cliente" class="control-label">PN:</label>
                    <input class="span12" class="form-control" readonly id="pn" type="text" name="pn" value="" />
                    <input id="idControleEtapa" type="hidden" name="idControleEtapa" value="" />
                </div>
                <div class="span3">
                    <label for="cliente" class="control-label">Descrição Item:</label>
                    <input class="span12" class="form-control" readonly id="descricaoItem" type="text" name="descricaoItem" value="" />
                </div>
                <div class="span1">
                    <label for="cliente" class="control-label">Qtd.:</label>
                    <input class="span12" class="form-control" id="qtd" readonly type="text" name="qtd" value="" />
                </div>
                <div class="span2">
                    <label for="cliente" class="control-label">Local:</label>
                    <input class="span12" class="form-control" id="local" type="text" name="local" value="" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" onclick="editaritem()">Salvar</a>
        </div>
    </form>
</div>

<div id="modal-editaritemfilho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formEditarFilho">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Editar item.</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span2">
                    <label for="cliente" class="control-label">Sub O.S.:</label>
                    <input class="span12" class="form-control" readonly id="subOs" type="text" name="subOs" value="" />
                </div>
                <div class="span2">
                    <label for="cliente" class="control-label">PN:</label>
                    <input class="span12" class="form-control" readonly id="pn" type="text" name="pn" value="" />
                    <input id="idControleEtapaSubitem" type="hidden" name="idControleEtapaSubitem" value="" />
                </div>
                <div class="span4">
                    <label for="cliente" class="control-label">Descrição Item:</label>
                    <input class="span12" class="form-control" id="descricaoItem" type="text" name="descricaoItem" value="" />
                </div>
                <div class="span1">
                    <label for="cliente" class="control-label">Qtd.:</label>
                    <input class="span12" class="form-control" id="qtd" readonly type="text" name="qtd" value="" />
                </div>
                <div class="span3">
                    <label for="cliente" class="control-label">Local:</label>
                    <input class="span12" class="form-control" id="local" type="text" name="local" value="" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" onclick="editarsubitem()">Salvar</a>
        </div>
    </form>
</div>

<div id="modal-atualizarstatus" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formAtualizar">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Atualizar etapa do item.</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span1">
                    <label for="cliente" class="control-label">Qtd.:</label>
                    <input class="span12" class="form-control" id="qtd" type="text" name="qtd" value="" />
                    <input id="idControleEtapa" type="hidden" name="idControleEtapa" value="" />
                </div>
                <div class="span4">
                    <label for="idGrupoServico" class="control-label">Etapa serviço: </label>
                    <select class="span12 form-control" id="statusServico">
                        <?php foreach ($statusEtapa as $r) {
                            echo '<option value="' . $r->idStatusEtapasServico . '">' . $r->descricaoStatusEtapaServico . '</option>';
                        } ?>
                    </select>
                </div>
                <div class="span5">
                    <label for="cliente" class="control-label">Usuário:</label>
                    <input class="span12" class="form-control" id="usuario" type="text" name="usuario" value="" />
                    <input id="idUser" type="hidden" name="idUser" value="" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" onclick="atualizarItem()">Salvar</a>
        </div>
        <div class="modal-body" style="padding:0px">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box" style="margin-top:0px">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Histórico Etapa</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">
                                            <div class="widget-box" style="margin-top:0px">
                                                <table id="tableHistStatus" class="table table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th>Data</th>
                                                            <th>Etapa</th>
                                                            <th>Usuário Etapa</th>
                                                            <th>Usuário Sistema</th>
                                                            <th>Assinatura</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-atualizarstatusfilho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formAtualizarFilho">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Atualizar etapa do item.</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span1">
                    <label for="cliente" class="control-label">Qtd.:</label>
                    <input class="span12" class="form-control" id="qtd" type="text" name="qtd" value="" />
                    <input id="idControleEtapaSubitem" type="hidden" name="idControleEtapaSubitem" value="" />
                </div>
                <div class="span4">
                    <label for="idGrupoServico" class="control-label">Etapa serviço: </label>
                    <select class="span12 form-control" id="statusServico">
                        <?php foreach ($statusEtapa as $r) {
                            echo '<option value="' . $r->idStatusEtapasServico . '">' . $r->descricaoStatusEtapaServico . '</option>';
                        } ?>
                    </select>
                </div>
                <div class="span5">
                    <label for="cliente" class="control-label">Usuário:</label>
                    <input class="span12" class="form-control" id="usuario" type="text" name="usuario" value="" />
                    <input id="idUser" type="hidden" name="idUser" value="" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" onclick="atualizarSubitem()">Salvar</a>
        </div>
        <div class="modal-body" style="padding:0px">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box" style="margin-top:0px">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Histórico Etapa</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">
                                            <div class="widget-box" style="margin-top:0px">
                                                <table id="tableHistStatusFilho" class="table table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th>Data</th>
                                                            <th>Etapa</th>
                                                            <th>Usuário Etapa</th>
                                                            <th>Usuário Sistema</th>
                                                            <th>Assinatura</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-observacao" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formObservacoes">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Adicionar Observação</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span12">
                    <label for="cliente" class="control-label">Observação.:</label>
                    <textarea class="span12" id="observacoes" style="resize:none;height: 150px;"></textarea>
                    <input id="idControleEtapa" type="hidden" name="idControleEtapa" value="" />
                    <input id="vObservacao2" type="hidden" name="vObservacao2" value="" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" onclick="salvarObservacao()">Salvar</a>
        </div>
        <div class="modal-body" style="padding:0px">
            <div class="span12">
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box" style="margin-top:0px">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-list-alt"></i>
                                </span>
                                <h5>Observações</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <div id="vObservacao" style="margin:35px;word-wrap: break-word">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-observacaofilho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formObservacoesFilho">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Adicionar Observação</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span12">
                    <label for="cliente" class="control-label">Observação.:</label>
                    <textarea class="span12" id="observacoes" style="resize:none;height: 150px;"></textarea>
                    <input id="idControleEtapaSubitem" type="hidden" name="idControleEtapaSubitem" value="" />
                    <input id="vObservacaoSubitem2" type="hidden" name="vObservacaoSubitem2" value="" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" onclick="salvarObservacaoSubitem()">Salvar</a>
        </div>
        <div class="modal-body" style="padding:0px">
            <div class="span12">
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box" style="margin-top:0px">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-list-alt"></i>
                                </span>
                                <h5>Observações</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <div id="vObservacaoSubitem" style="margin:35px;word-wrap: break-word">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-modalentrada" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formModelEntrada" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Entrada de produtos</h5>
        </div>
        <div  class="modal-body">
            <div class="span12">
                <div class="span4">
                    <label>Etapa:</label>
                    <select>
                        <option value="">Todos</option>
                        <?php foreach ($statusEtapa as $r) {
                            echo '<option value="' . $r->idStatusEtapasServico . '">' . $r->descricaoStatusEtapaServico . '</option>';
                        } ?>
                    </select>
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" 'onclick="salvarObservacaoSubitem()">Salvar</a>
        </div>
    </form>
</div>


<script type="text/javascript">

    function openclose(td, valor) {
        var tr = document.querySelector(".trfilho" + valor);

        if (tr.style.display == "table-row" || tr.style.display == "") {
            $(".trfilho" + valor).hide('fast');
            $(td).parent('tr').css('background-color', '');
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");
        } else {
            $(".trfilho" + valor).show('fast');
            $(td).parent('tr').css('background-color', '#efefef');
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }
    }

    function opencloseNeto(td, valor) {
        var tr = document.querySelector(".trneto" + valor);

        if (tr.style.display == "table-row" || tr.style.display == "") {
            $(".trneto" + valor).hide('fast');
            $(td).parent('tr').css('background-color', '');
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");
        } else {
            $(".trneto" + valor).show('fast');
            $(td).parent('tr').css('background-color', '#efefef');
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }
    }

    function cadastrarItem() {
        var idOrc = $("#formAdicionar #idOrcamento").val();
        var idOs = $("#formAdicionar #idOs").val();
        var idProduto = $("#formAdicionar #idPn").val();
        var descricaoItem = $("#formAdicionar #descricaoItem").val();
        var qtd = $("#formAdicionar #qtd").val();
        var local = $("#formAdicionar #local").val();
        if (idProduto == null || idProduto == "" || descricaoItem == null || descricaoItem == "" || qtd == null) {
            alert("PN, descrição e quantidade são obrigatórios.");
            return;
        }
        $("#formAdicionar #idOrcamento").val("");
        $("#formAdicionar #idOs").val("");
        $("#formAdicionar #idPn").val("");
        $("#formAdicionar #descricaoItem").val("");
        $("#formAdicionar #qtd").val("");
        $("#formAdicionar #local").val("");
        $("#modal-adicionaritem").modal('hide');
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/cadastrarItemControle",
            type: 'POST',
            dataType: 'json',
            data: {
                idOrcamento: idOrc,
                idOs: idOs,
                idPn: idProduto,
                descricaoItem: descricaoItem,
                qtd: qtd,
                local: local
            },
            success: function(data) {
                carregarItens();

                alert("Item adicionado com sucesso");
            },
            error: function(xhr, textStatus, error) {
                alert("Erro ao adicionar o item. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })

    }

    function carregarItensCancelado(){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/carregarItensCancelado",
            type: 'POST',
            dataType: 'json',
            data: {
            },
            success: function(data) {
                atualizarTabelaCancelados(data.obj)
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function carregarItens(limite) {
        var idOrc = $("#formFiltrar #idOrcamento").val();
        var idOs = $("#formFiltrar #idOs").val();
        var pn = $("#formFiltrar #pn").val();
        var descricaoItem = $("#formFiltrar #descricaoItem").val();
        var statusServico = $("#formFiltrar #statusServico").val();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/carregarItens",
            type: 'POST',
            dataType: 'json',
            data: {
                idOrcamento: idOrc,
                idOs: idOs,
                pn: pn,
                descricaoItem: descricaoItem,
                statusServico: statusServico,
                limite: limite
            },
            success: function(data) {
                atualizarTabelaLista(data.obj)
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function carregarItensRecebimento(limite){
        var idOrc = $("#formRecebimento #idOrcamento").val();
        var idOs = $("#formRecebimento #idOs").val();
        var pn = $("#formRecebimento #pn").val();
        var descricaoItem = $("#formRecebimento #descricaoItem").val();
        var statusServico = $("#formRecebimento #statusServico").val();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/carregarItensRecebimento",
            type: 'POST',
            dataType: 'json',
            data: {
                idOrcamento: idOrc,
                idOs: idOs,
                pn: pn,
                descricaoItem: descricaoItem,
                statusServico: statusServico,
                limite: limite
            },
            success: function(data) {
                atualizarTabelaRecebimento(data.obj)
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function carregarItensEntrada(limite){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/carregarItensEntrada",
            type: 'POST',
            dataType: 'json',
            data: {
            },
            success: function(data) {
                atualizarTabelaEntrada(data.obj)
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function carregarItensSaida(limite){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/carregarItensSaida",
            type: 'POST',
            dataType: 'json',
            data: {
            },
            success: function(data) {
                atualizarTabelaSaida(data.obj)
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function atualizarTabelaCancelados(itens){
        var html = "";
        for(x=0;x<itens.length;x++){
            html += '<tr>';
            html += '<td>' + itens[x].idOrcamentos + '</td>';
            html += '<td>' + itens[x].nomeCliente + '</td>';
            html += '<td>' + itens[x].data_abertura + '</td>';
            html += '<td> ';
            html += '<div>';
            html += '<table  class="table table-bordered " style="background-color: #f9f9f9;">';
            var count = 1;
            for(y=0;y<itens[x].orcItem.length;y++){
                ositem = "";
                
                html += '<tr>';
                html += '<td style="border-left: 0px;padding: 0px;border-top: 0px;">';
                if(itens[x].orcItem[y].idOs){
                    ositem = "<font color='red'><b> OS:</b>" + itens[x].orcItem[y].idOs + "</font>";
                }
                html += "<b>" + count + "- </b>" + itens[x].orcItem[y].descricao_item + ositem +"<br>";
                html += '</td>';
                html += '<td style="border-left: 0px;border-top: 0px;padding: 0px;width:200px">';
                    html += itens[x].orcItem[y].descricaoStatusEtapaServico;
                html += '</td>';
                count++;
                html += '</tr>';
            }
            html += '</table>';
            html += '</div>';
            html += '</td>';

            html += '<td>';
            //html += '<a href="<?php echo base_url();?>index.php/controle/saida2/' + itens[x].idOrcamentos + '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
            html += '</td>';
            html += '</tr>';
        }
        $('#tableCancelado tbody').empty();
        $("#tableCancelado tbody").append(html);
    }

    function atualizarTabelaRecebimento(itens){
        var html = "";
        for(x=0;x<itens.length;x++){

            html += '<tr>';
            html += '<td>' + itens[x].idOrcamentos + '</td>';
            html += '<td>' + itens[x].num_nf + '</td>';
            html += '<td>' + itens[x].nomeCliente + '</td>';
            if(itens[x].data_abertura != "" && itens[x].data_abertura != null){
                data_abertura = new Date(itens[x].data_abertura) .toLocaleString("pt-BR")
                html += '<td>' + data_abertura+ '</td>';
            }else{
                html += '<td></td>';
            }
            
            if(itens[x].data_previsao_chegada != "" && itens[x].data_previsao_chegada != null){
                data_chegada = new Date(itens[x].data_previsao_chegada) .toLocaleString("pt-BR")
                html += '<td>' + data_chegada + '</td>';
            }else{
                html += '<td></td>';
            }
            html += '<td> ';

            var count = 1;
            for(y=0;y<itens[x].orcItem.length;y++){
                ositem = "";
                if(itens[x].orcItem[y].idOs){
                    ositem = "<font color='red'><b> OS:</b>" + itens[x].orcItem[y].idOs + "</font>";
                }
                html += "<b>" + count + "- </b>" + itens[x].orcItem[y].descricao_item + ositem +"<br>";
                count++;
            }

            html += '</td>';

            html += '<td>';
            html += '<a href="<?php echo base_url();?>index.php/controle/recebimento/' + itens[x].idOrcamentos + '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
            html += '</td>';
            html += '</tr>';
        }
        $('#tableRecebimento tbody').empty();
        $("#tableRecebimento tbody").append(html)
    }

    function atualizarTabelaEntrada(itens){
        var html = "";
        for(x=0;x<itens.length;x++){
            html += '<tr>';
            html += '<td>' + itens[x].idOrcamentos + '</td>';
            html += '<td>' + itens[x].nomeCliente + '</td>';
            if(itens[x].data_abertura != "" && itens[x].data_abertura != null){
                data_abertura = new Date(itens[x].data_abertura).toLocaleString("pt-BR");
                html += '<td>' + data_abertura + '</td>';
            }else{
                html += '<td></td>';
            }
            
            html += '<td> ';
            html += '<div>';
            html += '<table  class="table table-bordered " style="background-color: #f9f9f9;">';
            var count = 1;
            for(y=0;y<itens[x].orcItem.length;y++){
                ositem = "";
                
                html += '<tr>';
                html += '<td style="border-left: 0px;padding: 0px;border-top: 0px;">';
                if(itens[x].orcItem[y].idOs){
                    ositem = "<font color='red'><b> OS:</b>" + itens[x].orcItem[y].idOs + "</font>";
                }
                html += "<b>" + count + "- </b>" + itens[x].orcItem[y].descricao_item + ositem +"<br>";
                html += '</td>';
                html += '<td style="border-left: 0px;border-top: 0px;padding: 0px;width:200px">';
                    html += itens[x].orcItem[y].descricaoStatusEtapaServico;
                html += '</td>';
                count++;
                html += '</tr>';
            }
            html += '</table>';
            html += '</div>';
            html += '</td>';

            html += '<td>';
            html += '<a href="<?php echo base_url();?>index.php/controle/entrada2/' + itens[x].idOrcamentos + '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
            html += '</td>';
            html += '</tr>';
        }
        $('#tableEntrada tbody').empty();
        $("#tableEntrada tbody").append(html);
    }

    function atualizarTabelaSaida(itens){
        var html = "";
        for(x=0;x<itens.length;x++){
            html += '<tr>';
            html += '<td>' + itens[x].idOrcamentos + '</td>';
            html += '<td>' + itens[x].nomeCliente + '</td>';
            if(itens[x].data_abertura != "" && itens[x].data_abertura != null){
                data_abertura = new Date(itens[x].data_abertura).toLocaleString("pt-BR");
                html += '<td>' + data_abertura + '</td>';
            }else{
                html += '<td></td>';
            }
            html += '<td> ';
            html += '<div>';
            html += '<table  class="table table-bordered " style="background-color: #f9f9f9;">';
            var count = 1;
            for(y=0;y<itens[x].orcItem.length;y++){
                ositem = "";
                html += '<tr>';
                html += '<td style="border-left: 0px;padding: 0px;border-top: 0px;">';
                if(itens[x].orcItem[y].idOs){
                    ositem = "<font color='red'><b> OS:</b>" + itens[x].orcItem[y].idOs + "</font>";
                }
                html += "<b>" + count + "- </b>" + itens[x].orcItem[y].descricao_item + ositem +"<br>";
                html += '</td>';
                html += '<td style="border-left: 0px;border-top: 0px;padding: 0px;width:200px">';
                    html += itens[x].orcItem[y].descricaoStatusEtapaServico;
                html += '</td>';
                count++;
                html += '</tr>';
            }
            html += '</table>';
            html += '</div>';
            html += '</td>';

            html += '<td>';
            html += '<a href="<?php echo base_url();?>index.php/controle/saida2/' + itens[x].idOrcamentos + '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
            html += '</td>';
            html += '</tr>';
        }
        $('#tableSaida tbody').empty();
        $("#tableSaida tbody").append(html);
    }

    function atualizarTabelaLista(itensLista) {
        var html = "";
        var formatter = new Intl.DateTimeFormat('pt-BR');
        for (x = 0; x < itensLista.length; x++) {
            html += '<tr class="trpai' + itensLista[x].idControleEtapa + '">';
            if(itensLista[x].filhos.length>0)
                html += '<td onclick="openclose(this,' + itensLista[x].idControleEtapa + ')" style="text-align: center;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';
            else
                html += '<td></td>';
            html += '<td>';
            data = new Date(itensLista[x].data_cadastro)
            html += formatter.format(data);
            html += '</td>';
            html += '<td>';
            if (itensLista[x].idOrcamento)
                html += itensLista[x].idOrcamento
            html += '</td>';
            html += '<td>';
            if (itensLista[x].idOs)
                html += itensLista[x].idOs
            html += '</td>';
            html += '<td>';
            html += itensLista[x].pn
            html += '</td>';
            html += '<td>';
                html += itensLista[x].descricaoItem
            html += '</td>';
            html += '<td>';
            html += itensLista[x].quantidade
            html += '</td>';
            html += '<td>';
            html += itensLista[x].descricaoStatusEtapaServico
            html += '</td>';
            html += '<td>';
            if (itensLista[x].local)
                html += itensLista[x].local
            html += '</td>';
            html += '<td>';
            if (itensLista[x].nomeUser)
                html += itensLista[x].nomeUser
            html += '</td>';
            html += '<td>';
            html += '<a onclick="abrirAtualizar(' + itensLista[x].idControleEtapa + ')" style="margin-right: 3%" class="btn btn-success"><i class="icon-refresh icon-white"></i></a>';
            html += '<a onclick="abrirEditar(' + itensLista[x].idControleEtapa + ')" style="margin-right: 3%" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>';
            html += '<a onclick="abrirObservacao(' + itensLista[x].idControleEtapa + ')" style="margin-right: 3%" class="btn tip-top"><i class="icon-list-alt icon-black"></i></a>';
            html += '</td>';
            html += '</tr>';
            html += '<tr class="trfilho' + itensLista[x].idControleEtapa + '" style="display:none">';
            if (itensLista[x].filhos.length > 0) {
                html += '<td colspan=11 style="background-color: #efefef;padding-top: 0px;">';
                html += '<div style="margin: 20px;margin-top: 0px;">';
                html += '<table class="table table-bordered ">';
                html += '<thead>';
                html += '<th>Data cad.:</th>';
                html += '<th>Sub O.S.</th>';
                html += '<th>PN</th>';
                html += '<th>Descrição</th>';
                html += '<th>Qtd</th>';
                html += '<th>Etapa</th>';
                html += '<th>Local</th>';
                html += '<th>Usuário</th>';
                html += '<th>Funções</th>';
                html += '</thead>';
                html += '<tbody>';
                for (y = 0; y < itensLista[x].filhos.length; y++) {
                    html += '<tr>';
                    html += '<td>';
                    data2 = new Date(itensLista[x].filhos[y].data_cadastro)
                    html += formatter.format(data2);
                    html += '</td>';
                    html += '<td>';
                    if (itensLista[x].filhos[y].idOs && itensLista[x].filhos[y].posicao)
                        html += itensLista[x].filhos[y].idOs + "." + itensLista[x].filhos[y].posicao;
                    html += '</td>';
                    html += '<td>';
                    html += itensLista[x].filhos[y].pn;
                    html += '</td>';
                    html += '<td>';
                    html += itensLista[x].filhos[y].descricaoItem;
                    html += '</td>';
                    html += '<td>';
                    html += itensLista[x].filhos[y].quantidade;
                    html += '</td>';
                    html += '<td>';
                    html += itensLista[x].filhos[y].descricaoStatusEtapaServico;
                    html += '</td>';
                    html += '<td>';
                    if (itensLista[x].filhos[y].local)
                        html += itensLista[x].filhos[y].local;
                    html += '</td>';
                    html += '<td>';
                    if (itensLista[x].filhos[y].nomeUser)
                        html += itensLista[x].filhos[y].nomeUser;
                    html += '</td>';
                    html += '<td>';
                    html += '<a onclick="abrirAtualizarFilho(' + itensLista[x].filhos[y].idControleEtapaSubitem + ')" style="margin-right: 3%" class="btn btn-success"><i class="icon-refresh icon-white"></i></a>';
                    html += '<a onclick="abrirEditarFilho(' + itensLista[x].filhos[y].idControleEtapaSubitem + ')" style="margin-right: 3%" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>';
                    html += '<a onclick="abrirObservacaoFilho(' + itensLista[x].filhos[y].idControleEtapaSubitem + ')" style="margin-right: 3%" class="btn tip-top"><i class="icon-list-alt icon-black"></i></a>';
                    html += '</td>';
                    html += '</tr>';
                }
                html += '</tbody>';
                html += '</table>';
                html += '</div>';
                html += '</td>';
            }
            html += '</tr>';

        }

        $('#tableItens tbody').empty();
        $("#tableItens tbody").append(html)

    }

    function abrirEditar(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/getControleById",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapa: id
            },
            success: function(data) {
                atualizarModalEditar(data.obj);
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function atualizarModalEditar(item) {
        $("#formEditar #idControleEtapa").val(item.idControleEtapa);
        $("#formEditar #idOs").val(item.idOs);
        $("#formEditar #idOrcamento").val(item.idOrcamento);
        $("#formEditar #pn").val(item.pn);
        $("#formEditar #descricaoItem").val(item.descricaoItem);
        $("#formEditar #qtd").val(item.quantidade);
        $("#formEditar #local").val(item.local);
        $("#formEditar #nf_cliente").val(item.nf_cliente);

        $("#modal-editaritem").modal('show');

    }

    function editaritem() {
        $("#modal-editaritem").modal('hide');
        console.log($("#formEditar #local").val())
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/editaritem",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapa: $("#formEditar #idControleEtapa").val(),
                idOs: $("#formEditar #idOs").val(),
                idOrcamento: $("#formEditar #idOrcamento").val(),
                pn: $("#formEditar #pn").val(),
                descricaoItem: $("#formEditar #descricaoItem").val(),
                nf_cliente: $("#formEditar #nf_cliente").val(),
                local: $("#formEditar #local").val()

            },
            success: function(data) {
                if (data.result) {
                    carregarItens();
                    alert(data.msg)
                } else {
                    alert(data.msg)
                }
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function abrirAtualizar(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/getControleById",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapa: id
            },
            success: function(data) {
                atualizarModalAtualizar(data.obj);
            },
            error: function(xhr, textStatus, error) {
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function atualizarModalAtualizar(item) {
        $("#formAtualizar #idControleEtapa").val(item.idControleEtapa);
        //$("#formAtualizar #idOs").val(item.idOs);
        //$("#formAtualizar #idOrcamento").val(item.idOrcamento);
        //$("#formAtualizar #pn").val(item.pn);
        //$("#formAtualizar #descricaoItem").val(item.descricaoItem);
        $("#formAtualizar #qtd").val(item.quantidade);
        $("#formAtualizar #statusServico").val(item.idStatusEtapaServico);
        var html = "";
        var formatter = new Intl.DateTimeFormat('pt-BR');
        for (x = 0; x < item.historicoStatus.length; x++) {

            html += "<tr>";
            html += "<td>";
            data = new Date(item.historicoStatus[x].data_alteracao)
            html += formatter.format(data);
            html += "</td>";
            html += "<td>";
            html += item.historicoStatus[x].descricaoStatusEtapaServico
            html += "</td>";
            html += "<td>";
            if (item.historicoStatus[x].nome) {
                html += item.historicoStatus[x].nome;
            }
            html += "</td>";
            html += "<td>";
            if (item.historicoStatus[x].sisnome) {
                html += item.historicoStatus[x].sisnome;
            }
            html += "</td>";
            html += "<td>";
            if (item.historicoStatus[x].assinatura) {
                html += '<a href="<?php echo base_url();?>'+item.historicoStatus[x].assinatura+'" target="_blank" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
            }
            html += "</td>";
            html += "</tr>";
        }
        $('#tableHistStatus tbody').empty();
        $("#tableHistStatus tbody").append(html);
        $("#modal-atualizarstatus").modal('show');
    }
    
    function atualizarItem() {
        $("#modal-atualizarstatus").modal('hide');
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/atualizaritem",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapa: $("#formAtualizar #idControleEtapa").val(),
                qtd: $("#formAtualizar #qtd").val(),
                statusServico: $("#formAtualizar #statusServico").val(),
                idUser: $("#formAtualizar #idUser").val()

            },
            success: function(data) {
                if (data.result) {
                    carregarItens();
                    alert(data.msg)
                } else {
                    alert(data.msg)
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
    }

    function abrirObservacao(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/getControleById",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapa: id
            },
            success: function(data) {
                atualizarModalObservacao(data.obj);
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function atualizarModalObservacao(item) {
        $("#formObservacoes #idControleEtapa").val(item.idControleEtapa);
        $("#formObservacoes #vObservacao2").val(item.observacao);
        $("#vObservacao").empty();
        $("#vObservacao").append(item.observacao);
        $("#modal-observacao").modal('show');
    }

    function salvarObservacao() {
        var observacao = $("#formObservacoes #observacoes").val();
        var vObservacao2 = $("#formObservacoes #vObservacao2").val();
        if (observacao == null || observacao == "") {
            alert("O campo observação não foi preenchido")
            return
        }
        $("#modal-observacao").modal('hide');
        var idControleEtapa = $("#formObservacoes #idControleEtapa").val();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/salvarobservacao",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapa: idControleEtapa,
                observacao: observacao,
                vObservacao2: vObservacao2
            },
            success: function(data) {
                alert("Observação cadastrada com sucesso.");
                $("#vObservacao").empty();
                $("#formObservacoes #idControleEtapa").val("");
                $("#formObservacoes #vObservacao2").val("");
                $("#formObservacoes #observacoes").val("");
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },

        })

    }

    function abrirAtualizarFilho(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/getControleSubitemById",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapaSubitem: id
            },
            success: function(data) {
                atualizarModalAtualizarFilho(data.obj);
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function atualizarModalAtualizarFilho(item) {
        $("#formAtualizarFilho #idControleEtapaSubitem").val(item.idControleEtapaSubitem);
        //$("#formAtualizar #idOs").val(item.idOs);
        //$("#formAtualizar #idOrcamento").val(item.idOrcamento);
        //$("#formAtualizar #pn").val(item.pn);
        //$("#formAtualizar #descricaoItem").val(item.descricaoItem);
        $("#formAtualizarFilho #qtd").val(item.quantidade);
        $("#formAtualizarFilho #statusServico").val(item.idStatusEtapaServico);
        var html = "";
        var formatter = new Intl.DateTimeFormat('pt-BR');
        for (x = 0; x < item.historicoStatus.length; x++) {
            html += "<tr>";
                html += "<td>";
                data = new Date(item.historicoStatus[x].data_alteracao)
                html += formatter.format(data);
                html += "</td>";
                html += "<td>";
                html += item.historicoStatus[x].descricaoStatusEtapaServico
                html += "</td>";
                html += "<td>";
                if (item.historicoStatus[x].nome) {
                    html += item.historicoStatus[x].nome;
                }
                html += "</td>";
                html += "<td>";
                if (item.historicoStatus[x].sisnome) {
                    html += item.historicoStatus[x].sisnome;
                }
                html += "</td>";
                html += "<td>";
                if (item.historicoStatus[x].assinatura) {
                    html += '<a href="<?php echo base_url();?>'+item.historicoStatus[x].assinatura+'" target="_blank" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
                }
                html += "</td>";
            html += "</tr>";
        }
        $('#tableHistStatusFilho tbody').empty();
        $("#tableHistStatusFilho tbody").append(html);
        $("#modal-atualizarstatusfilho").modal('show');
    }

    function atualizarSubitem() {
        $("#modal-atualizarstatusfilho").modal('hide');
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/atualizarsubitem",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapaSubitem: $("#formAtualizarFilho #idControleEtapaSubitem").val(),
                qtd: $("#formAtualizarFilho #qtd").val(),
                statusServico: $("#formAtualizarFilho #statusServico").val(),
                idUser: $("#formAtualizarFilho #idUser").val()

            },
            success: function(data) {
                if (data.result) {
                    carregarItens();
                    alert(data.msg)
                } else {
                    alert(data.msg)
                }
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function abrirEditarFilho(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/getControleSubitemById",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapaSubitem: id
            },
            success: function(data) {
                atualizarModalEditarSubitem(data.obj);
            },
            error: function(xhr, textStatus, error) {
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function atualizarModalEditarSubitem(item) {
        $("#formEditarFilho #idControleEtapaSubitem").val(item.idControleEtapaSubitem);
        $("#formEditarFilho #subOs").val(item.idOs + "." + item.posicao);
        $("#formEditarFilho #pn").val(item.pn);
        $("#formEditarFilho #descricaoItem").val(item.descricaoItem);
        $("#formEditarFilho #qtd").val(item.quantidade);
        $("#formEditarFilho #local").val(item.local);

        $("#modal-editaritemfilho").modal('show');
    }

    function editarsubitem() {
        $("#modal-editaritemfilho").modal('hide');
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/editarsubitem",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapaSubitem: $("#formEditarFilho #idControleEtapaSubitem").val(),
                descricaoItem: $("#formEditarFilho #descricaoItem").val(),
                local: $("#formEditarFilho #local").val()

            },
            success: function(data) {
                if (data.result) {
                    carregarItens();
                    alert(data.msg)
                } else {
                    alert(data.msg)
                }
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function abrirObservacaoFilho(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/getControleSubitemById",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapaSubitem: id
            },
            success: function(data) {
                atualizarModalObservacaoSubitem(data.obj);
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function atualizarModalObservacaoSubitem(item) {
        $("#formObservacoesFilho #idControleEtapaSubitem").val(item.idControleEtapaSubitem);
        $("#formObservacoesFilho #vObservacaoSubitem2").val(item.observacao);
        $("#vObservacaoSubitem").empty();
        $("#vObservacaoSubitem").append(item.observacao);
        $("#modal-observacaofilho").modal('show');
    }

    function salvarObservacaoSubitem() {
        $("#modal-observacaofilho").modal('hide');
        var observacao = $("#formObservacoesFilho #observacoes").val();
        var vObservacao2 = $("#formObservacoesFilho #vObservacaoSubitem2").val();
        if (observacao == null || observacao == "") {
            alert("O campo observação não foi preenchido")
            return
        }
        var idControleEtapaSubitem = $("#formObservacoesFilho #idControleEtapaSubitem").val();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/salvarobservacaosubitem",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapaSubitem: idControleEtapaSubitem,
                observacao: observacao,
                vObservacao2: vObservacao2
            },
            success: function(data) {
                alert("Observação cadastrada com sucesso.");
                $("#vObservacaoSubitem").empty();
                $("#formObservacoesFilho #idControleEtapaSubitem").val("");
                $("#formObservacoesFilho #vObservacaoSubitem2").val("");
                $("#formObservacoesFilho #observacoes").val("");
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },

        })

    }

    function procurarEntrada(){
        var idOrcamento = $("#formEntrada #idOrcamento").val();
        var os = $("#formEntrada #idOs").val();
        var descricaoItem = $("#formEntrada #descricaoItem").val();
        var pn = $("#formEntrada #pn").val();
        var contador = Array.apply(null,document.querySelectorAll("#contador"))

        var listaControleEtapa = "";
        var primeiro = true;
        for(j=0;j<contador.length;j++){
            if(primeiro){
                listaControleEtapa += contador[j].value;
                primeiro=false;
            }else{
                listaControleEtapa += ','+contador[j].value;
            }
        }
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/procurarItens",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idOrcamento: idOrcamento,
                os:os,
                descricaoItem: descricaoItem,
                pn: pn,
                listaControleEtapa: listaControleEtapa

            },
            success: function(data) {
                if (data.result) {
                    if(data.obj.length > 0){
                        atualizarTabelaEntrada(data.obj); 
                    }else{
                        alert("Nenhum resultado encontrado");
                    }
                    
                }                 
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })

    }

    function procurarSaida(){
        var idOrcamento = $("#formSaida #idOrcamento").val();
        var os = $("#formSaida #idOs").val();
        var descricaoItem = $("#formSaida #descricaoItem").val();
        var pn = $("#formSaida #pn").val();
        var contador = Array.apply(null,document.querySelectorAll("#contador2"))

        var listaControleEtapa = "";
        var primeiro = true;
        for(j=0;j<contador.length;j++){
            if(primeiro){
                listaControleEtapa += contador[j].value;
                primeiro=false;
            }else{
                listaControleEtapa += ','+contador[j].value;
            }
        }


        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/procurarItens2",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idOrcamento: idOrcamento,
                os:os,
                descricaoItem: descricaoItem,
                pn: pn,
                listaControleEtapa: listaControleEtapa

            },
            success: function(data) {
                if (data.result) {
                    if(data.obj.length > 0){
                        atualizarTabelaSaida(data.obj); 
                    }else{
                        alert("Nenhum resultado encontrado");
                    }
                    
                }                 
            },
            error: function(xhr, textStatus, error) {
                alert("Falha. Atualize a página e tente novamente.");
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    /*
    function atualizarTabelaEntrada(itens){
        html = "";
        var statusitens = <?php echo json_encode($statusEtapa);?>;
        for(x=0;x<itens.length;x++){
            html += '<tr class="trpai' + itens[x].idControleEtapa + '" style="background-color: #efefef">'+
                '<td onclick="openclose(this,' +itens[x].idControleEtapa+ ')" style="text-align: center;  display: table-cell;min-height: 10em;vertical-align: middle;"><a class="detail-icon" ><i class="fa fa-minus"></i></a></td>'+
                '<td style=" "><div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">'+
                    '<input type="hidden" id="id_orc_item_' +itens[x].idControleEtapa+ '" name="id_orc_item[]"   value="' +itens[x].idOrcamento_item+ '"/>'+
                    '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                        '<div class="span2">'+
                            '<label><b>PN </b> (master):</label>'+
                            '<input readonly type="text" class="span12" id="pn_' +itens[x].idControleEtapa+'" name="pn[]" value="' +itens[x].pn+ '" />' +
                            '<input type="hidden" name="contador[]" id="contador"   value="' +itens[x].idControleEtapa+ '"/>' +
                        '</div>'+
                        '<div class="span1">' +
                            '<label>Orç.:</label>' +
                            '<input readonly type="text" class="span12" id="orc_' + itens[x].idControleEtapa + '" name="orc[]" value="' +itens[x].tipoOrc+ '" />'+
                        '</div>'+
                        '<div class="span5">' +
                            '<label>Descrição:</label>' +
                            '<input type="text" readonly class="span12" id="descricao_item_' + itens[x].idControleEtapa + '" name="descricao_item[]"  value="' + itens[x].descricao_item + '" />' +
                        '</div>' +
                        '<div class="span1">' +
                            '<label>Tag:</label>' +
                            '<input type="text" readonly class="span12" id="tag_' + itens[x].idControleEtapa +  '" name="tag[]"  value="' + itens[x].tag + '" />' +
                        '</div>' +
                        '<div class="span2">' +
                            '<label>Orçamento:</label>' +
                            '<input type="text" class="span12" readonly id="idOrc_' + itens[x].idControleEtapa +  '" name="idOrc[]"  value="' + itens[x].idOrcamento + '" />' +
                            '<input type="hidden" id="idOrcItem_' + itens[x].idControleEtapa +  '" value="' + itens[x].idOrcamento_item + '"'+
                        '</div>' +
                    '</div>'+
                '</div></td>'+
            '</tr>';
            html += '<tr class="trfilho' + itens[x].idControleEtapa + '" style="display:table-row">'+
                '<td>'+
                '</td>'+
                '<td>'+
                    '<div>'+
                            '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                '<table class="table table-bordered " id="tableEntrada_' + itens[x].idControleEtapa + '">'+
                                    '<thead>'+
                                        '<th>'+
                                        '</th>'+
                                        '<th>'+
                                            'PN Master'+
                                        '</th>'+
                                        '<th>'+
                                            'Descrição'+
                                        '</th>'+
                                        '<th>'+
                                            'QTD'+
                                        '</th>'+
                                        '<th>'+
                                            'Etapa'+
                                        '</th>'+
                                        '<th>'+
                                            'Local'+
                                        '</th>'+
                                    '</thead>'+
                                    '<tbody>';
                                        html += '<tr>'+
                                            '<td style="width:30px">'+
                                                '<input type="checkbox" class="entradaPai_'+itens[x].idControleEtapa+'" name="produtoMaster[]" id="produtoMaster" value="'+itens[x].idControleEtapa+'">'+
                                            '</td>'+
                                            '<td style="width:150px">'+
                                                itens[x].pn+
                                            '</td>'+
                                            '<td>'+
                                                itens[x].descricao+
                                            '</td>'+
                                            '<td style="width:50px">'+
                                                itens[x].quantidade+
                                            '</td>'+
                                            '<td style="width:250px">'+
                                                itens[x].descricaoStatusEtapaServico+
                                            '</td>'+
                                            '<td style="width:100px">';
                                                if(itens[x].local)
                                                html += itens[x].local;
                                            html += '</td>'+
                                        '</tr>';
                                    html +='</tbody>'+
                                '</table>'+
                            '</div>'+
                            '<br>'+
                            '<br>';
                            if(itens[x].controleEtapaSubitens){
                                html += '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                    '<div id="escopo_' + itens[x].idControleEtapa + '">'+
                                        '<table class="table table-bordered " id="tableEntrada_' + itens[x].idControleEtapa + '">'+
                                            '<thead>'+
                                                '<th>'+
                                                '</th>'+
                                                '<th>'+
                                                    'PN'+
                                                '</th>'+
                                                '<th>'+
                                                    'Descrição'+
                                                '</th>'+
                                                '<th>'+
                                                    'QTD'+
                                                '</th>'+
                                                '<th>'+
                                                    'Etapa'+
                                                '</th>'+
                                                '<th>'+
                                                    'Local'+
                                                '</th>'+
                                            '</thead>'+
                                            '<tbody>';
                                                for(y=0;y<itens[x].controleEtapaSubitens.length;y++){
                                                    html += '<tr>'+
                                                        '<td style="width:30px">'+
                                                            '<input type="checkbox" class="'+( itens[x].controleEtapaSubitens[y].idStatusEtapaServico == itens[x].idStatusEtapaServico?'entradaFilho_'+itens[x].idControleEtapa:"")+'" name="subItemEntrada[]" id="subItemEntrada" value="'+itens[x].controleEtapaSubitens[y].idControleEtapaSubitem+'">'+
                                                        '</td>'+
                                                        '<td style="width:150px">'+
                                                            itens[x].controleEtapaSubitens[y].pn+
                                                        '</td>'+
                                                        '<td>'+
                                                            itens[x].controleEtapaSubitens[y].descricao+
                                                        '</td>'+
                                                        '<td style="width:50px">'+
                                                            itens[x].controleEtapaSubitens[y].quantidade+
                                                        '</td>'+
                                                        '<td style="width:250px">'+
                                                            itens[x].controleEtapaSubitens[y].descricaoStatusEtapaServico+
                                                        '</td>'+
                                                        '<td style="width:100px">';
                                                            if( itens[x].controleEtapaSubitens[y].local)
                                                                html += itens[x].controleEtapaSubitens[y].local;
                                                        html +='</td>'+
                                                        
                                                    '</tr>';
                                                }
                                                for(y=0;y<itens[x].produtos.length;y++){
                                                    html += '<tr>'+
                                                        '<td style="width:30px">'+
                                                            '<input type="checkbox" name="cadastrarNovoSubItem[]" id="cadastrarNovoSubItem" value="'+itens[x].produtos[y].idProdutos+'_'+itens[x].idOrcamento_item+'_'+itens[x].idControleEtapa+'">'+
                                                        '</td>'+
                                                        '<td style="width:150px">'+
                                                            itens[x].produtos[y].pn+
                                                        '</td>'+
                                                        '<td>'+
                                                            itens[x].produtos[y].descricao+
                                                        '</td>'+
                                                        '<td style="width:50px">'+
                                                        '0'+
                                                        '</td>'+
                                                        '<td style="width:250px">'+
                                                            'Não possuí cadastro.'+
                                                        '</td>'+
                                                        '<td style="width:100px">'+
                                                        
                                                        '</td>'+
                                                        
                                                    '</tr>';
                                                }
                                            html +='</tbody>'+
                                        '</table>'+
                                    '</div>'+
                                '</div>';
                            }
                    html += '</div>'+
                '</td>'+
            '</tr>';
            html += "<script type=\'text/javascript\'>"+
            "$(\'.entradaPai_"+itens[x].idControleEtapa+"\').change(function () {"+
                'if($(this).is(":checked")){'+
                    '$( \".entradaFilho_'+itens[x].idControleEtapa+' \").prop( "checked", true );'+
                '}'+                
            "});"+
            "<\/script>";
        }
        $("#tableEntrada").children("tbody").append(html);

    }*/
    /*
    function atualizarTabelaSaida(itens){
        html = "";
        var statusitens = <?php echo json_encode($statusEtapa);?>;
        for(x=0;x<itens.length;x++){
            html += '<tr class="trpai' + itens[x].idControleEtapa + '" style="background-color: #efefef">'+
                '<td onclick="openclose(this,' +itens[x].idControleEtapa+ ')" style="text-align: center; display: table-cell;min-height: 10em;vertical-align: middle;"><a class="detail-icon" ><i class="fa fa-minus"></i></a></td>'+
                '<td style=" "><div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">'+
                    '<input type="hidden" id="id_orc_item_' +itens[x].idControleEtapa+ '" name="id_orc_item[]"   value="' +itens[x].idOrcamento_item+ '"/>'+
                    '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                        '<div class="span2">'+
                            '<label><b>PN </b> (master):</label>'+
                            '<input readonly type="text" class="span12" id="pn_' +itens[x].idControleEtapa+'" name="pn[]" value="' +itens[x].pn+ '" />' +
                            '<input type="hidden" name="contador2[]" id="contador2"   value="' +itens[x].idControleEtapa+ '"/>' +
                        '</div>'+
                        '<div class="span1">' +
                            '<label>Orç.:</label>' +
                            '<input readonly type="text" class="span12" id="orc_' + itens[x].idControleEtapa + '" name="orc[]" value="' +itens[x].tipoOrc+ '" />'+
                        '</div>'+
                        '<div class="span5">' +
                            '<label>Descrição:</label>' +
                            '<input type="text" readonly class="span12" id="descricao_item_' + itens[x].idControleEtapa + '" name="descricao_item[]"  value="' + itens[x].descricao_item + '" />' +
                        '</div>' +
                        '<div class="span1">' +
                            '<label>Tag:</label>' +
                            '<input type="text" readonly class="span12" id="tag_' + itens[x].idControleEtapa +  '" name="tag[]"  value="' + itens[x].tag + '" />' +
                        '</div>' +
                        '<div class="span2">' +
                            '<label>Orçamento:</label>' +
                            '<input type="text" class="span12" readonly id="idOrc_' + itens[x].idControleEtapa +  '" name="idOrc[]"  value="' + itens[x].idOrcamento + '" />' +
                            '<input type="hidden" id="idOrcItem_' + itens[x].idControleEtapa +  '" value="' + itens[x].idOrcamento_item + '"'+
                        '</div>' +
                    '</div>'+
                '</div></td>'+
            '</tr>';
            html += '<tr class="trfilho' + itens[x].idControleEtapa + '" style="display:table-row">'+
                '<td>'+
                '</td>'+
                '<td>'+
                    '<div>'+
                        //'<form id="formEntrada_'+itens[x].idControleEtapa+'">'+
                            '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                '<table class="table table-bordered " id="tableSaida_' + itens[x].idControleEtapa + '">'+
                                    '<thead>'+
                                        '<th>'+
                                        '</th>'+
                                        '<th>'+
                                            'PN Master'+
                                        '</th>'+
                                        '<th>'+
                                            'Descrição'+
                                        '</th>'+
                                        '<th>'+
                                            'QTD'+
                                        '</th>'+
                                        '<th>'+
                                            'Etapa'+
                                        '</th>'+
                                        '<th>'+
                                            'Local'+
                                        '</th>'+
                                    '</thead>'+
                                    '<tbody>';
                                        html += '<tr>'+
                                            '<td style="width:30px">'+
                                                '<input type="checkbox" class="saidaPai_'+itens[x].idControleEtapa+'" name="produtoMaster[]" id="produtoMaster" value="'+itens[x].idControleEtapa+'">'+
                                            '</td>'+
                                            '<td style="width:150px">'+
                                                itens[x].pn+
                                            '</td>'+
                                            '<td>'+
                                                itens[x].descricao+
                                            '</td>'+
                                            '<td style="width:50px">'+
                                                itens[x].quantidade+
                                            '</td>'+
                                            '<td style="width:250px">'+
                                                itens[x].descricaoStatusEtapaServico+
                                            '</td>'+
                                            '<td style="width:100px">';
                                                if(itens[x].local)
                                                html += itens[x].local;
                                            html += '</td>'+
                                        '</tr>';
                                    html +='</tbody>'+
                                '</table>'+
                            '</div>'+
                            '<br>'+
                            '<br>';
                            if(itens[x].controleEtapaSubitens){
                                html += '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                    '<div id="escopo_' + itens[x].idControleEtapa + '">'+
                                        '<table class="table table-bordered " id="tableEntrada_' + itens[x].idControleEtapa + '">'+
                                            '<thead>'+
                                                '<th>'+
                                                '</th>'+
                                                '<th>'+
                                                    'PN'+
                                                '</th>'+
                                                '<th>'+
                                                    'Descrição'+
                                                '</th>'+
                                                '<th>'+
                                                    'QTD'+
                                                '</th>'+
                                                '<th>'+
                                                    'Etapa'+
                                                '</th>'+
                                                '<th>'+
                                                    'Local'+
                                                '</th>'+
                                            '</thead>'+
                                            '<tbody>';
                                                for(y=0;y<itens[x].controleEtapaSubitens.length;y++){
                                                    html += '<tr>'+
                                                        '<td style="width:30px">'+
                                                            '<input type="checkbox" class="'+( itens[x].controleEtapaSubitens[y].idStatusEtapaServico == itens[x].idStatusEtapaServico?'saidaFilho_'+itens[x].idControleEtapa:"")+'" name="subItemSaida[]" id="subItemSaida" value="'+itens[x].controleEtapaSubitens[y].idControleEtapaSubitem+'">'+
                                                        '</td>'+
                                                        '<td style="width:150px">'+
                                                            itens[x].controleEtapaSubitens[y].pn+
                                                        '</td>'+
                                                        '<td>'+
                                                            itens[x].controleEtapaSubitens[y].descricao+
                                                        '</td>'+
                                                        '<td style="width:50px">'+
                                                            itens[x].controleEtapaSubitens[y].quantidade+
                                                        '</td>'+
                                                        '<td style="width:250px">'+
                                                            itens[x].controleEtapaSubitens[y].descricaoStatusEtapaServico+
                                                        '</td>'+
                                                        '<td style="width:100px">';
                                                            if( itens[x].controleEtapaSubitens[y].local)
                                                                html += itens[x].controleEtapaSubitens[y].local;
                                                        html +='</td>'+
                                                        
                                                    '</tr>';
                                                }
                                            html +='</tbody>'+
                                        '</table>'+
                                    '</div>'+
                                '</div>';
                            }
                        //'</form>'+
                    html += '</div>'+
                '</td>'+
            '</tr>';
            html += "<script type=\'text/javascript\'>"+
            "$(\'.saidaPai_"+itens[x].idControleEtapa+"\').change(function () {"+
                'if($(this).is(":checked")){'+
                    '$( \".saidaFilho_'+itens[x].idControleEtapa+' \").prop( "checked", true );'+
                '}else{'+
                    '$( \".saidaFilho_'+itens[x].idControleEtapa+' \").prop( "checked", false );'+
                '}'+                
            "});"+
            "<\/script>";
        }
        $("#tableSaida").children("tbody").append(html);

    }*/
    
    function carregarModalEntrada(){
        var form = "#formEntrada_";
        var contador = Array.apply(null,document.querySelectorAll("#contador"));
        var html = "";
        var contagem = 0;
        var produtosNovo = "";
        var idProduto = new Array();
        var idOrcamento_item = new Array();
        for(j=0;j<contador.length;j++){
            form2=form+contador[j].value;
            checkbox = $(form2+" #cadastrarNovoSubItem");
            
            orcamento = "#idOrcItem_"+contador[j].value;
            arrayOrcamento = $(orcamento);
            for(a=0;a<checkbox.length;a++){
                if(checkbox[a].checked){
                    idProduto[contagem] = checkbox[a].value;
                    idOrcamento_item[contagem] = arrayOrcamento[j].value;
                    contagem ++;
                }
            }
            //console.log(idProduto);

            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/controle/getDetailProduto",
                type: 'POST',
                dataType: 'json',
                async: false,
                //data: produtosNovo,
                data:{
                    "idProduto":idProduto,
                    "idOrcamento_item":idOrcamento_item
                },
                success: function(data) {
                    if(data.result){
                        atualizarModalEntrada(data.obj);
                    }
                    

                },
                error: function(xhr, textStatus, error) {
                    console.log("4");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },
            })/**/
        }
    }

    function atualizarModalEntrada(itens){
        $("#modal-modalentrada").modal('show');
        for(x=0;x<itens.length;x++){
            html = "<div>"+

            "</div>";
        }
    }
    carregarItensCancelado();
    carregarItensSaida();
    carregarItensEntrada();
    carregarItensRecebimento();
    carregarItens(1);

    $("#formAdicionar #pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN_2",
        minLength: 1,
        select: function(event, ui) {
            $('#idPn').val(ui.item.id);
            $('#formAdicionar #descricaoItem').val(ui.item.no);
        }
    })
    /*
    $("#formFiltrar #pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN_2",
        minLength: 1,
        select: function(event, ui) {
            $('#formFiltrar #descricaoItem').val(ui.item.no);
        }
    })*/

    $("#formAtualizar #usuario").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteFunc",
        minLength: 1,
        select: function(event, ui) {
            $('#formAtualizar #idUser').val(ui.item.id);
        }
    })

    $("#formAtualizarFilho #usuario").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteFunc",
        minLength: 1,
        select: function(event, ui) {
            $('#formAtualizarFilho #idUser').val(ui.item.id);
        }
    })
    

    /*
    $("#formEntrada #idOrcamento").autocomplete({
        source: "<?php echo base_url(); ?>index.php/controle/autoCompleteIdOrcamento",
        minLength: 1,
        select: function(event, ui) {
            $('#formEntrada #idOs').val(ui.item.id);
            $('#formEntrada #pn').val(ui.item.no);
            $('#formEntrada #descricaoItem').val(ui.item.no);
        }
    })
    $("#formEntrada #idOs").autocomplete({
        source: "<?php echo base_url(); ?>index.php/controle/autoCompleteidOs",
        minLength: 1,
        select: function(event, ui) {
            $('#formEntrada #idOrcamento').val(ui.item.id);
            $('#formEntrada #pn').val(ui.item.no);
            $('#formEntrada #descricaoItem').val(ui.item.no);
        }
    })
    $("#formEntrada #pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/controle/autoCompletePN",
        minLength: 1,
        select: function(event, ui) {
            $('#formEntrada #idOrcamento').val(ui.item.id);
            $('#formEntrada #idOs').val(ui.item.no);
            $('#formEntrada #descricaoItem').val(ui.item.no);
        }
    })
    $("#formEntrada #descricaoItem").autocomplete({
        source: "<?php echo base_url(); ?>index.php/controle/autoCompleteDescricao",
        minLength: 1,
        select: function(event, ui) {
            $('#formEntrada #idOrcamento').val(ui.item.id);
            $('#formEntrada #pn').val(ui.item.no);
            $('#formEntrada #idOs').val(ui.item.no);
        }
    })*/
</script>