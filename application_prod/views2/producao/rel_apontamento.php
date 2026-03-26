<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/moment.js"></script>
<script src="<?php echo base_url()?>js/jquery.inputmask.bundle.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Relatório Apontamento</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <form class="form-inline" action="<?php echo base_url() ?>index.php/producao/rel_apontamento" method="post" name="form1" id="form1">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="span12">
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Data Inicio: </label>
                                            <div>
                                                <input id="dataInicio"  type="text" name="dataInicio" class="span12 data" value="" size='50' />
                                            </div>
                                        </div>
                                        <div class="span2" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Data Fim: </label>
                                            <div>
                                                <input id="dataFim"  type="text" name="dataFim" class="span12 data" value="" size='50' />
                                            </div>
                                        </div>
                                        <div class="span2" class="control-group">
                                            </br>
                                            <button type="submit" name="btnAbrirPedidos" value = "btnAbrirPedidos" class="btn btn-success"><i class="icon-plus icon-white"></i> Filtrar</button>
                                    
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
<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>Relatório</h5>

    </div>
    <div class="widget-content nopadding">
        <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
            <thead>
                <tr>
                    <th>
                        PN
                    </th>
                    <th>
                        Máquinas
                    </th>
                    <th>
                        HR/Média Fab.
                    </th>
                    <th>
                        Quantidade Fabricado
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($relatorio1 as $r){
                    echo '<tr>';
                        echo '<td>';
                            echo $r['pn'];
                        echo '</td>';
                        echo '<td>';
                            echo $r['maquina'];
                        echo '</td>';
                        echo '<td>';
                            echo number_format((float)$r['tempoFabricacao']/$r['quantidadeFabricado'],3,',','.');
                        echo '</td>';
                        echo '<td>';
                            echo $r['quantidadeFabricado'];
                        echo '</td>';
                    echo '</tr>';
                }
                 ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $('.data').inputmask("date",{
        inputFormat: "dd/mm/yyyy"
    }); 
</script>
