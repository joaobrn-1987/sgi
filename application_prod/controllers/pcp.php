<?php

class Pcp extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }
        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('os_model', '', TRUE);
        $this->data['menuPcp'] = 'PCP';
    }
    function index()
    {
        $this->backlog();
    }
    function backlog()
    {
        $this->load->model('os_model');
        $this->load->model('pedidocompra_model');
        $this->load->model('relatorios_model');
        $this->load->model('cotacao_model');
        $this->load->model('usuarios_model');

        $this->data['usuarios_dados'] = $this->usuarios_model->getusuarios('');
        $this->data['unid_exec'] = $this->os_model->get_table('unidade_execucao');
        $this->data['status_os'] = $this->os_model->getStatusOs();
        $this->data['dados_statuscompra'] = $this->cotacao_model->getstatus_compra('');

        if ($this->input->post('ehfiltro') == 1) {
            $where = " and distribuir_os.idOs not in (1,2,3,4,5,6,7,8,9,10,11,12,13)";

            $idStatuscompras = $this->input->post('idStatuscompras');
            if (!empty($idStatuscompras)) {
                $conteudo = $idStatuscompras;
                $where .= " and distribuir_os.idStatuscompras in (";
                $primeiro = true;
                foreach ($conteudo as $status_compra3) {
                    if ($primeiro) {
                        $where .= $status_compra3;
                        $primeiro = false;
                    } else {
                        $where .= "," . $status_compra3;
                    }
                }
                $where .= ")";
            }

            $idStatusOs = $this->input->post('idStatusOs');
            $unid_execucao = $this->input->post('unid_execucao');

            if (!empty($unid_execucao)) {
                $conteudo2 = $unid_execucao;
                $where .= " and os.unid_execucao in (";
                $primeiro2 = true;
                foreach ($conteudo2 as $unid_execucao2) {
                    if ($primeiro2) {
                        $where .= $unid_execucao2;
                        $primeiro2 = false;
                    } else {
                        $where .= "," . $unid_execucao2;
                    }
                }
                $where .= ")";
            }

            if (!empty($idStatusOs)) {
                $conteudo = $idStatusOs;
                $where .= " and os.idStatusOs in (";
                $primeiro = true;
                foreach ($conteudo as $status_producao3) {
                    if ($primeiro) {
                        $where .= $status_producao3;
                        $primeiro = false;
                    } else {
                        $where .= "," . $status_producao3;
                    }
                }
                $where .= ")";
            }

            $idUsuarios = $this->input->post('idUsuarios');
            if (!empty($idUsuarios)) {
                $conteudo22 = $idUsuarios;
                $where .= " and distribuir_os.usuario_cadastro in (";
                $primeiro22 = true;
                foreach ($conteudo22 as $tipouser) {
                    if ($primeiro22) {
                        $where .= $tipouser;
                        $primeiro22 = false;
                    } else {
                        $where .= "," . $tipouser;
                    }
                }
                $where .= ")";
            }
            
            
            if(!empty($this->input->post('idOs'))){
                $where .= " and os.idOs in (".$this->input->post('idOs').")";
            }

            if(!empty($this->input->post('idPedidoCompra'))){
                $where .= " and pedido_comprasitens.idPedidoCompra in (".$this->input->post('idPedidoCompra').")";
            }

            $this->data['result'] = $this->relatorios_model->relatorioBacklogPCP($where);
        } else {
            $this->data['result'] = $this->relatorios_model->relatorioBacklogPCP(' and os.idStatusOs = 5');
        }

        $this->data['view'] = 'pcp/backlog';
        $this->load->view('tema/topo', $this->data);
    }
    function getDistribuirById(){
        $id = $this->input->post('idDistribuir');
        $this->load->model('pedidocompra_model');
        $result = $this->pedidocompra_model->getdistribuidorById($id);
        echo json_encode(array("result"=>true,"obj"=>$result));
    }
    function addjusificativa(){
        $idDistribuir = $this->input->post('idDistribuir');       
        $data_reprog = $this->input->post('data_rep');
        $this->load->model('producao_model');
        if(!empty($data_reprog)){
            $data = explode("/",$data_reprog);
            $data_real = $data[2]."-".$data[1]."-".$data[0];
            $data = array(
                "data_reagendada"=>$data_real
            );            
            $this->producao_model->edit('distribuir_os',$data,'idDistribuir',$idDistribuir);
        }else{
            $data_real = "";
        }
        $obs = $this->input->post('justificativa');   
        if(!empty($obs)){;
            $data = array(
                "ultJustificativa"=>$obs
            );            
            $this->producao_model->edit('distribuir_os',$data,'idDistribuir',$idDistribuir);
        }else{
            $obs = "";
        }             
        $obsEx = $this->input->post('histJustficativa');
        $obs2 = $obsEx."Data: ".date('d/m/Y H:i:s')."<br>"."Autor: ".$this->session->userdata('nome')."<br>"."Data Reprogramada: ".$data_reprog."<br><br>".$obs."<br><div style='border-bottom: 1px solid black'></div><br><br>";
        $data = array(
            "justificativa"=>$obs2
        );
        $this->producao_model->edit('distribuir_os',$data,'idDistribuir',$idDistribuir);
        $this->session->set_flashdata('success','Justificativa adicionada com sucesso');
        redirect(base_url() . 'index.php/pcp/backlog');
        //echo json_encode(array("result"=>true,"msg"=>"Observação adicionada com sucesso.","idDistribuir"=>$idDistribuir,"data_reprog"=>$data_reprog,"obs"=>$obs,"obs2"=>$obs2));
    }
    function addjusificativaPedidoCompra(){
        if(empty($this->input->post('idPedidoCompra'))){
            $this->session->set_flashdata('error','Informe uma ordem de compra.');
            redirect(base_url() . 'index.php/pcp/backlog');
        }
        $this->load->model('pedidocompra_model');
        $this->load->model('producao_model');
        $distribuir = $this->pedidocompra_model->getdistribuidorByIdPedidoCompra($this->input->post('idPedidoCompra'));
        $data_reprog = $this->input->post('data_rep');
        if(!empty($data_reprog)){
            $data = explode("/",$data_reprog);
            $data_real = $data[2]."-".$data[1]."-".$data[0];
            $data2 = array(
                "data_reagendada"=>$data_real
            );            
        }else{
            $data_real = "";
        }
        $obs = $this->input->post('justificativa');   
        foreach($distribuir as $r){
            if(!empty($data_real)){
                $this->producao_model->edit('distribuir_os',$data2,'idDistribuir',$r->idDistribuir);
            }
            if(!empty($obs)){;
                $data = array(
                    "ultJustificativa"=>$obs
                );            
                $this->load->model('producao_model');
                $this->producao_model->edit('distribuir_os',$data,'idDistribuir',$r->idDistribuir);
            }else{
                $obs = "";
            }
            $obsEx = $r->justificativa;
            $obs2 = $obsEx."Data: ".date('d/m/Y H:i:s')."<br>"."Autor: ".$this->session->userdata('nome')."<br>"."Data Reprogramada: ".$data_reprog."<br><br>".$obs."<br><div style='border-bottom: 1px solid black'></div><br><br>";
            $data = array(
                "justificativa"=>$obs2
            );
            $this->producao_model->edit('distribuir_os',$data,'idDistribuir',$r->idDistribuir);
        }
        $this->session->set_flashdata('success','Justificativa adicionada com sucesso');
        redirect(base_url() . 'index.php/pcp/backlog');
    }

}
