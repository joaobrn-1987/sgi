<?php


$dat = $this->input->get('dataInicial');
if ($dat == '') {
    $dataimpri =  date("d/m/Y", strtotime($result[0]->data_abert_orc));
} else {
    $dataimpri =  date("d/m/Y", strtotime($dat));
}



?>
<style> 
.block {
  text-align: center;
  height: 100%;
}

/* The ghost, nudged to maintain perfect centering */
.block:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -0.25em; /* Adjusts for spacing */
}

/* The element to be centered, can
   also be of any width and height */ 
.centered {
  display: inline;
  vertical-align: middle;
  width: 99%;
}
</style>

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
        
        <div style="text-align: center;padding: 20px;font-size: 20px;font-weight: bold;">
            Relatório Técnico
        </div>
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
        <div style="text-align: center;padding: 20px;font-size: 20px;font-weight: bold;">
            Relatório de Avaliação Técnica
        </div>
        <div class="row-fluid" style="border: 1px solid grey;margin-top: 2px;">
            <div class="span12">

                <div class="widget-box" >

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
                                            <td width='45%'><?php echo $descricoes->pn; ?></td>
                                            <td align='left'>DATA:</td>
                                            <td><?php  ?></td>
                                        </tr>
                                        <tr>
                                            <td align='left' width='13%'>TAG: </td>
                                            <td><?php echo $descricoes->tag; ?></td>
                                            <td align='left' width='20%'>ORDEM SERV. </td>
                                            <td><?php echo $descricoes->idOs; ?></td>
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
                            <tbody>
                                <?php $counta = 0;foreach($itensLaudo as $r){
                                    if($counta%2 == "0"){
                                        echo '<tr>';
                                    }                                    
                                        echo '<td>';
                                            echo '<div style="text-align: center; padding: 20px;">';
                                                echo '<img src="'.base_url().$r->caminho.$r->imagem.'" alt="your image" style="max-height: 144px;  max-width: 256px;; cursor: zoom-in">';   
                                            echo '</div>';
                                            echo '<div style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;text-align:center">';
                                                //echo '<b> COMENTÁRIOS: </b>';
                                            echo '</div>';
                                            echo '<div style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;text-align:left">';
                                                echo strtoupper(nl2br($r->comentarios));
                                            echo '</div>';
                                        echo '</td>';
                                    if($counta % 2 == "1"){
                                        echo '</tr>';
                                    }
                                    $counta = $counta + 1;
                                }?>
                            </tbody>
                        </table>      
                    </div>
                </div>
            </div>            
        </div>
        <div>
            <div style="text-align: center;padding: 20px;font-size: 20px;font-weight: bold;">
                Descrição das operações
            </div>
        </div>
    </div>
</body>

</html>