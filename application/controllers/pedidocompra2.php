<?php

class Pedidocompra extends CI_Controller {
    
    function __construct() {
        parent::__construct();
                if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
                    redirect('mapos/login');
                }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('pedidocompra_model','',TRUE);
		$this->data['menuPedidoCompra'] = 'Pedido de Compra';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Pedido de compra.');
           redirect(base_url());
        }
         $this->load->library('table');
         $this->load->library('pagination');
         
         $this->load->model('os_model');
		$this->load->model('orcamentos_model');		 
		$this->load->model('cotacao_model');		 
         
         $config['base_url'] = base_url().'index.php/pedidocompra/gerenciar/';
         
$this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
$this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');		 
         
         $idOs = $this->input->post('idOs');
		 if(!empty($this->uri->segment(3)))
		 {
			  $idPedidoCompra = $this->uri->segment(3);
		 }
		 else
		 {
			  $idPedidoCompra = $this->input->post('idPedidoCompra');
		 }
        
        $idPedidoCotacao = $this->input->post('idPedidoCotacao');
          
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
					$query_statuscompra.=(int)$status_compra3;
					$primeiro = false;
				}
				else
				{
					$query_statuscompra.=",".(int)$status_compra3;
				}
			}
			$query_statuscompra .= ")";
		}
		  
		   $query_idgrupo = "";
		 $idgrupo = $this->input->post('idgrupo');
		  if(!empty($idgrupo))
		{
			$conteudo = $idgrupo;
		$query_idgrupo="(";
		$primeiro = true;
			foreach($conteudo as $idgrupo3)
			{
				if($primeiro)
				{
					$query_idgrupo.=(int)$idgrupo3;
					$primeiro = false;
				}
				else
				{
					$query_idgrupo.=",".(int)$idgrupo3;
				}
			}
			$query_idgrupo .= ")";
		}
		
		  
		  
		  
          $fornecedor_id = (int)$this->input->post('fornecedor_id');
          $nf_fornecedor = $this->input->post('nf_fornecedor');
		
		
		
		
         
		 
		 if (!empty($idOs) || !empty($idPedidoCotacao)   || !empty($query_statuscompra) || !empty($idPedidoCompra) || !empty($fornecedor_id) || !empty($nf_fornecedor) || !empty($query_idgrupo)) {
           
         $this->data['results'] = $this->pedidocompra_model->getWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo);
 
             $config['total_rows'] = $this->pedidocompra_model->numrowsWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo);
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


            //$config['total_rows'] = $this->pedidocompra_model->count('pedido_cotacaoitens');
            $config['total_rows'] = count( $this->pedidocompra_model->getdistribuidorcount('pedido_cotacaoitens','*','statuscompras.idStatuscompras  in(2,7)  and distribuir_os.solicitacao = 1 '));
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
           
         $this->data['results'] = $this->pedidocompra_model->getdistribuidor('pedido_cotacaoitens','*','statuscompras.idStatuscompras  in(2,7) and distribuir_os.solicitacao = 1',$config['per_page'],$this->uri->segment(3));
         
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
       
	    $this->data['view'] = 'pedidocompra/pedidocompra';
       	$this->load->view('tema/topo',$this->data);
       //$this->load->view('tema/rodape');
		
    }
	 public function imprimir_pedido(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Pedido.');
           redirect(base_url());
        }
		

        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
		
         $data['result'] = $this->pedidocompra_model->pedidoCustom($this->uri->segment(3));
       

	
				$this->load->helper('mpdf');
           echo $html = $this->load->view('pedidocompra/imprimir/imprimir_pedido',$data,true);
       
    }
	function editar_ipi(){
		
		 $contadoripi=count($this->input->post('idPedidoCompraItensipi'));  
		 
		 $valoripi = str_replace(".","",$this->input->post('valoripi'));  
		 $valoripi = str_replace(",",".",$valoripi);

$dataentregue2 = explode('/', $this->input->post('dataentregue2'));
$dataentregue2 = $dataentregue2[2].'-'.$dataentregue2[1].'-'.$dataentregue2[0];	

$datanf = explode('/', $this->input->post('datanf'));
$datanf = $datanf[2].'-'.$datanf[1].'-'.$datanf[0];	

$nf = $this->input->post('nf');
$idStatuscompras2 = $this->input->post('idStatuscompras2');
					
			$idPedidoCompraipi	= $this->input->post('idPedidoCompraipi');	
		for($x=0;$x<$contadoripi;$x++)
				{
					
	$this->data['dist'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idPedidoCompraItens ='. $this->input->post('idPedidoCompraItensipi')[$x]);
				
       
		 $dist = $this->data['dist']->idDistribuir;
		 
		 
					if( !empty($this->input->post('valoripi')))
					{
						$data2 = array(
               
                'ipi_valor' => $valoripi
            );
			$this->pedidocompra_model->edit('pedido_comprasitens', $data2, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
					}
					
			if( !empty($this->input->post('dataentregue2')))
					{
						$data3 = array(
               
                'datastatusentregue' => $dataentregue2
            );
			$this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
					}
					if( !empty($this->input->post('datanf')) && !empty($this->input->post('nf')))
					{
						$data4 = array(
               
                'datanf' => $datanf,
                'notafiscal' => $nf
            );
			$this->pedidocompra_model->edit('pedido_comprasitens', $data4, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
					}
					if( !empty($this->input->post('idStatuscompras2')) )
					{
						$data4 = array(
               
                'idStatuscompras' => $idStatuscompras2
            );
			$this->pedidocompra_model->edit('distribuir_os', $data4, 'idDistribuir', $dist);
					}
			
			
				}
				$this->session->set_flashdata('success','Dados alterado com sucesso!');
                redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompraipi);
	}
	function montarpedidocompra(){
		
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aPedCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar pedido.');
          redirect(base_url());
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

   $contador=count($this->input->post('idCotacaoItens_'));
  
  
        if ($this->input->post('idCotacaoItens_')[0] < 1) {
            
			$this->session->set_flashdata('error','Selecione pelo menos um item!');
                redirect(base_url() . 'index.php/pedidocompra');
				
         } else {



$data = array(
                'data_cadastro' => date('Y-m-d H:i:s')
            );
			

 

  if (is_numeric($id = $this->pedidocompra_model->add('pedido_compras', $data, true)) ) {

				$total=0;

				for($x=0;$x<$contador;$x++)
				{
					
					$data2 = array(
                'data_cadastro' => date('Y-m-d H:i:s'),
                'idCotacaoItens' => $this->input->post('idCotacaoItens_')[$x],
             
                'idPedidoCompra' => $id
            );
		
$this->data['dadoscot'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->input->post('idCotacaoItens_')[$x]);
        
		 $distri = $this->data['dadoscot']->idDistribuir;

		 
			//verifica se esta reservado estoque
				$this->data['status_atual'] = $this->pedidocompra_model->gettable('distribuir_os','idDistribuir ='. $distri);
				
       
		 $idStatuscomprasatual = $this->data['status_atual']->idStatuscompras;
		 
		  
		  if ($idStatuscomprasatual == 7)
		 {
			 $data3 = array(
                'idStatuscompras' => '7'
            );
		 }
		  else
		 {
			
			$data3 = array(
                'idStatuscompras' => '3'
            );
		 }
			
			
			
			
			
					
				$id_pci = $this->pedidocompra_model->add('pedido_comprasitens', $data2, true);
				
				$data5 = array(
                'idPedidoCompra' => $id,
                'idPedidoCompraItens' => $id_pci
            );
			
			
			
		$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $distri);
					
				$this->pedidocompra_model->edit('pedido_cotacaoitens', $data5, 'idCotacaoItens', $this->input->post('idCotacaoItens_')[$x]);
				
					
				}

	$this->session->set_flashdata('success','Pedido gerado com sucesso!');
                redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$id);
	
		 }
		  else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao gerar pedido.</p></div>';
            }
		 }
		
	}
	 public function estoque_atual($idproduto) {
		
//$this->data['orcamento'] = $this->orcamentos_model->getById('orcamento',$this->data['result']->idOrcamentos);		
		return "22"; 
	 }
	 
	 
	public function salvaritemcompra(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para editar item.');
          redirect(base_url());
        }
		$this->load->model('cotacao_model');
		$this->load->model('estoque_model');
		
	 $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
		 $contador=count($this->input->post('item'));
		 
			

		
				for($x=0;$x<$contador;$x++)
				{
					
				
				if(!empty($this->input->post('dataentregue')[$x]))
				{
					
					$dataentregue[$x] = explode('/', $this->input->post('dataentregue')[$x]);
					 $dataentregue[$x] = $dataentregue[$x][2].'-'.$dataentregue[$x][1].'-'.$dataentregue[$x][0];
					// $datafinal = $dataentregue." ".date("H:i:s");
					 //$datafinal = date("Y-m-d H:i:s");
					//echo $this->input->post('horaentregue')[$x];
					
				}
				
				
			
					$valor_unitario = str_replace(".","",$this->input->post('valor_unitario')[$x]);
					$valor_unitario = str_replace(",",".",$valor_unitario);
					
					$ipi_valor = str_replace(".","",$this->input->post('ipi_valor')[$x]);
					$ipi_valor = str_replace(",",".",$ipi_valor);
					
					$valor_produtos = str_replace(".","",$this->input->post('valor_produtos')[$x]);
					$valor_produtos = str_replace(",",".",$valor_produtos);
					
				if(!empty($this->input->post('dataentregue')[$x]))
				{	
			
					 $data2 = array(
                'quantidade' => $this->input->post('qtdrecebida')[$x],
                'id_status_grupo' => $this->input->post('idgrupo')[$x],
                'datastatusentregue' => $dataentregue[$x],
                'valor_unitario' => $valor_unitario,
                'ipi_valor' => $ipi_valor,
                'valor_total' => $valor_produtos         
            );
			
				}
				else
				{
					$data2 = array(
                'quantidade' => $this->input->post('qtdrecebida')[$x],
                'id_status_grupo' => $this->input->post('idgrupo')[$x],
                
                'valor_unitario' => $valor_unitario,
                'ipi_valor' => $ipi_valor,
                'valor_total' => $valor_produtos         
            );
				}
			
			
$this->pedidocompra_model->edit('pedido_comprasitens', $data2, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens')[$x]);	
				
				
$data3 = array(
                'idStatuscompras' => $this->input->post('idStatuscompras')[$x]
            );
			




 $this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->input->post('idCotacaoItens')[$x]);
			 
        $idDistribuir =  $this->data['dadosped2']->idDistribuir;
		

$this->data['dados_dist'] = $this->pedidocompra_model->gettable('distribuir_os','idDistribuir ='.$idDistribuir);

//7 -Solicitado Estoque
//8-Compra Aprov. Estoqu
//9-Aprov. Retirada Estoque

$status_praestoque = array(7,8,9);
//verificando estoque
$saida = $this->estoque_model->getestoquesaida($this->data['dados_dist']->idInsumos);


			if(!empty($saida))
			{
				 $saidaesto = $saida[0]->qtdsaida;
			}
			else
			{
				$saidaesto = '0';
			}
			
			 $entrada = $this->estoque_model->getestoqueentrada($this->data['dados_dist']->idInsumos);
			if(!empty($entrada))
			{
				 $entrada1 = $entrada[0]->qtd;
			}
			else
			{
				$entrada1 = '0';
			}
			
			 $reservado = $this->estoque_model->getreservado($this->data['dados_dist']->idInsumos,$idDistribuir);
			if(!empty($reservado))
			{
				 $reservado1 = $reservado[0]->qtdrese;
			}
			else
			{
				$reservado1 = '0';
			}
			
		$estoq_atual = $entrada1 -$saidaesto - $reservado1 ;
		
		
		
 $status_atual = $this->data['dados_dist']->idStatuscompras;	
	
	if ( $status_atual <> 8 && $status_atual <> 9)
				{
		
if($status_atual <> $this->input->post('idStatuscompras')[$x])
		{
				//verifica o status anterior para dar baixa nas tb
				if (in_array($status_atual, $status_praestoque))
				{

					if($status_atual == 7)
					{
						//retirar da tb de reserva de estoque
						$this->data['reserva_estoque'] = $this->pedidocompra_model->gettable('estoque_reservado','id_distribuir ='. $idDistribuir);
        
		 $id_estoque_reservado = $this->data['reserva_estoque']->id_estoque_reservado;
		  if ($id_estoque_reservado <> null)
		 {
			 $this->pedidocompra_model->delete('estoque_reservado','id_estoque_reservado',$id_estoque_reservado);
		 }
						
					}
				}
				
			
				
				
				if (in_array($this->input->post('idStatuscompras')[$x], $status_praestoque))
				{
					
					
					if($this->input->post('idStatuscompras')[$x] == 9)
					{
						
						
						
						$this->data['saida_estoque'] = $this->pedidocompra_model->gettable('estoque_saida','id_distribuir ='. $idDistribuir);
        
		 $id_estoque_saida = $this->data['saida_estoque']->idestoque_saida;
		  if ($id_estoque_saida == null)
		 {
						$data4 = array(
                
                'id_os' => $this->data['dados_dist']->idOs,
                'id_produto' => $this->data['dados_dist']->idInsumos,
                'id_distribuir' => $idDistribuir,
                'id_compra' => $this->input->post('idPedidoCompra'),
                'idPedidoCompraItens' =>$this->input->post('idPedidoCompraItens')[$x]
                
                  
            );
		//verificar se tem saldo dessa qtdo pra dar saida

if($this->data['dados_dist']->quantidade <= $estoq_atual)
		{
			$this->pedidocompra_model->add('estoque_saida', $data4, true);
			$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
			$this->session->set_flashdata('success',$x + 1 .'- Esse item foi dado saida no estoque com sucesso!');
			
			
		}
		else
		{
			$this->session->set_flashdata('error',$x + 1 .'- Esse item NÃO TEM ESTOQUE SUFICIENTE PRA DAR SAIDA!');
			
			
		}

	
		
		

		
					}
					}
					elseif($this->input->post('idStatuscompras')[$x] == 8)
					{
						if($this->data['dados_dist']->idOs <= 19999)
						{
						$this->data['entrada_estoque'] = $this->pedidocompra_model->gettable('estoque_entrada','id_distribuir ='. $idDistribuir);
        
		 $id_estoque_entrada = $this->data['entrada_estoque']->idestoque_entrada;
		  if ($id_estoque_entrada == null)
		 {
						$data4 = array(
                
                'id_os' => $this->data['dados_dist']->idOs,
                'id_produto' => $this->data['dados_dist']->idInsumos,
                'id_distribuir' => $idDistribuir,
                'id_compra' => $this->input->post('idPedidoCompra'),
                'idPedidoCompraItens' => $this->input->post('idPedidoCompraItens')[$x]
                
                  
            );
		
		$this->pedidocompra_model->add('estoque_entrada', $data4, true);
		$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
		$this->session->set_flashdata('success','Item '.$x + 1 .'ITEM INSERIDO NO ESTOQUE!');
		
					}
					else
					{
						$this->session->set_flashdata('error',$x + 1 .'- ESTE ITEM JA ESTA INSERIDO NO ESTOQUE!');
		
						
					}
					}
					else
					{
						$this->session->set_flashdata('error',$x + 1 .'- Esse item não pode ser inserida no estoque, somente OS 1 a 30!');
						
					}
					}
					else
					{
					if($this->data['dados_dist']->idOs >= 20000)
			{		
						$data4 = array(
                
                'id_os' => $this->data['dados_dist']->idOs,
                'id_produto' => $this->data['dados_dist']->idInsumos,
                'id_distribuir' => $idDistribuir,
                
                
                  
            );
		//verifica se tem estoque do item pra reservar
		
		
		
		if($this->data['dados_dist']->quantidade <= $estoq_atual)
		{
			$this->pedidocompra_model->add('estoque_reservado', $data4, true);
			$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
			$this->session->set_flashdata('success',$x + 1 .'- Esse item foi RESERVADO NO ESTOQUE COM SUCESSO!');
			
			
		}
		else
		{
			$this->session->set_flashdata('error',$x + 1 .'- Esse item esta SEM ESTOQUE SUFICIENTE PARA RESERVAR!');
			
			
		}
		
		
						
					}
else
{
	//caiu aqui por ser os menor q 200000
	 $this->session->set_flashdata('error',$x + 1 .'- Esse item não pode mudar status pra solicitar estoque, mude para retirada estoque direto.');
	 
	//$texto7 = "Essa OS não pode mudar status pra solicitar estoque, mude para retirada estoque direto.";
	
	
	
}
					}
				}
				else
				{
					$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
				}

				}				


	
		
	
	
			
				}//final do se $status_atual <> 8 && $status_atual <> 9
			else
			{
				if($status_atual <> $this->input->post('idStatuscompras')[$x])
				{
					//if($status_atual == 8)
					//{
						 $atualestoque = $estoq_atual - $this->data['dados_dist']->quantidade;
						if($this->data['dados_dist']->quantidade <= $atualestoque)
						{
							
						
		
							
							
							if (in_array($this->input->post('idStatuscompras')[$x], $status_praestoque))
							{
								if($this->input->post('idStatuscompras')[$x] == 8)
								{ 
								if($this->data['dados_dist']->idOs <= 19999)
						{
								
									//exclui da tb de reserva pq ele é status 9
									$this->data['estoque_saida'] = $this->pedidocompra_model->gettable('estoque_saida','id_distribuir ='. $idDistribuir);
        
		 $idestoque_saida = $this->data['estoque_saida']->idestoque_saida;
		  if ($idestoque_saida <> null)
		 {
			 $this->pedidocompra_model->delete('estoque_saida','idestoque_saida',$idestoque_saida);
		 }
		  
			
									
									$this->data['entrada_estoque'] = $this->pedidocompra_model->gettable('estoque_entrada','id_distribuir ='. $idDistribuir);
        
		 $id_estoque_entrada = $this->data['entrada_estoque']->idestoque_entrada;
		  if ($id_estoque_entrada == null)
		 {
						$data4 = array(
                
                'id_os' => $this->data['dados_dist']->idOs,
                'id_produto' => $this->data['dados_dist']->idInsumos,
                'id_distribuir' => $idDistribuir,
                'id_compra' => $this->input->post('idPedidoCompra'),
                'idPedidoCompraItens' => $this->input->post('idPedidoCompraItens')[$x]
                
                  
            );
		
		$this->pedidocompra_model->add('estoque_entrada', $data4, true);
		}
		$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
		$this->session->set_flashdata('success',$x + 1 .'- Esse item foi INSERIDO NO ESTOQUE com sucesso!');
			
		
									
								}
else
{
	$this->session->set_flashdata('error',$x + 1 .'- Esse item não pode ser inserido no estoque!');
		
	
}
								}
								else
								{
								if($this->data['dados_dist']->quantidade <= $atualestoque)
								{
									$this->data['estoque_entrada'] = $this->pedidocompra_model->gettable('estoque_entrada','id_distribuir ='. $idDistribuir);
        
		 $id_estoque_entrada = $this->data['estoque_entrada']->idestoque_entrada;
		  if ($id_estoque_entrada <> null)
		 {
			 $this->pedidocompra_model->delete('estoque_entrada','idestoque_entrada',$id_estoque_entrada);
		 }
		 
									if($this->input->post('idStatuscompras')[$x] == 7)
									{
										$table = "estoque_reservado";
										
									}
									else
									{
										$table = "estoque_saida";
										
									}
								
								$data4 = array(
                
                'id_os' => $this->data['dados_dist']->idOs,
                'id_produto' => $this->data['dados_dist']->idInsumos,
                'id_distribuir' => $idDistribuir,
                
                
                  
            );
			
			$this->pedidocompra_model->add($table, $data4, true);
			$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
			$this->session->set_flashdata('success',$x + 1 .'- Esse item foi reservado em ESTOQUE COM SUCESSO!');
	
	
			
								
								
									
								}
								ELSE
								{
									$this->session->set_flashdata('error','Item '.$x + 1 .'ESTOQUE INSUFICIENTE PRA DAR SAIDA, STATUS NÃO PODE SER ALTERADO!');
	
									
								}
							}
								
							}//se for 7,8,9
							else
							{
								if($this->data['dados_dist']->quantidade <= $atualestoque)
								{
									if($status_atual == 8)
									{
										$this->data['estoque_entrada'] = $this->pedidocompra_model->gettable('estoque_entrada','id_distribuir ='. $idDistribuir);
        
		 $id_estoque_entrada = $this->data['estoque_entrada']->idestoque_entrada;
		  if ($id_estoque_entrada <> null)
		 {
			 $this->pedidocompra_model->delete('estoque_entrada','idestoque_entrada',$id_estoque_entrada);
		 }
		 $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
		 $this->session->set_flashdata('sucess',$x + 1 .'- Esse item foi retirado DO ESTOQUE COM SUCESSO!');
			
		 
									}
									else
									{
										$this->data['estoque_saida'] = $this->pedidocompra_model->gettable('estoque_saida','id_distribuir ='. $idDistribuir);
        
		 $idestoque_saida = $this->data['estoque_saida']->idestoque_saida;
		  if ($idestoque_saida <> null)
		 {
			 $this->pedidocompra_model->delete('estoque_saida','idestoque_saida',$idestoque_saida);
		 }
		  $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
		 $this->session->set_flashdata('success',$x + 1 .'- Esse item foi RETIRADO DO ESTOQUE DE SAIDA COM SUCESSO!');
		
			
									}
									
		 
								
			
							}
							else
							{
								 $this->session->set_flashdata('error',$x + 1 .'- Esse item Status nao pode ser alterado, estoque fica negativo!');
		
								
							}
							
							}
							
						}
						else
						{
							$this->session->set_flashdata('error','Item '.$x + 1 .'COMPRA NÃO PODE SER RETIRADA DO ESTOQUE!');
							
							
						}
		
		
						
						
					}// if $this->data['dados_dist']->quantidade <= $atualestoque
					else
					{
						$this->session->set_flashdata('error',$x + 1 .'- Esse item não pode mudar status pois não tem estoque suficiente pra abater!');
						
					}
				
				
			}
       		
					
				
				}//final do else 
				
				
				 $this->session->set_flashdata('success','Pedido salvo com sucesso.');
               redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$this->input->post('idPedidoCompra'));
			
           
		
		
	}
	public function salvaritemcompra2(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para editar item.');
          redirect(base_url());
        }
		$this->load->model('cotacao_model');
		
	 $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
		
//todo status de compra() com os 1,2,3 		 
//Aprov. Retirada Estoque = status 9 - registra saida do estoque
//Compra Aprov. Estoque = status 8 - entra pra o estoque
//Solicitado Estoque = status 7 = reserva o item no estoque	


$status_praestoque = array(7,8,9);	
			
$data3 = array(
                'idStatuscompras' => $this->input->post('idStatuscompras')
            );
	
				$itenspc = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idPedidoCompra ='. $this->input->post('idPedidoCompra'),1);
			 foreach ($itenspc as $r)
			 {
				 
							
				 
        $idDistribuir2 =  $r->idDistribuir;
        $idPedidoCompraItens =  $r->idPedidoCompraItens;
        
		
		
		$this->data['dados_dist'] = $this->pedidocompra_model->gettable('distribuir_os','idDistribuir ='. $idDistribuir2);
        
		 $status_atual = $this->data['dados_dist']->idStatuscompras;
	//se ja possuir status 8 ou 9 nao pode mudar mais	
if ( $status_atual <> 8 && $status_atual <> 9)
				{		
		if($status_atual <> $this->input->post('idStatuscompras'))
		{
				//verifica o status anterior para dar baixa nas tb
				if (in_array($status_atual, $status_praestoque))
				{
					/*if($status_atual == 9)
					{
						//retirar da tb de saida de estoque
						$this->data['saida_estoque'] = $this->pedidocompra_model->gettable('estoque_saida','idPedidoCompraItens ='. $idPedidoCompraItens);
        
		 $idestoque_saida = $this->data['saida_estoque']->idestoque_saida;
		  if ($idestoque_saida <> null)
		 {
			 $this->pedidocompra_model->delete('estoque_saida','idestoque_saida',$idestoque_saida);
		 }
						
						
						
					}
					elseif($status_atual == 8)
					{
						//retirar da tb de entrada de estoque
						$this->data['entrada_estoque'] = $this->pedidocompra_model->gettable('estoque_entrada','idPedidoCompraItens ='. $idPedidoCompraItens);
        
		 $idestoque_entrada = $this->data['entrada_estoque']->idestoque_entrada;
		  if ($idestoque_entrada <> null)
		 {
			 $this->pedidocompra_model->delete('estoque_entrada','idestoque_entrada',$idestoque_entrada);
		 }
						
					}*/
					if($status_atual == 7)
					{
						//retirar da tb de reserva de estoque
						$this->data['reserva_estoque'] = $this->pedidocompra_model->gettable('estoque_reservado','id_distribuir ='. $idDistribuir2);
        
		 $id_estoque_reservado = $this->data['reserva_estoque']->id_estoque_reservado;
		  if ($id_estoque_reservado <> null)
		 {
			 $this->pedidocompra_model->delete('estoque_reservado','id_estoque_reservado',$id_estoque_reservado);
		 }
						
					}
				}
				
				if (in_array($this->input->post('idStatuscompras'), $status_praestoque))
				{
					
					if($this->input->post('idStatuscompras') == 9)
					{
						$this->data['saida_estoque'] = $this->pedidocompra_model->gettable('estoque_saida','id_distribuir ='. $idDistribuir2);
        
		 $id_estoque_saida = $this->data['saida_estoque']->idestoque_saida;
		  if ($id_estoque_saida == null)
		 {
			 
		 
						$data4 = array(
                
                'id_os' => $this->data['dados_dist']->idOs,
                'id_produto' => $this->data['dados_dist']->idInsumos,
                'id_distribuir' => $idDistribuir2,
                'id_compra' => $this->input->post('idPedidoCompra'),
                'idPedidoCompraItens' => $idPedidoCompraItens
                
                  
            );
		
		$this->pedidocompra_model->add('estoque_saida', $data4, true);	
	}
					}
					elseif($this->input->post('idStatuscompras') == 8)
					{
						$this->data['entrada_estoque'] = $this->pedidocompra_model->gettable('estoque_entrada','id_distribuir ='. $idDistribuir2);
        
		 $id_estoque_entrada = $this->data['entrada_estoque']->idestoque_entrada;
		  if ($id_estoque_entrada == null)
		 {
			 
			 
						$data4 = array(
                
                'id_os' => $this->data['dados_dist']->idOs,
                'id_produto' => $this->data['dados_dist']->idInsumos,
                'id_distribuir' => $idDistribuir2,
                'id_compra' => $this->input->post('idPedidoCompra'),
                'idPedidoCompraItens' => $idPedidoCompraItens
                
                  
            );
		
		$this->pedidocompra_model->add('estoque_entrada', $data4, true);
		 }
					}
					else
					{
					if($this->data['dados_dist']->idOs <> 1 && $this->data['dados_dist']->idOs <> 2 && $this->data['dados_dist']->idOs <> 3)
			{	
						$data4 = array(
                
                'id_os' => $this->data['dados_dist']->idOs,
                'id_produto' => $this->data['dados_dist']->idInsumos,
                'id_distribuir' => $idDistribuir2,
                
                
                  
            );
		
		$this->pedidocompra_model->add('estoque_reservado', $data4, true);
						
					}	
					}
				}
		}
		
		
		if($this->input->post('idStatuscompras') <> 7)
		{
		
				$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir2);
		}
		else
		{
			if($this->data['dados_dist']->idOs <> 1 && $this->data['dados_dist']->idOs <> 2 && $this->data['dados_dist']->idOs <> 3)
			{
				$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir2);
			}
		}

		
			 }
			 }
			 
			 
 	
					
			
				
				
				
				 $this->session->set_flashdata('success','Pedido salvo com sucesso.');
               redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$this->input->post('idPedidoCompra'));
			
           
		
		
	}
	public function salvaritemcompragrupo2(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para editar item.');
          redirect(base_url());
        }
		$this->load->model('cotacao_model');
		
	 $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
		
		 
	
				
$data3 = array(
                'id_status_grupo' => $this->input->post('idgrupo')
            );
	
				$itenspc = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompra ='. $this->input->post('idPedidoCompra'),1);
			 foreach ($itenspc as $r)
			 {
        $idPedidoCompraItens =  $r->idPedidoCompraItens;
		
		
		
				$this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $idPedidoCompraItens);
			 }
			 
					
				 $this->session->set_flashdata('success','Grupo salvo com sucesso.');
               redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$this->input->post('idPedidoCompra'));
		
	}
	function editarpedido(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para editar Pedido de compra.');
           redirect(base_url());
        }
         $this->load->library('table');
         $this->load->library('pagination');
         
         $this->load->model('os_model');
		$this->load->model('orcamentos_model');		 
		$this->load->model('cotacao_model');		 
         
         $config['base_url'] = base_url().'index.php/pedidocompra/editarpedido/';
 //trazer maior q  3 o status        
$this->data['dados_statuscompra'] = $this->pedidocompra_model->getstatus_compra2('2');
$this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
$this->data['dados_statuscondicao'] = $this->pedidocompra_model->getstatus_cond_pg('');
		 
         
        $idPedidoCompra = $this->uri->segment(3);
        
       
		
		
		 $this->data['results'] = $this->pedidocompra_model->getpedidocomprafornece($idPedidoCompra);
		 $this->data['resultsnf'] = $this->pedidocompra_model->getpedidocomprafornece($idPedidoCompra,'1');
		
         
 
        
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
       
	    $this->data['view'] = 'pedidocompra/editarpedido';
       	$this->load->view('tema/topo',$this->data);
       //$this->load->view('tema/rodape');
		
    }
	function editarpedidocompra(){
		
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para editar PC.');
          redirect(base_url());
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

  
    $idPedidoCompra= $this->input->post('idPedidoCompra');
   
  
$desconto = str_replace(".","",$this->input->post('desconto'));
$desconto = str_replace(",",".",$desconto);
if($desconto == '')
{
	$desconto = '0.00';
}
/*$ipi = str_replace(".","",$this->input->post('ipi'));
$ipi = str_replace(",",".",$ipi);
if($ipi == '')
{
	$ipi = '0.00';
}*/
$outros = str_replace(".","",$this->input->post('outros'));
$outros = str_replace(",",".",$outros);
if($outros == '')
{
	$outros = '0.00';
}
$frete = str_replace(".","",$this->input->post('frete'));
$frete = str_replace(",",".",$frete);
if($frete == '')
{
	$frete = '0.00';
}
$icms = str_replace(".","",$this->input->post('icms'));
$icms = str_replace(",",".",$icms);
if($icms == '')
{
	$icms = '0.00';
}
if($this->input->post('previsao_entrega') <> '')
{
	$previsao_entrega = explode('/', $this->input->post('previsao_entrega'));
$previsao_entrega = $previsao_entrega[2].'-'.$previsao_entrega[1].'-'.$previsao_entrega[0];		
}
else{
	$previsao_entrega = null;
}
if($this->input->post('fornecedor_id') <> '')
{
	$fornecedor_id = (int)$this->input->post('fornecedor_id');
}
else
{
	$fornecedor_id = null;
}

if($this->input->post('emitente_id') <> '')
{
	$emitente_id = $this->input->post('emitente_id');
}
else
{
	$emitente_id = null;
}	
if($this->input->post('idCondPgto') <> '')
{
	$idCondPgto = $this->input->post('idCondPgto');
}
else
{
	$idCondPgto = null;
}
/*if($this->input->post('notafiscal') <> '')
{
	$notafiscal = $this->input->post('notafiscal');
}
else
{
	$notafiscal = null;
}
if($this->input->post('datanf') <> '')
{
	$datanf = explode('/', $this->input->post('datanf'));
$datanf = $datanf[2].'-'.$datanf[1].'-'.$datanf[0];		
}
else{
	$datanf = null;
}
*/
if($this->input->post('cod_pgto') <> '')
{
	$cod_pgto = $this->input->post('cod_pgto');
}
else
{
	$cod_pgto = null;
}
if($this->input->post('obs') <> '')
{
	$obs = $this->input->post('obs');
}
else
{
	$obs = null;
}

if($this->input->post('prazo_entrega') <> '')
{
	$prazo_entrega = $this->input->post('prazo_entrega');
}
else
{
	$prazo_entrega = null;
}


					
 $data3 = array(
                'idFornecedores' => $fornecedor_id,
                'idEmitente' => $emitente_id,
                'previsao_entrega' => $previsao_entrega,
                'prazo_entrega' => $prazo_entrega,
                'idCondPgto' => $idCondPgto,
                'cod_pgto' => $cod_pgto,
                'obs' => $obs,
                'ipi' => $ipi,
                'desconto' => $desconto,
                'outros' => $outros,
                'frete' => $frete,

                'icms' => $icms
               
				 
            );
			
			
				
		$this->pedidocompra_model->edit('pedido_compras', $data3, 'idPedidoCompra', $idPedidoCompra);		
					
			

	$this->session->set_flashdata('success','Pedido alterado com sucesso!');
	
				redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompra);
			
	
		
		 
		
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
    $idPedidoCompra= $this->input->post('idPedidoCompra');
   
  
	$this->load->model('cotacao_model');	 
	
  
        if ($this->input->post('id_item_pc1') == '') {
            
			$this->session->set_flashdata('error','Erro ao editar!');
                redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompra);
				
         } else {
			 
			 		
			

$data3 = array(
                'liberado_edit_compras' => '1'
            );
			
			
	$this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $id_item_pc1);
			

	$this->session->set_flashdata('success','Item Liberado com sucesso!');
	
				redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompra);
			
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
    $idPedidoCompra= $this->input->post('idPedidoCompra');
   
  
	$this->load->model('cotacao_model');	 
	
  
        if ($this->input->post('id_item_pc2') == '') {
            
			$this->session->set_flashdata('error','Erro ao editar!');
                redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompra);
				
         } else {
			 
			 		
			

$data3 = array(
                'liberado_edit_compras' => '0'
            );
			
			
	$this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $id_item_pc2);
			

	$this->session->set_flashdata('success','Item Liberado com sucesso!');
	
				redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompra);
			
		 }
		
		 
		
	}
	
	function editarpc(){
		
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
          $this->session->set_flashdata('error','Você não tem permissão para editar PC.');
          redirect(base_url());
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

   $idPedidoCompraItens = $this->input->post('idPedidoCompraItens_');
    $idPedidoCompra_n= $this->input->post('idPedidoCompra_n');
   
  
		 
		
  
  
        if(count($this->pedidocompra_model->getqtditens($idPedidoCompra_n)) == 0 || $this->input->post('idPedidoCompra_n') == '') {
            
			$this->session->set_flashdata('error','Informe o número válido do pedido!');
                redirect(base_url() . 'index.php/pedidocompra/editarpedito/'.$idPedidoCompra);
				
         } else {
			 
			  $this->data['dadosped'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $idPedidoCompraItens);
        
		
		 $idCotacaoItens = $this->data['dadosped']->idCotacaoItens;
		
		 $idPedidoCompra = $this->data['dadosped']->idPedidoCompra; 
		 
		
			 if(count($this->pedidocompra_model->getqtditens($idPedidoCompra)) == 1)
			{
				$this->pedidocompra_model->delete('pedido_compras','idPedidoCompra',$idPedidoCompra); 
			}

 $data3 = array(
                'idPedidoCompra' => $idPedidoCompra_n
				 
            );
				
			
	$this->pedidocompra_model->edit('pedido_cotacaoitens', $data3, 'idCotacaoItens', $idCotacaoItens);

			$data4 = array(
                'idPedidoCompra' => $idPedidoCompra_n
				 
            );	
				
		$this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $idPedidoCompraItens);		
					
			

	$this->session->set_flashdata('success','Pedido alterado com sucesso!');
	
				redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompra_n);
			
		 }
		
		 
		
	}
	
	
	function excluir_itempedido(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dPedCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir item pedido.');
           redirect(base_url());
        }

          $idPedidoCompraItens =  $this->input->post('idPedidoCompraItens_nn');
          $excluirpedidocompra =  $this->input->post('todos');
		 
		
		 $this->data['dadosped'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $idPedidoCompraItens);
        
		  $idCotacaoItens =  $this->data['dadosped']->idCotacaoItens;
         $idPedidoCompra =  $this->data['dadosped']->idPedidoCompra;
       
	    $this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $idCotacaoItens);
			 
        $idDistribuir =  $this->data['dadosped2']->idDistribuir;
       
        
        if ($idCotacaoItens == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir item.'); 
			  redirect(base_url() . 'index.php/pedidocompra/gerenciar/'.$idPedidoCompra);
            
        }
		

      
			
			
			$data3 = array(
                'idStatuscompras' => '6'
            );
			
			$data4 = array(
                'idPedidoCompra' => null,
                'idPedidoCompraItens' => null
            );
			
			
			if($excluirpedidocompra == 'nao')
			{
			
	$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
	$this->pedidocompra_model->edit('pedido_cotacaoitens', $data4, 'idCotacaoItens', $idCotacaoItens);
			
		
			if(count($this->pedidocompra_model->getqtditens($idPedidoCompra)) == 1)
			{
				$this->pedidocompra_model->delete('pedido_compras','idPedidoCompra',$idPedidoCompra);  
			}
			$this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$idPedidoCompraItens); 
			
			 $this->session->set_flashdata('success','Item excluido com sucesso do pedido!'); 
				if(count($this->pedidocompra_model->getqtditens($idPedidoCompra)) == 1)
			{
        redirect(base_url() . 'index.php/pedidocompra/gerenciar/'.$idPedidoCompra);
			}
			else
			{
				  redirect(base_url() . 'index.php/pedidocompra');
			}
		
			}
			else
			{
				$itenspc = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idPedidoCompra ='. $idPedidoCompra,1);
			 foreach ($itenspc as $r)
			 {
        $idDistribuir2 =  $r->idDistribuir;
		
		
		
				$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir2);
			 }
			 $this->pedidocompra_model->edit('pedido_cotacaoitens', $data4, 'idPedidoCompra', $idPedidoCompra);
			 $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompra',$idPedidoCompra); 
				$this->pedidocompra_model->delete('pedido_compras','idPedidoCompra',$idPedidoCompra);
				$this->session->set_flashdata('success','Pedido excluido com sucesso!'); 
				redirect(base_url() . 'index.php/pedidocompra');
				
			}
	
        
                  
        
        

       
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


    
    function editaros() {
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar OS.');
          redirect(base_url());
        }
		$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('data_abertura_editada', '', 'trim|required|xss_clean');
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


	$data_abertura_editada = $this->input->post('data_abertura_editada');
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
	
	 
	$data_abertura_editada = explode('/', $data_abertura_editada);
	$data_abertura_editada = $data_abertura_editada[2].'-'.$data_abertura_editada[1].'-'.$data_abertura_editada[0];
	
	
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
	

 
if($this->input->post('qtd_os') < $this->input->post('qtd_os_original'))
{
	$gerarnovaqtd = $this->input->post('qtd_os_original') - $this->input->post('qtd_os');
	 $data3 = array(
                'data_abertura_editada' => $data_abertura_editada,
                'data_abertura' => $this->input->post('data_abertura'),
                'obs_controle' => $this->input->post('obs_controle'),
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
                
                'idStatusOs' => $this->input->post('idStatusOs'),
                'unid_execucao' => $this->input->post('unid_execucao'),
                'unid_faturamento' => $this->input->post('unid_faturamento'),
                'contrato' => $this->input->post('contrato'),
                'nf_venda_dev' => $this->input->post('nf_venda_dev'),
                'nf_cliente' => $this->input->post('nf_cliente'),
                'numero_nf' => $this->input->post('numero_nf'),
                'numpedido_os' => $this->input->post('numpedido_os')
                
                
            );
	
		$id_novo = $this->orcamentos_model->add('os', $data3, true);

 $data4 = array(
                
                'idOs_principal' => $this->input->post('idOs2'),
                'idOs_gerada' => $id_novo
                
                  
            );
		
		$this->orcamentos_model->add('os_vinculada', $data4, true);	
	
	
	
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
                'tamanho' => $item->tamanho
            );
			
		$this->os_model->add('anexo_desenho', $data_an)	;
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
			
		$this->os_model->add('anexo_nfcliente', $data_an)	;
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
			
		$this->os_model->add('anexo_nfvenda', $data_an)	;
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
			
		$this->os_model->add('anexo_notafiscal', $data_an)	;
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
			
		$this->os_model->add('anexo_pedido', $data_an)	;
	}	
		
	
	
	
}
	
           
            $data = array(
                'data_abertura_editada' => $data_abertura_editada,
                'data_entrega' => $data_entrega,
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
                'nf_venda_dev' => $this->input->post('nf_venda_dev'),
                'nf_cliente' => $this->input->post('nf_cliente'),
                'numero_nf' => $this->input->post('numero_nf'),
                'numpedido_os' => $this->input->post('numpedido_os')
                
                
            );
			$data2 = array(
                'descricao_item' => $this->input->post('descricao_os')
                
            );


            if ($this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs2')) == TRUE) {
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
                'obs_controle' => $this->input->post('obs_controle')
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

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
             //$campo = $_GET['campo'];
			
            $this->os_model->autoCompleteDistribuir($q);
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
        $this->form_validation->set_rules('idInsumos2', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantidade', '', 'trim|required|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe nome do arquivo!');
                redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
				
        } else {
  
        	

        	
        	

            $data = array(
                'idInsumos' => $this->input->post('idInsumos2'),
                'dimensoes' => $this->input->post('dimensoes'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $this->input->post('quantidade'),
                'idOs' => $this->input->post('idOs')
            );

            if ($this->os_model->add('distribuir_os', $data) == TRUE) {
                $this->session->set_flashdata('success','Item adicionado com sucesso!');
                redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'os/distribuiros';
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


        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe os dados necessarios!');
                redirect(base_url() . 'index.php/os/distribuiros/'.$this->input->post('idOs'));
				
        } else {
  
        	

        	
        	

            $data = array(
                'idInsumos' => $this->input->post('idInsumos'),
                'dimensoes' => $this->input->post('dimensoes'),
                'obs' => $this->input->post('obs'),
                'quantidade' => $this->input->post('quantidade'),
                'data_alteracao' => date('Y-m-d H:i:s'),
                'idOs' => $this->input->post('idOs')
            );
			 
  if ($this->os_model->edit('distribuir_os', $data, 'idDistribuir', $this->input->post('idDistribuir')) == TRUE) {
                $this->session->set_flashdata('success','Item adicionado com sucesso!');
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
		

       if( $this->os_model->getitemcompra($idDistribuir) == false)
		{
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
            'allowed_types' => 'png|jpg|jpeg|bmp|dwg|pdf|exe|docx|txt',
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
            'allowed_types' => 'png|jpg|jpeg|bmp|dwg|pdf|exe|docx|txt',
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
            'allowed_types' => 'png|jpg|jpeg|bmp|dwg|pdf|exe|docx|txt',
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
        
        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->os_model->autoCompleteProduto($q);
        }

    }

    public function autoCompleteCliente(){

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->os_model->autoCompleteCliente($q);
        }

    }
	 public function autoCompleteEmitente(){

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->pedidocompra_model->autoCompleteEmitente($q);
        }

    }
	
	 public function autoCompletefornecedor(){

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->pedidocompra_model->autoCompleteFornecedor($q);
        }

    }

    public function autoCompleteUsuario(){

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->os_model->autoCompleteUsuario($q);
        }

    }

    public function autoCompleteServico(){

        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
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

