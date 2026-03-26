<?php

class Os extends CI_Controller {
    
    function __construct() {
        parent::__construct();
                if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
                    redirect('mapos/login');
                }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('os_model','',TRUE);
		$this->data['menuOs'] = 'OS';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar OS.');
           redirect(base_url());
        }
         $this->load->library('table');
         $this->load->library('pagination');
         
             
         
         $config['base_url'] = base_url().'index.php/os/gerenciar/';
            
         
         $idOs = $this->input->post('idOs');
         $cod_orc = $this->input->post('idOrcamentos');
         $clientes_id  = $this->input->post('clientes_id');
         $idProdutos = $this->input->post('idProdutos');
         $numpedido_os = $this->input->post('numpedido_os');
         $tag = $this->input->post('tag');
         $numero_nf = $this->input->post('numero_nf');
         $descricao_item = $this->input->post('descricao_item');

		 if (!empty($idOs) || !empty($cod_orc) || !empty($clientes_id) || !empty($idProdutos) || !empty($numpedido_os) || !empty($tag) || !empty($numero_nf) || !empty($descricao_item)) {
            
			
			
			
            $this->data['results'] = $this->os_model->getWhereLikeos($idOs, $cod_orc, $clientes_id, $idProdutos, $numpedido_os,$tag, $numero_nf,$descricao_item,'os');
 
             $config['total_rows'] = $this->os_model->numrowsWhereLikeos($idOs, $cod_orc, $clientes_id, $idProdutos, $numpedido_os,$tag, $numero_nf,$descricao_item,'os');
             $config['per_page'] = 50;
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


            $config['total_rows'] = $this->os_model->count('os');
             $config['per_page'] = 50;
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
           
         $this->data['results'] = $this->os_model->getos('os','os.numpedido_os,os.tag,os.val_ipi_os,os.idOs,os.`data_abertura`,os.`subtot_os`,os.`data_entrega`,os.`data_reagendada`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,status_os.nomeStatusOs','','os',$config['per_page'],$this->uri->segment(3));
        
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
       
	    $this->data['view'] = 'os/os';
       	$this->load->view('tema/topo',$this->data);
       //$this->load->view('tema/rodape');
		
    }
	
	function carteiraservico(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar OS.');
           redirect(base_url());
        }
         $this->load->library('table');
         $this->load->library('pagination');
		 $this->load->model('orcamentos_model');
             
         
		  $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
  $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
		 $this->data['status_os']= $this->os_model->getStatusOs();
		 $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
		 
		 
         $config['base_url'] = base_url().'index.php/os/carteiraservico/';
            
         
         $idOs = $this->input->post('idOs');
         $cod_orc = $this->input->post('idOrcamentos');
         $clientes_id  = $this->input->post('clientes_id');
         $idProdutos = $this->input->post('idProdutos');
		 
		  $descricao_item = $this->input->post('descricao_item');
		 
		 $querydatacadastro = "";
		 $querydataentrega = "";
		 $querydatareagendada = "";
		 $queryentrega_reagendada = "";
		 
		 //data reagendada e entrega
		  $dataeinicial = $this->input->post('dataeinicial');
         $dataefinal = $this->input->post('dataefinal');
		 if(!empty($dataeinicial) && !empty($dataefinal))
		 {
		 $dataeinicial2 = explode('/', $dataeinicial);
         $dataeinicial2 = $dataeinicial2[2].'-'.$dataeinicial2[1].'-'.$dataeinicial2[0];
		
		
		 $dataefinal2 = explode('/', $dataefinal);
         $dataefinal2 = $dataefinal2[2].'-'.$dataefinal2[1].'-'.$dataefinal2[0];
		
		
		$queryentrega_reagendada = " and (os.data_entrega BETWEEN '$dataeinicial2 00:00:00' AND '$dataefinal2 23:59:59' or os.data_reagendada BETWEEN '$dataeinicial2 00:00:00' AND '$dataefinal2 23:59:59')";
		 }
		 
		
		 
         $dataInicialcad = $this->input->post('dataInicialcad');
         $dataFinalcad = $this->input->post('dataFinalcad');
		
		 if(!empty($dataInicialcad) && !empty($dataFinalcad))
		 {
		  $dataInicialcad2 = explode('/', $dataInicialcad);
           $dataInicialcad2 = $dataInicialcad2[2].'-'.$dataInicialcad2[1].'-'.$dataInicialcad2[0];
		
		
		 $dataFinalcad2 = explode('/', $dataFinalcad);
         $dataFinalcad2 = $dataFinalcad2[2].'-'.$dataFinalcad2[1].'-'.$dataFinalcad2[0];
		
		
		 $querydatacadastro = " and os.data_abertura BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
		 }		
         $dataInicialentrega = $this->input->post('dataInicialentrega');
         $dataFinalentrega = $this->input->post('dataFinalentrega');
		  if(!empty($dataInicialentrega) && !empty($dataFinalentrega))
		 {
		 $dataInicialentrega2 = explode('-', $dataInicialentrega);
         $dataInicialentrega2 = $dataInicialentrega2[0].'-'.$dataInicialentrega2[1].'-'.$dataInicialentrega2[2];
		
		 $dataFinalentrega2 = explode('-', $dataFinalentrega);
         $dataFinalentrega2 = $dataFinalentrega2[0].'-'.$dataFinalentrega2[1].'-'.$dataFinalentrega2[2];
		
		$querydataentrega = " and os.data_entrega BETWEEN '$dataInicialentrega2 00:00:00' AND '$dataFinalentrega2 23:59:59'";
		 }	
         $dataInicialreag = $this->input->post('dataInicialreag');
         $dataFinalreag = $this->input->post('dataFinalreag');
		  if(!empty($dataInicialreag) && !empty($dataFinalreag))
		 {
		 $dataInicialreag2 = explode('-', $dataInicialreag);
         $dataInicialreag2 = $dataInicialreag2[0].'-'.$dataInicialreag2[1].'-'.$dataInicialreag2[2];
		
		 $dataFinalreag2 = explode('-', $dataFinalreag);
         $dataFinalreag2 = $dataFinalreag2[0].'-'.$dataFinalreag2[1].'-'.$dataFinalreag2[2];
		
		$querydatareagendada = " and os.data_reagendada BETWEEN '$dataInicialreag2 00:00:00' AND '$dataFinalreag2 23:59:59'";
		 }
		 
         $idStatusOs = $this->input->post('idStatusOs');
		 $unid_execucao = $this->input->post('unid_execucao');
         $unid_faturamento = $this->input->post('unid_faturamento');
         
		 
		 $query_clientes = "";
		 if(!empty($clientes_id))
		{
			$conteudoc = $clientes_id;
		$query_clientes="(";
		$primeiroc = true;
			foreach($conteudoc as $clientes3)
			{
				if($primeiroc)
				{
					$query_clientes.=$clientes3;
					$primeiroc = false;
				}
				else
				{
					$query_clientes.=",".$clientes3;
				}
			}
			$query_clientes .= ")";
		}
		
		 $query_status_producao = "";
		 if(!empty($idStatusOs))
		{
			$conteudo = $idStatusOs;
		$query_status_producao="(";
		$primeiro = true;
			foreach($conteudo as $status_producao3)
			{
				if($primeiro)
				{
					$query_status_producao.=$status_producao3;
					$primeiro = false;
				}
				else
				{
					$query_status_producao.=",".$status_producao3;
				}
			}
			$query_status_producao .= ")";
		}
		$query_unid_execucao = "";
		 if(!empty($unid_execucao))
		{
			$conteudo2 = $unid_execucao;
		$query_unid_execucao="(";
		$primeiro2 = true;
			foreach($conteudo2 as $unid_execucao2)
			{
				if($primeiro2)
				{
					$query_unid_execucao.=$unid_execucao2;
					$primeiro2 = false;
				}
				else
				{
					$query_unid_execucao.=",".$unid_execucao2;
				}
			}
			$query_unid_execucao .= ")";
		}
$query_unid_faturamento = "";
		 if(!empty($unid_faturamento))
		{
			$conteudo3 = $unid_faturamento;
		$query_unid_faturamento="(";
		$primeiro3 = true;
			foreach($conteudo3 as $unid_execucao2)
			{
				if($primeiro3)
				{
					$query_unid_faturamento.=$unid_execucao2;
					$primeiro3 = false;
				}
				else
				{
					$query_unid_faturamento.=",".$unid_execucao2;
				}
			}
			$query_unid_faturamento .= ")";
		}
 
		 if (!empty($idOs) || !empty($cod_orc) ||  !empty($idProdutos) || !empty($query_status_producao) || !empty($query_unid_execucao) || !empty($query_unid_faturamento) || !empty($querydataentrega) || !empty($querydatacadastro) || !empty($querydatareagendada) || !empty($query_clientes) || !empty($queryentrega_reagendada) || !empty($descricao_item)) { 
            
			
            $this->data['results'] = $this->os_model->getWhereLikeos($idOs, $cod_orc, '', $idProdutos, '', '','',$descricao_item,'c',$query_status_producao,$query_unid_execucao,$query_unid_faturamento,$querydataentrega,$querydatacadastro,$querydatareagendada,$query_clientes,$queryentrega_reagendada);
			
			$this->data['result_status'] = $this->os_model->getWhereLikeos_status($idOs, $cod_orc, '', $idProdutos, '', '','',$descricao_item,'c',$query_status_producao,$query_unid_execucao,$query_unid_faturamento,$querydataentrega,$querydatacadastro,$querydatareagendada,$query_clientes,$queryentrega_reagendada);

             $config['total_rows'] = $this->os_model->numrowsWhereLikeos($idOs, $cod_orc, '', $idProdutos, '','', '',$descricao_item,'c',$query_status_producao,$query_unid_execucao,$query_unid_faturamento,$querydataentrega,$querydatacadastro,$querydatareagendada,$query_clientes,$queryentrega_reagendada);
             $config['per_page'] = 20000;
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


            $config['total_rows'] = $this->os_model->count('os');
             $config['per_page'] = 20000;
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
           
         $this->data['results'] = $this->os_model->getos('os','os.idOs,os.`data_abertura`,os.`data_entrega`,os.`data_reagendada`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,os.subtot_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,status_os.nomeStatusOs,emitente.nome','status_os.carteirapadrao = 1','c',$config['per_page'],$this->uri->segment(3));
		 
		 $this->data['result_status'] = $this->os_model->getWhereLikeos_status($this->uri->segment(3), '', '', '', '', '','','c','','','','','','','','','and status_os.carteirapadrao = 1');

        
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
       
	    $this->data['view'] = 'os/carteiraservico';
       	$this->load->view('tema/topo',$this->data);
       //$this->load->view('tema/rodape');
		
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

 function reagendar() {
	 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'reagendarOs')){
          $this->session->set_flashdata('error','Você não tem permissão para reagendar OS.');
          redirect(base_url());
        }
	
	 
	 
	
	 
	
	if($this->input->post('novadata') == '' || $this->input->post('varias_os') == '' )
	{
	$this->session->set_flashdata('error','Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os');
				
	}

	$data_rea = explode('/', $this->input->post('novadata'));
	$data_rea = $data_rea[2].'-'.$data_rea[1].'-'.$data_rea[0];
	
	$data3 = array(
                'data_reagendada' => $data_rea
                
                
                
            );
			
			$id_osreag = explode(',', $this->input->post('varias_os'));
			
			
			
			foreach ($id_osreag as $os_reag) {
				
				$this->data['result'] = $this->os_model->getByid_table($os_reag,'os','idOs');	
				$descricao = serialize($this->data['result']);
				$this->salvarlog($this->session->userdata('idUsuarios'),'os','editar',$descricao,$os_reag );

			}
			
			
		
				
			
		
				
				
			
	 if ( $this->os_model->edit2('os', $data3, 'idOs', $this->input->post('varias_os')) == TRUE) {
               
                
               
               
                $this->session->set_flashdata('success','Os Alterada com sucesso! OS: '.$this->input->post('varias_os'));
                redirect(base_url() . 'index.php/os');
            } else {
                 $this->session->set_flashdata('error','Erro ao editar!');
                redirect(base_url() . 'index.php/os');
            }
	
	
 }
    
    function editaros() {
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar OS.');
          redirect(base_url());
        }
		$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('data_abertura', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('qtd_os', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('data_entrega', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idStatusOs', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('unid_execucao', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('unid_faturamento', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('contrato', '', 'trim|required|xss_clean');
      
        //$this->form_validation->set_rules('val_ipi_os', '', 'trim|required|xss_clean');
		
		//so esse alterar em orçamento item
		$this->form_validation->set_rules('descricao_os', '', 'trim|required|xss_clean');
		
		
		/*$this->form_validation->set_rules('numpedido_os', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('numero_nf', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nf_cliente', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nf_venda_dev', '', 'trim|required|xss_clean');
      */
	 
        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe campos obrigatorios!');
                redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs2'));
				
         } else {


	$data_abertura = $this->input->post('data_abertura');
	$data_entrega = $this->input->post('data_entrega');
	$data_reagendada = $this->input->post('data_reagendada');
	$data_nf_faturamento = $this->input->post('data_nf_faturamento');
     
	$desconto_ = str_replace(".","",$this->input->post('desconto_os'));
	$desconto_ = str_replace(",",".",$desconto_);
	
	$val_ipi_ = str_replace(".","",$this->input->post('val_ipi_os'));
	$val_ipi_ = str_replace(",",".",$val_ipi_);
	
	$valorunita = str_replace(".","",$this->input->post('val_unit_os'));
	$valorunita = str_replace(",",".",$valorunita);

	$subtot_os = str_replace(".","",$this->input->post('subtot_os'));
	$subtot_os = str_replace(",",".",$subtot_os);
	
	 
	$data_abertura = explode('/', $data_abertura);
	$data_abertura = $data_abertura[2].'-'.$data_abertura[1].'-'.$data_abertura[0];
	
	
	$data_entrega = explode('/', $data_entrega);
	$data_entrega = $data_entrega[2].'-'.$data_entrega[1].'-'.$data_entrega[0];
	
	if($data_reagendada <> '')
	{
	$data_reagendada = explode('/', $data_reagendada);
	$data_reagendada = $data_reagendada[2].'-'.$data_reagendada[1].'-'.$data_reagendada[0];
	 //$campo_reagendada = "'data_reagendada' => ".$data_reagendada.",";
	}
	else
	{
		
		$data_reagendada = null;
	}
	if($data_nf_faturamento <> '')
	{
	$data_nf_faturamento = explode('/', $data_nf_faturamento);
	$data_nf_faturamento = $data_nf_faturamento[2].'-'.$data_nf_faturamento[1].'-'.$data_nf_faturamento[0];
	//$campo_nf_faturamento = "'data_nf_faturamento' => ".$data_nf_faturamento.",";
	}
	else
	{
		
		$data_nf_faturamento = null;
	}
	
	if(!empty($this->input->post('nf_venda_dev')))
	{
		$nf_venda_dev = $this->input->post('nf_venda_dev');
	}
	else
	{
		$nf_venda_dev = null;
		
	}
	
	if(!empty($this->input->post('nf_cliente') ))
	{
		$nf_cliente = $this->input->post('nf_cliente');
	}
	else
	{
		
		$nf_cliente = NULL;
	}
	
	if(!empty($this->input->post('numero_nf')))
	{
		
		$numero_nf = $this->input->post('numero_nf');
		
	}
	else
	{
		$numero_nf = NULL;
	}
	
	
	if(!empty($this->input->post('numpedido_os') ))
	{
		
		$numpedido_os = $this->input->post('numpedido_os');
		
	}
	else
	{ 
	
		$numpedido_os = NULL;
		
	}

if(!empty($this->input->post('tag') ))
	{
		
		$tag = $this->input->post('tag');
		
	}
	else
	{ 
	
		$tag = NULL;
		
	}
	
 
if($this->input->post('qtd_os') < $this->input->post('qtd_os_original'))
{
	$gerarnovaqtd = $this->input->post('qtd_os_original') - $this->input->post('qtd_os');
	 
	 $data3 = array(
                'data_abertura' => $data_abertura." ".date("h:i:s"),
                
                'obs_controle' => ($this->input->post('obs_controle')),
                'obs_os' => $this->input->post('obs_os'),
                'data_entrega' => $data_entrega,
                'data_reagendada' => $data_reagendada,
				'data_nf_faturamento' => $data_nf_faturamento,
                'idOrcamento_item' => $this->input->post('idOrcamento_item'),
                'idOrcamentos' => $this->input->post('idOrcamentos'),
				'subtot_os' => $subtot_os,
                'desconto_os' => $desconto_,
                'val_ipi_os' => $val_ipi_,
                'val_unit_os' => $valorunita,
                'qtd_os' => $gerarnovaqtd,
                  'nf_venda_dev' => $nf_venda_dev,
                'nf_cliente' => $nf_cliente,
                'numero_nf' => $numero_nf,
                'numpedido_os' => $numpedido_os,
                'tag' => $tag,
                'idStatusOs' => $this->input->post('idStatusOs'),
                'unid_execucao' => $this->input->post('unid_execucao'),
                'unid_faturamento' => $this->input->post('unid_faturamento'),
                'contrato' => $this->input->post('contrato')
              
                
                
            );
	
		$id_novo = $this->orcamentos_model->add('os', $data3, true);

 $descricao = serialize($data3);
                $this->salvarlog($this->session->userdata('idUsuarios'),'os','inserir',$descricao,$id_novo );


 $data4 = array(
                
                'idOs_principal' => $this->input->post('idOs2'),
                'idOs_gerada' => $id_novo
                
                  
            );
		
	$vinc =	$this->orcamentos_model->add('os_vinculada', $data4, true);	
	
	$descricao = serialize($data4);
                $this->salvarlog($this->session->userdata('idUsuarios'),'os_vinculada','inserir',$descricao,$vinc );

	
	$this->data['anexo_desenho'] = $this->os_model->getanexos_os($this->input->post('idOs2'),'anexo_desenho');
	foreach ($this->data['anexo_desenho'] as $item) 
	{
		$data_an = array(
                'nomeArquivo' => $item->nomeArquivo,
                'idOs' => $id_novo,
                'data_cadastro' => $item->data_cadastro,
                'nomeArquivo' => $item->nomeArquivo,
                'caminho' => $item->caminho,
                'imagem' => $item->imagem,
                'extensao' => $item->extensao,
                'tamanho' => $item->tamanho,
                'user_proprietario' => $item->user_proprietario
            );
			
	$iddesenho=	$this->os_model->add('anexo_desenho', $data_an, true)	;
		
		
		$descricao = serialize($data_an);
        $this->salvarlog($this->session->userdata('idUsuarios'),'anexo_desenho','inserir',$descricao,$iddesenho );
	}
	
	$this->data['anexo_nfcliente'] = $this->os_model->getanexos_os($this->input->post('idOs2'),'anexo_nfcliente');
	foreach ($this->data['anexo_nfcliente'] as $item) 
	{
		$data_an = array(
                'nomeArquivo' => $item->nomeArquivo,
                'idOs' => $id_novo,
                'data_cadastro' => $item->data_cadastro,
                'nomeArquivo' => $item->nomeArquivo,
                'caminho' => $item->caminho,
                'imagem' => $item->imagem,
                'extensao' => $item->extensao,
                'tamanho' => $item->tamanho
            );
			
		$idane = $this->os_model->add('anexo_nfcliente', $data_an, true)	;
		$descricao = serialize($data_an);
        $this->salvarlog($this->session->userdata('idUsuarios'),'anexo_nfcliente','inserir',$descricao,$idane );
		
	}
	$this->data['anexo_nfvenda'] = $this->os_model->getanexos_os($this->input->post('idOs2'),'anexo_nfvenda');
	foreach ($this->data['anexo_nfvenda'] as $item) 
	{
		$data_an = array(
                'nomeArquivo' => $item->nomeArquivo,
                'idOs' => $id_novo,
                'data_cadastro' => $item->data_cadastro,
                'nomeArquivo' => $item->nomeArquivo,
                'caminho' => $item->caminho,
                'imagem' => $item->imagem,
                'extensao' => $item->extensao,
                'tamanho' => $item->tamanho
            );
			
		$id_nf = $this->os_model->add('anexo_nfvenda', $data_an, true)	;
		$descricao = serialize($data_an);
        $this->salvarlog($this->session->userdata('idUsuarios'),'anexo_nfvenda','inserir',$descricao,$id_nf );
	}
	$this->data['anexo_notafiscal'] = $this->os_model->getanexos_os($this->input->post('idOs2'),'anexo_notafiscal');
	foreach ($this->data['anexo_notafiscal'] as $item) 
	{
		$data_an = array(
                'nomeArquivo' => $item->nomeArquivo,
                'idOs' => $id_novo,
                'data_cadastro' => $item->data_cadastro,
                'nomeArquivo' => $item->nomeArquivo,
                'caminho' => $item->caminho,
                'imagem' => $item->imagem,
                'extensao' => $item->extensao,
                'tamanho' => $item->tamanho
            );
			
		$idnf = $this->os_model->add('anexo_notafiscal', $data_an,true)	;
		$descricao = serialize($data_an);
        $this->salvarlog($this->session->userdata('idUsuarios'),'anexo_notafiscal','inserir',$descricao,$idnf );
		
	}
	$this->data['anexo_pedido'] = $this->os_model->getanexos_os($this->input->post('idOs2'),'anexo_pedido');
	foreach ($this->data['anexo_pedido'] as $item) 
	{
		$data_an = array(
                'nomeArquivo' => $item->nomeArquivo,
                'idOs' => $id_novo,
                'data_cadastro' => $item->data_cadastro,
                'nomeArquivo' => $item->nomeArquivo,
                'caminho' => $item->caminho,
                'imagem' => $item->imagem,
                'extensao' => $item->extensao,
                'tamanho' => $item->tamanho
            );
			
		$nfpedido = $this->os_model->add('anexo_pedido', $data_an,true)	;
		$descricao = serialize($data_an);
        $this->salvarlog($this->session->userdata('idUsuarios'),'anexo_pedido','inserir',$descricao,$nfpedido );
	}	
		
	
	
	
}
	
           
            $data = array(
                'data_abertura' => $data_abertura." ".date("h:i:s"),
                'data_entrega' => $data_entrega,
				'obs_os' => $this->input->post('obs_os'),
                'data_reagendada' => $data_reagendada,
                'data_nf_faturamento' => $data_nf_faturamento,
                'desconto_os' => $desconto_,
                'val_ipi_os' => $val_ipi_,
                'val_unit_os' => $valorunita,
                'subtot_os' => $subtot_os,
                'qtd_os' => $this->input->post('qtd_os'),
                'idStatusOs' => $this->input->post('idStatusOs'),
                'unid_execucao' => $this->input->post('unid_execucao'),
                'unid_faturamento' => $this->input->post('unid_faturamento'),
                'contrato' => $this->input->post('contrato'),
                 'nf_venda_dev' => $nf_venda_dev,
                'nf_cliente' => $nf_cliente,
                'numero_nf' => $numero_nf,
                'numpedido_os' => $numpedido_os,
                'tag' => $tag
                
                
            );
			$data2 = array(
                'descricao_item' => $this->input->post('descricao_os')
                
            );

			$this->data['result'] = $this->os_model->getByid_table($this->input->post('idOs2'),'os','idOs');	
		$descricao = serialize($this->data['result']);
                $this->salvarlog($this->session->userdata('idUsuarios'),'os','editar',$descricao,$this->input->post('idOs2') );
				
			

            if ($this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs2')) == TRUE) {
				
				$this->data['result'] = $this->os_model->getByid_table($this->input->post('idOrcamento_item'),'orcamento_item','idOrcamento_item');	
		$descricao = serialize($this->data['result']);
                $this->salvarlog($this->session->userdata('idUsuarios'),'orcamento_item','editar',$descricao,$this->input->post('idOrcamento_item') );	
				
				
				$this->orcamentos_model->edit('orcamento_item', $data2, 'idOrcamento_item', $this->input->post('idOrcamento_item'))	;	
				
				
				
                $this->session->set_flashdata('success','Os editada com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs2'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
				redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs2'));
            }
        }

        /*$this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['anexos'] = $this->os_model->getAnexos($this->uri->segment(3));
        $this->data['view'] = 'os/editarOs';
        $this->load->view('tema/topo', $this->data);*/
   
    }
	
	 public function editar_anexo() {
        
	
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'adesenhoOs')){
           $this->session->set_flashdata('error','Você não tem permissão para editar desenho.');
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
	
     
           
           
            if ($this->os_model->edit('anexo_desenho', $data, 'idAnexo', $this->input->post('idAnexo')) == TRUE) {
               
               /* $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumo','editar',$descricao );
               */
               
                $this->session->set_flashdata('success','Desenho editado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
            
	 }
    }
	 public function excluiranexo(){
    	

    	$id = $this->input->post('idAnexo');
    	
    	$idOs = $this->input->post('idOs');
    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
           redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
    	}

		$imagem = $this->input->post('imagem');
    	if( $this->os_model->getimagem_base($id,$imagem,'anexo_desenho') == true)
		{
			$this->session->set_flashdata('error','Esse arquivo não pode ser excluido , pois ele esta vinculado a outra OS.');
          redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
		}
		
		
    	$file = $this->os_model->getimagem($id);
		$this->db->where('idAnexo', $id);
		

    	
        
        if($this->db->delete('anexo_desenho')){
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

 public function editaobs_os() {
        
	
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
           $this->session->set_flashdata('error','Você não tem permissão para editar OS.');
           redirect(base_url().'index.php/os/visualizar/'.$this->input->post('idOs'));
        }
if($this->input->post('obs_os') <> '')
{
 $data = array(
                'idOs' => $this->input->post('idOs'),
                'obs_os' => $this->input->post('obs_os')
            );
	
}
else
{
	$data = array(
                'idOs' => $this->input->post('idOs'),
                'obs_controle' => ($this->input->post('obs_controle'))
            );
}
        

       
           
           
           

            
           
           
            if ($this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs')) == TRUE) {
               
               /* $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumo','editar',$descricao );
               */
               
                $this->session->set_flashdata('success','OBS editado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
            
        
    }



    public function visualizar(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar OS.');
           redirect(base_url());
        }
		

        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        
		$this->data['distribuir_os'] = $this->os_model->getmaterial_dist($this->uri->segment(3));
		
		$this->data['hrmaquina_os'] = $this->os_model->gethoramaquina($this->uri->segment(3));
		
		
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
$this->data['anexo_desenho'] = $this->os_model->getdesenho_os($this->uri->segment(3));
//$this->data['usuario'] = $this->os_model->getdesenho_os($this->uri->segment(3));
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

        $this->data['view'] = 'os/visualizarOs';
        $this->load->view('tema/topo', $this->data);
       
    }
	 public function distribuiros(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eDistribuirOs')){
           $this->session->set_flashdata('error','Você não tem permissão para Distribuir OS.');
           redirect(base_url());
        }
		

        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        
		$this->data['distribuir_os'] = $this->os_model->getmaterial_dist($this->uri->segment(3));
		$this->data['dados_statusgrupo'] = $this->os_model->getstatus_grupo('');
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
	
	


	 public function maquinas(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eHoramaquinas')){
           $this->session->set_flashdata('error','Você não tem permissão para editar hr/maquinas OS.');
           redirect(base_url());
        }
		

        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        
		$this->data['hrmaquina_os'] = $this->os_model->gethoramaquina($this->uri->segment(3));
		
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

        $this->data['view'] = 'os/maquinas';
        $this->load->view('tema/topo', $this->data);
       
    }
	public function autoCompleteDistribuir(){


        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
             //$campo = $_GET['campo'];
			
            $this->os_model->autoCompleteDistribuir($q);
        }
		if (isset($_GET['term2'])){
            $q = strtolower($_GET['term2']);
             //$campo = $_GET['campo'];
			
            $this->os_model->autoCompleteDistribuir($q);
        }
			

    }
	public function autoCompleteDistribuir2(){


        if (isset($_GET['dados2'])){
            $q = strtolower($_GET['dados2']);
             //$campo = $_GET['campo'];
			
            $this->os_model->autoCompleteDistribuir($q);
        }
		
			

    }
	public function autoCompleteMaquina(){

      
		if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
             //$campo = $_GET['campo'];
			
            $this->os_model->autoCompleteMaquina($q);
        }
			

    }
	public function autoCompleteMaquinauser(){

       
		if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
             //$campo = $_GET['campo'];
			
            $this->os_model->autoCompleteMaquinauser($q);
        }
			

    }
	public function cad_distribuir() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eDistribuirOs')){
          $this->session->set_flashdata('error','Você não tem permissão para distribuir OS.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('idOs', '', 'trim|required|xss_clean');
		
        
        $this->form_validation->set_rules('quantidade', '', 'trim|required|xss_clean');
  $almox = $this->input->post('almoxarifado');
      
if(empty($almox))
				{	  
    $this->form_validation->set_rules('idInsumos2', '', 'trim|required|xss_clean');
	$insumoid = $this->input->post('idInsumos2');
				}
				else{
					 $this->form_validation->set_rules('idInsumos__2', '', 'trim|required|xss_clean');
					 $insumoid = $this->input->post('idInsumos__2');
				}
   	
 if($this->input->post('idgrupo') == 0)
{
	$this->session->set_flashdata('error','Informe o grupo!');
	if(empty($almox))
				{
			redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
			}
			else{
				redirect(base_url() . 'index.php/almoxarifado');
                
			}
			
			
               
}

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe os dados!');
			if(empty($almox))
				{
			redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
			}
			else{
				redirect(base_url() . 'index.php/almoxarifado');
                
			}
        } else {
  
        	if(empty($almox))
				{
					if($this->input->post('estoque') > 0)
					{
						$pedir = $this->input->post('quantidade') - $this->input->post('estoque');
						
						if($pedir >= 0 )
						{
							if($pedir == 0)
							{
								//$this->input->post('estoque') solicitar estoque 7
							
								


            $data = array(
                'idInsumos' => $insumoid,
                'dimensoes' => $this->input->post('dimensoes'),
                'id_status_grupo' => $this->input->post('idgrupo'),
                'idProdutos' => $this->input->post('idProdutos'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $this->input->post('quantidade'),
                'idOs' => $this->input->post('idOs'),
                'idStatuscompras' => 7
            );


			 if (is_numeric($id = $this->os_model->add('distribuir_os', $data, true)) ) {
				 
				 $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'distribuir_os','inserir',$descricao,$id );
			
				$dataup = "*".$this->session->userdata('nome')."|".date('d-m-Y H:i:s');
		$updalog = array(
                
                'histo_alteracao' => $dataup
                  
            );
		
		$this->os_model->edit('distribuir_os', $updalog, 'idDistribuir', $id);
	
		 
			
            //if ($this->os_model->add('distribuir_os', $data) == TRUE) {
				
				$datae = array(
                
                'id_os' => $this->input->post('idOs'),
                'id_produto' => $insumoid,
                'id_distribuir' => $id
                  
            );
 
	$id =	$this->os_model->add('estoque_reservado', $datae, true);
		
		$descricao = serialize($datae);
        $this->salvarlog($this->session->userdata('idUsuarios'),'estoque_reservado','inserir',$descricao ,$id);
				 
                $this->session->set_flashdata('success','Item de estoque adicionado com sucesso!');
				if(empty($almox))
				{
					redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
				}
				else
				{
					
                redirect(base_url() . 'index.php/almoxarifado');
				}
				
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
				
								
								
							}
							else
							{
								//$this->input->post('estoque') solicitar estoque 7
								//$pedir solicitar compras idStatuscompras = 1
								

            $data2 = array(
                'idInsumos' => $insumoid,
                'dimensoes' => $this->input->post('dimensoes'),
				 'id_status_grupo' => $this->input->post('idgrupo'),
                'idProdutos' => $this->input->post('idProdutos'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $this->input->post('estoque'),
                'idOs' => $this->input->post('idOs'),
                'idStatuscompras' => 7
            );
		
				 
				 
				$id2 = $this->os_model->add('distribuir_os', $data2, true);
				
				 $descricao = serialize($data2);
                $this->salvarlog($this->session->userdata('idUsuarios'),'distribuir_os','inserir',$descricao,$id2 );
				
		$dataup = "*".$this->session->userdata('nome')."|".date('d-m-Y H:i:s');
		$updalog = array(
                
                'histo_alteracao' => $dataup
                  
            );
		
		$this->os_model->edit('distribuir_os', $updalog, 'idDistribuir', $id2);
	
		 
		 
				$datae = array(
                
                'id_os' => $this->input->post('idOs'),
                'id_produto' => $insumoid,
                'id_distribuir' => $id2
                  
            );
		
		$id3 = $this->os_model->add('estoque_reservado', $datae, true);
		
		 $descricao = serialize($datae);
                $this->salvarlog($this->session->userdata('idUsuarios'),'estoque_reservado','inserir',$descricao,$id3 );

			 $data = array(
                'idInsumos' => $insumoid,
                'dimensoes' => $this->input->post('dimensoes'),
				 'id_status_grupo' => $this->input->post('idgrupo'),
                'idProdutos' => $this->input->post('idProdutos'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $pedir,
                'idOs' => $this->input->post('idOs')
                
            );
			if (is_numeric($id34 = $this->os_model->add('distribuir_os', $data, true)) ) {
           // if ($this->os_model->add('distribuir_os', $data) == TRUE) {
				
				 $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'distribuir_os','inserir',$descricao,$id34 );
				
				$dataup = "*".$this->session->userdata('nome')."|".date('d-m-Y H:i:s');
		$updalog = array(
                
                'histo_alteracao' => $dataup
                  
            );
		
		$this->os_model->edit('distribuir_os', $updalog, 'idDistribuir', $id34);
				
				
                $this->session->set_flashdata('success','Adicionado 2 itens com sucesso!');
				if(empty($almox))
				{
					redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
				}
				else
				{
					
                redirect(base_url() . 'index.php/almoxarifado');
				}
				
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
				
							}
							
						}
						else
						{
							//$this->input->post('quantidade')  //solicitar estoque 7
							

            $data = array(
                'idInsumos' => $insumoid,
                'dimensoes' => $this->input->post('dimensoes'),
				 'id_status_grupo' => $this->input->post('idgrupo'),
                'idProdutos' => $this->input->post('idProdutos'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $this->input->post('quantidade'),
                'idOs' => $this->input->post('idOs'),
                'idStatuscompras' => 7
            );


	 if (is_numeric($id3 = $this->os_model->add('distribuir_os', $data, true)) ) {
         
		  $descricao = serialize($data);
          $this->salvarlog($this->session->userdata('idUsuarios'),'distribuir_os','inserir',$descricao,$id3 );
			

	$dataup = "*".$this->session->userdata('nome')."|".date('d-m-Y H:i:s');
		$updalog = array(
                
                'histo_alteracao' => $dataup
                  
            );
		
		$this->os_model->edit('distribuir_os', $updalog, 'idDistribuir', $id3);


			
				$datae = array(
                
                'id_os' => $this->input->post('idOs'),
                'id_produto' => $insumoid,
                'id_distribuir' => $id3
                  
            );
		
	$id0 =  $this->os_model->add('estoque_reservado', $datae, true);
		
  $descricao = serialize($datae);
  $this->salvarlog($this->session->userdata('idUsuarios'),'estoque_reservado','inserir',$descricao,$id0 );
			
				
				
                $this->session->set_flashdata('success','Item adicionado com sucesso!');
				if(empty($almox))
				{
					redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
				}
				else
				{
					
                redirect(base_url() . 'index.php/almoxarifado');
				}
				
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
				
							
						}
						
						
					}
					else{
								


            $data = array(
                'idInsumos' => $insumoid,
                'dimensoes' => $this->input->post('dimensoes'),
				 'id_status_grupo' => $this->input->post('idgrupo'),
                'idProdutos' => $this->input->post('idProdutos'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $this->input->post('quantidade'),
                'idOs' => $this->input->post('idOs')
            );

		

			if (is_numeric($id3 = $this->os_model->add('distribuir_os', $data, true)) ) {
           // if ($this->os_model->add('distribuir_os', $data) == TRUE) {
				
				$descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'distribuir_os','inserir',$descricao,$id3 );	
				
				$dataup = "*".$this->session->userdata('nome')."|".date('d-m-Y H:i:s');
		$updalog = array(
                
                'histo_alteracao' => $dataup
                  
            );
		
		$this->os_model->edit('distribuir_os', $updalog, 'idDistribuir', $id3);
		
				/*$this->os_model->edit_concatena('distribuir_os', $this->session->userdata('idUsuarios')."-".date('d-m-Y H:i:s'), 'histo_alteracao','idDistribuir', $id3);*/
			
				
				
                $this->session->set_flashdata('success','Item adicionado com sucesso!');
				
				
				
				
				if(empty($almox))
				{
					redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
				}
				else
				{
					
                redirect(base_url() . 'index.php/almoxarifado');
				}
				
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
			
					}
					
					
					
				}
				else
				{		


            $data = array(
                'idInsumos' => $insumoid,
                'dimensoes' => $this->input->post('dimensoes'),
				 'id_status_grupo' => $this->input->post('idgrupo'),
                'idProdutos' => $this->input->post('idProdutos'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $this->input->post('quantidade'),
                'idOs' => $this->input->post('idOs')
            );


if (is_numeric($id1 = $this->os_model->add('distribuir_os', $data, true)) ) {
            //if ($this->os_model->add('distribuir_os', $data) == TRUE) {
				
				
				$descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'distribuir_os','inserir',$descricao,$id1 );
				
				$dataup = "*".$this->session->userdata('nome')."|".date('d-m-Y H:i:s');
		$updalog = array(
                
                'histo_alteracao' => $dataup
                  
            );
		
		$this->os_model->edit('distribuir_os', $updalog, 'idDistribuir', $id1);
		
				
                $this->session->set_flashdata('success','Item adicionado com sucesso!');
				if(empty($almox))
				{
					redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
				}
				else
				{
					
                redirect(base_url() . 'index.php/almoxarifado');
				}
				
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
			
			
		}
			
			
        }

        $this->data['view'] = 'os/distribuiros';
        $this->load->view('tema/topo', $this->data);

    }
	public function cad_horamaquina() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eHoramaquinas')){
          $this->session->set_flashdata('error','Você não tem permissão para cadastrar HR/Maquinas.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('idOs', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idMaquinas2', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idUserMaquinas2', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('horainiciod', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('horainicioh', '', 'trim|required|xss_clean');
        

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe os dados!');
                redirect(base_url() . 'index.php/os/maquinas/'.$this->input->post('idOs'));
				
        } else {
			
		 $dataini = $this->input->post('horainiciod');
		 
		 
		 
		 $datac = explode('/', $dataini);
         $datai = $datac[2].'-'.$datac[1].'-'.$datac[0];
		
		
		
        
			
        	$horaini = $this->input->post('horainicioh');

        	
        	$hrtotal =  $datai." ".$horaini;

            $data = array(
                'idos' => $this->input->post('idOs'),
                'obs' => $this->input->post('obs'),
                'horainicio' => $hrtotal,
                'idUserMaquinas' => $this->input->post('idUserMaquinas2'),
                
                'idMaquinas' => $this->input->post('idMaquinas2')
            );

            if ($this->os_model->add('horasmaquinas', $data) == TRUE) {
                $this->session->set_flashdata('success','Item adicionado com sucesso!');
				
					redirect(base_url() . 'index.php/os/maquinas/'.$this->input->post('idOs'));
				
				
				
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/maquinas';
        $this->load->view('tema/topo', $this->data);

    }
	public function editar_hrmaquinas() {
		

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eHoramaquinas')){
          $this->session->set_flashdata('error','Você não tem permissão para cadastrar HR/Maquinas.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('idOs', '', 'trim|required|xss_clean');
        
        $this->form_validation->set_rules('horainiciod', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('horainicioh', '', 'trim|required|xss_clean');
		
		$this->form_validation->set_rules('datafinal', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('horafinal', '', 'trim|required|xss_clean');
        

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe os dados!');
                redirect(base_url() . 'index.php/os/maquinas/'.$this->input->post('idOs'));
				
        } else {
			
		 $dataini = $this->input->post('horainiciod');
		  
		 $datac = explode('/', $dataini);
         $datai = $datac[2].'-'.$datac[1].'-'.$datac[0];
		 
		 $horaini = $this->input->post('horainicioh');
        	
         $hrtotal =  $datai." ".$horaini;
		
		
		 $datafim = $this->input->post('datafinal');
		 
		  
		 $dataf = explode('/', $datafim);
         $datafi = $dataf[2].'-'.$dataf[1].'-'.$dataf[0];
		 
		 $horafinal = $this->input->post('horafinal');
        	
         $hrtotalfim =  $datafi." ".$horafinal;
		 
		 
		

            $data = array(
                'idos' => $this->input->post('idOs'),
                'obs' => $this->input->post('obs'),
                'horainicio' => $hrtotal,
                'horafim' => $hrtotalfim,
               
               
            );

 if ($this->os_model->edit('horasmaquinas', $data, 'idHoramaquinas', $this->input->post('idHoramaquinas')) == TRUE) {
                $this->session->set_flashdata('success','Item editado com sucesso!');
                redirect(base_url() . 'index.php/os/maquinas/'.$this->input->post('idOs'));
				
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
		
		
            
        

        $this->data['view'] = 'os/maquinas';
        $this->load->view('tema/topo', $this->data);
    }
	public function editar_distribuiros() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eDistribuirOs')){
          $this->session->set_flashdata('error','Você não tem permissão para distribuir OS.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('idOs', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idInsumos', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantidade', '', 'trim|required|xss_clean');
   
if(empty($this->input->post('idProdutosa2')))
{
	$idProdutosa2 = 0;
}
else
{
	$idProdutosa2 = $this->input->post('idProdutosa2');
}



if($this->input->post('idgrupo') == 0)
{
	$this->session->set_flashdata('error','Informe o grupo!');
                redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
}

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe os dados necessarios!');
                redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
				
        } else {
  
        	

        	

            $data = array(
                'idInsumos' => $this->input->post('idInsumos'),  
                'id_status_grupo' => $this->input->post('idgrupo'),
                'idProdutos' => $idProdutosa2,
                'dimensoes' => $this->input->post('dimensoes'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $this->input->post('quantidade'),
                'data_alteracao' => date('Y-m-d H:i:s'),
                'idOs' => $this->input->post('idOs')
            );
		
		$this->data['result'] = $this->os_model->getByid_table($this->input->post('idDistribuir'),'distribuir_os','idDistribuir');	
		$descricao = serialize($this->data['result']);
                $this->salvarlog($this->session->userdata('idUsuarios'),'distribuir_os','editar',$descricao,$this->input->post('idDistribuir') );
				
			 
  if ($this->os_model->edit('distribuir_os', $data, 'idDistribuir', $this->input->post('idDistribuir')) == TRUE) {
	  
	   
         
		$dataup = "*".$this->session->userdata('nome')."|".date('d-m-Y H:i:s');
		
		
		$this->data['result']  = $this->os_model->getByid_table($this->input->post('idDistribuir'),'distribuir_os','idDistribuir');
	
		 $this->os_model->edit_concatena('distribuir_os',$dataup, 'idDistribuir', $this->input->post('idDistribuir'),$this->data['result']->histo_alteracao);
		
		
                $this->session->set_flashdata('success','Item editado com sucesso!');
                redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/distribuiros';
        $this->load->view('tema/topo', $this->data);

    }
	
	function excluir_item(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eDistribuirOs')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir item.');
           redirect(base_url());
        }

        
        $idDistribuir =  $this->input->post('idDistribuir');
        $idOs =  $this->input->post('idOs');
        if ($idDistribuir == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir item.'); 
			 redirect(base_url() . 'index.php/os/distribuiros/'.$idOs);	
            
        }
		
		if( $this->os_model->getitemcotacaoitem($idDistribuir) == false)
		{
			$this->data['result'] = $this->os_model->getByid_table($idDistribuir,'distribuir_os','idDistribuir');
        $descricao = serialize($this->data['result'] );
            $this->salvarlog($this->session->userdata('idUsuarios'),'distribuir_os','excluir',$descricao,$idDistribuir );
			
			
		

     
			$this->os_model->delete('distribuir_os','idDistribuir',$idDistribuir); 
			
			 $this->session->set_flashdata('success','Item excluido com sucesso!');            
        redirect(base_url() . 'index.php/os/distribuiros/'.$idOs);
		}
		else
		{
			 $this->session->set_flashdata('error','Item possui compra cadastrada.');
			  redirect(base_url() . 'index.php/os/distribuiros/'.$idOs);
		}
        
                  
        
        

       
    }
	function excluir_hmaquina(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eHoramaquinas')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir item.');
           redirect(base_url());
        }

        
         $idHoramaquinas =  $this->input->post('horamaquina2');
         $idOs =  $this->input->post('idOs');
        
		
        if ($idHoramaquinas == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir item.'); 
			 redirect(base_url() . 'index.php/os/maquinas/'.$idOs);	
            
        }
		

      
			$this->os_model->delete('horasmaquinas','idHoramaquinas',$idHoramaquinas); 
			
			 $this->session->set_flashdata('success','Item excluido com sucesso!');            
        redirect(base_url() . 'index.php/os/maquinas/'.$idOs);
		
		
        
                  
        
        

       
    }
	
	 public function imprimir_osproducao(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar OS.');
           redirect(base_url());
        }
		

        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
         $data['result'] = $this->os_model->OSCustom($this->uri->segment(3));
       

	
				$this->load->helper('mpdf');
           echo $html = $this->load->view('os/imprimir/imprimir_osproducao',$data,true);
       
    }
	public function cad_desenho() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'adesenhoOs')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar desenho.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe nome do arquivo!');
                redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
				
        } else {
  
        	$arquivo = $this->do_upload();

        	$imagem = $arquivo['file_name'];
        	//$path = $arquivo['full_path'];
			$caminho = 'assets/uploads/desenho/';
        	//$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
        	$tamanho = $arquivo['file_size'];
        	$extensao = $arquivo['file_ext'];

        	$nomeArquivo = $this->input->post('nomeArquivo');
        	$idOs = $this->input->post('idOs');
        	
        	

            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'imagem' => $imagem,
                'caminho' => $caminho,
                'tamanho' => $tamanho,
                'extensao' => $extensao,
                'user_proprietario' => $this->session->userdata('idUsuarios'),
                'idOs' => $idOs
            );

            if ($this->os_model->add('anexo_desenho', $data) == TRUE) {
                $this->session->set_flashdata('success','Arquivo adicionado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/'.$idOs);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/visualizar';
        $this->load->view('tema/topo', $this->data);

    }
	 function do_upload(){
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
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
			
			
            //$file_info = array($this->upload->data());
           // return $file_info[0]['file_name'];
        }

    }
	//pedido
	public function cad_nf() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'anotafiscalOs')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar nf.');
          redirect(base_url());
        }

$table = $this->input->post('table');
if($table == 'anexo_notafiscal')
{
	$directory = "nf";
}
elseif($table == 'anexo_nfcliente')
{
	$directory = "nfcliente";
}
else
{
	$directory = "nfvenda";
}

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe nome do arquivo!');
                redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
        } else {
  
        	$arquivo = $this->do_upload_nf($directory);

        	$imagem = $arquivo['file_name'];
        	//$path = $arquivo['full_path'];
			$caminho = 'assets/uploads/'.$directory.'/';
        	//$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
        	$tamanho = $arquivo['file_size'];
        	$extensao = $arquivo['file_ext'];

        	$nomeArquivo = $this->input->post('nomeArquivo');
        	$idOs = $this->input->post('idOs');
        	
        	

            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'imagem' => $imagem,
                'caminho' => $caminho,
                'tamanho' => $tamanho,
                'extensao' => $extensao,
                'idOs' => $idOs
            );

            if ($this->os_model->add($table, $data) == TRUE) {
                $this->session->set_flashdata('success','Arquivo adicionado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/'.$idOs);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/visualizar';
        $this->load->view('tema/topo', $this->data);

    }
	 function do_upload_nf($directory){
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

       

        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads/'.$directory;

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
			
			
            //$file_info = array($this->upload->data());
           // return $file_info[0]['file_name'];
        }

    }
	 public function editar_nf() {
        
	 $table = $this->input->post('table');
	
	
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'anotafiscalOs')){
           $this->session->set_flashdata('error','Você não tem permissão para editar nf.');
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
	
     
           
           
        //if ($this->os_model->edit('anexo_notafiscal', $data, 'idAnexo', $this->input->post('idAnexo')) == TRUE) {
        if ($this->os_model->edit($table, $data, 'idAnexo', $this->input->post('idAnexo')) == TRUE) {
               
               /* $descricao = serialize($data);
                $this->salvarlog($this->session->userdata('idUsuarios'),'insumo','editar',$descricao );
               */
               
                $this->session->set_flashdata('success','NF editado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
            
	 }
    }
	 public function excluirnf(){
    	

    	$id = $this->input->post('idAnexo');
    	$idOs = $this->input->post('idOs');
    	$table = $this->input->post('table');
    	if($id == null || !is_numeric($id)){
    		$this->session->set_flashdata('error','Erro! O arquivo não pode ser localizado.');
           redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
    	}

$imagem = $this->input->post('imagem');
    	if( $this->os_model->getimagem_base($id,$imagem,$table) == true)
		{
			$this->session->set_flashdata('error','Esse arquivo não pode ser excluido , pois ele esta vinculado a outra OS.');
          redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
		}
		
    	$file = $this->os_model->getimagemnf($id);

    	$this->db->where('idAnexo', $id);
        
        if($this->db->delete($table)){
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
	
	//pedido
	public function cad_pedido() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'apedidoOs')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar pedido.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nomeArquivo', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe nome do arquivo!');
                redirect(base_url() . 'index.php/os/visualizar/'.$this->input->post('idOs'));
        } else {
  
        	$arquivo = $this->do_upload_pedido();

        	$imagem = $arquivo['file_name'];
        	//$path = $arquivo['full_path'];
			$caminho = 'assets/uploads/pedido/';
        	//$url = base_url().'assets/arquivos/'.date('d-m-Y').'/'.$file;
        	$tamanho = $arquivo['file_size'];
        	$extensao = $arquivo['file_ext'];

        	$nomeArquivo = $this->input->post('nomeArquivo');
        	$idOs = $this->input->post('idOs');
        	
        	

            $data = array(
                'nomeArquivo' => $this->input->post('nomeArquivo'),
                'imagem' => $imagem,
                'caminho' => $caminho,
                'tamanho' => $tamanho,
                'extensao' => $extensao,
                'idOs' => $idOs
            );

            if ($this->os_model->add('anexo_pedido', $data) == TRUE) {
                $this->session->set_flashdata('success','Arquivo adicionado com sucesso!');
                redirect(base_url() . 'index.php/os/visualizar/'.$idOs);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/visualizar';
        $this->load->view('tema/topo', $this->data);

    }
	 function do_upload_pedido(){
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

       

        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads/pedido';

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
			
			
            //$file_info = array($this->upload->data());
           // return $file_info[0]['file_name'];
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
           'allowed_types' => '*', // formatos permitidos para anexos de os
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
	
	 private function salvarlog($usuario,$table,$acao,$descricao,$id_tb){

        //colocar na funçao que vai enviar $this->salvarlog($usuario,$table,$acao,$descricao)

        $data = array(
            'ag_id_responsavel' => $usuario,
            'ag_tabela' => $table,
            'id_tb' => $id_tb,
            'ag_acao_realizada' => $acao,
             'ag_descricao' => $descricao
        );

        $this->os_model->add('auditoria_geral', $data);
    }

}

