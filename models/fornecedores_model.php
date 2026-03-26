<?php
class Fornecedores_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idFornecedores','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id){
        $this->db->where('idFornecedores',$id);
        $this->db->limit(1);
        return $this->db->get('fornecedores')->row();
    }
    function getByDocumento($cnpj,$idFornecedores = ''){
        if($idFornecedores <> '')
        {
            $this->db->where('idFornecedores <>',$idFornecedores);
        }

        $this->db->where('documento',$cnpj);
       
        return $this->db->get('fornecedores')->row();
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
	 public function getFornecedor($id = '')
    {
		$this->db->order_by('nomeFornecedor','asc');
		if($id <> '')
		{
			$this->db->where('idFornecedores',$id);
			return $this->db->get('fornecedores')->row();
		}
		else{
        
		
         return $this->db->get('fornecedores')->result();
		}
		
		
        
       
       
    }
    public function getFornecedorWhereLike($field, $search)
    {

        $query = "
            SELECT * FROM fornecedores
            WHERE $field LIKE '%$search%'
            ORDER BY $field 
        ";
        
        return $this->db->query($query)->result();
       
    }
    public function numrowsFornecedorWhereLike($field, $search)
    {

        $query = "
            SELECT * FROM fornecedores
            WHERE $field LIKE '%$search%'
            ORDER BY $field 
        ";
        
        return $this->db->count_all();
       
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
    
    function count($table) {
        return $this->db->count_all($table);
    }
    
    
    public function getOsByFornecedor($id){
        $this->db->where('fornecedores_id',$id);
        $this->db->order_by('idOs','desc');
        $this->db->limit(10);
        return $this->db->get('os')->result();
    }

}