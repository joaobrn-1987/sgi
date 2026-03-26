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
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 20px;
}

table.comBordas {
    border: 0px solid White;
}

table.comBordas td {
    border: 1px solid grey;
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
</style><!--
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Orçamento</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Cliente: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Solicitante: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Descrição Produto: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Ref.: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    <div class="span3" class="control-group">
                                        <label for="idGrupoServico" class="control-label">TAG: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Ordem de Compra</a></li>
    <li><a href="#tab2" data-toggle="tab">Histórico de Aprovação</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab1">
        <form action="<?php echo base_url() ?>index.php/suprimentos/autorizacao/1" method="post" name="form1" id="form1">
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
                                        <div class="span12" id="divCadastrarOs">
                                            <div class="span12" style="padding: 1%; margin-left: 0">
                                                <div class="span2" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">O.C.: </label>
                                                    <input type="text" name="idOCFiltro" class="span12" value=""/>
                                                </div>  
                                                                                    
                                            </div>
                                            <div class="span12" style="padding: 1%; margin-left: 0px">
                                                <div class="span2" class="control-group">
                                                    <button class="btn btn-success">Filtrar</button>
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
        </form>
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Compras</h5>
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
                                                        <th>O.C.</th>
                                                        <th>Fornecedor</th> 
                                                        <th>Valor Total</th> 
                                                        <th>Pagamento</th>
                                                        <th>Cond. de Pag.</th>
                                                        <th>Data Cadastro</th> <!--   
                                                        <th>Autorizado por</th>
                                                        <th>Data Autorização</th> -->
                                                        <th>Aprovar</th>
                                                        <th>Rejeitar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($listaPedidos as $r){
                                                        echo '<tr class="trpai'.$r->idPedidoCompra.'">';
                                                            echo '<td onclick="openclose(this,'.$r->idPedidoCompra.')" style="text-align: center;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';
                                                            
                                                            $itens = explode(";",$r->idPedidoCompraItens);
                                                            foreach($itens as $b){
                                                                echo '<input type="hidden" name="idPedidoCompraItens" id="idPedidoCompraItens'.$r->idPedidoCompra.'" value="'.$b.'">';
                                                            }
                                                            echo '<input  type="hidden" name="checkPedidoCompra" id="checkPedidoCompra'.$r->idPedidoCompra.'">';                                                    
                                                            echo '<td>'.$r->idPedidoCompra.'</td>';
                                                            echo '<td>'.$r->nomeFornecedor.'</td>';
                                                            echo '<td>R$ '.number_format($r->soma,2,',','.').'</td>';
                                                            echo '<td>' . $r->nomePgto . '</td>';
                                                            echo '<td>' . $r->condPgto . '</td>';
                                                            echo '<td>'.date("d/m/Y H:i:s", strtotime($r->data_cadastro)).'</td>';/*
                                                            echo '<td></td>';
                                                            if(!empty($r->data_autorizacao)){
                                                                echo '<td>'.date("d/m/Y H:i:s", strtotime($r->data_autorizacao)).'</td>';
                                                            }else{
                                                                echo '<td></td>';
                                                            }*/

                                                            //if($r->autorizadoCompra == 0 || empty($r->autorizadoCompra)){
                                                                echo '<td style="text-align:center"><label class="switch"><input type="checkbox" name="checkPedidoCompra" id="checkPedidoCompra'.$r->idPedidoCompra.'" value="'.$r->idPedidoCompra.'"><span class="slider round"></span></label></td>';
                                                            //}else{
                                                            //    echo '<td style="text-align:center"><label class="switch"><input type="checkbox" checked disabled name="checkPedidoCompra" id="checkPedidoCompra'.$r->idPedidoCompra.'" value="'.$r->idPedidoCompra.'"><span class="slider round"></span></label></td>';
                                                            //}
                                                            echo '<td style="text-align:center"><a onclick="openRejeitarOs('.$r->idPedidoCompra.')" orc="" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a></td>';

                                                            
                                                        echo '</tr>';
                                                        echo '<tr class="trfilho'.$r->idPedidoCompra.'" style="display:none">';
                                                            echo '<td colspan=9 style="background-color: #efefef;padding-top: 0px;">';
                                                                echo '<div style="margin: 20px;margin-top: 0px;">';
                                                                    echo '<table class="table table-bordered ">';
                                                                        echo '<thead>';
                                                                            echo '<tr>';
                                                                                echo '<th>O.S.</th>';
                                                                                //echo '<th>Cliente</th>';
                                                                                echo '<th>O.S. Status</th>';
                                                                                echo '<th>Descrição</th>';
                                                                                echo '<th>Quantidade</th>';
                                                                                echo '<th>Status</th>';
                                                                                echo '<th>Valor Unit.</th>';
                                                                                echo '<th>Valor Total</th>';
                                                                                echo '<th>Solicitado Por</th>';
                                                                                echo '<th>Autorizado PCP</th>';
                                                                                echo '<th>Data Autorizado PCP</th>';/*
                                                                                echo '<th>Autorizado Sup.</th>';
                                                                                echo '<th>Data Autorizado Sup.</th>';
                                                                                echo '<th>Autorizado Fin.</th>';
                                                                                echo '<th>Data Autorizado Fin.</th>';*/
                                                                                echo '<th>Aprovar</th>';
                                                                                echo '<th>Rejeitar</th>';
                                                                            echo '</tr>';                                                                    
                                                                        echo '</thead>';
                                                                        echo '<tbody>';
                                                                        //echo '<script>console.log('.json_encode($r->itens).')</script>';
                                                                            foreach($r->itens as $i){
                                                                                echo '<tr>';                                                                                                
                                                                                    echo '<td><a title="Clique aqui para visualizar as informações da O.S." style="cursor:pointer" onclick="openModalInfoOS(' . $i->idOs . ')"><b>' . $i->idOs . '</b></a></td>';                                                                           
                                                                                    //echo '<td>'.$i->nomeCliente.'</td>';
                                                                                    echo '<td>'.$i->nomeStatusOs.'</td>';                                      
                                                                                    echo '<td>'.$i->descricaoInsumo.'</td>';
                                                                                    echo '<td>'.$i->quantidade.'</td>';
                                                                                    echo '<td>'.$i->nomeStatus.'</td>'; 
                                                                                    echo '<td>R$ '.number_format($i->valor_unitario, 2, ",", ".").'</td>';
                                                                                    echo '<td>R$ '.number_format($i->valor_unitario*$i->quantidade, 2, ",", ".").'</td>';                                                                            
                                                                                    echo '<td>'.$i->nome.'</td>';
                                                                                    echo '<td>'.$i->nomeUserPCP.'</td>';
                                                                                    if(!empty($i->data_autorizacaoPCP)){
                                                                                        echo '<td>'.date("d/m/Y", strtotime($i->data_autorizacaoPCP)).'</td>';
                                                                                    }else{
                                                                                        echo '<td></td>';
                                                                                    }/*
                                                                                    echo '<td>'.$i->nomeUserSUP.'</td>';
                                                                                    if(!empty($i->data_autorizacaoSUP)){
                                                                                        echo '<td>'.date("d/m/Y", strtotime($i->data_autorizacaoSUP)).'</td>';
                                                                                    }else{
                                                                                        echo '<td></td>';
                                                                                    }
                                                                                    echo '<td>'.$i->nomeUserFIN.'</td>';
                                                                                    if(!empty($i->data_autorizacao)){
                                                                                        echo '<td>'.date("d/m/Y", strtotime($i->data_autorizacao)).'</td>';
                                                                                    }else{
                                                                                        echo '<td></td>';
                                                                                    }*/
                                                                                    if($i->rejeitado == 0){
                                                                                        if($i->autorizadoCompra == 1){
                                                                                            echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" checked disabled name="checkPedidoCompraItens" id="checkPedidoCompraItens'.$r->idPedidoCompra.'" value="'.$i->idPedidoCompraItens.'"><span class="slider round"></span></label></td>';    
                                                                                        }else{
                                                                                            echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" name="checkPedidoCompraItens" id="checkPedidoCompraItens'.$r->idPedidoCompra.'" value="'.$i->idPedidoCompraItens.'"><span class="slider round"></span></label></td>';                                                                        
                                                                                        }     
                                                                                        echo '<input type="hidden" name="checkDistribuir" id="checkDistribuir'.$r->idPedidoCompra.'" value="'.$i->idDistribuir.'">';
                                                                                        echo '<td><a onclick="openRejeitarItem('.$i->idDistribuir.','.$i->idOs.')" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a></td>';
                                                                                    }else{
                                                                                        echo '<td></td><td></td>';
                                                                                    }
                                                                                    
            
                                                                                echo '</tr>';
                                                                            }
                                                                            
                                                                        echo '</tbody>';
                                                                    echo '</table>';
                                                                echo '</div>';
                                                            echo '</td>';
                                                        echo '</tr>';
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
    </div>
    <div class="tab-pane" id="tab2">
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Histórico de Compras</h5>
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
                                                        <th>O.C.</th>
                                                        <th>Fornecedor</th> 
                                                        <th>Valor Total</th> 
                                                        <th>Data Cadastro</th>
                                                        <!--   
                                                        <th>Autorizado por</th>
                                                        <th>Data Autorização</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($histAutorizacao as $r){
                                                        echo '<tr class="trhistpai'.$r->idPedidoCompra.'">';
                                                            echo '<td onclick="openclose2(this,'.$r->idPedidoCompra.')" style="text-align: center;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';
                                                        
                                                            
                                                            echo '<td>'.$r->idPedidoCompra.'</td>';
                                                            echo '<td>'.$r->nomeFornecedor.'</td>';
                                                            echo '<td> </td>';
                                                            echo '<td>'.date("d/m/Y H:i:s", strtotime($r->data_cadastro)).'</td>';/*
                                                            echo '<td></td>';
                                                            if(!empty($r->data_autorizacao)){
                                                                echo '<td>'.date("d/m/Y H:i:s", strtotime($r->data_autorizacao)).'</td>';
                                                            }else{
                                                                echo '<td></td>';
                                                            }*/
                                                            
                                                        echo '</tr>';
                                                        echo '<tr class="trhistfilho'.$r->idPedidoCompra.'" style="display:none">';
                                                            echo '<td colspan=8 style="background-color: #efefef;padding-top: 0px;">';
                                                                echo '<div style="margin: 20px;margin-top: 0px;">';
                                                                    echo '<table class="table table-bordered ">';
                                                                        echo '<thead>';
                                                                            echo '<tr>';
                                                                                echo '<th>O.S.</th>';
                                                                                //echo '<th>Cliente</th>';
                                                                                echo '<th>O.S. Status</th>';
                                                                                echo '<th>Descrição</th>';
                                                                                echo '<th>Quantidade</th>';
                                                                                echo '<th>Status</th>';
                                                                                echo '<th>Valor Unit.</th>';
                                                                                echo '<th>Valor Total</th>';
                                                                                echo '<th>Solicitado Por</th>';
                                                                                echo '<th>Autorizado PCP</th>';
                                                                                echo '<th>Data Autorizado PCP</th>';
                                                                                echo '<th>Aut. Diretoria</th>';
                                                                                echo '<th>Data Autorizado</th>';
                                                                            echo '</tr>';
                                                                        echo '</thead>';
                                                                        echo '<tbody>';
                                                                            //echo '<script>console.log('.json_encode($r->itens).')</script>';
                                                                            foreach($r->itens as $i){
                                                                                echo '<tr>';
                                                                                    echo '<td><a title="Clique aqui para visualizar as informações da O.S." style="cursor:pointer" onclick="openModalInfoOS(' . $i->idOs . ')"><b>' . $i->idOs . '</b></a></td>';
                                                                                    //echo '<td>'.$i->nomeCliente.'</td>';
                                                                                    echo '<td>'.$i->nomeStatusOs.'</td>';                                                       
                                                                                    echo '<td>'.$i->descricaoInsumo.'</td>';
                                                                                    echo '<td>'.$i->quantidade.'</td>';
                                                                                    echo '<td>'.$i->nomeStatus.'</td>'; 
                                                                                    echo '<td>R$ '.number_format($i->valor_unitario, 2, ",", ".").'</td>';
                                                                                    echo '<td>R$ '.number_format($i->valor_unitario*$i->quantidade, 2, ",", ".").'</td>';                                                                            
                                                                                    echo '<td>'.$i->nome.'</td>';
                                                                                    echo '<td>'.$i->nomeUserPCP.'</td>';
                                                                                    if(!empty($i->data_autorizacaoPCP)){
                                                                                        echo '<td>'.date("d/m/Y", strtotime($i->data_autorizacaoPCP)).'</td>';
                                                                                    }else{
                                                                                        echo '<td></td>';
                                                                                    }
                                                                                    echo '<td>'.$i->nomeUserFIN.'</td>';
                                                                                    if(!empty($i->data_autorizacao)){
                                                                                        echo '<td>'.date("d/m/Y", strtotime($i->data_autorizacao)).'</td>';
                                                                                    }else{
                                                                                        echo '<td></td>';
                                                                                    }
                                                                                    
                                                                                echo '</tr>';
                                                                            }
                                                                            
                                                                        echo '</tbody>';
                                                                    echo '</table>';
                                                                echo '</div>';
                                                            echo '</td>';
                                                        echo '</tr>';
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
    </div>
</div>

<div id="modal-rejeitarOs" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Rejeitar Compra.</h5>
  </div>
  <div class="modal-body">
    <h5 style="text-align: center">Deseja realmente rejeitar a ordem de compa <b id="rejeitarOs_b"></b>?</h5>
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
                                            '<td align="left"><b>Cliente:</b></td>'+
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
    $("input:checkbox[name=checkPedidoCompraItens]").click(function(){
        //console.log(this.checked);
        //console.log(this.value)
        //console.log(this)           
        permCompra(this.value,this.checked);
        this.disabled = this.checked;
        alert("Compra aprovada com sucesso.")
       
    })
    $("input:checkbox[name=checkPedidoCompra]").click(function(){
        //console.log(this.checked);
        //console.log(this.value)
        //console.log(this)
        var arrayItens = Array.apply(null,document.querySelectorAll("#idPedidoCompraItens"+this.value))
        var arrayItens2 = Array.apply(null,document.querySelectorAll("#checkPedidoCompraItens"+this.value));
        arrayItens.forEach((elemento)=>{
            elemento.checked = this.checked;
            elemento.disabled = this.checked;
            permCompra(elemento.value,this.checked);
        })
        arrayItens2.forEach((elemento)=>{            
            elemento.checked = true;
            elemento.disabled = true;
        })
        this.disabled = this.checked;
        alert("Compra aprovada com sucesso.")
       
    })
    function permCompra(pedidoCompraItens,checked){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/permcompra",
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {
                idPedidoCompraItens:pedidoCompraItens,
                autorizacaoCompra:checked
            },
            success: function(data) {
                console.log(pedidoCompraItens+"/"+checked)
                if(data.result){
                    console.log(data.msggg)
                   
                }
            },
            error: function(xhr, textStatus, error) {
                window.location.herf = "<?php echo base_url();?>mapos/login"
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
        alert("Itens rejeitado com sucesso.")
        $("#modal-rejeitarItem").modal("hide")
    }
    function openRejeitarOs(id){
        $("#rejeitarOs_b").empty()
        $("#rejeitarOs_b").append(id)
        $('#rejeitarIdOs').val(id)
        $("#modal-rejeitarOs").modal("show")
    }
    function rejeitarOs(){
        var idOs = $('#rejeitarIdOs').val();
        var arrayItens = Array.apply(null,document.querySelectorAll("#checkDistribuir"+idOs))
        arrayItens.forEach((elemento)=>{
            //elemento.attr("disabled",true);
            rejeitar(elemento.value);
        })
        $("#modal-rejeitarOs").modal("hide")
        alert("Itens rejeitado com sucesso.")
    }    
    function openRejeitarItem(id,os){
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
        var html = "O.S.:"+os+" | Qtd: "+resultado.quantidade+" | "+resultado.descricaoInsumo
        $("#rejeitarItem_b").empty()
        $("#rejeitarItem_b").append(html)
        $('#rejeitarIdDist').val(id)
        $("#modal-rejeitarItem").modal("show")
    }
    function rejeitarItem(){
        var idDistribuir = $('#rejeitarIdDist').val();
        rejeitar(idDistribuir);
        alert("Item rejeitado com sucesso.")
        $("#modal-rejeitarItem").modal("hide")
    }
</script>