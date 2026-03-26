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
		//$this->gerenciar();
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
                $this->data['result'] = $this->orcamentos_model->getOrçAguardandoDesenho($where);
            }else{
                $where = " where (orcamento_item.statusDesenho = 1 or orcamento_item.statusDesenho = 2)";
                $this->data['result'] = $this->orcamentos_model->getOrçAguardandoDesenho($where);
            }
            
        }else{
            $where = " where (orcamento_item.statusDesenho = 1 or orcamento_item.statusDesenho = 2)";
            $this->data['result'] = $this->orcamentos_model->getOrçAguardandoDesenho($where);
        }
        $this->data['view'] = 'desenho/aguardandodesenho';
       	$this->load->view('tema/topo',$this->data);

    }
    function visualizardesenhos(){
        $this->load->model('orcamentos_model');
        $this->data['orcam'] = $this->orcamentos_model->getOrcItemDetailsById2($this->uri->segment(3));
        $this->data['result'] = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao( $this->uri->segment(3));
        $this->data['view'] = 'desenho/visualizardesenhos';
       	$this->load->view('tema/topo',$this->data);
    }
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
    }
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
        $this->desenho_model->edit('orcamento_item',$data,'idOrcamento_item',$idOrcItem);
        $this->session->set_flashdata('success', 'Finalizado com sucesso!');
        redirect(base_url().'index.php/desenho/visualizardesenhos/'.$idOrcItem);
    }
}