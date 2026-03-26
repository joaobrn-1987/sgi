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
        } else {
            //$this->uri->segment(2) == 'almoxarifado'
            $this->data['menucarteira'] = 'Carteira de Serviço';
        }
    }

    function index()
    {
        $this->gerenciar();
    }

    function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
            redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');

        if (!empty($this->input->get('idOrcamentos'))) {
            $cod_orc = $this->input->get('idOrcamentos');
        } else {
            $cod_orc = $this->input->post('idOrcamentos');
        }



        $config['base_url'] = base_url() . 'index.php/os/gerenciar/';
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
        $numero_nfserv = $this->input->post('numero_nfserv');
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
        $primeirodes = true;
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
            $query_desenho = " and statusDesenho IN($desenho2)";
        }
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

        if (!empty($idOs) || !empty($cod_orc) || !empty($clientes_id) || !empty($idProdutos) || !empty($numpedido_os) || !empty($tag) || !empty($numero_nf) || !empty($descricao_item) || !empty($unidade_execucao) || !empty($query_unid_execucao) || !empty($query_unid_faturamento) || !empty($query_tipoos) || !empty($query_status_producao) || !empty($query_desenho) || !empty($query_verifControl) || !empty($numero_nffab) || !empty($numero_nfserv) ) {




            $this->data['results'] = $this->os_model->getWhereLikeos($idOs, $cod_orc, $clientes_id, $idProdutos, $numpedido_os, $tag, $numero_nf, $descricao_item, 'os', "", $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", "", "", "", "", $query_tipoos, $query_desenho,'',$query_verifControl, $numero_nffab,$numero_nfserv);


            $config['total_rows'] = $this->os_model->numrowsWhereLikeos($idOs, $cod_orc, $clientes_id, $idProdutos, $numpedido_os, $tag, $numero_nf, $descricao_item, 'os', "", $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", "", "", "", "", $query_tipoos);
            $config['per_page'] = 50;
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
            $config['per_page'] = 50;
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


            $this->data['results'] = $this->os_model->getos('os', 'os.numero_nf,os.nf_venda_dev,os.nf_canhoto,os.nf_cliente,verificacao_controle.*,os.statusDesenho,os.obsDesenho,os.desconto_os,os.val_unit_os,os.numpedido_os,os.tag,os.val_ipi_os,os.idOs,os.`data_abertura`,os.`subtot_os`,os.`data_entrega`,os.`data_reagendada`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,os_tipo.nome_tipo,(SELECT anexo_desenho.idAnexo from anexo_desenho where anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue,status_os.nomeStatusOs ', '', 'os', $config['per_page'], $this->uri->segment(3));
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

        $this->data['view'] = 'os/os';
        $this->load->view('tema/topo', $this->data);
        //$this->load->view('tema/rodape');

    }

    function carteiraservico()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
            redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->model('orcamentos_model');


        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
        $this->data['status_os'] = $this->os_model->getStatusOs();
        $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
        $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
        $this->data['verificacao_controle'] = $this->os_model->getVerificacaoControle();

        $config['base_url'] = base_url() . 'index.php/os/carteiraservico/';


        $idOs = $this->input->post('idOs');
        $cod_orc = $this->input->post('idOrcamentos');
        $clientes_id  = $this->input->post('clientes_id');
        $idProdutos = $this->input->post('idProdutos');

        $descricao_item = $this->input->post('descricao_item');
        $unidade_execucao = $this->input->post('unidade_execucao');
        $verificacaoControle = $this->input->post('verificacaoControle');
        $desenho = $this->input->post('desenho');

        $querydatacadastro = "";
        $querydataentrega = "";
        $querydatareagendada = "";
        $queryentrega_reagendada = "";

        //data reagendada e entrega
        $dataeinicial = $this->input->post('dataeinicial');
        $dataefinal = $this->input->post('dataefinal');
        if (!empty($dataeinicial) && !empty($dataefinal)) {
            $dataeinicial2 = explode('/', $dataeinicial);
            $dataeinicial2 = $dataeinicial2[2] . '-' . $dataeinicial2[1] . '-' . $dataeinicial2[0];


            $dataefinal2 = explode('/', $dataefinal);
            $dataefinal2 = $dataefinal2[2] . '-' . $dataefinal2[1] . '-' . $dataefinal2[0];


            $queryentrega_reagendada = " and IF(os.data_reagendada is not null and os.data_reagendada != '',os.data_reagendada,os.data_entrega) BETWEEN '$dataeinicial2 00:00:00' AND '$dataefinal2 23:59:59' ";
        }



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

        }

        if (!empty($dataInicialcad) && !empty($dataFinalcad)) {
            $dataInicialcad2 = explode('/', $dataInicialcad);
            $dataInicialcad2 = $dataInicialcad2[2] . '-' . $dataInicialcad2[1] . '-' . $dataInicialcad2[0];


            $dataFinalcad2 = explode('/', $dataFinalcad);
            $dataFinalcad2 = $dataFinalcad2[2] . '-' . $dataFinalcad2[1] . '-' . $dataFinalcad2[0];

            $data_entrega['data_ini']   = $dataInicialcad;
            $data_entrega['data_final'] = $dataFinalcad;

            $querydatacadastro = " and os.data_abertura BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
        }
        $dataInicialentrega = $this->input->post('dataInicialentrega');
        $dataFinalentrega = $this->input->post('dataFinalentrega');
        if (!empty($dataInicialentrega) && !empty($dataFinalentrega)) {
            $dataInicialentrega2 = explode('-', $dataInicialentrega);
            $dataInicialentrega2 = $dataInicialentrega2[0] . '-' . $dataInicialentrega2[1] . '-' . $dataInicialentrega2[2];

            $dataFinalentrega2 = explode('-', $dataFinalentrega);
            $dataFinalentrega2 = $dataFinalentrega2[0] . '-' . $dataFinalentrega2[1] . '-' . $dataFinalentrega2[2];

            $querydataentrega = " and os.data_entrega BETWEEN '$dataInicialentrega2 00:00:00' AND '$dataFinalentrega2 23:59:59'";
        }
        $dataInicialreag = $this->input->post('dataInicialreag');
        $dataFinalreag = $this->input->post('dataFinalreag');
        if (!empty($dataInicialreag) && !empty($dataFinalreag)) {
            $dataInicialreag2 = explode('-', $dataInicialreag);
            $dataInicialreag2 = $dataInicialreag2[0] . '-' . $dataInicialreag2[1] . '-' . $dataInicialreag2[2];

            $dataFinalreag2 = explode('-', $dataFinalreag);
            $dataFinalreag2 = $dataFinalreag2[0] . '-' . $dataFinalreag2[1] . '-' . $dataFinalreag2[2];

            $querydatareagendada = " and os.data_reagendada BETWEEN '$dataInicialreag2 00:00:00' AND '$dataFinalreag2 23:59:59'";
        }

        $idStatusOs = $this->input->post('idStatusOs');
        $unid_execucao = $this->input->post('unid_execucao');
        $unid_faturamento = $this->input->post('unid_faturamento');
        $id_tipo = $this->input->post('id_tipo');

        $this->load->model('almoxarifado_model');
        $idUser = $this->session->userdata('idUsuarios');
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        $petrolina = false;
        $uberlandia = false;
        if (count($getUserEmpresa) > 0) {
            foreach ($getUserEmpresa as $r) {
                if ($r->id == 1 || $r->id == 3) {
                    $uberlandia    = true;
                }
                if ($r->id == 2) {
                    $petrolina = true;
                }
            }
        }

        $query_clientes = "";
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
            } else {
                /*if($uberlandia == true){
					$query_clientes3 =  " and clientes.idClientes not in(706,702,711,528,540,519,543,581,684,635,517,580,575,532,516,10,551)";
				}else*/
                if ($petrolina == true) {
                    $query_clientes3 =  " and clientes.idClientes in(706,702,711,528,540,552,519,543,581,684,635,517,580,575,532,516,10,551)";
                } else {
                    $query_clientes3 = '';
                }
            }
        }

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
        $query_desenho = "";
        $primeirodes = true;
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

        $query_clientes3 = '';


        if (!empty($idOs) || !empty($cod_orc) ||  !empty($idProdutos) || !empty($query_status_producao) || !empty($query_unid_execucao) || !empty($query_unid_faturamento) || !empty($querydataentrega) || !empty($querydatacadastro) || !empty($querydatareagendada) || !empty($query_clientes) || !empty($queryentrega_reagendada) || !empty($descricao_item) || !empty($query_tipoos) || !empty($unidade_execucao || !empty($query_clientes3) || !empty($query_desenho) || !empty($query_verifControl))) {


            $this->data['results'] = $this->os_model->getWhereLikeos($idOs, $cod_orc, '', $idProdutos, '', '', '', $descricao_item, 'c', $unidade_execucao, $query_status_producao, $query_unid_execucao, $query_unid_faturamento, $querydataentrega, $querydatacadastro, $querydatareagendada, $query_clientes, $queryentrega_reagendada, $query_tipoos, $query_desenho, $query_clientes3, $query_verifControl);

            $this->data['result_status'] = $this->os_model->getWhereLikeos_status($idOs, $cod_orc, '', $idProdutos, '', '', '', $descricao_item, 'c', $unidade_execucao, $query_status_producao, $query_unid_execucao, $query_unid_faturamento, $querydataentrega, $querydatacadastro, $querydatareagendada, $query_clientes, $queryentrega_reagendada, '', $query_tipoos, '', $query_clientes3);

            $this->data['data_entrega']= $data_entrega;

            $config['total_rows'] = $this->os_model->numrowsWhereLikeos($idOs, $cod_orc, '', $idProdutos, '', '', '', $descricao_item, 'c', $unidade_execucao, $query_status_producao, $query_unid_execucao, $query_unid_faturamento, $querydataentrega, $querydatacadastro, $querydatareagendada, $query_clientes, $queryentrega_reagendada, $query_tipoos);
            $config['per_page'] = 20000;
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
            $config['per_page'] = 20000;
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

            $this->data['data_entrega']= $data_entrega;


            $this->pagination->initialize($config);

            $this->data['results'] = $this->os_model->getos('os', 'verificacao_controle.*,os.nf_cliente,os.nf_venda_dev,os.nf_canhoto,os.statusDesenho,os.obsDesenho,os.idOs,os.val_ipi_os,os.val_unit_os,os.desconto_os,os.`data_abertura`,os.`data_entrega`,os.`data_reagendada`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,os.subtot_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,os_tipo.nome_tipo,status_os.nomeStatusOs,emitente.nome, (SELECT anexo_desenho.idAnexo from anexo_desenho where anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue', 'status_os.carteirapadrao = 1', 'c', $config['per_page'], $this->uri->segment(3));

            $this->data['result_status'] = $this->os_model->getWhereLikeos_status($this->uri->segment(3), '', '', '', '', '', '', '', 'c', '', '', '', '', '', '', '', '', 'and status_os.carteirapadrao = 1', '');
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

        $this->data['view'] = 'os/carteiraservico';
        $this->load->view('tema/topo', $this->data);
        //$this->load->view('tema/rodape');

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
            'data_reagendada' => $data_rea



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
        $this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs2'));
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


            $data_abertura = $this->input->post('data_abertura');
            $data_entrega = $this->input->post('data_entrega');
            $data_reagendada = $this->input->post('data_reagendada');
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

            if ($data_reagendada <> '') {
                $data_reagendada = explode('/', $data_reagendada);
                $data_reagendada = $data_reagendada[2] . '-' . $data_reagendada[1] . '-' . $data_reagendada[0];
                //$campo_reagendada = "'data_reagendada' => ".$data_reagendada.",";
            } else {

                $data_reagendada = null;
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
                if(!empty($verificacaoControle)){
                    $data3 = array(
                        'data_abertura' => $data_abertura . " " . date("h:i:s"),
                        'data_abertura_real' => date('Y-m-d H:i:s'),
                        'obs_controle' => ($this->input->post('obs_controle')),
                        'obs_os' => $this->input->post('obs_os'),
                        'data_entrega' => $data_entrega,
                        'data_reagendada' => $data_reagendada,
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
                        'obsDesenho' => $obs_desenho
    
    
    
                    );
                }else{
                    $data3 = array(
                        'data_abertura' => $data_abertura . " " . date("h:i:s"),
                        'data_abertura_real' => date('Y-m-d H:i:s'),
                        'obs_controle' => ($this->input->post('obs_controle')),
                        'obs_os' => $this->input->post('obs_os'),
                        'data_entrega' => $data_entrega,
                        'data_reagendada' => $data_reagendada,
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
                        'obsDesenho' => $obs_desenho
    
    
    
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
            }
            if(!empty($verificacaoControle)){
                $data = array(
                    'data_abertura' => $data_abertura . " " . date("h:i:s"),
                    'data_entrega' => $data_entrega,
                    'obs_os' => $this->input->post('obs_os'),
                    'data_reagendada' => $data_reagendada,
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
                    'obs_os' => $this->input->post('obs_os'),
                    'data_reagendada' => $data_reagendada,
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



    public function visualizar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
            redirect(base_url());
        }


        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        $this->load->model('producao_model');
        $this->data['distribuir_os'] = $this->os_model->getmaterial_dist($this->uri->segment(3));

        //$this->data['hrmaquina_os'] = $this->os_model->gethoramaquina($this->uri->segment(3));
        $this->data['hrmaquina_os'] = $this->producao_model->getHoraMaqForIdOsFinalizado($this->uri->segment(3));

        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['anexo_desenho'] = $this->os_model->getdesenho_os($this->uri->segment(3));
        //$this->data['usuario'] = $this->os_model->getdesenho_os($this->uri->segment(3));
        $this->data['anexo_pedido'] = $this->os_model->getpedido_os($this->uri->segment(3));
        $this->data['anexo_nf'] = $this->os_model->getnf_os($this->uri->segment(3), 'anexo_notafiscal');
        $this->data['anexo_nfcliente'] = $this->os_model->getnf_os($this->uri->segment(3), 'anexo_nfcliente');
        $this->data['anexo_nfvenda'] = $this->os_model->getnf_os($this->uri->segment(3), 'anexo_nfvenda');        
        $this->data['anexo_nfcanhoto'] = $this->os_model->getnf_os($this->uri->segment(3), 'anexo_nfcanhoto');
        $this->data['orcamento'] = $this->orcamentos_model->getById('orcamento', $this->data['result']->idOrcamentos);
        $this->data['status_os'] = $this->os_model->getstatus_os();
        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($this->data['orcamento']->idNatOperacao);
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
        $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
        $this->data['verificacao_controle'] = $this->os_model->getVerificacaoControle();
        /*   
        $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico($this->data['orcamento']->idGrupoServico);*/
        $this->data['itens_orcamento'] = $this->orcamentos_model->get_item_orc($this->data['result']->idOrcamento_item);

        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente($this->data['orcamento']->idEmitente);

        $result =  $this->os_model->getPedidosCompraFrete($this->uri->segment(3));
        $valorFrete = 0;
        foreach($result as $r){
            $valorFrete = $valorFrete + (($r->frete/$r->quantidadeProdutos)*$r->quantidadeProdutosOs);
        }
        $this->data['valor_frete'] = $valorFrete;

        $resultIcms =  $this->os_model->getPedidosCompraIcms($this->uri->segment(3));
        $valorIcms = 0;
        foreach($resultIcms as $r){
            $valorIcms = $valorIcms + $r->icms;
        }
        $this->data['valorIcms'] = $valorIcms;
        
        $resultAlteracoesStatus = $this->os_model->getHisStatusOs($this->uri->segment(3));
        $contt = 0;
        $conttDes = 0;
        $conttCont = 0;
        $arrayAlteracoesStatus = [];
        $arrayAlteracoesDesenho = [];
        $arrayAlteracoesCont = [];
        $anterior = null;
        $anteriorDes = null;
        $anteriorCont = null;
        foreach($resultAlteracoesStatus as $r){
            if($contt == 0){
                $anterior = $r->nomeStatusOs;
                array_push($arrayAlteracoesStatus,$r);
                $contt = 1;
            }else{
                if($anterior != $r->nomeStatusOs){
                    array_push($arrayAlteracoesStatus,$r);
                    $anterior = $r->nomeStatusOs;
                }else{
                    $arrayAlteracoesStatus[count($arrayAlteracoesStatus)-1] = $r;
                }
            }
            if($conttDes == 0){
                $anteriorDes = $r->statusDesenho;
                array_push($arrayAlteracoesDesenho,$r);
                $conttDes = 1;
            }else{
                if($anteriorDes != $r->statusDesenho){
                    array_push($arrayAlteracoesDesenho,$r);
                    $anteriorDes = $r->statusDesenho;
                }else{
                    $arrayAlteracoesDesenho[count($arrayAlteracoesDesenho)-1] = $r;
                }
            }
            if($conttCont == 0){
                $anteriorCont = $r->descricaoControle;
                array_push($arrayAlteracoesCont,$r);
                $conttCont = 1;
            }else{
                if($anteriorCont != $r->descricaoControle){
                    array_push($arrayAlteracoesCont,$r);
                    $anteriorCont = $r->descricaoControle;
                }else{
                    $arrayAlteracoesCont[count($arrayAlteracoesCont)-1] = $r;
                }
            }
        }
        $this->data['alteracoesStatus'] = $arrayAlteracoesStatus;
        $this->data['alteracoesDesenho'] = $arrayAlteracoesDesenho;
        $this->data['alteracoesCont'] = $arrayAlteracoesCont;


        $this->data['view'] = 'os/visualizarOs';
        $this->load->view('tema/topo', $this->data);
    }
    public function distribuiros()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
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
            if (!empty($_POST['exibirLista']))
                $exibLista = $_POST['exibirLista'];
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
                $this->data['distribuir_os'] = $this->os_model->getmaterial_dist($this->uri->segment(3), $ordertipo, $campo, null , $where);
                # echo("<script>console.log('N: 2');</script>");
            }
        } else {
            $this->data['distribuir_os'] = $this->os_model->getmaterial_dist($this->uri->segment(3), $ordertipo, $campo, 150, $where);
            # echo("<script>console.log('N: 3');</script>");
        }
        $this->load->model('cotacao_model');
        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
        $this->data['dados_statusgrupo'] = $this->os_model->getstatus_grupo('');
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



        $this->data['view'] = 'os/distribuiros';
        $this->load->view('tema/topo', $this->data);
    }




    public function maquinas()
    {
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
    public function autoCompleteDistribuir()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            //$campo = $_GET['campo'];

            $this->os_model->autoCompleteDistribuir($q);
        }
        if (isset($_GET['term2'])) {
            $q = strtolower($_GET['term2']);
            //$campo = $_GET['campo'];

            $this->os_model->autoCompleteDistribuir($q);
        }
        if (isset($_GET['term22'])) {
            $q = strtolower($_GET['term22']);
            //$campo = $_GET['campo'];

            $this->os_model->autoCompleteDistribuir($q);
        }
    }
    public function autoCompleteDistribuir2()
    {


        if (isset($_GET['dados2'])) {
            $q = strtolower($_GET['dados2']);
            //$campo = $_GET['campo'];

            $this->os_model->autoCompleteDistribuir($q);
        }
        if (isset($_GET['prod'])) {
            $q = strtolower($_GET['prod']);
            //$campo = $_GET['campo'];

            $this->os_model->autoCompleteProduto2($q);
        }
    }
    public function autoCompleteProduto2()
    {



        if (!empty($_GET['term'])) {
            $q = strtolower($_GET['term']);
            //$campo = $_GET['campo'];

            $this->os_model->autoCompleteProduto2($q);
        }
    }
    public function autoCompleteMaquina()
    {


        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            //$campo = $_GET['campo'];

            $this->os_model->autoCompleteMaquina($q);
        }
    }
    public function autoCompleteMaquinauser()
    {


        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            //$campo = $_GET['campo'];

            $this->os_model->autoCompleteMaquinauser($q);
        }
    }
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

            //date_default_timezone_set('America/Sao_Paulo');
            if($this->input->post('idOs') == 1 || $this->input->post('idOs') == 2 || $this->input->post('idOs') == 3 || $this->input->post('idOs') == 6){
                $data = array(
                    'idInsumos' => $insumoid,
                    'dimensoes' => $this->input->post('dimensoes'),
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
                    'idUserAprovacaoDir' => 51,
                    'data_autorizacaoPCP' => date('Y-m-d H:i:s'),
                    'data_autorizacaoDir' => date('Y-m-d H:i:s')
                );
            }else{
                $data = array(
                    'idInsumos' => $insumoid,
                    'dimensoes' => $this->input->post('dimensoes'),
                    'id_status_grupo' => $this->input->post('idgrupo'),
                    'idProdutos' => $this->input->post('idProdutos'),
                    'obs' => $this->input->post('obs'),
                    'quantidade' => $this->input->post('quantidade'),
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'solicitacao' => $solicitacao,
                    'usuario_cadastro' => $this->session->userdata('idUsuarios'),
                    'idOs' => $this->input->post('idOs')
                );
            }
            



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
    public function editar_distribuiros()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDistribuirOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para distribuir OS.');
            redirect(base_url());
        }

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



        if ($this->input->post('idgrupo') == 0) {
            $this->session->set_flashdata('error', 'Informe o grupo!');
            redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
        }

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe os dados necessarios!');
            redirect(base_url() . 'index.php/os/distribuiros/' . $this->input->post('idOs'));
        } else {





            $data = array(
                'idInsumos' => $this->input->post('idInsumos'),
                'id_status_grupo' => $this->input->post('idgrupo'),
                'idProdutos' => $idProdutosa2,
                'dimensoes' => $this->input->post('dimensoes'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $this->input->post('quantidade'),
                'data_alteracao' => date('Y-m-d H:i:s'),
                'idOs' => $this->input->post('idOs')
            );

            $this->data['result'] = $this->os_model->getByid_table($this->input->post('idDistribuir'), 'distribuir_os', 'idDistribuir');
            $descricao = serialize($this->data['result']);
            $this->salvarlog($this->session->userdata('idUsuarios'), 'distribuir_os', 'editar', $descricao, $this->input->post('idDistribuir'));


            if ($this->os_model->edit('distribuir_os', $data, 'idDistribuir', $this->input->post('idDistribuir')) == TRUE) {



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
        $this->load->model('pedidocompra_model');
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
                'numero_nf' => $this->input->post('nomeArquivo')

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
        } else {
            $directory = "nfvenda";
            $dataP = array(
                'nf_venda_dev' => $this->input->post('nomeArquivo')

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
    function do_upload_pedido()
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

        $this->os_model->delete('os', 'idOs', $id);


        $this->session->set_flashdata('success', 'OS excluída com sucesso!');
        redirect(base_url() . 'index.php/os/gerenciar/');
    }

    public function autoCompleteProduto()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteProduto($q);
        }
    }

    public function autoCompleteCliente()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteCliente($q);
        }
    }

    public function autoCompleteUsuario()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteUsuario($q);
        }
    }

    public function autoCompleteServico()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
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
    function almoxarifadoAdditensCompra(){
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
    /*
    function almoxarifadoAdditensCompra(){
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aPedidocompraalmox')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para cadastrar estoque em Almoxarifado.');
            redirect(base_url());
        }
        $idUser = $this->session->userdata('idUsuarios');
        $osItens = $this->input->post('osItens');
        $count = count($osItens);
        for ($x = 0; $x < $count; $x++) {
            if (!empty($osItens[$x]['idProdutoTD'])) {
                $idProd = $osItens[$x]['idProdutoTD'];
            } else {
                $json = array('result' => false, 'msggg' => 'Produto não selecionado.');
                echo json_encode($json);
                return;
            }
            if (!empty($osItens[$x]['idDimensoesTD'])) {
                $dimensoes = $osItens[$x]['idDimensoesTD'];
            } else {
                $dimensoes = null;
            }
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
            $data = array(
                'idInsumos' => $idProd,
                'dimensoes' => $dimensoes,
                'id_status_grupo' => '30',
                'idProdutos' => null,
                'obs' => $obs,
                'quantidade' => $qtd,
                'data_cadastro' => date('Y-m-d H:i:s'),
                'solicitacao' => '2',
                'usuario_cadastro' => $this->session->userdata('idUsuarios'),
                'idOs' => $os
            );
            is_numeric($id3 = $this->os_model->add('distribuir_os', $data, true));
        }
        $json = array('result' => true, 'msggg' => 'Solicitação criada com sucesso');
        echo json_encode($json);
    }*/
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
        $checkBox = $this->input->post('alterarOS');
        $verificaCheckbox = true;
        $editarReagendarOS = false;
        $editarDataEntregaOS = false;
        $editarStatusOS = false;
        $editarUnidExecOS = false;
        $editarUnidFatOS = false;
        $editarContratoOS = false;
        $editarTipoOS = false;
        $editarAnexoPedidoOS = false;
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
                if('editarDataOS' == $r){
                    $editarDataOS = true;
                }
            }
        }
        $verificacaoReagendada = true;
        if($editarReagendarOS){
            $listOs = $this->os_model->getOsIN($this->input->post('varias_os'));
            foreach ($listOs as $s){
                if($s->unid_execucao == 1 && (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproServ') && !$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs'))){
                    $verificacaoReagendada = false;
                }
                if($s->unid_execucao == 2 && (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproFab') && !$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs'))){
                    $verificacaoReagendada = false;
                }
                if($s->unid_execucao == 3 && (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproCil') && !$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs'))){
                    $verificacaoReagendada = false;
                }
                if($s->unid_execucao == 4 && (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eDataReproPet') && !$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs'))){
                    $verificacaoReagendada = false;
                }
            }
        }
        if(!$verificacaoReagendada){
            $this->session->set_flashdata('error', 'Você não tem permissão para reagendar essas O.S.');
            redirect(base_url()  . 'index.php/os');
        }
        if($verificaCheckbox){
            $this->session->set_flashdata('error', 'Não foram selecionados itens para ser editados.');
            redirect(base_url()  . 'index.php/os');
        }
        if( $this->input->post('varias_os') == ''){
            $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
            redirect(base_url() . 'index.php/os');
        }
        $data3 = array();
        if($editarDataOS){/*
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os');
            }*/
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
                //$this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                //redirect(base_url() . 'index.php/os');
                $data3['data_reagendada'] = null;
            }else{
    
                $data_rea = explode('/', $this->input->post('reagendarOs'));
                $data_rea = $data_rea[2] . '-' . $data_rea[1] . '-' . $data_rea[0];
        
                $data3['data_reagendada'] = $data_rea;

            }
        }
        if($editarDataEntregaOS){
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os');
            }
            if ($this->input->post('dataEntregaOs') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $data_ent = explode('/', $this->input->post('dataEntregaOs'));
            $data_ent = $data_ent[2] . '-' . $data_ent[1] . '-' . $data_ent[0];
    
            $data3['data_entrega'] = $data_ent;
        }
        if($editarStatusOS){
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os');
            }
            if ($this->input->post('idStatusOs2') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $statusOs = $this->input->post('idStatusOs2');    
            $data3['idStatusOs'] = $statusOs;
        }
        if($editarUnidExecOS){
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os');
            }
            if ($this->input->post('unid_execucao2') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $unid_exec = $this->input->post('unid_execucao2');    
            $data3['unid_execucao'] = $unid_exec;
        }
        if($editarUnidFatOS){
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os');
            }
            if ($this->input->post('unid_faturamento2') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $unid_exec = $this->input->post('unid_faturamento2');    
            $data3['unid_faturamento'] = $unid_exec;
        }
        if($editarContratoOS){
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os');
            }
            if ($this->input->post('contrato2') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $contrato2 = $this->input->post('contrato2');    
            $data3['contrato'] = $contrato2;
        }
        if($editarTipoOS){
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os');
            }
            if ($this->input->post('id_tipo2') == '' || $this->input->post('varias_os') == '') {
                $this->session->set_flashdata('error', 'Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
            }
    
            $id_tipo2 = $this->input->post('id_tipo2');    
            $data3['id_tipo'] = $id_tipo2;
        }
        if($editarAnexoPedidoOS){
            if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'reagendarOs')) {
                $this->session->set_flashdata('error', 'Você não tem permissão para editar OS.');
                redirect(base_url() . 'index.php/os');
            }
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
        if ($this->os_model->edit2('os', $data3, 'idOs', $this->input->post('varias_os')) == TRUE) {
            $id_osreag = explode(',', $this->input->post('varias_os'));
            foreach ($id_osreag as $os_reag){
                $os = $this->os_model->getByid_table($os_reag, 'os', 'idOs');
                $this->os_model->insertOSHis($os);
            }
            $this->session->set_flashdata('success', 'O.S. Alterada com sucesso! O.S.: ' . $this->input->post('varias_os'));
            redirect(base_url() . 'index.php/os');
        } else {
            $this->session->set_flashdata('error', 'Erro ao editar!');
            redirect(base_url() . 'index.php/os');
        }
    }
    function editar_datareagendada(){
        $idOs = $this->input->post('idos');
        //$dataReag = $this->input->post('data');
        if(!empty($this->input->post('datareag'))){
            $data_rea = explode('/', $this->input->post('datareag'));
            $data_rea = $data_rea[2] . '-' . $data_rea[1] . '-' . $data_rea[0];
            $data = array(
                "data_reagendada"=>$data_rea
            );
        }else{
            $data = array(
                "data_reagendada"=>null
            );
        }
        
        $vari = $this->os_model->edit('os', $data, 'idOs', $idOs);
        if($vari){
            $os = $this->os_model->getByid_table($idOs, 'os', 'idOs');
                $this->os_model->insertOSHis($os);
            echo json_encode(array("result"=>true,"msg"=>"Entrega reagendada com sucesso."));
        }else{
            echo json_encode(array("result"=>false,"msg"=>"Não foi possivel reagendar a entrega."));
        }
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
}
