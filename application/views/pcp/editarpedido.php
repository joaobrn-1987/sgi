<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>


<?php

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

                        <th>Nº OS</th>
                        <th>Qtd.</th>
                        <th>Descrição</th>
                        <th>Dimensões</th>
                        <th>OBS</th>
                        <th>Data Cadastro</th>
                        <th>Status</th>
                        <th>Pedido Cotação</th>
                        <th>Pedido Compra</th>
                        <th>Data Entregue</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Item Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php } else {
    echo "<br>";
    echo "<br>";

?>

    <body onLoad="calculaSubTotal();">

        <!--
    <div class='span12'>
        Filtrar: <b>Status Compra:</b><select class="controls" name="idStatuscompras2_" id="idStatuscompras2_">
            <option value=''></option>
            <option
                value='<?php echo base_url() ?>index.php/suprimentos/editarpedido/<?php echo $results[0]->idPedidoCompra; ?>'>
                TODOS</option>
            <?php foreach ($dados_statuscompra as $so) { ?>

            <option
                value="<?php echo base_url() ?>index.php/suprimentos/editarpedido/<?php echo $results[0]->idPedidoCompra; ?>/st-<?php echo $so->idStatuscompras; ?>">
                <?php echo $so->nomeStatus; ?></option>
            <?php } ?>


        </select>
        <b> Nota Fiscal:</b><select class="controls" name="nto" id="nto">
            <option value=''></option>
            <option
                value='<?php echo base_url() ?>index.php/suprimentos/editarpedido/<?php echo $results[0]->idPedidoCompra; ?>'>
                TODOS</option>
            <?php foreach ($resultsnf as $gg) { ?>

            <option
                value="<?php echo base_url() ?>index.php/suprimentos/editarpedido/<?php echo $results[0]->idPedidoCompra; ?>/nf-<?php echo $gg->notafiscal; ?>">
                <?php echo $gg->notafiscal; ?></option>
            <?php } ?>


        </select>
        <b> OS:</b><select class="controls" name="os_" id="os_">
            <option value=''></option>
            <option
                value='<?php echo base_url() ?>index.php/suprimentos/editarpedido/<?php echo $results[0]->idPedidoCompra; ?>'>
                TODOS</option>
            <?php foreach ($resultsosf as $os) { ?>

            <option
                value="<?php echo base_url() ?>index.php/suprimentos/editarpedido/<?php echo $results[0]->idPedidoCompra; ?>/os-<?php echo $os->idOs; ?>">
                <?php echo $os->idOs; ?></option>
            <?php } ?>


        </select>

    </div>-->
        <!--
    </form>-->


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


        <?php

        //echo '<a href="'.base_url().'index.php/pedidocompra/imprimir_pedido/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'" style="margin-right: 1%" class="class="btn btn-mini btn-info" title="Imprimir pedido" target="_blank"><button class="btn btn-mini btn-info" title="Imprimir PDF"><i class="icon-print icon-white"> Imprimir</i></button></a>'; 

        echo '<a href="#modal-imprimiritem" style="margin-right: 1%" role="button" data-toggle="modal" title="Imprimir Parcial"><font color="blue"><i class="icon-print icon-white">Imprimir</i></font></a>';
        ?>

        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Itens Pedido de compra</h5>

                <!--
            <a href="#modal-dadosnotafiscal" style="margin-right: 1%" role="button"
                data-toggle="modal" title="Dados Nota Fiscal">
                <font color="blue"><i class="icon-pencil icon-white"> <b>INSERIR DADOS NOTA FISCAL DOS ITENS
                            ABAIXO:</b></i></font>
            </a>
            <br>-->



            </div>

            <div>


                <form action="<?php echo base_url() ?>index.php/pcp/salvaritemcompra" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">


                    <!-------------------------------------------------------------------->
                    <input type="hidden" name="idPedidoCompra" value="<?= set_value('idPedidoCompra', null) ?>">
                    <input type="hidden" name="nf_fornecedor" value="<?= set_value('nf_fornecedor', null) ?>">
                    <input type="hidden" name="idOs" value="<?= set_value('idOs', null) ?>">
                    <input type="hidden" name="idStatuscompras" value="<?= set_value('idStatuscompras', null) ?>">
                    <input type="hidden" name="numPedido" value="<?= set_value('numPedido', null) ?>">
                    <input type="hidden" name="fornecedor" value="<?= set_value('fornecedor', null) ?>">
                    <input type="hidden" name="fornecedor_id" value="<?= set_value('fornecedor_id', null) ?>">
                    <input type="hidden" name="empresaNum1" value="<?= set_value('empresaNum1', null) ?>">
                    <input type="hidden" name="empresaNum2" value="<?= set_value('empresaNum2', null) ?>">

                    <!-------------------------------------------------------------------->
                    <table class="table table-bordered">

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
                            <th width='70'>QTD<br>recebida</th>
                            <th>Valor Unit.</th>
                            <th width='40'>IPI% <a href="#modal-ipi" style="margin-right: 1%" role="button" data-toggle="modal" title="Editar IPI">
                                    <font color='red'><i class="icon-pencil icon-white"></i></font>
                                </a></th>
                            <th>ICMS</th>
                            <th>Valor <br>total</th>

                            <th>N° NF <a href="#modal-ipi" style="margin-right: 1%" role="button" data-toggle="modal" title="Editar IPI">
                                    <font color='red'><i class="icon-pencil icon-white"></i></font>
                                </a></th>


                        </tr>

                        <?php
                        $contador = 0;
                        $idPedidoCompra = 0;
                        $previsaoEntrega = '';
                        $contLinesForn = 0;
                        //print_r($results);              
                        foreach ($results as $r) {
                            //print_r($r); exit;
                            //Cor de acordo com o status  
                            $color = '';
                            $codStatus = $r->idStatuscompras;
                            if ($codStatus == 1) {
                                $color = '#000000';
                            } else if ($codStatus == 2) {
                                $color = '#0000FF';
                            } else if ($codStatus == 3) {
                                $color = '#008000';
                            } else if ($codStatus == 4) {
                                $color = '#A020F0';
                            } else if ($codStatus == 5) {
                                $color = '#FFA500';
                            } else if ($codStatus == 6) {
                                $color = '#FF0000';
                            }

                        ?>
                            <?php
                            // print_r($r->idPedidoCompra);
                            if ($idPedidoCompra != $r->idPedidoCompra || $previsaoEntrega != $r->previsao_entrega) {
                                $nomeFornecedor = $r->nomeFornecedor;
                                $nomeEmitente = $r->nome;
                                $idPedidoCompra = $r->idPedidoCompra;
                                $previsaoEntrega = $r->previsao_entrega;
                                $contLinesForn = $contLinesForn + 1;
                            ?>

                                <tr>
                                    <td style="width:100%; border:1px solid #EEEEEE" class="table-bordered" COLSPAN="12">
                                        <a href="#modal-fornec-emitente<?php echo $r->idPedidoCompra . $r->previsao_entrega; ?>" data-toggle="modal"><?php echo ' <b>OC:</b> ' . $r->idPedidoCompra . ' <b>Empresa:</b> ' . $nomeEmitente . '/ <b>Fornecedor:</b> ' . $nomeFornecedor . ' <b>Previsão de entrega:</b> ' . $r->previsao_entrega; ?></a>
                                        <a href="#modal-fornec-emitente<?php echo $r->idPedidoCompra . $r->previsao_entrega; ?>" style="margin-right: 1%" role="button" data-toggle="modal" title="Editar IPI">
                                            <font color='red'><i class="icon-pencil icon-white"></i></font>
                                        </a>
                                    </td>
                                </tr>

                            <?php
                            }
                            ?>

                            <tr style="color:<?php echo $color; ?>" class="table-bordered">

                                <input id="idPedidoCompraItens" type="hidden" name="idPedidoCompraItens[]" value="<?php echo $r->idPedidoCompraItens; ?>" />
                                <input id="idDistribuir" type="hidden" name="idDistribuir[]" value="<?php echo $r->idDistribuir; ?>" />
                                <input id="idCotacaoItens" type="hidden" name="idCotacaoItens[]" value="<?php echo $r->idCotacaoItens; ?>" />
                                <input type="hidden" id="item<?php echo $contador; ?>" name="item[]" value="" size="1" />
                                <td><a href="#modal-usuario<?php echo $r->idPedidoCompraItens; ?>" style="margin-right: 1%" role="button" data-toggle="modal" class="btn tip-top"><i class="icon icon-user"></i></a>
                                    <font size='1'><?php echo $r->idOs; ?></font>
                                </td>
                                <td><input id="quantidade<?php echo $contador; ?>" type="hidden" name="quantidade[]" value="<?php echo $r->quantidade; ?>" /><?php echo $r->quantidade; ?> -
                                    <?php
                                    if ($r->liberado_edit_compras == 0) {
                                        if ($r->idStatuscompras <> 7) {
                                    ?>
                                            <a href="#modal-editar_1" style="margin-right: 1%" role="button" data-toggle="modal" id_disti1="<?php echo $r->idDistribuir; ?>" title="Destravar para editar">
                                                <font color='red'><i class="icon-remove icon-white"></i></font>
                                            </a>



                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <a href="#modal-editar_0" style="margin-right: 1%" role="button" data-toggle="modal" id_disti2="<?php echo $r->idDistribuir; ?>" title="Travar edição">
                                            <font color='blue'><i class="icon-pencil icon-white"></i></font>
                                        </a>
                                    <?php
                                    }

                                    ?>



                                </td>
                                <td>
                                    <font size='1'><?php 
                                    $html = $r->descricaoInsumo;
                                    if(!empty($r->dimensoes)){
                                        $html.=" ".$r->dimensoes;
                                    } 
                                    if(!empty($r->comprimento)){
                                        $html.=" ".$r->comprimento." cm";
                                    } 
                                    if(!empty($r->volume)){
                                        $html.=" ".$r->volume." ml";
                                    } 
                                    if(!empty($r->peso)){
                                        $html.=" ".$r->peso." g";
                                    } 
                                    
                                    if(!empty($r->dimensoesL)){
                                        $html .= " Largura: ".$r->dimensoesL." mm";
                                    }
                                    if(!empty($r->dimensoesC)){
                                        $html .= " Comp.: ".$r->dimensoesC." mm";
                                    }
                                    if(!empty($r->dimensoesA)){
                                        $html .= " Altura: ".$r->dimensoesA." mm";
                                    }
                                    echo $html;
                                    //echo $r->descricaoInsumo . " " . $r->dimensoes; 
                                    ?></font>
                                </td>

                                <td width='10'>
                                    <font size='1'><?php echo $r->obs; ?></font>
                                </td>

                                <td>
                                    <select class="recebe-solici" class="controls" style="font-size: 10px;" name="idStatuscompras[]" id="idStatuscompras<?php echo $contador; ?>">

                                        <?php foreach ($dados_statuscompra as $so) { ?>
                                            
                                            <?php
                                            //echo '<script>console.log("Etapa: '.$r->etapa.' Aprovacao PCP: '.$r->aprovacaoPCP.' Aprovacao SUP: '.$r->aprovacaoSUP.' Aprovacao Financeiro: '.$r->autorizadoCompra.' IDDistribuir '.$r->idDistribuir.'")</script>';
                                            if ($r->idOs <= 19999) {
                                                if($r->etapa <= 3 && ($r->autorizadoCompra == 0 || $r->aprovacaoPCP == 0 || $r->aprovacaoSUP == 0)){
                                                    if($so->etapa<=3 && $so->etapa!= 0){
                                                        ?>
                                                            <option value="<?php echo $so->idStatuscompras; ?>" <?php if ($so->idStatuscompras == $r->idStatuscompras) {
                                                                                                                    echo "selected='selected'";
                                                                                                                } ?>>
                                                                <?php echo $so->nomeStatus; ?>
                                                            </option>
                                                        <?php
                                                    }
                                                   }else{
                                                    ?>
                                                        <option value="<?php echo $so->idStatuscompras; ?>" <?php if ($so->idStatuscompras == $r->idStatuscompras) {
                                                                                                                echo "selected='selected'";
                                                                                                            } ?>>
                                                            <?php echo $so->nomeStatus; ?>
                                                        </option>
                                                    <?php
                                                   }?>  
                                            
                                            <!--
                                                <?php if ($r->idStatuscompras == 6 && $so->idStatuscompras >= 3) { ?>
                                                    <option value="<?php echo $so->idStatuscompras; ?>" <?php if ($so->idStatuscompras == $r->idStatuscompras) {
                                                                                                            echo "selected='selected'";
                                                                                                        } ?>>
                                                        <?php echo $so->nomeStatus; ?>
                                                    </option>
                                                <?php } elseif ($r->idStatuscompras != 6) { ?>
                                                    <option value="<?php echo $so->idStatuscompras; ?>" <?php if ($so->idStatuscompras == $r->idStatuscompras) {
                                                                                                            echo "selected='selected'";
                                                                                                        } ?>>
                                                        <?php echo $so->nomeStatus; ?>
                                                    </option>
                                                <?php } ?>
                                                                                                    -->
                                                <?php
                                            } else {
                                               if($r->etapa <= 3 && ($r->autorizadoCompra == 0 || $r->aprovacaoPCP == 0 || $r->aprovacaoSUP == 0)){
                                                if($so->etapa<=3 && $so->etapa!= 0){
                                                    ?>
                                                        <option value="<?php echo $so->idStatuscompras; ?>" <?php if ($so->idStatuscompras == $r->idStatuscompras) {
                                                                                                                echo "selected='selected'";
                                                                                                            } ?>>
                                                            <?php echo $so->nomeStatus; ?>
                                                        </option>
                                                    <?php
                                                }
                                               }else{
                                                ?>
                                                    <option value="<?php echo $so->idStatuscompras; ?>" <?php if ($so->idStatuscompras == $r->idStatuscompras) {
                                                                                                            echo "selected='selected'";
                                                                                                        } ?>>
                                                        <?php echo $so->nomeStatus; ?>
                                                    </option>
                                                <?php
                                               }
                                               
                                                
                                            }
                                            ?>

                                        <?php } ?>


                                    </select>

                                </td>
                                <td>
                                    <font size='1'>
                                        <?php
                                        $hratu = date("H:i:s");
                                        if (!empty($r->datastatusentregue)) {
                                            echo $dataentr = date("d/m/Y", strtotime($r->datastatusentregue));
                                            //$dataentr1 = date("d/m/Y", strtotime($r->datastatusentregue));
                                            //$dataentr2 = date("H:i:s", strtotime($r->datastatusentregue));

                                        ?>
                                            <input id="dataentregue" class="data span14" type="hidden" name="dataentregue[]" value="<?php echo $dataentr; ?>" />
                                            <!--<input id="dataentregue" class="data span14" type="hidden" name="dataentregue[]" value="<?php echo $dataentr1; ?>"/>
                                            <input id="horaentregue" class="data span14" type="hidden" name="horaentregue[]" value="<?php echo $dataentr2; ?>"/>-->
                                        <?php
                                        } else {
                                        ?>

                                            <input id="dataentregue" class="data span14" type="text" name="dataentregue[]" value="" style="font-size: 10px;" size='17' />
                                            <!--<input id="horaentregue" class="data span14" type="hidden" name="horaentregue[]" value="<?php echo $hratu; ?>"/>-->
                                        <?php
                                        }
                                        ?>
                                    </font>

                                </td>

                                <td>
                                    <font size='1'>
                                        <?php echo $r->nomegrupo; ?></font>

                                    <?php
                                    if ($r->idgrupo == 5) {

                                        $entrada = $this->pedidocompra_model->gettable2("estoque_entrada", "estoque_entrada.idPedidoCompraItens", $r->idPedidoCompraItens);
                                        if (count($entrada) == 0) {
                                    ?>
                                            <a href="#modalsaida2" data-toggle="modal" role="button" idInsumos_e="<?php echo $r->idInsumos; ?>" idPedidoCompra_e="<?php echo $r->idPedidoCompra; ?>" idPedidoCompraItens_e="<?php echo $r->idPedidoCompraItens; ?>" quantidade_e="<?php echo $r->quantidade; ?>" dimensoes_e="<?php echo $r->dimensoes; ?>" valor_unitario_e="<?php echo $r->valor_unitario; ?>" idEmitente_e="<?php echo $r->idEmitente; ?>"><img src="<?php echo base_url() ?>assets/img/sign-in.png" title="Dar Entrada" /></a>


                                        <?php
                                        } else {
                                            //$r->idInsumos    $r->idPedidoCompra  $r->idPedidoCompraItens  $r->quantidade   $r->dimensoes   $r->valor_unitario   $r->idEmitente   
                                        ?>
                                            <img src="<?php echo base_url() ?>assets/img/check.png" title="Ad. Estoque" />
                                    <?php
                                        }
                                    }
                                    ?>


                                </td>
                                <?php
                                    $pedidocompra = $this->pedidocompra_model->getInsumosByPedidoComprasItens($r->idPedidoCompraItens); 
                                    $estoque2 = $this->pedidocompra_model->getRelatorioPorInsumoEmpresa($pedidocompra->idInsumos,$pedidocompra->idOs);
                                ?>
                                <td><input class="span6" onclick="this.select();" type="text" style="font-size: 10px;" name="qtdrecebida[]" value="<?php if ($r->qtdrecebida) {
                                                                                                                                                        echo $r->qtdrecebida;
                                                                                                                                                    } else {
                                                                                                                                                        echo $r->quantidade;
                                                                                                                                                    } ?>">
                                                                                                                                                    <?php if(!empty($estoque2)){ ?>
                                                                                                                                                        - <a style="position: absolute;" href="#modal-estoque-<?php echo $r->idPedidoCompraItens; ?>" style="margin-right: 1%" role="button" data-toggle="modal" class="btn tip-top" ><i class="icon-eye-open"></i></a></td>
                                                                                                                                                        <?php 
                                                                                                                                                    } ?>
                                                                                                                                                    
                                <td>
                                
                                    <!--
			            <input style="font-size: 10px;" class="span12" onclick="this.select();" onKeyPress="FormataValor2(this,event,10,4);" type="text" id="valor_unitario<?php echo $contador; ?>"  name="valor_unitario[]" value="<?php echo number_format($r->valor_unitario, 4, ",", "."); ?>"  onKeyUp="calculaSubTotal(<?php echo $contador; ?>);"> -->
                                    <input <?php if($r->etapa >= 3){echo 'readonly';} ?> style="font-size: 10px;" class="span12" onclick="this.select();" type="text" onkeypress="alterarStatus(<?php echo $contador; ?>)" id="valor_unitario<?php echo $contador; ?>" name="valor_unitario[]" 'onKeyPress="FormataValor2(this,event,10,3);"
                                value="<?php echo number_format($r->valor_unitario, 3, ",", "."); ?>"
                                onKeyUp="calculaSubTotal(<?php echo $contador; ?>);">
                        </td>
                        <td>
                            <input style="font-size: 10px;" class="span12" onclick="this.select();" type="text"
                                id="ipi_valor<?php echo $contador; ?>" onKeyPress="FormataValor2(this,event,10,2);"
                                name="ipi_valor[]" value="<?php echo number_format($r->ipi_valor, 2, ",", "."); ?>"
                                onKeyUp="calculaSubTotal(<?php echo $contador; ?>);">
                        </td>
                        <td style="text-align: center"> 
                            
                            <input style="font-size: 10px;" class="span12" onclick="this.select();" type="text"
                                id="valor_icms<?php echo $contador; ?>" onKeyPress="FormataValor2(this,event,10,2);"
                                name="valor_icms[]" value="<?php if($r->porcentagem){echo number_format($r->icmsPorcentagem, 2, ",", ".");}else{echo number_format($r->icms, 2, ",", ".");} ?>"
                                >

                                <input type="checkbox" <?php if($r->porcentagem){echo 'checked';}?> id="checkPercentagem<?php echo $contador; ?>" name="checkPercentagem[]" value="<?php echo $r->idPedidoCompraItens; ?>"style="z-index:999"> %
                        </td>
                        <td> <?php



                                ?>
                            <input style="font-size: 10px;" type="text" id="valor_produtos<?php echo $contador; ?>"
                                name="valor_produtos[]"
                                value="<?php echo number_format($r->valor_total, 2, ",", "."); ?>" readonly="true"
                                class=' span12' />

                        </td>

                                <td>

                                    <a href="#modal-nfdata<?php echo $r->idPedidoCompraItens; ?>" style="margin-right: 1%" role="button" data-toggle="modal" class="btn tip-top">
                                        <font size='1'><?php echo $r->notafiscal; ?></font>
                                    </a>



                                    <!--<i class="icon icon-file"></i>-->
                                </td>

                                <div id="modal-usuario<?php echo $r->idPedidoCompraItens; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5 id="myModalLabel">Histórico de Usuario</h5>
                                    </div>
                                    <div class="modal-body">
                                        Informação do usuario que cadastrou e sequencia de alterações realizadas:<br>
                                        <?php echo $r->histo_alteracao; ?>
                                    </div>


                                </div>

                                

                                <?php
                                echo '</tr>';
                                ?>



                            <script type="text/javascript">
                                function alterarStatus(valor){
                                    $("#idStatuscompras"+valor).val(10);
                                }

                            </script>
                            <?php
                        
                            $contador++;
                        }

                            ?>
                            <tr>
                                <input id="idPedidoCompra" type="hidden" name="idPedidoCompra" value="<?php echo $results[0]->idPedidoCompra; ?>" />
                            </tr>

                    </table>
                    <div class="span12" style="padding: 1%; margin-left: 0">

                        <div class="form-actions" align='center'>

                            <button type="submit" name="btnSalvar" value="btnSalvar" class="btn btn-success"><i class="icon-plus icon-white"></i> SALVAR
                                ITENS</button>


                        </div>

                    </div>
                    <?php
                    $idPedidoCompraModal = 0;
                    $contadorOS = 0;
                    foreach ($results as $r) { ?>
                      <?php
                        if ($r->idPedidoCompra != $idPedidoCompraModal || $r->previsao_entrega != $previsaoEntregaModal) {
                            $contadorOS = $contadorOS + 1;
                            $idPedidoCompraModal = $r->idPedidoCompra;
                            $previsaoEntregaModal = $r->previsao_entrega;
                            ?>
                            
                            <div id="modal-fornec-emitente<?php echo $r->idPedidoCompra . $r->previsao_entrega; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h5 id="myModalLabel">Dados Orçamento</h5>                                   
                                    <a 'href="#modal-cadastrarInsumo" role="button" ' data-toggle="modal" onclick="openmodal('<?php echo $r->idPedidoCompra . $r->previsao_entrega; ?>')" class="btn btn-success" style="height: 20px"><i class="icon-plus icon-white"></i> Cadastrar Fornecedor</a>

                                </div>
                                <div class="modal-body">
                                    <div style="size:20px">
                                        <?php
                                        foreach ($results as $rs) {
                                        ?>
                                            <input type="hidden" name="idDistribuir_[]" value="<?php echo $rs->idDistribuir; ?>" />
                                        <?php
                                        }
                                        ?>

                                        <label for="idEmitente" class="control-label">Empresa:</label>
                                        <input id="idPedidoCompra" type="hidden" name="idPedidoCompra" value="<?php echo $r->idPedidoCompra; ?>" />
                                        <?php if (isset($r->idEmitente)) {
                                        ?>
                                            <input id="emitente" onclick="this.select();" class="span12 controls emitente" type="text" name="emitente" value="<?php echo $r->nome; ?>" size='50' />
                                            <input id="emitente_id" type="hidden" name="emitente_id" class="emitente_id" value="<?php echo $r->idEmitente; ?>" />

                                        <?php
                                        } else {
                                        ?>

                                            <input id="emitente" class="span12 emitente controls" type="text" name="emitente" value="" size='50' />
                                            <input id="emitente_id" type="hidden" name="emitente_id" value="" class="emitente_id" />
                                        <?php
                                        }
                                        ?>

                                        <label for="fornecedor" class="control-label">Fornecedor:</label>
                                        <?php if (isset($r->idFornecedores)) {
                                        ?>
                                            <input id="fornecedor-<?php echo $r->idPedidoCompra . $r->previsao_entrega; ?>" onclick="this.select();" class="span12 controls fornecedor" type="text" name="fornecedor" value="<?php echo $r->nomeFornecedor; ?>" size='50' />
                                            <input id="fornecedor_id-<?php echo $r->idPedidoCompra . $r->previsao_entrega; ?>" type="hidden" name="fornecedor_id" class="fornecedor_id" value="<?php echo $r->idFornecedores; ?>" />

                                        <?php
                                        } else {
                                        ?>

                                            <input id="fornecedor-<?php echo $r->idPedidoCompra . $r->previsao_entrega; ?>" class="span12 fornecedor controls" type="text" name="fornecedor" value="" size='50' />
                                            <input id="fornecedor_id-<?php echo $r->idPedidoCompra . $r->previsao_entrega; ?>" type="hidden" name="fornecedor_id" value="" class="fornecedor_id" />

                                        <?php
                                        }
                                        ?>

                                    </div>

                                    <!--
                                    Prazo Entrega:<b><?php echo $r->prazo_entrega; ?></b> dias<br>
                                    Previsão
                                    Entrega:<b><?php if (!empty($r->previsao_entrega)) {
                                                    echo date("d/m/Y", strtotime($r->previsao_entrega));
                                                }; ?></b><br>
                                    Forma de pagamento:<b><?php echo $r->nome_status_cond_pgt; ?></b><br>
                                    Condição de pagamento:<b><?php echo $r->cod_pgto; ?></b><br>

                                    Desconto:<b><?php echo number_format($r->desconto, 2, ",", "."); ?></b><br>
                                    ICMS:<b><?php echo number_format($r->icms, 2, ",", ".");  ?></b><br>
                                    Outros:<b><?php echo number_format($r->outros, 2, ",", ".");  ?></b><br>
                                    Frete:<b><?php echo number_format($r->frete, 2, ",", ".");  ?></b><br>
                                    OBS:<b><?php echo nl2br($r->obscompras); ?></b><br>-->

                                    <table>
                                        <tr>
                                            <td> <input id="idPedidoCompraipi" type="hidden" name="idPedidoCompraipi" value="<?php echo $results[0]->idPedidoCompra; ?>" />
                                                Previsão de entrega:<input size='6' id="previsao_entrega" class=" data" type="text" name="previsao_entrega" value="<?php if (!empty($r->previsao_entrega)) {
                                                                                                                                                                        echo date("d/m/Y", strtotime($r->previsao_entrega));
                                                                                                                                                                    }; ?>" />

                                            </td>
                                            <td>Prazo de entrega:<input size='3' class="span8 form-control" type="text" name="prazo_entrega" value="<?php echo $r->prazo_entrega; ?>">dias</td>
                                            <td>Pagamento:
                                                <select class=" recebe-solici" class=" controls" name="idCondPgto" id="idCondPgto">
                                                    <option value="" selected='selected'></option>
                                                    <?php
                                                    foreach ($dados_statuscondicao as $cond) {
                                                        if ($cond->id_status_cond_pgt == $r->idCondPgto) {
                                                    ?>

                                                            <option selected='selected' value="<?php echo $cond->id_status_cond_pgt; ?>">
                                                                <?php echo $cond->nome_status_cond_pgt; ?></option>

                                                        <?php
                                                        } else {
                                                        ?>

                                                            <option value="<?php echo $cond->id_status_cond_pgt; ?>">
                                                                <?php echo $cond->nome_status_cond_pgt; ?></option>

                                                    <?php
                                                        }
                                                    } ?>


                                                </select>
                                            </td>
                                            <td>Condição de pagamento:
                                                <input class=" form-control" size='50' type="text" name="cod_pgto" value="<?php echo $r->cod_pgto; ?>">
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan='4'><!--
                                                ICMS:
                                                <input class=" form-control" size='7' onKeyPress="FormataValor2(this,event,10,2);" type="text" name="icmsit" id="icmsit<?php echo $contadorOS; ?>" value="<?php echo number_format($r->icms, 2, ",", ".");  ?>">-->
                                                Frete:
                                                <input class=" form-control" size='7' onKeyPress="FormataValor2(this,event,10,2);" type="text" name="freteit" id="freteit<?php echo $contadorOS; ?>" value="<?php echo number_format($r->frete, 2, ",", ".");  ?>">
                                                Desconto:
                                                <input class=" form-control" size='7' onKeyPress="FormataValor2(this,event,10,2);" type="text" name="descontoit" id="descontoit<?php echo $contadorOS; ?>" value="<?php echo number_format($r->desconto, 2, ",", "."); ?>">
                                                Outros:
                                                <input class=" form-control" size='7' onKeyPress="FormataValor2(this,event,10,2);" type="text" name="outrosit" id="outrosit<?php echo $contadorOS; ?>" value="<?php echo number_format($r->outros, 2, ",", ".");  ?>">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='6'>OBS:
                                                <textarea id="obs" rows="5" cols="100" class="" name="obs"><?php echo ($r->obscompras); ?></textarea>
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                        <button type="submit" name="btnAlterar" value="btnAlterar" class="btn btn-danger">Alterar</button>
                                    </div>







                                    <!------------------------------------------------------------>

                                </div>


                            </div>
                    <?php
                        }
                    }
                    ?>
                </form>
            </div>
        </div>

        <div align='right'>
            VALOR DOS PRODUTOS R$:<input name="valor_produtos_" type="text" id="valor_produtos_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0,00" size="12" readonly="true">
        </div>
        <div align='right'>
            IPI R$: <input name="ipi_" type="text" id="ipi_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
        </div>
        <div align='right'>
            DESCONTO R$: <input name="desconto_" type="text" id="desconto_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
        </div>
        <div align='right'>
            OUTROS R$: <input name="outros_" type="text" id="outros_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
        </div>
        <div align='right'>
            FRETE R$: <input name="frete_" type="text" id="frete_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
        </div>
        <div align='right'>
            ICMS R$: <input name="icms_" type="text" id="icms_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
        </div>
        <div align='right'>
            TOTAL R$: <input name="valor_total_" type="text" id="valor_total_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
        </div>








    <?php echo $this->pagination->create_links();
} ?>


    <?php 
    foreach ($results as $r) { ?>
        <div id="modal-estoque-<?php echo $r->idPedidoCompraItens; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <form action="<?php echo base_url() ?>index.php/pcp/reservaritensalmoxarifado" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 id="myModalLabel">Quantidade em Estoque</h5>
                </div>
                <?php
                    $pedidocompra = $this->pedidocompra_model->getInsumosByPedidoComprasItens($r->idPedidoCompraItens); 
                    $estoque2 = $this->pedidocompra_model->getRelatorioPorInsumoEmpresa($pedidocompra->idInsumos,$pedidocompra->idOs);
                ?>
                
                <div class="modal-body">
                    
                        <input type="hidden" name="idprodutocompraitens" id="idprodutocompraitens" value="<?php echo $r->idPedidoCompraItens; ?>">
                        <table class="table table-bordered " id="tbodyEntradaTodos">
                            <thead>
                                <tr>
                                    <th>
                                        Empresa
                                    </th>
                                    <th>
                                        Qtd.
                                    </th>
                                    <th>
                                        Qtd. Reservada
                                    </th>
                                    <th>
                                        Reservar Estq. Qtd.
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($estoque2  as $estq){
                                        echo '<tr>';
                                            echo '<td>';
                                                echo $estq->nome.'<input type="hidden" name="empresa[]" id="empresa[]" value="'.$estq->id.'"><input type="hidden" name="insumo[]" id="insumo[]" value="'.$estq->idInsumos.'">';
                                            echo '</td>';
                                            echo '<td>';
                                                echo $estq->quantidade_total.'<input type="hidden" name="quantidadeTotal[]" id="quantidadeTotal[]" value="'.$estq->quantidade_total.'">';
                                            echo '</td>';
                                            echo '<td>';
                                                echo $estq->quantidade_reservada;
                                            echo '</td>';
                                            echo '<td>';
                                                echo "<input type='text' name='retiradaEstoque[]' id='retiradaEstoque[]'>";
                                            echo '</td>';
                                        echo '</tr>';
                                    } 
                                ?>
                            </tbody>
                        </table>      
                                                          
                    
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button class="btn btn-danger">Salvar</button>
                </div>
                <?php
                foreach ($results as $rsi) {
                ?><!--
                    <input id="idPedidoCompraipi" type="hidden" name="idPedidoCompraipi[]" value="<?php echo $rsi->idPedidoCompra; ?>" /> -->
                    <input id="idDistribuir" type="hidden" name="idDistribuir[]" value="<?php echo $rsi->idDistribuir; ?>" />
                <?php
                }
                ?>
            </form>

        </div><?php 
     }?>

    <div id="modal-imprimiritem" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?php echo base_url() ?>index.php/pcp/imprimiritem" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel">Marcar itens para imprimir</h5>
            </div>
            <div class="modal-body">
                <?php
                $contadoripi = 0;
                foreach ($results as $rsi) {
                    $color = '';
                ?>
                    <input id="idPedidoCompraipi" type="hidden" name="idPedidoCompraipi[]" value="<?php echo $rsi->idPedidoCompra; ?>" />
                    <input id="idDistribuir" type="hidden" name="idDistribuir[]" value="<?php echo $rsi->idDistribuir; ?>" />
                <?php
                }
                ?>

                <br><br>
                <b>Qtd ***** Descrição</b><br>
                <?php
                $contadoripi = 0;
                foreach ($results as $novo) {
                    $color = '';
                ?>

                    <input name="idPedidoCompraItensipi[]" type="checkbox" value="<?php echo $novo->idPedidoCompraItens; ?>" checked>

                    <?php echo $novo->quantidade; ?> ***** <?php echo $novo->descricaoInsumo . " " . $novo->dimensoes; ?>
                    <br>
                <?php
                }
                ?>

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-danger">Imprimir</button>
            </div>
        </form>
    </div>



    <div id="modal-ipi" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?php echo base_url() ?>index.php/pcp/editar_ipi" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel">Informar o valor nos campos desejados e selecionar todos que irão alterar:</h5>
            </div>
            <div class="modal-body">

                Valor IPI%:<input id="valoripi" onKeyPress="FormataValor2(this,event,10,2);" onclick="this.select();" type="text" name="valoripi" value="" />% ex.:5,00<br><br>
                Status Compra:<select class="recebe-solici" class="controls" name="idStatuscompras2" id="idStatuscompras2">
                    <option value=''></option>
                    <?php foreach ($dados_statuscompra as $so) { ?>

                        <option value="<?php echo $so->idStatuscompras; ?>"><?php echo $so->nomeStatus; ?></option>
                    <?php } ?>


                </select> <br><br>


                <!--<select class="recebe-solici" class="controls" name="idgrupo" id="idgrupo">
							<option value='0'></option> 
							<?php foreach ($dados_statusgrupo as $so) { ?>
                       
                        <option value="<?php echo $so->idgrupo; ?>" ><?php echo $so->nomegrupo; ?></option>
                        <?php } ?>
                       
					    
                            </select>-->
                Data entregue:
                <input id="dataentregue2" class="data" type="text" name="dataentregue2" value="" style="font-size: 10px;" size='17' /><br><br>


                N° NF:
                <input id="nNotaFiscal2" type="text" name="nNotaFiscal2" value="" style="font-size: 10px;" size='17' />


                <br><br>
                <b>Qtd ***** Descrição</b><br>
                <?php
                $contadoripi = 0;
                foreach ($results as $novo) {
                    $color = '';

                ?>

                    <input id="idDistribuir_ipi" type="hidden" name="idDistribuir_ipi[]" value="<?php echo $novo->idDistribuir; ?>" />
                    <input name="idPedidoCompraItensipi[]" type="checkbox" value="<?php echo $novo->idPedidoCompraItens; ?>" checked>

                    <?php echo $novo->quantidade; ?> ***** <?php echo $novo->descricaoInsumo . " " . $novo->dimensoes; ?>
                    <br>
                <?php
                }
                ?>


                <h5 style="text-align: center">Deseja alterar os itens selecionados para os valores informado?</h5>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-danger">Alterar</button>
            </div>
        </form>
    </div>
    <!--
    <div id="modal-dadosnotafiscal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="<?php echo base_url() ?>index.php/suprimentos/editar_notafiscal" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel">Informar o valor nos campos e selecionar todos que irão alterar:</h5>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td> <input id="idPedidoCompraipi" type="hidden" name="idPedidoCompraipi"
                                value="<?php echo $results[0]->idPedidoCompra; ?>" />
                            Previsão de entrega:<input size='6' id="previsao_entrega" class=" data" type="text"
                                name="previsao_entrega" value="" />

                        </td>
                        <td>Prazo de entrega:<input size='3' class="span8 form-control" type="text" name="prazo_entrega"
                                value="">dias</td>
                        <td>Pagamento:
                            <select class=" recebe-solici" class=" controls" name="idCondPgto" id="idCondPgto">
                                <option value="" selected='selected'></option>
                                <?php foreach ($dados_statuscondicao as $cond) {
                                    if (isset($results[0]->idCondPgto)) {

                                ?>

                                <option value="<?php echo $cond->id_status_cond_pgt; ?>">
                                    <?php echo $cond->nome_status_cond_pgt; ?></option>

                                <?php
                                    } else {
                                ?>

                                <option value="<?php echo $cond->id_status_cond_pgt; ?>">
                                    <?php echo $cond->nome_status_cond_pgt; ?></option>

                                <?php
                                    }
                                } ?>


                            </select>
                        </td>
                        <td>Condição de pagamento:
                            <input class=" form-control" size='50' type="text" name="cod_pgto" value="">
                        </td>

                    </tr>
                    <tr>
                        <td colspan='4'>
							ICMS:
                            <input class=" form-control" size='7' onKeyPress="FormataValor2(this,event,10,2);"
                                type="text" name="icmsit" id="icmsit" value="">Frete:
                            <input class="form-control freteit" size='7' onKeyPress="FormataValor2(this,event,10,2);"
                                type="text" name="freteit" id="freteit" value="">Desconto:
                            <input class=" form-control" size='7' onKeyPress="FormataValor2(this,event,10,2);"
                                type="text" name="descontoit" id="descontoit" value="">
								Outros:
                            	<input class=" form-control" size='7' onKeyPress="FormataValor2(this,event,10,2);" type="text" name="outrosit" id="outrosit" value="">
								Data NF:
								<input id="datanf" size='7' class="data" type="text" name="datanf" value="" style="font-size: 10px;" size='17' />Nº
                            NF:<input id="nf" size='7' type="text" name="nf" value="" style="font-size: 10px;"
                                size='17' />
                        </td>
                    </tr>
                    <tr>
                        <td colspan='6'>OBS:
                            <textarea id="obs" rows="5" cols="100" class="" name="obs"></textarea>
                        </td>
                    </tr>


                </table>




                <br><br>
                <b>Qtd ***** Descrição</b><br>
                <?php
                $contadoripi = 0;
                foreach ($results as $novo) {
                    $color = '';


                ?>

                <input id="idCotacaoItens" type="hidden" name="idCotacaoItens2[]" value="<?php echo $novo->idCotacaoItens; ?>" />

                <input name="idPedidoCompraItensipi[]" type="checkbox" value="<?php echo $novo->idPedidoCompraItens; ?>"
                    checked>

                <?php echo $novo->quantidade; ?> *****
                <?php echo $novo->descricaoInsumo . " " . $novo->dimensoes; ?>
                <br>
                <?php
                }
                ?>


            <h5 style="text-align: center">Deseja alterar os itens selecionados para os valores informado?</h5>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-danger">Alterar</button>
            </div>
        </form>
    </div>-->
    <div id="modal-editar_1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?php echo base_url() ?>index.php/pcp/editar_1" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel">Liberar item para editar quantidade</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_item_pc1" name="id_item_pc1" value="" />

                <input id="idPedidoCompra" type="hidden" name="idPedidoCompra" value="<?php echo $results[0]->idPedidoCompra; ?>" />
                <h5 style="text-align: center">Deseja realmente liberar este item para edição?</h5>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-danger">Liberar</button>
            </div>
        </form>
    </div>



    <?php
    foreach ($results as $r) {
    ?>
        <div id="modal-nfdata<?php echo $r->idPedidoCompraItens; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel">Dados NF Status</h5>
            </div>
            <div class="modal-body">

                <?php


                ?>
                <form action="<?php echo base_url() ?>index.php/pcp/editar_ipi" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div style="float:right; size:20px">

                        <font size="3">
                            <?php
                            foreach ($results as $rs) {
                            ?>
                                <input type="hidden" name="idDistribuir_[]" value="<?php echo $rs->idDistribuir; ?>" />
                            <?php
                            }
                            ?>

                            <input id="idPedidoCompraipi" type="hidden" name="idPedidoCompraipi" value="<?php echo $r->idPedidoCompra; ?>" />
                            <input name="idPedidoCompraItensipi[]" type="hidden" value="<?php echo $r->idPedidoCompraItens; ?>" checked />
                            Nº NF:
                            <input class="span8" type="text" style="font-size: 22px;" name="nNotaFiscal2" value="<?php echo $r->notafiscal; ?>" />
                            <br>
                            Data
                            NF:
                            <input class="data" type="text" style="font-size: 18px;" size=13 name="dataentregue2" value="<?php if (!empty($r->datastatusentregue)) {
                                                                                                                                echo date("d/m/Y", strtotime($r->datastatusentregue));
                                                                                                                            }; ?>" />


                        </font>

                    </div>


                    Prazo Entrega:<b><?php echo $r->prazo_entrega; ?></b> dias<br>
                    Previsão
                    Entrega:<b><?php if (!empty($r->previsao_entrega)) {
                                    echo date("d/m/Y", strtotime($r->previsao_entrega));
                                }; ?></b><br>
                    Forma de pagamento:<b><?php echo $r->nome_status_cond_pgt; ?></b><br>
                    Condição de pagamento:<b><?php echo $r->cod_pgto; ?></b><br>

                    Desconto:<b><?php echo number_format($r->desconto, 2, ",", "."); ?></b><br>
                    ICMS:<b><?php echo number_format($r->icms, 2, ",", ".");  ?></b><br>
                    Outros:<b><?php echo number_format($r->outros, 2, ",", ".");  ?></b><br>
                    Frete:<b><?php echo number_format($r->frete, 2, ",", ".");  ?></b><br>
                    OBS:<b><?php echo nl2br($r->obscompras); ?></b><br>

                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        <button class="btn btn-danger">Alterar</button>
                    </div>
                </form>
            </div>


        </div>
    <?php
    }
    ?>





    <div id="modal-editar_0" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?php echo base_url() ?>index.php/pcp/editar_0" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel">Travar item para edição de quantidade</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_item_pc2" name="id_item_pc2" value="" />
                <input id="idPedidoCompra" type="hidden" name="idPedidoCompra" value="<?php echo $results[0]->idPedidoCompra; ?>" />
                <h5 style="text-align: center">Deseja travar edição?</h5>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-danger">Confirmar</button>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        var contador_global_autocomplete = <?php echo $contador; ?>;
        var contador_os = <?php echo $contadorOS; ?>;

        var contador_local_autocomplete = contador_global_autocomplete;

        //alert('contglobal'+contador_global_autocomplete);
    </script>


    <div id="modalsaida2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?php echo base_url(); ?>index.php/estoque/cadastrarestoque" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">SGI - Entrada Item para Estoque</h3>
            </div>
            <div class="modal-body">

                <input type="hidden" id="compra" name="compra" value="1" />
                <input type="hidden" id="idInsumos_e1" name="idInsumos_e1" value="" />
                <input type="hidden" id="idPedidoCompra_e1" name="idPedidoCompra_e1" value="" />
                <input type="hidden" id="idPedidoCompraItens_e1" name="idPedidoCompraItens_e1" value="" />
                <input type="hidden" id="quantidade_e1" name="quantidade_e1" value="" />
                <input type="hidden" id="dimensoes_e1" name="dimensoes_e1" value="" />
                <input type="hidden" id="valor_unitario_e1" name="valor_unitario_e1" value="" />
                <input type="hidden" id="idEmitente_e1" name="idEmitente_e1" value="" />
                Você confirma dar entrada no estoque desse item?
            </div>



            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
                <button class="btn btn-success" id="saida3">Cadastrar Estoque</button>
            </div>
        </form>
    </div>

    <div id="modalCadastrarFornecedor" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Cadastrar Fornecedor</h3>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span12">
                    <label for="nomeFornecedor" class="control-label">Nome<span class="required">*</span></label>
                    <input class="span12" id="nomeFornecedor" type="text" name="nomeFornecedor" id="nomeFornecedor"value="<?php echo set_value('nomeFornecedor'); ?>" />
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span6">
                    <label for="documento" class="control-label">CPF/CNPJ<span class="required">*</span></label>
                    <input id="documento" class="span12" type="text" name="documento" id="documento" value="<?php echo set_value('documento'); ?> " />
                </div>
                <div class="span3">
                    <label for="telefone" class="control-label">Telefone<span class="required">*</span></label>
                    <input class="span12" id="telefone" type="text" name="telefone" id="telefone" value="<?php echo set_value('telefone'); ?>" />
                </div>
                <div class="span3">
                    <label for="celular" class="control-label">Celular</label>
                    <input class="span12" id="celular" type="text" name="celular" id="celular" value="<?php echo set_value('celular'); ?>" />
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span12">
                    <label for="email" class="control-label">Email<span class="required">*</span></label>
                    <input class="span12" id="email" type="text" name="email" id="email"  value="<?php echo set_value('email'); ?>" />
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span4">
                    <label for="cep" class="control-label">CEP<span class="required">*</span></label>
                    <input class="span12" id="cep" type="text" name="cep" id="cep" value="<?php echo set_value('cep'); ?>" />
                </div>
                <div class="span2">
                    <label for="estado" class="control-label">Estado<span class="required">*</span></label>
                    <select id="estado" name="estado" class="span12" >
                        <option value=""></option>
                        <option value="AC" <?php if (set_value('estado') == 'AC') {
                                                echo "selected='selected'";
                                            } ?>>Acre</option>
                        <option value="AL" <?php if (set_value('estado') == 'AL') {
                                                echo "selected='selected'";
                                            } ?>>Alagoas</option>
                        <option value="AP" <?php if (set_value('estado') == 'AP') {
                                                echo "selected='selected'";
                                            } ?>>Amapá</option>
                        <option value="AM" <?php if (set_value('estado') == 'AM') {
                                                echo "selected='selected'";
                                            } ?>>Amazonas</option>
                        <option value="BA" <?php if (set_value('estado') == 'BA') {
                                                echo "selected='selected'";
                                            } ?>>Bahia</option>
                        <option value="CE" <?php if (set_value('estado') == 'CE') {
                                                echo "selected='selected'";
                                            } ?>>Ceará</option>
                        <option value="DF" <?php if (set_value('estado') == 'DF') {
                                                echo "selected='selected'";
                                            } ?>>Distrito Federal</option>
                        <option value="ES" <?php if (set_value('estado') == 'ES') {
                                                echo "selected='selected'";
                                            } ?>>Espírito Santo</option>
                        <option value="GO" <?php if (set_value('estado') == 'GO') {
                                                echo "selected='selected'";
                                            } ?>>Goiás</option>
                        <option value="MA" <?php if (set_value('estado') == 'MA') {
                                                echo "selected='selected'";
                                            } ?>>Maranhão</option>
                        <option value="MT" <?php if (set_value('estado') == 'MT') {
                                                echo "selected='selected'";
                                            } ?>>Mato Grosso</option>
                        <option value="MS" <?php if (set_value('estado') == 'MS') {
                                                echo "selected='selected'";
                                            } ?>>Mato Grosso do Sul</option>
                        <option value="MG" <?php if (set_value('estado') == 'MG') {
                                                echo "selected='selected'";
                                            } ?>>Minas Gerais</option>
                        <option value="PA" <?php if (set_value('estado') == 'PA') {
                                                echo "selected='selected'";
                                            } ?>>Pará</option>
                        <option value="PB" <?php if (set_value('estado') == 'PB') {
                                                echo "selected='selected'";
                                            } ?>>Paraíba</option>
                        <option value="PR" <?php if (set_value('estado') == 'PR') {
                                                echo "selected='selected'";
                                            } ?>>Paraná</option>
                        <option value="PE" <?php if (set_value('estado') == 'PE') {
                                                echo "selected='selected'";
                                            } ?>>Pernambuco</option>
                        <option value="PI" <?php if (set_value('estado') == 'PI') {
                                                echo "selected='selected'";
                                            } ?>>Piauí</option>
                        <option value="RJ" <?php if (set_value('estado') == 'RJ') {
                                                echo "selected='selected'";
                                            } ?>>Rio de Janeiro</option>
                        <option value="RN" <?php if (set_value('estado') == 'RN') {
                                                echo "selected='selected'";
                                            } ?>>Rio Grande do Norte</option>
                        <option value="RS" <?php if (set_value('estado') == 'RS') {
                                                echo "selected='selected'";
                                            } ?>>Rio Grande do Sul</option>
                        <option value="RO" <?php if (set_value('estado') == 'RO') {
                                                echo "selected='selected'";
                                            } ?>>Rondônia</option>
                        <option value="RR" <?php if (set_value('estado') == 'RR') {
                                                echo "selected='selected'";
                                            } ?>>Roraima</option>
                        <option value="SC" <?php if (set_value('estado') == 'SC') {
                                                echo "selected='selected'";
                                            } ?>>Santa Catarina</option>
                        <option value="SP" <?php if (set_value('estado') == 'SP') {
                                                echo "selected='selected'";
                                            } ?>>São Paulo</option>
                        <option value="SE" <?php if (set_value('estado') == 'SE') {
                                                echo "selected='selected'";
                                            } ?>>Sergipe</option>
                        <option value="TO" <?php if (set_value('estado') == 'TO') {
                                                echo "selected='selected'";
                                            } ?>>Tocantins</option>
                        <option value="EX" <?php if (set_value('estado') == 'EX') {
                                                echo "selected='selected'";
                                            } ?>>Estrangeiro</option>
                    </select>
                </div>
                <div class="span6">
                    <label for="cidade" class="control-label">Cidade</label>
                    <input class="span12" id="cidade" type="text" name="cidade" id="cidade" value="<?php echo set_value('cidade'); ?>" />
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span4">
                    <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                    <input class="span12" id="bairro" type="text" name="bairro" id="bairro" value="<?php echo set_value('bairro'); ?>" />
                </div>                     
                <div class="span6">
                    <label for="rua" class="control-label">Rua<span class="required">*</span></label>
                    <input class="span12" id="rua" type="text" name="rua" id="rua" value="<?php echo set_value('rua'); ?>" />
                </div>
                <div class="span2">
                    <label for="numero" class="control-label">Número<span class="required">*</span></label>
                    <input class="span12" id="numero" type="text" name="numero" id="numero" value="<?php echo set_value('numero'); ?>" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <a 'href="#modal-cadastrarInsumo" role="button"  data-toggle="modal" onclick="cadastrarFornecedor()" class="btn btn-success" style="height: 20px"><i class="icon-plus icon-white"></i> Confirmado</a>
        </div>
    </div>

    <script type="text/javascript">
        

        var globalVariable = "";

        function cadastrarFornecedor() {
            var nomeFornecedor = document.querySelector('#nomeFornecedor').value;
            var documento = document.querySelector('#documento').value;
            var telefone = document.querySelector('#telefone').value;
            var celular = document.querySelector('#celular').value;
            var email = document.querySelector('#email').value;
            var estado = document.querySelector('#estado').value;
            var cep = document.querySelector('#cep').value;
            var cidade = document.querySelector('#cidade').value;
            var bairro = document.querySelector('#bairro').value;
            var rua = document.querySelector('#rua').value;
            var numero = document.querySelector('#numero').value;
            
            if(documento == "" || documento == null || 
            nomeFornecedor == "" || nomeFornecedor == null || 
            cep == "" || cep == null || 
            estado == "" || estado == null || 
            cidade == "" || cidade == null || 
            bairro == "" || bairro == null || 
            rua == "" || rua == null || 
            numero == "" || numero == null){
                alert("Verifique os dados.");
                return;
            }
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/fornecedores/cadastrarFornecedor",
                type: 'POST',
                dataType: 'json',
                data: {
                    nomeFornecedor: nomeFornecedor,
                    documento: documento,
                    telefone: telefone,
                    celular: celular,
                    email:email,
                    estado:estado,
                    cep:cep,
                    cidade:cidade,
                    bairro:bairro,
                    rua:rua,
                    numero:numero
                },
                success: function(data) {
                    alert(data.msg);
                    if(data.result){
                        document.querySelector("#fornecedor-"+globalVariable).value = nomeFornecedor.toUpperCase();
                        document.querySelector("#fornecedor_id-"+globalVariable).value = data.idFornecedor
                        $('#modalCadastrarFornecedor').modal('hide');	
                        $('#modal-fornec-emitente' + globalVariable).modal('show');				
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

        function openmodal(id) {
            globalVariable = id;
            $('#modal-fornec-emitente' + id).modal('hide');
            $('#modalCadastrarFornecedor').modal('show');
        }


        $(document).ready(function() {




            $(document).on('click', 'a', function(event) {

                var idInsumos_e = $(this).attr('idInsumos_e');
                var idPedidoCompra_e = $(this).attr('idPedidoCompra_e');
                var idPedidoCompraItens_e = $(this).attr('idPedidoCompraItens_e');
                var quantidade_e = $(this).attr('quantidade_e');
                var dimensoes_e = $(this).attr('dimensoes_e');
                var valor_unitario_e = $(this).attr('valor_unitario_e');
                var idEmitente_e = $(this).attr('idEmitente_e');
                $('#idInsumos_e1').val(idInsumos_e);
                $('#idPedidoCompra_e1').val(idPedidoCompra_e);
                $('#idPedidoCompraItens_e1').val(idPedidoCompraItens_e);
                $('#quantidade_e1').val(quantidade_e);
                $('#dimensoes_e1').val(dimensoes_e);
                $('#valor_unitario_e1').val(valor_unitario_e);
                $('#idEmitente_e1').val(idEmitente_e);

            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            jQuery(".data").mask("99/99/9999");
        });


        $(function() {
            $(document).on('click', 'input[type=text][id=example1]', function() {
                this.select();
            });
        });


        $(document).on('click', 'a', function(event) {

            var id_disti1 = $(this).attr('id_disti1');
            $('#id_item_pc1').val(id_disti1);

        });

        $(document).on('click', 'a', function(event) {

            var id_disti2 = $(this).attr('id_disti2');
            $('#id_item_pc2').val(id_disti2);

        });

        $(".emitente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/suprimentos/autoCompleteEmitente",
            minLength: 1,
            select: function(event, ui) {

                $(".emitente_id").val(ui.item.id);



            }
        });

        $(".fornecedor").autocomplete({
            source: "<?php echo base_url(); ?>index.php/suprimentos/autoCompletefornecedor",
            minLength: 1,
            select: function(event, ui) {

                $(".fornecedor_id").val(ui.item.id);



            }
        });

        /*$(document).ready(function(){

              $("#cliente").autocomplete({
                    source: "<?php echo base_url(); ?>index.php/os/autoCompleteInsumo",
                    minLength: 1,
                    select: function( event, ui ) {

                         $("#idInsumos").val(ui.item.id);
                        
        					//getValor(ui.item.id);

                    }
              });
          
             
           
        });*/

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

        function calculaSubTotal(x) {
            //alert('contunit'+contador_global_autocomplete);
            var qtd = 0;
            var valorunit = 0;

            var valor_itemprodutos = 0;
            var valor_tot_pedido = 0;
            var valor_tot_ipi = 0;
            var total_icms = 0;

            for (i = 0; i < contador_global_autocomplete; i++) {


                var valorunit = $('#valor_unitario' + i).val();
                valorunit = valorunit.toString().replace(".", "");
                valorunit = valorunit.toString().replace(",", ".");

                valorunit = parseFloat(valorunit);

                var ipivalor = $('#ipi_valor' + i).val();
                ipivalor = ipivalor.toString().replace(".", "");
                ipivalor = ipivalor.toString().replace(",", ".");

                ipivalor = parseFloat(ipivalor);

                var valor_icms = $('#valor_icms' + i).val();
                valor_icms = valor_icms.toString().replace(".", "");
                valor_icms = valor_icms.toString().replace(",", ".");

                valor_icms = parseFloat(valor_icms);



                /*valorunit=	valorunit.replace(/\./g, "");
                valorunit=	valorunit.replace(/,/g, ".");*/


                var qtd = $('#quantidade' + i).val();
                //alert(qtd);
                var calc_ipi = valorunit * qtd * (ipivalor / 100);
                //var total = ((valorunit * qtd) - desconto) *  valoripi / 100;
                var total1 = (valorunit * qtd) + calc_ipi;
                var total2 = (valorunit * qtd);
                total_icms = total_icms + valor_icms;


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

                /*
                var icms_ = $('#icmsit' + i2).val();
                icms_ = icms_.toString().replace(".", "");
                icms_ = icms_.toString().replace(",", ".");
                icms_ = parseFloat(icms_);
                icms = icms + icms_;*/

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
            $('#icms_').val(retorna_formatado(total_icms));
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
    </script><!--
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> -->

    <script type="text/javascript">
        $(document).ready(function() {


            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#estado").val("");

            }

            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#estado").val("...");


                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#estado").val(dados.uf);

                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });
    </script>