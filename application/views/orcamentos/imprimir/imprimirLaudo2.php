<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>A4</title>

        <!-- Normalize or reset CSS with your favorite library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

        <!-- Load paper.css for happy printing -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

        <!-- Set page size here: A5, A4 or A3 -->
        <!-- Set also "landscape" if you need -->
        <style>
            @page {
                size: A4
            }
            .divFooter{
                position: absolute;
                bottom:0px;
                left:0px;
                height: 130px;
            }
            .divTituloDestacado{
                border: 1px solid black; 
                text-align:center;
                padding: 10px;
                margin-top: 10px;
                margin-bottom: 10px;
            }
            .divTitulo{            
                text-align:center;
                padding: 10px;
                margin-top: 10px;
                margin-bottom: 10px;
            }
            .divTexto{
                text-align: justify;
                margin-bottom: 50px;
                font-size: 20px;
            }
            .divHeader{
                text-align: center;
            }
        </style>
    </head>

    <!-- Set "A5", "A4" or "A3" for class name -->
    <!-- Set also "landscape" if you need -->

    <body class="A4">
        <?php 
            $dat = $this->input->get('dataInicial');
            if ($dat == '') {
                $dataimpri =  date("d/m/Y", strtotime($result[0]->data_abert_orc));
            } else {
                $dataimpri =  date("d/m/Y", strtotime($dat));
            }
            $itenslaudoTotal = array();
            foreach($itensLaudo as $r){
                $html = "";
                $html .= '<div style="text-align: center; padding: 20px;">';
                $html .= '<img src="'.base_url().$r->caminho.$r->imagem.'" alt="your image" style="max-height: 144px;  max-width: 256px;;">';   
                $html .= '</div>';
                $html .= '<div style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;text-align:center">';
                $html .= nl2br($r->comentariosExibicao);
                $html .= '</div>';
                array_push($itenslaudoTotal,$html);
            }
        ?>
        <!-- Each sheet element should have the class "sheet" -->
        <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
        <section class="sheet padding-10mm">
            <div class="divHeader">
                <img src="<?php echo base_url();?>assets/img/ubertec.png" 'style="width:100%">
                <?php
                    if ($result[0]->status_orc == 1) {
                        ?>
                            <div align='center'>
                                <font size='5' color='red'>Orçamento Desativado</font>
                            </div>
                        <?php
                    }
                ?>
            </div>
            <!-- Write HTML just like a web page -->
            <article>
                <div class="divTitulo">
                    <b>RELATÓRIO TÉCNICO</b>
                </div>
                <div class="divTexto">
                    
                    <table style="width:100%">
                        <tr>
                            <td style="width: 50%;">Orçamento: <?php echo $result[0]->idorc; ?></td>
                            <td style="width: 50%;">Cliente: <?php echo $result[0]->nomecli; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;">Data: <?php echo $dataimpri; ?></td>
                            <td style="width: 50%;">CNPJ: <?php echo $result[0]->documentocli; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;">Referente: <?php echo $result[0]->referencia; ?></td>
                            <td style="width: 50%;">Solicitante: <?php echo $result[0]->nomesolici; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;">Vendedor: <?php echo $result[0]->nomevendedo; ?></td>
                            <td style="width: 50%;"></td>
                        </tr>
                    </table>
                </div><!--
                <div class="divTituloDestacado">
                    RELATÓRIO DE AVALIAÇÃO TÉCNICA
                </div> -->
                <div class="divTexto">
                    <div style="text-align:center">
                        <b>Motivo da Solicitação: </b><?php echo strtoupper(nl2br($result[0]->descricao_item));?>
                    </div>

                    <?php /* 
                    foreach($itensLaudo as $r){
                        echo '<div style="text-align: center; padding: 20px;">';
                            echo '<img src="'.base_url().$r->caminho.$r->imagem.'" alt="your image" style="max-height: 144px;  max-width: 256px;; cursor: zoom-in">';  
                        echo '</div>';
                        echo '<div style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;text-align:center">';
                            echo nl2br($r->comentarios);
                        echo '</div>';
                    } */?>
                </div>
                <div class="divTituloDestacado">
                    FOTOS DOS COMPONENTES
                </div>
                <div class="divTexto">
                <?php /*foreach($itensLaudo as $r){
                    echo '<div style="text-align: center; padding: 20px;">';
                        echo '<img src="'.base_url().$r->caminho.$r->imagem.'" alt="your image" style="max-height: 144px;  max-width: 256px;;">';   
                    echo '</div>';
                    echo '<div style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;text-align:center">';
                        echo nl2br($r->comentarios);
                    echo '</div>';
                }*/?>
                <?php $contador = 0;
                for($x=0;$x<sizeof($itenslaudoTotal) && $x!=2;$x++){
                    echo $itenslaudoTotal[$x];
                    $contador ++;
                } ?>
                </div>
            </article>
            <div class="divFooter">
                <img src="<?php echo base_url();?>assets/img/rodaperelatorio.png" style="width:100%">
            </div>
        </section>
        
        <?php if(sizeof($itenslaudoTotal)>2){ 
            while($contador != sizeof($itenslaudoTotal)){?>

            
            <section class="sheet padding-10mm">
                <div class="divHeader">
                    <img src="<?php echo base_url();?>assets/img/ubertec.png" 'style="width:100%">
                    <?php
                        if ($result[0]->status_orc == 1) {
                            ?>
                                <div align='center'>
                                    <font size='5' color='red'>Orçamento Desativado</font>
                                </div>
                            <?php
                        }
                    ?>
                </div>
                <article>
                    <div class="divTexto">
                        <?php 
                        $contador2 = $contador;
                        for($x=$contador;$x<sizeof($itenslaudoTotal) && $x!=$contador2+3;$x++){
                            echo $itenslaudoTotal[$x];
                            $contador ++;
                        } ?>
                    </div>
                </article>
                <div class="divFooter">
                    <img src="<?php echo base_url();?>assets/img/rodaperelatorio.png" style="width:100%">
                </div>
            </section>
        <?php }
        }?>
        
        
        
        <!--
        <section class="sheet padding-10mm">
            <div class="divHeader">
                <img src="<?php echo base_url();?>assets/img/ubertec.png" 'style="width:100%">
                <?php
                    if ($result[0]->status_orc == 1) {
                        ?>
                            <div align='center'>
                                <font size='5' color='red'>Orçamento Desativado</font>
                            </div>
                        <?php
                    }
                ?>
            </div>
            <article>
                <div class="divTituloDestacado">
                    FOTOS DOS COMPONENTES
                </div>            
            </article>
            <div class="divFooter">
                <img src="<?php echo base_url();?>assets/img/rodaperelatorio.png" style="width:100%">
            </div>
        </section>
                -->
        <section class="sheet padding-10mm">
            <div class="divHeader">
                <img src="<?php echo base_url();?>assets/img/ubertec.png" 'style="width:100%">
                <?php
                    if ($result[0]->status_orc == 1) {
                        ?>
                            <div align='center'>
                                <font size='5' color='red'>Orçamento Desativado</font>
                            </div>
                        <?php
                    }
                ?>
            </div>
            <!-- Write HTML just like a web page -->
            <article>
                <div class="divTituloDestacado">
                    DESCRIÇÃO DAS OPERAÇÕES
                </div>
                <div class="divTexto">
                    <ul>
                        <?php foreach($itensEscopo as $v){
                            $primeiro = true;
                            echo '<li style="margin-bottom: 10px;">'.$v->quantidade." - ".$v->descricaoServicoItens;
                            if(!empty($v->dimenExt)){
                                if($primeiro){
                                    echo " Ø".$v->dimenExt;
                                    $primeiro = false;
                                }else{
                                    echo " x Ø".$v->dimenExt;
                                }
                            }
                            if(!empty($v->dimenInt)){
                                if($primeiro){
                                    echo " Ø".$v->dimenInt;
                                    $primeiro = false;
                                }else{
                                    echo " x Ø".$v->dimenInt;
                                }
                            }
                            if(!empty($v->dimenComp)){
                                if($primeiro){
                                    echo " ".$v->dimenComp."mm";
                                    $primeiro = false;
                                }else{
                                    echo " x ".$v->dimenComp."mm";
                                }
                            }
                        echo '</li>';
                        }?>
                    </ul>
                </div>
            </article>
            <div class="divFooter">
                <img src="<?php echo base_url();?>assets/img/rodaperelatorio.png" style="width:100%">
            </div>
        </section>
        <section class="sheet padding-10mm">
            <div class="divHeader">
                <img src="<?php echo base_url();?>assets/img/ubertec.png" 'style="width:100%">
                <?php
                    if ($result[0]->status_orc == 1) {
                        ?>
                            <div align='center'>
                                <font size='5' color='red'>Orçamento Desativado</font>
                            </div>
                        <?php
                    }
                ?>
            </div>
            <!-- Write HTML just like a web page -->
            <article>
                <div class="divTituloDestacado">
                    POLÍTICA DE GARANTIA
                </div>
                <div class="divTexto">                
                    <p >Ubertec concederá garantia de 03 (três) meses para peças substituídas ou recuperadas que
                    apresentarem algum defeito de fabricação ou problemas decorrentes da montagem das
                    mesmas. Problemas causados por falhas operacionais, acidentes ou mau uso do
                    equipamento, não estarão cobertos pela garantia.</p>
                </div>
                <div class="divTituloDestacado">
                    PRAZO DE ENTREGA
                </div>
                <div class="divTexto">
                    <p>
                        <b>Prazo de entrega:</b> <?php echo $result[0]->prazo;?> dias
                    </p>
                    <p>
                        Agradecemos pela oportunidade, e nos colocamos a disposição para esclarecimentos de
                        possíveis dúvidas, e nos prontificamos para futuras recuperações, melhorias e/ou
                        desenvolvimento de novos projetos em parceria com esta conceituada empresa.
                    </p>
                    <p>
                        Atenciosamente,
                    </p>
                    <p>
                        <div  style="text-align:center">
                            <img src="<?php echo base_url().$result[0]->assinatura;?>" >
                        </div>
                        <div style="border:1px solid black"></div>
                        <div style="text-align:center">Comercial</div>

                    </p>
                
                </div>
            </article>
            <div class="divFooter">
                <img src="<?php echo base_url();?>assets/img/rodaperelatorio.png" style="width:100%">
            </div>
        </section>

    </body>

</html>