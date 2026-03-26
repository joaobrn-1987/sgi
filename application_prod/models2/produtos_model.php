<?php
class Produtos_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idProdutos','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id){
        $this->db->where('idProdutos',$id);
        $this->db->limit(1);
        return $this->db->get('produtos')->row();
    }
    function getByPn($pnfabricacao,$idproduto = ''){

        $excluir = array(" ", "*", "-", ".", ",", "=", "+", "'('", "')'");
        $resultado_pn = str_replace($excluir, "", $pnfabricacao);
        if($idproduto <> '')
        {
            $this->db->where('idProdutos <>',$idproduto);
        }
        $this->db->where('pn',$resultado_pn);
       
        return $this->db->get('produtos')->row();
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
    public function getProdutoPnWhereLike($field, $search)
    {

        $query = "
            SELECT * FROM produtos
            WHERE $field LIKE '%$search%'
            ORDER BY $field 
        ";
        
        return $this->db->query($query)->result();
       
    }
    public function numrowsProdutoWhereLike($field, $search)
    {

        $query = "
            SELECT * FROM produtos
            WHERE $field LIKE '%$search%'
            ORDER BY $field 
        ";
        
        return $this->db->count_all();
       
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