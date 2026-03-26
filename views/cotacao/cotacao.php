<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>

<?php //echo date("d/m/Y H:i:s");?>
<?php

//if(!$results){
		
?>
<!--

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>OS</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        
                         <th>Nº OS</th>
                        <th>Qtd.</th>
                       <th>Descrição</th>
                        <th>Dimensões</th>
                        <th>OBS</th>
                        <th>Data Cadastro</th>
                        <th>Status</th>
                        <th>Pedido Cotação</th>
                        <th>Pedido Compra</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Item Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
-->
<?php //}else{
//echo "<br>";
//echo "<br>";	

?>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Buscar Item da OS</h5>
            </div>
            <div class="widget-content nopadding">


                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Filtro OS</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">

                                <form class="form-inline" action="<?php echo base_url() ?>index.php/cotacao"
                                    method="post">


                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span4" class="control-group">
                                            <label for="idOs" class="control-label">Cod. OS.:</label>
                                            <input class="form-control" type="text" name="idOs" value="" autofocus
                                                class="span12">

                                        </div>
                                        <div class="span4" class="control-group">
                                            <label for="idPedidoCotacao" class="control-label">Cotaçao:</label>
                                            <input class="form-control" type="text" name="idPedidoCotacao" value=""
                                                class="span12">

                                        </div>

                                        <div class="span4" class="control-group">
                                            <label for="idStatuscompras" class="control-label">Status:</label>

                                            <select class="recebe-solici" class="controls" name="idStatuscompras"
                                                id="idStatuscompras">
                                                <option value="" selected='selected'></option>
                                                <?php foreach ($dados_statuscompra as $so) { ?>

                                                <!-- <option value="<?php echo $so->idStatuscompras; ?>" <?php if($so->idStatuscompras == $result->idStatuscompras){ echo "selected='selected'";}?>><?php echo $so->nomeStatus; ?></option>-->
                                                <option value="<?php echo $so->idStatuscompras; ?>">
                                                    <?php echo $so->nomeStatus; ?></option>
                                                <?php } ?>


                                            </select>
                                        </div>



                                    </div>

									 <?php
									$usuario_temp_restrito = $this->session->userdata('user') ;
									if($usuario_temp_restrito != "suprimentos" && $usuario_temp_restrito != "vagner"){
									 ?>				
										<div class="span12" style="padding: 1%; margin-left: 0">
											<label for="idGrupoServico" class="control-label">Usuarios:</label>
											<table width='100%'>
												<tr>
											 <?php 
											$i = 0;
											foreach ($usuarios_dados as $so) 
											
											{

												?>
													<td>
														<input type="checkbox" name="idUsuarios[]" class='check'
															value="<?php echo $so->idUsuarios; ?>">
														&nbsp;<?php echo $so->user; ?>
													</td>
													<?php 
											if ( ($i+1) % 5 == 0)
													echo "</tr>";
											
											$i++;
											} 											
											
											 ?>


											</table>

										</div>
									 <?php 
									} 
								 	 ?>

                                    <div class="span12" style="padding: 1%; margin-left: 0">

                                        <div class="span12" class="control-group">
                                            <br>

                                            <input class="btn btn-default" type="submit" name="filter" value="Filtrar">
                                        </div>

                                    </div>



                                </form>
                            </div>

                        </div>

                    </div>

                </div>


                .

            </div>

        </div>
    </div>
</div>






<div class="widget-box">
    <div class="widget-title">
        <span class="icon">
            <i class="icon-user"></i>
        </span>
        <h5>Montar cotação</h5>

        <?php //if($this->permission->checkPermission($this->session->userdata('permissao'),'eDistribuirOs')){ ?>

    </div>

    <div class="widget-content nopadding">

        <form class="form-inline" action="<?php echo base_url() ?>index.php/cotacao/montarcotacao" method="post">
            <table class="table table-bordered ">
                <thead>
                    <tr>

                        <th></th>
                        <th>Nº OS</th>
                        <th>Qtd. - Editar</th>
                        <th>Descrição</th>

                        <th>OBS</th>
                        <th>Data Solicitação.</th>
                        <th>Status</th>
                        <th>Cotação</th>
                        <th>Pedido Compra</th>
                        <th>Usuario</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $r) {
						$color = '';	
			
					 ?>
                    	<tr>
							<td>
								<?php if($r->idStatuscompras == 1 || $r->idStatuscompras == 7 ) {
										if($r->idCotacaoItens == null)
										{
								?>
											<?php echo $r->idDistribuir;?>
												<input type='checkbox' value='<?php echo $r->idDistribuir;?>' name='idDistribuir_[]'>
											<?php  
										} 
									};?>
							</td>
							<td>
								<?php echo $r->idOs;?>
							</td>
							<td>
                            	<?php echo $r->quantidade;?>
                            	<?php
								if($r->liberado_edit_compras == 0 )
								{
									if($r->idStatuscompras <> 7)
									{
								 ?>
										<a href="#modal-editar_1" style="margin-right: 1%" role="button" data-toggle="modal"
											id_disti1="<?php echo $r->idDistribuir; ?>" title="Destravar para editar">
											<font color='red'><i class="icon-remove icon-white"></i></font>
										</a>

                             <?php
									}	
								}
								else
								{
							 ?>
									<a href="#modal-editar_0" style="margin-right: 1%" role="button" data-toggle="modal"
										id_disti2="<?php echo $r->idDistribuir;?>" title="Travar edição">
										<font color='blue'><i class="icon-pencil icon-white"></i></font>
									</a>
							 <?php
								}

							 ?>
                        	</td>
							<td>
								<?php echo $r->descricaoInsumo;?>
								<?php echo $r->dimensoes;?>
							</td>

							<td>
								<?php echo $r->obs;?>
							</td>

							<td>
								<?php 
								echo date("d/m/Y H:i:s", strtotime($r->data_cadastro));
									/*if(!empty($r->data_alt))
									{
									echo "<br>"; 
									echo "<b>(".date("d/m/Y H:i:s", strtotime($r->data_alt))."*alteração)</b>";
									}*/
								?>

							</td>
							<td>
								<?php echo $r->nomeStatus;
								if($r->idStatuscompras == 2)
								{
									if($this->permission->checkPermission($this->session->userdata('permissao'),'eCotacao')){
										?>
									<a href="#modal-editaritemcotstatus" style="margin-right: 1%" role="button"
										data-toggle="modal" idCotacaoItens__edista="<?php echo $r->idCotacaoItens;?>"
										class="btn btn-info tip-top" title="Editar status"><i
											class="icon-pencil icon-white"></i></a>
								<?php
					
									}
								}
								?>
							</td>
							<td>
								<?php echo $r->idPedidoCotacao;?>
							</td>

							<td>
								<?php echo $r->idPedidoCompra;?>
							</td>
							<td>

								<?php echo $r->user; ?>
								<!--
								<a href="#modal-usuario<?php echo $r->idCotacaoItens; ?>" style="margin-right: 1%" role="button" data-toggle="modal"  class="btn tip-top" ><i class="icon icon-user"></i></a>-->
							</td>
                         <?php
							echo '<td>';
							if($r->idStatuscompras <> 6)
							{
								if($r->idPedidoCotacao <> '')
								{
									if($this->permission->checkPermission($this->session->userdata('permissao'),'vCotacao')){
										echo '<a href="'.base_url().'index.php/cotacao/visualizarimprimir/'.$r->idPedidoCotacao.'" style="margin-right: 1%" class="btn tip-top"  ><i class="icon-eye-open"></i></a>'; 
									}
								}
							}
			
						  ?>


                        	<?php
            
						echo '</td>';
						echo '<td>';
						if($r->idStatuscompras <> 6)
						{
						if($r->idPedidoCompra == null)
						{
						if($r->idPedidoCotacao <> '')
						{
						if($this->permission->checkPermission($this->session->userdata('permissao'),'eCotacao')){
							?>
									<a href="#modal-editaritemcot" style="margin-right: 1%" role="button" data-toggle="modal"
										idCotacaoItens__edi="<?php echo $r->idCotacaoItens;?>" class="btn btn-info tip-top"><i
											class="icon-pencil icon-white"></i></a>
						 <?php
						
						}
						}
						}
						}
						
						echo '</td>';
						echo '<td>';
						if($r->idPedidoCompra == null)
						{
							if(!empty($r->idCotacaoItens))
							{	 
								if($this->permission->checkPermission($this->session->userdata('permissao'),'dCotacao')){
						 ?>
										<a href="#modal-excluiritemcot" style="margin-right: 1%" role="button" data-toggle="modal"
											idCotacaoItens__="<?php echo $r->idCotacaoItens; ?>" class="btn btn-danger tip-top"><i
												class="icon-remove icon-white"></i></a>
						 <?php							
								}
							}
						}
						echo '</td>';
						echo '</tr>';
						
						 ?>

						<div id="modal-usuario<?php echo $r->idCotacaoItens; ?>" class="modal hide fade" tabindex="-1"
							role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5 id="myModalLabel">Histórico de Usuario</h5>
							</div>
							<div class="modal-body">
								Informação do usuario que cadastrou e sequencia de alterações realizadas:<br>
								<?php echo $r->histo_alteracao; ?>
							</div>


						</div>


					<?php
					}
					?>

					</tr>
                </tbody>
            </table>
            <div class="form-actions" align='center'>

                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Gerar
                    cotação</button>

            </div>
        </form>
    </div>
</div>
<?php echo $this->pagination->create_links();

//}

?>


<div id="modal-editar_1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/cotacao/editar_1" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Liberar item para editar quantidade</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="id_item_pc1" name="id_item_pc1" value="" />


            <h5 style="text-align: center">Deseja realmente liberar este item para edição?</h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Liberar</button>
        </div>
    </form>
</div>
<div id="modal-editar_0" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/cotacao/editar_0" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Travar item para edição de quantidade</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="id_item_pc2" name="id_item_pc2" value="" />

            <h5 style="text-align: center">Deseja travar edição?</h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Confirmar</button>
        </div>
    </form>
</div>
<!-- excluir -->

<div id="modal-excluiritemcot" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/cotacao/excluir_itemcotacao" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Item da Cotação</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idCotacaoItens2" name="idCotacaoItens2" value="" />


            <h5 style="text-align: center">Deseja realmente excluir este item? Ele voltara para status <font
                    color='red'>"COMPRA SOLICITADA"</font>
            </h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Excluir</button>
        </div>
    </form>
</div>

<!-- editar -->

<div id="modal-editaritemcot" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/cotacao/montarcotacao_editar" method="post">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Alterar número da cotação</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idCotacaoItens_edi5" name="idCotacaoItens_edi5" value="" />
            Enviar item para a cotação de número:<input type="text" id="idPedidoCotacao_n2" name="idPedidoCotacao_n2"
                value="" />


        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Salvar</button>
        </div>
    </form>
</div>

<div id="modal-editaritemcotstatus" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/cotacao/montarcotacao_editar_status" method="post">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Alterar status cotação</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idCotacaoItens_edis" name="idCotacaoItens_edis" value="" />
            Alterar Status para <font color='red'>CANCELADO?</font><input type="hidden" id="idStatuscompras_n"
                name="idStatuscompras_n" value="6" />


        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger">Alterar</button>
        </div>
    </form>
</div>

<script type="text/javascript">
$(document).ready(function() {

    $(document).on('click', 'a', function(event) {

        var id_disti1 = $(this).attr('id_disti1');
        $('#id_item_pc1').val(id_disti1);

    });

    $(document).on('click', 'a', function(event) {

        var id_disti2 = $(this).attr('id_disti2');
        $('#id_item_pc2').val(id_disti2);

    });

    $(document).on('click', 'a', function(event) {

        var idCotacaoItens__ = $(this).attr('idCotacaoItens__');
        $('#idCotacaoItens2').val(idCotacaoItens__);

    });

    $(document).on('click', 'a', function(event) {

        var idCotacaoItens__edista = $(this).attr('idCotacaoItens__edista');
        $('#idCotacaoItens_edis').val(idCotacaoItens__edista);

    });



    $(document).on('click', 'a', function(event) {

        var idCotacaoItens__edi = $(this).attr('idCotacaoItens__edi');
        $('#idCotacaoItens_edi5').val(idCotacaoItens__edi);

    });

});

$(document).ready(function() {

    //console.log('#idInsumos2');
    $("#term2").autocomplete({
        source: "<?php echo base_url(); ?>index.php/os/autoCompleteDistribuir",
        minLength: 1,
        select: function(event, ui) {
            $('#idInsumos2').val(ui.item.id);

        }
    });










});
</script>
<div id="modalinserir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Cadastrar Item Almoxarifado</h5>
    </div>
    <div class="modal-body">
        <form action="<?php echo base_url(); ?>index.php/os/cad_distribuir" id="formAlterar"
            enctype="multipart/form-data" method="post" class="form-horizontal">
            <div class="control-group">


                <div class="controls">
                    Descrição <input id="term2" type="text" name="term2" value="" class='span12' />


                    <input id="idOs" type="hidden" name="idOs" value="1" />
                    <input id="almoxarifado" type="hidden" name="almoxarifado" value="1" />
                    <input id="idInsumos2" type="hidden" name="idInsumos2" value="" />
                </div>

                <div class="controls">
                    Quantidade: <input id="quantidade" type="text" name="quantidade" value="" class='span12' />



                </div>

                <div class="controls">
                    Dimensões: <input id="dimensoes" type="text" name="dimensoes" value="" class='span12' />



                </div>

                <div class="controls">
                    OBS <textarea id="obs" rows="5" cols="100" class="span12" name="obs"></textarea>



                </div>


            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
                <button class="btn btn-primary">Cadastrar</button>
            </div>
        </form>
    </div>


</div>