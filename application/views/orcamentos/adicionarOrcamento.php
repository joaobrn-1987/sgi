<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

<!--
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>-->


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

    input:checked+.slider {
        background-color: #51a351;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #51a351;
    }

    input:checked+.slider:before {
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
    .line-through {
		text-decoration: line-through;
	}
</style>

<div id="modalCadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><!--
    <form action="<?php echo base_url(); ?>index.php/clientes/cadastrarSolicitante" id="formCadastrar" enctype="multipart/form-data" method="post" class="form-horizontal">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
 -->
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
                    <select class="form-control" name="idClientes" id="idClientes">
                        <option selected="selected" disabled="disabled" value="">Escolher</option>
                        <?php foreach ($dados_clientes as $p) { ?>

                            <option value="<?php echo $p->idClientes; ?>"><?php echo $p->nomeCliente; ?> | CNPJ: <?php echo $p->documento; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>



        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <a class="btn btn-success" onclick="cadastrarsolicitante()">Cadastrar</a>
        </div><!--
    </form>-->
</div> 

<div id="modalCadastrarPN" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Cadastrar PN</h3>
    </div>
    <div class="modal-body">
        <div class="span12">            
            <div class="span3">
                <label for="pn" class="control-label">PN<span class="required">*</span></label>
                <input class="span12" id="pn" type="text" name="pn" value="<?php echo set_value('pn'); ?>" onkeyup="maiuscula(this)" />
            </div>
            <div class="span3">
                <label for="referencia" class="control-label">Referencia<span class="required">*</span></label>
                <input class="span12" id="referencia"  type="text" name="referencia" value="<?php echo set_value('referencia'); ?>"  />
            </div>
            <div class="span6">
                <label for="descricao" class="control-label">Descrição<span class="required">*</span></label>
                <input class="span12" id="descricao" type="text" name="descricao" value="<?php echo set_value('descricao'); ?>"  />
            </div>
        </div>
        <div class="span12" style="margin-left:0px">
            <div class="span3">
                <label for="fornecedor_original" class="control-label">Fornecedor Original<span class="required">*</span></label>
                <input class="span12" id="fornecedor_original"  type="text" name="fornecedor_original" value="<?php echo set_value('fornecedor_original'); ?>"  />
            </div>
            <div class="span3">
                <label for="equipamento" class="control-label">Equipamento<span class="required">*</span></label>
                <input class="span12" id="equipamento"  type="text" name="equipamento" value="<?php echo set_value('equipamento'); ?>"  />
            </div>
            <div class="span3">
                <label for="subconjunto" class="control-label">SubConjunto<span class="required">*</span></label>
                <input class="span12" id="subconjunto"  type="text" name="subconjunto" value="<?php echo set_value('subconjunto'); ?>"  />
            </div>
            <div class="span3">
                <label for="modelo" class="control-label">Modelo<span class="required">*</span></label>
                <input class="span12" id="modelo"  type="text" name="modelo" value="<?php echo set_value('modelo'); ?>"  />
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
        <a class="btn btn-success" onclick="cadastrarProduto()">Cadastrar</a>
    </div>
</div>

<div id="modalCadastrarCliente" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Cadastrar Cliente</h3>
    </div>
    <div class="modal-body">
        <div class="span12">
            <div class="span12">
                <label for="nomeFornecedor" class="control-label">Nome<span class="required">*</span></label>
                <input class="span12" id="nomeFornecedor" type="text" name="nomeFornecedor" id="nomeFornecedor"value="<?php echo set_value('nomeFornecedor'); ?>" />
            </div>
        </div>
        <div class="span12" style="margin-left:0px">
            <div class="span4">
                <label for="documento" class="control-label">CPF/CNPJ<span class="required">*</span></label>
                <input id="documento" class="span12" type="text" name="documento" id="documento" value="<?php echo set_value('documento'); ?> " />
            </div>
            <div class="span2">
                <label for="telefone" class="control-label">IE<span class="required">*</span></label>
                <input class="span12" id="ie" type="text" name="ie" value="<?php echo set_value('ie'); ?> " />
            </div>
            <div class="span3">
                <label for="telefone" class="control-label">Telefone<span class="required">*</span></label>
                <input class="span12" id="telefone" type="text" maxlength="15" onkeyup="handlePhone(event)" name="telefone" id="telefone" value="<?php echo set_value('telefone'); ?>" />
            </div>
            <div class="span3">
                <label for="celular" class="control-label">Celular</label>
                <input class="span12" id="celular" type="text" maxlength="15" onkeyup="handlePhone(event)" name="celular" id="celular" value="<?php echo set_value('celular'); ?>" />
            </div>
        </div>
        <div class="span12" style="margin-left:0px">
            <div class="span12">
                <label for="email" class="control-label">Email<span class="required">*</span></label>
                <input class="span12" id="email" type="text" name="email" id="email"  value="<?php echo set_value('email'); ?>" />
            </div>
        </div>
        <div class="span12" style="margin-left:0px">
            <div class="span4">
                <label for="cep" class="control-label">CEP<span class="required">*</span></label>
                <input class="span12" id="cep" type="text" name="cep" id="cep" value="<?php echo set_value('cep'); ?>" />
            </div>
            <div class="span2">
                <label for="estado" class="control-label">Estado<span class="required">*</span></label>
                <select id="estado" name="estado" class="span12" >
                    <option value=""></option>
                    <option value="AC" <?php if (set_value('estado') == 'AC') {
                                            echo "selected='selected'";
                                        } ?>>Acre</option>
                    <option value="AL" <?php if (set_value('estado') == 'AL') {
                                            echo "selected='selected'";
                                        } ?>>Alagoas</option>
                    <option value="AP" <?php if (set_value('estado') == 'AP') {
                                            echo "selected='selected'";
                                        } ?>>Amapá</option>
                    <option value="AM" <?php if (set_value('estado') == 'AM') {
                                            echo "selected='selected'";
                                        } ?>>Amazonas</option>
                    <option value="BA" <?php if (set_value('estado') == 'BA') {
                                            echo "selected='selected'";
                                        } ?>>Bahia</option>
                    <option value="CE" <?php if (set_value('estado') == 'CE') {
                                            echo "selected='selected'";
                                        } ?>>Ceará</option>
                    <option value="DF" <?php if (set_value('estado') == 'DF') {
                                            echo "selected='selected'";
                                        } ?>>Distrito Federal</option>
                    <option value="ES" <?php if (set_value('estado') == 'ES') {
                                            echo "selected='selected'";
                                        } ?>>Espírito Santo</option>
                    <option value="GO" <?php if (set_value('estado') == 'GO') {
                                            echo "selected='selected'";
                                        } ?>>Goiás</option>
                    <option value="MA" <?php if (set_value('estado') == 'MA') {
                                            echo "selected='selected'";
                                        } ?>>Maranhão</option>
                    <option value="MT" <?php if (set_value('estado') == 'MT') {
                                            echo "selected='selected'";
                                        } ?>>Mato Grosso</option>
                    <option value="MS" <?php if (set_value('estado') == 'MS') {
                                            echo "selected='selected'";
                                        } ?>>Mato Grosso do Sul</option>
                    <option value="MG" <?php if (set_value('estado') == 'MG') {
                                            echo "selected='selected'";
                                        } ?>>Minas Gerais</option>
                    <option value="PA" <?php if (set_value('estado') == 'PA') {
                                            echo "selected='selected'";
                                        } ?>>Pará</option>
                    <option value="PB" <?php if (set_value('estado') == 'PB') {
                                            echo "selected='selected'";
                                        } ?>>Paraíba</option>
                    <option value="PR" <?php if (set_value('estado') == 'PR') {
                                            echo "selected='selected'";
                                        } ?>>Paraná</option>
                    <option value="PE" <?php if (set_value('estado') == 'PE') {
                                            echo "selected='selected'";
                                        } ?>>Pernambuco</option>
                    <option value="PI" <?php if (set_value('estado') == 'PI') {
                                            echo "selected='selected'";
                                        } ?>>Piauí</option>
                    <option value="RJ" <?php if (set_value('estado') == 'RJ') {
                                            echo "selected='selected'";
                                        } ?>>Rio de Janeiro</option>
                    <option value="RN" <?php if (set_value('estado') == 'RN') {
                                            echo "selected='selected'";
                                        } ?>>Rio Grande do Norte</option>
                    <option value="RS" <?php if (set_value('estado') == 'RS') {
                                            echo "selected='selected'";
                                        } ?>>Rio Grande do Sul</option>
                    <option value="RO" <?php if (set_value('estado') == 'RO') {
                                            echo "selected='selected'";
                                        } ?>>Rondônia</option>
                    <option value="RR" <?php if (set_value('estado') == 'RR') {
                                            echo "selected='selected'";
                                        } ?>>Roraima</option>
                    <option value="SC" <?php if (set_value('estado') == 'SC') {
                                            echo "selected='selected'";
                                        } ?>>Santa Catarina</option>
                    <option value="SP" <?php if (set_value('estado') == 'SP') {
                                            echo "selected='selected'";
                                        } ?>>São Paulo</option>
                    <option value="SE" <?php if (set_value('estado') == 'SE') {
                                            echo "selected='selected'";
                                        } ?>>Sergipe</option>
                    <option value="TO" <?php if (set_value('estado') == 'TO') {
                                            echo "selected='selected'";
                                        } ?>>Tocantins</option>
                    <option value="EX" <?php if (set_value('estado') == 'EX') {
                                            echo "selected='selected'";
                                        } ?>>Estrangeiro</option>
                </select>
            </div>
            <div class="span6">
                <label for="cidade" class="control-label">Cidade*</label>
                <input class="span12" id="cidade" type="text" name="cidade" id="cidade" value="<?php echo set_value('cidade'); ?>" />
            </div>
        </div>
        <div class="span12" style="margin-left:0px">
            <div class="span4">
                <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                <input class="span12" id="bairro" type="text" name="bairro" id="bairro" value="<?php echo set_value('bairro'); ?>" />
            </div>                     
            <div class="span6">
                <label for="rua" class="control-label">Rua<span class="required">*</span></label>
                <input class="span12" id="rua" type="text" name="rua" id="rua" value="<?php echo set_value('rua'); ?>" />
            </div>
            <div class="span2">
                <label for="numero" class="control-label">Número<span class="required">*</span></label>
                <input class="span12" id="numero" type="text" name="numero" id="numero" value="<?php echo set_value('numero'); ?>" />
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
        <a 'href="#modal-cadastrarInsumo" role="button"  data-toggle="modal" onclick="cadastrarCliente()" class="btn btn-success" style="height: 20px"><i class="icon-plus icon-white"></i> Confirmado</a>
    </div>
</div>



<div class="btn-group">
    <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" role="button">
        Cadastrar
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
        <li><a tabindex="-1" href="#modalCadastrar" data-toggle="modal" role="button">Solicitante</a></li>
        <li><a tabindex="-1" href="#modalCadastrarCliente" data-toggle="modal" role="button">Cliente</a></li>
        <li><a tabindex="-1" href="#modalCadastrarPN" data-toggle="modal" role="button">PN</a></li>
    </ul>
</div><!--
<div>
    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) { ?>
        <a href="#modalCadastrar" data-toggle="modal" role="button" class="btn btn-success">Cadastrar Solicitante</a>
    <?php } ?>
</div> -->
<form action="<?php echo current_url(); ?>" id="formOrcamento" method="post" name='form'>
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Cadastro de Orçamento</h5>
                </div>
               
                <div class="widget-content nopadding">


                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0;background-color: white;">
                        <ul class="nav nav-tabs">
                            <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes do orçamento</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs">
                                    <?php if ($custom_error != '') {
                                        //echo '<div class="alert alert-danger">' . $custom_error . '</div>';
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
										
										
<?php 
$idsParaExcluir = [2, 3, 4, 6, 7, 266, 186, 181]; // IDs que não devem ser exibidos
?>

<div class="span2 control-group">
    <label for="idVendedor" class="control-label"><span class="required">*</span>Gerente:</label>
    <select class="span12 form-control" name="idVendedor" id="idVendedor" onchange="atualizarRegiao()">
        <option value="">Selecione um gerente</option>
        <?php foreach ($dados_vendedor as $v) { ?>
            <?php if (!in_array($v->idVendedor, $idsParaExcluir)) { ?>
                <option value="<?php echo $v->idVendedor; ?>">
                    <?php echo htmlspecialchars($v->nomeVendedor, ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php } ?>
        <?php } ?>
    </select>
	<input type="hidden" name="regiao" id="regiao" readonly />
</div>

<div class="span2 control-group">
    <label for="idVendedorAuxiliar" class="control-label"><span class="required">*</span>Vendedor:</label>
    <select class="span12 form-control" name="idVendedorAuxiliar" id="idVendedorAuxiliar">
        <option value="">Selecione um vendedor auxiliar</option>
    </select>
</div>





<div class="span2 control-group">
    <label for="idGerente" class="control-label"><span class="required">*</span>Diretor Comercial:</label>
    <select class="span12 form-control" name="idGerente">
        <?php foreach ($dados_gerente as $g) { ?>
            <option value="<?php echo $g->idGerente; ?>" <?php echo ($g->idGerente == 1) ? "selected='selected'" : ""; ?>>
                <?php echo htmlspecialchars($g->nome, ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php } ?>
    </select>
</div>

                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label"><span class="required">*</span>Grupo Serviço:</label>

                                            <select class="span12 form-control" name="idGrupoServico" id="idGrupoServico" onchange="mudarOptions()">

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


                                        <div class="span1 " class="control-group"  alt="Validade da Proposta." title="Validade da Proposta.">

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
                                            <label for="entrega" class="control-label" title="CIF: O fornecedor é resposável pelo custo e seguro do frete e entrega do produto. &#13 FOB: O cliente é resposável pelo custo e seguro do frete e entrega do produto.">Entrega:
                                                <!--<input type="radio" name="entrega" checked="yes" VALUE="FOB" style="margin:0px" />FOB
                                                <input type="radio" name="entrega" VALUE="CIF" style="margin:0px" />CIF
                                                <input type="radio" name="entrega" VALUE="OUTROS" style="margin:0px" />Outros-->
                                            </label>
                                            <select name="entrega" class="span12">
													<?php foreach($dados_tipoentrega as $c){ 
														echo '<option value="'.$c->idTipoEntrega.'">'.$c->descricaoTipoEntrega.'</option>';
													} ?>
													
												</select>	
                                            <input class="span6" id="entregaoutros" type="hidden" name="entregaoutros" value="" size="50" />
                                        </div>
                                        <div class="span3" class="control-group">

                                            <label for="referencia" class="control-label">Referência:</label>

                                            <input id="referencia" class="span12" type="text" name="referencia" value="" />
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 0.2%; margin-left: 0">

                                        <div class="span2" class="control-group" alt="Número do Pedido." title="Número do Pedido.">
                                            <label for="num_pedido" class="control-label">Num. Pedido:</label>

                                            <input id="num_pedido" class="span12" type="text" name="num_pedido" value="" />
                                        </div>


                                        <div class="span2" class="control-group">
                                            <label for="num_nf" class="control-label" alt="Número da nota fiscal." title="Número da nota fiscal.">Num. Nota Fiscal:</label>

                                            <input id="num_nf" type="text" name="num_nf" class="span12" value="" />
                                        </div>
                                        <div class="span8" class="control-group" alt="Observações." title="Observações.">
                                            <label for="obs" class="control-label">OBS</label>
                                            <textarea id="obs" rows="5" cols="100" class="span12" name="obs"></textarea>
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

    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Cadastro de Itens </h5> <a  onclick="duplicarCampos();" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Item Orçamento</a>

        </div>
		
		
			
		
<!-- ALTERAR TODOS -->
<div class="widget-content" style="padding: 40px 15px;">



<fieldset style="border: 1px solid #ddd; padding: 10px; border-radius: 5px; margin-left: 0;">

        <legend style="font-weight: bold; font-size: 14px;">ALTERAR TODOS:</legend>
        <div class="row-fluid" style="border: 1px solid #ddd; padding: 10px; border-radius: 5px; margin-left: 2.0%;">
		
	
            <div class="span1">
                <label for="unex_todos">Un. Ex.:</label>
                <select class="span12" id="unex_todos">
                    <option value="">Selecione</option>
                    <?php foreach($unid_exec as $v){ ?>
                        <option value="<?php echo $v->id_unid_exec; ?>"><?php echo $v->status_execucao; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="span1">
                <label for="tipoos_todos">Tipo O.S.:</label>
                <select class="span12" id="tipoos_todos">
                    <option value="">Selecione</option>
                    <?php foreach ($tipo_os as $ostipo) { ?>
                        <option value="<?php echo $ostipo->id_tipo; ?>"><?php echo $ostipo->nome_tipo; ?></option>
                    <?php } ?>
                </select>
            </div>
<div class="span1">
    <label for="orc_todos">Orç.:</label>
    <select class="span12" id="orc_todos">
        <option value="">Selecione o tipo</option>
        <option value="fab">FAB</option>
        <option value="serv" style="<?php echo (isset($grupoServico) && $grupoServico == "1") ? 'display:none' : 'display:block'; ?>">SERV</option>

    </select>
</div>	

<div class="span1">
    <label for="tipo_prod_todos">Tipo de Prod.:</label>
    <select class="span12" id="tipo_prod_todos">
        <option value="">Selecione o produto</option>
        <option value="cil">Cilindro</option>
        <option value="maq">Máquina</option>
        <option value="pec">Peça</option>
        <option value="sub">Subconjunto</option>
    </select>
</div>		
        </div>
    </fieldset>
	
<fieldset style="border: 1px solid #ddd; padding: 10px; border-radius: 5px; margin-left: 0;">

    </fieldset>	
		

        <div class="widget-content nopadding">


            <table class="table table-bordered ">

                <tbody id="destino">

                    <!--
                    <div class="span12" style="padding: 0.2%; margin-left: 0">

                    </div>    -->
                </tbody>
            </table>
        </div>
    </div>
    <a onclick="duplicarCampos();" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Item Orçamento</a>

    <div class="widget-box" class="span12">

        <table align='right' border='0' width='40%'>
            <tr>
                <td align='right'>
                    SUBTOTAL R$:
                </td>
                <td align='center'>

                    <input name="subtotal_calculo" type="text" id="subtotal_calculo" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
                </td>




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

        <a 'type="button" ' type="submit" class="btn btn-success" onclick="verificarInfo()"><i class="icon-plus icon-white"></i> Salvar</a>
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
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

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
</div>


<!-- fim modal -->

<script type="text/javascript">
    
    $(document).ready(function() {
        duplicarCampos();
        var tipoOrc = Array.apply(null, document.querySelectorAll("select[name='orc[]']"));
        if(document.querySelector('#idGrupoServico').value == 1){
            tipoOrc.forEach((elemento) => {
                if (elemento.options[elemento.selectedIndex].value == "serv") {
                    elemento.value = ''
                }
                for(x=0;x<elemento.options.length;x++){
                    if(elemento.options[x].value=="serv"){
                        elemento.options[x].style = 'display:none';
                    }
                }
            })
        }
    })
    function mudarOptions(){
        var tipoOrc = Array.apply(null, document.querySelectorAll("select[name='orc[]']"));
        if(document.querySelector('#idGrupoServico').value == 1){
            tipoOrc.forEach((elemento) => {
                if (elemento.options[elemento.selectedIndex].value == "serv") {
                    elemento.value = ''
                }
                for(x=0;x<elemento.options.length;x++){
                    if(elemento.options[x].value=="serv"){
                        elemento.options[x].style = 'display:none';
                    }
                }
            })
        }else{
            tipoOrc.forEach((elemento) => {
                for(x=0;x<elemento.options.length;x++){
                    if(elemento.options[x].value=="serv"){
                        elemento.options[x].style = 'display:block';
                    }
                }
            })
        }
    }
    function verificarItens() {
        var tipoOrc = Array.apply(null, document.querySelectorAll("select[name='orc[]']"));
        var tipoProd = Array.apply(null, document.querySelectorAll("select[name='tipo_prod[]']"));
        var verifyOrc = true;
        var verifyProd = true;
        tipoOrc.forEach((elemento) => {
            if (elemento.options[elemento.selectedIndex].value == "") {
                verifyOrc = false;
            }
        })
        tipoProd.forEach((elemento) => {
            if (elemento.options[elemento.selectedIndex].value == "") {
                verifyProd = false;
            }
        })
        if (verifyProd && verifyOrc) {
            document.getElementById("formOrcamento").submit();
        } else {
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

                var valorFrete = $('#frete_' + i).val();
                valorFrete = Formata_Moeda(valorFrete);
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
                var total3 = total1 + total2 - desconto + valorFrete;

                //total3=parseFloat(total3);	
                //total3=Formata_Moeda(total3);	

                //total3.toLocaleString('pt-br', {minimumFractionDigits: 2});
                //alert(total3);
                subtotal_calculo = subtotal_calculo + total1;
                ipi_calculo = ipi_calculo + total2;
                desconto_calculo = desconto_calculo + desconto;

                //desconto_calculo=parseFloat(desconto_calculo);
                //desconto_calculo.toLocaleString('pt-br', {minimumFractionDigits: 2});

                total_calculo = total_calculo + total3 ;

                /*total3 = parseFloat(total3.toFixed(2));
                total3=(total3).toLocaleString(); 
                
                total1 = parseFloat(total1.toFixed(2));
                total1=(total1).toLocaleString(); */

                $('#val_ipi_rs_' + i).val(Formata_Dinheiro(ipi_calculo));

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

    function getValor(cliente,idSolicitante2) {
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
                    if(typeof idSolicitante2 === "undefined" || idSolicitante2 == null || idSolicitante2 == ""){
                        txt_solicitante += "<option value='" + solici.idSolicitante + "'>" + solici.nome + "</option>";
                    }else{
                        if(idSolicitante2 == solici.idSolicitante){
                            txt_solicitante += "<option selected value='" + solici.idSolicitante + "'>" + solici.nome + "</option>";
                        }else{
                            txt_solicitante += "<option value='" + solici.idSolicitante + "'>" + solici.nome + "</option>";
                        }
                    }
                    
                });
                $(".recebe-solici").html(txt_solicitante);

            }
        });


    }


    $(document).ready(function() {
       // $(".money").maskMoney();
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

    function closetable() {

        for (x = 0; x < contador_global_autocomplete; x++) {
            tr = document.querySelector(".trfilho" + x);
            if (tr.style.display == "table-row" || tr.style.display == "") {
                $(".trfilho" + x).hide('fast');
                $('.tdpai' + x).parent('tr').css('background-color', '');
                $('.tdpai' + x).find("a > i").removeClass("fa-minus");
                $('.tdpai' + x).find("a > i").addClass("fa-plus");
            }
        }
    }

function duplicarCampos() {

    var contador_local_autocomplete = contador_global_autocomplete;
    var cloneDiv = '';
    if (contador_global_autocomplete > 0) {
        closetable();
    }

    cloneDiv = '<tr class="trpai' + contador_local_autocomplete + '">' +
        '<td class="tdpai' + contador_local_autocomplete + '" onclick="openclose(this,' + contador_local_autocomplete + ')" style="text-align: center; display: table-cell;min-height: 10em;vertical-align: middle;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>' +
        '<td style="display: table-cell;vertical-align: middle;"><div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">' +
        '<div class="span12" style="padding: 0.2%; margin-left: 0">' +

        // Unidade de Execução com classe unex-item
        '<div class="span1">' +
        '<label>Un. Ex.:</label>' +
        '<select name="unex[]" class="span12 unex-item">' +
        '<option value="">Selecione</option>' +
        <?php foreach ($unid_exec as $v) { ?>
            '<option value="<?php echo $v->id_unid_exec ?>"><?php echo $v->status_execucao ?></option>' +
        <?php } ?>
        '</select>' +
        '</div>' +

        // Tipo O.S. com classe tipoos-item
        '<div class="span1">' +
        '<label>Tipo O.S.</label>' +
        '<select class="span12 tipoos-item" name="tipoos[]">' +
        '<option value="">Selecione</option>' +
        <?php foreach ($tipo_os as $ostipo) { ?>
            '<option value="<?php echo $ostipo->id_tipo; ?>"><?php echo $ostipo->nome_tipo; ?></option>' +
        <?php } ?>
        '</select>' +
        '</div>' +

        // Campo PN e inputs ocultos
        '<div class="span1">' +
        '<label><b>PN</b>:</label>' +
        '<input type="text" class="span12" id="pn_' + contador_local_autocomplete + '" onblur="carregarPn(' + contador_local_autocomplete + ')" name="pn[]" value="" />' +
        '<input type="hidden" id="item[]" name="item[]" value="" size="1"/>' +
        '<input type="hidden" id="idProdutos_' + contador_local_autocomplete + '" name="idProdutos[]" size="3" value=""/>' +
        '<input type="hidden" id="idChecklist_' + contador_local_autocomplete + '" name="idChecklist[]" size="3" value=""/>' +
        '<input type="hidden" name="contador[]" size="3" value="' + contador_local_autocomplete + '"/>' +
        '</div>' +

        // Campo Orçamento com classe orcamento-item
        '<div class="span1">' +
        '<label>Orç.:</label>' +
        '<select id="orc_' + contador_local_autocomplete + '" onchange="verificarEscopo(' + contador_local_autocomplete + ')" name="orc[]" class="span12 orcamento-item">' +
        '<option value="">Selecione o tipo</option>' +
        '<option value="fab">FAB</option>' +
        '<option value="serv" style="'+(document.querySelector('#idGrupoServico').value=="1"?"display:none":"display:block")+'">SERV</option>' +
        '</select>' +
        '</div>' +

        // Campo Tipo de Produto com classe tipoprod-item
        '<div class="span2">' +
        '<label>Tipo de Prod.:</label>' +
        '<select id="tipo_prod_' + contador_local_autocomplete + '" onchange="verificarEscopo(' + contador_local_autocomplete + ')" name="tipo_prod[]" class="span12 tipoprod-item">' +
        '<option value="" selected>Selecione o produto</option>' +
        '<option value="cil">Cilindro</option>' +
        '<option value="maq">Máquina</option>' +
        '<option value="pec">Peça</option>' +
        '<option value="sub">Subconjunto</option>' +
        '</select>' +
        '</div>' +

        // Continuação da linha
            '<div class="span4">' +
            '<label>Descrição:</label>' +
            '<input type="text" class="span12" id="descricao_item_' + contador_local_autocomplete + '" name="descricao_item[]"  value="" />' +
            '</div>' +
            '<div class="span1" alt="Código de identificação do produto." title="Código de identificação do produto.">' +
            '<label>Tag:</label>' +
            '<input type="text" class="span12" id="tag_' + contador_local_autocomplete + '" name="tag[]"  value="" />' +
            '</div>' +
            '<div class="span1" alt="A quantidade de unidades do produto no estoque." title="A quantidade de unidades do produto no estoque.">' +
            '<label>Estq.:</label>' +
            '<input type="text" class="span12" id="qtdest_' + contador_local_autocomplete + '" name="qtdest[]"  value="" disabled/>' +
            '</div>' +
            '</div>' +
            '</div></td>' +
            '<td style="text-align: center; display: table-cell;min-height: 10em;vertical-align: middle;">' +
            '<a href="#"  onclick="removerCampos(this);" style="margin-right: 1%" class="btn btn-danger tip-top" title="Excluir Item"><i class="icon-remove icon-white"></i></a>' +
            '</td>' +
            '</tr>' +
            '<tr class="trfilho' + contador_local_autocomplete + '" style="display:none">' +
            '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">' +
            '</td>' +
            '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">' +
            '<div >' +
            '<div class="span12" style="padding: 0.2%; margin-left: 0">' +
            '<div class="span2">' +
            '<label>Ultima O.S.:</label>' +
            '<input type="text" class="span12" id="cOs_' + contador_local_autocomplete + '" name="cOs[]" value="" disabled/> ' +
            '</div>' +
            '<div class="span2">' +
            '<label>Custo Insumo:</label>' +
            '<input type="text" class="span12" id="custoIns_' + contador_local_autocomplete + '" name="custoIns[]"  value="" disabled/>' +
            '</div>' +
            '<div class="span2">' +
            '<label>Custo HR/Maq</label>' +
            '<input type="text" class="span12" id="custoFab_' + contador_local_autocomplete + '" name="custoFab[]"  value="" disabled/>' +
            '</div>' +
            '<div class="span2">' +
            '<label>Custo Impostos</label>' +
            '<input type="text" class="span12" id="custoIcms_' + contador_local_autocomplete + '" name="custoIcms[]"  value="" disabled/>' +
            '</div>' +
            '<div class="span2">' +
            '<label>Custo Frete</label>' +
            '<input type="text" class="span12" id="custoFrete_' + contador_local_autocomplete + '" name="custoFrete[]"  value="" disabled/>' +
            '</div>' +
            '<div class="span2">' +
            '<label>Custo Total</label>' +
            '<input type="text" class="span12" id="custoTotal_' + contador_local_autocomplete + '" name="custoTotal[]"  value="" disabled/>' +
            '</div>' +
            '</div>' +
            '<div class="span12" style="padding: 0.2%; margin-left: 0">' +
            '<div class="span1">' +
            '<label>QTD:</label>' +
            '<input type="text" class="span5 number" id="qtd_' + contador_local_autocomplete + '" name="qtd[]" onblur="calculaSubTotal(' + contador_local_autocomplete + ');" onclick="this.select();" value="1" />' +
            '<select class="span7" id="tipoqtd_' + contador_local_autocomplete + '" name="tipoqtd[]">'+
            <?php foreach ($dados_tipoqtd as $v) {?>
                '<option value="<?php echo $v->idTipoQtd?>"><?php echo $v->descricaoTipoQtd?></option>'+
            <?php }?>
            '</select>'+
            '</div>' +
            '<div class="span1">' +
            '<label>Vl.Unit.:</label>' +
            '<input type="text" class="span12" id="val_unit_' + contador_local_autocomplete + '" name="val_unit[]" value="0,00" onKeyUp="calculaSubTotal(' + contador_local_autocomplete + ');"   onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" /> ' +
            '</div>' +
            '<div class="span2">' +
            '<label>Sub.Tot.:</label>' +
            '<input type="text" class="span12" id="subtot_' + contador_local_autocomplete + '" name="subtot[]" value="0,00" readonly/>' +
            '</div>' +
            '<div class="span1">' +
            '<label>Prazo:</label>' +
            '<input type="text" class="span12 number" id="prazo_' + contador_local_autocomplete + '" name="prazo[]" onclick="this.select(); " value="30" /> ' +
            '</div> ' +
            '<div class="span1">' +
            '<label>Frete:</label>' +
            '<input type="text" class="span12" id="frete_' + contador_local_autocomplete + '" name="frete[]" value="0,00" onKeyUp="calculaSubTotal(' + contador_local_autocomplete + ');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />' +
            '</div>' +
            '<div class="span2">' +
            '<label>Desconto:</label>' +
            '<input type="text" class="span12" id="desconto_' + contador_local_autocomplete + '" name="desconto[]" value="0,00" onKeyUp="calculaSubTotal(' + contador_local_autocomplete + ');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />' +
            '</div>' +
            '<div class="span1">' +
            '<label>IPI (%):</label>' +
            '<input type="text" class="span12" id="val_ipi_' + contador_local_autocomplete + '" name="val_ipi[]" value="0,00" onKeyUp="calculaSubTotal(' + contador_local_autocomplete + ');"  onKeyPress="FormataValor2(this,event,12,2);" onclick="this.select();" />' +
            '</div>' +
            '<div class="span1">' +
            '<label>IPI (R$):</label>' +
            '<input type="text" disabled class="span12" id="val_ipi_rs_' + contador_local_autocomplete + '" name="val_ipi_rs[]" value="0,00"  onclick="this.select();" />' +
            '</div>' +
            '<div class="span2">' +
            '<label>Valor Tot.:</label>' +
            '<input type="text" class="span12" id="vlr_total_' + contador_local_autocomplete + '" name="vlr_total[]" value="0,00" />' +
            '</div>' +
            '</div>' +
            '<div class="span12" style="padding: 0.2%; margin-left: 0">' +
            '<div class="span8">' +
            '<label>Detalhamento: </label>' +
            '<textarea style="max-width:100%" id="detalhe_' + contador_local_autocomplete + '"  cols="50" class="span12" name="detalhe[]"></textarea>' +
            '</div>' +
            '<div class="span2">' +
            '<label>Previsão de Chegada</label>' +
            '<input type="text" class="data span12" id="data_chegada_' + contador_local_autocomplete + '" name="data_chegada[]" value="" />' +
            '</div>' +
            '<div class="span4" id="divSelectFab_' + contador_local_autocomplete + '">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div id="escopo_' + contador_local_autocomplete + '">' +

            '</div>' +
            '</td>' +
            '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">' +
            '</td>' +
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
                            if (data.dados.somaInsumos) {
                                $('#custoIns_' + contador_local_autocomplete).val(data.dados.somaInsumos);
                                calcularTotalUnit(contador_local_autocomplete);
                            } else {
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
                            if (!data.dados) {
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
                if ($("#orc_" + contador_local_autocomplete).val() == "serv") {
                    $("#idChecklist_" + contador_local_autocomplete).val("");
                } else if ($("#orc_" + contador_local_autocomplete).val() == "fab") {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/peritagem/getcatalogoproduto",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            idProduto: ui.item.id
                        },
                        success: function(data) {
                            $("#escopo_" + contador_local_autocomplete).empty();
                            if (data.resultado.length > 0) {
                                var variavel = {
                                    value: data.resultado[0].idCatalogoProduto
                                }
                                buscarCatalogo(variavel, contador_local_autocomplete);
                                $("#idChecklist_" + contador_local_autocomplete).val(variavel.value);
                            }else{                                
                                $("#idChecklist_" + contador_local_autocomplete).val("");
                                preencherTabelaCatalogo(pos,false);
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

    function carregarPn(pos) {
        if (document.querySelector("#descricao_item_" + pos).value == "" && document.querySelector("#pn_" + pos).value != "") {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/produtos/getProdutoByPn",
                type: 'POST',
                dataType: 'json',
                data: {
                    pn: document.querySelector("#pn_" + pos).value
                },
                success: function(data) {
                    if (data.result) {
                        document.querySelector("#descricao_item_" + pos).value = data.produto.descricao + " PN: " + data.produto.pn + " Ref.: " + data.produto.referencia;
                        document.querySelector("#idProdutos_" + pos).value = data.produto.idProdutos
                    } else if (data.msg != "") {
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

                                if (data.dados.somaInsumos) {
                                    $('#custoIns_' + contador_local_autocomplete).val(data.dados.somaInsumos);
                                    calcularTotalUnit(contador_local_autocomplete);
                                } else {
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
                                    //console.log(1);
                                } else {
                                    $('#custoFrete_' + contador_local_autocomplete).val(data.dados);
                                    //console.log(2);
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

    function verificarEscopo(pos) {
        var orc = document.querySelector('#orc_' + pos).value;
        var tipo_prod = document.querySelector('#tipo_prod_' + pos).value;
        var idProduto = document.querySelector('#idProdutos_' + pos).value;
        $("#escopo_" + pos).empty();
        if (tipo_prod && orc == "serv" && idProduto) {
            $("#divSelectFab_" + pos).empty();
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
                    $("#escopo_" + pos).empty();
                    //if(data.resultado.length > 0)
                    preencherTabela(pos, data.resultado);
                },
                error: function(xhr, textStatus, error) {
                    console.log("4");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },
            })
        } else {
            if (idProduto && orc == "fab") {
                $("#escopo_"  + pos).empty();
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
                        $("#divSelectFab_" + pos).empty();
                        if (data.resultado.length > 0) {
                            var variavel = {
                                value: data.resultado[0].idCatalogoProduto
                            }
                            buscarCatalogo(variavel, pos);
                            $("#idChecklist_" + pos).val(variavel.value);
                        }else{
                            $("#idChecklist_" + pos).val("");
                            preencherTabelaCatalogo(pos,false);
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
            } else {
                $("#idChecklist" + pos).val("");
            }
        }
    }


    function preencherTabela(pos, resultado) {
        var html = '';
        var modals = '';
        $("#escopo_" + pos).empty();
        count = 0;
        if (resultado.length > 0) {
            resultado.forEach((elemento) => {
                if (elemento.idServicoEscopo == 1) {
                    if (elemento.pn == null)
                        elemento.pn = "";
                    html += '<tr>' +
                        '<td style="width:9%"><input type="text" class="span12" name="addPN_' + pos + '[]" id="addPN_' + pos + '_' + count + '" ><input type="hidden" name="addIdProduto_' + pos + '[]" id="addIdProduto_' + pos + '_' + count + '" value=""></td>' +
                        '<td><input type="hidden" name="addIdServicoEscopo_' + pos + '[]" id="addIdServicoEscopo_' + pos + '_' + count + '" value="' + elemento.idServicoEscopoItens + '">' + elemento.descricaoServicoItens + '</td>' +
                        '<td>' + elemento.descricaoClasse + '</td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>';
                   
                    html += '<td>'+//'<a href="#modal-imagem_'+pos+'_'+count+'" role="button" data-toggle="modal" style="margin-right: 1%" class="btn tip-top" ><i class="icon-ban-circle" style="color:grey"></i></a>'+
                        '<div id="modal-imagem_'+pos+'_'+count+'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
                            '<div class="modal-header">'+
                                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'+
                                '<h5 id="myModalLabel">Anexar Desenho</h5>'+
                            '</div>'+
                            '<div class="modal-body">'+
                                '<input type="text" name="addnomeArquivo_'+pos+'[]" id="addnomeArquivo_'+pos+'_'+count+'">'+
                                '<input type="file" onchange="attIcon('+pos+','+count+')" name="addimag_'+pos+'[]" id="addnomeArquivo_'+pos+'_'+count+'">'+
                            '</div>'+/*
                            '<div class="modal-footer">'+
                                '<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>'+
                                '<button class="btn btn-danger">Adicionar</button>'+
                            '</div>'+ */
                        '</div>'+
                    '</td>' +
                        
                    '</tr>';




                } else {
                    var quantidade = 0;
                    if (elemento.pn == null)
                        elemento.pn = "";
                    if(elemento.idProduto){                        
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/orcamentos/getEstoqueProd",
                            dataType: 'json',
                            async:false,
                            type: 'POST',
                            data:{
                                idProduto : elemento.idProduto
                            },
                            success: function(data2) {
                                if(data2.result)
                                    quantidade = data2.quantidade
                                else
                                    quantidade = 0;
                            },
                            error: function(xhr, textStatus, error) {
                                console.log("4");
                                console.log(xhr.responseText);
                                console.log(xhr.statusText);
                                console.log(textStatus);
                                console.log(error);
                                quantidade = 0;
                            },
                        })
                    }
                    html += '<tr>';
                        if(elemento.pn){
                            html += '<td style="height: 31px">' + elemento.pn + '</td>';
                        }else{													
                            html += '<td style="width:10%"><input type="hidden" class="money span12" name="idServicoEscopoItens_novopn_'+pos+'[]" value="'+elemento.idServicoEscopoItens+'"><input type="text" class="span12" name="novopn_'+pos+'[]" id="novopn_'+pos+'_'+count+'" ><input type="hidden" class="span12" name="novoidpn_'+pos+'[]" id="novoidpn_'+pos+'_'+count+'"></td>';
                            html += '<script type="text/javascript">'+
                                '$("#novopn_'+pos+'_'+count+'").autocomplete({' +
                                    'source: "<?php echo base_url();?>index.php/almoxarifado/autoCompleteProd2",' +
                                    'minLength: 1,' +
                                    'select: function( event, ui ) {' +
                                    'valor = this.id.split("_");' +
                                    '$("#novoidpn_'+pos+'_'+count+'").val(ui.item.id);' +
                                    '}' +
                                '});'+
                            '<\/script>';
                        }
                        //'<td>' + elemento.pn + '</td>' +
                        html += '<td><input type="hidden" name="idServicoEscopo_' + pos + '[]" id="idServicoEscopo_' + pos + '_' + count + '" value="' + elemento.idServicoEscopoItens + '">' + elemento.descricaoServicoItens + '</td>' +
                        '<td>' + elemento.descricaoClasse + '</td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td>'+quantidade+'</td>' +
                        '<td>'+//'<a href="#modal-imagem_'+pos+'_'+count+'" role="button" data-toggle="modal" style="margin-right: 1%" class="btn tip-top" ><i class="icon-ban-circle" style="color:grey"></i></a>'+
                            '<div id="modal-imagem_'+pos+'_'+count+'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
                                '<div class="modal-header">'+
                                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'+
                                    '<h5 id="myModalLabel">Anexar Desenho</h5>'+
                                '</div>'+
                                '<div class="modal-body">'+
                                    '<input type="text" name="nomeArquivo_'+pos+'[]" id="nomeArquivo_'+pos+'_'+count+'">'+
                                    '<input type="file" onchange="attIcon('+pos+','+count+')" name="imag_'+pos+'" id="imag_'+pos+'_'+count+'">'+
                                '</div>'+
                            '</div>'+
                        '</td>'+                        
                        '</tr>';
                }

                count++;

            })
        } /*else {
            html += '<tr>' +
                '<td><input class="span12" name="novoEscopoPN_' + pos + '[]" id="novoEscopoPN_' + pos + '_0" type="text"><input class="span12" name="novoEscopoIdProduto_' + pos + '[]" id="novoEscopoIdProduto_' + pos + '_0" type="hidden"></td>' +
                '<td><input class="span12" name="novoEscopoDescProd_' + pos + '[]" id="novoEscopoDescProd_' + pos + '_0" type="text"></td>' +
                '<td><select name="novoEscopoIdClasse_' + pos + '[]" id="novoEscopoIdClasse_' + pos + '_0" class="span12">' +
                '<option value="">Selecione</option>' +
                <?php foreach ($dados_classe as $c) {
                    echo '\'<option value="' . $c->idClasse . '">' . $c->descricaoClasse . '</option>\'+';
                } ?> '</select></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '</tr>';

        }*/

        table = '<h5>Checklist</h5>' +
            '<table id="tableEscopo_' + pos + '" class="table table-bordered ">' +
            '<thead>' +
            '<tr>' +
            '<th>PN (SUB)</th>' +
            '<th>DESCRIÇÃO</th>' +
            '<th>CLASSE</th>' +
            '<th>QTD</th>' +
            '<th>Ø EXT.</th>' +
            '<th>Ø INT.</th>' +
            '<th>COMP.</th>' +
            '<th>OBS.</th>' +
            '<th>Valor Unit.</th>' +
            '<th>Valor Total</th>' +
            '<th>ESTOQUE</th>' +
            '<th></th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            html +
            '</tbody>' +
            '</table>' +
            '</br>' +
            '<div>' +
            //'<ahref="#" onclick="adicionarItemCheckList(' + pos + ');" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Item Checklist</a>' +
            '</div>'+
            '<div>'+
            modals+
            '</div>';
        $("#escopo_" + pos).append(table);
        count = 0;
        count2 = 0;
        if (resultado.length > 0) {
            resultado.forEach((elemento) => {
                if (elemento.idServicoEscopo == 1) {
                    //inputProduto = '#addIdProduto_'+pos+'_'+count
                    $('#addPN_' + pos + '_' + count).autocomplete({
                        source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
                        minLength: 1,
                        select: function(event, ui) {
                            valor = this.id.split("_");
                            $('#addIdProduto_' + valor[1] + '_' + valor[2]).val(ui.item.id);
                        }
                    });
                }
                count++;
            })
        } else {
            $('#novoEscopoPN_' + pos + '_0').autocomplete({
                source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
                minLength: 1,
                select: function(event, ui) {
                    valor = this.id.split("_");
                    $('#novoEscopoDescProd_' + valor[1] + '_' + valor[2]).val(ui.item.produtos);
                    $('#novoEscopoIdProduto_' + valor[1] + '_' + valor[2]).val(ui.item.id);
                }
            });

            
        $( "#novoEscopoPN_" + pos + '_0' ).keyup(function() {
            valor = this.id.split("_");
            $('#novoEscopoIdProduto_' + valor[1] + '_' + valor[2]).val('')
        });
        }
    }

    function preencherSelect(pos, resultado) {
        html = '<option value=""> Selecione um checklist</option>';
        resultado.forEach((elemento) => {
            html += '<option value="' + elemento.idCatalogoProduto + '">' + elemento.descricaoCatalogo + '</option>'
        })
        div = '<label>Checklist</label>' +
            '<select id="catalogoProduto_' + pos + '" class="span12" onchange="buscarCatalogo(this,' + pos + ')">' +
            html +
            '</select>';
        //$("#divSelectFab_"+pos).append(div);

    }

    function attIcon(pos,contagem){
        //alert("OK!")
    }

    function preencherTabelaCatalogo(pos, resultado) {
        $("#escopo_" + pos).empty();
        html = '';
        if(!resultado){/*
            html += '<tr>'+
                    '<td><input type="text" class="span12" name="novoCatalogoPN_' + pos + '[]" id="novoCatalogoPN_' + pos + '_0">'+
                    '<input type="hidden" class="span12" name="novoCatalogoIdProduto_' + pos + '[]" id="novoCatalogoIdProduto_' + pos + '_0"></td>'+
                    '<td><input type="text" class="span12" name="novoCatalogoDescProd_' + pos + '[]" id="novoCatalogoDescProd_' + pos + '_0"></td>'+
                    '<td><input type="text" class="span12" name="novoCatalogoQtd_' + pos + '[]" id="novoCatalogoQtd_' + pos + '_0"></td>'+
                    '<td></td>'+
                    '<td></td>'+
                '</tr>';*/
        }else{
            resultado.forEach((elemento) => {
            
                if(elemento.idProduto){
                    quantidade = 0;
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/orcamentos/getEstoqueProd",
                        dataType: 'json',
                        async:false,
                        type: 'POST',
                        data:{
                            idProduto : elemento.idProduto
                        },
                        success: function(data2) {
                            if(data2.result)
                                quantidade = data2.quantidade
                            else
                                quantidade = 0;
                            $("#escopo_" + pos).empty();
                        },
                        error: function(xhr, textStatus, error) {
                            console.log("4");
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                            quantidade = 0;
                        },
                    })
                }
                
                
                if (elemento.pn == null)
                    elemento.pn = "";
                html += '<tr>' +
                    '<td>' + elemento.pn + '</td>' +
                    '<td>' + elemento.descricao + '</td>' +
                    '<td>' + elemento.quantidade + '</td>' +
                    '<td>'+quantidade+'</td>'+
                    '<td></td>'+
                    '</tr>';
            })
        }        
        table = '<h5>Checklist</h5>' +
            '<table class="table table-bordered" name="tableEscopo_'+pos+'" id="tableEscopo_'+pos+'">' +
            '<thead>' +
            '<tr>' +
            '<th>PN (SUB)</th>' +
            '<th>DESCRIÇÃO</th>' +
            '<th>QTD </th>' +
            '<th>ESTOQUE </th>' +
            '<th>' +
            '</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            html +
            '</tbody>' +
            '</table>'+            
            '</br>' +
            '<div>' +
            //'<ahref="#" onclick="adicionarItemCatalogo(' + pos + ');" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Item Checklist</a>' +
            '</div>';
        $("#escopo_" + pos).append(table);
        if(!resultado){
            $('#novoCatalogoPN_' + pos + '_0').autocomplete({
                source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
                minLength: 1,
                select: function(event, ui) {
                    valor = this.id.split("_");
                    $('#novoCatalogoDescProd_' + valor[1] + '_' + valor[2]).val(ui.item.produtos);
                    $('#novoCatalogoIdProduto_' + valor[1] + '_' + valor[2]).val(ui.item.id);
                }
            });
            $( "#novoCatalogoPN_" + pos + '_0' ).keyup(function() {
                valor = this.id.split("_");
                $('#novoCatalogoIdProduto_' + valor[1] + '_' + valor[2]).val('')
            });

        }
    }

    function buscarCatalogo(select, pos) {
        if (select.value) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/peritagem/getcatalogoitens",
                type: 'POST',
                dataType: 'json',
                data: {
                    idCatalogo: select.value
                },
                success: function(data) {
                    preencherTabelaCatalogo(pos, data.resultado)
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
        document.querySelector("#val_unit_" + contador).value = retorna_formatado(0);
        calculaSubTotal(contador);

    }

    function verificarInfo() {
        var produtos = Array.apply(null, document.querySelectorAll("input[name='idProdutos[]']"));
        var pn = Array.apply(null, document.querySelectorAll("input[name='pn[]']"));
        var quantidade = document.querySelectorAll("input[name='qtd[]']");
        var selectOrc = document.querySelectorAll("select[name='orc[]']");
        var selectProd = document.querySelectorAll("select[name='tipo_prod[]']");
        var contador = document.querySelectorAll("input[name='contador[]']");
        var center = $(window).height() / 2;
        var selectEmitente = document.querySelector("select[name='idEmitente']");
        var selectidSolicitante = document.querySelector("select[name='idSolicitante']");
        var selectclientes_id = document.querySelector("input[name='clientes_id']");
		var selectidVendedorAuxiliar = document.querySelector("select[name='idVendedorAuxiliar']");
		var selectidVendedor = document.querySelector("select[name='idVendedor']");
  
        var selectclientes = document.querySelector("input[name='cliente']");

        if(!selectEmitente.value){
            alert("Informe um emitente válido.");
            $(selectEmitente).css('border-color', 'red');
            return;
        }
        if(!selectidSolicitante.value){
            alert("Informe um solicitante válido.");
            $(selectidSolicitante).css('border-color', 'red');
            return;
        }
		
        if(!selectidVendedor.value){
            alert("Informe um Gerente válido.");
            $(selectidVendedor).css('border-color', 'red');
            return;
        }		
		
        if(!selectidVendedorAuxiliar.value){
            alert("Informe um Vendedor válido.");
            $(selectidVendedorAuxiliar).css('border-color', 'red');
            return;
        }			
        if(!selectclientes_id.value || !selectclientes.value){
            alert("Informe uma cliente válida.");
            $(selectclientes_id).css('border-color', 'red');
            return;
        }

        for (x = 0; x < produtos.length; x++) {
            if (!produtos[x].value) {
                alert("Informe um PN válido.");
                $(pn[x]).css('border-color', 'red');
                return;
            }
            if (!quantidade[x].value) {
                alert("Informe a quantidade.");
                $(quantidade[x]).css('border-color', 'red');
                return;
            } else if(quantidade[x].value < 1){
                alert("A quantidade não pode ser menor que 1.");
                $(quantidade[x]).css('border-color', 'red');
                return;
            }
            if(!selectOrc[x].value){
                alert("Informe o tipo de orç.");
                $(selectOrc[x]).css('border-color', 'red');
                return;
            }
            if(!selectProd[x].value){
                alert("Informe o tipo de produto.");
                $(selectProd[x]).css('border-color', 'red');
                return;
            }
        }
        for(x=0;x<contador.length;x++){
            
            // Escopo Cilindro Padrão
            /*element = document.querySelectorAll("input[name='addPN_"+contador[x].value+"[]']");
            if (typeof(element) != 'undefined' && element != null && element.length>0) {
                addIdProduto = document.querySelectorAll("input[name='addIdProduto_"+contador[x].value+"[]']");
                for(y=0;y<element.length;y++){
                    if (!element[y].value || !addIdProduto[y].value) {
                        alert("Informe um PN válido.");
                        $(element[y]).css('border-color', 'red');
                        return;
                    }
                    if () {
                        alert("Informe a quantidade.");
                        $(addIdProduto[y]).css('border-color', 'red');
                        return;
                    }
                }
            }*/

            //Escopo novo
            element = document.querySelectorAll("input[name='novoEscopoPN_"+contador[x].value+"[]']");
            if (typeof(element) != 'undefined' && element != null && element.length>0) {
                novoEscopoIdProduto_ = document.querySelectorAll("input[name='novoEscopoIdProduto_"+contador[x].value+"[]']");
                novoEscopoDescProd_ = document.querySelectorAll("input[name='novoEscopoDescProd_"+contador[x].value+"[]']");
                selectClasse = document.querySelectorAll("select[name='novoEscopoIdClasse_"+contador[x].value+"[]']");
                for(y=0;y<element.length;y++){/*
                    if (!element[y].value || !novoEscopoIdProduto_[y].value) {
                        alert("Informe um PN válido.");
                        $(element[y]).css('border-color', 'red');
                        return;
                    }*/
                    if (!novoEscopoDescProd_[y].value) {
                        alert("Informe uma descrição.");
                        $(novoEscopoDescProd_[y]).css('border-color', 'red');
                        return;
                    }
                    if(!selectClasse[y].value){
                        alert("Informe a classe.");
                        $(selectClasse[y]).css('border-color', 'red');
                        return;
                    }
                }
            }

            //Catalogo Novo 
            element = document.querySelectorAll("input[name='novoCatalogoPN_"+contador[x].value+"[]']");
            if (typeof(element) != 'undefined' && element != null && element.length>0) {
                novoCatalogoIdProduto_ = document.querySelectorAll("input[name='novoCatalogoIdProduto_"+contador[x].value+"[]']");
                novoCatalogoDescProd_ = document.querySelectorAll("input[name='novoCatalogoDescProd_"+contador[x].value+"[]']");
                novoCatalogoQtd_ = document.querySelectorAll("input[name='novoCatalogoQtd_"+contador[x].value+"[]']");
                tipoProd = document.querySelector("#tipo_prod_"+contador[x].value).value;
                for(y=0;y<element.length;y++){
                    if(tipoProd!="pec"){

                        if (!element[y].value || !novoCatalogoIdProduto_[y].value) {
                            alert("Informe um PN válido.");
                            $(element[y]).css('border-color', 'red');
                            return;
                        }
                        if (!novoCatalogoDescProd_[y].value) {
                            alert("Informe uma descrição.");
                            $(novoCatalogoDescProd_[y]).css('border-color', 'red');
                            return;
                        }
                        if(!novoCatalogoQtd_[y].value){
                            alert("Informe a quantidade.");
                            $(novoCatalogoQtd_[y]).css('border-color', 'red');
                            return;
                        } else if(novoCatalogoQtd_[y].value<1){
                            alert("Quantidade deve ser maior que 1.");
                            $(novoCatalogoQtd_[y]).css('border-color', 'red');
                            return;
                        }
                    }
                }
            }

            //Catalogo. Novo Item 
            /*element = document.querySelectorAll("input[name='novoCatalogoPN_"+contador[x].value+"[]']");
            if (typeof(element) != 'undefined' && element != null && element.length>0) {
                novoCatalogoIdProduto_ = document.querySelectorAll("input[name='novoCatalogoIdProduto_"+contador[x].value+"[]']");
                novoCatalogoDescProd_ = document.querySelectorAll("input[name='novoCatalogoDescProd_"+contador[x].value+"[]']");
                novoCatalogoQtd_ = document.querySelectorAll("input[name='novoCatalogoQtd_"+contador[x].value+"[]']");
                for(y=0;y<element.length;y++){
                    if (!element[y].value || !novoCatalogoIdProduto_[y].value) {
                        alert("Informe um PN válido.");
                        $(element[y]).css('border-color', 'red');
                        return;
                    }
                    if (!novoCatalogoDescProd_[y].value) {
                        alert("Informe uma descrição.");
                        $(novoCatalogoDescProd_[y]).css('border-color', 'red');
                        return;
                    }
                    if(!novoCatalogoQtd_[y].value){
                        alert("Informe a quantidade.");
                        $(novoCatalogoQtd_[y]).css('border-color', 'red');
                        return;
                    }
                }
            }*/
            


        }
         
        




        $('#formOrcamento').submit();

    }

    function adicionarItemCheckList(pos) {
        var table = document.getElementById("tableEscopo_" + pos).getElementsByTagName('tbody')[0];
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        $("#tableEscopo_" + pos).find("tbody").append('<tr><td><input type="text" class="span12" name="novoEscopoPN_' + pos + '[]" id="novoEscopoPN_' + pos + '_' + numOfRows + '"><input type="hidden" class="span12" name="novoEscopoIdProduto_' + pos + '[]" id="novoEscopoIdProduto_' + pos + '_' + numOfRows + '"></td><td><input type="text" class="span12" name="novoEscopoDescProd_' + pos + '[]" id="novoEscopoDescProd_' + pos + '_' + numOfRows + '"></td><td><select class="span12" name="novoEscopoIdClasse_' + pos + '[]" id="novoEscopoIdClasse_' + pos + '_' + numOfRows + '"><option value="">Selecione</option><?php foreach ($dados_classe as $v) {echo '<option value="' . $v->idClasse . '">' . $v->descricaoClasse . '</option>'; } ?></select></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow3(this.parentNode.parentNode.rowIndex,'+pos+')"><font size=1>Excluir</font></button></td></tr>');
        $('#novoEscopoPN_' + pos + '_' + numOfRows).autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
            minLength: 1,
            select: function(event, ui) {
                valor = this.id.split("_");
                $('#novoEscopoDescProd_' + valor[1] + '_' + valor[2]).val(ui.item.produtos);
                $('#novoEscopoIdProduto_' + valor[1] + '_' + valor[2]).val(ui.item.id);
            }
        });

        $( "#novoEscopoPN_" + pos + '_'+numOfRows ).keyup(function() {
            valor = this.id.split("_");
            $('#novoEscopoIdProduto_' + valor[1] + '_' + valor[2]).val('')
        });
    }
    function adicionarItemCatalogo(pos) {
        var table = document.getElementById("tableEscopo_" + pos).getElementsByTagName('tbody')[0];
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        $("#tableEscopo_" + pos).find("tbody").append('<tr><td><input type="text" class="span12" name="novoCatalogoPN_' + pos + '[]" id="novoCatalogoPN_' + pos + '_' + numOfRows + '"><input type="hidden" class="span12" name="novoCatalogoIdProduto_' + pos + '[]" id="novoCatalogoIdProduto_' + pos + '_' + numOfRows + '"></td><td><input type="text" class="span12" name="novoCatalogoDescProd_' + pos + '[]" id="novoCatalogoDescProd_' + pos + '_' + numOfRows + '"></td><td><input type="text" class="span12" name="novoCatalogoQtd_' + pos + '[]" id="novoCatalogoQtd_' + pos + '_' + numOfRows + '"></td><td></td><td><button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow3(this.parentNode.parentNode.rowIndex,'+pos+')"><font size=1>Excluir</font></button></td></tr>');
        $('#novoCatalogoPN_' + pos + '_' + numOfRows).autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
            minLength: 1,
            select: function(event, ui) {
                valor = this.id.split("_");
                $('#novoCatalogoDescProd_' + valor[1] + '_' + valor[2]).val(ui.item.produtos);
                $('#novoCatalogoIdProduto_' + valor[1] + '_' + valor[2]).val(ui.item.id);
            }
        });
        
        $( "#novoCatalogoPN_" + pos + '_'+numOfRows ).keyup(function() {
            valor = this.id.split("_");
            $('#novoCatalogoIdProduto_' + valor[1] + '_' + valor[2]).val('')
        });
    }
    function deleteRow3(i,pos){
        document.getElementById("tableEscopo_" + pos).deleteRow(i);
    }

    function cadastrarsolicitante(){
        var solicitante = document.querySelector("#nome").value;
        var cliente = document.querySelector("#idClientes").value;
        var email = document.querySelector("#email_solici").value;

        var clienteSelecionado = document.querySelector("#clientes_id").value;
        if(solicitante == null || solicitante == "" || cliente == null || cliente == "" || email == null || email == ""){
            alert("O preenchimento de todos os campos são obrigatórios.");
            return;
        }
        var sEmail	= email;
		// filtros
		var emailFilter=/^.+@.+\..{2,}$/;
		var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
		// condição
		if(!(emailFilter.test(sEmail))||sEmail.match(illegalChars)){			
			alert('Por favor, informe um email válido.');
            return;
		}
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/clientes/cadastrarSolicitante2",
            type: 'POST',
            dataType: 'json',
            data: {
                solicitante: solicitante,
                cliente: cliente,
                email: email
            },
            success: function(data) {
                alert(data.msg);
                if(data.result){
                    if(clienteSelecionado != null && clienteSelecionado!= ""){
                        getValor(clienteSelecionado,data.id);
                    }                    
                    $('#modalCadastrar').modal('hide');			
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
    }
    function cadastrarCliente() {
        var nomeFornecedor = document.querySelector('#nomeFornecedor').value;
        var ie = document.querySelector('#ie').value;
        var documento = document.querySelector('#documento').value;
        var telefone = document.querySelector('#telefone').value;
        var celular = document.querySelector('#celular').value;
        var email = document.querySelector('#email').value;
        var estado = document.querySelector('#estado').value;
        var cep = document.querySelector('#cep').value;
        var cidade = document.querySelector('#cidade').value;
        var bairro = document.querySelector('#bairro').value;
        var rua = document.querySelector('#rua').value;
        var numero = document.querySelector('#numero').value;
        
        if(documento == "" || documento == null || 
        nomeFornecedor == "" || nomeFornecedor == null || 
        cep == "" || cep == null || 
        estado == "" || estado == null || 
        cidade == "" || cidade == null || 
        bairro == "" || bairro == null || 
        rua == "" || rua == null || 
        numero == "" || numero == null || 
        telefone == "" || telefone == null || 
        email == "" || email == null || !validarCNPJ(documento)){
            alert("Os campos com asterisco são obrigatórios.");
            return;
        }
        var sEmail	= email;
		// filtros
		var emailFilter=/^.+@.+\..{2,}$/;
		var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
		// condição
		if(!(emailFilter.test(sEmail))||sEmail.match(illegalChars)){
			
			alert('Por favor, informe um email válido.');
            return;
		}
        if(telefone.length != 15 && telefone.length != 14){
            alert('Por favor, informe um telefone válido.');
            return;
        }


        $.ajax({
            url: "<?php echo base_url(); ?>index.php/clientes/cadastrarCliente",
            type: 'POST',
            dataType: 'json',
            data: {
                nomeCliente: nomeFornecedor,
                ie: ie,
                documento: documento,
                telefone: telefone,
                celular: celular,
                email:email,
                estado:estado,
                cep:cep,
                cidade:cidade,
                bairro:bairro,
                rua:rua,
                numero:numero
            },
            success: function(data) {
                alert(data.msg);
                if(data.result){
                    document.querySelector("#cliente").value = nomeFornecedor.toUpperCase();
                    document.querySelector("#clientes_id").value = data.id
                    $('#modalCadastrarCliente').modal('hide');	
                    var o = new Option( nomeFornecedor.toUpperCase()+" | CNPJ: "+documento, data.id);
                    /// jquerify the DOM object 'o' so we can use the html method
                    $(o).html(nomeFornecedor.toUpperCase());
                    $("#idClientes").append(o);
                    $("#idClientes option[value = '"+data.id+"']").attr("selected","selected");
                    $('#modalCadastrar').modal('show');	
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

    }
    function cadastrarProduto(){
        var pn = document.querySelector('#pn').value;
        var descricao = document.querySelector('#descricao').value;
        var referencia = document.querySelector('#referencia').value;
        var fornecedor_original = document.querySelector('#fornecedor_original').value;
        var equipamento = document.querySelector('#equipamento').value;
        var subconjunto = document.querySelector('#subconjunto').value;
        var modelo = document.querySelector('#modelo').value;
        if(pn == null || pn == "" || descricao == null || descricao == ""){
            alert("Os campos PN e descrição são obrigatórios");
            return;
        }
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/produtos/cadastrarProduto",
            type: 'POST',
            dataType: 'json',
            data: {
                pn: pn,
                descricao: descricao,
                referencia: referencia,
                fornecedor_original: fornecedor_original,
                equipamento: equipamento,
                subconjunto: subconjunto,
                modelo: modelo
            },
            success: function(data) {
                alert(data.msg);
                if(data.result){                                       
                    $('#modalCadastrarPN').modal('hide');			
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
    }
    function validarCNPJ(cnpj) {
 
        cnpj = cnpj.replace(/[^\d]+/g,'');

        if(cnpj == '') return false;
        
        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" || 
            cnpj == "11111111111111" || 
            cnpj == "22222222222222" || 
            cnpj == "33333333333333" || 
            cnpj == "44444444444444" || 
            cnpj == "55555555555555" || 
            cnpj == "66666666666666" || 
            cnpj == "77777777777777" || 
            cnpj == "88888888888888" || 
            cnpj == "99999999999999")
            return false;
            
        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
            
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
                
        return true;

    }

    function calcularTotalUnit(contador){
        valor_icms = document.querySelector("#custoIcms_"+contador).value.replace('.','');
        valor_icms = valor_icms.replace(',','.');
        valor_frete = document.querySelector("#custoFrete_"+contador).value.replace('.','');
        valor_frete = valor_frete.replace(',','.');
        valor_ins = document.querySelector("#custoIns_"+contador).value.replace('.','');
        valor_ins = valor_ins.replace(',','.');
        valor_fab = document.querySelector("#custoFab_"+contador).value.replace('.','');
        valor_fab = valor_fab.replace(',','.');
        total = parseFloat(valor_icms) + parseFloat(valor_frete) + parseFloat(valor_ins) + parseFloat(valor_fab);
        document.querySelector("#custoTotal_"+contador).value = retorna_formatado(total);
        document.querySelector("#val_unit_"+contador).value = retorna_formatado(total);
        calculaSubTotal(contador);

    }

    function verificarCEP(){
        //Nova variável "cep" somente com dígitos.
        var cep = $('#cep').val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#estado").val("...");
               

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                        return true;
                       
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        return false;
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                return false;
            }
        } //end if.
        else {
            
            return false;
            
        }
    }

    const handlePhone = (event) => {
        let input = event.target
        input.value = phoneMask(input.value)
    }

    const phoneMask = (value) => {
        if (!value) return ""
        value = value.replace(/\D/g,'')
        value = value.replace(/(\d{2})(\d)/,"($1) $2")
        value = value.replace(/(\d)(\d{4})$/,"$1-$2")
        return value
    }
    $(document).ready(function(){
        $("#cep").mask("99.999-999");
    });
    $(function(){
        $(".number").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
            }
        });
    });
</script>


<script type="text/javascript" >

$(document).ready(function() {
    $('.data').inputmask("date",{
        inputFormat: "dd/mm/yyyy"
    });
 
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#estado").val("");        
    }
    
    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#estado").val("...");
               

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                       
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});

</script> 


<script>
$(document).ready(function() {
    $('#idVendedor').change(function() {
        var idVendedor = $(this).val();
        console.log("ID Vendedor selecionado: ", idVendedor);

        $('#idVendedorAuxiliar').html('<option value="">Carregando...</option>');

        $.ajax({                     
            url: "<?php echo base_url('index.php/orcamentos/carregarVendedoresAuxiliares'); ?>",
            type: "POST",
            data: { idVendedor: idVendedor },
            dataType: "json",
            success: function(data) {
                console.log("Dados Recebidos: ", data);
                var options = '<option value="">Selecione um vendedor auxiliar</option>';
					$.each(data, function(index, item) {
						options += '<option value="' + item.idVendedorAuxiliar + '">' + item.nomeVendedorAuxiliar + '</option>';
					});
                $('#idVendedorAuxiliar').html(options);
            },
            error: function(xhr, status, error) {
                console.error("Erro ao carregar vendedores auxiliares:", error);
            }
        });
    });

    // Verifica se o valor do campo idVendedorAuxiliar está sendo enviado corretamente ao backend
    $('form').submit(function(e) {
        e.preventDefault();
        console.log("Valor de idVendedorAuxiliar: ", $('#idVendedorAuxiliar').val());
        this.submit();
    });
});
</script>

<script>
function atualizarRegiao() {
    var idVendedor = document.getElementById('idVendedor').value;
    var regiao = '';

    if (idVendedor == 1) {
        regiao = 'Sudeste';
    } else if (idVendedor == 5) {
        regiao = 'Nordeste';
    } else if (idVendedor == 8) {
        regiao = 'Norte';
    }

    document.getElementById('regiao').value = regiao;
}
</script>

<script>
$(document).ready(function () {
    // Alterar todos os itens de Unidade Execução
    $("#unex_todos").change(function () {
        var selectedValue = $(this).val();
        $(".unex-item").each(function () {
            $(this).val(selectedValue);
        });
    });

    // Alterar todos os itens de Tipo O.S.
    $("#tipoos_todos").change(function () {
        var selectedValue = $(this).val();
        $(".tipoos-item").each(function () {
            $(this).val(selectedValue);
        });
    });
	
    // Alterar todos os itens de Orçamento
    $("#orc_todos").change(function () {
        var selectedValue = $(this).val();
        $(".orcamento-item").each(function () {
            $(this).val(selectedValue).trigger('change');
        });
    });

    // Alterar todos os itens de Tipo de Produto
    $("#tipo_prod_todos").change(function () {
        var selectedValue = $(this).val();
        $(".tipoprod-item").each(function () {
            $(this).val(selectedValue).trigger('change');
        });
    });	
});

</script>  