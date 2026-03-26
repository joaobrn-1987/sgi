<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<form class="form-inline" action="<?php echo base_url() ?>index.php/peritagem/salvarCatalogo" method="post" id="formCatalogo">
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Informações do produto</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                            <div class="tab-pane active">
                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">PN: </label>
                                            <input type="text" class="span12" id="pn" value=""  />
                                            <input type="hidden" id="idProdutos" name="idProdutos" value=""  />
                                        </div>
                                        <div class="span5" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Descrição: </label>
                                            <input type="text" class="span12" value="" id="prod" readonly />
                                        </div>
                                        <div class="span5" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Tipo de Prod: </label>
                                            <select name="tipoProdMaster" class="span12"><option value="cil">Cilindro</option><option value="maq">Máquina</option><option value="pec" selected>Peça</option><option value="sub">Subconjunto</option></select>
                                        </div>
                                    </div><!--
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
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </br>
    <div align='center'>
        <a class="btn btn-warning" onclick="adicionarItemTabela()">Novo Item</a>
        <a name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success" onclick="document.getElementById('formCatalogo').submit();"><i class="icon-plus icon-white"></i>Salvar</a>
    </div>
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Itens do catálogo</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="span12" id="divCadastrarOs">                                
                            <div class="widget-box" style="margin-top:0px">                                        
                                <table id="table_id" class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>PN</th>
                                            <th>Descrição</th>
                                            <th>Tipo de prod.</th>
                                            <th>Quantidade</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            echo '<tr>';
                                                echo '<td><input type="text" class="span12" onblur="carregarPn(0)" name="pn[]" id="pn0"/><input class="span12"type="hidden"  value="" name="idProdutoC[]" id="idProdutoC0"/></td>';
                                                echo '<td><input type="text" name="descricaoServico[]" class="span12" id="descricaoPn0" disabled></td>';
                                                echo '<td><select name="tipoProd[]" class="span12"><option value="cil">Cilindro</option><option value="maq">Máquina</option><option value="pec" selected>Peça</option><option value="sub">Subconjunto</option></select></td>';
                                                echo '<td><input type="text" class="span12" name="quantidade[]" id="quantidade0"></td>';
                                                echo '<td></td>';
                                            echo '</tr>';
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
    <div align='center'>
        <a class="btn btn-warning" onClick="adicionarItemTabela()">Novo Item</a>
        <a name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success" ><i class="icon-plus icon-white"></i>Salvar</a>
    </div>
</form>
<script >

    var pnprod = document.getElementById('pn');
    pnprod.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
          document.querySelector("#pn").value = "";
          document.querySelector("#prod").value = "";
          document.querySelector("#idProdutos").value = "";
        }
    };
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
        var displayPerit = '';/*
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
        }*/
        newCell = newRow.insertCell(0);   
        newCell.innerHTML = '<input type="text" class="span12" onblur="carregarPn('+contador+')" name="pn[]" id="pn'+contador+'"/><input class="span12"type="hidden" value="" name="idProdutoC[]" id="idProdutoC'+contador+'"/>';

        newCell = newRow.insertCell(1);   
        newCell.innerHTML = '<input type="text" class="span12" name="descricaoServico[]" id="descricaoPn'+contador+'" disabled/>';

        newCell = newRow.insertCell(2);   
        newCell.innerHTML = '<select class="span12" name="tipoProd[]"><option value="cil">Cilindro</option><option value="maq">Máquina</option><option value="pec" selected>Peça</option><option value="sub">Subconjunto</option></select>';

        newCell = newRow.insertCell(3);   
        newCell.innerHTML = '<input type="text" class="span12" id="quantidade0" name="quantidade[]">';


        //newCell.classList.add("classPerit");
        //newCell.style.display = displayPerit;
        

        

        //newCell.style.display = displayVal;

        newCell = newRow.insertCell(4);  
        newCell.setAttribute('style','text-align:center');  
        newCell.innerHTML = '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow3(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button>';
    
        produto = "idProdutoC"+contador;
        descProd = "descricaoPn"+contador;
        $("#pn"+contador).autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
            minLength: 1,
            select: function( event, ui ) {
                document.getElementById(produto).value = ui.item.id;
                document.getElementById(descProd).value = ui.item.produtos;
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

    $(document).ready(function(){
        $("#pn0").autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
            minLength: 1,
            select: function( event, ui ) {
                document.getElementById("idProdutoC0").value = ui.item.id;
                document.getElementById("descricaoPn0").value = ui.item.produtos;
            }
        });

        $("#pn").autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
            minLength: 1,
            select: function( event, ui ) {
                $('#idProdutos').val(ui.item.id);
                $('#prod').val(ui.item.produtos);
            }
        }); 
    })
    function deleteRow3(i){
        document.getElementById('table_id').deleteRow(i);
    }
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
    function validarDados(){
        
    }
    
</script>