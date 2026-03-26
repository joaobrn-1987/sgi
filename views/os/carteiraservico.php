<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/fontawesome.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tableimprimir.css" />


<?php
//print_r(DateTimeZone::listIdentifiers());
//$data_atual = date('d/m/Y');

// TRATANDO DATAS - Wesley Guimarães
$data_inicial = $data_entrega["data_ini"];
$data_atual   = $data_entrega["data_final"];


$data_atual_sistem = date('d/m/Y H:i:s');
if (!$results) {

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
                        <t>NF Cliente</th>
                        <th>Qtd.</th>
                        <th>Item - Descrição</th>
                        <th>PN</th>
                        <?php
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                        ?>
                            <th>Valor</th>
                        <?php
                        }
                        ?>
                        <th>Data Ent.</th>
                        <th>Reprogr.</th>
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

<?php } else {


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

                                    <form class="form-inline" action="<?php echo base_url() ?>index.php/os/carteiraservico" method="get" name="form1" id="form1">

                                        <div class="span12" style="padding: 1%; margin-left: 0">
                                            <div class="span2" class="control-group">
                                                <label for="idOs" class="control-label">Cod. OS.:</label>
                                                <input class="span12 form-control" type="text" name="idOs" value="" autofocus class="span12">

                                            </div>
                                            <div class="span2" class="control-group">
                                                <label for="idOrcamentos" class="control-label">Cod. Orc.:</label>
                                                <input class="span12 form-control" type="text" name="idOrcamentos" value="" class="span12">

                                            </div>
                                            <!-- <div class="span1" class="control-group">
                                            <label for="cliente" class="control-label">Cliente:</label>
                                                        <input class="span12" class="span12 form-control" id="cliente"  type="text" name="cliente" value=""  />
                                            <input id="clientes_id"  type="hidden" name="clientes_id" value=""  />
                                        </div>-->



                                            <div class="span3" class="control-group">

                                                <label for="referencia" class="control-label"><b>PN</b>:</label>
                                                <input type="hidden" id="idProdutos" name="idProdutos" size="3" value="" />
                                                <input type="text" id="pn" class="span12" name="pn" size="97" ref="autocomplete" value="" />


                                            </div>

                                            <div class="span5" class="control-group">
                                                <label for="descricao_item" class="control-label">Descrição</label>

                                                <input id="descricao_item" class="span12" type="text" name="descricao_item" value="" />
                                            </div>
                                        </div>

                                        <div class="span12" style="padding: 1%; margin-left: 0">

                                            <div class="span12">
                                                <label for="cliente" class="control-label">Cliente:</label>
                                                <p>
                                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#adm" aria-expanded="false" aria-controls="collapseExample">
                                                        Mostrar/ocultar
                                                    </button>
                                                </p>
                                                <div class="collapse" id="adm">
                                                    <div class="card card-body">
                                                        <table>
                                                            <tr>
                                                                <input type="checkbox" name="todasf" id="todasf" onClick="CheckAll22f();">&nbsp;<b>Marcar/Desmarcar todos</b>
                                                                <br><br>
                                                                <?php
                                                                $i = 1;
                                                                foreach ($dados_clientes as $cli) {

                                                                ?>
                                                                    <td>
                                                                        <input type="checkbox" name="clientes_id[]" value="<?php echo $cli->idClientes; ?>"> <?php echo $cli->nomeCliente; ?>
                                                                    </td>
                                                                <?php
                                                                    if ($i % 2) {
                                                                        echo "</tr><tr>";
                                                                    }
                                                                    $i++;
                                                                }
                                                                ?>
                                                        </table>

                                                    </div>
                                                </div>




                                            </div>

                                            <div>

                                                <div class="span12" style="padding: 1%; margin-left: 0">




                                                    <div class="span6" class="control-group">
                                                        <label for="numpedido_os" class="control-label">Data cadastro:</label><br>

                                                        De: <input id="dataInicialcad" class="data" type="text" name="dataInicialcad" value="<?php echo $data_inicial;?>" /> | Até:<input id="dataFinalcad" class="data" type="text" name="dataFinalcad" value="<?php echo $data_atual; ?>" />
                                                    </div>

                                                    <div class="span6" class="control-group">
                                                        <label for="numpedido_os" class="control-label"><b>Data entrega e Data reagendada:</b></label><br>

                                                        De: <input id="dataeinicial" class="data" type="text" name="dataeinicial" value="" /> | Até:<input id="dataefinal" class="data" type="text" name="dataefinal" value="" />


                                                    </div>

                                                </div>

                                                <div class="span12" style="padding: 1%; margin-left: 0">

                                                    <div class="span6" class="control-group">
                                                        <label for="numpedido_os" class="control-label">Data entrega:</label><br>

                                                        De: <input type="date" name="dataInicialentrega" class="span5" /> | Até:<input type="date" name="dataFinalentrega" class="span5" />
                                                    </div>
                                                    <div class="span6" class="control-group">
                                                        <label for="numpedido_os" class="control-label">Data reagendada:</label><br>

                                                        De: <input type="date" name="dataInicialreag" class="span5" /> | Até:<input type="date" name="dataFinalreag" class="span5" />
                                                    </div>

		



                                                </div>
												<div class="span12" style="padding: 1%; margin-left: 0">
													<div class="span4" class="control-group">
														<label for="numpedido_os" class="control-label">Data Produção:</label><br>
														De: <input id="dataInicialProducao" class="span5" type="date" name="dataInicialProducao" value="" /> | Até:<input id="dataFinalProducao" class="span5" type="date" name="dataFinalProducao" value="" />
													</div>
												</div>

                                                <div class="span12" style="padding: 1%; margin-left: 0">




                                                    <div class="span412" class="control-group">


                                                        <label for="idGrupoServico" class="control-label">Status OS:</label>&nbsp;<input type="checkbox" name="todas" id="todas" onClick="CheckAll2();">&nbsp;Marcar/Desmarcar todos
                                                        <br>
                                                        <table width='100%'>
                                                            <tr>
                                                                <?php
                                                                $i = 0;
                                                                foreach ($status_os as $e) {



                                                                ?>
                                                                    <td>
                                                                        <input type="checkbox" name="idStatusOs[]" class='check' value="<?php echo $e->idStatusOs; ?>" <?php if ($e->carteirapadrao == 1) {
                                                                                                                                                                            echo "checked";
                                                                                                                                                                        }   ?>> &nbsp;<?php echo $e->nomeStatusOs; ?>
                                                                    </td>
                                                                <?php
                                                                    if (($i + 1) % 5 == 0)
                                                                        echo "</tr>";

                                                                    $i++;
                                                                }


                                                                ?>


                                                        </table>

                                                    </div>
                                                </div>

                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                
                                                    <div class="span4" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Unid. Execuçao:</label>


                                                        <?php foreach ($unid_exec as $exec) { ?>
                                                            <input type="checkbox" name="unid_execucao[]" class='check' value="<?php echo $exec->id_unid_exec; ?>"> &nbsp;<?php echo $exec->status_execucao; ?>

                                                        <?php } ?>


                                                    </div>
                                                    <div class="span4" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Unid. Faturamento:</label>


                                                        <?php foreach ($unid_fat as $fat) { ?>
                                                            <input type="checkbox" name="unid_faturamento[]" class='check' value="<?php echo $fat->id_unid_fat; ?>"> &nbsp;<?php echo $fat->status_faturamento; ?>


                                                        <?php } ?>

                                                        </select>

                                                    </div>
                                                    <div class="span2" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Tipo:</label>
                                                        <?php foreach ($tipo_os as $ostipo) { ?>
                                                            <input type="checkbox" name="id_tipo[]" class='check' value="<?php echo $ostipo->id_tipo; ?>"> &nbsp;<?php echo $ostipo->nome_tipo; ?>


                                                        <?php } ?>



                                                    </div>
                                                    <div class="span2" class="control-group">
                                                        <label for="idGrupoServico" class="control-label">Desenho: </label>



                                                        <input type="checkbox" name="desenho[]" class='check' value="3"> &nbsp;<i class="icon-ok" style="color:green"></i>
                                                        <input type="checkbox" name="desenho[]" class='check' value="2"> &nbsp;<i class="fas fa-exclamation-triangle" style="color:orange"></i>
                                                        <input type="checkbox" name="desenho[]" class='check' value="1"> &nbsp;<i class="icon-ban-circle" style="color:grey"></i>





                                                    </div>


                                                </div>
                                                <div class="span12" style="padding: 1%; margin-left:0">
                                                <label for="idGrupoServico" class="control-label">Vendedor: </label>
                                                <?php 
                                                foreach ($vendedores as $for) {

                                                    ?>
                                                    <td>
                                                    


                                                        <input type="checkbox" name="idVendedores[]" <?php if(isset($idVendedores)){foreach($idVendedores as $r){if($r == $for->idVendedor){echo 'checked';}}} ?> value="<?php echo $for->idVendedor; ?>"> <?php echo $for->nomeVendedor; ?>
                                                    </td>
                                                    <?php
                                                    if ($i == 1){
                                                        echo "</tr><tr>";
                                                        $i=0;
                                                    }
                                                    $i++;
                                                }?>
                                                </div>


                                                <div class="span12" style="padding: 1%; margin-left: 0">
                                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVerificacaocontroleOS')) {?>
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Verif. Cont.: </label>
                                                </br>
                                                <?php foreach($verificacao_controle as $r){?>
                                                    <input type="checkbox" name="verificacaoControle[]" class='check' value="<?php echo $r->idVerificacaoControle;?>"> &nbsp;<?php echo $r->descricaoControle;?>
                                                    </br>
                                                    <?php 
                                                }?>
                                                
                                            </div>
                                            <div class="span2" class="control-group">
                                                <label for="idGrupoServico" class="control-label">Status escopo: </label>
                                                <select class="span12" name="selectStatusPeritagem">
                                                    <option value=""></option>
                                                    <?php 
                                                        foreach($status_peritagem as $r){
                                                            echo "<option value='".$r->idStatusPeritagem."'>".$r->descricaoPeritagem."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="span2">
                                                    <label for="idGrupoServico" class="control-label">Grupo Serviço:</label>

                                                    <select class="span12 " name="idGrupoServico">
                                                        <option value=""></option>
                                                        <?php foreach ($dados_gruposervico as $gs) { ?>
                                                            <option value="<?php echo $gs->idGrupoServico; ?>"><?php echo $gs->nome; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php }?>

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
            <a href=javascript:; class="export-csv btn btn-mini btn-inverse" data-filename="Rel-Orcamento">Excel</a>
        </div>
        <div style="display: block ruby;">
            <h5>Legenda:</h5>
            <div>
                Completo <a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a>|
                Incompleto <a class="btn btn-small" style="border:0px"> <i class="fas fa-exclamation-triangle" style="color:orange"></i></a>|
                Sem desenho <a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a>
            </div>
        </div>
        <div class="widget-content nopadding" id="printOs">


            <table style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	font-size:11.5px; line-height:normal" border="1" width='100%' >

                <tr>
                    <td colspan='14' align='center'>
                        RELATÓRIO CARTEIRA DE SERVIÇO<br><?php echo  $data_atual_sistem; ?>
                    </td>
                </tr>
                <!--<tr>
	<td colspan='13' align='center' >
	
	Empresa: <?php echo $results[0]->nome; ?>
	</td>
	</tr>-->
                <tr>

                    <td align='center' ><b>OS.</b></td>
                    <td align='center' ><b>OR.</td>
                    <td align='center' ><b>Grupo</td>
                    <td align='center' ><b>Cliente</b></td>
                    <td align='center' ><b>Vendedor</b></td>
                    <td align='center' ><b>Data OS.</b></td>

                    <td align='center' ><b>NF Cliente</b></td>

                    <td align='center' ><b>Qtd.</b></td>
                    <td align='center' ><b>Item - Descrição</b></td>
                    <td align='center' ><b>PN</b></td>
                    <?php
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                    ?>
                        <td align='center'><b>Valor</b></td>
                    <?php
                    }
                    ?>
                    <td align='center' ><b>Data Ent.</b></td>
                    <td align='center' ><b>Reprogr.</b></td>
                    <td align='center' ><b>Status</b></td>
                    <td align='center' ><b>DES</b></td>
                    <?php
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVerificacaocontroleOS')) {
                    ?>
                        <td align='center' ><b>Verif. Cont.</b></td>
                    <?php
                    }
                    ?>
                    <td align='center' ><b>EXE</b></td>
                    <td align='center' ><b>FAT</b></td>
                    <td align='center' ><b>Tipo</b></td>
                    <td align='center'><b></b></td>
                </tr>


                <?php
                $totalos = 0;
                $somatorio = 0;
                $linha = 1;
                foreach ($results as $r) {
                    $color = '';

                    if ($r->data_entrega <> '') {
                        $data_entrega = date("d/m/Y", strtotime($r->data_entrega));
                    } else {
                        $data_entrega = "";
                    }

                    if ($r->data_reagendada <> '') {
                        $data_reagendada = date("d/m/Y", strtotime($r->data_reagendada));
                    } else {
                        $data_reagendada = "";
                    }



                    echo '<tr >';
                    echo '<td align="center" >' . $r->idOs . '</td>';
                    echo '<td align="center">' . $r->idOrcamentos . '</td>';
                    echo '<td align="center">' . $r->nomeServico . '</td>';
                    if($r->nomeClienteCart){
                        $nomeCliente = $r->nomeClienteCart;
                    }else{
                        $nomeCliente = $r->nomeCliente;
                    }
                    if($this->session->userdata('permissao') == 1){
                        $rest1 = '';
                        $desc_banco1 = substr($nomeCliente, 0, 42);
                        //$desc_banco1 = $r->nomeCliente;
                        /**/$conta1 = strlen($nomeCliente);
                        if ($conta1 > 42) {
                            $rest1 = " (...)";
                        }
                    }else{
                        $rest1 = '';
                        //$desc_banco1 = substr($r->nomeCliente, 0, 42);
                        $desc_banco1 = $nomeCliente;
                        /*$conta1 = strlen($r->nomeCliente);
                        if ($conta1 > 42) {
                            $rest1 = " (...)";
                        }*/
                    }
                    
                    
                    echo '<td>' . $desc_banco1 . $rest1 . '</td>';
                    echo '<td>' . $r->nomeVendedor.'</td>';
                    echo '<td align="center">' . (!empty($r->data_abertura)?date("d/m/Y", strtotime($r->data_abertura)):"") . '</td>';

                    if($r->nf_cliente == '' || $r->nf_cliente == null){
                        echo '<td>'. $r->nf_cliente .'</td>';
                    }else{
                        echo '<td>'. $r->nomeArquivo .'</td>';
                    }

                    
                    

                    echo '<td align="right">' . $r->qtd_os . ' '.$r->descricaoTipoQtd.'</td>';


                    $rest = '';
                    $desc_banco = substr($r->descricao_item, 0, 50);
                    $conta = strlen($r->descricao_item);
                    if ($conta > 50) {
                        $rest = " (...)";
                    }

                    echo '<td>' . $desc_banco . $rest . '</td>';

                    echo '<td align="center">' . $r->pn . '</td>';

                    $calc = $r->qtd_os * $r->val_unit_os - $r->desconto_os;
                    $ipicalc = $r->val_ipi_os / 100 * $calc;
                    $result = $calc + $ipicalc;
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {


                        echo '<td align="right">' . number_format($result, 2, ",", ".") . '</td>';
                    }
                    echo '<td align="center">' . $data_entrega . '</td>';
                    echo '<td align="center">' . $data_reagendada . '</td>';

                    echo '<td>' . $r->nomeStatusOs . '</td>';
                    if ($r->statusDesenho == 3) {
                        echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"> <img src="' . base_url() . 'img/confirm.png" style="max-width: none;"></a></div></font></td>';
                        //echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a></div></font></td>';
                    } else if ($r->statusDesenho == 1) {
                        echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"><img src="' . base_url() . 'img/block.png" style="max-width: none;" ></a></div></font></td>';
                        //echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a></div></font></td>';
                    } else {
                        echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"><img src="' . base_url() . 'img/alert.png" style="max-width: none;" ></a></div></font></td>';
                    }
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVerificacaocontroleOS')) {
                        echo '<td align="center">' . $r->descricaoControle . '</td>';
                    }
                    echo '<td align="center">' . $r->status_execucao . '</td>';
                    echo '<td align="center">' . $r->status_faturamento . '</td>';
                    echo '<td><font size="1">' . $r->nome_tipo . '</font></td>';
                    echo '<td><font size="1">';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                        echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" style="margin-right: 1%" class="btn tip-top" ><i class="icon-eye-open"></i></a>';
                    }
                    echo '</font></td>';

                    echo '</tr>';



                    $totalos++;
                    $somatorio = $somatorio + $result;
                }
                ?>

                <tr>
                    <?php
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                    ?>
                        <td colspan='7' align='right'>
                            Total:
                        </td>
                        <td>
                            <?php
                            echo number_format($somatorio, 2, ",", ".");
                            ?>
                        </td>
                    <?php
                    }
                    ?>
                    <td colspan='13' align='right'>Total de OS: <?php echo $totalos; ?></td>
                </tr>

            </table>
            <?php
            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
            ?>
                <div>
                    <br>
                    <table style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	font-size:10px;" border="1" width='50%'>
                        <?php
                        echo "<tr><td>Status</td><td>QTD</td><td>Valor</td></tr>";
                        $mudast = 0;
                        $escreve = '';
                        $soma_qtos = 0;
                        $somatoria_os = 0;
                        $mudalin = 0;
                        $i = 1;
                        $conta = count($result_status);
                        foreach ($result_status as $re_sta) {


                            if ($mudast == 0) {
                                if(!empty($re_sta->status_execucao)){
                                    echo "<tr><td colspan='3'><b>";
                                    echo $re_sta->status_execucao;
                                    echo "</b></td></tr>";
                                    $escreve = $re_sta->status_execucao;
                                    $soma_qtos = $soma_qtos + $re_sta->qtdos;
                                    $somatoria_os = $somatoria_os + $re_sta->soma;
                                }else{
                                    echo "<tr><td colspan='3'><b>";
                                    echo "Unid. Exec. Não definido";
                                    echo "</b></td></tr>";
                                    $escreve = $re_sta->status_execucao;
                                    $soma_qtos = $soma_qtos + $re_sta->qtdos;
                                    $somatoria_os = $somatoria_os + $re_sta->soma;
                                }
                                
                            } else {

                                if ($escreve <> $re_sta->status_execucao) {
                                    echo "<tr><b><td align='right'>";
                                    echo "Total:</td><td>";
                                    echo $soma_qtos;
                                    echo "</td><td>";
                                    echo "R$ " . number_format($somatoria_os, 2, ",", ".");
                                    echo "</td></b></tr>";

                                    $soma_qtos = '';
                                    $somatoria_os = '';

                                    if(!empty($re_sta->status_execucao)){
                                        echo "<tr><td colspan='3'><b>";
                                        echo $re_sta->status_execucao;
                                        echo "</b></td></tr>";
                                        $escreve = $re_sta->status_execucao;
                                        $soma_qtos = $soma_qtos + $re_sta->qtdos;
                                        $somatoria_os = $somatoria_os + $re_sta->soma;
                                    }else{
                                        echo "<tr><td colspan='3'><b>";
                                        echo "Unid. Exec. Não definido";
                                        echo "</b></td></tr>";
                                        $escreve = $re_sta->status_execucao;
                                        $soma_qtos = $soma_qtos + $re_sta->qtdos;
                                        $somatoria_os = $somatoria_os + $re_sta->soma;
                                    }
                                    
                                } else {
                                    $soma_qtos = $soma_qtos + $re_sta->qtdos;
                                    $somatoria_os = $somatoria_os + $re_sta->soma;
                                }
                            }
                            echo "<tr><td>";
                            echo $re_sta->nomeStatusOs;
                            echo "</td><td>";
                            echo $re_sta->qtdos;
                            echo "</td><td>";
                            echo "R$ " . number_format($re_sta->soma, 2, ",", ".");
                            echo "</tr>";
                            if ($i == $conta) {
                                echo "<tr><td align='right'>";
                                echo "Total:</td><td>";
                                echo $soma_qtos;
                                echo "</td><td>";
                                echo "R$ " . number_format($somatoria_os, 2, ",", ".");
                                echo "</td></tr>";
                            }

                            $i++;
                            $mudast++;
                        }
                        ?>
                    </table>
                </div>
                <?php } ?>
            <div id="printOs2" style="display:none">
            <table style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	            font-size:11.5px; line-height:normal;" border="1" width='100%' id="fixed_table" >

                <tr>
                    <td colspan='14' align='center'>
                        RELATÓRIO CARTEIRA DE SERVIÇO<br><?php echo  $data_atual_sistem; ?>
                    </td>
                </tr>
                <!--<tr>
	<td colspan='13' align='center' >
	
	Empresa: <?php echo $results[0]->nome; ?>
	</td>
	</tr>-->
                <tr>

                    <td align='center' style="font-size: 11px;"><b>O.S.</b></td>
                    <td align='center' style="font-size: 11px;"><b>Orç.</td>
                    <td align='center' style="font-size: 11px;width: 350px;"><b>Cliente</b></td>
                    <td align='center' style="font-size: 11px;"><b>Data OS.</b></td>
                    <td align='center' style="font-size: 11px;"><b>Qtd.</b></td>
                    <td align='center' style="font-size: 11px;width: 475px;"><b>Item - Descrição</b></td>
                    <td align='center' style="font-size: 11px;"><b>PN</b></td>
                    <?php
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                    ?>
                        <td align='center' style="font-size: 11px;"><b>Valor</b></td>
                    <?php
                    }
                    ?>
                    <td align='center' style="font-size: 11px;"><b>Data Ent.</b></td>
                    <td align='center' style="font-size: 11px;"><b>Reprogr.</b></td>
                    <td align='center' style="font-size: 11px;"><b>Status</b></td>
                    <?php if($this->session->userdata('permissao') != 1){?>
                    <td align='center' style="font-size: 11px;"><b>Des.</b></td>
                    <?php
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVerificacaocontroleOS')) {
                        ?>
                            <td align='center' style="font-size: 11px;"><b>C.Q.</b></td>
                        <?php
                        }
                    }
                    ?>
                    <td align='center' style="font-size: 11px;"><b>U. Exec.</b></td>
                    <td align='center' style="font-size: 11px;"><b>U. Fat.</b></td><!--
                    <td align='center' style="font-size: 11px;"><b>Tipo</b></td>-->
                </tr>


                <?php
                $totalos = 0;
                $somatorio = 0;
                $linha = 1;
                foreach ($results as $r) {
                    $color = '';

                    if ($r->data_entrega <> '') {
                        $data_entrega = date("d/m/Y", strtotime($r->data_entrega));
                    } else {
                        $data_entrega = "";
                    }

                    if ($r->data_reagendada <> '') {
                        $data_reagendada = date("d/m/Y", strtotime($r->data_reagendada));
                    } else {
                        $data_reagendada = "";
                    }



                    echo '<tr style="font-size: 11px;height:27px;min-height: 27px">';
                    echo '<td align="center" >' . $r->idOs . '</td>';
                    echo '<td align="center">' . $r->idOrcamentos . '</td>';
                    if($r->nomeClienteCart){
                        $nomeCliente = $r->nomeClienteCart;
                    }else{
                        $nomeCliente = $r->nomeCliente;
                    }
                    if($this->session->userdata('permissao') == 1){
                        $rest1 = '';
                        $desc_banco1 = substr($nomeCliente, 0, 32);
                        //$desc_banco1 = $r->nomeCliente;/**/
                        $conta1 = strlen($nomeCliente);
                        if ($conta1 > 32) {
                            $rest1 = " (...)";
                        }
                    }else{
                        $rest1 = '';
                        $desc_banco1 = substr($nomeCliente, 0, 32);
                        //$desc_banco1 = $r->nomeCliente;
                        $conta1 = strlen($nomeCliente);
                        if ($conta1 > 32) {
                            $rest1 = " (...)";
                        }/**/
                    }
                    
                    echo '<td>' . $desc_banco1 . $rest1 . '</td>';
                    echo '<td align="center">' . date("d/m/Y", strtotime($r->data_abertura)) . '</td>';
                    
                    echo '<td align="right">' . $r->qtd_os . ' '.$r->descricaoTipoQtd. '</td>';
                    $rest = '';
                    $rest2 = '';
                    $desc_banco = substr($r->descricao_item, 0, 40);
                    $pnsub = substr($r->pn, 0, 10);
                    $conta = strlen($r->descricao_item);
                    if ($conta > 40) {
                        $rest = " (...)";
                    }
                    $conta2 = strlen($r->pn);
                    if ($conta2 > 10) {
                        $rest2 = " (...)";
                    }
                    echo '<td>' . $desc_banco . $rest . '</td>';

                    echo '<td align="center">' . $pnsub . $rest2 . '</td>';

                    $calc = $r->qtd_os * $r->val_unit_os - $r->desconto_os;
                    $ipicalc = $r->val_ipi_os / 100 * $calc;
                    $result = $calc + $ipicalc;
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {


                        echo '<td align="right">' . number_format($result, 2, ",", ".") . '</td>';
                    }
                    echo '<td align="center">' . $data_entrega . '</td>';
                    echo '<td align="center">' . $data_reagendada . '</td>';

                    echo '<td style="width: 150px;">' . $r->nomeStatusOs . '</td>';
                    if($this->session->userdata('permissao') != 1){
                        if ($r->statusDesenho == 3) {
                            echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px;max-height: 15px;"> <img src="' . base_url() . 'img/confirm.png" style="max-width: none;"></a></div></font></td>';
                            //echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a></div></font></td>';
                        } else if ($r->statusDesenho == 1) {
                            echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px;max-height: 15px;"><img src="' . base_url() . 'img/block.png" style="max-width: none;" ></a></div></font></td>';
                            //echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a></div></font></td>';
                        } else {
                            echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px;max-height: 15px;"><img src="' . base_url() . 'img/alert.png" style="max-width: none;" ></a></div></font></td>';
                        }
                    
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVerificacaocontroleOS')) {
                            if ($r->descricaoControle == 'LIBERAÇÃO TOTAL DO CONTROLE') {
                                echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px;max-height: 15px;"> <img src="' . base_url() . 'img/confirm.png" style="max-width: none;"></a></div></font></td>';
                                //echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"> <i class="icon-ok" style="color:green"></i></a></div></font></td>';
                            } else if ($r->descricaoControle == 'NÃO CONTROLADO') {
                                echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px;max-height: 15px;"><img src="' . base_url() . 'img/block.png" style="max-width: none;" ></a></div></font></td>';
                                //echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px"><i class="icon-ban-circle" style="color:grey"></i></a></div></font></td>';
                            } else {
                                echo '<td style="text-align: center;"><font size="1"><div ><a class="btn btn-small" style="border:0px;max-height: 15px;"><img src="' . base_url() . 'img/alert.png" style="max-width: none;" ></a></div></font></td>';
                            }
                            //echo '<td align="center">' . $r->descricaoControle . '</td>';
                        }
                    }
                    echo '<td align="center">' . $r->status_execucao . '</td>';
                    echo '<td align="center">' . $r->status_faturamento . '</td>';
                    //echo '<td><font size="1">' . $r->nome_tipo . '</font></td>';

                    echo '</tr>';



                    $totalos++;
                    $somatorio = $somatorio + $result;
                }
                ?>

                <tr>
                    <?php
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
                    ?>
                        <td colspan='7' align='right'>
                            Total:
                        </td>
                        <td>
                            <?php

                            echo number_format($somatorio, 2, ",", ".");

                            ?>
                        </td>
                    <?php
                    }
                    ?>
                    <td colspan='13' align='right'>Total de OS: <?php echo $totalos; ?></td>
                </tr>

            </table>

            <?php
            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vvalorOs')) {
            ?>
                <div>
                    <br>
                    <table style="border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;
	font-size:10px;" border="1" width='50%'>
                        <?php
                        echo "<tr><td>Status</td><td>QTD</td><td>Valor</td></tr>";
                        $mudast = 0;
                        $escreve = '';
                        $soma_qtos = 0;
                        $somatoria_os = 0;
                        $mudalin = 0;
                        $i = 1;
                        $conta = count($result_status);
                        foreach ($result_status as $re_sta) {
                            if ($mudast == 0) {
                                if($re_sta->status_execucao){
                                    echo "<tr><td colspan='3'><b>";
                                    echo $re_sta->status_execucao;
                                    echo "</b></td></tr>";
                                    $escreve = $re_sta->status_execucao;
                                    $soma_qtos = $soma_qtos + $re_sta->qtdos;
                                    $somatoria_os = $somatoria_os + $re_sta->soma;
                                }else{
                                    echo "<tr><td colspan='3'><b>";
                                    echo "Unid. Exec. Não definido";
                                    echo "</b></td></tr>";
                                    $escreve = $re_sta->status_execucao;
                                    $soma_qtos = $soma_qtos + $re_sta->qtdos;
                                    $somatoria_os = $somatoria_os + $re_sta->soma;
                                }
                                
                            } else {

                                if ($escreve <> $re_sta->status_execucao) {
                                    echo "<tr><b><td align='right'>";
                                    echo "Total:</td><td>";
                                    echo $soma_qtos;
                                    echo "</td><td>";
                                    echo "R$ " . number_format($somatoria_os, 2, ",", ".");
                                    echo "</td></b></tr>";

                                    $soma_qtos = '';
                                    $somatoria_os = '';

                                    if($re_sta->status_execucao){
                                        echo "<tr><td colspan='3'><b>";
                                        echo $re_sta->status_execucao;
                                        echo "</b></td></tr>";
                                        $escreve = $re_sta->status_execucao;
                                        $soma_qtos = $soma_qtos + $re_sta->qtdos;
                                        $somatoria_os = $somatoria_os + $re_sta->soma;
                                    }else{
                                        echo "<tr><td colspan='3'><b>";
                                        echo "Unid. Exec. Não definido";
                                        echo "</b></td></tr>";
                                        $escreve = $re_sta->status_execucao;
                                        $soma_qtos = $soma_qtos + $re_sta->qtdos;
                                        $somatoria_os = $somatoria_os + $re_sta->soma;
                                    }
                                    
                                } else {
                                    $soma_qtos = $soma_qtos + $re_sta->qtdos;
                                    $somatoria_os = $somatoria_os + $re_sta->soma;
                                }
                            }
                            echo "<tr><td>";
                            echo $re_sta->nomeStatusOs;
                            echo "</td><td>";
                            echo $re_sta->qtdos;
                            echo "</td><td>";
                            echo "R$ " . number_format($re_sta->soma, 2, ",", ".");
                            echo "</tr>";
                            if ($i == $conta) {
                                echo "<tr><td align='right'>";
                                echo "Total:</td><td>";
                                echo $soma_qtos;
                                echo "</td><td>";
                                echo "R$ " . number_format($somatoria_os, 2, ",", ".");
                                echo "</td></tr>";
                            }

                            $i++;
                            $mudast++;
                        }
                        ?>
                    </table>
                </div>
                
            </div>
            <?php
            }
            ?>



        </div>



    </div>
<?php echo $this->pagination->create_links();
} ?>








<script type="text/javascript">
    $(document).ready(function() {

        jQuery(".data").mask("99/99/9999");
    });

    $(document).ready(function() {



        $(document).on('click', 'a', function(event) {

            var orc = $(this).attr('orc');
            $('#idorc').val(orc);

        });


        $(document).on('click', 'a', function(event) {

            var orc2 = $(this).attr('orc2');
            $('#idorc2').val(orc2);

        });

    });
    $(document).ready(function() {

        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {

                $("#clientes_id").val(ui.item.id);

                //getValor(ui.item.id);

            }
        });



    });
    console.log('#idProdutos');
    $("#pn").autocomplete({
        source: "<?php echo base_url(); ?>index.php/orcamentos/autoCompletePN",
        minLength: 1,
        select: function(event, ui) {
            $('#idProdutos').val(ui.item.id);

        }
    });
</script>
<script>
    ok = false;

    function CheckAll2() {
        if (!ok) {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'idStatusOs[]') {
                    x.checked = true;
                    ok = true;
                }
            }
        } else {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'idStatusOs[]') {
                    x.checked = false;
                    ok = false;
                }
            }
        }
    }
    okf = false;

    function CheckAll22f() {
        if (!okf) {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'clientes_id[]') {
                    x.checked = true;
                    okf = true;
                }
            }
        } else {
            for (var i = 0; i < document.form1.elements.length; i++) {
                var x = document.form1.elements[i];
                if (x.name == 'clientes_id[]') {
                    x.checked = false;
                    okf = false;
                }
            }
        }
    }
</script>
<script type="text/javascript">
    $(function() {
        $(".export-csv").on('click', function(event) {
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
                csv = startQuote + $rows.map(function(i, row) {
                    var $row = $(row),
                        $cols = $row.find('td,th');
                    return $cols.map(function(j, col) {
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

                var blob = new Blob([decodeURIComponent(BOM + csv)], {
                    type: 'text/csv;charset=utf8'
                });

                window.navigator.msSaveBlob(blob, filename);

            } else if (window.Blob && window.URL) {
                // HTML5 Blob        
                var blob = new Blob([BOM + csv], {
                    type: 'text/csv;charset=utf8'
                });
                var csvUrl = URL.createObjectURL(blob);

                $(this)
                    .attr({
                        'download': filename,
                        'href': csvUrl
                    });
            } else {
                // Data URI
                var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(BOM + csv);

                $(this)
                    .attr({
                        'download': filename,
                        'href': csvData,
                        'target': '_blank'
                    });
            }
        }

    });
    $(document).ready(function() {
        $("#imprimir").click(function() {
            PrintElem('#printOs2');
        })

        function PrintElem(elem) {
            Popup($(elem).html());
        }

        function Popup(data) {
            var mywindow = window.open('', 'SGI', 'height=600,width=800');
            mywindow.document.write('<html><head><title>SGI</title><meta charset="UTF-8" />');
            /* mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/bootstrap.min.css' /><link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css' />");*/
            mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/tableimprimir.css' />");


            mywindow.document.write('</head><body >');
            mywindow.document.write(data);
            mywindow.document.write('</body></html>');

            mywindow.print();
            //mywindow.close();

            return true;
        }

    });
</script>