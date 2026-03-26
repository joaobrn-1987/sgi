
<div align='center' style="margin-top: 15px;"><!--
    <a href="#modalinserir" data-toggle="modal" role="button" class="btn btn-warning"><i class="icon-plus icon-white"></i> Cadastrar Materiais OS</a>-->
    <a 'href="#modalDesnvicular" onclick="openModalDesvincular()" data-toggle="modal" role="button" class="btn btn-warning"><i class="icon-link icon-white"></i> Desvincular</a>
</div>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Materiais Reservados</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
					<div class="span12" id="divCadastrarOs">                                
						<div class="widget-box" style="margin-top:0px">                                        
							<table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
								<thead>
									<tr>
                                        <th></th>
                                        <th>O.S.</th>
										<th>Descrição</th>
										<th>Quantidade</th>                                                
										<th>Status O.S.</th> 
										<th>Empresa</th>
										<th>Departamento</th>
										<th>Local</th>
                                        <th></th>
									</tr>
								</thead>
								<tbody>
                                    <?php 
                                        foreach($result as $r){
                                            echo '<tr>';
                                                echo '<td><input type="checkbox" name="itens[]" id="itens" value="'.$r->idAlmoEstoque.'"></td>';
                                                echo '<td>'.$r->idOs.'</td>';
                                                echo '<td>'.$r->descricaoInsumo.'</td>';
                                                echo '<td>'.$r->quantidade.'</td>';
                                                echo '<td>'.$r->nomeStatusOs.'</td>';
                                                echo '<td>'.$r->nome.'</td>';
                                                echo '<td>'.$r->descricaoDepartamento.'</td>';
                                                echo '<td>'.$r->local.'</td>';
                                                echo '<td></td>';
                                            echo '</tr> ';
                                        }
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
<div align='center' style="margin-top: 15px;">
    <a 'href="#modalDesnvicular" onclick="openModalDesvincular()" data-toggle="modal" role="button" class="btn btn-warning"><i class="icon-plus icon-white"></i> Desvincular</a>
</div>

<div id="modalDesnvicular" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/almoxarifado/confirmardesvinculacao" id="formCadastrarSubOs" enctype="multipart/form-data" method="post" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Confirmar Desvinculação</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid" style="margin-top:0">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon">
                                <i class="icon-tags"></i>
                            </span>
                            <h5>Itens Selecionados</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                                <div class="span12" id="divCadastrarOs">                                
                                    <div class="widget-box" style="margin-top:0px">                                        
                                        <table class="table table-bordered " id="tableItensSelecionados">
                                            <thead>
                                                <tr>
                                                    <th>O.S.</th>
                                                    <th>Descrição</th>
                                                    <th>Quantidade</th>                                                
                                                    <th>Status O.S.</th> 
                                                </tr>
                                            </thead>
                                            <tbody>                                                                                    
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
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
            <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
    
</div>
<script type="text/javascript">
    function openModalDesvincular(){
        var listCheckbox = Array.apply(null,document.querySelectorAll("#itens"));
        var table = document.getElementById("tableItensSelecionados").getElementsByTagName('tbody')[0];
		$(table).empty();
        for(x=0;x<listCheckbox.length;x++){
			if(listCheckbox[x].checked){
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/almoxarifado/getInfoAlmoEstoque",
					type: 'POST',
					dataType: 'json',
					data: {
						idAlmoEstoque:listCheckbox[x].value
					},
					success: function(data) {
						if(data.result){
                            adicionarDadosModal(data.resultado[0])
                        }
					},
					error: function(xhr, textStatus, error) {
						console.log(xhr.responseText);
						console.log(xhr.statusText);
						console.log(textStatus);
						console.log(error);
					},
				})
			}			
		}
        
		$('#modalDesnvicular').modal('show');
    }

    function adicionarDadosModal(dados){
        var html="";
        html += "<tr>";
            html += "<td>";
				html += '<input type="hidden" name="idAlmoEstoqueCheck[]" value="'+dados.idAlmoEstoque+'"/>';
				html += dados.idOs
			html += "</td>";
            html += "<td>";
				html += dados.descricaoInsumo
			html += "</td>";
            html += "<td>";
				html += dados.quantidade
			html += "</td>";
            html += "<td>";
				html += dados.nomeStatusOs
			html += "</td>";
        html += "</tr>";
        var table = document.getElementById("tableItensSelecionados").getElementsByTagName('tbody')[0];
		$(table).append(html);
    }
</script>