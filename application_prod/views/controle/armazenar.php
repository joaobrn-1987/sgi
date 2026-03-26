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
                                            <label for="idGrupoServico" class="control-label">Status serviço: </label>
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
<div align='center'>
    <a href="#modal-adicionaritem" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Item</a>
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

<div id="modal-atualizarstatus" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formAtualizar">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Atualizar status do item.</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span1">
                    <label for="cliente" class="control-label">Qtd.:</label>
                    <input class="span12" class="form-control" id="qtd" type="text" name="qtd" value="" />
                    <input id="idControleEtapa" type="hidden" name="idControleEtapa" value="" />
                </div>
                <div class="span4">
                    <label for="idGrupoServico" class="control-label">Status serviço: </label>
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
                            <h5>Histórico Status</h5>
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
                                                            <th>Status</th>
                                                            <th>Usuário</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
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
                                                <th>Data cad.:</th>
                                                <th>Orç.:</th>
                                                <th>O.S.</th>
                                                <th>PN</th>
                                                <th>Descrição</th>
                                                <th>Qtd</th>
                                                <th>Status</th>
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
                            <div class="widget-content nopadding" >
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
<script type="text/javascript">
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
        $("#formAdicionar #local").val("")
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
                $("#modal-adicionaritem").modal('hide');
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
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function atualizarTabelaLista(itensLista) {
        var html = "";
        var formatter = new Intl.DateTimeFormat('pt-BR');
        for (x = 0; x < itensLista.length; x++) {
            html += '<tr>';
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

        $("#modal-editaritem").modal('show');

    }

    function editaritem() {
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
                local: $("#formEditar #local").val()

            },
            success: function(data) {
                if (data.result) {
                    $("#modal-editaritem").modal('hide');
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
            html += "</tr>";
        }
        $('#tableHistStatus tbody').empty();
        $("#tableHistStatus tbody").append(html);
        $("#modal-atualizarstatus").modal('show');
    }

    function atualizarItem() {
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
                    $("#modal-atualizarstatus").modal('hide');
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
    function salvarObservacao(){
        var observacao = $("#formObservacoes #observacoes").val();
        var vObservacao2 = $("#formObservacoes #vObservacao2").val();
        if(observacao == null || observacao == ""){

        }
        var idControleEtapa = $("#formObservacoes #idControleEtapa").val();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/salvarobservacao",
            type: 'POST',
            dataType: 'json',
            data: {
                idControleEtapa: idControleEtapa,
                observacao:observacao,
                vObservacao2:vObservacao2
            },
            success: function(data) {
                alert("Observação cadastrada com sucesso.");   
                $("#modal-observacao").modal('hide');
                $("#vObservacao").empty();
                $("#formObservacoes #idControleEtapa").val("");
                $("#formObservacoes #vObservacao2").val("");
                $("#formObservacoes #observacoes").val("");
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

    carregarItens(1);
    $("#formAdicionar #pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN_2",
        minLength: 1,
        select: function(event, ui) {
            $('#idPn').val(ui.item.id);
            $('#formAdicionar #descricaoItem').val(ui.item.no);
        }
    })
    $("#formFiltrar #pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN_2",
        minLength: 1,
        select: function(event, ui) {
            $('#formFiltrar #descricaoItem').val(ui.item.no);
        }
    })
    $("#formAtualizar #usuario").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteFunc",
        minLength: 1,
        select: function(event, ui) {
            $('#formAtualizar #idUser').val(ui.item.id);
        }
    })
</script>