<?php

class Almoxarifado extends CI_Controller {

    function __construct() {
        parent::__construct();
                if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
                    redirect('mapos/login');
                }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('almoxarifado_model','',TRUE);
		$this->data['menuAlmoxarifado'] = 'Almoxarifado';
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
            }else{
                $dim="";
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
                $idOs="";
            }
            if(!empty($this->input->post('valorUnit_')[$x])){
                $vu = str_replace(".","",$this->input->post('valorUnit_')[$x]);
                $vu = str_replace(",",".",$vu);
            }else{
                $vu="";
            }       
            if($m==0 || $m==1 || $m==2 || $m==3 || $m==4){
                $this->data["verificaPMEL"] = $this->almoxarifado_model->verificaPMEL($p,$m,$c,$v,$ps,$dim,$e,$l,$dep,$idOs);
                if(count($this->data["verificaPMEL"] )<1){
                    $this->almoxarifado_model->criarEstoqueEntrada($p,$m,$c,$v,$ps,$dim,$e,$l,$this->input->post('qtdTD_')[$x],$idUser,$nf,$idOs,$vu,$dep);
                    $this->almoxarifado_model->criarEstoque($p,$m,$c,$v,$ps,$dim,$e,$l,$this->input->post('qtdTD_')[$x],$dep,$idOs);
                }else {
                    $newQtd = $this->data["verificaPMEL"][0]->quantidade + $this->input->post('qtdTD_')[$x];
                    $this->almoxarifado_model->criarEstoqueEntrada($p,$m,$c,$v,$ps,$dim,$e,$l,$this->input->post('qtdTD_')[$x],$idUser,$nf,$idOs,$vu,$dep);
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
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
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
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteEstoqueSaida($q,$e,$d);
        }
    }
    public function autoCompleteFunc(){
        
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteFunc($q);
        }
    }
    public function autoCompleteCategoriaSubCategoria(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteCategoriaSubCategoria($q);
        }
    }
    public function autoCompleteSubcategoria(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteSubcategoria($q);
        }
    }
    public function autoCompleteInsumos(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteInsumos($q);
        }
    }
    public function autoCompletePN(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompletePN($q);
        }
    }
    public function autoCompleteREF2(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
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
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
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
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
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
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
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
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteREFEstoque($q,$e,$d);
        }
    }
    
    public function Busca_Estoque_Filtro(){
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        $this->load->model('estoque_model');
        $this->load->model('insumos_model');
        $primeiro = true;
        $where = "";
        $whereProd = "";
        if(!empty($this->input->post("prode"))){
            if($primeiro){
                $where = $where." insumos.descricaoInsumo like '%".$this->input->post("prode")."%'";
                $whereProd = $whereProd." produtos.descricao like '%".$this->input->post("prode")."%'";
                $primeiro = false;
            }else{
                $where = $where." and insumos.descricaoInsumo like '%".$this->input->post("prode")."%'";
                $whereProd = $whereProd." and produtos.descricao like '%".$this->input->post("prode")."%'";
            }
        }/*
        if(!empty($this->input->post("idMedicaoe"))){
            if($this->input->post("idMedicaoe") == 1){
                $metrica = 0;
            }else if($this->input->post("idMedicaoe") == 2){
                $metrica = 1;
            }else if($this->input->post("idMedicaoe") == 3){
                $metrica = 2;
            }else if($this->input->post("idMedicaoe") == 4){
                $metrica = 3;
            }
            if($primeiro){
                $where = $where." almo_estoque.metrica = ".$metrica;
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque.metrica = ".$metrica;
            }
        }
        if(!empty($this->input->post("tamanhoe"))){
            if($primeiro){
                $where = $where." almo_estoque.comprimento = ".$this->input->post("tamanhoe");
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque.comprimento = ".$this->input->post("tamanhoe");
            }
        }
        if(!empty($this->input->post("volumee"))){
            if($primeiro){
                $where = $where." almo_estoque.volume = ".$this->input->post("volumee");
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque.volume = ".$this->input->post("volumee");
            }
        }
        if(!empty($this->input->post("pesoe"))){
            if($primeiro){
                $where = $where." almo_estoque.peso = ".$this->input->post("pesoe");
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque.peso = ".$this->input->post("pesoe");
            }
        }*/
        if(!empty($this->input->post("idEmpresae"))){
            if($primeiro){
                $where = $where." almo_estoque.idEmitente = ".$this->input->post("idEmpresae");
                $whereProd = $whereProd." almo_estoque_produtos.idEmitente = ".$this->input->post("idEmpresae");
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque.idEmitente = ".$this->input->post("idEmpresae");
                $whereProd = $whereProd." and almo_estoque_produtos.idEmitente = ".$this->input->post("idEmpresae");
            }
        }
        if(!empty($this->input->post("pn"))){
            if($primeiro){
                $where = $where." insumos.pn_insumo = '".$this->input->post("pn")."'";
                $whereProd = $whereProd." produtos.pn = '".$this->input->post("pn")."'";
                $primeiro = false;
            }else{
                $where = $where." and insumos.pn_insumo = '".$this->input->post("pn")."'";
                $whereProd = $whereProd." and produtos.pn = '".$this->input->post("pn")."'";
            }
        }
        if(!empty($this->input->post("idLocale"))){
            if($primeiro){
                $where = $where." almo_estoque.idLocal = ".$this->input->post("idLocale");
                $whereProd = $whereProd." almo_estoque_produtos.idLocal = ".$this->input->post("idLocale");
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque.idLocal = ".$this->input->post("idLocale");
                $whereProd = $whereProd." and almo_estoque_produtos.idLocal = ".$this->input->post("idLocale");
            }
        }
        if(!empty($this->input->post("idDepartamentoe"))){
            if($primeiro){
                $where = $where." almo_estoque_departamento.idAlmoEstoqueDep = ".$this->input->post("idDepartamentoe");
                $whereProd = $whereProd." almo_estoque_departamento.idAlmoEstoqueDep = ".$this->input->post("idDepartamentoe");
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_departamento.idAlmoEstoqueDep = ".$this->input->post("idDepartamentoe");
                $whereProd = $whereProd." and almo_estoque_departamento.idAlmoEstoqueDep = ".$this->input->post("idDepartamentoe");
            }
        }
        if($primeiro){
            $where = $where." almo_estoque.quantidade > 0";
            $whereProd = $whereProd." almo_estoque_produtos.quantidade > 0";
            $primeiro = false;
        }else{
            $where = $where." and almo_estoque.quantidade > 0";
            $whereProd = $whereProd." and almo_estoque_produtos.quantidade > 0";
        }
        /*$idUser = $this->session->userdata('idUsuarios');
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
        $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
        //$this->data['dados_saida'] = $this->almoxarifado_model->getSaida();
        //$this->data['dados_entrada'] = $this->almoxarifado_model->getEntrada();
        $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
        $this->data['dados_categoria'] = $this->insumos_model->getCategoria();
        $this->data['dados_insumos'] = $this->insumos_model->getinsumosubcat2();
        //$this->data['dadosRelatorio'] = $this->almoxarifado_model->getRelatorioInicial2();
        $this->data['result'] = $this->almoxarifado_model->getEstoqueFilter($where);
        $this->data['view'] = 'almoxarifado/almoxarifado';
       	$this->load->view('tema/topo',$this->data);*/
        //$resultado = $this->almoxarifado_model->getEstoqueFilter($where);
        $resultado = $this->unificarEstoques(array_merge($this->almoxarifado_model->getEstoqueFilter($where),$this->almoxarifado_model->getEstoqueFilterProdutos($whereProd)));
        $json = array('result'=>true,'resultado'=>$resultado);
        echo json_encode($json);
    }
    public function cadastrarSaidas(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){
            $this->session->set_flashdata('error','Você não tem permissão para cadastrar estoque em Almoxarifado.');
            redirect(base_url());
        } 
        $this->data['custom_error'] = '';
        $idUser = $this->session->userdata('idUsuarios');
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
            $this->almoxarifado_model->cadastrarSaidas($est,$qtd,$emp,$set,$idUser,$user,$idOs,$obs);
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

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteInsumos2($q);
        }
    }
    public function autoCompletePN2(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompletePN2($q);
        }
    }

    public function autoCompleteProd(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
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
            $estoqueExistente = $this->almoxarifado_model->verificaPMEL($almoEstoque[0]->idProduto,$almoEstoque[0]->metrica,$almoEstoque[0]->comprimento,$almoEstoque[0]->volume,$almoEstoque[0]->peso,$almoEstoque[0]->dimensoesL.'x'.$almoEstoque[0]->dimensoesC.'x'.$almoEstoque[0]->dimensoesA,$almoEstoque[0]->idEmitente,$idLocal,$departamento,$almoEstoque[0]->idiOs);
            if(count($estoqueExistente)<1){
                
                $idAlmoDestino = $this->almoxarifado_model->criarEstoque($almoEstoque[0]->idProduto,$almoEstoque[0]->metrica,$almoEstoque[0]->comprimento,$almoEstoque[0]->volume,$almoEstoque[0]->peso,$almoEstoque[0]->dimensoesL.'x'.$almoEstoque[0]->dimensoesC.'x'.$almoEstoque[0]->dimensoesA,$almoEstoque[0]->idEmitente,$idLocal,$quantidade,$departamento,$almoEstoque[0]->idiOs);
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
                $newQtd = $verificacao[0]->quantidade + $almoEstoqueProd[0]->quantidade;
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
    public function relatorioAlmoxarifado(){
        $this->load->model('orcamentos_model');
        $this->load->model('estoque_model');
        $this->data['dados_saida_insumo'] = $this->almoxarifado_model->getSaida();
        $this->data['dados_saida_produto'] = $this->almoxarifado_model->getSaidaProduto();
        $this->data['result'] = $this->unificarEstoques(array_merge($this->almoxarifado_model->getEstoque(),$this->almoxarifado_model->getEstoqueProduto()));
        $this->data['dados_entrada_insumo'] = $this->almoxarifado_model->getEntrada();
        $this->data['dados_entrada_produto'] = $this->almoxarifado_model->getEntradaProduto();
        $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
        $this->data['dadosRelatorio2'] = $this->unificarRelatorio(array_merge($this->almoxarifado_model->getRelatorioInicial2(),$this->almoxarifado_model->getRelatorioInicial2Produtos()));
        $result = $this->unificarRelatorioDet(array_merge($this->almoxarifado_model->getRelatorioInicial(),$this->almoxarifado_model->getRelatorioInicialProdutos()));
        $this->data['dados_saida'] = $this->unificarSaidas(array_merge($this->data['dados_saida_insumo'], $this->data['dados_saida_produto']));
        $this->data['dados_entrada'] = $this->unificarEntradas(array_merge($this->data['dados_entrada_insumo'], $this->data['dados_entrada_produto']));
        //echo("<script>console.log(".$this->data['data_saida'].");</script>");
        if(count($result)>0){
            for($x=0;$x<count($result);$x++){
                $result[$x]->detalheEstoqueEmpresas = [];
                if($result[$x]->tabela == "insumo"){
                    $result[$x]->detalheEstoqueEmpresas = $this->almoxarifado_model->getRelatorioPorInsumoEmpresa($result[$x]->idInsumos);
                }else{
                    $result[$x]->detalheEstoqueEmpresas = $this->almoxarifado_model->getRelatorioPorProdutoEmpresa($result[$x]->idInsumos);
                }                    
                /*$result[$x]->entradas = [];
                $result[$x]->entradas = $this->almoxarifado_model->getRelatorioEntradaPorInsumo($result[$x]->idInsumos);
                $result[$x]->saidas = [];
                $result[$x]->saidas = $this->almoxarifado_model->getRelatorioSaidaPorInsumo($result[$x]->idInsumos);*/
            }
        }
        $this->data['dadosRelatorio'] = $result;
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
                    "nomeExibicao"=>$r->nomeExibicao,
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
                    "nomeExibicao"=>$r->nomeExibicao,
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
            if(isset($r->idAlmoEstoque)){
                $data= array(
                    "tabela"=>"insumo",
                    "idAlmoEstoque"=>$r->idAlmoEstoque,
                    "idProduto"=>$r->idProduto,
                    "descricaoStatusProduto"=>null,
                    "idEmitente"=>$r->idEmitente,
                    "idLocal"=>$r->idLocal,
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
                    "nomeExibicao"=>$r->nomeExibicao,
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
                    "nomeExibicao"=>$r->nomeExibicao,
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
                    "nomeExibicao"=>$r->nomeExibicao,
                    "destinoNomeExibicao"=>$r->destinoNomeExibicao,
                    "quantidade"=>$r->quantidade,
                    "data_saida"=>$r->data_saida,
                    "idUserSis"=>$r->idUserSis,
                    "idSetor"=>$r->idSetor,
                    "idOs"=>$r->idOs,
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
                    "nomeExibicao"=>$r->nomeExibicao,
                    "destinoNomeExibicao"=>$r->destinoNomeExibicao,
                    "quantidade"=>$r->quantidade,
                    "data_saida"=>$r->data_saida,
                    "idUserSis"=>$r->idUserSis,
                    "idSetor"=>$r->idSetor,
                    "idOs"=>$r->idOs,
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
                    "nomeExibicao"=>$r->nomeExibicao,
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
                    "nomeExibicao"=>$r->nomeExibicao,
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
                $where = $where."WHERE usuarios.idUsuarios  = ".$usuCadEntr;
                $whereProd = $whereProd."WHERE usuarios.idUsuarios  = ".$usuCadEntr;
                $primeiro = false;
            }else{
                $where = $where." and usuarios.idUsuarios  = ".$usuCadEntr;
                $whereProd = $whereProd." and usuarios.idUsuarios  = ".$usuCadEntr;
            }
        }
            
        if(!empty($nfRelEntr)){
            if($primeiro){
                $where = $where."WHERE almo_estoque_entrada.nf  = ".$nfRelEntr;
                $whereProd = $whereProd."WHERE almo_estoque_p_entrada.nf  = ".$nfRelEntr;
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
                $where = $where."WHERE insumos.descricaoInsumo  like '%".$descricao."%'";
                $whereProd = $whereProd."WHERE produtos.descricao  like '%".$descricao."%'";
                $primeiro = false;
            }else{
                $where = $where." and insumos.descricaoInsumo  like  '%".$descricao."%'";
                $whereProd = $whereProd." and produtos.descricao  like '%".$descricao."%'";
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
                $where = $where."WHERE usuarios.idUsuarios  = $usuCadSai";
                $whereProd = $whereProd."WHERE usuarios.idUsuarios  = $usuCadSai";
                $primeiro = false;
            }else{
                $where = $where." and usuarios.idUsuarios  = $usuCadSai";
                $whereProd = $whereProd." and usuarios.idUsuarios  = $usuCadSai";
            }
        }
            
        if(!empty($userSolRelSai)){
            if($primeiro){
                $where = $where."WHERE almo_estoque_saida.idUserSis  = $userSolRelSai";
                $whereProd = $whereProd."WHERE almo_estoque_p_saida.idUserSis  = $userSolRelSai";
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque_saida.idUserSis  = $userSolRelSai";
                $whereProd = $whereProd." and almo_estoque_p_saida.idUserSis  = $userSolRelSai";
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
                $vu= $arrayEntradas[$x]['valorUnitProd'];
            }else{
                $vu = null;
            }
            if(!empty($arrayEntradas[$x]['idOsTDProd'])){
                $os= $arrayEntradas[$x]['idOsTDProd'];
            }else{
                $os = null;
            }
            if(!empty($arrayEntradas[$x]['idStatusProdutoTDProd'])){
                $sp= $arrayEntradas[$x]['idStatusProdutoTDProd'];
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
            $this->almoxarifado_model->cadastrarSaidasProdutos($est,$qtd,$emp,$set,$idUser,$user,$idOs,$obs);
            $this->data["itemEstoque"]=$this->almoxarifado_model->getItemEstoqueProdutos($est);
            $newQtd = $this->data["itemEstoque"][0]->quantidade - $qtd;
            $this->almoxarifado_model->updateEstoqueProduto($est,$newQtd);
        }
        //$this->salvarlog($this->session->userdata('idUsuarios'),'almoxarifado','inserir',$descricao );
        $json = array('msggg'=>'Saídas cadastradas com sucesso.','result'=>true);
        echo json_encode($json);
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
                $this->data["verificaPMEL"] = $this->almoxarifado_model->verificaPMEL($result[0]->idInsumo,$result[0]->metrica,$result[0]->comprimento ,$result[0]->volume,$result[0]->peso,$result[0]->dimensoesL.'x'.$result[0]->dimensoesC.'x'.$result[0]->dimensoesA,$result[0]->idEmitente,$local,$this->input->post('idDepartamento')[$x]);
                if(count($this->data["verificaPMEL"] )<1){
                    $idEntrada = $this->almoxarifado_model->criarEstoqueEntrada($result[0]->idInsumo,$result[0]->metrica,$result[0]->comprimento,$result[0]->volume,$result[0]->peso,$result[0]->dimensoesL.'x'.$result[0]->dimensoesC.'x'.$result[0]->dimensoesA,$result[0]->idEmitente,$local,$result[0]->quantidade,$idUser,$result[0]->nf,null,$result[0]->valorUnitario,$this->input->post('idDepartamento')[$x]);
                    $this->almoxarifado_model->criarEstoque($result[0]->idInsumo,$result[0]->metrica,$result[0]->comprimento,$result[0]->volume,$result[0]->peso,$result[0]->dimensoesL.'x'.$result[0]->dimensoesC.'x'.$result[0]->dimensoesA,$result[0]->idEmitente,$local,$result[0]->quantidade,$this->input->post('idDepartamento')[$x]);
                }else {
                    $newQtd = $this->data["verificaPMEL"][0]->quantidade + $result[0]->quantidade;
                    $idEntrada = $this->almoxarifado_model->criarEstoqueEntrada($result[0]->idInsumo,$result[0]->metrica,$result[0]->comprimento,$result[0]->volume,$result[0]->peso,$result[0]->dimensoesL.'x'.$result[0]->dimensoesC.'x'.$result[0]->dimensoesA,$result[0]->idEmitente,$local,$result[0]->quantidade,$idUser,$result[0]->nf,null,$result[0]->valorUnitario,$this->input->post('idDepartamento')[$x]);
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
    
}