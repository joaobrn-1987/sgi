<?php
class Estoque extends CI_Controller {
    

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
            }
            $this->load->helper(array('codegen_helper'));
           $this->load->model('estoque_model','',TRUE);
		  
		   
		if( $this->uri->segment(2) == 'estoque')
		{
			$this->data['menuEstoque'] = 'Estoque';
		}
		elseif( $this->uri->segment(2) == 'estoquesaida')
		{
			$this->data['menuSaidaEstoque'] = 'Saída Estoque';
		}
		
		else
		{
			//$this->uri->segment(2) == 'almoxarifado'
			$this->data['menuEstoque'] = 'Estoque';
		}
		
		
		
		
	
	}	
	
	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vEstoque')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Estoque.');
           redirect(base_url());
        }
         $this->load->library('table');
         $this->load->library('pagination');
         
		 $this->load->model('orcamentos_model');
		 
           $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();   
           $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');   
         $this->data['categoria'] = $this->estoque_model->get_table('categoriaInsumos','descricaoCategoria asc');
		 
         $config['base_url'] = base_url().'index.php/estoque/gerenciar/';
            
         
         /*$idOs = $this->input->post('idOs');
         $cod_orc = $this->input->post('idOrcamentos');
         $clientes_id  = $this->input->post('clientes_id');
         $idProdutos = $this->input->post('idProdutos');
         $numpedido_os = $this->input->post('numpedido_os');
         $numero_nf = $this->input->post('numero_nf');*/
         $idInsumos = $this->input->post('idInsumos22a');
		 $codigo = $this->input->post('codigo');
         $catego = "";
		 if(!empty($this->input->post('cat')))
		{
			$conteudo = $this->input->post('cat');
		$catego="(";
		$primeiro = true;
			foreach($conteudo as $cat3)
			{
				if($primeiro)
				{
					$catego.=$cat3;
					$primeiro = false;
				}
				else
				{
					$catego.=",".$cat3;
				}
			}
			$catego .= ")";
		}
		$querydatacadastro = '';
		 $dataInicialcad = $this->input->post('dataInicialcad');
         $dataFinalcad = $this->input->post('dataFinalcad');
		
		 if(!empty($dataInicialcad) && !empty($dataFinalcad))
		 {
		  $dataInicialcad2 = explode('/', $dataInicialcad);
           $dataInicialcad2 = $dataInicialcad2[2].'-'.$dataInicialcad2[1].'-'.$dataInicialcad2[0];
		
		
		 $dataFinalcad2 = explode('/', $dataFinalcad);
         $dataFinalcad2 = $dataFinalcad2[2].'-'.$dataFinalcad2[1].'-'.$dataFinalcad2[0];
		
		
		 $querydatacadastro = " and estoque_entrada.data_entrada BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59' and estoque_saida.data_saida BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
		 }	

		 /*if (!empty($idOs) || !empty($cod_orc) || !empty($clientes_id) || !empty($idProdutos) || !empty($numpedido_os) || !empty($numero_nf) ) {*/
		 if (!empty($idInsumos)  || !empty($catego) || !empty($querydatacadastro) || !empty($codigo))
		 {
            $this->data['results'] = $this->estoque_model->getWhereLikeos($idInsumos,$catego,$querydatacadastro,$codigo);
 
        $config['total_rows'] = $this->estoque_model->numrowsWhereLikeos($idInsumos, $catego, $querydatacadastro,$codigo);
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
			 


         
			 $config['total_rows'] = count( $this->estoque_model->getestoqueentrada2('insumos','estoque_entrada.dimensao,insumos.idInsumos, insumos.descricaoInsumo, insumos.estoqueminimo, sum(estoque_entrada.quantidade) as qtd,sum(case when estoque_saida.qtd_saida = null then 0 else estoque_saida.qtd_saida end ) as qtd_saida, (sum(estoque_entrada.quantidade) - sum(estoque_saida.qtd_saida)) as atual , sum(CASE WHEN estoque_entrada.id_estoque_saida = 0 THEN estoque_entrada.vlr_unit ELSE 0 END) as media_unit, sum(CASE WHEN estoque_entrada.id_estoque_saida = 0 THEN estoque_entrada.vlr_unit ELSE 0 END) as valortotal,  categoriaInsumos.descricaoCategoria, subcategoriaInsumo.descricaoSubcategoria,insumos.pn_insumo, insumos.localizacao',''));
			 
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
			 
			 
          
		    
         $this->data['results'] = $this->estoque_model->getos('insumos','estoque_entrada.dimensao,insumos.idInsumos, insumos.descricaoInsumo, insumos.estoqueminimo, sum(estoque_entrada.quantidade) as qtd,sum(case when estoque_saida.qtd_saida = null then 0 else estoque_saida.qtd_saida end ) as qtd_saida, (sum(estoque_entrada.quantidade) - sum(estoque_saida.qtd_saida)) as atual , sum(CASE WHEN estoque_entrada.id_estoque_saida = 0 THEN estoque_entrada.vlr_unit ELSE 0 END) as media_unit, sum(CASE WHEN estoque_entrada.id_estoque_saida = 0 THEN estoque_entrada.vlr_unit ELSE 0 END) as valortotal,  categoriaInsumos.descricaoCategoria, subcategoriaInsumo.descricaoSubcategoria,insumos.pn_insumo, insumos.localizacao','',$config['per_page'],$this->uri->segment(3));
        
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
       
	    $this->data['view'] = 'estoque/estoque';
       	$this->load->view('tema/topo',$this->data);
       $this->load->view('tema/rodape');
		
    }
	function cadastrarestoque(){
		$i = '';
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aEstoque')){
          $this->session->set_flashdata('error','Você não tem permissão para cadastrar Estoque.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


				
				
if(empty($this->input->post('compra')))
{

        $this->form_validation->set_rules('idEmitente', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idInsumos2', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantidade', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('vlrunit', '', 'trim|required|xss_clean');
		$normal = 1;
}
else
{
	
  
	 $this->form_validation->set_rules('idEmitente_e1', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idInsumos_e1', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantidade_e1', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('valor_unitario_e1', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idPedidoCompra_e1', '', 'trim|required|xss_clean');
       
        $this->form_validation->set_rules('idPedidoCompraItens_e1', '', 'trim|required|xss_clean');
		$normal = 0;
}
		
		if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe todos os dados!');
			if($normal == 1)
			{
				redirect(base_url() . 'index.php/estoque');
            }
			else
			{
				redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$this->input->post('idPedidoCompra_e1'));
			}
        } 
		else 
		{
			if($normal == 1)
			{
				
			if($this->input->post('quantidade') > 0 && is_numeric($this->input->post('quantidade')))
			{
			$valorunita = str_replace(".","",$this->input->post('vlrunit'));
			$valorunita = str_replace(",",".",$valorunita);
	
	$dime = str_replace(" ","",$this->input->post('dimensao'));
	
			for($i = 0; $i < $this->input->post('quantidade'); $i++)
			{
            $data = array(
               
                'id_emitente' => $this->input->post('idEmitente'),
				 'id_produto' => $this->input->post('idInsumos2'),
				 'dimensao' => strtoupper($dime),
                'quantidade' => 1,
                'vlr_unit' => $valorunita,
                'data_entrada' => date('Y-m-d H:i:s'),
                'usuario_cad' => $this->session->userdata('idUsuarios')
            );
			
			$this->estoque_model->add('estoque_entrada', $data, true);
			
			
				
			//echo "i=".$i;	
			//echo "qtd=".$this->input->post('quantidade');	
			}
			
			
			 $this->session->set_flashdata('success','Item adicionado ao estoque sucesso!');
				 redirect(base_url() . 'index.php/estoque');
			
			}
			else{
			$this->session->set_flashdata('error','Quantidade inferior a 1 ou numero nao inteiro!');
				 redirect(base_url() . 'index.php/estoque');	
			}
			
			}
			else
			{
				
  
				//se vier do pedido de compra
				if($this->input->post('quantidade_e1') > 0 && is_numeric($this->input->post('quantidade_e1')))
			{
			
	
	$dime = str_replace(" ","",$this->input->post('dimensoes_e1'));
	
			for($i = 0; $i < $this->input->post('quantidade_e1'); $i++)
			{
            $data = array(
               
                'id_emitente' => $this->input->post('idEmitente_e1'),
				 'id_produto' => $this->input->post('idInsumos_e1'),
				 'dimensao' => strtoupper($dime),
				 'quantidade' => 1,
				 'data_entrada' => date('Y-m-d H:i:s'),
                'vlr_unit' => $this->input->post('valor_unitario_e1'),
                'idPedidoCompraItens' => $this->input->post('idPedidoCompraItens_e1'),
                'id_compra' => $this->input->post('idPedidoCompra_e1'),
                'usuario_cad' => $this->session->userdata('idUsuarios')
            );
			
			$this->estoque_model->add('estoque_entrada', $data, true);
			
			
				
			//echo "i=".$i;	
			//echo "qtd=".$this->input->post('quantidade');	
			}
			
			
			 $this->session->set_flashdata('success','Item adicionado ao estoque sucesso!');
				 redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$this->input->post('idPedidoCompra_e1'));
			
			}
			else{
			$this->session->set_flashdata('error','Quantidade inferior a 1 ou numero nao inteiro!');
				 redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$this->input->post('idPedidoCompra_e1'));
			}
			
			}	
		}
		
	}
	
	function saidaestoque(){
		$this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');   
		$i = '';
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aEstoque')){
          $this->session->set_flashdata('error','Você não tem permissão para retirar Estoque.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

   

        $this->form_validation->set_rules('idEmitente2', '', 'trim|required|xss_clean');
		if(empty($this->input->post('id_entra')))
			{
        $this->form_validation->set_rules('idInsumos22', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantidade2', '', 'trim|required|xss_clean');
			}
       //$this->form_validation->set_rules('vlrunit2', '', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_setor', '', 'trim|required|xss_clean');
      
		
		if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
			$this->session->set_flashdata('error','Informe todos os dados!');
			
				redirect(base_url() . 'index.php/estoque/estoquesaida');
            
        } 
		else 
		{
			
			if(empty($this->input->post('id_entra')))
			{
			if($this->input->post('quantidade2') > 0 && is_numeric($this->input->post('quantidade2')))
			{
			//$valorunita = str_replace(".","",$this->input->post('vlrunit2'));
			//$valorunita = str_replace(",",".",$valorunita);
			if(!empty($this->input->post('id_os')))
			{
				$id_os = $this->input->post('id_os');
			}
			else{
				$id_os = null;
			}
	
			for($i = 0; $i < $this->input->post('quantidade2'); $i++)
			{
				//verificar estoque
				$entrada = $this->estoque_model->getestoqueentrada_livre($this->input->post('idInsumos22'));
			if(!empty($entrada))
			{
				 $id_entrada = $entrada[0]->idestoque_entrada;
			}
			
			
			
			
			
			
			
            $data = array(
               
                'id_emitente' => $this->input->post('idEmitente2'),
				 'id_produto' => $this->input->post('idInsumos22'),
				 'id_setor' => $this->input->post('id_setor'),
                'qtd_saida' => 1,
                //'valor_unit' => $valorunita,
                'id_os' => $id_os,
				'data_saida' => date('Y-m-d H:i:s'),
                
                'user_cad' => $this->session->userdata('idUsuarios')
            );
			 $idsaida = $this->estoque_model->add('estoque_saida', $data, true);
			
			
			 $data2 = array(
               
                'id_estoque_saida' => $idsaida
				
            );
			
			
			$this->estoque_model->edit('estoque_entrada', $data2, 'idestoque_entrada', $id_entrada);	
				
				
			}
			
			 $this->session->set_flashdata('success','Item de estoque retirado com sucesso!');
				 redirect(base_url() . 'index.php/estoque/estoquesaida');
			
			}
			else{
			$this->session->set_flashdata('error','Quantidade inferior a 1 ou numero nao inteiro!');
				 redirect(base_url() . 'index.php/estoque/estoquesaida');	
			}
		}
		else
		{
			//retira por item
			
			
			
			$entrada = $this->estoque_model->gettable("estoque_entrada","estoque_entrada.idestoque_entrada",$this->input->post('id_entra'));
			
			
			if(!empty($this->input->post('id_os')))
			{
				$id_os = $this->input->post('id_os');
			}
			else{
				$id_os = null;
			}
			
			 $data = array(
               
                'id_emitente' => $this->input->post('idEmitente2'),
				 'id_produto' => $entrada[0]->id_produto,
				 'id_setor' => $this->input->post('id_setor'),
                'qtd_saida' => 1,
                //'valor_unit' => $valorunita,
                'id_os' => $id_os,
                'data_saida' => date('Y-m-d H:i:s'),
                'user_cad' => $this->session->userdata('idUsuarios')
            );
			 $idsaida = $this->estoque_model->add('estoque_saida', $data, true);
			
			
			 $data2 = array(
               
                'id_estoque_saida' => $idsaida
				
            );
			
			
			$this->estoque_model->edit('estoque_entrada', $data2, 'idestoque_entrada',$this->input->post('id_entra'));	
				
			 $this->session->set_flashdata('success','Item de estoque retirado com sucesso!');
				 redirect(base_url() . 'index.php/estoque/estoquesaida');	
			
		}
			
			
		}
		
	}
	 
	 
	function estoquesaida(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vEstoque')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Estoque.');
           redirect(base_url());
        }
         $this->load->library('table');
         $this->load->library('pagination');
         
		 $this->load->model('orcamentos_model');
		 
           $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();   
           $this->data['dados_setor'] = $this->estoque_model->get_table('setor_empresa', 'nomesetor asc');   
         $this->data['categoria'] = $this->estoque_model->get_table('categoriaInsumos','descricaoCategoria asc');
		 
         $config['base_url'] = base_url().'index.php/estoque/gerenciar/';
            
         
         /*$idOs = $this->input->post('idOs');
         $cod_orc = $this->input->post('idOrcamentos');
         $clientes_id  = $this->input->post('clientes_id');
         $idProdutos = $this->input->post('idProdutos');
         $numpedido_os = $this->input->post('numpedido_os');
         $numero_nf = $this->input->post('numero_nf');*/
         $idInsumos = $this->input->post('idInsumos22a');
         $codigo = $this->input->post('codigo');
         $catego = "";
		 if(!empty($this->input->post('cat')))
		{
			$conteudo = $this->input->post('cat');
		$catego="(";
		$primeiro = true;
			foreach($conteudo as $cat3)
			{
				if($primeiro)
				{
					$catego.=$cat3;
					$primeiro = false;
				}
				else
				{
					$catego.=",".$cat3;
				}
			}
			$catego .= ")";
		}
		$querydatacadastro = '';
		 $dataInicialcad = $this->input->post('dataInicialcad');
         $dataFinalcad = $this->input->post('dataFinalcad');
		
		 if(!empty($dataInicialcad) && !empty($dataFinalcad))
		 {
		  $dataInicialcad2 = explode('/', $dataInicialcad);
           $dataInicialcad2 = $dataInicialcad2[2].'-'.$dataInicialcad2[1].'-'.$dataInicialcad2[0];
		
		
		 $dataFinalcad2 = explode('/', $dataFinalcad);
         $dataFinalcad2 = $dataFinalcad2[2].'-'.$dataFinalcad2[1].'-'.$dataFinalcad2[0];
		
		
		 $querydatacadastro = " and estoque_entrada.data_entrada BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59' and estoque_saida.data_saida BETWEEN '$dataInicialcad2 00:00:00' AND '$dataFinalcad2 23:59:59'";
		 }	

		 /*if (!empty($idOs) || !empty($cod_orc) || !empty($clientes_id) || !empty($idProdutos) || !empty($numpedido_os) || !empty($numero_nf) ) {*/
		 if (!empty($idInsumos)  || !empty($catego) || !empty($querydatacadastro) || !empty($codigo))
		 {
            $this->data['results'] = $this->estoque_model->getWhereLikeosentrada($idInsumos,$catego,$querydatacadastro,$codigo);
 
        $config['total_rows'] = $this->estoque_model->numrowsWhereLikeosentrada($idInsumos, $catego, $querydatacadastro,$codigo);
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
			 


         
			 $config['total_rows'] = count( $this->estoque_model->getestoqueentrada2entrada('insumos','estoque_entrada.idestoque_entrada,estoque_entrada.data_entrada, estoque_saida.data_saida,estoque_entrada.usuario_cad as usercad, estoque_saida.user_cad as usersaida ,estoque_entrada.dimensao, estoque_entrada.id_compra, estoque_entrada.id_estoque_saida, insumos.pn_insumo, insumos.localizacao, categoriaInsumos.descricaoCategoria,subcategoriaInsumo.descricaoSubcategoria, insumos.idInsumos, insumos.descricaoInsumo, insumos.estoqueminimo, estoque_entrada.quantidade as qtd, estoque_entrada.vlr_unit',''));
			 
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
			 
			 
          
		    
         $this->data['results'] = $this->estoque_model->getosentrada('insumos','estoque_entrada.idestoque_entrada,estoque_entrada.data_entrada, estoque_saida.data_saida,estoque_entrada.usuario_cad as usercad, estoque_saida.user_cad as usersaida ,estoque_entrada.dimensao, estoque_entrada.id_compra, estoque_entrada.id_estoque_saida, insumos.pn_insumo, insumos.localizacao, categoriaInsumos.descricaoCategoria,subcategoriaInsumo.descricaoSubcategoria, insumos.idInsumos, insumos.descricaoInsumo, insumos.estoqueminimo, estoque_entrada.quantidade as qtd, estoque_entrada.vlr_unit','',$config['per_page'],$this->uri->segment(3));
        
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
       
	    $this->data['view'] = 'estoque/estoquesaida';
       	$this->load->view('tema/topo',$this->data);
       $this->load->view('tema/rodape');
		
    }

	function generateXlsx(){
		echo "gerandoxlsx";
		$conteudo = "<table><tr><td><img src='https://sgisistemas.site/assets5_2/img/logo/ubertec_logo.png'/></td>
		
		<td></td>
		
		</tr>
		
		</table>".
		
		"<table>
		
		<tr>
		
		<td><img src='http://10.10.10.198/ubertec/assets5_2/img/logo/ubertec_logo.png'/></td>
		
		<td></td>
		
		</tr>
		
		</table>";
		$filename = 'test2.xlsx';
		if (!$handle = fopen($filename, 'w+')) {

			echo "Cannot open file ($filename)";
			
			exit;
			
		}
		
		if (fwrite($handle, $conteudo) === FALSE) {
		
			echo "Não foi possível escrever no arquivo ($filename)";
			
			exit;
		
		}
		
		fclose($handle);
	}



}

