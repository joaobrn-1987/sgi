<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/moment.js"></script>
<script src="<?php echo base_url()?>js/jquery.inputmask.bundle.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/fontawesome.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integridade="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S + oqd12jhcu + A56Ebc1zFSJ" crossorigin="anônimo">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
    table.comBordas {
        border: 0px solid White;
        color: ffffff;
    }

    table.comBordas td {
        border: 1px solid grey;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;

    }

    table.comBordastitu td {

        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
    }
    .ocultar{
        display: none !important;
    }
    .mostrar{
        display: block !important;
    }
</style>
<?php
if (!$results) {
?>


    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>OS</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>

                        <th>Nº OS</th>
                        <th>Nº Orc.</th>
                        <th>Cliente</th>
                        <th>Descrição</th>
                        <th>PN</th>
                        <th>Data OS</th>
                        <th>Data entrega</th>
                        <th>Data reagendada</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhuma OS Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php
} else {
    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {

    ?>
        <div><!--
            <a href="#modal-reagendar" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuir="" class="btn btn-danger tip-top" title="Reagendar"><i class="icon icon-calendar"></i> Reagendar, várias OS</a>


            <a href="#modal-dataentrega" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuir="" class="btn btn-warning tip-top" title="Data Entrega"><i class="icon icon-calendar"></i> DATA ENTREGA, alterar várias OS</a>


            <a href="#modal-status" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuir="" class="btn btn-info tip-top" title="STATUS"><i class="icon icon-calendar"></i> STATUS, alterar várias OS</a>

            
            <a href="#modal-pedido" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuir="" class="btn btn-success tip-top" title="PEDIDO"><i class="icon icon-calendar"></i> Nº PEDIDO E ANEXO PEDIDO, alterar várias OS</a>-->

            <a href="#modal-alterarOS" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuir="" class="btn btn-success tip-top" title="PEDIDO"><i class="icon icon-calendar"></i> Alterar O.S.</a>
            <?php
            
            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
                echo '<a href="#modal-histvale" style="margin-right: 1%" role="button" data-toggle="modal" idDistribuir="" class="btn btn-warning tip-top" title="PEDIDO"><i class="icon "></i> Vale</a>';
            }
            
            ?>
            
        </div>

    <?php
    }
    ?>
    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Buscar OS</h5>
                </div>
                <div class="widget-content nopadding">


                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <ul class="nav nav-tabs">
                            <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Filtro OS</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">

                                <div class="span12" id="divCadastrarOs">

                                    <form class="form-inline" action="<?php echo base_url() ?>index.php/os" method="post" name="form8" id="form8">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">


                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span2" class="control-group">

                                                Cod. OS.:
                                                <input type="text" name="idOs" value="" autofocus class='span12'>

                                            </div>
                                            <div class="span1" class="control-group">

                                                Cod. Orc.:
                                                <input type="text" name="idOrcamentos" value="" class='span12'>

                                            </div>
                                            <div class="span1" class="control-group">

                                                NF Cliente:
                                                <input id="numero_nf" type="text" name="numero_nf" value="" class='span12' />
                                            </div>
                                            <div class="span1" class="control-group">
                                                NF Serviço
                                                <input id="numero_nfserv" type="text" name="numero_nfserv" value="" class='span12' />
                                            </div>
                                            <div class="span1" class="control-group">

                                                NF Dev|Fab:
                                                <input id="numero_nffab" type="text" name="numero_nffab" value="" class='span12' />
                                            </div>
                                            <div class="span2" class="control-group">


                                                Nº Pedido: <input id="numpedido_os" class="span12" type="text" name="numpedido_os" value="" />
                                            </div>
                                            <div class="span2" class="control-group">

                                                Tag:<input id="tag" class="span12" type="text" name="tag" value="" />
                                            </div>
                                            <div class="span2" class="control-group">

                                                <input type="hidden" id="idProdutos" name="idProdutos" value="" />
                                                PN:
                                                <input class="span12" type="text" id="pn" name="pn" ref="autocomplete" value="" />


                                            </div>

                                        </div>

                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span6" class="control-group">

                                                Cliente:
                                                <input class="span12" id="cliente" type="text" name="cliente" value="" />
                                                <input id="clientes_id" type="hidden" name="clientes_id" value="" />
                                            </div>

                                            <div class="span6" class="control-group">

                                                Descrição
                                                <input id="descricao_item" class="span12" type="text" name="descricao_item" value="" />

                                            </div>

                                        </div>



                                        <!--      
                                            
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span2" class="control-group">                                         
                                            <label for="idGrupoServico" class="control-label">Unidade Exec.
                                                </label>
                                            <select class="recebe-solici" class="controls" style="font-size: 10px; width:62%"
                                                     name="unidade_execucao" id="unidade_execucao">  
                                                        <option value="">
                                                            TODOS
                                                        </option>  
                                                        <option value="2">
                                                            FABRICAÇÃO
                                                        </option>   
                                                        <option value="1">
                                                            SERVIÇOS
                                                        </option>                                              
                                                    
                                                    </select>
                                            </div>

                                            <div class="span2" class="control-group">
                                                <br>
                        
                                                <input class="btn btn-default" type="submit" name="filter" value="Filtrar">
                                            </div>
                                                    
                                        </div>-->

                                        <div class="span12" style="padding: 1%; margin-left: 0">




                                            <div class="span412" class="control-group">


                                                <label for="idGrupoServico" class="control-label">Status OS:</label>&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll2();">&nbsp;Marcar/Desmarcar todos
                                                <br>
                                                <table width='100%'>
                                                    <tr>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($status_os as $e) {



                                                            ?>
                                                            <td>
                                                                <input type="checkbox" name="idStatusOs[]" class='check' value="<?php echo $e->idStatusOs; ?>" <?php if ($e->carteirapadrao == 1) {
                                                                                                                                                                    echo "checked";
                                                                                                                                                                }   ?>> &nbsp;<?php echo $e->nomeStatusOs; ?>
                                                            </td>
                                                            <?php
                                                            if (($i + 1) % 5 == 0)
                                                                echo "</tr>";

                                                            $i++;
                                                        }


                                                        ?>


                                                </table>

                                            </div>
                                        </div>
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span3" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Unid. Execuçao:</label>


                                                <?php foreach ($unid_exec as $exec) { ?>
                                                    <input type="checkbox" name="unid_execucao[]" class='check' value="<?php echo $exec->id_unid_exec; ?>"> &nbsp;<?php echo $exec->status_execucao; ?>

                                                <?php } ?>


                                            </div>
                                            <div class="span4" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Unid. Faturamento:</label>


                                                <?php foreach ($unid_fat as $fat) { ?>
                                                    <input type="checkbox" name="unid_faturamento[]" class='check' value="<?php echo $fat->id_unid_fat; ?>"> &nbsp;<?php echo $fat->status_faturamento; ?>


                                                <?php } ?>

                                                </select>

                                            </div>
                                            <div class="span3" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Tipo:</label>
                                                <?php foreach ($tipo_os as $ostipo) { ?>
                                                    <input type="checkbox" name="id_tipo[]" class='check' value="<?php echo $ostipo->id_tipo; ?>"> &nbsp;<?php echo $ostipo->nome_tipo; ?>


                                                <?php } ?>



                                            </div>
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Desenho: </label>



                                                <input type="checkbox" name="desenho[]" class='check' value="3"> &nbsp;<i class="icon-ok" style="color:green"></i>
                                                <input type="checkbox" name="desenho[]" class='check' value="2"> &nbsp;<i class="fas fa-exclamation-triangle" style="color:orange"></i>
                                                <input type="checkbox" name="desenho[]" class='check' value="1"> &nbsp;<i class="icon-ban-circle" style="color:grey"></i>





                                            </div>


                                        </div>

                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVerificacaocontroleOS')) {?>
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Verif. Cont.: </label>
                                                </br>
                                                <?php foreach($verificacao_controle as $r){?>
                                                    <input type="checkbox" name="verificacaoControle[]" class='check' value="<?php echo $r->idVerificacaoControle;?>"> &nbsp;<?php echo $r->descricaoControle;?>
                                                    </br>
                                                    <?php 
                                                }?>
                                                
                                            </div>
                                            <?php }?><!--
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Status escopo: </label>
                                                <select class="span12" name="selectStatusPeritagem">
                                                    <option value=""></option>
                                                    <?php 
                                                        foreach(($status_escopo ?? []) as $r){
                                                            echo "<option value='".$r->idStatusEscopo."'>".$r->descricaoEscopo."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>-->
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Status Peritagem: </label>
                                                <select class="span12" name="selectStatusPeritagem">
                                                    <option value=""></option>
                                                    <?php 
                                                        foreach($status_peritagem as $r){
                                                            echo "<option value='".$r->idStatusPeritagem."'>".$r->descricaoPeritagem."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="spanAjust" class="control-group">
                                                <br>

                                                <input class="btn btn-default" type="submit" name="filter" value="Filtrar">
                                            </div><!--
                                            <div class="spanAjust">
                                                <br>
                                                <a class="btn btn-success" type="button" onclick="exibirAntigas()">Orçamentos Vencidos</a>
                                            </div>
                                            <div class="spanAjust antigas ocultar">
                                                <label class="control-label" style="display: block;">Data:</label>
                                                <input type="text" class="span3 data" placeholder="Inicial" style="width: 100px;"  id="data_inicio_gb" name="data_inicio_gb" value="01/01/2020"/>
                                                <input type="text" class="span3 data" placeholder="Final" style="width: 100px;" id="data_fim_gb" name="data_fim_gb" value="31/05/2023"/>
                                                <input type="hidden" id="data_inicio" name="data_inicio" value=""/>
                                                <input type="hidden"  id="data_fim" name="data_fim" value=""/>
                                            </div>
                                            <div class="spanAjust antigas ocultar">
                                                <br>
                                                <a class="btn btn-success" type="button" onclick="filtrar()">OK</a>
                                            </div>-->
                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>





    
    <div class="row-fluid" style="margin-top:0">
        <div class="span12" id="scrollIdtest" style="width: 100%; overflow-y: scroll;" onmousemove="scrollDetect(this,event)">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>OS</h5>
                    <h5>Legenda:</h5>
                    <div style="padding:8px">
                        Completo <a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>|
                        Incompleto <a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>|
                        Sem desenho <a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a>
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="span12" id="divCadastrarOs">                                
                            <div class="widget-box" style="margin-top:0px">                                        
                                <table id="tableOs" class="table table-bordered ">
                                    <thead>
                                        <tr>

                                            <th>Nº OS</th>
                                            <th>Nº Orc.</th>
                                            <th>Cliente</th>
                                            <th>QTD</th>
                                            <th>Descrição</th>
                                            <th>Nº Pedido<br>Tag</th>

                                            <?php
                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                                            ?>

                                                <th>Valor</th>

                                            <?php
                                            }
                                            ?>
                                            <th>NF Cliente</th>
                                            <th>NF Dev|Fab</th>
                                            <th>NF Serviço</th>
                                            <th>Canhoto</th>
                                            <th>Status</th>
                                            <th>Status</br>Escopo</th>
                                            <th>PN</th>
                                            <th>Data Criação</th>
                                            <th>Data OS</th>
                                            <th>Data entrega</th>
                                            <th>Data reagendada</th>
                                            <th>Unid. Exec.</th>
                                            <th>Unid. Fat.</th>
                                            <th>Tipo</th>
                                            <th>Desenho</th>
                                            <?php
                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVerificacaocontroleOS')) {
                                            ?>
                                                <th>Verif. Contr.</th>
                                            <?php
                                            }
                                            ?>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $valor = 0;

                                        foreach ($results as $r) {
                                            $color = '';
                                            if ($r->data_entrega <> '') {
                                                $data_entrega = date("d/m/Y", strtotime($r->data_entrega));
                                            } else {
                                                $data_entrega = "";
                                            }

if ($r->data_reagendada <> '') {
    // Se a data for '0000-00-00', tratamos como zerada para exibir 00/00/0000
    if ($r->data_reagendada == '0000-00-00') {
        $data_reagendada = "00/00/0000";
    } else {
        $data_reagendada = date("d/m/Y", strtotime($r->data_reagendada));
    }
} else {
    $data_reagendada = ""; 
}

                                            if ($r->data_abertura <> '') {
                                                $data_abertura = date("d/m/Y", strtotime($r->data_abertura));
                                            } else {
                                                $data_abertura = "";
                                            }
                                            if($r->data_insert <> ''){
                                                $data_insert = date("d/m/Y", strtotime($r->data_insert));
                                            }else if($r->data_abertura_real <> ''){
                                                $data_insert = date("d/m/Y", strtotime($r->data_abertura_real));
                                            }else{
                                                $data_insert = "";
                                            }


                                            echo '<tr>';

                                            echo '<td><font size="1,8">' . $r->idOs . '</font></td>';
                                            echo '<td><font size="1">' . $r->idOrcamentos . '</font></td>';
                                            echo '<td><font size="1">' . $r->nomeCliente . '</font></td>';
                                            echo '<td><font size="1">' . $r->qtd_os .' '.$r->descricaoTipoQtd. '</font></td>';
                                            echo '<td width="60%">' . $r->descricao_item . '</font></td>';
                                            echo '<td><font size="1">' . $r->numpedido_os . '</font><br><font size="1" color="red"> ' . $r->tag . '</font></td>';
                                            $calc = (float)$r->qtd_os * (float)$r->val_unit_os - (float)$r->desconto_os;
                                            $ipicalc = ((float)$r->val_ipi_os) / 100 * $calc;
                                            $result = $calc + $ipicalc;
                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {

                                                echo '<td><font size="1">' . number_format($result, 2, ",", ".") . '</td>';
                                            }

                                            echo '<td><font size="1">' .$r->nf_cliente. '</font></td>';
                                            echo '<td><font size="1">' . $r->nf_venda_dev . '</font></td>';
                                            echo '<td><font size="1">' . $r->numero_nf . '</font></td>';
                                            echo '<td><font size="1">' . $r->nf_canhoto . '</font></td>';
                                            echo '<td><font size="1">' . $r->nomeStatusOs . '</font></td>';
                                            echo '<td><font size="1">' . $r->descricaoPeritagem . '</font></td>';
                                            echo '<td style="word-wrap:break-word; max-width:70px;"><font size="1">' . $r->pn . '</font></td>';
                                            echo '<td><font size="1">' . $data_insert . '</font></td>';
                                            echo '<td><font size="1">' . $data_abertura . '</font></td>';
                                            echo '<td><font size="1">' . $data_entrega . '</font></td>';
    // Se for 00/00/0000, pintamos de vermelho para destacar conforme você pediu
    $styleReag = ($data_reagendada == "00/00/0000") ? 'style="color:red"' : '';
    echo '<td><font size="1" '.$styleReag.'>' . $data_reagendada . '</font></td>';

                                            echo '<td><font size="1">' . $r->status_execucao . '</font></td>';
                                            echo '<td><font size="1">' . $r->status_faturamento . '</font></td>';
                                            echo '<td><font size="1">' . $r->nome_tipo . '</font></td>';
                                            if ($r->statusDesenho == 3) {
                                                echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a></div></font></td>';
                                            } else if ($r->statusDesenho == 2) {
                                                echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a></div></font></td>';
                                            } else {
                                                echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a></div></font></td>';
                                            }
                                            
                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVerificacaocontroleOS')) {
                                        
                                                echo '<td>'.$r->descricaoControle.'</td>';
                                            
                                            }
                                            

                                            echo '<td><font size="1">';
                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                                                echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
                                            }
                                            echo '</font></td>';
                                        ?>


                                        <?php

                                            
                                            echo '<td><font size="1">';
                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {/*
                                                echo '<a href="' . base_url() . 'index.php/os/distribuiros/' . $r->idOs . '" style="margin-right: 1%" class="btn btn-info tip-top" ><i class="icon-shopping-cart"></i></a>';
                                            */}
                                            echo '</font></td>';
                                            echo '<td><font size="1">';
                                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eHoramaquinas')) {/*
                                                echo '<a href="' . base_url() . 'index.php/os/maquinas/' . $r->idOs . '" style="margin-right: 1%" class="btn btn-success tip-top" ><i class="fa fa-clock-o"></i></a>';
                                            */}
                                            echo '</font></td>';
                                            echo '</tr>';
                                            $valor = (float)$valor + (float)$result;
                                        }
                                        ?><!--
                                        <tr>
                                            <td colspan='7' align='right'>
                                                
                                            </td>
                                        </tr>     -->                                                                              
                                    </tbody>
                                </table>
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div> 
    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) { ?>
        <p><?php echo "Somatória: " . number_format($valor, 2, ",", "."); ?></p>
                <?php }?>
    
    
    
    

    <?php
    echo $this->pagination->create_links();
}
?>



<div id="modal-reagendar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/os/reagendar" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Reagendar várias OS</h5>
        </div>
        <div class="modal-body">
            Nova data: <input id="novadata" class="data" type="text" name="novadata" value="" />
        </div>
        <div class="modal-body">Digitar as OS separando por virgula: EX.: 111,222,333<br>
            <input type="text" id="varias_os" name="varias_os" value="" class="span12" />


            <h5 style="text-align: center">Deseja realmente alterar data dessas OS?</h5>
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">
                <FONT color='red'> *ATENÇÃO AO DIGITAR AS OS, PARA NÃO ALTERAR OUTRAS.</font>
            </h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Alterar</button>
        </div>
    </form>
</div>


<div id="modal-dataentrega" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/os/dataentrega" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Alterar DATA ENTREGA DE várias OS</h5>
        </div>
        <div class="modal-body">
            Nova data: <input id="novadata" class="data" type="text" name="novadata" value="" />
        </div>

        <div class="modal-body">Digitar as OS separando por virgula: EX.: 111,222,333<br>
            <input type="text" id="varias_os" name="varias_os" value="" class="span12" />


            <h5 style="text-align: center">Deseja realmente alterar data dessas OS?</h5>
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">
                <FONT color='red'> *ATENÇÃO AO DIGITAR AS OS, PARA NÃO ALTERAR OUTRAS.</font>
            </h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Alterar</button>
        </div>
    </form>
</div>

<div id="modal-status" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/os/status" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Alterar STATUS DE várias OS</h5>
        </div>
        <div class="modal-body">
            Status:<select name="idStatusOs">

                <?php foreach ($status_os as $gs) { ?>

                    <option value="<?php echo $gs->idStatusOs; ?>"><?php echo $gs->nomeStatusOs; ?></option>
                <?php } ?>

            </select>
        </div>

        <div class="modal-body">Digitar as OS separando por virgula: EX.: 111,222,333<br>
            <input type="text" id="varias_os" name="varias_os" value="" class="span12" />


            <h5 style="text-align: center">Deseja realmente alterar data dessas OS?</h5>
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">
                <FONT color='red'> *ATENÇÃO AO DIGITAR AS OS, PARA NÃO ALTERAR OUTRAS.</font>
            </h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Alterar</button>
        </div>
    </form>
</div>


<div id="modal-pedido" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Cadastrar Desenho OS: </h5>
    </div>
    <div class="modal-body">
        <form action="<?php echo base_url(); ?>index.php/os/pedido" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="control-group">
                <label for="obs_controle" class="control-label">Nº Pedido</label>
                <div class="controls">
                    <input id="pedido" type="text" name="pedido" value="" />



                </div>
                <label for="obs_controle" class="control-label">Nome arquivo</label>
                <div class="controls">
                    <input id="nomeArquivo" type="text" name="nomeArquivo" value="" />



                </div>

                <label for="arquivo" class="control-label"><span class="required">Arquivo</span></label>
                <div class="controls"><!--
                    <input id="arquivo" type="file" name="userfile" />-->
                </div>


            </div>
            <div class="modal-body">Digitar as OS separando por virgula: EX.: 111,222,333<br>
                <input type="text" id="varias_os" name="varias_os" value="" class="span12" />


                <h5 style="text-align: center">Deseja realmente alterar pedido e inserir arquivo?</h5>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
                <button class="btn btn-primary">Cadastrar</button>
            </div>
        </form>
    </div>


</div>

<div id="modal-alterarOS" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow: auto;height: 600px;">
    <form id = 'formConjunto' action="<?php echo base_url() ?>index.php/os/alterarconjuntoos"  enctype="multipart/form-data" method="post" class="form-horizontal">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-body">
                <h5 style="text-align: center">
                    <FONT color='red'>SELECIONE APENAS OS CAMPOS QUE DESEJA ALTERAR.</font>
                </h5>
        </div>
        <div style="margin: 15px;">
            <div class="span12">
                <div class="span6">
                    <input type="checkbox" name="alterarOS[]" id="editarDataOS" class='check' value="editarDataOS"> &nbsp;Alterar Data O.S.            
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px"><!--
                        Nova data: <input disabled type="text" id="reagendarOs" name="reagendarOs" value="" class="span4" class="data"/>-->
                        Nova data: <input class="data" type="text" id="dataOs" name="dataOs" value="" disabled>
                    </div>
                </div>            
                <div class="span6">
                    <input type="checkbox" name="alterarOS[]" id="editarReagendarOS" class='check' value="editarReagendarOS"> &nbsp;Alterar Reagendar O.S.            
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px"><!--
                        Nova data: <input disabled type="text" id="reagendarOs" name="reagendarOs" value="" class="span4" class="data"/>-->
                        Nova data: <input class="data" type="text" id="reagendarOs" name="reagendarOs" value="" disabled>
                    </div>
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span6">
                    <input type="checkbox" name="alterarOS[]" id="editarDataEntregaOS" class='check' value="editarDataEntregaOS"> &nbsp;Alterar Data Entrega O.S.            
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        Nova data: <input disabled type="text" id="dataEntregaOs" name="dataEntregaOs" value=""  class="data"/>
                    </div>
                </div>
                <div class="span6" >
                    <input type="checkbox" name="alterarOS[]" id="editarStatusOS" class='check' value="editarStatusOS"> &nbsp;Alterar Status O.S.            
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        Status: <select name="idStatusOs2" id="idStatusOs2" disabled>

                        <?php foreach ($status_os as $gs) { ?>

                            <option value="<?php echo $gs->idStatusOs; ?>"><?php echo $gs->nomeStatusOs; ?></option>
                        <?php } ?>

                        </select>
                    </div>
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span6">
                    <input type="checkbox" name="alterarOS[]" id="editarDataExpedicaoOS" class='check' value="editarDataExpedicaoOS"> &nbsp;Alterar Data Expedição O.S.            
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        Nova data: <input disabled type="text" id="dataExpedicaoOs" name="dataExpedicaoOs" value=""  class="data"/>
                    </div>
                </div>
                <div class="span6">
                    <input type="checkbox" name="alterarOS[]" id="editarDataCanhotoOS" class='check' value="editarDataCanhotoOS"> &nbsp;Alterar Data Canhoto O.S.            
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        Nova data: <input disabled type="text" id="dataCanhotoOs" name="dataCanhotoOs" value=""  class="data"/>
                    </div>
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span3">
                    <input type="checkbox" name="alterarOS[]" id="editarUnidExecOS" class='check' value="editarUnidExecOS"> &nbsp;Alterar Unid. exec.            
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        Unid. Exec.: <select name="unid_execucao2" id="unid_execucao2" disabled>

                            <?php foreach ($unid_exec as $exec) { ?>

                            <option value="<?php echo $exec->id_unid_exec; ?>" ><?php echo $exec->status_execucao; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="span3">
                    <input type="checkbox" name="alterarOS[]" id="editarUnidFatOS" class='check' value="editarUnidFatOS"> &nbsp;Alterar Unid. fat.            
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        Unid. Fat.: <select name="unid_faturamento2" id="unid_faturamento2" disabled>

                            <?php foreach ($unid_fat as $fat) { ?>

                            <option value="<?php echo $fat->id_unid_fat; ?>" ><?php echo $fat->status_faturamento; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="span3">
                    <input type="checkbox" name="alterarOS[]" id="editarContratoOS" class='check' value="editarContratoOS"> &nbsp;Alterar Contrato            
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        Contrato: <select name="contrato2" id="contrato2" class="form-control" disabled>
                            <option value="Não">Não</option>
                            <option value="Sim">Sim</option>
                            </select>
                    </div>
                </div>
                <div class="span3">
                    <input type="checkbox" name="alterarOS[]" id="editarTipoOS" class='check' value="editarTipoOS"> &nbsp;Alterar Tipo.            
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        Tipo: <select class="form-control" name="id_tipo2" id="id_tipo2" disabled>
                            <!--<option value="" selected='selected'></option>-->
                            <?php foreach ($tipo_os as $ostipo) { ?>

                                <option value="<?php echo $ostipo->id_tipo; ?>"><?php echo $ostipo->nome_tipo; ?></option>
                            <?php } ?>

                            </select>
                    </div>
                </div>
            </div>
            
            
            
            <div class="span12" style="margin-left:0px">
                <div class="span6">
                    <input type="checkbox" name="alterarOS[]" id="editarAnexoPedidoOS" class='check' value="editarAnexoPedidoOS"> &nbsp; Alterar Nº PEDIDO E ANEXO PEDIDO         
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        <label for="obs_controle" class="control-label" style="width: 100px;">Nº Pedido</label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="pedido2" type="text" name="pedido2" value="" disabled/>
                        </div>
                        <label for="obs_controle" class="control-label" style="width: 100px;">Nome arquivo</label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="nomeArquivo2" type="text" name="nomeArquivo2" value="" disabled />
                        </div>

                        <label for="arquivo" class="control-label" style="width: 100px;"><span class="required" >Arquivo</span></label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="arquivo" type="file" name="userfile" disabled/>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <input type="checkbox" name="alterarOS[]" id="editarAnexoNFOS" class='check' value="editarAnexoNFOS"> &nbsp; Alterar NF       
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        <label for="obs_controle" class="control-label" style="width: 100px;">NF</label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="pedido3" type="text" name="pedido3" value="" disabled/>
                        </div>
                        <label for="obs_controle" class="control-label" style="width: 100px;">Nome arquivo</label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="nomeArquivo3" type="text" name="nomeArquivo3" value="" disabled />
                        </div>

                        <label for="arquivo" class="control-label" style="width: 100px;"><span class="required" >Arquivo</span></label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="arquivo2" type="file" name="userfile2" disabled/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span12" style="margin-left:0px">
                <div class="span6">
                    <input type="checkbox" name="alterarOS[]" id="editarAnexoNFClienteOS" class='check' value="editarAnexoNFClienteOS"> &nbsp; Alterar NF Cliente         
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        <label for="obs_controle" class="control-label" style="width: 100px;">NF Cliente</label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="pedido4" type="text" name="pedido4" value="" disabled/>
                        </div>
                        <label for="obs_controle" class="control-label" style="width: 100px;">Nome arquivo</label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="nomeArquivo4" type="text" name="nomeArquivo4" value="" disabled />
                        </div>

                        <label for="arquivo" class="control-label"  style="width: 100px;"><span class="required">Arquivo</span></label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="arquivo3" type="file" name="userfile3" disabled/>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <input type="checkbox" name="alterarOS[]" id="editarNFDevOS" class='check' value="editarNFDevOS"> &nbsp; Alterar NF Dev.|Fabricação      
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        <label for="obs_controle" class="control-label" style="width: 100px;">NF Dev.</label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="pedido5" type="text" name="pedido5" value="" disabled/>
                        </div>
                        <label for="obs_controle" class="control-label" style="width: 100px;">Nome arquivo</label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="nomeArquivo5" type="text" name="nomeArquivo5" value="" disabled />
                        </div>

                        <label for="arquivo" class="control-label" style="width: 100px;"><span class="required" >Arquivo</span></label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="arquivo4" type="file" name="userfile4" disabled/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span12" style="margin-left:0px">
                <div class="span12">
                    <input type="checkbox" name="alterarOS[]" id="editarAnexoCanhotoOS" class='check' value="editarAnexoCanhotoOS"> &nbsp; Alterar Canhoto         
                    <div style="border: 1px #6a6a6a57 solid;margin-top:5px; padding: 10px;margin-bottom:25px">
                        <label for="obs_controle" class="control-label" style="width: 100px;">NF Canhoto</label>
                        <div class="controls" style="margin-left: 130px;" >
                            <input id="pedido6" type="text" name="pedido6" value="" disabled />
                        </div>
                        <label for="obs_controle" class="control-label" style="width: 100px;">Nome arquivo</label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="nomeArquivo6" type="text" name="nomeArquivo6" value="" disabled />
                        </div>

                        <label for="arquivo" class="control-label" style="width: 100px;"><span class="required">Arquivo</span></label>
                        <div class="controls" style="margin-left: 130px;">
                            <input id="arquivo5" type="file" name="userfile5" disabled/>
                        </div>
                    </div>
                </div>          
            </div>
        </div>
        
        

        <div class="modal-body">Digitar as OS separando por virgula: EX.: 111,222,333<br>
            <input type="text" id="varias_os2" name="varias_os" value="" class="span12" />


            <h5 style="text-align: center">Deseja realmente alterar essas OS?</h5>
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">
                <FONT color='red'> *ATENÇÃO AO DIGITAR AS OS, PARA NÃO ALTERAR OUTRAS.</font>
            </h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a onclick = 'confirmacaoAlterar()' class="btn btn-danger">Alterar</a>
        </div>
    </form>
</div>

<div id="modal-confirmacao" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="position:absolute;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Confirmar Alteração </h5>
    </div>
    <div class="modal-body">
        Serão alteradas as seguintes O.S.: <b  id="confirmOS"> </b>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <a onclick = 'confirmarAlteracao()' class="btn btn-danger">Confirmar</a>
    </div>

</div>

<div id="modal-histvale" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="position:absolute;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Histórico de vales </h5>
    </div>
    <div class="modal-body">
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box"><!--
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Escopo Técnico</h5>
                    </div> -->
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">
                                        <div class="widget-box" style="margin-top:0px">
                                            <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                                <thead>
                                                    <tr>
                                                        <th>O.S. Orig.</th>
                                                        <th>O.S. Dest.</th>
                                                        <th>Descrição</th>
                                                        <th>Quantidade</th>
                                                        <th>Data</th> 
                                                        <th>Usuário</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        foreach($hist_vale as $r){
                                                            if(!empty($r->data_insert)){ 
                                                                $date = new DateTime( $r->data_insert);
                                                                //echo $date-> format( 'Y-m-d H:i:s' );
                                                            }
                                                            echo '<tr>';
                                                                echo '<td>'.$r->idOsOrig.'</td>';
                                                                echo '<td>'.$r->idOsDest.'</td>';
                                                                echo '<td>'.$r->descricaoInsumo.'</td>';
                                                                echo '<td>'.$r->quantidade.'</td>';
                                                                $date = new DateTime( $r->data_insert );
                                                                echo '<td><span style="display:none">'.$r->data_insert.'</span>'.$date-> format( 'd/m/Y' ).'</td>';
                                                                echo '<td>'.$r->nome.'</td>';
                                                                echo '<td>';
                                                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
                                                                    echo '<a href="' . base_url() . 'index.php/os/distribuiros/' . $r->idOsOrig . '" style="margin-right: 1%" class="btn btn-info tip-top" ><i class="icon-shopping-cart"></i></a>';
                                                                }
                                                                echo '</td>';
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
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    </div>
</div>

<script type="text/javascript">
    $('.data').inputmask("date",{
        inputFormat: "dd/mm/yyyy",
        placeholder: "DD/MM/AAAA"
    }); 
    function exibirAntigas(){
        $('.antigas').removeClass('ocultar');
        $('.antigas').addClass('mostrar');
    }
    function filtrar(){
        $('#data_inicio').val($('#data_inicio_gb').val());
        $('#data_fim').val($('#data_fim_gb').val());
        $('#form8').submit();
    }
    $("#editarDataOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#dataOs" ).prop( "disabled", false );
        }else{
            $( "#dataOs" ).prop( "disabled", true );
        }
    });
    $("#editarReagendarOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#reagendarOs" ).prop( "disabled", false );
        }else{
            $( "#reagendarOs" ).prop( "disabled", true );
        }
    });
    $("#editarDataEntregaOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#dataEntregaOs" ).prop( "disabled", false );
        }else{
            $( "#dataEntregaOs" ).prop( "disabled", true );
        }
    });
    $("#editarDataExpedicaoOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#dataExpedicaoOs" ).prop( "disabled", false );
        }else{
            $( "#dataExpedicaoOs" ).prop( "disabled", true );
        }
    });
    $("#editarDataCanhotoOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#dataCanhotoOs" ).prop( "disabled", false );
        }else{
            $( "#dataCanhotoOs" ).prop( "disabled", true );
        }
    });
    $("#editarStatusOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#idStatusOs2" ).prop( "disabled", false );
        }else{
            $( "#idStatusOs2" ).prop( "disabled", true );
        }
    });
    $("#editarUnidExecOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#unid_execucao2" ).prop( "disabled", false );
        }else{
            $( "#unid_execucao2" ).prop( "disabled", true );
        }
    });
    $("#editarUnidFatOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#unid_faturamento2" ).prop( "disabled", false );
        }else{
            $( "#unid_faturamento2" ).prop( "disabled", true );
        }
    });
    $("#editarContratoOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#contrato2" ).prop( "disabled", false );
        }else{
            $( "#contrato2" ).prop( "disabled", true );
        }
    });
    $("#editarTipoOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#id_tipo2" ).prop( "disabled", false );
        }else{
            $( "#id_tipo2" ).prop( "disabled", true );
        }
    });
    $("#editarAnexoPedidoOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#nomeArquivo2" ).prop( "disabled", false );
            $( "#pedido2" ).prop( "disabled", false );
            $( "#arquivo" ).prop( "disabled", false );
        }else{
            $( "#nomeArquivo2" ).prop( "disabled", true );
            $( "#pedido2" ).prop( "disabled", true );
            $( "#arquivo" ).prop( "disabled", true );
        }
    });
    $("#editarAnexoNFOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#nomeArquivo3" ).prop( "disabled", false );
            $( "#pedido3" ).prop( "disabled", false );
            $( "#arquivo2" ).prop( "disabled", false );
        }else{
            $( "#nomeArquivo3" ).prop( "disabled", true );
            $( "#pedido3" ).prop( "disabled", true );
            $( "#arquivo2" ).prop( "disabled", true );
        }
    });
    $("#editarAnexoNFClienteOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#nomeArquivo4" ).prop( "disabled", false );
            $( "#pedido4" ).prop( "disabled", false );
            $( "#arquivo3" ).prop( "disabled", false );
        }else{
            $( "#nomeArquivo4" ).prop( "disabled", true );
            $( "#pedido4" ).prop( "disabled", true );
            $( "#arquivo3" ).prop( "disabled", true );
        }
    });
    $("#editarNFDevOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#nomeArquivo5" ).prop( "disabled", false );
            $( "#pedido5" ).prop( "disabled", false );
            $( "#arquivo4" ).prop( "disabled", false );
        }else{
            $( "#nomeArquivo5" ).prop( "disabled", true );
            $( "#pedido5" ).prop( "disabled", true );
            $( "#arquivo4" ).prop( "disabled", true );
        }
    });
    $("#editarAnexoCanhotoOS").click(function(){
        //$('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
        if(this.checked){
            $( "#nomeArquivo6" ).prop( "disabled", false );
            $( "#pedido6" ).prop( "disabled", false );
            $( "#arquivo5" ).prop( "disabled", false );
        }else{
            $( "#nomeArquivo6" ).prop( "disabled", true );
            $( "#pedido6" ).prop( "disabled", true );
            $( "#arquivo5" ).prop( "disabled", true );
        }
    });
    /*
    $(document).ready(function() {

        jQuery(".data").mask("99/99/9999");
    });*/

    $(document).ready(function() {



        $(document).on('click', 'a', function(event) {

            var orc = $(this).attr('orc');
            $('#idorc').val(orc);

        });


        $(document).on('click', 'a', function(event) {

            var orc2 = $(this).attr('orc2');
            $('#idorc2').val(orc2);

        });

    });
    $(document).ready(function() {

        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {

                $("#clientes_id").val(ui.item.id);

                //getValor(ui.item.id);

            }
        });



    });
    console.log('#idProdutos');
    $("#pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
        minLength: 1,
        select: function(event, ui) {
            $('#idProdutos').val(ui.item.id);

        }
    });
    $(document).ready( function () {
        $('#tableOs').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
            "order": [[ 0, "desc" ]],
            "paging": false,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "sProcessing":    "Procesando...",
                "sZeroRecords":   "Sem resultados",
                //"sInfo":          "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) { ?>
                    "sInfo":          "<?php echo "Somatória: " . number_format($valor, 2, ",", "."); ?>",
                <?php }?>
                "sInfoEmpty":     "Mostrando registros de 0 a 0 de um total de 0 registros",
                "sInfoFiltered":  "(filtrado de um total de _MAX_ registros)",
                "sInfoPostFix":   "",
                "sUrl":           "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });
        
    });
</script>
<script>
    ok = false;
    $('#confirmOS').empty();

    function confirmacaoAlterar(){
        var input = document.querySelector('#varias_os2').value;
        $('#confirmOS').empty();
        $('#confirmOS').append(input);
        if(input == null || input == ''){
            alert('Informe as O.S. que deseja alterar.')
        }else{
            $('#modal-confirmacao').modal('show');
        }
    }
    function confirmarAlteracao(){
        $( "#formConjunto" ).submit();
    }

    function CheckAll2() {
        if (!ok) {
            for (var i = 0; i < document.form8.elements.length; i++) {
                var x = document.form8.elements[i];
                if (x.name == 'idStatusOs[]') {
                    x.checked = true;
                    ok = true;
                }
            }
        } else {
            for (var i = 0; i < document.form8.elements.length; i++) {
                var x = document.form8.elements[i];
                if (x.name == 'idStatusOs[]') {
                    x.checked = false;
                    ok = false;
                }
            }
        }
    }
    function scrollDetect(input,event){
        valor = document.querySelector("#scrollIdtest");
        if($("#scrollIdtest").width() -100 < (event.pageX - $("#scrollIdtest").offset().left) && $("#scrollIdtest").width() > (event.pageX - $("#scrollIdtest").offset().left)){
            $("#scrollIdtest").animate({scrollLeft:valor.scrollWidth},100)
        }
        if(0 < (event.pageX - $("#scrollIdtest").offset().left) && 100 > (event.pageX - $("#scrollIdtest").offset().left)){
            $("#scrollIdtest").animate({scrollLeft:0},100)
        }
			
			
	}
</script>