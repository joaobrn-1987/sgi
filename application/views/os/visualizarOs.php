<?php

//var_dump($status_os); exit;

?>

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/fontawesome.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<style type="text/css">
  .switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
  }

  /* Hide default HTML checkbox */
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 12px;
    width: 12px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #51a351;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #51a351;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(20px);
    -ms-transform: translateX(20px);
    transform: translateX(20px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>
<?php



$data = date("d-m-y");

$hora = date("H:i:s"); ?>

<body onLoad="calculaSubTotal();">


  <div class="row-fluid" style="margin-top:0">
    <div class="span12">
      <!--
      <div>
        Histórico alteração:
      </div>-->
      <?php if (!empty($result->data_reagendada)) {
        $dataEntrega = new DateTime($result->data_reagendada);
        $hoje = new DateTime(date('Y-m-d H:i:s'));
        $diff = $dataEntrega->diff($hoje);
        echo '<div>';
        if ($dataEntrega > $hoje) {
          echo 'Dias até a entrega: <b> ' . $diff->days . ' </b>dias';
        } else {
          echo 'Dias até a entrega: <b style="color:red;font-size: 20px;"> -' . $diff->days . ' </b>dias';
        }

        echo '</div>';
      } else if (!empty($result->data_entrega)) {
        $dataEntrega = new DateTime($result->data_entrega);
        $hoje = new DateTime(date('Y-m-d H:i:s'));
        $diff = $dataEntrega->diff($hoje);
        echo '<div>';
        if ($dataEntrega > $hoje) {
          echo 'Dias até a entrega: <b> ' . $diff->days . ' </b>dias';
        } else {
          echo 'Dias até a entrega: <b style="color:red;font-size: 20px;"> -' . $diff->days . ' </b>dias';
        }

        echo '</div>';
      } ?>
	  
	  
	  

<div class="widget-title" style="display: flex; align-items: center; gap: 15px; text-align: left;">
  <span class="icon">
    <i class="icon-tags"></i>
  </span>
  <div class="header-container" style="display: flex; align-items: center; gap: 10px;">
    <h5>Editar OS</h5>
  </div>
  <div class="buttons">
    <a title="Imprimir" class="btn btn-mini btn-inverse" href="<?php echo base_url() ?>index.php/os/imprimir_osproducao/<?php echo $result->idOs; ?>" target="_blank">
      <i class="icon-print icon-white"></i> Imprimir
    </a>
  </div>
</div>



        <div class="widget-content nopadding">


          <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
            <ul class="nav nav-tabs">
              <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">
                  <font color='red'>Detalhes da OS</font>
                </a></li>

              <li id="tabSubOs"><a href="#tab6" data-toggle="tab">
                  <font color='red'>Sub O.S.</font>
                </a></li>
              <?php if (!empty($escopo)) { ?>
                <li id="tabEscopo"><a href="#tab7" data-toggle="tab">
                    <font color='red'>Escopo</font>
                  </a></li>
              <?php  } ?>

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
            <?php
            if ($result->data_insert <> '') {
              $data_insert = date("d/m/Y", strtotime($result->data_insert));
            } else if ($result->data_abertura_real <> '') {
              $data_insert = date("d/m/Y", strtotime($result->data_abertura_real));
            } else {
              $data_insert = "";
            }
            ?>
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <form action="<?php echo base_url() ?>index.php/os/editaros" method="post">
                  <table border='1' width='100%' style="border-color: #aaaaab;border-style: solid;">
                    <tr>
                      <td>

                      <label>Data Criação:</label><p> <b><?php echo $data_insert ?></b></p>


                      </td>
                      <td>
                      <label>Data OS:</label> <input size='9' id="data_abertura" class="data" type="text" name="data_abertura" value="<?php if (!empty($result->data_abertura)) {
                                                                                                                            echo date("d/m/Y", strtotime($result->data_abertura));
                                                                                                                          }  ?>" onclick="this.select();" />

                        <input id="idOs2" type="hidden" name="idOs2" value="<?php echo $result->idOs; ?>" />
                        <input id="idOrcamento_item" type="hidden" name="idOrcamento_item" value="<?php echo $result->idOrcamento_item; ?>" />
                      </td>
                      <td>
                      <label>Data Entrega:</label>
                        <input size='9' id="data_entrega" class="data" type="text" name="data_entrega" value="<?php echo date("d/m/Y", strtotime($result->data_entrega));  ?>" onclick="this.select();" />
                        <?php
                        if (count($alteracoesDataEntrega) > 0) { ?>
                          <a href="#modalUltimasAlteracoesEntrega" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-eye-open"></i></a>
                        <?php
                        } ?>
                      </td>
                      <?php
                      $disabled = "readonly";
                      if ($this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
                        $disabled = "";
                      } else if ($result->unid_execucao == 1 && $this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproServ')) {
                        $disabled = "";
                      } else if ($result->unid_execucao == 2 && $this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproFab')) {
                        $disabled = "";
                      } else if ($result->unid_execucao == 4 && $this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproCil')) {
                        $disabled = "";
                      } else if ($result->unid_execucao == 3 && $this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproPet')) {
                        $disabled = "";
                      }
                      ?>
<td>
    <label>Data Reprog. <span style="color:red">*</span>:</label>
    <input size='9' id="data_reagendada" class="data" onclick="this.select();" 
           style="cursor: pointer; background-color: #ffffff;" type="text" 
           value="<?php 
                $dataFinal = "";
                // Agora 'alteracoesDataReagendada' contém os dados da tabela de motivos
                if (isset($alteracoesDataReagendada) && !empty($alteracoesDataReagendada)) {
                    $item = $alteracoesDataReagendada[0]; // Pega o mais recente (ID 1118)
                    if (!empty($item->data_reagendada) && $item->data_reagendada != '0000-00-00') {
                        $dataFinal = $item->data_reagendada;
                    }
                } 
                
                // Fallback para a OS principal
                if (empty($dataFinal) && !empty($result->data_reagendada) && $result->data_reagendada != '0000-00-00') {
                    $dataFinal = $result->data_reagendada;
                }

                echo (!empty($dataFinal)) ? date("d/m/Y", strtotime($dataFinal)) : ""; 
           ?>" 
           placeholder="00/00/0000" />
    

    <label style="margin-left: 10px;">Motivo <span style="color:red">*</span>:</label>
    <select id="motivo_reagendada" style="width: 140px; margin-bottom: 0px;">
        <option value="">Selecione o motivo...</option>
        <option value="Replanejamento">Replanejamento</option>
        <option value="Compras">Compras</option>
        <option value="Financeiro">Financeiro</option>
        <option value="Fornecedor">Fornecedor</option>
        <option value="Produção">Produção</option>
        <option value="Antecipar">Antecipar</option>
        <option value="Comercial">Comercial</option>
		<option value="Ajuste de Data">Ajuste de Data</option>
    </select>

    <?php
    if (isset($alteracoesDataReagendada) && count($alteracoesDataReagendada) > 0) { ?>
        <a href="#modalUltimasAlteracoesReagendada" data-toggle="modal" role="button" class="btn btn-primary" title="Ver Histórico">
            <i class="icon-eye-open"></i>
        </a>
    <?php }

    if (empty($disabled)) {
        echo ' - <a onclick="salvarReagendada()" style="margin-right: 1%" role="button" class="btn btn-primary" title="Salvar Reprogramação">
                <i class="icon-save icon-white"></i>
              </a>';
    } ?>
</td>
					  
                      <td>
<label>Planejar data:</label>
<input size='9' id="data_planejada" class="data" onclick="this.select();" type="text" name="data_planejada" 
       value="<?php echo (!empty($result->data_planejada) && $result->data_planejada != '0000-00-00') 
                     ? date("d/m/Y", strtotime($result->data_planejada)) : ''; ?>" />

                                                                                                                                                          
                        <?php
						$alteracoesDataPlanejada = [];
                        if (count($alteracoesDataPlanejada) > 0) { ?>
                          <a href="#modalUltimasAlteracoesReagendada" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-eye-open"></i></a>
                        <?php
                        }
                        if (empty($disabled)) {
                          echo '- <a onclick="salvarPlanejada()" style="margin-right: 1%" role="button"
                          data-toggle="modal" class="btn btn-primary"><i class="icon-save icon-white"></i></a>';
                        }

                        ?>
                      </td>						  
                      <td>
                        <label>Data Exped.:</label>
                        <input size='9' id="data_expedicao"  class="data" type="text" name="data_expedicao" value="<?php if ($result->data_expedicao <> '') {  echo date("d/m/Y", strtotime($result->data_expedicao)); } ?>" onclick="this.select();" />
                      </td>
                      <td>
					  <td>
                        <label>Data Viagem:</label>
                        <input size='9' id="data_viagem"  class="data" type="text" name="data_viagem" value="<?php if ($result->data_viagem <> '') {  echo date("d/m/Y", strtotime($result->data_viagem)); } ?>" onclick="this.select();" />
                      </td>
                        <label>Data Canhoto:</label>
                        <input size='9' id="data_canhoto"  class="data" type="text" name="data_canhoto" value="<?php if ($result->data_canhoto <> '') { echo date("d/m/Y", strtotime($result->data_canhoto));  }?>" onclick="this.select();" />
                      </td>
                      <td>
                      <label>Nº Pedido:</label><input size='11' id="numpedido_os" onclick="this.select();" type="text" name="numpedido_os" value="<?php echo $result->numpedido_os; ?>" />
                      </td>
                      <td>
                      <label>Tag:</label><input size='6' id="tag" onclick="this.select();" type=" text" name="tag" value="<?php echo $result->tag; ?>" />
                      </td>
                      <td>
                      <label>Unid. Exec.:</label><select name="unid_execucao" <?php if ($result->idStatusOs == 200) {
                                                                    echo 'disabled';
                                                                  } ?>>
                          <?php if ($result->unid_execucao == 0 || empty($result->unid_execucao)) { ?>
                            <option value="" selected>Não definido</option>
                          <?php
                          } ?>
                          <?php foreach ($unid_exec as $exec) {

                          ?>
                            <option value="<?php echo $exec->id_unid_exec; ?>" <?php if ($exec->id_unid_exec == $result->unid_execucao) {
                                                                                  echo "selected='selected'";
                                                                                } ?>><?php echo $exec->status_execucao; ?></option>
                          <?php } ?>

                        </select>
                      </td>
                      <td>
                      <label>Unid. Fat.:</label><select name="unid_faturamento" <?php if (empty($result->unid_faturamento)) {
                                                                      echo 'disabled';
                                                                    } ?>>
                          <?php if ($result->unid_faturamento == 0 || empty($result->unid_faturamento)) { ?>
                            <option value="" selected>Não definido</option>
                          <?php
                          } ?>
                          <?php foreach ($unid_fat as $fat) { ?>

                            <option value="<?php echo $fat->id_unid_fat; ?>" <?php if ($fat->id_unid_fat == $result->unid_faturamento) {
                                                                                echo "selected='selected'";
                                                                              } ?>><?php echo $fat->status_faturamento; ?></option>
                          <?php } ?>

                        </select>
                      </td>
                    </tr>
                  </table>
                  <table border='1' width='100%' style="border-color: #aaaaab;border-style: solid;">
                    <tr>
                      <td>
                        <label>Cod. OS:</label> <b><?php echo $result->idOs; ?></b>
                      </td>

                      <td>
                        <?php
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOrcamento')) {
                          echo '<a target="_blank" href="' . base_url() . 'index.php/orcamentos/editar/' . $result->idOrcamentos . '" style="color:black"onMouseOver="this.style.color=\'blue\'"
                            onMouseOut="this.style.color=\'black\'"> <label>Orçamento:</label> <b>' . $result->idOrcamentos  . '</b></a>';
                        } else { ?>
                          <label>Orçamento:</label> <b><?php echo $result->idOrcamentos; ?></b><?php
                                                                              }
                                                                                ?>
                      </td>
                      <td>
                      <!--<label>Natureza Op.:</label><font size='1'><b><?php //echo $dados_natoperacao->nome; ?></b></font>-->
					  <label>Natureza Op.:</label><font size='1'><b><?php echo (isset($dados_natoperacao) && is_object($dados_natoperacao)) ? $dados_natoperacao->nome : 'Não definida'; ?></b></font>
                      </td>
					  
<td>
  <label>Data Fim Prod.</label><br>
  <b>
    <?php
    echo !empty($result->data_producao)
      ? date("d/m/Y", strtotime($result->data_producao))
      : "Não produzido";
    ?>
  </b>
  <a href="javascript:void(0)" onclick="abrirHistoricoProducao(<?php echo $result->idOs; ?>)" title="Ver histórico de alterações">
    <i class="icon-eye-open" style="color:blue; font-size:15px; margin-left:5px;"></i>
  </a>
</td>
                      <td>

                      <label>NF Cliente:</label><input onclick="this.select();" id="nf_cliente" type="text" name="nf_cliente" size='11' value="<?php echo $result->nf_cliente; ?>" />
                      </td>
                      <td>
                      <label>Contrato:</label><select name="contrato" class="form-control">
                          <?php if ($result->contrato == 0 || empty($result->contrato)) { ?>
                            <option value="" selected>Não definido</option>
                          <?php
                          } ?>
                          <option value="Não" <?php if ($result->contrato == "Não") {
                                                echo "selected='selected'";
                                              } ?>>Não</option>
                          <option value="Sim" <?php if ($result->contrato == "Sim") {
                                                echo "selected='selected'";
                                              } ?>>Sim</option>
                        </select>
                      </td>
                      <td>
                        Nº NF | Data Fat.<br><input id="numero_nf" onclick="this.select();" size='9' type="text" name="numero_nf" value="<?php echo $result->numero_nf; ?>" /> |
                        <input size='9' id="data_nf_faturamento" onclick="this.select();" class="data" type="text" name="data_nf_faturamento" value="<?php if ($result->data_nf_faturamento <> '') {
                                                                                                                                                        echo date("d/m/Y", strtotime($result->data_nf_faturamento));
                                                                                                                                                      } ?>" />
                      </td>
                      <td colspan="2">
                        NF Dev.| Fabricaçao<br><input id="nf_venda_dev" size='9' onclick="this.select();" type="text" name="nf_venda_dev" value="<?php echo $result->nf_venda_dev; ?>" />|
                        <input size='9' id="data_devolucao" onclick="this.select();" class="data" type="text" name="data_devolucao" value="<?php if ($result->data_devolucao <> '') {
                                                                                                                                              echo date("d/m/Y", strtotime($result->data_devolucao));
                                                                                                                                            } ?>" />
                      </td>
                    </tr>
                  </table>
                  <table border='1' width='100%' style="border-color: #aaaaab;border-style: solid;">
                    <tr>
                      <td colspan='4'>
                       Cliente: <b><?php echo $orcamento->nomeCliente; ?></b>
					   <!--Cliente: <b><?php // echo (isset($result->nomeCliente)) ? $result->nomeCliente : 'Cliente não encontrado'; ?></b>-->
</td>
						
						
                      </td>
<td colspan='3'>Status:
    <?php 
        // Configuração da regra cirúrgica
        $statusExigemData = array(6, 8, 18, 44, 76, 89, 91, 97, 101, 205, 210, 212, 218, 220, 222, 224, 227, 228);
        $temDataProd = (!empty($result->data_producao) && $result->data_producao != '0000-00-00');
        $temPermissao = $this->permission->checkPermission($this->session->userdata('permissao'), 'alterarStatusOsPeritagem');
    ?>
    
    <select style="width: 300px;" name="idStatusOs" id="idStatusOs_visualizar" 
            onchange="verificarRegraStatus(this, <?php echo $result->idOs; ?>, <?php echo $temPermissao ? 'true' : 'false'; ?>)">
        <?php foreach ($status_os as $gs) { ?>
            <option value="<?php echo $gs->idStatusOs; ?>" <?php if ($gs->idStatusOs == $result->idStatusOs) echo "selected='selected'"; ?>>
                <?php echo $gs->nomeStatusOs; ?>
            </option>
        <?php } ?>
    </select>

    <div id="quadro-aviso-pcp" class="alert alert-warning" style="display: none; margin-top: 10px; padding: 10px; border: 1px solid #fbeed5;">
        <i class="icon-info-sign"></i> <b>Alteração Bloqueada:</b> <br>
        O status selecionado exige que a <b>"Data Fim Prod."</b> esteja preenchida. <br><br>
        <a href="<?php echo base_url('index.php/os/ordemservico_pcp'); ?>" class="btn btn-mini btn-inverse">
            <i class="icon-edit icon-white"></i> Ir para Edição PCP
        </a>
        <span style="display:block; margin-top:5px; color: #b94a48; font-size: 11px;">* Ou solicite à Produção a inclusão desta data.</span>
    </div>

    <?php if (count($alteracoesStatus) > 0) { ?>
        <a href="#modalUltimasAlteracoes" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-eye-open"></i></a>
    <?php } ?>
    Histórico de alterações status
</td>
                      <td>Tipo: <select class="form-control" name="id_tipo">
                          <!--<option value="" selected='selected'></option>-->
                          <?php if ($result->unid_execucao == 0 || empty($result->unid_execucao)) { ?>
                            <option value="" selected>Não definido</option>
                          <?php
                          } ?>
                          <?php foreach ($tipo_os as $ostipo) { ?>

                            <option value="<?php echo $ostipo->id_tipo; ?>" <?php if ($ostipo->id_tipo == $result->id_tipo) {
                                                                              echo "selected='selected'";
                                                                            } ?>><?php echo $ostipo->nome_tipo; ?></option>
                          <?php } ?>

                        </select> </td>
                    </tr>
                  </table>
                  <table border='1' width='100%' style="border-color: #aaaaab;border-style: solid;">
                    <tr>
					
					
<td colspan='4'> 
    <?php
    $obs = $result->obs_os;
    $font = $obs == '' ? '#000000' : 'red';
    ?>
    
    <strong>OBS OS:</strong> 
    <?php if ($result->idStatusOs == 200 && $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) { ?>
        <a href="#modalAlterarObsOs" data-toggle="modal" role="button" class="btn btn-primary">
            <i class="icon-pencil icon-white"></i>
        </a>
    <?php } ?>
    
    <textarea <?php echo $result->idStatusOs == 200 ? "readonly" : ""; ?> 
              id="obs_os" rows="2" cols="100" class="span12" 
              name="obs_os"><?php echo $obs; ?>
    </textarea>

    <!-- Histórico de Observações -->
<!-- Botão para abrir o modal -->
<?php if (!empty($obs_history)) { ?>
    <a href="#modalObsHistory" data-toggle="modal" role="button" class="btn btn-primary">
        <i class="icon-eye-open"></i> Ver Histórico de Observações
    </a>
<?php } ?>



<!-- Modal de Histórico de Observações -->
<div id="modalObsHistory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalObsHistoryLabel" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalObsHistoryLabel">Histórico de Observações</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (!empty($obs_history)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($obs_history as $hist) { ?>
                                <tr>
                                    <td><?php echo date('d/m/Y H:i', strtotime($hist->data_alteracaoHis)); ?></td>
                                    <td><?php echo htmlspecialchars($hist->nome); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($hist->obs_os)); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>Nenhuma observação encontrada.</p>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

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
                          if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eErificacaocontroleOS')) {
                            echo '<select name="idVerificacaoControle" id="idVerificacaoControle">';
                          } else {
                            echo '<select disabled name="idVerificacaoControle" id="idVerificacaoControle">';
                          }
                        ?>


                          <?php
                          foreach ($verificacao_controle as $r) {
                            if ($r->idVerificacaoControle == $result->idVerificacaoControle) {
                              echo '<option selected value="' . $r->idVerificacaoControle . '">' . $r->descricaoControle . '</option>';
                            } else {
                              echo '<option value="' . $r->idVerificacaoControle . '">' . $r->descricaoControle . '</option>';
                            }
                          } ?>

                          </select>
                        <?php
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eErificacaocontroleOS')) {
                          echo '<button type="submit" class="btn btn-success" value="1" id="buttonAlterarVerifContr" name="buttonAlterarVerifContr"><i class="icon-plus icon-white"></i> Alterar</button>';
                          if (count($alteracoesCont) > 0) {
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
                              <b>Unid:</b><br><input size='2' readonly type="text" value="<?php echo $itens_orcamento->descricaoTipoQtd; ?>" />

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

                                <b>Vlr. Unit.:</b><br><input id="val_unit_os" size='7' onKeyUp="calculaSubTotal();" onclick="this.select();" type="text" name="val_unit_os" onKeyPress="FormataValor2(this,event,13,2);" value="<?php echo number_format($result->val_unit_os, 2, ",", ".");  ?>" />
                              </td>
                              <td Valign="top">

                                <b>Desconto:</b><br><input size='3' id="desconto_os" onKeyPress="FormataValor2(this,event,13,2);" onKeyUp="calculaSubTotal();" onclick="this.select();" type="text" name="desconto_os" value="<?php echo number_format($result->desconto_os, 2, ",", "."); ?>" />
                              </td>
                              <td Valign="top">

                                <b>IPI (%):</b><br><input size='1' id="val_ipi_os" onKeyPress="FormataValor2(this,event,13,2);" onKeyUp="calculaSubTotal();" onclick="this.select();" type="text" name="val_ipi_os" value="<?php echo number_format($result->val_ipi_os, 2, ",", "."); ?>" />
                              </td>
                              <td Valign="top">
                                <b>IPI (R$):</b><br><input size='1' onclick="this.select();" type="text" value="<?php echo number_format(($result->val_ipi_os / 100) * $result->qtd_os * $result->val_unit_os, 2, ",", "."); ?>" />
                              </td>
                              <td Valign="top">
                                <?php
                                $calc = $result->qtd_os * $result->val_unit_os - $result->desconto_os;
                                $ipicalc = $result->val_ipi_os / 100 * $calc;
                                $resultde = $calc + $ipicalc;
                                ?>
                                <b>Sub. Total:</b><br><input id="subtot_os" size='7' type="text" readonly="true" name="subtot_os" value="<?php echo number_format($calc, 2, ",", "."); ?>" />
                              </td>
                              <td Valign="top">

                                <b>Total:</b><br><input id="total" size='7' type="text" name="total" value="" readonly="true" />
                              </td>

                            <?php
                            } else {
                              $calc = $result->qtd_os * $result->val_unit_os - $result->desconto_os;
                              $ipicalc = $result->val_ipi_os / 100 * $calc;
                              $resultde = $calc + $ipicalc;
                            ?>
                              <input id="subtot_os" size='6' type="hidden" readonly="true" name="subtot_os" value="<?php echo number_format($calc, 2, ",", "."); ?>" />
                              <input size='1' id="val_ipi_os" onclick="this.select();" type="hidden" name="val_ipi_os" value="<?php echo number_format($result->val_ipi_os, 2, ",", "."); ?>" />
                              <input size='3' id="desconto_os" onclick="this.select();" type="hidden" name="desconto_os" value="<?php echo number_format($result->desconto_os, 2, ",", "."); ?>" />
                              <input id="val_unit_os" size='6' onclick="this.select();" type="hidden" name="val_unit_os" value="<?php echo number_format($result->val_unit_os, 2, ",", ".");  ?>" />
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
                                <select name='statusDesenho' id='statusDesenho' style="<?php echo ($this->permission->checkPermission($this->session->userdata('permissao'), 'adesenhoOs') && ($this->permission->checkPermission($this->session->userdata('permissao'), 'aAnexo') && empty($itens_orcamento->tipoOrc) && empty($itens_orcamento->tipoProd))?"":"pointer-events:none")?>">
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
                              if (count($alteracoesDesenho) > 0) { ?>
                                <a href="#modalUltimasAlteracoesDesenho" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-eye-open"></i></a>
                              <?php
                              } ?>
                              Histórico de alterações Desenho
                              </br>
                              <?php //if ($this->permission->checkPermission($this->session->userdata('permissao'), 'adesenhoOs') && ($this->permission->checkPermission($this->session->userdata('permissao'), 'aAnexo') && empty($itens_orcamento->tipoOrc) && empty($itens_orcamento->tipoProd))) {
                                if  ($this->permission->checkPermission($this->session->userdata('permissao'), 'aAnexo')) {
                              ?>
                                <button type="submit" class="btn btn-success" style="margin-left:25%; margin-top:10px" value="1" name="btnAlterarDesenho" value="btnAlterarDesenho"><i class="icon-plus icon-white"></i> Alterar Status e OBS </br> Desenho</button>
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
                            <td Valign="top" >
                              <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aObsPlanejamento')) {
                              ?>
                                <b>OBS PCP:</b><a href="#modalAlterarplanejamento<?php echo $result->idOs; ?>" data-toggle="modal" role="button" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a>
                                <textarea disabled id="obs_desenho" rows="2" cols="100" class="span12" name="obs_desenho"><?php echo ($result->obs_pcp); ?></textarea>
                              <?php
                              } else { ?>
                                <b>OBS PCP:</b>                          

                                <textarea disabled id="obs_desenho" rows="2" cols="100" class="span12" name="obs_desenho"><?php echo ($result->obs_pcp); ?></textarea>
                              <?php
                              } ?>
                            </td>

                          </tr>
                        </table>
                      </td>
                      
                    </tr>

                    <?php /*if ($result->fechadoPCP == 0) {
                      echo '<tr>';
                      echo '<td colspan="8">';
                      echo '<table width="100%">';
                      echo '<tr>';
                      echo '<td Valign="top" style="border-right:0px">';

                      echo '<b>PCP Liberar:</b>';
                      echo '<a href="#modalLiberarPCP" style="margin-left: 10px;" data-toggle="modal" role="button" class="btn btn-success"><i class="icon-unlock icon-white"></i> Liberar</a>';
                      echo '</td>';
                      echo '</tr>';
                      echo '</table>';
                      echo '</td>';
                      echo '</tr>';
                    }/*else{
                        echo '<tr>';
                          echo '<td colspan="8">';
                            echo '<table width="100%">';
                              echo '<tr>';
                                echo '<td Valign="top" style="border-right:0px">';
                                  echo '<b>PCP Bloquear:</b>';
                                  echo '<a href="#modalBloquearPCP" style="margin-left: 10px;" data-toggle="modal" role="button" class="btn btn-success"><i class="icon-lock icon-lock"></i> Bloquear</a>';
                                echo '</td>';
                              echo '</tr>';
                            echo '</table>';
                          echo '</td>';
                        echo '</tr>';
                    } */ ?>





                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
                    ?>


                      <tr>
                        <td colspan='8' align='center'>
                          <?php if ($result->idStatusOs != 200) {

                          ?>
                            <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Alterar</button><?php
                                                                                                                              } ?>
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
                    <label for="item" class="control-label"> Num. Nota Fiscal: <?php echo $result->numero_nf; ?>
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
        <b style="font-size: 16px;">Suprimentos</b>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>O.C.</th>
                    <th>ID</th>
                    <th>Qtd.</th>
                    <th>Cod. Forn.</th>
                    <th>Usuario</th>
                    <th>Material</th>
                    <th>Dimensões</th>
                    <th>OBS</th>
                    <th>Data Cadastro</th>
                    <th>Data Alteração</th>
                    <th>Previsão Entrega</th>
                    <th>Status</th>
                    <th>IPI</th>
                    <th>Outros</th>
                    <th>Desconto</th>
                    <th>Valor Total</th>
                    <th>Qtd. Transf.</th>
                    <th>O.S. Destino</th>
                    <th>Ação</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $somaValorTotal = 0;
                $somaFrete = 0; 
                $somaIcms = 0; 
                $pedidos_frete_somados = array(); // Array para controlar fretes já somados

                foreach ($distribuir_os as $dist):
                    $form_id = 'form-transfer-' . $dist->idDistribuir;

                    if (isset($dist->data_alteracao) && $dist->data_alteracao <> '') {
                        $data_alteracao = date("d/m/Y H:i:s", strtotime($dist->data_alteracao));
                    } else {
                        $data_alteracao = "";
                    }
                    
                    // --- CÁLCULO UNIFICADO ---
                    $valor_unitario = isset($dist->valor_unitario) ? floatval($dist->valor_unitario) : 0;
                    $quantidade     = isset($dist->quantidade) ? floatval($dist->quantidade) : 0;
                    
                    // Valores Extras (R$)
                    $ipi_valor = isset($dist->ipi_valor) ? floatval($dist->ipi_valor) : 0;
                    $icms      = isset($dist->icms) ? floatval($dist->icms) : 0;
                    $outros    = isset($dist->outros) ? floatval($dist->outros) : 0;
                    $desconto  = isset($dist->desconto) ? floatval($dist->desconto) : 0;
                    
                    // LÓGICA DO FRETE: Soma apenas UMA vez por ID de Pedido
                    if (isset($dist->idPedidoCompra) && !empty($dist->idPedidoCompra)) {
                        if (!in_array($dist->idPedidoCompra, $pedidos_frete_somados)) {
                            $frete_deste_pedido = isset($dist->frete) ? floatval($dist->frete) : 0;
                            $somaFrete += $frete_deste_pedido;
                            $pedidos_frete_somados[] = $dist->idPedidoCompra; // Marca como processado
                        }
                    }

                    // Cálculo da Linha: (Qtd * Unit) + Impostos - Desconto
                    // (O Frete não entra aqui na linha para não confundir o valor unitário visualmente)
                    $subtotal = $valor_unitario * $quantidade;
                    $valor_produto_linha = $subtotal + $ipi_valor + $icms + $outros - $desconto;
                    
                    $somaValorTotal += $valor_produto_linha;
                    $somaIcms += $icms;
                ?>
                    <tr>
                        <td>
                            <?php 
                            // CORREÇÃO: Form movido para dentro da TD para não quebrar o layout da tabela
                            echo form_open('os/transferir_insumo', array('id' => $form_id, 'style' => 'display: none;')); 
                            echo form_hidden('idOs_origem', $result->idOs); 
                            echo form_hidden('idDistribuir', $dist->idDistribuir);
                            echo form_close();
                            ?>
                            
                            <?php echo '<a title="Clique aqui para visualizar as informações da O.C." style="cursor:pointer" onclick="openModalInfoOC(' . (isset($dist->idPedidoCompra) ? $dist->idPedidoCompra : 'null') . ')" ><b>' . (isset($dist->idPedidoCompra) ? $dist->idPedidoCompra : 'N/A') . '</b></a>'; ?>
                            
                            <?php if(!empty($dist->idPedidoCompra)){ ?>
                                <a href="<?php echo base_url(); ?>index.php/suprimentos/imprimir_pedido/<?php echo $dist->idPedidoCompra; ?>" target="_blank" title="Imprimir Pedido" style="margin-left: 5px;"><i class="icon-print"></i></a>
                            <?php } ?>
                        </td>
                        <td><?php echo $dist->idDistribuir; ?></td>
                        <td><?php echo $dist->quantidade; ?></td>
                        <td><?php echo isset($dist->cod_fornecedor) ? $dist->cod_fornecedor : ''; ?></td>
                        <td><?php echo isset($dist->nome) ? $dist->nome : ''; ?></td>
                        <td>
                            <?php 
                                $html = isset($dist->descricaoInsumo) ? $dist->descricaoInsumo : '';
                                if(!empty($dist->dimensoes)){ $html.=" ".$dist->dimensoes; } 
                                if(!empty($dist->comprimento)){ $html.=" x ".$dist->comprimento." mm"; } 
                                if(!empty($dist->volume)){ $html.=" ".$dist->volume." ml"; } 
                                if(!empty($dist->peso)){ $html.=" ".$dist->peso." g"; } 
                                if(!empty($dist->dimensoesL)){ $html .= " x L: ".$dist->dimensoesL." mm "; }
                                if(!empty($dist->dimensoesC)){ $html .= " x C: ".$dist->dimensoesC." mm "; }
                                if(!empty($dist->dimensoesA)){ $html .= " x A: ".$dist->dimensoesA." mm"; }
                                echo $html;
                            ?>
                        </td>
                        <td><?php echo isset($dist->dimensoes) ? $dist->dimensoes : ''; ?></td>
                        <td><?php echo isset($dist->obs) ? $dist->obs : ''; ?></td>
                        <td><?php echo date("d/m/Y H:i:s", strtotime($dist->datacadastro)); ?></td>
                        <td><?php echo $data_alteracao; ?></td>
                        <td><?php if (!empty($dist->previsao_entrega)) { echo date("d/m/Y", strtotime($dist->previsao_entrega)); } ?></td>
                        <td><?php echo isset($dist->nomeStatus) ? $dist->nomeStatus : ''; ?></td>
                        
                        <td><?php echo 'R$ ' . number_format($ipi_valor, 2, ',', '.'); ?></td>
                        <td><?php echo 'R$ ' . number_format($outros, 2, ',', '.'); ?></td>
                        <td><?php echo 'R$ ' . number_format($desconto, 2, ',', '.'); ?></td>
                        <td><?php echo 'R$ ' . number_format((float)$valor_produto_linha, 2, ',', '.'); ?></td>
                        
                        <td>
                            <input form="<?php echo $form_id; ?>" type="text" name="qtd_transf" value="" pattern="[0-9]+([.,][0-9]+)?" title="Apenas números e decimais." size="4" style="margin-bottom: 0;" required>
                        </td>   
                        <td>
                            <input form="<?php echo $form_id; ?>" type="text" name="idOs_destino" value="" pattern="[0-9]+" title="Apenas números." size="8" style="margin-bottom: 0;" required>
                        </td>   
                        <td> 
                            <button form="<?php echo $form_id; ?>" type="submit" class="btn btn-mini btn-primary" onclick="return confirm('Tem certeza que deseja transferir este insumo?')">Transferir</button>       
                        </td>                   
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
<table class="table table-bordered">
    <tr>
        <th style="font-size: 15px; font-weight: bold;">
            Frete (soma única): <?php echo 'R$ ' . number_format((float)$somaFrete, 2, ',', '.'); ?>
        </th>
        <th style="font-size: 15px; font-weight: bold;">
            ICMS Total: <?php echo 'R$ ' . number_format((float)$somaIcms, 2, ',', '.'); ?>
        </th>
        <th style="font-size: 15px; font-weight: bold;">
            Total Produtos (s/ Frete): <?php echo 'R$ ' . number_format((float)$somaValorTotal, 2, ',', '.'); ?>
        </th>
        <th style="font-size: 15px; font-weight: bold;">
            TOTAL GERAL (c/ Frete): <?php echo 'R$ ' . number_format((float)($somaValorTotal + $somaFrete), 2, ',', '.'); ?>
        </th>
    </tr>
</table>

    </div>
    
    <div class="span12 well" style="padding: 1%; margin-left: 0">
        <b style="font-size: 16px;">Almoxarifado</b>
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>Data Saída</th><th>Descrição</th><th>Qtd.</th><th>Empresa</th><th>Depart.</th><th>Empresa Destino</th><th>Usuário Ret.</th><th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $totalAlmo = 0;
            foreach($saidas_almoxarifado as $r){
                $date = new DateTime( $r->data_saida);
                echo '<tr>';
                echo '<td>'.$date->format( 'd/m/Y' ).'</td>';
                echo '<td>'.$r->descricaoInsumo.'</td>';
                echo '<td>'.$r->quantidade.'</td>';
                echo '<td>'.$r->nome.'</td>';                                
                echo '<td>'.$r->descricaoDepartamento.'</td>';
                echo '<td>'.$r->destinoNome.'</td>';
                echo '<td>'.$r->getUsernome.'</td>';
                echo '<td>R$ '.number_format((float)($r->valorUnit?$r->valorUnit:0)*$r->quantidade, 2, ',', '.').'</td>';
                echo '</tr>';
                $totalAlmo += ($r->valorUnit?$r->valorUnit:0)*$r->quantidade;
            }
            ?>
            </tbody>
        </table>
        <table class="table table-bordered ">
            <tr>
                <th>Total Almoxarifado: <?php echo 'R$ ' . number_format((float)$totalAlmo, 2, ',', '.'); ?></th>
            </tr>
        </table>
    </div>
</div>
			  
			  
			  
<!-- FIM ANÁLISE INSUMOS--------------------------------------------------------------------------->			


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
                      echo 'R$ ' . number_format((float)$somaValorTotal+$totalAlmo, 2, ',', '.');
                      echo '</td>';
                      echo '<td>';
                      echo 'R$ ' . number_format((float)$somaValorTotalHrMq, 2, ',', '.');
                      echo '</td>';
                      echo '<td>';
                      echo 'R$ ' . number_format((float)$somaValorTotalHrMq + $somaValorTotal + $valorIcms + $valor_frete + $totalAlmo, 2, ',', '.');
                      echo '</td>';
                      echo '</tr>';
                      ?>



                    </tbody>
                  </table>
                  <!--
                  <div style="text-align: right">
                    Total: <?php echo 'R$ ' . number_format((float)$somaValorTotal, 2, ',', '.'); ?>
                  </div>-->

                </div>
              </div>

              <div class="tab-pane" id="tab6">

                <div class="row-fluid" style="margin-top:0">
                  <div class="span12">
                    <div class="widget-box">
                      <div class="widget-title">
                        <span class="icon">
                          <i class="icon-tags"></i>
                        </span>
                        <h5>Sub O.S.</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                          <div class="span12" id="divCadastrarOs">
                            <div class="widget-box" style="margin-top:0px">
                              <table id="table_id" class="table table-bordered " id="dadosTlbOsOc">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th>Sub O.S.</th>
                                    <th>Tipo</th>
                                    <th>PN</th>
                                    <th>Descrição</th>
									<th>Unid. Exec.</th>
                                    <th>Qtd.</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  foreach ($subOs as $a) {
                                    if ($a->posicao != 0) {
                                      echo '<tr>';
                                      if ($a->posicao != 0 && !empty($a->posicao)) {
                                        if ($a->ativo == 0 || empty($a->ativo)) {
                                          echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" name="checkSubOs" value="' . $a->idOsSub . '" ><span class="slider round"></span></label></td>';
                                        } else {
                                          echo '<td style="text-align: center;"><label class="switch"><input type="checkbox" checked name="checkSubOs" value="' . $a->idOsSub . '" ><span class="slider round"></span></label></td>';
                                        }
                                      } else {
                                        echo '<td></td>';
                                      }
                                      echo '<td style="text-align: center;">' . $result->idOs . '.' . $a->posicao . '</td>';
                                      echo '<td>' . $a->nomeClasse . '</td>';
                                      echo '<td>' . $a->pn . '</td>';
                                      echo '<td>' . $a->descricaoOsSub . '</td>';
									  $result->unid_execucao;
									  if ($result->unid_execucao == 1) {
									  echo '<td>' . 'Serviço' . '</td>';
									  }
									  if ($result->unid_execucao == 2) {
									  echo '<td>' . 'Fabricação' . '</td>';
									  }
									  if ($result->unid_execucao == 3) {
									  echo '<td>' . 'Petrolina' . '</td>';
									  }
									  if ($result->unid_execucao == 4) {
									  echo '<td>' . 'Cilindro' . '</td>';
									  }
									  if ($result->unid_execucao == 5) {
									  echo '<td>' . 'Pará' . '</td>';
									  }
									  if ($result->unid_execucao == 6) {
									  echo '<td>' . 'CESU' . '</td>';
									  }	
									  echo '<td>' . $a->quantidade . '</td>';
                                      echo '</tr>';
                                    }
                                  }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane" id="tab7">
                <div class="row-fluid" style="margin-top:0">
                  <div class="span12">
                    <div class="widget-box">
                      <!--
                      <div class="widget-title">
                        <span class="icon">
                          <i class="icon-tags"></i>
                        </span>
                        <h5>Histórico Vale</h5>
                      </div> -->
                      <div class="widget-content nopadding">
                        <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                          <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                              <div class="span12" id="divCadastrarOs">
                                <div class="widget-box" style="margin-top:0px">
                                  <table id="tableHistVale" class="table table-bordered ">
                                    <thead>
                                      <tr>
                                        <th>PN</th>
                                        <th>DESCRIÇÃO</th>
                                        <th>CLASSE</th>
                                        <th>QTD</th>
                                        <th>Ø EXT.</th>
                                        <th>Ø INT.</th>
                                        <th>COMP.</th>
                                        <th>OBS.</th>
                                        <!--
                                        <th>DES.</th>
                                        <th>LAU. FOT.</th>-->
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      //echo json_encode($escopo);
                                      foreach ($escopo as $s) {
                                        echo '<tr>';
                                        echo '<td>';
                                          echo $s->pn;
                                        echo '</td>';
                                        echo '<td>';
                                          echo $s->descricaoServicoItens;
                                        echo '</td>';
                                        echo '<td>';
                                          echo $s->descricaoClasse;
                                        echo '</td>';
                                        echo '<td>';
                                          echo $s->quantidade;
                                        echo '</td>';
                                        echo '<td>';
                                          echo $s->dimenExt;
                                        echo '</td>';
                                        echo '<td>';
                                          echo $s->dimenInt;
                                        echo '</td>';
                                        echo '<td>';
                                          echo $s->dimenComp;
                                        echo '</td>';
                                        echo '<td>';
                                          echo $s->obs;
                                        echo '</td>';/*
                                            echo '<td>';
                                              echo $s->pn;
                                            echo '</td>';
                                            echo '<td>';
                                            echo '</td>';*/
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
                      </div>
                    </div>
                  </div>
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


            </h5> 
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aAnexo')){
            //if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aAnexoNovo') || (($this->permission->checkPermission($this->session->userdata('permissao'), 'aAnexo') && empty($itens_orcamento->tipoOrc) && empty($itens_orcamento->tipoProd)))) {
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
                  <th>Nome arquivo | Download</th>
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
                          if ($this->session->userdata('idUsuarios') == $desenho->user_proprietario || $this->session->userdata('idUsuarios') == '1' || (($this->session->userdata('idUsuarios') == '12' || $this->session->userdata('idUsuarios') == '13' || $this->session->userdata('idUsuarios') == '59') && ($desenho->user_proprietario == '13' || $desenho->user_proprietario == '12' || $desenho->user_proprietario == '59')) || $this->permission->checkPermission($this->session->userdata('permissao'), 'desenhoTotal')) {
                          ?>
                            <a href="#modalAlteraranexo<?php echo $desenho->idAnexo;?>" data-toggle="modal" role="button" class="btn btn-info tip-top" title="Editar"><i class="icon-pencil icon-white"></i></a>



                            <a href="#modal-excluir<?php echo $desenho->idAnexo;?>" style="margin-right: 1%" role="button" data-toggle="modal" arquivo="<?php echo $desenho->idAnexo; ?>" class="btn btn-danger tip-top" title="Excluir desenho"><i class="icon-remove icon-white"></i></a>
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
                                    <option value="CATÁLOGO" 
                                    <?php if ($desenho->tipo == "CATÁLOGO") {
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
    <div id="modalAlterarplanejamento<?php echo $result->idOs; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterar Observação PCP OS: <?php echo $result->idOs; ?></h5>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url(); ?>index.php/os/editaobs_os" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="obs_pcp" class="control-label">Observação PCP OS<span class="required">*</span></label>
            <div class="controls">
              <textarea id="obs_pcp" rows="5" cols="50" class="span10" name="obs_pcp"><?php echo ($result->obs_pcp); ?></textarea>


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
    <div id="modalAlterarObsOs" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterar Observação  OS: <?php echo $result->idOs; ?></h5>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url(); ?>index.php/os/editaobs" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
          <div class="control-group">
            <label for="obs_os" class="control-label">Observação  OS<span class="required">*</span></label>
            <div class="controls">
              <textarea id="obs_os" rows="5" cols="50" class="span10" name="obs_os"><?php echo ($result->obs_os); ?></textarea>


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
              <?php foreach ($alteracoesStatus as $r) {
                echo '<tr>';
                echo '<td>';
                $date = new DateTime($r->data_alteracaoHis);
                echo $date->format('d/m/Y H:i');
                echo '</td>';
                echo '<td>';
                echo $r->nomeStatusOs;
                echo '</td>';
                echo '<td>';
                echo $r->nome;
                echo '</td>';
                echo '</tr>';
              } ?>

            </tbody>
          </table>
        </div>

      </div>
    </div>
    <div id="modalUltimasAlteracoesEntrega" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Alterações da data de entrega: <?php echo $result->idOs; ?></h5>
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
                  Data Entrega
                </th>
                <th>
                  Status do momento
                </th>
                <th>
                  Usuário
                </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($alteracoesDataEntrega as $r) {
                echo '<tr>';
                echo '<td>';
                $date = new DateTime($r->data_alteracaoHis);
                echo $date->format('d/m/Y H:i');
                echo '</td>';
                echo '<td>';
                $date2 = new DateTime($r->data_entrega);
                echo $date2->format('d/m/Y');
                echo '</td>';
                echo '<td>';
                echo $r->nomeStatusOs;
                echo '</td>';
                echo '<td>';
                echo $r->nome;
                echo '</td>';
                echo '</tr>';
              } ?>

            </tbody>
          </table>
        </div>

      </div>
    </div>
    
	<!-------------------------------------------------ALTERAÇÃO DATA REPROGRAMADA INICIO------------------------------------------------------->

<div id="modalUltimasAlteracoesReagendada" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 id="myModalLabel">Histórico de Reprogramação: <?php echo $result->idOs; ?></h5>
    </div>
    <div class="modal-body">
        <div class="widget-content nopadding">
            <table class="table table-bordered" id="dadosTlbOsOc">
                <thead>
                    <tr>
                        <th style="width: 20%;">Data Alteração</th>
                        <th style="width: 15%;">Data Reprog.</th>
                        <th style="width: 25%;">Motivo</th>
                        <th style="width: 20%;">Status Momento</th>
                        <th style="width: 20%;">Usuário</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Garante que as variáveis existam como arrays para evitar erros no merge
                    $historico_v1 = isset($historico_motivos) && is_array($historico_motivos) ? $historico_motivos : [];
                    $historico_v2 = isset($alteracoesDataReagendada) && is_array($alteracoesDataReagendada) ? $alteracoesDataReagendada : [];
                    
                    // Une os dados e remove possíveis duplicados ou ordena (se necessário)
                    $dados_exibicao = array_merge($historico_v1, $historico_v2);

                    if (!empty($dados_exibicao)) {
                        foreach ($dados_exibicao as $r) {
                            echo '<tr>';
                            
                            // 1. Data da Operação (Quando o registro foi criado)
                            echo '<td>';
                            $dataAltStr = isset($r->data_registro) ? $r->data_registro : (isset($r->data_alteracaoHis) ? $r->data_alteracaoHis : null);
                            echo ($dataAltStr) ? date('d/m/Y H:i', strtotime($dataAltStr)) : '---';
                            echo '</td>';
                            
                            // 2. Data para a qual a OS foi reprogramada
                            echo '<td>';
                            if (!empty($r->data_reagendada) && $r->data_reagendada != '0000-00-00') {
                                echo date('d/m/Y', strtotime($r->data_reagendada));
                            } else {
                                echo '<span class="label">Não definida</span>';
                            }
                            echo '</td>';

                            // 3. Motivo da alteração (Destaque para a nova funcionalidade)
                            echo '<td>';
                            if (!empty($r->motivo)) {
                                echo '<span class="label label-info" style="font-size: 10px; text-transform: uppercase;">' . $r->motivo . '</span>';
                            } else {
                                echo '<span class="label" style="font-size: 10px;">Sem justificativa</span>';
                            }
                            echo '</td>';

                         
// 4. Status da OS no momento da alteração
echo '<td>';
// Prioriza nomeStatusOs (que vem do JOIN) sobre o status_momento (que é o ID)
$statusNome = !empty($r->nomeStatusOs) ? $r->nomeStatusOs : (!empty($r->status_momento) ? $r->status_momento : 'N/A');
echo $statusNome;
echo '</td>';
                            
                            // 5. Usuário que realizou a ação
                            echo '<td>';
                            $usuarioNome = isset($r->usuario_nome) ? $r->usuario_nome : (isset($r->nome) ? $r->nome : 'Sistema');
                            echo $usuarioNome;
                            echo '</td>';
                            
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" style="text-align:center">Nenhuma alteração registrada até o momento.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
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
              <?php foreach ($alteracoesCont as $r) {
                echo '<tr>';
                echo '<td>';
                $date = new DateTime($r->data_alteracaoHis);
                echo $date->format('d/m/Y H:i');
                echo '</td>';
                echo '<td>';
                echo $r->descricaoControle;
                echo '</td>';
                echo '<td>';
                echo $r->nome;
                echo '</td>';
                echo '</tr>';
              } ?>

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
              <?php foreach ($alteracoesDesenho as $r) {
                echo '<tr>';
                echo '<td>';
                $date = new DateTime($r->data_alteracaoHis);
                echo $date->format('d/m/Y H:i');
                echo '</td>';
                echo '<td>';
                if ($r->statusDesenho == 1) {
                  echo 'Sem desenho';
                }
                if ($r->statusDesenho == 2) {
                  echo 'Incompleto';
                }
                if ($r->statusDesenho == 3) {
                  echo 'Completo';
                }

                echo '</td>';
                echo '<td>';
                echo $r->nome;
                echo '</td>';
                echo '</tr>';
              } ?>

            </tbody>
          </table>
        </div>

      </div>
    </div>
    <div id="modalLiberarPCP" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <form action="<?php echo base_url(); ?>index.php/almoxarifado/destravar2" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h5 id="myModalLabel">Liberar cadastro de materiais. O.S.: <?php echo $result->idOs; ?></h5>
          <input type="hidden" value="<?php echo $result->idOs; ?>" class="span12" id="idOs2" name="idOs2">
        </div>
        <div class="modal-body">
          <h5 id="myModalLabel">Deseja confirmar a liberação para cadastro de materiais?</h5>
          <div class="span12" style="margin-left:0px">
            <div class="span4">
              <label>Motivo:</label>
              <select class="span12" id="motivoLib" name="motivoLib">
                <option value="">Selecione um motivo</option>
                <?php foreach ($motivos as $r) {
                  echo '<option value="' . $r->idMotivoLib . '">' . $r->descricaoMotivoLib . '</option>';
                } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
          <button class="btn btn-success">Confirmar</button>
        </div>
      </form>
    </div>
    <div id="modal-oc" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h5 id="myModalLabel">Informações da O.C.: <b id="bInfoOC"></b> </h5>
      </div>
      <div>
          <div class="widget-content nopadding" style="overflow-y: scroll;height: 500px;">
              <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                  <div class="tab-content">
                      <div class="tab-pane active" id="tab1">
                          <div class="span12" id="divCadastrarOs">                                
                              <div class="widget-box" style="margin-top:0px">                                        
                                  <table id="tableOC" class="table table-bordered ">
                                      <thead>
                                          <tr>
                                              <th>OS</th>
                                              <th>Unid. Exec.</th>
                                              <th>Alter. Status</th>
                                              <th>Qtd.</th>
                                              <th>Descrição</th>
                                              <th>Solicitação Material</th>
                                              <th>Status</th>
                                              <th>Usuário Ag. Orç.</th>
                                              <th>Data Pedido</th>
                                              <th>Usuário Ped.</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          
                                      </tbody>
                                  </table>
                              </div>                                
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>


<!-- Modal Histórico de Alterações - Data Fim Produção -->
<div class="modal hide fade" id="modal-historico-producao" tabindex="-1" role="dialog" aria-labelledby="modalHistoricoProducaoLabel" aria-hidden="true">
<!--<div class="modal fade" id="modal-historico-producao" tabindex="-1" role="dialog" aria-labelledby="modalHistoricoProducaoLabel" aria-hidden="true">-->
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Histórico de Alterações - Data Fim Produção</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered table-striped" style="font-size: 13px;">
                    <thead>
                        <tr>
                            <th width="180">Data da Alteração</th>
                            <th width="180">Data Fim Produção</th>
                            <th width="150">Usuário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($historicoDataProducao)) : ?>

                            <?php foreach ($historicoDataProducao as $h) : ?>
                                <tr>
                                    <td>
                                        <?= date('d/m/Y H:i:s', strtotime($h->data_alteracao)) ?>
                                    </td>

                                    <td>
                                        <?= (!empty($h->data_producao))
                                            ? date('d/m/Y', strtotime($h->data_producao))
                                            : '—'; ?>
                                    </td>

                                    <td>
                                        <?= $h->nomeUsuario ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center">
                                    Nenhum histórico encontrado.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
/**
 * 1. REPROGRAMAÇÃO (DATA E MOTIVO)
 * Salva a alteração via AJAX com validação obrigatória de ambos os campos.
 */
function salvarReagendada() {
    var idos = "<?php echo $result->idOs; ?>";
    var datareag = $('#data_reagendada').val();
    var motivo_val = $('#motivo_reagendada').val();

    // Validação de segurança antes do envio
    if (datareag == "" || datareag == "00/00/0000") {
        datareag = ""; // Garante que não envie string de máscara vazia
    }

    if (datareag != "") {
        if (motivo_val == "" || motivo_val == null) {
            alert("ATENÇÃO: Para definir uma nova data, selecione o MOTIVO da reprogramação.");
            $('#motivo_reagendada').focus();
            return false;
        }
    } 

    $.ajax({
        url: "<?php echo base_url(); ?>index.php/os/editar_datareagendada",
        type: 'POST',
        dataType: 'json',
        data: {
            idos: idos,
            datareag: datareag,
            motivo: motivo_val
        },
        success: function(data) {
            if (data.result == true) {
                alert(data.msg);
                // Força o recarregamento total para limpar o cache da data antiga
                window.location.href = window.location.href; 
            } else {
                alert("Erro: " + data.msg);
            }
        },
        error: function(xhr) {
            // Se cair no erro mas gravou, recarregamos para garantir a visualização
            window.location.reload(true);
        }
    });
}
/**
 * 2. HISTÓRICO DE PRODUÇÃO
 */
function abrirHistoricoProducao(idOs) {
    $.ajax({
        url: "<?php echo base_url(); ?>index.php/os/getHistoricoDataProducaoAjax",
        type: "POST",
        dataType: "json",
        data: { idOs: idOs },
        success: function (response) {
            let html = "";
            if (response.status === "success" && response.result && response.result.length > 0) {
                $.each(response.result, function (i, item) {
                    const dataAlt = item.data_alteracaoHis ? new Date(item.data_alteracaoHis).toLocaleString("pt-BR") : "-";
                    const dataProd = item.data_producao ? new Date(item.data_producao).toLocaleDateString("pt-BR") : "-";
                    html += "<tr><td>" + dataAlt + "</td><td>" + dataProd + "</td><td>" + (item.nome || "-") + "</td></tr>";
                });
            } else {
                html = "<tr><td colspan='3' style='text-align:center;'>Nenhum histórico encontrado.</td></tr>";
            }
            $("#tbodyProducao").html(html);
            $("#modal-historico-producao").modal("show");
        },
        error: function (xhr) {
            alert("Erro ao buscar histórico de produção!");
            console.error(xhr.responseText);
        }
    });
}

/**
 * 3. DATA PLANEJADA
 */
function salvarPlanejada() {
    var planej = document.querySelector('#data_planejada').value;
    var idos = document.querySelector('#idOs2').value;

    $.ajax({
        url: "<?php echo base_url(); ?>index.php/os/editar_dataplanejada",
        type: 'POST',
        dataType: 'json',
        data: {
            dataplanej: planej,
            idos: idos
        },
        success: function(data) {
            alert(data.msg);
        },
        error: function(xhr) {
            alert('Erro ao planejar a O.S.');
            console.log(xhr.responseText);
        }
    });
}

/**
 * 4. ALTERAÇÃO DE STATUS GERAL
 */
function alterarStatus(select, idOs) {
    $.ajax({
        url: "<?php echo base_url(); ?>index.php/os/alterarstatusos",
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            idOs: idOs,
            idStatusOs: select.value
        },
        success: function(data) {
            alert(data.msg);
            window.location.reload();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

/**
 * 5. INICIALIZAÇÃO (MÁSCARAS E EVENTOS)
 */
$(document).ready(function() {
    jQuery(".data").mask("99/99/9999");

    $("input:checkbox[name=checkSubOs]").click(function() {
        permCompra(this.value, this.checked);
    });

    $(document).on('click', 'input[type=text][id=example1]', function() {
        this.select();
    });
});

// Variável PHP passada para o JS
var temDataProducao = <?php echo ($temDataProd) ? 'true' : 'false'; ?>;

function verificarRegraStatus(select, idOs, temPermissao) {
    // Lista de IDs fornecida
    var statusRestritos = [6, 8, 18, 44, 76, 89, 91, 97, 101, 205, 210, 212, 218, 220, 222, 224, 227, 228];
    var valorSelecionado = parseInt(select.value);

    // Se o status está na lista e NÃO tem data de produção
    if (statusRestritos.indexOf(valorSelecionado) !== -1 && !temDataProducao) {
        // Mostra o quadro e NÃO executa a alteração
        $("#quadro-aviso-pcp").slideDown();
    } else {
        // Esconde o quadro e segue com o processo normal
        $("#quadro-aviso-pcp").hide();
        if (temPermissao) {
            alterarStatus(select, idOs);
        } else {
            select.form.submit();
        }
    }
}


/**
 * 6. LÓGICA DE CÁLCULO FINANCEIRO
 */
function calculaSubTotal() {
    var qtd = $('#qtd_os').val();
    var qtd_os_original = $('#qtd_os_original').val();
    if (qtd < qtd_os_original) {
        alert('Atenção, você alterou a qtd de itens, será gerada nova OS!');
    }

    var valorunit = $('#val_unit_os').val().toString().replaceAll(".", "").replaceAll(",", ".");
    var desconto = $('#desconto_os').val().toString().replace(".", "").replace(",", ".");
    var valoripi = $('#val_ipi_os').val().toString().replace(".", "").replace(",", ".");

    desconto = parseFloat(desconto) || 0;
    valoripi = parseFloat(valoripi) || 0;
    valorunit = parseFloat(valorunit) || 0;

    var total1 = (valorunit * qtd) - desconto;
    var total2 = (valorunit * qtd) * valoripi / 100;
    var total3 = total1 + total2;

    $('#subtot_os').val(retorna_formatado(total1));
    $('#total').val(retorna_formatado(total3));
}

function retorna_formatado(num) {
    var x = 0;
    if (num < 0) { num = Math.abs(num); x = 1; }
    if (isNaN(num)) num = "0";
    var cents = Math.floor((num * 100 + 0.5) % 100);
    var num_str = Math.floor((num * 100 + 0.5) / 100).toString();
    if (cents < 10) cents = "0" + cents;
    for (var i = 0; i < Math.floor((num_str.length - (1 + i)) / 3); i++)
        num_str = num_str.substring(0, num_str.length - (4 * i + 3)) + '.' + num_str.substring(num_str.length - (4 * i + 3));
    var ret = num_str + ',' + cents;
    return (x == 1) ? ' - ' + ret : ret;
}

/**
 * 7. SUPRIMENTOS E MODAIS DE O.C.
 */
function permCompra(idDistribuir, checked) {
    $.ajax({
        url: "<?php echo base_url(); ?>index.php/os/ativardesativarsubos",
        type: 'POST',
        dataType: 'json',
        data: { idOsSub: idDistribuir, status: checked }
    });
}

function openModalInfoOC(idPedidoCompra) {
    $.ajax({
        url: "<?php echo base_url(); ?>index.php/suprimentos/carregarinfooc",
        type: 'POST',
        dataType: 'json',
        async: false,
        data: { idPedidoCompra: idPedidoCompra },
        success: function(data) {
            if (data.result) carregarinfoModalOc(data.resultado);
        }
    });
}

function carregarinfoModalOc(item) {
    var html = "";
    for (var x = 0; x < item.length; x++) {
        html += "<tr>";
        html += "<td>" + item[x].idOs + "</td>";
        html += "<td>" + item[x].status_execucao + "</td>";
        var data_alteracao = new Date(item[x].data_alteracao);
        html += "<td>" + data_alteracao.toLocaleDateString('pt-BR', { timeZone: 'UTC' }) + "</td>";
        html += "<td>" + item[x].quantidade + "</td>";
        html += "<td>" + item[x].descricaoInsumo + (item[x].dimensoes ? " " + item[x].dimensoes : "") + "</td>";
        var data_cadastro = new Date(item[x].data_cadastro);
        html += "<td>" + data_cadastro.toLocaleDateString('pt-BR', { timeZone: 'UTC' }) + "</td>";
        html += "<td>" + item[x].nomeStatus + "</td>";
        html += "<td>" + item[x].nomeAgOrc + "</td>";
        var data_pedido = new Date(item[x].cadpedgerado);
        html += "<td>" + data_pedido.toLocaleDateString('pt-BR', { timeZone: 'UTC' }) + "</td>";
        html += "<td>" + item[x].user + "</td>";
        html += "</tr>";
    }
    $("#bInfoOC").empty().append(item[0].idPedidoCompra);
    $("#tableOC tbody").empty().append(html);
    $("#modal-oc").modal("show");
}

$(document).ready(function() {
    
    // Pega a variável que o Controller enviou (true ou false)
    var jaPossuiAjuste = <?php echo isset($ja_possui_ajuste_data) && $ja_possui_ajuste_data ? 'true' : 'false'; ?>;
    
    // Monitorea a mudança no select (Ajuste o name="motivo" se o seu campo tiver outro nome)
    $('select[name="motivo"], #motivoReagendamento').on('change', function() {
        var textoSelecionado = $(this).find("option:selected").text().trim().toLowerCase();
        var valorSelecionado = $(this).val().trim().toLowerCase();
        
        // Se escolheu Ajuste de Data E já existe no banco...
        if ((textoSelecionado === "ajuste de data" || valorSelecionado === "ajuste de data") && jaPossuiAjuste) {
            
            // Emite a mensagem exigida
            alert('Não é permitido alterar mais de uma vez a data para o motivo "Ajuste de Data".');
            
            // Reseta o select para a primeira opção (ex: "Selecione...") impedindo o cadastro
            $(this).prop('selectedIndex', 0); 
        }
    });

});

</script>