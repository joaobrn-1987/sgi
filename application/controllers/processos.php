<?php

class Processos extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('processos_model', '', TRUE);
        $this->data['menuOrcamentos'] = 'Orcamentos';
    }
    function index()
    {
        $this->gerenciar();
    }

    function gerenciar()
    {
        $where = '';
        if(!$this->permission->checkPermission($this->session->userdata('permissao'), 'eProcessos')){
            $where = ' and anexo_processos.ativo = 1';
        }
        
        if($this->input->post('grupo')){
            $where .= " and anexo_processos.idGrupoProcessos = ".$this->input->post('grupo');
        }
        if($this->input->post('descricao')){
            $where .= " and anexo_processos.descricaoArquivo like '%".$this->input->post('descricao')."%'";
        }
        $this->data['result'] = $this->processos_model->getGrupoProcessos($where);
        foreach($this->data['result'] as $c){
            $c->anexos= $this->processos_model->getAnexosProcessos($c->idGrupoProcessos,$where);
        }
        $this->data['grupos'] = $this->processos_model->getGrupos();
        $this->data['view'] = 'processos/processos';
        $this->load->view('tema/topo', $this->data);
    }

    function cadastrargrupo(){
        if(empty($this->input->post("descricao"))){
            $this->session->set_flashdata('error', 'Descrição não preenchida.');
            redirect('processos');
        }
        $data = array(
            "descricaoGrupoProcessos"=>strtoupper($this->input->post("descricao"))
        );
        $this->processos_model->add("grupo_processos",$data);
        $this->session->set_flashdata('success', 'Grupo cadastrado com sucesso.');
        redirect('processos');
    }

    function cadastrar(){
        if(empty($this->input->post("descricaoArquivo"))||empty($this->input->post("idGrupo"))){
            $this->session->set_flashdata('error', 'Descrição e/ou Grupo não preenchida.');
            redirect('processos');
        }
        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads/processos';

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

        if (!$this->upload->do_upload("arquivo")) {
            //$upload_error = $this->upload->display_errors();
            //print_r($upload_error);
            $this->session->set_flashdata('error', 'Error ao cadastrar o arquivo.');
            redirect('processos');
        } 
        $arquivo = $this->upload->data();
        $imagem = $arquivo['file_name'];
        $name = $arquivo['orig_name'];
        $caminho = 'assets/uploads/processos/';
        $tamanho = $arquivo['file_size'];
        $extensao = $arquivo['file_ext'];
        $data = array(
            'nomeArquivo' => $name,
            'descricaoArquivo' => $this->input->post('descricaoArquivo'),
            'idGrupoProcessos' => $this->input->post('idGrupo'),
            'versao' => $this->input->post('versao'),
            'imagem' => $imagem,
            'caminho' => $caminho,
            'tamanho' => $tamanho,
            'extensao' => $extensao,
            'idUsuario' => $this->session->userdata('idUsuarios'),
            'data_cadastro' => date('Y-m-d H:i:s')
        );
        $this->processos_model->add("anexo_processos", $data);
        $this->session->set_flashdata('success', 'Anexo cadastrado com sucesso.');
        redirect('processos');
    }
    function onoffanexos(){
        $idAnexo = $this->input->post("idAnexo");
        $ativo = $this->input->post("ativo");
        $this->processos_model->edit("anexo_processos",array("ativo"=>($ativo == 'true'?0:1)),"idAnexo",$idAnexo);
        echo json_encode(array("result"=>true));
    }

    function getAnexo(){
        $id = $this->input->post("idAnexo");
        $objAnexo = $this->processos_model->getAnexoByIdAnexo($id);
        echo json_encode(array("result"=>true,"obj"=>$objAnexo));
    }

    function editar(){
        $idAnexo = $this->input->post("idAnexo");
        $descricao = $this->input->post("descricao");
        $idGrupo = $this->input->post("grupo");
        $data = array(
            "descricaoArquivo"=>$descricao,
            "idGrupoProcessos"=>$idGrupo
        );
        $this->processos_model->edit("anexo_processos",$data,"idAnexo",$idAnexo);
        $this->session->set_flashdata('success', 'Item editado com sucesso.');
        redirect('processos');
    }

    function delete(){
        $idAnexo = $this->input->post("idAnexo");
        $this->processos_model->delete("anexo_processos","idAnexo",$idAnexo);
        $this->session->set_flashdata('success', 'Arquivo deletado com sucesso.');
        redirect('processos');
    }
}