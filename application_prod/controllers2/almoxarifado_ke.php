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
         $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
         $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
         $this->data['result'] = $this->almoxarifado_model->getEstoque();
         $this->data['dados_saida'] = $this->almoxarifado_model->getSaida();
         $this->data['dados_entrada'] = $this->almoxarifado_model->getEntrada();
         $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
         $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
         $this->data['dados_categoria'] = $this->insumos_model->getCategoria();
         $this->data['dados_insumos'] = $this->insumos_model->getinsumosubcat2();
         $this->data['view'] = 'almoxarifado/almoxarifado';
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
            if(!empty($this->input->post('idEmpresaTD_')[$x])){
                $e = $this->input->post('idEmpresaTD_')[$x];
            }else{
                $e="";
            }
            if(!empty($this->input->post('idLocalpTD_')[$x])){
                $l = $this->input->post('idLocalpTD_')[$x];
            }else{
                $l="";
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
            if($m==0 || $m==1 || $m==2 || $m==3){
                $this->data["verificaPMEL"] = $this->almoxarifado_model->verificaPMEL($p,$m,$c,$v,$ps,$e,$l);
                if(count($this->data["verificaPMEL"] )<1){
                    $this->almoxarifado_model->criarEstoqueEntrada($p,$m,$c,$v,$ps,$e,$l,$this->input->post('qtdTD_')[$x],$idUser,$nf,$idOs,$vu);
                    $this->almoxarifado_model->criarEstoque($p,$m,$c,$v,$ps,$e,$l,$this->input->post('qtdTD_')[$x]);
                }else {
                    $newQtd = $this->data["verificaPMEL"][0]->quantidade + $this->input->post('qtdTD_')[$x];
                    $this->almoxarifado_model->criarEstoqueEntrada($p,$m,$c,$v,$ps,$e,$l,$this->input->post('qtdTD_')[$x],$idUser,$nf,$idOs,$vu);
                    $this->almoxarifado_model->updateEstoque($this->data["verificaPMEL"][0]->idAlmoEstoque,$newQtd);
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
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
        $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
        $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
        $this->data['dados_saida'] = $this->almoxarifado_model->getSaida();
        $this->data['dados_entrada'] = $this->almoxarifado_model->getEntrada();
        $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
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
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteLocais($q,$e);
        }
    }
    public function autoCompleteEstoqueSaida(){
        
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteEstoqueSaida($q,$e);
        }
    }
    public function autoCompleteFunc(){
        
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteFunc($q,$e);
        }
    }
    public function autoCompleteCategoriaSubCategoria(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->almoxarifado_model->autoCompleteCategoriaSubCategoria($q);
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
        if(!empty($this->input->post("idProdutose"))){
            if($primeiro){
                $where = $where." almo_estoque.idProduto = ".$this->input->post("idProdutose");
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque.idProduto = ".$this->input->post("idProdutose");
            }
        }
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
        }
        if(!empty($this->input->post("idEmpresae"))){
            if($primeiro){
                $where = $where." almo_estoque.idEmitente = ".$this->input->post("idEmpresae");
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque.idEmitente = ".$this->input->post("idEmpresae");
            }
        }
        if(!empty($this->input->post("idLocale"))){
            if($primeiro){
                $where = $where." almo_estoque.idLocal = ".$this->input->post("idLocale");
                $primeiro = false;
            }else{
                $where = $where." and almo_estoque.idLocal = ".$this->input->post("idLocale");
            }
        }
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
        $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
        $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
        $this->data['dados_saida'] = $this->almoxarifado_model->getSaida();
        $this->data['dados_entrada'] = $this->almoxarifado_model->getEntrada();
        $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
        $this->data['dados_categoria'] = $this->insumos_model->getCategoria();
        $this->data['dados_insumos'] = $this->insumos_model->getinsumosubcat2();
        $this->data['result'] = $this->almoxarifado_model->getEstoqueFilter($where);
        $this->data['view'] = 'almoxarifado/almoxarifado';
       	$this->load->view('tema/topo',$this->data);

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
            $this->almoxarifado_model->cadastrarSaidas($est,$qtd,$emp,$set,$idUser,$user,$idOs);
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
                $whereEntrada = "and almo_estoque_entrada.idEmitente = ".$this->input->post('idEmpresaRel');
                $whereSaida = "and almo_estoque.idEmitente = ".$this->input->post('idEmpresaRel');
            }
        }
        if(!empty($this->input->post('idDescRel'))){
            if($primeiro){
                $whereEntrada = "where insumos.idInsumos = ".$this->input->post('idDescRel');
                $whereSaida = "where insumos.idInsumos = ".$this->input->post('idDescRel');
                $primeiro = false;
            }else{
                $whereEntrada = "and insumos.idInsumos = ".$this->input->post('idDescRel');
                $whereSaida = "and insumos.idInsumos = ".$this->input->post('idDescRel');
            }
        }
        if(!empty($this->input->post('idUsuCad'))){
            if($primeiro){
                $whereEntrada = "where usuarios.idUsuarios = ".$this->input->post('idUsuCad');
                $whereSaida = "where usuarios.idUsuarios = ".$this->input->post('idUsuCad');
                $primeiro = false;
            }else{
                $whereEntrada = "and usuarios.idUsuarios = ".$this->input->post('idUsuCad');
                $whereSaida = "and usuarios.idUsuarios = ".$this->input->post('idUsuCad');
            }
        }
        $primeiroEntrada = $primeiro;
        $primeiroSaida = $primeiro;
        if(!empty($this->input->post('nfRel'))){
            if($primeiroEntrada){
                $whereEntrada = "where almo_estoque_entrada.nf = ".$this->input->post('nfRel');
                $primeiroEntrada = false;
            }else{
                $whereEntrada = "and almo_estoque_entrada.nf = ".$this->input->post('nfRel');
            }
        }
        if(!empty($this->input->post('idOsRel'))){
            if($primeiroEntrada){
                $whereEntrada = "where almo_estoque_entrada.idOs = ".$this->input->post('idOsRel');
                $primeiroEntrada = false;
            }else{
                $whereEntrada = "and almo_estoque_entrada.idOs = ".$this->input->post('idOsRel');
            }
        }



        if(!empty($this->input->post('idOsRelSa'))){
            if($primeiroSaida){
                $whereSaida = "where almo_estoque_saida.idOs = ".$this->input->post('idOsRelSa');
                $primeiroSaida = false;
            }else{
                $whereSaida = "and almo_estoque_saida.idOs = ".$this->input->post('idOsRelSa');
            }
        }
        if(!empty($this->input->post('idEmpresaDestRel'))){
            if($primeiroSaida){
                $whereSaida = "where almo_estoque_saida.idEmpresaDestino = ".$this->input->post('idEmpresaDestRel');
                $primeiroSaida = false;
            }else{
                $whereSaida = "and almo_estoque_saida.idEmpresaDestino = ".$this->input->post('idEmpresaDestRel');
            }
        }
        if(!empty($this->input->post('idSetorRel'))){
            if($primeiroSaida){
                $whereSaida = "where almo_estoque_saida.idSetor = ".$this->input->post('idSetorRel');
                $primeiroSaida = false;
            }else{
                $whereSaida = "and almo_estoque_saida.idSetor = ".$this->input->post('idSetorRel');
            }
        }
        $this->load->model('orcamentos_model');
        $this->load->model('estoque_model');
        $this->load->model('almoxarifado_model');
        $this->load->model('insumos_model');
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
        $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
        $this->data['result'] = $this->almoxarifado_model->getEstoque();
        $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
        $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
        $this->data['dados_saida'] = $this->almoxarifado_model->getSaida($whereSaida);
        $this->data['dados_categoria'] = $this->insumos_model->getCategoria();
        $this->data['dados_entrada'] = $this->almoxarifado_model->getEntrada($whereEntrada);
        $this->data['dados_insumos'] = $this->insumos_model->getinsumosubcat2();
        $this->data['relatorio'] = true;
        $this->data['view'] = 'almoxarifado/almoxarifado';
       	$this->load->view('tema/topo',$this->data);
    }
    
    public function cadastrarLocal(){
        $this->load->library('form_validation');
        //echo("<script>console.log('Quantidade: test');</script>"); 
        $empresa = $this->input->post('empresa');
        $local = $this->input->post('local');
        if(empty($empresa) || empty($local )){
           $json =  array('result'=>false,'msggg'=>'Preencha os dados corretamente.');
           echo json_encode($json);
        }else {
            $this->almoxarifado_model->cadastrarLocal($empresa,$local);        
            $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
            $json = array('result'=>true,'dados_locais'=>$this->data['dados_locais']);
            echo json_encode($json);
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
            $this->almoxarifado_model->cadastrarUsuario($empresa,$setor,$nome,$cpf);        
            $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
            $json = array('result'=>true);//,'dados_locais'=>$this->data['dados_locais']);
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
            $this->almoxarifado_model->cadastrarInsumos($descricao,$estoqueMinimo,$subcat,$pn );        
            //$this->data['dados_insumos'] = $this->almoxarifado_model->getUsuario();
            $json = array('result'=>true);//,'dados_locais'=>$this->data['dados_locais']);
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
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
        $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');
        $this->data['result'] = $this->almoxarifado_model->getEstoque();
        $this->data['dados_locais'] = $this->almoxarifado_model->getLocais();
        $this->data['dados_usuario'] = $this->almoxarifado_model->getUsuario();
        $this->data['dados_saida'] = $this->almoxarifado_model->getSaida();
        $this->data['dados_categoria'] = $this->insumos_model->getCategoria();
        $this->data['dados_entrada'] = $this->almoxarifado_model->getEntrada();
        $this->data['dados_insumos'] = $this->insumos_model->getinsumosubcat2();
        $this->session->set_flashdata('success','Local excluído com sucesso.');
        redirect(base_url() . 'index.php/almoxarifado/almoxarifado/local');
        //$this->data['view'] = 'almoxarifado/almoxarifado';
       	//$this->load->view('tema/topo',$this->data);


        // echo("<script>console.log('Emitente:".$soma."');</script>");
    }
    public function cadastrarCatESubcat(){
        $categoria = $this->input->post('nomeCategoria');
        $subCategoria = $this->input->post('subCategoria');
        $this->load->model('insumos_model');
        if( $this->insumos_model->getBydescricaoCategoria($categoria) == true)
        {
            $json =  array('result'=>false,'msggg'=>'Essa categoria já existe.');
            echo json_encode($json);
        }
        $idCategoria = $this->almoxarifado_model->cadastrarCategoria($categoria);
        $idSubcategoria = $this->almoxarifado_model->cadastrarSubcategoria($subCategoria,$idCategoria);

        $json = array('result'=>true,"idSubcategoria"=>$idSubcategoria,"descricaoCategoria"=>$categoria,"descricaoSubcategoria"=>$subCategoria);
        echo json_encode($json);
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
        }
        //$idCategoria = $this->almoxarifado_model->cadastrarCategoria($categoria);
        $idSubcategoria = $this->almoxarifado_model->cadastrarSubcategoria($subCategoria,$idCategoria);

        $json = array('result'=>true,"idSubcategoria"=>$idSubcategoria,"descricaoCategoria"=>$categoria,"descricaoSubcategoria"=>$subCategoria);
        echo json_encode($json);
    }
    /*
    public function get_estoque(){
        //$this->load->library('form_validation');
        //$this->data['custom_error'] = '';
        //echo("<script>console.log('Emitente:".$this->input->get("idMedicaoe")."');</script>");
        $result = array();
        $result["idProduto"] = 2;
        return json_encode($result);
    }*/
    
}