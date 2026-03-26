<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->

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

input:checked + .slider {
  background-color: #51a351;
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
                                                <th>Descrição</th>
                                                <th>Qtd.</th>
                                                <th>Valor Estimado</th>
                                                <th>Data Cadastro</th>     
                                                <th>Solicitado por</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($comprasSolicitadas as $r){	
                                                echo '<tr>';
                                                    if($r->aprovacaoPCP == 0 || empty($r->aprovacaoPCP)){
                                                        echo '<td><label class="switch"><input type="checkbox" name="checkPedidoCompra" id="checkPedidoCompra'.$r->idDistribuir.'" value="'.$r->idDistribuir.'"><span class="slider round"></span></label></td>';
                                                    }else{
                                                        echo '<td><label class="switch"><input type="checkbox" checked name="checkPedidoCompra" id="checkPedidoCompra'.$r->idDistribuir.'" value="'.$r->idDistribuir.'"><span class="slider round"></span></label></td>';
                                                    }
                                                    echo '<td>'.$r->idOs.'</td>';
                                                    echo '<td>'.$r->descricaoInsumo." ".$r->dimensoes.'</td>';
                                                    echo '<td>'.$r->quantidade.'</td>';
                                                    if(empty($r->valor_estimado)){
                                                        echo '<td>R$ 0,00</td>';
                                                    }else{
                                                        echo '<td>R$ '.number_format($r->valor_estimado, 2, ",", ".").'</td>';
                                                    }
                                                    echo '<td>'.date("d/m/Y H:i:s", strtotime($r->data_cadastro)).'</td>';
                                                    echo '<td>'.$r->nome.'</td>';
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
<script>
    $("input:checkbox[name=checkPedidoCompra]").click(function(){
        //console.log(this.checked);
        //console.log(this.value)
        //console.log(this)
        permCompra(this.value,this.checked);
    })
    function permCompra(pedidoCompraItens,checked){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/permsolcompra",
            type: 'POST',
            dataType: 'json',
            data: {
                idDistribuir:pedidoCompraItens,
                autorizacaoCompra:checked
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
</script>