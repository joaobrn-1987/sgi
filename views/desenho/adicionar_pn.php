<script type="text/javascript">
    // INICIO FUNÇÃO DE MASCARA MAIUSCULA
    function maiuscula(z){
            v = z.value.toUpperCase();
            z.value = v;
        }
    //FIM DA FUNÇÃO MASCARA MAIUSCULA
</script>

<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/moment.js"></script><!--
<script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />

<!--
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script><!--
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
<link href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css" rel="stylesheet">

<!-- FORMULÁRIO DE CADASTRO -->
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
                <form action="<?php echo base_url();?>index.php/desenho/adicionar_pn" id="formProduto1" method="post" class="form-horizontal" enctype="multipart/form-data">
                    
                    <!--DESCRIÇÃO-->
                    <div class="control-group">
                        <label for="descricao" class="control-label">Descrição<span class="required">*</span></label>
                        <div class="controls">
                            <input id="descricao" type="text" name="descricao" value="<?php echo set_value('descricao'); ?>" size=50 />
                        </div>
                    </div>

                    <!--PN-->
                    <div class="control-group">
                        <label for="pn" class="control-label">PN<span class="required">*</span></label>
                        <div class="controls">
                            <input id="pn" type="text" name="pn" value="<?php echo set_value('pn'); ?>" onkeyup="maiuscula(this)" size=50 />
                        </div>
                    </div>

                    <!--REFERÊNCIA-->
                    <div class="control-group">
                        <label for="referencia" class="control-label">Referencia<span class="required">*</span></label>
                        <div class="controls">
                            <input id="referencia"  type="text" name="referencia" value="<?php echo set_value('referencia'); ?>" size=50 />
                        </div>
                    </div>

                    <!--FORNECEDOR ORIGINAL-->
					<div class="control-group">
                        <label for="fornecedor_original" class="control-label">Fornecedor Original<span class="required">*</span></label>
                        <div class="controls">
                            <input id="fornecedor_original"  type="text" name="fornecedor_original" value="<?php echo set_value('fornecedor_original'); ?>" size=50 />
                        </div>
                    </div>

                    <!--EQUIPAMENTO-->
					<div class="control-group">
                        <label for="equipamento" class="control-label">Equipamento<span class="required">*</span></label>
                        <div class="controls">
                            <input id="equipamento"  type="text" name="equipamento" value="<?php echo set_value('equipamento'); ?>" size=50 />
                        </div>
                    </div>

                    <!--SUBCONJUNTO-->
					<div class="control-group">
                        <label for="subconjunto" class="control-label">SubConjunto<span class="required">*</span></label>
                        <div class="controls">
                            <input id="subconjunto"  type="text" name="subconjunto" value="<?php echo set_value('subconjunto'); ?>" size=50 />
                        </div>
                    </div>

                    <!--MODELO-->
					<div class="control-group">
                        <label for="modelo" class="control-label">Modelo<span class="required">*</span></label>
                        <div class="controls">
                            <input id="modelo"  type="text" name="modelo" value="<?php echo set_value('modelo'); ?>" size=50 />
                        </div>
                    </div>

                    <!--OBSERVAÇÕES-->
                    <div class="control-group">
                        <label for="observ" class="control-label">Observações<span class="required">*</span></label>
                        <div class="controls">
                            <textarea id="observ" name="observ" rows="10" cols="70"></textarea>
                        </div>
                    </div>

                    <!--DESENHO-->
                    <div class="control-group">

                        <label for="desenho" class="control-label">Desenho</label>
                        <div class="controls">
                            <!--<a href="#modal-imagem" role="button" data-toggle="modal" class="btn btn-warning"  class="span12" >Anexo desenho</a>-->
                            <a class="btn btn-warning"  class="span12" onclick="mostrarAnexo()">Anexo desenho</a>
                        </div>

                        <div id="imagem">
                            
                            <div class="modal-header">
                                <button type="button" class="close" onclick="fecharAnexo()">×</button>
                                <h5 id="myModalLabel">Anexar Desenho. PN.: </h5> 
                                <p id="obsAnexo">Obs. Obrigatório cadastrar o desenho em DWG e JPG.</p>
                            </div>

                            <div class="modal-body" style="margin: 0px;">

                                <!--Arquivo DWG-->
                                <div class="span10">

                                    <br>
                                    <div class="span2">
                                        <label> <b>Arquivo DWG</b> </label>
                                        <input type="file"  name="imag_dwg" id="imag_dwg" accept=".dwg">
                                    </div>   
                                    
                                </div>

                                <!--Arquivo JPG-->
                                <div class="span10" style="margin-left:0px">

                                    <br>
                                    
                                    <div class="span2">
                                        <label> <b>Arquivo JPG</b></label>
                                        <input type="file"  name="imag_jpg" id="imag_jpg" accept=".jpg">
                                    </div>   
                                    
                                </div>

                                <!--Desenho de Corte - Arquivo DWG-->
                                <div class="span10" style="margin-left:0px">

                                    <br>

                                    <div class="span10">
                                        <label> <b>Desenho de Corte <br> Arquivo DWG</b></label>
                                        <input type="file"  name="imag_corte" id="imag_corte" accept=".dwg">
                                    </div>

                                    <div class="span10" id="desenhos_corte_title" style="display:none;">
                                        <br>
                                        <h5></h5>
                                    </div>

                                    <!-- Lista de Desenhos de Corte -->
                                    <div class="span7" id="desenhosCorte" style="display:none;">

                                        <table border="0" id="tableCorte" style="width:100%;">

                                            <thead>

                                                <tr class="trpai">
                                                    <th id="thPai" onclick="openclose(this);"> <a class="detail-icon" ><i class="fa fa-plus"></i></a></th>
                                                    <th colspan="3" style="padding-left: 10px;"><h5>Desenhos de Corte Anexados</h5></th>
                                                </tr>

                                                <tr id="title_pai">
                                                    <th></th>
                                                    <th></th>
                                                    <th>Descrição</th>
                                                    <th>Observação</th>
                                                </tr>

                                            </thead>

                                            <tbody id="tbodyFilho" class="trfilho" style="text-align: center;display:none;">

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>     

                    <!--BOTÕES FORMULÁRIO-->
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                
                                <button onclick="confirmaDados()" id="adicionar" type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar PN</button>
                                <!--<button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar PN</button>-->
                                <a href="<?php echo base_url() ?>index.php/desenho/criar_pn" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>

                            </div>
                        </div>
                    </div>

                    
                </form>
            </div>

         </div>
     </div>
</div>

<!-- MODAL CONFIRMAÇÃO DE DADOS -->
<div id="modal-confirma" style="height: 550px; width: 900px; overflow: scroll;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-header">
        <button type="button" onclick="renovaDados();" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5>CONFIRMAÇÃO DE DADOS</h5>
    </div>

    <div class="span10">
                    
        <div class="controls">
            <br>
            <h4>Você tem certeza que deseja enviar esse desenho para a MASTER? </h4>  
        </div>
        
    </div>

    <div class="modal-content" style="margin-top:0">

        <div class="span12">

            <div class="widget-box">

                <div class="widget-content nopadding">
                    
                    <div class="span12" id="divProdutosServicos" style=" margin-left: 0;">
                        
                        <div class="container-fluid" style="margin-top: 20px;">

                            <!--DETALHES PN-->
                            <table class='comBordas' style="font-size:18px; background-color: white;" width='100%' align='left'>
                                <tr>
                                    <td align='center'>
                                        PN: 
                                    </td>
                                    <td align='center'>
                                        Descrição:
                                    </td>
                                    <td align='center'>
                                        Referência: 
                                    </td>
                                </tr>
                                <tr>

                                    <td align='center'>
                                        <font size='5'><b><span id="pn2"></span></b></font>
                                    </td>
                                    <td align='center'>
                                        <b><span id="descricao2"></span></b>
                                    </td>
                                    <td align='center'>
                                        <b><span id="referencia2"></span></b>
                                    </td>

                                </tr>
                            </table>

                            <!--DADOS QUE SERÃO ENVIADOS-->
                            <div class="row-fluid">
                                <div class="span12">

                                    <div class="widget-box">

                                        <div class="widget-content nopadding">

                                            <table width='100%' border='0' style="border-style:solid; border: 1px solid grey;
                                                font-family:Arial, Helvetica, sans-serif;
                                                font-size:18px; background-color: white;">
                                                <tr>

                                                    <td align='center'>

                                                        <table width='100%' border='0' style="font-family:Arial, Helvetica, sans-serif;
                                                            font-size:15px; line-height: 20px; padding: 20px;">

                                                            <tr>
                                                                <td align='left' style="padding-left: 5px;"><b>Usuário Criação:</b></td>
                                                                <td align='left' style="border-right: 1px solid grey;">
                                                                    <span id="usuario">
                                                                        <?php echo $this->session->userdata('nome');?>
                                                                    </span>
                                                                </td>
                                                                <td align='left' style="padding-left: 5px;">
                                                                    <b>Equipamento:</b>
                                                                </td>
                                                                <td align='left' style="border-right: 1px solid grey;">
                                                                    <span id="equipamento2"></span>
                                                                </td>
                                                                <td align='left' style="padding-left: 5px;">
                                                                    <b>Fornecedor Original: </b>
                                                                </td>
                                                                <td align='left'>
                                                                    <span id="fornecedor_original2"></span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td align='left' style="padding-left: 5px;"><b>Data: </b></td>
                                                                <td align='left' style="border-right: 1px solid grey;">
                                                                    <span id="data">
                                                                        <?php echo date("d/m/Y H:i:s");?>
                                                                    </span>
                                                                </td>
                                                                <td align='left' style="padding-left: 5px;"><b>SubConjunto: </b></td>
                                                                <td align='left' style="border-right: 1px solid grey;">
                                                                    <span id="subconjunto2"></span>
                                                                </td>
                                                                <td align='left'style="padding-left: 5px;"><b>Modelo: </b></td>
                                                                <td align='left'>
                                                                    <span id="modelo2"></span>
                                                                </td>
                                                            </tr>

                                                            <tr style="border-top: 1px solid grey;">
                                                                <td align='left' style="padding-left: 5px;"><b>Observações:</b></td>
                                                            </tr>

                                                            <tr style="border-bottom: 1px solid grey;">
                                                                <td align='left' colspan="6" style="padding-left: 5px;">
                                                                    <span id="observ2"></span>
                                                                </td>
                                                            </tr>

                                                            <!--DESENHOS DWG-->
                                                            <tr>
                                                                <td align='left' style="padding-left: 5px;">
                                                                    <b>Desenho DWG:</b>
                                                                </td>
                                                                <td align='left' colspan="5">
                                                                    <span id="desenho_dwg"></span>
                                                                </td>
                                                            </tr>

                                                            <!--DESENHOS JPG-->
                                                            <tr>
                                                                <td align='left' style="padding-left: 5px;">
                                                                    <b>Desenho JPG:</b>
                                                                </td>
                                                                <td align='left' colspan="5">
                                                                    <span id="desenho_jpg"></span>
                                                                </td>
                                                            </tr>

                                                            <!--DESENHOS DE CORTE-->
                                                            <tr id="confirm_corte" style="display: none;">
                                                                
                                                            </tr>
                                                            

                                                        </table>

                                                    </td>         
                                                            
                                                </tr>

                                            </table>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--BOTÃO ENVIAR-->
                            <div class="control-group">

                                <div class="controls">

                                    <button onclick="enviaPN(this)" class="btn btn-success">
                                        <i class="icon-plus icon-white"></i> Enviar para a Master
                                    </button>

                                </div>

                            </div>

                            <br>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>js/maskmoney.js"></script>
<script type="text/javascript">
    
    $(document).ready(function(){

        $(".money").maskMoney();

        $('#formProduto1').validate({
            
            rules :{
                  descricao: { required: true},
                  pn: { required: true},
                  referencia: { required: true},
                  fornecedor_original: { required: true},
                  equipamento: { required: true},
                  subconjunto: { required: true},
                  modelo: { required: true},
                  observ: { required: true},
                  imag_dwg: { required: true},
                  imag_jpg: { required: true}
            },
            messages:{
                  descricao: { required: 'Campo Requerido.'},
                  pn: {required: 'Campo Requerido.'},
                  referencia: {required: 'Campo Requerido.'},
                  fornecedor_original: {required: 'Campo Requerido.'},
                  equipamento: {required: 'Campo Requerido.'},
                  subconjunto: {required: 'Campo Requerido.'},
                  modelo: {required: 'Campo Requerido.'},
                  observ: {required: 'Campo Requerido.'},
                  imag_dwg: {required: 'Obrigatório o cadastro de um desenho em DWG.'},
                  imag_jpg: {required: 'Obrigatório o cadastro de um desenho em JPG.'}
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $('#imagem').show();
                $(element).parents('.des').addClass('error');
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $('#imagem').show();
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }

        });

        $('#imagem').css( "display", "none" );

        $('#formProduto1').submit(function(e) {
            e.preventDefault();
            // ou return falso;
        });

    });

    function mostrarAnexo(){

        $('#imagem').show( 800 );

    }

    function fecharAnexo(){

        $('#imagem').hide( 800 );

    }

    function openclose(td){

        var tr = document.querySelector(".trfilho");

        if(tr.style.display == "table-row" || tr.style.display == "" || tr.style.display == "table-row-group"){
            $(".trfilho").hide('fast');
            $("#title_pai").hide('fast');
            //$(td).parent('tr').css('background-color', cor);
            $(td).find("a > i").removeClass("fa-minus");
            $(td).find("a > i").addClass("fa-plus");
        }else{
            $(".trfilho").show('fast');
            $("#title_pai").show('fast');
            //$(td).parent('tr').css('background-color', cor);
            $(td).find("a > i").removeClass("fa-plus");
            $(td).find("a > i").addClass("fa-minus");
        }

    }

    function renovaDados(){

        dataCorte = [];

    }

    $("#imag_dwg").change(function(){
   
        var file_dataDwg = document.getElementById('imag_dwg');

        if(file_dataDwg.files[0] == null || file_dataDwg.files[0] ===""){

        }else{

            var nomeArquivoDWG = file_dataDwg.files[0]["name"].split(".");
            extensaoArquivoDWG = nomeArquivoDWG[1];

            if(extensaoArquivoDWG !== 'dwg' && extensaoArquivoDWG !== 'DWG'){

                alert('Arquivo não é de extensão "DWG"');
                $("#imag_dwg").css("color", "red");

            }else{

                $("#imag_dwg").css("color", "green");

            }
            
        }

    });

    extensaoArquivoJPG = "";

    $("#imag_jpg").change(function(){
   
        var file_dataJpg = document.getElementById('imag_jpg');

        if(file_dataJpg.files[0] == null || file_dataJpg.files[0] ===""){

        }else{

            var nomeArquivoJPG = file_dataJpg.files[0]["name"].split(".");
            extensaoArquivoJPG = nomeArquivoJPG[1];

            if(extensaoArquivoJPG !== 'jpg' && extensaoArquivoJPG !== 'JPG'){

                alert('Arquivo não é de extensão "JPG"');
                $("#imag_jpg").css("color", "red");

            }else{

                $("#imag_jpg").css("color", "green");

            }
            
        }

    });

    extensaoArquivoCorte = "";
    tableCorte = document.getElementById("tableCorte").getElementsByTagName('tbody')[0];
    co = 0;
    cort = 1;
    delet = 0;

    form_dataCorte = [];

    $("#imag_corte").change(function(){

        var file_dataDwg = document.getElementById('imag_corte');

        if(file_dataDwg.files[0] == null || file_dataDwg.files[0] ===""){

        }else{

            var nomeArquivoDWG = file_dataDwg.files[0]["name"].split(".");
            extensaoArquivoCorte = nomeArquivoDWG[1];

            if(extensaoArquivoCorte !== 'dwg' && extensaoArquivoCorte !== 'DWG'){

                alert('Arquivo não é de extensão "DWG"');
                $("#imag_corte").css("color", "red");
                return;

            }else{

                var pn = document.getElementById('pn').value;
                if(pn === "" || pn == null){

                    alert("Necessário primeiro Digitar o PN!");
                    file_dataDwg.value = "";
                    return;

                }else{

                    totalRows = tableCorte.rows.length;

                    if(delet==1){
                        
                        trList = document.querySelectorAll('#tbodyFilho tr');

                        trList.forEach(function (tr_Corte, i, trs) {
                            
                            if(i === trs.length - 1){ 
                                var nameTr = tr_Corte.getAttribute("name");
                                nameTr = parseInt(nameTr);
                                cort = nameTr + 1;
                            }
                            
                        });

                        delet = 0;
                        
                    }

                    $("#imag_corte").css("color", "green");
                    $("#desenhosCorte").css("display", "block");

                    $(".trfilho").show('fast');
                    $("#thPai").find("a > i").removeClass("fa-plus");
                    $("#thPai").find("a > i").addClass("fa-minus");

                    if(tableCorte.rows.length == null || typeof tableCorte.rows.length == "undefined"){
                        var numOfRows = 0;
                    } else {
                        var numOfRows = tableCorte.rows.length;
                    }

                    // ARRAY DESENHOS CORTE
                    form_dataCorte.push(file_dataDwg.files[0]);

                    var indice = form_dataCorte.length -1;

                    var newRow;

                    newRow = tableCorte.insertRow(co);
                    newRow.setAttribute("id","trCorte" + cort);
                    newRow.setAttribute("name", cort);

                    // COLUNA BOTÃO DELETE
                    newCell = newRow.insertCell(0);
                    newCell.innerHTML = '<a onclick="deletaCorte(`trCorte'+ cort +'`,`'+ cort +'`,`'+ file_dataDwg.files[0]["name"] +'`)" class="btn btn-danger tip-top" title="Excluir Desenho"><i class="icon-remove icon-white"></i></a>';

                    // COLUNA NOME DO ARQUIVO
                    newCell = newRow.insertCell(1);
                    newCell.innerHTML = "<b>" + pn + "_corte" + cort + ".dwg</b>";

                    // COLUNA DESCRIÇÃO DO CORTE
                    newCell = newRow.insertCell(2);
                    newCell.innerHTML = '<input type="text" id="descCorte'+ cort +'" name="descCorte'+ cort +'">';

                    // COLUNA DESCRIÇÃO DO CORTE
                    newCell = newRow.insertCell(3);
                    newCell.innerHTML = '<input type="text" id="observCorte'+ cort +'" name="observCorte'+ cort +'" size="40">';

                    co++;
                    cort++;

                }

            }

        }

    });

    function deletaCorte(tr, x, nomeArquivo){

        var trCorte = document.getElementById(tr);
        trCorte.remove();

        var file_dataDwg = document.getElementById('imag_corte');
        file_dataDwg.value = "";

        var i = 0;

        for (const desenho of form_dataCorte) {

            if(desenho["name"] == nomeArquivo){

                form_dataCorte.splice(i, 1);
                dataCorte.splice(i, 1);

                break;

            }

            i++;

        }

        delet = 1;

        if(co > 0){

            co--;
            cort--;

        }

    }

    form_data = new FormData();
    dataCorte = [];

    function confirmaDados(){

        // DADIS 1º FORMULÁRIO (EDIÇÃO)
        var pn                  = document.getElementById('pn');
        var descricao           = document.getElementById('descricao');
        var referencia          = document.getElementById('referencia');
        var fornecedor_original = document.getElementById('fornecedor_original');
        var equipamento         = document.getElementById('equipamento');
        var subconjunto         = document.getElementById('subconjunto');
        var modelo              = document.getElementById('modelo');
        var observ              = document.getElementById('observ');
        var file_dataDwg        = document.getElementById('imag_dwg');
        var file_dataJpg        = document.getElementById('imag_jpg');

        if(!pn.value || pn.value ==="" || !descricao.value || descricao.value ==="" ||
           !referencia.value || referencia.value ==="" ||
           !fornecedor_original.value || fornecedor_original.value ==="" ||
           !equipamento.value || equipamento.value ==="" || !subconjunto.value || subconjunto.value ==="" ||
           !modelo.value || modelo.value ==="" || !observ.value || observ.value ==="" ||
           !file_dataDwg.files[0] || !file_dataJpg.files[0]){

            $('#obsAnexo').css({'color':'red','font-weight':'bold'});
            return;

        }else{

            if(extensaoArquivoDWG !== 'dwg' && extensaoArquivoDWG !== 'DWG'){

                alert('Favor cadastrar arquivo de Desenho em "DWG"');
                $("#imag_dwg").css("color", "red");
                return;

            }

            if(extensaoArquivoJPG !== 'jpg' && extensaoArquivoJPG !== 'JPG'){

                alert('Favor cadastrar arquivo de Desenho em "JPG"');
                $("#imag_jpg").css("color", "red");
                return;

            }

            if(extensaoArquivoCorte !== '' && extensaoArquivoCorte !== 'dwg' && extensaoArquivoCorte !== 'DWG'){

                alert('Favor cadastrar arquivo de Desenho de Corte em "DWG"');
                $("#imag_corte").css("color", "red");
                return;

            }

            //INPUTS PARA ENVIO
            form_data.append('pn', pn.value);
            form_data.append('descricao', descricao.value);
            form_data.append('referencia', referencia.value);
            form_data.append('fornecedor_original', fornecedor_original.value);
            form_data.append('equipamento', equipamento.value);
            form_data.append('subconjunto', subconjunto.value);
            form_data.append('modelo', modelo.value);
            form_data.append('observ', observ.value);
            form_data.append('imag_dwg', file_dataDwg.files[0]);
            form_data.append('imag_jpg', file_dataJpg.files[0]);

            $("#modal-confirma").modal({
                show: true
            });

            // INPUTS APENAS EXIBIDOS
            $('#descricao2').html(descricao.value);
            $('#pn2').html(pn.value);
            $('#referencia2').html(referencia.value);
            $('#fornecedor_original2').html(fornecedor_original.value);
            $('#equipamento2').html(equipamento.value);
            $('#subconjunto2').html(subconjunto.value);
            $('#modelo2').html(modelo.value);
            $('#observ2').html(observ.value);
            $('#desenho_dwg').html(file_dataDwg.files[0]["name"]);
            $('#desenho_jpg').html(file_dataJpg.files[0]["name"]);

            var tr_confirm_corte = document.getElementById("confirm_corte");
            var x = 1;
            var td_confirm_corte =  "";

            if(form_dataCorte.length > 0){

                tr_confirm_corte.style.display = "";

                td_confirm_corte = '<td align="left" colspan="6" style="padding-left: 5px;">';
                td_confirm_corte += '<b>Desenhos de Corte:</b></br>';

                var corte = [];

                for (const desenho of form_dataCorte) {

                    var desc = document.getElementById("descCorte"+x);
                    var observCorte = document.getElementById("observCorte"+x);

                    var checaDesc = document.body.contains(desc);

                    //console.log(desc,checaDesc);

                    if(checaDesc == true){

                        corte.push("||");
                        corte.push(desenho["name"]);
                        corte.push(desc.value);
                        corte.push(observCorte.value);
                        var corte_chave = 'corte' + x;
                        //console.log(corte_chave);
                        form_data.append(corte_chave, desenho);

                        td_confirm_corte += desenho["name"] + "<b>(" + corte_chave + ")</b>";
                        
                        td_confirm_corte += ' | <b>Descrição Corte: </b>';
                        if(desc.value !== ""){
                            td_confirm_corte += desc.value;
                        }else{
                            td_confirm_corte += "-";
                        }
               
                        td_confirm_corte += ' | <b>Observação Corte: </b>';
                        if(observCorte.value !== ""){
                            td_confirm_corte += observCorte.value +'<br>';
                        }else{
                            td_confirm_corte += "-<br>";
                        }

                        dataCorte.push(corte);

                        corte = [];

                    }

                    x++;
                
                }

                td_confirm_corte += '</td>';
                tr_confirm_corte.innerHTML = td_confirm_corte;

            }else{

                tr_confirm_corte.innerHTML = "";

            }

            //console.log("array",dataCorte);

            form_data.append('desenhos_corte', dataCorte);

        }

    }

    function enviaPN(botao){

        botao.disabled = true;

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/desenho/adicionar_pn",
            dataType: 'json',
            cache: false,
            async: false,
            contentType: false,
            processData: false,
            type: 'POST',
            data:form_data,
            success: function(data2) {
                if(data2.result == true){
                    alert("Desenho anexado com sucesso.");
                    window.location.href = "<?php echo base_url() . 'index.php/desenho/criar_pn';?>";
                }else{
                    alert("Erro com os dados enviados!");
                    $("#modal-confirma").modal('hide');
                    window.location.href = "<?php echo base_url() . 'index.php/desenho/adicionar_pn';?>";
                }
            },
            error: function(xhr, textStatus, error) {
                console.log("4");
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            },
        })

    }

</script>



