<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<?php

  

$data=date("d-m-y");

 $hora = date("H:i:s");?>
 <body onLoad="calculaSubTotal();" >

			
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Editar OS</h5>
				 <div class="buttons">
                    
                   
                    <a title="Imprimir" class="btn btn-mini btn-inverse" href="<?php echo base_url() ?>index.php/os/imprimir_osproducao/<?php echo $result->idOs; ?>" target="_blank"><i class="icon-print icon-white"></i> Imprimir</a>
                </div>
            </div>
            <div class="widget-content nopadding">


                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da OS</a></li>
                        <li id="tabProdutos"><a href="#tab2" data-toggle="tab">Anexo NF</a></li>
                        <li id="tabServicos"><a href="#tab3" data-toggle="tab">Insumos</a></li>
                        <!--<li id="tabAnexos"><a href="#tab4" data-toggle="tab">Anexos</a></li>-->
                    </ul>
                    <div class="tab-content">
                        
								
			
			
<div class="tab-pane active" id="tab1">			
<form action="<?php echo base_url() ?>index.php/os/editaros" method="post" >			
<div class="span12 well" style="padding: 1%; margin-left: 0">		
<div class="span2"  class="control-group">
<label for="item" class="control-label">Cod. OS: <?php echo $result->idOs; ?></label>
</div>
<div class="span3"  class="control-group">
<label for="item" class="control-label">Cliente: <?php echo $orcamento->nomeCliente; ?></label>
</div>	
<div class="span3"  class="control-group">
<label for="item" class="control-label">Orçamento: <?php echo $result->idOrcamentos; ?></label>
</div>
<div class="span3"  class="control-group">
<label for="item" class="control-label">Data O.S.: 

<input id="data_abertura_editada" class="span6 data" type="text" name="data_abertura_editada" value="<?php echo date("d/m/Y", strtotime($result->data_abertura_editada));  ?>" onclick="this.select();"/>

<input id="idOs2" type="hidden" name="idOs2" value="<?php echo $result->idOs; ?>"  />
<input id="idOrcamento_item" type="hidden" name="idOrcamento_item" value="<?php echo $result->idOrcamento_item; ?>"  />

</div>
				
</div>			
			 
<div class="span12 well" style="padding: 1%; margin-left: 0">	
<div class="span1"  class="control-group">
	<label for="item" class="control-label">Qtd.:</label>
	<input id="qtd_os" class="span12" type="text" onKeyUp="calculaSubTotal();" onclick="this.select();" name="qtd_os" value="<?php echo $result->qtd_os; ?>" />
	<input id="qtd_os_original" type="hidden" name="qtd_os_original" value="<?php echo $result->qtd_os; ?>" />
	<input id="data_abertura" type="hidden" name="data_abertura" value="<?php echo $result->data_abertura; ?>" />
	<input id="idOrcamentos" type="hidden" name="idOrcamentos" value="<?php echo $result->idOrcamentos; ?>" />
	<input id="obs_controle" type="hidden" name="obs_controle" value="<?php echo $result->obs_controle; ?>" />
	<input id="obs_os" type="hidden" name="obs_os" value="<?php echo $result->obs_os; ?>" />


</div>
<div class="span4"  class="control-group">
	<label for="item" class="control-label">Descrição:</label>
	<input id="descricao_os" class="span12" type="text" onclick="this.select();" name="descricao_os" value="<?php echo $itens_orcamento->descricao_item; ?>" />
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">PN:</label>
	 <?php echo $itens_orcamento->pn;?>
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Data Entrega:</label>
	
	<input id="data_entrega" class="span12 data" type="text" name="data_entrega" value="<?php echo date("d/m/Y", strtotime($result->data_entrega));  ?>" onclick="this.select();"/>
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Data Reprog.:</label>
	<input id="data_reagendada" class="span12 data" onclick="this.select();" type="text" name="data_reagendada" value="<?php if($result->data_reagendada <> '') { echo date("d/m/Y", strtotime($result->data_reagendada)); } ?>" />
</div>

</div>

<div class="span12 well" style="padding: 1%; margin-left: 0">	
<div class="span4"  class="control-group">
	<label for="item" class="control-label">Status:</label>
	 <select class="form-control" name="idStatusOs">
                        
                        <?php foreach ($status_os as $gs) { ?>
                        
<option value="<?php echo $gs->idStatusOs; ?>" <?php if($gs->idStatusOs == $result->idStatusOs){ echo "selected='selected'";}?>><?php echo $gs->nomeStatusOs; ?></option>
                        <?php } ?>
                       
                        </select>  
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Natureza Op.:</label>
	<?php echo $dados_natoperacao->nome; ?>
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Unid. Exec.:</label>
	<select class="form-control" name="unid_execucao">
                        
                        <?php foreach ($unid_exec as $exec) { ?>
                        
<option value="<?php echo $exec->id_unid_exec; ?>" <?php if($exec->id_unid_exec == $result->unid_execucao){ echo "selected='selected'";}?>><?php echo $exec->status_execucao; ?></option>
                        <?php } ?>
                       
                        </select>  
						
	
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Unid. Fat.:</label>
	<select class="form-control" name="unid_faturamento">
                        
                        <?php foreach ($unid_fat as $fat) { ?>
                        
<option value="<?php echo $fat->id_unid_fat; ?>" <?php if($fat->id_unid_fat == $result->unid_faturamento){ echo "selected='selected'";}?>><?php echo $fat->status_faturamento; ?></option>
                        <?php } ?>
                       
                        </select> 
						
	 
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Contrato:</label>
	 <select name="contrato">
					  <option value="Não" <?php if($result->contrato == "Não"){ echo "selected='selected'";}?>>Não</option>
					  <option value="Sim" <?php if($result->contrato == "Sim"){ echo "selected='selected'";}?>>Sim</option>
					  </select>
</div>



</div>


<?
if($this->permission->checkPermission($this->session->userdata('permissao'),'vvalorOs')){
?>
<div class="span12 well" style="padding: 1%; margin-left: 0">	

<div class="span2"  class="control-group">
	<label for="item" class="control-label">Vlr. Unit.:</label>
	<input id="val_unit_os" class="span12" onKeyUp="calculaSubTotal();" onclick="this.select();" type="text" name="val_unit_os" onKeyPress="FormataValor2(this,event,10,2);" value="<?php echo number_format($result->val_unit_os, 2, ",", ".");  ?>" />
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Desconto:</label>
	<input id="desconto_os" onKeyPress="FormataValor2(this,event,10,2);" class="span12" onKeyUp="calculaSubTotal();" onclick="this.select();" type="text" name="desconto_os" value="<?php echo number_format($result->desconto_os, 2, ",", "."); ?>" />
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">IPI:</label>
	<input id="val_ipi_os" onKeyPress="FormataValor2(this,event,10,2);" class="span12" onKeyUp="calculaSubTotal();" onclick="this.select();" type="text" name="val_ipi_os" value="<?php echo number_format($result->val_ipi_os, 2, ",", ".") ; ?>" />
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Sub. Total:</label>
	<input id="subtot_os" class="span12" type="text" readonly="true" name="subtot_os" value="<?php echo number_format($result->subtot_os, 2, ",", ".") ; ?>" />
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Total:</label>
	<input id="total" class="span12" type="text" name="total" value="" readonly="true"/>
</div>
</div>
<?
}
?>
 <div class="span12 well" style="padding: 1%; margin-left: 0">	
<!--<div class="span12" style="padding: 1%">-->
<div class="span3"  class="control-group">
	<label for="item" class="control-label">Num. Pedido
	</label>
<input id="numpedido_os" class="span12" type="text" name="numpedido_os" value="<?php echo $result->numpedido_os; ?>" />

	
</div>

<div class="span3"  class="control-group">
	<label for="item" class="control-label"> Nº. NF | Data Fat.
	
	</label>
<input id="numero_nf" class="span5" type="text" name="numero_nf" value="<?php echo $result->numero_nf; ?>" /> |
<input id="data_nf_faturamento" class="span6 data" type="text" name="data_nf_faturamento" value="<?php if($result->data_nf_faturamento <> '') { echo date("d/m/Y", strtotime($result->data_nf_faturamento));} ?>" /><br>
	
</div>
<div class="span3"  class="control-group">
	<label for="item" class="control-label"> NF Cliente
	</label>
<input id="nf_cliente" class="span12" type="text" name="nf_cliente" value="<?php echo $result->nf_cliente; ?>" />

	
</div>
<div class="span3"  class="control-group">
	<label for="item" class="control-label">NF Dev.| Fabricaçao
	<?
	
	?></label>
<input id="nf_venda_dev" class="span12" type="text" name="nf_venda_dev" value="<?php echo $result->nf_venda_dev; ?>" />


	
</div>
</div>
<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
	?>
                       
                    
<div class="form-actions" align='center'>
                        
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Alterar</button>
                               
                           
                    </div> 
		
	<?
} ?>	
                             
</form>	


<div class="span12" style="padding: 1%">
<div class="span2"  class="control-group">
<?php
$obs = $result->obs_os;
if($obs == '')
{
	$font='#000000';
}
else
{
	
	$font='red';
}


?>
	<label for="item" class="control-label"><font color='<?php echo $font;?>'>OBS OS</font></label>
	<?
if($this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
?>
	<a href="#modalAlteraros<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a>
	<?
}
?>
	<a href="#modalveros<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn tip-top"><i class="icon-eye-open"></i></a>
	
	

	
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">OBS Controle</label>
	
	<?
if($this->permission->checkPermission($this->session->userdata('permissao'),'eobscontroleOS')){
?>
	<a href="#modalAlterarcontroleos<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a>
	<?
}
if($this->permission->checkPermission($this->session->userdata('permissao'),'vobscontroleOS')){
?>
	<a href="#modalvercontroleos<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn tip-top"><i class="icon-eye-open"></i></a>
	
<?
}
?>	




	
</div>
<div class="span2"  class="control-group">
	<label for="item" class="control-label">Detalhe Serviço</label>
	<a href="#modalverdetalheos<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn tip-top"><i class="icon-eye-open"></i></a>
	

	
</div>
<?
if($this->permission->checkPermission($this->session->userdata('permissao'),'vdesenhoOs')){
?>

	<?
if($this->permission->checkPermission($this->session->userdata('permissao'),'adesenhoOs')){
?>

<a href="#modal_cad_desenho<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span1"><i class="icon-plus icon-white"></i> </a>

	<?
}
?>
<div class="span4"  class="control-group">
	<label for="item" >Desenho OS 

</label>
<br>
<?
 foreach ($anexo_desenho as $desenho) {
	 
	 
 if($this->permission->checkPermission($this->session->userdata('permissao'),'adesenhoOs')){
?>
<a href="#modalAlteraranexo<?php echo $desenho->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>
	 
                       
                   
                         <a href="#modal-excluir<?php echo $desenho->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $desenho->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir desenho"><i class="icon-remove icon-white"></i></a>
                    <?
					}
					?>
					<a href='<?php echo base_url().$desenho->caminho.$desenho->imagem;?>' target='_blank'><?php echo $desenho->nomeArquivo.$desenho->extensao;?></a>
					<?
					echo "<br>";
?>
<div id="modalAlteraranexo<?php echo $desenho->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar Desenho OS:<?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/editar_anexo" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
						
						
                   
        <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $desenho->nomeArquivo; ?>"  />
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                            <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $desenho->idAnexo; ?>"  />
                        </div>
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button>
  </div>
     </form>
  </div>
 
 
</div>
<div id="modal-excluir<?php echo $desenho->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/os/excluiranexo" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir Arquivo</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idAnexo" name="idAnexo" value="<?php echo $desenho->idAnexo; ?>" />
    <input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
    <input type="hidden" id="imagem" name="imagem" value="<?php echo $desenho->imagem; ?>" />
    <h5 style="text-align: center">Deseja realmente excluir este arquivo?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>
<?					
 }
					?>
					
</div>


<?
}
?>

	
</div>

</div><!-- div principal ao entrar -->



 <div class="tab-pane" id="tab2">
 <div class="span12 well" style="padding: 1%; margin-left: 0">	
<!--<div class="span12" style="padding: 1%">-->
<div class="span3"  class="control-group">
	<label for="item" class="control-label">Num. Pedido: <?php echo $result->numpedido_os; ?>
	<?
	if($this->permission->checkPermission($this->session->userdata('permissao'),'apedidoOs')){
		?>
		<a href="#modal_cad_pedido<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span1"> <i class="icon-plus icon-white"> </i> </a>
		<?
	}
	?></label>
<br>


<?
 foreach ($anexo_pedido as $pedido) {
	 
	 
 if($this->permission->checkPermission($this->session->userdata('permissao'),'apedidoOs')){
?>
<a href="#modalAlterarpedido<?php echo $pedido->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>
	 
                       
                   
                         <a href="#modal-excluirpedido<?php echo $pedido->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $pedido->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir pedido"><i class="icon-remove icon-white"></i></a>
                    <?
					}
					
if($this->permission->checkPermission($this->session->userdata('permissao'),'vpedidoOs')){

?>
					<a href='<?php echo base_url().$pedido->caminho.$pedido->imagem;?>' target='_blank'><?php echo $pedido->nomeArquivo.$pedido->extensao;?></a>
					<?
 }
					echo "<br>";
?>
<div id="modalAlterarpedido<?php echo $pedido->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar pedido OS:<?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/editar_pedido" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
						
						
                   
        <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $pedido->nomeArquivo; ?>"  />
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                            <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $pedido->idAnexo; ?>"  />
                        </div>
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button>
  </div>
     </form>
  </div>
 
 
</div>
<div id="modal-excluirpedido<?php echo $pedido->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/os/excluirpedido" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir pedido</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idAnexo" name="idAnexo" value="<?php echo $pedido->idAnexo; ?>" />
    <input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
	<input type="hidden" id="imagem" name="imagem" value="<?php echo $pedido->imagem; ?>" />
    <h5 style="text-align: center">Deseja realmente excluir este pedido?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>
<?					
 }
					?>



	
</div>

<div class="span3"  class="control-group">
	<label for="item" class="control-label"> Num. Nota Fiscal: <?php echo $result->numero_nf; ?>
	<?
	if($this->permission->checkPermission($this->session->userdata('permissao'),'anotafiscalOs')){
		?>
		<a href="#modal_cad_nf<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span1"> <i class="icon-plus icon-white"> </i> </a>
		<?
	}
	?></label>
<br>


<?
 foreach ($anexo_nf as $nf) {
	 
	 
 if($this->permission->checkPermission($this->session->userdata('permissao'),'anotafiscalOs')){
?>
<a href="#modalAlterarnf<?php echo $nf->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>
	 
                       
                   
                         <a href="#modal-excluirnf<?php echo $nf->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $nf->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir NF"><i class="icon-remove icon-white"></i></a>
                    <?
					}
					
if($this->permission->checkPermission($this->session->userdata('permissao'),'vnotafiscalOs')){

?>
					<a href='<?php echo base_url().$nf->caminho.$nf->imagem;?>' target='_blank'><?php echo $nf->nomeArquivo.$nf->extensao;?></a>
					<?
 }
					echo "<br>";
?>
<div id="modalAlterarnf<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar NF OS:<?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/editar_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
						
						
                   
        <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $nf->nomeArquivo; ?>"  />
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                            <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $nf->idAnexo; ?>"  />
                            <input id="table" type="hidden" name="table" value="anexo_notafiscal"  />
                        </div>
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button>
  </div>
     </form>
  </div>
 
 
</div>
<div id="modal-excluirnf<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/os/excluirnf" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir NF</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idAnexo" name="idAnexo" value="<?php echo $nf->idAnexo; ?>" />
    <input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
	 <input type="hidden" id="table" name="table" value="anexo_notafiscal" />
	 	<input type="hidden" id="imagem" name="imagem" value="<?php echo $nf->imagem; ?>" />
    <h5 style="text-align: center">Deseja realmente excluir esta NF?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>
<?					
 }
					?>



	
</div>
<div class="span3"  class="control-group">
	<label for="item" class="control-label"> NF Cliente: <?php echo $result->nf_cliente; ?> 
	<?
	if($this->permission->checkPermission($this->session->userdata('permissao'),'anotafiscalOs')){
		?>
		<a href="#modal_cad_nf_cli<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span1"> <i class="icon-plus icon-white"> </i> </a>
		<?
	}
	?></label>
<br>


<?
 foreach ($anexo_nfcliente as $nf) {
	 
	 
 if($this->permission->checkPermission($this->session->userdata('permissao'),'anotafiscalOs')){
?>
<a href="#modalAlterarnf_cli<?php echo $nf->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>
	 
                       
                   
                         <a href="#modal-excluirnfcli<?php echo $nf->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $nf->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir NF"><i class="icon-remove icon-white"></i></a>
                    <?
					}
					
if($this->permission->checkPermission($this->session->userdata('permissao'),'vnotafiscalOs')){

?>
					<a href='<?php echo base_url().$nf->caminho.$nf->imagem;?>' target='_blank'><?php echo $nf->nomeArquivo.$nf->extensao;?></a>
					<?
 }
					echo "<br>";
?>
<div id="modalAlterarnf_cli<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar NF Cliente OS:<?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/editar_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
						
						
                   
        <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $nf->nomeArquivo; ?>"  />
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                         <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $nf->idAnexo; ?>"  />
						 <input id="table" type="hidden" name="table" value="anexo_nfcliente"  />
                        </div>
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button>
  </div>
     </form>
  </div>
 
 
</div>
<div id="modal-excluirnfcli<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/os/excluirnf" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir NF Cliente</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idAnexo" name="idAnexo" value="<?php echo $nf->idAnexo; ?>" />
    <input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
	<input type="hidden" id="imagem" name="imagem" value="<?php echo $nf->imagem; ?>" />
   <input id="table" type="hidden" name="table" value="anexo_nfcliente"  />
    <h5 style="text-align: center">Deseja realmente excluir esta NF de cliente?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>
<?					
 }
					?>



	
</div>
<div class="span3"  class="control-group">
	<label for="item" class="control-label">NF Dev.| Fabricaçao: <?php echo $result->nf_venda_dev; ?>
	<?
	if($this->permission->checkPermission($this->session->userdata('permissao'),'anotafiscalOs')){
		?>
		<a href="#modal_cad_nf_dev<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span1"> <i class="icon-plus icon-white"> </i> </a>
		<?
	}
	?></label>
<br>


<?
 foreach ($anexo_nfvenda as $nf) {
	 
	 
 if($this->permission->checkPermission($this->session->userdata('permissao'),'anotafiscalOs')){
?>
<a href="#modalAlterarnfdev<?php echo $nf->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>
	 
                       
                   
                         <a href="#modal-excluirnf<?php echo $nf->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $nf->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir NF"><i class="icon-remove icon-white"></i></a>
                    <?
					}
					
if($this->permission->checkPermission($this->session->userdata('permissao'),'vnotafiscalOs')){

?>
					<a href='<?php echo base_url().$nf->caminho.$nf->imagem;?>' target='_blank'><?php echo $nf->nomeArquivo.$nf->extensao;?></a>
					<?
 }
					echo "<br>";
?>
<div id="modalAlterarnfdev<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar NF OS:<?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/editar_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
						
						
                   
        <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $nf->nomeArquivo; ?>"  />
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                            <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $nf->idAnexo; ?>"  />
							<input id="table" type="hidden" name="table" value="anexo_nfvenda"  />
                        </div>
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button>
  </div>
     </form>
  </div>
 
 
</div>
<div id="modal-excluirnf<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?php echo base_url() ?>index.php/os/excluirnf" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Excluir NF</h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idAnexo" name="idAnexo" value="<?php echo $nf->idAnexo; ?>" />
    <input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
	<input type="hidden" id="imagem" name="imagem" value="<?php echo $nf->imagem; ?>" />
	<input id="table" type="hidden" name="table" value="anexo_nfvenda"  />
    <h5 style="text-align: center">Deseja realmente excluir esta NF?</h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-danger">Excluir</button>
  </div>
  </form>
</div>
<?					
 }
					?>



	
</div>
</div>
</div><!-- fecha div aba de anexo -->
		
            <!--<div class="widget-content" id="printOs">
                <div class="invoice-content">
                  ddd
              
                </div>
            </div>-->
              </div>

                </div>


.

        </div>

    </div>
</div>
</div>



<!-- Modal detalhe do serviço -->
<div id="modalverdetalheos<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Detalhe Serviço OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
     <?php echo nl2br($itens_orcamento->detalhe); ?>
  </div>
 
 
</div> 
<!-- Modal ver obs -->
<div id="modalveros<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Observação OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
  

    <?php echo nl2br($result->obs_os); ?>
  </div>
 
 
</div>
<div id="modalAlteraros<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar Observação OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/editaobs_os" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="obs_os" class="control-label">Observação OS<span class="required">*</span></label>
                        <div class="controls">
						<textarea id="obs_os" rows="5" cols="50" class="span10" name="obs_os"><?php echo $result->obs_os; ?></textarea>
						
                   
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                        </div>
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button>
  </div>
     </form>
  </div>
 
</div>


<!-- Modal ver controle obs os -->
<div id="modalvercontroleos<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Observação Controle OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
  <?php echo nl2br($result->obs_controle); ?>
    
  </div>
 
 
</div>
<div id="modalAlterarcontroleos<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Alterar Observação Controle OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/editaobs_os" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="obs_controle" class="control-label">Observação Controle OS<span class="required">*</span></label>
                        <div class="controls">
						<textarea id="obs_controle" rows="5" cols="50" class="span10" name="obs_controle"><?php echo $result->obs_controle; ?></textarea>
						
                   
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                        </div>
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Alterar</button>
  </div>
     </form>
  </div>
 
 
</div>

<!-- cadastgrar desenho -->
<div id="modal_cad_desenho<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Cadastrar Desenho OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/cad_desenho" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="obs_controle" class="control-label">Nome arquivo</label>
                        <div class="controls">
						 <input id="nomeArquivo" type="text" name="nomeArquivo" value=""  />
						
                   
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                        </div>
						
						 <label for="arquivo" class="control-label"><span class="required">Arquivo</span></label>
                        <div class="controls">
                            <input id="arquivo" type="file" name="userfile" /> 
                        </div>
						
						
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Cadastrar</button>
  </div>
     </form>
  </div>
 
 
</div>

<!-- cadastgrar pedido -->
<div id="modal_cad_pedido<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Cadastrar Pedido OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/cad_pedido" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="obs_controle" class="control-label">Nome arquivo</label>
                        <div class="controls">
						 <input id="nomeArquivo" type="text" name="nomeArquivo" value=""  />
						
                   
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                        </div>
						
						 <label for="arquivo" class="control-label"><span class="required">Arquivo</span></label>
                        <div class="controls">
                            <input id="arquivo" type="file" name="userfile" /> 
                        </div>
						
						
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Cadastrar</button>
  </div>
     </form>
  </div>
 
 
</div>

<!-- cadastgrar nf -->
<div id="modal_cad_nf<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Cadastrar Nota Fiscal OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/cad_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="obs_controle" class="control-label">Nome arquivo</label>
                        <div class="controls">
						 <input id="nomeArquivo" type="text" name="nomeArquivo" value=""  />
						
                    <input id="table" type="hidden" name="table" value="anexo_notafiscal"  />
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                        </div>
						
						 <label for="arquivo" class="control-label"><span class="required">Arquivo</span></label>
                        <div class="controls">
                            <input id="arquivo" type="file" name="userfile" /> 
                        </div>
						
						
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Cadastrar</button>
  </div>
     </form>
  </div>
 
 
</div>


<!-- cadastgrar nf -->
<div id="modal_cad_nf_cli<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Cadastrar NF Cliente OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/cad_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="obs_controle" class="control-label">Nome arquivo</label>
                        <div class="controls">
						 <input id="nomeArquivo" type="text" name="nomeArquivo" value=""  />
						
                   
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                            <input id="table" type="hidden" name="table" value="anexo_nfcliente"  />
                        </div>
						
						 <label for="arquivo" class="control-label"><span class="required">Arquivo</span></label>
                        <div class="controls">
                            <input id="arquivo" type="file" name="userfile" /> 
                        </div>
						
						
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Cadastrar</button>
  </div>
     </form>
  </div>
 
 
</div>


<!-- cadastgrar nf -->
<div id="modal_cad_nf_dev<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel">Cadastrar Nota Fiscal OS: <?php echo $result->idOs; ?></h5>
  </div>
  <div class="modal-body">
   <form action="<?php echo base_url(); ?>index.php/os/cad_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal" >
   <div class="control-group">
                        <label for="obs_controle" class="control-label">Nome arquivo</label>
                        <div class="controls">
						 <input id="nomeArquivo" type="text" name="nomeArquivo" value=""  />
						
                    <input id="table" type="hidden" name="table" value="anexo_nfvenda"  />
                            <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>"  />
                        </div>
						
						 <label for="arquivo" class="control-label"><span class="required">Arquivo</span></label>
                        <div class="controls">
                            <input id="arquivo" type="file" name="userfile" /> 
                        </div>
						
						
                    </div>
					  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
    <button class="btn btn-primary">Cadastrar</button>
  </div>
     </form>
  </div>
 
 
</div>
<script type="text/javascript">
$(document).ready(function(){
	
jQuery(".data").mask("99/99/9999");
   });
   

$(function() {
   $(document).on('click', 'input[type=text][id=example1]', function() {
     this.select();
   });
 });


function calculaSubTotal(){
	
	var qtd = $('#qtd_os').val();
	var qtd_os_original = $('#qtd_os_original').val();
		if(qtd < qtd_os_original)
		{
			alert('Atenção, você alterou a qtd de itens, será gerada nova OS!');
		}
  
		
		//alert(contador_global_autocomplete);
			var valorunit = $('#val_unit_os').val();
			valorunit = valorunit.toString().replace( ".", "" );
			valorunit = valorunit.toString().replace( ",", "." );
		
			valorunit=parseFloat(valorunit);	
			
			/*valorunit=	valorunit.replace(/\./g, "");
			valorunit=	valorunit.replace(/,/g, ".");*/
			
			var desconto = $('#desconto_os').val();
			desconto = desconto.toString().replace( ".", "" );
			desconto = desconto.toString().replace( ",", "." );
			/*desconto=	desconto.replace(/\./g, "");
			desconto=	desconto.replace(/,/g, ".");*/
			
			desconto=parseFloat(desconto);	
			
			var valoripi = $('#val_ipi_os').val();
			valoripi = valoripi.toString().replace( ".", "" );
			valoripi = valoripi.toString().replace( ",", "." );
			/*desconto=	desconto.replace(/\./g, "");
			desconto=	desconto.replace(/,/g, ".");*/
			
			valoripi=parseFloat(valoripi);	
			//valoripi=valoripi+'';
	/*if(valoripi.indexOf('.')<0)
	{ 
		valoripi=valoripi+".00";
	}
	else
	{ 
		dp_impostoex=valoripi.split(".");
		if(dp_impostoex[1].length==1)
		{
			valoripi=valoripi+"0";
		}
		else if(dp_impostoex[1].length>=2)
		{
			dp_impostoexex=dp_impostoex[1].split("");
			campo0=parseInt(dp_impostoexex[0]);
			campo1=parseInt(dp_impostoexex[1]);
			campo2=parseInt(dp_impostoexex[2]);
			//if(campo2>5){ campo1++; }
			valoripi=dp_impostoex[0]+'.'+campo0+campo1;
		}
	}*/
			
			
			
			
			
			
			
			//var total = ((valorunit * qtd) - desconto) *  valoripi / 100;
			var total1 = (valorunit * qtd);
			var total2 = total1 * valoripi/100;
			
			total1=parseFloat(total1);	
			total2=parseFloat(total2);	
			var total3 = total1 + total2 - desconto;
			
			total3=parseFloat(total3);	
			
			
			
			//alert(total3);
			
			$('#subtot_os').val(retorna_formatado(total1));
			$('#total').val(retorna_formatado(total3));
			
			 
			   
			

	
	
}
function retorna_formatado(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }

   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));

   ret = num + ',' + cents;

   if (x == 1) ret = ' - ' + ret;return ret;

}


function FormataValor2(objeto, teclapres, tammax, decimais) {
	var tecla			= teclapres.keyCode;
	var tamanhoObjeto	= objeto.value.length;

	

	if ((tecla == 8) && (tamanhoObjeto == tammax))
		tamanhoObjeto = tamanhoObjeto - 1 ;



	if (( tecla == 8 || tecla == 88 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ) && ((tamanhoObjeto+1) <= tammax)) {
		
		vr	= objeto.value;
		vr	= vr.replace( "/", "" );
		vr	= vr.replace( "/", "" );
		vr	= vr.replace( ",", "" );
		vr	= vr.replace( ".", "" );
		vr	= vr.replace( ".", "" );
		vr	= vr.replace( ".", "" );
		vr	= vr.replace( ".", "" );
		tam	= vr.length;
		
		if (tam < tammax && tecla != 8)
			tam = vr.length + 1 ;

		if ((tecla == 8) && (tam > 1)){
			tam = tam - 1 ;
			vr = objeto.value;
			vr = vr.replace( "/", "" );
			vr = vr.replace( "/", "" );
			vr = vr.replace( ",", "" );
			vr = vr.replace( ".", "" );
			vr = vr.replace( ".", "" );
			vr = vr.replace( ".", "" );
			vr = vr.replace( ".", "" );
			}
	
		//Cálculo para casas decimais setadas por parametro
		if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ) {
			if (decimais > 0) {
				if ( (tam <= decimais) )
					objeto.value = ("0," + vr) ;
					
				if( (tam == (decimais + 1)) && (tecla == 8))
					objeto.value = vr.substr( 0, (tam - decimais)) + ',' + vr.substr( tam - (decimais), tam ) ;	
					
				if ( (tam > (decimais + 1)) && (tam <= (decimais + 3)) &&  ((vr.substr(0,1)) == "0"))
					objeto.value = vr.substr( 1, (tam - (decimais+1))) + ',' + vr.substr( tam - (decimais), tam ) ;
					
				if ( (tam > (decimais + 1)) && (tam <= (decimais + 3)) &&  ((vr.substr(0,1)) != "0"))
				    objeto.value = vr.substr( 0, tam - decimais ) + ',' + vr.substr( tam - decimais, tam ) ; 
					
				if ( (tam >= (decimais + 4)) && (tam <= (decimais + 6)) )
			 		objeto.value = vr.substr( 0, tam - (decimais + 3) ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

			 	if ( (tam >= (decimais + 7)) && (tam <= (decimais + 9)) )
			 		objeto.value = vr.substr( 0, tam - (decimais + 6) ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

				if ( (tam >= (decimais + 10)) && (tam <= (decimais + 12)) )
			 		objeto.value = vr.substr( 0, tam - (decimais + 9) ) + '.' + vr.substr( tam - (decimais + 9), 3 ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

				if ( (tam >= (decimais + 13)) && (tam <= (decimais + 15)) )
			 		objeto.value = vr.substr( 0, tam - (decimais + 12) ) + '.' + vr.substr( tam - (decimais + 12), 3 ) + '.' + vr.substr( tam - (decimais + 9), 3 ) + '.' + vr.substr( tam - (decimais + 6), 3 ) + '.' + vr.substr( tam - (decimais + 3), 3 ) + ',' + vr.substr( tam - decimais, tam ) ;

			}
			else if(decimais == 0) {
				if ( tam <= 3 )
			 		objeto.value = vr ;
					
				if ( (tam >= 4) && (tam <= 6) ) {
					if(tecla == 8) {
						objeto.value = vr.substr(0, tam);
						window.event.cancelBubble = true;
						window.event.returnValue = false;
						}
					objeto.value = vr.substr(0, tam - 3) + '.' + vr.substr( tam - 3, 3 ); 
					}
					
				if ( (tam >= 7) && (tam <= 9) ) {
					if(tecla == 8) {
						objeto.value = vr.substr(0, tam);
						window.event.cancelBubble = true;
						window.event.returnValue = false;
						}
					objeto.value = vr.substr( 0, tam - 6 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ); 
					}

				if ( (tam >= 10) && (tam <= 12) ) {
			 		if(tecla == 8) {
						objeto.value = vr.substr(0, tam);
						window.event.cancelBubble = true;
						window.event.returnValue = false;
						}
					objeto.value = vr.substr( 0, tam - 9 ) + '.' + vr.substr( tam - 9, 3 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ); 
					}

				if ( (tam >= 13) && (tam <= 15) ){
					if(tecla == 8) {
						objeto.value = vr.substr(0, tam);
						window.event.cancelBubble = true;
						window.event.returnValue = false;
						}
					objeto.value = vr.substr( 0, tam - 12 ) + '.' + vr.substr( tam - 12, 3 ) + '.' + vr.substr( tam - 9, 3 ) + '.' + vr.substr( tam - 6, 3 ) + '.' + vr.substr( tam - 3, 3 ) ;
					}			
				}
			}
		}
	else if((window.event.keyCode != 8) && (window.event.keyCode != 9) && (window.event.keyCode != 13) && (window.event.keyCode != 35) && (window.event.keyCode != 36) && (window.event.keyCode != 46)) {
			window.event.cancelBubble = true;
			window.event.returnValue = false;
			}
}

 
 
</script>