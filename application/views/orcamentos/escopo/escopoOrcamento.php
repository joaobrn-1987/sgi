<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />
<style>
    .tdExibirPedido{
        width:100%; 
        border:1px solid #EEEEEE;
    }
</style>
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
</style>

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
                                        <input type="text" class="span12"  value="<?php echo $orcamentoItem->idOrcamentos;?>" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Cliente: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->nomeCliente;?>" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Solicitante: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->nome;?>" readonly />
                                    </div>
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">PN (master): </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->pn;?>" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Descrição Produto: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->descricao;?>" readonly />
                                    </div>
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Ref.: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->referencia;?>" readonly />
                                    </div>
                                    <div class="span3" class="control-group">
                                        <label for="idGrupoServico" class="control-label">TAG: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->tag;?>" readonly />
                                    </div>
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span4" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Total Serviço: </label>
                                        <input type="text" class=" span12" id="totalServico" value="<?php if(isset($orcServicoEscopoItens)){$valorServ = 0;foreach($orcServicoEscopoItens as $r){if($r->descricaoClasse == "Serviço"){$valorServ += $r->valorUnitario*$r->quantidade;}} echo "R$ ".number_format($valorServ, 3, ",", ".");}?>" readonly />
                                    </div>
                                    <div class="span4" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Total Peças: </label>
                                        <input type="text"  class=" span12"id="totalPecas" value="<?php if(isset($orcServicoEscopoItens)){$valorPec = 0;foreach($orcServicoEscopoItens as $r){if($r->descricaoClasse == "Peça"){$valorPec += $r->valorUnitario*$r->quantidade;}} echo "R$ ".number_format($valorPec, 3, ",", ".");}?>" readonly />
                                    </div>
                                    <div class="span4" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Total da Reforma:</label>
                                        <input type="text" class=" span12" id="totalReforma" value="<?php if(isset($orcServicoEscopoItens)){$valorTot = 0;foreach($orcServicoEscopoItens as $r){$valorTot += $r->valorUnitario*$r->quantidade;} echo "R$ ".number_format($valorTot, 3, ",", ".");}?>" readonly />
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
        <form class="form-inline" action="<?php echo base_url() ?>index.php/peritagem/criarperitagemorc" method="post" id="formPeritag">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <input type="hidden" class="span12" name="idProdutoEsc" id="idProdutoEsc" value="<?php echo $orcamentoItem->idProdutos;?>" />
            <input type="hidden" class="span12" name="tipoServico" id="tipoServico" value="<?php echo $orcamentoItem->tipoProd;?>" />
            <input type="hidden" class="span12" name="idOrcItem" id="idOrcItem" value="<?php echo $orcamentoItem->idOrcamento_item;?>" />
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Escopo Técnico</h5>
                    <span style="padding: 3px 10px 3px 11px;">                    
                        <input type="text" style="margin-top:0px;"  <?php if(!isset($servicoEscopo)){echo 'placeholder="Nome Escopo"';}?> name="descricaoEscopo" id="descricaoEscopo" value="<?php if(isset($servicoEscopo)){echo $servicoEscopo->nomeServicoEscopo;}?>" <?php if(isset($servicoEscopo)){echo 'readonly';}?>/>   
                        <input type="hidden" style="margin-top:0px;" name="idEscopo" id="idEscopo" value="<?php if(isset($servicoEscopo)){echo $servicoEscopo->idServicoEscopo;}?>" />                 
                    </span>
                    <span style="padding: 3px 10px 3px 11px;">
                        <a class="btn btn-mini btn-inverse" href="<?php echo base_url().'index.php/orcamentos/escopoprint/'.$orcamentoItem->idOrcamento_item?>"><i class="icon-print icon-white"></i> Imprimir</a>
                    </span>
                    <span style="padding: 3px 10px 3px 11px;">
                        <select name="idStatusEscopo" id="idStatusEscopo">
                            <?php foreach($statusPeritagem as $r){ ?>
                                <option value="<?php echo $r->idStatusEscopo ?>" <?php if(!empty($orcServicoEscopo)){if($r->idStatusEscopo == $orcServicoEscopo->idStatusEscopo){echo "selected";}} ?>><?php echo $r->descricaoEscopo ?></option>
                            <?php
                            } ?>
                        </select>
                    </span>
                    <span style="padding: 9px 10px 7px 11px;float: right;">                    
                        Ocultar Dimensões <input type="checkbox" style="margin-top:0px;" id="checkPerit" name="checkPerit"/>                    
                    </span>
                    <span style="padding: 9px 10px 7px 11px;float: right;">                    
                        Ocultar Valores <input type="checkbox" style="margin-top:0px;" id="checkValores" name="checkValores"/>                    
                    </span>
                    <span style="padding: 9px 10px 7px 11px;float: right;">                    
                        Ocultar não Sel.. <input type="checkbox" style="margin-top:0px;" id="checkSel" name="checkSel"/>                    
                    </span>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs">                                
                                    <div class="widget-box" style="margin-top:0px">                                        
                                        <table id="table_id" class="table table-bordered " >
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">SUB PN</th>
                                                    <th rowspan="2">Descrição</th>
                                                    <th rowspan="2">Classe</th>
                                                    <th "class="classPerit" rowspan="2">Qtd.</th> 
                                                    <th class="classPerit" colspan='3'>Dimensões</th>   
                                                    <th class="classPerit" rowspan="2">OBS.</th>                                            
                                                    <th class="classVal" rowspan="2">Valor Unit.</th> 
                                                    <th class="classVal" rowspan="2">Valor Total</th>
                                                    <th rowspan="2"><!--Ativo--></th>
                                                </tr>
                                                <tr>
                                                    <th class="classPerit">Ø EXT.</th>
                                                    <th class="classPerit">Ø INT.</th>
                                                    <th class="classPerit">COMP.</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($orcServicoEscopoItens)){
                                                    $count = 1;
                                                    foreach($orcServicoEscopoItens as $r){
                                                        $class = "";
                                                        if(!$r->selected){
                                                            $class= 'class="classSelected"';
                                                        }
                                                        echo '<tr '.$class.'>';
                                                            echo '<td>'.$r->pn.'</td>';
                                                            echo '<td>'.$r->descricaoServicoItens.'<input type="hidden" name="idOrcServicoEscopoItens[]" id="idOrcServicoEscopoItens'.$r->idOrcServicoEscopoItens.'" value="'.$r->idOrcServicoEscopoItens.'"><input type="hidden" name="idServicoEscopoItens[]" id="idServicoEscopoItens'.$r->idServicoEscopoItens.'" value="'.$r->idServicoEscopoItens.'"></td>';
                                                            echo '<td>'.$r->descricaoClasse.'</td>';
                                                            echo '<td "class="classPerit">'.$r->quantidade.'<input type="hidden" class = "span12" id="quantidade_'.$count.'" name="quantidade[]" value="'.$r->quantidade.'"/></td>';
                                                            echo '<td class="classPerit">'.$r->dimenExt.'<input type="hidden" class = "span12" id="dimenExt_'.$count.'" name="dimenExt[]" value="'.$r->dimenExt.'"/></td>';
                                                            echo '<td class="classPerit">'.$r->dimenInt.'<input type="hidden" class = "span12" id="dimenInt_'.$count.'" name="dimenInt[]" value="'.$r->dimenInt.'"/></td>';
                                                            echo '<td class="classPerit">'.$r->dimenComp.'<input type="hidden" class = "span12" id="dimenComp_'.$count.'" name="dimenComp[]" value="'.$r->dimenComp.'"/></td>';
                                                            echo '<td class="classPerit">'.$r->obs.'<input type="hidden" class = "span12" id="obs_'.$count.'" name="obs[]" value="'.$r->obs.'"/></td>';                                               
                                                            echo '<td class="classVal" style="width:10%"><input type="text" class="money span12" name="valor[]" id="valor_'.$count.'" onblur="calcularUnidade('.$count.')" value="'.number_format($r->valorUnitario, 2, ",", ".").'"></td>';
                                                            echo '<td class="classVal" style="width:10%"><input type="text" class="money" name="valorTotal[]" id="valorTotal_'.$count.'"  value="'.number_format($r->valorUnitario*$r->quantidade, 2, ",", ".").'" class="span12" readonly></td>';
                                                            echo '<td style="text-align:center;padding: 14px 6px 12px 5px;">';
                                                                /**/echo '<label class="switch">';
                                                                    if($r->ativo == 1){
                                                                        echo '<input type="checkbox" checked name="checkPermAlmo" id="checkPermAlmo'.$r->idOrcServicoEscopoItens.'"  value="'.$r->idOrcServicoEscopoItens.'">';
                                                                    }else{
                                                                        echo '<input type="checkbox" name="checkPermAlmo" id="checkPermAlmo'.$r->idOrcServicoEscopoItens.'"  value="'.$r->idOrcServicoEscopoItens.'">';
                                                                    }
                                                                    echo '<span class="slider round"></span>';
                                                                echo '</label>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                        $count ++;
                                                    }
                                                }else if(isset($servicoEscopoItens)){
                                                    $count = 1;
                                                    foreach($servicoEscopoItens as $r){
                                                        echo '<tr>';
                                                            if(!empty($r->pn)){
                                                                echo '<td><input type="hidden" class="span12" name="idProdutoP[]" id="idProdutoP_'.$count.'">'.$r->pn.'</td>';
                                                            }else{
                                                                echo '<td style="width:7%"><input type="text" name="pnP[]" id="pnP_'.$count.'"><input type="hidden" class="span12" name="idProdutoP[]" id="idProdutoP_'.$count.'" value=""></td>';
                                                            }
                                                            
                                                            echo '<td>'.$r->descricaoServicoItens.'<input type="hidden" name="idServicoEscopoItens[]" id="idServicoEscopoItens'.$r->idServicoEscopoItens.'" value="'.$r->idServicoEscopoItens.'"></td>';
                                                            echo '<td>'.$r->descricaoClasse.'<input type="hidden" name="idClasse[]" id="idClasse'.$r->idClasse.'" value="'.$r->idClasse.'"></td>';
                                                            echo '<td "class="classPerit"></td>';
                                                            echo '<td class="classPerit"></td>';
                                                            echo '<td class="classPerit"></td>';
                                                            echo '<td class="classPerit"></td>';
                                                            echo '<td class="classPerit"></td>';
                                                            echo '<td class="classVal" style="width:7%"><input class="span12 money" type="text" name="valor[]" onblur="calcularUnidade('.$count.')" id="valor_'.$count.'"  value="" ></td>';
                                                            echo '<td class="classVal" style="width:7%"><input type="text" name="valorTotal[]" id="valorTotal_'.$count.'"  value="" class="span12" readonly></td>';
                                                            echo '<td style="text-align:center;padding: 14px 6px 12px 5px;">';
                                                                echo '<label class="switch">';
                                                                    if($r->ativo == 1){
                                                                        echo '<input type="checkbox" checked name="checkPermAlmo2" id="checkPermAlmo'.$r->idServicoEscopoItens.'"  value="'.$r->idServicoEscopoItens.'">';
                                                                    }else{
                                                                        echo '<input type="checkbox" name="checkPermAlmo2" id="checkPermAlmo'.$r->idServicoEscopoItens.'"  value="'.$r->idServicoEscopoItens.'">';
                                                                    }
                                                                    echo '<span class="slider round"></span>';
                                                                echo '</label>';
                                                            echo '</td>';
                                                        echo '</tr>';
                                                        ?>
                                                            <script type="text/javascript">
                                                                 $(document).ready(function(){
                                                                    $("#pnP_<?php echo $count;?>").autocomplete({
                                                                        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
                                                                        minLength: 1,
                                                                        select: function( event, ui ) {
                                                                            $('#idProdutoP_<?php echo $count;?>').val(ui.item.id);       
                                                                        }
                                                                    });                                                                    
                                                                })
                                                            </script>
                                                        
                                                        <?php
                                                        $count ++;
                                                    }
                                                }else{/**/
                                                    $count = 1;
                                                    echo '<tr>';
                                                        echo '<td><input class="span12" onblur="carregarPn(0)" name="pn[]" id="pn0"/><input class="span12"type="hidden"  value="" name="idProdutoC[]" id="idProdutoC0"/></td>';
                                                        echo '<td><input class="span12" name="descricaoServico[]" id="descricaoServico_0"/></td>';
                                                        echo '<td><select class="span12" name="tipoClasse[]" id="tipoClasse_0"><option value=""> --- </option>'?><?php foreach($typeClass as $r){echo '<option value="'.$r->idClasse.'">'.$r->descricaoClasse.'</option>';} ?><?php echo '</select></td>';
                                                        echo '<td "class="classPerit"></td>';
                                                        echo '<td class="classPerit"></td>';
                                                        echo '<td class="classPerit"></td>';
                                                        echo '<td class="classPerit"></td>';    
                                                        echo '<td class="classPerit"></td>';                                          
                                                        echo '<td class="classVal"></td>';
                                                        echo '<td class="classVal"></td>';
                                                        echo '<td></td>';
                                                    echo '</tr>';
                                                }
                                                ?>                                            
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="text-align: center;">
                                        <a class="btn btn-warning" onclick="adicionarItemTabela()">Novo Item</a>
                                        <a class="btn btn-success" onclick="salvarItens()" >Salvar</a>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>    
</div>
<script type="text/javascript">
    <?php 
        if(!isset($servicoEscopoItens) && !isset($orcServicoEscopoItens)){ ?>
            $(document).ready(function(){
                $("#pn0").autocomplete({
                    source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
                    minLength: 1,
                    select: function( event, ui ) {
                        $('#idProdutoC0').val(ui.item.id);       
                    }
                });
                $("#descricaoServico_0").autocomplete({
                    source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteItemServico",
                    minLength: 1,
                    select: function(event, ui) {
                
                    }
                })
                
            })
            <?php
        }
    ?>
     /**/
    $(document).ready(function(){
        $('.money').inputmask("decimal",{
            numericInput: false,
            groupSeparator: '.',
            radixPoint: ",",
            digits: 2,
            autoGroup: true,
            autoUnmask: true,
            prefix: 'R$ ',
            placeholder: '0,00'
        });
    })
    $("input:checkbox[name=checkPerit]").click(function(){
        if($('#checkPerit').is(':checked')){
            $('.classPerit').hide('fast');
        }else{
            $('.classPerit').show('fast');
        }
    })
    $("input:checkbox[name=checkValores]").click(function(){
        if($('#checkValores').is(':checked')){
            $('.classVal').hide('fast');
        }else{
            $('.classVal').show('fast');
        }
    })
    $("input:checkbox[name=checkSel]").click(function(){
        if($('#checkSel').is(':checked')){
            $('.classSelected').hide('fast');
        }else{
            $('.classSelected').show('fast');
        }
    })
    
    var contador = 1;
    function adicionarItemTabela(){
        console.log("oi")
        var table = document.getElementById("table_id").getElementsByTagName('tbody')[0];;
        if(table.rows.length == null || typeof table.rows.length == "undefined"){
          var numOfRows = 0;
        } else {
          var numOfRows = table.rows.length;
        }
        var newRow = table.insertRow(numOfRows);
        var displayPerit = '';
        if(document.querySelectorAll(".classPerit")[0].style.display == 'none'){
            displayPerit = 'none';
        }else{
            displayPerit = 'table-cell';
        }
        var displayVal = '';
        if(document.querySelectorAll(".classVal")[0].style.display == 'none'){
            displayVal = 'none';
        }else{
            displayVal = 'table-cell';
        }
        newCell = newRow.insertCell(0);   
        newCell.innerHTML = '<input class="span12" onblur="carregarPn('+contador+')" name="pn[]" id="pn'+contador+'"/><input class="span12"type="hidden" value="" name="idProdutoC[]" id="idProdutoC'+contador+'"/>';

        newCell = newRow.insertCell(1);   
        newCell.innerHTML = '<input class="span12" name="descricaoServico[]" id="descricaoServico_'+contador+'"/>';

        newCell = newRow.insertCell(2);   
        newCell.innerHTML = '<select class="span12" name="tipoClasse[]" id="tipoClasse_'+contador+'"><option value=""> --- </option><?php foreach($typeClass as $r){echo '<option value="'.$r->idClasse.'">'.$r->descricaoClasse.'</option>';} ?></select>';

        newCell = newRow.insertCell(3);   
        newCell.innerHTML = "";


        //newCell.classList.add("classPerit");
        //newCell.style.display = displayPerit;
        

        newCell = newRow.insertCell(4);   
        newCell.innerHTML = "";
        newCell.classList.add("classPerit");
        newCell.style.display= displayPerit;

        newCell = newRow.insertCell(5);   
        newCell.innerHTML = "";
        newCell.classList.add("classPerit");
        newCell.style.display = displayPerit;

        newCell = newRow.insertCell(6);   
        newCell.innerHTML = "";
        newCell.classList.add("classPerit");
        newCell.style.display = displayPerit;

        newCell = newRow.insertCell(7);   
        newCell.innerHTML = "";
        newCell.classList.add("classPerit");
        newCell.style.display = displayPerit;

        newCell = newRow.insertCell(8);   
        newCell.innerHTML = "";
        newCell.classList.add("classVal");
        newCell.style.display = displayVal;

        newCell = newRow.insertCell(9);   
        newCell.innerHTML = "";
        newCell.classList.add("classVal");
        newCell.style.display = displayVal;

        newCell = newRow.insertCell(10);  
        newCell.setAttribute('style','text-align:center');  
        newCell.innerHTML = '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow3(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button>';
    
        produto = "idProdutoC"+contador;
      
        $("#pn"+contador).autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
            minLength: 1,
            select: function( event, ui ) {
                document.getElementById(produto).value = ui.item.id;
            }
        });
        
        $("#descricaoServico_"+contador).autocomplete({
            source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteItemServico",
            minLength: 1,
            select: function(event, ui) {
                
            }
        })

        contador++;        
    }
    function deleteRow3(i){
        document.getElementById('table_id').deleteRow(i);
    }
    function salvarItens(){
        if(document.querySelector('#idEscopo').value == ""){
            if(document.querySelector('#descricaoEscopo').value == ""){
                return alert('Informe um nome para esse escopo');                
            }
            $("#formPeritag").submit();
        }else{
            $("#formPeritag").submit();
        }
    }
    <?php /* if(!isset($servicoEscopoItens)){
        echo '$(document).ready(function(){$("#descricaoServico_0").autocomplete({
            source: "'.base_url().'index.php/orcamentos/autoCompleteItemServico",
            minLength: 1,
            select: function(event, ui) {                
        }})})';
    } */ ?>
    function carregarPn(pos){
        if(document.querySelector("#idProdutoC"+pos).value == "" && document.querySelector("#pn"+pos).value != ""){
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/produtos/getProdutoByPn",
                type: 'POST',
                dataType: 'json',
                data: {
                    pn: document.querySelector("#pn"+pos).value
                },
                success: function(data) {
                    if(data.result){
                        document.querySelector("#idProdutoC"+pos).value = data.produto.idProdutos
                    }else if(data.msg != ""){
                        alert(data.msg);
                    }
                    verificarEscopo(pos);                        
                },
                error: function(xhr, textStatus, error) {
                    console.log("4");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },
            })
        }
    }
    
    
    function calcularUnidade(pos){
        valor_unitario = document.getElementById('valor_'+pos).value.replaceAll(".","").replaceAll(",",".");
        qtd = document.getElementById('quantidade_'+pos).value;
        soma = valor_unitario*qtd
        document.getElementById('valorTotal_'+pos).value =  parseFloat(soma).toFixed(2).toString();
        somaServ = 0;
        somaPec = 0;
        total = 0;

        valor_totalArray = Array.apply(null,document.querySelectorAll("input[name='valorTotal[]']"));
        for(x=0;x<valor_totalArray.length;x++){
            total = parseFloat(total) + parseFloat(valor_totalArray[x].value.replaceAll(".","").replaceAll(",","."));
        }
        document.getElementById('totalReforma').value =  parseFloat(total).toFixed(2).toString();
    }/**/
    $(document).ready(function(){
        $("input:checkbox[name=checkPermAlmo]").click(function(){
            permCompra(this.value,this.checked);       
            
        })
        $("input:checkbox[name=checkPermAlmo2]").click(function(){
            permCompra2(this.value,this.checked);       
            
        })
    })
    function permCompra(value,checked){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/orcamentos/ativardesativaritemescopo",
            type: 'POST',
            dataType: 'json',
            data: {
                idOrcServItem:value,
                status:checked
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
    function permCompra2(value,checked){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/orcamentos/ativardesativaritemescopo2",
            type: 'POST',
            dataType: 'json',
            data: {
                idOrcServItem:value,
                status:checked
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
    
</script>