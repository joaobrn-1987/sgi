<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<style>
    
	table.comBordas {
		border: 0px solid White;
	}

	table.comBordas td {
		border: 1px solid grey;
	}
</style>
<div class="row-fluid" style="margin-top:0">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-content nopadding">
				<div class="span12" id="divProdutosServicos" style=" margin-left: 0;background-color: #f9f9f9;">
                    <div class="container-fluid" style="margin-top: 20px;">
						<table class='comBordas' width='36%' align='left'>
							<tr>
								<td align='center' style="font-size: 12px;">
									Orçamento: <font size='5'><?php echo $result->idOrcamentos ?></font>
								</td>
								<td align='center'>
									Data Abertura:<?php echo date('d/m/Y',  strtotime($result->data_abertura)) ?></b>
                                </td>
								
							</tr>
						</table>
						<div class="row-fluid">
							<div class="span12">

								<div class="widget-box">

									<div class="widget-content nopadding">

										<table width='100%' border='0' style="border-style:solid; border: 1px solid grey;
											font-family:Arial, Helvetica, sans-serif;
											font-size:12px;">
											<tr>
												<td align='center'>
													<table width='100%' border='0' style="font-family:Arial, Helvetica, sans-serif;
														font-size:12px;   line-height: 20px;">


														<tr>
															<td align='left' width="13%">Cliente:</td>
															<td ><?php echo $result->nomeCliente; ?></td>
															<td align='left'  width="13%">Vendedor: </td>
															<td><?php echo $result->nomeVendedor; ?></td>
														</tr>

														<tr>
															<td align='left'>Solicitante:</td>
															<td ><?php echo $result->nome; ?></td><!--
															<td align='left' width='13%'>Orçamento: </td>
															<td><?php echo $result->idOrcamentos; ?></td>-->

														</tr>
														<tr>
                                                        </tr>
                                                    
													
										            </table>
										        </td>
										    </tr>
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
</div><!--
<div align="center" style="margin-top:20px">
    <button class="btn btn-success">Entrada</button>
</div>-->
<div class="row-fluid" style="margin-top:0">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-tags"></i>
				</span>
				<h5>Itens Recebimento</h5>
			</div>
			<div class="widget-content nopadding">
				<div class="span12" id="divProdutosServicos" style=" margin-left: 0">
					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
							<div class="span12" id="divCadastrarOs">
								<div class="widget-box" style="margin-top:0px">
									<table id="tableHistVale" class="table table-bordered "><!--
										<thead>
											<tr>
												<th>Data</th>
												<th>O.S. Origem</th>
												<th>O.S. Destino</th>
												<th>Item</th>
												<th>Qtd</th> 
												<th>Usuário</th>
											</tr>
										</thead> -->
										<tbody>
                                            <?php
                                                $contador_local_autocomplete = 0;
                                                foreach($objControleSubItem as $d){
                                                    echo '<tr class="trpai'.$d->idOrcamento_item.$d->idOs.'">';
                                                            
                                                        if($d->tipoOrc == "serv"){
                                                            echo '<td onclick="openclose(this,'.$d->idOrcamento_item.$d->idOs.')"  style="text-align: center; /* padding: 75px 5px 75px 5px */ display: table-cell;min-height: 10em;vertical-align: middle;"><a class="detail-icon"><i class="fa fa-plus"></i></a></td>';
                                                        }else{
                                                            echo '<td></td>';
                                                        }
                                                       
                                                        echo '<td ><div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">';
                                                            echo '<input type="hidden" id="id_orc_item_' . $contador_local_autocomplete . '" name="id_orc_item[]"   value="' . $d->idOrcamento_item . '"/>' .
                                                                '<div class="span12" style="padding: 0.2%; margin-left: 0">' ;
                                                                if(!empty($d->idOs)){
                                                                    echo '<div class="span1">'.
                                                                        '<label>O.S.:</label>'.
                                                                        '<input readonly type="text" class="span12" value="' . $d->idOs . '" />' .                                                                    
                                                                    '</div>';
                                                                    echo '<div class="span1">' .
                                                                    '<label><b>PN </b> (master):</label>' .
                                                                    '<input readonly type="text" class="span12" id="pn_' . $contador_local_autocomplete . '" name="pn[]" value="' . $d->pn . '" />' .
                                                                    '<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>' .
                                                                    '<input type="hidden" id="idProdutos_' . $contador_local_autocomplete . '" name="idProdutos[]" size="3"   value="' . $d->idProdutos . '"/>' .
                                                                    '<input type="hidden" name="contador[]" size="3"   value="' . $contador_local_autocomplete . '"/>' .
                                                                    '</div>' ;
                                                                }else{
                                                                    echo'<div class="span2">' .
                                                                    '<label><b>PN </b> (master):</label>' .
                                                                    '<input readonly type="text" class="span12" id="pn_' . $contador_local_autocomplete . '" name="pn[]" value="' . $d->pn . '" />' .
                                                                    '<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>' .
                                                                    '<input type="hidden" id="idProdutos_' .$contador_local_autocomplete. '" name="idProdutos[]" size="3"   value="' . $d->idProdutos . '"/>' .
                                                                    '<input type="hidden" name="contador[]" size="3"   value="' .$contador_local_autocomplete. '"/>' .
                                                                    '</div>' ;
                                                                }
                                                                
                                                                echo '<div class="span1">' .
                                                                '<label>Orç.:</label>' .
                                                                '<input readonly type="text" class="span12" id="orc_' . $contador_local_autocomplete . '" name="orc[]" value="' . $d->tipoOrc . '" />'.
                                                                
                                                                '</div>' .
                                                                '<div class="span2">' .
                                                                '<label>Tipo de Prod.:</label>' .
                                                                '<input readonly type="text" class="span12"  value="' .($d->tipoProd == 'cil'? "Cilindro":($d->tipoProd == 'maq'?"Máquina":($d->tipoProd == 'pec'?"Peça":($d->tipoProd == 'sub'?"Subconjunto":"")))). '" />'.
                                                                '<input readonly type="hidden" class="span12" id="tipo_prod_' . $contador_local_autocomplete . '" name="tipo_prod[]" value="' . $d->tipoProd . '" />';
                                                                
                                                            echo '</div>'.
                                                                '<div class="span5">' .
                                                                '<label>Descrição:</label>' .
                                                                '<input type="text" readonly class="span12" id="descricao_item_' .$contador_local_autocomplete. '" name="descricao_item[]"  value="' . $d->descricao_item . '" />' .
                                                                '</div>' .
                                                                '<div class="span1">' .
                                                                '<label>Tag:</label>' .
                                                                '<input type="text" readonly class="span12" id="tag_' .$contador_local_autocomplete. '" name="tag[]"  value="' . $d->tag . '" />' .
                                                                '</div>' ;
                                                            echo '<div class="span1">';
                                                                echo '<a onclick="receberMercadoria('.$contador_local_autocomplete.')" role="button" data-toggle="modal" class="btn btn-warning"  class="span12" style="/* margin-right: 10px;*/padding: 14px;">Receber</a>';
                                                            echo '</div>';
                                                            echo '</div>';
                                                            
                                                        echo '</div></td>';
                                                    echo '</tr>';
                                                    echo '<tr class="trfilho'.$d->idOrcamento_item.$d->idOs.'" style="display:none">';
                                                        echo '<td>';
                                                        echo '</td>';
                                                        echo '<td>';
                                                        foreach($d->controleEtapa as $c){
                                                            echo '<div>';
                                                                echo '<div class="widget-box" style="margin-top:0px">';                                        
                                                                    echo '<table id="tableHistVale" class="table table-bordered ">';
                                                                        echo '<thead>';
                                                                            echo '<tr>';
                                                                                echo '<th></th>';
                                                                                echo '<th>PN Master</th>';
                                                                                echo '<th>Descrição</th>';
                                                                                echo '<th>QTD</th>';
                                                                                echo '<th>Etapa</th>';
                                                                                echo '<th>Local</th>';
                                                                                echo '<th>Linha</th>';
                                                                                echo '<th>Coluna</th>';
                                                                            echo '</tr>';
                                                                        echo '</thead>';
                                                                        echo ' <tbody>';
                                                                            echo '<tr>';
                                                                                if($c->idStatusEtapaServico!=1){
                                                                                    echo '<td style="width:20px"></td>';
                                                                                }else{
                                                                                    echo '<td style="width:20px"><input type="checkbox" class="pai'.$c->idControleEtapa.'" name="idControleEtapa[]" id="idControleEtapa_'.$contador_local_autocomplete.'" value="'.$c->idControleEtapa.'"></td>';
                                                                                }
                                                                                echo '<td style="width:200px">'.$c->pn.'</td>';
                                                                                echo '<td style="width:650px">'.$c->descricao.'</td>';
                                                                                echo '<td style="width:70px"><input readonly type="text" name="quantidade" class="span12" value="'.$c->quantidade.'"></td>';
                                                                                echo '<td style="width:300px">'.$c->descricaoStatusEtapaServico.'</td>';
                                                                                echo '<td><input type="text" name="local[]" id="local_'.$contador_local_autocomplete.'" class="span12" value="'.$c->local.'"></td>';
                                                                                echo '<td><input type="text" name="linha[]" id="linha_'.$contador_local_autocomplete.'"class="span12" value="'.$c->linha.'"></td>';
                                                                                echo '<td><input type="text" name="coluna[]" id="coluna_'.$contador_local_autocomplete.'"class="span12" value="'.$c->coluna.'"></td>';
                                                                            echo '</tr>';
                                                                        echo '</tbody>';
                                                                    echo '</table>';/*
                                                                echo '</div>';
                                                                echo '<div class="widget-box" style="margin-top:0px">';*/
                                                                if(!empty($c->controleEtapaSubitem) || !empty($c->produtos)){
                                                                    echo '<table id="tableHistVale" class="table table-bordered ">';
                                                                        echo '<thead>';
                                                                            echo '<tr>';
                                                                                echo '<th></th>';
                                                                                echo '<th>PN</th>';
                                                                                echo '<th>Descrição</th>';
                                                                                echo '<th>QTD</th>';
                                                                                echo '<th>Etapa</th>';
                                                                                echo '<th>Local</th>';
                                                                                echo '<th>Linha</th>';
                                                                                echo '<th>Coluna</th>';
                                                                            echo '</tr>';
                                                                        echo '</thead>';
                                                                        echo ' <tbody>';
                                                                            foreach($c->controleEtapaSubitem as $d){
                                                                                echo '<tr>';
                                                                                    if($d->idStatusEtapaServico!=1){
                                                                                        echo '<td style="width:20px"></td>';
                                                                                    }else{
                                                                                        echo '<td style="width:20px"><input type="checkbox" class="filho'.$c->idControleEtapa.'" name="idControleEtapaSubitem[]" id="idControleEtapaSubitem_'.$contador_local_autocomplete.'" value="'.$d->idControleEtapaSubitem.'"></td>';
                                                                                    }
                                                                                    echo '<td style="width:200px">'.$d->pn.'</td>';
                                                                                    echo '<td style="width:650px">'.$d->descricaoItem.'</td>';
                                                                                    echo '<td style="width:70px"><input type="text" name="quantidadeSub" id="quantidadeSub_'.$contador_local_autocomplete.'" class="span12" value="'.$d->quantidade.'"></td>';
                                                                                    echo '<td style="width:300px">'.$d->descricaoStatusEtapaServico.'</td>';
                                                                                    echo '<td><input type="text" name="localSub[]" id="localSub_'.$contador_local_autocomplete.'" class="span12" value="'.$d->local.'"></td>';
                                                                                    echo '<td><input type="text" name="linhaSub[]" id="linhaSub_'.$contador_local_autocomplete.'"class="span12" value="'.$d->linha.'"></td>';
                                                                                    echo '<td><input type="text" name="colunaSub[]" id="colunaSub_'.$contador_local_autocomplete.'"class="span12" value="'.$d->coluna.'"></td>';
                                                                                echo '</tr>';
                                                                            }
                                                                            foreach($c->produtos as $d){
                                                                                echo '<tr>';                                                                                    
                                                                                    echo '<td style="width:20px"><input type="checkbox" class="filho'.$c->idControleEtapa.'" name="idNovoControleEtapaSubitem'.$c->idControleEtapa.'[]" id="idNovoControleEtapaSubitem_'.$contador_local_autocomplete.'" value="'.$d->idProdutos.'"><input type="hidden" id="idEtapa_'.$contador_local_autocomplete.'" value="'.$c->idControleEtapa.'"></td>';                                                                                    
                                                                                    echo '<td style="width:200px">'.$d->pn.'</td>';
                                                                                    echo '<td style="width:650px">'.$d->descricao.'</td>';
                                                                                    echo '<td style="width:70px"><input type="text" name="quantidadeNovo[]" id="quantidadeNovo_'.$contador_local_autocomplete.'" value="0" class="span12"></td>';
                                                                                    echo '<td style="width:300px">Aguardando Recebimento</td>';                                                                                    
                                                                                    echo '<td><input type="text" name="localNovo[]" id="localNovo_'.$contador_local_autocomplete.'" class="span12" value=""></td>';
                                                                                    echo '<td><input type="text" name="linhaNovo[]" id="linhaNovo_'.$contador_local_autocomplete.'"class="span12" value=""></td>';
                                                                                    echo '<td><input type="text" name="colunaNovo[]" id="colunaNovo_'.$contador_local_autocomplete.'"class="span12" value=""></td>';
                                                                                echo '</tr>';
                                                                            }
                                                                        echo '</tbody>';
                                                                    echo '</table>';
                                                                }
                                                                    
                                                                echo '</div>';
                                                            echo '</div>';
                                                            echo '<script type="text/javascript">
                                                            $(".pai'.$c->idControleEtapa.'").click(function(){
                                                                $(".filho'.$c->idControleEtapa.'").not(this).prop("checked", this.checked);
                                                            });
                                                            </script>';
                                                        }
                                                        echo '</td>';
                                                       
                                                    echo '</tr>';
                                                    $contador_local_autocomplete ++;
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
<div id="modal-observacao" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/controle/confirmarrecebimento"  enctype="multipart/form-data" method="post" class="form-horizontal">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Recebimento</h5>
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">Confirmar o recebimento dos itens</h5><!--
            <p style="text-align: center">(Certifique-se de que as alterações da peritagem foram salvas.)</p>
            <p style="text-align: center">(Após a confirmação não será possivel alterar as informações dessa peritagem sem a autorização do comercial.)</p> -->
            <input type="hidden" name="idOrcamentoEtapa" value="<?php echo $result->idOrcamentos?>">
            <label>NF Cliente</label>
            <input class="span12" name="nfcliente" type="text" value="<?php echo $result->num_nf?>">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Itens</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style="margin-left: 0">
                                <div class="span12" id="divCadastrarOs">
                                    <div class="widget-box" style="margin-top:0px"  id="confirmarRecebimento">
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    function openclose(td, valor) {
        var tr = document.querySelector(".trfilho" + valor);

        if (tr.style.display == "table-row" || tr.style.display == "") {
            $(".trfilho" + valor).hide('fast');
            $(td).parent('tr').css('background-color', '');
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");
        } else {
            $(".trfilho" + valor).show('fast');
            $(td).parent('tr').css('background-color', '#efefef');
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }
    }
    function receberMercadoria(valor){
        var controleEtapa = document.querySelectorAll("#idControleEtapa_"+valor);
        var controleEtapaSubitem = document.querySelectorAll("#idControleEtapaSubitem_"+valor)
        var quantidadeSubitem = document.querySelectorAll("#quantidadeSub_"+valor)
        var novoControleEtapaSubitem = document.querySelectorAll("#idNovoControleEtapaSubitem_"+valor)
        var quantidadeNovo = document.querySelectorAll("#quantidadeNovo_"+valor)
        var idEtapa = document.querySelectorAll("#idEtapa_"+valor)

        var arrayControleEtapa = [];
        var arrayControleEtapaSubitem = [];
        var arrayNovoControleEtapaSubitem = [];
        for(x=0;x<controleEtapa.length;x++){
            if(controleEtapa[x].checked){
                arrayControleEtapa.push(controleEtapa[x].value);
            }
        }
        for(x=0;x<controleEtapaSubitem.length;x++){
            if(controleEtapaSubitem[x].checked){
                if(quantidadeSubitem[x].value < 1){
                    alert("A quantidade deve ser maior do que 0.")
                    return;
                }
                arrayControleEtapaSubitem.push({"id":controleEtapaSubitem[x].value,"quantidade":quantidadeSubitem[x].value});
            }
        }
        for(x=0;x<novoControleEtapaSubitem.length;x++){
            if(novoControleEtapaSubitem[x].checked){
                if(quantidadeNovo[x].value < 1){
                    alert("A quantidade deve ser maior do que 0.")
                    return;
                }
                arrayNovoControleEtapaSubitem.push({"id":novoControleEtapaSubitem[x].value,"quantidade":quantidadeNovo[x].value,"idEtapa":idEtapa[x].value});
            }
        }
        if(arrayControleEtapaSubitem.length <= 0 && arrayControleEtapa.length <= 0 && arrayNovoControleEtapaSubitem <=0){
            alert("Nenhum item selecionado.");
            return;
        }
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/controle/recebermercadoria",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                arrayControleEtapa: arrayControleEtapa,
                arrayControleEtapaSubitem:arrayControleEtapaSubitem,
                arrayNovoControleEtapaSubitem:arrayNovoControleEtapaSubitem
            },
            success: function(data2) {
                carregarmodalconfirmacao(data2.itens)
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
    function carregarmodalconfirmacao(itens){
        var html = '';
        console.log(itens);
        if(itens.arrayControleEtapa.length>0){
            html += '<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">'+
                '<thead>'+
                    '<tr>'+
                        '<th></th>'+
                        '<th>PN Master</th>'+
                        '<th>Descrição</th>'+
                        '<th>QTD</th>'+
                        '<th>Etapa</th>'+
                        '<th>Local</th>'+
                        '<th>Linha</th>'+
                        '<th>Coluna</th>'+
                    '</tr>'+
                '</thead>'+
                '<tbody>';
                for(x=0;x<itens.arrayControleEtapa.length;x++){
                    html += '<tr>';
                        html += '<td>';
                            
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayControleEtapa[x].pn;
                            html += '<input type="hidden" name="idControleEtapa[]" value="'+itens.arrayControleEtapa[x].idControleEtapa+'">';
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayControleEtapa[x].descricao;
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayControleEtapa[x].quantidade
                            html += '<input type="hidden" name="quantidade[]" value="'+itens.arrayControleEtapa[x].quantidade+'">';
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayControleEtapa[x].descricaoStatusEtapaServico
                        html += '</td>';
                        html += '<td>';
                            if(itens.arrayControleEtapa[x].local)
                                html += itens.arrayControleEtapa[x].local
                        html += '</td>';
                        html += '<td>';
                            if(itens.arrayControleEtapa[x].linha)
                                html += itens.arrayControleEtapa[x].linha
                        html += '</td>';
                        html += '<td>';
                            if(itens.arrayControleEtapa[x].coluna)
                                html += itens.arrayControleEtapa[x].coluna
                        html += '</td>';
                    html += '</tr>';
                }
                html += '</tbody>'+
            '</table>';
        }
        if(itens.arrayControleEtapaSubitem.length>0 || itens.arrayNovoControleEtapaSubitem.length>0){
            html += '<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">'+
                '<thead>'+
                    '<tr>'+
                        '<th></th>'+
                        '<th>PN</th>'+
                        '<th>Descrição</th>'+
                        '<th>QTD</th>'+
                        '<th>Etapa</th>'+
                        '<th>Local</th>'+
                        '<th>Linha</th>'+
                        '<th>Coluna</th>'+
                    '</tr>'+
                '</thead>'+
                '<tbody>';
                for(x=0;x<itens.arrayControleEtapaSubitem.length;x++){
                    html += '<tr>';
                        html += '<td>';
                            
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayControleEtapaSubitem[x].pn;
                            html += '<input type="hidden" name="idControleEtapaSubitem[]" value="'+itens.arrayControleEtapaSubitem[x].idControleEtapaSubitem+'">';
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayControleEtapaSubitem[x].descricao;
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayControleEtapaSubitem[x].quantidade
                            html += '<input type="hidden" name="quantidadeSubitem[]" value="'+itens.arrayControleEtapaSubitem[x].quantidade+'">';
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayControleEtapaSubitem[x].descricaoStatusEtapaServico
                        html += '</td>';
                        html += '<td>';
                            if(itens.arrayControleEtapaSubitem[x].local)
                                html += itens.arrayControleEtapaSubitem[x].local
                        html += '</td>';
                        html += '<td>';
                            if(itens.arrayControleEtapaSubitem[x].linha)
                                html += itens.arrayControleEtapaSubitem[x].linha
                        html += '</td>';
                        html += '<td>';
                            if(itens.arrayControleEtapaSubitem[x].coluna)
                                html += itens.arrayControleEtapaSubitem[x].coluna
                        html += '</td>';
                    html += '</tr>';
                }
                for(x=0;x<itens.arrayNovoControleEtapaSubitem.length;x++){
                    html += '<tr>';
                        html += '<td>';
                            
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayNovoControleEtapaSubitem[x].pn;
                            html += '<input type="hidden" name="idProduto[]" value="'+itens.arrayNovoControleEtapaSubitem[x].idProdutos+'">';
                            html += '<input type="hidden" name="idEtapaNovoSubitem[]" value="'+itens.arrayNovoControleEtapaSubitem[x].idControleEtapa+'">';
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayNovoControleEtapaSubitem[x].descricao;
                        html += '</td>';
                        html += '<td>';
                            html += itens.arrayNovoControleEtapaSubitem[x].quantidade
                            html += '<input type="hidden" name="quantidadeNovoSubitem[]" value="'+itens.arrayNovoControleEtapaSubitem[x].quantidade+'">';
                        html += '</td>';
                        html += '<td>';
                            html += 'Aguardando Recebimento';
                        html += '</td>';
                        html += '<td>';
                           
                        html += '</td>';
                        html += '<td>';
                            
                        html += '</td>';
                        html += '<td>';
                        html += '</td>';
                    html += '</tr>';
                }
                html += '</tbody>'+
            '</table>';
        }
        $("#confirmarRecebimento").empty();
        $("#confirmarRecebimento").append(html);
        $("#modal-observacao").modal("show");

    }    
</script>