<?php

class Clientes extends CI_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('clientes_model','',TRUE);
            $this->data['menuClientes'] = 'clientes';
	}	
	
	function index(){
       


		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        
        
      
        
        $config['base_url'] = base_url().'index.php/clientes/gerenciar/';
       	
        
        $filter = $this->input->post('filter');
        $field  = $this->input->post('field');
        $search = $this->input->post('search');

        if (!empty($field) && !empty($search)) {
          
            $this->data['results'] = $this->clientes_model->getClienteWhereLike($field, $search);

            $config['total_rows'] = $this->clientes_model->numrowsClienteWhereLike( $field, $search);
            $config['per_page'] = 200;
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
            $config['total_rows'] = $this->clientes_model->count('clientes');
            $config['per_page'] = 200;
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
          
            $this->data['results'] = $this->clientes_model->get('clientes','idClientes,nomeCliente,documento,telefone,celular,email,email2,rua,numero,bairro,cidade,estado,cep,dataCadastro','',$config['per_page'],$this->uri->segment(3));
       
        }

	    //$this->data['results'] = $this->clientes_model->get('clientes','idClientes,nomeCliente,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep','',$config['per_page'],$this->uri->segment(3));
       
  
       	$this->data['view'] = 'clientes/clientes';
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
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar clientes.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

       

       

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'nomeCliente' => strtoupper(set_value('nomeCliente')),
                'documento' => set_value('documento'),
                'ie' => set_value('ie'),
                'telefone' => $this->input->post('telefone'),
                'celular' => $this->input->post('celular'),
                'email' => strtoupper($this->input->post('email')),
                'rua' =>  strtoupper($this->input->post('rua')),
                'numero' =>  $this->input->post('numero'),
                'bairro' =>  strtoupper($this->input->post('bairro')),
                'cidade' =>  strtoupper($this->input->post('cidade')),
                'dataCadastro' =>  date('Y-m-d'),
                
                'estado' =>  $this->input->post('estado'),
                'cep' =>  $this->input->post('cep'),
                'dataCadastro' => date('Y-m-d')
            );
            

            if( $this->clientes_model->getByDocumento(set_value('documento')) == true)
            {
                $this->session->set_flashdata('error','CNPJ ja possui cadastro.');
            redirect(base_url()); 
            }
			if (is_numeric($id = $this->clientes_model->add('clientes', $data, true)) ) {
       
                echo("<script>console.log('foi');</script>");
                $response = json_decode($this->simplexCadastroCliente(strtoupper(set_value('nomeCliente')))); 
                if($response->status == "success"){
                    echo("<script>console.log('sucesso');</script>");
                    $data2 = array("idSimplexCliente"=>$response->response->id);
                    $this->clientes_model->edit('clientes', $data2, 'idClientes', $id);
                }else{
                    echo("<script>console.log('falha');</script>");
                }
                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'clientes','inserir',$descricao );
                $this->session->set_flashdata('success','Cliente adicionado com sucesso!');
                redirect(base_url() . 'index.php/clientes/editar/'.$id);                
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'clientes/adicionarCliente';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para editar clientes.');
           redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'nomeCliente' => strtoupper($this->input->post('nomeCliente')),
                'documento' => $this->input->post('documento'),
                'ie' => $this->input->post('ie'),
                'telefone' => $this->input->post('telefone'),
                'celular' => $this->input->post('celular'),
                'email' => strtoupper($this->input->post('email')),
                'rua' => strtoupper($this->input->post('rua')),
                'numero' => $this->input->post('numero'),
                'bairro' => strtoupper($this->input->post('bairro')),
                'cidade' => strtoupper($this->input->post('cidade')),
                'estado' => $this->input->post('estado'),
                'dataAlteracao' => date('Y-m-d h:i:s'),
                'cep' => $this->input->post('cep')
            );

            if( $this->clientes_model->getByDocumento($this->input->post('documento'),$this->input->post('idClientes')) == true)
            {
                $this->session->set_flashdata('error','CNPJ ja possui cadastro.');
               redirect(base_url()); 
            }

            if ($this->clientes_model->edit('clientes', $data, 'idClientes', $this->input->post('idClientes')) == TRUE) {
               
                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'clientes','editar',$descricao );
               
               
                $this->session->set_flashdata('success','Cliente editado com sucesso!');
                redirect(base_url() . 'index.php/clientes/editar/'.$this->input->post('idClientes'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['view'] = 'clientes/editarCliente';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar clientes.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
       
        $this->data['view'] = 'clientes/visualizar';
        $this->load->view('tema/topo', $this->data);

        
    }
   
	
    public function excluir(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dCliente')){
               $this->session->set_flashdata('error','Você não tem permissão para excluir clientes.');
               redirect(base_url());
            }
            $this->load->model('orcamentos_model');
            
            $id =  $this->input->post('id');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir cliente.');            
                redirect(base_url().'index.php/clientes/gerenciar/');
            }

 
 
             //se tiver orcamento nao d eixar excluir
            if( $this->orcamentos_model->getorc('orcamento','*','clientes.idClientes = '.$id) == true)
            {
                $this->session->set_flashdata('error','Cliente ja possui orçamento');
               redirect(base_url()); 
            }
            
            //$id = 2;
            // excluindo OSs vinculadas ao cliente
            $this->db->where('idClientes', $id);
       

            //salvar log da açao
            $this->data['result'] = $this->clientes_model->getById($id);
            $descricao = serialize($this->data['result'] );
                $this->salvarlog($this->session->userdata('idUsuarios'),'clientes','excluir',$descricao );

            $this->clientes_model->delete('clientes','idClientes',$id); 

            $this->session->set_flashdata('success','Cliente excluido com sucesso!');            
            redirect(base_url().'index.php/clientes/gerenciar/');
    }


    private function salvarlog($usuario,$table,$acao,$descricao){

        //colocar na funçao que vai enviar $this->salvarlog($usuario,$table,$acao,$descricao)

        $data = array(
            'ag_id_responsavel' => $usuario,
            'ag_tabela' => $table,
            'ag_acao_realizada' => $acao,
             'ag_descricao' => $descricao
        );

        $this->clientes_model->add('auditoria_geral', $data);
    }
	
	
	//solicitante cadastrar editar e excluir
	public function solicitantes(){   
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
             $this->session->set_flashdata('error','Você não tem permissão para visualizar solicitante.');
             redirect(base_url());
          }
          $this->load->library('table');
          $this->load->library('pagination');
          
          
        
          
          $config['base_url'] = base_url().'index.php/clientes/solicitantes/';
             
          
          $filter = $this->input->post('filter');
           $field  = $this->input->post('field');
          $search = $this->input->post('search');
  
         
          if (!empty($field) && !empty($search)) {
            
             $data['dados'] = $this->clientes_model->getSolicitanteWhereLike($field, $search);
  
              $config['total_rows'] = $this->clientes_model->numrowsSolicWhereLike( $field, $search);
              $config['per_page'] = 200;
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
 
 
              $config['total_rows'] = $this->clientes_model->count('clientes_solicitantes');
              $config['per_page'] = 200;
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
            
              $data['dados'] = $this->clientes_model->getsolicitante('clientes_solicitantes','*','',$config['per_page'],$this->uri->segment(3));
         
          }
          //$data['dados_cat'] = $this->insumos_model->getcat('categoriaInsumos','idCategoria,descricaoCategoria');
         $data['dados_cliente'] = $this->clientes_model->getCliente();
         
         

          //$this->data['results'] = $this->insumos_model->get('insumos','idInsumos,nomeInsumo,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep','',$config['per_page'],$this->uri->segment(3));
         
             // $data['menuInsumos'] = 'Insumos';
             $data['view'] = 'clientes/solicitantes';
         $this->load->view('tema/topo',$data);
         $this->load->view('tema/rodape');
        
 
       
         //$data['dados'] = $this->mapos_model->getEmitente();
        //$data['dados'] = $this->insumos_model->getCategoria();
         //$data['view'] = 'insumos/categoria';
        // $this->load->view('tema/topo',$data);
         //$this->load->view('tema/rodape');
     }
    
 
    function editarsolicitante() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para editar solicitante.');
           redirect(base_url() . 'index.php/clientes/solicitantes');
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

       $this->form_validation->set_rules('nome','Solicitante','required|xss_clean|trim');
        $this->form_validation->set_rules('email_solici','Email Solicitante','required|xss_clean|trim');
        $this->form_validation->set_rules('idClientes','Clientes','required|xss_clean|trim');    

      

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/clientes/solicitantes');
            
        } 
        else {
            $data = array(
                'nome' => strtoupper($this->input->post('nome')),
                'idClientes' => $this->input->post('idClientes'),
                'idSolicitante' => $this->input->post('idSolicitante'),
                'email_solici' => strtoupper($this->input->post('email_solici'))
            );

           
            if( $this->clientes_model->getBysolici_cliente($this->input->post('email_solici'),$this->input->post('idClientes'),$this->input->post('idSolicitante')) == true)
            {
                $this->session->set_flashdata('error','Esse email e cliente ja possui cadastro.');
                redirect(base_url().'index.php/clientes/solicitantes');
            }

            

            if ($this->clientes_model->edit('clientes_solicitantes', $data, 'idSolicitante', $this->input->post('idSolicitante')) == TRUE) {
               
                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'clientes_solicitantes','editar',$descricao );
               
               
                $this->session->set_flashdata('success','Solicitante editado com sucesso!');
                redirect(base_url() . 'index.php/clientes/solicitantes');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['view'] = 'clientes/solicitantes';
        $this->load->view('tema/topo', $this->data);

    }
    public function excluirsolicitante(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir solicitante.');
           redirect(base_url().'index.php/clientes/solicitantes');
        }

        $this->load->model('orcamentos_model');
		
        $id =  $this->input->post('idcat');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir solcitante.');            
            redirect(base_url().'index.php/clientes/solicitantes/');
        }

         
             //se tiver orcamento nao d eixar excluir
            if( $this->orcamentos_model->getorc('orcamento','*','clientes_solicitantes.idSolicitante = '.$id) == true)
            {
                $this->session->set_flashdata('error','Solicitante ja possui orçamento');
               redirect(base_url()); 
            }
      
   

   //salvar log da açao
        $this->data['result'] = $this->clientes_model->getByIdsolici($id);
        $descricao = serialize($this->data['result'] );
            $this->salvarlog($this->session->userdata('idUsuarios'),'clientes_solicitantes','excluir',$descricao );

        $this->clientes_model->delete('clientes_solicitantes','idSolicitante',$id); 

        $this->session->set_flashdata('success','Solicitante excluido com sucesso!');            
        redirect(base_url().'index.php/clientes/solicitantes/');
}

    
	
	
	
	 public function cadastrarSolicitante() {
        

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para cadastrar solicitante.');
           redirect(base_url().'index.php/clientes/solicitantes');
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nome','Solicitante','required|xss_clean|trim');
        $this->form_validation->set_rules('email_solici','Email Solicitante','required|xss_clean|trim');
        $this->form_validation->set_rules('idClientes','Clientes','required|xss_clean|trim');    

        if(!empty($this->input->post('orcament')))
        {
            $mudar = '1';
        }
        else{
            $mudar = '';
        }
        

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/clientes/solicitantes');
            
        } 
        else {
            $data = array(
                'nome' => strtoupper($this->input->post('nome')),
                'idClientes' => $this->input->post('idClientes'),
                'email_solici' => strtoupper($this->input->post('email_solici'))
            );

           
            if( $this->clientes_model->getBysolici_cliente($this->input->post('email_solici'),$this->input->post('idClientes')) == true)
            {
                $this->session->set_flashdata('error','Esse email e cliente ja possui cadastro.');
				if(!empty($this->input->post('orcament')))
				{
					redirect(base_url().'index.php/orcamentos/adicionar');
				}
				else
				{
					 redirect(base_url().'index.php/clientes/solicitantes');
				}
            }

            
           
                //$descricao = serialize($data);
                //$this->salvarlog($this->session->userdata('idUsuarios'),'clientes_solicitantes','inserir',$descricao );

            $retorno = $this->clientes_model->add('clientes_solicitantes',$data);
            if($retorno){

                $this->session->set_flashdata('success','Solicitante inserido com sucesso.');
                if(!empty($this->input->post('orcament')))
				{
					redirect(base_url().'index.php/orcamentos/adicionar');
				}
				else
				{
					 redirect(base_url().'index.php/clientes/solicitantes');
				}
            }
            else{
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar inserir as informações.');
                if(!empty($this->input->post('orcament')))
				{
					redirect(base_url().'index.php/orcamentos/adicionar');
				}
				else
				{
					 redirect(base_url().'index.php/clientes/solicitantes');
				}
            }
            
        }
    }

    // API SIMPLEX

    public function simplexCadastroCliente($nomeCliente){
        
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL,$this->config->item('urlSimplex').'/post_cadastro_fornecedores');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS,'{
            "local_producao": "1643030732052x547164845382303740",
            "empresa": "1643030479504x771112863746752500",
            "deletado":"no",
            "cnpj_cpf": "'.$this->input->post('documento').'",
            "contato": "",
            "email": "",
            "endereco": "'.$this->input->post('cep').'",
            "fornecedor_cliente": "'.$nomeCliente.' (TESTE)",
            "inscricao_estadual": ""}'
            );
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$this->config->item('tokenSimplex')
        ));
        
        $response = curl_exec($curl);
        echo("<script>console.log('".$this->config->item('urlSimplex')."');</script>");
        $err_status = curl_error($curl);
        echo("<script>console.log('".$response."');</script>");
        //echo("<script>console.log('".$err_status."');</script>");

        curl_close($curl);
        //echo $response;
        return $response;
        
    }
	
}

