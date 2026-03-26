<?php

class Maquinas extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('maquinas_model', '', TRUE);
        $this->data['menuMaquinas'] = 'Maquinas';
    }
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vMaquina')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Maquinas.');
           redirect(base_url());
        }

        $this->load->library('pagination');
        
        
        $config['base_url'] = base_url().'index.php/maquinas/gerenciar/';
        $config['total_rows'] = $this->maquinas_model->count('maquinas');
        $config['per_page'] = $this->maquinas_model->count('maquinas');//100;
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

		$this->data['results'] = $this->maquinas_model->get('maquinas','idMaquinas,nome,descricao','',$config['per_page'],$this->uri->segment(3));
       
	    $this->data['view'] = 'maquinas/maquinas';
       	$this->load->view('tema/topo',$this->data);

       
		
    }
	
    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aMaquina')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar Maquinas.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('maquinas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
           

            $data = array(
                'nome' => strtoupper(set_value('nome')),
                'descricao' => set_value('descricao')
               
            );

            if ($this->maquinas_model->add('maquinas', $data) == TRUE) {
                $this->session->set_flashdata('success', 'Maquina adicionada com sucesso!');
                redirect(base_url() . 'index.php/maquinas/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'maquinas/adicionarMaquina';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eMaquina')){
           $this->session->set_flashdata('error','Você não tem permissão para editar maquinas.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('maquinas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            $data = array(
                'nome' => strtoupper($this->input->post('nome')),
                'descricao' => $this->input->post('descricao')
                
            );

            if ($this->maquinas_model->edit('maquinas', $data, 'idMaquinas', $this->input->post('idMaquinas')) == TRUE) {
                $this->session->set_flashdata('success', 'Maquina editada com sucesso!');
                redirect(base_url() . 'index.php/maquinas/editar/'.$this->input->post('idMaquinas'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um errro.</p></div>';
            }
        }

        $this->data['result'] = $this->maquinas_model->getById($this->uri->segment(3));

        $this->data['view'] = 'maquinas/editarMaquina';
        $this->load->view('tema/topo', $this->data);

    }
	
    function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dMaquina')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir maquinas.');
           redirect(base_url());
        }
       
        
        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir maquina.');            
            redirect(base_url().'index.php/maquinas/gerenciar/');
        }

        

        $this->maquinas_model->delete('maquinas','idMaquinas',$id);             
        

        $this->session->set_flashdata('success','Maquina excluida com sucesso!');            
        redirect(base_url().'index.php/maquinas/gerenciar/');
    }
}

