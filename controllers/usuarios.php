<?php

class Usuarios extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')){
          $this->session->set_flashdata('error','Você não tem permissão para configurar os usuários.');
          redirect(base_url());
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('usuarios_model', '', TRUE);
        $this->data['menuUsuarios'] = 'Usuários';
        $this->data['menuConfiguracoes'] = 'Configurações';
        $this->load->library('encrypt');
    }

    function index(){
		$this->gerenciar();
	}

	function gerenciar(){
        
        $this->load->library('pagination');
        

        $config['base_url'] = base_url().'index.php/usuarios/gerenciar/';

        $filter = $this->input->post('filter');
        $field  = $this->input->post('field');
        $search = $this->input->post('search');

        if (!empty($field) && !empty($search)) {
          
            $this->data['results'] = $this->usuarios_model->getUsuarioWhereLike($field, $search);

            $config['total_rows'] = $this->usuarios_model->numrowsUsuarioWhereLike( $field, $search);
        $config['per_page'] = 100;
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
        }
        else
        {
            $config['total_rows'] = $this->usuarios_model->count('usuarios');
            $config['per_page'] = 100;
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
          
          	$this->data['results'] = $this->usuarios_model->get($config['per_page'],$this->uri->segment(3));
       
	       
        }
        $this->data['view'] = 'usuarios/usuarios';
        $this->load->view('tema/topo',$this->data);

		
    }
	
    function adicionar(){  
          
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('usuarios') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);

        } else
        {
	

            $this->load->library('encrypt');                       
            $data = array(
                    'nome' => set_value('nome'),
                    'user' => set_value('user'),
					'rg' => $this->input->post('rg'),
					'cpf' => $this->input->post('cpf'),
					'rua' => $this->input->post('rua'),
					'numero' => $this->input->post('numero'),
					'bairro' => $this->input->post('bairro'),
					'cidade' => $this->input->post('cidade'),
					'estado' => $this->input->post('estado'),
					'email' => $this->input->post('email'),
					'senha' => password_hash($this->input->post('senha'), PASSWORD_BCRYPT),
					'telefone' => $this->input->post('telefone'),
					'celular' => $this->input->post('celular'),
					'situacao' => $this->input->post('situacao'),
                    'permissoes_id' => $this->input->post('permissoes_id'),
                    'nivel' => $this->input->post('nivel'),
					'dataCadastro' => date('Y-m-d')
            );
			
             
            if( $this->usuarios_model->getByUser(set_value('user'),'') == true)
            {
                $this->session->set_flashdata('error','Nome de usuario já existe.');
               redirect(base_url()); 
            }

			if ($this->usuarios_model->add('usuarios',$data) == TRUE)
			{
                                $this->_auditLog('adicionar_usuario');
                                $this->session->set_flashdata('success','Usuário cadastrado com sucesso!');
				redirect(base_url().'index.php/usuarios/adicionar/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';

			}
		}
        
        $this->load->model('permissoes_model');
        $this->data['permissoes'] = $this->permissoes_model->getActive('permissoes','permissoes.idPermissao,permissoes.nome');   
		$this->data['view'] = 'usuarios/adicionarUsuario';
        $this->load->view('tema/topo',$this->data);
   
       
    }	
    
    function editar(){  
          
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|xss_clean');
        /*$this->form_validation->set_rules('rg', 'RG', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cpf', 'CPF', 'trim|required|xss_clean');
        $this->form_validation->set_rules('rua', 'Rua', 'trim|required|xss_clean');
        $this->form_validation->set_rules('numero', 'Número', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bairro', 'Bairro', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cidade', 'Cidade', 'trim|required|xss_clean');
        $this->form_validation->set_rules('estado', 'Estado', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');*/
        $this->form_validation->set_rules('situacao', 'Situação', 'trim|required|xss_clean');
        $this->form_validation->set_rules('permissoes_id', 'Permissão', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        { 

            if ($this->input->post('idUsuarios') == 1 && $this->input->post('situacao') == 0)
            {
                $this->session->set_flashdata('error','O usuário super admin não pode ser desativado!');
                redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('idUsuarios'));
            }

            $senha = $this->input->post('senha');
            if($senha != null){
                $senha = password_hash($senha, PASSWORD_BCRYPT);

                $data = array(
                        'nome' => $this->input->post('nome'),
                        'rg' => $this->input->post('rg'),
                        'cpf' => $this->input->post('cpf'),
                        'rua' => $this->input->post('rua'),
                        'numero' => $this->input->post('numero'),
                        'bairro' => $this->input->post('bairro'),
                        'cidade' => $this->input->post('cidade'),
                        'estado' => $this->input->post('estado'),
                        'email' => $this->input->post('email'),
                        'senha' => $senha,
                        'telefone' => $this->input->post('telefone'),
                        'celular' => $this->input->post('celular'),
                        'situacao' => $this->input->post('situacao'),
                        'permissoes_id' => $this->input->post('permissoes_id')
                );
            }  

            else{

                $data = array(
                        'nome' => $this->input->post('nome'),
                        'user' => $this->input->post('user'),
                        'rg' => $this->input->post('rg'),
                        'cpf' => $this->input->post('cpf'),
                        'rua' => $this->input->post('rua'),
                        'numero' => $this->input->post('numero'),
                        'bairro' => $this->input->post('bairro'),
                        'cidade' => $this->input->post('cidade'),
                        'estado' => $this->input->post('estado'),
                        'email' => $this->input->post('email'),
                        'telefone' => $this->input->post('telefone'),
                        'celular' => $this->input->post('celular'),
                        'situacao' => $this->input->post('situacao'),
                        'permissoes_id' => $this->input->post('permissoes_id')
                );

            }  

            if( $this->usuarios_model->getByUser($this->input->post('user'),$this->input->post('idUsuarios')) == true)
            {
                $this->session->set_flashdata('error','Nome de usuario já existe.');
               redirect(base_url()); 
            }
			if ($this->usuarios_model->edit('usuarios',$data,'idUsuarios',$this->input->post('idUsuarios')) == TRUE)
			{
                $this->_auditLog('editar_usuario', $this->input->post('idUsuarios'));
                $this->session->set_flashdata('success','Usuário editado com sucesso!');
				redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('idUsuarios'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';

			}
		}

		$this->data['result'] = $this->usuarios_model->getById($this->uri->segment(3));
        $this->load->model('permissoes_model');
        $this->data['permissoes'] = $this->permissoes_model->getActive('permissoes','permissoes.idPermissao,permissoes.nome'); 

		$this->data['view'] = 'usuarios/editarUsuario';
        $this->load->view('tema/topo',$this->data);
			
      
    }
	
    function excluir(){
            $ID = (int) $this->uri->segment(3);

            // Prevent deletion of super admin (ID=1) and self
            if ($ID <= 0 || $ID == 1 || $ID == (int)$this->session->userdata('idUsuarios')) {
                $this->session->set_flashdata('error', 'Este usuário não pode ser excluído.');
                redirect(base_url().'index.php/usuarios/gerenciar/');
            }

            $this->_auditLog('excluir_usuario', $ID);
            $this->usuarios_model->delete('usuarios','idUsuarios', $ID);
            redirect(base_url().'index.php/usuarios/gerenciar/');
    }

    private function _auditLog($acao, $recursoId = null) {
        $pasta = 'application/logs/';
        $arquivo = $pasta . 'audit_' . preg_replace('/[^0-9\-]/', '', date('Y-m')) . '.txt';
        $linha = sprintf(
            "\n[%s][usuario_id:%s][ip:%s][acao:%s][recurso_id:%s]",
            date('Y-m-d H:i:s'),
            $this->session->userdata('idUsuarios'),
            $this->input->ip_address(),
            $acao,
            $recursoId
        );
        $f = fopen($arquivo, 'a+b');
        fwrite($f, $linha);
        fclose($f);
    }
}

