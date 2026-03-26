<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tableimprimir.css" />
<style>
    .tdExibirPedido {
        width: 100%;
        border: 1px solid #EEEEEE;
    }

    .tamanho {
        display: none
    }

    .volume {
        display: none
    }

    .peso {
        display: none
    }

    .dimensoes {
        display: none
    }
</style>
<style type="text/css">
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 12px;
        width: 12px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #51a351;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #51a351;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(20px);
        -ms-transform: translateX(20px);
        transform: translateX(20px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<?php


echo "<br>";
echo "<br>";

?>
<div class="btn-group">
    <a class="btn dropdown-toggle" data-toggle="dropdown" role="button">
        Submenu
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li><a tabindex="-1" role="button" onclick="showDivSolicitar()">Solicitar Compra</a></li>
        <li><a tabindex="-1" role="button" href="<?php echo base_url() ?>index.php/suprimentos/almoxarifadocompras">Suprimentos</a></li>
        <!--<li><a tabindex="-1" role="button" onclick="showDivSuprimentos()">Suprimentos</a></li>
        <li><a tabindex="-1" role="button" onclick="showDivMaterialEntregue()">Material Entregue</a></li>-->
        <!--<li><a tabindex="-1" role="button" 'onclick="showDivRelatorio()">Entradas</a></li>
        <li><a tabindex="-1" role="button" 'onclick="showDivRelatorio2()">Saídas</a></li>
        <li class="divider"></li>
        <li><a tabindex="-1" role="button" 'onclick="showDivRelatorioDetalhado()">Relatório Detalhado</a></li>
        
        <li><a tabindex="-1" href="#"></a></li>
        <li class="divider"></li>
        <li><a tabindex="-1" href="#">Separated link</a></li>-->
    </ul>

</div>
<div id="suprimentos" style="display:none">
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Buscar Pedido de compra</h5>
                </div>
                <div class="widget-content nopadding">


                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <ul class="nav nav-tabs">
                            <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Filtro OS</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">

                                <div class="span12" id="divCadastrarOs">

                                    <form class="form-inline" action="<?php echo base_url() ?>index.php/suprimentos" method="post" name="form1" id="form1">


                                        <div class="span12" style="padding: 1%; margin-left: 0">

                                            <div class="span2" class="control-group">
                                                <label for="idPedidoCompra" class="control-label">Ordem de Compra</label>
                                                <input class="form-control" type="text" name="idPedidoCompra" id="idPedidoCompra" value="" autofocus class="span12">

                                            </div>

                                            <div class="span2" class="control-group">
                                                <label for="nf_fornecedor" class="control-label">N° NFe</label><br>
                                                <input class="form-control" type="text" name="nf_fornecedor" id="nf_fornecedor" value="" class="span12">

                                            </div>

                                            <div class="span3" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Status Ordem
                                                    Compra</label>
                                                <!--&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll22();">&nbsp;Marcar/Desmarcar todos-->
                                                <br>

                                                <select class="recebe-solici" class="controls" name="idStatuscompras" id="idStatuscompras">
                                                    <option value="todos">
                                                        TODOS
                                                    </option>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($dados_statuscompra as $so) {

                                                    ?>

                                                        <option value="<?php echo $so->idStatuscompras; ?>">
                                                            <?php echo $so->nomeStatus; ?>
                                                        </option>
                                                        <!--
                                                                <input type="checkbox" name="idStatuscompras[]" class='check'
                                                                    value="<?php //echo $so->idStatuscompras; 
                                                                            ?>">
                                                                &nbsp;<?php //echo $so->nomeStatus; 
                                                                        ?>
                                                                -->

                                                    <?php
                                                        //if ( ($i+1) % 4 == 0) echo "</tr>";

                                                        $i++;
                                                    }

                                                    ?>
                                                </select>

                                            </div>
                                            <div class="span2" class="control-group">
                                                <label for="numPedido" class="control-label">N° Cotação</label><br>
                                                <input class="form-control" type="text" name="numPedido" id="numPedido" value="" class="span12">

                                            </div>

                                        </div>


                                        <div class="span12" style="padding: 1%; margin-left: 0">


                                            <div class="span2" class="control-group">
                                                <label for="fornecedor" class="control-label">Fornecedor</label>
                                                <input class="span12" class="form-control" id="fornecedor" type="text" name="fornecedor" value="" />
                                                <input id="fornecedor_id" type="hidden" name="fornecedor_id" value="" />
                                            </div>
                                            <div class="span2" class="control-group">
                                                <label for="descricao" class="control-label">Descrição</label><br>
                                                <input class="form-control" type="text" name="descricao" id="descricao" value="" class="span12">

                                            </div>





                                            <div class="span3" class="control-group">
                                                <label for="x8" class="control-label">Empresa</label><br>
                                                <input size="11" class="form-control" id="empresaNum1" type="text" name="empresaNum1" value="" /> a
                                                <input id="empresaNum2" size="10" type="text" name="empresaNum2" value="" />
                                            </div>

                                            <div class="span3" class="control-group">
                                                <a onclick="filtrarDistribuirOs()" style="background-color: #f9f9f9; border: 0px;"><i class="icon-search" style="font-size:30px; float: right; margin-right:50% "></i></a>

                                            </div>


                                        </div>


                                    </form>

                                </div>





                            </div>

                        </div>

                    </div>

                </div>


                <span style="color: white">.</span>

            </div>

        </div>
    </div>
    <!--<form class="form-inline" action="<?php echo base_url() ?>index.php/suprimentos/montarpedidocompra"
                method="post" name="form1" id="form1">-->

    <div align='center'>

        <a role="button" name="btnGerarCotacao" value="btnGerarCotacao" class="btn btn-success" onclick="gerarCotacao()"><i class="icon-plus icon-white"></i>Imprimir/Gerar Cotação</a>
        <a role="button" name="btnGerarPedido" value="btnGerarPedido" class="btn btn-success" onclick="gerarPedidoCompra()"><i class="icon-plus icon-white"></i> Gerar Pedido</a>
        <a role="button" name="btnAbrirPedidos" value="btnAbrirPedidos" class="btn btn-success" onclick="abrirPedidosSelecionados()"><i class="icon-plus icon-white"></i> Abrir Pedidos</a>
        <!--<button type="submit" name="btnImprimSelecionados" value="btnImprimSelecionados" class="btn btn-success" style="height: 26px"><i class="icon-print icon-white"></i></button>
            -->
        <a href="#modal-imprimiritem3" role="button" data-toggle="modal" class="btn btn-success" style="height: 20px"><i class="icon-print icon-white"></i></a>
        <!--    
            <?php if (!empty($results)) {
                if ($results[0]->idStatuscompras <= 2 || $results[0]->idStatuscompras == 6) { ?>
                <a  href="#modal-imprimiritem3" role="button" data-toggle="modal" class="btn btn-success" style="height: 20px"><i class="icon-print icon-white"></i></a>
                <?php
                } else if ($results[0]->idStatuscompras > 2 && $results[0]->idStatuscompras != 6) { ?>
                <button type="submit" name="btnImprimSelecionados" value="btnImprimSelecionados" class="btn btn-success" style="height: 26px"><i class="icon-print icon-white"></i></button>
                <?php
                }   ?> -->
    <?php
            }   ?>
    <?php
    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dPedCompra')) {
    ?>
        <a id="excluir" class="btn btn-warning"><i class="icon-remove icon-white"></i> Excluir</a>
    <?php

    } ?>
    <?php

    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
    ?>
        <a id="alterar" style="margin-right: 1%" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i>Alterar O.C.</a>
    <?php
    } ?>
    </div>

    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Montar Pedido de compra</h5>

        </div>


        <div class="widget-content nopadding">


            <!-------------------------------------------------------------------->
            <input type="hidden" name="idPedidoCompra" value="<?= set_value('idPedidoCompra', null) ?>">
            <input type="hidden" name="nf_fornecedor" value="<?= set_value('nf_fornecedor', null) ?>">
            <input type="hidden" name="idOs" value="<?= set_value('idOs', null) ?>">
            <input type="hidden" name="idStatuscompras" value="<?= set_value('idStatuscompras', null) ?>">
            <input type="hidden" name="numPedido" value="<?= set_value('numPedido', null) ?>">
            <input type="hidden" name="fornecedor" value="<?= set_value('fornecedor', null) ?>">
            <input type="hidden" name="fornecedor_id" value="<?= set_value('fornecedor_id', null) ?>">
            <input type="hidden" name="descricao" value="<?= set_value('descricao', null) ?>">
            <input type="hidden" name="empresaNum1" value="<?= set_value('empresaNum1', null) ?>">
            <input type="hidden" name="empresaNum2" value="<?= set_value('empresaNum2', null) ?>">

            <!-------------------------------------------------------------------->

            <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                <thead>
                    <tr>
                        <!--
                            <?php
                            //if($this->permission->checkPermission($this->session->userdata('permissao'),'aPermisaocompras')){
                            ?>
                            <th>
                                Permissão
                            </th>
                            <?php
                            //}
                            ?>-->
                        <th><input type="checkbox" id="checkTodos" name="checkTodos" style="z-index:999"></th>
                        <th>OS</th>
                        <th>Data Alteração</th>
                        <th>Qtd.</th>
                        <th>Descrição</th>

                        <th>OBS</th>
                        <th>Data Cadastro
                            <!-- <th>Data que gerou Status:<br>Aguardando orçamento</th>-->
                        <th>Status</th>
                        <!--
                            <th>Grupo</th>-->
                        <!--<th>Cotação</th>-->
                        <th>O.C.</th>
                        <th>Data Pedido</th>
                        <!--                                   
                            <th>Fornecedor / NF</th>
                            <th>OBS</th>-->
                        <th></th>
                        <th></th>
                        <!--<th></th>-->
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (isset($results)) { ?>
                        <?php foreach ($results as $r) {
                            $color = '';
                            $codStatus = $r->idStatuscompras;
                            if ($codStatus == 1) {
                                $r->cor = '#000000';
                            } else if ($codStatus == 2) {
                                $r->cor = '#03036c';
                            } else if ($codStatus == 3) {
                                $r->cor = '#008000';
                            } else if ($codStatus == 4) {
                                $r->cor = '#A020F0';
                            } else if ($codStatus == 5) {
                                $r->cor = '#c17d00';
                            } else if ($codStatus == 6) {
                                $r->cor = '#FF0000';
                            }

                        ?>

                            <tr>
                                <!--
                                    <?php
                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aPermisaocompras')) {
                                    ?>
                                    <td>
                                        <?php if ($r->idOs == '10' || $r->idOs == '11' || $r->idOs == '12') { ?>
                                        <label class="switch">
                                        
                                            <?php if ($r->statusPermissao == 1) { ?>
                                                <input type="checkbox" checked name='checkPermAlmo' id='checkPermAlmo<?php echo $r->idInsumos ?>'  value='<?php echo $r->idInsumos ?>'>
                                            <?php
                                            } else { ?>
                                                <input type="checkbox" name='checkPermAlmo' id='checkPermAlmo<?php echo $r->idInsumos ?>' value='<?php echo $r->idInsumos ?>'>
                                            <?php
                                            }
                                            ?>
                                            
                                            <span class="slider round"></span>
                                        </label>
                                        <?php
                                        } ?>
                                    </td> 
                                    <?php

                                    }
                                    ?>-->
                                <td>
                                    <font>
                                        <!--<?php if ($r->statusPermissao == 1 || $this->permission->checkPermission($this->session->userdata('permissao'), 'aPermisaocompras')) { ?>-->

                                        <!--<?php } ?>-->
                                        <input type='hidden' value='<?php echo $r->idStatuscompras; ?>' name='idStatuscompras_[]'>
                                        <input type='checkbox' id="checkDistri" value='<?php echo $r->idDistribuir; ?>' name='idDistribuir_[]'><?php echo $r->idDistribuir; ?>
                                    </font>

                                </td>
                                <td>
                                    <font>
                                        <?php
                                        echo $r->idOs;
                                        ?>
                                    </font>
                                </td>
                                <td>
                                    <font>
                                        <span style="display:none"><?php if (!empty($r->data_alteracao)) {
                                                                        $date = new DateTime($r->data_alteracao);
                                                                        echo $date->format('Y-m-d H:i:s');
                                                                    }
                                                                    ?></span>
                                        <?php if (!empty($r->data_alteracao)) {
                                            $date = new DateTime($r->data_alteracao);
                                            echo $date->format('d/m/Y');
                                            // echo date("d/m/Y H:i:s", strtotime($r->data_alteracao));
                                            //echo $r->data_alteracao;
                                        }
                                        ?>
                                    </font>
                                </td>
                                <td>
                                    <font>
                                        <?php echo $r->quantidade;
                                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'ePedidocompraalmox')) {
                                            if ($r->idStatuscompras == 1 || $r->idStatuscompras == 2) { ?>
                                                <a href="#modal-editarquantidade" style="margin-right: 1%" role="button" data-toggle="modal" quantidadeDistri="<?php if (isset($r->quantidade)) {
                                                                                                                                                                    echo $r->quantidade;
                                                                                                                                                                } ?>" idDistribuirOS="<?php if (isset($r->idDistribuir)) {
                                                                                                                                                                                                                                            echo $r->idDistribuir;
                                                                                                                                                                                                                                        } ?>" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>
                                        <?php
                                            }
                                        } ?>
                                    </font>
                                </td>
                                <td>
                                    <font>
                                        <?php echo $r->descricaoInsumo . " " . $r->dimensoes; ?>
                                    </font>
                                </td>

                                <td>
                                    <font>
                                        <?php echo $r->obs; ?>
                                    </font>
                                </td>
                                <td>
                                    <font><span style="display:none"><?php if (!empty($r->datacadastrodist)) {
                                                                            $date = new DateTime($r->datacadastrodist);
                                                                            echo $date->format('Y-m-d H:i:s');
                                                                        }
                                                                        ?></span>
                                        <?php echo date("d/m/Y", strtotime($r->datacadastrodist)); ?></font>
                                </td>
                                <td>
                                    <font>
                                        <?php echo $r->nomeStatus; ?>
                                        <?php if (!empty($r->datastatusentregue)) {
                                            echo " " . date("d/m/Y", strtotime($r->datastatusentregue));
                                        }
                                        ?>
                                    </font>
                                </td>
                                <!--
                                    <td >
                                        <font size='1'>
                                            <?php if (isset($r->nomegrupo)) {
                                                echo $r->nomegrupo;
                                            } ?>
                                        </font>


                                    </td>-->
                                <!--<td><?php echo $r->idPedidoCotacao; ?></td>-->

                                <td>
                                    <font>
                                        <?php echo $r->idPedidoCompra; ?>
                                        <?php
                                        if ($r->idPedidoCompra <> '') {
                                            if ($r->idStatuscompras <> 7) {
                                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
                                        ?>
                                                    <a href="#modal-editarpedidocompra2" style="margin-right: 1%" role="button" data-toggle="modal" itempedidocompra="<?php if (isset($r->idPedidoCompraItens)) {
                                                                                                                                                                            echo $r->idPedidoCompraItens;
                                                                                                                                                                        } ?>" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>
                                        <?php

                                                }
                                            }
                                        }
                                        ?>
                                    </font>

                                </td>
                                <td>
                                    <font>
                                        <span style="display:none"><?php if (!empty($r->cadpedgerado)) {
                                                                        $date = new DateTime($r->cadpedgerado);
                                                                        echo $date->format('Y-m-d H:i:s');
                                                                    }
                                                                    ?></span>
                                        <?php
                                        if (!empty($r->cadpedgerado)) {
                                            echo date("d/m/Y", strtotime($r->cadpedgerado));
                                        } else {
                                        }
                                        ?>
                                    </font>
                                </td>
                                <!--
                                    <td >
                                        <font >
                                            <?php if (isset($r->nomeFornecedor)) {
                                                echo $r->nomeFornecedor;
                                            } ?> / <b>
                                                <?php if (isset($r->notafiscal)) {
                                                    echo $r->notafiscal;
                                                } ?>
                                        </font></b>
                                    </td>
                                    <td >
                                        <font >
                                            <?php if (isset($r->obscompras)) {
                                                echo $r->obscompras;
                                            } ?>
                                        </font>
                                    </td>-->
                                <td>
                                    <font><?php echo $r->user; ?>
                                        <!--<a href="#modal-usuario<?php echo $r->idPedidoCompraItens; ?>" style="margin-right: 1%" role="button" data-toggle="modal" idPedidoCompraItens_1="<?php echo $r->idPedidoCompraItens; ?>" class="btn tip-top" ><i class="icon icon-user"></i></a>-->

                                    </font>
                                </td>

                                <?php
                                echo '<td>';

                                if ($r->idPedidoCompra <> '' && !empty($r->idEmitente))
                                //if($r->idPedidoCompra <> '')
                                {
                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vPedCompra')) {
                                        echo '<a href="' . base_url() . 'index.php/suprimentos/imprimir_pedido/' . $r->idPedidoCompra . '" style="margin-right: 1%" class="btn tip-top"  target="_blank"><i class="icon-print icon-white"></i></a>';
                                    }
                                }


                                ?>


                                <?php

                                echo '</td>';
                                /*echo '<td>';
                                    if($r->idPedidoCompra <> '')
                                    {
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
                                        ?>
                                                <a href="<?php echo base_url().'index.php/suprimentos/editarpedidosuprimentos/'.$r->idPedidoCompra ?>"
                                                    style="margin-right: 1%" role="button" data-toggle="modal"
                                                    cotacao="<?php echo $r->idPedidoCompra;?>" class="btn btn-info tip-top"><i
                                                        class="icon-pencil icon-white"></i></a>
                                                <?php
                                        
                                    }
                                    }
                        
                                    echo '</td>';*/
                                echo '<td>';

                                if (isset($r->idPedidoCompraItens) && $r->idPedidoCompraItens <> '') {

                                    if ($r->idStatuscompras <> 8 && $r->idStatuscompras <> 9 && $r->idStatuscompras <> 7) {
                                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dPedCompra')) {
                                ?>
                                            <a href="#modal-excluiritempedido" style="margin-right: 1%" role="button" data-toggle="modal" idPedidoCompraItens_1="<?php echo $r->idPedidoCompraItens; ?>" class="btn btn-warning tip-top"><i class="icon-remove icon-white"></i></a>
                                <?php

                                        }
                                    }
                                } /*else if($r->idStatuscompras == 1 || $r->idStatuscompras == 2 || $r->idStatuscompras == 6) {
                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'dPedCompra')){
                                            ?>
                                                <a href="#modal-deletardistribuir" style="margin-right: 1%" role="button" data-toggle="modal"
                                                    idDistribuir_1="<?php echo $r->idDistribuir; ?>"
                                                    class="btn btn-danger tip-top"><i class="icon-remove icon-white"></i></a>
                                            <?php
                                            
                                        }
                                    }*/

                                echo '</td>';
                                echo '</tr>';

                                ?>

                                <!--
                                    <div id="modal-usuario<?php if (isset($r->idPedidoCompraItens)) {
                                                                echo $r->idPedidoCompraItens;
                                                            } ?>" class="modal hide fade"
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h5 id="myModalLabel">Histórico de Usuario</h5>
                                        </div>
                                        <div class="modal-body">
                                            Informação do usuario que cadastrou e sequencia de alterações realizadas:<br>
                                            <?php echo $r->histo_alteracao; ?>
                                        </div>


                                    </div>-->

                            <?php
                        } ?>
                        <?php } ?>


                </tbody>
            </table>
            <?php //echo $this->pedidocompra->estoque_atual(1); 
            ?>
            <div class="form-actions" align='center'>

                <a role="button" name="btnGerarCotacao" value="btnGerarCotacao" class="btn btn-success" onclick="gerarCotacao()"><i class="icon-plus icon-white"></i>Imprimir/Gerar Cotação</a>
                <a role="button" name="btnGerarPedido" value="btnGerarPedido" class="btn btn-success" onclick="gerarPedidoCompra()"><i class="icon-plus icon-white"></i> Gerar Pedido</a>
                <a role="button" name="btnAbrirPedidos" value="btnAbrirPedidos" class="btn btn-success" onclick="abrirPedidosSelecionados()"><i class="icon-plus icon-white"></i> Abrir Pedidos</a>
                <!--<button type="submit" name="btnImprimSelecionados" value="btnImprimSelecionados" class="btn btn-success" style="height: 26px"><i class="icon-print icon-white"></i></button>
                    -->
                <a href="#modal-imprimiritem3" role="button" data-toggle="modal" class="btn btn-success" style="height: 20px"><i class="icon-print icon-white"></i></a>
                <!--
                    <?php if (!empty($results)) {
                        if ($results[0]->idStatuscompras <= 2 || $results[0]->idStatuscompras == 6) { ?>
                        <a  href="#modal-imprimiritem3" role="button" data-toggle="modal" class="btn btn-success" style="height: 20px"><i class="icon-print icon-white"></i></a>
                        <?php
                        } else if ($results[0]->idStatuscompras > 2 && $results[0]->idStatuscompras != 6) { ?>
                        <button type="submit" name="btnImprimSelecionados" value="btnImprimSelecionados" class="btn btn-success" style="height: 26px"><i class="icon-print icon-white"></i></button>
                        <?php
                        }   ?>
                    <?php
                    }   ?>-->
                <?php
                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dPedCompra')) {
                ?>
                    <a id="excluir2" class="btn btn-warning"><i class="icon-remove icon-white"></i> Excluir</a>
                <?php

                } ?>
                <?php

                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
                ?>
                    <a id="alterar2" style="margin-right: 1%" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i>Alterar O.C.</a>
                <?php
                } ?>

            </div>
            <div id="modal-imprimiritem3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 id="myModalLabel">Empresa</h5>
                </div>
                <div class="modal-body">
                    <select class="form-control" name="idEmitente2" id="idEmitente2">

                        <?php foreach ($dados_emitente2 as $e) { ?>

                            <option value="<?php echo $e->id; ?>" <?php if ($e->id == 1) {
                                                                        echo "selected='selected'";
                                                                    } ?>><?php echo $e->nome; ?></option>
                        <?php } ?>

                    </select>

                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <a type="submit" name="btnImprimSelecionados" value="btnImprimSelecionados" class="btn btn-danger" onclick='imprimir()'>Imprimir</a>
                </div>
            </div>

        </div>
    </div>
    <!--</form>-->
</div>

<div id="solicitar" style="display:<?php echo $solicitacao; ?>">
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5 style="    padding-right: 0px;">Solicitar Compras</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs">
                                    <form class="form-inline">
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <!--
                                            <div class="span1" class="control-group">
                                                <label for="cliente" class="control-label">PN:</label>
                                                <input class="span12" class="form-control" id="pn"
                                                    type="text" name="pn" value="" />
                                            </div>-->
                                            <div class="span2" class="control-group">
                                                <label for="cliente" class="control-label">Categoria:</label>
                                                <input class="span12" class="form-control" id="categoriaEntrada" type="text" name="categoriaEntrada" value="" />
                                                <input id="idCategoriaEntrada" type="hidden" name="idCategoriaEntrada" value="" />
                                            </div>
                                            <div class="span2" class="control-group">
                                                <label for="cliente" class="control-label">Subcategoria:</label>
                                                <input class="span12" class="form-control" id="subcategoriaEntrada" type="text" name="subcategoriaEntrada" value="" />
                                                <input id="idSubcategoriaEntrada" type="hidden" name="idSubcategoriaEntrada" value="" />
                                            </div>
                                            <div class="span2" class="control-group">
                                                <label for="cliente" class="control-label">Descrição:</label>
                                                <input class="span12" class="form-control" id="prod" type="text" name="prod" value="" />
                                                <input id="idProdutos" type="hidden" name="idProdutos" value="" />
                                                <input 'class="span12" ' class="form-control" id="pn" type="hidden" name="pn" value="" />
                                            </div>
                                            <div class="span2" class="control-group">
                                                <label for="idMedicao" class="control-label">Unidade:</label>
                                                <select class="span12 form-control" name="idMedicao" id="idMedicao" onchange="verificar(this.value)">
                                                    <option value="0">Unidade</option>
                                                    <option value="1">Unidade/Comprimento</option>
                                                    <option value="2">Unidade/Volume</option>
                                                    <option value="3">Unidade/Peso</option>
                                                    <option value="4">Unidade/Dimensões</option>
                                                </select>
                                            </div>
                                            <div class="tamanho">
                                                <div class="span1" class="control-group" style="margin-left: 35px">
                                                    <label for="cliente" class="control-label">Comprimento(mm):</label>
                                                    <input class="span12" class="form-control" id="tamanho" type="text" name="tamanho" value="" />
                                                    <input id="tamanho" type="hidden" name="tamanho" value="" />
                                                </div>
                                            </div>
                                            <div class="volume">
                                                <div class="span1" class="control-group" style="margin-left: 35px">
                                                    <label for="cliente" class="control-label">Volume(ml):</label>
                                                    <input class="span12" class="form-control" id="volume" type="text" name="volume" value="" />
                                                    <input id="volume" type="hidden" name="volume" value="" />
                                                </div>
                                            </div>
                                            <div class="peso">
                                                <div class="span1" class="control-group" style="margin-left: 35px">
                                                    <label for="cliente" class="control-label">Peso(g):</label>
                                                    <input class="span12" class="form-control" id="peso" type="text" name="peso" value="" />
                                                    <input id="peso" type="hidden" name="peso" value="" />
                                                </div>
                                            </div>
                                            <div class="dimensoes">
                                                <div class="span2" class="control-group" style="margin-left: 35px">
                                                    <label for="cliente" class="control-label">Dimensões(mm):</label>
                                                    <div class="span12">
                                                        <input class="span4" class="form-control" id="dimensoesL" type="text" name="dimensoesL" value="" placeholder='Largura' />
                                                        <input class="span4" class="form-control" id="dimensoesC" type="text" name="dimensoesC" value="" placeholder='Comp.' />
                                                        <input class="span4" class="form-control" id="dimensoesA" type="text" name="dimensoesA" value="" placeholder='Altura' />
                                                    </div>


                                                </div>
                                            </div>
                                            <!--
                                            <div class="span1" class="control-group">
                                                <label for="cliente" class="control-label">Dimensões</label>
                                                <input class="span12" class="form-control" id="dimensoes"
                                                    type="text" name="dimensoes" value="" />
                                            </div> -->
                                            <div class="span1" class="control-group" style="margin-left: 35px">
                                                <label for="cliente" class="control-label">Qtd. Est.:</label>
                                                <input disabled class="span12" class="form-control" id="qtdEst" type="text" name="qtdEst" value="" />
                                            </div>
                                            <div class="span1" class="control-group">
                                                <label for="cliente" class="control-label">Qtd.:</label>
                                                <input class="span12" class="form-control" id="qtd" type="text" name="qtd" value="" />
                                                <input id="qtd" type="hidden" name="qtd" value="" />
                                            </div>

                                        </div>

                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span3" class="control-group">
                                                <label for="idEmpresa" class="control-label">Empresa:</label>
                                                <select class="span12 form-control" name="idEmpresa" id="idEmpresa" onchange="alterarLocal2(this.value)">
                                                    <?php foreach ($dados_emitente as $r) {
                                                        if ($r->id == "1") { ?>
                                                            <option value="10">
                                                                <?php echo $r->nome ?> </option>
                                                        <?php
                                                        } ?>
                                                        <?php
                                                        if ($r->id == "2") { ?>
                                                            <option value="11">
                                                                <?php echo $r->nome ?> </option>
                                                        <?php
                                                        } ?>
                                                        <?php
                                                        if ($r->id == "3") { ?>
                                                            <option value="12">
                                                                <?php echo $r->nome ?> </option>
                                                        <?php
                                                        } ?>
                                                        <?php
                                                        if ($r->id == "4") { ?>
                                                            <option value="13">
                                                                <?php echo $r->nome ?> </option>
                                                        <?php
                                                        } ?>
                                                    <?php
                                                    } ?>

                                                </select>
                                            </div>
                                            <div class="span3" class="control-group">
                                                <label for="localp" class="control-label">OBS:</label>
                                                <textarea class="span12" class="form-control" id="obs" type="text" name="obs" value=""></textarea>
                                            </div>

                                            <!--
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
                                            </div>-->
                                            <div class="span1" class="control-group">
                                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aPedidocompraalmox')) { ?>
                                                    <label for="cliente" class="control-label"></label>
                                                    <a class="btn" onclick="verificarInsumoCategoriaSubcategoria()" style="justify-content: flex-end; display: table;">Adicionar</a>

                                                <?php } ?>
                                            </div>
                                            <div class="span1" class="control-group" style="margin-left:10px">
                                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aPedidocompraalmox')) { ?>
                                                    <label for="cliente" class="control-label"></label>
                                                    <a class="btn btn-success" onclick="cadastrarItensOS()" style="justify-content: flex-end; display: table;">Finalizar</a>

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
            <h5>Itens à comprar</h5>
        </div>

        <div class="widget-content nopadding" id="divTableInsert">
            <form action="<?php echo base_url() ?>index.php/almoxarifado/cadastrarEntradas" id="formEntradas" enctype="multipart/form-data" method="post">
                <div class="buttons">

                    <a id="imprimir3" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                    <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="CadastroEntradas">Excel</a>
                </div>
                <table class="table table-bordered " id="tableInsert" name="tableInsert" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif; font-size:10px;" border="1">
                    <thead>
                        <tr>
                            <th>PN.</th>
                            <th>Descrição</th>
                            <th>Dimensões</th>
                            <th>Quantidade</th>
                            <th>Empresa</th>
                            <th>OBS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    </br></br>
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Últimas solicitações</h5>
        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered " id="tableSupri" name="tableSupri" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif; font-size:10px;" border="1">
                <thead>
                    <tr>
                        <th>Data Solicitação</th>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>Status</th>
                        <th>O.C.</th>
                        <th>OBS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dados_ultimascompras as $r) {

                        echo '<tr>';
                            echo '<td>';
                            echo date("d/m/Y", strtotime($r->datacadastrodist));
                            echo '</td>';

                            echo '<td>';
                            $html = $r->descricaoInsumo;
                            if(!empty($r->dimensoes)){
                                $html.=" ".$r->dimensoes;
                            } 
                            if(!empty($r->comprimento)){
                                $html.=" X ".$r->comprimento." mm";
                            } 
                            if(!empty($r->volume)){
                                $html.=" ".$r->volume." ml";
                            } 
                            if(!empty($r->peso)){
                                $html.=" ".$r->peso." g";
                            } 
                            
                            if(!empty($r->dimensoesL)){
                                $html .= " X LARG.: ".$r->dimensoesL." MM";
                            }
                            if(!empty($r->dimensoesC)){
                                $html .= " X COMP.: ".$r->dimensoesC." MM";
                            }
                            if(!empty($r->dimensoesA)){
                                $html .= " X ALT.: ".$r->dimensoesA." MM";
                            }
                            echo $html;
                            echo '</td>';

                            echo '<td>';
                            echo $r->quantidade;
                            echo '</td>';

                            echo '<td>';
                            echo $r->nomeStatus;
                            echo '</td>';

                            echo '<td>';
                            echo $r->idPedidoCompra;
                            echo '</td>';

                            echo '<td>';
                            echo $r->obscompras;
                            echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="materialentregue" style="display:<?php echo $entregue; ?>">
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Aguardando Armazenamento</h5>
        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered " id="tableMateriaisArmazenar">
                <thead>
                    <tr>
                        <th></th>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>O.C.</th>
                        <th>Empresa</th>
                        <th>Departamento</th>
                        <th>Local</th>
                        <th>Status</th>
                        <th></th>
                        <!--
                        <th></th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados_aguardandoarmazenamento as $r) { ?>
                        <tr>
                            <td>
                                <input type='checkbox' id='idAlmoAgArmaz_' value='<?php echo $r->idAlmoAgArmaz; ?>' name='idAlmoAgArmaz_'>
                            </td>
                            <td>
                                <?php echo $r->descricaoInsumo; ?><input type='hidden' id='descricaoInsumoAgArmaz' value='<?php echo $r->descricaoInsumo; ?>' name='descricaoInsumoAgArmaz'>
                            </td>

                            <td>
                                <?php echo $r->quantidade; ?><input type='hidden' id='quantidadeAgArmaz' value='<?php echo $r->quantidade; ?>' name='quantidadeAgArmaz'>
                            </td>

                            <td>
                                <?php echo $r->idOrdemCompra; ?>
                            </td>

                            <td>
                                <?php echo $r->nome; ?>
                            </td>

                            <td>
                                <?php
                                if ($r->idDepartamentoSUG == null || empty($r->idDepartamentoSUG)) {
                                    echo '<select id="idDepartamento">';
                                    echo '<option value=""></option>';
                                    foreach ($dados_depinsumos as $s) {
                                        echo '<option value="' . $s->idAlmoEstoqueDep . '">' . $s->descricaoDepartamento . '</option>';
                                    }
                                    echo '</select>';
                                } else {
                                    echo '<select id="idDepartamento">';
                                    echo '<option value=""></option>';
                                    foreach ($dados_depinsumos as $s) {
                                        if ($r->idDepartamentoSUG == $s->idAlmoEstoqueDep) {
                                            echo '<option selected value="' . $s->idAlmoEstoqueDep . '">' . $s->descricaoDepartamento . '</option>';
                                        } else {
                                            echo '<option value="' . $s->idAlmoEstoqueDep . '">' . $s->descricaoDepartamento . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                } ?>

                            </td>

                            <td>

                                <?php if ($r->idLocalSUG == null  || empty($r->idLocalSUG)) { ?>
                                    <input type='text' name="descricaoLocal" id="descricaoLocal" value="<?php echo $r->local; ?>">
                                    <input type='hidden' value="<?php echo $r->idAlmoEstoqueLocais; ?>">
                                <?php
                                } else { ?>
                                    <input type='text' name="descricaoLocal" id="descricaoLocal" value="<?php echo $r->localSUG; ?>">
                                    <input type='hidden' value="<?php echo $r->idLocalSUG; ?>">
                                <?php } ?>
                            </td>

                            <td>
                                <?php echo $r->descricaoAgArmaz; ?>
                            </td>

                            <td>
                                <a style="margin-right: 1%" href="#modal-cancelarEntrada" data-toggle="modal" role="button" class="btn btn-danger tip-top " cancelarEntradaId="<?php echo $r->idAlmoAgArmaz ?>" descricaoEntrada="<?php echo $r->descricaoInsumo ?>" qtdEntrada="<?php echo $r->quantidade ?>" class="excluir">
                                    <font size=1>Excluir</font>
                                </a>

                            </td>
                            <!--
                        <td>
                            <a style="margin-right: 1%" href="#modal-adicionarEntrada" data-toggle="modal" role="button" 
                                class="btn btn-success tip-top " adicionarEntradaId = "<?php echo $r->idAlmoAgArmaz ?>" descricaoEntrada = "<?php echo $r->descricaoInsumo ?>" qtdEntrada = "<?php echo $r->quantidade ?>" class="inserir">
                                <font size=1>Adicionar</font>
                            </a>
                        </td>-->

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div align='center'>
        <a 'href="#modal-entradaTodos" ' data-toggle="modal" role="button" name="btnGerarCotacao" value="btnGerarCotacao" class="btn btn-success" onclick="modelEntrada()"><i class="icon-plus icon-white"></i> Confirmar Entrada (todos)</a>
        <a 'href="#modal-entradaSelecionados" ' data-toggle="modal" role="button" name="btnGerarCotacao" value="btnGerarCotacao" class="btn btn-info" onclick="modelEntrada(1)"><i class="icon-plus icon-white"></i> Confirmar Entrada (selecionados)</a>
    </div>
</div>

<div id="abrirpedido" style="display:none">
    <a href="#modal-imprimiritem" style="margin-right: 1%" role="button" data-toggle="modal" title="Imprimir Parcial">
        <font color="blue"><i class="icon-print icon-white">Imprimir</i></font>
    </a>
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Itens Pedido de compra</h5>

        </div>
        <div>
            <table class="table table-bordered" id="tableEditarSuprimentos">
                <thead>
                    <tr>

                        <th>Nº OS </th>
                        <th>Qtd<br>Editar</th>
                        <th>Descrição</th>

                        <th width='100'>OBS</th>

                        <th>Status<a href="#modal-ipi" style="margin-right: 1%" role="button" data-toggle="modal" title="Editar IPI">
                                <font color='red'><i class="icon-pencil icon-white"></i></font>
                            </a></th>
                        <th>Data <br>Entregue<a href="#modal-ipi" style="margin-right: 1%" role="button" data-toggle="modal" title="Editar IPI">
                                <font color='red'><i class="icon-pencil icon-white"></i></font>
                            </a></th>
                        <th>Grupo</th>
                        <th width='15'>QTD<br>recebida</th>
                        <th>Valor Unit.</th>
                        <th width='40'>IPI% <a href="#modal-ipi" style="margin-right: 1%" role="button" data-toggle="modal" title="Editar IPI">
                                <font color='red'><i class="icon-pencil icon-white"></i></font>
                            </a></th>
                        <th>ICMS</th>
                        <th>Valor <br>total</th>

                        <th>N° NF <a href="#modal-ipi" style="margin-right: 1%" role="button" data-toggle="modal" title="Editar IPI">
                                <font color='red'><i class="icon-pencil icon-white"></i></font>
                            </a>
                        </th>


                    </tr>
                </thead>
                <tbody>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>



        <div class="span12" style="padding: 1%; margin-left: 0">
            <div class="form-actions" align='center'>
                <button type="submit" name="btnSalvar" value="btnSalvar" class="btn btn-success" onclick="salvarAlteracoesPedidos('0','salvar')"><i class="icon-plus icon-white"></i> SALVAR
                    ITENS</button>
            </div>
        </div>
    </div>
    <div name="divModels" id="divModels">
    </div>
    <div id="modal-editar_1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Liberar item para editar quantidade</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="id_item_pc1" name="id_item_pc1" value="" />

            <input id="idPedidoCompra4" type="hidden" name="idPedidoCompra4" value="" />
            <h5 style="text-align: center">Deseja realmente liberar este item para edição?</h5>
        </div>
        <div class="modal-footer">
            <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
            <a class="btn btn-danger" onclick="destravarEdicao()">Liberar</a>
        </div>
    </div>
    <div id="modal-editar_0" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?php echo base_url() ?>index.php/suprimentos/editar_0" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel">Travar item para edição de quantidade</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_item_pc2" name="id_item_pc2" value="" />
                <input id="idPedidoCompra" type="hidden" name="idPedidoCompra" value="" />
                <h5 style="text-align: center">Deseja travar edição?</h5>
            </div>
            <div class="modal-footer">
                <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
                <a class="btn btn-danger" onclick="travarEdicao()">Confirmar</a>
            </div>
        </form>
    </div>

</div>

<div id="modal-editarpedidocompra2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="a" class="close" data-dismiss="modal" aria-hidden="true">×</a>
            <h5 id="myModalLabel">Alterar número do pedido</h5>
    </div>
    <div class="modal-body">
        <input type="hidden" id="idPedidoCompraItens_" name="idPedidoCompraItens_" value="" />
        Enviar item para o pedido de compra número:<input type="text" id="idPedidoCompra_n" name="idPedidoCompra_n" value="" />


    </div>
    <div class="modal-footer">
        <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
        <a class="btn btn-danger" onclick="editarpcalmoxarifado()">Salvar</a>
    </div>
</div>

<div id="modal-excluiritempedido" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <a type="button" class="close" data-dismiss="modal" aria-hidden="true">×</a>
        <h5 id="myModalLabel">Excluir Item da Cotação</h5>
    </div>
    <div class="modal-body">
        <input type="hidden" id="idPedidoCompraItens_nn" name="idPedidoCompraItens_nn" value="" />
        <h5 style="text-align: center">Deseja realmente excluir este item do pedido?</h5>
        Para excluir o pedido de compra INTEIRO com todos os itens, selecione SIM, caso deseja excluir somente esse
        item do pedido seleciona NÃO: <select name='todos' id='todos'>
            <option value='nao' selected>Não</option>
            <option value='sim'>sim</option>
        </select>
    </div>
    <div class="modal-footer">
        <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
        <a class="btn btn-danger" onclick="excluir_itempedidoalmoxarifado()">Excluir</a>
    </div>
</div>

<div id="modal-excluirSelect" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <a type="button" class="close" data-dismiss="modal" aria-hidden="true">×</a>
    </div>
    <div class="modal-body" id="tableExcluir">
        <h5 style="text-align: center">Deseja realmente cancelar estes itens?</h5>
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>OS</td>
                    <th>Qtd</td>
                    <th>Descrição</td>
                    <th>Status</td>
                </tr>
            </thead>
            <tbody id="tbodyExcluir">
            </tbody>
        </table>


    </div>
    <div class="modal-footer">
        <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
        <a class="btn btn-danger" onclick="cancelarItensAlmoxarifado()">Excluir</a>
    </div>
</div>

<div id="modal-editarpedidocompraitens" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<form action="<?php echo base_url() ?>index.php/suprimentos/alterarItens" method="post">-->
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterar número do pedido</h5>
    </div>
    <div class="modal-body">
        <input type="hidden" id="idPedidoCompraItens_2" name="idPedidoCompraItens_2" value="" />
        Enviar item para o pedido de compra número: <input type="text" id="idPedidoCompra_n2" name="idPedidoCompra_n2" value="" /> (Se deseja criar uma nova O.C., clique no botão GERAR NOVA ORDEM)</br></br>
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>OS</td>
                    <th>Qtd</td>
                    <th>Descrição</td>
                    <th>Status</td>
                    <th>O.C.</td>
                </tr>
            </thead>
            <tbody id="tbodyAlterar">
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
        <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
        <a class="btn btn-success" name="btnAlterar" value="btnAlterar" onclick="alterarItensAlmoxarifado('alterar')">Alterar para O.C. Existente</a>
        <a class="btn btn-danger" name="btnGerar" value="btnGerar" onclick="alterarItensAlmoxarifado('gerar')">Gerar Nova Ordem</a>
    </div>
    <!--</form>-->
</div>

<div id="modal-editarquantidade" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterar Quantidade: </h5>
    </div>
    <div class="modal-body">
        <input type="hidden" name="idDistrbuirOs2" id="idDistrbuirOs2" value="" />
        Quantidade:
        <!---->
        <input type="text" name="quantidadeModal" id="quantidadeModal" value="" />

    </div>
    <div class="modal-footer">
        <a data-dismiss="modal" aria-hidden="true" aria-hidden="true">Cancelar</a>
        <button class="btn btn-danger" data-dismiss="modal" name="alterarQuantidade" id="alterarQuantidade">Salvar</button>
    </div>
</div>

<div id="modal-imprimiritem" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Marcar itens para imprimir</h5>
    </div>
    <div class="modal-body">
        <br><br>
        <b>Qtd ***** Descrição</b><br>
        <div id="divImprimirItem" name="divImprimirItem">
        </div>

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <a class="btn btn-danger" onclick="imprimiritem()">Imprimir</a>
    </div>
</div>

<div id="modal-entradaTodos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<form action="<?php echo base_url() ?>index.php/suprimentos/alterarItens" method="post">-->
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Confirmar Entrada de todos os itens</h5>
    </div>
    <div class="modal-body">
        <table class="table table-bordered " id="tbodyEntradaTodos">
            <thead>
                <tr>
                    <th>Descrição</td>
                    <th>Qtd</td>
                    <th>Departamento</td>
                    <th>Local</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
        <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
        <a class="btn btn-danger" name="btnGerarEntradas" id="btnGerarEntradas" value="btnGerarEntradas" onclick="modelEntradaB()">Confirmar</a>
    </div>
    <!--</form>-->
</div>

<div id="modal-entradaSelecionados" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<form action="<?php echo base_url() ?>index.php/suprimentos/alterarItens" method="post">-->
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Confirmar Entrada dos itens selecionados</h5>
    </div>
    <div class="modal-body">
        <table class="table table-bordered " id="tbodyEntradaSelecionados">
            <thead>
                <tr>
                    <th>Descrição</td>
                    <th>Qtd</td>
                    <th>Departamento</td>
                    <th>Local</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
        <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
        <button class="btn btn-danger" name="btnGerarEntradas" id="btnGerarEntradas" value="btnGerarEntradas" onclick="modelEntradaB(1)">Confirmar</button>
    </div>
    <!--</form>-->
</div>

<div id="modal-cancelarEntrada" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<form action="<?php echo base_url() ?>index.php/suprimentos/alterarItens" method="post">-->
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Confirmar a exclusão deste item</h5>
    </div>
    <div class="modal-body">
        <table class="table table-bordered " id="tbodyCancelarEntrada">
            <thead>
                <tr>
                    <th>Descrição</td>
                    <th>Qtd</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
    <div class="modal-footer">
        <a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>
        <a class="btn btn-danger" name="btnGerar" value="btnGerar" onclick="cancelarEntrada()">Confirmar</a>
    </div>
    <!--</form>-->
</div>


<script>
    $('#idStatuscompras2_').change(function() {
        window.location = $(this).val();
    });
    $('#nto').change(function() {
        window.location = $(this).val();
    });
    $('#os_').change(function() {
        window.location = $(this).val();
    });
</script>
<script type="text/javascript">
    var dados_statuscompra2 = <?php echo json_encode($this->pedidocompra_model->getstatus_compra2('0')); ?>;
    var dados_statusgrupo;
    var dados_statuscondicao2 = <?php echo json_encode($this->pedidocompra_model->getstatus_cond_pg('')); ?>;



    var descricao = document.getElementById('prod');

    descricao.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if (key == 8 || key == 46) {
            document.querySelector("#idProdutos").value = "";
            document.querySelector('#pn').value = "";
            document.querySelector('#qtdEst').value = "";
            //document.querySelector("#idCategoriaEntrada").value = "";
            //document.querySelector("#categoriaEntrada").value = "";
            //document.querySelector("#idSubcategoriaEntrada").value = "";
            //document.querySelector("#subcategoriaEntrada").value = "";
        }
    };

    descricao.onkeyup = function() {
        document.querySelector("#idProdutos").value = "";
        document.querySelector('#pn').value = "";
        document.querySelector('#qtdEst').value = "";
        //document.querySelector("#idCategoriaEntrada").value = "";
        //document.querySelector("#categoriaEntrada").value = "";
        //document.querySelector("#idSubcategoriaEntrada").value = "";
        //document.querySelector("#subcategoriaEntrada").value = "";  
    };

    var pn = document.getElementById('pn');

    pn.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if (key == 8 || key == 46) {
            document.querySelector("#idProdutos").value = "";
            document.querySelector('#prod').value = "";
            document.querySelector('#qtdEst').value = "";
            document.querySelector("#idCategoriaEntrada").value = "";
            document.querySelector("#categoriaEntrada").value = "";
            document.querySelector("#idSubcategoriaEntrada").value = "";
            document.querySelector("#subcategoriaEntrada").value = "";
        }
    };

    pn.onkeyup = function() {
        document.querySelector("#idProdutos").value = "";
        document.querySelector('#prod').value = "";
        document.querySelector('#qtdEst').value = "";
        document.querySelector("#idCategoriaEntrada").value = "";
        document.querySelector("#categoriaEntrada").value = "";
        document.querySelector("#idSubcategoriaEntrada").value = "";
        document.querySelector("#subcategoriaEntrada").value = "";
    };

    var categoriaEntrada = document.getElementById('categoriaEntrada');

    categoriaEntrada.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if (key == 8 || key == 46) {
            document.querySelector("#idProdutos").value = "";
            document.querySelector('#pn').value = "";
            document.querySelector('#qtdEst').value = "";
            document.querySelector("#idCategoriaEntrada").value = "";
            document.querySelector("#idSubcategoriaEntrada").value = "";
            document.querySelector("#subcategoriaEntrada").value = "";
        }
    };

    categoriaEntrada.onkeyup = function() {
        var key = event.keyCode || event.charCode;
        if (key != 9) {
            document.querySelector("#idProdutos").value = "";
            document.querySelector('#pn').value = "";
            document.querySelector('#qtdEst').value = "";
            document.querySelector("#idCategoriaEntrada").value = "";
            document.querySelector("#idSubcategoriaEntrada").value = "";
            document.querySelector("#subcategoriaEntrada").value = "";
        }
    };

    var subcategoriaEntrada = document.getElementById('subcategoriaEntrada');

    subcategoriaEntrada.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if (key == 8 || key == 46) {
            document.querySelector("#idProdutos").value = "";
            document.querySelector('#pn').value = "";
            document.querySelector('#qtdEst').value = "";
            document.querySelector("#idSubcategoriaEntrada").value = "";
        }
    };

    subcategoriaEntrada.onkeyup = function() {
        var key = event.keyCode || event.charCode;
        if (key != 9) {
            document.querySelector("#idProdutos").value = "";
            document.querySelector('#pn').value = "";
            document.querySelector('#qtdEst').value = "";
            document.querySelector("#idSubcategoriaEntrada").value = "";
        }
    };

    function inserirItensTabela() {
        var table = document.getElementById("tableInsert").getElementsByTagName('tbody')[0];;

        var pn = document.querySelector("#pn").value;
        var prod = document.querySelector("#prod").value;
        var idProdutos = document.querySelector("#idProdutos").value;
        //var dimensoes = document.querySelector("#dimensoes").value;
        var medicao = document.querySelector("#idMedicao").value;
        var comprimento = document.querySelector("#tamanho").value;
        var volume = document.querySelector("#volume").value;
        var peso = document.querySelector("#peso").value;
        var dimensoesL = document.querySelector("#dimensoesL").value;
        var dimensoesC = document.querySelector("#dimensoesC").value;
        var dimensoesA = document.querySelector("#dimensoesA").value;
        var qtd = document.querySelector("#qtd").value;
        var empresap = document.getElementById('idEmpresa');
        var idEmpresa = empresap.options[empresap.selectedIndex].value;
        var nomeEmpresa = empresap.options[empresap.selectedIndex].text;
        var obs = document.querySelector("#obs").value;
        if (typeof idProdutos != "UNDEFINED" && idProdutos != null && idProdutos != "" && typeof prod != "UNDEFINED" && prod != null && prod != "" && typeof prod != "UNDEFINED" && qtd != null && qtd != "" && typeof idEmpresa != "UNDEFINED" && idEmpresa != null && idEmpresa != "") {

            if (isNaN(qtd) == true) {
                return alert("O campo quantidade deve possuir apenas numeros.");
            }
            if (isNaN(idProdutos) == true) {
                return alert("O produto não é valido.");
            }
            if (table.rows.length == null || typeof table.rows.length == "undefined") {
                var numOfRows = 0;
            } else {
                var numOfRows = table.rows.length;
            }
            // var numOfCols = table.rows[numOfRows-1].cells.length;
            // Insere uma linha no fim da tabela.
            var newRow = table.insertRow(numOfRows);
            newCell = newRow.insertCell(0);
            newCell.innerHTML = pn.split("|")[0] + "<input value='" + idProdutos + "' name='idProdutoTD_' id='idProdutoTD_' type='hidden'/>";

            newCell = newRow.insertCell(1);
            newCell.innerHTML = prod.split("|")[0];
            newCell.value = prod;


            newCell = newRow.insertCell(2);
            newCell.innerHTML = "<input value='" + medicao + "' name='medicaoTD_' id='medicaoTD_' type='hidden'/><input value='" + comprimento + "' name='comprimentoTD_' id='comprimentoTD_' type='hidden'/><input value='" + volume + "' name='volumeTD_' id='volumeTD_' type='hidden'/><input value='" + peso + "' name='pesoTD_' id='pesoTD_' type='hidden'/><input value='" + dimensoesL + "' name='dimensoesLTD_' id='dimensoesLTD_' type='hidden'/><input value='" + dimensoesC + "' name='dimensoesCTD_' id='dimensoesCTD_' type='hidden'/><input value='" + dimensoesA + "' name='dimensoesATD_' id='dimensoesATD_' type='hidden'/>"+(medicao == 1 ? comprimento+" CM":(medicao == 2 ? volume+" ML":(medicao == 3 ? peso+" G":(medicao == 4 ? (dimensoesL!=""?"LARG.: "+dimensoesL+" MM ":"")+(dimensoesC!=""?"COMP.: "+dimensoesC+" MM ":"")+(dimensoesA!=""?"ALT.: "+dimensoesA+" MM ":"") :""))));


            newCell = newRow.insertCell(3);
            newCell.innerHTML = qtd + "<input value='" + qtd + "' name='qtdTD_' id='qtdTD_' type='hidden'/>";


            newCell = newRow.insertCell(4);
            newCell.innerHTML = nomeEmpresa + "<input value='" + idEmpresa + "' name='osTD_' id='osTD_' type='hidden'/>";

            newCell = newRow.insertCell(5);
            newCell.innerHTML = obs + "<input value='" + obs + "' name='obsTD_' id='obsTD_' type='hidden'/>";
            newCell = newRow.insertCell(6);
            newCell.innerHTML = '';

            document.querySelector("#pn").value = "";
            document.querySelector("#prod").value = "";
            document.querySelector("#idProdutos").value = "";
            document.querySelector("#dimensoes").value = "";
            document.querySelector("#qtd").value = "";
            document.querySelector("#obs").value = "";


        } else {
            return alert("Os campos Descrição, Quantidade e Empresa não podem ser vazios.");
        } /**/
    }

    function cadastrarItensOS() {
        var idProdutoTD_ = Array.apply(null, document.querySelectorAll("#idProdutoTD_"));
        var osTD_ = Array.apply(null, document.querySelectorAll("#osTD_"));
        //var idDimensoesTD_ = Array.apply(null, document.querySelectorAll("#idDimensoesTD_"));
        var medicaoTD_ = Array.apply(null, document.querySelectorAll("#medicaoTD_"));
        var comprimentoTD_ = Array.apply(null, document.querySelectorAll("#comprimentoTD_"));
        var volumeTD_ = Array.apply(null, document.querySelectorAll("#volumeTD_"));
        var pesoTD_ = Array.apply(null, document.querySelectorAll("#pesoTD_"));
        var dimensoesLTD_ = Array.apply(null, document.querySelectorAll("#dimensoesLTD_"));
        var dimensoesCTD_ = Array.apply(null, document.querySelectorAll("#dimensoesCTD_"));
        var dimensoesATD_ = Array.apply(null, document.querySelectorAll("#dimensoesATD_"));
        var obsTD_ = Array.apply(null, document.querySelectorAll("#obsTD_"));
        var qtdTD_ = Array.apply(null, document.querySelectorAll("#qtdTD_"));
        var data = new Array();
        var obj = {};
        for (var x = 0; x < idProdutoTD_.length; x++) {
            obj = {};
            obj = {
                'idProdutoTD': idProdutoTD_[x].value,
                'medicaoTD_': medicaoTD_[x].value,
                'comprimentoTD_': comprimentoTD_[x].value,
                'volumeTD_': volumeTD_[x].value,
                'pesoTD_': pesoTD_[x].value,
                'dimensoesLTD_': dimensoesLTD_[x].value,
                'dimensoesCTD_': dimensoesCTD_[x].value,
                'dimensoesATD_': dimensoesATD_[x].value,                
                'osTD': osTD_[x].value,
                'obsTD': obsTD_[x].value,
                'qtdTD': qtdTD_[x].value
            }
            data.push(obj);
        }
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/os/almoxarifadoAdditensCompra",
            type: 'POST',
            dataType: 'json',
            data: {
                osItens: data
            },
            success: function(data2) {
                if (data2.result) {
                    alert(data2.msggg);
                    getListDistribuirOs();
                    $('#tableInsert tbody').empty();
                    showDivSuprimentos();

                    /*var arrayList = JSON.parse(getCookie('tabelaEntradaProduto'));
                    arrayList = { };
                    $('#tableInsertProd tbody').empty();
                    document.cookie = 'tabelaEntradaProduto ='+JSON.stringify(arrayList)+";path=/";
                    alert("Itens cadastrados com sucesso.");*/
                } else {
                    alert(data2.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },

        })
    }

    function getListDistribuirOs() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/getListDistribuirOs2",
            type: 'POST',
            dataType: 'json',
            data: {
                osItens: ''
            },
            success: function(data2) {
                if (data2.result) {
                    atualizarTabelSuprimentos(data2.resultado);
                } else {
                    alert(data2.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function showDivSolicitar() {
        document.getElementById('suprimentos').style.display = "none";
        document.getElementById('solicitar').style.display = "block";
        document.getElementById('abrirpedido').style.display = "none";
        document.getElementById('materialentregue').style.display = "none";
    }

    function showDivSuprimentos() {
        /*
        document.getElementById('suprimentos').style.display = "block";
        document.getElementById('solicitar').style.display = "none";
        document.getElementById('abrirpedido').style.display = "none";
        document.getElementById('materialentregue').style.display = "none"; 
        */
        window.location.href = "<?php echo base_url() ?>index.php/suprimentos/almoxarifadocompras";
    }

    function showDivAbrirPedido() {
        document.getElementById('suprimentos').style.display = "none";
        document.getElementById('solicitar').style.display = "none";
        document.getElementById('abrirpedido').style.display = "block";
        document.getElementById('materialentregue').style.display = "none";
    }

    function showDivMaterialEntregue() {
        document.getElementById('suprimentos').style.display = "none";
        document.getElementById('solicitar').style.display = "none";
        document.getElementById('abrirpedido').style.display = "none";
        document.getElementById('materialentregue').style.display = "block";
    }

    function gerarCotacao() {
        var data2 = [];
        $("input:checkbox[id=checkDistri]:checked").each(function() {
            data2.push($(this).val());
        })
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/gerarCotacaoAlmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                idDistribuir_: data2
            },
            success: function(data) {
                if (data.result) {
                    alert(data.msggg);
                    atualizarTabelSuprimentos(data.resultado);
                    var mywindow = window.open("", '_blank').document.write(data.html);
                    //mywindow
                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function gerarPedidoCompra() {
        var data2 = [];
        $("input:checkbox[id=checkDistri]:checked").each(function() {
            data2.push($(this).val());

        })
        console.log(data2);
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/gerarOrdemCompraAlmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                idDistribuir_: data2
            },
            success: function(data) {
                if (data.result) {
                    alert(data.msggg);
                    atualizarTabelSuprimentos(data.resultado);
                    tabelaEditarPedido(data.suprimentosEditado);
                    dados_statuscompra = data.dados_statuscompra;
                    dados_statusgrupo = data.dados_statusgrupo;
                    dados_statuscondicao = data.dados_statuscondicao;
                    //var mywindow = window.open("", '_blank').document.write(data.html); 
                    //mywindow
                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function atualizarTabelSuprimentos(resultado) {
        var table = document.getElementById("table_id").getElementsByTagName('tbody')[0];
        tabelaSuprimentos.destroy();
        //console.log(resultado);
        $('#table_id tbody').empty();
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        var newRow;
        var z = 0;
        for (y = 0; y < resultado.length; y++) {
            x = y;
            newRow = table.insertRow(x);
            /*
            <?php
            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aPermisaocompras')) {
            ?>
                var z = 1;
                newCell = newRow.insertCell(0); 
                if(resultado[x].idOs == 10 || resultado[x].idOs == 11 || resultado[x].idOs == 12){
                    if(resultado[x].statusPermissao == 1){
                        newCell.innerHTML = '<label class="switch">'+
                            '<input type="checkbox" checked name="checkPermAlmo" id="checkPermAlmo'+resultado[x].idInsumos+'"  value="'+resultado[x].idInsumos+'">'+
                            '<span class="slider round"></span>'+
                            '</label>'
                    }else{
                        newCell.innerHTML = '<label class="switch">'+
                            '<input type="checkbox" name="checkPermAlmo" id="checkPermAlmo'+resultado[x].idInsumos+'"  value="'+resultado[x].idInsumos+'">'+
                            '<span class="slider round"></span>'+
                            '</label>'
                    }
                }
                  
                
            <?php } else {
                echo 'var z = 0';
            } ?>*/

            newCell = newRow.insertCell(0 + z);
            //if(resultado[x].statusPermissao == 1){
            newCell.innerHTML = "<input type='hidden' value='" + resultado[x].idStatuscompras + "' name='idStatuscompras_[]'>" +
                "<input type='checkbox' id='checkDistri' value='" + resultado[x].idDistribuir + "' name='idDistribuir_[]'>" + resultado[x].idDistribuir
            /*}else{
                newCell.innerHTML = '';
            } */



            newCell = newRow.insertCell(1 + z);
            newCell.innerHTML = resultado[x].idOs;

            newCell = newRow.insertCell(2 + z);
            if (resultado[x].data_alteracao != "" && resultado[x].data_alteracao != null) {
                test = resultado[x].data_alteracao.split(" ");
                data = test[0].split("-");
                newCell.innerHTML = '<span style="display:none">' + resultado[x].data_alteracao + '</span>' + data[2] + "-" + data[1] + "-" + data[0] + " " + test[1];
            }


            newCell = newRow.insertCell(3 + z);
            <?php
            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'ePedidocompraalmox')) { ?>
                if (resultado[x].idStatuscompras == 1 || resultado[x].idStatuscompras == 2) {
                    newCell.innerHTML = resultado[x].quantidade + '<a href="#modal-editarquantidade" style="margin-right: 1%" role="button"' +
                        'data-toggle="modal" quantidadeDistri="' + resultado[x].quantidade + '" idDistribuirOS="' + resultado[x].idDistribuir + '"' +
                        'class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>';

                } else {
                    newCell.innerHTML = resultado[x].quantidade;
                }
            <?php
            } else {
                echo "newCell.innerHTML = resultado[x].quantidade;";
            } ?>


            newCell = newRow.insertCell(4 + z);
            if (resultado[x].dimensoes == null) {
                newCell.innerHTML = resultado[x].descricaoInsumo;
            } else {
                newCell.innerHTML = resultado[x].descricaoInsumo + " " + resultado[x].dimensoes;
            }

            newCell = newRow.insertCell(5 + z);
            newCell.innerHTML = resultado[x].obs;

            newCell = newRow.insertCell(6 + z);
            if (resultado[x].datacadastrodist != "" && resultado[x].datacadastrodist != null) {
                test = resultado[x].datacadastrodist.split(" ");
                data = test[0].split("-");
                newCell.innerHTML = '<span style="display:none">' + resultado[x].datacadastrodist + '</span>' + data[2] + "-" + data[1] + "-" + data[0] + " " + test[1];
            }

            newCell = newRow.insertCell(7 + z);
            newCell.innerHTML = resultado[x].nomeStatus;

            newCell = newRow.insertCell(8 + z);
            if (resultado[x].idPedidoCompra != null && resultado[x].idPedidoCompra != "" && resultado[x].idStatuscompras != 7) {
                <?php
                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
                ?>
                    newCell.innerHTML = resultado[x].idPedidoCompra +
                        '<a href="#modal-editarpedidocompra2" style="margin-right: 1%" role="button"' +
                        'data-toggle="modal" itempedidocompra="' + resultado[x].idPedidoCompraItens + '"' +
                        'class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>';
                <?php
                }
                ?>
            } else {
                newCell.innerHTML = resultado[x].idPedidoCompra;
            }
            newCell = newRow.insertCell(9 + z);
            if (resultado[x].cadpedgerado != "" && resultado[x].cadpedgerado != null) {
                test = resultado[x].cadpedgerado.split(" ");
                data = test[0].split("-");
                newCell.innerHTML = '<span style="display:none">' + resultado[x].cadpedgerado + '</span>' + data[2] + "-" + data[1] + "-" + data[0] + " " + test[1];

            }

            newCell = newRow.insertCell(10 + z);
            newCell.innerHTML = resultado[x].user;

            newCell = newRow.insertCell(11 + z);
            if (resultado[x].idPedidoCompra != '' && resultado[x].idEmitente != null) {
                <?php
                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vPedCompra')) {
                ?>
                    newCell.innerHTML = '<a href="<?php echo base_url(); ?>index.php/suprimentos/imprimir_pedido/' + resultado[x].idPedidoCompra + '" style="margin-right: 1%" class="btn tip-top"  target="_blank"><i class="icon-print icon-white"></i></a>';
                <?php
                }
                ?>
            }

            newCell = newRow.insertCell(12 + z);
            if (resultado[x].idPedidoCompraItens != '' && resultado[x].idPedidoCompraItens != null && resultado[x].idStatuscompras != 8 && resultado[x].idStatuscompras != 9 && resultado[x].idStatuscompras != 7) {
                <?php
                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dPedCompra')) {
                ?>
                    newCell.innerHTML = '<a href="#modal-excluiritempedido" style="margin-right: 1%" role="button" data-toggle="modal"' +
                        'idPedidoCompraItens_1="' + resultado[x].idPedidoCompraItens + '"' +
                        'class="btn btn-warning tip-top"><i class="icon-remove icon-white"></i></a>';

                <?php
                }
                ?>
            }


        }
        $("input:checkbox[name=checkPermAlmo]").click(function() {
            //console.log(this.checked);
            //console.log(this.value)
            permCompra(this.value, this.checked);
        })

        tabelaSuprimentos = $('#table_id').DataTable({
            'columnDefs': [{
                'targets': [0], // column index (start from 0)
                'orderable': false, // set orderable false for selected columns
            }],
            "order": [
                [3, "desc"],
                [11, "desc"]
            ],
            "paging": false, //Dont want paging                
            "bPaginate": false, //Dont want paging 
            "searching": false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "sProcessing": "Procesando...",
                "sZeroRecords": "Sem resultados",
                "sInfo": "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros de 0 a 0 de um total de 0 registros",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Seguinte",
                    "sPrevious": "Anterior"
                }
            }

        })
    }

    var contador_global_autocomplete = 0;
    var contador_local_autocomplete = contador_global_autocomplete;
    var contador_os = 0

    function tabelaEditarPedido(suprimentos) {

        var table = document.getElementById("tableEditarSuprimentos").getElementsByTagName('tbody')[0];
        $('#tableEditarSuprimentos tbody').empty();
        $('#divModels').empty();
        var contador = 0;
        var idPedidoCompra = 0;
        var previsaoEntrega = '';
        var contLinesForn = 0;
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        for (x = 0; x < suprimentos.length; x++) {
            suprimentos[x].previsao_entrega = ((suprimentos[x].previsao_entrega != null) ? suprimentos[x].previsao_entrega : "");
            if (idPedidoCompra != suprimentos[x].idPedidoCompra || previsaoEntrega != suprimentos[x].previsao_entrega) {
                nomeFornecedor = ((suprimentos[x].nomeFornecedor != null) ? suprimentos[x].nomeFornecedor : "");
                nomeEmitente = ((suprimentos[x].nome != null) ? suprimentos[x].nome : "");
                idPedidoCompra = suprimentos[x].idPedidoCompra;
                previsaoEntrega = ((suprimentos[x].previsao_entrega != null) ? suprimentos[x].previsao_entrega : "");
                contLinesForn = contLinesForn + 1;
                newRow = table.insertRow(-1);

                newCell = newRow.insertCell(0);
                newCell.innerHTML = '<a href="#modal-fornec-emitente' + suprimentos[x].idPedidoCompra + '' + ((suprimentos[x].previsao_entrega != null) ? suprimentos[x].previsao_entrega : "") + '" data-toggle="modal"> <b>OC:</b> ' + suprimentos[x].idPedidoCompra + ' <b>Empresa:</b> ' + nomeEmitente + '/ <b>Fornecedor:</b> ' + nomeFornecedor + ' <b>Previsão de entrega:</b> ' + previsaoEntrega + '</a>' +
                    '<a href="#modal-fornec-emitente' + suprimentos[x].idPedidoCompra + '' + ((suprimentos[x].previsao_entrega != null) ? suprimentos[x].previsao_entrega : "") + '" style="margin-right: 1%" role="button" data-toggle="modal" title="Editar IPI">' +
                    '<font color="red"><i class="icon-pencil icon-white"></i></font>' +
                    '</a>'
                newCell.className = "table-bordered tdExibirPedido";
                newCell.colSpan = '12';

            }
            newRow = table.insertRow(-1);

            newCell = newRow.insertCell(0);
            newCell.innerHTML = '<a href="#modal-usuario' + suprimentos[x].idPedidoCompraItens + '" style="margin-right: 1%"' +
                'role="button" data-toggle="modal" class="btn tip-top"><i class="icon icon-user"></i></a>' +
                '<font size="1">' + suprimentos[x].idOs + '</font>' + '<input id="idPedidoCompraItens2" type="hidden" name="idPedidoCompraItens2" value="' + suprimentos[x].idPedidoCompraItens + '" />' + '<input id="idCotacaoItens2" type="hidden" name="idCotacaoItens2"     value="' + suprimentos[x].idCotacaoItens + '" />' + '<input id="idDistribuirOs4" type="hidden" name="idDistribuirOs4"     value="' + suprimentos[x].idDistribuir + '" />';

            newCell = newRow.insertCell(1);
            text = '<input id="quantidade' + contador + '" type="hidden" name="quantidade[]"' +
                'value="' + suprimentos[x].quantidade + '" />' + suprimentos[x].quantidade + ' - ';
            if (suprimentos[x].liberado_edit_compras == 0) {
                if (suprimentos[x].idStatuscompras != 7) {
                    text = text + '<a href="#modal-editar_1" style="margin-right: 1%" role="button" data-toggle="modal"' +
                        'id_disti1="' + suprimentos[x].idDistribuir + '" title="Destravar para editar">' +
                        '<font color="red"><i class="icon-remove icon-white"></i></font>' +
                        '</a>';
                }
            } else {
                text = text + '<a href="#modal-editar_0" style="margin-right: 1%" role="button" data-toggle="modal"' +
                    'id_disti2="' + suprimentos[x].idDistribuir + '" title="Travar edição">' +
                    '<font color="blue"><i class="icon-pencil icon-white"></i></font>' +
                    '</a>';
            }
            newCell.innerHTML = text;

            newCell = newRow.insertCell(2);
            newCell.innerHTML = '<font size="1">' + suprimentos[x].descricaoInsumo + " " + ((suprimentos[x].dimensoes != null) ? suprimentos[x].dimensoes : "") + '</font>';

            newCell = newRow.insertCell(3);
            newCell.innerHTML = '<font size="1">' + ((suprimentos[x].obs != null) ? suprimentos[x].obs : "") + '</font>';

            newCell = newRow.insertCell(4);
            text = '<select class="recebe-solici" class="controls" style="font-size: 10px;"' +
                'name="idStatuscompras3" id="idStatuscompras3">';
            dados_statuscompra2.forEach((elemento) => {
                if (suprimentos[x].idOs <= 19999) {
                    if (elemento.idStatuscompras == 6 && elemento.idStatuscompras >= 3) {
                        if (elemento.idStatuscompras == suprimentos[x].idStatuscompras) {
                            text = text + '<option value="' + elemento.idStatuscompras + '" selected="selected">' + elemento.nomeStatus + '</option>'
                        } else {
                            text = text + '<option value="' + elemento.idStatuscompras + '" ">' + elemento.nomeStatus + '</option>'
                        }
                    } else if (elemento.idStatuscompras != 6) {
                        if (elemento.idStatuscompras == suprimentos[x].idStatuscompras) {
                            text = text + '<option value="' + elemento.idStatuscompras + '" selected="selected">' + elemento.nomeStatus + '</option>'
                        } else {
                            text = text + '<option value="' + elemento.idStatuscompras + '">' + elemento.nomeStatus + '</option>'
                        }
                    }
                } else {
                    if (elemento.idStatuscompras != 8) {
                        if (elemento.idStatuscompras == 6 && elemento.idStatuscompras >= 3) {
                            if (elemento.idStatuscompras == suprimentos[x].idStatuscompras) {
                                text = text + '<option value="' + elemento.idStatuscompras + '" selected="selected">' + elemento.nomeStatus + '</option>'
                            } else {
                                text = text + '<option value="' + elemento.idStatuscompras + '" ">' + elemento.nomeStatus + '</option>'
                            }
                        } else if (elemento.idStatuscompras != 6) {
                            if (elemento.idStatuscompras == suprimentos[x].idStatuscompras) {
                                text = text + '<option value="' + elemento.idStatuscompras + '" selected="selected">' + elemento.nomeStatus + '</option>'
                            } else {
                                text = text + '<option value="' + elemento.idStatuscompras + '">' + elemento.nomeStatus + '</option>'
                            }
                        }
                    }
                }

            })
            text = text + "</select>";
            newCell.innerHTML = text;

            newCell = newRow.insertCell(5);
            text = '<font size="1">';
            if (suprimentos[x].datastatusentregue != null) {
                test = suprimentos[x].datastatusentregue.split(" ");
                data = test[0].split("-");
                text = text + '' + data[2] + '/' + data[1] + '/' + data[0] + '<input id="dataentregue3" class="data span14" type="hidden" name="dataentregue3"' +
                    'value="' + data[2] + '/' + data[1] + '/' + data[0] + '" />'
            } else {
                text = text + '<input id="dataentregue3" class="data span14" type="text" name="dataentregue3" value=""' +
                    'style="font-size: 10px;" size="17" />'
            }
            text = text + '</font>';
            newCell.innerHTML = text;

            newCell = newRow.insertCell(6);
            text = '<font size="1">' + suprimentos[x].nomegrupo;
            text = text + '</font>';
            newCell.innerHTML = text;

            newCell = newRow.insertCell(7);
            if (suprimentos[x].qtdrecebida != 0) {
                text = '<input class="span8" onclick="this.select();" type="text" style="font-size: 10px;"' +
                    'name="qtdrecebida" id="qtdrecebida" value="' + suprimentos[x].qtdrecebida + '">';
            } else {
                text = '<input class="span8" onclick="this.select();" type="text" style="font-size: 10px;"' +
                    'name="qtdrecebida" id="qtdrecebida" value="' + suprimentos[x].quantidade + '">'
            }
            newCell.innerHTML = text;

            newCell = newRow.insertCell(8);
            newCell.innerHTML = '<input style="font-size: 10px;" class="span12" onclick="this.select();" type="text"' +
                'id="valor_unitario' + contador + '" onKeyPress="FormataValor2(this,event,10,2);" name="valor_unitario"' +
                'value="' + Number(suprimentos[x].valor_unitario).toFixed(2).replace('.', ',') + '"' +
                'onKeyUp="calculaSubTotal(' + contador + ')">';
            newCell = newRow.insertCell(9);
            newCell.innerHTML = '<input style="font-size: 10px;" class="span12" onclick="this.select();" type="text"' +
                'id="ipi_valor' + contador + '" onKeyPress="FormataValor2(this,event,10,2);"' +
                'name="ipi_valor" value="' + Number(suprimentos[x].ipi_valor).toFixed(2).replace('.', ',') + '"' +
                'onKeyUp="calculaSubTotal(' + contador + ')">';
            newCell = newRow.insertCell(10);
            newCell.innerHTML = '<input style="font-size: 10px;" class="span12" onclick="this.select();" type="text"' +
                'id="valor_icms' + contador + '" onKeyPress="FormataValor2(this,event,10,2);"' +
                'name="valor_icms" value="' + Number(suprimentos[x].icms).toFixed(2).replace('.', ',') + '"' +
                'onKeyUp="calculaSubTotal(' + contador + ')">';
            newCell = newRow.insertCell(11);
            newCell.innerHTML = '<input style="font-size: 10px;" type="text" id="valor_produtos' + contador + '"' +
                'name="valor_produtos"' +
                'value="' + Number(suprimentos[x].valor_total).toFixed(2).replace('.', ',') + '" readonly="true"' +
                'class="span12" />';
            newCell = newRow.insertCell(12);
            newCell.innerHTML = '<a href="#modal-nfdata' + suprimentos[x].idPedidoCompraItens + '" style="margin-right: 1%"' +
                'role="button" data-toggle="modal" class="btn tip-top">' +
                '<font size="1">' + ((suprimentos[x].notafiscal != null) ? suprimentos[x].notafiscal : "") + '</font>' +
                '</a>';
            contador++;
        }
        modelEditarPedido(suprimentos);
        showDivAbrirPedido();
        contador_global_autocomplete = contador;
        contador_local_autocomplete = contador_global_autocomplete;
    }

    function verificar(value) {

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

        if (value == 0) {
            tamanho.style.display = "none";
            volume.style.display = "none";
            peso.style.display = "none";
            dimensoes.style.display = "none";
        } else if (value == 1) {
            tamanho.style.display = "block";
            volume.style.display = "none";
            peso.style.display = "none";
            dimensoes.style.display = "none";
        } else if (value == 2) {
            tamanho.style.display = "none";
            volume.style.display = "block";
            peso.style.display = "none";
            dimensoes.style.display = "none";
        } else if (value == 3) {
            tamanho.style.display = "none";
            volume.style.display = "none";
            peso.style.display = "block";
            dimensoes.style.display = "none";
        } else if (value == 4) {
            tamanho.style.display = "none";
            volume.style.display = "none";
            peso.style.display = "none";
            dimensoes.style.display = "block";
        }
    };

    function modelEditarPedido(suprimentos) {
        var contadorOS = 0;
        var idPedidoCompraModal = 0;
        var previsaoEntregaModal = "";
        var html = "";
        var html2 = '';
        var html3 = '';
        var html4 = '';
        html2 +=
            '<div id="modal-ipi" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"        aria-hidden="true">' +
            '<div class="modal-header">' +
            '<a type="button" class="close" data-dismiss="modal" aria-hidden="true">×</a>' +
            '<h5 id="myModalLabel">Informar o valor nos campos desejados e selecionar todos que irão alterar:</h5>' +
            '</div>' +
            '<div class="modal-body">' +
            'Valor IPI%:<input id="valoripi" onKeyPress="FormataValor2(this,event,10,2);" onclick="this.select();" type="text" name="valoripi" value="" />% ex.:5,00<br><br>' +
            'Status Compra:<select class="recebe-solici" class="controls" name="idStatuscompras2" id="idStatuscompras2">' +
            '<option value=""></option>';
        dados_statuscompra2.forEach((elemento) => {
            html2 +=
                '<option value="' + elemento.idStatuscompras + '">' + elemento.nomeStatus + '</option>';
        });
        html2 +=
            '</select> <br><br>' +
            'Data entregue:' +
            '<input id="dataentregue2" class="data" type="text" name="dataentregue2" value="" style="font-size: 10px;" size="17" /><br><br>' +
            'N° NF:' +
            '<input id="nNotaFiscal2" type="text" name="nNotaFiscal2" value="" style="font-size: 10px;" size="17" />' +
            '<br><br>' +
            '<b>Qtd ***** Descrição</b><br>';








        for (x = 0; x < suprimentos.length; x++) {
            suprimentos[x].previsao_entrega = ((suprimentos[x].previsao_entrega != null) ? suprimentos[x].previsao_entrega : "")
            if (idPedidoCompraModal != suprimentos[x].idPedidoCompra || previsaoEntregaModal != suprimentos[x].previsao_entrega) {
                idPedidoCompraModal = suprimentos[x].idPedidoCompra;
                previsaoEntregaModal = suprimentos[x].previsao_entrega;
                contadorOS = contadorOS + 1;

                html +=
                    '<div id="modal-fornec-emitente' + suprimentos[x].idPedidoCompra + '' + ((suprimentos[x].previsao_entrega != null) ? suprimentos[x].previsao_entrega : "") + '" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
                    '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>' +
                    '<h5 id="myModalLabel">Dados Orçamento</h5>' +
                    '</div>' +
                    '<div class="modal-body">' +
                    '<div style="size:20px">';
                for (y = 0; y < suprimentos.length; y++) {
                    html = html +
                        '<input type="hidden" name="idDistribuir2_[]" value="' + suprimentos[y].idDistribuir + '"/>';
                }
                html += '<label for="idEmitente" class="control-label">Empresa:</label>' +
                    '<input id="idPedidoCompra2" type="hidden" name="idPedidoCompra2" value="' + suprimentos[x].idPedidoCompra + '" />';
                if (suprimentos[x].idEmitente != null && suprimentos[x].idEmitente != "") {
                    html += '<input id="emitente2" onclick="this.select();" class="span12 controls emitente2" type="text" name="emitente2" value="' + suprimentos[x].nome + '" size="50" />' +
                        '<input id="emitente_id2" type="hidden" name="emitente_id2" class="emitente_id" value="' + suprimentos[x].idEmitente + '" />';
                } else {
                    html += '<input id="emitente2" class="span12 emitente2 controls" type="text" name="emitente2" value="" size="50" />' +
                        '<input id="emitente_id2" type="hidden" name="emitente_id2" value="" class="emitente_id2" />';
                }
                html += '<label for="fornecedor" class="control-label">Fornecedor:</label>';
                if (suprimentos[x].idFornecedores != null && suprimentos[x].idFornecedores != "") {
                    html += '<input id="fornecedor2" onclick="this.select();" class="span12 controls fornecedor2" type="text" name="fornecedor2" value="' + suprimentos[x].nomeFornecedor + '" size="50" />' +
                        '<input id="fornecedor_id2" type="hidden" name="fornecedor_id2" class="fornecedor_id2" value="' + suprimentos[x].idFornecedores + '" />';
                } else {
                    html += '<input id="fornecedor2" class="span12 fornecedor2 controls" type="text" name="fornecedor2" value="" size="50" />' +
                        '<input id="fornecedor_id2" type="hidden" name="fornecedor_id2" value="" class="fornecedor_id2"/>';
                }
                dataPrevisaoEntrega = "";
                if (suprimentos[x].previsao_entrega != "" && suprimentos[x].previsao_entrega != null) {
                    test = suprimentos[x].previsao_entrega.split(" ");
                    data = test[0].split("-");
                    dataPrevisaoEntrega = data[2] + '/' + data[1] + '/' + data[0];
                }
                html +=
                    '</div>' +
                    '<table>' +
                    '<tr>' +
                    '<td>' +
                    '<input id="idPedidoCompraipi2" type="hidden" name="idPedidoCompraipi2" value="' + suprimentos[x].dPedidoCompra + '" />' +
                    'Previsão de entrega:<input size="6" id="previsao_entrega2" class=" data" type="text" name="previsao_entrega2" value="' + ((suprimentos[x].previsao_entrega != null) ? dataPrevisaoEntrega : "") + '" />' +
                    '</td>' +
                    '<td>Prazo de entrega:<input size="3" class="span8 form-control" type="text" name="prazo_entrega2"  id="prazo_entrega2" value="' + ((suprimentos[x].prazo_entrega != null) ? suprimentos[x].prazo_entrega : "") + '">dias</td>' +
                    '<td>Pagamento:' +
                    '<select class=" recebe-solici" class=" controls" name="idCondPgto2" id="idCondPgto2">' +
                    '<option value="" selected="selected"></option>';
                dados_statuscondicao2.forEach((elemento) => {
                    if (elemento.id_status_cond_pgt == suprimentos[x].idCondPgto) {
                        html +=
                            '<option selected="selected" value="' + elemento.id_status_cond_pgt + '">' + elemento.nome_status_cond_pgt + '</option>';
                    } else {
                        html +=
                            '<option value="' + elemento.id_status_cond_pgt + '">' + elemento.nome_status_cond_pgt + '</option>';
                    }
                });
                html +=
                    '</select>' +
                    '</td>' +
                    '<td>' +
                    'Condição de pagamento <input class=" form-control" size="50" type="text" name="cod_pgto2" id="cod_pgto2" value="' + ((suprimentos[x].cod_pgto != null) ? suprimentos[x].cod_pgto : "") + '">' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td colspan="4">' +
                    /*
                                                        'ICMS: '+
                                                        '<input class=" form-control" size="7" onKeyPress="FormataValor2(this,event,10,2);" type="text" name="icmsit" id="icmsit'+contadorOS+'" value="'+Number(suprimentos[x].icms).toFixed(2).replace('.',',')+'">'+*/
                    'Frete: ' +
                    '<input class=" form-control" size="7" onKeyPress="FormataValor2(this,event,10,2);"	type="text" name="freteit" id="freteit' + contadorOS + '" value="' + Number(suprimentos[x].frete).toFixed(2).replace('.', ',') + '">' +
                    'Desconto: ' +
                    '<input class=" form-control" size="7" onKeyPress="FormataValor2(this,event,10,2);"	type="text" name="descontoit" id="descontoit' + contadorOS + '" value="' + Number(suprimentos[x].desconto).toFixed(2).replace('.', ',') + '">' +
                    'Outros: ' +
                    '<input class=" form-control" size="7" onKeyPress="FormataValor2(this,event,10,2);" type="text" name="outrosit" id="outrosit' + contadorOS + '" value="' + Number(suprimentos[x].outros).toFixed(2).replace('.', ',') + '">' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td colspan="6">OBS: ' +
                    '<textarea id="obs2" rows="5" cols="100" class="" name="obs2">' + ((suprimentos[x].obscompras != null) ? suprimentos[x].obscompras : "") + '</textarea>' +
                    '</td>' +
                    '</tr>' +
                    '</table>' +
                    '<div class="modal-footer">' +
                    '<a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>' +
                    '<a role="button" name="btnAlterar" onclick="salvarAlteracoesPedidos(' + "'" + x + "','alterar'" + ')" value="btnAlterar" class="btn btn-danger">Alterar</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                contador_os = contadorOS;
            }
            //html2 model-ipi

            html2 +=
                '<input id="idDistribuir_ipi" type="hidden" name="idDistribuir_ipi" value="' + suprimentos[x].idDistribuir + '" />' +
                '<input name="idPedidoCompraItensipi" id="idPedidoCompraItensipi" type="checkbox" value="' + suprimentos[x].idPedidoCompraItens + '" checked>' +
                suprimentos[x].quantidade + "*****" + suprimentos[x].descricaoInsumo + " " + suprimentos[x].dimensoes +
                '<br>';

            html3 += '<input id="idPedidoCompraipi3" type="hidden" name="idPedidoCompraipi3"  value="' + suprimentos[x].idPedidoCompra + '" />' +
                '<input name="idPedidoCompraItensipi3" id="idPedidoCompraItensipi3" type="checkbox" value="' + suprimentos[x].idPedidoCompraItens + '" checked>' +
                suprimentos[x].quantidade + '*****' + suprimentos[x].descricaoInsumo + " " + suprimentos[x].dimensoes +
                '<br>';



            html4 += '<div id="modal-nfdata' + suprimentos[x].idPedidoCompraItens + '" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
                '<div class="modal-header">	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>	<h5 id="myModalLabel">Dados NF Status</h5> </div>' +
                '<div class="modal-body">' +
                '<div style="float:right; size:20px">' +
                '<font size="3">';
            idpedidocompra = suprimentos[x].idPedidoCompra == null ? "" : suprimentos[x].idPedidoCompra;
            idpedidocompraitens = suprimentos[x].idPedidoCompraItens == null ? "" : suprimentos[x].idPedidoCompraItens;
            nf = suprimentos[x].notafiscal == null ? "" : suprimentos[x].notafiscal;
            prazo = suprimentos[x].prazo_entrega == null ? "" : suprimentos[x].prazo_entrega;
            for (y = 0; y < suprimentos.length; y++) {
                html4 += '<input type="hidden" name="idDistribuir3_" value="' + suprimentos[y].idDistribuir + '"/>';
            }
            html4 += '<input id="idPedidoCompraipi3_" type="hidden" name="idPedidoCompraipi3_" value="' + idpedidocompra + '" />' +
                '<input name="idPedidoCompraItensipi3_" id="idPedidoCompraItensipi3_" type="hidden" value="' + idpedidocompraitens + '" checked />	Nº NF:' +
                '<input class="span8" type="text" style="font-size: 22px;" name="nNotaFiscal3" id="nNotaFiscal3" value="' + nf + '" />	<br> Data NF:';
            if (suprimentos[x].datastatusentregue != "" && suprimentos[x].datastatusentregue != null) {
                test = suprimentos[x].datastatusentregue.split(" ");
                data = test[0].split("-");
                datastatusentregue = data[2] + '/' + data[1] + '/' + data[0];
                html4 += '<input class="data" type="text" style="font-size: 18px;" size=13 name="dataentregue4" id="dataentregue4" value="' + datastatusentregue + '" />';
            } else {
                html4 += '<input class="data" type="text" style="font-size: 18px;" size=13 name="dataentregue4" id="dataentregue4"  value="" />';
            }
            html4 += '</font>' +
                '</div>';
            html4 += 'Prazo Entrega:<b>' + prazo + '</b> dias<br>';
            if (suprimentos[x].previsao_entrega != '' && suprimentos[x].previsao_entrega != null) {
                test = suprimentos[x].previsao_entrega.split(" ");
                data = test[0].split("-");
                previsao_entrega = data[2] + '/' + data[1] + '/' + data[0];
                html4 += 'Previsão Entrega:<b>' + previsao_entrega + '</b><br>';

            } else {
                html4 += 'Previsão Entrega:<b></b><br>';
            }
            statuscondpag = suprimentos[x].nome_status_cond_pgt == null ? "" : suprimentos[x].nome_status_cond_pgt;
            codpgto = suprimentos[x].cod_pgto == null ? "" : suprimentos[x].cod_pgto;
            desconto = suprimentos[x].desconto == null ? "" : suprimentos[x].desconto.replace(".", ",");
            icms = suprimentos[x].icms == null ? "" : suprimentos[x].icms;
            outros = suprimentos[x].outros == null ? "" : suprimentos[x].outros;
            frete = suprimentos[x].frete == null ? "" : suprimentos[x].frete;
            obscompras = suprimentos[x].obscompras == null ? "" : suprimentos[x].obscompras;
            html4 += 'Forma de pagamento:<b>' + statuscondpag + '</b><br>' +
                'Condição de pagamento:<b>' + codpgto + '</b><br>' +
                'Desconto:<b>' + desconto + '</b><br>' +
                'ICMS:<b>' + icms + '</b><br>' +
                'Outros:<b>' + outros + '</b><br>' +
                'Frete:<b>' + frete + '</b><br>' +
                'OBS:<b>' + obscompras + '</b><br>';
            html4 += '<div class="modal-footer">' +
                '<a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>' +
                '<a class="btn btn-danger" onclick="editar_ipi2(' + "'" + x + "'" + ')">Alterar</a>' +
                '</div>';
            html4 += '</div></div>';




        }
        //html2 model-ipi
        html2 += '<h5 style="text-align: center">Deseja alterar os itens selecionados para os valores informado?</h5>' +
            '</div>' +
            '<div class="modal-footer">' +
            '<a class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</a>' +
            '<a class="btn btn-danger" onclick="editar_ipi()">Alterar</a>' +
            '</div>' +
            '</div>';


        document.querySelector('#divModels').insertAdjacentHTML('afterbegin', html);
        document.querySelector('#divModels').insertAdjacentHTML('afterbegin', html2);
        document.querySelector('#divModels').insertAdjacentHTML('afterbegin', html4);
        document.querySelector('#divImprimirItem').insertAdjacentHTML('afterbegin', html3);
        $(".emitente2").autocomplete({
            source: "<?php echo base_url(); ?>index.php/suprimentos/autoCompleteEmitente",
            minLength: 1,
            select: function(event, ui) {
                $(".emitente_id2").val(ui.item.id);
            }
        });

        $(".fornecedor2").autocomplete({
            source: "<?php echo base_url(); ?>index.php/suprimentos/autoCompletefornecedor",
            minLength: 1,
            select: function(event, ui) {
                $(".fornecedor_id2").val(ui.item.id);
            }
        });

        jQuery(".data").mask("99/99/9999");

    }

    var data3 = [];

    function abrirPedidosSelecionados(data2) {
        if (data2 == null) {
            var data2 = [];
            $("input:checkbox[id=checkDistri]:checked").each(function() {
                data2.push($(this).val());
            })
            data3 = data2;
        }
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/editarpedidosuprimentosalmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                idDistribuir_: data2
            },
            success: function(data) {
                if (data.result) {
                    tabelaEditarPedido(data.resultado);
                    //alert(data.msggg);                    
                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function salvarAlteracoesPedidos(pos, button) {
        //idICMSIT = '#icmsit'+(pos+1);
        emitente = Array.apply(null, document.querySelectorAll(".emitente2"));
        idPedidoCompra = Array.apply(null, document.querySelectorAll("#idPedidoCompra2"));
        idDistribuirOs4 = Array.apply(null, document.querySelectorAll("#idDistribuirOs4"));
        emitente_id = Array.apply(null, document.querySelectorAll("#emitente_id2"));
        fornecedor = Array.apply(null, document.querySelectorAll("#fornecedor2"));
        fornecedor_id = Array.apply(null, document.querySelectorAll("#fornecedor_id2"));
        idPedidoCompraipi = Array.apply(null, document.querySelectorAll("#idPedidoCompraipi2"));
        previsao_entrega = Array.apply(null, document.querySelectorAll("#previsao_entrega2"));
        prazo_entrega = Array.apply(null, document.querySelectorAll("#prazo_entrega2"));
        idCondPgto = Array.apply(null, document.querySelectorAll("#idCondPgto2"));
        cod_pgto2 = Array.apply(null, document.querySelectorAll("#cod_pgto2"));
        freteit = Array.apply(null, document.querySelectorAll("input[name='freteit']"));
        descontoit = Array.apply(null, document.querySelectorAll("input[name='descontoit']"));
        outrosit = Array.apply(null, document.querySelectorAll("input[name='outrosit']"));
        obs = Array.apply(null, document.querySelectorAll("#obs2"));
        dataentregue = Array.apply(null, document.querySelectorAll("#dataentregue3"));
        idPedidoCompraItens = Array.apply(null, document.querySelectorAll("#idPedidoCompraItens2"));
        idCotacaoItens = Array.apply(null, document.querySelectorAll("#idCotacaoItens2"));
        idStatuscompras = Array.apply(null, document.querySelectorAll("#idStatuscompras3"));
        //console.log(idStatuscompras)

        qtdrecebida = Array.apply(null, document.querySelectorAll("input[name=qtdrecebida]"));
        valor_unitario = Array.apply(null, document.querySelectorAll("input[name=valor_unitario]"));
        ipi_valor = Array.apply(null, document.querySelectorAll("input[name=ipi_valor]"));
        icmsit = Array.apply(null, document.querySelectorAll("input[name=valor_icms]"));
        valor_produtos = Array.apply(null, document.querySelectorAll("input[name=valor_produtos]"));
        var arrayPedido = [];
        var arrayAataentregue = [];
        var arrayQtdrecebida = [];
        var arrayValor_unitario = [];
        var arrayIpi_valor = [];
        var arrayIcmsit = [];
        var arrayValor_produtos = [];
        var arrayIdCotacaoItens = [];
        var arrayIdStatuscompras = [];
        var arrayDistribuir = [];

        var modalClose = "#modal-fornec-emitente" + idPedidoCompra[pos].value + ((previsao_entrega[pos].value != null) ? previsao_entrega[pos].value.replaceAll("/", "-") : "");
        idPedidoCompraItens.forEach((elemento) => {
            arrayPedido.push(elemento.value);
        })
        idDistribuirOs4.forEach((elemento) => {
            arrayDistribuir.push(elemento.value);
        })
        dataentregue.forEach((elemento) => {
            arrayAataentregue.push(elemento.value);
        })
        qtdrecebida.forEach((elemento) => {
            arrayQtdrecebida.push(elemento.value);
        })
        valor_unitario.forEach((elemento) => {
            arrayValor_unitario.push(elemento.value);
        })
        ipi_valor.forEach((elemento) => {
            arrayIpi_valor.push(elemento.value);
        })
        icmsit.forEach((elemento) => {
            arrayIcmsit.push(elemento.value);
        })
        valor_produtos.forEach((elemento) => {
            arrayValor_produtos.push(elemento.value);
        })
        idCotacaoItens.forEach((elemento) => {
            arrayIdCotacaoItens.push(elemento.value);
        })
        idStatuscompras.forEach((elemento) => {
            elemento.options[elemento.selectedIndex].value
            arrayIdStatuscompras.push(elemento.options[elemento.selectedIndex].value);
        })
        //console.log(arrayIdStatuscompras);
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/salvaritemcompraalmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                emitente: emitente[pos].value,
                emitente_id: emitente_id[pos].value,
                idPedidoCompra: idPedidoCompra[pos].value,
                fornecedor: fornecedor[pos].value,
                fornecedor_id: fornecedor_id[pos].value,
                idPedidoCompraipi: idPedidoCompraipi[pos].value,
                previsao_entrega: previsao_entrega[pos].value,
                prazo_entrega: prazo_entrega[pos].value,
                idCondPgto: idCondPgto[pos].value,
                cod_pgto: cod_pgto2[pos].value,
                outrosit: outrosit[pos].value,
                freteit: freteit[pos].value,
                descontoit: descontoit[pos].value,
                obs: obs[pos].value,
                button: button,
                idPedidoCompraItens: arrayPedido,
                idDistribuir: arrayDistribuir,
                dataentregue: arrayAataentregue,
                valor_unitario: arrayValor_unitario,
                ipi_valor: arrayIpi_valor,
                valor_produtos: arrayValor_produtos,
                qtdrecebida: arrayQtdrecebida,
                valor_icms: arrayIcmsit,
                idCotacaoItens: arrayIdCotacaoItens,
                idStatuscompras: arrayIdStatuscompras
            },
            success: function(data) {
                if (data.result) {
                    console.log(modalClose)

                    $(modalClose).modal('hide');
                    $('.modal-backdrop').remove();
                    abrirPedidosSelecionados(data3);
                    atualizarTabelSuprimentos(data.resultado);
                    atualizarMaterialParaArmazenar();
                    alert(data.msggg);

                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })

        console.log(icmsit[pos].value);
    }

    function destravarEdicao() {
        var id_item_pc1 = document.querySelector("#id_item_pc1").value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/editar_1almoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                id_item_pc1: id_item_pc1
            },
            success: function(data2) {
                if (data2.result) {
                    abrirPedidosSelecionados();
                    alert(data2.msggg);
                    $("#modal-editar_1").modal('hide');
                } else {
                    alert(data2.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function travarEdicao() {
        var id_item_pc2 = document.querySelector("#id_item_pc2").value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/editar_0almoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                id_item_pc2: id_item_pc2
            },
            success: function(data2) {
                if (data2.result) {
                    abrirPedidosSelecionados();
                    alert(data2.msggg);
                    $("#modal-editar_0").modal('hide');
                } else {
                    alert(data2.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function editar_ipi() {
        var idStatuscompras2 = document.querySelector("#idStatuscompras2").value;
        var valoripi = document.querySelector("#valoripi").value;
        var dataentregue2 = document.querySelector("#dataentregue2").value;
        var nNotaFiscal2 = document.querySelector("#nNotaFiscal2").value;
        var idDistribuir_ipi_ = Array.apply(null, document.querySelectorAll("#idDistribuir_ipi"));
        var idDistribuir_ipi = []
        idPedidoCompraItensipi_ = Array.apply(null, document.querySelectorAll("#idPedidoCompraItensipi"));
        var idPedidoCompraItensipi = [];
        idDistribuir_ipi_.forEach((elemento) => {
            idDistribuir_ipi.push(elemento.value);
        });
        idPedidoCompraItensipi_.forEach((elemento) => {
            idPedidoCompraItensipi.push(elemento.value);
        });

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/editar_ipialmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                idStatuscompras2: idStatuscompras2,
                dataentregue2: dataentregue2,
                nNotaFiscal2: nNotaFiscal2,
                idDistribuir_ipi: idDistribuir_ipi,
                valoripi: valoripi,
                idPedidoCompraItensipi: idPedidoCompraItensipi
            },
            success: function(data) {
                if (data.result) {
                    alert(data.msggg);
                    abrirPedidosSelecionados(data3);
                    $("#modal-ipi").modal('hide');
                    $('.modal-backdrop').remove();
                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function editar_ipi2(pos) {
        //var idStatuscompras2 = document.querySelector("#idStatuscompras2").value;
        //var idPedidoCompraipi = document.querySelector("#idPedidoCompraipi3_").value;
        //var dataentregue4 = document.querySelector("#dataentregue4").value;
        //var nNotaFiscal2 = document.querySelector("#nNotaFiscal2").value;
        idPedidoCompraipi = Array.apply(null, document.querySelectorAll("#idPedidoCompraipi3_"));
        var idDistribuir_ipi = []
        idPedidoCompraItensipi_ = Array.apply(null, document.querySelectorAll("#idPedidoCompraItensipi3_"));
        var idPedidoCompraItensipi = [];
        nNotaFiscal3 = Array.apply(null, document.querySelectorAll("#nNotaFiscal3"));
        var ArrayNotaFiscal3 = []
        dataentregue4 = Array.apply(null, document.querySelectorAll("#dataentregue4"));
        var ArrayDataentregue4 = [];
        idPedidoCompraipi.forEach((elemento) => {
            idDistribuir_ipi.push(elemento.value);
        });
        /*
                idPedidoCompraItensipi_.forEach((elemento)=>{
                    idPedidoCompraItensipi.push(elemento.value);
                });
                nNotaFiscal3.forEach((elemento)=>{
                    ArrayNotaFiscal3.push(elemento.value);
                });
                dataentregue4.forEach((elemento)=>{
                    ArrayDataentregue4.push(elemento.value);
                });*/
        idPedidoCompraItensipi.push(idPedidoCompraItensipi_[pos].value);

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/editar_ipialmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                dataentregue2: dataentregue4[pos].value,
                nNotaFiscal2: nNotaFiscal3[pos].value,
                idPedidoCompraipi: idDistribuir_ipi,
                idPedidoCompraItensipi: idPedidoCompraItensipi
            },
            success: function(data) {
                if (data.result) {
                    alert(data.msggg);
                    console.log(data.nf);
                    modal = "#modal-nfdata" + idPedidoCompraItensipi_[pos].value;
                    abrirPedidosSelecionados(data3);
                    $(modal).modal('hide');
                    $('.modal-backdrop').remove();
                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function editarpcalmoxarifado() {
        var idPedidoCompraItens_ = document.querySelector('#idPedidoCompraItens_').value;
        var idPedidoCompra_n = document.querySelector('#idPedidoCompra_n').value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/editarpcalmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                idPedidoCompraItens_: idPedidoCompraItens_,
                idPedidoCompra_n: idPedidoCompra_n
            },
            success: function(data) {
                if (data.result) {
                    alert(data.msggg);
                    $("#modal-editarpedidocompra2").modal('hide');
                    atualizarTabelSuprimentos(data.resultado);
                    //var mywindow = window.open("", '_blank').document.write(data.html); 
                    //mywindow
                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })

    }

    function excluir_itempedidoalmoxarifado() {
        var idPedidoCompraItens_nn = document.querySelector('#idPedidoCompraItens_nn').value;
        var selectE = document.getElementById('todos');
        var todos = selectE.options[selectE.selectedIndex].value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/excluir_itempedidoalmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                todos: todos,
                idPedidoCompraItens_nn: idPedidoCompraItens_nn
            },
            success: function(data) {
                if (data.result) {
                    atualizarTabelSuprimentos(data.resultado);
                    alert(data.msggg);
                    $("#modal-excluiritempedido").modal('hide');
                } else {
                    alert(data.msggg);
                }
            },
        })

    }

    function cancelarItensAlmoxarifado() {
        excluirDistribuir_2 = Array.apply(null, document.querySelectorAll("#excluirDistribuir_"));
        excluirStatuscompras_2 = Array.apply(null, document.querySelectorAll("#excluirStatuscompras_"));
        excluirDistribuir_ = [];
        excluirStatuscompras_ = [];

        excluirDistribuir_2.forEach((elemento) => {
            excluirDistribuir_.push(elemento.value);
        });
        excluirStatuscompras_2.forEach((elemento) => {
            excluirStatuscompras_.push(elemento.value);
        });
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/cancelarItensAlmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                excluirDistribuir_: excluirDistribuir_,
                excluirStatuscompras_: excluirStatuscompras_
            },
            success: function(data) {
                if (data.result) {
                    atualizarTabelSuprimentos(data.resultado);
                    alert(data.msggg);
                    $("#modal-excluirSelect").modal('hide');
                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function alterarItensAlmoxarifado(button) {
        var alterarDistribuir_2 = Array.apply(null, document.querySelectorAll("#alterarDistribuir_"));
        var alterarStatuscompras_2 = Array.apply(null, document.querySelectorAll("#alterarStatuscompras_"));
        var alterarDistribuir_ = [];
        var alterarStatuscompras_ = [];
        var idPedidoCompra_n2 = document.querySelector("#idPedidoCompra_n2").value;
        alterarDistribuir_2.forEach((elemento) => {
            alterarDistribuir_.push(elemento.value);
        });
        alterarStatuscompras_2.forEach((elemento) => {
            alterarStatuscompras_.push(elemento.value);
        });
        console.log(alterarStatuscompras_);
        console.log(alterarDistribuir_);
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/alterarItensAlmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                alterarDistribuir_: alterarDistribuir_,
                alterarStatuscompras_: alterarStatuscompras_,
                button: button,
                idPedidoCompra_n: idPedidoCompra_n2
            },
            success: function(data) {
                if (data.result) {
                    alert(data.msggg);
                    $("#modal-editarpedidocompraitens").modal('hide');
                    atualizarTabelSuprimentos(data.resultado);
                    //var mywindow = window.open("", '_blank').document.write(data.html); 
                    //mywindow
                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    $(document).ready(function() {


        $(document).on('click', 'a', function(event) {

            var itempedidocompra = $(this).attr('itempedidocompra');
            $('#idPedidoCompraItens_').val(itempedidocompra);

        });

        $(document).on('click', 'a', function(event) {

            var idPedidoCompraItens_1 = $(this).attr('idPedidoCompraItens_1');
            $('#idPedidoCompraItens_nn').val(idPedidoCompraItens_1);

        });

        $(document).on('click', 'a', function(event) {

            var quantidadeDistri = $(this).attr('quantidadeDistri');
            $('#quantidadeModal').val(quantidadeDistri);

            var idDistribuirOS = $(this).attr('idDistribuirOS');
            $('#idDistrbuirOs2').val(idDistribuirOS);

        });

    });

    $(document).ready(function() {


        tabelaSuprimentos = $('#table_id').DataTable({
            'columnDefs': [{
                'targets': [0], // column index (start from 0)
                'orderable': false, // set orderable false for selected columns
            }],
            "order": [
                [3, "desc"],
                [11, "desc"]
            ],
            "paging": false, //Dont want paging                
            "bPaginate": false, //Dont want paging 
            "searching": false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "sProcessing": "Procesando...",
                "sZeroRecords": "Sem resultados",
                "sInfo": "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros de 0 a 0 de um total de 0 registros",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });


    });

    $(document).ready(function() {


        $("#pn").autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompletePN",
            minLength: 1,
            select: function(event, ui) {
                $('#idProdutos').val(ui.item.id);
                $('#prod').val(ui.item.descricao);
                $('#qtdEst').val(ui.item.qtdEst);
                $('#idSubcategoriaEntrada').val(ui.item.idSubcat);
                $('#categoriaEntrada').val(ui.item.descricaoCategoria);
                $('#idCategoriaEntrada').val(ui.item.idCategoria);
                $('#subcategoriaEntrada').val(ui.item.descricaoSubcategoria);

            }
        });

    });

    $(document).ready(function() {


        $("#prod").autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteInsumos",
            minLength: 1,
            select: function(event, ui) {
                $('#idProdutos').val(ui.item.id);
                $('#pn').val(ui.item.pn_insumo);
                $('#qtdEst').val(ui.item.qtdEst);
                $('#idSubcategoriaEntrada').val(ui.item.idSubcat);
                $('#categoriaEntrada').val(ui.item.descricaoCategoria);
                $('#idCategoriaEntrada').val(ui.item.idCategoria);
                $('#subcategoriaEntrada').val(ui.item.descricaoSubcategoria);
            }
        });

    });

    $(document).ready(function() {

        $("#categoriaEntrada").autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteCategoriaSubCategoria",
            minLength: 1,
            select: function(event, ui) {
                $('#idSubcategoriaEntrada').val(ui.item.id);
                $('#subcategoriaEntrada').val(ui.item.descricaoSubcategoria);
                $('#idCategoriaEntrada').val(ui.item.idCategoria);

            }
        });

    });

    $(document).ready(function() {

        $("#subcategoriaEntrada").autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteSubcategoria",
            minLength: 1,
            select: function(event, ui) {
                $('#idSubcategoriaEntrada').val(ui.item.id);
                $('#categoriaEntrada').val(ui.item.descricaoCategoria);
                $('#idCategoriaEntrada').val(ui.item.idCategoria);

            }
        });

    });

    function FormataValor2(objeto, teclapres, tammax, decimais) {
        var tecla = teclapres.keyCode;
        var tamanhoObjeto = objeto.value.length;



        if ((tecla == 8) && (tamanhoObjeto == tammax))
            tamanhoObjeto = tamanhoObjeto - 1;



        if ((tecla == 8 || tecla == 88 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) && ((
                tamanhoObjeto + 1) <= tammax)) {

            vr = objeto.value;
            vr = vr.replace("/", "");
            vr = vr.replace("/", "");
            vr = vr.replace(",", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            tam = vr.length;

            if (tam < tammax && tecla != 8)
                tam = vr.length + 1;

            if ((tecla == 8) && (tam > 1)) {
                tam = tam - 1;
                vr = objeto.value;
                vr = vr.replace("/", "");
                vr = vr.replace("/", "");
                vr = vr.replace(",", "");
                vr = vr.replace(".", "");
                vr = vr.replace(".", "");
                vr = vr.replace(".", "");
                vr = vr.replace(".", "");
            }

            //Cálculo para casas decimais setadas por parametro
            if (tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) {
                if (decimais > 0) {
                    if ((tam <= decimais))
                        objeto.value = ("0," + vr);

                    if ((tam == (decimais + 1)) && (tecla == 8))
                        objeto.value = vr.substr(0, (tam - decimais)) + ',' + vr.substr(tam - (decimais), tam);

                    if ((tam > (decimais + 1)) && (tam <= (decimais + 3)) && ((vr.substr(0, 1)) == "0"))
                        objeto.value = vr.substr(1, (tam - (decimais + 1))) + ',' + vr.substr(tam - (decimais), tam);

                    if ((tam > (decimais + 1)) && (tam <= (decimais + 3)) && ((vr.substr(0, 1)) != "0"))
                        objeto.value = vr.substr(0, tam - decimais) + ',' + vr.substr(tam - decimais, tam);

                    if ((tam >= (decimais + 4)) && (tam <= (decimais + 6)))
                        objeto.value = vr.substr(0, tam - (decimais + 3)) + '.' + vr.substr(tam - (decimais + 3), 3) +
                        ',' + vr.substr(tam - decimais, tam);

                    if ((tam >= (decimais + 7)) && (tam <= (decimais + 9)))
                        objeto.value = vr.substr(0, tam - (decimais + 6)) + '.' + vr.substr(tam - (decimais + 6), 3) +
                        '.' + vr.substr(tam - (decimais + 3), 3) + ',' + vr.substr(tam - decimais, tam);

                    if ((tam >= (decimais + 10)) && (tam <= (decimais + 12)))
                        objeto.value = vr.substr(0, tam - (decimais + 9)) + '.' + vr.substr(tam - (decimais + 9), 3) +
                        '.' + vr.substr(tam - (decimais + 6), 3) + '.' + vr.substr(tam - (decimais + 3), 3) + ',' + vr
                        .substr(tam - decimais, tam);

                    if ((tam >= (decimais + 13)) && (tam <= (decimais + 15)))
                        objeto.value = vr.substr(0, tam - (decimais + 12)) + '.' + vr.substr(tam - (decimais + 12), 3) +
                        '.' + vr.substr(tam - (decimais + 9), 3) + '.' + vr.substr(tam - (decimais + 6), 3) + '.' + vr
                        .substr(tam - (decimais + 3), 3) + ',' + vr.substr(tam - decimais, tam);

                } else if (decimais == 0) {
                    if (tam <= 3)
                        objeto.value = vr;

                    if ((tam >= 4) && (tam <= 6)) {
                        if (tecla == 8) {
                            objeto.value = vr.substr(0, tam);
                            window.event.cancelBubble = true;
                            window.event.returnValue = false;
                        }
                        objeto.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, 3);
                    }

                    if ((tam >= 7) && (tam <= 9)) {
                        if (tecla == 8) {
                            objeto.value = vr.substr(0, tam);
                            window.event.cancelBubble = true;
                            window.event.returnValue = false;
                        }
                        objeto.value = vr.substr(0, tam - 6) + '.' + vr.substr(tam - 6, 3) + '.' + vr.substr(tam - 3,
                            3);
                    }

                    if ((tam >= 10) && (tam <= 12)) {
                        if (tecla == 8) {
                            objeto.value = vr.substr(0, tam);
                            window.event.cancelBubble = true;
                            window.event.returnValue = false;
                        }
                        objeto.value = vr.substr(0, tam - 9) + '.' + vr.substr(tam - 9, 3) + '.' + vr.substr(tam - 6,
                            3) + '.' + vr.substr(tam - 3, 3);
                    }

                    if ((tam >= 13) && (tam <= 15)) {
                        if (tecla == 8) {
                            objeto.value = vr.substr(0, tam);
                            window.event.cancelBubble = true;
                            window.event.returnValue = false;
                        }
                        objeto.value = vr.substr(0, tam - 12) + '.' + vr.substr(tam - 12, 3) + '.' + vr.substr(tam - 9,
                            3) + '.' + vr.substr(tam - 6, 3) + '.' + vr.substr(tam - 3, 3);
                    }
                }
            }
        } else if ((window.event.keyCode != 8) && (window.event.keyCode != 9) && (window.event.keyCode != 13) && (window
                .event.keyCode != 35) && (window.event.keyCode != 36) && (window.event.keyCode != 46)) {
            window.event.cancelBubble = true;
            window.event.returnValue = false;
        }
    }

    function alterarOrdemServico() {
        var html = "";
        $("#tbodyAlterar").empty();
        $("input:checkbox[id=checkDistri]:checked").each(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/suprimentos/getDistribuir",
                type: 'POST',
                dataType: 'json',
                data: {
                    idDistribuir: $(this).val()
                },
                success: function(dataI) {
                    if (dataI.result == true) {
                        var obj;
                        for (x = 0; x < dataI.resultado.length; x++) {
                            html =
                                "<tr>" +
                                "<td><input type='hidden' value='" + dataI.resultado[x].idDistribuir + "'name='alterarDistribuir_' id='alterarDistribuir_'/>" + dataI.resultado[x].idOs + "</td>" +
                                "<td><input type='hidden' value='" + dataI.resultado[x].idStatuscompras + "'name='alterarStatuscompras_' id='alterarStatuscompras_'/>" + dataI.resultado[x].quantidade + "</td>" +
                                "<td>" + dataI.resultado[x].descricaoInsumo + " " + dataI.resultado[x].dimensoes + "</td>" +
                                "<td>" + dataI.resultado[x].nomeStatus + "</td>" +
                                "<td>" + dataI.resultado[x].idPedidoCompra + "</td>" +
                                "</tr>";
                            /*
                            obj = {
                                'idDistribuir':dataI.resultado[x].idDistribuir,
                                'idOs':dataI.resultado[x].idOs,
                                'descricaoInsumo':dataI.resultado[x].descricaoInsumo,
                                'dimensoes':dataI.resultado[x].dimensoes,
                                'nomeStatus':dataI.resultado[x].nomeStatus,
                                'quantidade':dataI.resultado[x].quantidade
                            }
                            arrayCheckDistri.push(obj);*/
                            $('#tbodyAlterar').append(html);
                        }

                        //console.log(arrayCheckDistri);
                    } else {
                        alert(dataI.msggg);
                    }


                },
                error: function(xhr, textStatus, error) {
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },

            });
        })
    }

    function calculaSubTotal(x) {
        //alert('contunit'+contador_global_autocomplete);
        var qtd = 0;
        var valorunit = 0;

        var valor_itemprodutos = 0;
        var valor_tot_pedido = 0;
        var valor_tot_ipi = 0;

        for (i = 0; i < contador_global_autocomplete; i++) {


            var valorunit = $('#valor_unitario' + i).val();
            valorunit = valorunit.toString().replace(".", "");
            valorunit = valorunit.toString().replace(",", ".");

            valorunit = parseFloat(valorunit);

            var ipivalor = $('#ipi_valor' + i).val();
            ipivalor = ipivalor.toString().replace(".", "");
            ipivalor = ipivalor.toString().replace(",", ".");

            ipivalor = parseFloat(ipivalor);



            /*valorunit=	valorunit.replace(/\./g, "");
            valorunit=	valorunit.replace(/,/g, ".");*/


            var qtd = $('#quantidade' + i).val();
            //alert(qtd);
            var calc_ipi = valorunit * qtd * (ipivalor / 100);
            //var total = ((valorunit * qtd) - desconto) *  valoripi / 100;
            var total1 = (valorunit * qtd) + calc_ipi;
            var total2 = (valorunit * qtd);


            total1 = parseFloat(total1);
            total2 = parseFloat(total2);



            valor_itemprodutos = valor_itemprodutos + total2;
            valor_tot_ipi = valor_tot_ipi + calc_ipi;





            $('#valor_produtos' + i).val(retorna_formatado(total1));



        }
        var desconto = 0;
        var icms = 0;
        var outros = 0;
        var frete = 0;
        for (i2 = 1; i2 <= contador_os; i2++) {
            var desconto_ = $('#descontoit' + i2).val();
            desconto_ = desconto_.toString().replace(".", "");
            desconto_ = desconto_.toString().replace(",", ".");
            desconto_ = parseFloat(desconto_);
            desconto = desconto + desconto_;


            var icms_ = $('#icmsit' + i2).val();
            icms_ = icms_.toString().replace(".", "");
            icms_ = icms_.toString().replace(",", ".");
            icms_ = parseFloat(icms_);
            icms = icms + icms_;

            var outros_ = $('#outrosit' + i2).val();
            outros_ = outros_.toString().replace(".", "");
            outros_ = outros_.toString().replace(",", ".");
            outros_ = parseFloat(outros_);
            outros = outros + outros_;


            var frete_ = $('#freteit' + i2).val();
            frete_ = frete_.toString().replace(".", "");
            frete_ = frete_.toString().replace(",", ".");
            frete_ = parseFloat(frete_);
            frete = frete + frete_;

        }


        //var compra = valor_itemprodutos - desconto;


        var tot = valor_itemprodutos - desconto + valor_tot_ipi + outros + frete;
        //alert($('#desconto').val());
        $('#valor_produtos_').val(retorna_formatado(valor_itemprodutos));
        $('#valor_total_').val(retorna_formatado(tot));

        $('#desconto_').val(retorna_formatado(desconto));

        $('#ipi_').val(retorna_formatado(valor_tot_ipi));
        $('#icms_').val(retorna_formatado(icms));
        $('#outros_').val(retorna_formatado(outros));
        $('#frete_').val(retorna_formatado(frete));



    }

    function retorna_formatado(num) {

        x = 0;

        if (num < 0) {
            num = Math.abs(num);
            x = 1;
        }

        if (isNaN(num)) num = "0";
        cents = Math.floor((num * 100 + 0.5) % 100);

        num = Math.floor((num * 100 + 0.5) / 100).toString();

        if (cents < 10) cents = "0" + cents;
        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
            num = num.substring(0, num.length - (4 * i + 3)) + '.' +
            num.substring(num.length - (4 * i + 3));

        ret = num + ',' + cents;

        if (x == 1) ret = ' - ' + ret;
        return ret;

    }

    function enabledDisabledButtonConfirm(valor) {
        arrayButton = Array.apply(null, document.querySelectorAll("#btnGerarEntradas"));
        arrayButton.forEach((elemento) => {
            if (valor == 1) {
                elemento.disabled = true;
            } else {
                elemento.disabled = false;
            }
        })
    }

    function modelEntrada(verifi) {
        var check = Array.apply(null, document.querySelectorAll("#idAlmoAgArmaz_"));
        var iddepartamento = Array.apply(null, document.querySelectorAll("#idDepartamento"));
        var local = Array.apply(null, document.querySelectorAll("#descricaoLocal"));
        var descricaoInsumoAgArmaz = Array.apply(null, document.querySelectorAll("#descricaoInsumoAgArmaz"));
        var quantidadeAgArmaz = Array.apply(null, document.querySelectorAll("#quantidadeAgArmaz"));

        var arrayIdAgArmaz = [];
        var arrayIdDepartamento = [];
        var arrayDescricaoDepartamento = [];
        var arraydescricaoInsumoAgArmaz = [];
        var arrayquantidadeAgArmaz = [];
        //var arrayIdLocal = [];
        var arrayLocal = [];
        for (x = 0; x < check.length; x++) {
            if (verifi != 1) {
                arrayIdAgArmaz.push(check[x].value);
                arrayIdDepartamento.push(iddepartamento[x].options[iddepartamento[x].selectedIndex].value);
                arrayDescricaoDepartamento.push(iddepartamento[x].options[iddepartamento[x].selectedIndex].text);
                arraydescricaoInsumoAgArmaz.push(descricaoInsumoAgArmaz[x].value);
                arrayquantidadeAgArmaz.push(quantidadeAgArmaz[x].value);
                arrayLocal.push(local[x].value);
            } else {
                if (check[x].checked) {
                    arrayIdAgArmaz.push(check[x].value);
                    arrayIdDepartamento.push(iddepartamento[x].options[iddepartamento[x].selectedIndex].value);
                    arrayDescricaoDepartamento.push(iddepartamento[x].options[iddepartamento[x].selectedIndex].text);
                    arrayLocal.push(local[x].value);
                    arraydescricaoInsumoAgArmaz.push(descricaoInsumoAgArmaz[x].value);
                    arrayquantidadeAgArmaz.push(quantidadeAgArmaz[x].value);
                }
            }

        }
        if (arrayIdAgArmaz.length <= 0) {
            alert("Não possuí nenhum item selecionado.");
            return;
        }
        var todos = {
            "idAgArmaz": arrayIdAgArmaz,
            "departamento": arrayDescricaoDepartamento,
            "insumo": arraydescricaoInsumoAgArmaz,
            "quantidade": arrayquantidadeAgArmaz,
            "local": arrayLocal
        }
        console.log(todos);
        if (verifi != 1) {
            tabelaEntradaTodos(todos);
        } else {
            tabelaEntradaSelecionados(todos);
        }

        /*
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/almoxarifado/entradasemiauto",
            type: 'POST',
            dataType: 'json',
            data: {
                idAlmoAgArmaz_:arrayIdAgArmaz,
                idDepartamento:arrayIdDepartamento,
                descricaoLocal:arrayLocal
            },
            success: function(data) {
                if(data.result){
                    alert(data.msggg);
                    atualizarMaterialParaArmazenar();
                }
                   
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })*/

    }

    function modelEntradaB(verifi) {
        var check = Array.apply(null, document.querySelectorAll("#idAlmoAgArmaz_"));
        var iddepartamento = Array.apply(null, document.querySelectorAll("#idDepartamento"));
        var local = Array.apply(null, document.querySelectorAll("#descricaoLocal"));
        var descricaoInsumoAgArmaz = Array.apply(null, document.querySelectorAll("#descricaoInsumoAgArmaz"));
        var quantidadeAgArmaz = Array.apply(null, document.querySelectorAll("#quantidadeAgArmaz"));

        var arrayIdAgArmaz = [];
        var arrayIdDepartamento = [];
        var arrayDescricaoDepartamento = [];
        var arraydescricaoInsumoAgArmaz = [];
        var arrayquantidadeAgArmaz = [];
        //var arrayIdLocal = [];
        var arrayLocal = [];
        enabledDisabledButtonConfirm(1);
        for (x = 0; x < check.length; x++) {
            if (verifi != 1) {
                arrayIdAgArmaz.push(check[x].value);
                arrayIdDepartamento.push(iddepartamento[x].options[iddepartamento[x].selectedIndex].value);
                arrayDescricaoDepartamento.push(iddepartamento[x].options[iddepartamento[x].selectedIndex].text);
                arraydescricaoInsumoAgArmaz.push(descricaoInsumoAgArmaz[x].value);
                arrayquantidadeAgArmaz.push(quantidadeAgArmaz[x].value);
                arrayLocal.push(local[x].value);
            } else {
                if (check[x].checked) {
                    arrayIdAgArmaz.push(check[x].value);
                    arrayIdDepartamento.push(iddepartamento[x].options[iddepartamento[x].selectedIndex].value);
                    arrayDescricaoDepartamento.push(iddepartamento[x].options[iddepartamento[x].selectedIndex].text);
                    arrayLocal.push(local[x].value);
                    arraydescricaoInsumoAgArmaz.push(descricaoInsumoAgArmaz[x].value);
                    arrayquantidadeAgArmaz.push(quantidadeAgArmaz[x].value);
                }
            }

        }
        if (arrayIdAgArmaz.length <= 0) {
            alert("Não possuí nenhum item selecionado.");
            enabledDisabledButtonConfirm(0);
            return;
        }



        $.ajax({
            url: "<?php echo base_url(); ?>index.php/almoxarifado/entradasemiauto",
            type: 'POST',
            dataType: 'json',
            data: {
                idAlmoAgArmaz_: arrayIdAgArmaz,
                idDepartamento: arrayIdDepartamento,
                descricaoLocal: arrayLocal
            },
            success: function(data) {
                if (data.result) {
                    alert(data.msggg);
                    enabledDisabledButtonConfirm(0);
                    atualizarMaterialParaArmazenar();
                    if (verifi != 1) {
                        $('#modal-entradaTodos').modal('hide');
                        $('.modal-backdrop').remove();
                    } else {
                        $('#modal-entradaSelecionados').modal('hide');
                        $('.modal-backdrop').remove();
                    }
                } else {
                    alert(data.msggg);
                }

            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
                //enabledDisabledButtonConfirm(0);
            },
        })

    }

    function tabelaEntradaTodos(result) {
        var table = document.getElementById("tbodyEntradaTodos").getElementsByTagName('tbody')[0];
        $('#tbodyEntradaTodos tbody').empty();
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        var newRow = table.insertRow(numOfRows);
        for (x = 0; x < result.idAgArmaz.length; x++) {
            var newRow = table.insertRow(numOfRows);
            newCell = newRow.insertCell(0);
            newCell.innerHTML = result.insumo[x];

            newCell = newRow.insertCell(1);
            newCell.innerHTML = result.quantidade[x];

            newCell = newRow.insertCell(2);
            newCell.innerHTML = result.departamento[x];

            newCell = newRow.insertCell(3);
            newCell.innerHTML = result.local[x];
        }
        $("#modal-entradaTodos").modal('show');

    }

    function tabelaEntradaSelecionados(result) {
        var table = document.getElementById("tbodyEntradaSelecionados").getElementsByTagName('tbody')[0];
        $('#tbodyEntradaSelecionados tbody').empty();
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        var newRow = table.insertRow(numOfRows);
        for (x = 0; x < result.idAgArmaz.length; x++) {
            var newRow = table.insertRow(numOfRows);
            newCell = newRow.insertCell(0);
            newCell.innerHTML = result.insumo[x];

            newCell = newRow.insertCell(1);
            newCell.innerHTML = result.quantidade[x];

            newCell = newRow.insertCell(2);
            newCell.innerHTML = result.departamento[x];

            newCell = newRow.insertCell(3);
            newCell.innerHTML = result.local[x];
        }
        $("#modal-entradaSelecionados").modal('show');

    }

    function filtrarDistribuirOs() {
        var ordemDeCompra = document.querySelector('#idPedidoCompra').value;
        var nfe = document.querySelector('#nf_fornecedor').value;
        var numPedido = document.querySelector('#numPedido').value;
        var fornecedor = document.querySelector('#fornecedor').value;
        var descricao = document.querySelector('#descricao').value;
        var empresaNum1 = document.querySelector('#empresaNum1').value;
        var empresaNum2 = document.querySelector('#empresaNum2').value;
        var select = document.getElementById('idStatuscompras');
        var idStatusCompras = select.options[select.selectedIndex].value;

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/filtrarDistribuirOs",
            type: 'POST',
            dataType: 'json',
            data: {
                idPedidoCompra: ordemDeCompra,
                nf_fornecedor: nfe,
                numPedido: numPedido,
                fornecedor: fornecedor,
                descricao: descricao,
                empresaNum1: empresaNum1,
                empresaNum2: empresaNum2,
                idStatuscompras: idStatusCompras
            },
            success: function(data) {
                atualizarTabelSuprimentos(data.resultado);
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        })
    }

    function imprimir() {
        var data2 = [];
        //var emitente = document.querySelector("#idEmitente2").value;
        var select = document.getElementById('idEmitente2');
        var emitente = select.options[select.selectedIndex].value;
        $("input:checkbox[id=checkDistri]:checked").each(function() {
            data2.push($(this).val());
        });
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/imprimiritem3Almoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                idDistribuir_: data2,
                idEmitente: emitente
            },
            success: function(data) {
                if (data.result) {
                    atualizarTabelSuprimentos(data.resultado);
                    var mywindow = window.open("", '_blank').document.write(data.html);
                    //mywindow
                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        })
    }

    function imprimiritem() {
        var data2 = [];
        var data3 = [];
        //var emitente = document.querySelector("#idEmitente2").value;
        var select = Array.apply(null, document.querySelectorAll('#idPedidoCompraipi3'));
        select.forEach((elemento) => {
            data3.push(elemento.value);
        });
        $("input:checkbox[id=idPedidoCompraItensipi3]:checked").each(function() {
            data2.push($(this).val());
        });
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/imprimiritemAlmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                idPedidoCompraItensipi: data2,
                idPedidoCompraipi: data3
            },
            success: function(data) {
                if (data.result) {
                    var mywindow = window.open("", '_blank').document.write(data.html);
                    //mywindow
                } else {
                    alert(data.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        })
    }

    function verificarInsumoCategoriaSubcategoria() {


        var prod = document.querySelector("#prod").value;
        var idProdutos = document.querySelector("#idProdutos").value;
        var catEntrada = document.querySelector("#categoriaEntrada").value;
        var idCatEntrada = document.querySelector("#idCategoriaEntrada").value;
        var subcatEntrada = document.querySelector("#subcategoriaEntrada").value;
        var idSubcatEntrada = document.querySelector("#idSubcategoriaEntrada").value;




        if (typeof subcatEntrada != "UNDEFINED" && subcatEntrada != null && subcatEntrada != "" && typeof catEntrada != "UNDEFINED" && catEntrada != null && catEntrada != "" && typeof prod != "UNDEFINED" && prod != null && prod != "") {

            if (idProdutos == "") {
                if (idCatEntrada == "") {
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
                                    subcat: idSubcatEntrada
                                },
                                success: function(dataI) {
                                    if (dataI.result == true) {
                                        document.querySelector("#idProdutos").value = dataI.idInsumo;
                                        //verificarCadastroLocal(pn);
                                        inserirItensTabela();
                                    } else {
                                        alert(dataI.msggg);
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
                        },
                        error: function(xhr, textStatus, error) {
                            console.log("3");
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        },
                    });
                } else if (idSubcatEntrada == "") {
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
                                    subcat: idSubcatEntrada
                                },
                                success: function(dataI) {
                                    if (dataI.result == true) {
                                        document.querySelector("#idProdutos").value = dataI.idInsumo;
                                        //verificarCadastroLocal(pn);
                                        inserirItensTabela();
                                    } else {
                                        alert(dataI.msggg);
                                    }


                                },
                                error: function(xhr, textStatus, error) {
                                    console.log("2");
                                    console.log(xhr.responseText);
                                    console.log(xhr.statusText);
                                    console.log(textStatus);
                                    console.log(error);
                                },

                            });
                        },
                        error: function(xhr, textStatus, error) {
                            console.log("1");
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
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
                            subcat: idSubcatEntrada
                        },
                        success: function(data) {
                            if (data.result == true) {

                                document.querySelector("#idProdutos").value = data.idInsumo;
                                //verificarCadastroLocal(pn);
                                inserirItensTabela();
                            } else {
                                alert(data.msggg);
                            }


                        },

                    });
                }
            } else {
                inserirItensTabela();

            }
        } else {
            console.log("B");
            a.disabled = false;
            alertaAdicionar();
        }
    }

    function atualizarMaterialParaArmazenar() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/atualizarMaterialParaArmazenar",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.result) {
                    atualizarTabelaMaterialParaArmazenar(data.resultado, data.dados_depinsumos);
                }
            }
        })
    }

    function atualizarTabelaMaterialParaArmazenar(resultado, dados_depinsumos) {
        var table = document.getElementById("tableMateriaisArmazenar").getElementsByTagName('tbody')[0];
        $('#tableMateriaisArmazenar tbody').empty();
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        for (x = 0; x < resultado.length; x++) {
            var newRow = table.insertRow(numOfRows);
            newCell = newRow.insertCell(0);
            newCell.innerHTML = "<input type='checkbox' id='idAlmoAgArmaz_' value='" + resultado[x].idAlmoAgArmaz + "' name='idAlmoAgArmaz_'>";

            newCell = newRow.insertCell(1);
            newCell.innerHTML = resultado[x].descricaoInsumo + "<input type='hidden' id='descricaoInsumoAgArmaz' value='" + resultado[x].descricaoInsumo + "' name='descricaoInsumoAgArmaz'>";

            newCell = newRow.insertCell(2);
            newCell.innerHTML = resultado[x].quantidade + "<input type='hidden' id='quantidadeAgArmaz' value='" + resultado[x].quantidade + "' name='quantidadeAgArmaz'>";

            newCell = newRow.insertCell(3);
            newCell.innerHTML = resultado[x].idOrdemCompra;

            newCell = newRow.insertCell(4);
            newCell.innerHTML = resultado[x].nome;

            newCell = newRow.insertCell(5);
            html = '<select id="idDepartamento">' +
                '<option value=""></option>';
            if (resultado[x].idDepartamentoSUG == null || resultado[x].idDepartamentoSUG == "") {
                //newCell.innerHTML =  '<select id="idDepartamento">'+
                //'<option value=""></option>';
                dados_depinsumos.forEach((elemento) => {
                    html = html + '<option value="' + elemento.idAlmoEstoqueDep + '">' + elemento.descricaoDepartamento + '</option>';
                })
                //newCell.innerHTML +=  '</select>';
            } else {
                //newCell.innerHTML =  '<select id="idDepartamento">'+
                //'<option value=""></option>';
                dados_depinsumos.forEach((elemento) => {
                    if (resultado[x].idDepartamentoSUG == elemento.idAlmoEstoqueDep) {
                        html = html + '<option selected value="' + elemento.idAlmoEstoqueDep + '">' + elemento.descricaoDepartamento + '</option>';
                    } else {
                        html = html + '<option value="' + elemento.idAlmoEstoqueDep + '">' + elemento.descricaoDepartamento + '</option>';

                    }
                })
                //newCell.innerHTML += '</select>';                                    
            }
            html = html + '</select>';
            newCell.innerHTML = html;
            newCell = newRow.insertCell(6);
            local = resultado[x].local == null ? "" : resultado[x].local;
            localSUG = resultado[x].localSUG == null ? "" : resultado[x].localSUG
            if (resultado[x].idLocalSUG == null || resultado[x].idLocalSUG == "") {
                newCell.innerHTML = '<input type="text" name="descricaoLocal" id="descricaoLocal" value="' + local + '">' +
                    '<input type="hidden" value="' + resultado[x].idAlmoEstoqueLocais + '">';
            } else {
                newCell.innerHTML = '<input type="text" name="descricaoLocal" id="descricaoLocal" value="' + localSUG + '">' +
                    '<input type="hidden" value="' + resultado[x].idLocalSUG + '">';
            }

            newCell = newRow.insertCell(7);
            newCell.innerHTML = resultado[x].descricaoAgArmaz;

            newCell = newRow.insertCell(8);
            newCell.innerHTML = '<a style="margin-right: 1%" href="#modal-cancelarEntrada" data-toggle="modal" role="button" class="btn btn-danger tip-top " cancelarEntradaId = "' + resultado[x].idAlmoAgArmaz + '" descricaoEntrada = "' + resultado[x].descricaoInsumo + '" qtdEntrada = "' + resultado[x].quantidade + '" class="excluir"><font size=1>Excluir</font> </a>';
        }

    }

    function cancelarEntrada() {
        var cancelarID = document.querySelector("#cancelarID").value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/almoxarifado/cancelarentrada",
            type: 'POST',
            dataType: 'json',
            data: {
                cancelarID: cancelarID
            },
            success: function(data) {
                if (data.result) {
                    alert(data.msggg);
                    $('#modal-cancelarEntrada').modal('hide');
                    $('.modal-backdrop').remove();
                    atualizarMaterialParaArmazenar();
                }
            }
        })
    }

    $("input:checkbox[name=checkPermAlmo]").click(function() {
        //console.log(this.checked);
        //console.log(this.value)
        permCompra(this.value, this.checked);
    })

    function permCompra(insumo, statusCheck) {
        var test = Array.apply(null, document.querySelectorAll("#checkPermAlmo" + insumo));
        test.forEach((elemento) => {
            elemento.checked = statusCheck;
        })
        console.log(statusCheck);
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/permCompraAlmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                insumo: insumo,
                statusCheck: statusCheck
            },
            success: function(data) {
                if (data.result) {
                    console.log(data.msggg)
                }
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    $(document).ready(function() {

        jQuery(".data").mask("99/99/9999");
    });

    $(document).ready(function() {

        $(function() {
            $(document).on('click', 'input[type=text][id=example1]', function() {
                this.select();
            });
        });
    })

    $(document).on('click', 'a', function(event) {

        var id_disti1 = $(this).attr('id_disti1');
        $('#id_item_pc1').val(id_disti1);

    });

    $(document).on('click', 'a', function(event) {

        var id_disti2 = $(this).attr('id_disti2');
        $('#id_item_pc2').val(id_disti2);

    });

    $(document).on('click', 'a', function(event) {

        var cancelarEntradaId = $(this).attr('cancelarEntradaId');
        var descricaoEntrada = $(this).attr('descricaoEntrada');
        var qtdEntrada = $(this).attr('qtdEntrada');


        var table = document.getElementById("tbodyCancelarEntrada").getElementsByTagName('tbody')[0];
        $('#tbodyCancelarEntrada tbody').empty();
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        var newRow = table.insertRow(numOfRows);
        newCell = newRow.insertCell(0);
        newCell.innerHTML = descricaoEntrada + '<input type="hidden" name="cancelarID" id="cancelarID" value="' + cancelarEntradaId + '">';
        newCell = newRow.insertCell(1);
        newCell.innerHTML = qtdEntrada;



        //$('#id_item_pc2').val(id_disti2);

    });

    $('#alterarQuantidade').click(function() {
        var idDistrbuirOs2 = document.querySelector("#idDistrbuirOs2").value;
        var quantidadeModal = document.querySelector("#quantidadeModal").value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/alterarQtdDistribuirOs",
            type: 'POST',
            dataType: 'json',
            data: {
                idDistribuir: idDistrbuirOs2,
                quantidade: quantidadeModal
            },
            success: function(data) {
                if (data.result) {
                    filtrarDistribuirOs();
                    alert(data.msggg);
                    $("#modal-editarquantidade").modal('hide');
                } else {
                    alert(data.msggg);

                }
            }
        })
    })

    $("#checkTodos").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).ready(function() {
        /*
                $("input:checkbox[]:checked").each(function(){
                    arrayCheckDistri.push($(this).val());
                    console.log(arrayCheckDistri);
                });*/
        $("#excluir").click(function() {
            var html = "";
            var check = false;
            $("#tbodyExcluir").empty();
            $("input:checkbox[id=checkDistri]:checked").each(function() {
                //arrayCheckDistri.push($(this).val());
                // 
                check = true;
                html = "";
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/suprimentos/getDistribuir",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        idDistribuir: $(this).val()
                    },
                    success: function(dataI) {
                        if (dataI.result == true) {
                            var obj;
                            for (x = 0; x < dataI.resultado.length; x++) {
                                html =
                                    "<tr>" +
                                    "<td><input type='hidden' value='" + dataI.resultado[x].idDistribuir + "'name='excluirDistribuir_' id='excluirDistribuir_'/>" + dataI.resultado[x].idOs + "</td>" +
                                    "<td><input type='hidden' value='" + dataI.resultado[x].idStatuscompras + "'name='excluirStatuscompras_' id='excluirStatuscompras_'/>" + dataI.resultado[x].quantidade + "</td>" +
                                    "<td>" + dataI.resultado[x].descricaoInsumo + " " + dataI.resultado[x].dimensoes + "</td>" +
                                    "<td>" + dataI.resultado[x].nomeStatus + "</td>" +
                                    "</tr>";
                                /*
                                obj = {
                                    'idDistribuir':dataI.resultado[x].idDistribuir,
                                    'idOs':dataI.resultado[x].idOs,
                                    'descricaoInsumo':dataI.resultado[x].descricaoInsumo,
                                    'dimensoes':dataI.resultado[x].dimensoes,
                                    'nomeStatus':dataI.resultado[x].nomeStatus,
                                    'quantidade':dataI.resultado[x].quantidade
                                }
                                arrayCheckDistri.push(obj);*/
                                $('#tbodyExcluir').append(html);
                            }

                            //console.log(arrayCheckDistri);
                        } else {
                            alert(dataI.msggg);
                        }


                    },
                    error: function(xhr, textStatus, error) {
                        console.log(xhr.responseText);
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(error);
                    },

                });
                //console.log(arrayCheckDistri);
            })
            if (check) {
                $('#modal-excluirSelect').modal('toggle');
                $('#modal-excluirSelect').modal('show');
            }

            //$('#modal-excluirSelect').modal('hide');
        })
        $("#excluir2").click(function() {
            var html = "";
            $("#tbodyExcluir").empty();
            $("input:checkbox[id=checkDistri]:checked").each(function() {
                //arrayCheckDistri.push($(this).val());
                // 
                html = "";
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/suprimentos/getDistribuir",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        idDistribuir: $(this).val()
                    },
                    success: function(dataI) {
                        if (dataI.result == true) {
                            check = true;
                            var obj;
                            for (x = 0; x < dataI.resultado.length; x++) {
                                html =
                                    "<tr>" +
                                    "<td><input type='hidden' value='" + dataI.resultado[x].idDistribuir + "'name='excluirDistribuir_' id='excluirDistribuir_'/>" + dataI.resultado[x].idOs + "</td>" +
                                    "<td><input type='hidden' value='" + dataI.resultado[x].idStatuscompras + "'name='excluirStatuscompras_' id='excluirStatuscompras_'/>" + dataI.resultado[x].quantidade + "</td>" +
                                    "<td>" + dataI.resultado[x].descricaoInsumo + " " + dataI.resultado[x].dimensoes + "</td>" +
                                    "<td>" + dataI.resultado[x].nomeStatus + "</td>" +
                                    "</tr>";
                                /*
                                obj = {
                                    'idDistribuir':dataI.resultado[x].idDistribuir,
                                    'idOs':dataI.resultado[x].idOs,
                                    'descricaoInsumo':dataI.resultado[x].descricaoInsumo,
                                    'dimensoes':dataI.resultado[x].dimensoes,
                                    'nomeStatus':dataI.resultado[x].nomeStatus,
                                    'quantidade':dataI.resultado[x].quantidade
                                }
                                arrayCheckDistri.push(obj);*/
                                $('#tbodyExcluir').append(html);
                            }

                            //console.log(arrayCheckDistri);
                        } else {
                            alert(dataI.msggg);
                        }


                    },
                    error: function(xhr, textStatus, error) {
                        console.log(xhr.responseText);
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(error);
                    },

                });
                //console.log(arrayCheckDistri);
            })
            if (check) {
                $('#modal-excluirSelect').modal('toggle');
                $('#modal-excluirSelect').modal('show');
            }
            //$('#modal-excluirSelect').modal('hide');
        })
    })

    $(document).ready(function() {
        $("#alterar").click(function() {
            alterarOrdemServico();
            $('#modal-editarpedidocompraitens').modal('toggle');
            $('#modal-editarpedidocompraitens').modal('show');
        })
        $("#alterar2").click(function() {
            alterarOrdemServico();
            $('#modal-editarpedidocompraitens').modal('toggle');
            $('#modal-editarpedidocompraitens').modal('show');
        })
    })
</script>