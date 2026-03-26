<?php

    //var_dump($versaoClientes); exit;

    $sucesso = "";
    $ind = 0;
    $idProd = "";

    if($this->session->flashdata('success') != null){

        if($this->session->flashdata('success') == "Produto PN adicionado com sucesso!" ||
           $this->session->flashdata('success') == "Desenho anexado com sucesso!"){

            //$sucesso = "color:green; font-weight: bold;";
            $sucesso = "color:yellow;";
            $ind = 0;

        }else{

            $sucesso = "";

        }

    }

    if($this->session->flashdata('idProdutos') != null){

        $idProd = $this->session->flashdata('idProdutos');
        $sucesso = "color:#FF8C00;font-weight: 600;";

    }

?>

<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/moment.js"></script><!--
<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />

<!--
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script><!--
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
<link href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css" rel="stylesheet">

<style type="text/css">

    .trTituloInicio th{

        background-color: #C0C0C0 !important;

    }

    /* .trTituloEmpresa th{

        background-color: #C0C0C0 !important;

    } */

</style>

<!-- PAGINA CRIAR PN -->
<div id="pndiv">
    <div class="tabbable" style="margin-top: 30px;">
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">

                <!-- CAMPOS DE BUSCA PN -->
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5 style="padding-right: 0px;">Busca PN</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="span12" id="divCadastrarOs">
                                                <form id="formPn" class="form-inline">
                                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                                        
                                                        <!-- PN -->
                                                        <div class="span2" class="control-group">
                                                            <label for="cliente" class="control-label">PN:</label>
                                                            <input class="span12 form-control" id="pn"
                                                                type="text" name="pn" value="" />
                                                            <input class="span12" class="form-control" id="pn4"
                                                                type="hidden" name="pn4" value="" />
                                                        </div>

                                                        <!-- DESCRIÇÃO -->
                                                        <div class="span2" class="control-group">
                                                            <label for="cliente"
                                                                class="control-label">Descrição:</label>
                                                            <input class="span12" class="form-control" id="prod"
                                                                type="text" name="prod" value="" />
                                                            <input id="idProdutos" type="hidden" name="idProdutos"
                                                                value="" />
                                                        </div>

                                                        <!-- REFERENCIA -->
                                                        <div class="span2" class="control-group">
                                                            <label for="cliente"
                                                                class="control-label">Referência:</label>
                                                            <input class="span12" class="form-control" id="ref"
                                                                type="text" name="ref" value="" />
                                                            <input id="referencia" type="hidden" name="referencia"
                                                                value="" />
                                                        </div>

                                                        <!-- EMPRESA -->
                                                        <div class="span2" class="control-group">
                                                            <label for="empresa"
                                                                class="control-label">EMPRESA(CLIENTE):</label>
                                                            <select class="span12 form-control" name="empresa"
                                                                id="empresa">
                                                                
                                                            </select>
                                                        </div>

                                                        <!-- VERSÃO PN -->
                                                        <div class="span2" class="control-group">
                                                            <label for="versaoEmpresa"
                                                                class="control-label">VERSÕES:</label>
                                                            <select class="span12 form-control" name="versaoEmpresa"
                                                                id="versaoEmpresa">
                                                                
                                                            </select>
                                                        </div>

                                                        <!-- BOTÃO BUSCAR -->
                                                        <div class="span2" class="control-group"
                                                            style="margin-left:10px">
                                                            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vDesenho')){ ?>
                                                                <label for="cliente" class="control-label"></label>
                                                                <a class="btn btn-success" name="busca" id="busca"
                                                                    style="justify-content: flex-end; display: table;"
                                                                    onclick="buscarPn()">Buscar
                                                                </a>

                                                            <?php } ?>
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

                <!-- CRIAR PN -->
                <div class="row-fluid" style="margin-top:0">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5 style="padding-right: 0px;">
                                    Criação de PN
                                </h5>
                            </div>
                            
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content">
                                        <br>
                                        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aDesenho')){ ?>
                                            <a href="<?php echo base_url();?>index.php/desenho/page_addPn" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Produto PN</a>
                                        <?php } ?>
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
                        <h5>Produtos PN - Últimos PNs Cadastrados <a href="<?php echo base_url(); ?>index.php/desenho/criar_pn" id="buscaVoltar"></a></h5> 
                    </div>

                </div>

                <!-- TABELA PNs ULTIMOS 10 CADASTRADOS -->
                <div class="widget-content nopadding">

                    <table class="table table-bordered" id="table_PN" style="border-collapse: collapse;
                        font-family:Arial, Helvetica, sans-serif; text-align: center;
	                    font-size:10px;" border="1">

                        <thead>
                            <tr class="trTituloInicio">
                                <th></th>
                                <th>PN</th>
                                <th>Descrição</th>
                                <th>Referência</th>
                                <th>Fornecedor Orig.</th>
                                <th>Equipamento</th>
                                <th>Subconjunto</th>
                                <th>Modelo</th>
                                <th>Revisão</th>
                                <th id="thEmpresa" style="display:none">Empresa</th>
                                <th id="thVersaoEmpresa" style="display:none">Revisão Empresa</th>
                                <th>Usuário Criação</th>
                                <th>Data Modificação</th>
                                <th>Desenho</th>
                                <th>Desenho de Corte</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                          
                            <?php

                                if(!empty($results)){

                                    foreach ($results as $t => $r) {

                                        if($t % 2 == 0){
                                            $cor_fundo = "#efefef";
                                        }else{
                                            $cor_fundo = "#F0F8FF";
                                        }
 
                                        // LISTA PN PRINCIPAL ULTIMA VERSÃO
                                        echo '<tr class="trpai'.$r->idProdutos.'" style="background-color: '.$cor_fundo.';">';

                                            echo '<td onclick="openclose(this,'.$r->idProdutos.',`'.$cor_fundo.'`);" style="text-align: center;font-size: 13px; "><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';
                                            echo '<td style="text-align: center; '.($idProd == $r->idProdutos ? $sucesso : "").'">'.$r->pn.'</td>';
                                            echo '<td style="text-align: center; '.($idProd == $r->idProdutos ? $sucesso : "").'">'.$r->descricao.'</td>';
                                            echo '<td style="text-align: center; '.($idProd == $r->idProdutos ? $sucesso : "").'">'.$r->referencia.'</td>';
                                            echo '<td style="text-align: center; '.($idProd == $r->idProdutos ? $sucesso : "").'">'.$r->fornecedor_original.'</td>';
                                            echo '<td style="text-align: center; '.($idProd == $r->idProdutos ? $sucesso : "").'">'.$r->equipamento.'</td>';
                                            echo '<td style="text-align: center; '.($idProd == $r->idProdutos ? $sucesso : "").'">'.$r->subconjunto.'</td>';
                                            echo '<td style="text-align: center; '.($idProd == $r->idProdutos ? $sucesso : "").'">'.$r->modelo.'</td>';
                                            echo '<td style="text-align: center; '.($idProd == $r->idProdutos ? $sucesso : "").'"> <font size="2"><b>v'.$r->versao.' </b></font></td>';
                                            echo '<td style="text-align: center; '.($idProd == $r->idProdutos ? $sucesso : "").'">'.$r->nome_user.'</td>';
                                            echo '<td style="text-align: center; '.($idProd == $r->idProdutos ? $sucesso : "").'"> '.date("d/m/Y H:i:s",strtotime($r->data_master)).' </td>';

                                            // ARQUIVO PARA DOWNLOAD
                                            if(empty($r->nomeArquivoDwg)){

                                                echo ' 
                                                
                                                    <td style="text-align: center;">
                                                        <font size="2" class="tip-top" title="PN sem Desenho">
                                                            <b style="text-align: center;">
                                                                <i class="icon-ban-circle" style="color:grey"></i>
                                                            </b>
                                                        </font>
                                                    </td>
                                                
                                                ';

                                            }else{

                                                echo '

                                                    <td style="text-align: center;">
                                                        <a class="tip-top" title="Baixar Desenho PN" style="text-align: center; color: green;" 
                                                            href="'.base_url().$r->caminhoDwg.$r->imagemDwg.'" download>
                                                            
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                            </svg>

                                                        </a>
                                                    </td>

                                                ';

                                            }

                                            // ARQUIVO DESENHO DE CORTE PARA DOWNLOAD
                                            if(empty($r->nomeArquivo)){

                                                echo ' 
                                                
                                                    <td style="text-align: center;">
                                                        
                                                    </td>
                                                
                                                ';

                                            }else{

                                                echo '

                                                    <td style="text-align: center;" onclick="corte(`'. $r->pn .'`,`'. $r->descricao .'`,`'. $r->idPn .'`,`'. $r->versao .'`,``,``)" >
                                                        <a 
                                                            class="tip-top" title="Visualizar Desenhos de Corte" style="text-align: center; color: green;">
                                                            
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                            </svg>

                                                        </a>
                                                    </td>

                                                ';

                                            }
                                            
                                            // BOTÔES
                                            echo
                                            '<td>';

                                                echo
                                                '<div class="btn-group" role="group">';
                                                
                                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vDesenho')){
                                                                                    
                                                        echo '<div class="btn-group">
                                                            <a onclick="historico(`'. $r->pn .'`,`'. $r->descricao .'`,`'. $r->idPn .'`,`'. $r->versao .'`,``,``)" class="btn tip-top" title="Visualizar Histórico do PN">
                                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                                </svg>
                                                            </a>
                                                        </div>';

                                                    }

                                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eDesenho')){

                                                        echo ((empty($r->nomeArquivoDwg) || !isset($r->nomeArquivoDwg)) ? '

                                                            <div class="btn-group">

                                                                <a onclick="addDesenho(`'.(empty($r->idPn) ? "" : $r->idPn).'`,`'.$r->idProdutos.'`);" class="btn btn-primary tip-top" style="background-color:#3AD5AC; 
                                                                color:white;" title="Adicionar Desenho">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-cloud-upload-fill" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0z"/>
                                                                    </svg>
                                                                </a>    

                                                            </div>
                                                        
                                                        ' : "").'

                                                        <div class="btn-group">
                                                            <a href="'.base_url(). 'index.php/desenho/page_add_versao_Pn?id='.$r->idProdutos.(empty($r->idPn) ? "" : '&idPn='.$r->idPn).'"
                                                            class="btn btn-primary tip-top" title="Adicionar versão para PN">
                                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-bezier2" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M1 2.5A1.5 1.5 0 0 1 2.5 1h1A1.5 1.5 0 0 1 5 2.5h4.134a1 1 0 1 1 0 1h-2.01c.18.18.34.381.484.605.638.992.892 2.354.892 3.895 0 1.993.257 3.092.713 3.7.356.476.895.721 1.787.784A1.5 1.5 0 0 1 12.5 11h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5H6.866a1 1 0 1 1 0-1h1.711a2.839 2.839 0 0 1-.165-.2C7.743 11.407 7.5 10.007 7.5 8c0-1.46-.246-2.597-.733-3.355-.39-.605-.952-1-1.767-1.112A1.5 1.5 0 0 1 3.5 5h-1A1.5 1.5 0 0 1 1 3.5v-1zM2.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10 10a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
                                                                </svg>
                                                            </a>
                                                        </div>

                                                        <div class="btn-group">
                                                            <a href="'.base_url(). 'index.php/desenho/page_editar_pn?id='.$r->idProdutos.(empty($r->idPn) ? "" : '&idPn='.$r->idPn).'" 
                                                            class="btn btn-info tip-top" title="Editar Produto PN">
                                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                </svg>
                                                            </a>
                                                        </div>';
                                                    
                                                    }

                                                echo '</div>';

                                                

                                            echo
                                            '</td>';

                                        echo '</tr>';

                                        // LISTA VERSÕES DA PN PRINCIPAL
                                        foreach ($versaoPrincipal as $v) {

                                            if($v->idProdutos == $r->idProdutos && $v->empresa == "" &&
                                                $v->versao !== $r->versao){

                                                echo '<tr style="background-color: '.$cor_fundo.';">';
                                                echo '<td></td>';
                                                echo '<td></td>';
                                                echo '<td style="text-align: center;">'.$v->descricao.'</td>';
                                                echo '<td style="text-align: center;">'.$v->referencia.'</td>';
                                                echo '<td style="text-align: center;">'.$v->fornecedor_original.'</td>';
                                                echo '<td style="text-align: center;">'.$v->equipamento.'</td>';
                                                echo '<td style="text-align: center;">'.$v->subconjunto.'</td>';
                                                echo '<td style="text-align: center;">'.$v->modelo.'</td>';
                                                echo '<td style="text-align: center;"><b>v'.$v->versao.'</b></td>';
                                                echo '<td style="text-align: center;">'.$v->nome_user.'</td>';
                                                echo '<td style="text-align: center;">'.date("d/m/Y H:i:s",strtotime($v->data_alteracaoHis)).'</td>';

                                                // TD ARQUIVO PARA DOWNLOAD
                                                    if(empty($v->nomeArquivoDwg)){

                                                        echo ' 
                                                        
                                                            <td style="text-align: center;">
                                                                <font size="2" class="tip-top" title="PN sem Desenho">
                                                                    <b style="text-align: center;">
                                                                        <i class="icon-ban-circle" style="color:grey"></i>
                                                                    </b>
                                                                </font>
                                                            </td>
                                                        
                                                        ';

                                                    }else{

                                                        echo '

                                                            <td style="text-align: center;">
                                                                <a class="tip-top" title="Baixar Desenho PN" style="text-align: center; color: green;" 
                                                                    href="'.base_url().$v->caminhoDwg.$v->imagemDwg.'" download>
                                                                    
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                                    </svg>

                                                                </a>
                                                            </td>

                                                        ';

                                                    }
                                                //----------------------
                                                
                                                // TD DESENHOS DE CORTE PARA DOWNLOAD

                                                    echo ' 
                                                                
                                                        <td style="text-align: center;">
                                                            
                                                        </td>
                                                    
                                                    ';

                                                    
                                                    // if(empty($v->nomeArquivoDwg)){

                                                    //     echo ' 
                                                        
                                                    //         <td style="text-align: center;">
                                                    //             <font size="2" class="tip-top" title="PN sem Desenho">
                                                    //                 <b style="text-align: center;">
                                                    //                     <i class="icon-ban-circle" style="color:grey"></i>
                                                    //                 </b>
                                                    //             </font>
                                                    //         </td>
                                                        
                                                    //     ';

                                                    // }else{

                                                    //     echo '

                                                    //         <td style="text-align: center;">
                                                    //             <a class="tip-top" title="Baixar Desenho PN" style="text-align: center; color: green;" 
                                                    //                 href="'.base_url().$v->caminhoDwg.$v->imagemDwg.'" download>
                                                                    
                                                    //                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    //                     <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                    //                     <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                    //                 </svg>

                                                    //             </a>
                                                    //         </td>

                                                    //     ';

                                                    // }

                                                //----------------------

                                                // BOTÔES
                                                echo '<td>';
                                                
                                                    echo '<div class="btn-group" role="group" style="margin:0px; padding:0px;">';

                                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'vDesenho')){
                                                                                        
                                                            echo '<div class="btn-group">
                                                                <a onclick="historico(`'. $v->pn .'`,`'. $v->descricao .'`,`'. $v->idPn .'`,`'. $v->versao .'`,``,``)" class="btn tip-top" title="Visualizar Histórico do PN">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                                    </svg>
                                                                </a>
                                                            </div>';

                                                        }

                                                        if($this->permission->checkPermission($this->session->userdata('permissao'),'eDesenho')){

                                                            echo ((empty($v->nomeArquivoDwg) || !isset($v->nomeArquivoDwg)) ? '

                                                                <div class="btn-group">

                                                                    <a onclick="addDesenho(`'.(empty($v->idPn) ? "" : $v->idPn).'`,`'.$v->idProdutos.'`);" class="btn btn-primary tip-top" style="background-color:#3AD5AC; 
                                                                    color:white;" title="Adicionar Desenho">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-cloud-upload-fill" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0z"/>
                                                                        </svg>
                                                                    </a>    

                                                                </div>
                                                            
                                                            ' : "").'

                                                            <div class="btn-group">
                                                                <a href="'.base_url(). 'index.php/desenho/page_add_versao_Pn?id='.$v->idProdutos.(empty($v->idPn) ? "" : '&idPn='.$v->idPn).'"
                                                                class="btn btn-primary tip-top" title="Adicionar versão para PN">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-bezier2" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M1 2.5A1.5 1.5 0 0 1 2.5 1h1A1.5 1.5 0 0 1 5 2.5h4.134a1 1 0 1 1 0 1h-2.01c.18.18.34.381.484.605.638.992.892 2.354.892 3.895 0 1.993.257 3.092.713 3.7.356.476.895.721 1.787.784A1.5 1.5 0 0 1 12.5 11h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5H6.866a1 1 0 1 1 0-1h1.711a2.839 2.839 0 0 1-.165-.2C7.743 11.407 7.5 10.007 7.5 8c0-1.46-.246-2.597-.733-3.355-.39-.605-.952-1-1.767-1.112A1.5 1.5 0 0 1 3.5 5h-1A1.5 1.5 0 0 1 1 3.5v-1zM2.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10 10a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
                                                                    </svg>
                                                                </a>
                                                            </div>

                                                            <div class="btn-group">
                                                                <a href="'.base_url(). 'index.php/desenho/page_editar_pn?id='.$v->idProdutos.(empty($v->idPn) ? "" : '&idPn='.$v->idPn).'" 
                                                                class="btn btn-info tip-top" title="Editar Produto PN">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                    </svg>
                                                                </a>
                                                            </div>';
                                                        
                                                        }

                                                    echo '</div>';

                                                echo '</td>';

                                                echo "</tr>";
                                            
                                            }

                                        }

                                        ?>
                                        
                                        <!-- VERSÕES EMPRESAS -->
                                        <tr class="trfilho<?php echo $r->idProdutos;?>" style="display:none; background-color: <?php echo $cor_fundo;?>;">

                                            <td style="padding-top: 0px;" colspan="15">

                                                <div style="margin: 20px; margin-top: 0px;">
                                                    <table class="table table-bordered ">

                                                        <thead>
                                                            <tr class="trTituloEmpresa" id="trTituloEmpresa<?php echo $r->idProdutos; ?>">
                                                                <th></th>
                                                                <th colspan="12"><b>Empresa (Cliente)</b></th>
                                                            </tr>                                                                    
                                                        </thead>
                                                        <tbody style="text-align: center;">

                                                            <?php

                                                                $empre      = array();
                                                                $empre_v    = array();
                                                                $vers_empre = array();

                                                                // MONTA LISTA DE EMPRESAS(CLIENTES)
                                                                foreach ($versaoPrincipal as $empresa) {
                                                                    
                                                                    if($empresa->idProdutos == $r->idProdutos &&
                                                                        !empty($empresa->empresa) &&
                                                                        $empresa->versao !== null){

                                                                        if(in_array($empresa->empresa, $empre) !== true){

                                                                            $vers_empre = array(

                                                                                "idPn" => $empresa->idPn,
                                                                                "empresa" => $empresa->empresa

                                                                            );
                                                                            
                                                                            array_push($empre, $empresa->empresa);
                                                                            array_push($empre_v, $vers_empre);

                                                                        }

                                                                    }

                                                                }

                                                                if(empty($empre_v)){

                                                                    ?>
                                                                    
                                                                        <script>

                                                                            $("#trTituloEmpresa<?php echo $r->idProdutos;?>").css("display","none");

                                                                        </script>
                                                                    
                                                                    <?php

                                                                }

                                                                // MOSTRA LISTA DE EMPRESAS
                                                                foreach($empre_v as $cliente){

                                                                    echo '<tr class="trVEmpresa'. $cliente["idPn"] .'">';
                                                                    echo '<td onclick="opencloseVEmp(this,'.$cliente["idPn"].',`'.$cor_fundo.'`);" style="text-align: center;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';
                                                                    echo '<td style="text-align: left;" colspan="12"><b>'. $cliente["empresa"] .'</b></td>';
                                                                    echo '</tr>';

                                                                    echo '<tr class="trVEmpresa2'.$cliente["idPn"].'" style="display:none">';
                                                                        echo '<th></th>';
                                                                        echo '<th>Revisão de Origem</th>';
                                                                        echo '<th>Revisão Empresa</th>';
                                                                        echo '<th>Descrição</th>';
                                                                        echo '<th>Referência</th>';
                                                                        echo '<th>Fornecedor Orig.</th>';
                                                                        echo '<th>Equipamento</th>';
                                                                        echo '<th>Subconjunto</th>';
                                                                        echo '<th>Modelo</th>';
                                                                        echo '<th>Usuário Criação</th>';
                                                                        echo '<th>Data Modificação</th>';
                                                                        echo '<th>Desenho | Download</th>';
                                                                        echo '<th></th>';
                                                                    echo '</tr>';

                                                                    // LISTA VERSÕES DE EMPRESA
                                                                    foreach ($versaoPrincipal as $x) {

                                                                        if($r->idProdutos == $x->idProdutos &&
                                                                            !empty($x->empresa) && 
                                                                            $x->empresa !== "" &&
                                                                            $cliente["empresa"] == $x->empresa){

                                                                            echo '<tr class="trVEmpresa2'.$cliente["idPn"].'" style="display:none">';

                                                                            echo '<td style="text-align: center;">
                                                                
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-right" viewBox="0 0 16 16">
                                                                                    <path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z"/>
                                                                                </svg>
                                                                            
                                                                            </td>';

                                                                            echo '<td style="text-align: center;">v'. $x->versao .'</td>';
                                                                            echo '<td style="text-align: center;">v'. $x->versaoEmpresa .'</td>';
                                                                            echo '<td style="text-align: center;">'. $x->descricao .'</td>';
                                                                            echo '<td style="text-align: center;">'. $x->referencia .'</td>';
                                                                            echo '<td style="text-align: center;">'. $x->fornecedor_original .'</td>';
                                                                            echo '<td style="text-align: center;">'. $x->equipamento .'</td>';
                                                                            echo '<td style="text-align: center;">'. $x->subconjunto .'</td>';
                                                                            echo '<td style="text-align: center;">'. $x->modelo .'</td>';
                                                                            echo '<td style="text-align: center;">'. $x->nome_user .'</td>';
                                                                            echo '<td style="text-align: center;">'. date("d/m/Y", strtotime($x->data_alteracaoHis)) .'</td>';

                                                                            // TD ARQUIVO PARA DOWNLOAD
                                                                                if(empty($x->nomeArquivoDwg)){

                                                                                    echo ' 
                                                                                    
                                                                                        <td style="text-align: center;">
                                                                                            <font size="2" class="tip-top" title="PN sem Desenho">
                                                                                                <b style="text-align: center;">
                                                                                                    <i class="icon-ban-circle" style="color:grey"></i>
                                                                                                </b>
                                                                                            </font>
                                                                                        </td>
                                                                                    
                                                                                    ';

                                                                                }else{

                                                                                    echo '

                                                                                        <td style="text-align: center;">
                                                                                            <a class="tip-top" title="Baixar Desenho PN" style="text-align: center; color: green;" 
                                                                                                href="'.base_url().$x->caminhoDwg.$x->imagemDwg.'" download>
                                                                                                
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                                                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                                                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                                                                </svg>

                                                                                            </a>
                                                                                        </td>

                                                                                    ';

                                                                                }
                                                                            //----------------------

                                                                            // BOTÔES
                                                                            echo '<td>';
                                                                            
                                                                                echo '<div class="btn-group" role="group" style="margin:0px; padding:0px;">';

                                                                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vDesenho')){
                                                                                            
                                                                                        echo '<div class="btn-group">
                                                                                            <a onclick="historico(`'. $x->pn .'`,`'. $x->descricao .'`,`'. $x->idPn .'`,`'. $x->versao .'`,`'. $x->empresa .'`,`'. $x->versaoEmpresa .'`)" class="btn tip-top" title="Visualizar Histórico do PN">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                                                                </svg>
                                                                                            </a>
                                                                                        </div>';
                            
                                                                                    }

                                                                                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eDesenho')){

                                                                                        echo ((empty($x->nomeArquivoDwg) || !isset($x->nomeArquivoDwg)) ? '

                                                                                            <div class="btn-group">

                                                                                                <a onclick="addDesenho(`'.(empty($x->idPn) ? "" : $x->idPn).'`,`'.$x->idProdutos.'`);" class="btn btn-primary tip-top" style="background-color:#3AD5AC; 
                                                                                                color:white;" title="Adicionar Desenho">
                                                                                                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-cloud-upload-fill" viewBox="0 0 16 16">
                                                                                                        <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0z"/>
                                                                                                    </svg>
                                                                                                </a>    

                                                                                            </div>
                                                                                        
                                                                                        ' : "").'

                                                                                        <div class="btn-group">
                                                                                            <a href="'.base_url(). 'index.php/desenho/page_add_versao_Pn?id='.$x->idProdutos.(empty($x->idPn) ? "" : '&idPn='.$x->idPn).'"
                                                                                            class="btn btn-primary tip-top" title="Adicionar versão para PN">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-bezier2" viewBox="0 0 16 16">
                                                                                                    <path fill-rule="evenodd" d="M1 2.5A1.5 1.5 0 0 1 2.5 1h1A1.5 1.5 0 0 1 5 2.5h4.134a1 1 0 1 1 0 1h-2.01c.18.18.34.381.484.605.638.992.892 2.354.892 3.895 0 1.993.257 3.092.713 3.7.356.476.895.721 1.787.784A1.5 1.5 0 0 1 12.5 11h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5H6.866a1 1 0 1 1 0-1h1.711a2.839 2.839 0 0 1-.165-.2C7.743 11.407 7.5 10.007 7.5 8c0-1.46-.246-2.597-.733-3.355-.39-.605-.952-1-1.767-1.112A1.5 1.5 0 0 1 3.5 5h-1A1.5 1.5 0 0 1 1 3.5v-1zM2.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10 10a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
                                                                                                </svg>
                                                                                            </a>
                                                                                        </div>

                                                                                        <div class="btn-group">
                                                                                            <a href="'.base_url(). 'index.php/desenho/page_editar_pn?id='.$x->idProdutos.(empty($x->idPn) ? "" : '&idPn='.$x->idPn).'" 
                                                                                            class="btn btn-info tip-top" title="Editar Produto PN">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:3px;" width="16" height="18" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                                                </svg>
                                                                                            </a>
                                                                                        </div>';
                                                                                    
                                                                                    }

                                                                                echo '</div>';

                                                                                

                                                                            echo '</td>';

                                                                            echo "</tr>";

                                                                        }


                                                                    }

                                                                }
                                                            
                                                            ?>

                                                        </tbody>

                                                    </table>
                                                </div>

                                            </td>

                                        </tr>

                                    <?php
                                    }

                                }

                            ?>
                            <tr>

                            </tr>

                        </tbody>
                    </table>

                </div>

            </div>
            
        </div>
    </div>
</div>

<!-- MODAL ADICIONAR DESENHO -->
<div id="modal-desenho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:550px; overflow-y: scroll;">

    <div id="imagem">
                            
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h5 id="myModalLabel">Anexar Desenho. PN.: </h5> 
            <p id="obsAnexo">Obs. Obrigatório cadastrar o desenho em DWG e JPG.</p>
        </div>

        <div class="modal-body" style="margin: 0px;">

            <div class="control-group">
                
                <div class="controls">
                    <h4>Você tem certeza que deseja enviar esse desenho para a MASTER? </h4>  
                </div>
                
            </div>

            <!--DETALHES PN ORIGINAL-->
            <div class="span12" id="divProdutosServicos" style=" margin-left: 0;background-color: #f9f9f9;">
                        
                <div class="container-fluid" style="margin-top: 20px;">

                    <!--DETALHES PN-->
                    <table class='comBordas' style="font-size:18px;" width='100%' align='left'>

                        <tr>
                            <td align='center'>
                                PN: 
                            </td>
                            <td align='center'>
                                Descrição:
                            </td>
                        </tr>

                        <tr>

                            <td align='center'>
                                <b><span id="pn2"></span></b> 
                            </td>
                            <td align='center'>
                                <b><span id="descricao2"></span></b>
                            </td>

                        </tr>

                    </table>
                
                </div>

            </div>

            <input type="hidden" id="idPn2">
            <input type="hidden" id="idProdutos2">

            <!--UPLOAD DESENHO DWG-->
            <div class="span10" style="margin-left:0px">

                <br>
                <div class="span10">
                    <label> <b>Arquivo DWG</b> </label>
                    <input type="file"  name="imag_dwg" id="imag_dwg" accept=".dwg">
                </div>   
                
            </div>
            
            <!--UPLOAD DESENHO JPG-->
            <div class="span10" style="margin-left:0px"> 

                <br>
                
                <div class="span10">
                    <label> <b>Arquivo JPG</b></label>
                    <input type="file"  name="imag_jpg" id="imag_jpg" accept=".jpg">
                </div>   
                
            </div>

            <!--UPLOAD BOTÃO ANEXAR-->
            <div class="span10">
                
                <br>
                
                <div class="span10" style="margin-left:0px">
                    <button onclick="anexarDesenho(this);"
                        class="btn btn-primary tip-top" title="Adicionar Desenho">
                            Anexar Desenho
                    </button> 
                </div>   

            </div>

        </div>

    </div>

</div>

<!-- MODAL HISTÓRICO -->
<div id="modalHistorico" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Histórico PN: <b id="TopoPn"></b></h5>
    </div>

    <div class="modal-body">
        <div class="widget-content nopadding">
            <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">

                <thead>
                    <tr>
                        
                        <th>Observação</th>
                        <th>Data Alteração</th>
                        <th>Usuário</th>
                        <th>Arquivo</th>
                    
                    </tr>
                </thead>
                <tbody>
                    
                    
                    
                </tbody>

            </table>
        </div>

    </div>

</div>

<!-- MODAL DESENHOS DE CORTE -->
<div id="modalCorte" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Histórico PN: <b id="TopoPn"></b></h5>
    </div>

    <div class="modal-body">
        <div class="widget-content nopadding">
            <table id="table_idCorte" class="table table-bordered " id="dadosTlbOsOc">

                <thead>
                    <tr>
                        
                        <th>Desenho</th>
                        <th>Descrição</th>
                        <th>Observação</th>
                        <th>Usuário</th>
                        <th>Arquivo</th>
                    
                    </tr>
                </thead>
                <tbody>
                    
                    
                    
                </tbody>

            </table>
        </div>

    </div>

</div>

<script type="text/javascript">

    $(document).ready(function(){

        // $('#table_PN tr:last').remove();
        // tabelaPN = $('#table_PN').DataTable({
        //     'columnDefs': [ { // column index (start from 0)
        //     'orderable': false, // set orderable false for selected columns
        //     }],
        //     "order": [[9, 'desc']],
        //     "paging": true,//Dont want paging                
        //     "bPaginate": false,//Dont want paging 
        //     "searching": false,
        //     "language": {
        //         "lengthMenu": "Mostrar _MENU_ resultados por página",
        //         "sProcessing":    "Procesando...",
        //         "sZeroRecords":   "Sem resultados",
        //         "sInfo":          "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
        //         "sInfoEmpty":     "Mostrando registros de 0 a 0 de um total de 0 registros",
        //         "sInfoFiltered":  "(filtrado de um total de _MAX_ registros)",
        //         "sInfoPostFix":   "",
        //         "sUrl":           "",
        //         "sInfoThousands":  ",",
        //         "sLoadingRecords": "Cargando...",
        //         "oPaginate": {
        //             "sFirst":    "Primero",
        //             "sLast":    "Último",
        //             "sNext":    "Seguinte",
        //             "sPrevious": "Anterior"
        //         }
        //     }
        // });

        $("#pn").autocomplete({
            source: "<?php echo base_url(); ?>index.php/desenho/autoCompletePN",
            minLength: 1,
            select: function( event, ui ) {

                $('#pn').val(ui.item.pn);
                $('#idProdutos').val(ui.item.id);
                $('#prod').val(ui.item.descricao);
                $('#ref').val(ui.item.referencia);

                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/desenho/autoCompleteEmpresa",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        pn: ui.item.pn
                    },
                    success: function(data) {
                        
                        if(data.result == true){

                            //console.log(data.empresas);
                            if(data.empresas.length > 0){
                                $('#empresa').append('<option> SELECIONE EMPRESA </option>');
                            }

                            data.empresas.forEach(function(item){
                                $('#empresa').append('<option value="'+ item.idClientes + '">' + item.empresa + '</option>');
                            });
                            
                        }else{
                            alert(data.msggg);
                        }

                    },
                    error: function(xhr, textStatus, error) {
                    console.log("4");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                    },
                });

            }

        });

        $("#prod").autocomplete({
            source: "<?php echo base_url(); ?>index.php/desenho/autoCompletePNDescri",
            minLength: 1,
            select: function( event, ui ) {

                $('#idProdutos').val(ui.item.id);
                $('#prod').val(ui.item.descricao);
                $('#ref').val(ui.item.referencia);
                $('#pn').val(ui.item.pn);

                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/desenho/autoCompleteEmpresa",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        pn: ui.item.pn
                    },
                    success: function(data) {
                        
                        if(data.result == true){

                            //console.log(data.empresas);
                            if(data.empresas.length > 0){
                                $('#empresa').append('<option> SELECIONE EMPRESA </option>');
                            }

                            
                            data.empresas.forEach(function(item){
                                $('#empresa').append('<option>' + item + '</option>');
                            });
                            
                        }else{
                            alert(data.msggg);
                        }

                    },
                    error: function(xhr, textStatus, error) {
                    console.log("4");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                    },
                });

            }
        });

        $("#ref").autocomplete({
            source: "<?php echo base_url(); ?>index.php/desenho/autoCompletePNRef",
            minLength: 1,
            select: function( event, ui ) {

                $('#idProdutos').val(ui.item.id);
                $('#prod').val(ui.item.descricao);
                $('#ref').val(ui.item.referencia);
                $('#pn').val(ui.item.pn);

                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/desenho/autoCompleteEmpresa",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        pn: ui.item.pn
                    },
                    success: function(data) {
                        
                        if(data.result == true){

                            //console.log(data.empresas);
                            if(data.empresas.length > 0){
                                $('#empresa').append('<option> SELECIONE EMPRESA </option>');
                            }

                            data.empresas.forEach(function(item){
                                $('#empresa').append('<option>' + item + '</option>');
                            });
                            
                        }else{
                            alert(data.msggg);
                        }

                    },
                    error: function(xhr, textStatus, error) {
                    console.log("4");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                    },
                });

            }
        });

        w = 0;

        var thEmpresa = document.getElementById("thEmpresa");
        var thVersaoEmpresa = document.getElementById("thVersaoEmpresa");

    });

    $("#pn").keyup(function() {
        $("#empresa").html('');
        $("#versaoEmpresa").html('');
    });

    $("#prod").keyup(function() {
        $("#empresa").html('');
        $("#versaoEmpresa").html('');
    });

    $("#ref").keyup(function() {
        $("#empresa").html('');
        $("#versaoEmpresa").html('');
    });

    $("#empresa").change(function(){

        $("#versaoEmpresa").html('');

        var empresa = document.getElementById("empresa").value;
        var pn = document.getElementById("pn").value;
        
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/autoCompleteVersaoEmpresa",
            type: 'POST',
            dataType: 'json',
            data: {
                pn: pn,
                empresa: empresa
            },
            success: function(data) {
                
                if(data.result == true){

                    data.versaoEmpresa.forEach(function(item){
                        $('#versaoEmpresa').append('<option>' + item + '</option>');
                    });
                    
                }else{
                    alert(data.msggg);
                }

            },
            error: function(xhr, textStatus, error) {
            console.log("4");
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
            },
        });

    });
  
    function buscarPn(){
        
        var pn = document.getElementById('pn').value;
        var empresa = document.getElementById('empresa').value;

        var versaoEmpresa = document.getElementById('versaoEmpresa').value;
        
        if(pn === ""){

            alert("Erro! É necessário digitar PN!");

        }else{

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/desenho/findPn",
                type: 'POST',
                dataType: 'json',
                data: {
                    pn: pn,
                    empresa: empresa,
                    versaoEmpresa: versaoEmpresa
                },
                success: function(data) {
                    
                    if(data.result == true){
                        //console.log(data.pn);
                        $("#buscaVoltar").html("- Voltar");
                        $("#buscaVoltar").css('color','green');
                        preencherTabelaPn(data.resultado)
                    }else{
                        alert(data.msggg);
                    }

                },
                error: function(xhr, textStatus, error) {
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
                },
            });

        }

    }

    function preencherTabelaPn(resultado){

        //console.log(resultado);

        var table = document.getElementById("table_PN").getElementsByTagName('tbody')[0];
        
       
        //tabelaPN.destroy();
        
        
        $('#table_PN tbody').empty();
        if(table.rows.length == null || typeof table.rows.length == "undefined"){
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }

        var newRow;
        var botoes = "";
        var campo_vazio = 0;
        
        for(y=0;y<resultado.length;y++){

            var empre = "";
            var versEmpre = "";

            x=y;
            newRow = table.insertRow(x);

            // COLUNA VAZIA
            newCell = newRow.insertCell(0);
            newCell.innerHTML = "";
            
            // COLUNA PN
            newCell = newRow.insertCell(1);   
            newCell.style.textAlign = "center";
            newCell.innerHTML = resultado[x].pn;

            // COLUNA DESCRIÇÃO
            newCell = newRow.insertCell(2);
            newCell.style.textAlign = "center";
            if(resultado[x].descricao == null || resultado[x].descricao === ""){
                newCell.innerHTML = "";
                campo_vazio = 1;
            }else{
                newCell.innerHTML = resultado[x].descricao;
            }

            // COLUNA REFERENCIA
            newCell = newRow.insertCell(3);
            newCell.style.textAlign = "center";
            if(resultado[x].referencia == null || resultado[x].referencia === ""){
                newCell.innerHTML = "";
                campo_vazio = 1;
            }else{
                newCell.innerHTML = resultado[x].referencia;
            }
            
            // COLUNA FORNECEDOR ORIGINAL
            newCell = newRow.insertCell(4);
            newCell.style.textAlign = "center";
            if(resultado[x].fornecedor_original == null || resultado[x].fornecedor_original === ""){
                newCell.innerHTML = "";
                campo_vazio = 1;
            }else{
                newCell.innerHTML = resultado[x].fornecedor_original;
            }

            // COLUNA EQUIPAMENTO
            newCell = newRow.insertCell(5);
            newCell.style.textAlign = "center";
            if(resultado[x].equipamento == null || resultado[x].equipamento === ""){
                newCell.innerHTML = "";
                campo_vazio = 1;
            }else{
                newCell.innerHTML = resultado[x].equipamento;
            }

            // COLUNA SUBCONJUNTO
            newCell = newRow.insertCell(6);
            newCell.style.textAlign = "center";
            if(resultado[x].subconjunto == null || resultado[x].subconjunto ==="" ){
                newCell.innerHTML = "";
                campo_vazio = 1;
            }else{
                newCell.innerHTML = resultado[x].subconjunto;
            }

            // COLUNA MODELO
            newCell = newRow.insertCell(7);
            newCell.style.textAlign = "center"; 
            if(resultado[x].modelo == null || resultado[x].modelo === ""){
                newCell.innerHTML = "";
                campo_vazio = 1;
            }else{
                newCell.innerHTML = resultado[x].modelo;
            }

            // COLUNA VERSÃO
            newCell = newRow.insertCell(8);
            newCell.style.textAlign = "center";
            if(resultado[x].versao == null || resultado[x].versao === ""){
                newCell.innerHTML = '';
            }else{
                newCell.innerHTML = '<font size="2"><b>v'+ resultado[x].versao + ' </b></font></td>';
            }

            // SE BUSCA FOR POR EMPRESA EXPECÍFICA
            var cel_usua = 9;
            var cel_data = 10;
            var cel_dese = 11;
            var cel_boto = 12;

            // COLUNA EMPRESA E VERSÃO EMPRESA
            if(resultado[x].empresa == null || resultado[x].empresa ===""){

                cel_usua = 9;
                cel_data = 10;
                cel_dese = 11;
                cel_boto = 12;

                thEmpresa.style.display = "none";
                thVersaoEmpresa.style.display = "none";

            }else{

                thEmpresa.style.display = "table-cell";
                thVersaoEmpresa.style.display = "table-cell";

                // COLUNA EMPRESA
                newCell = newRow.insertCell(9);
                newCell.style.textAlign = "center";
                if(resultado[x].empresa == null || resultado[x].empresa === ""){
                    newCell.innerHTML = '';
                }else{
                    newCell.innerHTML = '<font size="2"><b>'+ resultado[x].empresa + ' </b></font></td>';
                }

                // COLUNA VERSÃO EMPRESA
                newCell = newRow.insertCell(10);
                newCell.style.textAlign = "center";
                if(resultado[x].versaoEmpresa == null || resultado[x].versaoEmpresa === ""){
                    newCell.innerHTML = '';
                }else{
                    newCell.innerHTML = '<font size="2"><b>v'+ resultado[x].versaoEmpresa + ' </b></font></td>';
                }

                cel_usua = 11;
                cel_data = 12;
                cel_dese = 13;
                cel_boto = 14;

            }

            // COLUNA USUARIO
            newCell = newRow.insertCell(cel_usua);
            newCell.style.textAlign = "center";  
            if(resultado[x].nome_user == null || resultado[x].nome_user ===""){
                newCell.innerHTML = "";
            }else{
                newCell.innerHTML = resultado[x].nome_user;
            }

            // COLUNA DATA CRIAÇÃO
            newCell = newRow.insertCell(cel_data);
            newCell.style.textAlign = "center";
            if(resultado[x].data_master == null || resultado[x].data_master === ""){
                newCell.innerHTML = '';
            }else{
                var data_master = new Date(resultado[x].data_master);
                newCell.innerHTML = data_master.toLocaleDateString('pt-BR', {
                    timeZone: 'UTC',
                });
            }
            
            // COLUNA DESENHO | DOWNLOAD
            newCell = newRow.insertCell(cel_dese);
            newCell.style.textAlign = "center";   
            if(resultado[x].nomeArquivoDwg == null || resultado[x].nomeArquivoDwg === ""){
                newCell.innerHTML = '<font size="2" class="tip-top" title="PN sem Desenho"><b style="text-align: center;"><i class="icon-ban-circle" style="color:grey"></i></b></font>'
            }else{
                newCell.innerHTML = '<a class="tip-top" title="Baixar Desenho PN" style="text-align: center; color: green;" href="<?php echo base_url()?>' + resultado[x].caminhoDwg + resultado[x].imagemDwg + '" download><svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg></a>';
            }
            
            // COLUNA BOTÕES
            newCell = newRow.insertCell(cel_boto);

                botoes += '<div class="btn-group" role="group">';

                <?php
                
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'vDesenho')){
                
                ?>

                    if(resultado[x].idPn == null || resultado[x].idPn === ""){

                    }else{

                        //VALIDANDO SE PN TEM VERSÃO DE EMPRESA
                        if(resultado[x].empresa == null || resultado[x].empresa === ""){

                            empre = "";
                            versEmpre = "";

                        }else{

                            empre = resultado[x].empresa;
                            versEmpre = resultado[x].versaoEmpresa;

                        }

                        botoes += '<div class="btn-group">';
                        botoes +=     '<a onclick="historico(`'+ resultado[x].pn +'`,`'+ resultado[x].descricao +'`,`'+ resultado[x].idPn +'`,`'+ resultado[x].versao +'`,`'+ empre +'`,`'+ versEmpre +'`)" class="btn tip-top" title="Visualizar Histórico do PN">';
                        botoes +=         '<svg xmlns="http://www.w3.org/2000/svg" style="margin-top:0px;" width="14" height="14" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">';
                        botoes +=             '<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>';
                        botoes +=             '<path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>';
                        botoes +=         '</svg>';
                        botoes +=     '</a>';
                        botoes += '</div>';

                    }
                
                <?php

                    }
                    if($this->permission->checkPermission($this->session->userdata('permissao'),'eDesenho')){
                ?>

                    

                    var idPn;
                    if(resultado[x].idPn == null || resultado[x].idPn === ""){       
                        idPn = "";
                        idPn2 = "";
                    }else{
                        idPn2 = resultado[x].idPn;
                        idPn = "&idPn=" + resultado[x].idPn;
                    }

                    if(campo_vazio == 1 && (resultado[x].nomeArquivoDwg == null || resultado[x].nomeArquivoDwg === "")){

                        // BOTÃO ADICIONAR PN
                        botoes +='<div class="btn-group">';
                        botoes +=    '<a href="<?php echo base_url();?>index.php/desenho/page_add_pn_existente?id='+resultado[x].idProdutos+idPn+'"';
                        botoes +=    'class="btn btn-primary tip-top" style="background-color:#3AD5AC; color:white;" title="Adicionar Desenho">';
                        botoes +=       '<svg xmlns="http://www.w3.org/2000/svg" style="margin-top:0px;" width="14" height="14" fill="currentColor" class="bi bi-cloud-upload-fill" viewBox="0 0 16 16">';
                        botoes +=           '<path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0z"/>';
                        botoes +=       '</svg>';
                        botoes +=    '</a>';
                        botoes +='</div>';

                    }else{

                        // BOTÃO ADICIONAR IMAGEM
                        if(resultado[x].nomeArquivoDwg == null || resultado[x].nomeArquivoDwg === ""){
                            botoes += '<div class="btn-group">';
                            botoes +=   '<a onclick="addDesenho(`'+idPn2+'`,`'+resultado[x].idProdutos+'`);" class="btn btn-primary tip-top" style="background-color:#3AD5AC; color:white;" title="Adicionar Desenho">';
                            botoes +=       '<svg xmlns="http://www.w3.org/2000/svg" style="margin-top:0px;" width="14" height="14" fill="currentColor" class="bi bi-cloud-upload-fill" viewBox="0 0 16 16">';
                            botoes +=           '<path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0z"/>';
                            botoes +=       '</svg>';
                            botoes +=   '</a> ';
                            botoes += '</div> ';
                        }

                        // BOTÃO ADICIONAR VERSÃO
                        botoes +='<div class="btn-group">';
                        botoes +=    '<a href="<?php echo base_url();?>index.php/desenho/page_add_versao_Pn?id='+resultado[x].idProdutos+idPn+'"';
                        botoes +=    'class="btn btn-primary tip-top" title="Adicionar versão para PN">';
                        botoes +=        '<svg xmlns="http://www.w3.org/2000/svg" style="margin-top:0px;" width="14" height="14" fill="currentColor" class="bi bi-bezier2" viewBox="0 0 16 16">';
                        botoes +=            '<path fill-rule="evenodd" d="M1 2.5A1.5 1.5 0 0 1 2.5 1h1A1.5 1.5 0 0 1 5 2.5h4.134a1 1 0 1 1 0 1h-2.01c.18.18.34.381.484.605.638.992.892 2.354.892 3.895 0 1.993.257 3.092.713 3.7.356.476.895.721 1.787.784A1.5 1.5 0 0 1 12.5 11h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5H6.866a1 1 0 1 1 0-1h1.711a2.839 2.839 0 0 1-.165-.2C7.743 11.407 7.5 10.007 7.5 8c0-1.46-.246-2.597-.733-3.355-.39-.605-.952-1-1.767-1.112A1.5 1.5 0 0 1 3.5 5h-1A1.5 1.5 0 0 1 1 3.5v-1zM2.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10 10a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>';
                        botoes +=        '</svg>';
                        botoes +=    '</a>';
                        botoes +='</div>';

                    }

                    if(resultado[x].idPn == null || resultado[x].idPn === ""){

                    }else{

                        botoes +='<div class="btn-group">'
                        botoes +=    '<a href="<?php echo base_url();?>index.php/desenho/page_editar_pn?id='+resultado[x].idProdutos+idPn+'"';
                        botoes +=    'class="btn btn-info tip-top" title="Editar Produto PN">'
                        botoes +=        '<svg xmlns="http://www.w3.org/2000/svg" style="margin-top:0px;" width="14" height="14" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">'
                        botoes +=           '<path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>'
                        botoes +=        '</svg>'
                        botoes +=    '</a>'
                        botoes +='</div>'

                    }
                    
                    //botoes += '<div class="btn-group"><a style="margin-right: 1%" href="<?php echo base_url(); ?>index.php/desenho/findPn" class="btn btn-primary tip-top" title="Editar Produto PN">Add versão</a></div>';
                    //botoes += '<div class="btn-group"><a style="margin-right: 1%" href="<?php echo base_url(); ?>index.php/desenho/findPn" class="btn btn-info tip-top" title="Editar Produto PN">Alterar</a></div>';
                    
                    botoes += '</div>';

                <?php
                    }
                ?>

            newCell.innerHTML = botoes;

            botoes = "";
             
        }
        
        // tabelaPN = $('#table_PN').DataTable({
        //     'columnDefs': [ { // column index (start from 0)
        //     'orderable': false, // set orderable false for selected columns
        //     }],
        //     "paging": true,//Dont want paging                
        //     "bPaginate": false,//Dont want paging 
        //     "searching": false,
        //     "language": {
        //         "lengthMenu": "Mostrar _MENU_ resultados por página",
        //         "sProcessing":    "Procesando...",
        //         "sZeroRecords":   "Sem resultados",
        //         "sInfo":          "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
        //         "sInfoEmpty":     "Mostrando registros de 0 a 0 de um total de 0 registros",
        //         "sInfoFiltered":  "(filtrado de um total de _MAX_ registros)",
        //         "sInfoPostFix":   "",
        //         "sUrl":           "",
        //         "sInfoThousands":  ",",
        //         "sLoadingRecords": "Cargando...",
        //         "oPaginate": {
        //             "sFirst":    "Primero",
        //             "sLast":    "Último",
        //             "sNext":    "Seguinte",
        //             "sPrevious": "Anterior"
        //         }
        //     }
        // });

    }

    function addDesenho(idPn,idProduto){

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/modal_add_desenho",
            type: 'POST',
            dataType: 'json',
            data: {
                "idPn": idPn,
                "id": idProduto
            },
            success: function(data) {
                
                if(data.result == true){

                    $('#pn2').html(data.resultado[0].pn);
                    $('#descricao2').html(data.resultado[0].descricao);
                    $('#idPn2').val(data.resultado[0].idPn);
                    $('#idProdutos2').val(data.resultado[0].idProdutos);

                    var versao = data.resultado[0].versao;
                    var versao2;

                    var versaoEmpresa = data.resultado[0].versaoEmpresa;

                    /*
                        if(versao==null || versao===""){

                            versao2 = 0;
                            $('#versao2').html("v" + versao2);

                        }else{

                            if(versaoEmpresa==null || versaoEmpresa===""){

                                versao2 = versao;
                                $('#versao2').html("v" + versao2);

                            }else{

                                versao2 = versaoEmpresa;
                                $('#versao2').html("v" + versao2);

                            }

                        }
                    */

                    $("#modal-desenho").modal({
                        show: true
                    });

                }else{
                    alert(data.msggg);
                }

            },
            error: function(xhr, textStatus, error) {
            console.log("4");
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
            },
        });

    }

    $("#imag_dwg").change(function(){

        
        var file_dataDwg = document.getElementById('imag_dwg');

        if(file_dataDwg.files[0] == null || file_dataDwg.files[0] ===""){

            $("#imag_jpg").css("color", "green");
            alert("O desenho não será anexado sem um novo arquivo DWG!");

        }else{

            var file_dataJpg = document.getElementById('imag_jpg');
            $("#imag_dwg").css("color", "green");

            if(file_dataJpg.files[0] == null || file_dataJpg.files[0] ===""){
                $("#imag_jpg").css("color", "red");
            }

        }

    });

    $("#imag_jpg").change(function(){

        $("#imag_jpg").css("color", "green");

        var file_dataDwg = document.getElementById('imag_dwg');

        if(file_dataDwg.files[0] == null || file_dataDwg.files[0] ===""){

            alert("Obrigatório enviar o desenho em DWG!");
            return;

        }

        var file_dataJpg = document.getElementById('imag_jpg');

        if(file_dataJpg.files[0] == null || file_dataJpg.files[0] ===""){
            $("#imag_jpg").css("color", "red");
        }

    });

    function anexarDesenho(botao){

        var idPn         = document.getElementById('idPn2').value;
        var idProdutos   = document.getElementById('idProdutos2').value;
        var pn           = document.getElementById('pn2').innerText;
        var file_dataDwg = document.getElementById('imag_dwg');
        var file_dataJpg = document.getElementById('imag_jpg');

        if(!file_dataDwg.files[0] || !file_dataJpg.files[0]){

            alert("Obrigatório cadastrar o desenho em DWG e JPG.");

        }else{

            var certeza=confirm("Você tem certeza que deseja enviar esse desenho para a MASTER?");

            if(certeza==true){

                botao.disabled = true;

                form_data = new FormData();
                form_data.append('idPn', idPn);
                form_data.append('idProdutos', idProdutos);
                form_data.append('pn', pn);
                form_data.append('imag_dwg', file_dataDwg.files[0]);
                form_data.append('imag_jpg', file_dataJpg.files[0]);

                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/desenho/add_desenho_pn",
                    dataType: 'json',
                    cache: false,
                    async: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    data:form_data,
                    success: function(data2) {

                        if(data2.result == true){
                            alert("Desenho anexado com sucesso.");
                            window.location.href = "<?php echo base_url() . 'index.php/desenho/criar_pn';?>";
                        }else{
                            alert("Erro ao anexar desenho!");
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


            }else{
                return;
            }

        }

    }

    function openclose(td,valor, cor){

        var tr = document.querySelector(".trfilho"+valor);
        
        if(tr.style.display == "table-row" || tr.style.display == ""){
            $(".trfilho"+valor).hide('fast');
            $(td).parent('tr').css('background-color', cor);
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");        
        }else{
            $(".trfilho"+valor).show('fast');
            $(td).parent('tr').css('background-color', cor);
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }     

    }

    function opencloseVEmp(td,valor,cor){

        var tr = document.querySelector(".trVEmpresa2"+valor);

        if(tr.style.display == "table-row" || tr.style.display == ""){
            $(".trVEmpresa2"+valor).hide('fast');
            $(td).parent('tr').css('background-color', cor);
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");        
        }else{
            $(".trVEmpresa2"+valor).show('fast');
            $(td).parent('tr').css('background-color', cor);
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }     

    }

    function historico(pn, descricao, idPn, versao, empresa, versaoEmpresa){

        var textoEmpresa;

        if(empresa == null || empresa === ""){
            textoEmpresa = "";
        }else{

            textoEmpresa = " | " + empresa + " - v" + versaoEmpresa;

        }

        $('#TopoPn').html(pn + " | " + descricao + " - v" + versao + textoEmpresa);

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/historico",
            type: 'POST',
            dataType: 'json',
            data: {
                idPn: idPn
            },
            success: function(data) {
                
                if(data.result == true){
                    //console.log(data.resultado);
                    preencherHistoricoPn(data.resultado)
                }else{
                    alert(data.msggg);
                }

            },
            error: function(xhr, textStatus, error) {
            console.log("4");
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
            },
        });

        $("#modalHistorico").modal({
            show: true
        });

    }
  
    function preencherHistoricoPn(resultado){

        var table = document.getElementById("table_id").getElementsByTagName('tbody')[0];

        $('#table_id tbody').empty();
        if(table.rows.length == null || typeof table.rows.length == "undefined"){
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }

        var newRow;
        var botoes = "";

        for(y=0;y<resultado.length;y++){

            x=y;
            newRow = table.insertRow(x);

            // COLUNA OBSERVAÇÃO
            newCell = newRow.insertCell(0);   
            newCell.style.textAlign = "center";
            newCell.innerHTML = resultado[x].observacao;

            // COLUNA DATA
            newCell = newRow.insertCell(1);   
            newCell.style.textAlign = "center";
            newCell.innerHTML = resultado[x].data_alteracaoHis;

            // COLUNA USUÁRIO
            newCell = newRow.insertCell(2);   
            newCell.style.textAlign = "center";
            newCell.innerHTML = resultado[x].nome_user;

            // COLUNA ARQUIVO
            newCell = newRow.insertCell(3);   
            newCell.style.textAlign = "center";
            if(resultado[x].imagemDwg == null || resultado[x].imagemDwg === ""){
                newCell.innerHTML = '<font size="2" class="tip-top" title="PN sem Desenho"><b style="text-align: center;"><i class="icon-ban-circle" style="color:grey"></i></b></font>'
            }else{
                newCell.innerHTML = '<a class="tip-top" title="Baixar Desenho PN" style="text-align: center; color: green;" href="<?php echo base_url()?>' + resultado[x].caminhoDwg + resultado[x].imagemDwg + '" download><svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg></a>';
            }
            

        }

    }

    function corte(pn, descricao, idPn, versao, empresa, versaoEmpresa){

        var textoEmpresa;

        if(empresa == null || empresa === ""){
            textoEmpresa = "";
        }else{

            textoEmpresa = " | " + empresa + " - v" + versaoEmpresa;

        }

        $('#TopoPn').html(pn + " | " + descricao + " - v" + versao + textoEmpresa);

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/desenho_corte",
            type: 'POST',
            dataType: 'json',
            data: {
                idPn: idPn
            },
            success: function(data) {
                
                if(data.result == true){
                    console.log(data.resultado);
                    preencherHistoricoCorte(data.resultado)
                }else{
                    alert(data.msggg);
                }

            },
            error: function(xhr, textStatus, error) {
            console.log("4");
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
            },
        });

        $("#modalCorte").modal({
            show: true
        });

    }
  
    function preencherHistoricoCorte(resultado){

        var table = document.getElementById("table_idCorte").getElementsByTagName('tbody')[0];

        $('#table_id tbody').empty();
        if(table.rows.length == null || typeof table.rows.length == "undefined"){
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }

        var newRow;
        var botoes = "";

        for(y=0;y<resultado.length;y++){

            console.log(resultado);

            x=y;
            newRow = table.insertRow(x);

            // COLUNA NOME DESENHOS
            newCell = newRow.insertCell(0);   
            newCell.style.textAlign = "center";
            newCell.innerHTML = resultado[x].imagem;

            // COLUNA DESCRIÇÃO
            newCell = newRow.insertCell(1);   
            newCell.style.textAlign = "center";
            newCell.innerHTML = resultado[x].descricao_corte;

            // COLUNA OBSERVAÇÃO
            newCell = newRow.insertCell(2);   
            newCell.style.textAlign = "center";
            newCell.innerHTML = resultado[x].observacao_corte;

             // COLUNA USUÁRIO
             newCell = newRow.insertCell(2);   
            newCell.style.textAlign = "center";
            newCell.innerHTML = resultado[x].nome;

            // COLUNA ARQUIVO
            newCell = newRow.insertCell(4);   
            newCell.style.textAlign = "center";
            if(resultado[x].imagem == null || resultado[x].imagem === ""){
                newCell.innerHTML = '<font size="2" class="tip-top" title="PN sem Desenho"><b style="text-align: center;"><i class="icon-ban-circle" style="color:grey"></i></b></font>'
            }else{
                newCell.innerHTML = '<a class="tip-top" title="Baixar Desenho PN" style="text-align: center; color: green;" href="<?php echo base_url()?>' + resultado[x].caminho + resultado[x].imagem + '" download><svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg></a>';
            }
            

        }

    }

</script>