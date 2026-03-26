<?php

    //var_dump($resultado[0]); exit;

    // $a1 = array("nome"=>'Wesley', "idade"=> 19,"peso"=>5);
    // $a2 = array("nome"=>'Wesley1', "idade"=> 19,"peso"=>6);

    // $result = array_diff($a1, $a2);

    // var_dump($corte_desenho[0]); exit;

    if(isset($corte_desenho) && !empty($corte_desenho)){
        $displayCorte = "";
    }else{
        $displayCorte = "none";
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

<script type="text/javascript">
    // INICIO FUNÇÃO DE MASCARA MAIUSCULA
    function maiuscula(z){
            v = z.value.toUpperCase();
            z.value = v;
        }
    //FIM DA FUNÇÃO MASCARA MAIUSCULA
</script>

<style>

    .field.--has-error {
    border-color: #f00;
    }

</style>

<!-- FORMULÁRIO DE CADASTRO -->
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Editar Produto PN</h5>
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

                                                        <!--DESENHOS DE CORTE-->
                                                        <?php

                                                            if(isset($corte_desenho) && !empty($corte_desenho)){

                                                                echo "
                                                                    <tr>

                                                                        <td align='left' colspan='6' style='padding-left: 5px;'>
                                                                            <br><b>Desenho de Corte:</b>
                                                                        </td>

                                                                    </tr>
                                                                ";

                                                                echo "
                                                                    <tr>
                                                                    
                                                                        <td align='left' colspan='6' style='padding-left: 5px;'>
                                                                ";

                                                                        foreach ($corte_desenho as $k => $desCorte) {
                                                                            echo "<span>". $desCorte->imagem ."</span></b> | 
                                                                            Descrição: ".($desCorte->descricao_corte !== "" ? $desCorte->descricao_corte : "-")." 
                                                                            - Observação: ".($desCorte->observacao_corte !== "" ? $desCorte->observacao_corte : "-")."<br>";
                                                                        }

                                                                echo"
                                                                        </td>
                                                                    </tr>
                                                                ";
                            
                                                            }else{
                                                                echo "";
                                                            }

                                                            echo "</tr>";
                                                        
                                                        ?>
                                                    
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

                    <!--BOTÕES FORMULÁRIO-->
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset4">
                                
                                <button onclick="confirmaDados()" class="btn btn-success"><i class="icon-plus icon-white"></i> Editar PN</button>
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
                                value="<?php echo $resultado[0]->descricao; ?>"  />
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
                    <?php
                    
                        if(isset($resultado[0]->empresa) && $resultado[0]->empresa !== ""
                            && $resultado[0]->empresa !== null){

                            echo '
                            
                                <div class="control-group">
                                    <label for="empresa" class="control-label">EMPRESA(CLIENTE)<span class="required">*</span></label>
                                    <div class="controls">
                                                    
                                        <input id="empresa" type="text" name="empresa" size=50 
                                            value="'.$resultado[0]->empresa.'" />
                                        
                                        <input id="clientes_id" type="hidden" name="clientes_id"
                                            value="'.$resultado[0]->idClientes.'" />

                                    </div>
                                </div>
                            
                            ';

                        }else{

                            echo '
                            

                                <input id="empresa" type="hidden" name="empresa" size=50 
                                value="" />
                            
                                <input id="clientes_id" type="hidden" name="clientes_id"
                                    value="" />
                            
                            
                            ';

                        }
                    
                    ?>

                    <!--REFERÊNCIA-->
                    <div class="control-group">
                        <label for="referencia" class="control-label">Referencia<span class="required">*</span></label>
                        <div class="controls">
                            <input id="referencia" type="text" name="referencia" size=50
                                value="<?php echo $resultado[0]->referencia; ?>"  />
                        </div>
                    </div>

                    <!--FORNECEDOR ORIGINAL-->
					<div class="control-group">
                        <label for="fornecedor_original" class="control-label">Fornecedor Original<span class="required">*</span></label>
                        <div class="controls">
                            <input id="fornecedor_original" type="text" name="fornecedor_original" size=50
                                value="<?php echo $resultado[0]->fornecedor_original; ?>" />
                        </div>
                    </div>

                    <!--EQUIPAMENTO-->
					<div class="control-group">
                        <label for="equipamento" class="control-label">Equipamento<span class="required">*</span></label>
                        <div class="controls">
                            <input id="equipamento" type="text" name="equipamento" value="<?php echo $resultado[0]->equipamento; ?>" 
                             size=50 />
                        </div>
                    </div>

                    <!--SUBCONJUNTO-->
					<div class="control-group">
                        <label for="subconjunto" class="control-label">SubConjunto<span class="required">*</span></label>
                        <div class="controls">
                            <input id="subconjunto" type="text" name="subconjunto" size=50
                                value="<?php echo $resultado[0]->subconjunto; ?>" />
                        </div>
                    </div>

                    <!--MODELO-->
					<div class="control-group">
                        <label for="modelo" class="control-label">Modelo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="modelo" type="text" size=50 name="modelo" value="<?php echo $resultado[0]->modelo; ?>" />
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

                        <label for="desenho" class="control-label">Desenho Anexado</label>
                        <div class="controls">

                            
                            <?php

                                if(isset($resultado[0]->imagemDwg)){
                                    echo "<b><span id='desenhoDWG'>".$resultado[0]->nomeArquivoDwg.".".$resultado[0]->extensaoDwg."</span></b>";
                                }else{
                                    echo "";
                                }

                                if(isset($resultado[0]->imagemJpg)){
                                    echo "<br><b><span id='desenhoJPG'>".$resultado[0]->nomeArquivoJpg.".".$resultado[0]->extensaoJpg."</span></b>";
                                }else{
                                    echo "";
                                }

                                if(isset($corte_desenho) && !empty($corte_desenho)){

                                    echo "<hr><b><span><u> Desenho de Corte:</u></span></b>";
                                    foreach ($corte_desenho as $k => $desCorte) {
                                        echo "<br><b><span id='desenhoCorte".$k."'>". $desCorte->imagem ."</span></b> | 
                                        Descrição: ".($desCorte->descricao_corte !== "" ? $desCorte->descricao_corte : "-")." 
                                        - Observação: ".($desCorte->observacao_corte !== "" ? $desCorte->observacao_corte : "-");
                                    }

                                }else{
                                    echo "";
                                }
                                
                            ?>
                            

                        </div>
                        <div class="controls">
                            <!--<a href="#modal-imagem" role="button" data-toggle="modal" class="btn btn-warning"  class="span12" >Anexo desenho</a>-->
                            <a class="btn btn-warning"  class="span12" onclick="mostrarAnexo()">Alterar Desenho / Add Desenho de Corte</a>
                        </div>

                        <!-- PARA ADICIONAR NOVO DESENHO OU DESENHOD E CORTE-->
                        <div id="imagem">
                            
                            <div class="modal-header">
                                <button type="button" class="close" onclick="fecharAnexo()">×</button>
                                <h5 id="myModalLabel">Anexar Desenho. PN.: </h5> 
                                <p id="obsAnexo"><b>Obs.</b> Se desenho for alterado:</p>
                                <p>- Obrigatório cadastrar o desenho em DWG e JPG.</p>
                                <p>- Será adicionada uma nova versão do PN.</p>
                            </div>

                            <div class="modal-body" style="margin: 0px;">

                                <!--Arquivo DWG-->
                                <div class="span10">

                                    <br>
                                    <div class="span2">
                                        <label> <b>Arquivo DWG</b> </label>
                                        <input type="file"  name="imag_dwg" id="imag_dwg" accept=".dwg">
                                    </div>   
                                    
                                </div>
                                
                                <!--Arquivo JPG-->
                                <div class="span10" style="margin-left:0px"> 

                                    <br>
                                    
                                    <div class="span2">
                                        <label> <b>Arquivo JPG</b></label>
                                        <input type="file" name="imag_jpg" id="imag_jpg" accept=".jpg">
                                    </div>   
                                    
                                </div>

                                <!--Desenho de Corte - Arquivo DWG-->
                                <div class="span10" style="margin-left:0px">

                                    <br>

                                    <div class="span10">
                                        <label> <b>Desenho de Corte <br> Arquivo DWG</b></label>
                                        <input type="file"  name="imag_corte" id="imag_corte" accept=".dwg">
                                    </div>

                                    <div class="span10" id="desenhos_corte_title" style="display:none;">
                                        <br>
                                        <h5></h5>
                                    </div>

                                    <!-- Lista de Desenhos de Corte -->
                                    <div class="span7" id="desenhosCorte" style="display:none;">

                                        <table border="0" id="tableCorte" style="width:100%;">

                                            <thead>

                                                <tr class="trpai">
                                                    <th id="thPai"></th>
                                                    <th colspan="3" style="padding-left: 10px;"><h5>Desenhos de Corte Anexados</h5></th>
                                                </tr>

                                                <tr id="title_pai">
                                                    <th></th>
                                                    <th></th>
                                                    <th>Descrição</th>
                                                    <th>Observação</th>
                                                </tr>

                                            </thead>

                                            <tbody id="tbodyFilho" class="trfilho" style="text-align: center;display:none;">

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                        </div>

                    </div>

                    <!--BOTÕES FORMULÁRIO-->
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset4">
                                
                                <button onclick="confirmaDados()" class="btn btn-success"><i class="icon-plus icon-white"></i> Editar PN</button>
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
        <button type="button" class="close" onclick="restartValor();" data-dismiss="modal" aria-hidden="true">×</button>
        <h5>CONFIRMAÇÃO DE DADOS</h5>
    </div>

    <div class="span10">
                    
        <div class="controls">
            <br>
            <h4>Você tem certeza que deseja enviar esse desenho para a MASTER? </h4>  
        </div>
        
    </div>

    <div class="modal-content" style="margin-top:0; ">

        <div class="span12">

            <div class="widget-box">

                <div class="widget-content nopadding">
                    
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0;">
                        
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
                                                                <td align='left' colspan="5">
                                                                    <span id="desenho_dwg"></span>
                                                                </td>
                                                            </tr>

                                                            <!--DESENHOS JPG-->
                                                            <tr>
                                                                <td align='left' style="padding-left: 5px;">
                                                                    <b>Desenho JPG:</b>
                                                                </td>
                                                                <td align='left' colspan="5">
                                                                    <span id="desenho_jpg"></span>
                                                                </td>
                                                            </tr>

                                                            <!--DESENHOS DE CORTE-->
                                                            <tr id="confirm_corte" style="display: <?php echo $displayCorte;?>;">
                                                                
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

        empresa_on = document.getElementById("empresa").value;
    
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
                  observ:  { required: true}
            },
            messages:{
                  descricao: { required: 'Campo Requerido.'},
                  pn: {required: 'Campo Requerido.'},
                  referencia: {required: 'Campo Requerido.'},
                  fornecedor_original: {required: 'Campo Requerido.'},
                  equipamento: {required: 'Campo Requerido.'},
                  subconjunto: {required: 'Campo Requerido.'},
                  modelo: {required: 'Campo Requerido.'},
                  observ: {required: 'Campo Requerido.'}
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.des').addClass('error');
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }

        });

        $('#imagem').css( "display", "none" );

        $('#formProduto1').submit(function(e) {
            e.preventDefault();
            // ou return falso;
        });

        desenhoAtivo = 1;

    });

    $("#imag_dwg").change(function(){

        var file_dataDwg = document.getElementById('imag_dwg');

        if(file_dataDwg.files[0] == null || file_dataDwg.files[0] ===""){

            $("#imag_jpg").css("color", "green");
            alert("O desenho não será alterado sem um novo arquivo DWG!");
            desenhoAtivo = 1;

        }else{

            // SER ARQUIVO NÃO FOR DA EXTENSÃO DWG
            var nomeArquivoDWG = file_dataDwg.files[0]["name"].split(".");
            extensaoArquivoDWG = nomeArquivoDWG[1];

            if(extensaoArquivoDWG !== 'dwg' && extensaoArquivoDWG !== 'DWG'){

                alert('Arquivo não é de extensão "DWG"');
                $("#imag_dwg").css("color", "red");

            }else{

                $("#imag_dwg").css("color", "green");

            }

            var file_dataJpg = document.getElementById('imag_jpg');

            //console.log(file_dataDwg.files[0]);

            if(file_dataJpg.files[0] == null || file_dataJpg.files[0] ===""){
                $("#imag_jpg").css("color", "red");
            }
            desenhoAtivo = 0;

        }

    });

    extensaoArquivoJPG = "";

    $("#imag_jpg").change(function(){

        $("#imag_jpg").css("color", "green");

        var file_dataDwg = document.getElementById('imag_dwg');

        if(file_dataDwg.files[0] == null || file_dataDwg.files[0] ===""){

            alert("Obrigatório enviar o novo desenho em DWG!");

            return;

        }

        var file_dataJpg = document.getElementById('imag_jpg');

        if(file_dataJpg.files[0] == null || file_dataJpg.files[0] ===""){
            $("#imag_jpg").css("color", "red");
        }else{

            // SE ARQUIVO NÃO FOR DE EXTENSÃO JPG
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

    function restartValor(){

        versaoPn = $('#versao').val();
        versaoPn = parseInt(versaoPn);

        versaoEmpresa = document.getElementById('versaoEmpresa').value;

        dataCorte = [];

    }

    function mostrarAnexo(){

        $('#imagem').show( 800 );

    }

    function fecharAnexo(){

        $('#imagem').hide( 800 );

    }

    function openclose(td){

        var tr = document.querySelector(".trfilho");

        if(tr.style.display == "table-row" || tr.style.display == "" || tr.style.display == "table-row-group"){
            $(".trfilho").hide('fast');
            $("#title_pai").hide('fast');
            //$(td).parent('tr').css('background-color', cor);
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");
        }else{
            $(".trfilho").show('fast');
            $("#title_pai").show('fast');
            //$(td).parent('tr').css('background-color', cor);
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }

    }

    extensaoArquivoCorte = "";
    tableCorte = document.getElementById("tableCorte").getElementsByTagName('tbody')[0];
    co = 0;
    cort = 1;
    delet = 0;

    form_dataCorte = [];

    $("#imag_corte").change(function(){

        var file_dataDwg = document.getElementById('imag_corte');

        if(file_dataDwg.files[0] == null || file_dataDwg.files[0] ===""){

        }else{

            var nomeArquivoDWG = file_dataDwg.files[0]["name"].split(".");
            extensaoArquivoCorte = nomeArquivoDWG[1];

            if(extensaoArquivoCorte !== 'dwg' && extensaoArquivoCorte !== 'DWG'){

                alert('Arquivo não é de extensão "DWG"');
                $("#imag_corte").css("color", "red");
                return;

            }else{

                var pn = document.getElementById('pn').value;
                if(pn === "" || pn == null){

                    alert("Necessário primeiro Digitar o PN!");
                    file_dataDwg.value = "";
                    return;

                }else{

                    totalRows = tableCorte.rows.length;

                    if(delet==1){
                        
                        trList = document.querySelectorAll('#tbodyFilho tr');

                        trList.forEach(function (tr_Corte, i, trs) {
                            
                            if(i === trs.length - 1){ 
                                var nameTr = tr_Corte.getAttribute("name");
                                nameTr = parseInt(nameTr);
                                cort = nameTr + 1;
                            }
                            
                        });

                        delet = 0;
                        
                    }

                    $("#imag_corte").css("color", "green");
                    $("#desenhosCorte").css("display", "block");

                    $(".trfilho").show('fast');
                    $("#thPai").find("a > i").removeClass("fa-plus");
                    $("#thPai").find("a > i").addClass("fa-minus");

                    if(tableCorte.rows.length == null || typeof tableCorte.rows.length == "undefined"){
                        var numOfRows = 0;
                    } else {
                        var numOfRows = tableCorte.rows.length;
                    }

                    // ARRAY DESENHOS CORTE
                    form_dataCorte.push(file_dataDwg.files[0]);

                    var indice = form_dataCorte.length -1;

                    var newRow;

                    newRow = tableCorte.insertRow(co);
                    newRow.setAttribute("id","trCorte" + cort);
                    newRow.setAttribute("name", cort);

                    // COLUNA BOTÃO DELETE
                    newCell = newRow.insertCell(0);
                    newCell.innerHTML = '<a onclick="deletaCorte(`trCorte'+ cort +'`,`'+ cort +'`,`'+ file_dataDwg.files[0]["name"] +'`)" class="btn btn-danger tip-top" title="Excluir Desenho"><i class="icon-remove icon-white"></i></a>';

                    // COLUNA NOME DO ARQUIVO
                    newCell = newRow.insertCell(1);
                    newCell.innerHTML = "<b>" + pn + "_corte" + cort + ".dwg</b>";

                    // COLUNA DESCRIÇÃO DO CORTE
                    newCell = newRow.insertCell(2);
                    newCell.innerHTML = '<input type="text" id="descCorte'+ cort +'" name="descCorte'+ cort +'">';

                    // COLUNA DESCRIÇÃO DO CORTE
                    newCell = newRow.insertCell(3);
                    newCell.innerHTML = '<input type="text" id="observCorte'+ cort +'" name="observCorte'+ cort +'" size="40">';

                    co++;
                    cort++;

                }

            }

        }

    });

    function deletaCorte(tr, x, nomeArquivo){

        var trCorte = document.getElementById(tr);
        trCorte.remove();

        var file_dataDwg = document.getElementById('imag_corte');
        file_dataDwg.value = "";

        var i = 0;

        for (const desenho of form_dataCorte) {

            if(desenho["name"] == nomeArquivo){

                form_dataCorte.splice(i, 1);
                dataCorte.splice(i, 1);

                break;

            }

            i++;

        }

        delet = 1;

        if(co > 0){

            co--;
            cort--;

        }

    }

    form_data = new FormData();
    dataCorte = [];

    function confirmaDados(){

        // DADIS 1º FORMULÁRIO (EDIÇÃO)
        var idProdutos          = document.getElementById('idProdutos').value;
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
        var desenhoExistente    = $('#desenhoDWG').html();

        if(desenhoExistente === "" || desenhoExistente == undefined){

            var verifica_dataDwg = document.getElementById('imag_dwg');

            if(verifica_dataDwg.files[0] == null || verifica_dataDwg.files[0] ===""){
                alert("NÃO FOI ENCONTRADO NENHUM DESENHO. FAVOR CADASTRE UM DESENHO PARA CONTINUAR O CADASTRO!");
                return;
            }

        }

        if(empresa !== "" && idClientes === ""){

            alert("Empresa(Cliente) não cadastrada no sistema. Favor antes de cadastrar o PN, cadastrar essa nova Empresa.");
            return;

        }

        if(extensaoArquivoCorte !== '' && extensaoArquivoCorte !== 'dwg' && extensaoArquivoCorte !== 'DWG'){

            alert('Favor cadastrar arquivo de Desenho de Corte em "DWG"');
            $("#imag_corte").css("color", "red");
            return;

        }

        var alterado = 0;
        // PARA CASOS DE ALTERAÇÃO DE EMPRESA
        if(empresa_on == ""){
            // AQUI ENTRARIA SE NÃO TIVESSE EMPRESA
            alterado = 0;
        }else{

            // SE TIVER EMPRESA VERIFICAR SE A PESSOA NÃO DELETOU O NOME DA EMPRESA
            if(empresa == ""){

                alert("CAMPO EMPRESA JA ESTAVA PREENCHIDO! NÃO É POSSIVEL EDITAR ESSE PN SEM EMPRESA!");
                return;

            }else if(empresa_on !== empresa){

                var pergunta = confirm("Você tem certeza que deseja alterar a empresa?");

                if(pergunta == true){
                    alert("PARA CASOS DE ALTERAÇÃO DE EMPRESA, SERÁ ADICIONADO UMA NOVA VERSÃO DE PN!");
                    alterado = 1;
                }else{
                    return;
                }

            }

        }

        // PARA CASOS DE ALTERAÇÃO DE DESENHO
        if(desenhoAtivo==1){

            // SE DESENHO NÃO FOR ALTERADO
            var file_dataDwg = "";
            var file_dataJpg = "";

            var desenhoDWG = $('#desenhoDWG').html();
            var desenhoJPG = $('#desenhoJPG').html();

        }else{

            // CASO O USUÁRIO QUEIRA ALTERAR O DESENHO
            var file_dataDwg = document.getElementById('imag_dwg');
            var file_dataJpg = document.getElementById('imag_jpg');

            if(file_dataJpg.files[0] == null || file_dataJpg.files[0] ===""){

                alert("Necessário adicionar o desenho em JPG!");
                return;

            }else{

                var desenhoDWG = file_dataDwg.files[0]["name"];
                var desenhoJPG = file_dataJpg.files[0]["name"];

            }

        }

        $('#trEmpresa').hide();
        $('#trResulEmpresa').hide();
        

        if(!pn || pn ==="" || !descricao || descricao ==="" ||
           !referencia || referencia ==="" ||
           !fornecedor_original || fornecedor_original ==="" ||
           !equipamento || equipamento ==="" || !subconjunto || subconjunto ==="" ||
           !modelo || modelo ===""){

            //$('#obsAnexo').css({'color':'red','font-weight':'bold'});
            //$('#imagem').show();
            return;
            
        }else if(observ==="" || !observ){

            alert('Favor escreva uma observação sobre o que foi editado no campo "Observações"!');
            return;

        }else{

            //INPUTS PARA ENVIO
            form_data.append('idProdutos', idProdutos);
            form_data.append('idPn', idPn);
            form_data.append('idDesenhos', idDesenhos);
            form_data.append('pn', pn);
            form_data.append('descricao', descricao);
            form_data.append('referencia', referencia);
            form_data.append('fornecedor_original', fornecedor_original);
            form_data.append('equipamento', equipamento);
            form_data.append('subconjunto', subconjunto);
            form_data.append('modelo', modelo);
            form_data.append('observ', observ);
            form_data.append('empresa', empresa);

            if(desenhoAtivo==1){

                // SE DESENHO NÃO FOR ALTERADO
                form_data.append('desenhoDWG', desenhoDWG);

            }else{

                // SE NOVO ARQUIVO NÃO FOR EM DWG
                if(extensaoArquivoDWG !== 'dwg' && extensaoArquivoDWG !== 'DWG'){

                    alert('Favor cadastrar arquivo de Desenho em "DWG"');
                    $("#imag_dwg").css("color", "red");
                    return;

                }

                // SE NOVO ARQUIVO NÃO FOR EM JPG
                if(extensaoArquivoJPG !== 'jpg' && extensaoArquivoJPG !== 'JPG'){

                    alert('Favor cadastrar arquivo de Desenho em "JPG"');
                    $("#imag_jpg").css("color", "red");
                    return;

                }

                // SE DESENHO FOR ALTERADO
                form_data.append('imag_dwg', file_dataDwg.files[0]);
                form_data.append('imag_jpg', file_dataJpg.files[0]);
                form_data.append('desenhoDWG', "");

            }

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
            $('#desenho_dwg').html(desenhoDWG);
            $('#desenho_jpg').html(desenhoJPG);

            if(empresa === ""){

                form_data.append('idClientes', null);

                // desenhoAtivo = 1 SIGNIFICA QUE O DESENHO NÃO FOI ALTERADO
                if(desenhoAtivo == 1){

                    $('#versao2').html("v" + versaoPn);
                    form_data.append('versao', versaoPn);

                }else{

                    // QUANDO O DESENHO FOI ALTERADO
                    versaoPn = versaoPn + 1;

                    $('#versao2').html("v" + versaoPn);
                    form_data.append('versao', versaoPn);

                }

            }else{

                form_data.append('idClientes', idClientes);

                $('#versao2').html("v" + versaoPn);
                form_data.append('versao', versaoPn);

                $('#trEmpresa').show();
                $('#trResulEmpresa').show();

                $('#empresa2').html(empresa);

                var versaoEmpresa = document.getElementById('versaoEmpresa').value;

                // desenhoAtivo = 1 SIGNIFICA QUE O DESENHO NÃO FOI ALTERADO
                if(desenhoAtivo == 1){

                    if(alterado == 1){

                        // QUANDO O DESENHO NÃO FOI ALTERADO MAS A EMPRESA SIM
                        var data_verifica = new FormData();
                        data_verifica.append('idProdutos', idProdutos);
                        data_verifica.append('idClientes', idClientes);

                        // VERIFICA NO BANCO DE DADOS SE EMPRESA COM ESSA PN JA EXISTE
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/desenho/verifica_versao_empresa",
                            dataType: 'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            data:data_verifica,
                            success: function(data2) {
                                if(data2.result == true){
                                    
                                    if(data2.resultado == false){

                                        var novaVersaoEmpresa = 1;
                                        $('#versaoEmpresa2').html("v" + novaVersaoEmpresa);
                                        form_data.append('versaoEmpresa', novaVersaoEmpresa);

                                    }else{
                                        
                                        var versaoEmpresaAntiga = parseInt(data2.resultado.versaoEmpresa);
                                        var novaVersaoEmpresa = versaoEmpresaAntiga + 1;
                                        $('#versaoEmpresa2').html("v" + novaVersaoEmpresa);
                                        form_data.append('versaoEmpresa', novaVersaoEmpresa);

                                    }

                                }else{
                                    
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

                        if(versaoEmpresa !== ""){

                            versaoEmpresa = parseInt(versaoEmpresa);

                        }else{

                            versaoEmpresa = 1;

                        }

                        $('#versaoEmpresa2').html("v" + versaoEmpresa);
                        form_data.append('versaoEmpresa', versaoEmpresa);

                    }

                }else{

                    if(alterado == 1){

                        // QUANDO O DESENHO FOI ALTERADO E A EMPRESA TAMBÉM
                        var data_verifica = new FormData();
                        data_verifica.append('idProdutos', idProdutos);
                        data_verifica.append('idClientes', idClientes);

                        // VERIFICA NO BANCO DE DADOS SE EMPRESA COM ESSA PN JA EXISTE
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/desenho/verifica_versao_empresa",
                            dataType: 'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            data:data_verifica,
                            success: function(data2) {
                                if(data2.result == true){
                                    
                                    if(data2.resultado == false){

                                        var novaVersaoEmpresa = 1;
                                        $('#versaoEmpresa2').html("v" + novaVersaoEmpresa);
                                        form_data.append('versaoEmpresa', novaVersaoEmpresa);

                                    }else{
                                        
                                        var versaoEmpresaAntiga = parseInt(data2.resultado.versaoEmpresa);
                                        var novaVersaoEmpresa = versaoEmpresaAntiga + 1;
                                        $('#versaoEmpresa2').html("v" + novaVersaoEmpresa);
                                        form_data.append('versaoEmpresa', novaVersaoEmpresa);

                                    }

                                }else{
                                    
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

                        // QUANDO O DESENHO FOI ALTERADO E EMPRESA NÃO
                        var data_verifica = new FormData();
                        data_verifica.append('idProdutos', idProdutos);
                        data_verifica.append('idClientes', idClientes);

                        // VERIFICA NO BANCO DE DADOS SE EMPRESA COM ESSA PN JA EXISTE
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/desenho/verifica_versao_empresa",
                            dataType: 'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            data:data_verifica,
                            success: function(data2) {
                                if(data2.result == true){
                                    
                                    if(data2.resultado == false){
                                        
                                        var novaVersaoEmpresa = 1;
                                        $('#versaoEmpresa2').html("v" + novaVersaoEmpresa);
                                        form_data.append('versaoEmpresa', novaVersaoEmpresa);

                                    }else{
                                        
                                        var versaoEmpresaAntiga = parseInt(data2.resultado.versaoEmpresa);
                                        var novaVersaoEmpresa = versaoEmpresaAntiga + 1;
                                        $('#versaoEmpresa2').html("v" + novaVersaoEmpresa);
                                        form_data.append('versaoEmpresa', novaVersaoEmpresa);

                                    }

                                }else{
                                    
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

            }

            var tr_confirm_corte = document.getElementById("confirm_corte");
            var x = 1;
            var td_confirm_corte =  "";

            if(form_dataCorte.length > 0){

                tr_confirm_corte.style.display = "";

                td_confirm_corte = '<td align="left" colspan="6" style="padding-left: 5px;">';
                td_confirm_corte += '<b>Desenhos de Corte:</b></br>';

                var corte = [];

                for (const desenho of form_dataCorte) {

                    var desc = document.getElementById("descCorte"+x);
                    var observCorte = document.getElementById("observCorte"+x);

                    var checaDesc = document.body.contains(desc);

                    //console.log(desc,checaDesc);

                    if(checaDesc == true){

                        corte.push("||");
                        corte.push(desenho["name"]);
                        corte.push(desc.value);
                        corte.push(observCorte.value);
                        var corte_chave = 'corte' + x;
                        //console.log(corte_chave);
                        form_data.append(corte_chave, desenho);

                        td_confirm_corte += desenho["name"] + "<b>(" + corte_chave + ")</b>";
                        
                        td_confirm_corte += ' | <b>Descrição Corte: </b>';
                        if(desc.value !== ""){
                            td_confirm_corte += desc.value;
                        }else{
                            td_confirm_corte += "-";
                        }
               
                        td_confirm_corte += ' | <b>Observação Corte: </b>';
                        if(observCorte.value !== ""){
                            td_confirm_corte += observCorte.value +'<br>';
                        }else{
                            td_confirm_corte += "-<br>";
                        }

                        dataCorte.push(corte);

                        corte = [];

                    }

                    x++;
                
                }

                <?php

                    if(isset($corte_desenho) && !empty($corte_desenho)){

                        foreach ($corte_desenho as $k => $desCorte) {
                            echo "td_confirm_corte +='". $desCorte->imagem ."';
                            td_confirm_corte += ' | <b>Descrição Corte: </b>".($desCorte->descricao_corte !== "" ? $desCorte->descricao_corte : "-")."'; 
                            td_confirm_corte += ' | <b>Observação Corte: </b>".($desCorte->observacao_corte !== "" ? $desCorte->observacao_corte : "-")."<br>';
                            ";
                        }

                    }else{
                        echo "";
                    }
                
                ?>

                td_confirm_corte += '</td>';
                tr_confirm_corte.innerHTML = td_confirm_corte;

            }else{

                <?php

                    if(isset($corte_desenho) && !empty($corte_desenho)){

                        echo"
                        
                            td_confirm_corte = `<td align='left' colspan='6' style='padding-left: 5px;'>`;
                            td_confirm_corte += '<b>Desenhos de Corte:</b></br>';
                        
                        ";

                        foreach ($corte_desenho as $k => $desCorte) {
                            echo "td_confirm_corte +='". $desCorte->imagem ."';
                            td_confirm_corte += ' | <b>Descrição Corte: </b>".($desCorte->descricao_corte !== "" ? $desCorte->descricao_corte : "-")."'; 
                            td_confirm_corte += ' | <b>Observação Corte: </b>".($desCorte->observacao_corte !== "" ? $desCorte->observacao_corte : "-")."<br>';
                            ";
                        }

                        echo "td_confirm_corte += '</td>';";

                        echo "tr_confirm_corte.innerHTML = td_confirm_corte;";

                    }else{
                        echo "tr_confirm_corte.innerHTML = '';";
                    }
                    
                ?>

            }

            console.log("array",dataCorte);

            form_data.append('desenhos_corte', dataCorte);

        }

    }

    function enviaPN(botao){

        botao.disabled = true;

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/editar_pn",
            dataType: 'json',
            cache: false,
            async: false,
            contentType: false,
            processData: false,
            type: 'POST',
            data:form_data,
            success: function(data2) {
                if(data2.result == true){

                    window.location.href = "<?php echo base_url() . 'index.php/desenho/criar_pn';?>";

                }else{

                    //console.log(data2.resultado);
                    botao.disabled = false;
                    alert("Nenhum dado foi editado!");
                    $("#modal-confirma").modal('hide');
                    return;
                    

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

</script>



