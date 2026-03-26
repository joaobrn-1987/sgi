<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * @property Almoxarifado_model $almoxarifado_model
 * @property Arquivos_model $arquivos_model
 * @property Clientes_model $clientes_model
 * @property Conecte_model $conecte_model
 * @property Cotacao_model $cotacao_model
 * @property Desenho_model $desenho_model
 * @property Estoque_model $estoque_model
 * @property Financeiro_model $financeiro_model
 * @property Fornecedores_model $fornecedores_model
 * @property Insumos_model $insumos_model
 * @property Mapos_model $mapos_model
 * @property Maquinas_model $maquinas_model
 * @property Maquinasusuarios_model $maquinasusuarios_model
 * @property Orcamentos_model $orcamentos_model
 * @property Os_model $os_model
 * @property Pedidocompra_model $pedidocompra_model
 * @property Pedidocompraalmox_model $pedidocompraalmox_model
 * @property Peritagem_model $peritagem_model
 * @property Permissoes_model $permissoes_model
 * @property Processos_model $processos_model
 * @property Producao_model $producao_model
 * @property Produtos_model $produtos_model
 * @property Registrodescarte_model $registrodescarte_model
 * @property Relatorios_model $relatorios_model
 * @property Usuarios_model $usuarios_model
 */

class Relatorios extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        $this->load->model('Relatorios_model','',TRUE);
        $this->data['menuRelatorios'] = 'Relatórios';

    }

    /**
     * Valida e retorna uma data no formato Y-m-d.
     * Se inválida, retorna a data atual como fallback seguro.
     */
    private function _sanitizeDate($d) {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) {
            $dt = DateTime::createFromFormat('Y-m-d', $d);
            if ($dt && $dt->format('Y-m-d') === $d) {
                return $d;
            }
        }
        return date('Y-m-d');
    }

    /**
     * Converte data DD/MM/YYYY para Y-m-d com validação.
     * Retorna null se o formato ou data forem inválidos.
     */
    private function _convertAndValidateDate($dmy) {
        $parts = explode('/', $dmy);
        if (count($parts) !== 3) return null;
        $iso = $parts[2].'-'.$parts[1].'-'.$parts[0];
        $dt = DateTime::createFromFormat('Y-m-d', $iso);
        if ($dt && $dt->format('Y-m-d') === $iso) return $iso;
        return null;
    }
 public function imprimir_pedido(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Pedido.');
           redirect(base_url());
        }
		

        $this->data['custom_error'] = '';
        $this->load->model('relatorios_model');
		
		

         $data['result'] = $this->relatorios_model->pedidoCustom($this->uri->segment(3));
       

	
				$this->load->helper('mpdf');
           echo $html = $this->load->view('relatorios/imprimir/imprimir_pedido',$data,true);
       
    }
    public function clientes(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_clientes';
       	$this->load->view('tema/topo',$this->data);
    }
	
 /*   function rel_orcamento()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para ver relatorio de orçamento.');
            redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->model('orcamentos_model');
        $this->load->model('almoxarifado_model');
        $this->load->model('os_model');
        $this->load->model('relatorios_model');

        $idUser = $this->session->userdata('idUsuarios');
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);

        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
        $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
        $this->data['dados_vendedor'] = $this->orcamentos_model->getVendedor();
        $this->data['idVendedoresAux'] = $this->orcamentos_model->getVendedorAuxiliar();
        $this->data['todas_regioes'] = $this->relatorios_model->getTodasRegioes();
        $this->data['regiao'] = $this->relatorios_model->regiao();
        $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
        $this->data['dados_statusos'] = $this->orcamentos_model->getStatusOs();
        $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();

        $petrolina = false;
        $uberlandia = false;
        if (count($getUserEmpresa) > 0) {
            foreach ($getUserEmpresa as $r) {
                if ($r->id == 1 || $r->id == 3) {
                    $uberlandia = true;
                }
                if ($r->id == 2) {
                    $petrolina = true;
                }
            }
            if ($uberlandia == true && $petrolina == true) {
                $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
            } else if ($uberlandia == true) {
                $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
            } else if ($petrolina == true) {
                $this->data['dados_clientes'] = $this->orcamentos_model->getCliente2();
            }
        } else {
            $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
        }
        $this->data['status_orcamento'] = $this->orcamentos_model->getCliente('');
        $config['base_url'] = base_url() . 'index.php/relatorios/rel_orcamento/';
        $cod_orc = $this->input->get('idOrcamentos');
        $referencia = $this->input->get('referencia');
        $num_pedido = $this->input->get('num_pedido');
        $num_nf = $this->input->get('num_nf');
        $regiao = $this->input->get('regiao');
        $idstatusOs = $this->input->get('idstatusOs'); 
        $clientes_id = $this->input->get('clientes_id');
        $idstatusOrcamento = $this->input->get('idstatusOrcamento');
        $idNatOperacao = $this->input->get('idNatOperacao');
        $idGrupoServico = $this->input->get('idGrupoServico');

        // INÍCIO DA ALTERAÇÃO FINAL NO CONTROLLER
        if (is_array($idstatusOrcamento)) {
            // Verifica se o gatilho para "Orçamento Pendente" (11) foi acionado
            if (in_array('11', $idstatusOrcamento)) {
                
                // Adiciona o status 3 (Rejeitados/Cancelados) à busca
                if (!in_array('3', $idstatusOrcamento)) {
                    $idstatusOrcamento[] = '3';
                }

                // Adiciona o status 13 (Aprovado Parcial) à busca, para encontrar o orçamento 31009
                if (!in_array('13', $idstatusOrcamento)) {
                    $idstatusOrcamento[] = '13';
                }
            }
        }
        // FIM DA ALTERAÇÃO FINAL NO CONTROLLER

        $querydatacadastro = "";
        $dataInicialcad = $this->input->get('dataInicialcad');
        $dataFinalcad = $this->input->get('dataFinalcad');

        if (empty($dataInicialcad)) {
            $date = new DateTime();
            $interval = new DateInterval('P3M');
            $dataInicialcad = $date->sub($interval)->format('d/m/Y');
            $dataFinalcad = new DateTime();
            $dataFinalcad = $dataFinalcad->format('d/m/Y');

            $data_entrega['data_ini'] = $dataInicialcad;
            $data_entrega['data_final'] = $dataFinalcad;
            $this->data['data_entrega'] = $data_entrega;
        } else {
            $this->data['data_entrega'] = null;
        }
        if (!empty($dataInicialcad) && !empty($dataFinalcad)) {
            $dataInicialcad2 = explode('/', $dataInicialcad);
            $dataInicialcad2 = $dataInicialcad2[2] . '-' . $dataInicialcad2[1] . '-' . $dataInicialcad2[0];
            $dataFinalcad2 = explode('/', $dataFinalcad);
            $dataFinalcad2 = $dataFinalcad2[2] . '-' . $dataFinalcad2[1] . '-' . $dataFinalcad2[0];
            $querydatacadastro = " and orcamento.data_abertura BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
        }
        $status_orc = $this->input->get('status_orc');

        $query_statusorc = "";
        if (!empty($status_orc)) {
            $conteudoo = $status_orc;
            $query_statusorc = "(";
            $primeiroco = true;
            foreach ($conteudoo as $status3orc) {
                if ($primeiroco) {
                    $query_statusorc .= $status3orc;
                    $primeiroco = false;
                } else {
                    $query_statusorc .= "," . $status3orc;
                }
            }
            $query_statusorc .= ")";
        }

        $query_clientes = "";
        $query_clientes3 = '';
        if (!empty($clientes_id)) {
            $conteudoc = $clientes_id;
            $query_clientes = "(";
            $primeiroc = true;
            foreach ($conteudoc as $clientes3) {
                if ($primeiroc) {
                    $query_clientes .= $clientes3;
                    $primeiroc = false;
                } else {
                    $query_clientes .= "," . $clientes3;
                }
            }
            $query_clientes .= ")";
        } else {
            if ($uberlandia == true && $petrolina == true) {
                $query_clientes3 = '';
            } else if ($petrolina == true) {
                $query_clientes3 = " and clientes.idClientes in(706,702,711,528,552,540,519,543,581,684,635,517,580,575,532,516,10,551)";
            } else {
                $query_clientes3 = '';
            }
        }

        $query_idstatusOrcamento = "";
        if (!empty($idstatusOrcamento) && is_array($idstatusOrcamento)) {
            $conteudow1 = $idstatusOrcamento;
            $query_idstatusOrcamento = "(";
            $primeiro2w = true;
            foreach ($conteudow1 as $statusorc3) {
                if ($primeiro2w) {
                    $query_idstatusOrcamento .= $statusorc3;
                    $primeiro2w = false;
                } else {
                    $query_idstatusOrcamento .= "," . $statusorc3;
                }
            }
            $query_idstatusOrcamento .= ")";
        }
        $vendedor = $this->input->get('idVendedores');
        $query_vendedor = "";
        $primeirovend = true;
        if (!empty($vendedor)) {
            $vendedor2 = "";
            foreach ($vendedor as $des) {
                if ($primeirovend) {
                    $vendedor2 = $des;
                    $primeirovend = false;
                } else {
                    $vendedor2 = $vendedor2 . ',' . $des;
                }
            }
            $query_vendedor = "($vendedor2)";
        }

        $idstatusOs_filter = $this->input->get('idstatusOs');
        $query_idstatusOs = "";
        $primeirostatus = true;
        if (!empty($idstatusOs_filter)) { 
            $status2 = "";
            foreach ($idstatusOs_filter as $so) {
                if ($primeirostatus) {
                    $status2 = $so;
                    $primeirostatus = false;
                } else {
                    $status2 = $status2 . ',' . $so;
                }
            }
            $query_idstatusOs = "($status2)";
        }

        $query_idGrupoServico = "";
        if (!empty($idGrupoServico)) {
            $conteudow = $idGrupoServico;
            $query_idGrupoServico = "(";
            $primeirow = true;
            foreach ($conteudow as $grpo3) {
                if ($primeirow) {
                    $query_idGrupoServico .= $grpo3;
                    $primeirow = false;
                } else {
                    $query_idGrupoServico .= "," . $grpo3;
                }
            }
            $query_idGrupoServico .= ")";
        }

        $query_idNatOperacao = "";
        if (!empty($idNatOperacao)) {
            $conteudod = $idNatOperacao;
            $query_idNatOperacao = "(";
            $primeirod = true;
            foreach ($conteudod as $natoperacao3) {
                if ($primeirod) {
                    $query_idNatOperacao .= $natoperacao3;
                    $primeirod = false;
                } else {
                    $query_idNatOperacao .= "," . $natoperacao3;
                }
            }
            $query_idNatOperacao .= ")";
        }

        $idProdutos = $this->input->get('idProdutos');

        $vendedor = $this->input->get('idVendedores');
        $query_vendedor = "";
        $primeirovend = true;
        if (!empty($vendedor)) {
            $vendedor2 = "";
            foreach ($vendedor as $des) {
                if ($primeirovend) {
                    $vendedor2 = $des;
                    $primeirovend = false;
                } else {
                    $vendedor2 = $vendedor2 . ',' . $des;
                }
            }
            $query_vendedor = "($vendedor2)";
        }

        $idVendedorAuxiliar = $this->input->get('idVendedoresAux');
        $query_vendedorAuxiliar = "";
        $primeirovendaux = true;
        if (!empty($idVendedorAuxiliar)) {
            $vendedoraux2 = "";
            foreach ($idVendedorAuxiliar as $vaux) {
                if ($primeirovendaux) {
                    $vendedoraux2 = $vaux;
                    $primeirovendaux = false;
                } else {
                    $vendedoraux2 = $vendedoraux2 . ',' . $vaux;
                }
            }
            $query_vendedorAuxiliar = "($vendedoraux2)";
        }

        if (!empty($regiao) || !empty($idVendedorAuxiliar) || !empty($cod_orc) || !empty($referencia) ||  !empty($num_pedido) || !empty($num_nf)  || !empty($querydatacadastro) || !empty($query_statusorc) || !empty($num_pedido) || !empty($num_nf)  || !empty($query_clientes) || !empty($query_clientes) || !empty($query_idGrupoServico) || !empty($query_idNatOperacao) || !empty($query_idstatusOrcamento) || !empty ($query_idstatusOs) ||!empty($idProdutos) || !empty($query_clientes3) || !empty($query_vendedor) || !empty($query_vendedorAuxiliar)) {
            $this->data['results'] = $this->relatorios_model->getWhereLikeos2orc(
                $regiao,
                $idVendedorAuxiliar,
                $cod_orc,
                $referencia,
                $num_pedido,
                $num_nf,
                $querydatacadastro,
                $query_statusorc,
                $query_clientes,
                $query_idGrupoServico,
                $query_idNatOperacao,
                $query_idstatusOrcamento,
                $query_idstatusOs,
                $idProdutos,
                $query_clientes3,
                $query_vendedor,
                $query_vendedorAuxiliar
            );
        } else {
            $this->data['results'] = $this->relatorios_model->getAllOrcamentos();
        }
        $this->data['todas_regioes'] = $this->relatorios_model->getTodasRegioes();
        $this->data['regiao'] = $this->relatorios_model->regiao();
        $this->data['vendedores'] = $this->Relatorios_model->vendedoresRapid();
        $this->data['idVendedores'] = $this->Relatorios_model->vendedoresAuxRapid();
        $this->data['view'] = 'relatorios/rel_orcamento';
        $this->load->view('tema/topo', $this->data);
    }
*/
function rel_orcamento()
{
    if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rOrcamento')) {
        $this->session->set_flashdata('error', 'Você não tem permissão para ver relatorio de orçamento.');
        redirect(base_url());
    }
    $this->load->library('table');
    $this->load->library('pagination');
    $this->load->model('orcamentos_model');
    $this->load->model('almoxarifado_model');
    $this->load->model('os_model');
    $this->load->model('relatorios_model');

    $idUser = $this->session->userdata('idUsuarios');
    $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);

    $this->data['dados_emitente']        = $this->orcamentos_model->getEmitente();
    $this->data['dados_motivo']          = $this->orcamentos_model->getmotivo();
    $this->data['dados_vendedor']        = $this->orcamentos_model->getVendedor();
    $this->data['idVendedoresAux']       = $this->orcamentos_model->getVendedorAuxiliar();
    $this->data['todas_regioes']         = $this->relatorios_model->getTodasRegioes();
    $this->data['regiao']                = $this->relatorios_model->regiao();
    $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
    $this->data['dados_statusos']        = $this->orcamentos_model->getStatusOs();
    $this->data['dados_gruposervico']    = $this->orcamentos_model->getGrupoServico();
    $this->data['dados_natoperacao']     = $this->orcamentos_model->getNatOperacao();

    $petrolina = false;
    $uberlandia = false;
    if (count($getUserEmpresa) > 0) {
        foreach ($getUserEmpresa as $r) {
            if ($r->id == 1 || $r->id == 3) { $uberlandia = true; }
            if ($r->id == 2) { $petrolina = true; }
        }
        if ($uberlandia == true && $petrolina == true) {
            $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
        } else if ($uberlandia == true) {
            $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
        } else if ($petrolina == true) {
            $this->data['dados_clientes'] = $this->orcamentos_model->getCliente2();
        }
    } else {
        $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
    }
    $this->data['status_orcamento'] = $this->orcamentos_model->getCliente('');

    $config['base_url'] = base_url() . 'index.php/relatorios/rel_orcamento/';
    $cod_orc        = (int)$this->input->get('idOrcamentos');
    $referencia     = $this->db->escape_str($this->input->get('referencia'));
    $num_pedido     = $this->db->escape_str($this->input->get('num_pedido'));
    $num_nf         = $this->db->escape_str($this->input->get('num_nf'));
    $regiao         = $this->input->get('regiao');
    $idstatusOs     = $this->input->get('idstatusOs'); 
    $clientes_id    = $this->input->get('clientes_id');
    $idNatOperacao  = $this->input->get('idNatOperacao');
    $idGrupoServico = $this->input->get('idGrupoServico');
    $idProdutos     = $this->input->get('idProdutos');

    // ==================== STATUS ORÇAMENTO (ROBUSTO) ====================
    // Aceita quando vem como string única (ex.: 15) ou array (ex.: [11,15])
    $rawStatus = $this->input->get('idstatusOrcamento');
    if ($rawStatus === null) {
        $rawStatus = $this->input->get('idstatusOrcamento[]'); // fallback se o form usar "[]"
    }
    $idsStatus = array_values(array_unique(array_filter(array_map('intval', (array)$rawStatus))));

    // Regra já usada por você: se 11 está marcado, inclui 3 e 13
    if (in_array(11, $idsStatus, true)) {
        $idsStatus = array_values(array_unique(array_merge($idsStatus, [3, 13])));
    }
    // Monta IN (...) para passar ao model
    $query_idstatusOrcamento = $idsStatus ? '(' . implode(',', $idsStatus) . ')' : '';
    // ===================================================================

    $querydatacadastro = "";
    $dataInicialcad = $this->input->get('dataInicialcad');
    $dataFinalcad   = $this->input->get('dataFinalcad');

    if (empty($dataInicialcad)) {
        $date = new DateTime();
        $interval = new DateInterval('P3M');
        $dataInicialcad = $date->sub($interval)->format('d/m/Y');
        $dataFinalcad = new DateTime();
        $dataFinalcad = $dataFinalcad->format('d/m/Y');

        $data_entrega['data_ini']   = $dataInicialcad;
        $data_entrega['data_final'] = $dataFinalcad;
        $this->data['data_entrega'] = $data_entrega;
    } else {
        $this->data['data_entrega'] = null;
    }
    if (!empty($dataInicialcad) && !empty($dataFinalcad)) {
        $dataInicialcad2 = $this->_convertAndValidateDate($dataInicialcad);
        $dataFinalcad2   = $this->_convertAndValidateDate($dataFinalcad);
        if ($dataInicialcad2 && $dataFinalcad2) {
            $querydatacadastro = " and orcamento.data_abertura BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
        }
    }

    $status_orc = $this->input->get('status_orc');

    $query_statusorc = "";
    if (!empty($status_orc)) {
        $_so_safe = implode(',', array_filter(array_map('intval', (array)$status_orc)));
        if (!empty($_so_safe)) $query_statusorc = "(".$_so_safe.")";
    }

    $query_clientes  = "";
    $query_clientes3 = '';
    if (!empty($clientes_id)) {
        $_cli_safe = implode(',', array_filter(array_map('intval', (array)$clientes_id)));
        if (!empty($_cli_safe)) $query_clientes = "(".$_cli_safe.")";
    } else {
        if ($uberlandia == true && $petrolina == true) {
            $query_clientes3 = '';
        } else if ($petrolina == true) {
            $query_clientes3 = " and clientes.idClientes in(706,702,711,528,552,540,519,543,581,684,635,517,580,575,532,516,10,551,1005)";
        } else {
            $query_clientes3 = '';
        }
    }

    // Vendedor (usando $idsStatus já normalizado com intval acima)
    $vendedor = $this->input->get('idVendedores');
    $query_vendedor = "";
    if (!empty($vendedor)) {
        $_vend_safe2 = implode(',', array_filter(array_map('intval', (array)$vendedor)));
        if (!empty($_vend_safe2)) $query_vendedor = "(".$_vend_safe2.")";
    }

    $idstatusOs_filter = $this->input->get('idstatusOs');
    $query_idstatusOs = "";
    if (!empty($idstatusOs_filter)) {
        $_sos_safe = implode(',', array_filter(array_map('intval', (array)$idstatusOs_filter)));
        if (!empty($_sos_safe)) $query_idstatusOs = "(".$_sos_safe.")";
    }

    $query_idGrupoServico = "";
    if (!empty($idGrupoServico)) {
        $_gs_safe = implode(',', array_filter(array_map('intval', (array)$idGrupoServico)));
        if (!empty($_gs_safe)) $query_idGrupoServico = "(".$_gs_safe.")";
    }

    $query_idNatOperacao = "";
    if (!empty($idNatOperacao)) {
        $_no_safe = implode(',', array_filter(array_map('intval', (array)$idNatOperacao)));
        if (!empty($_no_safe)) $query_idNatOperacao = "(".$_no_safe.")";
    }

    // Vendedor (segunda construção mantida por compatibilidade — sanitizada)
    $vendedor = $this->input->get('idVendedores');
    $query_vendedor = "";
    if (!empty($vendedor)) {
        $_vend_safe3 = implode(',', array_filter(array_map('intval', (array)$vendedor)));
        if (!empty($_vend_safe3)) $query_vendedor = "(".$_vend_safe3.")";
    }

    $idVendedorAuxiliar = $this->input->get('idVendedoresAux');
    $query_vendedorAuxiliar = "";
    if (!empty($idVendedorAuxiliar)) {
        $_vaux_safe = implode(',', array_filter(array_map('intval', (array)$idVendedorAuxiliar)));
        if (!empty($_vaux_safe)) $query_vendedorAuxiliar = "(".$_vaux_safe.")";
    }

    // >>>> monta o IN dos status orcamento a partir do $idsStatus normalizado (já sanitizado com intval)
    $query_idstatusOrcamento = "";
    if (!empty($idsStatus)) {
        $query_idstatusOrcamento = '(' . implode(',', $idsStatus) . ')';
    }

    if (!empty($regiao) || !empty($idVendedorAuxiliar) || !empty($cod_orc) || !empty($referencia) ||  !empty($num_pedido) || !empty($num_nf)  || !empty($querydatacadastro) || !empty($query_statusorc) || !empty($num_pedido) || !empty($num_nf)  || !empty($query_clientes) || !empty($query_clientes) || !empty($query_idGrupoServico) || !empty($query_idNatOperacao) || !empty($query_idstatusOrcamento) || !empty ($query_idstatusOs) ||!empty($idProdutos) || !empty($query_clientes3) || !empty($query_vendedor) || !empty($query_vendedorAuxiliar)) {
        $this->data['results'] = $this->relatorios_model->getWhereLikeos2orc(
            $regiao,
            $idVendedorAuxiliar,
            $cod_orc,
            $referencia,
            $num_pedido,
            $num_nf,
            $querydatacadastro,
            $query_statusorc,
            $query_clientes,
            $query_idGrupoServico,
            $query_idNatOperacao,
            $query_idstatusOrcamento,
            $query_idstatusOs,
            $idProdutos,
            $query_clientes3,
            $query_vendedor,
            $query_vendedorAuxiliar
        );
    } else {
        $this->data['results'] = $this->relatorios_model->getAllOrcamentos();
    }

    $this->data['todas_regioes'] = $this->relatorios_model->getTodasRegioes();
    $this->data['regiao']        = $this->relatorios_model->regiao();
    $this->data['vendedores']    = $this->Relatorios_model->vendedoresRapid();
    $this->data['idVendedores']  = $this->Relatorios_model->vendedoresAuxRapid();
    $this->data['view']          = 'relatorios/rel_orcamento';
    $this->load->view('tema/topo', $this->data);
}


	function rel_orcamento_itens(){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOrcamento')){
           $this->session->set_flashdata('error','Você não tem permissão para ver relatorio de orçamento.');
           redirect(base_url());
        }
		
		
		$this->load->library('table');
		$this->load->library('pagination');
		$this->load->model('orcamentos_model');
		$this->load->model('almoxarifado_model');
		$this->load->model('os_model');
		$this->load->model('relatorios_model');

		$idUser = $this->session->userdata('idUsuarios');
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
             
		$this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
		$this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
	
		$this->data['dados_vendedor']= $this->orcamentos_model->getVendedor();
		//$this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
		$this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
		$this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
		$this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();
		 
		 /* $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
  		$this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
		 $this->data['status_os']= $this->os_model->getStatusOs();*/
		 $petrolina = false;
		 $uberlandia = false;
		 if(count($getUserEmpresa)>0){
			foreach($getUserEmpresa as $r){
				if($r->id == 1 || $r->id == 3){
					$uberlandia	= true;
				}
				if($r->id == 2){
					$petrolina = true;
				}
			}
			if($uberlandia == true && $petrolina == true){
				$this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
			}else if($uberlandia == true){
				//$this->data['dados_clientes'] = $this->orcamentos_model->getCliente3();
				$this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
			}else if($petrolina == true){
				$this->data['dados_clientes'] = $this->orcamentos_model->getCliente2();
			}
		 }else{
			$this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
		 }		 
		 $this->data['status_orcamento'] = $this->orcamentos_model->getCliente('');
		
		 
		 
         $config['base_url'] = base_url().'index.php/relatorios/rel_orcamento_itens/';
            
          // $idProdutos = $this->input->post('idProdutos');
         //$idOs = $this->input->post('idOs');
         $cod_orc = (int)$this->input->post('idOrcamentos');
         $referencia = $this->db->escape_str($this->input->post('referencia'));
         $num_pedido = $this->db->escape_str($this->input->post('num_pedido'));
         $num_nf = $this->db->escape_str($this->input->post('num_nf'));
        
             
         
		$clientes_id  = $this->input->post('clientes_id');
		$idstatusOrcamento = $this->input->post('idstatusOrcamento');
		$idNatOperacao = $this->input->post('idNatOperacao');
		$idGrupoServico = $this->input->post('idGrupoServico');
        
		
		

		$querydatacadastro = "";
		
		$dataInicialcad = $this->input->post('dataInicialcad');
		$dataFinalcad = $this->input->post('dataFinalcad');

		if(empty($dataInicialcad)){

            $date = new DateTime(); 

            $interval = new DateInterval('P3M');
            $dataInicialcad = $date->sub($interval)->format('d/m/Y');

            $dataFinalcad = new DateTime();
            $dataFinalcad = $dataFinalcad->format('d/m/Y');

            $data_entrega['data_ini']   = $dataInicialcad;
            $data_entrega['data_final'] = $dataFinalcad;
			$this->data['data_entrega']= $data_entrega;
        }else{
			$this->data['data_entrega']= null;
		}
		if(!empty($dataInicialcad) && !empty($dataFinalcad))
		{
			$dataInicialcad2 = $this->_convertAndValidateDate($dataInicialcad);
			$dataFinalcad2   = $this->_convertAndValidateDate($dataFinalcad);
			if($dataInicialcad2 && $dataFinalcad2){
				$querydatacadastro = " and orcamento.data_abertura BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
			}
		}

        //$idStatusOs = $this->input->post('idStatusOs');
		// $unid_execucao = $this->input->post('unid_execucao');
        //$unid_faturamento = $this->input->post('unid_faturamento');
         $status_orc = $this->input->post('status_orc');
        
		$query_statusorc = "";
		if(!empty($status_orc)){
			$_so2_safe = implode(',', array_filter(array_map('intval', (array)$status_orc)));
			if(!empty($_so2_safe)) $query_statusorc = "(".$_so2_safe.")";
		}
		$query_clientes = "";

		$query_clientes3 = '';
		if(!empty($clientes_id)){
			$_cli2_safe = implode(',', array_filter(array_map('intval', (array)$clientes_id)));
			if(!empty($_cli2_safe)) $query_clientes3 = " and clientes.idClientes in (".$_cli2_safe.")";
		}else{
			if($uberlandia==true && $petrolina == true){
				$query_clientes3 = '';
			}else{
				if($petrolina == true){
					$query_clientes3 = " and clientes.idClientes in(706,702,711,528,552,540,519,543,581,684,635,517,580,575,532,516,10,551,1005)";
				}else{
					$query_clientes3 = '';
				}
			}
		}

		$query_idstatusOrcamento = "";
		if(!empty($idstatusOrcamento)){
			$_soo_safe = implode(',', array_filter(array_map('intval', (array)$idstatusOrcamento)));
			if(!empty($_soo_safe)) $query_idstatusOrcamento = "(".$_soo_safe.")";
		}

		$query_idGrupoServico = "";
		if(!empty($idGrupoServico)){
			$_gs2_safe = implode(',', array_filter(array_map('intval', (array)$idGrupoServico)));
			if(!empty($_gs2_safe)) $query_idGrupoServico = "(".$_gs2_safe.")";
		}

		$query_idNatOperacao = "";
		if(!empty($idNatOperacao)){
			$_no2_safe = implode(',', array_filter(array_map('intval', (array)$idNatOperacao)));
			if(!empty($_no2_safe)) $query_idNatOperacao = "(".$_no2_safe.")";
		}
		$idProdutos = $this->input->post('idProdutos');

		$vendedor = $this->input->post('idVendedores');
		$query_vendedor = "";
		if(!empty($vendedor)){
			$_vend4_safe = implode(',', array_filter(array_map('intval', (array)$vendedor)));
			if(!empty($_vend4_safe)) $query_vendedor = " and orcamento.idVendedor IN(".$_vend4_safe.")";
		}
		
   
	
		 if (!empty($cod_orc) || !empty($referencia) ||  !empty($num_pedido) || !empty($num_nf)  || !empty($querydatacadastro) || !empty($query_statusorc) || !empty($num_pedido) || !empty($num_nf)  || !empty($query_clientes) || !empty($query_clientes) || !empty($query_idGrupoServico) || !empty($query_idNatOperacao) || !empty($query_idstatusOrcamento) || !empty($idProdutos) || !empty($query_clientes3) || !empty($query_vendedor)) { 
            
            $this->data['results'] = $this->relatorios_model->getOrcamento_item( $cod_orc,$referencia,$num_pedido,$num_nf ,$querydatacadastro,$query_statusorc,$query_clientes,$query_idGrupoServico,$query_idNatOperacao,$query_idstatusOrcamento,$idProdutos,$query_clientes3,$query_vendedor);
			
			

             //$config['total_rows'] = $this->relatorios_model->numrowsWhereLikeos2($cod_orc,$referencia,$num_pedido,$num_nf ,$querydatacadastro,$query_statusorc,$query_clientes,$query_idGrupoServico,$query_idNatOperacao,$query_idstatusOrcamento,$idProdutos);
			 
			 //$this->data['result_status'] = $this->relatorios_model->getWhereLikeos_status($cod_orc,$referencia,$num_pedido,$num_nf ,$querydatacadastro,$query_statusorc,$query_clientes,$query_idGrupoServico,$query_idNatOperacao,$query_idstatusOrcamento,$idProdutos);
			 
			 /*
             $config['per_page'] = 200000;
             $config['next_link'] = 'Próxima';
             $config['prev_link'] = 'Anterior';
             $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
             $config['full_tag_close'] = '</ul></div>';
             $config['num_tag_open'] = '<li>';
             $config['num_tag_close'] = '</li>';
             $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
             $config['cur_tag_close'] = '</b></a></li>';
             $config['prev_tag_open'] = '<li>';
             $config['prev_tag_close'] = '</li>';
             $config['next_tag_open'] = '<li>';
             $config['next_tag_close'] = '</li>';
             $config['first_link'] = 'Primeira';
             $config['last_link'] = 'Última';
             $config['first_tag_open'] = '<li>';
             $config['first_tag_close'] = '</li>';
             $config['last_tag_open'] = '<li>';
             $config['last_tag_close'] = '</li>';
             
             $this->pagination->initialize($config); 
 
            */
        
            
         } else {

			/*
            $config['total_rows'] = $this->orcamentos_model->count('orcamento');
             $config['per_page'] = 200000;
             $config['next_link'] = 'Próxima';
             $config['prev_link'] = 'Anterior';
             $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
             $config['full_tag_close'] = '</ul></div>';
             $config['num_tag_open'] = '<li>';
             $config['num_tag_close'] = '</li>';
             $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
             $config['cur_tag_close'] = '</b></a></li>';
             $config['prev_tag_open'] = '<li>';
             $config['prev_tag_close'] = '</li>';
             $config['next_tag_open'] = '<li>';
             $config['next_tag_close'] = '</li>';
             $config['first_link'] = 'Primeira';
             $config['last_link'] = 'Última';
             $config['first_tag_open'] = '<li>';
             $config['first_tag_close'] = '</li>';
             $config['last_tag_open'] = '<li>';
             $config['last_tag_close'] = '</li>';
            
           
             $this->pagination->initialize($config); */
           

  			$this->data['results'] = $this->relatorios_model->getOrcamento_item();

		 
		   	//$this->data['result_status'] = $this->relatorios_model->getWhereLikeos_status($this->uri->segment(3),'','','','','','','','');
   
         }
        
 
        
       /* $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
         $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
         $this->data['dados_clientes'] = $this->orcamentos_model->getCliente();
         $this->data['dados_vendedor']= $this->orcamentos_model->getVendedor();
         $this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
         $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
         $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
         $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();
        */
     	

		/*$this->data['results'] = $this->os_model->get('os','idOs,dataInicial,dataFinal,garantia,descricaoProduto,defeito,status,observacoes,laudoTecnico','',$config['per_page'],$this->uri->segment(3));*/
       
	    $this->data['view'] = 'relatorios/rel_orcamento_itens';
       	$this->load->view('tema/topo',$this->data);
       //$this->load->view('tema/rodape');
		
		
		
	}
	function ordemdecompra(){
		  if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOrdemcompra')){
           $this->session->set_flashdata('error','Você não tem permissão para ver relatorio de compra.');
           redirect(base_url());
        }
         $this->load->library('table');
         $this->load->library('pagination');
		 $this->load->model('orcamentos_model');
         $this->load->model('os_model');    
         $this->load->model('cotacao_model');    
         $this->load->model('pedidocompra_model');    
         $this->load->model('relatorios_model');    
         $this->load->model('fornecedores_model');    
         
		  $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
  		$this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
		 $this->data['status_os']= $this->os_model->getStatusOs();
		 $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
		 $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
		 $this->data['dados_fornecedor'] = $this->fornecedores_model->getFornecedor('');
		 
		 $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
        // $config['base_url'] = base_url().'index.php/os/carteiraservico/';
            
         
         $idOs = (int)$this->input->post('idOs');
         //$cod_orc = $this->input->post('idOrcamentos');
         $notafiscal = $this->db->escape_str($this->input->post('notafiscal'));
         //$clientes_id  = $this->input->post('clientes_id');
         $idFornecedores  = $this->input->post('idFornecedores');
         $os_1a13  = $this->input->post('os_1a13');
        // $idProdutos = $this->input->post('idProdutos');
		 
		$querydatacadastro = "";
		
		
		$dataInicialcad = $this->input->post('dataSolInicial');
		$dataFinalcad = $this->input->post('dataSolFinal');
		if(!empty($dataInicialcad) && !empty($dataFinalcad))
		{
			$dataInicialcad2 = $this->_convertAndValidateDate($dataInicialcad);
			$dataFinalcad2   = $this->_convertAndValidateDate($dataFinalcad);
			if($dataInicialcad2 && $dataFinalcad2){
				$querydatacadastro = " and distribuir_os.data_cadastro BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
			}
		}
		$querydatacompra = "";

		$dataInicialcad = $this->input->post('dataComInicial');
		$dataFinalcad = $this->input->post('dataComFinal');
		if(!empty($dataInicialcad) && !empty($dataFinalcad))
		{
			$dataInicialcad2 = $this->_convertAndValidateDate($dataInicialcad);
			$dataFinalcad2   = $this->_convertAndValidateDate($dataFinalcad);
			if($dataInicialcad2 && $dataFinalcad2){
				$querydatacompra = " and pedido_comprasitens.data_cadastro BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
			}
		}

		
		$idPedidoCompra = (int)$this->input->post('idPedidoCompra');
		
        
        $idPedidoCotacao = (int)$this->input->post('idPedidoCotacao');
         
		
		 
		
		$queryos1a13 = "";
		if(!empty($os_1a13))
		{
			if($os_1a13 == 'nao')
			{
				$queryos1a13 = "and distribuir_os.idOs not in(1,2,3,4,5,6,7,8,9,10,11,12,13)";
			}
			else
			{
				$queryos1a13 = "and distribuir_os.idOs > 0";
			}
		}
		
		$query_fornecedor = "";
		if(!empty($idFornecedores)){
			$_forn_safe = implode(',', array_filter(array_map('intval', (array)$idFornecedores)));
			if(!empty($_forn_safe)) $query_fornecedor = $_forn_safe;
		}

		$query_statuscompra = "";
		$idStatuscompras = $this->input->post('idStatuscompras');
		if(!empty($idStatuscompras)){
			$_sc_safe = implode(',', array_filter(array_map('intval', (array)$idStatuscompras)));
			if(!empty($_sc_safe)) $query_statuscompra = "(".$_sc_safe.")";
		}

		$query_idgrupo = "";
		$idgrupo = $this->input->post('idgrupo');
		if(!empty($idgrupo)){
			$_ig_safe = implode(',', array_filter(array_map('intval', (array)$idgrupo)));
			if(!empty($_ig_safe)) $query_idgrupo = "(".$_ig_safe.")";
		}
		
		$pn = $this->db->escape_like_str(str_replace("","",$this->input->post("pn")));

		$descricao = $this->db->escape_like_str($this->input->post("descricao"));
	
		 
		if (!empty($idOs) || !empty($idPedidoCotacao) || !empty($query_statuscompra) || !empty($idPedidoCompra) || !empty($query_fornecedor) || !empty($notafiscal) || !empty($query_idgrupo) || !empty($queryos1a13)|| !empty($pn)|| !empty($descricao)) {
            
			$this->data['results'] = $this->relatorios_model->getWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$query_fornecedor,$notafiscal,$query_idgrupo,$queryos1a13,$querydatacadastro,$querydatacompra,$pn,$descricao);
			
			$config['total_rows'] = $this->relatorios_model->numrowsWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$query_fornecedor,$notafiscal,$query_idgrupo,$queryos1a13,$querydatacadastro,$querydatacompra);
			
			$config['per_page'] = 40000;
			$config['next_link'] = 'Próxima';
			$config['prev_link'] = 'Anterior';
			$config['full_tag_open'] = '<div class="pagination alternate"><ul>';
			$config['full_tag_close'] = '</ul></div>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
			$config['cur_tag_close'] = '</b></a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = 'Primeira';
			$config['last_link'] = 'Última';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			
			$this->pagination->initialize($config); 
            
        } else {
			$config['total_rows'] = count( $this->relatorios_model->getdistribuidorcount('distribuir_os','*','distribuir_os.idOs not in(1,2,3,4,5,6,7,8,9,10,11,12,13) and distribuir_os.idStatuscompras in(1,2,3,10,4)'));
			
			$config['per_page'] = 2000;
			$config['next_link'] = 'Próxima';
			$config['prev_link'] = 'Anterior';
			$config['full_tag_open'] = '<div class="pagination alternate"><ul>';
			$config['full_tag_close'] = '</ul></div>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
			$config['cur_tag_close'] = '</b></a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = 'Primeira';
			$config['last_link'] = 'Última';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
		
			$this->pagination->initialize($config); 
            $this->data['results'] = $this->relatorios_model->getdistribuidor('distribuir_os','*','distribuir_os.idOs not in(1,2,3,4,5,6,7,8,9,10,11,12,13) and distribuir_os.idStatuscompras in(1,2,3,10,4)',$config['per_page'],$this->uri->segment(3));
					 
        }
        
 
        
       
	    $this->data['view'] = 'relatorios/rel_carteiracompra';
       	$this->load->view('tema/topo',$this->data);
       
		
    }
	

    public function produtos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_produtos';
       	$this->load->view('tema/topo',$this->data);

    }

    public function clientesCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }

        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');

        $data['clientes'] = $this->Relatorios_model->clientesCustom($dataInicial,$dataFinal);

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirClientes', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), TRUE);
    
    }

    public function clientesRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }

        $data['clientes'] = $this->Relatorios_model->clientesRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirClientes', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), TRUE);
    }

    public function produtosRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $data['produtos'] = $this->Relatorios_model->produtosRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirProdutos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
    }

    public function produtosRapidMin(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $data['produtos'] = $this->Relatorios_model->produtosRapidMin();

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
        
    }

    public function produtosCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $estoqueInicial = $this->input->get('estoqueInicial');
        $estoqueFinal = $this->input->get('estoqueFinal');

        $data['produtos'] = $this->Relatorios_model->produtosCustom($precoInicial,$precoFinal,$estoqueInicial,$estoqueFinal);

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
    }

    public function servicos(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_servicos';
       	$this->load->view('tema/topo',$this->data);

    }

    public function servicosCustom(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $data['servicos'] = $this->Relatorios_model->servicosCustom($precoInicial,$precoFinal);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirServicos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), TRUE);
    }

    public function servicosRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }

        $data['servicos'] = $this->Relatorios_model->servicosRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirServicos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), TRUE);
    }

    public function os(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_os';
       	$this->load->view('tema/topo',$this->data);
    }

    public function osRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }

        $data['os'] = $this->Relatorios_model->osRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }

    public function osCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }
        
        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $cliente = $this->input->get('cliente');
        $responsavel = $this->input->get('responsavel');
        $status = $this->input->get('status');
        $data['os'] = $this->Relatorios_model->osCustom($dataInicial,$dataFinal,$cliente,$responsavel,$status);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }


    public function financeiro(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }

        $this->data['view'] = 'relatorios/rel_financeiro';
        $this->load->view('tema/topo',$this->data);
    
    }


    public function financeiroRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }

        $data['lancamentos'] = $this->Relatorios_model->financeiroRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }

    public function financeiroCustom(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }

        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $tipo = $this->input->get('tipo');
        $situacao = $this->input->get('situacao');

        $data['lancamentos'] = $this->Relatorios_model->financeiroCustom($dataInicial,$dataFinal,$tipo,$situacao);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data, true);
        pdf_create($html, 'relatorio_financeiro' . date('d/m/y'), TRUE);
    }



    public function vendas(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }

        $this->data['view'] = 'relatorios/rel_vendas';
        $this->load->view('tema/topo',$this->data);
    }

    public function vendasRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $data['vendas'] = $this->Relatorios_model->vendasRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'relatorio_vendas' . date('d/m/y'), TRUE);
    }

    public function vendasCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $cliente = $this->input->get('cliente');
        $responsavel = $this->input->get('responsavel');

        $data['vendas'] = $this->Relatorios_model->vendasCustom($dataInicial,$dataFinal,$cliente,$responsavel);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'relatorio_vendas' . date('d/m/y'), TRUE);
    }
public function relcompras()
{
    $where = '';
    
    $temFiltrosTexto = !empty($this->input->post('listOs')) || !empty($this->input->post('listPc'));
    $temAgrupamento = !empty($this->input->post('agrupar'));

    // Bloco padrão (Sem filtros)
    if (empty($this->uri->segment(3)) && !$temFiltrosTexto && !$temAgrupamento) {
        $select = "distribuir_os.cod_fornecedor as 'Cód. Fornecedor OS', fornecedores.nomeFornecedor as 'Fornecedor',";
        $groupby = "group by fornecedores.idFornecedores, distribuir_os.cod_fornecedor, fornecedores.nomeFornecedor, pedido_compras.idPedidoCompra, distribuir_os.idDistribuir";
        
        $padraoInicial = date('Y-m-01');
        $padraoFinal   = date('Y-m-d');
        $this->data['dataInicial'] = $padraoInicial;
        $this->data['dataFinal']   = $padraoFinal;
        
        $where = " AND date(distribuir_os.data_cadastro) BETWEEN '{$padraoInicial}' AND '{$padraoFinal}'";
        
    } else {
        $select = "";
        $groupby = "";

        // 1. Filtro de Data
        if (!$temFiltrosTexto) {
            if (!empty($this->input->post('dataInicial')) && !empty($this->input->post('dataFinal'))) {
                $this->data['dataInicial'] = $this->input->post('dataInicial');
                $this->data['dataFinal'] = $this->input->post('dataFinal');
                
                $dataInicial = DateTime::createFromFormat('Y-m-d', $this->input->post('dataInicial'));
                $dataFinal = DateTime::createFromFormat('Y-m-d', $this->input->post('dataFinal'));

                if ($dataInicial && $dataFinal) {
                     $where .= " AND (
                        date(distribuir_os.data_cadastro) BETWEEN '" . $dataInicial->format('Y-m-d') . "' AND '" . $dataFinal->format('Y-m-d') . "'
                        OR 
                        date(pedido_compras.data_cadastro) BETWEEN '" . $dataInicial->format('Y-m-d') . "' AND '" . $dataFinal->format('Y-m-d') . "'
                     )";
                }
            }
        } else {
            $this->data['dataInicial'] = $this->input->post('dataInicial');
            $this->data['dataFinal'] = $this->input->post('dataFinal');
        }

        // 2. Filtros de Texto
        if (!empty($this->input->post('listOs'))) { 
            $this->data['listOs'] = $this->input->post('listOs'); 
            $_listOs_safe2 = implode(',', array_filter(array_map('intval', (array)$this->input->post('listOs'))));
            if (!empty($_listOs_safe2)) { $where .= " and os.idOs in (" . $_listOs_safe2 . ")"; }
            if(strpos($select, 'os.idOs') === false) { $select .= "os.idOs as 'OS',"; }
            if($groupby == "") { $groupby = "group by os.idOs"; } else { $groupby .= ", os.idOs"; }
        }

        if (!empty($this->input->post('listPc'))) { 
            $this->data['listPc'] = $this->input->post('listPc'); 
            $_listPc_safe = implode(',', array_filter(array_map('intval', (array)$this->input->post('listPc'))));
            if (!empty($_listPc_safe)) { $where .= " and pedido_compras.idPedidoCompra in (" . $_listPc_safe . ")"; }
            if(strpos($select, 'pedido_compras.idPedidoCompra') === false) { $select .= "pedido_compras.idPedidoCompra as 'Ordem de Compra',"; }
             if($groupby == "") { $groupby = "group by pedido_compras.idPedidoCompra"; } else { $groupby .= ", pedido_compras.idPedidoCompra"; }
        }
        
        // 3. Checkboxes
        if (!empty($this->input->post('agrupar'))) {
            $primeiroGroupBy = ($groupby == ""); 
            $this->data['agrupar'] = $this->input->post('agrupar');
            
            foreach ($this->input->post('agrupar') as $r) {
                
                if ($r == 'statuscompra') {
                    $select .= "statuscompras.nomeStatus as 'Status da Compra',";
                    // Garante busca no histórico
                    $where .= " AND (historico_alteracoes.alt LIKE '%\"idStatuscompras\"%' OR historico_alteracoes.tipo = 'INSERT' OR historico_alteracoes.idHistAlteracao IS NULL)";
                    
                    // [CORREÇÃO: REMOVIDA A LISTA HARDCODED DE USUÁRIOS]
                    // Isso permite que o relatório mostre TODAS as compras da OS, independente de quem fez.
                    // O filtro específico de usuário (abaixo) só será aplicado se o checkbox for marcado.

                    if (!empty($this->input->post('idUsuarios'))) {
                        $this->data['idUsuarios'] = $this->input->post('idUsuarios');
                        $usuariosSelecionados = implode(',', array_filter(array_map('intval', (array)$this->input->post('idUsuarios'))));
                        if (!empty($usuariosSelecionados)) {
                            $where .= " AND COALESCE(historico_alteracoes.idUser, distribuir_os.usuario_cadastro) IN ($usuariosSelecionados)";
                        }
                    }

                    if ($primeiroGroupBy) {
                        $groupby = "group by distribuir_os.idDistribuir, historico_alteracoes.data_alteracao";
                        $primeiroGroupBy = false;
                    } else {
                        $groupby .= ", distribuir_os.idDistribuir, historico_alteracoes.data_alteracao";
                    }

                    if (!empty($this->input->post('idStatusCompras'))) {
                        $this->data['idStatusCompras'] = $this->input->post('idStatusCompras');
                        $statusIds = implode(',', array_filter(array_map('intval', (array)$this->input->post('idStatusCompras'))));
                        if (!empty($statusIds)) {
                            $whereLike = [];
                            foreach(array_filter(array_map('intval', (array)$this->input->post('idStatusCompras'))) as $sid) {
                                $whereLike[] = "historico_alteracoes.alt LIKE '%\"idStatuscompras\":\"$sid\"%'";
                            }
                            $whereLike[] = "distribuir_os.idStatuscompras IN ($statusIds)";
                            if(in_array(1, array_map('intval', (array)$this->input->post('idStatusCompras')))){ $whereLike[] = "historico_alteracoes.tipo = 'INSERT'"; }
                            if(!empty($whereLike)){ $where .= " AND (" . implode(' OR ', $whereLike) . ")"; }
                        }
                    }
                }

                // ... (Demais filtros mantidos) ...
                if ($r == 'fornecedores') {
                    $select .= "distribuir_os.cod_fornecedor as 'Cód. Fornecedor OS', fornecedores.nomeFornecedor as 'Fornecedor',";
                    if ($primeiroGroupBy) { $groupby = "group by fornecedores.idFornecedores"; $primeiroGroupBy = false; } else { $groupby .= ", fornecedores.idFornecedores"; }
                    if (!empty($this->input->post('idFornecedores'))) { $this->data['idFornecedores'] = $this->input->post('idFornecedores'); $fornecedores = implode(',', array_filter(array_map('intval', (array)$this->input->post('idFornecedores')))); if (!empty($fornecedores)) { $where .= " and fornecedores.idFornecedores in ($fornecedores)"; } }
                }
                if ($r == 'clientes') {
                    $select .= "clientes.nomeCliente as 'Cliente',";
                    if ($primeiroGroupBy) { $groupby = "group by clientes.idClientes"; $primeiroGroupBy = false; } else { $groupby .= ", clientes.idClientes"; }
                    if (!empty($this->input->post('idClientes'))) { $this->data['idClientes'] = $this->input->post('idClientes'); $cliente = implode(',', array_filter(array_map('intval', (array)$this->input->post('idClientes')))); if (!empty($cliente)) { $where .= " and clientes.idClientes in ($cliente)"; } }
                }
                if ($r == 'categorias') {
                    $select .= "categoriaInsumos.descricaoCategoria as 'Categoria',";
                    if ($primeiroGroupBy) { $groupby = "group by categoriaInsumos.idCategoria"; $primeiroGroupBy = false; } else { $groupby .= ", categoriaInsumos.idCategoria"; }
                    if (!empty($this->input->post('idCategorias'))) { $this->data['idCategorias'] = $this->input->post('idCategorias'); $categoria = implode(',', array_filter(array_map('intval', (array)$this->input->post('idCategorias')))); if (!empty($categoria)) { $where .= " and categoriaInsumos.idCategoria in ($categoria)"; } }
                }
                if ($r == 'insumos') {
                    $select .= "insumos.descricaoInsumo as 'Insumo',";
                    if ($primeiroGroupBy) { $groupby = "group by insumos.idInsumos"; $primeiroGroupBy = false; } else { $groupby .= ", insumos.idInsumos"; }
                    if (!empty($this->input->post('idInsumos'))) { $this->data['idInsumos'] = $this->input->post('idInsumos'); $insumos = implode(',', array_filter(array_map('intval', (array)$this->input->post('idInsumos')))); if (!empty($insumos)) { $where .= " and insumos.idInsumos in ($insumos)"; } }
                }
                if ($r == 'quantidade') {
                    $select .= "sum(pedido_comprasitens.quantidade) as 'Qtde.',";
                }
                if ($r == 'grupoCompra') {
                    $select .= "status_grupo_compra.nomegrupo as 'Grupo de Compra',";
                    if ($primeiroGroupBy) { $groupby = "group by status_grupo_compra.idgrupo"; $primeiroGroupBy = false; } else { $groupby .= ", status_grupo_compra.idgrupo"; }
                    if (!empty($this->input->post('idGrupocompras'))) { $this->data['idGrupocompras'] = $this->input->post('idGrupocompras'); $grupo = implode(',', array_filter(array_map('intval', (array)$this->input->post('idGrupocompras')))); if (!empty($grupo)) { $where .= " and status_grupo_compra.idgrupo in ($grupo)"; } }
                }
                if ($r == 'unid_exec') {
                    $select .= "unidade_execucao.status_execucao as 'Unid. Exec.',";
                    if ($primeiroGroupBy) { $groupby = "group by unidade_execucao.id_unid_exec"; $primeiroGroupBy = false; } else { $groupby .= ", unidade_execucao.id_unid_exec"; }
                    if (!empty($this->input->post('id_unid_exec'))) { $this->data['id_unid_exec'] = $this->input->post('id_unid_exec'); $unidades = implode(',', array_filter(array_map('intval', (array)$this->input->post('id_unid_exec')))); if (!empty($unidades)) { $where .= " and unidade_execucao.id_unid_exec in ($unidades)"; } }
                }
                if ($r == 'status_execucao') {
                    $select .= "unidade_execucao.status_execucao as 'Status Execução',";
                    if ($primeiroGroupBy) { $groupby = "group by unidade_execucao.status_execucao"; $primeiroGroupBy = false; } else { $groupby .= ", unidade_execucao.status_execucao"; }
                    if (!empty($this->input->post('status_execucao'))) { $this->data['status_execucao'] = $this->input->post('status_execucao'); $status_lista = "'" . implode("','", array_map(function($s){ return addslashes($s); }, (array)$this->input->post('status_execucao'))) . "'"; if (!empty($status_lista) && $status_lista !== "''") { $where .= " and unidade_execucao.status_execucao in ($status_lista)"; } }
                }
                if ($r == 'status_os') {
                    $select .= "status_os.nomeStatusOs as 'Status OS',";
                    if ($primeiroGroupBy) { $groupby = "group by status_os.idStatusOs"; $primeiroGroupBy = false; } else { $groupby .= ", status_os.idStatusOs"; }
                    if (!empty($this->input->post('idStatusOs'))) { $this->data['idStatusOs'] = $this->input->post('idStatusOs'); $statusOs = implode(',', array_filter(array_map('intval', (array)$this->input->post('idStatusOs')))); if (!empty($statusOs)) { $where .= " and status_os.idStatusOs in ($statusOs)"; } }
                }
                if ($r == 'os' && strpos($select, 'os.idOs') === false) {
                    $select .= "os.idOs as 'O.S.',";
                    if ($primeiroGroupBy) { $groupby = "group by os.idOs"; $primeiroGroupBy = false; } else { $groupby .= ", os.idOs"; }
                }
                if ($r == 'pc' && strpos($select, 'pedido_compras.idPedidoCompra') === false) {
                    $select .= "pedido_compras.idPedidoCompra as 'Ordem de Compra',";
                    if ($primeiroGroupBy) { $groupby = "group by pedido_compras.idPedidoCompra"; $primeiroGroupBy = false; } else { $groupby .= ", pedido_compras.idPedidoCompra"; }
                }

                if ($r == 'usuarios') {
                    if (!in_array('statuscompra', $this->input->post('agrupar'))) {
                        $select .= "COALESCE(u_hist.nome, u_criador.nome) as 'Usuário Resp.',";
                        if ($primeiroGroupBy) { $groupby = "group by COALESCE(u_hist.idUsuarios, u_criador.idUsuarios), pedido_compras.idPedidoCompra"; $primeiroGroupBy = false; } else { $groupby .= ", COALESCE(u_hist.idUsuarios, u_criador.idUsuarios), pedido_compras.idPedidoCompra"; }
                        if (!empty($this->input->post('idUsuarios'))) {
                            $this->data['idUsuarios'] = $this->input->post('idUsuarios');
                            $usuariosIds = implode(',', $this->input->post('idUsuarios'));
                            if (!empty($usuariosIds)) { $where .= " and COALESCE(u_hist.idUsuarios, u_criador.idUsuarios) in ($usuariosIds)"; }
                        }
                    }
                }
            }

            if ($groupby != "" && !strpos($groupby, 'historico_alteracoes.data_alteracao') && !strpos($groupby, 'pedido_compras.idPedidoCompra')) {
                $groupby .= ", pedido_compras.idPedidoCompra"; 
            }
        } else {
             if ($groupby == "") {
                 $groupby = "group by pedido_compras.idPedidoCompra";
             }
        }
        
        if ($groupby != "" && !strpos($groupby, 'distribuir_os.idDistribuir')) {
            $groupby .= ", distribuir_os.idDistribuir";
        }
    }
    
    // Loads
    $this->data['grupocompra'] = $this->Relatorios_model->grupoCompraRapid();
    $this->data['insumos'] = $this->Relatorios_model->insumoRapid();
    $this->data['categorias'] = $this->Relatorios_model->categoriaRapid();
    $this->data['fornecedores'] = $this->Relatorios_model->fornecedoresRapid();
    $this->data['clientes'] = $this->Relatorios_model->clientesRapid();
    $this->data['statuscompras'] = $this->Relatorios_model->getStatusCompras(); 
    $this->data['unidades_execucao'] = $this->Relatorios_model->getUnidadesExecucao();
    $this->data['status_execucao_lista'] = $this->Relatorios_model->getStatusExecucao();
    $this->data['status_os_lista'] = $this->Relatorios_model->getStatusOs();
    $this->data['usuarios_lista'] = $this->Relatorios_model->getUsuarios();

    $raw_results = $this->Relatorios_model->relatorioComprasMelhorado($select, $groupby, $where);

    if (!empty($this->input->post('agrupar')) && in_array('statuscompra', $this->input->post('agrupar'))) {
        $clean_results = [];
        $seen_keys = [];
        
        $statusNomesPermitidos = [];
        if (!empty($this->input->post('idStatusCompras'))) {
            $allStats = $this->Relatorios_model->getStatusCompras();
            foreach($allStats as $st) {
                if (in_array($st->idStatuscompras, $this->input->post('idStatusCompras'))) { $statusNomesPermitidos[] = $st->nomeStatus; }
            }
            if (in_array('1', $this->input->post('idStatusCompras'))) { $statusNomesPermitidos[] = 'Compra Solicitada'; }
        }

        usort($raw_results, function($a, $b) { return strtotime($b->{'Data Alteração'}) - strtotime($a->{'Data Alteração'}); });
        
        foreach ($raw_results as $row) {
            if (!empty($statusNomesPermitidos) && !in_array($row->{'Status Histórico'}, $statusNomesPermitidos)) { continue; }
            $uniqueKey = $row->{'Nº OC'} . '_' . (isset($row->idDistribuir) ? $row->idDistribuir : '') . '_' . $row->{'Status Histórico'};
            if (!in_array($uniqueKey, $seen_keys)) {
                $seen_keys[] = $uniqueKey;
                $clean_results[] = $row;
            }
        }
        usort($clean_results, function($a, $b) {
            if ($a->{'Nº OC'} == $b->{'Nº OC'}) { return strtotime($a->{'Data Alteração'}) - strtotime($b->{'Data Alteração'}); }
            return $a->{'Nº OC'} - $b->{'Nº OC'};
        });
        $this->data['relatorio'] = $clean_results;
    } else {
        $this->data['relatorio'] = $raw_results;
    }

    $this->data['view'] = 'relatorios/rel_compras';
    $this->load->view('tema/topo', $this->data);
}
	
	public function relcomercial(){
		$where = '';
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOrcamento')){
			$this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
			redirect(base_url());
		 }
		 
	/*echo '<pre>';
    print_r($this->input->post());
    echo '</pre>';*/

		if(empty($this->uri->segment(3))){
			$select = "vendedores.nomeVendedor as 'Gerente',";
			//$where = " and os.idStatusOs != 44";
			$groupby = "group by vendedores.idVendedor";
		}else{
			$select = "";
			$groupby = "";
			if(!empty($this->input->post('dataOrcInicial')) && !empty($this->input->post('dataOrcFinal'))){
				$this->data['dataOrcInicial'] = $this->input->post('dataOrcInicial');
				$this->data['dataOrcFinal'] = $this->input->post('dataOrcFinal');
				$_dataOrcIni = $this->_convertAndValidateDate($this->input->post('dataOrcInicial'));
				$_dataOrcFim = $this->_convertAndValidateDate($this->input->post('dataOrcFinal'));
				if ($_dataOrcIni && $_dataOrcFim) {
					$where = $where." and date(orcamento.data_abertura) between '".$_dataOrcIni."' and '".$_dataOrcFim."' ";
				}
			}
			if(!empty($this->input->post('dataAberInicial')) && !empty($this->input->post('dataAberFinal'))){
				$this->data['dataAberInicial'] = $this->input->post('dataAberInicial');
				$this->data['dataAberFinal'] = $this->input->post('dataAberFinal');
				$_dataAberIni = $this->_convertAndValidateDate($this->input->post('dataAberInicial'));
				$_dataAberFim = $this->_convertAndValidateDate($this->input->post('dataAberFinal'));
				if ($_dataAberIni && $_dataAberFim) {
					$where = $where." and date(os.data_abertura) between '".$_dataAberIni."' and '".$_dataAberFim."' ";
				}
			}
			if(!empty($this->input->post('dataEntrInicial')) && !empty($this->input->post('dataEntrFinal'))){
				$this->data['dataEntrInicial'] = $this->input->post('dataEntrInicial');
				$this->data['dataEntrFinal'] = $this->input->post('dataEntrFinal');
				$_dataEntrIni = $this->_convertAndValidateDate($this->input->post('dataEntrInicial'));
				$_dataEntrFim = $this->_convertAndValidateDate($this->input->post('dataEntrFinal'));
				if ($_dataEntrIni && $_dataEntrFim) {
					$where = $where." and date(os.data_entrega) between '".$_dataEntrIni."' and '".$_dataEntrFim."' ";
				}
			}
			if(!empty($this->input->post('dataFatInicial')) && !empty($this->input->post('dataFatFinal'))){
				$this->data['dataFatInicial'] = $this->input->post('dataFatInicial');
				$this->data['dataFatFinal'] = $this->input->post('dataFatFinal');
				$_dataFatIni = $this->_convertAndValidateDate($this->input->post('dataFatInicial'));
				$_dataFatFim = $this->_convertAndValidateDate($this->input->post('dataFatFinal'));
				if ($_dataFatIni && $_dataFatFim) {
					$where = $where." and date(os.data_nf_faturamento) between '".$_dataFatIni."' and '".$_dataFatFim."' ";
				}
			}
			
			if(!empty($this->input->post('agrupar'))){
				$primeiroGroupBy = true;
				$this->data['agrupar'] = $this->input->post('agrupar');
				foreach($this->input->post('agrupar') as $r){
					if($r == 'vendedores'){
						$select = $select."vendedores.nomeVendedor as 'Gerentes',";
						if($primeiroGroupBy){
							$groupby = "group by vendedores.nomeVendedor";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", vendedores.idVendedor";
						}
						
						if(!empty($this->input->post('idVendedores'))){
							$this->data['idVendedores'] = $this->input->post('idVendedores');
							$vendedor = implode(',', array_filter(array_map('intval', (array)$this->input->post('idVendedores'))));
							if(!empty($vendedor)){
								$where = $where." and vendedores.idVendedor in ($vendedor)";
							}
						}
					}
			
					
if ($r == 'vendedoresAux') {
    // Adiciona tanto o ID quanto o Nome do Vendedor Auxiliar na seleção
    $select = $select."
        orcamento.idVendedorAuxiliar as 'Vendedor Auxiliar', 
        usuarios.nome as 'Nome Vendedor Auxiliar',";

    // Ajusta o agrupamento
    if ($primeiroGroupBy) {
        $groupby = "GROUP BY orcamento.idVendedorAuxiliar, usuarios.idUsuarios";
        $primeiroGroupBy = false;
    } else {
        $groupby = $groupby . ", orcamento.idVendedorAuxiliar, usuarios.idUsuarios";
    }

    // Filtro pelos vendedores auxiliares selecionados no formulário
    if (!empty($this->input->post('idVendedoresAux'))) {
        $this->data['idVendedoresAux'] = $this->input->post('idVendedoresAux');
        $VendedorAux = implode(',', array_filter(array_map('intval', (array)$this->input->post('idVendedoresAux'))));

        if (!empty($VendedorAux)) {
            // Filtro preciso para garantir correspondência correta entre Vendedor e Vendedor Auxiliar
            $where .= " AND orcamento.idVendedorAuxiliar IN ($VendedorAux)";
        }
    }

    // Filtro para garantir a correspondência correta entre Vendedor e Vendedor Auxiliar
   /* $where .= " AND (
        (orcamento.idVendedor = 1 AND orcamento.idVendedorAuxiliar IN (5,6,2,8)) 
        OR 
        (orcamento.idVendedor = 8 AND orcamento.idVendedorAuxiliar IN (7,8,9,10,3,16))
        OR 
        (orcamento.idVendedor = 5 AND orcamento.idVendedorAuxiliar IN (11,12,13,1,17))
        OR 
        (orcamento.idVendedor IS NULL AND vendedores.idVendedor = 8)
    )";*/
    $where .= " AND (
        (orcamento.idVendedor = 1 AND orcamento.idVendedorAuxiliar IN (2,5,6)) 
        OR 
        (orcamento.idVendedor = 8 AND orcamento.idVendedorAuxiliar IN (3,7,8,9,10,15,16))
        OR 
        (orcamento.idVendedor = 5 AND orcamento.idVendedorAuxiliar IN (1,11,12,13,14,17))
        OR 
        (orcamento.idVendedor = 2 AND orcamento.idVendedorAuxiliar IN (4,0))		
        OR 
        (orcamento.idVendedor IS NULL AND vendedores.idVendedor = 8)
    )";	
}
if ($r == 'regiao'){
    $select .= "orcamento.regiao as 'Regiao',";
    if ($primeiroGroupBy){
        $groupby = "group by orcamento.regiao";
        $primeiroGroupBy = false;
    } else {
        $groupby .= ", orcamento.regiao";
    }
    if (!empty($this->input->post('regiao'))){
        $this->data['regiao'] = $this->input->post('regiao');
        $regioes = implode(',', array_map(function($item) {
            return "'" . addslashes($item) . "'";
        }, (array)$this->input->post('regiao')));

        if (!empty($regioes)){
            $where .= " and orcamento.regiao in ($regioes)";
        }                           
    }                       
}

					
					if($r == 'clientes'){
						$select = $select."clientes.nomeCliente as 'Cliente',";
						if($primeiroGroupBy){
							$groupby = "group by clientes.idClientes";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", clientes.idClientes";
						}
						if(!empty($this->input->post('idClientes'))){
							$this->data['idClientes'] = $this->input->post('idClientes');
							$cliente = implode(',', array_filter(array_map('intval', (array)$this->input->post('idClientes'))));
							if(!empty($cliente)){
								$where = $where." and clientes.idClientes in ($cliente)";
							}
						}
					}
					if($r == 'statusOs'){
						$select = $select."status_os.nomeStatusOs as 'Status O.S.',";
						if($primeiroGroupBy){
							$groupby = "group by status_os.idStatusOs";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", status_os.idStatusOs";
						}
						if(!empty($this->input->post('idStatusOs'))){
							$this->data['idStatusOs'] = $this->input->post('idStatusOs');
							$statusOs = implode(',', array_filter(array_map('intval', (array)$this->input->post('idStatusOs'))));
							if(!empty($statusOs)){
								$where = $where." and status_os.idStatusOs in ($statusOs)";
							}
						}
					}
					if($r == 'os'){
						$select = $select."os.idOs as 'Ordem de Serviço',";
						if($primeiroGroupBy){
							$groupby = "group by os.idOs";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", os.idOs";
						}
						if(!empty($this->input->post('listOs'))){
							$this->data['listOs'] = $this->input->post('listOs');
							$_listOs_safe = implode(',', array_filter(array_map('intval', (array)$this->input->post('listOs'))));
						if(!empty($_listOs_safe)){
							$where = $where." and os.idOs in (".$_listOs_safe.")";
						}												
						}						
					}/*else{
						$select = $select."group_concat(DISTINCT os.idOs) as 'O.S. Vinculadas',";
					}*/
				}

			}
		}		
		$this->data['relatorio'] = $this->Relatorios_model->relatorioComercial($select,$groupby,$where);
		$this->data['clientes'] = $this->Relatorios_model->clientesRapid();
		//$this->data['regiao'] = $this->Relatorios_model->regiao();

		
		$this->data['todas_regioes'] = $this->Relatorios_model->getTodasRegioes();
		$this->data['regiao'] = $this->Relatorios_model->regiao();  // Verifique se essa linha está correta
		//var_dump($this->data['todas_regioes']);
	
		$this->data['vendedores'] = $this->Relatorios_model->vendedoresRapid();
		$this->data['idVendedores'] = $this->Relatorios_model->vendedoresAuxRapid();
		$this->data['statusOs'] = $this->Relatorios_model->get("status_os","*");
		$this->data['view'] = 'relatorios/rel_comercial';
        $this->load->view('tema/topo',$this->data);


	}
	
	
	
	function relfaturamento_old(){
		$this->load->model('os_model');   
		$this->load->model('pedidocompra_model'); 
		$this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
		$this->data['clientes'] = $this->Relatorios_model->clientesRapid();
		$this->data['vendedores'] = $this->Relatorios_model->vendedoresRapid();
		if((!empty($this->input->post('data_inicio')) && !empty($this->input->post('data_fim'))) || !empty($this->input->post('unid_execucao'))  || !empty($this->input->post('cliente')) || !empty($this->input->post('contrato')) || !empty($this->input->post('idVendedor'))){
			if(!empty($this->input->post('data_inicio')) && !empty($this->input->post('data_fim'))){
				$_dt_ini_old = $this->_convertAndValidateDate($this->input->post('data_inicio'));
				$_dt_fim_old = $this->_convertAndValidateDate($this->input->post('data_fim'));
				if ($_dt_ini_old && $_dt_fim_old) {
					$dataPeriodo = ' and os.data_entrega BETWEEN "'.$_dt_ini_old.'" and "'.$_dt_fim_old.'"';
				} else {
					$dataPeriodo = '';
				}
			}else{
				$dataPeriodo = '';
			}
			if(!empty($this->input->post('unid_execucao'))){
				$_unidExec_safe = implode(',', array_filter(array_map('intval', (array)$this->input->post('unid_execucao'))));
				$unidExec = !empty($_unidExec_safe) ? ' and os.unid_execucao in ('.$_unidExec_safe.')' : '';
			}else{
				$unidExec = '';
			}
			if(!empty($this->input->post('idVendedor'))){
				$vendedor = ' and orcamento.idVendedor ='.(int)$this->input->post('idVendedor');
			}else{
				$vendedor = '';
			}
			if(!empty($this->input->post('cliente'))){
				$_cliente_safe = $this->db->escape_like_str($this->input->post('cliente'));
				$cliente = ' and clientes.nomeCliente like "%'.$_cliente_safe.'%"';
			}else{
				$cliente = '';
			}
			if(!empty($this->input->post('contrato'))){
				$contrato = ' and os.contrato = "'.$this->db->escape_str($this->input->post('contrato')).'"';
			}else{
				$contrato = '';
			}
			$listOs = $this->Relatorios_model->relatorioEdivan2($dataPeriodo, $unidExec, $vendedor, $cliente, $contrato);
		}else{
			$dataPeriodo = ' and os.data_entrega BETWEEN "2020-01-01" and "2040-12-31"';
			$listOs = $this->Relatorios_model->relatorioEdivan2($dataPeriodo);
		}
		foreach($listOs as $r){
			$somaQtd = 0;
			$somaValor = 0;
			$r->osvinculadas = "";
			$os_vinculada = $this->os_model->os_vinculada($r->idOs);
			foreach($os_vinculada as $e){
				if($e->idOs_principal == $r->idOs){
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_gerada);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_gerada,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_gerada." / "; 

				}else{
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_principal);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_principal,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_principal." / ";
				}
				
			}
			$somaValor += $r->valorInsumos;
			$osAtual = $this->Relatorios_model->get("os"," * ","os.idOs = ".$r->idOs,1,null,true);
			$somaQtd += $osAtual->qtd_os;
			$result = $somaValor/$somaQtd;
			$r->valorInsumos = $result*$osAtual->qtd_os;
			$r->valorInsumos = str_replace(".",",",$r->valorInsumos);
			$r->valorOrc = str_replace(".",",",$r->valorOrc);
			$r->valorOS = str_replace(".",",",$r->valorOS);
		}
		$this->data['listOs'] = $listOs;
		$this->data['view'] = 'relatorios/rel_faturamento';
        $this->load->view('tema/topo',$this->data);
	}

	function relfaturamento(){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vvalorOs')){
			$this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
			redirect(base_url());
		 }
		 $this->load->helper('global_function');
		$this->load->model('os_model');   
		$this->load->model('pedidocompra_model'); 
		$this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
		$this->data['clientes'] = $this->Relatorios_model->clientesRapid();
		$this->data['vendedores'] = $this->Relatorios_model->vendedoresRapid();
		if((!empty($this->input->post('data_inicio_ab')) && !empty($this->input->post('data_fim_ab'))) || (!empty($this->input->post('data_inicio')) && !empty($this->input->post('data_fim'))) || !empty($this->input->post('encerrado')) || !empty($this->input->post('unid_execucao'))  || !empty($this->input->post('cliente')) || !empty($this->input->post('contrato')) || !empty($this->input->post('idVendedor'))){
			if(!empty($this->input->post('data_inicio')) && !empty($this->input->post('data_fim'))){
				$_dt_ini_rf = $this->_convertAndValidateDate($this->input->post('data_inicio'));
				$_dt_fim_rf = $this->_convertAndValidateDate($this->input->post('data_fim'));
				if ($_dt_ini_rf && $_dt_fim_rf) {
					$dataPeriodo = ' and data_faturado BETWEEN "'.$_dt_ini_rf.' 00:00:00" and "'.$_dt_fim_rf.' 23:59:59"';
				} else {
					$dataPeriodo = '';
				}
			}else{
				$dataPeriodo = '';
			}
			if(!empty($this->input->post('data_inicio_ab')) && !empty($this->input->post('data_fim_ab'))){
				$_dt_ini_ab = $this->_convertAndValidateDate($this->input->post('data_inicio_ab'));
				$_dt_fim_ab = $this->_convertAndValidateDate($this->input->post('data_fim_ab'));
				if ($_dt_ini_ab && $_dt_fim_ab) {
					$dataAbertura = ' and os.data_abertura BETWEEN "'.$_dt_ini_ab.' 00:00:00" and "'.$_dt_fim_ab.' 23:59:59"';
					$dataAbertura2 = ' os.data_abertura BETWEEN "'.$_dt_ini_ab.' 00:00:00" and "'.$_dt_fim_ab.' 23:59:59"';
					$this->data['abertura'] = $this->Relatorios_model->getDadosAbertura($dataAbertura2);
				} else {
					$dataAbertura = '';
				}
			}else if(!empty($this->input->post('data_inicio')) && !empty($this->input->post('data_fim'))){
				$dataAbertura = '';
				if (!empty($_dt_ini_rf) && !empty($_dt_fim_rf)) {
					$dataAbertura2 = ' os.data_abertura BETWEEN "'.$_dt_ini_rf.' 00:00:00" and "'.$_dt_fim_rf.' 23:59:59"';
					$this->data['abertura'] = $this->Relatorios_model->getDadosAbertura($dataAbertura2);
				}
			}else{
				$dataAbertura = '';
			}
			if(!empty($this->input->post('unid_execucao'))){
				$_unidExec_safe_rf = implode(',', array_filter(array_map('intval', (array)$this->input->post('unid_execucao'))));
				$unidExec = !empty($_unidExec_safe_rf) ? ' and os.unid_execucao in ('.$_unidExec_safe_rf.')' : '';
			}else{
				$unidExec = '';
			}
			if(!empty($this->input->post('idVendedor'))){
				$vendedor = ' and orcamento.idVendedor ='.(int)$this->input->post('idVendedor');
			}else{
				$vendedor = '';
			}
			if(!empty($this->input->post('cliente'))){
				$_cli_safe_rf = $this->db->escape_like_str($this->input->post('cliente'));
				$cliente = ' and clientes.nomeCliente like "%'.$_cli_safe_rf.'%"';
			}else{
				$cliente = '';
			}
			if(!empty($this->input->post('contrato'))){
				$contrato = ' and os.contrato = "'.$this->db->escape_str($this->input->post('contrato')).'"';
			}else{
				$contrato = '';
			}
			if(!empty($this->input->post('encerrado'))){
				$encerrado = ' and os.idStatusOS in (6,89,87)';
			}else{
				$encerrado = '';
			}
			$listOs = $this->Relatorios_model->relatorioEdivan3($dataPeriodo, $unidExec, $vendedor, $cliente, $contrato, $encerrado,$dataAbertura);
		}else{
			

			$date = new DateTime(); 

			$interval = new DateInterval('P1M');
			$dataInicialcad = $date->sub($interval)->format('d/m/Y');

			$dataFinalcad = new DateTime();
			$dataFinalcad = $dataFinalcad->format('d/m/Y');

			$data_entrega['data_ini']   = $dataInicialcad;
			$data_entrega['data_final'] = $dataFinalcad;
    
            
            if (!empty($dataInicialcad) && !empty($dataFinalcad)) {
                $dataInicialcad2 = explode('/', $dataInicialcad);
                $dataInicialcad2 = $dataInicialcad2[2] . '-' . $dataInicialcad2[1] . '-' . $dataInicialcad2[0];
    
    
                $dataFinalcad2 = explode('/', $dataFinalcad);
                $dataFinalcad2 = $dataFinalcad2[2] . '-' . $dataFinalcad2[1] . '-' . $dataFinalcad2[0];
    
                $data_entrega['data_ini']   = $dataInicialcad;
                $data_entrega['data_final'] = $dataFinalcad;
    
				$dataPeriodo = " and data_faturado BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
				$dataAbertura2 = ' os.data_abertura BETWEEN "'.$dataInicialcad2.' 00:00:00" and "'.$dataFinalcad2.' 23:59:59"';
				$this->data['abertura'] = $this->Relatorios_model->getDadosAbertura($dataAbertura2);
            }
			
			$listOs = $this->Relatorios_model->relatorioEdivan3($dataPeriodo);
		}
		foreach($listOs as $r){
			$somaQtd = 0;
			$somaValor = 0;
			$r->osvinculadas = "";
			$os_vinculada = $this->os_model->os_vinculada($r->idOs);
			foreach($os_vinculada as $e){
				if($this->os_model->getInfoOs($e->idOs_principal) && $this->os_model->getInfoOs($e->idOs_gerada)){
					if($e->idOs_principal == $r->idOs){
						$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_gerada);
						$somaValor += $insumos->somaInsumo;
						$os2 = $this->os_model->getInfoOs($e->idOs_gerada);
						$somaQtd += $os2->qtd_os;
						$r->osvinculadas .= $e->idOs_gerada." / "; 
	
					}else{
						$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_principal);
						$somaValor += $insumos->somaInsumo;
						$os2 = $this->os_model->getInfoOs($e->idOs_principal);
						$somaQtd += $os2->qtd_os;
						$r->osvinculadas .= $e->idOs_principal." / ";
					}
				}
			}
			$somaValor += $r->valorInsumos;
			$osAtual = $this->os_model->getInfoOs($r->idOs);
			$somaQtd += $osAtual->qtd_os;
			$result = $somaValor/$somaQtd;
			$r->valorInsumos = $result*$osAtual->qtd_os;
			//$r->valorInsumos = number_format($r->valorInsumos,2,",",".");
			//$r->valorOrc = number_format($r->valorOrc,2,",",".");
			//$r->valorOS = number_format($r->valorOS,2,",",".");
		}
		$this->data['listOs'] = $listOs;
		$this->data['view'] = 'relatorios/rel_faturamento';
        $this->load->view('tema/topo',$this->data);
	}

	function relfaturamentoitens(){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vvalorOs')){
			$this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
			redirect(base_url());
		 }
		$this->load->model('os_model');   
		$this->load->model('pedidocompra_model'); 
		$this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
		$this->data['clientes'] = $this->Relatorios_model->clientesRapid();
		$this->data['vendedores'] = $this->Relatorios_model->vendedoresRapid();
		if((!empty($this->input->post('data_inicio')) && !empty($this->input->post('data_fim'))) || !empty($this->input->post('unid_execucao'))  || !empty($this->input->post('cliente')) || !empty($this->input->post('contrato')) || !empty($this->input->post('idVendedor'))){
			if(!empty($this->input->post('data_inicio')) && !empty($this->input->post('data_fim'))){
				$_dt_ini_rfi = $this->_convertAndValidateDate($this->input->post('data_inicio'));
				$_dt_fim_rfi = $this->_convertAndValidateDate($this->input->post('data_fim'));
				if ($_dt_ini_rfi && $_dt_fim_rfi) {
					$dataPeriodo = ' and data_faturado BETWEEN "'.$_dt_ini_rfi.'" and "'.$_dt_fim_rfi.'"';
				} else {
					$dataPeriodo = '';
				}
			}else{
				$dataPeriodo = '';
			}
			if(!empty($this->input->post('unid_execucao'))){
				$_unidExec_safe_rfi = implode(',', array_filter(array_map('intval', (array)$this->input->post('unid_execucao'))));
				$unidExec = !empty($_unidExec_safe_rfi) ? ' and os.unid_execucao in ('.$_unidExec_safe_rfi.')' : '';
			}else{
				$unidExec = '';
			}
			if(!empty($this->input->post('idVendedor'))){
				$vendedor = ' and orcamento.idVendedor ='.(int)$this->input->post('idVendedor');
			}else{
				$vendedor = '';
			}
			if(!empty($this->input->post('cliente'))){
				$_cli_safe_rfi = $this->db->escape_like_str($this->input->post('cliente'));
				$cliente = ' and clientes.nomeCliente like "%'.$_cli_safe_rfi.'%"';
			}else{
				$cliente = '';
			}
			if(!empty($this->input->post('contrato'))){
				$contrato = ' and os.contrato = "'.$this->db->escape_str($this->input->post('contrato')).'"';
			}else{
				$contrato = '';
			}
			if(!empty($this->input->post('encerrado'))){
				$encerrado = ' os.idStatusOS in (6,89,87)';
			}else{
				$encerrado = '';
			}
			$listOs = array_merge( $this->Relatorios_model->relatorioEdivan4($dataPeriodo, $unidExec, $vendedor, $cliente, $contrato, $encerrado),$this->Relatorios_model->relatorioEdivan4Almoxarifado($dataPeriodo, $unidExec, $vendedor, $cliente, $contrato,$encerrado));
		}else{
			

			$date = new DateTime(); 

			$interval = new DateInterval('P1M');
			$dataInicialcad = $date->sub($interval)->format('d/m/Y');

			$dataFinalcad = new DateTime();
			$dataFinalcad = $dataFinalcad->format('d/m/Y');

			$data_entrega['data_ini']   = $dataInicialcad;
			$data_entrega['data_final'] = $dataFinalcad;
    
            
            if (!empty($dataInicialcad) && !empty($dataFinalcad)) {
                $dataInicialcad2 = explode('/', $dataInicialcad);
                $dataInicialcad2 = $dataInicialcad2[2] . '-' . $dataInicialcad2[1] . '-' . $dataInicialcad2[0];
    
    
                $dataFinalcad2 = explode('/', $dataFinalcad);
                $dataFinalcad2 = $dataFinalcad2[2] . '-' . $dataFinalcad2[1] . '-' . $dataFinalcad2[0];
    
                $data_entrega['data_ini']   = $dataInicialcad;
                $data_entrega['data_final'] = $dataFinalcad;
    
				$dataPeriodo = " and data_faturado BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
            }
			
			$listOs = array_merge($this->Relatorios_model->relatorioEdivan4($dataPeriodo),$this->Relatorios_model->relatorioEdivan4Almoxarifado($dataPeriodo));
		}
		usort($listOs,function($a,$b){return $a->idOs <=> $b->idOs;});
		$this->data['listOs'] = $listOs;
		$this->data['view'] = 'relatorios/rel_faturamento_itens';
        $this->load->view('tema/topo',$this->data);
	}
	/**/
	public function infoHoras(){
		$this->load->model('os_model');   
        $this->load->model('pedidocompra_model');
        $this->load->model('producao_model');

		$where = "";
		if(!empty($this->input->post('idOrcamento'))){
			$where = " and orcamento_item.idOrcamentos = ".(int)$this->input->post('idOrcamento');
		}
		if(!empty($this->input->post('idOs'))){
			$where = " and os.idOs = ".(int)$this->input->post('idOs');
		}
		if(!empty($this->input->post('pn'))){
			$_pn_safe_ih = $this->db->escape_like_str($this->input->post('pn'));
			$where = " and produtos.pn like '%".$_pn_safe_ih."%'";
		}
		if(!empty($this->input->post('descricaoOrc'))){
			$_desc_safe_ih = $this->db->escape_like_str($this->input->post('descricaoOrc'));
			$where = " and orcamento_item.descricao_item like '%".$_desc_safe_ih."%'";
		}

		$osServ = $this->Relatorios_model->getOsInfoHorasServ($where);
		$osFab = $this->Relatorios_model->getOsInfoHorasFab($where);
		
		foreach($osServ as $c){
			$distribuir = $this->os_model->getDistribuirByIdOs($c->idOs);

			//Calcula o tempo em que foi cadastrados os desenhos
			if(!empty($c->data_solicitar_desenho) && !empty($c->data_finalizado_desenho)){
				$inicio_desenho = new DateTime($c->data_solicitar_desenho);
				$fim_desenho = new DateTime($c->data_finalizado_desenho);
				$diffDataDesenho = $fim_desenho->diff($inicio_desenho);
				$diasHoras = 0;
				if($diffDataDesenho->d > 0){
					$diasHoras = intval($diffDataDesenho->d*24);
				}
				$c->horasGastaDesenho = ($diffDataDesenho->h+$diasHoras).":".(strlen($diffDataDesenho->i)>1?$diffDataDesenho->i:"0".$diffDataDesenho->i).":".(strlen($diffDataDesenho->s)>1?$diffDataDesenho->s:"0".$diffDataDesenho->s);
			}

			//Calcula o tempo em que foi realizado a peritagem
			if(!empty($c->data_finalizado_desenho) && !empty($c->data_finalizado_peritagem)){
				$inicio_peritagem = new DateTime($c->data_finalizado_desenho);
				$fim_peritagem = new DateTime($c->data_finalizado_peritagem);
				$diffDataPeritagem = $fim_peritagem->diff($inicio_peritagem);
				$diasHoras = 0;
				if($diffDataPeritagem->d > 0){
					$diasHoras = intval($diffDataPeritagem->d*24);
				}
				$c->horasGastaPeritagem = ($diffDataPeritagem->h+$diasHoras).":".(strlen($diffDataPeritagem->i)>1?$diffDataPeritagem->i:"0".$diffDataPeritagem->i).":".(strlen($diffDataPeritagem->s)>1?$diffDataPeritagem->s:"0".$diffDataPeritagem->s);
			}else{
				$c->horasGastaPeritagem = "0:00:00";
			}

			//Calcula o intervalo de tempo do momento em que a O.S. ficou disponivel para o PCP até o cadastro do primeiro item			
			if(!empty($c->data_abertura_real) && !empty($distribuir)){
				$disponibilizado = new DateTime($c->data_abertura_real);
				$iniciado = new DateTime($distribuir[0]->data_cadastro);
				$diffPcp = $iniciado->diff($disponibilizado);
				$diasHoras = 0;
				if($diffPcp->d > 0){
					$diasHoras = intval($diffPcp->d*24);

				}
				$c->horasInicioPCP = ($diffPcp->h+$diasHoras).":".(strlen($diffPcp->i)>1?$diffPcp->i:"0".$diffPcp->i).":".(strlen($diffPcp->s)>1?$diffPcp->s:"0".$diffPcp->s);

			}else{
				$c->horasInicioPCP = "0:00:00";
			}

			//Calcula a média de tempo entre o intervalo entre a data de solicitação da compra e data em que foi gerado o pedido pelo suprimentos
			$distribuirComPedido = $this->pedidocompra_model->getDistribuirByIdOs2($c->idOs);
			if(!empty($distribuirComPedido)){
				$somaDias = 0;
				$somaHR = 0;
				$somaMIN = 0;
				$somaSEG = 0;
				$totalEmSEG = 0;
				$contagemPedido = 0;
				$horas = 0;
				$minutos = 0;
				$segundos = 0;
				foreach($distribuirComPedido as $r){	
									
					if(!empty($r->dataDistribuir) && !empty($r->dataPedido)){
						$disponibilizado = new DateTime($r->dataDistribuir);
						$iniciado = new DateTime($r->dataPedido);
						$diffPedidoCompra = $iniciado->diff($disponibilizado);

						$somaSEG = $somaSEG + $diffPedidoCompra->s;
						$somaMIN = $somaMIN + $diffPedidoCompra->i;
						$somaHR = $somaHR + $diffPedidoCompra->h;
						$somaDias = $somaDias + $diffPedidoCompra->d;
						
						$contagemPedido = $contagemPedido+1;	
						/*	
						if($c->idOs == 30796){
							echo '<script>console.log('.json_encode($diffPedidoCompra).')</script>';
							echo '<script>console.log('.($somaSEG + ($somaMIN*60) + ($somaHR*3600) + (($somaDias*24)*3600)).')</script>';
						}	*/	
					}
				}
				$totalEmSEG += 	$somaSEG + ($somaMIN*60) + ($somaHR*3600) + (($somaDias*24)*3600);/*
				if($c->idOs == 30796){
					echo '<script>console.log("Quantidade: '.$contagemPedido.' </br> Segundos: '.$totalEmSEG.'")</script>';
				}*/
				if($somaDias>0){
					$somaHR = $somaHR + ($somaDias*24);
				}
				if($totalEmSEG>0){
					$mediaTempo = intval($totalEmSEG/$contagemPedido);
					
					$horas = floor($mediaTempo / 3600);
					$minutos = floor(($mediaTempo - ($horas * 3600)) / 60);
					$segundos = floor($mediaTempo % 60);
				}
				if(!empty($segundos) || !empty($minutos) || !empty($horas)){
					$c->horasPedidoSup = ($horas).":".(strlen($minutos)>1?$minutos:"0".$minutos).":".(strlen($segundos)>1?$segundos:"0".$segundos);
				}else{
					$c->horasPedidoSup = "0:00:00";
				}
			}else{
				$c->horasPedidoSup = "0:00:00";
			}

			//
			$controle_etapa = $this->producao_model->getControleEtapaByIdOrcamento_item($c->idOrcamento_item);
			if(!empty($controle_etapa)){
				$controle_etapa_hist =$this->producao_model->getControleStatusHistByIdControleEtapa($controle_etapa->idControleEtapa);		
				$idRecebimento = null;
				$objRecebimento = null;
				$idOutroStatus = null;
				$objOutroStatus = null;

				$idDesmontagem = null;
				$objDesmontagem = null;
				$idOutroStatus2 = null;
				$objOutroStatus2 = null;
				if(!empty($controle_etapa_hist)){
					foreach($controle_etapa_hist as $r){
						if($r->idStatusEtapaServico == 2 && empty($idRecebimento)){
							$idRecebimento = 2;
							$objRecebimento = $r;
						}else if(!empty($idRecebimento) && $r->idStatusEtapaServico  != 2 && empty($idOutroStatus)){
							$idOutroStatus = $r->idStatusEtapaServico ;
							$objOutroStatus = $r;
						}
						if($r->idStatusEtapaServico  == 14 && empty($idDesmontagem)){
							$idDesmontagem = 2;
							$objDesmontagem = $r;
						}else if(!empty($idDesmontagem) && $r->idStatusEtapaServico  != 14 && empty($idOutroStatus2)){
							$idOutroStatus2 = $r->idStatusEtapaServico ;
							$objOutroStatus2 = $r;
						}
					}		
					$diasHoras = 0;
					if(!empty($idRecebimento) && !empty($idOutroStatus)){
						$dataRecebimento = new DateTime($objRecebimento->data_alteracao);
						$dataAlteracao = new DateTime($objOutroStatus->data_alteracao);
						$diffDataRecebimento = $dataAlteracao->diff($dataRecebimento);
						if($diffDataRecebimento->d>0){
							$diasHoras = intval($diffDataRecebimento->d*24);
						}
						$c->horasArmazenar = ($diffDataRecebimento->h+$diasHoras).":".(strlen($diffDataRecebimento->i)>1?$diffDataRecebimento->i:"0".$diffDataRecebimento->i).":".(strlen($diffDataRecebimento->s)>1?$diffDataRecebimento->s:"0".$diffDataRecebimento->s);
					}else{
						$c->horasArmazenar = "0:00:00";
					}
	
					$diasHoras =0;
					if(!empty($idDesmontagem) && !empty($idOutroStatus2)){
						$dataDesmontagem = new DateTime($objDesmontagem->data_alteracao);
						$dataAlteracao2 = new DateTime($objOutroStatus2->data_alteracao);
						$diffDataDesmontagem = $dataAlteracao2->diff($dataDesmontagem);
						if($diffDataDesmontagem->d>0){
							$diasHoras = intval($diffDataDesmontagem->d*24);
						}
						$c->horasDesmontagem = ($diffDataDesmontagem->h+$diasHoras).":".(strlen($diffDataDesmontagem->i)>1?$diffDataDesmontagem->i:"0".$diffDataDesmontagem->i).":".(strlen($diffDataDesmontagem->s)>1?$diffDataDesmontagem->s:"0".$diffDataDesmontagem->s);
					}else{
						$c->horasDesmontagem = "0:00:00";
					}
				}else{
					$c->horasArmazenar = "0:00:00";
					$c->horasDesmontagem = "0:00:00";
				}
				
			}else{
				$c->horasArmazenar = "0:00:00";
				$c->horasDesmontagem = "0:00:00";
			}

			if(!empty($c->data_finalizado_peritagem) && !empty($c->data_abertura_real)){
				$dataFinalizadoPeritagem = new DateTime($c->data_finalizado_peritagem);
				$data_abertura_real = new DateTime($c->data_abertura_real);
				$diffDataComercial = $data_abertura_real->diff($dataFinalizadoPeritagem);
				$diasHoras = 0;
				if($diffDataComercial->m>0){
					$diasHoras = ($diffDataComercial->m*30*24);
				}
				if($diffDataComercial->d>0){
					$diasHoras = ($diffDataComercial->d*24) + $diasHoras;
				}
				$c->horasComercial = ($diffDataComercial->h+$diasHoras).":".(strlen($diffDataComercial->i)>1?$diffDataComercial->i:"0".$diffDataComercial->i).":".(strlen($diffDataComercial->s)>1?$diffDataComercial->s:"0".$diffDataComercial->s);

			}else{
				$c->horasComercial = "0:00:00";
			}

			if(!empty($c->data_abertura_orc_item) && !empty($c->data_entrega)){
				$dataAbertura = new DateTime($c->data_abertura_orc_item);
				$dataEntrega = (!empty($c->data_reagendada)?$c->data_reagendada:$c->data_entrega);
				//echo $dataEntrega;
				$dataEntrega = new DateTime($dataEntrega);
				$diffOs = $dataEntrega->diff($dataAbertura);
				$diasHoras = 0;
				if($diffOs->m>0){
					$diasHoras = ($diffOs->m*30*24);
				}
				if($diffOs->d>0){
					$diasHoras = ($diffOs->d*24) + $diasHoras;
				}
				$c->horasOs = ($diffOs->h+$diasHoras).":".(strlen($diffOs->i)>1?$diffOs->i:"0".$diffOs->i).":".(strlen($diffOs->s)>1?$diffOs->s:"0".$diffOs->s);

			}else{
				$c->horasOs = "0:00:00";
			}
			
		}
		foreach($osFab as $c){
			$c->horasGastaPeritagem = "0:00:00";
			$c->horasArmazenar = "0:00:00";
			$c->horasDesmontagem = "0:00:00";
			$distribuir = $this->os_model->getDistribuirByIdOs($c->idOs);
			//Calcula o tempo em que foi cadastrados os desenhos
			if(!empty($c->data_solicitar_desenho) && !empty($c->data_finalizado_desenho)){
				$inicio_desenho = new DateTime($c->data_solicitar_desenho);
				$fim_desenho = new DateTime($c->data_finalizado_desenho);
				$diffDataDesenho = $fim_desenho->diff($inicio_desenho);
				$diasHoras = 0;
				if($diffDataDesenho->d > 0){
					$diasHoras = intval($diffDataDesenho->d*24);
				}
				$c->horasGastaDesenho = ($diffDataDesenho->h+$diasHoras).":".(strlen($diffDataDesenho->i)>1?$diffDataDesenho->i:"0".$diffDataDesenho->i).":".(strlen($diffDataDesenho->s)>1?$diffDataDesenho->s:"0".$diffDataDesenho->s);
			}
			//Calcula o intervalo de tempo do momento em que a O.S. ficou disponivel para o PCP até o cadastro do primeiro item	
			if(!empty($c->data_finalizado_desenho) && !empty($distribuir)){
				$disponibilizado = new DateTime($c->data_finalizado_desenho);
				$iniciado = new DateTime($distribuir[0]->data_cadastro);
				$diffPcp = $iniciado->diff($disponibilizado);
				$diasHoras = 0;
				if($diffPcp->d > 0){
					$diasHoras = intval($diffPcp->d*24);

				}
				$c->horasInicioPCP = ($diffPcp->h+$diasHoras).":".(strlen($diffPcp->i)>1?$diffPcp->i:"0".$diffPcp->i).":".(strlen($diffPcp->s)>1?$diffPcp->s:"0".$diffPcp->s);
			}else{
				$c->horasInicioPCP = "0:00:00";
			}
			$distribuirComPedido = $this->pedidocompra_model->getDistribuirByIdOs2($c->idOs);
			
			if(!empty($distribuirComPedido)){
				$somaDias = 0;
				$somaHR = 0;
				$somaMIN = 0;
				$somaSEG = 0;
				$totalEmSEG = 0;
				$contagemPedido = 0;
				$horas = 0;
				$minutos = 0;
				$segundos = 0;
				foreach($distribuirComPedido as $r){
					if(!empty($r->dataDistribuir) && !empty($r->dataPedido)){
						$disponibilizado = new DateTime($r->dataDistribuir);
						$iniciado = new DateTime($r->dataPedido);
						$diffPedidoCompra = $iniciado->diff($disponibilizado);

						$somaSEG = $somaSEG + $diffPedidoCompra->s;
						$somaMIN = $somaMIN + $diffPedidoCompra->i;
						$somaHR = $somaHR + $diffPedidoCompra->h;
						$somaDias = $somaDias + $diffPedidoCompra->d;
						
						$contagemPedido = $contagemPedido+1;	
						/*	
						if($c->idOs == 30796){
							echo '<script>console.log('.json_encode($diffPedidoCompra).')</script>';
							echo '<script>console.log('.($somaSEG + ($somaMIN*60) + ($somaHR*3600) + (($somaDias*24)*3600)).')</script>';
						}	*/	
					}
				}
				$totalEmSEG += 	$somaSEG + ($somaMIN*60) + ($somaHR*3600) + (($somaDias*24)*3600);/*
				if($c->idOs == 30796){
					echo '<script>console.log("Quantidade: '.$contagemPedido.' </br> Segundos: '.$totalEmSEG.'")</script>';
				}*/
				if($somaDias>0){
					$somaHR = $somaHR + ($somaDias*24);
				}
				if($totalEmSEG>0){
					$mediaTempo = intval($totalEmSEG/$contagemPedido);
					
					$horas = floor($mediaTempo / 3600);
					$minutos = floor(($mediaTempo - ($horas * 3600)) / 60);
					$segundos = floor($mediaTempo % 60);
				}
				if(!empty($segundos) || !empty($minutos) || !empty($horas)){
					$c->horasPedidoSup = ($horas).":".(strlen($minutos)>1?$minutos:"0".$minutos).":".(strlen($segundos)>1?$segundos:"0".$segundos);
				}else{
					$c->horasPedidoSup = "0:00:00";
				}
			}else{
				$c->horasPedidoSup = "0:00:00";
			}

			if(!empty($c->data_abertura_orc_item) && !empty($c->data_abertura_real)){
				$inicio = new DateTime($c->data_abertura_orc_item);
				$fim = new DateTime($c->data_abertura_real);
				$diffDataComercial = $fim->diff($inicio);
				$diasHoras = 0;
				if($diffDataComercial->m>0){
					$diasHoras = ($diffDataComercial->m*30*24);
				}
				if($diffDataComercial->d>0){
					$diasHoras = ($diffDataComercial->d*24) + $diasHoras;
				}
				$c->horasComercial = ($diffDataComercial->h+$diasHoras).":".(strlen($diffDataComercial->i)>1?$diffDataComercial->i:"0".$diffDataComercial->i).":".(strlen($diffDataComercial->s)>1?$diffDataComercial->s:"0".$diffDataComercial->s);

			}else{
				$c->horasComercial = "0:00:00";
			}

			if(!empty($c->data_abertura_orc_item) && !empty($c->data_entrega)){
				$dataAbertura = new DateTime($c->data_abertura_orc_item);
				$dataEntrega = (!empty($c->data_reagendada)?$c->data_reagendada:$c->data_entrega);
				$dataEntrega = new DateTime($dataEntrega);
				$diffOs = $dataEntrega->diff($dataAbertura);
				$diasHoras = 0;
				if($diffOs->m>0){
					$diasHoras = ($diffOs->m*30*24);
				}
				if($diffOs->d>0){
					$diasHoras = ($diffOs->d*24) + $diasHoras;
				}
				$c->horasOs = ($diffOs->h+$diasHoras).":".(strlen($diffOs->i)>1?$diffOs->i:"0".$diffOs->i).":".(strlen($diffOs->s)>1?$diffOs->s:"0".$diffOs->s);

			}else{
				$c->horasOs = "0:00:00";
			}
		}
		$totalItens = array();
		if(!empty($osServ)){
			$totalItens = array_merge($totalItens,$osServ);
		}
		if(!empty($osFab)){
			$totalItens = array_merge($totalItens,$osFab);
		}
		//exit();
		$this->data['result'] = $totalItens;
		$this->data['view'] = 'relatorios/rel_horas';
        $this->load->view('tema/topo',$this->data);
	}

	public function edivan(){
		$this->load->model('os_model');
		$this->load->helper('download');
		$this->load->model('pedidocompra_model');
		if(!empty($this->input->post('data_inicio'))){
			$data = explode("/",$this->input->post('data_inicio'));
			$data_inicio = $data[2]."-".$data[1]."-".$data[0];
		}
		if(!empty($this->input->post('data_fim'))){
			$data = explode("/",$this->input->post('data_fim'));
			$data_fim = $data[2]."-".$data[1]."-".$data[0];
		}
		echo "O.S;Unid. Exec.;Valor Orc.;Valor O.S.;Valor Insumo;Valor Sup\n";
		$data_inicio = $this->uri->segment(3);
		$data_fim = $this->uri->segment(4);
		$unid_exec = $this->uri->segment(5);
		if(!$data_inicio || !$data_fim){
			echo 'Informe as datas de inicio e fim na url. Ex: relatorios/edivan/2022-01-01/2022-12-31';
			return;
		}
		$listOs = $this->Relatorios_model->relatorioEdivan($data_inicio,$data_fim,$unid_exec);
		//$listOs = $this->Relatorios_model->relatorioEdivan('2022-01-01','2022-01-31');
		//echo json_encode($listOs);
		foreach($listOs as $r){
			$somaQtd = 0;
			$somaValor = 0;
			$r->osvinculadas = "";
			$os_vinculada = $this->os_model->os_vinculada($r->idOs);
			foreach($os_vinculada as $e){
				if($e->idOs_principal == $r->idOs){
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_gerada);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_gerada,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_gerada." / "; 

				}else{
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_principal);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_principal,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_principal." / ";
				}
				
			}
			$somaValor += $r->valorInsumos;
			$osAtual = $this->Relatorios_model->get("os"," * ","os.idOs = ".$r->idOs,1,null,true);
			$somaQtd += $osAtual->qtd_os;
			$result = $somaValor/$somaQtd;
			$r->valorInsumos = $result*$osAtual->qtd_os;
			$r->valorInsumos = str_replace(".",",",$r->valorInsumos);
			$r->valorOrc = str_replace(".",",",$r->valorOrc);
			$r->valorOS = str_replace(".",",",$r->valorOS);
		}
		//echo json_encode($listOs);
		// Open a file in write mode ('w')
		$fp = fopen('php://output', 'w');
		header('Pragma: public');     // required
		header('Expires: 0');         // no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Disposition: attachment; filename="'.basename('relatorio_'.str_replace("-","",$data_inicio).'_'.str_replace("-","",$data_fim).'.csv').'"');  // Add the file name
		header('Content-Transfer-Encoding: binary');
		header('Connection: close');
		foreach ($listOs as $fields) {
			fputcsv($fp, get_object_vars($fields),";");
		}
		$data = file_get_contents('php://output');
    	// Build the headers to push out the file properly.
   
		exit();

		force_download('relatorio_'.str_replace("-","",$data_inicio).'_'.str_replace("-","",$data_fim).'.csv', $data);
		fclose($fp);
	}

	public function edivan2(){
		$this->load->model('os_model');
		$this->load->helper('download');
		$this->load->model('pedidocompra_model');
		if(!empty($this->input->post('data_inicio'))){
			$data = explode("/",$this->input->post('data_inicio'));
			$data_inicio = $data[2]."-".$data[1]."-".$data[0];
		}
		if(!empty($this->input->post('data_fim'))){
			$data = explode("/",$this->input->post('data_fim'));
			$data_fim = $data[2]."-".$data[1]."-".$data[0];
		}
		echo "O.S;Unid. Exec.;Valor Orc.;Valor O.S.;Valor Insumo;;Valor Almoxarifado\n";
		$data_inicio = $this->uri->segment(3);
		$data_fim = $this->uri->segment(4);
		$unid_exec = $this->uri->segment(5);
		if(!$data_inicio || !$data_fim){
			echo 'Informe as datas de inicio e fim na url. Ex: relatorios/edivan/2022-01-01/2022-12-31';
			return;
		}
		$listOs = $this->Relatorios_model->relatorioEdivan($data_inicio,$data_fim,$unid_exec);
		//$listOs = $this->Relatorios_model->relatorioEdivan('2022-01-01','2022-01-31');
		//echo json_encode($listOs);
		foreach($listOs as $r){
			$somaQtd = 0;
			$somaValor = 0;
			$r->osvinculadas = "";
			$os_vinculada = array();
			$os_vinculada = $this->os_model->os_vinculada($r->idOs);
			foreach($os_vinculada as $e){
				if($e->idOs_principal == $r->idOs){
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_gerada);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_gerada,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_gerada." / ";


				}else{
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_principal);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_principal,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_principal." / ";
				}
				
			}
			$soma_almoxarifado = 0;/**/
			$almoxarifado = $this->Relatorios_model->getSaidasByIdOsSemReserva($r->idOs);
			if(!empty($almoxarifado)){
				foreach($almoxarifado as $v){
					$insumoCompativel = $this->pedidocompra_model->getUltimosOrcLimitedOne(" and distribuir_os.idInsumos = $v->idProduto");
					if(!empty($insumoCompativel)){
						$soma_almoxarifado = $soma_almoxarifado + ((float)$insumoCompativel->valor_unitario * (float)$v->quantidade);
					}
				}
			}
			$somaValor += $r->valorInsumos;
			$osAtual = $this->Relatorios_model->get("os"," * ","os.idOs = ".$r->idOs,1,null,true);
			$somaQtd += $osAtual->qtd_os;
			$result = $somaValor/$somaQtd;
			$r->valorInsumos = $result*$osAtual->qtd_os;
			$r->valorInsumos = str_replace(".",",",$r->valorInsumos);
			$r->valorOrc = str_replace(".",",",$r->valorOrc);
			$r->valorOS = str_replace(".",",",$r->valorOS);
			$r->valorAlmoxarifado = str_replace(".",",",$soma_almoxarifado);
		}
		//echo json_encode($listOs);
		// Open a file in write mode ('w')
		$fp = fopen('php://output', 'w');
		header('Pragma: public');     // required
		header('Expires: 0');         // no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Disposition: attachment; filename="'.basename('relatorio_'.str_replace("-","",$data_inicio).'_'.str_replace("-","",$data_fim).'.csv').'"');  // Add the file name
		header('Content-Transfer-Encoding: binary');
		header('Connection: close');
		foreach ($listOs as $fields) {
			fputcsv($fp, get_object_vars($fields),";");
		}
		$data = file_get_contents('php://output');
    	// Build the headers to push out the file properly.
   
		exit();

		force_download('relatorio_'.str_replace("-","",$data_inicio).'_'.str_replace("-","",$data_fim).'.csv', $data);
		fclose($fp);
	}

	function relperitagem(){
		$antigo = $this->Relatorios_model->getPeritagemOs();
		$novo = $this->Relatorios_model->getOrcEscopoStatusPeritagem();
		$this->data['result']=array_merge($antigo,$novo);
		$this->data['view'] = 'relatorios/rel_peritagem';
        $this->load->view('tema/topo',$this->data);
	}

	function relvendas(){
		$this->load->model('orcamentos_model');
		$this->load->helper('global_function');
		$this->data['dados_vendedor']= $this->orcamentos_model->getVendedor();
		$where = "";
		
		if(empty($this->uri->segment(3))){
			echo '<script type="text/javascript">
				localStorage.clear();
			</script>
		';
		}
		if(empty($this->input->post('data_inicial')) || empty($this->input->post('data_final'))){
			$dataAtual = date('Y-m-d');
			$mesAnoAtual = date('Y-m');
			$this->data['data_inicial'] = converterReversoData($mesAnoAtual."-01");
			$this->data['data_final'] = converterReversoData($dataAtual);
			//$where .= " and os.data_abertura BETWEEN '".$mesAnoAtual."-01 00:00:00' and '".$dataAtual." 23:59:59'";
			$where .= " and os.data_abertura BETWEEN '".$mesAnoAtual."-01 00:00:00' and '".$dataAtual." 23:59:59'";
		}else{
			$dataInicial = converterData($this->input->post('data_inicial'));
			$dataFinal = converterData($this->input->post('data_final'));
			$this->data['data_inicial'] = $this->input->post('data_inicial');
			$this->data['data_final'] = $this->input->post('data_final');
			//$where .= " and os.data_abertura BETWEEN '".$dataInicial." 00:00:00' and '".$dataFinal." 23:59:59'";
			$where .= " and os.data_abertura BETWEEN '".$dataInicial." 00:00:00' and '".$dataFinal." 23:59:59'";
		}
		$this->data['vendedor'] = array();
		$primeirovend = true;
		if(!empty($this->input->post('idVendedores'))){
			$vendedor2 = "";
			$this->data['idVendedores'] = $this->input->post('idVendedores');
            foreach ($this->input->post('idVendedores') as $des) {
                if ($primeirovend) {
                    $vendedor2 = $des;
                    $primeirovend = false;
                } else {
                    $vendedor2 =  $vendedor2 . ',' . $des;
                }
            }
            $where .= " and orcamento.idVendedor IN($vendedor2)";
		}
		$this->data['result'] = $this->Relatorios_model->getVendas($where);
		$this->data['result_cliente'] = $this->Relatorios_model->getVendasCliente($where);
		$this->data['result_vendedor'] = $this->Relatorios_model->getVendasVendedor($where);
		$this->data['view'] = 'relatorios/rel_vendasnovo';
        $this->load->view('tema/topo',$this->data);
	}
}
