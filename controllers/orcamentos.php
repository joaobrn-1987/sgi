<?php

class Orcamentos extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('orcamentos_model', '', TRUE);
        $this->load->model('peritagem_model');
        $this->data['menuOrcamentos'] = 'Orcamentos';
    }

    function index()
    {
        $this->gerenciar();
    }

    function gerenciar()
    {


        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar Orcamentos.');
            redirect(base_url());
        }

        $this->load->library('table');
        $this->load->library('pagination');




        $config['base_url'] = base_url() . 'index.php/orcamentos/gerenciar/';


        $cod_orc = $this->input->post('cod_orc');
        $clientes_id  = $this->input->post('clientes_id');
        $idstatusOrcamento = $this->input->post('idstatusOrcamento');
        $idGrupoServico = $this->input->post('idGrupoServico');
        $idNatOperacao = $this->input->post('idNatOperacao');
        $referencia = $this->input->post('referencia');
        $num_pedido = $this->input->post('num_pedido');
        $num_nf = $this->input->post('num_nf');
        $os = $this->input->post('cod_os');
        $status = $this->input->post('status_orc');
        $idProdutos = $this->input->post('idProdutos');
        $descricao_item = $this->input->post('descricao_item');

        if (!empty($cod_orc) || !empty($clientes_id) || !empty($idstatusOrcamento) || !empty($idGrupoServico) || !empty($idNatOperacao) || !empty($referencia) || !empty($num_pedido) || !empty($num_nf) || !empty($status <> '') || !empty($idProdutos <> '') || !empty($descricao_item <> '') || !empty($os <> '')) {

            $this->data['results'] = $this->orcamentos_model->getWhereLikeorc2($cod_orc, $clientes_id, $idstatusOrcamento, $idGrupoServico, $idNatOperacao, $referencia, $num_pedido, $num_nf, $status, $idProdutos, $descricao_item, $os);

            $config['total_rows'] = $this->orcamentos_model->numrowsWhereLikeorc($cod_orc, $clientes_id, $idstatusOrcamento, $idGrupoServico, $idNatOperacao, $referencia, $num_pedido, $num_nf, $status, $idProdutos, $descricao_item);
            $config['per_page'] = 10;
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


            $config['total_rows'] = $this->orcamentos_model->count('orcamento');
            $config['per_page'] = 10;
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

            $this->data['results'] = $this->orcamentos_model->getorc('orcamento', '*, orcamento.idOrcamentos as id_Orcam, grupo_servico.nome as nomeGrupoServ', '', $config['per_page'], $this->uri->segment(3));
        }

        //Gera número único de orçamento com data e hora
        /*  $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
        $hora= date('H');
        $min = date('i');
        $seg = date('s');
        $dados['num_orcamento'] = $ano.$mes.$dia.$hora.$min.$seg;*/

        //Gera data de cadastro
        $ano_cadastro = date('Y');
        $mes_cadastro = date('m');
        $dia_cadastro = date('d');
        $data_cadastro = $dia_cadastro . '/' . $mes_cadastro . '/' . $ano_cadastro;
        $data['data_cadastro'] = $data_cadastro;


        //$this->data['results'] = $this->insumos_model->get('insumos','idInsumos,nomeInsumo,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep','',$config['per_page'],$this->uri->segment(3));

        // $data['menuInsumos'] = 'Insumos';

        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
        $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
        $this->data['dados_clientes'] = $this->orcamentos_model->getCliente();
        $this->data['dados_vendedor'] = $this->orcamentos_model->getVendedor();
        $this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
        $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
        $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();

        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();

        $this->data['view'] = 'orcamentos/orcamentos';
        $this->load->view('tema/topo', $this->data);
        $this->load->view('tema/rodape');
    }

    function adicionar()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar Orcamentos.');
            redirect(base_url());
        }

        $filter = $this->input->post('filter');
        $field  = $this->input->post('field');
        $search = $this->input->post('search');

        $this->load->model('produtos_model');
        $this->load->model('peritagem_model');
        $this->load->model('producao_model');


        //$data['dados_cat'] = $this->insumos_model->getcat('categoriaInsumos','idCategoria,descricaoCategoria');
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
        $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
        $this->data['dados_clientes'] = $this->orcamentos_model->getCliente();
        $this->data['dados_vendedor'] = $this->orcamentos_model->getVendedor();
        $this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
        $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
        $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();

        $this->data['dados_classe'] = $this->peritagem_model->getTypeClass();
        //$this->data['dados_pn'] = $this->orcamentos_model->getPN();
        $this->data['results_pn'] = $this->orcamentos_model->getPN($field, $search);
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';




        if ($this->form_validation->run('orcamento') == false) {
            echo $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {


            /*try {
                
                $dataVenda = explode('/', $dataVenda);
                $dataVenda = $dataVenda[2].'-'.$dataVenda[1].'-'.$dataVenda[0];


            } catch (Exception $e) {
               $dataVenda = date('Y/m/d'); 
            }*/

            $data = array(
                'idClientes' => $this->input->post('clientes_id'),
                'idEmitente' => $this->input->post('idEmitente'),
                'data_abertura' => date('Y-m-d H:i:s'),
                'idSolicitante' => $this->input->post('idSolicitante'),
                'idVendedor' => $this->input->post('idVendedor'),
                'idGerente' => $this->input->post('idGerente'),
                'idstatusOrcamento' => $this->input->post('idstatusOrcamento'),
                'referencia' => $this->input->post('referencia'),
                'cond_pgto' => $this->input->post('cond_pgto'),
                'garantia_servico' => $this->input->post('garantia_servico'),
                'idGrupoServico' => $this->input->post('idGrupoServico'),
                'idNatOperacao' => $this->input->post('idNatOperacao'),
                'num_pedido' => $this->input->post('num_pedido'),
                'num_nf' => $this->input->post('num_nf'),
                'entrega' => $this->input->post('entrega'),
                'validade' => $this->input->post('validade'),
                'entregaoutros' => $this->input->post('entregaoutros'),
                'obs' => $this->input->post('obs')

            );


            $tiposServicos = $this->orcamentos_model->getAllTiposServico();

            if (is_numeric($id = $this->orcamentos_model->add('orcamento', $data, true))) {

                //inserindo itens_de_orcamento
                $contador = count($this->input->post('item'));

                $total = 0;

                for ($x = 0; $x < $contador; $x++) {
                    $desconto_ = str_replace(".", "", $this->input->post('desconto')[$x]);
                    $desconto_ = str_replace(",", ".", $desconto_);

                    $val_ipi_ = str_replace(".", "", $this->input->post('val_ipi')[$x]);
                    $val_ipi_ = str_replace(",", ".", $val_ipi_);




                    $valorunita = str_replace(".", "", $this->input->post('val_unit')[$x]);
                    $valorunita1 = str_replace(",", ".", $valorunita);

                    $frete = str_replace(".", "", $this->input->post('frete')[$x]);
                    $frete = str_replace(",", ".", $frete);

                    $subtotal_ = str_replace(".", "", $this->input->post('subtot')[$x]);
                    $subtotal_ = str_replace(",", ".", $subtotal_);

                    $total_ = str_replace(".", "", $this->input->post('vlr_total')[$x]);
                    $total_ = str_replace(",", ".", $total_);

                    if ($this->input->post('descricao_item')[$x] == '') {
                        $des_produto = "XXXXXXX";
                    } else {
                        $des_produto = $this->input->post('descricao_item')[$x];
                    }

                    if ($this->input->post('idProdutos')[$x] == '') {
                        $id_produto = "4251";
                    } else {
                        $id_produto = $this->input->post('idProdutos')[$x];
                    }

                    $dataChegada = null;
                    if ($this->input->post('data_chegada')[$x] != "") {
                        $dataChegada = explode("/", $this->input->post('data_chegada')[$x]);
                        $dataChegada = $dataChegada[2] . "-" . $dataChegada[1] . "-" . $dataChegada[0];
                    }

                    if ($this->input->post('orc')[$x] == "serv") {
                        $data2 = array(
                            'descricao_item' => $des_produto,
                            'idProdutos' => $id_produto,
                            'desconto' => $desconto_,
                            'val_ipi' => $val_ipi_,
                            'qtd' => $this->input->post('qtd')[$x],
                            'val_unit' => $valorunita1,
                            'tipoOrc' => $this->input->post('orc')[$x],
                            'tipoProd' => $this->input->post('tipo_prod')[$x],
                            'tag' => $this->input->post('tag')[$x],
                            'prazo' => $this->input->post('prazo')[$x],
                            'frete' => $frete,
                            'subtot' => $subtotal_,
                            'valor_total' => $total_,
                            //'statusDesenho' => 1,
                            'detalhe' => $this->input->post('detalhe')[$x],
                            'data_previsao_chegada' => $dataChegada,
                            'idOrcamentos' => $id
                        );
                    } else {
                        $data2 = array(
                            'descricao_item' => $des_produto,
                            'idProdutos' => $id_produto,
                            'desconto' => $desconto_,
                            'val_ipi' => $val_ipi_,
                            'qtd' => $this->input->post('qtd')[$x],
                            'val_unit' => $valorunita1,
                            'tipoOrc' => $this->input->post('orc')[$x],
                            'tipoProd' => $this->input->post('tipo_prod')[$x],
                            'tag' => $this->input->post('tag')[$x],
                            'prazo' => $this->input->post('prazo')[$x],
                            'frete' => $frete,
                            'subtot' => $subtotal_,
                            'valor_total' => $total_,
                            'detalhe' => $this->input->post('detalhe')[$x],
                            'data_previsao_chegada' => $dataChegada,
                            'idOrcamentos' => $id
                        );
                    }
                    $data4 = null;
                    if ($this->input->post('orc')[$x] == 'fab') {
                        if (!empty($this->input->post('idChecklist')[$x])) {
                            $data4 = $this->input->post('idChecklist')[$x];/*
                            $novoInputCatalogoIdProduto = "novoCatalogoIdProduto_".$this->input->post('contador')[$x];
                            $novoInputCatalogoPN = "novoCatalogoPN_".$this->input->post('contador')[$x];
                            $novoInputCatalogoQtd= "novoCatalogoQtd_".$this->input->post('contador')[$x];

                            if(!empty($this->input->post($novoInputCatalogoIdProduto))){
                                for($c=0;$c<sizeof($this->input->post($novoInputCatalogoIdProduto));$c++){
                                    if(!empty($this->input->post($novoInputCatalogoIdProduto)[$c])){
                                        $data8 = array(
                                            "idProduto"=>$this->input->post($novoInputCatalogoIdProduto)[$c],
                                            "quantidade"=>$this->input->post($novoInputCatalogoQtd)[$c],
                                            "idCatalogoProduto"=>$this->input->post('idChecklist')[$x],
                                            "tipoProd"=>'pec',
                                            "data_cadastro"=>date('Y-m-d H:i:s'),
                                            "idUsuario"=>$this->session->userdata('idUsuarios'),
                                            "ativo"=>1
                                        );
                                        $this->orcamentos_model->add('catalogo_produto_itens', $data8, true);
                                    }
                                }
                            }
                            */
                        }/* else{
                            $produto = $this->produtos_model->getById($id_produto);
                            $data8 = array(
                                "idProduto"=>$id_produto,
                                'descricaoCatalogo'=>$produto->pn,
                                'data_cadastro'=>date('Y-m-d H:i:s'),
                                "idUsuario"=>$this->session->userdata('idUsuarios'),
                                "ativo"=>1
                            );
                            $data4 = $this->orcamentos_model->add('catalogo_produto', $data8, true);
                            $novoInputCatalogoIdProduto = "novoCatalogoIdProduto_".$this->input->post('contador')[$x];
                            $novoInputCatalogoPN = "novoCatalogoPN_".$this->input->post('contador')[$x];
                            $novoInputCatalogoQtd= "novoCatalogoQtd_".$this->input->post('contador')[$x];
                            //echo json_encode($this->input->post($novoInputCatalogoIdProduto));
                            if(!empty($this->input->post($novoInputCatalogoIdProduto))){
                                for($c=0;$c<sizeof($this->input->post($novoInputCatalogoIdProduto));$c++){
                                    if(!empty($this->input->post($novoInputCatalogoIdProduto)[$c])){
                                        $data9 = array(
                                            "idProduto"=>$this->input->post($novoInputCatalogoIdProduto)[$c],
                                            "quantidade"=>$this->input->post($novoInputCatalogoQtd)[$c],
                                            "idCatalogoProduto"=>$data4,
                                            "tipoProd"=>'pec',
                                            "data_cadastro"=>date('Y-m-d H:i:s'),
                                            "idUsuario"=>$this->session->userdata('idUsuarios'),
                                            "ativo"=>1
                                        );
                                        $this->orcamentos_model->add('catalogo_produto_itens', $data9, true);
                                    }
                                    
                                }
                            }
                        } */

                        $data2 = array_merge($data2, array('idCatalogo' => $data4));
                    }

                    $idOrcItem = $this->orcamentos_model->add('orcamento_item', $data2, true);
                    $this->criarOs($idOrcItem);
                    if ($this->input->post('orc')[$x] == 'fab') {
                        if (!empty($data4)) {
                            $catalogoitens = $this->peritagem_model->getCatalogoItensByIdCatalogo($data4);
                            foreach ($catalogoitens as $c) {
                                $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($c->idProduto);
                                if (!empty($anexo)) {
                                    if (!empty($anexo->idOsSub)) {
                                        $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                                    } else if (!empty($anexo->idOrcServicoEscopoItens)) {
                                        $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                                    }
                                    foreach ($anexos as $v) {
                                        $novoAnexo = clone $v;
                                        $novoAnexo->idAnexo = null;
                                        $novoAnexo->idOrcServicoEscopoItens = null;
                                        $novoAnexo->idOrcamentos_item = $idOrcItem;
                                        $novoAnexo->idOsSub = null;
                                        $novoAnexo->idOs = null;
                                        $novoAnexo->idCatItem = $c->idCatalogoProdutoItens;
                                        $novoAnexo->statusAnexo = 1;
                                    }
                                    $this->peritagem_model->add("anexo_desenho", $novoAnexo, true);
                                }
                            }
                        }
                    }

                    if ($this->input->post('orc')[$x] == "serv") {
                        $nameInputPN = 'addPN_' . $this->input->post('contador')[$x];
                        $nameInputProduto = 'addIdProduto_' . $this->input->post('contador')[$x];
                        $nameInputEscopo = 'addIdServicoEscopo_' . $this->input->post('contador')[$x];
                        $nameInputNovoClasse = 'novoEscopoIdClasse_' . $this->input->post('contador')[$x];
                        /*
                        $nameInputNovoDescProd = 'novoEscopoDescProd_'.$this->input->post('contador')[$x];
                        $nameInputNovoProduto = 'novoEscopoIdProduto_'.$this->input->post('contador')[$x];                    
                        $nameInputNovoAddimag = 'addimag_'.$this->input->post('contador')[$x];
                        $nameInputNovoAddNomeImag = 'addnomeArquivo_'.$this->input->post('contador')[$x];

                        $nameInputEscopoExis = 'idServicoEscopo_'.$this->input->post('contador')[$x];
                        $nameInputImag = 'imag_'.$this->input->post('contador')[$x];
                        $nameInputNomeImag = 'nomeArquivo_'.$this->input->post('contador')[$x];

                        $nameInputIdServicoItemNovo = 'idServicoEscopoItens_novopn_'.$this->input->post('contador')[$x];
                        $nameInputnovoidpn = 'novoidpn_'.$this->input->post('contador')[$x];*/

                        //$idEscopo = $this->peritagem_model->getEscopoByIdProduto($id_produto,$this->input->post('tipo_prod')[$x]);
                        $escopo = $this->peritagem_model->getEscopoByIdProduto($id_produto, $this->input->post('tipo_prod')[$x]);
                        if (empty($escopo)) {
                            $produto = $this->produtos_model->getById($id_produto);
                            $data3 = array(
                                'nomeServicoEscopo' => strtoupper('Checklist Especifico: ' . $produto->pn),
                                'idProduto' => $id_produto,
                                'tipoServico' => $this->input->post('tipo_prod')[$x]
                            );
                            $idEscopo = $this->peritagem_model->add("servico_escopo", $data3, true);
                            $escopo = $this->peritagem_model->getEscopoById($idEscopo);
                            for ($c = 0; $c < count($this->input->post($nameInputPN)); $c++) {
                                if ($this->input->post('tipo_prod')[$x] == "cil") {
                                    $itemEscopo = $this->peritagem_model->getEscopoItemByIdEscopoItem($this->input->post($nameInputEscopo)[$c]);
                                    $novoItem = clone $itemEscopo;
                                    $novoItem->idServicoEscopoItens = 0;
                                    $novoItem->idServicoEscopo = $idEscopo;
                                    $novoItem->idProduto = (!empty($this->input->post($nameInputProduto)[$c]) ? $this->input->post($nameInputProduto)[$c] : null);
                                    $this->input->post($nameInputProduto)[$c] = $this->peritagem_model->add("servico_escopo_itens", $novoItem, true);
                                } else {
                                    for ($c = 0; $c < count($this->input->post($nameInputPN)); $c++) {
                                        if (!empty($this->input->post($nameInputPN)[$c])) {
                                            $itemEscopo = $this->peritagem_model->getEscopoItemByIdEscopoItem($this->input->post($nameInputEscopo)[$c]);
                                            $novoItem = clone $itemEscopo;
                                            $novoItem->idServicoEscopoItens = 0;
                                            $novoItem->idServicoEscopo = $idEscopo;
                                            $novoItem->idProduto = (!empty($this->input->post($nameInputProduto)[$c]) ? $this->input->post($nameInputProduto)[$c] : null);
                                            $this->input->post($nameInputProduto)[$c] = $this->peritagem_model->add("servico_escopo_itens", $novoItem, true);
                                        }
                                    }
                                }
                            }
                            $escopoItens = $this->peritagem_model->getEscopoItensByIdEscopo($idEscopo);
                            $verificarTestar = false;
                            $verificarMontagem = false;
                            $verificarPintura = false;
                            $termo = "Testar";
                            $pattern = '/' . $termo . '/';
                            $termo2 = "Montagem";
                            $pattern2 = '/' . $termo2 . '/';
                            $termo3 = "Pintura";
                            $pattern3 = '/' . $termo3 . '/';
                            foreach ($escopoItens as $r) { //Padrão a ser encontrado na string $tags
                                if ($termo == $r->descricaoServicoItens) {
                                    $verificarTestar = true;
                                }
                                if ($termo2 == $r->descricaoServicoItens) {
                                    $verificarMontagem = true;
                                }
                                if ($termo3 == $r->descricaoServicoItens) {
                                    $verificarPintura = true;
                                }
                            }
                            if (!$verificarMontagem) {
                                $dataItem = array(
                                    "descricaoServicoItens" => "Montagem",
                                    "idServicoEscopo" => $escopo->idServicoEscopo,
                                    "idProduto" => null,
                                    "idClasse" => 1,
                                    "tipoCampo" => "check",
                                    "ativo" => 1
                                );
                                $this->peritagem_model->add("servico_escopo_itens", $dataItem);
                            }
                            if (!$verificarTestar) {
                                $dataItem = array(
                                    "descricaoServicoItens" => "Testar",
                                    "idServicoEscopo" => $escopo->idServicoEscopo,
                                    "idProduto" => null,
                                    "idClasse" => 1,
                                    "tipoCampo" => "check",
                                    "ativo" => 1
                                );
                                $this->peritagem_model->add("servico_escopo_itens", $dataItem);
                            }
                            if (!$verificarPintura) {
                                $dataItem = array(
                                    "descricaoServicoItens" => "Pintura",
                                    "idServicoEscopo" => $escopo->idServicoEscopo,
                                    "idProduto" => null,
                                    "idClasse" => 1,
                                    "tipoCampo" => "check",
                                    "ativo" => 1
                                );
                                $this->peritagem_model->add("servico_escopo_itens", $dataItem);
                            }
                        } else {
                        }
                        //$escopo = $this->peritagem_model->getEscopoById($idEscopo);
                        if (!empty($escopo)) {

                            //$dataItem2 = 
                            $escopoItens = $this->peritagem_model->getEscopoItensByIdEscopo($escopo->idServicoEscopo);
                            $verificarTestar = false;
                            $verificarMontagem = false;
                            $verificarPintura = false;
                            $termo = "Testar";
                            $pattern = '/' . $termo . '/';
                            $termo2 = "Montagem";
                            $pattern2 = '/' . $termo2 . '/';
                            $termo3 = "Pintura";
                            $pattern3 = '/' . $termo3 . '/';
                            foreach ($escopoItens as $r) { //Padrão a ser encontrado na string $tags
                                if ($termo == $r->descricaoServicoItens) {
                                    $verificarTestar = true;
                                }
                                if ($termo2 == $r->descricaoServicoItens) {
                                    $verificarMontagem = true;
                                }
                                if ($termo3 == $r->descricaoServicoItens) {
                                    $verificarPintura = true;
                                }
                            }
                            if (!$verificarMontagem) {
                                $dataItem = array(
                                    "descricaoServicoItens" => "Montagem",
                                    "idServicoEscopo" => $escopo->idServicoEscopo,
                                    "idProduto" => null,
                                    "idClasse" => 1,
                                    "tipoCampo" => "check",
                                    "ativo" => 1
                                );
                                $this->peritagem_model->add("servico_escopo_itens", $dataItem);
                            }
                            if (!$verificarTestar) {
                                $dataItem = array(
                                    "descricaoServicoItens" => "Testar",
                                    "idServicoEscopo" => $escopo->idServicoEscopo,
                                    "idProduto" => null,
                                    "idClasse" => 1,
                                    "tipoCampo" => "check",
                                    "ativo" => 1
                                );
                                $this->peritagem_model->add("servico_escopo_itens", $dataItem);
                            }
                            if (!$verificarPintura) {
                                $dataItem = array(
                                    "descricaoServicoItens" => "Pintura",
                                    "idServicoEscopo" => $escopo->idServicoEscopo,
                                    "idProduto" => null,
                                    "idClasse" => 1,
                                    "tipoCampo" => "check",
                                    "ativo" => 1
                                );
                                $this->peritagem_model->add("servico_escopo_itens", $dataItem);
                            }
                            $escopoItens = $this->peritagem_model->getEscopoItensByIdEscopo($escopo->idServicoEscopo);


                            $data = array(
                                'idServicoEscopo' => $escopo->idServicoEscopo,
                                'idOrcItem' => $idOrcItem,
                                'idStatusPeritagem' => 1
                            );
                            $idOrcServEscopo = $this->peritagem_model->add("orc_servico_escopo", $data, true);
                            foreach ($escopoItens as $r) {
                                $data2 = array(
                                    'idServicoEscopoItens' => $r->idServicoEscopoItens,
                                    'idOrcServicoEscopo' => $idOrcServEscopo,
                                    //'tiposServico'=>($r->idClasse == 1 && $r->descricaoServicoItens != "Testar" && $r->descricaoServicoItens != "Montagem" && $r->descricaoServicoItens != "Pintura"?json_encode($this->orcamentos_model->getAllTiposServico()):null),
                                    //'tiposServico'=>($r->idClasse == 1?json_encode($this->config->item('tiposServico')):null),
                                    'ativo' => $r->ativo
                                );

                                $idOrcServItem2 = $this->peritagem_model->add("orc_servico_escopo_itens", $data2, true);
                                if (!empty($r->idClasse == 1 && $r->descricaoServicoItens != "Montagem" && $r->descricaoServicoItens != "Pintura" && $r->descricaoServicoItens != "Testar")) {
                                    foreach ($tiposServicos as $l) {
                                        $data = array(
                                            "idTiposServico" => $l->idTiposServico,
                                            "idOrcServicoEscopoItem" => $idOrcServItem2
                                        );
                                        $this->peritagem_model->add("tiposservico_servitem", $data, true);
                                    }
                                }
                                if (!empty($r->idProduto)) {
                                    $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($r->idProduto);
                                    if (!empty($anexo)) {
                                        if (!empty($anexo->idOsSub)) {
                                            $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                                        } else if (!empty($anexo->idOrcServicoEscopoItens)) {
                                            $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                                        }
                                        foreach ($anexos as $v) {
                                            $novoAnexo = clone $v;
                                            $novoAnexo->idAnexo = null;
                                            $novoAnexo->idOrcServicoEscopoItens = $idOrcServItem2;
                                            $novoAnexo->idOrcamentos_item = $idOrcItem;
                                            $novoAnexo->idOsSub = null;
                                            $novoAnexo->idOs = null;
                                            $novoAnexo->idCatItem = null;
                                            $novoAnexo->statusAnexo = 1;
                                        }
                                        $this->peritagem_model->add("anexo_desenho", $novoAnexo, true);
                                    }
                                }
                            }
                        }

                        $dataControle = array(
                            "idOrcamento" => $id,
                            "idOrcamento_item" => $idOrcItem,
                            "idProduto" => $id_produto,
                            "descricaoItem" => $des_produto,
                            "quantidade" => $this->input->post('qtd')[$x],
                            "idStatusEtapaServico" => 1,
                            "data_cadastro" => date('Y-m-d H:i:s')
                        );
                        $idetapa = $this->peritagem_model->add("controle_etapa", $dataControle, true);
                        $escopo = $this->peritagem_model->getEscopoByIdProduto($id_produto, $this->input->post('tipo_prod')[$x]);

                        if (!empty($escopo)) {
                            $produtosEscopo = $this->producao_model->getProdutosEscopoByIdProduto($escopo->idServicoEscopo);
                        } else {
                            $produtosEscopo = array();
                        }

                        $checklist = $this->peritagem_model->getCatalogoAtivosByIdProduto2($id_produto);
                        if (!empty($checklist)) {
                            $produtosChecklist = $this->producao_model->getProdutosCatalogoByIdProduto($checklist->idCatalogoProduto);
                        } else {
                            $produtosChecklist = array();
                        }
                        if (sizeof($produtosEscopo) > sizeof($produtosChecklist)) {
                            $oCerto = $produtosEscopo;
                        } else {
                            $oCerto = $produtosChecklist;
                        }
                        foreach ($oCerto as $v) {
                            $dataSubitem = array(
                                "idControleEtapa" => $idetapa,
                                "idProduto" => $v->idProdutos,
                                "descricaoItem" => $v->descricao,
                                "quantidade" => 0,
                                "idStatusEtapaServico" => 1,
                                "local" => null,
                                "data_cadastro" => date('Y-m-d H:i:s')
                            );
                            $this->peritagem_model->add("controle_etapa_subitem", $dataSubitem, true);
                        }
                    }
                }
                $this->session->set_flashdata('success', 'Orçamento cadastrado com sucesso.');
                redirect('orcamentos/editar/' . $id);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'orcamentos/adicionarOrcamento';
        $this->load->view('tema/topo', $this->data);
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function criarOs($idOrcamentoItem)
    {
        $this->load->model('os_model');
        $resultado = $this->orcamentos_model->get_item_orc2($idOrcamentoItem);
        $data_entrega = date('Y-m-d', strtotime('+' . $resultado->prazo . ' days', strtotime(date('Y-m-d'))));
        $os = $this->orcamentos_model->get2('orcamento', ' * ', 'orcamento.idOrcamentos = ' . $resultado->idOrcamentos, 1, 0, true);
        $data2 = array(
            'idOrcamento_item' => $idOrcamentoItem,
            'val_unit_os' => $resultado->val_unit,
            'desconto_os' => $resultado->desconto,
            'qtd_os' => $resultado->qtd,
            'subtot_os' => $resultado->subtot,
            'val_ipi_os' => $resultado->val_ipi,
            'data_entrega' => $data_entrega,
            'idStatusOs' => 200,
            'data_abertura' => null,
            'data_abertura_real' => null,
            'data_insert' => date('Y-m-d H:i:s'),
            'unid_execucao' => 0,
            'unid_faturamento' => 0,
            'id_tipo' => 0,
            'contrato' => 0,
            'idOrcamentos' => $os->idOrcamentos,
            'numpedido_os' => $os->num_pedido
        );
        $nova_os =     $this->orcamentos_model->add('os', $data2, true);
        $os = $this->os_model->getByid_table($nova_os, 'os', 'idOs');
        $this->os_model->insertOSHis($os);

        $dataSubOs = array(
            "idOs" => $nova_os,
            "idProduto_master" => $resultado->idProdutos,
            "idProduto_sub" => $resultado->idProdutos,
            "posicao" => 0,
            "data_insert" => date('Y-m-d H:i:s'),
            "quantidade" => $resultado->qtd,
            "idClasse" => ($resultado->tipoProd == 'serv'?1:2),
            "ativo" => 1,
            "descricaoOsSub" => $resultado->descricao_item
        );
        $this->orcamentos_model->add("os_sub", $dataSubOs);
        
        
    }
    function adicionaritem()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Orcamentos');
            redirect(base_url());
        }

        $this->load->model('peritagem_model');
        $this->load->model('produtos_model');
        $data2 = array(
            'descricao_item' => $this->input->post('produtoNovo'),
            'idProdutos' => $this->input->post('idProdNovo'),
            'tipoOrc' => $this->input->post('orcNovo'),
            'tipoProd' => $this->input->post('prodNovo'),
            'desconto' => 0.00,
            'val_ipi' => 0.00,
            'qtd' => 1,
            'val_unit' => 0.00,
            'prazo' => 20,
            'subtot' => 0.00,
            'valor_total' => 0.00,

            'idOrcamentos' => $this->input->post('idOrcamentositem')
        );

        $id = $this->orcamentos_model->add('orcamento_item', $data2, true);

        if ($this->input->post('orcNovo') == "fab") {
            $catalogo = $this->peritagem_model->getCatalogoAtivosByIdProduto2($this->input->post('idProdNovo'));
            $getProduto = $this->produtos_model->getById($this->input->post("idProdNovo"));
            if (!empty($catalogo)) {
                $data4 = array(
                    "idCatalogo" => $catalogo->idCatalogoProduto
                );
                $this->orcamentos_model->edit("orcamento_item", $data4, "idOrcamento_item", $id);
                $idCatalogo = $catalogo->idCatalogoProduto;
            } else {
                $data4 = array(
                    "idProduto" => $this->input->post("idProdNovo"),
                    "data_cadastro" => date('Y-m-d H:i:s'),
                    "idUsuario" => $this->session->userdata('idUsuarios'),
                    "tipoProd" => 'pec',
                    "descricaoCatalogo" => $getProduto->pn,
                    "ativo" => 1
                );
                $idCatalogo = $this->peritagem_model->add('catalogo_produto', $data4, true);
                $data5 = array(
                    "idCatalogo" => $idCatalogo
                );
                $this->orcamentos_model->edit("orcamento_item", $data5, "idOrcamento_item", $id);
            }

            $catalogoitens = $this->peritagem_model->getCatalogoItensByIdCatalogo($idCatalogo);
            foreach ($catalogoitens as $c) {
                $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($c->idProduto);
                if (!empty($anexo)) {
                    if (!empty($anexo->idOsSub)) {
                        $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                    } else if (!empty($anexo->idOrcServicoEscopoItens)) {
                        $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                    }
                    foreach ($anexos as $v) {
                        $novoAnexo = clone $v;
                        $novoAnexo->idAnexo = null;
                        $novoAnexo->idOrcServicoEscopoItens = null;
                        $novoAnexo->idOrcamentos_item = $id;
                        $novoAnexo->idOsSub = null;
                        $novoAnexo->idOs = null;
                        $novoAnexo->idCatItem = $c->idCatalogoProdutoItens;
                        $novoAnexo->statusAnexo = 1;
                    }
                    $this->peritagem_model->add("anexo_desenho", $novoAnexo, true);
                }
            }
        } else if ($this->input->post('orcNovo') == "serv") {
            $escopo = $this->peritagem_model->getEscopoByIdProduto($this->input->post('idProdNovo'), $this->input->post('prodNovo'));
            if (!empty($escopo)) {
                $idEscopo = $escopo->idServicoEscopo;
                $escopoItens = $this->peritagem_model->getEscopoItensByIdEscopo($idEscopo);
                $data = array(
                    'idServicoEscopo' => $idEscopo,
                    'idOrcItem' => $id,
                    'idStatusPeritagem' => 1
                );
                $idOrcServEscopo = $this->peritagem_model->add("orc_servico_escopo", $data, true);
                foreach ($escopoItens as $r) {
                    $data2 = array(
                        'idServicoEscopoItens' => $r->idServicoEscopoItens,
                        'idOrcServicoEscopo' => $idOrcServEscopo,
                        'ativo' => $r->ativo
                    );
                    $idOrcServItem2 = $this->peritagem_model->add("orc_servico_escopo_itens", $data2, true);

                    if ($r->idProduto) {
                        $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($r->idProduto);
                        if (!empty($anexo)) {
                            if (!empty($anexo->idOsSub)) {
                                $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                            } else if (!empty($anexo->idOrcServicoEscopoItens)) {
                                $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                            }
                            foreach ($anexos as $v) {
                                $novoAnexo = clone $v;
                                $novoAnexo->idAnexo = null;
                                $novoAnexo->idOrcServicoEscopoItens = $idOrcServItem2;
                                $novoAnexo->idOrcamentos_item = $id;
                                $novoAnexo->idOsSub = null;
                                $novoAnexo->idOs = null;
                                $novoAnexo->idCatItem = null;
                                $novoAnexo->statusAnexo = 1;
                            }
                            $this->peritagem_model->add("anexo_desenho", $novoAnexo, true);
                        }
                    }
                }
            } else if ($this->input->post('prodNovo') == "cil") {
                $objEscopo = $this->peritagem_model->getEscopoById(1);
                $escopoItens = $this->peritagem_model->getOnlyEscopoItensByIdEscopo($objEscopo->idServicoEscopo);
                $data = array(
                    'nomeServicoEscopo' => strtoupper('Checklist Especifico: ' . $this->input->post('produtoNovo')),
                    'idProduto' => $this->input->post('idProdNovo'),
                    'tipoServico' => $this->input->post('prodNovo')
                );
                $idEscopo = $this->peritagem_model->add("servico_escopo", $data, true);
                $data2 = array(
                    'idServicoEscopo' => $idEscopo,
                    'idOrcItem' => $id,
                    'idStatusPeritagem' => 1
                );
                $idOrcServEscopo = $this->peritagem_model->add("orc_servico_escopo", $data2, true);
                foreach ($escopoItens as $r) {
                    $r->idServicoEscopo = $idEscopo;
                    $r->idServicoEscopoItens = null;
                    $idEscopoItem = $this->peritagem_model->add("servico_escopo_itens", $r, true);
                    $data2 = array(
                        'idServicoEscopoItens' => $idEscopoItem,
                        'idOrcServicoEscopo' => $idOrcServEscopo,
                        'ativo' => $r->ativo
                    );
                    $idOrcServitem = $this->peritagem_model->add("orc_servico_escopo_itens", $data2, true);
                    if ($r->idProduto) {
                        $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($r->idProduto);
                        if (!empty($anexo)) {
                            if (!empty($anexo->idOsSub)) {
                                $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                            } else if (!empty($anexo->idOrcServicoEscopoItens)) {
                                $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                            }
                            foreach ($anexos as $v) {
                                $novoAnexo = clone $v;
                                $novoAnexo->idAnexo = null;
                                $novoAnexo->idOrcServicoEscopoItens = $idOrcServitem;
                                $novoAnexo->idOrcamentos_item = $id;
                                $novoAnexo->idOsSub = null;
                                $novoAnexo->idOs = null;
                                $novoAnexo->idCatItem = null;
                                $novoAnexo->statusAnexo = 1;
                            }
                            $this->peritagem_model->add("anexo_desenho", $novoAnexo, true);
                        }
                    }
                }
            } else {
                $data = array(
                    'nomeServicoEscopo' => strtoupper('Checklist Especifico: ' . $this->input->post('produtoNovo')),
                    'idProduto' => $this->input->post('idProdNovo'),
                    'tipoServico' => $this->input->post('prodNovo')
                );
                $idEscopo = $this->peritagem_model->add("servico_escopo", $data, true);
                $data2 = array(
                    'idServicoEscopo' => $idEscopo,
                    'idOrcItem' => $id,
                    'idStatusPeritagem' => 1
                );
                $idOrcServEscopo = $this->peritagem_model->add("orc_servico_escopo", $data2, true);
            }
        }


        $linha_orcitem = $this->orcamentos_model->get_number_linhas('orcamento_item', 'idOrcamentos = ' . $this->input->post('idOrcamentositem'), '*');

        $linha_orcirep = $this->orcamentos_model->get_number_linhas('orcamento', 'idOrcamentos = ' . $this->input->post('idOrcamentositem') . ' and status_orc = 1', '*');

        $linha_os = $this->orcamentos_model->get_number_linhas('os', 'idOrcamentos = ' . $this->input->post('idOrcamentositem'), 'DISTINCT(`idOrcamento_item`)');

        /*'status_orc' => 1,
                        'idstatusOrcamento' => 12
        */

        if (count($linha_os) == count($linha_orcitem)) {
            $data = array(

                'idstatusOrcamento' => 4
            );
        } elseif (count($linha_os) == 0 && count($linha_orcirep) > 0) {
            $data = array(

                'idstatusOrcamento' => 12
            );
        } elseif (count($linha_os) == 0 && count($linha_orcirep) == 0) {
            $data = array(

                'idstatusOrcamento' => 11
            );
        } else {
            $data = array(

                'idstatusOrcamento' => 13
            );
        }
        $dataControle = array(
            "idOrcamento" => $this->input->post('idOrcamentositem'),
            "idOrcamento_item" => $id,
            "idProduto" => $this->input->post('idProdNovo'),
            "descricaoItem" => $this->input->post('produtoNovo'),
            "quantidade" => 1,
            "idStatusEtapaServico" => 1,
            "data_cadastro" => date('Y-m-d H:i:s')
        );

        $this->peritagem_model->add("controle_etapa", $dataControle, true);
        $this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $this->input->post('idOrcamentositem'));

        $this->session->set_flashdata('success', 'Item adicionado com sucesso!');
        redirect(base_url() . 'index.php/orcamentos/editar/' . $this->input->post('idOrcamentositem'));
    }

    function editar(){

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Orcamentos');
            redirect(base_url());
        }

        $this->data['result'] = $this->orcamentos_model->getById2('orcamento', $this->uri->segment(3));

        $this->load->model('peritagem_model');
        $this->load->model('produtos_model');
        $this->load->model('producao_model');
        $this->load->model('os_model');

        //$data['dados_cat'] = $this->insumos_model->getcat('categoriaInsumos','idCategoria,descricaoCategoria');
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
        $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
        $this->data['dados_clientes'] = $this->orcamentos_model->getCliente();

        $were = 'clientes.idClientes = ' . $this->data['result']->idClientes;
        $this->data['dados_solicitante'] = $this->orcamentos_model->getsolicitante('clientes', $were);
        $this->data['dados_vendedor'] = $this->orcamentos_model->getVendedor();
        $this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
        $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
        $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();
        $this->data['dados_item'] = $this->orcamentos_model->getorc_itemB($this->uri->segment(3));
        $this->data['dados_classe'] = $this->peritagem_model->getTypeClass();
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
        //echo "jjjjj";
        //print_r($this->data['dados_item']);


        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        foreach ($this->data['dados_item'] as $r) {
            if ($r->tipoOrc == "fab") {
                $r->catalogoItens = $this->peritagem_model->getCatalogoAtivosByIdProduto($r->idProdutos);
            }
        }

        if ($this->form_validation->run('orcamento') == false) {
            echo $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {
            $data = array(
                'idClientes' => $this->input->post('clientes_id'),
                'idEmitente' => $this->input->post('idEmitente'),
                'idSolicitante' => $this->input->post('idSolicitante'),
                'idVendedor' => $this->input->post('idVendedor'),
                'idGerente' => $this->input->post('idGerente'),
                'idstatusOrcamento' => $this->input->post('idstatusOrcamento'),
                'referencia' => $this->input->post('referencia'),
                'cond_pgto' => $this->input->post('cond_pgto'),
                'garantia_servico' => $this->input->post('garantia_servico'),
                'validade' => $this->input->post('validade'),
                'idGrupoServico' => $this->input->post('idGrupoServico'),
                'idNatOperacao' => $this->input->post('idNatOperacao'),
                'num_pedido' => $this->input->post('num_pedido'),
                'num_nf' => $this->input->post('num_nf'),
                'entrega' => $this->input->post('entrega'),
                'entregaoutros' => $this->input->post('entregaoutros'),
                'obs' => $this->input->post('obs'),
                'idOrcamentos' => $this->input->post('idOrcamentos')

            );

            if ($this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $this->input->post('idOrcamentos')) == TRUE) {
                //exclui todos itens do orçamento q nao tem os
                //$orc_item = $this->orcamentos_model->getitemorc($this->input->post('idOrcamentos'));


                //inserindo itens_de_orcamento
                $contador = count($this->input->post('item'));



                $total = 0;


                for ($x = 0; $x < $contador; $x++) {

                    $valorunita = str_replace(".", "", $this->input->post('val_unit')[$x]);
                    $valorunita1 = str_replace(",", ".", $valorunita);

                    $frete = str_replace(".", "", $this->input->post('frete')[$x]);
                    $frete = str_replace(",", ".", $frete);

                    $subtotal_ = str_replace(".", "", $this->input->post('subtot')[$x]);
                    $subtotal_ = str_replace(",", ".", $subtotal_);

                    $vlr_total_ = str_replace(".", "", $this->input->post('vlr_total')[$x]);
                    $vlr_total_ = str_replace(",", ".", $vlr_total_);



                    if ($this->input->post('desconto')[$x] == '') {

                        $desconto_ = 0.00;
                    } else {
                        $desconto_ = str_replace(".", "", $this->input->post('desconto')[$x]);
                        $desconto_ = str_replace(",", ".", $desconto_);
                    }

                    if ($this->input->post('val_ipi')[$x] == '') {
                        $val_ipi_ = 0.00;
                    } else {
                        $val_ipi_ = str_replace(".", "", $this->input->post('val_ipi')[$x]);
                        $val_ipi_ = str_replace(",", ".", $val_ipi_);
                    }
                    $orcamento_item = $this->orcamentos_model->get2("orcamento_item", " * ", "idOrcamento_item = " . $this->input->post('id_orc_item')[$x], 1, 0, true);
                    $os2 = $this->orcamentos_model->get2("os", " * ", "idOrcamento_item = " . $this->input->post('id_orc_item')[$x], 1, 0, true);
                    if (empty($os2)) {
                        $this->criarOs($this->input->post('id_orc_item')[$x]);
                    }else if(empty($this->orcamentos_model->getSubOsbyidOs($os2->idOs))){
                        $dataSubOs = array(
                            "idOs" => $os2->idOs,
                            "idProduto_master" => $orcamento_item->idProdutos,
                            "idProduto_sub" => $orcamento_item->idProdutos,
                            "posicao" => 0,
                            "data_insert" => date('Y-m-d H:i:s'),
                            "quantidade" => $orcamento_item->qtd,
                            "idClasse" => ($orcamento_item->tipoOrc?1:2),
                            "ativo" => 1,
                            "descricaoOsSub" => $orcamento_item->descricao_item
                        );
                        $this->orcamentos_model->add("os_sub", $dataSubOs);
                    }
                    if ($this->input->post('orc')[$x] == 'serv' && $orcamento_item->statusDesenho != 3 && $orcamento_item->statusDesenho != 2) {
                        $statusDesenho = 1;
                    } else if ($this->input->post('orc')[$x] == 'fab') {
                        $statusDesenho = 0;
                    } else {
                        $statusDesenho = $orcamento_item->statusDesenho;
                    }
                    $dataChegada = null;
                    if ($this->input->post('data_chegada')[$x] != "") {
                        $dataChegada = explode("/", $this->input->post('data_chegada')[$x]);
                        $dataChegada = $dataChegada[2] . "-" . $dataChegada[1] . "-" . $dataChegada[0];
                    }
                    //echo $this->input->post('idProdutos')[$x];exit;
                    $data2 = array(
                        'descricao_item' => $this->input->post('descricao_item')[$x],
                        'idProdutos' => $this->input->post('idProdutos')[$x],
                        'tag' => $this->input->post('tag')[$x],
                        'desconto' => $desconto_,
                        'val_ipi' => $val_ipi_,
                        'qtd' => $this->input->post('qtd')[$x],
                        'val_unit' => $valorunita1,
                        'frete' => $frete,
                        'prazo' => $this->input->post('prazo')[$x],
                        'subtot' => $subtotal_,
                        'detalhe' => $this->input->post('detalhe')[$x],
                        'valor_total' => $vlr_total_,
                        'idOrcamentos' =>  $this->input->post('idOrcamentos'),
                        'tipoOrc' => $this->input->post('orc')[$x],
                        'data_previsao_chegada' => $dataChegada,
                        //'statusDesenho' =>$statusDesenho,
                        'tipoProd' => $this->input->post('tipo_prod')[$x]
                    );

                    if (!empty($this->input->post('orc')[$x]) && !empty($this->input->post('tipo_prod')[$x])) {
                        if ($this->input->post('orc')[$x] == 'serv') {
                            $data2 = array_merge($data2, array('idCatalogo' => NULL));
                            $nameInputNovoDescProd = 'novoEscopoDescProd_' . $this->input->post('contador')[$x];
                            $nameInputNovoProduto = 'novoEscopoIdProduto_' . $this->input->post('contador')[$x];
                            $nameInputnovoEscopoPN_ = 'novoEscopoPN_' . $this->input->post('contador')[$x];
                            $nameInputNovoClasse = 'novoEscopoIdClasse_' . $this->input->post('contador')[$x];
                            $novoPN = 'novoidpn_' . $this->input->post('id_orc_item')[$x];
                            $novoPNDesc = 'novopn_' . $this->input->post('id_orc_item')[$x];
                            $idOrcServicoEscopoItens_novopn_ = 'idOrcServicoEscopoItens_novopn_' . $this->input->post('id_orc_item')[$x];

                            $idEscopo = $this->peritagem_model->getEscopoByIdProduto($this->input->post('idProdutos')[$x], $this->input->post('tipo_prod')[$x]);

                            if (!empty($idEscopo)) {
                                $idEscopo =  $idEscopo->idServicoEscopo;/*
                                if($this->input->post($nameInputNovoDescProd)){
                                    for($c = 0;$c<count($this->input->post($nameInputNovoProduto));$c++){
                                        if(!empty($this->input->post($nameInputNovoDescProd)[$c])){
                                            if(!empty($this->input->post($nameInputnovoEscopoPN_)[$c]) && empty($this->input->post($nameInputNovoProduto)[$c])){
                                                $objProduto = $this->produtos_model->getByPn($this->input->post($nameInputnovoEscopoPN_)[$c]);
                                                if(!empty($objProduto)){
                                                    $idNovoProduto = $objProduto->idProdutos;
                                                }
                                            }else{
                                                $idNovoProduto =$this->input->post($nameInputNovoProduto)[$c];
                                            }
                                            $data4 = array(
                                                'idProduto'=>(!empty($idNovoProduto)? $idNovoProduto:null),
                                                'idServicoEscopo'=>$idEscopo,
                                                'descricaoServicoItens'=>strtoupper($this->input->post($nameInputNovoDescProd)[$c]),
                                                'idClasse'=>$this->input->post($nameInputNovoClasse)[$c]
                                            );                                        
                                            $this->peritagem_model->add("servico_escopo_itens",$data4,true);
                                        }                                
                                    }
                                }*/
                                $escopoItens = $this->peritagem_model->getEscopoItensByIdEscopo($idEscopo);
                                $escopoOrc = $this->peritagem_model->getEscopoOrcByidEscopoAndIdOrcItem($idEscopo, $this->input->post('id_orc_item')[$x]);
                                if (!empty($escopoOrc)) {
                                    $escopoOrcItens = $this->peritagem_model->getEscopoItensOrcByidEscopoAndIdOrcItem($escopoOrc->idOrcServicoEscopo);
                                    $verifyItem = false;
                                    foreach ($escopoItens as $r) {
                                        $verifyItem = false;
                                        foreach ($escopoOrcItens as $b) {
                                            if ($b->idServicoEscopoItens == $r->idServicoEscopoItens) {
                                                $verifyItem = true;
                                            }
                                        }
                                        if (!$verifyItem) {
                                            $data5 = array(
                                                'idServicoEscopoItens' => $r->idServicoEscopoItens,
                                                'idOrcServicoEscopo' => $escopoOrc->idOrcServicoEscopo,
                                                'ativo' => $r->ativo
                                            );
                                            $idOrcServItem = $this->peritagem_model->add("orc_servico_escopo_itens", $data5, true);
                                            if ($r->idProduto) {
                                                $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($r->idProduto);
                                                if (!empty($anexo)) {
                                                    if (!empty($anexo->idOsSub)) {
                                                        $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                                                    } else if (!empty($anexo->idOrcServicoEscopoItens)) {
                                                        $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                                                    }
                                                    foreach ($anexos as $v) {
                                                        $novoAnexo = clone $v;
                                                        $novoAnexo->idAnexo = null;
                                                        $novoAnexo->idOrcServicoEscopoItens = $idOrcServItem;
                                                        $novoAnexo->idOrcamentos_item = $this->input->post('id_orc_item')[$x];
                                                        $novoAnexo->idOsSub = null;
                                                        $novoAnexo->idOs = null;
                                                        $novoAnexo->idCatItem = null;
                                                        $novoAnexo->statusAnexo = 1;
                                                    }
                                                    $this->peritagem_model->add("anexo_desenho", $novoAnexo, true);
                                                }
                                            }
                                        }
                                    }
                                    $nameOrcEscopoItens = "idOrcServicoEscopoItens_" . $this->input->post('id_orc_item')[$x];
                                    $nameValorItens = "valorOrcItem_" . $this->input->post('id_orc_item')[$x];
                                    for ($c = 0; $c < count($this->input->post($nameOrcEscopoItens)); $c++) {
                                        $valorOrcItem = str_replace(".", "", $this->input->post($nameValorItens)[$c]);
                                        $valorOrcItem = str_replace(",", ".", $valorOrcItem);
                                        $data7 = array("valorUnitario" => $valorOrcItem);
                                        $this->orcamentos_model->edit('orc_servico_escopo_itens', $data7, 'idOrcServicoEscopoItens', $this->input->post($nameOrcEscopoItens)[$c]);
                                    }/*
                                    for($y=0;$y<count($this->input->post($novoPN));$y++){
                                        if(empty($this->input->post($novoPN)[$y])&&!empty($this->input->post($novoPNDesc)[$y])){
                                            $objProduto = $this->produtos_model->getByPn($this->input->post($novoPNDesc)[$y]);
                                                if(!empty($objProduto)){
                                                    $idNovoPN = $objProduto->idProdutos;
                                                }
                                        }else{
                                            $idNovoPN = $this->input->post($novoPN)[$y];
                                        }
                                        if(!empty($idNovoPN)){
                                            $escopoItem = $this->peritagem_model->getEscopoItemByIdOrcEscopoItem($this->input->post($idOrcServicoEscopoItens_novopn_)[$y]);
                                            $escopoItem->idProduto = $idNovoPN;
    
                                            $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($escopoItem->idProduto);
                                            if(!empty($anexo)){
                                                if(!empty($anexo->idOsSub)){
                                                    $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                                                }else if(!empty($anexo->idOrcServicoEscopoItens)){
                                                    $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                                                }
                                                //$idEscopoItem = $this->peritagem_model->getEscopoItensOrcByidOrcServicoEscopoItem
                                                foreach($anexos as $v){
                                                    $novoAnexo = clone $v;
                                                    $novoAnexo->idAnexo = null;
                                                    $novoAnexo->idOrcServicoEscopoItens = $this->input->post($idOrcServicoEscopoItens_novopn_)[$y];
                                                    $novoAnexo->idOrcamentos_item = $this->input->post('id_orc_item')[$x];
                                                    $novoAnexo->idOsSub = null;
                                                    $novoAnexo->idOs = null;
                                                    $novoAnexo->idCatItem = null;                                    
                                                    $novoAnexo->statusAnexo = 1;
                                                }
                                                $this->peritagem_model->add("anexo_desenho",$novoAnexo,true);
                                            }
                                            $this->peritagem_model->edit("servico_escopo_itens",$escopoItem,"idServicoEscopoItens",$escopoItem->idServicoEscopoItens);
                                        }
                                    }*/
                                    $idOrcServEscopo = $escopoOrc->idOrcServicoEscopo;
                                    $this->peritagem_model->desativarEscoposOrcItem($this->input->post('id_orc_item')[$x], $idOrcServEscopo);
                                    $this->peritagem_model->ativarEscoposOrcItem($idOrcServEscopo);
                                } else {

                                    $data = array(
                                        'idServicoEscopo' => $idEscopo,
                                        'idOrcItem' => $this->input->post('id_orc_item')[$x],
                                        'idStatusPeritagem' => 1
                                    );


                                    $idOrcServEscopo = $this->peritagem_model->add("orc_servico_escopo", $data, true);
                                    foreach ($escopoItens as $r) {
                                        $data6 = array(
                                            'idServicoEscopoItens' => $r->idServicoEscopoItens,
                                            'idOrcServicoEscopo' => $idOrcServEscopo
                                        );
                                        $idOrcServItem = $this->peritagem_model->add("orc_servico_escopo_itens", $data6, true);
                                        if ($r->idProduto) {
                                            $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($r->idProduto);
                                            if (!empty($anexo)) {
                                                if (!empty($anexo->idOsSub)) {
                                                    $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                                                } else if (!empty($anexo->idOrcServicoEscopoItens)) {
                                                    $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                                                }
                                                foreach ($anexos as $v) {
                                                    $novoAnexo = clone $v;
                                                    $novoAnexo->idAnexo = null;
                                                    $novoAnexo->idOrcServicoEscopoItens = $idOrcServItem;
                                                    $novoAnexo->idOrcamentos_item = $this->input->post('id_orc_item')[$x];
                                                    $novoAnexo->idOsSub = null;
                                                    $novoAnexo->idOs = null;
                                                    $novoAnexo->idCatItem = null;
                                                    $novoAnexo->statusAnexo = 1;
                                                }
                                                $this->peritagem_model->add("anexo_desenho", $novoAnexo, true);
                                            }
                                        }
                                    }
                                    $orc = $this->orcamentos_model->get_item_orc2($this->input->post('id_orc_item')[$x]);
                                    $this->peritagem_model->desativarEscoposOrcItem($this->input->post('id_orc_item')[$x], $idOrcServEscopo);
                                    $this->peritagem_model->ativarEscoposOrcItem($idOrcServEscopo);
                                }
                            }/* else{
                                $produto = $this->produtos_model->getById($this->input->post('idProdutos')[$x]);
                                $data3 = array(
                                    'nomeServicoEscopo'=> strtoupper('Checklist Especifico: '.$produto->pn),
                                    'idProduto'=> $this->input->post('idProdutos')[$x],
                                    'tipoServico'=> $this->input->post('tipo_prod')[$x]
                                );
                                $idEscopo = $this->peritagem_model->add("servico_escopo",$data3,true);
                                for($c = 0;$c<count($this->input->post($nameInputNovoProduto));$c++){
                                    if(!empty($this->input->post($nameInputNovoDescProd)[$c])){
                                        $data4 = array(
                                            'idProduto'=>(!empty($this->input->post($nameInputNovoProduto)[$c])?$this->input->post($nameInputNovoProduto)[$c]:null),
                                            'idServicoEscopo'=>$idEscopo,
                                            'descricaoServicoItens'=>strtoupper($this->input->post($nameInputNovoDescProd)[$c]),
                                            'idClasse'=>$this->input->post($nameInputNovoClasse)[$c]
                                        );                                        
                                        $this->peritagem_model->add("servico_escopo_itens",$data4,true);
                                    }                                
                                }
                                $escopoItens = $this->peritagem_model->getEscopoItensByIdEscopo($idEscopo);
                                $escopoOrc = $this->peritagem_model->getEscopoOrcByidEscopoAndIdOrcItem($idEscopo,$this->input->post('id_orc_item')[$x]);
                                if(!empty($escopoOrc)){
                                    $escopoOrcItens = $this->peritagem_model->getEscopoItensOrcByidEscopoAndIdOrcItem($escopoOrc->idOrcServicoEscopo);
                                    $verifyItem = false;
                                    foreach($escopoItens as $r){
                                        $verifyItem = false;
                                        foreach($escopoOrcItens as $b){
                                            if($b->idServicoEscopoItens == $r->idServicoEscopoItens){
                                                $verifyItem = true;
                                            }
                                        }
                                        if(!$verifyItem){
                                            $data5 = array(
                                                'idServicoEscopoItens'=>$r->idServicoEscopoItens,
                                                'idOrcServicoEscopo'=> $escopoOrc->idOrcServicoEscopo,
                                                'ativo'=>$r->ativo
                                            );
                                            $idOrcServItem = $this->peritagem_model->add("orc_servico_escopo_itens",$data5,true);
                                            if($r->idProduto){
                                                $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($r->idProduto);
                                                if(!empty($anexo)){
                                                    if(!empty($anexo->idOsSub)){
                                                        $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                                                    }else if(!empty($anexo->idOrcServicoEscopoItens)){
                                                        $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                                                    }
                                                    foreach($anexos as $v){
                                                        $novoAnexo = clone $v;
                                                        $novoAnexo->idAnexo = null;
                                                        $novoAnexo->idOrcServicoEscopoItens = $idOrcServItem;
                                                        $novoAnexo->idOrcamentos_item = $this->input->post('id_orc_item')[$x];
                                                        $novoAnexo->idOsSub = null;
                                                        $novoAnexo->idOs = null;
                                                        $novoAnexo->idCatItem = null;                                    
                                                        $novoAnexo->statusAnexo = 1;
                                                    }
                                                    $this->peritagem_model->add("anexo_desenho",$novoAnexo,true);
                                                }
                                            }
                                        }
                                    }
                                    $nameOrcEscopoItens = "idOrcServicoEscopoItens_".$this->input->post('id_orc_item')[$x];
                                    $nameValorItens = "valorOrcItem_".$this->input->post('id_orc_item')[$x];
                                    for($c = 0; $c<count($this->input->post($nameOrcEscopoItens));$c++){
                                        $valorOrcItem =str_replace(".","",$this->input->post($nameValorItens)[$c]);
                                        $valorOrcItem = str_replace(",",".",$valorOrcItem);
                                        $data7 = array("valorUnitario" => $valorOrcItem);
                                        $this->orcamentos_model->edit('orc_servico_escopo_itens',$data7,'idOrcServicoEscopoItens',$this->input->post($nameOrcEscopoItens)[$c]);
                                        
                                    }
    
    
                                    $idOrcServEscopo = $escopoOrc->idOrcServicoEscopo;
                                    $this->peritagem_model->desativarEscoposOrcItem($this->input->post('id_orc_item')[$x],$idOrcServEscopo);
                                    $this->peritagem_model->ativarEscoposOrcItem($idOrcServEscopo);
                                }else{
                                    
                                    $data = array(
                                        'idServicoEscopo'=>$idEscopo,
                                        'idOrcItem'=>$this->input->post('id_orc_item')[$x],
                                        'idStatusPeritagem'=>1
                                    );
                                    
                                    
                                    $idOrcServEscopo = $this->peritagem_model->add("orc_servico_escopo",$data,true);
                                    foreach($escopoItens as $r){
                                        $data6 = array(
                                          'idServicoEscopoItens'=>$r->idServicoEscopoItens,
                                          'idOrcServicoEscopo'=> $idOrcServEscopo
                                        );
                                        $idOrcServItem = $this->peritagem_model->add("orc_servico_escopo_itens",$data6,true);
                                        if($r->idProduto){
                                            $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($r->idProduto);
                                            if(!empty($anexo)){
                                                if(!empty($anexo->idOsSub)){
                                                    $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                                                }else if(!empty($anexo->idOrcServicoEscopoItens)){
                                                    $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                                                }
                                                foreach($anexos as $v){
                                                    $novoAnexo = clone $v;
                                                    $novoAnexo->idAnexo = null;
                                                    $novoAnexo->idOrcServicoEscopoItens = $idOrcServItem;
                                                    $novoAnexo->idOrcamentos_item = $this->input->post('id_orc_item')[$x];
                                                    $novoAnexo->idOsSub = null;
                                                    $novoAnexo->idOs = null;
                                                    $novoAnexo->idCatItem = null;                                    
                                                    $novoAnexo->statusAnexo = 1;
                                                }
                                                $this->peritagem_model->add("anexo_desenho",$novoAnexo,true);
                                            }
                                        }
                                    }
                                    
                                    $orc = $this->orcamentos_model->get_item_orc2($this->input->post('id_orc_item')[$x]);                                
                                }
                            } */


                            $controleEtapa = $this->producao_model->getControleEtapaByIdOrcamento_item($this->input->post('id_orc_item')[$x]);
                            if (!empty($controleEtapa)) {
                                $controleEtapa->quantidade = $this->input->post('qtd')[$x];
                                $this->producao_model->edit("controle_etapa", $controleEtapa, "idControleEtapa", $controleEtapa->idControleEtapa);
                            }
                        } else if ($this->input->post('orc')[$x] == 'fab') {
                            if (!empty($this->input->post('idChecklist')[$x])) {
                                //echo '<script>console.log("test1k")</script>';
                                //echo '<script>console.log('.$this->input->post('idChecklist')[$x].')</script>';
                                $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($this->input->post('id_orc_item')[$x]);
                                $data2 = array_merge($data2, array('idCatalogo' => $this->input->post('idChecklist')[$x]));/*
                                $novoInputCatalogoIdProduto = "novoCatalogoIdProduto_".$this->input->post('contador')[$x];
                                $novoInputCatalogoPN = "novoCatalogoPN_".$this->input->post('contador')[$x];
                                $novoInputCatalogoQtd= "novoCatalogoQtd_".$this->input->post('contador')[$x];
    
                                if(!empty($this->input->post($novoInputCatalogoIdProduto))){
                                    for($c=0;$c<count($this->input->post($novoInputCatalogoIdProduto));$c++){
                                        if(!empty($this->input->post($novoInputCatalogoIdProduto)[$c])){
                                            $data8 = array(
                                                "idProduto"=>$this->input->post($novoInputCatalogoIdProduto)[$c],
                                                "quantidade"=>$this->input->post($novoInputCatalogoQtd)[$c],
                                                "idCatalogoProduto"=>$this->input->post('idChecklist')[$x],
                                                "tipoProd"=>'pec',
                                                "data_cadastro"=>date('Y-m-d H:i:s'),
                                                "idUsuario"=>$this->session->userdata('idUsuarios'),
                                                "ativo"=>1
                                            );
                                            $this->orcamentos_model->add('catalogo_produto_itens', $data8, true);
                                        }                                    
                                    }
                                }               */
                                if (!empty($escopo)) {
                                    $dataAtivo = array("ativo" => 0);
                                    $this->orcamentos_model->edit('orc_servico_escopo', $dataAtivo, 'idOrcServicoEscopo', $escopo->idOrcServicoEscopo);
                                }
                            }
                            /*else{
                                $produto = $this->produtos_model->getById( $this->input->post('idProdutos')[$x]);
                                $data8 = array(
                                    "idProduto"=> $this->input->post('idProdutos')[$x],
                                    'descricaoCatalogo'=>$produto->pn,
                                    'data_cadastro'=>date('Y-m-d H:i:s'),
                                    "idUsuario"=>$this->session->userdata('idUsuarios'),
                                    "ativo"=>1
                                );
                                $data4 = $this->orcamentos_model->add('catalogo_produto', $data8, true);
                                $data2= array_merge($data2, array('idCatalogo'=>$data4));
                                $novoInputCatalogoIdProduto = "novoCatalogoIdProduto_".$this->input->post('contador')[$x];
                                $novoInputCatalogoPN = "novoCatalogoPN_".$this->input->post('contador')[$x];
                                $novoInputCatalogoQtd= "novoCatalogoQtd_".$this->input->post('contador')[$x];
    
                                if(!empty($this->input->post($novoInputCatalogoIdProduto))){
                                    for($c=0;$c<count($this->input->post($novoInputCatalogoIdProduto));$c++){
                                        if(!empty($this->input->post($novoInputCatalogoIdProduto)[$c])){
                                            $data9 = array(
                                                "idProduto"=>$this->input->post($novoInputCatalogoIdProduto)[$c],
                                                "quantidade"=>$this->input->post($novoInputCatalogoQtd)[$c],
                                                "idCatalogoProduto"=>$data4,
                                                "tipoProd"=>'pec',
                                                "data_cadastro"=>date('Y-m-d H:i:s'),
                                                "idUsuario"=>$this->session->userdata('idUsuarios'),
                                                "ativo"=>1
                                            );
                                            $idCatItem = $this->orcamentos_model->add('catalogo_produto_itens', $data9, true);
                                            
                                            $anexo = $this->peritagem_model->getAnexoByIdProdutoLIMIT1($this->input->post($novoInputCatalogoIdProduto)[$c]);
                                            if(!empty($anexo)){
                                                if(!empty($anexo->idOsSub)){
                                                    $anexos = $this->peritagem_model->getAnexoByIdOsSub($anexo->idOsSub);
                                                }else if(!empty($anexo->idOrcServicoEscopoItens)){
                                                    $anexos = $this->peritagem_model->getAnexoByIdOrcServItem($anexo->idOrcServicoEscopoItens);
                                                }
                                                foreach($anexos as $v){
                                                    $novoAnexo = clone $v;
                                                    $novoAnexo->idAnexo = null;
                                                    $novoAnexo->idOrcServicoEscopoItens = null;
                                                    $novoAnexo->idOrcamentos_item = $this->input->post('id_orc_item')[$x];
                                                    $novoAnexo->idOsSub = null;
                                                    $novoAnexo->idOs = null;
                                                    $novoAnexo->idCatItem = $idCatItem;                                    
                                                    $novoAnexo->statusAnexo = 1;
                                                }
                                                $this->peritagem_model->add("anexo_desenho",$novoAnexo,true);
                                            }
                                        }
                                    }
                                }
                            } */
                        }
                    }else{
                        $data2 = array(
                            'descricao_item' => $this->input->post('descricao_item')[$x],
                            'idProdutos' => $this->input->post('idProdutos')[$x],
                            'tag' => $this->input->post('tag')[$x],
                            'desconto' => $desconto_,
                            'val_ipi' => $val_ipi_,
                            'qtd' => $this->input->post('qtd')[$x],
                            'val_unit' => $valorunita1,
                            'frete' => $frete,
                            'prazo' => $this->input->post('prazo')[$x],
                            'subtot' => $subtotal_,
                            'detalhe' => $this->input->post('detalhe')[$x],
                            'valor_total' => $vlr_total_,
                            'idOrcamentos' =>  $this->input->post('idOrcamentos'),
                            'tipoOrc' => $this->input->post('orc')[$x],
                            'data_previsao_chegada' => $dataChegada,
                            //'statusDesenho' =>$statusDesenho,
                            'tipoProd' => $this->input->post('tipo_prod')[$x],
                            'idCatalogo' => NULL
                        );
                        $this->orcamentos_model->edit('orcamento_item', $data2, 'idOrcamento_item', $this->input->post('id_orc_item')[$x]);
                    }   
                    if ($this->input->post('id_orc_item')[$x] <> 0) {
                        $this->orcamentos_model->edit('orcamento_item', $data2, 'idOrcamento_item', $this->input->post('id_orc_item')[$x]);
                    } else {
                        $this->orcamentos_model->add('orcamento_item', $data2, true);
                    }


                    $subOs = $this->os_model->getSubOsByIdOrcamentoItemByPosicao($this->input->post('id_orc_item')[$x], 0);
                    if (!empty($subOs)) {
                        $data = array(
                            "descricaoOsSub" => $this->input->post('descricao_item')[$x],
                            "idProduto_sub" => $this->input->post('idProdutos')[$x],
                            "idProduto_master" => $this->input->post('idProdutos')[$x]
                        );
                        foreach ($subOs as $c) {
                            $this->os_model->edit('os_sub', $data, "idOsSub", $c->idOsSub);
                        }
                        if ($subOs[0]->idProduto_master != $this->input->post('idProdutos')[$x]) {
                            $subOs = $this->os_model->getSubOsByIdOrcamentoItem($this->input->post('id_orc_item')[$x]);
                            $data = array(
                                "idProduto_master" => $this->input->post('idProdutos')[$x]
                            );
                            $this->os_model->edit('os_sub', $data, "idOsSub", $subOs[0]->idOs);
                        }
                    }
                }
                $this->session->set_flashdata('success', 'Orcamento editado com sucesso!');
                redirect(base_url() . 'index.php/orcamentos/editar/' . $this->input->post('idOrcamentos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }






        $this->load->model('producao_model');

        $this->load->model('peritagem_model');

        $this->data['view'] = 'orcamentos/editarOrcamento';
        $this->load->view('tema/topo', $this->data);
    }


    function excluir_item()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir item do orcamento.');
            redirect(base_url());
        }


        $id =  $this->input->post('id');
        $orc_item =  $this->input->post('orc_item');
        if ($id == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar excluir item.');
            redirect(base_url() . 'index.php/orcamentos');
        }


        if ($this->orcamentos_model->getitemos($id) == false) {
            $this->orcamentos_model->delete('orcamento_item', 'idOrcamento_item', $id);

            $linha_orcitem = $this->orcamentos_model->get_number_linhas('orcamento_item', 'idOrcamentos = ' . $this->input->post('orc_item'), '*');

            $linha_orcirep = $this->orcamentos_model->get_number_linhas('orcamento', 'idOrcamentos = ' . $this->input->post('orc_item') . ' and status_orc = 1', '*');

            $linha_os = $this->orcamentos_model->get_number_linhas('os', 'idOrcamentos = ' . $this->input->post('orc_item'), 'DISTINCT(`idOrcamento_item`)');

            /*'status_orc' => 1,
                'idstatusOrcamento' => 12
            */

            if (count($linha_os) == count($linha_orcitem)) {
                $data = array(
                    'idstatusOrcamento' => 4
                );
            } else if (count($linha_os) == 0 && count($linha_orcirep) > 0) {
                $data = array(
                    'idstatusOrcamento' => 12
                );
            } else if (count($linha_os) == 0 && count($linha_orcirep) == 0) {
                $data = array(
                    'idstatusOrcamento' => 11
                );
            } else {
                $data = array(
                    'idstatusOrcamento' => 13
                );
            }

            $this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $this->input->post('orc_item'));


            $this->session->set_flashdata('success', 'Item excluido com sucesso!');
            redirect(base_url() . 'index.php/orcamentos/editar/' . $orc_item);
        } else {
            $this->session->set_flashdata('error', 'Item possui OS aberto.');
            redirect(base_url() . 'index.php/orcamentos/editar/' . $orc_item);
        }
    }
    public function visualizar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar Orcamentos.');
            redirect(base_url());
        }




        $this->data['custom_error'] = '';


        $this->data['result'] = $this->orcamentos_model->getById2('orcamento', $this->uri->segment(3));

        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente($this->data['result']->idEmitente);
        $this->data['dados_clientes'] = $this->orcamentos_model->getCliente($this->data['result']->idClientes);
        $this->data['dados_solicitante'] = $this->orcamentos_model->getSolici($this->data['result']->idSolicitante);
        $this->data['dados_vendedor'] = $this->orcamentos_model->getVendedor($this->data['result']->idVendedor);
        $this->data['dados_gerente'] = $this->orcamentos_model->getGerente($this->data['result']->idGerente);
        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($this->data['result']->idNatOperacao);

        $this->data['itens_orcamento'] = $this->orcamentos_model->getorc_itemB($this->data['result']->idOrcamentos);



        $this->data['view'] = 'orcamentos/visualizar';
        $this->load->view('tema/topo', $this->data);
    }
    public function aprovar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'APOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para aprovar Orcamentos.');
            redirect(base_url());
        }
        $this->load->model('os_model');

        $this->data['custom_error'] = '';


        $this->data['result'] = $this->orcamentos_model->getById('orcamento', $this->uri->segment(3));

        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente($this->data['result']->idEmitente);
        $this->data['dados_clientes'] = $this->orcamentos_model->getCliente($this->data['result']->idClientes);
        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($this->data['result']->idNatOperacao);
        $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
        $this->data['itens_orcamento'] = $this->orcamentos_model->getorc_itemB($this->uri->segment(3));

        //var_dump($this->data['itens_orcamento']); exit;

        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
        $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
        $this->data['status_os'] = $this->orcamentos_model->getStatusOs();

        //inserindo os




        $this->data['view'] = 'orcamentos/aprovar';
        $this->load->view('tema/topo', $this->data);
    }
    public function aprovar_os()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'APOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para aprovar Orcamentos.');
            redirect(base_url());
        }

        //$this->data['result'] = $this->orcamentos_model->getById('orcamento',$this->input->post('idOrcamentos'));

        //var_dump($this->input->post('item')[0]);exit;

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $contador = count($this->input->post('item'));

        $this->load->model('clientes_model');
        $this->load->model('os_model');
        $this->load->model('peritagem_model');
        $this->load->model('producao_model');
        $this->load->model('produtos_model');
        if ($this->input->post('item')[0] > 0) {
            for ($x = 0; $x < $contador; $x++) {
                $itemOrc = $this->orcamentos_model->getitem($this->input->post('item')[$x]);
                $possuiOs = $this->orcamentos_model->get2("os", " * ", "idOrcamento_item = " . $this->input->post('item')[$x], 5, 0, true);

                if (!empty($possuiOs) && $itemOrc->status_item == 2) {

                    redirect('os?idOrcamentos=' . $this->input->post('idOrcamentos') . $possuiOs->idStatusOs);
                    return;
                }
                if ($itemOrc->tipoOrc == 'serv') {
                    $OrcEscopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($this->input->post('item')[$x]);
                    if (empty($OrcEscopo) || $OrcEscopo->idStatusPeritagem != 4) {
                        $this->session->set_flashdata('error', 'Não é permitido a aprovação de orçamentos com o escopo em aberto.');
                        redirect(base_url() . 'index.php/orcamentos/editar/' . $this->input->post('idOrcamentos'));
                        return;
                    }
                }
            }

            for ($x = 0; $x < $contador; $x++) {

                $valor_item = $this->orcamentos_model->getitem($this->input->post('item')[$x]);

                $possuiOs2 = $this->orcamentos_model->get2("os", " * ", "idOrcamento_item = " . $this->input->post('item')[$x], 1, 0, true);

                $data_entrega = date('Y-m-d', strtotime('+' . $valor_item->prazo . ' days', strtotime(date('Y-m-d'))));

                $os = $this->orcamentos_model->get('orcamento', 'idOrcamentos', 'orcamento.idOrcamentos = ' . $this->input->post('idOrcamentos'), 1, 0, true);
                if (empty($os->idSimplexCliente)) {       /*                 
                    $resposta2 = json_decode($this->simplexCadastroCliente($os->nomeCliente,$os->cep,$os->documento));
                    $data2 = array("idSimplexCliente"=>$resposta2->response->id);
                    $os->idSimplexCliente = $resposta2->response->id;
                    $this->clientes_model->edit('clientes', $data2, 'idClientes', $os->idClientes);*/
                    //echo("<script>console.log('foi?');</script>");
                    //echo $os;
                }

                /**/
                $desconto_ = str_replace(".", "", $valor_item->desconto);
                $desconto_ = str_replace(",", ".", $desconto_);

                $val_ipi_ = str_replace(".", "", $valor_item->val_ipi);
                $val_ipi_ = str_replace(",", ".", $val_ipi_);

                $valorunita = str_replace(".", "", $valor_item->val_unit);
                $valorunita = str_replace(",", ".", $valorunita);

                $subtotal_ = str_replace(".", "", $valor_item->subtot);
                $subtotal_ = str_replace(",", ".", $subtotal_);

                $dataAbertura = date('Y-m-d H:i:s');


                $data2 = array(
                    'idOrcamento_item' => $this->input->post('item')[$x],
                    'val_unit_os' => $valor_item->val_unit,
                    'desconto_os' => $valor_item->desconto,
                    'qtd_os' => $valor_item->qtd,
                    'subtot_os' => $valor_item->subtot,
                    'val_ipi_os' => $valor_item->val_ipi,
                    'data_entrega' => $data_entrega,
                    'idStatusOs' => $this->input->post('idStatusOs'),
                    'data_abertura' => date('Y-m-d H:i:s'),
                    'data_abertura_real' => date('Y-m-d H:i:s'),
                    'unid_execucao' => $this->input->post('unid_execucao'),
                    'unid_faturamento' => $this->input->post('unid_faturamento'),
                    'id_tipo' => $this->input->post('id_tipo'),
                    'contrato' => $this->input->post('contrato'),
                    'idOrcamentos' => $this->input->post('idOrcamentos'),
                    'numpedido_os' => $this->input->post('num_pedido')
                );



                $itemOrc = $this->orcamentos_model->getitem($this->input->post('item')[$x]);
                if (!empty($possuiOs2)) {
                    $this->orcamentos_model->edit("os", $data2, "idOs", $possuiOs2->idOs);
                    $nova_os = $possuiOs2->idOs;
                } else {
                    $nova_os =     $this->orcamentos_model->add('os', $data2, true);
                }

                if($itemOrc->tipoProd == "serv"){
                    $data3 = array(
                        "fechadoPCP"=>1                        
                    );
                    $this->orcamentos_model->edit("os", $data3, "idOs", $nova_os);
                }
                $objOs = $this->os_model->getByid_table($nova_os, 'os', 'idOs');
                $this->os_model->insertOSHis($objOs);

                $OrcEscopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($this->input->post('item')[$x]);
                if ($this->input->post('unid_execucao') == 2) {
                    $classe = 2;
                } else {
                    $classe = 1;
                }
                $subOs2 = $this->orcamentos_model->getSubOsbyidOs($nova_os);
                if(empty($subOs2)){
                    $dataSubOs = array(
                        "idOs" => $nova_os,
                        "idProduto_master" => $itemOrc->idProdutos,
                        "idProduto_sub" => $itemOrc->idProdutos,
                        "posicao" => 0,
                        "data_insert" => date('Y-m-d H:i:s'),
                        "quantidade" => $valor_item->qtd,
                        "idClasse" => $classe,
                        "ativo" => 1,
                        "descricaoOsSub" => $itemOrc->descricao_item
                    );
                    $this->orcamentos_model->add("os_sub", $dataSubOs);
                }
                
                $anexoDesenho = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao($itemOrc->idOrcamento_item);

                foreach ($anexoDesenho as $jk) {
                    $dataAnexo = array("idOs" => $nova_os);
                    $this->orcamentos_model->edit("anexo_desenho", $dataAnexo, "idAnexo", $jk->idAnexo);
                }
                
                if ($itemOrc->tipoOrc == 'serv') {
                    if (!empty($OrcEscopo)) {
                        $orcEscopoItens = $this->peritagem_model->itensPeritagemSelected($OrcEscopo->idOrcServicoEscopo);
                        foreach ($orcEscopoItens as $r) {
                            $subOs = $this->orcamentos_model->getSubOsbyidOs($nova_os);
                            //if($r->idClasse == 2){                        
                            $dataSubOs = array(
                                "idOs" => $nova_os,
                                "idProduto_master" => $itemOrc->idProdutos,
                                "idProduto_sub" => $r->idProduto,
                                "idOrcServicoEscopoItens" => $r->idOrcServicoEscopoItens,
                                "posicao" => count($subOs),
                                "data_insert" => date('Y-m-d H:i:s'),
                                "quantidade" => $r->quantidade,
                                "idClasse" => $r->idClasse,
                                "ativo" => 1,
                                "descricaoOsSub" => $r->descricaoServicoItens
                            );
                            $idSubOs = $this->orcamentos_model->add("os_sub", $dataSubOs, true);
                            //}
                            $anexoDesenho = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao2($r->idOrcServicoEscopoItens, $itemOrc->idOrcamento_item);
                            $dataOs = array('statusDesenho' => 3);
                            $this->orcamentos_model->edit("os", $dataOs, "idOs", $nova_os);
                            foreach ($anexoDesenho as $jk) {
                                $dataAnexo = array("idOs" => $nova_os, "idOsSub" => $idSubOs);
                                $this->orcamentos_model->edit("anexo_desenho", $dataAnexo, "idAnexo", $jk->idAnexo);
                            }
                            if (!empty($r->idProduto)) {
                                $ultimaSubOs = $this->os_model->getSubOsByIdProduto($r->idProduto);
                                if (!empty($ultimaSubOs)) {
                                    $listaMateriais = $this->os_model->getMaterialByIdOsSub($ultimaSubOs->idOsSub);
                                    echo json_encode($listaMateriais);

                                    if (count($listaMateriais) > 0) {
                                        foreach ($listaMateriais as $d) {
                                            $d->idDistribuir = null;
                                            $d->idOs = $nova_os;
                                            $d->idOsSub = $idSubOs;
                                            $d->idStatuscompras = 1;
                                            $d->usuario_cadastro = 51;
                                            $d->data_cadastro = date('Y-m-d H:i:s');
                                            $d->data_alteracao = null;
                                            $d->histo_alteracao = null;
                                            $d->notafiscal = null;
                                            $d->aprovacaoPCP = 0;
                                            $d->aprovacaoSUP = 0;
                                            $d->idUserAprovacao = null;
                                            $d->idUserAprovacaoSUP = null;
                                            $d->emailSup = 0;
                                            $d->emailPcp = 0;
                                            $d->entradaMp = 0;
                                            $d->finalizado = 0;
                                            $d->data_finalizado = null;

                                            $this->orcamentos_model->add("distribuir_os", $d);
                                        }
                                    }
                                }
                            }
                            $controle_etapa = $this->producao_model->getControleEtapaByIdOrcamento_item($this->input->post('item')[$x]);
                        }
                    }
                } else if ($itemOrc->tipoOrc == 'fab') {
                    if (!empty($itemOrc->idCatalogo)) {
                        $catalogo = $this->peritagem_model->getCatalogoById($itemOrc->idCatalogo);
                        $catalogoitens = $this->peritagem_model->getCatalogoItensByIdCatalogo($catalogo->idCatalogoProduto);
                        foreach ($catalogoitens as $v) {
                            $subOs = $this->orcamentos_model->getSubOsbyidOs($nova_os);
                            //if($r->idClasse == 2){                        
                            $dataSubOs = array(
                                "idOs" => $nova_os,
                                "idProduto_master" => $itemOrc->idProdutos,
                                "idProduto_sub" => $v->idProduto,
                                "posicao" => count($subOs),
                                "data_insert" => date('Y-m-d H:i:s'),
                                "quantidade" => $v->quantidade * $valor_item->qtd,
                                "idClasse" => 2,
                                "ativo" => 1,
                                "descricaoOsSub" => $v->descricao
                            );
                            $idSubOs = $this->orcamentos_model->add("os_sub", $dataSubOs, true);
                            //}
                            $anexoDesenho = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao5($itemOrc->idOrcamento_item, $v->idCatalogoProdutoItens);

                            foreach ($anexoDesenho as $jk) {
                                $dataAnexo = array("idOs" => $nova_os, "idOsSub" => $idSubOs);
                                $this->orcamentos_model->edit("anexo_desenho", $dataAnexo, "idAnexo", $jk->idAnexo);
                            }
                            $ultimaSubOs = $this->os_model->getSubOsByIdProduto($v->idProduto);
                            if (!empty($ultimaSubOs)) {
                                $listaMateriais = $this->os_model->getMaterialByIdOsSub($ultimaSubOs->idOsSub);
                                //echo json_encode($listaMateriais);    
                                if (count($listaMateriais) > 0) {
                                    foreach ($listaMateriais as $d) {
                                        $d->idDistribuir = null;
                                        $d->idOs = $nova_os;
                                        $d->idOsSub = $idSubOs;
                                        $d->idStatuscompras = 1;
                                        $d->usuario_cadastro = 51;
                                        $d->data_cadastro = date('Y-m-d H:i:s');
                                        $d->data_alteracao = null;
                                        $d->histo_alteracao = null;
                                        $d->notafiscal = null;
                                        $d->aprovacaoPCP = 0;
                                        $d->aprovacaoSUP = 0;
                                        $d->idUserAprovacao = null;
                                        $d->idUserAprovacaoSUP = null;
                                        $d->emailSup = 0;
                                        $d->emailPcp = 0;
                                        $d->entradaMp = 0;
                                        $d->finalizado = 0;
                                        $d->data_finalizado = null;

                                        $this->orcamentos_model->add("distribuir_os", $d);
                                    }
                                }
                            }
                        }
                    } else {
                        $catalogo = $this->peritagem_model->getCatalogoAtivosByIdProduto2($itemOrc->idProdutos);
                        if (!empty($catalogo)) {
                            $catalogoitens = $this->peritagem_model->getCatalogoItensByIdCatalogo($catalogo->idCatalogoProduto);
                            foreach ($catalogoitens as $v) {
                                $subOs = $this->orcamentos_model->getSubOsbyidOs($nova_os);
                                //if($r->idClasse == 2){                        
                                $dataSubOs = array(
                                    "idOs" => $nova_os,
                                    "idProduto_master" => $itemOrc->idProdutos,
                                    "idProduto_sub" => $v->idProduto,
                                    "posicao" => count($subOs),
                                    "data_insert" => date('Y-m-d H:i:s'),
                                    "quantidade" => $v->quantidade * $valor_item->qtd,
                                    "idClasse" => 2,
                                    "ativo" => 1,
                                    "descricaoOsSub" => $v->descricao
                                );
                                $idSubOs = $this->orcamentos_model->add("os_sub", $dataSubOs, true);
                                //}
                                $anexoDesenho = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao5($itemOrc->idOrcamento_item, $v->idCatalogoProdutoItens);

                                foreach ($anexoDesenho as $jk) {
                                    $dataAnexo = array("idOs" => $nova_os, "idOsSub" => $idSubOs);
                                    $this->orcamentos_model->edit("anexo_desenho", $dataAnexo, "idAnexo", $jk->idAnexo);
                                }
                                $ultimaSubOs = $this->os_model->getSubOsByIdProduto($v->idProduto);
                                if (!empty($ultimaSubOs)) {
                                    $listaMateriais = $this->os_model->getMaterialByIdOsSub($ultimaSubOs->idOsSub);
                                    //echo json_encode($listaMateriais);    
                                    if (count($listaMateriais) > 0) {
                                        foreach ($listaMateriais as $d) {
                                            $d->idDistribuir = null;
                                            $d->idOs = $nova_os;
                                            $d->idOsSub = $idSubOs;
                                            $d->idStatuscompras = 1;
                                            $d->usuario_cadastro = 51;
                                            $d->data_cadastro = date('Y-m-d H:i:s');
                                            $d->data_alteracao = null;
                                            $d->histo_alteracao = null;
                                            $d->notafiscal = null;
                                            $d->aprovacaoPCP = 0;
                                            $d->aprovacaoSUP = 0;
                                            $d->idUserAprovacao = null;
                                            $d->idUserAprovacaoSUP = null;
                                            $d->emailSup = 0;
                                            $d->emailPcp = 0;
                                            $d->entradaMp = 0;
                                            $d->finalizado = 0;
                                            $d->data_finalizado = null;

                                            $this->orcamentos_model->add("distribuir_os", $d);
                                        }
                                    }
                                }
                            }
                        } else {
                            $produtos = $this->produtos_model->getById($itemOrc->idProdutos);
                            $dataCatalogo = array(
                                "idProduto" => $itemOrc->idProdutos,
                                "descricaoCatalogo" => $produtos->pn,
                                "tipoProd" => $itemOrc->tipoProd,
                                "data_cadastro" => date('Y-m-d H:i:s'),
                                "idUsuario" => $this->session->userdata('idUsuarios'),
                                "ativo" => 1
                            );
                            $idCatalogo = $this->orcamentos_model->add("catalogo_produto", $dataCatalogo, true);

                            $dataCatalogo = array(
                                "idCatalogo" => $idCatalogo,
                                "data_solicitar_desenho" => date('Y-m-d H:i:s')
                            );
                            $this->orcamentos_model->edit('orcamento_item', $dataCatalogo, 'idOrcamento_item', $itemOrc->idOrcamento_item);
                        }
                    }
                }
                if ($itemOrc->tipoOrc == 'fab') {
                    $data3 = array("statusDesenho" => 1);
                    echo json_encode($itemOrc);
                    $this->solicitardesenho($itemOrc->idOrcamento_item);
                    $this->orcamentos_model->edit('orcamento_item', $data3, 'idOrcamento_item', $itemOrc->idOrcamento_item);
                }
                $data3 = array("status_item" => 2);
                $this->orcamentos_model->edit('orcamento_item', $data3, 'idOrcamento_item', $itemOrc->idOrcamento_item);
            }
            $linha_orcitem = $this->orcamentos_model->get_number_linhas('orcamento_item', 'idOrcamentos = ' . $this->input->post('idOrcamentos'), '*');

            $linha_orcirep = $this->orcamentos_model->get_number_linhas('orcamento', 'idOrcamentos = ' . $this->input->post('idOrcamentos') . ' and status_orc = 1', '*');

            $linha_os = $this->orcamentos_model->get_number_linhas('os', 'idOrcamentos = ' . $this->input->post('idOrcamentos'), 'DISTINCT(`idOrcamento_item`)');



            if (count($linha_os) == count($linha_orcitem)) {
                $data = array(

                    'idstatusOrcamento' => 4
                );
            } elseif (count($linha_os) == 0 && count($linha_orcirep) > 0) {
                $data = array(

                    'idstatusOrcamento' => 12
                );
            } elseif (count($linha_os) == 0 && count($linha_orcirep) == 0) {
                $data = array(

                    'idstatusOrcamento' => 11
                );
            } else {
                $data = array(

                    'idstatusOrcamento' => 13
                );
            }


            $this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $this->input->post('idOrcamentos'));
            //return; 
            $this->session->set_flashdata('success', 'OS cadastrada com sucesso.');
            redirect('os?idOrcamentos=' . $this->input->post('idOrcamentos'));
        } else {
            $this->session->set_flashdata('error', 'Marque um item!');
            redirect(base_url() . 'index.php/orcamentos/aprovar/' . $this->input->post('idOrcamentos'));
        }
    }
    public function orcCustom()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar orçamento.');
            redirect(base_url());
        }

        $dataInicial = $this->input->get('dataInicial');
        if ($dataInicial == '') {
            $dataimpri = date("d/m/Y");
        } else {
            $dataimpri =  $dataInicial;
        }

        $idOrcamentos = $this->input->get('idOrcamentos');

        $data['result'] = $this->orcamentos_model->orcCustom2($dataimpri, $idOrcamentos);


        /* $data['dados_emitente'] = $this->orcamentos_model->getEmitente($data['result']->idEmitente);
		$data['dados_clientes'] = $this->orcamentos_model->getCliente($data['result']->idClientes);
		$data['dados_vendedor'] = $this->orcamentos_model->getVendedor($data['result']->idVendedor);
        $data['dados_gerente'] = $this->orcamentos_model->getGerente($data['result']->idGerente);
        $data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($data['result']->idNatOperacao);
        */
        //$data['itens_orcamento'] = $this->orcamentos_model->getorc_item($data['result']->idOrcamentos);


        $this->load->helper('mpdf');
        echo $html = $this->load->view('orcamentos/imprimir/imprimirOrc', $data, true);

        //pdf_create($html, 'Orcamento_'.$idOrcamentos, TRUE);
        //pdf_create($html, 'Orcamento_'.$idOrcamentos, TRUE);


        /*$pagina = $this->load->view('orcamentos/imprimir/imprimirOrc',$data,true);
	    $this->load->helper('mpdf');
		
	    $arquivo = 'Orcamento_'.$idOrcamentos;

		$mpdf = new mPDF();
		$mpdf->WriteHTML($pagina);

		$mpdf->Output($arquivo, 'I');*/
    }
    function autoCompleteSolicitante()
    {
        //echo $id = $this->uri->segment(3);
        $id = $_REQUEST['id'];

        // $id  = $this->input->post('id');
        //$were = 'clientes.idClientes = '.$this->uri->segment(3);
        $were = 'clientes.idClientes = ' . $id;
        $c =  $this->orcamentos_model->getsolicitante('clientes', $were);


        echo json_encode($c);
    }
    function calculartotais()
    {
        // $id = $this->uri->segment(3);
        //$id = $_REQUEST['id'];
        $valorunit = $this->input->post('valorunit');
        $desconto = $this->input->post('desconto');
        $valoripi = $this->input->post('valoripi');
        $quant = $this->input->post('quant');



        $total1 = $valorunit * $quant;
        $total2 = $total1 * $valoripi / 100;
        $total3 = ($total1 + $total2) - $desconto;

        echo json_encode(array("subtot" => $total1, "vlr_total" => $total3, "total1" => $total1, "total2" => $total2, "desconto" => $desconto));
        /*echo json_encode(array("subtot" => number_format($total1, 2, ',', '.'), "vlr_total" => number_format($total3, 2, ',', '.'), "total1" => number_format($total1, 2, ',', '.'), "total2" => number_format($total2, 2, ',', '.'), "desconto" => number_format($desconto, 2, ',', '.')));
		
		*/
    }
    function excluir_os()
    {
        $this->load->model('os_model');
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir OS');
            redirect(base_url());
        }



        $data = array(
            'status_orc' => 0
        );
        $id_os = $this->input->post('id_os');
        $idOrc = $this->input->post('idOrc');
        if ($idOrc == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar excluir OS.');
            redirect(base_url() . 'index.php/orcamentos/gerenciar');
        }

        if ($id_os == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar excluir OS.');
            redirect(base_url() . 'index.php/orcamentos/aprovar/' . $idOrc);
        }
        $objOrcItem = $this->os_model->getOrcamentoItemByIdOs($id_os);


        //de excluir verificar se esta em produçao , se ja comprou item
        $vari = $this->orcamentos_model->get_number_linhas('distribuir_os', 'idOs = ' . $id_os, '');

        if (count($vari) == 0) {
            if ($this->orcamentos_model->delete('os', 'idOs', $id_os) == TRUE) {
                if(!empty($objOrcItem)){
                    $dataItem = array(
                        "status_item"=>0
                    );
                    $this->orcamentos_model->edit("orcamento_item",$dataItem,"idOrcamento_item",$objOrcItem->idOrcamento_item);
                }
                //update no orçamento
                $linha_orcitem = $this->orcamentos_model->get_number_linhas('orcamento_item', 'idOrcamentos = ' . $this->input->post('idOrc'), '*');

                $linha_orcirep = $this->orcamentos_model->get_number_linhas('orcamento', 'idOrcamentos = ' . $this->input->post('idOrc') . ' and status_orc = 1', '*');

                $linha_os = $this->orcamentos_model->get_number_linhas('os', 'idOrcamentos = ' . $this->input->post('idOrc'), 'DISTINCT(`idOrcamento_item`)');

                /*'status_orc' => 1,
                        'idstatusOrcamento' => 12
                */

                if (count($linha_os) == count($linha_orcitem)) {
                    $data = array(
                        'idstatusOrcamento' => 4
                    );
                } else if (count($linha_os) == 0 && count($linha_orcirep) > 0) {
                    $data = array(
                        'idstatusOrcamento' => 12
                    );
                } else if (count($linha_os) == 0 && count($linha_orcirep) == 0) {
                    $data = array(
                        'idstatusOrcamento' => 11
                    );
                } else {
                    $data = array(
                        'idstatusOrcamento' => 13
                    );
                }

                $this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $this->input->post('idOrc'));


                $this->session->set_flashdata('success', 'OS excluida com sucesso!');
                redirect(base_url() . 'index.php/orcamentos/aprovar/' . $idOrc);
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao deletar!');
                redirect(base_url() . 'index.php/orcamentos/aprovar/' . $idOrc);
            }
        } else {
            $this->session->set_flashdata('error', 'Essa OS tem item de compra inserida nela, nao pode apagar.!');
            redirect(base_url() . 'index.php/orcamentos/aprovar/' . $idOrc);
        }
    }


    function excluir()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir Orcamentos');
            redirect(base_url());
        }

        $this->load->model('producao_model');
        if ($this->input->post('idorc') <> '') {
            $idorc = $this->input->post('idorc');
            $texto = 'desativado';
            //verifica se tem algum item aprovado
            if ($this->orcamentos_model->getorc_os($idorc) == true) {
                $this->session->set_flashdata('error', 'Orçamento ja possui item aprovado.');
                redirect(base_url() . 'index.php/orcamentos/gerenciar/');
            }


            if ($this->input->post('idMotivo') == null) {

                $this->session->set_flashdata('error', 'Escolha um motivo.');
                redirect(base_url() . 'index.php/orcamentos/gerenciar/');
            }
            $data = array(

                'idMotivo' => $this->input->post('idMotivo'),
                'status_orc' => 1,
                'idstatusOrcamento' => 12
            );
        } else {
            $texto = 'reativado';
            $data = array(


                'status_orc' => 0,
                'idstatusOrcamento' => 11
            );
            $idorc = $this->input->post('idorc2');
        }

        if ($idorc == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar excluir Orcamento.');
            redirect(base_url() . 'index.php/orcamentos/gerenciar/');
        }
        $confirm = $this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $idorc);


        if ($confirm == TRUE) {
            $controleEtapas = $this->producao_model->getControleByIdOrcamento($idorc);
            foreach ($controleEtapas as $h) {
                $data = array(
                    "idStatusEtapaServico" => 13
                );
                $this->producao_model->edit("controle_etapa", $data, "idControleEtapa", $h->idControleEtapa);
                $this->producao_model->edit("controle_etapa_subitem", $data, "idControleEtapa", $h->idControleEtapa);
            }
            $this->session->set_flashdata('success', 'Orcamento ' . $texto . ' com sucesso!');
            redirect(base_url() . 'index.php/orcamentos/gerenciar/');
        } else {
            $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
        }
    }

    public function autoCompleteProduto()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompleteProduto($q);
        }
    }

    public function autoCompleteCliente()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompleteCliente($q);
        }
    }

    public function autoCompleteCliente2()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompleteCliente2($q);
        }
    }
    public function autoCompletePN()
    {

        if (isset($_GET['term'])) {
            //converte tudo pra maiusculo
            $q = strtoupper($_GET['term']);
            //retira -/.|;,
            $pn = str_replace("-", "", $q);
            $pn = str_replace("/", "", $pn);
            $pn = str_replace(",", "", $pn);
            $pn = str_replace("|", "", $pn);
            $pn = str_replace(";", "", $pn);
            $pn = str_replace(" ", "", $pn);
            $this->orcamentos_model->autoCompletePN($pn);
        }
    }
    public function autoCompletePN_2()
    {

        if (isset($_GET['term'])) {
            //converte tudo pra maiusculo
            $q = strtoupper($_GET['term']);
            //retira -/.|;,
            $pn = str_replace("-", "", $q);
            $pn = str_replace("/", "", $pn);
            $pn = str_replace(",", "", $pn);
            $pn = str_replace("|", "", $pn);
            $pn = str_replace(";", "", $pn);
            $pn = str_replace(" ", "", $pn);
            $this->orcamentos_model->autoCompletePN2($pn);
        }
    }
    public function autoCompletePN2()
    {

        if (isset($_GET['pn2'])) {
            //converte tudo pra maiusculo
            $q = strtoupper($_GET['pn2']);
            //retira -/.|;,
            $pn = str_replace("-", "", $q);
            $pn = str_replace("/", "", $pn);
            $pn = str_replace(",", "", $pn);
            $pn = str_replace("|", "", $pn);
            $pn = str_replace(";", "", $pn);
            $pn = str_replace(" ", "", $pn);
            $this->orcamentos_model->autoCompletePN($pn);
        }
    }

    public function autoCompleteUsuario()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompleteUsuario($q);
        }
    }



    public function adicionarProduto()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar orcamentos.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idProduto', 'Produto', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idOrcamentosProduto', 'Orcamentos', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            echo json_encode(array('result' => false));
        } else {

            $preco = $this->input->post('preco');
            $quantidade = $this->input->post('quantidade');
            $subtotal = $preco * $quantidade;
            $produto = $this->input->post('idProduto');
            $data = array(
                'quantidade' => $quantidade,
                'subTotal' => $subtotal,
                'produtos_id' => $produto,
                'orcamentos_id' => $this->input->post('idOrcamentosProduto'),
            );

            if ($this->orcamentos_model->add('itens_de_orcamentos', $data) == true) {
                $sql = "UPDATE produtos set estoque = estoque - ? WHERE idProdutos = ?";
                $this->db->query($sql, array($quantidade, $produto));

                echo json_encode(array('result' => true));
            } else {
                echo json_encode(array('result' => false));
            }
        }
    }

    function excluirProduto()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Orcamentos');
            redirect(base_url());
        }

        $ID = $this->input->post('idProduto');
        if ($this->orcamentos_model->delete('itens_de_orcamento', 'idItens', $ID) == true) {

            $quantidade = $this->input->post('quantidade');
            $produto = $this->input->post('produto');


            $sql = "UPDATE produtos set estoque = estoque + ? WHERE idProdutos = ?";

            $this->db->query($sql, array($quantidade, $produto));

            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }



    public function faturar()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Orcamentos');
            redirect(base_url());
        }

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
                'idClientes' => $this->input->post('clientes_id'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $recebimento,
                'baixado' => $this->input->post('recebido'),
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo')
            );

            if ($this->orcamentos_model->add('lancamentos', $data) == TRUE) {

                $venda = $this->input->post('orcamentos_id');

                $this->db->set('faturado', 1);
                $this->db->set('valorTotal', $this->input->post('valor'));
                $this->db->where('idOrcamentos', $venda);
                $this->db->update('orcamentos');

                $this->session->set_flashdata('success', 'Orcamento faturada com sucesso!');
                $json = array('result' =>  true);
                echo json_encode($json);
                die();
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar orcamento.');
                $json = array('result' =>  false);
                echo json_encode($json);
                die();
            }
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar orcamentos_id.');
        $json = array('result' =>  false);
        echo json_encode($json);
    }

    //API simplex

    public function simplexCriarOS($idSimplexCliente, $documento, $dataAbertura, $previsaoEntrega, $nova_os)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->item('urlSimplex') . '/post_ordem_execucao',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "local_producao": "1643030732052x547164845382303740",
            "empresa": "1643030479504x771112863746752500",
            "deletado": "no",
            "cnpj_emp": "' . $documento . '",
            "cnpj_fornecedor": "' . $idSimplexCliente . '",
            "cond_pagamento": "À vista",
            "contato": "",
            "data_emissao": "' . $dataAbertura . '",
            "email_fornecedor": "",
            "endereco_entrega": "",
            "fornecedor": "' . $idSimplexCliente . '",
            "solicitante": "",
            "oe_numero": "' . $nova_os . '",
            "previsao_entrega": "' . $previsaoEntrega . '"
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->config->item('tokenSimplex')
            ),
        ));

        $response = curl_exec($curl);
        echo ("<script>console.log('" . $response . "');</script>");
        $err_status = curl_error($curl);
        echo ("<script>console.log('" . $err_status . "');</script>");

        curl_close($curl);
        return $response;
    }
    public function simplexCriarItemOs($idSimplexOs, $quantidade, $descricaoItem, $valor, $pn = '')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->item('urlSimplex') . '/post_item_pc_oc_oe',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '
            {
                "local_producao": "1643030732052x547164845382303740",
                "empresa": "1643030479504x771112863746752500",
                "de_qual_oe": "' . $idSimplexOs . '",
                "descricao_item": "' . $descricaoItem . '",
                "item": "' . $pn . '",
                "nbr": "",
                "frete": "1",
                "grupo_orcamentario": "",
                "grupo_produto": "",
                "unidade_medida":"",
                "impostos": "1",
                "oc": "no",
                "oe": "yes",
                "quantidade": "' . $quantidade . '",
                "valor":"' . $valor . '"
              }
        ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->config->item('tokenSimplex')
            ),
        ));

        $response = curl_exec($curl);
        echo ("<script>console.log('" . $response . "');</script>");
        $err_status = curl_error($curl);
        echo ("<script>console.log('" . $err_status . "');</script>");

        curl_close($curl);
        return $response;
    }
    public function simplexCriarAtividade($idSimplexOs, $descricao, $idOs, $lista, $inicio, $entrega, $cor)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->item('urlSimplex') . '/post_kanban_atividades',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "de_qual_lista": "' . $lista . '",            
            "deletado":"no",
            "descricao_atividade": "' . $descricao . '",
            "local_producao": "1643030732052x547164845382303740",
            "empresa": "1643030479504x771112863746752500",
            "cor": "' . $cor . '",
            "horas_estimadas": "0",
            "prazo_previsto": "0",
            "prazo_realizado": "0",
            "produto_final": "",   
            "servico_controlado": "",   
            "termino_realizado": "0",   
            "inicio_previsto": "0",
            "inicio_realizado": "0",            
            "list_user": [],
            "titulo_atividade_oe": "' . $idSimplexOs . '",
            "inicio_previsto": "' . $inicio . '",
            "termino_previsto": "' . $entrega . '",
            "titulo_atividade": "' . $descricao . '",
            "titulo_atividade_oe_filter": "' . $idOs . '"
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->config->item('tokenSimplex')
            ),
        ));

        $response = curl_exec($curl);
        echo ("<script>console.log('" . $response . "');</script>");
        $err_status = curl_error($curl);
        echo ("<script>console.log('" . $err_status . "');</script>");

        curl_close($curl);
        return $response;
    }

    function simplexCadastroCliente($nomeCliente, $cep, $documento)
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->config->item('urlSimplex') . '/post_cadastro_fornecedores');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt(
            $curl,
            CURLOPT_POSTFIELDS,
            '{
            "local_producao": "1643030732052x547164845382303740",
            "empresa": "1643030479504x771112863746752500",
            "deletado":"no",
            "cnpj_cpf": "' . $documento . '",
            "contato": "",
            "email": "",
            "endereco": "' . $cep . '",
            "fornecedor_cliente": "' . $nomeCliente . '",
            "inscricao_estadual": ""}'
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->config->item('tokenSimplex')
        ));
        $response = curl_exec($curl);
        echo ("<script>console.log('" . $response . "');</script>");
        $err_status = curl_error($curl);
        echo ("<script>console.log('" . $err_status . "');</script>");

        curl_close($curl);
        //echo $response;
        return $response;
    }
    public function escopo()
    {
        $this->data["idOrçamentoItem"] = $this->uri->segment(3);
        $this->load->model('peritagem_model');
        $this->data["orcamentoItem"] = $this->orcamentos_model->getOrcItemDetailsById($this->data["idOrçamentoItem"]);
        $this->data["statusPeritagem"] = $this->peritagem_model->getStatusPeritagem();
        $this->data['typeClass'] = $this->peritagem_model->getTypeClass();
        if ($this->input->post('valueEscopo') == 'novo') {
            $this->data['view'] = 'orcamentos/escopo/escopoOrcamento';
            $this->load->view('tema/topo', $this->data);
            return;
        } else {
            $idEscopo = '';
            if (!empty($this->input->post('valueEscopo'))) {
                $idEscopo = $this->input->post('valueEscopo');
            }
            if (!empty($this->uri->segment(4))) {
                $idEscopo = $this->uri->segment(4);
            }
            $this->data['servicoEscopo'] = $this->peritagem_model->getEscopoById($idEscopo);
            $this->data['orcServicoEscopo'] = $this->peritagem_model->getEscopoOrcByidEscopoAndIdOrcItem($idEscopo, $this->data["idOrçamentoItem"]);
            if (!empty($this->data['orcServicoEscopo'])) {
                $this->data['orcServicoEscopoItens'] = $this->peritagem_model->itensPeritagemOrcamento($this->data['orcServicoEscopo']->idOrcServicoEscopo);
            }
            $this->data['servicoEscopoItens'] = $this->peritagem_model->getEscopoItensByIdEscopo($idEscopo);
            $this->data['view'] = 'orcamentos/escopo/escopoOrcamento';
            $this->load->view('tema/topo', $this->data);
        }
    }
    public function autoCompleteItemServico()
    {
        $this->load->model('peritagem_model');
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->peritagem_model->autoCompleteItemServico($q);
        }
    }
    public function escopoPrint()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar orçamento.');
            redirect(base_url());
        }
        /*
        $dataInicial = $this->input->get('dataInicial');
		if($dataInicial == ''){
			$dataimpri = date("d/m/Y");
		}
		else{
			$dataimpri =  $dataInicial;
		}*/
        $this->load->model('peritagem_model');
        $idOrcamentos = $this->uri->segment(3);
        $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($idOrcamentos);

        $data['itensEscopo'] = $this->peritagem_model->itensPeritagemSelected($escopo->idOrcServicoEscopo);
        $data['result'] = $this->orcamentos_model->orcItemCustom(null, $idOrcamentos);
        $data['descricoes'] =  $this->orcamentos_model->getOrcItemWithOs($idOrcamentos);

        $this->load->helper('mpdf');
        echo $html = $this->load->view('orcamentos/imprimir/imprimirOrcEscopo', $data, true);
    }
    public function escopoPrintTodos()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar orçamento.');
            redirect(base_url());
        }
        /*
        $dataInicial = $this->input->get('dataInicial');
		if($dataInicial == ''){
			$dataimpri = date("d/m/Y");
		}
		else{
			$dataimpri =  $dataInicial;
		}*/
        $this->load->model('peritagem_model');
        $idOrcamentos = $this->uri->segment(3);
        $escopo = $this->peritagem_model->getOrcEscopoActiveByidOrc($idOrcamentos);
        $escopo2 = array();
        if (empty($escopo)) {
            $this->session->set_flashdata('error', 'Esse orçamento não possuí escopo.');
            redirect(base_url() . "index.php/orcamentos/editar/" . $idOrcamentos);
        }
        foreach ($escopo as $r) {
            $r->itensEscopo = $this->peritagem_model->itensPeritagemSelected($r->idOrcServicoEscopo);
            $result = $this->orcamentos_model->orcItemCustom(null, $r->idOrcItem);
            //echo json_encode($result);
            //echo '</br>';
            //echo '</br>';
            //echo '</br>';
            $r =  (object)array_merge((array)$r, (array)$result[0]);
            $descricoes = $this->orcamentos_model->getOrcItemWithOs($r->idOrcItem);
            //echo json_encode($descricoes);
            //echo '</br>';
            //echo '</br>';
            //echo '</br>';
            $r =  (object)array_merge((array)$r, (array)$descricoes);
            //echo json_encode($r);
            //echo '</br>';
            //echo '</br>';
            //echo '</br>';
            array_push($escopo2, $r);
        }

        //echo json_encode($escopo2);
        //exit;
        $data['result'] = $this->orcamentos_model->orcCustom(null, $idOrcamentos);
        //$data['descricoes'] =  $this->orcamentos_model->getOrcItemWithOs($idOrcamentos);
        $data['escopo'] = $escopo2;
        $this->load->helper('mpdf');
        echo $html = $this->load->view('orcamentos/imprimir/imprimirOrcEscopoTodos', $data, true);
    }
    public function laudoPrint()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vPeritagem')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar orçamento.');
            redirect(base_url());
        }
        /*
        $dataInicial = $this->input->get('dataInicial');
		if($dataInicial == ''){
			$dataimpri = date("d/m/Y");
		}
		else{
			$dataimpri =  $dataInicial;
		}*/
        $this->load->model('peritagem_model');
        $idOrcamentos = $this->uri->segment(3);
        $data['itensLaudo'] = $this->peritagem_model->getLaudoFotograficoByIdOrcItem($idOrcamentos);
        $data['result'] = $this->orcamentos_model->orcItemCustom(null, $idOrcamentos);
        $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($idOrcamentos);
        $data['itensEscopo'] = $this->peritagem_model->itensPeritagemSelected($escopo->idOrcServicoEscopo);
        $data['descricoes'] =  $this->orcamentos_model->getOrcItemWithOs($idOrcamentos);





        $this->load->helper('mpdf');
        //echo $html = $this->load->view('orcamentos/imprimir/imprimirLaudo',$data,true);  
        echo $html = $this->load->view('orcamentos/imprimir/imprimirLaudo2', $data, true);
    }
    function send($to, $assunto = '', $msg = '')
    {
        $this->load->config('email');
        $this->load->library('email');

        $from = $this->config->item('smtp_user');
        if (!empty($assunto)) {
            $subject = $assunto;
        } else {
            $subject = $this->input->post('subject');
        }

        if (!empty($msg)) {
            $message = $msg;
        } else {
            $message = $this->input->post('message');
        }


        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        try {
            if ($this->email->send()) {
                echo 'Your Email has successfully been sent.';
            } else {
                //show_error($this->email->print_debugger());
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    function adicionaranexo()
    {
        $idOrc = $this->input->post('idOrc');
        $idOrcItem = $this->input->post('idOrcItem');
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
            $this->session->set_flashdata('error', 'Informe nome do arquivo!');
            redirect(base_url() . 'index.php/orcamentos/editar/' . $idOrc);
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
                'tipo' => 'DESENHO',
                'tamanho' => $tamanho,
                'extensao' => $extensao,
                'statusAnexo' => 1,
                'data_cadastro' => date('Y-m-d H:i:s'),
                'user_proprietario' => $this->session->userdata('idUsuarios'),
                'idOrcamentos_item' => $idOrcItem
            );

            if ($this->orcamentos_model->add('anexo_desenho', $data) == TRUE) {
                $data2 = array(
                    "idStatusDesenho" => 2
                );
                $this->session->set_flashdata('success', 'Arquivo adicionado com sucesso!');
                redirect(base_url() . 'index.php/orcamentos/editar/' . $idOrc);
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro.');
                redirect(base_url() . 'index.php/orcamentos/editar/' . $idOrc);
            }
        }
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
            log_message('error', 'Upload error: ' . strip_tags($upload_error));
            show_error('Erro no upload do arquivo.', 400);

        } else {

            return $this->upload->data();


            //$file_info = array($this->upload->data());
            // return $file_info[0]['file_name'];
        }
    }

    function ativardesativaritemescopo()
    {
        if ($this->input->post('status') == 'false') {
            $ativo = 0;
        } else {
            $ativo = 1;
        }
        $data = array(
            "ativo" => $ativo
        );
        $this->orcamentos_model->edit("orc_servico_escopo_itens", $data, "idOrcServicoEscopoItens", $this->input->post('idOrcServItem'));
        $orc = $this->orcamentos_model->getEscopoItem($this->input->post('idOrcServItem'));
        $this->orcamentos_model->edit("servico_escopo_itens", $data, "idServicoEscopoItens", $orc->idServicoEscopoItens);
        echo json_encode(array("result" => true));
    }
    function ativardesativaritemescopo2()
    {
        if ($this->input->post('status') == 'false') {
            $ativo = 0;
        } else {
            $ativo = 1;
        }
        $data = array(
            "ativo" => $ativo
        );

        $this->orcamentos_model->edit("servico_escopo_itens", $data, "idServicoEscopoItens", $this->input->post('idOrcServItem'));
        echo json_encode(array("result" => true));
    }
    function carregarChecklist()
    {
        $idProduto = $this->input->post('idProduto');
        $checklist = $this->peritagem_model->getChecklistAtivoByIdProduto($idProduto);
        $checklistItens = $this->peritagem_model->getChecklistItensAtivoByIdProduto($checklist->idCatalogoProduto);
        $json = array("result" => true, "resultado" => $checklistItens);
        echo json_encode($json);
    }

    function alterarcatalogoorc()
    {
        $idCatalogo = $this->input->post('idCatalogo');
        $orcItem = $this->input->post('idOrcItem');
        if (!empty($idCatalogo)) {
            $data = array(
                "idCatalogo" => $idCatalogo,
                "tipoOrc" => "fab"
            );
        } else {
            $data = array(
                "idCatalogo" => null
            );
        }
        $this->orcamentos_model->edit('orcamento_item', $data, "idOrcamento_item", $orcItem);
        echo json_encode(array("result" => true));
    }

    function copiarorcamento()
    {
        if (empty($this->input->post('copiarOrc'))) {
            $this->session->set_flashdata('error', 'Nenhum item foi selecionado.');
            redirect(base_url() . 'index.php/orcamentos/editar/' . $this->input->post('idOrcCopiar'));
        }
        $orc = $this->orcamentos_model->get2("orcamento", " * ", "idOrcamentos = " . $this->input->post('idOrcCopiar'), 1, null, true);
        $copiaOrc2 = clone $orc;
        $copiaOrc2->data_abertura = date('Y-m-d H:i:s');
        $copiaOrc2->status_orc = 0;
        $copiaOrc2->idOrcamentos = null;
        $copiaOrc2->idstatusOrcamento = 11;
        $idCopiaOrc = $this->orcamentos_model->add("orcamento", $copiaOrc2, true);
        foreach ($this->input->post('copiarOrc') as $r) {
            $orcItem = $this->orcamentos_model->get2("orcamento_item", " * ", "idOrcamento_item = " . $r, 1, null, true);
            $copiaOrcItem = clone $orcItem;
            $copiaOrcItem->idOrcamento_item = null;
            $copiaOrcItem->idOrcamentos = $idCopiaOrc;
            $copiaOrcItem->status_item = 0;
            $this->orcamentos_model->add("orcamento_item", $copiaOrcItem, true);
        }
        $this->session->set_flashdata('success', 'Orçamento criado com sucesso!');
        redirect(base_url() . 'index.php/orcamentos/editar/' . $idCopiaOrc);
    }
    function solicitardesenho($idOrcItem)
    {

        //$data2 = array("statusDesenho"=>1,"data_solicitar_desenho"=>date('Y-m-d H:i:s'));
        $itemOrcamento = $this->orcamentos_model->get_item_orc2($idOrcItem);
        $usuarios = $this->orcamentos_model->getUsuariosComidPermissao(7);
        $email = "";
        foreach ($usuarios as $r) {
            if (!empty($r->email)) {
                //$this->send($r->email,"Orçamento: ".$orc->idOrcamentos." - SOLICITAÇÃO DE PERITAGEM","PN: ".$orc->pn." - ".$orc->descricao_item);
                $email = $email . $r->email . ",";
            }
        }
        try {
            if (!empty($email)) {
                $this->send($email, "Orçamento: " . $itemOrcamento->idOrcamentos . " - SOLICITAÇÃO DE DESENHO", "PN: " . $itemOrcamento->pn . " - " . $itemOrcamento->descricao_item);
            }
        } catch (Exception $e) {
            return false;
        }
        //echo json_encode(array("result"=>true));
        return true;
    }
    function getEstoqueProd()
    {
        $produtoEstoque = $this->orcamentos_model->getEstoqueProd($this->input->post('idProduto'));
        if (!empty($produtoEstoque->quantidade)) {
            echo json_encode(array('result' => true, 'quantidade' => $produtoEstoque->quantidade));
        } else {
            echo json_encode(array('result' => false, 'quantidade' => 0));
        }
    }
    function onoffServicoItens()
    {
        $this->load->model('peritagem_model');
        $status = $this->input->post('status');
        if ($status == "true") {
            $status = 1;
        } else {
            $status = 0;
        }
        $id = $this->input->post('id');
        $objOrc = $this->peritagem_model->getEscopoItensOrcByidEscopoItem($id);
        $objOrc->ativo = $status;
        $this->orcamentos_model->edit('orc_servico_escopo_itens', $objOrc, 'idOrcServicoEscopoItens', $objOrc->idOrcServicoEscopoItens);
        $json = array('result' => true, 'escopoItem' => $objOrc->idServicoEscopoItens, 'objstatus' => $status);
        echo json_encode($json);
    }
    function onoffEscopoItens()
    {
        $this->load->model('peritagem_model');

        $status = $this->input->post('status');
        if ($status) {
            $status = 1;
        } else {
            $status = 0;
        }
        $id = $this->input->post('id');
        $objEsc = $this->peritagem_model->getEscopoItemByIdEscopoItem($id);
        $objEsc->ativo = $status;
        $this->orcamentos_model->edit('servico_escopo_itens', $objEsc, 'idServicoEscopoItens', $objEsc->idServicoEscopoItens);
        $json = array('result' => true);
        echo json_encode($json);
    }
    function getinfoSolicitacaoPendente()
    {
        $idOrcItem = $this->input->post("idOrcItem");
        $itensAguardando = $this->orcamentos_model->getSolicitacoesPendenteByIdOrcItem($idOrcItem);
        $infoOrcItem = $this->orcamentos_model->getInfoOrcItem($idOrcItem);
        echo json_encode(array("result" => true, "objItens" => $itensAguardando, "objInfoOrcItem" => $infoOrcItem));
    }
    function confirmarAlteracao()
    {
        $idOrcItem = $this->input->post("idOrcItem");
        $itensAguardando = $this->orcamentos_model->getSolicitacoesPendenteByIdOrcItem($idOrcItem);
        $data = array("idStatusSolicitacao" => 2);
        $this->orcamentos_model->edit('solicitacao_alterar_pn', $data, 'idSolicitacaoAltPn', $itensAguardando->idSolicitacaoAltPn);
        echo json_encode(array("result" => true));
    }
    function recusarAlteracao()
    {
        $idOrcItem = $this->input->post("idOrcItem");
        $itensAguardando = $this->orcamentos_model->getSolicitacoesPendenteByIdOrcItem($idOrcItem);
        $data = array("idStatusSolicitacao" => 3);
        $this->orcamentos_model->edit('solicitacao_alterar_pn', $data, 'idSolicitacaoAltPn', $itensAguardando->idSolicitacaoAltPn);
        echo json_encode(array("result" => true));
    }
    function pendente()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOrcamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar Orcamentos.');
            redirect(base_url());
        }

        $this->load->library('table');
        $this->load->library('pagination');




        $config['base_url'] = base_url() . 'index.php/orcamentos/pendente';


        $cod_orc = $this->input->post('cod_orc');
        $clientes_id  = $this->input->post('clientes_id');
        $idstatusOrcamento = $this->input->post('idstatusOrcamento');
        $idGrupoServico = $this->input->post('idGrupoServico');
        $idNatOperacao = $this->input->post('idNatOperacao');
        $referencia = $this->input->post('referencia');
        $num_pedido = $this->input->post('num_pedido');
        $num_nf = $this->input->post('num_nf');
        $os = $this->input->post('cod_os');
        $status = $this->input->post('status_orc');
        $idProdutos = $this->input->post('idProdutos');
        $descricao_item = $this->input->post('descricao_item');

        if (!empty($cod_orc) || !empty($clientes_id) || !empty($idstatusOrcamento) || !empty($idGrupoServico) || !empty($idNatOperacao) || !empty($referencia) || !empty($num_pedido) || !empty($num_nf) || !empty($status <> '') || !empty($idProdutos <> '') || !empty($descricao_item <> '') || !empty($os <> '')) {

            $this->data['results'] = $this->orcamentos_model->getWhereLikeorc3($cod_orc, $clientes_id, $idstatusOrcamento, $idGrupoServico, $idNatOperacao, $referencia, $num_pedido, $num_nf, $status, $idProdutos, $descricao_item, $os);

            $config['total_rows'] = $this->orcamentos_model->numrowsWhereLikeorc($cod_orc, $clientes_id, $idstatusOrcamento, $idGrupoServico, $idNatOperacao, $referencia, $num_pedido, $num_nf, $status, $idProdutos, $descricao_item);
            $config['per_page'] = 10;
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


            $config['total_rows'] = $this->orcamentos_model->count('orcamento');
            $config['per_page'] = 10;
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

            $this->data['results'] = $this->orcamentos_model->getorc2('orcamento', '*, orcamento.idOrcamentos as id_Orcam, grupo_servico.nome as nomeGrupoServ', 'solicitacao_alterar_pn.idStatusSolicitacao = 1', $config['per_page'], $this->uri->segment(3));
        }

        //Gera número único de orçamento com data e hora
        /*  $ano = date('Y');
         $mes = date('m');
         $dia = date('d');
         $hora= date('H');
         $min = date('i');
         $seg = date('s');
         $dados['num_orcamento'] = $ano.$mes.$dia.$hora.$min.$seg;*/

        //Gera data de cadastro
        $ano_cadastro = date('Y');
        $mes_cadastro = date('m');
        $dia_cadastro = date('d');
        $data_cadastro = $dia_cadastro . '/' . $mes_cadastro . '/' . $ano_cadastro;
        $data['data_cadastro'] = $data_cadastro;


        //$this->data['results'] = $this->insumos_model->get('insumos','idInsumos,nomeInsumo,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep','',$config['per_page'],$this->uri->segment(3));

        // $data['menuInsumos'] = 'Insumos';

        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
        $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
        $this->data['dados_clientes'] = $this->orcamentos_model->getCliente();
        $this->data['dados_vendedor'] = $this->orcamentos_model->getVendedor();
        $this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
        $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
        $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();

        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();

        $this->data['view'] = 'orcamentos/aguardandoAlteracaoPN';
        $this->load->view('tema/topo', $this->data);
        $this->load->view('tema/rodape');
    }
    function liberarPCP(){
        $this->load->model('os_model');
        $idOs = $this->input->post("idOs");
        $unid_exec = $this->input->post("unid_execucao");
        $unid_fat = $this->input->post("unid_faturamento");
        $id = $this->input->post("idOrc");
        $data = array(
            "unid_execucao"=>$unid_exec,
            "unid_faturamento"=>$unid_fat,
            "fechadoPCP"=>1
        );
        $this->orcamentos_model->edit("os",$data,"idOs",$idOs);
        $orcItem = $this->os_model->getOrcamentoItemByIdOs($idOs);
        if(empty($this->orcamentos_model->getSubOsbyidOs($idOs))){
            $dataSubOs = array(
                "idOs" => $idOs,
                "idProduto_master" => $orcItem->idProdutos,
                "idProduto_sub" => $orcItem->idProdutos,
                "posicao" => 0,
                "data_insert" => date('Y-m-d H:i:s'),
                "quantidade" => $orcItem->qtd,
                "idClasse" => ($orcItem->tipoOrc?1:2),
                "ativo" => 1,
                "descricaoOsSub" => $orcItem->descricao_item
            );
            $this->orcamentos_model->add("os_sub", $dataSubOs);
        }
        $this->session->set_flashdata('success', 'O.S. '.$idOs.' liberada para o PCP com sucesso.');
        redirect('orcamentos/editar/' . $id);
        //echo json_encode(array("result"=>true));
    }
}
