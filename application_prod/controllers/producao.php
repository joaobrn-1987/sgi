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
	}	
	
	function index(){
		$this->gerenciar();
	}
    function gerenciar(){
        
    }
    public function autoCompleteOnlyPN(){

        if (isset($_GET['term'])){
			//converte tudo pra maiusculo
            $q = strtoupper($_GET['term']);
			//retira -/.|;,
			$pn = str_replace("-","",$q);
            $this->producao_model->autoCompleteOnlyPN($pn);
        }

    }
    public function autoCompleteOnlyOS(){

        if (isset($_GET['term'])){
			//converte tudo pra maiusculo
            $q = strtoupper($_GET['term']);
			//retira -/.|;,			
            $this->producao_model->autoCompleteOnlyOS($q);
        }

    }
    function adicionarhoramaquina($idHoraMaquina = ''){
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aApontamento')){
            $this->session->set_flashdata('error','Você não tem permissão para adicionar Apontamento.');
            redirect(base_url());
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
        $result->somaInsumos = number_format((float)$result->somaInsumos/$result->qtd_os,'2',',','.');
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
        $resultado= number_format((float)$valorFrete/$result[0]->qtd_os,'2',',','.');
        if(!empty($resultado)){
            $somaFrete = $resultado;
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
}
