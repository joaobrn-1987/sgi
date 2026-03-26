<?php
class Registrodescarte extends CI_Controller {

    function __construct() {
        parent::__construct();
                if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
                    redirect('mapos/login');
                }
        
        $this->load->helper(array('form','codegen_helper'));
        $this->load->model('registrodescarte_model','',TRUE);
        $this->data['menuRegistroDescarte'] = 'RegistroDescarte';
    }	

    function index(){
        $this->gerenciar();
    }
    function gerenciar(){

        $this->data['dataAtual'] = date('Y-m-d');
        $this->data['view'] = 'registrodescarte/registrodescarte';
        $this->load->view('tema/topo',$this->data);
    }
}
?>