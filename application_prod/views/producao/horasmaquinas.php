<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/moment.js"></script>
<script src="<?php echo base_url()?>js/jquery.inputmask.bundle.js"></script><!--
<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Horas Máquinas</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs">
                                <form class="form-inline" action="<?php echo base_url() ?>index.php/producao/adicionarhoramaquina" method="post">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span12" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Máquinas: </label>
                                            
                                                <?php 
                                                    $tipo = "";
                                                    echo '<div>';
                                                    foreach($maquinas as $r){
                                                        if(isset($horasMaquinasId)){
                                                            if($tipo == $r->nome){
                                                                if($r->idMaquinas == $horasMaquinasId->idMaquina){
                                                                    echo ' |<input checked style="margin-left:5px;margin-top: 0px;" type = "radio"  name = "maquina" id="'.$r->descricao.'" class="check" value = "'.$r->idMaquinas.'"> &nbsp;<label for="'.$r->descricao.'">'.$r->descricao.'</label>';
                                                                }else{
                                                                    echo ' |<input style="margin-left:5px;margin-top: 0px;" type = "radio"  name = "maquina" id="'.$r->descricao.'" class="check" value = "'.$r->idMaquinas.'"> &nbsp;<label for="'.$r->descricao.'">'.$r->descricao.'</label>';
                                                                }
                                                                
                                                            }else{
                                                                echo '</div>';
                                                                echo '<div>';
                                                                $tipo = $r->nome;
                                                                if($r->idMaquinas == $horasMaquinasId->idMaquina){
                                                                    echo '<input checked style="margin-left:5px;margin-top: 0px;" type = "radio"  name = "maquina" id="'.$r->descricao.'" class="check" value = "'.$r->idMaquinas.'"> &nbsp; <label for="'.$r->descricao.'">'.$r->descricao.'</label>';
                                                            
                                                                }else{
                                                                    echo '<input style="margin-left:5px;margin-top: 0px;" type = "radio"  name = "maquina" id="'.$r->descricao.'" class="check" value = "'.$r->idMaquinas.'"> &nbsp; <label for="'.$r->descricao.'">'.$r->descricao.'</label>';
                                                                }
                                                                
                                                            }
                                                        }else{
                                                            if($tipo == $r->nome){
                                                                echo ' |<input style="margin-left:5px;margin-top: 0px;" type = "radio"  name = "maquina" id="'.$r->descricao.'" class="check" value = "'.$r->idMaquinas.'"> &nbsp;<label for="'.$r->descricao.'">'.$r->descricao.'</label>';
                                                            }else{
                                                                echo '</div>';
                                                                echo '<div>';
                                                                $tipo = $r->nome;
                                                                echo '<input style="margin-left:5px;margin-top: 0px;" type = "radio"  name = "maquina" id="'.$r->descricao.'" class="check" value = "'.$r->idMaquinas.'"> &nbsp; <label for="'.$r->descricao.'">'.$r->descricao.'</label>';
                                                            
                                                            }
                                                        }
                                                        
                                                        
                                                    }
                                                    echo '<div>';
                                                ?>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                   
                                    <div class="widget-box">                                        
                                        <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                            <thead>
                                                <tr>
                                                    <th>OS</th>
                                                    <th>PN</th>
                                                    <th>Operação</th>
                                                    <th>Qtd. para fabricar</th>
                                                    <th colspan='2'>Tempo de Preparação</th> 
                                                    <th colspan='2'>Tempo de Fabricação do Lote</th>
                                                    <th>Qtd. para Estoque</th>    
                                                    <th>Qtd. fabricado</th>                                                
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Inicio</th> 
                                                    <th>Fim</th>
                                                    <th>Inicio</th> 
                                                    <th>Fim</th> 
                                                    <th></th>   
                                                    <th></th>                                           
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <td style="text-align:center"><input type='text' name="os" id="os" <?php if(!empty($horasMaquinasId->idOs)){ echo 'disabled';}?> value="<?php if(isset($horasMaquinasId)){ echo $horasMaquinasId->idOs;}?>" style="width:90%;">
                                                    <input type='hidden' name="idHorasMaq" id="idHorasMaq" <?php if(!empty($horasMaquinasId->idHorasMaquinas)){ echo 'disabled';}?> value="<?php if(isset($horasMaquinasId)){ echo $horasMaquinasId->idHorasMaquinas;} ?>"></td><!-- autocomplete os -->
                                                    <td style="text-align:center"><input type='text' name="pn" <?php if(!empty($horasMaquinasId->pn)){ echo 'disabled';}?> id="pn" value="<?php if(isset($horasMaquinasId)){ echo $horasMaquinasId->pn;} ?>" style="width:90%;">
                                                    <input type='hidden' name="idProduto" id="idProduto" <?php if(!empty($horasMaquinasId->idProduto)){ echo 'disabled';}?> value="<?php if(isset($horasMaquinasId)){ echo $horasMaquinasId->idProduto;} ?>"></td> <!-- autocomplete PN -->
                                                    <td style="text-align:center"><input type='text' name="operacao" id="operacao" <?php if(!empty($horasMaquinasId->operacao)){ echo 'disabled';}?> value="<?php if(isset($horasMaquinasId)){ echo $horasMaquinasId->operacao;} ?>" style="width:90%;"></td><!-- selectbox -->
                                                    <td style="text-align:center"><input type='text' name="qtdPfabricar" id="qtdPfabricar" <?php if(!empty($horasMaquinasId->quantidadeParaFabricacao)){ echo 'disabled';}?> value="<?php if(isset($horasMaquinasId)){ echo $horasMaquinasId->quantidadeParaFabricacao;} ?>" style="width:90%;"></td>
                                                    <td style="text-align:center">
                                                        <?php
                                                            if(isset($horasMaquinasId) && !empty($horasMaquinasId->horaEntradaPreparacao)){
                                                                $date = new DateTime( $horasMaquinasId->horaEntradaPreparacao );                                                                 
                                                                echo '<div class="divButtonPrepIni" style="display:none">
                                                                        <a role="button" class="btn btn-success" id="buttonPrepIni" name="buttonPrepIni">Iniciar</a>
                                                                    </div>
                                                                    <div class="divInputPrepIni" style="display:block">
                                                                        <input class="data" type="text" id="dataPrepIni" name="dataPrepIni" value="'.str_replace("-","/",$date-> format( 'd-m-Y H:i' )).'">
                                                                    </div>';
                                                            }else{
                                                                echo '<div class="divButtonPrepIni" style="display:block">
                                                                        <a role="button" class="btn btn-success" id="buttonPrepIni" name="buttonPrepIni">Iniciar</a>
                                                                    </div>
                                                                    <div class="divInputPrepIni" style="display:none">
                                                                        <input class="data" type="text" id="dataPrepIni" name="dataPrepIni" value="">
                                                                    </div>';
                                                            }
                                                        ?>
                                                                                                                
                                                    </td> <!-- botão para iniciar e finalizar -->
                                                    <td style="text-align:center">
                                                        <?php
                                                            if(isset($horasMaquinasId) && !empty($horasMaquinasId->horaSaidaPreparacao)){
                                                                $date = new DateTime($horasMaquinasId->horaSaidaPreparacao);
                                                                echo '<div class="divButtonPrepFinal" style="display:none">
                                                                        <a role="button" class="btn btn-warning" id="buttonPrepFinal" name="buttonPrepFinal">Finalizar</a>
                                                                    </div>
                                                                    <div class="divInputPrepFinal" style="display:block">
                                                                        <input class="data" type="text" id="dataPrepFinal" name="dataPrepFinal" value="'.str_replace("-","/",$date-> format( 'd-m-Y H:i:s' )).'">
                                                                    </div>';
                                                            }else{
                                                                echo '<div class="divButtonPrepFinal" style="display:block">
                                                                        <a role="button" class="btn btn-warning" id="buttonPrepFinal" name="buttonPrepFinal">Finalizar</a>
                                                                    </div>
                                                                    <div class="divInputPrepFinal" style="display:none">
                                                                        <input class="data" type="text" id="dataPrepFinal" name="dataPrepFinal" value="">
                                                                    </div>';
                                                            }
                                                        ?>
                                                        
                                                    </td><!-- botão para iniciar e finalizar -->
                                                    <td style="text-align:center">
                                                        <?php
                                                            if(isset($horasMaquinasId) && !empty($horasMaquinasId->horaEntradaFabricacao)){
                                                                $date = new DateTime($horasMaquinasId->horaEntradaFabricacao);
                                                                echo '<div class="divButtonFabIni" style="display:none">
                                                                        <a role="button" class="btn btn-success" id="buttonFabIni" name="buttonFabIni">Iniciar</a>
                                                                    </div>
                                                                    <div class="divInputFabIni" style="display:block">
                                                                        <input class="data" type="text" id="dataFabIni" name="dataFabIni" value="'.str_replace("-","/",$date-> format( 'd-m-Y H:i:s' )).'">
                                                                    </div>';
                                                            }else{
                                                                echo '<div class="divButtonFabIni" style="display:block">
                                                                        <a role="button" class="btn btn-success" id="buttonFabIni" name="buttonFabIni">Iniciar</a>
                                                                    </div>
                                                                    <div class="divInputFabIni" style="display:none">
                                                                        <input class="data" type="text" id="dataFabIni" name="dataFabIni" value="">
                                                                    </div>';
                                                            }
                                                        ?>
                                                        
                                                    </td> <!-- botão para iniciar e finalizar -->
                                                    <td style="text-align:center">
                                                        <?php
                                                            if(isset($horasMaquinasId) && !empty($horasMaquinasId->horaSaidaFabricacao)){
                                                                $date = new DateTime($horasMaquinasId->horaSaidaFabricacao);
                                                                echo '<div class="divButtonFabFinal" style="display:none" >
                                                                        <a role="button" class="btn btn-warning" id="buttonFabFinal" name="buttonFabFinal">Finalizar</a>
                                                                    </div>
                                                                    <div class="divInputFabFinal" style="display:block">
                                                                        <input class="data" type="text" id="dataFabFinal" name="dataFabFinal" value="'.str_replace("-","/",$date-> format( 'd-m-Y H:i:s' )).'">
                                                                    </div>';
                                                            }else{
                                                                echo '<div class="divButtonFabFinal" style="display:block" >
                                                                        <a role="button" class="btn btn-warning" id="buttonFabFinal" name="buttonFabFinal">Finalizar</a>
                                                                    </div>
                                                                    <div class="divInputFabFinal" style="display:none">
                                                                        <input class="data" type="text" id="dataFabFinal" name="dataFabFinal" value="">
                                                                    </div>';
                                                            }
                                                        ?>
                                                           
                                                    </td> <!-- botão para iniciar e finalizar -->
                                                    <td style="text-align:center"><input type='text' name="qtdEstoque" id="qtdEstoque"  value="<?php if(isset($horasMaquinasId)){ echo $horasMaquinasId->quantidadeEstoque;} ?>" style="width:90%;"></td>
                                                    <td style="text-align:center"><input type='text' name="qtdFabricada" id="qtdFabricada" value="<?php if(isset($horasMaquinasId)){ echo $horasMaquinasId->quantidadeFabricada;} ?>" style="width:90%;"></td>  
                                            </tbody>
                                        </table>                                        
                                    </div>
                                    <div class="widget-box" style="display:flex;margin-left:-5px; margin-right:-5px;">
                                        <div style=" flex: 50%;  ">
                                            <table class="table table-bordered ">
                                                <thead>
                                                    <tr>  
                                                        <th colspan='2' style="border:1px solid #ddd">Motivos de Parada</th>
                                                        <th colspan='2' style="border:1px solid #ddd">Tempo de Parada</th>                                               
                                                    </tr>
                                                    <tr>
                                                        <th colspan='2' style="border:1px solid #ddd"></th>
                                                        <th style="border:1px solid #ddd">Inicio</th> 
                                                        <th style="border:1px solid #ddd">Fim</th>                                            
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>                                                  
                                                    <?php
                                                        foreach($motivos_parada as $r){
                                                            $verifyParada = 0;
                                                            if(!empty($horasMaqParada)){
                                                                foreach($horasMaqParada as $t){
                                                                    if($r->idMotivoParada == $t->idMotivosParada){
                                                                        $verifyParada = 1;
                                                                        echo '<tr>';
                                                                            echo '<td style="border:1px solid #ddd; text-align:center"><input type="checkbox" checked value="'.$r->idMotivoParada.'" name="idMotivosParada_" id="idMotivosParada-'.$r->idMotivoParada.'"></td>';
                                                                            echo '<td style="border:1px solid #ddd; text-align:center">'.$r->descricaoMotivoParada.'</td>';
                                                                            if(!empty($t->horaInicial)){
                                                                                $date = new DateTime($t->horaInicial);
                                                                                echo '<td style="border:1px solid #ddd; text-align:center">
                                                                                    <div class="divButtonMParadaIniciar-'.$r->idMotivoParada.'" style="display:none">
                                                                                        <a role="button" class="btn btn-success" id="buttonMParadaIniciar-'.$r->idMotivoParada.'" name="buttonMParadaIniciar">Iniciar</a>
                                                                                    </div>
                                                                                    <div class="divInputMParadaIniciar-'.$r->idMotivoParada.'" style="display:block">
                                                                                        <input class="data" type="text" value="'.str_replace("-","/",$date->format( 'd-m-Y H:i:s' )).'" style="width:90%;" name="dataParadaInicio" id="dataParadaInicio-'.$r->idMotivoParada.'"></td>
                                                                                    </div>';
                                                                            }else{
                                                                                echo '<td style="border:1px solid #ddd; text-align:center">
                                                                                    <div class="divButtonMParadaIniciar-'.$r->idMotivoParada.'" style="display:block">
                                                                                        <a role="button" class="btn btn-success" id="buttonMParadaIniciar-'.$r->idMotivoParada.'" name="buttonMParadaIniciar">Iniciar</a>
                                                                                    </div>
                                                                                    <div class="divInputMParadaIniciar-'.$r->idMotivoParada.'" style="display:none">
                                                                                        <input class="data" type="text" value="" style="width:90%;" name="dataParadaInicio" id="dataParadaInicio-'.$r->idMotivoParada.'"></td>
                                                                                    </div>';
                                                                            }
                                                                            if(!empty($t->horaFinal)){
                                                                                $date = new DateTime($t->horaFinal);
                                                                                echo '<td style="border:1px solid #ddd; text-align:center">
                                                                                    <div class="divButtonMParadaFim-'.$r->idMotivoParada.'" style="display:none">
                                                                                        <a role="button" class="btn btn-warning" id="buttonMParadaFinal-'.$r->idMotivoParada.'" name="buttonMParadaFinal">Finalizar</a>
                                                                                    </div>
                                                                                    <div class="divInputMParadaFim-'.$r->idMotivoParada.'" style="display:block">
                                                                                        <input class="data" type="text" value="'.str_replace("-","/",$date->format( 'd-m-Y H:i:s' )).'" style="width:90%;" name="dataParadaFim" id="dataParadaFim-'.$r->idMotivoParada.'"></td>
                                                                                    </div>';
                                                                            }else{
                                                                                echo '<td style="border:1px solid #ddd; text-align:center">
                                                                                    <div class="divButtonMParadaFim-'.$r->idMotivoParada.'" style="display:block">
                                                                                        <a role="button" class="btn btn-warning" id="buttonMParadaFinal-'.$r->idMotivoParada.'" name="buttonMParadaFinal">Finalizar</a>
                                                                                    </div>
                                                                                    <div class="divInputMParadaFim-'.$r->idMotivoParada.'" style="display:none">
                                                                                        <input class="data" type="text" value="" style="width:90%;" name="dataParadaFim" id="dataParadaFim-'.$r->idMotivoParada.'"></td>
                                                                                    </div>';
                                                                            }
                                                                            
                                                                        echo '</tr>';
                                                                    }
                                                                }
                                                            }
                                                            if($verifyParada == 0){
                                                                echo '<tr>';
                                                                    echo '<td style="border:1px solid #ddd; text-align:center"><input type="checkbox" value="'.$r->idMotivoParada.'" name="idMotivosParada_" id="idMotivosParada-'.$r->idMotivoParada.'"></td>';
                                                                    echo '<td style="border:1px solid #ddd; text-align:center">'.$r->descricaoMotivoParada.'</td>';
                                                                    echo '<td style="border:1px solid #ddd; text-align:center">
                                                                        <div class="divButtonMParadaIniciar-'.$r->idMotivoParada.'" style="display:block">
                                                                            <a role="button" class="btn btn-success" id="buttonMParadaIniciar-'.$r->idMotivoParada.'" name="buttonMParadaIniciar">Iniciar</a>
                                                                        </div>
                                                                        <div class="divInputMParadaIniciar-'.$r->idMotivoParada.'" style="display:none">
                                                                            <input class="data" type="text" value="" style="width:90%;" name="dataParadaInicio" id="dataParadaInicio-'.$r->idMotivoParada.'"></td>
                                                                        </div>';
                                                                    echo '<td style="border:1px solid #ddd; text-align:center">
                                                                        <div class="divButtonMParadaFim-'.$r->idMotivoParada.'" style="display:block">
                                                                            <a role="button" class="btn btn-warning" id="buttonMParadaFinal-'.$r->idMotivoParada.'" name="buttonMParadaFinal">Finalizar</a>
                                                                        </div>
                                                                        <div class="divInputMParadaFim-'.$r->idMotivoParada.'" style="display:none">
                                                                            <input class="data" type="text" value="" style="width:90%;" name="dataParadaFim" id="dataParadaFim-'.$r->idMotivoParada.'"></td>
                                                                        </div>';
                                                                echo '</tr>'; 
                                                            }
                                                            
                                                        } 
                                                        ?>                                             
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style=" flex: 50%;  padding-left:5px">
                                            <table class="table table-bordered ">
                                                <thead>
                                                    <tr >
                                                        <th colspan='2' style="border:1px solid #ddd">Motivos de Perda</th> 
                                                        <th colspan='2' style="border:1px solid #ddd">Quantidade de Perda</th>                                             
                                                    </tr>
                                                    <tr style="height:29px">   
                                                        <th colspan='2'></th> 
                                                        <th colspan='2'></th>                     
                                                    </tr>
                                                </thead>                                                
                                                <tbody> 
                                                    <?php
                                                        foreach($motivos_perda as $r){
                                                            $verifyPerda = 0;
                                                            if(!empty($maqPerda)){
                                                                foreach($maqPerda as $t){
                                                                    if($t->idMotivosPerda == $r->idMotivosPerda){
                                                                        $verifyPerda = 1;
                                                                        echo '<tr>';
                                                                            echo '<td style="border:1px solid #ddd; text-align:center"><input type="checkbox" checked value="'.$r->idMotivosPerda.'" name="idMotivosPerda_" id="idMotivosPerda_"></td>';
                                                                            echo '<td style="border:1px solid #ddd; text-align:center">'.$r->descricaoMotivosPerda.'</td>';
                                                                            echo '<td colspan="2" style="border:1px solid #ddd; text-align:center"><input type="text" value="'.$t->quantidade.'" style="width:90%;" name="quantidadePerda" id="quantidadePerda"></td>';
                                                                        echo '</tr>';
                                                                    }
                                                                }
                                                            }
                                                            if($verifyPerda == 0){
                                                                echo '<tr>';
                                                                    echo '<td style="border:1px solid #ddd; text-align:center"><input type="checkbox" value="'.$r->idMotivosPerda.'" name="idMotivosPerda_" id="idMotivosPerda_"></td>';
                                                                    echo '<td style="border:1px solid #ddd; text-align:center">'.$r->descricaoMotivosPerda.'</td>';
                                                                    echo '<td colspan="2" style="border:1px solid #ddd; text-align:center"><input type="text" value="" style="width:90%;" name="quantidadePerda" id="quantidadePerda"></td>';
                                                                echo '</tr>';
                                                            }
                                                            
                                                        } 
                                                    ?> 
                                                </tbody>                                                   
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-actions" align='center'>
                                        <a role="button" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success" onclick="salvarHorasMaquinas()"><i class="icon-plus icon-white"></i>Salvar</a>
                                        <button role="button"  class="btn btn-success" type="submit"><i class="icon-plus icon-white"></i>Novo Hora Máquina</button>
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
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Em Execução</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs">                                
                                <div class="widget-box">                                        
                                    <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                        <thead>
                                            <tr>
                                                <th>Máquina</th>
                                                <th>OS</th>
                                                <th>PN</th>
                                                <th>Operação</th>
                                                <th>Qtd. para fabricar</th>
                                                <th colspan='2'>Tempo de Preparação</th> 
                                                <th colspan='2'>Tempo de Fabricação do Lote</th>
                                                <th>Qtd. fabricado</th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th >Inicio</th> 
                                                <th >Fim</th> 
                                                <th >Inicio</th>
                                                <th >Fim</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(!empty($allHorasMaquinas)){
                                                foreach($allHorasMaquinas as $r){?>
                                                    
                                                    <tr>
                                                        <form class="form-inline" action="<?php echo base_url() ?>index.php/producao/adicionarHoraMaquina/<?php echo $r->idHorasMaquinas;?>" method="post">
                                                            <td>
                                                                <?php echo $r->descricao;?>
                                                            </td>
                                                            <td>
                                                                <?php echo $r->idOs;?>
                                                            </td>
                                                            <td>
                                                                <?php echo $r->pn;?>
                                                            </td>
                                                            <td>
                                                                <?php echo $r->operacao;?>
                                                            </td>
                                                            <td >
                                                                <?php echo $r->quantidadeParaFabricacao;?>
                                                            </td>
                                                            <td >
                                                                <?php 
                                                                if(!empty($r->horaEntradaPreparacao)){
                                                                    $date = new DateTime($r->horaEntradaPreparacao);
                                                                    echo str_replace("-","/",$date->format( 'd-m-Y H:i:s' ));
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($r->horaSaidaPreparacao)){
                                                                    $date = new DateTime($r->horaSaidaPreparacao);
                                                                    echo str_replace("-","/",$date->format( 'd-m-Y H:i:s' ));
                                                                }?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($r->horaEntradaFabricacao)){
                                                                    $date = new DateTime($r->horaEntradaFabricacao);
                                                                    echo str_replace("-","/",$date->format( 'd-m-Y H:i:s' ));
                                                                }?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($r->horaSaidaFabricacao)){
                                                                    $date = new DateTime($r->horaSaidaFabricacao);
                                                                    echo str_replace("-","/",$date->format( 'd-m-Y H:i:s' ));
                                                                }?>
                                                            </td>
                                                            <td>
                                                                <?php echo $r->quantidadeFabricada;?>
                                                            </td>
                                                            <td>
                                                                <button type="submit" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i> Editar</button>
                                                            </td>
                                                        </form>
                                                    </tr>
                                                    
                                                <?php
                                                }
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
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Histórico</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs">                                
                                <div class="widget-box">                                        
                                    <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                        <thead>
                                            <tr>
                                                <th>Máquina</th>
                                                <th>OS</th>
                                                <th>PN</th>
                                                <th>Operação</th>                                                
                                                <th >Tempo de Preparação</th> 
                                                <th >Tempo de Fabricação do Lote</th>
                                                <th>Qtd. fabricado</th>
                                                <th>Custo hora | homem | maquina</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(!empty($historicoMaquinas)){
                                                foreach($historicoMaquinas as $r){
                                                    if(!empty($r->horaEntradaPreparacao)){
                                                        $date = new DateTime($r->horaEntradaPreparacao);
                                                        $horaEntradaPreparacao = str_replace("-","/",$date->format('d-m-Y H:i:s'));
                                                      }else{
                                                        $horaEntradaPreparacao = '';
                                                      }
                                                      if(!empty($r->horaSaidaPreparacao)){
                                                        $date = new DateTime($r->horaSaidaPreparacao);
                                                        $horaSaidaPreparacao = str_replace("-","/",$date->format('d-m-Y H:i:s'));
                                                      }else{
                                                        $horaSaidaPreparacao = '';
                                                      }
                                                      if(!empty($r->horaEntradaFabricacao)){
                                                        $date = new DateTime($r->horaEntradaFabricacao);
                                                        $horaEntradaFabricacao = str_replace("-","/",$date->format('d-m-Y H:i:s'));
                                                      }else{
                                                        $horaEntradaFabricacao = '';
                                                      }
                                                      if(!empty($r->horaSaidaFabricacao)){
                                                        $date = new DateTime($r->horaSaidaFabricacao);
                                                        $horaSaidaFabricacao = str_replace("-","/",$date->format('d-m-Y H:i:s'));
                                                      }else{
                                                        $horaSaidaFabricacao = '';
                                                      }
                                                      if(!empty($r->horaEntradaPreparacao) && !empty($r->horaSaidaPreparacao)){
                                                        $hrEntrPrep = new DateTime($r->horaSaidaPreparacao);
                                                        $hrSaidPrep = new DateTime($r->horaEntradaPreparacao);
                                                        $diffDataPreparacao = $hrSaidPrep->diff($hrEntrPrep);
                                                      }else{
                                                        $diffDataPreparacao = '';
                                                      }
                                                      if(!empty($r->horaEntradaFabricacao) && !empty($r->horaSaidaFabricacao)){
                                                        $hrEntrFab = new DateTime($r->horaEntradaFabricacao);
                                                        $hrSaidFab = new DateTime($r->horaSaidaFabricacao);
                                                        $diffDataFabricacao = $hrSaidFab->diff($hrEntrFab);
                                                      }else{
                                                        $diffDataFabricacao = '';
                                                      }
                                                      if(!empty($diffDataFabricacao) && !empty($diffDataPreparacao)){
                                                        $e = new DateTime('00:00');
                                                        $f = clone $e;
                                                        echo("<script>console.log('HR ".$diffDataFabricacao->h.":".$diffDataFabricacao->i."');</script>");
                                                        echo("<script>console.log('HR ".$diffDataPreparacao->h.":".$diffDataPreparacao->i."');</script>");
                                                        $minutos = ($diffDataFabricacao->i + $diffDataPreparacao->i)/60;
                                                        $horas = intval($minutos) + $diffDataFabricacao->h + $diffDataPreparacao->h;           
                                                        $minutos = $minutos - intval($minutos);       
                                                        
                                                        $minutos = $minutos*60;
                                                       // $e->add($diffDataFabricacao);
                                                        //$e->add($diffDataPreparacao);
                                                        //$total->add($diffDataFabricacao);
                                                        //$total->add($diffDataPreparacao);
                                                        //$hours = $f->diff($e)->h;
                                                        //$hours = $hours + ($f->diff($e)->days*24);
                                                        //$diffTempoGasto = $f->diff($e)->format("%H:%I");
                                                        $diffTempoGasto = $horas.":".$minutos;
                                                      }else if(!empty($diffDataFabricacao)){
                                                        //$total->add($diffDataFabricacao);
                                                        $hours = $diffDataFabricacao->h;
                                                        $hours = $hours + ($diffDataFabricacao->days*24);
                                                        $diffTempoGasto = $hours.$diffDataFabricacao->format(":%I");
                                                      }else if(!empty($diffDataPreparacao)){
                                                        //$total->add($diffDataPreparacao);
                                                        $hours = $diffDataPreparacao->h;
                                                        $hours = $hours + ($diffDataPreparacao->days*24);
                                                        $diffTempoGasto = $diffDataPreparacao->format(":%I");
                                                      }else{
                                                        $diffTempoGasto = '';
                                                      }
                                                    
                                                    
                                                    ?>
                                                
                                                    
                                                    <tr>
                                                        <form class="form-inline" action="<?php echo base_url() ?>index.php/producao/adicionarHoraMaquina/<?php echo $r->idHorasMaquinas;?>" method="post">
                                                            <td>
                                                                <?php echo $r->descricao;?>
                                                            </td>
                                                            <td>
                                                                <?php echo $r->idOs;?>
                                                            </td>
                                                            <td>
                                                                <?php echo $r->pn;?>
                                                            </td>
                                                            <td>
                                                                <?php echo $r->operacao;?>
                                                            </td>
                                                            <td >                                                                
                                                                <?php 
                                                                if(!empty($diffDataPreparacao)){
                                                                    echo ($diffDataPreparacao->h + ($diffDataPreparacao->days*24)).$diffDataPreparacao->format(":%I");
                                                                }                                                                
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                echo ($diffDataFabricacao->h + ($diffDataFabricacao->days*24)).$diffDataFabricacao->format(":%I");?>
                                                            </td>
                                                            <td>
                                                                <?php echo $r->quantidadeFabricada;?>
                                                            </td>
                                                            <td>
                                                                <?php echo "R$ ".number_format((float)(((explode(":",$diffTempoGasto)[0])*300)+(300*((explode(":",$diffTempoGasto)[1])/60))),2,',','.');?>
                                                            </td>
                                                        </form>
                                                    </tr>
                                                    
                                                <?php
                                                }
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
<script type="text/javascript">
    var pn = document.getElementById('pn');
    $('.data').inputmask("datetime",{
        inputFormat: "dd/mm/yyyy HH:MM:"
    });                                  
    
    pn.onkeydown = function() {
        var key = event.keyCode || event.charCode;

        if( key == 8 || key == 46 ){      
            document.querySelector("#idProduto").value = "";
        }
    };

    pn.onkeyup = function() {
        var key = event.keyCode || event.charCode; 
        if(key != 9){
            document.querySelector("#idProduto").value = "";
        }
    };
    
    function salvarHorasMaquinas(){
        idHorasMaquinas = document.querySelector("#idHorasMaq").value;
        idMaquina = $('input[name=maquina]:checked').val();
        os = document.querySelector("#os").value;
        pn = document.querySelector("#pn").value;
        operacao = document.querySelector("#operacao").value;
        qtdPfabricar = document.querySelector("#qtdPfabricar").value;
        qtdEstoque = document.querySelector("#qtdEstoque").value;
        dataPrepIni = document.querySelector("#dataPrepIni").value;
        dataPrepFinal = document.querySelector("#dataPrepFinal").value;
        dataFabIni = document.querySelector("#dataFabIni").value;
        dataFabFinal = document.querySelector("#dataFabFinal").value;
        qtdFabricada = document.querySelector("#qtdFabricada").value;
        idMotivosParada = Array.apply(null,document.querySelectorAll("input[name=idMotivosParada_]"));
        dataParadaInicio = Array.apply(null,document.querySelectorAll("input[name=dataParadaInicio]"));
        dataParadaFim = Array.apply(null,document.querySelectorAll("input[name=dataParadaFim]"));
        idMotivosPerda = Array.apply(null,document.querySelectorAll("#idMotivosPerda_"));
        quantidadePerda = Array.apply(null,document.querySelectorAll("#quantidadePerda"));
        ArrayIdMotivosParada = [];
        ArrayDataParadaInicio = [];
        ArrayDataParadaFim = [];
        ArrayIdMotivosPerda = [];
        ArrayQuantidadePerda = [];
        for(x=0;x<idMotivosParada.length;x++){
            if(idMotivosParada[x].checked == true){
                ArrayIdMotivosParada.push(idMotivosParada[x].value);
                ArrayDataParadaInicio.push(dataParadaInicio[x].value);
                ArrayDataParadaFim.push(dataParadaFim[x].value);
            }
        }
        for(x=0;x<idMotivosPerda.length;x++){
            if(idMotivosPerda[x].checked == true){
                ArrayIdMotivosPerda.push(idMotivosPerda[x].value);
                ArrayQuantidadePerda.push(quantidadePerda[x].value);
            }
        }/**/
        console.log(ArrayIdMotivosParada);
        console.log(ArrayIdMotivosPerda);
        console.log(idHorasMaquinas);
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/producao/adicionarHoraMaquina",
            type: 'POST',
            dataType: 'json',
            data: {
                idHorasMaquinas:idHorasMaquinas,
                idMaquina:idMaquina,
                idOs:os,
                pn:pn,
                operacao:operacao,
                qtdPfabricar:qtdPfabricar,
                qtdEstoque:qtdEstoque,
                dataPrepIni:dataPrepIni,
                dataPrepFinal:dataPrepFinal,
                dataFabIni:dataFabIni,
                dataFabFinal:dataFabFinal,
                qtdFabricada:qtdFabricada,
                idMotivosParada:ArrayIdMotivosParada,
                dataParadaInicio:ArrayDataParadaInicio,
                dataParadaFim:ArrayDataParadaFim,
                idMotivosPerda:ArrayIdMotivosPerda,
                quantidadePerda:ArrayQuantidadePerda
            },
            success: function(data) {
                console.log(data.result);
                if(data.result == true){
                    window.location.href = data.redirect;
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
        })
        

    }

    function novaHora(){
        
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/producao/adicionarHoraMaquina",
            type: 'POST',
            dataType: 'json',
            data: {
            },
            success: function(data) {
                console.log(data.result);
                if(data.result == true){
                    window.location.href = data.redirect;
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
        })
        

    }
    
    <?php 
        foreach($motivos_parada as $r){
            echo '
            $("#buttonMParadaIniciar-'.$r->idMotivoParada.'").click(function(){
                $("#idMotivosParada-'.$r->idMotivoParada.'").prop("checked", true);
                $(".divButtonMParadaIniciar-'.$r->idMotivoParada.'").css("display", "none");
                $(".divInputMParadaIniciar-'.$r->idMotivoParada.'").css("display", "block");
                $("#dataParadaInicio-'.$r->idMotivoParada.'").val(new Date(Date.now()).toLocaleString("pt-BR"));
            })
            ';

            echo '
            $("#buttonMParadaFinal-'.$r->idMotivoParada.'").click(function(){
                if(document.querySelector("#dataParadaInicio-'.$r->idMotivoParada.'").value == ""){
                    alert("Não foi possivel finalizar o tempo dessa parada, pois o tempo não foi iniciado.");
                }else{
                    $(".divButtonMParadaFim-'.$r->idMotivoParada.'").css("display", "none");
                    $(".divInputMParadaFim-'.$r->idMotivoParada.'").css("display", "block");
                    $("#dataParadaFim-'.$r->idMotivoParada.'").val(new Date(Date.now()).toLocaleString("pt-BR"));
                }                
            })
            ';
        }
    ?>

    $("#buttonPrepIni").click(function() {
        if(document.querySelector("#os").value == ""
        || document.querySelector("#pn").value == ""
        || document.querySelector("#operacao").value == ""
        || document.querySelector("#qtdPfabricar").value == ""
        || typeof($('input[name=maquina]:checked').val()) == "undefined"){
            alert('Para iniciar os campos Máquinas, OS, PN, Operação e Quantidade p/ Fabricar não podem estar vazios.');
        }else{

            $(".divButtonPrepIni").css("display", "none");
            $(".divInputPrepIni").css("display", "block");
            $("#dataPrepIni").val(new Date(Date.now()).toLocaleString('pt-BR'));

        }
        //console.log(new Date(Date.now()).toLocaleString('pt-BR'));
    })

    $("#buttonPrepFinal").click(function() {
        if(document.querySelector("#dataPrepIni").value == ""){
            alert('Para finalizar a preparação primeiramente tem que iniciar a preparação.');
        }else{
            $(".divButtonPrepFinal").css("display", "none");
            $(".divInputPrepFinal").css("display", "block");
            $("#dataPrepFinal").val(new Date(Date.now()).toLocaleString('pt-BR'));
        }
    })

    $("#buttonFabIni").click(function() {
        if(document.querySelector("#os").value == ""
        || document.querySelector("#pn").value == ""
        || document.querySelector("#operacao").value == ""
        || document.querySelector("#qtdPfabricar").value == ""
        || typeof($('input[name=maquina]:checked').val()) == "undefined"){
            alert('Para iniciar os campos Máquinas, OS, PN, Operação e Quantidade p/ Fabricar não podem estar vazios.');
        }else{
            $(".divButtonFabIni").css("display", "none");
            $(".divInputFabIni").css("display", "block");
            $("#dataFabIni").val(new Date(Date.now()).toLocaleString('pt-BR'));
        }
    })

    $("#buttonFabFinal").click(function() {
        if(document.querySelector("#dataFabIni").value == ""){
            alert('Para finalizar a fabricação primeiramente tem que iniciar a fabricação.');
        }else{
            $(".divButtonFabFinal").css("display", "none");
            $(".divInputFabFinal").css("display", "block");
            $("#dataFabFinal").val(new Date(Date.now()).toLocaleString('pt-BR'));
        }
    })

    $(document).ready(function(){
      $(".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy', language: 'pt-BR', locale: 'pt-BR' });
    })

    $(document).ready(function(){
        $("#pn").autocomplete({
            source: "<?php echo base_url(); ?>index.php/producao/autoCompleteOnlyPN",
            minLength: 1,
            select: function( event, ui ) {
                $('#idProduto').val(ui.item.id);
            }
        });
        $("#os").autocomplete({
            source: "<?php echo base_url(); ?>index.php/producao/autoCompleteOnlyOS",
            minLength: 1,
            select: function( event, ui ) {
                //$('#idProduto').val(ui.item.id);
            }
        });
    })

    jQuery(function($){
        $.datepicker.regional['pt-BR'] = {
                closeText: 'Fechar',
                prevText: '&#x3c;Anterior',
                nextText: 'Pr&oacute;ximo&#x3e;',
                currentText: 'Hoje',
                monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                'Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
    });

</script>