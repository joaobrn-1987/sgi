<style>
table.comBordas {
    border: 0px solid White;
}
 
table.comBordas td {
    border: 1px solid grey;
}
</style>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Buscar Pedido de compra</h5>
            </div>
            <div class="widget-content nopadding">


                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Filtro OS</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">

                                <form class="form-inline" action="<?php echo base_url() ?>index.php/suprimentos/almoxarifadocompras"
                                    method="post" name="form1" id="form1">


                                    <div class="span12" style="padding: 1%; margin-left: 0">

                                        <div class="span2" class="control-group">
                                            <label for="idPedidoCompra" class="control-label">Ordem de Compra</label>
                                            <input class="form-control" type="text" name="idPedidoCompra" value="<?php echo $dadosFiltros['idPedidoCompra']; ?>"
                                            autofocus class="span12">

                                        </div>

                                        <div class="span2" class="control-group">
                                            <label for="nf_fornecedor" class="control-label">N° NFe</label><br>
                                            <input class="form-control" type="text" name="nf_fornecedor" value="<?php echo $dadosFiltros['nf_fornecedor']; ?>"
                                                class="span12">

                                        </div>

                                        <div class="span2" class="control-group">
                                                <label for="idOs" class="control-label">N° OS</label><br>
                                                <?php //echo $dadosFiltros['idOs'];?>
                                                <input class="form-control" type="text" name="idOs" value="<?php echo $dadosFiltros['idOs']; ?>"
                                                class="span12">

                                             </div>

                                        <div class="span4" class="control-group">
                                            <label for="idGrupoServico" class="control-label">Status Ordem
                                                Compra</label>
                                            <!--&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll22();">&nbsp;Marcar/Desmarcar todos-->
                                            <br>
                                           
                                                    <select class="recebe-solici" class="controls" style="font-size: 10px; width:62%"
                                                     name="idStatuscompras" id="idStatuscompras">  
                                                        <option value="todos">
                                                            TODOS
                                                        </option>                                                  
                                                    <?php 
                                                    $i = 0;                                                    
                                                    foreach ($dados_statuscompra as $so)                                                     
                                                    {
                                                        
                                                        ?>
                                                        
                                                            <option value="<?php echo $so->idStatuscompras; ?>" <?=($dadosFiltros['idStatuscompras'] == $so->idStatuscompras)?'selected':''?>>
                                                                <?php echo $so->nomeStatus; ?>
                                                            </option>
                                                            <!--
                                                            <input type="checkbox" name="idStatuscompras[]" class='check'
                                                                value="<?php //echo $so->idStatuscompras; ?>">
                                                            &nbsp;<?php //echo $so->nomeStatus; ?>
                                                            -->                                                                
                                                        
                                                        <?php 
                                                        //if ( ($i+1) % 4 == 0) echo "</tr>";
                                                        
                                                        $i++;
                                                    }									 
										 
										            ?>
                                                    </select>                                          

                                        </div>

                                        
                                    </div>


                                    <div class="span12" style="padding: 1%; margin-left: 0">

                                            <div class="span2" class="control-group">
                                            <?php //print_r($dadosFiltros); ?>
                                                <label for="numPedido" class="control-label">N° Cotação</label><br>
                                                <input class="form-control" type="text" name="numPedido" value="<?php echo $dadosFiltros['numPedido']; ?>"
                                                class="span12">

                                            </div>


                                            <div class="span2" class="control-group">
                                                <label for="fornecedor" class="control-label">Fornecedor</label>
                                                <input class="span12" class="form-control" id="fornecedor" type="text"
                                                name="fornecedor" value="<?=set_value('fornecedor', null)?>" />
                                                <input id="fornecedor_id" type="hidden" name="fornecedor_id" value="<?php echo $dadosFiltros['fornecedor_id']; ?>" />
                                            </div>

                                            <div class="span2" class="control-group">
                                                <label for="descricao" class="control-label">Descrição</label><br>
                                                <input class="form-control" type="text" name="descricao" value="<?php echo $dadosFiltros['descricao']; ?>" />
                                                
                                            </div>

                                            <div class="span3" class="control-group">
                                                <label for="x8" class="control-label">Empresa</label><br>
                                                <input size="11" class="form-control" id="empresaNum1" type="text"
                                                name="empresaNum1" value="<?=set_value('empresaNum1', 1)?>" /> a 
                                                <input id="empresaNum2" size="10" type="text" name="empresaNum2" value="<?php echo $dadosFiltros['empresaNum2']; ?>" />
                                            </div>

                                            <div class="span3" class="control-group">
                                                <a href="#" onClick="document.getElementById('form1').submit();"><i class="icon-search" style="font-size:30px; float: right; margin-right:50%"></i></a>
    
                                            </div>

                                        
                                    </div>


                                </form>

                            </div>
                            



                            
                        </div>

                    </div>

                </div>

            </div>


            <span style="color: white">.</span>

        </div>

    </div>
</div>
<div class="widget-box">
    <div class="widget-title">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados da Cotação</a></li>
            <!--<li><a data-toggle="tab" href="#tab2">Ordens de Serviço</a></li>-->
           
        </ul>
    </div>
   

     
      <div class="container-fluid">
	   <div class="row-fluid">
              <div class="span12">
   
                  <div class="widget-box">
                
                      <div class="widget-content nopadding">


 <form action="<?php echo base_url() ?>index.php/suprimentos/imprimir_cotacao2" method="get" target="_blank">                
        <div>Emitente:
        <select class="form-control" name="idEmitente">
                                
                                <?php foreach ($dados_emitente as $e) { ?>
                                
                                <option value="<?php echo $e->id; ?>" <?php if($e->id == 1){ echo "selected='selected'";}?>><?php echo $e->nome; ?></option>
                                <?php } ?>
                                
                                </select>
        </div>
        
            <div>Data Cadastro da cotação: 
        <?php echo date("d/m/Y H:i:s", strtotime($results[0]->datacotacao));?>
        </div>	
        <div>Número cotação:
        <?php echo $results[0]->idPedidoCotacao;?>
        </div>	

                  </div>

              </div>
                 

          </div>



      </div>
	  


	
<div class="row-fluid">
              <div class="span12">

                  <div class="widget-box">
                     
                      <div class="widget-content nopadding">

                
                  <table class="table table-bordered ">
    <thead>
        <tr>
        
                        
                        <th></th>
                        <th>Nº OS</th>
                        <th>Qtd.</th>
                        <th>Descrição</th>
                        <th>Dimensões</th>
                        <th>OBS</th>
                        
                        
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
			$color = '';
			
			
			?>
           <tr>
 
           <td><input name="idDistribuir_[]" type="checkbox"  value="<?php echo $r->idDistribuir;?>" checked></td>
           <td><?php echo $r->idOs;?></td>
           <td><?php echo $r->quantidade;?></td>
           <td><?php echo $r->descricaoInsumo;?></td>
           <td><?php echo $r->dimensoes;?></td>
           <td><?php echo $r->obs;?></td>
            
          
           
          
			 
			
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



      </div>


	




<!-- rodape-->


	
	  
</div>







<div align='center'>
<br>

    <?php $dataHoje = date('d/m/Y'); ?>
    <button class="btn btn-mini btn-info" title="Imprimir PDF"><i class="icon-print icon-white"></i> Imprimir</button>
    Data: <input type='text' name='dataInicial' value="<?php echo $dataHoje; ?>" class="span2" class="control-group">
    <input type='hidden' name='idPedidoCotacao' value='<?php echo $r->idPedidoCotacao;?>'>

</div>
</div>
</form>

<script>
    jQuery(document.body).on('keypress', '#form1', function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            document.getElementById('form1').submit();
        }
    });
</script>
