<?php

class Desenho extends CI_Controller {
    function __construct() {
        parent::__construct();
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('arquivos_model','',TRUE);
        $this->load->model('desenho_model','',TRUE);
		
		
	}	
	
	function index(){
		$this->aguardandodesenho();
	}
    function aguardandodesenho(){
        $this->load->model('orcamentos_model');
        if(!empty($this->uri->segment(3))){
            $where = "";
            $primeiro = true;

            if(!empty($this->input->post('idOrcamento'))){
                if($primeiro){
                    $where = " WHERE orcamento.idOrcamentos = ".$this->input->post('idOrcamento');
                    $primeiro = false;
                }else{
                    $where = " and orcamento.idOrcamentos = ".$this->input->post('idOrcamento');
                }
            }
            if(!empty($this->input->post('idOrcamentoItem'))){
                if($primeiro){
                    $where = " WHERE orcamento_item.idOrcamento_item = ".$this->input->post('idOrcamentoItem');
                    $primeiro = false;
                }else{
                    $where = " and orcamento_item.idOrcamento_item = ".$this->input->post('idOrcamentoItem');
                }
            }
            if(!empty($this->input->post('idOs'))){
                if($primeiro){
                    $where = " WHERE os.idOs = ".$this->input->post('idOs');
                    $primeiro = false;
                }else{
                    $where = " and os.idOs = ".$this->input->post('idOs');
                }
            }
            if(!empty($this->input->post('descricaoOrc'))){
                if($primeiro){
                    $where = " WHERE orcamento_item.descricao_item like '%".$this->input->post('descricaoOrc')."%'";
                    $primeiro = false;
                }else{
                    $where = " and orcamento_item.descricao_item like '%".$this->input->post('descricaoOrc')."%'";
                }
            }
            if(!empty($this->input->post('statusDesenho'))){
                if($primeiro){
                    $where = " WHERE orcamento_item.statusDesenho = ".$this->input->post('statusDesenho');
                    $primeiro = false;
                }else{
                    $where = " and orcamento_item.statusDesenho = ".$this->input->post('statusDesenho');
                }
            }
            if(!empty($this->input->post('pn'))){
                if($primeiro){
                    $where = " WHERE produtos.pn like '%".$this->input->post('pn')."%'";
                    $primeiro = false;
                }else{
                    $where = " and produtos.pn like '%".$this->input->post('pn')."%'";
                }
            }
            if(!empty($where)){
                $this->data['result'] = $this->orcamentos_model->getOrçAguardandoDesenho2($where.' and orcamento.idstatusOrcamento != 12');
            }else{
                $where = " where (orcamento_item.statusDesenho = 1 or orcamento_item.statusDesenho = 2) and orcamento.idstatusOrcamento != 12";
                $this->data['result'] = $this->orcamentos_model->getOrçAguardandoDesenho2($where);
            }
            
        }else{
            $where = " where (orcamento_item.statusDesenho = 1 or orcamento_item.statusDesenho = 2) and orcamento.idstatusOrcamento != 12";
            $this->data['result'] = $this->orcamentos_model->getOrçAguardandoDesenho2($where);
        }
        $this->data['view'] = 'desenho/aguardandodesenho';
       	$this->load->view('tema/topo',$this->data);

    }/*
    function visualizardesenhos(){
        $this->load->model('orcamentos_model');
        $this->data['orcam'] = $this->orcamentos_model->getOrcItemDetailsById2($this->uri->segment(3));
        $this->data['result'] = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao( $this->uri->segment(3));
        $this->data['view'] = 'desenho/visualizardesenhos';
       	$this->load->view('tema/topo',$this->data);
    }*/
    function visualizardesenhos(){
        $this->load->model('orcamentos_model');
        $this->load->model('peritagem_model');
        $this->load->model('os_model');
        $this->data['orcam'] = $this->orcamentos_model->getOrcamento($this->uri->segment(3));
        $this->data['result'] = $this->orcamentos_model->getorc_item2( $this->uri->segment(3));
        $this->data['view'] = 'desenho/visualizardesenhos';
       	$this->load->view('tema/topo',$this->data);
    }/*
    function aprovardesenho(){
        $idAnexo = $this->input->post('idAnexo2');
        $data = array(
            "statusAnexo"=>2
        );
        $this->desenho_model->edit("anexo_desenho",$data,"idAnexo",$idAnexo);
        $this->session->set_flashdata('success', 'Desenho aprovado com sucesso!');
        redirect('desenho/aguardandoDesenho');
    }
    function reprovardesenho(){
        $idAnexo = $this->input->post('idAnexo3');
        $data = array(
            "statusAnexo"=>3
        );
        $this->desenho_model->edit("anexo_desenho",$data,"idAnexo",$idAnexo);
        $this->session->set_flashdata('success', 'Desenho reprovado com sucesso!');
        redirect('desenho/aguardandoDesenho');
    }*/
    public function cad_desenho()
    {
        $this->load->model('orcamentos_model');

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
            //$idOs = $this->input->post('idOs');
            $idOrc = $this->input->post('idOrcItem');



            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'imagem' => $imagem,
                'caminho' => $caminho,
                'tipo' => 'DESENHO',
                'tamanho' => $tamanho,
                'extensao' => $extensao,
                'statusAnexo' => 2,
                'data_cadastro' => date('Y-m-d H:i:s'),
                'user_proprietario' => $this->session->userdata('idUsuarios'),
                'idOrcamentos_item' => $idOrc
            );
            
            if ($this->orcamentos_model->add('anexo_desenho', $data) == TRUE) {
                $this->session->set_flashdata('success', 'Arquivo adicionado com sucesso!');
                redirect(base_url() . 'index.php/desenho/visualizardesenhos/' . $idOrc);
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
        }
    }
    function finalizar(){
        $idOrcItem = $this->input->post("idOrcItem2");
        $data = array(
            "statusDesenho"=>3
        );
        $this->desenho_model->edit('os',$data,'idOrcamento_item',$idOrcItem);
        $this->desenho_model->edit('orcamento_item',$data,'idOrcamento_item',$idOrcItem);
        $this->session->set_flashdata('success', 'Finalizado com sucesso!');
        redirect(base_url().'index.php/desenho/visualizardesenhos/'.$idOrcItem);
    }
    function cadastrarDesenhoNoItem (){
        $this->load->model('peritagem_model');
        $this->load->model('orcamentos_model');
        if(!empty($_FILES['file']["name"])){
            $target_dir = "./assets/uploads/desenho/";
            $imageFileType = strtolower(pathinfo(basename($_FILES['file']["name"]),PATHINFO_EXTENSION));
            $_FILES['file']["name"] = $this->input->post('nomeArquivo')."_".$this->generateRandomString().".".$imageFileType;
            $target_file = $target_dir . basename($_FILES['file']["name"]);
            if (file_exists($target_file)) {
                $_FILES['file']["name"] = $this->input->post('nomeArquivo')."_".$this->generateRandomString().".".$imageFileType;
                $target_file = $target_dir . basename($_FILES[['file']]["name"]);             
            }
            if(!empty($this->input->post('idOrcSerItem'))){
                $idOrcSerItem = $this->input->post('idOrcSerItem');
            }else{
                $idOrcSerItem = NULL;
            }
            if(!empty($idOrcSerItem)){
                $objOrcServItem = $this->orcamentos_model->getEscopoItem($idOrcSerItem);
            }else{
                $objOrcServItem = null;
            }
            
            if(!empty($objOrcServItem->idProduto)){
                $idProduto = $objOrcServItem->idProduto;
            }else{
                $idProduto = null;
            }
            if (move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
                $data = array(
                    'nomeArquivo' => $this->input->post('nomeArquivo'),
                    'imagem' =>  $_FILES['file']["name"],
                    'caminho' => 'assets/uploads/desenho/',
                    'tipo' => 'DESENHO',
                    'tamanho' => filesize($target_dir.$_FILES['file']["name"]),
                    'extensao' => $imageFileType,
                    'statusAnexo' => 2,
                    'idProduto'=>$idProduto,
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'user_proprietario' => $this->session->userdata('idUsuarios'),
                    'idOrcamentos_item' => $this->input->post('idOrcItem'),
                    'idOrcServicoEscopoItens' => $idOrcSerItem
                );
                $this->peritagem_model->add('anexo_desenho',$data);
            }
        }
        $getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao( $this->input->post('idOrcItem'));
        if($idOrcSerItem){
            $getAnexoOrcServItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao2($idOrcSerItem, $this->input->post('idOrcItem'));
        }else{
            $getAnexoOrcServItem = array();
        }
        
        echo json_encode(array("result"=>true,"anexoGeral"=>$getAnexoOrcItem,"anexoItem"=>$getAnexoOrcServItem));
    }
    function cadastrarDesenhoNoItem2 (){
        $this->load->model('peritagem_model');
        $this->load->model('orcamentos_model');
        if(!empty($_FILES['file']["name"])){
            $target_dir = "./assets/uploads/desenho/";
            $imageFileType = strtolower(pathinfo(basename($_FILES['file']["name"]),PATHINFO_EXTENSION));
            $_FILES['file']["name"] = $this->input->post('nomeArquivo')."_".$this->generateRandomString().".".$imageFileType;
            $target_file = $target_dir . basename($_FILES['file']["name"]);
            if (file_exists($target_file)) {
                $_FILES['file']["name"] = $this->input->post('nomeArquivo')."_".$this->generateRandomString().".".$imageFileType;
                $target_file = $target_dir . basename($_FILES[['file']]["name"]);             
            }
            if(!empty($this->input->post('idOrcSerItem'))){
                $idOrcSerItem = $this->input->post('idOrcSerItem');
            }else{
                $idOrcSerItem = NULL;
            }
            if(!empty($idOrcSerItem)){
                $objOrcServItem = $this->orcamentos_model->getEscopoItem($idOrcSerItem);
            }else{
                $objOrcServItem = null;
            }
            
            if(!empty($objOrcServItem->idProduto)){
                $idProduto = $objOrcServItem->idProduto;
            }else{
                $idProduto = null;
            }
            if(move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
                $data = array(
                    'nomeArquivo' => $this->input->post('nomeArquivo'),
                    'imagem' =>  $_FILES['file']["name"],
                    'caminho' => 'assets/uploads/desenho/',
                    'tipo' => 'DESENHO',
                    'tamanho' => filesize($target_dir.$_FILES['file']["name"]),
                    'extensao' => $imageFileType,
                    'statusAnexo' => 1,
                    'idProduto' => $idProduto,
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'user_proprietario' => $this->session->userdata('idUsuarios'),
                    'idOrcamentos_item' => $this->input->post('idOrcItem'),
                    'idOrcServicoEscopoItens' => $idOrcSerItem
                );
                $this->peritagem_model->add('anexo_desenho',$data);
            }
        }
        $getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao( $this->input->post('idOrcItem'));
        if($idOrcSerItem){
            $getAnexoOrcServItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao2($idOrcSerItem, $this->input->post('idOrcItem'));
        }else{
            $getAnexoOrcServItem = array();
        }
        
        echo json_encode(array("result"=>true,"anexoGeral"=>$getAnexoOrcItem,"anexoItem"=>$getAnexoOrcServItem));
    }
    function cadastrarDesenhoNaSubOs (){
        $this->load->model('peritagem_model');
        $this->load->model('orcamentos_model');
        if(!empty($_FILES['file']["name"])){
            $target_dir = "./assets/uploads/desenho/";
            $imageFileType = strtolower(pathinfo(basename($_FILES['file']["name"]),PATHINFO_EXTENSION));
            $_FILES['file']["name"] = $this->input->post('nomeArquivoOs')."_".$this->generateRandomString().".".$imageFileType;
            $target_file = $target_dir . basename($_FILES['file']["name"]);
            if (file_exists($target_file)) {
                $_FILES['file']["name"] = $this->input->post('nomeArquivoOs')."_".$this->generateRandomString().".".$imageFileType;
                $target_file = $target_dir . basename($_FILES[['file']]["name"]);             
            }
            if(!empty($this->input->post('idOsSub'))){
                $idOsSub = $this->input->post('idOsSub');
            }else{
                $idOsSub = NULL;
            }
            
            if(!empty($idOsSub)){
                $objOsSub = $this->orcamentos_model->getSubOsbyIdOsSub($idOsSub);
            }else{
                $objOsSub = null;
            }

            if(!empty($objOsSub->idProduto_sub)){
                $idProduto = $objOsSub->idProduto_sub;
            }else{
                $idProduto = null;
            }
            if (move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
                $data = array(
                    'nomeArquivo' => $this->input->post('nomeArquivo'),
                    'imagem' =>  $_FILES['file']["name"],
                    'caminho' => 'assets/uploads/desenho/',
                    'tipo' => 'DESENHO',
                    'tamanho' => filesize($target_dir.$_FILES['file']["name"]),
                    'extensao' => $imageFileType,
                    'statusAnexo' => 2,
                    'idProduto' => $idProduto,
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'user_proprietario' => $this->session->userdata('idUsuarios'),
                    'idOs' => $this->input->post('idOs'),
                    'idOsSub' => $idOsSub
                );
                $this->peritagem_model->add('anexo_desenho',$data);
            }
        }
        $getAnexoIdOs = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao4($this->input->post('idOs'));
        if($idOsSub){
            $getAnexoOrcServItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao3($idOsSub, $this->input->post('idOs'));
        }else{
            $getAnexoOrcServItem = array();
        }
        
        echo json_encode(array("result"=>true,"anexoGeral"=>$getAnexoIdOs,"anexoItem"=>$getAnexoOrcServItem));
    }
    
    function cadastrarDesenhoNoOrcECat(){
        $this->load->model('peritagem_model');
        $this->load->model('orcamentos_model');
        if(!empty($_FILES['file']["name"])){
            $target_dir = "./assets/uploads/desenho/";
            $imageFileType = strtolower(pathinfo(basename($_FILES['file']["name"]),PATHINFO_EXTENSION));
            $_FILES['file']["name"] = $this->input->post('nomeArquivoOs')."_".$this->generateRandomString().".".$imageFileType;
            $target_file = $target_dir . basename($_FILES['file']["name"]);
            if (file_exists($target_file)) {
                $_FILES['file']["name"] = $this->input->post('nomeArquivoOs')."_".$this->generateRandomString().".".$imageFileType;
                $target_file = $target_dir . basename($_FILES[['file']]["name"]);             
            }
            $objCatItem = $this->peritagem_model->getCatalogoItem($this->input->post('idCatItem'));
            if(!empty($objCatItem)){
                $idProduto = $objCatItem->idProduto;
            }else{
                $idProduto = null;
            }
            if (move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
                $data = array(
                    'nomeArquivo' => $this->input->post('nomeArquivo'),
                    'imagem' =>  $_FILES['file']["name"],
                    'caminho' => 'assets/uploads/desenho/',
                    'tipo' => 'DESENHO',
                    'tamanho' => filesize($target_dir.$_FILES['file']["name"]),
                    'extensao' => $imageFileType,
                    'statusAnexo' => 1,
                    'idProduto' => $idProduto,
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'user_proprietario' => $this->session->userdata('idUsuarios'),
                    'idOrcamentos_item' => $this->input->post('idOrcItem'),
                    'idCatItem' => $this->input->post('idCatItem')
                );
                $this->peritagem_model->add('anexo_desenho',$data);
            }
        }
        $getAnexoIdOs = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao($this->input->post('idOrcItem'));
        if($this->input->post('idCatItem')){
            $getAnexoOrcServItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao5( $this->input->post('idOrcItem'),$this->input->post('idCatItem'));
        }else{
            $getAnexoOrcServItem = array();
        }
        
        echo json_encode(array("result"=>true,"anexoGeral"=>$getAnexoIdOs,"anexoItem"=>$getAnexoOrcServItem));
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
    function aprovarDesenho(){
        $this->load->model('peritagem_model');
        $this->load->model('orcamentos_model');
        $idAnexo = $this->input->post('idAnexo');
        $data = array(
            "statusAnexo"=>2
        );
        $this->desenho_model->edit("anexo_desenho",$data,"idAnexo",$idAnexo);
        $anexo = $this->orcamentos_model->getAnexoDesenhoByIdAnexo($idAnexo);
        if(empty($anexo->idOsSub)){
            $getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao( $anexo->idOrcamentos_item);
            if($anexo->idOrcServicoEscopoItens){
                $getAnexoOrcServItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao2($anexo->idOrcServicoEscopoItens,  $anexo->idOrcamentos_item);
            }else{
                $getAnexoOrcServItem = array();
            }
        }else{
            $getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao4( $anexo->idOs);
            if($anexo->idOsSub){
                $getAnexoOrcServItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao3($anexo->idOsSub, $anexo->idOs);
            }else{
                $getAnexoOrcServItem = array();
            }
        }
        
        echo json_encode(array("result"=>true,"anexoGeral"=>$getAnexoOrcItem,"anexoItem"=>$getAnexoOrcServItem));
    }
    function reprovarDesenho(){
        $this->load->model('peritagem_model');
        $this->load->model('orcamentos_model');
        $idAnexo = $this->input->post('idAnexo');
        $data = array(
            "statusAnexo"=>3
        );
        $this->desenho_model->edit("anexo_desenho",$data,"idAnexo",$idAnexo);
        $anexo = $this->orcamentos_model->getAnexoDesenhoByIdAnexo($idAnexo);
        if(empty($anexo->idOsSub)){
            $getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao( $anexo->idOrcamentos_item);
            if($anexo->idOrcServicoEscopoItens){
                $getAnexoOrcServItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao2($anexo->idOrcServicoEscopoItens, $anexo->idOrcamentos_item);
            }else{
                $getAnexoOrcServItem = array();
            }
        }else{
            $getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao4( $anexo->idOs);
            if($anexo->idOsSub){
                $getAnexoOrcServItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao3($anexo->idOsSub, $anexo->idOs);
            }else{
                $getAnexoOrcServItem = array();
            }
        }
        echo json_encode(array("result"=>true,"anexoGeral"=>$getAnexoOrcItem,"anexoItem"=>$getAnexoOrcServItem));
    }

    function finalizardesenho(){
        $this->load->model('peritagem_model');
        $this->load->model('orcamentos_model');
        $this->load->model('os_model');
        $idOrcItem = $this->input->post('idOrcItem');
        $idOs = $this->input->post('idOs');
        $data = array("idStatusEscopo"=>2);
        //$data2 = array("statusDesenho"=>3,"data_finalizado_desenho"=>date('Y-m-d H:i:s'));
        $data2 = array("statusDesenho"=>3);
        $data3 = array("statusDesenho"=>3,"data_finalizado_desenho"=>date('Y-m-d H:i:s'));
        $verifyOs = false;
        $verifyOrcitem = false;

        if(!empty($idOs)){
            foreach($idOs as $r){
                $anexoDesenhoOS = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao4($r);    
                $objOrcItem =  $this->os_model->getOrcamentoItemByIdOs($r);    
                $this->peritagem_model->edit("os",$data2,"idOs", $r);
                $this->peritagem_model->edit("orcamento_item",$data3,"idOrcamento_item", $objOrcItem->idOrcamento_item); /* 
                if($objOrcItem->tipoOrc == "serv"){
                    $dataOs = array("idStatusOs"=>202);
                    $this->peritagem_model->edit("os",$dataOs,"idOs", $r);
                }
                if($objOrcItem->tipoOrc == "fab"){
                    $dataOs = array("idStatusOs"=>205);
                    $this->peritagem_model->edit("os",$dataOs,"idOs", $r);
                }
                
                $os = $this->os_model->getByid_table($r, 'os', 'idOs');
                $this->os_model->insertOSHis($os);  */       
                if($objOrcItem->tipoOrc == 'serv'){
                    $orcamento = $this->orcamentos_model->getOrcamentoByidOrcItem2($objOrcItem->idOrcamento_item);
                    $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem2($objOrcItem->idOrcamento_item);
                    if (!empty($escopo)) {
                        $this->peritagem_model->edit("orc_servico_escopo",$data,"idOrcServicoEscopo", $escopo->idOrcServicoEscopo);
                    }
                    if($escopo->tipoServico == "cil"){
                        $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemCil";s:1:"1";');
                    }
                    if($escopo->tipoServico == "maq"){
                        $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemMaq";s:1:"1";');
                    }
                    if($escopo->tipoServico == "sub"){
                        $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemSub";s:1:"1";');
                    }
                    if($escopo->tipoServico == "pec"){
                        $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemPec";s:1:"1";');
                    }
                    $email = "";
                    $primeiro = true;
                    foreach($peritagem as $r){
                        if(!empty($r->email ) && $r->email != "."){
                            if($primeiro){
                                $email = $email.$r->email;
                                $primeiro = false;
                            }else{
                                $email = $email.",".$r->email;
                            }
                        }
                    }
                    try{
                        echo '<script>console.log("'.$email.'")</script>';
                        $this->send($email,"Orçamento: ".$orcamento->idOrcamentos." - SOLICITAÇÃO DE PERITAGEM","PN: ".$orcamento->pn." - ".$orcamento->descricao_item);
                    }catch(Exception $e){}
                }
            }
            $verifyOs = true;
        }
        if(!empty($idOrcItem)){
            $verifyOrcitem = true;
            $orcamento = $this->orcamentos_model->getOrcamentoByidOrcItem2($idOrcItem[0]);
            foreach($idOrcItem as $r){
                $objOrcItem = $this->orcamentos_model->get_item_orc($r);    
                $this->peritagem_model->edit("os",$data2,"idOrcamento_item", $r);
                $this->peritagem_model->edit("orcamento_item",$data3,"idOrcamento_item", $r);/*
                if($objOrcItem->tipoOrc == "serv"){
                    $dataOs = array("idStatusOs"=>202);
                    $this->peritagem_model->edit("os",$dataOs,"idOrcamento_item", $r);
                }
                if($objOrcItem->tipoOrc == "fab"){
                    $dataOs = array("idStatusOs"=>5);
                    $this->peritagem_model->edit("os",$dataOs,"idOrcamento_item", $r);
                }*/
                $os = $this->orcamentos_model->getos_item2($r);
                foreach($os as $d){
                    $this->os_model->insertOSHis($d);
                }
                 
                $getAnexoOrcItem = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao($r);          
                $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem2($r);
                if (!empty($escopo)) {
                    $this->peritagem_model->edit("orc_servico_escopo",$data,"idOrcServicoEscopo", $escopo->idOrcServicoEscopo);
                }     
                if(!empty($escopo)){                    
                    
                    if($escopo->tipoServico == "cil"){
                        $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemCil";s:1:"1";');
                    }
                    if($escopo->tipoServico == "maq"){
                        $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemMaq";s:1:"1";');
                    }
                    if($escopo->tipoServico == "sub"){
                        $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemSub";s:1:"1";');
                    }
                    if($escopo->tipoServico == "pec"){
                        $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemPec";s:1:"1";');
                    }
                    $email = "";
                    $primeiro = true;
                    foreach($peritagem as $r){
                        if(!empty($r->email ) && $r->email !="."){
                            if($primeiro){
                                $email = $email.$r->email;
                                $primeiro = false;
                            }else{
                                $email = $email.",".$r->email;
                            }
                        }
                    } 
                    //echo json_encode($email);
                    //exit;
                    try{
                        echo '<script>console.log("'.$email.'")</script>';
                        $this->send($email,"Orçamento: ".$orcamento->idOrcamentos." - SOLICITAÇÃO DE PERITAGEM","PN: ".$orcamento->pn." - ".$orcamento->descricao_item);
                    }catch(Exception $e){}
                }
            }
        }

        
        if($verifyOrcitem || $verifyOs){
            $this->session->set_flashdata('success', 'Email enviado para o setor de peritagem!');
        }else{
            $this->session->set_flashdata('error', 'Esse item não possuí desenhos anexados.');
        }
        
        redirect(base_url().'index.php/desenho/visualizardesenhos/'.$this->input->post('idOrcamento2'));   
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

    function criar_pn(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vDesenho')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar Versionamento de Desenhos.');
            redirect(base_url());
        }

        $this->load->library('pagination');
        $this->load->model('os_model');

        $filter = $this->input->post('filter');
        $field  = $this->input->post('field');
        $search = $this->input->post('search');

        $config['base_url'] = base_url().'index.php/desenho/criar_pn/';

        $this->data['results'] = $this->desenho_model->getPnInicioPaiB();
        $this->data['versaoPrincipal'] = $this->desenho_model->getPnFilhoPrincipal();
        $this->data['versaoClientes'] = $this->desenho_model->getPnNetoEmpresa();
        //$this->data['versionamento'] = $this->desenho_model->getPnInicioFilho();

        $this->data['view'] = 'desenho/criar_pn';
       	$this->load->view('tema/topo',$this->data);

    }

    function page_addPn(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aDesenho')){
            $this->session->set_flashdata('error','Você não tem permissão para criar um PN.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->data['view'] = 'desenho/adicionar_pn';
        $this->load->view('tema/topo', $this->data);

    }

    function page_add_versao_Pn(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aDesenho')){
            $this->session->set_flashdata('error','Você não tem permissão para criar uma versão de PN.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $idProduto = $this->input->get('id');
        $idPn = $this->input->get('idPn');

        if(null !== $this->input->get('idPn')){
            $verifica = $this->desenho_model->getPnProduto_desenho("idPn", $idPn);
        }else{
            $verifica = $this->desenho_model->getPnProduto_desenho("idProdutos", $idProduto);
        }


        if(empty($verifica)){

            $resultado = $this->desenho_model->getPnProdutos("idProdutos", $idProduto);

        }else{

            if(null !== $verifica[0]->idClientes){
                $campo = "idClientes";
                $empresa = $verifica[0]->idClientes;
            }else{
                $campo = "empresa";
                $empresa = "";
            }

            $versao_empresa = (isset($verifica[0]->versaoEmpresa) ? $verifica[0]->versaoEmpresa : "");
            $resultado = $this->desenho_model->getPn_vers_edit("idProdutos", $idProduto, $campo, $empresa, $versao_empresa, $idPn);

        }

        $this->data['resultado'] = $resultado;
        $this->data['view'] = 'desenho/adicionar_versao_pn';
        $this->load->view('tema/topo', $this->data);

    }

    function page_editar_pn(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eDesenho')){
            $this->session->set_flashdata('error','Você não tem permissão para editar um PN.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $idProduto = $this->input->get('id');
        $idPn = $this->input->get('idPn');

        if(null !== $idPn){
            $verifica = $this->desenho_model->getPnProduto_desenho("idPn", $idPn);
        }else{
            $verifica = $this->desenho_model->getPnProduto_desenho("idProdutos", $idProduto);
        }

        

        if(empty($verifica)){

            $resultado = $this->desenho_model->getPnProdutos("idProdutos", $idProduto);

        }else{

            if(null !== $verifica[0]->idClientes){
                $campo = "idClientes";
                $empresa = $verifica[0]->idClientes;
            }else{
                $campo = "empresa";
                $empresa = "";
            }

            $versao_empresa = (isset($verifica[0]->versaoEmpresa) ? $verifica[0]->versaoEmpresa : "");
            $resultado = $this->desenho_model->getPn_vers_edit("idProdutos", $idProduto, $campo, $empresa, $versao_empresa, $idPn);

        }


        $this->data['corte_desenho'] = $this->desenho_model->getDesenhoCorte($idPn);
        $this->data['resultado'] = $resultado;
        $this->data['view'] = 'desenho/editar_pn';
        $this->load->view('tema/topo', $this->data);

    }

    function page_add_pn_existente(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eDesenho')){
            $this->session->set_flashdata('error','Você não tem permissão para adicionar um desenho.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $idProduto = $this->input->get('id');
        $idPn = $this->input->get('idPn');

        if(null !== $this->input->get('idPn')){
            $verifica = $this->desenho_model->getPnProduto_desenho("idPn", $idPn);
        }else{
            $verifica = $this->desenho_model->getPnProduto_desenho("idProdutos", $idProduto);
        }


        if(empty($verifica)){

            $resultado = $this->desenho_model->getPnProdutos("idProdutos", $idProduto);

        }else{

            if(null !== $verifica[0]->idClientes){
                $campo = "idClientes";
                $empresa = $verifica[0]->idClientes;
            }else{
                $campo = "empresa";
                $empresa = "";
            }

            $versao_empresa = (isset($verifica[0]->versaoEmpresa) ? $verifica[0]->versaoEmpresa : "");
            $resultado = $this->desenho_model->getPn_vers_edit("idProdutos", $idProduto, $campo, $empresa, $versao_empresa, $idPn);

        }

        $this->data['resultado'] = $resultado;
        $this->data['view'] = 'desenho/adicionar_pn_existente';
        $this->load->view('tema/topo', $this->data);

    }

    function adicionar_pn(){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->load->model('produtos_model');

        // TRATATIVOS PARA CASO DE ENVIO DE DESENHO DE CORTE
        $desenhos_corte = $this->input->post('desenhos_corte');
        if($this->input->post('desenhos_corte') !== ""){

            $corte_dados = explode("||,", $desenhos_corte);
            $corte_dados_tratatos = array();
            $dadosXCorte = "";

            foreach ($corte_dados as $k => $dado_corte) {

                if($dado_corte !== ""){

                    $dadosXCorte = explode(",", $dado_corte);
                    array_push($corte_dados_tratatos, $dadosXCorte);

                    // TRATATIVA CONTINUA NA PARTE PERTO DA INCERSÃO DE DADOS NA TABELA PRODUTO HISTORY

                }

            }

        }


        if ($this->form_validation->run('produtos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            if(!empty($_FILES['imag_dwg']["name"]) && empty($_FILES['imag_jpg']["name"])){
                
                $this->session->set_flashdata('error', 'Não foi encontrado arquivo JPG. Se o desenho for anexado neste formulário, deve conter arquivos DWG e JPG.');
                redirect(base_url() . 'desenho/page_addPn');
                
            }elseif(empty($_FILES['imag_dwg']["name"]) && !empty($_FILES['imag_jpg']["name"])){
                
                $this->session->set_flashdata('error', 'Não foi encontrado arquivo DWG. Se o desenho for anexado neste formulário, deve conter arquivos DWG e JPG.');
                redirect(base_url() . 'desenho/page_addPn');

            }else{

                $excluir = array(" ", "*", "-", ".", ",", "=", "+", "'('", "')'");
                $resultado_pn = str_replace($excluir, "", $this->input->post('pn'));

                // DADOS PARA TABELA PRODUTOS
                $data = array(

                    'descricao' => strtoupper(set_value('descricao')),
                    'pn' => strtoupper($resultado_pn),
                    'referencia' => strtoupper($this->input->post('referencia')),
                    'fornecedor_original' => strtoupper($this->input->post('fornecedor_original')),
                    'equipamento' => strtoupper($this->input->post('equipamento')),
                    'subconjunto' => strtoupper($this->input->post('subconjunto')),
                    'modelo' => strtoupper($this->input->post('modelo'))
                    
                );

                if( $this->produtos_model->getByPn( $resultado_pn) == true){

                    $this->session->set_flashdata('error','PN ja possui cadastro.');
                    echo json_encode(array("result"=>false));
                    return;
                    //redirect(base_url(). 'desenho/page_addPn'); 

                }
                if (is_numeric($id = $this->produtos_model->add('produtos', $data, true)) ) {

                    $pn_adicionado = $this->produtos_model->getByPn($resultado_pn);

                    // DADOS PARA TABELA PRODUTO_DESENHO
                    $data_produtos_desenho = array(

                        "idProdutos" => $pn_adicionado->idProdutos,
                        "descricao" => $pn_adicionado->descricao,
                        "master" => 1,
                        "versao" => 0,
                        "idDesenhos" => 0,
                        "data_master" => date("Y-m-d H:i:s"),
                        "user_alteracao" => 0,
                        "user_criacao" => $this->session->userdata('idUsuarios'),
                        "observacao" => strtoupper($this->input->post('observ')),
                        "empresa" => '',
                        "versaoEmpresa" => '',
                        "idClientes" => null

                    );

                    //ADICIONANDO NA TABELA PRODUTO_DESENHO
                    if (is_numeric($idPn = $this->desenho_model->add('produto_desenho', $data_produtos_desenho, true)) ) {
                        

                        // ADICIONANDO NA TABELA DESENHO
                        if(!empty($_FILES['imag_dwg']["name"])){
                        
                            $target_dir = "./assets/uploads/desenhos_master/";

                            // EXTENSAO DO ARQUIVO (dwg/jpg)
                            $imageFileTypeDwg = strtolower(pathinfo(basename($_FILES['imag_dwg']["name"]),PATHINFO_EXTENSION));
                            $imageFileTypeJpg = strtolower(pathinfo(basename($_FILES['imag_jpg']["name"]),PATHINFO_EXTENSION));

                            // NOME DO ARQUIVO COM LETRAS ALEATORIAS
                            $number_random = $this->generateRandomString();
                            $_FILES['imag_dwg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeDwg;
                            $_FILES['imag_jpg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeJpg;
                            
                            // CAMINHO COMPLETO DO ARQUIVO
                            $target_fileDwg = $target_dir . basename($_FILES['imag_dwg']["name"]);
                            $target_fileJpg = $target_dir . basename($_FILES['imag_jpg']["name"]);
                            
                            // PARA CASO EXISTA O ARQUIVO NA PASTA
                            if (file_exists($target_fileDwg) || file_exists($target_fileJpg)) {

                                $number_random = $this->generateRandomString();

                                $_FILES['imag_dwg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeDwg;
                                $target_fileDwg = $target_dir . basename($_FILES[['imag_dwg']]["name"]);           
                            
                                $_FILES['imag_jpg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeJpg;
                                $target_fileJpg = $target_dir . basename($_FILES[['imag_jpg']]["name"]);

                            }
                            
                            // ENVIA ARQUIVOS DWG E JPG PARA PASTA DESENHOS MASTER
                            if (move_uploaded_file($_FILES['imag_dwg']["tmp_name"], $target_fileDwg)) {

                                move_uploaded_file($_FILES['imag_jpg']["tmp_name"], $target_fileJpg);

                                // DADOS PARA TABELA DESENHO
                                $data_desenhos = array(

                                    'data_ini'          => date("Y-m-d H:i:s"),
                                    'data_fim'          => date("Y-m-d H:i:s"),
                                    'idProdutos'        => $pn_adicionado->idProdutos,
                                    'idPn'              => $idPn,
                                    'nomeArquivoDwg'    => $resultado_pn,
                                    'caminhoDwg'        => 'assets/uploads/desenhos_master/',
                                    'imagemDwg'         => $_FILES['imag_dwg']["name"],
                                    'extensaoDwg'       => $imageFileTypeDwg,
                                    'tamanhoDwg'        => filesize($target_dir.$_FILES['imag_dwg']["name"]),
                                    'nomeArquivoJpg'    => $resultado_pn,
                                    'caminhoJpg'        => 'assets/uploads/desenhos_master/',
                                    'imagemJpg'         => $_FILES['imag_jpg']["name"],
                                    'extensaoJpg'       => $imageFileTypeJpg,
                                    'tamanhoJpg'        => filesize($target_dir.$_FILES['imag_jpg']["name"]),          
                                    'user_proprietario' => $this->session->userdata('idUsuarios'),
                                    'user_alteracao'    => 0,
                                    'data_alteracao'    => null,
                                    'versao'            => 0,
                                    'ativo'             => 1,
                                    'observacao'        => strtoupper($this->input->post('observ'))
                    
                                );
                                
                                $idDesenhos = $this->desenho_model->add('desenhos', $data_desenhos, true);

                                $data_edit_prodDes = array("idDesenhos"=>$idDesenhos);

                                $this->desenho_model->edit("produto_desenho",$data_edit_prodDes,"idPn",$idPn);

                            }

                        }


                        // SE TIVER DESENHO DE CORTE
                        $idCorte = "";
                        $idCorteAdd = "";

                        if($this->input->post('desenhos_corte') !== ""){

                            $nomeArquivoCorte = "";

                            for ($i=0; $i < 100; $i++) { 

                                $corte_chave = "corte".$i;
                                
                                if(isset($_FILES[$corte_chave]["name"])){

                                    foreach ($corte_dados_tratatos as $y => $dado_do_corte) {

                                        if($_FILES[$corte_chave]["name"] == $dado_do_corte[0]){

                                            // EXTENSAO DO ARQUIVO CORTE (dwg)
                                            $imageFileTypeCorte = strtolower(pathinfo(basename($_FILES[$corte_chave]["name"]),PATHINFO_EXTENSION));

                                            // NOME DO ARQUIVO COM LETRAS ALEATORIAS
                                            $_FILES[$corte_chave]["name"] = $resultado_pn."_".$corte_chave."_".$number_random.".".$imageFileTypeCorte;
                                            $nomeArquivoCorte = $resultado_pn."_".$corte_chave."_".$number_random;

                                            // CAMINHO COMPLETO DO ARQUIVO
                                            $target_fileCorte = $target_dir . basename($_FILES[$corte_chave]["name"]);

                                            // PARA CASO EXISTA O ARQUIVO NA PASTA
                                            if (file_exists($target_fileCorte)) {

                                                $number_random = $this->generateRandomString();

                                                $_FILES[$corte_chave]["name"] = $resultado_pn."_".$corte_chave."_".$number_random.".".$imageFileTypeCorte;
                                                $target_fileCorte = $target_dir . basename($_FILES[[$corte_chave]]["name"]);

                                            }

                                            // ENVIA ARQUIVOS DWG E JPG PARA PASTA DESENHOS MASTER
                                            if (move_uploaded_file($_FILES[$corte_chave]["tmp_name"], $target_fileCorte)) {

                                                // CADASTRAR NA TABELA
                                                $data_corte = array(

                                                    'idProdutos' => $pn_adicionado->idProdutos,
                                                    'idPn' => $idPn,
                                                    'descricao_corte' => $dado_do_corte[1],
                                                    'observacao_corte' => $dado_do_corte[2],
                                                    'nomeArquivo' =>$nomeArquivoCorte,
                                                    'caminho' => 'assets/uploads/desenhos_master/',
                                                    'imagem' => $_FILES[$corte_chave]["name"],
                                                    'extensao' =>$imageFileTypeCorte,
                                                    'tamanho' => filesize($target_dir.$_FILES[$corte_chave]["name"])

                                                );

                                                $idCorteAdd = $this->desenho_model->add('desenho_corte', $data_corte, true);

                                                if($idCorte == ""){

                                                    $idCorte = $idCorteAdd;

                                                }else{

                                                    $idCorte .= ", ". $idCorteAdd;

                                                }

                                            }

                                        }

                                    }
                    
                                }

                            }
                            
                        }

                        // DADOS LOG TABELA PRODUTO_HISTORY
                        $data_produto_history = array(

                            'idProdutos' => $pn_adicionado->idProdutos,
                            'idPn' => $idPn,
                            'idDesenhos' => $idDesenhos,
                            'idUserHis' => $this->session->userdata('idUsuarios'),
                            'data_alteracaoHis' =>  date("Y-m-d H:i:s"),
                            'status' => 'CRIOU NOVO PN',
                            'url' => 'desenho/adicionar_pn',
                            'descricao' => strtoupper(set_value('descricao')),
                            'pn' => strtoupper($resultado_pn),
                            'referencia' => strtoupper($this->input->post('referencia')),
                            'fornecedor_original' => strtoupper($this->input->post('fornecedor_original')),
                            'equipamento' => strtoupper($this->input->post('equipamento')),
                            'subconjunto' => strtoupper($this->input->post('subconjunto')),
                            'modelo' => strtoupper($this->input->post('modelo')),
                            'versao' => 0,
                            'empresa' => '',
                            'idClientes' => null,
                            'versaoEmpresa' => null,
                            'imagemDwg' => $_FILES['imag_dwg']["name"],
                            'ativo' => 1,
                            'master' => 1,
                            'observacao' => strtoupper($this->input->post('observ')),
                            'idCorte' => $idCorte
                            
                        );

                        if (is_numeric($idProdutosHis = $this->desenho_model->add('produto_history', $data_produto_history, true))){

                            $this->session->set_flashdata('success','Produto PN adicionado com sucesso!');
                            $this->session->set_flashdata('idProdutos',$pn_adicionado->idProdutos);
                            echo json_encode(array("result"=>true));
                            return;

                        }else{

                            echo json_encode(array("result"=>false));
                            return;

                        }

                        

                    }
                    
                } else {

                    $this->data['custom_error'] = '<div class="form_error"><p>Erro ao cadastrar.</p></div>';
                    echo json_encode(array("result"=>false));
                    return;

                }

            }
           
        }

        $this->data['view'] = 'desenho/adicionar_pn';
        $this->load->view('tema/topo', $this->data);

    }

    function adicionar_versao_pn(){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->load->model('produtos_model');
        
        if(!empty($_FILES['imag_dwg']["name"]) && empty($_FILES['imag_jpg']["name"])){
            
            $this->session->set_flashdata('error', 'Não foi encontrado arquivo JPG. Se o desenho for anexado neste formulário, deve conter arquivos DWG e JPG.');
            redirect(base_url() . 'desenho/page_add_versao_Pn');
            
        }elseif(empty($_FILES['imag_dwg']["name"]) && !empty($_FILES['imag_jpg']["name"])){
            
            $this->session->set_flashdata('error', 'Não foi encontrado arquivo DWG. Se o desenho for anexado neste formulário, deve conter arquivos DWG e JPG.');
            redirect(base_url() . 'desenho/page_add_versao_Pn');

        }else{

            $excluir = array(" ", "*", "-", ".", ",", "=", "+", "'('", "')'");
            $resultado_pn = str_replace($excluir, "", $this->input->post('pn'));

            $idPn_anterior = $this->input->post('idPn');
            $idDesenho_anterior = $this->input->post('idDesenhos');
            
            $pn_principal = $this->produtos_model->getByPn($resultado_pn);

            $prod_desenho_anterior = $this->desenho_model->getPnProduto_desenho("idPn", $idPn_anterior);

            $status = "";

            // SE NOVA VERSÃO PN PRINCIPAL
            if(empty($this->input->post('empresa'))){

                //EDITANDO COLUNA MASTER VERSÃO ANTERIOR TABELA PRODUTO DESENHO
                $data_prodDes = array("master"=>0);
                $this->desenho_model->edit("produto_desenho",$data_prodDes,"idPn",$idPn_anterior);

                //EDITANDO COLUNA ATIVO VERSÃO ANTERIOR TABELA DESENHOS
                $data_editDes = array("ativo"=>0);
                $this->desenho_model->edit("desenhos",$data_editDes,"idDesenhos",$idDesenho_anterior);

                $novaEmpresa = "";
                $master = 1;
                $idClientes = null;
                $status = "NOVA VERSÃO DO PN PRINCIPAL";

            }else{

                $master = 0;
                $novaEmpresa = $this->input->post('empresa');
                $idClientes  = $this->input->post('idClientes');
                $status = "NOVA VERSÃO DO PN PARA A EMPRESA(CLIENTE): {$novaEmpresa}";

            }
            
            // SE NOVA VERSÃO DE EMPRESA
            if(null !== $this->input->post('versaoEmpresa')){
                
                $novaVersaoEmp = $this->input->post('versaoEmpresa');
                
            }else{

                $novaVersaoEmp = "";

            }

            // DADOS PARA TABELA PRODUTO_DESENHO
            $data_produtos_desenho = array(

                "idProdutos" => $pn_principal->idProdutos,
                "descricao" => strtoupper($this->input->post('descricao')),
                "master" => $master,
                "versao" => $this->input->post('versao'),
                "idDesenhos" => 0,
                "data_master" => date("Y-m-d H:i:s"),
                "user_alteracao" => 0,
                "user_criacao" => $this->session->userdata('idUsuarios'),
                "observacao" => strtoupper($this->input->post('observ')),
                "empresa" => strtoupper($novaEmpresa),
                "versaoEmpresa" => strtoupper($novaVersaoEmp),
                "idClientes" => $idClientes

            );

            //ADICIONANDO NA TABELA PRODUTO_DESENHO
            if (is_numeric($idPn = $this->desenho_model->add('produto_desenho', $data_produtos_desenho, true)) ) {

                // ADICIONANDO NA TABELA DESENHO
                if(!empty($_FILES['imag_dwg']["name"])){
                
                    $target_dir = "./assets/uploads/desenhos_master/";

                    // EXTENSAO DO ARQUIVO (dwg/jpg)
                    $imageFileTypeDwg = strtolower(pathinfo(basename($_FILES['imag_dwg']["name"]),PATHINFO_EXTENSION));
                    $imageFileTypeJpg = strtolower(pathinfo(basename($_FILES['imag_jpg']["name"]),PATHINFO_EXTENSION));

                    // NOME DO ARQUIVO COM LETRAS ALEATORIAS
                    $number_random = $this->generateRandomString();
                    $_FILES['imag_dwg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeDwg;
                    $_FILES['imag_jpg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeJpg;
                    
                    // CAMINHO COMPLETO DO ARQUIVO
                    $target_fileDwg = $target_dir . basename($_FILES['imag_dwg']["name"]);
                    $target_fileJpg = $target_dir . basename($_FILES['imag_jpg']["name"]);
                    
                    // PARA CASO EXISTA O ARQUIVO NA PASTA
                    if (file_exists($target_fileDwg) || file_exists($target_fileJpg)) {

                        $number_random = $this->generateRandomString();

                        $_FILES['imag_dwg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeDwg;
                        $target_fileDwg = $target_dir . basename($_FILES[['imag_dwg']]["name"]);           
                    
                        $_FILES['imag_jpg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeJpg;
                        $target_fileJpg = $target_dir . basename($_FILES[['imag_jpg']]["name"]);

                    }
                    
                    // ENVIA ARQUIVOS DWG E JPG PARA PASTA DESENHOS MASTER
                    if (move_uploaded_file($_FILES['imag_dwg']["tmp_name"], $target_fileDwg)) {

                        move_uploaded_file($_FILES['imag_jpg']["tmp_name"], $target_fileJpg);

                        // DADOS PARA TABELA DESENHO
                        $data_desenhos = array(

                            'data_ini'          => date("Y-m-d H:i:s"),
                            'data_fim'          => date("Y-m-d H:i:s"),
                            'idProdutos'        => $pn_principal->idProdutos,
                            'idPn'              => $idPn,
                            'nomeArquivoDwg'    => $resultado_pn,
                            'caminhoDwg'        => 'assets/uploads/desenhos_master/',
                            'imagemDwg'         => $_FILES['imag_dwg']["name"],
                            'extensaoDwg'       => $imageFileTypeDwg,
                            'tamanhoDwg'        => filesize($target_dir.$_FILES['imag_dwg']["name"]),
                            'nomeArquivoJpg'    => $resultado_pn,
                            'caminhoJpg'        => 'assets/uploads/desenhos_master/',
                            'imagemJpg'         => $_FILES['imag_jpg']["name"],
                            'extensaoJpg'       => $imageFileTypeJpg,
                            'tamanhoJpg'        => filesize($target_dir.$_FILES['imag_jpg']["name"]),          
                            'user_proprietario' => $this->session->userdata('idUsuarios'),
                            'user_alteracao'    => 0,
                            'data_alteracao'    => null,
                            'versao'            => $this->input->post('versao'),
                            'ativo'             => 1,
                            'observacao'        => strtoupper($this->input->post('observ'))
            
                        );
                        
                        $idDesenhos = $this->desenho_model->add('desenhos', $data_desenhos, true);

                        $data_edit_prodDes = array("idDesenhos"=>$idDesenhos);

                        $this->desenho_model->edit("produto_desenho",$data_edit_prodDes,"idPn",$idPn);

                    }

                }

                // DADOS LOG TABELA PRODUTO_HISTORY
                $data_produto_history = array(

                    'idProdutos' => $pn_principal->idProdutos,
                    'idPn' => $idPn,
                    'idDesenhos' => $idDesenhos,
                    'idUserHis' => $this->session->userdata('idUsuarios'),
                    'data_alteracaoHis' =>  date("Y-m-d H:i:s"),
                    'status' => $status,
                    'url' => 'desenho/adicionar_versao_pn',
                    'descricao' => strtoupper($this->input->post('descricao')),
                    'pn' => strtoupper($resultado_pn),
                    'referencia' => strtoupper($pn_principal->referencia),
                    'fornecedor_original' => strtoupper($pn_principal->fornecedor_original),
                    'equipamento' => strtoupper($pn_principal->equipamento),
                    'subconjunto' => strtoupper($pn_principal->subconjunto),
                    'modelo' => strtoupper($pn_principal->modelo),
                    'versao' => $this->input->post('versao'),
                    'empresa' => strtoupper($novaEmpresa),
                    'idClientes' => $idClientes,
                    'versaoEmpresa' => strtoupper($novaVersaoEmp),
                    'imagemDwg' => $_FILES['imag_dwg']["name"],
                    'ativo' => 1,
                    'master' => $master,
                    'observacao' => strtoupper($this->input->post('observ'))
                    
                );

                if (is_numeric($idProdutosHis = $this->desenho_model->add('produto_history', $data_produto_history, true))){

                    $this->session->set_flashdata('success','Versão de Produto PN adicionado com sucesso!');
                    $this->session->set_flashdata('idProdutos',$pn_principal->idProdutos);
                    echo json_encode(array("result"=>true));
                    return;

                }else{

                    echo json_encode(array("result"=>false));
                    return;

                }

            }else {

                $this->data['custom_error'] = '<div class="form_error"><p>Erro ao cadastrar.</p></div>';
                echo json_encode(array("result"=>false));
                return;

            }

        }
           
        
        $this->data['view'] = 'desenho/adicionar_versao_pn';
        $this->load->view('tema/topo', $this->data);

    }

    function verificaEmpresa(){

        $idProdutos = $this->input->post('idProdutos');
        $idClientes = $this->input->post('idClientes');

        $resultado = $this->desenho_model->verificaEmpresa($idClientes, $idProdutos);

        echo json_encode(array("result"=>true, "resultado"=> $resultado));
        return;

    }

    function editar_pn(){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->load->model('produtos_model');

        if ($this->form_validation->run('produtos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $novo_desenho = 0;

            $desenhos_corte = $this->input->post('desenhos_corte');

            if(!empty($_FILES['imag_dwg']["name"])){
                // SE DESENHO FOR ALTERADO
                $novo_desenho = 1;
                $desenho_DWG = $_FILES['imag_dwg']["name"];
                $desenho_DWG = str_replace(".dwg", "", $desenho_DWG);
            }else{
                // SE DESENHO NÃO FOR ALTERADO
                $desenho_DWG = $this->input->post('desenhoDWG');
                $desenho_DWG = str_replace(".dwg", "", $desenho_DWG);
            }

            $excluir = array(" ", "*", "-", ".", ",", "=", "+", "'('", "')'");
            $resultado_pn = str_replace($excluir, "", $this->input->post('pn'));

            $idProdutos = $this->input->post('idProdutos');
            $idPn = $this->input->post('idPn');
            $idDesenhos = $this->input->post('idDesenhos');
            $idClientes = ($this->input->post('idClientes') == "null" ? null : $this->input->post('idClientes'));

            $result_pn_antigo = $this->desenho_model->verifica_pn_edit($idPn);

            // DADOS PN ANTES DE EDIÇÃO
            $dados_antigos = array(

                'descricao' => $result_pn_antigo->descricao,
                'pn' => $result_pn_antigo->pn,
                'referencia' => $result_pn_antigo->referencia,
                'fornecedor_original' => $result_pn_antigo->fornecedor_original,
                'equipamento' => $result_pn_antigo->equipamento,
                'subconjunto' => $result_pn_antigo->subconjunto,
                'modelo' => $result_pn_antigo->modelo,
                'empresa' => $result_pn_antigo->empresa,
                'idClientes' => $result_pn_antigo->idClientes,
                'observacao' => $result_pn_antigo->observacao,
                'versao' => $result_pn_antigo->versao,
                'versaoEmpresa' => $result_pn_antigo->versaoEmpresa,
                'desenho_DGW' => $result_pn_antigo->nomeArquivoDwg

            );

            // DADOS NOVOS PN VINDOS DO FORMULÁRIO EDIT
            $dados_novos = array(

                'descricao' => strtoupper($this->input->post('descricao')),
                'pn' => strtoupper($this->input->post('pn')),
                'referencia' => strtoupper($this->input->post('referencia')),
                'fornecedor_original' => strtoupper($this->input->post('fornecedor_original')),
                'equipamento' => strtoupper($this->input->post('equipamento')),
                'subconjunto' => strtoupper($this->input->post('subconjunto')),
                'modelo' => strtoupper($this->input->post('modelo')),
                'empresa' => strtoupper($this->input->post('empresa')),
                'idClientes' => ($this->input->post('idClientes') == "null" ? null : $this->input->post('idClientes')),
                'observacao' => strtoupper($this->input->post('observ')),
                'versao' => $this->input->post('versao'),
                'versaoEmpresa' => strtoupper($this->input->post('versaoEmpresa')),
                'desenho_DGW' => strtoupper($desenho_DWG)

            );

            $verifica_dif = array_diff($dados_novos,$dados_antigos);
            $campos_alterados = array_keys($verifica_dif);

            $acao = "";

            // VALIDA SE EDITA OU ADD NOVA VERSÃO PN
            if(empty($campos_alterados)){

                if($this->input->post('desenhos_corte') !== ""){

                    $acao = "EDITAR PN";

                }else{

                    $acao = "SEM AÇÃO";

                }

            }else{

                foreach ($campos_alterados as $k => $campos) {
                
                    if($campos == "versao" || $campos == "versaoEmpresa" || 
                       $campos == "empresa" || $campos == "desenho_DGW" ||
                       $campos == "idClientes"){
    
                        $acao = "ADICIONAR VERSÃO PN";
                        break;
    
                    }else{
    
                        $acao = "EDITAR PN";
    
                    }
    
                }

            }

            // TRATATIVOS PARA CASO DE ENVIO DE DESENHO DE CORTE
            if($this->input->post('desenhos_corte') !== ""){

                $corte_dados = explode("||,", $desenhos_corte);
                $corte_dados_tratatos = array();
                $dadosXCorte = "";

                foreach ($corte_dados as $k => $dado_corte) {

                    if($dado_corte !== ""){

                        $dadosXCorte = explode(",", $dado_corte);
                        array_push($corte_dados_tratatos, $dadosXCorte);

                        // TRATATIVA CONTINUA NA PARTE PERTO DA INCERSÃO DE DADOS NA TABELA PRODUTO HISTORY

                    }

                }

            }

            if($acao == "EDITAR PN"){

                $status = "EDIÇÃO DE PN | CAMPOS EDITADOS: ";

                foreach ($campos_alterados as $j => $editados) {
                        
                    $status .= $editados;

                    if(end($campos_alterados) == $editados){

                        $status .= ".";

                    }else{

                        $status .= ", ";

                    }

                }

                // DADOS PN EDITADO TABELA PRODUTOS
                $dados_edit_produtos = array(

                    'descricao' => strtoupper($this->input->post('descricao')),
                    'pn' => strtoupper($this->input->post('pn')),
                    'referencia' => strtoupper($this->input->post('referencia')),
                    'fornecedor_original' => strtoupper($this->input->post('fornecedor_original')),
                    'equipamento' => strtoupper($this->input->post('equipamento')),
                    'subconjunto' => strtoupper($this->input->post('subconjunto')),
                    'modelo' => strtoupper($this->input->post('modelo'))

                );

                $edit_produtos = $this->desenho_model->edit("produtos",$dados_edit_produtos,"idProdutos",$idProdutos);

                // DADOS PN EDITADO TABELA PRODUTO DESENHO
                $dados_edit_produto_desenho = array(

                    'descricao' => strtoupper($this->input->post('descricao')),
                    'observacao' => strtoupper($this->input->post('observ')),
                    'user_alteracao' => $this->session->userdata('idUsuarios')

                );

                $edit_produto_desenho = $this->desenho_model->edit("produto_desenho",$dados_edit_produto_desenho,"idPn",$idPn);

                // SE TIVER DESENHO DE CORTE
                $idCorte = "";
                $idCorteAdd = "";
                if($this->input->post('desenhos_corte') !== ""){

                    $nomeArquivoCorte = "";
                    $target_dir = "./assets/uploads/desenhos_master/";
                    $number_random = $this->generateRandomString();

                    for ($i=0; $i < 100; $i++) { 

                        $corte_chave = "corte".$i;
                        
                        if(isset($_FILES[$corte_chave]["name"])){

                            foreach ($corte_dados_tratatos as $y => $dado_do_corte) {

                                if($_FILES[$corte_chave]["name"] == $dado_do_corte[0]){

                                    // EXTENSAO DO ARQUIVO CORTE (dwg)
                                    $imageFileTypeCorte = strtolower(pathinfo(basename($_FILES[$corte_chave]["name"]),PATHINFO_EXTENSION));

                                    // NOME DO ARQUIVO COM LETRAS ALEATORIAS
                                    $_FILES[$corte_chave]["name"] = $resultado_pn."_".$corte_chave."_".$number_random.".".$imageFileTypeCorte;
                                    $nomeArquivoCorte = $resultado_pn."_".$corte_chave."_".$number_random;

                                    // CAMINHO COMPLETO DO ARQUIVO
                                    $target_fileCorte = $target_dir . basename($_FILES[$corte_chave]["name"]);

                                    // PARA CASO EXISTA O ARQUIVO NA PASTA
                                    if (file_exists($target_fileCorte)) {

                                        $number_random = $this->generateRandomString();

                                        $_FILES[$corte_chave]["name"] = $resultado_pn."_".$corte_chave."_".$number_random.".".$imageFileTypeCorte;
                                        $target_fileCorte = $target_dir . basename($_FILES[[$corte_chave]]["name"]);

                                    }

                                    // ENVIA ARQUIVOS DWG E JPG PARA PASTA DESENHOS MASTER
                                    if (move_uploaded_file($_FILES[$corte_chave]["tmp_name"], $target_fileCorte)) {

                                        // CADASTRAR NA TABELA
                                        $data_corte = array(

                                            'idProdutos' => $idProdutos,
                                            'idPn' => $idPn,
                                            'descricao_corte' => $dado_do_corte[1],
                                            'observacao_corte' => $dado_do_corte[2],
                                            'nomeArquivo' =>$nomeArquivoCorte,
                                            'caminho' => 'assets/uploads/desenhos_master/',
                                            'imagem' => $_FILES[$corte_chave]["name"],
                                            'extensao' =>$imageFileTypeCorte,
                                            'tamanho' => filesize($target_dir.$_FILES[$corte_chave]["name"])

                                        );

                                        $idCorteAdd = $this->desenho_model->add('desenho_corte', $data_corte, true);

                                        if($idCorte == ""){

                                            $idCorte = $idCorteAdd;

                                        }else{

                                            $idCorte .= ", ". $idCorteAdd;

                                        }

                                    }

                                }

                            }
            
                        }

                    }
                    
                }

                // DADOS LOG TABELA PRODUTO_HISTORY
                $data_produto_history = array(

                    'idProdutos' => $idProdutos,
                    'idPn' => $idPn,
                    'idDesenhos' => $idDesenhos,
                    'idUserHis' => $this->session->userdata('idUsuarios'),
                    'data_alteracaoHis' =>  date("Y-m-d H:i:s"),
                    'status' => $status,
                    'url' => 'desenho/editar_pn',
                    'descricao' => strtoupper($this->input->post('descricao')),
                    'pn' => strtoupper($this->input->post('pn')),
                    'referencia' => strtoupper($this->input->post('referencia')),
                    'fornecedor_original' => strtoupper($this->input->post('fornecedor_original')),
                    'equipamento' => strtoupper($this->input->post('equipamento')),
                    'subconjunto' => strtoupper($this->input->post('subconjunto')),
                    'modelo' => strtoupper($this->input->post('modelo')),
                    'versao' => $this->input->post('versao'),
                    'empresa' => strtoupper($this->input->post('empresa')),
                    'idClientes' => $idClientes,
                    'versaoEmpresa' => strtoupper($this->input->post('versaoEmpresa')),
                    'imagemDwg' => $result_pn_antigo->imagemDwg,
                    'ativo' => 1,
                    'master' => $result_pn_antigo->master,
                    'observacao' => strtoupper($this->input->post('observ')),
                    'idCorte' => $idCorte
                    
                );

                if (is_numeric($idProdutosHis = $this->desenho_model->add('produto_history', $data_produto_history, true))){

                    $this->session->set_flashdata('success','PN editado com sucesso!');
                    $this->session->set_flashdata('idProdutos',$idProdutos);
                    echo json_encode(array("result"=>true));
                    return;

                }else{

                    echo json_encode(array("result"=>false));
                    return;

                }

            }elseif ($acao == "ADICIONAR VERSÃO PN") {

                $idPn_anterior = $this->input->post('idPn');
                $idDesenho_anterior = $this->input->post('idDesenhos');
                
                $pn_principal = $this->produtos_model->getByPn($resultado_pn);

                $prod_desenho_anterior = $this->desenho_model->getPnProduto_desenho("idPn", $idPn_anterior);

                $status = "";
                $imagemDwg = "";

                // SE NOVA VERSÃO PN PRINCIPAL
                if(empty($this->input->post('empresa'))){

                    //EDITANDO COLUNA MASTER VERSÃO ANTERIOR TABELA PRODUTO DESENHO
                    $data_prodDes = array("master"=>0);
                    $this->desenho_model->edit("produto_desenho",$data_prodDes,"idPn",$idPn_anterior);

                    //EDITANDO COLUNA ATIVO VERSÃO ANTERIOR TABELA DESENHOS
                    $data_editDes = array("ativo"=>0);
                    $this->desenho_model->edit("desenhos",$data_editDes,"idDesenhos",$idDesenho_anterior);

                    $novaEmpresa = "";
                    $master = 1;
                    $idClientes = null;
                    $status = "NOVA VERSÃO DO PN PRINCIPAL | FORM EDIT";

                }else{

                    $master = 0;
                    $novaEmpresa = $this->input->post('empresa');
                    $idClientes  = $this->input->post('idClientes');
                    $status = "NOVA VERSÃO DO PN PARA A EMPRESA(CLIENTE): {$novaEmpresa} | FORM EDIT";

                }
                
                // SE NOVA VERSÃO DE EMPRESA
                if(null !== $this->input->post('versaoEmpresa')){
                    
                    $novaVersaoEmp = $this->input->post('versaoEmpresa');

                    //EDITANDO COLUNA MASTER VERSÃO ANTERIOR TABELA PRODUTO DESENHO
                    $data_prodDes = array("master"=>0);
                    $this->desenho_model->edit("produto_desenho",$data_prodDes,"idPn",$idPn_anterior);
                    
                }else{

                    $novaVersaoEmp = "";

                }

                // DADOS PARA TABELA PRODUTO_DESENHO
                $data_produtos_desenho = array(

                    "idProdutos" => $pn_principal->idProdutos,
                    "descricao" => $pn_principal->descricao,
                    "master" => $master,
                    "versao" => $this->input->post('versao'),
                    "idDesenhos" => 0,
                    "data_master" => date("Y-m-d H:i:s"),
                    "user_alteracao" => 0,
                    "user_criacao" => $this->session->userdata('idUsuarios'),
                    "observacao" => strtoupper($this->input->post('observ')),
                    "empresa" => strtoupper($novaEmpresa),
                    "versaoEmpresa" => strtoupper($novaVersaoEmp),
                    "idClientes" => $idClientes

                );

                //ADICIONANDO NA TABELA PRODUTO_DESENHO
                if (is_numeric($idPnNovo = $this->desenho_model->add('produto_desenho', $data_produtos_desenho, true)) ) {

                    // ADICIONANDO NA TABELA DESENHO
                    if(!empty($_FILES['imag_dwg']["name"])){
                    
                        $target_dir = "./assets/uploads/desenhos_master/";

                        // EXTENSAO DO ARQUIVO (dwg/jpg)
                        $imageFileTypeDwg = strtolower(pathinfo(basename($_FILES['imag_dwg']["name"]),PATHINFO_EXTENSION));
                        $imageFileTypeJpg = strtolower(pathinfo(basename($_FILES['imag_jpg']["name"]),PATHINFO_EXTENSION));

                        // NOME DO ARQUIVO COM LETRAS ALEATORIAS
                        $number_random = $this->generateRandomString();
                        $_FILES['imag_dwg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeDwg;
                        $_FILES['imag_jpg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeJpg;
                        
                        // CAMINHO COMPLETO DO ARQUIVO
                        $target_fileDwg = $target_dir . basename($_FILES['imag_dwg']["name"]);
                        $target_fileJpg = $target_dir . basename($_FILES['imag_jpg']["name"]);
                        
                        // PARA CASO EXISTA O ARQUIVO NA PASTA
                        if (file_exists($target_fileDwg) || file_exists($target_fileJpg)) {

                            $number_random = $this->generateRandomString();

                            $_FILES['imag_dwg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeDwg;
                            $target_fileDwg = $target_dir . basename($_FILES[['imag_dwg']]["name"]);           
                        
                            $_FILES['imag_jpg']["name"] = $resultado_pn."_".$number_random.".".$imageFileTypeJpg;
                            $target_fileJpg = $target_dir . basename($_FILES[['imag_jpg']]["name"]);

                        }
                        
                        // ENVIA ARQUIVOS DWG E JPG PARA PASTA DESENHOS MASTER
                        if (move_uploaded_file($_FILES['imag_dwg']["tmp_name"], $target_fileDwg)) {

                            move_uploaded_file($_FILES['imag_jpg']["tmp_name"], $target_fileJpg);

                            $imagemDwg = $_FILES['imag_dwg']["name"];

                            // DADOS PARA TABELA DESENHO
                            $data_desenhos = array(

                                'data_ini'          => date("Y-m-d H:i:s"),
                                'data_fim'          => date("Y-m-d H:i:s"),
                                'idProdutos'        => $pn_principal->idProdutos,
                                'idPn'              => $idPnNovo,
                                'nomeArquivoDwg'    => $resultado_pn,
                                'caminhoDwg'        => 'assets/uploads/desenhos_master/',
                                'imagemDwg'         => $_FILES['imag_dwg']["name"],
                                'extensaoDwg'       => $imageFileTypeDwg,
                                'tamanhoDwg'        => filesize($target_dir.$_FILES['imag_dwg']["name"]),
                                'nomeArquivoJpg'    => $resultado_pn,
                                'caminhoJpg'        => 'assets/uploads/desenhos_master/',
                                'imagemJpg'         => $_FILES['imag_jpg']["name"],
                                'extensaoJpg'       => $imageFileTypeJpg,
                                'tamanhoJpg'        => filesize($target_dir.$_FILES['imag_jpg']["name"]),          
                                'user_proprietario' => $this->session->userdata('idUsuarios'),
                                'user_alteracao'    => $this->session->userdata('idUsuarios'),
                                'data_alteracao'    => date("Y-m-d H:i:s"),
                                'versao'            => $this->input->post('versao'),
                                'ativo'             => 1,
                                'observacao'        => strtoupper($this->input->post('observ'))
                
                            );
                            
                            $idDesenhosNovo = $this->desenho_model->add('desenhos', $data_desenhos, true);

                            $data_edit_prodDes = array("idDesenhos"=>$idDesenhosNovo);

                            $this->desenho_model->edit("produto_desenho",$data_edit_prodDes,"idPn",$idPnNovo);

                        }

                    }else{

                        // SE ALTERAR SOMENTE A EMPRESA(CLIENTE) E NÃO ENVIAR NOVO DESENHO
                        $desenho_existente = $this->desenho_model->getPnDesenhos("idDesenhos", $idDesenhos);

                        $imagemDwg = $desenho_existente->imagemDwg;

                        // DADOS PARA TABELA DESENHO
                        $data_desenhos = array(

                            'data_ini'          => date("Y-m-d H:i:s"),
                            'data_fim'          => date("Y-m-d H:i:s"),
                            'idProdutos'        => $pn_principal->idProdutos,
                            'idPn'              => $idPnNovo,
                            'nomeArquivoDwg'    => $resultado_pn,
                            'caminhoDwg'        => 'assets/uploads/desenhos_master/',
                            'imagemDwg'         => $desenho_existente->imagemDwg,
                            'extensaoDwg'       => $desenho_existente->extensaoDwg,
                            'tamanhoDwg'        => $desenho_existente->tamanhoDwg,
                            'nomeArquivoJpg'    => $resultado_pn,
                            'caminhoJpg'        => 'assets/uploads/desenhos_master/',
                            'imagemJpg'         => $desenho_existente->imagemJpg,
                            'extensaoJpg'       => $desenho_existente->extensaoJpg,
                            'tamanhoJpg'        => $desenho_existente->tamanhoJpg,
                            'user_proprietario' => $this->session->userdata('idUsuarios'),
                            'user_alteracao'    => $this->session->userdata('idUsuarios'),
                            'data_alteracao'    => date("Y-m-d H:i:s"),
                            'versao'            => $this->input->post('versao'),
                            'ativo'             => 1,
                            'observacao'        => strtoupper($this->input->post('observ'))
            
                        );
                        
                        $idDesenhosNovo = $this->desenho_model->add('desenhos', $data_desenhos, true);

                        $data_edit_prodDes = array("idDesenhos"=>$idDesenhosNovo);

                        $this->desenho_model->edit("produto_desenho",$data_edit_prodDes,"idPn",$idPnNovo);

                    }

                    // SE TIVER DESENHO DE CORTE
                    $idCorte = "";
                    $idCorteAdd = "";
                    if($this->input->post('desenhos_corte') !== ""){

                        $nomeArquivoCorte = "";
                        $target_dir = "./assets/uploads/desenhos_master/";
                        $number_random = $this->generateRandomString();

                        for ($i=0; $i < 100; $i++) { 

                            $corte_chave = "corte".$i;
                            
                            if(isset($_FILES[$corte_chave]["name"])){

                                foreach ($corte_dados_tratatos as $y => $dado_do_corte) {

                                    if($_FILES[$corte_chave]["name"] == $dado_do_corte[0]){

                                        // EXTENSAO DO ARQUIVO CORTE (dwg)
                                        $imageFileTypeCorte = strtolower(pathinfo(basename($_FILES[$corte_chave]["name"]),PATHINFO_EXTENSION));

                                        // NOME DO ARQUIVO COM LETRAS ALEATORIAS
                                        $_FILES[$corte_chave]["name"] = $resultado_pn."_".$corte_chave."_".$number_random.".".$imageFileTypeCorte;
                                        $nomeArquivoCorte = $resultado_pn."_".$corte_chave."_".$number_random;

                                        // CAMINHO COMPLETO DO ARQUIVO
                                        $target_fileCorte = $target_dir . basename($_FILES[$corte_chave]["name"]);

                                        // PARA CASO EXISTA O ARQUIVO NA PASTA
                                        if (file_exists($target_fileCorte)) {

                                            $number_random = $this->generateRandomString();

                                            $_FILES[$corte_chave]["name"] = $resultado_pn."_".$corte_chave."_".$number_random.".".$imageFileTypeCorte;
                                            $target_fileCorte = $target_dir . basename($_FILES[[$corte_chave]]["name"]);

                                        }

                                        // ENVIA ARQUIVOS DWG E JPG PARA PASTA DESENHOS MASTER
                                        if (move_uploaded_file($_FILES[$corte_chave]["tmp_name"], $target_fileCorte)) {

                                            // CADASTRAR NA TABELA
                                            $data_corte = array(

                                                'idProdutos' => $pn_principal->idProdutos,
                                                'idPn' => $idPnNovo,
                                                'descricao_corte' => $dado_do_corte[1],
                                                'observacao_corte' => $dado_do_corte[2],
                                                'nomeArquivo' =>$nomeArquivoCorte,
                                                'caminho' => 'assets/uploads/desenhos_master/',
                                                'imagem' => $_FILES[$corte_chave]["name"],
                                                'extensao' =>$imageFileTypeCorte,
                                                'tamanho' => filesize($target_dir.$_FILES[$corte_chave]["name"])

                                            );

                                            $idCorteAdd = $this->desenho_model->add('desenho_corte', $data_corte, true);

                                            if($idCorte == ""){

                                                $idCorte = $idCorteAdd;

                                            }else{

                                                $idCorte .= ", ". $idCorteAdd;

                                            }

                                        }

                                    }

                                }
                
                            }

                        }
                        
                    }

                    // DADOS LOG TABELA PRODUTO_HISTORY
                    $data_produto_history = array(

                        'idProdutos' => $pn_principal->idProdutos,
                        'idPn' => $idPnNovo,
                        'idDesenhos' => $idDesenhosNovo,
                        'idUserHis' => $this->session->userdata('idUsuarios'),
                        'data_alteracaoHis' =>  date("Y-m-d H:i:s"),
                        'status' => $status,
                        'url' => 'desenho/editar_pn',
                        'descricao' => strtoupper($this->input->post('descricao')),
                        'pn' => strtoupper($this->input->post('pn')),
                        'referencia' => strtoupper($this->input->post('referencia')),
                        'fornecedor_original' => strtoupper($this->input->post('fornecedor_original')),
                        'equipamento' => strtoupper($this->input->post('equipamento')),
                        'subconjunto' => strtoupper($this->input->post('subconjunto')),
                        'modelo' => strtoupper($this->input->post('modelo')),
                        'versao' => $this->input->post('versao'),
                        'empresa' => strtoupper($this->input->post('empresa')),
                        'idClientes' => $idClientes,
                        'versaoEmpresa' => strtoupper($this->input->post('versaoEmpresa')),
                        'imagemDwg' => $imagemDwg,
                        'ativo' => 1,
                        'master' => $master,
                        'observacao' => strtoupper($this->input->post('observ')),
                        'idCorte' => $idCorte
                        
                    );

                    if (is_numeric($idProdutosHis = $this->desenho_model->add('produto_history', $data_produto_history, true))){

                        $this->session->set_flashdata('success','Versão de Produto PN adicionado com sucesso!');
                        $this->session->set_flashdata('idProdutos',$pn_principal->idProdutos);
                        echo json_encode(array("result"=>true));
                        return;

                    }else{

                        echo json_encode(array("result"=>false));
                        return;

                    }

                }else {

                    $this->data['custom_error'] = '<div class="form_error"><p>Erro ao cadastrar.</p></div>';
                    echo json_encode(array("result"=>false));
                    return;

                }

            }else{

                $this->data['custom_error'] = '<div class="form_error"><p>NENHUM DADO FOI EDITADO</p></div>';
                echo json_encode(array("result"=>false));
                return;

            }

           
        }

    }

    function modal_add_desenho(){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $idProduto = $this->input->post('id');
        $idPn = $this->input->post('idPn');

        if(null !== $idPn){
            $verifica = $this->desenho_model->getPnProduto_desenho("idPn", $idPn);
        }else{
            $verifica = $this->desenho_model->getPnProduto_desenho("idProdutos", $idProduto);
        }

        if(empty($verifica)){

            $resultado = $this->desenho_model->getPnProdutos("idProdutos", $idProduto);

        }else{

            if(null !== $verifica[0]->idClientes){
                $campo = "idClientes";
                $empresa = $verifica[0]->idClientes;
            }else{
                $campo = "empresa";
                $empresa = "";
            }

            $versao_empresa = (isset($verifica[0]->versaoEmpresa) ? $verifica[0]->versaoEmpresa : "");
            $resultado = $this->desenho_model->getPn_vers_edit("idProdutos", $idProduto, $campo, $empresa, $versao_empresa, $idPn);

        }

        echo json_encode(array("result"=>true,"resultado"=>$resultado));
        return;


    }

    function add_desenho_pn(){

        // ADICIONANDO NA TABELA DESENHO
        if(!empty($_FILES['imag_dwg']["name"])){


            $idPn = $this->input->post('idPn');
            $idProdutos = $this->input->post('idProdutos');
            $pn = $this->input->post('pn');

            $teste_idPn = $this->desenho_model->getPnProduto_desenho("idPn", $idPn);

            if(empty($teste_idPn)){

                // CASO PN NÃO TENHA CADASTRO NA TABELA PRODUTO_DESENHO
                $dados = $this->desenho_model->getPnProdutos("idProdutos", $idProdutos);

                // DADOS PARA TABELA PRODUTO_DESENHO
                $data_produtos_desenho = array(

                    "idProdutos" => $idProdutos,
                    "descricao" => $dados[0]->descricao,
                    "master" => 1,
                    "versao" => 0,
                    "idDesenhos" => 0,
                    "data_master" => date("Y-m-d H:i:s"),
                    "user_alteracao" => 0,
                    "user_criacao" => $this->session->userdata('idUsuarios'),
                    "observacao" => '',
                    "empresa" => '',
                    "versaoEmpresa" => '',
                    "idClientes" => null

                );

                //ADICIONANDO NA TABELA PRODUTO_DESENHO
                if (is_numeric($idPn = $this->desenho_model->add('produto_desenho', $data_produtos_desenho, true)) ) {

                    // ADICIONANDO NA TABELA DESENHO
                    if(!empty($_FILES['imag_dwg']["name"])){
                    
                        $target_dir = "./assets/uploads/desenhos_master/";

                        // EXTENSAO DO ARQUIVO (dwg/jpg)
                        $imageFileTypeDwg = strtolower(pathinfo(basename($_FILES['imag_dwg']["name"]),PATHINFO_EXTENSION));
                        $imageFileTypeJpg = strtolower(pathinfo(basename($_FILES['imag_jpg']["name"]),PATHINFO_EXTENSION));

                        // NOME DO ARQUIVO COM LETRAS ALEATORIAS
                        $number_random = $this->generateRandomString();
                        $_FILES['imag_dwg']["name"] = $pn."_".$number_random.".".$imageFileTypeDwg;
                        $_FILES['imag_jpg']["name"] = $pn."_".$number_random.".".$imageFileTypeJpg;
                        
                        // CAMINHO COMPLETO DO ARQUIVO
                        $target_fileDwg = $target_dir . basename($_FILES['imag_dwg']["name"]);
                        $target_fileJpg = $target_dir . basename($_FILES['imag_jpg']["name"]);
                        
                        // PARA CASO EXISTA O ARQUIVO NA PASTA
                        if (file_exists($target_fileDwg) || file_exists($target_fileJpg)) {

                            $number_random = $this->generateRandomString();

                            $_FILES['imag_dwg']["name"] = $pn."_".$number_random.".".$imageFileTypeDwg;
                            $target_fileDwg = $target_dir . basename($_FILES[['imag_dwg']]["name"]);           
                        
                            $_FILES['imag_jpg']["name"] = $pn."_".$number_random.".".$imageFileTypeJpg;
                            $target_fileJpg = $target_dir . basename($_FILES[['imag_jpg']]["name"]);

                        }
                        
                        // ENVIA ARQUIVOS DWG E JPG PARA PASTA DESENHOS MASTER
                        if (move_uploaded_file($_FILES['imag_dwg']["tmp_name"], $target_fileDwg)) {

                            move_uploaded_file($_FILES['imag_jpg']["tmp_name"], $target_fileJpg);

                            // DADOS PARA TABELA DESENHO
                            $data_desenhos = array(

                                'data_ini'          => date("Y-m-d H:i:s"),
                                'data_fim'          => date("Y-m-d H:i:s"),
                                'idProdutos'        => $idProdutos,
                                'idPn'              => $idPn,
                                'nomeArquivoDwg'    => $pn,
                                'caminhoDwg'        => 'assets/uploads/desenhos_master/',
                                'imagemDwg'         => $_FILES['imag_dwg']["name"],
                                'extensaoDwg'       => $imageFileTypeDwg,
                                'tamanhoDwg'        => filesize($target_dir.$_FILES['imag_dwg']["name"]),
                                'nomeArquivoJpg'    => $pn,
                                'caminhoJpg'        => 'assets/uploads/desenhos_master/',
                                'imagemJpg'         => $_FILES['imag_jpg']["name"],
                                'extensaoJpg'       => $imageFileTypeJpg,
                                'tamanhoJpg'        => filesize($target_dir.$_FILES['imag_jpg']["name"]),          
                                'user_proprietario' => $this->session->userdata('idUsuarios'),
                                'user_alteracao'    => 0,
                                'data_alteracao'    => null,
                                'versao'            => 0,
                                'ativo'             => 1,
                                'observacao'        => ''
                
                            );
                            
                            $idDesenhos = $this->desenho_model->add('desenhos', $data_desenhos, true);

                            $data_edit_prodDes = array("idDesenhos"=>$idDesenhos);

                            $this->desenho_model->edit("produto_desenho",$data_edit_prodDes,"idPn",$idPn);

                        }

                    }

                    // DADOS LOG TABELA PRODUTO_HISTORY
                    $data_produto_history = array(
                        
                        'idProdutos' => $idProdutos,
                        'idPn' => $idPn,
                        'idDesenhos' => $idDesenhos,
                        'idUserHis' => $this->session->userdata('idUsuarios'),
                        'data_alteracaoHis' =>  date("Y-m-d H:i:s"),
                        'status' => 'ADICIONOU DESENHO EM UM PN EXISTENTE QUE NÃO TINHA DESENHO - ADICIONOU PN NA TABELA PRODUTO_DESENHO',
                        'url' => 'desenho/add_desenho_pn',
                        'descricao' => strtoupper($dados[0]->descricao),
                        'pn' => strtoupper($pn),
                        'referencia' => strtoupper($dados[0]->referencia),
                        'fornecedor_original' => strtoupper($dados[0]->fornecedor_original),
                        'equipamento' => strtoupper($dados[0]->equipamento),
                        'subconjunto' => strtoupper($dados[0]->subconjunto),
                        'modelo' => strtoupper($dados[0]->modelo),
                        'versao' => 0,
                        'empresa' => '',
                        'idClientes' => null,
                        'versaoEmpresa' => '',
                        'imagemDwg' => $_FILES['imag_dwg']["name"],
                        'ativo' => 1,
                        'master' => 1,
                        'observacao' => ''
                        
                    );

                    if (is_numeric($idProdutosHis = $this->desenho_model->add('produto_history', $data_produto_history, true))){

                        $this->session->set_flashdata('success','Desenho anexado com sucesso!');
                        $this->session->set_flashdata('idProdutos',$idProdutos);
                        echo json_encode(array("result"=>true));
                        return;

                    }else{

                        echo json_encode(array("result"=>false));
                        return;
    
                    }
                    
                }

            }else{

                $pn_desenho = $this->desenho_model->getCompletoPn("idProdutos", $idProdutos, $idPn);

                // PASTA MASTER            
                $target_dir = "./assets/uploads/desenhos_master/";

                // EXTENSAO DO ARQUIVO (dwg/jpg)
                $imageFileTypeDwg = strtolower(pathinfo(basename($_FILES['imag_dwg']["name"]),PATHINFO_EXTENSION));
                $imageFileTypeJpg = strtolower(pathinfo(basename($_FILES['imag_jpg']["name"]),PATHINFO_EXTENSION));

                // NOME DO ARQUIVO COM LETRAS ALEATORIAS
                $number_random = $this->generateRandomString();
                $_FILES['imag_dwg']["name"] = $pn."_".$number_random.".".$imageFileTypeDwg;
                $_FILES['imag_jpg']["name"] = $pn."_".$number_random.".".$imageFileTypeJpg;
                
                // CAMINHO COMPLETO DO ARQUIVO
                $target_fileDwg = $target_dir . basename($_FILES['imag_dwg']["name"]);
                $target_fileJpg = $target_dir . basename($_FILES['imag_jpg']["name"]);
                
                // PARA CASO EXISTA O ARQUIVO NA PASTA
                if (file_exists($target_fileDwg) || file_exists($target_fileJpg)) {

                    $number_random = $this->generateRandomString();

                    $_FILES['imag_dwg']["name"] = $pn."_".$number_random.".".$imageFileTypeDwg;
                    $target_fileDwg = $target_dir . basename($_FILES[['imag_dwg']]["name"]);           
                
                    $_FILES['imag_jpg']["name"] = $pn."_".$number_random.".".$imageFileTypeJpg;
                    $target_fileJpg = $target_dir . basename($_FILES[['imag_jpg']]["name"]);

                }
                
                // ENVIA ARQUIVOS DWG E JPG PARA PASTA DESENHOS MASTER
                if (move_uploaded_file($_FILES['imag_dwg']["tmp_name"], $target_fileDwg)) {

                    move_uploaded_file($_FILES['imag_jpg']["tmp_name"], $target_fileJpg);

                    // DADOS PARA TABELA DESENHO
                    $data_desenhos = array(

                        'data_ini'          => date("Y-m-d H:i:s"),
                        'data_fim'          => date("Y-m-d H:i:s"),
                        'idProdutos'        => $idProdutos,
                        'idPn'              => $idPn,
                        'nomeArquivoDwg'    => $pn,
                        'caminhoDwg'        => 'assets/uploads/desenhos_master/',
                        'imagemDwg'         => $_FILES['imag_dwg']["name"],
                        'extensaoDwg'       => $imageFileTypeDwg,
                        'tamanhoDwg'        => filesize($target_dir.$_FILES['imag_dwg']["name"]),
                        'nomeArquivoJpg'    => $pn,
                        'caminhoJpg'        => 'assets/uploads/desenhos_master/',
                        'imagemJpg'         => $_FILES['imag_jpg']["name"],
                        'extensaoJpg'       => $imageFileTypeJpg,
                        'tamanhoJpg'        => filesize($target_dir.$_FILES['imag_jpg']["name"]),          
                        'user_proprietario' => $this->session->userdata('idUsuarios'),
                        'user_alteracao'    => 0,
                        'data_alteracao'    => null,
                        'versao'            => 0,
                        'ativo'             => 1,
                        'observacao'        => ''
        
                    );
                    
                    $idDesenhos = $this->desenho_model->add('desenhos', $data_desenhos, true);

                    $data_edit_prodDes = array("idDesenhos"=>$idDesenhos);

                    $this->desenho_model->edit("produto_desenho",$data_edit_prodDes,"idPn",$idPn);

                }

                // DADOS LOG TABELA PRODUTO_HISTORY
                $data_produto_history = array(
                    
                    'idProdutos' => $idProdutos,
                    'idPn' => $idPn,
                    'idDesenhos' => $idDesenhos,
                    'idUserHis' => $this->session->userdata('idUsuarios'),
                    'data_alteracaoHis' =>  date("Y-m-d H:i:s"),
                    'status' => 'ADICIONOU DESENHO EM UM PN EXISTENTE QUE NÃO TINHA DESENHO',
                    'url' => 'desenho/add_desenho_pn',
                    'descricao' => strtoupper($pn_desenho[0]->descricao),
                    'pn' => strtoupper($pn),
                    'referencia' => strtoupper($pn_desenho[0]->referencia),
                    'fornecedor_original' => strtoupper($pn_desenho[0]->fornecedor_original),
                    'equipamento' => strtoupper($pn_desenho[0]->equipamento),
                    'subconjunto' => strtoupper($pn_desenho[0]->subconjunto),
                    'modelo' => strtoupper($pn_desenho[0]->modelo),
                    'versao' => $pn_desenho[0]->versao,
                    'empresa' => $pn_desenho[0]->empresa,
                    'idClientes' => $pn_desenho[0]->idClientes,
                    'versaoEmpresa' => $pn_desenho[0]->versaoEmpresa,
                    'imagemDwg' => $_FILES['imag_dwg']["name"],
                    'ativo' => 1,
                    'master' => $pn_desenho[0]->master,
                    'observacao' => $pn_desenho[0]->observacao
                    
                );

                if (is_numeric($idProdutosHis = $this->desenho_model->add('produto_history', $data_produto_history, true))){

                    $this->session->set_flashdata('success','Desenho anexado com sucesso!');
                    $this->session->set_flashdata('idProdutos',$idProdutos);
                    echo json_encode(array("result"=>true));
                    return;

                }else{

                    echo json_encode(array("result"=>false));
                    return;

                }

            }

        }

    }

    function add_pn_existente(){

        // ADICIONANDO NA TABELA DESENHO PN EXISTENTE COM TODAS OS CAMPOS PREENCHIDOS
        if(!empty($_FILES['imag_dwg']["name"])){


            $idPn = $this->input->post('idPn');
            $idProdutos = $this->input->post('idProdutos');
            $pn = $this->input->post('pn');

            $teste_idPn = $this->desenho_model->getPnProduto_desenho("idPn", $idPn);

            if(empty($teste_idPn)){

                // CASO PN NÃO TENHA CADASTRO NA TABELA PRODUTO_DESENHO

                // DADOS PARA TABELA PRODUTOS
                $data_produtos = array(

                    'descricao' => strtoupper($this->input->post('descricao')),
                    'pn' => strtoupper($pn),
                    'referencia' => strtoupper($this->input->post('referencia')),
                    'fornecedor_original' => strtoupper($this->input->post('fornecedor_original')),
                    'equipamento' => strtoupper($this->input->post('equipamento')),
                    'subconjunto' => strtoupper($this->input->post('subconjunto')),
                    'modelo' => strtoupper($this->input->post('modelo'))
                    
                );

                // EDITANDO REGISTRO PRODUTOS ADICIONANDO CAMPOS QUE ESTAVAM FALTANDO
                $edit_produtos = $this->desenho_model->edit("produtos",$data_produtos,"idProdutos",$idProdutos);

                // BUSCA DADOS TABELA PRODUTOS
                $dados = $this->desenho_model->getPnProdutos("idProdutos", $idProdutos);

                // DADOS PARA TABELA PRODUTO_DESENHO
                $data_produtos_desenho = array(

                    "idProdutos" => $idProdutos,
                    "descricao" => $dados[0]->descricao,
                    "master" => 1,
                    "versao" => 0,
                    "idDesenhos" => 0,
                    "data_master" => date("Y-m-d H:i:s"),
                    "user_alteracao" => 0,
                    "user_criacao" => $this->session->userdata('idUsuarios'),
                    "observacao" => strtoupper($this->input->post('observ')),
                    "empresa" => '',
                    "versaoEmpresa" => '',
                    "idClientes" => null

                );

                //ADICIONANDO NA TABELA PRODUTO_DESENHO
                if (is_numeric($idPn = $this->desenho_model->add('produto_desenho', $data_produtos_desenho, true)) ) {

                    // ADICIONANDO NA TABELA DESENHO
                    if(!empty($_FILES['imag_dwg']["name"])){
                    
                        $target_dir = "./assets/uploads/desenhos_master/";

                        // EXTENSAO DO ARQUIVO (dwg/jpg)
                        $imageFileTypeDwg = strtolower(pathinfo(basename($_FILES['imag_dwg']["name"]),PATHINFO_EXTENSION));
                        $imageFileTypeJpg = strtolower(pathinfo(basename($_FILES['imag_jpg']["name"]),PATHINFO_EXTENSION));

                        // NOME DO ARQUIVO COM LETRAS ALEATORIAS
                        $number_random = $this->generateRandomString();
                        $_FILES['imag_dwg']["name"] = $pn."_".$number_random.".".$imageFileTypeDwg;
                        $_FILES['imag_jpg']["name"] = $pn."_".$number_random.".".$imageFileTypeJpg;
                        
                        // CAMINHO COMPLETO DO ARQUIVO
                        $target_fileDwg = $target_dir . basename($_FILES['imag_dwg']["name"]);
                        $target_fileJpg = $target_dir . basename($_FILES['imag_jpg']["name"]);
                        
                        // PARA CASO EXISTA O ARQUIVO NA PASTA
                        if (file_exists($target_fileDwg) || file_exists($target_fileJpg)) {

                            $number_random = $this->generateRandomString();

                            $_FILES['imag_dwg']["name"] = $pn."_".$number_random.".".$imageFileTypeDwg;
                            $target_fileDwg = $target_dir . basename($_FILES[['imag_dwg']]["name"]);           
                        
                            $_FILES['imag_jpg']["name"] = $pn."_".$number_random.".".$imageFileTypeJpg;
                            $target_fileJpg = $target_dir . basename($_FILES[['imag_jpg']]["name"]);

                        }
                        
                        // ENVIA ARQUIVOS DWG E JPG PARA PASTA DESENHOS MASTER
                        if (move_uploaded_file($_FILES['imag_dwg']["tmp_name"], $target_fileDwg)) {

                            move_uploaded_file($_FILES['imag_jpg']["tmp_name"], $target_fileJpg);

                            // DADOS PARA TABELA DESENHO
                            $data_desenhos = array(

                                'data_ini'          => date("Y-m-d H:i:s"),
                                'data_fim'          => date("Y-m-d H:i:s"),
                                'idProdutos'        => $idProdutos,
                                'idPn'              => $idPn,
                                'nomeArquivoDwg'    => $pn,
                                'caminhoDwg'        => 'assets/uploads/desenhos_master/',
                                'imagemDwg'         => $_FILES['imag_dwg']["name"],
                                'extensaoDwg'       => $imageFileTypeDwg,
                                'tamanhoDwg'        => filesize($target_dir.$_FILES['imag_dwg']["name"]),
                                'nomeArquivoJpg'    => $pn,
                                'caminhoJpg'        => 'assets/uploads/desenhos_master/',
                                'imagemJpg'         => $_FILES['imag_jpg']["name"],
                                'extensaoJpg'       => $imageFileTypeJpg,
                                'tamanhoJpg'        => filesize($target_dir.$_FILES['imag_jpg']["name"]),          
                                'user_proprietario' => $this->session->userdata('idUsuarios'),
                                'user_alteracao'    => 0,
                                'data_alteracao'    => null,
                                'versao'            => 0,
                                'ativo'             => 1,
                                'observacao'        => strtoupper($this->input->post('observ'))
                
                            );
                            
                            $idDesenhos = $this->desenho_model->add('desenhos', $data_desenhos, true);

                            $data_edit_prodDes = array("idDesenhos"=>$idDesenhos);

                            $this->desenho_model->edit("produto_desenho",$data_edit_prodDes,"idPn",$idPn);

                        }

                    }

                    // DADOS LOG TABELA PRODUTO_HISTORY
                    $data_produto_history = array(
                        
                        'idProdutos' => $idProdutos,
                        'idPn' => $idPn,
                        'idDesenhos' => $idDesenhos,
                        'idUserHis' => $this->session->userdata('idUsuarios'),
                        'data_alteracaoHis' =>  date("Y-m-d H:i:s"),
                        'status' => 'ADICIONOU DESENHO EM UM PN EXISTENTE QUE NÃO TINHA DESENHO - ADICIONOU PN NA TABELA PRODUTO_DESENHO',
                        'url' => 'desenho/add_desenho_pn',
                        'descricao' => strtoupper($dados[0]->descricao),
                        'pn' => strtoupper($pn),
                        'referencia' => strtoupper($dados[0]->referencia),
                        'fornecedor_original' => strtoupper($dados[0]->fornecedor_original),
                        'equipamento' => strtoupper($dados[0]->equipamento),
                        'subconjunto' => strtoupper($dados[0]->subconjunto),
                        'modelo' => strtoupper($dados[0]->modelo),
                        'versao' => 0,
                        'empresa' => '',
                        'idClientes' => null,
                        'versaoEmpresa' => '',
                        'imagemDwg' => $_FILES['imag_dwg']["name"],
                        'ativo' => 1,
                        'master' => 1,
                        'observacao' => strtoupper($this->input->post('observ'))
                        
                    );

                    if (is_numeric($idProdutosHis = $this->desenho_model->add('produto_history', $data_produto_history, true))){

                        $this->session->set_flashdata('success','Desenho anexado com sucesso!');
                        $this->session->set_flashdata('idProdutos',$idProdutos);
                        echo json_encode(array("result"=>true));
                        return;

                    }else{

                        echo json_encode(array("result"=>false));
                        return;
    
                    }
                    
                }

            }else{

                $pn_desenho = $this->desenho_model->getCompletoPn("idProdutos", $idProdutos, $idPn);

                // PASTA MASTER            
                $target_dir = "./assets/uploads/desenhos_master/";

                // EXTENSAO DO ARQUIVO (dwg/jpg)
                $imageFileTypeDwg = strtolower(pathinfo(basename($_FILES['imag_dwg']["name"]),PATHINFO_EXTENSION));
                $imageFileTypeJpg = strtolower(pathinfo(basename($_FILES['imag_jpg']["name"]),PATHINFO_EXTENSION));

                // NOME DO ARQUIVO COM LETRAS ALEATORIAS
                $number_random = $this->generateRandomString();
                $_FILES['imag_dwg']["name"] = $pn."_".$number_random.".".$imageFileTypeDwg;
                $_FILES['imag_jpg']["name"] = $pn."_".$number_random.".".$imageFileTypeJpg;
                
                // CAMINHO COMPLETO DO ARQUIVO
                $target_fileDwg = $target_dir . basename($_FILES['imag_dwg']["name"]);
                $target_fileJpg = $target_dir . basename($_FILES['imag_jpg']["name"]);
                
                // PARA CASO EXISTA O ARQUIVO NA PASTA
                if (file_exists($target_fileDwg) || file_exists($target_fileJpg)) {

                    $number_random = $this->generateRandomString();

                    $_FILES['imag_dwg']["name"] = $pn."_".$number_random.".".$imageFileTypeDwg;
                    $target_fileDwg = $target_dir . basename($_FILES[['imag_dwg']]["name"]);           
                
                    $_FILES['imag_jpg']["name"] = $pn."_".$number_random.".".$imageFileTypeJpg;
                    $target_fileJpg = $target_dir . basename($_FILES[['imag_jpg']]["name"]);

                }
                
                // ENVIA ARQUIVOS DWG E JPG PARA PASTA DESENHOS MASTER
                if (move_uploaded_file($_FILES['imag_dwg']["tmp_name"], $target_fileDwg)) {

                    move_uploaded_file($_FILES['imag_jpg']["tmp_name"], $target_fileJpg);

                    // DADOS PARA TABELA DESENHO
                    $data_desenhos = array(

                        'data_ini'          => date("Y-m-d H:i:s"),
                        'data_fim'          => date("Y-m-d H:i:s"),
                        'idProdutos'        => $idProdutos,
                        'idPn'              => $idPn,
                        'nomeArquivoDwg'    => $pn,
                        'caminhoDwg'        => 'assets/uploads/desenhos_master/',
                        'imagemDwg'         => $_FILES['imag_dwg']["name"],
                        'extensaoDwg'       => $imageFileTypeDwg,
                        'tamanhoDwg'        => filesize($target_dir.$_FILES['imag_dwg']["name"]),
                        'nomeArquivoJpg'    => $pn,
                        'caminhoJpg'        => 'assets/uploads/desenhos_master/',
                        'imagemJpg'         => $_FILES['imag_jpg']["name"],
                        'extensaoJpg'       => $imageFileTypeJpg,
                        'tamanhoJpg'        => filesize($target_dir.$_FILES['imag_jpg']["name"]),          
                        'user_proprietario' => $this->session->userdata('idUsuarios'),
                        'user_alteracao'    => 0,
                        'data_alteracao'    => null,
                        'versao'            => 0,
                        'ativo'             => 1,
                        'observacao'        => ''
        
                    );
                    
                    $idDesenhos = $this->desenho_model->add('desenhos', $data_desenhos, true);

                    $data_edit_prodDes = array("idDesenhos"=>$idDesenhos);

                    $this->desenho_model->edit("produto_desenho",$data_edit_prodDes,"idPn",$idPn);

                }

                // DADOS LOG TABELA PRODUTO_HISTORY
                $data_produto_history = array(
                    
                    'idProdutos' => $idProdutos,
                    'idPn' => $idPn,
                    'idDesenhos' => $idDesenhos,
                    'idUserHis' => $this->session->userdata('idUsuarios'),
                    'data_alteracaoHis' =>  date("Y-m-d H:i:s"),
                    'status' => 'ADICIONOU DESENHO EM UM PN EXISTENTE QUE NÃO TINHA DESENHO',
                    'url' => 'desenho/add_desenho_pn',
                    'descricao' => strtoupper($pn_desenho[0]->descricao),
                    'pn' => strtoupper($pn),
                    'referencia' => strtoupper($pn_desenho[0]->referencia),
                    'fornecedor_original' => strtoupper($pn_desenho[0]->fornecedor_original),
                    'equipamento' => strtoupper($pn_desenho[0]->equipamento),
                    'subconjunto' => strtoupper($pn_desenho[0]->subconjunto),
                    'modelo' => strtoupper($pn_desenho[0]->modelo),
                    'versao' => $pn_desenho[0]->versao,
                    'empresa' => $pn_desenho[0]->empresa,
                    'idClientes' => $pn_desenho[0]->idClientes,
                    'versaoEmpresa' => $pn_desenho[0]->versaoEmpresa,
                    'imagemDwg' => $_FILES['imag_dwg']["name"],
                    'ativo' => 1,
                    'master' => $pn_desenho[0]->master,
                    'observacao' => $pn_desenho[0]->observacao
                    
                );

                if (is_numeric($idProdutosHis = $this->desenho_model->add('produto_history', $data_produto_history, true))){

                    $this->session->set_flashdata('success','Desenho anexado com sucesso!');
                    $this->session->set_flashdata('idProdutos',$idProdutos);
                    echo json_encode(array("result"=>true));
                    return;

                }else{

                    echo json_encode(array("result"=>false));
                    return;

                }

            }

        }

    }

    public function autoCompletePN(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->desenho_model->autoCompletePN($q);
        }
        
    }

    public function autoCompletePNDescri(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->desenho_model->autoCompletePNDescri($q);
        }
        
    }

    public function autoCompletePNRef(){   

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->desenho_model->autoCompletePNRef($q);
        }
        
    }

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->desenho_model->autoCompleteCliente($q);
        }

    }

    function autoCompleteEmpresa(){

        $pn = $this->input->post('pn');

        $empresas = $this->desenho_model->autoCompleteEmpresa($pn);

        echo json_encode(array("result"=>true,'empresas'=>$empresas));

    }

    function autoCompleteVersaoEmpresa(){

        $empresa = $this->input->post('empresa');
        
        // CAMPOS
        $num_pn = explode("|",$this->input->post("pn"));
        $pn = strtoupper(str_replace(" ","", $num_pn[0]));

        $versaoEmpresa = $this->desenho_model->autoCompleteVersaoEmpresa($empresa, $pn);

        echo json_encode(array("result"=>true,'versaoEmpresa'=>$versaoEmpresa));

    }

    function findPn(){

        $this->load->model('produtos_model');

        // CAMPOS
        $num_pn = explode("|",$this->input->post("pn"));
        $pn = strtoupper(str_replace(" ","", $num_pn[0]));

        $empresa = (null !== $this->input->post("empresa") ? $this->input->post("empresa") : "");
        $campo = "idClientes";

        if($empresa == "SELECIONE EMPRESA" || $empresa == ""){
            $campo = "empresa";
            $empresa = "";
        }

        $versao_empresa = (null !== $this->input->post("versaoEmpresa") ? $this->input->post("versaoEmpresa") : "");

        $verifica = $this->desenho_model->getPnBusca("pn", $pn, $campo, $empresa, $versao_empresa);

        if(empty($verifica)){

            $resultado = $this->desenho_model->getPnProdutos("pn", $pn);

        }else{

            $resultado = $verifica;

        }
        
        $json = array('result'=>true,'resultado'=>$resultado, 'pn'=>$pn);
        echo json_encode($json);

    }

    function historico(){

        $idPn = $this->input->post("idPn");

        $resultado = $this->desenho_model->historico("idPn",$idPn);

        foreach ($resultado as $k => $value) {
            
            $resultado[$k]->data_alteracaoHis = date("d/m/Y H:i:s", strtotime($value->data_alteracaoHis));

        }

        $json = array('result'=>true,'resultado'=>$resultado);
        echo json_encode($json);

    }

    function verifica_versao_empresa(){

        $idProdutos = $this->input->post("idProdutos");
        $idClientes = $this->input->post("idClientes");
        $versao = $this->input->post("versao");

        $versaoEmp = $this->desenho_model->verifica_versao_empresa($idProdutos, $idClientes, $versao);

        if(empty($versaoEmp) || $versaoEmp == "" || 
           $versaoEmp == null || $versaoEmp == "0" ){

            $resposta = false;
            $resultado = 0;

        }else{

            $resposta = true;
            $resultado = $versaoEmp;

        }

        $json = array('result'=>$resposta,'resultado'=>$resultado);
        echo json_encode($json);

    }

    function desenho_corte(){

        $idPn = $this->input->post("idPn");

        $resultado = $this->desenho_model->getLisaDesenhoCorte($idPn);

        $json = array('result'=>true,'resultado'=>$resultado);
        echo json_encode($json);

    }
    
}