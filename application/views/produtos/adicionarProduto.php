<script type="text/javascript">
// INICIO FUNÇÃO DE MASCARA MAIUSCULA
function maiuscula(z){
        v = z.value.toUpperCase();
        z.value = v;
    }
//FIM DA FUNÇÃO MASCARA MAIUSCULA
</script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5>Cadastro de Produto PN</h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formProduto" method="post" class="form-horizontal" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                     <div class="control-group">
                        <label for="descricao" class="control-label">Descrição<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descricao" type="text" name="descricao" value="<?php echo set_value('descricao'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="pn" class="control-label">PN<span class="required">*</span></label>
                        <div class="controls">
                            <input id="pn" type="text" name="pn" value="<?php echo set_value('pn'); ?>" onkeyup="maiuscula(this)" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="referencia" class="control-label">Referencia<span class="required">*</span></label>
                        <div class="controls">
                            <input id="referencia"  type="text" name="referencia" value="<?php echo set_value('referencia'); ?>"  />
                        </div>
                    </div>
					  <div class="control-group">
                        <label for="fornecedor_original" class="control-label">Fornecedor Original<span class="required">*</span></label>
                        <div class="controls">
                            <input id="fornecedor_original"  type="text" name="fornecedor_original" value="<?php echo set_value('fornecedor_original'); ?>"  />
                        </div>
                    </div>
					  <div class="control-group">
                        <label for="equipamento" class="control-label">Equipamento<span class="required">*</span></label>
                        <div class="controls">
                            <input id="equipamento"  type="text" name="equipamento" value="<?php echo set_value('equipamento'); ?>"  />
                        </div>
                    </div>
					  <div class="control-group">
                        <label for="subconjunto" class="control-label">SubConjunto<span class="required">*</span></label>
                        <div class="controls">
                            <input id="subconjunto"  type="text" name="subconjunto" value="<?php echo set_value('subconjunto'); ?>"  />
                        </div>
                    </div>
					  <div class="control-group">
                        <label for="modelo" class="control-label">Modelo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="modelo"  type="text" name="modelo" value="<?php echo set_value('modelo'); ?>"  />
                        </div>
                    </div>

                   <!-- <div class="control-group">
                        <label for="precoVenda" class="control-label">Preço de Venda<span class="required">*</span></label>
                        <div class="controls">
                            <input id="precoVenda" class="money" type="text" name="precoVenda" value="<?php echo set_value('precoVenda'); ?>"  />
                        </div>
                    </div>-->

                   
                    

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                                <a href="<?php echo base_url() ?>index.php/produtos" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>

                    
                </form>
            </div>

         </div>
     </div>
</div>

<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".money").maskMoney();

        $('#formProduto').validate({
            rules :{
                  descricao: { required: true},
                  pn: { required: true}
                
            },
            messages:{
                  descricao: { required: 'Campo Requerido.'},
                  pn: {required: 'Campo Requerido.'}
                
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



