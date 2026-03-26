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
  -webkit-transition: .4s;
  transition: .4s;
  background-color: #ccc;
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
                <h5>Checklist</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                        <input type="text" class="span12" value="<?php echo $catalogo->pn; ?>" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Descrição: </label>
                                        <input type="text" class="span12" value="<?php echo $catalogo->descricao; ?>" readonly />
                                    </div>
                                    <div class="span3" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Tipo de Prod.: </label>
                                        <input type="text" class="span12" value="<?php echo $catalogo->tipoProd; ?>" readonly />
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
</br>

<div align='center'>
    <a class="btn btn-warning" onClick="adicionarItemTabela()">Novo Item</a>
    <a name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success" onClick='document.getElementById("form1").submit();'><i class="icon-plus icon-white"></i>Salvar</a>
</div>
<form class="form-inline" action="<?php echo base_url() ?>index.php/peritagem/salvarcatalogo2"            method="post" name="form1" id="form1">
    <input type="hidden" name="idCatalogoProduto" value="<?php echo $catalogo->idCatalogoProduto; ?>">
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Itens Checklist</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="span12" id="divCadastrarOs">                                
                            <div class="widget-box" style="margin-top:0px">                                        
                                <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
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
                                        <?php foreach($catalogoItens as $r){
                                            echo '<tr>';
                                                echo '<td>'.$r->pn.'</td>';
                                                echo '<td>'.$r->descricao.'</td>';
                                                //echo '<td>'.$r->tipoProd.'</td>';
                                                echo '<td><select class="span12" name="tipoProd[]"><option value="pec" '.($r->tipoProd == "pec"?"selected":"").'>Peça</option><option '.($r->tipoProd == "cil"?"selected":"").' value="cil">Cilindro</option><option '.($r->tipoProd == "sub"?"selected":"").' value="sub">Sub-conjunto</option><option '.($r->tipoProd == "maq"?"selected":"").' value="maq">Máquina</option></select></td>';
                                                echo '<td><input class="span12" type="text" name="quantidade[]" value="'.$r->quantidade.'"><input class="span12" type="hidden" name="idCatalogoItens[]" value="'.$r->idCatalogoProdutoItens.'"></td>';
                                                if($r->ativo == 1){
                                                    echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" checked name="checkPedidoCompraItens" id="checkPedidoCompraItens'.$r->idCatalogoProdutoItens.'" value="'.$r->idCatalogoProdutoItens.'"><span class="slider round"></span></label></td>';    
                                                }else{
                                                    echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" name="checkPedidoCompraItens" id="checkPedidoCompraItens'.$r->idCatalogoProdutoItens.'" value="'.$r->idCatalogoProdutoItens.'"><span class="slider round"></span></label></td>';                                                                        
                                                } 
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
</form>
<div align='center'>
        <a class="btn btn-warning" onClick="adicionarItemTabela()">Novo Item</a>
    <a name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success" onClick='document.getElementById("form1").submit();' ><i class="icon-plus icon-white"></i>Salvar</a>
</div>
<script>
    $("input:checkbox[name=checkPedidoCompraItens]").click(function(){
        //permCompra(this.value,this.checked,"");
        catalogoItemAtivo(this.value,this.checked)
        if(this.checked){
            alert("Item ativado!");
        }else{
            alert("Item desativado!");
        }
        
    })
    function catalogoItemAtivo(pedidoCompraItens,checked){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/catalogoitemativo",
            type: 'POST',
            dataType: 'json',
            data: {
                idCatalogoProdutoItem:pedidoCompraItens,
                statusAtivo:checked
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
    }var contador = 0;
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
        newCell.innerHTML = '<select class="span12" name="tipoProd2[]"><option value="cil">Cilindro</option><option value="maq">Máquina</option><option value="pec" selected>Peça</option><option value="sub">Subconjunto</option></select>';

        newCell = newRow.insertCell(3);   
        newCell.innerHTML = '<input type="text" class="span12" id="quantidade0" name="quantidade2[]">';


        //newCell.classList.add("classPerit");
        //newCell.style.display = displayPerit;
        

        

        //newCell.style.display = displayVal;

        newCell = newRow.insertCell(4);  
        newCell.setAttribute('style','text-align:center');  
        newCell.innerHTML = '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow3(this.parentNode.parentNode.rowIndex)"><font size=1>Excluir</font></button>';
    
        produto = "idProdutoC"+contador;
        descProd = "descricaoPn"+contador;
        $("#pn"+numOfRows).autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
            minLength: 1,
            select: function( event, ui ) {
                $("#idProdutoC"+numOfRows).val(ui.item.id) 
                $("#descricaoPn"+numOfRows).val(ui.item.produtos);
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
                    //verificarEscopo(pos);                        
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
</script>