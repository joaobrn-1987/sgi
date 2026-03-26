<?php

class Pcp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }
        $this->load->helper(['form', 'codegen_helper']);
        
        $this->load->model('os_model', '', true);
        $this->load->model('pedidocompra_model');
        $this->load->model('cotacao_model');
        $this->load->model('relatorios_model');
        $this->load->model('orcamentos_model');

        $this->data['menuPcp'] = 'PCP';
    }
    public function index()
    {
        $this->backlog();
    }
/*public function backlog()
{
    $this->load->library('pagination');
    $this->load->model('relatorios_model');
    $this->load->model('cotacao_model');
    $this->load->model('os_model');

    $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
    $this->data['status_os'] = $this->os_model->getStatusOs();
    $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');

    $config['base_url'] = base_url() . 'index.php/pcp/backlog/';
    $config['per_page'] = 50;
    $config['uri_segment'] = 3;
    $config['reuse_query_string'] = TRUE;

    $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
    $config['full_tag_close'] = '</ul></div>';
    $config['first_link'] = 'Primeira';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = 'Última';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = 'Próxima &raquo;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '&laquo; Anterior';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $where = "";

    if ($this->input->get('ehfiltro') || !$this->input->get()) {
        $normal_os_conditions = [];
        $normal_os_conditions[] = "distribuir_os.idOs NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14)";

        $idStatuscompras = $this->input->get('idStatuscompras');
        if ($idStatuscompras !== null && is_array($idStatuscompras) && count($idStatuscompras) > 0) {
            $normal_os_conditions[] = "distribuir_os.idStatuscompras IN (" . implode(',', array_map('intval', $idStatuscompras)) . ")";
        }

        $idStatusOs = $this->input->get('idStatusOs');
        if ($idStatusOs !== null && is_array($idStatusOs) && count($idStatusOs) > 0) {
            $normal_os_conditions[] = "os.idStatusOs IN (" . implode(',', array_map('intval', $idStatusOs)) . ")";
        }

        $normal_os_filter_string = implode(" AND ", $normal_os_conditions);

        if ($this->input->get('exibir_almoxarifado') == '1') {
            $where = " AND ((distribuir_os.idOs IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14)) OR ({$normal_os_filter_string}))";
        } else {
            $where = " AND ({$normal_os_filter_string})";
        }

        if (!empty($this->input->get('idOs'))) {
            $where .= " AND os.idOs IN (" . $this->db->escape_str($this->input->get('idOs')) . ")";
        }

        if (!empty($this->input->get('idPedidoCompra'))) {
            $where .= " AND pedido_comprasitens.idPedidoCompra IN (" . $this->db->escape_str($this->input->get('idPedidoCompra')) . ")";
        }

        $unid_execucao = $this->input->get('unid_execucao');
        if ($unid_execucao !== null && is_array($unid_execucao) && count($unid_execucao) > 0) {
            $where .= " AND os.unid_execucao IN (" . implode(',', array_map('intval', $unid_execucao)) . ")";
        }
    }

    $config['total_rows'] = $this->relatorios_model->countRelatorioBacklogPCP($where);
    $this->pagination->initialize($config);
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    $this->data['result'] = $this->relatorios_model->relatorioBacklogPCP($where, $config['per_page'], $page);
    $this->data['pagination'] = $this->pagination->create_links();
    $this->data['view'] = 'pcp/backlog';

    $this->load->view('tema/topo', $this->data);
}

public function exportarBacklog()
{
    $this->load->model('relatorios_model');
    $this->load->model('os_model');

    $where = "";
    $normal_os_conditions = [];
    $normal_os_conditions[] = "distribuir_os.idOs NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14)";

    $idStatuscompras = $this->input->get('idStatuscompras');
    if ($idStatuscompras !== null && is_array($idStatuscompras) && count($idStatuscompras) > 0) {
        $normal_os_conditions[] = "distribuir_os.idStatuscompras IN (" . implode(',', array_map('intval', $idStatuscompras)) . ")";
    }

    $idStatusOs = $this->input->get('idStatusOs');
    if ($idStatusOs !== null && is_array($idStatusOs) && count($idStatusOs) > 0) {
        $normal_os_conditions[] = "os.idStatusOs IN (" . implode(',', array_map('intval', $idStatusOs)) . ")";
    }

    $normal_os_filter_string = implode(" AND ", $normal_os_conditions);

    if ($this->input->get('exibir_almoxarifado') == '1') {
        $where = " AND ((distribuir_os.idOs IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14)) OR ({$normal_os_filter_string}))";
    } else {
        $where = " AND ({$normal_os_filter_string})";
    }

    if (!empty($this->input->get('idOs'))) {
        $where .= " AND os.idOs IN (" . $this->db->escape_str($this->input->get('idOs')) . ")";
    }

    if (!empty($this->input->get('idPedidoCompra'))) {
        $where .= " AND pedido_comprasitens.idPedidoCompra IN (" . $this->db->escape_str($this->input->get('idPedidoCompra')) . ")";
    }

    $unid_execucao = $this->input->get('unid_execucao');
    if ($unid_execucao !== null && is_array($unid_execucao) && count($unid_execucao) > 0) {
        $where .= " AND os.unid_execucao IN (" . implode(',', array_map('intval', $unid_execucao)) . ")";
    }

    $todos_resultados = $this->relatorios_model->relatorioBacklogPCP($where, 0, 0);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=relatorio_backlog_'.date('Y-m-d').'.csv');
    echo "\xEF\xBB\xBF";
    
    $output = fopen('php://output', 'w');
    fputcsv($output, [
        'Resp. PCP', 'Descricao O.S.', 'PN', 'O.S.', 'Data Entrega',
        'Unid. Exec.', 'Data Reagendada', 'Descricao Insumo', 'Qtde', 'O.C.',
        'Valor Unit.', 'Valor Total', 'Data Lanc.', 'Data Alt.', 'Previsao Ent.', 'Data Ent.',
        'Status Compra', 'Fornecedor', 'Contato', 'Data Reprog.', 'Data Limite', 'Justificativa',
        'Data Abertura OS', 'Status OS'
    ], ';');

    foreach ($todos_resultados as $r) {
        $linha = [
            $r->nome,
            $r->descricao_item,
            $r->pn,
            $r->idOs,
            (!empty($r->entrega_os) ? date("d/m/Y", strtotime($r->entrega_os)) : ""),
            $r->status_execucao,
            (!empty($r->reagendada_os) ? date("d/m/Y", strtotime($r->reagendada_os)) : ""),
            $r->descricaoInsumo,
            $r->quantidade,
            $r->idPedidoCompra,
            number_format($r->valor_unitario, 2, ",", "."),
            number_format($r->valor_unitario * $r->quantidade, 2, ",", "."),
            (!empty($r->data_dist) ? date("d/m/Y", strtotime($r->data_dist)) : ""),
            (!empty($r->data_alteracao) ? date("d/m/Y", strtotime($r->data_alteracao)) : ""),
            (!empty($r->previsao_entrega) ? date("d/m/Y", strtotime($r->previsao_entrega)) : ""),
            (!empty($r->datastatusentregue) ? date("d/m/Y", strtotime($r->datastatusentregue)) : ""),
            $r->nomeStatus,
            $r->nomeFornecedor,
            $r->telefone,
            (!empty($r->data_reagendada) ? date("d/m/Y", strtotime($r->data_reagendada)) : ""),
            (!empty($r->data_limite) ? date("d/m/Y", strtotime($r->data_limite)) : ""),
            $r->ultJustificativa,
            (!empty($r->data_abertura) ? date("d/m/Y", strtotime($r->data_abertura)) : ""),
            $r->nomeStatusOs,
        ];
        fputcsv($output, $linha, ';');
    }

    fclose($output);
    exit();
}
*/





    public function backlog()
    {
        $this->load->library('pagination');

        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['status_os'] = $this->os_model->getStatusOs();
        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
        $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();

        $config['base_url'] = base_url() . 'index.php/pcp/backlog/';
        $config['per_page'] = 50;
        // ... (resto da sua configuração de paginação)
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_link'] = 'Primeira';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Última';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Próxima &raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo; Anterior';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $conditions = [];

        if ($this->input->get('exibir_almoxarifado') == '1') {
            $conditions[] = "distribuir_os.idOs IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14)";
        } else {
            $conditions[] = "distribuir_os.idOs NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14)";
        }
        
        if ($this->input->get('ehfiltro') == '1') {
            $idStatuscompras = $this->input->get('idStatuscompras');
            if (!empty($idStatuscompras) && is_array($idStatuscompras)) {
                $conditions[] = "distribuir_os.idStatuscompras IN (" . implode(',', array_map('intval', $idStatuscompras)) . ")";
            }
            $idStatusOs = $this->input->get('idStatusOs');
            if (!empty($idStatusOs) && is_array($idStatusOs)) {
                $conditions[] = "os.idStatusOs IN (" . implode(',', array_map('intval', $idStatusOs)) . ")";
            }
        } else {
            $conditions[] = "distribuir_os.idStatuscompras IN (1, 17, 18, 2, 16, 3, 13, 10, 14, 19, 12, 4)";
            $conditions[] = "os.idStatusOs IN (5, 9, 16, 20, 21, 25, 28, 30, 42, 85, 88, 90, 96, 101, 200, 208, 213, 217, 219, 221, 223, 225)";
        }
        
        $unid_execucao = $this->input->get('unid_execucao');
        if (!empty($unid_execucao) && is_array($unid_execucao)) {
            $conditions[] = "os.unid_execucao IN (" . implode(',', array_map('intval', $unid_execucao)) . ")";
        }
        if (!empty($this->input->get('idOs'))) {
            $conditions[] = "os.idOs IN (" . $this->db->escape_str($this->input->get('idOs')) . ")";
        }
        if (!empty($this->input->get('idPedidoCompra'))) {
            $conditions[] = "pedido_comprasitens.idPedidoCompra IN (" . $this->db->escape_str($this->input->get('idPedidoCompra')) . ")";
        }
        $tipo_compra = $this->input->get('tipo_compra');
        if (!empty($tipo_compra)) {
            $conditions[] = "distribuir_os.tipo_compra = " . $this->db->escape($tipo_compra);
        }

        // --- CORREÇÃO DO FILTRO DE GRUPO DE SERVIÇO ---
        $idGrupoServico = $this->input->get('idGrupoServico');
        if (!empty($idGrupoServico)) {
            // Alterado de 'os.idGrupoServico' para 'orcamento.idGrupoServico'
            $conditions[] = "orcamento.idGrupoServico = " . $this->db->escape((int)$idGrupoServico);
        }
        // --- FIM DA CORREÇÃO ---
        
        $where = "";
        if (!empty($conditions)) {
            $where = "AND " . implode(" AND ", $conditions);
        }

        $config['total_rows'] = $this->relatorios_model->countRelatorioBacklogPCP($where);
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['result'] = $this->relatorios_model->relatorioBacklogPCP($where, $config['per_page'], $page);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['view'] = 'pcp/backlog';

        $this->load->view('tema/topo', $this->data);
    }

public function exportarBacklog()
    {
        $this->load->model('relatorios_model');
        $this->load->model('os_model');

        // --- LÓGICA DE FILTROS (MANTIDA ORIGINAL) ---
        $conditions = [];

        if ($this->input->get('exibir_almoxarifado') != '1') {
            $conditions[] = "distribuir_os.idOs NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14)";
        }
        
        if ($this->input->get('ehfiltro') == '1') {
            $idStatuscompras = $this->input->get('idStatuscompras');
            if (!empty($idStatuscompras) && is_array($idStatuscompras)) {
                $conditions[] = "distribuir_os.idStatuscompras IN (" . implode(',', array_map('intval', $idStatuscompras)) . ")";
            }
            $idStatusOs = $this->input->get('idStatusOs');
            if (!empty($idStatusOs) && is_array($idStatusOs)) {
                $conditions[] = "os.idStatusOs IN (" . implode(',', array_map('intval', $idStatusOs)) . ")";
            }
        } else {
            $conditions[] = "distribuir_os.idStatuscompras IN (1, 17, 18, 2, 16, 3, 13, 10, 14, 19, 12, 4)";
            $conditions[] = "os.idStatusOs IN (5, 9, 16, 20, 21, 25, 28, 30, 42, 85, 88, 90, 96, 101, 200, 208, 213, 217, 219, 221, 223, 225)";
        }
        
        $unid_execucao = $this->input->get('unid_execucao');
        if (!empty($unid_execucao) && is_array($unid_execucao)) {
            $conditions[] = "os.unid_execucao IN (" . implode(',', array_map('intval', $unid_execucao)) . ")";
        }

        if (!empty($this->input->get('idOs'))) {
            $conditions[] = "os.idOs IN (" . $this->db->escape_str($this->input->get('idOs')) . ")";
        }

        if (!empty($this->input->get('idPedidoCompra'))) {
            $conditions[] = "pedido_comprasitens.idPedidoCompra IN (" . $this->db->escape_str($this->input->get('idPedidoCompra')) . ")";
        }

        $tipo_compra = $this->input->get('tipo_compra');
        if (!empty($tipo_compra)) {
            $conditions[] = "distribuir_os.tipo_compra = " . $this->db->escape($tipo_compra);
        }
        
        $idGrupoServico = $this->input->get('idGrupoServico');
        if (!empty($idGrupoServico)) {
            $conditions[] = "orcamento.idGrupoServico = " . $this->db->escape((int)$idGrupoServico);
        }

        $where = "";
        if (!empty($conditions)) {
            $where = "AND " . implode(" AND ", $conditions);
        }

        // Busca dados
        $todos_resultados = $this->relatorios_model->relatorioBacklogPCP($where, 0, 0);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=relatorio_backlog_'.date('Y-m-d').'.csv');
        echo "\xEF\xBB\xBF";
        
        $output = fopen('php://output', 'w');
        
        fputcsv($output, [
            'Resp. PCP', 'Descricao O.S.', 'PN', 'O.S.', 'Data Entrega', 
            'Unid. Exec.', 'Data Reagendada', 'Descricao Insumo', 'Qtde', 'O.C.',
            'Valor Unit.', 'Valor Total', 'Data Lanc.', 'Data Alt.', 'Previsao Ent.', 'Data Ent.',
            'Status Compra', 'Fornecedor', 'Contato', 'Data Reprog.', 'Data Limite', 'Justificativa', 'Cliente',
            'Data Abertura OS', 'Status OS', 'Tipo Compra', 'Valor O.S.', 'Grupo Serviço',
            'Valor Total c/ Impostos'
        ], ';');

        // --- ARRAY DE CONTROLE PARA FRETE (Soma Única) ---
        $pedidos_frete_somados = array();

        foreach ($todos_resultados as $r) {
            $descricaoCompleta = $r->descricaoInsumo;
            if(!empty($r->dimensoes)){ $descricaoCompleta.=" ".$r->dimensoes; }
            if(!empty($r->comprimento)){ $descricaoCompleta.=" x ".$r->comprimento." mm"; }
            if(!empty($r->volume)){ $descricaoCompleta.=" ".$r->volume." ml"; }
            if(!empty($r->peso)){ $descricaoCompleta.=" ".$r->peso." g"; }
            if(!empty($r->dimensoesL)){ $descricaoCompleta .= " x L: ".$r->dimensoesL." mm "; }
            if(!empty($r->dimensoesC)){ $descricaoCompleta .= " x C: ".$r->dimensoesC." mm "; }
            if(!empty($r->dimensoesA)){ $descricaoCompleta .= " x A: ".$r->dimensoesA." mm"; }

            // [INÍCIO CÁLCULO UNIFICADO]
            $valorBase = floatval($r->valor_unitario) * floatval($r->quantidade);
            
            // Impostos do Item
            $icms = (!empty($r->icms) && is_numeric($r->icms)) ? floatval($r->icms) : 0;
            $ipi = (!empty($r->ipi_valor) && is_numeric($r->ipi_valor)) ? floatval($r->ipi_valor) : 0; // IPI já vem calculado ou fixo dependendo do Model, aqui assumimos valor
            $outros = (!empty($r->outros) && is_numeric($r->outros)) ? floatval($r->outros) : 0;
            $desconto = (!empty($r->desconto) && is_numeric($r->desconto)) ? floatval($r->desconto) : 0;

            // Frete do Pedido (Soma única por ID)
            $frete_para_soma = 0;
            if (!empty($r->idPedidoCompra)) {
                if (!in_array($r->idPedidoCompra, $pedidos_frete_somados)) {
                    $frete_para_soma = isset($r->frete) ? floatval($r->frete) : 0;
                    $pedidos_frete_somados[] = $r->idPedidoCompra;
                }
            }

            // Fórmula: Base + Impostos + Frete(se 1ª vez) - Desconto
            $valorComImpostos = $valorBase + $ipi + $icms + $outros + $frete_para_soma - $desconto;
            // [FIM CÁLCULO]

            $linha = [
                $r->nome, $r->descricao_item, $r->pn, $r->idOs,
                (!empty($r->entrega_os) ? date("d/m/Y", strtotime($r->entrega_os)) : ""),
                $r->status_execucao,
                (!empty($r->reagendada_os) ? date("d/m/Y", strtotime($r->reagendada_os)) : ""),
                $descricaoCompleta,
                $r->quantidade, $r->idPedidoCompra,
                number_format($r->valor_unitario, 2, ",", "."),
                number_format($valorBase, 2, ",", "."),
                (!empty($r->data_dist) ? date("d/m/Y", strtotime($r->data_dist)) : ""),
                (!empty($r->data_alteracao) ? date("d/m/Y", strtotime($r->data_alteracao)) : ""),
                (!empty($r->previsao_entrega) ? date("d/m/Y", strtotime($r->previsao_entrega)) : ""),
                (!empty($r->datastatusentregue) ? date("d/m/Y", strtotime($r->datastatusentregue)) : ""),
                $r->nomeStatus, $r->nomeFornecedor, $r->telefone,
                (!empty($r->data_reagendada) ? date("d/m/Y", strtotime($r->data_reagendada)) : ""),
                (!empty($r->data_limite) ? date("d/m/Y", strtotime($r->data_limite)) : ""),
                $r->ultJustificativa,
                $r->nomeCliente,
                (!empty($r->data_abertura) ? date("d/m/Y", strtotime($r->data_abertura)) : ""),
                $r->nomeStatusOs, 
                (isset($r->tipo_compra) ? $r->tipo_compra : ''), 
                number_format($r->SubTotal, 2, ",", "."),
                (isset($r->nome_grupo_servico) ? $r->nome_grupo_servico : ''),
                number_format($valorComImpostos, 2, ",", ".")
            ];
            
            fputcsv($output, $linha, ';');
        }

        fclose($output);
        exit();
    }


    function addjusificativaPedidoCompra()
    {
        if (empty($this->input->post('idPedidoCompra'))){
            $this->session->set_flashdata('error', 'Informe uma ordem de compra.');
            redirect(base_url() . 'index.php/pcp/backlog');
        }
        $this->load->model('producao_model');
        $distribuir = $this->pedidocompra_model->getdistribuidorByIdPedidoCompra($this->input->post('idPedidoCompra'));
        $data_reprog = $this->input->post('data_rep');
        if (!empty($data_reprog)) {
            $data = explode("/", $data_reprog);
            $data_real = $data[2] . "-" . $data[1] . "-" . $data[0];
            $data2 = array(
                "data_reagendada" => $data_real
            );
        } else {
            $data_real = "";
        }
        $obs = $this->input->post('justificativa');
        foreach ($distribuir as $r) {
            if (!empty($data_real)) {
                $this->producao_model->edit('distribuir_os', $data2, 'idDistribuir', $r->idDistribuir);
            }
            if (!empty($obs)) {;
                $data = array(
                    "ultJustificativa" => $obs
                );
                $this->load->model('producao_model');
                $this->producao_model->edit('distribuir_os', $data, 'idDistribuir', $r->idDistribuir);
            } else {
                $obs = "";
            }
            $obsEx = $r->justificativa;
            $obs2 = $obsEx . "Data: " . date('d/m/Y H:i:s') . "<br>" . "Autor: " . $this->session->userdata('nome') . "<br>" . "Data Reprogramada: " . $data_reprog . "<br><br>" . $obs . "<br><div style='border-bottom: 1px solid black'></div><br><br>";
            $data = array(
                "justificativa" => $obs2
            );
            $this->producao_model->edit('distribuir_os', $data, 'idDistribuir', $r->idDistribuir);
        }
        $this->session->set_flashdata('success', 'Justificativa adicionada com sucesso');
        redirect(base_url() . 'index.php/pcp/backlog');
    }
	
	
    function compra()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vPedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar Pedido de compra.');
            redirect(base_url());
        }
        $empresaNum1 = $this->input->post('empresaNum1');
        $empresaNum2 = $this->input->post('empresaNum2');
        if ((!empty($empresaNum1) && empty($empresaNum2)) || (empty($empresaNum1) && !empty($empresaNum2))) {
            $this->session->set_flashdata('error', 'Para filtrar por empresas preencha os dois campos!');
            redirect(base_url() . 'index.php/pcp/compra');
        }

        $this->load->library('table');
        $this->load->library('pagination');

        $this->load->model('os_model');
        $this->load->model('orcamentos_model');
        $this->load->model('cotacao_model');
        $this->load->model('usuarios_model');
        $this->data['usuarios_dados'] = $this->usuarios_model->getusuarios('');
        $config['base_url'] = base_url() . 'index.php/pcp/gerenciar/';

        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');

        //--------------------------------------------------------------------------------

        $this->data['dadosFiltros'] = $this->input->post();


        //------------------------------------------------------

        $numPedido = $this->input->post('numPedido');

        $idOs = $this->input->post('idOs');
        if (!empty($this->uri->segment(3))) {
            $idPedidoCompra = $this->uri->segment(3);
        } else {
            $idPedidoCompra = $this->input->post('idPedidoCompra');
        }

        $idPedidoCotacao = $this->input->post('idPedidoCotacao');

        $query_statuscompra = "";
        $idStatuscompras = $this->input->post('idStatuscompras');
        if (!empty($idStatuscompras)) {
            $conteudo = $idStatuscompras;

            if ($idStatuscompras == 'todos') {
                $query_statuscompra = "(1,2,3,4,5,7,8,9,10,11,12,13,14)";
            } else {
                $query_statuscompra = "(" . $idStatuscompras . ")";
            }
        } else {
            //$query_statuscompra = "(1)";
        }
        /*
         $query_idgrupo = "";
         $idgrupo = $this->input->post('idgrupo');
         if(!empty($idgrupo))
         {
             $conteudo = $idgrupo;
         $query_idgrupo="(";
         $primeiro = true;
             foreach($conteudo as $idgrupo3)
             {
                 if($primeiro)
                 {
                     $query_idgrupo.=$idgrupo3;
                     $primeiro = false;
                 }
                 else
                 {
                     $query_idgrupo.=",".$idgrupo3;
                 }
             }
             $query_idgrupo .= ")";
         }*/

        $query_idgrupo = "";
        $idgrupo = $this->input->post('idgrupo');
        if (!empty($idgrupo)) {
            $query_idgrupo = "($idgrupo)";
        }



        $fornecedor_id = $this->input->post('fornecedor_id');
        $nf_fornecedor = $this->input->post('nf_fornecedor');
        $descricao = $this->input->post('descricao');
        $data_entrega = null;
        if (!empty($this->input->post('data_entrega_inicio')) && !empty($this->input->post('data_entrega_fim'))) {
            $data = explode("/", $this->input->post('data_entrega_inicio'));
            $data_entrega_inicio = $data[2] . "-" . $data[1] . "-" . $data[0];

            $data2 = explode("/", $this->input->post('data_entrega_fim'));
            $data_entrega_fim = $data2[2] . "-" . $data2[1] . "-" . $data2[0];
            $data_entrega = " and pedido_comprasitens.datastatusentregue BETWEEN \"$data_entrega_inicio\" and \"$data_entrega_fim\"";
        }

        $query_usuario = "";
        $idUsuarios = $this->input->post('idUsuarios');
        if (!empty($idUsuarios)) {
            $conteudo22 = $idUsuarios;
            $query_usuario = "(";
            $primeiro22 = true;
            foreach ($conteudo22 as $tipouser) {
                if ($primeiro22) {
                    $query_usuario .= $tipouser;
                    $primeiro22 = false;
                } else {
                    $query_usuario .= "," . $tipouser;
                }
            }
            $query_usuario .= ")";
        }
        $unid_execucao = $this->input->post('unid_execucao');
        $query_unid_execucao = "";
        if (!empty($unid_execucao)) {
            $conteudo2 = $unid_execucao;
            $query_unid_execucao = "(";
            $primeiro2 = true;
            foreach ($conteudo2 as $unid_execucao2) {
                if ($primeiro2) {
                    $query_unid_execucao .= $unid_execucao2;
                    $primeiro2 = false;
                } else {
                    $query_unid_execucao .= "," . $unid_execucao2;
                }
            }
            $query_unid_execucao .= ")";
        }
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        //if (!empty($idOs) || !empty($idPedidoCotacao)   || !empty($query_statuscompra) || !empty($idPedidoCompra) || !empty($fornecedor_id) || !empty($nf_fornecedor) || !empty($query_idgrupo) || !empty($query_usuario) || !empty($numPedido) || !empty($empresaNum1) || !empty($empresaNum2) || !empty($descricao)|| !empty($data_entrega)|| !empty($query_unid_execucao)) {
        $this->data['results'] = $this->pedidocompra_model->getComprasRespPCP($idOs, $idPedidoCotacao, $query_statuscompra, $idPedidoCompra, $fornecedor_id, $nf_fornecedor, $query_idgrupo, '', $query_usuario, $numPedido, $empresaNum1, $empresaNum2, $descricao, '', $data_entrega, '', $query_unid_execucao);
        //}        
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
        $this->data['view'] = 'pcp/compra';
        $this->load->view("tema/topo", $this->data);
    }
    function montarpedidocompra()
    {

        $btnGerarCotacao = $this->input->post('btnGerarCotacao');
        $btnAbrirPedidos = $this->input->post('btnAbrirPedidos');
        $btnImprimSelecionados = $this->input->post('btnImprimSelecionados');

        if ($btnGerarCotacao) {
            $this->montarImpressao();
        } elseif ($btnAbrirPedidos) {
            $this->editarpedidosuprimentos();
        } elseif ($btnImprimSelecionados) {
            $this->imprimiritem3();
        } else {
            //$contador=count($this->input->post('idCotacaoItens_'));
            if ($this->input->post('idDistribuir_')[0] < 1) {

                $this->session->set_flashdata('error', 'Nenhum item selecionado!');
                redirect(base_url() . 'index.php/pcp/compra');
            }
            $contador = count($this->input->post('idDistribuir_'));

            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aPedCompra')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para adicionar pedido.');
                redirect(base_url());
            }
            //$this->load->model('orcamentos_model');
            $this->load->library('form_validation');
            $this->data['custom_error'] = '';
            /*
            for($x=0;$x<$contador;$x++)
            {
                if($this->input->post('idStatuscompras_')[$x] != 2 ){
                    $this->session->set_flashdata('error','Você só pode gerar ordem de compra de itens que estão *Aguardando Orçamento* e não possuem *número de Ordem de Compra*!');
                    redirect(base_url() . 'index.php/suprimentos');
                }

            }*/
            for ($x = 0; $x < $contador; $x++) {
                //$this->data['status_atual_valida'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->get('idDistribuir_')[$x]);                        
                $this->data_val['results'] = $this->pedidocompra_model->verificaos($this->input->post('idDistribuir_')[$x]);

                foreach ($this->data_val['results'] as $rs) {
                    if (($rs->idStatuscompras != 2 && $rs->idStatuscompras != 6) || !empty($rs->idPedidoCompra)) {
                        $this->session->set_flashdata('error', 'Você só pode gerar ordem de compra de itens que estão *Aguardando Orçamento ou Cancelados* e não possuem *número de Ordem de Compra*!');
                        redirect(base_url() . 'index.php/pcp/compra');
                    }
                }
            }

            if ($this->input->post('idDistribuir_')[0] < 1) {

                $this->session->set_flashdata('error', 'Selecione pelo menos um item!');
                redirect(base_url() . 'index.php/pcp/compra');
            } else {



                $data = array(
                    'data_cadastro' => date('Y-m-d H:i:s')
                );



                if (is_numeric($id = $this->pedidocompra_model->add('pedido_compras', $data, true))) {

                    $total = 0;

                    for ($x = 0; $x < $contador; $x++) {

                        $this->data['dadoscot'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idDistribuir =' . $this->input->post('idDistribuir_')[$x]);

                        $distri = $this->data['dadoscot']->idDistribuir;

                        $data2 = array(
                            'data_cadastro' => date('Y-m-d H:i:s'),
                            'idCotacaoItens' => $this->data['dadoscot']->idCotacaoItens,

                            'idPedidoCompra' => $id
                        );



                        //verifica se esta reservado estoque
                        $this->data['status_atual'] = $this->pedidocompra_model->gettable('distribuir_os', 'idDistribuir =' . $distri);


                        $idStatuscomprasatual = $this->data['status_atual']->idStatuscompras;


                        if ($idStatuscomprasatual == 7) {
                            $data3 = array(
                                'idStatuscompras' => '7'
                            );
                        } else {

                            $data3 = array(
                                'idStatuscompras' => '3'
                            );
                        }



                        $id_pci = $this->pedidocompra_model->add('pedido_comprasitens', $data2, true);

                        $data5 = array(
                            'idPedidoCompra' => $id,
                            'idPedidoCompraItens' => $id_pci
                        );

                        $this->attDataAlteracao($distri);

                        $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $distri);

                        $this->pedidocompra_model->edit('pedido_cotacaoitens', $data5, 'idDistribuir', $this->input->post('idDistribuir_')[$x]);
                    }

                    $this->session->set_flashdata('success', 'Pedido gerado com sucesso!');
                    //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$id);
                    $idsDistribuirPar = $this->input->post('idDistribuir_');
                    $this->exibirsuprimentoseditados($idsDistribuirPar);
                } else {

                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao gerar pedido.</p></div>';
                }
            }
        }
    }
    public function montarImpressao()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCotacao')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar Cotacao.');
            redirect(base_url());
        }
        //$this->load->model('orcamentos_model');
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $dadosFiltros = $this->input->post();

        $contador = count($this->input->post('idDistribuir_'));

        if ($this->input->post('idDistribuir_')[0] < 1) {

            $this->session->set_flashdata('error', 'Selecione pelo menos um item!');

            redirect(base_url() . 'index.php/pcp/compra');
        } else {
            $this->gerarCotacao();

            $total = 0;

            /*for($x=0;$x<$contador;$x++)
            {          
        
                $idsDistribuir .= '/'.$this->input->post('idDistribuir_')[$x];              
                	
            }*/

            //$this->session->set_flashdata('success','Cotação cadastrada com sucesso!');
            if (!empty($this->uri->segment(3))) {
                $this->visualizarimprimir2($this->input->post('idDistribuir_'), $dadosFiltros);
                //redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$id);
            } else {
                //redirect(base_url() . 'index.php/cotacao/visualizarimprimir/'.$id);
                //redirect(base_url() . 'index.php/suprimentos/visualizarimprimir'.$idsDistribuir);
                $this->visualizarimprimir($this->input->post('idDistribuir_'), $dadosFiltros);
            }
        }
    }
    function editarpedidosuprimentos($idsDistribuirPar = array())
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Pedido de compra.');
            redirect(base_url());
        }
        /*
        $contador = count($this->input->post('idStatuscompras_'));
        for ($x = 0; $x < $contador; $x++) {
            if ($this->input->post('idStatuscompras_')[$x] < 3) {
                $this->session->set_flashdata('error', 'Verifique o(s) statu(s) da(s) Ordem(ns) de Compra(s) que está tentando visualizar!');
                redirect(base_url() . 'index.php/pcp/compra');
            }
        }
        */

        $this->load->library('table');
        $this->load->library('pagination');

        $this->load->model('os_model');
        $this->load->model('orcamentos_model');
        $this->load->model('cotacao_model');

        $config['base_url'] = base_url() . 'index.php/pcp/editarpedido/';

        //trazer maior q  3 o status        
        $this->data['dados_statuscompra'] = $this->pedidocompra_model->getstatus_compra2('0');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
        $this->data['dados_statuscondicao'] = $this->pedidocompra_model->getstatus_cond_pg('');

        $this->data['dadosFiltros'] = $this->input->post();


        if ($this->input->post('idDistribuir_')) {
            $idsDistribuir = $this->input->post('idDistribuir_');
        } elseif (!empty($idsDistribuirPar)) {
            $idsDistribuir = $idsDistribuirPar;
        }


        if ($this->input->post('idDistribuir_')[0] < 1) {

            $this->session->set_flashdata('error', 'Selecione pelo menos um item!');
            redirect(base_url() . 'index.php/pcp/compra');
        }

        //print_r($idsDistribuir); exit;


        $statusValidos = array(1,2,6);
        $idPedidoCompra = $this->uri->segment(3);
        // echo  $rrrr = $this->uri->segment(5);
        if (!empty($this->uri->segment(4))) {
            $statuscompra = $this->uri->segment(4);
        } else {
            $statuscompra = '';
        }

        $this->data['results'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir, '', $statuscompra);
        foreach($this->data['results'] as $r){
            if(in_array($r->idStatuscompras,$statusValidos) ){
                $this->session->set_flashdata('error', 'Verifique o(s) statu(s) da(s) Ordem(ns) de Compra(s) que está tentando visualizar!');
                redirect(base_url() . 'index.php/pcp/compra');
            }
        }
        $this->data['resultsnf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir, '1', $statuscompra);
        $this->data['resultsosf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir, '2', $statuscompra);

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

        $this->data['view'] = 'pcp/editarpedido';
        $this->load->view('tema/topo', $this->data);
        //$this->load->view('tema/rodape');

    }
    function imprimiritem3()
    {

        $idDistribuir = $this->input->post('idDistribuir_');
        $idEmitente2 = $this->input->post('idEmitente');
        //echo("<script>console.log('Emitente: ".$idEmitente2."');</script>");
        if ($this->input->post('idDistribuir_')[0] < 1) {

            $this->session->set_flashdata('error', 'Selecione pelo menos um item!');
            redirect(base_url() . 'index.php/pcp/compra');
        }

        $contadoritens = count($idDistribuir);

        $primeiro = true;
        $itens = '';
        for ($x = 0; $x < $contadoritens; $x++) {

            if ($primeiro) {
                $itens .= $idDistribuir[$x];
                $primeiro = false;
            } else {
                $itens .= "," . $idDistribuir[$x];
            }
        }

        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        //$data['dados_emitente'] = $this->cotacao_model->getEmitente($idEmitente2);
        //$dadosEmitente = $this->cotacao_model->getEmitente($idEmitente2);
        //$dadosPedidoCustom3 = $this->pedidocompra_model->pedidoCustom3($itens);
        //echo("<script>console.log('Emitente: ".$dadosPedidoCustom3."');</script>");
        $data['dados_emitente'] = $this->cotacao_model->getEmitente($idEmitente2);
        $data['result'] = $this->pedidocompra_model->pedidoCustom3($itens);

        $this->load->helper('mpdf');
        echo $html = $this->load->view('suprimentos/imprimir/imprimir_pedido', $data, true);
    }
    public function attDataAlteracao($idDistOS)
    {
        $data3 = array('data_alteracao' => date('Y-m-d H:i:s'));
        $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistOS);
    }

    public function exibirsuprimentoseditados($idsDistribuirPar = null, $data = null)
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Pedido de compra.');
            redirect(base_url());
        }
        //$this->session->set_flashdata('success','Pedido salvo com sucesso.');
        $contador = count($this->input->post('idStatuscompras_'));


        $this->load->library('table');
        $this->load->library('pagination');

        $this->load->model('os_model');
        $this->load->model('orcamentos_model');
        $this->load->model('cotacao_model');

        $config['base_url'] = base_url() . 'index.php/pc/editarpedido/';

        //trazer maior q  3 o status        
        $this->data['dados_statuscompra'] = $this->pedidocompra_model->getstatus_compra2('0');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
        $this->data['dados_statuscondicao'] = $this->pedidocompra_model->getstatus_cond_pg('');
        $this->data['dadosFiltros'] = $data;

        if (!empty($this->session->flashdata('idsDistribuir'))) {
            $idsDistribuir = $this->session->flashdata('idsDistribuir');
        } else if ($this->input->post('idDistribuir_')) {
            $idsDistribuir = $this->input->post('idDistribuir_');
            $this->session->set_flashdata('idsDistribuir', $idsDistribuir);
            redirect(base_url() . 'index.php/pcp/exibirsuprimentoseditados');
        } else if (!empty($idsDistribuirPar)) {
            $idsDistribuir = $idsDistribuirPar;
            $this->session->set_flashdata('idsDistribuir', $idsDistribuirPar);
            redirect(base_url() . 'index.php/pcp/exibirsuprimentoseditados');
        }


        //print_r($idsDistribuir); exit;

        $idPedidoCompra = $this->uri->segment(3);
        // echo  $rrrr = $this->uri->segment(5);
        if (!empty($this->uri->segment(4))) {
            $statuscompra = $this->uri->segment(4);
        } else {
            $statuscompra = '';
        }

        $this->data['results'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir, '', $statuscompra);
        $this->data['resultsnf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir, '1', $statuscompra);
        $this->data['resultsosf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir, '2', $statuscompra);

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

        $this->data['view'] = 'pcp/editarpedido';

        $this->load->view('tema/topo', $this->data);
        //$this->load->view('tema/rodape');
    }
    public function gerarCotacao()
    {
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $contador = count($this->input->post('idDistribuir_'));
        $val_cotacoes = 0;
        for ($x = 0; $x < $contador; $x++) {
            //$this->data['status_atual_valida'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->get('idDistribuir_')[$x]);                         
            $this->data_val['results'] = $this->pedidocompra_model->verificaos($this->input->post('idDistribuir_')[$x]);
            //print_r($this->data['results']); 
            foreach ($this->data_val['results'] as $rs) {
                //echo $rs->idDistribuir;
                //$idOc = $this->data['results']->idPedidoCompra;
                if (($rs->idStatuscompras != 1 &&  $rs->idStatuscompras != 6) || !empty($rs->idPedidoCompra)) {
                    $this->session->set_flashdata('error', 'Não foi possível gerar cotação, verifique se você não selecionou itens que não estão com o status de *Compra Solicitada* ou se já possuem *número de Ordem de Compra*.');
                    redirect(base_url() . 'index.php/pcp/compra');
                }
            }
        }


        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCotacao')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar Cotacao.');
            redirect(base_url());
        }



        //------------------------


        if ($this->input->post('idDistribuir_')[0] < 1) {

            $this->session->set_flashdata('error', 'Selecione pelo menos um item!');

            redirect(base_url() . 'index.php/pcp/compra');
        } elseif ($val_cotacoes != 1) {


            $data = array(
                'data_cadastro' => date('Y-m-d H:i:s')
            );

            if (is_numeric($id = $this->cotacao_model->add('pedido_cotacao', $data, true))) {

                $total = 0;

                for ($x = 0; $x < $contador; $x++) {

                    $data2 = array(
                        'idDistribuir' => $this->input->post('idDistribuir_')[$x],
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'idPedidoCotacao' => $id
                    );

                    //verifica se esta reservado estoque
                    $this->data['status_atual'] = $this->cotacao_model->gettable('distribuir_os', 'idDistribuir =' . $this->input->post('idDistribuir_')[$x]);

                    $idStatuscomprasatual = $this->data['status_atual']->idStatuscompras;

                    if ($idStatuscomprasatual == 7) {
                        $data3 = array(
                            'idStatuscompras' => '7'
                        );
                    } else {

                        $data3 = array(
                            'idStatuscompras' => '2',
                            'idUser_aguardandoOrc' => $this->session->userdata('idUsuarios')
                        );
                    }
                    $this->attDataAlteracao($this->input->post('idDistribuir_')[$x]);

                    $this->cotacao_model->add('pedido_cotacaoitens', $data2, true);
                    $this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $this->input->post('idDistribuir_')[$x]);
                }

                /*
                if(!empty($this->uri->segment(3)))
                {
                    redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$id);
                }
                else
                {
                    redirect(base_url() . 'index.php/suprimentos/visualizarimprimir/'.$id);
                }
                */
            } else {

                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao gerar cotacao.</p></div>';
            }
        }
    }

    function visualizarimprimir2($idsDistribuir, $dadosFiltros)
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCotacao')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar Cotacao.');
            redirect(base_url());
        }

        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->model('os_model');
        $this->load->model('orcamentos_model');

        //$config['base_url'] = base_url().'index.php/cotacao/visualizarimprimir/';

        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();

        //----------------------------------------------------------------------
        $this->data['dadosFiltros'] = $dadosFiltros;

        //----------------------------------------------------------------------



        //$idsPedidoCotacao = $this->uri->segment_array();
        //$i=1;
        $arrayParPedidoCotacao = [];
        foreach ($idsDistribuir as $segment) {
            //if($i > 2 ){
            $arrayParPedidoCotacao[] = $segment;
            //}
            //$i++;
        }
        $parPedidoCotacao = implode(', ', $arrayParPedidoCotacao);

        $this->data['results'] = $this->pedidocompra_model->getWhereLikeos2($parPedidoCotacao);

        /*$this->data['results'] = $this->os_model->get('os','idOs,dataInicial,dataFinal,garantia,descricaoProduto,defeito,status,observacoes,laudoTecnico','',$config['per_page'],$this->uri->segment(3));*/

        $this->data['view'] = 'almoxarifado/visualizarimprimir';
        $this->load->view('tema/topo', $this->data);
        //$this->load->view('tema/rodape');

    }
    function visualizarimprimir($idsDistribuir, $dadosFiltros)
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCotacao')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar Cotacao.');
            redirect(base_url());
        }

        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->model('os_model');
        $this->load->model('orcamentos_model');

        $config['base_url'] = base_url() . 'index.php/cotacao/visualizarimprimir/';

        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();

        //----------------------------------------------------------------------
        $this->data['dadosFiltros'] = $dadosFiltros;

        //----------------------------------------------------------------------



        //$idsPedidoCotacao = $this->uri->segment_array();
        //$i=1;
        $arrayParPedidoCotacao = [];
        foreach ($idsDistribuir as $segment) {
            //if($i > 2 ){
            $arrayParPedidoCotacao[] = $segment;
            //}
            //$i++;
        }
        $parPedidoCotacao = implode(', ', $arrayParPedidoCotacao);

        $this->data['results'] = $this->pedidocompra_model->getWhereLikeos2($parPedidoCotacao);


        $this->data['view'] = 'pcp/visualizarimprimir';
        $this->load->view('tema/topo', $this->data);
    }

    function editarpc()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar PC.');
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $idPedidoCompraItens = $this->input->post('idPedidoCompraItens_');
        $idPedidoCompra_n = $this->input->post('idPedidoCompra_n');






        if (count($this->pedidocompra_model->getqtditens($idPedidoCompra_n)) == 0 || $this->input->post('idPedidoCompra_n') == '') {

            $this->session->set_flashdata('error', 'Informe o número válido do pedido!');
            redirect(base_url() . 'index.php/pcp/compra');
        } else {

            $this->data['dadosped'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $idPedidoCompraItens);


            $idCotacaoItens = $this->data['dadosped']->idCotacaoItens;

            $idPedidoCompra = $this->data['dadosped']->idPedidoCompra;


            if (count($this->pedidocompra_model->getqtditens($idPedidoCompra)) == 1) {
                $this->pedidocompra_model->delete('pedido_compras', 'idPedidoCompra', $idPedidoCompra);
            }

            $data3 = array(
                'idPedidoCompra' => $idPedidoCompra_n

            );


            $this->pedidocompra_model->edit('pedido_cotacaoitens', $data3, 'idCotacaoItens', $idCotacaoItens);

            $data4 = array(
                'idPedidoCompra' => $idPedidoCompra_n

            );

            $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $idPedidoCompraItens);

            $this->data['pedidoCotacaoID'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens = ' . $idCotacaoItens);
            $this->attDataAlteracao($this->data['pedidoCotacaoID']->idDistribuir);
            $this->session->set_flashdata('success', 'Pedido alterado com sucesso!');

            redirect(base_url() . 'index.php/pcp/editarpedido/' . $idPedidoCompra_n);
        }
    }

    public function alterarItens()
    {
        $btnGerar = $this->input->post('btnGerar');
        $btnAlterar = $this->input->post('btnAlterar');

        if ($btnGerar) {
            $this->gerarNovoPedidoCompra();
        } else if ($btnAlterar) {
            $this->alterarItensPedidoCompra();
        }
    }
    public function alterarItensPedidoCompra()
    {
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar PC.');
            redirect(base_url());
        }
        $itens = $this->input->post('alterarDistribuir_');
        $statusCompras = $this->input->post('alterarStatuscompras_');
        if (count($statusCompras) > 0) {
            foreach ($statusCompras as $r) {
                if ($r != 3) {
                    $this->session->set_flashdata('error', 'É permitido alterar apenas os itens com status "Gerou Ordem de Compra".');
                    redirect(base_url() . 'index.php/pcp/compra');
                    return;
                }
            }
        }
        $pedidoCompra = $this->input->post('idPedidoCompra_n');
        if (count($this->pedidocompra_model->getqtditens($pedidoCompra)) == 0 || $this->input->post('idPedidoCompra_n') == '') {
            $this->session->set_flashdata('error', 'Informe o número válido do pedido!');
            redirect(base_url() . 'index.php/pcp/compra');
        }
        if (count($itens) > 0) {
            foreach ($itens as $r) {
                $result = $this->pedidocompra_model->getIdsDisitribuir($r);
                if (!empty($result)) {
                    if ($result[0]->idCotacaoItens != null) {
                        $data2 = array('idPedidoCompra' => $pedidoCompra);
                        $this->pedidocompra_model->edit('pedido_cotacaoitens', $data2, 'idCotacaoItens', $result[0]->idCotacaoItens);
                    }
                    if ($result[0]->idPedidoCompraItens != null) {
                        $data2 = array('idPedidoCompra' => $pedidoCompra);
                        $this->pedidocompra_model->edit('pedido_comprasitens', $data2, 'idPedidoCompraItens', $result[0]->idPedidoCompraItens);
                    }
                    if ($result[0]->idDistribuir != null) {
                        $data1 = array('data_alteracao' => date('Y-m-d H:i:s'));
                        $this->pedidocompra_model->edit('distribuir_os', $data1, 'idDistribuir', $result[0]->idDistribuir);
                    }
                }
                //echo("<script>console.log(".json_encode($result).");</script>");
            }
        }
        $this->session->set_flashdata('success', 'Ordem de compra foi alterado com sucesso.');
        redirect(base_url() . 'index.php/pcp/compra');
    }
    public function gerarNovoPedidoCompra()
    {
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar PC.');
            redirect(base_url());
        }
        $itens = $this->input->post('alterarDistribuir_');
        $statusCompras = $this->input->post('alterarStatuscompras_');
        if (count($statusCompras) > 0) {
            foreach ($statusCompras as $r) {
                if ($r != 3) {
                    $this->session->set_flashdata('error', 'É permitido alterar apenas os itens com status "Gerou Ordem de Compra".');
                    redirect(base_url() . 'index.php/pcp/compra');
                    return;
                }
            }
        }
        $data1 = array('data_cadastro' => date('Y-m-d H:i:s'));
        $novoPC = $this->pedidocompra_model->add('pedido_compras', $data1, true);
        if ($novoPC == "" || $novoPC == null) {
            $this->session->set_flashdata('error', 'Não foi possível criar uma nova ordem de compra.');
            redirect(base_url() . 'index.php/pcp/compra');
        }
        if (count($itens) > 0) {
            foreach ($itens as $r) {
                $result = $this->pedidocompra_model->getIdsDisitribuir($r);
                if (!empty($result)) {
                    if ($result[0]->idCotacaoItens != null) {
                        $data2 = array('idPedidoCompra' => $novoPC);
                        $this->pedidocompra_model->edit('pedido_cotacaoitens', $data2, 'idCotacaoItens', $result[0]->idCotacaoItens);
                    }
                    if ($result[0]->idPedidoCompraItens != null) {
                        $data2 = array('idPedidoCompra' => $novoPC);
                        $this->pedidocompra_model->edit('pedido_comprasitens', $data2, 'idPedidoCompraItens', $result[0]->idPedidoCompraItens);
                    }
                    if ($result[0]->idDistribuir != null) {
                        $data2 = array('data_alteracao' => date('Y-m-d H:i:s'));
                        $this->pedidocompra_model->edit('distribuir_os', $data2, 'idDistribuir', $result[0]->idDistribuir);
                    }
                }
                //echo("<script>console.log(".json_encode($result).");</script>");
            }
        }
        $this->session->set_flashdata('success', 'Ordem de compra criada com sucesso. Os itens foram alterados para a nova ordem de compra: ' . $novoPC);
        redirect(base_url() . 'index.php/pcp/compra');
    }

    function excluir_itempedido()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dPedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir item pedido.');
            redirect(base_url());
        }

        $idPedidoCompraItens =  $this->input->post('idPedidoCompraItens_nn');
        $excluirpedidocompra =  $this->input->post('todos');

        $this->data['dadosped'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $idPedidoCompraItens);

        $idCotacaoItens =  $this->data['dadosped']->idCotacaoItens;
        $idPedidoCompra =  $this->data['dadosped']->idPedidoCompra;

        $this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $idCotacaoItens);

        $idDistribuir =  $this->data['dadosped2']->idDistribuir;
        $idPedidoCotacao = $this->data['dadosped2']->idPedidoCotacao;


        if ($idCotacaoItens == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar excluir item.');
            redirect(base_url() . 'index.php/pcp/compra/' . $idPedidoCompra);
        }

        $data3 = array(
            'idStatuscompras' => '6'
        );

        $data4 = array(
            'idPedidoCompra' => null,
            'idPedidoCompraItens' => null
        );


        if ($excluirpedidocompra == 'nao') {

            $this->attDataAlteracao($idDistribuir);
            $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
            $this->pedidocompra_model->edit('pedido_cotacaoitens', $data4, 'idCotacaoItens', $idCotacaoItens);


            if (count($this->pedidocompra_model->getqtditens($idPedidoCompra)) == 1) {
                $this->pedidocompra_model->delete('pedido_compras', 'idPedidoCompra', $idPedidoCompra);
            }
            $this->pedidocompra_model->delete('pedido_comprasitens', 'idPedidoCompraItens', $idPedidoCompraItens);

            $this->pedidocompra_model->delete('pedido_cotacaoitens', 'idCotacaoItens', $idCotacaoItens);


            $this->session->set_flashdata('success', 'Item excluido com sucesso do pedido!');
            if (count($this->pedidocompra_model->getqtditens($idPedidoCompra)) == 1) {
                redirect(base_url() . 'index.php/pcp/compra/' . $idPedidoCompra);
            } else {
                redirect(base_url() . 'index.php/pcp/compra');
            }
        } else {
            $itenspc = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idPedidoCompra =' . $idPedidoCompra, 1);
            foreach ($itenspc as $r) {
                $idDistribuir2 =  $r->idDistribuir;


                $this->attDataAlteracao($idDistribuir2);
                $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir2);
            }

            $this->pedidocompra_model->edit('pedido_cotacaoitens', $data4, 'idPedidoCompra', $idPedidoCompra);
            $this->pedidocompra_model->delete('pedido_comprasitens', 'idPedidoCompra', $idPedidoCompra);
            $this->pedidocompra_model->delete('pedido_compras', 'idPedidoCompra', $idPedidoCompra);
            $this->pedidocompra_model->delete('pedido_cotacaoitens', 'idPedidoCotacao', $idPedidoCotacao);
            $this->session->set_flashdata('success', 'Pedido excluido com sucesso!');
            redirect(base_url() . 'index.php/pcp/compra');
        }
    }

    public function cancelarItens()
    {
        $itens = $this->input->post('excluirDistribuir_');
        $statusCompras = $this->input->post('excluirStatuscompras_');
        echo ("<script>console.log('E '" . $statusCompras . ");</script>");
        if (count($statusCompras) > 0) {
            foreach ($statusCompras as $r) {
                if ($r == 6 || $r >= 5) {
                    $this->session->set_flashdata('error', 'Você está tentando cancelar um item cancelado ou que já foi entregue.');
                    redirect(base_url() . 'index.php/pcp/compra');
                    return;
                }
            }
        }

        if (count($itens) > 0) {
            foreach ($itens as $r) {
                $result = $this->pedidocompra_model->getIdsDisitribuir($r);
                if (!empty($result)) {
                    if ($result[0]->idCotacaoItens != null) {
                        $this->pedidocompra_model->delete('pedido_cotacaoitens', 'idCotacaoItens', $result[0]->idCotacaoItens);
                    }
                    if ($result[0]->idPedidoCompraItens != null) {
                        $this->pedidocompra_model->delete('pedido_comprasitens', 'idPedidoCompraItens', $result[0]->idPedidoCompraItens);
                    }
                    if ($result[0]->idDistribuir != null) {
                        $data1 = array('data_alteracao' => date('Y-m-d H:i:s'), 'idStatuscompras' => 6);
                        $this->pedidocompra_model->edit('distribuir_os', $data1, 'idDistribuir', $result[0]->idDistribuir);
                    }
                }
                //echo("<script>console.log(".json_encode($result).");</script>");
            }
        }
        $this->session->set_flashdata('success', 'Itens cancelados com sucesso.');
        redirect(base_url() . 'index.php/pcp/compra');
    }
    public function salvaritemcompra()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar item.');
            redirect(base_url());
        }
        $btnSalvar = $this->input->post("btnSalvar");
        $btnAlterar = $this->input->post("btnAlterar");
        if ($btnAlterar) {
            $this->editarpedidocompra();
            return;
        }
        $this->load->model('cotacao_model');
        $this->load->model('estoque_model');

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $contador = count($this->input->post('idPedidoCompraItens'));

        $this->data['dadosFiltros'] = $this->input->post();

        $idsDistribuirPar = $this->input->post('idDistribuir');
        for ($x = 0; $x < $contador; $x++) {
            if ($this->input->post('qtdrecebida')[$x] <= 0) {
                //$json = array("result"=>false,"msggg"=>"Quantidade recebida não pode ser igual a 0.'");
                $this->session->set_flashdata('error', 'Quantidade recebida não pode ser igual a 0.');
                $this->exibirsuprimentoseditados($idsDistribuirPar, $this->data['dadosFiltros']);
                return;
            }
            if (!empty($this->input->post('dataentregue')[$x])) {

                $dataentregue[$x] = explode('/', $this->input->post('dataentregue')[$x]);
                $dataentregue[$x] = $dataentregue[$x][2] . '-' . $dataentregue[$x][1] . '-' . $dataentregue[$x][0];
                // $datafinal = $dataentregue." ".date("H:i:s");
                //$datafinal = date("Y-m-d H:i:s");
                //echo $this->input->post('horaentregue')[$x];

            } else if ($this->input->post('idStatuscompras')[$x] == 5) {
                //$json = array("result"=>false,"msggg"=>"Não é possivel alterar o status para 'Material Entregue' se a 'Data Entregue' estiver vazia.");
                $this->session->set_flashdata('error', 'Não é possivel alterar o status para "Material Entregue" se a "Data Entregue" estiver vazia.');
                $this->exibirsuprimentoseditados($idsDistribuirPar, $this->data['dadosFiltros']);
                return;
            }
        }
        for ($x = 0; $x < $contador; $x++) {


            if (!empty($this->input->post('dataentregue')[$x])) {

                $dataentregue[$x] = explode('/', $this->input->post('dataentregue')[$x]);
                $dataentregue[$x] = $dataentregue[$x][2] . '-' . $dataentregue[$x][1] . '-' . $dataentregue[$x][0];
                // $datafinal = $dataentregue." ".date("H:i:s");
                //$datafinal = date("Y-m-d H:i:s");
                //echo $this->input->post('horaentregue')[$x];

            }


            $valor_unitario = str_replace(".", "", $this->input->post('valor_unitario')[$x]);
            $valor_unitario = str_replace(",", ".", $valor_unitario);
            if (empty($valor_unitario)) {
                $valor_unitario = (float)0.00;
            }

            $ipi_valor = str_replace(".", "", $this->input->post('ipi_valor')[$x]);
            $ipi_valor = str_replace(",", ".", $ipi_valor);
            if (empty($ipi_valor)) {
                $ipi_valor = (float)0.00;
            }

            $valor_produtos = str_replace(".", "", $this->input->post('valor_produtos')[$x]);
            $valor_produtos = str_replace(",", ".", $valor_produtos);

            $valor_icms = str_replace(".", "", $this->input->post('valor_icms')[$x]);
            $valor_icms = str_replace(",", ".", $valor_icms);
            if (empty($valor_icms)) {
                $valor_icms = (float)0.00;
            }

            $statusCompraEtapa = $this->pedidocompra_model->gettable('statuscompras', 'idStatuscompras = ' . $this->input->post('idStatuscompras')[$x]);

            if ($statusCompraEtapa->etapa < 3) {
                $dataStatus = array(
                    'autorizadoCompra' => 0,
                    'idUsuarioAutorizacao' => null,
                    'data_autorizacao' => null
                );
                $this->pedidocompra_model->edit('pedido_comprasitens', $dataStatus, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens')[$x]);
            }

            $porcentagem = false;
            $icms_porcentagem = '0.0000';
            if (!empty($this->input->post('checkPercentagem'))) {
                foreach ($this->input->post('checkPercentagem') as $r) {
                    if ($r == $this->input->post('idPedidoCompraItens')[$x]) {
                        $porcentagem = true;
                    }
                }
            }

            if ($porcentagem) {
                $icms_porcentagem = $valor_icms;
                $valor_icms = ($valor_produtos / (1 - ($valor_icms / 100))) * (($valor_icms / 100));
            }

            if (!empty($this->input->post('dataentregue')[$x])) {

                $data2 = array(
                    'quantidade' => $this->input->post('qtdrecebida')[$x],
                    'id_status_grupo' => $this->input->post('idgrupo')[$x],
                    'datastatusentregue' => $dataentregue[$x],
                    'valor_unitario' => $valor_unitario,
                    'ipi_valor' => $ipi_valor,
                    'valor_total' => $valor_produtos,
                    'icms' => $valor_icms,
                    'porcentagem' => $porcentagem,
                    'icmsPorcentagem' => $icms_porcentagem
                );
            } else {
                $data2 = array(
                    'quantidade' => $this->input->post('qtdrecebida')[$x],
                    'id_status_grupo' => $this->input->post('idgrupo')[$x],

                    'valor_unitario' => $valor_unitario,
                    'ipi_valor' => $ipi_valor,
                    'valor_total' => $valor_produtos,
                    'icms' => $valor_icms,
                    'porcentagem' => $porcentagem,
                    'icmsPorcentagem' => $icms_porcentagem
                );
            }


            $this->pedidocompra_model->edit('pedido_comprasitens', $data2, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens')[$x]);


            $data3 = array(
                'idStatuscompras' => $this->input->post('idStatuscompras')[$x]
            );



            $this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->input->post('idCotacaoItens')[$x]);

            $idDistribuir =  $this->data['dadosped2']->idDistribuir;



            $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
            if ($statusCompraEtapa->etapa < 3) {
                $dataStatusDistri = array(
                    'aprovacaoPCP' => 0,
                    'aprovacaoSUP' => 0,
                    'idUserAprovacao' => null,
                    'idUserAprovacaoSUP' => null
                );
                $this->pedidocompra_model->edit('distribuir_os', $dataStatusDistri, 'idDistribuir', $idDistribuir);
            }

            //se a qtd recebida for menor q a solicitada, vai abrir outro item de compra
            $this->data['dadosped3'] = $this->pedidocompra_model->gettable('distribuir_os', 'idDistribuir =' . $idDistribuir);
            if ($this->input->post('qtdrecebida')[$x] > 0) {
                if ($this->input->post('qtdrecebida')[$x] < $this->data['dadosped3']->quantidade) {
                    $qtd_nova =   $this->data['dadosped3']->quantidade - $this->input->post('qtdrecebida')[$x];

                    //add nova item

                    $data55 = array(
                        'idInsumos' => $this->data['dadosped3']->idInsumos,
                        'dimensoes' => $this->data['dadosped3']->dimensoes,
                        'solicitacao' => $this->data['dadosped3']->solicitacao,
                        'id_status_grupo' => $this->data['dadosped3']->id_status_grupo,
                        'idProdutos' => $this->data['dadosped3']->idProdutos,
                        'idOsSub' => $this->data['dadosped3']->idOsSub,
                        'idUserAprovacao' => $this->data['dadosped3']->idUserAprovacao,
                        'idUserAprovacaoSUP' => $this->data['dadosped3']->idUserAprovacaoSUP,
                        'aprovacaoPCP' => $this->data['dadosped3']->aprovacaoPCP,
                        'aprovacaoSUP' => $this->data['dadosped3']->aprovacaoSUP,
                        'finalizado' => $this->data['dadosped3']->finalizado,
                        'metrica' => $this->data['dadosped3']->metrica,
                        'volume' => $this->data['dadosped3']->volume,
                        'peso' => $this->data['dadosped3']->peso,
                        'comprimento' => $this->data['dadosped3']->comprimento,
                        'dimensoesL' => $this->data['dadosped3']->dimensoesL,
                        'dimensoesC' => $this->data['dadosped3']->dimensoesC,
                        'dimensoesA' => $this->data['dadosped3']->dimensoesA,
                        'data_cadastro' => $this->data['dadosped3']->data_cadastro,
                        'obs' => $this->data['dadosped3']->obs,
                        'histo_alteracao' => $this->data['dadosped3']->histo_alteracao,
                        'idStatuscompras' => 4,
                        'usuario_cadastro' => $this->data['dadosped3']->usuario_cadastro,
                        'quantidade' => $qtd_nova,
                        'idOs' => $this->data['dadosped3']->idOs
                    );
                    $id_pci = $this->pedidocompra_model->add('distribuir_os', $data55, true);

                    $idsDistribuirPar[] = $id_pci;

                    $data3_ = array(

                        'quantidade' => $this->input->post('qtdrecebida')[$x]

                    );

                    //update na tb
                    $this->pedidocompra_model->edit('distribuir_os', $data3_, 'idDistribuir', $idDistribuir);
                    $this->attDataAlteracao($idDistribuir);
                    $data4 = array(

                        'id_distribuir' => $idDistribuir,
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'quantidade' => $this->data['dadosped3']->quantidade

                    );

                    $this->pedidocompra_model->add('distribuir_os_hist', $data4, true);


                    $dataco = array(
                        'data_cadastro' => $this->data['dadosped2']->data_cadastro,
                        'idDistribuir' => $id_pci,
                        'idPedidoCotacao' => $this->data['dadosped2']->idPedidoCotacao,
                        'idPedidoCompra' => $this->data['dadosped2']->idPedidoCompra


                    );
                    $cot = $this->pedidocompra_model->add('pedido_cotacaoitens', $dataco, true);

                    //aqui calcula valor total		


                    $this->data['dados_'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idCotacaoItens =' . $this->input->post('idCotacaoItens')[$x]);

                    $valor_total_calc = $this->data['dados_']->valor_unitario * $this->input->post('qtdrecebida')[$x];
                    if ($this->data['dados_']->ipi_valor <> 0.00) {
                        $calc = ($this->data['dados_']->ipi_valor) / 100 * $valor_total_calc;
                        $valor_total_calc = $valor_total_calc + $calc;
                    }


                    $data__ = array(

                        'valor_total' => $valor_total_calc

                    );
                    $this->pedidocompra_model->edit('pedido_comprasitens', $data__, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens')[$x]);

                    $valor_total_calc2 = $this->data['dados_']->valor_unitario * $qtd_nova;
                    if ($this->data['dados_']->ipi_valor <> 0.00) {
                        $calc = ($this->data['dados_']->ipi_valor) / 100 * $valor_total_calc2;
                        $valor_total_calc2 = $valor_total_calc2 + $calc;
                    }

                    $dataAtualMais1 = new DateTime();
                    $dataAtualMais1->modify('+1 day');

                    $datacom = array(
                        'data_cadastro' => $this->data['dados_']->data_cadastro,
                        'idPedidoCompra' => $this->data['dados_']->idPedidoCompra,
                        'idCotacaoItens' => $cot,
                        'valor_unitario' => $this->data['dados_']->valor_unitario,
                        'ipi_valor' => $this->data['dados_']->ipi_valor,
                        'valor_total' => $valor_total_calc2,
                        'previsao_entrega' => $dataAtualMais1->format('Y-m-d'),


                        'id_status_grupo' => $this->data['dados_']->id_status_grupo,
                        'idCondPgto' => $this->data['dados_']->idCondPgto,
                        'cod_pgto' => $this->data['dados_']->cod_pgto,
                        'icms' => $this->data['dados_']->icms,
                        'autorizadoCompra ' => $this->data['dados_']->autorizadoCompra,
                        'idUsuarioAutorizacao' => $this->data['dados_']->idUsuarioAutorizacao

                    );

                    $compraitem = $this->pedidocompra_model->add('pedido_comprasitens', $datacom, true);

                    $datadd = array(

                        'idPedidoCompraItens' => $compraitem

                    );

                    //update na tb
                    $this->pedidocompra_model->edit('pedido_cotacaoitens', $datadd, 'idCotacaoItens', $cot);


                    $this->session->set_flashdata('success', 'Foi gerada novo item.');
                }
            }


            //Exclui pedido de compra e permite nova ordem de compra caso o estatus mude para Compra solicitada ou Aguardando Orçamento
            $data56 = array(
                'idPedidoCompra' => NULL,
                'idPedidoCompraItens' => NULL
            );
            if ($this->input->post('idStatuscompras')[$x] == 1) {
                //$this->pedidocompra_model->delete('pedido_compras','idPedidoCompra',$idPedidoCompra);
                $this->pedidocompra_model->delete('pedido_comprasitens', 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens')[$x]);
                //$this->cotacao_model->delete('pedido_cotacao','idPedidoCotacao',$idPedidoCotacao); 
                $this->cotacao_model->delete('pedido_cotacaoitens', 'idCotacaoItens', $this->input->post('idCotacaoItens')[$x]);
            } elseif ($this->input->post('idStatuscompras')[$x] == 2) {
                $this->pedidocompra_model->delete('pedido_comprasitens', 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens')[$x]);
                $this->cotacao_model->edit('pedido_cotacaoitens', $data56, 'idCotacaoItens', $this->input->post('idCotacaoItens')[$x]);
            }
            $redireciona = 'editarPedido';
            if ($contador <= 1 && ($this->input->post('idStatuscompras')[$x] == 1 || $this->input->post('idStatuscompras')[$x] == 2)) {
                $redireciona = 'filtrosSuprimentos';
            }
            $ok = false;
            if (empty($valor_unitario)) {
                $valor_unitario = 0;
            }
            if ($this->input->post('idStatuscompras')[$x] == 5 && $this->input->post('qtdrecebida')[$x] > 0 && ($this->data['dadosped3']->idOs == 10 || $this->data['dadosped3']->idOs == 11 || $this->data['dadosped3']->idOs == 12)) {
                $ok = true;
                if ($this->data['dadosped3']->idOs == 10) {
                    $idEmitente3 = 1;
                } else if ($this->data['dadosped3']->idOs == 11) {
                    $idEmitente3 = 2;
                } else if ($this->data['dadosped3']->idOs == 12) {
                    $idEmitente3 = 3;
                }
                $dataAgArmaz = array(
                    'idStatusAgArmaz' => 2,
                    'idDistribuirOs' => $this->input->post('idDistribuir')[$x],
                    'valorUnitario' => $valor_unitario,
                    'idUsuario' => $this->session->userdata('idUsuarios'),
                    'idInsumo' => $this->data['dadosped3']->idInsumos,
                    'idEmitente' => $idEmitente3,
                    'metrica' => '0',
                    'quantidade' => $this->input->post('qtdrecebida')[$x],
                    'idOrdemCompra' => $this->data['dadosped2']->idPedidoCompra,
                    'data_entregue' => $dataentregue[$x]
                );
                $this->load->model('almoxarifado_model', '', TRUE);
                $result = $this->almoxarifado_model->getAgArmaz($this->input->post('idDistribuir')[$x]);
                if (empty($result)) {
                    $this->almoxarifado_model->insertAgArmaz($dataAgArmaz);
                }
            }
        } //final do for 


        //$this->session->set_flashdata('success','Pedido salvo com sucesso.');
        //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$this->input->post('idPedidoCompra'));
        if ($redireciona == 'editarPedido') {
            $this->session->set_flashdata('success', 'Pedido salvo com sucesso.');
            $this->exibirsuprimentoseditados($idsDistribuirPar, $this->data['dadosFiltros']);
            return;
        } else {
            redirect(base_url() . 'index.php/pcp/compra');
        }
    }

    function editarpedidocompra()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar PC.');
            redirect(base_url());
        }
        //$this->load->model('orcamentos_model');
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $idPedidoCompraItens = "";
        $idPedidoCompraItens = $this->input->post('idPedidoCompraItens');
        //echo("<script>console.log('List'".implode(",",$idDistribuirOS).");</script>");


        $idPedidoCompra = $this->input->post('idPedidoCompra');


        if ($this->input->post('fornecedor_id') <> '') {
            $fornecedor_id = $this->input->post('fornecedor_id');
        } else {
            $fornecedor_id = null;
        }

        if ($this->input->post('emitente_id') <> '') {
            $emitente_id = $this->input->post('emitente_id');
        } else {
            $emitente_id = null;
        }


        /*if($this->input->post('notafiscal') <> '')
        {
            $notafiscal = $this->input->post('notafiscal');
        }
        else
        {
            $notafiscal = null;
        }
        if($this->input->post('datanf') <> '')
        {
            $datanf = explode('/', $this->input->post('datanf'));
        $datanf = $datanf[2].'-'.$datanf[1].'-'.$datanf[0];		
        }
        else{
            $datanf = null;
        }
        */
        $frete = str_replace(".", "", $this->input->post('freteit'));
        $frete = str_replace(",", ".", $frete);
        if ($frete == '') {
            $frete = '0.00';
        }
        $icms = str_replace(".", "", $this->input->post('icmsit'));
        $icms = str_replace(",", ".", $icms);
        if ($icms == '') {
            $icms = '0.00';
        }


        $data3 = array(
            'idFornecedores' => $fornecedor_id,
            'idEmitente' => $emitente_id,
            'frete' => $frete/*,
            'icms' => $icms*/
        );


        $this->pedidocompra_model->edit('pedido_compras', $data3, 'idPedidoCompra', $idPedidoCompra);

        //-------------------------------------------------------------------------------------------------

        //$contadoripi=count($idPedidoCompra);  		 		 

        $desconto = str_replace(".", "", $this->input->post('descontoit'));
        $desconto = str_replace(",", ".", $desconto);
        if ($desconto == '') {
            $desconto = '0.00';
        }
        /*$ipi = str_replace(".","",$this->input->post('ipi'));
        $ipi = str_replace(",",".",$ipi);
        if($ipi == '')
        {
            $ipi = '0.00';
        }*/
        $outros = str_replace(".", "", $this->input->post('outrosit'));
        $outros = str_replace(",", ".", $outros);
        if ($outros == '') {
            $outros = '0.00';
        }

        if ($this->input->post('previsao_entrega') <> '') {
            $previsao_entrega = explode('/', $this->input->post('previsao_entrega'));
            $previsao_entrega = $previsao_entrega[2] . '-' . $previsao_entrega[1] . '-' . $previsao_entrega[0];
        } else {
            $previsao_entrega = null;
        }
        if ($this->input->post('idCondPgto') <> '') {
            $idCondPgto = $this->input->post('idCondPgto');
        } else {
            $idCondPgto = null;
        }
        if ($this->input->post('cod_pgto') <> '') {
            $cod_pgto = $this->input->post('cod_pgto');
        } else {
            $cod_pgto = null;
        }
        if ($this->input->post('obs') <> '') {
            $obs = $this->input->post('obs');
        } else {
            $obs = null;
        }

        if ($this->input->post('prazo_entrega') <> '') {
            $prazo_entrega = $this->input->post('prazo_entrega');
        } else {
            $prazo_entrega = null;
        }

        if (!empty($this->input->post('datanf'))) {
            $datanf = explode('/', $this->input->post('datanf'));
            $datanf = $datanf[2] . '-' . $datanf[1] . '-' . $datanf[0];
        } else {
            $datanf = null;
        }

        if (!empty($this->input->post('nf'))) {
            $nf = $this->input->post('nf');
        } else {
            $nf = null;
        }



        $idPedidoCompraipi    = $this->input->post('idPedidoCompraipi');
        if (!empty($previsao_entrega)) {
            $data3 = array('previsao_entrega' => $previsao_entrega);

            foreach ($idPedidoCompraItens as $distrOS) {
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        if (!empty($prazo_entrega)) {
            $data3 = array('prazo_entrega' => $prazo_entrega);

            foreach ($idPedidoCompraItens as $distrOS) {
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        if (!empty($idCondPgto)) {
            $data3 = array('idCondPgto' => $idCondPgto);

            foreach ($idPedidoCompraItens as $distrOS) {
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        if (!empty($cod_pgto)) {
            $data3 = array('cod_pgto' => $cod_pgto);

            foreach ($idPedidoCompraItens as $distrOS) {
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        if (!empty($obs)) {
            $data3 = array('obs' => $obs);

            foreach ($idPedidoCompraItens as $distrOS) {
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        if (!empty($datanf)) {
            $data3 = array('datanf' => $datanf);

            foreach ($idPedidoCompraItens as $distrOS) {
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        if (!empty($nf)) {
            $data3 = array('notafiscal' => $nf);

            foreach ($idPedidoCompraItens as $distrOS) {
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
            }

            $this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->data['dados3']->idCotacaoItens);
            $idDistribuir =  $this->data['dadosped2']->idDistribuir;
            $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
            $this->attDataAlteracao($idDistribuir);
        }
        if (!empty($desconto)) {
            $data3 = array('desconto' => $desconto);

            foreach ($idPedidoCompraItens as $distrOS) {
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        if (!empty($outros)) {
            $data3 = array('outros' => $outros);

            foreach ($idPedidoCompraItens as $distrOS) {
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        if (!empty($frete)) {
            $data3 = array('frete' => $frete);

            foreach ($idPedidoCompraItens as $distrOS) {
                //$this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);  
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idCotacaoItens =' . $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        /*
        if( !empty($icms))
        {
            $data3 = array('icms' => $icms );
            
            foreach($idPedidoCompraItens as $distrOS){
                //$this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }*/


        $this->session->set_flashdata('success', 'Pedido alterado com sucesso!');
        //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra);
        $idsDistribuirPar = $this->input->post('idDistribuir_');
        $this->exibirsuprimentoseditados($idsDistribuirPar, '');
    }

    function reservaritensalmoxarifado()
    {
        $this->load->model('almoxarifado_model');
        $empresa = $this->input->post('empresa');
        $estoque = $this->input->post('retiradaEstoque');
        $quantidadeTotal = $this->input->post('quantidadeTotal');
        $insumo = $this->input->post('insumo');
        $distribuir = $this->pedidocompra_model->getInsumosByPedidoComprasItens($this->input->post('idprodutocompraitens'));
        for ($x = 0; $x < count($estoque); $x++) {
            if (!empty($estoque[$x])) {
                if ($distribuir->quantidade < $estoque[$x]) {
                    $this->session->set_flashdata('error', 'A quantidade informada é maior do que a quantidade solicitada para a compra.');
                    $this->exibirsuprimentoseditados($this->input->post('idDistribuir'));
                    return;
                }
                if ($estoque[$x] > $quantidadeTotal[$x]) {
                    $this->session->set_flashdata('error', 'A quantidade informada é maior do que a quantidade em estoque.');
                    $this->exibirsuprimentoseditados($this->input->post('idDistribuir'));
                    return;
                }
            }
        }
        for ($x = 0; $x < count($empresa); $x++) {
            if (!empty($estoque[$x])) {
                $resultEstq = $this->almoxarifado_model->getEstoqueByIdEmitenteAndIdInsumo($empresa[$x], $insumo[$x]);
                if ($resultEstq[0]->quantidade >= $estoque[$x]) {
                    $newQuantidade = $resultEstq[0]->quantidade - $estoque[$x];
                    $data = array(
                        'quantidade' => $newQuantidade
                    );
                    $this->pedidocompra_model->edit('almo_estoque', $data, 'idAlmoEstoque', $resultEstq[0]->idAlmoEstoque);
                    $data2 = $resultEstq[0];
                    $data2->idAlmoEstoque = null;
                    $data2->quantidade = $estoque[$x];
                    $data2->idOs = $distribuir->idOs;
                    if (empty($data2->idLocal)) {
                        $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal is null";
                    } else {
                        $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal = $data2->idLocal";
                    }
                    echo ("<script>console.log('" . $where . "');</script>");
                    $getEstoque =  $this->pedidocompra_model->get('almo_estoque', $where);
                    if (!empty($getEstoque)) {
                        $quantidade = $getEstoque->quantidade + $estoque[$x];
                        $data3 = array('quantidade' => $quantidade);
                        $this->pedidocompra_model->edit('almo_estoque', $data3, 'idAlmoEstoque', $getEstoque->idAlmoEstoque);
                    } else {
                        $this->pedidocompra_model->add('almo_estoque', $data2);
                    }
                } else {
                    $count = 0;
                    $acabou = false;
                    while ($estoque[$x] > 0 && $acabou == false) {
                        if ($resultEstq[$count]->quantidade >= $estoque[$x]) {
                            $newQuantidade = $resultEstq[$count]->quantidade - $estoque[$x];
                            $data = array(
                                'quantidade' => $newQuantidade
                            );
                            $this->pedidocompra_model->edit('almo_estoque', $data, 'idAlmoEstoque', $resultEstq[$count]->idAlmoEstoque);
                            $data2 = $resultEstq[$count];
                            $data2->idAlmoEstoque = null;
                            $data2->quantidade = $estoque[$x];
                            $data2->idOs = $distribuir->idOs;
                            if (empty($data2->idLocal)) {
                                $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal is null";
                            } else {
                                $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal = $data2->idLocal";
                            }
                            echo ("<script>console.log('" . $where . "');</script>");
                            $getEstoque =  $this->pedidocompra_model->get('almo_estoque', $where);
                            if (!empty($getEstoque)) {
                                $quantidade = $getEstoque->quantidade + $estoque[$x];
                                $data3 = array('quantidade' => $quantidade);
                                $this->pedidocompra_model->edit('almo_estoque', $data3, 'idAlmoEstoque', $getEstoque->idAlmoEstoque);
                            } else {
                                $this->pedidocompra_model->add('almo_estoque', $data2);
                            }

                            $acabou = true;
                        } else {
                            $estoque[$x] = $estoque[$x] - $resultEstq[$count]->quantidade;
                            $data = array(
                                'quantidade' => 0
                            );
                            $this->pedidocompra_model->edit('almo_estoque', $data, 'idAlmoEstoque', $resultEstq[$count]->idAlmoEstoque);
                            $data2 = $resultEstq[$count];
                            $data2->idAlmoEstoque = null;
                            $data2->idOs = $distribuir->idOs;
                            if (empty($data2->idLocal)) {
                                $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal is null";
                            } else {
                                $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal = $data2->idLocal";
                            }
                            echo ("<script>console.log('" . $where . "');</script>");
                            $getEstoque =  $this->pedidocompra_model->get('almo_estoque', $where);
                            if (!empty($getEstoque)) {
                                $quantidade = $getEstoque->quantidade + $resultEstq[$count]->quantidade;
                                $data3 = array('quantidade' => $quantidade);
                                $this->pedidocompra_model->edit('almo_estoque', $data3, 'idAlmoEstoque', $getEstoque->idAlmoEstoque);
                            } else {
                                $this->pedidocompra_model->add('almo_estoque', $data2);
                            }
                        }
                    }
                }
            }
        }
        $this->exibirsuprimentoseditados($this->input->post('idDistribuir'));
    }
    function imprimiritem()
    {

        $contadoripi = count($this->input->post('idPedidoCompraItensipi'));

        $idPedidoCompraipi    = $this->input->post('idPedidoCompraipi');
        $tipo = gettype($idPedidoCompraipi);

        if ($tipo == 'array') {
            $primero = true;
            foreach ($idPedidoCompraipi as $idspc) {
                if ($primero) {
                    $idPedidoCompraipi = $idspc;
                    $primero = false;
                } else {
                    $idPedidoCompraipi .= "," . $idspc;
                }
            }
        }

        $itens = '';
        $primeiro = true;
        for ($x = 0; $x < $contadoripi; $x++) {

            if ($primeiro) {
                $itens .= $this->input->post('idPedidoCompraItensipi')[$x];
                $primeiro = false;
            } else {
                $itens .= "," . $this->input->post('idPedidoCompraItensipi')[$x];
            }
        }

        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');

        $data['result'] = $this->pedidocompra_model->pedidoCustom($idPedidoCompraipi, $itens);
        if (empty($data['result'][0]->imagem)) {
            $idsDistribuirPar = $this->input->post('idDistribuir');
            $this->session->set_flashdata('error', 'Não é possivel imprimir ordens de compra sem informar a empresa e fornecedor.');
            $this->exibirsuprimentoseditados($idsDistribuirPar, null);
        } else {
            $this->load->helper('mpdf');
            //redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompraipi);			
            echo $html = $this->load->view('suprimentos/imprimir/imprimir_pedido', $data, true);
        }
    }

    function editar_ipi()
    {

        $idsDistribuirPar = $this->input->post('idDistribuir_ipi');

        $contadoripi = count($this->input->post('idPedidoCompraItensipi'));

        $valoripi = str_replace(".", "", $this->input->post('valoripi'));
        $valoripi = str_replace(",", ".", $valoripi);

        if ($this->input->post('dataentregue2')) {
            $dataentregue2 = explode('/', $this->input->post('dataentregue2'));
            $dataentregue2 = $dataentregue2[2] . '-' . $dataentregue2[1] . '-' . $dataentregue2[0];
        }



        $idStatuscompras2 = $this->input->post('idStatuscompras2');

        //$idPedidoCompraipi = $this->input->post('idPedidoCompraipi');	

        for ($x = 0; $x < $contadoripi; $x++) {

            $this->data['dist'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens', 'idPedidoCompraItens =' . $this->input->post('idPedidoCompraItensipi')[$x]);

            $pedidoCompra = $this->pedidocompra_model->gettable('pedido_comprasitens', 'idPedidoCompraItens =' . $this->input->post('idPedidoCompraItensipi')[$x]);

            //if ($pedidoCompra->autorizadoCompra == 1) {
                $dist = $this->data['dist']->idDistribuir;

                if (!empty($this->input->post('valoripi'))) {
                    $data2 = array(

                        'ipi_valor' => $valoripi
                    );
                    $this->pedidocompra_model->edit('pedido_comprasitens', $data2, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
                }

                if (!empty($this->input->post('dataentregue2'))) {
                    $data3 = array(
                        'datastatusentregue' => $dataentregue2
                    );

                    $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
                }
                /*if( !empty($this->input->post('datanf')) && !empty($this->input->post('nf')))
                        {
                            $data4 = array(
                   
                    'datanf' => $datanf,
                    'notafiscal' => $nf
                );
                $this->pedidocompra_model->edit('pedido_comprasitens', $data4, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
                }*/
                if (!empty($this->input->post('idStatuscompras2'))) {
                    $data4 = array(

                        'idStatuscompras' => $idStatuscompras2
                    );
                    $this->pedidocompra_model->edit('distribuir_os', $data4, 'idDistribuir', $dist);
                    $this->attDataAlteracao($dist);
                    if ($this->input->post('idStatuscompras2') == 1 || $this->input->post('idStatuscompras2') == 2 || $this->input->post('idStatuscompras2') == 6) {
                        if ($this->input->post('idStatuscompras2') == 1 || $this->input->post('idStatuscompras2') == 6) {
                            $pedidocompraitens2 = $this->pedidocompra_model->getPedidoCompraItensByIdDistribuir($dist);
                            foreach ($pedidocompraitens2 as $v) {
                                $pedidocompraitens3 = $this->pedidocompra_model->getPedidoCompraItensByIdCotacaoItem($v->idCotacaoItens);
                                foreach ($pedidocompraitens3 as $b) {
                                    $this->pedidocompra_model->delete('pedido_comprasitens', 'idPedidoCompraItens', $b->idPedidoCompraItens);
                                }
                                $this->pedidocompra_model->delete('pedido_cotacaoitens', 'idCotacaoItens', $v->idCotacaoItens);
                            }
                        }
                        if ($this->input->post('idStatuscompras2') == 2) {
                            $pedidocompraitens2 = $this->pedidocompra_model->getPedidoCompraItensByIdDistribuir($dist);
                            foreach ($pedidocompraitens2 as $v) {
                                $pedidocompraitens3 = $this->pedidocompra_model->getPedidoCompraItensByIdCotacaoItem($v->idCotacaoItens);
                                foreach ($pedidocompraitens3 as $b) {
                                    $this->pedidocompra_model->delete('pedido_comprasitens', 'idPedidoCompraItens', $b->idPedidoCompraItens);
                                }
                                $edit = array(
                                    'idPedidoCompra' => null,
                                    'idPedidoCompraItens' => null
                                );
                                $this->pedidocompra_model->edit("pedido_cotacaoitens", $edit, "idCotacaoItens", $v->idCotacaoItens);
                            }
                        }
                    }
                }

                if (!empty($this->input->post('nNotaFiscal2'))) {
                    $data5 = array(

                        'notafiscal' => $this->input->post('nNotaFiscal2')
                    );
                    //Id 5 para material recebido
                    /*$data6 = array(               
                        'idStatuscompras' => 5
                    );*/

                    $this->pedidocompra_model->edit('pedido_comprasitens', $data5, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
                    //$this->pedidocompra_model->edit('distribuir_os', $data6, 'idDistribuir', $dist);
                    $this->attDataAlteracao($dist);
                }
            //}
        }

        $this->session->set_flashdata('success', 'Dados alterado com sucesso!');
        //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompraipi);
        $this->exibirsuprimentoseditados($idsDistribuirPar);
    }

    function editar_1()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar PC.');
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $id_item_pc1 = $this->input->post('id_item_pc1');
        $idPedidoCompra = $this->input->post('idPedidoCompra');
        $this->load->model('cotacao_model');
        if ($this->input->post('id_item_pc1') == '') {
            $this->session->set_flashdata('error', 'Erro ao editar!');
            redirect(base_url() . 'index.php/pcp/editarpedido/' . $idPedidoCompra);
        } else {
            $data3 = array(
                'liberado_edit_compras' => '1'
            );
            $this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $id_item_pc1);
            $this->session->set_flashdata('success', 'Item Liberado com sucesso!');
            redirect(base_url() . 'index.php/pcp/editarpedido/' . $idPedidoCompra);
        }
    }

    function editar_0()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'ePedCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar PC.');
            redirect(base_url());
        }
        //$this->load->model('orcamentos_model');
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $id_item_pc2 = $this->input->post('id_item_pc2');
        $idPedidoCompra = $this->input->post('idPedidoCompra');
        $this->load->model('cotacao_model');
        if ($this->input->post('id_item_pc2') == '') {
            $this->session->set_flashdata('error', 'Erro ao editar!');
            redirect(base_url() . 'index.php/pcp/editarpedido/' . $idPedidoCompra);
        } else {
            $data3 = array(
                'liberado_edit_compras' => '0'
            );
            $this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $id_item_pc2);
            $this->session->set_flashdata('success', 'Item Liberado com sucesso!');
            redirect(base_url() . 'index.php/pcp/editarpedido/' . $idPedidoCompra);
        }
    }
    function editarpedido(){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para editar Pedido de compra.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
         
        $this->load->model('os_model');
		$this->load->model('orcamentos_model');		 
		$this->load->model('cotacao_model');		 
         
        $config['base_url'] = base_url().'index.php/suprimentos/editarpedido/';
        //trazer maior q  3 o status        
        $this->data['dados_statuscompra'] = $this->pedidocompra_model->getstatus_compra2('0');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
        $this->data['dados_statuscondicao'] = $this->pedidocompra_model->getstatus_cond_pg('');
		 
         
        $idPedidoCompra = $this->uri->segment(3);
        // echo  $rrrr = $this->uri->segment(5);
		if(!empty($this->uri->segment(4)))
		{	
					 
			$statuscompra = $this->uri->segment(4);
		}
		else
		{
			$statuscompra = '';
		}	
		
		$this->data['results'] = $this->pedidocompra_model->getpedidocomprafornece($idPedidoCompra,'',$statuscompra);
		$this->data['resultsnf'] = $this->pedidocompra_model->getpedidocomprafornece($idPedidoCompra,'1',$statuscompra);
		$this->data['resultsosf'] = $this->pedidocompra_model->getpedidocomprafornece($idPedidoCompra,'2',$statuscompra);
         
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
       
	    $this->data['view'] = 'pcp/editarpedido';
        
       	$this->load->view('tema/topo',$this->data);
            
        //$this->load->view('tema/rodape');
		
    }
    function alterarlimite(){
        $idDistribuir = $this->input->post("idDistribuir");
        if(!empty($this->input->post("data"))){
            $data = $this->input->post("data");
            $data = DateTime::createFromFormat('d/m/Y',  $data);
            if($data && $data->format('d/m/Y') == $this->input->post("data")){
                $data = explode("/",$this->input->post('data'));
                $data_limite = $data[2]."-".$data[1]."-".$data[0];
                $dataArray = array("data_limite"=>$data_limite);
                $this->pedidocompra_model->edit("distribuir_os",$dataArray,"idDistribuir",$idDistribuir);
                echo json_encode(array("result"=>true));
                return;
            }else{
                echo json_encode(array("result"=>false));
                return;
            }
        }else{
            $dataArray = array("data_limite"=>NULL);
            $this->pedidocompra_model->edit("distribuir_os",$dataArray,"idDistribuir",$idDistribuir);
            echo json_encode(array("result"=>true));
            return;
        }
        
    }
}
