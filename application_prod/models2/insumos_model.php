<?php
class Insumos_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idInsumos','asc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    
    function getinsumosubcat($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->join('subcategoriaInsumo', 'subcategoriaInsumo.idSubcategoria  = '.$table.'.idSubcategoria');
        $this->db->join('categoriaInsumos', 'categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria');
        $this->db->order_by('descricaoInsumo','asc');
        $this->db->limit($perpage,$start);
      
       
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function getById($id){
        $this->db->where('idInsumos',$id);
        $this->db->limit(1);
        return $this->db->get('insumos')->row();
    }
    
    function getBydescricaoInsumo($descricaoSubcategoria,$idSubcategoria,$idInsumos = ''){
        if($idInsumos <> '')
        {
            $this->db->where('idInsumos <>',$idInsumos);
        }
        if($idSubcategoria <> '')
        {
            $this->db->where('idSubcategoria',$idSubcategoria);
        }

        $this->db->where('descricaoInsumo',$descricaoSubcategoria);
       
        return $this->db->get('insumos')->row();
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
        if ($this->db->affected_rows() == '1' )
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
   
    public function getInsumosWhereLikeinsumo($field, $search)
    {

        $query = "
            SELECT * FROM insumos,subcategoriaInsumo, categoriaInsumos
            WHERE insumos.idSubcategoria = subcategoriaInsumo.idSubcategoria and subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria and $field LIKE '%$search%'
            ORDER BY $field 
        ";
        
        return $this->db->query($query)->result();
       
    }
    public function numrowsWhereLikeinsumo($field, $search)
    {

        $query = "
        SELECT * FROM insumos,subcategoriaInsumo, categoriaInsumos
        WHERE insumos.idSubcategoria = subcategoriaInsumo.idSubcategoria and subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria and $field LIKE '%$search%'
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
    
    //categoria
    function getcat($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('descricaoCategoria','asc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function getByIdCat($id){
        $this->db->where('idCategoria',$id);
        $this->db->limit(1);
        return $this->db->get('categoriaInsumos')->row();
    }
  
    function getByCat_sub($id){
       
        $this->db->where('idCategoria',$id);
       
        return $this->db->get('subcategoriaInsumo')->row();
    }

    function getByidInsumos($id){
        $this->db->where('idInsumos',$id);
        $this->db->limit(1);
        return $this->db->get('insumos')->row();
    }
  

    function getBydescricaoCategoria($descricaoCategoria,$idCategoria = ''){
        if($idCategoria <> '')
        {
            $this->db->where('idCategoria <>',$idCategoria);
        }

        $this->db->where('descricaoCategoria',$descricaoCategoria);
       
        return $this->db->get('categoriaInsumos')->row();
    }
    public function verificaCategoria($q){

        $this->db->select('*');
        //$this->db->limit(5);
        $this->db->where('descricaoCategoria', $q);
        $query = $this->db->get('categoriaInsumos');
        if($query->num_rows > 0){
            $cat = true;
           
        }
        else{
            $cat = false;
           
        }
        echo json_encode(array(
            'categoria' => $cat,
        ));
    }
    public function getCategoria()
    {
        $this->db->order_by('descricaoCategoria','asc');
        return $this->db->get('categoriaInsumos')->result();
       
    }
    
    
    public function addCategoria($descricaoCategoria){
       
        $this->db->set('descricaoCategoria', $descricaoCategoria);
       
        return $this->db->insert('categoriaInsumos');
     }
     public function getInsumosWhereLikecat($field, $search)
     {
 
         $query = "
             SELECT * FROM categoriaInsumos
             WHERE $field LIKE '%$search%'
             ORDER BY $field 
         ";
         
         return $this->db->query($query)->result();
        
     }
     public function numrowsClienteWhereLikecat($field, $search)
     {
 
         $query = "
             SELECT * FROM categoriaInsumos
             WHERE $field LIKE '%$search%'
             ORDER BY $field 
         ";
         
         return $this->db->count_all();
        
     }
    
     //subcategoria

     function getsubcat($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
       
        $this->db->join('categoriaInsumos', 'categoriaInsumos.idCategoria = '.$table.'.idCategoria');
        $this->db->order_by('categoriaInsumos.descricaoCategoria','asc');
        $this->db->order_by('descricaoSubcategoria','asc');
        $this->db->limit($perpage,$start);
      
       
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function getByIdSubCat($id){
        $this->db->where('idSubcategoria',$id);
        $this->db->limit(1);
        return $this->db->get('subcategoriaInsumo')->row();
    }
  
    function getBysubinsumos($id){
       
        $this->db->where('idSubcategoria',$id);
       
        return $this->db->get('insumos')->row();
    }



 function getBydescricaoSubCategoria_editar($descricaoSubcategoria,$idCategoria = ''){
        if($idCategoria <> '')
        {
            $this->db->where('idCategoria',$idCategoria);
        }

        $this->db->where('descricaoSubcategoria',$descricaoSubcategoria);
       
        return $this->db->get('subcategoriaInsumo')->row();
    }
	

    function getBydescricaoSubCategoria($descricaoSubcategoria,$idCategoria = ''){
        if($idCategoria <> '')
        {
            $this->db->where('idCategoria',$idCategoria);
        }

        $this->db->where('descricaoSubcategoria',$descricaoSubcategoria);
       
        return $this->db->get('subcategoriaInsumo')->row();
    }
    public function getSubCategoria()
    {
        
        $this->db->join('categoriaInsumos', 'categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria');
        $this->db->order_by('descricaoCategoria');
        $this->db->order_by('descricaoSubcategoria','asc');
        return $this->db->get('subcategoriaInsumo')->result();
       
    }
    
  
    public function addsubCategoria($descricaoSubcategoria){
       
        $this->db->set('descricaoSubcategoria', $descricaoSubcategoria);
       
        return $this->db->insert('subcategoriaInsumo');
     }
     public function getInsumosWhereLikesubcat($field, $search)
     {
 
         $query = "
             SELECT * FROM subcategoriaInsumo, categoriaInsumos
             WHERE subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria and $field LIKE '%$search%'
             ORDER BY categoriaInsumos.descricaoCategoria, subcategoriaInsumo.descricaoSubcategoria
         ";
         
         return $this->db->query($query)->result();
        
     }
     public function numrowsWhereLikesubcat($field, $search)
     {
 
         $query = "
             SELECT * FROM subcategoriaInsumo, categoriaInsumos
             WHERE subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria and $field LIKE '%$search%'
             ORDER BY categoriaInsumos.descricaoCategoria, subcategoriaInsumo.descricaoSubcategoria
         ";
         
         return $this->db->count_all();
        
     }


    public function getOsByCliente($id){
        $this->db->where('insumos_id',$id);
        $this->db->order_by('idOs','desc');
        $this->db->limit(10);
        return $this->db->get('os')->result();
    }
    public function getInsumosWithCategoriaAndSubCategoria(){
        $query = "SELECT subcategoriaInsumo.idSubcategoria,subcategoriaInsumo.descricaoSubcategoria,subcategoriaInsumo.idCategoria,categoriaInsumos.descricaoCategoria 
        FROM `subcategoriaInsumo` 
        JOIN  categoriaInsumos 
        on categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria
        order by categoriaInsumos.descricaoCategoria asc, subcategoriaInsumo.descricaoSubcategoria asc";
        return $this->db->query($query)->result();
    }
    function getinsumosubcat2(){
        
        $query = "SELECT insumos.idInsumos, insumos.idSubcategoria, insumos.descricaoInsumo, insumos.pn_insumo, categoriaInsumos.descricaoCategoria, subcategoriaInsumo.descricaoSubcategoria FROM `insumos` JOIN subcategoriaInsumo on subcategoriaInsumo.idSubcategoria = insumos.idSubcategoria
        JOIN categoriaInsumos on categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria
        order by insumos.descricaoInsumo asc";
        return $this->db->query($query)->result();
    }
    function getInsumo2($cod){
       $query =  "SELECT insumos.*, categoriaInsumos.descricaoCategoria, subcategoriaInsumo.descricaoSubcategoria 
       FROM `insumos` 
       join subcategoriaInsumo on subcategoriaInsumo.idSubcategoria = insumos.idSubcategoria 
       join categoriaInsumos on categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria 
       where insumos.idInsumos = $cod";
       return $this->db->query($query)->result();
    }
    public function autoCompleteCategoriaSubCategoria($q){

        $this->db->select('*');
        $this->db->limit(20);
        $this->db->like('categoriaInsumos.descricaoCategoria', $q);
        $this->db->join('categoriaInsumos', 'categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria');
        $this->db->order_by('categoriaInsumos.descricaoCategoria','asc');
        $query = $this->db->get('subcategoriaInsumo');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricaoCategoria'].' | Sub.: '.$row['descricaoSubcategoria'],'id'=>$row['idSubcategoria'],'idCategoria'=>$row['idCategoria'],'descricaoCategoria'=>$row['descricaoCategoria'],'descricaoSubcategoria'=>$row['descricaoSubcategoria']);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteCategoriaSubCategoria2($q){

        $this->db->select('*');
        $this->db->limit(20);
        $this->db->like('categoriaInsumos.descricaoCategoria', $q);
        //$this->db->join('categoriaInsumos', 'categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria');
        $this->db->order_by('categoriaInsumos.descricaoCategoria','asc');
        $query = $this->db->get('categoriaInsumos');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricaoCategoria'],'idCategoria'=>$row['idCategoria'],'descricaoCategoria'=>$row['descricaoCategoria']);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteSubcategoria($q){

        $this->db->select('*');
        $this->db->limit(20);
        $this->db->like('subcategoriaInsumo.descricaoSubcategoria', $q);
        $this->db->join('categoriaInsumos', 'categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria');
        $this->db->order_by('subcategoriaInsumo.descricaoSubcategoria','asc');
        $query = $this->db->get('subcategoriaInsumo');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricaoSubcategoria'].' | Cat.: '.$row['descricaoCategoria'],'id'=>$row['idSubcategoria'],'idCat'=>$row['idCategoria'],'descricaoCategoria'=>$row['descricaoCategoria'],'descricaoSubcategoria'=>$row['descricaoSubcategoria']);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteSubcategoria2($q){

        $this->db->select('*');
        $this->db->limit(20);
        $this->db->like('subcategoriaInsumo.descricaoSubcategoria', $q);
        //$this->db->join('categoriaInsumos', 'categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria');
        $this->db->order_by('subcategoriaInsumo.descricaoSubcategoria','asc');
        $query = $this->db->get('subcategoriaInsumo');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricaoSubcategoria'],'id'=>$row['idSubcategoria'],'descricaoSubcategoria'=>$row['descricaoSubcategoria']);
            }
			
            echo json_encode($row_set);
        }
    }
    public function getCategoriaByIdSubcategoria($id){
        $query = "SELECT * FROM categoriainsumos join subcategoriainsumo on subcategoriainsumo.idCategoria = categoriainsumos.idCategoria where idSubcategoria = $id";
        return $this->db->query($query)->result();

    }

}