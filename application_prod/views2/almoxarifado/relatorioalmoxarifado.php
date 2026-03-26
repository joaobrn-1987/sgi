
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script><!--
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
<link href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css" rel="stylesheet">

<div class="container" style="width: auto">
  
    <table
        id="table"
        data-toggle="table"
        data-toolbar="#toolbar"
        data-filter-control="false"
        data-show-footer="false"
        data-detail-formatter="detailFormatter"
        data-detail-view="true"
        data-hide-unused-select-options="true">
        <thead>
            <tr><!--
            <th data-field="state" data-checkbox="false"></th>-->
            <th data-field="Insumo" data-filter-control="select">Insumo</th>
            <th data-field="ValorUnitMedio" data-filter-control="select">Valor Unit. Medio</th>
            <th data-field="ValorTotalEntrada" data-filter-control="select">Valor Total Entrada</th>
            <th data-field="ValorTotalSaida" data-filter-control="select">Valor Total Saida</th>
            <th data-field="ValorTotal" data-filter-control="select">Valor Total Estoque</th>
            <th data-field="QuantidadeTotalEntrada" data-filter-control="select">Quantidade Entrada</th>
            <th data-field="QuantidadeTotalSaida" data-filter-control="select">Quantidade Saída</th>
            <th data-field="QuantidadeTotal" data-filter-control="select">Quantidade Total</th>
            <th data-field="id" data-filter-control="select" data-visible="false">id</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(isset($dadosRelatorio)){
                foreach($dadosRelatorio as $r){?>
                    <tr>
                        <td><?php echo $r->descricaoInsumo?></td>
                        <td>R$ <?php echo str_replace(".",",",round($r->valor_unit_medio,3))?></td>
                        <td>R$ <?php echo str_replace(".",",",round($r->valor_total_entrada,3))?></td>
                        <td>R$ <?php echo str_replace(".",",",round($r->valor_total_saida,3))?></td>
                        <td>R$ <?php echo str_replace(".",",",round($r->valor_total,3))?></td>
                        <td><?php echo $r->quantidade_entrada?></td>
                        <td><?php echo $r->quantidade_saida?></td>
                        <td><?php echo $r->quantidade_total?></td>
                        <td><?php echo $r->idInsumos?></td>
                    </tr>
            
                <?php
                }
            }?>
            
        </tbody>
    </table>
</div>


<script type="text/javascript">
    <?php if(isset($dadosRelatorio)){
        foreach($dadosRelatorio as $r){?>
    var sub_data<?php echo $r->idInsumos ?> = [
        <?php if(isset($r->detalheEstoqueEmpresas)){
            $tot = count($r->detalheEstoqueEmpresas);
            foreach($r->detalheEstoqueEmpresas as $ru){
                $contador = 0;
                $contador = $contador+1;?>
        {
        "insumos": "<?php echo $ru->descricaoInsumo;?>",
        "empresa": "<?php echo $ru->nome;?>",
        "quantidade": "<?php echo $ru->quantidade_total;?>",
        "quantidade_entrada": "<?php echo $ru->quantidade_entrada;?>",
        "quantidade_saida": "<?php echo $ru->quantidade_saida;?>",
        "valor_unit": "<?php echo $ru->valor_unit_medio;?>",
        "valor_total_entrada": "<?php echo $ru->valor_total_entrada;?>",
        "valor_total_saida": "<?php echo $ru->valor_total_saida;?>",
        "valor_total": "<?php echo $ru->valor_total;?>",
        }<?php if($contador != $tot){ echo ",";}?>
    <?php }
    }?>
    ];
    <?php }
    }?>


    <?php if(isset($dadosRelatorio)){
        foreach($dadosRelatorio as $r){?>
        var sub_entrada<?php echo $r->idInsumos ?> = [
        <?php if(isset($r->entradas)){
            $tot2 = count($r->entradas);
            foreach($r->entradas as $ru){
                $contador2 = 0;
                $contador2 = $contador2+1;?>
        {
        "insumos": "<?php echo $ru->descricaoInsumo;?>",
        "empresa": "<?php echo $ru->nome;?>",
        "quantidade": "<?php echo $ru->quantidade_total;?>",
        //"valor_unit": "",
        "valor_total": "<?php echo $ru->valor_total;?>",
        }<?php if($contador2 != $tot2){ echo ",";}?>
    <?php }
    }?>
    ];
    <?php }
    }?>

<?php if(isset($dadosRelatorio)){
        foreach($dadosRelatorio as $r){?>
        var sub_saida<?php echo $r->idInsumos ?> = [
        <?php if(isset($r->saidas)){
            $tot3 = count($r->saidas);
            foreach($r->saidas as $ru){
                $contador3 = 0;
                $contador3 = $contador3+1;?>
        {
        "insumos": "<?php echo $ru->descricaoInsumo;?>",
        "empresa": "<?php echo $ru->nome;?>",
        "quantidade": "<?php echo $ru->quantidade_total;?>",
        //"valor_unit": "",
        "valor_total": "<?php echo $ru->valor_total;?>",
        }<?php if($contador3 != $tot3){ echo ",";}?>
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
        var data2 = JSON.parse(JSON.stringify(eval("sub_entrada"+row.id)))
        var data3 = JSON.parse(JSON.stringify(eval("sub_saida"+row.id)))
        var htmlA = "";
        var htmlB = "";
        var htmlC = "";

        for(var x=0;x<data.length;x++){
            htmlA = htmlA + 
            '<tr>'+
                '<td >'+data[x].insumos+'</td>'+
                '<td >'+data[x].empresa+'</td>'+
                '<td >'+data[x].quantidade+'</td>'+
                '<td >'+data[x].quantidade_entrada+'</td>'+
                '<td >'+data[x].quantidade_saida+'</td>'+
                '<td >R$ '+Number(data[x].valor_unit).toFixed(3).replace(".",",")+'</td>'+
                '<td >R$ '+Number(data[x].valor_total_entrada).toFixed(3).replace(".",",")+'</td>'+
                '<td >R$ '+Number(data[x].valor_total_saida).toFixed(3).replace(".",",")+'</td>'+
                '<td >R$ '+Number(data[x].valor_total).toFixed(3).replace(".",",")+'</td>'+
            '</tr>'
        }
        for(var x=0;x<data2.length;x++){
            htmlB = htmlB + 
            '<tr>'+
                '<td >'+data2[x].insumos+'</td>'+
                '<td >'+data2[x].empresa+'</td>'+
                '<td >'+data2[x].quantidade+'</td>'+
                '<td >'+data2[x].valor_total.replace(".",",")+'</td>'+
            '</tr>'
        }
        for(var x=0;x<data3.length;x++){
            htmlC = htmlC + 
            '<tr>'+
                '<td >'+data3[x].insumos+'</td>'+
                '<td >'+data3[x].empresa+'</td>'+
                '<td >'+data3[x].quantidade+'</td>'+
                '<td >'+data3[x].valor_total.replace(".",",")+'</td>'+
            '</tr>'
        }
        html.push('<div class="ui one column grid" style="margin-bottom:30px">'+
            '<div >'+
                //'<label for="sub_table"'+row.id+' style= "text-align: center;margin-top: 5px">Estoque por Empresa</label>'+
                '<table class="ui very compact table" id="sub_table"'+row.id+' >'+
                    '<thead>'+
                        '<tr>'+
                            '<th data-field="insumos">Insumos</th>'+
                            '<th data-field="empresa">Empresa</th>'+
                            '<th data-field="quantidade">Quantidade</th>'+
                            '<th data-field="quantidade_entrada">Quantidade Entrada</th>'+
                            '<th data-field="quantidade_saida">Quantidade Saída</th>'+
                            '<th data-field="valor_unit">Valor Unit.</th>'+
                            '<th data-field="valor_total_entrada">Valor Total Entrada</th>'+
                            '<th data-field="valor_total_saida">Valor Total Saída</th>'+
                            '<th data-field="valor_total">Valor Total Estoque</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+                        
                        htmlA+
                    '</tbody>'+
                '</table>'+
            '</div>'+
        '</div>');  /*
        html.push('<div class="ui one column grid" style="margin-bottom:30px">'+
            '<div >'+
                '<label for="sub_tableEntrada"'+row.id+' style= "text-align: center;margin-top: 5px">Entradas por Empresa</label>'+
                '<table class="ui very compact table" id="sub_tableEntrada"'+row.id+' >'+
                    '<thead>'+
                        '<tr>'+
                            '<th data-field="insumos">Insumos</th>'+
                            '<th data-field="empresa">Empresa</th>'+
                            '<th data-field="quantidade">Quantidade</th>'+
                            '<th data-field="valor_total">Valor Total</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+                        
                        htmlB+
                    '</tbody>'+
                '</table>'+
            '</div>'+
        '</div>');  
        html.push('<div class="ui one column grid" style="margin-bottom:30px">'+
            '<div >'+
                '<label for="sub_tableSaida"'+row.id+' style= "text-align: center;margin-top: 5px">Saídas por Empresa</label>'+
                '<table class="ui very compact table" id="sub_tableSaida"'+row.id+' >'+
                    '<thead>'+
                        '<tr>'+
                            '<th data-field="insumos">Insumos</th>'+
                            '<th data-field="empresa">Empresa</th>'+
                            '<th data-field="quantidade">Quantidade</th>'+
                            '<th data-field="valor_total">Valor Total</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+                        
                        htmlC+
                    '</tbody>'+
                '</table>'+
            '</div>'+
        '</div>'); */

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