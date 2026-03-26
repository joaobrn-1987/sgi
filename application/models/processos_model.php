<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Processos_model extends CI_Model {

	function __construct() {
        parent::__construct();
    }

    function add($table,$data,$returnId = false){
        $this->db->insert($table, $data);  
        $id = $this->db->insert_id();   
        $this->histAlteracaoAdd($table,$id);     
        if ($this->db->affected_rows() == '1')
		{
            if($returnId == true){
                return $id;
            }
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function edit($table,$data,$fieldID,$ID,$retorno = false){     
		
		return $this->histAlteracao($table,$data,$fieldID,$ID,$retorno);       
    }
	function getObj($table,$fieldID,$ID){
        
        $this->db->select('*');
        $this->db->from($table);
		$this->db->where($fieldID,$ID);
        
        
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
	function getObjONE($table,$fieldID,$ID){
		$this->db->select('*');
        $this->db->from($table);
		$this->db->where($fieldID,$ID);
        
        
        $query = $this->db->get();
        
        $result = $query->row();
        return $result;
	}
	function histAlteracao($table,$data,$fieldID,$ID,$retorno = false){
		$itensAntes = $this->getObj($table,$fieldID,$ID);
		$fields = $this->db->field_data($table);
		foreach ($fields as $field)
		{
			if($field->primary_key == 1){
				$primary_key = $field->name;
			}
		}
		$this->db->where($fieldID,$ID);
        $this->db->update($table, $data);
		if($retorno){
            $retorno2 = $this->db->last_query();
        }
        if ($this->db->affected_rows() >= 0)
		{
			$retorno2 = TRUE;
		}else{
			$retorno2 = FALSE;
		}
		foreach($itensAntes as $r){
			$itensAgora = $this->getObjONE($table,$primary_key,$r->{$primary_key});
			$arrayDif = array_diff_assoc((array)$itensAgora,(array)$r);
			if($arrayDif){
				$dataHistorico = array(
					"idUser"=>$this->session->userdata('idUsuarios'),
					"url"=>$this->uri->uri_string(),
					"data_alteracao"=>date('Y-m-d H:i:s'),
					"tipo"=>"UPDATE",
					"alt_table"=>$table,
					"alt_primary_key"=>$primary_key,
					"alt_id"=>$r->{$primary_key},
					"alt_obj"=>json_encode($itensAgora),
					"alt"=>json_encode($arrayDif)
				);
				$this->db->insert("historico_alteracoes", $dataHistorico);   
			}
		}
		return $retorno2;
	}
	function histAlteracaoAdd($table,$id){
		$fields = $this->db->field_data($table);
		foreach ($fields as $field)
		{
			if($field->primary_key == 1){
				$primary_key = $field->name;
			}
		}
		$itensAntes = $this->getObjONE($table,$primary_key,$id);
		$dataHistorico = array(
			"idUser"=>$this->session->userdata('idUsuarios'),
			"url"=>$this->uri->uri_string(),
			"data_alteracao"=>date('Y-m-d H:i:s'),
			"tipo"=>"INSERT",
			"alt_table"=>$table,
			"alt_primary_key"=>$primary_key,
			"alt_id"=>$id,
			"alt_obj"=>json_encode($itensAntes),
			"alt"=>json_encode($itensAntes)
		);
		$this->db->insert("historico_alteracoes", $dataHistorico);   
	}
    function getGrupos(){
        $query = "SELECT * FROM grupo_processos order by grupo_processos.descricaoGrupoProcessos asc";
        return $this->db->query($query)->result();
    }
    function getGrupoProcessos($where = ''){
        $this->db->select('DISTINCT grupo_processos.idGrupoProcessos, grupo_processos.descricaoGrupoProcessos');
        $this->db->from('grupo_processos');
        $this->db->join('anexo_processos', 'anexo_processos.idGrupoProcessos = grupo_processos.idGrupoProcessos');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->group_by('grupo_processos.idGrupoProcessos');
        $this->db->order_by('grupo_processos.descricaoGrupoProcessos', 'asc');
        return $this->db->get()->result();
    }
    function getAnexosProcessos($idGrupo,$where = ''){
        $idGrupo = (int)$idGrupo;
        $this->db->select('anexo_processos.*, grupo_processos.descricaoGrupoProcessos, usuarios.nome');
        $this->db->from('grupo_processos');
        $this->db->join('anexo_processos', 'anexo_processos.idGrupoProcessos = grupo_processos.idGrupoProcessos');
        $this->db->join('usuarios', 'usuarios.idUsuarios = anexo_processos.idUsuario');
        $this->db->where('grupo_processos.idGrupoProcessos', $idGrupo);
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('anexo_processos.descricaoArquivo', 'asc');
        return $this->db->get()->result();
    }
	function getAnexoByIdAnexo($id){
		$id = (int)$id;
		$this->db->select('anexo_processos.*, grupo_processos.*');
		$this->db->from('anexo_processos');
		$this->db->join('grupo_processos', 'grupo_processos.idGrupoProcessos = anexo_processos.idGrupoProcessos');
		$this->db->where('idAnexo', $id);
		return $this->db->get()->row();
	}
	function delete($table,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    } 
}