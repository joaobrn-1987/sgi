<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/fontawesome.js"></script>
<?php



$data = date("d-m-y");

$hora = date("H:i:s"); ?>

<body onLoad="calculaSubTotal();">


  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <div>
        Histórico alteração:
      </div>
      <div class="widget-box">
        <div class="widget-title">
          <span class="icon">
            <i class="icon-tags"></i>
          </span>
          <h5>Editar OS </h5>
          <div class="buttons">


            <a title="Imprimir" class="btn btn-mini btn-inverse" href="<?php echo base_url() ?>index.php/os/imprimir_osproducao/<?php echo $result->idOs; ?>" target="_blank"><i class="icon-print icon-white"></i> Imprimir</a>
          </div>
        </div>
        <div class="widget-content nopadding">


          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <ul class="nav nav-tabs">
              <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">
                  <font color='red'>Detalhes da OS</font>
                </a></li>

              <li id="tabProdutos"><a href="#tab2" data-toggle="tab">
                  <font color='red'>Anexo NF</font>
                </a></li>
              <li id="tabServicos"><a href="#tab3" data-toggle="tab">
                  <font color='red'>Insumos</font>
                </a></li>
              <li id="tabMaquina"><a href="#tab4" data-toggle="tab">
                  <font color='red'>Hr/Máquinas</font>
                </a></li>
              <li id="tabCusto"><a href="#tab5" data-toggle="tab">
                  <font color='red'>Custo Total O.S.</font>
                </a></li>
              <!--<li id="tabdetserv"><a href="#tab5" data-toggle="tab"><font color='red'>Detalhes Serviço</font></a></li><li id="tabAnexos"><a href="#tab4" data-toggle="tab">Anexos</a></li>-->
            </ul>
            <div class="tab-content">




              <div class="tab-pane active" id="tab1">
                <form action="<?php echo base_url() ?>index.php/os/editaros" method="post">
                  <table border='1' width='100%' style="border-color: #aaaaab;border-style: solid;">
                    <tr>
                      <td>
                        Data Abertura: <?php echo date("d/m/Y", strtotime($result->data_abertura_real)); ?>

                        
                      </td>
                      <td>
                        Data OS: <input size='6' id="data_abertura" class="data" type="text" name="data_abertura" value="<?php echo date("d/m/Y", strtotime($result->data_abertura));  ?>" onclick="this.select();" />

                        <input id="idOs2" type="hidden" name="idOs2" value="<?php echo $result->idOs; ?>" />
                        <input id="idOrcamento_item" type="hidden" name="idOrcamento_item" value="<?php echo $result->idOrcamento_item; ?>" />
                      </td>
                      <td>
                        Data Entrega:
                        <input size='6' id="data_entrega" class="data" type="text" name="data_entrega" value="<?php echo date("d/m/Y", strtotime($result->data_entrega));  ?>" onclick="this.select();" />
                      </td>
                      <?php 
                        $disabled = "readonly";
                        if($this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')){
                          $disabled = "";
                        }else if($result->unid_execucao == 1 && $this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproServ')){
                          $disabled = "";
                        }else if($result->unid_execucao == 2 && $this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproFab')){
                          $disabled = "";
                        }else if($result->unid_execucao == 4 && $this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproCil')){
                          $disabled = "";
                        }else if($result->unid_execucao == 3 && $this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproPet')){
                          $disabled = "";
                        } 
                      ?>
                      <td>
                        Data Reprog.:<input size='6' <?php //echo $disabled ?> id="data_reagendada" class="data" onclick="this.select();" type="text" name="data_reagendada" value="<?php if ($result->data_reagendada <> '') {
                                                                                                                                                            echo date("d/m/Y", strtotime($result->data_reagendada));
                                                                                                                                                          } ?>" /> 
                        <?php
                        if(empty($disabled)){
                          echo '- <a onclick="salvarReagendada()" style="margin-right: 1%" role="button"
                          data-toggle="modal" class="btn btn-primary"><i class="icon-save icon-white"></i></a>';
                        }
                          
                        ?>
                        
                      </td>
                      <td>
                        Nº Pedido:<input size='11' id="numpedido_os" onclick="this.select();" type="text" name="numpedido_os" value="<?php echo $result->numpedido_os; ?>" />
                      </td>
                      <td>
                        Tag:<input size='6' id="tag" onclick="this.select();" type=" text" name="tag" value="<?php echo $result->tag; ?>" />
                      </td>
                      <td>
                        Unid. Exec.:<select name="unid_execucao">

                          <?php foreach ($unid_exec as $exec) { ?>

                            <option value="<?php echo $exec->id_unid_exec; ?>" <?php if ($exec->id_unid_exec == $result->unid_execucao) {
                                                                                  echo "selected='selected'";
                                                                                } ?>><?php echo $exec->status_execucao; ?></option>
                          <?php } ?>

                        </select>
                      </td>
                      <td>
                        Unid. Fat.:<select name="unid_faturamento">

                          <?php foreach ($unid_fat as $fat) { ?>

                            <option value="<?php echo $fat->id_unid_fat; ?>" <?php if ($fat->id_unid_fat == $result->unid_faturamento) {
                                                                                echo "selected='selected'";
                                                                              } ?>><?php echo $fat->status_faturamento; ?></option>
                          <?php } ?>

                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Cod. OS: <b><?php echo $result->idOs; ?></b>
                      </td>

                      <td>
                        <?php 
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOrcamento')) {
                          echo '<a target="_blank" href="' . base_url() . 'index.php/orcamentos/editar/' . $result->idOrcamentos . '" style="color:black"onMouseOver="this.style.color=\'blue\'"
                          onMouseOut="this.style.color=\'black\'"> Orçamento: <b>' .$result->idOrcamentos  .'</b></a>';
                        }else{ ?>
                          Orçamento: <b><?php echo $result->idOrcamentos; ?></b><?php
                        }
                        ?>
                        
                      </td>
                      <td>
                        Natureza Op.:<font size='1'><b><?php echo $dados_natoperacao->nome; ?></b></font>
                      </td>
                      <td>

                        NF Cliente:<input onclick="this.select();" id="nf_cliente" type="text" name="nf_cliente" size='11' value="<?php echo $result->nf_cliente; ?>" />
                      </td>
                      <td>
                        Contrato:<select name="contrato" class="form-control">
                          <option value="Não" <?php if ($result->contrato == "Não") {
                                                echo "selected='selected'";
                                              } ?>>Não</option>
                          <option value="Sim" <?php if ($result->contrato == "Sim") {
                                                echo "selected='selected'";
                                              } ?>>Sim</option>
                        </select>
                      </td>
                      <td>
                        Nº NF | Data Fat.<br><input id="numero_nf" onclick="this.select();" size='6' type="text" name="numero_nf" value="<?php echo $result->numero_nf; ?>" /> |
                        <input size='6' id="data_nf_faturamento" onclick="this.select();" class="data" type="text" name="data_nf_faturamento" value="<?php if ($result->data_nf_faturamento <> '') {
                                                                                                                                                        echo date("d/m/Y", strtotime($result->data_nf_faturamento));
                                                                                                                                                      } ?>" />
                      </td>
                      <td  colspan="2">
                        NF Dev.| Fabricaçao<br><input id="nf_venda_dev" size='6' onclick="this.select();" type="text" name="nf_venda_dev" value="<?php echo $result->nf_venda_dev; ?>" />|
                        <input size='6' id="data_devolucao" onclick="this.select();" class="data" type="text" name="data_devolucao" value="<?php if ($result->data_devolucao <> '') {
                                                                                                                                                        echo date("d/m/Y", strtotime($result->data_devolucao));
                                                                                                                                                      } ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td colspan='4'>
                        Cliente: <b><?php echo $orcamento->nomeCliente; ?></b>
                      </td>
                      <td colspan='3'>Status:
                        <select name="idStatusOs" <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'alterarStatusOsPeritagem')) {echo 'onchange="alterarStatus(this,'.$result->idOs.')"'; }else{echo 'onchange="this.form.submit()"';  } ?>>

                          <?php foreach ($status_os as $gs) { ?>

                            <option value="<?php echo $gs->idStatusOs; ?>" <?php if($this->permission->checkPermission($this->session->userdata('permissao'), 'alterarStatusOsPeritagem')){
                              if ($gs->idStatusOs == $result->idStatusOs) {
                                echo "selected='selected'";
                              }else if($gs->etapa!=2){
                                echo "disabled";
                              }
                            }else{if ($gs->idStatusOs == $result->idStatusOs) {
                                                                              echo "selected='selected'";
                                                                            }} ?>><?php echo $gs->nomeStatusOs; ?></option>
                          <?php } ?>

                        </select>
                        <?php 
                          if(count($alteracoesStatus)>0){?>
                            <a href="#modalUltimasAlteracoes" data-toggle="modal" role="button" class="btn btn-primary" ><i class="icon-eye-open"></i></a>
                          <?php 
                          }?>
                        Histórico de alterações status
                        
                      </td>
                      <td>Tipo: <select class="form-control" name="id_tipo">
                          <!--<option value="" selected='selected'></option>-->
                          <?php foreach ($tipo_os as $ostipo) { ?>

                            <option value="<?php echo $ostipo->id_tipo; ?>" <?php if ($ostipo->id_tipo == $result->id_tipo) {
                                                                              echo "selected='selected'";
                                                                            } ?>><?php echo $ostipo->nome_tipo; ?></option>
                          <?php } ?>

                        </select> </td>
                    </tr>

                    <tr>
                      <td colspan='4'>
                        <?php
                        $obs = $result->obs_os;
                        if ($obs == '') {
                          $font = '#000000';
                        } else {

                          $font = 'red';
                        }


                        ?>

                        OBS OS:<textarea id="obs_os" rows="2" cols="100" class="span12" name="obs_os"><?php echo ($result->obs_os); ?></textarea>
                      </td>
                      <td colspan='4'>
                        OBS: Setor de Controle <?php
                                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eobscontroleOS')) {
                                                ?>
                          <a href="#modalAlterarcontroleos<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a>
                        <?php
                                                }
                        ?>
                        <?php 
                          if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVerificacaocontroleOS')) {
                            if($this->permission->checkPermission($this->session->userdata('permissao'), 'eErificacaocontroleOS')) {
                              echo '<select name="idVerificacaoControle" id="idVerificacaoControle">';
                            }else{
                              echo '<select disabled name="idVerificacaoControle" id="idVerificacaoControle">';
                            }
                        ?>
                        
                        
                          <?php 
                          foreach($verificacao_controle as $r){
                            if($r->idVerificacaoControle == $result->idVerificacaoControle){
                              echo '<option selected value="'.$r->idVerificacaoControle.'">'.$r->descricaoControle.'</option>';
                            }else{
                              echo '<option value="'.$r->idVerificacaoControle.'">'.$r->descricaoControle.'</option>';
                            }
                            
                          }?>
                          
                        </select>
                        <?php
                        }
                        if($this->permission->checkPermission($this->session->userdata('permissao'), 'eErificacaocontroleOS')) {
                          echo '<button type="submit" class="btn btn-success" id="buttonAlterarVerifContr" name="buttonAlterarVerifContr"><i class="icon-plus icon-white"></i> Alterar</button>';
                          if(count($alteracoesCont)>0){
                            echo ' - <a href="#modalUltimasAlteracoesControle" data-toggle="modal" role="button" class="btn btn-primary" ><i class="icon-eye-open"></i></a>';
                          }
                        }
                        ?>
                        

                        <?php
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vobscontroleOS')) {
                        ?>
                          <!--<a href="#modalvercontroleos<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn tip-top"><i class="icon-eye-open"></i></a>-->
                          <textarea id="vv" rows="2" cols="100" class="span12" name="vv" Disabled><?php echo ($result->obs_controle); ?></textarea>

                        <?php
                        }
                        ?>
                        
                      </td>
                    </tr>
                    <tr>
                      <td colspan='8'>
                        <table width='100%'>
                          <tr>
                            <td Valign="top">
                              <b>Qtd:</b><br><input size='1' id="qtd_os" type="text" onKeyUp="calculaSubTotal();" onclick="this.select();" name="qtd_os" value="<?php echo $result->qtd_os; ?>" />
                              <input id="qtd_os_original" type="hidden" name="qtd_os_original" value="<?php echo $result->qtd_os; ?>" />

                              <input id="idOrcamentos" type="hidden" name="idOrcamentos" value="<?php echo $result->idOrcamentos; ?>" />
                              <!--<input id="obs_controle" type="hidden" name="obs_controle" value="<?php echo $result->obs_controle; ?>" />-->

                            </td>
                            <td Valign="top">
                              <b>Descrição:</b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>Detalhe do serviço</b>:<a href="#modalverdetalheos<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn tip-top"><i class="icon-eye-open"></i></a> <br>
                              <input id="descricao_os" size='80' type="text" onclick="this.select();" name="descricao_os" value="<?php echo $itens_orcamento->descricao_item; ?>" />


                            </td>
                            <td Valign="top">
                              <b>PN:</b><br><input id="pn_sem" size='9' type="text" name="pn_sem" Disabled value="<?php echo $itens_orcamento->pn; ?>" />
                            </td>

                            <?php
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                            ?>


                              <td Valign="top">

                                <b>Vlr. Unit.:</b><br><input id="val_unit_os" size='6' onKeyUp="calculaSubTotal();" onclick="this.select();" type="text" name="val_unit_os" onKeyPress="FormataValor2(this,event,13,2);" value="<?php echo number_format($result->val_unit_os, 2, ",", ".");  ?>" />
                              </td>
                              <td Valign="top">

                                <b>Desconto:</b><br><input size='3' id="desconto_os" onKeyPress="FormataValor2(this,event,13,2);" onKeyUp="calculaSubTotal();" onclick="this.select();" type="text" name="desconto_os" value="<?php echo number_format($result->desconto_os, 2, ",", "."); ?>" />
                              </td>
                              <td Valign="top">

                                <b>IPI:</b><br><input size='1' id="val_ipi_os" onKeyPress="FormataValor2(this,event,13,2);" onKeyUp="calculaSubTotal();" onclick="this.select();" type="text" name="val_ipi_os" value="<?php echo number_format($result->val_ipi_os, 2, ",", "."); ?>" />
                              </td>
                              <td Valign="top">
                                <?php
                                $calc = $result->qtd_os * $result->val_unit_os - $result->desconto_os;
                                $ipicalc = $result->val_ipi_os / 100 * $calc;
                                $resultde = $calc + $ipicalc;
                                ?>
                                <b>Sub. Total:</b><br><input id="subtot_os" size='6' type="text" readonly="true" name="subtot_os" value="<?php echo number_format($calc, 2, ",", "."); ?>" />
                              </td>
                              <td Valign="top">

                                <b>Total:</b><br><input id="total" size='6' type="text" name="total" value="" readonly="true" />
                              </td>

                            <?php
                            }else{
                              $calc = $result->qtd_os * $result->val_unit_os - $result->desconto_os;
                                $ipicalc = $result->val_ipi_os / 100 * $calc;
                                $resultde = $calc + $ipicalc;
                              ?>
                              <input id="subtot_os" size='6' type="hidden" readonly="true" name="subtot_os" value="<?php echo number_format($calc, 2, ",", "."); ?>" />
                              <input size='1' id="val_ipi_os"  onclick="this.select();" type="hidden" name="val_ipi_os" value="<?php echo number_format($result->val_ipi_os, 2, ",", "."); ?>" />
                              <input size='3' id="desconto_os"  onclick="this.select();" type="hidden" name="desconto_os" value="<?php echo number_format($result->desconto_os, 2, ",", "."); ?>" />
                              <input id="val_unit_os" size='6' onclick="this.select();" type="hidden" name="val_unit_os"  value="<?php echo number_format($result->val_unit_os, 2, ",", ".");  ?>"/>
                              <?php
                            }
                            ?>

                          </tr>



                        </table>
                      </td>
                    </tr>





                    <tr>
                      <td colspan='8'>
                        <table width='100%'>
                          <tr>
                            <td Valign="top" style="border-right:0px">
                              <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'adesenhoOs')) {
                              ?>
                                <b>Status Desenho:</b>
                                <select name='statusDesenho' id='statusDesenho'>
                                  <?php if ($result->statusDesenho == 1) {
                                    echo '<option value="1" selected>Sem Desenho</option>';
                                  } else {
                                    echo '<option value="1">Sem Desenho</option>';
                                  }
                                  if ($result->statusDesenho == 2) {
                                    echo '<option value="2" selected>Incompleto</option>';
                                  } else {
                                    echo '<option value="2">Incompleto</option>';
                                  }
                                  if ($result->statusDesenho == 3) {
                                    echo '<option value="3" selected>Completo</option>';
                                  } else {
                                    echo '<option value="3">Completo</option>';
                                  }
                                  ?>
                                </select>
                              <?php
                              } else { ?>
                                <b>Status Desenho:</b>
                                <select name='statusDesenho' id='statusDesenho' disabled>
                                  <?php if ($result->statusDesenho == 1) {
                                    echo '<option value="1" selected>Sem Desenho</option>';
                                  } else {
                                    echo '<option value="1">Sem Desenho</option>';
                                  }
                                  if ($result->statusDesenho == 2) {
                                    echo '<option value="2" selected>Incompleto</option>';
                                  } else {
                                    echo '<option value="2">Incompleto</option>';
                                  }
                                  if ($result->statusDesenho == 3) {
                                    echo '<option value="3" selected>Completo</option>';
                                  } else {
                                    echo '<option value="3">Completo</option>';
                                  }
                                  ?>
                                </select>
                                
                              <?php
                              } ?>
                              <?php 
                                if(count($alteracoesDesenho)>0){?>
                                  <a href="#modalUltimasAlteracoesDesenho" data-toggle="modal" role="button" class="btn btn-primary" ><i class="icon-eye-open"></i></a>
                                <?php 
                                }?>
                              Histórico de alterações Desenho
                              </br>
                              <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'adesenhoOs')) {
                              ?>
                                <button type="submit" class="btn btn-success" style="margin-left:25%; margin-top:10px" name="btnAlterarDesenho" value="btnAlterarDesenho"><i class="icon-plus icon-white"></i> Alterar Status e OBS </br> Desenho</button>
                              <?php } ?>
                            </td>
                            <td Valign="top" style="border-left:0px">
                              <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'adesenhoOs')) {
                              ?>
                                <b>OBS Desenho:</b>
                                <textarea id="obs_desenho" rows="2" cols="100" class="span12" name="obs_desenho"><?php echo ($result->obsDesenho); ?></textarea>
                              <?php
                              } else { ?>
                                <b>OBS Desenho:</b>
                                <textarea disabled id="obs_desenho" rows="2" cols="100" class="span12" name="obs_desenho"><?php echo ($result->obsDesenho); ?></textarea>
                              <?php
                              } ?>
                            </td>


                          </tr>



                        </table>
                      </td>
                    </tr>



                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
                    ?>


                      <tr>
                        <td colspan='8' align='center'>
                          <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Alterar</button>

                        </td>
                      </tr>

                    <?php
                    } ?>
                  </table>



                </form>



              </div><!-- div principal ao entrar -->
              


              <div class="tab-pane" id="tab2">
                <div class="span12 well" style="padding: 1%; margin-left: 0">
                  <!--<div class="span12" style="padding: 1%">-->
                  <div class="span2" class="control-group">
                    <label for="item" class="control-label">Num. Pedido: <?php echo $result->numpedido_os; ?>
                      <?php
                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'apedidoOs')) {
                      ?>
                        <a href="#modal_cad_pedido<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span2"> <i class="icon-plus icon-white"> </i> </a>
                      <?php
                      }
                      ?></label>
                    <br>


                    <?php
                    foreach ($anexo_pedido as $pedido) {


                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'apedidoOs')) {
                    ?>
                        <a href="#modalAlterarpedido<?php echo $pedido->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>



                        <a href="#modal-excluirpedido<?php echo $pedido->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $pedido->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir pedido"><i class="icon-remove icon-white"></i></a>
                      <?php
                      }

                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vpedidoOs')) {

                      ?>
                        <a href='<?php echo base_url() . $pedido->caminho . $pedido->imagem; ?>' target='_blank'><?php echo $pedido->nomeArquivo . $pedido->extensao; ?></a>
                      <?php
                      }
                      echo "<br>";
                      ?>
                      <div id="modalAlterarpedido<?php echo $pedido->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h5 id="myModalLabel">Alterar pedido OS:<?php echo $result->idOs; ?></h5>
                        </div>
                        <div class="modal-body">
                          <form action="<?php echo base_url(); ?>index.php/os/editar_pedido" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
                            <div class="control-group">
                              <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                              <div class="controls">



                                <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $pedido->nomeArquivo; ?>" />
                                <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
                                <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $pedido->idAnexo; ?>" />
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
                        <form action="<?php echo base_url() ?>index.php/os/excluirpedido" method="post">
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
                    <?php
                    }
                    ?>




                  </div>

                  <div class="span2" class="control-group">
                    <label for="item" class="control-label"> Num. Nota Serviço: <?php echo $result->numero_nf; ?>
                      <?php
                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'anotafiscalOs')) {
                      ?>
                        <a href="#modal_cad_nf<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span2"> <i class="icon-plus icon-white"> </i> </a>
                      <?php
                      }
                      ?></label>
                    <br>


                    <?php
                    foreach ($anexo_nf as $nf) {


                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'anotafiscalOs')) {
                    ?>
                        <a href="#modalAlterarnf<?php echo $nf->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>



                        <a href="#modal-excluirnf<?php echo $nf->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $nf->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir NF"><i class="icon-remove icon-white"></i></a>
                      <?php
                      }

                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vnotafiscalOs')) {

                      ?>
                        <a href='<?php echo base_url() . $nf->caminho . $nf->imagem; ?>' target='_blank'><?php echo $nf->nomeArquivo . $nf->extensao; ?></a>
                      <?php
                      }
                      echo "<br>";
                      ?>
                      <div id="modalAlterarnf<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h5 id="myModalLabel">Alterar NF OS:<?php echo $result->idOs; ?></h5>
                        </div>
                        <div class="modal-body">
                          <form action="<?php echo base_url(); ?>index.php/os/editar_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
                            <div class="control-group">
                              <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                              <div class="controls">



                                <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $nf->nomeArquivo; ?>" />
                                <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
                                <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $nf->idAnexo; ?>" />
                                <input id="table" type="hidden" name="table" value="anexo_notafiscal" />
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
                        <form action="<?php echo base_url() ?>index.php/os/excluirnf" method="post">
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
                    <?php
                    }
                    ?>




                  </div>
                  <div class="span2" class="control-group">
                    <label for="item" class="control-label"> NF Cliente: <?php echo $result->nf_cliente; ?>
                      <?php
                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'anotafiscalOs')) {
                      ?>
                        <a href="#modal_cad_nf_cli<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span2"> <i class="icon-plus icon-white"> </i> </a>
                      <?php
                      }
                      ?></label>
                    <br>


                    <?php
                    foreach ($anexo_nfcliente as $nf) {


                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'anotafiscalOs')) {
                    ?>
                        <a href="#modalAlterarnf_cli<?php echo $nf->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>



                        <a href="#modal-excluirnfcli<?php echo $nf->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $nf->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir NF"><i class="icon-remove icon-white"></i></a>
                      <?php
                      }

                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vnotafiscalOs')) {

                      ?>
                        <a href='<?php echo base_url() . $nf->caminho . $nf->imagem; ?>' target='_blank'><?php echo $nf->nomeArquivo . $nf->extensao; ?></a>
                      <?php
                      }
                      echo "<br>";
                      ?>
                      <div id="modalAlterarnf_cli<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h5 id="myModalLabel">Alterar NF Cliente OS:<?php echo $result->idOs; ?></h5>
                        </div>
                        <div class="modal-body">
                          <form action="<?php echo base_url(); ?>index.php/os/editar_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
                            <div class="control-group">
                              <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                              <div class="controls">



                                <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $nf->nomeArquivo; ?>" />
                                <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
                                <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $nf->idAnexo; ?>" />
                                <input id="table" type="hidden" name="table" value="anexo_nfcliente" />
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
                        <form action="<?php echo base_url() ?>index.php/os/excluirnf" method="post">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 id="myModalLabel">Excluir NF Cliente</h5>
                          </div>
                          <div class="modal-body">
                            <input type="hidden" id="idAnexo" name="idAnexo" value="<?php echo $nf->idAnexo; ?>" />
                            <input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
                            <input type="hidden" id="imagem" name="imagem" value="<?php echo $nf->imagem; ?>" />
                            <input id="table" type="hidden" name="table" value="anexo_nfcliente" />
                            <h5 style="text-align: center">Deseja realmente excluir esta NF de cliente?</h5>
                          </div>
                          <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                            <button class="btn btn-danger">Excluir</button>
                          </div>
                        </form>
                      </div>
                    <?php
                    }
                    ?>




                  </div>
                  <div class="span2" class="control-group">
                    <label for="item" class="control-label">NF Dev.| Fabricaçao: <?php echo $result->nf_venda_dev; ?>
                      <?php
                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'anotafiscalOs')) {
                      ?>
                        <a href="#modal_cad_nf_dev<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span2"> <i class="icon-plus icon-white"> </i> </a>
                      <?php
                      }
                      ?></label>
                    <br>


                    <?php
                    foreach ($anexo_nfvenda as $nf) {


                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'anotafiscalOs')) {
                    ?>
                        <a href="#modalAlterarnfdev<?php echo $nf->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>



                        <a href="#modal-excluirnf<?php echo $nf->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $nf->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir NF"><i class="icon-remove icon-white"></i></a>
                      <?php
                      }

                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vnotafiscalOs')) {

                      ?>
                        <a href='<?php echo base_url() . $nf->caminho . $nf->imagem; ?>' target='_blank'><?php echo $nf->nomeArquivo . $nf->extensao; ?></a>
                      <?php
                      }
                      echo "<br>";
                      ?>
                      <div id="modalAlterarnfdev<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h5 id="myModalLabel">Alterar NF OS:<?php echo $result->idOs; ?></h5>
                        </div>
                        <div class="modal-body">
                          <form action="<?php echo base_url(); ?>index.php/os/editar_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
                            <div class="control-group">
                              <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                              <div class="controls">



                                <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $nf->nomeArquivo; ?>" />
                                <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
                                <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $nf->idAnexo; ?>" />
                                <input id="table" type="hidden" name="table" value="anexo_nfvenda" />
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
                        <form action="<?php echo base_url() ?>index.php/os/excluirnf" method="post">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 id="myModalLabel">Excluir NF</h5>
                          </div>
                          <div class="modal-body">
                            <input type="hidden" id="idAnexo" name="idAnexo" value="<?php echo $nf->idAnexo; ?>" />
                            <input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
                            <input type="hidden" id="imagem" name="imagem" value="<?php echo $nf->imagem; ?>" />
                            <input id="table" type="hidden" name="table" value="anexo_nfvenda" />
                            <h5 style="text-align: center">Deseja realmente excluir esta NF?</h5>
                          </div>
                          <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                            <button class="btn btn-danger">Excluir</button>
                          </div>
                        </form>
                      </div>
                    <?php
                    }
                    ?>




                  </div>
                  <div class="span2" class="control-group">
                    <label for="item" class="control-label">Canhoto NF: <?php echo $result->nf_canhoto; ?>
                      <?php
                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'anotafiscalOs')) {
                      ?>
                        <a href="#modal_cad_nf_canhoto<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span2"> <i class="icon-plus icon-white"> </i> </a>
                      <?php
                      }
                      ?></label>
                    <br>


                    <?php
                    foreach ($anexo_nfcanhoto as $nf) {


                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'anotafiscalOs')) {
                    ?>
                        <a href="#modalAlterarnfcanhoto<?php echo $nf->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>



                        <a href="#modal-excluirnfcanhoto<?php echo $nf->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $nf->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir NF"><i class="icon-remove icon-white"></i></a>
                      <?php
                      }

                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vnotafiscalOs')) {

                      ?>
                        <a href='<?php echo base_url() . $nf->caminho . $nf->imagem; ?>' target='_blank'><?php echo $nf->nomeArquivo . $nf->extensao; ?></a>
                      <?php
                      }
                      echo "<br>";
                      ?>
                      <div id="modalAlterarnfcanhoto<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h5 id="myModalLabel">Alterar Canhoto O.S.:<?php echo $result->idOs; ?></h5>
                        </div>
                        <div class="modal-body">
                          <form action="<?php echo base_url(); ?>index.php/os/editar_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
                            <div class="control-group">
                              <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                              <div class="controls">



                                <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $nf->nomeArquivo; ?>" />
                                <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
                                <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $nf->idAnexo; ?>" />
                                <input id="table" type="hidden" name="table" value="anexo_nfcanhoto" />
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
                              <button class="btn btn-primary">Alterar</button>
                            </div>
                          </form>
                        </div>


                      </div>
                      <div id="modal-excluirnfcanhoto<?php echo $nf->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <form action="<?php echo base_url() ?>index.php/os/excluirnf" method="post">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 id="myModalLabel">Excluir Canhoto O.S.:<?php echo $result->idOs; ?></h5>
                          </div>
                          <div class="modal-body">
                            <input type="hidden" id="idAnexo" name="idAnexo" value="<?php echo $nf->idAnexo; ?>" />
                            <input type="hidden" id="idOs" name="idOs" value="<?php echo $result->idOs; ?>" />
                            <input type="hidden" id="imagem" name="imagem" value="<?php echo $nf->imagem; ?>" />
                            <input id="table" type="hidden" name="table" value="anexo_nfcanhoto" />
                            <h5 style="text-align: center">Deseja realmente excluir esta NF?</h5>
                          </div>
                          <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                            <button class="btn btn-danger">Excluir</button>
                          </div>
                        </form>
                      </div>
                    <?php
                    }
                    ?>




                  </div>
                </div>
              </div><!-- fecha div aba de anexo -->

              <div class="tab-pane" id="tab3">
                <div class="span12 well" style="padding: 1%; margin-left: 0">
                  <table class="table table-bordered ">
                    <thead>
                      <tr>

                        <th>ID</th>

                        <th>Qtd.</th>
                        <th>Material</th>
                        <th>Dimensões</th>
                        <th>OBS</th>
                        <th>Data Cadastro</th>
                        <th>Data Alteração</th>
                        <th>Previsão Entrega</th>
                        <th>Status</th>
                        <th>Valor Total</th>
                        <th>Solicitante</th>


                      </tr>
                    </thead>
                    <tbody>



                      <?php
                      $somaValorTotal = 0;
                      foreach ($distribuir_os as $dist) {

                        if ($dist->data_alteracao <> '') {
                          $data_alteracao = date("d/m/Y H:i:s", strtotime($dist->data_alteracao));
                        } else {
                          $data_alteracao = "";
                        }
                        $somaValorTotal = $somaValorTotal + ($dist->valor_unitario * $dist->quantidade)*(1+$dist->ipi_valor/100);
                      ?>
                        <tr>
                          <td>
                            <?php echo $dist->idDistribuir; ?>
                          </td>

                          <td>
                            <?php echo $dist->quantidade; ?>
                          </td>
                          <td>
                            <?php echo $dist->descricaoInsumo; ?>
                          </td>
                          <td>
                            <?php echo $dist->dimensoes; ?>
                          </td>
                          <td>
                            <?php echo $dist->obs; ?>
                          </td>
                          <td>
                            <?php echo date("d/m/Y H:i:s", strtotime($dist->datacadastro));  ?>

                          </td>
                          <td>
                            <?php echo $data_alteracao; ?>
                          </td>
                          <td>
                            <?php if (!empty($dist->previsao_entrega)) {
                              echo date("d/m/Y", strtotime($dist->previsao_entrega));
                            } ?>
                          </td>
                          <td>
                            <?php echo $dist->nomeStatus; ?>
                          </td>
                          <!---->
                          <td>
                            <?php echo 'R$ ' . number_format((float)($dist->valor_unitario * $dist->quantidade)*(1+$dist->ipi_valor/100), 2, ',', '.'); ?>
                          </td>
                          <td>
                            <?php echo $dist->nome; ?>
                          </td>







                        <?php
                        //$somaValorTotal = $somaValorTotal + $dist->valor_total;

                      }
                        ?>


                    </tbody>
                  </table>
                  <table class="table table-bordered ">
                    <tr>
                      <th>Frete: <?php echo 'R$ ' . number_format((float)$valor_frete, 2, ',', '.'); ?></th>
                      <th>ICMS: <?php echo 'R$ ' . number_format((float)$valorIcms, 2, ',', '.'); ?></th>
                      <th>Total Produtos: <?php echo 'R$ ' . number_format((float)$somaValorTotal, 2, ',', '.'); ?></th>
                    </tr>
                  </table>
                  <!--
                  <div style="text-align: right">
                    Total Produtos: <?php echo 'R$ ' . number_format((float)$somaValorTotal, 2, ',', '.'); ?>
                  </div>
                  <div style="text-align: right">
                    Frete: <?php echo 'R$ ' . number_format((float)$valor_frete, 2, ',', '.'); ?>
                  </div>
                  <div style="text-align: right">
                    ICMS: <?php echo 'R$ ' . number_format((float)$valorIcms, 2, ',', '.'); ?>
                  </div>-->

                </div>

              </div>

              <!-- fecha div aba insumos e abre maquinas -->


              <div class="tab-pane" id="tab4">
                <div class="span12 well" style="padding: 1%; margin-left: 0">
                  <table class="table table-bordered ">
                    <thead>
                      <tr>
                        <th>Máquina</th>
                        <th>PN</th>
                        <!--
                        <th>Operação</th>  
                        <th colspan="2">Tempo de Preparação</th>
                        <th colspan="2">Tempo de Fabricação do Lote</th> -->
                        <th>Qtd. Fabricado</th>
                        <th>Tempo Utilizado</th>
                        <th>Valor hora | homem | máquina</th>
                      </tr>
                      <!--
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>   
                      <th>Inicio</th>
                      <th>Fim</th>
                      <th>Inicio</th>
                      <th>Fim</th>
                      <th></th>
                      <th></th>
                    </tr>-->
                    </thead>
                    <tbody>
                      <?php
                      $somaValorTotalHrMq = 0;
                      $total = new DateTime('00:00');
                      foreach ($hrmaquina_os as $r) {
                        if (!empty($r->horaEntradaPreparacao)) {
                          $date = new DateTime($r->horaEntradaPreparacao);
                          $horaEntradaPreparacao = str_replace("-", "/", $date->format('d-m-Y H:i:s'));
                        } else {
                          $horaEntradaPreparacao = '';
                        }
                        if (!empty($r->horaSaidaPreparacao)) {
                          $date = new DateTime($r->horaSaidaPreparacao);
                          $horaSaidaPreparacao = str_replace("-", "/", $date->format('d-m-Y H:i:s'));
                        } else {
                          $horaSaidaPreparacao = '';
                        }
                        if (!empty($r->horaEntradaFabricacao)) {
                          $date = new DateTime($r->horaEntradaFabricacao);
                          $horaEntradaFabricacao = str_replace("-", "/", $date->format('d-m-Y H:i:s'));
                        } else {
                          $horaEntradaFabricacao = '';
                        }
                        if (!empty($r->horaSaidaFabricacao)) {
                          $date = new DateTime($r->horaSaidaFabricacao);
                          $horaSaidaFabricacao = str_replace("-", "/", $date->format('d-m-Y H:i:s'));
                        } else {
                          $horaSaidaFabricacao = '';
                        }
                        if (!empty($r->horaEntradaPreparacao) && !empty($r->horaSaidaPreparacao)) {
                          $hrEntrPrep = new DateTime($r->horaSaidaPreparacao);
                          $hrSaidPrep = new DateTime($r->horaEntradaPreparacao);
                          $diffDataPreparacao = $hrSaidPrep->diff($hrEntrPrep);
                        } else {
                          $diffDataPreparacao = '';
                        }
                        if (!empty($r->horaEntradaFabricacao) && !empty($r->horaSaidaFabricacao)) {
                          $hrEntrFab = new DateTime($r->horaEntradaFabricacao);
                          $hrSaidFab = new DateTime($r->horaSaidaFabricacao);
                          $diffDataFabricacao = $hrSaidFab->diff($hrEntrFab);
                        } else {
                          $diffDataFabricacao = '';
                        }
                        if (!empty($diffDataFabricacao) && !empty($diffDataPreparacao)) {
                          $e = new DateTime('00:00');
                          $f = clone $e;
                          echo ("<script>console.log('HR " . $diffDataFabricacao->h . ":" . $diffDataFabricacao->i . "');</script>");
                          echo ("<script>console.log('HR " . $diffDataPreparacao->h . ":" . $diffDataPreparacao->i . "');</script>");
                          $minutos = ($diffDataFabricacao->i + $diffDataPreparacao->i) / 60;
                          $horas = intval($minutos) + $diffDataFabricacao->h + $diffDataPreparacao->h;
                          $minutos = $minutos - intval($minutos);

                          $minutos = $minutos * 60;
                          // $e->add($diffDataFabricacao);
                          //$e->add($diffDataPreparacao);
                          //$total->add($diffDataFabricacao);
                          //$total->add($diffDataPreparacao);
                          //$hours = $f->diff($e)->h;
                          //$hours = $hours + ($f->diff($e)->days*24);
                          //$diffTempoGasto = $f->diff($e)->format("%H:%I");
                          $diffTempoGasto = $horas . ":" . $minutos;
                        } else if (!empty($diffDataFabricacao)) {
                          $total->add($diffDataFabricacao);
                          $hours = $diffDataFabricacao->h;
                          $hours = $hours + ($diffDataFabricacao->days * 24);
                          $diffTempoGasto = $hours . $diffDataFabricacao->format(":%I");
                        } else if (!empty($diffDataPreparacao)) {
                          $total->add($diffDataPreparacao);
                          $hours = $diffDataPreparacao->h;
                          $hours = $hours + ($diffDataPreparacao->days * 24);
                          $diffTempoGasto = $diffDataPreparacao->format(":%I");
                        } else {
                          $diffTempoGasto = '';
                        }
                        /**/
                        echo '<tr>';
                        echo '<td>';
                        echo $r->descricao;
                        echo '</td>';
                        echo '<td>';
                        echo $r->pn;
                        echo '</td>';/*
                        echo '<td>';
                          echo $r->operacao;
                        echo '</td>';
                        echo '<td>';
                          echo $horaEntradaPreparacao;
                        echo '</td>';
                        echo '<td>';
                          echo $horaSaidaPreparacao;
                        echo '</td>';
                        echo '<td>';
                          echo $horaEntradaFabricacao;
                        echo '</td>';
                        echo '<td>';
                          echo $horaSaidaFabricacao;
                        echo '</td>';*/
                        echo '<td>';
                        echo $r->quantidadeFabricada;
                        echo '</td>';
                        echo '<td>';
                        echo $diffTempoGasto;
                        echo '</td>';
                        echo '<td>';
                        echo "R$ " . number_format((float)(((explode(":", $diffTempoGasto)[0]) * 300) + (300 * ((explode(":", $diffTempoGasto)[1]) / 60))), 2, ',', '.');
                        echo '</td>';
                        echo '</tr>';
                        $somaValorTotalHrMq = $somaValorTotalHrMq + (((explode(":", $diffTempoGasto)[0]) * 300) + (300 * ((explode(":", $diffTempoGasto)[1]) / 60)));
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div style="text-align: right">
                  Total: <?php echo 'R$ ' . number_format((float)$somaValorTotalHrMq, 2, ',', '.'); ?>
                </div>


                <!-- fecha maquina -->

                <!--<div class="widget-content" id="printOs">
                <div class="invoice-content">
                  ddd
              
                </div>
                  </div>-->
              </div>

              <div class="tab-pane" id="tab5">
                <div class="span12 well" style="padding: 1%; margin-left: 0">
                  <table class="table table-bordered ">
                    <thead>
                      <tr>
                        <th>ICMS</th>
                        <th>Frete</th>
                        <th>Valor Insumo</th>
                        <th>Valor Hora / Homem / Maq.</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        echo '<tr>';
                          echo '<td>';
                            echo 'R$ ' . number_format((float)$valorIcms, 2, ',', '.'); 
                          echo '</td>';
                          echo '<td>';
                            echo 'R$ ' . number_format((float)$valor_frete, 2, ',', '.'); 
                          echo '</td>';
                          echo '<td>';
                            echo 'R$ ' . number_format((float)$somaValorTotal, 2, ',', '.'); 
                          echo '</td>';
                          echo '<td>';
                            echo 'R$ ' . number_format((float)$somaValorTotalHrMq, 2, ',', '.'); 
                          echo '</td>';
                          echo '<td>';
                            echo 'R$ ' . number_format((float)$somaValorTotalHrMq+$somaValorTotal+$valorIcms+$valor_frete, 2, ',', '.'); 
                          echo '</td>';
                        echo '</tr>';
                      ?>



                    </tbody>
                  </table><!--
                  <div style="text-align: right">
                    Total: <?php echo 'R$ ' . number_format((float)$somaValorTotal, 2, ',', '.'); ?>
                  </div>-->

                </div>
              </div>
            </div>




          </div>

        </div>
      </div>
    </div>
    <div style="display: block ruby;">
      <h5>Legenda:</h5>
      <div style="padding:8px">
        Completo <a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>|
        Incompleto <a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>|
        Sem desenho <a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a>
      </div>
    </div>
    <!--desenho-->
    <div class="row-fluid" style="margin-top:0">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title">
            <span class="icon">
              <i class="icon-tags"></i>
            </span>
            <h5>
              <font color='blue' size='3'>Anexos O.S.</font>


            </h5> <?php
                  if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aAnexo')) {
                  ?>

              <a href="#modal_cad_desenho<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-success span2"><i class="icon-plus icon-white"> Adicionar</i> </a>

            <?php
                  }
            ?>
            <span class="icon">
              <i 'class="icon-tags"></i>
                </span>
                <h5><font color=' blue' size='3'>Status Desenho: <?php if ($result->statusDesenho == 1) {
                                                                    echo '<a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a>';
                                                                  } else if ($result->statusDesenho == 2) {
                                                                    echo '<a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>';
                                                                  } else {
                                                                    echo '<a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>';
                                                                  } ?></font>
          </div>

          <div class="widget-content nopadding">


            <table class="table table-bordered ">
              <thead>
                <tr>

                  <th>Nome arquivo | Donwload</th>
                  <th>Tipo</th>
                  <th>Data cadastro</th>
                  <th>Usuário proprietário</th>

                  <th></th>
                </tr>
              </thead>
              <?php

              if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vdesenhoOs')) {
              ?>
                <tbody>

                  <?php
                  foreach ($anexo_desenho as $desenho) {
                  ?>
                    <tr>
                      <td>

                        <a href='<?php echo base_url() . $desenho->caminho . $desenho->imagem; ?>' target='_blank'><?php echo $desenho->nomeArquivo . $desenho->extensao; ?></a>
                      </td>
                      <td>
                        <?php echo $desenho->tipo;  ?>
                      </td>
                      <td>
                        <?php echo date("d/m/Y h:i:s", strtotime($desenho->data_cadastro));  ?>

                      </td>
                      <td>
                        <?php echo $desenho->user;  ?>

                      </td>

                      <td>
                        <?php
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eAnexo')) {
                          if ($this->session->userdata('idUsuarios') == $desenho->user_proprietario || $this->session->userdata('idUsuarios') == '1' || (($this->session->userdata('idUsuarios') == '12' || $this->session->userdata('idUsuarios') == '13' || $this->session->userdata('idUsuarios') == '59') && ($desenho->user_proprietario == '13' || $desenho->user_proprietario == '12' || $desenho->user_proprietario == '59'))) {
                        ?>
                            <a href="#modalAlteraranexo<?php echo $desenho->idAnexo; ?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>



                            <a href="#modal-excluir<?php echo $desenho->idAnexo; ?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $desenho->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir desenho"><i class="icon-remove icon-white"></i></a>
                        <?php
                          }
                        }
                        ?>

                      </td>
                      <div id="modalAlteraranexo<?php echo $desenho->idAnexo; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h5 id="myModalLabel">Alterar Desenho OS:<?php echo $result->idOs; ?></h5>
                        </div>
                        <div class="modal-body">
                          <form action="<?php echo base_url(); ?>index.php/os/editar_anexo" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
                            <div class="control-group">
                              <label for="nomeArquivo" class="control-label">Nome<span class="required">*</span></label>
                              <div class="controls">



                                <input id="nomeArquivo" type="text" name="nomeArquivo" value="<?php echo $desenho->nomeArquivo; ?>" />
                                <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
                                <input id="idAnexo" type="hidden" name="idAnexo" value="<?php echo $desenho->idAnexo; ?>" />
                                <label for="obs_controle" class="control-label">Tipo</label>
                                <div class="controls">
                                  <select name="tipo" id="tipo">
                                    <option value="CATÁLOGO" <?php if ($desenho->tipo == "CATÁLOGO") {
                                                                echo "selected";
                                                              } ?>>Catálogo</option>
                                    <?php
                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'adesenhoOs')) { ?>
                                      <option value="DESENHO" <?php if ($desenho->tipo == "DESENHO") {
                                                                echo "selected";
                                                              } ?>>Desenho</option>
                                    <?php } ?>
                                    <?php
                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aPeritagem')) { ?>
                                      <option value="PERITAGEM" <?php if ($desenho->tipo == "PERITAGEM") {
                                                                  echo "selected";
                                                                } ?>>Peritagem</option>
                                    <?php } ?>

                                    <option value="OUTROS" <?php if ($desenho->tipo == "OUTROS") {
                                                              echo "selected";
                                                            } ?>>Outros</option>
                                  </select>
                                </div>
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
                        <form action="<?php echo base_url() ?>index.php/os/excluiranexo" method="post">
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
                    </tr>
                  <?php
                  }
                  ?>

                </tbody>
              <?php
              }
              ?>
            </table>
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
        <form action="<?php echo base_url(); ?>index.php/os/editaobs_os" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="obs_os" class="control-label">Observação OS<span class="required">*</span></label>
            <div class="controls">
              <textarea id="obs_os" rows="5" cols="50" class="span10" name="obs_os"><?php echo $result->obs_os; ?></textarea>


              <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
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
        <?php echo ($result->obs_controle); ?>

      </div>


    </div>
    <div id="modalAlterarcontroleos<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterar Observação Controle OS: <?php echo $result->idOs; ?></h5>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url(); ?>index.php/os/editaobs_os" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="obs_controle" class="control-label">Observação Controle OS<span class="required">*</span></label>
            <div class="controls">
              <textarea id="obs_controle" rows="5" cols="50" class="span10" name="obs_controle"><?php echo ($result->obs_controle); ?></textarea>


              <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
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
        <form action="<?php echo base_url(); ?>index.php/os/cad_desenho" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="obs_controle" class="control-label">Nome arquivo</label>
            <div class="controls">
              <input id="nomeArquivo" type="text" name="nomeArquivo" value="" />


              <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
            </div>
            <label for="obs_controle" class="control-label">Tipo</label>
            <div class="controls">
              <select name="tipo" id="tipo">
                <option value="CATÁLOGO">Catálogo</option>
                <?php
                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'adesenhoOs')) { ?>
                  <option value="DESENHO" <?php if ($this->session->userdata('permissao') == "7") {
                                            echo 'selected';
                                          } ?>>Desenho</option>
                <?php } ?>
                <?php
                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aPeritagem')) { ?>
                  <option value="PERITAGEM">Peritagem</option>
                <?php } ?>

                <option value="OUTROS">Outros</option>
              </select>
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
        <form action="<?php echo base_url(); ?>index.php/os/cad_pedido" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="obs_controle" class="control-label">Nome arquivo</label>
            <div class="controls">
              <input id="nomeArquivo" type="text" name="nomeArquivo" value="" />


              <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
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
        <form action="<?php echo base_url(); ?>index.php/os/cad_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="obs_controle" class="control-label">Nome arquivo</label>
            <div class="controls">
              <input id="nomeArquivo" type="text" name="nomeArquivo" value="" />

              <input id="table" type="hidden" name="table" value="anexo_notafiscal" />
              <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
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
        <form action="<?php echo base_url(); ?>index.php/os/cad_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="obs_controle" class="control-label">Nome arquivo</label>
            <div class="controls">
              <input id="nomeArquivo" type="text" name="nomeArquivo" value="" />


              <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
              <input id="table" type="hidden" name="table" value="anexo_nfcliente" />
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
        <form action="<?php echo base_url(); ?>index.php/os/cad_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="obs_controle" class="control-label">Nome arquivo</label>
            <div class="controls">
              <input id="nomeArquivo" type="text" name="nomeArquivo" value="" />

              <input id="table" type="hidden" name="table" value="anexo_nfvenda" />
              <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
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
    <div id="modal_cad_nf_canhoto<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Cadastrar Canhoto OS: <?php echo $result->idOs; ?></h5>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url(); ?>index.php/os/cad_nf" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="obs_controle" class="control-label">Nome arquivo</label>
            <div class="controls">
              <input id="nomeArquivo" type="text" name="nomeArquivo" value="" />

              <input id="table" type="hidden" name="table" value="anexo_nfcanhoto" />
              <input id="idOs" type="hidden" name="idOs" value="<?php echo $result->idOs; ?>" />
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
    <div id="modalUltimasAlteracoes" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterações de Status: <?php echo $result->idOs; ?></h5>
      </div>
      <div class="modal-body">
        <div class="widget-content nopadding">
          <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
            <thead>
              <tr>
                <th>
                  Data Alteração
                </th>
                <th>
                  Status
                </th>
                <th>
                  Usuário
                </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($alteracoesStatus as $r){
                echo '<tr>';
                  echo '<td>';
                    $date = new DateTime( $r->data_alteracaoHis );
                    echo $date-> format( 'd/m/Y H:i' );
                  echo '</td>';
                  echo '<td>';
                    echo $r->nomeStatusOs;
                  echo '</td>';
                  echo '<td>';
                    echo $r->nome;
                  echo '</td>';
                echo '</tr>';
              }?>
              
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <div id="modalUltimasAlteracoesControle" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterações de Controle: <?php echo $result->idOs; ?></h5>
      </div>
      <div class="modal-body">
        <div class="widget-content nopadding">
          <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
            <thead>
              <tr>
                <th>
                  Data Alteração
                </th>
                <th>
                  Status
                </th>
                <th>
                  Usuário
                </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($alteracoesCont as $r){
                echo '<tr>';
                  echo '<td>';
                    $date = new DateTime( $r->data_alteracaoHis );
                    echo $date->format( 'd/m/Y H:i' );
                  echo '</td>';
                  echo '<td>';
                    echo $r->descricaoControle;
                  echo '</td>';
                  echo '<td>';
                    echo $r->nome;
                  echo '</td>';
                echo '</tr>';
              }?>
              
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <div id="modalUltimasAlteracoesDesenho" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterações de Status Desenho: <?php echo $result->idOs; ?></h5>
      </div>
      <div class="modal-body">
        <div class="widget-content nopadding">
          <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
            <thead>
              <tr>
                <th>
                  Data Alteração
                </th>
                <th>
                  Status
                </th>
                <th>
                  Usuário
                </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($alteracoesDesenho as $r){
                echo '<tr>';
                  echo '<td>';
                    $date = new DateTime( $r->data_alteracaoHis );
                    echo $date-> format( 'd/m/Y H:i' );
                  echo '</td>';
                  echo '<td>';
                    if($r->statusDesenho == 1){
                      echo 'Sem desenho';
                    }
                    if($r->statusDesenho == 2){
                      echo 'Incompleto';
                    }
                    if($r->statusDesenho == 3){
                      echo 'Completo';
                    }
                    
                  echo '</td>';
                  echo '<td>';
                    echo $r->nome;
                  echo '</td>';
                echo '</tr>';
              }?>
              
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <script type="text/javascript">
      function alterarStatus(select,idOs){/**/
        $.ajax({
          url:"<?php echo base_url();?>index.php/os/alterarstatusos",
          type: 'POST',
          dataType: 'json',
          async:false,
          data: {
              idOs:idOs,
              idStatusOs:select.value
          },
          success: function(data){
            alert(data.msg);
            window.location.reload();
          },
          error: function(xhr, textStatus, error){
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
          }
        })
      }
      $(document).ready(function() {

        jQuery(".data").mask("99/99/9999");
      });


      $(function() {
        $(document).on('click', 'input[type=text][id=example1]', function() {
          this.select();
        });
      });


      function calculaSubTotal() {

        var qtd = $('#qtd_os').val();
        var qtd_os_original = $('#qtd_os_original').val();
        if (qtd < qtd_os_original) {
          alert('Atenção, você alterou a qtd de itens, será gerada nova OS!');
        }


        //alert(contador_global_autocomplete);
        var valorunit = $('#val_unit_os').val();
        valorunit = valorunit.toString().replaceAll(".", "");
        valorunit = valorunit.toString().replaceAll(",", ".");

        valorunit = parseFloat(valorunit);

        /*valorunit=	valorunit.replace(/\./g, "");
        valorunit=	valorunit.replace(/,/g, ".");*/

        var desconto = $('#desconto_os').val();
        desconto = desconto.toString().replace(".", "");
        desconto = desconto.toString().replace(",", ".");
        /*desconto=	desconto.replace(/\./g, "");
        desconto=	desconto.replace(/,/g, ".");*/

        desconto = parseFloat(desconto);

        var valoripi = $('#val_ipi_os').val();
        valoripi = valoripi.toString().replace(".", "");
        valoripi = valoripi.toString().replace(",", ".");
        /*desconto=	desconto.replace(/\./g, "");
        desconto=	desconto.replace(/,/g, ".");*/

        valoripi = parseFloat(valoripi);
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
        var total1 = (valorunit * qtd) - desconto;
        var total2 = total1 * valoripi / 100;

        total1 = parseFloat(total1);
        total2 = parseFloat(total2);
        var total3 = total1 + total2;

        total3 = parseFloat(total3);



        //alert(total3);

        $('#subtot_os').val(retorna_formatado(total1));
        $('#total').val(retorna_formatado(total3));







      }

      function retorna_formatado(num) {

        x = 0;

        if (num < 0) {
          num = Math.abs(num);
          x = 1;
        }

        if (isNaN(num)) num = "0";
        cents = Math.floor((num * 100 + 0.5) % 100);

        num = Math.floor((num * 100 + 0.5) / 100).toString();

        if (cents < 10) cents = "0" + cents;
        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
          num = num.substring(0, num.length - (4 * i + 3)) + '.' +
          num.substring(num.length - (4 * i + 3));

        ret = num + ',' + cents;

        if (x == 1) ret = ' - ' + ret;
        return ret;

      }


      function FormataValor2(objeto, teclapres, tammax, decimais) {
        var tecla = teclapres.keyCode;
        var tamanhoObjeto = objeto.value.length;



        if ((tecla == 8) && (tamanhoObjeto == tammax))
          tamanhoObjeto = tamanhoObjeto - 1;



        if ((tecla == 8 || tecla == 88 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) && ((tamanhoObjeto + 1) <= tammax)) {

          vr = objeto.value;
          vr = vr.replace("/", "");
          vr = vr.replace("/", "");
          vr = vr.replace(",", "");
          vr = vr.replace(".", "");
          vr = vr.replace(".", "");
          vr = vr.replace(".", "");
          vr = vr.replace(".", "");
          tam = vr.length;

          if (tam < tammax && tecla != 8)
            tam = vr.length + 1;

          if ((tecla == 8) && (tam > 1)) {
            tam = tam - 1;
            vr = objeto.value;
            vr = vr.replace("/", "");
            vr = vr.replace("/", "");
            vr = vr.replace(",", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
            vr = vr.replace(".", "");
          }

          //Cálculo para casas decimais setadas por parametro
          if (tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) {
            if (decimais > 0) {
              if ((tam <= decimais))
                objeto.value = ("0," + vr);

              if ((tam == (decimais + 1)) && (tecla == 8))
                objeto.value = vr.substr(0, (tam - decimais)) + ',' + vr.substr(tam - (decimais), tam);

              if ((tam > (decimais + 1)) && (tam <= (decimais + 3)) && ((vr.substr(0, 1)) == "0"))
                objeto.value = vr.substr(1, (tam - (decimais + 1))) + ',' + vr.substr(tam - (decimais), tam);

              if ((tam > (decimais + 1)) && (tam <= (decimais + 3)) && ((vr.substr(0, 1)) != "0"))
                objeto.value = vr.substr(0, tam - decimais) + ',' + vr.substr(tam - decimais, tam);

              if ((tam >= (decimais + 4)) && (tam <= (decimais + 6)))
                objeto.value = vr.substr(0, tam - (decimais + 3)) + '.' + vr.substr(tam - (decimais + 3), 3) + ',' + vr.substr(tam - decimais, tam);

              if ((tam >= (decimais + 7)) && (tam <= (decimais + 9)))
                objeto.value = vr.substr(0, tam - (decimais + 6)) + '.' + vr.substr(tam - (decimais + 6), 3) + '.' + vr.substr(tam - (decimais + 3), 3) + ',' + vr.substr(tam - decimais, tam);

              if ((tam >= (decimais + 10)) && (tam <= (decimais + 12)))
                objeto.value = vr.substr(0, tam - (decimais + 9)) + '.' + vr.substr(tam - (decimais + 9), 3) + '.' + vr.substr(tam - (decimais + 6), 3) + '.' + vr.substr(tam - (decimais + 3), 3) + ',' + vr.substr(tam - decimais, tam);

              if ((tam >= (decimais + 13)) && (tam <= (decimais + 15)))
                objeto.value = vr.substr(0, tam - (decimais + 12)) + '.' + vr.substr(tam - (decimais + 12), 3) + '.' + vr.substr(tam - (decimais + 9), 3) + '.' + vr.substr(tam - (decimais + 6), 3) + '.' + vr.substr(tam - (decimais + 3), 3) + ',' + vr.substr(tam - decimais, tam);

            } else if (decimais == 0) {
              if (tam <= 3)
                objeto.value = vr;

              if ((tam >= 4) && (tam <= 6)) {
                if (tecla == 8) {
                  objeto.value = vr.substr(0, tam);
                  window.event.cancelBubble = true;
                  window.event.returnValue = false;
                }
                objeto.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, 3);
              }

              if ((tam >= 7) && (tam <= 9)) {
                if (tecla == 8) {
                  objeto.value = vr.substr(0, tam);
                  window.event.cancelBubble = true;
                  window.event.returnValue = false;
                }
                objeto.value = vr.substr(0, tam - 6) + '.' + vr.substr(tam - 6, 3) + '.' + vr.substr(tam - 3, 3);
              }

              if ((tam >= 10) && (tam <= 12)) {
                if (tecla == 8) {
                  objeto.value = vr.substr(0, tam);
                  window.event.cancelBubble = true;
                  window.event.returnValue = false;
                }
                objeto.value = vr.substr(0, tam - 9) + '.' + vr.substr(tam - 9, 3) + '.' + vr.substr(tam - 6, 3) + '.' + vr.substr(tam - 3, 3);
              }

              if ((tam >= 13) && (tam <= 15)) {
                if (tecla == 8) {
                  objeto.value = vr.substr(0, tam);
                  window.event.cancelBubble = true;
                  window.event.returnValue = false;
                }
                objeto.value = vr.substr(0, tam - 12) + '.' + vr.substr(tam - 12, 3) + '.' + vr.substr(tam - 9, 3) + '.' + vr.substr(tam - 6, 3) + '.' + vr.substr(tam - 3, 3);
              }
            }
          }
        } else if ((window.event.keyCode != 8) && (window.event.keyCode != 9) && (window.event.keyCode != 13) && (window.event.keyCode != 35) && (window.event.keyCode != 36) && (window.event.keyCode != 46)) {
          window.event.cancelBubble = true;
          window.event.returnValue = false;
        }
      }
      function salvarReagendada(){
        reag = document.querySelector('#data_reagendada').value;
        idos = document.querySelector('#idOs2').value
        $.ajax({
          url: "<?php echo base_url(); ?>index.php/os/editar_datareagendada",
          type: 'POST',
          dataType: 'json',
          data: {
              datareag:reag,
              idos:idos
          },
          success: function(data) {
            alert(data.msg);
                    
          },          
          error: function(xhr, textStatus, error) {
              console.log("4");
              alert('Erro ao reagendar a O.S.');
              console.log(xhr.responseText);
              console.log(xhr.statusText);
              console.log(textStatus);
              console.log(error);
          },
        })
      }
    </script>