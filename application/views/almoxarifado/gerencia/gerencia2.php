<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<?php 
    //$this->load->view('almoxarifado/gerencia/menugerencia');
?>
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Incluir</a></li>
    <li><a href="#tab2" data-toggle="tab">Histórico</a></li>
    <li><a href="#tab3" data-toggle="tab">Peças Mortas</a></li>
    <li><a href="#tab4" data-toggle="tab">Destino</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab1">

        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Peças Mortas</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <form action="<?php echo base_url() ?>index.php/almoxarifado/gerencia2" method="post">
                                <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                    <div class="tab-pane active">
                                        <div class="span12" id="divCadastrarOs">
                                            <div class="span12" style="padding: 1%; margin-left: 0">
                                                <div class="span1" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">O.S.: </label>
                                                    <input type="text" class="span12" value="" id="os" name="os"/>
                                                </div>
                                                <div class="span3" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">Descrição: </label>
                                                    <input type="text" class="span12" value="" id="desc" name="desc"/>
                                                </div>
                                                <div class="span3" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">Departamento: </label>
                                                    <select class="span12 form-control" name="idDepartamento" id="idDepartamento" >
                                                        <option value="">Todos</option>
                                                        <?php foreach ($dados_departamento as $r) {
                                                        ?>
                                                            <option value="<?php echo $r->idAlmoEstoqueDep ?>">
                                                                <?php echo $r->descricaoDepartamento ?> </option>
                                                        <?php
                                                        } ?>

                                                    </select>
                                                </div>
                                                <div class="span3" class="control-group">
                                                    <label for="idGrupoServico" class="control-label">Empresa: </label>
                                                    <select class="span12 form-control" name="idEmpresa" id="idEmpresa" >
                                                        <option value="">Todos</option>
                                                        <?php foreach ($dados_emitente as $r) {
                                                        ?>
                                                            <option value="<?php echo $r->id ?>">
                                                                <?php echo $r->nome ?> </option>
                                                        <?php
                                                        } ?>

                                                    </select>
                                                </div>
                                                <div class="span2" class="control-group">
                                                    <button type="submit" style="background-color: #f9f9f9; border: 0px;"><i class="icon-search" style="font-size:30px; float: right;"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                        <h5>Saídas</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <form >
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table id="tableSaidasEstoque" class="table table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th>Data Saída</th>
                                                            <th>O.S.</th>
                                                            <th>Insumo</th>
                                                            <th>Quantidade</th>                                                
                                                            <th>Usuário</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($itens as $r){
                                                            if(!empty($r->data_saida)){ 
                                                                $date = new DateTime( $r->data_saida);
                                                                //echo $date-> format( 'Y-m-d H:i:s' );
                                                            }
                                                            echo '<tr>';
                                                                echo '<td><span style="display:none">'.$r->data_saida.'</span>'.$date->format( 'd/m/Y' ).'</td>';
                                                                echo '<td>'.$r->idOs.'</td>';
                                                                echo '<td>'.$r->descricaoInsumo.'</td>';
                                                                echo '<td>'.$r->quantidade.'</td>';                                          
                                                                echo '<td>'.$r->getUsernome.'</td>';
                                                                if($this->permission->checkPermission($this->session->userdata('permissao'),'ePecamorta')){
                                                                    echo '<td><a id="pecamorta" quantidade="' . $r->quantidade . '" idSaida="' . $r->idAlmoEstoqueSaida . '" dataSaida="'.$r->data_saida.'" idOs="'.$r->idOs.'" descricaoInsumo="'.$r->descricaoInsumo.'" nomeUser = "'.$r->getUsernome.'" href="#modal-pecamorta" style="margin-right: 1%" role="button" data-toggle="modal" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a></td>';
                                                                }else{
                                                                    echo '<td></td>';
                                                                }
                                                            echo '</tr>';
                                                        }?>
                                                    </tbody>
                                                </table>
                                            </div>                                
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
    <div class="tab-pane" id="tab2"><!--
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Orçamento</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                                <div class="tab-pane active">
                                    <div class="span12" id="divCadastrarOs">
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                            <div class="span5" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Cliente: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                            <div class="span5" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Solicitante: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                        </div>
                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">PN: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                            <div class="span5" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Descrição Produto: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Ref.: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                            <div class="span3" class="control-group">
                                                <label for="idGrupoServico" class="control-label">TAG: </label>
                                                <input type="text" class="span12" value="" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Histórico Peças Mortas</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">                                
                                        <div class="widget-box" style="margin-top:0px">                                        
                                            <table id="tableHistPecasMortas" class="table table-bordered ">
                                                <thead>
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>Item</th>
                                                        <th>Motivo</th>
                                                        <th>Quantidade</th>
                                                        <th>Valor Unitário</th>
                                                        <th>Valor Total</th>
                                                        <th>Usuário</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($historico as $r){
                                                            if(!empty($r->data_cadastro)){ 
                                                                $date = new DateTime( $r->data_cadastro);
                                                                //echo $date-> format( 'Y-m-d H:i:s' );
                                                            }
                                                            echo '<tr>';
                                                                echo '<td>'.$date-> format( 'd/m/Y' ).'</td>';
                                                                echo '<td>'.$r->descricaoInsumo.'</td>';
                                                                echo '<td>'.$r->descricaoMotivosPerda.'</td>';
                                                                echo '<td>'.$r->quantidade.'</td>';
                                                                echo '<td>R$ '. number_format($r->valorUnitario, 2, ",", ".").'</td>';                                                                
                                                                echo '<td>R$ '. number_format($r->valorUnitario*$r->quantidade, 2, ",", ".").'</td>';
                                                                echo '<td>'.$r->nome.'</td>';  
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
    </div>
    <div class="tab-pane" id="tab3">
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Peças Mortas - Estoque</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">                                
                                        <div class="widget-box" style="margin-top:0px">                                        
                                            <table id="tablePecasMortas" class="table table-bordered " >
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>O.S.</th>
                                                        <th>Descrição</th>
                                                        <th>Motivo</th>
                                                        <th>Quantidade</th>
                                                        <th>Valor Unitário</th>
                                                        <th>Valor Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        foreach($estoqueMorte as $r){
                                                            echo '<tr>';                                             
                                                            echo '<td style="text-align: center;width: 20px;"><input type="checkbox" name="idPecasMortasEstoque[]" id="idPecasMortasEstoque" value="'.$r->idPecasMortasEstoque.'"></td>';
                                                            echo '<td>'.$r->idOs.'</td>';
                                                            echo '<td>'.$r->descricaoInsumo.'</td>';
                                                            echo '<td>'.$r->descricaoMotivosPerda.'</td>';
                                                            echo '<td>'.$r->quantidade.'</td>'; 
                                                            echo '<td>R$ '. number_format($r->valorUnitario, 2, ",", ".").'</td>';                                                                
                                                            echo '<td>R$ '. number_format($r->valorUnitario*$r->quantidade, 2, ",", ".").'</td>';
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
        
        <div align='center'> 
            <a href="#modal-saida" role="button" data-toggle="modal" name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success" onclick="getInfoPecaMorta()"><i class="icon-plus icon-white"></i> Saída</a>
        </div>
    </div>
    <div class="tab-pane" id="tab4">
        <div class="row-fluid" style="margin-top:0">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-tags"></i>
                        </span>
                        <h5>Destino das peças</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">                                
                                        <div class="widget-box" style="margin-top:0px">                                        
                                            <table id="tableDestinoPecas" class="table table-bordered " >
                                                <thead>
                                                    <tr>
                                                        <th>Descrição</th>
                                                        <th>Quantidade</th>  
                                                        <th>Destino</th>                                               
                                                        <th>Data</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($destinoPecasHist as $r){
                                                        if(!empty($r->data_insert)){ 
                                                            $date = new DateTime( $r->data_insert);
                                                            //echo $date-> format( 'Y-m-d H:i:s' );
                                                        }
                                                        echo '<tr>';
                                                            echo '<td>'.$r->descricaoInsumo.'</td>';
                                                            echo '<td>'.$r->quantidade.'</td>';
                                                            echo '<td>'.$r->descricaoDestinoPecasMortas.'</td>';
                                                            echo '<td> <span style="display:none">'.$r->data_insert.'</span>'.$date-> format( 'd/m/Y' ).'</td>';  
                                                        echo '</tr>';
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
    </div>
</div>

<div id="modal-saida" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"   aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/almoxarifado/saidapecamorta" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>               
        </div>
        <div class="modal-body" id="divSaidaModal">
            <div class="span12">
                <div class="span6">
                    <label for="idGrupoServico" class="control-label">Destino: </label><!--
                    <input type="text" class="span12" value="" id="os" name="os"/>-->
                    <select class="span12 form-control" name="idDestino"
                        id="idDestino">
                        <?php foreach($destinoPecas as $r){
                            echo '<option value="'.$r->idDestinoPecasMortas.'">'.$r->descricaoDestinoPecasMortas.'</option>';
                        } ?>
                        
                    </select>
                </div>
                <div class="span6">
                    <label for="idGrupoServico" class="control-label">O.S.: </label>
                    <input name="idOs" type="text" class="span12">
                </div>
                

            </div>
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box"><!--
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Escopo Técnico</h5>
                        </div> -->
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="span12" id="divCadastrarOs">                                
                                            <div class="widget-box" style="margin-top:0px">                                        
                                                <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                                    <thead>
                                                        <tr>
                                                            <th>O.S.</th>
                                                            <th>Descrição</th>
                                                            <th>Motivo</th>
                                                            <th>Quantidade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyid">
                                                                                                                                              
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
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>

<div id="modal-pecamorta" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/almoxarifado/pecamorta" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>               
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">Essa é a saída referente a peça morta?</h5>
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Data Saída</th>
                        <th>O.S.</th>
                        <th>Insumo</th>
                        <th>Quantidade</th>
                        <th>Usuário</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" value="" class="span12" id="dataSaida2" name="dataSaida2" readonly></td>
                        <td><input type="text" value="" class="span12" id="idOs2" name="idOs2" readonly><input type="hidden" value="" class="span12" id="idSaida2" name="idSaida2"></td>
                        <td><input type="text" value="" class="span12" id="descricaoInsumo2" name="descricaoInsumo2" title="" readonly></td>
                        <td><input type="text" value="" class="span12" id="quantidade2" name="quantidade2" readonly></td>
                        <td><input type="text" value="" class="span12" id="nomeUser2" name="nomeUser2" readonly></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <h5 style="text-align: center">Peças Mortas</h5>
                <div class="span12" style=" margin-left: 0">
                    <div class="span2">
                        <label for="idGrupoServico" class="control-label">Quantidade: </label>
                        <input type="text" class="span12" value="" id="quantidade3" name="quantidade3"/>
                    </div> 
                    <div class="span5" class="control-group">
                        <label for="idEmpresa" class="control-label">Motivo:</label>
                        <select class="span12 form-control" name="idMotivo"
                            id="idMotivo">
                            <?php 
                                foreach($motivosPerda as $r){
                                    ?>
                                    <option value="<?php echo $r->idMotivosPerda; ?>">
                                    <?php echo $r->descricaoMotivosPerda;?>
                                    </option> 
                                    <?php
                                }
                            ?>
                            
                        </select>
                    </div>
                    <div class="span5" class="control-group">
                        <label for="idEmpresa" class="control-label">Empresa:</label>
                        <select class="span12 form-control" name="idEmpresa"
                            id="idEmpresa" onchange="alterarLocal2(this.value)">
                            <?php foreach($dados_emitente as $r){
                            ?>
                            <option value="<?php echo $r->id ?>">
                                <?php echo $r->nome ?> </option>
                            <?php
                            }?>

                        </select>
                    </div>
                    <!--
                    <div class="span4">
                        <label for="idGrupoServico" class="control-label">Motivo: </label>
                    </div>-->

                </div>
                <div class="span12" style=" margin-left: 0">
                    <label for="idEmpresa" class="control-label">Obs.:</label>
                        <textarea style="max-width: 98%;min-width: 50%;max-height: 150px;" name="obs"></textarea>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {

            var quantidade = $(this).attr('quantidade');
            $('#quantidade2').val(quantidade);

            var quantidade = $(this).attr('quantidade');
            $('#quantidade3').val(quantidade);

            var idSaida = $(this).attr('idSaida');
            $('#idSaida2').val(idSaida);

            var idOs = $(this).attr('idOs');
            $('#idOs2').val(idOs);

            var dataSaida = $(this).attr('dataSaida');
            $('#dataSaida2').val(dataSaida);

            var descricaoInsumo = $(this).attr('descricaoInsumo');
            $('#descricaoInsumo2').val(descricaoInsumo);

            var nomeUser = $(this).attr('nomeUser');
            $('#nomeUser2').val(nomeUser);

            $('#descricaoInsumo2').attr('title', descricaoInsumo);
        }); 
    });
    function getInfoPecaMorta(){
        var pecasMortas = Array.apply(null,document.querySelectorAll('#idPecasMortasEstoque'));
        $('#tbodyid').empty();
        for(var x=0;x<pecasMortas.length;x++){
            if(pecasMortas[x].checked){
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/almoxarifado/getInfoPecaMorta",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        idPecasMortasEstoque: pecasMortas[x].value
                    },
                    success: function(data2) {
                        preencherModal(data2.resposta);
                        //divSaidaModal
                    },
                    error: function(xhr, textStatus, error) {
                        console.log(xhr.responseText);
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(error);
                        a.disabled = false;
                    },
                })
            }            
        }        
    }
    function preencherModal(row){
        console.log(row);
        html = '<tr>';
            html += '<td>';
                html += row.idOs+'<input type="hidden" name="idPecasMortas[]" value="'+row.idPecasMortasEstoque+'"></input>';
            html += '</td>';
            html += '<td>';
                html += row.descricaoInsumo;
            html += '</td>';
            html += '<td>';
                html += row.descricaoMotivosPerda;
            html += '</td>';
            html += '<td>';
                html += row.quantidade;
            html += '</td>';
        html += '<tr>';
        $( "#tbodyid" ).append( html );
    }
    $(document).ready(function () {
        $('#tableSaidasEstoque').DataTable({
            'order':[[0, 'desc']],
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
        
    } );
    $(document).ready(function () {
        $('#tableHistPecasMortas').DataTable({
            'order':[[0, 'desc']],
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
        
    } );
    $(document).ready(function () {
        $('#tablePecasMortas').DataTable({
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
        
    } );
    $(document).ready(function () {
        $('#tableDestinoPecas').DataTable({
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
        
    } );
</script>