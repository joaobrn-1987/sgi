<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Insumo</a></li>
            <!--<li><a data-toggle="tab" href="#tab2">Ordens de Serviço</a></li>-->
            <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eInsumo')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/insumos/editar/'.$result->idInsumos.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } ?>
                    
            </div>
        </ul>
    </div>
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">

            <div class="accordion" id="collapse-group">
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                            <span class="icon"><i class="icon-list"></i></span><h5>Dados Insumos</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGOne">
                                    <div class="widget-content">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: right; width: 30%"><strong>Categoria/Subcategoria</strong></td>
                                                    <td><?php echo $result->idCategoria ?>/<?php echo $result->idSubcategoria ?></td>
                                                </tr>
                                               
                                                <tr>
                                                    <td style="text-align: right"><strong>Descrição</strong></td>
                                                    <td><?php echo $result->descricaoInsumo; ?></td>
                                                </tr>
												<tr>
                                                    <td style="text-align: right"><strong>Estoque min.</strong></td>
                                                    <td><?php echo $result->estoqueminimo; ?></td>
                                                </tr>
												<tr>
                                                    <td style="text-align: right"><strong>Pn Insumo</strong></td>
                                                    <td><?php echo $result->pn_insumo; ?></td>
                                                </tr>
												<tr>
                                                    <td style="text-align: right"><strong>Localização</strong></td>
                                                    <td><?php echo $result->localizacao; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                           
                           
                        </div>



          
        </div>


        <!--Tab 2-->
       
    </div>
</div>