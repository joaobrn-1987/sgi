<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->

<style type="text/css">

table.comBordas {
    border: 0px solid White;
}

table.comBordas td {
    border: 1px solid grey;
}
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
  background-color: #51a351;
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

input:checked + .slider {
  background-color: #ccc;
}

input:focus + .slider {
  box-shadow: 0 0 1px #51a351;
}

input:checked + .slider:before {
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

/*slider2 */

.slider2 {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #0087ff;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider2:before {
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

input:checked + .slider2 {
  background-color: #ccc;
}

input:focus + .slider2 {
  box-shadow: 0 0 1px #0087ff;
}

input:checked + .slider2:before {
  -webkit-transform: translateX(20px);
  -ms-transform: translateX(20px);
  transform: translateX(20px);
}

/* Rounded sliders */
.slider2.round {
  border-radius: 34px;
}

.slider2.round:before {
  border-radius: 50%;
}
</style>
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Ordem de serviços</a></li>
    <li><a href="#tab2" data-toggle="tab">Histórico de Aprovação</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab1">
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Solicitação de Compras</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">                                
                                        <div class="widget-box" style="margin-top:0px">                                        
                                            <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>O.S.</th>
                                                        <th>Qtd.</th>
                                                        <th>Descrição</th>
                                                        <th>Status O.S.</th>
                                                        <th>Valor Total </br> (Itens Aguard. Aprov.)</th>
                                                        <th>Data Finalizado</th>
                                                        <th>Aprov. Emergencial</th>
                                                        <th>Aprovar</th>
                                                        <th>Rejeitar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($comprasSolicitadas as $r){	
                                                        echo '<tr class="trpai'.$r->idOs.'">';
                                                            echo '<td onclick="openclose(this,'.$r->idOs.')" style="text-align: center;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';
                                                        
                                                            echo '<td><a title="Clique aqui para visualizar as informações da O.S." style="cursor:pointer" onclick="openModalInfoOS(' . $r->idOs . ')"><b>' . $r->idOs . '</b></a></td>';
                                                            echo '<td>'.$r->qtd_os.'</td>';
                                                            echo '<td>'.$r->descricao_item.'</td>';
                                                            echo '<td>'.$r->nomeStatusOs.'</td>';
                                                            echo '<td>R$ '.number_format($r->valorTotal, 2, ",", ".").'</td>';
                                                            //echo '<td>'.date("d/m/Y", strtotime($r->data_fechadoPCP)).'</td>';
                                                            echo '<td></td>';
                                                            echo '<td style="text-align:center">';
                                                                $verificarEmergencia = false;
                                                                if(isset($r->itens)){
                                                                    for($x=0;$x<count($r->itens);$x++){
                                                                        if(!empty($r->itens[$x]->valor_unitario) && $r->itens[$x]->etapa==3){
                                                                            if($r->itens[$x]->valor_unitario*$r->itens[$x]->quantidade<=1000 && $r->itens[$x]->aprovacaoPCP == 0){
                                                                                $verificarEmergencia = true;
                                                                            }
                                                                        }
                                                                    }/**/
                                                                }/**/
                                                                if($verificarEmergencia){
                                                                    echo '<label class="switch"><input type="checkbox" onchange="aprovacaoEmergencialOs('.$r->idOs.',this)" id="checkEmergencia" value="'.$r->idOs.'"><span class="slider2 round"></span></label>';
                                                                    //echo'<a  class="btn" style="background-color:#0087ff;color:white" onclick="aprovacaoEmergencialOs('.$r->idOs.',this)">Aprov.</a>';  
                                                                }                                                                     
                                                            echo '</td>';
                                                            //if($r->aprovacaoPCP == 0 || empty($r->aprovacaoPCP)){
                                                                echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" name="checkOs" id="checkOs'.$r->idOs.'" value="'.$r->idOs.'"><span class="slider round"></span></label></td>';
                                                            /*}else{
                                                                echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" checked disabled name="checkOs" id="checkOs'.$r->idOs.'" value="'.$r->idOs.'"><span class="slider round"></span></label></td>';
                                                            }*/
                                                            echo '<td><a onclick="openRejeitarOs('.$r->idOs.')" orc="" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a></td>';
                                                        echo '</tr>';
                                                        echo '<tr class="trfilho'.$r->idOs.'" style="display:none">';
                                                            echo '<td colspan=9 style="background-color: #efefef;padding-top: 0px;">';
                                                                echo '<div style="margin: 20px;margin-top: 0px;">';
                                                                    echo '<table class="table table-bordered ">';
                                                                        echo '<thead>';
                                                                            echo '<tr>';/*
                                                                                echo '<th>Estoque</th>';*/
                                                                                echo '<th>O.C.</th>';
                                                                                echo '<th>Data Ag. Aut.</th>';
                                                                                echo '<th>Insumo</th>';
                                                                                echo '<th>Quantidade</th>';
                                                                                echo '<th>Valor Total</th>';
                                                                                echo '<th>Status</th>';
                                                                                echo '<th>Prev. Entr.</th>';
                                                                                echo '<th>Data Cadastro</th>';
                                                                                //echo '<th>Valor Unit.</th>';
                                                                                //echo '<th>Valor Total</th>';
                                                                                echo '<th>Compra solicitada</th>';/*
                                                                                echo '<th>Data Finalizado</th>';
                                                                                echo '<th>Autorizado PCP</th>';
                                                                                echo '<th>Data Autorizado PCP</th>';*/
                                                                                echo '<th>Aprov. Emergencial</th>';
                                                                                echo '<th>Aprovar</th>';
                                                                                echo '<th>Rejeitar</th>';
                                                                            echo '</tr>';                                                                    
                                                                        echo '</thead>';
                                                                        echo '<tbody>';
                                                                        if(isset($r->itens)){
                                                                            $tot = count($r->itens);
                                                                            for($x=0;$x<$tot;$x++){/*
                                                                                $pedidocompra = $this->pedidocompra_model->getInsumosByIdDistribuir($r->itens[$x]->idDistribuir); 
                                                                                if(!empty($pedidocompra)){
                                                                                    $estoque2 = $this->pedidocompra_model->getRelatorioPorInsumoEmpresa($pedidocompra->idInsumos,$pedidocompra->idOs);
                                                                                }*/
                                                                                
                                                                                
                                                                                echo '<tr>';/*
                                                                                    if(!empty($estoque2)){?>
                                                                                        <td style="text-align: center;"><a style="position: absolute;" href="#modal-estoque-<?php echo $r->itens[$x]->idDistribuir; ?>" style="margin-right: 1%" role="button" data-toggle="modal" class="btn tip-top" ><i class="icon-eye-open"></i></a></td><?php 
                                                                                    }else{
                                                                                        echo '<td></td>';
                                                                                    }*/
                                                                                    echo '<td><a title="Clique aqui para visualizar as informações da O.C." style="cursor:pointer" onclick="openModalInfoOC(' . $r->itens[$x]->idPedidoCompra . ')" ><b>'.$r->itens[$x]->idPedidoCompra.'</b></a></td>';
                                                                                    echo '<td>'.(!isset($r->itens[$x]->data_enviadopcp)?"":date("d/m/Y", strtotime($r->itens[$x]->data_enviadopcp))).'</td>';
                                                                                    //echo "<script type='text/javascript'>console.log(\"ins: ".count($ins).", dim:".count($dim).", X: ".$x." dist:".count($dist).", distId:".$dist[$x]."\")</script>";
                                                                                    echo '<td>'.$r->itens[$x]->descricaoInsumo." ".(!isset($r->itens[$x]->dimensoes)?"":$r->itens[$x]->dimensoes).'</td>';
                                                                                    echo '<td>'.$r->itens[$x]->quantidade.'</td>';
                                                                                    echo '<td>R$ '.number_format($r->itens[$x]->quantidade*$r->itens[$x]->valor_unitario, 2, ",", ".").'</td>';
                                                                                    echo '<td>'.$r->itens[$x]->nomeStatus.'</td>';
                                                                                    echo '<td>'.(!isset($r->itens[$x]->previsao_entrega)?"":date("d/m/Y", strtotime($r->itens[$x]->previsao_entrega))).'</td>';
                                                                                    echo '<td>'.(!isset($r->itens[$x]->data_cadastro)?"":date("d/m/Y", strtotime($r->itens[$x]->data_cadastro))).'</td>';/*
                                                                                    echo '<td>R$ '.number_format($valor_unit[$x], 2, ",", ".").'</td>';
                                                                                    echo '<td>R$ '.number_format($valor_unit[$x]*$qtd[$x], 2, ",", ".").'</td>';*/
                                                                                    echo '<td>'.$r->itens[$x]->nome.'</td>';/*
                                                                                    if(isset($r->itens[$x]->data_finaliziado))
                                                                                        echo '<td>'.date("d/m/Y", strtotime($r->itens[$x]->data_finalizado)).'</td>';
                                                                                    else
                                                                                        echo '<td></td>';
                                                                                    echo '<td>'.$r->itens[$x]->nomeUserPCP.'</td>';
                                                                                    if(!empty($r->itens[$x]->data_autorizacaoPCP)){
                                                                                        echo '<td>'.date("d/m/Y", strtotime($r->itens[$x]->data_autorizacaoPCP)).'</td>';
                                                                                    }else{
                                                                                        echo '<td></td>';
                                                                                    }*/
                                                                                    if($r->itens[$x]->etapa == 3){
                                                                                        echo '<td style="text-align:center">';
                                                                                        if($r->itens[$x]->valor_unitario*$r->itens[$x]->quantidade <=1000 && $r->itens[$x]->aprovacaoPCP == 0)
                                                                                            echo '<label class="switch"><input type="checkbox" id="checkEmergenciaFilho'.$r->idOs.'" onchange="aprovacaoEmergencial('.$r->itens[$x]->idDistribuir.',this,'.$r->idOs.')" ><span class="slider2 round"></span></label><input type="hidden" id="distribuirOsEmergencia'.$r->idOs.'" value="'.$r->itens[$x]->idDistribuir.'">';
                                                                                        //echo'<a class="btn" style="background-color:#0087ff;color:white" onclick="aprovacaoEmergencial('.$dist[$x].',this)">Aprov.</a><input type="hidden" id="distribuirOsEmergencia'.$r->idOs.'" value="'.$dist[$x].'">';
                                                                                        echo '</td>';
                                                                                        if($r->itens[$x]->aprovacaoPCP == 0 || empty($r->itens[$x]->aprovacaoPCP)){
                                                                                            echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" name="checkPedidoCompra" id="checkPedidoCompra'.$r->idOs.'" value="'.$r->itens[$x]->idDistribuir.'"><span class="slider round"></span></label></td>';
                                                                                        }else{
                                                                                            echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" checked disabled name="checkPedidoCompra" id="checkPedidoCompra'.$r->idOs.'" value="'.$r->itens[$x]->idDistribuir.'"><span class="slider round"></span></label></td>';
                                                                                        }
                                                                                        echo '<td><a onclick="openRejeitarItem('.$r->itens[$x]->idDistribuir.')" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a></td>';
                                                                                    }else{
                                                                                        echo '<td></td>';
                                                                                        echo '<td></td>';
                                                                                        echo '<td></td>';
                                                                                    }
                                                                                    
                                                                                    
                                                                                echo '</tr>';
                                                                            }
                                                                        }
                                                                        echo '</tbody>';
                                                                    echo '</table>';
                                                                echo '</div>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                    }?>								
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
    </div>
    <div class="tab-pane" id="tab2">
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Histórico de aprovação</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">                                
                                        <div class="widget-box" style="margin-top:0px">                                        
                                            <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>O.S.</th>
                                                        <th>Qtd.</th>
                                                        <th>Descrição</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($histAprovacao as $r){	
                                                        echo '<tr class="trhistpai'.$r->idOs.'">';
                                                            echo '<td onclick="openclose2(this,'.$r->idOs.')" style="text-align: center;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';
                                                        
                                                            echo '<td><a title="Clique aqui para visualizar as informações da O.S." style="cursor:pointer" onclick="openModalInfoOS(' . $r->idOs . ')"><b>' . $r->idOs . '</b></a></td>';
                                                            echo '<td>'.$r->qtd_os.'</td>';
                                                            echo '<td>'.$r->descricao_item.'</td>';
                                                        echo '</tr>';
                                                        echo '<tr class="trhistfilho'.$r->idOs.'" style="display:none">';
                                                            echo '<td colspan=8 style="background-color: #efefef;padding-top: 0px;">';
                                                                echo '<div style="margin: 20px;margin-top: 0px;">';
                                                                    echo '<table class="table table-bordered ">';
                                                                        echo '<thead>';
                                                                            echo '<tr>';
                                                                                echo '<th>Estoque</th>';
                                                                                echo '<th>Insumo</th>';
                                                                                echo '<th>Quantidade</th>';
                                                                                echo '<th>Status</th>';
                                                                                echo '<th>Data Cadastro</th>';
                                                                                //echo '<th>Valor Unit.</th>';
                                                                                //echo '<th>Valor Total</th>';
                                                                                echo '<th>Compra solicitada</th>';
                                                                                echo '<th>Data Finalizado</th>';
                                                                                echo '<th>Autorizado PCP</th>';
                                                                                echo '<th>Data Autorizado PCP</th>';
                                                                            echo '</tr>';                                                                    
                                                                        echo '</thead>';
                                                                        echo '<tbody>';
                                                                        if(isset($r->idDistribuir)){
                                                                            $tot = count(explode("?/",$r->idDistribuir));
                                                                            $dist = explode("?/",$r->idDistribuir);
                                                                            $dim = explode("?/",$r->dimensoes);
                                                                            $qtd = explode("?/",$r->qtd);
                                                                            $dtCad = explode("?/",$r->data_cadastro);
                                                                            $ins = explode("?/",$r->descricaoInsumo);
                                                                            $nome = explode("?/",$r->nomeUsuario);
                                                                            $aprov = explode("?/",$r->aprovacaoPCP);
                                                                            $valor_unit = explode("?/",$r->valor_unitario);
                                                                            $status = explode("?/",$r->nomeStatus);
                                                                            $etapaStatus = explode("?/",$r->etapaStatus);
                                                                            //$data_finalizado = explode(";",$r->data_finalizado);
                                                                            $data_autorizacaoPCP = explode("?/",$r->data_autorizacaoPCP);
                                                                            $nomeUserPCP = explode("?/",$r->nomeUserPCP);
                                                                            for($x=0;$x<$tot;$x++){
                                                                                $contador = 0;
                                                                                $estoque2 = "";
                                                                                $contador = $contador+1;/*
                                                                                $pedidocompra = $this->pedidocompra_model->getInsumosByIdDistribuir($dist[$x]); 
                                                                                if(!empty($pedidocompra)){
                                                                                    $estoque2 = $this->pedidocompra_model->getRelatorioPorInsumoEmpresa($pedidocompra->idInsumos,$pedidocompra->idOs);
                                                                                }      */                                                                  
                                                                                echo '<tr>';
                                                                                    if(!empty($estoque2)){?>
                                                                                        <td style="text-align: center;"></td><?php 
                                                                                    }else{
                                                                                        echo '<td></td>';
                                                                                    }
                                                                                    echo '<td>'.$ins[$x]." ".(!isset($dim[$x])?"":$dim[$x]).'</td>';
                                                                                    echo '<td>'.$qtd[$x].'</td>';
                                                                                    echo '<td>'.$status[$x].'</td>';
                                                                                    echo '<td>'.(!isset($dtCad[$x])?"":date("d/m/Y", strtotime($dtCad[$x]))).'</td>';/*
                                                                                    echo '<td>R$ '.number_format($valor_unit[$x], 2, ",", ".").'</td>';
                                                                                    echo '<td>R$ '.number_format($valor_unit[$x]*$qtd[$x], 2, ",", ".").'</td>';*/
                                                                                    echo '<td>'.$nome[$x].'</td>';
                                                                                    if(isset($data_finalizado[$x]))
                                                                                        echo '<td>'.date("d/m/Y", strtotime($data_finalizado[$x])).'</td>';
                                                                                    else
                                                                                        echo '<td></td>';
                                                                                    echo '<td>'.$nomeUserPCP[$x].'</td>';
                                                                                    if(!empty($data_autorizacaoPCP[$x])){
                                                                                        echo '<td>'.date("d/m/Y", strtotime($data_autorizacaoPCP[$x])).'</td>';
                                                                                    }else{
                                                                                        echo '<td></td>';
                                                                                    }
                                                                                    
                                                                                    
                                                                                echo '</tr>';
                                                                            }
                                                                        }
                                                                        echo '</tbody>';
                                                                    echo '</table>';
                                                                echo '</div>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                    }?>								
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
    </div>
</div>
<div id="modal-rejeitarOs" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Rejeitar Compra.</h5>
  </div>
  <div class="modal-body">
    <h5 style="text-align: center">Deseja realmente rejeitar a compra de materiais para a O.S. <b id="rejeitarOs_b"></b>?</h5>
    <input type="hidden" id="rejeitarIdOs" value="">
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <a class="btn btn-danger" onclick="rejeitarOs()">Confirmar</a>
  </div>
</div>
<div id="modal-rejeitarItem" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Rejeitar Compra.</h5>
  </div>
  <div class="modal-body">   
    <h5 style="text-align: center">Deseja realmente rejeitar a compra desse item?</h5>    
    <input type="hidden" id="rejeitarIdDist" value="">
    <p style="text-align: center;" id="rejeitarItem_b"></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <a class="btn btn-danger" onclick="rejeitarItem()">Confirmar</a>
  </div>
</div>

<div id="modal-autorizacaoemergencial" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Autorizar a compra.</h5>
  </div>
  <div class="modal-body">   
    <h5 style="text-align: center">Deseja realmente autorizar a compra emergencial desse item?</h5>    
    <input type="hidden" id="idDistribuir_emergencia"  value="">
    <p style="text-align: center;" id="autorizacaoEmergencialItem"></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <a class="btn btn-danger" onclick="confirmarAprovacaoEmergencial()">Confirmar</a>
  </div>
</div>
<div id="modal-autorizacaoemergencialos" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Autorizar a compra.</h5>
  </div>
  <div class="modal-body">   
    <h5 style="text-align: center">Deseja realmente autorizar a compra emergencial dos itens dessa O.S. <b id="bEmergenciaOs"></b>?</h5>    
    <div id="divItensDistribuir">
    </div>
    <p style="text-align: center;" id="autorizacaoEmergencialItem"></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <a class="btn btn-danger" onclick="confirmarAprovacaoEmergencialOs()">Confirmar</a>
  </div>
</div>

<div id="modal-os" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Informações da O.S.: <b id="bInfoOS"></b> </h5>
    </div>
    <div>
        <div class="row-fluid" style="margin-top: 0px">
            <div class="span12">                
                <div class="">
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0;background-color: #f9f9f9;">
                            <div class="container-fluid" style="margin-top: 20px;" id="divInfoOS">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-oc" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Informações da O.C.: <b id="bInfoOC"></b> </h5>
    </div>
    <div>
        <div class="widget-content nopadding" style="overflow-y: scroll;height: 500px;">
            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="span12" id="divCadastrarOs">                                
                            <div class="widget-box" style="margin-top:0px">                                        
                                <table id="tableOC" class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>OS</th>
                                            <th>Unid. Exec.</th>
                                            <th>Alter. Status</th>
                                            <th>Qtd.</th>
                                            <th>Descrição</th>
                                            <th>Solicitação Material</th>
                                            <th>Status</th>
                                            <th>Usuário Ag. Orç.</th>
                                            <th>Data Pedido</th>
                                            <th>Usuário Ped.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
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
<?php /*
    foreach ($comprasSolicitadas as $r) {
        for($x=0;$x<count($r->itens);$x++){ ?>
        <div id="modal-estoque-<?php echo $r->itens[$x]->idDistribuir; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <form action="<?php echo base_url() ?>index.php/suprimentos/reservaritensalmoxarifado" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 id="myModalLabel">Quantidade em Estoque</h5>
                </div>
                <?php
                    $estoque2 = "";
                    $pedidocompra = $this->pedidocompra_model->getInsumosByIdDistribuir($r->itens[$x]->idDistribuir); 
                    if(!empty($pedidocompra)){
                        $estoque2 = $this->pedidocompra_model->getRelatorioPorInsumoEmpresa($pedidocompra->idInsumos,$pedidocompra->idOs);
                    }
                ?>
                
                <div class="modal-body">
                    
                        <input type="hidden" name="idprodutocompraitens" id="" value="<?php echo $r->itens[$x]->idDistribuir; ?>">
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
                                    <th><!--
                                        Reservar Estq. Qtd.
                                    </th>-->
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
                                            //echo '<td>';
                                            //    echo "<input type='text' name='retiradaEstoque[]' id='retiradaEstoque[]'>";
                                            //echo '</td>';
                                        echo '</tr>';
                                    } 
                                ?>
                            </tbody>
                        </table>      
                                                          
                    
                </div><!--
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button class="btn btn-danger">Salvar</button>
                </div>     -->          
            </form>

        </div><?php 
        }
     }*/?>
<script>
    setTimeout(function() {
        window.location.href = "<?php echo base_url()?>";
    }, 240000);
    function openclose(td,valor){
        var tr = document.querySelector(".trfilho"+valor);        
        if(tr.style.display == "table-row" || tr.style.display == ""){
            $(".trfilho"+valor).hide('fast');
            $(td).parent('tr').css('background-color', '');
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");            
        }else{
            $(".trfilho"+valor).show('fast');
            $(td).parent('tr').css('background-color', '#efefef');
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }       
    }
    function openclose2(td,valor){
        var tr = document.querySelector(".trhistfilho"+valor);
        
        if(tr.style.display == "table-row" || tr.style.display == ""){
            $(".trhistfilho"+valor).hide('fast');
            $(td).parent('tr').css('background-color', '');
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");            
        }else{
            $(".trhistfilho"+valor).show('fast');
            $(td).parent('tr').css('background-color', '#efefef');
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }       
    }
    function openModalInfoOC(idPedidoCompra) {
        
        //$("#modal-oc").modal("show");
        
        
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/carregarinfooc",
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {
                idPedidoCompra: idPedidoCompra
            },
            success: function(data) {
                if(data.result)
                    carregarinfoModalOc(data.resultado);
                    
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        })
    }
    function openModalInfoOS(idOs) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/os/carregarinfoos",
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {
                idOs: idOs
            },
            success: function(data) {
                if(data.result)
                    carregarinfoModal(data.resultado);
                    
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        })
    }

    function carregarinfoModal(item){
        $("#divInfoOS").empty()
        html = '<table class="comBordas" width="36%" align="left">'+
            '<tr>'+
                '<td align="center">'+
                    'O.S. Número: <font size="5">'+item.idOs+'</font>'+
                '</td>'+
                '<td align="center">';
                    data = new Date(item.data_abertura);
                    visualData = moment(data).format('DD/MM/YYYY')
                    html+='Data: </b>'+visualData+'</td>';
                html += '<td align="center">'+
                    'Unid. Exec.: </b>'+item.status_execucao+'</td>'+
            '</tr>'+
        '</table>'+
        '<div class="row-fluid">'+
            '<div class="span12">'+
                '<div class="widget-box">'+
                    '<div class="widget-content nopadding">'+
                        '<table width="100%" border="0" style="border-style:solid; border: 1px solid grey;font-family:Arial, Helvetica, sans-serif;font-size:12px;">'+
                            '<tr>'+
                                '<td align="center">'+
                                    '<table width="100%" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;   line-height: 20px;">'+
                                        '<tr>'+
                                            '<td align="left">Descrição:</td>'+
                                            '<td style="width: 50%">'+item.descricao_item+'</td>'+
                                            '<td align="left">Cliente:</td>'+
                                            '<td><b>'+item.nomeCliente+'</b></td>'+
                                        '</tr>'+
                                        '<tr>'+
                                            '<td align="left" width="13%"> Qtd.: </td>'+
                                            '<td>'+item.qtd_os+'</td>'+
                                            '<td align="left" width="13%">Orçamento: </td>'+
                                            '<td>'+item.idOrcamentos+'</td>'+
                                        '</tr>'+
                                        '<tr>'+
                                            '<td align="left">'+
                                                '<h5>PN:</h5>'+
                                            '</td>'+
                                            '<td>'+
                                                '<h5>'+item.pn+'</h5>'+
                                            '</td>';
                                            if(item.data_reagendada && item.data_reagendada != ""){
                                                data = new Date(item.data_reagendada);
                                                visualData = moment(data).format('DD/MM/YYYY')
                                                html += '<td align="left">Data Reagendada:</td>'+
                                                '<td colspan="3">'+visualData+'</td>';
                                            }else if(item.data_entrega && item.data_entrega != ""){
                                                data = new Date(item.data_entrega);
                                                visualData = moment(data).format('DD/MM/YYYY')
                                                html += '<td align="left">Data Entrega:</td>'+
                                                '<td colspan="3">'+visualData+'</td>';
                                            }
                                            
                                        html += '</tr>'+
                                    '</table>'+
                                '</td>'+
                            '</tr>'+
                        '</table>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
        $("#divInfoOS").append(html)
        $("#modal-os").modal("show");
    }

    function carregarinfoModalOc(item){
        var table = document.getElementById("tableOC").getElementsByTagName('tbody')[0];
        var html = "";
        for(x=0;x<item.length;x++){
            html += "<tr>";
                html += "<td>"+item[x].idOs+"</td>";
                html += "<td>"+item[x].status_execucao+"</td>";
                data_alteracao = new Date(item[x].data_alteracao);
                html += "<td>"+data_alteracao.toLocaleDateString('pt-BR', {
                    timeZone: 'UTC',
                })+"</td>";
                html += "<td>"+item[x].quantidade+"</td>";
                if(item[x].dimensoes){
                    html += "<td>"+item[x].descricaoInsumo+" "+item[x].dimensoes+"</td>";
                }else{
                    html += "<td>"+item[x].descricaoInsumo+"</td>";
                }    
                data_cadastro = new Date(item[x].data_cadastro);          
                html += "<td>"+data_cadastro.toLocaleDateString('pt-BR', {
                    timeZone: 'UTC',
                })+"</td>";
                html += "<td>"+item[x].nomeStatus+"</td>";
                html += "<td>"+item[x].nomeAgOrc+"</td>";
                data_pedido = new Date(item[x].cadpedgerado);
                html += "<td>"+data_pedido.toLocaleDateString('pt-BR', {
                    timeZone: 'UTC',
                })+"</td>";
                html += "<td>"+item[x].user+"</td>";
            html += "</tr>";
        }    
            
        $("#bInfoOC").empty()
        $("#tableOC tbody").empty();
        $("#bInfoOC").append(item[0].idPedidoCompra)
        $("#tableOC tbody").append(html);
        
        $("#modal-oc").modal("show");
    }

    $("input:checkbox[name=checkOs]").click(function(){
            console.log(this.checked);
            console.log(this.value)
            //console.log(this)
            var arrayItens = Array.apply(null,document.querySelectorAll("#checkPedidoCompra"+this.value))
            arrayItens.forEach((elemento)=>{
                if(!elemento.disabled){
                    elemento.checked = this.checked;
                    permCompra(elemento.value,this.checked);
                }
                
            })
            if(this.checked){
                alert("Item aprovado com Sucesso");
                this.disabled = true;
            }
        })
    $("input:checkbox[name=checkPedidoCompra]").click(function(){
        //console.log(this.checked);
        //console.log(this.value);
        //console.log(this);
        permCompra(this.value,this.checked);
        alert("Item aprovado com Sucesso");
    })
    function permCompra(pedidoCompraItens,checked){
        var status = 10;
        if(checked){
            status = 16;
        }
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/permsolcompra",
            type: 'POST',
            dataType: 'json',
            data: {
                idDistribuir:pedidoCompraItens,
                autorizacaoCompra:checked,
                status:status
            },
            success: function(data) {
                console.log(pedidoCompraItens+"/"+checked)
                if(data.result){
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
    function rejeitar(idDistribuir){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/rejeitaritem",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idDistribuir:idDistribuir
            },
            success: function(data) {
                
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }
    function openRejeitarOs(id){
        $("#rejeitarOs_b").empty()
        $("#rejeitarOs_b").append(id)
        $('#rejeitarIdOs').val(id)
        $("#modal-rejeitarOs").modal("show")
    }
    function rejeitarOs(){
        var idOs = $('#rejeitarIdOs').val();
        var arrayItens = Array.apply(null,document.querySelectorAll("#checkPedidoCompra"+idOs))
        arrayItens.forEach((elemento)=>{
            //elemento.attr("disabled",true);
            rejeitar(elemento.value);
        })
        alert("Itens rejeitado com sucesso.")
    }    
    function openRejeitarItem(id){
        var resultado = ""
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/getdistribuirdetail",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idDistribuir:id
            },
            success: function(data) {
                resultado = data.objDistribuir
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
        var html = "Qtd: "+resultado.quantidade+" | "+resultado.descricaoInsumo
        $("#rejeitarItem_b").empty()
        $("#rejeitarItem_b").append(html)
        $('#rejeitarIdDist').val(id)
        $("#modal-rejeitarItem").modal("show")
    }
    function rejeitarItem(){
        var idDistribuir = $('#rejeitarIdDist').val();
        rejeitar(idDistribuir);
        alert("Item rejeitado com sucesso.")
    }
    var buttonglobal = ""
    function aprovacaoEmergencial(id,button,os){
        var resultado = ""
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/getdistribuirdetail",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idDistribuir:id
            },
            success: function(data) {
                resultado = data.objDistribuir
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
        button.checked = false;
        buttonglobal = button;
        var html = "O.S.:"+os+" | Qtd: "+resultado.quantidade+" | "+resultado.descricaoInsumo;
        $("#autorizacaoEmergencialItem").empty()
        $("#autorizacaoEmergencialItem").append(html)
        $('#idDistribuir_emergencia').val(id)
        $("#modal-autorizacaoemergencial").modal("show")
    }
    function aprovacaoEmergencialOs(id,button){
        var arrayItens = Array.apply(null,document.querySelectorAll("#distribuirOsEmergencia"+id))
        var resultado = ""
        arrayItens.forEach((elemento)=>{
            resultado += '<input type="hidden" id="idDistribuir_emergenciaOs" value="'+elemento.value+'">';            
        })
        button.checked =false;
        buttonglobal = button;
        $("#divItensDistribuir").empty()
        $("#bEmergenciaOs").empty()
        $("#bEmergenciaOs").append(id);
        $("#divItensDistribuir").append(resultado)
        $("#modal-autorizacaoemergencialos").modal("show")
    }
    function disabledAndCheckedInputItens(id){
        var arrayItens = Array.apply(null,document.querySelectorAll("#checkEmergenciaFilho"+id))
        var arrayItens2 = Array.apply(null,document.querySelectorAll("#checkPedidoCompra"+id))
        arrayItens.forEach((elemento)=>{
            elemento.checked = true;
            elemento.disabled = true;
            
        })
        arrayItens2.forEach((elemento)=>{
            elemento.checked = true;
            elemento.disabled = true;
            
        })
    }
    function confirmarAprovacaoEmergencial(){
        var idDistribuir = $('#idDistribuir_emergencia').val();
        var arrayItens = [];
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/confirmaraprovacaoemergencial",
            type: 'POST',
            dataType: 'json',
            data: {
                idDistribuir:idDistribuir
            },
            success: function(data) {
                idOs = buttonglobal.id.replace("checkEmergenciaFilho","");
                arrayItens = Array.apply(null,document.querySelectorAll("#checkPedidoCompra"+idOs))
                arrayItens.forEach((elemento)=>{
                    if(elemento.value == idDistribuir){
                        elemento.checked = true;
                        elemento.disabled = true;
                    }
                    
                })
                buttonglobal.checked = true;
                buttonglobal.disabled = true;
                //$(buttonglobal).remove()
                alert(data.msg);
                $("#modal-autorizacaoemergencial").modal("hide")
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }
    function confirmarAprovacaoEmergencialOs(){
        var arrayItens = Array.apply(null,document.querySelectorAll("#idDistribuir_emergenciaOs"));
        var resultado = "";
        arrayItens.forEach((elemento)=>{
            verificar = "";
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/suprimentos/confirmaraprovacaoemergencial",
                type: 'POST',
                dataType: 'json',
                async:false,
                data: {
                    idDistribuir:elemento.value
                },
                success: function(data) {
                    
                    resultado = data.msg;
                },
                error: function(xhr, textStatus, error) {
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },
            })
        })
        buttonglobal.checked = true;
        buttonglobal.disabled = true;
        disabledAndCheckedInputItens(buttonglobal.value);
        //$(buttonglobal).remove()
        alert(resultado);
        $("#modal-autorizacaoemergencialos").modal("hide")
    }
</script>