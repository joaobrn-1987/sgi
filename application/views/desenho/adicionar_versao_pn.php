<?php

    //var_dump($resultado[0]); exit;

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

<script type="text/javascript">
    // INICIO FUNÇÃO DE MASCARA MAIUSCULA
    function maiuscula(z){
            v = z.value.toUpperCase();
            z.value = v;
        }
    //FIM DA FUNÇÃO MASCARA MAIUSCULA
</script>

<!-- FORMULÁRIO DE CADASTRO -->
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Cadastro de Versão Produto PN</h5>
            </div>
            <div class="widget-content nopadding">

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
                                <td align='center'>
                                    Referência: 
                                </td>
                                <?php

                                    if(isset($resultado[0]->versao)){

                                        $colspan = 4;
                                
                                ?>

                                    <td align='center'>
                                        Revisão PN: 
                                    </td>

                                <?php
                                    }else{$colspan = 3;}
                                ?>
                            </tr>

                            <tr>

                                <td align='center'>
                                    <font size='5'><b>
                                        <span><?php echo $resultado[0]->pn;?></span></b>
                                    </font>
                                </td>
                                <td align='center'>
                                    <b><span><?php echo $resultado[0]->descricao;?></span></b>
                                </td>
                                <td align='center'>
                                    <b><span><?php echo $resultado[0]->referencia;?></span></b>
                                </td>
                                <?php

                                    if(isset($resultado[0]->versao)){
                                
                                ?>
                                    <td align='center'>
                                        <b><span><?php echo "v". $resultado[0]->versao;?></span></b>
                                    </td>
                                <?php
                                    }
                                ?>

                            </tr>

                            <?php
                                
                                if(isset($resultado[0]->empresa) && $resultado[0]->empresa !== ""){

                                    echo "

                                        <tr>
                                            <td colspan=".$colspan."><br><hr></td>
                                        </tr>

                                        <tr>
                                            <td align='center' colspan='2'>
                                                Empresa: 
                                            </td>

                                            <td align='center' colspan='2'>
                                                Revisão Empresa: 
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align='center' colspan='2'>
                                                <b><span>{$resultado[0]->empresa}</span></b>
                                            </td>

                                            <td align='center' colspan='2'>
                                                <b><span>v{$resultado[0]->versaoEmpresa}</span></b>
                                            </td>
                                        </tr>
                                    
                                    ";

                                }
                                
                            ?>

                        </table>

                        <!--DADOS-->
                        <div class="row-fluid">
                            <div class="span12">

                                <div class="widget-box">

                                    <div class="widget-content nopadding">

                                        <table width='100%' border='0' style="border-style:solid; border: 1px solid grey;
                                            font-family:Arial, Helvetica, sans-serif;
                                            font-size:18px;">
                                            <tr>

                                                <td align='center'>

                                                    <table width='100%' border='0' style="font-family:Arial, Helvetica, sans-serif;
                                                        font-size:15px; line-height: 20px; padding: 20px;">

                                                        <tr>
                                                            <td align='left' style="width:10%; padding-left: 5px;"><b>Usuário Criação:</b></td>
                                                            <td align='left' style="width:23%; border-right: 1px solid grey;">
                                                                <span>
                                                                    <?php 
                                                                    
                                                                        if(isset($resultado[0]->nome_user)){
                                                                            echo $resultado[0]->nome_user;
                                                                        }else{
                                                                            echo "";
                                                                        }
                                                                        
                                                                    
                                                                    ?>
                                                                </span>
                                                            </td>
                                                            <td align='left' style="width:10%; padding-left: 5px;">
                                                                <b>Equipamento:</b>
                                                            </td>
                                                            <td align='left' style="width:23%; border-right: 1px solid grey;">
                                                                <span><?php echo $resultado[0]->equipamento;?></span>
                                                            </td>
                                                            <td align='left' style="width:10%; padding-left: 5px;">
                                                                <b>Fornecedor Original: </b>
                                                            </td>
                                                            <td align='left' style="width:23%;">
                                                                <span><?php echo $resultado[0]->fornecedor_original;?></span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td align='left' style="width:10%; padding-left: 5px;"><b>Data: </b></td>
                                                            <td align='left' style="width:23%; border-right: 1px solid grey;">
                                                                <span>
                                                                    <?php 

                                                                        if(isset($resultado[0]->data_master)){
                                                                            echo date("d/m/Y H:i:s",strtotime($resultado[0]->data_master));
                                                                        }else{
                                                                            echo "";
                                                                        }

                                                                    ?>
                                                                </span>
                                                            </td>
                                                            <td align='left' style="width:10%; padding-left: 5px;"><b>SubConjunto: </b></td>
                                                            <td align='left' style="width:23%; border-right: 1px solid grey;">
                                                                <span><?php echo $resultado[0]->subconjunto;?></span>
                                                            </td>
                                                            <td align='left'style="width:10%; padding-left: 5px;"><b>Modelo: </b></td>
                                                            <td align='left' style="width:23%;">
                                                                <span><?php echo $resultado[0]->modelo;?></span>
                                                            </td>
                                                        </tr>

                                                        <tr style="border-top: 1px solid grey;">
                                                            <td align='left' style="padding-left: 5px;"><b>Observações:</b></td>
                                                        </tr>

                                                        <tr style="border-bottom: 1px solid grey;">
                                                            <td align='left' colspan="6" style="padding-left: 5px;">
                                                                <span>
                                                                    <?php

                                                                        if(isset($resultado[0]->observacao)){
                                                                            echo $resultado[0]->observacao;
                                                                        }else{
                                                                            echo "";
                                                                        }

                                                                    ?>
                                                                </span>
                                                            </td>
                                                        </tr>

                                                        <!--DESENHOS DWG-->
                                                        <tr>
                                                            <td align='left' style="padding-left: 5px;">
                                                                <b>Desenho DWG:</b>
                                                            </td>
                                                            <td colspan="5">

                                                                <span>
                                                                    <?php

                                                                        if(isset($resultado[0]->imagemDwg)){
                                                                            echo $resultado[0]->imagemDwg;
                                                                        }else{
                                                                            echo "";
                                                                        }
                                                                        
                                                                    ?>
                                                                </span>

                                                            </td>
                                                        </tr>

                                                        <!--DESENHOS JPG-->
                                                        <tr>
                                                            <td align='left' style="padding-left: 5px;">
                                                                <b>Desenho JPG:</b>
                                                            </td>
                                                            <td colspan="5">

                                                                <span>
                                                                    <?php

                                                                        if(isset($resultado[0]->imagemJpg)){
                                                                            echo $resultado[0]->imagemJpg;
                                                                        }else{
                                                                            echo "";
                                                                        }
                                                                        
                                                                    ?>
                                                                </span>
                                                                
                                                            </td>
                                                        </tr>
                                                    
                                                    </table>

                                                </td>         
                                                        
                                            </tr>

                                        </table>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <br>

                    </div>

                </div>

                <?php echo $custom_error; ?>
                <form action="" id="formProduto1" method="post" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">


                    <!--BOTÕES FORMULÁRIO-->
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset4">
                                
                                <button onclick="confirmaDados()" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Nova Versão PN</button>
                                <!--<button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar PN</button>-->
                                <a href="<?php echo base_url() ?>index.php/desenho/criar_pn" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>

                            </div>
                        </div>
                    </div>
                                                                        
                    <input id="idProdutos" type="hidden" value="<?php echo (isset($resultado[0]->idProdutos)? $resultado[0]->idProdutos : ""); ?>">
                    <input id="versao" type="hidden" value="<?php echo (isset($resultado[0]->versao)? $resultado[0]->versao : -1); ?>">
                    <input id="idPn" type="hidden" value="<?php echo (isset($resultado[0]->idPn)? $resultado[0]->idPn : ""); ?>">
                    <input id="idDesenhos" type="hidden" value="<?php echo (isset($resultado[0]->idDesenhos)? $resultado[0]->idDesenhos : ""); ?>">

                    <?php
                    
                        if(isset($resultado[0]->versaoEmpresa) && $resultado[0]->versaoEmpresa !== ""){
                            echo '<input id="versaoEmpresa" type="hidden" value="'.$resultado[0]->versaoEmpresa. '">';
                        }else{
                            echo '<input id="versaoEmpresa" type="hidden" value="">';
                        }

                    ?>

                    <!--DESCRIÇÃO-->
                    <div class="control-group">
                        <label for="descricao" class="control-label">Descrição<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descricao" type="text" name="descricao" size=50
                                value="<?php echo $resultado[0]->descricao; ?>" />
                        </div>
                    </div>

                    <!--PN-->
                    <div class="control-group">
                        <label for="pn" class="control-label">PN<span class="required">*</span></label>
                        <div class="controls">
                            <input id="pn" type="text" name="pn" size=50
                                value="<?php echo $resultado[0]->pn; ?>" 
                                disabled />
                        </div>
                    </div>

                    <!--EMPRESA-->
                    <div class="control-group">
                        <label for="empresa" class="control-label">EMPRESA(CLIENTE)<span class="required">*</span></label>
                        <div class="controls">
                                           
                            <input id="empresa" type="text" name="empresa" size=50
                                value="<?php echo (isset($resultado[0]->empresa) ? $resultado[0]->empresa : ""); ?>" />
                            <input id="clientes_id" type="hidden" name="clientes_id" 
                                value="<?php echo (isset($resultado[0]->idClientes) ? $resultado[0]->idClientes : ""); ?>" />

                        </div>
                    </div>

                    <!--REFERÊNCIA-->
                    <div class="control-group">
                        <label for="referencia" class="control-label">Referencia<span class="required">*</span></label>
                        <div class="controls">
                            <input id="referencia" type="text" name="referencia" size=50
                                value="<?php echo $resultado[0]->referencia; ?>"  disabled />
                        </div>
                    </div>

                    <!--FORNECEDOR ORIGINAL-->
					<div class="control-group">
                        <label for="fornecedor_original" class="control-label">Fornecedor Original<span class="required">*</span></label>
                        <div class="controls">
                            <input id="fornecedor_original" type="text" name="fornecedor_original" size=50
                                value="<?php echo $resultado[0]->fornecedor_original; ?>" disabled />
                        </div>
                    </div>

                    <!--EQUIPAMENTO-->
					<div class="control-group">
                        <label for="equipamento" class="control-label">Equipamento<span class="required">*</span></label>
                        <div class="controls">
                            <input id="equipamento" type="text" name="equipamento" value="<?php echo $resultado[0]->equipamento; ?>" 
                             size=50 disabled />
                        </div>
                    </div>

                    <!--SUBCONJUNTO-->
					<div class="control-group">
                        <label for="subconjunto" class="control-label">SubConjunto<span class="required">*</span></label>
                        <div class="controls">
                            <input id="subconjunto" type="text" name="subconjunto" size=50
                                value="<?php echo $resultado[0]->subconjunto; ?>" disabled />
                        </div>
                    </div>

                    <!--MODELO-->
					<div class="control-group">
                        <label for="modelo" class="control-label">Modelo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="modelo" type="text" size=50 name="modelo" value="<?php echo $resultado[0]->modelo; ?>" disabled />
                        </div>
                    </div>

                    <!--OBSERVAÇÕES-->
                    <div class="control-group">
                        <label for="observ" class="control-label">Observações<span class="required">*</span></label>
                        <div class="controls">
                            <textarea id="observ"  name="observ" rows="10" cols="70"><?php echo (isset($resultado[0]->observacao) ? $resultado[0]->observacao : ""); ?></textarea>
                        </div>
                    </div>

                    <!--DESENHO-->
                    <div class="control-group">

                        <label for="desenho" class="control-label">Desenho</label>
                        <div class="controls">
                            <!--<a href="#modal-imagem" role="button" data-toggle="modal" class="btn btn-warning"  class="span12" >Anexo desenho</a>-->
                            <a class="btn btn-warning"  class="span12" onclick="mostrarAnexo()">Anexo desenho</a>
                        </div>

                        <div id="imagem">
                            
                            <div class="modal-header">
                                <button type="button" class="close" onclick="fecharAnexo()">×</button>
                                <h5 id="myModalLabel">Anexar Desenho. PN.: </h5> 
                                <p id="obsAnexo">Obs. Obrigatório cadastrar o desenho em DWG e JPG.</p>
                            </div>

                            <div class="modal-body" style="margin: 0px;">

                                <div class="span10">

                                    <br>
                                    <div class="span2">
                                        <label> <b>Arquivo DWG</b> </label>
                                        <input type="file"  name="imag_dwg" id="imag_dwg" accept=".dwg">
                                    </div>   
                                    
                                </div>
                                
                                <div class="span10" style="margin-left:0px"> 

                                    <br>
                                    
                                    <div class="span2">
                                        <label> <b>Arquivo JPG</b></label>
                                        <input type="file"  name="imag_jpg" id="imag_jpg" accept=".jpg">
                                    </div>   
                                    
                                </div>

                            </div>

                        </div>

                    </div>     

                    <!--BOTÕES FORMULÁRIO-->
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset4">
                                
                                <button onclick="confirmaDados()" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Nova Versão PN</button>
                                <!--<button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar PN</button>-->
                                <a href="<?php echo base_url() ?>index.php/desenho/criar_pn" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>

                            </div>
                        </div>
                    </div>

                    
                </form>
            </div>

         </div>
     </div>
</div>

<!-- MODAL CONFIRMAÇÃO DE DADOS -->
<div id="modal-confirma" style="height: 550px; width: 900px; overflow: scroll;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5>CONFIRMAÇÃO DE DADOS</h5>
    </div>

    <div class="span10">
                    
        <div class="controls">
            <br>
            <h4>Você tem certeza que deseja enviar esse desenho para a MASTER? </h4>  
        </div>
        
    </div>

    <div class="modal-content" style="margin-top:0">

        <div class="span12">

            <div class="widget-box">

                <div class="widget-content nopadding">
                    
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0;">
                        
                        <div class="container-fluid" style="margin-top: 20px;">

                            <!--DETALHES PN-->
                            <table class='comBordas' style="font-size:18px; background-color: white;" width='100%' align='left'>
                                <tr>
                                    <td align='center'>
                                        PN: 
                                    </td>
                                    <td align='center'>
                                        Descrição:
                                    </td>
                                    <td align='center'>
                                        Referência: 
                                    </td>
                                    <td align='center'>
                                        Revisão PN: 
                                    </td>
                                </tr>
                                <tr>

                                    <td align='center'>
                                        <font size='5'><b><span id="pn2"></span></b></font>
                                    </td>
                                    <td align='center'>
                                        <b><span id="descricao2"></span></b>
                                    </td>
                                    <td align='center'>
                                        <b><span id="referencia2"></span></b>
                                    </td>

                                    <td align='center'>
                                        <b><span id="versao2"></span></b>
                                    </td>

                                </tr>

                                <tr>
                                    <td><br></td>
                                </tr>

                                <tr id="trEmpresa">

                                    <td align='center' id="tdempresa" colspan="2">
                                        Empresa: 
                                    </td>
                                    <td align='center' id="tdvsempresa" colspan="2">
                                        Revisão Empresa: 
                                    </td>

                                </tr>

                                <tr id="trResulEmpresa">

                                    <td align='center' colspan="2">
                                        <b><span id="empresa2"></span></b>
                                    </td>
                                    <td align='center' colspan="2">
                                        <b><span id="versaoEmpresa2"></span></b>
                                    </td>

                                </tr>

                            </table>

                            <!--DADOS QUE SERÃO ENVIADOS-->
                            <div class="row-fluid">
                                <div class="span12">

                                    <div class="widget-box">

                                        <div class="widget-content nopadding">

                                            <table width='100%' border='0' style="border-style:solid; border: 1px solid grey;
                                                font-family:Arial, Helvetica, sans-serif;
                                                font-size:18px; background-color: white;">
                                                <tr>

                                                    <td align='center'>

                                                        <table width='100%' border='0' style="font-family:Arial, Helvetica, sans-serif;
                                                            font-size:15px; line-height: 20px; padding: 20px;">

                                                            <tr>
                                                                <td align='left' style="padding-left: 5px;"><b>Usuário Criação:</b></td>
                                                                <td align='left' style="border-right: 1px solid grey;">
                                                                    <span id="usuario">
                                                                        <?php echo $this->session->userdata('nome');?>
                                                                    </span>
                                                                </td>
                                                                <td align='left' style="padding-left: 5px;">
                                                                    <b>Equipamento:</b>
                                                                </td>
                                                                <td align='left' style="border-right: 1px solid grey;">
                                                                    <span id="equipamento2"></span>
                                                                </td>
                                                                <td align='left' style="padding-left: 5px;">
                                                                    <b>Fornecedor Original: </b>
                                                                </td>
                                                                <td align='left'>
                                                                    <span id="fornecedor_original2"></span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td align='left' style="padding-left: 5px;"><b>Data: </b></td>
                                                                <td align='left' style="border-right: 1px solid grey;">
                                                                    <span id="data">
                                                                        <?php echo date("d/m/Y H:i:s");?>
                                                                    </span>
                                                                </td>
                                                                <td align='left' style="padding-left: 5px;"><b>SubConjunto: </b></td>
                                                                <td align='left' style="border-right: 1px solid grey;">
                                                                    <span id="subconjunto2"></span>
                                                                </td>
                                                                <td align='left'style="padding-left: 5px;"><b>Modelo: </b></td>
                                                                <td align='left'>
                                                                    <span id="modelo2"></span>
                                                                </td>
                                                            </tr>

                                                            <tr style="border-top: 1px solid grey;">
                                                                <td align='left' style="padding-left: 5px;"><b>Observações:</b></td>
                                                            </tr>

                                                            <tr style="border-bottom: 1px solid grey;">
                                                                <td align='left' colspan="6" style="padding-left: 5px;">
                                                                    <span id="observ2"></span>
                                                                </td>
                                                            </tr>

                                                            <!--DESENHOS DWG-->
                                                            <tr>
                                                                <td align='left' style="padding-left: 5px;">
                                                                    <b>Desenho DWG:</b>
                                                                </td>
                                                                <td colspan="5">
                                                                    <span id="desenho_dwg"></span>
                                                                </td>
                                                            </tr>

                                                            <!--DESENHOS JPG-->
                                                            <tr>
                                                                <td align='left' style="padding-left: 5px;">
                                                                    <b>Desenho JPG:</b>
                                                                </td>
                                                                <td colspan="5">
                                                                    <span id="desenho_jpg"></span>
                                                                </td>
                                                            </tr>
                                                        
                                                        </table>

                                                    </td>         
                                                            
                                                </tr>

                                            </table>
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!--BOTÃO ENVIAR-->
                            <div class="control-group">

                                <div class="controls">

                                    <button onclick="enviaPN(this)" class="btn btn-success">
                                        <i class="icon-plus icon-white"></i> Enviar para a Master
                                    </button>

                                </div>

                            </div>

                            <br>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">

    $(document).ready(function(){

        $("#empresa").autocomplete({
            source: "<?php echo base_url(); ?>index.php/desenho/autoCompleteCliente",
            minLength: 1,
            select: function( event, ui ) {

                $('#clientes_id').val(ui.item.id);
            
            }

        });
    
    });
    
    $(document).ready(function(){

        versaoPn = $('#versao').val();
        versaoPn = parseInt(versaoPn);

        idProdutos = $('#idProdutos').val();

        $(".money").maskMoney();

        $('#formProduto1').validate({
            
            rules :{
                  descricao: { required: true},
                  pn: { required: true},
                  referencia: { required: true},
                  fornecedor_original: { required: true},
                  equipamento: { required: true},
                  subconjunto: { required: true},
                  modelo: { required: true},
                  observ: { required: true},
                  imag_dwg: { required: true},
                  imag_jpg: { required: true}
            },
            messages:{
                  descricao: { required: 'Campo Requerido.'},
                  pn: {required: 'Campo Requerido.'},
                  referencia: {required: 'Campo Requerido.'},
                  fornecedor_original: {required: 'Campo Requerido.'},
                  equipamento: {required: 'Campo Requerido.'},
                  subconjunto: {required: 'Campo Requerido.'},
                  modelo: {required: 'Campo Requerido.'},
                  observ: {required: 'Campo Requerido.'},
                  imag_dwg: {required: 'Obrigatório o cadastro de um desenho em DWG.'},
                  imag_jpg: {required: 'Obrigatório o cadastro de um desenho em JPG.'}
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $('#imagem').show();
                $(element).parents('.des').addClass('error');
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $('#imagem').show();
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }

        });

        $('#imagem').css( "display", "none" );

        $('#formProduto1').submit(function(e) {
            e.preventDefault();
            // ou return falso;
        });

    });

    function mostrarAnexo(){

        $('#imagem').show( 800 );

    }

    function fecharAnexo(){

        $('#imagem').hide( 800 );

    }

    form_data = new FormData();

    $("#imag_dwg").change(function(){
   
        var file_dataDwg = document.getElementById('imag_dwg');

        if(file_dataDwg.files[0] == null || file_dataDwg.files[0] ===""){

        }else{

            var nomeArquivoDWG = file_dataDwg.files[0]["name"].split(".");
            extensaoArquivoDWG = nomeArquivoDWG[1];

            if(extensaoArquivoDWG !== 'dwg' && extensaoArquivoDWG !== 'DWG'){

                alert('Arquivo não é de extensão "DWG"');
                $("#imag_dwg").css("color", "red");

            }else{

                $("#imag_dwg").css("color", "green");

            }
            
        }

    });

    extensaoArquivoJPG = "";

    $("#imag_jpg").change(function(){
   
        var file_dataJpg = document.getElementById('imag_jpg');

        if(file_dataJpg.files[0] == null || file_dataJpg.files[0] ===""){

        }else{

            var nomeArquivoJPG = file_dataJpg.files[0]["name"].split(".");
            extensaoArquivoJPG = nomeArquivoJPG[1];

            if(extensaoArquivoJPG !== 'jpg' && extensaoArquivoJPG !== 'JPG'){

                alert('Arquivo não é de extensão "JPG"');
                $("#imag_jpg").css("color", "red");

            }else{

                $("#imag_jpg").css("color", "green");

            }
            
        }

    });

    novaVersaoEmpresa = "";

    function confirmaDados(){

        // DADOS 1º FORMULÁRIO
        var idPn                = document.getElementById('idPn').value;
        var idDesenhos          = document.getElementById('idDesenhos').value;
        var idClientes          = document.getElementById('clientes_id').value;
        var pn                  = document.getElementById('pn').value;
        var descricao           = document.getElementById('descricao').value;
        var referencia          = document.getElementById('referencia').value;
        var fornecedor_original = document.getElementById('fornecedor_original').value;
        var equipamento         = document.getElementById('equipamento').value;
        var subconjunto         = document.getElementById('subconjunto').value;
        var modelo              = document.getElementById('modelo').value;
        var observ              = document.getElementById('observ').value;
        var empresa             = document.getElementById('empresa').value;
        var file_dataDwg        = document.getElementById('imag_dwg');
        var file_dataJpg        = document.getElementById('imag_jpg');

        $('#trEmpresa').hide();
        $('#trResulEmpresa').hide();
        
        
        if(empresa !== "" && idClientes === ""){

            alert("Empresa(Cliente) não cadastrada no sistema. Favor antes de cadastrar o PN, cadastrar essa nova Empresa.");
            return;

        }

        if(!pn || pn ==="" || !descricao || descricao ==="" ||
           !referencia || referencia ==="" ||
           !fornecedor_original || fornecedor_original ==="" ||
           !equipamento || equipamento ==="" || !subconjunto || subconjunto ==="" ||
           !modelo || modelo ==="" || !observ || observ ==="" ||
           !file_dataDwg.files[0] || !file_dataJpg.files[0]){

            $('#obsAnexo').css({'color':'red','font-weight':'bold'});
            $('#imagem').show();
            return;

        }else{

            if(extensaoArquivoDWG !== 'dwg' && extensaoArquivoDWG !== 'DWG'){

                alert('Favor cadastrar arquivo de Desenho em "DWG"');
                $("#imag_dwg").css("color", "red");
                return;

            }

            if(extensaoArquivoJPG !== 'jpg' && extensaoArquivoJPG !== 'JPG'){

                alert('Favor cadastrar arquivo de Desenho em "JPG"');
                $("#imag_jpg").css("color", "red");
                return;

            }

            //INPUTS PARA ENVIO
            form_data.append('idProdutos', idProdutos);
            form_data.append('idPn', idPn);
            form_data.append('idDesenhos', idDesenhos);
            form_data.append('idClientes', idClientes);
            form_data.append('pn', pn);
            form_data.append('descricao', descricao);
            form_data.append('referencia', referencia);
            form_data.append('fornecedor_original', fornecedor_original);
            form_data.append('equipamento', equipamento);
            form_data.append('subconjunto', subconjunto);
            form_data.append('modelo', modelo);
            form_data.append('observ', observ);
            form_data.append('empresa', empresa);
            form_data.append('imag_dwg', file_dataDwg.files[0]);
            form_data.append('imag_jpg', file_dataJpg.files[0]);

            $("#modal-confirma").modal({
                show: true
            });

            // INPUTS APENAS EXIBIDOS
            $('#descricao2').html(descricao);
            $('#pn2').html(pn);
            $('#referencia2').html(referencia);
            $('#fornecedor_original2').html(fornecedor_original);
            $('#equipamento2').html(equipamento);
            $('#subconjunto2').html(subconjunto);
            $('#modelo2').html(modelo);
            $('#observ2').html(observ);
            $('#desenho_dwg').html(file_dataDwg.files[0]["name"]);
            $('#desenho_jpg').html(file_dataJpg.files[0]["name"]);

            if(empresa === ""){

                var novaVersaoPn = 1 + versaoPn;
                $('#versao2').html("v" + novaVersaoPn);
                form_data.append('versao', novaVersaoPn);

            }else{

                $('#versao2').html("V" + versaoPn);
                form_data.append('versao', versaoPn);

                $('#trEmpresa').show();
                $('#trResulEmpresa').show();

                $('#empresa2').html(empresa);

                var versaoEmpresa = document.getElementById('versaoEmpresa').value;
                if(versaoEmpresa !== ""){

                    versaoEmpresa = parseInt(versaoEmpresa);

                }else{

                    versaoEmpresa = 0;

                }

                novaVersaoEmpresa = versaoEmpresa + 1;

                //console.log(idClientes);

                // VERIFICAÇÃO DE VERSÃO

                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/desenho/verifica_versao_empresa",
                        dataType: 'json',
                        type: 'POST',
                        data:{
                            idProdutos: idProdutos,
                            idClientes: idClientes,
                            versao: versaoPn
                        },
                        success: function(data2) {
                            if(data2.result == true){
                                
                                // SE ESSA VERSÃO DESSA EMPRESA
                                verificaVersaoEmp = parseInt(data2.resultado["versaoEmpresa"]);
                                alteraVersaoEmp(novaVersaoEmpresa, verificaVersaoEmp);

                            }else{

                                // SE NÃO EXISTIR ESSA VERSÃO DA EMPRESA
                                verificaVersaoEmp = parseInt(data2.resultado);
                                novaVersaoEmpresa = verificaVersaoEmp + 1;

                                $('#versaoEmpresa2').html("v" + novaVersaoEmpresa);
                                form_data.append('versaoEmpresa', novaVersaoEmpresa);
                                
                            }
                        },
                        error: function(xhr, textStatus, error) {
                            //window.location.href = "<?php echo base_url() . 'mapos/login';?>";
                            console.log("4");
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(textStatus);
                            console.log(error);
                        },
                    });

                // --------------

            }

        }

    }

    function enviaPN(botao){

        botao.disabled = true;

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/adicionar_versao_pn",
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
                    alert("Nova Revisão PN criada! Porém houve um problema para salvar o log da PN!");
                    $("#modal-confirma").modal('hide');
                    window.location.href = "<?php echo base_url() . 'index.php/desenho/adicionar_versao_pn';?>";
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

    function alteraVersaoEmp(novaVersaoEmpresa, versaoEmp){

        novaVersaoEmpresa = versaoEmp + 1;

        $('#versaoEmpresa2').html("v" + novaVersaoEmpresa);
        form_data.append('versaoEmpresa', novaVersaoEmpresa);

        novaVersaoEmpresa = "";

    }

</script>



