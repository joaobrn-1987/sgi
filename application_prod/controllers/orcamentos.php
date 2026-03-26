<?php

class Orcamentos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('orcamentos_model','',TRUE);
		$this->data['menuOrcamentos'] = 'Orcamentos';
	}	
	
	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vOrcamento')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Orcamentos.');
           redirect(base_url());
        }
   
       
         $this->load->library('table');
         $this->load->library('pagination');
         
         
       
         
         $config['base_url'] = base_url().'index.php/orcamentos/gerenciar/';
            
         
         $cod_orc = $this->input->post('cod_orc');
         $clientes_id  = $this->input->post('clientes_id');
         $idstatusOrcamento = $this->input->post('idstatusOrcamento');
         $idGrupoServico = $this->input->post('idGrupoServico');
         $idNatOperacao = $this->input->post('idNatOperacao');
         $referencia = $this->input->post('referencia');
         $num_pedido = $this->input->post('num_pedido');
         $num_nf = $this->input->post('num_nf');
         $status = $this->input->post('status_orc');
  $idProdutos = $this->input->post('idProdutos');
  $descricao_item = $this->input->post('descricao_item');
       
         if (!empty($cod_orc) || !empty($clientes_id) || !empty($idstatusOrcamento) || !empty($idGrupoServico) || !empty($idNatOperacao) || !empty($referencia) || !empty($num_pedido) || !empty($num_nf) || !empty($status <> '') || !empty($idProdutos <> '') || !empty($descricao_item <> '')) {
            
            $this->data['results'] = $this->orcamentos_model->getWhereLikeorc($cod_orc, $clientes_id, $idstatusOrcamento,$idGrupoServico, $idNatOperacao,$referencia, $num_pedido,$num_nf,$status,$idProdutos,$descricao_item);
 
             $config['total_rows'] = $this->orcamentos_model->numrowsWhereLikeorc($cod_orc, $clientes_id, $idstatusOrcamento,$idGrupoServico, $idNatOperacao,$referencia, $num_pedido,$num_nf,$status,$idProdutos,$descricao_item);
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


             $config['total_rows'] = $this->orcamentos_model->count('orcamento');
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
           
             $this->data['results'] = $this->orcamentos_model->getorc('orcamento','*','',$config['per_page'],$this->uri->segment(3));
        
         } 
       
        //Gera número único de orçamento com data e hora
      /*  $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
        $hora= date('H');
        $min = date('i');
        $seg = date('s');
        $dados['num_orcamento'] = $ano.$mes.$dia.$hora.$min.$seg;*/

        //Gera data de cadastro
        $ano_cadastro = date('Y');
        $mes_cadastro = date('m');
        $dia_cadastro = date('d');
        $data_cadastro= $dia_cadastro.'/'.$mes_cadastro.'/'.$ano_cadastro;
        $data['data_cadastro'] = $data_cadastro; 
        

         //$this->data['results'] = $this->insumos_model->get('insumos','idInsumos,nomeInsumo,documento,telefone,celular,email,rua,numero,bairro,cidade,estado,cep','',$config['per_page'],$this->uri->segment(3));
        
            // $data['menuInsumos'] = 'Insumos';
       
         $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
         $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
         $this->data['dados_clientes'] = $this->orcamentos_model->getCliente();
         $this->data['dados_vendedor']= $this->orcamentos_model->getVendedor();
         $this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
         $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
         $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
         
         $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();
       
        $this->data['view'] = 'orcamentos/orcamentos';
        $this->load->view('tema/topo',$this->data);
        $this->load->view('tema/rodape');



       
      
		
    }
	
    function adicionar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aOrcamento')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar Orcamentos.');
          redirect(base_url());
        }
		
		$filter = $this->input->post('filter');
        $field  = $this->input->post('field');
        $search = $this->input->post('search');
		
		
		 //$data['dados_cat'] = $this->insumos_model->getcat('categoriaInsumos','idCategoria,descricaoCategoria');
         $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
		 $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
         $this->data['dados_clientes'] = $this->orcamentos_model->getCliente();
         $this->data['dados_vendedor']= $this->orcamentos_model->getVendedor();
         $this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
         $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
         $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
         $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();
        //$this->data['dados_pn'] = $this->orcamentos_model->getPN();
        $this->data['results_pn'] = $this->orcamentos_model->getPN($field,$search);
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
  
		
		
		
        if ($this->form_validation->run('orcamento') == false) {  
          echo $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

          
           /* try {
                
                $dataVenda = explode('/', $dataVenda);
                $dataVenda = $dataVenda[2].'-'.$dataVenda[1].'-'.$dataVenda[0];


            } catch (Exception $e) {
               $dataVenda = date('Y/m/d'); 
            }*/

            $data = array(
                'idClientes' => $this->input->post('clientes_id'),
                'idEmitente' => $this->input->post('idEmitente'),
                'data_abertura' => date('Y-m-d H:i:s'),
                'idSolicitante' => $this->input->post('idSolicitante'),
                'idVendedor' => $this->input->post('idVendedor'),
                'idGerente' => $this->input->post('idGerente'),
                'idstatusOrcamento' => $this->input->post('idstatusOrcamento'),
                'referencia' => $this->input->post('referencia'),
                'cond_pgto' => $this->input->post('cond_pgto'),
                'garantia_servico' => $this->input->post('garantia_servico'),
                'idGrupoServico' => $this->input->post('idGrupoServico'),
                'idNatOperacao' => $this->input->post('idNatOperacao'),
                'num_pedido' => $this->input->post('num_pedido'),
                'num_nf' => $this->input->post('num_nf'),
                'entrega' => $this->input->post('entrega'),
                'validade' => $this->input->post('validade'),
                'entregaoutros' => $this->input->post('entregaoutros'),
                'obs' => $this->input->post('obs')
               
            );
			
			

            if (is_numeric($id = $this->orcamentos_model->add('orcamento', $data, true)) ) {
				
				//inserindo itens_de_orcamento
				$contador=count($this->input->post('item'));

				$total=0;

				for($x=0;$x<$contador;$x++)
				{
					$desconto_ = str_replace(".","",$this->input->post('desconto')[$x]);
					$desconto_ = str_replace(",",".",$desconto_);
					
					$val_ipi_ = str_replace(".","",$this->input->post('val_ipi')[$x]);
					$val_ipi_ = str_replace(",",".",$val_ipi_);
					
					
					
					
					$valorunita = str_replace(".","",$this->input->post('val_unit')[$x]);
					$valorunita1 = str_replace(",",".",$valorunita);
					
					$subtotal_ = str_replace(".","",$this->input->post('subtot')[$x]);
					$subtotal_ = str_replace(",",".",$subtotal_);
					
					$total_ = str_replace(".","",$this->input->post('vlr_total')[$x]);
					$total_ = str_replace(",",".",$total_);
					
			if($this->input->post('descricao_item')[$x] == '')
			{
				$des_produto = "XXXXXXX";
			}
			else
			{
				$des_produto = $this->input->post('descricao_item')[$x];
			}
			
			if($this->input->post('idProdutos')[$x] == '')
			{
				$id_produto = "4251";
			}
			else
			{
				$id_produto = $this->input->post('idProdutos')[$x];
			}
			
			
			
					 $data2 = array(
                'descricao_item' => $des_produto,
                'idProdutos' => $id_produto,
                'desconto' => $desconto_,
                'val_ipi' => $val_ipi_,
                'qtd' => $this->input->post('qtd')[$x],
                'val_unit' => $valorunita1,
                'prazo' => $this->input->post('prazo')[$x],
                'subtot' => $subtotal_,
                'valor_total' => $total_,
                'detalhe' => $this->input->post('detalhe')[$x],
                'idOrcamentos' => $id               
            );
			
				
					$this->orcamentos_model->add('orcamento_item', $data2, true);
				}
				
                $this->session->set_flashdata('success','Orçamento cadastrado com sucesso.');
                redirect('orcamentos/visualizar/'.$id);

            } else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
         
        $this->data['view'] = 'orcamentos/adicionarOrcamento';
        $this->load->view('tema/topo', $this->data);
    }
       
function adicionaritem(){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOrcamento')){
          $this->session->set_flashdata('error','Você não tem permissão para editar Orcamentos');
          redirect(base_url());
        }
		
		$data2 = array(
                'descricao_item' => '.',
                'idProdutos' => 4251,
                'desconto' => 0.00,
                'val_ipi' => 0.00,
                'qtd' => 1,
                'val_unit' => 0.00,
                'prazo' => 20,
                'subtot' => 0.00,
                'valor_total' => 0.00,
               
                'idOrcamentos' => $this->input->post('idOrcamentositem')               
            );
			
			
		
			$this->orcamentos_model->add('orcamento_item', $data2, true);
			
		$linha_orcitem = $this->orcamentos_model->get_number_linhas('orcamento_item', 'idOrcamentos = '.$this->input->post('idOrcamentositem'),'*');

        $linha_orcirep = $this->orcamentos_model->get_number_linhas('orcamento', 'idOrcamentos = '.$this->input->post('idOrcamentositem').' and status_orc = 1','*');
                        
            $linha_os = $this->orcamentos_model->get_number_linhas('os','idOrcamentos = '.$this->input->post('idOrcamentositem'),'DISTINCT(`idOrcamento_item`)');			

        /*'status_orc' => 1,
                        'idstatusOrcamento' => 12
        */
                        
        if(count($linha_os) == count($linha_orcitem) )
        {
            $data = array(
                        
                        'idstatusOrcamento' => 4
                    );
        }
        elseif(count($linha_os) == 0 && count($linha_orcirep) > 0)
        {
            $data = array(
                        
                        'idstatusOrcamento' => 12
                    );
        }

        elseif(count($linha_os) == 0 && count($linha_orcirep) == 0)
        {
            $data = array(
                        
                        'idstatusOrcamento' => 11
                    );
            
        }
        else
        {
            $data = array(
                        
                        'idstatusOrcamento' => 13
                    );
        }
                                                
        $this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $this->input->post('idOrcamentositem'));		 
                    
                    
                    
			
		$this->session->set_flashdata('success','Item adicionado com sucesso!');
        redirect(base_url() . 'index.php/orcamentos/editar/'.$this->input->post('idOrcamentositem'));
	}
    
    function editar() {
		
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOrcamento')){
          $this->session->set_flashdata('error','Você não tem permissão para editar Orcamentos');
          redirect(base_url());
        }
		
		$this->data['result'] = $this->orcamentos_model->getById('orcamento',$this->uri->segment(3));
		
		
		 //$data['dados_cat'] = $this->insumos_model->getcat('categoriaInsumos','idCategoria,descricaoCategoria');
         $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
		 $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
         $this->data['dados_clientes'] = $this->orcamentos_model->getCliente();
		 
		 $were = 'clientes.idClientes = '.$this->data['result']->idClientes;
         $this->data['dados_solicitante'] = $this->orcamentos_model->getsolicitante('clientes',$were);
         $this->data['dados_vendedor']= $this->orcamentos_model->getVendedor();
         $this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
         $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
         $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
         $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();
         $this->data['dados_item'] = $this->orcamentos_model->getorc_item($this->uri->segment(3));
		 //echo "jjjjj";
         //print_r($this->data['dados_item']);
		
		
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

		  if ($this->form_validation->run('orcamento') == false) {  
          echo $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

			
			 $data = array(
                'idClientes' => $this->input->post('clientes_id'),
                'idEmitente' => $this->input->post('idEmitente'),
                'idSolicitante' => $this->input->post('idSolicitante'),
                'idVendedor' => $this->input->post('idVendedor'),
                'idGerente' => $this->input->post('idGerente'),
                'idstatusOrcamento' => $this->input->post('idstatusOrcamento'),
                'referencia' => $this->input->post('referencia'),
                'cond_pgto' => $this->input->post('cond_pgto'),
                'garantia_servico' => $this->input->post('garantia_servico'),
                'validade' => $this->input->post('validade'),
                'idGrupoServico' => $this->input->post('idGrupoServico'),
                'idNatOperacao' => $this->input->post('idNatOperacao'),
                'num_pedido' => $this->input->post('num_pedido'),
                'num_nf' => $this->input->post('num_nf'),
                'entrega' => $this->input->post('entrega'),
                'entregaoutros' => $this->input->post('entregaoutros'),
                'obs' => $this->input->post('obs'),
                'idOrcamentos' => $this->input->post('idOrcamentos')
               
            );
			
			if ($this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $this->input->post('idOrcamentos')) == TRUE) 
			{
				
				//exclui todos itens do orçamento q nao tem os
				//$orc_item = $this->orcamentos_model->getitemorc($this->input->post('idOrcamentos'));
				
				
				//inserindo itens_de_orcamento
				$contador=count($this->input->post('item'));
				
				

				$total=0;


				for($x=0;$x<$contador;$x++)
				{
					
					$valorunita = str_replace(".","",$this->input->post('val_unit')[$x]);
					$valorunita1 = str_replace(",",".",$valorunita);
					
					$subtotal_ = str_replace(".","",$this->input->post('subtot')[$x]);
					$subtotal_ = str_replace(",",".",$subtotal_);
					
					$vlr_total_ = str_replace(".","",$this->input->post('vlr_total')[$x]);
					$vlr_total_ = str_replace(",",".",$vlr_total_);
					
					
					
					if($this->input->post('desconto')[$x] == '' )
					{
					
						$desconto_ = 0.00;
					}
					else
					{
						$desconto_ = str_replace(".","",$this->input->post('desconto')[$x]);
						$desconto_ = str_replace(",",".",$desconto_);
					
						
					}
					
					if($this->input->post('val_ipi')[$x] == '' )
					{
					$val_ipi_ = 0.00;
					
					}
					else
					{
						$val_ipi_ = str_replace(".","",$this->input->post('val_ipi')[$x]);
					$val_ipi_ = str_replace(",",".",$val_ipi_);
					
						
					}
					
					
					 $data2 = array(
                'descricao_item' => $this->input->post('descricao_item')[$x],
                'idProdutos' => $this->input->post('idProdutos')[$x],
                'desconto' => $desconto_,
                'val_ipi' => $val_ipi_,
                'qtd' => $this->input->post('qtd')[$x],
                'val_unit' => $valorunita1,
                'prazo' => $this->input->post('prazo')[$x],
                'subtot' => $subtotal_,
                'detalhe' => $this->input->post('detalhe')[$x],
                'valor_total' => $vlr_total_,
                'idOrcamentos' =>  $this->input->post('idOrcamentos')            
                            
            );
			
				
				if($this->input->post('id_orc_item')[$x] <> 0)
				{
			
					$this->orcamentos_model->edit('orcamento_item', $data2, 'idOrcamento_item', $this->input->post('id_orc_item')[$x])	;	
					
					
				}
				else
				{
					$this->orcamentos_model->add('orcamento_item', $data2, true);
				}
					
					
				}
				
				
				
                $this->session->set_flashdata('success','Orcamento editado com sucesso!');
                redirect(base_url() . 'index.php/orcamentos/editar/'.$this->input->post('idOrcamentos'));
				
			}
			 else 
			{
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
			
			
		}


		
		

		

         
        $this->data['view'] = 'orcamentos/editarOrcamento';
		$this->load->view('tema/topo', $this->data);

   
    }

function excluir_item(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dOrcamento')){
           $this->session->set_flashdata('error','Você não tem permissão para excluir item do orcamento.');
           redirect(base_url());
        }

        
        $id =  $this->input->post('id');
        $orc_item =  $this->input->post('orc_item');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir item.'); 
			redirect(base_url() .'index.php/orcamentos');	
            
        }
		

       if( $this->orcamentos_model->getitemos($id) == false)
		{
			$this->orcamentos_model->delete('orcamento_item','idOrcamento_item',$id); 
			
			$linha_orcitem = $this->orcamentos_model->get_number_linhas('orcamento_item', 'idOrcamentos = '.$this->input->post('orc_item'),'*');

$linha_orcirep = $this->orcamentos_model->get_number_linhas('orcamento', 'idOrcamentos = '.$this->input->post('orc_item').' and status_orc = 1','*');
				
	$linha_os = $this->orcamentos_model->get_number_linhas('os','idOrcamentos = '.$this->input->post('orc_item'),'DISTINCT(`idOrcamento_item`)');			

/*'status_orc' => 1,
                'idstatusOrcamento' => 12
*/
				
if(count($linha_os) == count($linha_orcitem) )
{
	$data = array(
                 
				 'idstatusOrcamento' => 4
            );
}
elseif(count($linha_os) == 0 && count($linha_orcirep) > 0)
{
	$data = array(
                 
				 'idstatusOrcamento' => 12
            );
}

elseif(count($linha_os) == 0 && count($linha_orcirep) == 0)
{
	$data = array(
                 
				 'idstatusOrcamento' => 11
            );
	
}
else
{
	$data = array(
                 
				 'idstatusOrcamento' => 13
            );
}
										
		$this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $this->input->post('orc_item'));		 
			
			
			 $this->session->set_flashdata('success','Item excluido com sucesso!');            
        redirect(base_url() .'index.php/orcamentos/editar/'.$orc_item);
		}
		else
		{
			 $this->session->set_flashdata('error','Item possui OS aberto.');
			 redirect(base_url() .'index.php/orcamentos/editar/'.$orc_item);
		}
        
                  
        
        

       
    }
    public function visualizar(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vOrcamento')){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar Orcamentos.');
          redirect(base_url());
        }
		
		
		 

        $this->data['custom_error'] = '';
      
	  
	   $this->data['result'] = $this->orcamentos_model->getById('orcamento',$this->uri->segment(3));
        
		$this->data['dados_emitente'] = $this->orcamentos_model->getEmitente($this->data['result']->idEmitente);
		$this->data['dados_clientes'] = $this->orcamentos_model->getCliente($this->data['result']->idClientes);
		$this->data['dados_solicitante'] = $this->orcamentos_model->getSolici($this->data['result']->idSolicitante);
		$this->data['dados_vendedor']= $this->orcamentos_model->getVendedor($this->data['result']->idVendedor);
        $this->data['dados_gerente'] = $this->orcamentos_model->getGerente($this->data['result']->idGerente);
        $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($this->data['result']->	idNatOperacao);
        
		$this->data['itens_orcamento'] = $this->orcamentos_model->getorc_item($this->data['result']->idOrcamentos);
		
		
		
        $this->data['view'] = 'orcamentos/visualizar';
        $this->load->view('tema/topo', $this->data);
       
    }
	 public function aprovar(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'APOrcamento')){
          $this->session->set_flashdata('error','Você não tem permissão para aprovar Orcamentos.');
          redirect(base_url());
        }
	    $this->load->model('os_model');

        $this->data['custom_error'] = '';
      
	  
	   $this->data['result'] = $this->orcamentos_model->getById('orcamento',$this->uri->segment(3));
        
		$this->data['dados_emitente'] = $this->orcamentos_model->getEmitente($this->data['result']->idEmitente);
		$this->data['dados_clientes'] = $this->orcamentos_model->getCliente($this->data['result']->idClientes);
		$this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($this->data['result']->	idNatOperacao);
         $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
		$this->data['itens_orcamento'] = $this->orcamentos_model->getorc_item($this->data['result']->idOrcamentos);
		
		 $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
        $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
		 $this->data['status_os']= $this->orcamentos_model->getStatusOs();
		
		//inserindo os
		
				
	
		
        $this->data['view'] = 'orcamentos/aprovar';
        $this->load->view('tema/topo', $this->data);
       
    }
	 public function aprovar_os(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'APOrcamento')){
          $this->session->set_flashdata('error','Você não tem permissão para aprovar Orcamentos.');
          redirect(base_url());
        }
		
		 //$this->data['result'] = $this->orcamentos_model->getById('orcamento',$this->input->post('idOrcamentos'));
		
        $this->load->library('form_validation');
            $this->data['custom_error'] = '';
            
            $contador=count($this->input->post('item'));
            
            $this->load->model('clientes_model');   
            $this->load->model('os_model');            
        if($this->input->post('item')[0] > 0)
        {
		
				for($x=0;$x<$contador;$x++)
				{
                    $possuiOs = $this->orcamentos_model->get2("os"," * ", "idOrcamento_item = ".$this->input->post('item')[$x],5);

                    if(!empty($possuiOs)){
                        redirect('os?idOrcamentos='.$this->input->post('idOrcamentos'));
                        return;
                    }
					
                    $valor_item = $this->orcamentos_model->getitem($this->input->post('item')[$x]);
                            
                    $data_entrega = date('Y-m-d', strtotime('+'.$valor_item->prazo.' days', strtotime(date('Y-m-d'))));

                    $os = $this->orcamentos_model->get('orcamento','idOrcamentos','orcamento.idOrcamentos = '.$this->input->post('idOrcamentos'),1, 0, true);
                    if(empty($os->idSimplexCliente)){                        
                        $resposta2 = json_decode($this->simplexCadastroCliente($os->nomeCliente,$os->cep,$os->documento));
                        $data2 = array("idSimplexCliente"=>$resposta2->response->id);
                        $os->idSimplexCliente = $resposta2->response->id;
                        $this->clientes_model->edit('clientes', $data2, 'idClientes', $os->idClientes);
                        echo("<script>console.log('foi?');</script>");
                        echo $os;
                    }

                    

					/*$desconto_ = str_replace(".","",$valor_item->desconto);
					$desconto_ = str_replace(",",".",$desconto_);
					
					$val_ipi_ = str_replace(".","",$valor_item->val_ipi);
					$val_ipi_ = str_replace(",",".",$val_ipi_);
					
					$valorunita = str_replace(".","",$valor_item->val_unit);
					$valorunita = str_replace(",",".",$valorunita);
					
					$subtotal_ = str_replace(".","",$valor_item->subtot);
					$subtotal_ = str_replace(",",".",$subtotal_);*/
					
                    $dataAbertura = date('Y-m-d H:i:s');
                    
			
					 $data2 = array(
                        'idOrcamento_item' => $this->input->post('item')[$x],
                        'val_unit_os' => $valor_item->val_unit,
                        'desconto_os' => $valor_item->desconto,
                        'qtd_os' => $valor_item->qtd,
                        'subtot_os' => $valor_item->subtot,
                        'val_ipi_os' => $valor_item->val_ipi,
                        'data_entrega' => $data_entrega,
                        'idStatusOs' => $this->input->post('idStatusOs'),
                        'data_abertura' => date('Y-m-d H:i:s'),
                        'data_abertura_real' => date('Y-m-d H:i:s'),
                    
                        'unid_execucao' => $this->input->post('unid_execucao'),
                        'unid_faturamento' => $this->input->post('unid_faturamento'),
                        'id_tipo' => $this->input->post('id_tipo'),
                        'contrato' => $this->input->post('contrato'),          
                        'idOrcamentos' => $this->input->post('idOrcamentos'),          
                        'numpedido_os' => $this->input->post('num_pedido')          
                    );
			
					
					$itemOrc = $this->orcamentos_model->getitem($this->input->post('item')[$x]);
                    $nova_os = 	$this->orcamentos_model->add('os', $data2, true);
                    $objOs = $this->os_model->getByid_table($nova_os, 'os', 'idOs');
                    $this->os_model->insertOSHis($objOs);
                    if(($this->input->post('unid_execucao') == '2' || $this->input->post('unid_execucao') == '4'  || $this->input->post('unid_execucao') == '1') && $this->input->post('idStatusOs') == 5){
                        $response = json_decode($this->simplexCriarOS($os->idSimplexCliente,$os->documento,$dataAbertura,$data_entrega,$nova_os));
                        if($response->status == "success"){
                            echo("<script>console.log('sucesso');</script>");
                            $data2 = array("idSimplexOs"=>$response->response->id);
                            $this->orcamentos_model->edit('os', $data2, 'idOs', $nova_os);
                            //$produto = $this->produtos_model->getById();
                            $response2 = json_decode($this->simplexCriarItemOs($response->response->id,$valor_item->qtd,$itemOrc->descricao_item,$valor_item->val_unit));
                            if($response2->status == "success"){
                                $data2 = array("idSimplexItemOs"=>$response2->response->id);
                                $this->orcamentos_model->edit('os', $data2, 'idOs', $nova_os);
                            }
                            //$response3 = json_decode($this->simplexCriarAtividade($response->id,$itemOrc->descricao_item,$nova_os,'1650891880589x672038920761376800',$dataAbertura,$data_entrega));
                            if($this->input->post('unid_execucao') == '2'){
                                $response3 = json_decode($this->simplexCriarAtividade($response->response->id,$itemOrc->descricao_item,$nova_os,'1652280851846x229444076177981440',$dataAbertura,$data_entrega,"#0000FF"));
                                if($response3->status == "success"){
                                    $data2 = array("idSimplexAtividade"=>$response3->response->id);
                                    $this->orcamentos_model->edit('os', $data2, 'idOs', $nova_os);
                                }
                            }
                            if($this->input->post('unid_execucao') == '4'){
                                $response3 = json_decode($this->simplexCriarAtividade($response->response->id,$itemOrc->descricao_item,$nova_os,'1669720623542x538115201003946000',$dataAbertura,$data_entrega,"#5c3317"));
                                if($response3->status == "success"){
                                    $data2 = array("idSimplexAtividade"=>$response3->response->id);
                                    $this->orcamentos_model->edit('os', $data2, 'idOs', $nova_os);
                                }
                            }

                            if($this->input->post('unid_execucao') == '1'){
                                $response3 = json_decode($this->simplexCriarAtividade($response->response->id,$itemOrc->descricao_item,$nova_os,'1676546559152x342005079569072100',$dataAbertura,$data_entrega,"#ff60d7"));
                                if($response3->status == "success"){
                                    $data2 = array("idSimplexAtividade"=>$response3->response->id);
                                    $this->orcamentos_model->edit('os', $data2, 'idOs', $nova_os);
                                }
                            }
                            
                        }else{
                            echo("<script>console.log('falha');</script>");
                        }
                    }else if($this->input->post('unid_execucao') == '2' || $this->input->post('unid_execucao') == '4' || $this->input->post('unid_execucao') == '1'){
                        $response = json_decode($this->simplexCriarOS($os->idSimplexCliente,$os->documento,$dataAbertura,$data_entrega,$nova_os));
                        if($response->status == "success"){
                            echo("<script>console.log('sucesso');</script>");
                            $data2 = array("idSimplexOs"=>$response->response->id);
                            $this->orcamentos_model->edit('os', $data2, 'idOs', $nova_os);
                            //$produto = $this->produtos_model->getById();
                            $response2 = json_decode($this->simplexCriarItemOs($response->response->id,$valor_item->qtd,$itemOrc->descricao_item,$valor_item->val_unit));
                            if($response2->status == "success"){
                                $data2 = array("idSimplexItemOs"=>$response2->response->id);
                                $this->orcamentos_model->edit('os', $data2, 'idOs', $nova_os);
                            }
                            if($this->input->post('unid_execucao') == '2'){
                                $response3 = json_decode($this->simplexCriarAtividade($response->response->id,$itemOrc->descricao_item,$nova_os,'1650891880589x672038920761376800',$dataAbertura,$data_entrega,"#0000FF"));
                                if($response3->status == "success"){
                                    $data2 = array("idSimplexAtividade"=>$response3->response->id);
                                    $this->orcamentos_model->edit('os', $data2, 'idOs', $nova_os);
                                }
                            }
                            if($this->input->post('unid_execucao') == '4'){
                                $response3 = json_decode($this->simplexCriarAtividade($response->response->id,$itemOrc->descricao_item,$nova_os,'1669720623542x538115201003946000',$dataAbertura,$data_entrega,"#5c3317"));
                                if($response3->status == "success"){
                                    $data2 = array("idSimplexAtividade"=>$response3->response->id);
                                    $this->orcamentos_model->edit('os', $data2, 'idOs', $nova_os);
                                }
                            }
                            if($this->input->post('unid_execucao') == '1'){
                                $response3 = json_decode($this->simplexCriarAtividade($response->response->id,$itemOrc->descricao_item,$nova_os,'1676546559152x342005079569072100',$dataAbertura,$data_entrega,"#ff60d7"));
                                if($response3->status == "success"){
                                    $data2 = array("idSimplexAtividade"=>$response3->response->id);
                                    $this->orcamentos_model->edit('os', $data2, 'idOs', $nova_os);
                                }
                            }
                            
                        }else{
                            echo("<script>console.log('falha');</script>");
                        }
                    }
                    
					
				}
            $linha_orcitem = $this->orcamentos_model->get_number_linhas('orcamento_item', 'idOrcamentos = '.$this->input->post('idOrcamentos'),'*');

            $linha_orcirep = $this->orcamentos_model->get_number_linhas('orcamento', 'idOrcamentos = '.$this->input->post('idOrcamentos').' and status_orc = 1','*');
                            
                $linha_os = $this->orcamentos_model->get_number_linhas('os','idOrcamentos = '.$this->input->post('idOrcamentos'),'DISTINCT(`idOrcamento_item`)');			

            /*'status_orc' => 1,
                            'idstatusOrcamento' => 12
            */
                            
            if(count($linha_os) == count($linha_orcitem) )
            {
                $data = array(
                            
                            'idstatusOrcamento' => 4
                        );
            }
            elseif(count($linha_os) == 0 && count($linha_orcirep) > 0)
            {
                $data = array(
                            
                            'idstatusOrcamento' => 12
                        );
            }

            elseif(count($linha_os) == 0 && count($linha_orcirep) == 0)
            {
                $data = array(
                            
                            'idstatusOrcamento' => 11
                        );
                
            }
            else
            {
                $data = array(
                            
                            'idstatusOrcamento' => 13
                        );
            }
                                                    
                    $this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $this->input->post('idOrcamentos'));		 
                            
                        $this->session->set_flashdata('success','OS cadastrada com sucesso.');
                        redirect('os?idOrcamentos='.$this->input->post('idOrcamentos'));
            }
            else
            {
                $this->session->set_flashdata('error','Marque um item!');
                            redirect(base_url() . 'index.php/orcamentos/aprovar/'.$this->input->post('idOrcamentos'));
                            
                
            }	
                    
		
		
	}
	public function orcCustom(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vOrcamento')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar orçamento.');
           redirect(base_url());
        }
        
        $dataInicial = $this->input->get('dataInicial');
		if($dataInicial == ''){
			$dataimpri = date("d/m/Y");
		}
		else{
			$dataimpri =  $dataInicial;
		}
		
        $idOrcamentos = $this->input->get('idOrcamentos');
        
        $data['result'] = $this->orcamentos_model->orcCustom($dataimpri,$idOrcamentos);
      
        
		/* $data['dados_emitente'] = $this->orcamentos_model->getEmitente($data['result']->idEmitente);
		$data['dados_clientes'] = $this->orcamentos_model->getCliente($data['result']->idClientes);
		$data['dados_vendedor'] = $this->orcamentos_model->getVendedor($data['result']->idVendedor);
        $data['dados_gerente'] = $this->orcamentos_model->getGerente($data['result']->idGerente);
        $data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao($data['result']->idNatOperacao);
        */
		//$data['itens_orcamento'] = $this->orcamentos_model->getorc_item($data['result']->idOrcamentos);
		
         
        $this->load->helper('mpdf');
           echo $html = $this->load->view('orcamentos/imprimir/imprimirOrc',$data,true);
	  
	 //pdf_create($html, 'Orcamento_'.$idOrcamentos, TRUE);
        //pdf_create($html, 'Orcamento_'.$idOrcamentos, TRUE);
		
		
		/*$pagina = $this->load->view('orcamentos/imprimir/imprimirOrc',$data,true);
	    $this->load->helper('mpdf');
		
	    $arquivo = 'Orcamento_'.$idOrcamentos;

		$mpdf = new mPDF();
		$mpdf->WriteHTML($pagina);

		$mpdf->Output($arquivo, 'I');*/
	
    }
	function autoCompleteSolicitante()
	{
		//echo $id = $this->uri->segment(3);
		 $id = $_REQUEST['id'];
		
		// $id  = $this->input->post('id');
		//$were = 'clientes.idClientes = '.$this->uri->segment(3);
		$were = 'clientes.idClientes = '.$id;
		  $c =  $this->orcamentos_model->getsolicitante('clientes',$were);
       
		      
        echo json_encode($c);
		
		
	}
	function calculartotais()
	{
		// $id = $this->uri->segment(3);
		 //$id = $_REQUEST['id'];
		$valorunit = $this->input->post('valorunit');
		$desconto = $this->input->post('desconto');
		$valoripi = $this->input->post('valoripi');
		$quant = $this->input->post('quant');
		
		
		
		$total1 = $valorunit * $quant;
		$total2 = $total1 * $valoripi/100;
		$total3 = ($total1 + $total2) - $desconto;
		
		echo json_encode(array("subtot" => $total1, "vlr_total" => $total3, "total1" => $total1, "total2" => $total2, "desconto" => $desconto));	 
		/*echo json_encode(array("subtot" => number_format($total1, 2, ',', '.'), "vlr_total" => number_format($total3, 2, ',', '.'), "total1" => number_format($total1, 2, ',', '.'), "total2" => number_format($total2, 2, ',', '.'), "desconto" => number_format($desconto, 2, ',', '.')));
		
		*/
		
	}
	 function excluir_os(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dOs')){
          $this->session->set_flashdata('error','Você não tem permissão para excluir OS');
          redirect(base_url());
        }
		
		
			
			 $data = array(
                'status_orc' => 0
            );
			$id_os = $this->input->post('id_os');
			$idOrc = $this->input->post('idOrc');
		
        if ($idOrc == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir OS.');            
            redirect(base_url().'index.php/orcamentos/gerenciar');
        }
		
        if ($id_os == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir OS.');            
            redirect(base_url().'index.php/orcamentos/aprovar/'.$idOrc);
        }
		
	
		//de excluir verificar se esta em produçao , se ja comprou item
		 $vari = $this->orcamentos_model->get_number_linhas('distribuir_os','idOs = '.$id_os,'');
		
		if(count($vari) == 0)
		{
        if ($this->orcamentos_model->delete('os','idOs',$id_os) == TRUE) {
			
			
			
			//update no orçamento
				$linha_orcitem = $this->orcamentos_model->get_number_linhas('orcamento_item', 'idOrcamentos = '.$this->input->post('idOrc'),'*');

$linha_orcirep = $this->orcamentos_model->get_number_linhas('orcamento', 'idOrcamentos = '.$this->input->post('idOrc').' and status_orc = 1','*');
				
	$linha_os = $this->orcamentos_model->get_number_linhas('os','idOrcamentos = '.$this->input->post('idOrc'),'DISTINCT(`idOrcamento_item`)');			

/*'status_orc' => 1,
                'idstatusOrcamento' => 12
*/

if(count($linha_os) == count($linha_orcitem) )
{
	$data = array(
                 
				 'idstatusOrcamento' => 4
            );
}
elseif(count($linha_os) == 0 && count($linha_orcirep) > 0)
{
	$data = array(
                 
				 'idstatusOrcamento' => 12
            );
}

elseif(count($linha_os) == 0 && count($linha_orcirep) == 0)
{
	$data = array(
                 
				 'idstatusOrcamento' => 11
            );
	
}
else
{
	$data = array(
                 
				 'idstatusOrcamento' => 13
            );
}
										
		$this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $this->input->post('idOrc'));		 
			
		
                $this->session->set_flashdata('success','OS excluida com sucesso!');
                redirect(base_url().'index.php/orcamentos/aprovar/'.$idOrc);
            } else {
				$this->session->set_flashdata('error','Ocorreu um erro ao deletar!');
                redirect(base_url().'index.php/orcamentos/aprovar/'.$idOrc);
				
                }
	 }
	 else
	 {
		 $this->session->set_flashdata('error','Essa OS tem item de compra inserida nela, nao pode apagar.!');
                redirect(base_url().'index.php/orcamentos/aprovar/'.$idOrc);
				
		  
	 }

        
               

    }

	
    function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dOrcamento')){
          $this->session->set_flashdata('error','Você não tem permissão para excluir Orcamentos');
          redirect(base_url());
        }
		
		if($this->input->post('idorc') <> '')
		{
			$idorc = $this->input->post('idorc');
			$texto = 'desativado';
		//verifica se tem algum item aprovado
		if( $this->orcamentos_model->getorc_os($idorc) == true)
            {
                $this->session->set_flashdata('error','Orçamento ja possui item aprovado.');
               redirect(base_url().'index.php/orcamentos/gerenciar/');
            }
			
			
		if ($this->input->post('idMotivo') == null){

            $this->session->set_flashdata('error','Escolha um motivo.');            
            redirect(base_url().'index.php/orcamentos/gerenciar/');
        }
		 $data = array(
                
                'idMotivo' => $this->input->post('idMotivo'),
                'status_orc' => 1,
                'idstatusOrcamento' => 12
            );
		}
		else
		{
			$texto = 'reativado';
			 $data = array(
                
                
                'status_orc' => 0,
				 'idstatusOrcamento' => 11
            );
			$idorc = $this->input->post('idorc2');
		}
       
        if ($idorc == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir Orcamento.');            
            redirect(base_url().'index.php/orcamentos/gerenciar/');
        }
		
	

        if ($this->orcamentos_model->edit('orcamento', $data, 'idOrcamentos', $idorc) == TRUE) {
                $this->session->set_flashdata('success','Orcamento '. $texto.' com sucesso!');
                redirect(base_url().'index.php/orcamentos/gerenciar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
			

        
               

    }

    public function autoCompleteProduto(){
        
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompleteProduto($q);
        }

    }

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompleteCliente($q);
        }

    }
	public function autoCompletePN(){

        if (isset($_GET['term'])){
			//converte tudo pra maiusculo
            $q = strtoupper($_GET['term']);
			//retira -/.|;,
			$pn = str_replace("-","",$q);
			$pn = str_replace("/","",$pn);
			$pn = str_replace(",","",$pn);
			$pn = str_replace("|","",$pn);
			$pn = str_replace(";","",$pn);
			$pn = str_replace(" ","",$pn);
            $this->orcamentos_model->autoCompletePN($pn);
        }

    }
	public function autoCompletePN_2(){

        if (isset($_GET['term'])){
			//converte tudo pra maiusculo
            $q = strtoupper($_GET['term']);
			//retira -/.|;,
			$pn = str_replace("-","",$q);
			$pn = str_replace("/","",$pn);
			$pn = str_replace(",","",$pn);
			$pn = str_replace("|","",$pn);
			$pn = str_replace(";","",$pn);
			$pn = str_replace(" ","",$pn);
            $this->orcamentos_model->autoCompletePN2($pn);
        }

    }
	public function autoCompletePN2(){

        if (isset($_GET['pn2'])){
			//converte tudo pra maiusculo
            $q = strtoupper($_GET['pn2']);
			//retira -/.|;,
			$pn = str_replace("-","",$q);
			$pn = str_replace("/","",$pn);
			$pn = str_replace(",","",$pn);
			$pn = str_replace("|","",$pn);
			$pn = str_replace(";","",$pn);
			$pn = str_replace(" ","",$pn);
            $this->orcamentos_model->autoCompletePN($pn);
        }

    }

    public function autoCompleteUsuario(){
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompleteUsuario($q);
        }

    }



    public function adicionarProduto(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOrcamento')){
          $this->session->set_flashdata('error','Você não tem permissão para editar orcamentos.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idProduto', 'Produto', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idOrcamentosProduto', 'Orcamentos', 'trim|required|xss_clean');
        
        if($this->form_validation->run() == false){
           echo json_encode(array('result'=> false)); 
        }
        else{

            $preco = $this->input->post('preco');
            $quantidade = $this->input->post('quantidade');
            $subtotal = $preco * $quantidade;
            $produto = $this->input->post('idProduto');
            $data = array(
                'quantidade'=> $quantidade,
                'subTotal'=> $subtotal,
                'produtos_id'=> $produto,
                'orcamentos_id'=> $this->input->post('idOrcamentosProduto'),
            );

            if($this->orcamentos_model->add('itens_de_orcamentos', $data) == true){
                $sql = "UPDATE produtos set estoque = estoque - ? WHERE idProdutos = ?";
                $this->db->query($sql, array($quantidade, $produto));
                
                echo json_encode(array('result'=> true));
            }else{
                echo json_encode(array('result'=> false));
            }

        }
        
      
    }

    function excluirProduto(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOrcamento')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Orcamentos');
              redirect(base_url());
            }

            $ID = $this->input->post('idProduto');
            if($this->orcamentos_model->delete('itens_de_orcamento','idItens',$ID) == true){
                
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



    public function faturar() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eOrcamento')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Orcamentos');
              redirect(base_url());
            }

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
                'idClientes' => $this->input->post('clientes_id'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $recebimento,
                'baixado' => $this->input->post('recebido'),
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo')
            );

            if ($this->orcamentos_model->add('lancamentos',$data) == TRUE) {
                
                $venda = $this->input->post('orcamentos_id');

                $this->db->set('faturado',1);
                $this->db->set('valorTotal',$this->input->post('valor'));
                $this->db->where('idOrcamentos', $venda);
                $this->db->update('orcamentos');

                $this->session->set_flashdata('success','Orcamento faturada com sucesso!');
                $json = array('result'=>  true);
                echo json_encode($json);
                die();
            } else {
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar orcamento.');
                $json = array('result'=>  false);
                echo json_encode($json);
                die();
            }
        }

        $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar orcamentos_id.');
        $json = array('result'=>  false);
        echo json_encode($json);
        
    }

    //API simplex

    public function simplexCriarOS($idSimplexCliente,$documento,$dataAbertura,$previsaoEntrega,$nova_os){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->config->item('urlSimplex').'/post_ordem_execucao',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "local_producao": "1643030732052x547164845382303740",
            "empresa": "1643030479504x771112863746752500",
            "deletado": "no",
            "cnpj_emp": "'.$documento.'",
            "cnpj_fornecedor": "'.$idSimplexCliente.'",
            "cond_pagamento": "À vista",
            "contato": "",
            "data_emissao": "'.$dataAbertura.'",
            "email_fornecedor": "",
            "endereco_entrega": "",
            "fornecedor": "'.$idSimplexCliente.'",
            "solicitante": "",
            "oe_numero": "'.$nova_os.'",
            "previsao_entrega": "'.$previsaoEntrega.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->config->item('tokenSimplex')
        ),
        ));

        $response = curl_exec($curl);
        echo("<script>console.log('".$response."');</script>");
        $err_status = curl_error($curl);
        echo("<script>console.log('".$err_status."');</script>");

        curl_close($curl);
        return $response;
    }
    public function simplexCriarItemOs($idSimplexOs,$quantidade,$descricaoItem,$valor,$pn = ''){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->config->item('urlSimplex').'/post_item_pc_oc_oe',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'
            {
                "local_producao": "1643030732052x547164845382303740",
                "empresa": "1643030479504x771112863746752500",
                "de_qual_oe": "'.$idSimplexOs.'",
                "descricao_item": "'.$descricaoItem.'",
                "item": "'.$pn.'",
                "nbr": "",
                "frete": "1",
                "grupo_orcamentario": "",
                "grupo_produto": "",
                "unidade_medida":"",
                "impostos": "1",
                "oc": "no",
                "oe": "yes",
                "quantidade": "'.$quantidade.'",
                "valor":"'.$valor.'"
              }
        ',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->config->item('tokenSimplex')
        ),
        ));

        $response = curl_exec($curl);
        echo("<script>console.log('".$response."');</script>");
        $err_status = curl_error($curl);
        echo("<script>console.log('".$err_status."');</script>");

        curl_close($curl);
        return $response;
    }
    public function simplexCriarAtividade($idSimplexOs,$descricao,$idOs,$lista,$inicio,$entrega,$cor){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->config->item('urlSimplex').'/post_kanban_atividades',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "de_qual_lista": "'.$lista.'",            
            "deletado":"no",
            "descricao_atividade": "'.$descricao.'",
            "local_producao": "1643030732052x547164845382303740",
            "empresa": "1643030479504x771112863746752500",
            "cor": "'.$cor.'",
            "horas_estimadas": "0",
            "prazo_previsto": "0",
            "prazo_realizado": "0",
            "produto_final": "",   
            "servico_controlado": "",   
            "termino_realizado": "0",   
            "inicio_previsto": "0",
            "inicio_realizado": "0",            
            "list_user": [],
            "titulo_atividade_oe": "'.$idSimplexOs.'",
            "inicio_previsto": "'.$inicio.'",
            "termino_previsto": "'.$entrega.'",
            "titulo_atividade": "'.$descricao.'",
            "titulo_atividade_oe_filter": "'.$idOs.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->config->item('tokenSimplex')
        ),
        ));

        $response = curl_exec($curl);
        echo("<script>console.log('".$response."');</script>");
        $err_status = curl_error($curl);
        echo("<script>console.log('".$err_status."');</script>");

        curl_close($curl);
        return $response;
    }
   
    function simplexCadastroCliente($nomeCliente,$cep,$documento){
        
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
            "cnpj_cpf": "'.$documento.'",
            "contato": "",
            "email": "",
            "endereco": "'.$cep.'",
            "fornecedor_cliente": "'.$nomeCliente.'",
            "inscricao_estadual": ""}'
            );
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$this->config->item('tokenSimplex')
        ));
        $response = curl_exec($curl);
        echo("<script>console.log('".$response."');</script>");
        $err_status = curl_error($curl);
        echo("<script>console.log('".$err_status."');</script>");

        curl_close($curl);
        //echo $response;
        return $response;
        
    }
    function copiarorcamento(){
        if(empty($this->input->post('copiarOrc'))){
            $this->session->set_flashdata('error', 'Nenhum item foi selecionado.');
            redirect(base_url() . 'index.php/orcamentos/editar/' . $this->input->post('idOrcCopiar'));
        }
        $orc = $this->orcamentos_model->get2("orcamento"," * ","idOrcamentos = ".$this->input->post('idOrcCopiar'),1,null,true);
        $copiaOrc2 = clone $orc;
        $copiaOrc2->data_abertura = date('Y-m-d H:i:s');
        $copiaOrc2->status_orc = 0;
        $copiaOrc2->idOrcamentos = null;
        $copiaOrc2->idstatusOrcamento = 11;
        $idCopiaOrc = $this->orcamentos_model->add("orcamento",$copiaOrc2,true);
        foreach($this->input->post('copiarOrc') as $r){
            $orcItem = $this->orcamentos_model->get2("orcamento_item"," * ","idOrcamento_item = ".$r,1,null,true);
            $copiaOrcItem = clone $orcItem;
            $copiaOrcItem->idOrcamento_item = null;
            $copiaOrcItem->idOrcamentos = $idCopiaOrc;
            $copiaOrcItem->status_item = 0;
            $this->orcamentos_model->add("orcamento_item",$copiaOrcItem,true);
        }
        $this->session->set_flashdata('success', 'Orçamento criado com sucesso!');
        redirect(base_url() . 'index.php/orcamentos/editar/' . $idCopiaOrc);
    }


}

