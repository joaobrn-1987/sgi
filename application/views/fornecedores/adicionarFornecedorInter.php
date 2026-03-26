
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>

            <script type="text/javascript" >

$(document).ready(function() {

 
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#estado").val("");
        
    }
    
    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#estado").val("...");
               

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                       
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});

</script> 


<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.maskedinput-1.3.min"/></script> 

        

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5>Cadastro de Fornecedor Internacional</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formFornecedor" method="post" class="form-horizontal" >
               <!--<form  action="<?php echo base_url() ?>index.php/Fornecedors/pesquisar_cnpj" method="post">-->
                    <div class="control-group">
                        <label for="nomeFornecedor" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input class="span8" id="nomeFornecedor" type="text" name="nomeFornecedor" value="<?php echo set_value('nomeFornecedor'); ?>"  />
                        </div>
                    </div>
                  
                    <div class="control-group">
                        <label for="documento" class="control-label">CPF/CNPJ<span class="required">*</span></label>
                        <div class="controls">
                            <input id="documento" type="text" name="documento" value="<?php echo set_value('documento'); ?> " />
                        </div>
                        
                    </div>
                    
                    <div class="control-group">
                        <label for="telefone" class="control-label">Telefone<span class="required">*</span></label>
                        <div class="controls">
                            <input id="telefone" type="text" name="telefone" value="<?php echo set_value('telefone'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="celular" class="control-label">Celular</label>
                        <div class="controls">
                            <input id="celular" type="text" name="celular" value="<?php echo set_value('celular'); ?>"  />
                        </div>
                    </div>
                   

                    <div class="control-group">
                        <label for="email" class="control-label">Email<span class="required">*</span></label>
                        <div class="controls">
                            <input class="span8" id="email" type="text" name="email" value="<?php echo set_value('email'); ?>"  />
                        </div>
                    </div>
                    <div class="control-group" class="control-label">
                        <label for="cep" class="control-label">CEP<span class="required">*</span></label>
                        <div class="controls">
                            <input id="cep" type="text" name="cep" value="<?php echo set_value('cep'); ?>"  />
                        </div>
                    </div>
                    <div class="control-group" class="control-label">
                        <label for="rua" class="control-label">Rua<span class="required">*</span></label>
                        <div class="controls">
                            <input class="span8" id="rua" type="text" name="rua" value="<?php echo set_value('rua'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="numero" class="control-label">Número<span class="required">*</span></label>
                        <div class="controls">
                            <input id="numero" type="text" name="numero" value="<?php echo set_value('numero'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                        <div class="controls">
                            <input class="span8" id="bairro" type="text" name="bairro" value="<?php echo set_value('bairro'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="cidade" class="control-label">Cidade</label>
                        <div class="controls">
                            <input class="span8" id="cidade" type="text" name="cidade" value="<?php echo set_value('cidade'); ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="estado" class="control-label">Estado<span class="required">*</span></label>
                        <div class="controls">
                            <select id="estado" name="estado">
    <option value=""></option>
    <option value="AC" <?php if(set_value('estado') == 'AC') { echo "selected='selected'"; } ?>>Acre</option>
    <option value="AL" <?php if(set_value('estado') == 'AL') { echo "selected='selected'" ;} ?>>Alagoas</option>
    <option value="AP" <?php if(set_value('estado') == 'AP') { echo "selected='selected'"; } ?>>Amapá</option>
    <option value="AM" <?php if(set_value('estado') == 'AM') { echo "selected='selected'"; } ?>>Amazonas</option>
    <option value="BA" <?php if(set_value('estado') == 'BA') { echo "selected='selected'" ;} ?>>Bahia</option>
    <option value="CE" <?php if(set_value('estado') == 'CE') { echo "selected='selected'"; } ?>>Ceará</option>
    <option value="DF" <?php if(set_value('estado') == 'DF') { echo "selected='selected'"; } ?>>Distrito Federal</option>
    <option value="ES" <?php if(set_value('estado') == 'ES') { echo "selected='selected'"; } ?>>Espírito Santo</option>
    <option value="GO" <?php if(set_value('estado') == 'GO') { echo "selected='selected'"; } ?>>Goiás</option>
    <option value="MA" <?php if(set_value('estado') == 'MA') { echo "selected='selected'"; } ?>>Maranhão</option>
    <option value="MT" <?php if(set_value('estado') == 'MT') { echo "selected='selected'"; } ?>>Mato Grosso</option>
    <option value="MS" <?php if(set_value('estado') == 'MS') { echo "selected='selected'" ;} ?>>Mato Grosso do Sul</option>
    <option value="MG" <?php if(set_value('estado') == 'MG') { echo "selected='selected'"; } ?>>Minas Gerais</option>
    <option value="PA" <?php if(set_value('estado') == 'PA') { echo "selected='selected'"; } ?>>Pará</option>
    <option value="PB" <?php if(set_value('estado') == 'PB') { echo "selected='selected'"; } ?>>Paraíba</option>
    <option value="PR" <?php if(set_value('estado') == 'PR') { echo "selected='selected'"; } ?>>Paraná</option>
    <option value="PE" <?php if(set_value('estado') == 'PE') { echo "selected='selected'"; } ?>>Pernambuco</option>
    <option value="PI" <?php if(set_value('estado') == 'PI') { echo "selected='selected'"; } ?>>Piauí</option>
    <option value="RJ" <?php if(set_value('estado') == 'RJ') { echo "selected='selected'"; } ?>>Rio de Janeiro</option>
    <option value="RN" <?php if(set_value('estado') == 'RN') { echo "selected='selected'"; } ?>>Rio Grande do Norte</option>
    <option value="RS" <?php if(set_value('estado') == 'RS') { echo "selected='selected'";} ?>>Rio Grande do Sul</option>
    <option value="RO" <?php if(set_value('estado') == 'RO') { echo "selected='selected'"; } ?>>Rondônia</option>
    <option value="RR" <?php if(set_value('estado') == 'RR') { echo "selected='selected'" ;} ?>>Roraima</option>
    <option value="SC" <?php if(set_value('estado') == 'SC') { echo "selected='selected'"; } ?>>Santa Catarina</option>
    <option value="SP" <?php if(set_value('estado') == 'SP') { echo "selected='selected'" ;} ?>>São Paulo</option>
    <option value="SE" <?php if(set_value('estado') == 'SE') { echo "selected='selected'"; } ?>>Sergipe</option>
    <option value="TO" <?php if(set_value('estado') == 'TO') { echo "selected='selected'"; } ?>>Tocantins</option>
    <option value="EX" <?php if(set_value('estado') == 'EX') { echo "selected='selected'" ;} ?>>Estrangeiro</option>
</select>
                        </div>
                    </div>

                    



                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                                <a href="<?php echo base_url() ?>index.php/fornecedores" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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
           $('#formFornecedor').validate({
            rules :{
                  nomeFornecedor:{ required: true},
                  documento:{ required: true},
                  /*telefone:{ required: true},
                  email:{ required: true},
                  rua:{ required: true},
                  numero:{ required: true},
                  bairro:{ required: true},
                  cidade:{ required: true},
                  estado:{ required: true},
                  cep:{ required: true}*/
            },
            messages:{
                  nomeFornecedor :{ required: 'Campo Requerido.'},
                  documento :{ required: 'Campo Requerido.'},
                  /*telefone:{ required: 'Campo Requerido.'},
                  email:{ required: 'Campo Requerido.'},
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/imask"></script>
<script>
var maskCpfOuCnpj = IMask(document.getElementById('documento'), {
			mask:[
				{
					mask: '000.000.000-00',
					maxLength: 11
				},
				{
					mask: '00.000.000/0000-00'
				}
			]
		});
/*		
$(document).ready(function(e) {
  $('#documento').mask('000.000.000-00', {
  onKeyPress : function(documento, e, field, options) {
    const masks = ['000.000.000-000', '00.000.000/0000-00'];
    const mask = (documento.length > 14) ? masks[1] : masks[0];
    $('#documento').mask(mask, options);
  }
});
});*/


		jQuery(function($){
		       $("#cep").mask("99.999-999");
		       $("#telefone").mask("(99) 9999-9999");
               $("#celular").mask("(99) 99999-9999");
              // $("#documento").mask("99.999.999/9999-99");
		});
	</script>

