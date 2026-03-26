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
                                            <input id="empresaNum2" class="form-control span5" type="text" name="empresaNum2" value="<?=set_value('empresaNum2', 3)?>" />
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
    <!--
    <div class="tab-content">
        <div class="tab-pane active" id="tab1"> -->
            <div align='center'>            

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
                                <th colspan=7></th>
                                <th colspan=4>Aprovação</th>
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
                                <th>Qtd.</th>
                                <th>Descrição</th>

                                <th>OBS</th>
                                <th>PCP</th>
                                <th>DIR TEC</th>
                                <th>FIN</th>
                                <th>DIR</th>
                                <th>Solicitação Material</th>
                                <!-- <th>Data que gerou Status:<br>Aguardando orçamento</th>-->
                                <th>Status</th>
                                <th>Usuário Ag. Orç.</th><!--
                                <th>Grupo</th>-->
                                <!--<th>Cotação</th>-->
                                <th>O.C.</th>
                                <th>Data Pedido</th>
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
                                $color = '';                  
                                $codStatus = $r->idStatuscompras;
                                if($codStatus == 1){
                                    $r->cor = '#000000';
                                }else if($codStatus == 2){
                                    $r->cor = '#03036c';
                                }else if($codStatus == 3){
                                    $r->cor = '#008000';
                                }else if($codStatus == 4){
                                    $r->cor = '#A020F0';
                                }else if($codStatus == 5){
                                    $r->cor = '#c17d00';
                                }else if($codStatus == 6){
                                    $r->cor = '#FF0000';
                                }		
                        
                                ?>

                                    <tr ><!--
                                        <?php 
                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'aPermisaocompras')){
                                        ?>
                                        <td>
                                            <?php if($r->idOs == '10'||$r->idOs == '11'||$r->idOs == '12'){?>
                                            <label class="switch">
                                            
                                                <?php if($r->statusPermissao == 1){?>
                                                    <input type="checkbox" checked name='checkPermAlmo' id='checkPermAlmo<?php echo $r->idInsumos ?>'  value='<?php echo $r->idInsumos ?>'>
                                                <?php
                                                }else{?>
                                                    <input type="checkbox" name='checkPermAlmo' id='checkPermAlmo<?php echo $r->idInsumos ?>' value='<?php echo $r->idInsumos ?>'>
                                                <?php
                                                }
                                            ?>
                                                
                                                <span class="slider round"></span>
                                            </label>
                                            <?php
                                            }?>
                                        </td>
                                        <?php
                                        
                                        }
                                        ?>-->
                                        <td >
                                            <font >                                        
                                            <!--<?php echo $r->idDistribuir;?>-->
                                            <input type='hidden' value='<?php echo $r->idStatuscompras;?>' name='idStatuscompras_[]'>
                                            <input type='checkbox' id="checkDistri" value='<?php echo $r->idDistribuir;?>' name='idDistribuir_[]'>
                                            </font>
                                            
                                        </td>
                                        <td >
                                            <font >
                                            <?php 
                                                echo $r->idOs;
                                            ?>
                                            </font>
                                        </td>
                                        <td><?php echo $r->status_execucao;?></td>
                                        <td >
                                        <font >
                                            <span style="display:none"><?php if(!empty($r->data_alteracao)){ 
                                                $date = new DateTime( $r->data_alteracao );
                                                echo $date-> format( 'Y-m-d H:i:s' );
                                            }
                                            ?></span>
                                            <?php if(!empty($r->data_alteracao)){ 
                                                $date = new DateTime( $r->data_alteracao );
                                                    echo $date-> format( 'd/m/Y' );
                                            // echo date("d/m/Y H:i:s", strtotime($r->data_alteracao));
                                                //echo $r->data_alteracao;
                                            }
                                            ?>
                                            </font>
                                        </td>
                                        <td >
                                            <font >
                                            <?php echo $r->quantidade;?>
                                            </font>
                                        </td>
                                        <td >
                                            <font >
                                                <?php 
                                                    $html = $r->descricaoInsumo;
                                                    if(!empty($r->dimensoes)){
                                                        $html.=" ".$r->dimensoes;
                                                    } 
                                                    if(!empty($r->comprimento)){
                                                        $html.=" ".$r->comprimento." cm";
                                                    } 
                                                    if(!empty($r->volume)){
                                                        $html.=" ".$r->volume." ml";
                                                    } 
                                                    if(!empty($r->peso)){
                                                        $html.=" ".$r->peso." g";
                                                    } 
                                                    
                                                    if(!empty($r->dimensoesL)){
                                                        $html .= " L: ".$r->dimensoesL." mm |";
                                                    }
                                                    if(!empty($r->dimensoesC)){
                                                        $html .= " C: ".$r->dimensoesC." mm |";
                                                    }
                                                    if(!empty($r->dimensoesA)){
                                                        $html .= " A: ".$r->dimensoesA." mm";
                                                    }
                                                    echo $html;
                                                //echo $r->descricaoInsumo." ".$r->dimensoes;?>
                                            </font>
                                        </td>
                                        <td >
                                            <font >
                                                <?php echo $r->obs;?>
                                            </font>
                                        </td>
                                        <td><font>
                                            <?php echo $r->nomePCP.",";?> <?php if(!empty($r->data_autorizacaoPCP)){ 
                                                $date = new DateTime( $r->data_autorizacaoPCP );
                                                    echo $date-> format( 'd/m/Y H:i' );
                                            
                                            }?>
                                        </font></td>
                                        <td><font>
                                            <?php echo $r->nomeDirTec.",";?> <?php if(!empty($r->data_autorizacaoDir)){ 
                                                $date = new DateTime( $r->data_autorizacaoDir );
                                                    echo $date-> format( 'd/m/Y H:i' );
                                            
                                            }?>
                                        </font></td>
                                        <td><font>
                                            <?php echo $r->nomeSUP.",";?> <?php if(!empty($r->data_autorizacaoSUP)){ 
                                                $date = new DateTime( $r->data_autorizacaoSUP );
                                                echo $date-> format( 'd/m/Y H:i' );                                    
                                            }?>
                                        </font></td>
                                        <td><font>
                                            <?php echo $r->nomeDir.",";?> <?php if(!empty($r->data_autorizacao)){ 
                                                $date = new DateTime( $r->data_autorizacao );
                                                echo $date-> format( 'd/m/Y H:i' );
                                            
                                            }?>
                                        </font></td>
                                        <td ><font ><span style="display:none"><?php if(!empty($r->datacadastrodist)){ 
                                                $date = new DateTime( $r->datacadastrodist );
                                                echo $date-> format( 'Y-m-d H:i:s' );
                                            }
                                            ?></span>
                                            <?php echo date("d/m/Y", strtotime($r->datacadastrodist));?></font></td>
                                        <td >
                                            <font >
                                                <?php echo $r->nomeStatus;?>
                                                <?php if(!empty($r->datastatusentregue))
                                                    {
                                                        echo " ".date("d/m/Y", strtotime($r->datastatusentregue));
                                                    }
                                                ?>
                                            </font>
                                        </td>
                                        <td>
                                            <font >
                                                <?php echo $r->nomeAgOrc;?>
                                                
                                            </font>
                                        </td>
                                        <!--
                                        <td >
                                            <font size='1'>
                                                <?php if(isset($r->nomegrupo)){ echo $r->nomegrupo;}?>
                                            </font>


                                        </td>-->
                                        <!--<td><?php echo $r->idPedidoCotacao;?></td>-->

                                        <td >
                                            <font >
                                            <?php echo $r->idPedidoCompra;?>
                                            <?php
                                            if($r->idPedidoCompra <> '')
                                            {
                                                    if($r->idStatuscompras <> 7)
                                                    {					
                                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
                                                            ?>
                                                                <a href="#modal-editarpedidocompra2" style="margin-right: 1%" role="button"
                                                                    data-toggle="modal" itempedidocompra="<?php if(isset($r->idPedidoCompraItens)){echo $r->idPedidoCompraItens;}?>"
                                                                    class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a>
                                                                <?php
                                                    
                                                        }
                                                    }
                                            }
                                            ?>
                                            </font>

                                        </td>
                                        <td >
                                            <font >
                                            <span style="display:none"><?php if(!empty($r->cadpedgerado)){ 
                                                $date = new DateTime( $r->cadpedgerado );
                                                echo $date-> format( 'Y-m-d H:i:s' );
                                            }
                                            ?></span>
                                                <?php
                                                if(!empty($r->cadpedgerado))
                                                {
                                                    echo date("d/m/Y", strtotime($r->cadpedgerado));
                                                }
                                                else{
                                                }
                                                ?>
                                            </font>
                                        </td>
                                        <!--
                                        <td >
                                            <font >
                                                <?php if(isset($r->nomeFornecedor)){echo $r->nomeFornecedor;}?> / <b>
                                                    <?php if(isset($r->notafiscal)){echo $r->notafiscal;}?>
                                            </font></b>
                                        </td>
                                        <td >
                                            <font >
                                                <?php if(isset($r->obscompras)){echo $r->obscompras;}?>
                                            </font>
                                        </td>-->
                                        <td > <font ><?php echo $r->user; ?>
                                            <!--<a href="#modal-usuario<?php echo $r->idPedidoCompraItens; ?>" style="margin-right: 1%" role="button" data-toggle="modal" idPedidoCompraItens_1="<?php echo $r->idPedidoCompraItens; ?>" class="btn tip-top" ><i class="icon icon-user"></i></a>-->

                                            </font>
                                        </td>

                                        <?php
                                        echo '<td>';
                                        
                                        if($r->idPedidoCompra <> '' && !empty($r->idEmitente))
                                        //if($r->idPedidoCompra <> '')
                                        {
                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
                                            echo '<a href="'.base_url().'index.php/suprimentos/imprimir_pedido/'.$r->idPedidoCompra.'" style="margin-right: 1%" class="btn tip-top"  target="_blank"><i class="icon-print icon-white"></i></a>'; 
                                            
                                        }  
                                        }
                    
                                
                                        ?>


                                        <?php
                            
                                        echo '</td>';
                                        /*echo '<td>';
                                        if($r->idPedidoCompra <> '')
                                        {
                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
                                            ?>
                                                    <a href="<?php echo base_url().'index.php/suprimentos/editarpedidosuprimentos/'.$r->idPedidoCompra ?>"
                                                        style="margin-right: 1%" role="button" data-toggle="modal"
                                                        cotacao="<?php echo $r->idPedidoCompra;?>" class="btn btn-info tip-top"><i
                                                            class="icon-pencil icon-white"></i></a>
                                                    <?php
                                            
                                        }
                                        }
                            
                                        echo '</td>';*/
                                        echo '<td>';
                                        
                                        if(isset($r->idPedidoCompraItens) && $r->idPedidoCompraItens <> '')
                                        {
                                            
                                            if($r->idStatuscompras <> 8 && $r->idStatuscompras <> 9 && $r->idStatuscompras <> 7)
                                            {
                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'dPedCompra')){
                                            ?>
                                                    <a href="#modal-excluiritempedido" style="margin-right: 1%" role="button" data-toggle="modal"
                                                        idPedidoCompraItens_1="<?php echo $r->idPedidoCompraItens; ?>"
                                                        class="btn btn-warning tip-top"><i class="icon-remove icon-white"></i></a>
                                                    <?php
                                            
                                                }
                                            }
                                        } /*else if($r->idStatuscompras == 1 || $r->idStatuscompras == 2 || $r->idStatuscompras == 6) {
                                            if($this->permission->checkPermission($this->session->userdata('permissao'),'dPedCompra')){
                                                ?>
                                                    <a href="#modal-deletardistribuir" style="margin-right: 1%" role="button" data-toggle="modal"
                                                        idDistribuir_1="<?php echo $r->idDistribuir; ?>"
                                                        class="btn btn-danger tip-top"><i class="icon-remove icon-white"></i></a>
                                                <?php
                                                
                                            }
                                        }*/
                                                        
                                        echo '</td>';
                                        echo '</tr>';
                                        
                                    ?>



                                        <div id="modal-usuario<?php if(isset($r->idPedidoCompraItens)){ echo $r->idPedidoCompraItens; } ?>" class="modal hide fade"
                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h5 id="myModalLabel">Histórico de Usuario</h5>
                                            </div>
                                            <div class="modal-body">
                                                Informação do usuario que cadastrou e sequencia de alterações realizadas:<br>
                                                <?php echo $r->histo_alteracao; ?>
                                            </div>


                                        </div>

                                        <?php
                                        }?>
                            <?php } ?>
                                                    

                        </tbody>
                    </table>
                    <?php //echo $this->pedidocompra->estoque_atual(1); ?>
                    <div class="form-actions" align='center'>            

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




<script type="text/javascript">
    $('.data').inputmask("date",{
        inputFormat: "dd/mm/yyyy"
    });
    $(document).ready(function() {


        $(document).on('click', 'a', function(event) {

            var itempedidocompra = $(this).attr('itempedidocompra');
            $('#idPedidoCompraItens_').val(itempedidocompra);

        });

        $(document).on('click', 'a', function(event) {

            var idPedidoCompraItens_1 = $(this).attr('idPedidoCompraItens_1');
            $('#idPedidoCompraItens_nn').val(idPedidoCompraItens_1);

        });





    });

    $("#fornecedor").autocomplete({
        source: "<?php echo base_url(); ?>index.php/suprimentos/autoCompletefornecedor",
        minLength: 1,
        select: function(event, ui) {

            $("#fornecedor_id").val(ui.item.id);



        }
    });
</script>
<script>
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
    function alterarOrdemServico(){
        var html = "";
        $("#tbodyAlterar").empty();
        $("input:checkbox[id=checkDistri]:checked").each(function(){
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/suprimentos/getDistribuir",
                type: 'POST',
                dataType: 'json',
                data: {
                    idDistribuir: $(this).val()
                },
                success: function(dataI) {
                if(dataI.result == true){
                    var obj;
                    for(x=0;x<dataI.resultado.length;x++){
                        html = 
                        "<tr>"+
                            "<td><input type='hidden' value='"+dataI.resultado[x].idDistribuir+"'name='alterarDistribuir_[]'/>"+dataI.resultado[x].idOs+"</td>"+
                            "<td><input type='hidden' value='"+dataI.resultado[x].idStatuscompras+"'name='alterarStatuscompras_[]'/>"+dataI.resultado[x].quantidade+"</td>"+
                            "<td>"+dataI.resultado[x].descricaoInsumo+" "+dataI.resultado[x].dimensoes+"</td>"+
                            "<td>"+dataI.resultado[x].nomeStatus+"</td>"+
                            "<td>"+dataI.resultado[x].idPedidoCompra+"</td>"+
                        "</tr>";
                        /*
                        obj = {
                            'idDistribuir':dataI.resultado[x].idDistribuir,
                            'idOs':dataI.resultado[x].idOs,
                            'descricaoInsumo':dataI.resultado[x].descricaoInsumo,
                            'dimensoes':dataI.resultado[x].dimensoes,
                            'nomeStatus':dataI.resultado[x].nomeStatus,
                            'quantidade':dataI.resultado[x].quantidade
                        }
                        arrayCheckDistri.push(obj);*/ 
                        $('#tbodyAlterar').append(html);                       
                    }
                    
                    //console.log(arrayCheckDistri);
                }else{
                    alert(dataI.msggg);
                }
                
                
                },
                error: function(xhr, textStatus, error) {
                console.log("2");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
                },
                            
            });
        })
    }
    $("input:checkbox[name=checkPermAlmo]").click(function(){
        //console.log(this.checked);
        //console.log(this.value)
        permCompra(this.value,this.checked);
    })
    function permCompra(insumo,statusCheck){
        var test = Array.apply(null,document.querySelectorAll("#checkPermAlmo"+insumo));
        test.forEach((elemento)=>{
            elemento.checked = statusCheck;
        })
        console.log(statusCheck);
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/permCompraAlmoxarifado",
            type: 'POST',
            dataType: 'json',
            data: {
                insumo:insumo,
                statusCheck:statusCheck
            },
            success: function(data) {
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

    $("#checkTodos").click(function(){
        $('input:checkbox[id=checkDistri]').not(this).prop('checked', this.checked);
    });
    $(document).ready(function() {/*
        $("input:checkbox[]:checked").each(function(){
            arrayCheckDistri.push($(this).val());
            console.log(arrayCheckDistri);
        });*/    
        $("#excluir").click(function(){ 
            var html = "";
            var check = false;
            $("#tbodyExcluir").empty();
            $("input:checkbox[id=checkDistri]:checked").each(function(){
                //arrayCheckDistri.push($(this).val());
            // 
                check = true;
                html = "";
                $.ajax({
                url: "<?php echo base_url(); ?>index.php/suprimentos/getDistribuir",
                type: 'POST',
                dataType: 'json',
                data: {
                    idDistribuir: $(this).val()
                },
                success: function(dataI) {
                    if(dataI.result == true){
                        var obj;
                        for(x=0;x<dataI.resultado.length;x++){
                            html = 
                            "<tr>"+
                                "<td><input type='hidden' value='"+dataI.resultado[x].idDistribuir+"'name='excluirDistribuir_[]'/>"+dataI.resultado[x].idOs+"</td>"+
                                "<td><input type='hidden' value='"+dataI.resultado[x].idStatuscompras+"'name='excluirStatuscompras_[]'/>"+dataI.resultado[x].quantidade+"</td>"+
                                "<td>"+dataI.resultado[x].descricaoInsumo+" "+dataI.resultado[x].dimensoes+"</td>"+
                                "<td>"+dataI.resultado[x].nomeStatus+"</td>"+
                            "</tr>";
                            /*
                            obj = {
                                'idDistribuir':dataI.resultado[x].idDistribuir,
                                'idOs':dataI.resultado[x].idOs,
                                'descricaoInsumo':dataI.resultado[x].descricaoInsumo,
                                'dimensoes':dataI.resultado[x].dimensoes,
                                'nomeStatus':dataI.resultado[x].nomeStatus,
                                'quantidade':dataI.resultado[x].quantidade
                            }
                            arrayCheckDistri.push(obj);*/ 
                            $('#tbodyExcluir').append(html);                       
                        }
                        
                        //console.log(arrayCheckDistri);
                    }else{
                    alert(dataI.msggg);
                    }
                
                    
                },
                error: function(xhr, textStatus, error) {
                    console.log("2");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },
                                
                });
                //console.log(arrayCheckDistri);
            })
            if(check){
                $('#modal-excluirSelect').modal('toggle');
                $('#modal-excluirSelect').modal('show');
            }
        
            //$('#modal-excluirSelect').modal('hide');
        })   
        $("#excluir2").click(function(){ 
            var html = "";
            $("#tbodyExcluir").empty();
            $("input:checkbox[id=checkDistri]:checked").each(function(){
                //arrayCheckDistri.push($(this).val());
            // 
                html = "";
                $.ajax({
                url: "<?php echo base_url(); ?>index.php/suprimentos/getDistribuir",
                type: 'POST',
                dataType: 'json',
                data: {
                    idDistribuir: $(this).val()
                },
                success: function(dataI) {
                    if(dataI.result == true){
                        check=true;
                        var obj;
                        for(x=0;x<dataI.resultado.length;x++){
                            html = 
                            "<tr>"+
                                "<td><input type='hidden' value='"+dataI.resultado[x].idDistribuir+"'name='excluirDistribuir_[]'/>"+dataI.resultado[x].idOs+"</td>"+
                                "<td><input type='hidden' value='"+dataI.resultado[x].idStatuscompras+"'name='excluirStatuscompras_[]'/>"+dataI.resultado[x].quantidade+"</td>"+
                                "<td>"+dataI.resultado[x].descricaoInsumo+" "+dataI.resultado[x].dimensoes+"</td>"+
                                "<td>"+dataI.resultado[x].nomeStatus+"</td>"+
                            "</tr>";
                            /*
                            obj = {
                                'idDistribuir':dataI.resultado[x].idDistribuir,
                                'idOs':dataI.resultado[x].idOs,
                                'descricaoInsumo':dataI.resultado[x].descricaoInsumo,
                                'dimensoes':dataI.resultado[x].dimensoes,
                                'nomeStatus':dataI.resultado[x].nomeStatus,
                                'quantidade':dataI.resultado[x].quantidade
                            }
                            arrayCheckDistri.push(obj);*/ 
                            $('#tbodyExcluir').append(html);                       
                        }
                        
                        //console.log(arrayCheckDistri);
                    }else{
                    alert(dataI.msggg);
                    }
                
                    
                },
                error: function(xhr, textStatus, error) {
                    console.log("2");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },
                                
                });
                //console.log(arrayCheckDistri);
            })
            if(check){
                $('#modal-excluirSelect').modal('toggle');
                $('#modal-excluirSelect').modal('show');
            }
            //$('#modal-excluirSelect').modal('hide');
        })  
    })
    $(document).ready(function(){
        $("#alterar").click(function(){ 
            alterarOrdemServico();
            $('#modal-editarpedidocompraitens').modal('toggle');
            $('#modal-editarpedidocompraitens').modal('show');
        })
        $("#alterar2").click(function(){ 
            alterarOrdemServico();
            $('#modal-editarpedidocompraitens').modal('toggle');
            $('#modal-editarpedidocompraitens').modal('show');
        })
    })
    $(document).ready( function () {
        
        tabelaSuprimentos = $('#table_id').DataTable({
            'columnDefs': [ {
                'targets': [0], // column index (start from 0)
                'orderable': false, // set orderable false for selected columns
            }],
            "order": [[3, "desc"],[11, "desc"]],
            "paging": false,//Dont want paging                
            "bPaginate": false,//Dont want paging 
            "searching": false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "sProcessing":    "Procesando...",
                "sZeroRecords":   "Sem resultados",
                "sInfo":          "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
                "sInfoEmpty":     "Mostrando registros de 0 a 0 de um total de 0 registros",
                "sInfoFiltered":  "(filtrado de um total de _MAX_ registros)",
                "sInfoPostFix":   "",
                "sUrl":           "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primeiro",
                    "sLast":    "Último",
                    "sNext":    "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });
        
        
    } );

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