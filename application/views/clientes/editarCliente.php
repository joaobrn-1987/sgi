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
                <h5>Editar Cliente</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="control-group">
                        <?php echo form_hidden('idClientes',$result->idClientes) ?>
                        <label for="nomeCliente" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input class="span8" id="nomeCliente" type="text" name="nomeCliente" value="<?php echo $result->nomeCliente; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="nomeCliente" class="control-label">Nome - Exibição (Carteira)</label>
                        <div class="controls">
                            <input class="span8" id="nomeClienteCart" type="text" name="nomeClienteCart" value="<?php echo $result->nomeClienteCart; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="documento" class="control-label">CPF/CNPJ<span class="required">*</span></label>
                        <div class="controls">
                            <input id="documento" type="text" name="documento" value="<?php echo $result->documento; ?>"  />
                        </div>
                    </div>
					 <div class="control-group">
                        <label for="ie" class="control-label">IE</label>
                        <div class="controls">
                            <input id="ie" type="text" name="ie" value="<?php echo $result->ie; ?>" />
                        </div>
                        
                    </div>
                    <div class="control-group">
                        <label for="telefone" class="control-label">Telefone<span class="required">*</span></label>
                        <div class="controls">
                            <input id="telefone" type="text" name="telefone" value="<?php echo $result->telefone; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="celular" class="control-label">Celular</label>
                        <div class="controls">
                            <input id="celular" type="text" name="celular" value="<?php echo $result->celular; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="email" class="control-label">Email<span class="required">*</span></label>
                        <div class="controls">
                            <input class="span8" id="email" type="text" name="email" value="<?php echo $result->email; ?>"  />
                        </div>
                    </div>
                    <div class="control-group" class="control-label">
                        <label for="cep" class="control-label">CEP<span class="required">*</span></label>
                        <div class="controls">
                            <input id="cep" type="text" name="cep" value="<?php echo $result->cep; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="rua" class="control-label">Rua<span class="required">*</span></label>
                        <div class="controls">
                            <input class="span8" id="rua" type="text" name="rua" value="<?php echo $result->rua; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="numero" class="control-label">Número<span class="required">*</span></label>
                        <div class="controls">
                            <input id="numero" type="text" name="numero" value="<?php echo $result->numero; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                        <div class="controls">
                            <input class="span8" id="bairro" type="text" name="bairro" value="<?php echo $result->bairro; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="cidade" class="control-label">Cidade<span class="required">*</span></label>
                        <div class="controls">
                            <input class="span8" id="cidade" type="text" name="cidade" value="<?php echo $result->cidade; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="estado" class="control-label">Estado<span class="required">*</span></label>
                        <div class="controls">
						<select id="estado" name="estado">
    <option value=""></option>
    <option value="AC" <?php if($result->estado == 'AC') { echo "selected='selected'"; } ?>>Acre</option>
    <option value="AL" <?php if($result->estado == 'AL') { echo "selected='selected'" ;} ?>>Alagoas</option>
    <option value="AP" <?php if($result->estado == 'AP') { echo "selected='selected'"; } ?>>Amapá</option>
    <option value="AM" <?php if($result->estado == 'AM') { echo "selected='selected'"; } ?>>Amazonas</option>
    <option value="BA" <?php if($result->estado == 'BA') { echo "selected='selected'" ;} ?>>Bahia</option>
    <option value="CE" <?php if($result->estado == 'CE') { echo "selected='selected'"; } ?>>Ceará</option>
    <option value="DF" <?php if($result->estado == 'DF') { echo "selected='selected'"; } ?>>Distrito Federal</option>
    <option value="ES" <?php if($result->estado == 'ES') { echo "selected='selected'"; } ?>>Espírito Santo</option>
    <option value="GO" <?php if($result->estado == 'GO') { echo "selected='selected'"; } ?>>Goiás</option>
    <option value="MA" <?php if($result->estado == 'MA') { echo "selected='selected'"; } ?>>Maranhão</option>
    <option value="MT" <?php if($result->estado == 'MT') { echo "selected='selected'"; } ?>>Mato Grosso</option>
    <option value="MS" <?php if($result->estado == 'MS') { echo "selected='selected'" ;} ?>>Mato Grosso do Sul</option>
    <option value="MG" <?php if($result->estado == 'MG') { echo "selected='selected'"; } ?>>Minas Gerais</option>
    <option value="PA" <?php if($result->estado == 'PA') { echo "selected='selected'"; } ?>>Pará</option>
    <option value="PB" <?php if($result->estado == 'PB') { echo "selected='selected'"; } ?>>Paraíba</option>
    <option value="PR" <?php if($result->estado == 'PR') { echo "selected='selected'"; } ?>>Paraná</option>
    <option value="PE" <?php if($result->estado == 'PE') { echo "selected='selected'"; } ?>>Pernambuco</option>
    <option value="PI" <?php if($result->estado == 'PI') { echo "selected='selected'"; } ?>>Piauí</option>
    <option value="RJ" <?php if($result->estado == 'RJ') { echo "selected='selected'"; } ?>>Rio de Janeiro</option>
    <option value="RN" <?php if($result->estado == 'RN') { echo "selected='selected'"; } ?>>Rio Grande do Norte</option>
    <option value="RS" <?php if($result->estado == 'RS') { echo "selected='selected'";} ?>>Rio Grande do Sul</option>
    <option value="RO" <?php if($result->estado == 'RO') { echo "selected='selected'"; } ?>>Rondônia</option>
    <option value="RR" <?php if($result->estado == 'RR') { echo "selected='selected'" ;} ?>>Roraima</option>
    <option value="SC" <?php if($result->estado == 'SC') { echo "selected='selected'"; } ?>>Santa Catarina</option>
    <option value="SP" <?php if($result->estado == 'SP') { echo "selected='selected'" ;} ?>>São Paulo</option>
    <option value="SE" <?php if($result->estado == 'SE') { echo "selected='selected'"; } ?>>Sergipe</option>
    <option value="TO" <?php if($result->estado == 'TO') { echo "selected='selected'"; } ?>>Tocantins</option>
    <option value="EX" <?php if($result->estado == 'EX') { echo "selected='selected'" ;} ?>>Estrangeiro</option>
</select>

                           
                        </div>
                    </div>

                   


                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                <a href="<?php echo base_url() ?>index.php/clientes" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
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
                  nomeCliente:{ required: true},
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
                  nomeCliente :{ required: 'Campo Requerido.'},
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

<script>
		jQuery(function($){
		       $("#cep").mask("99.999-999");
		       $("#telefone").mask("(99) 9999-9999");
               $("#celular").mask("(99) 99999-9999");
               $("#documento").mask("99.999.999/9999-99");
		});
	</script>