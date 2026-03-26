<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<form action="<?php echo base_url() ?>index.php/controle/entrada" method="post" id="formEntrada">
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Confirmar Entrada</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                            <div class="tab-pane active">
                                
                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">                                        
                                        
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Status Entrada: </label>
                                            <select class="span12 form-control" name="statusEntrada" id="statusEntrada">
                                            <?php foreach ($statusEtapa as $r) {
                                                if($r->ciclo == 2 || $r->ciclo == 3){
                                                    echo '<option value="' . $r->idStatusEtapasServico . '" '.($r->ciclo == 3?"selected":"").'>' . $r->descricaoStatusEtapaServico . '</option>';
                                                }
                                                
                                            } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <a onclick="modalConfirmacaoEntrada()" class="btn btn-success"><i class="icon-white"></i>Confirmar</a>
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
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Itens da entrada</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs">                                
                                    <div class="widget-box" style="margin-top:0px">  
                                        <?php 
                                        $ultimo = 0;
                                        for($x=0;$x<count($listaOrc_item);$x++){
                                            
                                            if($ultimo != 0 && $idControleEtapa[$x] != $ultimo){                                            
                                                echo "<br>";
                                            }
                                            echo '<table id="tableHistVale" class="table table-bordered " style="border: 1px solid #b0b0b0;">'.
                                            '<thead>'.
                                                '<tr>'.
                                                    '<th>'.
                                                        'Orc.'.
                                                    '</th>'.
                                                    '<th>'.
                                                        'Cliente.'.
                                                    '</th>'.
                                                    '<th>'.
                                                        'PN.'.
                                                    '</th>'.
                                                    '<th>'.
                                                        'Descrição.'.
                                                    '</th>'.
                                                '</tr>'.
                                            '</thead>'. 
                                            '<tbody>'.
                                                '<tr style="background-color: #efefef;">'. 
                                                    '<td>'. 
                                                        $orc_item[$x]->idOrcamentos.
                                                    '</td>'.
                                                    '<td>'. 
                                                        
                                                    '</td>'.
                                                    '<td>'. 
                                                        $orc_item[$x]->pn.
                                                    '</td>'.
                                                    '<td>'. 
                                                        $orc_item[$x]->descricao.
                                                    '</td>'.
                                                '</tr>'. 
                                                '<tr>'. 
                                                    '<td colspan=4 style="background-color: #efefef;padding-top: 0px; ">';
                                                        echo '<div style="margin: 20px;margin-top: 0px;">';
                                                            echo '<table class="table table-bordered ">';
                                                                echo '<thead>';
                                                                    echo '<tr>';
                                                                        echo '<th>PN</th>';
                                                                        echo '<th>Descrição</th>';
                                                                        echo '<th>Quantidade</th>';
                                                                        echo '<th>Status Atual</th>';
                                                                        echo '<th>Local</th>';
                                                                    echo '</tr>';                                                                    
                                                                echo '</thead>';
                                                                echo '<tbody>';
                                                                    foreach($controleSubitens as $r){
                                                                        if($r->idControleEtapa == $idControleEtapa[$x]){
                                                                            echo '<tr>'.
                                                                                '<td  style="width:300px">'. 
                                                                                    $r->pn.
                                                                                    '<input type="hidden" name="idControleSubItem[]" value="'.$r->idControleEtapaSubitem.'">'.
                                                                                '</td>'.
                                                                                '<td>'. 
                                                                                    $r->descricao.
                                                                                '</td>'.
                                                                                '<td style="width:80px">'. 
                                                                                    '<input type="text" name="quantidade[]" id="quantidade"class="span12" value="'.$r->quantidade.'">'.
                                                                                    '<input type="hidden" name="quantidade_real[]" id="quantidade_real"class="span12" value="'.$r->quantidade.'">'.
                                                                                '</td>'.
                                                                                '<td style="width:300px">'. 
                                                                                    $r->descricaoStatusEtapaServico.
                                                                                '</td>'.
                                                                                '<td style="width:150px">'. 
                                                                                    '<input type="text" name="local[]" id="local"class="span12" value="">'.
                                                                                '</td>'.
                                                                            '</tr>';
                                                                        }
                                                                    }
                                                                    do{
                                                                        $ultimo = $idControleEtapa[$x];
                                                                        echo '<tr>'.
                                                                            '<td  style="width:300px">'. 
                                                                                $produtos[$x]->pn.
                                                                                '<input type="hidden" name="idProduto[]" value="'.$produtos[$x]->idProdutos.'">'.
                                                                                '<input type="hidden" name="idControleEtapa_NovoItem[]" value="'.$idControleEtapa[$x].'">'.
                                                                            '</td>'.
                                                                            '<td>'. 
                                                                                $produtos[$x]->descricao.
                                                                            '</td>'.
                                                                            '<td style="width:80px">'. 
                                                                                '<input type="text" name="quantidade_NovoItem[]" id="quantidade_NovoItem"class="span12">'.
                                                                            '</td>'.
                                                                            '<td style="width:300px">'. 
                                                                                'Não controlado'.
                                                                            '</td>'.
                                                                            '<td style="width:150px">'. 
                                                                                '<input type="text" name="local_NovoItem[]" id="local_NovoItem"class="span12">'.
                                                                            '</td>'.
                                                                        '</tr>';
                                                                        $x++;
                                                                    }while(count($produtos)>$x && $ultimo == $idControleEtapa[$x]);
                                                                echo '</tbody>';
                                                            echo '</table>';
                                                        echo '</div>';
                                                    echo '</td>';
                                                echo '</tr>';
                                            echo '</tbody>';
                                            echo '</table>';
                                        
                                        }?>    
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
<div id="modal-modalentrada" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Confirmar entrada dos produtos</h5>
    </div>
    <div  class="modal-body">
        <p>Ao confirmar a entrada dos itens informados, o status dos produtos passará a ser "<b id="statush5"></b>".</p>        
        
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <a class="btn btn-success" onclick="$('#formEntrada').submit()">Confirmar</a>
    </div>
</div>
<script type="text/javascript">
    function modalConfirmacaoEntrada(){
        var quantidade = Array.apply(null,document.querySelectorAll("#quantidade_NovoItem"));
        for(x=0;x<quantidade.length;x++){
            if(quantidade[x].value == null || quantidade[x].value == "" || quantidade[x].value == 0|| isNaN(quantidade[x].value)){
                alert("Informe a quantidade de cada item");
                return;
            }
        }
        var quantidade2 = Array.apply(null,document.querySelectorAll("#quantidade"));
        var quantidade_real = Array.apply(null,document.querySelectorAll("#quantidade_real"));
        for(x=0;x<quantidade2.length;x++){
            if(quantidade2[x].value == null || quantidade2[x].value == "" || quantidade2[x].value == 0|| isNaN(quantidade2[x].value)){
                alert("Informe a quantidade de cada item");
                return;
            }
            if(quantidade2[x].value > quantidade_real[x].value){
                alert("A quantidade informada não pode ser maior que a quantidade registrada");
                return;
            }
        }
        $("#statush5").empty();
        $("#statush5").append($( "#statusEntrada option:selected" ).text());
        $("#modal-modalentrada").modal('show');
    }
</script>
