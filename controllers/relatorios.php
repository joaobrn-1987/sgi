<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relatorios extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
        
        $this->load->model('Relatorios_model','',TRUE);
        $this->data['menuRelatorios'] = 'Relatórios';

    }
 public function imprimir_pedido(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Pedido.');
           redirect(base_url());
        }
		

        $this->data['custom_error'] = '';
        $this->load->model('relatorios_model');
		
		

         $data['result'] = $this->relatorios_model->pedidoCustom($this->uri->segment(3));
       

	
				$this->load->helper('mpdf');
           echo $html = $this->load->view('relatorios/imprimir/imprimir_pedido',$data,true);
       
    }
    public function clientes(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_clientes';
       	$this->load->view('tema/topo',$this->data);
    }
	
	function rel_orcamento(){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOrcamento')){
           $this->session->set_flashdata('error','Você não tem permissão para ver relatorio de orçamento.');
           redirect(base_url());
        }
		
		
		$this->load->library('table');
		$this->load->library('pagination');
		$this->load->model('orcamentos_model');
		$this->load->model('almoxarifado_model');
		$this->load->model('os_model');
		$this->load->model('relatorios_model');

		$idUser = $this->session->userdata('idUsuarios');
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
             
		$this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
		$this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
	
		$this->data['dados_vendedor']= $this->orcamentos_model->getVendedor();
		//$this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
		$this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
		$this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
		$this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();
		 
		 /* $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
  $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
		 $this->data['status_os']= $this->os_model->getStatusOs();*/
		 $petrolina = false;
		 $uberlandia = false;
		 if(count($getUserEmpresa)>0){
			foreach($getUserEmpresa as $r){
				if($r->id == 1 || $r->id == 3){
					$uberlandia	= true;
				}
				if($r->id == 2){
					$petrolina = true;
				}
			}
			if($uberlandia == true && $petrolina == true){
				$this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
			}else if($uberlandia == true){
				//$this->data['dados_clientes'] = $this->orcamentos_model->getCliente3();
				$this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
			}else if($petrolina == true){
				$this->data['dados_clientes'] = $this->orcamentos_model->getCliente2();
			}
		 }else{
			$this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
		 }		 
		 $this->data['status_orcamento'] = $this->orcamentos_model->getCliente('');
		
		 
		 
         $config['base_url'] = base_url().'index.php/relatorios/rel_orcamento/';
            
          // $idProdutos = $this->input->post('idProdutos');
         //$idOs = $this->input->post('idOs');
         $cod_orc = $this->input->post('idOrcamentos');
         $referencia = $this->input->post('referencia');
         $num_pedido = $this->input->post('num_pedido');
         $num_nf = $this->input->post('num_nf');
        
             
         
		$clientes_id  = $this->input->post('clientes_id');
		$idstatusOrcamento = $this->input->post('idstatusOrcamento');
		$idNatOperacao = $this->input->post('idNatOperacao');
		$idGrupoServico = $this->input->post('idGrupoServico');
        
		
		

		$querydatacadastro = "";
		
		$dataInicialcad = $this->input->post('dataInicialcad');
		$dataFinalcad = $this->input->post('dataFinalcad');

		if(empty($dataInicialcad)){

            $date = new DateTime(); 

            $interval = new DateInterval('P3M');
            $dataInicialcad = $date->sub($interval)->format('d/m/Y');

            $dataFinalcad = new DateTime();
            $dataFinalcad = $dataFinalcad->format('d/m/Y');

            $data_entrega['data_ini']   = $dataInicialcad;
            $data_entrega['data_final'] = $dataFinalcad;
			$this->data['data_entrega']= $data_entrega;
        }else{
			$this->data['data_entrega']= null;
		}
		 if(!empty($dataInicialcad) && !empty($dataFinalcad))
		 {
			$dataInicialcad2 = explode('/', $dataInicialcad);
			$dataInicialcad2 = $dataInicialcad2[2].'-'.$dataInicialcad2[1].'-'.$dataInicialcad2[0];
			
			
			$dataFinalcad2 = explode('/', $dataFinalcad);
			$dataFinalcad2 = $dataFinalcad2[2].'-'.$dataFinalcad2[1].'-'.$dataFinalcad2[0];
			
			
			$querydatacadastro = " and orcamento.data_abertura BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
		 }  	
        
         
		
         //$idStatusOs = $this->input->post('idStatusOs');
		// $unid_execucao = $this->input->post('unid_execucao');
        //$unid_faturamento = $this->input->post('unid_faturamento');
         $status_orc = $this->input->post('status_orc');
        
		  $query_statusorc = "";
		 if(!empty($status_orc))
		{
			$conteudoo = $status_orc;
			$query_statusorc="(";
			$primeiroco = true;
			foreach($conteudoo as $status3orc)
			{
				if($primeiroco)
				{
					$query_statusorc.=$status3orc;
					$primeiroco = false;
				}
				else
				{
					$query_statusorc.=",".$status3orc;
				}
			}
			$query_statusorc .= ")";
		}
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
		}else{
			if($uberlandia==true && $petrolina == true){
				$query_clientes3 = '';
			}else{
				/*if($uberlandia == true){
					$query_clientes3 =  " and clientes.idClientes not in(706,702,711,528,540,519,543,581,684,635,517,580,575,532,516,10,551)";
				}else*/ if($petrolina == true){
					$query_clientes3 =  " and clientes.idClientes in(706,702,711,528,552,540,519,543,581,684,635,517,580,575,532,516,10,551)";
				}else{
					$query_clientes3 = '';
				}
			}			
			
		}
		
		 
		$query_idstatusOrcamento = "";
		 if(!empty($idstatusOrcamento))
		{
			$conteudow1 = $idstatusOrcamento;
			$query_idstatusOrcamento="(";
			$primeiro2w = true;
			foreach($conteudow1 as $statusorc3)
			{
				if($primeiro2w)
				{
					$query_idstatusOrcamento.=$statusorc3;
					$primeiro2w = false;
				}
				else
				{
					$query_idstatusOrcamento.=",".$statusorc3;
				}
			}
			$query_idstatusOrcamento .= ")";
		}
		
		 $query_idGrupoServico = "";
		 if(!empty($idGrupoServico))
		{
			$conteudow = $idGrupoServico;
			$query_idGrupoServico="(";
			$primeirow = true;
			foreach($conteudow as $grpo3)
			{
				if($primeirow)
				{
					$query_idGrupoServico.=$grpo3;
					$primeirow = false;
				}
				else
				{
					$query_idGrupoServico.=",".$grpo3;
				}
			}
			$query_idGrupoServico .= ")";
		}
		
		 $query_idNatOperacao = "";
		 if(!empty($idNatOperacao))
		{
			$conteudod = $idNatOperacao;
			$query_idNatOperacao="(";
			$primeirod = true;
			foreach($conteudod as $natoperacao3)
			{
				if($primeirod)
				{
					$query_idNatOperacao.=$natoperacao3;
					$primeirod = false;
				}
				else
				{
					$query_idNatOperacao.=",".$natoperacao3;
				}
			}
			$query_idNatOperacao .= ")";
		}
		$idProdutos = $this->input->post('idProdutos');

		$vendedor = $this->input->post('idVendedores');
        $query_vendedor = "";
        $primeirovend = true;
        if(!empty($vendedor)){
            $vendedor2 = "";
            foreach ($vendedor as $des) {
                if ($primeirovend) {
                    $vendedor2 = $des;
                    $primeirovend = false;
                } else {
                    $vendedor2 =  $vendedor2 . ',' . $des;
                }
            }
            $query_vendedor = " and orcamento.idVendedor IN($vendedor2)";
        }
		/* $query_status_producao = "";
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
		}*/
   
	
		 if (!empty($cod_orc) || !empty($referencia) ||  !empty($num_pedido) || !empty($num_nf)  || !empty($querydatacadastro) || !empty($query_statusorc) || !empty($num_pedido) || !empty($num_nf)  || !empty($query_clientes) || !empty($query_clientes) || !empty($query_idGrupoServico) || !empty($query_idNatOperacao) || !empty($query_idstatusOrcamento) || !empty($idProdutos) || !empty($query_clientes3) || !empty($query_vendedor)) { 
            
            $this->data['results'] = $this->relatorios_model->getWhereLikeos2( $cod_orc,$referencia,$num_pedido,$num_nf ,$querydatacadastro,$query_statusorc,$query_clientes,$query_idGrupoServico,$query_idNatOperacao,$query_idstatusOrcamento,$idProdutos,$query_clientes3,$query_vendedor);
			
			

             //$config['total_rows'] = $this->relatorios_model->numrowsWhereLikeos2($cod_orc,$referencia,$num_pedido,$num_nf ,$querydatacadastro,$query_statusorc,$query_clientes,$query_idGrupoServico,$query_idNatOperacao,$query_idstatusOrcamento,$idProdutos);
			 
			 //$this->data['result_status'] = $this->relatorios_model->getWhereLikeos_status($cod_orc,$referencia,$num_pedido,$num_nf ,$querydatacadastro,$query_statusorc,$query_clientes,$query_idGrupoServico,$query_idNatOperacao,$query_idstatusOrcamento,$idProdutos);
			 
			 /*
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
 
            */
        
            
         } else {

			/*
            $config['total_rows'] = $this->orcamentos_model->count('orcamento');
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
            
           
             $this->pagination->initialize($config); */
           

  			$this->data['results'] = $this->relatorios_model->getos2('orcamento','orcamento.idOrcamentos,orcamento.data_abertura,orcamento.validade,clientes.nomeCliente,vendedores.nomeVendedor,motivo_orcamento.motivo, status_orcamento.nome_status_orc,NatOperacao.nome as nomenat, grupo_servico.nome as nomeserv','',$config['per_page'],$this->uri->segment(3));

		 
		   	//$this->data['result_status'] = $this->relatorios_model->getWhereLikeos_status($this->uri->segment(3),'','','','','','','','');
   
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
       
	    $this->data['view'] = 'relatorios/rel_orcamento';
       	$this->load->view('tema/topo',$this->data);
       //$this->load->view('tema/rodape');
		
		
		
	}
	function ordemdecompra(){
		  if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOrdemcompra')){
           $this->session->set_flashdata('error','Você não tem permissão para ver relatorio de compra.');
           redirect(base_url());
        }
         $this->load->library('table');
         $this->load->library('pagination');
		 $this->load->model('orcamentos_model');
         $this->load->model('os_model');    
         $this->load->model('cotacao_model');    
         $this->load->model('pedidocompra_model');    
         $this->load->model('relatorios_model');    
         $this->load->model('fornecedores_model');    
         
		  $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
  		$this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
		 $this->data['status_os']= $this->os_model->getStatusOs();
		 $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
		 $this->data['dados_clientes'] = $this->orcamentos_model->getCliente('');
		 $this->data['dados_fornecedor'] = $this->fornecedores_model->getFornecedor('');
		 
		 $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
        // $config['base_url'] = base_url().'index.php/os/carteiraservico/';
            
         
         $idOs = $this->input->post('idOs');
         //$cod_orc = $this->input->post('idOrcamentos');
         $notafiscal = $this->input->post('notafiscal');
         //$clientes_id  = $this->input->post('clientes_id');
         $idFornecedores  = $this->input->post('idFornecedores');
         $os_1a13  = $this->input->post('os_1a13');
        // $idProdutos = $this->input->post('idProdutos');
		 
		$querydatacadastro = "";
		
		
		$dataInicialcad = $this->input->post('dataSolInicial');
		$dataFinalcad = $this->input->post('dataSolFinal');
		if(!empty($dataInicialcad) && !empty($dataFinalcad))
		{
			$dataInicialcad2 = explode('/', $dataInicialcad);
			$dataInicialcad2 = $dataInicialcad2[2].'-'.$dataInicialcad2[1].'-'.$dataInicialcad2[0];
			
			
			$dataFinalcad2 = explode('/', $dataFinalcad);
			$dataFinalcad2 = $dataFinalcad2[2].'-'.$dataFinalcad2[1].'-'.$dataFinalcad2[0];
			
			
			$querydatacadastro = " and distribuir_os.data_cadastro BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
		}
		$querydatacompra = "";
		
		
		$dataInicialcad = $this->input->post('dataComInicial');
		$dataFinalcad = $this->input->post('dataComFinal');
		if(!empty($dataInicialcad) && !empty($dataFinalcad))
		{
			$dataInicialcad2 = explode('/', $dataInicialcad);
			$dataInicialcad2 = $dataInicialcad2[2].'-'.$dataInicialcad2[1].'-'.$dataInicialcad2[0];
			
			
			$dataFinalcad2 = explode('/', $dataFinalcad);
			$dataFinalcad2 = $dataFinalcad2[2].'-'.$dataFinalcad2[1].'-'.$dataFinalcad2[0];
			
			
			$querydatacompra = " and pedido_comprasitens.data_cadastro BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
		} 

		
		$idPedidoCompra = $this->input->post('idPedidoCompra');
		
        
        $idPedidoCotacao = $this->input->post('idPedidoCotacao');
         
		
		 
		
		$queryos1a13 = "";
		if(!empty($os_1a13))
		{
			if($os_1a13 == 'nao')
			{
				$queryos1a13 = "and distribuir_os.idOs not in(1,2,3,4,5,6,7,8,9,10,11,12,13)";
			}
			else
			{
				$queryos1a13 = "and distribuir_os.idOs > 0";
			}
		}
		
		$query_fornecedor = "";
		
		
		//exit;
		 if(!empty($idFornecedores))
		{
			$conteudoc2 = $idFornecedores;
			
			
		$query_fornecedor="(";
		$primeiroc2 = true;
			foreach($conteudoc2 as $fornecedor3)
			{
				//echo $fornecedor3;
				//echo "<br>";
					if($primeiroc2 == true)
					{
						$query_fornecedor.=$fornecedor3;
						$primeiroc2 = false;
					}
					else
					{
						$query_fornecedor.=",".$fornecedor3;
					}
				//echo "--".$fornecedor3."--";
			}
			$query_fornecedor .= ")";
		}
		
		 $query_fornecedor;
		
		$query_statuscompra = "";
		 $idStatuscompras = $this->input->post('idStatuscompras');
		if(!empty($idStatuscompras))
		{
			$conteudo = $idStatuscompras;
			$query_statuscompra="(";
			$primeiro = true;
			foreach($conteudo as $status_compra3)
			{
				if($primeiro)
				{
					$query_statuscompra.=$status_compra3;
					$primeiro = false;
				}
				else
				{
					$query_statuscompra.=",".$status_compra3;
				}
			}
			$query_statuscompra .= ")";
		}
		 
		 
		$query_idgrupo = "";
		$idgrupo = $this->input->post('idgrupo');
		if(!empty($idgrupo))
		{
			$conteudo2 = $idgrupo;
			$query_idgrupo="(";
			$primeiro = true;
			foreach($conteudo2 as $idgrupo3)
			{
				if($primeiro)
				{
					$query_idgrupo.=$idgrupo3;
					$primeiro = false;
				}
				else
				{
					$query_idgrupo.=",".$idgrupo3;
				}
			}
			$query_idgrupo .= ")";
		}
		
		$pn = str_replace("","",$this->input->post("pn"));

		$descricao = $this->input->post("descricao");
	
		 
		if (!empty($idOs) || !empty($idPedidoCotacao) || !empty($query_statuscompra) || !empty($idPedidoCompra) || !empty($query_fornecedor) || !empty($notafiscal) || !empty($query_idgrupo) || !empty($queryos1a13)|| !empty($pn)|| !empty($descricao)) {
            
			$this->data['results'] = $this->relatorios_model->getWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$query_fornecedor,$notafiscal,$query_idgrupo,$queryos1a13,$querydatacadastro,$querydatacompra,$pn,$descricao);
			
			$config['total_rows'] = $this->relatorios_model->numrowsWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$query_fornecedor,$notafiscal,$query_idgrupo,$queryos1a13,$querydatacadastro,$querydatacompra);
			
			$config['per_page'] = 40000;
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
			$config['total_rows'] = count( $this->relatorios_model->getdistribuidorcount('distribuir_os','*','distribuir_os.idOs not in(1,2,3,4,5,6,7,8,9,10,11,12,13) and distribuir_os.idStatuscompras in(1,2,3,10,4)'));
			
			$config['per_page'] = 2000;
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
            $this->data['results'] = $this->relatorios_model->getdistribuidor('distribuir_os','*','distribuir_os.idOs not in(1,2,3,4,5,6,7,8,9,10,11,12,13) and distribuir_os.idStatuscompras in(1,2,3,10,4)',$config['per_page'],$this->uri->segment(3));
					 
        }
        
 
        
       
	    $this->data['view'] = 'relatorios/rel_carteiracompra';
       	$this->load->view('tema/topo',$this->data);
       
		
    }
	

    public function produtos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_produtos';
       	$this->load->view('tema/topo',$this->data);

    }

    public function clientesCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }

        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');

        $data['clientes'] = $this->Relatorios_model->clientesCustom($dataInicial,$dataFinal);

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirClientes', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), TRUE);
    
    }

    public function clientesRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de clientes.');
           redirect(base_url());
        }

        $data['clientes'] = $this->Relatorios_model->clientesRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirClientes', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), TRUE);
    }

    public function produtosRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $data['produtos'] = $this->Relatorios_model->produtosRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirProdutos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
    }

    public function produtosRapidMin(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $data['produtos'] = $this->Relatorios_model->produtosRapidMin();

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
        
    }

    public function produtosCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de produtos.');
           redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $estoqueInicial = $this->input->get('estoqueInicial');
        $estoqueFinal = $this->input->get('estoqueFinal');

        $data['produtos'] = $this->Relatorios_model->produtosCustom($precoInicial,$precoFinal,$estoqueInicial,$estoqueFinal);

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirProdutos', $data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), TRUE);
    }

    public function servicos(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_servicos';
       	$this->load->view('tema/topo',$this->data);

    }

    public function servicosCustom(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $data['servicos'] = $this->Relatorios_model->servicosCustom($precoInicial,$precoFinal);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirServicos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), TRUE);
    }

    public function servicosRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de serviços.');
           redirect(base_url());
        }

        $data['servicos'] = $this->Relatorios_model->servicosRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirServicos', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), TRUE);
    }

    public function os(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_os';
       	$this->load->view('tema/topo',$this->data);
    }

    public function osRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }

        $data['os'] = $this->Relatorios_model->osRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }

    public function osCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de OS.');
           redirect(base_url());
        }
        
        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $cliente = $this->input->get('cliente');
        $responsavel = $this->input->get('responsavel');
        $status = $this->input->get('status');
        $data['os'] = $this->Relatorios_model->osCustom($dataInicial,$dataFinal,$cliente,$responsavel,$status);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }


    public function financeiro(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }

        $this->data['view'] = 'relatorios/rel_financeiro';
        $this->load->view('tema/topo',$this->data);
    
    }


    public function financeiroRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }

        $data['lancamentos'] = $this->Relatorios_model->financeiroRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), TRUE);
    }

    public function financeiroCustom(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios financeiros.');
           redirect(base_url());
        }

        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $tipo = $this->input->get('tipo');
        $situacao = $this->input->get('situacao');

        $data['lancamentos'] = $this->Relatorios_model->financeiroCustom($dataInicial,$dataFinal,$tipo,$situacao);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirFinanceiro', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirFinanceiro', $data, true);
        pdf_create($html, 'relatorio_financeiro' . date('d/m/y'), TRUE);
    }



    public function vendas(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }

        $this->data['view'] = 'relatorios/rel_vendas';
        $this->load->view('tema/topo',$this->data);
    }

    public function vendasRapid(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $data['vendas'] = $this->Relatorios_model->vendasRapid();

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'relatorio_vendas' . date('d/m/y'), TRUE);
    }

    public function vendasCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para gerar relatórios de vendas.');
           redirect(base_url());
        }
        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $cliente = $this->input->get('cliente');
        $responsavel = $this->input->get('responsavel');

        $data['vendas'] = $this->Relatorios_model->vendasCustom($dataInicial,$dataFinal,$cliente,$responsavel);
        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirOs', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirVendas', $data, true);
        pdf_create($html, 'relatorio_vendas' . date('d/m/y'), TRUE);
    }
	public function relcompras(){
		$where = '';
		if(empty($this->uri->segment(3))){
			$select = "fornecedores.nomeFornecedor as 'Fornecedor',";
			$groupby = "group by fornecedores.idFornecedores";
		}else{
			$select = "";
			$groupby = "";
			
			if(!empty($this->input->post('dataInicial')) && !empty($this->input->post('dataFinal'))){
				$this->data['dataInicial'] = $this->input->post('dataInicial');
				$this->data['dataFinal'] = $this->input->post('dataFinal');
				$dataInicial = explode('/',$this->input->post('dataInicial'));
				$dataFinal = explode('/',$this->input->post('dataFinal'));
				$where = $where." and date(distribuir_os.data_cadastro) between '".$dataInicial[2]."-".$dataInicial[1]."-".$dataInicial[0]."' and '".$dataFinal[2]."-".$dataFinal[1]."-".$dataFinal[0]."' ";
			}
			if(!empty($this->input->post('dataEntInicial')) && !empty($this->input->post('dataEntFinal'))){
				$this->data['dataEntInicial'] = $this->input->post('dataEntInicial');
				$this->data['dataEntFinal'] = $this->input->post('dataEntFinal');
				$dataEntInicial = explode('/',$this->input->post('dataEntInicial'));
				$dataEntFinal = explode('/',$this->input->post('dataEntFinal'));
				$where = $where." and date(pedido_comprasitens.datastatusentregue) between '".$dataEntInicial[2]."-".$dataEntInicial[1]."-".$dataEntInicial[0]."' and '".$dataEntFinal[2]."-".$dataEntFinal[1]."-".$dataEntFinal[0]."' ";
			}
			if(!empty($this->input->post('agrupar'))){
				$primeiroGroupBy = true;
				$this->data['agrupar'] = $this->input->post('agrupar');
				foreach($this->input->post('agrupar') as $r){
					if($r == 'fornecedores'){
						$select = $select."fornecedores.nomeFornecedor as 'Fornecedor',";
						if($primeiroGroupBy){
							$groupby = "group by fornecedores.idFornecedores";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", fornecedores.idFornecedores";
						}
						if(!empty($this->input->post('idFornecedores'))){
							$this->data['idFornecedores'] = $this->input->post('idFornecedores');
							$primeiroFornecedor= true;
							$fornecedores = '';
							foreach($this->input->post('idFornecedores') as $f){
								if($primeiroFornecedor){
									$fornecedores = $f;
									$primeiroFornecedor = false;
								}else{
									$fornecedores = $fornecedores.','.$f;
								}
							}
							if(!empty($fornecedores)){
								$where = $where." and fornecedores.idFornecedores in ($fornecedores)";
							}							
						}						
					}
					if($r == 'clientes'){
						$select = $select."clientes.nomeCliente as 'Cliente',";
						if($primeiroGroupBy){
							$groupby = "group by clientes.idClientes";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", clientes.idClientes";
						}
						if(!empty($this->input->post('idClientes'))){
							$this->data['idClientes'] = $this->input->post('idClientes');
							$primeiroCliente= true;
							$cliente = '';
							foreach($this->input->post('idClientes') as $f){
								if($primeiroCliente){
									$cliente = $f;
									$primeiroCliente = false;
								}else{
									$cliente = $cliente.','.$f;
								}
							}
							if(!empty($cliente)){
								$where = $where." and clientes.idClientes in ($cliente)";
							}							
						}						
					}
					if($r == 'categorias'){
						$select = $select."categoriaInsumos.descricaoCategoria as 'Categoria de Insumos',";
						if($primeiroGroupBy){
							$groupby = "group by categoriaInsumos.idCategoria";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", categoriaInsumos.idCategoria";
						}
						if(!empty($this->input->post('idCategorias'))){
							$this->data['idCategorias'] = $this->input->post('idCategorias');
							$primeiroCategoria= true;
							$categoria = '';
							foreach($this->input->post('idCategorias') as $f){
								if($primeiroCategoria){
									$categoria = $f;
									$primeiroCategoria = false;
								}else{
									$categoria = $categoria.','.$f;
								}
							}
							if(!empty($categoria)){
								$where = $where." and categoriaInsumos.idCategoria in ($categoria)";
							}							
						}						
					}
					if($r == 'insumos'){
						$select = $select."insumos.descricaoInsumo as 'Insumos',";
						if($primeiroGroupBy){
							$groupby = "group by insumos.idInsumos";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", insumos.idInsumos";
						}
						if(!empty($this->input->post('idInsumos'))){
							$this->data['idInsumos'] = $this->input->post('idInsumos');
							$primeiroInsumo= true;
							$insumo = '';
							foreach($this->input->post('idInsumos') as $f){
								if($primeiroInsumo){
									$insumo = $f;
									$primeiroInsumo = false;
								}else{
									$insumo = $insumo.','.$f;
								}
							}
							if(!empty($insumo)){
								$where = $where." and insumos.idInsumos in ($insumo)";
							}							
						}						
					}
					if($r == 'grupoCompra'){
						$select = $select."status_grupo_compra.nomegrupo as 'Grupo de Compra',";
						if($primeiroGroupBy){
							$groupby = "group by status_grupo_compra.idgrupo";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", status_grupo_compra.idgrupo";
						}
						if(!empty($this->input->post('idGrupocompras'))){
							$this->data['idGrupocompras'] = $this->input->post('idGrupocompras');
							$primeiroGrupo= true;
							$grupo = '';
							foreach($this->input->post('idGrupocompras') as $f){
								if($primeiroGrupo){
									$grupo = $f;
									$primeiroGrupo = false;
								}else{
									$grupo = $grupo.','.$f;
								}
							}
							if(!empty($grupo)){
								$where = $where." and status_grupo_compra.idgrupo in ($grupo)";
							}							
						}						
					}
					if($r == 'os'){
						$select = $select."os.idOs as 'Ordem de Serviço',";
						if($primeiroGroupBy){
							$groupby = "group by os.idOs";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", os.idOs";
						}
						if(!empty($this->input->post('listOs'))){
							$this->data['listOs'] = $this->input->post('listOs');
							$where = $where." and os.idOs in (".$this->input->post('listOs').")";												
						}						
					}/*else{
						$select = $select."group_concat(DISTINCT os.idOs) as 'O.S. Vinculadas',";
					}*/
					if($r == 'pc'){
						$select = $select."pedido_compras.idPedidoCompra as 'Ordem de Compra',";
						if($primeiroGroupBy){
							$groupby = "group by pedido_compras.idPedidoCompra";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", pedido_compras.idPedidoCompra";
						}
						if(!empty($this->input->post('listPc'))){
							$this->data['listPc'] = $this->input->post('listPc');
							$where = $where." and pedido_compras.idPedidoCompra in (".$this->input->post('listPc').")";												
						}						
					}
				}
			}
		}
		$this->data['grupocompra'] = $this->Relatorios_model->grupoCompraRapid();
		$this->data['insumos'] = $this->Relatorios_model->insumoRapid();
		$this->data['categorias'] = $this->Relatorios_model->categoriaRapid();
		$this->data['fornecedores'] = $this->Relatorios_model->fornecedoresRapid();
		$this->data['clientes'] = $this->Relatorios_model->clientesRapid();
		$this->data['relatorio'] = $this->Relatorios_model->relatorioComprasMelhorado($select,$groupby,$where);
		//echo '<script>console.log('.json_encode($this->data['relatorio']).')</script>';
		$this->data['view'] = 'relatorios/rel_compras';
        $this->load->view('tema/topo',$this->data);
	}
	public function relcomercial(){
		$where = '';
		if(empty($this->uri->segment(3))){
			$select = "vendedores.nomeVendedor as 'Vendedor',";
			$where = " and os.idStatusOs != 44";
			$groupby = "group by vendedores.idVendedor";
		}else{
			$select = "";
			$groupby = "";
			if(!empty($this->input->post('dataOrcInicial')) && !empty($this->input->post('dataOrcFinal'))){
				$this->data['dataOrcInicial'] = $this->input->post('dataOrcInicial');
				$this->data['dataOrcFinal'] = $this->input->post('dataOrcFinal');
				$dataOrcInicial = explode('/',$this->input->post('dataOrcInicial'));
				$dataOrcFinal = explode('/',$this->input->post('dataOrcFinal'));
				$where = $where." and date(orcamento.data_abertura) between '".$dataOrcInicial[2]."-".$dataOrcInicial[1]."-".$dataOrcInicial[0]."' and '".$dataOrcFinal[2]."-".$dataOrcFinal[1]."-".$dataOrcFinal[0]."' ";
			}
			if(!empty($this->input->post('dataAberInicial')) && !empty($this->input->post('dataAberFinal'))){
				$this->data['dataAberInicial'] = $this->input->post('dataAberInicial');
				$this->data['dataAberFinal'] = $this->input->post('dataAberFinal');
				$dataAberInicial = explode('/',$this->input->post('dataAberInicial'));
				$dataAberFinal = explode('/',$this->input->post('dataAberFinal'));
				$where = $where." and date(os.data_abertura) between '".$dataAberInicial[2]."-".$dataAberInicial[1]."-".$dataAberInicial[0]."' and '".$dataAberFinal[2]."-".$dataAberFinal[1]."-".$dataAberFinal[0]."' ";
			}
			if(!empty($this->input->post('dataEntrInicial')) && !empty($this->input->post('dataEntrFinal'))){
				$this->data['dataEntrInicial'] = $this->input->post('dataEntrInicial');
				$this->data['dataEntrFinal'] = $this->input->post('dataEntrFinal');
				$dataEntrInicial = explode('/',$this->input->post('dataEntrInicial'));
				$dataEntrFinal = explode('/',$this->input->post('dataEntrFinal'));
				$where = $where." and date(os.data_entrega) between '".$dataEntrInicial[2]."-".$dataEntrInicial[1]."-".$dataEntrInicial[0]."' and '".$dataEntrFinal[2]."-".$dataEntrFinal[1]."-".$dataEntrFinal[0]."' ";
			}
			if(!empty($this->input->post('dataFatInicial')) && !empty($this->input->post('dataFatFinal'))){
				$this->data['dataFatInicial'] = $this->input->post('dataFatInicial');
				$this->data['dataFatFinal'] = $this->input->post('dataFatFinal');
				$dataFatInicial = explode('/',$this->input->post('dataFatInicial'));
				$dataFatFinal = explode('/',$this->input->post('dataFatFinal'));
				$where = $where." and date(os.data_nf_faturamento) between '".$dataFatInicial[2]."-".$dataFatInicial[1]."-".$dataFatInicial[0]."' and '".$dataFatFinal[2]."-".$dataFatFinal[1]."-".$dataFatFinal[0]."' ";
			}
			if(!empty($this->input->post('agrupar'))){
				$primeiroGroupBy = true;
				$this->data['agrupar'] = $this->input->post('agrupar');
				foreach($this->input->post('agrupar') as $r){
					if($r == 'vendedores'){
						$select = $select."vendedores.nomeVendedor as 'Vendedor',";
						if($primeiroGroupBy){
							$groupby = "group by vendedores.nomeVendedor";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", vendedores.idVendedor";
						}
						if(!empty($this->input->post('idVendedores'))){
							$this->data['idVendedores'] = $this->input->post('idVendedores');
							$primeiroVendedor= true;
							$vendedor = '';
							foreach($this->input->post('idVendedores') as $f){
								if($primeiroVendedor){
									$vendedor = $f;
									$primeiroVendedor = false;
								}else{
									$vendedor = $vendedor.','.$f;
								}
							}
							if(!empty($vendedor)){
								$where = $where." and vendedores.idVendedor in ($vendedor)";
							}
						}
					}
					if($r == 'clientes'){
						$select = $select."clientes.nomeCliente as 'Cliente',";
						if($primeiroGroupBy){
							$groupby = "group by clientes.idClientes";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", clientes.idClientes";
						}
						if(!empty($this->input->post('idClientes'))){
							$this->data['idClientes'] = $this->input->post('idClientes');
							$primeiroCliente= true;
							$cliente = '';
							foreach($this->input->post('idClientes') as $f){
								if($primeiroCliente){
									$cliente = $f;
									$primeiroCliente = false;
								}else{
									$cliente = $cliente.','.$f;
								}
							}
							if(!empty($cliente)){
								$where = $where." and clientes.idClientes in ($cliente)";
							}							
						}						
					}
					if($r == 'statusOs'){
						$select = $select."status_os.nomeStatusOs as 'Status O.S.',";
						if($primeiroGroupBy){
							$groupby = "group by status_os.idStatusOs";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", status_os.idStatusOs";
						}
						if(!empty($this->input->post('idStatusOs'))){
							$this->data['idStatusOs'] = $this->input->post('idStatusOs');
							$primeiroStatusos= true;
							$statusOs = '';
							foreach($this->input->post('idStatusOs') as $f){
								if($primeiroStatusos){
									$statusOs = $f;
									$primeiroStatusos = false;
								}else{
									$statusOs = $statusOs.','.$f;
								}
							}
							if(!empty($statusOs)){
								$where = $where." and status_os.idStatusOs in ($statusOs)";
							}							
						}						
					}
					if($r == 'os'){
						$select = $select."os.idOs as 'Ordem de Serviço',";
						if($primeiroGroupBy){
							$groupby = "group by os.idOs";
							$primeiroGroupBy = false;
						}else{
							$groupby = $groupby.", os.idOs";
						}
						if(!empty($this->input->post('listOs'))){
							$this->data['listOs'] = $this->input->post('listOs');
							$where = $where." and os.idOs in (".$this->input->post('listOs').")";												
						}						
					}/*else{
						$select = $select."group_concat(DISTINCT os.idOs) as 'O.S. Vinculadas',";
					}*/
				}

			}
		}		
		$this->data['relatorio'] = $this->Relatorios_model->relatorioComercial($select,$groupby,$where);
		$this->data['clientes'] = $this->Relatorios_model->clientesRapid();
		$this->data['vendedores'] = $this->Relatorios_model->vendedoresRapid();
		$this->data['statusOs'] = $this->Relatorios_model->get("status_os","*");
		$this->data['view'] = 'relatorios/rel_comercial';
        $this->load->view('tema/topo',$this->data);
	}
	function relfaturamento(){
		$this->load->model('os_model');   
		$this->load->model('pedidocompra_model'); 
		$this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
		$this->data['clientes'] = $this->Relatorios_model->clientesRapid();
		$this->data['vendedores'] = $this->Relatorios_model->vendedoresRapid();
		if(!empty($this->input->post('data_inicio'))){
			$data = explode("/",$this->input->post('data_inicio'));
			$data_inicio = $data[2]."-".$data[1]."-".$data[0];
		}
		if(!empty($this->input->post('data_fim'))){
			$data = explode("/",$this->input->post('data_fim'));
			$data_fim = $data[2]."-".$data[1]."-".$data[0];
		}
		if((!empty($this->input->post('data_inicio')) && !empty($this->input->post('data_fim'))) || !empty($this->input->post('unid_execucao'))  || !empty($this->input->post('cliente')) || !empty($this->input->post('contrato')) || !empty($this->input->post('idVendedor'))){
			if(!empty($this->input->post('data_inicio')) && !empty($this->input->post('data_fim'))){
				$dataPeriodo = ' and os.data_entrega BETWEEN "'.$data_inicio.'" and "'.$data_fim.'"';
			}else{
				$dataPeriodo = '';
			}
			if(!empty($this->input->post('unid_execucao'))){
				$unidExec = ' and os.unid_execucao in (';
				$primeiroUnidExec = true;
				foreach($this->input->post('unid_execucao') as $v){
					if($primeiroUnidExec){
						$primeiroUnidExec = false;
						$unidExec .= $v;
					}else{
						$unidExec .= ','.$v;
					}
				}
				$unidExec .= ')';
			}else{
				$unidExec = '';
			}
			if(!empty($this->input->post('idVendedor'))){
				$vendedor = ' and orcamento.idVendedor ='.$this->input->post('idVendedor');
			}else{
				$vendedor = '';
			}
			if(!empty($this->input->post('cliente'))){
				$cliente = ' and clientes.nomeCliente like "%'.$this->input->post('cliente').'%"';
			}else{
				$cliente = '';
			}
			if(!empty($this->input->post('contrato'))){
				$contrato = ' and os.contrato = "'.$this->input->post('contrato').'"';
			}else{
				$contrato = '';
			}
			$listOs = $this->Relatorios_model->relatorioEdivan2($dataPeriodo, $unidExec, $vendedor, $cliente, $contrato);
		}else{
			$dataPeriodo = ' and os.data_entrega BETWEEN "2020-01-01" and "2040-12-31"';
			$listOs = $this->Relatorios_model->relatorioEdivan2($dataPeriodo);
		}
		foreach($listOs as $r){
			$somaQtd = 0;
			$somaValor = 0;
			$r->osvinculadas = "";
			$os_vinculada = $this->os_model->os_vinculada($r->idOs);
			foreach($os_vinculada as $e){
				if($e->idOs_principal == $r->idOs){
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_gerada);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_gerada,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_gerada." / "; 

				}else{
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_principal);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_principal,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_principal." / ";
				}
				
			}
			$somaValor += $r->valorInsumos;
			$osAtual = $this->Relatorios_model->get("os"," * ","os.idOs = ".$r->idOs,1,null,true);
			$somaQtd += $osAtual->qtd_os;
			$result = $somaValor/$somaQtd;
			$r->valorInsumos = $result*$osAtual->qtd_os;
			$r->valorInsumos = str_replace(".",",",$r->valorInsumos);
			$r->valorOrc = str_replace(".",",",$r->valorOrc);
			$r->valorOS = str_replace(".",",",$r->valorOS);
		}
		$this->data['listOs'] = $listOs;
		$this->data['view'] = 'relatorios/rel_faturamento';
        $this->load->view('tema/topo',$this->data);
	}

	/**/
	public function infoHoras(){
		$this->load->model('os_model');   
        $this->load->model('pedidocompra_model');
        $this->load->model('producao_model');

		$where = "";
		if(!empty($this->input->post('idOrcamento'))){
			$where = " and orcamento_item.idOrcamentos = ".$this->input->post('idOrcamento');
		}
		if(!empty($this->input->post('idOs'))){
			$where = " and os.idOs = ".$this->input->post('idOs');
		}
		if(!empty($this->input->post('pn'))){
			$where = " and produtos.pn = '".$this->input->post('pn')."'";
		}
		if(!empty($this->input->post('descricaoOrc'))){
			$where = " and orcamento_item.descricao_item like '%".$this->input->post('descricaoOrc')."%'";
		}

		$osServ = $this->Relatorios_model->getOsInfoHorasServ($where);
		$osFab = $this->Relatorios_model->getOsInfoHorasFab($where);
		
		foreach($osServ as $c){
			$distribuir = $this->os_model->getDistribuirByIdOs($c->idOs);

			//Calcula o tempo em que foi cadastrados os desenhos
			if(!empty($c->data_solicitar_desenho) && !empty($c->data_finalizado_desenho)){
				$inicio_desenho = new DateTime($c->data_solicitar_desenho);
				$fim_desenho = new DateTime($c->data_finalizado_desenho);
				$diffDataDesenho = $fim_desenho->diff($inicio_desenho);
				$diasHoras = 0;
				if($diffDataDesenho->d > 0){
					$diasHoras = intval($diffDataDesenho->d*24);
				}
				$c->horasGastaDesenho = ($diffDataDesenho->h+$diasHoras).":".(strlen($diffDataDesenho->i)>1?$diffDataDesenho->i:"0".$diffDataDesenho->i).":".(strlen($diffDataDesenho->s)>1?$diffDataDesenho->s:"0".$diffDataDesenho->s);
			}

			//Calcula o tempo em que foi realizado a peritagem
			if(!empty($c->data_finalizado_desenho) && !empty($c->data_finalizado_peritagem)){
				$inicio_peritagem = new DateTime($c->data_finalizado_desenho);
				$fim_peritagem = new DateTime($c->data_finalizado_peritagem);
				$diffDataPeritagem = $fim_peritagem->diff($inicio_peritagem);
				$diasHoras = 0;
				if($diffDataPeritagem->d > 0){
					$diasHoras = intval($diffDataPeritagem->d*24);
				}
				$c->horasGastaPeritagem = ($diffDataPeritagem->h+$diasHoras).":".(strlen($diffDataPeritagem->i)>1?$diffDataPeritagem->i:"0".$diffDataPeritagem->i).":".(strlen($diffDataPeritagem->s)>1?$diffDataPeritagem->s:"0".$diffDataPeritagem->s);
			}else{
				$c->horasGastaPeritagem = "0:00:00";
			}

			//Calcula o intervalo de tempo do momento em que a O.S. ficou disponivel para o PCP até o cadastro do primeiro item			
			if(!empty($c->data_abertura_real) && !empty($distribuir)){
				$disponibilizado = new DateTime($c->data_abertura_real);
				$iniciado = new DateTime($distribuir[0]->data_cadastro);
				$diffPcp = $iniciado->diff($disponibilizado);
				$diasHoras = 0;
				if($diffPcp->d > 0){
					$diasHoras = intval($diffPcp->d*24);

				}
				$c->horasInicioPCP = ($diffPcp->h+$diasHoras).":".(strlen($diffPcp->i)>1?$diffPcp->i:"0".$diffPcp->i).":".(strlen($diffPcp->s)>1?$diffPcp->s:"0".$diffPcp->s);

			}else{
				$c->horasInicioPCP = "0:00:00";
			}

			//Calcula a média de tempo entre o intervalo entre a data de solicitação da compra e data em que foi gerado o pedido pelo suprimentos
			$distribuirComPedido = $this->pedidocompra_model->getDistribuirByIdOs2($c->idOs);
			if(!empty($distribuirComPedido)){
				$somaDias = 0;
				$somaHR = 0;
				$somaMIN = 0;
				$somaSEG = 0;
				$totalEmSEG = 0;
				$contagemPedido = 0;
				$horas = 0;
				$minutos = 0;
				$segundos = 0;
				foreach($distribuirComPedido as $r){	
									
					if(!empty($r->dataDistribuir) && !empty($r->dataPedido)){
						$disponibilizado = new DateTime($r->dataDistribuir);
						$iniciado = new DateTime($r->dataPedido);
						$diffPedidoCompra = $iniciado->diff($disponibilizado);

						$somaSEG = $somaSEG + $diffPedidoCompra->s;
						$somaMIN = $somaMIN + $diffPedidoCompra->i;
						$somaHR = $somaHR + $diffPedidoCompra->h;
						$somaDias = $somaDias + $diffPedidoCompra->d;
						
						$contagemPedido = $contagemPedido+1;	
						/*	
						if($c->idOs == 30796){
							echo '<script>console.log('.json_encode($diffPedidoCompra).')</script>';
							echo '<script>console.log('.($somaSEG + ($somaMIN*60) + ($somaHR*3600) + (($somaDias*24)*3600)).')</script>';
						}	*/	
					}
				}
				$totalEmSEG += 	$somaSEG + ($somaMIN*60) + ($somaHR*3600) + (($somaDias*24)*3600);/*
				if($c->idOs == 30796){
					echo '<script>console.log("Quantidade: '.$contagemPedido.' </br> Segundos: '.$totalEmSEG.'")</script>';
				}*/
				if($somaDias>0){
					$somaHR = $somaHR + ($somaDias*24);
				}
				if($totalEmSEG>0){
					$mediaTempo = intval($totalEmSEG/$contagemPedido);
					
					$horas = floor($mediaTempo / 3600);
					$minutos = floor(($mediaTempo - ($horas * 3600)) / 60);
					$segundos = floor($mediaTempo % 60);
				}
				if(!empty($segundos) || !empty($minutos) || !empty($horas)){
					$c->horasPedidoSup = ($horas).":".(strlen($minutos)>1?$minutos:"0".$minutos).":".(strlen($segundos)>1?$segundos:"0".$segundos);
				}else{
					$c->horasPedidoSup = "0:00:00";
				}
			}else{
				$c->horasPedidoSup = "0:00:00";
			}

			//
			$controle_etapa = $this->producao_model->getControleEtapaByIdOrcamento_item($c->idOrcamento_item);
			if(!empty($controle_etapa)){
				$controle_etapa_hist =$this->producao_model->getControleStatusHistByIdControleEtapa($controle_etapa->idControleEtapa);		
				$idRecebimento = null;
				$objRecebimento = null;
				$idOutroStatus = null;
				$objOutroStatus = null;

				$idDesmontagem = null;
				$objDesmontagem = null;
				$idOutroStatus2 = null;
				$objOutroStatus2 = null;
				if(!empty($controle_etapa_hist)){
					foreach($controle_etapa_hist as $r){
						if($r->idStatusEtapaServico == 2 && empty($idRecebimento)){
							$idRecebimento = 2;
							$objRecebimento = $r;
						}else if(!empty($idRecebimento) && $r->idStatusEtapaServico  != 2 && empty($idOutroStatus)){
							$idOutroStatus = $r->idStatusEtapaServico ;
							$objOutroStatus = $r;
						}
						if($r->idStatusEtapaServico  == 14 && empty($idDesmontagem)){
							$idDesmontagem = 2;
							$objDesmontagem = $r;
						}else if(!empty($idDesmontagem) && $r->idStatusEtapaServico  != 14 && empty($idOutroStatus2)){
							$idOutroStatus2 = $r->idStatusEtapaServico ;
							$objOutroStatus2 = $r;
						}
					}		
					$diasHoras = 0;
					if(!empty($idRecebimento) && !empty($idOutroStatus)){
						$dataRecebimento = new DateTime($objRecebimento->data_alteracao);
						$dataAlteracao = new DateTime($objOutroStatus->data_alteracao);
						$diffDataRecebimento = $dataAlteracao->diff($dataRecebimento);
						if($diffDataRecebimento->d>0){
							$diasHoras = intval($diffDataRecebimento->d*24);
						}
						$c->horasArmazenar = ($diffDataRecebimento->h+$diasHoras).":".(strlen($diffDataRecebimento->i)>1?$diffDataRecebimento->i:"0".$diffDataRecebimento->i).":".(strlen($diffDataRecebimento->s)>1?$diffDataRecebimento->s:"0".$diffDataRecebimento->s);
					}else{
						$c->horasArmazenar = "0:00:00";
					}
	
					$diasHoras =0;
					if(!empty($idDesmontagem) && !empty($idOutroStatus2)){
						$dataDesmontagem = new DateTime($objDesmontagem->data_alteracao);
						$dataAlteracao2 = new DateTime($objOutroStatus2->data_alteracao);
						$diffDataDesmontagem = $dataAlteracao2->diff($dataDesmontagem);
						if($diffDataDesmontagem->d>0){
							$diasHoras = intval($diffDataDesmontagem->d*24);
						}
						$c->horasDesmontagem = ($diffDataDesmontagem->h+$diasHoras).":".(strlen($diffDataDesmontagem->i)>1?$diffDataDesmontagem->i:"0".$diffDataDesmontagem->i).":".(strlen($diffDataDesmontagem->s)>1?$diffDataDesmontagem->s:"0".$diffDataDesmontagem->s);
					}else{
						$c->horasDesmontagem = "0:00:00";
					}
				}else{
					$c->horasArmazenar = "0:00:00";
					$c->horasDesmontagem = "0:00:00";
				}
				
			}else{
				$c->horasArmazenar = "0:00:00";
				$c->horasDesmontagem = "0:00:00";
			}

			if(!empty($c->data_finalizado_peritagem) && !empty($c->data_abertura_real)){
				$dataFinalizadoPeritagem = new DateTime($c->data_finalizado_peritagem);
				$data_abertura_real = new DateTime($c->data_abertura_real);
				$diffDataComercial = $data_abertura_real->diff($dataFinalizadoPeritagem);
				$diasHoras = 0;
				if($diffDataComercial->m>0){
					$diasHoras = ($diffDataComercial->m*30*24);
				}
				if($diffDataComercial->d>0){
					$diasHoras = ($diffDataComercial->d*24) + $diasHoras;
				}
				$c->horasComercial = ($diffDataComercial->h+$diasHoras).":".(strlen($diffDataComercial->i)>1?$diffDataComercial->i:"0".$diffDataComercial->i).":".(strlen($diffDataComercial->s)>1?$diffDataComercial->s:"0".$diffDataComercial->s);

			}else{
				$c->horasComercial = "0:00:00";
			}

			if(!empty($c->data_abertura_orc_item) && !empty($c->data_entrega)){
				$dataAbertura = new DateTime($c->data_abertura_orc_item);
				$dataEntrega = (!empty($c->data_reagendada)?$c->data_reagendada:$c->data_entrega);
				//echo $dataEntrega;
				$dataEntrega = new DateTime($dataEntrega);
				$diffOs = $dataEntrega->diff($dataAbertura);
				$diasHoras = 0;
				if($diffOs->m>0){
					$diasHoras = ($diffOs->m*30*24);
				}
				if($diffOs->d>0){
					$diasHoras = ($diffOs->d*24) + $diasHoras;
				}
				$c->horasOs = ($diffOs->h+$diasHoras).":".(strlen($diffOs->i)>1?$diffOs->i:"0".$diffOs->i).":".(strlen($diffOs->s)>1?$diffOs->s:"0".$diffOs->s);

			}else{
				$c->horasOs = "0:00:00";
			}
			
		}
		foreach($osFab as $c){
			$c->horasGastaPeritagem = "0:00:00";
			$c->horasArmazenar = "0:00:00";
			$c->horasDesmontagem = "0:00:00";
			$distribuir = $this->os_model->getDistribuirByIdOs($c->idOs);
			//Calcula o tempo em que foi cadastrados os desenhos
			if(!empty($c->data_solicitar_desenho) && !empty($c->data_finalizado_desenho)){
				$inicio_desenho = new DateTime($c->data_solicitar_desenho);
				$fim_desenho = new DateTime($c->data_finalizado_desenho);
				$diffDataDesenho = $fim_desenho->diff($inicio_desenho);
				$diasHoras = 0;
				if($diffDataDesenho->d > 0){
					$diasHoras = intval($diffDataDesenho->d*24);
				}
				$c->horasGastaDesenho = ($diffDataDesenho->h+$diasHoras).":".(strlen($diffDataDesenho->i)>1?$diffDataDesenho->i:"0".$diffDataDesenho->i).":".(strlen($diffDataDesenho->s)>1?$diffDataDesenho->s:"0".$diffDataDesenho->s);
			}
			//Calcula o intervalo de tempo do momento em que a O.S. ficou disponivel para o PCP até o cadastro do primeiro item	
			if(!empty($c->data_finalizado_desenho) && !empty($distribuir)){
				$disponibilizado = new DateTime($c->data_finalizado_desenho);
				$iniciado = new DateTime($distribuir[0]->data_cadastro);
				$diffPcp = $iniciado->diff($disponibilizado);
				$diasHoras = 0;
				if($diffPcp->d > 0){
					$diasHoras = intval($diffPcp->d*24);

				}
				$c->horasInicioPCP = ($diffPcp->h+$diasHoras).":".(strlen($diffPcp->i)>1?$diffPcp->i:"0".$diffPcp->i).":".(strlen($diffPcp->s)>1?$diffPcp->s:"0".$diffPcp->s);
			}else{
				$c->horasInicioPCP = "0:00:00";
			}
			$distribuirComPedido = $this->pedidocompra_model->getDistribuirByIdOs2($c->idOs);
			
			if(!empty($distribuirComPedido)){
				$somaDias = 0;
				$somaHR = 0;
				$somaMIN = 0;
				$somaSEG = 0;
				$totalEmSEG = 0;
				$contagemPedido = 0;
				$horas = 0;
				$minutos = 0;
				$segundos = 0;
				foreach($distribuirComPedido as $r){
					if(!empty($r->dataDistribuir) && !empty($r->dataPedido)){
						$disponibilizado = new DateTime($r->dataDistribuir);
						$iniciado = new DateTime($r->dataPedido);
						$diffPedidoCompra = $iniciado->diff($disponibilizado);

						$somaSEG = $somaSEG + $diffPedidoCompra->s;
						$somaMIN = $somaMIN + $diffPedidoCompra->i;
						$somaHR = $somaHR + $diffPedidoCompra->h;
						$somaDias = $somaDias + $diffPedidoCompra->d;
						
						$contagemPedido = $contagemPedido+1;	
						/*	
						if($c->idOs == 30796){
							echo '<script>console.log('.json_encode($diffPedidoCompra).')</script>';
							echo '<script>console.log('.($somaSEG + ($somaMIN*60) + ($somaHR*3600) + (($somaDias*24)*3600)).')</script>';
						}	*/	
					}
				}
				$totalEmSEG += 	$somaSEG + ($somaMIN*60) + ($somaHR*3600) + (($somaDias*24)*3600);/*
				if($c->idOs == 30796){
					echo '<script>console.log("Quantidade: '.$contagemPedido.' </br> Segundos: '.$totalEmSEG.'")</script>';
				}*/
				if($somaDias>0){
					$somaHR = $somaHR + ($somaDias*24);
				}
				if($totalEmSEG>0){
					$mediaTempo = intval($totalEmSEG/$contagemPedido);
					
					$horas = floor($mediaTempo / 3600);
					$minutos = floor(($mediaTempo - ($horas * 3600)) / 60);
					$segundos = floor($mediaTempo % 60);
				}
				if(!empty($segundos) || !empty($minutos) || !empty($horas)){
					$c->horasPedidoSup = ($horas).":".(strlen($minutos)>1?$minutos:"0".$minutos).":".(strlen($segundos)>1?$segundos:"0".$segundos);
				}else{
					$c->horasPedidoSup = "0:00:00";
				}
			}else{
				$c->horasPedidoSup = "0:00:00";
			}

			if(!empty($c->data_abertura_orc_item) && !empty($c->data_abertura_real)){
				$inicio = new DateTime($c->data_abertura_orc_item);
				$fim = new DateTime($c->data_abertura_real);
				$diffDataComercial = $fim->diff($inicio);
				$diasHoras = 0;
				if($diffDataComercial->m>0){
					$diasHoras = ($diffDataComercial->m*30*24);
				}
				if($diffDataComercial->d>0){
					$diasHoras = ($diffDataComercial->d*24) + $diasHoras;
				}
				$c->horasComercial = ($diffDataComercial->h+$diasHoras).":".(strlen($diffDataComercial->i)>1?$diffDataComercial->i:"0".$diffDataComercial->i).":".(strlen($diffDataComercial->s)>1?$diffDataComercial->s:"0".$diffDataComercial->s);

			}else{
				$c->horasComercial = "0:00:00";
			}

			if(!empty($c->data_abertura_orc_item) && !empty($c->data_entrega)){
				$dataAbertura = new DateTime($c->data_abertura_orc_item);
				$dataEntrega = (!empty($c->data_reagendada)?$c->data_reagendada:$c->data_entrega);
				$dataEntrega = new DateTime($dataEntrega);
				$diffOs = $dataEntrega->diff($dataAbertura);
				$diasHoras = 0;
				if($diffOs->m>0){
					$diasHoras = ($diffOs->m*30*24);
				}
				if($diffOs->d>0){
					$diasHoras = ($diffOs->d*24) + $diasHoras;
				}
				$c->horasOs = ($diffOs->h+$diasHoras).":".(strlen($diffOs->i)>1?$diffOs->i:"0".$diffOs->i).":".(strlen($diffOs->s)>1?$diffOs->s:"0".$diffOs->s);

			}else{
				$c->horasOs = "0:00:00";
			}
		}
		$totalItens = array();
		if(!empty($osServ)){
			$totalItens = array_merge($totalItens,$osServ);
		}
		if(!empty($osFab)){
			$totalItens = array_merge($totalItens,$osFab);
		}
		//exit();
		$this->data['result'] = $totalItens;
		$this->data['view'] = 'relatorios/rel_horas';
        $this->load->view('tema/topo',$this->data);
	}

	public function edivan(){
		$this->load->model('os_model');
		$this->load->helper('download');
		$this->load->model('pedidocompra_model');
		if(!empty($this->input->post('data_inicio'))){
			$data = explode("/",$this->input->post('data_inicio'));
			$data_inicio = $data[2]."-".$data[1]."-".$data[0];
		}
		if(!empty($this->input->post('data_fim'))){
			$data = explode("/",$this->input->post('data_fim'));
			$data_fim = $data[2]."-".$data[1]."-".$data[0];
		}
		echo "O.S;Unid. Exec.;Valor Orc.;Valor O.S.;Valor Insumo;Valor Sup\n";
		$data_inicio = $this->uri->segment(3);
		$data_fim = $this->uri->segment(4);
		$unid_exec = $this->uri->segment(5);
		if(!$data_inicio || !$data_fim){
			echo 'Informe as datas de inicio e fim na url. Ex: relatorios/edivan/2022-01-01/2022-12-31';
			return;
		}
		$listOs = $this->Relatorios_model->relatorioEdivan($data_inicio,$data_fim,$unid_exec);
		//$listOs = $this->Relatorios_model->relatorioEdivan('2022-01-01','2022-01-31');
		//echo json_encode($listOs);
		foreach($listOs as $r){
			$somaQtd = 0;
			$somaValor = 0;
			$r->osvinculadas = "";
			$os_vinculada = $this->os_model->os_vinculada($r->idOs);
			foreach($os_vinculada as $e){
				if($e->idOs_principal == $r->idOs){
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_gerada);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_gerada,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_gerada." / "; 

				}else{
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_principal);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_principal,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_principal." / ";
				}
				
			}
			$somaValor += $r->valorInsumos;
			$osAtual = $this->Relatorios_model->get("os"," * ","os.idOs = ".$r->idOs,1,null,true);
			$somaQtd += $osAtual->qtd_os;
			$result = $somaValor/$somaQtd;
			$r->valorInsumos = $result*$osAtual->qtd_os;
			$r->valorInsumos = str_replace(".",",",$r->valorInsumos);
			$r->valorOrc = str_replace(".",",",$r->valorOrc);
			$r->valorOS = str_replace(".",",",$r->valorOS);
		}
		//echo json_encode($listOs);
		// Open a file in write mode ('w')
		$fp = fopen('php://output', 'w');
		header('Pragma: public');     // required
		header('Expires: 0');         // no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Disposition: attachment; filename="'.basename('relatorio_'.str_replace("-","",$data_inicio).'_'.str_replace("-","",$data_fim).'.csv').'"');  // Add the file name
		header('Content-Transfer-Encoding: binary');
		header('Connection: close');
		foreach ($listOs as $fields) {
			fputcsv($fp, get_object_vars($fields),";");
		}
		$data = file_get_contents('php://output');
    	// Build the headers to push out the file properly.
   
		exit();

		force_download('relatorio_'.str_replace("-","",$data_inicio).'_'.str_replace("-","",$data_fim).'.csv', $data);
		fclose($fp);
	}

	public function edivan2(){
		$this->load->model('os_model');
		$this->load->helper('download');
		$this->load->model('pedidocompra_model');
		if(!empty($this->input->post('data_inicio'))){
			$data = explode("/",$this->input->post('data_inicio'));
			$data_inicio = $data[2]."-".$data[1]."-".$data[0];
		}
		if(!empty($this->input->post('data_fim'))){
			$data = explode("/",$this->input->post('data_fim'));
			$data_fim = $data[2]."-".$data[1]."-".$data[0];
		}
		echo "O.S;Unid. Exec.;Valor Orc.;Valor O.S.;Valor Insumo;;Valor Almoxarifado\n";
		$data_inicio = $this->uri->segment(3);
		$data_fim = $this->uri->segment(4);
		$unid_exec = $this->uri->segment(5);
		if(!$data_inicio || !$data_fim){
			echo 'Informe as datas de inicio e fim na url. Ex: relatorios/edivan/2022-01-01/2022-12-31';
			return;
		}
		$listOs = $this->Relatorios_model->relatorioEdivan($data_inicio,$data_fim,$unid_exec);
		//$listOs = $this->Relatorios_model->relatorioEdivan('2022-01-01','2022-01-31');
		//echo json_encode($listOs);
		foreach($listOs as $r){
			$somaQtd = 0;
			$somaValor = 0;
			$r->osvinculadas = "";
			$os_vinculada = array();
			$os_vinculada = $this->os_model->os_vinculada($r->idOs);
			foreach($os_vinculada as $e){
				if($e->idOs_principal == $r->idOs){
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_gerada);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_gerada,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_gerada." / ";


				}else{
					$insumos = $this->pedidocompra_model->getDistribuirByIdOs($e->idOs_principal);
					$somaValor += $insumos->somaInsumo;
					$os2 = $this->Relatorios_model->get("os"," * ","os.idOs = ".$e->idOs_principal,1,null,true);
					$somaQtd += $os2->qtd_os;
					$r->osvinculadas .= $e->idOs_principal." / ";
				}
				
			}
			$soma_almoxarifado = 0;/**/
			$almoxarifado = $this->Relatorios_model->getSaidasByIdOsSemReserva($r->idOs);
			if(!empty($almoxarifado)){
				foreach($almoxarifado as $v){
					$insumoCompativel = $this->pedidocompra_model->getUltimosOrcLimitedOne(" and distribuir_os.idInsumos = $v->idProduto");
					if(!empty($insumoCompativel)){
						$soma_almoxarifado = $soma_almoxarifado + ($insumoCompativel->valor_unitario * $v->quantidade);
					}
				}
			}
			$somaValor += $r->valorInsumos;
			$osAtual = $this->Relatorios_model->get("os"," * ","os.idOs = ".$r->idOs,1,null,true);
			$somaQtd += $osAtual->qtd_os;
			$result = $somaValor/$somaQtd;
			$r->valorInsumos = $result*$osAtual->qtd_os;
			$r->valorInsumos = str_replace(".",",",$r->valorInsumos);
			$r->valorOrc = str_replace(".",",",$r->valorOrc);
			$r->valorOS = str_replace(".",",",$r->valorOS);
			$r->valorAlmoxarifado = str_replace(".",",",$soma_almoxarifado);
		}
		//echo json_encode($listOs);
		// Open a file in write mode ('w')
		$fp = fopen('php://output', 'w');
		header('Pragma: public');     // required
		header('Expires: 0');         // no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Disposition: attachment; filename="'.basename('relatorio_'.str_replace("-","",$data_inicio).'_'.str_replace("-","",$data_fim).'.csv').'"');  // Add the file name
		header('Content-Transfer-Encoding: binary');
		header('Connection: close');
		foreach ($listOs as $fields) {
			fputcsv($fp, get_object_vars($fields),";");
		}
		$data = file_get_contents('php://output');
    	// Build the headers to push out the file properly.
   
		exit();

		force_download('relatorio_'.str_replace("-","",$data_inicio).'_'.str_replace("-","",$data_fim).'.csv', $data);
		fclose($fp);
	}

	function relperitagem(){
		$antigo = $this->Relatorios_model->getPeritagemOs();
		$novo = $this->Relatorios_model->getOrcEscopoStatusPeritagem();
		$this->data['result']=array_merge($antigo,$novo);
		$this->data['view'] = 'relatorios/rel_peritagem';
        $this->load->view('tema/topo',$this->data);
	}
}
