<?php
$apaganx = "";
$submit  = "";
$conclui = "";

if($this->session->userdata('cond_pag') == '')
{
	$this->cond_pag = "";
}
		
		
//------------------------------ ITEM'S ------------------------------------
if($this->input->post('ok'))
{

	$this->cod_solic=$this->input->post('cod_solic');
	
	$abre=0;
}
else
{
	$abre=1;
}



//$cont = count($this->session->userdata('dp_valor_total2'))+1;
	for($x=0;$x < count($this->session->userdata('dp_valor_total2')); $x++)
	{
		 $vl_tot = str_replace(".","",$this->session->userdata('vlr_total')[$x]);
		 $vl_tot = str_replace(",",".",$vl_tot);

		 $desconto_item2 = str_replace(".","",$this->session->userdata('desconto_item')[$x]);
		 $desconto_item2 = str_replace(",",".",$desconto_item2);
		 
		// $vl_tot = number_format($this->session->userdata('vlr_total')[$x],2,'.','.');			
		//echo $vl_tot = str_replace(",",".",$this->session->userdata('vlr_total')[$x]);
		
		
		 // $total = $vl_tot * $this->session->userdata('imposto')/100;
		  //$total_aux = explode(',',$total);
	  // $total = $total_aux[0].'.'.substr($total_aux[1],0,2);
		//$this->session->userdata('dp_valor_total2')[$x] = $vl_tot + $total - $desconto_item2;
		
		 $total_aux = $vl_tot * $this->session->userdata('imposto')/100;
		
		$this->session->userdata('dp_valor_total2')[$x] = $vl_tot + $total_aux ;
		
		
		
		$this->session->userdata('dp_valor_total2')[$x] = str_replace(",",".",$this->session->userdata('dp_valor_total2')[$x]);
		$this->session->userdata('dp_valor_total2')[$x]=number_format($this->session->userdata('dp_valor_total2')[$x],2,',','.');
	
	
	}

	
$contador=count($this->session->userdata('item'));

if($contador==0){ $contador=1; };

if(($this->input->post('acao')))
{
	switch ($this->input->post('acao'))
	{
		case 'apagar':
			$apaganx=$this->input->post('valor_apaga'); 

			unset($this->session->userdata('cod_int')[$apaganx],
			$this->session->userdata('cod_fab')[$apaganx],
			$this->session->userdata('cod_cli')[$apaganx],		
			$this->session->userdata('qtde_mat')[$apaganx],
			$this->session->userdata('desc_mat')[$apaganx],
			$this->session->userdata('cod_mat')[$apaganx],
			$this->session->userdata('tk_mat')[$apaganx],
			$this->session->userdata('vlr_unit_mat')[$apaganx],
			$this->session->userdata('vlr_total_mat')[$apaganx]);
			
			
			$submit=1;
				
		break;
		case 'adciona':
			
			$contador=count($this->session->userdata('item'))+1;
			
		break;
		case 'reseta':
			
			echo "<script>window.location='orcamento.php';</script>";
			$contador=1;
			$submit=1;
		break;
		case 'salva':
			$abre=1;
			$submit=1;
		break;
		case 'conclui_orc':
			$abre=1;
			$conclui=1;
		break;
		case 'atualiza':
			$abre=1;
			$submit=1;
		break;
	
	}
	
}


//--------------------------------- FIM - ITEM'S ------------------------------------
?>

<html>

<head>
<meta http-equiv="Content-Language" content="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Sistema SGI - Comercial</title>
<script language="JavaScript" fptype="dynamicanimation">
<!--
function dynAnimation() {}
function clickSwapImg() {}
//-->
</script>
<script language="JavaScript1.2" fptype="dynamicanimation" src="../../../animate.js">
</script>
<link href="stylesheet.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style13 {font-size: 9px}
.style14 {font-size: 1px}
-->
</style>
<script src="script.js">
</script>
</head>

<body topmargin="0" onLoad="soma_totalitem();" leftmargin="0">
<form name="form1" id="form1" method="post" action="">
<table border="1"  cellspacing="0" cellpadding="0">

  <tr>
    <td width="100%" bgcolor="#FFFFFF" colspan="12" height="245" valign="top">
      <table border="0" width="100%" cellspacing="0" cellpadding="0" height="100%">
        <tr>
         
          
          <td width="100%" height="100%" valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
               
                <td width="97%">
                  <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
         
          <td width="99%" valign="top">
            <font size="1" face="Arial">Você está em <font color="#6600FF"><b>
            Orçamento</b></font> - </font><b>
            <font face="Arial">Novo </font></b>
            <br>
           
			
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100%">
				<?php
				
				?>
				
                  <table >
                    
					
                   
					
                    
					
                    <tr>
                      <td bgcolor="#FBFEFF" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" bgcolor="#FFFFFF"><a onMouseOver="document['fpAnimswapImgFP18').imgRolln=document['fpAnimswapImgFP18').src;document['fpAnimswapImgFP18').src=document['fpAnimswapImgFP18').lowsrc;" onMouseOut="document['fpAnimswapImgFP18').src=document['fpAnimswapImgFP18').imgRolln" onClick="document.getElementById('acao').value='adciona'; document.form1.submit();">adicionar</a>
                        <input name="ok" type="hidden" id="ok" value="1" />
                        <input name="acao" type="hidden" id="acao" />
						<input name="valor_apaga" type="hidden" id = "valor_apaga" />
&nbsp;&nbsp;<a onClick="document.getElementById('acao').value='salva'; document.form1.submit();">salvar</a></td>
                      <td width="15%" bgcolor="#FFFFFF">&nbsp;</td>
                      <td width="36%" bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                  </table>
				  
			                  </td>
              </tr>
            </table>
		
			
            <table  >
              <tr>
                <td bgcolor="#EDFAFE">
                <table >
                  <tr>
          <td  bgcolor="#EDFAFE">
            <table >
              <tr>
                <td height="24" bgcolor="#D3E4EB" align="center"><b><font face="Arial" size="1">&nbsp;Item</font></b></td>
                
                <td bgcolor="#D3E4EB" height="24" align="center"><b>
                  <font face="Arial" size="1">Qtde</font></b></td>
               
                <td height="24" bgcolor="#D3E4EB" align="center"><b>
                <font face="Arial" size="1">Descrição </font></b></td>
               
                
				<td bgcolor="#D3E4EB" height="24" align="center"><b>
                  <font face="Arial" size="1">Valor Unit.</font></b></td>
				  
				 <td bgcolor="#D3E4EB" height="24" align="center"><b> <font face="Arial" size="1">Desconto</font></b></td> 
                <td bgcolor="#D3E4EB" height="24" align="center"><b> <font face="Arial" size="1">Sub. Total</font></b></td>
				
              <td bgcolor="#D3E4EB" height="24" align="center"><b> <font face="Arial" size="1">IPI:
			  <input name="imposto" type="text" id="imposto" dir="rtl" value="<?php echo $this->session->userdata('imposto'); ?>" size="3" maxlength="5" onBlur="mostra_total(); document.form1.submit();" onKeyPress="return txtBoxFormat(document.form1, 'imposto', '99.99', event);">%</font></b></td>
              <td bgcolor="#D3E4EB" height="24" align="center"><b> <font face="Arial" size="1">Total</font></b></td>
              </tr>
             

<?php

/*if(is_array($this->session->userdata('item')))
{ 
$this->session->userdata('item')=array_unique($this->session->userdata('item'));
}*/
$variavel = 0;
for($x=0;$x<$contador;$x++)
{
$indice = $variavel + 1;
$this->session->userdata('item')[$x] = $indice;
	if("$x" != "$apaganx")
	{
		if(!$abre || $this->session->userdata('desc')[$x]!= "" || $contador == 1)
		{
			if($this->session->userdata('item')[$x] == "")
			{
				$z = $x+1;
				for($y=0;$y < $contador;$y++)
				{
					if($this->session->userdata('item')[$y] == $z)
					{
						$z++;
						$y = -1;
					}
				}
				$this->session->userdata('item')[$x] = $z;
			}
			
			
			
?>			  
              <tr>
                <td valign="top" bgcolor="#F9FEFF" align="center"><input name="item[]" type="text" class="input" id="item[<?php echo $x; ?>]" dir="rtl" value="<?php echo $this->session->userdata('item')[$x]; ?>" maxlength="2" readonly="true"></td>
                
                <td  valign="top" bgcolor="#F9FEFF" align="center"><div align="center">
                  <input name="quant[]" type="text" class="input" id="quant[<?php echo $x; ?>]" dir="rtl" value="<?php echo $this->session->userdata('quant')[$x]; ?>"  maxlength="4" onKeyUp="soma_totalitem(<?php echo $x; ?>);">
                </div></td>
               
                <td  valign="top" bgcolor="#F9FEFF" align="center"><div align="center">
                  <textarea name="desc[]" cols="35" rows="4" class="input" id="desc[<?php echo $x; ?>]"><?php echo $this->session->userdata('desc')[$x]; ?></textarea>
                </div></td>
                
				
				
				
                 <td  valign="top" bgcolor="#F9FEFF" align="center"><input name="vlr_unit[]" type="text" class="input" id="vlr_unit[<?php echo $x; ?>]" dir="rtl" value="<?php echo $this->session->userdata('vlr_unit')[$x]; ?>"  maxlength="10" onKeyUp="soma_totalitem(<?php echo $x; ?>);"  onKeyPress="FormataValor2(this,event,10,2);"></td>
                 <td  valign="top" bgcolor="#F9FEFF" align="center"><input name="desconto_item[]" type="text" class="input" id="desconto_item[<?php echo $x; ?>]" dir="rtl" value="<?php echo $this->session->userdata('desconto_item')[$x]; ?>" maxlength="10" onKeyUp="soma_totalitem(<?php echo $x; ?>);" onBlur="document.form1.submit();"  onKeyPress="FormataValor2(this,event,10,2);"></td>
				 <td valign="top" bgcolor="#F9FEFF" align="center">
                  
                     <input name="vlr_total[]" type="text" class="input" id="vlr_total[<?php echo $x; ?>]" dir="rtl" value="<?php echo $this->session->userdata('vlr_total')[$x];?>"  maxlength="12" readonly	="true">                  </td>
				  <input name="mostra_imposto2" class="input2" type="hidden" id="mostra_imposto2" value="<?php echo $this->session->userdata('imposto'); ?>" readonly="true">
				 
			
			  
			  
              <td valign="top" bgcolor="#F9FEFF" align="center"><b>
                <input name="dp_valor_total2[]" class="input2" type="text" id="dp_valor_total2[<?php echo $x; ?>]" style="font-family: Arial; font-weight: bold; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="<?php echo $this->session->userdata('dp_valor_total2')[$x];?>"  readonly="true">
              </b></td>  
              </tr>
             <tr>
			
			 
			 <td colspan="10" align="right"><!-- <?php //if(isset($this->session->userdata('cod_servico')) && $this->session->userdata('cod_servico') != ''){?><a href="javascript:openPopUpCentro('orcamento_main_item.php?item=<?php //echo $x; ?>&cod_servico=<?php //echo $this->session->userdata('cod_servico'); ?>', 770,600);"><img src="images/listar.png" alt="Editar Item" width="16" height="16" border="0">&nbsp;Materiais do Item</a><?php //}?>
			&nbsp;&nbsp;
			<a href="javascript:openPopUpCentro('orcamento_sel_item.php?item=<?php //echo $x; ?>', 780,600);"><img src="images/inserir.png" alt="Buscar Item" width="16" height="16" border="0">&nbsp;Buscar</a>	
			&nbsp;&nbsp;-->
					
					<a onMouseOver="document['fpAnimswapImgFP18').imgRolln=document['fpAnimswapImgFP18').src;document['fpAnimswapImgFP18').src=document['fpAnimswapImgFP18').lowsrc;" onMouseOut="document['fpAnimswapImgFP18').src=document['fpAnimswapImgFP18').imgRolln" onClick="document.getElementById('acao').value='apagar'; document.getElementById('valor_apaga').value='<?php echo $x; ?>'; document.form1.submit();"><img border="0" src="images/xiz.png" id="fpAnimswapImgFP18" name="fpAnimswapImgFP18" dynamicanimation="fpAnimswapImgFP18" lowsrc="images/xiz.png" alt="Excluir" width="16" height="16" >&nbsp;Excluir Item</a>			</td>
			 </tr>
              <tr>
                <td bgcolor="#F9FEFF" height="23" colspan="11">
                  <hr noshade color="#BCEEFC" size="1"></td>
                </tr>
<?php
		}
	}
	$variavel ++;
}
?>			
              <tr>
                <td bgcolor="#F9FEFF" height="7" colspan="11">
                <table border="0" >
                  <tr>
                    <td bgcolor="#FFFFFF"><a onMouseOver="document['fpAnimswapImgFP17').imgRolln=document['fpAnimswapImgFP17').src;document['fpAnimswapImgFP17').src=document['fpAnimswapImgFP17').lowsrc;" onMouseOut="document['fpAnimswapImgFP17').src=document['fpAnimswapImgFP17').imgRolln" onClick="document.getElementById('acao').value='adciona'; document.form1.submit();">novo</a>&nbsp;&nbsp;<!-- <a onClick="document.getElementById('acao').value='salva'; document.form1.submit();"><img src="images/salvar.jpg" width="54" height="19"></a> --></td>
                    <td width="15%" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="3%" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="15%" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="25%" bgcolor="#FFFFFF"><font size="1" face="Arial">                      
                      <input name="total" type="hidden" class="input2" id="total" dir="rtl" size="8" maxlength="12" readonly="true" onChange="mostra_total();">
					  <input name="total_desconto" type="hidden" class="input2" id="total_desconto" dir="rtl" size="8" maxlength="12" readonly="true" onChange="mostra_total();">
                    </font></td>
                  </tr>
                </table>
                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="8" colspan="2" bgcolor="#E3EEF2"><span class="style14">&nbsp;</span></td>
                    <td height="8" bgcolor="#E3EEF2"><span class="style14">&nbsp;</span></td>
                  </tr>
                  <tr>
                    <td colspan="2" bgcolor="#E3EEF2"><b>
                    <font size="1" face="Arial">&nbsp;Condição de Pagamento&nbsp;</font></b>
                      <input name="cond_pag" type="text" id="cond_pag" value="<?php echo $this->session->userdata('cond_pag'); ?>" size="65" maxlength="50"></td>
                  
                  </tr>
                
               
                  <tr>
                    <td width="81%" bgcolor="#E3EEF2" colspan="3">
                <table border="0">
                  
                  <tr>
                      <td height="25" valign="top"><table border="0" width="110%" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="40%"></td>
                          <td width="10%"><a onMouseOver="document['fpAnimswapImgFP12').imgRolln=document['fpAnimswapImgFP12').src;document['fpAnimswapImgFP12').src=document['fpAnimswapImgFP12').lowsrc;" onMouseOut="document['fpAnimswapImgFP12').src=document['fpAnimswapImgFP12').imgRolln" onClick="post_orc();">salvar</a></td>
                          <td width="50%"><a onMouseOver="document['fpAnimswapImgFP13').imgRolln=document['fpAnimswapImgFP13').src;document['fpAnimswapImgFP13').src=document['fpAnimswapImgFP13').lowsrc;" onMouseOut="document['fpAnimswapImgFP13').src=document['fpAnimswapImgFP13').imgRolln" onClick="document.getElementById('acao').value='reseta'; document.form1.submit();"> limpar
                            
                          </a></td>
                        </tr>
                      </table></td>
                      </tr>
                </table>                    </td>
                  </tr>
                </table>                </td>
                </tr>
              <tr>
                <td bgcolor="#F9FEFF" height="19" colspan="11">
                <hr noshade color="#BCEEFC" size="1"></td>
              </tr>
              <tr>
                <td bgcolor="#E3EEF2" height="19" colspan="11">
                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                 
                  <tr>
                    <td width="22%" height="17"></td>
                    <td width="37%" height="17">
                    <p align="right"><font face="Arial" size="2">Sub Total</font></td>
                    <td width="2%" height="17"></td>
                    <td width="39%" height="17" align="left">
                    <font face="Arial" size="2">R$ 
                    <input name="dp_sub_total" type="text" id="dp_sub_total" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
                    </font></td>
                  </tr>
                  <tr>
                    <td width="22%" height="10"></td>
                    <td width="37%" height="10" align="right">
					<font face="Arial" size="2"><b>IPI:</b> </font>
                    <font face="Arial" size="2">
                      <input name="mostra_imposto" type="text" id="mostra_imposto" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" dir="rtl" value="0.00" size="4" readonly="true">%</font>                    </td>
                    <td width="2%" height="10"></td>
                    <td width="39%" height="10" align="left">
                    <font face="Arial" size="2">R$ 
                    <label>
                    <input name="dp_imposto" type="text" id="dp_imposto" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
                    </label>
                    </font></td>
                  </tr>
                   <tr>
                    <td width="22%" height="10"></td>
                    <td width="37%" height="10">
                    <p align="right"><b><font size="2" face="Arial">VALOR 
                    DESCONTO</font></b></td>
                    <td width="2%" height="10"></td>
                    <td width="39%" height="10" align="left">
                    <font face="Arial" size="2"><b>R$ </b>
                   <input name="dp_mostra_desc" type="text" id="dp_mostra_desc" style="font-family: Arial; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
                    </font></td>
                  </tr>
                  
                  <tr>
                    <td width="22%" height="10"></td>
                    <td width="37%" height="10">
                    <p align="right"><b><font size="2" face="Arial">VALOR 
                    TOTAL DO ORÇAMENTO</font></b></td>
                    <td width="2%" height="10"></td>
                    <td width="39%" height="10" align="left">
                    <font face="Arial" size="2"><b>R$ </b>
                    <input name="dp_valor_total" type="text" id="dp_valor_total" style="font-family: Arial; font-weight: bold; font-size: 12px; background-color:#E3EEF2; border: 0px solid #000000;" value="0.00" size="12" readonly="true">
                    </font></td>
                  </tr>
                </table>                </td>
              </tr>
            
              </table>         </td>
                  </tr>
                </table>                </td>
          </tr></table>          </td>
                  </tr>
                    <tr>
                      <td></td>
                      <td width="1%" valign="top">&nbsp;</td>
                    </tr>
      </table>                </td>
                <td width="1%"></td>
  </tr>
</table>          </td>
        </tr>
      </table>    </td>
  </tr>
 
</table>
<script language="JavaScript">
function openPopUpCentro(url, vwidth, vheight){
	w = screen.width;
	h = screen.height;
	meio_w = w/2;
	meio_h = h/2;
	altura2 = vheight/2;
	largura2 = vwidth/2;
	meio1 = meio_h-altura2;
	meio2 = meio_w-largura2;
		
	window.open(url,'','toolbar=0,menubar=0,status=0,scrollbars=1, width=' + vwidth + ',height=' + vheight + ',top=' + meio1 + ',left=' + meio2);
}

function soma_total(){
	var valor;
	
	var valor_desc;
	var total=0;
	var tot_desconto_item = 0;
	var totalex;
	var totalex2;
	var totalexex;	
	var totalexex2;
	for(x=0;x<<?php echo $contador; ?>;x++){
		valor=document.getElementById('vlr_total['+x+')').value;
		valor_desc=document.getElementById('desconto_item['+x+')').value;
		
		valor = valor.replace('.','');
		valor = valor.replace(',','.');
		
		valor_desc = valor_desc.replace('.','');
		valor_desc = valor_desc.replace(',','.');
		
		if(valor==''){ valor=0; }	
		
		valor=parseFloat(valor);
		total=total+valor;
		
		if(valor_desc==''){ valor_desc=0; }	
		
		valor_desc=parseFloat(valor_desc);
		tot_desconto_item=tot_desconto_item+valor_desc;
	}
	total=total+'';
	tot_desconto_item=tot_desconto_item+'';
	
	if(total.indexOf('.')<0){ 
		total=total+".00";
		
	}
	else{
		totalex=total.split(".");
				
		if(totalex[1].length==1){
			total=totalex[0]+'.'+totalex[1]+'0';
		}
		else if(totalex[1].length>=2){
			totalexex=totalex[1].split("");
			campo0=parseInt(totalexex[0]);
			campo1=parseInt(totalexex[1]);
			campo2=parseInt(totalexex[2]);
			//if(campo2>5){ campo1++; }
			total=totalex[0]+'.'+campo0+campo1;
		}
	}
	
	if(tot_desconto_item.indexOf('.')<0){ 
		tot_desconto_item=tot_desconto_item+".00";
		
	}
	else{
		totalex2=tot_desconto_item.split(".");
				
		if(totalex2[1].length==1){
			tot_desconto_item=totalex2[0]+'.'+totalex2[1]+'0';
		}
		else if(totalex2[1].length>=2){
			totalexex2=totalex2[1].split("");
			campo00=parseInt(totalexex2[0]);
			campo11=parseInt(totalexex2[1]);
			campo22=parseInt(totalexex2[2]);
			//if(campo2>5){ campo1++; }
			tot_desconto_item=totalex2[0]+'.'+campo00+campo11;
		}
	}
	
	
	document.getElementById('total').value=total;
	document.getElementById('total_desconto').value=tot_desconto_item;
	
	mostra_total();
}


function soma_totalitem(x){
	var y = x;
	var tk;
	var vlr_unit;
	var desconto_item;

	for(x=0;x<<?php echo $contador; ?>;x++){
		if(document.getElementById('unid['+x+')').value==''){ document.getElementById('unid['+x+')').value='un'; }
		
		if(document.getElementById('quant['+x+')').value==''){ document.getElementById('quant['+x+')').value=1; }
		quant=document.getElementById('quant['+x+')').value;

		if(document.getElementById('vlr_unit['+x+')').value==''){ document.getElementById('vlr_unit['+x+')').value='0'; }		
		vlr_unit=document.getElementById('vlr_unit['+x+')').value;
		
		if(document.getElementById('desconto_item['+x+')').value==''){ document.getElementById('desconto_item['+x+')').value='0'; }		
		desconto_item=document.getElementById('desconto_item['+x+')').value;
			
		vlr_unit = vlr_unit.toString().replace( ".", "" );
		vlr_unit = vlr_unit.toString().replace( ",", "." );
		
		desconto_item = desconto_item.toString().replace( ".", "" );
		desconto_item = desconto_item.toString().replace( ",", "." );
		
		desconto_item=parseFloat(desconto_item);	
		
		vlr_unit=parseFloat(vlr_unit);	
		total=quant*vlr_unit-desconto_item;
		total=total+'';
		
		//alert("vlr"+vlr_unit);
		
		//alert("vlr"+total);
				
		
		//total = total.toString().replace( ".", "," );	
				
		/*total = total.toString().replace( ",", "." );
		total = retorna_formatado(total);*/
		document.getElementById('vlr_total['+x+')').value=retorna_formatado(total);
		
	}	
	soma_total();
	mostra_total2(y);
}
function mostra_total2(x){
	if(document.getElementById('vlr_total['+x+')').value==''){ document.getElementById('vlr_total['+x+')').value='0'; }		
		
		
	var total=document.getElementById('vlr_total['+x+')').value
	
	var imposto=document.getElementById('imposto').value;
		
	var dp_sub_total=total;
	dp_sub_total = dp_sub_total.toString().replace( ".", "" );
	dp_sub_total = dp_sub_total.toString().replace( ",", "." );
	dp_sub_total = parseFloat(dp_sub_total)
	var dp_imposto=dp_sub_total*imposto/100;
	var dp_valor_total=parseFloat(dp_sub_total)+parseFloat(dp_imposto);

	//----------------
	dp_imposto=dp_imposto+'';
	if(dp_imposto.indexOf('.')<0)
	{ 
		dp_imposto=dp_imposto+".00";
	}
	else
	{ 
		dp_impostoex=dp_imposto.split(".");
		if(dp_impostoex[1].length==1)
		{
			dp_imposto=dp_imposto+"0";
		}
		else if(dp_impostoex[1].length>=2)
		{
			dp_impostoexex=dp_impostoex[1].split("");
			campo0=parseInt(dp_impostoexex[0]);
			campo1=parseInt(dp_impostoexex[1]);
			campo2=parseInt(dp_impostoexex[2]);
			//if(campo2>5){ campo1++; }
			dp_imposto=dp_impostoex[0]+'.'+campo0+campo1;
		}
	}
	//------------------

	//----------------
	dp_valor_total=dp_valor_total+'';
	if(dp_valor_total.indexOf('.')<0)
	{ 
		dp_valor_total=dp_valor_total+".00";
	}
	else
	{ 
		dp_valor_totalex=dp_valor_total.split(".");
		if(dp_valor_totalex[1].length==1)
		{
			dp_valor_total=dp_valor_total+"0";
		}
		else if(dp_valor_totalex[1].length>=2)
		{
			dp_valor_totalexex=dp_valor_totalex[1].split("");
			campo0_=parseInt(dp_valor_totalexex[0]);
			campo1_=parseInt(dp_valor_totalexex[1]);
			campo2_=parseInt(dp_valor_totalexex[2]);
			//if(campo2_>5){ campo1_++; }
			dp_valor_total=dp_valor_totalex[0]+'.'+campo0_+campo1_;
		}
	}
	//------------------
	
document.getElementById('dp_valor_total2['+x+')').value=retorna_formatado(dp_valor_total);
}
function mostra_total(){
	
	var total=document.getElementById('total').value;
	var imposto=document.getElementById('imposto').value;
	var total_desconto=document.getElementById('total_desconto').value;
	
	
	
	imposto1=imposto;
	if(imposto1==''){ imposto1='0'; }
	document.getElementById('mostra_imposto').value=imposto1;
	//document.getElementById('mostra_imposto2').value=imposto1;
	total_desconto1=total_desconto;
	if(total_desconto1==''){ total_desconto1='0'; }
document.getElementById('dp_mostra_desc').value=total_desconto1;

	var dp_sub_total=parseFloat(total);
	var dp_imposto=dp_sub_total*imposto/100;
	var dp_valor_total=parseFloat(dp_sub_total)+parseFloat(dp_imposto);
	var dp_total_desconto = total_desconto;
	
	//----------------
	dp_imposto=dp_imposto+'';
	if(dp_imposto.indexOf('.')<0){ 
		dp_imposto=dp_imposto+".00";
	}
	else{ 
		dp_impostoex=dp_imposto.split(".");
		if(dp_impostoex[1].length==1){
			dp_imposto=dp_imposto+"0";
		}
		else if(dp_impostoex[1].length>=2){
			dp_impostoexex=dp_impostoex[1].split("");
			campo0=parseInt(dp_impostoexex[0]);
			campo1=parseInt(dp_impostoexex[1]);
			campo2=parseInt(dp_impostoexex[2]);
			//if(campo2>5){ campo1++; }
			dp_imposto=dp_impostoex[0]+'.'+campo0+campo1;
		}
	}
	//------------------

	//----------------
	dp_valor_total=dp_valor_total+'';
	if(dp_valor_total.indexOf('.')<0){ 
		dp_valor_total=dp_valor_total+".00";
		
	}
	else{ 
		dp_valor_totalex=dp_valor_total.split(".");
		
		if(dp_valor_totalex[1].length==1){
			dp_valor_total=dp_valor_total+"0";
		}
		else if(dp_valor_totalex[1].length>=2){
			dp_valor_totalexex=dp_valor_totalex[1].split("");
			campo0_=parseInt(dp_valor_totalexex[0]);
			campo1_=parseInt(dp_valor_totalexex[1]);
			campo2_=parseInt(dp_valor_totalexex[2]);
			//if(campo2_>5){ campo1_++; }
			dp_valor_total=dp_valor_totalex[0]+'.'+campo0_+campo1_;
		}
	}
	
	//------------------
	
	
	
	
	
	
	document.getElementById('dp_sub_total').value=retorna_formatado(total);
	document.getElementById('dp_imposto').value=retorna_formatado(dp_imposto);
	document.getElementById('dp_valor_total').value=retorna_formatado(dp_valor_total);
	document.getElementById('dp_mostra_desc').value=retorna_formatado(dp_total_desconto);
}



function post_orc(){

	if(document.getElementById('id_diretor').value==""){ alert('Preencha o Gerente Comercial!'); return false; }
	if(document.getElementById('cod_vend').value==""){ alert('Preencha o vendedor!'); return false; } 
	if(document.getElementById('cod_servico').value==""){ alert('Preencha o serviço!'); return false; } 
	if(document.getElementById('empresa_destino').value==""){ alert('Preencha a empresa!'); return false; } 
	if(document.getElementById('cod_solic').value==""){ alert('Preencha o solicitante!'); return false; }
	if(document.getElementById('imposto').value==""){ alert('Preencha o imposto!'); return false; }
	if(document.getElementById('val_prop').value==""){ alert('Preencha a validade da proposta!'); return false; }
	
	document.getElementById('acao').value='conclui_orc'; 
	document.form1.submit();
}
</script>
<?php
if($submit){
	echo "<script>document.form1.submit();</script>";
}
if($conclui){	
	echo "<script>
		document.form1.action='orcamento_main_result_cadastro.php';
		document.form1.submit();
		</script>";
}
?>
</form> 
</body>
</html>
