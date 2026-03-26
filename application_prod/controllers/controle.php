<?php

class Controle extends CI_Controller {
    function __construct() {
        parent::__construct();
        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }
        $this->load->model('producao_model');
		$this->data['menuControle'] = 'Controle';
    }
    function index(){
		$this->gerenciar();
	}
    function gerenciar(){

    }
    function armazenar(){
        $this->data['statusEtapa'] = $this->producao_model->getStatusEtapasServico();
        $this->data['view'] = 'controle/armazenar';
        $this->load->view('tema/topo',$this->data);
    }
    function cadastrarItemControle(){
        $idOrc = null;
        if(!empty($this->input->post('idOrcamento'))){
            $idOrc = $this->input->post('idOrcamento');
        }
        $idOs = null;
        if(!empty($this->input->post('idOs'))){
            $idOs = $this->input->post('idOs');
        }
        $idProduto = $this->input->post('idPn');
        $descItem = $this->input->post('descricaoItem');
        $qtd = $this->input->post('qtd');
        $local = $this->input->post('local');
        $data = array(
            "idOrcamento"=>$idOrc,
            'idOs'=>$idOs,
            "idProduto"=>$idProduto,
            "descricaoItem"=>$descItem,
            "quantidade"=>$qtd,
            "idStatusEtapaServico"=>1,
            "local"=>$local,
            "data_cadastro"=>date('Y-m-d H:i:s')
        );
        $id = $this->producao_model->add("controle_etapa",$data,true);
        $data2 = array(
            "idControleEtapa"=>$id,
            "idStatusEtapaServico"=>1,
            "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
            "data_alteracao"=>date('Y-m-d H:i:s')
        );
        $this->producao_model->add("controle_etapa_hist_status",$data2,true);
        echo json_encode(array("result"=>true));
    }
    function carregarItens(){
        $idOrc = $this->input->post('idOrcamento');
        $idOs = $this->input->post('idOs');
        $idProduto = $this->input->post('pn');
        $descItem = $this->input->post('descricaoItem');
        $statusServico = $this->input->post('statusServico');

        if(!empty($this->input->post('limite'))){
            $result = $this->producao_model->getControleEtapas(1);
            echo json_encode(array("result"=>true,"obj"=>$result));
        }else if(!empty($idOrc) || !empty($idOs) ||!empty($idProduto) ||!empty($descItem) ||!empty($statusServico)){
            $where = "";
            if(!empty($idOrc)){                
                $where .= " and controle_etapa.idOrcamento = $idOrc";                    
            }
            if(!empty($idOs)){                
                $where .= " and controle_etapa.idOs = $idOs";                    
            }            
            if(!empty($idProduto)){                
                $where .= " and produtos.pn like '%$idProduto%'";                    
            }            
            if(!empty($descItem)){                
                $where .= " and controle_etapa.descricaoItem like '%$descItem%'";                    
            }            
            if(!empty($statusServico)){                
                $where .= " and controle_etapa.idStatusEtapaServico = $statusServico";                    
            }
            $result = $this->producao_model->getControleEtapas('',$where);
            echo json_encode(array("result"=>true,"obj"=>$result));
        }else{
            $result = $this->producao_model->getControleEtapas();
            echo json_encode(array("result"=>true,"obj"=>$result));
        }
    }

    function getControleById (){
        $id = $this->input->post('idControleEtapa');
        $result = $this->producao_model->getControleEtapaById($id);
        $historicoStatus = $this->producao_model->getControleStatusHistByIdControleEtapa2($id);
        $result->historicoStatus = $historicoStatus;
        echo json_encode(array("result"=>true,"obj"=>$result));
    }

    function atualizaritem(){
        $idControleEtapa = $this->input->post('idControleEtapa');
        $idStatusServico = $this->input->post('statusServico');
        $qtd = $this->input->post('qtd');
        $idUser = null;
        if(!empty($this->input->post('idUser'))){
            $idUser = $this->input->post('idUser');
        }

        $controle = $this->producao_model->getOnlyControleEtapaById($idControleEtapa);
        if($qtd>$controle->quantidade || $qtd <= 0){
            echo json_encode(array("result"=>false,"msg"=>"Quantidade inválida."));
            return;
        }
        if($idStatusServico != $controle->idStatusEtapaServico){
            if($qtd != $controle->quantidade){
                $data = clone $controle;
                $data->idControleEtapa = null;
                $data->quantidade = $qtd;
                $data->idStatusEtapaServico = $idStatusServico;
                $controle->quantidade = $controle->quantidade-$qtd;
                $this->producao_model->edit('controle_etapa',$controle,'idControleEtapa',$controle->idControleEtapa);
                $id = $this->producao_model->add("controle_etapa",$data,true);
                $statusHist =  $this->producao_model->getControleStatusHistByIdControleEtapa($controle->idControleEtapa);
                foreach($statusHist as $r){
                    $r->idControleEtapa = $id;
                    $r->idControleEtapaHistStatus = null;
                    $this->producao_model->add("controle_etapa_hist_status",$r);
                }
                $data2 = array(
                    "idControleEtapa"=>$id,
                    "idStatusEtapaServico"=>$idStatusServico,
                    "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                    "idUsuarioAcao"=>$idUser,
                    "data_alteracao"=>date('Y-m-d H:i:s')
                );
                $this->producao_model->add("controle_etapa_hist_status",$data2,true);
                echo json_encode(array("result"=>true,"msg"=>"Status atualizado com sucesso."));
                return;
            }else{
                $controle->idStatusEtapaServico = $idStatusServico;
                $this->producao_model->edit('controle_etapa',$controle,'idControleEtapa',$controle->idControleEtapa);
                $data2 = array(
                    "idControleEtapa"=>$controle->idControleEtapa,
                    "idStatusEtapaServico"=>$idStatusServico,
                    "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                    "idUsuarioAcao"=>$idUser,
                    "data_alteracao"=>date('Y-m-d H:i:s')
                );
                $this->producao_model->add("controle_etapa_hist_status",$data2,true);
                echo json_encode(array("result"=>true,"msg"=>"Status atualizado com sucesso."));
                return;
            }
        }else{
            echo json_encode(array("result"=>false,"msg"=>"Não houve alteração no status do serviço."));
            return;
        }
    }
    
    function editaritem(){
        $idControleEtapa = $this->input->post('idControleEtapa');
        $idOs = $this->input->post('idOs');
        $idOrcamento = $this->input->post('idOrcamento');
        $descricaoItem = $this->input->post('descricaoItem');
        $local = $this->input->post('local');
        $data = array(
            "idOs"=>$idOs,
            "idOrcamento"=>$idOrcamento,
            "descricaoItem"=>$descricaoItem,
            "local"=>$local
        );
        $this->producao_model->edit('controle_etapa',$data,'idControleEtapa',$idControleEtapa);
        echo json_encode(array("result"=>true,"msg"=>"Item alterado com sucesso."));
    }

    function salvarobservacao(){
        $idControleEtapa = $this->input->post('idControleEtapa');        
        $obs = $this->input->post('observacao');                
        $obsEx = $this->input->post('vObservacao2');
        $obs2 = $obsEx."Data: ".date('d/m/Y H:i:s')."<br>"."Autor: ".$this->session->userdata('nome')."<br><br>".$obs."<br><div style='border-bottom: 1px solid black'></div><br><br>";
        $data = array(
            "observacao"=>$obs2
        );
        $this->producao_model->edit('controle_etapa',$data,'idControleEtapa',$idControleEtapa);
        echo json_encode(array("result"=>true,"msg"=>"Observação adicionada com sucesso."));
    }
}