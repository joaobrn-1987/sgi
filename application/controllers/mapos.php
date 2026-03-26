<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mapos_model','',TRUE);
        
    }
    // NOVA FUNÇÃO PARA A PÁGINA DE ESTOQUE DO CLIENTE
    public function estoque() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'clientes')){
            $this->session->set_flashdata('error','Você não tem permissão para acessar esta página.');
            redirect(base_url());
        }

        $this->load->model('almoxarifado_model');
        $this->data['estoque'] = $this->almoxarifado_model->getEstoqueProduto2();
        $this->data['view'] = 'estoque/estoque';
        $this->load->view('menu/principal', $this->data);
    }
    public function index() {
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        // --- INÍCIO DA MODIFICAÇÃO ---
        if($this->permission->checkPermission($this->session->userdata('permissao'),'clientes')){
            // Para o usuário 'clientes', a página inicial será a de consulta de OS.
            // O menu no template 'menu/principal' permitirá a navegação para o estoque.
            redirect('os/cliente_visualizar_os');
        
        } else {
            // Lógica para os outros usuários (usuários internos)
            if($this->permission->checkPermission($this->session->userdata('permissao'),'fComercial')){
                $this->load->model('os_model');
                $listaOsReagendadas = $this->os_model->getOsReagendada();
                $resultado = array();
                foreach($listaOsReagendadas as $v){
                    // ... (seu código original para usuários internos foi mantido) ...
                    $conttDRep = 0;
                    $objDadosAlteracao = "";
                    $arrayAlteracoesDataReprogramada = [];
                    $anteriorDReprogramada = null;
                    $resultAlteracoesOs = $this->os_model->getHisStatusOs($v->idOs);
                    foreach($resultAlteracoesOs as $r){
                        if($conttDRep == 0){
                            $anteriorDReprogramada = $r->data_reagendada;
                            array_push($arrayAlteracoesDataReprogramada,$r);
                            $conttDRep = 1;
                        }else{
                            if($anteriorDReprogramada != $r->data_reagendada){
                                array_push($arrayAlteracoesDataReprogramada,$r);
                                $anteriorDReprogramada = $r->data_reagendada;
                            }else{
                                $arrayAlteracoesDataReprogramada[count($arrayAlteracoesDataReprogramada)-1] = $r;
                            }
                        }
                    }
                    if($arrayAlteracoesDataReprogramada){
                        if(count($arrayAlteracoesDataReprogramada)>1){
                            $objDadosAlteracao = array(
                                "idOs"=>$v->idOs,
                                "data_reagendada"=>$arrayAlteracoesDataReprogramada[0]->data_reagendada,
                                "data_anterior"=>($arrayAlteracoesDataReprogramada[1]->data_reagendada?$arrayAlteracoesDataReprogramada[1]->data_reagendada:$arrayAlteracoesDataReprogramada[0]->data_entrega),
                                "nomeUser"=>$arrayAlteracoesDataReprogramada[0]->nome,
                                "data_ocorrencia"=>$arrayAlteracoesDataReprogramada[0]->data_alteracaoHis,
                                "data_planejada" => $arrayAlteracoesDataReprogramada[0]->data_planejada
                                
                            );
                            array_push($resultado,(object)$objDadosAlteracao);
                        }else{
                            $objDadosAlteracao = array(
                                "idOs"=>$v->idOs,
                                "data_reagendada"=>$arrayAlteracoesDataReprogramada[0]->data_reagendada,
                                "data_anterior"=>$arrayAlteracoesDataReprogramada[0]->data_entrega,
                                "nomeUser"=>$arrayAlteracoesDataReprogramada[0]->nome,
                                "data_ocorrencia"=>$arrayAlteracoesDataReprogramada[0]->data_alteracaoHis,
                                "data_planejada" => $arrayAlteracoesDataReprogramada[0]->data_planejada
                            );
                            array_push($resultado,(object)$objDadosAlteracao);
                        }
                    }
                }
                usort($resultado,function($a,$b){return new DateTime($a->data_ocorrencia) <=> new DateTime($b->data_ocorrencia);});
                $this->data['alteracoes'] = $resultado;
            }
            $this->data['menuPainel'] = 'Painel';
            $this->data['view'] = 'mapos/painel';
            $this->load->view('tema/topo',  $this->data);
        }
        // --- FIM DA MODIFICAÇÃO ---
      
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
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Pragma: no-cache');
        $this->load->view('mapos/login');
    }
    public function sair(){
        $this->session->sess_destroy();
        redirect('mapos/login');
    }


   public function verificarLogin(){

        $this->load->library('form_validation');
        $this->form_validation->set_rules('user','User','required|xss_clean|trim');
        $this->form_validation->set_rules('senha','Senha','required|xss_clean|trim');
        $ajax = $this->input->get('ajax');

        // SEGURANÇA: rate limiting persistente em banco de dados
        $ip = $this->input->ip_address();
        $janela = 300; // 5 minutos
        $max_tentativas = 5;
        $agora = time();
        $limite = date('Y-m-d H:i:s', $agora - $janela);

        $raw_attempts = $this->session->userdata('login_attempts');
        $tentativas = is_array($raw_attempts) ? $raw_attempts : [];
        // Filtrar tentativas dentro da janela
        $tentativas = array_filter($tentativas, function($t) use ($agora, $janela) {
            return is_numeric($t) && ($agora - $t) < $janela;
        });

        if (count($tentativas) >= $max_tentativas) {
            $msg = 'Muitas tentativas de login. Aguarde alguns minutos.';
            if ($ajax) {
                echo json_encode(['result' => false, 'message' => $msg]);
            } else {
                $this->session->set_flashdata('error', $msg);
                redirect('mapos/login');
            }
            return;
        }

        if ($this->form_validation->run() == false) {
            if($ajax == true){
                $json = array('result' => false);
                echo json_encode($json);
            }
            else{
                $this->session->set_flashdata('error','Os dados de acesso estão incorretos.');
                redirect('mapos/login');
            }
            return;
        }

        $user  = $this->input->post('user');
        $senha = $this->input->post('senha');

        // SEGURANÇA: buscar usuário apenas pelo username (sem comparar senha no SQL)
        $this->db->where('user', $user);
        $this->db->where('situacao', 1);
        $this->db->limit(1);
        $usuario = $this->db->get('usuarios')->row();

        $autenticado = false;
        if ($usuario !== null) {
            $hash = $usuario->senha;
            // SEGURANÇA: suporte a bcrypt (novos) e SHA1 (legado) com upgrade automático
            if (strlen($hash) === 40 && ctype_xdigit($hash)) {
                // Hash SHA1 legado — verificar e migrar para bcrypt
                if (hash_equals($hash, sha1($senha))) {
                    $autenticado = true;
                    $novo_hash = password_hash($senha, PASSWORD_BCRYPT);
                    $this->db->set('senha', $novo_hash);
                    $this->db->where('idUsuarios', $usuario->idUsuarios);
                    $this->db->update('usuarios');
                }
            } else {
                // Hash bcrypt
                $autenticado = password_verify($senha, $hash);
            }
        }

        if ($autenticado) {
            // Resetar tentativas de login
            $this->session->set_userdata('login_attempts', []);

            $dados = array(
                'nome'      => $usuario->nome,
                'id'        => $usuario->idUsuarios,
                'permissao' => $usuario->permissoes_id,
                'logado'    => TRUE
            );
            $this->session->set_userdata($dados);

            if($ajax == true){
                echo json_encode(['result' => true]);
            } else {
                $this->session->set_userdata('idUsuarios', $usuario->idUsuarios);
                $this->session->set_userdata('user', $user);

                // Log de acesso
                $data = date("d-m-y");
                $hora = date("H:i:s");
                $ip_log = $ip;
                $pasta = APPPATH . "logs/";
                $arquivo = $pasta . "Log_$data.txt";
                $texto = "\n[$hora][$user][$ip_log]> LOGIN";
                $manipular = fopen($arquivo, "a+b");
                if ($manipular) {
                    fwrite($manipular, $texto);
                    fclose($manipular);
                }

                redirect(base_url());
            }
        } else {
            // SEGURANÇA: registrar tentativa falha
            $tentativas[] = $agora;
            $this->session->set_userdata('login_attempts', array_values($tentativas));

            if($ajax == true){
                echo json_encode(['result' => false]);
            } else {
                $this->session->set_flashdata('error','Os dados de acesso estão incorretos.');
                redirect('mapos/login');
            }
        }
    }



    public function backup(){
        //ini_set("memory_limit","900M");

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
    public function backup2(){
        //ini_set("memory_limit","900M");
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
            redirect('mapos/login');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){
           $this->session->set_flashdata('error','Você não tem permissão para efetuar backup.');
           redirect(base_url());
        }
        date_default_timezone_set('America/Fortaleza');
        $date = new DateTime(date('Y-m-d H:i:s'));
        //echo $date;
        $date2 = date('Y-m-d H:i:s');
        $tosub = new DateInterval('PT58M');
        $objBackup = $this->mapos_model->getBackupLast1Hours($date->sub($tosub)->format('Y-m-d H:i:s'),$date2);
        if(!$objBackup){            
           
            $this->load->dbutil();
            $prefs = array(
                'format'      => 'zip',
                'filename'    => 'backup'.date('d-m-Y').'.sql'
            );
    
            $dados = array(
                "idUser"=>$this->session->userdata('idUsuarios'),
                "data_backup"=>date('Y-m-d H:i:s')
            );
            $this->mapos_model->add("backup_hist",$dados);
            $backup =& $this->dbutil->backup($prefs);
    
            $this->load->helper('file');
            write_file(base_url().'backup/backup.zip', $backup);
    
            $this->load->helper('download');
            force_download('backup__data_'.$this->clean(date('d-m-Y H:i:s')).'__from_'.$this->clean(base_url()).'.zip', $backup);

            //echo json_encode(array("result"=>true,"link"=>base_url().'backup/backup.zip',"backup"=>$backup));
            //return;
        }
        echo "<script  type=\"text/javascript\" charset=\"utf8\" src=\"". base_url()."assets/js/jquery-1-11-13.js\"></script><script type='text/javascript'>$(document).ready(function() {window.close()});</script>";
        //echo json_encode(array("result"=>false));
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
            print_r($upload_error);
            exit();
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
            
        } else {

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
            print_r($upload_error);
            exit();
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

    function cadastrarprodutos(){
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
            print_r($upload_error);
            exit();
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
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $data2 =$data[0];
                    
                    $data2 = str_replace(".","",$data2);
                    $data2 = str_replace("-","",$data2);
                    //$data2 = str_replace(" ","",$data2);
                    $data2 = explode(";",$data2);
                    $produtoSub = $this->produtos_model->getByPn2($data2[0]);                        
                    if(empty($produtoSub)){
                        $dataProduto = array(
                            "pn"=>$data2[0],
                            "descricao"=>$data2[1],
                            "referencia"=>"",
                            "fornecedor_original"=>"",
                            "equipamento"=>"",
                            "subconjunto"=>"",
                            "modelo"=>""
                        );
                        $idProdutoSub = $this->produtos_model->add("produtos",$dataProduto,true);
                        $produtoSub = $this->produtos_model->getById($idProdutoSub);
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
            print_r($upload_error);
            exit();
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
        $this->load->model('almoxarifado_model');
        $divergencias = $this->almoxarifado_model->compareEntradaSaida();
        $arrayEntrada = "";
        $arraySaida = "";
        foreach($divergencias as $r){
            /*
            $todos = array_merge($this->almoxarifado_model->getAllEntradaByIdInsumoAndIdEmitenteAndIdDepartamento($r->idInsumos,$r->id,$r->idAlmoEstoqueDep),$this->almoxarifado_model->getAllSaidaByIdInsumoAndIdEmitenteAndIdDepartamento($r->idInsumos,$r->id,$r->idAlmoEstoqueDep));
            
            usort($todos,function($a,$b){return new DateTime($a->data_insert) <=> new DateTime($b->data_insert);});
            $soma= 0;
            foreach($todos as $v){
                if($v->tipo == "Saida"){
                    $soma = $soma - $v->quantidade;
                }else{
                    $soma = $soma + $v->quantidade;
                }
                echo $soma;
                echo '<br>';
               
            }*/
            if(($r->quantidade_total - $r->subtracao)>0){
                $data = array(
                    "idProduto" => $r->idInsumos,
                    "metrica" => "0",
                    "quantidade" => ($r->quantidade_total - $r->subtracao),
                    "idEmitente" => $r->id,
                    "idLocal" => null,
                    "idDepartamento" => $r->idAlmoEstoqueDep,
                    "nf" => null,
                    "idOs" => null,
                    "data_entrada" => "2000-01-01",
                    "idUsuario" => 51,
                    "valorUnitario" => 0.00,
                    "ocultar"=>1);
                $arrayEntrada = $arrayEntrada.",".$this->almoxarifado_model->add("almo_estoque_entrada",$data,true);
            }else{
                $data = array(
                    "idAlmoEstoque" => $r->idAlmoEstoque,
                    "idEmpresaDestino" => 1,
                    "idSetor" => 22,
                    "idUserSis" => 51,
                    "idOs" => null,
                    "idAlmoEstoqueUsuario" => 146,
                    "quantidade" => ($r->quantidade_total - $r->subtracao)*-1,
                    "obs" => null,
                    "assinatura" => null,
                    "data_saida" => "2000-01-01",
                    "ocultar"=>1);
                $arraySaida = $arraySaida.",".$this->almoxarifado_model->add("almo_estoque_saida",$data,true);
            }
            
        }
        
        $conteudo = "Entradas ".$arrayEntrada."<br> Saídas ".$arraySaida;
        echo  $conteudo ;
        $fp = fopen("entradas_saidas.txt","wb");

        fwrite($fp,$conteudo);

        fclose($fp);
    }

    function equalizarHistoricoEstoqueProd(){
        //$negativos = $this->almoxarifado_model->compareEntradaSaidaNegativos();
        $this->load->model('almoxarifado_model');
        $divergencias = $this->almoxarifado_model->compareEntradaSaidaProdutos();
        $arrayEntrada = "";
        $arraySaida = "";
        foreach($divergencias as $r){
            /*
            $todos = array_merge($this->almoxarifado_model->getAllEntradaByIdInsumoAndIdEmitenteAndIdDepartamento($r->idInsumos,$r->id,$r->idAlmoEstoqueDep),$this->almoxarifado_model->getAllSaidaByIdInsumoAndIdEmitenteAndIdDepartamento($r->idInsumos,$r->id,$r->idAlmoEstoqueDep));
            
            usort($todos,function($a,$b){return new DateTime($a->data_insert) <=> new DateTime($b->data_insert);});
            $soma= 0;
            foreach($todos as $v){
                if($v->tipo == "Saida"){
                    $soma = $soma - $v->quantidade;
                }else{
                    $soma = $soma + $v->quantidade;
                }
                echo $soma;
                echo '<br>';
               
            }*/
            if(($r->quantidade_total - $r->subtracao)>0){
                $data = array(
                    "idProduto" => $r->idProdutos,
                    "quantidade" => ($r->quantidade_total - $r->subtracao),
                    "idEmitente" => $r->id,
                    "idStatusProduto" => $r->idStatusProduto,
                    "idLocal" => null,
                    "idDepartamento" => $r->idAlmoEstoqueDep,
                    "idOs" => null,
                    "data_entrada" => "2000-01-01",
                    "idUsuario" => 51,
                    "ocultar"=>1);
                $arrayEntrada = $arrayEntrada.",".$this->almoxarifado_model->add("almo_estoque_p_entrada",$data,true);
            }else{
                $data = array(
                    "idAlmoEstoqueProdutos" => $r->idAlmoEstoqueProduto,
                    "idEmpresaDestino" => 1,
                    "idSetor" => 22,
                    "idUserSis" => 51,
                    "idOs" => null,
                    "idAlmoEstoqueUsuario" => 146,
                    "quantidade" => ($r->quantidade_total - $r->subtracao)*-1,
                    "obs" => null,
                    "assinatura" => null,
                    "data_saida" => "2000-01-01",
                    "ocultar"=>1);
                $arraySaida = $arraySaida.",".$this->almoxarifado_model->add("almo_estoque_p_saida",$data,true);
            }
            
        }
        
        $conteudo = "Entradas ".$arrayEntrada."<br> Saídas ".$arraySaida;
        echo  $conteudo ;
        $fp = fopen("entradas_saidas.txt","wb");

        fwrite($fp,$conteudo);

        fclose($fp);
    }
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     
        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
     }
    function itenspn(){
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
            print_r($upload_error);
            exit();
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
            $this->load->model('os_model');
            $this->load->model('peritagem_model');
            $dados = array();
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $pn = $data[0];
                    $objProd = $this->os_model->getLastOsByPn($pn);
                    if($objProd){
                        $dadosOS = array(
                            "pn"=>$pn,
                            "os"=>$objProd->idOs,
                            "quantidade_os"=>$objProd->qtd_os
                        );
                        $materialOs = $this->os_model->getMaterialEntregueByIdOs($objProd->idOs);
                        if($materialOs){
                            foreach($materialOs as $c){
                                array_push($dados,(object)array_merge($dadosOS,(array)$c));
                            }
                        }
                    }
                }
            }
        }
        $fp = fopen('file.csv', 'w');
        $header = array_keys((array)$dados[0]);
        fputcsv($fp, $header, ";"); 
        foreach ($dados as $fields) {
            fputcsv($fp,get_object_vars($fields),";");
        }
        fclose($fp);
    }
    function listapndesenhos(){
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
            print_r($upload_error);
            exit();
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
            $this->load->model('os_model');
            $this->load->model('peritagem_model');
            $this->load->model('desenho_model');
            $dados = array();
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $pn = $data[0];
                    $objProd = $this->desenho_model->getListaPNDesenho($pn);
                    if($objProd){
                        for($x=0;$x<count($objProd);$x++){
                            if (file_exists($objProd[$x]->caminho . $objProd[$x]->imagem)) 
                                copy( $objProd[$x]->caminho . $objProd[$x]->imagem, 'assets/uploads/temporario/'.$pn.' ('.$x.')'.(strpbrk($objProd[$x]->extensao,".")?$objProd[$x]->extensao:".".$objProd[$x]->extensao));
                            else
                                 array_push($dados,(object)array("pn"=>$pn));
                            
                        }
                    }else{
                        //echo ":(";
                        array_push($dados,(object)array("pn"=>$pn));
                    }
                    
                }
            }
        }
        $arquivo = 'assets/uploads/backupListaDesenho.zip';

        // Apaga o backup anterior para que ele não seja compactado junto com o atual.
        if (file_exists($arquivo)) unlink(realpath($arquivo)); 
        
        // diretório que será compactado
        $diretorio = 'assets/uploads/temporario'; // aqui estou compactando a pasta raiz do sistema.
        $rootPath = realpath($diretorio);

       // echo $rootPath;
        
        // Inicia o Módulo ZipArchive do PHP
        $zip = new ZipArchive();
        $zip->open($arquivo, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        // Compactação de subpastas
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        
        // Varre todos os arquivos da pasta
        foreach ($files as $name => $file)
        {
            if (!$file->isDir())
            {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
        
                // Adiciona os arquivos no pacote Zip.
                $zip->addFile($filePath, $relativePath);
            }
        }
        
        // Encerra a criação do pacote .Zip
        $zip->close();
        $fp = fopen('file22.csv', 'w');
        //echo json_encode($dados);
        foreach ($dados as $fields) {
            fputcsv($fp,get_object_vars($fields),";");
        }
        echo "<a href=\"".base_url()."file22.csv\">Não foram encontrados </a></br></br>";
        fclose($fp);
       
        echo "<a href=\"".base_url().$arquivo."\">Click aqui para baixar </a>";

        /*
        if (file_exists($arquivo)) {
            // Forçamos o donwload do arquivo.
            header('Content-Type: application/zip');
            header("Content-Transfer-Encoding: Binary");    
            header("Content-Length: ".filesize($arquivo)); 
            header('Content-Disposition: attachment; filename="'.basename($arquivo).'"');
            //readfile($arquivo);
          }*/
        /*
        //$arquivo = 'backup.zip'; // define o nome do pacote Zip gerado na 9
        if(isset($arquivo) && file_exists($arquivo)){ // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
            switch(strtolower(substr(strrchr(basename($arquivo),"."),1))){ // verifica a extensão do arquivo para pegar o tipo
                case "pdf": $tipo="application/pdf"; break;
                case "exe": $tipo="application/octet-stream"; break;
                case "zip": $tipo="application/zip"; break;
                case "doc": $tipo="application/msword"; break;
                case "xls": $tipo="application/vnd.ms-excel"; break;
                case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
                case "gif": $tipo="image/gif"; break;
                case "png": $tipo="image/png"; break;
                case "jpg": $tipo="image/jpg"; break;
                case "mp3": $tipo="audio/mpeg"; break;
                case "php": // deixar vazio por segurança
                case "htm": // deixar vazio por segurança
                case "html": // deixar vazio por segurança
            }
            header("Content-Type: ".$tipo); // informa o tipo do arquivo ao navegador
            header("Content-Length: ".filesize($arquivo)); // informa o tamanho do arquivo ao navegador
            header("Content-Disposition: attachment; filename=".basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
            readfile($arquivo); // lê o arquivo
            exit; // aborta pós-ações
        }*/
    }
    function listadesenhosbyos(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'desenvolvedor')){
            $this->session->set_flashdata('error','Você não tem permissão.');
            redirect(base_url());
         }
         if(!$this->input->post("idOs")){
            $this->session->set_flashdata('error','Você não informou uma O.S..');
            redirect(base_url());
         }
       
        //$config['file_name'] = $fileName;

        // Load the library with config
        
        // Do the upload
        $idOs = $this->input->post("idOs");
       
            
            /**/
            // Read the CSV file
            $row = 1;
            // Open the file and adjust the code as per your need
        
            
            $this->load->model('produtos_model');
            $this->load->model('os_model');
            $this->load->model('peritagem_model');
            $this->load->model('desenho_model');
            $dados = array();
            
            $objProd = $this->desenho_model->getListaDesenhoByIdOs($idOs);
            if($objProd){
                for($x=0;$x<count($objProd);$x++){
                    if (file_exists($objProd[$x]->caminho . $objProd[$x]->imagem)) 
                        copy( $objProd[$x]->caminho . $objProd[$x]->imagem, 'assets/uploads/temporario/'.$objProd[$x]->nomeArquivo.' ('.$x.')'.(strpbrk($objProd[$x]->extensao,".")?$objProd[$x]->extensao:".".$objProd[$x]->extensao));
                    
                }
            }
            
             
        
        $arquivo = 'assets/uploads/backupListaDesenho.zip';

        // Apaga o backup anterior para que ele não seja compactado junto com o atual.
        if (file_exists($arquivo)) unlink(realpath($arquivo)); 
        
        // diretório que será compactado
        $diretorio = 'assets/uploads/temporario'; // aqui estou compactando a pasta raiz do sistema.
        $rootPath = realpath($diretorio);

       // echo $rootPath;
        
        // Inicia o Módulo ZipArchive do PHP
        $zip = new ZipArchive();
        $zip->open($arquivo, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        // Compactação de subpastas
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        
        // Varre todos os arquivos da pasta
        foreach ($files as $name => $file)
        {
            if (!$file->isDir())
            {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
        
                // Adiciona os arquivos no pacote Zip.
                $zip->addFile($filePath, $relativePath);
            }
        }
        
        // Encerra a criação do pacote .Zip
        $zip->close();
       
       
        echo "<a href=\"".base_url().$arquivo."\">Click aqui para baixar </a>";

        /*
        if (file_exists($arquivo)) {
            // Forçamos o donwload do arquivo.
            header('Content-Type: application/zip');
            header("Content-Transfer-Encoding: Binary");    
            header("Content-Length: ".filesize($arquivo)); 
            header('Content-Disposition: attachment; filename="'.basename($arquivo).'"');
            //readfile($arquivo);
          }*/
        /*
        //$arquivo = 'backup.zip'; // define o nome do pacote Zip gerado na 9
        if(isset($arquivo) && file_exists($arquivo)){ // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
            switch(strtolower(substr(strrchr(basename($arquivo),"."),1))){ // verifica a extensão do arquivo para pegar o tipo
                case "pdf": $tipo="application/pdf"; break;
                case "exe": $tipo="application/octet-stream"; break;
                case "zip": $tipo="application/zip"; break;
                case "doc": $tipo="application/msword"; break;
                case "xls": $tipo="application/vnd.ms-excel"; break;
                case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
                case "gif": $tipo="image/gif"; break;
                case "png": $tipo="image/png"; break;
                case "jpg": $tipo="image/jpg"; break;
                case "mp3": $tipo="audio/mpeg"; break;
                case "php": // deixar vazio por segurança
                case "htm": // deixar vazio por segurança
                case "html": // deixar vazio por segurança
            }
            header("Content-Type: ".$tipo); // informa o tipo do arquivo ao navegador
            header("Content-Length: ".filesize($arquivo)); // informa o tamanho do arquivo ao navegador
            header("Content-Disposition: attachment; filename=".basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
            readfile($arquivo); // lê o arquivo
            exit; // aborta pós-ações
        }*/
    }
    function adicionarvalorentradaalmo(){
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
            print_r($upload_error);
            exit();
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
            $this->load->model('os_model');
            $this->load->model('peritagem_model');
            $this->load->model('pedidocompra_model');
            $this->load->model('almoxarifado_model');
            $this->load->model('desenho_model');
            $dados = array();
            $encontrado = 0;
            $naoencontrado = 0;
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $item = $data;
                    $valor = str_replace("R$","",$item[5]);
                    $valor = str_replace(" ","",$valor);
                    $valor = str_replace(".","",$valor);
                    $valor = str_replace(",",".",$valor);
                    $id = $item[1];
                    $verificar = false;
                    if($id){
                        $ins = explode("/",$id);
                        foreach($ins as $v){
                            if($v){
                                $insumos = $this->almoxarifado_model->getEntrada("WHERE insumos.idInsumos = ".(int)$v);
                                if($insumos){
                                    $verificar = true;
                                    foreach($insumos as $c){
                                        if($c->valorUnitario == 0 || $c->valorUnitario == null){
                                            $c->valorUnitario = $valor;
                                            $this->almoxarifado_model->edit("almo_estoque_entrada",array("valorUnitario"=>$valor),"idAlmoEstoqueEnt",$c->idAlmoEstoqueEnt);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if($verificar){
                        echo $item[2].";".$item[3].";Encontrado</br>";
                        $encontrado++;
                    }  else{
                        echo $item[2].";".$item[3].";Não Encontrado</br>";
                        $naoencontrado++;
                    }             
                }
            }
            echo "<br>";
            echo "<br>";
            echo "qtd. Encontrado: ".$encontrado;
            echo "<br>";
            echo "qtd. Não Encontrado: ".$naoencontrado;

        }
    }

    function carregarPlanilhaLoja(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'desenvolvedor')){
            $this->session->set_flashdata('error','Você não tem permissão.');
            redirect(base_url());
        }
        $uploadPath = FCPATH . 'assets/uploads/csv';
        $this->load->library('upload');
        $tipoprod = "sub";
        
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, DIR_WRITE_MODE, true);
        }
        $this->upload_config = array(
            'upload_path'   => $uploadPath,
            'allowed_types' => '*',
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE,
        );
        
        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            print_r($upload_error);
            exit();
        } else {
            $arquivo = $this->upload->data();
            $csvFile = $uploadPath .'/'. $arquivo['file_name'];
            $row = 1;
        
            
            $this->load->model('produtos_model');
            $this->load->model('os_model');
            $this->load->model('peritagem_model');
            $this->load->model('pedidocompra_model');
            $this->load->model('almoxarifado_model');
            $this->load->model('desenho_model');
            $dados = array();
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $item = explode(";",$data[0]);
                    $qtd = $item[2];
                    $pn = $item[1];
                    $local = $item[0];
                    
                    $itemObj = $this->produtos_model->getByPn2($pn);
                    if($itemObj){
                        $local = str_replace(" ","",$local);
                        $objlocal = $this->almoxarifado_model->getLocal1(1,13,$local);
                        if($objlocal){
                            $idLocal = $objlocal->idAlmoEstoqueLocais;
                        }else{
                            $dataLocal = array(
                                "idEmitente"=>1,
                                "idDepartamento"=>13,
                                "local"=>$local
                            );       
                            $idLocal = $this->almoxarifado_model->add("almo_estoque_locais",$dataLocal,true);                 
                        }

                        $dataEntrada = array(
                            "idProduto"=> $itemObj->idProdutos,
                            "quantidade"=> $qtd,
                            "idEmitente"=> 1,
                            "idDepartamento"=> 13,
                            "idStatusProduto"=> 1,
                            "idLocal"=> $idLocal,
                            "data_entrada"=> date('Y-m-d H:i:s'),
                            "nf"=> null,
                            "valorUnitario"=> 0,
                            "idUsuario" => 51,
                            "idOs"=> null
                        );
                        $idEntrada = $this->almoxarifado_model->add("almo_estoque_p_entrada",$dataEntrada,true);

                        $dataAlmo = array(
                            "idProduto"=> $itemObj->idProdutos,
                            "quantidade"=> $qtd,
                            "idEmitente"=> 1,
                            "idDepartamento"=> 13,
                            "idStatusProduto"=> 1,
                            "idLocal"=> $idLocal,
                            "idOs"=> null
                        );
                        $idAlmo = $this->almoxarifado_model->add("almo_estoque_produtos",$dataAlmo,true);
                    }else{
                       echo $pn." | NÂO TEM " ."<br>";
                    }
                                
                }
            }
        }
    }
    function carregarPlanilhaEP(){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'desenvolvedor')){
            $this->session->set_flashdata('error','Você não tem permissão.');
            redirect(base_url());
        }
        $uploadPath = FCPATH . 'assets/uploads/csv';
        $this->load->library('upload');
        $tipoprod = "sub";
        
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, DIR_WRITE_MODE, true);
        }
        $this->upload_config = array(
            'upload_path'   => $uploadPath,
            'allowed_types' => '*',
            'remove_space'  => TRUE,
            'encrypt_name'  => TRUE,
        );
        
        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            print_r($upload_error);
            exit();
        } else {
            $arquivo = $this->upload->data();
            $csvFile = $uploadPath .'/'. $arquivo['file_name'];
            $row = 1;
        
            
            $this->load->model('produtos_model');
            $this->load->model('os_model');
            $this->load->model('peritagem_model');
            $this->load->model('pedidocompra_model');
            $this->load->model('almoxarifado_model');
            $this->load->model('desenho_model');
            $dados = array();
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $item = explode(";",$data[0]);
                    $qtd = str_replace(" ","",$item[2]);
                    $pn = str_replace(" ","",$item[0]);
                    $local = str_replace(" ","",$item[1]);
                    if($pn){
                        $itemObj = $this->produtos_model->getByPn2($pn);
                        if($itemObj){
                            $local = str_replace(" ","",$local);
                            $objlocal = $this->almoxarifado_model->getLocal1(1,1,$local);
                            if($objlocal){
                                $idLocal = $objlocal->idAlmoEstoqueLocais;
                            }else{
                                $dataLocal = array(
                                    "idEmitente"=>1,
                                    "idDepartamento"=>1,
                                    "local"=>$local
                                );       
                                $idLocal = $this->almoxarifado_model->add("almo_estoque_locais",$dataLocal,true);                 
                            }
                            
                            $dataEntrada = array(
                                "idProduto"=> $itemObj->idProdutos,
                                "quantidade"=> $qtd,
                                "idEmitente"=> 1,
                                "idDepartamento"=> 1,
                                "idStatusProduto"=> 2,
                                "idLocal"=> $idLocal,
                                "data_entrada"=> date('Y-m-d H:i:s'),
                                "nf"=> null,
                                "valorUnitario"=> 0,
                                "idUsuario" => 51,
                                "idOs"=> null
                            );
                            $idEntrada = $this->almoxarifado_model->add("almo_estoque_p_entrada",$dataEntrada,true);
    
                            $dataAlmo = array(
                                "idProduto"=> $itemObj->idProdutos,
                                "quantidade"=> $qtd,
                                "idEmitente"=> 1,
                                "idDepartamento"=> 1,
                                "idStatusProduto"=> 2,
                                "idLocal"=> $idLocal,
                                "idOs"=> null
                            );
                            $idAlmo = $this->almoxarifado_model->add("almo_estoque_produtos",$dataAlmo,true);
                            echo $pn." ;Encontrado" ."<br>";
                        }else{
                           echo $pn." ;NÂO Encontrado" ."<br>";
                        }
                    }else{
                        echo "<br>";
                    }
                    
                                
                }
            }
        }
    }
    function carregarSimplex(){
        
        $this->load->model('clientes_model');
        $this->load->model('orcamentos_model');
        $osArray = $this->mapos_model->getOSSimplexPendente();
        foreach($osArray as $os){
            if (empty($os->idSimplexCliente)) {                        
                $resposta2 = json_decode($this->simplexCadastroCliente($os->nomeCliente,$os->cep,$os->documento));
                $data2 = array("idSimplexCliente"=>$resposta2->response->id);
                foreach($osArray as $os2){
                    $os2->idSimplexCliente = $resposta2->response->id;
                }
                echo $this->clientes_model->edit('clientes', $data2, 'idClientes', $os->idClientes,true);
                echo "<br>";
            }
            $response = json_decode($this->simplexCriarOS($os->idSimplexCliente,$os->documento,$os->data_abertura,$os->data_entrega,$os->idOs));
            if($response->status == "success"){
                $data2 = array("idSimplexOs"=>$response->response->id);
                echo $this->orcamentos_model->edit('os', $data2, 'idOs', $os->idOs,true);
                echo "<br>";
                $response2 = json_decode($this->simplexCriarItemOs($response->response->id,$os->qtd_os,$os->descricao_item,0.00));
                if($response2->status == "success"){
                    $data2 = array("idSimplexItemOs"=>$response2->response->id);
                    echo $this->orcamentos_model->edit('os', $data2, 'idOs', $os->idOs,true);
                    echo "<br>";
                }
                $response3 = json_decode($this->simplexCriarAtividade($response->response->id,$os->descricao_item,$os->idOs,'1697560863836x689668401219240000',$os->data_abertura,$os->data_entrega,""));
                if($response3->status == "success"){
                    $data2 = array("idSimplexAtividade"=>$response3->response->id);
                    echo $this->orcamentos_model->edit('os', $data2, 'idOs', $os->idOs,true);
                    echo "<br>";
                }
            }

        }
        
        
    }
    public function simplexCriarOS($idSimplexCliente, $documento, $dataAbertura, $previsaoEntrega, $nova_os)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->item('urlSimplex') . '/post_ordem_execucao',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "local_producao": "1697208705259x215421191803633660",
                "empresa": "1643030479504x771112863746752500",
                "deletado": "no",
                "cnpj_emp": "' . $documento . '",
                "cnpj_fornecedor": "' . $idSimplexCliente . '",
                "cond_pagamento": "À vista",
                "contato": "",
                "data_emissao": "' . $dataAbertura . '",
                "email_fornecedor": "",
                "endereco_entrega": "",
                "fornecedor": "' . $idSimplexCliente . '",
                "solicitante": "",
                "oe_numero": "' . $nova_os . '",
                "previsao_entrega": "' . $previsaoEntrega . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->config->item('tokenSimplex')
            ),
        ));

        $response = curl_exec($curl);
        echo ("<script>console.log('" . $response . "');</script>");
        $err_status = curl_error($curl);
        echo ("<script>console.log('" . $err_status . "');</script>");

        curl_close($curl);
        return $response;
    }
    public function simplexCriarItemOs($idSimplexOs, $quantidade, $descricaoItem, $valor, $pn = '')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->item('urlSimplex') . '/post_item_pc_oc_oe',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '
            {
                "local_producao": "1697208705259x215421191803633660",
                "empresa": "1643030479504x771112863746752500",
                "de_qual_oe": "' . $idSimplexOs . '",
                "descricao_item": "' . $descricaoItem . '",
                "item": "' . $pn . '",
                "nbr": "",
                "frete": "1",
                "grupo_orcamentario": "",
                "grupo_produto": "",
                "unidade_medida":"",
                "impostos": "1",
                "oc": "no",
                "oe": "yes",
                "quantidade": "' . $quantidade . '",
                "valor":"' . $valor . '"
              }
        ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->config->item('tokenSimplex')
            ),
        ));

        $response = curl_exec($curl);
        echo ("<script>console.log('" . $response . "');</script>");
        $err_status = curl_error($curl);
        echo ("<script>console.log('" . $err_status . "');</script>");

        curl_close($curl);
        return $response;
    }
    public function simplexCriarAtividade($idSimplexOs, $descricao, $idOs, $lista, $inicio, $entrega, $cor)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->item('urlSimplex') . '/post_kanban_atividades',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "de_qual_lista": "' . $lista . '",            
            "deletado":"no",
            "descricao_atividade": "' . $descricao . '",
            "local_producao": "1697208705259x215421191803633660",
            "empresa": "1643030479504x771112863746752500",
            "cor": "' . $cor . '",
            "horas_estimadas": "0",
            "prazo_previsto": "0",
            "prazo_realizado": "0",
            "produto_final": "",   
            "servico_controlado": "",   
            "termino_realizado": "0",   
            "inicio_previsto": "0",
            "inicio_realizado": "0",            
            "list_user": [],
            "titulo_atividade_oe": "' . $idSimplexOs . '",
            "inicio_previsto": "' . $inicio . '",
            "termino_previsto": "' . $entrega . '",
            "titulo_atividade": "' . $descricao . '",
            "titulo_atividade_oe_filter": "' . $idOs . '"
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->config->item('tokenSimplex')
            ),
        ));

        $response = curl_exec($curl);
        echo ("<script>console.log('" . $response . "');</script>");
        $err_status = curl_error($curl);
        echo ("<script>console.log('" . $err_status . "');</script>");

        curl_close($curl);
        return $response;
    }

    function simplexCadastroCliente($nomeCliente, $cep, $documento)
    {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->config->item('urlSimplex') . '/post_cadastro_fornecedores');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt(
            $curl,
            CURLOPT_POSTFIELDS,
            '{
            "local_producao": "1697208705259x215421191803633660",
            "empresa": "1643030479504x771112863746752500",
            "deletado":"no",
            "cnpj_cpf": "' . $documento . '",
            "contato": "",
            "email": "",
            "endereco": "' . $cep . '",
            "fornecedor_cliente": "' . $nomeCliente . '",
            "inscricao_estadual": ""}'
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->config->item('tokenSimplex')
        ));
        $response = curl_exec($curl);
        echo ("<script>console.log('" . $response . "');</script>");
        $err_status = curl_error($curl);
        echo ("<script>console.log('" . $err_status . "');</script>");

        curl_close($curl);
        //echo $response;
        return $response;
    }

    function queryfactory(){
        $this->load->model('os_model');
        $this->load->model('desenho_model');
        $os = $this->os_model->getOsFactory();
        $primeiroOs = true;
        echo 'insert into tint_ordem_producao (cod_empresa, codigo, nome, unidade, dt_prev_entrega, quantidade, cod_cliente,campo_add1,campo_add2,campo_add3)
        values ';
        foreach($os as $r){
            $desenho = $this->desenho_model->getDesenhoByIdOs($r->idOs);
            $link = '';
            if(!empty($desenho )){
                $link = 'https://sgisistemas.site/index.php/desenho/downdes/'.$desenho->idAnexo;
            }
            if($primeiroOs){
                $primeiroOs = false;
                
                echo "(1,'".$r->idOs."','".substr($r->descricao_item, 0, 100)."','".$r->descricaoTipoQtd."',convert(datetime,'".$r->data_entrega." 00:00:00',20 ),".$r->qtd_os.",'".$r->idClientes."','".(!empty($desenho)?$link:"")."','".$r->pn."','".$r->status_execucao."')</br>";

            }else{
                echo ",(1,'".$r->idOs."','".substr($r->descricao_item, 0, 100)."','".$r->descricaoTipoQtd."',convert(datetime,'".$r->data_entrega." 00:00:00',20 ),".$r->qtd_os.",'".$r->idClientes."','".(!empty($desenho)?$link:"")."','".$r->pn."','".$r->status_execucao."')</br>";

            }
        }
        echo '<br>';
        echo '<br>';/**/
        $primeiroOs = true;
        echo 'insert into tint_item_producao (cod_empresa, cod_op, codigo, desenho, posicao, predecessora, nome, unidade, quantidade,campo_add1)
        values ';
        foreach($os as $r){
            $desenho = $this->desenho_model->getDesenhoByIdOs($r->idOs);
            $link = '';
            if(!empty($desenho )){
                $link = 'https://sgisistemas.site/index.php/desenho/downdes/'.$desenho->idAnexo;
            }
            if($primeiroOs){
                $primeiroOs = false;
                echo "(1,'".$r->idOs."','".$r->idOs."/001','','01','','".substr($r->descricao_item, 0, 100)."','".$r->descricaoTipoQtd."',".$r->qtd_os.",'".$link."')</br>";

            }else{
                echo ",(1,'".$r->idOs."','".$r->idOs."/001','','01','','".substr($r->descricao_item, 0, 100)."','".$r->descricaoTipoQtd."',".$r->qtd_os.",'".$link."')</br>";

            }
        }
        
        echo '<br>';
        echo '<br>';
        /**/
        $html = "";
        foreach ($os as $r){
            $html .= ",".$r->idOs;
        }
        echo $html;
    }
    public function encurtadorLink($link)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.encurtador.dev/encurtamentos',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '
            {
                "url":"'.$link.'"
            }
        ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        echo ("<script>console.log('" . $response . "');</script>");
        $err_status = curl_error($curl);
        echo ("<script>console.log('" . $err_status . "');</script>");

        curl_close($curl);
        return $response;
    }
}
