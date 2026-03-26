<?php
class Clientes_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idClientes','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id){
        $this->db->where('idClientes',$id);
        $this->db->limit(1);
        return $this->db->get('clientes')->row();
    }
    function getByDocumento($cnpj,$idcliente = ''){
        if($idcliente <> '')
        {
            $this->db->where('idClientes <>',$idcliente);
        }

        $this->db->where('documento',$cnpj);
       
        return $this->db->get('clientes')->row();
    }
    function add($table,$data,$returnId = false){
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
    public function getClienteWhereLike($field, $search)
    {
        $allowed_fields = array('nomeCliente', 'documento', 'email', 'telefone', 'cidade', 'estado', 'cnpj', 'cpf');
        if (!in_array($field, $allowed_fields, true)) { return array(); }
        $search_escaped = $this->db->escape_like_str($search);

        $query = "
            SELECT * FROM clientes
            WHERE $field LIKE '%{$search_escaped}%'
            ORDER BY $field
        ";

        return $this->db->query($query)->result();

    }
    public function numrowsClienteWhereLike($field, $search)
    {
        $allowed_fields = array('nomeCliente', 'documento', 'email', 'telefone', 'cidade', 'estado', 'cnpj', 'cpf');
        if (!in_array($field, $allowed_fields, true)) { return 0; }
        $search_escaped = $this->db->escape_like_str($search);

        $query = "
            SELECT * FROM clientes
            WHERE $field LIKE '%{$search_escaped}%'
            ORDER BY $field
        ";

        return $this->db->count_all();

    }
	//solicitante
	public function getCliente()
    {
        $this->db->order_by('nomeCliente','asc');
        return $this->db->get('clientes')->result();
       
    }
	public function getSolicitanteWhereLike($field, $search)
    {
        $allowed_fields = array('clientes_solicitantes.nome', 'clientes_solicitantes.email_solici', 'clientes.nomeCliente');
        if (!in_array($field, $allowed_fields, true)) { return array(); }
        $search_escaped = $this->db->escape_like_str($search);

        $query = "
            SELECT * FROM clientes_solicitantes, clientes
            WHERE clientes.idClientes = clientes_solicitantes.idClientes and $field LIKE '%{$search_escaped}%'
            ORDER BY $field
        ";

        return $this->db->query($query)->result();

    }
	
	function getBysolici_cliente($email_solici,$idClientes,$idSolicitante = ''){
        if($idSolicitante <> '')
        {
            $this->db->where('idSolicitante <>',$idSolicitante);
        }

        $this->db->where('idClientes',$idClientes);
        $this->db->where('email_solici',$email_solici);
       
        return $this->db->get('clientes_solicitantes')->row();
    }
	
    public function numrowsSolicWhereLike($field, $search)
    {
        $allowed_fields = array('clientes_solicitantes.nome', 'clientes_solicitantes.email_solici', 'clientes.nomeCliente');
        if (!in_array($field, $allowed_fields, true)) { return 0; }

        $query = "
           SELECT * FROM clientes_solicitantes, clientes
            WHERE clientes.idClientes = clientes_solicitantes.idClientes and $field LIKE '%{$this->db->escape_like_str($search)}%'
            ORDER BY $field
        ";

        return $this->db->count_all();

    }
	function getByIdsolici($id){
        $this->db->where('idSolicitante',$id);
        $this->db->limit(1);
        return $this->db->get('clientes_solicitantes')->row();
    }
	 function getsolicitante($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
       
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.idClientes');
        $this->db->order_by('clientes.idClientes','asc');
        $this->db->limit($perpage,$start);
      
       
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
   
    function delete($table,$fieldID,$ID){
        $query = "SET FOREIGN_KEY_CHECKS=0;";
        $this->db->query($query);
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
		{
            $query = "SET FOREIGN_KEY_CHECKS=1;";
            $this->db->query($query);
			return TRUE;
		}		
        $query = "SET FOREIGN_KEY_CHECKS=1;";
        $this->db->query($query);
		return FALSE;        
    }
    
    function count($table) {
        return $this->db->count_all($table);
    }
    
    
    public function getOsByCliente($id){
        $this->db->where('clientes_id',$id);
        $this->db->order_by('idOs','desc');
        $this->db->limit(10);
        return $this->db->get('os')->result();
    }

}