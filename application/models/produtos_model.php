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
    function getByPn2($pn){
        $excluir = array(" ", "*", "-", ".", ",", "=", "+", "'('", "')'");
        $resultado_pn = str_replace($excluir, "", $pn);
        $this->db->where('pn', $resultado_pn);
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
        $allowed = ['descricao','pn','referencia'];
        if (!in_array($field, $allowed, true)) return [];
        $search_safe = $this->db->escape_like_str($search);
        $query = "
            SELECT * FROM produtos
            WHERE $field LIKE '%{$search_safe}%'
            ORDER BY $field
        ";

        return $this->db->query($query)->result();

    }
	
	
	
	////////////////////nova função contador///////////////////////
    public function getEstatisticasConsulta($idProduto) {
        // Garante que o ID seja tratado como inteiro
        $idProduto = (int) $idProduto;

        // Usando $this->db->query() para ter controle total sobre a sintaxe SQL
        // Aplicamos a mesma lógica de subconsulta para consolidar as consultas por data_consulta
        $sql = "
        SELECT
            COUNT(t1.idProduto_data_consulta) AS total_consultas,
            SUM(CASE WHEN t1.quantidade_estoque_consolidada = 0 THEN 1 ELSE 0 END) AS estoque_zero,
            SUM(CASE WHEN t1.quantidade_estoque_consolidada >= 1 THEN 1 ELSE 0 END) AS estoque_maior_igual_1
        FROM (
            SELECT
                idProduto,
                data_consulta,
                CONCAT(idProduto, '-', data_consulta) AS idProduto_data_consulta,
                MAX(CASE WHEN quantidade_estoque >= 1 THEN 1 ELSE 0 END) AS quantidade_estoque_consolidada
            FROM
                consulta_estoque_log
            WHERE
                idProduto = ?
            GROUP BY
                idProduto,
                data_consulta
        ) AS t1
        ";

        // Prepara a query com um bind parameter (?) para segurança e performance
        $query = $this->db->query($sql, array($idProduto));
        $result = $query->row();

        // Se nenhum resultado for encontrado, retorna zero para todas as estatísticas
        if (empty($result)) {
            return (object)[
                'total_consultas' => 0,
                'estoque_zero' => 0,
                'estoque_maior_igual_1' => 0
            ];
        }

        return $result;
    }


// Estatísticas somadas para vários produtos
public function getEstatisticasConsultasPorListaIds($idsProdutos) {
    $result = (object)[
        'total_consultas' => 0,
        'estoque_zero' => 0,
        'estoque_maior_igual_1' => 0
    ];

    foreach ($idsProdutos as $idProduto) {
        $stats = $this->getEstatisticasConsulta($idProduto);
        $result->total_consultas += $stats->total_consultas;
        $result->estoque_zero += $stats->estoque_zero;
        $result->estoque_maior_igual_1 += $stats->estoque_maior_igual_1;
    }

    return $result;
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////




	
    public function numrowsProdutoWhereLike($field, $search)
    {
        $allowed = ['descricao','pn','referencia'];
        if (!in_array($field, $allowed, true)) return 0;

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