<?php

class fornecedores extends CI_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('fornecedores_model','',TRUE);
            $this->data['menuFornecedores'] = 'fornecedores';
	}	
	
	function index(){
       


		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vFornecedor')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar fornecedores.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
        
      
        
        $config['base_url'] = base_url().'index.php/fornecedores/gerenciar/';
       	
        
        $filter = $this->input->post('filter');
        $field  = $this->input->post('field');
        $search = $this->input->post('search');

        if (!empty($field) && !empty($search)) {
          
            $this->data['results'] = $this->fornecedores_model->getFornecedorWhereLike($field, $search);

            $config['total_rows'] = $this->fornecedores_model->numrowsFornecedorWhereLike( $field, $search);
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

           
       
           
        } else {
            $config['total_rows'] = $this->fornecedores_model->count('fornecedores');
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
          
            $this->data['results'] = $this->fornecedores_model->get('fornecedores','idFornecedores,nomeFornecedor,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep','',$config['per_page'],$this->uri->segment(3));
       
        }

	    //$this->data['results'] = $this->fornecedores_model->get('fornecedores','idFornecedors,nomeFornecedor,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep','',$config['per_page'],$this->uri->segment(3));
       
  
       	$this->data['view'] = 'fornecedores/fornecedores';
       	$this->load->view('tema/topo',$this->data);
	  
       
		
    }
    
    public static function pesquisar_cnpj() {
        $cnpj =  $_POST['documento'];
       
        header("Content-Type: text/plain");
        //Se tiver com o nive vazio então retorna false
        /*if (empty($cnpj)) {
            return false;
        }*/
       
       
		 $url = "https://www.receitaws.com.br/v1/cnpj/".$cnpj;
		 
	$ch = curl_init();
	
       
 $fields = array(
            
            'cnpj' => $cnpj
        );

		
       

	/*echo "<pre>";
	print_r($fields);
	echo "</pre>";
	echo $url."<br>";*/
	//$url = str_replace("//ws","/ws",$url);
		curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
	$result = curl_exec($ch);
	//echo "<pre>";
	//print_r($result);
	//echo "</pre>";
	//exit;
	//$xml= simplexml_load_string($result);
	
    //print_r($result);
    //exit;
    $retorno = json_decode($retorno); //Ajuda a ser lido mais rapidamente
echo $ret = json_encode($retorno, JSON_PRETTY_PRINT);

	return $ret;

	
      
		
    }

    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aFornecedor')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar fornecedores.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

       

       

        if ($this->form_validation->run('fornecedores') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'nomeFornecedor' => strtoupper(set_value('nomeFornecedor')),
                'documento' => set_value('documento'),
                'telefone' => $this->input->post('telefone'),
                'celular' => $this->input->post('celular'),
                'email' => $this->input->post('email'),
                'rua' =>  $this->input->post('rua'),
                'numero' =>  $this->input->post('numero'),
                'bairro' =>  $this->input->post('bairro'),
                'cidade' =>  $this->input->post('cidade'),
                
                'estado' =>  $this->input->post('estado'),
                'cep' =>  $this->input->post('cep'),
                'dataCadastro' => date('Y-m-d')
            );
            

            if( $this->fornecedores_model->getByDocumento(set_value('documento')) == true)
        {
            $this->session->set_flashdata('error','CNPJ ja possui cadastro.');
           redirect(base_url()); 
        }
		
			if (is_numeric($id = $this->fornecedores_model->add('fornecedores', $data, true)) ) {
        
                
                //$descricao = serialize($data);
                //$this->salvarlog($this->session->userdata('idUsuarios'),'fornecedores','inserir',$descricao );
                $this->session->set_flashdata('success','Fornecedor adicionado com sucesso!');
                redirect(base_url() . 'index.php/fornecedores/editar/'.$id);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'fornecedores/adicionarFornecedor';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eFornecedor')){
           $this->session->set_flashdata('error','Você não tem permissão para editar fornecedores.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('fornecedores') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'nomeFornecedor' => strtoupper($this->input->post('nomeFornecedor')),
                'documento' => $this->input->post('documento'),
                'telefone' => $this->input->post('telefone'),
                'celular' => $this->input->post('celular'),
                'email' => $this->input->post('email'),
                'rua' => $this->input->post('rua'),
                'numero' => $this->input->post('numero'),
                'bairro' => $this->input->post('bairro'),
                'cidade' => $this->input->post('cidade'),
                'estado' => $this->input->post('estado'),
                'dataAlteracao' => date('Y-m-d h:i:s'),
                'cep' => $this->input->post('cep')
            );

            if( $this->fornecedores_model->getByDocumento($this->input->post('documento'),$this->input->post('idFornecedores')) == true)
            {
                $this->session->set_flashdata('error','CNPJ ja possui cadastro.');
               redirect(base_url()); 
            }

            if ($this->fornecedores_model->edit('fornecedores', $data, 'idFornecedores', $this->input->post('idFornecedores')) == TRUE) {
               
                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'fornecedores','editar',$descricao );
               
               
                $this->session->set_flashdata('success','Fornecedor editado com sucesso!');
                redirect(base_url() . 'index.php/fornecedores/editar/'.$this->input->post('idFornecedores'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->fornecedores_model->getById($this->uri->segment(3));
        $this->data['view'] = 'fornecedores/editarFornecedor';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vFornecedor')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar fornecedores.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->fornecedores_model->getById($this->uri->segment(3));
       
        $this->data['view'] = 'fornecedores/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
   
	
    public function excluir(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dFornecedor')){
               $this->session->set_flashdata('error','Você não tem permissão para excluir fornecedores.');
               redirect(base_url());
            }

            $this->load->model('pedidocompra_model');
            $id =  $this->input->post('id');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir Fornecedor.');            
                redirect(base_url().'index.php/fornecedores/gerenciar/');
            }

			//se tiver pedido de compra nao excluir
             if( $this->pedidocompra_model->get('pedido_compras','pedido_compras.idFornecedores = '.$id) == true)
            {
                $this->session->set_flashdata('error','Fornecedor ja possui compra cadastrada');
               redirect(base_url()); 
            }
            

            //$id = 2;
            // excluindo OSs vinculadas ao Fornecedor
            $this->db->where('idFornecedores', $id);
       

       //salvar log da açao
            $this->data['result'] = $this->fornecedores_model->getById($id);
            $descricao = serialize($this->data['result'] );
                $this->salvarlog($this->session->userdata('idUsuarios'),'fornecedores','excluir',$descricao );

            $this->fornecedores_model->delete('fornecedores','idFornecedores',$id); 

            $this->session->set_flashdata('success','Fornecedor excluido com sucesso!');            
            redirect(base_url().'index.php/fornecedores/gerenciar/');
    }


    private function salvarlog($usuario,$table,$acao,$descricao){

        //colocar na funçao que vai enviar $this->salvarlog($usuario,$table,$acao,$descricao)

        $data = array(
            'ag_id_responsavel' => $usuario,
            'ag_tabela' => $table,
            'ag_acao_realizada' => $acao,
             'ag_descricao' => $descricao
        );

        $this->fornecedores_model->add('auditoria_geral', $data);
    }


    public function cadastrarFornecedor(){
        $data = array(
            'nomeFornecedor' => strtoupper($this->input->post('nomeFornecedor')),
            'documento' => $this->input->post('documento'),
            'telefone' => $this->input->post('telefone'),
            'celular' => $this->input->post('celular'),
            'email' => $this->input->post('email'),
            'rua' =>  $this->input->post('rua'),
            'numero' =>  $this->input->post('numero'),
            'bairro' =>  $this->input->post('bairro'),
            'cidade' =>  $this->input->post('cidade'),
            
            'estado' =>  $this->input->post('estado'),
            'cep' =>  $this->input->post('cep'),
            'dataCadastro' => date('Y-m-d')
        );
        if( $this->fornecedores_model->getByDocumento($this->input->post('documento')) == true)
        {
            echo json_encode(array("result"=>false,"msg"=>"CNPJ ja possui cadastro."));
            return;
        }
        if (is_numeric($id = $this->fornecedores_model->add('fornecedores', $data, true)) ) {
            echo json_encode(array("result"=>true,"msg"=>"Fornecedor adicionado com sucesso!","idFornecedor"=>$id));
            return;
        }
    }
}

