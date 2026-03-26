<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />
<script src="<?php echo base_url()?>js/jquery.inputmask.bundle.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="icon-tags"></i></span>
                <h5>Relatório de Compras</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="span12">
                                <form class="form-inline" action="<?php echo base_url() ?>index.php/relatorios/relcompras/1" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span4" class="control-group">
                                            <label for="dataInicial" class="control-label">Data da compra/saída estoque</label></br>
                                            De: <input class="data" type="date" name="dataInicial" class="span4" value="<?php if(isset($dataInicial)){echo $dataInicial;} ?>"/> |
                                            Até:<input class="data" type="date" name="dataFinal" class="span4" value="<?php if(isset($dataFinal)){echo $dataFinal;} ?>"/>
                                        </div>
                                        <div class="span6" class="control-group">
                                            <label class="control-label">Por:</label></br>
                                            <table>
                                                <tr>
                                                    <td><input type="checkbox" id='checkFornecedores' name="agrupar[]" class='check' value="fornecedores" <?php $forn = (isset($agrupar) && in_array('fornecedores', $agrupar)); if($forn) echo 'checked'; ?>> &nbsp;Fornecedores</td>
                                                    <td><input type="checkbox" id='checkClientes' name="agrupar[]" class='check' value="clientes" <?php $cli = (isset($agrupar) && in_array('clientes', $agrupar)); if($cli) echo 'checked'; ?>> &nbsp;Clientes</td>
                                                    <td><input type="checkbox" id='checkOs' name="agrupar[]" class='check' value="os" <?php $os2 = (isset($agrupar) && in_array('os', $agrupar)); if($os2) echo 'checked'; ?>> &nbsp;O.S.</td>
                                                    <td><input type="checkbox" id='checkPC' name="agrupar[]" class='check' value="pc" <?php $pc2 = (isset($agrupar) && in_array('pc', $agrupar)); if($pc2) echo 'checked'; ?>> &nbsp;O.C.</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" id='checkCategorias' name="agrupar[]" class='check' value="categorias" <?php $categorias2 = (isset($agrupar) && in_array('categorias', $agrupar)); if($categorias2) echo 'checked'; ?>> &nbsp;Categoria</td>
                                                    <td><input type="checkbox" id='checkInsumos' name="agrupar[]" class='check' value="insumos" <?php $insumos2 = (isset($agrupar) && in_array('insumos', $agrupar)); if($insumos2) echo 'checked'; ?>> &nbsp;Insumos</td>
                                                    <td><input type="checkbox" id='checkQuantidade' name="agrupar[]" class='check' value="quantidade" <?php $quantidade = (isset($agrupar) && in_array('quantidade', $agrupar)); if($quantidade) echo 'checked'; ?>> &nbsp;Qtde.</td>
                                                    <td><input type="checkbox" id='checkGrupoCompra' name="agrupar[]" class='check' value="grupoCompra" <?php $grupoCompra2 = (isset($agrupar) && in_array('grupoCompra', $agrupar)); if($grupoCompra2) echo 'checked'; ?>> &nbsp;Grupo Compra</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" id='checkStatus' name="agrupar[]" class='check' value="statuscompra" <?php $status2 = (isset($agrupar) && in_array('statuscompra', $agrupar)); if($status2) echo 'checked'; ?>> &nbsp;Status Compra</td>
                                                    <td><input type="checkbox" id='checkUnidExec' name="agrupar[]" class='check' value="unid_exec" <?php $unidExec2 = (isset($agrupar) && in_array('unid_exec', $agrupar)); if($unidExec2) echo 'checked'; ?>> &nbsp;Unid. Exec.</td>
                                                    <td><input type="checkbox" id='checkStatusExec' name="agrupar[]" class='check' value="status_execucao" <?php $statusExec2 = (isset($agrupar) && in_array('status_execucao', $agrupar)); if($statusExec2) echo 'checked'; ?>> &nbsp;Status Execução</td>
                                                    <td><input type="checkbox" id="checkStatusOs" name="agrupar[]" class="check" value="status_os" <?php if(isset($agrupar) && in_array('status_os', $agrupar)) echo 'checked'; ?>> &nbsp;Status OS</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" id="checkUsuarios" name="agrupar[]" class="check" value="usuarios" <?php if(isset($agrupar) && in_array('usuarios', $agrupar)) echo 'checked'; ?>> &nbsp;Usuário Resp.</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="span2" class="control-group" style="padding-left:30px">
                                            <br>
                                            <button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> Pesquisar</button>
                                        </div>                                      
                                    </div>
                                    <div class="span12" style="margin-left: 0px; display: flex; flex-wrap: wrap; gap: 10px;">
                                        <div class="span3" style="display:<?php if(isset($os2) && $os2){echo 'block';}else{echo 'none';}?>;" id="divOS">
                                            <label for="listOs" class="control-label">OS - (Separe com vírgulas)</label>
                                            <input type="text" name="listOs" class="span12" value="<?php if(isset($listOs)){echo $listOs;} ?>"/>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($pc2) && $pc2){echo 'block';}else{echo 'none';}?>;" id="divPC">
                                            <label for="listPc" class="control-label">OC - (Separe com vírgulas)</label>
                                            <input type="text" name="listPc" class="span12" value="<?php if(isset($listPc)){echo $listPc;} ?>"/>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($forn) && $forn){echo 'block';}else{echo 'none';}?>;" id="divFornecedores">
                                            <label for="idFornecedores[]" class="control-label">Fornecedor:</label>
                                            <div class="card card-body" style="overflow-y: scroll;height: 200px">
                                                <table><?php if(isset($fornecedores)) foreach ($fornecedores as $for) { echo "<tr><td><input type='checkbox' name='idFornecedores[]' ".(isset($idFornecedores) && in_array($for->idFornecedores, $idFornecedores) ? 'checked' : '')." value='{$for->idFornecedores}'> {$for->nomeFornecedor}</td></tr>"; } ?></table>
                                            </div>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($cli) && $cli){echo 'block';}else{echo 'none';}?>;" id="divClientes">
                                            <label for="idClientes[]" class="control-label">Clientes:</label>
                                            <div class="card card-body" style="overflow-y: scroll;height: 200px">
                                                <table><?php if(isset($clientes)) foreach ($clientes as $for) { echo "<tr><td><input type='checkbox' name='idClientes[]' ".(isset($idClientes) && in_array($for->idClientes, $idClientes) ? 'checked' : '')." value='{$for->idClientes}'> {$for->nomeCliente}</td></tr>"; } ?></table>
                                            </div>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($categorias2) && $categorias2){echo 'block';}else{echo 'none';}?>;" id="divCategorias">
                                            <label for="idCategorias[]" class="control-label">Categoria de Insumos:</label>
                                            <div class="card card-body" style="overflow-y: scroll;height: 200px">
                                                <table><?php if(isset($categorias)) foreach ($categorias as $for) { echo "<tr><td><input type='checkbox' name='idCategorias[]' ".(isset($idCategorias) && in_array($for->idCategoria, $idCategorias) ? 'checked' : '')." value='{$for->idCategoria}'> {$for->descricaoCategoria}</td></tr>"; } ?></table>
                                            </div>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($insumos2) && $insumos2){echo 'block';}else{echo 'none';}?>;" id="divInsumos">
                                            <label for="idInsumos[]" class="control-label">Insumos:</label>
                                            <div class="card card-body" style="overflow-y: scroll;height: 200px">
                                                <table>
                                                    <?php 
                                                    if(isset($insumos)) {
                                                        foreach ($insumos as $insumo) { 
                                                            $checked = (isset($idInsumos) && in_array($insumo->idInsumos, $idInsumos)) ? 'checked' : '';
                                                            echo "<tr><td><input type='checkbox' name='idInsumos[]' {$checked} value='{$insumo->idInsumos}'> {$insumo->descricaoInsumo}</td></tr>";
                                                        }
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($grupoCompra2) && $grupoCompra2){echo 'block';}else{echo 'none';}?>;" id="divGrupoCompra">
                                            <label for="idGrupocompras[]" class="control-label">Grupo de compra:</label>
                                            <div class="card card-body" style="overflow-y: scroll;height: 200px">
                                                <table><?php if(isset($grupocompra)) foreach ($grupocompra as $for) { echo "<tr><td><input type='checkbox' name='idGrupocompras[]' ".(isset($idGrupocompras) && in_array($for->idgrupo, $idGrupocompras) ? 'checked' : '')." value='{$for->idgrupo}'> {$for->nomegrupo}</td></tr>"; } ?></table>
                                            </div>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($status2) && $status2){echo 'block';}else{echo 'none';}?>;" id="divStatusCompra">
                                            <label for="idStatusCompras[]" class="control-label">Status da Compra:</label>
                                            <div class="card card-body" style="overflow-y: scroll;height: 200px">
                                                <table><?php if(isset($statuscompras)) foreach ($statuscompras as $status) { echo "<tr><td><input type='checkbox' name='idStatusCompras[]' ".(isset($idStatusCompras) && in_array($status->idStatuscompras, $idStatusCompras) ? 'checked' : '')." value='{$status->idStatuscompras}'> {$status->nomeStatus}</td></tr>"; } ?></table>
                                            </div>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($unidExec2) && $unidExec2){echo 'block';}else{echo 'none';}?>;" id="divUnidExec">
                                            <label for="id_unid_exec[]" class="control-label">Unidade de Execução:</label>
                                            <div class="card card-body" style="overflow-y: scroll;height: 200px">
                                                <table><?php if(isset($unidades_execucao)) foreach ($unidades_execucao as $ue) { echo "<tr><td><input type='checkbox' name='id_unid_exec[]' ".(isset($id_unid_exec) && in_array($ue->id_unid_exec, $id_unid_exec) ? 'checked' : '')." value='{$ue->id_unid_exec}'> {$ue->nome}</td></tr>"; } ?></table>
                                            </div>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($statusExec2) && $statusExec2){echo 'block';}else{echo 'none';}?>;" id="divStatusExec">
                                            <label for="status_execucao[]" class="control-label">Status de Execução:</label>
                                            <div class="card card-body" style="overflow-y: scroll;height: 200px">
                                                <table><?php if(isset($status_execucao_lista)) foreach ($status_execucao_lista as $se) { echo "<tr><td><input type='checkbox' name='status_execucao[]' ".(isset($status_execucao) && in_array($se->status_execucao, $status_execucao) ? 'checked' : '')." value='{$se->status_execucao}'> {$se->status_execucao}</td></tr>"; } ?></table>
                                            </div>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($agrupar) && in_array('status_os', $agrupar)){echo 'block';}else{echo 'none';}?>;" id="divStatusOs">
                                            <label class="control-label">Status OS:</label>
                                            <div class="card card-body" style="overflow-y: scroll;height: 200px">
                                                <table><?php if(isset($status_os_lista)){ foreach ($status_os_lista as $so) { echo "<tr><td><input type='checkbox' name='idStatusOs[]' ".(isset($idStatusOs) && in_array($so->idStatusOs, $idStatusOs) ? 'checked' : '')." value='{$so->idStatusOs}'> {$so->nomeStatusOs}</td></tr>"; } } ?></table>
                                            </div>
                                        </div>
                                        <div class="span3" style="display:<?php if(isset($agrupar) && in_array('usuarios', $agrupar)){echo 'block';}else{echo 'none';}?>;" id="divUsuarios">
                                            <label class="control-label">Usuário Responsável:</label>
                                            <div class="card card-body" style="overflow-y: scroll;height: 200px">
                                                <table>
                                                    <?php if(isset($usuarios_lista)) foreach ($usuarios_lista as $usuario) { 
                                                        echo "<tr><td><input type='checkbox' name='idUsuarios[]' ".(isset($idUsuarios) && in_array($usuario->idUsuarios, $idUsuarios) ? 'checked' : '')." value='{$usuario->idUsuarios}'> {$usuario->nome}</td></tr>"; 
                                                    } ?>
                                                </table>
                                            </div>
                                        </div>
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

<div class="widget-box">
    <div class="widget-title">
        <span class="icon"><i class="icon-list-alt"></i></span>
        <h5>Relatório e Totalizações</h5>
        <div class="buttons">
            <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href="#"><i class="icon-print icon-white"></i> Imprimir</a>
            <a href="#" class="export-csv btn btn-mini btn-inverse" data-filename="Relatorio_Compras">Excel</a>
        </div>
    </div>

    <?php 
    // BUSCA DE ITENS DO ESTOQUE (INJETADO DE FORMA INVISÍVEL PARA NÃO DAR ERRO NO RODAPÉ)
    $total_geral_estoque = 0;
    
    $ci =& get_instance();
    $ci->load->model('almoxarifado_model');
    $whereEstoque = " AND almo_estoque_saida.ocultar = 0";
    if (!empty($ci->input->post('listOs'))) {
        $whereEstoque .= " AND almo_estoque_saida.idOs IN (" . $ci->input->post('listOs') . ")";
    }
    
    // CORREÇÃO AQUI: Troca do isset() por !empty() para ignorar filtros de data vazios
    if (!empty($ci->input->post('dataInicial')) && !empty($ci->input->post('dataFinal'))) {
        $dIni = DateTime::createFromFormat('Y-m-d', $ci->input->post('dataInicial'));
        $dFim = DateTime::createFromFormat('Y-m-d', $ci->input->post('dataFinal'));
        if ($dIni && $dFim) {
            $whereEstoque .= " AND DATE(almo_estoque_saida.data_saida) BETWEEN '" . $dIni->format('Y-m-d') . "' AND '" . $dFim->format('Y-m-d') . "'";
        }
    } elseif (!empty($dataInicial) && !empty($dataFinal)) {
         $whereEstoque .= " AND DATE(almo_estoque_saida.data_saida) BETWEEN '{$dataInicial}' AND '{$dataFinal}'";
    }
    
    $saidas_estoque = $ci->almoxarifado_model->getSaida2($whereEstoque);
    
    if(!empty($saidas_estoque)){
        foreach($saidas_estoque as $saida){
            $total_geral_estoque += ((float)$saida->quantidade * (float)$saida->valorUnit);
        }
    }
    ?>

    <div class="widget-content nopadding" id="divRelatorio">
        <div style="text-align:center; padding: 5px;">
            <?php if(!empty($dataInicial)){echo '<b>Período da Compra:</b> '.date('d/m/Y', strtotime($dataInicial)).' à '.date('d/m/Y', strtotime(isset($dataFinal) ? $dataFinal : $dataInicial));} ?>
        </div>

        <table class="table table-bordered" id="table_relatorio" style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;font-size:10px;" border="1">
            <thead>
                <tr>
                <?php 
                if(!empty($relatorio)): 
                    $arrayKeys = array_keys((array)$relatorio[0]); 
                    foreach($arrayKeys as $r){ 
                        // Oculta a nova coluna ID_OS que usamos na base
                        if($r == 'Total das compras realizadas' || $r == 'idDistribuir' || $r == 'ID_OS') continue;
                        echo '<th>'.$r.'</th>'; 
                    } 
                endif; 
                ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($relatorio)){
                    $somaTotal = 0;
                    $itens_somados = array(); // Controle para não somar itens repetidos

                    foreach($relatorio as $r){
                        echo '<tr>';
                        
                        $idUnico = null;
                        if(isset($r->idDistribuir)) {
                             $idUnico = $r->idDistribuir;
                        } elseif (isset($r->{'Nº OC'})) {
                             $idUnico = 'OC_' . $r->{'Nº OC'};
                        } else {
                             $idUnico = uniqid(); 
                        }

                        if(!in_array($idUnico, $itens_somados)) {
                             $valorLinha = isset($r->{'Total das compras realizadas'}) ? $r->{'Total das compras realizadas'} : 0;
                             $somaTotal += $valorLinha;
                             $itens_somados[] = $idUnico;
                        }

                        foreach($arrayKeys as $d){
                            if($d == 'idDistribuir' || $d == 'Total das compras realizadas' || $d == 'ID_OS') continue;

                            // Formata as colunas monetárias
                            if($d == 'ICMS' || $d == 'IPI' || $d == 'Frete' || 
                               $d == 'Preço Total (Item)' || $d == 'Valor Unitário' ||
                               $d == 'Total das compras realizadas'){
                                echo '<td>R$ '. number_format((float)$r->$d, 2, ',', '.').'</td>';
                            } else {
                                echo '<td>'.$r->$d.'</td>';
                            }
                        }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="1"><h4 style="text-align:center">Nenhum resultado encontrado na base de compras diretas.</h4></td></tr>';
                }
                ?>
            </tbody>
            <?php if(!empty($relatorio)): ?>
            <tfoot>
                <tr style="background-color: #f9f9f9;">
                    <td colspan="<?php echo count($arrayKeys) - (isset($relatorio[0]->idDistribuir) ? 2 : 0) - (isset($relatorio[0]->{'ID_OS'}) ? 1 : 0); ?>" style="text-align:right; font-weight: bold; padding: 10px;">
                        <span style="margin-right: 30px; color: #333;">
                            TOTAL GRID COMPRAS (compras + impostos + frete - descontos): 
                            <span style="color: #000; font-size: 12px;">R$ <?php echo number_format((float)$somaTotal, 2, ',', '.'); ?></span>
                        </span>
                        
                        <span style="margin-right: 30px; color: #d9534f;">
                            CUSTO ESTOQUE / ALMOXARIFADO: 
                            <span style="font-size: 12px;">R$ <?php echo number_format((float)$total_geral_estoque, 2, ',', '.'); ?></span>
                        </span>

                        <span style="color: #2D335B; font-size: 14px; border-left: 2px solid #ccc; padding-left: 15px;">
                            CUSTO TOTAL REAL: 
                            <strong>R$ <?php echo number_format((float)($somaTotal + $total_geral_estoque), 2, ',', '.'); ?></strong>
                        </span>
                    </td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    function toggleFilter(checkboxId, divId) {
        $(checkboxId).on('click', function() {
            $(divId).toggle(this.checked);
        });
    }

    toggleFilter('#checkClientes', '#divClientes');
    toggleFilter('#checkFornecedores', '#divFornecedores');
    toggleFilter('#checkCategorias', '#divCategorias');
    toggleFilter('#checkInsumos', '#divInsumos');
    toggleFilter('#checkOs', '#divOS');
    toggleFilter('#checkPC', '#divPC');
    toggleFilter('#checkGrupoCompra', '#divGrupoCompra');
    toggleFilter('#checkStatus', '#divStatusCompra');
    toggleFilter('#checkUnidExec', '#divUnidExec');
    toggleFilter('#checkStatusExec', '#divStatusExec');
    toggleFilter('#checkStatusOs', '#divStatusOs');
    toggleFilter('#checkUsuarios', '#divUsuarios');

    $("#imprimir").on('click', function(e) {
        e.preventDefault();
        PrintElem('#divRelatorio');
    });

    $(".export-csv").on('click', function(event) {
        event.preventDefault();
        let filename = $(this).data("filename") || "relatorio";
        if(!filename.endsWith('.csv')) { filename += ".csv"; }
        exportTableToCSV($(this), $('#table_relatorio'), filename);
    });

    function PrintElem(elem) {
        var mywindow = window.open('', 'PRINT', 'height=600,width=800');
        mywindow.document.write('<html><head><title>Relatório de Compras</title>');
        mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />');
        mywindow.document.write('</head><body><h1>Relatório de Compras e Custos</h1>');
        mywindow.document.write($(elem).html());
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        mywindow.focus();
        mywindow.print();
        return true;
    }

    function exportTableToCSV($button, $table, filename) {
        var $rows = $table.find('tr');
        var colDelim = ';'; 
        var rowDelim = '\r\n';

        var csv = $rows.map(function (i, row) {
            var $row = $(row), $cols = $row.find('td,th');
            return $cols.map(function (j, col) {
                var $col = $(col);
                var text = $col.text().trim();
                text = text.replace(/"/g, '""'); 
                return '"' + text + '"';
            }).get().join(colDelim);
        }).get().join(rowDelim);

        var csvFile = new Blob(["\uFEFF" + csv], {type: "text/csv;charset=utf-8;"});

        if (window.navigator.msSaveBlob) {
            window.navigator.msSaveBlob(csvFile, filename);
        } else {
            var downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    }
});
</script>