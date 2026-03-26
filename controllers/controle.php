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
    function carregarItensRecebimento(){
        $this->load->model('orcamentos_model');
        $idOrc = $this->input->post('idOrcamento');
        $idOs = $this->input->post('idOs');
        $idProduto = $this->input->post('pn');
        $descItem = $this->input->post('descricaoItem');
        $statusServico = $this->input->post('statusServico');

        if(!empty($this->input->post('limite'))){
            $resultOrc = $this->producao_model->getOrcComItensAguardandoRecebimento();
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
            $resultOrc = $this->producao_model->getOrcComItensAguardandoRecebimento($where);
        }else{
            $resultOrc = $this->producao_model->getOrcComItensAguardandoRecebimento();
        }
        foreach($resultOrc as $r){
            $r->orcItem = $this->producao_model->getItemOrcComControleEtapa($r->idOrcamentos);//$this->orcamentos_model->getorc_item($r->idOrcamentos);
        }
        echo json_encode(array("result"=>true,"obj"=>$resultOrc));
    }
    function carregarItensEntrada(){
        $this->load->model('orcamentos_model');
        $resultOrc = $this->producao_model->getOrcComItensAguardandoEntrada();
        foreach($resultOrc as $r){
            $r->orcItem = $this->producao_model->getItemOrcComControleEtapa($r->idOrcamentos);//$this->orcamentos_model->getorc_item($r->idOrcamentos);
        }
        echo json_encode(array("result"=>true,"obj"=>$resultOrc));
    }
    function carregarItensSaida(){
        $this->load->model('orcamentos_model');
        $resultOrc = $this->producao_model->getOrcComItensAguardandoSaida();
        foreach($resultOrc as $r){
            $r->orcItem = $this->producao_model->getItemOrcComControleEtapa($r->idOrcamentos);//$this->orcamentos_model->getorc_item($r->idOrcamentos);
        }
        echo json_encode(array("result"=>true,"obj"=>$resultOrc));
    }
    function carregarItensCancelado(){
        $this->load->model('orcamentos_model');
        $resultOrc = $this->producao_model->getOrcComItensCancelado();
        foreach($resultOrc as $r){
            $r->orcItem = $this->producao_model->getItemOrcComControleEtapa($r->idOrcamentos);//$this->orcamentos_model->getorc_item($r->idOrcamentos);
        }
        echo json_encode(array("result"=>true,"obj"=>$resultOrc));
    }
    function carregarItens(){
        $idOrc = $this->input->post('idOrcamento');
        $idOs = $this->input->post('idOs');
        $idProduto = $this->input->post('pn');
        $descItem = $this->input->post('descricaoItem');
        $statusServico = $this->input->post('statusServico');

        if(!empty($this->input->post('limite'))){
            $result = $this->producao_model->getControleEtapas(1);
            //echo json_encode(array("result"=>true,"obj"=>$result));
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
            //echo json_encode(array("result"=>true,"obj"=>$result));
        }else{
            $result = $this->producao_model->getControleEtapas();
            //echo json_encode(array("result"=>true,"obj"=>$result));
        }
        foreach($result as $r){
            $r->filhos = $this->producao_model->getControleEtapaItens($r->idControleEtapa);
        }
        echo json_encode(array("result"=>true,"obj"=>$result));
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
        $controleSubitens = $this->producao_model->getOnlySubitensControleByIdControle($idControleEtapa);
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
                //echo json_encode(array("result"=>true,"msg"=>"Status atualizado com sucesso."));
                //return;
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
                //echo json_encode(array("result"=>true,"msg"=>"Status atualizado com sucesso."));
                //return;
            }
            foreach($controleSubitens as $r){
                if($r->idStatusEtapaServico != $idStatusServico){
                    $r->idStatusEtapaServico = $idStatusServico;
                    $this->producao_model->edit('controle_etapa_subitem',$r,'idControleEtapaSubitem',$r->idControleEtapaSubitem);

                    $data2 = array(
                        "idControleEtapaSubitem"=>$r->idControleEtapaSubitem,
                        "idStatusEtapaServico"=>$idStatusServico,
                        "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                        "idUsuarioAcao"=>$idUser,
                        "data_alteracao"=>date('Y-m-d H:i:s')
                    );
                    $this->producao_model->add("controle_etapa_subitem_hist_status",$data2,true);
                }
            }
            echo json_encode(array("result"=>true,"msg"=>"Status atualizado com sucesso."));
            return;
        }else{
            echo json_encode(array("result"=>false,"msg"=>"Não houve alteração no status do serviço."));
            return;
        }
    }
    
    function editaritem(){
        $idControleEtapa = $this->input->post('idControleEtapa');
        $idOs = $this->input->post('idOs');
        $nfCliente = (!empty($this->input->post('nf_cliente')?$this->input->post('nf_cliente'):null));
        $idOrcamento = $this->input->post('idOrcamento');
        $descricaoItem = $this->input->post('descricaoItem');
        $local = $this->input->post('local');
        $data = array(
            "idOs"=>(!empty($idOs)?$idOs:null),
            "idOrcamento"=>$idOrcamento,
            "nf_cliente"=>$nfCliente,
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

    function getControleSubitemById(){
        $idControleEtapaSubitem = $this->input->post('idControleEtapaSubitem');
        $result = $this->producao_model->getControleEtapaSubitemById($idControleEtapaSubitem);
        $historicoStatus = $this->producao_model->getControleStatusHistByIdControleEtapaSubitem2($idControleEtapaSubitem);
        //$historicoStatus = array();
        $result->historicoStatus = $historicoStatus;
        echo json_encode(array("result"=>true,"obj"=>$result));
    }

    function atualizarsubitem(){
        $idControleEtapaSubitem = $this->input->post('idControleEtapaSubitem');
        $idStatusServico = $this->input->post('statusServico');
        $qtd = $this->input->post('qtd');
        $idUser = null;
        if(!empty($this->input->post('idUser'))){
            $idUser = $this->input->post('idUser');
        }

        $controle = $this->producao_model->getOnlyControleEtapaSubitemById($idControleEtapaSubitem);
        if($qtd>$controle->quantidade || $qtd <= 0){
            echo json_encode(array("result"=>false,"msg"=>"Quantidade inválida."));
            return;
        }
        if($idStatusServico != $controle->idStatusEtapaServico){
            if($qtd != $controle->quantidade){
                $data = clone $controle;
                $data->idControleEtapaSubitem = null;
                $data->quantidade = $qtd;
                $data->idStatusEtapaServico = $idStatusServico;
                $controle->quantidade = $controle->quantidade-$qtd;
                $this->producao_model->edit('controle_etapa_subitem',$controle,'idControleEtapaSubitem',$controle->idControleEtapaSubitem);
                $id = $this->producao_model->add("controle_etapa_subitem",$data,true);
                $statusHist =  $this->producao_model->getControleStatusHistByIdControleEtapaSubitem($controle->idControleEtapaSubitem);
                foreach($statusHist as $r){
                    $r->idControleEtapaSubitem = $id;
                    $r->idControleEtapaHistStatus = null;
                    $this->producao_model->add("controle_etapa_subitem_hist_status",$r);
                }
                $data2 = array(
                    "idControleEtapaSubitem"=>$id,
                    "idStatusEtapaServico"=>$idStatusServico,
                    "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                    "idUsuarioAcao"=>$idUser,
                    "data_alteracao"=>date('Y-m-d H:i:s')
                );
                $this->producao_model->add("controle_etapa_subitem_hist_status",$data2,true);
                echo json_encode(array("result"=>true,"msg"=>"Status atualizado com sucesso."));
                return;
            }else{
                $controle->idStatusEtapaServico = $idStatusServico;
                $this->producao_model->edit('controle_etapa_subitem',$controle,'idControleEtapaSubitem',$controle->idControleEtapaSubitem);
                $data2 = array(
                    "idControleEtapaSubitem"=>$controle->idControleEtapaSubitem,
                    "idStatusEtapaServico"=>$idStatusServico,
                    "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                    "idUsuarioAcao"=>$idUser,
                    "data_alteracao"=>date('Y-m-d H:i:s')
                );
                $this->producao_model->add("controle_etapa_subitem_hist_status",$data2,true);
                echo json_encode(array("result"=>true,"msg"=>"Status atualizado com sucesso."));
                return;
            }
        }else{
            echo json_encode(array("result"=>false,"msg"=>"Não houve alteração no status do serviço."));
            return;
        }
    }

    function editarsubitem(){
        $idControleEtapaSubitem = $this->input->post('idControleEtapaSubitem');
        $descricaoItem = $this->input->post('descricaoItem');
        $local = $this->input->post('local');
        $data = array(
            "descricaoItem"=>$descricaoItem,
            "local"=>$local
        );
        $this->producao_model->edit('controle_etapa_subitem',$data,'idControleEtapaSubitem',$idControleEtapaSubitem);
        echo json_encode(array("result"=>true,"msg"=>"Item alterado com sucesso."));
    }

    function salvarobservacaosubitem(){
        $idControleEtapaSubitem = $this->input->post('idControleEtapaSubitem');        
        $obs = $this->input->post('observacao');                
        $obsEx = $this->input->post('vObservacao2');
        $obs2 = $obsEx."Data: ".date('d/m/Y H:i:s')."<br>"."Autor: ".$this->session->userdata('nome')."<br><br>".$obs."<br><div style='border-bottom: 1px solid black'></div><br><br>";
        $data = array(
            "observacao"=>$obs2
        );
        $this->producao_model->edit('controle_etapa_subitem',$data,'idControleEtapaSubitem',$idControleEtapaSubitem);
        echo json_encode(array("result"=>true,"msg"=>"Observação adicionada com sucesso."));
    }

    function procurarItens(){
        $idOrc = $this->input->post('idOrcamento');
        $idOs = $this->input->post('os');
        $descricaoItem = $this->input->post('descricaoItem');
        $pn = $this->input->post('pn');
        $listaControleEtapa = $this->input->post('listaControleEtapa');
        $this->load->model('peritagem_model');
        $where = "";
        if(!empty($idOrc)){
            $where .= " and controle_etapa.idOrcamento = $idOrc";
        }
        if(!empty($idOs)){
            $where .= " and os.idOs = $idOs";
        }
        if(!empty($descricaoItem)){
            $where .= " and produtos.descricao like '%$descricaoItem%'";
        }
        if(!empty($pn)){
            $where .= " and produtos.pn like '%$pn%'";
        }
        if(!empty($listaControleEtapa)){
            $where .= " and controle_etapa.idControleEtapa not in ($listaControleEtapa)";
        }
        $result = $this->producao_model->procurarItensEntrada($where);
        /**/
        $where2 = " and status_etapas_servico.ciclo in (4,5,1,2)";
        foreach($result as $c){
            $subItensControle = $this->producao_model->getControleEtapaItens($c->idControleEtapa,$where2);
            if(!empty($subItensControle)){
                $count = "";
                $c->controleEtapaSubitens = $subItensControle;
                $primeiro = true;
                foreach($subItensControle as $d){
                    if($primeiro){
                        $count .= $d->idProduto;
                    }else{
                        $count .= ",".$d->idProduto;
                    }
                }
                $escopo = $this->peritagem_model->getEscopoByIdProduto($c->idProduto,$c->tipoProd);
                if(!empty($escopo)){
                    $produtosEscopo = $this->producao_model->getProdutosEscopoByIdProduto($escopo->idServicoEscopo,$count);
                }else{
                    $produtosEscopo = array();
                }
                
                $checklist = $this->peritagem_model->getCatalogoAtivosByIdProduto2($c->idProduto);
                if(!empty($checklist)){
                    $produtosChecklist = $this->producao_model->getProdutosCatalogoByIdProduto($checklist->idCatalogoProduto,$count);
                }else{
                    $produtosChecklist = array();
                }                
                if(count($produtosEscopo) > count($produtosChecklist)){
                    $c->produtos = $produtosEscopo;
                }else{
                    $c->produtos = $produtosChecklist;
                }
            }else{
                $count = "";
                $c->controleEtapaSubitens = array();
                $escopo = $this->peritagem_model->getEscopoByIdProduto($c->idProduto,$c->tipoProd);
                $produtosEscopo = $this->producao_model->getProdutosEscopoByIdProduto($escopo->idServicoEscopo,$count);
                $checklist = $this->peritagem_model->getCatalogoAtivosByIdProduto2($c->idProduto);
                if(!empty($checklist)){
                    $produtosChecklist = $this->producao_model->getProdutosCatalogoByIdProduto($checklist->idCatalogoProduto,$count);
                }else{
                    $produtosChecklist = array();
                }
                
                if(count($produtosEscopo) > count($produtosChecklist)){
                    $c->produtos = $produtosEscopo;
                }else{
                    $c->produtos = $produtosChecklist;
                }
            }
        } 
        
        echo json_encode(array("result"=>true,"obj"=>$result));
    }

    function procurarItens2(){
        $idOrc = $this->input->post('idOrcamento');
        $idOs = $this->input->post('os');
        $descricaoItem = $this->input->post('descricaoItem');
        $pn = $this->input->post('pn');
        $listaControleEtapa = $this->input->post('listaControleEtapa');
        $this->load->model('peritagem_model');
        $where = "";
        if(!empty($idOrc)){
            $where .= " and controle_etapa.idOrcamento = $idOrc";
        }
        if(!empty($idOs)){
            $where .= " and os.idOs = $idOs";
        }
        if(!empty($descricaoItem)){
            $where .= " and produtos.descricao like '%$descricaoItem%'";
        }
        if(!empty($pn)){
            $where .= " and produtos.pn like '%$pn%'";
        }
        if(!empty($listaControleEtapa)){
            $where .= " and controle_etapa.idControleEtapa not in ($listaControleEtapa)";
        }
        $where2 = " and status_etapas_servico.ciclo in (3,2,1)";
        $result = $this->producao_model->procurarItensEntrada($where);
        foreach($result as $c){
            $subItensControle = $this->producao_model->getControleEtapaItens($c->idControleEtapa,$where2);
            if(!empty($subItensControle)){
                $c->controleEtapaSubitens = $subItensControle;
            }else{
                $c->controleEtapaSubitens = array();
            }
        }
        echo json_encode(array("result"=>true,"obj"=>$result));
    }

    public function getDetailProduto(){
        
        $this->load->model('orcamentos_model');
        if(empty($this->input->post("cadastrarNovoSubItem")) && empty($this->input->post("subItemEntrada")) && empty($this->input->post("produtoMaster"))){
            $this->session->set_flashdata('error','Nenhum item foi selecionado.');
            redirect(base_url().'index.php/controle/armazenar');
        }
        $arrayControle = array();
        $contador = $this->input->post("contador");
        for($k=0;$k<count($contador);$k++){
            $verifyNovosubitem = false;
            $verifySubitemExistente = false;
            $verifyProdutoMaster = false;

            //<pn master>
                if(!empty($this->input->post("produtoMaster"))){
                    $produtoMaster = $this->input->post("produtoMaster");
                    $arrayPNMaster = array();
                    for($x=0;$x<count($produtoMaster);$x++){
                        if($produtoMaster[$x] == $contador[$k]){
                            $pnmaster = $this->producao_model->getControleEtapaById($contador[$k]);         
                            array_push($arrayPNMaster,$pnmaster);
                            $verifyProdutoMaster = true;
                        }
                    }
                }
             //</pn master>
            
            //<novo subitem>
                if(!empty($this->input->post("cadastrarNovoSubItem"))){
                    $cadasNovoSubItem = $this->input->post("cadastrarNovoSubItem");
                    $arrayProduto = array();
                    $arrayOrcItem = array();
                    $arrayControleEtapa = array();
                    for($x=0;$x<count($cadasNovoSubItem);$x++){
                        $explodeItem = explode("_",$cadasNovoSubItem[$x]);
                        $idControleEtapa = $explodeItem[2];
                        if($idControleEtapa == $contador[$k]){
                            $produtos = $explodeItem[0];
                            $orc_item = $explodeItem[1];
                            array_push($arrayProduto, $this->producao_model->getProdutobyId($produtos));
                            array_push($arrayOrcItem, $this->orcamentos_model->getOrcamentoByidOrcItem2($orc_item));
                            array_push($arrayControleEtapa, $idControleEtapa);
                            $verifyNovosubitem = true;
                        }
                    }
                }
            //</novo subitem>

            //<existente subitem>
                if(!empty($this->input->post("subItemEntrada"))){
                    $idControleSubItem =  $this->input->post("subItemEntrada");
                    $arrayDetailControleSubItem = array();
                    for($x=0;$x<count($idControleSubItem);$x++){
                        $objControleSubItem = $this->producao_model->getControleEtapaSubitemById($idControleSubItem[$x]);
                        if($objControleSubItem->idControleEtapa == $contador[$k]){
                            array_push($arrayDetailControleSubItem, $objControleSubItem);
                            $verifySubitemExistente = true;
                        }
                    }
                }
             //</existente subitem>

             

            if($verifySubitemExistente || $verifyNovosubitem ||  $verifyProdutoMaster){
                $objControle = $this->producao_model->getControleEtapaById($contador[$k]);
                if($verifyProdutoMaster){
                    $objControle->pnmaster = $arrayPNMaster;
                }
                if($verifyNovosubitem){
                    $objControle->novoSubitem = $arrayProduto;
                }
                if($verifySubitemExistente){
                    $objControle->existenteSubitem = $arrayDetailControleSubItem;
                }
                array_push($arrayControle,$objControle);
            }
           
        }
        $this->data['result'] = $arrayControle;
        $this->data['statusEtapa'] = $this->producao_model->getStatusEtapasServico();
        $this->data['view'] = 'controle/confirmarEntradaArmazenamento';
        $this->load->view('tema/topo',$this->data);
        //echo json_encode(array("result"=>true,"obj"=>$result));
    }

    public function getDetailProduto2(){
        
        $this->load->model('orcamentos_model');
        if(empty($this->input->post("subItemSaida")) && empty($this->input->post("produtoMaster"))){
            $this->session->set_flashdata('error','Nenhum item foi selecionado.');
            redirect(base_url().'index.php/controle/armazenar');
        }
        $arrayControle = array();
        $contador = $this->input->post("contador2");
        for($k=0;$k<count($contador);$k++){
            $verifyNovosubitem = false;
            $verifySubitemExistente = false;
            $verifyProdutoMaster = false;

            //<pn master>
                if(!empty($this->input->post("produtoMaster"))){
                    $produtoMaster = $this->input->post("produtoMaster");
                    $arrayPNMaster = array();
                    for($x=0;$x<count($produtoMaster);$x++){
                        if($produtoMaster[$x] == $contador[$k]){
                            $pnmaster = $this->producao_model->getControleEtapaById($contador[$k]);         
                            array_push($arrayPNMaster,$pnmaster);
                            $verifyProdutoMaster = true;
                        }
                    }
                }
            //</pn master>           
            

            //<existente subitem>
                if(!empty($this->input->post("subItemSaida"))){
                    $idControleSubItem =  $this->input->post("subItemSaida");
                    $arrayDetailControleSubItem = array();
                    for($x=0;$x<count($idControleSubItem);$x++){
                        $objControleSubItem = $this->producao_model->getControleEtapaSubitemById($idControleSubItem[$x]);
                        if($objControleSubItem->idControleEtapa == $contador[$k]){
                            array_push($arrayDetailControleSubItem, $objControleSubItem);
                            $verifySubitemExistente = true;
                        }
                    }
                }
            //</existente subitem>

             

            if($verifySubitemExistente || $verifyNovosubitem ||  $verifyProdutoMaster){
                $objControle = $this->producao_model->getControleEtapaById($contador[$k]);
                if($verifyProdutoMaster){
                    $objControle->pnmaster = $arrayPNMaster;
                }
                if($verifySubitemExistente){
                    $objControle->existenteSubitem = $arrayDetailControleSubItem;
                }
                array_push($arrayControle,$objControle);
            }
           
        }
        $this->data['result'] = $arrayControle;
        $this->data['statusEtapa'] = $this->producao_model->getStatusEtapasServico();
        $this->data['view'] = 'controle/confirmarSaidaArmazenamento';
        $this->load->view('tema/topo',$this->data);
        //echo json_encode(array("result"=>true,"obj"=>$result));
    }

    function entrada(){
        $statusEntrada = $this->input->post("statusEntrada");
        // <Novo Subitem>            
            $idProduto = $this->input->post("idProduto");
            $idControleEtapa_NovoItem = $this->input->post("idControleEtapa_NovoItem");
            $quantidade_NovoItem = $this->input->post("quantidade_NovoItem"); 
            $local_NovoItem = $this->input->post("local_NovoItem");

            //echo $idProduto;
            //return;
            if(!empty($idProduto)){
                for($x=0;$x<count($idProduto);$x++){
                    $produto = $this->producao_model->getProdutobyId($idProduto[$x]);
                    $data = array(
                        "idControleEtapa"=>$idControleEtapa_NovoItem[$x],
                        //"idOsSub"=>$idSubOs,
                        "idProduto"=>$idProduto[$x],
                        "descricaoItem"=>$produto->descricao,
                        "quantidade"=>$quantidade_NovoItem[$x],
                        "idStatusEtapaServico"=>$statusEntrada,
                        "local"=>$local_NovoItem[$x],
                        "data_cadastro"=>date('Y-m-d H:i:s')
                    );
                    $id = $this->producao_model->add("controle_etapa_subitem",$data,true);
                    $data2 = array(
                        "idControleEtapaSubitem"=> $id,
                        "idStatusEtapaServico"=>$statusEntrada,
                        "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                        //"idUsuarioAcao"=>$idUser,
                        "data_alteracao"=>date('Y-m-d H:i:s')
                    );
                    $this->producao_model->add("controle_etapa_subitem_hist_status",$data2);
                }
            }
            
        // </Novo Subitem>

        //<subitem existente>
            $idControleSubItem = $this->input->post("idControleSubItem");
            $quantidade = $this->input->post("quantidade");
            $local = $this->input->post("local");
            if(!empty($idControleSubItem)){
                for($x=0;$x<count($idControleSubItem);$x++){
                    $objControleSubItem = $this->producao_model->getOnlyControleEtapaSubitemById($idControleSubItem[$x]);
                    if($objControleSubItem->idStatusEtapaServico != $statusEntrada){
                        if($quantidade[$x]>$objControleSubItem->quantidade){
                            $this->session->set_flashdata('error','A quantidade informada é maior que a quantidade registrada.');
                            redirect(base_url().'index.php/controle/armazenar');
                        }else if($quantidade[$x]<$objControleSubItem->quantidade){
                            $data = clone $objControleSubItem;
                            $data->idControleEtapaSubitem = null;
                            $data->quantidade = $quantidade[$x];
                            $data->idStatusEtapaServico = $statusEntrada;
                            $data->local = $local[$x];
                            $objControleSubItem->quantidade = $objControleSubItem->quantidade-$quantidade[$x];
                            $this->producao_model->edit('controle_etapa_subitem',$objControleSubItem,'idControleEtapaSubitem',$objControleSubItem->idControleEtapaSubitem);
                            $id = $this->producao_model->add("controle_etapa_subitem",$data,true);
                            $statusHist =  $this->producao_model->getControleStatusHistByIdControleEtapaSubitem($objControleSubItem->idControleEtapaSubitem);
                            foreach($statusHist as $r){
                                $r->idControleEtapaSubitem = $id;
                                $r->idControleEtapaHistStatus = null;
                                $this->producao_model->add("controle_etapa_subitem_hist_status",$r);
                            }
                            $data2 = array(
                                "idControleEtapaSubitem"=>$id,
                                "idStatusEtapaServico"=>$statusEntrada,
                                "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                                //"idUsuarioAcao"=>$idUser,
                                "data_alteracao"=>date('Y-m-d H:i:s')
                            );
                            $this->producao_model->add("controle_etapa_subitem_hist_status",$data2,true);
                        }else{
                            $objControleSubItem->idStatusEtapaServico = $statusEntrada;
                            $objControleSubItem->local = $local[$x];
                            $this->producao_model->edit('controle_etapa_subitem',$objControleSubItem,'idControleEtapaSubitem',$objControleSubItem->idControleEtapaSubitem);
                            $data2 = array(
                                "idControleEtapaSubitem"=>$objControleSubItem->idControleEtapaSubitem,
                                "idStatusEtapaServico"=>$statusEntrada,
                                "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                                //"idUsuarioAcao"=>$idUser,
                                "data_alteracao"=>date('Y-m-d H:i:s')
                            );
                            $this->producao_model->add("controle_etapa_subitem_hist_status",$data2);
                        }
                    }                    
                }
            }
            
        //</subitem existente>

        // <PN Master>
            $idControleItem = $this->input->post("pnmaster");
            $quantidade_master = $this->input->post("quantidade_master");
            $quantidade_master_real = $this->input->post("quantidade_master_real");
            $local_master = $this->input->post("local_master");
            if(!empty($idControleItem)){
                for($x=0;$x<count($idControleItem);$x++){
                    $objControle = $this->producao_model->getOnlyControleEtapaById($idControleItem[$x]);
                    if($objControle->idStatusEtapaServico != $statusEntrada){
                        if($quantidade_master[$x]>$objControle->quantidade || $quantidade_master[$x]<=0){
                            $this->session->set_flashdata('error','A quantidade informada é maior que a quantidade registrada.');
                            redirect(base_url().'index.php/controle/armazenar');
                        } else if($quantidade_master[$x]<$objControle->quantidade){
                            $data = clone $objControle;
                            $data->idControleEtapa = null;
                            $data->quantidade = $quantidade_master[$x];
                            $data->idStatusEtapaServico = $statusEntrada;
                            $objControle->quantidade = $objControle->quantidade-$quantidade_master[$x];
                            $this->producao_model->edit('controle_etapa',$objControle,'idControleEtapa',$objControle->idControleEtapa);
                            $id = $this->producao_model->add("controle_etapa",$data,true);
                            $statusHist =  $this->producao_model->getControleStatusHistByIdControleEtapa($objControle->idControleEtapa);
                            foreach($statusHist as $r){
                                $r->idControleEtapa = $id;
                                $r->idControleEtapaHistStatus = null;
                                $this->producao_model->add("controle_etapa_hist_status",$r);
                            }
                            $data2 = array(
                                "idControleEtapa"=>$id,
                                "idStatusEtapaServico"=>$statusEntrada,
                                "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                                //"idUsuarioAcao"=>$idUser,
                                "data_alteracao"=>date('Y-m-d H:i:s')
                            );
                            $this->producao_model->add("controle_etapa_hist_status",$data2,true);
                        }else{
                            $objControle->idStatusEtapaServico = $statusEntrada;
                            $objControle->local = $local_master[$x];
                            $this->producao_model->edit('controle_etapa',$objControle,'idControleEtapa',$objControle->idControleEtapa);
                            $data2 = array(
                                "idControleEtapa"=>$objControle->idControleEtapa,
                                "idStatusEtapaServico"=>$statusEntrada,
                                "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                                //"idUsuarioAcao"=>$idUser,
                                "data_alteracao"=>date('Y-m-d H:i:s')
                            );
                            $this->producao_model->add("controle_etapa_hist_status",$data2,true);
                        }
                    }                    
                }
            }
        // </PN Master>
        $this->session->set_flashdata('success','Entradas realizadas com sucesso.');
        redirect(base_url().'index.php/controle/armazenar');
    }

    function saida(){
        $statusEntrada = $this->input->post("statusSaida");
        $idUser = $this->input->post("idUser");
        $assinatura = $this->input->post("assinatura");
        if(!empty($assinatura)){
            $encoded_image = explode(",", $assinatura)[1];
            $decoded_image = base64_decode($encoded_image);
            $target_dir = "./assets/assinaturas/";
            $target_dir2 = "assets/assinaturas/";
            $nomeAssinatura = $this->generateRandomString().".png";
            $target_file = $target_dir.$nomeAssinatura;
            $target_file2 = $target_dir2.$nomeAssinatura;
            file_put_contents($target_file, $decoded_image);
        }else{
            $this->session->set_flashdata('error','O assinatura deve ser preenchida.');
            redirect(base_url().'index.php/controle/armazenar');
        }
        //<subitem existente>
            $idControleSubItem = $this->input->post("idControleSubItem");
            $quantidade = $this->input->post("quantidade");
            //$local = $this->input->post("local");
            if(!empty($idControleSubItem)){
                for($x=0;$x<count($idControleSubItem);$x++){
                    $objControleSubItem = $this->producao_model->getOnlyControleEtapaSubitemById($idControleSubItem[$x]);
                    if($objControleSubItem->idStatusEtapaServico != $statusEntrada){
                        if($quantidade[$x]>$objControleSubItem->quantidade){
                            $this->session->set_flashdata('error','A quantidade informada é maior que a quantidade registrada.');
                            redirect(base_url().'index.php/controle/armazenar');
                        }else if($quantidade[$x]<$objControleSubItem->quantidade){
                            $data = clone $objControleSubItem;
                            $data->idControleEtapaSubitem = null;
                            $data->quantidade = $quantidade[$x];
                            $data->idStatusEtapaServico = $statusEntrada;
                            $data->local = null;
                            $objControleSubItem->quantidade = $objControleSubItem->quantidade-$quantidade[$x];
                            $this->producao_model->edit('controle_etapa_subitem',$objControleSubItem,'idControleEtapaSubitem',$objControleSubItem->idControleEtapaSubitem);
                            $id = $this->producao_model->add("controle_etapa_subitem",$data,true);
                            $statusHist =  $this->producao_model->getControleStatusHistByIdControleEtapaSubitem($objControleSubItem->idControleEtapaSubitem);
                            foreach($statusHist as $r){
                                $r->idControleEtapaSubitem = $id;
                                $r->idControleEtapaHistStatus = null;
                                $this->producao_model->add("controle_etapa_subitem_hist_status",$r);
                            }
                            $data2 = array(
                                "idControleEtapaSubitem"=>$id,
                                "idStatusEtapaServico"=>$statusEntrada,
                                "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                                "idUsuarioAcao"=>$idUser,
                                "assinatura"=>$target_file2,
                                "data_alteracao"=>date('Y-m-d H:i:s')
                            );
                            $this->producao_model->add("controle_etapa_subitem_hist_status",$data2,true);
                        }else{
                            $objControleSubItem->idStatusEtapaServico = $statusEntrada;
                            $objControleSubItem->local = null;
                            $this->producao_model->edit('controle_etapa_subitem',$objControleSubItem,'idControleEtapaSubitem',$objControleSubItem->idControleEtapaSubitem);
                            $data2 = array(
                                "idControleEtapaSubitem"=>$objControleSubItem->idControleEtapaSubitem,
                                "idStatusEtapaServico"=>$statusEntrada,
                                "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                                "idUsuarioAcao"=>$idUser,
                                "assinatura"=>$target_file2,
                                "data_alteracao"=>date('Y-m-d H:i:s')
                            );
                            $this->producao_model->add("controle_etapa_subitem_hist_status",$data2);
                        }
                    }                    
                }
            }
            
        //</subitem existente>

        // <PN Master>
            $idControleItem = $this->input->post("pnmaster");
            $quantidade_master = $this->input->post("quantidade_master");
            $quantidade_master_real = $this->input->post("quantidade_master_real");
            //$local_master = $this->input->post("local_master");
            if(!empty($idControleItem)){
                for($x=0;$x<count($idControleItem);$x++){
                    $objControle = $this->producao_model->getOnlyControleEtapaById($idControleItem[$x]);
                    if($objControle->idStatusEtapaServico != $statusEntrada){
                        if($quantidade_master[$x]>$objControle->quantidade || $quantidade_master[$x]<=0){
                            $this->session->set_flashdata('error','A quantidade informada é maior que a quantidade registrada.');
                            redirect(base_url().'index.php/controle/armazenar');
                        } else if($quantidade_master[$x]<$objControle->quantidade){
                            $data = clone $objControle;
                            $data->idControleEtapa = null;
                            $data->quantidade = $quantidade_master[$x];
                            $data->idStatusEtapaServico = $statusEntrada;
                            $data->local = null;
                            $objControle->quantidade = $objControle->quantidade-$quantidade_master[$x];
                            $this->producao_model->edit('controle_etapa',$objControle,'idControleEtapa',$objControle->idControleEtapa);
                            $id = $this->producao_model->add("controle_etapa",$data,true);
                            $statusHist =  $this->producao_model->getControleStatusHistByIdControleEtapa($objControle->idControleEtapa);
                            foreach($statusHist as $r){
                                $r->idControleEtapa = $id;
                                $r->idControleEtapaHistStatus = null;
                                $this->producao_model->add("controle_etapa_hist_status",$r);
                            }
                            $data2 = array(
                                "idControleEtapa"=>$id,
                                "idStatusEtapaServico"=>$statusEntrada,
                                "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                                "idUsuarioAcao"=>$idUser,
                                "assinatura"=>$target_file2,
                                "data_alteracao"=>date('Y-m-d H:i:s')
                            );
                            $this->producao_model->add("controle_etapa_hist_status",$data2,true);
                        }else{
                            $objControle->idStatusEtapaServico = $statusEntrada;
                            $objControle->local = null;
                            $this->producao_model->edit('controle_etapa',$objControle,'idControleEtapa',$objControle->idControleEtapa);
                            $data2 = array(
                                "idControleEtapa"=>$objControle->idControleEtapa,
                                "idStatusEtapaServico"=>$statusEntrada,
                                "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                                "idUsuarioAcao"=>$idUser,
                                "assinatura"=>$target_file2,
                                "data_alteracao"=>date('Y-m-d H:i:s')
                            );
                            $this->producao_model->add("controle_etapa_hist_status",$data2,true);
                        }
                    }                    
                }
            }
        // </PN Master>
        $this->session->set_flashdata('success','Saídas realizadas com sucesso.');
        redirect(base_url().'index.php/controle/armazenar');
    }

    public function autoCompleteIdOrcamento(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompleteIdOrcamento($q);
        }

    }

    public function autoCompleteidOs(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompleteidOs($q);
        }

    }

    public function autoCompletePN(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompletePN($q);
        }

    }

    public function autoCompleteDescricao(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->orcamentos_model->autoCompleteDescricao($q);
        }

    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function recebimento(){
        $this->load->model('orcamentos_model');
        $this->load->model('peritagem_model');
        $idOrc= $this->uri->segment(3);
        $objOrc =  $this->orcamentos_model->getOrcamento($idOrc);
        $objControle = $this->producao_model->getItemOrcComControleEtapa($idOrc);
        foreach($objControle as  $r){
            if($r->tipoOrc = "serv"){
                //$r->controleEtapa = $this->producao_model->getControleEtapaByIdOrcamento_itemAndByidStatus($idOrc,1);
                $r->controleEtapa = $this->producao_model->getAllControleEtapaByIdOrcamento_item($r->idOrcamento_item);
                foreach($r->controleEtapa as $c){
                    $c->controleEtapaSubitem = $this->producao_model->getControleEtapaItens2($c->idControleEtapa);
                    $count = "";
                    foreach($c->controleEtapaSubitem as $x){
                        if(!empty($count)){
                            $count .= ",".$x->idProduto;
                        }else{
                            $count .= $x->idProduto;
                        }
                    }
                    $escopo = $this->peritagem_model->getEscopoByIdProduto($c->idProduto,$c->tipoProd);
                    if(!empty($escopo)){
                        $produtosEscopo = $this->producao_model->getProdutosEscopoByIdProduto($escopo->idServicoEscopo,$count);
                    }else{
                        $produtosEscopo = array();
                    }
                    
                    $checklist = $this->peritagem_model->getCatalogoAtivosByIdProduto2($c->idProduto);
                    if(!empty($checklist)){
                        $produtosChecklist = $this->producao_model->getProdutosCatalogoByIdProduto($checklist->idCatalogoProduto,$count);
                    }else{
                        $produtosChecklist = array();
                    }                
                    if(count($produtosEscopo) > count($produtosChecklist)){
                        $c->produtos = $produtosEscopo;
                    }else{
                        $c->produtos = $produtosChecklist;
                    }
                    //echo $count;
                    //return;
                }
                
            }
            
        }
        
        $this->data{'result'} = $this->orcamentos_model->getOrcDetail($idOrc);
        $this->data['objOrc'] = $objOrc;
        $this->data['objControleSubItem'] = $objControle;
        $this->data['view'] = 'controle/recebimento';
        $this->load->view('tema/topo',$this->data);
    }

    function entrada2(){
        $this->load->model('orcamentos_model');
        $this->load->model('peritagem_model');
        $idOrc= $this->uri->segment(3);
        $objOrc =  $this->orcamentos_model->getOrcamento($idOrc);
        $objControle = $this->producao_model->getItemOrcComControleEtapa($idOrc);
        foreach($objControle as  $r){
            if($r->tipoOrc = "serv"){
                //$r->controleEtapa = $this->producao_model->getControleEtapaByIdOrcamento_itemAndByidStatus($idOrc,1);
                $r->controleEtapa = $this->producao_model->getAllControleEtapaByIdOrcamento_item($r->idOrcamento_item);
                foreach($r->controleEtapa as $c){
                    $c->controleEtapaSubitem = $this->producao_model->getControleEtapaItens2($c->idControleEtapa);
                    $count = "";
                    foreach($c->controleEtapaSubitem as $x){
                        if(!empty($count)){
                            $count .= ",".$x->idProduto;
                        }else{
                            $count .= $x->idProduto;
                        }
                    }
                    $escopo = $this->peritagem_model->getEscopoByIdProduto($c->idProduto,$c->tipoProd);
                    if(!empty($escopo)){
                        $produtosEscopo = $this->producao_model->getProdutosEscopoByIdProduto($escopo->idServicoEscopo,$count);
                    }else{
                        $produtosEscopo = array();
                    }
                    
                    $checklist = $this->peritagem_model->getCatalogoAtivosByIdProduto2($c->idProduto);
                    if(!empty($checklist)){
                        $produtosChecklist = $this->producao_model->getProdutosCatalogoByIdProduto($checklist->idCatalogoProduto,$count);
                    }else{
                        $produtosChecklist = array();
                    }
                    if(count($produtosEscopo) > count($produtosChecklist)){
                        $c->produtos = $produtosEscopo;
                    }else{
                        $c->produtos = $produtosChecklist;
                    }
                    //echo $count;
                    //return;
                }
            }
        }
        $this->data{'result'} = $this->orcamentos_model->getOrcDetail($idOrc);
        $this->data['objOrc'] = $objOrc;
        $this->data['objControleSubItem'] = $objControle;
        $this->data['view'] = 'controle/entrada';
        $this->load->view('tema/topo',$this->data);
    }

    function saida2(){
        $this->load->model('orcamentos_model');
        $this->load->model('peritagem_model');
        $idOrc= $this->uri->segment(3);
        $objOrc =  $this->orcamentos_model->getOrcamento($idOrc);
        $objControle = $this->producao_model->getItemOrcComControleEtapa($idOrc);
        foreach($objControle as  $r){
            if($r->tipoOrc = "serv"){
                //$r->controleEtapa = $this->producao_model->getControleEtapaByIdOrcamento_itemAndByidStatus($idOrc,1);
                $r->controleEtapa = $this->producao_model->getAllControleEtapaByIdOrcamento_item($r->idOrcamento_item);
                foreach($r->controleEtapa as $c){
                    $c->controleEtapaSubitem = $this->producao_model->getControleEtapaItens2($c->idControleEtapa);
                    $count = "";
                    foreach($c->controleEtapaSubitem as $x){
                        if(!empty($count)){
                            $count .= ",".$x->idProduto;
                        }else{
                            $count .= $x->idProduto;
                        }
                    }
                    $escopo = $this->peritagem_model->getEscopoByIdProduto($c->idProduto,$c->tipoProd);
                    if(!empty($escopo)){
                        $produtosEscopo = $this->producao_model->getProdutosEscopoByIdProduto($escopo->idServicoEscopo,$count);
                    }else{
                        $produtosEscopo = array();
                    }
                    
                    $checklist = $this->peritagem_model->getCatalogoAtivosByIdProduto2($c->idProduto);
                    if(!empty($checklist)){
                        $produtosChecklist = $this->producao_model->getProdutosCatalogoByIdProduto($checklist->idCatalogoProduto,$count);
                    }else{
                        $produtosChecklist = array();
                    }
                    if(count($produtosEscopo) > count($produtosChecklist)){
                        $c->produtos = $produtosEscopo;
                    }else{
                        $c->produtos = $produtosChecklist;
                    }
                    //echo $count;
                    //return;
                }
            }
        }
        $this->data{'result'} = $this->orcamentos_model->getOrcDetail($idOrc);
        $this->data['statusEtapa'] = $this->producao_model->getStatusEtapasServico();
        $this->data['objOrc'] = $objOrc;
        $this->data['objControleSubItem'] = $objControle;
        $this->data['view'] = 'controle/saida';
        $this->load->view('tema/topo',$this->data);
    }

    function recebermercadoria(){
        $this->load->model("produtos_model");
        $controleEtapa = $this->input->post("arrayControleEtapa");
        $controleEtapaSubitem = $this->input->post("arrayControleEtapaSubitem");
        $novoControleEtapaSubitem = $this->input->post("arrayNovoControleEtapaSubitem");
        $arrayControleEtapa = array();
        $arrayControleEtapaSubitem = array();
        $arrayNovoControleEtapaSubitem = array();

        if(!empty($controleEtapa)){
            foreach($controleEtapa as $r){
                $objControleEtapa = $this->producao_model->getControleEtapaById($r);
                $arrayControleEtapa = array_merge($arrayControleEtapa,array($objControleEtapa));
            }
        }

        if(!empty($controleEtapaSubitem)){
            for($x=0;$x<sizeof($controleEtapaSubitem);$x++){
                //echo $controleEtapaSubitem[$x]["id"].",";
                $objControleEtapaSubitem = $this->producao_model->getControleEtapaSubitemById($controleEtapaSubitem[$x]["id"]);
                $objControleEtapaSubitem->quantidade =  $controleEtapaSubitem[$x]["quantidade"];
                $arrayControleEtapaSubitem = array_merge($arrayControleEtapaSubitem,array($objControleEtapaSubitem));
            }
        }

        if(!empty($novoControleEtapaSubitem)){
            for($x=0;$x<sizeof($novoControleEtapaSubitem);$x++){
                //echo $controleEtapaSubitem[$x]["id"].",";
                $objNovoSubitem = $this->produtos_model->getById($novoControleEtapaSubitem[$x]["id"]);
                $objNovoSubitem->quantidade =  $novoControleEtapaSubitem[$x]["quantidade"];
                $objNovoSubitem->idControleEtapa =  $novoControleEtapaSubitem[$x]["idEtapa"];
                $arrayNovoControleEtapaSubitem = array_merge($arrayNovoControleEtapaSubitem,array($objNovoSubitem));
            }
        }

        $itens = (object) array(
            "arrayControleEtapa"=>$arrayControleEtapa,
            "arrayControleEtapaSubitem"=>$arrayControleEtapaSubitem,
            "arrayNovoControleEtapaSubitem"=>$arrayNovoControleEtapaSubitem
        );
        echo json_encode(array("result"=>true,"itens"=>$itens));
    }
    function entradamercadoria(){
        $this->load->model("produtos_model");
        $controleEtapa = $this->input->post("arrayControleEtapa");
        $controleEtapaSubitem = $this->input->post("arrayControleEtapaSubitem");
        $novoControleEtapaSubitem = $this->input->post("arrayNovoControleEtapaSubitem");
        $arrayControleEtapa = array();
        $arrayControleEtapaSubitem = array();
        $arrayNovoControleEtapaSubitem = array();

        if(!empty($controleEtapa)){
            for($x=0;$x<sizeof($controleEtapa);$x++){
                $objControleEtapa = $this->producao_model->getControleEtapaById($controleEtapa[$x]["id"]);
                $objControleEtapa->local = $controleEtapa[$x]["local"];
                $objControleEtapa->linha = $controleEtapa[$x]["linha"];
                $objControleEtapa->coluna = $controleEtapa[$x]["coluna"];
                $arrayControleEtapa = array_merge($arrayControleEtapa,array($objControleEtapa));
            }
        }

        if(!empty($controleEtapaSubitem)){
            for($x=0;$x<sizeof($controleEtapaSubitem);$x++){
                //echo $controleEtapaSubitem[$x]["id"].",";
                $objControleEtapaSubitem = $this->producao_model->getControleEtapaSubitemById($controleEtapaSubitem[$x]["id"]);
                $objControleEtapaSubitem->quantidade =  $controleEtapaSubitem[$x]["quantidade"];
                $objControleEtapaSubitem->local = $controleEtapaSubitem[$x]["local"];
                $objControleEtapaSubitem->linha = $controleEtapaSubitem[$x]["linha"];
                $objControleEtapaSubitem->coluna = $controleEtapaSubitem[$x]["coluna"];
                $arrayControleEtapaSubitem = array_merge($arrayControleEtapaSubitem,array($objControleEtapaSubitem));
            }
        }

        if(!empty($novoControleEtapaSubitem)){
            for($x=0;$x<sizeof($novoControleEtapaSubitem);$x++){
                //echo $controleEtapaSubitem[$x]["id"].",";
                $objNovoSubitem = $this->produtos_model->getById($novoControleEtapaSubitem[$x]["id"]);
                $objNovoSubitem->quantidade =  $novoControleEtapaSubitem[$x]["quantidade"];
                $objNovoSubitem->idControleEtapa =  $novoControleEtapaSubitem[$x]["idEtapa"];
                $arrayNovoControleEtapaSubitem = array_merge($arrayNovoControleEtapaSubitem,array($objNovoSubitem));
            }
        }

        $itens = (object) array(
            "arrayControleEtapa"=>$arrayControleEtapa,
            "arrayControleEtapaSubitem"=>$arrayControleEtapaSubitem,
            "arrayNovoControleEtapaSubitem"=>$arrayNovoControleEtapaSubitem
        );
        echo json_encode(array("result"=>true,"itens"=>$itens));
    }
    function saidamercadoria(){
        $this->load->model("produtos_model");
        $controleEtapa = $this->input->post("arrayControleEtapa");
        $controleEtapaSubitem = $this->input->post("arrayControleEtapaSubitem");
        $arrayControleEtapa = array();
        $arrayControleEtapaSubitem = array();
        $arrayNovoControleEtapaSubitem = array();

        if(!empty($controleEtapa)){
            for($x=0;$x<sizeof($controleEtapa);$x++){
                $objControleEtapa = $this->producao_model->getControleEtapaById($controleEtapa[$x]["id"]);
                $objControleEtapa->local = $controleEtapa[$x]["local"];
                $objControleEtapa->linha = $controleEtapa[$x]["linha"];
                $objControleEtapa->coluna = $controleEtapa[$x]["coluna"];
                $arrayControleEtapa = array_merge($arrayControleEtapa,array($objControleEtapa));
            }
        }

        if(!empty($controleEtapaSubitem)){
            for($x=0;$x<sizeof($controleEtapaSubitem);$x++){
                //echo $controleEtapaSubitem[$x]["id"].",";
                $objControleEtapaSubitem = $this->producao_model->getControleEtapaSubitemById($controleEtapaSubitem[$x]["id"]);
                $objControleEtapaSubitem->quantidade =  $controleEtapaSubitem[$x]["quantidade"];
                $objControleEtapaSubitem->local = $controleEtapaSubitem[$x]["local"];
                $objControleEtapaSubitem->linha = $controleEtapaSubitem[$x]["linha"];
                $objControleEtapaSubitem->coluna = $controleEtapaSubitem[$x]["coluna"];
                $arrayControleEtapaSubitem = array_merge($arrayControleEtapaSubitem,array($objControleEtapaSubitem));
            }
        }

        $itens = (object) array(
            "arrayControleEtapa"=>$arrayControleEtapa,
            "arrayControleEtapaSubitem"=>$arrayControleEtapaSubitem
        );
        echo json_encode(array("result"=>true,"itens"=>$itens));
    }
    function confirmarrecebimento(){
        $this->load->model("produtos_model");
        $this->load->model("peritagem_model");
        $idControleEtapa = $this->input->post("idControleEtapa");
        $quantidade = $this->input->post("quantidade");

        $idControleEtapaSubitem = $this->input->post("idControleEtapaSubitem");
        $quantidadeSubitem = $this->input->post("quantidadeSubitem");

        $idProduto = $this->input->post("idProduto");
        $idEtapaNovoSubitem = $this->input->post("idEtapaNovoSubitem");
        $quantidadeNovoSubitem = $this->input->post("quantidadeNovoSubitem");
        $nfCliente = $this->input->post("nfcliente");

        if(!empty($idControleEtapa)){
            for($x=0;$x<sizeof($idControleEtapa);$x++){
                $data1 = array(
                    "quantidade"=>$quantidade[$x],
                    "idStatusEtapaServico"=>2,
                    "nf_cliente"=>(!empty($nfCliente)?$nfCliente:null)
                );

                // INSERE NOTA FISCAL NA TABELA CONTROLE_ETAPA
                $this->producao_model->edit("controle_etapa",$data1,"idControleEtapa",$idControleEtapa[$x]);

                // PEGA REGISTRO DA TABELA CONTROLE_ETAPA
                $controle_etapa_result = $this->producao_model->getControleEtapaById($idControleEtapa[$x]);

                // PEGA IDORÇAMENTO_ITEM DO REGISTRO ACIMA
                $idOrcamento_item = $controle_etapa_result->idOrcamento_item;


                if(!empty($nfCliente)){
                    $data_os = array("nf_cliente"=>(!empty($nfCliente)?$nfCliente:null));

                    // INSERE NOTA FISCAL NA TABELA OS
                    $this->producao_model->edit("os",$data_os,"idOrcamento_item",$idOrcamento_item);
                }
               

                $this->producao_model->edit("orcamento_item",array("statusDesenho"=>1,"data_solicitar_desenho"=>date('Y-m-d H:i:s')),"idOrcamento_item",$controle_etapa_result->idOrcamento_item);

                $orc_escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem($idOrcamento_item);
                if($orc_escopo->idStatusPeritagem == 1){
                    $idStatusPeritagem = 5;
                    $this->producao_model->edit("orc_servico_escopo",array("idStatusPeritagem"=>$idStatusPeritagem),"idOrcServicoEscopo",$orc_escopo->idOrcServicoEscopo);
                }

                $data11 = array(
                    "idControleEtapa"=>$idControleEtapa[$x],
                    "idStatusEtapaServico"=>2,
                    "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                    "idUsuarioAcao"=>null,
                    "assinatura"=>null,
                    "data_alteracao"=>date('Y-m-d H:i:s')
                );
                $this->producao_model->add("controle_etapa_hist_status",$data11,true);
            }
        }
        
        if(!empty($idControleEtapaSubitem)){
            for($x=0;$x<sizeof($idControleEtapaSubitem);$x++){
                $data2 = array(
                    "quantidade"=>$quantidadeSubitem[$x],
                    "idStatusEtapaServico"=>2
                );
                $this->producao_model->edit("controle_etapa_subitem",$data2,"idControleEtapaSubitem",$idControleEtapaSubitem[$x]);
                $data2 = array(
                    "idControleEtapaSubitem"=> $idControleEtapaSubitem[$x],
                    "idStatusEtapaServico"=>2,
                    "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                    "idUsuarioAcao"=>null,
                    "assinatura"=>null,
                    "data_alteracao"=>date('Y-m-d H:i:s')
                );
                $this->producao_model->add("controle_etapa_subitem_hist_status",$data2);
            }
        }
        
        if(!empty($idProduto)){
            for($x=0;$x<sizeof($idProduto);$x++){
                $objProduto = $this->produtos_model->getById($idProduto[$x]);
                $dataNovoSub = array(
                    "idControleEtapa"=>$idEtapaNovoSubitem[$x],
                    //"idOsSub"=>$idSubOs,
                    "idProduto"=>$idProduto[$x],
                    "descricaoItem"=>$objProduto->descricao,
                    "quantidade"=>$quantidadeNovoSubitem[$x],
                    "idStatusEtapaServico"=>2,
                    "local"=>null,
                    "data_cadastro"=>date('Y-m-d H:i:s')
                );
                $idControleSub = $this->producao_model->add("controle_etapa_subitem",$dataNovoSub,true);
                $data2 = array(
                    "idControleEtapaSubitem"=> $idControleSub,
                    "idStatusEtapaServico"=>2,
                    "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                    "idUsuarioAcao"=>null,
                    "assinatura"=>null,
                    "data_alteracao"=>date('Y-m-d H:i:s')
                );
                $this->producao_model->add("controle_etapa_subitem_hist_status",$data2);
            }
        }
        
        $this->session->set_flashdata('success','Confirmado o recebimento dos itens.');
        redirect(base_url().'index.php/controle/recebimento/'.$this->input->post('idOrcamentoEtapa'));
    }
    function confirmarentrada(){
        $this->load->model("produtos_model");
        $idControleEtapa = $this->input->post("idControleEtapa");
        $quantidade = $this->input->post("quantidadeModal");
        $local = $this->input->post("localModal");
        $linha = $this->input->post("linhaModal");
        $coluna = $this->input->post("colunaModal");

        $idControleEtapaSubitem = $this->input->post("idControleEtapaSubitem");
        $quantidadeSubitem = $this->input->post("quantidadeSubitem");
        $localSub = $this->input->post("localModalSubitem");
        $linhaSub = $this->input->post("linhaModalSubitem");
        $colunaSub = $this->input->post("colunaModalSubitem");

        if(!empty($idControleEtapa)){
            for($x=0;$x<sizeof($idControleEtapa);$x++){
                $data1 = array(
                    "quantidade"=>$quantidade[$x],
                    "idStatusEtapaServico"=>3,
                    "local"=>$local[$x],
                    "linha"=>$linha[$x],
                    "coluna"=>$coluna[$x]
                );
                $this->producao_model->edit("controle_etapa",$data1,"idControleEtapa",$idControleEtapa[$x]);
                $data11 = array(
                    "idControleEtapa"=>$idControleEtapa[$x],
                    "idStatusEtapaServico"=>3,
                    "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                    "idUsuarioAcao"=>null,
                    "assinatura"=>null,
                    "data_alteracao"=>date('Y-m-d H:i:s')
                );
                $this->producao_model->add("controle_etapa_hist_status",$data11,true);
            }
        }
        if(!empty($idControleEtapaSubitem)){
            for($x=0;$x<sizeof($idControleEtapaSubitem);$x++){
                $objControleSubItem = $this->producao_model->getOnlyControleEtapaSubitemById($idControleEtapaSubitem[$x]);
                if($objControleSubItem->idStatusEtapaServico != 3){
                    if($quantidadeSubitem[$x]>$objControleSubItem->quantidade){
                        $this->session->set_flashdata('error','A quantidade informada é maior que a quantidade registrada.');
                        redirect(base_url().'index.php/controle/armazenar');
                    }else if($quantidadeSubitem[$x]<$objControleSubItem->quantidade){
                        $data = clone $objControleSubItem;
                        $data->idControleEtapaSubitem = null;
                        $data->quantidade = $quantidadeSubitem[$x];
                        $data->idStatusEtapaServico = 3;
                        $data->local = $localSub[$x];
                        $objControleSubItem->quantidade = $objControleSubItem->quantidade-$quantidadeSubitem[$x];
                        $this->producao_model->edit('controle_etapa_subitem',$objControleSubItem,'idControleEtapaSubitem',$objControleSubItem->idControleEtapaSubitem);
                        $id = $this->producao_model->add("controle_etapa_subitem",$data,true);
                        $statusHist =  $this->producao_model->getControleStatusHistByIdControleEtapaSubitem($objControleSubItem->idControleEtapaSubitem);
                        foreach($statusHist as $r){
                            $r->idControleEtapaSubitem = $id;
                            $r->idControleEtapaSubitemHistStatus = null;
                            $this->producao_model->add("controle_etapa_subitem_hist_status",$r);
                        }
                        $data2 = array(
                            "idControleEtapaSubitem"=>$id,
                            "idStatusEtapaServico"=>3,
                            "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                            //"idUsuarioAcao"=>$idUser,
                            "data_alteracao"=>date('Y-m-d H:i:s')
                        );
                        $this->producao_model->add("controle_etapa_subitem_hist_status",$data2,true);
                    }else{
                        $data2 = array(
                            "quantidade"=>$quantidadeSubitem[$x],
                            "idStatusEtapaServico"=>3,
                            "local"=>$localSub[$x],
                            "linha"=>$linhaSub[$x],
                            "coluna"=>$colunaSub[$x]
                        );
                        $this->producao_model->edit("controle_etapa_subitem",$data2,"idControleEtapaSubitem",$idControleEtapaSubitem[$x]);
                        $data2 = array(
                            "idControleEtapaSubitem"=> $idControleEtapaSubitem[$x],
                            "idStatusEtapaServico"=>3,
                            "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                            "idUsuarioAcao"=>null,
                            "assinatura"=>null,
                            "data_alteracao"=>date('Y-m-d H:i:s')
                        );
                        $this->producao_model->add("controle_etapa_subitem_hist_status",$data2);
                    }
                }
                
            }
        }
        
        $this->session->set_flashdata('success','Confirmado a entrada dos itens no estoque.');
        redirect(base_url().'index.php/controle/entrada2/'.$this->input->post('idOrcamentoEtapa'));
    }
    function confirmarsaida(){
        $this->load->model("produtos_model");
        $idControleEtapa = $this->input->post("idControleEtapa");
        $quantidade = $this->input->post("quantidade");
        $local = $this->input->post("localModal");
        $linha = $this->input->post("linhaModal");
        $coluna = $this->input->post("colunaModal");

        $idControleEtapaSubitem = $this->input->post("idControleEtapaSubitem");
        $quantidadeSubitem = $this->input->post("quantidadeSubitem");
        $localSub = $this->input->post("localModalSubitem");
        $linhaSub = $this->input->post("linhaModalSubitem");
        $colunaSub = $this->input->post("colunaModalSubitem");

        $assinatura = $this->input->post("assinatura");
        $statusServico = $this->input->post("statusServico");
        $idUser = $this->input->post("idUser");
        if(!empty($assinatura)){
            $encoded_image = explode(",", $assinatura)[1];
            $decoded_image = base64_decode($encoded_image);
            $target_dir = "./assets/assinaturas/";
            $target_dir2 = "assets/assinaturas/";
            $nomeAssinatura = $this->generateRandomString().".png";
            $target_file = $target_dir.$nomeAssinatura;
            $target_file2 = $target_dir2.$nomeAssinatura;
            file_put_contents($target_file, $decoded_image);
        }else{
            $this->session->set_flashdata('error','O assinatura deve ser preenchida.');
            redirect(base_url().'index.php/controle/armazenar');
        }

        if(!empty($idControleEtapa)){
            for($x=0;$x<sizeof($idControleEtapa);$x++){
                $objControle = $this->producao_model->getOnlyControleEtapaById($idControleEtapa[$x]);
                if($objControle->idStatusEtapaServico != $statusServico){
                    if($quantidade[$x]>$objControle->quantidade || $quantidade[$x]<=0){
                        $this->session->set_flashdata('error','A quantidade informada é maior que a quantidade registrada.');
                        redirect(base_url().'index.php/controle/armazenar');
                    } else if($quantidade[$x]<$objControle->quantidade){
                        $data = clone $objControle;
                        $data->idControleEtapa = null;
                        $data->quantidade = $quantidade[$x];
                        $data->idStatusEtapaServico = $statusServico;
                        $data->local = null;
                        $objControle->quantidade = $objControle->quantidade-$quantidade[$x];
                        $this->producao_model->edit('controle_etapa',$objControle,'idControleEtapa',$objControle->idControleEtapa);
                        $id = $this->producao_model->add("controle_etapa",$data,true);
                        $statusHist =  $this->producao_model->getControleStatusHistByIdControleEtapa($objControle->idControleEtapa);
                        foreach($statusHist as $r){
                            $r->idControleEtapa = $id;
                            $r->idControleEtapaHistStatus = null;
                            $this->producao_model->add("controle_etapa_hist_status",$r);
                        }
                        $data2 = array(
                            "idControleEtapa"=>$id,
                            "idStatusEtapaServico"=>$statusServico,
                            "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                            "idUsuarioAcao"=>$idUser,
                            "assinatura"=>$target_file2,
                            "data_alteracao"=>date('Y-m-d H:i:s')
                        );
                        $this->producao_model->add("controle_etapa_hist_status",$data2,true);
                    
                    }else{
                        $data1 = array(
                            "quantidade"=>$quantidade[$x],
                            "idStatusEtapaServico"=>$statusServico,
                            "local"=>$local[$x],
                            "linha"=>$linha[$x],
                            "coluna"=>$coluna[$x]
                        );
                        $this->producao_model->edit("controle_etapa",$data1,"idControleEtapa",$idControleEtapa[$x]);
                        $data11 = array(
                            "idControleEtapa"=>$idControleEtapa[$x],
                            "idStatusEtapaServico"=>$statusServico,
                            "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                            "idUsuarioAcao"=>null,
                            "assinatura"=>$target_file2,
                            "data_alteracao"=>date('Y-m-d H:i:s')
                        );
                        $this->producao_model->add("controle_etapa_hist_status",$data11,true);
                    }
                }                
            }
        }
        
        if(!empty($idControleEtapaSubitem)){
            for($x=0;$x<sizeof($idControleEtapaSubitem);$x++){
                $objControleSubItem = $this->producao_model->getOnlyControleEtapaSubitemById($idControleEtapaSubitem[$x]);
                if($objControleSubItem->idStatusEtapaServico != $statusServico){
                    if($quantidadeSubitem[$x]>$objControleSubItem->quantidade){
                        $this->session->set_flashdata('error','A quantidade informada é maior que a quantidade registrada.');
                        redirect(base_url().'index.php/controle/armazenar');
                    }else if($quantidadeSubitem[$x]<$objControleSubItem->quantidade){
                        $data = clone $objControleSubItem;
                        $data->idControleEtapaSubitem = null;
                        $data->quantidade = $quantidadeSubitem[$x];
                        $data->idStatusEtapaServico = $statusServico;
                        $data->local = null;
                        $objControleSubItem->quantidade = $objControleSubItem->quantidade-$quantidadeSubitem[$x];
                        $this->producao_model->edit('controle_etapa_subitem',$objControleSubItem,'idControleEtapaSubitem',$objControleSubItem->idControleEtapaSubitem);
                        $id = $this->producao_model->add("controle_etapa_subitem",$data,true);
                        $statusHist =  $this->producao_model->getControleStatusHistByIdControleEtapaSubitem($objControleSubItem->idControleEtapaSubitem);
                        foreach($statusHist as $r){
                            $r->idControleEtapaSubitem = $id;
                            $r->idControleEtapaSubitemHistStatus = null;
                            $this->producao_model->add("controle_etapa_subitem_hist_status",$r);
                        }
                        $data2 = array(
                            "idControleEtapaSubitem"=>$id,
                            "idStatusEtapaServico"=>$statusServico,
                            "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                            "idUsuarioAcao"=>$idUser,
                            "assinatura"=>$target_file2,
                            "data_alteracao"=>date('Y-m-d H:i:s')
                        );
                        $this->producao_model->add("controle_etapa_subitem_hist_status",$data2,true);
                    }else{
                        $data2 = array(
                            "quantidade"=>$quantidadeSubitem[$x],
                            "idStatusEtapaServico"=>$statusServico,
                            "local"=>$localSub[$x],
                            "linha"=>$linhaSub[$x],
                            "coluna"=>$colunaSub[$x]
                        );
                        $this->producao_model->edit("controle_etapa_subitem",$data2,"idControleEtapaSubitem",$idControleEtapaSubitem[$x]);
                        $data2 = array(
                            "idControleEtapaSubitem"=> $idControleEtapaSubitem[$x],
                            "idStatusEtapaServico"=>$statusServico,
                            "idUsuarioSis"=>$this->session->userdata('idUsuarios'),
                            "idUsuarioAcao"=>$idUser,
                            "assinatura"=>$target_file2,
                            "data_alteracao"=>date('Y-m-d H:i:s')
                        );
                        $this->producao_model->add("controle_etapa_subitem_hist_status",$data2);
                    }
                }
            }
        }
        
        $this->session->set_flashdata('success','Confirmado a saída dos itens no estoque.');
        redirect(base_url().'index.php/controle/saida2/'.$this->input->post('idOrcamentoEtapa'));
    }

}