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
                <h5>Editar Fornecedor Internacional</h5>
            </div>
            <div class="widget-content nopadding">
                <?php if ($custom_error != '') {
                    echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                } ?>
                <form action="<?php echo current_url(); ?>" id="formFornecedorInt" method="post" class="form-horizontal" >
				
					<input type="hidden" name="tipoFor" value="2">
					<input type="hidden" name="documento" value="000.000.000/0000-00">
                    <div class="control-group">
                        <?php echo form_hidden('idFornecedores',$result->idFornecedores) ?>
                        <label for="nomeFornecedor" class="control-label">Nome Fornecedor <span class="required">*</span></label>
                        <div class="controls">
                            <input class="span8" id="nomeFornecedor" type="text" name="nomeFornecedor" value="<?php echo $result->nomeFornecedor; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="telefone" class="control-label">Telefone<span class="">*</span></label>
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
						<label for="site" class="control-label">Site<span></span></label>
							<div class="controls">
								<input class="span8" id="site" type="text" name="site" value="<?php echo $result->site; ?>"  />
							</div>
					</div>					

                    <div class="control-group">
                        <label for="email" class="control-label">Email<span class="">*</span></label>
                        <div class="controls">
                            <input class="span8" id="email" type="text" name="email" value="<?php echo $result->email; ?>"  />
                        </div>
                    </div>
					<div class="control-group" class="control-label">
						<label for="endcomp" class="control-label">Endereço completo<span></span></label>
						<div class="controls">
							<input class="span8" id="endcomp" type="text" name="endcomp" value="<?php echo $result->endcomp; ?>"  />
						</div>
					</div>					



                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
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
           $('#formFornecedorInt').validate({
            rules :{
                  nomeFornecedor:{ required: true},
                  //documento:{ required: true},
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
                  //documento :{ required: 'Campo Requerido.'},
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
/*$(document).ready(function(e) {
  $('#documento').mask('00.000.000/0000-00', {
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