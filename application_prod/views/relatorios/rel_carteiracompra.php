<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />

<?php

if(!$results){
		
?>


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
                        
                         <th>OS.</th>
                        <th>OR.</th>
                        <th>Data OS.</th>
                        <th>Descrição</th>
                        <th>Cliente</th>
                        <th>Qtd.</th>
                        <th>Item - Descrição</th>
                        <th>PN</th>
						<?php
if($this->permission->checkPermission($this->session->userdata('permissao'),'vvalorOs')){
?>
                        <th>Valor</th>
						<?php
}
?>
                        <th>Data Ent.</th>
                        <th>Data Rep.</th>
                        <th>Status</th>
                        <th>EXE</th>
                        <th>FAT</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Nenhuma OS Cadastrado</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{
	

?>
 <div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Filtro OS</h5>
            </div>
            <div class="widget-content nopadding">
                

                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                 
                              <form class="form-inline" action="<?php echo base_url() ?>index.php/relatorios/ordemdecompra" method="post" name="form1" id="form1">
               

                                   
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span4" class="control-group">
                                            <label for="idOs" class="control-label">Cod. OS.:<font size='1'> P/ vários separar por vírgula.</font></label>
                       <input class="span12" type="text" name="idOs" value="" autofocus class="span12">
                       
                                        </div>
										<div class="span4" class="control-group">
                                            <label for="idPedidoCompra" class="control-label">Pedido Compra:<font size='1'> P/ vários separar por vírgula.</font></label>
                       <input class="span12" type="text" name="idPedidoCompra" value="" class="span12">
                       
                                        </div>
										<div class="span4" class="control-group">
                                            <label for="idPedidoCotacao" class="control-label">Cotaçao:<font size='1'> P/ vários separar por vírgula.</font></label>
                                            <input class="span12" type="text" name="idPedidoCotacao" value="" class="span12">
                       
                                        </div>
                                        
										<!--<div class="span2" class="control-group">
                                            <label for="idOrcamentos" class="control-label">Cod. Orc.:</label>
                       <input class="span12 form-control" type="text" name="idOrcamentos" value="" class="span12">
                       
                                        </div>
										 <div class="span1" class="control-group">
                                            <label for="cliente" class="control-label">Cliente:</label>
                      <input class="span12" class="span12 form-control" id="cliente"  type="text" name="cliente" value=""  />
		<input id="clientes_id"  type="hidden" name="clientes_id" value=""  />
                                        </div>
										
										 <div class="span5" >
										 <label for="cliente" class="control-label">Cliente:</label>
										 <div style="overflow: auto; width: 450px; height: 50px; border:solid 0px"> 
										 
										 <?php
										 foreach ($dados_clientes as $cli) 
										  
										  {
										 
										 ?>
    <input type="checkbox" name="clientes_id[]" value="<?php echo $cli->idClientes; ?>"> <?php echo $cli->nomeCliente; ?><br>
   <?php
}
?>
 
</div>
										 </div>
                                       
                                       <div class="span3" class="control-group">
                                           
                        <label for="referencia" class="control-label"><b>PN Ordem Serviço</b>:</label>
						<input type="hidden" id="idProdutos" name="idProdutos" size="3"   value=""/>
			<input type="text" id="pn" class="span12" name="pn" size="97" ref="autocomplete"  value=""/>
	
	
                                        </div> -->

                                        
                                    </div>
									 <div class="span12" style="padding: 1%; margin-left: 0">
									 <div class="span3" class="control-group">
                                            <label for="nf_fornecedor" class="control-label">NF Fornecedor:<font size='1'> P/ vários separar por vírgula.</font></label>
                       <input class="span12" type="text" name="notafiscal" value="" class="span12">
                       
                                        </div>
                                        <div class="span3" class="control-group" style="width:378px">
                                            <label for="data" class="control-label">Data Solicitação:</label><br>
                                            De: <input class="data" type="text" name="dataSolInicial" class="span5" /> |  Até:<input class="data" type="text" name="dataSolFinal" class="span5" />                    
                                        </div>
                                        <div class="span3" class="control-group" style="width:378px">
                                            <label for="data" class="control-label">Data Compra:</label><br>
                                            De: <input class="data" type="text" name="dataComInicial" class="span5" /> |  Até:<input class="data" type="text" name="dataComFinal" class="span5" />                    
                                        </div>
										<div class="span2" class="control-group">
									  <label for="nf_fornecedor" class="control-label">Incluir as OS 1 a 13 no relatório</label><br>
								        <input class="" type="radio" name="os_1a13" checked="yes" value="nao"/> Não
							            <input class="" type="radio" name="os_1a13" value="sim"/> Sim
									 </div> 
									</div> 

                                    <!-- <div class="span12" style="padding: 1%; margin-left: 0">

                                       
                                       
										
									<div class="span4" class="control-group">
                                            <label for="numpedido_os" class="control-label">Data cadastro O.S.:</label><br>
                       
                            De: <input onclick="this.select();" type="date" name="dataInicialcad" class="span5	" /> |  Até:<input onclick="this.select();" type="date" name="dataFinalcad" class="span5" />
                                        </div>
                                       
									    <div class="span4" class="control-group">
                                            <label for="numpedido_os" class="control-label">Data entrega O.S.:</label><br>
                       
                            De: <input type="date" name="dataInicialentrega" class="span5" /> |  Até:<input type="date" name="dataFinalentrega" class="span5" />
                                        </div>
										 <div class="span4" class="control-group">
                                            <label for="numpedido_os" class="control-label">Data reagendada O.S.:</label><br>
                       
                            De: <input type="date" name="dataInicialreag" class="span5" /> |  Até:<input type="date" name="dataFinalreag" class="span5" />
                                        </div>
										 
                                    </div>-->
								 	
								<!--<div class="span12" style="padding: 1%; margin-left: 0">

                                       
                                       
										
									 <div class="span12" class="control-group">
                                             
											
                                         <label for="idGrupoServico" class="control-label">Status OS:</label>&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll2();">&nbsp;Marcar/Desmarcar todos
 <br>
 <table width='100%'><tr>
										  <?php 
										  $i = 0;
										  foreach ($status_os as $e) 
										  
										  {



											  ?>
											  <td>
										<input type = "checkbox"  name = "idStatusOs[]" class='check' value = "<?php echo $e->idStatusOs; ?>" > &nbsp;<?php echo $e->nomeStatusOs; ?>
										</td>
										 <?php 
										 if ( ($i+1) % 5 == 0)
												echo "</tr>";
										 
										 $i++;
										 } 
										 
										 
										 ?> 
										 
										 
								 </table>
											 
                                        </div>
                                        </div>-->
									<div class="span12" style="padding: 1%; margin-left: 0">

                                       
                                       
										
									 <div class="span12" class="control-group">
                                             
											
                                         <label for="idGrupoServico" class="control-label">Status Ordem Compra:</label>&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll22();">&nbsp;Marcar/Desmarcar todos
 <br>
 <table width='100%'><tr>
										  <?php 
										  $i = 0;
										  foreach ($dados_statuscompra as $so) 
										  
										  {



											  ?>
											  <td>
										<input type = "checkbox"  name = "idStatuscompras[]" class='check' value = "<?php echo $so->idStatuscompras; ?>" <?php if($so->idStatuscompras == 1 || $so->idStatuscompras == 2 || $so->idStatuscompras == 3 || $so->idStatuscompras == 4 || $so->idStatuscompras == 10) { echo "checked";}; ?>> &nbsp;<?php echo $so->nomeStatus; ?>
										</td>
										 <?php 
										 if ( ($i+1) % 5 == 0)
												echo "</tr>";
										 
										 $i++;
										 } 
										 
										 
										 ?> 
										 
										 
								 </table>
											 
                                        </div>
                                        </div>

					
<div class="span12" style="padding: 1%; margin-left: 0">
								   <div class="span12" class="control-group">
                                             
											
                                  <label for="idGrupoServico" class="control-label">Grupo:</label><!--&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll22();">&nbsp;Marcar/Desmarcar todos-->
 <br>
 <table width='100%'><tr>
										  <?php 
										  $i = 0;
										  foreach ($dados_statusgrupo as $so) 
										  
										  {


										
											  ?>
											  <td>
										<input type = "checkbox"  name = "idgrupo[]"   class='check' value = "<?php echo $so->idgrupo; ?>" > &nbsp;<?php echo $so->nomegrupo; ?>
										</td>
										 <?php 
										 if ( ($i+1) % 4 == 0)
												echo "</tr>";
										 
										 $i++;
										  
										 } 
										 
										 
										 ?> 
										 
										 
								 </table>
											 
                                        </div>
								   
								   
								   
								   
								   
								   
										
										
										</div>


					
									<!-- <div class="span12" style="padding: 1%; margin-left: 0">	
									<div class="span4" class="control-group">
<label for="idGrupoServico" class="control-label">Unid. Execuçao O.S.:</label>
										
                         
                        <?php foreach ($unid_exec as $exec) { ?>
              <input type = "checkbox"  name = "unid_execucao[]" class='check' value = "<?php echo $exec->id_unid_exec; ?>"> &nbsp;<?php echo $exec->status_execucao; ?>        

                        <?php } ?>
                       
                      
                                        </div>
										<div class="span4" class="control-group">
<label for="idGrupoServico" class="control-label">Unid. Faturamento O.S.:</label>
										
										
                        <?php foreach ($unid_fat as $fat) { ?>
                   <input type = "checkbox"  name = "unid_faturamento[]" class='check' value = "<?php echo $fat->id_unid_fat; ?>"> &nbsp;<?php echo $fat->status_faturamento; ?>
				   

                        <?php } ?>
                       
                        </select> 
										
                                        </div>


										
                                        </div>	-->
									
								 <div class="span12" style="padding: 1%; margin-left: 0">
                                        
										
										 
                                     <!-- <div class="span12" >
										 <label for="fornecedor" class="control-label">Fornecedor:</label>
										<div style="overflow: auto; width: 1000px; height: 200px; border:solid 0px">
										 ----aqui
</div>
										 </div>-->
                                       

                                        
                                    </div>
									<div class="span12" >
										 <label for="fornecedor" class="control-label">Fornecedor:</label>
<p>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#adm" aria-expanded="false" aria-controls="collapseExample">
    Mostrar/ocultar
  </button>
</p>
<div class="collapse" id="adm">
  <div class="card card-body">
     <table><tr>
	 
	 <input type="checkbox" name="todasf" id="todasf" onClick="CheckAll22f();">&nbsp;<b>Marcar/Desmarcar todos</b>
	 <br><br>
	 
	 
										 <?php
										 $i = 1;
										 foreach ($dados_fornecedor as $for) 
										  
										  {
										 
										 ?>
										  <td><!--checked-->
										  
										  
    <input type="checkbox" name="idFornecedores[]" value="<?php echo $for->idFornecedores; ?>"> <?php echo $for->nomeFornecedor; ?></td>
   <?php
   if($i % 2)
   {
	   echo "</tr><tr>";
   }
   $i++;
}
?>

 </table>
 
 
 
 
 
  </div>
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
        <h5>OS</h5>

     </div>
 <div class="buttons">
                    
                    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                    <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Rel-Ordem-De-Compra">Excel</a>
                </div>
				
<div class="widget-content nopadding" id="printOs">


<table style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	font-size:10px;" border="1" width='100%' id="fixed_table">
    
	<tr>
	<td colspan='13' align='center'>
	RELATÓRIO CARTEIRA DE COMPRA<br>
	<font size='1'>* O <b>Valor</b> do item esta somamdo com IPI, FRETE(divisão entre os itens da OC) e com desconto se tiver.</font>
	</td>
	</tr>
	
        <tr>
        
                        <td align='center'>OS.</td>
                        <td align='center'>Data Solic. </br>"PCP"</td>
                        <td align='center'>Descrição</td>
                        <td align='center'>Qtd.</td>
                        <td align='center'>O.C.</td>
						<td align='center'>Fornecedor / NF</td>
						<td align='center'>Data Compra.</td>						
						<td align='center'>Data Prev.<br>chegada</td>
                        <td align='center'>Status</td>
                        <td align='center'>OBS</td>
                        <!--<td align='center'>Pedido de Compra</td>-->
                        <td align='center'>Valor</td>
                        
        </tr>
    
   
        <?php 
		$total = 0;
		$qtd = 0;
		$primeiro = true;
		$segundo = true;
		$id_pedi = '';
		$itens = '';
		foreach ($results as $r) {
			$color = '';
			if(!empty($r->previsao_entrega))
			{
				$previsao_entrega = date("d/m/Y", strtotime($r->previsao_entrega));
			
			}
			else
			{
				$previsao_entrega = "";
			}
			
			$total = $total + $r->valor_total;
			$valorporitem = 0;
			$qtditem = 0;
			$desconto = 0;
			$frete = 0;
			$outros = 0;
			
			if(!empty($r->idPedidoCompra))
			{
				
		$compra = $this->relatorios_model->tabela('pedido_cotacaoitens','idPedidoCompra ='. $r->idPedidoCompra);
			 $qtditem = count($compra);
			  $desconto = $r->desconto / $qtditem; //echo "<br>";
			 $frete = $r->frete / $qtditem;  //echo "<br>";
			 $outros = $r->outros / $qtditem;  //echo "<br>";
			 
			}
			$valorporitem = $r->valor_total + $frete + $outros -  $desconto;
			
            echo '<tr>';
            //echo '<td align="center">'.$r->idOs.'='.$r->idPedidoCompraItens.'</td>';
            echo '<td align="center">'.$r->idOs.'</td>';
            echo '<td align="left">'.date("d/m/Y H:i:s", strtotime($r->data_dist)).'</td>';
            echo '<td align="left">'.$r->descricaoInsumo.' '.$r->dimensoes.'</td>';
            echo '<td align="center">'.$r->quantidade.'</td>';
            echo '<td align="center">'.$r->idPedidoCompra.'</td>';
			?>
			<td align="left"><?php echo $r->nomeFornecedor." <b>NF:</b> ".$r->notafiscal;?></td>
			<?php
           
            echo '<td align="left">';
            if(!empty($r->cadpedgerado))
            {
            
                echo date("d/m/Y H:i:s", strtotime($r->cadpedgerado));
            
            }
            
            echo '</td>';
           
            echo '<td align="left">'.$previsao_entrega.'</td>';
           
		  
			?>
			<td align="center">
			<?php echo $r->nomeStatus;?>
			<?php
			 if(!empty($r->datastatusentregue))
		   {
			  echo "<br>".date("d/m/Y", strtotime($r->datastatusentregue));
		   }
			
			
			
            
           
            echo '</td>';
			//echo '<td align="left">'.$r->nomegrupo.'</td>';
			
			
			
			
			echo '<td align="left">'.$r->obscompras.'</td>';
			//echo '<td align="center">'.$r->idPedidoCompra.'</td>';
			 echo '<td align="right">'.number_format($valorporitem, 2, ",", ".").'</td></tr>';
				
		if($primeiro)
				{
					$itens.=$r->idDistribuir;
					$primeiro = false;
				}
				else
				{
					$itens.=".".$r->idDistribuir;
				}
		
				
				
			
			$qtd++;
			
        }?>
        <tr>
            <td colspan='10' align='right'>Total:<b><?php echo number_format($total, 2, ",", ".");?></b></td>
        </tr>
		<tr>
            <td colspan='10' align='right'>Qtd itens: <b><?php echo $qtd;?></b></td>
        </tr>
		<tr><td>
		<?php
		//echo $id_pedi;
				
				echo '<a href="'.base_url().'index.php/relatorios/imprimir_pedido/'.$itens.'" style="margin-right: 1%" class="class="btn btn-mini btn-info" title="Imprimir pedido" target="_blank"><button class="btn btn-mini btn-info" title="Imprimir PDF"><i class="icon-print icon-white"> Imprimir</i></button></a>'; 
				?>
		</td></tr>
		
   
</table>
</div>





</div>
<?php echo $this->pagination->create_links();}?>



 




<script type="text/javascript">
$(document).ready(function(){
	
jQuery(".data").mask("99/99/9999");
   });
   
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



console.log('#idProdutos');
	$("#pn").autocomplete({
		source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
		minLength: 1,
		select: function( event, ui ) {
			 $('#idProdutos').val(ui.item.id);

		}
	});





</script>
<script>

ok=false;
function CheckAll2() {
    if(!ok){
      for (var i=0;i<document.form1.elements.length;i++) {
        var x = document.form1.elements[i];
        if (x.name == 'idStatusOs[]') {        
                x.checked = true;
                ok=true;
            }
        }
    }
    else{
    for (var i=0;i<document.form1.elements.length;i++) {
        var x = document.form1.elements[i];
        if (x.name == 'idStatusOs[]') {        
                x.checked = false;
                ok=false;
            }
        }    
    }
}


ok2=false;
function CheckAll22() {
    if(!ok2){
      for (var i=0;i<document.form1.elements.length;i++) {
        var x = document.form1.elements[i];
        if (x.name == 'idStatuscompras[]') {        
                x.checked = true;
                ok2=true;
            }
        }
    }
    else{
    for (var i=0;i<document.form1.elements.length;i++) {
        var x = document.form1.elements[i];
        if (x.name == 'idStatuscompras[]') {        
                x.checked = false;
                ok2=false;
            }
        }    
    }
}
okf=false;
function CheckAll22f() {
    if(!okf){
      for (var i=0;i<document.form1.elements.length;i++) {
        var x = document.form1.elements[i];
        if (x.name == 'idFornecedores[]') {        
                x.checked = true;
                okf=true;
            }
        }
    }
    else{
    for (var i=0;i<document.form1.elements.length;i++) {
        var x = document.form1.elements[i];
        if (x.name == 'idFornecedores[]') {        
                x.checked = false;
                okf=false;
            }
        }    
    }
}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#imprimir").click(function(){         
            PrintElem('#printOs');
        })

        function PrintElem(elem)
        {
            Popup($(elem).html());
        }

        function Popup(data)
        {
            var mywindow = window.open('', 'SGI', 'height=600,width=800');
            mywindow.document.write('<html><head><title>SGI</title>');
           /* mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap.min.css' /><link rel='stylesheet' href='<?php echo base_url();?>assets/css/bootstrap-responsive.min.css' />");*/
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/tableimprimir.css' />");


            mywindow.document.write('</head><body >');
            mywindow.document.write(data);
            mywindow.document.write('</body></html>');

            mywindow.print();
            //mywindow.close();

            return true;
        }

    });
$(function () {
    $(".export-csv").on('click', function (event) {
        // CSV
        var filename = $(".export-csv").data("filename")
        var args = [$('#fixed_table'), filename + ".csv", 0];
        exportTableToCSV.apply(this, args);
    });
    
    function exportTableToCSV($table, filename, type) {
        var startQuote = type == 0 ? '"' : '';
        console.log(type);
        var $rows = $table.find('tr').not(".no-csv"),
            // Temporary delimiter characters unlikely to be typed by keyboard
            // This is to avoid accidentally splitting the actual contents
            tmpColDelim = String.fromCharCode(11), // vertical tab character
            tmpRowDelim = String.fromCharCode(0), // null character
            // actual delimiter characters for CSV/Txt format
            colDelim = type == 0 ? '";"' : '\t',
            rowDelim = type == 0 ? '"\r\n"' : '\r\n',
            // Grab text from table into CSV/txt formatted string
            csv = startQuote + $rows.map(function (i, row) {
                var $row = $(row),
                    $cols = $row.find('td,th');
                return $cols.map(function (j, col) {
                    var $col = $(col),
                        text = $col.text().trim().indexOf("is in cohort") > 0 ? $(this).attr('title') : $col.text().trim();
                    return text.replace(/"/g, '""'); // escape double quotes

                }).get().join(tmpColDelim);

            }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + startQuote;
        // Deliberate 'false', see comment below
        var BOM = "\uFEFF";
        if (false && window.navigator.msSaveBlob) {
            
            var blob = new Blob([decodeURIComponent(BOM+csv)], {
                type: 'text/csv;charset=utf8'
            });

              window.navigator.msSaveBlob(blob, filename);

        } else if (window.Blob && window.URL) {
            // HTML5 Blob        
            var blob = new Blob([BOM+csv], { type: 'text/csv;charset=utf8' });
            var csvUrl = URL.createObjectURL(blob);

            $(this)
                .attr({
                    'download': filename,
                    'href': csvUrl
                });
        } else {
            // Data URI
            var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(BOM+csv);

            $(this)
                .attr({
                    'download': filename,
                    'href': csvData,
                    'target': '_blank'
                });
        }
    }

});
</script>