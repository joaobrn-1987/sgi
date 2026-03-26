<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/moment.js"></script>
<script src="<?php echo base_url()?>js/jquery.inputmask.bundle.js"></script>
<style type="text/css">
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
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
    .slider.round {
        border-radius: 34px;
    }
    .slider.round:before {
        border-radius: 50%;
    }
</style>

<style>
    .modal-dialog.modal-pcp-obs {
        max-width: 100% !important;
        min-width: 320px;
    }
    #modalObsRevisao textarea#obsRevisaoTexto {
        width: 100% !important;
        min-width: 180px;
        max-width: 100%;
        box-sizing: border-box;
        resize: vertical;
    }
</style><style>
/* MODAL: Menor e centralizado */
.modal-pcp-obs {
    max-width: 430px !important; /* Bem mais estreito */
    min-width: 300px;
   
}
@media (max-width: 480px) {
    .modal-pcp-obs { max-width: 98vw !important; min-width: 0; }
}

/* HEADER: Alinha título à esquerda e X à direita */
#modalObsRevisao .modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px 10px 18px;
    border-bottom: 1px solid #e9ecef;
}

#modalObsRevisao .modal-title {
    font-size: 1.12rem;
    font-weight: 600;
}

#modalObsRevisao .close {
    font-size: 1.5rem;
    font-weight: 400;
    color: #666;
    opacity: 1;
    border: none;
    background: transparent;
    outline: none;
    transition: color 0.2s;
    padding: 0 0 0 20px;
}

#modalObsRevisao .close:hover {
    color: #d11a2a;
}

#modalObsRevisao .modal-body {
    padding: 18px 18px 8px 18px;
}

#modalObsRevisao textarea#obsRevisaoTexto {
    width: 100%;
    min-width: 160px;
    max-width: 100%;
    resize: vertical;
    font-size: 1rem;
    margin-bottom: 2px;
    box-sizing: border-box;
}

#modalObsRevisao .modal-footer {
    padding: 8px 18px 16px 18px;
    border-top: 1px solid #e9ecef;
}

#modalObsRevisao .btn {
    min-width: 70px;
}
</style>


<?php
echo "<br>";
echo "<br>";	
?>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Buscar Pedido de compra</h5>
            </div>
            <div class="widget-content nopadding">


                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Filtro OS</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">

                                <form class="form-inline" action="<?php echo base_url() ?>index.php/suprimentos"
                                    method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">



                                    <div class="span12" style="padding: 1%; margin-left: 0">

                                        <div class="span2" class="control-group">
                                            <label for="idPedidoCompra" class="control-label">Ordem de Compra</label>
                                            <input class="form-control span12" type="text" name="idPedidoCompra" value="<?=set_value('idPedidoCompra', null)?>"
                                            autofocus >

                                        </div>

                                        <div class="span2" class="control-group">
                                            <label for="nf_fornecedor" class="control-label">N° NFe</label><br>
                                            <input class="form-control span12" type="text" name="nf_fornecedor" value="<?=set_value('nf_fornecedor', null)?>">

                                        </div>

                                        <div class="span2" class="control-group">
                                            <label for="nf_fornecedor" class="control-label">Data Material Entregue</label><br>
                                            <input  class="data form-control span5" type="text" name="data_entrega_inicio" value=""> a 
                                            <input  class="data form-control span5" type="text" name="data_entrega_fim" value="">
                                        </div>

                                        <div class="span2" class="control-group">
                                                <label for="idOs" class="control-label">N° OS</label><br>
                                                <input class="form-control span12" type="text" name="idOs" value="<?=set_value('idOs', null)?>">

                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="" class="control-label">Unid. Exec.</label>
                                            </br>
                                            <?php foreach ($unid_exec as $exec) { ?>
                                                <input type="checkbox" name="unid_execucao[]" class='check' value="<?php echo $exec->id_unid_exec; ?>"> &nbsp;<?php echo $exec->status_execucao; ?>
                                            <?php } ?>
                                        </div>

                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Status Ordem
                                                Compra</label>
                                            <!--&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll22();">&nbsp;Marcar/Desmarcar todos-->
                                            <br>
                                           
                                                    <select class="recebe-solici span12" class="controls" style="font-size: 10px;" name="idStatuscompras" id="idStatuscompras">  
                                                        <option value="todos">
                                                            TODOS
                                                        </option>                                                  
                                                    <?php 
                                                    $i = 0;                                                    
                                                    foreach ($dados_statuscompra as $so)                                                     
                                                    {
                                                        
                                                        ?>
                                                        
                                                            <option value="<?php echo $so->idStatuscompras; ?>" <?=($dadosFiltros['idStatuscompras'] == $so->idStatuscompras)?'selected':''?>>
                                                                <?php echo $so->nomeStatus; ?>
                                                            </option>
                                                            <!--
                                                            <input type="checkbox" name="idStatuscompras[]" class='check'
                                                                value="<?php //echo $so->idStatuscompras; ?>">
                                                            &nbsp;<?php //echo $so->nomeStatus; ?>
                                                            -->                                                                
                                                        
                                                        <?php 
                                                        //if ( ($i+1) % 4 == 0) echo "</tr>";
                                                        
                                                        $i++;
                                                    }									 
										 
										            ?>
                                                    </select>                                          

                                        </div>

                                        
                                    </div>


                                    <div class="span12" style="padding: 1%; margin-left: 0">

                                        <div class="span1" class="control-group">
                                            <label for="numPedido" class="control-label">N° Cotação</label><br>
                                            <input class="form-control span12" type="text" name="numPedido" value="<?=set_value('numPedido', null)?>">

                                        </div>


                                        <div class="span2" class="control-group">
                                            <label for="fornecedor" class="control-label">Fornecedor</label>
                                            <input  class="form-control span12" id="fornecedor" type="text"
                                            name="fornecedor" value="<?=set_value('fornecedor', null)?>" />
                                            <input id="fornecedor_id" type="hidden" name="fornecedor_id" value="<?=set_value('fornecedor_id', null)?>" />
                                        </div>

                                        <div class="span2" class="control-group">
                                            <label for="descricao" class="control-label">Descrição</label><br>
                                            <input class="form-control span12" type="text" name="descricao" value="<?=set_value('descricao', null)?>" >

                                        </div>

                                        <div class="span2" class="control-group">
                                            <label for="x8" class="control-label">Empresa</label><br>
                                            <input  class="form-control span5" id="empresaNum1" type="text"
                                            name="empresaNum1" value="<?=set_value('empresaNum1', 1)?>" /> a 
                                            <input id="empresaNum2" class="form-control span5" type="text" name="empresaNum2" value="<?=set_value('empresaNum2', 5)?>" />
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="descricao" class="control-label">Grupo Compra</label><br>
                                            <!--<input class="form-control span12" type="text" name="descricao" value="<?=set_value('descricao', null)?>" > --> 
                                            <select name="idgrupo" class="span12">
                                                <option value = ""> TODOS</option>
                                                <?php foreach ($dados_statusgrupo as $so) { ?>

                                                <option value="<?php echo $so->idgrupo; ?>" ><?php echo $so->nomegrupo; ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="descricao" class="control-label">Usuário Ag. Orç.</label><br>
                                            <select name="idusuarioorc" class="span12">
                                                <option value = ""> TODOS</option>
                                                <?php foreach ($dados_usuario_orc as $so) { ?>

                                                <option value="<?php echo $so->idUser_aguardandoOrc; ?>" ><?php echo $so->nome; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="span1" class="control-group">
                                            <button href="#" onClick="document.getElementById('form1').submit();" style="background-color: #f9f9f9; border: 0px;"><i class="icon-search" style="font-size:30px; float: right; margin-right:50% "></i></button>
                                        </div>

                                        
                                    </div>


                                </form>

                            </div>
                            



                            
                        </div>

                    </div>

                </div>

            </div>


            <span style="color: white">.</span>

        </div>

    </div>
</div><!--
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Itens</a></li>
    <li><a href="#tab2" data-toggle="tab">Cotações</a></li>
    <li><a href="#tab3" data-toggle="tab">Pedidos de Compra</a></li>
</ul> -->
<form class="form-inline" action="<?php echo base_url() ?>index.php/suprimentos/montarpedidocompra"
            method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <!--
    <div class="tab-content">
        <div class="tab-pane active" id="tab1"> -->
            <div align='center'>            

                <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Rel-compras">Excel</a>
                <button type="submit" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success"><i class="icon-plus icon-white"></i> Imprimir/Gerar Cotação</button>
                <button type="submit" name="btnGerarPedido" value = "btnGerarPedido" class="btn btn-success"><i class="icon-plus icon-white"></i> Gerar Pedido</button>
                <button type="submit" name="btnAbrirPedidos" value = "btnAbrirPedidos" class="btn btn-success"><i class="icon-plus icon-white"></i> Abrir Pedidos</button>
                <!--<button type="submit" name="btnImprimSelecionados" value="btnImprimSelecionados" class="btn btn-success" style="height: 26px"><i class="icon-print icon-white"></i></button>
                -->
                <?php if(!empty($results)){ 
                    if($results[0]->idStatuscompras <=2 || $results[0]->idStatuscompras ==6){ ?>
                    <a  href="#modal-imprimiritem3" role="button" data-toggle="modal" class="btn btn-success" style="height: 20px"><i class="icon-print icon-white"></i></a>
                    <?php
                }else if($results[0]->idStatuscompras >2 && $results[0]->idStatuscompras !=6){ ?>
                    <button type="submit" name="btnImprimSelecionados" value="btnImprimSelecionados" class="btn btn-success" style="height: 26px"><i class="icon-print icon-white"></i></button>
                    <?php
                }   ?>
                <?php
                }   ?>
                <?php
                if($this->permission->checkPermission($this->session->userdata('permissao'),'dPedCompra')){
                ?>
                    <a  id="excluir" class="btn btn-warning"><i class="icon-remove icon-white"></i> Excluir</a>
                    <?php

                }?>
                <?php
                                            
                if($this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
                    ?>
                        <a id="alterar" style="margin-right: 1%" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i>Alterar O.C.</a>
                        <?php                        
                }?>
            </div>

            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-user"></i>
                    </span>
                    <h5>Montar Pedido de compra</h5>

                </div>


                <div id="scrollIdtest" onmousemove="scrollDetect(this,event)" class="widget-content nopadding" style="  overflow-x: scroll;">

                    
                    <!-------------------------------------------------------------------->
                    <input type="hidden" name="idPedidoCompra" value="<?=set_value('idPedidoCompra', null)?>">
                    <input type="hidden" name="nf_fornecedor" value="<?=set_value('nf_fornecedor', null)?>">
                    <input type="hidden" name="idOs" value="<?=set_value('idOs', null)?>">
                    <input type="hidden" name="idStatuscompras" value="<?=set_value('idStatuscompras', null)?>">
                    <input type="hidden" name="numPedido" value="<?=set_value('numPedido', null)?>">
                    <input type="hidden" name="fornecedor" value="<?=set_value('fornecedor', null)?>">
                    <input type="hidden" name="fornecedor_id" value="<?=set_value('fornecedor_id', null)?>">
                    <input type="hidden" name="descricao" value="<?=set_value('descricao', null)?>">
                    <input type="hidden" name="empresaNum1" value="<?=set_value('empresaNum1', null)?>">
                    <input type="hidden" name="empresaNum2" value="<?=set_value('empresaNum2', null)?>">
                                                            
                    <!-------------------------------------------------------------------->

                    <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                        <thead>
                            <tr>
                                <th colspan=8></th>
                                <th colspan=4>Aprovação</th>
                                <th colspan=8></th>
								<th colspan=8></th>
                            </tr>
                            <tr><!--
                                <?php 
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'aPermisaocompras')){
                                ?>
                                <th>
                                    Permissão
                                </th>
                                <?php
                                }
                                ?>-->
                                <th><input type="checkbox" id="checkTodos" name="checkTodos" style="z-index:999"></th>
                                <th>OS</th>
                                <th>Unid. Exec.</th>
                                <th>Alter. Status</th>
                                <th>Cod. <br>Forn.</th>
                                <th>Qtd.</th>
                                <th>Descrição</th>
                                <th>OBS</th>
                                <th>PCP</th>
                                <th>DIR TEC</th>
                                <th>FIN/SUP</th>
                                <th>DIR</th>
                                <th>Solicitação Material</th>
                                <!-- <th>Data que gerou Status:<br>Aguardando orçamento</th>-->
                                <th>Status</th>
								<th>Revisão PCP</th> 
								<th>Data Ped. Revisão</th> 								
                                <th>Usuário Ag. Orç.</th><!--
                                <th>Grupo</th>-->
                                <!--<th>Cotação</th>-->
                                <th>O.C.</th>
                                <th>Data Pedido</th>
								<th>Data Limite PCP</th>
                                <!--                                   
                                <th>Fornecedor / NF</th>
                                <th>OBS</th>-->
                                <th></th>
                                <th></th>
                                <!--<th></th>-->
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
							<?php if(isset($results)){ ?>
								<?php foreach ($results as $r) {
								// Color logic based on status
								$r->cor = '#000000'; // Default color
								if($r->idStatuscompras == 2) $r->cor = '#03036c';
								else if($r->idStatuscompras == 3) $r->cor = '#008000';
								else if($r->idStatuscompras == 4) $r->cor = '#A020F0';
								else if($r->idStatuscompras == 5) $r->cor = '#c17d00';
								else if($r->idStatuscompras == 6) $r->cor = '#FF0000';
								?>

                           <tr>
                                <td>
                                    <input type='hidden' value='<?php echo $r->idStatuscompras;?>' name='idStatuscompras_[]'>
                                    <input type='checkbox' id="checkDistri" value='<?php echo $r->idDistribuir;?>' name='idDistribuir_[]'>
                                </td>
                                <td><?php echo $r->idOs; ?></td>
                                <td><?php echo $r->status_execucao;?></td>
                                <td>
                                    <span style="display:none"><?php if(!empty($r->data_alteracao)) echo date('Y-m-d H:i:s', strtotime($r->data_alteracao)); ?></span>
                                    <?php if(!empty($r->data_alteracao)) echo date('d/m/Y', strtotime($r->data_alteracao)); ?>
                                </td>
                                <td><?php echo $r->cod_fornecedor;?></td>										
                                <td><?php echo $r->quantidade;?></td>
                                <td>
                                    <?php  
                                        $html = $r->descricaoInsumo;
                                        if(!empty($r->dimensoes)) $html.=" ".$r->dimensoes;
                                        if(!empty($r->comprimento)) $html.=" x ".$r->comprimento." mm";
                                        if(!empty($r->volume)) $html.=" ".$r->volume." ml";
                                        if(!empty($r->peso)) $html.=" ".$r->peso." g";
                                        if(!empty($r->dimensoesL)) $html .= " x L: ".$r->dimensoesL." mm ";
                                        if(!empty($r->dimensoesC)) $html .= " x C: ".$r->dimensoesC." mm ";
                                        if(!empty($r->dimensoesA)) $html .= " x A: ".$r->dimensoesA." mm";
                                        echo $html;
                                    ?>
                                </td>
                                <td><?php echo $r->obs;?></td>
                                <td><?php echo $r->nomePCP.",";?> <?php if(!empty($r->data_autorizacaoPCP)) echo date('d/m/Y H:i', strtotime($r->data_autorizacaoPCP)); ?></td>
                                <td><?php echo $r->nomeDirTec.",";?> <?php if(!empty($r->data_autorizacaoDir)) echo date('d/m/Y H:i', strtotime($r->data_autorizacaoDir)); ?></td>
                                <td><?php echo $r->nomeSUP.",";?> <?php if(!empty($r->data_autorizacaoSUP)) echo date('d/m/Y H:i', strtotime($r->data_autorizacaoSUP)); ?></td>
                                <td><?php echo $r->nomeDir.",";?> <?php if(!empty($r->data_autorizacao)) echo date('d/m/Y H:i', strtotime($r->data_autorizacao)); ?></td>
                                <td>
                                    <span style="display:none"><?php if(!empty($r->datacadastrodist)) echo date('Y-m-d H:i:s', strtotime($r->datacadastrodist)); ?></span>
                                    <?php echo date("d/m/Y", strtotime($r->datacadastrodist));?>
                                </td>
                                <td>
                                    <?php echo $r->nomeStatus; if(!empty($r->datastatusentregue)) echo " ".date("d/m/Y", strtotime($r->datastatusentregue)); ?>
                                </td>
<td>
    <?php if ($r->idStatuscompras == 2): ?>
        <input type="checkbox" class="revisao-pcp-check" data-id="<?= $r->idDistribuir ?>" />
        <button type="button" class="btn btn-info btn-sm open-observacao" data-id="<?= $r->idDistribuir ?>" data-idos="<?= $r->idOs ?>">Obs</button>
    <?php elseif ($r->idStatuscompras == 22): ?>
        <span title="<?= htmlspecialchars(@$r->observacao_revisao_pcp) ?>">
            <i class="fa fa-check-circle text-success"></i>
        </span>
        <button type="button" class="btn btn-info btn-xs open-observacao" style="font-size:10px; padding:2px 4px;" data-id="<?= $r->idDistribuir ?>" data-idos="<?= $r->idOs ?>">Ver Obs</button>
    <?php endif; ?>
</td>
<td>
<?php if (isset($r->data_revisao_pcp) && $r->data_revisao_pcp): ?>
    <div style="font-size:11px; color:#777;">
        <?= date('d/m/Y H:i', strtotime($r->data_revisao_pcp)) ?>
    </div>
<?php endif; ?>
</td>									
                                <td><?php echo $r->nomeAgOrc;?></td>
                                <td>
                                    <?php echo $r->idPedidoCompra;?>
                                    <?php if($r->idPedidoCompra <> '' && $r->idStatuscompras <> 7) {
                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){ ?>
                                            <a href="#modal-editarpedidocompra2" style="margin-right: 1%" role="button" data-toggle="modal" itempedidocompra="<?php if(isset($r->idPedidoCompraItens)){echo $r->idPedidoCompraItens;}?>" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>
                                    <?php } } ?>
                                </td>
                                <td>
                                    <span style="display:none"><?php if(!empty($r->cadpedgerado)) echo date('Y-m-d H:i:s', strtotime($r->cadpedgerado)); ?></span>
                                    <?php if(!empty($r->cadpedgerado)) echo date("d/m/Y", strtotime($r->cadpedgerado)); ?>
                                </td>
                                <td>
                                    <?php if(!empty($r->data_limite)) echo date("d/m/Y", strtotime($r->data_limite)); ?>	
                                </td>										
                                <td><?php echo $r->user; ?></td>
                                <td>
                                <?php if($r->idPedidoCompra <> '' && !empty($r->idEmitente)) {
                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
                                        echo '<a href="'.base_url().'index.php/suprimentos/imprimir_pedido/'.$r->idPedidoCompra.'" style="margin-right: 1%" class="btn tip-top"  target="_blank"><i class="icon-print icon-white"></i></a>'; 
                                    }  
                                }
                                ?>
                                </td>
                                <td>
                                <?php if(isset($r->idPedidoCompraItens) && $r->idPedidoCompraItens <> '') {
                                    if($r->idStatuscompras <> 8 && $r->idStatuscompras <> 9 && $r->idStatuscompras <> 7) {
                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'dPedCompra')){ ?>
                                            <a href="#modal-excluiritempedido" style="margin-right: 1%" role="button" data-toggle="modal" idPedidoCompraItens_1="<?php echo $r->idPedidoCompraItens; ?>" class="btn btn-warning tip-top"><i class="icon-remove icon-white"></i></a>
                                <?php   }
                                    }
                                }
                                ?>
                                </td>
                            </tr>
                            <div id="modal-usuario<?php if(isset($r->idPedidoCompraItens)){ echo $r->idPedidoCompraItens; } ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h5 id="myModalLabel">Histórico de Usuario</h5>
                                </div>
                                <div class="modal-body">
                                    Informação do usuario que cadastrou e sequencia de alterações realizadas:<br>
                                    <?php echo $r->histo_alteracao; ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
                    <?php //echo $this->pedidocompra->estoque_atual(1); ?>
                    <div class="form-actions" align='center'>            

                        <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Rel-compras">Excel</a>
                        <button type="submit" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success"><i class="icon-plus icon-white"></i> Imprimir/Gerar Cotação</button>
                        <button type="submit" name="btnGerarPedido" value = "btnGerarPedido" class="btn btn-success"><i class="icon-plus icon-white"></i> Gerar Pedido</button>
                        <button type="submit" name="btnAbrirPedidos" value = "btnAbrirPedidos" class="btn btn-success"><i class="icon-plus icon-white"></i> Abrir Pedidos</button>
                        <!--<button type="submit" name="btnImprimSelecionados" value="btnImprimSelecionados" class="btn btn-success" style="height: 26px"><i class="icon-print icon-white"></i></button>
                        -->
                        <?php if(!empty($results)){ 
                            if($results[0]->idStatuscompras <=2 || $results[0]->idStatuscompras ==6){ ?>
                            <a  href="#modal-imprimiritem3" role="button" data-toggle="modal" class="btn btn-success" style="height: 20px"><i class="icon-print icon-white"></i></a>
                            <?php
                        }else if($results[0]->idStatuscompras >2 && $results[0]->idStatuscompras !=6){ ?>
                            <button type="submit" name="btnImprimSelecionados" value="btnImprimSelecionados" class="btn btn-success" style="height: 26px"><i class="icon-print icon-white"></i></button>
                            <?php
                        }   ?>
                        <?php
                        }   ?>
                        <?php
                        if($this->permission->checkPermission($this->session->userdata('permissao'),'dPedCompra')){
                        ?>
                            <a id="excluir2" class="btn btn-warning"><i class="icon-remove icon-white"></i> Excluir</a>
                            <?php
                        
                        }?>
                        <?php
                                            
                        if($this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
                            ?>
                                <a id="alterar2"  style="margin-right: 1%" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i>Alterar O.C.</a>
                                <?php                        
                        }?>
                        
                    </div>
                    <div id="modal-imprimiritem3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 id="myModalLabel">Empresa</h5>
                        </div>
                        <div class="modal-body">
                        <select class="form-control" name="idEmitente">
                                        
                            <?php foreach ($dados_emitente as $e) { ?>
                            
                            <option value="<?php echo $e->id; ?>" <?php if($e->id == 1){ echo "selected='selected'";}?>><?php echo $e->nome; ?></option>
                            <?php } ?>
                                        
                        </select>

                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                            <button type="submit" name="btnImprimSelecionados" value="btnImprimSelecionados" class="btn btn-danger">Imprimir</button>
                        </div>
                    </div>
                    
                </div>
            </div><!--
        </div>

        <div class="tab-pane" id="tab2">
                                olá
        </div>
        <div class="tab-pane" id="tab3">
                                Hello
        </div> 
    </div>-->
        
    
</form>

<?php echo $this->pagination->create_links();?>
<div id="modal-editarpedidocompra2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/suprimentos/editarpc" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">


        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Alterar número do pedido</h5>
        </div>
        <div class="modal-body">
            <!--<input type="hidden" id="idPedidoCompra" name="idPedidoCompra" value="<?php echo $r->idPedidoCompra; ?>" />
     <input type="hidden" id="idCotacaoItens" name="idCotacaoItens" value="<?php echo $r->idCotacaoItens; ?>" />
    --><input type="hidden" id="idPedidoCompraItens_" name="idPedidoCompraItens_" value="" />
            Enviar item para o pedido de compra número:<input type="text" id="idPedidoCompra_n" name="idPedidoCompra_n"
                value="" />


        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Salvar</button>
        </div>
    </form>
</div>




<div id="modal-editarpedidocompraitens" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/suprimentos/alterarItens" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">


        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Alterar número do pedido</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idPedidoCompraItens_" name="idPedidoCompraItens_" value="" />
            Enviar item para o pedido de compra número: <input type="text" id="idPedidoCompra_n" name="idPedidoCompra_n"
                value="" /> (Se deseja criar uma nova O.C., clique no botão GERAR NOVA ORDEM)</br></br>
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>OS</td>
                            <th>Qtd</td>
                            <th>Descrição</td>
                            <th>Status</td>
                            <th>O.C.</td>
							<th>ID Forn.</td>
							<th>Emitente</td>							
                        </tr>
                    </thead>
                    <tbody id="tbodyAlterar">
                    </tbody>
                </table>

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success" name="btnAlterar" value = "btnAlterar">Alterar para O.C. Existente</button>
            <button class="btn btn-danger" name="btnGerar" value = "btnGerar">Gerar Nova Ordem</button>
        </div>
    </form>
</div>




<div id="modal-excluiritempedido" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/suprimentos/excluir_itempedido" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Item da Cotação</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idPedidoCompraItens_nn" name="idPedidoCompraItens_nn" value="" />
            <!-- idCotacaoItens<input type="text" id="idCotacaoItens" name="idCotacaoItens" value="<?php echo $r->idCotacaoItens; ?>" />
                idDistribuir<input type="text" id="idDistribuir" name="idDistribuir" value="<?php echo $r->idDistribuir; ?>" />
            -->
            <h5 style="text-align: center">Deseja realmente excluir este item do pedido?</h5>
            Para excluir o pedido de compra INTEIRO com todos os itens, selecione SIM, caso deseja excluir somente esse
            item do pedido seleciona NÃO: <select name='todos'>
                <option value='nao' selected>Não</option>
                <option value='sim'>sim</option>
            </select>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Excluir</button>
        </div>
    </form>
</div>

<div id="modal-excluirSelect" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/suprimentos/cancelarItens" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>               
        </div>
        <div class="modal-body" id="tableExcluir">
            <h5 style="text-align: center">Deseja realmente cancelar estes itens?</h5>
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>OS</td>
                        <th>Qtd</td>
                        <th>Descrição</td>
                        <th>Status</td>
                    </tr>
                </thead>
                <tbody id="tbodyExcluir">
                </tbody>
            </table>
            

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Excluir</button>
        </div>
    </form>
</div>



<div id="modalObsRevisao" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-pcp-obs">
    <form id="formObsRevisao">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Observação da Revisão PCP</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <textarea name="observacao" id="obsRevisaoTexto" rows="4" class="form-control" placeholder="Digite a observação para o comprador..."></textarea>
          
          <p id="dataRevisaoPcpTexto" style="font-size: 11px; color: #888; margin-top: 5px;"></p>
          
          <input type="hidden" id="itemObsId" name="idDistribuir" value="">
          
          <input type="hidden" id="itemObsIdOs" name="idOs" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
// Funções auxiliares (fora do document.ready)
function CheckAll22() {
    var ok2 = $('#todas').data('checked') || false;
    $('input[name="idStatuscompras[]"]').prop('checked', !ok2);
    $('#todas').data('checked', !ok2);
}

function alterarOrdemServico() {
    var html = "";
    $("#tbodyAlterar").empty();
    $("input:checkbox[id=checkDistri]:checked").each(function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/getDistribuir",
            type: 'POST',
            dataType: 'json',
            data: { idDistribuir: $(this).val() },
            success: function(dataI) {
                if (dataI.result == true) {
                    for (x = 0; x < dataI.resultado.length; x++) {
                        html = "<tr>" +
                            "<td><input type='hidden' value='" + dataI.resultado[x].idDistribuir + "' name='alterarDistribuir_[]'/>" + dataI.resultado[x].idOs + "</td>" +
                            "<td><input type='hidden' value='" + dataI.resultado[x].idStatuscompras + "' name='alterarStatuscompras_[]'/>" + dataI.resultado[x].quantidade + "</td>" +
                            "<td>" + dataI.resultado[x].descricaoInsumo + " " + dataI.resultado[x].dimensoes + "</td>" +
                            "<td>" + dataI.resultado[x].nomeStatus + "</td>" +
                            "<td>" + dataI.resultado[x].idPedidoCompra + "</td>" +
                            "<td><input type='hidden' value='" + dataI.resultado[x].idFornecedores + "' name='idFornecedores[]'/>" + dataI.resultado[x].idFornecedores + "</td>" +
                            "<td><input type='hidden' value='" + dataI.resultado[x].idEmitente + "' name='idEmitente[]'/>" + dataI.resultado[x].idEmitente + "</td>" +
                            "</tr>";
                        $('#tbodyAlterar').append(html);
                    }
                } else {
                    alert(dataI.msggg);
                }
            },
            error: function(xhr, textStatus, error) {
                console.log("Erro em getDistribuir:", xhr.responseText);
            }
        });
    });
}

function permCompra(insumo, statusCheck) {
    var test = Array.apply(null, document.querySelectorAll("#checkPermAlmo" + insumo));
    test.forEach((elemento) => {
        elemento.checked = statusCheck;
    });
    $.ajax({
        url: "<?php echo base_url(); ?>index.php/suprimentos/permCompraAlmoxarifado",
        type: 'POST',
        dataType: 'json',
        data: { insumo: insumo, statusCheck: statusCheck },
        success: function(data) {
            if (data.result) {
                console.log(data.msggg);
            }
        },
        error: function(xhr, textStatus, error) {
            console.log("Erro em permCompraAlmoxarifado:", xhr.responseText);
        },
    });
}

function scrollDetect(input, event) {
    var valor = document.querySelector("#scrollIdtest");
    if ($("#scrollIdtest").width() - 100 < (event.pageX - $("#scrollIdtest").offset().left) && $("#scrollIdtest").width() > (event.pageX - $("#scrollIdtest").offset().left)) {
        $("#scrollIdtest").animate({ scrollLeft: valor.scrollWidth }, 100);
    }
    if (0 < (event.pageX - $("#scrollIdtest").offset().left) && 100 > (event.pageX - $("#scrollIdtest").offset().left)) {
        $("#scrollIdtest").animate({ scrollLeft: 0 }, 100);
    }
}

function exportTableToCSV($table, filename, type) {
    var startQuote = type == 0 ? '"' : '';
    var $rows = $table.find('tr').not(".no-csv"),
        tmpColDelim = String.fromCharCode(11),
        tmpRowDelim = String.fromCharCode(0),
        colDelim = type == 0 ? '";"' : '\t',
        rowDelim = type == 0 ? '"\r\n"' : '\r\n',
        csv = startQuote + $rows.map(function(i, row) {
            var $row = $(row),
                $cols = $row.find('td,th');
            return $cols.map(function(j, col) {
                var $col = $(col),
                    text = $col.text().trim().indexOf("is in cohort") > 0 ? $(this).attr('title') : $col.text().trim();
                return text.replace(/"/g, '""');
            }).get().join(tmpColDelim);
        }).get().join(tmpRowDelim)
        .split(tmpRowDelim).join(rowDelim)
        .split(tmpColDelim).join(colDelim) + startQuote;
    
    var BOM = "\uFEFF";
    if (window.Blob && window.URL) {
        var blob = new Blob([BOM + csv], { type: 'text/csv;charset=utf8' });
        var csvUrl = URL.createObjectURL(blob);
        $(this).attr({ 'download': filename, 'href': csvUrl });
    } else {
        var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(BOM + csv);
        $(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' });
    }
}

// LÓGICA CONSOLIDADA NO DOCUMENT.READY
$(document).ready(function() {
    
    // Máscara de data
    $('.data').inputmask("date",{ inputFormat: "dd/mm/yyyy" });

    // Lógica para preencher campos ocultos ao clicar em <a>
    $(document).on('click', 'a', function(event) {
        var itempedidocompra = $(this).attr('itempedidocompra');
        if (itempedidocompra) {
            $('#idPedidoCompraItens_').val(itempedidocompra);
        }
        var idPedidoCompraItens_1 = $(this).attr('idPedidoCompraItens_1');
        if (idPedidoCompraItens_1) {
            $('#idPedidoCompraItens_nn').val(idPedidoCompraItens_1);
        }
    });

    // Autocomplete para fornecedor
    $("#fornecedor").autocomplete({
        source: "<?php echo base_url(); ?>index.php/suprimentos/autoCompletefornecedor",
        minLength: 1,
        select: function(event, ui) {
            $("#fornecedor_id").val(ui.item.id);
        }
    });
    
    // Lógica do botão de marcar/desmarcar todos (simplificada)
    $("#checkTodos").click(function(){
        $('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
    });

    // Lógica para o botão de "Excluir" itens
    $("#excluir, #excluir2").click(function(){
        var html = "";
        var check = false;
        $("#tbodyExcluir").empty();
        $("input:checkbox[id=checkDistri]:checked").each(function(){
            check = true;
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/suprimentos/getDistribuir",
                type: 'POST',
                dataType: 'json',
                data: { idDistribuir: $(this).val() },
                success: function(dataI) {
                    if(dataI.result == true){
                        for(x=0;x<dataI.resultado.length;x++){
                            html = "<tr>" +
                                "<td><input type='hidden' value='"+dataI.resultado[x].idDistribuir+"'name='excluirDistribuir_[]'/>"+dataI.resultado[x].idOs+"</td>" +
                                "<td><input type='hidden' value='"+dataI.resultado[x].idStatuscompras+"'name='excluirStatuscompras_[]'/>"+dataI.resultado[x].quantidade+"</td>" +
                                "<td>"+dataI.resultado[x].descricaoInsumo+" "+dataI.resultado[x].dimensoes+"</td>" +
                                "<td>"+dataI.resultado[x].nomeStatus+"</td>" +
                            "</tr>";
                            $('#tbodyExcluir').append(html);
                        }
                    } else {
                        alert(dataI.msggg);
                    }
                },
                error: function(xhr) { console.log("Erro em getDistribuir para exclusão:", xhr.responseText); }
            });
        });
        if(check){
            $('#modal-excluirSelect').modal('show');
        }
    });

    // Lógica para o botão de "Alterar O.C."
    $("#alterar, #alterar2").click(function(){
        alterarOrdemServico();
        $('#modal-editarpedidocompraitens').modal('show');
    });

    // LÓGICA DO MODAL DE REVISÃO PCP
    $(document).on('click', '.open-observacao', function(e) {
        e.preventDefault();
        
        var itemId = $(this).data('id');
        var itemOsId = $(this).data('idos');
        
        if (!itemId || !itemOsId) {
            console.error('ERRO: Item ID ou OS ID não encontrado nos atributos data-* do botão.');
            alert('Erro ao carregar dados do item. Verifique o console (F12).');
            return;
        }

        $('#itemObsId').val(itemId);
        $('#itemObsIdOs').val(itemOsId);
        
        var getUrl = '<?php echo base_url("index.php/suprimentos/getObsRevisaoPcp"); ?>';

        $.get(getUrl, { idDistribuir: itemId }, function(data) {
            $('#obsRevisaoTexto').val(data.observacao || '');
            if (data.data_revisao_pcp) {
                let dataFormatada = moment(data.data_revisao_pcp).format('DD/MM/YYYY HH:mm');
                $('#dataRevisaoPcpTexto').text('Revisado em: ' + dataFormatada);
            } else {
                $('#dataRevisaoPcpTexto').text('');
            }
            $('#modalObsRevisao').modal('show');
        }, 'json');
    });

    $('#formObsRevisao').on('submit', function(e) {
        e.preventDefault();

        var postUrl = '<?php echo base_url("index.php/suprimentos/salvarRevisaoPcp"); ?>';
        
        var dataToSend = $(this).serialize();

        $.post(postUrl, dataToSend, function(response) {
            if(response && response.status === 'ok') {
                $('#modalObsRevisao').modal('hide');
                location.reload();
            } else {
                var errorMsg = (response && response.msg) ? response.msg : 'Ocorreu um erro desconhecido.';
                alert('Ocorreu um erro ao salvar: ' + errorMsg);
            }
        }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
            console.error('ERRO ao salvar observação:', textStatus, errorThrown);
            console.error('Resposta completa do servidor:', jqXHR.responseText);
            alert('Erro de comunicação com o servidor. Verifique o console do navegador (F12).');
        });
    });

    // Inicialização do DataTable
    $('#table_id').DataTable({
        'columnDefs': [{
            'targets': [0],
            'orderable': false,
        }],
        "order": [[3, "desc"], [11, "desc"]],
        "paging": false,
        "bPaginate": false,
        "searching": false,
        "language": {
            "lengthMenu": "Mostrar _MENU_ resultados por página",
            "sProcessing": "Procesando...",
            "sZeroRecords": "Sem resultados",
            "sInfo": "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros de 0 a 0 de um total de 0 registros",
            "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primeiro",
                "sLast": "Último",
                "sNext": "Seguinte",
                "sPrevious": "Anterior"
            }
        }
    });
    
    // Exportar para CSV
    $(".export-csv").on('click', function(event) {
        var filename = $(this).data("filename");
        exportTableToCSV.apply(this, [$('#table_id'), filename + ".csv", 0]);
    });

    // Lógica para o checkbox CheckAll22 (se for acionada por um atributo HTML)
    ok2 = false;
    function CheckAll22() {
        if (!ok2) {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'idStatuscompras[]') {
                    x.checked = true;
                    ok2 = true;
                }
            }
        } else {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'idStatuscompras[]') {
                    x.checked = false;
                    ok2 = false;
                }
            }
        }
    }

    // A lógica de permCompra estava fora do ready, mantive essa estrutura
    $("input:checkbox[name=checkPermAlmo]").click(function(){
        permCompra(this.value,this.checked);
    });
    
});
</script>