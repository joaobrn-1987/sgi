<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<style>
    .wrapper {
        position: relative;
        width: 800px;
        height: 200px;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    img {
        position: absolute;
        left: 0;
        top: 62px;
    }

    .signature-pad {
        position: absolute;
        left: 0;
        top: 0;
        width:800px;
        height:200px;
    }
</style>


<form action="<?php echo base_url() ?>index.php/controle/saida" method="post" id="formSaida">
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Confirmar Saída</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                            <div class="tab-pane active">
                                
                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">                                        
                                        
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Status Saída: </label>
                                            <select class="span12 form-control" name="statusSaida" id="statusSaida">
                                            <?php foreach ($statusEtapa as $r) {
                                                if($r->ciclo == 4 || $r->ciclo == 5){
                                                    echo '<option value="' . $r->idStatusEtapasServico . '" >' . $r->descricaoStatusEtapaServico . '</option>';
                                                }
                                            } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="span5">
                                            <label for="cliente" class="control-label">Usuário:</label>
                                            <input class="span12" class="form-control" id="usuario" type="text" name="usuario" value="" />
                                            <input id="idUser" type="hidden" name="idUser" value="" />
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        
                                    </div>
                                </div>                          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div align='center' style="margin-top: 20px;">
        
            <a onclick="modalConfirmacaoEntrada()" class="btn btn-success"><i class="icon-white"></i>Confirmar</a>
        
    </div>
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Itens para saída</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs">                                
                                    <div class="widget-box" style="margin-top:0px">  
                                        <?php 
                                        $ultimo = 0;
                                        //echo json_encode($result);
                                        for($x=0;$x<count($result);$x++){

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
                                                        $result[$x]->idOrcamento.
                                                    '</td>'.
                                                    '<td>'. 
                                                        
                                                    '</td>'.
                                                    '<td>'. 
                                                        $result[$x]->pn.
                                                    '</td>'.
                                                    '<td>'. 
                                                        $result[$x]->descricao.
                                                    '</td>'.
                                                '</tr>';
                                                echo '<tr>'. 
                                                    '<td colspan=4 style="background-color: #efefef;padding-top: 0px; ">';                                                    
                                                        if(!empty($result[$x]->pnmaster)){
                                                            echo '<div style="margin: 20px;margin-top: 0px;">';
                                                                echo '<table class="table table-bordered ">';
                                                                    echo '<thead>';
                                                                        echo '<tr>';
                                                                            echo '<th>PN Master</th>';
                                                                            echo '<th>Descrição</th>';
                                                                            echo '<th>Quantidade</th>';
                                                                            echo '<th>Status Atual</th>';
                                                                            echo '<th>Local</th>';
                                                                        echo '</tr>';                                                                    
                                                                    echo '</thead>';
                                                                    echo '<tbody>';
                                                                        for($e=0;$e<count($result[$x]->pnmaster);$e++){
                                                                            echo '<tr>'. 
                                                                                '<td style="width:300px">'.
                                                                                    $result[$x]->pnmaster[$e]->pn.
                                                                                    '<input type="hidden" name="pnmaster[]" value="'.$result[$x]->pnmaster[$e]->idControleEtapa.'">'.
                                                                                '</td>'. 
                                                                                '<td>'. 
                                                                                    $result[$x]->pnmaster[$e]->descricao.
                                                                                '</td>'. 
                                                                                '<td style="width:80px">'. 
                                                                                    '<input type="text" name="quantidade_master[]" id="quantidade_master"class="span12" value="'.$result[$x]->pnmaster[$e]->quantidade.'">'.
                                                                                    '<input type="hidden" name="quantidade_master_real[]" id="quantidade_master_real"class="span12" value="'.$result[$x]->pnmaster[$e]->quantidade.'">'.
                                                                                
                                                                                '</td>'. 
                                                                                '<td style="width:300px">'. 
                                                                                    $result[$x]->pnmaster[$e]->descricaoStatusEtapaServico.
                                                                                '</td>'. 
                                                                                '<td style="width:150px">'.                                                                                    
                                                                                    $result[$x]->pnmaster[$e]->local.
                                                                                '</td>'.
                                                                            '</tr>';
                                                                        }
                                                                    echo '</tbody>';
                                                                echo '</table>';
                                                            echo '</div>';
                                                        }
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
                                                                    if(!empty($result[$x]->existenteSubitem)){
                                                                        for($e=0;$e<count($result[$x]->existenteSubitem);$e++){
                                                                            echo '<tr>'.
                                                                                '<td  style="width:300px">'. 
                                                                                    $result[$x]->existenteSubitem[$e]->pn.
                                                                                    '<input type="hidden" name="idControleSubItem[]" value="'.$result[$x]->existenteSubitem[$e]->idControleEtapaSubitem.'">'.
                                                                                '</td>'.
                                                                                '<td>'. 
                                                                                    $result[$x]->existenteSubitem[$e]->descricao.
                                                                                '</td>'.
                                                                                '<td style="width:80px">'. 
                                                                                    '<input type="text" name="quantidade[]" id="quantidade"class="span12" value="'.$result[$x]->existenteSubitem[$e]->quantidade.'">'.
                                                                                    '<input type="hidden" name="quantidade_real[]" id="quantidade_real"class="span12" value="'.$result[$x]->existenteSubitem[$e]->quantidade.'">'.
                                                                                '</td>'.
                                                                                '<td style="width:300px">'. 
                                                                                    $result[$x]->existenteSubitem[$e]->descricaoStatusEtapaServico.
                                                                                '</td>'.
                                                                                '<td style="width:150px">'. 
                                                                                    $result[$x]->existenteSubitem[$e]->local.
                                                                                '</td>'.
                                                                            '</tr>';
                                                                        }
                                                                    }
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
    <div align='center' style="margin-top: 20px;">
        
            <a onclick="modalConfirmacaoEntrada()" class="btn btn-success"><i class="icon-white"></i>Confirmar</a>
        
    </div>
    <input type="hidden" name="assinatura" id="assinatura">
</form>
<div id="modal-modalsaida" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Confirmar saída dos produtos</h5>
    </div>
    <div  class="modal-body">
        <p>Ao confirmar a saída dos itens informados, o status dos produtos passará a ser "<b id="statush5"></b>".</p> 
        <div class="wrapper">
            <div style="border-bottom: 2px solid black;height: 125px;margin-bottom: 10px;"></div>
            <canvas id="signature-pad" name="signature-pad" class="signature-pad" width=800 height=200></canvas>
            <div style="text-align:center">
            <h4>Assinatura</h4> 
            </div> 
        </div>
            
        <button type="" onclick="limparAssinatura()" style="margin-top:15px">Limpar</button><!--
        <button onclick="salvarAssinatura()">Salvar</button>-->
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <a class="btn btn-success" onclick="verificarAssinatura()">Confirmar</a>
    </div>
</div>
<script type="text/javascript">
    $("#usuario").autocomplete({
        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteFunc",
        minLength: 1,
        select: function(event, ui) {
            $('#idUser').val(ui.item.id);
        }
    })
    function modalConfirmacaoEntrada(){
        var quantidade = Array.apply(null,document.querySelectorAll("#quantidade_NovoItem"));
        var idUser = document.querySelector("#idUser").value;
        for(x=0;x<quantidade.length;x++){
            if(quantidade[x].value == null || quantidade[x].value == "" || quantidade[x].value == 0|| isNaN(quantidade[x].value)){
                alert("Informe a quantidade de cada item");
                return;
            }
        }
        if(idUser == null || idUser == "" ){
            alert("Informe o usuário que está retirando os itens");
            return;
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
        $("#statush5").append($( "#statusSaida option:selected" ).text());
        $("#modal-modalsaida").modal('show');
    }
</script>
<script type="text/javascript">
    
    var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
        backgroundColor: 'rgba(255, 255, 255, 0)',
        penColor: 'rgb(0, 0, 0)'
    });
    var saveButton = document.getElementById('save');
    var cancelButton = document.getElementById('clear');
    /*
    saveButton.addEventListener('click', function (event) {
        var data = signaturePad.toDataURL('image/png');

        // Send data to server instead...
        window.open(data);
    });

    cancelButton.addEventListener('click', function (event) {
        signaturePad.clear();
    });*/
    function verificarAssinatura(){
        var data = signaturePad.toDataURL('image/png');
        if(signaturePad.isEmpty()){
            alert("Assinatura não preenchida");
            return;
        }
        var divisao = data.split(",");
        $("#assinatura").val(data);
        $('#formSaida').submit();

    }
    function limparAssinatura(){
        signaturePad.clear();
    }
    function salvarAssinatura(){
        var data = signaturePad.toDataURL('image/png');

        // Send data to server instead...
        window.open(data);
    }
</script>