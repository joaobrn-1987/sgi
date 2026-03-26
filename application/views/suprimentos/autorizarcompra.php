<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<style type="text/css">
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    table.comBordas {
        border: 0px solid White;
    }

    table.comBordas td {
        border: 1px solid grey;
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
        background-color: #ccc; /* Cinza (Pendente) */
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
        background-color: #51a351; /* Verde (Aprovado) */
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
</style>

<ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Ordem de Compra</a></li>
    <li><a href="#tab3" data-toggle="tab">Histórico de Aprovação</a></li>
</ul>

<div class="tab-content"> <div class="tab-pane active" id="tab1">
        
        <form action="<?php echo current_url(); ?>" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Filtro</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                    <div class="tab-pane active">
                                        <div class="span12" id="divCadastrarOs">
                                            <div class="span12" style="padding: 1%; margin-left: 0">
                                                <div class="span2" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">O.C.: </label>
                                                    <input type="text" name="idOCFiltro" class="span12" value="<?php echo $this->input->post('idOCFiltro'); ?>"/>
                                                </div>  
                                                <div class="span2 control-group">
                                                    <label for="cliente" class="control-label">Comprador:</label>
                                                    <input class="span12 form-control" id="userS" type="text" name="userS" value="<?php echo $this->input->post('userS'); ?>" />
                                                    <input id="idUserS" type="hidden" name="idUserS" value="<?php echo $this->input->post('idUserS'); ?>" />
                                                </div>												
                                                                                    
                                            </div>
                                            <div class="span12" style="padding: 1%; margin-left: 0px">
                                                <div class="span2" class="control-group">
                                                    <button class="btn btn-success">Filtrar</button>
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
        </form> <div class="row-fluid" style="margin-top:10px">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tasks"></i>
                        </span>
                        <h5>Aprovação em Lote por Semana</h5>
                    </div>
                    <div class="widget-content">
                        <form action="<?php echo base_url(); ?>index.php/suprimentos/aprovacao_em_lote" method="post" id="formAprovacaoLote" onsubmit="return confirm('Tem certeza que deseja aprovar todos os itens pendentes (Status 23) das OCs relacionadas a estas OSs? Esta ação não pode ser desfeita.')">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="span12" style="padding: 1%; margin-left: 0">
                                
                                <div class="span3 control-group">
                                    <label for="semana_ano" class="control-label">Semana/Ano<span class="required">*</span></label>
                                    <input type="text" name="semana_ano" id="semana_ano" class="span11" value="<?php echo date('W/Y'); ?>" required />
                                </div>
                                
                                <div class="span6 control-group">
                                    <label for="lista_os">Lista de OSs<span class="required">*</span></label>
                                    <textarea name="lista_os" id="lista_os" class="span12" rows="4" placeholder="Insira as OSs separadas por espaço, vírgula ou quebra de linha" required></textarea>
                                </div>

                                <div class="span3 control-group">
                                     <label for="btnAprovarLote" class="control-label">&nbsp;</label>
                                    <button type="submit" id="btnAprovarLote" class="btn btn-success"><i class="icon-ok icon-white"></i> Aprovar Lote</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Compras</h5>
                        <?php if($listaPedidos)
                            // O botão "Aprovar Todos" agora chama a nova função JS
                            echo '<div style="position: unset;text-align: right;height: 100%;padding: 9px 100px;">Aprovar Todos: <label class="switch"><input type="checkbox" name="allCheck" id="allCheck"><span class="slider round"></span></label></div>';
                        ?>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">
                                        <div class="widget-box" style="margin-top:0px">
                                            <table class="table table-bordered" id="dadosTlbOsOc">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>O.C.</th>
                                                        <th>Fornecedor</th>
                                                        <th>Valor Total</th>
                                                        <th>Pagamento</th>
                                                        <th>Cond. de Pag.</th>
                                                        <th>Data Cadastro</th>
                                                        <th>Comprador</th>
                                                        <th>Anexo</th>
                                                        <th>Aprovar (OC)</th> <th>Rejeitar (OC)</th> </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($listaPedidos as $r) {
                                                        // A linha 'pai' (OC)
                                                        echo '<tr class="trpai' . $r->idPedidoCompra . '" data-id="' . $r->idPedidoCompra . '">'; // Adicionado data-id
                                                        echo '<td onclick="openclose(this,' . $r->idPedidoCompra . ')" style="text-align: center;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';

                                                        // Salva os IDs de distribuir de todos os filhos em inputs hidden
                                                        $itens = explode(";", $r->idDistribuir);
                                                        foreach ($itens as $b) {
                                                            echo '<input type="hidden" name="checkDistribuir" id="checkDistribuir' . $r->idPedidoCompra . '" value="' . $b . '">';
                                                        }
                                                        
                                                        echo '<td><a title="Clique aqui para visualizar as informações da O.C." style="cursor:pointer" onclick="openModalInfoOC(' .  $r->idPedidoCompra . ')"><b>' .  $r->idPedidoCompra . '</b></a></td>';
                                                        echo '<td>' . $r->nomeFornecedor . '</td>';
                                                        echo '<td> <input type="hidden" name="somaIdDistribuir" id="somaIdDistribuir' . $r->idPedidoCompra . '" value="' . $r->soma . '"> R$ ' . number_format($r->soma, 2, ',', '.') . '</td>';
                                                        echo '<td>' . $r->nomePgto . '</td>';
                                                        echo '<td>' . $r->condPgto . '</td>';
                                                        echo '<td>' . date("d/m/Y H:i:s", strtotime($r->data_cadastro)) . '</td>';
                                                        echo '<td>' . $r->nomeUserOrc . '</td>';
                                                        
                                                        // Lógica de Anexos (Preservada)
                                                        $anexoImagens = $this->pedidocompra_model->getAnexoCotacaoSuprimentosByIdPedidoCompra($r->idPedidoCompra);
                                                            echo '<td><a href="#modal-anexo_cotacao'.$r->idPedidoCompra.'" role="button" data-toggle="modal" style="margin-right: 3%" class="btn tip-top"><i class="icon-folder-open" id="i_obs_" style="color:'.($anexoImagens?"green":"grey").'"></i></a>'.
                                                                '<div id="modal-anexo_cotacao'.$r->idPedidoCompra.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                    '<div class="modal-header">'.
                                                                        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                        '<h5 id="myModalLabel">Anexos de Cotações OC:'.$r->idPedidoCompra.'</h5>'.
                                                                    '</div>'.
                                                                    '<div class="modal-body">';
                                                                        if($anexoImagens){
                                                                            echo '<div class="span12" style="margin-left:0px">'. 
                                                                                '<div class="row-fluid" style="margin-top:0">'.
                                                                                    '<div class="span12">'.
                                                                                        '<div class="widget-box">'.
                                                                                            '<div class="widget-title">'.
                                                                                                '<span class="icon">'.
                                                                                                    '<i class="icon-tags"></i>'.
                                                                                                '</span>'.
                                                                                                '<h5>Anexos</h5>'.
                                                                                            '</div>'.
                                                                                            '<div class="widget-content nopadding">'.
                                                                                                '<div class="span12" id="divProdutosServicos" style=" margin-left: 0">'.
                                                                                                    '<div class="span12" id="divCadastrarOs">  '.                             
                                                                                                        '<div class="widget-box" style="margin-top:0px">' .                                       
                                                                                                            '<table class="table table-bordered " >'.
                                                                                                                '<thead>'.
                                                                                                                    '<tr>'.
                                                                                                                        '<th>Arquivo</th>'.
                                                                                                                        '<th></th>'.
                                                                                                                    '</tr>'.
                                                                                                                '</thead>'.
                                                                                                                '<tbody>'; 
                                                                                                                    foreach($anexoImagens as $anex){
                                                                                                                        echo '<tr>';
                                                                                                                        echo '<td><a href="' . base_url() .  $anex->caminho . $anex->imagem . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>
                                                                                                                            <a href="' .base_url(). $anex->caminho . $anex->imagem . '" target="_blank">' . $anex->nomeArquivo  . '</a></td>';
                                                                                                                        echo '<td></td>';
                                                                                                                        echo '</tr>';
                                                                                                                    }
                                                                                                                echo '</tbody>'.
                                                                                                            '</table>'.
                                                                                                        '</div>'.
                                                                                                    '</div>'.
                                                                                                '</div>'.
                                                                                            '</div>'.
                                                                                        '</div>'.
                                                                                    '</div>'.    
                                                                                '</div>'. 
                                                                            '</div>';
                                                                        }else{
                                                                            echo '<div class="span12" style="margin-left:0px">'. 
                                                                                '<div class="row-fluid" style="margin-top:0">'.
                                                                                    '<div class="span12">'.
                                                                                        '<div class="widget-box">'.
                                                                                            '<div class="widget-title">'.
                                                                                                '<span class="icon">'.
                                                                                                    '<i class="icon-tags"></i>'.
                                                                                                '</span>'.
                                                                                                '<h5>Anexos</h5>'.
                                                                                            '</div>'.
                                                                                            '<div class="widget-content nopadding">'.
                                                                                                '<div class="span12" id="divProdutosServicos" style=" margin-left: 0">'.
                                                                                                    '<div class="span12" id="divCadastrarOs">  '.                             
                                                                                                        '<div class="widget-box" style="margin-top:0px">' .                                       
                                                                                                            '<table class="table table-bordered " id="tableDesenhos_">'.
                                                                                                                '<thead>'.
                                                                                                                    '<tr>'.
                                                                                                                        '<th>Arquivo</th>'.
                                                                                                                        '<th></th>'.
                                                                                                                    '</tr>'.
                                                                                                                '</thead>'.
                                                                                                                '<tbody>'.
                                                                                                                    '<tr>'.
                                                                                                                        '<td colspan="2" style="text-align:center">Não há desenhos anexados nesse item.</td>'.
                                                                                                                    '</tr>';
                                                                                                                                                                                                
                                                                                                                echo '</tbody>'.
                                                                                                            '</table>'.
                                                                                                        '</div>'.                               
                                                                                                    '</div>'.
                                                                                                '</div>'.
                                                                                            '</div>'.
                                                                                        '</div>'.
                                                                                    '</div>'.    
                                                                                '</div>'. 
                                                                            '</div>';
                                                                        }                                                                                           
                                                                    echo '</div>'.
                                                                '</div>'; 
                                                            '</td>';
                                                        
                                                        // Botão Aprovar OC
                                                        echo '<td style="text-align:center"><label class="switch"><input type="checkbox" name="checkPedidoCompra" id="checkPedidoCompra' . $r->idPedidoCompra . '" value="' . $r->idPedidoCompra . '"><span class="slider round"></span></label></td>';
                                                        // Botão Rejeitar OC
                                                        echo '<td style="text-align:center"><a onclick="openRejeitarModal(' . $r->idPedidoCompra . ', \'oc\')" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a></td>';

                                                        echo '</tr>';

                                                        // Linha 'filho' (Itens)
                                                        echo '<tr class="trfilho' . $r->idPedidoCompra . '" style="display:none">';
                                                        echo '<td colspan=11 style="background-color: #efefef;padding-top: 0px;">';
                                                        echo '<div style="margin: 20px;margin-top: 0px;">';
                                                        echo '<table class="table table-bordered ">';
                                                        echo '<thead>';
                                                        echo '<tr>';
                                                        echo '<th>O.S.</th>';
                                                        echo '<th>O.S. Status</th>';
                                                        echo '<th>Descrição</th>';
                                                        echo '<th>Quantidade</th>';
                                                        echo '<th>Status</th>';
                                                        echo '<th>Grupo</th>';
                                                        echo '<th>Valor Unit.</th>';
                                                        echo '<th>Valor Total</th>';
                                                        echo '<th>Solicitado Por</th>';
                                                        echo '<th>Autorizado PCP</th>';
                                                        echo '<th>Data Autorizado PCP</th>';
                                                        echo '<th>Aut. Dir. Téc.</th>';
                                                        echo '<th>Data Aut. Dir. Téc.</th>';
                                                        echo '<th>Últimos</br>Orç.</th>';
                                                        echo '<th>Aprovar (Item)</th>';
                                                        echo '<th>Rejeitar (Item)</th>';
                                                        echo '</tr>';
                                                        echo '</thead>';
                                                        echo '<tbody>';
                                                        
                                                        foreach ($r->itens as $i) {
                                                            echo '<tr id="itemRow'.$i->idDistribuir.'">'; // ID na linha para remoção
                                                            echo '<td><a title="Clique aqui para visualizar as informações da O.S." style="cursor:pointer" onclick="openModalInfoOS(' . $i->idOs . ')"><b>' . $i->idOs . '</b></a></td>';
                                                            echo '<td>' . $i->nomeStatusOs . '</td>';
                                                            // ... (lógica de descrição preservada) ...
                                                            $html = $i->descricaoInsumo;
                                                            if(!empty($i->dimensoes)){ $html.=" ".$i->dimensoes; } 
                                                            if(!empty($i->comprimento)){ $html.=" X ".$i->comprimento." mm"; } 
                                                            if(!empty($i->volume)){ $html.=" ".$i->volume." ml"; } 
                                                            if(!empty($i->peso)){ $html.=" ".$i->peso." g"; } 
                                                            if(!empty($i->dimensoesL)){ $html .= " X L: ".$i->dimensoesL." mm"; }
                                                            if(!empty($i->dimensoesC)){ $html .= " X C: ".$i->dimensoesC." mm"; }
                                                            if(!empty($i->dimensoesA)){ $html .= " X A: ".$i->dimensoesA." mm"; }
                                                            echo '<td>' . $html. '</td>';
                                                            
                                                            echo '<td>' . $i->quantidade . '</td>';
                                                            echo '<td>' . $i->nomeStatus . '</td>';
                                                            echo '<td>' . $i->nomegrupo . '</td>';
                                                            echo '<td>R$ ' . number_format($i->valor_unitario, 2, ",", ".") . '</td>';
                                                            echo '<td>R$ ' . number_format($i->valor_unitario * $i->quantidade, 2, ",", ".") . '</td>';
                                                            echo '<td>' . $i->nome . '</td>';
                                                            echo '<td>' . $i->nomeUserPCP . '</td>';
                                                            if (!empty($i->data_autorizacaoPCP)) {
                                                                echo '<td>' . date("d/m/Y", strtotime($i->data_autorizacaoPCP)) . '</td>';
                                                            } else { echo '<td></td>'; }
                                                            echo '<td>' . $i->nomeUserDir . '</td>';
                                                            if (!empty($i->data_autorizacaoDir)) {
                                                                echo '<td>' . date("d/m/Y", strtotime($i->data_autorizacaoDir)) . '</td>';
                                                            } else { echo '<td></td>'; }
                                                            echo '<td><a onclick="buscarUltimosOrc('. $i->idDistribuir .')" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a></td>';
                                                            
                                                            
                                                            if($i->rejeitado == 0){ // Só mostra botões se não estiver rejeitado
                                                                echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" name="checkPedidoCompraItens" id="checkItem' . $i->idDistribuir . '" value="' . $i->idDistribuir . '"><span class="slider round"></span></label></td>';
                                                                echo '<td style="text-align:center"><a onclick="openRejeitarModal(' . $i->idDistribuir . ', \'item\', ' . $i->idOs . ')" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a></td>';
                                                            }else{
                                                                echo '<td colspan="2">Rejeitado</td>'; // Se já foi rejeitado
                                                            }
                                                            
                                                            echo '</tr>';
                                                            
                                                        }

                                                        echo '</tbody>';
                                                        echo '</table>';
                                                        echo '</div>';
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

    </div><div class="tab-pane" id="tab3">
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Histórico de Compras</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">
                                        <div class="widget-box" style="margin-top:0px">
                                            <table class="table table-bordered " id="dadosTlbOsOcHist"> 
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>O.C.</th>
                                                        <th>Fornecedor</th>
                                                        <th>Valor Total</th>
                                                        <th>Data Cadastro</th>
                                                        <th>Semana Aprov.</th> </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($histAutorizacao as $r) {
                                                        echo '<tr class="trhistpai' . $r->idPedidoCompra . '">';
                                                        echo '<td onclick="openclose2(this,' . $r->idPedidoCompra . ')" style="text-align: center;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';
                                                        echo '<td>'. $r->idPedidoCompra . '</td>';
                                                        echo '<td>' . $r->nomeFornecedor . '</td>';
                                                        echo '<td>  R$ ' . number_format($r->soma, 2, ',', '.') . '</td>';
                                                        echo '<td>' . date("d/m/Y H:i:s", strtotime($r->data_cadastro)) . '</td>';
                                                        echo '<td>' . (isset($r->semana_aprovacao) ? $r->semana_aprovacao : '') . '</td>'; // echo '</tr>'; // echo '<tr class="trhistfilho' . $r->idPedidoCompra . '" style="display:none">';
                                                        echo '<td colspan=8 style="background-color: #efefef;padding-top: 0px;">';
                                                        echo '<div style="margin: 20px;margin-top: 0px;">';
                                                        echo '<table class="table table-bordered ">';
                                                        echo '<thead>';
                                                        echo '<tr>';
                                                        echo '<th>O.S.</th>';
                                                        echo '<th>O.S. Status</th>';
                                                        echo '<th>Descrição</th>';
                                                        echo '<th>Quantidade</th>';
                                                        echo '<th>Status</th>';
                                                        echo '<th>Valor Unit.</th>';
                                                        echo '<th>Valor Total</th>';
                                                        echo '<th>Solicitado Por</th>';
                                                        echo '<th>Autorizado PCP</th>';
                                                        echo '<th>Data Autorizado PCP</th>';
                                                        echo '<th>Usuar. Fin.</th>';
                                                        echo '<th>Data Autorizado Fin.</th>';
                                                        echo '<th>Usuar. Dir. Técnica</th>';
                                                        echo '<th>Data Autorizado Dir. Técnica</th>';
                                                        echo '</tr>';
                                                        echo '</thead>';
                                                        echo '<tbody>';
                                                        foreach ($r->itens as $i) {
                                                            echo '<tr>';
                                                            echo '<td><a title="Clique aqui para visualizar as informações da O.S." style="cursor:pointer" onclick="openModalInfoOS(' . $i->idOs . ')"><b>' . $i->idOs . '</b></a></td>';
                                                            echo '<td>' . $i->nomeStatusOs . '</td>';
                                                            $html = $i->descricaoInsumo;
                                                            if(!empty($i->dimensoes)){ $html.=" ".$i->dimensoes; } 
                                                            if(!empty($i->comprimento)){ $html.=" X ".$i->comprimento." mm"; } 
                                                            if(!empty($i->volume)){ $html.=" ".$i->volume." ml"; } 
                                                            if(!empty($i->peso)){ $html.=" ".$i->peso." g"; } 
                                                            if(!empty($i->dimensoesL)){ $html .= " X L: ".$i->dimensoesL." mm"; }
                                                            if(!empty($i->dimensoesC)){ $html .= " X C: ".$i->dimensoesC." mm"; }
                                                            if(!empty($i->dimensoesA)){ $html .= " X A: ".$i->dimensoesA." mm"; }
                                                            echo '<td>' . $html. '</td>';
                                                            echo '<td>' . $i->quantidade . '</td>';
                                                            echo '<td>' . $i->nomeStatus . '</td>';
                                                            echo '<td>R$ ' . number_format($i->valor_unitario, 2, ",", ".") . '</td>';
                                                            echo '<td>R$ ' . number_format($i->valor_unitario * $i->quantidade, 2, ",", ".") . '</td>';
                                                            echo '<td>' . $i->nome . '</td>';
                                                            echo '<td>' . $i->nomeUserPCP . '</td>';
                                                            if (!empty($i->data_autorizacaoPCP)) {
                                                                echo '<td>' . date("d/m/Y", strtotime($i->data_autorizacaoPCP)) . '</td>';
                                                            } else { echo '<td></td>'; }
                                                            echo '<td>' . $i->nomeUserSUP . '</td>';
                                                            if (!empty($i->data_autorizacaoSUP)) {
                                                                echo '<td>' . date("d/m/Y", strtotime($i->data_autorizacaoSUP)) . '</td>';
                                                            } else { echo '<td></td>'; }
                                                            echo '<td>' . $i->nomeUserDir . '</td>';
                                                            if (!empty($i->data_autorizacaoDir)) {
                                                                echo '<td>' . date("d/m/Y", strtotime($i->data_autorizacaoDir)) . '</td>';
                                                            } else { echo '<td></td>'; }
                                                            echo '</tr>';
                                                        }
                                                        echo '</tbody>';
                                                        echo '</table>';
                                                        echo '</div>';
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
    </div></div><div id="modal-rejeitarItem" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabelRejeitar">Rejeitar Compra</h5> </div>
    <div class="modal-body">
        <div class="span12">
            <h5 style="text-align: center">Deseja realmente rejeitar?</h5>
            <input type="hidden" id="rejeitarId" value="">
            <input type="hidden" id="rejeitarTipo" value="">
            <p style="text-align: center; font-weight: bold;" id="rejeitarItem_b"></p> </div>
        <div class="span12">
            <label>Observação (Obrigatória):</label>
            <textarea class="span12" name="obs_rejeitado" id="obs_rejeitado" rows="3"></textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <a class="btn btn-danger" id="btnConfirmarRejeicao" onclick="confirmarRejeicao()">Confirmar Rejeição</a>
    </div>
</div>

<div id="modal-os" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Informações da O.S.: <b id="bInfoOS"></b> </h5>
    </div>
    <div>
        <div class="row-fluid" style="margin-top: 0px">
            <div class="span12">
                <div class="">
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0;background-color: #f9f9f9;">
                            <div class="container-fluid" style="margin-top: 20px;" id="divInfoOS">
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-fornec-emitente" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Dados Orçamento</h5>   
    </div>
    <div class="modal-body" id="divInfoOC">
         </div>
</div>
<div id="modal-ultimosorcamento" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Últimos Orçamentos </h5>
    </div>
    <div>
        <div class="widget-content nopadding" style="overflow-y: scroll;height: 500px;">
            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="span12" id="divCadastrarOs">                                
                            <div class="widget-box" style="margin-top:0px">                                        
                                <table id="tableOC" class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Data O.C.</th>
                                            <th>O.C.</th>
                                            <th>Descrição</th>
                                            <th>Status</th>
                                            <th>Qtd.</th>
                                            <th>Valor Unit.</th>
                                            <th>Valor Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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

<script>
    // --- FUNÇÕES DE UI (PRESERVADAS) ---
    /*setTimeout(function() {
        window.location.href = "<?php echo base_url()?>";
    }, 240000);*/
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

    function openclose2(td, valor) {
        var tr = document.querySelector(".trhistfilho" + valor);

        if (tr.style.display == "table-row" || tr.style.display == "") {
            $(".trhistfilho" + valor).hide('fast');
            $(td).parent('tr').css('background-color', '');
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");
        } else {
            $(".trhistfilho" + valor).show('fast');
            $(td).parent('tr').css('background-color', '#efefef');
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }
    }

    function openModalInfoOS(idOs) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/os/carregarinfoos",
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {
                idOs: idOs
            },
            success: function(data) {
                if(data.result)
                    carregarinfoModal(data.resultado);
                    
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        })
    }
    function carregarinfoModal(item){
        $("#divInfoOS").empty()
        html = '<table class="comBordas" width="36%" align="left">'+
            '<tr>'+
                '<td align="center">'+
                    'O.S. Número: <font size="5">'+item.idOs+'</font>'+
                '</td>'+
                '<td align="center">';
                    data = new Date(item.data_abertura);
                    visualData = moment(data).format('DD/MM/YYYY')
                    html+='Data: </b>'+visualData+'</td>';
                html += '<td align="center">'+
                    'Unid. Exec.: </b>'+item.status_execucao+'</td>'+
            '</tr>'+
        '</table>'+
        '<div class="row-fluid">'+
            '<div class="span12">'+
                '<div class="widget-box">'+
                    '<div class="widget-content nopadding">'+
                        '<table width="100%" border="0" style="border-style:solid; border: 1px solid grey;font-family:Arial, Helvetica, sans-serif;font-size:12px;">'+
                            '<tr>'+
                                '<td align="center">'+
                                    '<table width="100%" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;   line-height: 20px;">'+
                                        '<tr>'+
                                            '<td align="left">Descrição:</td>'+
                                            '<td style="width: 50%">'+item.descricao_item+'</td>'+
                                            '<td align="left">Cliente:</td>'+
                                            '<td><b>'+item.nomeCliente+'</b></td>'+
                                        '</tr>'+
                                        '<tr>'+
                                            '<td align="left" width="13%"> Qtd.: </td>'+
                                            '<td>'+item.qtd_os+'</td>'+
                                            '<td align="left" width="13%">Orçamento: </td>'+
                                            '<td>'+item.idOrcamentos+'</td>'+
                                        '</tr>'+
                                        '<tr>'+
                                            '<td align="left">'+
                                                '<h5>PN:</h5>'+
                                            '</td>'+
                                            '<td>'+
                                                '<h5>'+item.pn+'</h5>'+
                                            '</td>';
                                            if(item.data_reagendada && item.data_reagendada != ""){
                                                data = new Date(item.data_reagendada);
                                                visualData = moment(data).format('DD/MM/YYYY')
                                                html += '<td align="left">Data Reagendada:</td>'+
                                                '<td colspan="3">'+visualData+'</td>';
                                            }else if(item.data_entrega && item.data_entrega != ""){
                                                data = new Date(item.data_entrega);
                                                visualData = moment(data).format('DD/MM/YYYY')
                                                html += '<td align="left">Data Entrega:</td>'+
                                                    '<td colspan="3">'+visualData+'</td>';
                                                
                                            }
                                            
                                        html += '</tr>'+
                                    '</table>'+
                                '</td>'+
                            '</tr>'+
                        '</table>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
        $("#divInfoOS").append(html)
        $("#modal-os").modal("show");
    }

    function openModalInfoOC(oc){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/carregarinfooc",
            type: 'POST',
            dataType: 'json',
            async: false,
            data: { idPedidoCompra: oc },
            success: function(data) {
                if(data.result) carregarinfoModalOC(data.resultado);
            },
            error: function(xhr, textStatus, error) { console.log(xhr.responseText); }
        })
    }
    
    function carregarinfoModalOC(item){
        $("#divInfoOC").empty();
        html = '<div style="size:20px">'+
            '<label >Empresa:</label>'+
            '<input readonly id="emitente" class="span12 controls emitente" type="text" value="'+(item[0].nome ? item[0].nome : '')+'" size="50" />'+
            '<label readonly for="fornecedor" class="control-label">Fornecedor:</label>'+
            '<input readonly id="fornecedor" class="span12 controls fornecedor" type="text" value="'+(item[0].nomeFornecedor ? item[0].nomeFornecedor : '')+'" size="50" />'+
        '</div>' +
        '<table>'+
            '<tr>'+
                '<td>'+ 
                    'Previsão de entrega:<input readonly size="6" id="previsao_entrega" class=" data" type="text"  value="'+(item[0].previsao_entrega!=null?moment(new Date(item[0].previsao_entrega)).format('DD/MM/YYYY'):"")+'" />'+
                '</td>'+
                '<td>Prazo de entrega: <input readonly size="3" class="span8 form-control" type="text" value="'+(item[0].prazo_entrega!=null?item[0].prazo_entrega:"")+'">dias</td>'+
                '<td>Pagamento: <input readonly class="recebe-solici" type="text" class="controls" value="'+(item[0].nome_status_cond_pgt!=null?item[0].nome_status_cond_pgt:"")+'">'+                      
                '</td>'+
                '<td>Condição de pagamento:'+
                    '<input class="form-control" readonly size="50" type="text"  value="'+(item[0].cod_pgto!=null?item[0].cod_pgto:"")+'">'+
                '</td>'+
            '</tr>'+
            '<tr>'+
                '<td colspan="4">'+
                    'Frete:'+
                    '<input class="form-control" readonly type="text" size="7" id="freteit" value="'+(item[0].frete!= null?Number(item[0].frete).toFixed(2).replace(".",","):"")+'">'+
                    'Desconto:'+
                    '<input class="form-control" readonly type="text" size="7" id="descontoit" value="'+(item[0].desconto!=null?Number(item[0].desconto).toFixed(2).replace(".",","):"")+'">'+
                    'Outros:'+
                    '<input class="form-control" readonly type="text" size="7" id="outrosit" value="'+(item[0].outros!=null?Number(item[0].outros).toFixed(2).replace(".",","):"")+'">'+
                '</td>'+
            '</tr>'+
            '<tr>'+
                '<td colspan="6">OBS:'+
                    '<textarea id="obs" readonly rows="5" cols="100" class="" id="obs">'+(item[0].obscompras ? item[0].obscompras : '')+'</textarea>'+
                '</td>'+
            '</tr>'+
        '</table>';
        $("#divInfoOC").append(html);
        $("#modal-fornec-emitente").modal("show");
    }

    function buscarUltimosOrc(id){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/suprimentos/ultimoorc",
            type: 'POST',
            dataType: 'json',
            async: false,
            data: { idDistribuir: id },
            success: function(data) {
                if(data.result)
                    carregarUltimosOrc(data.obj);
                else
                    alert("Não foi encontrado orçamentos anteriores deste item.");
            },
            error: function(xhr, textStatus, error) { console.log(xhr.responseText); }
        });
    }

    function carregarUltimosOrc(item){
        var html = "";
        for(x=0;x<item.length;x++){
            html += "<tr>";
                html += "<td>"+(item[x].cadpedgerado!=null?moment(new Date(item[x].cadpedgerado)).format('DD/MM/YYYY'):"")+"</td>";
                html += "<td>"+item[x].idPedidoCompra+"</td>";
                html += "<td>"+item[x].descricaoInsumo+" "+(item[x].dimensoes!=null?item[x].dimensoes:"")+"</td>";
                html += "<td>"+item[x].nomeStatus+"</td>";
                html += "<td>"+item[x].quantidade+"</td>";
                html += "<td> R$ "+(item[x].valor_unitario!=null?Number(item[x].valor_unitario).toFixed(2).replace(".",","):"0,00")+"</td>";
                html += "<td> R$ "+(item[x].valor_unitario!= null && item[x].quantidade !=null ?Number(item[x].valor_unitario*item[x].quantidade).toFixed(2).replace(".",","):"0,00")+"</td>";
            html += "</tr>";
        }    
        $("#tableOC tbody").empty();
        $("#tableOC tbody").append(html);
        $("#modal-ultimosorcamento").modal("show");
    }

    $("#userS").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "<?php echo base_url(); ?>index.php/suprimentos/autoCompleteFunc",
          dataType: "json",
          data: { term: request.term },
          success: function(data) { response(data); },
          error: function(xhr, status, error) { console.log("Erro no autocomplete: ", error); }
        });
      },
      minLength: 1,
      select: function(event, ui) {
        $('#idUserS').val(ui.item.id);
        //$('#userS2').val(ui.item.nome); // Descomente se este campo for usado
      }
    });

    // --- FIM FUNÇÕES DE UI PRESERVADAS ---


    // --- INÍCIO: NOVAS FUNÇÕES DE APROVAÇÃO E REJEIÇÃO ---

    /**
     * Função chamada pelos toggles/checkboxes para APROVAR um item ou OC.
     * @param {string|number} id - O ID do que está sendo aprovado.
     * @param {string} tipo - 'item' (para idDistribuir) ou 'oc' (para idPedidoCompra) ou 'todos'.
     * @param {HTMLElement} checkboxElement - O próprio checkbox que foi clicado.
     */
    function aprovar(id, tipo, checkboxElement) {
        
        var idsDistribuir = [];
        var parentRow;
        var childCheckboxes;
        
        // Desabilita o checkbox clicado para evitar cliques duplos
        if (checkboxElement) {
            $(checkboxElement).prop('disabled', true);
        }

        if (tipo === 'item') {
            // Aprovando um único item (sub-item da tabela)
            idsDistribuir.push(id);
            parentRow = $(checkboxElement).closest('tr');
        } 
        else if (tipo === 'oc') {
            // Aprovando uma OC inteira (linha principal)
            var idPedidoCompra = id;
            $('input[name="checkDistribuir"][id="checkDistribuir' + idPedidoCompra + '"]').each(function() {
                idsDistribuir.push($(this).val());
            });
            parentRow = $('.trpai' + idPedidoCompra); // Pega a linha principal da OC
            
            // ATUALIZAÇÃO: Marca e desabilita os checkboxes filhos
            childCheckboxes = $('.trfilho' + idPedidoCompra).find('input[name=checkPedidoCompraItens]');
            childCheckboxes.prop('disabled', true).prop('checked', true); // Marca e desabilita os filhos
        }
        else if (tipo === 'todos') {
            // Aprovando "Todos"
            $('input:checkbox[name=checkPedidoCompra]:not(:disabled)').each(function() {
                var idOC = $(this).val();
                $(this).prop('disabled', true).prop('checked', true); // Desabilita e marca o checkbox da OC
                
                $('input[name="checkDistribuir"][id="checkDistribuir' + idOC + '"]').each(function() {
                    idsDistribuir.push($(this).val());
                });

                // ATUALIZAÇÃO: Marca e desabilita os checkboxes filhos
                $('.trfilho' + idOC).find('input[name=checkPedidoCompraItens]').prop('disabled', true).prop('checked', true);
            });
            parentRow = null; // Múltiplas linhas
        }

        if (idsDistribuir.length === 0) {
            alert("Nenhum item válido encontrado para aprovar.");
            if (checkboxElement) $(checkboxElement).prop('disabled', false); // Reabilita se nada foi feito
            return;
        }

        var totalRequests = idsDistribuir.length;
        var completedRequests = 0;
        var errors = [];
        var successCount = 0;

        idsDistribuir.forEach(function(idDist) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/suprimentos/aprovarFinal",
                type: 'POST',
                dataType: 'json',
                data: {
                    idDistribuir: idDist,
                    action: 'approve'
                },
                success: function(data) {
                    if (data.result) {
                        successCount++;
                        // Se estiver aprovando item individual, remove a linha dele
                        if (tipo === 'item') {
                            $('#itemRow' + idDist).fadeOut('slow', function() { $(this).remove(); });
                        }
                    } else {
                        errors.push("Erro ao aprovar item " + idDist + ": " + (data.msggg || "Erro desconhecido"));
                    }
                },
                error: function(xhr, textStatus, error) {
                    errors.push("Erro de comunicação ao aprovar item " + idDist);
                    console.log(xhr.responseText); // Mostra o erro do PHP no console
                },
                complete: function() {
                    completedRequests++;
                    if (completedRequests === totalRequests) {
                        handleApprovalCompletion(errors, parentRow, tipo, id, successCount);
                    }
                }
            });
        });
    }

    /**
     * Função auxiliar chamada após todas as aprovações AJAX terminarem
     */
    function handleApprovalCompletion(errors, parentRow, tipo, id, successCount) {
        if (errors.length > 0) {
            alert("Ocorreram erros:\n" + errors.join("\n") + "\n\n" + successCount + " item(ns) aprovado(s) com sucesso.");
            // Recarrega a página para mostrar o estado misto
            location.reload(); 
        } else {
            // Se não houver erros
            alert(successCount + " item(ns) aprovado(s) com sucesso.");
            if (tipo === 'oc') {
                // Remove a linha da OC e sua linha filha
                parentRow.fadeOut('slow', function() { $(this).remove(); });
                $('.trfilho' + id).remove(); // Remove a linha filha
            } else if (tipo === 'todos') {
                location.reload();
            }
            // Se for 'item', a linha já foi removida na chamada success
        }
    }

    /**
     * Abre o modal de rejeição, preparando-o com os IDs corretos.
     * @param {string|number} id - O ID do que está sendo rejeitado (idDistribuir ou idPedidoCompra).
     * @param {string} tipo - 'item' (para idDistribuir) ou 'oc' (para idPedidoCompra).
     * @param {string|number} os - O número da OS (opcional, para exibir no modal).
     */
    function openRejeitarModal(id, tipo, os = '') {
        // Limpa o modal
        $("#obs_rejeitado").val('');
        $("#rejeitarItem_b").empty();

        // Adiciona inputs ocultos para o tipo e id no modal (se não existirem)
        if ($('#rejeitarId').length === 0) {
            $('#modal-rejeitarItem .modal-body').append('<input type="hidden" id="rejeitarId" value="">');
        }
         if ($('#rejeitarTipo').length === 0) {
            $('#modal-rejeitarItem .modal-body').append('<input type="hidden" id="rejeitarTipo" value="">');
        }
        $('#rejeitarId').val(id);
        $('#rejeitarTipo').val(tipo);

        var modalTitle = "Rejeitar ";
        var modalBody = "";

        if (tipo === 'item') {
            modalTitle += "Item";
            // Tenta buscar detalhes do item
             $.ajax({
                url: "<?php echo base_url(); ?>index.php/suprimentos/getdistribuirdetail",
                type: 'POST',
                dataType: 'json',
                async: false,
                data: { idDistribuir: id },
                success: function(data) {
                    if (data.result && data.objDistribuir) {
                         modalBody = "O.S.: " + data.objDistribuir.idOs + " | Qtd: " + data.objDistribuir.quantidade + " | " + data.objDistribuir.descricaoInsumo;
                    } else {
                        modalBody = "Item (ID Dist: " + id + ")";
                    }
                }, error: function() { modalBody = "Item (ID Dist: " + id + ")"; }
            });
        } else if (tipo === 'oc') {
            modalTitle += "Ordem de Compra";
            modalBody = "O.C. inteira: " + id;
        }

        $("#myModalLabelRejeitar").text(modalTitle); // Define o título do modal
        $("#rejeitarItem_b").html(modalBody); // Define o corpo

        // Abre o modal
        $("#modal-rejeitarItem").modal("show");
    }

    /**
     * Função chamada pelo botão "Confirmar" do modal de rejeição.
     */
    function confirmarRejeicao() {
        var id = $('#rejeitarId').val();
        var tipo = $('#rejeitarTipo').val();
        var observacao = $('#obs_rejeitado').val();
        var idsDistribuir = [];

        if (!observacao) {
            alert("A observação é obrigatória para rejeitar.");
            return;
        }

        // Desabilita botões do modal
        $('#modal-rejeitarItem .btn').prop('disabled', true);

        if (tipo === 'item') {
            idsDistribuir.push(id);
        } else if (tipo === 'oc') {
            // Pega todos os idDistribuir daquela OC
            $('input[name="checkDistribuir"][id="checkDistribuir' + id + '"]').each(function() {
                idsDistribuir.push($(this).val());
            });
        }

        if (idsDistribuir.length === 0) {
            alert("Nenhum item válido encontrado para rejeitar.");
            $('#modal-rejeitarItem .btn').prop('disabled', false);
            $("#modal-rejeitarItem").modal("hide");
            return;
        }

        var totalRequests = idsDistribuir.length;
        var completedRequests = 0;
        var errors = [];

        idsDistribuir.forEach(function(idDist) {
             $.ajax({
                url: "<?php echo base_url(); ?>index.php/suprimentos/aprovarFinal", // Usa a mesma função do controller
                type: 'POST',
                dataType: 'json',
                data: {
                    idDistribuir: idDist,
                    action: 'reject',
                    observacao: observacao
                },
                success: function(data) {
                    if (!data.result) {
                        errors.push("Erro ao rejeitar item " + idDist + ": " + (data.msggg || "Erro desconhecido"));
                    }
                },
                error: function(xhr, textStatus, error) {
                    errors.push("Erro de comunicação ao rejeitar item " + idDist);
                    console.log(xhr.responseText);
                },
                complete: function() {
                    completedRequests++;
                    if (completedRequests === totalRequests) {
                        // Quando todas as requisições terminarem
                        $('#modal-rejeitarItem .btn').prop('disabled', false);
                        $("#modal-rejeitarItem").modal("hide");

                        if (errors.length > 0) {
                            alert("Ocorreram erros:\n" + errors.join("\n"));
                        } else {
                            alert("Item(s) rejeitado(s) com sucesso.");
                        }
                        location.reload(); // Recarrega a página para atualizar a lista
                    }
                }
            });
        });
    }

    // --- BINDINGS (LIGAÇÕES) DOS EVENTOS ---
    
    // Assegura que o jQuery está pronto
    $(document).ready(function() {
        
        // Clique no Checkbox do SUB-ITEM (Aprovar Item)
        // Usa delegação de evento para funcionar mesmo após filtragem
        $('#dadosTlbOsOc').on('click', 'input:checkbox[name="checkPedidoCompraItens"]', function() {
            var idDistribuir = $(this).val();
            aprovar(idDistribuir, 'item', this);
        });

        // Clique no Checkbox "Aprovar Todos"
        $('#allCheck').on('click', function(){
            // Corrigindo a lógica do 'Aprovar Todos' para desabilitar/habilitar com base no estado 'checked'
            if ($(this).is(':checked')) {
                aprovar(null, 'todos', this);
            } else {
                // Se o "Aprovar Todos" for desmarcado, re-habilita os botões (um reload é mais simples)
                location.reload();
            }
        });

        // Clique no Checkbox da OC (Aprovar OC Inteira)
        $('#dadosTlbOsOc').on('click', 'input:checkbox[name="checkPedidoCompra"]', function() {
            var idPedidoCompra = $(this).val();
            // Só executa a aprovação se o checkbox for MARCADO
            if ($(this).is(':checked')) {
                aprovar(idPedidoCompra, 'oc', this);
            } else {
                // Se desmarcar, re-habilita o próprio botão (ação de "desaprovar" não implementada no AJAX)
                $(this).prop('disabled', false);
                // Um reload seria mais seguro para resetar o estado dos filhos
                // location.reload(); 
            }
        });

        // As funções openRejeitarModal() são chamadas via onclick() no HTML.
        // O modal de rejeição 'modal-rejeitarItem' agora chama confirmarRejeicao().
        
    });

</script>