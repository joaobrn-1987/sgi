<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Cadastro de Cliente</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
               <!--<form  action="<?php echo base_url() ?>index.php/insumos/pesquisar_cnpj" method="post">-->
                    <div class="control-group">
                    <label for="idCategoria">Categoria<span class="required">*</span></label>
                                            <select class="span12" name="idCategoria" id="idCategoria" value="">
                                                <option value="Orçamento">Orçamento</option>
                                                <option value="Aberto">Aberto</option>
                                                <option value="Em Andamento">Em Andamento</option>
                                                <option value="Finalizado">Finalizado</option>
                                                <option value="Cancelado">Cancelado</option>
                                            </select>
                    </div>
                  
                    <div class="control-group">
                    <label for="idSubcategoria">Subcategoria<span class="required">*</span></label>
                                            <select class="span12" name="idSubcategoria" id="idSubcategoria" value="">
                                                <option value="Orçamento">Orçamento</option>
                                                <option value="Aberto">Aberto</option>
                                                <option value="Em Andamento">Em Andamento</option>
                                                <option value="Finalizado">Finalizado</option>
                                                <option value="Cancelado">Cancelado</option>
                                            </select>
                        
                    </div>
                    
                    <div class="control-group">
                        
                        <div class="span12 controls">
						Descrição<br>
                            <input id="descricaoInsumo" type="text" name="telefdescricaoInsumoone" value="<?php echo set_value('descricaoInsumo'); ?>" class='span12' />
                        </div>
                    </div>

                   





                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                                <a href="<?php echo base_url() ?>index.php/insumos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
           $('#formCliente').validate({
            rules :{
                idCategoria:{ required: true},
                idSubcategoria:{ required: true},
                descricaoInsumo:{ required: true},
                  /* email:{ required: true},
                  rua:{ required: true},
                  numero:{ required: true},
                  bairro:{ required: true},
                  cidade:{ required: true},
                  estado:{ required: true},
                  cep:{ required: true}*/
            },
            messages:{
                idCategoria :{ required: 'Campo Requerido.'},
                idSubcategoria :{ required: 'Campo Requerido.'},
                 descricaoInsumo:{ required: 'Campo Requerido.'},
                  /* email:{ required: 'Campo Requerido.'},
                  rua:{ required: 'Campo Requerido.'},
                  numero:{ required: 'Campo Requerido.'},
                  bairro:{ required: 'Campo Requerido.'},
                  cidade:{ required: 'Campo Requerido.'},
                  estado:{ required: 'Campo Requerido.'},
                  cep:{ required: 'Campo Requerido.'}*/

            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
           });
          
      
      });
</script>




