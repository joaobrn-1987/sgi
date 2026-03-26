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
    background-color: #51a351;
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
    background-color: #ccc;
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

    /*slider2 */

    .slider2 {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #0087ff;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider2:before {
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

    input:checked + .slider2 {
    background-color: #ccc;
    }

    input:focus + .slider2 {
    box-shadow: 0 0 1px #0087ff;
    }

    input:checked + .slider2:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
    }

    /* Rounded sliders */
    .slider2.round {
    border-radius: 34px;
    }

    .slider2.round:before {
    border-radius: 50%;
    }
</style>
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<?php 
    if($this->permission->checkPermission($this->session->userdata('permissao'), 'aProcessos')){?>
        <div class="row-fluid" style="margin-top:0">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Cadastrar Processos</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                <div class="tab-pane active">
                                    <form action="<?php echo base_url() ?>index.php/processos/cadastrar" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                        <div class="span12" id="divCadastrarOs">
                                            <div class="span12" style="padding: 1%; margin-left: 0">
                                                <div class="span4" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">Grupo: </label>
                                                    <select class="span12" name="idGrupo">
                                                        <option value=""> Selecione um grupo </option>
                                                        <?php 
                                                            foreach($grupos as $r){
                                                                echo '<option value="'.$r->idGrupoProcessos.'">'.$r->descricaoGrupoProcessos.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="span2" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">Versão: </label>
                                                    <input type="text" class="span12" value=""  name="versao"/>
                                                </div>
                                                <div class="span3" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">Nome: </label>
                                                    <input type="text" class="span12" value=""  name="descricaoArquivo"/>
                                                </div>
                                                <div class="span3" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">Arquivo: </label>
                                                    <input type="file" class="span12" value=""  name="arquivo"/>
                                                </div>
                                            </div>
                                            <div class="span12" style="padding: 1%; margin-left: 0">
                                                <div class="span2" class="control-group">
                                                    <button type="submit" class="btn btn-success"><i class="icon-white"></i>Cadastrar</button>
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
            <?php 
                if($this->permission->checkPermission($this->session->userdata('permissao'), 'aGruposProcessos')){?>
                    <div class="span6">
                        <div class="widget-box">
                            <div class="widget-title">
                                <span class="icon">
                                    <i class="icon-tags"></i>
                                </span>
                                <h5>Cadastrar Grupo</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                        <div class="tab-pane active">
                                            <form action="<?php echo base_url() ?>index.php/processos/cadastrarGrupo" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                                <div class="span12" id="divCadastrarOs">
                                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                                        <div class="span6" class="control-group">
                                                            <label for="idGrupoServico" class="control-label">Descrição: </label>
                                                            <input type="text" class="span12" value=""  name="descricao"/>
                                                        </div>
                                                    </div>
                                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                                        <div class="span2" class="control-group">
                                                            <button type="submit" class="btn btn-success"><i class="icon-white"></i>Cadastrar</button>
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
                    <?php
                }
            ?>
        </div>
        <?php
    }
?>

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
                            <form action="<?php echo base_url() ?>index.php/processos" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Grupo: </label>
                                            <select class="span12 form-control" name="grupo">
                                                <option value=""></option>
                                                <?php 
                                                    foreach($grupos as $r){
                                                        echo '<option value="'.$r->idGrupoProcessos.'">'.$r->descricaoGrupoProcessos.'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Descrição: </label>
                                            <input type="text" class="span12" value=""  name="descricao"/>
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <button type="submit" class="btn btn-success"><i class="icon-white"></i>Filtrar</button>
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
<div class="row-fluid" style="margin-top:0">
    <ul class="nav nav-tabs">
        <?php 
         $contador = 0;
         $marcador = null;
        foreach($result as $c){   
            if($contador == 0){         
                echo '<li class="active"><a href="#tab'.$c->idGrupoProcessos.'" data-toggle="tab">'.$c->descricaoGrupoProcessos.'</a></li>';
                $contador = 1;
                $marcador = $c->idGrupoProcessos;
            }else{
                echo '<li ><a href="#tab'.$c->idGrupoProcessos.'" data-toggle="tab">'.$c->descricaoGrupoProcessos.'</a></li>';
            }
        }
        if($result){
            echo '<li><a href="#tabtodos" data-toggle="tab">Todos</a></li>';
        }
        ?>
    </ul>
    <div class="tab-content">
    <?php 
        foreach($result as $c){ 
            if($marcador == $c->idGrupoProcessos){
                echo '<div class="tab-pane active" id="tab'.$c->idGrupoProcessos.'">';
            }else{
                echo '<div class="tab-pane" id="tab'.$c->idGrupoProcessos.'">';
            }
            ?>
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Anexos de Processos</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table id="tableHistVale" class="table table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <?php if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){?>
                                                            <th></th>
                                                            <?php } ?>
                                                            <th>Descrição</th>
                                                            <?php if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){?>
                                                            <th>Arquivo</th>
                                                            <?php } ?>
                                                            <th>Versão</th>
                                                            <th>Download</th>
                                                            <th>Data Cadastro</th>
                                                            <th>Usuário</th>
                                                            <?php if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){?>
                                                            <th>Editar</th>
                                                            <th>Excluir</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>    
                                                        <?php 
                                                            foreach($c->anexos as $d){
                                                                echo '<tr>';
                                                                    if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){
                                                                        echo '<td style="text-align: center; width:60px"><label class="switch"><input type="checkbox" '.(!$d->ativo?"checked":"").' name="checkAnexo"  value="'.$d->idAnexo.'"><span class="slider round"></span></label></td>';
                                                                    }
                                                                    echo '<td>'.$d->descricaoArquivo.'</td>';
                                                                    if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){
                                                                        echo '<td>'.$d->nomeArquivo.'</td>';
                                                                    }
                                                                    echo '<td>'.$d->versao.'</td>';
                                                                    echo '<td style="width: 60px;text-align: center;"><a class="tip-top" title="Baixar Desenho PN" style="text-align: center; color: green;" 
                                                                    onclick="aviso()" href="'.base_url().$d->caminho.$d->imagem.'" download>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                                        </svg>
                                                                    </a></td>';
                                                                    echo '<td>'.date("d/m/Y", strtotime($d->data_cadastro)).'</td>';
                                                                    echo '<td>'.$d->nome.'</td>';
                                                                    if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){
                                                                        echo '<td style="width: 60px;text-align: center;"><a onclick="editar('.$d->idAnexo.')" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a></td>';
                                                                        echo '<td style="width: 60px;text-align: center;"><a onclick="deletar('.$d->idAnexo.')" class="btn btn-danger tip-top"><i class="icon-remove icon-white"></i></a></td>';
                                                                    }
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
            <?php 
            echo '</div>';
        }
    ?> 
    <div class="tab-pane" id="tabtodos">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Anexos de Processos</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs">                                
                                    <div class="widget-box" style="margin-top:0px">                                        
                                        <table id="tableHistVale" class="table table-bordered ">
                                            <thead>
                                                <tr>
                                                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){?>
                                                    <th></th>
                                                    <?php } ?>
                                                    <th>Descrição</th>
                                                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){?>
                                                    <th>Arquivo</th>
                                                    <?php } ?>
                                                    <th>Versão</th>
                                                    <th>Grupo</th>
                                                    <th>Download</th>
                                                    <th>Data Cadastro</th>
                                                    <th>Usuário</th>
                                                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){?>
                                                    <th>Editar</th>
                                                    <th>Excluir</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>    
                                                <?php 
                                                    foreach($result as $c){
                                                        foreach($c->anexos as $d){
                                                            echo '<tr>';
                                                                if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){
                                                                    echo '<td style="text-align: center; width:60px"><label class="switch"><input type="checkbox" '.(!$d->ativo?"checked":"").' name="checkAnexo"  value="'.$d->idAnexo.'"><span class="slider round"></span></label></td>';
                                                                }
                                                                echo '<td>'.$d->descricaoArquivo.'</td>';
                                                                if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){
                                                                    echo '<td>'.$d->nomeArquivo.'</td>';
                                                                }
                                                                echo '<td>'.$d->versao.'</td>';
                                                                echo '<td>'.$d->descricaoGrupoProcessos.'</td>';
                                                                echo '<td style="width: 60px;text-align: center;"><a class="tip-top" title="Baixar Desenho PN" style="text-align: center; color: green;" 
                                                                    onclick="aviso()" href="'.base_url().$d->caminho.$d->imagem.'" download>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                                    </svg>
                                                                </a></td>';
                                                                echo '<td>'.date("d/m/Y", strtotime($d->data_cadastro)).'</td>';
                                                                echo '<td>'.$d->nome.'</td>';
                                                                if($this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){
                                                                    echo '<td style="width: 60px;text-align: center;"><a onclick="editar('.$d->idAnexo.')" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a></td>';
                                                                    echo '<td style="width: 60px;text-align: center;"><a onclick="deletar('.$d->idAnexo.')" class="btn btn-danger tip-top"><i class="icon-remove icon-white"></i></a></td>';
                                                                }
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
</div>
<div id="modalEditar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/processos/editar" method="post" id="formEditar">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Editar Anexo</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span3">
                    <label>Descrição</label>
                    <input type="text" class="span12" name="descricao" id="descricao">
                    <input type="hidden" name="idAnexo" id="idAnexo">
                </div>
                <div class="span3">
                    <label>Arquivo</label>
                    <input type="text" class="span12" readonly name="arquivo" id="arquivo">
                </div>
                <div class="span3">
                    <label>Versão</label>
                    <input type="text" class="span12" readonly name="versao" id="versao">
                </div>
                <div class="span3">
                    <label for="idGrupoServico" class="control-label">Grupo: </label>
                    <select class="span12 form-control" name="grupo" id="grupo">
                        <?php 
                            foreach($grupos as $r){
                                echo '<option value="'.$r->idGrupoProcessos.'">'.$r->descricaoGrupoProcessos.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>
<div id="modalDeletar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/processos/delete" method="post" id="formDelete">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Deletar Anexo</h5>
        </div>
        <div class="modal-body">
            <div class="span12">
                <div class="span3">
                    <label>Descrição</label>
                    <input type="text" class="span12" name="descricao" id="descricao">
                    <input type="hidden" name="idAnexo" id="idAnexo">
                </div>
                <div class="span3">
                    <label>Arquivo</label>
                    <input type="text" class="span12" readonly name="arquivo" id="arquivo">
                </div>
                <div class="span3">
                    <label>Versão</label>
                    <input type="text" class="span12" readonly name="versao" id="versao">
                </div>
                <div class="span3">
                    <label for="idGrupoServico" class="control-label">Grupo: </label>
                    <select class="span12 form-control" name="grupo" id="grupo">
                        <?php 
                            foreach($grupos as $r){
                                echo '<option value="'.$r->idGrupoProcessos.'">'.$r->descricaoGrupoProcessos.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $("input:checkbox[name=checkAnexo]").click(function(){
        console.log(this.checked);
        console.log(this.value)
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/processos/onoffanexos",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                ativo:this.checked,
                idAnexo:this.value
            },
            success: function(data) {
                if(this.checked){
                    //alert("Visualização ativado com sucesso");            
                }else{
                    //alert("Visualização desativado com sucesso");
                }
            },
            error: function(xhr, textStatus, error) {
                alert("Houve um erro na alteração do item"); 
                if(this.checked){
                    this.checked = false;
                }else{
                    this.checked = true;
                }
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })
        
    })
    function editar(idAnexo){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/processos/getAnexo",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idAnexo:idAnexo
            },
            success: function(data) {
                if(data.obj){
                    $("#formEditar #descricao")[0].value = data.obj.descricaoArquivo;
                    $("#formEditar #idAnexo")[0].value = data.obj.idAnexo;
                    $("#formEditar #arquivo")[0].value = data.obj.nomeArquivo;
                    $("#formEditar #versao")[0].value = data.obj.versao;
                    $("#formEditar #grupo")[0].value = data.obj.idGrupoProcessos;
                    $("#modalEditar").modal("show");
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
    function deletar(idAnexo){
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/processos/getAnexo",
            type: 'POST',
            dataType: 'json',
            async:false,
            data: {
                idAnexo:idAnexo
            },
            success: function(data) {
                if(data.obj){
                    $("#formDelete #descricao")[0].value = data.obj.descricaoArquivo;
                    $("#formDelete #idAnexo")[0].value = data.obj.idAnexo;
                    $("#formDelete #versao")[0].value = data.obj.versao;
                    $("#formDelete #arquivo")[0].value = data.obj.nomeArquivo;
                    $("#formDelete #grupo")[0].value = data.obj.idGrupoProcessos;
                    $("#modalDeletar").modal("show");
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
    function aviso(){
        alert("Lembre-se de verificar se a versão do arquivo utilizado é a versão mais recente.");
    }
</script>