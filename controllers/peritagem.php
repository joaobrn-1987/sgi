<?php

class Peritagem extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('peritagem_model', '', TRUE);     
        $this->load->model('orcamentos_model');             
        $this->data['menuPeritagem'] = 'peritagem';
        
    }
    function index()
    {
        $this->gerenciar();
    }
    function gerenciar(){

    }
    function listaperitagem(){ 
        $this->data['view'] = 'peritagem/peritagem';
        $tipo = "";
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vPeritagem')){
            $this->session->set_flashdata('error','Você não tem permissão para visualizar peritagem.');
            redirect(base_url());
        }
        $primeiro =true;
        if($this->permission->checkPermission($this->session->userdata('permissao'),'peritagemCil')){
            if($primeiro){
                $tipo = $tipo."\"cil\"";
                $primeiro =false;
            }else{
                $tipo = $tipo.",\"cil\"";
            }
            
        }
        if($this->permission->checkPermission($this->session->userdata('permissao'),'peritagemMaq')){
            if($primeiro){
                $tipo = $tipo."\"maq\"";
                $primeiro =false;
            }else{
                $tipo = $tipo.",\"maq\"";
            }
        }
        if($this->permission->checkPermission($this->session->userdata('permissao'),'peritagemSub')){
            if($primeiro){
                $tipo = $tipo."\"sub\"";
                $primeiro =false;
            }else{
                $tipo = $tipo.",\"sub\"";
            }
        }
        if($this->permission->checkPermission($this->session->userdata('permissao'),'peritagemPec')){
            if($primeiro){
                $tipo = $tipo."\"pec\"";
                $primeiro =false;
            }else{
                $tipo = $tipo.",\"pec\"";
            }
        }
        $where = "";
        $idOrcamento = $this->input->post('idOrcamento');
        if(!empty($idOrcamento)){
            $where .= " and orcamento.idOrcamentos = ".$idOrcamento;
        }
        $idOs = $this->input->post('idOs');
        if(!empty($idOs)){
            $where .= " and os.idOs = ".$idOs;
        }
        $pn = $this->input->post('pn');
        if(!empty($pn)){
            $where .= " and produtos.pn like '%".$pn."'";
        }
        $descricaoOrc = $this->input->post('descricaoOrc');
        if(!empty($descricaoOrc)){
            $where .= " and orcamento_item.descricao_item like '%".$descricaoOrc."'";
        }
        $statusPeritagem = $this->input->post('statusPeritagem');
        if(!empty($statusPeritagem)){
            $where .= " and orc_servico_escopo.idStatusPeritagem = ".$statusPeritagem;
        }else if($this->permission->checkPermission($this->session->userdata('permissao'),'cPeritagem') && empty($where)){
            $where .= " and orc_servico_escopo.idStatusPeritagem = 3";
            $statusPeritagem = 3;
        }
        $this->data['idStatusPeritagem2'] = $statusPeritagem;
        $this->data['statusPeritagem'] = $this->peritagem_model->getStatusPeritagem();
        $this->data['aguardandoPer'] = $this->peritagem_model->aguardandoPeritagem2($tipo,$where);
        $this->load->view('tema/topo',$this->data);
    }
    function criarperitagemorc(){
        if(!empty($this->input->post('idOrcServicoEscopoItens'))){
            echo '<script>console.log(2)</script>';
            $this->atualizarOrcEscopoItens();
        }
        if(!empty($this->input->post('idProdutoP'))){
            $idEscopo = $this->criarescopoespecifico();
            if(empty($idEscopo)){
                $this->session->set_flashdata('error','Erro ao criar o escopo especifico');
                redirect('orcamentos/escopo/'.$this->input->post('idOrcItem').'/'.$this->input->post('idEscopo'));
                return;
            }
        }else{
            if(empty($this->input->post('idEscopo'))){
                $idEscopo = $this->criarescopo();
                $this->criaritensescopo($idEscopo);
            }else if(!empty($this->input->post('descricaoServico'))){
                $idEscopo = $this->input->post('idEscopo');
                $this->criaritensescopo($idEscopo);
            }else{
                $idEscopo = $this->input->post('idEscopo');
            }
        }        
        $this->criarescopoorc($idEscopo);
        $this->session->set_flashdata('success','Escopo selecionado e salvo com sucesso.');
        redirect('orcamentos/escopo/'.$this->input->post('idOrcItem').'/'.$idEscopo);
    }

    function criarescopo(){
        $data = array(
            'nomeServicoEscopo'=> strtoupper($this->input->post('descricaoEscopo')),
            'idProduto'=> $this->input->post('idProdutoEsc'),
            'tipoServico'=> $this->input->post('tipoServico')
        );
        $id = $this->peritagem_model->add("servico_escopo",$data,true);
        return $id;
    }

    function criaritensescopo($idEscopo){
        $count = count($this->input->post('descricaoServico'));
        if($count >0){
            for($x=0;$x<$count;$x++){
                if(!empty($this->input->post('idProdutoC')[$x])){
                    $produto = $this->input->post('idProdutoC')[$x];
                }else{
                    $produto = null;
                }
                if(!empty($this->input->post('descricaoServico')[$x])){
                    $data = array(
                        'idProduto'=>$produto,
                        'idServicoEscopo'=>$idEscopo,
                        'descricaoServicoItens'=>strtoupper($this->input->post('descricaoServico')[$x]),
                        'idClasse'=>$this->input->post('tipoClasse')[$x]
                    );
                    $this->peritagem_model->add("servico_escopo_itens",$data,true);
                }
            }
        }        
    }

    function criarescopoorc($id){
        $escopo = $this->peritagem_model->getEscopoById($id);
        $escopoItens = $this->peritagem_model->getEscopoItensByIdEscopo($id);
        $escopoOrc = $this->peritagem_model->getEscopoOrcByidEscopoAndIdOrcItem($id,$this->input->post('idOrcItem'));
        if(!empty($escopoOrc)){
            $escopoOrcItens = $this->peritagem_model->getEscopoItensOrcByidEscopoAndIdOrcItem($escopoOrc->idOrcServicoEscopo);
            $verifyItem = false;
            foreach($escopoItens as $r){
                $verifyItem = false;
                foreach($escopoOrcItens as $b){
                    if($b->idServicoEscopoItens == $r->idServicoEscopoItens){
                        $verifyItem = true;
                    }
                }
                if(!$verifyItem){
                    $data2 = array(
                        'idServicoEscopoItens'=>$r->idServicoEscopoItens,
                        'idOrcServicoEscopo'=> $escopoOrc->idOrcServicoEscopo,
                        'ativo'=>$r->ativo
                    );
                    $this->peritagem_model->add("orc_servico_escopo_itens",$data2,true);
                }
            }
            if($this->input->post('idStatusPeritagem')<=2){
                $data = array('idStatusPeritagem'=>$this->input->post('idStatusPeritagem'));
                $this->peritagem_model->edit("orc_servico_escopo",$data,"idOrcServicoEscopo",$escopoOrc->idOrcServicoEscopo);
            }
            $idOrcServEscopo = $escopoOrc->idOrcServicoEscopo;
        }else{
            if($this->input->post('idStatusPeritagem')<=2){
                $data = array(
                    'idServicoEscopo'=>$id,
                    'idOrcItem'=>$this->input->post('idOrcItem'),
                    'idStatusPeritagem'=>$this->input->post('idStatusPeritagem')
                );
            }else{
                $data = array(
                    'idServicoEscopo'=>$id,
                    'idOrcItem'=>$this->input->post('idOrcItem'),
                    'idStatusPeritagem'=>1
                );
            }
            
            $idOrcServEscopo = $this->peritagem_model->add("orc_servico_escopo",$data,true);
            foreach($escopoItens as $r){
                $data2 = array(
                  'idServicoEscopoItens'=>$r->idServicoEscopoItens,
                  'idOrcServicoEscopo'=> $idOrcServEscopo
                );
                $this->peritagem_model->add("orc_servico_escopo_itens",$data2,true);
            }
            $orc = $this->orcamentos_model->get_item_orc2($this->input->post('idOrcItem'));
            if($escopo->tipoServico == "cil"){
                $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemCil";s:1:"1";');
            }
            if($escopo->tipoServico == "maq"){
                $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemMaq";s:1:"1";');
            }
            if($escopo->tipoServico == "sub"){
                $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemSub";s:1:"1";');
            }
            if($escopo->tipoServico == "pec"){
                $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagem('"peritagemPec";s:1:"1";');
            }
            //$vendedor = $this->orcamentos_model->getVendedor($orc->idVendedor);
            $email = "";
            foreach($peritagem as $r){
                if(!empty($r->email)){
                    //$this->send($r->email,"Orçamento: ".$orc->idOrcamentos." - SOLICITAÇÃO DE PERITAGEM","PN: ".$orc->pn." - ".$orc->descricao_item);
                    $email = $email.$r->email.",";
                }
            }
            try{
                $this->send($email,"Orçamento: ".$orc->idOrcamentos." - SOLICITAÇÃO DE PERITAGEM","PN: ".$orc->pn." - ".$orc->descricao_item);
            }catch(Exception $e){}
        }

        $this->peritagem_model->desativarEscoposOrcItem($this->input->post('idOrcItem'),$idOrcServEscopo);
        $this->peritagem_model->ativarEscoposOrcItem($idOrcServEscopo);
    }

    function criarescopoespecifico(){ 
        $this->load->model('produtos_model');        
        $verificar = false;
        for($x=0;$x<count($this->input->post('idProdutoP'));$x++){
            if(!empty($this->input->post('idProdutoP')[$x])){
                $verificar = true;
            }
            echo $verificar;
        }
        if(!$verificar){
            echo 0;
            return 0;
        }
        $produto = $this->produtos_model->getById($this->input->post('idProdutoEsc'));
        $data = array(
            'nomeServicoEscopo'=> strtoupper('Checklist Especifico: '.$produto->pn),
            'idProduto'=> $this->input->post('idProdutoEsc'),
            'tipoServico'=> $this->input->post('tipoServico')
        );
        $idEscopo = $this->peritagem_model->add("servico_escopo",$data,true);
        for($x=0;$x<count($this->input->post('idProdutoP'));$x++){
            if(!empty($this->input->post('idProdutoP')[$x])){
                $itemEscopo = $this->peritagem_model->getEscopoItemByIdEscopoItem($this->input->post('idServicoEscopoItens')[$x]);
                $novoItem = clone $itemEscopo;
                $novoItem->idServicoEscopoItens = 0;
                $novoItem->ativo = 1;
                $novoItem->idServicoEscopo = $idEscopo;
                $novoItem->idProduto = $this->input->post('idProdutoP')[$x];
                $this->peritagem_model->add("servico_escopo_itens",$novoItem,true);
            }
        }
        echo $idEscopo;
        return $idEscopo;        
    }
    /*
    function escopoperitagem(){
        $idOrcServEscopo = $this->uri->segment(3);
        $this->data['escopoItens'] = $this->peritagem_model->itensPeritagem($idOrcServEscopo);
        $this->data['escopo'] = $this->peritagem_model->getOrcEscopo($idOrcServEscopo);
        $this->load->model('orcamentos_model');        
        $this->data["orcamentoItem"] = $this->orcamentos_model->getOrcItemDetailsById($this->data['escopo']->idOrcItem);
        $this->data['idOrcServEscopo'] = $idOrcServEscopo;
        $this->data['anexoDesenho'] = $this->orcamentos_model->getAnexoDesenhoAguardandoAprovacao($this->data['escopo']->idOrcItem);
        $this->data['view'] = 'peritagem/escopoPeritagem';
        $this->load->view('tema/topo',$this->data);
    }
    */
    function escopoperitagem(){
        $idOrcamento = $this->uri->segment(3);
        $listIdOrcamentoItem = str_replace("_",",",$this->uri->segment(4));
        $this->load->model('orcamentos_model');    
        $this->data['orcam'] =  $this->orcamentos_model->getOrcamento($idOrcamento);
        //$this->data['orcItem'] = $this->orcamentos_model->getorc_item3($idOrcamento);
        $this->data['orcItem'] = $this->orcamentos_model->getorc_itemList($listIdOrcamentoItem);

        $this->data['view'] = 'peritagem/escopoPeritagem';
        $this->load->view('tema/topo',$this->data);
    }
    /*
    function salvaravaliacao(){
        if(!empty($this->input->post('idOrcServicoEscopoItens'))){
            for($x=0;$x<count($this->input->post('idOrcServicoEscopoItens'));$x++){
                if(!empty($this->input->post('quantidade')[$x])){
                    $data = array(
                        'quantidade'=>$this->input->post('quantidade')[$x],
                        'selected'=>1,
                        'dimenExt'=>$this->input->post('dimenExt')[$x],
                        'dimenInt'=>$this->input->post('dimenInt')[$x],
                        'dimenComp'=>$this->input->post('dimenComp')[$x],
                        'obs'=>$this->input->post('obs')[$x]
                    );
                }else{
                    $data = array(
                        'quantidade'=>null,
                        'selected'=>0,
                        'dimenExt'=>null,
                        'dimenInt'=>null,
                        'dimenComp'=>null,
                        'obs'=>null
                    );
                }
                $this->peritagem_model->edit('orc_servico_escopo_itens',$data,'idOrcServicoEscopoItens',$this->input->post('idOrcServicoEscopoItens')[$x]);
                
            }
        }
        $this->session->set_flashdata('success','Escopo salvo com sucesso.');
        redirect('peritagem/escopoperitagem/'.$this->input->post('idOrcServicoEscopo'));
    }*/

    function salvaravaliacao(){
        $button = $this->input->post("salvarChecklist");
        //echo $button;
        //exit;
        //if(!empty($button)){
            $this->additenschecklist();
            //return;
        //}
        $itens = "";
        foreach($this->input->post('idOrcEscopo') as $r){
            $contagem = 0;
            $idOrcServicoEscopoItens_ = 'idOrcServicoEscopoItens_'.$r;
            $tipoCampo_ = 'tipoCampo_'.$r;
            $quantidade_ = 'quantidade_'.$r;
            $dimenExt_ = 'dimenExt_'.$r;
            $dimenInt_ = 'dimenInt_'.$r;
            $dimenComp_ = 'dimenComp_'.$r;
            $obs_ = 'obs_'.$r;

            $check_ = 'check_'.$r;

            $radio_ = 'radio_'.$r;

            for($x = 0;$x < count($this->input->post($idOrcServicoEscopoItens_)); $x ++){
                if($this->input->post($tipoCampo_)[$x] == "input"){
                    if(!empty($this->input->post($quantidade_)[$x])){
                        $data = array(
                            'quantidade'=>$this->input->post($quantidade_)[$x],
                            'checkbox'=>0,
                            'selected'=>1,
                            'dimenExt'=>$this->input->post($dimenExt_)[$x],
                            'dimenInt'=>$this->input->post($dimenInt_)[$x],
                            'dimenComp'=>$this->input->post($dimenComp_)[$x]
                        );
                    }else{
                        $data = array(
                            'quantidade'=>null,
                            'checkbox'=>0,
                            'selected'=>0,
                            'dimenExt'=>null,
                            'dimenInt'=>null,
                            'dimenComp'=>null
                        );
                    }
                }            
                if($this->input->post($tipoCampo_)[$x] == "check"){
                    if($this->input->post($check_.'_'.$this->input->post($idOrcServicoEscopoItens_)[$x])!==null && !empty($this->input->post($check_.'_'.$this->input->post($idOrcServicoEscopoItens_)[$x]))){
                        $data = array(
                            'quantidade'=>1,
                            'checkbox'=>1,
                            'selected'=>1,
                            'dimenExt'=>null,
                            'dimenInt'=>null,
                            'dimenComp'=>null
                        );
                    }else{
                        $data = array(
                            'quantidade'=>null,
                            'checkbox'=>0,
                            'selected'=>0,
                            'dimenExt'=>null,
                            'dimenInt'=>null,
                            'dimenComp'=>null
                        );
                    }
                }             
                if($this->input->post($tipoCampo_)[$x] == "radio"){
                    if($this->input->post($radio_.'_'.$this->input->post($idOrcServicoEscopoItens_)[$x])!==null 
                    && !empty($this->input->post($radio_.'_'.$this->input->post($idOrcServicoEscopoItens_)[$x]))){
                        $data = array(
                            'quantidade'=>1,
                            'checkbox'=>1,
                            'selected'=>1,
                            'dimenExt'=>null,
                            'dimenInt'=>null,
                            'dimenComp'=>null
                        );
                    }else{
                        $data = array(
                            'quantidade'=>null,
                            'checkbox'=>0,
                            'selected'=>0,
                            'dimenExt'=>null,
                            'dimenInt'=>null,
                            'dimenComp'=>null
                        );
                    }
                }  
                $this->peritagem_model->edit('orc_servico_escopo_itens',$data,'idOrcServicoEscopoItens',$this->input->post($idOrcServicoEscopoItens_)[$x]);
            }
            $dataEsc = array(
                "obs"=>$this->input->post("observacaoEscopo")[$contagem]
            );
            $escopo = $this->peritagem_model->getOrcEscopoActiveByOrcItem2($r);
            if(!empty($escopo)){
                $this->peritagem_model->edit('orc_servico_escopo',$dataEsc,'idOrcServicoEscopo',$escopo->idOrcServicoEscopo);
            }            
            $contagem++;
        }
        $this->session->set_flashdata('success','Escopo salvo com sucesso.');
        redirect('peritagem/escopoperitagem/'.$this->input->post('idOrcamento').'/'.$this->input->post('idOrcItemRedirect'));
    }

    function additenschecklist(){
        $catalogoitens = $this->input->post("idCatalogoItensNovosItens");
        $orcServicoEscopo = $this->input->post("idOrcEscopoNovosItens");
        /*
        echo json_encode($catalogoitens);
        echo "<br>";
        echo json_encode($orcServicoEscopo);
        */
        $this->load->model('orcamentos_model');
        $tiposServicos = $this->orcamentos_model->getAllTiposServico();
        for($r= 0; $r<count($catalogoitens);$r++){
            if(!empty($catalogoitens)){
                $pn = $this->input->post("novoEscopoPN_".$catalogoitens[$r]);
                $idProduto = $this->input->post("novoEscopoIdProduto_".$catalogoitens[$r]);
                $descricao = $this->input->post("novoEscopoDescProd_".$catalogoitens[$r]);
                $classe = $this->input->post("selectClasse_".$catalogoitens[$r]);
                $objOrcEscopo = $this->peritagem_model->getOrcEscopo($orcServicoEscopo[$r]);
                $idServicoEscopo = $objOrcEscopo->idServicoEscopo;
                
                
                for($x = 0; $x < count($pn);$x++){
                    $idEscopoItens = null;
                    if(!empty($idProduto[$x])){
                        $data = array(
                            "idProduto"=>$idProduto[$x],
                            "descricaoServicoItens"=>$descricao[$x],
                            "idServicoEscopo"=>$idServicoEscopo,
                            "idClasse"=>$classe[$x],
                            "tipoCampo"=>"input",
                            "ativo"=>1
                        );
                        $idEscopoItens = $this->peritagem_model->add("servico_escopo_itens",$data,true);
                    }else if(!empty($pn[$x])){
                        $produtos = $this->produtos_model->getByPn2($pn[$x]);
                        $data = array(
                            "idProduto"=>$produtos->idProdutos,
                            "descricaoServicoItens"=>$descricao[$x],
                            "idServicoEscopo"=>$idServicoEscopo,
                            "idClasse"=>$classe[$x],
                            "tipoCampo"=>"input",
                            "ativo"=>1
                        );
                        $idEscopoItens = $this->peritagem_model->add("servico_escopo_itens",$data,true);
                    }
    
                    if(!empty($idEscopoItens)){
                        $data = array(
                            "idServicoEscopoItens"=>$idEscopoItens,
                            "idOrcServicoEscopo"=>$orcServicoEscopo[$r],
                            //'tiposServico'=>($classe[$x] == 1?json_encode($this->orcamentos_model->getAllTiposServico()):null),
                            "data_cadastro"=>date('Y-m-d H:i:s'),
                            "ativo"=>1
                        );
                        $idOrcServItem = $this->peritagem_model->add("orc_servico_escopo_itens",$data,true);
                        foreach($tiposServicos as $l){
                            $data = array(
                                "idTiposServico"=>$l->idTiposServico,
                                "idOrcServicoEscopoItem"=>$idOrcServItem
                            );
                            $this->peritagem_model->add("tiposservico_servitem",$data,true);
                        }
                    }
                }
            }
            
        }
    }

    function atualizarOrcEscopoItens(){
        
        if(!empty($this->input->post('idOrcServicoEscopoItens'))){
            for($x=0;$x<count($this->input->post('idOrcServicoEscopoItens'));$x++){
                if(!empty($this->input->post('quantidade')[$x])){
                    $valor = str_replace(",",".",str_replace(".","",str_replace("R$ ","",$this->input->post('valor')[$x])));
                    $data = array(
                        'quantidade'=>$this->input->post('quantidade')[$x],
                        'valorUnitario'=>$valor,
                        'ativo'=>1
                    );
                    $this->peritagem_model->edit('orc_servico_escopo_itens',$data,'idOrcServicoEscopoItens',$this->input->post('idOrcServicoEscopoItens')[$x]);
                    echo '<script>console.log("'.$valor.'")</script>';
                }else{
                    $data = array(
                        'quantidade'=>null,
                        'valorUnitario'=>0.000,
                        'ativo'=>0
                    );
                    $this->peritagem_model->edit('orc_servico_escopo_itens',$data,'idOrcServicoEscopoItens',$this->input->post('idOrcServicoEscopoItens')[$x]);
                }
            }
        }
    }
    function laudofotografico(){
        $this->data['idOrcamentoItem'] = $this->uri->segment(3);
        $this->data['orcamentoItem'] = $this->orcamentos_model->getOrcItemDetailsById($this->data["idOrcamentoItem"]);
        $this->data['fotografias'] = $this->peritagem_model->getLaudoFotograficoByIdOrcItemAndDetails($this->data['idOrcamentoItem']);
        $this->data['view'] = 'peritagem/laudofotografico';
        $this->load->view('tema/topo',$this->data);
    }
    function laudofotograficocomercial(){
        $this->data['idOrcamentoItem'] = $this->uri->segment(3);
        $this->data['orcamentoItem'] = $this->orcamentos_model->getOrcItemDetailsById($this->data["idOrcamentoItem"]);
        $this->data['fotografias'] = $this->peritagem_model->getLaudoFotograficoByIdOrcItemAndDetails($this->data['idOrcamentoItem']);
        $this->data['view'] = 'orcamentos/laudofotografico';
        $this->load->view('tema/topo',$this->data);
    }

    function salvarlaudo(){
        $idOrcamentoItem = $this->input->post('idOrcamentoItem');
        print_r($_FILES);
        if(isset($_FILES["fileToUpload"])){
            foreach ($_FILES["fileToUpload"]["error"] as $key => $error) {
                $target_dir = "assets/uploads/laudofotografico";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$key]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                //echo "<script>console.log('$imageFileType')</script>";
                if(!empty($_FILES["fileToUpload"]["tmp_name"][$key])){
                    if(getimagesize($_FILES["fileToUpload"]["tmp_name"][$key]) == false){
                        $this->session->set_flashdata('error','Este arquivo não é uma imagem.');
                        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                        return;
                    }
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif"){
                        $this->session->set_flashdata('error','Formato não aceito.');
                        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                        return;
                    }
                }
            }
        }
        foreach($this->input->post('idAnexoLaudo') as $r){
            if(isset($_FILES['file'.$r])){
                $target_dir = "assets/uploads/laudofotografico";
                $target_file = $target_dir . basename($_FILES['file'.$r]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if(!empty($_FILES['file'.$r]["tmp_name"])){
                    if(getimagesize($_FILES['file'.$r]["tmp_name"]) == false){
                        $this->session->set_flashdata('error','Este arquivo não é uma imagem.');
                        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                        return;
                    }
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif"){
                        $this->session->set_flashdata('error','Formato não aceito.');
                        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                        return;
                    }
                }
            }
        }
        if(isset($_FILES["fileToUpload"])){
            $qtd = count($_FILES["fileToUpload"]["error"]);
            for($x = 0; $x < $qtd; $x++){
                $target_dir = "./assets/uploads/laudofotografico/";
                $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"][$x]),PATHINFO_EXTENSION));
                $_FILES["fileToUpload"]["name"][$x] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$x]);
                if (file_exists($target_file)) {
                    $_FILES["fileToUpload"]["name"][$x] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$x]);             
                } print_r($target_file);
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$x], $target_file)) {
                    echo "<script>console.log('". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"][$x])). "')</script>";
                    $data = array(
                        'caminho'=>'assets/uploads/laudofotografico/',
                        'imagem'=>$_FILES["fileToUpload"]["name"][$x],
                        'extensao'=>$imageFileType,
                        'idOrc_item'=>$idOrcamentoItem,
                        'userProprietario'=>$this->session->userdata('idUsuarios'),
                        'data_cadastro'=>date('Y-m-d H:i:s'),
                        'comentarios'=>$this->input->post('inputCommNew')[$x]
                    );
                    $this->peritagem_model->add('anexo_laudo',$data);
                } else {
                    $this->session->set_flashdata('error','Houve um erro ao fazer o upload da imagem.');
                    redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                    return;
                }
            }
        }
        $qtdId = count($this->input->post('idAnexoLaudo'));
        for($x = 0; $x < $qtdId; $x ++){
            if(!empty($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"])){
                $target_dir = "./assets/uploads/laudofotografico/";
                $imageFileType = strtolower(pathinfo(basename($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"]),PATHINFO_EXTENSION));
                $_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                $target_file = $target_dir . basename($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"]);
                if (file_exists($target_file)) {
                    $_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                    $target_file = $target_dir . basename($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"]);             
                } //print_r($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]);
                if (move_uploaded_file($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["tmp_name"], $target_file)) {
                    echo "<script>console.log('". htmlspecialchars( basename( $_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"])). "')</script>";
                    $data = array(
                        'imagem'=>$_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"],
                        'extensao'=>$imageFileType,
                        'comentarios'=>$this->input->post('inputComm')[$x]
                    );
                    $this->peritagem_model->edit('anexo_laudo',$data,'idAnexoLaudo',$this->input->post('idAnexoLaudo')[$x]);
                } else {
                    $this->session->set_flashdata('error','Houve um erro ao fazer o upload da imagem.');
                    redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                    return;
                }
            }else{
                $data = array(
                    'comentarios'=>$this->input->post('inputComm')[$x]
                );
                $this->peritagem_model->edit('anexo_laudo',$data,'idAnexoLaudo',$this->input->post('idAnexoLaudo')[$x]);
            }
        }
        $this->session->set_flashdata('success','Laudo fotográfico salvo com sucesso!');
        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
    }

    function salvarlaudocomercial(){
        $idOrcamentoItem = $this->input->post('idOrcamentoItem');
        print_r($_FILES);
        if(isset($_FILES["fileToUpload"])){
            foreach ($_FILES["fileToUpload"]["error"] as $key => $error) {
                $target_dir = "assets/uploads/laudofotografico";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$key]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                //echo "<script>console.log('$imageFileType')</script>";
                if(!empty($_FILES["fileToUpload"]["tmp_name"][$key])){
                    if(getimagesize($_FILES["fileToUpload"]["tmp_name"][$key]) == false){
                        $this->session->set_flashdata('error','Este arquivo não é uma imagem.');
                        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                        return;
                    }
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif"){
                        $this->session->set_flashdata('error','Formato não aceito.');
                        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                        return;
                    }
                }
            }
        }
        foreach($this->input->post('idAnexoLaudo') as $r){
            if(isset($_FILES['file'.$r])){
                $target_dir = "assets/uploads/laudofotografico";
                $target_file = $target_dir . basename($_FILES['file'.$r]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if(!empty($_FILES['file'.$r]["tmp_name"])){
                    if(getimagesize($_FILES['file'.$r]["tmp_name"]) == false){
                        $this->session->set_flashdata('error','Este arquivo não é uma imagem.');
                        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                        return;
                    }
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif"){
                        $this->session->set_flashdata('error','Formato não aceito.');
                        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                        return;
                    }
                }
            }
        }
        if(isset($_FILES["fileToUpload"])){
            $qtd = count($_FILES["fileToUpload"]["error"]);
            for($x = 0; $x < $qtd; $x++){
                $target_dir = "./assets/uploads/laudofotografico/";
                $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"][$x]),PATHINFO_EXTENSION));
                $_FILES["fileToUpload"]["name"][$x] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$x]);
                if (file_exists($target_file)) {
                    $_FILES["fileToUpload"]["name"][$x] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$x]);             
                } print_r($target_file);
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$x], $target_file)) {
                    echo "<script>console.log('". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"][$x])). "')</script>";
                    $data = array(
                        'caminho'=>'assets/uploads/laudofotografico/',
                        'imagem'=>$_FILES["fileToUpload"]["name"][$x],
                        'extensao'=>$imageFileType,
                        'idOrc_item'=>$idOrcamentoItem,
                        'userProprietario'=>$this->session->userdata('idUsuarios'),
                        'data_cadastro'=>date('Y-m-d H:i:s'),
                        'comentariosExibicao'=>$this->input->post('inputCommNew')[$x]
                    );
                    $this->peritagem_model->add('anexo_laudo',$data);
                } else {
                    $this->session->set_flashdata('error','Houve um erro ao fazer o upload da imagem.');
                    redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                    return;
                }
            }
        }
        $qtdId = count($this->input->post('idAnexoLaudo'));
        for($x = 0; $x < $qtdId; $x ++){
            if(!empty($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"])){
                $target_dir = "./assets/uploads/laudofotografico/";
                $imageFileType = strtolower(pathinfo(basename($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"]),PATHINFO_EXTENSION));
                $_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                $target_file = $target_dir . basename($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"]);
                if (file_exists($target_file)) {
                    $_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                    $target_file = $target_dir . basename($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"]);             
                } //print_r($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]);
                if (move_uploaded_file($_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["tmp_name"], $target_file)) {
                    echo "<script>console.log('". htmlspecialchars( basename( $_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"])). "')</script>";
                    $data = array(
                        'imagem'=>$_FILES['file'.$this->input->post('idAnexoLaudo')[$x]]["name"],
                        'extensao'=>$imageFileType,
                        'comentariosExibicao'=>$this->input->post('inputComm')[$x]
                    );
                    $this->peritagem_model->edit('anexo_laudo',$data,'idAnexoLaudo',$this->input->post('idAnexoLaudo')[$x]);
                } else {
                    $this->session->set_flashdata('error','Houve um erro ao fazer o upload da imagem.');
                    redirect( base_url().'index.php/peritagem/laudofotograficocomercial/'.$idOrcamentoItem );
                    return;
                }
            }else{
                $data = array(
                    'comentariosExibicao'=>$this->input->post('inputComm')[$x]
                );
                $this->peritagem_model->edit('anexo_laudo',$data,'idAnexoLaudo',$this->input->post('idAnexoLaudo')[$x]);
            }
        }
        $this->session->set_flashdata('success','Laudo fotográfico salvo com sucesso!');
        redirect( base_url().'index.php/peritagem/laudofotograficocomercial/'.$idOrcamentoItem );
    }
    function salvarlaudo2(){
        $idOrcamentoItem = $this->input->post('idOrcamentoItem');
        if(isset($_FILES["fileToUpload"])){
            foreach ($_FILES["fileToUpload"]["error"] as $key => $error) {
                $target_dir = "assets/uploads/laudofotografico";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$key]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                //echo "<script>console.log('$imageFileType')</script>";
                if(!empty($_FILES["fileToUpload"]["tmp_name"][$key])){
                    if(getimagesize($_FILES["fileToUpload"]["tmp_name"][$key]) == false){
                        $this->session->set_flashdata('error','Este arquivo não é uma imagem.');
                        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                        return;
                    }
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif"){
                        $this->session->set_flashdata('error','Formato não aceito.');
                        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
                        return;
                    }
                }
            }
        }        
        $qtd = count($_FILES["fileToUpload"]["error"]);
        for($x = 0;$x < $qtd;$x++){
            if(!empty($_FILES["fileToUpload"]["name"][$x])){
                if(!empty($this->input->post('idAnexoLaudo')[$x])){
                    $target_dir = "./assets/uploads/laudofotografico/";
                    $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"][$x]),PATHINFO_EXTENSION));
                    $_FILES["fileToUpload"]["name"][$x] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$x]);
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$x], $target_file)) {
                        echo "<script>console.log('". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"][$x])). "')</script>";
                        $data = array(
                            'imagem'=>$_FILES["fileToUpload"]["name"][$x],
                            'extensao'=>$imageFileType,
                            'userProprietario'=>$this->session->userdata('idUsuarios'),
                            'data_cadastro'=>date('Y-m-d H:i:s'),
                            'comentarios'=>$this->input->post('inputComm')[$x]
                        );
                        $this->peritagem_model->edit('anexo_laudo',$data,'idAnexoLaudo',$this->input->post('idAnexoLaudo')[$x]);
                    } else {
                        $this->session->set_flashdata('error','Houve um erro ao fazer o upload da imagem.');
                    }
                }else{
                    $target_dir = "./assets/uploads/laudofotografico/";
                    $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"][$x]),PATHINFO_EXTENSION));
                    $_FILES["fileToUpload"]["name"][$x] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$x]);
                    if (file_exists($target_file)) {
                        $_FILES["fileToUpload"]["name"][$x] = $idOrcamentoItem."_".$this->generateRandomString().".".$imageFileType;
                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$x]);             
                    }
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$x], $target_file)) {
                        echo "<script>console.log('". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"][$x])). "')</script>";
                        $data = array(
                            'caminho'=>'assets/uploads/laudofotografico/',
                            'imagem'=>$_FILES["fileToUpload"]["name"][$x],
                            'extensao'=>$imageFileType,
                            'idOrc_item'=>$idOrcamentoItem,
                            'userProprietario'=>$this->session->userdata('idUsuarios'),
                            'data_cadastro'=>date('Y-m-d H:i:s'),
                            'comentarios'=>$this->input->post('inputComm')[$x]
                        );
                        $this->peritagem_model->add('anexo_laudo',$data);
                    } else {
                        $this->session->set_flashdata('error','Houve um erro ao fazer o upload da imagem.');
                    }
                }
            }else{
                if(!empty($this->input->post('idAnexoLaudo')[$x])){
                    $data = array(
                        'comentarios'=>$this->input->post('inputComm')[$x]
                    );
                    $this->peritagem_model->edit('anexo_laudo',$data,'idAnexoLaudo',$this->input->post('idAnexoLaudo')[$x]);
                }
            }
            
        }
        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
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
    function deletarlaudo(){
        $idOrcamentoItem = $this->uri->segment(3);
        $data = array('deletado'=>1);
        $this->peritagem_model->edit('anexo_laudo',$data,'idAnexoLaudo',$this->input->post('idFotoLaudo'));
        redirect( base_url().'index.php/peritagem/laudofotografico/'.$idOrcamentoItem );
    }/*
    function finalizarPeritagem(){
        $idOrcServicoEscopo = $this->uri->segment(3);
        $this->load->model('usuarios_model');        
        $data = array (
            'idStatusPeritagem'=>4,
            'idUsuarioFinalizado'=>$this->session->userdata('idUsuarios')
        );
        $this->peritagem_model->edit('orc_servico_escopo',$data,'idOrcServicoEscopo',$idOrcServicoEscopo);
        $this->session->set_flashdata('success','Peritagem finalizada com sucesso!');
        
        $orcServicoEscopo = $this->peritagem_model->getOrcEscopo($idOrcServicoEscopo);
        $orc = $this->orcamentos_model->get_item_orc2($orcServicoEscopo->idOrcItem);
        $vendedor = $this->orcamentos_model->getVendedor($orc->idVendedor);
        $usuarioVend = $this->usuarios_model->getById($vendedor->idUsuario);
        $usuarioPeri = $this->usuarios_model->getById($this->session->userdata('idUsuarios'));
        $escopo = $this->peritagem_model->getEscopoById($orcServicoEscopo->idServicoEscopo);
        if(!empty($usuarioVend->email)){
            $this->send($usuarioVend->email,"Orçamento: ".$orc->idOrcamentos." - PERITAGEM FINALIZADA","PN: ".$orc->pn." - ".$orc->descricao_item."\r\n Confirmada por: ".$usuarioPeri->nome);
        }
        
        redirect( base_url().'index.php/peritagem/escopoperitagem/'.$idOrcServicoEscopo );
    }*/
    function finalizarPeritagem(){
        //$idOrcServicoEscopo = $this->uri->segment(3);
        $this->load->model('usuarios_model');        
        $this->load->model('os_model');        
        foreach($this->input->post('idOrcServEscopo') as $r){
            $data = array (
                'idStatusPeritagem'=>4,
                //'data_finalizado_peritagem'=>date('Y-m-d H:i:s'),
                'idUsuarioFinalizado'=>$this->session->userdata('idUsuarios')
            );
            $this->peritagem_model->edit('orc_servico_escopo',$data,'idOrcServicoEscopo',$r);
            $idOrcServicoEscopo = $r;
            $orcServicoEscopo = $this->peritagem_model->getOrcEscopo($idOrcServicoEscopo);
            $orc = $this->orcamentos_model->get_item_orc2($orcServicoEscopo->idOrcItem);
            $vendedor = $this->orcamentos_model->getVendedor($orc->idVendedor);
            $vendedorAuxiliar = $this->orcamentos_model->getVendedorAuxiliar($orc->idVendedor);
            $data2 = array('data_finalizado_peritagem'=>date('Y-m-d H:i:s'),);
            $this->peritagem_model->edit('orcamento_item',$data2,'idOrcamento_item',$orc->idOrcamento_item);            
            $dataOs = array("idStatusOs"=>204);
            $os = $this->orcamentos_model->getos_item2($orcServicoEscopo->idOrcItem);
            foreach($os as $d){
                //$this->peritagem_model->edit("os",$dataOs,"idOs", $d->idOs);
                $this->os_model->insertOSHis($d,51);
            }
            
          
            $emailVend = "";
            $usuarioVend = $this->usuarios_model->getById($vendedor->idUsuario);
            $usuarioPeri = $this->usuarios_model->getById($this->session->userdata('idUsuarios'));
            if(!empty($usuarioVend->email)){
                //
                $emailVend = $emailVend. $usuarioVend->email .",";
            }
            foreach($vendedorAuxiliar as $r){
                if(!empty($r->email)){
                    //$this->send($r->email,"Orçamento: ".$orc->idOrcamentos." - SOLICITAÇÃO DE PERITAGEM","PN: ".$orc->pn." - ".$orc->descricao_item);
                    $emailVend = $emailVend.$r->email.",";
                }
            }
            if(!empty($emailVend)){
                $this->send($emailVend,"Orçamento: ".$orc->idOrcamentos." - PERITAGEM FINALIZADA","PN: ".$orc->pn." - ".$orc->descricao_item."\r\n Confirmada por: ".$usuarioPeri->nome);
            }
        }
        if($this->input->post('idOrcServEscopo')){
            $this->session->set_flashdata('success','Peritagem finalizada com sucesso!'); 
        }else{
            $this->session->set_flashdata('error','Selecione algum item para finalizar.');
        }
         
        redirect(base_url().'index.php/peritagem/escopoperitagem/'.$this->input->post('idOrcamento2').'/'.$this->input->post('idOrcItemRedirect'));
    }

    function solicitarconfirmacao(){
        $this->load->model('usuarios_model');   
        $this->load->model('os_model');        
        foreach($this->input->post('idOrcServEscopo') as $r){
            $data = array (
                'idStatusPeritagem'=>3
            );
            $data2 = array (
                'idStatusOs'=>203
            );
            $this->peritagem_model->edit('orc_servico_escopo',$data,'idOrcServicoEscopo',$r);
            $idOrcServicoEscopo = $r;
            $orcServicoEscopo = $this->peritagem_model->getOrcEscopo2($idOrcServicoEscopo);
            if($orcServicoEscopo->tipoServico == "cil"){
                $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagemEPermissaoFinalizar('"peritagemCil";s:1:"1";');
            }
            if($orcServicoEscopo->tipoServico == "maq"){
                $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagemEPermissaoFinalizar('"peritagemMaq";s:1:"1";');
            }
            if($orcServicoEscopo->tipoServico == "sub"){
                $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagemEPermissaoFinalizar('"peritagemSub";s:1:"1";');
            }
            if($orcServicoEscopo->tipoServico == "pec"){
                $peritagem = $this->orcamentos_model->getUsuariosComPermissaoPeritagemEPermissaoFinalizar('"peritagemPec";s:1:"1";');
            }
            $orc = $this->orcamentos_model->get_item_orc2($orcServicoEscopo->idOrcItem);
            $os = $this->orcamentos_model->getos_item2($orcServicoEscopo->idOrcItem);
            foreach($os as $d){
                //$this->peritagem_model->edit("os",$data2,"idOs", $d->idOs);
                //$this->os_model->insertOSHis($d,51);
            }
            $emailVend = "";
            $vendedor = $this->orcamentos_model->getVendedor($orc->idVendedor);
            $vendedorAuxiliar = $this->orcamentos_model->getVendedorAuxiliar($orc->idVendedor);
            //$data2 = array('data_finalizado_peritagem'=>date('Y-m-d H:i:s'),);
            //$this->peritagem_model->edit('orcamento_item',$data2,'idOrcamento_item',$orc->idOrcamento_item);
            $usuarioVend = $this->usuarios_model->getById($vendedor->idUsuario);
            if(!empty($usuarioVend->email)){
                //
                $emailVend = $emailVend. $usuarioVend->email .",";
            }
            foreach($vendedorAuxiliar as $r){
                if(!empty($r->email)  && $r->email != "."){
                    //$this->send($r->email,"Orçamento: ".$orc->idOrcamentos." - SOLICITAÇÃO DE PERITAGEM","PN: ".$orc->pn." - ".$orc->descricao_item);
                    $emailVend = $emailVend.$r->email.",";
                }
            }
            if(!empty($emailVend)){
                //$this->send($emailVend,"Orçamento: ".$orc->idOrcamentos." - SOLICITADO A CONFIRMAÇÃO DA PERITAGEM","PN: ".$orc->pn." - ".$orc->descricao_item);
            }
            $email = "";
            //echo json_encode($peritagem);
            //exit;
            foreach($peritagem as $r){
                if(!empty($r->email) && $r->email != "."){
                    //$this->send($r->email,"Orçamento: ".$orc->idOrcamentos." - SOLICITAÇÃO DE PERITAGEM","PN: ".$orc->pn." - ".$orc->descricao_item);
                    $email = $email.$r->email.",";
                }
            }
            //echo $email;
            //exit;
            $this->send($email,"Orçamento: ".$orc->idOrcamentos." - SOLICITADO A CONFIRMAÇÃO DA PERITAGEM","PN: ".$orc->pn." - ".$orc->descricao_item);
            
        }
        if($this->input->post('idOrcServEscopo')){
            $this->session->set_flashdata('success','Confirmação solicitada com sucesso!'); 
        }else{
            $this->session->set_flashdata('error','Selecione algum item.');
        }
         
        redirect(base_url().'index.php/peritagem/escopoperitagem/'.$this->input->post('idOrcamento2').'/'.$this->input->post('idOrcItemRedirect'));
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
            //echo 'Your Email has successfully been sent.';
        } else {
            //show_error($this->email->print_debugger());
        }
    }

    function getescopobyidproduto(){
        if(!empty($this->input->post('orc'))){
            if(!empty($this->input->post('idOrc'))){
                $preResultado1 = $this->peritagem_model->getEscopoByIdProdutoAndTipoProd($this->input->post('tipo_prod'),$this->input->post('idProduto'));   
                if(!empty($preResultado1)){
                    $preResultado2 = $this->peritagem_model->getEscopoOrcByidEscopoAndIdOrcItem($preResultado1[0]->idServicoEscopo,$this->input->post('idOrc'));
                    if(!empty($preResultado2)){
                        $resultado = $this->peritagem_model->itensPeritagemOrcamento($preResultado2->idOrcServicoEscopo);
                        $json  = array("result"=>true,"resultado"=>$resultado);  
                        echo json_encode($json);
                        return;
                    }else{
                        $resultado = $this->peritagem_model->getEscopoByIdProdutoAndTipoProd($this->input->post('tipo_prod'),$this->input->post('idProduto'));   
                        if($this->input->post('tipo_prod') == 'cil' && empty($resultado)){
                            $resultado =  $this->peritagem_model->getEscopoItensByIdEscopo(1);
                        }
                        $json  = array("result"=>true,"resultado"=>$resultado);  
                        echo json_encode($json);
                        return;
                    }
                }else{
                    $resultado = $this->peritagem_model->getEscopoByIdProdutoAndTipoProd($this->input->post('tipo_prod'),$this->input->post('idProduto'));   
                    if($this->input->post('tipo_prod') == 'cil' && empty($resultado)){
                        $resultado =  $this->peritagem_model->getEscopoItensByIdEscopo(1);
                    }
                    $json  = array("result"=>true,"resultado"=>$resultado);  
                    echo json_encode($json);
                    return;
                }
            }else{
                $resultado = $this->peritagem_model->getEscopoByIdProdutoAndTipoProd($this->input->post('tipo_prod'),$this->input->post('idProduto'));   
                if($this->input->post('tipo_prod') == 'cil' && empty($resultado)){
                    $resultado =  $this->peritagem_model->getEscopoItensByIdEscopo(1);
                }
                $json  = array("result"=>true,"resultado"=>$resultado);  
                echo json_encode($json);
                return;
            }            
        }
        echo json_encode(array("result"=>false));
        return;
    }

    function catalogo(){
        $this->data['view'] = 'peritagem/catalogo';
        $this->data['catalogos']=$this->peritagem_model->getCatalogos();
        $this->load->view('tema/topo',$this->data);
    }
    function adicionarCatalogo(){
        $this->data['view'] = 'peritagem/adicionarCatalogo';
        $this->load->view('tema/topo',$this->data);
    }
    function salvarCatalogo(){
        $listaProd = $this->input->post("idProdutoC");
        $this->input->post("idProdutos");
        $this->load->model('produtos_model'); 
        $getProduto = $this->produtos_model->getById($this->input->post("idProdutos"));
        $data = array(
            "idProduto"=>$this->input->post("idProdutos"),
            "data_cadastro"=>date('Y-m-d H:i:s'),
            "idUsuario"=>$this->session->userdata('idUsuarios'),
            "tipoProd"=>$this->input->post("tipoProdMaster"),
            "descricaoCatalogo"=>$getProduto->pn,
            "ativo"=>1
        );
        $idCatalogo = $this->peritagem_model->add('catalogo_produto',$data,true);
        for($x=0;$x<count($listaProd);$x++){
            $data2 = array(
                "idCatalogoProduto"=>$idCatalogo,
                "idProduto"=>$listaProd[$x],
                "tipoProd"=>$this->input->post('tipoProd')[$x],
                "quantidade"=>$this->input->post('quantidade')[$x],
                "data_cadastro"=>date('Y-m-d H:i:s'),
                "idUsuario"=>$this->session->userdata('idUsuarios'),
                "ativo"=>1
            );
            $this->peritagem_model->add('catalogo_produto_itens',$data2);
        }
        $this->session->set_flashdata('success','Catalogo criado com sucesso.');
        redirect( base_url().'index.php/peritagem/visualizarCatalogo/'.$idCatalogo );

    }
    function visualizarCatalogo(){
        $idCatalogo = $this->uri->segment(3);
        $this->data['catalogo'] = $this->peritagem_model->getCatalogoById($idCatalogo);
        $this->data['catalogoItens'] = $this->peritagem_model->getCatalogoItensByIdCatalogo($idCatalogo);
        $this->data['view'] = 'peritagem/visualizarcatalogo';
        $this->load->view('tema/topo',$this->data);
    }
    function catalogoitemativo(){
        $idItem = $this->input->post("idCatalogoProdutoItem");
        //$status = $this->input->post("statusAtivo");
        if($this->input->post("statusAtivo") == 'false'){
            $status = 0;
        }else{
            $status = 1;
        }
        $data = array("ativo"=>$status);
        $this->peritagem_model->edit("catalogo_produto_itens",$data,"idCatalogoProdutoItens",$idItem);
        echo json_encode(array("resul"=>true));

    }
    function salvarCatalogo2(){
        for($x=0;$x<count($this->input->post('idCatalogoItens'));$x++){
            $data = array(
                "quantidade"=>$this->input->post('quantidade')[$x],
                "tipoProd"=>$this->input->post('tipoProd')[$x]
            );
            $this->peritagem_model->edit("catalogo_produto_itens",$data,"idCatalogoProdutoItens",$this->input->post('idCatalogoItens')[$x]);
        }
    }
    function getcatalogoproduto(){
        $idProduto = $this->input->post('idProduto');
        $tipoProd = $this->input->post('tipo_prod');
        $orc = $this->input->post('orc');
        $catalogo = $this->peritagem_model->getCatalogoAtivosByIdProduto($idProduto);
        echo  json_encode(array(
            "result"=>true,
            "resultado"=>$catalogo
        ));
    }
    function getcatalogoitens(){
        $idCatalogo = $this->input->post('idCatalogo');
        $itens = $this->peritagem_model->getCatalogoItensAtivosByIdProduto($idCatalogo);
        echo json_encode(array(
            "result"=>true,
            "resultado"=>$itens
        ));
    }

    function solicitarperitagem(){
        $this->load->model('os_model');
        $idOrcEscopo = $this->input->post('idOrcEscopo');
        $idOrcItem = $this->input->post('idOrcItem');
        $objos = $this->orcamentos_model->getos_item($this->input->post('idOrcItem'));
        $dataOs = array("idStatusOs"=>40);
        $data = array("idStatusPeritagem"=>5);
        $data2 = array("statusDesenho"=>1,"data_solicitar_desenho"=>date('Y-m-d H:i:s'));
        $this->peritagem_model->edit("orc_servico_escopo",$data,"idOrcServicoEscopo", $idOrcEscopo);
        $this->peritagem_model->edit("orcamento_item",$data2,"idOrcamento_item", $idOrcItem);
        //$this->peritagem_model->edit("os",$dataOs,"idOs", $objos->idOs);
        $os = $this->os_model->getByid_table($objos->idOs, 'os', 'idOs');
        $this->os_model->insertOSHis($os,51);
        $itemOrcamento = $this->orcamentos_model->get_item_orc2($idOrcItem);
        $usuarios = $this->orcamentos_model->getUsuariosComidPermissao(7);
        $email = "";
        foreach($usuarios as $r){
            if(!empty($r->email)){
                //$this->send($r->email,"Orçamento: ".$orc->idOrcamentos." - SOLICITAÇÃO DE PERITAGEM","PN: ".$orc->pn." - ".$orc->descricao_item);
                $email = $email.$r->email.",";
            }
        }
        if(!empty($email)){
            try{
                $this->send($email,"Orçamento: ".$itemOrcamento->idOrcamentos." - SOLICITAÇÃO DE DESENHO","PN: ".$itemOrcamento->pn." - ".$itemOrcamento->descricao_item);
            }catch(Exception $e){}
        }
       
        echo json_encode(array("result"=>true));
    }
    function salvarlaudo3(){
        $this->load->model('orcamentos_model');
        $nomeArquivo = $this->generateRandomString();
        if(!empty($_FILES['file']["name"])){
            $target_dir = "./assets/uploads/laudofotografico/";
            $imageFileType = strtolower(pathinfo(basename($_FILES['file']["name"]),PATHINFO_EXTENSION));
            $_FILES['file']["name"] = $nomeArquivo."_".$this->generateRandomString().".".$imageFileType;
            $target_file = $target_dir . basename($_FILES['file']["name"]);
            if (file_exists($target_file)) {
                $_FILES['file']["name"] = $nomeArquivo."_".$this->generateRandomString().".".$imageFileType;
                $target_file = $target_dir . basename($_FILES[['file']]["name"]);             
            }
            if(!empty($this->input->post('idOrcSerItem'))){
                $idOrcSerItem = $this->input->post('idOrcSerItem');
            }else{
                $idOrcSerItem = NULL;
            }
            if (move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
                
                $data = array(
                    'caminho'=>'assets/uploads/laudofotografico/',
                    'imagem'=>$_FILES["file"]["name"],
                    'extensao'=>$imageFileType,
                    'nomeArquivo'=>$nomeArquivo,
                    'idOrc_item'=>$this->input->post('idOrcItem'),
                    'idOrcServicoEscopoItens'=>$this->input->post('idOrcSerItem'),
                    'userProprietario'=>$this->session->userdata('idUsuarios'),
                    'data_cadastro'=>date('Y-m-d H:i:s'),
                    'comentarios'=>$this->input->post('comentario'),
                    'comentariosExibicao'=>$this->input->post('comentario')
                );
                $this->peritagem_model->add('anexo_laudo',$data);
            }
        }
        $laudofotografico = $this->peritagem_model->getLaudoFotograficoByIdOrcItemAndIdOrcServEscopo($this->input->post('idOrcItem'),$this->input->post('idOrcSerItem'));
        echo json_encode(array("result"=>true,"data"=>$laudofotografico));
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



        $config['base_url'] = base_url() . 'index.php/peritagem/ordemservico/';
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



        $this->data['view'] = 'peritagem/ordemservico_perit';
        $this->load->view('tema/topo', $this->data);
    }
    function getInfoOrcServEscItem(){
        $idOrcServItem = $this->input->post("idOrcSerItem");
        $objeto = $this->peritagem_model->getInfoOrcServEscItem($idOrcServItem);
        echo json_encode(array("result"=>true,"resultado"=>$objeto));
    }
    function adicionarObservacao(){
        $idOrcServItem = $this->input->post("idOrcSerItem");
        $obs = $this->input->post("obs");
        $data = array(
            "obs"=>$obs
        );
        $this->peritagem_model->edit("orc_servico_escopo_itens",$data,"idOrcServicoEscopoItens",$idOrcServItem);
        echo json_encode(array("result"=>true,"idOrcEscopoItens"=>$idOrcServItem,"vazio"=>(!empty($obs)?false:true)));
    }
    function getinfocatalogoitem(){
        $id = $this->input->post("idCatalogoItem");
        $produto = $this->peritagem_model->getProdutosByidCatalogoItens($id);
        echo json_encode(array("result"=>true,"produto"=>$produto));
    }
    
    function salvaritemescopoorc(){
        $id = $this->input->post("id");
        $campo = $this->input->post("campo");
        $valor = $this->input->post("valor");
        //echo $id."_".$campo."-".$valor;
        if($campo == "check"){
            if($valor == 1 && !empty($valor)){
                $data = array(
                    'quantidade'=>1,
                    'checkbox'=>1,
                    'selected'=>1,
                    'dimenExt'=>null,
                    'dimenInt'=>null,
                    'dimenComp'=>null
                );
            }else{
                $data = array(
                    'quantidade'=>null,
                    'checkbox'=>0,
                    'selected'=>0,
                    'dimenExt'=>null,
                    'dimenInt'=>null,
                    'dimenComp'=>null
                );
            }
        }else if($campo == "radio"){
            if($valor == 1 && !empty($valor)){
                $data = array(
                    'quantidade'=>1,
                    'checkbox'=>1,
                    'selected'=>1,
                    'dimenExt'=>null,
                    'dimenInt'=>null,
                    'dimenComp'=>null
                );
            }else{
                $data = array(
                    'quantidade'=>null,
                    'checkbox'=>0,
                    'selected'=>0,
                    'dimenExt'=>null,
                    'dimenInt'=>null,
                    'dimenComp'=>null
                );
            }
        }else{
            if(!empty($valor)){
                if($campo == "quantidade"){
                    $data = array(
                        "quantidade"=>$valor
                    );
                }
                if($campo == "dimenExt"){
                    $data = array(
                        "dimenExt"=>$valor
                    );
                }
                if($campo == "dimenInt"){
                    $data = array(
                        "dimenInt"=>$valor
                    );
                }
                if($campo == "dimenComp"){
                    $data = array(
                        "dimenComp"=>$valor
                    );
                }
            }else{
                $data = array(
                    'quantidade'=>null,
                    'checkbox'=>0,
                    'selected'=>0,
                    'dimenExt'=>null,
                    'dimenInt'=>null,
                    'dimenComp'=>null
                );
            }
        }
        $this->peritagem_model->edit("orc_servico_escopo_itens",$data,"idOrcServicoEscopoItens",$id);
        echo json_encode(array("result"=>true));
    }

    function salvarobsescopoorc(){
        $data = array(
            "obs"=>$this->input->post("valor")
        );
        $this->peritagem_model->edit("orc_servico_escopo",$data,"idOrcServicoEscopo",$this->input->post("id"));
        echo json_encode(array("result"=>true));
    }

    function getinfoorcitem(){
        $idOrcItem = $this->input->post("idOrcitem");
        $objOrcItem = $this->orcamentos_model->getOrcItemDetailsById($idOrcItem);
        echo json_encode(array("result"=>true,"obj"=>$objOrcItem));
    }

    function solicitarAlteracaoPN(){
        $idorcitem = $this->input->post("orcamentoItemEditarPN2");
        $idProdNovo = $this->input->post("idProdNovoeditar");
        $objOrcItem = $this->orcamentos_model->getOrcItemDetailsById($idorcitem);

        $data = array(
            "idProduto"=>$objOrcItem->idProdutos,
            "idProdutoNovo"=>$idProdNovo,
            "idOrcamento_item"=>$idorcitem,
            "idUserSolicitacao"=>$this->session->userdata('idUsuarios'),
            "idStatusSolicitacao"=>1
        );
        
        $this->peritagem_model->add("solicitacao_alterar_pn",$data);
        $this->session->set_flashdata('success','Alteração de PN solicitada com sucesso');
        redirect(base_url().'index.php/peritagem/escopoperitagem/'.$objOrcItem->idOrcamentos.'/'.$this->input->post('idOrcItemRedirect'));
    }

    function salvartiposervico(){
        $id = $this->input->post("id");
        $selecionado = $this->input->post("selecionado");
        $data = array(
            "selecionado"=>$selecionado
        );
        $this->peritagem_model->edit("tiposservico_servitem",$data,"idTiposservico_servitem",$id);
        echo json_encode(array("result"=>true));
    }


    function getInfoTipoServico(){
        $id = $this->input->post("idOrcSerItem");
        $obj = $this->peritagem_model->getInfoTipoServico($id);
        echo json_encode(array("result"=>true,"obj"=>$obj));
    }

    function adicionarObservacaoServico(){
        $idOrcServItem = $this->input->post("idOrcSerItem");
        $obs = $this->input->post("obs");
        $data = array(
            "observacao"=>$obs
        );
        $this->peritagem_model->edit("tiposservico_servitem",$data,"idTiposservico_servitem",$idOrcServItem);
        echo json_encode(array("result"=>true,"idTiposservico_servitem"=>$idOrcServItem,"vazio"=>(!empty($obs)?false:true)));
    }
    
    function recusarperitagem(){
        $this->load->model('usuarios_model');   
        $this->load->model('os_model');        
        foreach($this->input->post('idOrcServEscopo') as $r){
            $data = array (
                'idStatusPeritagem'=>7
            );
            $data2 = array (
                'idStatusOs'=>203
            );
            $this->peritagem_model->edit('orc_servico_escopo',$data,'idOrcServicoEscopo',$r);
            $idOrcServicoEscopo = $r;
            $orcServicoEscopo = $this->peritagem_model->getOrcEscopo2($idOrcServicoEscopo);
           
            
        }
        if($this->input->post('idOrcServEscopo')){
            $this->session->set_flashdata('success','Peritagem recusada com sucesso'); 
        }else{
            $this->session->set_flashdata('error','Selecione algum item.');
        }
         
        redirect(base_url().'index.php/peritagem/escopoperitagem/'.$this->input->post('idOrcamento2').'/'.$this->input->post('idOrcItemRedirect'));
        
    }
    function reavaliacaodesenho(){
        $this->load->model('usuarios_model');   
        $this->load->model('os_model');        
        foreach($this->input->post('idOrcServEscopo') as $r){
            $data = array (
                'idStatusPeritagem'=>6
            );
            $data2 = array (
                'statusDesenho'=>2
            );
            $this->peritagem_model->edit('orc_servico_escopo',$data,'idOrcServicoEscopo',$r);
            $idOrcServicoEscopo = $r;
            $orcServicoEscopo = $this->peritagem_model->getOrcEscopo2($idOrcServicoEscopo);
            $this->peritagem_model->edit('os',$data2,'idOrcamento_item',$orcServicoEscopo->idOrcItem);
            $this->peritagem_model->edit('orcamento_item',$data2,'idOrcamento_item',$orcServicoEscopo->idOrcItem);
           
            
        }
        if($this->input->post('idOrcServEscopo')){
            $this->session->set_flashdata('success','Reavaliação de desenho solicitada!'); 
        }else{
            $this->session->set_flashdata('error','Selecione algum item.');
        }
        redirect(base_url().'index.php/peritagem/escopoperitagem/'.$this->input->post('idOrcamento2').'/'.$this->input->post('idOrcItemRedirect'));
    }
    function escopochecklistimprimir(){
        $data['dados_emitente'] = $this->orcamentos_model->getEmitente(1);
        $data['infoOrc'] = $this->orcamentos_model->getOrcItemDetailsById2($this->uri->segment(3));
        $data['orc_escopo_itens'] = $this->peritagem_model->getInfoOrcServEscByIdOrcamentoItem($this->uri->segment(3));
        $this->load->helper('mpdf');
        echo $html = $this->load->view('peritagem/imprimir/imprimirchecklist',$data,true);
    }
}
?>