<style>
table.comBordas {
    border: 0px solid White;
}
 
table.comBordas td {
    border: 1px solid grey;
}
</style>
<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Orcamento</a></li>
            <!--<li><a data-toggle="tab" href="#tab2">Ordens de Serviço</a></li>-->
            <div class="buttons">
                    <?php 
								if($result->status_orc == 0)
					{
					if($this->permission->checkPermission($this->session->userdata('permissao'),'eOrcamento')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/orcamentos/editar/'.$result->idOrcamentos.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } 
					
					}
					?>
					</div>
					 <div class="buttons">
					 <?
					 if($this->permission->checkPermission($this->session->userdata('permissao'),'APOrcamento')){
						 
						 
						  echo '<a title="Icon Title" class="btn btn-mini btn-success" href="'.base_url().'index.php/orcamentos/aprovar/'.$result->idOrcamentos.'"><i class="icon-ok icon-white"></i> Aprovar</a>'; 
						  
						  
                 
            }
			?>
                    
            </div>
        </ul>
    </div>
   

     
      <div class="container-fluid">
	   <div class="row-fluid">
              <div class="span12">
<?
if($result->status_orc == 1)
{
	?>
	<div align='center'>
	<font size='5' color='red'>Orçamento Desativado</font>
	</div>
	<?
}
?>     
                  <div class="widget-box">
                
                      <div class="widget-content nopadding">


                  <!--<table class="table table-bordered">-->
                  <table width='100%' align='center' border ='0' class='comBordastitu'>
                      
                          <tr>   
					   <td style="text-align: center; width: 20%" rowspan='3'><strong><img src=" <?php echo base_url().$dados_emitente->url_logo.$dados_emitente->imagem; ?> " width='55%' height='30%'=></strong></td>
						<td align='center'>
						<table width='70%' border='0'>
						<tr><td colspan='2' align='center' height='50'>
						<b><font size='5'><?php echo $dados_emitente->nome; ?></font> </b> </td>
						</tr>
						<tr><td>
						CNPJ: <?php echo $dados_emitente->cnpj; ?>
						</td>
						<td>						
						INSCRIÇÃO ESTADUAL: <?php echo $dados_emitente->cnpj; ?></br>
						</td>
						
						</tr>
						<tr>
						<td>
						ENDEREÇO: <?php echo $dados_emitente->rua;?> Nº: <?php echo $dados_emitente->numero;?>
						</td>
						<td>
						Bairro: <?php echo $dados_emitente->bairro;?>
						</td>
						</tr>
						<tr>
						<td>
						Cidade: <?php echo $dados_emitente->cidade;?>
						</td>
						<td>
						Estado: <?php echo $dados_emitente->uf; ?>
						</td>
						<tr>
						<td>
						 E-mail: <?php echo $dados_emitente->email;?>
						 </td>
						 <td>
					TELEFONE: <?php echo $dados_emitente->telefone; ?>
					</td></tr>
					</table>
						</td>
						
					
					</tr>
				  
                  </table>


				



                  </div>

              </div>
                 

          </div>



      </div>
	  <br>
	   <table class='comBordas' width='36%' align='right'>
 <tr><td align='center'>
Orçamento número: <font size='5'><?php echo $result->idOrcamentos ?></font>
</td><td align='center'>
Data:<?php echo date('d/m/Y',  strtotime($result->data_abertura)) ?></b></td></tr>
</td></tr>
</table>

 <div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                     
                      <div class="widget-content nopadding">

                  
                  <table  width='100%' border='0' style="border-style:solid; border: 1px solid grey;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;">
                    <tr>
					<td align='center'>
					<table  width='100%' border ='0' style="font-family:Arial, Helvetica, sans-serif;
	font-size:12px;">
	
					
                          <tr>
					   
					  <td align='left'>Cliente:</td><td width='50%'><?php echo $dados_clientes->nomeCliente;?></td>
					   <td align='left'>CNPJ:</td><td ><?php echo $dados_clientes->documento;?></td>
					  </tr>
					  
					  <tr>
					   <td align='left'  width='13%'>Email solicitante: </td><td><?php echo $dados_solicitante->email_solici;?></td>
					   <td align='left' width='13%'> Nome solicitante: </td><td><?php echo $dados_solicitante->nome;?></td>
					   
					   </tr>
					   
					   <td align='left'>Telefone:</td><td><?php echo $dados_clientes->telefone;?></td>
						 <td align='left'>Referência:</td><td colspan='3'><?php echo $result->referencia ?></td>
					    
					</tr>
					
					 
					 
					  
					   
					   </table>
					   </td></tr>
				 
                     
                  </table>


				



                  </div>

              </div>
                 

          </div>



      </div>


<!-- acaba cliente-->
<!-- acaba produtos--> <br> 
<div>Prezado(a) senhor(a): Apresentamos nosso orçamento para fornecimento do(s) seguinte(s) item(ns):</div> <br>	
<div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                     
                      <div class="widget-content nopadding">

                
                  <table class='comBordas' width='100%'>
                      <thead>
                          <tr>
					   <td align='center'><b>Item</b></td>
					   <td align='center'><b>Qtde</b></td>
					   <td align='center'><b>Unid.</b></td>
					   <td><b>Descrição</b></td>
					   <td><b>PN</b></td>
					   <td align='center'><b>Prazo Entr.</b></td>
					   <td align='center'><b>Valor Unit.</b></td>
					   <td align='center'><b>Sub. Total</b></td>
					   <td align='center'><b>IPI</b></td>
					   <td align='center'><b>Total</b></td>
					   
					</tr>
					
				  </thead>
                     
					  <tbody>
					
					  <?php 
					  $valorsub = 0;
					  $valortot = 0;
					  $valoripi = 0;
					  $valordesconto = 0;
					  
					  $count_item = 1;
					  $valor_calc = 0;
					
					  foreach ($itens_orcamento as $item) {
					$valor_calc = $item->qtd * $item->val_unit - $item->desconto;
					$valoripi = $item->val_ipi/100 * $valor_calc;
					
					$valordesconto = $valordesconto + $item->desconto;
					$valorsub =  $valorsub + ($item->qtd * $item->val_unit);
					 $valortot = $valortot + $valor_calc + $valoripi;
					
						  ?>
					  
					  <tr>
					   <td align='center'><?php echo $count_item; ?></td>
					    <td align='center'><?php echo $item->qtd;?></td>
					   <td align='center'>un</td>
					   <td><?php echo $item->descricao_item;?></td>
					   <td><?php echo $item->pn;?></td>
					   
					   <td align='center'><?php echo $item->prazo;?></td>
					  
					   <td align='center'><?php echo number_format($item->val_unit, 2, ",", ".");?></td>
					   <td align='center'><?php echo number_format($item->subtot, 2, ",", ".");?></td>
					   <td align='center'><?php echo number_format($item->val_ipi, 2, ",", ".");?></td>
					 <td align='center'><?php echo number_format($item->valor_total, 2, ",", ".");?></td>
					   
					   
					 
					   
					   
					   
					</tr>
					 <tr>
					   <td colspan='10'><?php echo nl2br($item->detalhe);?></td>
					   
					   
					</tr>
					
					  <?
					   $count_item ++;
					  }
					  ?>
					 
					  </tbody>
					  
                  </table>


				



                  </div>

              </div>
                 

          </div>



      </div>


							
<!-- acaba produtos-->
<!-- observaçao--> <br> <br>
<div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                     
                      <div class="widget-content nopadding">

                  <!--<table class="table table-bordered">-->
                  <table  width='100%' border='0'>
                      
					  <tr>
					  <td>
					  <table width='100%' class='comBordas'>
                          <tr>
					   <td colspan='2'>OBSERVAÇÕES:<?php echo $result->obs;?></td> 
					   <td align='center' rowspan='2'>SUBTOTAL R$: <?php echo number_format($valorsub, 2, ",", ".");?></td>
					    </tr>
					  
					   <tr>
					   <td>Condição de Pagamento</td>
					  <td><?php echo $result->cond_pgto;?></td>
					   
					</tr>
					<tr>
					   <td>Validade da Proposta</td>
					  <td><?php echo $result->validade;?></td>
					  <td align='center' rowspan='2'>VALOR IPI R$: <?php echo number_format($valoripi, 2, ",", "."); ?></td>
					   
					</tr>
					
					<tr>
					   <td>Local/Condição de Entrega</td>
					  <td><?
					  if($result->entregaoutros <> '')
					  {
						  echo $result->entregaoutros;
					  }
					  else
					  {
						  echo $result->entrega;
					  }
					  
					  ?>
					  
					  </td>
					   
					</tr>
					<tr>  
					   <td>Natureza da Operação</td>
					  <td><?php echo $dados_natoperacao->nome;?></td>
					   <td align='center' rowspan='1'></td>
					</tr>
					<tr>
					   <td>Prazo Entrega</td>
					  <td>O prazo de entrega está condicionado ao recebimento do pedido de compra.<br> SALVO VENDA PRÉVIA</td>
					   <td align='center' rowspan='1'><b>TOTAL R$: <?php echo number_format($valortot, 2, ",", "."); ?></b></td>
					</tr>
					<?
					if(!empty($result->garantia_servico))
					{
						?>
						<tr>
					   <td>Garantia Serviço</td>
					  <td><?php echo $result->garantia_servico;?></td>
					  
					</tr>
						
						<?
						
					}
					
					?>
					</table>
					</td>
					<td>
					<table width='100%'class='comBordas' >
 <tr>

 <td align='center'>
	Impostos Inclusos<br>
Para Fabricação :<br>
Para Serviço :
</td>
<td align='center'><br>
	ICMS e DARF<br>
ISS e DARF
</td>
</tr>

</table> 
</td>
	</tr>				
				
                     
					 
					  
                  </table>


				



                  </div>

              </div>
                 

          </div>


      </div>



<!-- fecha observaçao-->
<br>
 <table class='comBordas' width='100%'>
 <tr><td>
<div align="center">NÃO É DOCUMENTO FISCAL - NÃO É VÁLIDO COMO RECIBO E COMO GARANTIA DE MERCADORIA - NÃO COMPROVA PAGAMENTO.
</div>	
</td></tr>
</table>


<!-- rodape-->

<br>
 

<table class='comBordas' width='100%' align='rigth'><tr><td>Após a data de validade do orçamento, nosso preço e prazo de entrega estarão sujeitos a alteração.</td></tr>

</table>
<div ><b><br>Atenciosamente,</b></div>
<table  width='50%' align='center'>
 <tr>
  <td align="center"><br>_______________________________<br><?php echo $dados_vendedor->nomeVendedor;?><br>Comercial</td>
  <td align="center"><br>_______________________________<br><?php echo $dados_gerente->nome;?><br>Gerente Comercial</td>
  </tr><tr>
 <td align="center" colspan='2'><br><br>_______________________________<br>
 Aprovação do cliente
 
 </td>
</tr>

</table>
	  
	 <br> <br>  
	
	  
</div>







<div align='center'>
<br>
<form action="<?php echo base_url() ?>index.php/orcamentos/orcCustom" method="get" target="_blank">
 <button class="btn btn-inverse tip-top" title="Imprimir PDF"><i class="icon-print icon-white"></i></button>
Data:<input type='date' name='dataInicial' value='' class="span2" class="control-group">
<input type='hidden' name='idOrcamentos' value='<?php echo $result->idOrcamentos;?>'>
</form>
</div>
</div>