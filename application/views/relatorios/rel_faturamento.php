<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->

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
                            <form action="<?php echo base_url() ?>index.php/relatorios/relfaturamento" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Unidade Exec.: </label><!--
                                            <input type="text" class="span12" value=""  name="idOrcamento"/> -->
                                            <?php foreach ($unid_exec as $exec) { ?>
                                                <input type="checkbox" name="unid_execucao[]" class='check' value="<?php echo $exec->id_unid_exec; ?>"> &nbsp;<?php echo $exec->status_execucao; ?>
                                            <?php } ?>
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Cliente: </label>
                                            <input type="text" class="span12" value=""  name="cliente" id="cliente"/>
                                            <input type="hidden" class="span12" value=""  name="idCliente" id="idCliente"/>
                                        </div>
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Vendedor: </label>
                                            <select class="span12 form-control" name="idVendedor">
                                                <option value="">Todos</option>
                                                <?php foreach ($vendedores as $v) { ?>

                                                    <option value="<?php echo $v->idVendedor; ?>" <?php if ($v->idVendedor == 1) {
                                                                                                        //echo "selected='selected'";
                                                                                                    } ?>><?php echo $v->nomeVendedor; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Data Abertura: </label>
                                            <input type="text" class="span6 datap" value=""  name="data_inicio_ab" id="data_inicio_ab" placeholder="Inicio"/> 
                                            <input type="text" class="span6 datap" value=""  name="data_fim_ab" id="data_fim_ab" placeholder="Fim"/>
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Data Faturamento: </label>
                                            <input type="text" class="span6 datap" value=""  name="data_inicio" id="data_inicio" placeholder="Inicio"/> 
                                            <input type="text" class="span6 datap" value=""  name="data_fim" id="data_fim" placeholder="Fim"/>
                                        </div>    
                                        <div class="span1">
                                            <label for="idGrupoServico" class="control-label">Contrato: </label> 
                                            <select class="span12 form-control" name="contrato">
                                                <option value="">Todos</option>
                                                <option value="Sim">Sim</option>
                                                <option value="Não">Não</option>
                                            </select>
                                        </div>
                                        <div class="span1">
                                            <label for="idGrupoServico" class="control-label">Encerrado: </label> 
                                            <select class="span12 form-control" name="encerrado">
                                                <option value="Sim">Sim</option>
                                                <option selected value="">Não</option>
                                            </select>
                                        </div>                                    
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
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

<?php if(isset($abertura)){ ?>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">Faturamento</a></li>
        <li><a href="#tab2" data-toggle="tab">Relação</a></li>
    </ul>
<?php }?>

<div class="tab-content" onmousemove="scrollDetect(this,event)">
	<div class="tab-pane active" id="tab1">
        <div class="buttons" align='center' style="margin-top:15px">
            <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
            <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Rel-Orcamento" id="btnExport">Excel</a>
        </div>

        <div id="imprimirTable">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Histórico faturamento</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">                                
                                            <div class="widget-box" style="margin-top:0px">   
                                                <?php 
                                                    $valor = array(array());
                                                    $linha = 1;
                                                    $coluna = 1;
                                                    $valor[0][0] = "CONTRATO";

                                                    $valor2 = array(array());
                                                    $linha2 = 1;
                                                    $coluna2 = 1;
                                                    $valor2[0][0] = "CONTRATO";

                                                    $valor3 = array(array());
                                                    $linha3 = 1;
                                                    $coluna3 = 1;
                                                    $valor3[0][0] = "CONTRATO";

                                                    $totalOrc = 0;
                                                    $totalOS = 0;
                                                    $totalInsumo = 0;
                                                ?>
                                                <table id="tableHistVale" class="table table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th>Data Aber.</th>
                                                            <th>Data Fat.</th>
                                                            <th>O.S.</th>
                                                            <th>Status</th>
                                                            <th>Unid. exec.</th>
                                                            <th>Contrato.</th>
                                                            <th>Descrição</th>
                                                            <th>Cliente</th>
                                                            <th>Valor Orç</th>
                                                            <th>Valor O.S.</th>
                                                            <th>Valor Insumo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                        //echo "<script type='text/javascript'>console.log(".json_encode($valor2).")</script>";
                                                            foreach($listOs as $r){
                                                                echo '<tr>';
                                                                    $dataAB = new DateTime($r->data_abertura);
                                                                    echo '<td>'.$dataAB->format( 'd/m/Y' ).'</td>';
                                                                    $dataFat = new DateTime($r->data_faturado);
                                                                    echo '<td>'.$dataFat->format( 'd/m/Y' ).'</td>';
                                                                    echo '<td>'.$r->idOs.'</td>';
                                                                    echo '<td>'.$r->nomeStatusOs.'</td>';
                                                                    echo '<td>'.$r->status_execucao.'</td>';
                                                                    echo '<td>'.$r->contrato.'</td>';
                                                                    echo '<td>'.$r->descricao_item.'</td>';
                                                                    echo '<td>'.$r->nomeCliente.'</td>';
                                                                    echo '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div><spam >'.number_format($r->valorOrc,2,",",".").'</spam></td>';
                                                                    echo '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div>'.number_format($r->valorOS,2,",",".").'</td>';
                                                                    echo '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div>'.number_format($r->valorInsumos,2,",",".").'</td>';
                                                                echo '</tr>';
                                                                $totalOrc += $r->valorOrc;
                                                                $totalOS += $r->valorOS;
                                                                $totalInsumo += $r->valorInsumos;


                                                                //ValorInsumo
                                                                $verificarContrato = false;
                                                                $posicaoContrato = $linha ;
                                                                for($x=1;$x<$linha;$x++){
                                                                    if($valor[$x][0] == $r->contrato){
                                                                        $verificarContrato = true;
                                                                        $posicaoContrato = $x;
                                                                    }
                                                                }
                                                                if(!$verificarContrato){
                                                                    $valor[$linha][0] = $r->contrato;
                                                                    $linha ++;
                                                                    for($x=1;$x<$coluna;$x++){
                                                                        $valor[$linha][$x] = "0";
                                                                    }
                                                                    $valor[$linha][0] = "oi";
                                                                }
                                                                
                                                                $verificarUnidExec = false;
                                                                $posicaoUnidExec = $coluna;
                                                                for($x=1;$x<$coluna;$x++){
                                                                    if($valor[0][$x] == $r->status_execucao){
                                                                        $verificarUnidExec = true;
                                                                        $posicaoUnidExec = $x;
                                                                    }
                                                                }
                                                                if(!$verificarUnidExec){
                                                                    $valor[0][$coluna] = $r->status_execucao;
                                                                    $coluna ++;
                                                                    for($x=1;$x<$linha;$x++){
                                                                        $valor[$x][$coluna] = "0";
                                                                    }
                                                                    $valor[0][$coluna] = "oi";
                                                                }
                                                                $valor[$posicaoContrato][$posicaoUnidExec] = (empty($valor[$posicaoContrato][$posicaoUnidExec])?0:$valor[$posicaoContrato][$posicaoUnidExec]) +$r->valorInsumos;
                                                                
                                                                //ValorORc
                                                                $verificarContrato = false;
                                                                $posicaoContrato = $linha2 ;
                                                                for($x=1;$x<$linha2;$x++){
                                                                    if($valor2[$x][0] == $r->contrato){
                                                                        $verificarContrato = true;
                                                                        $posicaoContrato = $x;
                                                                    }
                                                                }
                                                                if(!$verificarContrato){
                                                                    $valor2[$linha2][0] = $r->contrato;
                                                                    $linha2 ++;
                                                                    for($x=1;$x<$coluna2;$x++){
                                                                        $valor2[$linha2][$x] = "0";
                                                                    }
                                                                    $valor2[$linha2][0] = "oi";
                                                                }
                                                                
                                                                $verificarUnidExec = false;
                                                                $posicaoUnidExec = $coluna2;
                                                                for($x=1;$x<$coluna2;$x++){
                                                                    if($valor2[0][$x] == $r->status_execucao){
                                                                        $verificarUnidExec = true;
                                                                        $posicaoUnidExec = $x;
                                                                    }
                                                                }
                                                                //echo "<script type='text/javascript'>console.log($coluna2)</script>";
                                                                if(!$verificarUnidExec){
                                                                    $valor2[0][$coluna2] = $r->status_execucao;                                                            
                                                                    $coluna2 ++;
                                                                    for($x=1;$x<$linha2;$x++){
                                                                        $valor2[$x][$coluna2] = "0";
                                                                    }
                                                                    $valor2[0][$coluna2] = "oi";
                                                                }
                                                                $valor2[$posicaoContrato][$posicaoUnidExec] = (empty($valor2[$posicaoContrato][$posicaoUnidExec])?0:$valor2[$posicaoContrato][$posicaoUnidExec]) +$r->valorOrc;
                                                                
                                                            
                                                                //ValorOS
                                                                $verificarContrato = false;
                                                                $posicaoContrato = $linha3 ;
                                                                for($x=1;$x<$linha3;$x++){
                                                                    if($valor3[$x][0] == $r->contrato){
                                                                        $verificarContrato = true;
                                                                        $posicaoContrato = $x;
                                                                    }
                                                                }
                                                                if(!$verificarContrato){
                                                                    $valor3[$linha3][0] = $r->contrato;
                                                                    $linha3 ++;
                                                                    for($x=1;$x<$coluna3;$x++){
                                                                        $valor3[$linha3][$x] = "0";
                                                                    }
                                                                    $valor3[$linha3][0] = "oi";
                                                                }
                                                                
                                                                $verificarUnidExec = false;
                                                                $posicaoUnidExec = $coluna3;
                                                                for($x=1;$x<$coluna3;$x++){
                                                                    if($valor3[0][$x] == $r->status_execucao){
                                                                        $verificarUnidExec = true;
                                                                        $posicaoUnidExec = $x;
                                                                    }
                                                                }
                                                                if(!$verificarUnidExec){
                                                                    $valor3[0][$coluna3] = $r->status_execucao;
                                                                    $coluna3 ++;
                                                                    for($x=1;$x<$linha3;$x++){
                                                                        $valor3[$x][$coluna3] = "0";
                                                                    }
                                                                    $valor3[0][$coluna3] = "oi";
                                                                }
                                                                $valor3[$posicaoContrato][$posicaoUnidExec] = (empty($valor3[$posicaoContrato][$posicaoUnidExec])?0:$valor3[$posicaoContrato][$posicaoUnidExec]) +$r->valorOS;
                                                                


                                                            }
                                                        ?>
                                                        <tr>
                                                            <td colspan="11"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="8">Total:</td>
                                                            <td>R$</br><?php echo number_format($totalOrc,2,",",".");?></td>
                                                            <td>R$</br><?php echo number_format($totalOS,2,",",".");?></td>
                                                            <td>R$</br><?php echo number_format($totalInsumo,2,",",".");?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>                                
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            
            <?php if(isset($abertura)){
                if($abertura){?>
                <div class="row-fluid" style="margin-top:0;page-break-before: always">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Quantidade de O.S. que foram abertas por mês/ano e quais dessas O.S. já foram faturadas </h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">                            
                                    <div class="tab-pane active" >
                                        <div class="span12">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table  class="table table-bordered ">
                                                    <tbody>
                                                        <?php
                                                            echo '<tr>';
                                                                echo '<th>';
                                                                echo '</th>';
                                                                foreach($abertura as $ab){

                                                                    echo '<th>';
                                                                        $formatter = new IntlDateFormatter('pt_BR',
                                                                        IntlDateFormatter::FULL,
                                                                        IntlDateFormatter::NONE,
                                                                        'America/Sao_Paulo',          
                                                                        IntlDateFormatter::GREGORIAN);
                                                                        $formatter->setPattern('MMMM');
                                                                        $month_name = $formatter->format(mktime(0, 0, 0, $ab->mes));
                                                                        echo ucfirst($month_name)."/".$ab->ano;
                                                                    echo '</th>';
                                                                    
                                                                }
                                                                echo '<th>';
                                                                    echo 'Total';
                                                                echo '</th>';
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            echo '<th>';                                                    
                                                                echo 'Faturadas / Aprovadas';
                                                            echo '</th>';
                                                            $somaFat = 0;
                                                            $somaApr = 0;
                                                            foreach($abertura as $ab){
                                                                echo '<td>';
                                                                    echo $ab->faturadas.' / '.$ab->aprovadas;
                                                                    $somaFat = $somaFat + $ab->faturadas;
                                                                    $somaApr = $somaApr + $ab->aprovadas;
                                                                echo '</td>';
                                                            }
                                                            echo '<td>';
                                                                echo $somaFat.' / '.$somaApr;
                                                            echo '</td>';
                                                            echo '</tr>';/*
                                                            echo '<tr>';
                                                            echo '<th>';                                                    
                                                                echo 'Valor à faturar';
                                                            echo '</th>';
                                                            $somaValAFat = 0;
                                                            foreach($abertura as $ab){
                                                                echo '<td>';
                                                                    echo "R$ ".number_format($ab->valor_aprovadas-$ab->valor_faturadas,2,",",".");
                                                                    $somaValAFat = $somaValAFat + $ab->valor_aprovadas-$ab->valor_faturadas;
                                                                echo '</td>';
                                                            }
                                                            echo '<td>';
                                                                echo "R$ ".number_format($somaValAFat,2,",",".");
                                                            echo '</td>';
                                                            echo '<tr>';
                                                            echo '<th>';                                                    
                                                                echo 'Valor Faturado';
                                                            echo '</th>';
                                                            $somaValFat = 0;
                                                            foreach($abertura as $ab){
                                                                echo '<td>';
                                                                    echo "R$ ".number_format($ab->valor_faturadas,2,",",".");
                                                                    $somaValFat = $ab->valor_faturadas+$somaValFat;
                                                                echo '</td>';
                                                            }
                                                            echo '<td>';                                                    
                                                                echo "R$ ".number_format($somaValFat,2,",",".");
                                                            echo '</td>';
                                                            echo '</tr>';*/
                                                            
                                                        ?>
                                                    
                                                    
                                                    </tbody>
                                                </table>
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                }
            }?>

            <?php if($listOs){?>
            <div class="row-fluid" style="margin-top:0;page-break-before: always">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Resumo (Valor Orçamentos)</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <?php 
                                        for($x=0;$x<$linha2;$x++){
                                            for($y=0;$y<$coluna2;$y++){
                                                if(!isset($valor2[$x][$y])){
                                                    $valor2[$x][$y] = "0";
                                                }
                                            }
                                        }
                                        //echo "<script type='text/javascript'>console.log(".json_encode($valor2).")</script>";
                                        for($x=1;$x<$linha2;$x++){                        
                                            $valor2[$x][$coluna2]="oi";
                                        }

                                        for($y=1;$y<$coluna2;$y++){
                                            $valor2[$linha2][$y]="oi";
                                        }
                                        $valor2[$linha2][$coluna2]="oi";
                                        $coluna2 ++;
                                        $linha2 ++;
                                        for($x=1;$x<$linha2;$x++){                        
                                            $valor2[$x][$coluna2]="0";
                                        }

                                        for($y=1;$y<$coluna2;$y++){
                                            $valor2[$linha2][$y]="0";
                                        }
                                        $valor2[$linha2][0]="Total";
                                        $valor2[0][$coluna2]="Total";
                                        $valor2[$linha2][$coluna2]="0";
                                        $valor2[$linha2-1][$coluna2]="oi2";
                                        $valor2[$linha2][$coluna2-1]="oi2";
                                        $coluna2 ++;
                                        $linha2 ++;
                                        echo "<script type='text/javascript'>console.log(".json_encode($valor2).")</script>";
                                    ?>
                                    <div class="tab-pane active" >
                                        <div class="span12">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table  class="table table-bordered ">
                                                    <tbody>
                                                        <?php

                                                        for($x=0;$x<$linha2;$x++){
                                                            echo "<tr>";
                                                            
                                                            for($y=0;$y<$coluna2;$y++){
                                                                if($x>0 && $y>0){
                                                                    if( $x<=$linha2 && $y<=$coluna2 && $x!=$linha2-1 && $y!=$coluna2-1){
                                                                        $valor2[$x][$coluna2-1]=$valor2[$x][$coluna2-1]+$valor2[$x][$y];
                                                                        $valor2[$linha2-1][$y]=$valor2[$linha2-1][$y]+$valor2[$x][$y];
                                                                        $valor2[$linha2-1][$coluna2-1] = $valor2[$linha2-1][$coluna2-1]+$valor2[$x][$y];
                                                                    }
                                                                }
                                                                if($x == 0 || $y==0){
                                                                    if($valor2[$x][$y]=="oi"){
                                                                        echo '<th style="border-right: 1px solid #ddd"> ';
                                                                            
                                                                        echo "</th>";
                                                                    }else{
                                                                        echo "<th>";
                                                                            echo $valor2[$x][$y];
                                                                        echo "</th>";
                                                                    }
                                                                    
                                                                }else if($valor2[$x][$y]=="oi"){
                                                                    if(($y+2) == $coluna2 && ($x+2) == $linha2){
                                                                        echo '<td style="text-align:right;border-top: 0px;border-left: 0px;background: white;width: 10px;">';

                                                                        echo "</td>";
                                                                    }else if(($y+2) == $coluna2){
                                                                        echo '<td style="text-align:right;border-top: 0px;background: white;width: 10px;">';

                                                                        echo "</td>";
                                                                    }else if(($x+2) == $linha2){
                                                                        echo '<td style="text-align:right;border-left: 0px;background: white;height: 10px;">';

                                                                        echo "</td>";
                                                                    }
                                                                    
                                                                    
                                                                }else if($valor2[$x][$y] == "oi2"){
                                                                    if($x==$linha2-1 && $y==$coluna2-1){
                                                                        echo '<td style="text-align:right;border-top: 0px;border-left: 0px;">';
                                                                        echo "</td>";
                                                                    }else{
                                                                        echo "<td>";
                                                                        echo "</td>";
                                                                    }
                                                                    
                                                                }else{
                                                                    echo '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div>';
                                                                        echo number_format($valor2[$x][$y],2,",",".");
                                                                    echo "</td>";
                                                                }
                                                                
                                                            }
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    
                                                    
                                                    </tbody>
                                                </table>
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row-fluid" style="margin-top:0;page-break-before: auto">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Resumo (Valor O.S.)</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <?php 

                                        for($x=0;$x<$linha3;$x++){
                                            for($y=0;$y<$coluna3;$y++){
                                                if(!isset($valor3[$x][$y])){
                                                    $valor3[$x][$y] = "0";
                                                }
                                            }
                                        }
                                        for($x=1;$x<$linha3;$x++){                        
                                            $valor3[$x][$coluna3]="oi";
                                        }

                                        for($y=1;$y<$coluna3;$y++){
                                            $valor3[$linha3][$y]="oi";
                                        }
                                        $valor3[$linha3][$coluna3]="oi";
                                        $coluna3 ++;
                                        $linha3 ++;
                                        for($x=1;$x<$linha3;$x++){                        
                                            $valor3[$x][$coluna3]="0";
                                        }

                                        for($y=1;$y<$coluna3;$y++){
                                            $valor3[$linha3][$y]="0";
                                        }
                                        $valor3[$linha3][0]="Total";
                                        $valor3[0][$coluna3]="Total";
                                        $valor3[$linha3][$coluna3]="0";
                                        $valor3[$linha3-1][$coluna3]="oi2";
                                        $valor3[$linha3][$coluna3-1]="oi2";
                                        $coluna3 ++;
                                        $linha3 ++;

                                    ?>
                                    <div class="tab-pane active" >
                                        <div class="span12">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table  class="table table-bordered ">
                                                    <tbody>
                                                        <?php for($x=0;$x<$linha3;$x++){
                                                            echo "<tr>";
                                                            
                                                            for($y=0;$y<$coluna3;$y++){
                                                                if($x>0 && $y>0){
                                                                    if($x+2!=$linha3 && $y+2!=$coluna3 && $x!=$linha3-1 && $y!=$coluna3-1){
                                                                        $valor3[$x][$coluna3-1]=$valor3[$x][$coluna3-1]+$valor3[$x][$y];
                                                                        $valor3[$linha3-1][$y]=$valor3[$linha3-1][$y]+$valor3[$x][$y];
                                                                        $valor3[$linha3-1][$coluna3-1] = $valor3[$linha3-1][$coluna3-1]+$valor3[$x][$y];
                                                                    }
                                                                }
                                                                if($x == 0 || $y==0){
                                                                    if($valor3[$x][$y]=="oi"){
                                                                        echo '<th style="border-right: 1px solid #ddd"> ';
                                                                            
                                                                        echo "</th>";
                                                                    }else{
                                                                        echo "<th>";
                                                                            echo $valor3[$x][$y];
                                                                        echo "</th>";
                                                                    }
                                                                    
                                                                }else if($valor3[$x][$y]=="oi"){
                                                                    if(($y+2) == $coluna3 && ($x+2) == $linha3){
                                                                        echo '<td style="text-align:right;border-top: 0px;border-left: 0px;background: white;width: 10px;">';

                                                                        echo "</td>";
                                                                    }else if(($y+2) == $coluna3){
                                                                        echo '<td style="text-align:right;border-top: 0px;background: white;width: 10px;">';

                                                                        echo "</td>";
                                                                    }else if(($x+2) == $linha3){
                                                                        echo '<td style="text-align:right;border-left: 0px;background: white;height: 10px;">';

                                                                        echo "</td>";
                                                                    }
                                                                    
                                                                    
                                                                }else if($valor3[$x][$y] == "oi2"){
                                                                    if($x==$linha3-1 && $y==$coluna3-1){
                                                                        echo '<td style="text-align:right;border-top: 0px;border-left: 0px;">';
                                                                        echo "</td>";
                                                                    }else{
                                                                        echo "<td>";
                                                                        echo "</td>";
                                                                    }
                                                                    
                                                                }else{
                                                                    echo '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div>';
                                                                        echo number_format($valor3[$x][$y],2,",",".");
                                                                    echo "</td>";
                                                                }
                                                                
                                                            }
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    
                                                    
                                                    </tbody>
                                                </table>
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row-fluid" style="margin-top:0;page-break-before: always">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Resumo (Valor Insumo)</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <?php 
                                        for($x=0;$x<$linha;$x++){
                                            for($y=0;$y<$coluna;$y++){
                                                if(!isset($valor[$x][$y])){
                                                    $valor[$x][$y] = "0";
                                                }
                                            }
                                        }
                                        for($x=1;$x<$linha;$x++){                        
                                            $valor[$x][$coluna]="oi";
                                        }

                                        for($y=1;$y<$coluna;$y++){
                                            $valor[$linha][$y]="oi";
                                        }
                                        $valor[$linha][$coluna]="oi";
                                        $coluna ++;
                                        $linha ++;
                                        for($x=1;$x<$linha;$x++){                        
                                            $valor[$x][$coluna]="0";
                                        }

                                        for($y=1;$y<$coluna;$y++){
                                            $valor[$linha][$y]="0";
                                        }
                                        $valor[$linha][0]="Total";
                                        $valor[0][$coluna]="Total";
                                        $valor[$linha][$coluna]="0";
                                        $valor[$linha-1][$coluna]="oi2";
                                        $valor[$linha][$coluna-1]="oi2";
                                        $coluna ++;
                                        $linha ++;

                                    ?>
                                    <div class="tab-pane active" >
                                        <div class="span12">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table  class="table table-bordered ">
                                                    <tbody>
                                                        <?php for($x=0;$x<$linha;$x++){
                                                            echo "<tr>";
                                                            
                                                            for($y=0;$y<$coluna;$y++){
                                                                if($x>0 && $y>0){
                                                                    if($x+2!=$linha && $y+2!=$coluna && $x!=$linha-1 && $y!=$coluna-1){
                                                                        $valor[$x][$coluna-1]=$valor[$x][$coluna-1]+$valor[$x][$y];
                                                                        $valor[$linha-1][$y]=$valor[$linha-1][$y]+$valor[$x][$y];
                                                                        $valor[$linha-1][$coluna-1] = $valor[$linha-1][$coluna-1]+$valor[$x][$y];
                                                                    }
                                                                }
                                                                if($x == 0 || $y==0){
                                                                    if($valor[$x][$y]=="oi"){
                                                                        echo '<th style="border-right: 1px solid #ddd"> ';
                                                                            
                                                                        echo "</th>";
                                                                    }else{
                                                                        echo "<th>";
                                                                            echo $valor[$x][$y];
                                                                        echo "</th>";
                                                                    }
                                                                    
                                                                }else if($valor[$x][$y]=="oi"){
                                                                    if(($y+2) == $coluna && ($x+2) == $linha){
                                                                        echo '<td style="text-align:right;border-top: 0px;border-left: 0px;background: white;width: 10px;">';

                                                                        echo "</td>";
                                                                    }else if(($y+2) == $coluna){
                                                                        echo '<td style="text-align:right;border-top: 0px;background: white;width: 10px;">';

                                                                        echo "</td>";
                                                                    }else if(($x+2) == $linha){
                                                                        echo '<td style="text-align:right;border-left: 0px;background: white;height: 10px;">';

                                                                        echo "</td>";
                                                                    }
                                                                    
                                                                    
                                                                }else if($valor[$x][$y] == "oi2"){
                                                                    if($x==$linha-1 && $y==$coluna-1){
                                                                        echo '<td style="text-align:right;border-top: 0px;border-left: 0px;">';
                                                                        echo "</td>";
                                                                    }else{
                                                                        echo "<td>";
                                                                        echo "</td>";
                                                                    }
                                                                    
                                                                }else{
                                                                    echo '<td style="text-align:right"><div style="text-align:left" class="span1">R$</div>';
                                                                        echo number_format($valor[$x][$y],2,",",".");
                                                                    echo "</td>";
                                                                }
                                                                
                                                            }
                                                            echo "</tr>";
                                                        }
                                                        
                                                        ?>
                                                    
                                                    
                                                    </tbody>
                                                </table>
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
    <div class="tab-pane" id="tab2">
        <?php if(isset($abertura)){
            if($abertura){?>
            <div class="row-fluid" style="margin-top:0;page-break-before: always">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Quantidade de O.S. que foram abertas por mês/ano e quais dessas O.S. já foram faturadas </h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">                            
                                    <div class="tab-pane active" >
                                        <div class="span12">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table  class="table table-bordered ">
                                                    <tbody>
                                                        <?php
                                                            echo '<tr>';
                                                                echo '<th>';
                                                                echo '</th>';
                                                                foreach($abertura as $ab){

                                                                    echo '<th>';
                                                                        $formatter = new IntlDateFormatter('pt_BR',
                                                                        IntlDateFormatter::FULL,
                                                                        IntlDateFormatter::NONE,
                                                                        'America/Sao_Paulo',
                                                                        IntlDateFormatter::GREGORIAN);
                                                                        $formatter->setPattern('MMMM');
                                                                        $month_name = $formatter->format(mktime(0, 0, 0, $ab->mes));
                                                                        echo ucfirst($month_name)."/".$ab->ano;
                                                                    echo '</th>';
                                                                    
                                                                }
                                                                echo '<th>';
                                                                    echo 'Total';
                                                                echo '</th>';
                                                            echo '</tr>';
                                                            echo '<tr>';
                                                            echo '<th>';                                                    
                                                                echo 'Faturadas / Aprovadas';
                                                            echo '</th>';
                                                            $somaFat = 0;
                                                            $somaApr = 0;
                                                            foreach($abertura as $ab){
                                                                echo '<td>';
                                                                    echo $ab->faturadas.' / '.$ab->aprovadas;
                                                                    $somaFat = $somaFat + $ab->faturadas;
                                                                    $somaApr = $somaApr + $ab->aprovadas;
                                                                echo '</td>';
                                                            }
                                                            echo '<td>';
                                                                echo $somaFat.' / '.$somaApr;
                                                            echo '</td>';
                                                            echo '</tr>';/*
                                                            echo '<tr>';
                                                            echo '<th>';                                                    
                                                                echo 'Valor à faturar';
                                                            echo '</th>';
                                                            $somaValAFat = 0;
                                                            foreach($abertura as $ab){
                                                                echo '<td>';
                                                                    echo "R$ ".number_format($ab->valor_aprovadas-$ab->valor_faturadas,2,",",".");
                                                                    $somaValAFat = $somaValAFat + $ab->valor_aprovadas-$ab->valor_faturadas;
                                                                echo '</td>';
                                                            }
                                                            echo '<td>';
                                                                echo "R$ ".number_format($somaValAFat,2,",",".");
                                                            echo '</td>';
                                                            echo '<tr>';
                                                            echo '<th>';                                                    
                                                                echo 'Valor Faturado';
                                                            echo '</th>';
                                                            $somaValFat = 0;
                                                            foreach($abertura as $ab){
                                                                echo '<td>';
                                                                    echo "R$ ".number_format($ab->valor_faturadas,2,",",".");
                                                                    $somaValFat = $ab->valor_faturadas+$somaValFat;
                                                                echo '</td>';
                                                            }
                                                            echo '<td>';                                                    
                                                                echo "R$ ".number_format($somaValFat,2,",",".");
                                                            echo '</td>';
                                                            echo '</tr>';*/
                                                            
                                                        ?>
                                                    
                                                    
                                                    </tbody>
                                                </table>
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                }
            }?>
    </div>
</div>
<script type="text/javascript">
    $('.datap').inputmask("date", {
        inputFormat: "dd/mm/yyyy",
        placeholder: "DD/MM/AAAA"
    });
    $(document).ready(function() {
        $(".datap").datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior'
        });
    })
    $(document).ready(function() {
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteCliente2",
            minLength: 1,
            select: function(event, ui) {
                $("#idCliente").val(ui.item.id);
            }
        });
    });
    /*
    $("#btnExport").click(function(e) {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('imprimirTable');
        
        $(table_div).prepend("<meta charset='UTF-8' /><style type='text/css'>"+
            "table {"+
            "margin: 0 auto;"+
            "}"+
            "table {"+
                "color: #333;"+
                "background: white;"+
                "border: 1px solid grey;"+
                "font-size: 12pt;"+
                "border-collapse: collapse;"+
                "}"+
                "table thead th,"+
                "table tfoot th {"+
            " color: #777;"+
            "background: rgba(0,0,0,.1);"+
            "}"+
            "table caption {"+
                "padding:.5em;"+
                "}"+
                "table th,"+
                "table td {"+
                    "padding: .5em;"+
                    "border: 1px solid lightgrey;"+
                    "}"+

                    "[data-table-theme*=zebra] tbody tr:nth-of-type(odd) {"+
                        "background: rgba(0,0,0,.05);"+
                        "}"+
                        "[data-table-theme*=zebra][data-table-theme*=dark] tbody tr:nth-of-type(odd) {"+
                            "background: rgba(255,255,255,.05);"+
                            "}"+

                            "[data-table-theme*=dark] {"+
                                "color: #ddd;"+
                                " background: #333;"+
                                "font-size: 12pt;"+
                                "border-collapse: collapse;"+
                                "}"+
                                "[data-table-theme*=dark] thead th,"+
                                "[data-table-theme*=dark] tfoot th {"+
                                    "color: #aaa;"+
                                    "background: rgba(0255,255,255,.15);"+
                                    "}"+
                                    "[data-table-theme*=dark] caption {"+
                                        "padding:.5em;"+
                                        "}"+
                                        "[data-table-theme*=dark] th,"+
                                        "[data-table-theme*=dark] td {"+
                                            "padding: .5em;"+
                                            "border: 1px solid grey;"+
                                            "}</style>");
        //var table_html = table_div.outerHTML.replace(/ /g, '%20');
        var table_html = encodeURIComponent(table_div.outerHTML.replaceAll('<div style="text-align:left" class="span1">R$</div>',""));
        a.href = data_type + ', ' + table_html;
        console.log(data_type + ', ' + table_html)
        a.download = 'filename.xls';
        a.click();
        e.preventDefault();
    });*/
    
    $("#btnExport").click(function(e) {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('imprimirTable');
        var mywindow = window.open('', 'SGI', 'height=600,width=800');
        mywindow.document.write('<html><head><title>SGI</title><meta charset="UTF-8" />')
        mywindow.document.write('</head><body >');
        mywindow.document.write("<style type='text/css'>"+
            "table {"+
            "margin: 0 auto;"+
            "}"+
            "table {"+
                "color: #333;"+
                "background: white;"+
                "border: 1px solid grey;"+
                "font-size: 12pt;"+
                "border-collapse: collapse;"+
                "}"+
                "table thead th,"+
                "table tfoot th {"+
            " color: #777;"+
            "background: rgba(0,0,0,.1);"+
            "}"+
            "table caption {"+
                "padding:.5em;"+
                "}"+
                "table th,"+
                "table td {"+
                    "padding: .5em;"+
                    "border: 1px solid lightgrey;"+
                    "}"+

                    "[data-table-theme*=zebra] tbody tr:nth-of-type(odd) {"+
                        "background: rgba(0,0,0,.05);"+
                        "}"+
                        "[data-table-theme*=zebra][data-table-theme*=dark] tbody tr:nth-of-type(odd) {"+
                            "background: rgba(255,255,255,.05);"+
                            "}"+

                            "[data-table-theme*=dark] {"+
                                "color: #ddd;"+
                                " background: #333;"+
                                "font-size: 12pt;"+
                                "border-collapse: collapse;"+
                                "}"+
                                "[data-table-theme*=dark] thead th,"+
                                "[data-table-theme*=dark] tfoot th {"+
                                    "color: #aaa;"+
                                    "background: rgba(0255,255,255,.15);"+
                                    "}"+
                                    "[data-table-theme*=dark] caption {"+
                                        "padding:.5em;"+
                                        "}"+
                                        "[data-table-theme*=dark] th,"+
                                        "[data-table-theme*=dark] td {"+
                                            "padding: .5em;"+
                                            "border: 1px solid grey;"+
                                            "}</style>");
        //var table_html = table_div.outerHTML.replace(/ /g, '%20');
        var table_html = table_div.outerHTML.replaceAll('<div style="text-align:left" class="span1">R$</div>',"");
        
        mywindow.document.write(table_html);
        mywindow.document.write('</body></html>');
        a.href = data_type + ', ' + encodeURIComponent(mywindow.document.firstChild.outerHTML);
        console.log(data_type + ', ' + table_html)
        a.download = 'filename.xls';
        a.click();
        mywindow.close();
        e.preventDefault();
        
    });
    
    $(document).ready(function() {
        $("#imprimir").click(function() {
            PrintElem('#imprimirTable');
        })

        function PrintElem(elem) {
            Popup($(elem).html());
        }

        function Popup(data) {
            var mywindow = window.open('', 'SGI', 'height=600,width=800');
            mywindow.document.write('<html><head><title>SGI</title><meta charset="UTF-8" />');
            /* mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/bootstrap.min.css' /><link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css' />");*/
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/tableimprimir.css' />");
            mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />');
            mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />');
            mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />');
            mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />');
            mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />');


            mywindow.document.write('</head><body >');
            mywindow.document.write(data);
            mywindow.document.write('</body></html>');

            mywindow.print();
            //mywindow.close();

            return true;
        }

    });
</script>