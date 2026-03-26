<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tableimprimir.css" />
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!--
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>-->
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>

<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">-->
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">
<link href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css" rel="stylesheet">
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
<div class="container" style="width: auto">

    <table id="table" data-toggle="table" data-toolbar="#toolbar" data-filter-control="false" data-show-footer="false" data-detail-formatter="detailFormatter" data-detail-view="true" data-hide-unused-select-options="true">
        <thead>
            <tr>
                <!--
            <th data-field="state" data-checkbox="false"></th>-->
                <th data-field="Insumo" data-filter-control="select"></th>
                <th data-field="id" data-filter-control="select">O.S.</th>
                <th data-field="ValorTotalEntrada" data-filter-control="select">Qtd.</th>
                <th data-field="ValorTotalSaida" data-filter-control="select">Descrição</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($comprasSolicitadas)) {
                foreach ($comprasSolicitadas as $r) { ?>
                    <tr><!--
                        <td><a class="detail-icon" href="#"><i class="fa fa-plus"></i></a></td>-->
                        <?php if($r->aprovacaoPCP == 0 || empty($r->aprovacaoPCP)){
                            echo '<td><label class="switch"><input type="checkbox" name="checkOs" id="checkOs'.$r->idOs.'" value="'.$r->idOs.'"><span class="slider round"></span></label></td>';
                        }else{
                            echo '<td><label class="switch"><input type="checkbox" checked name="checkOs" id="checkOs'.$r->idOs.'" value="'.$r->idOs.'"><span class="slider round"></span></label></td>';
                        } ?>                        
                        <td><?php echo $r->idOs ?></td>
                        <td><?php echo $r->qtd_os ?></td>                        
                        <td><?php echo $r->descricao_item  ?></td>
                    </tr>

            <?php
                }
            } ?>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $("input:checkbox[name=checkOs]").click(function(){
            console.log(this.checked);
            console.log(this.value)
            //console.log(this)
            var arrayItens = Array.apply(null,document.querySelectorAll("#checkPedidoCompra"+this.value))
            arrayItens.forEach((elemento)=>{
                elemento.checked = this.checked;
                permCompra(elemento.value,this.checked);
            })
        })
        $("input:checkbox[name=checkPedidoCompra]").click(function(){
            //console.log(this.checked);
            //console.log(this.value)
            //console.log(this)
            permCompra(this.value,this.checked);
        })
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
        <?php if(isset($comprasSolicitadas)){
        foreach($comprasSolicitadas as $r){?>
      var sub_data<?php echo $r->idOs ?> = [
        <?php if(isset($r->idDistribuir)){
            $tot = count(explode(";",$r->idDistribuir));
            $dist = explode(";",$r->idDistribuir);
            $dim = explode(";",$r->dimensoes);
            $qtd = explode(";",$r->qtd);
            $dtCad = explode(";",$r->data_cadastro);
            $ins = explode(";",$r->descricaoInsumo);
            $nome = explode(";",$r->nomeUsuario);
            $aprov = explode(";",$r->aprovacaoPCP);
            $valor_unit = explode(";",$r->valor_unitario);
            for($x=0;$x<$tot;$x++){
                $contador = 0;
                $contador = $contador+1;?>
        {
        <?php if($aprov[$x] == 0 || empty($aprov[$x])){?>
            "checkbox": '<label class="switch"><input type="checkbox" name="checkPedidoCompra" id="checkPedidoCompra<?php echo $r->idOs?>" value="<?php echo $dist[$x]?>"><span class="slider round"></span></label>',<?php
        }else{?>
            "checkbox": '<label class="switch"><input type="checkbox" checked name="checkPedidoCompra" id="checkPedidoCompra<?php echo $r->idOs?>" value="<?php echo $dist[$x]?>"><span class="slider round"></span></label>',<?php
        }
        ?>        
        "insumo": '<?php echo $ins[$x]." ".$dim[$x];?>',
        "quantidade": '<?php echo $qtd[$x];?>',
        "data_cadastro": '<?php echo date("d/m/Y", strtotime($dtCad[$x]));?>',
        "valor_unit": 'R$ <?php echo number_format($valor_unit[$x], 2, ",", ".");?>',
        "valor_total": 'R$ <?php echo number_format($valor_unit[$x]*$qtd[$x], 2, ",", ".");;?>',
        "solicitado_por": '<?php echo $nome[$x];?>',
        }<?php if($contador != $tot){ echo ",";}?>
    <?php }
    }?>
    ];
    <?php }
    }?>


    


    function build_sub_table(subData, table) {
        var data = JSON.parse(JSON.stringify(eval(subData)))

        $('#'+table).bootstrapTable({
            columns: [{
            title: 'Insumos',
            field: 'insumos',
            sortable: true,
            },{
            title: 'Empresa',
            field: 'empresa',
            sortable: true,
            },{
            title: 'Quantidade',
            field: 'quantidade',
            sortable: true,
            },{
            title: 'Valor Unit.',
            field: 'valor_unit',
            sortable: true,
            },{
            title: 'Valor Total.',
            field: 'valor_total',
            sortable: true,
            }],
            data: data
        })
    
    };

    function detailFormatter(index, row, element){ 
        var html = []
        var data = JSON.parse(JSON.stringify(eval("sub_data"+row.id)))
        var htmlA = "";
        var htmlB = "";
        var htmlC = "";

        for(var x=0;x<data.length;x++){
            htmlA = htmlA + 
            '<tr>'+
                '<td >'+data[x].checkbox+'</td>'+
                '<td >'+data[x].insumo+'</td>'+
                '<td >'+data[x].quantidade+'</td>'+
                '<td >'+data[x].data_cadastro+'</td>'+
                '<td >'+data[x].valor_unit+'</td>'+
                '<td >'+data[x].valor_total+'</td>'+
                '<td >'+data[x].solicitado_por+'</td>'+
                //'<td >R$ '+Number(data[x].valor_unit).toFixed(3).replace(".",",")+'</td>'+
                //'<td >R$ '+Number(data[x].valor_total).toFixed(3).replace(".",",")+'</td>'+
            '</tr>'
        }
        html.push('<div class="ui one column grid" style="margin-bottom:30px">'+
            '<div style="margin: 20px;">'+
                //'<label for="sub_table"'+row.id+' style= "text-align: center;margin-top: 5px">Estoque por Empresa</label>'+
                '<table class="ui very compact table" id="sub_table"'+row.id+' >'+
                    '<thead>'+
                        '<tr>'+
                            '<th data-field="checkbox"></th>'+
                            '<th data-field="insumo">Insumo</th>'+
                            '<th data-field="quantidade">Quantidade</th>'+
                            '<th data-field="data_cadastro">Data Cadastro</th>'+
                            '<th data-field="valor_unit">Valor Unit.</th>'+
                            '<th data-field="valor_total">Valor Total</th>'+
                            '<th data-field="solicitado_por">Solicitado Por</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+                        
                        htmlA+
                    '</tbody>'+
                '</table>'+
            '</div>'+
        '</div>'); 

        return html.join('')
        //return childDetail(index,row)
    };
        

    function childDetail(index,row){
        var row1 = document.createElement("div");
        row1.setAttribute('class','ui one column grid'); 
        var button = document.createElement("button");
        button.setAttribute('onclick','build_sub_table("sub_data'+row.id+'", "sub_table'+row.id+'")')  
        button.textContent="Detalhes"
        row1.append(button);
        
        var row2 = document.createElement("div");
        row1.setAttribute('class','ui one column grid');
        
        var table = document.createElement('table');
        table.setAttribute('class','ui very compact table');
        table.setAttribute('id','sub_table'+row.id);


        row2.append(table);
        build_sub_table("sub_data"+row.id, "sub_table"+row.id)
        row1.append(row2);
        return row1;
    };
   
</script>