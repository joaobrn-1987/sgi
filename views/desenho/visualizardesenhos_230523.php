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
<form action="<?php echo base_url() ?>index.php/desenho/finalizar"    method="post" name="form1" id="form1">
    <div align='center'>    
        </br>
        <a type="button" onclick="modelConfirmarFinalizacao()" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success"><i class="icon-plus icon-white"></i> Finalizar</a>
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
                                                foreach($result as $d){
                                                    echo '<tr class="trpai'.$d->idOrcamento_item.$d->idOs.'">';
                                                        if($d->statusDesenho == 1 || $d->statusDesenho == 2){
                                                            echo '<td onclick="openclose(this,'.$d->idOrcamento_item.$d->idOs.')"  style="text-align: center; /* padding: 75px 5px 75px 5px */ display: table-cell;min-height: 10em;vertical-align: middle;"><a class="detail-icon"><i class="fa fa-plus"></i></a></td>';
                                                        }else{
                                                            echo '<td style="text-align: center;"><a class="detail-icon" ><i class=""></i></a></td>';                                                        
                                                        }
                                                        echo '<td style="/* padding: 50px 5px 50px 5px */ "><div id="origem" class="span12" style="padding: 0.2%; margin-left: 0">';
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
                                                            if($d->statusDesenho == 1 || $d->statusDesenho == 2){
                                                                if($d->tipoOrc == 'serv'){
                                                                    $anexoImagens2 = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao($d->idOrcamento_item); 
                                                                }
                                                                if($d->tipoOrc == 'fab'){
                                                                    $anexoImagens2 = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao4($d->idOs); 
                                                                }
                                                                echo '<div class="span1">' .
                                                                '<label></label>';
                                                                if($d->tipoOrc == 'serv'){                                                                
                                                                    echo '<a href="#modal-imagem_' .$d->idOrcamento_item. '" role="button" data-toggle="modal" style="margin-left: 10px;" class="btn btn-warning"  class="span12" >Anexo desenho</a>'.
                                                                        '<div id="modal-imagem_'.$d->idOrcamento_item.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                            '<div class="modal-header">'.
                                                                                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                                '<h5 id="myModalLabel">Anexar Desenho. PN.: '.$d->pn.'</h5>'.
                                                                            '</div>'.
                                                                            '<div class="modal-body">'.
                                                                                '<div class="span12">'. 
                                                                                    '<div class="span3">'.
                                                                                        '<label>Nome Arquivo</label>'.
                                                                                        '<input type="text" name="nomeArquivo_'.$d->idOrcamento_item.'[]" id="nomeArquivo_'.$d->idOrcamento_item.'">'.
                                                                                    '</div>'.
                                                                                    '<div class="span3">'.
                                                                                        '<label> Arquivo </label>'.
                                                                                        '<input type="file"  name="imag_'.$d->idOrcamento_item.'" id="imag_'.$d->idOrcamento_item.'" accept=".pdf,.dwg">'.
                                                                                    '</div>'.   
                                                                                    '<div class=""span3>'.
                                                                                        '<a onclick="salvarArquivo('.$d->idOrcamento_item.','.$d->idOrcamento_item.',\'\')" role="button" data-toggle="modal" style="margin-right: 1%" class="btn btn-success" ><i class="fa fa-plus" style="color:white"></i> Salvar Desenho</a>'.
                                                                                    '</div>'.
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
                                                                                                                    '<table class="table table-bordered " id="tableDesenhos_'.$d->idOrcamento_item.'_">'.
                                                                                                                        '<thead>'.
                                                                                                                            '<tr>'.
                                                                                                                                '<th>Arquivo</th>'.
                                                                                                                                '<th>Status Desenho</th>'.
                                                                                                                                '<th>Aprovar</th>'.
                                                                                                                                '<th>Reprovar</th>' .         
                                                                                                                            '</tr>'.
                                                                                                                        '</thead>'.
                                                                                                                        '<tbody>';
                                                                                                                            '<tr>'.
                                                                                                                                '<td></td>'.
                                                                                                                                '<td></td>'.
                                                                                                                                '<td></td>'.
                                                                                                                                '<td></td>'.
                                                                                                                            '</tr>';  
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
                                                                    echo '<a href="#modal-imagem_' .$d->idOs. '" role="button" data-toggle="modal" style="margin-left: 10px;" class="btn btn-warning"  class="span12" >Anexo desenho</a>'.
                                                                        '<div id="modal-imagem_'.$d->idOs.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                            '<div class="modal-header">'.
                                                                                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                                '<h5 id="myModalLabel">Anexar Desenho. O.S.:'.$d->idOs.'</h5>'.
                                                                            '</div>'.
                                                                            '<div class="modal-body">'.
                                                                                '<div class="span12">'. 
                                                                                    '<div class="span3">'.
                                                                                        '<label>Nome Arquivo</label>'.
                                                                                        '<input type="text" name="nomeArquivoOs_'.$d->idOs.'[]" id="nomeArquivoOs_'.$d->idOs.'">'.
                                                                                    '</div>'.
                                                                                    '<div class="span3">'.
                                                                                        '<label> Arquivo </label>'.
                                                                                        '<input type="file"  name="imagOs_'.$d->idOs.'" id="imagOs_'.$d->idOs.'" accept=".pdf,.dwg">'.
                                                                                    '</div>'.   
                                                                                    '<div class=""span3>'.
                                                                                        '<a onclick="salvarArquivo2('.$d->idOs.','.$d->idOs.',\'\')" role="button" data-toggle="modal" style="margin-right: 1%" class="btn btn-success" ><i class="fa fa-plus" style="color:white"></i> Salvar Desenho</a>'.
                                                                                    '</div>'. 
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
                                                            }
                                                            
                                                            echo '</div>';
                                                        echo '</div></td>';
                                                        
                                                    echo '</tr>';
                                                    if($d->tipoOrc == 'serv'){
                                                        $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($d->idOrcamento_item);
                                                        if (!empty($escopo)) {
                                                            $possuiEscopo = true;
                                                            $statusEscopo = $escopo->descricaoPeritagem;
                                                            $escopoItens = $this->peritagem_model->itensPeritagem($escopo->idOrcServicoEscopo);
                                                        }
                                                        echo '<tr class="trfilho'.$d->idOrcamento_item.$d->idOs.'" style="display:none">';/**/
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;"> ';
                                                            echo '</td>';
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">';
                                                                echo '<div id="escopo_' . $contador_local_autocomplete . '">';
                                                                    echo '<h5>Checklist</h5>';
                                                                    echo '<table class="table table-bordered " id="tableEscopo_' . $contador_local_autocomplete . '">' .
                                                                        '<thead>' .
                                                                        '<tr>' .
                                                                        '<th>PN</th>' .
                                                                        '<th>DESCRIÇÃO</th>' .
                                                                        '<th>CLASSE</th>' .
                                                                        '<th>QTD</th>' .
                                                                        '<th>Ø EXT.</th>' .
                                                                        '<th>Ø INT.</th>' .
                                                                        '<th>COMP.</th>' .
                                                                        '<th>OBS.</th>' .
                                                                        '<th>Des.</th>'.
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
                                                                                    '<td>' . $r->pn . '</td>' .
                                                                                    '<td>' . $r->descricaoServicoItens . '</td>' .
                                                                                    '<td>' . $r->descricaoClasse . '</td>';
                                                                                echo '<td>' . $r->quantidade . '</td>';
                                                                                echo '<td>' . $r->dimenExt . '</td>';
                                                                                echo '<td>' . $r->dimenInt . '</td>';
                                                                                echo '<td>' . $r->dimenComp . '</td>';
                                                                                echo '<td>' . $r->obs . '</td>';
                                                                                echo '<td>'.
                                                                                    '<a href="#modal-imagem_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" role="button" data-toggle="modal" style="margin-right: 1%" class="btn tip-top" ><i id="i_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" class="'.($verifyAnexo == 1 ?"fas fa-exclamation-triangle":($verifyAnexo == 2 ?"icon-ok":"icon-ban-circle")).'" style="color:'.($verifyAnexo == 1 ?"orange":($verifyAnexo == 2 ?"green":"grey")).'"></i></a>'.
                                                                                    '<div id="modal-imagem_'.$d->idOrcamento_item.'_'.$r->idOrcServicoEscopoItens.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                                        '<div class="modal-header">'.
                                                                                            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                                            '<h5 id="myModalLabel">Anexar Desenho PN: '.$r->pn.' | Descrição: '.$r->descricaoServicoItens.'</h5>'.
                                                                                        '</div>'.
                                                                                        '<div class="modal-body">'.
                                                                                            '<div class="span12">'. 
                                                                                                '<div class="span3">'.
                                                                                                    '<label>Nome Arquivo</label>'.
                                                                                                    '<input type="text" name="nomeArquivo_'.$d->idOrcamento_item.'[]" id="nomeArquivo_'.$d->idOrcamento_item.'_'. $r->idOrcServicoEscopoItens .'">'.
                                                                                                '</div>'.
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
                                                                                echo'</tr>';
                                                                            }
                                                                        }
                                                                        echo '</tbody>'. 
                                                                        '</table>';
                                                                echo '</div>';
                                                            echo '</td>'; 
                                                        echo '</tr>';
                                                    }
                                                    if($d->tipoOrc == 'fab'){
                                                        $subdOs = $this->os_model->getSubOsByIdOrcamentoItem($d->idOrcamento_item);
                                                        echo '<tr class="trfilho'.$d->idOrcamento_item.$d->idOs.'" style="display:none">';/**/
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;"> ';
                                                            echo '</td>';
                                                            echo '<td style="background-color: #efefef;padding-top: 0px;border-top: 0px;">';
                                                                echo '<div id="escopo_' . $contador_local_autocomplete . '">';
                                                                    echo '<h5>Sub OS</h5>';
                                                                    echo '<table class="table table-bordered " id="tableEscopo_' . $contador_local_autocomplete . '">' .
                                                                        '<thead>' .
                                                                        '<tr>' .
                                                                        '<th>SUB O.S.</th>' .
                                                                        '<th>TIPO</th>' .
                                                                        '<th>DESCRIÇÃO</th>' .
                                                                        '<th>PN</th>' .
                                                                        '<th>QTD</th>' .
                                                                        '<th></th>' .
                                                                        '</tr>' .
                                                                        '</thead>' .
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
                                                                                echo '<tr>' .
                                                                                    '<input type="hidden" name="idOs[]" value="' . $r->idOs . '">' .
                                                                                    '<input type="hidden" name="idSubOs'.$r->idOsSub.'[]" value="">' .
                                                                                    '<td>' . $r->idOs.'.'. $r->posicao. '</td>' .
                                                                                    '<td>' . $r->tipoOrc. '</td>' .
                                                                                    '<td>' . $r->descricaoOsSub . '</td>';
                                                                                echo '<td>' . $r->pn . '</td>';
                                                                                echo '<td>' . $r->quantidade . '</td>';
                                                                                echo '<td>'.
                                                                                    '<a href="#modal-imagem_'.$r->idOs.'_'.$r->idOsSub.'" role="button" data-toggle="modal" style="margin-right: 1%" class="btn tip-top" ><i  id="i_'.$r->idOs.'_'.$r->idOsSub.'" class="'.($verifyAnexo == 1 ?"fas fa-exclamation-triangle":($verifyAnexo == 2 ?"icon-ok":"icon-ban-circle")).'" style="color:'.($verifyAnexo == 1 ?"orange":($verifyAnexo == 2 ?"green":"grey")).'"></i></a>'.
                                                                                    '<div id="modal-imagem_'.$r->idOs.'_'.$r->idOsSub.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.
                                                                                        '<div class="modal-header">'.
                                                                                            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'.
                                                                                            '<h5 id="myModalLabel">Anexar Desenho. O.S.: '.$r->idOs.'.'.$r->posicao.'. PN: '.$r->pn.'</h5>'.
                                                                                        '</div>'.
                                                                                        '<div class="modal-body">'.
                                                                                            '<div class="span12">'. 
                                                                                                '<div class="span3">'.
                                                                                                    '<label>Nome Arquivo</label>'.
                                                                                                    '<input type="text" name="nomeArquivoOs_'.$r->idOs.'[]" id="nomeArquivoOs_'.$r->idOs.'_'. $r->idOsSub .'">'.
                                                                                                '</div>'.
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
                                                                                    '</div>';                                                                            
                                                                                echo'</tr>';
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
        <a type="button" onclick="modelConfirmarFinalizacao()" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success"><i class="icon-plus icon-white"></i> Finalizar</a>
    </div> 
</form>


<div id="modalAprovar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/desenho/aprovardesenho" method="post" enctype="multipart/form-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Deseja aprovar esse desenho? </h5>
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
<script>
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
    function modelConfirmarFinalizacao(){
        $('#modelFinalizar').modal('show');
    }
    function salvarArquivo(pos,idOrcItem,idOrcSerItem){
        var valueNome = document.querySelector("#nomeArquivo_"+pos).value;
        var file_data = document.getElementById('imag_'+pos);   
        var form_data = new FormData();                  
        form_data.append('file', file_data.files[0]);
        form_data.append('idOrcSerItem', idOrcSerItem);
        form_data.append('idOrcItem', idOrcItem);
        if(!valueNome || !file_data.files[0]){
            alert("Informe um nome e um arquivo válido.");
            return;
        }
        form_data.append('nomeArquivo', valueNome);
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
                document.querySelector("#nomeArquivo_"+pos).value = "";
                $("#imag_"+pos).val(null); 
                atualizarTabelaAnexo(pos,data2.anexoGeral,data2.anexoItem)
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
        var valueNome = document.querySelector("#nomeArquivoOs_"+pos).value;
        var file_data = document.getElementById('imagOs_'+pos);   
        var form_data = new FormData();                  
        form_data.append('file', file_data.files[0]);
        form_data.append('idOsSub', idOrcSerItem);
        form_data.append('idOs', idOrcItem);
        if(!valueNome || !file_data.files[0]){
            alert("Informe um nome e um arquivo válido.");
            return;
        }
        form_data.append('nomeArquivo', valueNome);
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
                document.querySelector("#nomeArquivoOs_"+pos).value = "";
                $("#imagOs_"+pos).val(null); 
                atualizarTabelaAnexo(pos,data2.anexoGeral,data2.anexoItem);
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
</script>