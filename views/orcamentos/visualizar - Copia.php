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
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eOrcamento')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.base_url().'index.php/orcamentos/editar/'.$result->idOrcamentos.'"><i class="icon-pencil icon-white"></i> Editar</a>'; 
                    } ?>
                    
            </div>
        </ul>
    </div>
   

          <div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                     
                      <div class="widget-content nopadding">

                  <!--<table class="table table-bordered">-->
                  <table >
                      <thead>
                          <tr>
					   <td style="text-align: center; width: 20%" rowspan='3'><strong><img src=" <?php echo base_url().$dados_emitente->url_logo.$dados_emitente->imagem; ?> " width='55%' height='30%'=></strong></td>
						<td align='center'>
						<b><font size='5'><?php echo $dados_emitente->nome; ?></font> </b> </br>
						<b>CNPJ:</b> <?php echo $dados_emitente->cnpj; ?> 
						<b>INSCRIÇÃO ESTADUAL:</b> <?php echo $dados_emitente->cnpj; ?> </br>
						<b>ENDEREÇO:</b> <?php echo $dados_emitente->rua;?><b> Nº: </b><?php echo $dados_emitente->numero;?>
						<b>Bairro:</b> <?php echo $dados_emitente->bairro;?><br>
						<b>Cidade:</b> <?php echo $dados_emitente->cidade;?> <b>| Estado:</b> <?php echo $dados_emitente->uf; ?>
						</br>  <b>E-mail:</b> <?php echo $dados_emitente->email;?>
					<b>TELEFONE:</b> <?php echo $dados_emitente->telefone; ?>
						
						</td>
						<td rowspan='3'><table><tr><td>Orçamento Nº: <b><?php echo $result->idOrcamentos ?></b></td></tr>
						<tr><td>Data Emissão: <b><?php echo date('d/m/Y',  strtotime($result->dataCadastro)) ?></b></td></tr>
						</table></td>
					</tr>
				  </thead>
                      <tbody>
                          
                      </tbody>
                  </table>


				



                  </div>

              </div>
                 

          </div>



      </div>
<div align="center">Dados Cliente</div>
	<!--  cliente   -->
 <div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                     
                      <div class="widget-content nopadding">

                  <!--<table class="table table-bordered">-->
                  <table class='comBordas' width='100%'>
                      <thead>
                          <tr>
					   <td align='center'>Código<br><?php echo $dados_clientes->idClientes;?></td>
					   <td colspan='3'>NOME / RAZÃO SOCIAL<br><?php echo $dados_clientes->nomeCliente;?></td>
					   
					</tr>
					<tr>
					   <td colspan='4'>ENDEREÇO:<br><?php echo $dados_clientes->rua;?>, nº: <?php echo $dados_clientes->numero;?> | Bairro: <?php echo $dados_clientes->bairro;?></td>
					  
					   
					</tr>
					 <tr>
					   <td>CIDADE:<br><?php echo $dados_clientes->cidade;?></td>
					    <td>UF:<br><?php echo $dados_clientes->estado;?></td>
					    <td>CEP:<br><?php echo $dados_clientes->cep;?></td>
					    
					   
					</tr>
					 <tr>
					    <td>TELEFONES:<br><?php echo $dados_clientes->telefone;?></td>
					    <td colspan='2'>CPF/CNPJ:<br><?php echo $dados_clientes->documento;?></td>
					    <td>RG/IE:<br><?php echo $dados_clientes->ie;?></td>
					   
					   
					</tr>
				  </thead>
                     
                  </table>


				



                  </div>

              </div>
                 

          </div>



      </div>


<!-- acaba cliente-->
<!-- acaba produtos-->
<div align="center">DISCRIMINAÇÃO DOS PRODUTOS/SERVIÇOS</div>	
<div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                     
                      <div class="widget-content nopadding">

                  <!--<table class="table table-bordered">-->
                  <table class='comBordas' width='100%'>
                      <thead>
                          <tr>
					   <td align='center'>CÓD.</td>
					   <td>PRODUTO</td>
					   <td align='center'>UN.</td>
					   <td align='center'>PRAZO DIAS</td>
					   <td align='center'>QTD.</td>
					   <td align='center'>UNITÁRIO</td>
					   <td align='center'>SUB. TOTAL</td>
					   <td align='center'>IPI</td>
					   <td align='center'>VALOR TOTAL</td>
					   
					</tr>
					
				  </thead>
                     
					  <tbody>
					 
					  <?php 
					  $valorsub = 0;
					  $valortot = 0;
					  $valoripi = 0;
					  $valordesconto = 0;
					  
					  
					  foreach ($itens_orcamento as $item) {

					$valoripi = ($item->val_ipi/100 * $item->subtot) + $valoripi;
					$valordesconto = $item->desconto + $valordesconto;
					$valorsub = $item->subtot + $valorsub;
					 $valortot = $valorsub + $valoripi;
					
						  ?>
					  
					  <tr>
					   <td align='center'><?php echo $item->idProdutos;?></td>
					   <td><?php echo $item->descricao;?> <b>PN:</b> <?php echo $item->pn;?></td>
					   <td align='center'>UN.</td>
					   <td align='center'><?php echo $item->prazo;?></td>
					   <td align='center'><?php echo $item->qtd;?></td>
					   <td align='center'><?php echo $item->val_unit;?></td>
					   <td align='center'><?php echo $item->subtot;?></td>
					   <td align='center'><?php echo $item->val_ipi;?></td>
					   <td align='center'><?php echo $valortot;?></td>
					   
					   
					   
					</tr>
					 <tr>
					   <td colspan='9'><?php echo nl2br($item->detalhe);?></td>
					   
					   
					</tr>
					
					  <?
					  }
					  ?>
					  </tbody>
					  
                  </table>


				



                  </div>

              </div>
                 

          </div>



      </div>


							
<!-- acaba produtos-->
<!-- observaçao-->
<div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                     
                      <div class="widget-content nopadding">

                  <!--<table class="table table-bordered">-->
                  <table class='comBordas' width='100%'>
                      <thead>
                          <tr>
					   <td colspan='2'>OBSERVAÇÕES:<?php echo $result->obs;?></td> <td align='center' rowspan='2'>SUBTOTAL - R$: <?php echo $valorsub;?></td>
					    </tr>
					  
					   <tr>
					   <td>Condição de Pagamento</td>
					  <td><?php echo $result->cond_pgto;?></td>
					   
					</tr>
					<tr>
					   <td>Validade da Proposta</td>
					  <td><?php echo $result->validade;?></td>
					  <td align='center' rowspan='2'>VALOR IPI - R$: <?php echo $valoripi;?></td>
					   
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
						  echo  $result->entrega;
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
					  <td>SALVO VENDA PREVIA</td>
					   <td align='center' rowspan='1'>TOTAL - R$: <?php echo $valortot;?></td>
					</tr>
					
				  </thead>
                     
					 
					  
                  </table>


				



                  </div>

              </div>
                 

          </div>

 
<div align="center">O prazo de entrega está condicionado ao recebimento do pedido de compra.
Após a data da validade do Orçamento, nosso preço e prazo de entrega estarão sujeitos a alteração</div>	

      </div>



<!-- fecha observaçao-->
<br>
 <table class='comBordas' width='100%'>
 <tr><td>
<div align="center">NÃO É DOCUMENTO FISCAL - NÃO É VÁLIDO COMO RECIBO E COMO GARANTIA DE MERCADORIA - NÃO COMPROVA PAGAMENTO
PREZADO(A) SENHOR(A): APRESENTAMOS NOSSO ORÇAMENTO PARA FORNECIMENTO DO(S) SEGUINTE(S) ITEM(NS)</div>	
</td></tr>
</table>


<!-- rodape-->

<br>
 <table class='comBordas' width='100%' align='rigth'>
 <tr>
 <td width='70%'></td>
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

<div align="center">ASSINATURAS</div>
 <table class='comBordas' width='100%' align='rigth'>
 <tr>
  <td align="center"><br>_______________________________<br><?php echo $dados_vendedor->nomeVendedor;?><br>COMERCIAL</td>
  <td align="center"><br>_______________________________<br><?php echo $dados_gerente->nome;?><br>GERENTE COMERCIAL</td>
 <td align="center">AUTORIZAÇÃO DO CLIENTE<br><br>
 DATA: ______/______/______ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASSINATURA:_______________________________
 
 </td>
</tr>

</table>
<div align='center'>
<br>
<form action="<?php echo base_url() ?>index.php/orcamentos/orcCustom" method="get">
 <button class="btn btn-inverse tip-top" title="Imprimir PDF"><i class="icon-print icon-white"></i></button>
Data:<input type='date' name='dataInicial' value='' class="span2" class="control-group">
<input type='hidden' name='idOrcamentos' value='<?php echo $result->idOrcamentos;?>'>
</form>
</div>
</div>