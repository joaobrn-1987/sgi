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
                <h5>Catálogo</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                     
                                     
                                    <div class="span3">
                                        <label for="cliente" class="control-label">Tipo:</label>
                                        <select class="span12" id="tipo" name="tipo">
                                            <option value="">Selecione</option>
                                            <option value="cil">Cilindro</option>
                                            <option value="maq">Máquina</option>
                                            <option value="pec">Peça</option>
                                            <option value="sub">Subconjunto</option>
                                        </select>
                                    </div>
                                    <!-- PN -->
                                    <div class="span2" class="control-group">
                                        <label for="cliente" class="control-label">PN:</label>
                                        <input class="span12 form-control" id="pn"
                                            type="text" name="pn" value="" />
                                        <input class="span12" class="form-control" id="pn4"
                                            type="hidden" name="pn4" value="" />

                                    </div>

                                    <!-- DESCRIÇÃO --><!---->
                                    <div class="span2" class="control-group">
                                        <label for="cliente"
                                            class="control-label">Descrição:</label>
                                        <input class="span12" class="form-control" id="prod"
                                            type="text" name="prod" value="" readonly />
                                        <input id="idProdutos" type="hidden" name="idProdutos"
                                            value="" />
                                    </div>

                                    <!-- REFERENCIA --><!--
                                    <div class="span2" class="control-group">
                                        <label for="cliente"
                                            class="control-label">Referência:</label>
                                        <input class="span12" class="form-control" id="ref"
                                            type="text" name="ref" value="" />
                                        <input id="referencia" type="hidden" name="referencia"
                                            value="" readonly/>
                                    </div>-->
                                    <!-- BOTÃO BUSCAR -->
                                    
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group"
                                        style="margin-left:0px">
                                        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vDesenho')){ ?>
                                            <label for="cliente" class="control-label"></label>
                                            <a class="btn btn-success" name="busca" id="busca"
                                                style="justify-content: flex-end; display: table;"
                                                onclick="buscarPn()">Buscar
                                            </a>

                                        <?php } ?>
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
<!-- CRIAR PN -->
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5 style="padding-right: 0px;">
                    Criação de PN
                </h5>
            </div>
            
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content">
                        <br>
                        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aDesenho')){ ?>
                            <a href="<?php echo base_url();?>index.php/desenho/page_addPn" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Produto PN</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
</br>
<div align='center'>
    <a name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success" href="<?php echo base_url().'index.php/peritagem/adicionarcatalogo' ?>"><i class="icon-plus icon-white"></i>Adicionar Catálogo</a>
</div>-->
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Itens</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
					<div class="span12" id="divCadastrarOs">                                
						<div class="widget-box" style="margin-top:0px">                                        
							<table id="table_id" class="table table-bordered ">
								<thead>
									<tr>
										<th>PN</th>
										<th>Descrição</th>
										<th>Tipo</th>
                                        <th>Data cadastro</th>
                                        <th></th>    
									</tr>
								</thead>
								<tbody>

                                    <?php /* foreach($catalogos as $r){
                                        echo '<tr>';
                                            echo '<td>'.$r->pn.'</td>';
                                            echo '<td>'.$r->descricao.'</td>';
                                            echo '<td>'.date("d/m/Y", strtotime($r->data_cadastro)).'</td>';
                                            echo '<td>'.$r->nome.'</td>';
                                            echo '<td><a href="'.base_url().'index.php/peritagem/visualizarcatalogo/'.$r->idCatalogoProduto.'" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a></td>';
                                        echo'</tr>';
                                        }*/
                                        
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
<script type="text/javascript">
    $("#pn").autocomplete({
            source: "<?php echo base_url(); ?>index.php/desenho/autoCompletePN",
            minLength: 1,
            select: function( event, ui ) {

                $('#pn').val(ui.item.pn);
                $('#idProdutos').val(ui.item.id);
                $('#prod').val(ui.item.descricao);
                $('#ref').val(ui.item.referencia);               

            }

        });
    function buscarPn(){
        
        var pn = document.getElementById('pn').value;
        var tipo = document.getElementById('tipo').value;

        
        if(pn === ""){

            alert("Erro! É necessário digitar PN!");

        }else if(tipo === ""){
            alert("Erro! É necessário selecionar o tipo do produto!");
        }else{
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/desenho/findPn2",
                type: 'POST',
                dataType: 'json',
                data: {
                    pn: pn,
                    tipo: tipo
                },
                success: function(data) {
                    
                    if(data.result == true){
                        //console.log(data.pn);
                        preencherTabelaPn(data.resultado,data.tipo)
                    }else{
                        alert(data.msggg);
                    }

                },
                error: function(xhr, textStatus, error) {
                    console.log("4");
                    console.log(xhr.responseText);
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                },
            });

        }

    }

    function preencherTabelaPn(resultado,tipo){
        var table = document.getElementById("table_id").getElementsByTagName('tbody')[0];
        
       
        //tabelaPN.destroy();
        
        
        $('#table_id tbody').empty();
        if(table.rows.length == null || typeof table.rows.length == "undefined"){
            var numOfRows = 0;
        } else {
            var numOfRows = table.rows.length;
        }

        var newRow;
        var botoes = "";
        var campo_vazio = 0;
        var html = "";
        for(x=0;x<resultado.length;x++){
            html += '<tr>';
                html+= '<td>';
                    html += resultado[x].pn;
                html += '</td>';
                html += '<td>';
                    html += resultado[x].descricao;
                html += '</td>';
                html += '<td>';
                    html += tipo;
                html += '</td>';
                html += '<td>';
                    html += ( typeof resultado[x].data_cadastro !== "undefined"?resultado[x].data_cadastro:"");
                html += '</td>';
                html += '<td>';
                if(typeof resultado[x].idCatalogoProduto !== "undefined"){
                    html += '<a href="<?php echo base_url();?>index.php/desenho/visualizarcatalogo/'+resultado[x].idCatalogoProduto+'" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
                }else{
                    html += '<a href="<?php echo base_url();?>index.php/desenho/adicionarcatalogo?idProduto='+resultado[x].idProdutos+'&tipo='+tipo+'" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
                }
                html += '</td>';
            html += '</tr>';
        }
        $("#table_id tbody").append(html);
    }
    
</script>
<!--
<div align='center'>
    <a name="btnGerarCotacao" value = "btnGerarCotacao" class="btn btn-success" href="<?php echo base_url().'index.php/peritagem/adicionarcatalogo' ?>"><i class="icon-plus icon-white"></i>Adicionar Catálogo</a>
</div>-->