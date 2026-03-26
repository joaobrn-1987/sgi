<?php

class Insumos extends CI_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('insumos_model','',TRUE);
            $this->data['menuInsumos'] = 'insumos';
	}	
	
	function index(){
       


		$this->insumos();
	}

    public function insumos(){   
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vInsumo')){
             $this->session->set_flashdata('error','Você não tem permissão para visualizar insumo.');
             redirect(base_url());
          }
          $this->load->library('table');
          $this->load->library('pagination');
          
          
         
        
          
          $config['base_url'] = base_url().'index.php/insumos/insumos/';
             
          
          $filter = $this->input->post('filter');
           $field  = $this->input->post('field');
          $search = $this->input->post('search');
  
         
          if (!empty($field) && !empty($search)) {
            
            $this->data['dados'] = $this->insumos_model->getInsumosWhereLikeinsumo($field, $search);

            $config['total_rows'] = $this->insumos_model->numrowsWhereLikeinsumo( $field, $search);
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
 
              $config['total_rows'] = $this->insumos_model->count('insumos');  
             
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
            
              $this->data['dados'] = $this->insumos_model->getinsumosubcat('insumos','idInsumos,insumos.idSubcategoria,descricaoInsumo,subcategoriaInsumo.idCategoria,descricaoCategoria,descricaoSubcategoria','',$config['per_page'],$this->uri->segment(3));
              
          }
        
         
 
         $this->data['view'] = 'insumos/insumos';
         $this->data['dsubcat'] = $this->insumos_model->getSubCategoria();
         $this->load->view('tema/topo',$this->data);
         $this->load->view('tema/rodape');
     }
    

	
    
    

    public function cadastrarInsumo() {
        

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aInsumo')){
           $this->session->set_flashdata('error','Você não tem permissão para cadastrar insumo.');
           redirect(base_url().'index.php/insumos/insumos');
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('descricaoInsumo','Insumo','required|xss_clean|trim');
           
        $this->form_validation->set_rules('idSubcategoria','Categoria e Subcategoria','required|xss_clean|trim'); 

        

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/insumos/insumos');
            
        } 
        else {
            $data = array(
                'idSubcategoria' => $this->input->post('idSubcategoria'),
                'descricaoInsumo' => $this->input->post('descricaoInsumo')
            );

           
            if( $this->insumos_model->getBydescricaoInsumo($this->input->post('descricaoInsumo'),$this->input->post('idSubcategoria')) == true)
            {
                $this->session->set_flashdata('error','Insumo ja possui cadastro.');
                redirect(base_url().'index.php/insumos/insumos');
            }

            
           
                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumos','inserir',$descricao );

            $retorno = $this->insumos_model->add('insumos',$data);
            if($retorno){

                $this->session->set_flashdata('success','As informações foram inseridas com sucesso.');
                redirect(base_url().'index.php/insumos/insumos');
            }
            else{
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar inserir as informações.');
                redirect(base_url().'index.php/insumos/insumos');
            }
            
        }
    }
   
    public function editarinsumos() {
        

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eInsumo')){
           $this->session->set_flashdata('error','Você não tem permissão para editar insumo.');
           redirect(base_url().'index.php/insumos/insumos');
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('descricaoInsumo','Insumo','required|xss_clean|trim');
           
        $this->form_validation->set_rules('idSubcategoria','Categoria e Subcategoria','required|xss_clean|trim'); 

        

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/insumos/insumos');
            
        } 
        else {
            $data = array(
                'idSubcategoria' => $this->input->post('idSubcategoria'),
                'descricaoInsumo' => $this->input->post('descricaoInsumo')
            );

           
            if( $this->insumos_model->getBydescricaoInsumo($this->input->post('descricaoInsumo'),$this->input->post('idSubcategoria')) == true)
            {
                $this->session->set_flashdata('error','Insumo ja possui cadastro.');
                redirect(base_url().'index.php/insumos/insumos');
            }

            
           
           
            if ($this->insumos_model->edit('insumos', $data, 'idInsumos', $this->input->post('idInsumos')) == TRUE) {
               
                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumo','editar',$descricao );
               
               
                $this->session->set_flashdata('success','Insumo editado com sucesso!');
                redirect(base_url() . 'index.php/insumos/insumos');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
            
        }
    }
    public function excluirinsumo(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dInsumo')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir insumo.');
           redirect(base_url().'index.php/insumos/insumo');
        }

        
        $id =  $this->input->post('idcat');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir insumo.');            
            redirect(base_url().'index.php/insumos/insumos/');
        }

         //se tiver cadastro no item de produçao nao deixar excluir
        /*if( $this->insumos_model->getBysubinsumos($id) == true)
        {
            $this->session->set_flashdata('error','Insumo possui registro de compra.');
            redirect(base_url().'index.php/insumos/insumos/');
        }*/
        
        //$id = 2;
        // excluindo OSs vinculadas ao cliente
        $this->db->where('idInsumos', $id);
   

   //salvar log da açao
        $this->data['result'] = $this->insumos_model->getByidInsumos($id);
        $descricao = serialize($this->data['result'] );
            $this->salvarlog($this->session->userdata('idUsuarios'),'insumos','excluir',$descricao );

        $this->insumos_model->delete('insumos','idInsumos',$id); 

        $this->session->set_flashdata('success','Insumo excluido com sucesso!');            
        redirect(base_url().'index.php/insumos/insumos/');
}

    
	
   
    //categoria
    public function categoria(){   
         if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCategoria')){
             $this->session->set_flashdata('error','Você não tem permissão para visualizar categoria.');
             redirect(base_url());
          }
          $this->load->library('table');
          $this->load->library('pagination');
          
          
        
          
          $config['base_url'] = base_url().'index.php/insumos/categoria/';
             
          
          $filter = $this->input->post('filter');
           $field  = $this->input->post('field');
          $search = $this->input->post('search');
  
         
          if (!empty($field) && !empty($search)) {
            
             $data['dados'] = $this->insumos_model->getInsumosWhereLikecat($field, $search);
  
              $config['total_rows'] = $this->insumos_model->numrowsClienteWhereLikecat( $field, $search);
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
 
 
              $config['total_rows'] = $this->insumos_model->count('categoriaInsumos');
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
            
              $data['dados'] = $this->insumos_model->getcat('categoriaInsumos','idCategoria,descricaoCategoria','',$config['per_page'],$this->uri->segment(3));
         
          }
  
          //$this->data['results'] = $this->insumos_model->get('insumos','idInsumos,nomeInsumo,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep','',$config['per_page'],$this->uri->segment(3));
         
             // $data['menuInsumos'] = 'Insumos';
             $data['view'] = 'insumos/categoria';
         $this->load->view('tema/topo',$data);
         $this->load->view('tema/rodape');
        
 
       
         //$data['dados'] = $this->mapos_model->getEmitente();
        //$data['dados'] = $this->insumos_model->getCategoria();
         //$data['view'] = 'insumos/categoria';
        // $this->load->view('tema/topo',$data);
         //$this->load->view('tema/rodape');
     }
     public function verificaCategoria(){
         
         if (isset($_GET['categoria'])){
             $q = strtolower($_GET['categoria']);
             $this->insumos_model->verificaCategoria($q);
         }
 
     }
 
    function editarcat() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCategoria')){
           $this->session->set_flashdata('error','Você não tem permissão para editar categoria.');
           redirect(base_url() . 'index.php/insumos/categoria');
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('categoriaInsumos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = array(
                'descricaoCategoria' => set_value('descricaoCategoria')
                
            );

            if( $this->insumos_model->getBydescricaoCategoria($this->input->post('descricaoCategoria')) == true)
            {
                $this->session->set_flashdata('error','Categoria ja possui cadastro.');
                redirect(base_url() . 'index.php/insumos/categoria');
            }

            if ($this->insumos_model->edit('categoriaInsumos', $data, 'idCategoria', $this->input->post('idCategoria')) == TRUE) {
               
                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'categoria','editar',$descricao );
               
               
                $this->session->set_flashdata('success','Categoria editada com sucesso!');
                redirect(base_url() . 'index.php/insumos/categoria');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->insumos_model->getById($this->uri->segment(3));
        $this->data['view'] = 'insumos/categoria';
        $this->load->view('tema/topo', $this->data);

    }
    public function excluircat(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dCategoria')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir categoria.');
           redirect(base_url().'index.php/insumos/categoria');
        }

        
        $id =  $this->input->post('idcat');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir categoria.');            
            redirect(base_url().'index.php/insumos/categoria/');
        }

         //se tiver subcategoria nao deixar excluir
        if( $this->insumos_model->getByCat_sub($id) == true)
        {
            $this->session->set_flashdata('error','Categoria possui subcategoria cadastrada.');
            redirect(base_url().'index.php/insumos/categoria/');
        }
        
        //$id = 2;
        // excluindo OSs vinculadas ao cliente
        $this->db->where('idCategoria', $id);
   

   //salvar log da açao
        $this->data['result'] = $this->insumos_model->getByIdCat($id);
        $descricao = serialize($this->data['result'] );
            $this->salvarlog($this->session->userdata('idUsuarios'),'categoria','excluir',$descricao );

        $this->insumos_model->delete('categoriaInsumos','idCategoria',$id); 

        $this->session->set_flashdata('success','Categoria excluido com sucesso!');            
        redirect(base_url().'index.php/insumos/categoria/');
}

    

    public function cadastrarCategoria() {
        

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCategoria')){
           $this->session->set_flashdata('error','Você não tem permissão para cadastrar categoria.');
           redirect(base_url().'index.php/insumos/categoria');
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('descricaoCategoria','Descrição','required|xss_clean|trim');
        


        

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/insumos/categoria');
            
        } 
        else {
            $data = array(
                'descricaoCategoria' => $this->input->post('descricaoCategoria')
            );

           
            if( $this->insumos_model->getBydescricaoCategoria($this->input->post('descricaoCategoria')) == true)
            {
                $this->session->set_flashdata('error','Esse nome de Categoria ja possui cadastro.');
                redirect(base_url().'index.php/insumos/categoria');
            }

            
           
                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'categoria','inserir',$descricao );

            $retorno = $this->insumos_model->add('categoriaInsumos',$data);
            if($retorno){

                $this->session->set_flashdata('success','As informações foram inseridas com sucesso.');
                redirect(base_url().'index.php/insumos/categoria');
            }
            else{
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar inserir as informações.');
                redirect(base_url().'index.php/insumos/categoria');
            }
            
        }
    }
    //subcategoria
    
    public function subcategoria(){   
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vSubcategoria')){
             $this->session->set_flashdata('error','Você não tem permissão para visualizar subcategoria.');
             redirect(base_url());
          }
          $this->load->library('table');
          $this->load->library('pagination');
          
          
        
          
          $config['base_url'] = base_url().'index.php/insumos/subcategoria/';
             
          
          $filter = $this->input->post('filter');
           $field  = $this->input->post('field');
          $search = $this->input->post('search');
  
         
          if (!empty($field) && !empty($search)) {
            
             $data['dados'] = $this->insumos_model->getInsumosWhereLikesubcat($field, $search);
  
              $config['total_rows'] = $this->insumos_model->numrowsWhereLikesubcat( $field, $search);
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
 
 
              $config['total_rows'] = $this->insumos_model->count('subcategoriaInsumo');
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
            
              $data['dados'] = $this->insumos_model->getsubcat('subcategoriaInsumo','idSubcategoria,subcategoriaInsumo.idCategoria,descricaoSubcategoria,descricaoCategoria','',$config['per_page'],$this->uri->segment(3));
         
          }
          //$data['dados_cat'] = $this->insumos_model->getcat('categoriaInsumos','idCategoria,descricaoCategoria');
         $data['dados_cat'] = $this->insumos_model->getCategoria();
         
         

          //$this->data['results'] = $this->insumos_model->get('insumos','idInsumos,nomeInsumo,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep','',$config['per_page'],$this->uri->segment(3));
         
             // $data['menuInsumos'] = 'Insumos';
             $data['view'] = 'insumos/subcategoria';
         $this->load->view('tema/topo',$data);
         $this->load->view('tema/rodape');
        
 
       
         //$data['dados'] = $this->mapos_model->getEmitente();
        //$data['dados'] = $this->insumos_model->getCategoria();
         //$data['view'] = 'insumos/categoria';
        // $this->load->view('tema/topo',$data);
         //$this->load->view('tema/rodape');
     }
    
 
    function editarsubcat() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eSubcategoria')){
           $this->session->set_flashdata('error','Você não tem permissão para editar Subcategoria.');
           redirect(base_url() . 'index.php/insumos/subcategoria');
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('descricaoSubcategoria','Subcategoria','required|xss_clean|trim');
        $this->form_validation->set_rules('idCategoria','Categoria','required|xss_clean|trim');    


        exit;

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/insumos/subcategoria');
            
        } 
        else {
            $data = array(
                'idCategoria' => $this->input->post('idCategoria'),
                'descricaoSubcategoria' => $this->input->post('descricaoSubcategoria')
            );

           
            if( $this->insumos_model->getBydescricaoSubCategoria($this->input->post('descricaoSubcategoria')) == true)
            {
                $this->session->set_flashdata('error','Esse nome de SubCategoria ja possui cadastro.');
                redirect(base_url().'index.php/insumos/subcategoria');
            }

            

            if ($this->insumos_model->edit('subcategoriaInsumo', $data, 'idSubcategoria', $this->input->post('idSubcategoria')) == TRUE) {
               
                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'subcategoria','editar',$descricao );
               
               
                $this->session->set_flashdata('success','SubCategoria editada com sucesso!');
                redirect(base_url() . 'index.php/insumos/subcategoria');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }


        $this->data['result'] = $this->insumos_model->getById($this->uri->segment(3));
        $this->data['view'] = 'insumos/subcategoria';
        $this->load->view('tema/topo', $this->data);

    }
    public function excluirsubcat(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dSubcategoria')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir subcategoria.');
           redirect(base_url().'index.php/insumos/subcategoria');
        }

        
        $id =  $this->input->post('idcat');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir subcategoria.');            
            redirect(base_url().'index.php/insumos/subcategoria/');
        }

         //se tiver subcategoria nao deixar excluir
        if( $this->insumos_model->getBysubinsumos($id) == true)
        {
            $this->session->set_flashdata('error','SubCategoria possui insumo cadastrado.');
            redirect(base_url().'index.php/insumos/subcategoria/');
        }
        
        //$id = 2;
        // excluindo OSs vinculadas ao cliente
        $this->db->where('idSubcategoria', $id);
   

   //salvar log da açao
        $this->data['result'] = $this->insumos_model->getByIdSubCat($id);
        $descricao = serialize($this->data['result'] );
            $this->salvarlog($this->session->userdata('idUsuarios'),'subcategoria','excluir',$descricao );

        $this->insumos_model->delete('subcategoriaInsumo','idSubcategoria',$id); 

        $this->session->set_flashdata('success','SubCategoria excluido com sucesso!');            
        redirect(base_url().'index.php/insumos/subcategoria/');
}

    

    public function cadastrarSubCategoria() {
        

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aSubcategoria')){
           $this->session->set_flashdata('error','Você não tem permissão para cadastrar subcategoria.');
           redirect(base_url().'index.php/insumos/subcategoria');
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('descricaoSubcategoria','Descrição','required|xss_clean|trim');
        $this->form_validation->set_rules('idCategoria','Categoria','required|xss_clean|trim');    


        

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/insumos/subcategoria');
            
        } 
        else {
            $data = array(
                'idCategoria' => $this->input->post('idCategoria'),
                'descricaoSubcategoria' => $this->input->post('descricaoSubcategoria')
            );

           
            if( $this->insumos_model->getBydescricaoSubCategoria($this->input->post('descricaoSubcategoria')) == true)
            {
                $this->session->set_flashdata('error','Esse nome de SubCategoria ja possui cadastro.');
                redirect(base_url().'index.php/insumos/subcategoria');
            }

            
           
                $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'subcategoria','inserir',$descricao );

            $retorno = $this->insumos_model->add('subcategoriaInsumo',$data);
            if($retorno){

                $this->session->set_flashdata('success','As informações foram inseridas com sucesso.');
                redirect(base_url().'index.php/insumos/subcategoria');
            }
            else{
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar inserir as informações.');
                redirect(base_url().'index.php/insumos/subcategoria');
            }
            
        }
    }
   
    private function salvarlog($usuario,$table,$acao,$descricao){

        //colocar na funçao que vai enviar $this->salvarlog($usuario,$table,$acao,$descricao)

        $data = array(
            'ag_id_responsavel' => $usuario,
            'ag_tabela' => $table,
            'ag_acao_realizada' => $acao,
             'ag_descricao' => $descricao
        );

        $this->insumos_model->add('auditoria_geral', $data);
    }
}

