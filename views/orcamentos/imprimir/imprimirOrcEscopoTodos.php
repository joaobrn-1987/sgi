<?php


$dat = $this->input->get('dataInicial');
if ($dat == '') {
    $dataimpri =  date("d/m/Y", strtotime($result[0]->data_abert_orc));
} else {
    $dataimpri =  date("d/m/Y", strtotime($dat));
}



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
            font-size: 10px;
        }

        table.comBordastitu td {

            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }
    </style>


    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">

                <div class="widget-box">
                    <?php
                    if ($result[0]->status_orc == 1) {
                    ?>
                        <div align='center'>
                            <font size='5' color='red'>Orçamento Desativado</font>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="widget-content nopadding">

                        <table width='100%' align='center' border='0' class='comBordastitu'>

                            <tr>
                                <td style="text-align: center; width: 20%" rowspan='3'><strong><img src=" <?php echo base_url() . $result[0]->url_logoemi . $result[0]->imagememi; ?> " width='55%' height='30%'=></strong></td>
                                <td align='center'>
                                    <table width='100%' border='0'>
                                        <tr>
                                            <td colspan='2' align='center' height='50'>
                                                <b>
                                                    <font size='4'><?php echo $result[0]->nomeemi; ?></font>
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <font size='1'>CNPJ: <?php echo $result[0]->cnpjemi; ?></font>
                                            </td>
                                            <td>
                                                <font size='1'>INSCRIÇÃO ESTADUAL: <?php echo $result[0]->ieemi; ?></font> </br>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <font size='1'>ENDEREÇO: <?php echo $result[0]->ruaemi; ?> Nº: <?php echo $result[0]->numeroemi; ?></font>
                                            </td>
                                            <td>
                                                <font size='1'>BAIRRO: <?php echo $result[0]->bairroemi; ?></font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <font size='1'>CIDADE: <?php echo $result[0]->cidadeemi; ?> </font>
                                            </td>
                                            <td>
                                                <font size='1'>ESTADO: <?php echo $result[0]->ufemi; ?></font>
                                            </td>
                                        <tr>
                                            <td>
                                                <font size='1'>E-MAIL: <?php echo $result[0]->emailemi; ?></font>
                                            </td>
                                            <td>
                                                <font size='1'>TELEFONE: <?php echo $result[0]->telefoneemi; ?></font>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <!--<td rowspan='3'><table><tr><td>Orçamento Nº: <b><?php echo $result[0]->idorc ?></b></td></tr>
						<tr><td>Data Emissão: <b><?php echo date('d/m/Y',  strtotime($result[0]->data_abert_orc)) ?></b></td></tr>
						</table></td>-->

                            </tr>

                        </table>






                    </div>

                </div>


            </div>



        </div>
        <br>
        <table class='comBordas' width='36%' align='right'>
            <tr>
                <td align='center'>
                    ORÇAMENTO Nº: <font size='1'><?php echo $result[0]->idorc ?></font>
                </td>
                <td align='center'>
                    DATA:<?php echo $dataimpri; ?>
                </td>
            </tr>
        </table>
        <br><br>

        <div class="row-fluid">
            <div class="span12">

                <div class="widget-box">

                    <div class="widget-content nopadding">

                        <!--<table class="table table-bordered">-->
                        <table width='100%' border='0' style="border-style:solid; border: 1px solid grey;
                            font-family:Arial, Helvetica, sans-serif;
                            font-size:12px;">
                            <tr>
                                <td>
                                    <table width='100%' border='0' style="font-family:Arial, Helvetica, sans-serif;
	                                    font-size:12px;">
                                        <tr>
                                            <!--<td align='center'>Código<br><?php echo $result[0]->idcli; ?></td>-->
                                            <td align='left'>CLIENTE:</td>
                                            <td width='45%'><?php echo $result[0]->nomecli; ?></td>
                                            <td align='left'>CNPJ:</td>
                                            <td><?php echo $result[0]->documentocli; ?></td>
                                        </tr>
                                        <tr>
                                            <td align='left' width='13%'>SOLICITANTE: </td>
                                            <td><?php echo $result[0]->nomesolici; ?></td>
                                            <td align='left' width='20%'>E-MAIL SOLICITANTE: </td>
                                            <td><?php echo $result[0]->emailsolicitante; ?></td>
                                        </tr>
                                        <tr>
                                            <td align='left'>TELEFONE:</td>
                                            <td><?php echo $result[0]->telefonecli; ?></td>
                                            <td align='left'>REFERÊNCIA:</td>
                                            <td><?php echo $result[0]->referencia; ?></td>

                                        </tr>

                                    </table>
                                </td>
                            </tr>


                        </table>






                    </div>

                </div>


            </div>



        </div>

        <?php foreach ($escopo as $v) {
            $valorServico = 0;
            $valorFabricacao = 0;
        ?>
            <div class="row-fluid" style="border: 1px solid grey;margin-top: 2px;">
                <div class="span12">

                    <div class="widget-box">

                        <div class="widget-content nopadding" style="font-family:Arial, Helvetica, sans-serif;
                                            font-size:12px; ">
                            <div class="span12" style="min-height:0px">
                                <div style="text-align: center; margin-top: 5px;">
                                    <!-- DESCRIÇÃO:--> <?php echo $result[0]->descricao_item; ?>
                                </div>
                            </div>
                            <table width='100%' border='0' style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                                <tr>
                                    <td>
                                        <table width='100%' border='0' style="font-family:Arial, Helvetica, sans-serif;
                                            font-size:12px;">
                                            <tr>
                                                <!--<td align='center'>Código<br><?php echo $result[0]->idcli; ?></td>-->
                                                <td align='left'>PN:</td>
                                                <td width='45%'><?php echo $v->pn; ?></td>
                                                <td align='left'>DATA:</td>
                                                <td><?php  ?></td>
                                            </tr>
                                            <tr>
                                                <td align='left' width='13%'>TAG: </td>
                                                <td><?php echo $v->tag; ?></td>
                                                <td align='left' width='20%'>ORDEM SERV. </td>
                                                <td><?php echo $v->idOs; ?></td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>


                            </table>



                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">


                    <div class="widget-box">

                        <div class="widget-content nopadding">

                            <table class='comBordas' width='100%'>
                                <thead>
                                    <tr>
                                        <td align='center'><b>Item</b></td>
                                        <td align='center'><b>Descrição</b></td>
                                        <td align='center'><b>Classe</b></td>
                                        <td align='center'><b>Qtd.</b></td>
                                        <td align='center'><b>Valor Unit.</b></td>
                                        <td align='center'><b>Valor Total</b></td>
                                        <td align='center'><b>Avaliação Técnica</b></td>

                                    </tr>

                                </thead>
                                <tbody>
                                    <?php $counta = 1;
                                    foreach ($v->itensEscopo as $r) {
                                        if($r->idClasse == 1){
                                            $valorServico += ($r->valorUnitario * $r->quantidade);
                                        }
                                        if($r->idClasse == 2){
                                            $valorFabricacao += ($r->valorUnitario * $r->quantidade);
                                        }
                                        echo '<tr>';
                                        echo '<td>';
                                        echo $counta;
                                        echo '</td>';
                                        echo '<td>';
                                        echo $r->descricaoServicoItens;
                                        echo '</td>';
                                        echo '<td>';
                                        echo $r->descricaoClasse;
                                        echo '</td>';
                                        echo '<td>';
                                        echo $r->quantidade;
                                        echo '</td>';
                                        echo '<td>';
                                        echo 'R$ ' . number_format($r->valorUnitario, 2, ',', '.');
                                        echo '</td>';
                                        echo '<td>';
                                        echo 'R$ ' . number_format($r->valorUnitario * $r->quantidade, 2, ',', '.');
                                        echo '</td>';
                                        echo '<td>';
                                        echo $r->obs;
                                        echo '</td>';

                                        echo '</tr>';
                                        $counta++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <table width='100%'  >
                    <tr><td align='right'><table width='50%' class='comBordas'>
            
                        <tr>
                        <td align='left'>VALOR SERVIÇO:</td><td> R$ <?php echo number_format($valorServico, 2, ",", ".");?></td>
                    </tr>
                    <tr>
                        <td align='rigth'>VALOR FABRICAÇÃO:</td><td> R$ <?php echo number_format($valorFabricacao, 2, ",", "."); ?></td>
                    </tr>
                    
                    <tr>
                        <td align='rigth'><b>TOTAL:</td><td> R$ <?php echo number_format($valorServico + $valorFabricacao, 2, ",", "."); ?></b></td>
                    </tr>
                            
                                
                </table>



            </div>
                                </br>
                                </br>
        <?php } ?>
        



    </div>
</body>
<?php
$valorsub = 0;
$valortot = 0;
$valoripi = 0;
$valordesconto = 0;

$count_item = 1;
//foreach ($itens_orcamento as $item) {
foreach ($escopo as $item) {

    $valoripi = ($item->val_ipi / 100 * $item->subtot) + $valoripi;
    $valordesconto = $item->desconto + $valordesconto;
    $valorsub = $item->subtot + $valorsub;
    $valortot = $valorsub + $valoripi;
}

?>
<div class="row-fluid">
    <div class="span12">

        <div class="widget-box" style="padding-right: 12px;">

            <div class="widget-content nopadding">

                <!--<table class="table table-bordered">-->
                <table width='100%' border='0'>

                    <tr>
                        <td>
                            <table width='100%' class='comBordas'>
                                <tr>
                                    <td colspan='2'>OBSERVAÇÕES: <?php echo $result[0]->obs; ?></td>

                                </tr>

                                <tr>
                                    <td>Condição de Pagamento</td>
                                    <td><?php echo $result[0]->cond_pgto; ?></td>

                                </tr>
                                <tr>
                                    <td>Validade da Proposta</td>
                                    <td><?php echo $result[0]->validade; ?></td>


                                </tr>

                                <tr>
                                    <td>Local/Condição de Entrega</td>
                                    <td><?php
                                        if ($result[0]->entregaoutros <> '') {
                                            echo $result[0]->entregaoutros;
                                        } else {
                                            echo  $result[0]->entrega;
                                        }

                                        ?>

                                    </td>

                                </tr>
                                <tr>
                                    <td>Natureza da Operação</td>
                                    <td><?php echo $result[0]->nomenat; ?></td>

                                </tr>
                                <tr>
                                    <td>Prazo Entrega</td>
                                    <td>
                                        <font size='1'>O prazo de entrega está condicionado ao recebimento<br> do pedido de compra.<br> SALVO VENDA PRÉVIA
                                    </td>

                                </tr>
                                <?php
                                if (!empty($result[0]->garantia_servico)) {
                                ?>
                                    <tr>
                                        <td>Garantia Serviço</td>
                                        <td>
                                            <font size='1'><?php echo $result[0]->garantia_servico; ?>
                                        </td>

                                    </tr>

                                <?php

                                }

                                ?>
                            </table>
                        </td>
                        <td>
                            <table width='100%'>
                                <tr>
                                    <td align='right'>
                                        <table width='100%' class='comBordas'>

                                            <tr>
                                                <td align='left'>SUBTOTAL:</td>
                                                <td> R$ <?php echo number_format($valorsub, 2, ",", "."); ?></td>
                                            </tr>
                                            <tr>
                                                <td align='rigth'>VALOR IPI:</td>
                                                <td> R$ <?php echo number_format($valoripi, 2, ",", "."); ?></td>
                                            </tr>

                                            <tr>
                                                <td align='rigth'><b>TOTAL:</td>
                                                <td> R$ <?php echo number_format($valortot, 2, ",", "."); ?></b></td>
                                            </tr>


                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width='100%' class='comBordas'>
                                            <tr>

                                                <td align='center'>
                                                    Impostos Inclusos<br>
                                                    Para Fabricação :<br>
                                                    Para Serviço :
                                                </td>
                                                <td align='center'><br>
                                                    ICMS e DARF<br>
                                                    ISS e DARF
                                                </td>


                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>




                </table>






            </div>

        </div>


    </div>

    <!--
<div align="center"> <br>O prazo de entrega está condicionado ao recebimento do pedido de compra.
Após a data da validade do Orçamento, nosso preço e prazo de entrega estarão sujeitos a alteração</div>	
-->
</div>



<!-- fecha observaçao-->
<br>
<table class='comBordas' width='100%'>
    <tr>
        <td>
            <div align="center">NÃO É DOCUMENTO FISCAL - NÃO É VÁLIDO COMO RECIBO E COMO GARANTIA DE MERCADORIA - NÃO COMPROVA PAGAMENTO.
            </div>
        </td>
    </tr>
</table>


<!-- rodape-->

<br>


<!--<div align="center">ASSINATURAS</div>--><br>
<!-- <table class='comBordas' width='100%' align='rigth'>
 <tr>
  <td align="center"><br>_______________________________<br><?php echo $result[0]->nomevendedo; ?><br>Comercial</td>
  <td align="center"><br>_______________________________<br><?php echo $result[0]->nomegerente; ?><br>Gerente Comercial</td>
 <td align="center">Aprovação do cliente<br><br>
 DATA: ______/______/______ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASSINATURA:_______________________________
 
 </td>
</tr>

</table>-->
<table class='comBordas' width='100%' align='rigth'>
    <tr>
        <td>Após a data de validade do orçamento, nosso preço e prazo de entrega estarão sujeitos a alteração.</td>
    </tr>

</table>
<div><b><br>Atenciosamente,</b></div>
<table width='50%' align='center'>
    <tr>
        <td align="center">
            <img src=" <?php echo base_url() . $result[0]->assinatura; ?> " style="height: 50px;" width='55%' height='30%'>
            <br>_______________________________<br><?php echo $result[0]->nomevendedo; ?><br>Comercial
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="center">
            <img src=" <?php echo base_url() . $result[0]->caminho_assinatura; ?> " style="height: 50px;" width='55%' height='30%'>
            <br>_______________________________<br><?php echo $result[0]->nomegerente; ?><br>Gerente Comercial
        </td>
    </tr>
    <tr>
        <td align="center" colspan='3'><br><br>_______________________________<br>
            Aprovação do cliente

        </td>
    </tr>

</table>

</html>