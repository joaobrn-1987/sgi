<?php

class Os extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('os_model', '', TRUE);


        if (empty($this->uri->segment(2))) {
            $this->data['menuOs'] = 'OS';
        } elseif ($this->uri->segment(2) == 'visualizar') {
            $this->data['menuOs'] = 'OS';
        } elseif ($this->uri->segment(2) == 'distribuiros') {
            $this->data['menuOs'] = 'OS';
        } elseif($this->uri->segment(2) == 'ordemservico_pcp'){
            $this->data['menuPcp'] = 'PCP';
        }else{
            //$this->uri->segment(2) == 'almoxarifado'
            $this->data['menucarteira'] = 'Carteira de Serviço';
        }
    }

    function index()
    {
        $this->gerenciar();
    }


    // Método privado para validar datas (agora dentro da classe)
    private function _validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        // Verifica se a data foi criada E se a data formatada de volta é igual à original
        return $d && $d->format($format) === $date;
    }


    function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
            redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->helper('global_function');
        $this->load->helper('date'); // Carrega o helper de data

        // --- INÍCIO: LÓGICA DO FILTRO DE DATA ---
        $dataInicialcad = $this->input->post('dataInicialcad'); // Recebe YYYY-MM-DD do input type="date"
        $dataFinalcad = $this->input->post('dataFinalcad');     // Recebe YYYY-MM-DD do input type="date"
        $filtroSubmetido = $this->input->post('filter');

        // Define o período padrão (últimos 60 dias) se nenhum filtro de data foi enviado
        $dataInicialParaView = '';
        $dataFinalParaView = '';
        if (empty($dataInicialcad) && empty($dataFinalcad) && !$filtroSubmetido) {
            $dataFinalcad   = date('Y-m-d'); // Hoje no formato YYYY-MM-DD
            $dataInicialcad = date('Y-m-d', strtotime('-10 days')); // 60 dias atrás no formato YYYY-MM-DD
            // Define as datas para a view no formato DD/MM/YYYY
            $dataFinalParaView = date('d/m/Y');
            $dataInicialParaView = date('d/m/Y', strtotime('-60 days'));
        } else {
            // Se as datas vieram do POST, converte para DD/MM/YYYY para a view
             if (!empty($dataInicialcad)) {
                 try { $dataInicialParaView = DateTime::createFromFormat('Y-m-d', $dataInicialcad)->format('d/m/Y'); } catch (Exception $e) {$dataInicialParaView = '';}
             }
             if (!empty($dataFinalcad)) {
                 try { $dataFinalParaView = DateTime::createFromFormat('Y-m-d', $dataFinalcad)->format('d/m/Y'); } catch (Exception $e) {$dataFinalParaView = '';}
             }
        }

        // Passa as datas para a view (no formato DD/MM/YYYY)
        $this->data['data_filtro'] = [
            'data_ini'   => $dataInicialParaView,
            'data_final' => $dataFinalParaView,
        ];

        // Constrói a cláusula WHERE para a data (usando YYYY-MM-DD)
        $filtro_data_where = "";
        if (!empty($dataInicialcad) && !empty($dataFinalcad)) {
            // *** CORREÇÃO: Chama o método interno da classe ***
            if ($this->_validateDate($dataInicialcad, 'Y-m-d') && $this->_validateDate($dataFinalcad, 'Y-m-d')) {
                $dataInicialFormatada = $dataInicialcad;
                $dataFinalFormatada = $dataFinalcad;
                $campo_data_filtro = 'os.data_abertura'; // Ou 'os.data_insert' se preferir
                $filtro_data_where = " AND {$campo_data_filtro} BETWEEN '{$dataInicialFormatada} 00:00:00' AND '{$dataFinalFormatada} 23:59:59'";
            } else {
                $filtro_data_where = ""; // Não aplica filtro se a data for inválida
                $this->session->set_flashdata('error', 'Data inválida recebida.');
                // Reseta as datas na view para o padrão se a entrada for inválida
                 $this->data['data_filtro'] = [
                    'data_ini'   => date('d/m/Y', strtotime('-60 days')),
                    'data_final' => date('d/m/Y'),
                 ];
            }
        }
        // --- FIM: LÓGICA DO FILTRO DE DATA ---


        // Pega idOrcamentos (GET ou POST)
        if (!empty($this->input->get('idOrcamentos'))) {
            $cod_orc = $this->input->get('idOrcamentos');
        } else {
            $cod_orc = $this->input->post('idOrcamentos');
        }

        // Carrega dados para os selects do formulário de filtro
        $config['base_url'] = base_url() . 'index.php/os/gerenciar/';
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
        $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
        $this->data['status_os'] = $this->os_model->getstatus_os();
        $this->data['verificacao_controle'] = $this->os_model->getVerificacaoControle();
        $this->data['status_peritagem'] = $this->os_model->getStatusPeritagem2();

        // Pega todos os possíveis filtros do POST
        $idOs = $this->input->post('idOs');
        $clientes_id  = $this->input->post('clientes_id');
        $idProdutos = $this->input->post('idProdutos');
        $numpedido_os = $this->input->post('numpedido_os');
        $tag = $this->input->post('tag');
        $numero_nf = $this->input->post('numero_nf');
        $numero_nffab = $this->input->post('numero_nffab');
        $descricao_item = $this->input->post('descricao_item');
        $numero_nfserv = $this->input->post('numero_nfserv');
        $unid_execucao = $this->input->post('unid_execucao'); // Array
        $unid_faturamento = $this->input->post('unid_faturamento'); // Array
        $id_tipo = $this->input->post('id_tipo'); // Array
        $idStatusOs = $this->input->post('idStatusOs'); // Array
        $desenho = $this->input->post('desenho'); // Array
        $verificacaoControle = $this->input->post('verificacaoControle'); // Array

        // Variável $abertura
        $abertura = '';/* if($exibirVenc){...} */

        // --- Monta strings de condição WHERE a partir dos filtros ---
        $query_status_producao_sql = ""; $query_status_producao = "";
        if (!empty($idStatusOs)) { $ids_int = []; foreach ($idStatusOs as $status) { $ids_int[] = (int)$status; } $ids_int = array_filter($ids_int); if (!empty($ids_int)) { $query_status_producao = "(" . implode(',', $ids_int) . ")"; $query_status_producao_sql = " AND os.idStatusOs IN " . $query_status_producao; } }
        $query_unid_execucao_sql = ""; $query_unid_execucao = "";
        if (!empty($unid_execucao)) { $ids_int = []; foreach ($unid_execucao as $unid) { $ids_int[] = (int)$unid; } $ids_int = array_filter($ids_int); if (!empty($ids_int)) { $query_unid_execucao = "(" . implode(',', $ids_int) . ")"; $query_unid_execucao_sql = " AND os.unid_execucao IN " . $query_unid_execucao; } }
        $query_unid_faturamento_sql = ""; $query_unid_faturamento = "";
        if (!empty($unid_faturamento)) { $ids_int = []; foreach ($unid_faturamento as $unid) { $ids_int[] = (int)$unid; } $ids_int = array_filter($ids_int); if (!empty($ids_int)) { $query_unid_faturamento = "(" . implode(',', $ids_int) . ")"; $query_unid_faturamento_sql = " AND os.unid_faturamento IN " . $query_unid_faturamento; } }
        $query_tipoos_sql = ""; $query_tipoos = "";
        if (!empty($id_tipo)) { $ids_int = []; foreach ($id_tipo as $tipo) { $ids_int[] = (int)$tipo; } $ids_int = array_filter($ids_int); if (!empty($ids_int)) { $query_tipoos = "(" . implode(',', $ids_int) . ")"; $query_tipoos_sql = " AND os.id_tipo IN " . $query_tipoos; } }
        $query_desenho_sql = ""; $query_desenho = "";
        if (!empty($desenho)) { $ids_escaped = []; foreach ($desenho as $des) { $ids_escaped[] = $this->db->escape($des); } $desenho2 = implode(',', $ids_escaped); $query_desenho = " and os.statusDesenho IN(".$desenho2.")"; $query_desenho_sql = $query_desenho; } // Mantendo a string SQL completa aqui
        $query_verifControl_sql = ""; $query_verifControl = "";
        if (!empty($verificacaoControle)) { $ids_escaped = []; foreach ($verificacaoControle as $vc) { $ids_escaped[] = $this->db->escape($vc); } $verificacaoControle2 = implode(',', $ids_escaped); $query_verifControl = " and os.idVerificacaoControle IN(".$verificacaoControle2.")"; $query_verifControl_sql = $query_verifControl; } // Mantendo a string SQL completa aqui
        $status_escopo = "";
        if(!empty($this->input->post("selectStatusPeritagem"))){ $status_escopo = $this->input->post("selectStatusPeritagem"); }
        $this->data['hist_vale'] = $this->os_model->getHistVale();
        // --- Fim da montagem dos filtros ---

        // Configuração padrão da paginação
        $config['per_page'] = 15; // Aumentado para 15
        $config['next_link'] = 'Próxima'; $config['prev_link'] = 'Anterior'; $config['full_tag_open'] = '<div class="pagination alternate"><ul>'; $config['full_tag_close'] = '</ul></div>'; $config['num_tag_open'] = '<li>'; $config['num_tag_close'] = '</li>'; $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>'; $config['cur_tag_close'] = '</b></a></li>'; $config['prev_tag_open'] = '<li>'; $config['prev_tag_close'] = '</li>'; $config['next_tag_open'] = '<li>'; $config['next_tag_close'] = '</li>'; $config['first_link'] = 'Primeira'; $config['last_link'] = 'Última'; $config['first_tag_open'] = '<li>'; $config['first_tag_close'] = '</li>'; $config['last_tag_open'] = '<li>'; $config['last_tag_close'] = '</li>';

        // Verifica se algum filtro FOI APLICADO PELO USUÁRIO (exceto as datas padrão)
        $filtros_especificos_aplicados = !empty($idOs) || !empty($cod_orc) || !empty($clientes_id) || !empty($idProdutos) || !empty($numpedido_os) || !empty($tag) || !empty($numero_nf) || !empty($descricao_item) || !empty($unid_execucao) || !empty($unid_faturamento) || !empty($id_tipo) || !empty($idStatusOs) || !empty($desenho) || !empty($verificacaoControle) || !empty($numero_nffab) || !empty($numero_nfserv) || !empty($status_escopo);

        // Se o usuário clicou em filtrar OU aplicou filtros específicos, usa a lógica de busca com filtros
        if ($filtroSubmetido || $filtros_especificos_aplicados) {

             // --- BLOCO COM FILTROS (LÓGICA ORIGINAL + FILTRO DE DATA IMPLÍCITO NAS FUNÇÕES DO MODEL) ---
             // NOTA: Para que o filtro de data funcione *neste bloco*, as funções
             // getWhereLikeos e numrowsWhereLikeos precisam ser adaptadas no os_model.php
             // para receber $dataInicialcad e $dataFinalcad e adicionar a condição $filtro_data_where internamente.

             $this->data['results'] = $this->os_model->getWhereLikeos($idOs, $cod_orc, $clientes_id, $idProdutos, $numpedido_os, $tag, $numero_nf, $descricao_item, 'os', "", $query_status_producao /*Valor IN()*/, $query_unid_execucao /*Valor IN()*/, $query_unid_faturamento /*Valor IN()*/, "", "", "", "", "", $query_tipoos /*Valor IN()*/, $query_desenho /*SQL com AND*/,'',$query_verifControl /*SQL com AND*/, $numero_nffab, $numero_nfserv, null, $status_escopo, $abertura /* Adicionar $dataInicialcad, $dataFinalcad aqui após modificar o model */);
             $config['total_rows'] = $this->os_model->numrowsWhereLikeos($idOs, $cod_orc, $clientes_id, $idProdutos, $numpedido_os, $tag, $numero_nf, $descricao_item, 'os', "", $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", "", "", "", "", $query_tipoos /* Adicionar $dataInicialcad, $dataFinalcad aqui após modificar o model */);

             $this->pagination->initialize($config);

        } else {
             // --- BLOCO OTIMIZADO (SEM FILTROS DO USUÁRIO, USA DATAS PADRÃO) ---

             $where_final_padrao = "1=1";
             $where_final_padrao .= $filtro_data_where; // Adiciona o filtro de data padrão
             if (!empty($abertura)) { $abertura_limpa = ltrim(trim($abertura), 'and'); $where_final_padrao .= " AND " . $abertura_limpa; }

             // 1. Contagem RÁPIDA (usa a string WHERE completa, removendo '1=1 AND ' e espaços)
             // *** CORREÇÃO APLICADA AQUI (revisão da lógica substr + trim) ***
             $where_para_model = '';
             $trimmed_where = trim($where_final_padrao);
             if (strpos($trimmed_where, '1=1 AND ') === 0) {
                 $where_para_model = trim(substr($trimmed_where, 7)); // Remove '1=1 AND '
             } elseif ($trimmed_where === '1=1') {
                 $where_para_model = ''; // Sem condição extra
             } else {
                 $where_para_model = $trimmed_where; // Caso inesperado, mas seguro
             }
             $config['total_rows'] = $this->os_model->count('os', $where_para_model); // Passa a string limpa

             $this->pagination->initialize($config);

             // Define o offset
             $offset = (!empty($this->uri->segment(3)) && is_numeric($this->uri->segment(3))) ? (int)$this->uri->segment(3) : 0;

             // 2. Busca RÁPIDA (usa a mesma string WHERE limpa)
             $this->data['results'] = $this->os_model->getos2($config['per_page'], $offset, $where_para_model);
             // --- FIM DO BLOCO OTIMIZADO ---
        }

        // Carrega a view
        $this->data['view'] = 'os/os';
        $this->load->view('tema/topo', $this->data);
    }




function planejadoPCP(){
    $this->load->model('os_model');

    // Obtém os valores do POST
    $idOs = $this->input->post("idOs");
    $planejadoPCP = $this->input->post("planejadoPCP");

    // Verifica se o idOs e planejadoPCP foram fornecidos corretamente
    if (($idOs && $planejadoPCP !== null) || ($planejadoPCP !== 1) ) {
        // Atualiza o campo planejadoPCP no registro correspondente ao idOs
        $this->db->set('planejadoPCP', $planejadoPCP);
        $this->db->where('idOs', $idOs);
        $this->db->update('os');
		
        echo "<script>console.log(".json_encode($planejadoPCP).")</script>";

        $this->session->set_flashdata('success', 'O.S. planejada com sucesso.');
    } else if (($planejadoPCP == '') || ($planejadoPCP !== 1) ) {
        $this->session->set_flashdata('error', 'Por favor marque a opção "OS PLANEJADA".');
    }

    // Redireciona de volta para a página desejada
    redirect(base_url() . 'index.php/os/distribuiros/'.$idOs);
}


public function carteiraservico()
{
    if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
        $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
        redirect(base_url());
    }
    $this->load->library('table');
    $this->load->library('pagination');
    $this->load->model('orcamentos_model');
    $this->load->model('Relatorios_model');
    $this->load->model('os_model');

    $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
    $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
    $this->data['status_os'] = $this->os_model->getStatusOs();
    $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
    $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
    $this->data['verificacao_controle'] = $this->os_model->getVerificacaoControle();
    $this->data['vendedores'] = $this->Relatorios_model->vendedoresRapid();
    $this->data['status_peritagem'] = $this->os_model->getStatusPeritagem2();
    $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();

    // --- CAPTURA DE FILTROS ---
    $idOs = $this->input->get('idOs');
    $cod_orc = $this->input->get('idOrcamentos');
    $clientes_id_arr  = $this->input->get('clientes_id');
    $idProdutos = $this->input->get('idProdutos');
    $descricao_item = $this->input->get('descricao_item');
    $verificacaoControle_arr = $this->input->get('verificacaoControle');
    $desenho_arr = $this->input->get('desenho');

    // Filtro de Reprogramação (Data de Registro)
    $queryDataReprog = "";
    $dataReprogInicial = $this->input->get('dataReprogInicial');
    $dataReprogFinal = $this->input->get('dataReprogFinal');
    $periodo_motivos_sql = null;

    if (!empty($dataReprogInicial) && !empty($dataReprogFinal)) {
        $dr_ini = implode('-', array_reverse(explode('/', $dataReprogInicial)));
        $dr_fim = implode('-', array_reverse(explode('/', $dataReprogFinal)));
        // Valida formato de data para evitar SQL Injection
        if (!$this->_validateDate($dr_ini) || !$this->_validateDate($dr_fim)) {
            $dr_ini = date('Y-m-d');
            $dr_fim = date('Y-m-d');
        }
        $queryDataReprog = " AND os.idOs IN (SELECT idOs FROM os_reagendada_motivo WHERE data_registro BETWEEN '$dr_ini 00:00:00' AND '$dr_fim 23:59:59')";
        $periodo_motivos_sql = "data_registro BETWEEN '$dr_ini 00:00:00' AND '$dr_fim 23:59:59'";
    }

    // Filtros de Datas padrão (Cadastro)
    $dataInicialcad = $this->input->get('dataInicialcad');
    $dataFinalcad = $this->input->get('dataFinalcad');
    if (empty($dataInicialcad) && empty($dataFinalcad) && !$this->input->get('filter')) {
        $dataFinalcad   = date('d/m/Y');
        $dataInicialcad = date('d/m/Y', strtotime('-40 days'));
    }
    $this->data['data_entrega'] = ['data_ini' => $dataInicialcad, 'data_final' => $dataFinalcad];
    
    $querydatacadastro = ""; $querydatacadastro2 = "";
    if (!empty($dataInicialcad) && !empty($dataFinalcad)) {
        $ini = implode('-', array_reverse(explode('/', $dataInicialcad)));
        $fim = implode('-', array_reverse(explode('/', $dataFinalcad)));
        if ($this->_validateDate($ini) && $this->_validateDate($fim)) {
            $querydatacadastro = " and os.data_abertura BETWEEN '$ini 00:00:00' AND '$fim 23:59:59'";
            $querydatacadastro2 = " and os.data_insert BETWEEN '$ini 00:00:00' AND '$fim 23:59:59'";
        }
    }

    $dataeinicial = $this->input->get('dataeinicial');
    $dataefinal = $this->input->get('dataefinal');
    $queryentrega_reagendada = "";
    if (!empty($dataeinicial) && !empty($dataefinal)) {
        $ini = implode('-', array_reverse(explode('/', $dataeinicial)));
        $fim = implode('-', array_reverse(explode('/', $dataefinal)));
        if ($this->_validateDate($ini) && $this->_validateDate($fim)) {
            $queryentrega_reagendada = " and IF(os.data_reagendada is not null and os.data_reagendada != '',os.data_reagendada,os.data_entrega) BETWEEN '$ini 00:00:00' AND '$fim 23:59:59' ";
        }
    }

    $idStatusOs_arr = $this->input->get('idStatusOs');
    $unid_execucao_arr = $this->input->get('unid_execucao');
    $unid_faturamento_arr = $this->input->get('unid_faturamento');
    $id_tipo_arr = $this->input->get('id_tipo');
    $vendedores_arr = $this->input->get('idVendedores');

    $query_status_producao = !empty($idStatusOs_arr) ? "(" . implode(',', array_filter(array_map('intval', (array)$idStatusOs_arr))) . ")" : "";
    $query_unid_execucao = !empty($unid_execucao_arr) ? "(" . implode(',', array_filter(array_map('intval', (array)$unid_execucao_arr))) . ")" : "";
    $query_unid_faturamento = !empty($unid_faturamento_arr) ? "(" . implode(',', array_filter(array_map('intval', (array)$unid_faturamento_arr))) . ")" : "";
    $query_tipoos = !empty($id_tipo_arr) ? "(" . implode(',', array_filter(array_map('intval', (array)$id_tipo_arr))) . ")" : "";
    $query_clientes = !empty($clientes_id_arr) ? "(" . implode(',', array_filter(array_map('intval', (array)$clientes_id_arr))) . ")" : "";
    $_vend_safe = !empty($vendedores_arr) ? implode(',', array_filter(array_map('intval', (array)$vendedores_arr))) : "";
    $query_vendedor = !empty($_vend_safe) ? " and orcamento.idVendedor IN(".$_vend_safe.")" : "";
    $_vc_safe = !empty($verificacaoControle_arr) ? implode(',', array_filter(array_map('intval', (array)$verificacaoControle_arr))) : "";
    $query_verifControl = !empty($_vc_safe) ? " and os.idVerificacaoControle IN(".$_vc_safe.")" : "";
    $_des_safe = !empty($desenho_arr) ? implode(',', array_filter(array_map('intval', (array)$desenho_arr))) : "";
    $query_desenho = !empty($_des_safe) ? " and os.statusDesenho IN(".$_des_safe.")" : "";
    
    // Lógica Regional
    $this->load->model('almoxarifado_model');
    $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($this->session->userdata('idUsuarios'));
    $petrolina = false; $uberlandia = false;
    foreach ($getUserEmpresa as $r) {
        if (in_array($r->id, [1, 3, 4])) $uberlandia = true;
        if ($r->id == 2) $petrolina = true;
    }
    $query_clientes3 = ($petrolina && !$uberlandia) ? " and clientes.idClientes in(706,702,711,528,540,537,552,519,543,581,684,635,517,576,580,575,532,516,10,551,1005,1024)" : "";

    $status_escopo = $this->input->get("selectStatusPeritagem") ?: "";
    $idGrupoServico = $this->input->get('idGrupoServico');
    
    // --- ✅ CORREÇÃO CIRÚRGICA: Lógica de Filtro Data de Produção ---
    $dataInicialProducao = $this->input->get('dataInicialProducao');
    $dataFinalProducao = $this->input->get('dataFinalProducao');
    $queryDataProducao = ""; 

    if (!empty($dataInicialProducao) && !empty($dataFinalProducao)) {
        if ($this->_validateDate($dataInicialProducao) && $this->_validateDate($dataFinalProducao)) {
            $queryDataProducao = " and os.data_producao BETWEEN '{$dataInicialProducao} 00:00:00' AND '{$dataFinalProducao} 23:59:59'";
        }
    }
    // -----------------------------------------------------------------

    // BUSCA NO MODEL
    $result1 = $this->os_model->getOsAberta($idOs, $cod_orc, '', $idProdutos, '', '', '', $descricao_item, 'c', '', $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", $querydatacadastro, "", $query_clientes, $queryentrega_reagendada, $query_tipoos, $query_desenho, $query_clientes3, $query_verifControl, null, null, $query_vendedor, $status_escopo, $idGrupoServico, $queryDataProducao, $queryDataReprog);
    $result2 = $this->os_model->getOsPendente($idOs, $cod_orc, '', $idProdutos, '', '', '', $descricao_item, 'c', '', $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", $querydatacadastro2, "", $query_clientes, $queryentrega_reagendada, $query_tipoos, $query_desenho, $query_clientes3, $query_verifControl, null, null, $query_vendedor, $status_escopo, $idGrupoServico, $queryDataProducao, $queryDataReprog);
    
    $this->data['results'] = array_merge($result1, $result2);
    
    // --- PÓS-PROCESSAMENTO CIRÚRGICO ---
    if (!empty($this->data['results'])) {
        foreach ($this->data['results'] as $key => $os) {
            
            // 1. Filtro Restritivo
            if (!empty($periodo_motivos_sql)) {
                $check_no_periodo = $this->db->where('idOs', $os->idOs)
                                             ->where($periodo_motivos_sql, NULL, FALSE)
                                             ->count_all_results('os_reagendada_motivo');
                if ($check_no_periodo == 0) {
                    unset($this->data['results'][$key]);
                    continue; 
                }
            }

            // 2. Busca histórico completo para a lista numerada
            $lista_completa = $this->db->select('motivo, data_registro')
                                       ->where('idOs', $os->idOs)
                                       ->order_by('idMotivoReag', 'ASC')
                                       ->get('os_reagendada_motivo')
                                       ->result();

            $historico_formatado = "";
            if (!empty($lista_completa)) {
                $cont = 1;
                foreach ($lista_completa as $m) {
                    $dt_reg = date('d/m/Y', strtotime($m->data_registro));
                    $historico_formatado .= "<b>{$cont})</b> {$dt_reg}: {$m->motivo}<br>";
                    $cont++;
                }
            }
            $this->data['results'][$key]->qtde_reprog = count($lista_completa);
            $this->data['results'][$key]->todos_motivos = $historico_formatado;

            // --- ✅ CORREÇÃO CIRÚRGICA: DATA REPROGRAMADA (ACEITA NULL/VAZIO) ---
            $ultimo_motivo = $this->db->select('data_reagendada')
                                      ->where('idOs', $os->idOs)
                                      ->order_by('idMotivoReag', 'DESC') // Pega o último registro (mesmo se NULL)
                                      ->limit(1)
                                      ->get('os_reagendada_motivo')
                                      ->row();

            if ($ultimo_motivo) {
                // Se o último motivo tiver data nula/zerada, força null para a View exibir o traço (-)
                if (empty($ultimo_motivo->data_reagendada) || $ultimo_motivo->data_reagendada == '0000-00-00') {
                    $this->data['results'][$key]->data_reagendada = null;
                } else {
                    $this->data['results'][$key]->data_reagendada = $ultimo_motivo->data_reagendada;
                }
            } else {
                // Se nunca houve reprogramação, tenta a tabela principal
                $dados_os_base = $this->db->select('data_reagendada')->where('idOs', $os->idOs)->get('os')->row();
                $this->data['results'][$key]->data_reagendada = (!empty($dados_os_base->data_reagendada)) ? $dados_os_base->data_reagendada : null;
            }

            // Data do último canhoto
            $canhoto = $this->db->select('data_cadastro')->where('idOs', $os->idOs)->order_by('idAnexo', 'DESC')->limit(1)->get('anexo_nfcanhoto')->row();
            $this->data['results'][$key]->data_canhoto = !empty($canhoto) ? $canhoto->data_cadastro : null;
            
            // --- BUSCA DE DADOS DA NOTA FISCAL PARA A VIEW ---
            $os_db = $this->db->select('data_nf_faturamento, numero_nf')->where('idOs', $os->idOs)->get('os')->row();
            
            if ($os_db) {
                $this->data['results'][$key]->data_nf_emitida = ($os_db->data_nf_faturamento != '0000-00-00') ? $os_db->data_nf_faturamento : null;
                $this->data['results'][$key]->numero_nf = $os_db->numero_nf;

                $this->data['results'][$key]->usuario_nf = ""; 
                if (!empty($os_db->numero_nf)) {
                    $user_nf = $this->db->select('usuarios.nome')
                                        ->from('os_history')
                                        ->join('usuarios', 'usuarios.idUsuarios = os_history.idUserHis')
                                        ->where('os_history.idOs', $os->idOs)
                                        ->where('os_history.numero_nf', $os_db->numero_nf)
                                        ->order_by('os_history.idOsHis', 'DESC')
                                        ->limit(1)
                                        ->get()
                                        ->row();
                    
                    if ($user_nf) {
                        $this->data['results'][$key]->usuario_nf = $user_nf->nome;
                    }
                }
            } else {
                $this->data['results'][$key]->data_nf_emitida = null;
                $this->data['results'][$key]->usuario_nf = "";
            }
        }
    }
    
    // Atualização dos Status no rodapé
    $this->data['result_status'] = array_merge(
        $this->os_model->getWhereLikeos_status($idOs, $cod_orc, '', $idProdutos, '', '', '', $descricao_item, 'c', '', $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", $querydatacadastro, "", $query_clientes, $queryentrega_reagendada, '', $query_tipoos, '', $query_clientes3, $query_verifControl, null, null, $query_vendedor, $status_escopo, $idGrupoServico, $queryDataProducao, $queryDataReprog),
        $this->os_model->getWhereLikeos_status2($idOs, $cod_orc, '', $idProdutos, '', '', '', $descricao_item, 'c', '', $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", $querydatacadastro2, "", $query_clientes, $queryentrega_reagendada, '', $query_tipoos, '', $query_clientes3, $query_verifControl, null, null, $query_vendedor, $status_escopo, $idGrupoServico, $queryDataProducao, $queryDataReprog)
    );
            
    usort($this->data['results'], function ($a, $b) { return $a->idOs <=> $b->idOs; });
    $this->data['view'] = 'os/carteiraservico';
    $this->load->view('tema/topo', $this->data);
}

public function exportarMotivosReagendamento() {
    $this->load->model('os_model');
    
    // --- CAPTURA DE TODOS OS FILTROS ATIVOS ---
    $idOs = $this->input->get('idOs');
    $cod_orc = $this->input->get('idOrcamentos');
    $clientes_id = $this->input->get('clientes_id'); 
    $idProdutos = $this->input->get('idProdutos');
    $descricao_item = $this->input->get('descricao_item');
    $idStatusOs = $this->input->get('idStatusOs'); 
    $unid_execucao = $this->input->get('unid_execucao'); 
    $unid_faturamento = $this->input->get('unid_faturamento'); 
    $id_tipo = $this->input->get('id_tipo'); 
    $vendedores = $this->input->get('idVendedores'); 
    $verificacaoControle = $this->input->get('verificacaoControle'); 
    
    $dataReprogInicial = $this->input->get('dataReprogInicial');
    $dataReprogFinal = $this->input->get('dataReprogFinal');
    
    // Seleção dos 34 campos
    $this->db->select('
        os.idOs, os.idOrcamentos, gs.nome as nomeServico, cli.nomeCliente, clisol.nome as solicitante, vend.nomeVendedor, 
        os.data_insert, os.data_abertura, os.nf_cliente, os.numpedido_os, os.qtd_os, orc_i.descricao_item, prod.pn, os.subtot_os, 
        os.data_entrega, st_os.nomeStatusOs, os.data_nf_faturamento, os.data_producao, os.statusDesenho, verif.descricaoControle, 
        exe.status_execucao, fat.status_faturamento, ostip.nome_tipo, os.data_expedicao, os.numero_nf, u_nf.nome AS usuario_nf_nome,
        rm.data_reagendada AS data_reprog_alvo, rm.motivo, rm.data_registro as data_da_alteracao,
        (SELECT COUNT(*) FROM os_reagendada_motivo WHERE idOs = os.idOs) as total_reprog_count,
        (SELECT data_cadastro FROM anexo_nfcanhoto WHERE idOs = os.idOs ORDER BY idAnexo DESC LIMIT 1) as data_canhoto_venda
    ', FALSE);
    
    $this->db->from('os_reagendada_motivo rm');
    $this->db->join('os', 'os.idOs = rm.idOs');
    $this->db->join('orcamento_item orc_i', 'orc_i.idOrcamento_item = os.idOrcamento_item');
    $this->db->join('orcamento orc', 'orc.idOrcamentos = os.idOrcamentos');
    $this->db->join('grupo_servico gs', 'gs.idGrupoServico = orc.idGrupoServico');
    $this->db->join('clientes cli', 'cli.idClientes = orc.idClientes');
    $this->db->join('produtos prod', 'prod.idProdutos = orc_i.idProdutos');
    $this->db->join('vendedores vend', 'vend.idVendedor = orc.idVendedor');
    $this->db->join('status_os st_os', 'st_os.idStatusOs = os.idStatusOs');
    $this->db->join('clientes_solicitantes clisol', 'clisol.idSolicitante = orc.idSolicitante', 'left');
    $this->db->join('unidade_execucao exe', 'exe.id_unid_exec = os.unid_execucao', 'left');
    $this->db->join('unidade_faturamento fat', 'fat.id_unid_fat = os.unid_faturamento', 'left');
    $this->db->join('os_tipo ostip', 'ostip.id_tipo = os.id_tipo', 'left');
    $this->db->join('verificacao_controle verif', 'verif.idVerificacaoControle = os.idVerificacaoControle', 'left');
    
    $this->db->join('(SELECT h1.idOs, h1.idUserHis FROM os_history h1 INNER JOIN (SELECT idOs, MAX(idOsHis) AS max_id FROM os_history WHERE idUserHis IS NOT NULL GROUP BY idOs) h2 ON h1.idOs = h2.idOs AND h1.idOsHis = h2.max_id) AS ult_hist', 'ult_hist.idOs = os.idOs AND os.numero_nf > 0', 'left', FALSE);
    $this->db->join('usuarios u_nf', 'u_nf.idUsuarios = ult_hist.idUserHis', 'left');

    // --- FILTROS DE OS ---
    if (!empty($idOs)) { $this->db->where('os.idOs', $idOs); }
    if (!empty($cod_orc)) { $this->db->where('os.idOrcamentos', $cod_orc); }
    if (!empty($clientes_id)) { $this->db->where_in('orc.idClientes', $clientes_id); }
    if (!empty($idProdutos)) { $this->db->where('orc_i.idProdutos', $idProdutos); }
    if (!empty($descricao_item)) { $this->db->like('orc_i.descricao_item', $descricao_item); }
    if (!empty($idStatusOs)) { $this->db->where_in('os.idStatusOs', $idStatusOs); }
    if (!empty($unid_execucao)) { $this->db->where_in('os.unid_execucao', $unid_execucao); }
    if (!empty($unid_faturamento)) { $this->db->where_in('os.unid_faturamento', $unid_faturamento); }
    if (!empty($id_tipo)) { $this->db->where_in('os.id_tipo', $id_tipo); }
    if (!empty($vendedores)) { $this->db->where_in('orc.idVendedor', $vendedores); }
    if (!empty($verificacaoControle)) { $this->db->where_in('os.idVerificacaoControle', $verificacaoControle); }

    // --- AJUSTE CIRÚRGICO NA DATA (O SEGREDO) ---
    if (!empty($dataReprogInicial) && !empty($dataReprogFinal)) {
        $dr_ini = implode('-', array_reverse(explode('/', $dataReprogInicial)));
        $dr_fim = implode('-', array_reverse(explode('/', $dataReprogFinal)));
        // Valida formato de data para evitar SQL Injection
        if (!$this->_validateDate($dr_ini) || !$this->_validateDate($dr_fim)) {
            $dr_ini = date('Y-m-d');
            $dr_fim = date('Y-m-d');
        }
        // Filtramos as IDs das OSs que tiveram movimentação no período,
        // mas permitimos que o FROM 'os_reagendada_motivo' traga todas as linhas dessas IDs.
        $this->db->where("os.idOs IN (SELECT idOs FROM os_reagendada_motivo WHERE data_registro BETWEEN '$dr_ini 00:00:00' AND '$dr_fim 23:59:59')", NULL, FALSE);
    }

    $this->db->order_by('os.idOs ASC, rm.data_registro ASC'); 
    $resultados = $this->db->get()->result();

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Relatorio_Motivos_Reprogramacao_'.date('d-m-Y').'.csv');
    echo "\xEF\xBB\xBF"; 
    $output = fopen('php://output', 'w');
    
    fputcsv($output, array(
        'OS.', 'OR.', 'Grupo', 'Cliente', 'Solicitante', 'Vendedor', 'Data Criação OS', 'Data OS.', 
        'NF Cliente', 'Nº Pedido', 'Qtd.', 'Item - Descrição', 'PN', 'Valor', 'Data Ent.', 
        'Reprogr.', 'Status', 'Data Fat.', 'Data Fab.', 'Data Fim Prod.', 'DES', 'Verif. Cont.', 
        'EXE', 'FAT', 'Tipo', 'Data Expedição', 'Nº NF', 'Data NF Emitida', 'Usuário (Emitiu NF)', 
        'Qtde data Rep', 'Data Alter. Rep.', 'Motivo Reprog.', 'Data Canhoto', 'Ver OS'
    ), ';');

    foreach ($resultados as $row) {
        $des_status = ($row->statusDesenho == 3) ? "Finalizado" : (($row->statusDesenho == 1) ? "Aguardando Desenho" : "Aguardando Validação");

        fputcsv($output, array(
            $row->idOs, $row->idOrcamentos, $row->nomeServico, $row->nomeCliente, $row->solicitante, $row->nomeVendedor,
            (!empty($row->data_insert) ? date('d/m/Y', strtotime($row->data_insert)) : ""),
            (!empty($row->data_abertura) ? date('d/m/Y', strtotime($row->data_abertura)) : ""),
            $row->nf_cliente, $row->numpedido_os, $row->qtd_os, $row->descricao_item, $row->pn,
            number_format($row->subtot_os, 2, ",", "."),
            (!empty($row->data_entrega) ? date('d/m/Y', strtotime($row->data_entrega)) : ""),
            (!empty($row->data_reprog_alvo) ? date('d/m/Y', strtotime($row->data_reprog_alvo)) : ""),
            $row->nomeStatusOs,
            (!empty($row->data_nf_faturamento) ? date('d/m/Y', strtotime($row->data_nf_faturamento)) : ""),
            (!empty($row->data_producao) ? date('d/m/Y', strtotime($row->data_producao)) : ""),
            (!empty($row->data_producao) ? date('d/m/Y', strtotime($row->data_producao)) : ""),
            $des_status, $row->descricaoControle, $row->status_execucao, $row->status_faturamento, $row->nome_tipo,
            (!empty($row->data_expedicao) ? date('d/m/Y', strtotime($row->data_expedicao)) : ""),
            $row->numero_nf,
            (!empty($row->data_nf_faturamento) ? date('d/m/Y', strtotime($row->data_nf_faturamento)) : ""),
            $row->usuario_nf_nome, 
            $row->total_reprog_count,
            (!empty($row->data_da_alteracao) ? date('d/m/Y', strtotime($row->data_da_alteracao)) : ""), 
            $row->motivo,
            (!empty($row->data_canhoto_venda) ? date('d/m/Y', strtotime($row->data_canhoto_venda)) : ""),
            base_url('index.php/os/visualizar/' . $row->idOs)
        ), ';');
    }
    fclose($output);
    exit;
}
    function adicionar()
    {

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('os') == false) {
            $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');

            try {

                $dataInicial = explode('/', $dataInicial);
                $dataInicial = $dataInicial[2] . '-' . $dataInicial[1] . '-' . $dataInicial[0];

                $dataFinal = explode('/', $dataFinal);
                $dataFinal = $dataFinal[2] . '-' . $dataFinal[1] . '-' . $dataFinal[0];
            } catch (Exception $e) {
                $dataInicial = date('Y/m/d');
            }

            $data = array(
                'dataInicial' => $dataInicial,
                'clientes_id' => $this->input->post('clientes_id'), //set_value('idCliente'),
                'usuarios_id' => $this->input->post('usuarios_id'), //set_value('idUsuario'),
                'dataFinal' => $dataFinal,
                'garantia' => set_value('garantia'),
                'descricaoProduto' => set_value('descricaoProduto'),
                'defeito' => set_value('defeito'),
                'status' => set_value('status'),
                'observacoes' => set_value('observacoes'),
                'data_abertura' => date('Y-m-d H:i:s'),
                'data_abertura_real' => date('Y-m-d H:i:s'),
                'laudoTecnico' => set_value('laudoTecnico'),
                'faturado' => 0
            );

            if (is_numeric($id = $this->os_model->add('os', $data, true))) {
                $this->session->set_flashdata('success', 'OS adicionada com sucesso, você pode adicionar produtos ou serviços a essa OS nas abas de "Produtos" e "Serviços"!');
                redirect('os/editar/' . $id);
            } else {

                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }

        $this->data['view'] = 'os/adicionarOs';
        $this->load->view('tema/topo', $this->data);
    }


// Adicione ou substitua esta função no seu arquivo de controlador (ex: controllers/os.php)

public function dataproducaoPCP() {
    // Validação inicial dos dados recebidos via POST
    if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Você não tem permissão para editar OS.']);
        return;
    }

    $idOs = $this->input->post('idOs');
    $dataProducao = $this->input->post('data_producao');

    if (empty($idOs) || empty($dataProducao)) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Dados incompletos. ID da OS e Data são obrigatórios.']);
        return;
    }

    // 1. ATUALIZAR A DATA DE PRODUÇÃO NA TABELA 'os'
    $dadosUpdate = ['data_producao' => $dataProducao];
    
    // Usando a função 'edit' que já trata o histórico de alterações (hist_alteracao)
    if ($this->os_model->edit('os', $dadosUpdate, 'idOs', $idOs) == TRUE) {
        
        // 2. BUSCAR O OBJETO COMPLETO DA OS (JÁ ATUALIZADO)
        // Isso é crucial para que o histórico reflita o novo estado.
        $osAtualizada = $this->os_model->getById($idOs);

        if ($osAtualizada) {
            // 3. INSERIR O REGISTRO DE HISTÓRICO NA 'os_history'
            // A função insertOSHis já pega o usuário da sessão e outros dados automaticamente.
            $this->os_model->insertOSHis($osAtualizada);
        }

        // Formata a data para retornar ao AJAX e atualizar a tela
        $data_formatada = date('d/m/Y', strtotime($dataProducao));

        // Retorna sucesso para a chamada AJAX
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Data de produção atualizada e histórico gravado com sucesso!',
            'idOs' => $idOs,
            'data_producao_formatada' => $data_formatada
        ]);

    } else {
        // Em caso de falha na atualização
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Falha ao atualizar a data de produção na OS.']);
    }
}


    public function adicionarAjax()
    {
        $this->load->library('form_validation');

        if ($this->form_validation->run('os') == false) {
            $json = array("result" => false);
            echo json_encode($json);
        } else {
            $data = array(
                'dataInicial' => set_value('dataInicial'),
                'clientes_id' => $this->input->post('clientes_id'), //set_value('idCliente'),
                'usuarios_id' => $this->input->post('usuarios_id'), //set_value('idUsuario'),
                'dataFinal' => set_value('dataFinal'),
                'garantia' => set_value('garantia'),
                'descricaoProduto' => set_value('descricaoProduto'),
                'defeito' => set_value('defeito'),
                'status' => set_value('status'),
                'observacoes' => set_value('observacoes'),
                'laudoTecnico' => set_value('laudoTecnico')
            );

            if (is_numeric($id = $this->os_model->add('os', $data, true))) {
                $json = array("result" => true, "id" => $id);
                echo json_encode($json);
            } else {
                $json = array("result" => false);
                echo json_encode($json);
            }
        }
    }

    function reagendar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para reagendar OS.');
            redirect(base_url());
        }






        if ($this->input->post('novadata') == '' || $this->input->post('varias_os') == '') {
            $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
            redirect(base_url() . 'index.php/os');
        }

        $data_rea = explode('/', $this->input->post('novadata'));
        $data_rea = $data_rea[2] . '-' . $data_rea[1] . '-' . $data_rea[0];

        $data3 = array(
            'data_reagendada' => $data_rea,
			'data_reagendada_count' => $data_reagendada_count



        );

        $id_osreag = explode(',', $this->input->post('varias_os'));



        foreach ($id_osreag as $os_reag) {

            $this->data['result'] = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
            $descricao = serialize($this->data['result']);
            $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'editar', $descricao, $os_reag);
        }









        if ($this->os_model->edit2('os', $data3, 'idOs', $this->input->post('varias_os')) == TRUE) {




            $this->session->set_flashdata('success', 'Os Alterada com sucesso! OS: ' . $this->input->post('varias_os'));
            redirect(base_url() . 'index.php/os');
        } else {
            $this->session->set_flashdata('error', 'Erro ao editar!');
            redirect(base_url() . 'index.php/os');
        }
    }
    function dataentrega()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para reagendar OS.');
            redirect(base_url());
        }






        if ($this->input->post('novadata') == '' || $this->input->post('varias_os') == '') {
            $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
            redirect(base_url() . 'index.php/os');
        }

        $data_rea = explode('/', $this->input->post('novadata'));
        $data_rea = $data_rea[2] . '-' . $data_rea[1] . '-' . $data_rea[0];

        $data3 = array(
            'data_entrega' => $data_rea



        );

        $id_osreag = explode(',', $this->input->post('varias_os'));



        foreach ($id_osreag as $os_reag) {

            $this->data['result'] = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
            $descricao = serialize($this->data['result']);
            $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'editar', $descricao, $os_reag);
        }









        if ($this->os_model->edit2('os', $data3, 'idOs', $this->input->post('varias_os')) == TRUE) {




            $this->session->set_flashdata('success', 'Os Alterada com sucesso! OS: ' . $this->input->post('varias_os'));
            redirect(base_url() . 'index.php/os');
        } else {
            $this->session->set_flashdata('error', 'Erro ao editar!');
            redirect(base_url() . 'index.php/os');
        }
    }
    function status()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para reagendar OS.');
            redirect(base_url());
        }






        if ($this->input->post('idStatusOs') == '' || $this->input->post('varias_os') == '') {
            $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
            redirect(base_url() . 'index.php/os');
        }

        $idStatusOs = $this->input->post('idStatusOs');


        $data3 = array(
            'idStatusOs' => $idStatusOs



        );

        $id_osreag = explode(',', $this->input->post('varias_os'));



        foreach ($id_osreag as $os_reag) {

            $this->data['result'] = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
            $descricao = serialize($this->data['result']);
            $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'editar', $descricao, $os_reag);
        }









        if ($this->os_model->edit2('os', $data3, 'idOs', $this->input->post('varias_os')) == TRUE) {




            $this->session->set_flashdata('success', 'Os Alterada com sucesso! OS: ' . $this->input->post('varias_os'));
            redirect(base_url() . 'index.php/os');
        } else {
            $this->session->set_flashdata('error', 'Erro ao editar!');
            redirect(base_url() . 'index.php/os');
        }
    }

    function pedido()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para reagendar OS.');
            redirect(base_url());
        }




        if ($this->input->post('nomeArquivo') == '' || $this->input->post('pedido') == '' ||  $this->input->post('varias_os') == '') {
            $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
            redirect(base_url() . 'index.php/os');
        }




        $data3 = array(
            'numpedido_os' => $this->input->post('pedido')



        );

        $id_osreag = explode(',', $this->input->post('varias_os'));



        foreach ($id_osreag as $os_reag) {






            $this->data['result'] = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
            $descricao = serialize($this->data['result']);
            $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'editar', $descricao, $os_reag);

            $arquivo = $this->do_upload_pedido();

            $imagem = $arquivo['file_name'];
            //$path = $arquivo['full_path'];
            $caminho = 'assets/uploads/pedido/';
            //$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
            $tamanho = $arquivo['file_size'];
            $extensao = $arquivo['file_ext'];

            $nomeArquivo = $this->input->post('nomeArquivo');




            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'imagem' => $imagem,
                'caminho' => $caminho,
                'tamanho' => $tamanho,
                'extensao' => $extensao,
                'data_cadastro' => date('Y-m-d H:i:s'),

                'idOs' => $os_reag
            );
            $this->os_model->add('anexo_pedido', $data);
        }




        if ($this->os_model->edit2('os', $data3, 'idOs', $this->input->post('varias_os')) == TRUE) {



            $this->session->set_flashdata('success', 'Os Alterada com sucesso! OS: ' . $this->input->post('varias_os'));
            redirect(base_url() . 'index.php/os');
        } else {
            $this->session->set_flashdata('error', 'Erro ao editar!');
            redirect(base_url() . 'index.php/os');
        }
    }

    function alterarStatusDesenho()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'adesenhoOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para Alterar Desenho.');
            redirect(base_url());
        }
        if (!empty($this->input->post('statusDesenho'))) {
            $statusDesenho = $this->input->post('statusDesenho');
        } else {
            $statusDesenho = null;
        }
        if (!empty($this->input->post('obs_desenho'))) {
            $obs_desenho = $this->input->post('obs_desenho');
        } else {
            $obs_desenho = null;
        }
        $data = array(
            "statusDesenho" => $statusDesenho,
            "obsDesenho" => $obs_desenho
        );
        $data2 = array(
            "statusDesenho" => $statusDesenho
        );
        $objOrcamentoItem = $this->os_model->getOrcamentoItemByIdOs($this->input->post('idOs2'));
        if($objOrcamentoItem->tipoOrc == "serv"){
            $data3 = array();
            $data4 = array("idStatusEscopo"=>2);
            $data = array_merge($data,$data3);
            $this->os_model->edit('orc_servico_escopo',$data4,'idOrcItem',$objOrcamentoItem->idOrcamento_item);
        }else if($objOrcamentoItem->tipoOrc == "fab"){
            $data3 = array();
            if($statusDesenho == 3)
                $data3 = array("fechadoPCP"=>1);
            
            $data = array_merge($data,$data3);
        }else{
            $data3 = array();
            if($statusDesenho == 3)
                $data3 = array("fechadoPCP"=>1);
            $data = array_merge($data,$data3);
        }
        $this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs2'));
        $this->os_model->edit('orcamento_item', $data2, 'idOrcamento_item', $objOrcamentoItem->idOrcamento_item);
        $os = $this->os_model->getByid_table($this->input->post('idOs2'), 'os', 'idOs');
        $this->os_model->insertOSHis($os);
        $this->session->set_flashdata('success', 'Os editada com sucesso!');
        redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs2'));
        return;
        //$this->salvarlog($this->session->userdata('idUsuarios'),'os','editar',$descricao, );
    }
	
	
	
	
	
    function alterarStatusControle()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eErificacaocontroleOS')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para Alterar o status do Controle.');
            redirect(base_url());
        }
        if (!empty($this->input->post('idVerificacaoControle'))) {
            $statusControle = $this->input->post('idVerificacaoControle');
        } else {
            $statusControle = null;
        }
        $data2 = array(
            "idVerificacaoControle" => $statusControle
        );
        $this->os_model->edit('os', $data2, 'idOs', $this->input->post('idOs2'));
        $this->session->set_flashdata('success', 'Controle alterado com sucesso!');
        $os = $this->os_model->getByid_table($this->input->post('idOs2'), 'os', 'idOs');
        $this->os_model->insertOSHis($os);
        redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs2'));
        return;
        //$this->salvarlog($this->session->userdata('idUsuarios'),'os','editar',$descricao, );
    }


    function editaros()
    {
        $bttDesenho = $this->input->post('btnAlterarDesenho');
        if (!empty($bttDesenho)) {
            $this->alterarStatusDesenho();
            return;
        }
        $bttControle = $this->input->post('buttonAlterarVerifContr');
        if (!empty($bttControle)) {
            $this->alterarStatusControle();
            return;
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
            redirect(base_url());
        }
        $this->load->model('almoxarifado_model');
        $this->load->model('orcamentos_model');
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';





        $this->form_validation->set_rules('data_abertura', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('qtd_os', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('data_entrega', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idStatusOs', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('unid_execucao', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('unid_faturamento', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('contrato', '', 'trim|required|xss_clean');

        //$this->form_validation->set_rules('val_ipi_os', '', 'trim|required|xss_clean');

        //so esse alterar em orçamento item
        $this->form_validation->set_rules('descricao_os', '', 'trim|required|xss_clean');


        /*$this->form_validation->set_rules('numpedido_os', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('numero_nf', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nf_cliente', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nf_venda_dev', '', 'trim|required|xss_clean');
      */

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs2'));
        } else {

			$idStatusOs = $this->input->post('idStatusOs');
			$data_expedicao = $this->input->post('data_expedicao');
			
			// Verifica se o idStatusOs está entre os valores restritos e se a data_expedicao está preenchida
			if (in_array($idStatusOs, [92, 86, 6, 87]) && empty($data_expedicao)) {
			// Retorna uma mensagem de erro ao usuário
			$this->session->set_flashdata('error', 'Você só pode alterar O.S. com STATUS: 
													Aguar. Apro. entregue (OS),
													Contrato Entregue (OS),
													Faturada Aprovada (F),
													Entregue (OS),
													se a DATA DE EXPEDIÇÃO for informada.');
													
			redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs2'));
			}

            $data_abertura = $this->input->post('data_abertura');
            $data_entrega = $this->input->post('data_entrega');
			$data_viagem = $this->input->post('data_viagem');
            $data_canhoto = $this->input->post('data_canhoto');
            $data_reagendada = $this->input->post('data_reagendada');
			$data_reagendada_count = $this->input->post('data_reagendada_count');
            $data_planejada = $this->input->post('data_planejada');
			$data_planejada_count = $this->input->post('data_planejada_count');	
/*var_dump($this->input->post('data_planejada_count'));
exit();*/
			
            $data_nf_faturamento = $this->input->post('data_nf_faturamento');
            $data_devolucao = $this->input->post('data_devolucao');

            $desconto_ = str_replace(".", "", $this->input->post('desconto_os'));
            $desconto_ = str_replace(",", ".", $desconto_);

            $val_ipi_ = str_replace(".", "", $this->input->post('val_ipi_os'));
            $val_ipi_ = str_replace(",", ".", $val_ipi_);

            $valorunita = str_replace(".", "", $this->input->post('val_unit_os'));
            $valorunita = str_replace(",", ".", $valorunita);

            $subtot_os = str_replace(".", "", $this->input->post('subtot_os'));
            $subtot_os = str_replace(",", ".", $subtot_os);


            $data_abertura = explode('/', $data_abertura);
            $data_abertura = $data_abertura[2] . '-' . $data_abertura[1] . '-' . $data_abertura[0];


            $data_entrega = explode('/', $data_entrega);
            $data_entrega = $data_entrega[2] . '-' . $data_entrega[1] . '-' . $data_entrega[0];

            
            if ($data_planejada <> '') {
                $data_planejada = explode('/', $data_planejada);
                $data_planejada = $data_planejada[2] . '-' . $data_planejada[1] . '-' . $data_planejada[0];
                //$campo_reagendada = "'data_reagendada' => ".$data_reagendada.",";
            } else {

                $data_planejada = null;
            }  
            

            if ($data_reagendada <> '') {
                $data_reagendada = explode('/', $data_reagendada);
                $data_reagendada = $data_reagendada[2] . '-' . $data_reagendada[1] . '-' . $data_reagendada[0];
                //$campo_reagendada = "'data_reagendada' => ".$data_reagendada.",";
            } else {

                $data_reagendada = null;
            }
            if ($data_expedicao <> '') {
                $data_expedicao = explode('/', $data_expedicao);
                $data_expedicao = $data_expedicao[2] . '-' . $data_expedicao[1] . '-' . $data_expedicao[0];
                //$campo_reagendada = "'data_reagendada' => ".$data_reagendada.",";
            } else {

                $data_expedicao = null;
            }
			if ($data_viagem <> '') {
                $data_viagem = explode('/', $data_viagem);
                $data_viagem = $data_viagem[2] . '-' . $data_viagem[1] . '-' . $data_viagem[0];
                //$campo_reagendada = "'data_reagendada' => ".$data_reagendada.",";
            } else {

                $data_viagem = null;
            }	
            if ($data_canhoto <> '') {
                $data_canhoto = explode('/', $data_canhoto);
                $data_canhoto = $data_canhoto[2] . '-' . $data_canhoto[1] . '-' . $data_canhoto[0];
                //$campo_reagendada = "'data_reagendada' => ".$data_reagendada.",";
            } else {

                $data_canhoto = null;
            }
            if ($data_nf_faturamento <> '') {
                $data_nf_faturamento = explode('/', $data_nf_faturamento);
                $data_nf_faturamento = $data_nf_faturamento[2] . '-' . $data_nf_faturamento[1] . '-' . $data_nf_faturamento[0];
                //$campo_nf_faturamento = "'data_nf_faturamento' => ".$data_nf_faturamento.",";
            } else {

                $data_nf_faturamento = null;
            }
            if ($data_devolucao <> '') {
                $data_devolucao = explode('/', $data_devolucao);
                $data_devolucao = $data_devolucao[2] . '-' . $data_devolucao[1] . '-' . $data_devolucao[0];
                //$campo_nf_faturamento = "'data_nf_faturamento' => ".$data_nf_faturamento.",";
            } else {

                $data_devolucao = null;
            }

            if (!empty($this->input->post('nf_venda_dev'))) {
                $nf_venda_dev = $this->input->post('nf_venda_dev');
            } else {
                $nf_venda_dev = null;
            }

            if (!empty($this->input->post('nf_cliente'))) {
                $nf_cliente = $this->input->post('nf_cliente');
            } else {

                $nf_cliente = NULL;
            }

            if (!empty($this->input->post('numero_nf'))) {

                $numero_nf = $this->input->post('numero_nf');
            } else {
                $numero_nf = NULL;
            }


            if (!empty($this->input->post('numpedido_os'))) {

                $numpedido_os = $this->input->post('numpedido_os');
            } else {

                $numpedido_os = NULL;
            }

            if (!empty($this->input->post('tag'))) {
                $tag = $this->input->post('tag');
            } else {
                $tag = NULL;
            }

            if (!empty($this->input->post('statusDesenho'))) {
                $statusDesenho = $this->input->post('statusDesenho');
            } else {
                $statusDesenho = null;
            }
            if (!empty($this->input->post('obs_desenho'))) {
                $obs_desenho = $this->input->post('obs_desenho');
            } else {
                $obs_desenho = null;
            }

            if (!empty($this->input->post('idVerificacaoControle'))) {
                $verificacaoControle = $this->input->post('idVerificacaoControle');
            } else {
                $verificacaoControle = null;
            }
            
            if ($this->input->post('qtd_os') < $this->input->post('qtd_os_original')) {
                $gerarnovaqtd = $this->input->post('qtd_os_original') - $this->input->post('qtd_os');
				$exported_queryfactory_at = ($exported_queryfactory_at == '0000-00-00 00:00:00') ? NULL : $exported_queryfactory_at;
                if(!empty($verificacaoControle)){
                    $data3 = array(
                        'data_abertura' => $data_abertura . " " . date("h:i:s"),
                        'data_abertura_real' => date('Y-m-d H:i:s'),
                        'obs_controle' => ($this->input->post('obs_controle')),
                        'obs_os' => $this->input->post('obs_os'),
                        'data_entrega' => $data_entrega,
                        'data_canhoto'=>$data_canhoto,
                        'data_expedicao'=>$data_expedicao,
						'data_viagem'=>$data_viagem,
                        'data_reagendada' => $data_reagendada,
						'data_reagendada_count' => $data_reagendada_count,
						'data_planejada' => $data_planejada,
						'data_planejada_count' => $data_planejada_count,						
                        'data_nf_faturamento' => $data_nf_faturamento,
                        'data_devolucao' => $data_devolucao,
                        'idOrcamento_item' => $this->input->post('idOrcamento_item'),
                        'idOrcamentos' => $this->input->post('idOrcamentos'),
                        'subtot_os' => $subtot_os,
                        'desconto_os' => $desconto_,
                        'val_ipi_os' => $val_ipi_,
                        'val_unit_os' => $valorunita,
                        'qtd_os' => $gerarnovaqtd,
                        'nf_venda_dev' => $nf_venda_dev,
                        'id_tipo' => $this->input->post('id_tipo'),
                        'idVerificacaoControle' => $verificacaoControle,
                        'nf_cliente' => $nf_cliente,
                        'numero_nf' => $numero_nf,
                        'numpedido_os' => $numpedido_os,
                        'tag' => $tag,
                        'tag' => $tag,
                        'idStatusOs' => $this->input->post('idStatusOs'),
                        'unid_execucao' => $this->input->post('unid_execucao'),
                        'unid_faturamento' => $this->input->post('unid_faturamento'),
                        'contrato' => $this->input->post('contrato'),
                        'statusDesenho' => $statusDesenho,
                        'obsDesenho' => $obs_desenho,
                        'fechadoPCP' =>1,
						'exported_queryfactory_at' => $exported_queryfactory_at
						

    
    
    
                    );
                }else{
                    $data3 = array(
                        'data_abertura' => $data_abertura . " " . date("h:i:s"),
                        'data_abertura_real' => date('Y-m-d H:i:s'),
                        'obs_controle' => ($this->input->post('obs_controle')),
                        'obs_os' => $this->input->post('obs_os'),
                        'data_entrega' => $data_entrega,
                        'data_canhoto'=>$data_canhoto,
                        'data_expedicao'=>$data_expedicao,
						'data_viagem'=>$data_viagem,
                        'data_reagendada' => $data_reagendada,
						'data_reagendada_count' => $data_reagendada_count,
						'data_planejada' => $data_planejada,
						'data_planejada_count' => $data_planejada_count,						
                        'data_nf_faturamento' => $data_nf_faturamento,
                        'data_devolucao' => $data_devolucao,
                        'idOrcamento_item' => $this->input->post('idOrcamento_item'),
                        'idOrcamentos' => $this->input->post('idOrcamentos'),
                        'subtot_os' => $subtot_os,
                        'desconto_os' => $desconto_,
                        'val_ipi_os' => $val_ipi_,
                        'val_unit_os' => $valorunita,
                        'qtd_os' => $gerarnovaqtd,
                        'nf_venda_dev' => $nf_venda_dev,
                        'id_tipo' => $this->input->post('id_tipo'),
                        'nf_cliente' => $nf_cliente,
                        'numero_nf' => $numero_nf,
                        'numpedido_os' => $numpedido_os,
                        'tag' => $tag,
                        'tag' => $tag,
                        'idStatusOs' => $this->input->post('idStatusOs'),
                        'unid_execucao' => $this->input->post('unid_execucao'),
                        'unid_faturamento' => $this->input->post('unid_faturamento'),
                        'contrato' => $this->input->post('contrato'),
                        'statusDesenho' => $statusDesenho,
                        'obsDesenho' => $obs_desenho,
                        'fechadoPCP' =>1,
						'exported_queryfactory_at' => $exported_queryfactory_at
    
    
    
                    );
                }

                

                $id_novo = $this->orcamentos_model->add('os', $data3, true);

                $descricao = serialize($data3);
                $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'inserir', $descricao, $id_novo);


                $data4 = array(

                    'idOs_principal' => $this->input->post('idOs2'),
                    'idOs_gerada' => $id_novo


                );

                $vinc =    $this->orcamentos_model->add('os_vinculada', $data4, true);

                $descricao = serialize($data4);
                $this->salvarlog($this->session->userdata('idUsuarios'), 'os_vinculada', 'inserir', $descricao, $vinc);


                $this->data['anexo_desenho'] = $this->os_model->getanexos_os($this->input->post('idOs2'), 'anexo_desenho');
                foreach ($this->data['anexo_desenho'] as $item) {
                    $data_an = array(
                        'nomeArquivo' => $item->nomeArquivo,
                        'idOs' => $id_novo,
                        'data_cadastro' => $item->data_cadastro,
                        'nomeArquivo' => $item->nomeArquivo,
                        'caminho' => $item->caminho,
                        'imagem' => $item->imagem,
                        'extensao' => $item->extensao,
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'tamanho' => $item->tamanho,
                        'user_proprietario' => $item->user_proprietario
                    );

                    $iddesenho =    $this->os_model->add('anexo_desenho', $data_an, true);


                    $descricao = serialize($data_an);
                    $this->salvarlog($this->session->userdata('idUsuarios'), 'anexo_desenho', 'inserir', $descricao, $iddesenho);
                }

                $this->data['anexo_nfcliente'] = $this->os_model->getanexos_os($this->input->post('idOs2'), 'anexo_nfcliente');
                foreach ($this->data['anexo_nfcliente'] as $item) {
                    $data_an = array(
                        'nomeArquivo' => $item->nomeArquivo,
                        'idOs' => $id_novo,
                        'data_cadastro' => $item->data_cadastro,
                        'nomeArquivo' => $item->nomeArquivo,
                        'caminho' => $item->caminho,
                        'imagem' => $item->imagem,
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'extensao' => $item->extensao,
                        'tamanho' => $item->tamanho
                    );

                    $idane = $this->os_model->add('anexo_nfcliente', $data_an, true);
                    $descricao = serialize($data_an);
                    $this->salvarlog($this->session->userdata('idUsuarios'), 'anexo_nfcliente', 'inserir', $descricao, $idane);
                }
                $this->data['anexo_nfvenda'] = $this->os_model->getanexos_os($this->input->post('idOs2'), 'anexo_nfvenda');
                foreach ($this->data['anexo_nfvenda'] as $item) {
                    $data_an = array(
                        'nomeArquivo' => $item->nomeArquivo,
                        'idOs' => $id_novo,
                        'data_cadastro' => $item->data_cadastro,
                        'nomeArquivo' => $item->nomeArquivo,
                        'caminho' => $item->caminho,
                        'imagem' => $item->imagem,
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'extensao' => $item->extensao,
                        'tamanho' => $item->tamanho
                    );

                    $id_nf = $this->os_model->add('anexo_nfvenda', $data_an, true);
                    $descricao = serialize($data_an);
                    $this->salvarlog($this->session->userdata('idUsuarios'), 'anexo_nfvenda', 'inserir', $descricao, $id_nf);
                }
                $this->data['anexo_notafiscal'] = $this->os_model->getanexos_os($this->input->post('idOs2'), 'anexo_notafiscal');
                foreach ($this->data['anexo_notafiscal'] as $item) {
                    $data_an = array(
                        'nomeArquivo' => $item->nomeArquivo,
                        'idOs' => $id_novo,
                        'data_cadastro' => $item->data_cadastro,
                        'nomeArquivo' => $item->nomeArquivo,
                        'caminho' => $item->caminho,
                        'imagem' => $item->imagem,
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'extensao' => $item->extensao,
                        'tamanho' => $item->tamanho
                    );

                    $idnf = $this->os_model->add('anexo_notafiscal', $data_an, true);
                    $descricao = serialize($data_an);
                    $this->salvarlog($this->session->userdata('idUsuarios'), 'anexo_notafiscal', 'inserir', $descricao, $idnf);
                }
                $this->data['anexo_pedido'] = $this->os_model->getanexos_os($this->input->post('idOs2'), 'anexo_pedido');
                foreach ($this->data['anexo_pedido'] as $item) {
                    $data_an = array(
                        'nomeArquivo' => $item->nomeArquivo,
                        'idOs' => $id_novo,
                        'data_cadastro' => $item->data_cadastro,
                        'nomeArquivo' => $item->nomeArquivo,
                        'caminho' => $item->caminho,
                        'imagem' => $item->imagem,
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'extensao' => $item->extensao,
                        'tamanho' => $item->tamanho
                    );

                    $nfpedido = $this->os_model->add('anexo_pedido', $data_an, true);
                    $descricao = serialize($data_an);
                    $this->salvarlog($this->session->userdata('idUsuarios'), 'anexo_pedido', 'inserir', $descricao, $nfpedido);
                }
                $itemOrc = $this->orcamentos_model->getitem($this->input->post('idOrcamento_item'));
                if ($this->input->post('unid_execucao') == 2) {
                    $classe = 2;
                } else {
                    $classe = 1;
                }
                $dataSubOs = array(
                    "idOs" => $id_novo,
                    "idProduto_master" => $itemOrc->idProdutos,
                    "idProduto_sub" => $itemOrc->idProdutos,
                    "posicao" => 0,
                    "data_insert" => date('Y-m-d H:i:s'),
                    "quantidade" =>$gerarnovaqtd,
                    "idClasse" => $classe,
                    "ativo" => 1,
                    "descricaoOsSub" => $itemOrc->descricao_item
                );
                $this->orcamentos_model->add("os_sub", $dataSubOs);
            }
            if(!empty($verificacaoControle)){
                $data = array(
                    'data_abertura' => $data_abertura . " " . date("h:i:s"),
                    'data_entrega' => $data_entrega,
                    'data_canhoto'=>$data_canhoto,
                    'data_expedicao'=>$data_expedicao,
					'data_viagem'=>$data_viagem,
                    'obs_os' => $this->input->post('obs_os'),
                    'data_reagendada' => $data_reagendada,
					'data_reagendada_count' => $data_reagendada_count,
					'data_planejada' => $data_planejada,
					'data_planejada_count' => $data_planejada_count,					
                    'data_nf_faturamento' => $data_nf_faturamento,
                    'data_devolucao' => $data_devolucao,
                    'desconto_os' => $desconto_,
                    'val_ipi_os' => $val_ipi_,
                    'val_unit_os' => $valorunita,
                    'subtot_os' => $subtot_os,
                    'qtd_os' => $this->input->post('qtd_os'),
                    'idVerificacaoControle' => $verificacaoControle,
                    'idStatusOs' => $this->input->post('idStatusOs'),
                    'unid_execucao' => $this->input->post('unid_execucao'),
                    'unid_faturamento' => $this->input->post('unid_faturamento'),
                    'contrato' => $this->input->post('contrato'),
                    'nf_venda_dev' => $nf_venda_dev,
                    'id_tipo' => $this->input->post('id_tipo'),
                    'nf_cliente' => $nf_cliente,
                    'numero_nf' => $numero_nf,
                    'numpedido_os' => $numpedido_os,
                    'tag' => $tag,
                    'statusDesenho' => $statusDesenho,
                    'obsDesenho' => $obs_desenho
                );
            }else{
                $data = array(
                    'data_abertura' => $data_abertura . " " . date("h:i:s"),
                    'data_entrega' => $data_entrega,
                    'data_canhoto'=>$data_canhoto,
                    'data_expedicao'=>$data_expedicao,
					'data_viagem'=>$data_viagem,
                    'obs_os' => $this->input->post('obs_os'),
                    'data_reagendada' => $data_reagendada,
					'data_reagendada_count' => $data_reagendada_count,
                    'data_planejada' => $data_planejada,
					'data_planejada_count' => $data_planejada_count,					
                    'data_nf_faturamento' => $data_nf_faturamento,
                    'data_devolucao' => $data_devolucao,
                    'desconto_os' => $desconto_,
                    'val_ipi_os' => $val_ipi_,
                    'val_unit_os' => $valorunita,
                    'subtot_os' => $subtot_os,
                    'qtd_os' => $this->input->post('qtd_os'),
                    'idStatusOs' => $this->input->post('idStatusOs'),
                    'unid_execucao' => $this->input->post('unid_execucao'),
                    'unid_faturamento' => $this->input->post('unid_faturamento'),
                    'contrato' => $this->input->post('contrato'),
                    'nf_venda_dev' => $nf_venda_dev,
                    'id_tipo' => $this->input->post('id_tipo'),
                    'nf_cliente' => $nf_cliente,
                    'numero_nf' => $numero_nf,
                    'numpedido_os' => $numpedido_os,
                    'tag' => $tag,
                    'statusDesenho' => $statusDesenho,
                    'obsDesenho' => $obs_desenho 
                );
            }

            $status_faturado = $this->os_model->getStatusF();
            $verifyStatus = false;
            foreach($status_faturado as $v){
                if($v->idStatusOs == $this->input->post('idStatusOs')){
                    $verifyStatus = true;
                }
            }

            if($verifyStatus){
                $itensOs = $this->almoxarifado_model->getItensReservadoOs(" and almo_estoque.idOs = ".$this->input->post('idOs2'));
                if(count($itensOs)>0){
                    $email = "";
                    $listEmail = $this->orcamentos_model->getUsuariosComPermissao('"emailSobra";s:1:"1";');
                    foreach($listEmail as $r){
                        if(!empty($r->email)){
                            //$this->send($r->email,"Orçamento: ".$orc->idOrcamentos." - SOLICITAÇÃO DE PERITAGEM","PN: ".$orc->pn." - ".$orc->descricao_item);
                            $email = $email.$r->email.",";
                        }
                    }
                    try{
                        $this->send($email,"O.S.: ".$this->input->post('idOs2')." - Finalizada com Materiais no Almoxarifado","");
                    }catch(Exception $e){}
                }
            }
            $data2 = array(
                'descricao_item' => $this->input->post('descricao_os')

            );
            
            $this->data['result'] = $this->os_model->getByid_table($this->input->post('idOs2'), 'os', 'idOs');
            if(!empty($this->data['result']->idSimplexAtividade)){
                if($this->input->post('idStatusOs') == 5 && $this->input->post('unid_execucao') == 2){
                    //$this->simplexUpdateAtividade($this->data['result']->idSimplexAtividade,"1652280851846x229444076177981440",$this->input->post('idOs2'));
                }else{
                    //$this->simplexUpdateAtividade($this->data['result']->idSimplexAtividade,"1650891880589x672038920761376800",$this->input->post('idOs2'));
                }
            }
            

            $descricao = serialize($this->data['result']);
            $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'editar', $descricao, $this->input->post('idOs2'));



            if ($this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs2')) == TRUE) {

                $this->data['result'] = $this->os_model->getByid_table($this->input->post('idOrcamento_item'), 'orcamento_item', 'idOrcamento_item');
                $descricao = serialize($this->data['result']);
                $this->salvarlog($this->session->userdata('idUsuarios'), 'orcamento_item', 'editar', $descricao, $this->input->post('idOrcamento_item'));


                $this->orcamentos_model->edit('orcamento_item', $data2, 'idOrcamento_item', $this->input->post('idOrcamento_item'));
                $os = $this->os_model->getByid_table($this->input->post('idOs2'), 'os', 'idOs');
                $this->os_model->insertOSHis($os);

                $this->session->set_flashdata('success', 'Os editada com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs2'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
                redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs2'));
            }
        }

        /*$this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['anexos'] = $this->os_model->getAnexos($this->uri->segment(3));
        $this->data['view'] = 'os/editarOs';
        $this->load->view('tema/topo', $this->data);*/
    }

    public function editar_anexo()
    {


        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'adesenhoOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar desenho.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe um nome!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {

            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'idOs' => $this->input->post('idOs'),
                'idAnexo' => $this->input->post('idAnexo'),
                'tipo' => $this->input->post('tipo')
            );




            if ($this->os_model->edit('anexo_desenho', $data, 'idAnexo', $this->input->post('idAnexo')) == TRUE) {

                /* $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumo','editar',$descricao );
               */

                $this->session->set_flashdata('success', 'Desenho editado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }
    }
    public function excluiranexo()
    {


        $id = $this->input->post('idAnexo');

        $idOs = $this->input->post('idOs');
        if ($id == null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }

        $imagem = $this->input->post('imagem');
        if ($this->os_model->getimagem_base($id, $imagem, 'anexo_desenho') == true) {
            $this->session->set_flashdata('error', 'Esse arquivo não pode ser excluido , pois ele esta vinculado a outra OS.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }


        $file = $this->os_model->getimagem($id);
        $this->db->where('idAnexo', $id);




        if ($this->db->delete('anexo_desenho')) {
            $path = FCPATH . $file->caminho . $file->imagem;
            unlink($path);
            $this->session->set_flashdata('success', 'Arquivo excluido com sucesso!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar excluir o arquivo.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }
    }

    public function editaobs_os()
    {
        if ($this->input->post('obs_os') <> '') {
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
            }
            $data = array(
                'idOs' => $this->input->post('idOs'),
                'obs_os' => $this->input->post('obs_os')
            );
        } else if($this->input->post('obs_pcp') <> ''){
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aObsPlanejamento')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
            }
            $data = array(
                'idOs' => $this->input->post('idOs'),
                'obs_pcp' => $this->input->post('obs_pcp')
            );
        }else {
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eErificacaocontroleOS')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
            }
            $data = array(
                'idOs' => $this->input->post('idOs'),
                'obs_controle' => ($this->input->post('obs_controle'))
            );
        }










        if ($this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs')) == TRUE) {
            $os = $this->os_model->getByid_table($this->input->post('idOs'), 'os', 'idOs');
            //$os->idUserHis = $this->session->userdata('idUsuarios');
            //var_dump($os); exit;
            $this->os_model->insertOSHis($os,$this->session->userdata('idUsuarios'));
            /* $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumo','editar',$descricao );
               */

            $this->session->set_flashdata('success', 'OBS editado com sucesso!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {
            $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
        }
    }

    

    public function editaobs()
    {


        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }
        if ($this->input->post('obs_os') <> '') {
            $data = array(
                'idOs' => $this->input->post('idOs'),
                'obs_os' => $this->input->post('obs_os')
            );
        } else {
            $data = array(
                'idOs' => $this->input->post('idOs'),
                'obs_controle' => ($this->input->post('obs_controle'))
            );
        }
        if ($this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs')) == TRUE) {

            /* $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumo','editar',$descricao );
               */

            $this->session->set_flashdata('success', 'OBS editado com sucesso!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {
            $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
        }
    }

public function getObsHistoryByIdOs($idOs) {
    $this->db->select('os_history.idOsHis, os_history.idUserHis, os_history.data_alteracaoHis, os_history.obs_os, usuarios.nome');
    $this->db->from('os_history');
    $this->db->join('usuarios', 'usuarios.idUsuarios = os_history.idUserHis', 'left');
    $this->db->where('os_history.idOsHis', $idOs);
    $this->db->order_by('os_history.data_alteracaoHis', 'DESC'); // Ordena do mais recente para o mais antigo
    return $this->db->get()->result();
}

public function getHistoricoDataProducaoAjax()
{
    $idOs = $this->input->post('idOs');
    $dados = $this->os_model->getHistoricoDataProducao($idOs);

    if ($dados) {
        echo json_encode(['status' => 'success', 'result' => $dados]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Nenhum histórico encontrado.']);
    }
}

///////////////////////aqui obtemos os valores dos insumos entre outras coisas/////////////////////////////////////////////
public function visualizar()
{
    if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
        $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
        redirect(base_url());
    }

    $idOs = $this->uri->segment(3);

    $this->data['custom_error'] = '';
    $this->load->model('almoxarifado_model');
    $this->load->model('orcamentos_model');
    $this->load->model('producao_model');
    $this->load->model('peritagem_model');

    // Distribuição
    $this->data['distribuir_os'] = $this->os_model->getmaterial_dist($idOs);

    // Hora máquina
    $this->data['hrmaquina_os'] = $this->producao_model->getHoraMaqForIdOsFinalizado($idOs);

    // Dados da OS
    $this->data['result'] = $this->os_model->getById($idOs);

    // Anexos e histórico de observações
    $this->data['obs_history'] = $this->os_model->getObsHistoryByIdOs($idOs);
    $this->data['anexo_desenho'] = $this->os_model->getdesenho_os2($idOs);
    $this->data['anexo_pedido'] = $this->os_model->getpedido_os($idOs);
    $this->data['anexo_nf'] = $this->os_model->getnf_os($idOs, 'anexo_notafiscal');
    $this->data['anexo_nfcliente'] = $this->os_model->getnf_os($idOs, 'anexo_nfcliente');
    $this->data['anexo_nfvenda'] = $this->os_model->getnf_os($idOs, 'anexo_nfvenda');
    $this->data['anexo_nfcanhoto'] = $this->os_model->getnf_os($idOs, 'anexo_nfcanhoto');

    // Orçamento
    $this->data['orcamento'] = $this->orcamentos_model->getById('orcamento', $this->data['result']->idOrcamentos);
    if ($this->data['orcamento'] === null) {
        $this->session->set_flashdata('error', 'Orçamento não encontrado para esta OS.');
        redirect('os');
        return;
    }
    $this->data['status_os'] = $this->os_model->getstatus_os();
    $this->data['escopo'] = $this->peritagem_model->getOrcEscopoItemByIdOs($idOs);
    $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($this->data['orcamento']->idNatOperacao);
    $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
    $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
    $this->data["motivos"] = $this->almoxarifado_model->get2('motivos_liberacao',"*",null,false);
    $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
    $this->data['verificacao_controle'] = $this->os_model->getVerificacaoControle();

    // Saídas almox.
    $this->data['saidas_almoxarifado'] =
        $this->almoxarifado_model->getSaida2(
            ' WHERE (almo_estoque.idOs is null OR almo_estoque.idOs = 0 OR almo_estoque.idOs = "")
              AND almo_estoque_saida.idOs = '.$idOs
        );

    // Itens do orçamento
    $this->data['itens_orcamento'] =
        $this->orcamentos_model->get_item_orc($this->data['result']->idOrcamento_item);

    // Emitente
    $this->data['dados_emitente'] =
        $this->orcamentos_model->getEmitente($this->data['orcamento']->idEmitente);

    // Frete
    $result = $this->os_model->getPedidosCompraFrete($idOs);
    $valorFrete = 0;
    foreach($result as $r){
        $valorFrete += (($r->frete / $r->quantidadeProdutos) * $r->quantidadeProdutosOs);
    }
    $this->data['valor_frete'] = $valorFrete;

    // ICMS
    $resultIcms = $this->os_model->getPedidosCompraIcms($idOs);
    $valorIcms = 0;
    foreach($resultIcms as $r){
        $valorIcms += $r->icms;
    }
    $this->data['valorIcms'] = $valorIcms;

    // Histórico de status
    $resultAlteracoesStatus = $this->os_model->getHisStatusOs($idOs);

    $contt = $conttDEntr = $conttDRep = $conttDes = $conttCont = 0;
    $arrayAlteracoesStatus = [];
    $arrayAlteracoesDataEntrega = [];
    $arrayAlteracoesDataReprogramada = [];
    $arrayAlteracoesDesenho = [];
    $arrayAlteracoesCont = [];

    $anterior = $anteriorDEntr = $anteriorDReprogramada = $anteriorDes = $anteriorCont = null;

    foreach($resultAlteracoesStatus as $r){

        if($contt == 0){ $anterior = $r->nomeStatusOs; $arrayAlteracoesStatus[] = $r; $contt = 1; }
        else{
            if($anterior != $r->nomeStatusOs){ $arrayAlteracoesStatus[] = $r; $anterior = $r->nomeStatusOs; }
            else{ $arrayAlteracoesStatus[count($arrayAlteracoesStatus)-1] = $r; }
        }

        if($conttDEntr == 0){ $anteriorDEntr = $r->data_entrega; $arrayAlteracoesDataEntrega[] = $r; $conttDEntr = 1; }
        else{
            if($anteriorDEntr != $r->data_entrega){ $arrayAlteracoesDataEntrega[] = $r; $anteriorDEntr = $r->data_entrega; }
            else{ $arrayAlteracoesDataEntrega[count($arrayAlteracoesDataEntrega)-1] = $r; }
        }

        if($conttDRep == 0){ $anteriorDReprogramada = $r->data_reagendada; $arrayAlteracoesDataReprogramada[] = $r; $conttDRep = 1; }
        else{
            if($anteriorDReprogramada != $r->data_reagendada){ $arrayAlteracoesDataReprogramada[] = $r; $anteriorDReprogramada = $r->data_reagendada; }
            else{ $arrayAlteracoesDataReprogramada[count($arrayAlteracoesDataReprogramada)-1] = $r; }
        }

        if($conttDes == 0){ $anteriorDes = $r->statusDesenho; $arrayAlteracoesDesenho[] = $r; $conttDes = 1; }
        else{
            if($anteriorDes != $r->statusDesenho){ $arrayAlteracoesDesenho[] = $r; $anteriorDes = $r->statusDesenho; }
            else{ $arrayAlteracoesDesenho[count($arrayAlteracoesDesenho)-1] = $r; }
        }

        if($conttCont == 0){ $anteriorCont = $r->descricaoControle; $arrayAlteracoesCont[] = $r; $conttCont = 1; }
        else{
            if($anteriorCont != $r->descricaoControle){ $arrayAlteracoesCont[] = $r; $anteriorCont = $r->descricaoControle; }
            else{ $arrayAlteracoesCont[count($arrayAlteracoesCont)-1] = $r; }
        }
    }

	$this->data['alteracoesStatus'] = $arrayAlteracoesStatus;
    $this->data['alteracoesDataEntrega'] = $arrayAlteracoesDataEntrega;

    // --- ✅ CORREÇÃO CIRÚRGICA: PRIORIDADE PARA A TABELA DE MOTIVOS ---
    // Removemos a atribuição do $arrayAlteracoesDataReprogramada (que trazia lixo do os_history)
    // e usamos diretamente a função que busca os dados do "disquete".
    $this->data['alteracoesDataReagendada'] = $this->os_model->getMotivosReagendamento($idOs);

    $this->data['alteracoesDesenho'] = $arrayAlteracoesDesenho;
    $this->data['alteracoesCont'] = $arrayAlteracoesCont;

    // Histórico da data de produção (PCP)
    $this->data['historicoDataProducao'] = $this->os_model->getHistoricoDataProducao($idOs);

    // Sub OS
    $this->data['subOs'] = $this->os_model->getSubOsByIdOs($idOs);

    // View
    $this->data['view'] = 'os/visualizarOs';
    $this->load->view('tema/topo', $this->data);
}
	
	
	
///////////////////////aqui obtemos os valores dos insumos entre outras coisas/////////////////////////////////////////////
	
	
	
    public function distribuiros()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs') && !$this->permission->checkPermission($this->session->userdata('permissao'), 'vDistribuirOs') && !$this->permission->checkPermission($this->session->userdata('permissao'), 'vDistribuirOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para Distribuir OS.');
            redirect(base_url());
        }
        if (!empty($this->uri->segment(4))) {
            $expl = explode('-', $this->uri->segment(4));

            $campo = $expl[0];
            $ordertipo = $expl[1];
        } else {
            $campo = 'distribuir_os.data_cadastro';
            $ordertipo = 'desc';
        }


        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        $exibLista = "";
        try {
            if (!empty($this->input->post('exibirLista')))
                $exibLista = $this->input->post('exibirLista');
        } catch (Exception $e) {
        }
        $where = '';
        if (!empty($this->input->post('statusCompra'))) {
            $where = 'distribuir_os.idStatuscompras = ' . $this->input->post('statusCompra');
        }
        #debug_to_console($exibLista);
        echo ("<script>console.log('List: " . $exibLista . "');</script>");
        if (!empty($exibLista)) {
            if ($exibLista > 1) {
                $this->data['distribuir_os'] = $this->os_model->getmaterial_dist($this->uri->segment(3), $ordertipo, $campo, $exibLista, $where);
                #  echo("<script>console.log('N: 1');</script>");
            } else {
                $this->data['distribuir_os'] = $this->os_model->getmaterial_dist($this->uri->segment(3), $ordertipo, $campo, null, $where);
                # echo("<script>console.log('N: 2');</script>");
            }
        } else {
            $this->data['distribuir_os'] = $this->os_model->getmaterial_dist($this->uri->segment(3), $ordertipo, $campo, 150, $where);
            # echo("<script>console.log('N: 3');</script>");
        }

        $this->load->model('cotacao_model');
        $this->load->model('almoxarifado_model');
        $this->data['almoxarifado_reservados'] = $this->almoxarifado_model->getEstoqueFilter(' almo_estoque.idOs = '.$this->uri->segment(3));
        $this->data['almoxarifado_entrada'] = $this->almoxarifado_model->getEntrada(' WHERE almo_estoque_entrada.idOs = '.$this->uri->segment(3));
        $this->data['almoxarifado_saida'] = $this->almoxarifado_model->getSaida(' WHERE almo_estoque_saida.idOs = '.$this->uri->segment(3));
        $this->data['vale'] = $this->almoxarifado_model->getValeByOs($this->uri->segment(3));
        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
        $this->data['dados_statusgrupo'] = $this->os_model->getstatus_grupo('');
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['anexo_desenho'] = $this->os_model->getdesenho_os($this->uri->segment(3));
        $this->data['anexo_pedido'] = $this->os_model->getpedido_os($this->uri->segment(3));
        $this->data['anexo_nf'] = $this->os_model->getnf_os($this->uri->segment(3), 'anexo_notafiscal');
        $this->data['anexo_nfcliente'] = $this->os_model->getnf_os($this->uri->segment(3), 'anexo_nfcliente');
        $this->data['anexo_nfvenda'] = $this->os_model->getnf_os($this->uri->segment(3), 'anexo_nfvenda');
        $this->data['orcamento'] = $this->orcamentos_model->getById('orcamento', $this->data['result']->idOrcamentos);
        if ($this->data['orcamento'] === null) {
            $this->session->set_flashdata('error', 'Orçamento não encontrado para esta OS.');
            redirect('os');
            return;
        }
        $this->data['status_os'] = $this->os_model->getstatus_os();
        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($this->data['orcamento']->idNatOperacao);
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
        $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
        $this->data['subOs'] = $this->os_model->getSubOsByIdOs2($this->uri->segment(3));
        $this->data['classe'] = $this->os_model->get_table('classe_item_escopo');

        for($x=0;$x<count($this->data['subOs']);$x++){
            //$this->data['dados_sugestao'] = $this->os_model->getSugestaoOsSub();
            $where2 = "";
            $where4 = "";
            if (!empty($this->input->post('statusCompra'))) {
                $where2 = 'distribuir_os.idStatuscompras = ' . $this->input->post('statusCompra');
                $where4 = 'distribuir_os.idStatuscompras = ' . $this->input->post('statusCompra');
            }
            if(!empty($where2)){
                $where2 .= " and ";
                $where4 .= " and ";
            }
            $dados_sugestao = $this->os_model->getSugestaoOsSub($this->data['subOs'][$x]->idOsSub);
            if(!empty($dados_sugestao)){
                $this->data['subOs'][$x]->sugestaoDistribuir = $dados_sugestao;
            }else{
                $this->data['subOs'][$x]->sugestaoDistribuir = array();
            }
            $where2 .= 'distribuir_os.idOsSub = '.$this->data['subOs'][$x]->idOsSub;
            $resultado = $this->os_model->getmaterial_dist($this->uri->segment(3), $ordertipo, $campo, 150, $where2);
            if(!empty($resultado)){ 
                $this->data['subOs'][$x]->distribuiros =$resultado;
            }else{
                $this->data['subOs'][$x]->distribuiros = array();
            }
            if($this->data['subOs'][$x]->posicao == 0){
                $where4 .= 'distribuir_os.idOsSub is null ';
                $resultado = $this->os_model->getmaterial_dist($this->uri->segment(3), $ordertipo, $campo, 150, $where4);
                if(!empty($resultado)){
                    $this->data['subOs'][$x]->distribuiros = array_merge($resultado,$this->data['subOs'][$x]->distribuiros);
                }
            }
        }
        
        /*   
        $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico($this->data['orcamento']->idGrupoServico);*/
        $this->data['itens_orcamento'] = $this->orcamentos_model->get_item_orc($this->data['result']->idOrcamento_item);

        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente($this->data['orcamento']->idEmitente);



        $this->data['view'] = 'os/distribuiros';
        $this->load->view('tema/topo', $this->data);
    }




    public function maquinas(){
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eHoramaquinas')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar hr/maquinas OS.');
            redirect(base_url());
        }


        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');

        $this->data['hrmaquina_os'] = $this->os_model->gethoramaquina($this->uri->segment(3));

        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['anexo_desenho'] = $this->os_model->getdesenho_os($this->uri->segment(3));
        $this->data['anexo_pedido'] = $this->os_model->getpedido_os($this->uri->segment(3));
        $this->data['anexo_nf'] = $this->os_model->getnf_os($this->uri->segment(3), 'anexo_notafiscal');
        $this->data['anexo_nfcliente'] = $this->os_model->getnf_os($this->uri->segment(3), 'anexo_nfcliente');
        $this->data['anexo_nfvenda'] = $this->os_model->getnf_os($this->uri->segment(3), 'anexo_nfvenda');
        $this->data['orcamento'] = $this->orcamentos_model->getById('orcamento', $this->data['result']->idOrcamentos);
        $this->data['status_os'] = $this->os_model->getstatus_os();
        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($this->data['orcamento']->idNatOperacao);
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
        $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
        /*   
        $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico($this->data['orcamento']->idGrupoServico);*/
        $this->data['itens_orcamento'] = $this->orcamentos_model->get_item_orc($this->data['result']->idOrcamento_item);

        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente($this->data['orcamento']->idEmitente);

$this->data['view'] = 'os/maquinas';
        $this->load->view('tema/topo', $this->data);
    }
    public function autoCompleteDistribuir(){

        if ($this->input->get('term') !== null) {
            $q = strtolower($this->input->get('term', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteDistribuir($q);
        }
        if ($this->input->get('term2') !== null) {
            $q = strtolower($this->input->get('term2', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteDistribuir($q);
        }
        if ($this->input->get('term22') !== null) {
            $q = strtolower($this->input->get('term22', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteDistribuir($q);
        }
    }
    public function autoCompleteDistribuir3()
    {

        if ($this->input->get('term') !== null) {
            $q = strtolower($this->input->get('term', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteDistribuir2($q);
        }
        if ($this->input->get('term2') !== null) {
            $q = strtolower($this->input->get('term2', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteDistribuir2($q);
        }
        if ($this->input->get('term22') !== null) {
            $q = strtolower($this->input->get('term22', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteDistribuir2($q);
        }
    }
    public function autoCompleteDistribuir2()
    {


        if ($this->input->get('dados2') !== null) {
            $q = strtolower($this->input->get('dados2', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteDistribuir($q);
        }
        if ($this->input->get('prod') !== null) {
            $q = strtolower($this->input->get('prod', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteProduto2($q);
        }
    }
    public function autoCompleteProduto2()
    {
        if (!empty($this->input->get('term', TRUE))) {
            $q = strtolower($this->input->get('term', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteProduto2($q);
        }
    }
    public function autoCompleteMaquina()
    {


        if ($this->input->get('term') !== null) {
            $q = strtolower($this->input->get('term', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteMaquina($q);
        }
    }
    public function autoCompleteMaquinauser()
    {


        if ($this->input->get('term') !== null) {
            $q = strtolower($this->input->get('term', TRUE));
            //$campo = $this->input->get('campo', TRUE);

            $this->os_model->autoCompleteMaquinauser($q);
        }
    }
    public function cad_distribuir2()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para distribuir OS.');
            redirect(base_url());
        }
        for($x=0;$x<count($this->input->post("idDistribuirSugestao"));$x++){
            $distribuirSug = $this->os_model->getInforDistribuirSugestao($this->input->post("idDistribuirSugestao")[$x]);
            $data = array(
                "idInsumos"=>$distribuirSug->idInsumos,
				"material_producao" => $distribuirSug->material_producao,
                "dimensoes"=>null,
                "metrica"=>$distribuirSug->metrica,
                "comprimento"=>$distribuirSug->comprimento,
                "peso"=>$distribuirSug->peso,
                "volume"=>$distribuirSug->volume,
                "dimensoesL"=>$distribuirSug->dimensoesL,
                "dimensoesA"=>$distribuirSug->dimensoesA,
                "dimensoesC"=>$distribuirSug->dimensoesC,
                "id_status_grupo"=>$distribuirSug->id_status_grupo,
                "obs"=>$distribuirSug->obs,
                "solicitacao"=>1,
                "quantidade"=>$this->input->post("quantidade")[$x],
                "idOs"=>$this->input->post("idOs"),
                "idOsSub"=>$distribuirSug->idOsSub,
                "usuario_cadastro"=>$this->session->userdata('idUsuarios') 
            );
            if (is_numeric($id3 = $this->os_model->add('distribuir_os', $data, true))) {
                // if ($this->os_model->add('distribuir_os', $data) == TRUE) {

                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'), 'distribuir_os', 'inserir', $descricao, $id3);

                $dataup = "*" . $this->session->userdata('nome') . "|" . date('d-m-Y H:i:s');
                $updalog = array(

                    'histo_alteracao' => $dataup

                );

                $this->os_model->edit('distribuir_os', $updalog, 'idDistribuir', $id3);

                /*$this->os_model->edit_concatena('distribuir_os', $this->session->userdata('idUsuarios')."-".date('d-m-Y H:i:s'), 'histo_alteracao','idDistribuir', $id3);*/

            }
                
            $data3 = array(
                "respondeu"=>1,
                "resposta"=>1
            );
            $this->os_model->edit("distribuir_os_sugestao",$data3,"idDistribuirSugestao",$this->input->post("idDistribuirSugestao")[$x]);  
            
        }
        $this->session->set_flashdata('success', 'Item adicionado com sucesso!');                
        redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
    }
	
	
	
/////////////////////////////alteração adicionar insumos//////////////////////////////////////
	
    /////////////////////////////alteração adicionar insumos//////////////////////////////////////
	
    public function cad_distribuir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para distribuir OS.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('idOs', '', 'trim|required|xss_clean');


        $this->form_validation->set_rules('quantidade', '', 'trim|required|xss_clean');
        $almox = $this->input->post('almoxarifado');

        if(empty($this->input->post('idMedicao')) || $this->input->post('idMedicao')==0){
            $data2 = array("metrica" => "0",
            'dimensoes' => $this->input->post('livre'));
        }
        if($this->input->post('idMedicao')==1){
            if(empty($this->input->post('tamanho'))){
                $this->session->set_flashdata('error', 'Informe o comprimento!');
                redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
            }else{
                $data2 = array("metrica" => "1",
                "comprimento" => $this->input->post('tamanho'));
            }
        }
        if($this->input->post('idMedicao')==2){
            if(empty($this->input->post('volume'))){
                $this->session->set_flashdata('error', 'Informe o volume!');
                redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
            }else{
                $data2 = array("metrica" => "2",
                "volume" => $this->input->post('volume'));
            }
        }
        if($this->input->post('idMedicao')==3){
            if(empty($this->input->post('peso'))){
                $this->session->set_flashdata('error', 'Informe o peso!');
                redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));

            }else{
                $data2 = array("metrica" => "3",
                "peso" => $this->input->post('peso'));
            }
        }
        if($this->input->post('idMedicao')==4){
            if(!empty($this->input->post('dimensoesL')) || !empty($this->input->post('dimensoesC')) || !empty($this->input->post('dimensoesA'))){
                $data2 = array("metrica" => "4",
                "dimensoesL" => (!empty($this->input->post('dimensoesL'))?$this->input->post('dimensoesL'):null),
                "dimensoesC" => (!empty($this->input->post('dimensoesC'))?$this->input->post('dimensoesC'):null),
                "dimensoesA" => (!empty($this->input->post('dimensoesA'))?$this->input->post('dimensoesA'):null));
            }else{
                $this->session->set_flashdata('error', 'Informe as dimensões!');
                redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
            }
        }

        if (empty($almox)) {
            $this->form_validation->set_rules('idInsumos2', '', 'trim|required|xss_clean');
            $insumoid = $this->input->post('idInsumos2');
            $solicitacao = '1';
        } else {
            $this->form_validation->set_rules('idInsumos__2', '', 'trim|required|xss_clean');
            $insumoid = $this->input->post('idInsumos__2');
            $solicitacao = '2';
        }

        if ($this->input->post('idgrupo') == 0) {
            $this->session->set_flashdata('error', 'Informe o grupo!');
            if (empty($almox)) {
                redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
            } else {
                redirect(base_url() . 'index.php/almoxarifado');
            }
        }

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe os dados!');
            if (empty($almox)) {
                redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
            } else {
                redirect(base_url() . 'index.php/almoxarifado');
            }
        } else {
            if(!empty($this->input->post('checkbox'))){
                $resp = 1;
                $aprov = 1;
            }else{
                $resp = 0;
                $aprov = 0;
            }

            //date_default_timezone_set('America/Sao_Paulo');

            if($this->input->post('idOs') == 1  || $this->input->post('idOs') == 3 ){
                $data = array(
                    'idInsumos' => $insumoid,
					'material_producao' => $this->input->post('material_producao'), // ADICIONE AQUI
                    'id_status_grupo' => $this->input->post('idgrupo'),
                    'idProdutos' => $this->input->post('idProdutos'),
                    'obs' => $this->input->post('obs'),
                    'quantidade' => $this->input->post('quantidade'),
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'solicitacao' => $solicitacao,
                    'usuario_cadastro' => $this->session->userdata('idUsuarios'),
                    'idOs' => $this->input->post('idOs'),
                    'aprovacaoPCP' => 1,
                    'idUserAprovacao' => 51,
                    'aprovacaoDir' => 1,
                    'cod_fornecedor' => $this->input->post('codforn'),
                    'itemcomercial' => (empty($this->input->post('itemcomercial'))?0:1),
                    'idUserAprovacaoDir' => 51,
                    'data_autorizacaoPCP' => date('Y-m-d H:i:s'),
                    'data_autorizacaoDir' => date('Y-m-d H:i:s')
                );
            }else if($this->input->post('idOs') == 6 || $this->input->post('idOs') == 2){
                $data = array(
                    'idInsumos' => $insumoid,
					'material_producao' => $this->input->post('material_producao'), // ADICIONE AQUI
                    'id_status_grupo' => $this->input->post('idgrupo'),
                    'idProdutos' => $this->input->post('idProdutos'),
                    'obs' => $this->input->post('obs'),
                    'quantidade' => $this->input->post('quantidade'),
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'solicitacao' => $solicitacao,
                    'usuario_cadastro' => $this->session->userdata('idUsuarios'),
                    'idOs' => $this->input->post('idOs'),
                    'aprovacaoPCP' => 1,
                    'itemcomercial' => (empty($this->input->post('itemcomercial'))?0:1),
                    'cod_fornecedor' => $this->input->post('codforn'),
                    'idUserAprovacao' => 51,
                    'data_autorizacaoPCP' => date('Y-m-d H:i:s')
                );
            }else{
                $data = array(
                    'idInsumos' => $insumoid,
					'material_producao' => $this->input->post('material_producao'), // ADICIONE AQUI
                    'id_status_grupo' => $this->input->post('idgrupo'),
                    'idProdutos' => $this->input->post('idProdutos'),
                    'obs' => $this->input->post('obs'),
                    'quantidade' => $this->input->post('quantidade'),
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'itemcomercial' => (empty($this->input->post('itemcomercial'))?0:1),
                    'cod_fornecedor' => $this->input->post('codforn'),
                    'solicitacao' => $solicitacao,
                    'usuario_cadastro' => $this->session->userdata('idUsuarios'),
                    'idOs' => $this->input->post('idOs')
                );
            }
            

            $data = array_merge($data,$data2);


            if (is_numeric($id3 = $this->os_model->add('distribuir_os', $data, true))) {
                // if ($this->os_model->add('distribuir_os', $data) == TRUE) {

                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'), 'distribuir_os', 'inserir', $descricao, $id3);

                $dataup = "*" . $this->session->userdata('nome') . "|" . date('d-m-Y H:i:s');
                $updalog = array(

                    'histo_alteracao' => $dataup

                );

                $this->os_model->edit('distribuir_os', $updalog, 'idDistribuir', $id3);

                /*$this->os_model->edit_concatena('distribuir_os', $this->session->userdata('idUsuarios')."-".date('d-m-Y H:i:s'), 'histo_alteracao','idDistribuir', $id3);*/



                $this->session->set_flashdata('success', 'Item adicionado com sucesso!');




                if (empty($almox)) {
                    redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
                } else {

                    redirect(base_url() . 'index.php/almoxarifado');
                }
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/distribuiros';
        $this->load->view('tema/topo', $this->data);
    }
	
	/******************************************************************************************/
    /* NOVO MÉTODO PARA TRANSFERÊNCIA DE INSUMOS ADICIONADO ABAIXO               */
    /******************************************************************************************/

    public function transferir_insumo()
    {
        // Verifica se o usuário tem permissão para a ação
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para realizar esta operação.');
            redirect(base_url());
        }

        // Carrega a biblioteca de validação de formulário e define as regras
        $this->load->library('form_validation');
        $this->form_validation->set_rules('idDistribuir', 'ID do Insumo', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('idOs_origem', 'OS de Origem', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('idOs_destino', 'OS de Destino', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('qtd_transf', 'Quantidade a Transferir', 'trim|required|greater_than[0]');

		// Se a validação falhar, redireciona com erro
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', 'Dados inválidos. Verifique as informações preenchidas: ' . validation_errors());
			
			$idOsOrigem = $this->input->post('idOs_origem');
			// Verifica se o idOs_origem foi enviado (deve ter sido, pois é um campo oculto)
			if ($idOsOrigem) {
				redirect(base_url() . 'index.php/os/visualizar/' . $idOsOrigem);
			} else {
				// Fallback caso idOs_origem não esteja disponível
				// Poderia ser um redirect para a lista de OS ou uma página de erro genérica.
				// Se você realmente precisa do referrer e quer usar a biblioteca user_agent:
				// $this->load->library('user_agent');
				// redirect($this->agent->referrer());
				// Por enquanto, vamos redirecionar para a lista de OS como fallback seguro.
				redirect(base_url() . 'index.php/os'); 
			}
			return; // Importante para parar a execução do método aqui
		}

        // Coleta os dados do POST
        $idDistribuir = $this->input->post('idDistribuir');
        $idOsOrigem = $this->input->post('idOs_origem');
        $idOsDestino = $this->input->post('idOs_destino');
        // Converte a quantidade para float, aceitando tanto vírgula quanto ponto como decimal
        $qtdTransferir = (float) str_replace(',', '.', $this->input->post('qtd_transf'));

        // Impede a transferência para a mesma OS
        if ($idOsOrigem == $idOsDestino) {
            $this->session->set_flashdata('error', 'A OS de destino não pode ser a mesma que a de origem.');
            redirect(base_url() . 'index.php/os/visualizar/' . $idOsOrigem);
        }

        // Carrega o model e chama a função de transferência
        $this->load->model('os_model');
        $resultado = $this->os_model->transferirInsumoOs($idDistribuir, $qtdTransferir, $idOsDestino, $idOsOrigem);

        // Processa o resultado e define a mensagem para o usuário
        if ($resultado === true) {
            $this->session->set_flashdata('success', 'Insumo transferido com sucesso da OS ' . $idOsOrigem . ' para a OS ' . $idOsDestino . '.');
        } else {
            // A função do model retornará uma string com o erro específico
            $this->session->set_flashdata('error', 'Falha na transferência: ' . $resultado);
        }

        // Redireciona o usuário de volta para a OS de origem
        redirect(base_url() . 'index.php/os/visualizar/' . $idOsOrigem);
    }

	
	/////////////////////////////alteração adicionar insumos//////////////////////////////////////
	
	
    public function cad_horamaquina()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eHoramaquinas')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para cadastrar HR/Maquinas.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('idOs', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idMaquinas2', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idUserMaquinas2', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('horainiciod', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('horainicioh', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe os dados!');
            redirect(base_url() . 'index.php/os/maquinas/' . $this->input->post('idOs'));
        } else {

            $dataini = $this->input->post('horainiciod');



            $datac = explode('/', $dataini);
            $datai = $datac[2] . '-' . $datac[1] . '-' . $datac[0];





            $horaini = $this->input->post('horainicioh');


            $hrtotal =  $datai . " " . $horaini;

            $data = array(
                'idos' => $this->input->post('idOs'),
                'obs' => $this->input->post('obs'),
                'horainicio' => $hrtotal,
                'idUserMaquinas' => $this->input->post('idUserMaquinas2'),

                'idMaquinas' => $this->input->post('idMaquinas2')
            );

            if ($this->os_model->add('horasmaquinas', $data) == TRUE) {
                $this->session->set_flashdata('success', 'Item adicionado com sucesso!');

                redirect(base_url() . 'index.php/os/maquinas/' . $this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/maquinas';
        $this->load->view('tema/topo', $this->data);
    }
    public function editar_hrmaquinas()
    {


        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eHoramaquinas')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para cadastrar HR/Maquinas.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('idOs', '', 'trim|required|xss_clean');

        $this->form_validation->set_rules('horainiciod', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('horainicioh', '', 'trim|required|xss_clean');

        $this->form_validation->set_rules('datafinal', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('horafinal', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe os dados!');
            redirect(base_url() . 'index.php/os/maquinas/' . $this->input->post('idOs'));
        } else {

            $dataini = $this->input->post('horainiciod');

            $datac = explode('/', $dataini);
            $datai = $datac[2] . '-' . $datac[1] . '-' . $datac[0];

            $horaini = $this->input->post('horainicioh');

            $hrtotal =  $datai . " " . $horaini;


            $datafim = $this->input->post('datafinal');


            $dataf = explode('/', $datafim);
            $datafi = $dataf[2] . '-' . $dataf[1] . '-' . $dataf[0];

            $horafinal = $this->input->post('horafinal');

            $hrtotalfim =  $datafi . " " . $horafinal;




            $data = array(
                'idos' => $this->input->post('idOs'),
                'obs' => $this->input->post('obs'),
                'horainicio' => $hrtotal,
                'horafim' => $hrtotalfim,


            );

            if ($this->os_model->edit('horasmaquinas', $data, 'idHoramaquinas', $this->input->post('idHoramaquinas')) == TRUE) {
                $this->session->set_flashdata('success', 'Item editado com sucesso!');
                redirect(base_url() . 'index.php/os/maquinas/' . $this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }





        $this->data['view'] = 'os/maquinas';
        $this->load->view('tema/topo', $this->data);
    }
public function editar_datareagendada()
{
    // Captura dos dados enviados pelo AJAX
    $idOs = $this->input->post('idos');
    $data_post = $this->input->post('datareag');
    
    // CORREÇÃO DE SINCRONIA: Captura o motivo independente do nome enviado pelo JS
    $motivo = $this->input->post('motivo'); 
    if(empty($motivo)) {
        $motivo = $this->input->post('motivo_reagendada');
    }

    // 1. Verificação "Fail-Fast"
    if (empty($idOs)) {
        echo json_encode(array("result" => false, "msg" => "ID da OS não recebido."));
        return;
    }

    // Validação obrigatória: Se tem data, tem que ter motivo
    if (!empty($data_post) && empty($motivo)) {
        echo json_encode(array("result" => false, "msg" => "O MOTIVO é obrigatório para reprogramar a data."));
        return;
    }

    // --- ✅ NOVA TRAVA DE SEGURANÇA: BLOQUEIO DO "AJUSTE DE DATA" ---
    if (strtolower(trim($motivo)) == 'ajuste de data') {
        $this->load->model('os_model');
        // Se a função retornar TRUE, significa que já usou este motivo antes
        if ($this->os_model->checkMotivoAjusteData($idOs)) {
            echo json_encode(array("result" => false, "msg" => "Não é permitido alterar mais de uma vez a data para o motivo \"Ajuste de Data\"."));
            return;
        }
    }
    // -----------------------------------------------------------------

    // 2. Formatação da data para o padrão MySQL (YYYY-MM-DD)
    if (!empty($data_post)) {
        $partes = explode('/', $data_post);
        if (count($partes) == 3) {
            $data_mysql = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
        } else {
            $data_mysql = $data_post;
        }
        $data_update = array("data_reagendada" => $data_mysql);
    } else {
        $data_update = array("data_reagendada" => null);
        $data_mysql = null;
    }

    // 3. Tenta atualizar a tabela OS principal
    if ($this->os_model->edit('os', $data_update, 'idOs', $idOs)) {
        
        // 4. Busca dados da OS atualizada para os históricos
        $os_atual = $this->os_model->getByid_table($idOs, 'os', 'idOs');
        
        // 5. CORREÇÃO CIRÚRGICA: Inserção com data_registro explícita para evitar 31/12/1969
        $dadosMotivo = array(
            'idOs' => $idOs,
            'data_reagendada' => $data_mysql,
            'motivo' => $motivo,
            'usuario_id' => $this->session->userdata('idUsuarios'),
            'status_momento' => ($os_atual) ? $os_atual->idStatusOs : 'N/A',
            'data_registro' => date('Y-m-d H:i:s') 
        );
        $this->db->insert('os_reagendada_motivo', $dadosMotivo);

        // 6. Grava no histórico geral (os_history)
        if ($os_atual) {
            foreach ($os_atual as $key => $value) {
                if ($value == '0000-00-00' || $value == '0000-00-00 00:00:00') {
                    $os_atual->$key = null;
                }
            }
            $this->os_model->insertOSHis($os_atual);
        }

        // 7. Envio de e-mail (Mantido original)
        $emails = array('euripedes@ubertec.ind.br', 'abne@ubertec.ind.br', 'marcelo@ubertec.ind.br', 'bruno@ubertec.ind.br', 'patrick@ubertec.ind.br', 'jonatas.soares@ubertec.ind.br', 'pcp2@ubertec.ind.br');
        try {
            @$this->send($emails, "OS $idOs reagendada para: " . $data_post, "Motivo: " . $motivo);
        } catch (Exception $e) { 
            log_message('error', 'Falha no envio de e-mail OS ' . $idOs);
        }

        echo json_encode(array("result" => true, "msg" => "Entrega reagendada com sucesso."));

    } else {
        echo json_encode(array("result" => false, "msg" => "Erro ao atualizar no banco de dados."));
    }
}
	
function editar_dataplanejada() {
    $idOs = $this->input->post('idos');


    // Obtém a contagem atual de alterações
    $osData = $this->os_model->getByid_table($idOs, 'os', 'idOs');
    $countExistente = $osData->data_planejada_count;

    // Verifica se a contagem de alterações já atingiu o limite de 2
    if ($countExistente >= 2) {
        echo json_encode(array("result" => false, "msg" => "A data planejada já foi alterada duas vezes e não pode ser modificada novamente."));
        return;
    }

    // Prepara a nova data se fornecida
    if (!empty($this->input->post('dataplanej'))) {
        $data_plan = explode('/', $this->input->post('dataplanej'));
        $data_plan = $data_plan[2] . '-' . $data_plan[1] . '-' . $data_plan[0];

        $data = array(
            "data_planejada" => $data_plan,
            "data_planejada_count" => $countExistente + 1 // Incrementa a contagem
        );
    } else {
        $data = array(
            "data_planejada" => null,
            "data_planejada_count" => $countExistente + 1 // Incrementa a contagem mesmo se a data for removida
        );
    }

    // Envio de e-mail
    $email = array(
        'euripedes@ubertec.ind.br', 'eduardo.soares@ubertec.ind.br', 'marcelo@ubertec.ind.br',
        'pcp2@ubertec.ind.br',
        'jonatas.soares@ubertec.ind.br', 'pcp2@ubertec.ind.br'
    );

    try {
        $this->send($email, "OS planejada para: " . $this->input->post('dataplanej'), "OS: " . $idOs);
    } catch (Exception $e) {
        // Tratar erro de envio de e-mail
    }

    // Atualização no banco de dados
    $vari = $this->os_model->edit('os', $data, 'idOs', $idOs);
    if ($vari) {
        $os = $this->os_model->getByid_table($idOs, 'os', 'idOs');
        $this->os_model->insertOSHis($os);
        echo json_encode(array("result" => true, "msg" => "Data planejada com sucesso."));
    } else {
        echo json_encode(array("result" => false, "msg" => "Não foi possível reprogramar."));
    }
}	
public function editar_distribuiros(){
    if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
        $this->session->set_flashdata('error', 'Você não tem permissão para distribuir OS.');
        redirect(base_url());
    }

    $this->load->model('pedidocompra_model');
    $this->load->library('form_validation');
    $this->data['custom_error'] = '';

    $this->form_validation->set_rules('idOs', '', 'trim|required|xss_clean');
    $this->form_validation->set_rules('idInsumos', '', 'trim|required|xss_clean');
    $this->form_validation->set_rules('quantidade', '', 'trim|required|xss_clean');

    if (empty($this->input->post('idProdutosa2'))) {
        $idProdutosa2 = 0;
    } else {
        $idProdutosa2 = $this->input->post('idProdutosa2');
    }

    // ---------------- TIPOS DE MEDIÇÃO (mantidos) ----------------
    if(empty($this->input->post('idMedicao')) || $this->input->post('idMedicao')==0){
        $data2 = array("metrica" => "0",
            'dimensoes' => $this->input->post('livre'),
            "comprimento"=>null,
            "volume"=>null,
            "peso"=>null,
            "dimensoesL"=>null,
            "dimensoesC" => null,
            "dimensoesA" => null
        );
    }
    if($this->input->post('idMedicao')==1){
        if(empty($this->input->post('tamanho'))){
            $this->session->set_flashdata('error', 'Informe o comprimento!');
            redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
        }else{
            $data2 = array("metrica" => "1",
            "comprimento" => $this->input->post('tamanho'),
            "volume"=>null,
            "peso"=>null,
            "dimensoesL"=>null,
            "dimensoesC" =>null,
            "dimensoesA" =>null,
            "dimensoes"=>null);
        }
    }
    if($this->input->post('idMedicao')==2){
        if(empty($this->input->post('volume'))){
            $this->session->set_flashdata('error', 'Informe o volume!');
            redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
        }else{
            $data2 = array("metrica" => "2",
            "volume" => $this->input->post('volume'),
            "comprimento"=>null,
            "peso"=>null,
            "dimensoesL"=>null,
            "dimensoesC" => null,
            "dimensoesA" => null,
            "dimensoes"=>null);
        }
    }
    if($this->input->post('idMedicao')==3){
        if(empty($this->input->post('peso'))){
            $this->session->set_flashdata('error', 'Informe o peso!');
            redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
        }else{
            $data2 = array("metrica" => "3",
            "peso" => $this->input->post('peso'),
            "comprimento"=>null,
            "volume"=>null,
            "dimensoesL"=>null,
            "dimensoesC" => null,
            "dimensoesA" => null,
            "dimensoes"=>null);
        }
    }
    if($this->input->post('idMedicao')==4){
        if(!empty($this->input->post('dimensoesL')) || !empty($this->input->post('dimensoesC')) || !empty($this->input->post('dimensoesA'))){
            $data2 = array("metrica" => "4",
            "dimensoesL" => (!empty($this->input->post('dimensoesL'))?$this->input->post('dimensoesL'):null),
            "dimensoesC" => (!empty($this->input->post('dimensoesC'))?$this->input->post('dimensoesC'):null),
            "dimensoesA" => (!empty($this->input->post('dimensoesA'))?$this->input->post('dimensoesA'):null),
            "comprimento"=>null,
            "peso"=>null,
            "volume"=>null,
            "dimensoes"=>null);
        }else{
            $this->session->set_flashdata('error', 'Informe as dimensões!');
            redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
        }
    }
    // ------------------------------------------------------------

    if(!empty($this->input->post('checkbox'))){
        $data2 = array_merge($data2,array('responsabilidadePCP'=>1,'aprovacaoPCP'=>1));
    }else{
        $data2 = array_merge($data2,array('responsabilidadePCP'=>0,'aprovacaoPCP'=>0));
    }

    if ($this->input->post('idgrupo') == 0) {
        $this->session->set_flashdata('error', 'Informe o grupo!');
        redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
    }

    if ($this->form_validation->run() == false) {
        $this->session->set_flashdata('error', 'Informe os dados necessarios!');
        redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
    } else {

        $data3 = array(
            'idInsumos' => $this->input->post('idInsumos'),
            'id_status_grupo' => $this->input->post('idgrupo'),
            'idProdutos' => $idProdutosa2,
            'obs' => $this->input->post('obs'),
            'quantidade' => $this->input->post('quantidade'),
            'data_alteracao' => date('Y-m-d H:i:s'),
            'itemcomercial'=>(empty($this->input->post('itemcomercial'))?0:1),
            'cod_fornecedor' => $this->input->post('codforn'),
            'idOs' => $this->input->post('idOs')
        );

        // Carrega o item atual antes de atualizar
        $objDistribuir = $this->pedidocompra_model->getDistribuirById($this->input->post('idDistribuir'));

        // ---- STATUS 19 (Rejeitado) ----
        if($objDistribuir->idStatuscompras == 19){
            $data2 = array_merge($data2,array(
                'idStatuscompras'=>1,
                'rejeitado'=>0,
                'idUserRejeitado'=>NULL,
                'data_rejeitado'=>NULL
            ));
        }

        // ---- 🔥 NOVO STATUS: 22 → 1 ----
        if ($objDistribuir->idStatuscompras == 22) {
            $data2 = array_merge($data2, array(
                'idStatuscompras' => 1,
                'observacao_revisao_pcp' => NULL,
                'data_revisao_pcp' => NULL
            ));
        }

        $data3 = array_merge($data3,$data2);

        $this->data['result'] = $this->os_model->getByid_table($this->input->post('idDistribuir'), 'distribuir_os', 'idDistribuir');
        $descricao = serialize($this->data['result']);
        $this->salvarlog($this->session->userdata('idUsuarios'), 'distribuir_os', 'editar', $descricao, $this->input->post('idDistribuir'));

        if ($this->os_model->edit('distribuir_os', $data3, 'idDistribuir', $this->input->post('idDistribuir')) == TRUE) {

            $dataup = "*" . $this->session->userdata('nome') . "|" . date('d-m-Y H:i:s');

            $this->data['result']  = $this->os_model->getByid_table($this->input->post('idDistribuir'), 'distribuir_os', 'idDistribuir');
            $this->os_model->edit_concatena('distribuir_os', $dataup, 'idDistribuir', $this->input->post('idDistribuir'), $this->data['result']->histo_alteracao);

            $this->session->set_flashdata('success', 'Item editado com sucesso!');
            redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
        } else {
            $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
        }
    }

    $this->data['view'] = 'os/distribuiros';
    $this->load->view('tema/topo', $this->data);
}


    function excluir_item()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir item.');
            redirect(base_url());
        }


        $idDistribuir =  $this->input->post('idDistribuir');
        $idOs =  $this->input->post('idOs');
        if ($idDistribuir == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar excluir item.');
            redirect(base_url() . 'index.php/os/distribuiros/' . $idOs);
        }

        //if( $this->os_model->getitemcotacaoitem($idDistribuir) == false)
        //{
        $this->data['result'] = $this->os_model->getByid_table($idDistribuir, 'distribuir_os', 'idDistribuir');
        $descricao = serialize($this->data['result']);
        $this->salvarlog($this->session->userdata('idUsuarios'), 'distribuir_os', 'excluir', $descricao, $idDistribuir);





        $this->os_model->delete('distribuir_os', 'idDistribuir', $idDistribuir);

        $this->session->set_flashdata('success', 'Item excluido com sucesso!');
        redirect(base_url() . 'index.php/os/distribuiros/' . $idOs);
        /*}
		else
		{
			 $this->session->set_flashdata('error','Item possui compra cadastrada.');
			  redirect(base_url() . 'index.php/os/distribuiros/'.$idOs);
		}*/
    }
    function excluir_item_cancelar()
    {
        $this->load->model('pedidocompra_model');

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir item.');
            redirect(base_url());
        }


        $idDistribuir =  $this->input->post('idDistribuircancelar');
        $idOs =  $this->input->post('idOs');
        if ($idDistribuir == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar cancelar item.');
            redirect(base_url() . 'index.php/os/distribuiros/' . $idOs);
        }


        $this->data['result'] = $this->os_model->getByid_table($idDistribuir, 'distribuir_os', 'idDistribuir');
        $descricao = serialize($this->data['result']);
        $this->salvarlog($this->session->userdata('idUsuarios'), 'distribuir_os', 'excluir', $descricao, $idDistribuir);

        $data = array(
            'idStatuscompras' => 6
        );
        $this->os_model->edit('distribuir_os', $data, 'idDistribuir', $idDistribuir);
        $pedidocompraitens2 = $this->pedidocompra_model->getPedidoCompraItensByIdDistribuir($idDistribuir);
        foreach($pedidocompraitens2 as $v){
            $pedidocompraitens3 = $this->pedidocompra_model->getPedidoCompraItensByIdCotacaoItem($v->idCotacaoItens);
            foreach($pedidocompraitens3 as $b){
                $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$b->idPedidoCompraItens);
            }
            $this->pedidocompra_model->delete('pedido_cotacaoitens','idCotacaoItens',$v->idCotacaoItens);
        }



        $this->session->set_flashdata('success', 'Item Cancelado com sucesso!');
        redirect(base_url() . 'index.php/os/distribuiros/' . $idOs);
    }

    function excluir_hmaquina()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eHoramaquinas')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir item.');
            redirect(base_url());
        }


        $idHoramaquinas =  $this->input->post('horamaquina2');
        $idOs =  $this->input->post('idOs');


        if ($idHoramaquinas == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar excluir item.');
            redirect(base_url() . 'index.php/os/maquinas/' . $idOs);
        }



        $this->os_model->delete('horasmaquinas', 'idHoramaquinas', $idHoramaquinas);

        $this->session->set_flashdata('success', 'Item excluido com sucesso!');
        redirect(base_url() . 'index.php/os/maquinas/' . $idOs);
    }

    public function imprimir_osproducao()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
            redirect(base_url());
        }


        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        $data['result'] = $this->os_model->OSCustom($this->uri->segment(3));
        if(!empty($data['result'][0]->idSimplexAtividade)){
            $data['resultSimplex'] = json_decode($this->simplexGetAtividade($data['result'][0]->idSimplexAtividade));
            
        }else{
            $data['resultSimplex'] = null;
        }
        
        //echo("<script>console.log('".$data['result'][0]->idSimplexAtividade."');</script>");


        $this->load->helper('mpdf');
        echo $html = $this->load->view('os/imprimir/imprimir_osproducao', $data, true);
    }
    public function cad_desenho()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aAnexo')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar anexo.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe nome do arquivo!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {

            $arquivo = $this->do_upload();

            $imagem = $arquivo['file_name'];
            //$path = $arquivo['full_path'];
            $caminho = 'assets/uploads/desenho/';
            //$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
            $tamanho = $arquivo['file_size'];
            $extensao = $arquivo['file_ext'];

            $nomeArquivo = $this->input->post('nomeArquivo');
            $idOs = $this->input->post('idOs');



            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'imagem' => $imagem,
                'caminho' => $caminho,
                'tipo' => $this->input->post('tipo'),
                'tamanho' => $tamanho,
                'extensao' => $extensao,
                'data_cadastro' => date('Y-m-d H:i:s'),
                'user_proprietario' => $this->session->userdata('idUsuarios'),
                'idOs' => $idOs
            );

            if ($this->os_model->add('anexo_desenho', $data) == TRUE) {
                $this->session->set_flashdata('success', 'Arquivo adicionado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/' . $idOs);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/visualizar';
        $this->load->view('tema/topo', $this->data);
    }
    function do_upload()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }



        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads/desenho';

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = array(
            'upload_path'   => $image_upload_folder,
            'allowed_types' => '*',
            // 'max_size'      => 2048,
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE,
        );

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            print_r($upload_error);
            exit();
        } else {

            return $this->upload->data();


            //$file_info = array($this->upload->data());
            // return $file_info[0]['file_name'];
        }
    }
    //pedido
    public function cad_nf()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'anotafiscalOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar nf.');
            redirect(base_url());
        }

        $table = $this->input->post('table');
        if ($table == 'anexo_notafiscal') {
            $directory = "nf";
            $dataP = array(
                'numero_nf' => $this->input->post('nomeArquivo'),
                'data_nf_faturamento'=>date('Y-m-d')

            );
        } elseif ($table == 'anexo_nfcliente') {
            $directory = "nfcliente";
            $dataP = array(
                'nf_cliente' => $this->input->post('nomeArquivo')

            );
        } else if($table == 'anexo_nfcanhoto'){
            $directory = "nfvenda";
            $dataP = array(
                'nf_canhoto' => $this->input->post('nomeArquivo')

            );
        }else{
            $directory = "nfvenda";
            $dataP = array(
                'nf_venda_dev' => $this->input->post('nomeArquivo'),
                'data_devolucao'=>date('Y-m-d')

            );
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe nome do arquivo!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {

            $arquivo = $this->do_upload_nf($directory);

            $imagem = $arquivo['file_name'];
            //$path = $arquivo['full_path'];
            $caminho = 'assets/uploads/' . $directory . '/';
            //$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
            $tamanho = $arquivo['file_size'];
            $extensao = $arquivo['file_ext'];

            $nomeArquivo = $this->input->post('nomeArquivo');
            $idOs = $this->input->post('idOs');



            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'imagem' => $imagem,
                'caminho' => $caminho,
                'tamanho' => $tamanho,
                'extensao' => $extensao,
                'data_cadastro' => date('Y-m-d H:i:s'),
                'idOs' => $idOs
            );

            if ($this->os_model->add($table, $data) == TRUE) {

               
                $this->os_model->edit('os', $dataP, 'idOs', $idOs);
                
                

                $this->session->set_flashdata('success', 'Arquivo adicionado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/' . $idOs);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/visualizar';
        $this->load->view('tema/topo', $this->data);
    }
    function do_upload_nf($directory)
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }



        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads/' . $directory;

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = array(
            'upload_path'   => $image_upload_folder,
            'allowed_types' => '*',
            // 'max_size'      => 2048,
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE,
        );

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            print_r($upload_error);
            exit();
        } else {

            return $this->upload->data();


            //$file_info = array($this->upload->data());
            // return $file_info[0]['file_name'];
        }
    }
    public function editar_nf()
    {

        $table = $this->input->post('table');


        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'anotafiscalOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar nf.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe um nome!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {

            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'idOs' => $this->input->post('idOs'),
                'idAnexo' => $this->input->post('idAnexo')
            );




            //if ($this->os_model->edit('anexo_notafiscal', $data, 'idAnexo', $this->input->post('idAnexo')) == TRUE) {
            if ($this->os_model->edit($table, $data, 'idAnexo', $this->input->post('idAnexo')) == TRUE) {

                /* $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumo','editar',$descricao );
               */

                $this->session->set_flashdata('success', 'NF editado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }
    }
    public function excluirnf()
    {


        $id = $this->input->post('idAnexo');
        $idOs = $this->input->post('idOs');
        $table = $this->input->post('table');
        if ($id == null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }

        $imagem = $this->input->post('imagem');
        if ($this->os_model->getimagem_base($id, $imagem, $table) == true) {
            $this->session->set_flashdata('error', 'Esse arquivo não pode ser excluido , pois ele esta vinculado a outra OS.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }

        $file = $this->os_model->getimagemnf($id);

        $this->db->where('idAnexo', $id);

        if ($this->db->delete($table)) {
            $path = FCPATH . $file->caminho . $file->imagem;
            unlink($path);


            $this->session->set_flashdata('success', 'Arquivo excluido com sucesso!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {

            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar excluir o arquivo.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }
    }

    //pedido
    public function cad_pedido()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'apedidoOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar pedido.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe nome do arquivo!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {

            $arquivo = $this->do_upload_pedido();

            $imagem = $arquivo['file_name'];
            //$path = $arquivo['full_path'];
            $caminho = 'assets/uploads/pedido/';
            //$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
            $tamanho = $arquivo['file_size'];
            $extensao = $arquivo['file_ext'];

            $nomeArquivo = $this->input->post('nomeArquivo');
            $idOs = $this->input->post('idOs');



            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'imagem' => $imagem,
                'caminho' => $caminho,
                'tamanho' => $tamanho,
                'extensao' => $extensao,
                'data_cadastro' => date('Y-m-d H:i:s'),
                'idOs' => $idOs
            );
            $dataP = array(
                'numpedido_os' => $this->input->post('nomeArquivo')

            );


            if ($this->os_model->add('anexo_pedido', $data) == TRUE) {

                $this->os_model->edit('os', $dataP, 'idOs', $idOs);

                $this->session->set_flashdata('success', 'Arquivo adicionado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/' . $idOs);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/visualizar';
        $this->load->view('tema/topo', $this->data);
    }
    function do_upload_pedido($nome = 'userfile')
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }



        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads/pedido';

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = array(
            'upload_path'   => $image_upload_folder,
            'allowed_types' => '*',
            // 'max_size'      => 2048,
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE,
        );

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload($nome)) {
            $upload_error = $this->upload->display_errors();
            print_r($upload_error);
            exit();
        } else {

            return $this->upload->data();


            //$file_info = array($this->upload->data());
            // return $file_info[0]['file_name'];
        }
    }
    public function editar_pedido()
    {


        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'apedidoOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar pedido.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe um nome!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {

            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'idOs' => $this->input->post('idOs'),
                'idAnexo' => $this->input->post('idAnexo')
            );




            if ($this->os_model->edit('anexo_pedido', $data, 'idAnexo', $this->input->post('idAnexo')) == TRUE) {

                /* $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumo','editar',$descricao );
               */

                $this->session->set_flashdata('success', 'Pedido editado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }
    }
    public function excluirpedido()
    {


        $id = $this->input->post('idAnexo');
        $idOs = $this->input->post('idOs');
        if ($id == null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Erro! O arquivo não pode ser localizado.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }

        $imagem = $this->input->post('imagem');
        if ($this->os_model->getimagem_base($id, $imagem, 'anexo_pedido') == true) {
            $this->session->set_flashdata('error', 'Esse arquivo não pode ser excluido , pois ele esta vinculado a outra OS.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs') . '#tab2');
        }

        $file = $this->os_model->getimagempedido($id);

        $this->db->where('idAnexo', $id);

        if ($this->db->delete('anexo_pedido')) {
            $path = FCPATH . $file->caminho . $file->imagem;
            unlink($path);


            $this->session->set_flashdata('success', 'Arquivo excluido com sucesso!');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        } else {

            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar excluir o arquivo.');
            redirect(base_url() . 'index.php/os/visualizar/' . $this->input->post('idOs'));
        }
    }

    function excluir()
    {

        $id =  $this->input->post('id');
        if ($id == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar excluir OS.');
            redirect(base_url() . 'index.php/os/gerenciar/');
        }

        $this->db->where('os_id', $id);
        $this->db->delete('servicos_os');

        $this->db->where('os_id', $id);
        $this->db->delete('produtos_os');

        $this->db->where('os_id', $id);
        $this->db->delete('anexos');

        $os = $this->os_model->getByid_table($id, 'os', 'idOs');
        $this->os_model->insertOSHis($os);

        $this->os_model->delete('os', 'idOs', $id);


        $this->session->set_flashdata('success', 'OS excluída com sucesso!');
        redirect(base_url() . 'index.php/os/gerenciar/');
    }

    public function autoCompleteProduto()
    {

        if ($this->input->get('term') !== null) {
            $q = strtolower($this->input->get('term', TRUE));
            $this->os_model->autoCompleteProduto($q);
        }
    }

    public function autoCompleteCliente()
    {

        if ($this->input->get('term') !== null) {
            $q = strtolower($this->input->get('term', TRUE));
            $this->os_model->autoCompleteCliente($q);
        }
    }

    public function autoCompleteUsuario()
    {

        if ($this->input->get('term') !== null) {
            $q = strtolower($this->input->get('term', TRUE));
            $this->os_model->autoCompleteUsuario($q);
        }
    }

    public function autoCompleteServico()
    {

        if ($this->input->get('term') !== null) {
            $q = strtolower($this->input->get('term', TRUE));
            $this->os_model->autoCompleteServico($q);
        }
    }

    public function adicionarProduto()
    {


        $preco = $this->input->post('preco');
        $quantidade = $this->input->post('quantidade');
        $subtotal = $preco * $quantidade;
        $produto = $this->input->post('idProduto');
        $data = array(
            'quantidade' => $quantidade,
            'subTotal' => $subtotal,
            'produtos_id' => $produto,
            'os_id' => $this->input->post('idOsProduto'),
        );

        if ($this->os_model->add('produtos_os', $data) == true) {
            $sql = "UPDATE produtos set estoque = estoque - ? WHERE idProdutos = ?";
            $this->db->query($sql, array($quantidade, $produto));

            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }

    function excluirProduto()
    {
        $ID = $this->input->post('idProduto');
        if ($this->os_model->delete('produtos_os', 'idProdutos_os', $ID) == true) {

            $quantidade = $this->input->post('quantidade');
            $produto = $this->input->post('produto');


            $sql = "UPDATE produtos set estoque = estoque + ? WHERE idProdutos = ?";

            $this->db->query($sql, array($quantidade, $produto));

            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }

    public function adicionarServico()
    {


        $data = array(
            'servicos_id' => $this->input->post('idServico'),
            'os_id' => $this->input->post('idOsServico'),
        );

        if ($this->os_model->add('servicos_os', $data) == true) {

            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }

    function excluirServico()
    {
        $ID = $this->input->post('idServico');
        if ($this->os_model->delete('servicos_os', 'idServicos_os', $ID) == true) {

            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }


    public function anexar()
    {

        $this->load->library('upload');
        $this->load->library('image_lib');

        $upload_conf = array(
            'upload_path'   => realpath('./assets/anexos'),
            'allowed_types' => '*', // formatos permitidos para anexos de os
            'max_size'      => 0,
        );

        $this->upload->initialize($upload_conf);

        // Change $_FILES to new vars and loop them
        foreach ($_FILES['userfile'] as $key => $val) {
            $i = 1;
            foreach ($val as $v) {
                $field_name = "file_" . $i;
                $_FILES[$field_name][$key] = $v;
                $i++;
            }
        }
        // Unset the useless one ;)
        unset($_FILES['userfile']);

        // Put each errors and upload data to an array
        $error = array();
        $success = array();

        // main action to upload each file
        foreach ($_FILES as $field_name => $file) {
            if (!$this->upload->do_upload($field_name)) {
                // if upload fail, grab error 
                $error['upload'][] = $this->upload->display_errors();
            } else {
                // otherwise, put the upload datas here.
                // if you want to use database, put insert query in this loop
                $upload_data = $this->upload->data();

                if ($upload_data['is_image'] == 1) {

                    // set the resize config
                    $resize_conf = array(
                        // it's something like "/full/path/to/the/image.jpg" maybe
                        'source_image'  => $upload_data['full_path'],
                        // and it's "/full/path/to/the/" + "thumb_" + "image.jpg
                        // or you can use 'create_thumbs' => true option instead
                        'new_image'     => $upload_data['file_path'] . 'thumbs/thumb_' . $upload_data['file_name'],
                        'width'         => 200,
                        'height'        => 125
                    );

                    // initializing
                    $this->image_lib->initialize($resize_conf);

                    // do it!
                    if (!$this->image_lib->resize()) {
                        // if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        // otherwise, put each upload data to an array.
                        $success[] = $upload_data;

                        $this->load->model('Os_model');

                        $this->Os_model->anexar($this->input->post('idOsServico'), $upload_data['file_name'], base_url() . 'assets/anexos/', 'thumb_' . $upload_data['file_name'], realpath('./assets/anexos/'));
                    }
                } else {

                    $success[] = $upload_data;

                    $this->load->model('Os_model');

                    $this->Os_model->anexar($this->input->post('idOsServico'), $upload_data['file_name'], base_url() . 'assets/anexos/', '', realpath('./assets/anexos/'));
                }
            }
        }

        // see what we get
        if (count($error) > 0) {
            //print_r($data['error'] = $error);
            echo json_encode(array('result' => false, 'mensagem' => 'Nenhum arquivo foi anexado.'));
        } else {
            //print_r($data['success'] = $upload_data);
            echo json_encode(array('result' => true, 'mensagem' => 'Arquivo(s) anexado(s) com sucesso .'));
        }
    }


    /* public function excluirAnexo($id = null){
        if($id == null || !is_numeric($id)){
            echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao tentar excluir anexo.'));
        }
        else{

            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos',1)->row();

            unlink($file->path.'/'.$file->anexo);

            if($file->thumb != null){
                unlink($file->path.'/thumbs/'.$file->thumb);    
            }
            
            if($this->os_model->delete('anexos','idAnexos',$id) == true){

                echo json_encode(array('result'=> true, 'mensagem' => 'Anexo excluído com sucesso.'));
            }
            else{
                echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao tentar excluir anexo.'));
            }

            
        }
    }*/


    public function downloadanexo($id = null)
    {

        if ($id != null && is_numeric($id)) {

            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos', 1)->row();

            $this->load->library('zip');

            $path = $file->path;

            $this->zip->read_file($path . '/' . $file->anexo);

            $this->zip->download('file' . date('d-m-Y-H.i.s') . '.zip');
        }
    }


    public function faturar()
    {

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('receita') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


            $vencimento = $this->input->post('vencimento');
            $recebimento = $this->input->post('recebimento');

            try {

                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2] . '-' . $vencimento[1] . '-' . $vencimento[0];

                if ($recebimento != null) {
                    $recebimento = explode('/', $recebimento);
                    $recebimento = $recebimento[2] . '-' . $recebimento[1] . '-' . $recebimento[0];
                }
            } catch (Exception $e) {
                $vencimento = date('Y/m/d');
            }

            $data = array(
                'descricao' => set_value('descricao'),
                'valor' => $this->input->post('valor'),
                'clientes_id' => $this->input->post('clientes_id'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $recebimento,
                'baixado' => $this->input->post('recebido'),
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo')
            );

            if ($this->os_model->add('lancamentos', $data) == TRUE) {

                $os = $this->input->post('os_id');

                $this->db->set('faturado', 1);
                $this->db->set('valorTotal', $this->input->post('valor'));
                $this->db->where('idOs', $os);
                $this->db->update('os');

                $this->session->set_flashdata('success', 'OS faturada com sucesso!');
                $json = array('result' =>  true);
                echo json_encode($json);
                die();
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar OS.');
                $json = array('result' =>  false);
                echo json_encode($json);
                die();
            }
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar OS.');
        $json = array('result' =>  false);
        echo json_encode($json);
    }

    private function salvarlog($usuario, $table, $acao, $descricao, $id_tb)
    {

        //colocar na funçao que vai enviar $this->salvarlog($usuario,$table,$acao,$descricao)

        $data = array(
            'ag_id_responsavel' => $usuario,
            'ag_tabela' => $table,
            'id_tb' => $id_tb,
            'ag_acao_realizada' => $acao,
            'ag_data' => date('Y-m-d H:i:s'),
            'ag_descricao' => $descricao
        );

        $this->os_model->add('auditoria_geral', $data);
    }
    function debug_to_console($data)
    {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
    function almoxarifadoAdditensCompra()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aPedidocompraalmox')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para cadastrar estoque em Almoxarifado.');
            redirect(base_url());
        }
        $idUser = $this->session->userdata('idUsuarios');
        $osItens = $this->input->post('osItens');
        $dataMerge = array();
        $count = count($osItens);
        for ($x = 0; $x < $count; $x++) {
            if (!empty($osItens[$x]['idProdutoTD'])) {
                $idProd = $osItens[$x]['idProdutoTD'];
            } else {
                $json = array('result' => false, 'msggg' => 'Produto não selecionado.');
                echo json_encode($json);
                return;
            }/*
            if (!empty($osItens[$x]['idDimensoesTD'])) {
                $dimensoes = $osItens[$x]['idDimensoesTD'];
            } else {
                $dimensoes = null;
            }*/
            if (!empty($osItens[$x]['osTD'])) {
                $os = $osItens[$x]['osTD'];
            } else {
                $json = array('result' => false, 'msggg' => 'Empresa não selecionada.');
                echo json_encode($json);
                return;
            }
            if (!empty($osItens[$x]['obsTD'])) {
                $obs = $osItens[$x]['obsTD'];
            } else {
                $obs = null;
            }
            if (!empty($osItens[$x]['qtdTD'])) {
                $qtd = $osItens[$x]['qtdTD'];
            } else {
                $json = array('result' => false, 'msggg' => 'Quantidade não informada.');
                echo json_encode($json);
                return;
            }
            if (!empty($osItens[$x]['medicaoTD_'])) {
                //$qtd = $osItens[$x]['qtdTD'];
                if($osItens[$x]['medicaoTD_'] == 1){
                    if(!empty($osItens[$x]['comprimentoTD_'] )){
                        $dataMerge = array(
                            "metrica"=>1,
                            "comprimento"=>$osItens[$x]['comprimentoTD_']);
                    }else{
                        $json = array('result' => false, 'msggg' => 'Comprimento não informado.');
                        echo json_encode($json);
                        return;
                    }
                }
                if($osItens[$x]['medicaoTD_'] == 2){
                    if(!empty($osItens[$x]['volumeTD_'] )){
                        $dataMerge = array(
                            "metrica"=>2,
                            "volume"=>$osItens[$x]['volumeTD_']);
                    }else{
                        $json = array('result' => false, 'msggg' => 'Volume não informado.');
                        echo json_encode($json);
                        return;
                    }
                }
                if($osItens[$x]['medicaoTD_'] == 3){
                    if(!empty($osItens[$x]['pesoTD_'] )){
                        $dataMerge = array(
                            "metrica"=>3,
                            "peso"=>$osItens[$x]['pesoTD_']);
                    }else{
                        $json = array('result' => false, 'msggg' => 'Peso não informado.');
                        echo json_encode($json);
                        return;
                    }
                }
                if($osItens[$x]['medicaoTD_'] == 4){
                    if(!empty($osItens[$x]['dimensoesLTD_'] ) || !empty($osItens[$x]['dimensoesCTD_'] ) || !empty($osItens[$x]['dimensoesATD_'])){
                        $dataMerge = array(
                            "metrica"=>4,
                            "dimensoesL"=>(!empty($osItens[$x]['dimensoesLTD_'])?$osItens[$x]['dimensoesLTD_']:null),
                            "dimensoesC"=>(!empty($osItens[$x]['dimensoesCTD_'])?$osItens[$x]['dimensoesCTD_']:null),
                            "dimensoesA"=>(!empty($osItens[$x]['dimensoesATD_'])?$osItens[$x]['dimensoesATD_']:null));
                    }else{
                        $json = array('result' => false, 'msggg' => 'Dimensões não informado.');
                        echo json_encode($json);
                        return;
                    }
                }
            } else {
                $dataMerge = array(
                    "metrica"=>0
                );
            }
            $data = array(
                'idInsumos' => $idProd,
                'id_status_grupo' => '30',
                'idProdutos' => null,
                'obs' => $obs,
                'quantidade' => $qtd,
                'data_cadastro' => date('Y-m-d H:i:s'),
                'solicitacao' => '2',
                'usuario_cadastro' => $this->session->userdata('idUsuarios'),
                'aprovacaoPCP' => 1,
                'idUserAprovacao' => 51,
                'idOs' => $os
            );
            $data = array_merge($data,$dataMerge);
            is_numeric($id3 = $this->os_model->add('distribuir_os', $data, true));
        }
        $json = array('result' => true, 'msggg' => 'Solicitação criada com sucesso');
        echo json_encode($json);
    }
    public function simplexUpdateAtividade($idSimplexAtividade,$lista,$idOs){
        $curl = curl_init();
        $os = $this->os_model->getByid_table($idOs, 'os', 'idOs');
        $orc = $this->os_model->getByid_table($os->idOrcamento_item, 'orcamento_item', 'idOrcamento_item');
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->config->item('urlSimplex').'/put_kanban_atividades',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "de_qual_lista": "'.$lista.'",            
            "deletado":"no",
            "descricao_atividade": "'.$orc->descricao_item.'",
            "local_producao": "1643030732052x547164845382303740",
            "empresa": "1643030479504x771112863746752500",
            "horas_estimadas": "0",
            "prazo_previsto": "0",
            "prazo_realizado": "0",
            "produto_final": "",   
            "servico_controlado": "",   
            "termino_realizado": "0",   
            "inicio_previsto": "0",
            "inicio_realizado": "0",            
            "list_user": [],
            "titulo_atividade_oe": "'.$os->idSimplexOs.'",
            "inicio_previsto": "'.$os->data_abertura_real.'",
            "termino_previsto": "'.$os->data_entrega.'",
            "titulo_atividade": "'.$orc->descricao_item.'",
            "titulo_atividade_oe_filter": "'.$idOs.'",
            "id":"'.$idSimplexAtividade.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->config->item('tokenSimplex')
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    public function simplexGetAtividade($idSimplexAtividade){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->config->item('urlSimplex').'/get_id_kanban_atividades',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "local_producao": "1643030732052x547164845382303740",
            "empresa": "1643030479504x771112863746752500",
            "id": "'.$idSimplexAtividade.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->config->item('tokenSimplex')
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function alterarconjuntoos(){
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para reagendar OS.');
            redirect(base_url() . 'index.php/os');
        }
        $checkBox = $this->input->post('alterarOS');
        $verificaCheckbox = true;
        $editarReagendarOS = false;
        $editarDataEntregaOS = false;
        $editarDataExpedicaoOS = false;
        $editarDataCanhotoOS = false;
        $editarStatusOS = false;
        $editarUnidExecOS = false;
        $editarUnidFatOS = false;
        $editarContratoOS = false;
        $editarTipoOS = false;
        $editarAnexoPedidoOS = false;
        $editarAnexoNFOS = false;
        $editarAnexoNFClienteOS = false;
        $editarNFDevOS = false;
        $editarAnexoCanhotoOS = false;
        $editarDataOS = false;
        foreach($checkBox as $r){
            if(!empty($r)){
                $verificaCheckbox = false;
                if('editarReagendarOS' == $r){
                    $editarReagendarOS = true;
                }
                if('editarDataEntregaOS' == $r){
                    $editarDataEntregaOS = true;
                }
                if('editarDataExpedicaoOS' == $r){
                    $editarDataExpedicaoOS = true;
                }
                if('editarDataCanhotoOS' == $r){
                    $editarDataCanhotoOS = true;
                }
                if('editarStatusOS' == $r){
                    $editarStatusOS = true;
                }
                if('editarUnidExecOS' == $r){
                    $editarUnidExecOS = true;
                }
                if('editarUnidFatOS' == $r){
                    $editarUnidFatOS = true;
                }
                if('editarContratoOS' == $r){
                    $editarContratoOS = true;
                }
                if('editarTipoOS' == $r){
                    $editarTipoOS = true;
                }
                if('editarAnexoPedidoOS' == $r){
                    $editarAnexoPedidoOS = true;
                }
                if('editarAnexoNFOS' == $r){
                    $editarAnexoNFOS = true;
                }
                if('editarDataOS' == $r){
                    $editarDataOS = true;
                }
                if('editarAnexoNFClienteOS' == $r){
                    $editarAnexoNFClienteOS = true;
                }
                if('editarNFDevOS' == $r){
                    $editarNFDevOS = true;
                }
                if('editarAnexoCanhotoOS' == $r){
                    $editarAnexoCanhotoOS = true;
                }
            }
        }
        
        if($verificaCheckbox){
            $this->session->set_flashdata('error', 'Não foram selecionados itens para ser editados.');
            redirect(base_url()  . 'index.php/os');
        }
        $data3 = array();
        if($editarDataOS){
            if ($this->input->post('dataOs') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $data_rea = explode('/', $this->input->post('dataOs'));
            $data_rea = $data_rea[2] . '-' . $data_rea[1] . '-' . $data_rea[0];
    
            $data3['data_abertura'] = $data_rea;
        }
        if($editarReagendarOS){
            if ($this->input->post('reagendarOs') == '' || $this->input->post('varias_os') == '') {
                //$this->session->set_flashdata('error', 'Informe campos obrigatórios!');
                //redirect(base_url() . 'index.php/os');
                $data3['data_reagendada'] = null;
            }else{

                $data_rea = explode('/', $this->input->post('reagendarOs'));
                $data_rea = $data_rea[2] . '-' . $data_rea[1] . '-' . $data_rea[0];
        
                $data3['data_reagendada'] = $data_rea;
            }
    
        }
        if($editarDataEntregaOS){
            if ($this->input->post('dataEntregaOs') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $data_ent = explode('/', $this->input->post('dataEntregaOs'));
            $data_ent = $data_ent[2] . '-' . $data_ent[1] . '-' . $data_ent[0];
    
            $data3['data_entrega'] = $data_ent;
        }
        if($editarDataExpedicaoOS){
            if ($this->input->post('dataExpedicaoOs') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $data_exp = explode('/', $this->input->post('dataExpedicaoOs'));
            $data_exp = $data_exp[2] . '-' . $data_exp[1] . '-' . $data_exp[0];
    
            $data3['data_expedicao'] = $data_exp;
        }
        if($editarDataCanhotoOS){
            if ($this->input->post('dataCanhotoOs') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $data_can = explode('/', $this->input->post('dataCanhotoOs'));
            $data_can = $data_can[2] . '-' . $data_can[1] . '-' . $data_can[0];
    
            $data3['data_canhoto'] = $data_can;
        }
        if($editarStatusOS){
            if ($this->input->post('idStatusOs2') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $statusOs = $this->input->post('idStatusOs2');    
            $data3['idStatusOs'] = $statusOs;
        }
        if($editarUnidExecOS){
            if ($this->input->post('unid_execucao2') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $unid_exec = $this->input->post('unid_execucao2');    
            $data3['unid_execucao'] = $unid_exec;
        }
        if($editarUnidFatOS){
            if ($this->input->post('unid_faturamento2') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $unid_exec = $this->input->post('unid_faturamento2');    
            $data3['unid_faturamento'] = $unid_exec;
        }
        if($editarContratoOS){
            if ($this->input->post('contrato2') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $contrato2 = $this->input->post('contrato2');    
            $data3['contrato'] = $contrato2;
        }
        if($editarTipoOS){
            if ($this->input->post('id_tipo2') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $id_tipo2 = $this->input->post('id_tipo2');    
            $data3['id_tipo'] = $id_tipo2;
        }
        $id_osreag = explode(',', $this->input->post('varias_os'));
        foreach ($id_osreag as $os_reag) {
            $orcamentoItem = $this->os_model->getOrcamentoItemByIdOs($os_reag);
            // if($orcamentoItem->status_item != 2){
            //     $this->session->set_flashdata('error', 'Não é possivel alterar informações de O.S. que não foram aprovadas');
            //     redirect(base_url() . 'index.php/os');
            // }

            if($orcamentoItem->status_item != 2 ){
                $this->session->set_flashdata('error', 'Não é possivel alterar informações de O.S. que não foram aprovadas');
                redirect(base_url() . 'index.php/os');
            }

        }
        if($editarAnexoPedidoOS){
            if ($this->input->post('nomeArquivo2') == '' || $this->input->post('pedido2') == '' ||  $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
            $data3['numpedido_os'] = $this->input->post('pedido2');
            $id_osreag = explode(',', $this->input->post('varias_os'));
            


            foreach ($id_osreag as $os_reag) {
                $this->data['result'] = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
                $descricao = serialize($this->data['result']);
                $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'editar', $descricao, $os_reag);

                $arquivo = $this->do_upload_pedido();

                $imagem = $arquivo['file_name'];
                //$path = $arquivo['full_path'];
                $caminho = 'assets/uploads/pedido/';
                //$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
                $tamanho = $arquivo['file_size'];
                $extensao = $arquivo['file_ext'];

                $nomeArquivo = $this->input->post('nomeArquivo2');
                $data = array(
                    'nomeArquivo' => $this->input->post('nomeArquivo2'),
                    'imagem' => $imagem,
                    'caminho' => $caminho,
                    'tamanho' => $tamanho,
                    'extensao' => $extensao,
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'idOs' => $os_reag
                );
                $this->os_model->add('anexo_pedido', $data);
            }
        }
        if($editarAnexoNFOS){
            if ($this->input->post('nomeArquivo3') == '' || $this->input->post('pedido3') == '' ||  $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
            $data3['numero_nf'] = $this->input->post('pedido3');
            $id_osreag = explode(',', $this->input->post('varias_os'));
            


            foreach ($id_osreag as $os_reag) {
                $this->data['result'] = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
                $descricao = serialize($this->data['result']);
                $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'editar', $descricao, $os_reag);

                $arquivo = $this->do_upload_pedido('userfile2');

                $imagem = $arquivo['file_name'];
                //$path = $arquivo['full_path'];
                $caminho = 'assets/uploads/pedido/';
                //$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
                $tamanho = $arquivo['file_size'];
                $extensao = $arquivo['file_ext'];

                $nomeArquivo = $this->input->post('nomeArquivo3');
                $data = array(
                    'nomeArquivo' => $this->input->post('nomeArquivo3'),
                    'imagem' => $imagem,
                    'caminho' => $caminho,
                    'tamanho' => $tamanho,
                    'extensao' => $extensao,
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'idOs' => $os_reag
                );
                $this->os_model->add('anexo_notafiscal', $data);
            }
        }
        if($editarAnexoNFClienteOS){
            if ($this->input->post('nomeArquivo4') == '' || $this->input->post('pedido4') == '' ||  $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
            $data3['nf_cliente'] = $this->input->post('pedido4');
            $id_osreag = explode(',', $this->input->post('varias_os'));
            


            foreach ($id_osreag as $os_reag) {
                $this->data['result'] = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
                $descricao = serialize($this->data['result']);
                $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'editar', $descricao, $os_reag);

                $arquivo = $this->do_upload_pedido('userfile3');

                $imagem = $arquivo['file_name'];
                //$path = $arquivo['full_path'];
                $caminho = 'assets/uploads/pedido/';
                //$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
                $tamanho = $arquivo['file_size'];
                $extensao = $arquivo['file_ext'];

                $nomeArquivo = $this->input->post('nomeArquivo4');
                $data = array(
                    'nomeArquivo' => $this->input->post('nomeArquivo4'),
                    'imagem' => $imagem,
                    'caminho' => $caminho,
                    'tamanho' => $tamanho,
                    'extensao' => $extensao,
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'idOs' => $os_reag
                );
                $this->os_model->add('anexo_nfcliente', $data);
            }
        }
        if($editarNFDevOS){
            if ($this->input->post('nomeArquivo5') == '' || $this->input->post('pedido5') == '' ||  $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
            $data3['nf_venda_dev'] = $this->input->post('pedido5');
            $id_osreag = explode(',', $this->input->post('varias_os'));
            


            foreach ($id_osreag as $os_reag) {
                $this->data['result'] = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
                $descricao = serialize($this->data['result']);
                $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'editar', $descricao, $os_reag);

                $arquivo = $this->do_upload_pedido('userfile4');

                $imagem = $arquivo['file_name'];
                //$path = $arquivo['full_path'];
                $caminho = 'assets/uploads/pedido/';
                //$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
                $tamanho = $arquivo['file_size'];
                $extensao = $arquivo['file_ext'];

                $nomeArquivo = $this->input->post('nomeArquivo5');
                $data = array(
                    'nomeArquivo' => $this->input->post('nomeArquivo5'),
                    'imagem' => $imagem,
                    'caminho' => $caminho,
                    'tamanho' => $tamanho,
                    'extensao' => $extensao,
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'idOs' => $os_reag
                );
                $this->os_model->add('anexo_nfvenda', $data);
            }
        }
        if($editarAnexoCanhotoOS){
            if ($this->input->post('nomeArquivo6') == '' || $this->input->post('pedido6') == '' ||  $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
            $data3['nf_canhoto'] = $this->input->post('pedido6');
            $id_osreag = explode(',', $this->input->post('varias_os'));
            


            foreach ($id_osreag as $os_reag) {
                $this->data['result'] = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
                $descricao = serialize($this->data['result']);
                $this->salvarlog($this->session->userdata('idUsuarios'), 'os', 'editar', $descricao, $os_reag);

                $arquivo = $this->do_upload_pedido('userfile5');

                $imagem = $arquivo['file_name'];
                //$path = $arquivo['full_path'];
                $caminho = 'assets/uploads/pedido/';
                //$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
                $tamanho = $arquivo['file_size'];
                $extensao = $arquivo['file_ext'];

                $nomeArquivo = $this->input->post('nomeArquivo6');
                $data = array(
                    'nomeArquivo' => $this->input->post('nomeArquivo6'),
                    'imagem' => $imagem,
                    'caminho' => $caminho,
                    'tamanho' => $tamanho,
                    'extensao' => $extensao,
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'idOs' => $os_reag
                );
                $this->os_model->add('anexo_nfcanhoto', $data);
            }
        }
        if ($this->os_model->edit2('os', $data3, 'idOs', $this->input->post('varias_os')) == TRUE) {
            $id_osreag = explode(',', $this->input->post('varias_os'));
            foreach ($id_osreag as $os_reag){
                $os = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
                //$os->idUserHis = $this->session->userdata('idUsuarios');
                //var_dump($os); exit;
                $this->os_model->insertOSHis($os,$this->session->userdata('idUsuarios'));
            }
            $this->session->set_flashdata('success', 'O.S. Alterada com sucesso! O.S.: ' . $this->input->post('varias_os'));
            redirect(base_url() . 'index.php/os');
        } else {
            $this->session->set_flashdata('error', 'Erro ao editar!');
            redirect(base_url() . 'index.php/os');
        }
    }
    function finalizarpcp(){
        $distribuir = $this->os_model->getmaterial_dist($this->input->post('idOsDis'));
        $data = array(
            "finalizado"=>1,
            "data_finalizado"=>date('Y-m-d H:i:s')
        );
        if(!empty($distribuir)){
            foreach($distribuir as $d){
                $this->os_model->edit("distribuir_os",$data,"idDistribuir",$d->idDistribuir);
            }
        }
        $data = array(
            "fechadoPCP"=>1,
            "idOs"=>$this->input->post('idOsDis'),
            "idUser"=>$this->session->userdata('idUsuarios'),
            "data_insert"=>date('Y-m-d H:i:s'),
            "idMotivoLib"=>null
        );
        $this->os_model->add("hist_fechadoPCP",$data);
        $data2 = array(
            "fechadoPCP"=>1,
            "data_fechadoPCP"=>date('Y-m-d H:i:s')
        );
        $this->session->set_flashdata('success', 'Cadastro de Materiais finalizado com sucesso!');
        $this->os_model->edit("os",$data2,"idOs",$this->input->post('idOsDis'));
        redirect(base_url()."index.php/os/distribuiros/".$this->input->post('idOsDis'));
    }
    function redirectDistribuirOs(){
        if(!empty($this->input->post('idOs'))){
            $osDestino = $this->os_model->getByid_table($this->input->post('idOs'), 'os', 'idOs');
            if(!empty($osDestino)){
                redirect(base_url()."index.php/os/distribuiros/".$this->input->post('idOs'));
            }else{
                $this->session->set_flashdata('error', 'O.S. não encontrada.');
                redirect(base_url()."index.php/os/distribuiros/".$this->input->post('idOsAtual'));
            }
        }else{
            $this->session->set_flashdata('error', 'Informe a O.S.');
            redirect(base_url()."index.php/os/distribuiros/".$this->input->post('idOsAtual'));
        }

    }
    function criarSubOs(){
        $this->load->model('orcamentos_model');
        $idOs = $this->input->post('idOs');
        $descricao = $this->input->post('descricao');
        $idProdutos = $this->input->post('idProdutos');
        $quantidade = $this->input->post('quantidade');
        $os = $this->os_model->getos("os","orcamento_item.idProdutos","os.idOs = $idOs",null,1,null,true);
        $subOs = $this->orcamentos_model->getSubOsbyidOs($idOs);
        $data = array(
            "descricaoOsSub"=>$descricao,
            "idProduto_sub"=>$idProdutos,
            "quantidade"=>$quantidade,
            "data_insert"=>date('Y-m-d H:i:s'),
            "idClasse"=>$this->input->post('tipoClasse'),
            "idOs"=>$idOs,
            "ativo"=>1,
            "idProduto_master"=>$os->idProdutos,
            "posicao"=>count($subOs)
        );
        echo "<script>console.log(".json_encode($os).")</script>";
        $idInsert = $this->orcamentos_model->add("os_sub",$data,true);
        $ultimaSubOs = $this->os_model->getSubOsByIdProduto($idProdutos);
        if(!empty($ultimaSubOs)){
            $listaMateriais = $this->os_model->getMaterialByIdOsSub($ultimaSubOs->idOsSub);

            if(count($listaMateriais)>0){
                foreach($listaMateriais as $r){
                    $data2 = array(
                        "idOs"=>$idOs,
                        "idOsSub"=>$idInsert,
                        "idDistribuir"=>$r->idDistribuir,
                        "idInsumos"=>$r->idInsumos,
                        "quantidade"=>$r->quantidade,
                        "metrica"=>$r->metrica,
                        "comprimento"=>$r->comprimento,
                        "volume"=>$r->volume,
                        "peso"=>$r->peso,
                        "dimensoesL"=>$r->dimensoesL,
                        "dimensoesC"=>$r->dimensoesC,
                        "dimensoesA"=>$r->dimensoesA,
                        "dimensoes"=>$r->dimensoes,
                        "id_status_grupo"=>$r->id_status_grupo,
                        "obs"=>$r->obs
                    );           
                }
                $this->orcamentos_model->add("distribuir_os_sugestao",$data2);
            }
        }
       

        $this->session->set_flashdata('success', 'Sub O.S. criada com sucesso.');
        
        redirect(base_url() . 'index.php/os/distribuiros/'.$idOs);
    }

    function getInforDistribuirSugestao(){
        $dados_sugestao = $this->os_model->getInforDistribuirSugestao($this->input->post("idDistribuirSugestao"));
        if($dados_sugestao){
            $json = array(
                "result"=>true,
                "dados"=>$dados_sugestao
            );
        }else{
            $json = array(
                "result"=>false
            );
        }
        echo json_encode($json);
    }
    
   function rej_distribuir (){
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para distribuir OS.');
            redirect(base_url());
        }

        for($x=0;$x<count($this->input->post("idDistribuirSugestao"));$x++){
            $data3 = array(
                "respondeu"=>1,
                "resposta"=>0
            );
            $this->os_model->edit("distribuir_os_sugestao",$data3,"idDistribuirSugestao",$this->input->post("idDistribuirSugestao")[$x]);  
        }
        $this->session->set_flashdata('success', 'Itens rejeitados com sucesso!');                
        redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs')); 
   }
   function send($to,$assunto,$msg) {
        $this->load->config('email');
        $this->load->library('email');
        
        $from = $this->config->item('smtp_user');
        //$subject = $this->input->post('subject');
        //$message = $this->input->post('message');

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($assunto);
        $this->email->message($msg);

        if ($this->email->send()) {
            //echo 'Your Email has successfully been sent.';
        } else {
            //show_error($this->email->print_debugger());
        }
    }

    function ativardesativarsubos(){
        $this->load->model('orcamentos_model');
        if($this->input->post("status") == 'false'){
            $data = array("ativo"=>0);
        }else{
            $data = array("ativo"=>1);
        }
        $this->orcamentos_model->edit("os_sub",$data,'idOsSub',$this->input->post("idOsSub"));
        echo json_encode(array("result"=>true));
    }
    function ordemservico_pcp(){
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
            redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->model('almoxarifado_model');

        if (!empty($this->input->get('idOrcamentos'))) {
            $cod_orc = $this->input->get('idOrcamentos');
        } else {
            $cod_orc = $this->input->post('idOrcamentos');
        }



        $config['base_url'] = base_url() . 'index.php/os/ordemservico_pcp/';
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
        $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
        $this->data['status_os'] = $this->os_model->getstatus_os();
        $this->data['verificacao_controle'] = $this->os_model->getVerificacaoControle();
        $idOs = $this->input->post('idOs');

        $clientes_id  = $this->input->post('clientes_id');
        $idProdutos = $this->input->post('idProdutos');
        $numpedido_os = $this->input->post('numpedido_os');
        $tag = $this->input->post('tag');
        $numero_nf = $this->input->post('numero_nf');
        $numero_nffab = $this->input->post('numero_nffab');
        $descricao_item = $this->input->post('descricao_item');
        //$unidade_execucao = $this->input->post('unidade_execucao');
        $unid_execucao = $this->input->post('unid_execucao');
        $unid_faturamento = $this->input->post('unid_faturamento');
        $id_tipo = $this->input->post('id_tipo');
        $idStatusOs = $this->input->post('idStatusOs');
        $desenho = $this->input->post('desenho');
        $verificacaoControle = $this->input->post('verificacaoControle');
        $query_status_producao = "";
        if (!empty($idStatusOs)) {
            $conteudo = $idStatusOs;
            $query_status_producao = "(";
            $primeiro = true;
            foreach ($conteudo as $status_producao3) {
                if ($primeiro) {
                    $query_status_producao .= $status_producao3;
                    $primeiro = false;
                } else {
                    $query_status_producao .= "," . $status_producao3;
                }
            }
            $query_status_producao .= ")";
        }
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
        $query_unid_faturamento = "";
        if (!empty($unid_faturamento)) {
            $conteudo3 = $unid_faturamento;
            $query_unid_faturamento = "(";
            $primeiro3 = true;
            foreach ($conteudo3 as $unid_execucao2) {
                if ($primeiro3) {
                    $query_unid_faturamento .= $unid_execucao2;
                    $primeiro3 = false;
                } else {
                    $query_unid_faturamento .= "," . $unid_execucao2;
                }
            }
            $query_unid_faturamento .= ")";
        }
        $query_tipoos = "";
        if (!empty($id_tipo)) {
            $conteudo33 = $id_tipo;
            $query_tipoos = "(";
            $primeiro33 = true;
            foreach ($conteudo33 as $tipo3) {
                if ($primeiro33) {
                    $query_tipoos .= $tipo3;
                    $primeiro33 = false;
                } else {
                    $query_tipoos .= "," . $tipo3;
                }
            }
            $query_tipoos .= ")";
        }
        $query_desenho = "";
        $primeirodes = true;/**/
        if (!empty($desenho)) {
            $desenho2 = "";
            foreach ($desenho as $des) {
                if ($primeirodes) {
                    $desenho2 = $des;
                    $primeirodes = false;
                } else {
                    $desenho2 =  $desenho2 . ',' . $des;
                }
            }
            $query_desenho = " and os.statusDesenho IN($desenho2)";
        }
        //$query_desenho = " and os.statusDesenho IN(3)";
        $query_verifControl = "";
        $primeiroverifControl = true;
        if (!empty($verificacaoControle)) {
            $verificacaoControle2 = "";
            foreach ($verificacaoControle as $des) {
                if ($primeiroverifControl) {
                    $verificacaoControle2 = $des;
                    $primeiroverifControl = false;
                } else {
                    $verificacaoControle2 =  $verificacaoControle2 . ',' . $des;
                }
            }
            $query_verifControl = " and os.idVerificacaoControle IN($verificacaoControle2)";
        }
        $this->data['hist_vale'] = $this->os_model->getHistVale();
        /*
        $tem = false;
        $ntem = false;
        if(!empty($desenho)){
            foreach($desenho as $des){
                if($des == "tem"){
                    $tem = true;
                }
                if($des == "nao"){
                    $ntem = true;
                }
            }
            if(($tem && $ntem) || (!$tem && !$ntem)){
                $query_desenho = "";
            }else if($tem){
                $query_desenho = " and (SELECT anexo_desenho.idAnexo from anexo_desenho where anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) IS NOT NULL";
            }else if($ntem){
                $query_desenho = " and (SELECT anexo_desenho.idAnexo from anexo_desenho where anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) IS NULL";
            }
        }*/

        if (!empty($idOs) || !empty($cod_orc) || !empty($clientes_id) || !empty($idProdutos) || !empty($numpedido_os) || !empty($tag) || !empty($numero_nf) || !empty($descricao_item) || !empty($unidade_execucao) || !empty($query_unid_execucao) || !empty($query_unid_faturamento) || !empty($query_tipoos) || !empty($query_status_producao)  || !empty($query_verifControl) || !empty($numero_nffab) ) {




            $this->data['results'] = $this->os_model->getWhereLikeos($idOs, $cod_orc, $clientes_id, $idProdutos, $numpedido_os, $tag, $numero_nf, $descricao_item, 'os', "", $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", "", "", "", "", $query_tipoos, $query_desenho,'',$query_verifControl, $numero_nffab);


            $config['total_rows'] = $this->os_model->numrowsWhereLikeos($idOs, $cod_orc, $clientes_id, $idProdutos, $numpedido_os, $tag, $numero_nf, $descricao_item, 'os', "", $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", "", "", "", "", $query_tipoos);
            $config['per_page'] = 5;
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


            $config['total_rows'] = $this->os_model->count('os');
            $config['per_page'] = 5;
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


            $this->data['results'] = $this->os_model->getos('os', 'tipo_qtd.descricaoTipoQtd,os.data_abertura_real,os.data_insert,verificacao_controle.*,os.statusDesenho,os.obsDesenho,os.desconto_os,os.val_unit_os,os.numpedido_os,os.tag,os.val_ipi_os,os.idOs,os.`data_abertura`,os.`subtot_os`,os.`data_entrega`,os.`data_reagendada`,os.`data_producao`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,os_tipo.nome_tipo,(SELECT anexo_desenho.idAnexo from anexo_desenho where  anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue,status_os.nomeStatusOs ', 'os.statusDesenho = 3', 'os', $config['per_page'], $this->uri->segment(3));
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

        $this->data['view'] = 'pcp/ordemservico';
        $this->load->view('tema/topo', $this->data);
        //$this->load->view('tema/rodape');
    }
    function carregarinfoos(){
        $idOs = $this->input->post("idOs");
        $resultado = $this->os_model->getInfoOS($idOs);

        echo json_encode(array("result"=>true,"resultado"=>$resultado));
    }
    function alterarstatusos(){
        $idOs = $this->input->post("idOs");
        $statusOs = $this->input->post("idStatusOs");
        $data = array("idStatusOs"=>$statusOs);
        if($this->os_model->edit('os', $data, 'idOs', $idOs)){
            $objOs = $this->os_model->getOsIN($idOs,true);
            $this->os_model->insertOSHis($objOs);
            echo json_encode(array("result"=>true,"msg"=>"Alterado com Sucesso"));
        }else{
            echo json_encode(array("result"=>false,"msg"=>"Não foi possivel alterar o Status."));
        }
    }
    function ossemmateriais(){
        $this->data['status_os'] = $this->os_model->getstatus_os();
        if(!$this->input->get("verificar")){
            $where = " and os.idStatusos in (20,5,90)";
            $result = $this->os_model->getOSSemMateriais($where);
        }else{
            $where = '';
            $query_status_producao = "";
            $idStatusOs = $this->input->get("idStatusOs");
            if (!empty($idStatusOs)) {
                $conteudo = $idStatusOs;
                $query_status_producao = "(";
                $primeiro = true;
                foreach ($conteudo as $status_producao3) {
                    if ($primeiro) {
                        $query_status_producao .= $status_producao3;
                        $primeiro = false;
                    } else {
                        $query_status_producao .= "," . $status_producao3;
                    }
                }
                $query_status_producao .= ")";
                $where .= " and os.idStatusos in $query_status_producao";
            }

            $idOs = $this->input->get('idOs');
            if(!empty($idOs)){
                $where .= " and os.idOs = $idOs";
            }

            $idOrcamento = $this->input->get('idOrcamento');
            if(!empty($idOrcamento)){
                $where .= " and os.idOrcamento = $idOrcamento";
            }

            $statusDesenho = $this->input->get('statusDesenho');
            if(!empty($statusDesenho)){
                $where .= " and os.statusDesenho = $statusDesenho";
            }

            $pn = $this->input->get('pn');
            if(!empty($pn)){
                $where .= " and produtos.pn like \"%$pn%\"";
            }

            $descricaoOrc = $this->input->get('descricaoOrc');
            if(!empty($descricaoOrc)){
                $where .= " and orcamento_item.descricaoOrc like \"%$descricaoOrc%\"";
            }
            $result = $this->os_model->getOSSemMateriais($where);
        }
        $this->data['results'] = $result;
        $this->data['view'] = 'os/ossemmateriais';
        $this->load->view('tema/topo', $this->data);
    }
	
	
	

public function cliente_visualizar_os()
{
    // 1. Verificação de Segurança
    if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
        redirect('mapos/login');
    }

    // --- Configuração da Página ---
    $idClienteEspecifico = 927;
    if (is_array($idClienteEspecifico)) {
        $idClienteEspecifico = reset($idClienteEspecifico);
    }
    $idClienteEspecifico = (int)$idClienteEspecifico;

    $this->data['os_info'] = null;
    $this->data['anexos'] = [];
    $this->data['page_title'] = "Consulta de OS - Cliente";

    // 2. Lógica de Busca da OS
    if ($this->input->post('idOs')) {
        $idOs = $this->input->post('idOs');
        $os = $this->os_model->getOsForClient($idOs, $idClienteEspecifico);

        if ($os) {
            $this->data['os_info'] = $os;

            // 3. Consolidação e Construção dos Caminhos dos Anexos
            $all_anexos = [];

            // ANEXOS DE DESENHO - CORREÇÃO APLICADA AQUI
            $anexo_desenho = $this->os_model->getdesenho_os2($idOs);
            if ($anexo_desenho) {
                foreach ($anexo_desenho as $a) {
                    $a->tipo_anexo = 'Desenho/Outros';
                    // CORREÇÃO 1: Usando a propriedade 'imagem', que é a correta.
                    $a->url = base_url('assets/uploads/desenho/' . $a->imagem);
                    $all_anexos[] = $a;
                }
            }

            // ANEXOS DE PEDIDO DO CLIENTE
            $anexo_pedido = $this->os_model->getpedido_os($idOs);
            if ($anexo_pedido) {
                foreach ($anexo_pedido as $a) {
                    $a->tipo_anexo = 'Pedido Cliente';
                    // Para este tipo, mantemos 'anexo', conforme a estrutura original.
                    $a->url = base_url('assets/uploads/pedidos/' . $a->anexo);
                    $all_anexos[] = $a;
                }
            }

            // ... (outros tipos de anexo seriam adicionados aqui se necessário)

            // Filtra a lista de anexos para exibir apenas os formatos permitidos - LÓGICA CORRIGIDA
            $filtered_anexos = [];
            $allowed_extensions = ['.jpg', '.jpeg', '.mp4', '.png', '.pdf'];

            // CORREÇÃO 2: Lógica de filtragem segura que não causa erros.
            foreach ($all_anexos as $anexo) {
                $filename = '';
                // Primeiro, verifica se o anexo é um DESENHO (propriedade 'imagem')
                if (isset($anexo->imagem)) {
                    $filename = $anexo->imagem;
                } 
                // Se não for, verifica se é outro tipo (propriedade 'anexo')
                elseif (isset($anexo->anexo)) {
                    $filename = $anexo->anexo;
                }

                // Extrai a extensão apenas se um nome de arquivo foi encontrado
                if (!empty($filename)) {
                    $extension = strtolower(strrchr($filename, '.'));
                    if (in_array($extension, $allowed_extensions)) {
                        $filtered_anexos[] = $anexo;
                    }
                }
            }

            $this->data['anexos'] = $filtered_anexos;

        } else {
            $this->session->set_flashdata('error', 'OS não encontrada ou não pertence a este cliente.');
        }
    }

    // 4. Carregamento da View
    $this->data['view'] = 'os/cliente_os_view';
    $this->load->view('menu/principal', $this->data);
}
    public function alterarTipoCompra()
    {
        // Define o cabeçalho da resposta como JSON
        header('Content-Type: application/json');

        // Verifica se o usuário tem permissão para editar
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
            echo json_encode(['result' => 'error', 'message' => 'Você não tem permissão para editar este item.']);
            return;
        }

        // Pega os dados enviados pelo JavaScript
        $idDistribuir = $this->input->post('id');
        $tipoCompra = $this->input->post('tipo');

        // Valida se os dados foram recebidos
        if (!$idDistribuir || !$tipoCompra) {
            echo json_encode(['result' => 'error', 'message' => 'Dados inválidos recebidos (ID ou Tipo estão vazios).']);
            return;
        }

        // Carrega o os_model
        $this->load->model('os_model');

        // Prepara os dados para o banco
        $data = ['tipo_compra' => $tipoCompra];

        // Tenta editar o registro no banco de dados usando a função (agora simplificada) do model
        if ($this->os_model->edit('distribuir_os', $data, 'idDistribuir', $idDistribuir)) {
            // Se a edição for bem-sucedida, envia uma resposta de sucesso
            echo json_encode(['result' => 'success', 'message' => 'Tipo de compra atualizado com sucesso!']);
        } else {
            // Se falhar, envia uma resposta de erro
            echo json_encode(['result' => 'error', 'message' => 'Ocorreu um erro ao salvar no banco de dados.']);
        }
    }
}
