
<?php
 
 
 


 
$dat = $this->input->get('dataInicial');
if($dat == '')
		{
			$dataimpri =  date("d/m/Y", strtotime($result[0]->datacotacao));
			
		}
		else{
			
			$dataimpri = $dat;
		}
		

?>


 <head>
    <title>SGI</title>
    <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.min.css" />
    <!--<link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/fullcalendar.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/main.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/blue.css" class="skin-color" />
    <script type="text/javascript"  src="<?php echo base_url();?>js/jquery-1.10.2.min.js"></script>-->
    <link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
    <script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

  <body style="background-color: transparent">
<style type="text/css">
table.comBordas {
    border: 0px solid White;
	
}
 
table.comBordas td {
    border: 1px solid grey;
	font-family:Arial, Helvetica, sans-serif;
	font-size:9px;
}
table.comBordas22 {
    border: 0px solid White;
	
}
 
table.comBordas22 tr {
    border: 1px solid grey;
	font-family:Arial, Helvetica, sans-serif;
	font-size:9px;
}
table.comBordastitu td {
    
	font-family:Arial, Helvetica, sans-serif;
	font-size:9px;
}
table.comBordas2 {
    border: 0px solid White;
	
}
 
table.comBordas2 td {
    border: 0px solid grey;
	font-family:Arial, Helvetica, sans-serif;
	font-size:9px;
}

</style>


      <div class="container-fluid">
	   <div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
             
      
                     <div class="widget-content nopadding">

                  <!--<table class="table table-bordered">-->
                  <table width='100%' align='center' border ='0' class='comBordas'>
                     
                          <tr>   
					  <td style="text-align: center; width: 20%" rowspan='3'><strong><img src=" <?php echo base_url().$dados_emitente->url_logo.$dados_emitente->imagem; ?> " width='55%' height='30%'=></strong></td>
						<td align='center'>
						<table width='100%' border='0'class='comBordas2'>
						<tr><td colspan='2' align='center' height='50'>
						<b><font size='4'><?php echo $dados_emitente->nome; ?></font> </b> </td>
						</tr>
						
						 <tr>
					  <td>
					  <font size='1'>CNPJ: <?php echo $dados_emitente->cnpj; ?></font>
					  <br>
					  <font size='1'>ENDEREÇO: <?php echo $dados_emitente->rua;?> Nº: <?php echo $dados_emitente->numero;?></font>
					  <br>
					  <font size='1'>CIDADE: <?php echo $dados_emitente->cidade;?> </font>
					  <br>
					  <font size='1'>EMAIL: <?php echo $dados_emitente->email_compras;?></font>
					  </td>
					  
					  <td>
					  <font size='1'>INSCRIÇÃO ESTADUAL: <?php echo $dados_emitente->ie; ?></font> </br>
					  <font size='1'>BAIRRO: <?php echo $dados_emitente->bairro;?></font>
					  <br>
					  <font size='1'>ESTADO: <?php echo $dados_emitente->uf; ?></font>
					  <br>
					  <font size='1'>TELEFONE: <?php echo $dados_emitente->telefone; ?></font>
					  </td>
					  
					  
					  </tr>
					  
					  
					
                  </table>

              </td>
			  <td style="text-align: center; width: 20%" rowspan='3'>
			    <table align='center' width='100%' border='0'  class='comBordas2'>
				  
	<tr>
	<td align='center'><font size='1'>
	Cotação: <b><?php echo $result[0]->idPedidoCotacao;?></b></font></td></tr><tr>
						<td align='center'><font size='1'>Data: <b><?php echo $dataimpri ;?></b>
						</font>
	</td></tr>
			
			  
				  
                  </table>
			  </td>
			  
			  </tr>
			   </table>
			   <div align='center'>
<h5>DADOS DO FORNECEDOR</h5>

</div>
<div>		
 <table align='center' width='100%' border='0'  class='comBordas22'>
<tr>
<td width='40%'>
NOME/RAZÃO SOCIAL:<br>
<b> . </b>
</td>
<td width='40%'>
CNPJ:<BR>
<b> . </b>
</td>
<td >
TELEFONE:<BR>
<b> . </b>
</td>
</tr>
</table>
</div>
<div>
 <table align='center' width='100%' border='0'  class='comBordas22'>
<tr>
<td width='40%'>
ENDEREÇO:<br>
<b>. </b>
</td>
<td>
BAIRRO:<BR>
<b> .</b>
</td>

</tr>
</table>
</div>
			<div align='center'>
<h5>DISCRIMINAÇÃO DOS PRODUTOS</h5>
<br>
</div>			
	 <table align='center' width='100%' border='0'  class='comBordas'>
    <thead>
        <tr>
       
                        
                        <td> <b>OS</b></td>
                        
                       <td><b>PRODUTO</b></td>
                        
						<td><b>QTD.</b></td>
                        <td><b>UNIT.</b></td>
                        <td><b>TOTAL</b></td>
                        
                        
        </tr>
    </thead>
    <tbody>
       <?php foreach ($result as $r) {
			$color = '';
			
			
			?>
           <tr>
 
           <td><?php echo $r->idOs;?></td>
           
           <td><?php echo $r->descricaoInsumo." ".$r->dimensoes;?></td>
          
		   <td><?php echo $r->quantidade;?></td>
           <td>-</td>
           <td>-</td>
          
            
          
           
          
			 
			
           </tr>
	
	
			
			<?php
			
        }?>
        <tr>
            
        </tr>
		

    </tbody>
</table>

			 
			



                  </div>

              </div>
                 

          </div>

<div class='span12'>
	
<div class='span5'><br>
<font size='1'>Observações:


<br>Previsão de Entrega:    dias
<br>Condição de Pagamento:</font>



</div>

<div class='span7'>
<br><font size='1'>
<div align='right' >
 VALOR DOS PRODUTOS R$:<input name="valor_produtos_" type="text" id="valor_produtos_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="" size="12" readonly="true">
</div>
<div align='right'>
IPI R$: <input name="ipi_" type="text" id="ipi_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="" size="12" readonly="true">
</div>
<div align='right'>
DESCONTO R$: <input name="desconto_" type="text" id="desconto_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="" size="12" readonly="true">
</div>
<div align='right'>
OUTROS R$: <input name="outros_" type="text" id="outros_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="" size="12" readonly="true">
</div>
<div align='right'>
FRETE R$: <input name="frete_" type="text" id="frete_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="" size="12" readonly="true">
</div>
<div align='right'>
ICMS R$: <input name="icms_" type="text" id="icms_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="" size="12" readonly="true">
</div>
<div align='right'>
TOTAL R$: <input name="valor_total_" type="text" id="valor_total_" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="" size="12" readonly="true">
</div>
</font>
</div>	  
	
	  
</div>

      </div>



            <!-- Arquivos js-->

           <!-- <script src="<?php echo base_url();?>js/excanvas.min.js"></script>
            <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
            <script src="<?php echo base_url();?>js/jquery.flot.min.js"></script>
            <script src="<?php echo base_url();?>js/jquery.flot.resize.min.js"></script>
            <script src="<?php echo base_url();?>js/jquery.peity.min.js"></script>
            <script src="<?php echo base_url();?>js/fullcalendar.min.js"></script>
            <script src="<?php echo base_url();?>js/sosmc.js"></script>
            <script src="<?php echo base_url();?>js/dashboard.js"></script>-->
  </body>
</html>

<script type="text/javascript">    
    window.print();
    window.addEventListener("afterprint", function(event) { window.close(); });
    window.onafterprint();      
</script>





