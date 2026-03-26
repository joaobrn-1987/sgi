<?php $permissoes = unserialize($result->permissoes); ?>
<div class="span12" style="margin-left: 0">
    <form action="<?php echo base_url(); ?>index.php/permissoes/editar" id="formPermissao" method="post">

        <div class="span12" style="margin-left: 0">

            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-lock"></i>
                    </span>
                    <h5>Editar Permissão</h5>
                </div>
                <div class="widget-content">

                    <div class="span4">
                        <label>Nome da Permissão</label>
                        <input name="nome" type="text" id="nome" class="span12" value="<?php echo $result->nome; ?>" />
                        <input type="hidden" name="idPermissao" value="<?php echo $result->idPermissao; ?>">

                    </div>

                    <div class="span3">
                        <label>Situação</label>

                        <select name="situacao" id="situacao" class="span12">
                            <?php if ($result->situacao == 1) {
                                $sim = 'selected';
                                $nao = '';
                            } else {
                                $sim = '';
                                $nao = 'selected';
                            } ?>
                            <option value="1" <?php echo $sim; ?>>Ativo</option>
                            <option value="0" <?php echo $nao; ?>>Inativo</option>
                        </select>

                    </div>
                    <div class="span4">
                        <br />
                        <label>
                            <input name="" type="checkbox" value="1" id="marcarTodos" />
                            <span class="lbl"> Marcar Todos</span>

                        </label>
                        <br />
                    </div>

                    <div class="control-group">
                        <label for="documento" class="control-label"></label>
                        <div class="controls">

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vCliente'])) {
                                                            if ($permissoes['vCliente'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vCliente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Cliente</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aCliente'])) {
                                                            if ($permissoes['aCliente'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aCliente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Cliente</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eCliente'])) {
                                                            if ($permissoes['eCliente'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eCliente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Cliente</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dCliente'])) {
                                                            if ($permissoes['dCliente'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dCliente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Cliente</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vAlmoxarifado'])) {
                                                            if ($permissoes['vAlmoxarifado'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vAlmoxarifado" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Almoxarifado</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aAlmoxarifado'])) {
                                                            if ($permissoes['aAlmoxarifado'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aAlmoxarifado" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Almoxarifado</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eAlmoxarifado'])) {
                                                            if ($permissoes['eAlmoxarifado'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eAlmoxarifado" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Almoxarifado</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dAlmoxarifado'])) {
                                                            if ($permissoes['dAlmoxarifado'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dAlmoxarifado" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Almoxarifado</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vPedidocompraalmox'])) {
                                                            if ($permissoes['vPedidocompraalmox'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vPedidocompraalmox" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Almoxarifado P.C.</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aPedidocompraalmox'])) {
                                                            if ($permissoes['aPedidocompraalmox'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aPedidocompraalmox" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Almoxarifado P.C.</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['ePedidocompraalmox'])) {
                                                            if ($permissoes['ePedidocompraalmox'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="ePedidocompraalmox" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Almoxarifado P.C.</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dPedidocompraalmox'])) {
                                                            if ($permissoes['dPedidocompraalmox'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dPedidocompraalmox" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Almoxarifado P.C.</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aPermisaocompras'])) {
                                                            if ($permissoes['aPermisaocompras'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aPermisaocompras" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Permitir Almoxarifado Comprar</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vGerenciaalmo'])) {
                                                            if ($permissoes['vGerenciaalmo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vGerenciaalmo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Gerência Almoxarifado</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eVale'])) {
                                                            if ($permissoes['eVale'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eVale" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Vale</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['ePecamorta'])) {
                                                            if ($permissoes['ePecamorta'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="ePecamorta" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Peça Morta</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eLiberarpcp'])) {
                                                            if ($permissoes['eLiberarpcp'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eLiberarpcp" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Liberar PCP</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vCotacao'])) {
                                                            if ($permissoes['vCotacao'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vCotacao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Cotação</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aCotacao'])) {
                                                            if ($permissoes['aCotacao'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aCotacao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Cotação</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eCotacao'])) {
                                                            if ($permissoes['eCotacao'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eCotacao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Cotação</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dCotacao'])) {
                                                            if ($permissoes['dCotacao'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dCotacao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Cotação</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vPedCompra'])) {
                                                            if ($permissoes['vPedCompra'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vPedCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Pedido Compra</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aPedCompra'])) {
                                                            if ($permissoes['aPedCompra'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aPedCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Pedido Compra</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['ePedCompra'])) {
                                                            if ($permissoes['ePedCompra'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="ePedCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Pedido Compra</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dPedCompra'])) {
                                                            if ($permissoes['dPedCompra'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dPedCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Pedido Compra</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vAutCompra'])) {
                                                            if ($permissoes['vAutCompra'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vAutCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Autorização Compra</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aAutCompra'])) {
                                                            if ($permissoes['aAutCompra'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aAutCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Autorização Compra</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['pSolCompra'])) {
                                                            if ($permissoes['pSolCompra'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="pSolCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Permitir Solicitação de Compra</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['aAutCompraPCP'])){ if($permissoes['aAutCompraPCP'] == '1'){echo 'checked';}}?> name="aAutCompraPCP" class="marcar" type="checkbox"  value="1" />
                                                <span class="lbl"> Autorização Compra PCP</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['aAutCompraFIN'])){ if($permissoes['aAutCompraFIN'] == '1'){echo 'checked';}}?> name="aAutCompraFIN" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Autorização Compra Financeiro</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['aAutCompraDir'])){ if($permissoes['aAutCompraDir'] == '1'){echo 'checked';}}?> name="aAutCompraDir" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Autorização Compra Diretoria</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['aAutCompraDirTec'])){ if($permissoes['aAutCompraDirTec'] == '1'){echo 'checked';}}?> name="aAutCompraDirTec" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Autorização Compra Dir. Téc.</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vFornecedor'])) {
                                                            if ($permissoes['vFornecedor'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vFornecedor" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Fornecedor</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aFornecedor'])) {
                                                            if ($permissoes['aFornecedor'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aFornecedor" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Fornecedor</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eFornecedor'])) {
                                                            if ($permissoes['eFornecedor'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eFornecedor" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Fornecedor</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dFornecedor'])) {
                                                            if ($permissoes['dFornecedor'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dFornecedor" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Fornecedor</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vProduto'])) {
                                                            if ($permissoes['vProduto'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vProduto" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Produto</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aProduto'])) {
                                                            if ($permissoes['aProduto'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aProduto" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Produto</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eProduto'])) {
                                                            if ($permissoes['eProduto'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eProduto" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Produto</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dProduto'])) {
                                                            if ($permissoes['dProduto'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dProduto" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Produto</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vDesenho'])) {
                                                            if ($permissoes['vDesenho'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vDesenho" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Versionamento Desenho</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aDesenho'])) {
                                                            if ($permissoes['aDesenho'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aDesenho" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Versionamento Desenho</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eDesenho'])) {
                                                            if ($permissoes['eDesenho'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eDesenho" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Versionamento Desenho</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dDesenho'])) {
                                                            if ($permissoes['dDesenho'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dDesenho" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Versionamento Desenho</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vInsumo'])) {
                                                            if ($permissoes['vInsumo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vInsumo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Insumo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aInsumo'])) {
                                                            if ($permissoes['aInsumo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aInsumo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Insumo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eInsumo'])) {
                                                            if ($permissoes['eInsumo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eInsumo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Insumo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dInsumo'])) {
                                                            if ($permissoes['dInsumo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dInsumo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Insumo</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vEstoque'])) {
                                                            if ($permissoes['vEstoque'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vEstoque" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Estoque</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aEstoque'])) {
                                                            if ($permissoes['aEstoque'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aEstoque" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Estoque</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['sEstoque'])) {
                                                            if ($permissoes['sEstoque'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="sEstoque" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Saida Estoque</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['valorEstoque'])) {
                                                            if ($permissoes['valorEstoque'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="valorEstoque" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Valor Estoque</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vCategoria'])) {
                                                            if ($permissoes['vCategoria'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vCategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Categoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aCategoria'])) {
                                                            if ($permissoes['aCategoria'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aCategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Categoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eCategoria'])) {
                                                            if ($permissoes['eCategoria'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eCategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Categoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dCategoria'])) {
                                                            if ($permissoes['dCategoria'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dCategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Categoria</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vSubcategoria'])) {
                                                            if ($permissoes['vSubcategoria'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vSubcategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Subcategoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aSubcategoria'])) {
                                                            if ($permissoes['aSubcategoria'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aSubcategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Subcategoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eSubcategoria'])) {
                                                            if ($permissoes['eSubcategoria'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eSubcategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Subcategoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dSubcategoria'])) {
                                                            if ($permissoes['dSubcategoria'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dSubcategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Subcategoria</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vMaquina'])) {
                                                            if ($permissoes['vMaquina'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vMaquina" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Maquina</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aMaquina'])) {
                                                            if ($permissoes['aMaquina'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aMaquina" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Maquina</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eMaquina'])) {
                                                            if ($permissoes['eMaquina'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eMaquina" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Maquina</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dMaquina'])) {
                                                            if ($permissoes['dMaquina'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dMaquina" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Maquina</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>


                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vMaquinausuario'])) {
                                                            if ($permissoes['vMaquinausuario'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vMaquinausuario" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Maquina User</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aMaquinausuario'])) {
                                                            if ($permissoes['aMaquinausuario'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aMaquinausuario" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Maquina User</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eMaquinausuario'])) {
                                                            if ($permissoes['eMaquinausuario'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eMaquinausuario" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Maquina User</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dMaquinausuario'])) {
                                                            if ($permissoes['dMaquinausuario'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dMaquinausuario" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Maquina User</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eHoramaquinas'])) {
                                                            if ($permissoes['eHoramaquinas'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eHoramaquinas" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar HR/Maquina OS</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>






                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vOs'])) {
                                                            if ($permissoes['vOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar OS</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aOs'])) {
                                                            if ($permissoes['aOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar OS</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eOs'])) {
                                                            if ($permissoes['eOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar OS</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dOs'])) {
                                                            if ($permissoes['dOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir OS</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vvalorOs'])) {
                                                            if ($permissoes['vvalorOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vvalorOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Valor</span>
                                            </label>



                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vpedidoOs'])) {
                                                            if ($permissoes['vpedidoOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vpedidoOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Pedidos</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['apedidoOs'])) {
                                                            if ($permissoes['apedidoOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="apedidoOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Alterar Pedidos</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['reagendarOs'])) {
                                                            if ($permissoes['reagendarOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="reagendarOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Reagendar OS</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>    
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['reagendarOs'])){ if($permissoes['reagendarOs'] == '1'){echo 'checked';}}?> name="reagendarOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Reagendar OS - Todas</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['eDataReproCil'])){ if($permissoes['eDataReproCil'] == '1'){echo 'checked';}}?> name="eDataReproCil" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Reagendar OS - Cilindros</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['eDataReproServ'])){ if($permissoes['eDataReproServ'] == '1'){echo 'checked';}}?> name="eDataReproServ" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Reagendar OS - Serviço</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['eDataReproFab'])){ if($permissoes['eDataReproFab'] == '1'){echo 'checked';}}?> name="eDataReproFab" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Reagendar OS - Fabricação</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['eDataReproPet'])){ if($permissoes['eDataReproPet'] == '1'){echo 'checked';}}?> name="eDataReproPet" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Reagendar OS - Petrolina</span>
                                            </label>
                                        </td>
                                    
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['alterarStatusOsPeritagem'])){ if($permissoes['alterarStatusOsPeritagem'] == '1'){echo 'checked';}}?> name="alterarStatusOsPeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Alterar Status da O.S. (Peritagem)</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vdesenhoOs'])) {
                                                            if ($permissoes['vdesenhoOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vdesenhoOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Desenho</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['adesenhoOs'])) {
                                                            if ($permissoes['adesenhoOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="adesenhoOs" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Alterar Desenho</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vnotafiscalOs'])) {
                                                            if ($permissoes['vnotafiscalOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vnotafiscalOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar NF</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['anotafiscalOs'])) {
                                                            if ($permissoes['anotafiscalOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="anotafiscalOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Alterar NF</span>
                                            </label>
                                        </td>



                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vobscontroleOS'])) {
                                                            if ($permissoes['vobscontroleOS'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vobscontroleOS" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar OBS Controle</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eobscontroleOS'])) {
                                                            if ($permissoes['eobscontroleOS'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eobscontroleOS" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Ediar OBS Controle</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vDistribuirOs'])) {
                                                            if ($permissoes['vDistribuirOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vDistribuirOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Visualizar Distribuir OS</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eDistribuirOs'])) {
                                                            if ($permissoes['eDistribuirOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eDistribuirOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Inserir/Editar Distribuir OS</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vVerificacaocontroleOS'])) {
                                                            if ($permissoes['vVerificacaocontroleOS'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vVerificacaocontroleOS" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Verificação Controle</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eErificacaocontroleOS'])) {
                                                            if ($permissoes['eErificacaocontroleOS'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eErificacaocontroleOS" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Editar Verificação Controle</span>
                                            </label>
                                        </td>


                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vOrcamento'])) {
                                                            if ($permissoes['vOrcamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vOrcamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Orçamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aOrcamento'])) {
                                                            if ($permissoes['aOrcamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aOrcamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Orçamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eOrcamento'])) {
                                                            if ($permissoes['eOrcamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eOrcamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Orçamento</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['APOrcamento'])) {
                                                            if ($permissoes['APOrcamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="APOrcamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Aprovar Orçamento</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dOrcamento'])) {
                                                            if ($permissoes['dOrcamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dOrcamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Orçamento</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vArquivo'])) {
                                                            if ($permissoes['vArquivo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vArquivo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Arquivo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aArquivo'])) {
                                                            if ($permissoes['aArquivo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aArquivo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Arquivo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eArquivo'])) {
                                                            if ($permissoes['eArquivo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eArquivo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Arquivo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dArquivo'])) {
                                                            if ($permissoes['dArquivo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dArquivo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Arquivo</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vAnexo'])) {
                                                            if ($permissoes['vAnexo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vAnexo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Anexo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aAnexo'])) {
                                                            if ($permissoes['aAnexo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aAnexo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Anexo</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aAnexoNovo'])) {
                                                            if ($permissoes['aAnexoNovo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aAnexoNovo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Anexo Novo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eAnexo'])) {
                                                            if ($permissoes['eAnexo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eAnexo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Anexo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dAnexo'])) {
                                                            if ($permissoes['dAnexo'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dAnexo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Anexo</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vApontamento'])) {
                                                            if ($permissoes['vApontamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vApontamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Apontamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aApontamento'])) {
                                                            if ($permissoes['aApontamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aApontamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Apontamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eApontamento'])) {
                                                            if ($permissoes['eApontamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eApontamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Apontamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dApontamento'])) {
                                                            if ($permissoes['dApontamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dApontamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Apontamento</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vLancamento'])) {
                                                            if ($permissoes['vLancamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vLancamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Lançamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aLancamento'])) {
                                                            if ($permissoes['aLancamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aLancamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Lançamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['eLancamento'])) {
                                                            if ($permissoes['eLancamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="eLancamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Lançamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['dLancamento'])) {
                                                            if ($permissoes['dLancamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="dLancamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Lançamento</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['vPeritagem'])) {
                                                            if ($permissoes['vPeritagem'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="vPeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Visualizar Peritagem</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['aPeritagem'])) {
                                                            if ($permissoes['aPeritagem'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="aPeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Adicionar Peritagem</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['ePeritagem'])) {
                                                            if ($permissoes['ePeritagem'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="ePeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Editar Peritagem</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['cPeritagem'])) {
                                                            if ($permissoes['cPeritagem'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="cPeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Confirmar Peritagem</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['peritagemPec'])) {
                                                            if ($permissoes['peritagemPec'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="peritagemPec" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Peritagem de Peças</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['peritagemCil'])) {
                                                            if ($permissoes['peritagemCil'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="peritagemCil" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Peritagem de Cilindros</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['peritagemMaq'])) {
                                                            if ($permissoes['peritagemMaq'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="peritagemMaq" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Peritagem de Máquinas</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['peritagemSub'])) {
                                                            if ($permissoes['peritagemSub'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="peritagemSub" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Peritagem de Subconjuntos</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['vBacklog'])){ if($permissoes['vBacklog'] == '1'){echo 'checked';}}?> name="vBacklog" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Visualizar Backlog</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if(isset($permissoes['aBacklog'])){ if($permissoes['aBacklog'] == '1'){echo 'checked';}}?> name="aBacklog" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Adicionar Backlog</span>
                                            </label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['rCliente'])) {
                                                            if ($permissoes['rCliente'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="rCliente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Cliente</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['rServico'])) {
                                                            if ($permissoes['rServico'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="rServico" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Serviço</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['rOs'])) {
                                                            if ($permissoes['rOs'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="rOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório OS</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['rProduto'])) {
                                                            if ($permissoes['rProduto'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="rProduto" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Produto</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['rOrcamento'])) {
                                                            if ($permissoes['rOrcamento'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="rOrcamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Orçamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['rFinanceiro'])) {
                                                            if ($permissoes['rFinanceiro'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="rFinanceiro" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Financeiro</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['rOrdemcompra'])) {
                                                            if ($permissoes['rOrdemcompra'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="rOrdemcompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Ordem de Compra</span>
                                            </label>
                                        </td>
                                        <td colspan="1"></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['cUsuario'])) {
                                                            if ($permissoes['cUsuario'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="cUsuario" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Configurar Usuário</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['cEmitente'])) {
                                                            if ($permissoes['cEmitente'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="cEmitente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Configurar Emitente</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['cPermissao'])) {
                                                            if ($permissoes['cPermissao'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="cPermissao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Configurar Permissão</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['cBackup'])) {
                                                            if ($permissoes['cBackup'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="cBackup" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Backup</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['fComercial'])) {
                                                            if ($permissoes['fComercial'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="fComercial" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função Comercial</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['fPCP'])) {
                                                            if ($permissoes['fPCP'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="fPCP" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função PCP</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['fProducao'])) {
                                                            if ($permissoes['fProducao'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="fProducao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função Produção</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['fPeritagem'])) {
                                                            if ($permissoes['fPeritagem'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="fPeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função Peritagem</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['fSuprimentos'])) {
                                                            if ($permissoes['fSuprimentos'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="fSuprimentos" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função Suprimentos</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['fAlmoxarifado'])) {
                                                            if ($permissoes['fAlmoxarifado'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="fAlmoxarifado" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Função Almoxarifado</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['clientes'])) {
                                                            if ($permissoes['clientes'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="clientes" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> É Cliente</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['desenvolvedor'])) {
                                                            if ($permissoes['desenvolvedor'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="desenvolvedor" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> MODO desenvolvedor</span>
                                            </label>
                                        </td>
                                    </tr>



                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <label>
                                                <input <?php if (isset($permissoes['emailSobra'])) {
                                                            if ($permissoes['emailSobra'] == '1') {
                                                                echo 'checked';
                                                            }
                                                        } ?> name="emailSobra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Email Sobra</span>
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                <a href="<?php echo base_url() ?>index.php/permissoes" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>

    </form>

</div>


<script type="text/javascript" src="<?php echo base_url() ?>assets/js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {


        $("#marcarTodos").click(function() {

            if ($(this).attr("checked")) {
                $('.marcar').each(
                    function() {
                        $(this).attr("checked", true);
                    }
                );
            } else {
                $('.marcar').each(
                    function() {
                        $(this).attr("checked", false);
                    }
                );
            }

        });



        $("#formPermissao").validate({
            rules: {
                nome: {
                    required: true
                }
            },
            messages: {
                nome: {
                    required: 'Campo obrigatório'
                }
            }
        });



    });
</script>