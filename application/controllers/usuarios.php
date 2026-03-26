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

            $config['total_rows'] = $this->usuarios_model->numrowsUsuarioWhereLike($field, $search);
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
        $this->load->model('orcamentos_model');
        $this->load->model('almoxarifado_model');
          
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
        $this->data['dados_departamento'] = $this->almoxarifado_model->getDepartamento();
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('usuarios') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : false);

        } else
        {
	

            // SEGURANÇA: usar bcrypt em vez de SHA1 para armazenar senhas
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
            $idUser = $this->usuarios_model->add2('usuarios',$data,true);
			if ( $idUser)
			{
                if($this->input->post('idempresa')){
                    foreach($this->input->post('idempresa') as $c){
                        $data = array("idEmpresa"=>$c,"idUsuario"=>$idUser);
                        $this->usuarios_model->add("usuario_empresa",$data);
                    }
                }
                if($this->input->post('iddepartamento')){
                    foreach($this->input->post('iddepartamento') as $c){
                        $data = array("idDepartamento"=>$c,"idUsuario"=>$idUser);
                        $this->usuarios_model->add("usuario_departamento",$data);
                    }
                }                
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
          
        $this->load->model('orcamentos_model');
        $this->load->model('almoxarifado_model');
        $this->data['dados_departamento'] = $this->almoxarifado_model->getDepartamento();
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
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
        $this->form_validation->set_rules('idempresa[]', 'Empresa', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false){
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else{ 

            if ($this->input->post('idUsuarios') == 1 && $this->input->post('situacao') == 0)
            {
                $this->session->set_flashdata('error','O usuário super admin não pode ser desativado!');
                redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('idUsuarios'));
            }

            $senha = $this->input->post('senha');
            if($senha != null){
                // SEGURANÇA: usar bcrypt em vez de SHA1
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
				$empresas = $this->usuarios_model->getEmpresasUserByIdUsuario($this->input->post('idUsuarios'));
                if($this->input->post('idempresa')){
                    foreach($this->input->post('idempresa') as $d){
                        $verificar = false;
                        foreach($empresas as $c){
                            if($d == $c->idEmpresa){
                                $verificar = true;
                            }
                        }
                        if(!$verificar){
                            $data = array("idEmpresa"=>$d,"idUsuario"=>$this->input->post('idUsuarios'));
                            $this->usuarios_model->add("usuario_empresa",$data);
                        }
                    }
                    $this->usuarios_model->deteleNotIn($this->input->post('idUsuarios'),implode(",",$this->input->post('idempresa')));
                }else{
                    $this->usuarios_model->deletaTodasEmpresasDoUsuario($this->input->post('idUsuarios'));
                }
                
                $getUserDepartaentos = $this->almoxarifado_model->getDepartamentoUsuario($this->input->post('idUsuarios'));
                if($this->input->post('iddepartamento')){
                    foreach($this->input->post('iddepartamento') as $d){
                        $verificar = false;
                        foreach($getUserDepartaentos as $c){
                            if($d == $c->idDepartamento){
                                $verificar = true;
                            }
                        }
                        if(!$verificar){
                            $data = array("idDepartamento"=>$d,"idUsuario"=>$this->input->post('idUsuarios'));
                            $this->usuarios_model->add("usuario_departamento",$data);
                        }
                    }
                    $this->usuarios_model->deteleNotIn2($this->input->post('idUsuarios'),implode(",",$this->input->post('iddepartamento')));
                }else{
                    $this->usuarios_model->deletaTodosDepartamentosDoUsuario($this->input->post('idUsuarios'));
                }
                
                
                
                $this->session->set_flashdata('success','Usuário editado com sucesso!');
				redirect(base_url().'index.php/usuarios/editar/'.$this->input->post('idUsuarios'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';

			}
		}

		$this->data['result'] = $this->usuarios_model->getById($this->uri->segment(3));
        $this->data['empresas_user'] = $this->usuarios_model->getEmpresasUserByIdUsuario($this->uri->segment(3));
        $this->data['departamento_user'] = $this->almoxarifado_model->getDepartamentoUsuario($this->uri->segment(3));
        $this->load->model('permissoes_model');
        $this->data['permissoes'] = $this->permissoes_model->getActive('permissoes','permissoes.idPermissao,permissoes.nome'); 

		$this->data['view'] = 'usuarios/editarUsuario';
        $this->load->view('tema/topo',$this->data);
			
      
    }
	
    function excluir(){
        $ID =  $this->uri->segment(3);
        $this->usuarios_model->delete('usuarios','idUsuarios',$ID);
        redirect(base_url().'index.php/usuarios/gerenciar/');
    }

    /**
     * Diagnóstico de segurança: lista usuários com hash SHA1 legado.
     * Acessível apenas por usuários com permissão cUsuario.
     * URL: /usuarios/diagnostico_senhas
     */
    function diagnostico_senhas(){
        // Verificar se é o superadmin (idUsuarios = 1)
        if ($this->session->userdata('id') != 1) {
            $this->session->set_flashdata('error', 'Acesso restrito ao administrador principal.');
            redirect(base_url());
        }

        // Buscar todos os usuários
        $query = $this->db->get('usuarios');
        $usuarios = $query->result();

        $sha1_count = 0;
        $bcrypt_count = 0;
        $sha1_users = [];

        foreach ($usuarios as $u) {
            $hash = $u->senha;
            // SHA1: 40 chars hex
            if (strlen($hash) === 40 && ctype_xdigit($hash)) {
                $sha1_count++;
                $sha1_users[] = ['id' => $u->idUsuarios, 'user' => $u->user, 'nome' => $u->nome, 'situacao' => $u->situacao];
            } else {
                $bcrypt_count++;
            }
        }

        $this->data['sha1_count']  = $sha1_count;
        $this->data['bcrypt_count'] = $bcrypt_count;
        $this->data['sha1_users']  = $sha1_users;
        $this->data['total']       = $sha1_count + $bcrypt_count;
        $this->data['view']        = 'usuarios/diagnostico_senhas';
        $this->load->view('tema/topo', $this->data);
    }

    /**
     * Força o reset de todas as senhas SHA1 legadas.
     * Gera senhas temporárias bcrypt e exibe na tela (copiar e enviar aos usuários).
     * Acessível apenas pelo superadmin.
     * URL: /usuarios/forcar_reset_senhas (POST com confirmação)
     */
    function forcar_reset_senhas(){
        if ($this->session->userdata('id') != 1) {
            $this->session->set_flashdata('error', 'Acesso restrito ao administrador principal.');
            redirect(base_url());
        }

        if ($this->input->post('confirmar') !== 'SIM_CONFIRMO') {
            $this->session->set_flashdata('error', 'Confirmação incorreta.');
            redirect(base_url() . 'index.php/usuarios/diagnostico_senhas');
        }

        $query = $this->db->get('usuarios');
        $usuarios = $query->result();
        $resetados = [];

        foreach ($usuarios as $u) {
            $hash = $u->senha;
            if (strlen($hash) === 40 && ctype_xdigit($hash)) {
                // Gerar senha temporária segura (12 chars)
                $senha_temp = substr(str_replace(['+', '/', '='], ['A', 'B', 'C'], base64_encode(random_bytes(9))), 0, 12);
                $novo_hash  = password_hash($senha_temp, PASSWORD_BCRYPT);

                $this->db->where('idUsuarios', (int)$u->idUsuarios);
                $this->db->update('usuarios', ['senha' => $novo_hash, 'senha_temp' => 1]);

                $resetados[] = [
                    'id'         => $u->idUsuarios,
                    'user'       => $u->user,
                    'nome'       => $u->nome,
                    'senha_temp' => $senha_temp,
                ];
            }
        }

        $this->data['resetados'] = $resetados;
        $this->data['view']      = 'usuarios/resultado_reset_senhas';
        $this->load->view('tema/topo', $this->data);
    }
}

