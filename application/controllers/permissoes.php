<?php

class Permissoes extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cPermissao')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar as permissões no sistema.');
            redirect(base_url());
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('permissoes_model', '', TRUE);
        $this->data['menuConfiguracoes'] = 'Permissões';
    }

    function index()
    {
        $this->gerenciar();
    }

    function gerenciar()
    {

        $this->load->library('pagination');


        $config['base_url'] = base_url() . 'index.php/permissoes/gerenciar/';
        $config['total_rows'] = $this->permissoes_model->count('permissoes');
        $config['per_page'] = 20;
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

        $this->data['results'] = $this->permissoes_model->get('permissoes', 'idPermissao,nome,data,situacao', '', $config['per_page'], $this->uri->segment(3));

        $this->data['view'] = 'permissoes/permissoes';
        $this->load->view('tema/topo', $this->data);
    }

    function adicionar()
    {
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $nomePermissao = $this->input->post('nome');
            $cadastro = date('Y-m-d');
            $situacao = 1;

            $permissoes = array(

                'aCliente' => $this->input->post('aCliente'),
                'eCliente' => $this->input->post('eCliente'),
                'dCliente' => $this->input->post('dCliente'),
                'vCliente' => $this->input->post('vCliente'),


                  'pSolCompra' => $this->input->post('pSolCompra'),
                  'vAutCompra' => $this->input->post('vAutCompra'),
                  'aAutCompra' => $this->input->post('aAutCompra'),
                  'aAutCompraFIN' => $this->input->post('aAutCompraFIN'),
                  'aAutCompraDir' => $this->input->post('aAutCompraDir'),
                  'aAutCompraPCP' => $this->input->post('aAutCompraPCP'),
                  'aAutCompraDirTec' => $this->input->post('aAutCompraDirTec'),
				  
				  'aFornecedor' => $this->input->post('aFornecedor'),
                  'eFornecedor' => $this->input->post('eFornecedor'),
                  'dFornecedor' => $this->input->post('dFornecedor'),
                  'vFornecedor' => $this->input->post('vFornecedor'),

                'aAlmoxarifado' => $this->input->post('aAlmoxarifado'),
                'eAlmoxarifado' => $this->input->post('eAlmoxarifado'),
                'dAlmoxarifado' => $this->input->post('dAlmoxarifado'),
                'vAlmoxarifado' => $this->input->post('vAlmoxarifado'),

                'aPedidocompraalmox' => $this->input->post('aPedidocompraalmox'),
                'ePedidocompraalmox' => $this->input->post('ePedidocompraalmox'),
                'dPedidocompraalmox' => $this->input->post('dPedidocompraalmox'),
                'vPedidocompraalmox' => $this->input->post('vPedidocompraalmox'),
                'aPermisaocompras' => $this->input->post('aPermisaocompras'),
                'vGerenciaalmo' => $this->input->post('vGerenciaalmo'),
                'eVale' => $this->input->post('eVale'),
                'ePecamorta' => $this->input->post('ePecamorta'),
                'eLiberarpcp' => $this->input->post('eLiberarpcp'),

                'aCotacao' => $this->input->post('aCotacao'),
                'eCotacao' => $this->input->post('eCotacao'),
                'dCotacao' => $this->input->post('dCotacao'),
                'vCotacao' => $this->input->post('vCotacao'),

                'aPedCompra' => $this->input->post('aPedCompra'),
                'ePedCompra' => $this->input->post('ePedCompra'),
                'dPedCompra' => $this->input->post('dPedCompra'),
                'vPedCompra' => $this->input->post('vPedCompra'),

                'pSolCompra' => $this->input->post('pSolCompra'),
                'vAutCompra' => $this->input->post('vAutCompra'),
                'aAutCompra' => $this->input->post('aAutCompra'),
                'aAutCompraFIN' => $this->input->post('aAutCompraFIN'),
                'aAutCompraDir' => $this->input->post('aAutCompraDir'),
                'aAutCompraPCP' => $this->input->post('aAutCompraPCP'),
                'aAutCompraDirTec' => $this->input->post('aAutCompraDirTec'),

                'aFornecedor' => $this->input->post('aFornecedor'),
                'eFornecedor' => $this->input->post('eFornecedor'),
                'dFornecedor' => $this->input->post('dFornecedor'),
                'vFornecedor' => $this->input->post('vFornecedor'),


                  'aOs' => $this->input->post('aOs'),
                  'eOs' => $this->input->post('eOs'),
                  'dOs' => $this->input->post('dOs'),
                  'vOs' => $this->input->post('vOs'),
                  'vDistribuirOs' => $this->input->post('vDistribuirOs'),
                  'eDistribuirOs' => $this->input->post('eDistribuirOs'),
                  'vvalorOs' => $this->input->post('vvalorOs'),
                  'vpedidoOs' => $this->input->post('vpedidoOs'),
                  'apedidoOs' => $this->input->post('apedidoOs'),
                  'vdesenhoOs' => $this->input->post('vdesenhoOs'),
                  'adesenhoOs' => $this->input->post('adesenhoOs'),
                  'vnotafiscalOs' => $this->input->post('vnotafiscalOs'),
                  'anotafiscalOs' => $this->input->post('anotafiscalOs'),
                  'alterarStatusOsPeritagem' => $this->input->post('alterarStatusOsPeritagem'),
                  'vobscontroleOS' => $this->input->post('vobscontroleOS'),
                  'eobscontroleOS' => $this->input->post('eobscontroleOS'),
                  'vVerificacaocontroleOS' => $this->input->post('vVerificacaocontroleOS'),
                  'eErificacaocontroleOS' => $this->input->post('eErificacaocontroleOS'),
                'aProduto' => $this->input->post('aProduto'),
                'eProduto' => $this->input->post('eProduto'),
                'dProduto' => $this->input->post('dProduto'),
                'vProduto' => $this->input->post('vProduto'),

                'aDesenho' => $this->input->post('aDesenho'),
                'eDesenho' => $this->input->post('eDesenho'),
                'dDesenho' => $this->input->post('dDesenho'),
                'vDesenho' => $this->input->post('vDesenho'),

                'aInsumo' => $this->input->post('aInsumo'),
                'eInsumo' => $this->input->post('eInsumo'),
                'dInsumo' => $this->input->post('dInsumo'),
                'vInsumo' => $this->input->post('vInsumo'),

                'vEstoque' => $this->input->post('vEstoque'),
                'aEstoque' => $this->input->post('aEstoque'),
                'sEstoque' => $this->input->post('sEstoque'),
                'valorEstoque' => $this->input->post('valorEstoque'),

                'aCategoria' => $this->input->post('aCategoria'),
                'eCategoria' => $this->input->post('eCategoria'),
                'dCategoria' => $this->input->post('dCategoria'),
                'vCategoria' => $this->input->post('vCategoria'),

                'aSubcategoria' => $this->input->post('aSubcategoria'),
                'eSubcategoria' => $this->input->post('eSubcategoria'),
                'dSubcategoria' => $this->input->post('dSubcategoria'),
                'vSubcategoria' => $this->input->post('vSubcategoria'),

                'aMaquina' => $this->input->post('aMaquina'),
                'eMaquina' => $this->input->post('eMaquina'),
                'dMaquina' => $this->input->post('dMaquina'),
                'vMaquina' => $this->input->post('vMaquina'),

                'aMaquinausuario' => $this->input->post('aMaquinausuario'),
                'eMaquinausuario' => $this->input->post('eMaquinausuario'),
                'dMaquinausuarioa' => $this->input->post('dMaquinausuario'),
                'vMaquinausuario' => $this->input->post('vMaquinausuario'),

                'eHoramaquinas' => $this->input->post('eHoramaquinas'),

                
                'reagendarOs' => $this->input->post('reagendarOs'),

                'aOrcamento' => $this->input->post('aOrcamento'),
                'eOrcamento' => $this->input->post('eOrcamento'),
                'APOrcamento' => $this->input->post('APOrcamento'),
                'dOrcamento' => $this->input->post('dOrcamento'),
                'vOrcamento' => $this->input->post('vOrcamento'),

                'aArquivo' => $this->input->post('aArquivo'),
                'eArquivo' => $this->input->post('eArquivo'),
                'dArquivo' => $this->input->post('dArquivo'),
                'vArquivo' => $this->input->post('vArquivo'),

                'aAnexoNovo' => $this->input->post('aAnexoNovo'),
                'aAnexo' => $this->input->post('aAnexo'),
                'eAnexo' => $this->input->post('eAnexo'),
                'dAnexo' => $this->input->post('dAnexo'),
                'vAnexo' => $this->input->post('vAnexo'),

                'aApontamento' => $this->input->post('aApontamento'),
                'eApontamento' => $this->input->post('eApontamento'),
                'dApontamento' => $this->input->post('dApontamento'),
                'vApontamento' => $this->input->post('vApontamento'),

                'aLancamento' => $this->input->post('aLancamento'),
                'eLancamento' => $this->input->post('eLancamento'),
                'dLancamento' => $this->input->post('dLancamento'),
                'vLancamento' => $this->input->post('vLancamento'),

                'vPeritagem' => $this->input->post('vPeritagem'),
                'ePeritagem' => $this->input->post('ePeritagem'),
                'cPeritagem' => $this->input->post('cPeritagem'), //confirmar Peritagem
                'aPeritagem' => $this->input->post('aPeritagem'),
                'peritagemCil' => $this->input->post('peritagemCil'),
                'peritagemMaq' => $this->input->post('peritagemMaq'),
                'peritagemSub' => $this->input->post('peritagemSub'),
                'peritagemPec' => $this->input->post('peritagemPec'),

                'cUsuario' => $this->input->post('cUsuario'),
                'cEmitente' => $this->input->post('cEmitente'),
                'cPermissao' => $this->input->post('cPermissao'),
                'cBackup' => $this->input->post('cBackup'),

                'rCliente' => $this->input->post('rCliente'),
                'rProduto' => $this->input->post('rProduto'),
                'rServico' => $this->input->post('rServico'),
                'rOs' => $this->input->post('rOs'),
                'rOrcamento' => $this->input->post('rOrcamento'),
                'rOrdemcompra' => $this->input->post('rOrdemcompra'),
                'rFinanceiro' => $this->input->post('rFinanceiro'),

                'emailSobra' => $this->input->post('emailSobra'),

                'fComercial' => $this->input->post('fComercial'),
                'fPCP' => $this->input->post('fPCP'),
                'fProducao' => $this->input->post('fProducao'),
                'fPeritagem' => $this->input->post('fPeritagem'),
                'fSuprimentos' => $this->input->post('fSuprimentos'),
                'fAlmoxarifado' => $this->input->post('fAlmoxarifado'),
                
                'eDataReproCil' => $this->input->post('eDataReproCil'),
                'eDataReproServ' => $this->input->post('eDataReproServ'),
                'eDataReproFab' => $this->input->post('eDataReproFab'),
                'eDataReproPet' => $this->input->post('eDataReproPet'),

                'vProcessos' =>$this->input->post('vProcessos'),
                'eProcessos' =>$this->input->post('eProcessos'),
                'aProcessos' =>$this->input->post('aProcessos'),
                'aGruposProcessos' =>$this->input->post('aGruposProcessos'),
                'desenhoTotal'=>$this->input->post('desenhoTotal'),

                'receberMercadoria' =>$this->input->post('receberMercadoria'),

                'aObsPlanejamento' =>$this->input->post('aObsPlanejamento'),
                
                'clientes' => $this->input->post('clientes'),

                'desenvolvedor' => $this->input->post('desenvolvedor')
            );
            $permissoes = serialize($permissoes);

            $data = array(
                'nome' => $nomePermissao,
                'data' => $cadastro,
                'permissoes' => $permissoes,
                'situacao' => $situacao
            );

            if ($this->permissoes_model->add('permissoes', $data) == TRUE) {

                $this->session->set_flashdata('success', 'Permissão adicionada com sucesso!');
                redirect(base_url() . 'index.php/permissoes/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'permissoes/adicionarPermissao';
        $this->load->view('tema/topo', $this->data);
    }

    function editar()
    {

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->input->post('situacao');



        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $nomePermissao = $this->input->post('nome');
            $situacao = $this->input->post('situacao');
            $permissoes = array(

                'aCliente' => $this->input->post('aCliente'),
                'eCliente' => $this->input->post('eCliente'),
                'dCliente' => $this->input->post('dCliente'),
                'vCliente' => $this->input->post('vCliente'),


                  'pSolCompra' => $this->input->post('pSolCompra'),
                  'vAutCompra' => $this->input->post('vAutCompra'),
                  'aAutCompra' => $this->input->post('aAutCompra'),
                  'aAutCompraFIN' => $this->input->post('aAutCompraFIN'),
                  'aAutCompraDir' => $this->input->post('aAutCompraDir'),
                  'aAutCompraPCP' => $this->input->post('aAutCompraPCP'),
                  'aAutCompraDirTec' => $this->input->post('aAutCompraDirTec'),
				  
				  'aFornecedor' => $this->input->post('aFornecedor'),
                  'eFornecedor' => $this->input->post('eFornecedor'),
                  'dFornecedor' => $this->input->post('dFornecedor'),
                  'vFornecedor' => $this->input->post('vFornecedor'),

                'aAlmoxarifado' => $this->input->post('aAlmoxarifado'),
                'eAlmoxarifado' => $this->input->post('eAlmoxarifado'),
                'dAlmoxarifado' => $this->input->post('dAlmoxarifado'),
                'vAlmoxarifado' => $this->input->post('vAlmoxarifado'),

                'aPedidocompraalmox' => $this->input->post('aPedidocompraalmox'),
                'ePedidocompraalmox' => $this->input->post('ePedidocompraalmox'),
                'dPedidocompraalmox' => $this->input->post('dPedidocompraalmox'),
                'vPedidocompraalmox' => $this->input->post('vPedidocompraalmox'),
                'aPermisaocompras' => $this->input->post('aPermisaocompras'),
                'vGerenciaalmo' => $this->input->post('vGerenciaalmo'),
                'eVale' => $this->input->post('eVale'),
                'ePecamorta' => $this->input->post('ePecamorta'),
                'eLiberarpcp' => $this->input->post('eLiberarpcp'),

                'aCotacao' => $this->input->post('aCotacao'),
                'eCotacao' => $this->input->post('eCotacao'),
                'dCotacao' => $this->input->post('dCotacao'),
                'vCotacao' => $this->input->post('vCotacao'),

                'aPedCompra' => $this->input->post('aPedCompra'),
                'ePedCompra' => $this->input->post('ePedCompra'),
                'dPedCompra' => $this->input->post('dPedCompra'),
                'vPedCompra' => $this->input->post('vPedCompra'),

                'pSolCompra' => $this->input->post('pSolCompra'),
                'vAutCompra' => $this->input->post('vAutCompra'),
                'aAutCompra' => $this->input->post('aAutCompra'),
                'aAutCompraFIN' => $this->input->post('aAutCompraFIN'),
                'aAutCompraDir' => $this->input->post('aAutCompraDir'),
                'aAutCompraPCP' => $this->input->post('aAutCompraPCP'),
                'aAutCompraDirTec' => $this->input->post('aAutCompraDirTec'),

                'aFornecedor' => $this->input->post('aFornecedor'),
                'eFornecedor' => $this->input->post('eFornecedor'),
                'dFornecedor' => $this->input->post('dFornecedor'),
                'vFornecedor' => $this->input->post('vFornecedor'),


                  'aOs' => $this->input->post('aOs'),
                  'eOs' => $this->input->post('eOs'),
                  'dOs' => $this->input->post('dOs'),
                  'vOs' => $this->input->post('vOs'),
                  
                  'vDistribuirOs' => $this->input->post('vDistribuirOs'),
                  'eDistribuirOs' => $this->input->post('eDistribuirOs'),
				  'vvalorOs' => $this->input->post('vvalorOs'),
                  'vpedidoOs' => $this->input->post('vpedidoOs'),
                  'apedidoOs' => $this->input->post('apedidoOs'),
                  'vdesenhoOs' => $this->input->post('vdesenhoOs'),
                  'adesenhoOs' => $this->input->post('adesenhoOs'),
                  'vnotafiscalOs' => $this->input->post('vnotafiscalOs'),
                  'anotafiscalOs' => $this->input->post('anotafiscalOs'),
                  'alterarStatusOsPeritagem' => $this->input->post('alterarStatusOsPeritagem'),
                  'vobscontroleOS' => $this->input->post('vobscontroleOS'),
                  'eobscontroleOS' => $this->input->post('eobscontroleOS'),
                  'vVerificacaocontroleOS' => $this->input->post('vVerificacaocontroleOS'),
                  'eErificacaocontroleOS' => $this->input->post('eErificacaocontroleOS'),

                'aProduto' => $this->input->post('aProduto'),
                'eProduto' => $this->input->post('eProduto'),
                'dProduto' => $this->input->post('dProduto'),
                'vProduto' => $this->input->post('vProduto'),

                'aDesenho' => $this->input->post('aDesenho'),
                'eDesenho' => $this->input->post('eDesenho'),
                'dDesenho' => $this->input->post('dDesenho'),
                'vDesenho' => $this->input->post('vDesenho'),

                'aInsumo' => $this->input->post('aInsumo'),
                'eInsumo' => $this->input->post('eInsumo'),
                'dInsumo' => $this->input->post('dInsumo'),
                'vInsumo' => $this->input->post('vInsumo'),

                'vEstoque' => $this->input->post('vEstoque'),
                'aEstoque' => $this->input->post('aEstoque'),
                'sEstoque' => $this->input->post('sEstoque'),
                'valorEstoque' => $this->input->post('valorEstoque'),


                'aCategoria' => $this->input->post('aCategoria'),
                'eCategoria' => $this->input->post('eCategoria'),
                'dCategoria' => $this->input->post('dCategoria'),
                'vCategoria' => $this->input->post('vCategoria'),

                'aSubcategoria' => $this->input->post('aSubcategoria'),
                'eSubcategoria' => $this->input->post('eSubcategoria'),
                'dSubcategoria' => $this->input->post('dSubcategoria'),
                'vSubcategoria' => $this->input->post('vSubcategoria'),

                'aMaquina' => $this->input->post('aMaquina'),
                'eMaquina' => $this->input->post('eMaquina'),
                'dMaquina' => $this->input->post('dMaquina'),
                'vMaquina' => $this->input->post('vMaquina'),

                'aMaquinausuario' => $this->input->post('aMaquinausuario'),
                'eMaquinausuario' => $this->input->post('eMaquinausuario'),
                'dMaquinausuario' => $this->input->post('dMaquinausuario'),
                'vMaquinausuario' => $this->input->post('vMaquinausuario'),

                'eHoramaquinas' => $this->input->post('eHoramaquinas'),

                'aOs' => $this->input->post('aOs'),
                'eOs' => $this->input->post('eOs'),
                'dOs' => $this->input->post('dOs'),
                'vOs' => $this->input->post('vOs'),
                
                'reagendarOs' => $this->input->post('reagendarOs'),

                'aOrcamento' => $this->input->post('aOrcamento'),
                'eOrcamento' => $this->input->post('eOrcamento'),
                'dOrcamento' => $this->input->post('dOrcamento'),
                'APOrcamento' => $this->input->post('APOrcamento'),
                'vOrcamento' => $this->input->post('vOrcamento'),

                'aArquivo' => $this->input->post('aArquivo'),
                'eArquivo' => $this->input->post('eArquivo'),
                'dArquivo' => $this->input->post('dArquivo'),
                'vArquivo' => $this->input->post('vArquivo'),

                'aAnexoNovo' => $this->input->post('aAnexoNovo'),
                'aAnexo' => $this->input->post('aAnexo'),
                'eAnexo' => $this->input->post('eAnexo'),
                'dAnexo' => $this->input->post('dAnexo'),
                'vAnexo' => $this->input->post('vAnexo'),

                'aApontamento' => $this->input->post('aApontamento'),
                'eApontamento' => $this->input->post('eApontamento'),
                'dApontamento' => $this->input->post('dApontamento'),
                'vApontamento' => $this->input->post('vApontamento'),

                'aLancamento' => $this->input->post('aLancamento'),
                'eLancamento' => $this->input->post('eLancamento'),
                'dLancamento' => $this->input->post('dLancamento'),
                'vLancamento' => $this->input->post('vLancamento'),

                'vPeritagem' => $this->input->post('vPeritagem'),
                'ePeritagem' => $this->input->post('ePeritagem'),
                'cPeritagem' => $this->input->post('cPeritagem'), //confirmar Peritagem
                'aPeritagem' => $this->input->post('aPeritagem'),
                'peritagemCil' => $this->input->post('peritagemCil'),
                'peritagemMaq' => $this->input->post('peritagemMaq'),
                'peritagemSub' => $this->input->post('peritagemSub'),
                'peritagemPec' => $this->input->post('peritagemPec'),

                'cUsuario' => $this->input->post('cUsuario'),
                'cEmitente' => $this->input->post('cEmitente'),
                'cPermissao' => $this->input->post('cPermissao'),
                'cBackup' => $this->input->post('cBackup'),

                'rCliente' => $this->input->post('rCliente'),
                'rProduto' => $this->input->post('rProduto'),
                'rServico' => $this->input->post('rServico'),
                'rOs' => $this->input->post('rOs'),
                'rOrcamento' => $this->input->post('rOrcamento'),
                'rOrdemcompra' => $this->input->post('rOrdemcompra'),
                'rFinanceiro' => $this->input->post('rFinanceiro'),

                'emailSobra' => $this->input->post('emailSobra'),

                'fComercial' => $this->input->post('fComercial'),
                'fPCP' => $this->input->post('fPCP'),
                'fProducao' => $this->input->post('fProducao'),
                'fPeritagem' => $this->input->post('fPeritagem'),
                'fSuprimentos' => $this->input->post('fSuprimentos'),
                'fAlmoxarifado' => $this->input->post('fAlmoxarifado'),
                
                'eDataReproCil' => $this->input->post('eDataReproCil'),
                'eDataReproServ' => $this->input->post('eDataReproServ'),
                'eDataReproFab' => $this->input->post('eDataReproFab'),
                'eDataReproPet' => $this->input->post('eDataReproPet'),
                
                'vProcessos' =>$this->input->post('vProcessos'),
                'eProcessos' =>$this->input->post('eProcessos'),
                'aProcessos' =>$this->input->post('aProcessos'),
                'aGruposProcessos' =>$this->input->post('aGruposProcessos'),
                
                'receberMercadoria' =>$this->input->post('receberMercadoria'),
                'aObsPlanejamento' =>$this->input->post('aObsPlanejamento'),
                'desenhoTotal'=>$this->input->post('desenhoTotal'),

                'clientes' => $this->input->post('clientes'),
                'desenvolvedor' => $this->input->post('desenvolvedor')

            );
            $permissoes = serialize($permissoes);

            $data = array(
                'nome' => $nomePermissao,
                'permissoes' => $permissoes,
                'situacao' => $situacao
            );

            if ($this->permissoes_model->edit('permissoes', $data, 'idPermissao', $this->input->post('idPermissao')) == TRUE) {
                $this->session->set_flashdata('success', 'Permissão editada com sucesso!');
                redirect(base_url() . 'index.php/permissoes/editar/' . $this->input->post('idPermissao'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um errro.</p></div>';
            }
        }

        $this->data['result'] = $this->permissoes_model->getById($this->uri->segment(3));

        $this->data['view'] = 'permissoes/editarPermissao';
        $this->load->view('tema/topo', $this->data);
    }

    function excluir()
    {


        $id =  $this->input->post('id');
        if ($id == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar excluir serviço.');
            redirect(base_url() . 'index.php/maquinas/gerenciar/');
        }

        $this->db->where('servicos_id', $id);
        $this->db->delete('servicos_os');

        $this->maquinas_model->delete('maquinas', 'idMaquinas', $id);


        $this->session->set_flashdata('success', 'Maquina excluida com sucesso!');
        redirect(base_url() . 'index.php/maquinas/gerenciar/');
    }
}


/* End of file permissoes.php */
/* Location: ./application/controllers/permissoes.php */