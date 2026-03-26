<?php

class Maquinasusuarios extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('maquinasusuarios_model', '', TRUE);
        $this->data['menuMaquinasusuarios'] = 'Maquinas Usuarios';
    }
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vMaquinausuario')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Maquinas Usuarios.');
           redirect(base_url());
        }

        $this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/maquinasusuarios/gerenciar/';
        $config['total_rows'] = $this->maquinasusuarios_model->count('maquinasusuarios');
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

		$this->data['results'] = $this->maquinasusuarios_model->get('maquinasusuarios','idUserMaquinas,nome_UserMaquinas,descricao_UserMaquinas','',$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'maquinasusuarios/maquinasusuarios';
       	$this->load->view('tema/topo',$this->data);

       
		
    }
	
    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aMaquinausuario')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar usuario Maquinas.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('maquinasusuarios') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
           

            $data = array(
                'nome_UserMaquinas' => strtoupper(set_value('nome')),
                'descricao_UserMaquinas' => set_value('descricao')
               
            );

            if ($this->maquinasusuarios_model->add('maquinasusuarios', $data) == TRUE) {
                $this->session->set_flashdata('success', 'Usuario Maquina adicionado com sucesso!');
                redirect(base_url() . 'index.php/maquinasusuarios/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'maquinasusuarios/adicionarMaquinausuario';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eMaquinausuario')){
           $this->session->set_flashdata('error','Você não tem permissão para editar usuario maquinas.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('maquinasusuarios') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            $data = array(
                'nome_UserMaquinas' => strtoupper($this->input->post('nome')),
                'descricao_UserMaquinas' => $this->input->post('descricao')
                
            );

            if ($this->maquinasusuarios_model->edit('maquinasusuarios', $data, 'idUserMaquinas', $this->input->post('idUserMaquinas')) == TRUE) {
                $this->session->set_flashdata('success', 'Usuario Maquina editada com sucesso!');
                redirect(base_url() . 'index.php/maquinasusuarios/editar/'.$this->input->post('idUserMaquinas'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um errro.</p></div>';
            }
        }

        $this->data['result'] = $this->maquinasusuarios_model->getById($this->uri->segment(3));

        $this->data['view'] = 'maquinasusuarios/editarMaquinausuario';
        $this->load->view('tema/topo', $this->data);

    }
	
    function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dMaquinausuario')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir usuario de maquinas.');
           redirect(base_url());
        }
       
        
        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir usuario maquina.');            
            redirect(base_url().'index.php/maquinasusuarios/gerenciar/');
        }

        

        $this->maquinasusuarios_model->delete('maquinasusuarios','idUserMaquinas',$id);             
        

        $this->session->set_flashdata('success','Usuario Maquina excluido com sucesso!');            
        redirect(base_url().'index.php/maquinasusuarios/gerenciar/');
    }
}

