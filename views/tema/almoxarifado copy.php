<?php

class AlmoxarifadoCextends CI_Controller {
    
    function __construct() {
        parent::__construct();
                if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
                    redirect('mapos/login');
                }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('almoxarifado_model','',TRUE);
		$this->data['menuAlmoxarifado'] = 'Almoxarifado';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vAlmoxarifado')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Cotacao.');
           redirect(base_url());
        }
         $this->load->library('table');
         $this->load->library('pagination');
         
         $this->load->model('os_model');
		$this->load->model('orcamentos_model');		 
		$this->load->model('cotacao_model');		 
         
         $config['base_url'] = base_url().'index.php/almoxarifado/gerenciar/';
         
$this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
$this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
	$this->data['dados_statusgrupo'] = $this->os_model->getstatus_grupo('');	 
        //se é almoxarifado ou nao
		/*if(!empty($this->uri->segment(4)))
		 {
			 //almoxarifado
			 $tipo = 1;
			 $osdisponivel =  "";
		 }
		 else
		 {
			 //normal
			 $tipo = 2;
			 $osdisponivel =  "";
		 }*/
		
         $idOs = $this->input->post('idOs');
		 if(!empty($this->uri->segment(3)))
		 {
			  $idPedidoCotacao = $this->uri->segment(3);
		 }
		 else
		 {
			  $idPedidoCotacao = $this->input->post('idPedidoCotacao');
		 }
        
        
          $idStatuscompras = $this->input->post('idStatuscompras');
		
		
		
		
         
		
		 if (!empty($idOs) || !empty($idPedidoCotacao)   || !empty($idStatuscompras) ) {
           
         $this->data['results'] = $this->almoxarifado_model->getWhereLikeos($idOs, $idPedidoCotacao,$idStatuscompras);
 
             $config['total_rows'] = $this->almoxarifado_model->numrowsWhereLikeos($idOs, $idPedidoCotacao,$idStatuscompras);
             $config['per_page'] = 200000;
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


            //$config['total_rows'] = $this->cotacao_model->count('distribuir_os');
            $config['total_rows'] = count($this->almoxarifado_model->getdistribuidorcount('distribuir_os','*','distribuir_os.solicitacao = 2'));
             $config['per_page'] = 200000;
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
         //distribuir_os.idOs not in(10,11,12) nao é pra vir os de almoxarifado  
         $this->data['results'] = $this->almoxarifado_model->getdistribuidor('distribuir_os','*','distribuir_os.solicitacao = 2',$config['per_page'],$this->uri->segment(3));
         
         }
        
 
        
       /* $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
         $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
         $this->data['dados_clientes'] = $this->orcamentos_model->getCliente();
         $this->data['dados_vendedor']= $this->orcamentos_model->getVendedor();
         $this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
         $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
         $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
         $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();
        */
     	

		/*$this->data['results'] = $this->os_model->get('os','idOs,dataInicial,dataFinal,garantia,descricaoProduto,defeito,status,observacoes,laudoTecnico','',$config['per_page'],$this->uri->segment(3));*/
       
	    $this->data['view'] = 'almoxarifado/almoxarifado';
       	$this->load->view('tema/topo',$this->data);
       //$this->load->view('tema/rodape');
		
    }
	public function almoxarifadoeditar() {
		 $this->load->model('os_model');
		 
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eAlmoxarifado')){
          $this->session->set_flashdata('error','Você não tem permissão para alterar item almoxarifado.');
          redirect(base_url());
        }
		$this->data['dados_statusgrupo'] = $this->os_model->getstatus_grupo('');
		$this->data['r'] = $this->almoxarifado_model->getdistribuidor2('distribuir_os','*','distribuir_os.idDistribuir = '.$this->uri->segment(3));
		
		 $this->data['view'] = 'almoxarifado/almoxarifadoeditar';
       	$this->load->view('tema/topo',$this->data);
	}
	public function editar_distribuiros() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eAlmoxarifado')){
          $this->session->set_flashdata('error','Você não tem permissão para alterar item almoxarifado.');
          redirect(base_url());
        }
		 //$config['base_url'] = base_url().'index.php/almoxarifado/almoxarifadoeditar/'.$this->uri->segment(3);
		 
		
		 
		 
 $this->load->model('os_model');
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('idOs', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idInsumos', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantidade', '', 'trim|required|xss_clean');
		$this->data['dados_statusgrupo'] = $this->os_model->getstatus_grupo('');
if($this->input->post('idgrupo') == 0)
{
	$this->session->set_flashdata('error','Informe o grupo!');
                redirect(base_url() . 'index.php/almoxarifado/almoxarifado/'.$this->input->post('idOs'));
}



$this->data['r'] = $this->almoxarifado_model->getdistribuidor2('distribuir_os','*','distribuir_os.idDistribuir = '.$this->input->post('idDistribuir'));

        if ($this->form_validation->run() == false) {

            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe os dados necessarios!');
                redirect(base_url() . 'index.php/almoxarifado/almoxarifado/');
				
        } else {
  
        	
        	

            $data = array(
                'idInsumos' => $this->input->post('idInsumos'),
                'dimensoes' => $this->input->post('dimensoes'),
				 'id_status_grupo' => $this->input->post('idgrupo'),
                'idProdutos' => $this->input->post('idProdutosa2'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $this->input->post('quantidade'),
                'data_alteracao' => date('Y-m-d H:i:s'),
                'idOs' => $this->input->post('idOs')
            );
			 
  if ($this->os_model->edit('distribuir_os', $data, 'idDistribuir', $this->input->post('idDistribuir')) == TRUE) {
                $this->session->set_flashdata('success','Item editado com sucesso!');
                redirect(base_url() . 'index.php/almoxarifado/almoxarifadoeditar/'.$this->input->post('idDistribuir'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'almoxarifado/almoxarifadoeditar';
       	$this->load->view('tema/topo',$this->data);

    }
	function editar_1(){
		
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para editar PC.');
          redirect(base_url());
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

  
    $id_item_pc1= $this->input->post('id_item_pc1');
    //$idCotacaoItens= $this->input->post('idCotacaoItens');
   
  
	 
	
  
        if ($this->input->post('id_item_pc1') == '') {
            
			$this->session->set_flashdata('error','Erro ao editar!');
                redirect(base_url() . 'index.php/almoxarifado/almoxarifado');
				
         } else {
			 
			 		
			

$data3 = array(
                'liberado_edit_compras' => '1'
            );
			
			
	$this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $id_item_pc1);
			

	$this->session->set_flashdata('success','Item Liberado com sucesso!');
	
				redirect(base_url() . 'index.php/almoxarifado/almoxarifado');
			
		 }
		
		 
		
	}
	
	function editar_0(){
		
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para editar PC.');
          redirect(base_url());
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

  
    $id_item_pc2= $this->input->post('id_item_pc2');
   
   
  
	 
	
  
        if ($this->input->post('id_item_pc2') == '') {
            
			$this->session->set_flashdata('error','Erro ao editar!');
                redirect(base_url() . 'index.php/almoxarifado/almoxarifado');
				
         } else {
			 
			 		
			

$data3 = array(
                'liberado_edit_compras' => '0'
            );
			
			
	$this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $id_item_pc2);
			

	$this->session->set_flashdata('success','Item Liberado com sucesso!');
	
				redirect(base_url() . 'index.php/almoxarifado/almoxarifado');
			
		 }
		
		 
		
	}
	function visualizarimprimir(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vAlmoxarifado')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Cotacao.');
           redirect(base_url());
        }
        
          $this->load->library('table');
         $this->load->library('pagination');
         $this->load->model('os_model');
		$this->load->model('orcamentos_model');		 
		$this->load->model('cotacao_model');		 
         
         $config['base_url'] = base_url().'index.php/cotacao/visualizarimprimir/';
         
$this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
$this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
		 
        
        
			  $idPedidoCotacao = $this->uri->segment(3);
		if($idPedidoCotacao == null)
		{
			 redirect(base_url() . 'index.php/almoxarifado/gerenciar');
		}
        
        $this->data['results'] = $this->almoxarifado_model->getWhereLikeos('', $idPedidoCotacao,'');
  
        
        
    

		/*$this->data['results'] = $this->os_model->get('os','idOs,dataInicial,dataFinal,garantia,descricaoProduto,defeito,status,observacoes,laudoTecnico','',$config['per_page'],$this->uri->segment(3));*/
       
	    $this->data['view'] = 'cotacao/visualizarimprimir';
       	$this->load->view('tema/topo',$this->data);
       //$this->load->view('tema/rodape');
		
    }
	
	public function imprimir_cotacao(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vAlmoxarifado')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Cotacao.');
           redirect(base_url());
        }
		 $idPedidoCotacao =  $this->input->get('idPedidoCotacao');
		 $dataInicial =  $this->input->get('dataInicial');
		 $idEmitente =  $this->input->get('idEmitente');
	
  $data['dados_emitente'] = $this->cotacao_model->getEmitente($this->input->get('idEmitente'));
        $this->data['custom_error'] = '';
        
         $data['result'] = $this->cotacao_model->cotacaoCustom($idPedidoCotacao,$dataInicial,$idEmitente);
       
 
	
				$this->load->helper('mpdf');
           echo $html = $this->load->view('cotacao/imprimir/imprimir_cotacao',$data,true);
       
    }
	function montarcotacao_editar(){
		
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCotacao')){
          $this->session->set_flashdata('error','Você não tem permissão para editar Cotacao.');
          redirect(base_url());
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

   
  
    $idCotacaoItens = $this->input->post('idCotacaoItens_edi5');
   
   $idPedidoCotacao_n= $this->input->post('idPedidoCotacao_n2');
  
 
        if ($this->input->post('idPedidoCotacao_n2') == '' || $this->input->post('idCotacaoItens_edi5') == '') {
            
			$this->session->set_flashdata('error','Informe o número da nova cotação!');
                redirect(base_url() . 'index.php/almoxarifado/gerenciar');
				
         } else {
			 
			$this->data['dadoscot'] = $this->cotacao_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $idCotacaoItens);
        
		 $idPedidoCotacao = $this->data['dadoscot']->idPedidoCotacao;
		 $idDistribuir = $this->data['dadoscot']->idDistribuir; 
			 
			 
			 
			 if(count($this->cotacao_model->getqtditens($idPedidoCotacao)) == 1)
			{
				$this->cotacao_model->delete('pedido_cotacao','idPedidoCotacao',$idPedidoCotacao); 
			}

 $data3 = array(
                'idPedidoCotacao' => $idPedidoCotacao_n,
				 'data_cadastro' => date('Y-m-d H:i:s')
            );
				
			
	$this->cotacao_model->edit('pedido_cotacaoitens', $data3, 'idCotacaoItens', $idCotacaoItens);

				
				
				
					
			

	$this->session->set_flashdata('success','Cotação editada com sucesso!');
	
				redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$idPedidoCotacao_n);
			
		 }
		
		 
		
	}
	
	function montarcotacao_editar_status(){
		
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCotacao')){
          $this->session->set_flashdata('error','Você não tem permissão para editar Cotacao.');
          redirect(base_url());
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

   
  
   $idCotacaoItens = $this->input->post('idCotacaoItens_edis');
   
   $idStatuscompras_n= $this->input->post('idStatuscompras_n');
  
  
      
			 
			$this->data['dadoscot'] = $this->cotacao_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $idCotacaoItens);
        
		 $idPedidoCotacao = $this->data['dadoscot']->idPedidoCotacao;
		 $idDistribuir = $this->data['dadoscot']->idDistribuir; 
			 
			 
			 
			

 $data3 = array(
                'idStatuscompras' => $idStatuscompras_n,
				 'data_alteracao' => date('Y-m-d H:i:s')
            );
				
			
	$this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);

				
				
				
					
			

	$this->session->set_flashdata('success','Status editado com sucesso!');
	
				redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$idPedidoCotacao);
			
		
		
		 
		
	}
	 
	
	function excluir_itemcotacao(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dAlmoxarifado')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir item cotação.');
           redirect(base_url());
        }

        $this->load->model('cotacao_model');		
        
         $idCotacaoItens =  $id =  $this->input->post('idCotacaoItens2');
		
		
       
		
		
        if ($idCotacaoItens == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir item.'); 
			  redirect(base_url() . 'index.php/almoxarifado/gerenciar');
            
        }
		
		$this->data['dadoscot'] = $this->cotacao_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $idCotacaoItens);
        
		  $idPedidoCotacao = $this->data['dadoscot']->idPedidoCotacao;
		  $idDistribuir = $this->data['dadoscot']->idDistribuir;
		
		
		 
		

       if( $this->cotacao_model->getitemcompra($idCotacaoItens) == false)
		{
			
			
			$data3 = array(
                'idStatuscompras' => '1'
            );
			
			
	$this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
			
		
			if(count($this->cotacao_model->getqtditens($idPedidoCotacao)) == 1)
			{
				$this->cotacao_model->delete('pedido_cotacao','idPedidoCotacao',$idPedidoCotacao); 
			}
			$this->cotacao_model->delete('pedido_cotacaoitens','idCotacaoItens',$idCotacaoItens); 
			
			 $this->session->set_flashdata('success','Item excluido com sucesso!'); 
				if(count($this->cotacao_model->getqtditens($idPedidoCotacao)) == 1)
			{
        redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$idPedidoCotacao);
			}
			else
			{
				  redirect(base_url() . 'index.php/almoxarifado');
			}
		}
		else
		{
			 $this->session->set_flashdata('error','Item possui compra cadastrada.');
			  redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$idPedidoCotacao);
		}
	
        
    }
	function excluir_itemdist(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dAlmoxarifado')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir item cotação.');
           redirect(base_url());
        }

        $this->load->model('cotacao_model');		
        
          $idDistribuir =  $id =  $this->input->post('idCotacaoItens22');
		

        if ($idDistribuir == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir item.'); 
			  redirect(base_url() . 'index.php/almoxarifado/gerenciar');
            
        }
		
				
	$this->cotacao_model->delete('distribuir_os','idDistribuir',$idDistribuir); 		
			
			 $this->session->set_flashdata('success','Item excluido com sucesso!'); 
		
				  redirect(base_url() . 'index.php/almoxarifado');
	   
    }
	
    function adicionar(){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
        if ($this->form_validation->run('os') == false) {
           $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');

            try {
                
                $dataInicial = explode('/', $dataInicial);
                $dataInicial = $dataInicial[2].'-'.$dataInicial[1].'-'.$dataInicial[0];

                $dataFinal = explode('/', $dataFinal);
                $dataFinal = $dataFinal[2].'-'.$dataFinal[1].'-'.$dataFinal[0];

            } catch (Exception $e) {
               $dataInicial = date('Y/m/d'); 
            }

            $data = array(
                'dataInicial' => $dataInicial,
                'clientes_id' => $this->input->post('clientes_id'),//set_value('idCliente'),
                'usuarios_id' => $this->input->post('usuarios_id'),//set_value('idUsuario'),
                'dataFinal' => $dataFinal,
                'garantia' => set_value('garantia'),
                'descricaoProduto' => set_value('descricaoProduto'),
                'defeito' => set_value('defeito'),
                'status' => set_value('status'),
                'observacoes' => set_value('observacoes'),
                'laudoTecnico' => set_value('laudoTecnico'),
                'faturado' => 0
            );

            if ( is_numeric($id = $this->os_model->add('os', $data, true)) ) {
                $this->session->set_flashdata('success','OS adicionada com sucesso, você pode adicionar produtos ou serviços a essa OS nas abas de "Produtos" e "Serviços"!');
                redirect('os/editar/'.$id);

            } else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
         
        $this->data['view'] = 'os/adicionarOs';
        $this->load->view('tema/topo', $this->data);
    }
    
    public function adicionarAjax(){
        $this->load->library('form_validation');

        if ($this->form_validation->run('os') == false) {
           $json = array("result"=> false);
           echo json_encode($json);
        } else {
            $data = array(
                'dataInicial' => set_value('dataInicial'),
                'clientes_id' => $this->input->post('clientes_id'),//set_value('idCliente'),
                'usuarios_id' => $this->input->post('usuarios_id'),//set_value('idUsuario'),
                'dataFinal' => set_value('dataFinal'),
                'garantia' => set_value('garantia'),
                'descricaoProduto' => set_value('descricaoProduto'),
                'defeito' => set_value('defeito'),
                'status' => set_value('status'),
                'observacoes' => set_value('observacoes'),
                'laudoTecnico' => set_value('laudoTecnico')
            );

            if ( is_numeric($id = $this->os_model->add('os', $data, true)) ) {
                $json = array("result"=> true, "id"=> $id);
                echo json_encode($json);

            } else {
                $json = array("result"=> false);
                echo json_encode($json);

            }
        }
         
    }




	 public function distribuiros(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eDistribuirOs')){
           $this->session->set_flashdata('error','Você não tem permissão para Distribuir OS.');
           redirect(base_url());
        }
		

        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        
		$this->data['distribuir_os'] = $this->os_model->getmaterial_dist($this->uri->segment(3));
		
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
$this->data['anexo_desenho'] = $this->os_model->getdesenho_os($this->uri->segment(3));
$this->data['anexo_pedido'] = $this->os_model->getpedido_os($this->uri->segment(3));
$this->data['anexo_nf'] = $this->os_model->getnf_os($this->uri->segment(3),'anexo_notafiscal');
$this->data['anexo_nfcliente'] = $this->os_model->getnf_os($this->uri->segment(3),'anexo_nfcliente');
$this->data['anexo_nfvenda'] = $this->os_model->getnf_os($this->uri->segment(3),'anexo_nfvenda');
$this->data['orcamento'] = $this->orcamentos_model->getById('orcamento',$this->data['result']->idOrcamentos);
$this->data['status_os'] = $this->os_model->getstatus_os();
$this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($this->data['orcamento']->	idNatOperacao); 
 $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
  $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
/*   
$this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico($this->data['orcamento']->idGrupoServico);*/	
	$this->data['itens_orcamento'] = $this->orcamentos_model->get_item_orc($this->data['result']->idOrcamento_item);
		
$this->data['dados_emitente'] = $this->orcamentos_model->getEmitente($this->data['orcamento']->idEmitente);	

        $this->data['view'] = 'os/distribuiros';
        $this->load->view('tema/topo', $this->data);
       
    }
	public function autoCompleteDistribuir(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
             //$campo = $_GET['campo'];
			
            $this->os_model->autoCompleteDistribuir($q);
        }

    }
	
	
	
	 
	 function montarcotacao(){
		
		 $this->load->model('cotacao_model');
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar item almoxarifado.');
          redirect(base_url());
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

   $contador=count($this->input->post('idDistribuir_'));
  
  
        if ($this->input->post('idDistribuir_')[0] < 1) {
            
			$this->session->set_flashdata('error','Selecione pelo menos um item!');
                redirect(base_url() . 'index.php/almoxarifado');
				
         } else {



$data = array(
                'data_cadastro' => date('Y-m-d H:i:s')
            );
			

 

  if (is_numeric($id = $this->cotacao_model->add('pedido_cotacao', $data, true)) ) {

				$total=0;

				for($x=0;$x<$contador;$x++)
				{
					
					$data2 = array(
                'idDistribuir' => $this->input->post('idDistribuir_')[$x],
                'data_cadastro' => date('Y-m-d H:i:s'),
                'idPedidoCotacao' => $id
            );
			
			$data3 = array(
                'idStatuscompras' => '2'
            );
			
					
				$this->cotacao_model->add('pedido_cotacaoitens', $data2, true);
		$this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $this->input->post('idDistribuir_')[$x]);
					
				
				
					
				}

	$this->session->set_flashdata('success','Cotação cadastrada com sucesso!');
                redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$id);
	
		 }
		  else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao gerar cotacao.</p></div>';
            }
		 }
		
	}
	 public function editar_pedido() {
        
	
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'apedidoOs')){
           $this->session->set_flashdata('error','Você não tem permissão para editar pedido.');
           redirect(base_url().'index.php/os/visualizar/'.$this->input->post('idOs'));
        }
	 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe um nome!');
                redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
        } else {	

 $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'idOs' => $this->input->post('idOs'),
                'idAnexo' => $this->input->post('idAnexo')
            );
	
     
           
           
            if ($this->os_model->edit('anexo_pedido', $data, 'idAnexo', $this->input->post('idAnexo')) == TRUE) {
               
               /* $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumo','editar',$descricao );
               */
               
                $this->session->set_flashdata('success','Pedido editado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
            
	 }
    }
	 public function excluirpedido(){
    	

    	$id = $this->input->post('idAnexo');
    	$idOs = $this->input->post('idOs');
    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
           redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
    	}

$imagem = $this->input->post('imagem');
    	if( $this->os_model->getimagem_base($id,$imagem,'anexo_pedido') == true)
		{
			$this->session->set_flashdata('error','Esse arquivo não pode ser excluido , pois ele esta vinculado a outra OS.');
          redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs').'#tab2');
		}
		
    	$file = $this->os_model->getimagempedido($id);

    	$this->db->where('idAnexo', $id);
        
        if($this->db->delete('anexo_pedido')){
			$path = FCPATH.$file->caminho.$file->imagem;
        	 unlink($path);
	    	

	    	$this->session->set_flashdata('success','Arquivo excluido com sucesso!');
	        redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
        }
        else{

        	$this->session->set_flashdata('error','Ocorreu um erro ao tentar excluir o arquivo.');
          redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
        }


    }
	
    function excluir(){

        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir OS.');            
            redirect(base_url().'index.php/os/gerenciar/');
        }

        $this->db->where('os_id', $id);
        $this->db->delete('servicos_os');

        $this->db->where('os_id', $id);
        $this->db->delete('produtos_os');

        $this->db->where('os_id', $id);
        $this->db->delete('anexos');

        $this->os_model->delete('os','idOs',$id);             
        

        $this->session->set_flashdata('success','OS excluída com sucesso!');            
        redirect(base_url().'index.php/os/gerenciar/');


        
    }

    public function autoCompleteProduto(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteProduto($q);
        }

    }

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteCliente($q);
        }

    }

    public function autoCompleteUsuario(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteUsuario($q);
        }

    }

    public function autoCompleteServico(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteServico($q);
        }

    }

    public function adicionarProduto(){

        
        $preco = $this->input->post('preco');
        $quantidade = $this->input->post('quantidade');
        $subtotal = $preco * $quantidade;
        $produto = $this->input->post('idProduto');
        $data = array(
            'quantidade'=> $quantidade,
            'subTotal'=> $subtotal,
            'produtos_id'=> $produto,
            'os_id'=> $this->input->post('idOsProduto'),
        );

        if($this->os_model->add('produtos_os', $data) == true){
            $sql = "UPDATE produtos set estoque = estoque - ? WHERE idProdutos = ?";
            $this->db->query($sql, array($quantidade, $produto));
            
            echo json_encode(array('result'=> true));
        }else{
            echo json_encode(array('result'=> false));
        }
      
    }

    function excluirProduto(){
            $ID = $this->input->post('idProduto');
            if($this->os_model->delete('produtos_os','idProdutos_os',$ID) == true){
                
                $quantidade = $this->input->post('quantidade');
                $produto = $this->input->post('produto');


                $sql = "UPDATE produtos set estoque = estoque + ? WHERE idProdutos = ?";

                $this->db->query($sql, array($quantidade, $produto));
                
                echo json_encode(array('result'=> true));
            }
            else{
                echo json_encode(array('result'=> false));
            }           
    }

    public function adicionarServico(){

        
        $data = array(
            'servicos_id'=> $this->input->post('idServico'),
            'os_id'=> $this->input->post('idOsServico'),
        );

        if($this->os_model->add('servicos_os', $data) == true){

            echo json_encode(array('result'=> true));
        }else{
            echo json_encode(array('result'=> false));
        }

    }

    function excluirServico(){
            $ID = $this->input->post('idServico');
            if($this->os_model->delete('servicos_os','idServicos_os',$ID) == true){

                echo json_encode(array('result'=> true));
            }
            else{
                echo json_encode(array('result'=> false));
            }
    }


    public function anexar(){

        $this->load->library('upload');
        $this->load->library('image_lib');

        $upload_conf = array(
            'upload_path'   => realpath('./assets/anexos'),
            'allowed_types' => 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|PDF|cdr|CDR|docx|DOCX|txt', // formatos permitidos para anexos de os
            'max_size'      => 0,
            );
    
        $this->upload->initialize( $upload_conf );
        
        // Change $_FILES to new vars and loop them
        foreach($_FILES['userfile'] as $key=>$val)
        {
            $i = 1;
            foreach($val as $v)
            {
                $field_name = "file_".$i;
                $_FILES[$field_name][$key] = $v;
                $i++;   
            }
        }
        // Unset the useless one ;)
        unset($_FILES['userfile']);
    
        // Put each errors and upload data to an array
        $error = array();
        $success = array();
        
        // main action to upload each file
        foreach($_FILES as $field_name => $file)
        {
            if ( ! $this->upload->do_upload($field_name))
            {
                // if upload fail, grab error 
                $error['upload'][] = $this->upload->display_errors();
            }
            else
            {
                // otherwise, put the upload datas here.
                // if you want to use database, put insert query in this loop
                $upload_data = $this->upload->data();
                
                if($upload_data['is_image'] == 1){

                   // set the resize config
                    $resize_conf = array(
                        // it's something like "/full/path/to/the/image.jpg" maybe
                        'source_image'  => $upload_data['full_path'], 
                        // and it's "/full/path/to/the/" + "thumb_" + "image.jpg
                        // or you can use 'create_thumbs' => true option instead
                        'new_image'     => $upload_data['file_path'].'thumbs/thumb_'.$upload_data['file_name'],
                        'width'         => 200,
                        'height'        => 125
                        );

                    // initializing
                    $this->image_lib->initialize($resize_conf);

                    // do it!
                    if ( ! $this->image_lib->resize())
                    {
                        // if got fail.
                        $error['resize'][] = $this->image_lib->display_errors();
                    }
                    else
                    {
                        // otherwise, put each upload data to an array.
                        $success[] = $upload_data;

                        $this->load->model('Os_model');

                        $this->Os_model->anexar($this->input->post('idOsServico'), $upload_data['file_name'] ,base_url().'assets/anexos/','thumb_'.$upload_data['file_name'],realpath('./assets/anexos/'));

                    } 
                }
                else{

                    $success[] = $upload_data;

                    $this->load->model('Os_model');

                    $this->Os_model->anexar($this->input->post('idOsServico'), $upload_data['file_name'] ,base_url().'assets/anexos/','',realpath('./assets/anexos/'));
 
                }
                
            }
        }

        // see what we get
        if(count($error) > 0)
        {
            //print_r($data['error'] = $error);
            echo json_encode(array('result'=> false, 'mensagem' => 'Nenhum arquivo foi anexado.'));
        }
        else
        {
            //print_r($data['success'] = $upload_data);
            echo json_encode(array('result'=> true, 'mensagem' => 'Arquivo(s) anexado(s) com sucesso .'));
        }
        

    }


   /* public function excluirAnexo($id = null){
        if($id == null || !is_numeric($id)){
            echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao tentar excluir anexo.'));
        }
        else{

            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos',1)->row();

            unlink($file->path.'/'.$file->anexo);

            if($file->thumb != null){
                unlink($file->path.'/thumbs/'.$file->thumb);    
            }
            
            if($this->os_model->delete('anexos','idAnexos',$id) == true){

                echo json_encode(array('result'=> true, 'mensagem' => 'Anexo excluído com sucesso.'));
            }
            else{
                echo json_encode(array('result'=> false, 'mensagem' => 'Erro ao tentar excluir anexo.'));
            }

            
        }
    }*/


    public function downloadanexo($id = null){
        
        if($id != null && is_numeric($id)){
            
            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos',1)->row();

            $this->load->library('zip');

            $path = $file->path;

            $this->zip->read_file($path.'/'.$file->anexo); 

            $this->zip->download('file'.date('d-m-Y-H.i.s').'.zip'); 

        }
      
    }


    public function faturar() {

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
 

        if ($this->form_validation->run('receita') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {


            $vencimento = $this->input->post('vencimento');
            $recebimento = $this->input->post('recebimento');

            try {
                
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];

                if($recebimento != null){
                    $recebimento = explode('/', $recebimento);
                    $recebimento = $recebimento[2].'-'.$recebimento[1].'-'.$recebimento[0];

                }
            } catch (Exception $e) {
               $vencimento = date('Y/m/d'); 
            }
            
            $data = array(
                'descricao' => set_value('descricao'),
                'valor' => $this->input->post('valor'),
                'clientes_id' => $this->input->post('clientes_id'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $recebimento,
                'baixado' => $this->input->post('recebido'),
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo')
            );

            if ($this->os_model->add('lancamentos',$data) == TRUE) { 
                
                $os = $this->input->post('os_id'); 

                $this->db->set('faturado',1);
                $this->db->set('valorTotal',$this->input->post('valor'));
                $this->db->where('idOs', $os);
                $this->db->update('os'); 

                $this->session->set_flashdata('success','OS faturada com sucesso!');
                $json = array('result'=>  true);
                echo json_encode($json);
                die();
            } else {
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar OS.');
                $json = array('result'=>  false);
                echo json_encode($json);
                die();
            }
        }

        $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar OS.');
        $json = array('result'=>  false);
        echo json_encode($json);
        
    }

}

