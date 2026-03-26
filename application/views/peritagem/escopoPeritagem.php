<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->

<form action="<?php echo base_url() ?>index.php/peritagem/salvaravaliacao"    method="post" name="form1" id="formPeritag">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <div class="row-fluid" style="margin-top:0">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Peritagem</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                            <div class="tab-pane active">
                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                            <input type="text" name="idOrcamento" class="span12" value="<?php echo $orcam->idOrcamentos; ?>" readonly />
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Vendedor: </label>
                                            <input type="text" class="span12" value="<?php echo $orcam->nomeVendedor; ?>" readonly />
                                        </div>
                                        <div class="span5" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Cliente: </label>
                                            <input type="text" class="span12" value="<?php echo $orcam->nomeCliente; ?>" readonly />
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Solicitante: </label>
                                            <input type="text" class="span12" value="<?php echo $orcam->nome; ?>" readonly />
                                        </div>
                                    </div><!--
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- -->
    <div align='center'>    
        </br> 
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aPeritagem') ){ ?>
            <a class="btn btn-success" onclick="salvarItens()">Salvar</a>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aPeritagem') ){ ?>
            <a class="btn btn-success" onclick="confirmarItem()">Solicitar Confirmação</a>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPeritagem')){ ?>
            <a class="btn btn-success" onclick="modelConfirmarFinalizacao()">Finalizar a Peritagem</a>
        <?php } ?>        
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPeritagem')){ ?>
            <a class="btn btn-danger" onclick="modelReprovarPeritagem()">Reprovar Peritagem</a>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPeritagem')){ ?>
            <a class="btn btn-warning" onclick="modelReavaliarDesenho()">Sol. Reavaliação Desenho</a>
        <?php } ?>
    </div> 
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
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs">                                
                                    <div class="widget-box" style="margin-top:0px">                                        
                                        <table id="table_id" class="table table-bordered " id="dadosTlbOsOc"><!--
                                            <thead>
                                                <tr>
                                                    <th>PN</th>
                                                    <th>Orc.</th>
                                                    <th>Tipo Prod.</th>
                                                    <th>Descrição</th>  
                                                    <th>TAG</th>                                              
                                                </tr>
                                            </thead>-->
                                            <tbody>
                                                
                                                <?php 
                                                $contador_local_autocomplete = 0;
                                                $itens = "";
                                                foreach($orcItem as $d){
                                                    if(empty($itens)){
                                                        $itens = $d->idOrcamento_item;
                                                    }else{
                                                        $itens = $itens."_".$d->idOrcamento_item;
                                                    }
                                                    echo '<tr class="trpai'.$d->idOrcamento_item.'">';
                                                        if($d->tipoOrc == 'serv' && (($d->tipoProd == "cil" && 
                                                            $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemCil')) || ($d->tipoProd == "maq" && 
                                                            $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemMaq')) || ($d->tipoProd == "sub" && 
                                                            $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemSub')) || ($d->tipoProd == "pec" && 
                                                            $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemPec')))){
                                                            echo '<td onclick="openclose(this,'.$d->idOrcamento_item.')"  style="text-align: center; /* padding: 75px 5px 75px 5px */ display: table-cell;min-height: 10em;vertical-align: middle;"><a class="detail-icon"><i class="fa fa-plus"></i></a></td>';                                                        
                                                        }else{
                                                            echo '<td  style="text-align: center;"><a class="detail-icon" ><i class=""></i></a></td>';                                                        
                                                        }
                                                        echo '<td style="/* padding: 50px 5px 50px 5px */ "><div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">';
                                                            echo '<input type="hidden" id="id_orc_item_' . $contador_local_autocomplete . '" name="id_orc_item[]"   value="' . $d->idOrcamento_item . '"/>' .
                                                                '<div class="span12" style="padding: 0.2%; margin-left: 0px">' .
                                                                '<div class="span1">' .
                                                                '<label><b>PN </b>:<a onclick="editarpn('.$d->idOrcamento_item.')" style="padding: 0px 5px 5px 5px;"data-toggle="modal" role="button" class="btn-small btn-primary"><i class="icon-pencil icon-white"></i></a></label>' .
                                                                '<input readonly type="text" class="span12" id="pn_' . $contador_local_autocomplete . '" name="pn[]" value="' . $d->pn . '" />' .
                                                                ''.
                                                                '<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>' .
                                                                '<input type="hidden" id="idProdutos_' . $contador_local_autocomplete . '" name="idProdutos[]" size="3"   value="' . $d->idProdutos . '"/>' .
                                                                '<input type="hidden" name="contador[]" size="3"   value="' . $contador_local_autocomplete . '"/>' .
                                                                '</div>' .
                                                                '<div class="span1">'. 
                                                                '<label>O.S.</label>'.
                                                                '<input type="text" class="span12" readonly value="'.$d->idOs.'">'.
                                                                '</div>'.
                                                                '<div class="span1">'. 
                                                                '<label>NF Cliente</label>'.
                                                                '<input type="text" class="span12" readonly value="'.$d->nf_cliente.'">'.
                                                                '</div>'.
                                                                '<div class="span1">'. 
                                                                    '<label>Início Des.:</label>' .
                                                                    '<input readonly type="text" class="span12" value="'.(!empty($d->data_finalizado_desenho)?date("d/m/Y H:i", strtotime($d->data_finalizado_desenho)):"").'">'.
                                                                '</div>'; 
                                                                if($d->tipoOrc == 'serv'){
                                                                    $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($d->idOrcamento_item);
                                                                }
                                                                if($escopo && $escopo->nome){
                                                                    echo '<div class="span2" >' .
                                                                    '<label>Finalizado por:</label>' .
                                                                    '<input readonly type="text" class="span12" value="' . $escopo->nome . '" />'.
                                                                    
                                                                    '</div>';
                                                                }else{
                                                                    echo '<div class="span1" title="Tipo de Orçamento">' .
                                                                    '<label>Orç.:</label>' .
                                                                    '<input readonly type="text" class="span12" id="orc_' . $contador_local_autocomplete . '" name="orc[]" value="' . $d->tipoOrc . '" />'.
                                                                    
                                                                    '</div>' .
                                                                    '<div class="span1" title="Tipo de Produto">' .
                                                                    '<label>Prod.:</label>' .
                                                                    '<input readonly type="text" class="span12"  value="' . ($d->tipoProd == 'cil'? "Cilindro":($d->tipoProd == 'maq'?"Máquina":($d->tipoProd == 'pec'?"Peça":($d->tipoProd == 'sub'?"Subconjunto":"")))). '" />'.
                                                                    '<input readonly type="hidden" class="span12" id="tipo_prod_' . $contador_local_autocomplete . '" name="tipo_prod[]" value="' . $d->tipoProd . '" />';
                                                                    echo '</div>';
                                                                }
                                                                

                                                                
                                                                echo  '<div class="span3">'.
                                                                '<label>Descrição:</label>'.
                                                                '<input type="text" readonly class="span12" id="descricao_item_' . $contador_local_autocomplete . '" name="descricao_item[]"  value="' . $d->descricao_item . '" />' .
                                                                '</div>' .
                                                                '<div class="span2">';
                                                                if($d->tipoOrc == 'serv'){
                                                                    if(!empty($escopo)){
                                                                        echo '<label>Status Perit.:</label>';
                                                                        echo '<input type="text" readonly class="span12" value="'.$escopo->descricaoPeritagem.'">';
                                                                    }
                                                                }
                                                                echo'</div>'.
                                                                '<div class="span1">' .
                                                                '<label>Tag:</label>' .
                                                                '<input type="text" readonly class="span12" id="tag_' . $contador_local_autocomplete . '" name="tag[]"  value="' . $d->tag . '" />' .
                                                                '</div>' ;
                                                            
                                                            
                                                            echo '</div>';
                                                        echo '</div></td>';
                                                        echo '<td style="width:100px">';
                                                            if($d->tipoOrc == 'serv'){
                                                                $anexoImagens2 = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao( $d->idOrcamento_item);
                                                                $idOs = $this->orcamentos_model->getOrcItemDetailsById2($d->idOrcamento_item);
                                                                if($idOs->idOs){
                                                                    $anexoImagens2 = array_merge($anexoImagens2,$this->orcamentos_model->getAnexoDesenhoByIdOs($idOs->idOs));
                                                                }
                                                                echo '<div class="span1">'.
                                                                '<label></label>'.
                                                                '<a href="#modal-imagem_' .$d->idOrcamento_item. '" role="button" data-toggle="modal" style="margin-left: 10px;" class="btn btn-warning"  class="span12" >Visualizar desenhos</a>'.
                                                                    '<div id="modal-imagem_'.$d->idOrcamento_item.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                        '<div class="modal-header">'.
                                                                            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                            '<h5 id="myModalLabel">Anexar Desenho</h5>'.
                                                                        '</div>'.
                                                                        '<div class="modal-body">'.
                                                                            '<div class="span12"  style="margin-left:0px">';
                                                                                if($anexoImagens2){
                                                                                    echo '<div class="row-fluid" style="margin-top:0">'.
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
                                                                                                                    '<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">'.
                                                                                                                        '<thead>'.
                                                                                                                            '<tr>'.
                                                                                                                                '<th>Arquivo</th>'.
                                                                                                                                '<th>Status Desenho</th>'.        
                                                                                                                            '</tr>'.
                                                                                                                        '</thead>'.
                                                                                                                        '<tbody>';
                                                                                                                            '<tr>'.
                                                                                                                                '<td></td>'.
                                                                                                                                '<td></td>'.
                                                                                                                            '</tr>';  
                                                                                                                            foreach($anexoImagens2 as $anex){
                                                                                                                                echo '<tr>';
                                                                                                                                echo '<td><a href=\'' . base_url() .  $anex->caminho . $anex->imagem . '\' style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>
                                                                                                                                <a href=\'' . base_url() . $anex->caminho . $anex->imagem . '\' target="_blank">' . $anex->nomeArquivo . $anex->extensao . '</a></td>'.
                                                                                                                                    '<td>' . (!empty($anex->statusAnexo)?($anex->statusAnexo == 1 ? 'Aguardando Verificação' : ($anex->statusAnexo == 2 ? 'Aprovado' : 'Rejeitado')):"") . '</td>';
                                                                                                                                    
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
                                                                                        '</div>';
                                                                                }
                                                                            echo '</div>'. 
                                                                        '</div>'. 
                                                                    '</div>'.
                                                                '</div>';
                                                            }
                                                        echo'</td>';
                                                        
                                                    echo '</tr>';
                                                    if($d->tipoOrc == 'serv'){
                                                        $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($d->idOrcamento_item);
                                                        if (!empty($escopo)) {
                                                            $possuiEscopo = true;
                                                            $statusEscopo = $escopo->descricaoEscopo;
                                                            $escopoItens = $this->peritagem_model->itensPeritagem($escopo->idOrcServicoEscopo);
                                                            $catalogo = $this->peritagem_model->getCatalogoAtivosByIdProduto2($d->idProdutos);
                                                            if(!empty($catalogo)){
                                                                $catalogoitens = $this->peritagem_model->getCatalogoItensByIdCatalogo($catalogo->idCatalogoProduto);
                                                            }else{
                                                                $catalogoitens = null;
                                                            }
                                                        }
                                                        echo '<tr class="trfilho'.$d->idOrcamento_item.'" style="display:none">';/**/
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;"> ';
                                                            echo '</td>';
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">';
                                                                echo '<ul class="nav nav-tabs">';
                                                                echo '<li id="tabSubOs"><a href="#tabItens_'.$d->idOrcamento_item.'" data-toggle="tab">'.
                                                                '<font>Itens</font>'.
                                                                '</a></li>';
                                                                 echo '<li class="active" id="tabDetalhes"><a href="#tabEscopo_'.$d->idOrcamento_item.'" data-toggle="tab">';
                                                                    echo '<font >Peritagem</font>';
                                                                echo '</a></li>';
                                                                echo '<div>';
                                                                    echo '<a onclick="" class="btn btn-mini btn-inverse" href="'.base_url().'index.php/peritagem/escopochecklistimprimir/'.$d->idOrcamento_item.'"><i class="icon-print icon-white"></i>Imprimir Checklist</a>';
                                                                echo '</div>';
                                                                echo '</ul>';
                                                                echo '<div class="tab-content">';
                                                                    echo '<div class="tab-pane active" id="tabEscopo_'.$d->idOrcamento_item.'">';
                                                                        echo '<div class="span12" align="center" style="margin-left:0px">'.
                                                                            '</br>';/*
                                                                            if($this->permission->checkPermission($this->session->userdata('permissao'),'aPeritagem') ){ 
                                                                                echo '<a style = "margin-right:10px"class="btn btn-success" onclick="salvarItens()">Salvar</a>';
                                                                            }
                                                                            if($this->permission->checkPermission($this->session->userdata('permissao'),'aPeritagem') ){
                                                                                echo '<a style = "margin-right:10px"class="btn btn-success" onclick="confirmarItem()">Solicitar Confirmação</a>';
                                                                            }
                                                                            if($this->permission->checkPermission($this->session->userdata('permissao'),'cPeritagem')){
                                                                                echo '<a style = "margin-right:10px" class="btn btn-success" onclick="modelConfirmarFinalizacao()">Finalizar a Peritagem</a>';
                                                                            }*/
                                                                        echo '</div> ';
                                                                        echo '<div id="escopo_' . $contador_local_autocomplete . '">';
                                                                            echo '<h5>Checklist</h5>';
                                                                            echo '<table class="table table-bordered " id="tableEscopo_' . $contador_local_autocomplete . '">' .
                                                                                '<thead>' .
                                                                                '<tr>' .
                                                                                '<th>ITEM </br> COMERCIAL</th>' .
                                                                                '<th>PN</th>' .
                                                                                '<th>DESCRIÇÃO</th>' .
                                                                                '<th>CLASSE</th>' .
                                                                                '<th></th>' .
                                                                                '<th>QTD</th>' .
                                                                                '<th>Ø EXT.</th>' .
                                                                                '<th>Ø INT.</th>' .
                                                                                '<th>COMP.</th>' .
                                                                                '<th>OBS.</th>' .
                                                                                '<th>DES.</th>'.
                                                                                '<th>LAU. FOT.</th>'.
                                                                                '</tr>' .
                                                                                '</thead>' .
                                                                                '<tbody>';

                                                                                foreach ($escopoItens as $r) {
                                                                                    if (!empty($r->idOrcServicoEscopo)) {
                                                                                        $anexoImagens = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao2($r->idOrcServicoEscopoItens,$d->idOrcamento_item);
                                                                                        $getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao2($r->idOrcServicoEscopoItens,$d->idOrcamento_item);
                                                                                        $verifyAnexo = 0;
                                                                                        $verifyAnexoAguardando = 0;
                                                                                        $verifyAnexoPossui = 0;
                                                                                        foreach($getAnexoOrcItem as $k){
                                                                                            if($k->statusAnexo == 1){
                                                                                                $verifyAnexoAguardando = 1;
                                                                                            }
                                                                                            if($k->statusAnexo == 2){
                                                                                                $verifyAnexoPossui = 1;
                                                                                            }
                                                                                        }
                                                                                        if($verifyAnexoAguardando ==1){
                                                                                            $verifyAnexo = 1;
                                                                                        }else if($verifyAnexoPossui ==1){
                                                                                            $verifyAnexo = 2;
                                                                                        }
                                                                                        echo '<tr>' .
                                                                                            '<input type="hidden" name="idOrcEscopo[]" value="' . $d->idOrcamento_item . '">' .
                                                                                            '<input type="hidden" name="idOrcServicoEscopoItens_'.$d->idOrcamento_item.'[]" value="' . $r->idOrcServicoEscopoItens . '">' .
                                                                                            '<input type="hidden" name="tipoCampo_'.$d->idOrcamento_item.'[]" value="' . (!empty($r->tipoCampo)?$r->tipoCampo:"input") . '">' ;
                                                                                            if($r->item_comercial == 1){
                                                                                                echo '<td><input type="checkbox" class="span12" disabled checked></td>';
                                                                                            }else{
                                                                                                echo '<td><input type="checkbox" class="span12" disabled ></td>';
                                                                                            }
                                                                                           echo '<td>' . $r->pn . '</td>' .
                                                                                            '<td>' . $r->descricaoServicoItens . '';
                                                                                            /*
                                                                                            if(!empty($r->tiposServico)){
                                                                                                foreach(json_decode($r->tiposServico) as $h){
                                                                                                    echo '</br><div class="span12"><div class="span8">'. 
                                                                                                        $h->descricaoTiposServico.
                                                                                                    '</div>';
                                                                                                    echo '<div class="span4">'. 
                                                                                                        '<input type="checkbox" name="" id="" value="'.$r->idOrcServicoEscopoItens.'">'.
                                                                                                        '</div>';
                                                                                                    echo '</div>';
                                                                                                }
                                                                                            }*/
                                                                                            echo '</td>' .
                                                                                            '<td>' . $r->descricaoClasse . '</td>';
                                                                                            if($r->tipoCampo == "input" || empty($r->tipoCampo)){
                                                                                                echo '<td></td>';
                                                                                                echo '<td style="width:7%"><input type="text" onblur="salvarEscopoItem('.$r->idOrcServicoEscopoItens.',\'quantidade\',this)" onkeyup="onoffTiposServico('.$r->idOrcServicoEscopoItens.',this)"class="span12 number" '.($d->idStatusPeritagem != 2 && $d->idStatusPeritagem != 5?"readonly":"").' name="quantidade_'.$d->idOrcamento_item.'[]" value="'. $r->quantidade .'"></td>';
                                                                                                echo '<td style="width:7%"><input type="text" onblur="salvarEscopoItem('.$r->idOrcServicoEscopoItens.',\'dimenExt\',this)" class="span12 number" '.($d->idStatusPeritagem != 2 && $d->idStatusPeritagem != 5?"readonly":"").' name="dimenExt_'.$d->idOrcamento_item.'[]" value="'. $r->dimenExt .'"></td>';
                                                                                                echo '<td style="width:7%"><input type="text" onblur="salvarEscopoItem('.$r->idOrcServicoEscopoItens.',\'dimenInt\',this)" class="span12 number" '.($d->idStatusPeritagem != 2 && $d->idStatusPeritagem != 5?"readonly":"").' name="dimenInt_'.$d->idOrcamento_item.'[]" value="'. $r->dimenInt .'"></td>';
                                                                                                echo '<td style="width:7%"><input type="text" onblur="salvarEscopoItem('.$r->idOrcServicoEscopoItens.',\'diminComp\',this)" class="span12 number" '.($d->idStatusPeritagem != 2 && $d->idStatusPeritagem != 5?"readonly":"").' name="dimenComp_'.$d->idOrcamento_item.'[]" value="'. $r->dimenComp .'"></td>';
                                                                                                //echo '<td style="width:7%"><input type="text" class="span12" '.($r->idStatusPeritagem != 2?"readonly":"").' name="obs_'.$d->idOrcamento_item.'[]" value="'. $r->obs .'"></td>';
                
                                                                                            }
                                                                                            if($r->tipoCampo == "check"){
                                                                                                echo '<td style="width:7%"><input onchange="salvarEscopoItem('.$r->idOrcServicoEscopoItens.',\'check\',this)" type="checkbox" '.(!empty($r->checkbox)?"checked":"").' class="span3"name="check_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" value="'.$r->idOrcServicoEscopoItens.'"></td>';
                                                                                                echo '<td></td>';
                                                                                                echo '<td></td>';
                                                                                                echo '<td></td>';
                                                                                                echo '<td></td>';
                                                                                                // echo '<td></td>';
                                                                                                echo '<input type="hidden" class="span12"  name="quantidade_'.$d->idOrcamento_item.'[]" value="'. $r->quantidade .'">';
                                                                                                echo '<input type="hidden" class="span12"  name="dimenExt_'.$d->idOrcamento_item.'[]" value="'. $r->dimenExt .'">';
                                                                                                echo '<input type="hidden" class="span12"  name="dimenInt_'.$d->idOrcamento_item.'[]" value="'. $r->dimenInt .'">';
                                                                                                echo '<input type="hidden" class="span12"  name="dimenComp_'.$d->idOrcamento_item.'[]" value="'. $r->dimenComp .'">';
                                                                                                //echo '<input type="hidden" class="span12"  name="obs_'.$d->idOrcamento_item.'[]" value="'. $r->obs .'">';
                                                                                            }
                                                                                            if($r->tipoCampo == "radio"){                                                                                        
                                                                                                echo '<td style="width:7%"><div><table style="width: 100%;"><tr ><td style="border: 0px;width: 40%;padding-left: 0px;padding-right: 0px;padding-bottom: 0px;padding-top: 0px;">Sim</td><td style="padding: 0px;border: 0px;text-align:center;"> <input type="radio" <input onchange="salvarEscopoItem('.$r->idOrcServicoEscopoItens.',\'radio\',this)" style="width: 20px;height: 20px;vertical-align: middle;" name="radio_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" '.(!empty($r->checkbox)?"checked":"").' value="1"></td></tr><tr><td style="border: 0px;width: 30%;padding-left: 0px;padding-right: 0px;padding-bottom: 0px;padding-top: 0px;">Não</td> <td style="padding: 0px;border: 0px;text-align:center;"><input type="radio" onchange="salvarEscopoItem('.$r->idOrcServicoEscopoItens.',\'radio\',this)" style="width: 20px;height: 20px;vertical-align: middle;" name="radio_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" '.(empty($r->checkbox) || $r->checkbox == 0?"checked":"").' value="0"></td></tr></table></div></td>';
                                                                                                echo '<td ></td>';
                                                                                                echo '<td ></td>';
                                                                                                echo '<td></td>';
                                                                                                echo '<td></td>';
                                                                                                //echo '<td></td>';
                                                                                                echo '<input type="hidden" class="span12"  name="quantidade_'.$d->idOrcamento_item.'[]" value="'. $r->quantidade .'">';
                                                                                                echo '<input type="hidden" class="span12"  name="dimenExt_'.$d->idOrcamento_item.'[]" value="'. $r->dimenExt .'">';
                                                                                                echo '<input type="hidden" class="span12"  name="dimenInt_'.$d->idOrcamento_item.'[]" value="'. $r->dimenInt .'">';
                                                                                                echo '<input type="hidden" class="span12"  name="dimenComp_'.$d->idOrcamento_item.'[]" value="'. $r->dimenComp .'">';
                                                                                                //echo '<input type="hidden" class="span12"  name="obs_'.$d->idOrcamento_item.'[]" value="'. $r->obs .'">';

                                                                                            }
                                                                                            //echo '<td style="width:7%"><input type="text" class="span12" '.($r->idStatusPeritagem != 2?"readonly":"").' name="obs_'.$d->idOrcamento_item.'[]" value="'. $r->obs .'"></td>';
                                                                                            
                                                                                            echo '<td title="'. $r->obs .'"><a onclick="abrirObservacao(' . $r->idOrcServicoEscopoItens. ')" style="margin-right: 3%" class="btn tip-top"><i class="icon-list-alt" id="i_obs_'.$r->idOrcServicoEscopoItens.'" style="color:'.($r->obs?"green":"grey").'"></i></a></td>';
                                                                                            
                                                                                        echo '<td>'.
                                                                                            '<a href="#modal-imagem_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" role="button" data-toggle="modal" style="margin-right: 1%" class="btn tip-top" ><i class="'.($verifyAnexo == 1 ?"fas fa-exclamation-triangle":($verifyAnexo == 2 ?"icon-ok":"icon-ban-circle")).'" style="color:'.($verifyAnexo == 1 ?"orange":($verifyAnexo == 2 ?"green":"grey")).'"></i></a>'.
                                                                                            '<div id="modal-imagem_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                                                '<div class="modal-header">'.
                                                                                                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                                                    '<h5 id="myModalLabel">Desenho PN: '.$r->pn.' | Descrição: '.$r->descricaoServicoItens.'</h5>'.
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
                                                                                                                            '<h5>Anexos </h5>'.
                                                                                                                        '</div>'.
                                                                                                                        '<div class="widget-content nopadding">'.
                                                                                                                            '<div class="span12" id="divProdutosServicos" style=" margin-left: 0">'.
                                                                                                                                '<div class="span12" id="divCadastrarOs">  '.                             
                                                                                                                                    '<div class="widget-box" style="margin-top:0px">' .                                       
                                                                                                                                        '<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">'.
                                                                                                                                            '<thead>'.
                                                                                                                                                '<tr>'.
                                                                                                                                                    '<th>Arquivo</th>'.
                                                                                                                                                    '<th>Status Desenho</th>'.
                                                                                                                                                    '<th></th>'.
                                                                                                                                                    '<th></th>' .            
                                                                                                                                                '</tr>'.
                                                                                                                                            '</thead>'.
                                                                                                                                            '<tbody>';  
                                                                                                                                                foreach($anexoImagens as $anex){
                                                                                                                                                    echo '<tr>';
                                                                                                                                                    echo '<td><a href="' . base_url() .  $anex->caminho . $anex->imagem . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>
                                                                                                                                                    <a href=\'' . base_url() . $anex->caminho . $anex->imagem . '\' target="_blank">' . $anex->nomeArquivo . $anex->extensao . '</a></td>'.
                                                                                                                                                        '<td>' . ($anex->statusAnexo == 1 ? 'Aguardando Verificação' : ($anex->statusAnexo == 2 ? 'Aprovado' : 'Rejeitado')) . '</td>';
                                                                                                                                                        if ($anex->statusAnexo != 1) {
                                                                                                                                                            if($anex->statusAnexo == 2){
                                                                                                                                                                echo '<td></td>';
                                                                                                                                                                echo '<td style="text-align: center;"><a href="#modalReprovar" idAnexo = "' . $anex->idAnexo . '" tipoa = "2" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
                                                                                                    
                                                                                                                                                            }
                                                                                                                                                            if($anex->statusAnexo == 3){
                                                                                                                                                                
                                                                                                                                                                echo '<td style="text-align: center;"><a href="#modalAprovar" idAnexo = "' . $anex->idAnexo . '" tipoa = "1" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                                                                                                                                echo '<td></td>';
                                                                                                                                                                
                                                                                                                                                            }
                                                                                                                                                            
                                                                                                                                                        } else {
                                                                                                                                                            echo '<td style="text-align: center;"><a href="#modalAprovar" idAnexo = "' . $anex->idAnexo . '" tipoa = "1" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                                                                                                                            echo '<td style="text-align: center;"><a href="#modalReprovar" idAnexo = "' . $anex->idAnexo . '" tipoa = "2" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
                                                                                                                                                        }
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
                                                                                                    }                                                                                                                                                                                           
                                                                                                echo '</div>'.
                                                                                            '</div>'. 
                                                                                            '</td>';
                                                                                            $laudoFotografico = $this->peritagem_model->getLaudoFotograficoByIdOrcItemAndIdOrcServEscopo($d->idOrcamento_item,$r->idOrcServicoEscopoItens);
                                                                                            echo '<td>'.
                                                                                                '<a  href="#modal-laudo_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" role="button" data-toggle="modal" style="margin-right: 1%" class="btn tip-top" ><i id="i_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" class="icon-camera" style="color:'.($laudoFotografico?"green":"grey").'"></i></a>'. 
                                                                                                '<div id="modal-laudo_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                                                    '<div class="modal-header">'.
                                                                                                        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                                                        '<h5 id="myModalLabel">Anexo Laudo Fotográfico PN: '.$r->pn.' | Descrição: '.$r->descricaoServicoItens.'</h5>'.
                                                                                                    '</div>'.
                                                                                                    '<div class="modal-body">'.
                                                                                                        '<div class="span12">'./*
                                                                                                            '<div class="span3">'.
                                                                                                                '<label>Nome Arquivo</label>'.
                                                                                                                '<input type="text" class="span12" name="nomeArquivoLaudo_'.$d->idOrcamento_item.'[]" id="nomeArquivoLaudo_'.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'">'.
                                                                                                            '</div>'.*/
                                                                                                            '<div class="span3">'.
                                                                                                                '<label> Arquivo </label>'.
                                                                                                                '<input type="file" onchange="attIconLaudo('.$d->idOrcamento_item.','. $r->idOrcServicoEscopoItens .')" name="imagLaudo_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" id="imagLaudo_'.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'" accept="image/*">'.
                                                                                                                //camera '<input type="file" onchange="attIconLaudo('.$d->idOrcamento_item.','. $r->idOrcServicoEscopoItens .')" name="imagLaudo_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" id="imagLaudo_'.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'" accept="image/*" capture="camera">'.
                                                                                                            '</div>'.
                                                                                                            '<div class="span6">'.
                                                                                                                '<label>Observação</label>'.
                                                                                                                '<textarea name="txtObsLaudo_'.$d->idOrcamento_item.'[]" id="txtObsLaudo_'.$d->idOrcamento_item."_".$r->idOrcServicoEscopoItens.'"class="span12"></textarea>'.
                                                                                                            '</div>'.
                                                                                                            '<div class="span3">'.
                                                                                                                '<a onclick="salvarArquivo(\''.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'\','.$d->idOrcamento_item.','.$r->idOrcServicoEscopoItens.',this)" role="button" data-toggle="modal" style="margin-right: 1%" class="btn btn-success" ><i class="fa fa-plus" style="color:white"></i> Salvar Imagem</a>'.
                                                                                                            '</div>'.
                                                                                                        '</div>';
                                                                                                        
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
                                                                                                                                        '<table class="table table-bordered " id="tableDesenhos_'.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'">'.
                                                                                                                                            '<thead>'.
                                                                                                                                                '<tr>'.
                                                                                                                                                    '<th>Arquivo</th>'.
                                                                                                                                                    '<th>Comentários</th>'.
                                                                                                                                                    '<th>'.
                                                                                                                                                    '</th>'.         
                                                                                                                                                '</tr>'.
                                                                                                                                            '</thead>'.
                                                                                                                                            '<tbody>'; 
                                                                                                                                            if($laudoFotografico){
                                                                                                                                                foreach($laudoFotografico as $k){
                                                                                                                                                echo '<tr>';
                                                                                                                                                    echo '<td>';
                                                                                                                                                        echo '<a href="' . base_url() .  $k->caminho . $k->imagem . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>
                                                                                                                                                        <a href=\'' . base_url() . $k->caminho . $k->imagem . '\' target="_blank">' . $k->nomeArquivo . $k->extensao . '</a>';
                                                                                                                                                    echo '</td>';
                                                                                                                                                    echo '<td>';
                                                                                                                                                        echo $k->comentarios;
                                                                                                                                                    echo '</td>';
                                                                                                                                                    echo '<td>';
                                                                                                                                                    echo '</td>';
                                                                                                                                                echo '</tr>';
                                                                                                                                                }	   
                                                                                                                                            }else{
                                                                                                                                                echo '<tr><td colspan="3" style="text-align: center">Sem imagens anexadas</td></tr>';
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
                                                                                                        
                                                                                                    echo '</div>'. 
                                                                                                '</div>';
                                                                                            echo '</td>';                                                                          
                                                                                        echo'</tr>';
                                                                                        $tipoServico = $this->peritagem_model->getTipoServicoByIdOrcItem($r->idOrcServicoEscopoItens);
                                                                                        
                                                                                        if(!empty($tipoServico)){
                                                                                            
                                                                                            foreach($tipoServico as $h){
                                                                                                echo '<tr class="trneto'.$r->idOrcServicoEscopoItens.'" style="display:'.(!empty($r->quantidade)?"table-row":"none").'">';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;">';
                                                                                                    echo '</td>';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;padding-left: 25px;">';
                                                                                                        echo $h->descricaoTiposServico;
                                                                                                    echo '</td>';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;">';                                                                                                            
                                                                                                    echo '</td>';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;">';
                                                                                                        echo '<input onchange="salvarTipoServico(this)" class="span3" type="checkbox" '.($h->selecionado == 1?"checked":"").' name="tipoServico_'.$r->idOrcServicoEscopoItens.'[]" id="" value="'.$h->idTiposservico_servitem.'">';
                                                                                                    echo '</td>';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;">';                                                                                                            
                                                                                                    echo '</td>';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;">';                                                                                                            
                                                                                                    echo '</td>';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;">';                                                                                                            
                                                                                                    echo '</td>';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;">';                                                                                                            
                                                                                                    echo '</td>';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;">';
                                                                                                        echo '<a onclick="abrirObservacaoServicos(' .$h->idTiposservico_servitem. ')" style="margin-right: 3%" class="btn tip-top"><i class="icon-list-alt" id="i_obs_item_'.$h->idTiposservico_servitem.'" style="color:'.($h->observacao?"green":"grey").'"></i></a>';                                                                                                            
                                                                                                    echo '</td>';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;">';                                                                                                            
                                                                                                    echo '</td>';
                                                                                                    echo '<td style="border-top: 1px solid whitesmoke;">';                                                                                                            
                                                                                                    echo '</td>';
                                                                                                echo '</tr>';
                                                                                            }
                                                                                        }
                                                                                        
                                                                                    }
                                                                                }
                                                                                echo '</tbody>'. 
                                                                                '</table>';
                                                                        echo '</div>';
                                                                        echo '</br>';
                                                                        echo '<div class="span12" style="margin-left:0px">';
                                                                            echo '<label>Observação <a class="btn classdiametro" ">Ø</a></label>'.
                                                                            '<textarea style="width:99%" onblur="salvarEscopo('.$escopo->idOrcServicoEscopo.',this)" name="observacaoEscopo[]">'.$escopo->obs.'</textarea>';
                                                                        echo '</div>';
                                                                        echo '<div class="span12" align="center" style="margin-left:0px">'.
                                                                            '</br>';/*
                                                                            if($this->permission->checkPermission($this->session->userdata('permissao'),'aPeritagem') ){ 
                                                                                echo '<a style = "margin-right:10px"class="btn btn-success" onclick="salvarItens()">Salvar</a>';
                                                                            }
                                                                            if($this->permission->checkPermission($this->session->userdata('permissao'),'aPeritagem') ){
                                                                                echo '<a style = "margin-right:10px"class="btn btn-success" onclick="confirmarItem()">Solicitar Confirmação</a>';
                                                                            }
                                                                            if($this->permission->checkPermission($this->session->userdata('permissao'),'cPeritagem')){
                                                                                echo '<a style = "margin-right:10px" class="btn btn-success" onclick="modelConfirmarFinalizacao()">Finalizar a Peritagem</a>';
                                                                            }*/
                                                                        echo '</div> ';
                                                                    echo '</div>';
                                                                    echo '<div class="tab-pane" id="tabItens_'.$d->idOrcamento_item.'">';                                                                    
                                                                        echo '<div class="row-fluid" style="margin-top:0">'.
                                                                            '<div class="span12">'.
                                                                                '<div class="widget-box">'.
                                                                                    '<div class="widget-title">'.
                                                                                        '<span class="icon">'.
                                                                                            '<i class="icon-tags"></i>'.
                                                                                        '</span>'.
                                                                                        '<h5>Itens do produto</h5>'.
                                                                                    '</div>'.
                                                                                    '<div class="widget-content nopadding">'.
                                                                                        '<div class="span12" id="divProdutosServicos" style=" margin-left: 0">'.
                                                                                            '<div class="tab-content">'.
                                                                                                '<div class="tab-pane active" id="tab1">'.
                                                                                                    '<div class="span12" id="divCadastrarOs">' .                               
                                                                                                        '<div class="widget-box" style="margin-top:0px">   '  .                                   
                                                                                                            '<table id="tableHistVale" class="table table-bordered ">'.
                                                                                                                '<thead>'.
                                                                                                                    '<tr>'.
                                                                                                                        '<th></th>'.
                                                                                                                        '<th>PN</th>'.
                                                                                                                        '<th>DESCRIÇÃO</th>'.
                                                                                                                    '</tr>'.
                                                                                                                '</thead>'.
                                                                                                                '<tbody>';    
                                                                                                                
                                                                                                                //echo json_encode($catalogoitens);

                                                                                                                for($l = 0;$l<count($catalogoitens);$l++){
                                                                                                                    echo '<tr class="trneto'.$catalogoitens[$l]->idCatalogoProdutoItens.'">'.
                                                                                                                        '<td onclick="openclose2(this,'.$catalogoitens[$l]->idCatalogoProdutoItens.')"  style=" width: 20px;text-align: center;  display: table-cell;min-height: 10em;vertical-align: middle;"><a class="detail-icon"><i class="fa fa-plus"></i></a></td>'.
                                                                                                                        '<td>'.$catalogoitens[$l]->pn.'</td>'.
                                                                                                                        '<td>'.$catalogoitens[$l]->descricao.'</td>'.
                                                                                                                        '<input type="hidden" name="idCatalogoItensNovosItens[]" value="'.$catalogoitens[$l]->idCatalogoProdutoItens.'">'.
                                                                                                                        '<input type="hidden" name="idOrcEscopoNovosItens[]" value="'.$escopo->idOrcServicoEscopo.'">'.
                                                                                                                    '</tr>';

                                                                                                                    echo '<tr class="trbisneto'.$catalogoitens[$l]->idCatalogoProdutoItens.'" style="display:none">';
                                                                                                                        echo '<td></td>';
                                                                                                                        echo '<td colspan="2">';
                                                                                                                        
                                                                                                                        echo '<script>console.log('.json_encode($catalogoitens).')</script>';
                                                                                                                            $catalogoEscopoItens = $this->peritagem_model->itensPeritagemIdProduto($escopo->idOrcServicoEscopo,$catalogoitens[$l]->idProdutos);
                                                                                                                            echo '<div>';                                                                                                                                   
                                                                                                                                echo '<div class="row-fluid" style="margin-top:0">';
                                                                                                                                    echo '<div class="span12" style="margin-left:0px;text-align:center">';
                                                                                                                                        echo '<a onclick="adicionarItemCheckList(' . $catalogoitens[$l]->idCatalogoProdutoItens . ',' . $escopo->idOrcServicoEscopo . ');" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Item Checklist</a>';
                                                                                                                                    echo '</div>';
                                                                                                                                    
                                                                                                                                    echo '<div class="span12" style="margin-left:0px">';
                                                                                                                                        echo '<div class="widget-box">';
                                                                                                                                            echo '<div class="widget-title">';
                                                                                                                                                echo '<span class="icon">';
                                                                                                                                                    echo '<i class="icon-tags"></i>';
                                                                                                                                                echo '</span>';
                                                                                                                                                echo '<h5>Itens do Checklist </h5>';
                                                                                                                                            echo '</div>';
                                                                                                                                            echo '<div class="widget-content nopadding">';					
                                                                                                                                                echo '<div class="tab-content">';						
                                                                                                                                                    echo '<div class="span12" id="divCadastrarOs">';   
                                                                                                                                                        echo '<table id="tableCheck_'.$catalogoitens[$l]->idCatalogoProdutoItens.'" class="table table-bordered ">';
                                                                                                                                                            echo '<thead>';
                                                                                                                                                                echo '<tr>';
                                                                                                                                                                    echo '<th>PN</th>';
                                                                                                                                                                    echo '<th>Descrição</th>';
                                                                                                                                                                    echo '<th>Classe</th>';
                                                                                                                                                                    echo '<th>Excluir</th>';
                                                                                                                                                                echo '</tr>';
                                                                                                                                                            echo '</thead>';
                                                                                                                                                            echo '<tbody>';
                                                                                                                                                                foreach($catalogoEscopoItens as $m){
                                                                                                                                                                    echo '<tr>';
                                                                                                                                                                        echo '<td>'.$m->pn.'</td>';
                                                                                                                                                                        echo '<td>'.$m->descricaoServicoItens.'</td>';
                                                                                                                                                                        echo '<td>'.$m->nomeClasse.'</td>';
                                                                                                                                                                        echo '<td></td>';
                                                                                                                                                                    echo '</tr>';  
                                                                                                                                                                }  /**/                                                                             
                                                                                                                                                            echo '</tbody>';
                                                                                                                                                        echo '</table>';
                                                                                                                                                    echo '</div>';
                                                                                                                                                echo '</div>';
                                                                                                                                            echo '</div>';   
                                                                                                                                        echo '</div>';
                                                                                                                                    echo '</div>';
                                                                                                                                    echo '<div class="span12" style="margin-left:0px;text-align:center">';
                                                                                                                                        echo '<a onclick="adicionarItemCheckList(' . $catalogoitens[$l]->idCatalogoProdutoItens . ',' . $escopo->idOrcServicoEscopo . ');" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Item Checklist</a>';
                                                                                                                                    echo '</div>';
                                                                                                                                echo '</div>';
                                                                                                                            echo '</div>';
                                                                                                                        echo '</td>';
                                                                                                                    echo '</tr>';
                                                                                                                }

                                                                                                                echo '</tbody>'.
                                                                                                            '</table>'.
                                                                                                        '</div> '.                               
                                                                                                    '</div>'.
                                                                                                '</div>'.
                                                                                            '</div>'.
                                                                                        '</div>'.
                                                                                    '</div>'.
                                                                                '</div>'.
                                                                            '</div> ' .  
                                                                        '</div>';
                                                                        echo '<div style="text-align:center">';
                                                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'aPeritagem') ){ 
                                                                            //echo '<button id="salvarChecklist" name="salvarChecklist" value="salvarChecklist" style="margin-right:10px"class="btn btn-success" >Salvar</button>';
                                                                        }
                                                                        echo '</div>';
                                                                    echo '</div>';
                                                                 echo '</div>';
                                                            echo '</td>'; 
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">';
                                                                if ($d->tipoOrc == 'serv') {
                                                                    echo '<a href="' . base_url() . 'index.php/peritagem/laudofotografico/' . $d->idOrcamento_item . '" role="button" data-toggle="modal" class="btn btn-warning"  class="span12" style="/*margin-right: 10px;*/ margin-bottom: 10px;">Laudo Fotográfico</a>';
                                                                }
                                                            echo '</td>';
                                                            
                                                        echo '</tr>';
                                                    }
                                                    
                                                    $contador_local_autocomplete++;
                                                }
                                                ?>	
                                                <input type="hidden" name="idOrcItemRedirect" value="<?php echo $itens;?>">							
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
    <div align='center'>    
        </br> 
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aPeritagem') ){ ?>
            <a class="btn btn-success" onclick="salvarItens()">Salvar</a>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aPeritagem') ){ ?>
            <a class="btn btn-success" onclick="confirmarItem()">Solicitar Confirmação</a>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPeritagem')){ ?>
            <a class="btn btn-success" onclick="modelConfirmarFinalizacao()">Finalizar a Peritagem</a>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPeritagem')){ ?>
            <a class="btn btn-danger" onclick="modelReprovarPeritagem()">Reprovar Peritagem</a>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPeritagem')){ ?>
            <a class="btn btn-warning" onclick="modelReavaliarDesenho()">Sol. Reavaliação Desenho</a>
        <?php } ?>
    </div> 
</form>
<?php

?>
<div id="modal-anexodesenho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/desenho/reprovardesenho" method="post" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Anexo desenho</h5>
            <input type="hidden" name="idOrcItemRedirect" value="<?php echo $itens;?>">	
        </div>
        <div class="modal-body">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">
                                            <div class="widget-box" style="margin-top:0px">
                                                <input id="idAnexo3" name="idAnexo3" value="" type="hidden">
                                                <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                                    <thead>
                                                        <tr>
                                                            <th>Arquivo</th>
                                                            <th>Proprietário</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            foreach($anexoDesenho as $r){
                                                                if($r->statusAnexo == 2){
                                                                    echo '<tr>'; ?>
                                                                        <td><a href='<?php echo base_url().$r->caminho.$r->imagem;?>' id="aAprovar2" target="_blank"><?php echo  $r->nomeArquivo .'.'. $r->extensao;?> </a></td><?php 
                                                                        echo '<td>'.$r->nome.'</td>';
                                                                    echo '</tr>';
                                                                }                                                                
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
        </div><!--
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success">Adicionar</button>
        </div> -->
    </form>
</div>

<div id="modelFinalizar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/peritagem/finalizarPeritagem"  enctype="multipart/form-data" method="post" class="form-horizontal">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Confirmar fim da Peritagem</h5>
            <input type="hidden" name="idOrcamento2" value="<?php echo $orcam->idOrcamentos; ?>">
            <input type="hidden" name="idOrcItemRedirect" value="<?php echo $itens;?>">	
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">Deseja realmente finalizar está peritagem?</h5>
            <p style="text-align: center">(Certifique-se de que as alterações da peritagem foram salvas.)</p>
            <p style="text-align: center">(Após a confirmação não será possivel alterar as informações dessa peritagem sem a autorização do comercial.)</p>
            <div class="row-fluid" style="margin-top:0px">
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
                                    <div class="widget-box" style="margin-top:0px">                                        
                                        <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>PN</th>
                                                    <th>Orç.</th>
                                                    <th>Tipo de prod.</th>
                                                    <th>Descrição</th>  
                                                    <th>TAG</th>   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($orcItem as $r){
                                                    echo ' <tr>';
                                                    if($r->tipoOrc == "serv" && (($r->tipoProd == "cil" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemCil')) || ($r->tipoProd == "maq" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemMaq')) || ($r->tipoProd == "sub" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemSub')) || ($r->tipoProd == "pec" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemPec')))){
                                                        $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($r->idOrcamento_item);
                                                        if($r->idStatusPeritagem == 4){
                                                            echo '<td><input type="checkbox" '.($r->idStatusPeritagem == 4?"checked disabled":"").' value="'.$escopo->idOrcServicoEscopo.'"></td>';
                                                        }else if($r->idStatusPeritagem == 2 || $r->idStatusPeritagem == 3){
                                                            echo '<td><input type="checkbox"  name="idOrcServEscopo[]" value="'.$escopo->idOrcServicoEscopo.'"></td>';
                                                        }else{
                                                            echo '<td></td>';
                                                        }
                                                        
                                                    }else{
                                                        echo '<td></td>';
                                                    }
                                                    echo '<td>'.$r->pn.'</td>';
                                                    echo '<td>'.$r->tipoOrc.'</td>';
                                                    echo '<td>'. ($r->tipoProd == 'cil'? "Cilindro":($r->tipoProd == 'maq'?"Máquina":($r->tipoProd == 'pec'?"Peça":($r->tipoProd == 'sub'?"Subconjunto":"")))).'</td>';
                                                    echo '<td>'.$r->descricao_item.'</td>';   
                                                    echo '<td>'.$r->tag.'</td>';   
                                                    echo '</tr>';
                                                } ?>
                                                                                                                                     
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
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>



<div id="model-confirmacao" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/peritagem/solicitarconfirmacao"  enctype="multipart/form-data" method="post" class="form-horizontal">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
  
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Solicitar confirmação</h5>
            <input type="hidden" name="idOrcamento2" value="<?php echo $orcam->idOrcamentos; ?>">
            <input type="hidden" name="idOrcItemRedirect" value="<?php echo $itens;?>">	
        </div>
        <div class="modal-body"><!--
            <h5 style="text-align: center">Deseja realmente finalizar está peritagem?</h5>
            <p style="text-align: center">(Certifique-se de que as alterações da peritagem foram salvas.)</p>
            <p style="text-align: center">(Após a confirmação não será possivel alterar as informações dessa peritagem sem a autorização do comercial.)</p> -->
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
                                    <div class="widget-box" style="margin-top:0px">                                        
                                        <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>PN</th>
                                                    <th>Orç.</th>
                                                    <th>Tipo de prod.</th>
                                                    <th>Descrição</th>  
                                                    <th>TAG</th>   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($orcItem as $r){
                                                    echo ' <tr>';
                                                    if($r->tipoOrc == "serv" && (($r->tipoProd == "cil" && 
                                                    $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemCil')) || ($r->tipoProd == "maq" && 
                                                    $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemMaq')) || ($r->tipoProd == "sub" && 
                                                    $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemSub')) || ($r->tipoProd == "pec" && 
                                                    $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemPec')))){
                                                        $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($r->idOrcamento_item);
                                                        if($r->idStatusPeritagem == 4 || $r->idStatusPeritagem == 3){
                                                            echo '<td><input type="checkbox" checked disabled value="'.$escopo->idOrcServicoEscopo.'"></td>';
                                                        }else if($r->idStatusPeritagem == 2 || $r->idStatusPeritagem == 5){
                                                            echo '<td><input type="checkbox" name="idOrcServEscopo[]" value="'.$escopo->idOrcServicoEscopo.'"></td>';
                                                        }else{
                                                            echo '<td></td>';
                                                        }
                                                        
                                                    }else{
                                                        echo '<td></td>';
                                                    }
                                                    echo '<td>'.$r->pn.'</td>';
                                                    echo '<td>'.$r->tipoOrc.'</td>';
                                                    echo '<td>'. ($r->tipoProd == 'cil'? "Cilindro":($r->tipoProd == 'maq'?"Máquina":($r->tipoProd == 'pec'?"Peça":($r->tipoProd == 'sub'?"Subconjunto":"")))).'</td>';
                                                    echo '<td>'.$r->descricao_item.'</td>';   
                                                    echo '<td>'.$r->tag.'</td>';   
                                                    echo '</tr>';
                                                } ?>
                                                                                                                                     
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
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>

<div id="model-recusar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/peritagem/recusarperitagem"  enctype="multipart/form-data" method="post" class="form-horizontal">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
  
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Recusar Peritagem</h5>
            <input type="hidden" name="idOrcamento2" value="<?php echo $orcam->idOrcamentos; ?>">
            <input type="hidden" name="idOrcItemRedirect" value="<?php echo $itens;?>">	
        </div>
        <div class="modal-body"><!--
            <h5 style="text-align: center">Deseja realmente finalizar está peritagem?</h5>
            <p style="text-align: center">(Certifique-se de que as alterações da peritagem foram salvas.)</p>
            <p style="text-align: center">(Após a confirmação não será possivel alterar as informações dessa peritagem sem a autorização do comercial.)</p> -->
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
                                    <div class="widget-box" style="margin-top:0px">                                        
                                        <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>PN</th>
                                                    <th>Orç.</th>
                                                    <th>Tipo de prod.</th>
                                                    <th>Descrição</th>  
                                                    <th>TAG</th>   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($orcItem as $r){
                                                    echo ' <tr>';
                                                    if($r->tipoOrc == "serv" && (($r->tipoProd == "cil" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemCil')) || ($r->tipoProd == "maq" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemMaq')) || ($r->tipoProd == "sub" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemSub')) || ($r->tipoProd == "pec" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemPec')))){
                                                        $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($r->idOrcamento_item);
                                                        if($r->idStatusPeritagem == 4 || $r->idStatusPeritagem == 3){
                                                            echo '<td><input type="checkbox"  name="idOrcServEscopo[]" value="'.$escopo->idOrcServicoEscopo.'"></td>';
                                                        }else{
                                                            echo '<td></td>';
                                                        }
                                                        
                                                    }else{
                                                        echo '<td></td>';
                                                    }
                                                    echo '<td>'.$r->pn.'</td>';
                                                    echo '<td>'.$r->tipoOrc.'</td>';
                                                    echo '<td>'.($r->tipoProd == 'cil'? "Cilindro":($r->tipoProd == 'maq'?"Máquina":($r->tipoProd == 'pec'?"Peça":($r->tipoProd == 'sub'?"Subconjunto":"")))).'</td>';
                                                    echo '<td>'.$r->descricao_item.'</td>';   
                                                    echo '<td>'.$r->tag.'</td>';   
                                                    echo '</tr>';
                                                } ?>
                                                                                                                                     
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
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>

<div id="modal-justificativa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><!--
    <form action="<?php echo base_url() ?>index.php/peritagem/observacao" method="post" id="formObservacoes">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
 -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="h5Observacao" >Adicionar Observacao</h5>
            <input type="hidden" name="idOrcItemRedirect" value="<?php echo $itens;?>">	
        </div>
        <div class="modal-body">           
            <div class="span12" style="margin-left:0px;text-align:center">
                <h5 id="h5Observacao2"></h5>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span12">
                    <label>Observações<a class="btn classdiametro">Ø</a></label>
                    <textarea name="modelObservacao" id="modelObservacao" class="span12" style="resize:none;height: 150px;"></textarea>
                    <input type="hidden" name="modelIdOrcServEscItem" id="modelIdOrcServEscItem" value="">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" onclick="finalizarObservacao()">Adicionar </a>
        </div><!--
        <div class="modal-body" style="padding:0px">
            <div class="span12">
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box" style="margin-top:0px">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-list-alt"></i>
                                </span>
                                <h5>Histórico de Observações</h5>
                            </div>
                            <div class="widget-content nopadding" >
                                <div id="vObservacao" style="margin:35px;word-wrap: break-word">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>--><!--
    </form>-->
</div>

<div id="modal-justificativa2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><!--
    <form action="<?php echo base_url() ?>index.php/peritagem/observacao" method="post" id="formObservacoes">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
 -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="h5Observacao3_1" >Adicionar Observacao</h5>
            <input type="hidden" name="idOrcItemRedirect" value="<?php echo $itens;?>">	
        </div>
        <div class="modal-body">           
            <div class="span12" style="margin-left:0px;text-align:center">
                <h5 id="h5Observacao3"></h5>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span12">
                    <label>Observações<a class="btn classdiametro">Ø</a></label>
                    <textarea name="modelObservacao2" id="modelObservacao2" class="span12" style="resize:none;height: 150px;"></textarea>
                    <input type="hidden" name="modelIdTipoServico" id="modelIdTipoServico" value="">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" onclick="finalizarObservacaoServico()">Adicionar </a>
        </div><!--
    </form>-->
</div>

<div id="modal-editarpn" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/peritagem/solicitarAlteracaoPN" method="post" id="formEditarPN">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="h5Observacao" >Editar PN</h5>
            <input type="hidden" name="idOrcItemRedirect" value="<?php echo $itens;?>">	
        </div>
        <div class="modal-body">
            <div class="span12" style="margin-left:0px">
                <div class="span12">
                    <h5>Informações Atuais</h5>
                </div>
                <div class="span2">
                    <label>Orçamento</label>                
                    <input readonly class="span12" type="text" name="orcamentoEditarPN" id="orcamentoEditarPN" value="">
                </div>
                <div class="span2">
                    <label>PN Atual</label>                
                    <input readonly class="span12" type="text" name="pnAtual" id="pnAtual" value="">
                </div>
                <div class="span4">
                    <label>Descrição</label>                
                    <input readonly class="span12" type="text" name="descricaoEditarPN" id="descricaoEditarPN" value="">
                </div>
            </div>
            <div class="span12" style="margin-left:0px">
                <div class="span12">
                    <h5>Novas Informações</h5>
                </div>
                <div class="span2">
                    <label>Orçamento</label>                
                    <input readonly class="span12" type="text" name="orcamentoEditarPN2" id="orcamentoEditarPN2" value="">
                    <input readonly class="span12" type="hidden" name="orcamentoItemEditarPN2" id="orcamentoItemEditarPN2" value="">
                </div>
                <div class="span2">
                    <label>PN Novo</label>                
                    <input class="span12" type="text" name="pnNovoeditar" id="pnNovoeditar" value="">
                    <input class="span12" type="hidden" name="idProdNovoeditar" id="idProdNovoeditar" value="">
                </div>
                <div class="span4">
                    <label>Descrição</label>                
                    <input readonly class="span12" type="text" name="descricaoEditarPN2" id="descricaoEditarPN2" value="">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <a class="btn btn-success" onclick="finalizarAlteracaoPN()">Adicionar </a>
        </div>
    </form>
    
</div>

<div id="model-reavaliacaodesenho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/peritagem/reavaliacaodesenho"  enctype="multipart/form-data" method="post" class="form-horizontal">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
  
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Solicitar reavaliação desenho</h5>
            <input type="hidden" name="idOrcamento2" value="<?php echo $orcam->idOrcamentos; ?>">
            <input type="hidden" name="idOrcItemRedirect" value="<?php echo $itens;?>">	
        </div>
        <div class="modal-body"><!--
            <h5 style="text-align: center">Deseja realmente finalizar está peritagem?</h5>
            <p style="text-align: center">(Certifique-se de que as alterações da peritagem foram salvas.)</p>
            <p style="text-align: center">(Após a confirmação não será possivel alterar as informações dessa peritagem sem a autorização do comercial.)</p> -->
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
                                    <div class="widget-box" style="margin-top:0px">                                        
                                        <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>PN</th>
                                                    <th>Orç.</th>
                                                    <th>Tipo de prod.</th>
                                                    <th>Descrição</th>  
                                                    <th>TAG</th>   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($orcItem as $r){
                                                    echo ' <tr>';
                                                    if($r->tipoOrc == "serv" && (($r->tipoProd == "cil" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemCil')) || ($r->tipoProd == "maq" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemMaq')) || ($r->tipoProd == "sub" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemSub')) || ($r->tipoProd == "pec" && 
                                                        $this->permission->checkPermission($this->session->userdata('permissao'),'peritagemPec')))){
                                                        $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($r->idOrcamento_item);
                                                         if($r->idStatusPeritagem == 2 || $r->idStatusPeritagem == 3  || $r->idStatusPeritagem == 7){
                                                            echo '<td><input type="checkbox"  name="idOrcServEscopo[]" value="'.$escopo->idOrcServicoEscopo.'"></td>';
                                                        }else{
                                                            echo '<td></td>';
                                                        }
                                                        
                                                    }else{
                                                        echo '<td></td>';
                                                    }
                                                    echo '<td>'.$r->pn.'</td>';
                                                    echo '<td>'.$r->tipoOrc.'</td>';
                                                    echo '<td>'. ($r->tipoProd == 'cil'? "Cilindro":($r->tipoProd == 'maq'?"Máquina":($r->tipoProd == 'pec'?"Peça":($r->tipoProd == 'sub'?"Subconjunto":"")))).'</td>';
                                                    echo '<td>'.$r->descricao_item.'</td>';   
                                                    echo '<td>'.$r->tag.'</td>';   
                                                    echo '</tr>';
                                                } ?>
                                                                                                                                     
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
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#pnNovoeditar").autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
            minLength: 1,
            select: function( event, ui ) {
                $('#idProdNovoeditar').val(ui.item.id);
                $('#descricaoEditarPN2').val(ui.item.produtos);
            }
        });
    });
    $('.classdiametro').click(function(e){
        insereSinal( $(e.target).parent().next()[0] ,e.target.textContent);
    });
    $(function(){
        $(".number").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });
    function onoffTiposServico(idOrcItem, item){
        if(item.value != "" && item.value != 0){
            $(".trneto" + idOrcItem).show('fast');
        }else{
            $(".trneto" + idOrcItem).hide('fast');
        }
    }
    function deleteRow3(i,pos){
        document.getElementById("tableCheck_" + pos).deleteRow(i);
    }

    function adicionarItemCheckList(pos,escopo) {
        var table = document.getElementById("tableCheck_" + pos).getElementsByTagName('tbody')[0];
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/getinfocatalogoitem",
            dataType: 'json',
            type: 'POST',
            data:{
                idCatalogoItem:pos
            },
            success: function(data2) {
                $("#tableCheck_" + pos).children("tbody").append( '<tr><td style="width:200px"><input readonly type="text" class="span12 novoEscopoPN" name="novoEscopoPN_' + pos + '[]" id="novoEscopoPN_' + pos + '_' + numOfRows + '" value="'+data2.produto.pn+'"><input type="hidden" class="span12 novoEscopoidProd" name="novoEscopoIdProduto_' + pos + '[]" id="novoEscopoIdProduto_' + pos + '_' + numOfRows + '" value="'+data2.produto.idProdutos+'"></td><td><input type="text" class="span12 novoEscopoDescProd" name="novoEscopoDescProd_' + pos + '[]" id="novoEscopoDescProd_' + pos + '_' + numOfRows + '" value="'+data2.produto.descricao+'"></td><td><select class="span12 novoEscopoClasse" name="selectClasse_'+pos+'[]"> <option value="">Selecione</option> <option value="1">Serviço</option><option value="2">Fabricação</option></select> </td><td style="width:70px"><button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow3(this.parentNode.parentNode.rowIndex,'+pos+')"><font size=1>Excluir</font></button></td></tr>');
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

    function editarpn(idOrcitem){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/getinfoorcitem",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idOrcitem: idOrcitem
            },
            success: function(data){
                if(data.result){
                    abrirmodaleditarpn(data.obj);
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

    function abrirmodaleditarpn(item){
        $("#pnAtual").val(item.pn);
        $("#orcamentoEditarPN").val(item.idOrcamentos);
        $("#descricaoEditarPN").val(item.descricao_item);
        $("#orcamentoEditarPN2").val(item.idOrcamentos);
        $("#orcamentoItemEditarPN2").val(item.idOrcamento_item);
        $("#modal-editarpn").modal("show");
    }

    function finalizarAlteracaoPN(){
        var idOrcItem = $("#orcamentoItemEditarPN2").val()
        var pn = $("#pnNovoeditar").val()
        var idProd = $("#idProdNovoeditar").val()

        if(idProd == "" || idProd == null){
            alert("Informe e selecione um PN válido")
            return;
        }

        $("#formEditarPN").submit();
        
    }
    function salvarEscopoItem(id,campo,inputCampo){
        var valor = 0
        if(campo == "check"){
            if(inputCampo.checked == true){
                valor = 1;
            }else{
                valor = 0;
            }
        }else if(campo == "radio"){
            valor = $('input[name='+inputCampo.name+']:checked').val()
        }else{
            valor = inputCampo.value;
        }
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/salvaritemescopoorc",
            type: 'POST',
            dataType: 'json',
            async:false,
            data:{
                id:id,
                campo:campo,
                valor:valor
            },
            success: function(data2) {
            },
            error: function(xhr, textStatus, error) {
                window.location.herf = "<?php echo base_url();?>mapos/login"
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }
    function insereSinal(cId, sinal){
        var cam = $(cId)[0];
        var cvl = $(cam).val();
        var cps = cam.selectionStart;
        var ini = cvl.substring(0, cps);
        var fim = cvl.substring(cps, cvl.length);
        $(cam).val(ini+sinal+fim);
        cps += sinal.length;
        cam.selectionStart = cam.selectionEnd = cps;
        cam.focus();
    }
    function salvarEscopo(id,inputCampo){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/salvarobsescopoorc",
            type: 'POST',
            dataType: 'json',
            async:false,
            data:{
                id:id,
                valor:inputCampo.value
            },
            success: function(data2) {
            },
            error: function(xhr, textStatus, error) {
                window.location.herf = "<?php echo base_url();?>mapos/login"
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function salvarTipoServico(input){
        var selecionado = 0;
        if(input.checked){
            selecionado = 1;
        }
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/salvartiposervico",
            type: 'POST',
            dataType: 'json',
            async:false,
            data:{
                id:input.value,
                selecionado:selecionado
            },
            success: function(data2) {
            },
            error: function(xhr, textStatus, error) {
                window.location.herf = "<?php echo base_url();?>mapos/login"
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
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
    function openclose2(td, valor) {

        var tr = document.querySelector(".trbisneto" + valor);
        if (tr.style.display == "table-row" || tr.style.display == "") {
            $(".trbisneto" + valor).hide('fast');
            $(td).parent('tr').css('background-color', '');
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");
        } else {
            $(".trbisneto" + valor).show('fast');
            $(td).parent('tr').css('background-color', '#efefef');
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }
    }
    function salvarItens(){
        var descricao = Array.apply(null,document.querySelectorAll(".novoEscopoDescProd"))
        var classe = Array.apply(null,document.querySelectorAll(".novoEscopoClasse"))
        if(descricao.length >0){
            for(var x = 0; x < descricao.length; x++){
                if(descricao[x].value == "" || descricao[x].value  == null){
                    alert("Preencha a descricao corretamente.")
                    return;
                }
                if(classe[x].value  == "" || classe[x].value  == null || classe[x].value  == 0){
                    alert("Selecione a classe do produto.")
                    return;
                }
            }
        }
        $("#formPeritag").submit();
    }
    function modelConfirmarFinalizacao(){
        $('#modelFinalizar').modal('show');
    }
    function confirmarItem(){
        $('#model-confirmacao').modal('show');
    }
    function salvarArquivo(pos,idOrcItem,idOrcSerItem,inputCampo){
        inputCampo.style.display="none";
        var file_data = document.getElementById('imagLaudo_'+pos);   
        var form_data = new FormData();                
        var comentario = document.querySelector("#txtObsLaudo_"+pos).value;  
        form_data.append('file', file_data.files[0]);
        form_data.append('idOrcSerItem', idOrcSerItem);
        form_data.append('idOrcItem', idOrcItem);
        form_data.append('comentario', comentario);/**/
        if( !file_data.files[0]){
            inputCampo.style.display="inline-block";
            alert("Informe um arquivo válido.");
            return;
        }/*
        form_data.append('nomeArquivo', valueNome);*/
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/salvarlaudo3",
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            data:form_data ,
            success: function(data2) {
                alert("Laudo anexado com sucesso.");
                //document.querySelector("#nomeArquivoLaudo_"+pos).value = "";
                inputCampo.style.display="inline-block";
                $("#imagLaudo_"+pos).val(null); 
                document.querySelector("#txtObsLaudo_"+pos).value = "";
                atualizarTabelaAnexo(pos,data2.data)
            },
            error: function(xhr, textStatus, error) {
                inputCampo.style.display="inline-block";
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
        
    }
    function atualizarTabelaAnexo(pos,anexos){
        if(anexos.length >0 ){
            $('#tableDesenhos_'+pos+' tbody').empty();
            html = "";
            for(x=0;x<anexos.length;x++){
                 html += '<tr>'+
                    '<td>'+
                    '<a href="<?php echo base_url();?>' + anexos[x].caminho + anexos[x].imagem + '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>'+
                    '<a href="<?php echo base_url();?>' + anexos[x].caminho + anexos[x].imagem + '" target="_blank">' + anexos[x].nomeArquivo + anexos[x].extensao + '</a>'+
                    '</td>'+
                    '<td>'+
                    anexos[x].comentarios+
                    '</td>'+
                    '<td>'+
                    '</td>'+
                '</tr>';
            }
            $('#i_'+pos).css('color','green');
            $('#tableDesenhos_'+pos+' tbody').append(html);
        }else{
            $('#i_'+pos).css('color','grey');
        }
    }
    function abrirObservacao(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/getInfoOrcServEscItem",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idOrcSerItem: id
            },
            success: function(data) {
                atualizarModalObservacao(data.resultado);
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
    function atualizarModalObservacao(item) {
        //$("#idDistribuir").val(item.idDistribuir);
        //$("#histJustficativa").val(item.justificativa);
        $("#h5Observacao2").empty();
        $("#modelObservacao").empty();
        $("#modelIdOrcServEscItem").val("");
        $("#h5Observacao2").append("A observação será vinculada a este item: PN "+(item.pn?item.pn:"")+" - "+item.descricaoServicoItens);
        $("#modelIdOrcServEscItem").val(item.idOrcServicoEscopoItens);
        $("#h5Observacao").empty();
        $("#h5Observacao").append("Adicionar Observacao - Orçamento: "+item.idOrcamentos+" - "+item.descricao_item);
        $("#modelObservacao").val(item.obs);
        $("#modal-justificativa").modal('show');
    }

    function finalizarObservacao(){
        var idOrcServItem = document.querySelector("#modelIdOrcServEscItem").value;
        var obs = document.querySelector("#modelObservacao").value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/adicionarObservacao",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idOrcSerItem: idOrcServItem,
                obs: obs
            },
            success: function(data) {
                alert("Observação adicionada com sucesso.");
                if(data.vazio){
                    $('#i_obs_'+data.idOrcEscopoItens).css('color','grey');
                }else{
                    $('#i_obs_'+data.idOrcEscopoItens).css('color','green');
                }
                

                $("#modal-justificativa").modal('hide');
            },
            error: function(xhr, textStatus, error) {
                alert("Houve um erro no sistema. Tente novamente.")
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function abrirObservacaoServicos(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/getInfoTipoServico",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idOrcSerItem: id
            },
            success: function(data) {
                atualizarModalObservacaoServicos(data.obj);
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

    function atualizarModalObservacaoServicos(item){
        $("#h5Observacao3").empty();
        $("#modelObservacao2").empty();
        $("#modelIdOrcServEscItem").val("");
        $("#h5Observacao3").append("A observação será vinculada a este item:  "+item.descricaoServicoItens+" - "+item.descricaoTiposServico);
        $("#modelIdTipoServico").val(item.idTiposservico_servitem);
        $("#h5Observacao3_1").empty();
        $("#h5Observacao3_1").append("Adicionar Observacao - Orçamento: "+item.idOrcamentos+" - "+item.descricao_item);
        $("#modelObservacao2").val(item.observacao);
        $("#modal-justificativa2").modal('show');
    }

    function finalizarObservacaoServico(){
        var idOrcServItem = document.querySelector("#modelIdTipoServico").value;
        var obs = document.querySelector("#modelObservacao2").value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/peritagem/adicionarObservacaoServico",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idOrcSerItem: idOrcServItem,
                obs: obs
            },
            success: function(data) {
                alert("Observação adicionada com sucesso.");
                if(data.vazio){
                    $('#i_obs_item_'+data.idTiposservico_servitem).css('color','grey');
                }else{
                    $('#i_obs_item_'+data.idTiposservico_servitem).css('color','green');
                }
                

                $("#modal-justificativa2").modal('hide');
            },
            error: function(xhr, textStatus, error) {
                alert("Houve um erro no sistema. Tente novamente.")
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }

    function modelReprovarPeritagem(){
        $('#model-recusar').modal('show'); 
    }

    function modelReavaliarDesenho(){
        $('#model-reavaliacaodesenho').modal('show'); 
    }
    $(document).ready( function () {
        $('#tablePeritagem').DataTable({
            'columnDefs': [ { // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
            }],
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
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Seguinte",
                    "sPrevious": "Anterior"
                }
            }
        });
        
    });
</script>