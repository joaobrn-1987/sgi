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
    function getusuarios2($id = ''){
		if(!empty($id))
		{
        $this->db->where('idUsuarios',$id);
		}
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
    function add2($table,$data,$returnId = false){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
		{
                        if($returnId == true){
                            return $this->db->insert_id($table);
                        }
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
        // SEGURANÇA: whitelist de campos permitidos para evitar SQL Injection via $field
        $allowed_fields = ['nome', 'user', 'email', 'cpf', 'rg', 'telefone', 'celular', 'cidade', 'estado'];
        if (!in_array($field, $allowed_fields, true)) {
            return [];
        }
        $search_safe = $this->db->escape_like_str($search);
        $field_safe  = $this->db->protect_identifiers($field);
        $query = "
        SELECT usuario.*,permissoes.nome as permissao FROM usuarios as usuario, permissoes as permissoes
        WHERE usuario.permissoes_id = permissoes.idPermissao AND usuario.$field_safe LIKE '%{$search_safe}%'
            ORDER BY usuario.$field_safe
        ";
        return $this->db->query($query)->result();
    }
    public function numrowsUsuarioWhereLike($field, $search)
    {
        // SEGURANÇA: whitelist de campos permitidos para evitar SQL Injection via $field
        $allowed_fields = ['nome', 'user', 'email', 'cpf', 'rg', 'telefone', 'celular', 'cidade', 'estado'];
        if (!in_array($field, $allowed_fields, true)) {
            return 0;
        }
        $search_safe = $this->db->escape_like_str($search);
        $field_safe  = $this->db->protect_identifiers($field);
        $query = "
        SELECT COUNT(*) as total FROM usuarios as usuario, permissoes as permissoes
        WHERE usuario.permissoes_id = permissoes.idPermissao AND usuario.$field_safe LIKE '%{$search_safe}%'
        ";
        $row = $this->db->query($query)->row();
        return $row ? (int)$row->total : 0;
    }
    function getByUser($user,$iduser = ''){
        $this->db->where('user',$user);
        if($iduser !== '')
        {
            // SEGURANÇA: cast para inteiro evita SQL Injection
            $this->db->where('idUsuarios !=', (int)$iduser);
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
    function getUsuariosPcp(){
        $query = "SELECT usuarios.*,permissoes.nome FROM usuarios  join permissoes on permissoes.idPermissao = usuarios.permissoes_id WHERE permissoes.idPermissao = '25' ORDER BY usuarios.idUsuarios";
        return $this->db->query($query)->result();
    }

    function getEmpresasUserByIdUsuario($idUsuario){
        // SEGURANÇA: parâmetro via bind/Active Record evita SQL Injection
        $this->db->where('idUsuario', (int)$idUsuario);
        return $this->db->get('usuario_empresa')->result();
    }
    function deteleNotIn($idUser, $idEmpresas){
        // SEGURANÇA: cast de todos os IDs para inteiro antes de montar a query
        $idUser = (int)$idUser;
        $ids = array_map('intval', explode(',', $idEmpresas));
        $ids = array_filter($ids); // remove zeros/vazios
        if (empty($ids)) {
            return $this->deletaTodasEmpresasDoUsuario($idUser);
        }
        $ids_safe = implode(',', $ids);
        $query = "DELETE FROM usuario_empresa WHERE idUsuario = ? AND idEmpresa NOT IN ($ids_safe)";
        return $this->db->query($query, [$idUser]);
    }
    function deteleNotIn2($idUser, $idDepartamento){
        // SEGURANÇA: cast de todos os IDs para inteiro antes de montar a query
        $idUser = (int)$idUser;
        $ids = array_map('intval', explode(',', $idDepartamento));
        $ids = array_filter($ids);
        if (empty($ids)) {
            return $this->deletaTodosDepartamentosDoUsuario($idUser);
        }
        $ids_safe = implode(',', $ids);
        $query = "DELETE FROM usuario_departamento WHERE idUsuario = ? AND idDepartamento NOT IN ($ids_safe)";
        return $this->db->query($query, [$idUser]);
    }
    function deletaTodasEmpresasDoUsuario($idUser){
        // SEGURANÇA: cast para inteiro evita SQL Injection
        $this->db->where('idUsuario', (int)$idUser);
        return $this->db->delete('usuario_empresa');
    }
    function deletaTodosDepartamentosDoUsuario($idUser){
        // SEGURANÇA: cast para inteiro evita SQL Injection
        $this->db->where('idUsuario', (int)$idUser);
        return $this->db->delete('usuario_departamento');
    }
}