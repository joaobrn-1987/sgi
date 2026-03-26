<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tableimprimir.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

<?php
$data_atual = date('d/m/Y');
if (!$results) {

?>


    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>OS</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>

                        <td align='center'>Orç.</td>

                        <td align='center'>Data Orc.</td>
                        <td align='center'>Vencimento</td>
                        <td align='center'>Cliente</td>
                        <td align='center'>Vendedor</td>
                        <td align='center'>Regiao</td>
                        <?php
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                        ?>
                            <td align='center'>Total</td>
                        <?php
                        }
                        ?>
                        <td align='center'>Status</td>
                        <td align='center'>Descrição</td>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhuma OS Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php } else {

    $data_inicial = $data_entrega["data_ini"];

    $data_atual = $data_entrega["data_final"];

    $data_atual_sistem = date('d/m/Y H:i:s');
?>
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Filtro Orçamento</h5>
                </div>
                <div class="widget-content nopadding">


                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">

                                <div class="span12" id="divCadastrarOs">

                                    <form class="form-inline" action="<?php echo base_url() ?>index.php/relatorios/rel_orcamento" method="get" name="form1" id="form1">



                                        <div class="span12" style="padding: 1%; margin-left: 0">

                                            <div class="span3" class="control-group">
                                                <label for="idOrcamentos" class="control-label">Cod. Orc.:</label>
                                                <input class="span12 form-control" type="text" name="idOrcamentos" value="" class="span12">
                                            </div>
                                            <div class="span3" class="control-group">
                                                Referência: <input id="referencia" type="text" name="referencia" value="" />
                                            </div>
                                            <div class="span3" class="control-group">
                                                Num. Pedido:<input id="num_pedido" type="text" name="num_pedido" value="" />
                                            </div>
                                            <div class="span3" class="control-group">
                                                Num. Nota Fiscal:<input id="num_nf" type="text" name="num_nf" value="" />
                                            </div>
                                        </div>

                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span6" class="control-group">
                                                <label for="numpedido_os" class="control-label">Data cadastro:</label><br>

                                                De: <input id="dataInicialcad" class="data datap" type="text" name="dataInicialcad" value="<?php echo $data_inicial; ?>" /> | Até:<input id="dataFinalcad" class="data datap" type="text" name="dataFinalcad" value="<?php echo $data_atual; ?>" />
                                            </div>
                                            <div class="span6" class="control-group">
                                                <label for="num_pedido" class="control-label">PN:</label>
                                                <input type="hidden" id="idProdutos" name="idProdutos" size="3" value="" />
                                                <input id="pn" class="span12" type="text" name="pn" value="" ref="autocomplete" />
                                            </div>
                                        </div>


                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span12" class="control-group">
                                                Nat. Operação:
                                                <table width='100%'>
                                                    <tr>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($dados_natoperacao as $nt) {
                                                        ?>
                                                            <td>
                                                                <input type="checkbox" name="idNatOperacao[]" class='check' value="<?php echo $nt->idNatOperacao; ?>"> &nbsp;<?php echo $nt->nome; ?>
                                                            </td>
                                                        <?php
                                                            if (($i + 1) % 5 == 0)
                                                                echo "</tr>";

                                                            $i++;
                                                        }
                                                        ?>
                                                </table>
                                            </div>
                                        </div>


                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span12" class="control-group">
                                                Grupo Serviço:
                                                <table width='100%'>
                                                    <tr>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($dados_gruposervico as $gs) {
                                                        ?>
                                                            <td>
                                                                <input type="checkbox" name="idGrupoServico[]" class='check' value="<?php echo $gs->idGrupoServico; ?>"> &nbsp;<?php echo $gs->nome; ?>
                                                            </td>
                                                        <?php
                                                            if (($i + 1) % 5 == 0)
                                                                echo "</tr>";

                                                            $i++;
                                                        }
                                                        ?>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span6">
                                                <label for="idOs" class="control-label">Por:</label><br>
                                                <table width="100%">
                                                    <tr>
                                                        <td><input type="checkbox" id="checkVendedores" name="agrupar[]" value="vendedores"> &nbsp;Gerente</td>
                                                        <td><input type="checkbox" id="checkVendedoresAux" name="agrupar[]" value="vendedoresAux"> &nbsp;Vendedor Auxiliar</td>
                                                        <td><input type="checkbox" id="checkClientes" name="agrupar[]" value="clientes"> &nbsp;Clientes</td>
                                                        <td><input type="checkbox" id="checkRegiao" name="agrupar[]" value="regiao"> &nbsp;Região</td>
                                                        <td><input type="checkbox" id="checkStatusOrcamento" name="agrupar[]" value="statusOrcamento"> &nbsp;Status Orçamento</td>
                                                        <td><input type="checkbox" id="checkStatusOs" name="agrupar[]" value="idStatusOs"> &nbsp;Status Os</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span2" id="divVendedor" style="display: none; border: 1px solid #ccc; padding: 5px;">
                                                <label for="fornecedor">Gerentes:</label><br><br>
                                                <div id="adm">
                                                    <div class="card card-body" style="overflow: scroll; height: 300px;">
                                                        <table>
                                                            <tr>
                                                                <?php
                                                                $i = 1;
                                                                foreach ($vendedores as $for) {
                                                                    if (in_array($for->idVendedor, [2, 3, 4, 6, 7])) {
                                                                        continue;
                                                                    }
                                                                ?>
                                                                    <td>
                                                                        <input type="checkbox" name="idVendedores[]" <?php if (isset($idVendedores)) { foreach ($idVendedores as $r) { if ($r == $for->idVendedor) { echo 'checked'; } } } ?> value="<?php echo $for->idVendedor; ?>"> <?php echo $for->nomeVendedor; ?>
                                                                    </td>
                                                                <?php
                                                                    if ($i == 1) {
                                                                        echo "</tr><tr>";
                                                                        $i = 0;
                                                                    }
                                                                    $i++;
                                                                }
                                                                ?>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="span3" id="divVendedorAux" style="display: none; border: 1px solid #ccc; padding: 5px;">
                                                <label for="fornecedor">Vendedor Auxiliar:</label><br><br>
                                                <div id="adm">
                                                    <div class="card card-body" style="overflow: scroll; height: 300px;">
                                                        <?php
                                                        $vendedoresAux = $this->data['idVendedores'];
                                                        $currentVendedor = null;
                                                        ?>
                                                        <table>
                                                            <?php
                                                            if (is_array($vendedoresAux)) {
                                                                foreach ($vendedoresAux as $aux) {
                                                                    if (in_array($aux->idVendedorAuxiliar, [1, 3, 4])) {
                                                                        continue;
                                                                    }
                                                                    if ($currentVendedor !== $aux->nomeVendedorPrincipal) {
                                                                        $currentVendedor = $aux->nomeVendedorPrincipal;
                                                            ?>
                                                                        <tr>
                                                                            <td colspan="2"><strong><?php echo $currentVendedor; ?></strong></td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox" name="idVendedoresAux[]" <?php if (isset($idVendedoresAux) && is_array($idVendedoresAux)) { foreach ($idVendedoresAux as $r) { if ($r == $aux->idVendedorAuxiliar) { echo 'checked'; } } } ?> value="<?php echo $aux->idVendedorAuxiliar; ?>">
                                                                            <?php echo $aux->nomeUsuario; ?>
                                                                        </td>
                                                                    </tr>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="span6" style=" margin-left: 30">
                                                <div class="span12" style="display:none; border: 1px solid #ccc; padding: 5px 0px 0px 5px;" id="divClientes">
                                                    <label for="fornecedor" class="control-label">Clientes:</label><br><br>
                                                    <div id="adm">
                                                        <div class="card card-body" style="overflow: scroll;height: 300px">
                                                            <table>
                                                                <tr>
                                                                    <?php
                                                                    $i = 1;
                                                                    foreach ($dados_clientes as $cli) {
                                                                    ?>
                                                                        <td class="span6">
                                                                            <input type="checkbox" name="clientes_id[]" value="<?php echo $cli->idClientes; ?>"> <?php echo $cli->nomeCliente; ?>
                                                                        </td>
                                                                    <?php
                                                                        if ($i % 2) {
                                                                            echo "</tr><tr>";
                                                                        }
                                                                        $i++;
                                                                    }
                                                                    ?>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="span12" style="padding: 5px 10px 0px 0px; margin-left: 0">
                                                <div class="span2" id="divRegiao" style="display: none; border: 1px solid #ccc; padding: 5px;">
                                                    <label for="fornecedor">Região:</label>
                                                    <div id="adm">
                                                        <div class="card card-body" style="overflow: auto; height: 90px;">
                                                            <table>
                                                                <tr>
                                                                    <?php
                                                                    $i = 1;
                                                                    $todas_regioes = isset($this->data['todas_regioes']) && is_array($this->data['todas_regioes']) ? $this->data['todas_regioes'] : [];
                                                                    $regioes_selecionadas = isset($this->data['regioes_selecionadas']) && is_array($this->data['regioes_selecionadas']) ? $this->data['regioes_selecionadas'] : [];
                                                                    if (!empty($todas_regioes)) {
                                                                        foreach ($todas_regioes as $regiao) {
                                                                            if (isset($regiao['regiao']) && !empty($regiao['regiao']) && $regiao['regiao'] !== '0') { ?>
                                                                                <td>
                                                                                    <input type="checkbox" name="regiao[]" value="<?php echo htmlspecialchars($regiao['regiao']); ?>" <?php if (in_array($regiao['regiao'], $regioes_selecionadas)) { echo 'checked'; } ?>>
                                                                                    <?php echo htmlspecialchars($regiao['regiao']); ?>
                                                                                </td>
                                                                    <?php
                                                                            }
                                                                            if ($i % 2 == 0) {
                                                                                echo "</tr><tr>";
                                                                            }
                                                                            $i++;
                                                                        }
                                                                    } else {
                                                                        echo "<td>Nenhuma região encontrada.</td>";
                                                                    }
                                                                    ?>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="span12" style="padding: 5px 10px 0px 0px; margin-left: 0">
                                                <div class="span6" id="divStatusOrcamento" style="display: none; border: 1px solid #ccc; padding: 5px;">
                                                    <label for="fornecedor" class="control-label">Status Orçamento:</label><br><br>
                                                    <div id="adm">
                                                        <table>
                                                            <tr>
                                                                <?php
                                                                $i = 0;
                                                                foreach ($dados_statusorcamento as $o) {
                                                                ?>
                                                                    <td>
                                                                        <input type="checkbox" name="idstatusOrcamento[]" class='check' value="<?php echo $o->idstatusOrcamento; ?>"> &nbsp;<?php echo $o->nome_status_orc; ?>
                                                                    </td>
                                                                <?php
                                                                    if (($i + 1) % 5 == 0) echo "</tr>";
                                                                    $i++;
                                                                }
                                                                ?>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="span4" style="display:none; border: 1px solid #ccc; padding: 5px 0px 0px 5px;" id="divStatusOs">
                                                    <label for="fornecedor" class="control-label">Status O.S.:</label>
                                                    <div id="adm">
                                                        <div class="card card-body" style="overflow: scroll;height: 300px">
                                                            <table>
                                                                <tr>
                                                                    <?php
                                                                    $i = 1;
                                                                    foreach ($dados_statusos as $for) {
                                                                        if (in_array($for->idStatusOs, [200, 101, 20, 42, 92, 95])) {
                                                                    ?>
                                                                            <td>
                                                                                <input type="checkbox" name="idstatusOs[]" <?php if (isset($idStatusOs)) { foreach ($idStatusOs as $r) { if ($r == $for->idStatusOs) { echo 'checked'; } } } ?> value="<?php echo $for->idStatusOs; ?>"> <?php echo $for->nomeStatusOs; ?>
                                                                            </td>
                                                                    <?php
                                                                            if ($i == 1) {
                                                                                echo "</tr><tr>";
                                                                                $i = 0;
                                                                            }
                                                                            $i++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
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
                <i class="icon-print"></i>
            </span>
            <h5>Relatório</h5>
            <div class="buttons">
                <a id="imprimirRelTable" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                <a href="javascript:;" class="export-csv-rel btn btn-mini btn-inverse" data-filename="Relatorio-Detalhado-Orcamento">Exportar para Excel</a>
                <a href="javascript:;" class="export-csv-only-rel btn btn-mini btn-inverse" data-filename="Relatorio-Detalhado-Orcamento">Exportar para CSV</a>
            </div>
        </div>
        <div class="widget-content nopadding">
            <div id="printRelTable">
                <table id="rel_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <td align='center'>Orç.</td>
                            <td align='center'>Data Orc.</td>
                            <td align='center'>Vencimento</td>
                            <td align='center'>Cliente</td>
                            <td align='center'>Gerente</td>
                            <td align='center'>Vendedor</td>
                            <td align='center'>Região</td>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) { ?>
                                <td align='center'>Total</td>
                            <?php } ?>
                            <td align='center'>Status Orc</td>
                            <td align='center'>Status OS</td>
                            <td align='center'>Descrição</td>
                            <td align='center'>Nat. Ope.</td>
                            <td align='center'>Grupo Serv.</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalos = 0;
                        $somatorio_global = 0;
                        $processed_orc_ids_for_total = array();
                        $processed_orc_ids_for_subrule_display = array();

                        $osRule_Orc13_Item2 = array(5, 6, 9, 10, 16, 20, 25, 28, 29, 30, 42, 85, 86, 87, 90, 92, 95, 96, 101, 213);
                        $osRule_Orc13_Item0 = array(200);
                        
                        foreach ($results as $r) {
                            if (in_array($r->idOrcamentos, $processed_orc_ids_for_subrule_display)) {
                                continue;
                            }

                            $currentOrcamentoStatus = property_exists($r, 'idstatusOrcamento') ? (int)$r->idstatusOrcamento : null;
                            $at_least_one_rule_displayed_for_this_budget = false;

                            $rules_for_this_budget = [];
                            
                            if ($currentOrcamentoStatus === 13 || $currentOrcamentoStatus === 4 || $currentOrcamentoStatus === 11) {
                                
                                $group_name_suffix = 'Aprovado';
                                if ($currentOrcamentoStatus === 11) {
                                    $group_name_suffix = 'Aprov. Parcial';
                                }
                                if ($currentOrcamentoStatus === 13) {
                                    $group_name_suffix = 'Aprov. Parcial';
                                }

                                // --- ALTERAÇÃO: REGRA PARA OCULTAR ITENS COM STATUS 2 ---
                                // A regra abaixo, que busca por 'item_status_required' => 2, foi comentada
                                // para impedir que esses itens sejam exibidos no relatório.
                                
                                $rules_for_this_budget[] = array(
                                    'item_status_required' => 2,
                                    'os_valid_statuses'    => $osRule_Orc13_Item2,
                                    'display_group_name'   => $group_name_suffix . ' (Itens Fat.)'
                                );
                                
                                
                                // Esta regra, para itens pendentes, é mantida.
                                $rules_for_this_budget[] = array(
                                    'item_status_required' => 0,
                                    'os_valid_statuses'    => $osRule_Orc13_Item0,
                                    'display_group_name'   => $group_name_suffix . ' (Itens Pend. OS 200)'
                                );
                            
                            } elseif ($currentOrcamentoStatus === 3) {
                                // Lógica customizada para status 3 (Rejeitado)
                                $desc_banco_para_rejeitados = '';
                                $valor_orc_para_rejeitados = 0;
                                $count_itens_na_regra = 1;
                                $items_found_for_this_rule = false;
                                
                                $orca_item_rejeitado = $this->relatorios_model->tabela('orcamento_item', 'idOrcamentos =' . $r->idOrcamentos);
                            
                                foreach ($orca_item_rejeitado as $itemo) {
                                    if (property_exists($itemo, 'status_item') && (int)$itemo->status_item === 0) {
                                        $items_found_for_this_rule = true;
                                        $valor_orc_para_rejeitados += property_exists($itemo, 'valor_total') ? (float)$itemo->valor_total : 0;
                                        $descricaoItemFormatada = property_exists($itemo, 'descricao_item') ? substr($itemo->descricao_item, 0, 60) : '';
                                        $desc_banco_para_rejeitados .= "<b> " . $count_itens_na_regra++ . "- </b>" . htmlspecialchars($descricaoItemFormatada) . "(...) (Item Pendente)</br>";
                                    }
                                }
                            
                                if ($items_found_for_this_rule) {
                                    $at_least_one_rule_displayed_for_this_budget = true; 
                                    $data_cad = date("Y/m/d", strtotime($r->data_abertura));
                                    $vencimento = date('d/m/Y', strtotime('+' . $r->validade . ' days', strtotime($data_cad)));
                                    echo '<tr>';
                                    echo '<td align="center">' . htmlspecialchars($r->idOrcamentos) . '</td>';
                                    echo '<td align="center">' . date("d/m/Y", strtotime($r->data_abertura)) . '</td>';
                                    echo '<td align="right">' . htmlspecialchars($vencimento) . '</td>';
                                    echo '<td>' . htmlspecialchars($r->nomeCliente) . '</td>';
                                    echo '<td>' . htmlspecialchars($r->nomeVendedor) . '</td>';
                                    echo '<td>' . (!empty($r->nomeUsuarioVendedorAuxiliar) ? htmlspecialchars($r->nomeUsuarioVendedorAuxiliar) : 'Não informado') . '</td>';
                                    echo '<td>' . (!empty($r->regiao) ? htmlspecialchars($r->regiao) : 'Não informado') . '</td>';
                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                                        echo '<td align="right">' . number_format($valor_orc_para_rejeitados, 2, ",", ".") . '</td>';
                                    }
                                    $motivo = !empty($r->motivo) ? " Motivo: " . htmlspecialchars($r->motivo) : '';
                                    echo '<td>' . htmlspecialchars($r->nome_status_orc) . $motivo . '</td>';
                                    echo '<td>Itens Pendentes do Orçamento</td>';
                                    echo '<td>' . $desc_banco_para_rejeitados . '</td>';
                                    echo '<td>' . htmlspecialchars($r->nomenat) . '</td>';
                                    echo '<td>' . htmlspecialchars($r->nomeserv) . '</td>';
                                    echo '</tr>';
                                    $somatorio_global += $valor_orc_para_rejeitados;
                                }

                            } elseif ($currentOrcamentoStatus === 15) {
                                // ===================== NOVA REGRA: "PARA ORÇAR" =====================
                                // Mostra a linha mesmo que não exista OS atrelada, somando o valor dos itens (se houver).
                                $desc_itens   = '';
                                $valor_total  = 0.0;
                                $count_itens  = 1;

                                $orca_item = $this->relatorios_model->tabela('orcamento_item', 'idOrcamentos = ' . (int)$r->idOrcamentos);
                                if (!empty($orca_item)) {
                                    foreach ($orca_item as $itemo) {
                                        $valor_total += property_exists($itemo, 'valor_total') ? (float)$itemo->valor_total : 0.0;
                                        $descricaoItem = property_exists($itemo, 'descricao_item') ? (string)$itemo->descricao_item : '';
                                        $descricaoItemFormatada = mb_substr($descricaoItem, 0, 60, 'UTF-8');
                                        $desc_itens .= '<b>' . ($count_itens++) . ' - </b>' .
                                            htmlspecialchars($descricaoItemFormatada) .
                                            (mb_strlen($descricaoItem, 'UTF-8') > 60 ? '(...)' : '') .
                                            '</br>';
                                    }
                                    if ($desc_itens === '') {
                                        $desc_itens = 'Itens informados, sem descrição.';
                                    }
                                } else {
                                    $desc_itens = 'Sem itens cadastrados';
                                }

                                $data_cad   = date('Y/m/d', strtotime($r->data_abertura));
                                $vencimento = date('d/m/Y', strtotime('+' . (int)$r->validade . ' days', strtotime($data_cad)));

                                echo '<tr>';
                                echo '<td align="center">' . htmlspecialchars($r->idOrcamentos) . '</td>';
                                echo '<td align="center">' . date('d/m/Y', strtotime($r->data_abertura)) . '</td>';
                                echo '<td align="right">' . htmlspecialchars($vencimento) . '</td>';
                                echo '<td>' . htmlspecialchars($r->nomeCliente) . '</td>';
                                echo '<td>' . htmlspecialchars($r->nomeVendedor) . '</td>';
                                echo '<td>' . (!empty($r->nomeUsuarioVendedorAuxiliar) ? htmlspecialchars($r->nomeUsuarioVendedorAuxiliar) : 'Não informado') . '</td>';
                                echo '<td>' . (!empty($r->regiao) ? htmlspecialchars($r->regiao) : 'Não informado') . '</td>';

                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                                    echo '<td align="right">' . number_format($valor_total, 2, ',', '.') . '</td>';
                                }

                                // Status Orc (com motivo, se houver, mantendo padrão das outras regras)
                                $motivo = !empty($r->motivo) ? " Motivo: " . htmlspecialchars($r->motivo) : '';
                                echo '<td>' . htmlspecialchars($r->nome_status_orc) . $motivo . '</td>';

                                // Status OS textual para este caso
                                echo '<td>PARA ORÇAR</td>';

                                // Descrição agregada
                                echo '<td>' . $desc_itens . '</td>';

                                // Demais colunas
                                echo '<td>' . htmlspecialchars($r->nomenat) . '</td>';
                                echo '<td>' . htmlspecialchars($r->nomeserv) . '</td>';
                                echo '</tr>';

                                $somatorio_global += $valor_total;
                                $at_least_one_rule_displayed_for_this_budget = true;
                                // ================================================================

                            }
                            
                            // MOTOR DE REGRAS GENÉRICO
                            if (!empty($rules_for_this_budget)) {
                                $orca_item = $this->relatorios_model->tabela('orcamento_item', 'idOrcamentos =' . $r->idOrcamentos);

                                foreach ($rules_for_this_budget as $rule) {
                                    $desc_banco_para_regra = '';
                                    $valor_orc_para_regra = 0;
                                    $count_itens_na_regra = 1;
                                    $items_found_for_this_rule = false;
    
                                    foreach ($orca_item as $itemo) {
                                        $statusItemOrcamento = property_exists($itemo, 'status_item') ? (int)$itemo->status_item : null;
                                        if ($statusItemOrcamento !== $rule['item_status_required']) continue;
    
                                        $os_item = $this->relatorios_model->tabela('os', 'idOrcamento_item =' . $itemo->idOrcamento_item);
                                        
                                        if (!empty($os_item) && isset($os_item[0]->idStatusOs) && in_array((int)$os_item[0]->idStatusOs, $rule['os_valid_statuses'])) {
                                            $items_found_for_this_rule = true;
                                            $valor_orc_para_regra += property_exists($itemo, 'valor_total') ? (float)$itemo->valor_total : 0;
                                            
                                            // Lógica de DEBUG mantida
                                            $osStatusItem = (int)$os_item[0]->idStatusOs;
                                            $ositem_html = "<u><b> OS:</b>" . htmlspecialchars($os_item[0]->idOs) . "</u> <span style='color:red; font-size:9px;'>(Item St: ".$statusItemOrcamento.", OS St: ".$osStatusItem.")</span>";

                                            $desc_banco_para_regra .= "<b> " . $count_itens_na_regra++ . "- </b>" . htmlspecialchars(substr($itemo->descricao_item, 0, 60)) . "(...) " . $ositem_html . "</br>";
                                        }
                                    }
    
                                    if ($items_found_for_this_rule) {
                                        $at_least_one_rule_displayed_for_this_budget = true;
                                        $data_cad = date("Y/m/d", strtotime($r->data_abertura));
                                        $vencimento = date('d/m/Y', strtotime('+' . $r->validade . ' days', strtotime($data_cad)));
                                        echo '<tr>';
                                        echo '<td align="center">' . htmlspecialchars($r->idOrcamentos) . '</td>';
                                        echo '<td align="center">' . date("d/m/Y", strtotime($r->data_abertura)) . '</td>';
                                        echo '<td align="right">' . htmlspecialchars($vencimento) . '</td>';
                                        echo '<td>' . htmlspecialchars($r->nomeCliente) . '</td>';
                                        echo '<td>' . htmlspecialchars($r->nomeVendedor) . '</td>';
                                        echo '<td>' . (!empty($r->nomeUsuarioVendedorAuxiliar) ? htmlspecialchars($r->nomeUsuarioVendedorAuxiliar) : 'Não informado') . '</td>';
                                        echo '<td>' . (!empty($r->regiao) ? htmlspecialchars($r->regiao) : 'Não informado') . '</td>';
                                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                                            echo '<td align="right">' . number_format($valor_orc_para_regra, 2, ",", ".") . '</td>';
                                        }
                                        $motivo = !empty($r->motivo) ? " Motivo: " . htmlspecialchars($r->motivo) : '';
                                        echo '<td>' . htmlspecialchars($r->nome_status_orc) . $motivo . '</td>';
                                        echo '<td>' . htmlspecialchars($rule['display_group_name']) . '</td>';
                                        echo '<td>' . $desc_banco_para_regra . '</td>';
                                        echo '<td>' . htmlspecialchars($r->nomenat) . '</td>';
                                        echo '<td>' . htmlspecialchars($r->nomeserv) . '</td>';
                                        echo '</tr>';
                                        $somatorio_global += $valor_orc_para_regra;
                                    }
                                }
                            }
                            
                            if ($at_least_one_rule_displayed_for_this_budget) {
                                $processed_orc_ids_for_subrule_display[] = $r->idOrcamentos;
                            }

                            if ($at_least_one_rule_displayed_for_this_budget && !in_array($r->idOrcamentos, $processed_orc_ids_for_total)) {
                                $totalos++;
                                $processed_orc_ids_for_total[] = $r->idOrcamentos;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php echo $this->pagination->create_links();
} ?>

<script type="text/javascript">
$(document).ready(function() {
    
    // --- Lógica de UI (sem alterações) ---
    $('#checkClientes').click(function() { $('#divClientes').toggle(this.checked); });
    $('#checkVendedores').click(function() { $('#divVendedor').toggle(this.checked); });
    $('#checkVendedoresAux').click(function() { $('#divVendedorAux').toggle(this.checked); });
    $('#checkRegiao').click(function() { $('#divRegiao').toggle(this.checked); });
    $('#checkStatusOrcamento').click(function() { $('#divStatusOrcamento').toggle(this.checked); });
    $('#checkStatusOs').click(function() { $('#divStatusOs').toggle(this.checked); });
    
    $("#pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
        minLength: 1,
        select: function(event, ui) { $('#idProdutos').val(ui.item.id); }
    });
    $('.datap').inputmask("date", { inputFormat: "dd/mm/yyyy", placeholder: "DD/MM/AAAA" });
    $(".datap").datepicker({ dateFormat: 'dd/mm/yy' });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

    // --- Lógica de Impressão (sem alterações) ---
    $("#imprimirRelTable").click(function(e) {
        e.preventDefault();
        var contentToPrint = $('#printRelTable').clone();
        contentToPrint.find('#rel_table').addClass('table_print');
        var mywindow = window.open('', 'SGI', 'height=600,width=800');
        mywindow.document.write('<html><head><title>Imprimir</title>');
        mywindow.document.write('<style>.table_print{border-collapse: collapse;font-family:Arial;font-size:10px;width:100%;} .table_print td, .table_print th {border:1px solid #ccc;padding: 4px;}</style>');
        mywindow.document.write('</head><body>' + contentToPrint.html() + '</body></html>');
        mywindow.print();
        mywindow.close();
        return true;
    });


    // --- INÍCIO DA NOVA LÓGICA DE EXPORTAÇÃO PARA .XLSX ---

    /**
     * Função que exporta uma tabela HTML para um arquivo .XLSX formatado.
     * @param {jQuery} $table - O objeto jQuery da tabela.
     * @param {string} filename - O nome do arquivo (ex: "relatorio.xlsx").
     */
    function exportTableToXLSX($table, filename) {
        // 1. Coleta os dados da tabela
        var data = [];
        var header = [];
        
        // Pega o cabeçalho
        //$table.find('thead tr th').each(function() {
        $table.find('thead tr td, thead tr th').each(function() {
            header.push($(this).text().trim());
        });
        data.push(header);

        // Pega as linhas de dados
        $table.find('tbody tr').each(function() {
            var rowData = [];
            $(this).find('td').each(function() {
                var cell = $(this);
                var text;
                
                // Trata a célula de descrição para manter quebras de linha e remover o debug
                if (cell.find('br').length > 0) {
                    var cellHtml = cell.html().replace(/<br\s*\/?>/ig, "\n"); 
                    var tempDiv = $('<div>').html(cellHtml);
                    tempDiv.find('span').remove(); // Remove o span de debug
                    text = tempDiv.text().trim();
                } else {
                    text = cell.text().trim();
                }
                rowData.push(text);
            });
            data.push(rowData);
        });

        // 2. Cria a planilha usando a biblioteca SheetJS
        var worksheet = XLSX.utils.aoa_to_sheet(data);

        // 3. Define a formatação (A PARTE MAIS IMPORTANTE)
        var row_heights = [];
        for (var i = 0; i < data.length; i++) {
            // Define uma altura maior para as linhas de dados, mantendo o cabeçalho com altura padrão.
            if (i > 0) { 
                // Você pode ajustar este valor como quiser. 60 é uma altura boa para 3-4 linhas de texto.
                row_heights.push({ hpt: 60 }); // hpt = height in points
            } else {
                row_heights.push({ hpt: 20 }); // Altura para o cabeçalho
            }
        }
        worksheet['!rows'] = row_heights;

        // Opcional: Definir a largura das colunas
        worksheet['!cols'] = [
            { wch: 8 },  // Orç.
            { wch: 12 }, // Data Orc.
            { wch: 12 }, // Vencimento
            { wch: 40 }, // Cliente
            { wch: 20 }, // Gerente
            { wch: 20 }, // Vendedor
            { wch: 15 }, // Região
            { wch: 15 }, // Total
            { wch: 30 }, // Status Orc
            { wch: 30 }, // Status OS
            { wch: 60 }, // Descrição (coluna mais larga)
            { wch: 20 }, // Nat. Ope.
            { wch: 20 }  // Grupo Serv.
        ];

        // 4. Cria o arquivo Excel e força o download
        var workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Relatório");
        XLSX.writeFile(workbook, filename);
    }

    // Evento de clique que chama a nova função de exportação
    $(".export-csv-rel").on('click', function(event) {
        event.preventDefault(); 
        var filename = $(this).data("filename") + '.xlsx'; // Mudamos a extensão para .xlsx
        exportTableToXLSX($('#rel_table'), filename);
    });

    // --- FIM DA NOVA LÓGICA ---
});

// Configuração do Datepicker em Português
$.datepicker.regional['pt-BR'] = {
    closeText: 'Fechar', prevText: '&#x3c;Anterior', nextText: 'Pr&oacute;ximo&#x3e;', currentText: 'Hoje',
    monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun', 'Jul','Ago','Set','Out','Nov','Dez'],
    dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
    dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
    weekHeader: 'Sm', dateFormat: 'dd/mm/yy', firstDay: 0, isRTL: false, showMonthAfterYear: false, yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['pt-BR']);

// Evento de clique para exportar CSV
$(".export-csv-only-rel").on('click', function(event) {
    event.preventDefault();
    var filename = $(this).data("filename") + '.csv';
    exportTableToCSV($('#rel_table'), filename);
});

function exportTableToCSV($table, filename) {
    var data = [];
    var header = [];
    $table.find('thead tr td, thead tr th').each(function() {
        header.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
    });
    data.push(header.join(";"));

    $table.find('tbody tr').each(function() {
        var rowData = [];
        $(this).find('td').each(function() {
            var cell = $(this);
            var text;
            if (cell.find('br').length > 0) {
                var cellHtml = cell.html().replace(/<br\s*\/?>/ig, "\n");
                var tempDiv = $('<div>').html(cellHtml);
                tempDiv.find('span').remove();
                text = tempDiv.text().trim();
            } else {
                text = cell.text().trim();
            }
            rowData.push('"' + text.replace(/"/g, '""') + '"');
        });
        data.push(rowData.join(";"));
    });

    // *** AQUI O SEGREDO DO BOM ***
    var csvContent = "\uFEFF" + data.join("\n");
    var blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });

    if (navigator.msSaveBlob) {
        navigator.msSaveBlob(blob, filename);
    } else {
        var link = document.createElement("a");
        if (link.download !== undefined) {
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}
</script>
