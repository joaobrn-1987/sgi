<?php
class Producao extends CI_Controller {
    
    function __construct() {
        parent::__construct();
                if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
                    redirect('mapos/login');
                }
		
		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('producao_model','',TRUE);
        $this->data['menuApontamento'] = 'Produção';   
        $this->data['menuProducao'] = 'producao';
	}	
	
	function index(){
		$this->gerenciar();
	}
    function gerenciar(){
        
    }
    public function autoCompleteOnlyPN(){

        if ($this->input->get('term') !== null){
			//converte tudo pra maiusculo
            $q = strtoupper($this->input->get('term', TRUE));
			//retira -/.|;,
			$pn = str_replace("-","",$q);
            $this->producao_model->autoCompleteOnlyPN($pn);
        }

    }
    public function autoCompleteOnlyOS(){

        if ($this->input->get('term') !== null){
			//converte tudo pra maiusculo
            $q = strtoupper($this->input->get('term', TRUE));
			//retira -/.|;,			
            $this->producao_model->autoCompleteOnlyOS($q);
        }

    }
    function adicionarhoramaquina($idHoraMaquina = ''){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aApontamento')){
            $this->session->set_flashdata('error','Você não tem permissão para adicionar Apontamento.');
            redirect(base_url());
        } 
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }     
        if(!empty($this->uri->segment(3)) || !empty($idHoraMaquina)){
            if(!empty($this->uri->segment(3))){
                $idHoraMaquina  = $this->uri->segment(3);                
            }
            $this->data['horasMaquinasId'] = $this->producao_model->getHoraMaqId($idHoraMaquina);
            $this->data['horasMaqParada'] = $this->producao_model->getHoraMaqParadaForIdHrMaq($idHoraMaquina);
            $this->data['maqPerda'] = $this->producao_model->getMaqPerdaForIdHrMaq($idHoraMaquina);
        }else if(null!=$this->input->post('idOs')){
            if(null!=$this->input->post('idHorasMaquinas')){
                $this->updateHoraMaquina();
                return;
            }else{
                $this->insertHoraMaquina();
                return;
            }
        }
        
        $this->load->model('maquinas_model');
        $this->data['maquinas'] = $this->maquinas_model->getAll();
        $this->data['allHorasMaquinas'] = $this->producao_model->getAllHorasMaquinas($idHoraMaquina);
        $this->data['historicoMaquinas'] = $this->producao_model->getHistoricoHoraMaquinaCompletado();
        $this->data['motivos_parada'] = $this->producao_model->getAllMotivosParada();
        $this->data['motivos_perda'] = $this->producao_model->getAllMotivosPerda();
        $this->data['view'] = 'producao/horasmaquinas';
        $this->load->view('tema/topo', $this->data);
    }
    public function insertHoraMaquina(){
        
        if(!empty($this->input->post('idMaquina'))){
            $idMaquina = $this->input->post('idMaquina');
        }else{
            $idMaquina = null;
        }       
        if(!empty($this->input->post('idOs'))){
            $idOs = $this->input->post('idOs');
        }else{
            $idOs = null;
        } 
        if(!empty($this->input->post('pn'))){
            $pn = $this->input->post('pn');
        }else{
            $pn = null;
        } 
        if(!empty($this->input->post('operacao'))){
            $operacao = $this->input->post('operacao');
        }else{
            $operacao = null;
        }
        if(!empty($this->input->post('qtdPfabricar'))){
            $qtdPfabricar = $this->input->post('qtdPfabricar');
        }else{
            $qtdPfabricar = null;
        }
        if(!empty($this->input->post('qtdEstoque'))){
            $qtdEstoque = $this->input->post('qtdEstoque');
        }else{
            $qtdEstoque = null;
        }
        if(!empty($this->input->post('dataPrepIni'))){
            $dataTime = explode(' ', $this->input->post('dataPrepIni'));
            $date = explode('/', $dataTime[0]);
            $dataPrepIni = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
        }else{
            $dataPrepIni = null;
        }
        if(!empty($this->input->post('dataPrepFinal'))){
            $dataTime = explode(' ', $this->input->post('dataPrepFinal'));
            $date = explode('/', $dataTime[0]);
            $dataPrepFinal = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
        }else{
            $dataPrepFinal = null;
        }
        if(!empty($this->input->post('dataFabIni'))){
            $dataTime = explode(' ', $this->input->post('dataFabIni'));
            $date = explode('/', $dataTime[0]);
            $dataFabIni = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
        }else{
            $dataFabIni = null;
        }
        if(!empty($this->input->post('dataFabFinal'))){
            $dataTime = explode(' ', $this->input->post('dataFabFinal'));
            $date = explode('/', $dataTime[0]);
            $dataFabFinal = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
        }else{
            $dataFabFinal = null;
        }
        if($this->input->post('qtdFabricada') == '0'){
            $qtdFabricada = '0';
        }else if(!empty($this->input->post('qtdFabricada'))){
            $qtdFabricada = $this->input->post('qtdFabricada');
        }else{
            $qtdFabricada = null;
        }
        if(empty($idMaquina) || empty($idOs) || empty($pn) || empty($operacao) || empty($qtdPfabricar)){
            $json = array('result'=>false,'msggg'=>'Máquina, OS, PN, Operação e Quantidade para Fabricar não podem ser vazios.');
            echo json_encode($json);
            return;
        }
        if(empty($this->input->post('idProduto'))){
            $produto = $this->producao_model->findProdutoForPn($pn);
            if(isset($produto->idProdutos)){
                $idProduto = $produto->idProdutos;                
            }else{
                $json = array('result'=>false,'msggg'=>'Este PN não está cadastrado em nosso banco de dados.');
                echo json_encode($json);
                return;
            }
        }else{
            $idProduto = $this->input->post('idProduto');
        }
        
        $data = array(
            'idMaquina'=>$idMaquina,
            'idOs'=>$idOs,
            'idProduto'=>$idProduto,
            'operacao'=>$operacao,
            'quantidadeParaFabricacao'=>$qtdPfabricar,
            'quantidadeFabricada'=>$qtdFabricada,
            'quantidadeEstoque'=>$qtdEstoque,
            'horaEntradaPreparacao'=>$dataPrepIni,
            'horaSaidaPreparacao'=>$dataPrepFinal,
            'horaEntradaFabricacao'=>$dataFabIni,
            'horaSaidaFabricacao'=>$dataFabFinal
        );
        $idHoraMaquina = $this->producao_model->insertHoraMaquina($data);

        $countMotivosParadas = count($this->input->post('idMotivosParada'));
        if($countMotivosParadas > 0){
            for($x=0;$x<$countMotivosParadas;$x++){
                $idMotivoParada = "";
                $dataInicioParada = "";
                $dataFimParada = "";
                $idMotivoParada = $this->input->post('idMotivosParada')[$x];
               
                if(!empty($this->input->post('dataParadaInicio')[$x])){
                    $dataTime = explode(' ', $this->input->post('dataParadaInicio')[$x]);
                    $date = explode('/', $dataTime[0]);
                    $dataInicioParada = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
                }else{
                    $dataInicioParada = null;
                }
                if(!empty($this->input->post('dataParadaFim')[$x])){
                    $dataTime = explode(' ', $this->input->post('dataParadaFim')[$x]);
                    $date = explode('/', $dataTime[0]);
                    $dataFimParada = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
                }else{
                    $dataFimParada = null;
                }
                if(!empty($dataInicioParada) && !empty($idMotivoParada)){
                    $dataParada = array(
                        'idHorasMaquinas'=>$idHoraMaquina,
                        'idMotivosParada'=>$idMotivoParada,
                        'horaInicial'=>$dataInicioParada,
                        'horaFinal'=>$dataFimParada
                    );
                    $this->producao_model->insertHoraMaqParada($dataParada);
                }
            }
        }


        $countMotivosPerdas = count($this->input->post('idMotivosPerda'));
        if($countMotivosPerdas > 0){
            for($x=0;$x<$countMotivosPerdas;$x++){
                $idMotivosPerda = "";
                $quantidadePerda = "";
                $idMotivosPerda = $this->input->post('idMotivosPerda')[$x];
                $quantidadePerda = $this->input->post('quantidadePerda')[$x];
                if(!empty($idMotivosPerda) && !empty($quantidadePerda)){
                    $dataPerda = array(
                        'idHorasMaquinas'=>$idHoraMaquina,
                        'idMotivosPerda'=>$idMotivosPerda,
                        'quantidade'=>$quantidadePerda
                    );
                    $this->producao_model->insertMaqPerda($dataPerda);
                }
            }
        }
        $this->session->set_flashdata('success', 'Hora máquina cadastrada com sucesso!');
        //redirect(base_url() . 'index.php/producao/adicionarhoramaquina/'.$idHoraMaquina);
        $json = array('result'=>true,'redirect'=>base_url().'index.php/producao/adicionarhoramaquina/'.$idHoraMaquina);
        echo json_encode($json);
        //$json = array('result'=>true,'msggg'=>$idHoraMaquina);
        //echo json_encode($json);
    }
    public function updateHoraMaquina(){
        $idHoraMaquina = $this->input->post('idHorasMaquinas');   
        if(!empty($this->input->post('operacao'))){
            $operacao = $this->input->post('operacao');
        }else{
            $operacao = null;
        }
        if(!empty($this->input->post('qtdPfabricar'))){
            $qtdPfabricar = $this->input->post('qtdPfabricar');
        }else{
            $qtdPfabricar = null;
        }
        if(!empty($this->input->post('dataPrepIni'))){
            $dataTime = explode(' ', $this->input->post('dataPrepIni'));
            $date = explode('/', $dataTime[0]);
            $dataPrepIni = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
        }else{
            $dataPrepIni = null;
        }
        if(!empty($this->input->post('dataPrepFinal'))){
            $dataTime = explode(' ', $this->input->post('dataPrepFinal'));
            $date = explode('/', $dataTime[0]);
            $dataPrepFinal = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
        }else{
            $dataPrepFinal = null;
        }
        if(!empty($this->input->post('dataFabIni'))){
            $dataTime = explode(' ', $this->input->post('dataFabIni'));
            $date = explode('/', $dataTime[0]);
            $dataFabIni = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
        }else{
            $dataFabIni = null;
        }
        if(!empty($this->input->post('dataFabFinal'))){
            $dataTime = explode(' ', $this->input->post('dataFabFinal'));
            $date = explode('/', $dataTime[0]);
            $dataFabFinal = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
        }else{
            $dataFabFinal = null;
        }
        if(!empty($this->input->post('qtdFabricada'))){
            $qtdFabricada = $this->input->post('qtdFabricada');
        }else{
            $qtdFabricada = null;
        }   
        if(!empty($this->input->post('qtdEstoque'))){
            $qtdEstoque = $this->input->post('qtdEstoque');
        }else{
            $qtdEstoque = null;
        }   
        $data = array(
            'operacao'=>$operacao,
            'quantidadeParaFabricacao'=>$qtdPfabricar,
            'quantidadeFabricada'=>$qtdFabricada,
            'quantidadeEstoque'=>$qtdEstoque,
            'horaEntradaPreparacao'=>$dataPrepIni,
            'horaSaidaPreparacao'=>$dataPrepFinal,
            'horaEntradaFabricacao'=>$dataFabIni,
            'horaSaidaFabricacao'=>$dataFabFinal
        );
        if($this->producao_model->edit('horas_maquinas',$data,'idHorasMaquinas',$idHoraMaquina) == FALSE){
            $json = array('result'=>false,'msggg'=>'Houve um erro ao atualizar os dados, verifique os dados e tente novamente.');
            echo json_encode($json);
            return;
        }
        $countMotivosParadas = 0;
        if(!empty($this->input->post('idMotivosParada'))){
            $countMotivosParadas = count($this->input->post('idMotivosParada'));
        }else{
            $countMotivosParadas = 0;
        }
        if($countMotivosParadas > 0){
            for($x=0;$x<$countMotivosParadas;$x++){
                $idMotivoParada = "";
                $dataInicioParada = "";
                $dataFimParada = "";
                $idMotivoParada = $this->input->post('idMotivosParada')[$x];
                $resultMotivoParada = $this->producao_model->getHoraMaqParadaForIdMotParadaAndIdHrMaq($idMotivoParada,$idHoraMaquina);
                if(!empty($this->input->post('dataParadaInicio')[$x])){
                    $dataTime = explode(' ', $this->input->post('dataParadaInicio')[$x]);
                    $date = explode('/', $dataTime[0]);
                    $dataInicioParada = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
                }else{
                    $dataInicioParada = null;
                }
                if(!empty($this->input->post('dataParadaFim')[$x])){
                    $dataTime = explode(' ', $this->input->post('dataParadaFim')[$x]);
                    $date = explode('/', $dataTime[0]);
                    $dataFimParada = $date[2].'-'.$date[1].'-'.$date[0].' '.$dataTime[1];
                }else{
                    $dataFimParada = null;
                }

                if(!empty($resultMotivoParada)){
                    if(!empty($dataInicioParada) && !empty($idMotivoParada)){
                        $dataParada = array(
                            'horaInicial'=>$dataInicioParada,
                            'horaFinal'=>$dataFimParada
                        );
                        $this->producao_model->edit('horas_maq_parada',$dataParada,'idHorasMaqParada',$resultMotivoParada->idHorasMaqParada);
                    }
                }else{                    
                    if(!empty($dataInicioParada) && !empty($idMotivoParada)){
                        $dataParada = array(
                            'idHorasMaquinas'=>$idHoraMaquina,
                            'idMotivosParada'=>$idMotivoParada,
                            'horaInicial'=>$dataInicioParada,
                            'horaFinal'=>$dataFimParada
                        );
                        $this->producao_model->insertHoraMaqParada($dataParada);
                    }
                }           
                
            }
        }

        $countMotivosPerdas = 0;
        if(!empty($this->input->post('idMotivosPerda'))){
            $countMotivosPerdas = count($this->input->post('idMotivosPerda'));
        }else{
            $countMotivosPerdas = 0;
        }
        if($countMotivosPerdas > 0){
            for($x=0;$x<$countMotivosPerdas;$x++){
                $idMotivosPerda = "";
                $quantidadePerda = "";
                $idMotivosPerda = $this->input->post('idMotivosPerda')[$x];
                $resultMotPerda = $this->producao_model->getMaqPerdaForIdMotPerdaIdHrMaq($idMotivosPerda,$idHoraMaquina);
                $quantidadePerda = $this->input->post('quantidadePerda')[$x];
                if(!empty($resultMotPerda)){
                    if(!empty($idMotivosPerda) && !empty($quantidadePerda)){
                        $dataPerda = array(
                            'quantidade'=>$quantidadePerda
                        );
                        $this->producao_model->edit('maq_perda',$dataPerda,'idMaqPerda',$resultMotPerda->idMaqPerda);
                    }
                }else{
                    if(!empty($idMotivosPerda) && !empty($quantidadePerda)){
                        $dataPerda = array(
                            'idHorasMaquina'=>$idHoraMaquina,
                            'idMotivosPerda'=>$idMotivosPerda,
                            'quantidade'=>$quantidadePerda
                        );
                        $this->producao_model->insertMaqPerda($dataPerda);
                    }
                }
                
            }
        }
        
        //return;
        $this->session->set_flashdata('success', 'Hora máquina alterado com sucesso!');
        //redirect(base_url().'index.php/producao/adicionarhoramaquina/'.$idHoraMaquina); 
        $json = array('result'=>true,'redirect'=>base_url().'index.php/producao/adicionarhoramaquina/'.$idHoraMaquina);
        echo json_encode($json);       
    }

    public function rel_apontamento(){
        if(!empty($this->input->post('dataFim'))){
            $data = explode('/',$this->input->post('dataFim'));
            $dataFim = $data[2].'-'.$data[1].'-'.$data[0];
        }else{
            $dataFim = date('Y-m-d');            
        }
        if(!empty($this->input->post('dataInicio'))){
            $data = explode('/',$this->input->post('dataInicio'));
            $dataInicio = $data[2].'-'.$data[1].'-'.$data[0];
        }else{
            $dataInicio = date('Y-m-d', strtotime("-30 days"));
        }
        $relatorio = $this->producao_model->getRelatorio($dataInicio,$dataFim);
        $result = [];
        foreach($relatorio as $r){
            if(empty($r->quantidadeFabricada)){
                $r->quantidadeFabricada = 0;
            }
            $verificador = 0;
            if(empty($result)){
                $hrEntrFab = new DateTime($r->horaEntradaFabricacao);
                $hrSaidFab = new DateTime($r->horaSaidaFabricacao);
                $diffDataFabricacao = $hrSaidFab->diff($hrEntrFab);
                $e = new DateTime('00:00');
                $minutos = $diffDataFabricacao->i/60;
                $horas = $minutos + $diffDataFabricacao->h;
                $data = array('idMaquina'=>$r->idMaquina,
                    'idProduto'=>$r->idProdutos,
                    'pn'=>$r->pn,
                    'maquina'=>$r->descricao,
                    'tempoFabricacao'=>$horas,
                    'quantidadeFabricado'=>$r->quantidadeFabricada);
                array_push($result,$data);                
            }else{
                for($x=0;$x<count($result);$x++){
                    if($result[$x]['idMaquina'] == $r->idMaquina && $r->idProdutos == $result[$x]['idProduto']){
                        $verificador = 1;
                        $hrEntrFab = new DateTime($r->horaEntradaFabricacao);
                        $hrSaidFab = new DateTime($r->horaSaidaFabricacao);
                        $diffDataFabricacao = $hrSaidFab->diff($hrEntrFab);
                        //$e = new DateTime('00:00');
                        $minutos = $diffDataFabricacao->i/60;
                        $horas = $minutos + $diffDataFabricacao->h;
                        if(empty($result[$x]['quantidadeFabricada'])){
                            $result[$x]['quantidadeFabricada'] = 0;
                        }
                        
                        $result[$x]['tempoFabricacao'] = $result[$x]['tempoFabricacao']+$horas;
                        $result[$x]['quantidadeFabricada'] = $result[$x]['quantidadeFabricada']+$r->quantidadeFabricada;
                    }
                }
                if($verificador!=1){
                    $hrEntrFab = new DateTime($r->horaEntradaFabricacao);
                    $hrSaidFab = new DateTime($r->horaSaidaFabricacao);
                    $diffDataFabricacao = $hrSaidFab->diff($hrEntrFab);
                    //$e = new DateTime('00:00');
                    $minutos = $diffDataFabricacao->i/60;
                    $horas = $minutos + $diffDataFabricacao->h;
                    $data = array('idMaquina'=>$r->idMaquina,
                        'idProduto'=>$r->idProdutos,
                        'pn'=>$r->pn,
                        'maquina'=>$r->descricao,
                        'tempoFabricacao'=>$horas,
                        'quantidadeFabricado'=>$r->quantidadeFabricada);
                    array_push($result,$data);
                }
            }
        }
        $this->data['relatorio1'] = $result;
        //$this->data['pn'] = $this->producao_model->get();
        $this->data['view'] = 'producao/rel_apontamento';
        $this->load->view('tema/topo', $this->data);
    }
    public function getCustoInsumoPorPN(){
        $result = $this->producao_model->getCustoInsumoPorPN($this->input->post('idProduto'));
        if(!empty($result)){
            $result->somaInsumos = number_format((float)$result->somaInsumos/$result->qtd_os,'2',',','.');
        }
        $json = array('result'=>true,'dados'=>$result);
        echo json_encode($json);
    }
    public function getCustoICMSPorPN(){
        $result = $this->producao_model->getCustoICMSPorPN($this->input->post('idProduto'));
        if(isset($result->somaIcms)){
            $result->somaIcms= number_format((float)$result->somaIcms/$result->qtd_os,'2',',','.');
        }else{
            
            $somaIcms=0;
            $result = (object) $somaIcms;
        }
         
        $json = array('result'=>true,'dados'=>$result);
        echo json_encode($json);
    }
    public function getCustoFretePorPN(){
        $result = $this->producao_model->getCustoFretePorPN($this->input->post('idProduto'));
        $valorFrete = 0;
        foreach($result as $r){
            $valorFrete = $valorFrete + (($r->frete/$r->quantidadeProdutos)*$r->quantidadeProdutosOs);
        }
        if(!empty($valorFrete)){
            $somaFrete = number_format((float)$valorFrete/$result[0]->qtd_os,'2',',','.');
        }else{
            $somaFrete = 0;
        }
        $json = array('result'=>true,'dados'=>$somaFrete);
        echo json_encode($json);
    }
    public function getCustoHrMaqPorPN(){
        $result = $this->producao_model->getCustoHrMaqPorPN($this->input->post('idProduto'));

        if(!empty($result)){
            $horas = 0;
            foreach($result as $r){
                $hrEntrFab = new DateTime($r->horaEntradaFabricacao);
                $hrSaidFab = new DateTime($r->horaSaidaFabricacao);
                $diffDataFabricacao = $hrSaidFab->diff($hrEntrFab);
                //$e = new DateTime('00:00');
                $minutos = $diffDataFabricacao->i/60;
                $horas = $minutos + $diffDataFabricacao->h + $horas;


                $hrEntrPre = new DateTime($r->horaEntradaPreparacao);
                $hrSaidPre = new DateTime($r->horaSaidaPreparacao);
                $diffDataPreparacao = $hrSaidPre->diff($hrEntrPre);
                //$e = new DateTime('00:00');
                $minutos = $diffDataPreparacao->i/60;
                $horas = $minutos + $diffDataPreparacao->h + $horas;                   
            }
            $valor = $horas * 300;
            $valor = $valor/$result[0]->qtd_os;
            $json = array('result'=>true,'dados'=>number_format((float)$valor,'2',',','.'));
            echo json_encode($json);
            return;
        }
        $json = array('result'=>true,'dados'=>'0,00');
        echo json_encode($json);
        return;


        //$json = array('result'=>true,'dados'=>$result);
        //echo json_encode($json);
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



        $config['base_url'] = base_url() . 'index.php/producao/ordemservico/';
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


            $this->data['results'] = $this->os_model->getos('os', 'os.data_abertura_real,os.data_insert,verificacao_controle.*,grupo_servico.*,os.statusDesenho,os.obsDesenho,os.desconto_os,os.val_unit_os,os.numpedido_os,os.tag,os.val_ipi_os,os.idOs,os.`data_abertura`,os.`subtot_os`,os.`data_entrega`,os.`data_reagendada`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,os_tipo.nome_tipo,(SELECT anexo_desenho.idAnexo from anexo_desenho where  anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue,status_os.nomeStatusOs ', '', 'os', $config['per_page'], $this->uri->segment(3));
        }



        $this->data['view'] = 'producao/ordemservico_prod';
        $this->load->view('tema/topo', $this->data);
    }
}
