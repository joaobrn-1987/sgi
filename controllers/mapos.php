<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mapos_model','',TRUE);
        
    }

    public function index() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

       /* $this->data['ordens'] = $this->mapos_model->getOsAbertas();
        $this->data['produtos'] = $this->mapos_model->getProdutosMinimo();
        $this->data['os'] = $this->mapos_model->getOsEstatisticas();
        $this->data['estatisticas_financeiro'] = $this->mapos_model->getEstatisticasFinanceiro();*/
        if($this->permission->checkPermission($this->session->userdata('permissao'),'clientes')){
            $this->load->model('almoxarifado_model');
            $this->data['estoque'] = $this->almoxarifado_model->getEstoqueProduto2();
            $this->data['view'] = 'estoque/estoque';
            $this->load->view('menu/principal', $this->data);
        } else {
            $this->data['menuPainel'] = 'Painel';
            $this->data['view'] = 'mapos/painel';
            $this->load->view('tema/topo',  $this->data);
        }
      
    }

    public function minhaConta() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        $this->data['usuario'] = $this->mapos_model->getById($this->session->userdata('id'));
        $this->data['view'] = 'mapos/minhaConta';
        $this->load->view('tema/topo',  $this->data);
     
    }

    public function alterarSenha() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        $oldSenha = $this->input->post('oldSenha');
        $senha = $this->input->post('novaSenha');
        $result = $this->mapos_model->alterarSenha($senha,$oldSenha,$this->session->userdata('id'));
		
        if($result){
            $this->session->set_flashdata('success','Senha Alterada com sucesso!');
            redirect(base_url() . 'index.php/mapos/minhaConta');
        }
        else{
            $this->session->set_flashdata('error','Ocorreu um erro ao tentar alterar a senha!');
            redirect(base_url() . 'index.php/mapos/minhaConta');
            
        }
    }

    public function pesquisar() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }        
        $termo = $this->input->get('termo');
        $data['results'] = $this->mapos_model->pesquisar($termo);
        $this->data['produtos'] = $data['results']['produtos'];
        $this->data['servicos'] = $data['results']['servicos'];
        $this->data['os'] = $data['results']['os'];
        $this->data['clientes'] = $data['results']['clientes'];
        $this->data['fornecedores'] = $data['results']['fornecedores'];
        $this->data['view'] = 'mapos/pesquisa';
        $this->load->view('tema/topo',  $this->data);
      
    }

    public function login(){
        
        $this->load->view('mapos/login');
        
    }
    public function sair(){
        $this->session->sess_destroy();
        redirect('mapos/login');
    }


    public function verificarLogin(){

        // Rate limiting: max 5 attempts per 5 minutes per IP
        $ip_key = 'login_attempts_' . md5($this->input->ip_address());
        $attempts_key = $ip_key . '_count';
        $time_key = $ip_key . '_time';
        $login_attempts = $this->session->userdata($attempts_key) ?: 0;
        $login_time = $this->session->userdata($time_key) ?: 0;

        if ($login_attempts >= 5 && (time() - $login_time) < 300) {
            $ajax = $this->input->get('ajax');
            if ($ajax == true) {
                echo json_encode(array('result' => false, 'error' => 'Muitas tentativas. Aguarde 5 minutos.'));
            } else {
                $this->session->set_flashdata('error', 'Muitas tentativas de login. Aguarde 5 minutos.');
                redirect('mapos/login');
            }
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('user','User','required|xss_clean|trim');
        $this->form_validation->set_rules('senha','Senha','required|xss_clean|trim');
        $ajax = $this->input->get('ajax');

        if ($this->form_validation->run() == false) {

            if($ajax == true){
                $json = array('result' => false);
                echo json_encode($json);
            }
            else{
                $this->session->set_flashdata('error','Os dados de acesso estão incorretos.');
				redirect('mapos/login');
            }
        }
        else {

            $user = $this->input->post('user');
            $senha_input = $this->input->post('senha');

            // Fetch user by username only (no password in WHERE clause)
            $this->db->where('user', $user);
            $this->db->where('situacao', 1);
            $this->db->limit(1);
            $usuario = $this->db->get('usuarios')->row();

            $autenticado = false;
            if ($usuario) {
                if (password_verify($senha_input, $usuario->senha)) {
                    // bcrypt match
                    $autenticado = true;
                } elseif ($usuario->senha === sha1($senha_input)) {
                    // Legacy SHA1 match — upgrade hash to bcrypt
                    $this->db->set('senha', password_hash($senha_input, PASSWORD_BCRYPT));
                    $this->db->where('idUsuarios', $usuario->idUsuarios);
                    $this->db->update('usuarios');
                    $autenticado = true;
                }
            }

            if($autenticado){
                // Reset rate limiting on success
                $this->session->unset_userdata($attempts_key);
                $this->session->unset_userdata($time_key);

                $dados = array('nome' => $usuario->nome, 'id' => $usuario->idUsuarios,'permissao' => $usuario->permissoes_id , 'logado' => TRUE);
                $this->session->set_userdata($dados);

                if($ajax == true){
                    $json = array('result' => true);
                    echo json_encode($json);
                }
                else{
                    $this->session->set_userdata('idUsuarios', $usuario->idUsuarios);
                    $this->session->set_userdata('user', $user);

                    $data = preg_replace('/[^0-9\-]/', '', date("d-m-y"));
                    $hora = date("H:i:s");
                    $ip = $this->input->ip_address();
                    $computador = preg_replace('/[^a-zA-Z0-9_\-]/', '', (string)getenv("USERNAME"));
                    $msg = "LOGIN";

                    $pasta = "application/logs/";
                    $arquivo = $pasta . "Log_" . $data . ".txt";
                    $texto = "\n[$hora][" . htmlspecialchars($user, ENT_QUOTES) . "][$ip][$computador]> $msg";

                    $manipular = fopen($arquivo, "a+b");
                    fwrite($manipular, $texto);
                    fclose($manipular);

                    redirect(base_url());
                }
            }
            else{
                // Increment rate limiting counter on failure
                $this->session->set_userdata($attempts_key, $login_attempts + 1);
                $this->session->set_userdata($time_key, time());

                if($ajax == true){
                    $json = array('result' => false);
                    echo json_encode($json);
                }
                else{
                    $this->session->set_flashdata('error','Os dados de acesso estão incorretos.');
                    redirect('mapos/login');
                }
            }

        }

    }


    public function backup(){

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){
           $this->session->set_flashdata('error','Você não tem permissão para efetuar backup.');
           redirect(base_url());
        }

        
        
        $this->load->dbutil();
        $prefs = array(
                'format'      => 'zip',
                'filename'    => 'backup'.date('d-m-Y').'.sql'
              );

        $backup =& $this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file(base_url().'backup/backup.zip', $backup);

        $this->load->helper('download');
        force_download('backup'.date('d-m-Y H:m:s').'.zip', $backup);
    }


    public function emitente(){

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Você não tem permissão para configurar emitente.');
           redirect(base_url());
        }

        // $this->data['results'] = $this->mapos_model->get('emitente');
        $data['menuConfiguracoes'] = 'Configuracoes';
        //$data['dados'] = $this->mapos_model->getEmitente();
        $data['dados'] = $this->mapos_model->getEmitente();
        $data['view'] = 'mapos/emitente';
        $this->load->view('tema/topo',$data);
        $this->load->view('tema/rodape');
    }

    function do_upload(){
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Você não tem permissão para configurar emitente.');
           redirect(base_url());
        }

        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads/emitente';

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = array(
            'upload_path'   => $image_upload_folder,
            'allowed_types' => 'png|jpg|jpeg|bmp',
            'max_size'      => 2048,
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE,
        );

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            log_message('error', 'Upload error: ' . strip_tags($upload_error));
            show_error('Erro no upload do arquivo.', 400);

        } else {
            $file_info = array($this->upload->data());
            return $file_info[0]['file_name'];
        }

    }


    public function cadastrarEmitente() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('index.php/mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Você não tem permissão para configurar emitente.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome','Razão Social','required|xss_clean|trim');
        $this->form_validation->set_rules('cnpj','CNPJ','required|xss_clean|trim');
        $this->form_validation->set_rules('ie','IE','required|xss_clean|trim');
        $this->form_validation->set_rules('logradouro','Logradouro','required|xss_clean|trim');
        $this->form_validation->set_rules('numero','Número','required|xss_clean|trim');
        $this->form_validation->set_rules('bairro','Bairro','required|xss_clean|trim');
        $this->form_validation->set_rules('cidade','Cidade','required|xss_clean|trim');
        $this->form_validation->set_rules('uf','UF','required|xss_clean|trim');
        $this->form_validation->set_rules('telefone','Telefone','required|xss_clean|trim');
        $this->form_validation->set_rules('email','E-mail','required|xss_clean|trim');
        $this->form_validation->set_rules('email_compras','E-mail compras','required|xss_clean|trim');


        

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/mapos/emitente');
            
        } 
        else {

            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $email_compras = $this->input->post('email_compras');
            $image = $this->do_upload();
            $logo = $image;
            $caminho = 'assets/uploads/emitente/';


            $retorno = $this->mapos_model->addEmitente($nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf,$telefone,$email, $logo,$caminho,$email_compras);
            if($retorno){

                $this->session->set_flashdata('success','As informações foram inseridas com sucesso.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            else{
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar inserir as informações.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            
        }
    }


    public function editarEmitente(){
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('index.php/mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Você não tem permissão para configurar emitente.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome','Razão Social','required|xss_clean|trim');
        $this->form_validation->set_rules('cnpj','CNPJ','required|xss_clean|trim');
        $this->form_validation->set_rules('ie','IE','required|xss_clean|trim');
        $this->form_validation->set_rules('logradouro','Logradouro','required|xss_clean|trim');
        //$this->form_validation->set_rules('numero','Número','required|xss_clean|trim');
        $this->form_validation->set_rules('bairro','Bairro','required|xss_clean|trim');
        $this->form_validation->set_rules('cidade','Cidade','required|xss_clean|trim');
        $this->form_validation->set_rules('uf','UF','required|xss_clean|trim');
        $this->form_validation->set_rules('telefone','Telefone','required|xss_clean|trim');
        $this->form_validation->set_rules('email','E-mail','required|xss_clean|trim');
        $this->form_validation->set_rules('email_compras','E-mail','required|xss_clean|trim');


        

        if ($this->form_validation->run() == false) {
            
            $this->session->set_flashdata('error','Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/mapos/emitente');
            
        } 
        else {

            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $email_compras = $this->input->post('email_compras');
            $id = $this->input->post('id');


            $retorno = $this->mapos_model->editEmitente($id, $nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf,$telefone,$email,$email_compras);
            if($retorno){

                $this->session->set_flashdata('success','As informações foram alteradas com sucesso.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            else{
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar alterar as informações.');
                redirect(base_url().'index.php/mapos/emitente');
            }
            
        }
    }


    public function editarLogo(){
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('index.php/mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){
           $this->session->set_flashdata('error','Você não tem permissão para configurar emitente.');
           redirect(base_url());
        }

        $id = $this->input->post('id');
        if($id == null || !is_numeric($id)){
           $this->session->set_flashdata('error','Ocorreu um erro ao tentar alterar a logomarca.');
           redirect(base_url().'index.php/mapos/emitente'); 
        }
		//exclui a img correspondente
				 $imglogo = $this->mapos_model->getimagem($id);
			
		
				foreach ($imglogo as $lo) 
				{
					
					$image_path = FCPATH.$lo->url_logo.$lo->imagem;
					
						 
						
					if (file_exists($image_path))
						{
							
						   unlink($image_path);
						   
						}
				}
				
         $this->load->helper('file');
		 
		
        //delete_files(FCPATH .'assets/uploads/');

        $image = $this->do_upload();
        $logo = $image;
        $caminho = 'assets/uploads/emitente/';

        $retorno = $this->mapos_model->editLogo($id,$caminho, $logo);
        if($retorno){

            $this->session->set_flashdata('success','As informações foram alteradas com sucesso.');
            redirect(base_url().'index.php/mapos/emitente');
        }
        else{
            $this->session->set_flashdata('error','Ocorreu um erro ao tentar alterar as informações.');
            redirect(base_url().'index.php/mapos/emitente');
        }

    }

    public function verificarNomeclatura($nome){
        if($nome == "relatorioAlmoxarifado"){
            return  "Relatório Almoxarifado";
        }
        if($nome == "carteiraservico"){
            return  "Carteira de Serviço";
        }
        return $nome;
    }

    public function desenvolvedor(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'desenvolvedor')){
            $this->session->set_flashdata('error','Você não tem permissão.');
            redirect(base_url());
         }
        $data['view'] = 'mapos/desenvolvedor';
        $this->load->view('tema/topo',$data);
    }
    function gerarsubos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'desenvolvedor')){
            $this->session->set_flashdata('error','Você não tem permissão.');
            redirect(base_url());
         }
        $this->load->model('os_model');
        $listOsSemSub = $this->os_model->getOsSubSemSub((!empty($this->input->post("idOs"))?" and os.idOs =".$this->input->post("idOs"):""));
        foreach($listOsSemSub as $r){
            $dataSubOs = array(
                "idOs"=>$r->idOs,
                "idProduto_master"=>$r->idProdutos,
                "idProduto_sub"=>null,
                "posicao"=>0,
                "data_insert"=>date('Y-m-d H:i:s'),
                "quantidade"=>1,
                "idClasse"=>1,
                "ativo"=>1,
                "descricaoOsSub"=>$r->descricao_item
            );
            $this->os_model->add("os_sub",$dataSubOs);
        }
        redirect(base_url().'index.php/mapos/desenvolvedor');
    }
    function gerarescopo(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'desenvolvedor')){
            $this->session->set_flashdata('error','Você não tem permissão.');
            redirect(base_url());
         }
        //$fileName = $this->input->post('name');
        $uploadPath = FCPATH . 'assets/uploads/csv';
        $this->load->library('upload');
        $tipoprod = "sub";
        // Config the upload
        //$config['upload_path'] = $uploadPath; // some directory on the server with write permission
        
        // CHecking if present else create one
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, DIR_WRITE_MODE, true);
        }
        $this->upload_config = array(
            'upload_path'   => $uploadPath,
            'allowed_types' => '*',
            // 'max_size'      => 2048,
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE,
        );
        
        // Set file name
        //$config['file_name'] = $fileName;

        // Load the library with config
        
        $this->upload->initialize($this->upload_config);
        // Do the upload

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            log_message('error', 'Upload error: ' . strip_tags($upload_error));
            show_error('Erro no upload do arquivo.', 400);

        } else {
            $arquivo = $this->upload->data();
            $csvFile = $uploadPath .'/'. $arquivo['file_name'];/*
            $arr = array_map('str_getcsv', file($csvFile));
            echo json_encode($arr);*/
            
            /**/
            // Read the CSV file
            $row = 1;
            // Open the file and adjust the code as per your need
        
            
            $this->load->model('produtos_model');
            $this->load->model('peritagem_model');
            $idEscopo=0;
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $data2 =$data[0];
                    if($row == 1){
                        $data2 = str_replace(".","",$data2);
                        $data2 = str_replace("-","",$data2);
                        //$data2 = str_replace(" ","",$data2);
                        $data2 = explode(";",$data2);
                        $data2[1] = str_replace(" ","",$data2[1]);
                        $produto = $this->produtos_model->getByPn2($data2[1]);                        
                        if(empty($produto)){
                            $dataProduto = array(
                                "pn"=>$data2[1],
                                "descricao"=>$data2[3],
                                "referencia"=>$data2[4],
                                "fornecedor_original"=>$data2[5],
                                "equipamento"=>$data2[6],
                                "subconjunto"=>$data2[7],
                                "modelo"=>$data2[8]
                            );
                            $idProdutoMaster = $this->produtos_model->add("produtos",$dataProduto,true);
                            $produto = $this->produtos_model->getById($idProdutoMaster->idProdutos); 
                        }else{
                            $idProdutoMaster = $produto->idProdutos;
                        }
                        $escopo = $this->peritagem_model->getEscopoByIdProduto($idProdutoMaster,$tipoprod);
                        if(empty($escopo)){
                            $dataEscopo = array(
                                "nomeServicoEscopo"=>$produto->descricao,
                                "idProduto"=>$produto->idProdutos,
                                "tipoServico"=>$tipoprod,
                            );
                            $idEscopo = $this->peritagem_model->add("servico_escopo",$dataEscopo,true);
                        }else{
                            $idEscopo = $escopo->idServicoEscopo;
                        }
                    }else if($row !=2){
                        $data2 = str_replace(".","",$data2);
                        $data2 = str_replace("-","",$data2);
                        //$data2 = str_replace(" ","",$data2);
                        $data2 = explode(";",$data2);
                        $data2[1] = str_replace(" ","",$data2[1]);
                        $produtoSub = $this->produtos_model->getByPn2($data2[1]);                        
                        if(empty($produtoSub)){
                            $dataProduto = array(
                                "pn"=>$data2[1],
                                "descricao"=>$data2[3],
                                "referencia"=>$data2[4],
                                "fornecedor_original"=>$data2[5],
                                "equipamento"=>$data2[6],
                                "subconjunto"=>$data2[7],
                                "modelo"=>$data2[8]
                            );
                            $idProdutoSub = $this->produtos_model->add("produtos",$dataProduto,true);
                            $produtoSub = $this->produtos_model->getById($idProdutoSub);
                        }else{
                            $idProdutoSub = $produtoSub->idProdutos;
                        }
                        $escopoItens = $this->peritagem_model->getEscopoItensByIdEscopoAndIdProduto($idEscopo,$idProdutoSub);
                        if(empty($escopoItens)){
                            $dataEscopoItensServico = array(
                                "idServicoEscopo"=>$idEscopo,
                                "idProduto"=>$idProdutoSub,
                                "descricaoServicoItens"=>"Recuperar ".$produtoSub->descricao,
                                "idClasse"=>1,
                                "ativo"=>1
                            );
                            $dataEscopoItensFab = array(
                                "idServicoEscopo"=>$idEscopo,
                                "idProduto"=>$idProdutoSub,
                                "descricaoServicoItens"=>"Substituir ".$produtoSub->descricao,
                                "idClasse"=>2,
                                "ativo"=>1
                            );
                            $this->peritagem_model->add("servico_escopo_itens",$dataEscopoItensServico);
                            $this->peritagem_model->add("servico_escopo_itens",$dataEscopoItensFab);
                        }
                    }
                    //echo "<p> $num fields in line $row: <br /></p>\n";
                    $row++;/*
                    for ($c=0; $c < $num; $c++) {
                        echo $data[$c] . "<br />\n";
                    }*/
                }
                fclose($handle);
            }
        }
        redirect(base_url().'index.php/mapos/desenvolvedor');
       
    }

    function carregarPlanilhaMP(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'desenvolvedor')){
            $this->session->set_flashdata('error','Você não tem permissão.');
            redirect(base_url());
         }
        //$fileName = $this->input->post('name');
        $uploadPath = FCPATH . 'assets/uploads/csv';
        $this->load->library('upload');
        $tipoprod = "sub";
        // Config the upload
        //$config['upload_path'] = $uploadPath; // some directory on the server with write permission
        
        // CHecking if present else create one
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, DIR_WRITE_MODE, true);
        }
        $this->upload_config = array(
            'upload_path'   => $uploadPath,
            'allowed_types' => '*',
            // 'max_size'      => 2048,
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE,
        );
        
        // Set file name
        //$config['file_name'] = $fileName;

        // Load the library with config
        
        $this->upload->initialize($this->upload_config);
        // Do the upload

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            log_message('error', 'Upload error: ' . strip_tags($upload_error));
            show_error('Erro no upload do arquivo.', 400);

        } else {
            $arquivo = $this->upload->data();
            $csvFile = $uploadPath .'/'. $arquivo['file_name'];/*
            $arr = array_map('str_getcsv', file($csvFile));
            echo json_encode($arr);*/
            
            /**/
            // Read the CSV file
            $row = 1;
            // Open the file and adjust the code as per your need
        
            $idUser = 51;
            $this->load->model('insumos_model');
            $this->load->model('pedidocompra_model');
            $this->load->model('almoxarifado_model');
            $html = "<table>". 
                "<thead>". 
                    "<tr>".
                        "<th>Descrição".
                        "</th>".
                        "<th>Quantidade".
                        "</th>".
                        "<th>Valor".
                        "</th>". 
                    "</tr>". 
                "</thead>". 
                "<tbody>";
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE && $row<=520) {
                    $num = count($data);
                    $data2 =$data[1];
                    /*if(isset($data)){
                        echo json_encode($data);
                        echo "</br>";
                    }*/
                    
                    if($row > 1){
                        $data2 = str_replace("mm","",$data2);
                        $data2 = str_replace("MM","",$data2);
                        $data2 = str_replace(" ","",$data2);
                        $data2 = str_replace('"','\"',$data2);
                        if(!empty($data2)){
                            $descricao = $this->pedidocompra_model->getDescricaoInsumo($data2);
                            
                            $local = $data[5].$data[6];
                            if(!empty($descricao)){
                                $descricao->idDistribuir;
                                $objDistribuir = $this->pedidocompra_model->getdistribuidorById($descricao->idDistribuir);
                                if(!empty($local)){
                                    $objLocal = $this->almoxarifado_model->getLocal(1,4,$local);
                                    if(!empty($objLocal)){                                    
                                        $l = $objLocal[0]->idAlmoEstoqueLocais;
                                    }else{
                                        $l = $this->almoxarifado_model->cadastrarLocal(1,$local,4);
                                    }
                                }else{
                                    $l = null;
                                }
                                
                                $estoqueExistente = $this->almoxarifado_model->verificaPMEL($objDistribuir->idInsumos,0,null,null,null,null,null,null,1,$l,4,null);
                                if(empty($estoqueExistente)){
                                    $this->almoxarifado_model->criarEstoqueEntrada($objDistribuir->idInsumos,0,null,null,null,null,null,null,1,$l,$data[2],$idUser,null,null,(empty($data[3])?$objDistribuir->valor_unitario:$data[3]),4);
                                    $idAlmoDestino = $this->almoxarifado_model->criarEstoque($objDistribuir->idInsumos,0,null,null,null,null,null,null,1,$l,$data[2],4,null);
                                }else{
                                    $this->almoxarifado_model->criarEstoqueEntrada($objDistribuir->idInsumos,0,null,null,null,null,null,null,1,$l,$data[2],$idUser,null,null,(empty($data[3])?$objDistribuir->valor_unitario:$data[3]),4);
                                    $newQtdEstoqueAntigo = $estoqueExistente[0]->quantidade + $data[2];
                                    $this->almoxarifado_model->updateEstoque($estoqueExistente[0]->idAlmoEstoque,$newQtdEstoqueAntigo,4);
                                }
                                
                            }else{
                                $descricao = $this->pedidocompra_model->getDescricaoInsumo2($data2);
                                if(!empty($descricao)){                                    
                                    $insumo = $descricao->idInsumos;
                                }else{
                                    $data3 = array(
                                        "idSubCategoria"=>592,
                                        "descricaoInsumo"=>$data[1],
                                        "estoqueminimo"=>0,
                                        "pn_insumo"=>null,
                                        "localizacao"=>null
                                    );
                                    $insumo = $this->almoxarifado_model->add("insumos",$data3,true);
                                }
                                
                                $objLocal = $this->almoxarifado_model->getLocal(1,4,$local);
                                if(!empty($local)){
                                    if(!empty($objLocal)){
                                        $l = $objLocal[0]->idAlmoEstoqueLocais;
                                    }else{
                                        $l = $this->almoxarifado_model->cadastrarLocal(1,$local,4);
                                    }
                                }else{
                                    $l = null;
                                }
                                $this->almoxarifado_model->criarEstoqueEntrada($insumo,0,null,null,null,null,null,null,1,$l,$data[2],$idUser,null,null,(empty($data[3])?0:$data[3]),4);
                                $idAlmoDestino = $this->almoxarifado_model->criarEstoque($insumo,0,null,null,null,null,null,null,1,$l,$data[2],4,null);
                                if(empty($data[3])){
                                    $html .= "<tr>";
                                        $html .= "<td>";
                                            $html .= $data[1];
                                        $html .= "</td>";
                                        $html .= "<td>";
                                            $html .= $data[2];
                                        $html .= "</td>";
                                        $html .= "<td>0,00";
                                        $html .= "</td>";
                                    $html .= "</tr>";
                                }
                            }
                        }
                        
                    }/**/
                    
                    $row++;
                }
                fclose($handle);
            }
            $html .= "</tbody>";
            $html .= "</table>";
            echo $html;
        }
    }

    function substituirEscopoPadraoCilindro(){
        $this->load->model('peritagem_model');
        $obj = $this->peritagem_model->getAllEscopoByTipoProd();
        
        foreach($obj as $v){
            if($v->idServicoEscopo != 1){
                //$itens = $this->peritagem_model->getOnlyEscopoItensByIdEscopo($v->idServicoEscopo);
                
                $data2 = array(
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"CAMISA",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"TAMPA",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"ROSCAS",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"ÊMBOLO",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"HASTE",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"PINO GRAXEIRO",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"ESPAÇADOR",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"PARAFUSOS",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"CONEXÕES",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"BUJÃO",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"TRAVA",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo"=>$v->idServicoEscopo,
                        "descricaoServicoItens"=>"KIT DE VEDAÇÃO",
                        "idProduto"=>NULL,
                        "idClasse"=>2,
                        "tipoCampo"=>"input",
                        "ativo"=>1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo" => $v->idServicoEscopo,
                        "descricaoServicoItens" => "Válvula",
                        "idProduto" => null,
                        "idClasse" => 2,
                        "tipoCampo" => "radio",
                        "ativo" => 1,
                        "deletado" => 0
                    ),
                    array(
                        "idServicoEscopo" => $v->idServicoEscopo,
                        "descricaoServicoItens" => "Montagem",
                        "idProduto" => null,
                        "idClasse" => 1,
                        "tipoCampo" => "check",
                        "ativo" => 1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo" => $v->idServicoEscopo,
                        "descricaoServicoItens" => "Testar",
                        "idProduto" => null,
                        "idClasse" => 1,
                        "tipoCampo" => "check",
                        "ativo" => 1,
                        "deletado"=>0
                    ),
                    array(
                        "idServicoEscopo" => $v->idServicoEscopo,
                        "descricaoServicoItens" => "Pintura",
                        "idProduto" => null,
                        "idClasse" => 1,
                        "tipoCampo" => "check",
                        "ativo" => 1,
                        "deletado"=>0
                    )
                );
                $escopoExcessao = $this->peritagem_model->getEscopoSePreenchido($v->idServicoEscopo);
                if(empty($escopoExcessao)){
                    $this->peritagem_model->delete("servico_escopo_itens","idServicoEscopo",$v->idServicoEscopo); 
                    $this->peritagem_model->insert_batch("servico_escopo_itens",$data2);
                    $orcescopo = $this->peritagem_model->getAllOrcEscopoByIdEscopo($v->idServicoEscopo);
                    $itens = $this->peritagem_model->getOnlyEscopoItensByIdEscopo($v->idServicoEscopo);
                    foreach($orcescopo as $c){
                        $this->peritagem_model->delete("orc_servico_escopo_itens","idOrcServicoEscopo",$c->idOrcServicoEscopo);
                        foreach($itens as $b){
                            $data3 = array(
                                'idServicoEscopoItens' => $b->idServicoEscopoItens,
                                'idOrcServicoEscopo' => $c->idOrcServicoEscopo,
                                'ativo' => $b->ativo
                            );
                            $this->peritagem_model->add("orc_servico_escopo_itens",$data3);
                        }
                    }
                }
            }
        }
        redirect(base_url().'index.php/mapos/desenvolvedor');
    }
    function equalizarHistoricoEstoque(){
        //$negativos = $this->almoxarifado_model->compareEntradaSaidaNegativos();
        $divergencias = $this->almoxarifado_model->compareEntradaSaida();

    }
    
}
