<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>

<?php 
    $this->load->view('almoxarifado/gerencia/menugerencia');
?>
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Vale</a></li>
    <li><a href="#tab2" data-toggle="tab">Histórico</a></li>
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
                        <h5>Vale</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <form action="<?php echo base_url() ?>index.php/almoxarifado/menuvale" method="post">
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
                                                        <option value="">todos</option>
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
                                                        <option value="">todos</option>
                                                        <?php foreach ($dados_emitente as $r) {
                                                        ?>
                                                            <option value="<?php echo $r->id ?>">
                                                                <?php echo $r->nome ?> </option>
                                                        <?php
                                                        } ?>

                                                    </select>
                                                </div>
                                                <div class="span2" class="control-group">
                                                    <button type="submit" style="background-color: #f9f9f9; border: 0px;"><i class="icon-search" style="font-size:30px; float: right;  "></i></button>
                                                </div>
                                            </div>
                                            <!--
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
                                            </div> -->
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
                        <h5>Matéria-Prima</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="span12" id="divCadastrarOs">
                                        <div class="widget-box" style="margin-top:0px">
                                            <table id="tableMateriaPrima" class="table table-bordered ">
                                                <thead>
                                                    <tr>
                                                        <th>OS</th>
                                                        <th>Status O.S.</th>
                                                        <th>Descrição</th>
                                                        <th>Quantidade</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($itens as $r) {
                                                        echo '<tr>';
                                                            echo '<td>' . $r->idOs . '</td>';
                                                            echo '<td>' . $r->nomeStatusOs . '</td>';
                                                            echo '<td>' . $r->descricaoInsumo . '</td>';
                                                            echo '<td>' . $r->quantidade . '</td>';
                                                            if($this->permission->checkPermission($this->session->userdata('permissao'),'eVale')){
                                                                echo '<td><a id="vale" quantidade="' . $r->quantidade . '" idEstoque="' . $r->idAlmoEstoque . '" idOs = "'.$r->idOs.'" nomeStatus = "'.$r->nomeStatusOs.'" descricaoInsumo = "'.$r->descricaoInsumo.'"  href="#modal-vale" style="margin-right: 1%" role="button" data-toggle="modal" class="btn btn-info tip-top"><i class="icon-pencil icon-white"></i></a></td>';
                                                            }else{
                                                                echo '<td></td>';
                                                            }
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
                        <h5>Histórico Vale</h5>
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
                                                        <th>Data</th>
                                                        <th>O.S. Origem</th>
                                                        <th>O.S. Destino</th>
                                                        <th>Item</th>                                                
                                                        <th>Qtd</th> 
                                                        <th>Usuário</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($historico as $r){
                                                        if(!empty($r->data_insert)){ 
                                                            $date = new DateTime( $r->data_insert);
                                                            //echo $date-> format( 'Y-m-d H:i:s' );
                                                        }
                                                        echo '<tr>';
                                                            echo '<td><span style="display:none">'.$r->data_insert.'</span>'.$date->format( 'd/m/Y' ).'</td>';
                                                            echo '<td>'.$r->idOsOrig.'</td>';
                                                            echo '<td>'.$r->idOsDest.'</td>';
                                                            echo '<td>'.$r->descricaoInsumo.'</td>';                                            
                                                            echo '<td>'.$r->quantidade.'</td>';
                                                            echo '<td>'.$r->nome.'</td>';
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
        </div>
    </div>
</div>
<div id="modal-vale" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/almoxarifado/vale" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>               
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">Deseja fazer vale desse item?</h5>
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>OS</th>
                        <th>Status O.S.</th>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" value="" class="span12" id="idOs2" name="idOs2" readonly><input type="hidden" value="" class="span12" id="idEstoque2" name="idEstoque2"></td>
                        <td><input type="text" value="" class="span12" id="nomeStatus2" name="nomeStatus2" readonly></td>
                        <td><input type="text" value="" class="span12" id="descricaoInsumo2" name="descricaoInsumo2" title="" readonly></td>
                        <td><input type="text" value="" class="span12" id="quantidade2" name="quantidade2" readonly></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <h5 style="text-align: center"> Destino </h5>
                <div class="span12" style=" margin-left: 0">
                    <div class="span4">
                        <label for="idGrupoServico" class="control-label">O.S.: </label>
                        <input type="text" class="span12" value="" id="idOs3" name="idOs3"/>               
                    </div>
                    <div class="span4">
                        <label for="idGrupoServico" class="control-label">Quantidade: </label>
                        <input type="text" class="span12" value="" id="quantidade3" name="quantidade3"/>
                    </div>
                    <div class="span4">
                        <label for="idGrupoServico" class="control-label">Motivo: </label>
                        <select class="span12" name="motivoVale">  
                            <option value="">Selecione um motivo</option>
                            <?php foreach($motivos as $r){
                                echo '<option value="'.$r->idMotivoVale.'">'.$r->descricaoMotivoVale.'</option>';
                            }?>
                        </select>             
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
<script>
    $(document).ready(function() {


        $(document).on('click', 'a', function(event) {
            var quantidade = $(this).attr('quantidade');
            $('#quantidade2').val(quantidade);
            var idEstoque = $(this).attr('idEstoque');
            $('#idEstoque2').val(idEstoque);
            var idOs = $(this).attr('idOs');
            $('#idOs2').val(idOs);
            var nomeStatus = $(this).attr('nomeStatus');
            $('#nomeStatus2').val(nomeStatus);
            var descricaoInsumo = $(this).attr('descricaoInsumo');
            $('#descricaoInsumo2').val(descricaoInsumo);

            $('#descricaoInsumo2').attr('title', descricaoInsumo);
        });
    });

    $(document).ready(function () {
        $('#tableMateriaPrima').DataTable({
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
        $('#tableHistVale').DataTable({
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