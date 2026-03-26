<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

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
                            <form action="<?php echo base_url() ?>index.php/pcp/backlog" method="get" name="form1" id="form1">
                                <input type="hidden" value="1" name="ehfiltro">
                                <div class="span12" id="divCadastrarOs" style="margin-left: 0">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3" class="control-group">
                                            <label>O.S.</label>
                                            <input class="span12" type="text" name="idOs" id="idOs" value="<?php echo $this->input->get('idOs'); ?>">
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label>O.C.</label>
                                            <input class="span12" type="text" name="idPedidoCompra" id="idPedidoCompra" value="<?php echo $this->input->get('idPedidoCompra'); ?>">
                                        </div>
                                        <div class="span3">
                                            <label for="idGrupoServico" class="control-label">Grupo Serviço:</label>
                                            <select class="span12" name="idGrupoServico">
                                                <option value=""></option>
                                                <?php
                                                if (isset($dados_gruposervico)) {
                                                    foreach ($dados_gruposervico as $gs) {
                                                        $selected = ($this->input->get('idGrupoServico') == $gs->idGrupoServico) ? 'selected' : '';
                                                        echo '<option value="' . $gs->idGrupoServico . '" ' . $selected . '>' . $gs->nome . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>                                      
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                       
                                        <div class="span6" class="control-group">
                                            <label for="exibir_almoxarifado" class="control-label">
                                                <input type="checkbox" name="exibir_almoxarifado" id="exibir_almoxarifado" value="1" <?php if($this->input->get('exibir_almoxarifado') == '1') echo 'checked'; ?>>
                                                <strong>Exibir Todos os Itens (incluindo OS de estoque/internas)</strong>
                                            </label>
                                        </div>       
                                        <div class="span3" class="control-group">
                                            <label for="tipo_compra" class="control-label"> <strong>Tipo de Compra</strong></label>
                                            <select name="tipo_compra" id="tipo_compra" class="span6">
                                                <option value="" <?php if($this->input->get('tipo_compra') == '') echo 'selected'; ?>>Todos</option>
                                                <option value="Necessário" <?php if($this->input->get('tipo_compra') == 'Necessário') echo 'selected'; ?>>Necessário</option>
                                                <option value="Reposição" <?php if($this->input->get('tipo_compra') == 'Reposição') echo 'selected'; ?>>Reposição</option>
                                            </select>
                                        </div>  
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                                <div class="span2" class="control-group">
                                                    <button type="submit" class="btn btn-success"><i class="icon-white"></i>Filtrar</button>
                                                </div>
                                        </div>                  
                                            
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span12" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Status Ordem Compra:</label>&nbsp;<input type="checkbox" name="todasSog" id="todasSog" value='SOG' onClick="CheckAll2('SOG');">&nbsp;Marcar/Desmarcar todos
                                                <br>
                                                <table width='100%'>
                                                    <tr>
                                                    <?php
                                                    $idsStatusCompraSelecionadosPadrao = [1, 17, 18, 22, 2, 16, 3, 13, 10, 14, 19, 12, 4];
                                                    $statusCompraFiltro = $this->input->get('idStatuscompras') ?: $idsStatusCompraSelecionadosPadrao;
                                                    $i = 0;
                                                    foreach ($dados_statuscompra as $so) {
                                                    ?>
                                                        <td>
                                                            <input type="checkbox" name="idStatuscompras[]" class='check' value="<?php echo $so->idStatuscompras; ?>"
                                                                <?php if (in_array($so->idStatuscompras, $statusCompraFiltro)) { echo 'checked'; } ?>
                                                            > &nbsp;<?php echo $so->nomeStatus; ?>
                                                        </td>
                                                    <?php
                                                        if (($i + 1) % 5 == 0) echo "</tr><tr>";
                                                        $i++;
                                                    }
                                                    ?>
                                                    </tr>
                                                </table>
                                            </div>
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span12" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Status OS:</label>&nbsp;<input type="checkbox" name="todasGs" id="todasGs" value="GS" onClick="CheckAll2('GS');">&nbsp;Marcar/Desmarcar todos
                                                <br>
                                                <table width='100%'>
                                                    <tr>
                                                        <?php
                                                        $idsSelecionadosPadrao = [5, 9, 16, 20, 21, 25, 28, 30, 42, 85, 88, 90, 96, 101, 200, 208, 213, 217, 219, 221, 223, 225];
                                                        $statusOsFiltro = $this->input->get('idStatusOs') ?: $idsSelecionadosPadrao;
                                                        $i = 0;
                                                        foreach ($status_os as $e) {
                                                        ?>
                                                            <td>
                                                                <input type="checkbox" name="idStatusOs[]" class='check' value="<?php echo $e->idStatusOs; ?>"
                                                                    <?php if (in_array($e->idStatusOs, $statusOsFiltro)) { echo 'checked'; } ?>
                                                                > &nbsp;<?php echo $e->nomeStatusOs; ?>
                                                            </td>
                                                        <?php
                                                            if (($i + 1) % 5 == 0) echo "</tr><tr>";
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tr>
                                                </table>
                                            </div>
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span4" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Unid. Execuçao O.S.:</label>&nbsp;<input type="checkbox" name="todasExec" id="todasExec" value="EXEC" onClick="CheckAll2('EXEC');">&nbsp;Marcar/Desmarcar todos
                                                </br>
                                                <?php 
                                                $unidExecFiltro = $this->input->get('unid_execucao') ?: [];
                                                foreach ($unid_exec as $exec) { ?>
                                                    <input type="checkbox" name="unid_execucao[]" class='check' value="<?php echo $exec->id_unid_exec; ?>"
                                                        <?php if (in_array($exec->id_unid_exec, $unidExecFiltro)) { echo 'checked'; } ?>
                                                    > &nbsp;<?php echo $exec->status_execucao; ?>
                                                <?php } ?>
                                            </div>
                                    </div>

                                    <div class="span12" style="margin-left: 0">
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

<div align='center'>
    <a href="#modal-justificativaPedidoCompra" role="button" data-toggle="modal" class="btn btn-success" style="height: 20px"><i class="icon-plus icon-white"></i> Justificativa O.C.</a>
</div>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Backlog</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs" style="overflow-x: auto;">
                                <div class="span12" style="margin-top:0px">
                                
                    
<div class="buttons">
    <?php
    $get_params = $this->input->get() ?: [];
    $queryString = http_build_query($get_params);
    ?>
    <a href="<?php echo base_url(); ?>index.php/pcp/exportarBacklog?<?php echo $queryString; ?>" class="btn btn-mini btn-inverse">
        <i class="fas fa-file-excel"></i> Exportar Tudo (Excel)
    </a>
</div>
<table id="tableHistVale" class="table table-bordered ">
    <thead>
        <tr>
            <th>Resp. PCP</th>
            <th>Descrição O.S.</th>
            <th>PN</th>
            <th>O.S.</th>
            <th>STATUS OS</th>
            <th>Data<br>Entrega</th>
            <th>Unid. Exec.</th>
            <th>Data<br>Reagendada</th>
            <th>Descrição Insumo</th>
            <th>Qtde</th>
            <th>O.C.</th>
            <th>Grupo Compra</th>
            <th>Valor Unit.</th>
            <th>Valor Total</th>
            <th>Data Lanç.</th>
            <th>Data Alt.</th>
            <th>Previsão Ent.</th>
            <th>Data Ent.</th>
            <th>Status Compra</th>
            <th>Fornecedor</th>
            <th>Contato</th>
            <th>Data Reprog.</th>
            <th></th>
            <th>Data Limite</th>
            <th>Justificativa</th>
            <th>Cliente</th>
            <th>tipo_compra</th>
            <th>Grupo Serviço</th>
            <th>Valor O.S.</th> 
            <th>Valor Total c/ Impostos</th> 
            <th>Obs</th>
        </tr>
    </thead>
<tbody>
    <?php 
    $total_geral = 0;
    $total_produtos = 0;
    $total_frete = 0;
    $pedidos_frete_somados = array();

    foreach ($result as $r) {
        // ... (seus cálculos de valores permanecem iguais)
        $valorComImpostos = ($r->valor_unitario * $r->quantidade) + $r->ipi_valor + $r->icms + $r->outros - $r->desconto;
        $total_geral += $valorComImpostos;

        // --- LÓGICA DE RECAPTURAR DATA PARA O.S. 50070 / 56521 ---
        $dataExibicao = "00/00/0000";
        $estiloData = 'style="color:red; font-weight:bold;"';

        // 1ª Tentativa: Pelo campo que criámos no Model
        if (!empty($r->DATA_MOTIVO) && $r->DATA_MOTIVO != '0000-00-00') {
            $dataExibicao = date("d/m/Y", strtotime($r->DATA_MOTIVO));
            $estiloData = 'style="color:blue; font-weight:bold;"';
        } 
        // 2ª Tentativa: Caso o Model não tenha enviado o alias, mas a data esteja na OS
        elseif (!empty($r->data_reagendada) && $r->data_reagendada != '0000-00-00') {
            $dataExibicao = date("d/m/Y", strtotime($r->data_reagendada));
            $estiloData = '';
        }
        // 3ª Tentativa (FORÇA BRUTA): Se ainda estiver vazio, buscamos diretamente na tabela de motivos
        else {
            $CI =& get_instance(); // Aceder ao motor do CodeIgniter
            $checkData = $CI->db->select('data_reagendada')
                                ->where('idOs', $r->idOs)
                                ->order_by('idMotivoReag', 'DESC')
                                ->limit(1)
                                ->get('os_reagendada_motivo')
                                ->row();
            
            if ($checkData && !empty($checkData->data_reagendada) && $checkData->data_reagendada != '0000-00-00') {
                $dataExibicao = date("d/m/Y", strtotime($checkData->data_reagendada));
                $estiloData = 'style="color:green; font-weight:bold;"'; // Verde indica que a View teve que buscar sozinha
            }
        }
    ?>
        <tr>
            <td><?php echo $r->nome; ?></td>
            <td><?php echo $r->descricao_item; ?></td>
            <td><?php echo $r->pn; ?></td>
            <td><font color="red"><a target="_blank" href="<?php echo base_url(); ?>index.php/os/visualizar/<?php echo $r->idOs; ?>" style="color: red;"><?php echo $r->idOs; ?></a></font></td>
            <td><?php echo $r->nomeStatusOs; ?></td>
            <td><?php echo (!empty($r->entrega_os) ? date("d/m/Y", strtotime($r->entrega_os)) : ""); ?></td>
            <td align="center"><?php echo $r->status_execucao; ?></td>
            
            <td <?php echo $estiloData; ?>><?php echo $dataExibicao; ?></td>

            <td><?php echo $r->descricaoInsumo; ?></td>
            <td><?php echo $r->quantidade; ?></td>
            <td><?php echo $r->idPedidoCompra; ?></td>
            <td><?php echo $r->nomegrupo; ?></td>
            
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')): ?>
                <td>R$ <?php echo number_format($r->valor_unitario, 2, ",", "."); ?></td>
                <td>R$ <?php echo number_format($r->valor_unitario * $r->quantidade, 2, ",", "."); ?></td>
            <?php endif; ?>

            <td><?php echo (!empty($r->data_dist) ? date("d/m/Y", strtotime($r->data_dist)) : ""); ?></td>
            <td><?php echo (!empty($r->data_alteracao) ? date("d/m/Y", strtotime($r->data_alteracao)) : ""); ?></td>
            <td><?php echo (!empty($r->previsao_entrega) ? date("d/m/Y", strtotime($r->previsao_entrega)) : ""); ?></td>
            <td><?php echo (!empty($r->datastatusentregue) ? date("d/m/Y", strtotime($r->datastatusentregue)) : ""); ?></td>
            <td><?php echo $r->nomeStatus; ?></td>
            <td><?php echo $r->nomeFornecedor; ?></td>
            <td><?php echo $r->telefone; ?></td>

            <td <?php echo $estiloData; ?>><?php echo $dataExibicao; ?></td>
            
            <td></td>
            <td><?php echo (!empty($r->data_limite) ? date("d/m/Y", strtotime($r->data_limite)) : ""); ?></td>
            <td><?php echo $r->ultJustificativa; ?></td>
            <td><?php echo $r->nomeCliente; ?></td>
            <td><?php echo $r->tipo_compra; ?></td>
            <td><?php echo $r->nome_grupo_servico; ?></td>
            
            <td>R$ <?php echo number_format($r->ValorTotalOS, 2, ",", "."); ?></td>
            <td>R$ <?php echo number_format($valorComImpostos, 2, ",", "."); ?></td>
            <td><a onclick="abrirObservacao(<?php echo $r->idDistribuir; ?>)" class="btn tip-top"><i class="icon-list-alt"></i></a></td>
        </tr>
    <?php } ?>
</tbody>
</table>
                                    <div class="span12" style="text-align: center;">
                                        <?php if (isset($pagination)) { echo $pagination; } ?>
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

<div id="modal-justificativa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
<div id="modal-justificativaPedidoCompra" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>

<script type="text/javascript">
    $('.data').inputmask("date",{
        inputFormat: "dd/mm/yyyy",
        placeholder: "DD/MM/AAAA"
    });

    function CheckAll2(inputCheck) {
        var sog = document.querySelector("#todasSog");
        var gs = document.querySelector("#todasGs");
        var exec = document.querySelector("#todasExec");
        if (inputCheck == 'SOG') {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'idStatuscompras[]') {
                    x.checked = sog.checked;
                }
            }
        }
        if (inputCheck == 'GS') {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'idStatusOs[]') {
                    x.checked = gs.checked;
                }
            }
        }
        if (inputCheck == 'EXEC') {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'unid_execucao[]') {
                    x.checked = exec.checked;
                }
            }
        }
    }
    function abrirObservacao(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/pcp/getDistribuirById",
            type: 'POST',
            dataType: 'json',
            data: { idDistribuir: id },
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
        $("#idDistribuir").val(item.idDistribuir);
        $("#histJustficativa").val(item.justificativa);
        $("#vObservacao").empty();
        $("#vObservacao").append(item.justificativa);
        $("#modal-justificativa").modal('show');
    }
    function alterarLimite(id, item){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/pcp/alterarlimite",
            type: 'POST',
            dataType: 'json',
            data: {
                idDistribuir: id,
                data: item.value
            },
            success: function(data) {
                console.log(data.result)
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
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var exibirTodos = document.getElementById('exibir_almoxarifado');
    var status93 = document.querySelector('input[name="idStatusOs[]"][value="93"]');

    if (!exibirTodos || !status93) return;

    var status93Inicial = status93.checked;

    if(exibirTodos.checked) {
        status93.checked = true;
    }

    exibirTodos.addEventListener('change', function() {
        if(this.checked) {
            status93.checked = true;
        } else {
            if(!status93Inicial) {
                status93.checked = false;
            }
        }
    });
});
</script>