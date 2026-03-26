<?php
/*
$dat = $this->input->get('dataInicial');
if($dat == '')
        {
            $dataimpri =  date("d/m/Y", strtotime($result[0]->datacotacao));
            
        }
        else{
            
            $dataimpri = $dat;
        }
    */
?>

<head>
    <title>SGI</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body style="background-color: transparent">
    <style type="text/css">
        table.comBordas {
            border: 0px solid White;
        }
        table.comBordas td {
            border: 1px solid grey;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }
        table.comBordas22 {
            border: 0px solid White;
        }
        table.comBordas22 tr {
            border: 1px solid grey;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }
        table.comBordastitu td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }
        table.comBordas2 {
            border: 0px solid White;
        }
        table.comBordas2 td {
            border: 0px solid grey;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }
    </style>

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">

                <div class="widget-box">
                    <div class="widget-content nopadding">

                        <table width='100%' align='center' border='0' class='comBordas'>
                            <tr>
                                <td style="text-align: center; width: 20%" rowspan='3'><strong><img src=" <?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo base_url() . $dados_emitente->url_logo . $dados_emitente->imagem; } else { echo base_url() . $result[0]->url_logo . $result[0]->imagem; }  ?> " width='55%' height='30%'=></strong></td>
                                <td align='center'>
                                    <table width='100%' border='0' class='comBordas2'>
                                        <tr>
                                            <td colspan='2' align='center' height='50'>
                                                <b><font size='4'><?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo $dados_emitente->nome; } else { echo $result[0]->nome; }  ?></font></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <font size='1'><b>CNPJ: </b><?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo $dados_emitente->cnpj; } else { echo $result[0]->cnpj; } ?></font>
                                                <br>
                                                <font size='1'><b>ENDEREÇO:</b> <?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo $dados_emitente->rua; } else { echo $result[0]->rua; } ?> Nº: <?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo $dados_emitente->numero; } else { echo $result[0]->numero; } ?></font>
                                                <br>
                                                <font size='1'><b>CIDADE: </b><?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo $dados_emitente->cidade; } else { echo $result[0]->cidade; } ?> </font>
                                                <br>
                                                <font size='1'><b>EMAIL:</b> <?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo $dados_emitente->email_compras; } else { echo $result[0]->email_compras; } ?></font>
                                            </td>
                                            <td>
                                                <font size='1'><b>INSCRIÇÃO ESTADUAL:</b> <?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo $dados_emitente->ie; } else { echo $result[0]->ie; } ?></font> </br>
                                                <font size='1'><b>BAIRRO:</b> <?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo $dados_emitente->bairro; } else { echo $result[0]->bairro; } ?></font>
                                                <br>
                                                <font size='1'><b>ESTADO:</b> <?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo $dados_emitente->uf; } else { echo $result[0]->uf; } ?></font>
                                                <br>
                                                <font size='1'><b>TELEFONE:</b> <?php if (!isset($result[0]->imagem) || is_null($result[0]->imagem)) { echo $dados_emitente->telefone; } else { echo $result[0]->telefone; } ?></font>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="text-align: center; width: 20%" rowspan='3'>
                                    <table align='center' width='100%' border='0' class='comBordas2'>
                                        <tr>
                                            <?php
                                            if (!empty($result)) {
                                                if ($result[0]->idStatuscompras == 2) {
                                            ?>
                                                    <td align='center'>
                                                        <font size='1'>
                                                            Cotação:
                                                            <b><?php echo $result[0]->idPedidoCotacao; ?></b>
                                                        </font>
                                                    </td>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td align='center'>
                                                <font size='1'>
                                                    ORDEM COMPRA:
                                                    <?php
                                                    if (!empty($result)) {
                                                    ?>
                                                        <b><?php echo $result[0]->idPedidoCompra; ?></b>
                                                    <?php
                                                    }
                                                    ?>
                                                </font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align='center'>
                                                <font size='1'>Data:
                                                    <b>
                                                        <?php
                                                        if (!empty($result)) {
                                                            echo date("d/m/Y", strtotime($result[0]->data_cadastro));
                                                        }
                                                        ?>
                                                    </b>
                                                </font>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <div align='center'>
                            <h5>DADOS DO FORNECEDOR</h5>
                        </div>
                        <div>
                            <table align='center' width='100%' border='0' class='comBordas22'>
                                <tr>
                                    <td width='40%'>
                                        NOME/RAZÃO SOCIAL:<br>
                                        <b> <?php echo $result[0]->nomeFornecedor; ?> </b>
                                    </td>
                                    <td width='40%'>
                                        CNPJ:<BR>
                                        <b> <?php echo $result[0]->documento; ?> </b>
                                    </td>
                                    <td>
                                        TELEFONE:<BR>
                                        <b> <?php echo $result[0]->telforne; ?> </b>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <table align='center' width='100%' border='0' class='comBordas22'>
                                <tr>
                                    <td width='40%'>
                                        ENDEREÇO:<br>
                                        <b><?php echo $result[0]->ruaforne; ?> </b>
                                    </td>
                                    <td>
                                        BAIRRO:<BR>
                                        <b> <?php echo $result[0]->bforne; ?> </b>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div align='center'>
                            <h5>DISCRIMINAÇÃO DOS PRODUTOS</h5>
                            <br>
                        </div>
                        <table align='center' width='100%' border='0' class='comBordas'>
                            <thead>
                                <tr>
                                    <td> <b>OS</b></td>
                                    <td><b>STATUS OS</b></td>
                                    <td><b>UNID. EXEC.</b></td>
                                    <td><b>PRODUTO</b></td>
                                    <td><b>STATUS</b></td>
                                    <td><b>QTD.</b></td>
                                    <td><b>UNIT.</b></td>
                                    <td><b>TOTAL</b></td>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $produtos = 0;
                                $valorip = 0;
                                
                                foreach ($result as $r) {
                                ?>
                                    <tr>
                                        <td><?php echo $r->idOs; ?></td>
                                        <td><?php echo $r->nomeStatusOs; ?></td>
                                        <td><?php echo $r->status_execucao; ?></td>
                                        <td>
                                            <font size='1'><?php 
                                            $html = $r->descricaoInsumo;
                                            if(!empty($r->dimensoes)){ $html.=" ".$r->dimensoes; } 
                                            if(!empty($r->comprimento)){ $html.=" ".$r->comprimento." mm"; } 
                                            if(!empty($r->volume)){ $html.=" ".$r->volume." ml"; } 
                                            if(!empty($r->peso)){ $html.=" ".$r->peso." g"; } 
                                            
                                            if(!empty($r->dimensoesL)){ $html .= " Largura: ".$r->dimensoesL." mm"; }
                                            if(!empty($r->dimensoesC)){ $html .= " Comp.: ".$r->dimensoesC." mm"; }
                                            if(!empty($r->dimensoesA)){ $html .= " Altura: ".$r->dimensoesA." mm"; }
                                            echo $html; ?> </font>
                                        </td>
                                        <td><?php echo $r->nomeStatus; ?></td>
                                        <td><?php echo $r->quantidade; ?></td>
                                        <td><?php echo number_format($r->valor_unitario, 2, ",", "."); ?></td>
                                        <td><?php echo number_format($r->valor_total, 2, ",", "."); ?></td>
                                    </tr>

                                <?php
                                    // SOMA DOS PRODUTOS
                                    // AQUI NÃO SOMAMOS O DESCONTO (ele vem do cabeçalho)
                                    $v_unitario = floatval($r->valor_unitario);
                                    $v_qtd = floatval($r->quantidade);
                                    
                                    // Cálculo do IPI
                                    if (isset($r->ipi_valor)) {
                                        $v_ipi_percent = floatval($r->ipi_valor);
                                        $calc_ipi = $v_unitario * $v_qtd * ($v_ipi_percent / 100);
                                    } else {
                                        $calc_ipi = 0;
                                    }
                                    
                                    // Somatórios
                                    $produtos += ($v_unitario * $v_qtd);
                                    $valorip += $calc_ipi;
                                } 
                                ?>
                                <tr></tr>
                            </tbody>
                        </table>

                        <?php
                        // CÁLCULO FINAL CORRIGIDO
                        
                        // Pegamos o DESCONTO APENAS UMA VEZ (do primeiro registro/cabeçalho)
                        // Assim ele não é multiplicado pela quantidade de itens
                        $v_desconto = isset($result[0]->desconto) ? floatval($result[0]->desconto) : 0;
                        
                        $v_frete = isset($result[0]->frete) ? floatval($result[0]->frete) : 0;
                        $v_outros = isset($result[0]->outros) ? floatval($result[0]->outros) : 0;
                        
                        // FÓRMULA FINAL: (Produtos - Desconto) + IPI + Frete + Outros (Sem ICMS)
                        $total = ($produtos - $v_desconto) + $valorip + $v_frete + $v_outros;
                        ?>

                    </div>
                </div>
            </div>

            <div class='span12'>
                <div class='span5'><br>
                    <font size='1'>
                        <b>Observações:</b>
                        <?php echo nl2br($result[0]->obscompras); ?>

                        <br><b>Previsão de Entrega:</b>
                        <?php echo $result[0]->prazo_entrega; ?> dias
                        <br><b>Condição de Pagamento:</b>
                        <?php echo $result[0]->cod_pgto; ?>
                    </font>
                </div>

                <div class='span7'>
                    <br>
                    <font size='1'>
                        <div align='right'>
                            <b> VALOR DOS PRODUTOS R$:</b><input name="valor_produtos_" type="text" id="valor_produtos_" style="font-size: 10px; background-color:#E3EEF2; border: 0px solid #000000;" value="<?php echo number_format($produtos, 2, ",", "."); ?>" size="12" readonly="true">
                        </div>
                        <div align='right'>
                            <b>IPI R$: </b><input name="ipi_" type="text" id="ipi_" style="font-family: Arial; font-size: 10px; background-color:#E3EEF2; border: 0px solid #000000;" value="<?php echo number_format($valorip, 2, ",", "."); ?>" size="12" readonly="true">
                        </div>
                        <div align='right'>
                            <b>DESCONTO R$:</b> <input name="desconto_" type="text" id="desconto_" style="font-family: Arial; font-size: 10px; background-color:#E3EEF2; border: 0px solid #000000;" value="<?php echo number_format($v_desconto, 2, ",", "."); ?>" size="12" readonly="true">
                        </div>
                        <div align='right'>
                            <b>OUTROS R$:</b> <input name="outros_" type="text" id="outros_" style="font-family: Arial; font-size: 10px; background-color:#E3EEF2; border: 0px solid #000000;" value="<?php echo number_format($v_outros, 2, ",", "."); ?>" size="12" readonly="true">
                        </div>
                        <div align='right'>
                            <b>FRETE R$:</b> <input name="frete_" type="text" id="frete_" style="font-family: Arial; font-size: 10px; background-color:#E3EEF2; border: 0px solid #000000;" value="<?php echo number_format($v_frete, 2, ",", "."); ?>" size="12" readonly="true">
                        </div>
                        <div align='right'>
                            <b>ICMS R$:</b> <input name="icms_" type="text" id="icms_" style="font-family: Arial; font-size: 10px; background-color:#E3EEF2; border: 0px solid #000000;" value="<?php echo number_format($result[0]->icms, 2, ",", "."); ?>" size="12" readonly="true">
                        </div>
                        <div align='right'>
                            <b>TOTAL R$:</b> <input name="valor_total_" type="text" id="valor_total_" style="font-family: Arial; font-size: 10px; background-color:#E3EEF2; border: 0px solid #000000;" value="<?php echo number_format($total, 2, ",", "."); ?>" size="12" readonly="true">
                        </div>
                    </font>
                </div>
            </div>
        </div>
</body>
</html>