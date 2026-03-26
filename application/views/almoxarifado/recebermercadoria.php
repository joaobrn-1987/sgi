<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Recebimento</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <form action="<?php echo base_url() ?>index.php/almoxarifado/buscaroc" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Nº Ordem de Compra: </label>
                                            <input type="text" class="span12" id="idOc" name="idOc" value="" />
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label"></label>
                                            <button  class="btn btn-success"
                                                onclick="" name="fEntradaI" id="fEntradaI" style="justify-content: flex-end; display: table; margin-top:20px">Buscar</button>
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
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Materiais</h5>
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
                                                <th>O.S.</th>
                                                <th>Unid. Exec.</th>
                                                <th>Descrição</th>
                                                <th>Quantidade</th>
                                                <th>Qtd. Entrada</th>
                                                <th>NF</th><!--
                                                <th>Status</th>-->
                                            </tr>
                                            <tr>
                                                <th ></th>
                                                <th colspan="6"></th>
                                                <th><input class="span12" type="text" name="notaFiscalAll" id="notaFiscalAll"></th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($materiais))foreach($materiais as $r){
                                                echo '<tr>';
                                                    echo '<td><input type="checkbox" name="checkDistribuir" id="checkDistribuir" value="'.$r->idDistribuir.'"/></td>';                   
                                                    echo '<td>'.$r->idPedidoCompra.'</td>';
                                                    echo '<td>'.$r->idOs.'<input type="hidden" name="idPedidoCompraItens" id="idPedidoCompraItens" value="'.$r->idPedidoCompraItens.'"/></td>';
                                                    echo '<td>'.$r->status_execucao.'</td>';
                                                    echo '<td>';
                                                    $html = $r->descricaoInsumo;
                                                    if(!empty($r->dimensoes)){
                                                        $html.=" ".$r->dimensoes;
                                                    } 
                                                    if(!empty($r->comprimento)){
                                                        $html.=" X ".$r->comprimento." MM";
                                                    } 
                                                    if(!empty($r->volume)){
                                                        $html.=" ".$r->volume." ML";
                                                    } 
                                                    if(!empty($r->peso)){
                                                        $html.=" ".$r->peso." G";
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
                                                    echo '<td><input type="hidden" name="quantidade" id="quantidade" value="'.$r->quantidade.'"/>'.$r->quantidade.'</td>';                                                    
                                                    echo '<td><input class="span12" type="text" name="qtdRecebida" id="qtdRecebida" value="'.$r->quantidade.'"/></td>';
                                                    echo '<td><input class="span12" type="text" name="notaFiscal" id="notaFiscal"></td>';
                                                    //echo '<td>'.$r->nomeStatus.'</td>';                                                    
                                                   
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
<div class="span12">
    <div style="text-align: center;">
        <a type="button" class="btn btn-success" onclick="salvarAlmoxarifado()">Finalizar</a>
    </div>
</div>
<script>
 
    $(document).ready(function () {
        $('#notaFiscalAll').keyup(function(){
           for(var x=0;x<document.querySelectorAll("#notaFiscal").length;x++){
                document.querySelectorAll("#notaFiscal")[x].value = this.value;
           } 
        });
        $('#locallAll').keyup(function(){
           for(var x=0;x<document.querySelectorAll("#locall").length;x++){
                document.querySelectorAll("#locall")[x].value = this.value;
           } 
        });
        $('#localnAll').keyup(function(){
           for(var x=0;x<document.querySelectorAll("#localn").length;x++){
                document.querySelectorAll("#localn")[x].value = this.value;
           } 
        });
        $('#idDepartamentoAll').change(function(){
           for(var x=0;x<document.querySelectorAll("#idDepartamento").length;x++){
                document.querySelectorAll("#idDepartamento")[x].value = this.value;
           } 
        });
        $('#idEmpresaAll').change(function(){
           for(var x=0;x<document.querySelectorAll("#idEmpresa").length;x++){
                document.querySelectorAll("#idEmpresa")[x].value = this.value;
           } 
        });
    })
    function salvarAlmoxarifado(){
        var check = Array.apply(null,document.querySelectorAll("#checkDistribuir"));
        var idPedidoCompraItens = Array.apply(null,document.querySelectorAll("#idPedidoCompraItens"));
        var quantidade = Array.apply(null,document.querySelectorAll("#quantidade"));
        var qtdRecebida = Array.apply(null,document.querySelectorAll("#qtdRecebida"));
        
        var notaFiscal = Array.apply(null,document.querySelectorAll("#notaFiscal"));
        //var idLocal = Array.apply(null,document.querySelectorAll("#idLocal"));
        var counta = 0;
        var counta2 = 0;
        for(x = 0;x<check.length;x++){
            if(check[x].checked){
                counta ++;
                if(parseInt(quantidade[x].value) < parseInt(qtdRecebida[x].value)){
                    alert("A quantidade recebida não pode ser maior que a quantidade comprada.");
                    return;
                }
                if(parseInt(qtdRecebida[x].value) < 0){
                    alert("A quantidade recebida não pode ser 0.");
                    return;
                }
            }
        }
        for(x = 0;x<check.length;x++){
            if(check[x].checked){
                idDistribuir = check[x].value;
                
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/almoxarifado/confirmarMercadoria",
                    type: 'POST',
                    dataType: 'json',
                    async: false,
                    data: {
                        idDistribuir:idDistribuir,
                        idPedidoCompraItens:idPedidoCompraItens[x].value,
                        objeto:x/**/,
                        nf:notaFiscal[x].value,
                        qtdRecebida:qtdRecebida[x].value
                    },
                    success: function(data) {
                        counta2++;
                        if(data.result){
                            $(check[data.objeto]).closest('tr').remove();
                        }
                        
                    },
                    error: function(xhr, textStatus, error) {
                        console.log(xhr.responseText);
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(error);
                        counta2++
                    },
                })
                if(counta2 == counta){
                    alert("Itens cadastrados com sucesso.");
                }
            }
        }        
    }
</script>