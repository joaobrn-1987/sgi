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
                <h5>Filtro</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <form action="<?php echo base_url() ?>index.php/desenho/aguardandodesenho/1" method="post" name="form1" id="form1">
                                <div class="span12" id="divCadastrarOs">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                            <input type="text" class="span12" value=""  name="idOrcamento"/>
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Orçamento Item: </label>
                                            <input type="text" class="span12" value=""  name="idOrcamentoItem"/>
                                        </div>
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">O.S.: </label>
                                            <input type="text" class="span12" value=""  name="idOs"/>
                                        </div>
                                        <div class="span1" class="control-group">
                                            <label for="idGrupoServico" class="control-label">PN: </label>
                                            <input type="text" class="span12" value=""  name="pn"/>
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Descrição: </label>
                                            <input type="text" class="span12" value=""  name="descricaoOrc"/>
                                        </div>
                                        <div class="span3" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Status Desenho: </label>
                                            <select class="span12 form-control" name="statusDesenho">
                                                <option value=""></option>
                                                <option value="1">Aguardando Desenho</option>
                                                <option value="2">Incompleto</option>
                                                <option value="3">Finalizado</option>
                                            </select>
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
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Aguardando desenho</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divCadastrarOs">                                
                                <div class="widget-box" style="margin-top:0px">                                        
                                    <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Orçamento</th>
                                                <th>Cliente</th>
                                                <th></th>                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result as $r){	
                                                echo '<tr class="trpai'.$r->idOrcamentos.'">';
                                                    echo '<td onclick="openclose(this,'.$r->idOrcamentos.')" style="text-align: center;"><a class="detail-icon" ><i class="fa fa-plus"></i></a></td>';
                                                    echo '<td>'.$r->idOrcamentos.'</td>';
                                                    echo '<td>'.$r->nomeCliente.'</td>';
                                                    echo '<td><a href="' . base_url().'index.php/desenho/visualizardesenhos/'.$r->idOrcamentos . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a></td>';
                                                echo '</tr>';
                                                echo '<tr class="trfilho'.$r->idOrcamentos.'" style="display:none">';
                                                    echo '<td colspan=6 style="background-color: #efefef;padding-top: 0px;">';
                                                        echo '<div style="margin: 20px;margin-top: 0px;">';
                                                            echo '<table class="table table-bordered ">';
                                                                echo '<thead>';
                                                                    echo '<tr>';
                                                                        echo '<th>Orç. Item</th>';
                                                                        echo '<th>O.S.</th>';
                                                                        echo '<th>PN</th>';
                                                                        echo '<th>Descrição</th>';
                                                                        //echo '<th>Status</th>';
                                                                        echo '<th></th>';
                                                                    echo '</tr>';                                                                    
                                                                echo '</thead>';
                                                                echo '<tbody>';
                                                                if(isset($r->idOrcamento_item)){
                                                                    $tot = count(explode(";",$r->idOrcamento_item));
                                                                    $dist = explode(";",$r->idOrcamento_item);
                                                                    $dim = explode(";",$r->idOs);
                                                                    $qtd = explode(";",$r->pn);
                                                                    $dtCad = explode(";",$r->descricao_item);
                                                                    $ins = explode(";",$r->idOs);
                                                                    $nome = explode(";",$r->nomeVendedor);
                                                                    for($x=0;$x<$tot;$x++){
                                                                        $contador = 0;
                                                                        $contador = $contador+1;
                                                                        echo '<tr>';
                                                                            
                                                                            echo '<td>'.$dist[$x].'</td>';
                                                                            echo '<td>'.$dim[$x].'</td>';
                                                                            echo '<td>'.$qtd[$x].'</td>';
                                                                            echo '<td>'.$dtCad[$x].'</td>';/*
                                                                            echo '<td>R$ '.number_format($valor_unit[$x], 2, ",", ".").'</td>';
                                                                            echo '<td>R$ '.number_format($valor_unit[$x]*$qtd[$x], 2, ",", ".").'</td>';*/
                                                                            //echo '<td>'.$nome[$x].'</td>';
                                                                            echo '<td></td>';
                                                                        echo '</tr>';
                                                                    }
                                                                }
                                                                echo '</tbody>';
                                                            echo '</table>';
                                                        echo '</div>';
                                                    echo '</td>';
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
<script type="text/javascript">
    function openclose(td,valor){
        var tr = document.querySelector(".trfilho"+valor);
        
        if(tr.style.display == "table-row" || tr.style.display == ""){
            $(".trfilho"+valor).hide('fast');
            $(td).parent('tr').css('background-color', '');
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");            
        }else{
            $(".trfilho"+valor).show('fast');
            $(td).parent('tr').css('background-color', '#efefef');
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }       
    }
    $(document).ready(function () {
        $('#tableAguardandoDesenho').DataTable({
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