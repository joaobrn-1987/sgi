<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>js/maskmoney.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/ckeditor/ckeditor.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.10.2.min.js"></script>-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<style>

</style>
<script type="text/javascript">
    var contador_global_autocomplete = 0;
</script>
<script type="text/javascript">
    window.addEventListener('keydown', function(e) {
        if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
            if (e.target.nodeName == 'INPUT' && e.target.type == 'text') {
                e.preventDefault();
                return false;
            }
        }
    }, true);
</script>
<script>
    //document.addEventListener("keydown", function(e) {
    //if(e.keyCode === 13) {

    // e.preventDefault();

    //}
    //});
</script>
<div id="modalCadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/clientes/cadastrarSolicitante" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">SGI - Cadastrar Solicitante</h3>
        </div>
        <div class="modal-body">


            <div class="control-group">
                <label for="nome" class="control-label">Solicitante<span class="required">*</span></label>
                <div class="controls">
                    <input id="nome" type="text" name="nome" value="" class="span6" />
                </div>
            </div>
            <div class="control-group">
                <label for="email_solici" class="control-label">Email<span class="required">*</span></label>
                <div class="controls">
                    <input id="email_solici" type="text" name="email_solici" value="" class="span6" />
                    <input id="orcament" type="hidden" name="orcament" value="1" />
                </div>
            </div>
            <div class="control-group">
                <label for="idClientes" class="control-label">Cliente<span class="required">*</span></label>
                <div class="controls">
                    <select class="form-control" name="idClientes">
                        <option selected="selected" disabled="disabled" value="">Escolher</option>
                        <?php foreach ($dados_clientes as $p) { ?>

                            <option value="<?php echo $p->idClientes; ?>"><?php echo $p->nomeCliente; ?> | CNPJ: <?php echo $p->documento; ?></option>
                        <?php } ?>
                </div>
                </select>
            </div>
        </div>


</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-success">Cadastrar</button>
</div>
</form>
</div>
<!--<form action="<?php echo base_url() ?>index.php/orcamentos/adicionarorcamento" id="formOrcamento" method="post"  >-->
<form action="<?php echo current_url(); ?>" id="formOrcamento" method="post"  name='form'>
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Cadastro de Orçamento</h5>
                </div>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
                    <a href="#modalCadastrar" data-toggle="modal" role="button" class="btn btn-success">Cadastrar Solicitante</a>
                <?php } ?>
                <div class="widget-content nopadding">


                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <ul class="nav nav-tabs">
                            <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes do orçamento</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">

                                <div class="span12" id="divCadastrarOs">
                                    <?php if ($custom_error != '') {
                                        echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                                    } ?>



                                    <div class="span12" style="padding: 0.2%">
                                        <div class="span4" class="control-group">
                                            <label for="idEmitente" class="control-label"><span class="required">*</span>Emitente:</label>

                                            <select class="span12 form-control" name="idEmitente">

                                                <?php foreach ($dados_emitente as $e) { ?>

                                                    <option value="<?php echo $e->id; ?>" <?php if ($e->id == 1) {
                                                                                                echo "selected='selected'";
                                                                                            } ?>><?php echo $e->nome; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="span5" class="control-group">

                                            <label for="cliente"><span class="required">*</span>Cliente</label>
                                            <input id="cliente" class="span12" class="controls" type="text" name="cliente" value="" size='50' />
                                            <input id="clientes_id" type="hidden" name="clientes_id" value="" />
                                        </div>
                                        <div class="span3" class="control-group">

                                            <label for="idSolicitante" class="control-label"><span class="required">*</span>Solicitante:</label>

                                            <select class="span12 recebe-solici" class="controls" name="idSolicitante" id="idSolicitante">


                                            </select>
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 0.2%; margin-left: 0">
                                        <div class="span3" class="control-group">
                                            <label for="idstatusOrcamento" class="control-label"><span class="required">*</span>Status Orçamento:</label>

                                            <select class="span12 form-control" name="idstatusOrcamento">

                                                <?php foreach ($dados_statusorcamento as $o) { ?>

                                                    <option value="<?php echo $o->idstatusOrcamento; ?>" <?php if ($o->idstatusOrcamento == 11) {
                                                                                                                echo "selected='selected'";
                                                                                                            } ?>><?php echo $o->nome_status_orc; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="span2" class="control-group">

                                            <label for="idVendedor" class="control-label"><span class="required">*</span>Vendedor:</label>

                                            <select class="span12 form-control" name="idVendedor">

                                                <?php foreach ($dados_vendedor as $v) { ?>

                                                    <option value="<?php echo $v->idVendedor; ?>" <?php if ($v->idVendedor == 1) {
                                                                                                        echo "selected='selected'";
                                                                                                    } ?>><?php echo $v->nomeVendedor; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="idGerente" class="control-label"><span class="required">*</span>Gerente:</label>

                                            <select class="span12 form-control" name="idGerente">

                                                <?php foreach ($dados_gerente as $g) { ?>

                                                    <option value="<?php echo $g->idGerente; ?>" <?php if ($g->idGerente == 1) {
                                                                                                        echo "selected='selected'";
                                                                                                    } ?>><?php echo $g->nome; ?></option>
                                                <?php } ?>

                                            </select>

                                        </div>

                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label"><span class="required">*</span>Grupo Serviço:</label>

                                            <select class="span12 form-control" name="idGrupoServico">

                                                <?php foreach ($dados_gruposervico as $gs) { ?>

                                                    <option value="<?php echo $gs->idGrupoServico; ?>" <?php if ($gs->idGrupoServico == 1) {
                                                                                                            echo "selected='selected'";
                                                                                                        } ?>><?php echo $gs->nome; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idNatOperacao" class="control-label"><span class="required">*</span>Nat. Operação:</label>

                                            <select class="span12 form-control" name="idNatOperacao">

                                                <?php foreach ($dados_natoperacao as $nt) { ?>

                                                    <option value="<?php echo $nt->idNatOperacao; ?>" <?php if ($nt->idNatOperacao == 2) {
                                                                                                            echo "selected='selected'";
                                                                                                        } ?>><?php echo $nt->nome; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="span12" style="padding: 0.2%; margin-left: 0">


                                        <div class="span1 "  class="control-group">

                                            <label for="referencia" class="control-label">Val.Prop.:</label>

                                            <input id="validade" class="span12" type="text" name="validade" value="20" size="15" title="Validade da proposta" />
                                        </div>

                                        <div class="span3" class="control-group">
                                            <label for="cond_pgto" class="control-label">Condição Pagamento:</label>

                                            <input class="span12" id="cond_pgto" type="text" name="cond_pgto" value="" size="50" />
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="cond_pgto" class="control-label">Garantia Serv.</label>

                                            <input class="span12" id="garantia_servico" type="text" name="garantia_servico" value="" size="50" />
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="entrega" class="control-label">Entrega:
                                                <input type="radio" name="entrega" checked="yes" VALUE="FOB" style="margin:0px"/>FOB
                                                <input type="radio" name="entrega" VALUE="CIF" style="margin:0px"/>CIF
                                                <input type="radio" name="entrega" VALUE="OUTROS" style="margin:0px"/>Outros 
                                            </label>

                                            <input class="span6" id="entregaoutros" type="text" name="entregaoutros" value="" size="50" />
                                        </div>
                                        <div class="span3" class="control-group">

                                            <label for="referencia" class="control-label">Referência:</label>

                                            <input id="referencia" class="span12" type="text" name="referencia" value="" />
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 0.2%; margin-left: 0">

                                        <div class="span2" class="control-group">
                                            <label for="num_pedido" class="control-label">Num. Pedido:</label>

                                            <input id="num_pedido" class="span12" type="text" name="num_pedido" value="" />
                                        </div>


                                        <div class="span2" class="control-group">
                                            <label for="num_nf" class="control-label">Num. Nota Fiscal:</label>

                                            <input id="num_nf" type="text" name="num_nf" class="span12" value="" />
                                        </div>
                                        <div class="span8" class="control-group">
                                            <label for="obs" class="control-label">OBS</label>
                                            <textarea id="obs" rows="5" cols="100" class="span12" name="obs"></textarea>
                                        </div>
                                    </div>




                                </div>

                            </div>

                        </div>

                    </div>


                    .

                </div>

            </div>
        </div>
    </div>

    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Cadastro de Itens </h5> <a href="#" onclick="duplicarCampos();" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Itens</a>

        </div>

        <div class="widget-content nopadding">


            <table class="table table-bordered ">
                
                <tbody  id="destino">
                    
<!--
                    <div class="span12" style="padding: 0.2%; margin-left: 0">
                                                                                                      
                    </div>    -->
                </tbody>
            </table>
        </div>
    </div>
        <a href="#" onclick="duplicarCampos();" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Itens</a>

    <div class="widget-box" class="span12">

        <table align='right' border='0' width='40%'>
            <tr>
                <td align='right'>
                    SUBTOTAL R$:
                </td>
                <td align='center'>

                    <input name="subtotal_calculo" type="text" id="subtotal_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
                </td>
    </div>



    </tr>
    <tr>
        <td align='right'>
            DESCONTO R$:
        </td>
        <td align='center'>
            <input name="desconto_calculo" type="text" id="desconto_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
        </td>
    </tr>
    <tr>
        <td align='right'>
            VALOR IPI R$:
        </td>
        <td align='center'>
            <input name="ipi_calculo" type="text" id="ipi_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
        </td>
    </tr>
    <tr>
        <td align='right'>
            <B>TOTAL ORÇAMENTO R$:</B>
        </td>
        <td align='center'>
            <B>
                <input name="total_calculo" type="text" id="total_calculo" style="font-family: Arial; font-weight: bold; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">

            </B>
        </td>
    </tr>
    </table>


    </div><br><br><br>
    <div class="form-actions" align='center'>

        <a 'type="button" 'type="submit" class="btn btn-success" onclick="verificarInfo()"><i class="icon-plus icon-white"></i> Salvar</a>
        <a href="<?php echo base_url() ?>index.php/orcamentos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>

    </div>


</form>



<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="">SGI - Buscar PN</h3>
    </div>
    <div class="modal-body">


        <form class="form-inline" action="" method="post">
            <select class="form-control" name="field">

                <option value="pn" selected="selected">PN</option>
                <option value="descricao">Descricao</option>

                <option value="referencia">Referência</option>

            </select>
            <input class="form-control" type="text" name="search" value="" placeholder="Search...">
            <input class="btn btn-default" type="submit" name="filter" value="Filtrar">
        </form>
        <table class="table table-bordered ">
            <thead>
                <tr style="background-color: #2D335B">
                    <th>#</th>
                    <th>Descrição</th>
                    <th>PN</th>
                    <th>Referencia</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results_pn as $retorno) {
                    echo '<tr>';
                    echo '<td>' . $retorno->idProdutos . '</td>';
                    echo '<td>' . $retorno->descricao . '</td>';
                    echo '<td>' . $retorno->pn . '</td>';
                    echo '<td>' . $retorno->referencia . '</td>';


                    echo '<td>';

                ?>
                    <button type="button" class="btn btn-primary btn-mini" data-toggle="modal" data-dismiss="modal" onclick="mostraDados('<?php echo $retorno->idProdutos; ?>','<?php echo $retorno->descricao; ?>','<?php echo $retorno->pn; ?>')"> enviar </button>
                <?php

                    echo '</td>';
                    echo '</tr>';
                } ?>
                <tr>

                </tr>
            </tbody>
        </table>



    </div>


    <!-- fim modal -->

    <script type="text/javascript">
        function verificarItens(){
            var tipoOrc = Array.apply(null,document.querySelectorAll("input[name='orc[]']"));
            var tipoProd = Array.apply(null,document.querySelectorAll("input[name='tipo_prod[]']"));
            var verifyOrc = true;
            var verifyProd = true;
            tipoOrc.forEach((elemento)=>{
                if(elemento.options[elemento.selectedIndex].value == ""){
                    verifyOrc = false;
                }
            })
            tipoProd.forEach((elemento)=>{
                if(elemento.options[elemento.selectedIndex].value == ""){
                    verifyProd = false;
                }
            })
            if(verifyProd && verifyOrc){
                document.getElementById("formOrcamento").submit();                
            }else{
                alert("Verifique se foi selecionado o tipo de orçamento e o tipo de produto");
            }
            
        }
        $(document).ready(function() {


            $("#cliente").autocomplete({
                source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteCliente",
                minLength: 1,
                select: function(event, ui) {

                    $("#clientes_id").val(ui.item.id);

                    getValor(ui.item.id);

                }
            });

            duplicarCampos();


            /*$("#pn_0").autocomplete({
            source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
            minLength: 1,
            select: function( event, ui ) {

                 $("#idProdutos_0").val(ui.item.id);
                 
                
					

            }
      });*/



        });

        function Formata_Moeda(valor) {
            // Remove todos os .
            valor = valor.replace(/\./g, "");

            // Troca todas as , por .
            valor = valor.replace(",", ".");

            // Converte para float
            valor = parseFloat(valor);
            valor = parseFloat(valor) || 0.0;

            return valor;
        }

        function Formata_Dinheiro(n) {
            return n.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
        }


        function calculaSubTotal(x) {
            //alert('globalcalcula'+contador_global_autocomplete);
            var total_calculo = 0;
            var ipi_calculo = 0;
            var desconto_calculo = 0;
            var subtotal_calculo = 0;
            for (i = 0; i < contador_global_autocomplete; i++) {


                if ($('#val_unit_' + i).val() != undefined) {
                    var valorunit = $('#val_unit_' + i).val();
                    //alert('unit'+valorunit);
                    //valorunit = valorunit.toString().replace( ".", "" );
                    //valorunit = valorunit.toString().replace( ",", "." );

                    valorunit = Formata_Moeda(valorunit);
                    //valorunit.toLocaleString('pt-br', {minimumFractionDigits: 2});	

                    /*valorunit=	valorunit.replace(/\./g, "");
                    valorunit=	valorunit.replace(/,/g, ".");*/

                    var desconto = $('#desconto_' + i).val();
                    //desconto = desconto.toString().replace( ".", "" );
                    //desconto = desconto.toString().replace( ",", "." );
                    /*desconto=	desconto.replace(/\./g, "");
                    desconto=	desconto.replace(/,/g, ".");*/

                    desconto = Formata_Moeda(desconto);
                    //desconto.toLocaleString('pt-br', {minimumFractionDigits: 2});				

                    var valoripi = $('#val_ipi_' + i).val();
                    //valoripi = valoripi.toString().replace( ".", "" );
                    //valoripi = valoripi.toString().replace( ",", "." );
                    /*desconto=	desconto.replace(/\./g, "");
                    desconto=	desconto.replace(/,/g, ".");*/

                    valoripi = Formata_Moeda(valoripi);
                    //valoripi.toLocaleString('pt-br', {minimumFractionDigits: 2});
                    //valoripi=valoripi+'';
                    /*if(valoripi.indexOf('.')<0)
                    { 
                    	valoripi=valoripi+".00";
                    }
                    else
                    { 
                    	dp_impostoex=valoripi.split(".");
                    	if(dp_impostoex[1].length==1)
                    	{
                    		valoripi=valoripi+"0";
                    	}
                    	else if(dp_impostoex[1].length>=2)
                    	{
                    		dp_impostoexex=dp_impostoex[1].split("");
                    		campo0=parseInt(dp_impostoexex[0]);
                    		campo1=parseInt(dp_impostoexex[1]);
                    		campo2=parseInt(dp_impostoexex[2]);
                    		//if(campo2>5){ campo1++; }
                    		valoripi=dp_impostoex[0]+'.'+campo0+campo1;
                    	}
                    }*/




                    var qtd = $('#qtd_' + i).val();


                    //var total = ((valorunit * qtd) - desconto) *  valoripi / 100;
                    var total1 = (valorunit * qtd);
                    var total2 = total1 * valoripi / 100;

                    //total1=Formata_Moeda(total1);
                    //total1.toLocaleString('pt-br', {minimumFractionDigits: 2});			
                    //total2=(total2);	
                    //total2.toLocaleString('pt-br', {minimumFractionDigits: 2});	
                    var total3 = total1 + total2 - desconto;

                    //total3=parseFloat(total3);	
                    //total3=Formata_Moeda(total3);	

                    //total3.toLocaleString('pt-br', {minimumFractionDigits: 2});
                    //alert(total3);
                    subtotal_calculo = subtotal_calculo + total1;
                    ipi_calculo = ipi_calculo + total2;
                    desconto_calculo = desconto_calculo + desconto;

                    //desconto_calculo=parseFloat(desconto_calculo);
                    //desconto_calculo.toLocaleString('pt-br', {minimumFractionDigits: 2});

                    total_calculo = total_calculo + total3;

                    /*total3 = parseFloat(total3.toFixed(2));
                    total3=(total3).toLocaleString(); 
                    
                    total1 = parseFloat(total1.toFixed(2));
                    total1=(total1).toLocaleString(); */



                    $('#subtot_' + i).val(Formata_Dinheiro(total1));
                    $('#vlr_total_' + i).val(Formata_Dinheiro(total3));



                }

            }
            //document.getElementByID("desconto_calculo").innerHTML += desconto_calculo

            $('#subtotal_calculo').val(Formata_Dinheiro(subtotal_calculo));
            $('#total_calculo').val(Formata_Dinheiro(total_calculo));
            $('#ipi_calculo').val(Formata_Dinheiro(ipi_calculo));
            $('#desconto_calculo').val(Formata_Dinheiro(desconto_calculo));


            /*$("#subtotal_calculo").text(subtotal_calculo).toLocaleString();
            $("#total_calculo").text(total_calculo).toLocaleString();
            $("#ipi_calculo").text(ipi_calculo).toLocaleString();
            $("#desconto_calculo").text(desconto_calculo).toLocaleString();
            */


            //alert(subtotal_calculo);

        }

        function getValor(cliente) {
            $.ajax({
                /*url: 'http://localhost/sgi/index.php/orcamentos/autoCompleteSolicitante',
                type: 'POST',
                data: {id: cliente},
                dataType: 'json',
                success: function(json) {*/

                url: '<?php echo base_url('index.php/orcamentos/autoCompleteSolicitante') ?>?id=' + cliente,
                dataType: 'json',
                success: function(json) {
                    /*type:'POST',
                url : '<?php echo base_url('index.php/orcamentos/autoCompleteSolicitante/') ?>/' + cliente,
                success: function(json){*/
                    var txt_solicitante = "<option value=''>--Selecione--</option>";
                    $.each(json, function(index, solici) {
                        txt_solicitante += "<option value='" + solici.idSolicitante + "'>" + solici.nome + "</option>";
                    });
                    $(".recebe-solici").html(txt_solicitante);

                }
            });


        }


        $(document).ready(function() {
            $(".money").maskMoney();
            $('#formOrcamento').validate({
                rules: {
                    idEmitente: {
                        required: true
                    },
                    cliente: {
                        required: true
                    },
                    idSolicitante: {
                        required: true
                    },
                    idstatusOrcamento: {
                        required: true
                    },
                    idGerente: {
                        required: true
                    },
                    idVendedor: {
                        required: true
                    },
                    idGrupoServico: {
                        required: true
                    },
                    idNatOperacao: {
                        required: true
                    }
                    /*estado:{ required: true},
                    cep:{ required: true}*/
                },
                messages: {
                    idEmitente: {
                        required: 'Campo Requerido.'
                    },
                    cliente: {
                        required: 'Campo Requerido.'
                    },
                    idSolicitante: {
                        required: 'Campo Requerido.'
                    },
                    idstatusOrcamento: {
                        required: 'Campo Requerido.'
                    },
                    idGerente: {
                        required: 'Campo Requerido.'
                    },
                    idVendedor: {
                        required: 'Campo Requerido.'
                    },
                    idGrupoServico: {
                        required: 'Campo Requerido.'
                    },
                    idNatOperacao: {
                        required: 'Campo Requerido.'
                    }
                    /*cep:{ required: 'Campo Requerido.'}*/

                },

                errorClass: "help-inline",
                errorElement: "span",
                highlight: function(element, errorClass, validClass) {
                    $(element).parents('.control-group').addClass('error');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).parents('.control-group').removeClass('error');
                    $(element).parents('.control-group').addClass('success');
                }
            });


        });


        function removerCampos(obj) {
            var div = $(obj).parent();
            valor = div.find("input:eq(0)").val();

            $(obj).parent().parent().remove();
            calculaSubTotal();
        }
    </script>

    <script type="text/javascript">
        $('.dinheiro').mask('#.##0,00', {
            reverse: true
        });

        function closetable (){			
			      
            for(x=0;x<contador_global_autocomplete;x++){
                tr = document.querySelector(".trfilho"+x);
                if(tr.style.display == "table-row" || tr.style.display == ""){
                    $(".trfilho"+x).hide('fast');
                    $('.tdpai'+x).parent('tr').css('background-color', '');
                    $('.tdpai'+x).find("a > i").removeClass("fa-minus");
                    $('.tdpai'+x).find("a > i").addClass("fa-plus");  
                }
            }
        }

        function duplicarCampos() {

            

            var contador_local_autocomplete = contador_global_autocomplete;
            var cloneDiv = '';
            if(contador_global_autocomplete>0){
                closetable();
                //cloneDiv = '<div class="span12" style="/*! border: 1px solid; */padding: 0.2%; margin-left: 0;border-bottom: 1px solid grey;margin-bottom: 20px;"></div>';
            }/*
            cloneDiv += '<div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">'+
                            '<div class="span12" style="text-align: end;">'+
                                '<a href="#"  onclick="removerCampos(this);" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>'+
                            '</div>'+
                            '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                '<div class="span1">'+
                                    '<label>Orç.:</label>'+
                                    '<select id="orc_'+contador_local_autocomplete+'" name="orc[]" class="span12">'+
                                        '<option value="fab">FAB</option>'+
                                        '<option value="serv">SERV</option>'+
                                    '</select>'+                               
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Tipo de Prod.:</label>'+
                                    '<select id="tipo_prod_'+contador_local_autocomplete+'" name="tipo_prod[]" class="span12">'+
                                        '<option value="cil">Cilindro</option>'+
                                        '<option value="maq">Máquina</option>'+
                                        '<option value="pec" selected>Peça</option>'+
                                        '<option value="sub">Subconjunto</option>'+
                                    '</select>'+                               
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>PN:</label>'+
                                    '<input type="text" class="span12" id="pn_'+contador_local_autocomplete+'" name="pn[]" value="" />'+     
                                    '<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>'+
                                    '<input type="hidden" id="idProdutos_'+contador_local_autocomplete+'" name="idProdutos[]" size="3"   value=""/>'+                         
                                '</div>'+
                                '<div class="span5">'+
                                    '<label>Descrição:</label>'+
                                    '<input type="text" class="span12" id="descricao_item_'+contador_local_autocomplete+'" name="descricao_item[]"  value="" />'+                              
                                '</div>'+
                                '<div class="span1">'+
                                    '<label>Tag:</label>'+
                                    '<input type="text" class="span12" id="tag_'+contador_local_autocomplete+'" name="tag[]"  value="" />'+                              
                                '</div>'+
                                '<div class="span1">'+
                                    '<label>Qtd. Estq.:</label>'+
                                    '<input type="text" class="span12" id="qtdest_'+contador_local_autocomplete+'" name="qtdest[]"  value="" disabled/>'+                              
                                '</div>'+
                            '</div>'+
                            '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                '<div class="span2">'+
                                    '<label>Ultima O.S.:</label>'+
                                    '<input type="text" class="span12" id="cOs_'+contador_local_autocomplete+'" name="cOs[]" value="" disabled/> '+                             
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Custo Insumo:</label>'+
                                    '<input type="text" class="span12" id="custoIns_'+contador_local_autocomplete+'" name="custoIns[]"  value="" disabled/>'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Custo HR/Maq</label>'+
                                    '<input type="text" class="span12" id="custoFab_'+contador_local_autocomplete+'" name="custoFab[]"  value="" disabled/>'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Custo Impostos</label>'+
                                    '<input type="text" class="span12" id="custoIcms_'+contador_local_autocomplete+'" name="custoIcms[]"  value="" disabled/>'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Custo Frete</label>'+
                                    '<input type="text" class="span12" id="custoFrete_'+contador_local_autocomplete+'" name="custoFrete[]"  value="" disabled/>'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Custo Total</label>'+
                                    '<input type="text" class="span12" id="custoTotal_'+contador_local_autocomplete+'" name="custoTotal[]"  value="" disabled/>'+                              
                                '</div>'+
                            '</div>'+
                            '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                '<div class="span1">'+
                                    '<label>QTD:</label>'+
                                    '<input type="text" class="span12" id="qtd_'+contador_local_autocomplete+'" name="qtd[]" onblur="calculaSubTotal('+contador_local_autocomplete+');" onclick="this.select();" value="" />'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Vl.Unit.:</label>'+
                                    '<input type="text" class="span12" id="val_unit_'+contador_local_autocomplete+'" name="val_unit[]" value="0,00" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"   onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" /> '+                             
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Sub.Tot.:</label>'+
                                    '<input type="text" class="span12" id="subtot_'+contador_local_autocomplete+'" name="subtot[]" value="0,00" readonly/>'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Prazo:</label>'+
                                    '<input type="text" class="span12" id="prazo_'+contador_local_autocomplete+'" name="prazo[]" onclick="this.select(); value="" /> '+                             
                                '</div> '+ 
                                '<div class="span2">'+
                                    '<label>Desconto:</label>'+
                                    '<input type="text" class="span12" id="desconto_'+contador_local_autocomplete+'" name="desconto[]" value="0,00" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />'+                              
                                '</div>'+ 
                                '<div class="span1">'+
                                    '<label>IPI%:</label>'+
                                    '<input type="text" class="span12" id="val_ipi_'+contador_local_autocomplete+'" name="val_ipi[]" value="0,00" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />'+                              
                                '</div>'+  
                                '<div class="span2">'+
                                    '<label>Valor Tot.:</label>'+
                                    '<input type="text" class="span12" id="vlr_total_'+contador_local_autocomplete+'" name="vlr_total[]" value="0,00" />'+                              
                                '</div>'+                                                             
                            '</div>'+
                            '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                '<div class="span10">'+
                                    '<label>Detalhamento: </label>'+
                                    '<textarea id="detalhe_'+contador_local_autocomplete+'"  cols="50" class="span10" name="detalhe[]"></textarea>'+
                                '</div>'+
                            '</div>'+
                        '</div> ';*/
            cloneDiv = '<tr class="trpai'+contador_local_autocomplete+'">'+
                    '<td class="tdpai'+contador_local_autocomplete+'" onclick="openclose(this,'+contador_local_autocomplete+')" style="text-align: center; display: table-cell;min-height: 10em;vertical-align: middle;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>'+
                    '<td style="display: table-cell;vertical-align: middle;"><div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">'+
                        '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                            '<div class="span2">'+
                                '<label><b>PN</b> (master):</label>'+
                                '<input type="text" class="span12" id="pn_'+contador_local_autocomplete+'" onblur="carregarPn('+contador_local_autocomplete+')" name="pn[]" value="" />'+     
                                '<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>'+
                                '<input type="hidden" id="idProdutos_'+contador_local_autocomplete+'" name="idProdutos[]" size="3"   value=""/>'+     
                                '<input type="hidden" id="idChecklist_'+contador_local_autocomplete+'" name="idChecklist[]" size="3"   value=""/>'+                     
                            '</div>'+
                            '<div class="span1">'+
                                '<label>Orç.:</label>'+
                                '<select id="orc_'+contador_local_autocomplete+'" onchange="verificarEscopo('+contador_local_autocomplete+')" name="orc[]" class="span12">'+
                                    '<option value="">Selecione o tipo</option>'+
                                    '<option value="fab">FAB</option>'+
                                    '<option value="serv">SERV</option>'+
                                '</select>'+                               
                            '</div>'+
                            '<div class="span2">'+
                                '<label>Tipo de Prod.:</label>'+ 
                                '<select id="tipo_prod_'+contador_local_autocomplete+'" onchange="verificarEscopo('+contador_local_autocomplete+')" name="tipo_prod[]" class="span12">'+
                                    '<option value="">Selecione o produto</option>'+
                                    '<option value="cil">Cilindro</option>'+
                                    '<option value="maq">Máquina</option>'+
                                    '<option value="pec" selected>Peça</option>'+
                                    '<option value="sub">Subconjunto</option>'+
                                '</select>'+                               
                            '</div>'+
                            '<div class="span4">'+
                                '<label>Descrição:</label>'+
                                '<input type="text" class="span12" id="descricao_item_'+contador_local_autocomplete+'" name="descricao_item[]"  value="" />'+                              
                            '</div>'+
                            '<div class="span2">'+
                                '<label>Tag (ID Cliente):</label>'+
                                '<input type="text" class="span12" id="tag_'+contador_local_autocomplete+'" name="tag[]"  value="" />'+                              
                            '</div>'+
                            '<div class="span1">'+
                                '<label>Qtd. Estq.:</label>'+
                                '<input type="text" class="span12" id="qtdest_'+contador_local_autocomplete+'" name="qtdest[]"  value="" disabled/>'+                              
                            '</div>'+
                        '</div>'+
                    '</div></td>'+
                    '<td style="text-align: center; display: table-cell;min-height: 10em;vertical-align: middle;">'+
                        '<a href="#"  onclick="removerCampos(this);" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>'+
                    '</td>'+
                '</tr>'+
                '<tr class="trfilho'+contador_local_autocomplete+'" style="display:none">'+
                    '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">'+
                    '</td>'+
                    '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">'+
                        '<div >'+
                            '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                '<div class="span2">'+
                                    '<label>Ultima O.S.:</label>'+
                                    '<input type="text" class="span12" id="cOs_'+contador_local_autocomplete+'" name="cOs[]" value="" disabled/> '+                             
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Custo Insumo:</label>'+
                                    '<input type="text" class="span12" id="custoIns_'+contador_local_autocomplete+'" name="custoIns[]"  value="" disabled/>'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Custo HR/Maq</label>'+
                                    '<input type="text" class="span12" id="custoFab_'+contador_local_autocomplete+'" name="custoFab[]"  value="" disabled/>'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Custo Impostos</label>'+
                                    '<input type="text" class="span12" id="custoIcms_'+contador_local_autocomplete+'" name="custoIcms[]"  value="" disabled/>'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Custo Frete</label>'+
                                    '<input type="text" class="span12" id="custoFrete_'+contador_local_autocomplete+'" name="custoFrete[]"  value="" disabled/>'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Custo Total</label>'+
                                    '<input type="text" class="span12" id="custoTotal_'+contador_local_autocomplete+'" name="custoTotal[]"  value="" disabled/>'+                              
                                '</div>'+
                            '</div>'+
                            '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                '<div class="span1">'+
                                    '<label>QTD:</label>'+
                                    '<input type="text" class="span12" id="qtd_'+contador_local_autocomplete+'" name="qtd[]" onblur="calculaSubTotal('+contador_local_autocomplete+');" onclick="this.select();" value="" />'+                              
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Vl.Unit.:</label>'+
                                    '<input type="text" class="span12" id="val_unit_'+contador_local_autocomplete+'" name="val_unit[]" value="0,00" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"   onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" /> '+                             
                                '</div>'+
                                '<div class="span2">'+
                                    '<label>Sub.Tot.:</label>'+
                                    '<input type="text" class="span12" id="subtot_'+contador_local_autocomplete+'" name="subtot[]" value="0,00" readonly/>'+                              
                                '</div>'+
                                '<div class="span1">'+
                                    '<label>Prazo:</label>'+
                                    '<input type="text" class="span12" id="prazo_'+contador_local_autocomplete+'" name="prazo[]" onclick="this.select(); " value="0" /> '+                             
                                '</div> '+ 
                                '<div class="span1">'+
                                    '<label>Frete:</label>'+
                                    '<input type="text" class="span12" id="frete_'+contador_local_autocomplete+'" name="frete[]" value="0,00" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />'+                              
                                '</div>'+ 
                                '<div class="span2">'+
                                    '<label>Desconto:</label>'+
                                    '<input type="text" class="span12" id="desconto_'+contador_local_autocomplete+'" name="desconto[]" value="0,00" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />'+                              
                                '</div>'+ 
                                '<div class="span1">'+
                                    '<label>IPI%:</label>'+
                                    '<input type="text" class="span12" id="val_ipi_'+contador_local_autocomplete+'" name="val_ipi[]" value="0,00" onKeyUp="calculaSubTotal('+contador_local_autocomplete+');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />'+                              
                                '</div>'+  
                                '<div class="span2">'+
                                    '<label>Valor Tot.:</label>'+
                                    '<input type="text" class="span12" id="vlr_total_'+contador_local_autocomplete+'" name="vlr_total[]" value="0,00" />'+                              
                                '</div>'+                                                             
                            '</div>'+
                            '<div class="span12" style="padding: 0.2%; margin-left: 0">'+
                                '<div class="span8">'+
                                    '<label>Detalhamento: </label>'+
                                    '<textarea style="max-width:100%" id="detalhe_'+contador_local_autocomplete+'"  cols="50" class="span12" name="detalhe[]"></textarea>'+
                                '</div>'+
                                '<div class="span4" id="divSelectFab_'+contador_local_autocomplete+'">'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div id="escopo_'+contador_local_autocomplete+'">'+

                        '</div>'+
                    '</td>'+                    
                    '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">'+
                    '</td>'+
                '</tr>';


            $("#destino").append(cloneDiv);

            console.log('#idProdutos_' + contador_global_autocomplete);
            $("#pn_" + contador_global_autocomplete).autocomplete({
                source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN_2",
                minLength: 1,
                select: function(event, ui) {
                    $('#idProdutos_' + contador_local_autocomplete).val(ui.item.id);
                    $('#descricao_item_' + contador_local_autocomplete).val(ui.item.no);
                    if (ui.item.qtdEst == '' || ui.item.qtdEst == null) {
                        $('#qtdest_' + contador_local_autocomplete).val(0);
                    } else {
                        $('#qtdest_' + contador_local_autocomplete).val(ui.item.qtdEst);
                    }
                    verificarEscopo(contador_local_autocomplete);
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/producao/getCustoInsumoPorPN",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            idProduto: ui.item.id
                        },
                        success: function(data) {
                            if (data.result == true) {
                                if(data.dados.somaInsumos){
                                    $('#custoIns_' + contador_local_autocomplete).val(data.dados.somaInsumos);
                                    calcularTotalUnit(contador_local_autocomplete);
                                }else{
                                    $('#custoIns_' + contador_local_autocomplete).val("0,00");
                                }
                                
                            }

                        },
                        error: function(xhr, textStatus, error) {
                            console.log("4");
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        },
                    })
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/producao/getCustoHrMaqPorPN",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            idProduto: ui.item.id
                        },
                        success: function(data) {
                            if (data.result == true) {
                                if (data.dados == '' || data.dados == null) {
                                    $('#custoFab_' + contador_local_autocomplete).val(0);
                                } else {
                                    $('#custoFab_' + contador_local_autocomplete).val(data.dados);
                                }
                                calcularTotalUnit(contador_local_autocomplete);
                            }
                        },
                        error: function(xhr, textStatus, error) {
                            console.log("4");
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        },
                    })
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/producao/getCustoICMSPorPN",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            idProduto: ui.item.id
                        },
                        success: function(data) {
                            if (data.result == true) {
                                if (!data.dados.somaIcms) {
                                    $('#custoIcms_' + contador_local_autocomplete).val("0,00");
                                } else {
                                    $('#custoIcms_' + contador_local_autocomplete).val(data.dados.somaIcms);
                                }
                                calcularTotalUnit(contador_local_autocomplete);
                            }
                        },
                        error: function(xhr, textStatus, error) {
                            console.log("4");
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        },
                    })
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/producao/getCustoFretePorPN",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            idProduto: ui.item.id
                        },
                        success: function(data) {
                            if (data.result == true) {
                                if (!data.dados ) {
                                    $('#custoFrete_' + contador_local_autocomplete).val("0,00");
                                    console.log(1);
                                } else {
                                    $('#custoFrete_' + contador_local_autocomplete).val(data.dados);
                                    console.log(2);
                                }
                                calcularTotalUnit(contador_local_autocomplete);
                            }
                        },
                        error: function(xhr, textStatus, error) {
                            console.log("4");
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        },
                    })
                    if($( "#orc_"+contador_local_autocomplete ).val() == "serv"){
                        $("#idChecklist_"+contador_local_autocomplete).val("");
                    }else if($( "#orc_"+contador_local_autocomplete).val() == "fab"){
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/peritagem/getcatalogoproduto",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                idProduto: ui.item.id
                            },
                            success: function(data) {
                                $("#escopo_"+contador_local_autocomplete).empty();
                                if(data.resultado.length > 0){
                                    var variavel = {value:data.resultado[0].idCatalogoProduto}
                                    buscarCatalogo(variavel,contador_local_autocomplete);
                                    $("#idChecklist_"+contador_local_autocomplete).val(variavel.value);
                                }
                                //preencherTabelaCatalogo(pos,data.resultado);
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

            });
            contador_global_autocomplete = contador_global_autocomplete + 1;
            calculaSubTotal();

        }
        function carregarPn(pos){
            if(document.querySelector("#descricao_item_"+pos).value == "" && document.querySelector("#pn_"+pos).value != ""){
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/produtos/getProdutoByPn",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        pn: document.querySelector("#pn_"+pos).value
                    },
                    success: function(data) {
                        if(data.result){
                            document.querySelector("#descricao_item_"+pos).value = data.produto.descricao+" PN: "+data.produto.pn+" Ref.: "+data.produto.referencia;
                            document.querySelector("#idProdutos_"+pos).value = data.produto.idProdutos
                        }else if(data.msg != ""){
                            alert(data.msg);
                        }
                        verificarEscopo(pos);
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/producao/getCustoInsumoPorPN",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                idProduto: ui.item.id
                            },
                            success: function(data) {
                                if (data.result == true) {
                                    
                                    if(data.dados.somaInsumos){
                                        $('#custoIns_' + contador_local_autocomplete).val(data.dados.somaInsumos);
                                        calcularTotalUnit(contador_local_autocomplete);
                                    }else{
                                        $('#custoIns_' + contador_local_autocomplete).val("0,00");
                                    }
                                }

                            },
                            error: function(xhr, textStatus, error) {
                                console.log("4");
                                console.log(xhr.responseText);
                                console.log(xhr.statusText);
                                console.log(textStatus);
                                console.log(error);
                            },
                        })
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/producao/getCustoHrMaqPorPN",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                idProduto: ui.item.id
                            },
                            success: function(data) {
                                if (data.result == true) {
                                    if (data.dados == '' || data.dados == null) {
                                        $('#custoFab_' + contador_local_autocomplete).val(0);
                                    } else {
                                        $('#custoFab_' + contador_local_autocomplete).val(data.dados);
                                    }
                                    calcularTotalUnit(contador_local_autocomplete);
                                }
                            },
                            error: function(xhr, textStatus, error) {
                                console.log("4");
                                console.log(xhr.responseText);
                                console.log(xhr.statusText);
                                console.log(textStatus);
                                console.log(error);
                            },
                        })
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/producao/getCustoICMSPorPN",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                idProduto: ui.item.id
                            },
                            success: function(data) {
                                if (data.result == true) {
                                    if (data.dados.somaIcms == '' || data.dados.somaIcms == null) {
                                        $('#custoIcms_' + contador_local_autocomplete).val(0);
                                    } else {
                                        $('#custoIcms_' + contador_local_autocomplete).val(data.dados.somaIcms);
                                    }
                                    calcularTotalUnit(contador_local_autocomplete);
                                }
                            },
                            error: function(xhr, textStatus, error) {
                                console.log("4");
                                console.log(xhr.responseText);
                                console.log(xhr.statusText);
                                console.log(textStatus);
                                console.log(error);
                            },
                        })
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/producao/getCustoFretePorPN",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                idProduto: ui.item.id
                            },
                            success: function(data) {
                                if (data.result == true) {
                                    if (data.dados == '' || data.dados == null) {
                                        $('#custoFrete_' + contador_local_autocomplete).val(0);
                                        console.log(1);
                                    } else {
                                        $('#custoFrete_' + contador_local_autocomplete).val(data.dados);
                                        console.log(2);
                                    }
                                    calcularTotalUnit(contador_local_autocomplete);
                                }
                            },
                            error: function(xhr, textStatus, error) {
                                console.log("4");
                                console.log(xhr.responseText);
                                console.log(xhr.statusText);
                                console.log(textStatus);
                                console.log(error);
                            },
                        })
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

        function verificarEscopo(pos){
            var orc = document.querySelector('#orc_'+pos).value;
            var tipo_prod = document.querySelector('#tipo_prod_'+pos).value;
            var idProduto = document.querySelector('#idProdutos_'+pos).value;
                        $("#escopo_"+pos).empty();
            if(tipo_prod && orc == "serv"  && idProduto){
                $("#divSelectFab_"+pos).empty();
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/peritagem/getescopobyidproduto",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        idProduto: idProduto,
                        tipo_prod: tipo_prod,
                        orc: orc
                    },
                    success: function(data) {
                        $("#escopo_"+pos).empty();
                        if(data.resultado.length > 0)
                        preencherTabela(pos,data.resultado);
                    },
                    error: function(xhr, textStatus, error) {
                        console.log("4");
                        console.log(xhr.responseText);
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(error);
                    },
                })
            }else{
                if(idProduto && orc == "fab"){
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/peritagem/getcatalogoproduto",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            idProduto: idProduto,
                            tipo_prod: tipo_prod,
                            orc: orc
                        },
                        success: function(data) {
                            $("#divSelectFab_"+pos).empty();
                            if(data.resultado.length>0){
                                var variavel = {value:data.resultado[0].idCatalogoProduto}
                                buscarCatalogo(variavel,pos);
                                $("#idChecklist_"+pos).val(variavel.value);
                            }
                            //preencherSelect(pos,data.resultado)
                        },
                        error: function(xhr, textStatus, error) {
                            console.log("4");
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        },
                    })
                }else{
                    $("#idChecklist"+pos).val("");
                }
            }            
        }


        function preencherTabela(pos,resultado){
            html = '';
            $("#escopo_"+pos).empty();
            resultado.forEach((elemento)=>{
                if(elemento.pn == null)
                elemento.pn = "";
                html += '<tr>'+
                    '<td>'+elemento.pn+'</td>'+                            
                    '<td>'+elemento.descricaoServicoItens+'</td>'+
                    '<td>'+elemento.descricaoClasse+'</td>'+                            
                    '<td></td>'+                                                                                                    
                    '<td></td>'+                                
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                    '<td></td>'+
                '</tr>';          
            })
            table = '<h5>Checklist</h5>'+
                    '<table class="table table-bordered ">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>PN</th>'+
                                '<th>DESCRIÇÃO</th>'+
                                '<th>CLASSE</th>'+
                                '<th>QTD</th>'+
                                '<th>Ø EXT.</th>'+
                                '<th>Ø INT.</th>'+
                                '<th>COMP.</th>'+
                                '<th>OBS.</th>'+
                                '<th>Valor Unit.</th>'+
                                '<th>Valor Total</th>'+
                            '</tr>'+                            
                        '</thead>'+
                        '<tbody>'+
                              html+                                                                                                                                                                                             
                        '</tbody>'+
                    '</table>';
            $("#escopo_"+pos).append(table);
        }
            
        function preencherSelect(pos,resultado){
            html = '<option value=""> Selecione um checklist</option>';
            resultado.forEach((elemento)=>{
                html += '<option value="'+elemento.idCatalogoProduto+'">'+elemento.descricaoCatalogo+'</option>'
            })
            div = '<label>Checklist</label>'+
                '<select id="catalogoProduto_'+pos+'" class="span12" onchange="buscarCatalogo(this,'+pos+')">'+
                    html+
                '</select>';
            //$("#divSelectFab_"+pos).append(div);
            
        }

        function preencherTabelaCatalogo(pos,resultado){
            $("#escopo_"+pos).empty();
            html = '';
            resultado.forEach((elemento)=>{
                if(elemento.pn == null)
                elemento.pn = "";
            html += '<tr>'+
                    '<td>'+elemento.pn+'</td>'+                            
                    '<td>'+elemento.descricao+'</td>'+
                    '<td>'+elemento.quantidade+'</td>'+
                '</tr>';          
            })
            table = '<h5>Checklist</h5>'+
                    '<table class="table table-bordered ">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>PN</th>'+
                                '<th>DESCRIÇÃO</th>'+
                                '<th>QTD</th>'+
                            '</tr>'+                            
                        '</thead>'+
                        '<tbody>'+
                              html+                                                                                                                                                                                             
                        '</tbody>'+
                    '</table>';
            $("#escopo_"+pos).append(table);
        }

        function buscarCatalogo(select,pos){
            if(select.value){
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/peritagem/getcatalogoitens",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        idCatalogo: select.value
                    }, 
                    success: function(data) {
                        preencherTabelaCatalogo(pos,data.resultado)
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

        function abrirmodal(obj) {
            $('#myModal').modal('show');
        }
        function openclose(td,valor){
			var tr = document.querySelector(".trfilho"+valor);
			
			if(tr.style.display == "table-row" || tr.style.display == ""){
				$(".trfilho"+valor).hide('fast');
				$(td).parent('tr').css('background-color', '');
				$(td).find("a > i").removeClass("fa-minus");
				$(td).find("a > i").addClass("fa-plus");            
			}else{
				$(".trfilho"+valor).show('fast');
				$(td).parent('tr').css('background-color', '#efefef');
				$(td).find("a > i").removeClass("fa-plus");
				$(td).find("a > i").addClass("fa-minus");
			}       
		}

        //function 

        function retorna_formatado(num) {

            x = 0;

            if (num < 0) {
                num = Math.abs(num);
                x = 1;
            }

            if (isNaN(num)) num = "0";
            cents = Math.floor((num * 100 + 0.5) % 100);

            num = Math.floor((num * 100 + 0.5) / 100).toString();

            if (cents < 10) cents = "0" + cents;
            for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                num = num.substring(0, num.length - (4 * i + 3)) + '.' +
                num.substring(num.length - (4 * i + 3));

            ret = num + ',' + cents;

            if (x == 1) ret = ' - ' + ret;
            return ret;

        }

        function FormataValor2(objeto, teclapres, tammax, decimais) {
            var tecla = teclapres.keyCode;
            var tamanhoObjeto = objeto.value.length;



            if ((tecla == 8) && (tamanhoObjeto == tammax))
                tamanhoObjeto = tamanhoObjeto - 1;



            if ((tecla == 8 || tecla == 88 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) && ((tamanhoObjeto + 1) <= tammax)) {

                vr = objeto.value;
                vr = vr.replace("/", "");
                vr = vr.replace("/", "");
                vr = vr.replace(",", "");
                vr = vr.replace(".", "");
                vr = vr.replace(".", "");
                vr = vr.replace(".", "");
                vr = vr.replace(".", "");
                tam = vr.length;

                if (tam < tammax && tecla != 8)
                    tam = vr.length + 1;

                if ((tecla == 8) && (tam > 1)) {
                    tam = tam - 1;
                    vr = objeto.value;
                    vr = vr.replace("/", "");
                    vr = vr.replace("/", "");
                    vr = vr.replace(",", "");
                    vr = vr.replace(".", "");
                    vr = vr.replace(".", "");
                    vr = vr.replace(".", "");
                    vr = vr.replace(".", "");
                }

                //Cálculo para casas decimais setadas por parametro
                if (tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) {
                    if (decimais > 0) {
                        if ((tam <= decimais))
                            objeto.value = ("0," + vr);

                        if ((tam == (decimais + 1)) && (tecla == 8))
                            objeto.value = vr.substr(0, (tam - decimais)) + ',' + vr.substr(tam - (decimais), tam);

                        if ((tam > (decimais + 1)) && (tam <= (decimais + 3)) && ((vr.substr(0, 1)) == "0"))
                            objeto.value = vr.substr(1, (tam - (decimais + 1))) + ',' + vr.substr(tam - (decimais), tam);

                        if ((tam > (decimais + 1)) && (tam <= (decimais + 3)) && ((vr.substr(0, 1)) != "0"))
                            objeto.value = vr.substr(0, tam - decimais) + ',' + vr.substr(tam - decimais, tam);

                        if ((tam >= (decimais + 4)) && (tam <= (decimais + 6)))
                            objeto.value = vr.substr(0, tam - (decimais + 3)) + '.' + vr.substr(tam - (decimais + 3), 3) + ',' + vr.substr(tam - decimais, tam);

                        if ((tam >= (decimais + 7)) && (tam <= (decimais + 9)))
                            objeto.value = vr.substr(0, tam - (decimais + 6)) + '.' + vr.substr(tam - (decimais + 6), 3) + '.' + vr.substr(tam - (decimais + 3), 3) + ',' + vr.substr(tam - decimais, tam);

                        if ((tam >= (decimais + 10)) && (tam <= (decimais + 12)))
                            objeto.value = vr.substr(0, tam - (decimais + 9)) + '.' + vr.substr(tam - (decimais + 9), 3) + '.' + vr.substr(tam - (decimais + 6), 3) + '.' + vr.substr(tam - (decimais + 3), 3) + ',' + vr.substr(tam - decimais, tam);

                        if ((tam >= (decimais + 13)) && (tam <= (decimais + 15)))
                            objeto.value = vr.substr(0, tam - (decimais + 12)) + '.' + vr.substr(tam - (decimais + 12), 3) + '.' + vr.substr(tam - (decimais + 9), 3) + '.' + vr.substr(tam - (decimais + 6), 3) + '.' + vr.substr(tam - (decimais + 3), 3) + ',' + vr.substr(tam - decimais, tam);

                    } else if (decimais == 0) {
                        if (tam <= 3)
                            objeto.value = vr;

                        if ((tam >= 4) && (tam <= 6)) {
                            if (tecla == 8) {
                                objeto.value = vr.substr(0, tam);
                                window.event.cancelBubble = true;
                                window.event.returnValue = false;
                            }
                            objeto.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, 3);
                        }

                        if ((tam >= 7) && (tam <= 9)) {
                            if (tecla == 8) {
                                objeto.value = vr.substr(0, tam);
                                window.event.cancelBubble = true;
                                window.event.returnValue = false;
                            }
                            objeto.value = vr.substr(0, tam - 6) + '.' + vr.substr(tam - 6, 3) + '.' + vr.substr(tam - 3, 3);
                        }

                        if ((tam >= 10) && (tam <= 12)) {
                            if (tecla == 8) {
                                objeto.value = vr.substr(0, tam);
                                window.event.cancelBubble = true;
                                window.event.returnValue = false;
                            }
                            objeto.value = vr.substr(0, tam - 9) + '.' + vr.substr(tam - 9, 3) + '.' + vr.substr(tam - 6, 3) + '.' + vr.substr(tam - 3, 3);
                        }

                        if ((tam >= 13) && (tam <= 15)) {
                            if (tecla == 8) {
                                objeto.value = vr.substr(0, tam);
                                window.event.cancelBubble = true;
                                window.event.returnValue = false;
                            }
                            objeto.value = vr.substr(0, tam - 12) + '.' + vr.substr(tam - 12, 3) + '.' + vr.substr(tam - 9, 3) + '.' + vr.substr(tam - 6, 3) + '.' + vr.substr(tam - 3, 3);
                        }
                    }
                }
            } else if ((window.event.keyCode != 8) && (window.event.keyCode != 9) && (window.event.keyCode != 13) && (window.event.keyCode != 35) && (window.event.keyCode != 36) && (window.event.keyCode != 46)) {
                window.event.cancelBubble = true;
                window.event.returnValue = false;
            }
        }

        function calcularTotalUnit(contador) {
            valor_icms = document.querySelector("#custoIcms_" + contador).value.replace('.', '');
            valor_icms = valor_icms.replace(',', '.');
            valor_frete = document.querySelector("#custoFrete_" + contador).value.replace('.', '');
            valor_frete = valor_frete.replace(',', '.');
            valor_ins = document.querySelector("#custoIns_" + contador).value.replace('.', '');
            valor_ins = valor_ins.replace(',', '.');
            valor_fab = document.querySelector("#custoFab_" + contador).value.replace('.', '');
            valor_fab = valor_fab.replace(',', '.');
            total = parseFloat(valor_icms) + parseFloat(valor_frete) + parseFloat(valor_ins) + parseFloat(valor_fab);
            document.querySelector("#custoTotal_" + contador).value = retorna_formatado(total);
            document.querySelector("#val_unit_" + contador).value = retorna_formatado(total);
            calculaSubTotal(contador);

        }

        function verificarInfo(){
            var produtos = Array.apply(null,document.querySelectorAll("input[name='idProdutos[]']"));
            var pn = Array.apply(null,document.querySelectorAll("input[name='pn[]']"));
            var quantidade = document.querySelectorAll("input[name='qtd[]']");
            var selectOrc = document.querySelectorAll("input[name='qtd[]']");
            var selectProd = document.querySelectorAll("input[name='qtd[]']");
            var center = $(window).height()/2;
           
            for(x=0;x<produtos.length;x++){
                if(!produtos[x].value){
                    alert("Informe um PN válido.");
                    $(pn[x]).css('border-color','red');
                    return;
                }
                if(!quantidade[x].value){
                    alert("Informe a quantidade.");
                    $(quantidade[x]).css('border-color','red');
                    return;
                }
            }

            $('#formOrcamento').submit();

        }
    </script>

