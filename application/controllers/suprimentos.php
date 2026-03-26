<?php

class Suprimentos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
                if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
                    redirect('mapos/login');
                }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('pedidocompra_model','',TRUE);
        $this->load->model('cotacao_model','',TRUE);
		
		
		
		if(($this->uri->segment(2)) == 'almoxarifado' || $this->session->userdata('permissao') == 6){
			//$this->uri->segment(2) == 'almoxarifado'
			$this->data['menuPedidocompraalmox'] = 'Almoxarifado Pedido de Compra';
		}
		else if(($this->uri->segment(2)) == 'almoxarifado_compras' || ($this->uri->segment(2)) == 'almoxarifadocompras')/**/
		{   
			$this->data['menuAlmoxarifado'] = 'Almoxarifado';/*
		}else if($this->uri->segment(2) == 'autorizacao'){
            $this->data['menuDiretoria'] = 'Diretoria';
        }else if($this->uri->segment(2) == 'aprovacao'){
            $this->data['menuFinanceiro'] = 'Financeiro';*/
        }else{
            
            $this->data['menuPedidoCompra'] = 'Pedido de Compra';
            
        }
		

		
	}
	function index(){
		$this->gerenciar();
	}
	
// --- COLE ESTE BLOCO DE CÓDIGO DENTRO DA CLASSE Suprimentos ---

    function anexarCotacao(){
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }
        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads/cotacaosup'; // Diretório para salvar as cotações

        if (!file_exists($image_upload_folder)) {
            // Tenta criar o diretório com permissões de escrita
            if (!mkdir($image_upload_folder, 0777, true)) {
                 $this->session->set_flashdata('error','Falha ao criar o diretório de uploads.');
                 $idPedidoCompraRedirect = $this->uri->segment(3);
                 if($idPedidoCompraRedirect && is_numeric($idPedidoCompraRedirect)){
                    redirect('suprimentos/editarpedido/'.$idPedidoCompraRedirect);
                 } else {
                    redirect('suprimentos');
                 }
                 return;
            }
        }

        // Pega o ID da Ordem de Compra da URL (segmento 3)
        $idPedidoCompra = $this->uri->segment(3);
        if(!$idPedidoCompra || !is_numeric($idPedidoCompra)){
           $this->session->set_flashdata('error','ID do Pedido de Compra inválido na URL.');
            redirect('suprimentos'); // Redireciona para a listagem geral
            return;
        }

        // Configuração do Upload
        $this->upload_config = array(
            'upload_path'   => $image_upload_folder,
            // (CORRIGIDO: 'allowed_types' => '*' é um risco de segurança)
            'allowed_types' => 'pdf|png|jpg|jpeg|doc|docx|xls|xlsx|dwg|bmp|txt', 
            // 'max_size'    => 2048, // Define um tamanho máximo em KB, se necessário
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE, // Renomeia o arquivo para evitar conflitos
        );

        // Define o nome esperado para o input de arquivo
        $file_input_name = 'imag_' . $idPedidoCompra;

        // Verifica se o input de arquivo esperado existe e se tem arquivos
         if (!isset($_FILES[$file_input_name]) || empty($_FILES[$file_input_name]['name'][0])) {
             $this->session->set_flashdata('error', 'Nenhum arquivo selecionado ou erro no nome do campo de upload (esperado: '.$file_input_name.'[]).');
             redirect('suprimentos/editarpedido/'.$idPedidoCompra);
             return;
         }

        $files = $_FILES[$file_input_name];
        $success_count = 0;
        $error_messages = [];

        // Processa cada arquivo enviado
        foreach ($files['name'] as $key => $image) {
            
            if ($files['error'][$key] == UPLOAD_ERR_NO_FILE) {
                continue; // Pula campos vazios
            }
            if ($files['error'][$key] != UPLOAD_ERR_OK) {
                $error_messages[] = "Erro no upload PHP para o arquivo '" . htmlspecialchars($files['name'][$key]) . "'. Código: " . $files['error'][$key];
                continue;
            }

            // Prepara o array $_FILES para a biblioteca do CodeIgniter
            $_FILES['upload_temp_file']['name']     = $files['name'][$key];
            $_FILES['upload_temp_file']['type']     = $files['type'][$key];
            $_FILES['upload_temp_file']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['upload_temp_file']['error']    = $files['error'][$key];
            $_FILES['upload_temp_file']['size']     = $files['size'][$key];

            $this->upload->initialize($this->upload_config);

            if ($this->upload->do_upload('upload_temp_file')) {
                $arquivo = $this->upload->data();
                $imagem_criptografada = $arquivo['file_name'];
                $caminho_relativo = 'assets/uploads/cotacaosup/'; 
                $tamanho = $arquivo['file_size'];
                $extensao = $arquivo['file_ext'];

                $data = array(
                    'nomeArquivo' => $files['name'][$key], // Nome original
                    'imagem' => $imagem_criptografada,     // Nome salvo
                    'caminho' => $caminho_relativo,
                    'tamanho' => $tamanho,
                    'extensao' => $extensao,
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'idPedidoCompra' => $idPedidoCompra 
                );

                if($this->pedidocompra_model->add('anexo_cotacao_suprimentos', $data)){
                    $success_count++;
                } else {
                     $error_messages[] = "Erro ao salvar anexo '" . htmlspecialchars($files['name'][$key]) . "' no banco de dados.";
                     unlink($arquivo['full_path']); // Deleta o arquivo se o BD falhar
                }

            } else {
                $error_messages[] = "Erro no upload (CI) para '" . htmlspecialchars($files['name'][$key]) . "': " . $this->upload->display_errors('', '');
            }
        } // Fim do loop foreach

        // Define mensagens de feedback
        if($success_count > 0){
            $this->session->set_flashdata('success', $success_count . ' anexo(s) registrado(s) com sucesso.');
        }
        if(count($error_messages) > 0){
             $this->session->set_flashdata('error', implode('<br>', $error_messages));
        }

        // Redireciona de volta para a tela de edição da OC
        redirect('suprimentos/editarpedido/'.$idPedidoCompra);
        return;
    }

    function getAnexoCotacao(){
        $item = $this->pedidocompra_model->getAnexoCotacao($this->input->post("idAnexo"));
        echo json_encode(array("result"=>true,"obj"=>$item));
    }

    function removeranexocotacao(){
        $id = $this->input->post("idAnexoRemover");
        
        // Tenta buscar o anexo para saber para qual OC redirecionar
        $anexo = $this->pedidocompra_model->getAnexoCotacao($id);
        $idPedidoCompraRedirect = null;
        if($anexo && isset($anexo->idPedidoCompra)){
            $idPedidoCompraRedirect = $anexo->idPedidoCompra;
        }

        if ($this->pedidocompra_model->delete("anexo_cotacao_suprimentos","idAnexo",$id)) {
            // (Opcional: Adicionar lógica para deletar o arquivo físico do servidor)
            // unlink(FCPATH . $anexo->caminho . $anexo->imagem);
            $this->session->set_flashdata('success','Anexo removido com sucesso.');
        } else {
            $this->session->set_flashdata('error','Erro ao remover anexo.');
        }

        // Redireciona de volta para a OC correta
        if($idPedidoCompraRedirect){
             redirect('suprimentos/editarpedido/'.$idPedidoCompraRedirect);
        } else {
            // Fallback se não encontrar a OC
             redirect('suprimentos');
        }
    }

    // --- FIM DO BLOCO PARA COLAR ---	
	
private function _assertFinanceApprover()
{
    $user = $this->session->userdata();
    $id = isset($user['id']) ? (int)$user['id'] : (int)$this->session->userdata('idUsuarios');

    // IDs autorizados: Daniel (53) e José (18)
    $autorizados = array(26,18,53);

    if (!in_array($id, $autorizados)) {
        $this->session->set_flashdata('error', 'Aprovação financeira permitida apenas aos usuários Daniel Peixoto (id 53) e José Vagner (id 18) e Karina (id 26).');
        redirect('dashboard');
        exit;
    }
}



	function gerenciar(){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Pedido de compra.');
           redirect(base_url());
        }
        $empresaNum1 = $this->input->post('empresaNum1');
        $empresaNum2 = $this->input->post('empresaNum2');
        if((!empty($empresaNum1) && empty($empresaNum2)) || (empty($empresaNum1) && !empty($empresaNum2))){
            $this->session->set_flashdata('error','Para filtrar por empresas preencha os dois campos!');
            redirect(base_url() . 'index.php/suprimentos');	
        }

        $this->load->library('table');
        $this->load->library('pagination');
        
        $this->load->model('os_model');
		$this->load->model('orcamentos_model');		 
		$this->load->model('cotacao_model');		 
        $this->load->model('usuarios_model');	
        $this->data['usuarios_dados'] = $this->usuarios_model->getusuarios('');		
        $config['base_url'] = base_url().'index.php/suprimentos/gerenciar/';
         
        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
        $this->data['dados_usuario_orc']= $this->pedidocompra_model->getUsuariosOrc();
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        
        //------------------------------------------------------

        $this->data['dadosFiltros'] = $this->input->post();
       

        //------------------------------------------------------
         
        $numPedido = $this->input->post('numPedido');        

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
            
            if($idStatuscompras == 'todos'){

                $query_statuscompra = "(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,20,21,23)";

            }else{
                $query_statuscompra = "(".$idStatuscompras.")";
            }

		    
            /*
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
            */
            //print_r($query_statuscompra); exit;
            if($idStatuscompras == 1 || $idStatuscompras == 6){
                //$autorizacaoPCP = 1;
                //$autorizacaoPCP = "";
            }else{
                //$autorizacaoPCP = "";
            }
		}else{
            $query_statuscompra = "(1)";
            //$autorizacaoPCP = 1;
            $autorizacaoPCP = "1";
        }
       /*
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
					$query_idgrupo.=$idgrupo3;
					$primeiro = false;
				}
				else
				{
					$query_idgrupo.=",".$idgrupo3;
				}
			}
			$query_idgrupo .= ")";
		}*/
		
        $query_idgrupo = "";
		$idgrupo = $this->input->post('idgrupo');
		if(!empty($idgrupo))
		{
			$query_idgrupo = "($idgrupo)";
		}

        $query_usuario_orc = "";
		$idusuarioorc = $this->input->post('idusuarioorc');
		if(!empty($idusuarioorc))
		{
			$query_usuario_orc = "($idusuarioorc)";
		}
		  
		  
		  
          $fornecedor_id = $this->input->post('fornecedor_id');
          $nf_fornecedor = $this->input->post('nf_fornecedor');
          $descricao = $this->input->post('descricao');
          $data_entrega = null;
          if(!empty($this->input->post('data_entrega_inicio')) && !empty($this->input->post('data_entrega_fim')) ){
              $data = explode("/",$this->input->post('data_entrega_inicio'));
              $data_entrega_inicio = $data[2]."-".$data[1]."-".$data[0];

              $data2 = explode("/",$this->input->post('data_entrega_fim'));
              $data_entrega_fim = $data2[2]."-".$data2[1]."-".$data2[0];
              $data_entrega = " and pedido_comprasitens.datastatusentregue BETWEEN \"$data_entrega_inicio\" and \"$data_entrega_fim\"";
          }
		
		$query_usuario = "";
		$idUsuarios = $this->input->post('idUsuarios');
		if(!empty($idUsuarios))
		{
			$conteudo22 = $idUsuarios;
            $query_usuario="(";
            $primeiro22 = true;
			foreach($conteudo22 as $tipouser)
			{
				if($primeiro22)
				{
					$query_usuario.=$tipouser;
					$primeiro22 = false;
				}
				else
				{
					$query_usuario.=",".$tipouser;
				}
			}
			$query_usuario .= ")";
		}
        $unid_execucao = $this->input->post('unid_execucao');
        $query_unid_execucao = "";
        if (!empty($unid_execucao)) {
            $conteudo2 = $unid_execucao;
            $query_unid_execucao = "(";
            $primeiro2 = true;
            foreach ($conteudo2 as $unid_execucao2) {
                if ($primeiro2) {
                    $query_unid_execucao .= $unid_execucao2;
                    $primeiro2 = false;
                } else {
                    $query_unid_execucao .= "," . $unid_execucao2;
                }
            }
            $query_unid_execucao .= ")";
        }
        //echo $query_unid_execucao;
        
        
        /*
        if($idStatuscompras == 1){

            if (!empty($idOs) || !empty($idPedidoCotacao)   || !empty($query_statuscompra) || !empty($idPedidoCompra) || !empty($fornecedor_id) || !empty($nf_fornecedor) || !empty($query_idgrupo) || !empty($query_usuario) || !empty($numPedido) || !empty($empresaNum1) || !empty($empresaNum2)) {

                $this->data['results'] = $this->cotacao_model->getWhereLikeos($idOs, $idPedidoCotacao,$idStatuscompras,$query_usuario);
 
                $config['total_rows'] = $this->cotacao_model->numrowsWhereLikeos($idOs, $idPedidoCotacao,$idStatuscompras,$query_usuario);
                $config['per_page'] = 5000;
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

        }else{
*/
            if (!empty($idOs) || !empty($idPedidoCotacao)   || !empty($query_statuscompra) || !empty($idPedidoCompra) || !empty($fornecedor_id) || !empty($nf_fornecedor) || !empty($query_idgrupo) || !empty($query_usuario) || !empty($numPedido) || !empty($empresaNum1) || !empty($empresaNum2) || !empty($descricao)|| !empty($data_entrega)|| !empty($query_unid_execucao) || !empty($query_usuario_orc)) {
                $finalizadoPCP = "1";
                $responsabilidadePCP = "0";
                $this->data['results'] = $this->pedidocompra_model->getWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo,'',$query_usuario, $numPedido, $empresaNum1, $empresaNum2, $descricao, ' and distribuir_os.idOs not in(1,2,3,6,7,10,11,12,13)',$data_entrega,$finalizadoPCP,$query_unid_execucao,$responsabilidadePCP,$query_usuario_orc);
                //print_r($this->data['results']); exit;
                //echo json_encode($this->data['results']);      
                $config['total_rows'] = $this->pedidocompra_model->numrowsWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo,'',$query_usuario, $numPedido, $empresaNum1, $empresaNum2, $descricao);
                $config['per_page'] = 2;
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
                
                //$this->pagination->initialize($config); 
            } 
        //}

         //else {

            //$config['total_rows'] = $this->pedidocompra_model->count('pedido_cotacaoitens');
            /*--ms--
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
         
         
         */
         //}
        
 
        
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
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
	    $this->data['view'] = 'suprimentos/suprimentos';
       	$this->load->view('tema/topo',$this->data);
       //$this->load->view('tema/rodape');
		
    }
	function almoxarifado(){
		 if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar Pedido de compra.');
           redirect(base_url());
        }
         $this->load->library('table');
         $this->load->library('pagination');
         
         $this->load->model('os_model');
		$this->load->model('orcamentos_model');		 
		$this->load->model('cotacao_model');		 
         
         $config['base_url'] = base_url().'index.php/suprimentos/almoxarifado/';
         
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
			$conteudo = $idgrupo;
		$query_idgrupo="(";
		$primeiro = true;
			foreach($conteudo as $idgrupo3)
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
		
		  
		  
		  
          $fornecedor_id = $this->input->post('fornecedor_id');
          $nf_fornecedor = $this->input->post('nf_fornecedor');
		
		
		
		
          $query_usuario = '';
		 
		 if (!empty($idOs) || !empty($idPedidoCotacao)   || !empty($query_statuscompra) || !empty($idPedidoCompra) || !empty($fornecedor_id) || !empty($nf_fornecedor) || !empty($query_idgrupo)) {
           
            $this->data['results'] = $this->pedidocompra_model->getWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo,'2',$query_usuario);
 
             $config['total_rows'] = $this->pedidocompra_model->numrowsWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo,'2',$query_usuario);
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
            $config['total_rows'] = count( $this->pedidocompra_model->getdistribuidorcount('pedido_cotacaoitens','*','statuscompras.idStatuscompras  in(2,7)  and distribuir_os.solicitacao = 2 '));
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
           
         $this->data['results'] = $this->pedidocompra_model->getdistribuidor('pedido_cotacaoitens','*','statuscompras.idStatuscompras  in(2,7) and distribuir_os.solicitacao = 2',$config['per_page'],$this->uri->segment(3));
         
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
       
	    $this->data['view'] = 'suprimentos/almoxarifado';
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
		
		if(!empty($this->uri->segment(4)))
		{
			$statuscompra = $this->uri->segment(4);
		}
		else
		{
			$statuscompra = '';
		}

         $data['result'] = $this->pedidocompra_model->pedidoCustom($this->uri->segment(3),'',$statuscompra);

        // NOVO BLOCO INSERIDO PARA CORRIGIR VALORES DE ITENS TRANSFERIDOS

		if (!empty($data['result'])) {
			foreach ($data['result'] as $item) {
				// Se a quantidade é zero (item totalmente transferido)
				if ((int)$item->quantidade === 0) {
					$item->valor_unitario = 0.00;
					$item->valor_total = 0.00;
				} 
				// Garante que o total reflete a quantidade atual (para itens parcialmente transferidos)
				else {
					$valor_unitario = (float) $item->valor_unitario;
					$quantidade = (float) $item->quantidade;
					
					// Verifica se a propriedade ipi_valor existe antes de usá-la
					$ipi_valor = 0.00;
					if (isset($item->ipi_valor)) {
						$ipi_valor = (float) $item->ipi_valor;
					}

					$subtotal = $valor_unitario * $quantidade;
					if ($ipi_valor > 0) {
						$subtotal += ($subtotal * ($ipi_valor / 100));
					}
					$item->valor_total = $subtotal;
				}
			}
		}
        // FIM DO BLOCO INSERIDO

	
		$this->load->helper('mpdf');
        echo $html = $this->load->view('suprimentos/imprimir/imprimir_pedido',$data,true);
       
    }

    public function imprimir_pedidos_compras(){

    }

	function imprimiritem(){
		
		$contadoripi=count($this->input->post('idPedidoCompraItensipi'));  		
					
        $idPedidoCompraipi	= $this->input->post('idPedidoCompraipi');
        $tipo = gettype($idPedidoCompraipi);

        if($tipo == 'array'){
            $primero = true;
            foreach($idPedidoCompraipi as $idspc){
                if($primero)
                {
                    $idPedidoCompraipi = $idspc;
                    $primero = false;
                }
                else
                {
                    $idPedidoCompraipi.=",".$idspc;
                }
                
            }
        }
        
        $itens = '';
        $primeiro = true;
        for($x=0;$x<$contadoripi;$x++)
        {
                        
            if($primeiro)
            {
                $itens.=$this->input->post('idPedidoCompraItensipi')[$x];
                $primeiro = false;
            }
            else
            {
                $itens.=",".$this->input->post('idPedidoCompraItensipi')[$x];
            }	
                
        }
            
        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        
        $data['result'] = $this->pedidocompra_model->pedidoCustom($idPedidoCompraipi,$itens);

        // Bloco de correção para itens transferidos (versão 2 - com verificação de ipi_valor)
        if (!empty($data['result'])) {
            foreach ($data['result'] as $item) {
                // Se a quantidade é zero (item totalmente transferido)
                if ((int)$item->quantidade === 0) {
                    $item->valor_unitario = 0.00;
                    $item->valor_total = 0.00;
                } 
                // Garante que o total reflete a quantidade atual (para itens parcialmente transferidos)
                else {
                    $valor_unitario = (float) $item->valor_unitario;
                    $quantidade = (float) $item->quantidade;
                    
                    // Verifica se a propriedade ipi_valor existe antes de usá-la
                    $ipi_valor = 0.00;
                    if (isset($item->ipi_valor)) {
                        $ipi_valor = (float) $item->ipi_valor;
                    }

                    $subtotal = $valor_unitario * $quantidade;
                    if ($ipi_valor > 0) {
                        $subtotal += ($subtotal * ($ipi_valor / 100));
                    }
                    $item->valor_total = $subtotal;
                }
            }
        }
        // FIM DO BLOCO INSERIDO		
		
        if(empty($data['result'][0]->imagem)){
            $idsDistribuirPar = $this->input->post('idDistribuir');
            $this->session->set_flashdata('error','Não é possivel imprimir ordens de compra sem informar a empresa e fornecedor.');
            $this->exibirsuprimentoseditados($idsDistribuirPar,null);
        }else{
            $this->load->helper('mpdf');
            //redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompraipi);			
            echo $html = $this->load->view('suprimentos/imprimir/imprimir_pedido',$data,true);
        }
        
		   				
	}

    function imprimiritem2(){

        $idDistribuir = $this->input->post('idDistribuir_');

        if ($this->input->post('idDistribuir_')[0] < 1) {
                
            $this->session->set_flashdata('error','Selecione pelo menos um item!');
                redirect(base_url() . 'index.php/suprimentos');
                
        }

		$contadoritens=count($idDistribuir);  

        $primeiro = true;
        $itens = '';
        for($x=0;$x<$contadoritens;$x++)
        {
                        
            if($primeiro)
            {
                $itens.=$idDistribuir[$x];
                $primeiro = false;
            }
            else
            {
                $itens.=",".$idDistribuir[$x];
            }	
                
        }

        $resultOcs = $this->pedidocompra_model->getOc($itens); 
        $contadorOcs = count($resultOcs);  
        $primeiro2 = true;
        $numsOcs = [];
        $pedidocompraitens = '';
        foreach($resultOcs as $roc){

            if($primeiro2)
            {
                $numsOcs[]=$roc->idPedidoCompra;
                $pedidocompraitens.= $roc->idPedidoCompraItens;
                $primeiro2 = false;
            }
            else
            {
                $numsOcs[]=$roc->idPedidoCompra;
                $pedidocompraitens .= ",".$roc->idPedidoCompraItens;
            }
                
        }
        $numsOcs= array_unique($numsOcs);
        /*
        print_r($numsOcs);
        print_r($pedidocompraitens);
        exit;
        */
        $primeiro3 = true;
        $strnumOcs = '';
        foreach($numsOcs as $nos){
            if($primeiro3)
            {
                $strnumOcs .= $nos; 
                $primeiro3 = false;
            }else{
                $strnumOcs .= ','.$nos;
            }
        }				
       
            
        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        
        $data['result'] = $this->pedidocompra_model->pedidoCustom($strnumOcs,$pedidocompraitens);
        ///print_r($data); exit;

        // Bloco de correção para itens transferidos (versão 2 - com verificação de ipi_valor)
        if (!empty($data['result'])) {
            foreach ($data['result'] as $item) {
                // Se a quantidade é zero (item totalmente transferido)
                if ((int)$item->quantidade === 0) {
                    $item->valor_unitario = 0.00;
                    $item->valor_total = 0.00;
                } 
                // Garante que o total reflete a quantidade atual (para itens parcialmente transferidos)
                else {
                    $valor_unitario = (float) $item->valor_unitario;
                    $quantidade = (float) $item->quantidade;
                    
                    // Verifica se a propriedade ipi_valor existe antes de usá-la
                    $ipi_valor = 0.00;
                    if (isset($item->ipi_valor)) {
                        $ipi_valor = (float) $item->ipi_valor;
                    }

                    $subtotal = $valor_unitario * $quantidade;
                    if ($ipi_valor > 0) {
                        $subtotal += ($subtotal * ($ipi_valor / 100));
                    }
                    $item->valor_total = $subtotal;
                }
            }
        }
        // FIM DO BLOCO INSERIDO	
		
        $this->load->helper('mpdf');
        //redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompraipi);			
        echo $html = $this->load->view('suprimentos/imprimir/imprimir_pedido',$data,true);
		   				
	}
	
    function imprimiritem3(){

        $idDistribuir = $this->input->post('idDistribuir_');
        $idEmitente2 = $this->input->post('idEmitente');
        //echo("<script>console.log('Emitente: ".$idEmitente2."');</script>");
        if ($this->input->post('idDistribuir_')[0] < 1) {
                
            $this->session->set_flashdata('error','Selecione pelo menos um item!');
                redirect(base_url() . 'index.php/suprimentos');
                
        }

		$contadoritens=count($idDistribuir);  

        $primeiro = true;
        $itens = '';
        for($x=0;$x<$contadoritens;$x++)
        {
                        
            if($primeiro)
            {
                $itens.=$idDistribuir[$x];
                $primeiro = false;
            }
            else
            {
                $itens.=",".$idDistribuir[$x];
            }	
                
        }
       
        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        //$data['dados_emitente'] = $this->cotacao_model->getEmitente($idEmitente2);
        //$dadosEmitente = $this->cotacao_model->getEmitente($idEmitente2);
        //$dadosPedidoCustom3 = $this->pedidocompra_model->pedidoCustom3($itens);
        //echo("<script>console.log('Emitente: ".$dadosPedidoCustom3."');</script>");
        $data['dados_emitente'] = $this->cotacao_model->getEmitente($idEmitente2);
        $data['result'] = $this->pedidocompra_model->pedidoCustom3($itens);
		
       // Bloco de correção para itens transferidos (versão 2 - com verificação de ipi_valor)
        if (!empty($data['result'])) {
            foreach ($data['result'] as $item) {
                // Se a quantidade é zero (item totalmente transferido)
                if ((int)$item->quantidade === 0) {
                    $item->valor_unitario = 0.00;
                    $item->valor_total = 0.00;
                } 
                // Garante que o total reflete a quantidade atual (para itens parcialmente transferidos)
                else {
                    $valor_unitario = (float) $item->valor_unitario;
                    $quantidade = (float) $item->quantidade;
                    
                    // Verifica se a propriedade ipi_valor existe antes de usá-la
                    $ipi_valor = 0.00;
                    if (isset($item->ipi_valor)) {
                        $ipi_valor = (float) $item->ipi_valor;
                    }

                    $subtotal = $valor_unitario * $quantidade;
                    if ($ipi_valor > 0) {
                        $subtotal += ($subtotal * ($ipi_valor / 100));
                    }
                    $item->valor_total = $subtotal;
                }
            }
        }
        // FIM DO BLOCO INSERIDO			

        $this->load->helper('mpdf');	
        echo $html = $this->load->view('suprimentos/imprimir/imprimir_pedido',$data,true);
		   				
	}

	function editar_notafiscal(){
		
		$contadoripi=count($this->input->post('idPedidoCompraItensipi'));  
		 		 
        
        $desconto = str_replace(".","",$this->input->post('descontoit'));
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
        $outros = str_replace(".","",$this->input->post('outrosit'));
        $outros = str_replace(",",".",$outros);
        if($outros == '')
        {
            $outros = '0.00';
        }
        $frete = str_replace(".","",$this->input->post('freteit'));
        $frete = str_replace(",",".",$frete);
        if($frete == '')
        {
            $frete = '0.00';
        }
        $icms = str_replace(".","",$this->input->post('icmsit'));
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
        if($this->input->post('idCondPgto') <> '')
        {
            $idCondPgto = $this->input->post('idCondPgto');
        }
        else
        {
            $idCondPgto = null;
        }
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

        if(!empty($this->input->post('datanf')))
        {
            $datanf = explode('/', $this->input->post('datanf'));
        $datanf = $datanf[2].'-'.$datanf[1].'-'.$datanf[0];	
        }
        else
        {
            $datanf = null;
        }

        if(!empty($this->input->post('nf')))
        {
            $nf = $this->input->post('nf');
        }
        else
        {
            $nf = null;
        }


					
		$idPedidoCompraipi	= $this->input->post('idPedidoCompraipi');	
		for($x=0;$x<$contadoripi;$x++)
        {
            if( !empty($previsao_entrega))
            {
                $data3 = array('previsao_entrega' => $previsao_entrega );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
            }
            if( !empty($prazo_entrega))
            {
                $data3 = array('prazo_entrega' => $prazo_entrega );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
            }
            if( !empty($idCondPgto))
            {
                $data3 = array('idCondPgto' => $idCondPgto );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
            }
            if( !empty($cod_pgto))
            {
                $data3 = array('cod_pgto' => $cod_pgto );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
            }
            if( !empty($obs))
            {
                $data3 = array('obs' => $obs );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
            }
            if( !empty($datanf))
            {
                $data3 = array('datanf' => $datanf );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
            }
            if( !empty($nf))
            {
                $data3 = array('notafiscal' => $nf );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
                
                $this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->input->post('idCotacaoItens2')[$x]);			 
                $idDistribuir =  $this->data['dadosped2']->idDistribuir;
                $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
            }
            if( !empty($desconto))
            {
                $data3 = array('desconto' => $desconto );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
            }
            if( !empty($outros))
            {
                $data3 = array('outros' => $outros );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
            }
            if( !empty($frete))
            {
                $data3 = array('frete' => $frete );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
            }
            if( !empty($icms))
            {
                $data3 = array('icms' => $icms );
                
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
            }
            
            
        
        }
        $this->session->set_flashdata('success','Dados alterado com sucesso!');
        redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompraipi);
	}

    // -----
	// function editar_ipi(){

    //     $idsDistribuirPar = $this->input->post('idDistribuir_ipi');
		
    //     $contadoripi=count($this->input->post('idPedidoCompraItensipi'));  
    
    //     $valoripi = str_replace(".","",$this->input->post('valoripi'));  
    //     $valoripi = str_replace(",",".",$valoripi);

    //     if($this->input->post('dataentregue2')){
    //         $dataentregue2 = explode('/', $this->input->post('dataentregue2'));
    //         $dataentregue2 = $dataentregue2[2].'-'.$dataentregue2[1].'-'.$dataentregue2[0];	
    //     }
    //     if( !empty($this->input->post('idStatuscompras2')) ){
    //         $objStatus = $this->pedidocompra_model->gettable('statuscompras','idStatuscompras ='. $this->input->post('idStatuscompras2'));
    //         if($objStatus->etapa >3){
                
    //             $objDistribuir2 = $this->pedidocompra_model->getDistribuirDetails2(implode(",",$idsDistribuirPar));
    //             //echo json_encode($objDistribuir2);
    //             //return ;
    //             foreach($objDistribuir2 as $c){
    //                 if($c->aprovacaoPCP != 1 || $c->aprovacaoDir != 1 || $c->aprovacaoSUP != 1 || $c->autorizadoCompra != 1){
    //                     $this->session->set_flashdata('error','Essa ordem de compra possuí itens que não foram aprovados'); 
                        
    //                     $this->exibirsuprimentoseditados($idsDistribuirPar);
    //                 }
    //             }
            
                
    //         }
                 
    //     }
        

    //     $idStatuscompras2 = $this->input->post('idStatuscompras2');
					
	// 	//$idPedidoCompraipi	= $this->input->post('idPedidoCompraipi');	
        
	// 	for($x=0;$x<$contadoripi;$x++)
	// 	{
			
	//         $this->data['dist'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idPedidoCompraItens ='. $this->input->post('idPedidoCompraItensipi')[$x]);

    //         $pedidoCompra = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $this->input->post('idPedidoCompraItensipi')[$x]);
    //         var_dump($pedidoCompra->autorizadoCompra); exit;
    //         if($pedidoCompra->autorizadoCompra == 1){
    //             $dist = $this->data['dist']->idDistribuir;
		 

    //             if( !empty($this->input->post('valoripi')))
    //                     {
    //                         $data2 = array(
                   
    //                 'ipi_valor' => $valoripi
    //                 );
    //                 $this->pedidocompra_model->edit('pedido_comprasitens', $data2, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
    //             }
                        
    //             if( !empty($this->input->post('dataentregue2')))
    //             {
    //                 $data3 = array(               
    //                     'datastatusentregue' => $dataentregue2
    //                 );
                    
    //                 $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
    //             }
    //                     /*if( !empty($this->input->post('datanf')) && !empty($this->input->post('nf')))
    //                     {
    //                         $data4 = array(
                   
    //                 'datanf' => $datanf,
    //                 'notafiscal' => $nf
    //             );
    //             $this->pedidocompra_model->edit('pedido_comprasitens', $data4, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
    //             }*/
    //             if( !empty($this->input->post('idStatuscompras2')) )
    //             {
    //                 $data4 = array(
            
    //                     'idStatuscompras' => $idStatuscompras2
    //                 );
    //                 var_dump("veio aqui"); exit;
    //                 $this->pedidocompra_model->edit('distribuir_os', $data4, 'idDistribuir', $dist);
    //                 $this->attDataAlteracao($dist);
    //                 if($this->input->post('idStatuscompras2') == 1 || $this->input->post('idStatuscompras2') == 2 || $this->input->post('idStatuscompras2') == 6){
    //                     if($this->input->post('idStatuscompras2') == 1 || $this->input->post('idStatuscompras2') == 6){
    //                         $pedidocompraitens2 = $this->pedidocompra_model->getPedidoCompraItensByIdDistribuir($dist);
    //                         foreach($pedidocompraitens2 as $v){
    //                             $pedidocompraitens3 = $this->pedidocompra_model->getPedidoCompraItensByIdCotacaoItem($v->idCotacaoItens);
    //                             foreach($pedidocompraitens3 as $b){
    //                                 $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$b->idPedidoCompraItens);
    //                             }
    //                             $this->pedidocompra_model->delete('pedido_cotacaoitens','idCotacaoItens',$v->idCotacaoItens);
    //                         }
    //                     }
    //                     if($this->input->post('idStatuscompras2') == 2){
    //                         $pedidocompraitens2 = $this->pedidocompra_model->getPedidoCompraItensByIdDistribuir($dist);
    //                         foreach($pedidocompraitens2 as $v){
    //                             $pedidocompraitens3 = $this->pedidocompra_model->getPedidoCompraItensByIdCotacaoItem($v->idCotacaoItens);
    //                             foreach($pedidocompraitens3 as $b){
    //                                 $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$b->idPedidoCompraItens);
    //                             }
    //                             $edit = array(
    //                                 'idPedidoCompra'=> null,
    //                                 'idPedidoCompraItens'=> null
    //                             );
    //                             $this->pedidocompra_model->edit("pedido_cotacaoitens",$edit,"idCotacaoItens",$v->idCotacaoItens);
    //                         }
    //                     }
    //                 }
    //             }
    
    //             if( !empty($this->input->post('nNotaFiscal2')) )
    //             {
    //                 $data5 = array(
            
    //                     'notafiscal' => $this->input->post('nNotaFiscal2')
    //                 );
    //                 //Id 5 para material recebido
    //                 /*$data6 = array(               
    //                     'idStatuscompras' => 5
    //                 );*/
                    
    //                 $this->pedidocompra_model->edit('pedido_comprasitens', $data5, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
    //                 //$this->pedidocompra_model->edit('distribuir_os', $data6, 'idDistribuir', $dist);
    //                 $this->attDataAlteracao($dist);
    
                
    //             }
    //         }
		       
		    
			
			
	// 	}
        
    //     $this->session->set_flashdata('success','Dados alterado com sucesso!');
    //     //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompraipi);
    //     $this->exibirsuprimentoseditados($idsDistribuirPar);
	// }
    // -----

    function editar_ipi(){

$idsDistribuirPar = $this->input->post('idDistribuir_ipi');

$contadoripi=count($this->input->post('idPedidoCompraItensipi'));

$valoripi = str_replace(".","",$this->input->post('valoripi'));
$valoripi = str_replace(",",".",$valoripi);
// Garante que é float, mesmo se vazio
 if(empty($valoripi)){ $valoripi = (float)0.00; } else { $valoripi = (float)$valoripi; }

$dataentregue2 = null; // Inicializa como null
if($this->input->post('dataentregue2')){
    try {
        $data_parts = explode('/', $this->input->post('dataentregue2'));
        if(count($data_parts) == 3 && checkdate($data_parts[1], $data_parts[0], $data_parts[2])){
             $dataentregue2 = $data_parts[2].'-'.$data_parts[1].'-'.$data_parts[0];
        } else {
             log_message('error', 'Data entregue inválida recebida em editar_ipi: ' . $this->input->post('dataentregue2'));
             // Considerar lançar erro ou usar null
        }
    } catch (Exception $e) {
        log_message('error', 'Erro ao processar data entregue em editar_ipi: ' . $e->getMessage());
    }
}

$idStatuscompras2_input = $this->input->post('idStatuscompras2'); // Status vindo do input geral (se houver)

// Validações pré-loop (se aplicável, como verificar aprovações para etapas > 3)
if( !empty($idStatuscompras2_input) ){
    $objStatusGeral = $this->pedidocompra_model->gettable('statuscompras','idStatuscompras ='. $idStatuscompras2_input);
    if($objStatusGeral && $objStatusGeral->etapa > 3){ // Verifica se o STATUS GERAL selecionado é uma etapa final
        $objDistribuir2 = $this->pedidocompra_model->getDistribuirDetails2(implode(",",$idsDistribuirPar));
        foreach($objDistribuir2 as $c){
            // Verifica se ALGUM item selecionado NÃO passou por todas as aprovações (intermediárias e final)
             // Se o status final for 23, a verificação deve ser diferente
            if ($idStatuscompras2_input == 23){
                // Se o objetivo é forçar para 23, não precisa checar aprovações finais ainda
            } else if($c->aprovacaoPCP != 1 || $c->aprovacaoDir != 1 || $c->aprovacaoSUP != 1 || $c->autorizadoCompra != 1){ // Checa aprovações incluindo a final (autorizadoCompra)
                $this->session->set_flashdata('error','Essa ordem de compra possuí itens que não foram totalmente aprovados para avançar para esta etapa.');
                $this->exibirsuprimentoseditados($idsDistribuirPar);
                return;
            }
        }
        // Verificação de anexos (se status = 10 e não tem anexo) - Mantida
        $pedidoItem =  $this->pedidocompra_model->gettable('pedido_cotacaoitens','idPedidoCompraItens ='. $this->input->post('idPedidoCompraItensipi')[0]); // Pega o primeiro item como referência
         if ($pedidoItem) {
             $anexoImagens3 = $this->pedidocompra_model->getAnexoCotacaoSuprimentosByIdPedidoCompra($pedidoItem->idPedidoCompra);
             foreach($objDistribuir2 as $c){
                 // A regra original era if ($c->idStatuscompras == 3) - mantendo essa lógica
                 if($c->idStatuscompras == 3 && $idStatuscompras2_input == 10 && (empty($anexoImagens3) || count($anexoImagens3)<2)){ // Verifica se está saindo do status 3 para o 10
                     $this->session->set_flashdata('error','Essa ordem de compra não pode ter o status alterado para "Aguardando Aprovação PCP", pois não possuí em anexo as cotações.');
                     $this->exibirsuprimentoseditados($idsDistribuirPar);
                     return;
                 }
             }
         }
    }
}


for($x=0; $x<$contadoripi; $x++)
{
    $idPedidoCompraItensAtual = $this->input->post('idPedidoCompraItensipi')[$x];
    $cotacaoItem = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idPedidoCompraItens ='. $idPedidoCompraItensAtual);

    if (!$cotacaoItem || !$cotacaoItem->idDistribuir) {
         log_message('error', "Não foi possível encontrar idDistribuir para idPedidoCompraItens: $idPedidoCompraItensAtual em editar_ipi.");
         continue; // Pula para o próximo item do loop
    }
    $dist = $cotacaoItem->idDistribuir;

    // --- Atualização de IPI --- (Mantida)
    if( !empty($this->input->post('valoripi'))){ // Verifica se o campo GERAL foi preenchido
        $data_ipi = array('ipi_valor' => $valoripi);
        $this->pedidocompra_model->edit('pedido_comprasitens', $data_ipi, 'idPedidoCompraItens', $idPedidoCompraItensAtual);
    }

    // --- Atualização de Data Entregue --- (Mantida)
    if( !empty($dataentregue2)) { // Usa a variável processada fora do loop
        $data_entrega = array('datastatusentregue' => $dataentregue2);
        $this->pedidocompra_model->edit('pedido_comprasitens', $data_entrega, 'idPedidoCompraItens', $idPedidoCompraItensAtual);
    }

    // --- INÍCIO: Bloco de Lógica de Status (SUBSTITUIÇÃO) ---
    $objDistribuir = $this->pedidocompra_model->gettable('distribuir_os','idDistribuir ='. $dist);
    $idStatusAtual = $objDistribuir->idStatuscompras;
    $idStatusNovoInput = $idStatuscompras2_input; // Usa o status GERAL selecionado
    //$objStatusNovo = $this->pedidocompra_model->gettable('statuscompras','idStatuscompras ='. $idStatusNovoInput);
	
	$objStatusNovo = null;
    if(!empty($idStatusNovoInput)){
        $objStatusNovo = $this->pedidocompra_model->gettable('statuscompras','idStatuscompras ='. $idStatusNovoInput);
    }
	
     // Pega valor unitário atual do item para validação (se necessário)
     $objPCIAtual = $this->pedidocompra_model->getbyIdPedidoComprasItens($idPedidoCompraItensAtual);
     $valor_unitario_atual = ($objPCIAtual && $objPCIAtual->valor_unitario) ? (float)$objPCIAtual->valor_unitario : 0.00;


    $enviarParaAprovacaoFinal = false;

     // Verifica se um novo status foi realmente selecionado no dropdown
     if (!empty($idStatusNovoInput)) {

         // Condição 1: Status atual é 'Gerou OC' (3) ou 'Aguardando Orçamento' (2) E o novo status selecionado é uma etapa de aprovação (etapa 3 ou maior - CONSIDERANDO ETAPA 4 PARA O STATUS 23) E o novo status não é o 23
         // Ajuste ">= 3" se a etapa do status 23 for diferente de 4
        if (($idStatusAtual == 3 || $idStatusAtual == 2) && isset($objStatusNovo->etapa) && $objStatusNovo->etapa >= 3 && $idStatusNovoInput != 23) {
             $enviarParaAprovacaoFinal = true;
        }
         // Condição 2: (Menos relevante aqui, pois o valor não é editado neste form, mas mantida por segurança) Status atual é 'Gerou OC' (3), valor unitário existe (>0) e novo status não é de reset
        if ($idStatusAtual == 3 && $valor_unitario_atual > 0.00 && !in_array($idStatusNovoInput, [1, 2, 6, 23])) {
             $enviarParaAprovacaoFinal = true;
        }
         // Condição 3: Item estava Rejeitado (15) ou Revisado PCP (22) e o novo status é um de aprovação (etapa >= 3) E o novo status não é o 23
        if (($idStatusAtual == 15 || $idStatusAtual == 22) && isset($objStatusNovo->etapa) && $objStatusNovo->etapa >= 3 && $idStatusNovoInput != 23){
            $enviarParaAprovacaoFinal = true;
        }

        if ($enviarParaAprovacaoFinal) {

            // Validar se o valor unitário já existe no banco (importante, pois não é editado aqui)
            if (empty($valor_unitario_atual) || $valor_unitario_atual == 0.00) {
                 $this->session->set_flashdata('error', 'O item com ID Dist: ' . $dist . ' não possui Valor Unitário cadastrado e não pode ser enviado para aprovação.');
                 $this->exibirsuprimentoseditados($idsDistribuirPar); // Adapte se necessário
                return; // Interrompe para este item ou todos? Decidi interromper tudo.
            }

            // Auto-aprova todas as etapas anteriores e envia para Daniel (Status 23)
            $data_auto_approve = array(
                'aprovacaoPCP' => 1, 'idUserAprovacao' => 51, 'data_autorizacaoPCP' => date('Y-m-d H:i:s'),
                'aprovacaoDirTec' => 1, 'idUserAprovacaoDirTec' => 51, 'data_autorizacaoDirTec' => date('Y-m-d H:i:s'), // Exemplo
                'aprovacaoSUP' => 1, 'idUserAprovacaoSUP' => 51, 'data_autorizacaoSUP' => date('Y-m-d H:i:s'),
                'aprovacaoDir' => 1, 'idUserAprovacaoDir' => 51, 'data_autorizacaoDir' => date('Y-m-d H:i:s'),
                'idStatuscompras' => 23, // <<< NOVO STATUS: Aguardando Aprovação Final
                'data_alteracao' => date('Y-m-d H:i:s'),
                'rejeitado' => 0, 'obs_rejeitado' => null, 'idUserRejeitado' => null, 'data_rejeitado' => null
            );
            $this->pedidocompra_model->edit('distribuir_os', $data_auto_approve, 'idDistribuir', $dist);

            // Garante que 'autorizadoCompra' em pedido_comprasitens está zerado/nulo
            $data_pci_reset = array('autorizadoCompra' => 0, 'idUsuarioAutorizacao' => null, 'data_autorizacao' => null);
            $this->pedidocompra_model->edit('pedido_comprasitens', $data_pci_reset, 'idPedidoCompraItens', $idPedidoCompraItensAtual);

        } else {
            // --- Lógica para outros status (não aprovação ou se já estiver em 23) ---
            if ($idStatusAtual != 23) {
                // Atualiza apenas se o status novo for diferente do atual E não for um que deveria ir para 23
                if ($idStatusNovoInput != $idStatusAtual && !in_array($idStatusNovoInput, [10, 12, 13, 16, 17, 23])) {
                    $data4 = array(
                        'idStatuscompras' => $idStatusNovoInput,
                        'data_alteracao' => date('Y-m-d H:i:s')
                    );
                     if($idStatusNovoInput != 15){ // Limpa rejeição se não for o status Rejeitado
                        $data4['rejeitado'] = 0; $data4['obs_rejeitado'] = null; $data4['idUserRejeitado'] = null; $data4['data_rejeitado'] = null;
                     }
                    $this->pedidocompra_model->edit('distribuir_os', $data4, 'idDistribuir', $dist);

                     // Lógica original para status 1, 2, 6 (Excluir/Resetar)
                     if($idStatusNovoInput == 1 || $idStatusNovoInput == 6){
                        if ($idPedidoCompraItensAtual) $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$idPedidoCompraItensAtual);
                        if ($cotacaoItem->idCotacaoItens) $this->cotacao_model->delete('pedido_cotacaoitens','idCotacaoItens',$cotacaoItem->idCotacaoItens);
                     } else if($idStatusNovoInput == 2){
                         $data56 = array('idPedidoCompra' => NULL, 'idPedidoCompraItens' => NULL);
                         if ($idPedidoCompraItensAtual) $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$idPedidoCompraItensAtual);
                         if ($cotacaoItem->idCotacaoItens) $this->cotacao_model->edit('pedido_cotacaoitens', $data56, 'idCotacaoItens', $cotacaoItem->idCotacaoItens);
                     }
                     // Lógica para status 5 (se existir)
                } else if ($idStatusNovoInput == $idStatusAtual) {
                    // Status não mudou, apenas atualiza data de alteração
                    $this->attDataAlteracao($dist);
                }
            } else {
                // Status atual é 23, não faz nada ou apenas atualiza data de alteração
                 $this->attDataAlteracao($dist);
            }
        }
     } else {
         // Nenhum status novo foi selecionado, apenas atualiza data de alteração
         $this->attDataAlteracao($dist);
     }
    // --- FIM: Bloco de Lógica de Status (SUBSTITUIÇÃO) ---


    // --- Atualização de Nota Fiscal --- (Mantida)
    if( !empty($this->input->post('nNotaFiscal2')) ) {
        $data_nf = array('notafiscal' => $this->input->post('nNotaFiscal2'));
        $this->pedidocompra_model->edit('pedido_comprasitens', $data_nf, 'idPedidoCompraItens', $idPedidoCompraItensAtual);
         // A lógica original também atualizava 'distribuir_os', mantendo isso:
         $this->pedidocompra_model->edit('distribuir_os', $data_nf, 'idDistribuir', $dist); // Cuidado: pode sobrescrever status
        $this->attDataAlteracao($dist); // Atualiza data de alteração
    }
	

} // Fim do for

$this->session->set_flashdata('success','Dados alterados com sucesso!');
$this->exibirsuprimentoseditados($idsDistribuirPar);
	}

	function montarpedidocompra(){ 

        $btnGerarCotacao = $this->input->post('btnGerarCotacao');
        $btnAbrirPedidos = $this->input->post('btnAbrirPedidos');
        $btnImprimSelecionados = $this->input->post('btnImprimSelecionados');     

        if($btnGerarCotacao){
            $this->montarImpressao();
        }elseif($btnAbrirPedidos){
            $this->editarpedidosuprimentos();
        }elseif($btnImprimSelecionados){
            $this->imprimiritem3();
        }else{
            //$contador=count($this->input->post('idCotacaoItens_'));
            if ($this->input->post('idDistribuir_')[0] < 1) {
            
                $this->session->set_flashdata('error','Nenhum item selecionado!');
                redirect(base_url() . 'index.php/suprimentos');
                    
            }
            $contador=count($this->input->post('idDistribuir_'));

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aPedCompra')){
            $this->session->set_flashdata('error','Você não tem permissão para adicionar pedido.');
            redirect(base_url());
            }
            //$this->load->model('orcamentos_model');
            $this->load->library('form_validation');
            $this->data['custom_error'] = '';
            /*
            for($x=0;$x<$contador;$x++)
            {
                if($this->input->post('idStatuscompras_')[$x] != 2 ){
                    $this->session->set_flashdata('error','Você só pode gerar ordem de compra de itens que estão *Aguardando Orçamento* e não possuem *número de Ordem de Compra*!');
                    redirect(base_url() . 'index.php/suprimentos');
                }

            }*/
            for($x=0;$x<$contador;$x++)
            {
                //$this->data['status_atual_valida'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->get('idDistribuir_')[$x]);                        
                $this->data_val['results'] = $this->pedidocompra_model->verificaos($this->input->post('idDistribuir_')[$x]);
               
                foreach($this->data_val['results'] as $rs){
                    if(($rs->idStatuscompras != 2 && $rs->idStatuscompras != 6) || !empty($rs->idPedidoCompra)){
                        $this->session->set_flashdata('error','Você só pode gerar ordem de compra de itens que estão *Aguardando Orçamento ou Cancelados* e não possuem *número de Ordem de Compra*!');
                        redirect(base_url() . 'index.php/suprimentos');
                    }
                }
                
            }            
    
            if ($this->input->post('idDistribuir_')[0] < 1) {
                
                $this->session->set_flashdata('error','Selecione pelo menos um item!');
                    redirect(base_url() . 'index.php/suprimentos');
                    
            } else {


            
            $data = array(
                            'data_cadastro' => date('Y-m-d H:i:s')
                        );               

    

            if (is_numeric($id = $this->pedidocompra_model->add('pedido_compras', $data, true)) ) {

                    $total=0;

                    for($x=0;$x<$contador;$x++)
                    {


                        
                        $this->data['dadoscot'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idDistribuir ='. $this->input->post('idDistribuir_')[$x]);
                    
                        $distri = $this->data['dadoscot']->idDistribuir;
                        
                        $objDistribuir = $this->pedidocompra_model->gettable('distribuir_os','idDistribuir ='. $distri,"1");
                        
                        /*
                        if($objDistribuir[0]->aprovacaoPCP == 1){
                            $data2 = array(
                                'data_cadastro' => date('Y-m-d H:i:s'),
                                'idCotacaoItens' => $this->data['dadoscot']->idCotacaoItens,                            
                                'idPedidoCompra' => $id,
                                'autorizadoCompra'=> 1,
                                'idUsuarioAutorizacao' =>51
                            );
                        }else{*/
                            $data2 = array(
                                'data_cadastro' => date('Y-m-d H:i:s'),
                                'idCotacaoItens' => $this->data['dadoscot']->idCotacaoItens,
                            
                                'idPedidoCompra' => $id
                            );
                        //}
                           
                        
                                                

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
                    
                        $this->attDataAlteracao($distri);	
                    
                        $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $distri);
                            
                        $this->pedidocompra_model->edit('pedido_cotacaoitens', $data5, 'idDistribuir', $this->input->post('idDistribuir_')[$x]);
                        
                        
                    }

                $this->session->set_flashdata('success','Pedido gerado com sucesso!');
                //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$id);
                $idsDistribuirPar = $this->input->post('idDistribuir_');
                $this->exibirsuprimentoseditados($idsDistribuirPar);
        
            }
            else {
                    
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao gerar pedido.</p></div>';
                }
            }
        }
	}

    
    //Monta cotação
    function montarcotacao(){
				
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCotacao')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar Cotacao.');
          redirect(base_url());
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        /*echo 'aqui';
        print_r($this->input->post('idDistribuir_'));
        echo 'aqui1';
        exit;*/

        $contador=count($this->input->post('idDistribuir_'));
  
        if ($this->input->post('idDistribuir_')[0] < 1) {
            
			$this->session->set_flashdata('error','Selecione pelo menos um item!');
			if(!empty($this->uri->segment(3)))
			{
				redirect(base_url() . 'index.php/almoxarifado');
			}
			else{
				redirect(base_url() . 'index.php/suprimentos');
			}
                
				
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
			
                    //verifica se esta reservado estoque
                    $this->data['status_atual'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->post('idDistribuir_')[$x]);
                        
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
                            'idStatuscompras' => '2'
                        );
                    }		 
					
				    $this->cotacao_model->add('pedido_cotacaoitens', $data2, true);
		            /*ms
                    $this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $this->input->post('idDistribuir_')[$x]);
					*/	
                }

                //$this->session->set_flashdata('success','Cotação cadastrada com sucesso!');
                if(!empty($this->uri->segment(3)))
                {
                    redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$id);
                }
                else
                {
                    //redirect(base_url() . 'index.php/cotacao/visualizarimprimir/'.$id);
                    redirect(base_url() . 'index.php/cotacao/visualizarimprimir/'.$id);
                }
	        }
            else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao gerar cotacao.</p></div>';
            }
		}
		
	}

    //monta impressão de cotação sem salvar no banco
    public function montarImpressao(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCotacao')){
            $this->session->set_flashdata('error','Você não tem permissão para adicionar Cotacao.');
            redirect(base_url());
          }
          //$this->load->model('orcamentos_model');
          $this->load->library('form_validation');
          $this->data['custom_error'] = '';

          $dadosFiltros = $this->input->post();
  
          $contador=count($this->input->post('idDistribuir_'));
    
          if ($this->input->post('idDistribuir_')[0] < 1) {
              
              $this->session->set_flashdata('error','Selecione pelo menos um item!');
              if(!empty($this->uri->segment(3)))
              {
                  redirect(base_url() . 'index.php/almoxarifado');
              }
              else{
                  redirect(base_url() . 'index.php/suprimentos');
              }

          } else { 
            $this->gerarCotacao();              
            $total=0;

            /*for($x=0;$x<$contador;$x++)
            {          
        
                $idsDistribuir .= '/'.$this->input->post('idDistribuir_')[$x];              
                	
            }*/

            //$this->session->set_flashdata('success','Cotação cadastrada com sucesso!');
            if(!empty($this->uri->segment(3)))
            {
                $this->visualizarimprimir2($this->input->post('idDistribuir_'),$dadosFiltros);
                //redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$id);
            }
            else
            {
                //redirect(base_url() . 'index.php/cotacao/visualizarimprimir/'.$id);
                //redirect(base_url() . 'index.php/suprimentos/visualizarimprimir'.$idsDistribuir);
                $this->visualizarimprimir($this->input->post('idDistribuir_'),$dadosFiltros);
            }
          
            
        }
    }




/**
     * Processa o formulário de Aprovação em Lote.
     */
    public function aprovacao_em_lote() {
        // 1. Verificação de Segurança (Apenas Daniel)
        if ($this->session->userdata('idUsuarios') != 53) {
            $this->session->set_flashdata('error', 'Acesso não autorizado.');
            redirect('suprimentos/aprovacaoFinal');
            return;
        }

        // 2. Validação de Permissão
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aAutCompraFIN')) {
            $this->session->set_flashdata('error', 'Permissão insuficiente.');
            redirect('suprimentos/aprovacaoFinal');
            return;
        }

        // 3. Obter e Validar Inputs
        $semana_ano = $this->input->post('semana_ano');
        $os_input = $this->input->post('lista_os');

        if (empty($semana_ano) || empty($os_input)) {
            $this->session->set_flashdata('error', 'Semana/Ano e Lista de OSs são obrigatórios.');
            redirect('suprimentos/aprovacaoFinal');
            return;
        }

        // Limpa e formata a lista de OSs (aceita espaço, vírgula ou quebra de linha)
        $arrayOs = preg_split('/[\s,]+/', $os_input);
        $arrayOs = array_filter(array_map('intval', $arrayOs)); // Remove vazios e converte para int

        if (empty($arrayOs)) {
            $this->session->set_flashdata('error', 'Nenhuma OS válida foi inserida.');
            redirect('suprimentos/aprovacaoFinal');
            return;
        }

        // 4. Buscar Itens Iniciais (Status 23)
        $itens_iniciais = $this->pedidocompra_model->getItensParaAprovacaoLote($arrayOs);
        
        if (empty($itens_iniciais)) {
            $this->session->set_flashdata('info', 'Nenhum item pendente de aprovação (Status 23) foi encontrado para as OSs informadas.');
            redirect('suprimentos/aprovacaoFinal');
            return;
        }

        // 5. Coletar OCs Únicas
        $lista_ocs = [];
        foreach ($itens_iniciais as $item) {
            $lista_ocs[$item->idPedidoCompra] = true;
        }
        $arrayIdPedidoCompra = array_keys($lista_ocs);

        // 6. Buscar TODOS os itens (Status 23) dessas OCs
        $itens_para_aprovar = $this->pedidocompra_model->getTodosItensDasOCsParaAprovar($arrayIdPedidoCompra);

        if (empty($itens_para_aprovar)) {
            // Isso não deve acontecer se $itens_iniciais não for vazio, mas é uma segurança.
            $this->session->set_flashdata('error', 'Erro ao buscar lista completa de itens para aprovar.');
            redirect('suprimentos/aprovacaoFinal');
            return;
        }

        // 7. Iniciar Transação e Aprovar
        $this->db->trans_start();

        $valor_total_aprovado = 0;
        $agora = date('Y-m-d H:i:s');
        $id_usuario = (int)$this->session->userdata('idUsuarios'); // ID 53

        foreach ($itens_para_aprovar as $item) {
            
            // 1. Update distribuir_os (Muda status para 14)
            $data_dist = [
                'idStatuscompras' => 14, // Compra Autorizada
                'data_alteracao' => $agora,
                'rejeitado' => 0,
                'obs_rejeitado' => null,
                'idUserRejeitado' => null,
                'data_rejeitado' => null
            ];
            $this->pedidocompra_model->edit('distribuir_os', $data_dist, 'idDistribuir', $item->idDistribuir);

            // 2. Update pedido_comprasitens (Define como autorizado)
            $data_pci = [
                'autorizadoCompra' => 1,
                'idUsuarioAutorizacao' => $id_usuario,
                'data_autorizacao' => $agora
            ];
            $this->pedidocompra_model->edit('pedido_comprasitens', $data_pci, 'idPedidoCompraItens', $item->idPedidoCompraItens);

            // 3. Somar valor
            $valor_total_aprovado += (float)$item->valor_item;
        }



        // 8. Finalizar Transação
        $this->db->trans_complete();

        // 9. Feedback
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Falha na transação. Nenhuma aprovação foi concluída.');
        } else {
            $this->session->set_flashdata('success', 'Aprovação em lote concluída! ' . count($itens_para_aprovar) . ' itens aprovados em ' . count($arrayIdPedidoCompra) . ' OCs. Valor total: R$ ' . number_format($valor_total_aprovado, 2, ',', '.'));
        }

        redirect('suprimentos/aprovacaoFinal');
    }
    /**
     * Carrega a tela de Aprovação Final, exclusiva para o usuário ID 53.
     * Lista itens com status 23 (Aguardando Aprovação Final).
     */
// SUBSTITUA A FUNÇÃO DA LINHA 1720 POR ESTA:
    /**
     * Carrega a tela de Aprovação Final, exclusiva para o usuário ID 53.
     * Lista itens com status 23 (Aguardando Aprovação Final).
     */
public function aprovacaoFinal() {
    // 1. Permissão Genérica de Visualização
    if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vAutCompra')) {
        $this->session->set_flashdata('error', 'Você não tem permissão para visualizar autorizações de compra.');
        redirect(base_url());
    }

    // 2. Verifica se é o Usuário Aprovador Final (Daniel ou Vagner)
    $idUsuario = (int)$this->session->userdata('idUsuarios');
    if ($idUsuario != 53 && $idUsuario != 18 && $idUsuario != 26) {
        $this->session->set_flashdata('error', 'Acesso não autorizado a esta funcionalidade.');
        redirect(base_url());
    }

    // 3. Define a variável para ativar o menu (se necessário)
    $this->data['menuAprovacaoFinal'] = true; // Para destacar o item no menu lateral

    // (demais linhas preservadas)
    $permCompra = $this->pedidocompra_model->getPermissaoCompraByIdPermissao($this->session->userdata('permissao'));
    $where = "";
    $where .= " AND distribuir_os.idStatuscompras = 23";
    $where .= " AND distribuir_os.rejeitado != 1";

    if (!empty($this->input->post("idOCFiltro"))) {
        if (ctype_digit($this->input->post("idOCFiltro"))) {
            $where .= " AND pedido_compras.idPedidoCompra = " . $this->db->escape($this->input->post("idOCFiltro"));
        }
    }

    $idComprador = !empty($this->input->post("idUserS")) ? (int)$this->input->post("idUserS") : null;
    if ($idComprador) {
        $where .= " AND distribuir_os.idUser_aguardandoOrc = " . $this->db->escape($idComprador);
    }

    if (!empty($permCompra)) {
        if (!empty($permCompra->valorMax)) {
            $this->data['listaPedidos'] = $this->pedidocompra_model->itensAprovacaoFinal($permCompra->valorMin, $permCompra->valorMax, $where);
        } else {
            $this->data['listaPedidos'] = $this->pedidocompra_model->itensAprovacaoFinal($permCompra->valorMin, "", $where);
        }
    } else {
        $this->data['listaPedidos'] = $this->pedidocompra_model->itensAprovacaoFinal("", "", $where);
    }

    if (!empty($this->data['listaPedidos'])) {
        foreach ($this->data['listaPedidos'] as &$pedido) {
            $unid_execucao_pedido = null;
            if (isset($pedido->unid_execucao)) {
                $unid_execucao_array = explode(';', $pedido->unid_execucao);
                $unid_execucao_pedido = $unid_execucao_array[0];
            }
            $pedido->itens = $this->pedidocompra_model->getByIdOrdemCompra2($pedido->idPedidoCompra, $unid_execucao_pedido, 23);
        }
        unset($pedido);
    }

    $this->data['histAutorizacao'] = $this->pedidocompra_model->getHistoricoAprovacaoDiretoria(); 
    if (!empty($this->data['histAutorizacao'])) {
        foreach ($this->data['histAutorizacao'] as &$hist) {
            $hist->itens = $this->pedidocompra_model->getByIdOrdemCompra2Hist($hist->idPedidoCompra);
        }
        unset($hist);
    }

    $this->data['view'] = 'suprimentos/autorizarcompra';
    $this->load->view('tema/topo', $this->data);
}

	 
	 
public function salvaritemcompra(){


    if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
      $this->session->set_flashdata('error','Você não tem permissão para editar item.');
      redirect(base_url());
    }
    $btnSalvar = $this->input->post("btnSalvar");
    $btnAlterar = $this->input->post("btnAlterar");
    if($btnAlterar){
        $this->editarpedidocompra(); // Chama a função de edição geral da OC
        return;
    }
    $this->load->model('cotacao_model');
    $this->load->model('estoque_model');
    $this->load->model('permissoes_model');

    $this->load->library('form_validation');
    $this->data['custom_error'] = '';

    $contador=count($this->input->post('idPedidoCompraItens'));

    $this->data['dadosFiltros'] = $this->input->post(); // Mantém os filtros para o redirect

    $idsDistribuirPar = $this->input->post('idDistribuir'); // Array de IDs para redirect

    // --- Validações Pré-Loop ---
    for($x=0;$x<$contador;$x++){
        // Validação Valor Unitário para Status de Aprovação
        $valor_unitario_val = str_replace(".","",$this->input->post('valor_unitario')[$x]);
        $valor_unitario_val = str_replace(",",".",$valor_unitario_val);
        if(empty($valor_unitario_val)){ $valor_unitario_val = (float)0.00; } else { $valor_unitario_val = (float)$valor_unitario_val; }

        $statusNovo1_val = $this->input->post('idStatuscompras')[$x];
        $objStatusNovo_val = $this->pedidocompra_model->gettable('statuscompras','idStatuscompras ='. $statusNovo1_val);

        // Se o valor é zero E o status selecionado é um que levaria à aprovação final (etapa >= 3)
        if($valor_unitario_val <= 0.00 && isset($objStatusNovo_val->etapa) && $objStatusNovo_val->etapa >= 3){
            $this->session->set_flashdata('error','É obrigatório cadastrar valor (maior que zero) em itens de aprovação! Item ID Dist: ' . $this->input->post('idDistribuir')[$x]);
            $this->exibirsuprimentoseditados($idsDistribuirPar,$this->data['dadosFiltros']);
            return;
        }

        // Validação Quantidade Recebida se Status = Entregue
        if($this->input->post('idStatuscompras')[$x] == 5 && $this->input->post('qtdrecebida')[$x] <= 0){
            $this->session->set_flashdata('error','Quantidade recebida não pode ser igual a 0 para o status "Material Entregue". Item ID Dist: ' . $this->input->post('idDistribuir')[$x]);
            $this->exibirsuprimentoseditados($idsDistribuirPar,$this->data['dadosFiltros']);
            return;
        }

        // Validação Data Entregue se Status = Entregue
        if($this->input->post('idStatuscompras')[$x] == 5 && empty($this->input->post('dataentregue')[$x])){
            $this->session->set_flashdata('error','Não é possivel alterar o status para "Material Entregue" se a "Data Entregue" estiver vazia. Item ID Dist: ' . $this->input->post('idDistribuir')[$x]);
            $this->exibirsuprimentoseditados($idsDistribuirPar,$this->data['dadosFiltros']);
            return;
        }
    }
    // --- Fim Validações Pré-Loop ---


    for($x=0;$x<$contador;$x++)
    {
        // Processa data entregue (se houver)
        $dataentregue_proc = null;
        if(!empty($this->input->post('dataentregue')[$x]))
        {
            try {
                $data_parts = explode('/', $this->input->post('dataentregue')[$x]);
                if(count($data_parts) == 3 && checkdate($data_parts[1], $data_parts[0], $data_parts[2])){
                    $dataentregue_proc = $data_parts[2].'-'.$data_parts[1].'-'.$data_parts[0];
                } else {
                     log_message('error', 'Data entregue inválida recebida em salvaritemcompra: ' . $this->input->post('dataentregue')[$x]);
                }
            } catch (Exception $e) {
                log_message('error', 'Erro ao processar data entregue em salvaritemcompra: ' . $e->getMessage());
            }
        }

        // Processa valores numéricos
        $valor_unitario = str_replace(".","",$this->input->post('valor_unitario')[$x]);
        $valor_unitario = str_replace(",",".",$valor_unitario);
        if(empty($valor_unitario)){ $valor_unitario = (float)0.00; } else { $valor_unitario = (float)$valor_unitario; }

        $ipi_valor = str_replace(".","",$this->input->post('ipi_valor')[$x]);
        $ipi_valor = str_replace(",",".",$ipi_valor);
        if(empty($ipi_valor)){ $ipi_valor = (float)0.00; } else { $ipi_valor = (float)$ipi_valor; }

        $valor_produtos = str_replace(".","",$this->input->post('valor_produtos')[$x]); // Este valor vem calculado da view
        $valor_produtos = str_replace(",",".",$valor_produtos);
        if(empty($valor_produtos)){ $valor_produtos = (float)0.00; } else { $valor_produtos = (float)$valor_produtos; }


        $valor_icms_input = str_replace(".","",$this->input->post('valor_icms')[$x]);
        $valor_icms_input = str_replace(",",".",$valor_icms_input);
        if(empty($valor_icms_input)){ $valor_icms_input = (float)0.00; } else { $valor_icms_input = (float)$valor_icms_input; }


        // Processa ICMS e porcentagem
        $porcentagem = false;
        $icms_porcentagem = '0.0000';
        $valor_icms_final = 0.00;
        if(!empty($this->input->post('checkPercentagem'))){
            foreach($this->input->post('checkPercentagem') as $r){
                if($r == $this->input->post('idPedidoCompraItens')[$x]){
                    $porcentagem = true;
                    break; // Sai do loop assim que encontrar
                }
            }
        }

        if($porcentagem){
            $icms_porcentagem = $valor_icms_input; // Guarda a porcentagem
             // Calcula o valor do ICMS com base no valor dos produtos (valor_total calculado na view) e porcentagem
             // Atenção: A base de cálculo pode variar (valor_produtos ou valor_unitario * qtd). Usando valor_produtos.
             if ($valor_produtos > 0 && $icms_porcentagem > 0) {
                 //$valor_icms_final = ($valor_produtos / (1 - ($icms_porcentagem / 100))) * ($icms_porcentagem / 100); // Cálculo por dentro?
                 $valor_icms_final = $valor_produtos * ($icms_porcentagem / 100); // Cálculo simples por fora
             } else {
                 $valor_icms_final = 0.00;
             }

        } else {
            $icms_porcentagem = '0.0000'; // Garante que está zerado se não for porcentagem
            $valor_icms_final = $valor_icms_input; // Usa o valor absoluto digitado
        }


        // --- Prepara dados para pedido_comprasitens ---
        $data2 = array(
            'quantidade' => $this->input->post('qtdrecebida')[$x],
            'id_status_grupo' => $this->input->post('idgrupo')[$x],
            'valor_unitario' => $valor_unitario,
            'ipi_valor' => $ipi_valor,
            'valor_total' => $valor_produtos, // Salva o valor total calculado na view (já inclui IPI)
            'icms' => $valor_icms_final, // Salva o valor calculado ou absoluto
            'porcentagem' => $porcentagem,
            'icmsPorcentagem' => $icms_porcentagem // Salva a porcentagem se aplicável
        );
        if($dataentregue_proc !== null) {
            $data2['datastatusentregue'] = $dataentregue_proc;
        }

        // --- Atualiza pedido_comprasitens ---
        $this->pedidocompra_model->edit('pedido_comprasitens', $data2, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens')[$x]);


        // --- INÍCIO: Bloco de Lógica de Status (SUBSTITUIÇÃO) ---
        $idDistribuir = $this->input->post('idDistribuir')[$x]; // Garante que temos o ID correto
        $objDistribuir = $this->pedidocompra_model->gettable('distribuir_os','idDistribuir ='. $idDistribuir); // Pega o estado ATUAL do item
        $idStatusAtual = $objDistribuir->idStatuscompras;
        $idStatusNovoInput = $this->input->post('idStatuscompras')[$x]; // Status vindo do select da view editarpedido.php
        $objStatusNovo = $this->pedidocompra_model->gettable('statuscompras','idStatuscompras ='. $idStatusNovoInput);
        // valor_unitario já foi processado acima

        $enviarParaAprovacaoFinal = false;

        // Condição 1: Status atual é 'Gerou OC' (3) ou 'Aguardando Orçamento' (2) E o novo status selecionado é uma etapa de aprovação (etapa 3 ou maior - CONSIDERANDO ETAPA 4 PARA O STATUS 23) E o novo status não é o 23
         // Ajuste ">= 3" se a etapa do status 23 for diferente de 4
        if (($idStatusAtual == 3 || $idStatusAtual == 2) && isset($objStatusNovo->etapa) && $objStatusNovo->etapa >= 3 && $idStatusNovoInput != 23) {
             $enviarParaAprovacaoFinal = true;
        }
        // Condição 2: Status atual é 'Gerou OC' (3), o valor unitário foi preenchido (>0) e o status selecionado NÃO é um de cancelamento/solicitado/aguardando (ou seja, a intenção é prosseguir) E o novo status não é o 23
        if ($idStatusAtual == 3 && $valor_unitario > 0.00 && !in_array($idStatusNovoInput, [1, 2, 6, 23])) {
             $enviarParaAprovacaoFinal = true;
        }
         // Condição 3: Item estava Rejeitado (15) ou Revisado PCP (22) e o novo status é um de aprovação (etapa >= 3) E o novo status não é o 23
        if (($idStatusAtual == 15 || $idStatusAtual == 22) && isset($objStatusNovo->etapa) && $objStatusNovo->etapa >= 3 && $idStatusNovoInput != 23){
            $enviarParaAprovacaoFinal = true;
        }


        if ($enviarParaAprovacaoFinal) {

            // Validação de valor unitário já feita no pré-loop

            // Auto-aprova todas as etapas anteriores e envia para Daniel (Status 23)
			// Auto-aprova todas as etapas anteriores e envia para Daniel (Status 23)
                $data_auto_approve = array(
                    'aprovacaoPCP' => 1,
                    'idUserAprovacao' => 51, // ID do Usuário Sistema/Automático
                    'data_autorizacaoPCP' => date('Y-m-d H:i:s'),

                    // Flags de aprovação intermediária existentes:
                    'aprovacaoSUP' => 1,
                    'idUserAprovacaoSUP' => 51,
                    'data_autorizacaoSUP' => date('Y-m-d H:i:s'),

                    'aprovacaoDir' => 1,
                    'idUserAprovacaoDir' => 51,
                    'data_autorizacaoDir' => date('Y-m-d H:i:s'),
                    // Fim das flags intermediárias

                    'idStatuscompras' => 23, // <<< NOVO STATUS: Aguardando Aprovação Final
                    'data_alteracao' => date('Y-m-d H:i:s'),
                    'rejeitado' => 0, // Garante que flags de rejeição sejam limpas
                    'obs_rejeitado' => null,
                    'idUserRejeitado' => null,
                    'data_rejeitado' => null
                     // ... (pode ter a linha data_enviadopcp aqui também) ...
                );
             // Adiciona data_enviadopcp se estiver mudando de um status anterior para aprovação
             if ($idStatusAtual < 10) { // Ou outra condição que indique o início do fluxo
                $data_auto_approve['data_enviadopcp'] = date('Y-m-d H:i:s');
             }
            $this->pedidocompra_model->edit('distribuir_os', $data_auto_approve, 'idDistribuir', $idDistribuir);

            // Garante que 'autorizadoCompra' em pedido_comprasitens está zerado/nulo
            $idPedidoCompraItemAtual = $this->input->post('idPedidoCompraItens')[$x];
             if ($idPedidoCompraItemAtual) {
                 $data_pci_reset = array('autorizadoCompra' => 0, 'idUsuarioAutorizacao' => null, 'data_autorizacao' => null);
                 $this->pedidocompra_model->edit('pedido_comprasitens', $data_pci_reset, 'idPedidoCompraItens', $idPedidoCompraItemAtual);
             } else {
                 log_message('error', "ID Pedido Compra Item não encontrado para ID Distribuir $idDistribuir ao tentar resetar autorizacaoCompra.");
             }

        } else {
            // --- Lógica original para outros status (Entregue, Cancelado, etc.) ---
            if ($idStatusAtual != 23) { // Só atualiza se NÃO estiver aguardando Daniel

                // Verifica se o status mudou E se não é um dos status que deveria ter ido para aprovação final
                if ($idStatusNovoInput != $idStatusAtual && !in_array($idStatusNovoInput, [10, 12, 13, 16, 17, 23])) {
                    $data3 = array(
                        'idStatuscompras' => $idStatusNovoInput,
                        'data_alteracao' => date('Y-m-d H:i:s')
                    );
                    // Adiciona data_enviadopcp se o novo status for 10 e o anterior não era
                    if ($idStatusNovoInput == 10 && $idStatusAtual != 10) {
                        $data3['data_enviadopcp'] = date('Y-m-d H:i:s');
                    }
                     if($idStatusNovoInput != 15){ // Limpa rejeição se não for o status Rejeitado
                        $data3['rejeitado'] = 0; $data3['obs_rejeitado'] = null; $data3['idUserRejeitado'] = null; $data3['data_rejeitado'] = null;
                     }
                    $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);

                     // Lógica específica original para status 1, 2, 6 (Excluir/Resetar pedido_comprasitens/pedido_cotacaoitens)
                     // A lógica original estava fora do IF principal, movida para cá
                     $idPedidoCompraItemAtual = $this->input->post('idPedidoCompraItens')[$x];
                     $idCotacaoItemAtual = $this->input->post('idCotacaoItens')[$x]; // Garante que temos o ID da cotação
                     if ($idStatusNovoInput == 1 || $idStatusNovoInput == 6) {
                         if ($idPedidoCompraItemAtual) $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$idPedidoCompraItemAtual);
                         if ($idCotacaoItemAtual) $this->cotacao_model->delete('pedido_cotacaoitens','idCotacaoItens',$idCotacaoItemAtual);
                         // Talvez deletar o 'distribuir_os' também no cancelamento? Depende da regra.
                         // Se deletar, o restante do loop (divisão de qtd) não deve ser executado para este item.

                     } else if ($idStatusNovoInput == 2) {
                          $data56 = array('idPedidoCompra' => NULL, 'idPedidoCompraItens' => NULL);
                          if ($idPedidoCompraItemAtual) $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$idPedidoCompraItemAtual);
                          if ($idCotacaoItemAtual) $this->cotacao_model->edit('pedido_cotacaoitens', $data56, 'idCotacaoItens', $idCotacaoItemAtual);
                     }
                     // Lógica para status 5 (Entregue)
                    if($idStatusNovoInput == 5){
                        $ok = false;
                        // A lógica original para OS 10, 11, 12 parece estar aqui:
                        if ($this->input->post('qtdrecebida')[$x] > 0 && ($objDistribuir->idOs == 10 || $objDistribuir->idOs == 11 || $objDistribuir->idOs == 12)){
                             // Certifique-se que $this->data['dadosped2'] está definido ou busque os dados necessários
                             $dadosped2 = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->input->post('idCotacaoItens')[$x]);

                            if($dadosped2 && isset($dataentregue_proc)) { // Verifica se dados existem e data foi processada
                                $ok = true;
                                $idEmitente3 = null;
                                if($objDistribuir->idOs == 10){ $idEmitente3 = 1; }
                                else if($objDistribuir->idOs == 11){ $idEmitente3 = 2; }
                                else if($objDistribuir->idOs == 12){ $idEmitente3 = 3; }

                                if($idEmitente3 !== null){
                                    $dataAgArmaz = array(
                                        'idStatusAgArmaz'=>2,
                                        'idDistribuirOs'=>$idDistribuir,
                                        'valorUnitario'=>$valor_unitario, // Usa o valor já processado
                                        'idUsuario'=>$this->session->userdata('idUsuarios'),
                                        'idInsumo'=>$objDistribuir->idInsumos,
                                        'idEmitente'=>$idEmitente3,
                                        'metrica'=>'0', // Assumindo métrica 0
                                        'quantidade'=>$this->input->post('qtdrecebida')[$x],
                                        'idOrdemCompra'=>$dadosped2->idPedidoCompra,
                                        'data_entregue'=>$dataentregue_proc // Usa a data processada
                                    );
                                    $this->load->model('almoxarifado_model','',TRUE);
                                    $result = $this->almoxarifado_model->getAgArmaz($idDistribuir);
                                    if(empty($result)){
                                        $this->almoxarifado_model->insertAgArmaz($dataAgArmaz);
                                    }
                                } else {
                                     log_message('error', "idEmitente não determinado para inserir em AgArmaz. ID OS: " . $objDistribuir->idOs);
                                }
                            } else {
                                log_message('error', "Dados ausentes (dadosped2 ou dataentregue) para inserir em AgArmaz. ID Distribuir: " . $idDistribuir);
                            }
                        }
                    }

                } else if ($idStatusNovoInput == $idStatusAtual) {
                    // Status não mudou, apenas atualiza data de alteração
                     $this->attDataAlteracao($idDistribuir); // Função helper para atualizar data_alteracao
                }
            } else {
                 // Status atual é 23, não faz nada ou apenas atualiza data de alteração
                 $this->attDataAlteracao($idDistribuir);
            }
        }
        // --- FIM: Bloco de Lógica de Status (SUBSTITUIÇÃO) ---


        // --- Lógica de Divisão de Quantidade (Mantida) ---
        // Verifica se o status NÃO é 1 ou 6 antes de dividir (pois o item original pode ter sido deletado)
        if (!in_array($idStatusNovoInput, [1, 6])) {
            $this->data['dadosped3'] = $this->pedidocompra_model->gettable('distribuir_os','idDistribuir ='. $idDistribuir); // Pega dados atualizados
            if ($this->data['dadosped3'] && $this->input->post('qtdrecebida')[$x] > 0) { // Verifica se dadosped3 existe
                if($this->input->post('qtdrecebida')[$x] < $this->data['dadosped3']->quantidade ) {
                    $qtd_nova =   $this->data['dadosped3']->quantidade - $this->input->post('qtdrecebida')[$x];

                    //add novo item (distribuir_os)
                    $data55 = (array)$this->data['dadosped3']; // Copia dados do item original
                    unset($data55['idDistribuir']); // Remove ID antigo
                    $data55['quantidade'] = $qtd_nova;
                    $data55['idStatuscompras'] = 4; // Ou outro status inicial apropriado para o restante
                    $data55['data_cadastro'] = date('Y-m-d H:i:s'); // Nova data de cadastro
                    $data55['data_alteracao'] = date('Y-m-d H:i:s');
                     // Limpa flags de aprovação para o novo item
                     $data55['aprovacaoPCP'] = 0; $data55['idUserAprovacao'] = null; $data55['data_autorizacaoPCP'] = null;
                     $data55['aprovacaoSUP'] = 0; $data55['idUserAprovacaoSUP'] = null; $data55['data_autorizacaoSUP'] = null;
                     $data55['aprovacaoDir'] = 0; $data55['idUserAprovacaoDir'] = null; $data55['data_autorizacaoDir'] = null;
                     //$data55['aprovacaoDirTec'] = 0; $data55['idUserAprovacaoDirTec'] = null; $data55['data_autorizacaoDirTec'] = null; // Se existir
                     $data55['rejeitado'] = 0; $data55['obs_rejeitado'] = null; $data55['idUserRejeitado'] = null; $data55['data_rejeitado'] = null;

                    $id_novo_distribuir = $this->pedidocompra_model->add('distribuir_os', $data55, true);

                    if($id_novo_distribuir){
                        $idsDistribuirPar[] = $id_novo_distribuir; // Adiciona ao array para redirect

                        // Atualiza quantidade do item original (distribuir_os)
                        $data3_ = array('quantidade' => $this->input->post('qtdrecebida')[$x]);
                        $this->pedidocompra_model->edit('distribuir_os', $data3_, 'idDistribuir', $idDistribuir);
                        $this->attDataAlteracao($idDistribuir); // Atualiza data de alteração

                        // Adiciona histórico da divisão
                        $data4 = array(
                            'id_distribuir' => $idDistribuir,
                            'data_cadastro' => date('Y-m-d H:i:s'),
                            'quantidade' => $this->data['dadosped3']->quantidade // Quantidade ANTES da divisão
                        );
                        $this->pedidocompra_model->add('distribuir_os_hist', $data4, true);


                        // Cria nova entrada em pedido_cotacaoitens para o novo distribuir_os
                        $dadosped2 = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->input->post('idCotacaoItens')[$x]); // Pega dados da cotação original
                         if ($dadosped2) {
                             $dataco = array(
                                 'data_cadastro' => date('Y-m-d H:i:s'), // Nova data
                                 'idDistribuir' => $id_novo_distribuir,
                                 'idPedidoCotacao' => $dadosped2->idPedidoCotacao, // Mesmo pedido de cotação
                                 'idPedidoCompra' => $dadosped2->idPedidoCompra, // Mesmo pedido de compra
                                 // idPedidoCompraItens será nulo ou criado depois? Criar um novo parece mais correto.
                             );
                             $id_nova_cotacao_item = $this->pedidocompra_model->add('pedido_cotacaoitens', $dataco, true);

                             // Ajusta valor_total do item original em pedido_comprasitens
                             $dados_ = $this->pedidocompra_model->gettable('pedido_comprasitens','idCotacaoItens ='. $this->input->post('idCotacaoItens')[$x]);
                             if ($dados_) {
                                 $valor_total_calc = $dados_->valor_unitario * $this->input->post('qtdrecebida')[$x];
                                 if($dados_->ipi_valor != 0.00) {
                                     $calc = ($dados_->ipi_valor / 100) * $valor_total_calc;
                                     $valor_total_calc = $valor_total_calc + $calc;
                                 }
                                 $data__ = array('valor_total' => $valor_total_calc);
                                 $this->pedidocompra_model->edit('pedido_comprasitens', $data__, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens')[$x]);

                                 // Cria novo item em pedido_comprasitens para a nova cotação
                                 $valor_total_calc2 = $dados_->valor_unitario * $qtd_nova;
                                 if($dados_->ipi_valor != 0.00) {
                                     $calc = ($dados_->ipi_valor / 100) * $valor_total_calc2;
                                     $valor_total_calc2 = $valor_total_calc2 + $calc;
                                 }

                                 $dataAtualMais1 = new DateTime();
                                 $dataAtualMais1->modify('+1 day');

                                 $datacom = array(
                                     'data_cadastro' => date('Y-m-d H:i:s'), // Nova data
                                     'idPedidoCompra' => $dados_->idPedidoCompra,
                                     'idCotacaoItens' => $id_nova_cotacao_item,
                                     'valor_unitario' => $dados_->valor_unitario,
                                     'ipi_valor' => $dados_->ipi_valor,
                                     'valor_total' => $valor_total_calc2,
                                     'quantidade' => $qtd_nova, // Quantidade do novo item
                                     'previsao_entrega' => $dataAtualMais1->format('Y-m-d'), // Nova previsão? Ou copiar?
                                     'id_status_grupo' => $dados_->id_status_grupo,
                                     'idCondPgto' => $dados_->idCondPgto,
                                     'cod_pgto' => $dados_->cod_pgto,
                                     'icms' => $dados_->icms, // Copia ICMS, porcentagem, etc.
                                     'porcentagem' => $dados_->porcentagem,
                                     'icmsPorcentagem' => $dados_->icmsPorcentagem,
                                     'autorizadoCompra' => 0, // Reinicia aprovação final
                                     'idUsuarioAutorizacao' => null,
                                     'data_autorizacao' => null
                                 );
                                 $id_novo_compra_item = $this->pedidocompra_model->add('pedido_comprasitens', $datacom, true);

                                 // Atualiza pedido_cotacaoitens com o novo idPedidoCompraItens
                                 if ($id_novo_compra_item) {
                                     $datadd = array('idPedidoCompraItens' => $id_novo_compra_item);
                                     $this->pedidocompra_model->edit('pedido_cotacaoitens', $datadd, 'idCotacaoItens', $id_nova_cotacao_item);
                                     $this->session->set_flashdata('success','Foi gerado novo item de compra restante.');
                                 } else {
                                     log_message('error', "Falha ao criar novo pedido_comprasitens para divisão de quantidade. ID Distribuir original: $idDistribuir");
                                     $this->session->set_flashdata('error','Erro ao dividir quantidade (pedido_comprasitens).');
                                 }
                             } else {
                                 log_message('error', "Não encontrou pedido_comprasitens original para recalcular total. ID Cotacao Item: " . $this->input->post('idCotacaoItens')[$x]);
                             }
                         } else {
                             log_message('error', "Não encontrou pedido_cotacaoitens original para copiar dados. ID Cotacao Item: " . $this->input->post('idCotacaoItens')[$x]);
                             $this->session->set_flashdata('error','Erro ao dividir quantidade (pedido_cotacaoitens).');
                         }
                    } else {
                         log_message('error', "Falha ao criar novo distribuir_os para divisão de quantidade. ID Distribuir original: $idDistribuir");
                         $this->session->set_flashdata('error','Erro ao dividir quantidade (distribuir_os).');
                    }
                }
            } else {
                 log_message('debug', "Dados de distribuir_os não encontrados para ID: $idDistribuir durante a divisão de quantidade.");
            }
        } // Fim da verificação de status 1 ou 6


    }//final do for


    //$this->session->set_flashdata('success','Pedido salvo com sucesso.');
    if($redireciona == 'editarPedido'){
        $this->session->set_flashdata('success','Pedido salvo com sucesso.');
        $this->exibirsuprimentoseditados($idsDistribuirPar,$this->data['dadosFiltros']);
        return;
    }else{
        redirect(base_url() . 'index.php/suprimentos');
    }

}


    public function exibirsuprimentoseditados($idsDistribuirPar = null,$data = null){
    
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
            $this->session->set_flashdata('error','Você não tem permissão para editar Pedido de compra.');
            redirect(base_url());
         }
         //$this->session->set_flashdata('success','Pedido salvo com sucesso.');
         $contador = count($this->input->post('idStatuscompras_'));
          
 
         $this->load->library('table');
         $this->load->library('pagination');
          
         $this->load->model('os_model');
         $this->load->model('orcamentos_model');		 
         $this->load->model('cotacao_model');		 
          
         $config['base_url'] = base_url().'index.php/suprimentos/editarpedido/';
 
         //trazer maior q  3 o status        
         $this->data['dados_statuscompra'] = $this->pedidocompra_model->getstatus_compra2('0');
         $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
         $this->data['dados_statuscondicao'] = $this->pedidocompra_model->getstatus_cond_pg('');
         $this->data['dadosFiltros'] = $data;
          
        if(!empty($this->session->flashdata('idsDistribuir'))){
            $idsDistribuir = $this->session->flashdata('idsDistribuir');
        }else if($this->input->post('idDistribuir_')){
            $idsDistribuir = $this->input->post('idDistribuir_');
            $this->session->set_flashdata('idsDistribuir', $idsDistribuir);
            redirect(base_url(). 'index.php/suprimentos/exibirsuprimentoseditados');
        }else if(!empty($idsDistribuirPar)){
            $idsDistribuir = $idsDistribuirPar;
            $this->session->set_flashdata('idsDistribuir', $idsDistribuirPar);
            redirect(base_url(). 'index.php/suprimentos/exibirsuprimentoseditados');
        }
      
         //print_r($idsDistribuir); exit;
 
         $idPedidoCompra = $this->uri->segment(3);
         // echo  $rrrr = $this->uri->segment(5);
         if(!empty($this->uri->segment(4)))
         {	                      
             $statuscompra = $this->uri->segment(4);
         }
         else {
             $statuscompra = '';
         }	
         
         $this->data['results'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'',$statuscompra);
         $this->data['resultsnf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'1',$statuscompra);
         $this->data['resultsosf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'2',$statuscompra);
          
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
    
        $this->data['view'] = 'suprimentos/editarpedido';
        
        $this->load->view('tema/topo',$this->data);
         //$this->load->view('tema/rodape');
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
               redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$this->input->post('idPedidoCompra'));
			
           
		
		
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
        foreach ($itenspc as $r){
            $idPedidoCompraItens =  $r->idPedidoCompraItens;
            $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $idPedidoCompraItens);
        }
			 
					
        $this->session->set_flashdata('success','Grupo salvo com sucesso.');
        redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$this->input->post('idPedidoCompra'));
		
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
         
        $config['base_url'] = base_url().'index.php/suprimentos/editarpedido/';
        //trazer maior q  3 o status        
        $this->data['dados_statuscompra'] = $this->pedidocompra_model->getstatus_compra2('0');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
        $this->data['dados_statuscondicao'] = $this->pedidocompra_model->getstatus_cond_pg('');
		 
         
        $idPedidoCompra = $this->uri->segment(3);
        // echo  $rrrr = $this->uri->segment(5);
		if(!empty($this->uri->segment(4)))
		{	
					 
			$statuscompra = $this->uri->segment(4);
		}
		else
		{
			$statuscompra = '';
		}	
		
		$this->data['results'] = $this->pedidocompra_model->getpedidocomprafornece($idPedidoCompra,'',$statuscompra);
		$this->data['resultsnf'] = $this->pedidocompra_model->getpedidocomprafornece($idPedidoCompra,'1',$statuscompra);
		$this->data['resultsosf'] = $this->pedidocompra_model->getpedidocomprafornece($idPedidoCompra,'2',$statuscompra);
         
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
       
	    $this->data['view'] = 'suprimentos/editarpedido';
        
       	$this->load->view('tema/topo',$this->data);
            
        //$this->load->view('tema/rodape');
		
    }

    function editarpedidosuprimentos($idsDistribuirPar = array()){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){
           $this->session->set_flashdata('error','Você não tem permissão para editar Pedido de compra.');
           redirect(base_url());
        }

        $contador = count($this->input->post('idStatuscompras_'));
        for($x=0;$x<$contador;$x++)
        {
            if($this->input->post('idStatuscompras_')[$x] < 3 ){
                $this->session->set_flashdata('error','Verifique o(s) statu(s) da(s) Ordem(ns) de Compra(s) que está tentando visualizar!');
                redirect(base_url() . 'index.php/suprimentos');
            }

        }


        $this->load->library('table');
        $this->load->library('pagination');
         
        $this->load->model('os_model');
		$this->load->model('orcamentos_model');		 
		$this->load->model('cotacao_model');		 
         
        $config['base_url'] = base_url().'index.php/suprimentos/editarpedido/';

        //trazer maior q  3 o status        
        $this->data['dados_statuscompra'] = $this->pedidocompra_model->getstatus_compra2('0');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
        $this->data['dados_statuscondicao'] = $this->pedidocompra_model->getstatus_cond_pg('');

        $this->data['dadosFiltros'] = $this->input->post();
		 

        if($this->input->post('idDistribuir_')){
            $idsDistribuir = $this->input->post('idDistribuir_');
        }elseif(!empty($idsDistribuirPar)){
            $idsDistribuir = $idsDistribuirPar;
        }

    
        if ($this->input->post('idDistribuir_')[0] < 1) {
            
            $this->session->set_flashdata('error','Selecione pelo menos um item!');
            if(!empty($this->uri->segment(3))){
                redirect(base_url() . 'index.php/almoxarifado');
            }
            else{
                redirect(base_url() . 'index.php/suprimentos');
            }
        } 

        //print_r($idsDistribuir); exit;

           

        $idPedidoCompra = $this->uri->segment(3);
        // echo  $rrrr = $this->uri->segment(5);
		if(!empty($this->uri->segment(4)))
		{	
			$statuscompra = $this->uri->segment(4);
		}
		else
		{
			$statuscompra = '';
		}	
		
		$this->data['results'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'',$statuscompra);
		$this->data['resultsnf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'1',$statuscompra);
		$this->data['resultsosf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'2',$statuscompra);
         
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
       
	    $this->data['view'] = 'suprimentos/editarpedido';
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
        $idPedidoCompraItens = "";
        $idPedidoCompraItens = $this->input->post('idPedidoCompraItens');
        //echo("<script>console.log('List'".implode(",",$idDistribuirOS).");</script>");
        
  
        $idPedidoCompra= $this->input->post('idPedidoCompra');
    
    
        if($this->input->post('fornecedor_id') <> '')
        {
            $fornecedor_id = $this->input->post('fornecedor_id');
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
        $frete = str_replace(".","",$this->input->post('freteit'));
        $frete = str_replace(",",".",$frete);
        if($frete == '')
        {
            $frete = '0.00';
        }
        $icms = str_replace(".","",$this->input->post('icmsit'));
        $icms = str_replace(",",".",$icms);
        if($icms == '')
        {
            $icms = '0.00';
        }

					
        $data3 = array(
            'idFornecedores' => $fornecedor_id,
            'idEmitente' => $emitente_id,
            'frete' => $frete/*,
            'icms' => $icms*/
        );
			
				
        $this->pedidocompra_model->edit('pedido_compras', $data3, 'idPedidoCompra', $idPedidoCompra);	

        //-------------------------------------------------------------------------------------------------
        
        //$contadoripi=count($idPedidoCompra);  		 		 
        
        $desconto = str_replace(".","",$this->input->post('descontoit'));
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
        $outros = str_replace(".","",$this->input->post('outrosit'));
        $outros = str_replace(",",".",$outros);
        if($outros == '')
        {
            $outros = '0.00';
        }
        
        if($this->input->post('previsao_entrega') <> '')
        {
            $previsao_entrega = explode('/', $this->input->post('previsao_entrega'));
        $previsao_entrega = $previsao_entrega[2].'-'.$previsao_entrega[1].'-'.$previsao_entrega[0];		
        }
        else{
            $previsao_entrega = null;
        }
        if($this->input->post('idCondPgto') <> '')
        {
            $idCondPgto = $this->input->post('idCondPgto');
        }
        else
        {
            $idCondPgto = null;
        }
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

        if(!empty($this->input->post('datanf')))
        {
            $datanf = explode('/', $this->input->post('datanf'));
        $datanf = $datanf[2].'-'.$datanf[1].'-'.$datanf[0];	
        }
        else
        {
            $datanf = null;
        }

        if(!empty($this->input->post('nf')))
        {
            $nf = $this->input->post('nf');
        }
        else
        {
            $nf = null;
        }


					
		$idPedidoCompraipi	= $this->input->post('idPedidoCompraipi');	
        if( !empty($previsao_entrega))
        {
            $data3 = array('previsao_entrega' => $previsao_entrega );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);  
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        if( !empty($prazo_entrega))
        {
            $data3 = array('prazo_entrega' => $prazo_entrega );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        if( !empty($idCondPgto))
        {
            $data3 = array('idCondPgto' => $idCondPgto );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS); 
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        if( !empty($cod_pgto))
        {
            $data3 = array('cod_pgto' => $cod_pgto );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);  
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        if( !empty($obs))
        {
            $data3 = array('obs' => $obs );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
            
        }
        if( !empty($datanf))
        {
            $data3 = array('datanf' => $datanf );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);  
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        if( !empty($nf))
        {
            $data3 = array('notafiscal' => $nf );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);    
            }
            
            $this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);			 
            $idDistribuir =  $this->data['dadosped2']->idDistribuir;
            $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
            $this->attDataAlteracao($idDistribuir);
        }
        if( !empty($desconto))
        {
            $data3 = array('desconto' => $desconto );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS); 
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        if( !empty($outros))
        {
            $data3 = array('outros' => $outros );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);    
            }
        }
        if( !empty($frete))
        {
            $data3 = array('frete' => $frete );
            
            foreach($idPedidoCompraItens as $distrOS){
                //$this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);  
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        /*
        if( !empty($icms))
        {
            $data3 = array('icms' => $icms );
            
            foreach($idPedidoCompraItens as $distrOS){
                //$this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }*/
                
            
        $this->session->set_flashdata('success','Pedido alterado com sucesso!');
        //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra);
        $idsDistribuirPar = $this->input->post('idDistribuir_');
        $this->exibirsuprimentoseditados($idsDistribuirPar,'');      
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
                redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra);
				
        } else {
			 
			 
            $data3 = array(
                        'liberado_edit_compras' => '1'
                    );
			
			
	        $this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $id_item_pc1);
			

	        $this->session->set_flashdata('success','Item Liberado com sucesso!');
	
				redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra);
			
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
                redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra);
				
         } else {
			 
			 		
			

$data3 = array(
                'liberado_edit_compras' => '0'
            );
			
			
	$this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $id_item_pc2);
			

	$this->session->set_flashdata('success','Item Liberado com sucesso!');
	
				redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra);
			
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

        $pedidoCompra = $this->input->post('idPedidoCompra_n');
        $objPedidoCompra = $this->pedidocompra_model->getdistribuidorByIdPedidoCompra($pedidoCompra);
        
        
        if(count($objPedidoCompra) == 0 || $this->input->post('idPedidoCompra_n') == ''){
            $this->session->set_flashdata('error','Informe o número válido do pedido!');
            redirect(base_url() . 'index.php/suprimentos');
        }
        //verifica se a ordem de compra de destino possuí itens nas etapas de aprovação e posteriores
        foreach($objPedidoCompra as $c){
            if($c->etapa >=3){
                $this->session->set_flashdata('error','A ordem de compra de destino possuí itens que não estão no status "Gerou ordem de compra"');
                redirect(base_url() . 'index.php/suprimentos');
            }
        }
        $itemPedido = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $this->input->post('idPedidoCompraItens_'));
        $objPedidoCompraExistente = $this->pedidocompra_model->getdistribuidorByIdPedidoCompra($itemPedido->idPedidoCompra);
        //verifica se a ordem de compra atual possuí itens nas etapas de aprovação e posteriores
        foreach($objPedidoCompraExistente as $c){
            if($c->etapa >=3){
                $this->session->set_flashdata('error','A ordem de compra de atual possuí itens que não estão no status "Gerou ordem de compra"');
                redirect(base_url() . 'index.php/suprimentos');
            }
        }
  
        $idPedidoCompraItens = $this->input->post('idPedidoCompraItens_');
        $idPedidoCompra_n= $this->input->post('idPedidoCompra_n');
		
  
        if(count($this->pedidocompra_model->getqtditens($idPedidoCompra_n)) == 0 || $this->input->post('idPedidoCompra_n') == '') {
            
			$this->session->set_flashdata('error','Informe o número válido do pedido!');
                redirect(base_url() . 'index.php/suprimentos');
				
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
					
			$this->data['pedidoCotacaoID'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens = '.$idCotacaoItens);
            $this->attDataAlteracao($this->data['pedidoCotacaoID']->idDistribuir);
	$this->session->set_flashdata('success','Pedido alterado com sucesso!');
	
				redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra_n);
			
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
        $idPedidoCotacao = $this->data['dadosped2']->idPedidoCotacao;
       
        
        if ($idCotacaoItens == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir item.'); 
			  redirect(base_url() . 'index.php/suprimentos/gerenciar/'.$idPedidoCompra);
            
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
                $this->attDataAlteracao($idDistribuir);
                $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
                $this->pedidocompra_model->edit('pedido_cotacaoitens', $data4, 'idCotacaoItens', $idCotacaoItens);
			
		
			if(count($this->pedidocompra_model->getqtditens($idPedidoCompra)) == 1)
			{
				$this->pedidocompra_model->delete('pedido_compras','idPedidoCompra',$idPedidoCompra);  
			}
			$this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$idPedidoCompraItens);

            $this->pedidocompra_model->delete('pedido_cotacaoitens','idCotacaoItens',$idCotacaoItens);

			
			 $this->session->set_flashdata('success','Item excluido com sucesso do pedido!'); 
				if(count($this->pedidocompra_model->getqtditens($idPedidoCompra)) == 1)
			{
                redirect(base_url() . 'index.php/suprimentos/gerenciar/'.$idPedidoCompra);
			}
			else
			{
				  redirect(base_url() . 'index.php/suprimentos');
			}
		
			}
			    else
			{
                $itenspc = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idPedidoCompra ='. $idPedidoCompra,1);
                foreach ($itenspc as $r)
                {
                    $idDistribuir2 =  $r->idDistribuir;
            
            
                    $this->attDataAlteracao($idDistribuir2);
                    $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir2);
                    //$this->pedidocompra_model->edit('pedido_cotacaoitens', $data4, 'idPedidoCompra', $r->idPedidoCompra);
                    $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompra',$r->idPedidoCompra); 
                    $this->pedidocompra_model->delete('pedido_compras','idPedidoCompra',$r->idPedidoCompra);
                    $this->pedidocompra_model->delete('pedido_cotacaoitens','idPedidoCompra', $r->idPedidoCompra);
                }
                
                
				$this->session->set_flashdata('success','Pedido excluido com sucesso!'); 
				redirect(base_url() . 'index.php/suprimentos');
				
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
             //$campo = $this->input->get('campo', TRUE);
			
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
  
        	

        	if($this->input->post('idOs') == 1 || $this->input->post('idOs') == 2 || $this->input->post('idOs') == 3 || $this->input->post('idOs') == 6){
                $data = array(
                    'idInsumos' => $this->input->post('idInsumos2'),
                    'dimensoes' => $this->input->post('dimensoes'),
                    'obs' => $this->input->post('obs'),
                    'quantidade' => $this->input->post('quantidade'),
                    'idOs' => $this->input->post('idOs'),
                    'aprovacaoPCP' => 1,
                    'idUserAprovacaoDir' => 51,
                    'aprovacaoDir'=>1,
                    'idUserAprovacao'=>51,
                    'data_autorizacaoPCP'=>date('Y-m-d H:i:s'),
                    'data_autorizacaoDir'=>date('Y-m-d H:i:s')
                );
            }else{
                $data = array(
                    'idInsumos' => $this->input->post('idInsumos2'),
                    'dimensoes' => $this->input->post('dimensoes'),
                    'obs' => $this->input->post('obs'),
                    'quantidade' => $this->input->post('quantidade'),
                    'idOs' => $this->input->post('idOs')
                );
            }
        	

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

    public function autoCompleteFunc(){
        
        if(!empty($this->uri->segment(3))){
            $e = $this->uri->segment(3);
        }
        
        if ($this->input->get('term') !== null){
            $q = strtolower($this->input->get('term', TRUE));
            $this->pedidocompra_model->autoCompleteFunc($q);
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

    function visualizarimprimir($idsDistribuir, $dadosFiltros){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCotacao')){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar Cotacao.');
          redirect(base_url());
        }
       
       $this->load->library('table');
       $this->load->library('pagination');
       $this->load->model('os_model');
       $this->load->model('orcamentos_model');		 
        
       $config['base_url'] = base_url().'index.php/cotacao/visualizarimprimir/';
        
       $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
       $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();

       //----------------------------------------------------------------------
       $this->data['dadosFiltros'] = $dadosFiltros;

       //----------------------------------------------------------------------
       
                
       
       //$idsPedidoCotacao = $this->uri->segment_array();
       //$i=1;
       $arrayParPedidoCotacao = [];
       foreach ($idsDistribuir as $segment)
        {
            //if($i > 2 ){
                $arrayParPedidoCotacao[] = $segment;
            //}
            //$i++;
        }
        $parPedidoCotacao = implode(', ', $arrayParPedidoCotacao);

       $this->data['results'] = $this->pedidocompra_model->getWhereLikeos2($parPedidoCotacao);
 
       /*$this->data['results'] = $this->os_model->get('os','idOs,dataInicial,dataFinal,garantia,descricaoProduto,defeito,status,observacoes,laudoTecnico','',$config['per_page'],$this->uri->segment(3));*/
      
       $this->data['view'] = 'suprimentos/visualizarimprimir';
        $this->load->view('tema/topo',$this->data);
      //$this->load->view('tema/rodape');
       
   }
   function visualizarimprimir2($idsDistribuir, $dadosFiltros){
    if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCotacao')){
      $this->session->set_flashdata('error','Você não tem permissão para visualizar Cotacao.');
      redirect(base_url());
    }
   
   $this->load->library('table');
   $this->load->library('pagination');
   $this->load->model('os_model');
   $this->load->model('orcamentos_model');		 
    
   //$config['base_url'] = base_url().'index.php/cotacao/visualizarimprimir/';
    
   $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
   $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();

   //----------------------------------------------------------------------
   $this->data['dadosFiltros'] = $dadosFiltros;

   //----------------------------------------------------------------------
   
            
   
   //$idsPedidoCotacao = $this->uri->segment_array();
   //$i=1;
   $arrayParPedidoCotacao = [];
   foreach ($idsDistribuir as $segment)
    {
        //if($i > 2 ){
            $arrayParPedidoCotacao[] = $segment;
        //}
        //$i++;
    }
    $parPedidoCotacao = implode(', ', $arrayParPedidoCotacao);

   $this->data['results'] = $this->pedidocompra_model->getWhereLikeos2($parPedidoCotacao);

   /*$this->data['results'] = $this->os_model->get('os','idOs,dataInicial,dataFinal,garantia,descricaoProduto,defeito,status,observacoes,laudoTecnico','',$config['per_page'],$this->uri->segment(3));*/
  
   $this->data['view'] = 'almoxarifado/visualizarimprimir';
    $this->load->view('tema/topo',$this->data);
  //$this->load->view('tema/rodape');
   
}

   public function imprimir_cotacao(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCotacao')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar Cotacao.');
            redirect(base_url());
        }
        //$idPedidoCotacao =  $this->input->get('idPedidoCotacao');
        //$dataInicial =  $this->input->get('dataInicial');
        $idEmitente =  $this->input->get('idEmitente');

        $contador=count($this->input->get('item'));

           
        $cont = 1;
        $itensimprimir = '';
        for($x=0;$x<$contador;$x++)
        {
                    
            $itensimprimir .= $this->input->get('item')[$x];
            if($cont < $contador)
            {
                $itensimprimir .= ",";
                
            }
            $cont ++;
        }


        $data['dados_emitente'] = $this->cotacao_model->getEmitente($this->input->get('idEmitente'));
        $this->data['custom_error'] = '';
        
        //$data['result'] = $this->cotacao_model->cotacaoCustom($idPedidoCotacao,$dataInicial,$idEmitente,$itensimprimir);
        $data['result'] = $this->pedidocompra_model->cotacaoCustom($idEmitente,$itensimprimir);

        $data1 = array(
            'idStatuscompras' => 2,
            'data_alteracao' => date('Y-m-d H:i:s')
        );  
        $this->pedidocompra_model->edit('distribuir_os', $data1, 'idDistribuir', 'in'.$itensimprimir);
    


        $this->load->helper('mpdf');
        echo $html = $this->load->view('suprimentos/imprimir/imprimir_cotacao',$data,true);
    
    }

    public function gerarCotacao(){
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $contador=count($this->input->post('idDistribuir_'));
        $val_cotacoes = 0;
        for($x=0;$x<$contador;$x++)
        {
            //$this->data['status_atual_valida'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->get('idDistribuir_')[$x]);                         
            $this->data_val['results'] = $this->pedidocompra_model->verificaos($this->input->post('idDistribuir_')[$x]);
            //print_r($this->data['results']); 
            foreach($this->data_val['results'] as $rs){
                //echo $rs->idDistribuir;
                //$idOc = $this->data['results']->idPedidoCompra;
                if(($rs->idStatuscompras != 1 &&  $rs->idStatuscompras != 6)|| !empty($rs->idPedidoCompra)){
                    $this->session->set_flashdata('error','Não foi possível gerar cotação, verifique se você não selecionou itens que não estão com o status de *Compra Solicitada* ou se já possuem *número de Ordem de Compra*.');
                    redirect(base_url() . 'index.php/suprimentos');
                }
            }
            
        }

        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCotacao')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar Cotacao.');
            redirect(base_url());
        }

        

        //------------------------
        
       
        if ($this->input->post('idDistribuir_')[0] < 1) {
            
            $this->session->set_flashdata('error','Selecione pelo menos um item!');
            if(!empty($this->uri->segment(3)))
            {
                redirect(base_url() . 'index.php/almoxarifado');
            }
            else{
                redirect(base_url() . 'index.php/suprimentos');
            }
                  
                  
        } elseif($val_cotacoes != 1) {


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
            
                    //verifica se esta reservado estoque
                    $this->data['status_atual'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->post('idDistribuir_')[$x]);
                        
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
                            'idStatuscompras' => '2',
                            'idUser_aguardandoOrc' => $this->session->userdata('idUsuarios')
                        );
                    }
                    $this->attDataAlteracao($this->input->post('idDistribuir_')[$x]);	 
                    
                    $this->cotacao_model->add('pedido_cotacaoitens', $data2, true);
                    $this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $this->input->post('idDistribuir_')[$x]);
                        
                }

                /*
                if(!empty($this->uri->segment(3)))
                {
                    redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$id);
                }
                else
                {
                    redirect(base_url() . 'index.php/suprimentos/visualizarimprimir/'.$id);
                }
                */
            }
            else {
                
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao gerar cotacao.</p></div>';
            }
        }
    }

    public function imprimir_cotacao2(){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $contador=count($this->input->get('idDistribuir_'));
        $val_cotacoes = 0;
        for($x=0;$x<$contador;$x++)
        {
            //$this->data['status_atual_valida'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->get('idDistribuir_')[$x]);                         
            $this->data_val['results'] = $this->pedidocompra_model->verificaos($this->input->get('idDistribuir_')[$x]);
            //print_r($this->data['results']); 
            
            
        }

        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCotacao')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar Cotacao.');
            redirect(base_url());
        }
        
        //------------------------

        $idPedidoCotacao =  $this->data_val['results'][0]->idPedidoCotacao;
        $dataInicial =  $this->input->get('dataInicial');
        $idEmitente =  $this->input->get('idEmitente');
    
        $contador=count($this->input->get('idDistribuir_'));
        
            
        $cont = 1;
        $itensimprimir = '';
        for($x=0;$x<$contador;$x++)
        {                    
            $itensimprimir .= $this->input->get('idDistribuir_')[$x];
            if($cont < $contador)
            {
                $itensimprimir .= ",";
            
            }
            $cont ++;
        }
     
     
        $data['dados_emitente'] = $this->cotacao_model->getEmitente($this->input->get('idEmitente'));
        $this->data['custom_error'] = '';
         
        $data['result'] = $this->cotacao_model->cotacaoCustom($idPedidoCotacao,$dataInicial,$idEmitente,$itensimprimir);
        
  
        $this->load->helper('mpdf');
        echo $html = $this->load->view('cotacao/imprimir/imprimir_cotacao',$data,true);
        
    }
    public function attDataAlteracao($idDistOS){
        $data3 = array('data_alteracao' => date('Y-m-d H:i:s'));
        $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistOS);
        
    }
    public function getDistribuir(){
        $resultado = $this->pedidocompra_model->pedidoCustom3($this->input->post('idDistribuir'));
        $json = array('result'=>true,'resultado'=>$resultado);
        echo json_encode($json);
    }
    public function cancelarItens(){
        $itens = $this->input->post('excluirDistribuir_');
        $statusCompras = $this->input->post('excluirStatuscompras_');
        echo("<script>console.log('E '". $statusCompras.");</script>");
        if(count($statusCompras)>0){
            foreach($statusCompras as $r){
                if($r == 6 || $r >= 5){
                    $this->session->set_flashdata('error','Você está tentando cancelar um item cancelado ou que já foi entregue.');
                    redirect(base_url(). 'index.php/suprimentos');
                    return;
                }
            }
        }
        
        if(count($itens)>0){
            foreach($itens as $r){
                $result = $this->pedidocompra_model->getIdsDisitribuir($r);
                if(!empty($result)){
                    if($result[0]->idCotacaoItens!=null){
                        $this->pedidocompra_model->delete('pedido_cotacaoitens','idCotacaoItens',$result[0]->idCotacaoItens);
                    }
                    if($result[0]->idPedidoCompraItens!=null){
                        $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$result[0]->idPedidoCompraItens);
                    }
                    if($result[0]->idDistribuir!=null){
                        $data1 = array('data_alteracao' => date('Y-m-d H:i:s'),'idStatuscompras'=>6);
                        $this->pedidocompra_model->edit('distribuir_os',$data1,'idDistribuir',$result[0]->idDistribuir);
                    }
                }
                //echo("<script>console.log(".json_encode($result).");</script>");
            }
        }
        $this->session->set_flashdata('success','Itens cancelados com sucesso.');
        redirect(base_url() . 'index.php/suprimentos');
    }
    public function alterarItens(){
        $btnGerar = $this->input->post('btnGerar');
        $btnAlterar = $this->input->post('btnAlterar');    

        if($btnGerar){
            $this->gerarNovoPedidoCompra();
        }else if($btnAlterar){
            $this->alterarItensPedidoCompra();
        }
    }
    public function alterarItensPedidoCompra(){
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
            $this->session->set_flashdata('error','Você não tem permissão para editar PC.');
            redirect(base_url());
        }
        $itens = $this->input->post('alterarDistribuir_');
        $statusCompras = $this->input->post('alterarStatuscompras_');
        if(count($statusCompras)>0){
            foreach($statusCompras as $r){
                if($r != 3 ){
                    $this->session->set_flashdata('error','É permitido alterar apenas os itens com status "Gerou Ordem de Compra".');
                    redirect(base_url(). 'index.php/suprimentos');
                    return;
                }
            }
        }
        $pedidoCompra = $this->input->post('idPedidoCompra_n');
        $objPedidoCompra = $this->pedidocompra_model->getdistribuidorByIdPedidoCompra($pedidoCompra);
        if(count($objPedidoCompra) == 0 || $this->input->post('idPedidoCompra_n') == ''){
            $this->session->set_flashdata('error','Informe o número válido do pedido!');
            redirect(base_url() . 'index.php/suprimentos');
        }
        //$verificarStatus = false
        foreach($objPedidoCompra as $c){
            if($c->etapa >=3){
                $this->session->set_flashdata('error','A ordem de compra de destino possuí itens que não está no status "Gerou ordem de compra"');
                redirect(base_url() . 'index.php/suprimentos');
            }
        }
        //$itemPedido = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $this->input->post('idPedidoCompraItens_'));
        foreach($itens as $c){
            $result = $this->pedidocompra_model->getIdsDisitribuir($c);
            $objPedidoCompraExistente = $this->pedidocompra_model->getdistribuidorByIdPedidoCompra($result[0]->idPedidoCompra);
            //verifica se a ordem de compra atual possuí itens nas etapas de aprovação e posteriores
            foreach($objPedidoCompraExistente as $d){
                if($d->etapa >=3){
                    $this->session->set_flashdata('error','A ordem de compra de atual possuí itens que não estão no status "Gerou ordem de compra"');
                    redirect(base_url() . 'index.php/suprimentos');
                }
            }
        }
        
        if(count($itens)>0){
            foreach($itens as $r){
                $result = $this->pedidocompra_model->getIdsDisitribuir($r);
                if(!empty($result)){
                    if($result[0]->idCotacaoItens!=null){
                        $data2 = array('idPedidoCompra' => $pedidoCompra);
                        $this->pedidocompra_model->edit('pedido_cotacaoitens',$data2,'idCotacaoItens',$result[0]->idCotacaoItens);
                    }
                    if($result[0]->idPedidoCompraItens!=null){
                        $data2 = array('idPedidoCompra' => $pedidoCompra);
                        $this->pedidocompra_model->edit('pedido_comprasitens',$data2,'idPedidoCompraItens',$result[0]->idPedidoCompraItens);
                    }
                    if($result[0]->idDistribuir!=null){
                        $data1 = array('data_alteracao' => date('Y-m-d H:i:s'));
                        $this->pedidocompra_model->edit('distribuir_os',$data1,'idDistribuir',$result[0]->idDistribuir);
                    }
                }
                //echo("<script>console.log(".json_encode($result).");</script>");
            }
        }
        $this->session->set_flashdata('success','Ordem de compra foi alterado com sucesso.');
        redirect(base_url() . 'index.php/suprimentos');
    }
public function gerarNovoPedidoCompra(){
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
            $this->session->set_flashdata('error','Você não tem permissão para editar PC.');
            redirect(base_url());
        }

        $itens = $this->input->post('alterarDistribuir_');
        $statusCompras = $this->input->post('alterarStatuscompras_');
        
        // 1. Validação de Status (Mantendo a permissão ampliada para evitar travas futuras)
        if(count($statusCompras)>0){
            foreach($statusCompras as $r){
                if($r != 3 && $r != 14 && $r != 18){
                    $this->session->set_flashdata('error','Apenas itens com status "Gerou Ordem de Compra", "Aprovado" ou "Aguardando Pagamento" podem gerar nova OC.');
                    redirect(base_url(). 'index.php/suprimentos');
                    return;
                }
            }
        }
		
        // 2. CORREÇÃO DO FORNECEDOR (Resolve o erro "Data truncated" / "Incorrect integer")
        $fornecedor_post = $this->input->post('idFornecedores');
        $idFornecedorFinal = NULL; 

        if (is_array($fornecedor_post)) {
            // Filtra o array para remover vazios e nulos
            $filtrado = array_filter($fornecedor_post, function($val) {
                return !empty($val) && $val !== 'null' && $val !== 0 && $val !== '0';
            });
            
            // Pega o primeiro ID válido encontrado (Ex: 4111)
            if (!empty($filtrado)) {
                $idFornecedorFinal = intval(reset($filtrado));
            }
        } else {
            if (!empty($fornecedor_post) && $fornecedor_post !== 'null' && $fornecedor_post != 0) {
                $idFornecedorFinal = intval($fornecedor_post);
            }
        }
 		
        $data1 = array(
            'data_cadastro' => date('Y-m-d H:i:s'),
            'idFornecedores' => $idFornecedorFinal 
		);
		
        // 3. Cria a Nova OC
        $novoPC = $this->pedidocompra_model->add('pedido_compras',$data1,true);
        
        if($novoPC=="" || $novoPC==null){
            $this->session->set_flashdata('error','Não foi possível criar uma nova ordem de compra.');
            redirect(base_url() . 'index.php/suprimentos');
        }

        // 4. Atualiza os Itens
        if(count($itens)>0){
            foreach($itens as $r){
                $result = $this->pedidocompra_model->getIdsDisitribuir($r);
                if(!empty($result)){
                    // Atualiza cotação
                    if($result[0]->idCotacaoItens!=null){
                        $data2 = array('idPedidoCompra' => $novoPC);
                        $this->pedidocompra_model->edit('pedido_cotacaoitens',$data2,'idCotacaoItens',$result[0]->idCotacaoItens);
                    }
                    
                    // CORREÇÃO DA DATA (Resolve o problema de separação visual na tela)
                    if($result[0]->idPedidoCompraItens!=null){
                        $data_compra_item = array(
                            'idPedidoCompra' => $novoPC,
                            'previsao_entrega' => NULL // <--- OBRIGATÓRIO: Reseta a data para agrupar os itens
                        );
                        $this->pedidocompra_model->edit('pedido_comprasitens',$data_compra_item,'idPedidoCompraItens',$result[0]->idPedidoCompraItens);
                    }
                    
                    // Atualiza distribuir_os
                    if($result[0]->idDistribuir!=null){
                        $data2 = array('data_alteracao' => date('Y-m-d H:i:s'));
                        $this->pedidocompra_model->edit('distribuir_os',$data2,'idDistribuir',$result[0]->idDistribuir);
                    }
                }
            }
        }
        $this->session->set_flashdata('success','Ordem de compra criada com sucesso. Os itens foram alterados para a nova ordem de compra: '.$novoPC);
        redirect(base_url() . 'index.php/suprimentos');
    }
	
    public function almoxarifado_compras(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vPedidocompraalmox')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar compras do almoxarifado.');
            redirect(base_url());
        }
        $this->data['entregue'] = "none";
        $this->data['solicitacao'] = "none";
        if($this->uri->segment(3)=='1'){
            $this->data['solicitacao'] = "block";
        }
        if($this->uri->segment(3)=='2'){
            $this->data['entregue'] = "block";
        }
        $this->load->model('almoxarifado_model');
        $this->load->model('orcamentos_model');		 
		$this->load->model('cotacao_model');		 
        $this->load->model('usuarios_model');	
        $config['base_url'] = base_url().'index.php/suprimentos/gerenciar/';
         
        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');		
        $this->data['dados_statuscompra2'] = $this->pedidocompra_model->getstatus_compra2('0');
        $this->data['dados_statuscondicao'] = $this->pedidocompra_model->getstatus_cond_pg('');
        $this->data['dados_depinsumos'] = $this->almoxarifado_model->getDepartamentoTipo('INSUMO');
        $this->data['dados_aguardandoarmazenamento'] = $this->almoxarifado_model->getAgArmazInicial();
        $idUser = $this->session->userdata('idUsuarios');
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        $this->data['dados_emitente2'] = $this->orcamentos_model->getEmitente2();
        if(count($getUserEmpresa)>0){
            $this->data['dados_emitente'] = $getUserEmpresa;
            $primeiro = true;
            $idOs = '';
            foreach($getUserEmpresa as $r){
                if($r->id=="1"){                
                    if($primeiro){
                        $idOs = "10,3,7";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",10,3,7";
                    }
                }
                if($r->id=="2"){
                    if($primeiro){
                        $idOs = "11,2";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",11,2";
                    }
                }
                if($r->id=="3"){
                    if($primeiro){
                        $idOs = "12,1";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",12,1";
                    }
                }
                if($r->id=="4"){
                    if($primeiro){
                        $idOs = "13,6";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",13,6";
                    }
                }
            }            
        }else{
            /*
            $getUserEmpresa = "";
            $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
            */
            $this->session->set_flashdata('error','Você não está vinculado à uma empresa.');
            redirect(base_url());
        }
        $this->data['dados_ultimascompras'] = $this->pedidocompra_model->ultimasComprasLIMIT10($idOs);
        $query_statuscompra = "";
		$idStatuscompras = $this->input->post('idStatuscompras');
		if(!empty($idStatuscompras))
		{
            $conteudo = $idStatuscompras;
            
            if($idStatuscompras == 'todos'){
                $query_statuscompra = "(1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23)";
            }else{
                $query_statuscompra = "(" . $idStatuscompras . ")";
            }

		    
            /*
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
        */
            //print_r($query_statuscompra); exit;
            
		}else{
            $query_statuscompra = "(1,2)";
        }
        
        if (!empty($idOs) || !empty($query_statuscompra)) {
           
            $this->data['results'] = $this->pedidocompra_model->getWhereLikeos($idOs,null,$query_statuscompra);
    
        }   
        
        
        $this->data['view'] = 'almoxarifado/almoxarifadocompras';
       	$this->load->view('tema/topo',$this->data);
    }
    public function gerarCotacaoAlmoxarifado(){
        $this->load->library('form_validation');        
        $this->load->model('almoxarifado_model');

        $this->data['custom_error'] = '';
        $contador=count($this->input->post('idDistribuir_'));
        $val_cotacoes = 0;
        if($contador<=0){
            $json = array("result"=>false,"msggg"=>"Não possuí itens selecionados");
            //redirect(base_url() . 'index.php/suprimentos');
            echo json_encode($json);
            return;
        }
        for($x=0;$x<$contador;$x++)
        {
            //$this->data['status_atual_valida'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->get('idDistribuir_')[$x]);                         
            $this->data_val['results'] = $this->pedidocompra_model->verificaos($this->input->post('idDistribuir_')[$x]);
            //print_r($this->data['results']); 
            foreach($this->data_val['results'] as $rs){
                //echo $rs->idDistribuir;
                //$idOc = $this->data['results']->idPedidoCompra;
                if(($rs->idStatuscompras != 1 &&  $rs->idStatuscompras != 6) || !empty($rs->idPedidoCompra)){
                    //$this->session->set_flashdata('error','Não foi possível gerar cotação, verifique se você não selecionou itens que não estão com o status de *Compra Solicitada* ou se já possuem *número de Ordem de Compra*.');
                    $json = array("result"=>false,"msggg"=>"Não foi possível gerar cotação, verifique se você não selecionou itens que não estão com o status de *Compra Solicitada* ou se já possuem *número de Ordem de Compra*.");
                    //redirect(base_url() . 'index.php/suprimentos');
                    echo json_encode($json);
                    return;
                }
            }
            
        }

        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCotacao')){
            //$this->session->set_flashdata('error','Você não tem permissão para visualizar Cotacao.');
            //redirect(base_url());
            $json = array("result"=>false,"msggg"=>"Você não tem permissão para visualizar Cotacao.");
            echo json_encode($json);
            return;
        }

        

        //------------------------
        
       
        if ($this->input->post('idDistribuir_')[0] < 1) {
            
            //$this->session->set_flashdata('error','Selecione pelo menos um item!');
            $json = array("result"=>false,"msggg"=>"Selecione pelo menos um item!");
            echo json_encode($json);
            return;
                  
                  
        } elseif($val_cotacoes != 1) {


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
            
                    //verifica se esta reservado estoque
                    $this->data['status_atual'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->post('idDistribuir_')[$x]);
                        
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
                            'idStatuscompras' => '2'
                        );
                    }
                    $cota = $this->cotacao_model->gettable('pedido_cotacaoitens','idDistribuir ='. $this->input->post('idDistribuir_')[$x]);
                    if(empty($cota)){
                        $this->attDataAlteracao($this->input->post('idDistribuir_')[$x]);                    
                        $this->cotacao_model->add('pedido_cotacaoitens', $data2, true);
                        $this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $this->input->post('idDistribuir_')[$x]);
                    }
                    
                    
                }
	
                $idUser = $this->session->userdata('idUsuarios');
                $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
                if(count($getUserEmpresa)>0){
                    $this->data['dados_emitente'] = $getUserEmpresa;
                    $primeiro = true;
                    $idOs = '';
                    foreach($getUserEmpresa as $r){
                        if($r->id=="1"){                
                            if($primeiro){
                                $idOs = "10";
                                $primeiro = false;
                            }else{
                                $idOs = $idOs.",10";
                            }
                        }
                        if($r->id=="2"){
                            if($primeiro){
                                $idOs = "11";
                                $primeiro = false;
                            }else{
                                $idOs = $idOs.",11";
                            }
                        }
                        if($r->id=="3"){
                            if($primeiro){
                                $idOs = "12";
                                $primeiro = false;
                            }else{
                                $idOs = $idOs.",12";
                            }
                        }
                    }
                }
                $query_statuscompra = "";
                $idStatuscompras = $this->input->post('idStatuscompras');
                if(!empty($idStatuscompras))
                {
                    $conteudo = $idStatuscompras;
                    
                    if($idStatuscompras == 'todos'){
                        $query_statuscompra = "(1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19,21,22,23)";
                    }else{
                        $query_statuscompra = "(" . $idStatuscompras . ")";
                    }
                }
                if (!empty($idOs) || !empty($query_statuscompra)) {           
                    $resultado = $this->pedidocompra_model->getWhereLikeos($idOs,null,$query_statuscompra);            
                } 
                
                $json = array("result"=>true,"msggg"=>"Cotação gerada com sucesso!","resultado"=>$resultado,"html"=>$this->imprimir_cotacao_almoxarifado());
                echo json_encode($json);
                return;
                /*
                if(!empty($this->uri->segment(3)))
                {
                    redirect(base_url() . 'index.php/almoxarifado/gerenciar/'.$id);
                }
                else
                {
                    redirect(base_url() . 'index.php/suprimentos/visualizarimprimir/'.$id);
                }
                */
            }
            else {
                
                //$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao gerar cotacao.</p></div>';
                $json = array("result"=>false,"msggg"=>"Ocorreu um erro ao gerar cotacao.");
                echo json_encode($json);
                return;
            }
        }
    }

    public function imprimir_cotacao_almoxarifado(){

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $contador=count($this->input->post('idDistribuir_'));
        $val_cotacoes = 0;
        for($x=0;$x<$contador;$x++)
        {
            $this->data['status_atual_valida'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->post('idDistribuir_')[$x]);                         
            $this->data_val['results'] = $this->pedidocompra_model->verificaos($this->input->post('idDistribuir_')[$x]);
            //print_r($this->data['results']); 
            
            
        }

        /*
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCotacao')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar Cotacao.');
            redirect(base_url());
        }*/
        
        //------------------------

        $idPedidoCotacao =  $this->data_val['results'][0]->idPedidoCotacao;
        $dataInicial =  date('d-m-Y');//$this->input->get('dataInicial');
        if($this->data['status_atual_valida']->idOs==10){
            $idEmitente =  1;
        }
        if($this->data['status_atual_valida']->idOs==11){
            $idEmitente =  2;
        }
        if($this->data['status_atual_valida']->idOs==12){
            $idEmitente =  3;
        }
       
    
        $contador=count($this->input->post('idDistribuir_'));
        
            
        $cont = 1;
        $itensimprimir = '';
        for($x=0;$x<$contador;$x++)
        {                    
            $itensimprimir .= $this->input->post('idDistribuir_')[$x];
            if($cont < $contador)
            {
                $itensimprimir .= ",";
            
            }
            $cont ++;
        }
     
     
        $data['dados_emitente'] = $this->cotacao_model->getEmitente($idEmitente);
        $this->data['custom_error'] = '';
         
        $data['result'] = $this->cotacao_model->cotacaoCustom($idPedidoCotacao,$dataInicial,$idEmitente,$itensimprimir);
        
  
        $this->load->helper('mpdf');
        return $html = $this->load->view('cotacao/imprimir/imprimir_cotacao',$data,true);
        
    }
    public function gerarOrdemCompraAlmoxarifado(){
         //$contador=count($this->input->post('idCotacaoItens_'));
         if ($this->input->post('idDistribuir_')[0] < 1) {
            
            //$this->session->set_flashdata('error','Nenhum item selecionado!');
            //    redirect(base_url() . 'index.php/suprimentos');
            $json = array("result"=>false,"msggg"=>"Nenhum item selecionado!");
            echo json_encode($json);
            return;
                
        }
        
        $contador=count($this->input->post('idDistribuir_'));

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aPedCompra')){
            //$this->session->set_flashdata('error','Você não tem permissão para adicionar pedido.');
            //redirect(base_url());
            $json = array("result"=>false,"msggg"=>"Você não tem permissão para adicionar pedido.");
            echo json_encode($json);
            return;
        }
        //$this->load->model('orcamentos_model');
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        /*
        for($x=0;$x<$contador;$x++)
        {
            if($this->input->post('idStatuscompras_')[$x] != 2 ){
                $this->session->set_flashdata('error','Você só pode gerar ordem de compra de itens que estão *Aguardando Orçamento* e não possuem *número de Ordem de Compra*!');
                redirect(base_url() . 'index.php/suprimentos');
            }

        }*/
        for($x=0;$x<$contador;$x++)
        {
            //$this->data['status_atual_valida'] = $this->cotacao_model->gettable('distribuir_os','idDistribuir ='. $this->input->get('idDistribuir_')[$x]);                        
            $this->data_val['results'] = $this->pedidocompra_model->verificaos($this->input->post('idDistribuir_')[$x]);
           
            foreach($this->data_val['results'] as $rs){
                if(($rs->idStatuscompras != 2 && $rs->idStatuscompras != 6) || !empty($rs->idPedidoCompra)){
                    //$this->session->set_flashdata('error','Você só pode gerar ordem de compra de itens que estão *Aguardando Orçamento ou Cancelados* e não possuem *número de Ordem de Compra*!');
                    //redirect(base_url() . 'index.php/suprimentos');
                    $json = array("result"=>false,"msggg"=>"Você só pode gerar ordem de compra de itens que estão *Aguardando Orçamento ou Cancelados* e não possuem *número de Ordem de Compra*!");
                    echo json_encode($json);
                    return;
                }
            }
            
        }            

        if ($this->input->post('idDistribuir_')[0] < 1) {
            
            //$this->session->set_flashdata('error','Selecione pelo menos um item!');
            //redirect(base_url() . 'index.php/suprimentos');
            $json = array("result"=>false,"msggg"=>"Selecione pelo menos um item!");
            echo json_encode($json);
            return;
                
        } else {



            $data = array(
                            'data_cadastro' => date('Y-m-d H:i:s')
                        );               



            if (is_numeric($id = $this->pedidocompra_model->add('pedido_compras', $data, true)) ) {

                $total=0;

                for($x=0;$x<$contador;$x++)
                {

                    $this->data['dadoscot'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idDistribuir ='. $this->input->post('idDistribuir_')[$x]);
                
                    $distri = $this->data['dadoscot']->idDistribuir;
                    
                    $data2 = array(
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'idCotacaoItens' => $this->data['dadoscot']->idCotacaoItens,
                    
                        'idPedidoCompra' => $id
                    );   
                    
                                            

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
                
                    $this->attDataAlteracao($distri);	
                
                    $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $distri);
                        
                    $this->pedidocompra_model->edit('pedido_cotacaoitens', $data5, 'idDistribuir', $this->input->post('idDistribuir_')[$x]);
                    
                    
                }
                $idsDistribuirPar = $this->input->post('idDistribuir_');
                $exibirsuprimentos = $this->exibirsuprimentoseditadosAlmoxarifado($idsDistribuirPar);
                $dados_statuscompra = $this->pedidocompra_model->getstatus_compra2('0');
                $dados_statusgrupo = $this->pedidocompra_model->getstatus_grupo('');
                $dados_statuscondicao = $this->pedidocompra_model->getstatus_cond_pg('');

                //$this->session->set_flashdata('success','Pedido gerado com sucesso!');
                $json = array("result"=>true,
                    "msggg"=>"Pedido gerado com sucesso!",
                    "resultado"=>$this->getListDistribuirOs(),
                    "suprimentosEditado"=>$exibirsuprimentos);
                echo json_encode($json);
                return;
                //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$id);
                
                //$this->exibirsuprimentoseditados($idsDistribuirPar);
        
            }
            else {
                $json = array("result"=>false,"msggg"=>"Ocorreu um erro ao gerar pedido.");
                echo json_encode($json);
                return;
                //$this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao gerar pedido.</p></div>';
            }
        }
        
    }
    public function getListDistribuirOs2(){
        $json = array("result"=>true,"resultado"=>$this->getListDistribuirOs());
        echo json_encode($json);
    }
    public function getListDistribuirOs($gamb = ''){
        $this->load->model('almoxarifado_model');

        $idUser = $this->session->userdata('idUsuarios');
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        if(count($getUserEmpresa)>0){
            $this->data['dados_emitente'] = $getUserEmpresa;
            $primeiro = true;
            $idOs = '';
            foreach($getUserEmpresa as $r){
                if($r->id=="1"){                
                    if($primeiro){
                        $idOs = "10";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",10";
                    }
                }
                if($r->id=="2"){
                    if($primeiro){
                        $idOs = "11";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",11";
                    }
                }
                if($r->id=="3"){
                    if($primeiro){
                        $idOs = "12";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",12";
                    }
                }
            }
        }
        $query_statuscompra = "";
        if(!empty($gamb)){
            $idStatuscompras = 'todos';
        }else{
            $idStatuscompras = $this->input->post('idStatuscompras');
        }
        
        if(!empty($idStatuscompras))
        {
            $conteudo = $idStatuscompras;
            
            if($idStatuscompras == 'todos'){
                $query_statuscompra = "(1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23)";
            }else{
                $query_statuscompra = "(1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23)";
            }
        }
        if (!empty($idOs) || !empty($query_statuscompra)) {
   
            $resultado = $this->pedidocompra_model->getWhereLikeos($idOs,null,$query_statuscompra);
    
        }
        return $resultado;
    }

    public function exibirsuprimentoseditadosAlmoxarifado($idsDistribuirPar,$data = null){
    
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
            $this->session->set_flashdata('error','Você não tem permissão para editar Pedido de compra.');
            redirect(base_url());
         }
         $this->session->set_flashdata('success','Pedido salvo com sucesso.');
         //$contador = count($this->input->post('idStatuscompras_'));
          
 
         $this->load->library('table');
         $this->load->library('pagination');
          
         $this->load->model('os_model');
         $this->load->model('orcamentos_model');		 
         $this->load->model('cotacao_model');		 
          
         $config['base_url'] = base_url().'index.php/suprimentos/editarpedido/';
 
         //trazer maior q  3 o status        
         //$this->data['dados_statuscompra'] = $this->pedidocompra_model->getstatus_compra2('0');
         //$this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
         //$this->data['dados_statuscondicao'] = $this->pedidocompra_model->getstatus_cond_pg('');
         //$this->data['dadosFiltros'] = $data;
          
 
         if($this->input->post('idDistribuir_')){
             $idsDistribuir = $this->input->post('idDistribuir_');
         }elseif(!empty($idsDistribuirPar)){
             $idsDistribuir = $idsDistribuirPar;
         }
         

      
         //print_r($idsDistribuir); exit;
 
         $idPedidoCompra = $this->uri->segment(3);
         // echo  $rrrr = $this->uri->segment(5);
         if(!empty($this->uri->segment(4)))
         {	
                      
             $statuscompra = $this->uri->segment(4);
         }
         else
         {
             $statuscompra = '';
         }	
         
         $this->data['results'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'',$statuscompra);
         //$this->data['resultsnf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'1',$statuscompra);
         //$this->data['resultsosf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'2',$statuscompra);
          
         /* $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
          $this->data['dados_motivo'] = $this->orcamentos_model->getmotivo();
          $this->data['dados_clientes'] = $this->orcamentos_model->getCliente();
          $this->data['dados_vendedor']= $this->orcamentos_model->getVendedor();
          $this->data['dados_gerente'] = $this->orcamentos_model->getGerente();
          $this->data['dados_statusorcamento'] = $this->orcamentos_model->getStatusOrcamento();
          $this->data['dados_gruposervico'] = $this->orcamentos_model->getGrupoServico();
          $this->data['dados_natoperacao'] = $this->orcamentos_model->getNatOperacao();
         */
          
         return $this->data['results'];
         /*$this->data['results'] = $this->os_model->get('os','idOs,dataInicial,dataFinal,garantia,descricaoProduto,defeito,status,observacoes,laudoTecnico','',$config['per_page'],$this->uri->segment(3));*/
    
        //$this->data['view'] = 'suprimentos/editarpedido';
        
       // $this->load->view('tema/topo',$this->data);
         //$this->load->view('tema/rodape');
    }

    function editarpedidosuprimentosalmoxarifado($idsDistribuirPar = array()){
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
           //$this->session->set_flashdata('error','Você não tem permissão para editar Pedido de compra.');
           //redirect(base_url());
            $json = array("result"=>false,"msggg"=>"Você não tem permissão para editar Pedido de compra.");
            echo json_encode($json);
            return;

        }
        /*
        $contador = count($this->input->post('idStatuscompras_'));
        for($x=0;$x<$contador;$x++)
        {
            if($this->input->post('idStatuscompras_')[$x] < 3 ){
                //$this->session->set_flashdata('error','Verifique o(s) statu(s) da(s) Ordem(ns) de Compra(s) que está tentando visualizar!');
                //redirect(base_url() . 'index.php/suprimentos');
                $json = array("result"=>false,"msggg"=>"Verifique o(s) statu(s) da(s) Ordem(ns) de Compra(s) que está tentando visualizar!");
                echo json_encode($json);
                return;
            }

        }*/


        $this->load->library('table');
        $this->load->library('pagination');
         
        $this->load->model('os_model');
		$this->load->model('orcamentos_model');		 
		$this->load->model('cotacao_model');		 
         
        $config['base_url'] = base_url().'index.php/suprimentos/editarpedido/';

        //trazer maior q  3 o status        
        $this->data['dados_statuscompra'] = $this->pedidocompra_model->getstatus_compra2('0');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');
        $this->data['dados_statuscondicao'] = $this->pedidocompra_model->getstatus_cond_pg('');

        $this->data['dadosFiltros'] = $this->input->post();
		 

        if($this->input->post('idDistribuir_')){
            $idsDistribuir = $this->input->post('idDistribuir_');
        }elseif(!empty($idsDistribuirPar)){
            $idsDistribuir = $idsDistribuirPar;
        }

    
        if ($this->input->post('idDistribuir_')[0] < 1) {
            
            //$this->session->set_flashdata('error','Selecione pelo menos um item!');
            $json = array("result"=>false,"msggg"=>"Selecione pelo menos um item!");
                echo json_encode($json);
                return;

        } 

        //print_r($idsDistribuir); exit;

           

        $idPedidoCompra = $this->uri->segment(3);
        // echo  $rrrr = $this->uri->segment(5);
		if(!empty($this->uri->segment(4)))
		{	
					 
			$statuscompra = $this->uri->segment(4);
		}
		else
		{
			$statuscompra = '';
		}	
		
		$resultado = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'',$statuscompra);
        $json = array("result"=>true,"resultado"=>$resultado);
        echo json_encode($json);
		//$this->data['resultsnf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'1',$statuscompra);
		//$this->data['resultsosf'] = $this->pedidocompra_model->getpedidocomprafornece2($idsDistribuir,'2',$statuscompra);
         
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
       
	    //$this->data['view'] = 'suprimentos/editarpedido';
       	//$this->load->view('tema/topo',$this->data);
        //$this->load->view('tema/rodape');
		
    }

    public function salvaritemcompraalmoxarifado(){
        
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){

          //$this->session->set_flashdata('error','Você não tem permissão para editar item.');
          //redirect(base_url());
            $json = array("result"=>false,"msggg"=>"Você não tem permissão para editar item.");
            echo json_encode($json);
            return;
        }
        $button = $this->input->post('button');
        if($button == "alterar"){
            $this->editarpedidocompraalmoxarifado();
            return;
        }
		$this->load->model('cotacao_model');
		$this->load->model('estoque_model');
		
	    $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		
		$contador=count($this->input->post('idPedidoCompraItens'));

        $this->data['dadosFiltros'] = $this->input->post();

		$idsDistribuirPar = $this->input->post('idDistribuir');
        for($x=0;$x<$contador;$x++){
            if($this->input->post('idStatuscompras')[$x] == 5 && $this->input->post('qtdrecebida')[$x] <= 0){
                $json = array("result"=>false,"msggg"=>"Quantidade recebida não pode ser igual a 0.'");
                echo json_encode($json);
                return;
            }
            if(!empty($this->input->post('dataentregue')[$x]))
            {
                
                $dataentregue[$x] = explode('/', $this->input->post('dataentregue')[$x]);
                    $dataentregue[$x] = $dataentregue[$x][2].'-'.$dataentregue[$x][1].'-'.$dataentregue[$x][0];
                // $datafinal = $dataentregue." ".date("H:i:s");
                    //$datafinal = date("Y-m-d H:i:s");
                //echo $this->input->post('horaentregue')[$x];
                
            }else if($this->input->post('idStatuscompras')[$x] == 5){
                $json = array("result"=>false,"msggg"=>"Não é possivel alterar o status para 'Material Entregue' se a 'Data Entregue' estiver vazia.");
                echo json_encode($json);
                return;
            }	
        }
        for($x=0;$x<$contador;$x++)
        {
					
				
            		
				
			
            $valor_unitario = str_replace(".","",$this->input->post('valor_unitario')[$x]);
            $valor_unitario = str_replace(",",".",$valor_unitario);
            
            $ipi_valor = str_replace(".","",$this->input->post('ipi_valor')[$x]);
            $ipi_valor = str_replace(",",".",$ipi_valor);
            
            $valor_produtos = str_replace(".","",$this->input->post('valor_produtos')[$x]);
            $valor_produtos = str_replace(",",".",$valor_produtos);

            $valor_icms = str_replace(".","",$this->input->post('valor_icms')[$x]);
            $valor_icms = str_replace(",",".",$valor_icms);
            
            if(!empty($this->input->post('dataentregue')[$x]))
            {	
			
                $data2 = array(
                    'quantidade' => $this->input->post('qtdrecebida')[$x],
                    'id_status_grupo' => $this->input->post('idgrupo')[$x],
                    'datastatusentregue' => $dataentregue[$x],
                    'valor_unitario' => $valor_unitario,
                    'ipi_valor' => $ipi_valor,
                    'valor_total' => $valor_produtos,
                    'icms' => $valor_icms      
                );
            
			
			}
			else
			{
                $data2 = array(
                    'quantidade' => $this->input->post('qtdrecebida')[$x],
                    'id_status_grupo' => $this->input->post('idgrupo')[$x],

                    'valor_unitario' => $valor_unitario,
                    'ipi_valor' => $ipi_valor,
                    'valor_total' => $valor_produtos,
                    'icms' => $valor_icms         
                );
			}
			
			
            $this->pedidocompra_model->edit('pedido_comprasitens', $data2, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens')[$x]);	
				
				
            $data3 = array(
                            'idStatuscompras' => $this->input->post('idStatuscompras')[$x]
                        );



            $this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->input->post('idCotacaoItens')[$x]);
			 
            $idDistribuir =  $this->data['dadosped2']->idDistribuir;
                    
            
		
			$this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
				
			//se a qtd recebida for menor q a solicitada, vai abrir outro item de compra
			$this->data['dadosped3'] = $this->pedidocompra_model->gettable('distribuir_os','idDistribuir ='. $idDistribuir);
			if($this->input->post('qtdrecebida')[$x] > 0)
			{
				if($this->input->post('qtdrecebida')[$x] < $this->data['dadosped3']->quantidade )
				{
					$qtd_nova =   $this->data['dadosped3']->quantidade - $this->input->post('qtdrecebida')[$x];
					
					//add nova item
					
                    $data55 = array(
                        'idInsumos' => $this->data['dadosped3']->idInsumos,
                        'dimensoes' => $this->data['dadosped3']->dimensoes,
                        'solicitacao' => $this->data['dadosped3']->solicitacao,
                        'id_status_grupo' => $this->data['dadosped3']->id_status_grupo,
                        'idProdutos' => $this->data['dadosped3']->idProdutos,
                        'metrica' => $this->data['dadosped3']->metrica,
                        'volume' => $this->data['dadosped3']->volume,
                        'peso' => $this->data['dadosped3']->peso,                        
                        'comprimento' => $this->data['dadosped3']->comprimento,
                        'dimensoesL' => $this->data['dadosped3']->dimensoesL,
                        'dimensoesC' => $this->data['dadosped3']->dimensoesC,
                        'dimensoesA' => $this->data['dadosped3']->dimensoesA,
                        'data_cadastro' => $this->data['dadosped3']->data_cadastro,
                        'obs' => $this->data['dadosped3']->obs,
                        'histo_alteracao' => $this->data['dadosped3']->histo_alteracao,
                        'idStatuscompras' => 4,
                        'usuario_cadastro' => $this->data['dadosped3']->usuario_cadastro,
                        'quantidade' => $qtd_nova,
                        'idOs' => $this->data['dadosped3']->idOs
                    );
                    $id_pci = $this->pedidocompra_model->add('distribuir_os', $data55, true);

                    $idsDistribuirPar[] = $id_pci;
                    
                    $data3_ = array(
                    
                        'quantidade' => $this->input->post('qtdrecebida')[$x]
                    
                    );
			
                    //update na tb
                    $this->pedidocompra_model->edit('distribuir_os', $data3_, 'idDistribuir', $idDistribuir);
                    $this->attDataAlteracao($idDistribuir);
                    $data4 = array(
                    
                        'id_distribuir' => $idDistribuir,
                        'data_cadastro' => date('Y-m-d H:i:s'),
                        'quantidade' => $this->data['dadosped3']->quantidade
                    
                    );
			
                    $this->pedidocompra_model->add('distribuir_os_hist', $data4, true);
                    
                    
                    $dataco = array(
                            'data_cadastro' => $this->data['dadosped2']->data_cadastro,
                            'idDistribuir' => $id_pci,
                            'idPedidoCotacao' => $this->data['dadosped2']->idPedidoCotacao,
                            'idPedidoCompra' => $this->data['dadosped2']->idPedidoCompra
                            
                        
                    );
			        $cot = $this->pedidocompra_model->add('pedido_cotacaoitens', $dataco, true);
			
			        //aqui calcula valor total		
			
			
                    $this->data['dados_'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idCotacaoItens ='. $this->input->post('idCotacaoItens')[$x]);
                    
                    $valor_total_calc = $this->data['dados_']->valor_unitario * $this->input->post('qtdrecebida')[$x];
                    if($this->data['dados_']->ipi_valor <> 0.00)
                    {
                        $calc = ($this->data['dados_']->ipi_valor) / 100 * $valor_total_calc;
                        $valor_total_calc = $valor_total_calc + $calc;
                    }
			
			
                    $data__ = array(
                    
                        'valor_total' => $valor_total_calc
                    
                    );
                    $this->pedidocompra_model->edit('pedido_comprasitens', $data__, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItens')[$x]);	
                    
                    $valor_total_calc2 = $this->data['dados_']->valor_unitario * $qtd_nova;
                    if($this->data['dados_']->ipi_valor <> 0.00)
                    {
                        $calc = ($this->data['dados_']->ipi_valor) / 100 * $valor_total_calc2;
                        $valor_total_calc2 = $valor_total_calc2 + $calc;
                    }
					
                    $dataAtualMais1 = new DateTime();
                    $dataAtualMais1->modify('+1 day');                    
                    
                    $datacom = array(
                        'data_cadastro' => $this->data['dados_']->data_cadastro,
                        'idPedidoCompra' => $this->data['dados_']->idPedidoCompra,
                        'idCotacaoItens' => $cot,
                        'valor_unitario' => $this->data['dados_']->valor_unitario,
                        'ipi_valor' => $this->data['dados_']->ipi_valor,
                        'valor_total' => $valor_total_calc2,
                        'previsao_entrega' => $dataAtualMais1->format('Y-m-d'),                        

                        
                        'id_status_grupo' => $this->data['dados_']->id_status_grupo,
                        'idCondPgto' => $this->data['dados_']->idCondPgto,
                        'cod_pgto' => $this->data['dados_']->cod_pgto,
                        'icms' => $this->data['dados_']->icms
            				
                    );

                    $compraitem = $this->pedidocompra_model->add('pedido_comprasitens', $datacom, true);
                    
                    $datadd = array(
                    
                        'idPedidoCompraItens' => $compraitem
                    
                    );
                    
                    //update na tb
                    $this->pedidocompra_model->edit('pedido_cotacaoitens', $datadd, 'idCotacaoItens', $cot);
                    
                    
                    //$this->session->set_flashdata('success','Foi gerada novo item.');	
                    
				}
                
			}

            //Exclui pedido de compra e permite nova ordem de compra caso o status mude para Compra solicitada ou Aguardando Orçamento
            $data56 = array(
                'idPedidoCompra' => NULL,
                'idPedidoCompraItens' => NULL
            );
            if($this->input->post('idStatuscompras')[$x] == 1){
                //$this->pedidocompra_model->delete('pedido_compras','idPedidoCompra',$idPedidoCompra);
                $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$this->input->post('idPedidoCompraItens')[$x]);
                //$this->cotacao_model->delete('pedido_cotacao','idPedidoCotacao',$idPedidoCotacao); 
                $this->cotacao_model->delete('pedido_cotacaoitens','idCotacaoItens',$this->input->post('idCotacaoItens')[$x]);                
            }elseif($this->input->post('idStatuscompras')[$x] == 2){
                $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$this->input->post('idPedidoCompraItens')[$x]);
                $this->cotacao_model->edit('pedido_cotacaoitens', $data56, 'idCotacaoItens', $this->input->post('idCotacaoItens')[$x]);
            }
            $redireciona = 'editarPedido';
            if($contador <= 1 && ($this->input->post('idStatuscompras')[$x] == 1 || $this->input->post('idStatuscompras')[$x] == 2)){
                $redireciona = 'filtrosSuprimentos';
            }

            $ok = false;
            if(empty($valor_unitario)){
                $valor_unitario = 0;
            }
            if($this->input->post('idStatuscompras')[$x] == 5 && $this->input->post('qtdrecebida')[$x] > 0 && ($this->data['dadosped3']->idOs == 10 || $this->data['dadosped3']->idOs == 11 || $this->data['dadosped3']->idOs == 12)){
                $ok = true;
                if($this->data['dadosped3']->idOs == 10){
                    $idEmitente3 = 1;
                }else if($this->data['dadosped3']->idOs == 11){
                    $idEmitente3 = 2;
                }else if($this->data['dadosped3']->idOs == 12){
                    $idEmitente3 = 3;
                }
                $dataAgArmaz = array(
                    'idStatusAgArmaz'=>2,
                    'idDistribuirOs'=>$this->input->post('idDistribuir')[$x],
                    'valorUnitario'=>$valor_unitario,
                    'idUsuario'=>$this->session->userdata('idUsuarios'),
                    'idInsumo'=>$this->data['dadosped3']->idInsumos,
                    'idEmitente'=>$idEmitente3,
                    'metrica'=>'0',
                    'quantidade'=>$this->input->post('qtdrecebida')[$x],
                    'idOrdemCompra'=>$this->data['dadosped2']->idPedidoCompra,
                    'data_entregue'=>$dataentregue[$x]
                );
                $this->load->model('almoxarifado_model','',TRUE);
                $result = $this->almoxarifado_model->getAgArmaz($this->input->post('idDistribuir')[$x]);
                if(empty($result)){
                    $this->almoxarifado_model->insertAgArmaz($dataAgArmaz);
                }
                
            }


            
            
				
        }//final do for 
        
        
        //$this->session->set_flashdata('success','Pedido salvo com sucesso.');
        //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$this->input->post('idPedidoCompra'));
        /*if($redireciona == 'editarPedido'){            
            $this->exibirsuprimentoseditadosAlmoxarifado($idsDistribuirPar,$this->data['dadosFiltros']);
        }else{
            redirect(base_url() . 'index.php/suprimentos');
        }*/

        
        $json = array("result"=>true,"msggg"=>"Pedido salvo com sucesso.","resultado"=>$this->getListDistribuirOs(1),'ok'=>$ok);
        echo json_encode($json);
        return;	
        
         	
	}

    function editarpedidocompraalmoxarifado(){		
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
          //$this->session->set_flashdata('error','Você não tem permissão para editar PC.');
          //redirect(base_url());
            $json = array("result"=>false,"msggg"=>"Você não tem permissão para editar PC.");
            echo json_encode($json);
            return;
        }
		//$this->load->model('orcamentos_model');
		$this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $idPedidoCompraItens = "";
        $idPedidoCompraItens = $this->input->post('idPedidoCompraItens');
        //echo("<script>console.log('List'".implode(",",$idDistribuirOS).");</script>");
        
  
        $idPedidoCompra= $this->input->post('idPedidoCompra');
    
    
        if($this->input->post('fornecedor_id') <> '')
        {
            $fornecedor_id = $this->input->post('fornecedor_id');
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
        $frete = str_replace(".","",$this->input->post('freteit'));
        $frete = str_replace(",",".",$frete);
        if($frete == '')
        {
            $frete = '0.00';
        }/*
        $icms = str_replace(".","",$this->input->post('icmsit'));
        $icms = str_replace(",",".",$icms);
        if($icms == '')
        {
            $icms = '0.00';
        }*/
					
        $data3 = array(
                        'idFornecedores' => $fornecedor_id,
                        'idEmitente' => $emitente_id,
                        'frete' => $frete/*,
                        'icms' => $icms*/
                        
                    );
			
				
        $this->pedidocompra_model->edit('pedido_compras', $data3, 'idPedidoCompra', $idPedidoCompra);	

        //-------------------------------------------------------------------------------------------------
        
        //$contadoripi=count($idPedidoCompra);  		 		 
        
        $desconto = str_replace(".","",$this->input->post('descontoit'));
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
        $outros = str_replace(".","",$this->input->post('outrosit'));
        $outros = str_replace(",",".",$outros);
        if($outros == '')
        {
            $outros = '0.00';
        }
        

        if($this->input->post('previsao_entrega') <> '')
        {
            $previsao_entrega = explode('/', $this->input->post('previsao_entrega'));
        $previsao_entrega = $previsao_entrega[2].'-'.$previsao_entrega[1].'-'.$previsao_entrega[0];		
        }
        else{
            $previsao_entrega = null;
        }
        if($this->input->post('idCondPgto') <> '')
        {
            $idCondPgto = $this->input->post('idCondPgto');
        }
        else
        {
            $idCondPgto = null;
        }
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

        if(!empty($this->input->post('datanf')))
        {
            $datanf = explode('/', $this->input->post('datanf'));
        $datanf = $datanf[2].'-'.$datanf[1].'-'.$datanf[0];	
        }
        else
        {
            $datanf = null;
        }

        if(!empty($this->input->post('nf')))
        {
            $nf = $this->input->post('nf');
        }
        else
        {
            $nf = null;
        }


					
		$idPedidoCompraipi	= $this->input->post('idPedidoCompraipi');	
        if( !empty($previsao_entrega))
        {
            $data3 = array('previsao_entrega' => $previsao_entrega );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);  
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        if( !empty($prazo_entrega))
        {
            $data3 = array('prazo_entrega' => $prazo_entrega );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }
        if( !empty($idCondPgto))
        {
            $data3 = array('idCondPgto' => $idCondPgto );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS); 
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        if( !empty($cod_pgto))
        {
            $data3 = array('cod_pgto' => $cod_pgto );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);  
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        if( !empty($obs))
        {
            $data3 = array('obs' => $obs );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
            
        }
        if( !empty($datanf))
        {
            $data3 = array('datanf' => $datanf );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);  
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        if( !empty($nf))
        {
            $data3 = array('notafiscal' => $nf );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);    
            }
            
            $this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);			 
            $idDistribuir =  $this->data['dadosped2']->idDistribuir;
            $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
            $this->attDataAlteracao($idDistribuir);
        }
        if( !empty($desconto))
        {
            $data3 = array('desconto' => $desconto );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS); 
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }
        if( !empty($outros))
        {
            $data3 = array('outros' => $outros );
            
            foreach($idPedidoCompraItens as $distrOS){
                $this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);    
            }
        }
        if( !empty($frete))
        {
            $data3 = array('frete' => $frete );
            
            foreach($idPedidoCompraItens as $distrOS){
                //$this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);  
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);  
            }
        }/*
        if( !empty($icms))
        {
            $data3 = array('icms' => $icms );
            
            foreach($idPedidoCompraItens as $distrOS){
                //$this->pedidocompra_model->edit('pedido_comprasitens', $data3, 'idPedidoCompraItens', $distrOS);
                $this->data['dados3'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $distrOS);
                $this->data['dados4'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $this->data['dados3']->idCotacaoItens);
                $this->attDataAlteracao($this->data['dados4']->idDistribuir);
            }
        }*/
        $json = array("result"=>true,"msggg"=>"Pedido alterado com sucesso!","resultado"=>$this->getListDistribuirOs());
        echo json_encode($json);
        return; 
            
        //$this->session->set_flashdata('success','Pedido alterado com sucesso!');
        //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra);
        $idsDistribuirPar = $this->input->post('idDistribuir_');
        //$this->exibirsuprimentoseditadosAlmoxarifado();      
	}

    function editar_1almoxarifado(){
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
          //$this->session->set_flashdata('error','Você não tem permissão para editar PC.');
          //redirect(base_url());
            $json = array("result"=>false,"msggg"=>"Você não tem permissão para editar PC.");
            echo json_encode($json);
            return;
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

  
        $id_item_pc1= $this->input->post('id_item_pc1');
        //$idPedidoCompra= $this->input->post('idPedidoCompra');
    
    
        $this->load->model('cotacao_model');	 
	
  
        if ($this->input->post('id_item_pc1') == '') {
            
			$json = array("result"=>false,"msggg"=>"Erro ao editar.");
            echo json_encode($json);
            return;
				
        } else {
			 
			 
            $data3 = array(
                        'liberado_edit_compras' => '1'
                    );
			
			
	        $this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $id_item_pc1);
			

	        //$this->session->set_flashdata('success','Item Liberado com sucesso!');
	
				//redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra);
                
                $json = array("result"=>true,"msggg"=>"Item Liberado com sucesso!");
                echo json_encode($json);
                return;
		}
		
	}
    function editar_0almoxarifado(){
		
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
            $json = array("result"=>false,"msggg"=>"Você não tem permissão para editar PC.");
            echo json_encode($json);
            return;
        }
		//$this->load->model('orcamentos_model');
		$this->load->library('form_validation');
        $this->data['custom_error'] = '';

  
        $id_item_pc2= $this->input->post('id_item_pc2');
        //$idPedidoCompra= $this->input->post('idPedidoCompra');
    
    
        $this->load->model('cotacao_model');	 
        
    
        if ($this->input->post('id_item_pc2') == '') {
            
            $this->session->set_flashdata('error','Erro ao editar!');
            $json = array("result"=>false,"msggg"=>"Erro ao editar!");
            echo json_encode($json);
            return;
            //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra);
                
        } else {
            $data3 = array(
                'liberado_edit_compras' => '0'
            );
        
        
            $this->cotacao_model->edit('distribuir_os', $data3, 'idDistribuir', $id_item_pc2);
                    

            //$this->session->set_flashdata('success','Item Liberado com sucesso!');
            $json = array("result"=>true,"msggg"=>"Item Travado com sucesso!");
            echo json_encode($json);
            return;

            //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra);
        
        }
		
		 
		
	}

    function editar_ipialmoxarifado(){

        $idsDistribuirPar = $this->input->post('idDistribuir_ipi');
		
        $contadoripi=count($this->input->post('idPedidoCompraItensipi'));  
    
        $valoripi = str_replace(".","",$this->input->post('valoripi'));  
        $valoripi = str_replace(",",".",$valoripi);

        if($this->input->post('dataentregue2')){
            $dataentregue2 = explode('/', $this->input->post('dataentregue2'));
            $dataentregue2 = $dataentregue2[2].'-'.$dataentregue2[1].'-'.$dataentregue2[0];	
        }
        


        $idStatuscompras2 = $this->input->post('idStatuscompras2');
					
		//$idPedidoCompraipi	= $this->input->post('idPedidoCompraipi');	
        $ok = false;
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
					/*if( !empty($this->input->post('datanf')) && !empty($this->input->post('nf')))
					{
						$data4 = array(
               
                'datanf' => $datanf,
                'notafiscal' => $nf
            );
			$this->pedidocompra_model->edit('pedido_comprasitens', $data4, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
					}*/
					if( !empty($this->input->post('idStatuscompras2')) )
					{
						$data4 = array(
               
                            'idStatuscompras' => $idStatuscompras2
                        );
                        $this->pedidocompra_model->edit('distribuir_os', $data4, 'idDistribuir', $dist);
                        $data56 = array(
                            'idPedidoCompra' => NULL,
                            'idPedidoCompraItens' => NULL
                        );
                        if($this->input->post('idStatuscompras2') == 1){
                            //$this->pedidocompra_model->delete('pedido_compras','idPedidoCompra',$idPedidoCompra);
                            $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$this->input->post('idPedidoCompraItensipi')[$x]);
                            //$this->cotacao_model->delete('pedido_cotacao','idPedidoCotacao',$idPedidoCotacao); 
                            $this->cotacao_model->delete('pedido_cotacaoitens','idCotacaoItens',$this->data['dist']->idCotacaoItens);                
                        }elseif($this->input->post('idStatuscompras2') == 2){
                            $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$this->input->post('idPedidoCompraItensipi')[$x]);
                            $this->cotacao_model->edit('pedido_cotacaoitens', $data56, 'idCotacaoItens', $this->data['dist']->idCotacaoItens);
                        }
                        $this->attDataAlteracao($dist);
					}
                    
                    if( !empty($this->input->post('nNotaFiscal2')) )
					{
                        
						$data5 = array(
               
                            'notafiscal' => $this->input->post('nNotaFiscal2')
                        );
                        //Id 5 para material recebido
                        /*$data6 = array(               
                            'idStatuscompras' => 5
                        );*/
                        
                        $this->pedidocompra_model->edit('pedido_comprasitens', $data5, 'idPedidoCompraItens', $this->input->post('idPedidoCompraItensipi')[$x]);
                        //$this->pedidocompra_model->edit('distribuir_os', $data6, 'idDistribuir', $dist);
                        $this->attDataAlteracao($dist);

                    
                    }
			
			
		}
        
        //$this->session->set_flashdata('success','Dados alterado com sucesso!');
        $json = array("result"=>true,"msggg"=>"Dados alterado com sucesso!","resultado"=>$this->getListDistribuirOs(),"nf"=>$ok);
        echo json_encode($json);
        return;
        //redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompraipi);
        //$this->exibirsuprimentoseditados($idsDistribuirPar);
	}

    function editarpcalmoxarifado(){
		
		
		if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
          //$this->session->set_flashdata('error','Você não tem permissão para editar PC.');
          //redirect(base_url());
          $json = array("result"=>false,"msggg"=>"Você não tem permissão para editar PC.");
            echo json_encode($json);
        }
		//$this->load->model('orcamentos_model');
		 $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $idPedidoCompraItens = $this->input->post('idPedidoCompraItens_');
        $idPedidoCompra_n= $this->input->post('idPedidoCompra_n');
   
  
		 
		
  
  
        if(count($this->pedidocompra_model->getqtditens($idPedidoCompra_n)) == 0 || $this->input->post('idPedidoCompra_n') == '') {
            
			//$this->session->set_flashdata('error','Informe o número válido do pedido!');
            //   redirect(base_url() . 'index.php/suprimentos');

            $json = array("result"=>false,"msggg"=>"Informe o número válido do pedido!");
            echo json_encode($json);
            return;
				
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
					
			$this->data['pedidoCotacaoID'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens = '.$idCotacaoItens);
            $this->attDataAlteracao($this->data['pedidoCotacaoID']->idDistribuir);
	        //$this->session->set_flashdata('success','Pedido alterado com sucesso!');
	
				//redirect(base_url() . 'index.php/suprimentos/editarpedido/'.$idPedidoCompra_n);
            $json = array("result"=>true,"msggg"=>"Pedido alterado com sucesso!","resultado"=>$this->getListDistribuirOs());
            echo json_encode($json);
            return;
			
		 }
		
		 
		
	}
    function excluir_itempedidoalmoxarifado(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dPedCompra')){
            //$this->session->set_flashdata('error','Você não tem permissão para excluir item pedido.');
           //redirect(base_url());
           $json = array("result"=>false,"msggg"=>"Você não tem permissão para excluir item pedido.");
            echo json_encode($json);
            return;
        }

        $idPedidoCompraItens =  $this->input->post('idPedidoCompraItens_nn');
        $excluirpedidocompra =  $this->input->post('todos');
    
        $this->data['dadosped'] = $this->pedidocompra_model->gettable('pedido_comprasitens','idPedidoCompraItens ='. $idPedidoCompraItens);
        
        $idCotacaoItens =  $this->data['dadosped']->idCotacaoItens;
        $idPedidoCompra =  $this->data['dadosped']->idPedidoCompra;
    
        $this->data['dadosped2'] = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idCotacaoItens ='. $idCotacaoItens);
            
        $idDistribuir =  $this->data['dadosped2']->idDistribuir;
        $idPedidoCotacao = $this->data['dadosped2']->idPedidoCotacao;
    
    
        if ($idCotacaoItens == null){

            //$this->session->set_flashdata('error','Erro ao tentar excluir item.'); 
            //redirect(base_url() . 'index.php/suprimentos/gerenciar/'.$idPedidoCompra);
            $json = array("result"=>false,"msggg"=>"Erro ao tentar excluir item.");
            echo json_encode($json);
            return;
            
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
        
            $this->attDataAlteracao($idDistribuir);
            $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir);
            $this->pedidocompra_model->edit('pedido_cotacaoitens', $data4, 'idCotacaoItens', $idCotacaoItens);
        
    
            if(count($this->pedidocompra_model->getqtditens($idPedidoCompra)) == 1)
            {
                $this->pedidocompra_model->delete('pedido_compras','idPedidoCompra',$idPedidoCompra);  
            }
            $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$idPedidoCompraItens);

            $this->pedidocompra_model->delete('pedido_cotacaoitens','idCotacaoItens',$idCotacaoItens);

            
            //$this->session->set_flashdata('success','Item excluido com sucesso do pedido!'); 
            $json = array("result"=>true,"msggg"=>"Item excluido com sucesso do pedido!","resultado"=>$this->getListDistribuirOs());
            echo json_encode($json);
            return;
    
        }
        else
        {
            $itenspc = $this->pedidocompra_model->gettable('pedido_cotacaoitens','idPedidoCompra ='. $idPedidoCompra,1);
            foreach ($itenspc as $r)
            {
                $idDistribuir2 =  $r->idDistribuir;
        
        
                $this->attDataAlteracao($idDistribuir2);
                $this->pedidocompra_model->edit('distribuir_os', $data3, 'idDistribuir', $idDistribuir2);
            }
            
            $this->pedidocompra_model->edit('pedido_cotacaoitens', $data4, 'idPedidoCompra', $idPedidoCompra);
            $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompra',$idPedidoCompra); 
            $this->pedidocompra_model->delete('pedido_compras','idPedidoCompra',$idPedidoCompra);
            $this->pedidocompra_model->delete('pedido_cotacaoitens','idPedidoCotacao',$idPedidoCotacao);
            //$this->session->set_flashdata('success','Pedido excluido com sucesso!'); 
            //redirect(base_url() . 'index.php/suprimentos');
            $json = array("result"=>true,"msggg"=>"Pedido excluido com sucesso!","resultado"=>$this->getListDistribuirOs());
            echo json_encode($json);
            return;
            
        }
	
        
                  
        
        

       
    }
    public function cancelarItensAlmoxarifado(){
        $itens = $this->input->post('excluirDistribuir_');
        $statusCompras = $this->input->post('excluirStatuscompras_');
        //echo("<script>console.log('E '". $statusCompras.");</script>");
        if(count($statusCompras)>0){
            foreach($statusCompras as $r){
                if($r == 6 || $r >= 5){
                   // $this->session->set_flashdata('error','Você está tentando cancelar um item cancelado ou que já foi entregue.');
                   // redirect(base_url(). 'index.php/suprimentos');
                    //return;
                    $json = array("result"=>false,"msggg"=>"Você está tentando cancelar um item cancelado ou que já foi entregue.");
                    echo json_encode($json);
                    return;
                }
            }
        }
        
        if(count($itens)>0){
            foreach($itens as $r){
                $result = $this->pedidocompra_model->getIdsDisitribuir($r);
                if(!empty($result)){
                    if($result[0]->idCotacaoItens!=null){
                        $this->pedidocompra_model->delete('pedido_cotacaoitens','idCotacaoItens',$result[0]->idCotacaoItens);
                    }
                    if($result[0]->idPedidoCompraItens!=null){
                        $this->pedidocompra_model->delete('pedido_comprasitens','idPedidoCompraItens',$result[0]->idPedidoCompraItens);
                    }
                    if($result[0]->idDistribuir!=null){
                        $data1 = array('data_alteracao' => date('Y-m-d H:i:s'),'idStatuscompras'=>6);
                        $this->pedidocompra_model->edit('distribuir_os',$data1,'idDistribuir',$result[0]->idDistribuir);
                    }
                }
                //echo("<script>console.log(".json_encode($result).");</script>");
            }
        }
        //$this->session->set_flashdata('success','Itens cancelados com sucesso.');
       // redirect(base_url() . 'index.php/suprimentos');
        $json = array("result"=>true,"msggg"=>"Itens cancelados com sucesso.","resultado"=>$this->getListDistribuirOs());
            echo json_encode($json);
            return;
    }

    public function alterarItensAlmoxarifado(){
        $button = $this->input->post('button');  

        if($button == 'gerar'){
            $this->gerarNovoPedidoCompraAlmoxarifado();
        }else if($button == 'alterar'){
            $this->alterarItensPedidoCompraAlmoxarifado();
        }
    }

    public function alterarItensPedidoCompraAlmoxarifado(){
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
            //$this->session->set_flashdata('error','Você não tem permissão para editar PC.');
            //redirect(base_url());
            $json = array("result"=>false,"msggg"=>"Você não tem permissão para editar PC.");
            echo json_encode($json);
            return;
        }
        $itens = $this->input->post('alterarDistribuir_');
        $statusCompras = $this->input->post('alterarStatuscompras_');
        if(count($statusCompras)>0){
            foreach($statusCompras as $r){
                if($r != 3 ){
                    //$this->session->set_flashdata('error','É permitido alterar apenas os itens com status "Gerou Ordem de Compra".');
                    //redirect(base_url(). 'index.php/suprimentos');
                    //return;
                    $json = array("result"=>false,"msggg"=>'É permitido alterar apenas os itens com status "Gerou Ordem de Compra".');
                    echo json_encode($json);
                    return;
                }
            }
        }
        $pedidoCompra = $this->input->post('idPedidoCompra_n');
        if(count($this->pedidocompra_model->getqtditens($pedidoCompra)) == 0 || $this->input->post('idPedidoCompra_n') == ''){
            //$this->session->set_flashdata('error','Informe o número válido do pedido!');
            //redirect(base_url() . 'index.php/suprimentos');
            $json = array("result"=>false,"msggg"=>'Informe o número válido do pedido!');
            echo json_encode($json);
            return;
        }
        if(count($itens)>0){
            foreach($itens as $r){
                $result = $this->pedidocompra_model->getIdsDisitribuir($r);
                if(!empty($result)){
                    if($result[0]->idCotacaoItens!=null){
                        $data2 = array('idPedidoCompra' => $pedidoCompra);
                        $this->pedidocompra_model->edit('pedido_cotacaoitens',$data2,'idCotacaoItens',$result[0]->idCotacaoItens);
                    }
                    if($result[0]->idPedidoCompraItens!=null){
                        $data2 = array('idPedidoCompra' => $pedidoCompra);
                        $this->pedidocompra_model->edit('pedido_comprasitens',$data2,'idPedidoCompraItens',$result[0]->idPedidoCompraItens);
                    }
                    if($result[0]->idDistribuir!=null){
                        $data1 = array('data_alteracao' => date('Y-m-d H:i:s'));
                        $this->pedidocompra_model->edit('distribuir_os',$data1,'idDistribuir',$result[0]->idDistribuir);
                    }
                }
                //echo("<script>console.log(".json_encode($result).");</script>");
            }
        }
        //$this->session->set_flashdata('success','Ordem de compra foi alterado com sucesso.');
        //redirect(base_url() . 'index.php/suprimentos');
        $json = array("result"=>true,"msggg"=>'Ordem de compra foi alterado com sucesso.',"resultado"=>$this->getListDistribuirOs());
        echo json_encode($json);
        return;
    }

    public function gerarNovoPedidoCompraAlmoxarifado(){
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'ePedCompra')){
            //$this->session->set_flashdata('error','Você não tem permissão para editar PC.');
            //redirect(base_url());
            $json = array("result"=>false,"msggg"=>'Você não tem permissão para editar PC.');
            echo json_encode($json);
            return;
        }
        $itens = $this->input->post('alterarDistribuir_');
        $statusCompras = $this->input->post('alterarStatuscompras_');
        if(count($statusCompras)>0){
            foreach($statusCompras as $r){
                if($r != 3 ){
                    //$this->session->set_flashdata('error','É permitido alterar apenas os itens com status "Gerou Ordem de Compra".');
                    //redirect(base_url(). 'index.php/suprimentos');
                    //return;
                    $json = array("result"=>false,"msggg"=>'É permitido alterar apenas os itens com status "Gerou Ordem de Compra".');
                    echo json_encode($json);
                    return;
                }
            }
        }
        $data1 = array('data_cadastro' => date('Y-m-d H:i:s'));
        $novoPC = $this->pedidocompra_model->add('pedido_compras',$data1,true);
        if($novoPC==""||$novoPC==null){
            //$this->session->set_flashdata('error','Não foi possível criar uma nova ordem de compra.');
            //redirect(base_url() . 'index.php/suprimentos');
            $json = array("result"=>false,"msggg"=>'Não foi possível criar uma nova ordem de compra.');
            echo json_encode($json);
            return;
        }
        if(count($itens)>0){
            foreach($itens as $r){
                $result = $this->pedidocompra_model->getIdsDisitribuir($r);
                if(!empty($result)){
                    if($result[0]->idCotacaoItens!=null){
                        $data2 = array('idPedidoCompra' => $novoPC);
                        $this->pedidocompra_model->edit('pedido_cotacaoitens',$data2,'idCotacaoItens',$result[0]->idCotacaoItens);
                    }
                    if($result[0]->idPedidoCompraItens!=null){
                        $data2 = array('idPedidoCompra' => $novoPC);
                        $this->pedidocompra_model->edit('pedido_comprasitens',$data2,'idPedidoCompraItens',$result[0]->idPedidoCompraItens);
                    }
                    if($result[0]->idDistribuir!=null){
                        $data2 = array('data_alteracao' => date('Y-m-d H:i:s'));
                        $this->pedidocompra_model->edit('distribuir_os',$data2,'idDistribuir',$result[0]->idDistribuir);
                    }
                }
                //echo("<script>console.log(".json_encode($result).");</script>");
            }
        }
        //$this->session->set_flashdata('success','Ordem de compra criada com sucesso. Os itens foram alterados para a nova ordem de compra: '.$novoPC);
        //redirect(base_url() . 'index.php/suprimentos');
        $json = array("result"=>true,"msggg"=>'Ordem de compra criada com sucesso. Os itens foram alterados para a nova ordem de compra: '.$novoPC,"resultado"=>$this->getListDistribuirOs() );
        echo json_encode($json);
        return;
        
    }
    public function permCompraAlmoxarifado(){
        $insumo = $this->input->post('insumo');
        $statusCheck = $this->input->post('statusCheck');
        $this->load->model('almoxarifado_model','',TRUE);
        $permCompra = $this->almoxarifado_model->getPermCompra($insumo,$statusCheck);
        if(!empty($permCompra)){
            if(gettype($permCompra) == 'array'){
                $idAlmoPermSupr = $permCompra[0]->idAlmoPermSupr;
            }else{
                $idAlmoPermSupr = $permCompra->idAlmoPermSupr;
            }
        }
        if($statusCheck == 'false'){
            $status = '0';
        }else{
            $status = '1';
        }
        if(!empty($idAlmoPermSupr)){
            $data = array(
                'data_cadastro'=> date('Y-m-d H:i:s'),
                'statusPermissao'=> $status,
                'idUserPerm'=> $this->session->userdata('idUsuarios')
            );
            $this->pedidocompra_model->edit('almo_permissao_suprimentos',$data,'idAlmoPermSupr',$idAlmoPermSupr);
        }else{
            $data = array(
                'data_cadastro'=> date('Y-m-d H:i:s'),
                'statusPermissao'=> $status,
                'idUserPerm'=> $this->session->userdata('idUsuarios'),
                'idInsumo'=> $insumo
            );
            $this->almoxarifado_model->addPermCompra($data);

        }
        $json = array("result"=>true,"msggg"=>'Foi');
        echo json_encode($json);
        return;

    }
    public function filtrarDistribuirOs(){
        $empresaNum1 = $this->input->post('empresaNum1');
        $empresaNum2 = $this->input->post('empresaNum2');
        if((!empty($empresaNum1) && empty($empresaNum2)) || (empty($empresaNum1) && !empty($empresaNum2))){            
            $json = array("result"=>false,"msggg"=>'Para filtrar por empresas preencha os dois campos!');
            echo json_encode($json);
            return;
        }

        $this->load->library('table');
        $this->load->library('pagination');
        
        $this->load->model('os_model');
		$this->load->model('orcamentos_model');	        
		$this->load->model('almoxarifado_model');		 
		$this->load->model('cotacao_model');		 
        $this->load->model('usuarios_model');	
        $this->data['usuarios_dados'] = $this->usuarios_model->getusuarios('');		
        $config['base_url'] = base_url().'index.php/suprimentos/gerenciar/';
         
        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');		
        
        //------------------------------------------------------

        $this->data['dadosFiltros'] = $this->input->post();
       

        //------------------------------------------------------

        $idUser = $this->session->userdata('idUsuarios');
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        $this->data['dados_emitente2'] = $this->orcamentos_model->getEmitente2();
        if(count($getUserEmpresa)>0){
            $this->data['dados_emitente'] = $getUserEmpresa;
            $primeiro = true;
            $idOs = "";
            foreach($getUserEmpresa as $r){
                if($r->id=="1"){                
                    if($primeiro){
                        $idOs = "10";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",10";
                    }
                }
                if($r->id=="2"){
                    if($primeiro){
                        $idOs = "11";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",11";
                    }
                }
                if($r->id=="3"){
                    if($primeiro){
                        $idOs = "12";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",12";
                    }
                }
            }
        }else{
            /*
            $getUserEmpresa = "";
            $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
            */
            $json = array("result"=>false,"msggg"=>'Você não está vinculado à uma empresa.');
            echo json_encode($json);
            return;
        }
         
        $numPedido = $this->input->post('numPedido');        

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
            
            if($idStatuscompras == 'todos'){
                $query_statuscompra = "(1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,1819,20,21,22,23)";
            }else{
                $query_statuscompra = "(" . $idStatuscompras . ")";
            }

		    
            /*
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
        */
            //print_r($query_statuscompra); exit;
            
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
		
		  
		  
		  
        $fornecedor_id = $this->input->post('fornecedor_id');
        $nf_fornecedor = $this->input->post('nf_fornecedor');
        $descricao = $this->input->post('descricao');
		
		$query_usuario = "";
        $idUsuarios = $this->input->post('idUsuarios');
        if(!empty($idUsuarios))
		{
			$conteudo22 = $idUsuarios;
            $query_usuario="(";
            $primeiro22 = true;
			foreach($conteudo22 as $tipouser)
			{
				if($primeiro22)
				{
					$query_usuario.=$tipouser;
					$primeiro22 = false;
				}
				else
				{
					$query_usuario.=",".$tipouser;
				}
			}
			$query_usuario .= ")";
		}
               
        $resultado = $this->pedidocompra_model->getWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo,'',$query_usuario, $numPedido, $empresaNum1, $empresaNum2, $descricao);
        $json = array('result'=>true,'resultado'=>$resultado);
        echo json_encode($json);
        return;
    }
    public function imprimiritem3Almoxarifado(){

        $idDistribuir = $this->input->post('idDistribuir_');
        $idEmitente2 = $this->input->post('idEmitente');
        //echo("<script>console.log('Emitente: ".$idEmitente2."');</script>");
        if ($this->input->post('idDistribuir_')[0] < 1) {              
            
            $json = array("result"=>false,"msggg"=>'Selecione pelo menos um item!');
            echo json_encode($json);
            return;
                
        }

		$contadoritens=count($idDistribuir);  

        $primeiro = true;
        $itens = '';
        for($x=0;$x<$contadoritens;$x++)
        {
                        
            if($primeiro)
            {
                $itens.=$idDistribuir[$x];
                $primeiro = false;
            }
            else
            {
                $itens.=",".$idDistribuir[$x];
            }	
                
        }
       
        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        //$data['dados_emitente'] = $this->cotacao_model->getEmitente($idEmitente2);
        //$dadosEmitente = $this->cotacao_model->getEmitente($idEmitente2);
        //$dadosPedidoCustom3 = $this->pedidocompra_model->pedidoCustom3($itens);
        //echo("<script>console.log('Emitente: ".$dadosPedidoCustom3."');</script>");
        //$data['dados_emitente'] = $this->cotacao_model->getEmitente($idEmitente2);
        //$data['result'] = $this->pedidocompra_model->pedidoCustom3($itens);

        $data['dados_emitente'] = $this->cotacao_model->getEmitente($idEmitente2);
        $data['result'] = $this->pedidocompra_model->pedidoCustom3($itens);

        $this->load->helper('mpdf');	
        //echo $html = $this->load->view('suprimentos/imprimir/imprimir_pedido',$data,true);
        $json = array(
            'result'=>true,
            'resultado'=>$this->getListDistribuirOs(),
            'html'=>$this->load->view('suprimentos/imprimir/imprimir_pedido',$data,true)
        );
        echo json_encode($json);
		   				
	}
    public function imprimiritemAlmoxarifado(){
		
		$contadoripi=count($this->input->post('idPedidoCompraItensipi'));  		
					
        $idPedidoCompraipi	= $this->input->post('idPedidoCompraipi');
        $tipo = gettype($idPedidoCompraipi);

        if($tipo == 'array'){
            $primero = true;
            foreach($idPedidoCompraipi as $idspc){
                if($primero)
                {
                    $idPedidoCompraipi = $idspc;
                    $primero = false;
                }
                else
                {
                    $idPedidoCompraipi.=",".$idspc;
                }
                
            }
        }
        
        $itens = '';
        $primeiro = true;
        for($x=0;$x<$contadoripi;$x++)
        {
                        
            if($primeiro)
            {
                $itens.=$this->input->post('idPedidoCompraItensipi')[$x];
                $primeiro = false;
            }
            else
            {
                $itens.=",".$this->input->post('idPedidoCompraItensipi')[$x];
            }	
                
        }
            
        $this->data['custom_error'] = '';
        $this->load->model('orcamentos_model');
        
        $data['result'] = $this->pedidocompra_model->pedidoCustom($idPedidoCompraipi,$itens);
    
        $this->load->helper('mpdf');
        $json = array("result"=>true,"resultado"=>$this->getListDistribuirOs(),"html"=>$this->load->view('suprimentos/imprimir/imprimir_pedido',$data,true));
        echo json_encode($json);
        return;
        //redirect(base_url() . 'index.php/pedidocompra/editarpedido/'.$idPedidoCompraipi);			
        //echo $html = $this->load->view('suprimentos/imprimir/imprimir_pedido',$data,true);
		   				
	}
    public function atualizarMaterialParaArmazenar(){
        $this->load->model('almoxarifado_model');
        $json = array("result"=>true,"resultado"=>$this->almoxarifado_model->getAgArmazInicial(),"dados_depinsumos"=>$this->almoxarifado_model->getDepartamentoTipo('INSUMO'));
        echo json_encode($json);
    }

    public function alterarQtdDistribuirOs(){
        $idDistribuir = $this->input->post('idDistribuir');
        $quantidade = $this->input->post('quantidade');
        if(!empty($idDistribuir) && !empty($quantidade)){
            $data = array(
                "quantidade"=>$quantidade
            );
            $this->pedidocompra_model->edit('distribuir_os',$data,'idDistribuir',$idDistribuir);
            $json = array("result"=>true,"msggg"=>"Quantidade alterada!");
            echo json_encode($json);
            return;
        }
        $json = array("result"=>false,"msggg"=>"Ocorreu um erro ao alterar a quantidade.");
        echo json_encode($json);
    }
    public function autorizacao_old(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vAutCompra')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar autorização de compra.');
            redirect(base_url());
        }
        $permCompra = $this->pedidocompra_model->getPermissaoCompraByIdPermissao($this->session->userdata('permissao'));
        if(!empty($permCompra)){
            if(!empty($permCompra->valorMax)){
                $this->data['listaPedidos'] = $this->pedidocompra_model->itensautorizacaocompra($permCompra->valorMin,$permCompra->valorMax);
            }else{
                $this->data['listaPedidos'] = $this->pedidocompra_model->itensautorizacaocompra($permCompra->valorMin,"");
            }
        }
        $this->data['view'] = 'suprimentos/autorizarcompra';
       	$this->load->view('tema/topo',$this->data);
    }
    public function autorizacaoold(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vAutCompra')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar autorização de compra.');
            redirect(base_url());
        }
        $permCompra = $this->pedidocompra_model->getPermissaoCompraByIdPermissao($this->session->userdata('permissao'));
        if(!empty($permCompra)){
            if(!empty($permCompra->valorMax)){
                $this->data['listaPedidos'] = $this->pedidocompra_model->itensautorizacaocompra3($permCompra->valorMin,$permCompra->valorMax);
            }else{
                $this->data['listaPedidos'] = $this->pedidocompra_model->itensautorizacaocompra3($permCompra->valorMin,"");
            }
        }
        if(!empty($this->data['listaPedidos'])){
            for($x = 0; $x < count($this->data['listaPedidos']); $x++){
                $this->data['listaPedidos'][$x]->itens = $this->pedidocompra_model->getByIdOrdemCompra2($this->data['listaPedidos'][$x]->idPedidoCompra);
            }
        }
        $this->data['view'] = 'financeiro/autorizarcompra';
       	$this->load->view('tema/topo',$this->data);
    }
    
    
    
    
    public function autorizacaopcp(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'pSolCompra')){
            $this->session->set_flashdata('error','Você não tem permissão para permitir a solicitação da compra.');
            redirect(base_url());
        }
        $this->data['comprasSolicitadas'] = $this->pedidocompra_model->getComprasSolicitadasPcp();
        $this->data['view'] = 'pcp/solicitacaoCompra';
       	$this->load->view('tema/topo',$this->data);
    }
    
    public function almoxarifadocompras(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vPedidocompraalmox')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar Pedido de compra.');
            redirect(base_url());
        }
        $empresaNum1 = $this->input->post('empresaNum1');
        $empresaNum2 = $this->input->post('empresaNum2');
        if((!empty($empresaNum1) && empty($empresaNum2)) || (empty($empresaNum1) && !empty($empresaNum2))){
            $empresaNum1 = 1;
            $empresaNum2 = 2;
        }

        $this->load->library('table');
        $this->load->library('pagination');
        
        $this->load->model('os_model');
        $this->load->model('almoxarifado_model');
        $this->load->model('orcamentos_model');		 
        $this->load->model('cotacao_model');		 
        $this->load->model('usuarios_model');	
        $this->data['usuarios_dados'] = $this->usuarios_model->getusuarios('');		
        $config['base_url'] = base_url().'index.php/suprimentos/gerenciar/';
        
        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');
        $this->data['dados_statusgrupo'] = $this->pedidocompra_model->getstatus_grupo('');		
        $this->data['dados_usuario_orc']= $this->pedidocompra_model->getUsuariosOrc();
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        
        //------------------------------------------------------

        $this->data['dadosFiltros'] = $this->input->post();
        $idUser = $this->session->userdata('idUsuarios');
        $getUserEmpresa = $this->almoxarifado_model->getEmpresaUsuario($idUser);
        $this->data['dados_emitente2'] = $this->orcamentos_model->getEmitente2();
        if(count($getUserEmpresa)>0){
            $this->data['dados_emitente'] = $getUserEmpresa;
            $primeiro = true;
            $idOs = '';
            foreach($getUserEmpresa as $r){
                if($r->id=="1"){                
                    if($primeiro){
                        $idOs = "10,3,7";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",10,3,7";
                    }
                }
                if($r->id=="2"){
                    if($primeiro){
                        $idOs = "11,2";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",11,2";
                    }
                }
                if($r->id=="3"){
                    if($primeiro){
                        $idOs = "12,1";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",12,1";
                    }
                }
                if($r->id=="4"){
                    if($primeiro){
                        $idOs = "13,6";
                        $primeiro = false;
                    }else{
                        $idOs = $idOs.",13,6";
                    }
                }
            }            
        }else{
            /*
            $getUserEmpresa = "";
            $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente2();
            */
            $this->session->set_flashdata('error','Você não está vinculado à uma empresa.');
            redirect(base_url());
        }
        if(!empty($this->input->post('idOs'))){
            if($this->input->post('idOs')<20000){
                $idOs = $this->input->post('idOs');
            }else{
                $this->session->set_flashdata('error','A ordem de serviço informada não pode ser exibida no almoxarifado.');
                redirect('suprimentos/almoxarifadocompras');
            }
            
        }
 
         //------------------------------------------------------
          
         $numPedido = $this->input->post('numPedido');        
 
         //$idOs = $this->input->post('idOs');
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
             
             if($idStatuscompras == 'todos'){
                 $query_statuscompra = "(1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,18,20,21,22,23)";
             }else{
                 $query_statuscompra = "(" . $idStatuscompras . ")";
             }
 
             
             /*
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
             */
             //print_r($query_statuscompra); exit;
             
            $autorizacaoPCP = "";
         }else{
             $autorizacaoPCP = "";
             $query_statuscompra = "(1)";
         }
           
         $query_idgrupo = "";
         $idgrupo = $this->input->post('idgrupo');
         if(!empty($idgrupo))
		{
			$query_idgrupo = "($idgrupo)";
		}
         
           
           $query_usuario_orc = "";
		$idusuarioorc = $this->input->post('idusuarioorc');
		if(!empty($idusuarioorc))
		{
			$query_usuario_orc = "($idusuarioorc)";
		}
           
           $fornecedor_id = $this->input->post('fornecedor_id');
           $nf_fornecedor = $this->input->post('nf_fornecedor');
           $descricao = $this->input->post('descricao');
           $data_entrega = null;
           if(!empty($this->input->post('data_entrega_inicio')) && !empty($this->input->post('data_entrega_fim')) ){
                $data = explode("/",$this->input->post('data_entrega_inicio'));
                $data_entrega_inicio = $data[2]."-".$data[1]."-".$data[0];

                $data2 = explode("/",$this->input->post('data_entrega_fim'));
                $data_entrega_fim = $data2[2]."-".$data2[1]."-".$data2[0];
                $data_entrega = " and (pedido_comprasitens.datastatusentregue BETWEEN \"$data_entrega_inicio\" and \"$data_entrega_fim\")";
            }
         
         $query_usuario = "";
          $idUsuarios = $this->input->post('idUsuarios');
           if(!empty($idUsuarios))
         {
            $conteudo22 = $idUsuarios;
            $query_usuario="(";
            $primeiro22 = true;
            foreach($conteudo22 as $tipouser)
            {
                if($primeiro22)
                {
                    $query_usuario.=$tipouser;
                    $primeiro22 = false;
                }
                else
                {
                    $query_usuario.=",".$tipouser;
                }
            }
            $query_usuario .= ")";
         }
         $unid_execucao = $this->input->post('unid_execucao');
        $query_unid_execucao = "";
        if (!empty($unid_execucao)) {
            $conteudo2 = $unid_execucao;
            $query_unid_execucao = "(";
            $primeiro2 = true;
            foreach ($conteudo2 as $unid_execucao2) {
                if ($primeiro2) {
                    $query_unid_execucao .= $unid_execucao2;
                    $primeiro2 = false;
                } else {
                    $query_unid_execucao .= "," . $unid_execucao2;
                }
            }
            $query_unid_execucao .= ")";
        }
         
         /*
         if($idStatuscompras == 1){
 
             if (!empty($idOs) || !empty($idPedidoCotacao)   || !empty($query_statuscompra) || !empty($idPedidoCompra) || !empty($fornecedor_id) || !empty($nf_fornecedor) || !empty($query_idgrupo) || !empty($query_usuario) || !empty($numPedido) || !empty($empresaNum1) || !empty($empresaNum2)) {
 
                 $this->data['results'] = $this->cotacao_model->getWhereLikeos($idOs, $idPedidoCotacao,$idStatuscompras,$query_usuario);
  
                 $config['total_rows'] = $this->cotacao_model->numrowsWhereLikeos($idOs, $idPedidoCotacao,$idStatuscompras,$query_usuario);
                 $config['per_page'] = 5000;
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
 
         }else{
        */
             if (!empty($idOs) || !empty($idPedidoCotacao)   || !empty($query_statuscompra) || !empty($idPedidoCompra) || !empty($fornecedor_id) || !empty($nf_fornecedor) || !empty($query_idgrupo) || !empty($query_usuario) || !empty($numPedido) || !empty($empresaNum1) || !empty($empresaNum2) || !empty($descricao)|| !empty($data_entrega) || !empty($query_unid_execucao) || !empty($query_usuario_orc)) {
                
                 $this->data['results'] = $this->pedidocompra_model->getWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo,'',$query_usuario, $numPedido, $empresaNum1, $empresaNum2, $descricao, '',$data_entrega,$autorizacaoPCP,$query_unid_execucao,null,$query_usuario_orc);
                 //print_r($this->data['results']); exit;            
                 $config['total_rows'] = $this->pedidocompra_model->numrowsWhereLikeos($idOs, $idPedidoCotacao,$query_statuscompra,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo,'',$query_usuario, $numPedido, $empresaNum1, $empresaNum2, $descricao);
                 $config['per_page'] = 2;
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
                 
                 //$this->pagination->initialize($config); 
 
             } 
         //}
 
          //else {
 
             //$config['total_rows'] = $this->pedidocompra_model->count('pedido_cotacaoitens');
             /*--ms--
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
          
          
          */
          //}
         
  
         
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
        $this->data['dados_emitente'] = $this->orcamentos_model->getEmitente();
        $this->data['view'] = 'almoxarifado/suprimentos';
        $this->load->view('tema/topo',$this->data);
    }
    function reservaritensalmoxarifado(){
        $this->load->model('almoxarifado_model');
        $empresa = $this->input->post('empresa');
        $estoque = $this->input->post('retiradaEstoque');
        $quantidadeTotal = $this->input->post('quantidadeTotal');
        $insumo = $this->input->post('insumo');
        $distribuir =$this->pedidocompra_model->getInsumosByPedidoComprasItens($this->input->post('idprodutocompraitens')); 
        for($x=0;$x<count($estoque);$x++){
            if(!empty($estoque[$x])){
                if($distribuir->quantidade < $estoque[$x]){
                    $this->session->set_flashdata('error','A quantidade informada é maior do que a quantidade solicitada para a compra.');
                    $this->exibirsuprimentoseditados($this->input->post('idDistribuir'));
                    return;
                }
                if($estoque[$x]>$quantidadeTotal[$x]){
                    $this->session->set_flashdata('error','A quantidade informada é maior do que a quantidade em estoque.');
                    $this->exibirsuprimentoseditados($this->input->post('idDistribuir'));
                    return;
                }
            }            
        }
        for($x=0;$x<count($empresa);$x++){
            if(!empty($estoque[$x])){
                $resultEstq = $this->almoxarifado_model->getEstoqueByIdEmitenteAndIdInsumo($empresa[$x],$insumo[$x]);       
                if($resultEstq[0]->quantidade >= $estoque[$x]){
                    $newQuantidade = $resultEstq[0]->quantidade - $estoque[$x];
                    $data = array(
                        'quantidade'=>$newQuantidade
                    );
                    $this->pedidocompra_model->edit('almo_estoque', $data, 'idAlmoEstoque', $resultEstq[0]->idAlmoEstoque);
                    $data2 = $resultEstq[0];
                    $data2->idAlmoEstoque = null;
                    $data2->quantidade = $estoque[$x];
                    $data2->idOs = $distribuir->idOs;
                    if(empty($data2->idLocal)){
                        $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal is null";
                    
                    }else{
                        $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal = $data2->idLocal";
                    
                    }
                    echo("<script>console.log('".$where."');</script>");
                    $getEstoque =  $this->pedidocompra_model->get('almo_estoque',$where);
                    if(!empty($getEstoque)){
                        $quantidade = $getEstoque->quantidade + $estoque[$x];
                        $data3 = array('quantidade'=>$quantidade);
                        $this->pedidocompra_model->edit('almo_estoque', $data3, 'idAlmoEstoque', $getEstoque->idAlmoEstoque);
                    }else{
                        $this->pedidocompra_model->add('almo_estoque', $data2);
                    }
                }else{
                    $count = 0;
                    $acabou = false;
                    while($estoque[$x]>0 && $acabou == false){
                        if($resultEstq[$count]->quantidade >= $estoque[$x]){
                            $newQuantidade = $resultEstq[$count]->quantidade - $estoque[$x];
                            $data = array(
                                'quantidade'=>$newQuantidade
                            );
                            $this->pedidocompra_model->edit('almo_estoque', $data, 'idAlmoEstoque', $resultEstq[$count]->idAlmoEstoque);
                            $data2 = $resultEstq[$count];
                            $data2->idAlmoEstoque = null;
                            $data2->quantidade = $estoque[$x];
                            $data2->idOs = $distribuir->idOs;
                            if(empty($data2->idLocal)){
                                $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal is null";
                            }else{
                                $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal = $data2->idLocal";
                            
                            }
                            echo("<script>console.log('".$where."');</script>");
                            $getEstoque =  $this->pedidocompra_model->get('almo_estoque',$where);
                            if(!empty($getEstoque)){
                                $quantidade = $getEstoque->quantidade + $estoque[$x];
                                $data3 = array('quantidade'=>$quantidade);
                                $this->pedidocompra_model->edit('almo_estoque', $data3, 'idAlmoEstoque', $getEstoque->idAlmoEstoque);
                            }else{
                                $this->pedidocompra_model->add('almo_estoque', $data2);
                            }
                            
                            $acabou = true;
                        }else{
                            $estoque[$x] = $estoque[$x] - $resultEstq[$count]->quantidade;
                            $data = array(
                                'quantidade'=>0
                            );
                            $this->pedidocompra_model->edit('almo_estoque', $data, 'idAlmoEstoque', $resultEstq[$count]->idAlmoEstoque);
                            $data2 = $resultEstq[$count];
                            $data2->idAlmoEstoque = null;
                            $data2->idOs = $distribuir->idOs;
                            if(empty($data2->idLocal)){
                                $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal is null";
                            
                            }else{
                                $where = "idProduto = $data2->idProduto and idOs = $data2->idOs and idDepartamento = $data2->idDepartamento and idEmitente = $data2->idEmitente and idLocal = $data2->idLocal";
                            
                            }
                            echo("<script>console.log('".$where."');</script>");
                            $getEstoque =  $this->pedidocompra_model->get('almo_estoque',$where);
                            if(!empty($getEstoque)){
                                $quantidade = $getEstoque->quantidade + $resultEstq[$count]->quantidade;
                                $data3 = array('quantidade'=>$quantidade);
                                $this->pedidocompra_model->edit('almo_estoque', $data3, 'idAlmoEstoque', $getEstoque->idAlmoEstoque);
                            }else{
                                $this->pedidocompra_model->add('almo_estoque', $data2);
                            }
                        }
                    }
                }        
            }            
        }
        $this->exibirsuprimentoseditados($this->input->post('idDistribuir'));
    }

    function ordemservico(){
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
            redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->model('os_model');

        if (!empty($this->input->get('idOrcamentos'))) {
            $cod_orc = $this->input->get('idOrcamentos');
        } else {
            $cod_orc = $this->input->post('idOrcamentos');
        }



        $config['base_url'] = base_url() . 'index.php/suprimentos/ordemservico/';
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['unid_fat'] = $this->os_model->get_table('unidade_faturamento');
        $this->data['tipo_os'] = $this->os_model->get_table('os_tipo');
        $this->data['status_os'] = $this->os_model->getstatus_os();
        $this->data['verificacao_controle'] = $this->os_model->getVerificacaoControle();
        $idOs = $this->input->post('idOs');

        $clientes_id  = $this->input->post('clientes_id');
        $idProdutos = $this->input->post('idProdutos');
        $numpedido_os = $this->input->post('numpedido_os');
        $tag = $this->input->post('tag');
        $numero_nf = $this->input->post('numero_nf');
        $numero_nffab = $this->input->post('numero_nffab');
        $descricao_item = $this->input->post('descricao_item');
        $unid_execucao = $this->input->post('unid_execucao');
        $unid_faturamento = $this->input->post('unid_faturamento');
        $id_tipo = $this->input->post('id_tipo');
        $idStatusOs = $this->input->post('idStatusOs');
        $desenho = $this->input->post('desenho');
        $verificacaoControle = $this->input->post('verificacaoControle');
        $query_status_producao = "";
        if (!empty($idStatusOs)) {
            $conteudo = $idStatusOs;
            $query_status_producao = "(";
            $primeiro = true;
            foreach ($conteudo as $status_producao3) {
                if ($primeiro) {
                    $query_status_producao .= $status_producao3;
                    $primeiro = false;
                } else {
                    $query_status_producao .= "," . $status_producao3;
                }
            }
            $query_status_producao .= ")";
        }
        $query_unid_execucao = "";
        if (!empty($unid_execucao)) {
            $conteudo2 = $unid_execucao;
            $query_unid_execucao = "(";
            $primeiro2 = true;
            foreach ($conteudo2 as $unid_execucao2) {
                if ($primeiro2) {
                    $query_unid_execucao .= $unid_execucao2;
                    $primeiro2 = false;
                } else {
                    $query_unid_execucao .= "," . $unid_execucao2;
                }
            }
            $query_unid_execucao .= ")";
        }
        $query_unid_faturamento = "";
        if (!empty($unid_faturamento)) {
            $conteudo3 = $unid_faturamento;
            $query_unid_faturamento = "(";
            $primeiro3 = true;
            foreach ($conteudo3 as $unid_execucao2) {
                if ($primeiro3) {
                    $query_unid_faturamento .= $unid_execucao2;
                    $primeiro3 = false;
                } else {
                    $query_unid_faturamento .= "," . $unid_execucao2;
                }
            }
            $query_unid_faturamento .= ")";
        }
        $query_tipoos = "";
        if (!empty($id_tipo)) {
            $conteudo33 = $id_tipo;
            $query_tipoos = "(";
            $primeiro33 = true;
            foreach ($conteudo33 as $tipo3) {
                if ($primeiro33) {
                    $query_tipoos .= $tipo3;
                    $primeiro33 = false;
                } else {
                    $query_tipoos .= "," . $tipo3;
                }
            }
            $query_tipoos .= ")";
        }
        $query_desenho = "";
        $primeirodes = true;
        if (!empty($desenho)) {
            $desenho2 = "";
            foreach ($desenho as $des) {
                if ($primeirodes) {
                    $desenho2 = $des;
                    $primeirodes = false;
                } else {
                    $desenho2 =  $desenho2 . ',' . $des;
                }
            }
            $query_desenho = " and os.statusDesenho IN($desenho2)";
        }
        $query_verifControl = "";
        $primeiroverifControl = true;
        if (!empty($verificacaoControle)) {
            $verificacaoControle2 = "";
            foreach ($verificacaoControle as $des) {
                if ($primeiroverifControl) {
                    $verificacaoControle2 = $des;
                    $primeiroverifControl = false;
                } else {
                    $verificacaoControle2 =  $verificacaoControle2 . ',' . $des;
                }
            }
            $query_verifControl = " and os.idVerificacaoControle IN($verificacaoControle2)";
        }
        $this->data['hist_vale'] = $this->os_model->getHistVale();

        if (!empty($idOs) || !empty($cod_orc) || !empty($clientes_id) || !empty($idProdutos) || !empty($numpedido_os) || !empty($tag) || !empty($numero_nf) || !empty($descricao_item) || !empty($unidade_execucao) || !empty($query_unid_execucao) || !empty($query_unid_faturamento) || !empty($query_tipoos) || !empty($query_status_producao)  || !empty($query_verifControl) || !empty($numero_nffab) || !empty($query_desenho) ) {




            $this->data['results'] = $this->os_model->getWhereLikeos($idOs, $cod_orc, $clientes_id, $idProdutos, $numpedido_os, $tag, $numero_nf, $descricao_item, 'os', "", $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", "", "", "", "", $query_tipoos, $query_desenho,'',$query_verifControl, $numero_nffab);


            $config['total_rows'] = $this->os_model->numrowsWhereLikeos($idOs, $cod_orc, $clientes_id, $idProdutos, $numpedido_os, $tag, $numero_nf, $descricao_item, 'os', "", $query_status_producao, $query_unid_execucao, $query_unid_faturamento, "", "", "", "", "", $query_tipoos);
            $config['per_page'] = 5;
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
            $config['per_page'] = 5;
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


            $this->data['results'] = $this->os_model->getos('os', 'os.data_abertura_real,os.data_insert,verificacao_controle.*,grupo_servico.*,os.statusDesenho,os.obsDesenho,os.desconto_os,os.val_unit_os,os.numpedido_os,os.tag,os.val_ipi_os,os.idOs,os.`data_abertura`,os.`subtot_os`,os.`data_entrega`,os.`data_reagendada`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,os_tipo.nome_tipo,(SELECT anexo_desenho.idAnexo from anexo_desenho where  anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue,status_os.nomeStatusOs ', '', 'os', $config['per_page'], $this->uri->segment(3));    
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

        $this->data['view'] = 'suprimentos/ordemservico_sup.php';
        $this->load->view('tema/topo', $this->data);
        //$this->load->view('tema/rodape');
    }

    function send($to,$assunto,$msg) {
        $this->load->config('email');
        $this->load->library('email');
        
        $from = $this->config->item('smtp_user');
        //$subject = $this->input->post('subject');
        //$message = $this->input->post('message');

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($assunto);
        $this->email->message($msg);

        if ($this->email->send()) {
            echo 'Your Email has successfully been sent.';
        } else {
           // show_error($this->email->print_debugger());
        }
    }

    
    public function getpedidocompra(){
        $idPedidoCompraItens = $this->input->post('idPedidoCompraItens');
        if(!empty($idPedidoCompraItens)){
            $pedidoCompraItens = $this->pedidocompra_model->getbyIdPedidoComprasItens($idPedidoCompraItens);
            echo json_encode(array("result"=>true,"idPedidoCompra"=>$pedidoCompraItens->idPedidoCompra));
            return;
        }else{
            echo json_encode(array("result"=>false,"msg"=>"Pedido de compra inexistente."));
            return;
        }
    }

 public function aprovacao() {
        redirect('suprimentos/aprovacao_financeira');
        return;
    
}
    public function permcompradistribuir(){
        $idPedidoCompraItens = $this->input->post("idDistribuir");/*
        if($this->input->post("soma")>=1000){
            $autorizacaoFinan = 0;
            $data2 = array{

            }
        }else{
            $autorizacaoFinan = 1;
        }*/
        $objDistribuir = $this->pedidocompra_model->get("distribuir_os","idDistribuir = ".$idPedidoCompraItens);
        $objPedidoCompraItens = $this->pedidocompra_model->getPedidoCompraItensByIdDistribuir2($idPedidoCompraItens);
        //echo json_encode($objDistribuir);
        //echo "</br>";
        //echo json_encode($objPedidoCompraItens);
        //return;
        $autorizadoCompra = $this->input->post("autorizacaoCompra") ;
        if($objDistribuir->aprovacaoSUP==0){
            if($this->input->post("autorizacaoCompra") == 'false'){
                $autorizadoCompra = (int)0;
    
                $data = array(
                    'aprovacaoSUP'=>$autorizadoCompra,
                    'idUserAprovacaoSUP'=>null,
                    'idStatuscompras'=>17,
                    'data_autorizacaoSUP'=>null,
                    'data_alteracao'=>date('Y-m-d H:i:s')
                );
            }else{
                $autorizadoCompra = (int)1;
                if($objDistribuir->aprovacaoDir == 1){/*
                    $objPedidoCompraItens = $this->pedidocompra_model->getPedidoCompraItensByIdDistribuir2($objDistribuir->idDistribuir);
                    $allObjPedidoCompraItens = $this->pedidocompra_model->getItensDoPedidoCompra($objPedidoCompraItens->idPedidoCompra);
                    $somaTotal = 0;
                    for($k=0;$k<count($allObjPedidoCompraItens);$k++){
                        $somaTotal = $somaTotal + ($allObjPedidoCompraItens[$k]->quantidade*$allObjPedidoCompraItens[$k]->valor_unitario);
                    }
                    if($somaTotal > 5000){
                        $data = array(
                            'aprovacaoSUP'=>$autorizadoCompra,
                            'idUserAprovacaoSUP'=>$this->session->userdata('idUsuarios'),
                            'idStatuscompras'=>13,
                            'data_autorizacaoSUP'=>date('Y-m-d H:i:s'),
                            'data_alteracao'=>date('Y-m-d H:i:s')
                        );
                    }else{*/
                        $data = array(
                            'aprovacaoSUP'=>$autorizadoCompra,
                            'idUserAprovacaoSUP'=>$this->session->userdata('idUsuarios'),
                            'idStatuscompras'=>14,
                            'data_autorizacaoSUP'=>date('Y-m-d H:i:s'),
                            'data_alteracao'=>date('Y-m-d H:i:s')
                        );/**/
                        $data2 = array(
                            'autorizadoCompra'=>1,
                            'idUsuarioAutorizacao'=>51,
                            'data_autorizacao'=>date('Y-m-d H:i:s')
                        );
                        $this->pedidocompra_model->edit('pedido_comprasitens',$data2,'idPedidoCompraItens',$objPedidoCompraItens->idPedidoCompraItens);
                    //}                
                }else{
                    $data = array(
                        'aprovacaoSUP'=>$autorizadoCompra,
                        'idUserAprovacaoSUP'=>$this->session->userdata('idUsuarios'),
                        'idStatuscompras'=>16,
                        'data_autorizacaoSUP'=>date('Y-m-d H:i:s'),
                        'data_alteracao'=>date('Y-m-d H:i:s')
                    );
                }
                
            }
    
            
            $this->pedidocompra_model->edit('distribuir_os',$data,'idDistribuir',$idPedidoCompraItens);
        }
        
        $json = array("result"=>true,"msggg"=>$autorizadoCompra);
        echo json_encode($json);
    }
    public function permcompradistribuir2(){
        $idPedidoCompraItens = $this->input->post("idDistribuir");/*
        if($this->input->post("soma")>=1000){
            $autorizacaoFinan = 0;
            $data2 = array{

            }
        }else{
            $autorizacaoFinan = 1;
        }*/
        $objDistribuir = $this->pedidocompra_model->get("distribuir_os","idDistribuir = ".$idPedidoCompraItens);
        $autorizadoCompra = $this->input->post("autorizacaoCompra");
        if($objDistribuir->aprovacaoDir == 0){
            $objPedidoCompraItens = $this->pedidocompra_model->getPedidoCompraItensByIdDistribuir2($idPedidoCompraItens);
            if($this->input->post("autorizacaoCompra") == 'false'){
                $autorizadoCompra = (int)0;
    
                $data = array(
                    'aprovacaoDir'=>$autorizadoCompra,
                    'idUserAprovacaoDir'=>null,
                    'idStatuscompras'=>16,
                    'data_autorizacaoDir'=>null,
                    'data_alteracao'=>date('Y-m-d H:i:s')
                );
            }else{
                $autorizadoCompra = (int)1;
                if($objDistribuir->aprovacaoSUP == 1){
                    $data = array(
                        'aprovacaoDir'=>$autorizadoCompra,
                        'idUserAprovacaoDir'=>$this->session->userdata('idUsuarios'),
                        'idStatuscompras'=>14,
                        'data_autorizacaoDir'=>date('Y-m-d H:i:s'),
                        'data_alteracao'=>date('Y-m-d H:i:s')
                    );/*
                    $data2 = array(
                        'autorizadoCompra'=>1,
                        'idUsuarioAutorizacao'=>51,
                        'data_autorizacao'=>date('Y-m-d H:i:s')
                    );
                    $this->pedidocompra_model->edit('pedido_comprasitens',$data2,'idPedidoCompraItens',$objPedidoCompraItens->idPedidoCompraItens);
                */}else{
                    $data = array(
                        'aprovacaoDir'=>$autorizadoCompra,
                        'idUserAprovacaoDir'=>$this->session->userdata('idUsuarios'),                        
                        'data_autorizacaoDir'=>date('Y-m-d H:i:s'),/*
                        'aprovacaoSUP'=>1,
                        'idUserAprovacaoSUP'=>51,
                        'data_autorizacaoSUP'=>date('Y-m-d H:i:s'),*/
                        'idStatuscompras'=>17,
                        'data_alteracao'=>date('Y-m-d H:i:s')
                    );/*
                    $data2 = array(
                        'autorizadoCompra'=>1,
                        'idUsuarioAutorizacao'=>51,
                        'data_autorizacao'=>date('Y-m-d H:i:s')
                    );
                    $this->pedidocompra_model->edit('pedido_comprasitens',$data2,'idPedidoCompraItens',$objPedidoCompraItens->idPedidoCompraItens);
                */}
                
            }
            $this->pedidocompra_model->edit('distribuir_os',$data,'idDistribuir',$idPedidoCompraItens);
        }        
        $json = array("result"=>true,"msggg"=>$autorizadoCompra);
        echo json_encode($json);
    }
    public function aprovarpcpCopy(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'pSolCompra')){
            $this->session->set_flashdata('error','Você não tem permissão para permitir a solicitação da compra.');
            redirect(base_url());
        }
        $this->data['menuPedidoCompra'] = null;
        $this->data['menuPcp'] = "Aprovar";
        $this->data['comprasSolicitadas'] = $this->pedidocompra_model->getComprasParaAprovarPcp();
        $this->data['view'] = 'pcp/aprovarCompra';
       	$this->load->view('tema/topo',$this->data);
    }
	
	
  public function aprovarpcp(){
        redirect('suprimentos/aprovacao_financeira');
        return;
    
}

    public function permSolCompra(){
        $idDistribuir = $this->input->post("idDistribuir");
        if($this->input->post("autorizacaoCompra") == 'false'){
            $autorizadoCompra = (int)0;
            $data = array(
                'aprovacaoPCP'=>$autorizadoCompra,
                'idUserAprovacao'=>null,
                'idStatuscompras'=>$this->input->post("status"),
                'data_autorizacaoPCP'=>null,
                'data_alteracao'=>date('Y-m-d H:i:s')
            );
        }else{
            $autorizadoCompra = (int)1;
            $data = array(
                'aprovacaoPCP'=>$autorizadoCompra,
                'idUserAprovacao'=>$this->session->userdata('idUsuarios'),
                'idStatuscompras'=>$this->input->post("status"),
                'data_autorizacaoPCP'=>date('Y-m-d H:i:s'),
                'data_alteracao'=>date('Y-m-d H:i:s')
            );
        }
        $this->pedidocompra_model->edit('distribuir_os',$data,'idDistribuir',$idDistribuir);
        $objdistribuiros = $this->pedidocompra_model->getDistribuirDetails($idDistribuir);
        $itensPedido = $this->pedidocompra_model->getItensDoPedidoCompra($objdistribuiros->idPedidoCompra);
        $soma = 0;/*
        $enviarEmail = true;
        foreach($itensPedido as $v){
            $soma += $v->valor_unitario*$v->quantidade;
            if($v->etapa<3 || $v->idStatuscompras ==10){
                $enviarEmail = false;
            }
        }
        $html = "";
        if($enviarEmail){
            $itensCompra = $this->pedidocompra_model->getdistribuidorByIdPedidoCompra($objdistribuiros->idPedidoCompra);
            $html = "<table>
                        <thead>
                            <tr>
                                <th>O.S.</th>
                                <th>Qtd</th>
                                <th>Descrição</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach($itensCompra as $g){
                $html = $html."<tr>";
                $html = $html."<td>".$g->idOs." </td>";
                $html = $html."<td>".$g->quantidade." </td>";
                $html = $html."<td>".$g->descricaoInsumo." </td>";
                $html = $html."</tr>";
            }
            
            $html = $html."</tbody>";
            $html = $html."</table>";
        }
        $this->send("keven@ubertec.ind.br","Um novo pedido de compra para autorizar (".$objdistribuiros->idPedidoCompra."). ",$html);*/
        $json = array("result"=>true,"msggg"=>"");
        echo json_encode($json);
    }
    
    public function autorizacao(){
        redirect('suprimentos/aprovacao_financeira');
        return;
    
}

public function getObsRevisaoPcp() {
    header('Content-Type: application/json');
    $id = $this->input->get('idDistribuir');
    if (!$id) {
        echo json_encode(['observacao' => '', 'data_revisao_pcp' => '']);
        exit;
    }

    // Busca o item no banco de dados usando o cotacao_model
$item = $this->cotacao_model->gettable('distribuir_os', 'idDistribuir = ' . (int)$id);

$response = [
  'observacao' => ($item && property_exists($item, 'observacao_revisao_pcp')) ? $item->observacao_revisao_pcp : '',
  'data_revisao_pcp' => ($item && property_exists($item, 'data_revisao_pcp') && $item->data_revisao_pcp) ? $item->data_revisao_pcp : null,
];

echo json_encode($response);
exit;

}	
    public function salvarRevisaoPcp() {
        header('Content-Type: application/json');
        $id = $this->input->post('idDistribuir');
        $obs = $this->input->post('observacao');
        
        if (!$id) {
            echo json_encode(['status' => 'erro', 'msg' => 'ID invalido']); exit;
        }
        $ok = $this->pedidocompra_model->edit('distribuir_os', [
            'idStatuscompras' => 22,
            'observacao_revisao_pcp' => $obs,
            'data_revisao_pcp' => date('Y-m-d H:i:s')
        ], 'idDistribuir', $id);

        echo json_encode(['status' => $ok ? 'ok' : 'erro']);
    }
	
	
    public function aprovacao_financeira()
    {
        $this->_assertFinanceApprover();
        $sql = "
            SELECT 
                os.idOs, os.dataInicial, os.dataFinal, os.idOrcamentos, os.clientes_id,
                clientes.nomeCliente,
                distribuir_os.idDistribuir AS idDist,
                pedido_comprasitens.idPedidoCompraItem,
                pedido_comprasitens.idPedidoCompra,
                IFNULL(pedido_comprasitens.autorizadoCompra,0) AS autorizadoCompra,
                pedido_comprasitens.valorTotalItem
            FROM distribuir_os
            JOIN os ON os.idOs = distribuir_os.idOs
            JOIN clientes ON clientes.idClientes = os.clientes_id
            LEFT JOIN pedido_comprasitens 
                   ON pedido_comprasitens.idDistribuir = distribuir_os.idDistribuir
            WHERE (pedido_comprasitens.autorizadoCompra = 0 OR pedido_comprasitens.autorizadoCompra IS NULL)
              AND IFNULL(os.excluido,0) = 0
            ORDER BY os.idOs DESC
            LIMIT 500
        ";
        $this->data['itensPendentes'] = $this->db->query($sql)->result();
        $this->data['view'] = 'suprimentos/aprovacao_financeira';
        $this->load->view('tema/topo', $this->data);
    }


public function aprovar_financeiro()
{
    // Permite apenas Daniel (id 53) e José (id 18)
    $this->_assertFinanceApprover();

    $idsItens = $this->input->post('idsItens');

    if (!is_array($idsItens) || empty($idsItens)) {
        $this->session->set_flashdata('error', 'Nenhum item selecionado para aprovação.');
        redirect('suprimentos/aprovacao_financeira');
        return;
    }

    $this->db->trans_begin();
    $agora = date('Y-m-d H:i:s');

    // Obtém o ID do usuário logado (para registrar quem aprovou)
    $idUsuario = (int)$this->session->userdata('idUsuarios');

    foreach ($idsItens as $idItem) {
        $idItem = (int)$idItem;

        // Atualiza a autorização financeira com o usuário que aprovou
        $this->db->where('idPedidoCompraItem', $idItem)
                 ->update('pedido_comprasitens', array(
                     'autorizadoCompra'     => 1,
                     'idUsuarioAutorizacao' => $idUsuario,
                     'data_autorizacao'     => $agora
                 ));
    }

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        $this->session->set_flashdata('error', 'Falha ao aprovar financeiramente.');
    } else {
        $this->db->trans_commit();

        // Mensagem diferenciada (identifica quem aprovou)
        $usuarioNome = $this->session->userdata('nome') ?: 'Usuário ID ' . $idUsuario;
        $this->session->set_flashdata('success', 'Itens aprovados financeiramente por ' . $usuarioNome . '.');
    }

    redirect('suprimentos/aprovacao_financeira');
}

	
// --- INÍCIO: FUNÇÃO AJAX CORRIGIDA ---
    // Substitua a função aprovarFinal() existente por esta

    /**
     * Processa a APROVAÇÃO ou REJEIÇÃO final vinda da tela (via AJAX).
     * Esta função é chamada pelo JavaScript na view autorizarcompra.php.
     */
// --- INÍCIO: FUNÇÃO AJAX CORRIGIDA ---
    // Substitua a função aprovarFinal() existente por esta

    /**
     * Processa a APROVAÇÃO ou REJEIÇÃO final vinda da tela (via AJAX).
     * Esta função é chamada pelo JavaScript na view autorizarcompra.php.
     */
public function aprovarFinal() {
    // 1. Verificação de Segurança e Permissão (Apenas Daniel ou Vagner)
    $idUsuario = (int)$this->session->userdata('idUsuarios');
    if ($idUsuario != 53 && $idUsuario != 18 && $idUsuario != 26) {
         if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
             echo json_encode(["result" => false, "msggg" => "Acesso não autorizado."]); exit;
         } else {
             $this->session->set_flashdata('error', 'Acesso não autorizado.'); redirect(base_url()); exit;
         }
    }
    
    // 2. Permissão de EDIÇÃO (Verificando a permissão 'aAutCompraFIN')
    if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aAutCompraFIN')){
         if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode(["result" => false, "msggg" => "Permissão insuficiente para executar a aprovação."]); exit;
         } else {
             $this->session->set_flashdata('error', 'Permissão insuficiente.'); redirect(base_url('suprimentos/aprovacaoFinal')); exit; 
         }
    }

    // 3. Obter Dados da Requisição (AJAX)
    $idDistribuir = $this->input->post("idDistribuir");
    $action = $this->input->post("action");
    $observacao = $this->input->post("observacao");

    if (!$idDistribuir || !$action || !is_numeric($idDistribuir)) {
         echo json_encode(["result" => false, "msggg" => "Dados incompletos ou inválidos."]); exit;
    }

    // 4. Verificar Estado Atual do Item
    $objDistribuir = $this->pedidocompra_model->get("distribuir_os", "idDistribuir = ".(int)$idDistribuir." AND idStatuscompras = 23");

    if(!$objDistribuir){
        echo json_encode(["result" => false, "msggg" => "Item não encontrado ou não está mais aguardando aprovação final."]); exit;
    }

    // 5. Processar Ação
    $data_dist = [];
    $update_pci = false;
    $data_pci = [];

    if ($action == 'approve') {
        $data_dist = array(
            'idStatuscompras' => 14,
            'data_alteracao' => date('Y-m-d H:i:s'),
            'rejeitado' => 0, 
            'obs_rejeitado' => null,
            'idUserRejeitado' => null,
            'data_rejeitado' => null
        );
        $update_pci = true;
        $data_pci = array(
           'autorizadoCompra' => 1,
           'idUsuarioAutorizacao' => $idUsuario, // agora grava quem aprovou
           'data_autorizacao' => date('Y-m-d H:i:s')
        );

    } elseif ($action == 'reject') {
        if (empty($observacao)) {
             echo json_encode(["result" => false, "msggg" => "A observação é obrigatória para rejeitar."]); exit;
        }
        $data_dist = array(
            'idStatuscompras' => 15,
            'rejeitado' => 1,
            'obs_rejeitado' => $observacao,
            'idUserRejeitado' => $idUsuario, // grava quem rejeitou
            'data_rejeitado' => date('Y-m-d H:i:s'),
            'data_alteracao' => date('Y-m-d H:i:s')
        );
        $update_pci = true;
        $data_pci = array(
           'autorizadoCompra' => 0,
           'idUsuarioAutorizacao' => null,
           'data_autorizacao' => null
        );

    } else {
        echo json_encode(["result" => false, "msggg" => "Ação inválida."]); exit;
    }

    // 6. Executar Atualizações no Banco de Dados (Transação)
    $this->db->trans_start();

    $update_dist_ok = $this->pedidocompra_model->edit('distribuir_os', $data_dist, 'idDistribuir', $idDistribuir);
    $update_pci_ok = true;

    if ($update_pci) {
         $objPCI = $this->pedidocompra_model->getPedidoCompraItensByIdDistribuir2($idDistribuir);
         if ($objPCI && $objPCI->idPedidoCompraItens) {
             $update_pci_ok = $this->pedidocompra_model->edit('pedido_comprasitens', $data_pci, 'idPedidoCompraItens', $objPCI->idPedidoCompraItens);
         } else {
             log_message('error', "Não foi possível encontrar idPedidoCompraItens para idDistribuir: $idDistribuir na aprovação final.");
             $update_pci_ok = false;
         }
    }

    $this->db->trans_complete();

    // 7. Retornar Resposta AJAX
    if ($this->db->trans_status() === FALSE || !$update_dist_ok || !$update_pci_ok) {
         log_message('error', "Falha na transação ao aprovar/rejeitar final. idDistribuir: $idDistribuir. Ação: $action");
         echo json_encode(array("result" => false, "msggg" => "Erro ao atualizar o banco de dados."));
    } else {
         echo json_encode(array("result" => true, "msggg" => "Ação realizada com sucesso."));
    }
     exit;
}


}
