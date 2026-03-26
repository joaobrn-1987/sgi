<div class="span12" style="margin-left: 0">
    <form action="<?php echo base_url(); ?>index.php/permissoes/adicionar" id="formPermissao" method="post">

        <div class="span12" style="margin-left: 0">

            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-lock"></i>
                    </span>
                    <h5>Cadastro de Permissão</h5>
                </div>
                <div class="widget-content">

                    <div class="span6">
                        <label>Nome da Permissão</label>
                        <input name="nome" type="text" id="nome" class="span12" />

                    </div>
                    <div class="span6">
                        <br />
                        <label>
                            <input name="marcarTodos" type="checkbox" value="1" id="marcarTodos" />
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
                                                <input name="vCliente" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Cliente</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aCliente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Cliente</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eCliente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Cliente</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="dCliente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Cliente</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input name="vAlmoxarifado" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Almoxarifado</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aAlmoxarifado" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Almoxarifado</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eAlmoxarifado" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Almoxarifado</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="dAlmoxarifado" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Almoxarifado</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input name="vPedidocompraalmox" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Almoxarifado P.C.</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aPedidocompraalmox" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Almoxarifado P.C.</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="ePedidocompraalmox" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Almoxarifado P.C.</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="dPedidocompraalmox" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Almoxarifado P.C.</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="aPermisaocompras" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Permitir Almoxarifado Comprar</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input name="vGerenciaalmo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Gerência Almoxarifado</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eVale" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Vale</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="ePecamorta" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Peça Morta</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="eLiberarpcp" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Liberar PCP</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input name="vCotacao" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Cotação</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aCotacao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Cotação</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eCotacao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Cotação</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="dCotacao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Cotação</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input name="vPedCompra" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Pedido Compra</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aPedCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Pedido Compra</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="ePedCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Pedido Compra</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="dPedCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Pedido Compra</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input name="vAutCompra" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Autorização Compra</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aAutCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Autorização Compra</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="pSolCompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Permitir Solicitação de Compra</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input name="aAutCompraPCP" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Autorização Compra PCP</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aAutCompraFIN" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Autorização Compra Financeiro</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="aAutCompraDir" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Autorização Compra Diretoria</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="aAutCompraDirTec" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Autorização Compra Dir. Téc.</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input name="vFornecedor" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Fornecedor</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aFornecedor" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Fornecedor</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eFornecedor" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Fornecedor</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="dFornecedor" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vProduto" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Produto</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aProduto" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Produto</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eProduto" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Produto</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dProduto" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir Produto</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input name="vDesenho" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Versionamento Desenho</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aDesenho" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Versionamento Desenho</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eDesenho" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Versionamento Desenho</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dDesenho" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vInsumo" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Insumo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aInsumo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Insumo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eInsumo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Insumo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dInsumo" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vEstoque" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Estoque</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="aEstoque" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Estoque</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="sEstoque" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Saída Estoque</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="valorEstoque" class="marcar" type="checkbox" checked="checked" value="1" />
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
                                                <input name="vCategoria" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Categoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aCategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Categoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eCategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Categoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dCategoria" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vSubcategoria" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Subcategoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aSubcategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Subcategoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eSubcategoria" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Subcategoria</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dSubcategoria" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vMaquina" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Maquina</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aMaquina" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Maquina</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eMaquina" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Maquina</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dMaquina" class="marcar" type="checkbox" value="1" />
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
                                                <input name="eHoramaquinas" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vMaquinausuario" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Maquina User</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aMaquinausuario" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Maquina User</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eMaquinausuario" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Maquina User</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dMaquinausuario" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vOs" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar OS</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar OS</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar OS</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Excluir OS</span>
                                            </label>
                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input name="vvalorOs" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Valor</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="vpedidoOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Pedidos</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="apedidoOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Alterar Pedidos</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="reagendarOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Reagendar OS</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input name="alterarStatusOsPeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Alterar Status da O.S. (Peritagem)</span>
                                            </label>
                                        </td>

                                    </tr>
                                    
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <label>
                                                <input name="vdesenhoOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Desenho</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="adesenhoOs" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Alterar Desenho</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="vnotafiscalOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar NF</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="anotafiscalOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Alterar NF</span>
                                            </label>
                                        </td>



                                    </tr>
                                    <tr>

                                        <td>
                                            <label>
                                                <input name="vobscontroleOS" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar OBS Controle</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eobscontroleOS" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Ediar OBS Controle</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="vDistribuirOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Distribuir OS</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="eDistribuirOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Inserir/Editar Distribuir OS</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="vVerificacaocontroleOS" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Visualizar Verificação Controle</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="eErificacaocontroleOS" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Verificação Controle</span>
                                            </label>
                                        </td>


                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input name="vOrcamento" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Orçamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aOrcamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Orçamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eOrcamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Orçamento</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="APOrcamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Aprovar Orçamento</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="dOrcamento" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vArquivo" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Arquivo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aArquivo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Arquivo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eArquivo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Arquivo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dArquivo" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vAnexo" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Anexo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aAnexo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Anexo</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="aAnexoNovo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Anexo Novo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eAnexo" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Anexo</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dAnexo" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vApontamento" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Apontamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aApontamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Apontamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eApontamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Apontamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dApontamento" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vLancamento" class="marcar" type="checkbox" checked="checked" value="1" />
                                                <span class="lbl"> Visualizar Lançamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="aLancamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Adicionar Lançamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="eLancamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Editar Lançamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="dLancamento" class="marcar" type="checkbox" value="1" />
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
                                                <input name="vPeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Visualizar Peritagem</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="aPeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Adicionar Peritagem</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="ePeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Editar Peritagem</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="cPeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Confirmar Peritagem</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input name="peritagemPec" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Peritagem de Peças</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="peritagemCil" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Peritagem de Cilindros</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="peritagemMaq" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Peritagem de Máquinas</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="peritagemSub" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Peritagem de Subconjuntos</span>
                                            </label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input name="rCliente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Cliente</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="rServico" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Serviço</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="rOs" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório OS</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="rProduto" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Produto</span>
                                            </label>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <label>
                                                <input name="rOrcamento" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Orçamento</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="rFinanceiro" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Financeiro</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="rOrdemcompra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Relatório Ordem de compra</span>
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
                                                <input name="cUsuario" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Configurar Usuário</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="cEmitente" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Configurar Emitente</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="cPermissao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Configurar Permissão</span>
                                            </label>
                                        </td>

                                        <td>
                                            <label>
                                                <input name="cBackup" class="marcar" type="checkbox" value="1" />
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
                                                <input name="fComercial" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função Comercial</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="fPCP" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função PCP</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="fProducao" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função Produção</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="fPeritagem" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função Peritagem</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="fSuprimentos" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função Suprimentos</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="fAlmoxarifado" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Função Almoxarifado</span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>
                                                <input name="clientes" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> É Cliente</span>
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input name="desenolvedor" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl">Modo desenvolvedor</span>
                                            </label>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <label>
                                                <input name="emailSobra" class="marcar" type="checkbox" value="1" />
                                                <span class="lbl"> Email Sobra</span>
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
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
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

        $(document).on('click', '#marcarTodos', function(event) {
            if ($(this).prop('checked')) {

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