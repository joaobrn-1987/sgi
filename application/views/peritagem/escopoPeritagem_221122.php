<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Dados do Produto</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                        <input type="text" class="span12"  value="<?php echo $orcamentoItem->idOrcamentos;?>" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Cliente: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->nomeCliente;?>" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Solicitante: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->nome;?>" readonly />
                                    </div>
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->pn;?>" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Descrição Produto: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->descricao;?>" readonly />
                                    </div>
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Ref.: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->referencia;?>" readonly />
                                    </div>
                                    <div class="span3" class="control-group">
                                        <label for="idGrupoServico" class="control-label">TAG: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->tag;?>" readonly />
                                    </div>
                                </div>                                    
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <a href="#modal-anexodesenho" style="margin-right: 1%" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-plus icon-white"></i>Anexos Desenho</a>
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
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <form class="form-inline" action="<?php echo base_url() ?>index.php/peritagem/salvaravaliacao" method="post" id="formPeritag">
            <input type="hidden" name="idOrcServicoEscopo" id="idOrcServicoEscopo" value="<?php echo $idOrcServEscopo ?>"  />
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-tags"></i>
                    </span>
                    <h5>Escopo Técnico</h5><!--
                    <span style="padding: 7px 10px 7px 11px;">                    
                        Status 
                        <select name="statusPeritagem" id="statusPeritagem">       
                            <option>test1</option>
                            <option>test1</option>
                            <option>test1</option>
                        </select>           
                    </span> -->
                </div>
                <div class="widget-content nopadding">
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="span12" id="divCadastrarOs">
                                    <div class="widget-box" style="margin-top:0px">
                                        <table id="tablePeritagem" class="table table-bordered" >
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="padding: 3px;">PN</th>
                                                    <th rowspan="2" style="padding: 3px;">Descrição</th>
                                                    <th rowspan="2" style="padding: 3px;">Classe</th>
                                                    <th class="classPerit" rowspan="2" style="padding: 3px;">Qtd.</th> 
                                                    <th class="classPerit" colspan='3' style="border-bottom: 1px solid #ddd;padding: 3px;">Dimensões</th>   
                                                    <th class="classPerit" rowspan="2" style="padding: 3px;">OBS.</th>
                                                </tr>
                                                <tr>
                                                    <th class="classPerit" style="padding: 3px;">Ø EXT.</th>
                                                    <th class="classPerit" style="padding: 3px;">Ø INT.</th>
                                                    <th class="classPerit" style="padding: 3px;">COMP.</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if(isset($escopoItens)){
                                                        $count = 0;
                                                        foreach($escopoItens as $r){
                                                            echo '<tr>';
                                                                echo '<td>'.$r->pn.'</td>';
                                                                echo '<td>'.$r->descricaoServicoItens.'<input type="hidden" name="idOrcServicoEscopoItens[]" id="idOrcServicoEscopoItens" value="'.$r->idOrcServicoEscopoItens.'"/></td>';
                                                                echo '<td>'.$r->descricaoClasse.'</td>';
                                                                if( $escopo->idStatusEscopo == 4){
                                                                    echo '<td style="width:7%"><input type="text" class = "span12" id="quantidade_'.$count.'" name="quantidade[]" readonly value="'.$r->quantidade.'"/ ></td>';
                                                                    echo '<td style="width:7%"><input type="text" class = "span12" id="dimenExt_'.$count.'" name="dimenExt[]" readonly value="'.$r->dimenExt.'"/></td>';
                                                                    echo '<td style="width:7%"><input type="text" class = "span12" id="dimenInt_'.$count.'" name="dimenInt[]" readonly value="'.$r->dimenInt.'"/></td>';
                                                                    echo '<td style="width:7%"><input type="text" class = "span12" id="dimenComp_'.$count.'" name="dimenComp[]" readonly value="'.$r->dimenComp.'"/></td>';
                                                                    echo '<td style="width:7%"><input type="text" class = "span12" id="obs_'.$count.'" name="obs[]" readonly value="'.$r->obs.'"/></td>';
                                                                }else{
                                                                    echo '<td style="width:7%"><input type="text" class = "span12" id="quantidade_'.$count.'" name="quantidade[]" value="'.$r->quantidade.'"/ ></td>';
                                                                    echo '<td style="width:7%"><input type="text" class = "span12" id="dimenExt_'.$count.'" name="dimenExt[]" value="'.$r->dimenExt.'"/></td>';
                                                                    echo '<td style="width:7%"><input type="text" class = "span12" id="dimenInt_'.$count.'" name="dimenInt[]" value="'.$r->dimenInt.'"/></td>';
                                                                    echo '<td style="width:7%"><input type="text" class = "span12" id="dimenComp_'.$count.'" name="dimenComp[]" value="'.$r->dimenComp.'"/></td>';
                                                                    echo '<td style="width:7%"><input type="text" class = "span12" id="obs_'.$count.'" name="obs[]" value="'.$r->obs.'"/></td>';

                                                                }                                                                 
                                                            echo '</tr>';
                                                            $count ++;
                                                        }
                                                    }
                                                ?>                                                                                      
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="text-align: center;"><!--
                                        <a class="btn btn-warning" onclick="adicionarItemTabela()">Novo Item</a>-->
                                        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aPeritagem') && $escopo->idStatusEscopo != 4){ ?>
                                            <a class="btn btn-success" onclick="salvarItens()">Salvar</a>
                                        <?php } ?>
                                        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPeritagem') && $escopo->idStatusEscopo != 4){ ?>
                                            <a class="btn btn-success" onclick="modelConfirmarFinalizacao()">Finalizar a Peritagem</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>    
</div>
<div id="modal-anexodesenho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/desenho/reprovardesenho" method="post" enctype="multipart/form-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Anexo desenho</h5>
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
                                                            <th>Proprietário</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            foreach($anexoDesenho as $r){
                                                                if($r->statusAnexo == 2){
                                                                    echo '<tr>';
                                                                        echo '<td><a href="'. base_url() .  $r->caminho . $r->imagem .'" id="aAprovar2" target="_blank">'. $r->nomeArquivo . $r->extensao .'</a></td>';
                                                                        echo '<td>'.$r->nome.'</td>';
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
        </div><!--
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-success">Adicionar</button>
        </div> -->
    </form>
</div>
<div id="modelFinalizar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/peritagem/finalizarPeritagem/<?php echo $idOrcServEscopo ?>"  enctype="multipart/form-data" method="post" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Confirmar fim da Peritagem</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idFotoLaudo" name="idFotoLaudo" value="" />
            <h5 style="text-align: center">Deseja realmente finalizar está peritagem?</h5>
            <p style="text-align: center">(Certifique-se de que as alterações da peritagem foram salvas.)</p>
            <p style="text-align: center">(Após a confirmação não será possivel alterar as informações dessa peritagem sem a autorização do comercial.)</p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    function salvarItens(){
        $("#formPeritag").submit();
    }
    function modelConfirmarFinalizacao(){
        $('#modelFinalizar').modal('show');
    }
    $(document).ready( function () {
        $('#tablePeritagem').DataTable({
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
        
    });
</script>