<?php
class Usuarios_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    

    function get($perpage=0,$start=0,$one=false){
        
        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao');
        $this->db->limit($perpage,$start);
        $this->db->join('permissoes', 'usuarios.permissoes_id = permissoes.idPermissao', 'left');
  
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

     function getAllTipos(){
        $this->db->where('situacao',1);
        return $this->db->get('tiposUsuario')->result();
    }

    function getById($id){
        $this->db->where('idUsuarios',$id);
        $this->db->limit(1);
        return $this->db->get('usuarios')->row();
    }
	function getusuarios($id = ''){
		if(!empty($id))
		{
        $this->db->where('idUsuarios',$id);
		}
		 $this->db->where('situacao','1');
        $this->db->order_by('user','asc');
        return $this->db->get('usuarios')->result();
    }
    
    function add($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    
    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;       
    }
    public function getUsuarioWhereLike($field, $search)
    {

        $query = "
        SELECT usuario.*,permissoes.nome as permissao  FROM usuarios as usuario, permissoes as permissoes
        WHERE usuario.permissoes_id = permissoes.idPermissao and usuario.$field LIKE '%$search%'
            ORDER BY usuario.$field 
        ";
        
        return $this->db->query($query)->result();
       
    }
    public function numrowsUsuarioWhereLike($field, $search)
    {

        $query = "
        SELECT usuario.*,permissoes.nome as permissao  FROM usuarios as usuario, permissoes as permissoes
        WHERE usuario.permissoes_id = permissoes.idPermissao and usuario.$field LIKE '%$search%'
            ORDER BY usuario.$field 
        ";
        
        return $this->db->count_all();
       
    }
    function getByUser($user,$iduser = ''){
        $this->db->where('user',$user);
		if($iduser <> '')
		{
        $this->db->where('idUsuarios <> '.$iduser);
		}
        return $this->db->get('usuarios')->row();
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
	
	function count($table){
		return $this->db->count_all($table);
	}
}