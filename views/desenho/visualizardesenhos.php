<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Adicionar Desenhos</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                        <input type="text" class="span12" value="<?php echo $orcam->idOrcamentos; ?>" readonly />
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
<form action="<?php echo base_url() ?>index.php/desenho/finalizar"    method="post" name="formFinalizar" id="formFinalizar">

    <input type="hidden" name="idOrcamentoSalvar" class="span12" value="<?php echo $orcam->idOrcamentos; ?>" readonly />
    <div align='center'>
        </br>
        <a type="button" onclick="verificarCamposPreenchidos()" name="btnSalvar" value = "btnSalvar" class="btn btn-success"><i class="icon-plus icon-white"></i> Salvar</a>
        <a type="button" onclick="modelConfirmarFinalizacao()" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success"><i class="icon-plus icon-white"></i> Finalizar</a>
        <a  onclick="modelReavalicaoDesenho()" name="" value = "btnGerarCotacao" class="btn btn-warning"><i class="icon-plus icon-white"></i> Retornar ao Desenho</a>
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
                                                foreach($result as $d){
                                                    if(empty($itens)){
                                                        $itens = $d->idOrcamento_item;
                                                    }else{
                                                        $itens = $itens."_".$d->idOrcamento_item;
                                                    }
                                                    if($d->tipoOrc == 'serv'){
                                                        $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($d->idOrcamento_item);
                                                    }
                                                    echo '<tr class="trpai'.$d->idOrcamento_item.$d->idOs.'">';
                                                        //if($d->statusDesenho == 1 || $d->statusDesenho == 2){
                                                            echo '<td onclick="openclose(this,'.$d->idOrcamento_item.$d->idOs.')"  style="text-align: center; /* padding: 75px 5px 75px 5px */ display: table-cell;min-height: 10em;vertical-align: middle;"><a class="detail-icon"><i class="fa fa-plus"></i></a></td>';
                                                        //}else{
                                                        //    echo '<td style="text-align: center;"><a class="detail-icon" ><i class=""></i></a></td>';                                                        
                                                        //}
                                                        echo '<td style="/* padding: 50px 5px 50px 5px */ "><div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">';
                                                            echo '<input type="hidden" id="id_orc_item_' . $contador_local_autocomplete . '" name="id_orc_item[]"   value="' . $d->idOrcamento_item . '"/>' .
                                                                '<div class="span12" style="padding: 0.2%; margin-left: 0">' ;
                                                                if(!empty($d->idOs)){
                                                                    echo '<div class="span1">'.
                                                                        '<label>O.S.:</label>'.
                                                                        '<input readonly type="text" class="span12" value="' . $d->idOs . '" />' .                                                                    
                                                                    '</div>';
                                                                    echo '<div class="span1">' .
                                                                    '<label><b>PN </b>:</label>' .
                                                                    '<input readonly type="text" class="span12" id="pn_' . $contador_local_autocomplete . '" name="pn[]" value="' . $d->pn . '" />' .
                                                                    '<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>' .
                                                                    '<input type="hidden" id="idProdutos_' . $contador_local_autocomplete . '" name="idProdutos[]" size="3"   value="' . $d->idProdutos . '"/>' .
                                                                    '<input type="hidden" name="contador[]" size="3"   value="' . $contador_local_autocomplete . '"/>' .
                                                                    '</div>' ;
                                                                }else{
                                                                    echo'<div class="span2">' .
                                                                    '<label><b>PN </b>:</label>' .
                                                                    '<input readonly type="text" class="span12" id="pn_' . $contador_local_autocomplete . '" name="pn[]" value="' . $d->pn . '" />' .
                                                                    '<input type="hidden" id="item[]" name="item[]"  value="" size="1"/>' .
                                                                    '<input type="hidden" id="idProdutos_' .$contador_local_autocomplete. '" name="idProdutos[]" size="3"   value="' . $d->idProdutos . '"/>' .
                                                                    '<input type="hidden" name="contador[]" size="3"   value="' .$contador_local_autocomplete. '"/>' .
                                                                    '</div>' ;
                                                                }
                                                                
                                                                echo '<div class="span1">'. 
                                                                        '<label>Início Des.:</label>' .
                                                                        '<input readonly type="text" class="span12" value="'.(!empty($d->data_solicitar_desenho)?date("d/m/Y H:i", strtotime($d->data_solicitar_desenho)):"").'">'.
                                                                    '</div>'. 
                                                                    '<div class="span1" title="Tipo de Orçamento">' .
                                                                    '<label>Orç.:</label>' .
                                                                    '<input readonly type="text" class="span12" id="orc_' . $contador_local_autocomplete . '" name="orc[]" value="' . $d->tipoOrc . '" />'.
                                                                    '</div>' .
                                                                    '<div class="span1" title="Tipo de Produto">' .
                                                                    '<label>Prod.:</label>' .
                                                                    '<input readonly type="text" class="span12"  value="' .($d->tipoProd == 'cil'? "Cilindro":($d->tipoProd == 'maq'?"Máquina":($d->tipoProd == 'pec'?"Peça":($d->tipoProd == 'sub'?"Subconjunto":"")))). '" />'.
                                                                    '<input readonly type="hidden" class="span12" id="tipo_prod_' . $contador_local_autocomplete . '" name="tipo_prod[]" value="' . $d->tipoProd . '" />';
                                                                    if($d->tipoOrc == 'serv'){
                                                                        $anexoImagens2 = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao($d->idOrcamento_item); 
                                                                    }
                                                                    if($d->tipoOrc == 'fab'){
                                                                        $anexoImagens2 = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao4($d->idOs); 
                                                                    }
                                                            echo '</div>'.
                                                                '<div class="span3">' .
                                                                '<label>Descrição:</label>' .
                                                                '<input type="text" readonly class="span12" id="descricao_item_' .$contador_local_autocomplete. '" name="descricao_item[]"  value="' . $d->descricao_item . '" />' .
                                                                '</div>' .
                                                                '<div class="span2">';
                                                                echo '<label>Status Escopo:</label>';
                                                                if($d->tipoOrc == 'serv'){
                                                                    if(!empty($escopo)){
                                                                        echo '<input type="text" readonly class="span12" value="'.$escopo->descricaoPeritagem.'">';
                                                                    }else{
                                                                        echo '<input type="text" readonly class="span12" value="Não possuí escopo">';
                                                                    }
                                                                }else{
                                                                    echo '<input type="text" readonly class="span12" value="Não possuí escopo">';
                                                                }
                                                                echo '</div>'.
                                                                '<div class="span1">' .
                                                                '<label>Tag:</label>' .
                                                                '<input type="text" readonly class="span12" id="tag_' .$contador_local_autocomplete. '" name="tag[]"  value="' . $d->tag . '" />' .
                                                                '</div>'. 
                                                                '<div class="span1">'. 
                                                                '<label>Des.:</label>' .
                                                                '<input type="text" readonly style="background:url('.base_url().(empty($anexoImagens2)?"/img/block.png":($d->statusDesenho == 3? "/img/confirm.png":"/img/alert.png")).') no-repeat center" class="span12" id="des_' .($d->tipoProd == "serv"?$d->idOrcamento_item:$d->idOs). '" />'.
                                                                '</div>' ;
                                                                //if($d->statusDesenho == 1 || $d->statusDesenho == 2){
                                                                
                                                                
                                                            echo '<div>';
                                                            echo '</div>';
                                                        echo '</div></td>';
                                                        echo '<td style="width:100px">';
                                                        echo '<div class="span1">' .
                                                                '<label></label>';
                                                                if($d->tipoOrc == 'serv'){                                                                
                                                                    echo '<a href="#modal-imagem_' .$d->idOrcamento_item. '" role="button" id="aDesenho_'.$d->idOrcamento_item.'" data-toggle="modal" style="margin-left: 10px;'.($d->statusDesenho == 3?"background-color: #999;color: white;":"").'" class="btn '.($d->statusDesenho == 3?"":"btn-warning").'"  class="span12" >Anexo desenho</a>'.
                                                                        '<div id="modal-imagem_'.$d->idOrcamento_item.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                            '<div class="modal-header">'.
                                                                                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                                '<h5 id="myModalLabel">Anexar Desenho. PN.: '.$d->pn.'</h5>'.
                                                                            '</div>'.
                                                                            '<div class="modal-body">'.
                                                                                '<div class="span12" style="margin-left:0px;display:'.($d->statusDesenho == 1 || $d->statusDesenho == 2?"block":"none").'">'. /*
                                                                                    '<div class="span3">'.
                                                                                        '<label>Nome Arquivo</label>'.
                                                                                        '<input type="text" name="nomeArquivo_'.$d->idOrcamento_item.'[]" id="nomeArquivo_'.$d->idOrcamento_item.'">'.
                                                                                    '</div>'.*/
                                                                                    '<div class="span3">'.
                                                                                        '<label> Arquivo </label>'.
                                                                                        '<input type="file"  name="imag_'.$d->idOrcamento_item.'" id="imag_'.$d->idOrcamento_item.'" accept=".pdf,.dwg">'.
                                                                                    '</div>'.   
                                                                                    '<div class=""span3>'.
                                                                                        '<a onclick="salvarArquivo('.$d->idOrcamento_item.','.$d->idOrcamento_item.',\'\')" role="button" data-toggle="modal" style="margin-right: 1%" class="btn btn-success" ><i class="fa fa-plus" style="color:white"></i> Salvar Desenho</a>'.
                                                                                    '</div>'.
                                                                                '</div>'.
                                                                                '<div class="span12" style="margin-left:0px;display:'.(($d->statusDesenho == 3)?"block":"none").'">'. /*
                                                                                    '<div class="span3">'.
                                                                                        '<label>Nome Arquivo</label>'.
                                                                                        '<input type="text" name="nomeArquivo_'.$d->idOrcamento_item.'[]" id="nomeArquivo_'.$d->idOrcamento_item.'">'.
                                                                                    '</div>'.*/
                                                                                    '<div class="span12">'.
                                                                                        '<div class="span3">'.
                                                                                            '<label> Finalizado por: </label>'.
                                                                                            '<input type="text" class="span12" readonly value="'.$d->nome.'">'.
                                                                                        '</div>'. 
                                                                                        '<div class="span3">'.
                                                                                            '<label> Data: </label>'.
                                                                                            '<input type="text" class="span12" readonly value="'.$d->data_finalizado_desenho.'">'.
                                                                                        '</div>'. 
                                                                                    '</div>'.   
                                                                                    
                                                                                    '<div class="span12">'.
                                                                                        '<b style="color:red">Para adicionar desenho novamente, clique no botão "Retornar ao Desenho" selecione os itens e confirme.</b>'. 
                                                                                    '</div>'.                                                                             
                                                                                '</div>'.
                                                                                '<div class="span12" style="margin-left:0px;display:'.($d->idStatusPeritagem==1?"block":"none").'">'. /*
                                                                                    '<div class="span3">'.
                                                                                        '<label>Nome Arquivo</label>'.
                                                                                        '<input type="text" name="nomeArquivo_'.$d->idOrcamento_item.'[]" id="nomeArquivo_'.$d->idOrcamento_item.'">'.
                                                                                    '</div>'.*/
                                                                                    '<b style="color:red">Aguardando aprovação e/ou solicitação do comercial.</b>'.
                                                                                '</div>'.
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
                                                                                                                    '<table class="table table-bordered " id="tableDesenhos_'.$d->idOrcamento_item.'">'.
                                                                                                                        '<thead>'.
                                                                                                                            '<tr>'.
                                                                                                                                '<th>Arquivo</th>'.
                                                                                                                                '<th>Status Desenho</th>'.
                                                                                                                                '<th>Aprovar</th>'.
                                                                                                                                '<th>Reprovar</th>' .         
                                                                                                                            '</tr>'.
                                                                                                                        '</thead>'.
                                                                                                                        '<tbody>';
                                                                                                                            foreach($anexoImagens2 as $anex){
                                                                                                                                echo '<tr>';
                                                                                                                                echo '<td><a href="' . base_url() .  $anex->caminho . $anex->imagem . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>
                                                                                                                                <a href=' . base_url() . $anex->caminho . $anex->imagem . ' target="_blank">' . $anex->nomeArquivo . $anex->extensao . '</a></td>'.
                                                                                                                                    '<td>' . ($anex->statusAnexo == 1 ? 'Aguardando Verificação' : ($anex->statusAnexo == 2 ? 'Aprovado' : 'Rejeitado')) . '</td>';
                                                                                                                                    if ($anex->statusAnexo != 1) {
                                                                                                                                        if($anex->statusAnexo == 2){
                                                                                                                                            echo '<td></td>';
                                                                                                                                            echo '<td style="text-align: center;"><a onclick="reprovarDesenho('.$anex->idAnexo.','.$d->idOrcamento_item.')" idAnexo = "' . $anex->idAnexo . '" tipoa = "2" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';

                                                                                                                                        }
                                                                                                                                        if($anex->statusAnexo == 3){
                                                                                                                                            echo '<td style="text-align: center;"><a onclick="aprovarDesenho('.$anex->idAnexo.','.$d->idOrcamento_item.')" idAnexo = "' . $anex->idAnexo . '" tipoa = "1" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                                                                                                            echo '<td></td>';
                                                                                                                                        }
                                                                                                                                        
                                                                                                                                    } else {
                                                                                                                                        echo '<td style="text-align: center;"><a onclick="aprovarDesenho('.$anex->idAnexo.','.$d->idOrcamento_item.')" idAnexo = "' . $anex->idAnexo . '" tipoa = "1" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                                                                                                        echo '<td style="text-align: center;"><a onclick="reprovarDesenho('.$anex->idAnexo.','.$d->idOrcamento_item.')" idAnexo = "' . $anex->idAnexo . '" tipoa = "2" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
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
                                                                                        '</div>';
                                                                                }else{
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
                                                                                                                    '<table  class="table table-bordered " id="tableDesenhos_'.$d->idOrcamento_item.'">'.
                                                                                                                        '<thead>'.
                                                                                                                            '<tr>'.
                                                                                                                                '<th>Arquivo</th>'.
                                                                                                                                '<th>Status Desenho</th>'.
                                                                                                                                '<th>Aprovar</th>'.
                                                                                                                                '<th>Reprovar</th>' .            
                                                                                                                            '</tr>'.
                                                                                                                        '</thead>'.
                                                                                                                        '<tbody>'.
                                                                                                                            '<tr>'.
                                                                                                                                '<td colspan="4" style="text-align:center">Não há desenhos anexados nesse item</td>'.
                                                                                                                            '</tr>';                                                                    
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

                                                                if($d->tipoOrc == 'fab'){
                                                                    echo '<a href="#modal-imagem_' .$d->idOs. '" role="button" id="aDesenho_'.$d->idOs.'" data-toggle="modal" style="margin-left: 10px;'.($d->statusDesenho == 3?"background-color: #999;color: white;":"").'" class="btn '.($d->statusDesenho == 3?"":"btn-warning").'"  class="span12" >Anexo desenho</a>'.
                                                                        '<div id="modal-imagem_'.$d->idOs.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                            '<div class="modal-header">'.
                                                                                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                                '<h5 id="myModalLabel">Anexar Desenho. O.S.:'.$d->idOs.'</h5>'.
                                                                            '</div>'.
                                                                            '<div class="modal-body">'.
                                                                                '<div class="span12" style="margin-left:0px;display:'.(($d->statusDesenho == 1 || $d->statusDesenho == 2) &&$d->status_item==2?"block":"none").'">'. /*
                                                                                    '<div class="span3">'.
                                                                                        '<label>Nome Arquivo</label>'.
                                                                                        '<input type="text" name="nomeArquivoOs_'.$d->idOs.'[]" id="nomeArquivoOs_'.$d->idOs.'">'.
                                                                                    '</div>'. */
                                                                                    '<div class="span3">'.
                                                                                        '<label> Arquivo </label>'.
                                                                                        '<input type="file"  name="imagOs_'.$d->idOs.'" id="imagOs_'.$d->idOs.'" accept=".pdf,.dwg">'.
                                                                                    '</div>'.   
                                                                                    '<div class=""span3>'.
                                                                                        '<a onclick="salvarArquivo2('.$d->idOs.','.$d->idOs.',\'\')" role="button" data-toggle="modal" style="margin-right: 1%" class="btn btn-success" ><i class="fa fa-plus" style="color:white"></i> Salvar Desenho</a>'.
                                                                                    '</div>'. 
                                                                                '</div>'. 
                                                                                
                                                                                '<div class="span12" style="margin-left:0px;display:'.($d->statusDesenho ==3 && $d->status_item!=2?"block":"none").'">'. /*
                                                                                    '<div class="span3">'.
                                                                                        '<label>Nome Arquivo</label>'.
                                                                                        '<input type="text" name="nomeArquivo_'.$d->idOrcamento_item.'[]" id="nomeArquivo_'.$d->idOrcamento_item.'">'.
                                                                                    '</div>'.*/
                                                                                    '<div class="span12">'.
                                                                                        '<div class="span3">'.
                                                                                            '<label> Finalizado por: </label>'.
                                                                                            '<input type="text" class="span12" readonly value="'.$d->nome.'">'.
                                                                                        '</div>'. 
                                                                                        '<div class="span3">'.
                                                                                            '<label> Data: </label>'.
                                                                                            '<input type="text" class="span12" readonly value="'.$d->data_finalizado_desenho.'">'.
                                                                                        '</div>'. 
                                                                                    '</div>'.
                                                                                    '<div class="span12">'.
                                                                                        '<b style="color:red">Para adicionar desenho novamente, clique no botão "Retornar ao Desenho" selecione os itens e confirme.</b>'. 
                                                                                    '</div>'.
                                                                                '</div>'.
                                                                                '<div class="span12" style="margin-left:0px;display:'.($d->status_item!=2?"block":"none").'">'. /*
                                                                                    '<div class="span3">'.
                                                                                        '<label>Nome Arquivo</label>'.
                                                                                        '<input type="text" name="nomeArquivo_'.$d->idOrcamento_item.'[]" id="nomeArquivo_'.$d->idOrcamento_item.'">'.
                                                                                    '</div>'.*/
                                                                                    '<b style="color:red">Aguardando aprovação e/ou solicitação do comercial.</b>'.
                                                                                '</div>'.
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
                                                                                                                '<table class="table table-bordered " id="tableDesenhos_'.$d->idOs.'_">'.
                                                                                                                    '<thead>'.
                                                                                                                        '<tr>'.
                                                                                                                            '<th>Arquivo</th>'.
                                                                                                                            '<th>Status Desenho</th>'.
                                                                                                                            '<th>Aprovar</th>'.
                                                                                                                            '<th>Reprovar</th>' .        
                                                                                                                        '</tr>'.
                                                                                                                    '</thead>'.
                                                                                                                    '<tbody>';
                                                                                                                        foreach($anexoImagens2 as $anex){
                                                                                                                            echo '<tr>';
                                                                                                                            echo '<td><a href="' . base_url() .  $anex->caminho . $anex->imagem . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>
                                                                                                                            <a href=' . base_url() . $anex->caminho . $anex->imagem . ' target="_blank">' . $anex->nomeArquivo . $anex->extensao . '</a></td>'.
                                                                                                                                '<td>' . ($anex->statusAnexo == 1 ? 'Aguardando Verificação' : ($anex->statusAnexo == 2 ? 'Aprovado' : 'Rejeitado')) . '</td>';
                                                                                                                                if ($anex->statusAnexo != 1) {
                                                                                                                                    if($anex->statusAnexo == 2){
                                                                                                                                        echo '<td></td>';
                                                                                                                                        echo '<td style="text-align: center;"><a onclick="reprovarDesenho('.$anex->idAnexo.','.$d->idOs.')" idAnexo = "' . $anex->idAnexo . '" tipoa = "2" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
                                                                            
                                                                                                                                    }
                                                                                                                                    if($anex->statusAnexo == 3){
                                                                                                                                        
                                                                                                                                        echo '<td style="text-align: center;"><a onclick="aprovarDesenho('.$anex->idAnexo.','.$d->idOs.')" idAnexo = "' . $anex->idAnexo . '" tipoa = "1" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                                                                                                        echo '<td></td>';
                                                                                                                                        
                                                                                                                                    }
                                                                                                                                    
                                                                                                                                } else {
                                                                                                                                    echo '<td style="text-align: center;"><a onclick="aprovarDesenho('.$anex->idAnexo.','.$d->idOs.')" idAnexo = "' . $anex->idAnexo . '" tipoa = "1" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                                                                                                    echo '<td style="text-align: center;"><a onclick="reprovarDesenho('.$anex->idAnexo.','.$d->idOs.')" idAnexo = "' . $anex->idAnexo . '" tipoa = "2" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
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
                                                                                    '</div>';
                                                                                }else{
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
                                                                                                                '<table  class="table table-bordered " id="tableDesenhos_'.$d->idOs.'">'.
                                                                                                                    '<thead>'.
                                                                                                                        '<tr>'.
                                                                                                                            '<th>Arquivo</th>'.
                                                                                                                            '<th>Status Desenho</th>'.
                                                                                                                            '<th>Aprovar</th>'.
                                                                                                                            '<th>Reprovar</th>' .             
                                                                                                                        '</tr>'.
                                                                                                                    '</thead>'.
                                                                                                                    '<tbody>'.
                                                                                                                        '<tr>'.
                                                                                                                            '<td colspan="4" style="text-align:center">Não há desenhos anexados nesse item</td>'.
                                                                                                                        '</tr>';                                                                    
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
                                                                // }
                                                            
                                                            echo '</div>';
                                                        echo '</td>';
                                                        
                                                    echo '</tr>';
                                                    if($d->tipoOrc == 'serv'){
                                                        $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($d->idOrcamento_item);
                                                        $catalogoServ = $this->peritagem_model->getCatalogoAtivosByIdProduto2($d->idProdutos);
                                                        if (!empty($escopo)) {
                                                            $possuiEscopo = true;
                                                            $statusEscopo = $escopo->descricaoPeritagem;
                                                            $escopoItens = $this->peritagem_model->itensPeritagemDesenho($escopo->idOrcServicoEscopo);
                                                        }else{
                                                            $escopoItens = array();
                                                        }

                                                        echo '<tr class="trfilho'.$d->idOrcamento_item.$d->idOs.'" style="display:none">';/**/
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;"> ';
                                                            echo '<input type="hidden" name="idOrcamentoItemChecklist[]" id="idOrcamentoItemChecklist" value="' . $d->idOrcamento_item . '">';
                                                            echo '</td>';
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;" colspan="2">';
                                                                echo '<div id="escopo_' . $d->idOrcamento_item . '">';
                                                                    echo '<h5>Checklist <a onclick="adicionarItemCheckList(' . $d->idOrcamento_item . ');" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Item Checklist</a></h5><div>Completo <a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>|
                                                                    Incompleto/Pend. Aprov. <a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>|
                                                                    Sem desenho <a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a></div>';
                                                                    echo '<table class="table table-bordered " id="tableEscopo_' . $d->idOrcamento_item . '">' .
                                                                        '<thead>'.
                                                                        '<tr>'.
                                                                        '<th></th>'.
                                                                        '<th>Item</br>Comercial</th>'.
                                                                        '<th>PN</th>'.
                                                                        '<th>Desc. PN</th>'.
                                                                        '<th>Desc. Escopo</th>'.
                                                                        '<th>Qtd</th>' .
                                                                        '<th>Tipo</th>'.                                                                        
                                                                        '<th>Des.</th>'.
                                                                        '<th>Excluir</th>'.
                                                                        '</tr>'.
                                                                        '</thead>' .
                                                                        '<tbody>';
                                                                        $contagemLinha = 0;
                                                                        foreach ($escopoItens as $r) {
                                                                            if (!empty($r->idOrcServicoEscopo) && $r->descricaoServicoItens != "Testar" && $r->descricaoServicoItens != "Pintura" && $r->descricaoServicoItens != "Montagem"&& $r->descricaoServicoItens != "Válvula") {
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
                                                                                if($verifyAnexoAguardando == 1){
                                                                                    $verifyAnexo = 1;
                                                                                }else if($verifyAnexoPossui == 1){
                                                                                    $verifyAnexo = 2;
                                                                                }
                                                                                echo '<tr>'.
                                                                                    '<input type="hidden" name="idOrcEscopo[]" value="' . $d->idOrcamento_item . '">' .
                                                                                    '<input type="hidden" id="idOrcServicoEscopoItens_" name="idOrcServicoEscopoItens_'.$d->idOrcamento_item.'[]" value="' . $r->idOrcServicoEscopoItens . '">' ;
                                                                                echo '<td></td>';
                                                                                if(!empty($r->pn)){
                                                                                    if($r->item_comercial == 0){
                                                                                        echo '<td style="width:60px"><input type="checkbox" onchange="checkcomercial(this)" class="span12" id="checkItemComercial" value="'.$r->idProdutos.'"></td>';
                                                                                    }else{
                                                                                        echo '<td style="width:60px"><input type="checkbox" onchange="checkcomercial(this)" class="span12" checked id="checkItemComercial" value="'.$r->idProdutos.'"></td>';
                                                                                    }
                                                                                    //echo '<td></td>';
                                                                                }else{
                                                                                    echo '<td style="width:60px"><input type="checkbox" onchange="checkcomercial(this)" class="span12" name="checkItemComercial2_novo" id="checkItemComercial2_novo_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" value=""></td>';
                                                                                }
                                                                                
                                                                                
                                                                                if(!empty($r->pn)){
                                                                                    echo '<td style="width: 140px;"><input type="text" onblur="salvarPn('.$r->idServicoEscopoItens.',\''.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'\',this)" onclick="abrirModal(this)" name="pn_'.$d->idOrcamento_item.'[]" id="pn_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" value="'.$r->pn.'"></td>' .
                                                                                        '<input type="hidden"  name="idpn_'.$d->idOrcamento_item.'[]" id="idpn_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" value="'.$r->idProdutos.'">'. 
                                                                                        '<td id="descpn_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'">' . $r->descricao . '</td>'. 
                                                                                        '<td>' . $r->descricaoServicoItens . '</td>' ;
                                                                                }else{
                                                                                    echo '<td style="width: 140px;"><input type="text" onblur="salvarPn('.$r->idServicoEscopoItens.',\''.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'\',this)" name="pn_'.$d->idOrcamento_item.'[]" id="pn_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" value="'.$r->pn.'"></td>' .
                                                                                        '<input type="hidden"  name="idpn_'.$d->idOrcamento_item.'[]" id="idpn_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" value="'.$r->idProdutos.'">'. 
                                                                                        '<td id="descpn_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'"></td>'.
                                                                                        '<td>' . $r->descricaoServicoItens . '</td>' ;
                                                                                }
                                                                                echo '<script type="text/javascript">'.
                                                                                    '$("#pn_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'").autocomplete({' .
                                                                                        'source: "' .base_url(). 'index.php/almoxarifado/autoCompleteProd2",' .
                                                                                        'minLength: 1,' .
                                                                                        'select: function( event, ui ) {' .
                                                                                            'valor = this.id.split("_");' .
                                                                                            '$(\'#idpn_\'+valor[1]+\'_\'+valor[2]).val(ui.item.id);' .
                                                                                            '$(\'#descpn_\'+valor[1]+\'_\'+valor[2]).empty();' .
                                                                                            '$(\'#descpn_\'+valor[1]+\'_\'+valor[2]).append(ui.item.produtos);' .
                                                                                        '}'.
                                                                                    '});'.
                                                                                '</script>';
                                                                                if(empty($r->pn)){
                                                                                    echo '<td style="width:50px"><input type="text"onblur="salvarPn('.$r->idServicoEscopoItens.',\''.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'\',this)" onclick="abrirModal(this)" class="span12 number" name="pnQtd_'.$r->idOrcServicoEscopoItens.'" id="pnQtd_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'"></td>';
                                                                                    echo '<td style="width:250px"><select onchange = "salvarPn('.$r->idServicoEscopoItens.',\''.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'\',this)" class="span12" name="pnIdClasse_' .$r->idOrcServicoEscopoItens. '" id="pnIdClasse_' .$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'"><option value="">Selecione</option><option value="cil">Cilindro</option>' .
                                                                                        '<option value="maq">Máquina</option>'.
                                                                                        '<option value="pec">Peça</option>'.
                                                                                        '<option value="sub">Subconjunto</option></select></td>';
                                                                                }else{
                                                                                    echo '<td></td>';
                                                                                    echo '<td></td>';
                                                                                }
                                                                                
                                                                               
                                                                                echo '<td>'.
                                                                                    '<a href="#modal-imagem_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" role="button" data-toggle="modal" style="margin-right: 1%" class="btn tip-top" ><i id="i_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" class="'.($verifyAnexo == 1 ?"fas fa-exclamation-triangle":($verifyAnexo == 2 ?"icon-ok":"icon-ban-circle")).'" style="color:'.($verifyAnexo == 1 ?"orange":($verifyAnexo == 2 ?"green":"grey")).'"></i></a>'.
                                                                                    '<div id="modal-imagem_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                                        '<div class="modal-header">'.
                                                                                            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                                            '<h5 id="myModalLabel">Anexar Desenho PN: '.$r->pn.' | Descrição: '.$r->descricaoServicoItens.'</h5>'.
                                                                                        '</div>'.
                                                                                        '<div class="modal-body">'.
                                                                                            '<div class="span12" style="display:'.($d->statusDesenho == 1 || $d->statusDesenho == 2?"block":"none").'">'. /*
                                                                                                '<div class="span3">'.
                                                                                                    '<label>Nome Arquivo</label>'.
                                                                                                    '<input type="text" name="nomeArquivo_'.$d->idOrcamento_item.'[]" id="nomeArquivo_'.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'">'.
                                                                                                '</div>'. */
                                                                                                '<div class="span3">'.
                                                                                                    '<label> Arquivo </label>'.
                                                                                                    '<input type="file" name="imag_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" id="imag_'.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'" accept=".pdf,.dwg">'.
                                                                                                '</div>'. 
                                                                                                '<div class=""span3>'.
                                                                                                    '<a onclick="salvarArquivo(\''.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'\','.$d->idOrcamento_item.','.$r->idOrcServicoEscopoItens.')" role="button" data-toggle="modal" style="margin-right: 1%" class="btn btn-success" ><i class="fa fa-plus" style="color:white"></i> Salvar Desenho</a>'.
                                                                                                '</div>'. 
                                                                                            '</div>';
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
                                                                                                                                '<table class="table table-bordered " id="tableDesenhos_'.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'">'.
                                                                                                                                    '<thead>'.
                                                                                                                                        '<tr>'.
                                                                                                                                            '<th>Arquivo</th>'.
                                                                                                                                            '<th>Status Desenho</th>'.
                                                                                                                                            '<th>Aprovar</th>'.
                                                                                                                                            '<th>Reprovar</th>' .
                                                                                                                                        '</tr>'.
                                                                                                                                    '</thead>'.
                                                                                                                                    '<tbody>'; 
                                                                                                                                        foreach($anexoImagens as $anex){
                                                                                                                                            echo '<tr>';
                                                                                                                                            echo '<td><a href="' . base_url() .  $anex->caminho . $anex->imagem . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>
                                                                                                                                            <a href=' . base_url() . $anex->caminho . $anex->imagem . ' target="_blank">' . $anex->nomeArquivo . $anex->extensao . '</a></td>'.
                                                                                                                                                '<td>' . ($anex->statusAnexo == 1 ? 'Aguardando Verificação' : ($anex->statusAnexo == 2 ? 'Aprovado' : 'Rejeitado')) . '</td>';
                                                                                                                                                if ($anex->statusAnexo != 1) {
                                                                                                                                                    if($anex->statusAnexo == 2){
                                                                                                                                                        echo '<td></td>';
                                                                                                                                                        echo '<td style="text-align: center;"><a onclick="reprovarDesenho('.$anex->idAnexo.',\''.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'\')" tipoa = "2" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
                                                                                            
                                                                                                                                                    }
                                                                                                                                                    if($anex->statusAnexo == 3){
                                                                                                                                                        
                                                                                                                                                        echo '<td style="text-align: center;"><a onclick="aprovarDesenho('.$anex->idAnexo.',\''.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'\')" idAnexo = "' . $anex->idAnexo . '" tipoa = "1" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                                                                                                                        echo '<td></td>';
                                                                                                                                                        
                                                                                                                                                    }
                                                                                                                                                    
                                                                                                                                                } else {
                                                                                                                                                    echo '<td style="text-align: center;"><a onclick="aprovarDesenho('.$anex->idAnexo.',\''.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'\')" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                                                                                                                    echo '<td style="text-align: center;"><a onclick="reprovarDesenho('.$anex->idAnexo.',\''.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'\')" idAnexo = "' . $anex->idAnexo . '" tipoa = "2" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
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
                                                                                                                                '<table class="table table-bordered " id="tableDesenhos_'.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'">'.
                                                                                                                                    '<thead>'.
                                                                                                                                        '<tr>'.
                                                                                                                                            '<th>Arquivo</th>'.
                                                                                                                                            '<th>Status Desenho</th>'.
                                                                                                                                            '<th>Aprovar</th>'.
                                                                                                                                            '<th>Reprovar</th>' .
                                                                                                                                        '</tr>'.
                                                                                                                                    '</thead>'.
                                                                                                                                    '<tbody>'.
                                                                                                                                        '<tr>'.
                                                                                                                                            '<td colspan="4" style="text-align:center">Não há desenhos anexados nesse item.</td>'.
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
                                                                                echo '</td>';  
                                                                                echo '<td></td>';                                                                         
                                                                                echo '</tr>';
                                                                            }
                                                                            $contagemLinha++;
                                                                        }
                                                                        echo '</tbody>'. 
                                                                        '</table>';
                                                                echo '</div>';
                                                            echo '</td>'; 
                                                        echo '</tr>';
                                                    }
                                                    if($d->tipoOrc == 'fab'){
                                                        $subdOs = $this->os_model->getSubOsByIdOrcamentoItem2($d->idOrcamento_item);
                                                        echo '<tr class="trfilho'.$d->idOrcamento_item.$d->idOs.'" style="display:none">';/**/
                                                            echo '<input type="hidden" name="idOsCatalogo[]" id="idOsCatalogo" value="'.$d->idOs.'">';
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;"> ';
                                                            echo '</td>';
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">';
                                                                echo '<div id="escopo_' . $d->idOs . '">';
                                                                    echo '<h5>Sub OS <a onclick="adicionarItemCatalogo(' . $d->idOs . ');" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Item </a></h5><div>Completo <a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>|
                                                                    Incompleto/Pend. Aprov. <a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>|
                                                                    Sem desenho <a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a></div>';
                                                                    echo '<table class="table table-bordered" id="tableEscopo_'.$d->idOs.'">' .
                                                                        '<thead>' .
                                                                        '<tr>'.
                                                                        '<th>Item</br>Comercial</th>' .
                                                                        '<th>PN</th>' .
                                                                        '<th>DESCRIÇÃO</th>'.
                                                                        '<th>QTD</th>'.
                                                                        '<th>Tipo Prod.</th>'.
                                                                        //'<th>SUB O.S.</th>'.
                                                                        '<th>TIPO</th>'.
                                                                        '<th></th>'.
                                                                        '<th>Excluir</th>'.
                                                                        '</tr>'.
                                                                        '</thead>'.
                                                                        '<tbody>';
                                                                        foreach ($subdOs as $r) {
                                                                            if (!empty($r->idOsSub)) {
                                                                                $anexoImagens = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao3($r->idOsSub,$r->idOs);
                                                                                $getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao3($r->idOsSub,$r->idOs);
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
                                                                                if($r->posicao != 0){
                                                                                    echo '<tr>' .
                                                                                        '<input type="hidden" name="idOs[]" value="' . $r->idOs . '">' .
                                                                                        '<input type="hidden" name="idSubOs'.$r->idOsSub.'[]" value="">';
                                                                                    if(!empty($r->pn)){
                                                                                        if($r->item_comercial == 0){
                                                                                            echo '<td style="width:60px"><input type="checkbox" onchange="checkcomercial(this)" class="span12" id="checkItemComercial" value="'.$r->idProdutos.'"></td>';
                                                                                        }else{
                                                                                            echo '<td style="width:60px"><input type="checkbox" onchange="checkcomercial(this)" class="span12" checked id="checkItemComercial" value="'.$r->idProdutos.'"></td>';
                                                                                        }
                                                                                        //echo '<td></td>';
                                                                                    }else{
                                                                                        echo '<td style="width:60px"><input type="checkbox" onchange="checkcomercial(this)" class="span12" name="checkItemComercial2_novo" id="checkItemComercial2_novo_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" value=""></td>';
                                                                                    }
                                                                                    echo '<td>' . $r->pn . '</td>';
                                                                                    echo '<td>' . $r->descricaoOsSub . '</td>';
                                                                                    echo '<td>' . $r->quantidade . '</td>';
                                                                                    echo '<td>' . /*$r->tipoProd*/'' . '</td>';
                                                                                    echo //'<td>' . $r->idOs.'.'. $r->posicao. '</td>' .
                                                                                        '<td>' . $r->tipoOrc. '</td>' ;
                                                                                    
                                                                                    echo '<td>'.
                                                                                        '<a href="#modal-imagem_'.$r->idOs.'_'.$r->idOsSub.'" role="button" data-toggle="modal" style="margin-right: 1%" class="btn tip-top" ><i  id="i_'.$r->idOs.'_'.$r->idOsSub.'" class="'.($verifyAnexo == 1 ?"fas fa-exclamation-triangle":($verifyAnexo == 2 ?"icon-ok":"icon-ban-circle")).'" style="color:'.($verifyAnexo == 1 ?"orange":($verifyAnexo == 2 ?"green":"grey")).'"></i></a>'.
                                                                                        '<div id="modal-imagem_'.$r->idOs.'_'.$r->idOsSub.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                                            '<div class="modal-header">'.
                                                                                                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                                                '<h5 id="myModalLabel">Anexar Desenho. O.S.: '.$r->idOs.'.'.$r->posicao.'. PN: '.$r->pn.'</h5>'.
                                                                                            '</div>'.
                                                                                            '<div class="modal-body">'.
                                                                                                '<div class="span12" style="display:'.($d->statusDesenho == 1 || $d->statusDesenho == 2?"block":"none").'">'. /*
                                                                                                    '<div class="span3">'.
                                                                                                        '<label>Nome Arquivo</label>'.
                                                                                                        '<input type="text" name="nomeArquivoOs_'.$r->idOs.'[]" id="nomeArquivoOs_'.$r->idOs.'_'. $r->idOsSub .'">'.
                                                                                                    '</div>'. */
                                                                                                    '<div class="span3">'.
                                                                                                        '<label> Arquivo </label>'.
                                                                                                        '<input type="file"  name="imagOs_'.$r->idOs.'_'.$r->idOsSub.'" id="imagOs_'.$r->idOs.'_'. $r->idOsSub .'" accept=".pdf,.dwg">'.
                                                                                                    '</div>'. 
                                                                                                    '<div class=""span3>'.
                                                                                                        '<a onclick="salvarArquivo2(\''.$r->idOs.'_'. $r->idOsSub .'\','.$r->idOs.','.$r->idOsSub.')" role="button" data-toggle="modal" style="margin-right: 1%" class="btn btn-success" ><i class="fa fa-plus" style="color:white"></i> Salvar Desenho</a>'.
                                                                                                    '</div>'. 
                                                                                                '</div>';
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
                                                                                                                                    '<table class="table table-bordered " id="tableDesenhos_'.$r->idOs.'_'. $r->idOsSub .'">'.
                                                                                                                                        '<thead>'.
                                                                                                                                            '<tr>'.
                                                                                                                                                '<th>Arquivo</th>'.
                                                                                                                                                '<th>Status Desenho</th>'.
                                                                                                                                                '<th>Aprovar</th>'.
                                                                                                                                                '<th>Reprovar</th>' .        
                                                                                                                                            '</tr>'.
                                                                                                                                        '</thead>'.
                                                                                                                                        '<tbody>'; 
                                                                                                                                            foreach($anexoImagens as $anex){
                                                                                                                                                echo '<tr>';
                                                                                                                                                echo '<td><a href="' . base_url() .  $anex->caminho . $anex->imagem . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>
                                                                                                                                                <a href=' . base_url() . $anex->caminho . $anex->imagem . ' target="_blank">' . $anex->nomeArquivo . $anex->extensao . '</a></td>'.
                                                                                                                                                    '<td>' . ($anex->statusAnexo == 1 ? 'Aguardando Verificação' : ($anex->statusAnexo == 2 ? 'Aprovado' : 'Rejeitado')) . '</td>';
                                                                                                                                                    if ($anex->statusAnexo != 1) {
                                                                                                                                                        if($anex->statusAnexo == 2){
                                                                                                                                                            echo '<td></td>';
                                                                                                                                                            echo '<td style="text-align: center;"><a onclick="reprovarDesenho('.$anex->idAnexo.',\''.$r->idOs.'_'. $r->idOsSub .'\')" tipoa = "2" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
                                                                                                
                                                                                                                                                        }
                                                                                                                                                        if($anex->statusAnexo == 3){
                                                                                                                                                            
                                                                                                                                                            echo '<td style="text-align: center;"><a onclick="aprovarDesenho('.$anex->idAnexo.',\''.$r->idOs.'_'. $r->idOsSub .'\')" idAnexo = "' . $anex->idAnexo . '" tipoa = "1" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                                                                                                                            echo '<td></td>';
                                                                                                                                                            
                                                                                                                                                        }                                                                                                                                                    
                                                                                                                                                    } else {
                                                                                                                                                        echo '<td style="text-align: center;"><a onclick="aprovarDesenho('.$anex->idAnexo.',\''.$r->idOs.'_'. $r->idOsSub .'\')" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>';
                                                                                                                                                        echo '<td style="text-align: center;"><a onclick="reprovarDesenho('.$anex->idAnexo.',\''.$r->idOs.'_'. $r->idOsSub .'\')" idAnexo = "' . $anex->idAnexo . '" tipoa = "2" linkdesenho = "' . base_url() . $anex->caminho . $anex->imagem . '" nomedesenho="' . $anex->nomeArquivo . $anex->extensao . '" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
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
                                                                                                                                    '<table class="table table-bordered " id="tableDesenhos_'.$r->idOs.'_'. $r->idOsSub .'">'.
                                                                                                                                        '<thead>'.
                                                                                                                                            '<tr>'.
                                                                                                                                                '<th>Arquivo</th>'.
                                                                                                                                                '<th>Status Desenho</th>'.
                                                                                                                                                '<th>Aprovar</th>'.
                                                                                                                                                '<th>Reprovar</th>' .        
                                                                                                                                            '</tr>'.
                                                                                                                                        '</thead>'.
                                                                                                                                        '<tbody>'.
                                                                                                                                            '<tr>'.
                                                                                                                                                '<td colspan="4" style="text-align:center">Não há desenhos anexados nesse item.</td>'.
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
                                                                                        '</div></td>';       
                                                                                        echo '<td></td>';                                                                     
                                                                                    echo'</tr>';
                                                                                }
                                                                                
                                                                            }
                                                                        }
                                                                        echo '</tbody>'. 
                                                                        '</table>';
                                                                echo '</div>';
                                                            echo '</td>'; 
                                                        echo '</tr>';
                                                    }
                                                    
                                                    $contador_local_autocomplete++;
                                                }?>
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
        <a type="button" onclick="verificarCamposPreenchidos()" name="btnSalvar" value = "btnSalvar" class="btn btn-success"><i class="icon-plus icon-white"></i> Salvar</a>
        <a type="button" onclick="modelConfirmarFinalizacao()" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success"><i class="icon-plus icon-white"></i> Finalizar</a>
        <a  onclick="modelReavalicaoDesenho()" name="" value = "btnGerarCotacao" class="btn btn-warning"><i class="icon-plus icon-white"></i> Retornar ao Desenho</a>
    </div> 
</form>


<div id="modalAprovar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/desenho/aprovardesenho" method="post" enctype="multipart/form-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Deseja aprovar esse desenho? </h5>
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
                                                <input id="idAnexo2" name="idAnexo2" value="" type="hidden">
                                                <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                                    <thead>
                                                        <tr>
                                                            <th>Arquivo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><a href=" " id="aAprovar" target="_blank"></a></td>
                                                        </tr>
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
            <button class="btn btn-success">Adicionar</button>
        </div>
    </form>
</div>
<div id="modalReprovar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/desenho/reprovardesenho" method="post" enctype="multipart/form-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Deseja reprovar esse desenho? </h5>
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
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><a href=" " id="aAprovar2" target="_blank"></a></td>
                                                        </tr>
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
            <button class="btn btn-success">Adicionar</button>
        </div>
    </form>
</div>
<div id="modal_cad_desenho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Cadastrar Desenho </h5>
            <input type="hidden" name="idOrcItemRedirect" value="<?php echo $itens;?>">	
    </div>
    <div class="modal-body">
        <form action="<?php echo base_url(); ?>index.php/desenho/cad_desenho" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
            <div class="control-group">
                <label for="obs_controle" class="control-label">Nome arquivo</label>
                <div class="controls">
                    <input id="nomeArquivo" type="text" name="nomeArquivo" value="" />
                    <input id="idOrcItem" type="hidden" name="idOrcItem" value="<?php echo $orcam->idOrcamento_item;?>" />
                </div>

                <label for="arquivo" class="control-label"><span class="required">Arquivo</span></label>
                <div class="controls">
                    <input id="arquivo" type="file" name="userfile" />
                </div>


            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
                <button class="btn btn-primary">Cadastrar</button>
            </div>
        </form>
    </div>
</div>
<div id="modelFinalizar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/desenho/finalizarDesenho"  enctype="multipart/form-data" method="post" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Finalizar anexagem</h5>
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
                                                <?php foreach($result as $r){
                                                    echo ' <tr>';

                                                    if($r->tipoOrc == 'fab'){
                                                        if($r->statusDesenho == 3){
                                                            echo '<td><input type="checkbox"  '.($r->statusDesenho == 3?"checked disabled":"").'   value=""></td>';
                                                        }else if($r->statusDesenho){
                                                            echo '<td><input type="checkbox"  name="idOs[]" value="'.$r->idOs.'"></td>';
                                                        }else{
                                                            echo '<td></td>';
                                                        }
                                                    }else{
                                                        if($r->statusDesenho == 3){
                                                            echo '<td><input type="checkbox"  '.($r->statusDesenho == 3?"checked disabled":"").'   value=""></td>';
                                                        }else if($r->statusDesenho){
                                                            echo '<td><input type="checkbox"  name="idOrcItem[]" value="'.$r->idOrcamento_item.'"></td>';
                                                        }else{
                                                            echo '<td></td>';
                                                        }
                                                    }

                                                    

                                                    /*
                                                    if($r->tipoOrc == "serv"){
                                                        
                                                        if($r->statusDesenho == 3){
                                                            echo '<td><input type="checkbox"  '.($r->statusDesenho == 3?"checked disabled":"").'   ></td>';
                                                        }else{
                                                            echo '<td><input type="checkbox"  name="idOrcServEscopo[]" value="'.$r->idOrcamento_item.'"></td>';
                                                        }
                                                        
                                                    }else{
                                                        if($r->statusDesenho == 3){
                                                            echo '<td><input type="checkbox"  '.($r->statusDesenho == 3?"checked disabled":"").'   ></td>';
                                                        }else if($r->statusDesenho){
                                                            echo '<td><input type="checkbox"  name="finalizarFabIdOrcItem[]" value="'.$r->idOrcamento_item.'"></td>';
                                                        }else{
                                                            echo '<td></td>';
                                                        }
                                                    }*/
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
            <!--
            <input type="hidden" id="idFotoLaudo" name="idFotoLaudo" value="" />
            <h5 style="text-align: center">Deseja realmente finalizar está peritagem?</h5>
            <p style="text-align: center">(Certifique-se de que as alterações da peritagem foram salvas.)</p>
            <p style="text-align: center">(Após a confirmação não será possivel alterar as informações dessa peritagem sem a autorização do comercial.)</p>
                                                        -->
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>
<div id="model-reavaliacaodesenho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/desenho/reavaliacaodesenho"  enctype="multipart/form-data" method="post" class="form-horizontal">  
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
                                                <?php foreach($result as $r){
                                                    echo ' <tr>';
                                                    if($r->statusDesenho == 3){
                                                        echo '<td><input type="checkbox"  name="idOrcItem[]" value="'.$r->idOrcamento_item.'"></td>';
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
    function checkcomercial(item){
        var checkado;
        var idProduto = item.value;
        if(item.checked){
            checkado = 1;
        }else{
            checkado = 0;
        }
        if(idProduto){
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/produtos/itemcomercial",
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    check: checkado,
                    idProduto: idProduto
                },
                success: function(data2) {
                    
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
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var tipoa = $(this).attr('tipoa');
            var idAnexo = $(this).attr('idAnexo');
            $('#idAnexo2').val(idAnexo);
            $('#aAprovar').attr('href', $(this).attr('linkdesenho'));
            $('#aAprovar').append($(this).attr('nomedesenho'));

            $('#idAnexo3').val(idAnexo);
            $('#aAprovar2').attr('href', $(this).attr('linkdesenho'));
            $('#aAprovar2').append($(this).attr('nomedesenho'));

        });
    });

    function verificarCamposPreenchidos(){
        var idOsCatalogo = document.querySelectorAll("#idOsCatalogo");
        for(x=0;x<idOsCatalogo.length ; x++){
            catalogoDesc = document.querySelectorAll("input[name='novoCatalogoDescProd_"+idOsCatalogo[x].value+"[]']");
            quantidade = document.querySelectorAll("input[name='novoCatalogoQtd_"+idOsCatalogo[x].value+"[]']");
            classe = document.querySelectorAll("select[name='novoEscopoIdClasse_"+idOsCatalogo[x].value+"[]']");
            if(quantidade){
                for(y=0;y<quantidade.length;y++){
                    if(!quantidade[y].value || quantidade[y].value == null || quantidade[y].value == ""){
                        $(quantidade[y]).css('border-color', 'red');
                        alert("Quantidade não informada.");
                        return
                    }
                    if(!catalogoDesc[y].value || catalogoDesc[y].value == null || catalogoDesc[y].value == ""){
                        $(catalogoDesc[y]).css('border-color', 'red');
                        alert("Os dados não foram preenchidos.");
                        return
                    }
                    if(!classe[y].value || classe[y].value == null || classe[y].value == ""){
                        $(classe[y]).css('border-color', 'red');
                        alert("Classe não informada.");
                        return
                    }
                }
            }
        }

        var idOrcamentoItemChecklist = document.querySelectorAll("#idOrcamentoItemChecklist");
        for(x=0;x<idOrcamentoItemChecklist.length ; x++){
            novoEscopoIdProduto = document.querySelectorAll("input[name='novoEscopoIdProduto_"+idOrcamentoItemChecklist[x].value+"[]']");
            quantidade = document.querySelectorAll("input[name='novoEscopoQtd_"+idOrcamentoItemChecklist[x].value+"[]']");
            classe = document.querySelectorAll("select[name='novoEscopoIdClasse_"+idOrcamentoItemChecklist[x].value+"[]']");
            if(quantidade){
                for(y=0;y<quantidade.length;y++){
                    if(!quantidade[y].value || quantidade[y].value == null || quantidade[y].value == ""){
                        $(quantidade[y]).css('border-color', 'red');
                        alert("Quantidade não informada.");
                        return;
                    }
                    if(!novoEscopoIdProduto[y].value || novoEscopoIdProduto[y].value == null || novoEscopoIdProduto[y].value == ""){
                        $(novoEscopoIdProduto[y]).css('border-color', 'red');
                        alert("Os dados não foram preenchidos.");
                        return;
                    }
                    if(!classe[y].value || classe[y].value == null || classe[y].value == ""){
                        $(classe[y]).css('border-color', 'red');
                        alert("Classe não informada.");
                        return;
                    }
                }
            }
        }

        var idOrcEscopo = document.querySelectorAll("input[name='idOrcamentoItemChecklist[]']");
        for(x=0;x<idOrcEscopo.length ; x++){
            idpn = document.querySelectorAll("input[name='idpn_"+idOrcEscopo[x].value+"[]']");
            idOrcServicoEscopo = document.querySelectorAll("input[name='idOrcServicoEscopoItens_"+idOrcEscopo[x].value+"[]']")
            for(y=0;y<idpn.length;y++){
                if(idpn[y]){
                    qtd = document.querySelector("input[name='pnQtd_"+idOrcServicoEscopo[y].value+"']");
                    pnIdclasse = document.querySelector("select[name='pnIdClasse_"+idOrcServicoEscopo[y].value+"']");
                    if(qtd && pnIdclasse && idpn[y].value){
                        if(qtd.value == "" || !qtd.value || pnIdclasse.value == "" || !pnIdclasse.value){
                            alert("Informe a quantidade e a classe dos PN que foram preenchidos.");
                            return;
                        }
                    }
                    
                    
                }
            }
            
        }
        $("#formFinalizar").append("<input type='hidden' name='btnSalvar' value='1'>") 
        $("#formFinalizar").submit();

        
    }

    function adicionarItemCatalogo(pos) {
        var table = document.getElementById("tableEscopo_" + pos).getElementsByTagName('tbody')[0];
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        $("#tableEscopo_" + pos).children("tbody").append( '<tr><td><input type="checkbox" name="checkItemComercial_novo_' + pos + '[]" class="span12"  id="checkItemComercial_novo" value=""></td><td style="width:130px"><input type="text" class="span12" name="novoCatalogoPN_' + pos + '[]" id="novoCatalogoPN_' + pos + '_' + numOfRows + '"><input type="hidden" class="span12" name="novoCatalogoIdProduto_' + pos + '[]" id="novoCatalogoIdProduto_' + pos + '_' + numOfRows + '"></td><td><input type="text" class="span12" readonly name="novoCatalogoDescProd_' + pos + '[]" id="novoCatalogoDescProd_' + pos + '_' + numOfRows + '"></td><td style="width:50px"><input type="text" class="span12" name="novoCatalogoQtd_' + pos + '[]" id="novoCatalogoQtd_' + pos + '_' + numOfRows + '"></td><td><select class="span12" name="novoEscopoIdClasse_' + pos + '[]" id="novoEscopoIdClasse_' + pos + '_' + numOfRows + '"><option value="">Selecione</option><option value="cil">Cilindro</option>' +
            '<option value="maq">Máquina</option>' +
            '<option value="pec">Peça</option>' +
            '<option value="sub">Subconjunto</option></select></td><td></td><td></td><td><button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow3(this.parentNode.parentNode.rowIndex,'+pos+')"><font size=1>Excluir</font></button></td></tr>');
        $('#novoCatalogoPN_' + pos + '_' + numOfRows).autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
            minLength: 1,
            select: function(event, ui) {
                valor = this.id.split("_");
                $('#novoCatalogoDescProd_' + pos + '_' + numOfRows).val(ui.item.produtos);
                $('#novoCatalogoIdProduto_' + pos + '_' + numOfRows).val(ui.item.id);
            }
        });
        $( "#novoCatalogoPN_" + pos + '_'+numOfRows ).keyup(function(event) {
            valor = this.id.split("_");
            if(event.which != 13){
                $('#novoCatalogoIdProduto_' + valor[1] + '_' + valor[2]).val('')
            }
            
        });
    }
    function adicionarItemCheckList(pos) {
        var table = document.getElementById("tableEscopo_" + pos).getElementsByTagName('tbody')[0];
        if (table.rows.length == null || typeof table.rows.length == "undefined") {
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }
        $("#tableEscopo_" + pos).children("tbody").append( '<tr><td></td><td><input type="checkbox" name="checkItemComercial_novo_' + pos + '[]" class="span12"  id="checkItemComercial_novo" value=""></td><td><input type="text" class="span12" name="novoEscopoPN_' + pos + '[]" id="novoEscopoPN_' + pos + '_' + numOfRows + '"><input type="hidden" class="span12" name="novoEscopoIdProduto_' + pos + '[]" id="novoEscopoIdProduto_' + pos + '_' + numOfRows + '"></td><td><input type="text" class="span12" readonly name="novoEscopoDescProd_' + pos + '[]" id="novoEscopoDescProd_' + pos + '_' + numOfRows + '"></td><td></td><td style="width:50px"><input type="text" class="span12 number" name="novoEscopoQtd_' + pos + '[]" id="novoEscopoQtd_' + pos + '_' + numOfRows + '"></td><td><select class="span12" name="novoEscopoIdClasse_' + pos + '[]" id="novoEscopoIdClasse_' + pos + '_' + numOfRows + '"><option value="">Selecione</option><option value="cil">Cilindro</option>' +
            '<option value="maq">Máquina</option>' +
            '<option value="pec">Peça</option>' +
            '<option value="sub">Subconjunto</option></select></td><td></td><td><button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deleteRow3(this.parentNode.parentNode.rowIndex,'+pos+')"><font size=1>Excluir</font></button></td></tr>');
        $('#novoEscopoPN_' + pos + '_' + numOfRows).autocomplete({
            source: "<?php echo base_url(); ?>index.php/almoxarifado/autoCompleteProd2",
            minLength: 1,
            select: function(event, ui) {
                //valor = this.id.split("_");
                $('#novoEscopoDescProd_' + pos + '_' + numOfRows).val(ui.item.produtos);
                $('#novoEscopoIdProduto_' + pos + '_' + numOfRows).val(ui.item.id);
            }
        });
        $( "#novoEscopoPN_" + pos + '_'+numOfRows ).keyup(function(event) {
            valor = this.id.split("_");
            if(event.which != 13){
                $('#novoEscopoIdProduto_' + valor[1] + '_' + valor[2]).val('')
            }
        });
    }
    function deleteRow3(i,pos){
        document.getElementById("tableEscopo_" + pos).deleteRow(i);
    }
    function modelConfirmarFinalizacao(){
        
        $('#modelFinalizar').modal('show');
    }
    function salvarArquivo(pos,idOrcItem,idOrcSerItem){
        //var valueNome = document.querySelector("#nomeArquivo_"+pos).value;
        var file_data = document.getElementById('imag_'+pos);   
        var form_data = new FormData();                  
        form_data.append('file', file_data.files[0]);
        form_data.append('idOrcSerItem', idOrcSerItem);
        form_data.append('idOrcItem', idOrcItem);/*
        if(!valueNome || !file_data.files[0]){
            alert("Informe um nome e um arquivo válido.");
            return;
        }
        form_data.append('nomeArquivo', valueNome);*/
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/cadastrarDesenhoNoItem",
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            data:form_data ,
            success: function(data2) {
                alert("Desenho anexado com sucesso.");
                //document.querySelector("#nomeArquivo_"+pos).value = "";
                $("#imag_"+pos).val(null); 
                atualizarTabelaAnexo(pos,data2.anexoGeral,data2.anexoItem,data2.nome)
            },
            error: function(xhr, textStatus, error) {
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
    }/**/
    function salvarArquivo2(pos,idOrcItem,idOrcSerItem){
        //var valueNome = document.querySelector("#nomeArquivoOs_"+pos).value;
        var file_data = document.getElementById('imagOs_'+pos);
        var form_data = new FormData();
        form_data.append('file', file_data.files[0]);
        form_data.append('idOsSub', idOrcSerItem);
        form_data.append('idOs', idOrcItem);/*
        if(!valueNome || !file_data.files[0]){
            alert("Informe um nome e um arquivo válido.");
            return;
        }
        form_data.append('nomeArquivo', valueNome);*/
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/cadastrarDesenhoNaSubOs",
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            data:form_data ,
            success: function(data2) {
                alert("Desenho anexado com sucesso.");
                //document.querySelector("#nomeArquivoOs_"+pos).value = "";
                $("#imagOs_"+pos).val(null); 
                atualizarTabelaAnexo(pos,data2.anexoGeral,data2.anexoItem,data2.nome);
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
    function atualizarTabelaAnexo(pos,anexosGeral,anexosItem){
        //var posGeral = pos.toString().split("_");
        //posGeral = posGeral[1];
        var statusAnexo1 = false;
        var statusAnexo2 = false;
        var statusAnexo3 = false;
        if(anexosGeral.length > 0){           
            if(pos.toString().indexOf("_") != -1) {
                pos2 = pos.toString().split("_")[0];
            }else{
                pos2 = pos;
            }
            $('#tableDesenhos_'+pos2+'_ tbody').empty();
            html = "";/**/
            for(x=0;x<anexosGeral.length;x++){
                html += '<tr>'+
                    '<td><a href="<?php echo base_url();?>'+anexosGeral[x].caminho+anexosGeral[x].imagem + '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a><a href="<?php echo base_url();?>'+anexosGeral[x].caminho+anexosGeral[x].imagem + '" target="_blank">'+anexosGeral[x].nomeArquivo + anexosGeral[x].extensao + '</a></td>'+
                    '<td>'+(anexosGeral[x].statusAnexo == 1 ? 'Aguardando Verificação' : (anexosGeral[x].statusAnexo == 2 ? 'Aprovado' : 'Rejeitado'))+'</td>';
                    if(anexosGeral[x].statusAnexo == 3){
                        html +=  '<td style="text-align: center;"><a onclick="aprovarDesenho('+anexosGeral[x].idAnexo+','+pos2+')"  data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>'+
                         '<td></td>';
                    }else if(anexosGeral[x].statusAnexo == 2){
                        html +=  '<td></td>'+
                        '<td style="text-align: center;"><a onclick="reprovarDesenho('+anexosGeral[x].idAnexo+','+pos2+')" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
                                                                                            
                    }else{
                        html +=  '<td style="text-align: center;"><a onclick="aprovarDesenho('+anexosGeral[x].idAnexo+','+pos2+')" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>'+
                        '<td style="text-align: center;"><a onclick="reprovarDesenho('+anexosGeral[x].idAnexo+','+pos2+')" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';

                    }
                    '</tr>';
            }
            if(anexosGeral.length>0){
                //$('#aDesenho_'+pos).removeClass('bt bt-warning');
                //$('#aDesenho_'+pos).css('color','white');
                //$('#aDesenho_'+pos).css('background-color','#999');
                $('#des_'+pos).removeAttr('background');
                $('#des_'+pos).attr('style','background:url("<?php echo base_url();?>/img/alert.png") no-repeat center');
            }else{
                //$('#aDesenho_'+pos).removeAttrs('class');
                //$('#aDesenho_'+pos).removeAttr('color');
                //$('#aDesenho_'+pos).removeAttr('background-color');
                //$('#aDesenho_'+pos).addClass('bt bt-warning');
                $('#des_'+pos).removeAttr('background');
                $('#des_'+pos).attr('style','background:url("<?php echo base_url();?>/img/block.png") no-repeat center');
            }
            $('#tableDesenhos_'+pos2+'_ tbody').append(html);
        }
        if(anexosItem.length >0 ){
            $('#tableDesenhos_'+pos+' tbody').empty();
            html = "";
            for(x=0;x<anexosItem.length;x++){
                html += '<tr>'+
                    '<td><a href="<?php echo base_url();?>'+anexosItem[x].caminho+anexosItem[x].imagem + '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a><a href="<?php echo base_url();?>'+anexosItem[x].caminho+anexosItem[x].imagem + '" target="_blank">'+anexosItem[x].nomeArquivo + anexosItem[x].extensao + '</a></td>'+
                    '<td>'+(anexosItem[x].statusAnexo == 1 ? 'Aguardando Verificação' : (anexosItem[x].statusAnexo == 2 ? 'Aprovado' : 'Rejeitado'))+'</td>';
                    if(anexosItem[x].statusAnexo == 3){
                        html +=  '<td style="text-align: center;"><a onclick="aprovarDesenho('+anexosItem[x].idAnexo+',\''+pos+'\')"  data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>'+
                         '<td></td>';
                    }else if(anexosItem[x].statusAnexo == 2){
                        html +=  '<td></td>'+
                        '<td style="text-align: center;"><a onclick="reprovarDesenho('+anexosItem[x].idAnexo+',\''+pos+'\')" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';
                                                                                            
                    }else{
                        html +=  '<td style="text-align: center;"><a onclick="aprovarDesenho('+anexosItem[x].idAnexo+',\''+pos+'\')" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-success tip-top" ><i class="icon-ok"></i></a></td>'+
                        '<td style="text-align: center;"><a onclick="reprovarDesenho('+anexosItem[x].idAnexo+',\''+pos+'\')" data-toggle="modal" role="button" style="margin-right: 1%"class="btn btn-danger tip-top" ><i class="icon-remove"></i></a></td>';

                    }
                    '</tr>';
                if(anexosItem[x].statusAnexo == 1){
                    statusAnexo1 = true;
                }
                if(anexosItem[x].statusAnexo == 2){
                    statusAnexo2 = true;
                }
                if(anexosItem[x].statusAnexo == 3){
                    statusAnexo3 = true;
                }
            }
            
            if(statusAnexo1){
                $('#i_'+pos).removeClass('icon-ban-circle');
                $('#i_'+pos).removeClass('fas fa-exclamation-triangle');                
                $('#i_'+pos).removeClass('icon-ok');
                $('#i_'+pos).addClass('fas fa-exclamation-triangle');
                $('#i_'+pos).css('color','orange');
            }else if(statusAnexo2){
                $('#i_'+pos).removeClass('icon-ban-circle');
                $('#i_'+pos).removeClass('fas fa-exclamation-triangle');                
                $('#i_'+pos).removeClass('icon-ok');
                $('#i_'+pos).addClass('icon-ok');
                $('#i_'+pos).css('color','green');
            }else{
                $('#i_'+pos).removeClass('icon-ban-circle');
                $('#i_'+pos).removeClass('fas fa-exclamation-triangle');                
                $('#i_'+pos).removeClass('icon-ok');
                $('#i_'+pos).addClass('icon-ban-circle');
                $('#i_'+pos).css('color','grey');
            }
            $('#tableDesenhos_'+pos+' tbody').append(html);
        }
        
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
    function aprovarDesenho(idAnexo,pos){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/aprovardesenho",
            type: 'POST',
            dataType: 'json',
            data: {
            idAnexo: idAnexo
            },
            success: function(data2) {
                atualizarTabelaAnexo(pos,data2.anexoGeral,data2.anexoItem);
                alert("Desenho aprovado com sucesso.")
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
    function reprovarDesenho(idAnexo,pos){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/reprovardesenho",
            type: 'POST',
            dataType: 'json',
            data: {
                idAnexo: idAnexo
            },
            success: function(data2) {
                atualizarTabelaAnexo(pos,data2.anexoGeral,data2.anexoItem)
                alert("Desenho reprovado com sucesso.")
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
    
    function salvarPn(idServicoEscopoItens,posicao,item){
        var pn = document.querySelector("#pn_"+posicao);
        var idpn = document.querySelector("#idpn_"+posicao);
        var pnQtd = document.querySelector("#pnQtd_"+posicao);
        var pnIdClasse = document.querySelector("#pnIdClasse_"+posicao);
        var checkbox = document.querySelector("#checkItemComercial2_novo_"+posicao);
        var pnQtd2 = "";
        if(pnQtd != null && pnQtd.value){
            pnQtd2 = pnQtd.value;
        }else{
            return;
        }
        var pnIdClasse2 = "";
        if(pnIdClasse != null && pnIdClasse.value){
            pnIdClasse2 = pnIdClasse.value;
        }else{
            return;
        }
        
        if(pn.value || idpn.value){
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/desenho/salvarpndesenho",
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    pn: pn.value,
                    idpn: idpn.value,
                    idServicoEscopoItens: idServicoEscopoItens,
                    pnQtd: pnQtd2,
                    pnIdClasse: pnIdClasse2,
                    checkbox:checkbox.checked
                },
                success: function(data2) {
                    console.log(data2.result)
                    if(data2.result){
                        $("#descpn_"+posicao).empty();
                        $("#descpn_"+posicao).append(data2.produto.descricao);
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
    }
    
    function modelReavalicaoDesenho(){
        $('#model-reavaliacaodesenho').modal('show'); 
    }
    /*
    function abrirModal(item){
        $(item).removeAttr("readonly");

    }*/
</script>