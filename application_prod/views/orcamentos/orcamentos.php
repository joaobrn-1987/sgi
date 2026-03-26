<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aOrcamento')){ ?>
    <a href="<?php echo base_url();?>index.php/orcamentos/adicionar" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar Orcamento</a>    
<?php } ?>


<?php
if(!$results){
	
	echo "<br>";
echo "<br>";
?>
 <div class="widget-content nopadding">
                

                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    
                    <div class="tab-content">
                       

                           
                                 
<form class="form-inline" action="<?php echo base_url() ?>index.php/orcamentos" method="post">
 <div class="span12" style="padding: 1%; margin-left: 0">
 <div class="span4" class="control-group">
        Cod. Orc.:<input class="span12 form-control" type="text" name="cod_orc" value="" autofocus>
		</div>
		<div class="span4" class="control-group">
		Cliente:<input id="cliente"  type="text" name="cliente" class="span12" value="" size='50' />
		<input id="clientes_id"  type="hidden" name="clientes_id" value=""  />
		</div>
		<div class="span4" class="control-group">
		Status Orçamento:<select class="span12 form-control" name="idstatusOrcamento">
							<option value=""></option>
                         <?php foreach ($dados_statusorcamento as $o) { ?>
                        <option value="<?php echo $o->idstatusOrcamento; ?>"><?php echo $o->nome_status_orc; ?></option>
                        <?php } ?>
                        </select>
				</div>		
						
						</div>
						<div class="span12" style="padding: 1%; margin-left: 0">
 <div class="span4" class="control-group">
		Grupo Serviço:<select class="form-control" name="idGrupoServico">
                        <option value=""></option>
                        <?php foreach ($dados_gruposervico as $gs) { ?>
                        
                        <option value="<?php echo $gs->idGrupoServico; ?>"><?php echo $gs->nome; ?></option>
                        <?php } ?>
                       
                        </select>
           </div>
		 <div class="span4" class="control-group">  
       Nat. Operação:<select class="form-control" name="idNatOperacao">
                        <option value=""></option>
                        <?php foreach ($dados_natoperacao as $nt) { ?>
                        
                        <option value="<?php echo $nt->idNatOperacao; ?>"><?php echo $nt->nome; ?></option>
                        <?php } ?>
                       
                        </select>
						 </div>
						 
						 <div class="span4" class="control-group"> 
							
			 Status:<select class="form-control" name="status_orc">
                        <option value=""></option>
                        
                        <option value="0">Ativo</option>
                        <option value="1">Excluido</option>
                       
                       
                        </select>				
		</div>
		</div>
		<div class="span12" style="padding: 1%; margin-left: 0">
		 <div class="span2" class="control-group"> 
        Referência: <input id="referencia" type="text" name="referencia" value=""  />
		 </div>
		 <div class="span2" class="control-group"> 
		Num. Pedido:<input id="num_pedido" type="text" name="num_pedido" value=""  />
		 </div>
		 <div class="span2" class="control-group"> 
		Num. Nota Fiscal:<input id="num_nf" type="text" name="num_nf" value=""  />
		 </div>
		 </div>
		  <div class="span12" style="padding: 1%; margin-left: 0">
		 <div class="span6" class="control-group">
                                          
                       
                         Descrição <input id="descricao_item" class="span12" type="text" name="descricao_item" value=""  />
                                        </div> 
                                        </div> 
										
										
		 <div class="span12" style="padding: 1%; margin-left: 0">
                                       
										 <div class="span12" class="control-group">
                                             <br>
                       
                            <input class="btn btn-default" type="submit" name="filter" value="Filtrar">
                                        </div>
										
                                    </div>
									
        
		
    </form>
</div></div></div>



        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-user"></i>
            </span>
            <h5>Orcamentos</h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        
                        <th>Nº Orçamento</th>
                        <th>Cliente</th>
                        <th>Data orçamento</th>
                        <th>Status orçamento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhum Orcamento Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{
echo "<br>";
echo "<br>";	

?>
 
 <div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Filtro Orçamento</h5>
            </div>
            <div class="widget-content nopadding">
                

                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                 
                              <form class="form-inline" action="<?php echo base_url() ?>index.php/orcamentos" method="post">
               

                                   
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3" class="control-group">
                                            <label for="idstatusOrcamento" class="control-label">Cod. Orc.:</label>
                       <input class="span12 form-control" type="text" name="cod_orc" value="" autofocus class="span12">
                       
                                        </div>
										 <div class="span6" class="control-group">
                                            <label for="cliente" class="control-label">Cliente:</label>
                      <input class="span12" class="form-control" id="cliente"  type="text" name="cliente" value=""  />
		<input id="clientes_id"  type="hidden" name="clientes_id" value=""  />
                                        </div>
                                       
                                        <div class="span3" class="control-group">
                                            <label for="idGerente" class="control-label">Status Orçamento:</label>
                        
                       <select class="span12 form-control" name="idstatusOrcamento">
			<option value=""></option>
		 <?php foreach ($dados_statusorcamento as $o) { ?>
		<option value="<?php echo $o->idstatusOrcamento; ?>"><?php echo $o->nome_status_orc; ?></option>
		<?php } ?>
		</select>
										   
                                        </div>

                                        
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">

                                        <div class="span3" class="control-group">
										 <label for="idNatOperacao" class="control-label">Nat. Operação:</label>
                       
                        <select class="span12 form-control" name="idNatOperacao">
                        <option value=""></option>
                        <?php foreach ($dados_natoperacao as $nt) { ?>
                        
                        <option value="<?php echo $nt->idNatOperacao; ?>" ><?php echo $nt->nome; ?></option>
                        <?php } ?>
                       
                        </select>
						                  </div>
                                        <div class="span6" class="control-group">
                                           
                        <label for="referencia" class="control-label">Referência:</label>
                      
                            <input id="referencia" class="span12" type="text" name="referencia" value=""  />
                                        </div>
										
										 <div class="span3" class="control-group">
   <label for="status_orc" class="control-label">Status:</label>                                          
										  <select class="span12 form-control" name="status_orc">
                        <option value=""></option>
                        
                        <option value="0">Ativo</option>
                        <option value="1">Excluido</option>
                       
                       
                        </select>

											</div>

                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
									 <div class="span6" class="control-group">
                                            <label for="num_pedido" class="control-label">PN:</label>
                       <input type="hidden" id="idProdutos" name="idProdutos" size="3"   value=""/>
                            <input id="pn" class="span12" type="text" name="pn" value="" ref="autocomplete" />
                                        </div>
									 
                                        <div class="span2" class="control-group">
                                            <label for="num_pedido" class="control-label">Num. Pedido:</label>
                       
                            <input id="num_pedido" class="span12" type="text" name="num_pedido" value=""  />
                                        </div>
                                        <div class="span2" class="control-group">
                                             
											
                                         <label for="idGrupoServico" class="control-label">Grupo Serviço:</label>
                       
                        <select class="span12 form-control" name="idGrupoServico">
                         <option value=""></option>
                        <?php foreach ($dados_gruposervico as $gs) { ?>
                        
                        <option value="<?php echo $gs->idGrupoServico; ?>" ><?php echo $gs->nome; ?></option>
                        <?php } ?>
                       
                        </select>   
                                        
											 
											 
                                        </div>
										 <div class="span2" class="control-group">
                                             <label for="num_nf" class="control-label">Num. Nota Fiscal:</label>
                       
                            <input id="num_nf" class='span12' type="text" name="num_nf" class="span12" value=""  />
                                        </div>
										
										
                                    </div>
									 <div class="span12" style="padding: 1%; margin-left: 0">
		 <div class="span6" class="control-group">
                                          
                       
                         Descrição <input id="descricao_item" class="span12" type="text" name="descricao_item" value=""  />
                                        </div> 
                                        </div> 
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
        <h5>Orcamentos</h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
        
                        <th>Nº Orçamento</th>
                        <th>Cliente</th>
                        <th>Data orçamento</th>
                        <th>Itens</th>
                        <th>Status orçamento</th>
                        <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
			$color = '';
			
			if($r->status_orc == 1)
			{
				$color = "bgcolor='#fb9d9d'";
			}
			
            echo '<tr>';
            echo '<td '.$color.'>'.$r->idOrcamentos.'</td>';
            echo '<td '.$color.'>'.$r->nomeCliente.'</td>';
            echo '<td '.$color.'>'.date("d/m/Y H:i:s", strtotime($r->data_abertura)).'</td>';
			echo '<td> ';
			 $this->data['results2'] = $this->orcamentos_model->getorc_item($r->idOrcamentos);
		$count = 1;
			foreach ($this->data['results2'] as $orcitem) {
				$this->data['results3'] = $this->orcamentos_model->getos_item($orcitem->idOrcamento_item);
				if(!empty($this->data['results3']))
				{
					if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                        $ositem = '<font color="red"><a target="_blank" href="' . base_url() . 'index.php/os/visualizar/' . $this->data['results3']->idOs . '" style="color: red;" onMouseOver="this.style.color=\'blue\'"
                        onMouseOut="this.style.color=\'red\'"><b> OS:</b>' . $this->data['results3']->idOs .'</a></font>';
                    }else{
                        $ositem = "<font color='red'><b> OS:</b>" . $this->data['results3']->idOs . "</font>";
                    }
				}
				else
				{
					$ositem = '';
				}
				echo "<b>".$count."- </b>".$orcitem->descricao_item.$ositem."<br>";
				$count ++;
			}
			
			echo '</td>';
            echo '<td '.$color.'>'.$r->nome_status_orc.'</td>';
            echo '<td>';
			if($this->permission->checkPermission($this->session->userdata('permissao'),'vOrcamento')){
                echo '<a href="'.base_url().'index.php/orcamentos/visualizar/'.$r->idOrcamentos.'" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>'; 
            }
			
         			if($r->status_orc == 0)
{
            if($this->permission->checkPermission($this->session->userdata('permissao'),'eOrcamento')){
                echo '<a href="'.base_url().'index.php/orcamentos/editar/'.$r->idOrcamentos.'" style="margin-right: 1%" class="btn btn-info tip-top" ><i class="icon-pencil icon-white"></i></a>'; 
            }

			 if($this->permission->checkPermission($this->session->userdata('permissao'),'APOrcamento')){
                echo '<a href="'.base_url().'index.php/orcamentos/aprovar/'.$r->idOrcamentos.'" style="margin-right: 1%" class="btn btn-success tip-top" ><i class="icon-ok icon-white"></i></a>'; 
            }
}
if($r->status_orc == 0)
{	
            if($this->permission->checkPermission($this->session->userdata('permissao'),'dOrcamento')){
                echo '<a href="#modal-excluir" role="button" data-toggle="modal" orc="'.$r->idOrcamentos.'" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a>'; 
            }
}
else
{
	 if($this->permission->checkPermission($this->session->userdata('permissao'),'dOrcamento')){
                echo '<a href="#modal-excluir_editar" role="button" data-toggle="modal" orc2="'.$r->idOrcamentos.'" style="margin-right: 1%" class="btn btn-danger tip-top" ><i class="icon-remove icon-white"></i></a>'; 
            }
}
			
?>

<form action="<?php echo base_url() ?>index.php/orcamentos/orcCustom" method="get" target="_blank">
 <button class="btn btn-inverse tip-top" ><i class="icon-print icon-white"></i></button>
Data:<input type='date' name='dataInicial' value='' class="span5" class="control-group">
<input type='hidden' name='idOrcamentos' value='<?php echo $r->idOrcamentos;?>'>
</form>
<?php
            
            echo '</td>';
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
</div>
</div>
<?php echo $this->pagination->create_links();}?>

<div id="modal-copiar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/orcamentos/copiarorcamento" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Copiar Orçamento</h5>
        </div>
        <div class="modal-body">
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style="margin-left: 0">
                    <div class="span12" id="divCadastrarOs">                                
                        <div class="widget-box" style="margin-top:0px">    
                            <input type="hidden" name="idOrcCopiar" value="<?php echo $result->idOrcamentos; ?>">                                    
                            <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>PN</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach($dados_item as $item){
                                            echo '<tr>';
                                                echo '<td><input type="checkbox" name="copiarOrc[]" value="'.$item->idOrcamento_item.'"></td>';
                                                echo '<td>'.$item->pn.'</td>';
                                                echo '<td>'.$item->descricao_item.'</td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                                                                                                            
                                </tbody>
                            </table>
                        </div>                                
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button class="btn btn-danger" >Confirmar</a>
        </div>
    </form>
</div>

 
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/orcamentos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Desativar orçamento</h5>
  </div>
  <div class="modal-body">
     Motivo:<select class="form-control" name="idMotivo">
                         <option value=""></option>
                        <?php foreach ($dados_motivo as $gs) { ?>
                        
                        <option value="<?php echo $gs->idMotivo; ?>" ><?php echo $gs->motivo; ?></option>
                        <?php } ?>
                       
                        </select> 
    <input type="hidden" id="idorc" name="idorc" value="" />
   
    <h5 style="text-align: center">Deseja realmente desativar este orçamento?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Desativar</button>
  </div>
  </form>
</div>

<!-- Modal -->
<div id="modal-excluir_editar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/orcamentos/excluir" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Desfazer cancelamento de orçamento</h5>
  </div>
  <div class="modal-body">
     <input type="hidden" id="reativar" name="reativar" value="1" />
    <input type="hidden" id="idorc2" name="idorc2" value="" />
    <h5 style="text-align: center">Deseja realmente reativar este orçamento?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Reativar</button>
  </div>
  </form>
</div>




<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {
        
        var orc = $(this).attr('orc');
        $('#idorc').val(orc);

    });
	
	
   $(document).on('click', 'a', function(event) {
        
        var orc2 = $(this).attr('orc2');
        $('#idorc2').val(orc2);

    });

});
$(document).ready(function(){

      $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteCliente",
            minLength: 1,
            select: function( event, ui ) {

                 $("#clientes_id").val(ui.item.id);
                
					//getValor(ui.item.id);

            }
      });
  
     
   
});
$("#pn").autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutos').val(ui.item.id);

		}
	});
</script>
