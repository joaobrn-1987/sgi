<?php

class Almoxarifado extends CI_Controller {

    function __construct() {
        parent::__construct();
                if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
                    redirect('mapos/login');
                }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('almoxarifado_model','',TRUE);
		$this->load->model('produtos_model'); // <-- Adicione esta linha
        if($this->uri->segment(2) == 'menuvale'){
            $this->data['menuPcp'] = 'PCP';
        }else{
            $this->data['menuAlmoxarifado'] = 'Almoxarifado';
        }
        $this->load->model('producao_model');
	}	
	
	function index(){
		$this->gerenciar();
	}

    function gerenciar(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vAlmoxarifado')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar Almoxarifado.');
            redirect(base_url());
        }
        if($this->uri->segment(3) == 'local'){
            $this->data['local'] = true;
        }
        $this->load->model('orcamentos_model');
        $this->load->model('estoque_model');
        $this->load->model('insumos_model');
        $idUser = $this->session->userdata('idUsuarios');
        $getUserDepartaentos = $this->almoxarifado_model->getDepartamentoUsuario($idUser);
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        if(count($getUserEmpresa)>0){
            $this->data['dados_emitente'] = $getUserEmpresa;
        }else{
            /*
            $getUserEmpresa = "";
            $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
            */
            $this->session->set_flashdata('error','Você não está vinculado à uma empresa.');
            redirect(base_url());
        }
        if(count($getUserDepartaentos)>0){
            $this->data['dados_departamento'] = $getUserDepartaentos;
        }else{
            /*
            $this->data['dados_departamento'] = $this->almoxarifado_model->getDepartamento();*/
            $this->session->set_flashdata('error','Você não está vinculado à um departamento.');
            redirect(base_url());
        }      
        $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
        $this->data['result'] = $this->almoxarifado_model->getEstoque();
        //$this->data['dados_saida'] = $this->almoxarifado_model->getSaida();
        //$this->data['dados_entrada'] = $this->almoxarifado_model->getEntrada();
        $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
        $this->data['dados_statusProduto'] = $this->almoxarifado_model->getStatusProduto();
        $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
        $this->data['dados_categoria'] = $this->insumos_model->getCategoria();
        //$this->data['dadosRelatorio'] = $this->almoxarifado_model->getRelatorioInicial2();
        $this->data['dados_insumos'] = $this->insumos_model->getinsumosubcat2();
        $this->data['view'] = 'almoxarifado/almoxarifado';
        $this->load->view('tema/topo',$this->data);
    }
    
    function reldetalhado(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vAlmoxarifado')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar Almoxarifado.');
            redirect(base_url());
        }
        //$this->data['dadosRelatorioEntrada'] = 
        //$this->data['dadosRelatorioSaida'] = 
        $result = $this->almoxarifado_model->getRelatorioInicial();
        if(count($result)>0){
            for($x=0;$x<count($result);$x++){
                $result[$x]->detalheEstoqueEmpresas = [];
                $result[$x]->detalheEstoqueEmpresas = $this->almoxarifado_model->getRelatorioPorInsumoEmpresa($result[$x]->idInsumos);
                /*$result[$x]->entradas = [];
                $result[$x]->entradas = $this->almoxarifado_model->getRelatorioEntradaPorInsumo($result[$x]->idInsumos);
                $result[$x]->saidas = [];
                $result[$x]->saidas = $this->almoxarifado_model->getRelatorioSaidaPorInsumo($result[$x]->idInsumos);*/
            }
        }
        $this->data['dadosRelatorio'] = $result;
        $this->data['view'] = 'almoxarifado/relatorioalmoxarifado';
        $this->load->view('tema/topo',$this->data);
    }
    public function cadastrarEntradas(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){
            $this->session->set_flashdata('error','Você não tem permissão para cadastrar estoque em Almoxarifado.');
            redirect(base_url());
        }
        $this->data['custom_error'] = '';
        $idUser = $this->session->userdata('idUsuarios');
        //$idProdutoID = $this->input->post('idProdutoTD_');
        //echo("<script>console.log('Emitente: OI');</script>");
        //echo("<script>console.log('ProdutoId: ".$idProdutoID[0]."');</script>");
        for($x=0;$x<count($this->input->post('idProdutoTD_'));$x++){
            if(!empty($this->input->post('idProdutoTD_')[$x])){
                $p = $this->input->post('idProdutoTD_')[$x];
            }else{
                $p="";
            }
            if(!empty($this->input->post('idMedicaoTD_')[$x])){
                $m = $this->input->post('idMedicaoTD_')[$x];
            }else{
                $m="";
            }
            if(!empty($this->input->post('tamanhoTD_')[$x])){
                $c = $this->input->post('tamanhoTD_')[$x];
            }else{
                $c="";
            } 
            if(!empty($this->input->post('volumeTD_')[$x])){
                $v = $this->input->post('volumeTD_')[$x];
            }else{
                $v="";
            }
            if(!empty($this->input->post('pesoTD_')[$x])){
                $ps = $this->input->post('pesoTD_')[$x];
            }else{
                $ps="";
            }
            if(!empty($this->input->post('dimensoesTD_')[$x])){
                $dim = $this->input->post('dimensoesTD_')[$x];
                $dim = explode('x',$dim);
                $dimL = $dim[0];
                $dimC = $dim[1];
                $dimA = $dim[2];
            }else{
                $dimL = null;
                $dimC = null;
                $dimA = null;
            }
            if(!empty($this->input->post('idEmpresaTD_')[$x])){
                $e = $this->input->post('idEmpresaTD_')[$x];
            }else{
                $e="";
            }
            if(!empty($this->input->post('idDepartamento_')[$x])){
                $dep = $this->input->post('idDepartamento_')[$x];
            }else{
                $dep="";
            }
            if(!empty($this->input->post('idLocalpTD_')[$x])){
                $l = $this->input->post('idLocalpTD_')[$x];
            }else{
                $l=null;
            } 
            if(!empty($this->input->post('nFTD_')[$x])){
                $nf = $this->input->post('nFTD_')[$x];
            }else{
                $nf="";
            } 
            if(!empty($this->input->post('idOsTD_')[$x])){
                $idOs = $this->input->post('idOsTD_')[$x];
            }else{
                $idOs=null;
            }
            if(!empty($this->input->post('valorUnit_')[$x])){
                $vu = str_replace(".","",$this->input->post('valorUnit_')[$x]);
                $vu = str_replace(",",".",$vu);
            }else{
                $vu="";
            }       
            if($m==0 || $m==1 || $m==2 || $m==3 || $m==4){
                $this->data["verificaPMEL"] = $this->almoxarifado_model->verificaPMEL($p,$m,$c,$v,$ps,$dimL,$dimC,$dimA,$e,$l,$dep,$idOs);
                if(count($this->data["verificaPMEL"] )<1){
                    $this->almoxarifado_model->criarEstoqueEntrada($p,$m,$c,$v,$ps,$dimL,$dimC,$dimA,$e,$l,$this->input->post('qtdTD_')[$x],$idUser,$nf,$idOs,$vu,$dep);
                    $this->almoxarifado_model->criarEstoque($p,$m,$c,$v,$ps,$dimL,$dimC,$dimA,$e,$l,$this->input->post('qtdTD_')[$x],$dep,$idOs);
                }else {
                    $newQtd = $this->data["verificaPMEL"][0]->quantidade + $this->input->post('qtdTD_')[$x];
                    $this->almoxarifado_model->criarEstoqueEntrada($p,$m,$c,$v,$ps,$dimL,$dimC,$dimA,$e,$l,$this->input->post('qtdTD_')[$x],$idUser,$nf,$idOs,$vu,$dep);
                    $this->almoxarifado_model->updateEstoque($this->data["verificaPMEL"][0]->idAlmoEstoque,$newQtd,$dep);
                }
            }
        }
        //cookie destroy
        setcookie("tabelaEntrada", "", time() - 3600,"/");
        //echo("<script>console.log(".dirname(__FILE__).");</script>");
        $this->session->set_flashdata('success','Itens cadastrados com sucesso.');
        redirect(base_url() . 'index.php/almoxarifado/almoxarifado');
        //$this->recarregarDadosEstoque();        
    }
    public function recarregarDadosEstoque(){
        $this->load->model('orcamentos_model');
        $this->load->model('estoque_model');
        $this->load->model('insumos_model');
        $idUser = $this->session->userdata('idUsuarios');
        $getUserDepartaentos = $this->almoxarifado_model->getDepartamentoUsuario($idUser);
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        if(count($getUserEmpresa)>0){
            $this->data['dados_emitente'] = $getUserEmpresa;
        }else{
            $getUserEmpresa = "";
            $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
        }
        if(count($getUserDepartaentos)>0){
            $this->data['dados_departamento'] = $getUserDepartaentos;
        }else{
            $this->data['dados_departamento'] = $this->almoxarifado_model->getDepartamento();
        }      
        $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
        $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
        //$this->data['dados_saida'] = $this->almoxarifado_model->getSaida();
        //$this->data['dados_entrada'] = $this->almoxarifado_model->getEntrada();
        $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
        //$this->data['dadosRelatorio'] = $this->almoxarifado_model->getRelatorioInicial2();
        $this->data['dados_categoria'] = $this->insumos_model->getCategoria();
        $this->data['dados_insumos'] = $this->insumos_model->getinsumosubcat2();
        $this->data['result'] = $this->almoxarifado_model->getEstoque();
        $this->data['view'] = 'almoxarifado/almoxarifado';
       	$this->load->view('tema/topo',$this->data);
    }
    public function autoCompleteLocais(){
        
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        if(!empty($this->uri->segment(4))){
            $d = $this->uri->segment(4);
        }else{
            $d= null;
        }
        
        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteLocais($q,$e,$d);
        }
    }
    public function autoCompleteEstoqueSaida(){
        
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        if(!empty($this->uri->segment(4))){
            $d = $this->uri->segment(4);
        }
        
        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteEstoqueSaida($q,$e,$d);
        }
    }public function autoCompleteEstoqueSaidaLocal(){
        
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        if(!empty($this->uri->segment(4))){
            $d = $this->uri->segment(4);
        }
        
        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteEstoqueSaidaLocal($q,$e,$d);
        }
    }
    public function autoCompleteFunc(){
        
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        
        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteFunc($q);
        }
    }
    public function autoCompleteCategoriaSubCategoria(){   

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteCategoriaSubCategoria($q);
        }
    }
    public function autoCompleteSubcategoria(){   

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteSubcategoria($q);
        }
    }
    public function autoCompleteInsumos(){   

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteInsumos($q);
        }
    }
    public function autoCompletePN(){   

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompletePN($q);
        }
    }
    public function autoCompleteProd2(){   

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteProd2($q);
        }
    }
    public function autoCompleteREF2(){   

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteREF2($q);
        }
    }

    public function autoCompleteInsumosPN(){   

        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        if(!empty($this->uri->segment(4))){
            $d = $this->uri->segment(4);
        }
        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteInsumosPN($q,$e,$d);
        }
    }
    public function autoCompleteProdEstoque(){
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        if(!empty($this->uri->segment(4))){
            $d = $this->uri->segment(4);
        }
        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteProdEstoque($q,$e,$d);
        }
    }
    public function autoCompletePnEstoque(){
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        if(!empty($this->uri->segment(4))){
            $d = $this->uri->segment(4);
        }
        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompletePnEstoque($q,$e,$d);
        }
    }
    public function autoCompleteREFEstoque(){
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        if(!empty($this->uri->segment(4))){
            $d = $this->uri->segment(4);
        }
        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteREFEstoque($q,$e,$d);
        }
    }
//////////////////////////////registra consulta contador/////////////////////
public function getEstatisticasEstoqueFiltrado()
{
    $this->load->model('produtos_model');
    $this->load->model('almoxarifado_model');

    $prode = $this->input->post('prode');
    $pne = $this->input->post('pne');
    $idOse = $this->input->post('idOse');
    $idEmpresae = $this->input->post('idEmpresae');
    $idDepartamentoe = $this->input->post('idDepartamentoe');
    $local = $this->input->post('local');
    $unidades = $this->input->post('unidades');

    // Construa as condições WHERE para as tabelas de estoque (insumos e produtos)
    $whereInsumos = '';
    $whereProdutos = '';
    $primeiroInsumo = true;
    $primeiroProduto = true;

    if (!empty($prode)) {
        $prode_safe = $this->db->escape_like_str($prode);
        $whereInsumos .= ($primeiroInsumo ? '' : ' AND ') . "descricaoInsumo LIKE '%" . $prode_safe . "%'";
        $whereProdutos .= ($primeiroProduto ? '' : ' AND ') . "descricao LIKE '%" . $prode_safe . "%'";
        $primeiroInsumo = false;
        $primeiroProduto = false;
    }
    if (!empty($pne)) {
        $pne_safe = $this->db->escape_str($pne);
        $whereInsumos .= ($primeiroInsumo ? '' : ' AND ') . "pn_insumo = '" . $pne_safe . "'";
        $whereProdutos .= ($primeiroProduto ? '' : ' AND ') . "pn = '" . $pne_safe . "'";
        $primeiroInsumo = false;
        $primeiroProduto = false;
    }
    if (!empty($idOse)) {
        $idOse_safe = (int)$idOse;
        $whereInsumos .= ($primeiroInsumo ? '' : ' AND ') . "idOs = " . $idOse_safe;
        $whereProdutos .= ($primeiroProduto ? '' : ' AND ') . "idOs = " . $idOse_safe;
        $primeiroInsumo = false;
        $primeiroProduto = false;
    }
    if (!empty($idEmpresae)) {
        $idEmpresae_safe = (int)$idEmpresae;
        $whereInsumos .= ($primeiroInsumo ? '' : ' AND ') . "emitente = " . $idEmpresae_safe;
        $whereProdutos .= ($primeiroProduto ? '' : ' AND ') . "emitente = " . $idEmpresae_safe;
        $primeiroInsumo = false;
        $primeiroProduto = false;
    }
    if (!empty($idDepartamentoe)) {
        $idDepartamentoe_safe = (int)$idDepartamentoe;
        $whereInsumos .= ($primeiroInsumo ? '' : ' AND ') . "departamento = " . $idDepartamentoe_safe;
        $whereProdutos .= ($primeiroProduto ? '' : ' AND ') . "departamento = " . $idDepartamentoe_safe;
        $primeiroInsumo = false;
        $primeiroProduto = false;
    }
    if (!empty($local)) {
        $local_safe = $this->db->escape_like_str($local);
        $whereInsumos .= ($primeiroInsumo ? '' : ' AND ') . "local LIKE '%" . $local_safe . "%'";
        $whereProdutos .= ($primeiroProduto ? '' : ' AND ') . "local LIKE '%" . $local_safe . "%'";
        $primeiroInsumo = false;
        $primeiroProduto = false;
    }
    if (!empty($unidades)) {
        $unidades_safe = (int)$unidades;
        $whereInsumos .= ($primeiroInsumo ? '' : ' AND ') . "quantidade = " . $unidades_safe;
        $whereProdutos .= ($primeiroProduto ? '' : ' AND ') . "quantidadeEstoque = " . $unidades_safe;
        $primeiroInsumo = false;
        $primeiroProduto = false;
    }

    // Obtenha os dados dos produtos filtrados
    $produtosFiltradosInsumos = $this->almoxarifado_model->getEstoqueFilter($whereInsumos);
    $produtosFiltradosProdutos = $this->almoxarifado_model->getEstoqueFilterProdutos($whereProdutos);
    $produtosFiltrados = array_merge($produtosFiltradosInsumos, $produtosFiltradosProdutos);

    $resultadoComEstatisticas = array();

    $idsProdutosFiltrados = array_column($produtosFiltrados, 'idProduto');

    if (!empty($idsProdutosFiltrados)) {
        $estatisticasPorId = [];
        $estatisticasAgregadas = $this->produtos_model->getEstatisticasConsultasPorListaIds($idsProdutosFiltrados);
        if ($estatisticasAgregadas) {
            $estatisticasPorId['geral'] = $estatisticasAgregadas;
        }

        foreach ($produtosFiltrados as $produto) {
            $estatisticasProduto = $this->produtos_model->getEstatisticasConsulta($produto->idProduto);
            $produtoComEstatisticas = (array) $produto;
            $produtoComEstatisticas['total_consultas'] = $estatisticasProduto ? $estatisticasProduto->total_consultas : 0;
            $produtoComEstatisticas['estoque_zero'] = $estatisticasProduto ? $estatisticasProduto->estoque_zero : 0;
            $produtoComEstatisticas['estoque_maior_igual_1'] = $estatisticasProduto ? $estatisticasProduto->estoque_maior_igual_1 : 0;
            $resultadoComEstatisticas[] = $produtoComEstatisticas;
        }
    }

    $resposta = array(
        'produtos' => $resultadoComEstatisticas,
        'estatisticas_gerais' => isset($estatisticasPorId['geral']) ? $estatisticasPorId['geral'] : (object) ['total_consultas' => 0, 'estoque_zero' => 0, 'estoque_maior_igual_1' => 0]
    );

    echo json_encode($resposta);
}





////////////////////////////////////////////////////////////////
// Funções auxiliares para converter as cláusulas WHERE para buscar apenas os IDs dos produtos
private function converterWhereParaIdProduto($where) {
    $newWhere = str_replace(" insumos.descricaoInsumo like '%", " insumos.idInsumos like '%", $where);
    $newWhere = str_replace(" and insumos.descricaoInsumo like '%", " and insumos.idInsumos like '%", $newWhere);
    $newWhere = str_replace(" almo_estoque.idOs = ", " almo_estoque.idOs = ", $newWhere);
    $newWhere = str_replace(" and almo_estoque.idOs = ", " and almo_estoque.idOs = ", $newWhere);
    $newWhere = str_replace(" almo_estoque.idEmitente = ", " almo_estoque.idEmitente = ", $newWhere);
    $newWhere = str_replace(" and almo_estoque.idEmitente = ", " and almo_estoque.idEmitente = ", $newWhere);
    $newWhere = str_replace(" insumos.pn_insumo = '", " insumos.idInsumos = '", $newWhere);
    $newWhere = str_replace(" and insumos.pn_insumo = '", " and insumos.idInsumos = '", $newWhere);
    $newWhere = str_replace(" almo_estoque.idLocal = ", " almo_estoque.idLocal = ", $newWhere);
    $newWhere = str_replace(" and almo_estoque.idLocal = ", " and almo_estoque.idLocal = ", $newWhere);
    $newWhere = str_replace(" almo_estoque_departamento.idAlmoEstoqueDep = ", " almo_estoque_departamento.idAlmoEstoqueDep = ", $newWhere);
    $newWhere = str_replace(" and almo_estoque_departamento.idAlmoEstoqueDep = ", " and almo_estoque_departamento.idAlmoEstoqueDep = ", $newWhere);
    $newWhere = str_replace(" almo_estoque_locais.local like '%", " almo_estoque_locais.idLocal like '%", $newWhere);
    $newWhere = str_replace(" and almo_estoque_locais.local like '%", " and almo_estoque_locais.idLocal like '%", $newWhere);
    $newWhere = str_replace(" almo_estoque.quantidade > 0", "", $newWhere);
    $newWhere = str_replace(" os.unid_execucao in (", " os.unid_execucao in (", $newWhere);
    $newWhere = str_replace(" and os.unid_execucao in (", " and os.unid_execucao in (", $newWhere);
    $newWhere = preg_replace('/^ and /i', '', trim($newWhere));
    return trim($newWhere);
}

private function converterWhereParaIdProdutoProdutos($where) {
    $newWhere = str_replace(" produtos.descricao like '%", " produtos.idProdutos like '%", $where);
    $newWhere = str_replace(" and produtos.descricao like '%", " and produtos.idProdutos like '%", $newWhere);
    $newWhere = str_replace(" almo_estoque_produtos.idOs = ", " almo_estoque_produtos.idOs = ", $newWhere);
    $newWhere = str_replace(" and almo_estoque_produtos.idOs = ", " and almo_estoque_produtos.idOs = ", $newWhere);
    $newWhere = str_replace(" almo_estoque_produtos.idEmitente = ", " almo_estoque_produtos.idEmitente = ", $newWhere);
    $newWhere = str_replace(" and almo_estoque_produtos.idEmitente = ", " and almo_estoque_produtos.idEmitente = ", $newWhere);
    $newWhere = str_replace(" produtos.pn = '", " produtos.idProdutos = '", $newWhere);
    $newWhere = str_replace(" and produtos.pn = '", " and produtos.idProdutos = '", $newWhere);
    $newWhere = str_replace(" almo_estoque_produtos.idLocal = ", " almo_estoque_produtos.idLocal = ", $newWhere);
    $newWhere = str_replace(" and almo_estoque_produtos.idLocal = ", " and almo_estoque_produtos.idLocal = ", $newWhere);
    $newWhere = str_replace(" almo_estoque_departamento.idAlmoEstoqueDep = ", " almo_estoque_departamento.idAlmoEstoqueDep = ", $newWhere);
    $newWhere = str_replace(" and almo_estoque_departamento.idAlmoEstoqueDep = ", " and almo_estoque_departamento.idAlmoEstoqueDep = ", $newWhere);
    $newWhere = str_replace(" almo_estoque_locais.local like '%", " almo_estoque_locais.idLocal like '%", $newWhere);
    $newWhere = str_replace(" and almo_estoque_locais.local like '%", " and almo_estoque_locais.idLocal like '%", $newWhere);
    $newWhere = str_replace(" almo_estoque_produtos.quantidade > 0", "", $newWhere);
    $newWhere = str_replace(" os.unid_execucao in (", " os.unid_execucao in (", $newWhere);
    $newWhere = str_replace(" and os.unid_execucao in (", " and os.unid_execucao in (", $newWhere);
    $newWhere = preg_replace('/^ and /i', '', trim($newWhere));
    return trim($newWhere);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////   

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function visualizar_produto($idProduto)
    {
        $this->load->model('produtos_model');

        // Busca produto
        $produto = $this->produtos_model->getProdutoById($idProduto);
        if (!$produto) {
            show_404();
            return;
        }

        // Consulta estoque
        $resultado = $this->almoxarifado_model->getEstoqueByProduto($idProduto);

        // Log da consulta (se encontrou)
        /*if (!empty($resultado)) {
            foreach ($resultado as $r) {
                // Garante que o objeto tenha a propriedade idProduto
                if (isset($r->idProduto)) {
                    $this->db->insert('consulta_estoque_log', array(
                        'idProduto' => $r->idProduto,
                        'quantidade_estoque' => isset($r->quantidade) ? $r->quantidade : null,
                        'idUsuario' => $this->session->userdata('id'),
                        'ip_consulta' => $this->input->ip_address(),
                        'data_consulta' => date('Y-m-d H:i:s')
                    ));
                }
            }*/
			
			
        

$json = array('produto' => $produto, 'estoque' => $resultado);
echo json_encode($json);
return; // Importante para evitar outras saídas

    // Aqui você pode retornar a view ou resultado, se necessário
}



//////////////////////////////registra consulta contador/////////////////////


public function Busca_Estoque_Filtro()
{
    $this->load->library('form_validation');
    $this->data['custom_error'] = '';
    $this->load->model(array(
        'orcamentos_model',
        'estoque_model',
        'insumos_model',
        'produtos_model',
        'almoxarifado_model'
    ));

    $whereClauses = array();
    $whereProdClauses = array();

    $post = $this->input->post();

    if (!empty($post["prode"])) {
        $desc = $this->db->escape_like_str($post["prode"]);
        $whereClauses[] = "insumos.descricaoInsumo LIKE '%" . $desc . "%'";
        $whereProdClauses[] = "produtos.descricao LIKE '%" . $desc . "%'";
    }

    if (!empty($post["idOs"])) {
        $idOs = (int)$post["idOs"];
        $whereClauses[] = "almo_estoque.idOs = " . $idOs;
        $whereProdClauses[] = "almo_estoque_produtos.idOs = " . $idOs;
    }

    if (!empty($post["idEmpresae"])) {
        $idEmitente = (int)$post["idEmpresae"];
        $whereClauses[] = "almo_estoque.idEmitente = " . $idEmitente;
        $whereProdClauses[] = "almo_estoque_produtos.idEmitente = " . $idEmitente;
    }

    if (!empty($post["pn"])) {
        $pn = $this->db->escape($post["pn"]);
        $whereClauses[] = "insumos.pn_insumo = " . $pn;
        $whereProdClauses[] = "produtos.pn = " . $pn;
    }

    if (!empty($post["idLocale"])) {
        $idLocal = (int)$post["idLocale"];
        $whereClauses[] = "almo_estoque.idLocal = " . $idLocal;
        $whereProdClauses[] = "almo_estoque_produtos.idLocal = " . $idLocal;
    }

    if (!empty($post["idDepartamentoe"])) {
        $idDep = (int)$post["idDepartamentoe"];
        $whereClauses[] = "almo_estoque_departamento.idAlmoEstoqueDep = " . $idDep;
        $whereProdClauses[] = "almo_estoque_departamento.idAlmoEstoqueDep = " . $idDep;
    }

    if (!empty($post["local"])) {
        $local = $this->db->escape_like_str($post["local"]);
        $whereClauses[] = "almo_estoque_locais.local LIKE '%" . $local . "%'";
        $whereProdClauses[] = "almo_estoque_locais.local LIKE '%" . $local . "%'";
    }

    if (!empty($post["unidades"])) {
        $whereClauses[] = "os.unid_execucao IN (" . $post["unidades"] . ")";
        $whereProdClauses[] = "os.unid_execucao IN (" . $post["unidades"] . ")";
    }

    if (empty($post["pn"])) {
        $whereClauses[] = "almo_estoque.quantidade >= 0";
        $whereProdClauses[] = "almo_estoque_produtos.quantidade >= 0";
    }

    $where = implode(" AND ", $whereClauses);
    $whereProd = implode(" AND ", $whereProdClauses);

    $estoqueInsumos = $this->almoxarifado_model->getEstoqueFilter($where);
    $estoqueProdutos = $this->almoxarifado_model->getEstoqueFilterProdutos($whereProd);

    $resultadoEstoque = $this->unificarEstoques(array_merge($estoqueInsumos, $estoqueProdutos));

    $estoqueAgrupado = array(); // [idProduto => [registros]]

    foreach ($resultadoEstoque as $item) {
        if (!isset($item->idProduto)) continue;
        $idProduto = $item->idProduto;
        if (!isset($estoqueAgrupado[$idProduto])) {
            $estoqueAgrupado[$idProduto] = array();
        }
        $estoqueAgrupado[$idProduto][] = $item;
    }

    $itensParaLog = array();

    foreach ($estoqueAgrupado as $idProduto => $itens) {
        $temPositivo = false;
        foreach ($itens as $item) {
            if ($item->quantidade >= 1) {
                $temPositivo = true;
                break;
            }
        }

        if ($temPositivo) {
            // Grava todos com quantidade >= 1 (mesmo idProduto, diferentes locais)
            foreach ($itens as $item) {
                if ($item->quantidade >= 1) {
                    $itensParaLog[] = $item;
                }
            }
        } else {
            // Grava apenas um com quantidade = 0
            $itensParaLog[] = $itens[0];
        }
    }

    // Grava no log
    foreach ($itensParaLog as $r) {
        $dadosLog = array(
            'idProduto' => $r->idProduto,
            'idLocal' => isset($r->idLocal) ? $r->idLocal : null,
            'quantidade_estoque' => ($r->quantidade >= 1) ? 1 : 0,
            'idUsuario' => $this->session->userdata('id'),
            'ip_consulta' => $this->input->ip_address(),
            'data_consulta' => date('Y-m-d H:i:s')
        );
        $this->db->insert('consulta_estoque_log', $dadosLog);
    }

    // Adiciona estatísticas por produto
    $resultadoComEstatisticas = array();
    foreach ($itensParaLog as $item) {
        $estatisticas = $this->produtos_model->getEstatisticasConsulta($item->idProduto);
        $item->total_consultas = isset($estatisticas->total_consultas) ? $estatisticas->total_consultas : 0;
        $item->estoque_zero = isset($estatisticas->estoque_zero) ? $estatisticas->estoque_zero : 0;
        $item->estoque_maior_igual_1 = isset($estatisticas->estoque_maior_igual_1) ? $estatisticas->estoque_maior_igual_1 : 0;
        $resultadoComEstatisticas[] = $item;
    }

    echo json_encode(array('result' => true, 'resultado' => $resultadoComEstatisticas));
}
	
	
	
	
	
	
	
	
	
	
    public function cadastrarSaidas(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){
            $this->session->set_flashdata('error','Você não tem permissão para cadastrar estoque em Almoxarifado.');
            redirect(base_url());
        } 
        $this->data['custom_error'] = '';
        $idUser = $this->session->userdata('idUsuarios');
        $assinatura = $this->input->post("assinatura");
        if(!empty($assinatura)){
            $encoded_image = explode(",", $assinatura)[1];
            $decoded_image = base64_decode($encoded_image);
            $target_dir = "./assets/assinaturas/";
            $target_dir2 = "assets/assinaturas/";
            $nomeAssinatura = $this->generateRandomString().".png";
            $target_file = $target_dir.$nomeAssinatura;
            $target_file2 = $target_dir2.$nomeAssinatura;
            file_put_contents($target_file, $decoded_image);
        }else{
            $target_file2 = null;
        }
        for($x=0;$x<count($this->input->post('idAlmoEstoque_'));$x++){
            if(!empty($this->input->post('idAlmoEstoque_')[$x])){
                $est = $this->input->post('idAlmoEstoque_')[$x];
            }else{
                $est="";
            }
            if(!empty($this->input->post('qtd_')[$x])){
                $qtd = $this->input->post('qtd_')[$x];
            }else{
                $qtd="";
            }
            if(!empty($this->input->post('idEmitenteDest_')[$x])){
                $emp = $this->input->post('idEmitenteDest_')[$x];
            }else{
                $emp="";
            } 
            if(!empty($this->input->post('idSetor_')[$x])){
                $set = $this->input->post('idSetor_')[$x];
            }else{
                $set="";
            }
            if(!empty($this->input->post('user_')[$x])){
                $user = $this->input->post('user_')[$x];
            }else{
                $user="";
            }
            if(!empty($this->input->post('idOs_')[$x])){
                $idOs = $this->input->post('idOs_')[$x];
            }else{
                $idOs="";
            }
            if(!empty($this->input->post('obs_')[$x])){
                $obs = $this->input->post('obs_')[$x];
            }else{
                $obs =null;
            }
            
            $this->almoxarifado_model->cadastrarSaidas($est,$qtd,$emp,$set,$idUser,$user,$idOs,$obs,$target_file2);
            $this->data["itemEstoque"]=$this->almoxarifado_model->getItemEstoque($est);
            //echo("<script>console.log('Quantidade: ".$this->data["itemEstoque"][0]->quantidade."');</script>");
            $newQtd = $this->data["itemEstoque"][0]->quantidade - $this->input->post('qtd_')[$x];
            $this->almoxarifado_model->updateEstoque($this->data["itemEstoque"][0]->idAlmoEstoque,$newQtd);
        }
        setcookie("tabelaSaida", "", time() - 3600,"/");
        $this->session->set_flashdata('success','Saídas cadastradas com sucesso.');
        redirect(base_url() . 'index.php/almoxarifado/almoxarifado');
        //$this->recarregarDadosEstoque();
    }
    public function relatorio(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vAlmoxarifado')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar Almoxarifado.');
            redirect(base_url());
        }
        $whereEntrada = "";
        $whereSaida = "";
        $primeiro = true;
        if(!empty($this->input->post('idEmpresaRel'))){
            if($primeiro){
                $whereEntrada = "where almo_estoque_entrada.idEmitente = ".$this->input->post('idEmpresaRel');
                $whereSaida = "where almo_estoque.idEmitente = ".$this->input->post('idEmpresaRel');
                $primeiro = false;
            }else{
                $whereEntrada = $whereEntrada." and almo_estoque_entrada.idEmitente = ".$this->input->post('idEmpresaRel');
                $whereSaida = $whereSaida." and almo_estoque.idEmitente = ".$this->input->post('idEmpresaRel');
            }
        }
        if(!empty($this->input->post('idDescRel'))){
            if($primeiro){
                $whereEntrada = "where insumos.idInsumos = ".$this->input->post('idDescRel');
                $whereSaida = "where insumos.idInsumos = ".$this->input->post('idDescRel');
                $primeiro = false;
            }else{
                $whereEntrada = $whereEntrada." and insumos.idInsumos = ".$this->input->post('idDescRel');
                $whereSaida = $whereSaida." and insumos.idInsumos = ".$this->input->post('idDescRel');
            }
        }
        if(!empty($this->input->post('idUsuCad'))){
            if($primeiro){
                $whereEntrada = "where usuarios.idUsuarios = ".$this->input->post('idUsuCad');
                $whereSaida = "where usuarios.idUsuarios = ".$this->input->post('idUsuCad');
                $primeiro = false;
            }else{
                $whereEntrada = $whereEntrada." and usuarios.idUsuarios = ".$this->input->post('idUsuCad');
                $whereSaida = $whereSaida." and usuarios.idUsuarios = ".$this->input->post('idUsuCad');
            }
        }
        $dataeinicial = $this->input->post('dataInicial');
         $dataefinal = $this->input->post('dataFinal');
        if(!empty($dataeinicial)&&!empty($dataefinal)){
            echo("<script>console.log(".$dataeinicial.");</script>");
            $dataeinicial2 = explode('/', $this->input->post("dataInicial"));
            $dataeinicial2 = $dataeinicial2[2].'-'.$dataeinicial2[1].'-'.$dataeinicial2[0];
            $dataefinal2 = explode('/', $this->input->post("dataFinal"));
            $dataefinal2 = $dataefinal2[2].'-'.$dataefinal2[1].'-'.$dataefinal2[0];
            if($primeiro){
                $whereEntrada = "where almo_estoque_entrada.data_entrada BETWEEN '$dataeinicial2 00:00:00' AND '$dataefinal2 23:59:59'";
                $whereSaida = "where almo_estoque_saida.data_saida BETWEEN '$dataeinicial2 00:00:00' AND '$dataefinal2 23:59:59'";
                $primeiro = false;
            }else{
                $whereEntrada = $whereEntrada." and almo_estoque_entrada.data_entrada BETWEEN '$dataeinicial2 00:00:00' AND '$dataefinal2 23:59:59'";
                $whereSaida = $whereSaida." and almo_estoque_saida.data_saida BETWEEN '$dataeinicial2 00:00:00' AND '$dataefinal2 23:59:59'";
            }
        }
        if(!empty($this->input->post('idDepartamentoRel'))){
            if($primeiro){
                $whereEntrada = "where almo_estoque_entrada.idDepartamento = ".$this->input->post('idDepartamentoRel');
                $whereSaida = "where almo_estoque_departamento.idAlmoEstoqueDep = ".$this->input->post('idDepartamentoRel');
                $primeiro = false;
            }else{
                $whereEntrada = $whereEntrada." and almo_estoque_entrada.idDepartamento = ".$this->input->post('idDepartamentoRel');
                $whereSaida = $whereSaida." and almo_estoque_departamento.idAlmoEstoqueDep = ".$this->input->post('idDepartamentoRel');
            }
        }
        $primeiroEntrada = $primeiro;
        $primeiroSaida = $primeiro;
        if(!empty($this->input->post('nfRel'))){
            if($primeiroEntrada){
                $whereEntrada = "where almo_estoque_entrada.nf = ".$this->input->post('nfRel');
                $primeiroEntrada = false;
            }else{
                $whereEntrada = $whereEntrada." and almo_estoque_entrada.nf = ".$this->input->post('nfRel');
            }
        }
        if(!empty($this->input->post('idOsRel'))){
            if($primeiroEntrada){
                $whereEntrada = "where almo_estoque_entrada.idOs = ".$this->input->post('idOsRel');
                $primeiroEntrada = false;
            }else{
                $whereEntrada = $whereEntrada." and almo_estoque_entrada.idOs = ".$this->input->post('idOsRel');
            }
        }



        if(!empty($this->input->post('idOsRelSa'))){
            if($primeiroSaida){
                $whereSaida = "where almo_estoque_saida.idOs = ".$this->input->post('idOsRelSa');
                $primeiroSaida = false;
            }else{
                $whereSaida = $whereSaida." and almo_estoque_saida.idOs = ".$this->input->post('idOsRelSa');
            }
        }
        if(!empty($this->input->post('idEmpresaDestRel'))){
            if($primeiroSaida){
                $whereSaida = "where almo_estoque_saida.idEmpresaDestino = ".$this->input->post('idEmpresaDestRel');
                $primeiroSaida = false;
            }else{
                $whereSaida = $whereSaida." and almo_estoque_saida.idEmpresaDestino = ".$this->input->post('idEmpresaDestRel');
            }
        }
        
        if(!empty($this->input->post('idSetorRel'))){
            if($primeiroSaida){
                $whereSaida = "where almo_estoque_saida.idSetor = ".$this->input->post('idSetorRel');
                $primeiroSaida = false;
            }else{
                $whereSaida = $whereSaida." and almo_estoque_saida.idSetor = ".$this->input->post('idSetorRel');
            }
        }
        
        
        $this->load->model('orcamentos_model');
        $this->load->model('estoque_model');
        $this->load->model('almoxarifado_model');
        $this->load->model('insumos_model');
        
        $idUser = $this->session->userdata('idUsuarios');
        $getUserDepartaentos = $this->almoxarifado_model->getDepartamentoUsuario($idUser);
        if(count($getUserDepartaentos)>0){
            $this->data['dados_departamento'] = $getUserDepartaentos;
        }else{
            $getUserDepartaentos = "";
            $this->data['dados_departamento'] = $this->almoxarifado_model->getDepartamento();
        } 
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        if(count($getUserEmpresa)>0){
            $this->data['dados_emitente'] = $getUserEmpresa;
        }else{
            $getUserEmpresa = "";
            $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
        }    
        $this->data['result'] = $this->almoxarifado_model->getEstoque();
        $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
        $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
        $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
        //$this->data['dados_saida'] = $this->almoxarifado_model->getSaida($whereSaida);
        $this->data['dados_categoria'] = $this->insumos_model->getCategoria();
        //$this->data['dadosRelatorio'] = $this->almoxarifado_model->getRelatorioInicial2();
        //$this->data['dados_entrada'] = $this->almoxarifado_model->getEntrada($whereEntrada);
        $this->data['dados_insumos'] = $this->insumos_model->getinsumosubcat2();
        $this->data['relatorio'] = true;
        $this->data['view'] = 'almoxarifado/almoxarifado';
       	$this->load->view('tema/topo',$this->data);
    }
    
    public function cadastrarLocal(){
        $this->load->library('form_validation');
        //echo("<script>console.log('Quantidade: test');</script>"); 
        $empresa = $this->input->post('empresa');
        $departamento = $this->input->post('departamento');
        $local = $this->input->post('local');
        if(empty($empresa) || empty($local ) || empty($departamento )){
           $json =  array('result'=>false,'msggg'=>'Preencha os dados corretamente.');
           echo json_encode($json);
        }else {
            $this->almoxarifado_model->cadastrarLocal($empresa,$local,$departamento);        
            $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
            $json = array('result'=>true,'dados_locais'=>$this->data['dados_locais']);
            echo json_encode($json);
        }
       
    }
    public function cadastrarLocal2(){
        $this->load->library('form_validation');
        //echo("<script>console.log('Quantidade: test');</script>"); 
        $empresa = $this->input->post('empresa');
        $departamento = $this->input->post('depart');
        $local = $this->input->post('local');
        if(empty($empresa) || empty($local ) || empty($departamento )){
           $json =  array('result'=>false,'msggg'=>'Preencha os dados corretamente.');
           echo json_encode($json);
        }else {
            $resuls=$this->almoxarifado_model->getLocal($empresa,$departamento,$local);
            if(!empty($resuls)){
                if(gettype($resuls)=='array'){
                    $idAlmoEstoqueLocal =  $resuls[0]->idAlmoEstoqueLocais;
                }else{
                    $idAlmoEstoqueLocal = $resuls->idAlmoEstoqueLocais;
                }
            }
            if( $this->almoxarifado_model->getLocal($empresa,$departamento,$local) == false){
                $idAlmoEstoqueLocal = $this->almoxarifado_model->cadastrarLocal($empresa,$local,$departamento); 
                $json = array('result'=>true,'idLocal'=>$idAlmoEstoqueLocal,"test"=>$resuls);
                echo json_encode($json);
            }else{
                $json = array('result'=>true,'idLocal'=>$idAlmoEstoqueLocal,"test"=>$resuls);
                echo json_encode($json);
            } 
            
        }
       
    }
    public function cadastrarLocal3($local,$departamento,$empresa){
        $this->load->library('form_validation');
        //echo("<script>console.log('Quantidade: test');</script>"); 
        if(empty($empresa) || empty($local ) || empty($departamento )){
           $json =  array('result'=>false,'msggg'=>'Preencha os dados corretamente.');
           echo json_encode($json);
           return;
        }else {
            $resuls=$this->almoxarifado_model->getLocal($empresa,$departamento,$local);
            if(!empty($resuls)){
                if(gettype($resuls)=='array'){
                    $idAlmoEstoqueLocal =  $resuls[0]->idAlmoEstoqueLocais;
                }else{
                    $idAlmoEstoqueLocal = $resuls->idAlmoEstoqueLocais;
                }
            }
            if( $this->almoxarifado_model->getLocal($empresa,$departamento,$local) == false){
                $idAlmoEstoqueLocal = $this->almoxarifado_model->cadastrarLocal($empresa,$local,$departamento); 
                $json = array('result'=>true,'idLocal'=>$idAlmoEstoqueLocal,"test"=>$resuls);
                return $idAlmoEstoqueLocal;
                //echo json_encode($json);
            }else{
                $json = array('result'=>true,'idLocal'=>$idAlmoEstoqueLocal,"test"=>$resuls);
                //echo json_encode($json);
                return $idAlmoEstoqueLocal;
            }
            
        }
       
    }
    public function cadastrarUsuario(){
        $this->load->library('form_validation');
        //echo("<script>console.log('Quantidade: test');</script>"); 
        $empresa = $this->input->post('empresa');
        $setor = $this->input->post('setor');
        $nome = $this->input->post('nome');
        $cpf = $this->input->post('cpf');
        if(empty($empresa) || empty($setor) || empty($nome)){
           $json =  array('result'=>false,'msggg'=>'Preencha os dados corretamente.');
           echo json_encode($json);
        }else {
            $cod = $this->almoxarifado_model->cadastrarUsuario($empresa,$setor,$nome,$cpf);        
            $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
            $json = array('result'=>true,'cod'=>$cod);//,'dados_locais'=>$this->data['dados_locais']);
            echo json_encode($json);
        }
       
    }
    public function cadastrarInsumos(){
        $this->load->library('form_validation');
        //echo("<script>console.log('Quantidade: test');</script>"); 
        $descricao = $this->input->post('descricao');
        $estoqueMinimo = $this->input->post('estoquemin');
        $pn = $this->input->post('pn');
        $subcat = $this->input->post('subcat');
        if(empty($descricao) ||  empty($subcat)){
           $json =  array('result'=>false,'msggg'=>'Preencha os dados corretamente.');
           echo json_encode($json);
        }else {
            $idInsumo = $this->almoxarifado_model->cadastrarInsumos($descricao,$estoqueMinimo,$subcat,$pn );        
            //$this->data['dados_insumos'] = $this->almoxarifado_model->getUsuario();
            $json = array('result'=>true,'idInsumo'=>$idInsumo);//,'dados_locais'=>$this->data['dados_locais']);
            echo json_encode($json);
        }
       
    }
    public function cadastrarInsumos2(){
        $this->load->library('form_validation');
        
        $this->load->model('insumos_model');
        //echo("<script>console.log('Quantidade: test');</script>"); 
        $descricao = $this->input->post('descricao');
        $estoqueMinimo = $this->input->post('estoquemin');
        $pn = $this->input->post('pn');
        $subcat = $this->input->post('subcat');
        $this->data["insum"] = $this->insumos_model->getBydescricaoInsumo($descricao,"");
        $idInsumo = false;
        if(!empty($this->data["insum"])){
            if(gettype($this->data["insum"])=='array'){
                $idInsumo =  $this->data["insum"][0]->idInsumos;
            }else{
                $idInsumo = $this->data["insum"]->idInsumos;
            }
        }
        
        if($idInsumo == true){
           $json = array('result'=>true,'idInsumo'=>$idInsumo);
           echo json_encode($json);
        }else {
            $idInsumo = $this->almoxarifado_model->cadastrarInsumos($descricao,$estoqueMinimo,$subcat,$pn );        
            //$this->data['dados_insumos'] = $this->almoxarifado_model->getUsuario();
            $json = array('result'=>true,'idInsumo'=>$idInsumo);//,'dados_locais'=>$this->data['dados_locais']);
            echo json_encode($json);
        }
       
    }
    public function excluir_local(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dAlmoxarifado')){
            $this->session->set_flashdata('error','Você não tem permissão para excluir itens vinculados ao Almoxarifado.');
            redirect(base_url());
        }
        $idAlmoLocal =  $this->input->post('idAlmoEstoqueLocais');
        $estoqueLocal = $this->almoxarifado_model->getEstoqueFromLocal($idAlmoLocal);
        $soma = 0;
        if(count($estoqueLocal)>0){
            foreach($estoqueLocal as $r){
            $soma = $r->quantidade + $soma;
            }
            if($soma>0){
                echo("<script>alert('Esse local não pode ser excluído, pois, possui produtos vinculados à ele.');</script>");
                $this->recarregarDadosEstoque();
            return;
            }
        }
        $this->almoxarifado_model->delete("almo_estoque_locais","idAlmoEstoqueLocais",$idAlmoLocal);
        $this->load->model('orcamentos_model');
        $this->load->model('estoque_model');
        $this->load->model('almoxarifado_model');
        $this->load->model('insumos_model');
        $idUser = $this->session->userdata('idUsuarios');
        $getUserDepartaentos = $this->almoxarifado_model->getDepartamentoUsuario($idUser);
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        if(count($getUserEmpresa)>0){
            $this->data['dados_emitente'] = $getUserEmpresa;
        }else{
            $getUserEmpresa = "";
            $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
        }
        if(count($getUserDepartaentos)>0){
            $this->data['dados_departamento'] = $getUserDepartaentos;
        }else{
            $getUserDepartaentos = "";
            $this->data['dados_departamento'] = $this->almoxarifado_model->getDepartamento();
        }      
        $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
        $this->data['result'] = $this->almoxarifado_model->getEstoque();
        $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
        $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
        //$this->data['dados_saida'] = $this->almoxarifado_model->getSaida();
        $this->data['dados_categoria'] = $this->insumos_model->getCategoria();
        //$this->data['dadosRelatorio'] = $this->almoxarifado_model->getRelatorioInicial2();
        //$this->data['dados_entrada'] = $this->almoxarifado_model->getEntrada();
        $this->data['dados_insumos'] = $this->insumos_model->getinsumosubcat2();
        $this->session->set_flashdata('success','Local excluído com sucesso.');
        redirect(base_url() . 'index.php/almoxarifado/almoxarifado/local');
        //$this->data['view'] = 'almoxarifado/almoxarifado';
       	//$this->load->view('tema/topo',$this->data);


        // echo("<script>console.log('Emitente:".$soma."');</script>");
    }
    public function busca_estoqueGeral_filtro(){
        $departamento = $this->input->post('departamento');
        $empresa = $this->input->post('empresa');
        $descricao = $this->input->post('descricao');
        $pn = $this->input->post('pn');
        $where = '';
        $whereProd = '';
        $primeiro = true;
        if(!empty($departamento)){
            if($primeiro){
                $where = "where almo_estoque_departamento.idAlmoEstoqueDep = ".$departamento;
                $whereProd = "where almo_estoque_departamento.idAlmoEstoqueDep = ".$departamento;
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_departamento.idAlmoEstoqueDep = ".$departamento;
                $whereProd = $whereProd." and almo_estoque_departamento.idAlmoEstoqueDep = ".$departamento;
            }
        }
        if(!empty($pn)){
            if($primeiro){
                $where = "where insumos.pn_insumo = '".$pn."'";
                $whereProd = "where produtos.pn = '".$pn."'";
                $primeiro = false;
            }else{
                $where = $where." and insumos.pn_insumo = '".$pn."'";
                $whereProd = $whereProd." and produtos.pn = '".$pn."'";
            }
        }
        if(!empty($empresa)){
            if($primeiro){
                $where = "where emitente.id = ".$empresa;
                $whereProd = "where emitente.id = ".$empresa;
                $primeiro = false;
            }else{
                $where = $where." and emitente.id = ".$empresa;
                $whereProd = $whereProd." and emitente.id = ".$empresa;
            }
        }
        if(!empty($descricao)){
            if($primeiro){
                $where = "where insumos.descricaoInsumo like '%".$descricao."%'";
                $whereProd = "where produtos.descricao like '%".$descricao."%'";
                $primeiro = false;
            }else{
                $where = $where." and insumos.descricaoInsumo like '%".$descricao."%'";
                $whereProd = $whereProd." and produtos.descricao like '%".$descricao."%'";
            }
        }
        //$result = $this->almoxarifado_model->getRelatorioInicial2($where);
        $result = $this->unificarRelatorio(array_merge($this->almoxarifado_model->getRelatorioInicial2($where),$this->almoxarifado_model->getRelatorioInicial2Produtos($whereProd)));
        $json = array('result'=>true,'resultado'=>$result);
        echo json_encode($json);
    }
    public function cadastrarCatESubcat(){
        $categoria = $this->input->post('nomeCategoria');
        $subCategoria = $this->input->post('subCategoria');
        $this->load->model('insumos_model');
        if( $this->insumos_model->getBydescricaoCategoria($categoria) == true)
        {
            $json =  array('result'=>false,'msggg'=>'Essa categoria já existe.');
            echo json_encode($json);
            return;
        }
        $idCategoria = $this->almoxarifado_model->cadastrarCategoria($categoria);
        $idSubcategoria = $this->almoxarifado_model->cadastrarSubcategoria($subCategoria,$idCategoria);

        $json = array('result'=>true,"idSubcategoria"=>$idSubcategoria,"descricaoCategoria"=>$categoria,"descricaoSubcategoria"=>$subCategoria,"idCategoria"=>$idCategoria);
        echo json_encode($json);
    }
    public function cadastrarCatESubcat2(){
        $categoria = $this->input->post('nomeCategoria');
        $subCategoria = $this->input->post('subCategoria');
        $this->load->model('insumos_model');
        $idCategoria = false;
        $this->data['cat'] = $this->insumos_model->getBydescricaoCategoria($categoria);
        if(!empty($this->data['cat'])){
            if(gettype($this->data['cat']) == 'array'){
                $idCategoria = $this->data['cat'][0]->idCategoria;
            }else{
                $idCategoria = $this->data['cat']->idCategoria;
            }
        }
        $idSubcategoria = false;
        if( $this->insumos_model->getBydescricaoCategoria($categoria) == true)
        {
            //$this->data["subCat"] = $this->insumos_model->getBydescricaoSubcategoria($subCategoria,$idCategoria)->idSubcategoria;
            if($this->insumos_model->getBydescricaoSubcategoria($subCategoria,$idCategoria) == true){
                $idSubcategoria =  $this->insumos_model->getBydescricaoSubcategoria($subCategoria,$idCategoria)->idSubcategoria;
            }

            if($idSubcategoria == true){                
                $json = array('result'=>true,"idSubcategoria"=>$idSubcategoria,"descricaoCategoria"=>$categoria,"descricaoSubcategoria"=>$subCategoria,"idCategoria"=>$idCategoria);
                echo json_encode($json);
            }else{
                $idSubcategoria = $this->almoxarifado_model->cadastrarSubcategoria($subCategoria,$idCategoria);
                $json = array('result'=>true,"idSubcategoria"=>$idSubcategoria,"descricaoCategoria"=>$categoria,"descricaoSubcategoria"=>$subCategoria,"idCategoria"=>$idCategoria);
                echo json_encode($json);
            }
        }else{
            $idCategoria = $this->almoxarifado_model->cadastrarCategoria($categoria);
            $idSubcategoria = $this->almoxarifado_model->cadastrarSubcategoria($subCategoria,$idCategoria);

            $json = array('result'=>true,"idSubcategoria"=>$idSubcategoria,"descricaoCategoria"=>$categoria,"descricaoSubcategoria"=>$subCategoria,"idCategoria"=>$idCategoria);
            echo json_encode($json);
        }
    }

    public function cadastrarSubcat(){
        $categoria = $this->input->post('nomeCategoria');
        $subCategoria = $this->input->post('subCategoria');
        $idCategoria = $this->input->post('idCategoria');
        $this->load->model('insumos_model');
        if( $this->insumos_model->getBydescricaoSubcategoria($subCategoria,$idCategoria) == true)
        {
            $json =  array('result'=>false,'msggg'=>'Essa subcategoria já existe.');
            echo json_encode($json);
            return;
        }
        //$idCategoria = $this->almoxarifado_model->cadastrarCategoria($categoria);
        $idSubcategoria = $this->almoxarifado_model->cadastrarSubcategoria($subCategoria,$idCategoria);

        $json = array('result'=>true,"idSubcategoria"=>$idSubcategoria,"descricaoCategoria"=>$categoria,"descricaoSubcategoria"=>$subCategoria,"idCategoria"=>$idCategoria);
        echo json_encode($json);
    }
    public function cadastrarSubcat2(){
        $categoria = $this->input->post('nomeCategoria');
        $subCategoria = $this->input->post('subCategoria');
        $idCategoria = $this->input->post('idCategoria');
        $this->load->model('insumos_model');
        $this->data["subCat"] = $this->insumos_model->getBydescricaoSubcategoria($subCategoria,$idCategoria);
        $idSubcategoria = false;
        if(!empty($this->data["subCat"])){
            if(gettype($this->data["subCat"])=='array'){
                $idSubcategoria =  $this->data["subCat"][0]->idSubcategoria;
            }else{
                $idSubcategoria = $this->data["subCat"]->idSubcategoria;
            }
        }        

        if( $this->insumos_model->getBydescricaoSubcategoria($subCategoria,$idCategoria) == true)
        {
            $json = array('result'=>true,"idSubcategoria"=>$idSubcategoria,"descricaoCategoria"=>$categoria,"descricaoSubcategoria"=>$subCategoria,"idCategoria"=>$idCategoria);        
            echo json_encode($json);
            return;
        }
        //$idCategoria = $this->almoxarifado_model->cadastrarCategoria($categoria);
        $idSubcategoria = $this->almoxarifado_model->cadastrarSubcategoria($subCategoria,$idCategoria);

        $json = array('result'=>true,"idSubcategoria"=>$idSubcategoria,"descricaoCategoria"=>$categoria,"descricaoSubcategoria"=>$subCategoria,"idCategoria"=>$idCategoria);
        echo json_encode($json);
    }

    

    public function estoquePecas(){
        $this->load->model('orcamentos_model');
        $this->load->model('estoque_model');
        $this->load->model('almoxarifado_model');
        $this->load->model('insumos_model');
        $idUser = $this->session->userdata('idUsuarios');
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        if(count($getUserEmpresa)>0){
            $this->data['dados_emitente'] = $getUserEmpresa;
        }else{
            $getUserEmpresa = "";
            $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
        }
        $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
        $this->data['view'] = 'almoxarifado/estoquepeca';
        $this->load->view('tema/topo',$this->data);
    }
    public function autoCompleteInsumos2(){   

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteInsumos2($q);
        }
    }
    public function autoCompletePN2(){   

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompletePN2($q);
        }
    }

    public function autoCompleteProd(){   

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteProd($q);
        }
    }
    
    public function alterarLocalQtd(){
        $quantidade = $this->input->post('quantidade');
        $idAlmoEstoque = $this->input->post('idAlmoEstoque');
        $idLocal = $this->input->post('idLocal');
        $local = $this->input->post('local');
        $almoxarifado = $this->input->post('almoxarifado');
        //$almoxarifado = $this->input->post('almoxarifado');
        $departamento = $this->input->post('departamento');
        if($idAlmoEstoque == null || $idAlmoEstoque == "" ){
            $json = array('result'=>false,'msggg'=>"Informe o produto que deseja alterar.");        
            echo json_encode($json);
            return;
        }
        if($almoxarifado == "insumo"){
            $almoEstoque = $this->almoxarifado_model->getItemEstoque($idAlmoEstoque);
            $idEmitente2 = $almoEstoque[0]->idEmitente;
            if($quantidade > $almoEstoque[0]->quantidade || $quantidade <= 0){
                $json = array('result'=>false,'msggg'=>"Quantidade informada é inválida.");        
                echo json_encode($json);
                return;
            }
        }else{
            $almoEstoqueProd = $this->almoxarifado_model->getItemEstoqueProdutos($idAlmoEstoque);
            $idEmitente2 = $almoEstoqueProd[0]->idEmitente;
            if($quantidade > $almoEstoqueProd[0]->quantidade || $quantidade < 0){
                $json = array('result'=>false,'msggg'=>"Quantidade informada é inválida.");        
                echo json_encode($json);
                return;
            }
        }
        if($idLocal == "" || $idLocal == null){
            if($local != "" && $local != null){
                $this->data["localAl"] = $this->almoxarifado_model->getLocal($idEmitente2,$departamento,$local);
                if(!empty($this->data["localAl"])){
                    if(gettype($this->data["localAl"])=='array'){
                        $idLocal =  $this->data["localAl"][0]->idAlmoEstoqueLocais;
                    }else{
                        $idLocal = $this->data["localAl"]->idAlmoEstoqueLocais;
                    }
                }else{
                    $idLocal = $this->almoxarifado_model->cadastrarLocal($idEmitente2,$local,$departamento);
                }                
            }else{
                $idLocal = null;
            }
        }
        if($almoxarifado == "insumo"){
            if($almoEstoque[0]->idLocal == $idLocal){
                $json = array('result'=>false,'msggg'=>"Local inválido");        
                echo json_encode($json);
                return;
            }
        }else{
            if($almoEstoqueProd[0]->idLocal == $idLocal){
                $json = array('result'=>false,'msggg'=>"Local inválido");        
                echo json_encode($json);
                return;
            }
        }
        
        if($almoxarifado == "insumo"){
            $estoqueExistente = $this->almoxarifado_model->verificaPMEL($almoEstoque[0]->idProduto,$almoEstoque[0]->metrica,$almoEstoque[0]->comprimento,$almoEstoque[0]->volume,$almoEstoque[0]->peso,$almoEstoque[0]->dimensoesL,$almoEstoque[0]->dimensoesC,$almoEstoque[0]->dimensoesA,$almoEstoque[0]->idEmitente,$idLocal,$departamento,$almoEstoque[0]->idOs);
            if(count($estoqueExistente)<1){
                
                $idAlmoDestino = $this->almoxarifado_model->criarEstoque($almoEstoque[0]->idProduto,$almoEstoque[0]->metrica,$almoEstoque[0]->comprimento,$almoEstoque[0]->volume,$almoEstoque[0]->peso,$almoEstoque[0]->dimensoesL,$almoEstoque[0]->dimensoesC,$almoEstoque[0]->dimensoesA,$almoEstoque[0]->idEmitente,$idLocal,$quantidade,$departamento,$almoEstoque[0]->idOs);
                $newQtdEstoqueAntigo = $almoEstoque[0]->quantidade - $quantidade;
                $this->almoxarifado_model->updateEstoque($idAlmoEstoque,$newQtdEstoqueAntigo,$departamento);
                $idUser = $this->session->userdata('idUsuarios');
                $data = array(
                    "idAlmoOrigem"=>$idAlmoEstoque,
                    "idAlmoDestino"=>$idAlmoDestino,
                    "quantidade"=>$quantidade,
                    "data_editar"=>date('Y-m-d H:i:s'),
                    "idUsuario"=>$idUser
                );
                $this->almoxarifado_model->insertEditarLocal($data);
            }else {
                $newQtd = $quantidade + $estoqueExistente[0]->quantidade;
                $newQtdEstoqueAntigo = $almoEstoque[0]->quantidade - $quantidade;
                $this->almoxarifado_model->updateEstoque($idAlmoEstoque,$newQtdEstoqueAntigo,$departamento);
                $this->almoxarifado_model->updateEstoque($estoqueExistente[0]->idAlmoEstoque,$newQtd,$departamento);
                $idUser = $this->session->userdata('idUsuarios');
                $data = array(
                    "idAlmoOrigem"=>$idAlmoEstoque,
                    "idAlmoDestino"=>$estoqueExistente[0]->idAlmoEstoque,
                    "quantidade"=>$quantidade,
                    "data_editar"=>date('Y-m-d H:i:s'),
                    "idUsuario"=>$idUser
                );
                $this->almoxarifado_model->insertEditarLocal($data);
            }
            //$this->almoxarifado_model->updateLocalEQuantidade($idAlmoEstoque,$quantidade,$idLocal);
        }else{
            $verificacao = $this->almoxarifado_model->verificaPEDL($almoEstoqueProd[0]->idProduto,$almoEstoqueProd[0]->idEmitente,$departamento,$idLocal,$almoEstoqueProd[0]->idStatusProduto);
            if(count($verificacao )<1){
                $idAlmoDestino = $this->almoxarifado_model->criarEstoqueProduto($almoEstoqueProd[0]->idProduto,$quantidade,$almoEstoqueProd[0]->idEmitente,$departamento,$idLocal,null,$almoEstoqueProd[0]->idStatusProduto);
                $newQtdEstoqueAntigo = $almoEstoqueProd[0]->quantidade - $quantidade;
                $this->almoxarifado_model->updateEstoqueProduto($idAlmoEstoque,$newQtdEstoqueAntigo);
                $idUser = $this->session->userdata('idUsuarios');
                $data = array(
                    "idAlmoPOrigem"=>$idAlmoEstoque,
                    "idAlmoPDestino"=>$idAlmoDestino,
                    "quantidade"=>$quantidade,
                    "data_editar"=>date('Y-m-d H:i:s'),
                    "idUsuario"=>$idUser
                );
                $this->almoxarifado_model->insertPEditarLocal($data);
            }else {
                $newQtd = $verificacao[0]->quantidade + $quantidade;
                $newQtdEstoqueAntigo = $almoEstoqueProd[0]->quantidade - $quantidade;
                $this->almoxarifado_model->updateEstoqueProduto($idAlmoEstoque,$newQtdEstoqueAntigo);
                $this->almoxarifado_model->updateEstoqueProduto($verificacao[0]->idAlmoEstoqueProduto,$newQtd);
                $idUser = $this->session->userdata('idUsuarios');
                $data = array(
                    "idAlmoPOrigem"=>$idAlmoEstoque,
                    "idAlmoPDestino"=>$verificacao[0]->idAlmoEstoqueProduto,
                    "quantidade"=>$quantidade,
                    "data_editar"=>date('Y-m-d H:i:s'),
                    "idUsuario"=>$idUser
                );
                $this->almoxarifado_model->insertPEditarLocal($data);
            }
            //$this->almoxarifado_model->updateLocalEQuantidadeProduto($idAlmoEstoque,$quantidade,$idLocal);
        }
        $json = array('result'=>true,'msggg'=>"Alterado com sucesso."); 
        echo json_encode($json);
    }
    function relatorioAlmoxarifado(){
        $this->load->model('orcamentos_model');
        $this->load->model('estoque_model');
        $this->load->model('os_model');
        $this->data['dados_saida_insumo'] = $this->almoxarifado_model->getSaida();
        $this->data['dados_saida_produto'] = $this->almoxarifado_model->getSaidaProduto();
        
        $this->data['result'] = $this->unificarEstoques(array_merge($this->almoxarifado_model->getEstoque(),$this->almoxarifado_model->getEstoqueProduto()));
		
		$idsProdutos = array();
foreach ($this->data['result'] as $r) {
    $idsProdutos[] = $r->idProduto;
}
$this->data['estatisticas'] = $this->almoxarifado_model->getEstatisticasConsultasPorListaIdsAlmo($idsProdutos);

        $this->data['dados_entrada_insumo'] = $this->almoxarifado_model->getEntrada();
        $this->data['dados_entrada_produto'] = $this->almoxarifado_model->getEntradaProduto();
        $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
        $this->data['dadosRelatorio2'] = array();//$this->unificarRelatorio(array_merge($this->almoxarifado_model->getRelatorioInicial2(),$this->almoxarifado_model->getRelatorioInicial2Produtos()));
        $result = array();//$this->unificarRelatorioDet(array_merge($this->almoxarifado_model->getRelatorioInicial(),$this->almoxarifado_model->getRelatorioInicialProdutos()));
        $this->data['dados_saida'] = array(); //$this->unificarSaidas(array_merge($this->data['dados_saida_insumo'], $this->data['dados_saida_produto']));
        $this->data['dados_entrada'] = array(); //$this->unificarEntradas(array_merge($this->data['dados_entrada_insumo'], $this->data['dados_entrada_produto']));
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        //echo("<script>console.log(".$this->data['data_saida'].");</script>");
        
        
        $idUser = $this->session->userdata('idUsuarios');
        $getUserDepartaentos = $this->almoxarifado_model->getDepartamentoUsuario($idUser);
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        if(count($getUserEmpresa)>0){
            $this->data['dados_emitente2'] = $getUserEmpresa;
        }else{
            $getUserEmpresa = "";
            $this->data['dados_emitente2'] = [];
        }
        if(count($getUserDepartaentos)>0){
            $this->data['dados_departamento2'] = $getUserDepartaentos;
        }else{
            $this->data['dados_departamento2'] = [];
        }  
        
        
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
        $this->data['dados_departamento'] = $this->almoxarifado_model->getDepartamento();
        $this->data['view'] = 'almoxarifado/relatoriosalmoxarifado';
        $this->load->view('tema/topo',$this->data);
    }
    public function unificarRelatorioDet($estoque){
        $newEstoque = [];
        foreach($estoque as $r){
            if(isset($r->idInsumos)){
                $data= array(
                    "tabela"=>"insumo",
                    "idInsumos"=>$r->idInsumos,
                    "descricaoInsumo"=>$r->descricaoInsumo,
                    "quantidade_total"=>$r->quantidade_total,
                    "quantidade_entrada"=>$r->quantidade_entrada,
                    "quantidade_saida"=>$r->quantidade_saida,
                    "valor_total_entrada"=>$r->valor_total_entrada,
                    "valor_total_saida"=>$r->valor_total_saida,
                    "valor_unit_medio"=>$r->valor_unit_medio,
                    "valor_total"=>$r->valor_total
                );
            }else{
                $data=array(
                    "tabela"=>"produto",
                    "idInsumos"=>$r->idProdutos,
                    "descricaoInsumo"=>$r->descricao,
                    "quantidade_total"=>$r->quantidade_total,
                    "quantidade_entrada"=>$r->quantidade_entrada,
                    "quantidade_saida"=>$r->quantidade_saida,
                    "valor_total_entrada"=>$r->valor_total_entrada,
                    "valor_total_saida"=>$r->valor_total_saida,
                    "valor_unit_medio"=>$r->valor_unit_medio,
                    "valor_total"=>$r->valor_total
                );                
            }
            $datadois = (object) $data;
            
            array_push($newEstoque,$datadois);
            //echo("<script>console.log(".json_encode($newSaida).");</script>");
        }
        return $newEstoque;
    }
    public function unificarRelatorio($estoque){
        $newEstoque = [];
        foreach($estoque as $r){
            if(isset($r->idInsumos)){
                $data= array(
                    "tabela"=>"insumo",
                    "pn_insumo"=>$r->pn_insumo,
                    "idInsumos"=>$r->idInsumos,
                    "descricaoInsumo"=>$r->descricaoInsumo,
                    "nome"=>$r->nome,
                    "descricaoDepartamento"=>$r->descricaoDepartamento,
                    "quantidade_total"=>$r->quantidade_total,
                    "quantidade_entrada"=>$r->quantidade_entrada,
                    "quantidade_saida"=>$r->quantidade_saida,
                    "valor_total_entrada"=>$r->valor_total_entrada,
                    "valor_total_saida"=>$r->valor_total_saida,
                    "valor_unit_medio"=>$r->valor_unit_medio,
                    "valor_total"=>$r->valor_total
                );
            }else{
                $data=array(
                    "tabela"=>"produto",
                    "pn_insumo"=>$r->pn,
                    "idInsumos"=>$r->idProdutos,
                    "descricaoInsumo"=>$r->descricao,
                    "nome"=>$r->nome,
                    "descricaoDepartamento"=>$r->descricaoDepartamento,
                    "quantidade_total"=>$r->quantidade_total,
                    "quantidade_entrada"=>$r->quantidade_entrada,
                    "quantidade_saida"=>$r->quantidade_saida,
                    "valor_total_entrada"=>$r->valor_total_entrada,
                    "valor_total_saida"=>$r->valor_total_saida,
                    "valor_unit_medio"=>$r->valor_unit_medio,
                    "valor_total"=>$r->valor_total
                );                
            }
            $datadois = (object) $data;
            
            array_push($newEstoque,$datadois);
            //echo("<script>console.log(".json_encode($newSaida).");</script>");
        }
        return $newEstoque;
    }
    public function unificarEstoques($estoque){
        $newEstoque = [];
        foreach($estoque as $r){
            //echo json_encode($r);
            if(isset($r->idAlmoEstoque)){
                $data= array(
                    "tabela"=>"insumo",
                    "idAlmoEstoque"=>$r->idAlmoEstoque,
                    "idProduto"=>$r->idProduto,
                    "descricaoStatusProduto"=>null,
                    "idEmitente"=>$r->idEmitente,
                    "idLocal"=>$r->idLocal,
                    "idOs"=>$r->idOs,
                    "quantidade"=>$r->quantidade,
                    "metrica"=>$r->metrica,
                    "volume"=>$r->volume,
                    "comprimento"=>$r->comprimento,
                    "peso"=>$r->peso,
                    "dimensoesL"=>$r->dimensoesL,
                    "dimensoesC"=>$r->dimensoesC,
                    "dimensoesA"=>$r->dimensoesA,
                    "idInsumos"=>$r->idInsumos,
                    "pn_insumo"=>$r->pn_insumo,
                    "descricaoInsumo"=>$r->descricaoInsumo,
                    "id"=>$r->id,
                    "nome"=>$r->nome,
                    "idAlmoEstoqueLocais"=>$r->idAlmoEstoqueLocais,
                    "descricaoDepartamento"=>$r->descricaoDepartamento,
                    "idDepartamento"=>$r->idDepartamento,
                    "local"=>$r->local
                );
            }else{
                $data=array(
                    "tabela"=>"produto",
                    "idAlmoEstoque"=>$r->idAlmoEstoqueProduto,
                    "idProduto"=>$r->idProduto,
                    "descricaoStatusProduto"=>$r->descricaoStatusProduto,
                    "idEmitente"=>$r->idEmitente,
                    "idLocal"=>$r->idLocal,
                    "idOs"=>$r->idOs,
                    "quantidade"=>$r->quantidade,
                    "metrica"=>0,
                    "volume"=>null,
                    "comprimento"=>null,
                    "peso"=>null,
                    "dimensoesL"=>null,
                    "dimensoesC"=>null,
                    "dimensoesA"=>null,
                    "idInsumos"=>$r->idProdutos,
                    "pn_insumo"=>$r->pn,
                    "descricaoInsumo"=>$r->descricao,
                    "id"=>$r->id,
                    "nome"=>$r->nome,
                    "idAlmoEstoqueLocais"=>$r->idAlmoEstoqueLocais,
                    "descricaoDepartamento"=>$r->descricaoDepartamento,
                    "idDepartamento"=>$r->idDepartamento,
                    "local"=>$r->local
                );                
            }
            $datadois = (object) $data;
            
            array_push($newEstoque,$datadois);
            //echo("<script>console.log(".json_encode($newSaida).");</script>");
        }
        return $newEstoque;
    }
    public function unificarSaidas($saidas){
        $newSaida = [];
        foreach($saidas as $r){
            if(isset($r->idAlmoEstoqueSaida)){
                $data= array(
                    "tabela"=>"insumo",
                    "idAlmoEstoqueSaida"=>$r->idAlmoEstoqueSaida,
                    "idAlmoEstoque"=>$r->idAlmoEstoque,
                    "destinoNome"=>$r->destinoNome,
                    "nome"=>$r->nome,
                    "quantidade"=>$r->quantidade,
                    "data_saida"=>$r->data_saida,
                    "idUserSis"=>$r->idUserSis,
                    "idSetor"=>$r->idSetor,
                    "idOs"=>$r->idOs,
                    "assinatura"=>$r->assinatura,
                    "idAlmoEstoqueUsuario"=>$r->idAlmoEstoqueUsuario,
                    "getUsernome"=>$r->getUsernome,
                    "obs"=>$r->obs,
                    "idInsumos"=>$r->idInsumos,
                    "descricaoInsumo"=>$r->descricaoInsumo,
                    "pn_insumo"=>$r->pn_insumo,
                    "metrica"=>$r->metrica,
                    "volume"=>$r->volume,
                    "comprimento"=>$r->comprimento,
                    "peso"=>$r->peso,
                    "dimensoesL"=>$r->dimensoesL,
                    "dimensoesC"=>$r->dimensoesC,
                    "dimensoesA"=>$r->dimensoesA,
                    "local"=>$r->local,
                    "descricaoDepartamento"=>$r->descricaoDepartamento,
                    "username"=>$r->username,
                    "nomesetor"=>$r->nomesetor
                );
            }else{
                $data=array(
                    "tabela"=>"produto",
                    "idAlmoEstoqueSaida"=>$r->idAlmoEstoquePSaida,
                    "idAlmoEstoque"=>$r->idAlmoEstoqueProdutos,
                    "destinoNome"=>$r->destinoNome,
                    "nome"=>$r->nome,
                    "quantidade"=>$r->quantidade,
                    "data_saida"=>$r->data_saida,
                    "idUserSis"=>$r->idUserSis,
                    "idSetor"=>$r->idSetor,
                    "idOs"=>$r->idOs,
                    "assinatura"=>$r->assinatura,
                    "idAlmoEstoqueUsuario"=>$r->idAlmoEstoqueUsuario,
                    "getUsernome"=>$r->getUsernome,
                    "obs"=>$r->obs,
                    "idInsumos"=>$r->idProdutos,
                    "descricaoInsumo"=>$r->descricao,
                    "pn_insumo"=>$r->pn,
                    "metrica"=>0,
                    "volume"=>null,
                    "comprimento"=>null,
                    "peso"=>null,
                    "dimensoesL"=>null,
                    "dimensoesC"=>null,
                    "dimensoesA"=>null,
                    "local"=>$r->local,
                    "descricaoDepartamento"=>$r->descricaoDepartamento,
                    "username"=>$r->username,
                    "nomesetor"=>$r->nomesetor
                );                
            }
            $datadois = (object) $data;
            
            array_push($newSaida,$datadois);
            //echo("<script>console.log(".json_encode($newSaida).");</script>");
        }
        return $newSaida;
    }
    public function unificarEntradas($entradas){
        $newEntradas = [];
        foreach($entradas as $r){
            if(isset($r->idAlmoEstoqueEnt)){
                $data= array(
                    "tabela"=>"insumo",
                    "idAlmoEstoqueEnt"=>$r->idAlmoEstoqueEnt,
                    "idProduto"=>$r->idProduto,
                    "metrica"=>$r->metrica,
                    "comprimento"=>$r->comprimento,
                    "quantidade"=>$r->quantidade,
                    "volume"=>$r->volume,
                    "peso"=>$r->peso,
                    "dimensoesL"=>$r->dimensoesL,
                    "dimensoesC"=>$r->dimensoesC,
                    "dimensoesA"=>$r->dimensoesA,
                    "data_entrada"=>$r->data_entrada,
                    "idOs"=>$r->idOs,
                    "nf"=>$r->nf,
                    "idUsuario"=>$r->idUsuario,
                    "descricaoInsumo"=>$r->descricaoInsumo,
                    "pn_insumo"=>$r->pn_insumo,
                    "local"=>$r->local,
                    "descricaoDepartamento"=>$r->descricaoDepartamento,
                    "nomeEmpresa"=>$r->nomeEmpresa,
                    "descricaoStatusProduto"=>null,
                    "username"=>$r->username
                );
            }else{
                $data=array(
                    "tabela"=>"produto",
                    "idAlmoEstoqueEnt"=>$r->idAlmoEstoquePEntrada,
                    "idProduto"=>$r->idProduto,
                    "metrica"=>0,
                    "comprimento"=>null,
                    "quantidade"=>$r->quantidade,
                    "volume"=>null,
                    "peso"=>null,
                    "dimensoesL"=>null,
                    "dimensoesC"=>null,
                    "dimensoesA"=>null,
                    "data_entrada"=>$r->data_entrada,
                    "idOs"=>$r->idOs,
                    "nf"=>$r->nf,
                    "idUsuario"=>$r->idUsuario,
                    "descricaoInsumo"=>$r->descricao,
                    "pn_insumo"=>$r->pn,
                    "local"=>$r->local,
                    "descricaoDepartamento"=>$r->descricaoDepartamento,
                    "nomeEmpresa"=>$r->nomeEmpresa,
                    "descricaoStatusProduto"=>$r->descricaoStatusProduto,
                    "username"=>$r->username
                );                
            }
            $datadois = (object) $data;
            
            array_push($newEntradas,$datadois);
            //echo("<script>console.log(".json_encode($newEntradas).");</script>");
        }
        return $newEntradas;
    }
    public function filtrarEntradas(){
        $idEmpresa = $this->input->post('empresa');
        $departamento = $this->input->post('departamento');
        $usuCadEntr = $this->input->post('usuCadEntr');
        if(!empty($this->input->post('dataInicialEntr')))
            $dataInicialEntr = explode('/', $this->input->post('dataInicialEntr'));
        else
            $dataInicialEntr = "";
        if(!empty($this->input->post('dataFinalEntr')))
            $dataFinalEntr = explode('/', $this->input->post('dataFinalEntr'));
        else
            $dataFinalEntr = "";
        $nfRelEntr = $this->input->post('nfRelEntr');
        $pn = $this->input->post('pn');
        $idOsRelEntr = $this->input->post('idOsRelEntr');
        $descricao = $this->input->post('descricao');
        $primeiro = true;
        $where = "";
        $whereProd = "";
        $somenteProdutos = false;
        $somenteInsumos = false;
        if(!empty($idEmpresa)){
            if($primeiro){
                $where = $where."WHERE emitente.id = ".$idEmpresa;
                $whereProd = $whereProd."WHERE emitente.id = ".$idEmpresa;
                $primeiro = false;
            }else{
                $where = $where." and emitente.id = ".$idEmpresa;
                $whereProd = $whereProd." and emitente.id = ".$idEmpresa;
            }
        }
        if(!empty($pn)){
            if($primeiro){
                $where = $where."WHERE insumos.pn_insumo = '".$pn."'";
                $whereProd = $whereProd."WHERE produtos.pn = '".$pn."'";
                $primeiro = false;
            }else{
                $where = $where." and insumos.pn_insumo = '".$pn."'";
                $whereProd = $whereProd." and produtos.pn = '".$pn."'";
            }
        }
            
        if(!empty($departamento)){
            if($primeiro){
                $where = $where."WHERE almo_estoque_entrada.idDepartamento = ".$departamento;
                $whereProd = $whereProd."WHERE almo_estoque_p_entrada.idDepartamento = ".$departamento;
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_entrada.idDepartamento = ".$departamento;
                $whereProd = $whereProd." and almo_estoque_p_entrada.idDepartamento = ".$departamento;
            }
        }
            
        if(!empty($usuCadEntr)){
            if($primeiro){
                $where = $where."WHERE usuarios.nome like '%$usuCadEntr%'";
                $whereProd = $whereProd."WHERE usuarios.nome like '%$usuCadEntr%'";
                $primeiro = false;
            }else{
                $where = $where." and usuarios.nome like '%$usuCadEntr%'";
                $whereProd = $whereProd." and usuarios.nome like '%$usuCadEntr%'";
            }
        }
            
        if(!empty($nfRelEntr)){
            if($primeiro){
                $where = $where."WHERE almo_estoque_entrada.nf = ".$nfRelEntr;
                $whereProd = $whereProd."WHERE almo_estoque_p_entrada.nf = ".$nfRelEntr;
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_entrada.nf  = ".$nfRelEntr;
                $whereProd = $whereProd." and almo_estoque_p_entrada.nf  = ".$nfRelEntr;
            }
        }
            
        if(!empty($idOsRelEntr)){
            if($primeiro){
                $where = $where."WHERE almo_estoque_entrada.idOs  = ".$idOsRelEntr;
                $whereProd = $whereProd."WHERE almo_estoque_p_entrada.idOs  = ".$idOsRelEntr;
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_entrada.idOs  = ".$idOsRelEntr;
                $whereProd = $whereProd." and almo_estoque_p_entrada.idOs  = ".$idOsRelEntr;
            }
        }
        if(!empty($descricao)){
            if($primeiro){
                $where = $where."WHERE insumos.descricaoInsumo like '%".$descricao."%'";
                $whereProd = $whereProd."WHERE produtos.descricao like '%".$descricao."%'";
                $primeiro = false;
            }else{
                $where = $where." and insumos.descricaoInsumo like '%".$descricao."%'";
                $whereProd = $whereProd." and produtos.descricao like '%".$descricao."%'";
            }
        }
        if(!empty($dataInicialEntr) && !empty($dataInicialEntr)){
            if($primeiro){
                //$whereEntrada = "where almo_estoque_entrada.data_entrada BETWEEN '$dataeinicial2 00:00:00' AND '$dataefinal2 23:59:59'";
                $where = $where."where almo_estoque_entrada.data_entrada BETWEEN '".$dataInicialEntr[2]."-".$dataInicialEntr[1]."-".$dataInicialEntr[0]." 00:00:00' AND '".$dataFinalEntr[2]."-".$dataFinalEntr[1]."-".$dataFinalEntr[0]." 23:59:59'";
                $whereProd = $whereProd."where almo_estoque_p_entrada.data_entrada BETWEEN '".$dataInicialEntr[2]."-".$dataInicialEntr[1]."-".$dataInicialEntr[0]." 00:00:00' AND '".$dataFinalEntr[2]."-".$dataFinalEntr[1]."-".$dataFinalEntr[0]." 23:59:59'";
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_entrada.data_entrada BETWEEN '".$dataInicialEntr[2]."-".$dataInicialEntr[1]."-".$dataInicialEntr[0]." 00:00:00' AND '".$dataFinalEntr[2]."-".$dataFinalEntr[1]."-".$dataFinalEntr[0]." 23:59:59'";
                $whereProd = $whereProd." and almo_estoque_p_entrada.data_entrada BETWEEN '".$dataInicialEntr[2]."-".$dataInicialEntr[1]."-".$dataInicialEntr[0]." 00:00:00' AND '".$dataFinalEntr[2]."-".$dataFinalEntr[1]."-".$dataFinalEntr[0]." 23:59:59'";
            }
        }
        if(!empty($this->input->post("unidades"))){
            if($primeiro){
                $where = $where."where os.unid_execucao in (".$this->input->post("unidades").")";
                $whereProd = $whereProd."where os.unid_execucao in (".$this->input->post("unidades").")";
                $primeiro = false;
            }else{
                $where = $where." and os.unid_execucao in (".$this->input->post("unidades").")";
                $whereProd = $whereProd." and os.unid_execucao in (".$this->input->post("unidades").")";
            }
        }
        $resultado = $this->unificarEntradas(array_merge($this->almoxarifado_model->getEntrada($where), $this->almoxarifado_model->getEntradaProduto($whereProd)));
        $json = array('result'=>true,'resultado'=>$resultado,'where'=>$where);
        echo json_encode($json);
            
    }
    public function filtrarSaidas(){
        $idEmpresa = $this->input->post('empresa');
        $departamento = $this->input->post('departamento');
        $descricao = $this->input->post('descricao');
        $setor = $this->input->post('setor');
        $usuCadSai = $this->input->post('usuCadSai');
        if(!empty($this->input->post("dataInicialSai")))
            $dataInicialSai = explode('/', $this->input->post("dataInicialSai"));
        else
            $dataInicialSai = "";
        if(!empty($this->input->post("dataFinalSai")))
            $dataFinalSai = explode('/', $this->input->post('dataFinalSai'));
        else
            $dataFinalSai = "";
        $userSolRelSai = $this->input->post('userSolRelSai');
        $idOsRelSai = $this->input->post('idOsRelSai');
        $pn = $this->input->post('pn');
        $primeiro = true;
        $where = "";
        $whereProd = "";
        if(!empty($idEmpresa)){
            if($primeiro){
                $where = $where."WHERE emitente.id = $idEmpresa";
                $whereProd = $whereProd."WHERE emitente.id = $idEmpresa";
                $primeiro = false;
            }else{
                $where = $where." and emitente.id = $idEmpresa";
                $whereProd = $whereProd." and emitente.id = $idEmpresa";
            }
        }
            
        if(!empty($departamento)){
            if($primeiro){
                $where = $where."WHERE almo_estoque_departamento.idAlmoEstoqueDep = $departamento";
                $whereProd = $whereProd."WHERE almo_estoque_departamento.idAlmoEstoqueDep = $departamento";
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_departamento.idAlmoEstoqueDep = $departamento";
                $whereProd = $whereProd." and almo_estoque_departamento.idAlmoEstoqueDep = $departamento";
            }
        }
        if(!empty($descricao)){
            if($primeiro){
                $where = $where."WHERE insumos.descricaoInsumo  like '%$descricao%'";
                $whereProd = $whereProd."WHERE produtos.descricao  like '%$descricao%'";
                $primeiro = false;
            }else{
                $where = $where." and insumos.descricaoInsumo  like  '%$descricao%'";
                $whereProd = $whereProd." and produtos.descricao  like '%$descricao%'";
            }
        }

        if(!empty($pn)){
            if($primeiro){
                $where = $where."WHERE insumos.pn_insumo = '".$pn."'";
                $whereProd = $whereProd."WHERE produtos.pn = '".$pn."'";
                $primeiro = false;
            }else{
                $where = $where." and insumos.pn_insumo = '".$pn."'";
                $whereProd = $whereProd." and produtos.pn = '".$pn."'";
            }
        }
            
        if(!empty($usuCadSai)){
            if($primeiro){
                $where = $where."WHERE usuarios.nome like '%$usuCadSai%'";
                $whereProd = $whereProd."WHERE usuarios.nome like '%$usuCadSai%'";
                $primeiro = false;
            }else{
                $where = $where." and usuarios.nome like '%$usuCadSai%'";
                $whereProd = $whereProd." and usuarios.nome like '%$usuCadSai%'";
            }
        }
            
        if(!empty($userSolRelSai)){
            if($primeiro){
                $where = $where."WHERE almo_estoque_usuario.nome like '%$userSolRelSai%'";
                $whereProd = $whereProd."WHERE almo_estoque_usuario.nome like '%$userSolRelSai%'";
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_usuario.nome like '%$userSolRelSai%'";
                $whereProd = $whereProd." and almo_estoque_usuario.nome like '%$userSolRelSai%'";
            }
        }
            
        if(!empty($idOsRelSai)){
            if($primeiro){
                $where = $where."WHERE almo_estoque_saida.idOs  = $idOsRelSai";
                $whereProd = $whereProd."WHERE almo_estoque_p_saida.idOs  = $idOsRelSai";
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_saida.idOs  = $idOsRelSai";
                $whereProd = $whereProd." and almo_estoque_p_saida.idOs  = $idOsRelSai";
            }
        }
        if(!empty($dataInicialSai) && !empty($dataFinalSai)){
            if($primeiro){
                //$whereEntrada = "where almo_estoque_entrada.data_entrada BETWEEN '$dataeinicial2 00:00:00' AND '$dataefinal2 23:59:59'";
                $where = $where."where almo_estoque_saida.data_saida BETWEEN '".$dataInicialSai[2]."-".$dataInicialSai[1]."-".$dataInicialSai[0]." 00:00:00' AND '".$dataFinalSai[2]."-".$dataFinalSai[1]."-".$dataFinalSai[0]." 23:59:59'";
                $whereProd = $whereProd."where almo_estoque_p_saida.data_saida BETWEEN '".$dataInicialSai[2]."-".$dataInicialSai[1]."-".$dataInicialSai[0]." 00:00:00' AND '".$dataFinalSai[2]."-".$dataFinalSai[1]."-".$dataFinalSai[0]." 23:59:59'";
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_saida.data_saida BETWEEN '".$dataInicialSai[2]."-".$dataInicialSai[1]."-".$dataInicialSai[0]." 00:00:00' AND '".$dataFinalSai[2]."-".$dataFinalSai[1]."-".$dataFinalSai[0]." 23:59:59'";
                $whereProd = $whereProd." and almo_estoque_p_saida.data_saida BETWEEN '".$dataInicialSai[2]."-".$dataInicialSai[1]."-".$dataInicialSai[0]." 00:00:00' AND '".$dataFinalSai[2]."-".$dataFinalSai[1]."-".$dataFinalSai[0]." 23:59:59'";
            }
        }
        $resultado = $this->unificarSaidas(array_merge($this->almoxarifado_model->getSaida($where), $this->almoxarifado_model->getSaidaProduto($whereProd)));
        $json = array('result'=>true,'resultado'=>$resultado,'where'=>$where);
        echo json_encode($json);
            
    }    
    public function cadastrarEntradasProdutos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){
            $this->session->set_flashdata('error','Você não tem permissão para cadastrar estoque em Almoxarifado.');
            redirect(base_url());
        }
        $this->load->model('produtos_model');
        $idUser = $this->session->userdata('idUsuarios');
        $arrayEntradas = $this->input->post('arrayEntradas');
        $count = count($arrayEntradas);
        for($x = 0; $x < $count; $x++){
            if(!empty($arrayEntradas[$x]['idProdutoTDProd'])){
                $p = $arrayEntradas[$x]['idProdutoTDProd'];
            }else{
                $json = array('result'=>false,'msggg'=>'Produto não selecionado.');
                echo json_encode($json);
                return;
            }
            if(!empty($arrayEntradas[$x]['qtdTDProd'])){
                $qtd = $arrayEntradas[$x]['qtdTDProd'];
            }else{
                $json = array('result'=>false,'msggg'=>'Quantidade não informada.');
                echo json_encode($json);
                return;
            }
            if(!empty($arrayEntradas[$x]['idEmpresaTDProd'])){
                $emp= $arrayEntradas[$x]['idEmpresaTDProd'];
            }else{
                $json = array('result'=>false,'msggg'=>'Empresa não informada.');
                echo json_encode($json);
                return;
            }
            if(!empty($arrayEntradas[$x]['idDepartamentoProd'])){
                $dep= $arrayEntradas[$x]['idDepartamentoProd'];
            }else{
                $json = array('result'=>false,'msggg'=>'Departamento não informado.');
                echo json_encode($json);
                return;
            }
            if(!empty($arrayEntradas[$x]['idLocalpTDProd'])){
                $l= $arrayEntradas[$x]['idLocalpTDProd'];
            }else{
                $l = null;
            }
            if(!empty($arrayEntradas[$x]['nFTDProd'])){
                $nf= $arrayEntradas[$x]['nFTDProd'];
            }else{
                $nf = null;
            }
            if(!empty($arrayEntradas[$x]['valorUnitProd'])){
                $vu = $arrayEntradas[$x]['valorUnitProd'];
            }else{
                $vu = null;
            }
            if(!empty($arrayEntradas[$x]['idOsTDProd'])){
                $os = $arrayEntradas[$x]['idOsTDProd'];
            }else{
                $os = null;
            }
            if(!empty($arrayEntradas[$x]['idStatusProdutoTDProd'])){
                $sp = $arrayEntradas[$x]['idStatusProdutoTDProd'];
            }else{
                $sp = null;
            }
            $verificacao = $this->almoxarifado_model->verificaPEDL($p,$emp,$dep,$l,$sp);
            if(count($verificacao )<1){
                $this->almoxarifado_model->criarEstoqueEntradaProduto($p,$qtd,$emp,$dep,$l,$nf,$vu,$os,$idUser,$sp);
                $this->almoxarifado_model->criarEstoqueProduto($p,$qtd,$emp,$dep,$l,$os,$sp);
            }else {
                $newQtd = $verificacao[0]->quantidade + $qtd;
                $this->almoxarifado_model->criarEstoqueEntradaProduto($p,$qtd,$emp,$dep,$l,$nf,$vu,$os,$idUser,$sp);
                $this->almoxarifado_model->updateEstoqueProduto($verificacao[0]->idAlmoEstoqueProduto,$newQtd);
            }
            $objproduto = $this->produtos_model->getById($arrayEntradas[$x]['idProdutoTDProd']);
            $arrayEntradas[$x]['pn'] = $objproduto->pn;
        }
        $json = array('entrada'=>$arrayEntradas,'result'=>true);
        echo json_encode($json);
    }
    public function cadastrarSaidasProdutos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){
            $this->session->set_flashdata('error','Você não tem permissão para cadastrar estoque em Almoxarifado.');
            redirect(base_url());
        }
        $idUser = $this->session->userdata('idUsuarios');
        $arraySaidas = $this->input->post('arraySaidas');
        $count = count($arraySaidas);
        $assinatura = $this->input->post("assinatura2");
        if(!empty($assinatura)){
            $encoded_image = explode(",", $assinatura)[1];
            $decoded_image = base64_decode($encoded_image);
            $target_dir = "./assets/assinaturas/";
            $target_dir2 = "assets/assinaturas/";
            $nomeAssinatura = $this->generateRandomString().".png";
            $target_file = $target_dir.$nomeAssinatura;
            $target_file2 = $target_dir2.$nomeAssinatura;
            file_put_contents($target_file, $decoded_image);
        }else{
            $target_file2 = null;
        }
        for($x=0;$x<$count;$x++){
            if(!empty($arraySaidas[$x]['idEstoqueTDSProd_'])){
                $est = $arraySaidas[$x]['idEstoqueTDSProd_'];
            }else{
                $json = array('result'=>false,'msggg'=>'Produto não selecionado.');
                echo json_encode($json);
                return;
            }
            if(!empty($arraySaidas[$x]['qtdTDSProd_'])){
                $qtd = $arraySaidas[$x]['qtdTDSProd_'];
            }else{
                $json = array('result'=>false,'msggg'=>'Quantidade não informada.');
                echo json_encode($json);
                return;
            }
            if(!empty($arraySaidas[$x]['idEmpresaTDSProd_'])){
                $emp = $arraySaidas[$x]['idEmpresaTDSProd_'];
            }else{
                $json = array('result'=>false,'msggg'=>'Empresa de destino não selecionada.');
                echo json_encode($json);
                return;
            } 
            if(!empty($arraySaidas[$x]['idSetorProd_'])){
                $set = $arraySaidas[$x]['idSetorProd_'];
            }else{
                $json = array('result'=>false,'msggg'=>'Setor não selecionado.');
                echo json_encode($json);
                return;
            }
            if(!empty($arraySaidas[$x]['idUserProd_'])){
                $user = $arraySaidas[$x]['idUserProd_'];
            }else{
                $json = array('result'=>false,'msggg'=>'Usuário não selecionado.');
                echo json_encode($json);
                return;
            }
            if(!empty($arraySaidas[$x]['idOsTDSProd_'])){
                $idOs = $arraySaidas[$x]['idOsTDSProd_'];
            }else{
                $idOs = null;
            }

            if(!empty($arraySaidas[$x]['obsTDSProd_'])){
                $obs = $arraySaidas[$x]['obsTDSProd_'];
            }else{
                $obs =null;
            }
            
            $this->almoxarifado_model->cadastrarSaidasProdutos($est,$qtd,$emp,$set,$idUser,$user,$idOs,$obs,$target_file2);
            $this->data["itemEstoque"]=$this->almoxarifado_model->getItemEstoqueProdutos($est);
            $newQtd = $this->data["itemEstoque"][0]->quantidade - $qtd;
            $this->almoxarifado_model->updateEstoqueProduto($est,$newQtd);
        }
        //$this->salvarlog($this->session->userdata('idUsuarios'),'almoxarifado','inserir',$descricao );
        $json = array('msggg'=>'Saídas cadastradas com sucesso.','result'=>true);
        echo json_encode($json);
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function entradasemiauto(){
        $contador = count($this->input->post('idAlmoAgArmaz_'));
        $idUser = $this->session->userdata('idUsuarios');
        $idEntrada = null;
        if($contador <=0){
            $json = array('result'=>false,'msggg'=>'Produto não selecionado.');
            echo json_encode($json);
            return;
        }
        for($x=0;$x<$contador;$x++){
            if(empty($this->input->post('idDepartamento')[$x])){
                $json = array('result'=>false,'msggg'=>'Departamento não selecionado.');
                echo json_encode($json);
                return;
            }
            if(empty($this->input->post('descricaoLocal')[$x])){
                $json = array('result'=>false,'msggg'=>'Local não selecionado.');
                echo json_encode($json);
                return;
            }
        }
        for($x=0;$x<$contador;$x++){
            $idEntrada = null;
            if(!empty($this->input->post('idDepartamento')[$x])){
                $result = $this->almoxarifado_model->getAgArmazId($this->input->post('idAlmoAgArmaz_')[$x]);
                $local = $this->cadastrarLocal3($this->input->post('descricaoLocal')[$x],$this->input->post('idDepartamento')[$x],$result[0]->idEmitente);
                $this->data["verificaPMEL"] = $this->almoxarifado_model->verificaPMEL($result[0]->idInsumo,$result[0]->metrica,$result[0]->comprimento ,$result[0]->volume,$result[0]->peso,$result[0]->dimensoesL,$result[0]->dimensoesC,$result[0]->dimensoesA,$result[0]->idEmitente,$local,$this->input->post('idDepartamento')[$x],"");
                if(count($this->data["verificaPMEL"] )<1){
                    $idEntrada = $this->almoxarifado_model->criarEstoqueEntrada($result[0]->idInsumo,$result[0]->metrica,$result[0]->comprimento,$result[0]->volume,$result[0]->peso,$result[0]->dimensoesL,$result[0]->dimensoesC,$result[0]->dimensoesA,$result[0]->idEmitente,$local,$result[0]->quantidade,$idUser,$result[0]->nf,null,$result[0]->valorUnitario,$this->input->post('idDepartamento')[$x]);
                    $this->almoxarifado_model->criarEstoque($result[0]->idInsumo,$result[0]->metrica,$result[0]->comprimento,$result[0]->volume,$result[0]->peso,$result[0]->dimensoesL,$result[0]->dimensoesC,$result[0]->dimensoesA,$result[0]->idEmitente,$local,$result[0]->quantidade,$this->input->post('idDepartamento')[$x]);
                }else {
                    $newQtd = $this->data["verificaPMEL"][0]->quantidade + $result[0]->quantidade;
                    $idEntrada = $this->almoxarifado_model->criarEstoqueEntrada($result[0]->idInsumo,$result[0]->metrica,$result[0]->comprimento,$result[0]->volume,$result[0]->peso,$result[0]->dimensoesL,$result[0]->dimensoesC,$result[0]->dimensoesA,$result[0]->idEmitente,$local,$result[0]->quantidade,$idUser,$result[0]->nf,null,$result[0]->valorUnitario,$this->input->post('idDepartamento')[$x]);
                    $this->almoxarifado_model->updateEstoque($this->data["verificaPMEL"][0]->idAlmoEstoque,$newQtd,$this->input->post('idDepartamento')[$x]);
                }
                $data = array(
                    'idStatusAgArmaz'=>3,
                    'idAlmoEstoqueEnt '=>$idEntrada
                );
                $this->almoxarifado_model->updateAgArmazId($data,$this->input->post('idAlmoAgArmaz_')[$x]);
            }         

        }
        $json = array('msggg'=>'Entradas Finalizadas!','result'=>true,'resultado'=>$this->almoxarifado_model->getAgArmazInicial());
        echo json_encode($json);
    }

    function cancelarentrada(){
        $cancelar = $this->input->post('cancelarID');
        $data = array(
            "idStatusAgArmaz "=>"1"
        );
        $this->almoxarifado_model->updateAgArmazId($data,$cancelar);
        $json = array('result'=>true,"msggg"=>"Cancelado com sucesso!");
        echo json_encode($json);
    }

    function getItensOs(){
        $idOs = $this->uri->segment(3);
        $idEmpresa = $this->uri->segment(4);
        $idDepart = $this->uri->segment(5);
        $result = $this->almoxarifado_model->getItensOs($idOs,$idEmpresa,$idDepart);
        foreach($result as $r){
            $r->vale = $this->almoxarifado_model->getValeByOsDestAndIdInsumo($idOs,$r->idProduto);
        }
        $json = array('result'=>true,"resultado"=>$result);
        echo json_encode($json);
    }

    

    private function salvarlog($usuario,$table,$acao,$descricao){

        //colocar na funçao que vai enviar $this->salvarlog($usuario,$table,$acao,$descricao)

        $data = array(
            'ag_id_responsavel' => $usuario,
            'ag_tabela' => $table,
            'ag_acao_realizada' => $acao,
             'ag_descricao' => $descricao
        );
        $this->almoxarifado_model->add('auditoria_geral', $data);
    }

    function recebercompras(){
        $this->data['view'] = 'almoxarifado/recebercompras';
       	$this->load->view('tema/topo',$this->data);
    }
    function buscaroc(){
        $this->load->model('pedidocompra_model');
        $this->load->model('orcamentos_model');
        if(!empty($this->input->post('idOc'))){       
            $idUser = $this->session->userdata('idUsuarios');
            $getUserDepartaentos = "";//$this->almoxarifado_model->getDepartamentoUsuario($idUser);
            $getUserEmpresa = "";//$this->almoxarifado_model->getEmpresaUsuario($idUser);
            $this->data['materiais'] = $this->pedidocompra_model->getByIdOrdemCompraAndNotRecebido($this->input->post('idOc'));
            if(empty($getUserDepartaentos)){
                $this->data['departamento'] = $this->almoxarifado_model->getDepartamento();
            }else{
                $this->data['departamento'] = $getUserDepartaentos;
            }        
            if(empty($getUserEmpresa)){
                $this->data['emitente'] = $this->orcamentos_model->getEmitente2();
            }else{
                $this->data['emitente'] = $getUserEmpresa;
            }        
            $this->data['view'] = 'almoxarifado/recebermercadoria';
       	    $this->load->view('tema/topo',$this->data);
        }else{
            redirect(base_url()."index.php/almoxarifado/receber"); 
        }
    }
    function buscaroc2(){
        $this->load->model('pedidocompra_model');
        $this->load->model('orcamentos_model');
        if(!empty($this->input->post('idOc'))){       
            $idUser = $this->session->userdata('idUsuarios');
            $getUserDepartaentos = "";//$this->almoxarifado_model->getDepartamentoUsuario($idUser);
            $getUserEmpresa = "";//$this->almoxarifado_model->getEmpresaUsuario($idUser);
            $this->data['materiais'] = $this->pedidocompra_model->getByIdOrdemCompraAndRecebido($this->input->post('idOc'));
            if(empty($getUserDepartaentos)){
                $this->data['departamento'] = $this->almoxarifado_model->getDepartamento();
            }else{
                $this->data['departamento'] = $getUserDepartaentos;
            }        
            if(empty($getUserEmpresa)){
                $this->data['emitente'] = $this->orcamentos_model->getEmitente2();
            }else{
                $this->data['emitente'] = $getUserEmpresa;
            }        
            $this->data['view'] = 'almoxarifado/recebercompras';
       	    $this->load->view('tema/topo',$this->data);
        }else{
            redirect(base_url()."index.php/almoxarifado/recebercompras"); 
        }
    }
    function confirmarEntrega(){
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }
        $idDistribuir = $this->input->post('idDistribuir');
        $qtdRecebida = $this->input->post('qtdRecebida');
        $this->load->model('pedidocompra_model');
        $distribuir = $this->pedidocompra_model->getByIdDistribuir($idDistribuir);
        if($distribuir->entradaMp  == 0 ){
            $idUser = $this->session->userdata('idUsuarios');
            if(!empty($this->input->post('descricaoLocal'))){
                $local = $this->cadastrarLocal3($this->input->post('descricaoLocal'),$this->input->post('idDepartamento'),$this->input->post('emitente'));  
            }else{
                $local = null;
            }
            $pedidoComprasItens = $this->pedidocompra_model->getbyIdPedidoComprasItens($this->input->post('idPedidoCompraItens'));
            $this->data["verificaPMEL"] = $this->almoxarifado_model->verificaPMEL($distribuir->idInsumos,$distribuir->metrica,$distribuir->comprimento,$distribuir->volume,$distribuir->peso,$distribuir->dimensoesL,$distribuir->dimensoesC,$distribuir->dimensoesA,$this->input->post('emitente'),$local,$this->input->post('idDepartamento'),($distribuir->idOs>=2000?$distribuir->idOs:null));
            //$data = array("idDistribuir"=>$idDistribuir,"quantidade"=>$qtdRecebida);
            if(count($this->data["verificaPMEL"] )<1){
                $idEntrada = $this->almoxarifado_model->criarEstoqueEntrada($distribuir->idInsumos,$distribuir->metrica,$distribuir->comprimento,$distribuir->peso,$distribuir->volume,$distribuir->dimensoesL,$distribuir->dimensoesC,$distribuir->dimensoesA,$this->input->post('emitente'),$local,$qtdRecebida,$idUser,$this->input->post('nf'),($distribuir->idOs>=2000?$distribuir->idOs:null),$pedidoComprasItens->valor_unitario,$this->input->post('idDepartamento'));
                $this->almoxarifado_model->criarEstoque($distribuir->idInsumos,$distribuir->metrica,$distribuir->comprimento,$distribuir->peso,$distribuir->volume,$distribuir->dimensoesL,$distribuir->dimensoesC,$distribuir->dimensoesA,$this->input->post('emitente'),$local,$qtdRecebida,$this->input->post('idDepartamento'),($distribuir->idOs>=2000?$distribuir->idOs:null));
            }else{
                $newQtd = $this->data["verificaPMEL"][0]->quantidade + $qtdRecebida;
                $idEntrada = $this->almoxarifado_model->criarEstoqueEntrada($distribuir->idInsumos,$distribuir->metrica,$distribuir->comprimento,$distribuir->peso,$distribuir->volume,$distribuir->dimensoesL,$distribuir->dimensoesC,$distribuir->dimensoesA,$this->input->post('emitente'),$local,$qtdRecebida,$idUser,$this->input->post('nf'),($distribuir->idOs>=2000?$distribuir->idOs:null),$pedidoComprasItens->valor_unitario,$this->input->post('idDepartamento'));
                $this->almoxarifado_model->updateEstoque($this->data["verificaPMEL"][0]->idAlmoEstoque,$newQtd,$this->input->post('idDepartamento'),$distribuir->idOs);
            }
            $data = array("entradaMp"=>1);
           
            $this->pedidocompra_model->edit('distribuir_os',$data,'idDistribuir',$idDistribuir);
            
			

            $json = array('msggg'=>'Entradas Finalizadas!','result'=>true,"objeto"=>$this->input->post('objeto'));
            echo json_encode($json);
            return;

        }else{
            $json = array('msggg'=>'Entradas Finalizadas!','result'=>true,"objeto"=>$this->input->post('objeto'));
            echo json_encode($json);
            return;
        }
    }
    
    function confirmarMercadoria(){
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }
        $idDistribuir = $this->input->post('idDistribuir');
        $qtdRecebida = $this->input->post('qtdRecebida');
        $this->load->model('pedidocompra_model');
        $distribuir = $this->pedidocompra_model->getByIdDistribuir($idDistribuir);
        if($distribuir->entradaMp  == 0 ){
            $idUser = $this->session->userdata('idUsuarios');
            
            $pedidoComprasItens = $this->pedidocompra_model->getbyIdPedidoComprasItens($this->input->post('idPedidoCompraItens'));
            //$data = array("idDistribuir"=>$idDistribuir,"quantidade"=>$qtdRecebida);
           
            $data = array("recebido"=>1,"idUserRecebido"=>$idUser);
            if($distribuir->idStatuscompras!=5){
                $data2 = array("idStatusCompras"=>5);
                $data = array_merge($data,$data2);
            }
            $this->pedidocompra_model->edit('distribuir_os',$data,'idDistribuir',$idDistribuir);
            $dataPedidoItens = array(
                "notafiscal"=>(!empty($this->input->post('nf'))?$this->input->post('nf'):null)
            );
            $this->pedidocompra_model->edit('pedido_comprasitens',$dataPedidoItens,'idPedidoCompraItens',$pedidoComprasItens->idPedidoCompraItens);
            $this->data['dadosped3'] = $this->pedidocompra_model->gettable('distribuir_os','idDistribuir ='. $idDistribuir);
			if($this->input->post('qtdRecebida') > 0)
			{
				if($this->input->post('qtdRecebida') < $this->data['dadosped3']->quantidade )
				{
					$qtd_nova =   $this->data['dadosped3']->quantidade - $this->input->post('qtdRecebida');
					$this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $pedidoComprasItens->idCotacaoItens);
					//add nova item
					
                    $data55 = array(
                        'idInsumos' => $this->data['dadosped3']->idInsumos,
                        'dimensoes' => $this->data['dadosped3']->dimensoes,
                        'solicitacao' => $this->data['dadosped3']->solicitacao,
                        'id_status_grupo' => $this->data['dadosped3']->id_status_grupo,
                        'idProdutos' => $this->data['dadosped3']->idProdutos,
                        'idOsSub' => $this->data['dadosped3']->idOsSub,
                        'idUserAprovacao' =>$this->data['dadosped3']->idUserAprovacao,
                        'idUserAprovacaoSUP' =>$this->data['dadosped3']->idUserAprovacaoSUP,     
                        'idUserAprovacaoDir' =>$this->data['dadosped3']->idUserAprovacaoDir,                           
                        'aprovacaoPCP' =>$this->data['dadosped3']->aprovacaoPCP,
                        'aprovacaoSUP' =>$this->data['dadosped3']->aprovacaoSUP,
                        'aprovacaoDir' =>$this->data['dadosped3']->aprovacaoDir,                         
                        'data_autorizacaoPCP' =>$this->data['dadosped3']->data_autorizacaoPCP,
                        'data_autorizacaoSUP' =>$this->data['dadosped3']->data_autorizacaoSUP,
                        'data_autorizacaoDir' =>$this->data['dadosped3']->data_autorizacaoDir ,
                        'finalizado' =>$this->data['dadosped3']->finalizado,
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
                        'idUser_aguardandoOrc' => $this->data['dadosped3']->idUser_aguardandoOrc,
                        'quantidade' => $qtd_nova,
                        'idOs' => $this->data['dadosped3']->idOs
                    );
                    $id_pci = $this->pedidocompra_model->add('distribuir_os', $data55, true);

                    $idsDistribuirPar[] = $id_pci;


                    
                    $data3_ = array(
                    
                        'quantidade' => $this->input->post('qtdRecebida'),
                        'idStatuscompras' => 11,
                    
                    );
			
                    //update na tb
                    $this->pedidocompra_model->edit('distribuir_os', $data3_, 'idDistribuir', $idDistribuir);
                    //$this->attDataAlteracao($idDistribuir);
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
			
			
                    $this->data['dados_'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idCotacaoItens ='. $pedidoComprasItens->idCotacaoItens);
                    
                    $valor_total_calc = $this->data['dados_']->valor_unitario * $this->input->post('qtdRecebida');
                    if($this->data['dados_']->ipi_valor <> 0.00)
                    {
                        $calc = ($this->data['dados_']->ipi_valor) / 100 * $valor_total_calc;
                        $valor_total_calc = $valor_total_calc + $calc;
                    }
			
			
                    $data__ = array(
                    
                        'valor_total' => $valor_total_calc
                    
                    );
                    $this->pedidocompra_model->edit('pedido_comprasitens', $data__, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens'));	
                    
                    $valor_total_calc2 = $this->data['dados_']->valor_unitario * $qtd_nova;
                    if($this->data['dados_']->ipi_valor <> 0.00)
                    {
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
                        'icms'=>$this->data['dados_']->icms,
                        'autorizadoCompra '=>$this->data['dados_']->autorizadoCompra,
                        'idUsuarioAutorizacao'=>$this->data['dados_']->idUsuarioAutorizacao
            				
                    );

                    $compraitem = $this->pedidocompra_model->add('pedido_comprasitens', $datacom, true);
                    
                    $datadd = array(
                    
                        'idPedidoCompraItens' => $compraitem
                    
                    );
                    
                    //update na tb
                    $this->pedidocompra_model->edit('pedido_cotacaoitens', $datadd, 'idCotacaoItens', $cot);
                    
                    
                    $this->session->set_flashdata('success','Foi gerada novo item.');		
					
				}
			}

            $json = array('msggg'=>'Entradas Finalizadas!','result'=>true,"objeto"=>$this->input->post('objeto'));
            echo json_encode($json);
            return;

        }else{
            $json = array('msggg'=>'Entradas Finalizadas!','result'=>true,"objeto"=>$this->input->post('objeto'));
            echo json_encode($json);
            return;
        }
    }

    function menuvale(){
        $this->data["dados_emitente"] = $this->almoxarifado_model->getEmitente();
        $this->data["dados_departamento"] = $this->almoxarifado_model->getDepartamento();
        $where = "";
        $primeiro = true;
        if(!empty($this->input->post('os'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where almo_estoque.idOs = ".$this->input->post('os');
            }else{*/
                $where = $where." and almo_estoque.idOs = ".$this->input->post('os');/*
            }*/
        }
        if(!empty($this->input->post('desc'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where insumos.descricaoInsumo = ".$this->input->post('desc');
            }else{*/
                $where = $where." and insumos.descricaoInsumo like '%".$this->input->post('desc')."%'";/*
            }*/
        }
        if(!empty($this->input->post('idEmpresa'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where almo_estoque.idEmitente = ".$this->input->post('idEmitente');
            }else{*/
                $where = $where." and almo_estoque.idEmitente = ".$this->input->post('idEmpresa');/*
            }*/
        }
        if(!empty($this->input->post('idDepartamento'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where almo_estoque.idDepartamento = ".$this->input->post('idDepartamento');
            }else{*/
                $where = $where." and almo_estoque.idDepartamento = ".$this->input->post('idDepartamento');/*
            }*/
        }
        $this->data["historico"] = $this->almoxarifado_model->getHistoricoVale();
        $this->data["itens"] = $this->almoxarifado_model->getItensReservadoOs($where);
        $this->data["motivos"] = $this->almoxarifado_model->get2("motivos_vale", " * ",null,false);
        $this->data['view'] = 'almoxarifado/gerencia/gerencia';
       	$this->load->view('tema/topo',$this->data);
    }
    function gerencia2(){
        $this->data["dados_emitente"] = $this->almoxarifado_model->getEmitente();
        $this->data["dados_departamento"] = $this->almoxarifado_model->getDepartamento();
        $where = "";
        $primeiro = true;
        if(!empty($this->input->post('os'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where almo_estoque.idOs = ".$this->input->post('os');
            }else{*/
                $where = $where." and almo_estoque_saida.idOs = ".$this->input->post('os');/*
            }*/
        }
        if(!empty($this->input->post('desc'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where insumos.descricaoInsumo = ".$this->input->post('desc');
            }else{*/
                $where = $where." and insumos.descricaoInsumo like '%".$this->input->post('desc')."%'";/*
            }*/
        }
        if(!empty($this->input->post('idEmpresa'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where almo_estoque.idEmitente = ".$this->input->post('idEmitente');
            }else{*/
                $where = $where." and almo_estoque.idEmitente = ".$this->input->post('idEmpresa');/*
            }*/
        }
        if(!empty($this->input->post('idDepartamento'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where almo_estoque.idDepartamento = ".$this->input->post('idDepartamento');
            }else{*/
                $where = $where." and almo_estoque.idDepartamento = ".$this->input->post('idDepartamento');/*
            }*/
        }
        $this->data['destinoPecasHist'] =  $this->almoxarifado_model->getDestinoPecasHis();
        $this->data['destinoPecas'] =  $this->almoxarifado_model->getDestinoPecas();
        $this->data['motivosPerda'] =  $this->producao_model->getAllMotivosPerda();
        $this->data['estoqueMorte'] =  $this->almoxarifado_model->getEstoqueMorte();
        $this->data["historico"] = $this->almoxarifado_model->getHistoricoPecasMortas();
        $this->data["itens"] = $this->almoxarifado_model->getSaida($where);
        $this->data['view'] = 'almoxarifado/gerencia/gerencia2';
       	$this->load->view('tema/topo',$this->data);
    }
    function gerencia3(){
        $this->data["dados_emitente"] = $this->almoxarifado_model->getEmitente();
        $this->data["dados_departamento"] = $this->almoxarifado_model->getDepartamento();
        $where = "";
        $primeiro = true;
        if(!empty($this->input->post('os'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where almo_estoque.idOs = ".$this->input->post('os');
            }else{*/
                $where = $where." and os.idOs = ".$this->input->post('os');/*
            }*/
        }
        if(!empty($this->input->post('cliente'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where insumos.descricaoInsumo = ".$this->input->post('desc');
            }else{*/
                $where = $where." and clientes.nomeCliente like '%".$this->input->post('cliente')."%'";/*
            }*/
        }
        if(!empty($this->input->post('vendedor'))){/*
            if($primeiro){
                $primeiro = false;
                $where = $where."where almo_estoque.idEmitente = ".$this->input->post('idEmitente');
            }else{*/
                $where = $where." and vendedores.nomeVendedor like '%".$this->input->post('vendedor')."%'";/*
            }*/
        }        
        if(empty($where)){
            $where = " and pecas_mortas.idPecaMorta is not null";
        }
        $this->data["historico"] = $this->almoxarifado_model->getHistoricoLiberarPCP();
        $this->data["itens"] = $this->almoxarifado_model->getOsTravadas($where);
        $this->data["motivos"] = $this->almoxarifado_model->get2('motivos_liberacao',"*",null,false);
        $this->data['view'] = 'almoxarifado/gerencia/gerencia3';
       	$this->load->view('tema/topo',$this->data);
    }
    function gerencia_idea(){ //testando layout diferente
        $this->data["itens"] = $this->almoxarifado_model->getItensReservadoOs();
        $this->data["dados_emitente"] = $this->almoxarifado_model->getEmitente();
        $this->data["dados_departamento"] = $this->almoxarifado_model->getDepartamento();
        $this->data['view'] = 'almoxarifado/gerencia';
       	$this->load->view('tema/topo2',$this->data);
    }
    function vale(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVale')){
            $this->session->set_flashdata('error','Você não tem permissão para realizar vale.');
            redirect(base_url());
            return;
        }
        $idEstoque = $this->input->post('idEstoque2');
        $idOsOri = $this->input->post('idOs2');
        $idOsDest = $this->input->post('idOs3');
        //$nomeStatus = $this->input->post('nomeStatus2');
        //$descricaoInsumo = $this->input->post('descricaoInsumo2');
        $quantidadeEst = $this->input->post('quantidade2');
        $quantidadeDest = $this->input->post('quantidade3');
        if($quantidadeDest>$quantidadeEst){
            $this->session->set_flashdata('error','A quantidade informada é maior que a quantidade em estoque.');
            redirect(base_url()."index.php/almoxarifado/menuvale");
            return;
        }
        /*
        $data = array( 
            "quantidade"=>$quantidadeDest,
            "idOsDest"=>$idOsDest,
            "idOsOri"=>$idOsOri,
            "idUser"=>$this->session->userdata('idUsuarios')
        );*/
        $estoque = $this->almoxarifado_model->get2("almo_estoque","*","idAlmoEstoque = ".$idEstoque,true);
        
        $os = $this->almoxarifado_model->get("os","*","idOs = $idOsDest");
        if(empty($os)){
            $this->session->set_flashdata('error','A O.S. de destino não existe.');
            redirect(base_url()."index.php/almoxarifado/menuvale");
            return;
        }
        //$estoque->idAlmoEstoque = null;
        $estoqueDest = clone $estoque;
        $estoqueDest->quantidade = intval($quantidadeDest);
        $estoqueDest->idOs = $idOsDest;
        $estoqueDest->idAlmoEstoque = null;
        $qtdnew = intval($estoque->quantidade) - intval($quantidadeDest);
        $estoque->quantidade = $qtdnew;
        echo json_encode($estoqueDest);
        
        echo json_encode($estoque);
        
        $this->load->model('usuarios_model');

        $this->data["verificaPMEL"] = $this->almoxarifado_model->verificaPMEL($estoqueDest->idProduto,$estoque->metrica,$estoque->comprimento,$estoque->volume,$estoque->peso,$estoqueDest->dimensoesL,$estoqueDest->dimensoesC,$estoque->dimensoesA,$estoqueDest->idEmitente,$estoqueDest->idLocal,$estoqueDest->idDepartamento,$estoqueDest->idOs);
        
        if(count($this->data["verificaPMEL"] )<1){
            $this->almoxarifado_model->criarEstoque($estoqueDest->idProduto,$estoque->metrica,$estoque->comprimento,$estoque->volume,$estoque->peso,$estoqueDest->dimensoesL,$estoqueDest->dimensoesC,$estoque->dimensoesA,$estoqueDest->idEmitente,$estoqueDest->idLocal,$estoqueDest->quantidade,$estoqueDest->idDepartamento,$estoqueDest->idOs);
            $this->almoxarifado_model->edit("almo_estoque",$estoque,"idAlmoEstoque",$estoque->idAlmoEstoque);
        }else{
            $newQtd = $this->data["verificaPMEL"][0]->quantidade + $estoqueDest->quantidade;
            $this->almoxarifado_model->updateEstoque($this->data["verificaPMEL"][0]->idAlmoEstoque,$newQtd,$estoqueDest->idDepartamento,$estoqueDest->idOs);
            $this->almoxarifado_model->edit("almo_estoque",$estoque,"idAlmoEstoque",$estoque->idAlmoEstoque);
        }
        $insumo = $this->almoxarifado_model->get2("insumos","*","idInsumos = ".$estoque->idProduto,true);
        $data = array(
            "quantidade"=>$quantidadeDest,
            "idOsOrig"=>$idOsOri,
            "idInsumo"=>$estoque->idProduto,
            "idOsDest"=>$idOsDest,
            "idUser"=>$this->session->userdata('idUsuarios'),
            "data_insert"=>date('Y-m-d H:i:s')
        );
        $email = "";
        $userPCP = $this->usuarios_model->getUsuariosPcp();
        foreach($userPCP as $r){
            if(!empty($r->email)){
                $email = $email.$r->email.",";
            }
        }
        $this->send($email,"VALE REALIZADO O.S.: $idOsOri","ITEM: ".$insumo->descricaoInsumo);
        $this->almoxarifado_model->add("hist_vale",$data);
        $this->session->set_flashdata('success','Vale feito com sucesso.');
        redirect(base_url()."index.php/almoxarifado/menuvale");
        return;
    }
    function pecamorta(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePecamorta')){
            $this->session->set_flashdata('error','Você não tem permissão para informar peças mortas.');
            redirect(base_url());
            return;
        }
        $idSaida = $this->input->post('idSaida2');
        $quantidade = $this->input->post('quantidade3');

        $saida = $this->almoxarifado_model->get2('almo_estoque_saida', ' * ','idAlmoEstoqueSaida = '.$idSaida,true);
        if($saida->quantidade < $quantidade){
            $this->session->set_flashdata('error','A quantidade informada é maior que a quantidade da saída.');
            redirect(base_url()."index.php/almoxarifado/gerencia2");
            return;
        }
        $qtdSomaPM = 0;
        $pecasMortas = $this->almoxarifado_model->get2('pecas_mortas',' * ','idAlmoEstoqueSaida = '.$idSaida,false);
        foreach($pecasMortas as $r){
            $qtdSomaPM = $qtdSomaPM + $r->quantidade;
        }
        if($saida->quantidade < $quantidade + $qtdSomaPM){
            $this->session->set_flashdata('error','A quantidade informada somada a quantidade de peças mortas registrada anteriormente dessa mesma saída supera a quantidade informada na saída do almoxarifado.');
            redirect(base_url()."index.php/almoxarifado/gerencia2");
            return;
        }
        $this->load->model('pedidocompra_model');
        $insumo = $this->almoxarifado_model->getSaida("WHERE idAlmoEstoqueSaida = ".$idSaida);
        $distribuirOs = $this->pedidocompra_model->getValorInsumoByIdInsumo($insumo[0]->idInsumos);
        $data = array(
            'quantidade'=>$quantidade,
            'usuario'=>$this->session->userdata('idUsuarios'),
            'data_cadastro'=>date('Y-m-d H:i:s'),
            'idAlmoEstoqueSaida'=>$idSaida,
            'valorUnitario'=>$distribuirOs->valor_unitario,
            'idOs'=>$saida->idOs,
            'obs'=>$this->input->post('obs'),
            'idEmitente'=>$this->input->post('idEmpresa'),
            'idMotivoPerda'=>$this->input->post('idMotivo')
        );
        $estoque = $this->almoxarifado_model->get2("almo_estoque"," * ","idAlmoEstoque = ".$saida->idAlmoEstoque,true);
        if($this->almoxarifado_model->add('pecas_mortas',$data)){
            $data2 = array(
                'quantidade'=>$quantidade,
                "idInsumo"=>$estoque->idProduto,
                'idOs'=>$saida->idOs,
                "idEmitente"=>$this->input->post('idEmpresa'),
                'obs'=>$this->input->post('obs'),
                'valorUnitario'=>$distribuirOs->valor_unitario,
                'idMotivoPerda'=>$this->input->post('idMotivo')
            );
            $this->almoxarifado_model->add('pecas_mortas_estoque',$data2);
            $this->session->set_flashdata('success','Peça Morta registrada com sucesso.');
            redirect(base_url()."index.php/almoxarifado/gerencia2");
            return;
        }else{
            $this->session->set_flashdata('error','Houve um erro ao registrar a peça morta, tente novamente. Caso persista informe ao responsável pelo sistema.');
            redirect(base_url()."index.php/almoxarifado/gerencia2");
            return;
        }

    }
    function destravar(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eLiberarpcp')){
            $this->session->set_flashdata('error','Você não tem permissão para liberar cadastro de materiais para o PCP.');
            redirect(base_url());
            return;
        }
        $idOs = $this->input->post('idOs2');
        $motivo = $this->input->post('motivoLib');

        $data = array(
            "fechadoPCP"=>0
        );
        if(empty($motivo)){
            $this->session->set_flashdata('error','O motivo não pode está vazio.');
            redirect(base_url()."index.php/almoxarifado/gerencia3");
            return;
        }
        $this->almoxarifado_model->edit("os",$data,"idOs",$idOs);

        $data2 = array(
            "fechadoPCP"=>0,
            "idUser"=>$this->session->userdata('idUsuarios'),
            "idOs"=>$idOs,
            "data_insert"=>date('Y-m-d H:i:s'),
            "idMotivoLib"=>$motivo
        );
        $this->almoxarifado_model->add("hist_fechadoPCP",$data2);
        $this->session->set_flashdata('success','O.S. Liberada com sucesso.');
        redirect(base_url()."index.php/almoxarifado/gerencia3");
        return;

    }
    function destravar2(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eLiberarpcp')){
            $this->session->set_flashdata('error','Você não tem permissão para liberar cadastro de materiais para o PCP.');
            redirect(base_url());
            return;
        }
        $idOs = $this->input->post('idOs2');
        $motivo = $this->input->post('motivoLib');

        $data = array(
            "fechadoPCP"=>0
        );
        if(empty($motivo)){
            $this->session->set_flashdata('error','O motivo não pode está vazio.');
            redirect(base_url()."index.php/os/visualizar/".$idOs);
            return;
        }
        $this->almoxarifado_model->edit("os",$data,"idOs",$idOs);

        $data2 = array(
            "fechadoPCP"=>0,
            "idUser"=>$this->session->userdata('idUsuarios'),
            "idOs"=>$idOs,
            "data_insert"=>date('Y-m-d H:i:s'),
            "idMotivoLib"=>$motivo
        );
        $this->almoxarifado_model->add("hist_fechadoPCP",$data2);
        $this->session->set_flashdata('success','O.S. Liberada com sucesso.');
        redirect(base_url()."index.php/os/visualizar/".$idOs);
        return;

    }
    public function autoCompleteCliente(){

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteCliente($q);
        }

    }
    public function autoCompleteVendedor(){

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->almoxarifado_model->autoCompleteVendedor($q);
        }

    }
    public function getInfoPecaMorta(){        
        $idPecaMorta = $this->input->post('idPecasMortasEstoque');
        $obj = $this->almoxarifado_model->getPecaMortaEstoque($idPecaMorta);
        $json = array("result"=>true,"resposta"=>$obj);
        echo json_encode($json);
    }    
    public function saidapecamorta(){
        $idPecaMorta = $this->input->post('idPecasMortas');
        
        if(!empty($this->input->post('idOs'))){
            $idOsDestino = $this->input->post('idOs');
        }else{
            $idOsDestino = null;
        }
        foreach($idPecaMorta as $r){
            $obj = $this->almoxarifado_model->getPecaMortaEstoque2($r);
            $saida = array(
                "idPecasMortasEstoque" => $obj->idPecasMortasEstoque,
                "idInsumo"=> $obj->idInsumo,
                "quantidade"=> intval($obj->quantidade),
                "idDestino"=>$this->input->post('idDestino'),
                "idOsDestino"=>$idOsDestino,
                "data_insert"=>date('Y-m-d H:i:s')
            );
            $obj->quantidade = 0;
            $this->almoxarifado_model->edit('pecas_mortas_estoque',$obj,'idPecasMortasEstoque',$obj->idPecasMortasEstoque);
            $this->almoxarifado_model->add('pecas_mortas_saida',$saida);
            
            $this->session->set_flashdata('success','Peças Mortas retiradas com sucesso.');
            redirect(base_url().'index.php/almoxarifado/gerencia2/4');
        }
    }
    function send($to,$assunto,$msg) {
        $this->load->config('email');
        $this->load->library('email');
        
        $from = $this->config->item('smtp_user');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($assunto);
        $this->email->message($msg);

        if ($this->email->send()) {
            echo 'Your Email has successfully been sent.';
        } else {
            show_error($this->email->print_debugger());
        }
    }
    function desvincularitens(){
        $this->data['result'] = $this->almoxarifado_model->getItensReservadoOs(" and status_os.nomeStatusOs like '%(F)%'");
        $this->data['view'] = 'almoxarifado/desvincularitens';
       	$this->load->view('tema/topo',$this->data);

    }
    function getInfoAlmoEstoque(){
       $result = $this->almoxarifado_model->getItensReservadoOs(" and almo_estoque.idAlmoEstoque = ".$this->input->post('idAlmoEstoque')); 
       $json = array('result'=>true,'resultado'=>$result);
       echo json_encode($json);
    }
    function confirmardesvinculacao(){
        $data = array(
            "idOs"=>null
        );
        foreach($this->input->post("idAlmoEstoqueCheck") as $r){
            $itemEstoque = $this->almoxarifado_model->get2('almo_estoque',' * ','idAlmoEstoque = '.$r,true);
            $data2 = array(
                'idOs'=>$itemEstoque->idOs,
                'idAlmoEstoque'=>$itemEstoque->idAlmoEstoque,
                'quantidade'=>$itemEstoque->quantidade,
                'data_insert'=>date('Y-m-d H:i:s')
            );
            $this->almoxarifado_model->add('hist_desvinculo_estoque',$data2);
            $this->almoxarifado_model->edit('almo_estoque',$data,'idAlmoEstoque',$r);
        }
        $this->session->set_flashdata('success','Materiais desvinculados com sucesso.');
        redirect(base_url().'index.php/almoxarifado/desvincularitens');
    }

    function ordemservico(){
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
            redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->model('os_model');

        if (!empty($this->input->get('idOrcamentos'))) {
            $cod_orc = $this->input->get('idOrcamentos');
        } else {
            $cod_orc = $this->input->post('idOrcamentos');
        }



        $config['base_url'] = base_url() . 'index.php/almoxarifado/ordemservico/';
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

        if (!empty($idOs) || !empty($cod_orc) || !empty($clientes_id) || !empty($idProdutos) || !empty($numpedido_os) || !empty($tag) || !empty($numero_nf) || !empty($descricao_item) || !empty($unidade_execucao) || !empty($query_unid_execucao) || !empty($query_unid_faturamento) || !empty($query_tipoos) || !empty($query_status_producao)  || !empty($query_verifControl) || !empty($numero_nffab) || !empty($query_desenho) ) {




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


            $this->data['results'] = $this->os_model->getos('os', 'os.data_abertura_real,os.data_insert,verificacao_controle.*,grupo_servico.*,os.statusDesenho,os.obsDesenho,os.desconto_os,os.val_unit_os,os.numpedido_os,os.tag,os.val_ipi_os,os.idOs,os.`data_abertura`,os.`subtot_os`,os.`data_entrega`,os.`data_reagendada`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,os_tipo.nome_tipo,(SELECT anexo_desenho.idAnexo from anexo_desenho where  anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue,status_os.nomeStatusOs ', '', 'os', $config['per_page'], $this->uri->segment(3));
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

        $this->data['view'] = 'almoxarifado/ordemservico_almo.php';
        $this->load->view('tema/topo', $this->data);
        //$this->load->view('tema/rodape');
    }
    function carregarInfoInsumo(){
        $arrayComOS =$this->almoxarifado_model->getEstoqueNot0AndReservadoByIdInsumo($this->input->post("idInsumo"));
        $arraySemOs = $this->almoxarifado_model->getEstoqueNot0AndNotReservadoByIdInsumo($this->input->post("idInsumo"));
        $result = array_merge($arrayComOS,$arraySemOs);
        echo json_encode(array("result"=>true,"obj"=>$result));
    }
    function imprimircodbarras(){
        //echo $_GET["my_data"];
        //echo "<br>";
        //$var = json_decode($_GET["my_data"]);
        //echo json_encode($var[0]->idEmpresaTDProd);
        // SEGURANÇA: usar input helper do CI com XSS filtering
        $this->data['result'] = json_decode($this->input->get('my_data', TRUE));
        $this->data['view'] = 'almoxarifado/imprimircodbarras.php';
        $this->load->view('almoxarifado/imprimircodbarras', $this->data);
    }
    function linhadotempo(){
        $this->load->model('pedidocompra_model');
        $this->load->model('os_model');
		$this->load->helper('global_function');
        $this->data["dados_emitente"] = $this->almoxarifado_model->getEmitente();
        $this->data["dados_departamento"] = $this->almoxarifado_model->getDepartamento();
        $datahj = date('Y-m-d')." 23:59:59";
        $this->data['datahjexib'] = date("d/m/Y");
        $where = '';
        $where2 = '';
        if(!empty($this->input->post("data"))){
           $datahj = converterData($this->input->post("data"))." 23:59:59";
           $this->data['datahjexib'] = $this->input->post("data");
        }
        if(!empty($this->input->post("idEmpresa"))){
            $where .= " and almo_estoque.idEmitente = ".$this->input->post("idEmpresa");
            $where2 .= " and almo_estoque_produtos.idEmitente = ".$this->input->post("idEmpresa");
        }
        if(!empty($this->input->post("idDepartamento"))){
            $where .= " and almo_estoque.idDepartamento = ".$this->input->post("idDepartamento");
            $where2 .= " and almo_estoque_produtos.idDepartamento = ".$this->input->post("idDepartamento");
        }
        $this->data['comvalor'] = 0;
        $this->data['semvalor'] = 0;
        $result2 = array();
        $result = $this->almoxarifado_model->getLinhaDotempo($datahj,$where);
        $result2 = $this->almoxarifado_model->getLinhaDotempoProd($datahj,$where2);/**/
        foreach($result as $r){
            $objSuprimentos = $this->pedidocompra_model->getAllComprasByIdInsumo($r->idInsumos);
            if(empty($objSuprimentos)){
                $r->mediaValorUnit = 0;
                $this->data['semvalor']++;
            }else{
                if($objSuprimentos->valor_total!= 0 && $objSuprimentos->quantidade !=0){
                    $r->mediaValorUnit = $objSuprimentos->valor_total/$objSuprimentos->quantidade;
                    $this->data['comvalor']++;
                }else{
                    $r->mediaValorUnit = 0;
                    $this->data['semvalor']++;
                }
            }
        }
        foreach($result2 as $r){
            $objOs = $this->os_model->getLastSaleByIdProdutos($r->idProdutos);
            if(empty($objOs)){
                $r->mediaValorUnit = 0;                
                $this->data['semvalor']++;
            }else{
                if($objOs->valor_total!= 0 && $objOs->quantidade !=0){
                    $r->mediaValorUnit = $objOs->valor_total/$objOs->quantidade;
                    $this->data['comvalor']++;
                }else{
                    $r->mediaValorUnit = 0;
                    $this->data['semvalor']++;
                }
            }
            
        }
        $this->data['result'] = //usort(array_merge($result,$result2),function($a,$b){return strcmp($a->descricaoInsumo,$b->descricaoInsumo);});
        $this->data['result'] = array_merge($result,$result2);
        //usort($this->data['results'],function($a,$b){return  strcmp($a->descricaoInsumo,$b->descricaoInsumo);});
        //$this->data['result'] = $this->almoxarifado_model->getLinhaDotempo($datahj,$where);
        $this->data['view'] = 'almoxarifado/linhadotempo';
       	$this->load->view('tema/topo',$this->data);
    }
    function receber(){
        
        $this->data['view'] = 'almoxarifado/recebermercadoria';
       	$this->load->view('tema/topo',$this->data);
    }
	
public function exportarExcelEstoque($tipo = 'geral') {
    $this->load->model('almoxarifado_model');
    
    // Define o nome do arquivo
    $filename = "estoque_" . $tipo . "_" . date('Ymd_His') . ".csv";
    
    // Configura os headers para download de CSV (Excel reconhece)
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    // Adiciona o BOM para o Excel reconhecer caracteres especiais (UTF-8)
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    // Cabeçalhos das colunas
    fputcsv($output, array('Tabela', 'Descrição', 'PN', 'Quantidade', 'Valor Unit. Médio', 'Valor Total', 'Departamento', 'Empresa'), ';');

    if ($tipo == 'atual') {
        // Busca os dados do relatório detalhado (Insumos)
        $dados = $this->almoxarifado_model->getRelatorioInicial();
    } else {
        // Busca unificado (Insumos + Produtos)
        $dadosInsumos = $this->almoxarifado_model->getRelatorioInicial2(""); 
        $dadosProdutos = $this->almoxarifado_model->getRelatorioInicial2Produtos("");
        $dados = array_merge($dadosInsumos, $dadosProdutos);
    }

    foreach ($dados as $row) {
        fputcsv($output, array(
            isset($row->idInsumos) ? 'Insumo' : 'Produto',
            isset($row->descricaoInsumo) ? $row->descricaoInsumo : $row->descricao,
            isset($row->pn_insumo) ? $row->pn_insumo : (isset($row->pn) ? $row->pn : ''),
            $row->quantidade_total,
            number_format($row->valor_unit_medio, 3, ',', '.'),
            number_format($row->valor_total, 2, ',', '.'),
            isset($row->descricaoDepartamento) ? $row->descricaoDepartamento : '',
            isset($row->nome) ? $row->nome : ''
        ), ';');
    }

    fclose($output);
    exit;
}	

public function exportarEstoqueAtualExcel() {
        $empresa = $this->input->get('empresa');
        $departamento = $this->input->get('departamento');
        $prode = $this->input->get('prode');
        $pn = $this->input->get('pn');
        $idOs = $this->input->get('idOs');
        $local = $this->input->get('local');
        
        $whereArr = [];
        if (!empty($empresa) && $empresa != '0') { $whereArr[] = "almo_estoque.idEmitente = " . (int)$empresa; }
        if (!empty($departamento) && $departamento != '0') { $whereArr[] = "almo_estoque.idDepartamento = " . (int)$departamento; }
        if (!empty($prode)) { $whereArr[] = "insumos.descricaoInsumo LIKE '%" . $this->db->escape_like_str($prode) . "%'"; }
        if (!empty($pn)) { $whereArr[] = "insumos.pn_insumo LIKE '%" . $this->db->escape_like_str($pn) . "%'"; }
        if (!empty($idOs)) { $whereArr[] = "almo_estoque.idOs = " . (int)$idOs; }
        if (!empty($local)) { $whereArr[] = "almo_estoque_locais.local LIKE '%" . $this->db->escape_like_str($local) . "%'"; }

        $where = count($whereArr) > 0 ? implode(" AND ", $whereArr) : "";

        $this->load->model('almoxarifado_model');
        $dados = $this->almoxarifado_model->getEstoqueFilter($where);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=estoque_atual_' . date('Ymd_His') . '.csv');
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8 (corrige acentos no Excel)

        fputcsv($output, array('PN', 'Descrição', 'Quantidade', 'O.S.', 'Empresa', 'Departamento', 'Local'), ';');

        foreach ($dados as $r) {
            // Lógica para formatar quantidade baseada na métrica
            $qtd = $r->quantidade;
            if($r->metrica == 1) { $qtd .= " | ".$r->comprimento." MM"; }
            if($r->metrica == 2) { $qtd .= " | ".$r->volume." ML"; }
            if($r->metrica == 3) { $qtd .= " | ".$r->peso." G"; }
            if($r->metrica == 4) { $qtd .= " | ".$r->dimensoesL."x".$r->dimensoesC."x".$r->dimensoesA; }

            fputcsv($output, array(
                $r->pn_insumo,
                $r->descricaoInsumo,
                $qtd,
                $r->idOs,
                $r->nome,
                $r->descricaoDepartamento,
                $r->local
            ), ';');
        }
        fclose($output);
        exit;
    }

    public function exportarEstoqueGeralExcel() {
        $empresa = $this->input->get('empresa');
        $departamento = $this->input->get('departamento');
        $descricao = $this->input->get('descricao');
        $pn = $this->input->get('pn');

        $whereArrInsumo = [];
        $whereArrProduto = [];

        if (!empty($empresa) && $empresa != '0') {
            $whereArrInsumo[] = "almo_estoque.idEmitente = " . (int)$empresa;
            $whereArrProduto[] = "almo_estoque_produtos.idEmitente = " . (int)$empresa;
        }
        if (!empty($departamento) && $departamento != '0') {
            $whereArrInsumo[] = "almo_estoque.idDepartamento = " . (int)$departamento;
            $whereArrProduto[] = "almo_estoque_produtos.idDepartamento = " . (int)$departamento;
        }
        if (!empty($descricao)) {
            $whereArrInsumo[] = "insumos.descricaoInsumo LIKE '%" . $this->db->escape_like_str($descricao) . "%'";
            $whereArrProduto[] = "produtos.descricao LIKE '%" . $this->db->escape_like_str($descricao) . "%'";
        }
        if (!empty($pn)) {
            $whereArrInsumo[] = "insumos.pn_insumo LIKE '%" . $this->db->escape_like_str($pn) . "%'";
            $whereArrProduto[] = "produtos.pn LIKE '%" . $this->db->escape_like_str($pn) . "%'";
        }

        $whereInsumo = count($whereArrInsumo) > 0 ? implode(" AND ", $whereArrInsumo) : "";
        $whereProduto = count($whereArrProduto) > 0 ? implode(" AND ", $whereArrProduto) : "";

        $this->load->model('almoxarifado_model');
        $dadosInsumos = $this->almoxarifado_model->getRelatorioInicial2($whereInsumo);
        $dadosProdutos = $this->almoxarifado_model->getRelatorioInicial2Produtos($whereProduto);

        $dados = array_merge($dadosInsumos, $dadosProdutos);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=estoque_geral_' . date('Ymd_His') . '.csv');
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($output, array('PN', 'Descrição', 'Valor Unit. Medio', 'Valor Total Entrada', 'Valor Total Saida', 'Valor Total Estoque', 'Qtd. Entrada', 'Qtd. Saida', 'Qtd. Atual', 'Empresa', 'Departamento'), ';');

        foreach ($dados as $r) {
            fputcsv($output, array(
                isset($r->pn_insumo) ? $r->pn_insumo : (isset($r->pn) ? $r->pn : ''),
                isset($r->descricaoInsumo) ? $r->descricaoInsumo : (isset($r->descricao) ? $r->descricao : ''),
                number_format((float)$r->valor_unit_medio, 3, ',', '.'),
                number_format((float)$r->valor_total_entrada, 3, ',', '.'),
                number_format((float)$r->valor_total_saida, 3, ',', '.'),
                number_format((float)$r->valor_total, 3, ',', '.'),
                $r->quantidade_entrada,
                $r->quantidade_saida,
                $r->quantidade_total,
                $r->nome,
                $r->descricaoDepartamento
            ), ';');
        }
        fclose($output);
        exit;
    }
}