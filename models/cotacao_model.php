<?php
class Cotacao_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields.',clientes.nomeCliente');
        $this->db->from($table);
        $this->db->join('clientes','clientes.idClientes = os.clientes_id');
        $this->db->limit($perpage,$start);
        $this->db->order_by('idOs','desc');
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
	function gettable($table,$where,$one=false){
        $this->db->from($table);
       
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  $query->row();
        return $result;
    }

	public function get_item($item)
    {
		 
		$this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
		$this->db->where('orcamento_item.idOrcamento_item',$item);
        return $this->db->get('orcamento_item')->result();
       
    }
	 public function getEmitente($id = '')
    {
		
		
			$this->db->where('id',$id);
			return $this->db->get('emitente')->row();
		
		
    }
	public function cotacaoCustom($idPedidoCotacao, $a = '', $b = '', $itensimprimir = ''){
        $idPedidoCotacao = (int) $idPedidoCotacao;
        $idPedidoCotacao1 = " and  pedido_cotacaoitens.idPedidoCotacao = $idPedidoCotacao";
        $itens_safe = implode(',', array_filter(array_map('intval', is_array($itensimprimir) ? $itensimprimir : explode(',', (string)$itensimprimir))));
        $imprimir = ($itens_safe !== '') ? " and pedido_cotacaoitens.idDistribuir in($itens_safe)" : '';
               
        $query = "
        SELECT distribuir_os.idDistribuir,
        distribuir_os.idOs,
        distribuir_os.quantidade,
        distribuir_os.dimensoes,
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,
        distribuir_os.obs,
        distribuir_os.data_cadastro,
        statuscompras.nomeStatus,
        statuscompras.idStatuscompras,
        pedido_cotacaoitens.idPedidoCompra,
        pedido_cotacaoitens.idCotacaoItens,
        pedido_cotacaoitens.idPedidoCotacao,
        pedido_cotacao.data_cadastro as datacotacao,
        insumos.descricaoInsumo FROM `distribuir_os` left join pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir inner join pedido_cotacao on pedido_cotacao.idPedidoCotacao = pedido_cotacaoitens.idPedidoCotacao inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras where 1=1 $idPedidoCotacao1 $imprimir ORDER BY `distribuir_os`.`data_cadastro` desc
        ";		
        
        return $this->db->query($query)->result();
    }


	 public function getstatus_os($id = '')
    {
		$this->db->order_by('nomeStatusOs','asc');
		if($id <> '')
		{
			$this->db->where('idStatusOs',$id);
			return $this->db->get('status_os')->row();
		}
		else{
        
		
        return $this->db->get('status_os')->result();
		}
    }
	 public function get_table($table)
    {
		 return $this->db->get($table)->result();
	 }

	public function getstatus_compra($id)
    {
	    $this->db->order_by('ordem','asc');
		if($id <> '')
		{
			$this->db->where('idStatuscompras',$id);
			return $this->db->get('statuscompras')->row();
		}
		else{
        
		
        return $this->db->get('statuscompras')->result();
		}
		
    }

	public function getnf_os($id,$table)
    {
	
		
			$this->db->where('idOs',$id);
	        return $this->db->get($table)->result();
		
    }
	
	public function getpedido_os($id)
    {
	
		
			$this->db->where('idOs',$id);
	        return $this->db->get('anexo_pedido')->result();
		
    }
	
	
	public function getimagem($id)
    {
	
		
			$this->db->where('idAnexo',$id);
	        return $this->db->get('anexo_desenho')->row();
		
    }
	public function getimagem_base($id,$img,$table)
    {
			 $this->db->where('idAnexo <>',$id);
			
			$this->db->where('imagem',$img);
	        
			 return $this->db->get($table)->row();
			 
		
    }
	public function getimagempedido($id)
    {
	
		
			$this->db->where('idAnexo',$id);
	        return $this->db->get('anexo_pedido')->row();
		
    }
	public function getimagemnf($id)
    {
	
		
			$this->db->where('idAnexo',$id);
	        return $this->db->get('anexo_notafiscal')->row();
		
    }
	public function autoCompleteDistribuir($q){

        $this->db->select('*');
        //$this->db->limit(10);
        $this->db->like('descricaoInsumo', $q);
        $query = $this->db->get('insumos');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricaoInsumo'].' | ID: '.$row['idInsumos'],'id'=>$row['idInsumos'] );
            }
			
            echo json_encode($row_set);
        }
    }
    function getById($id){
         $this->db->from('os');
        $this->db->where('os.idOs',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function getProdutos($id = null){
        $this->db->select('produtos_os.*, produtos.*');
        $this->db->from('produtos_os');
        $this->db->join('produtos','produtos.idProdutos = produtos_os.produtos_id');
        $this->db->where('os_id',$id);
        return $this->db->get()->result();
    }
	public function getmaterial_dist($id){
        
        $this->db->from('distribuir_os');
        $this->db->join('insumos','insumos.idInsumos = distribuir_os.idInsumos');
        $this->db->join('statuscompras','statuscompras.idStatuscompras = distribuir_os.idStatuscompras');
        $this->db->where('idOs',$id);
        return $this->db->get()->result();
    }
 public function getitemcompra($id)
    {
		$this->db->where('idCotacaoItens',$id);
        
        return $this->db->get('pedido_comprasitens')->result();
       
    }
public function getqtditens($id)
    {
		
           $this->db->where('idPedidoCotacao',$id);    
       return $this->db->get('pedido_cotacaoitens')->result();
		
		
       
    }

    public function getServicos($id = null){
        $this->db->select('servicos_os.*, servicos.*');
        $this->db->from('servicos_os');
        $this->db->join('servicos','servicos.idServicos = servicos_os.servicos_id');
        $this->db->where('os_id',$id);
        return $this->db->get()->result();
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
	 public function getanexos_os($os,$table)
    {
		 
		
		$this->db->where('idOs',$os);
        
        return $this->db->get($table)->result();
       
    }
     function getdistribuidor($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array')
	 {
          
        $this->db->select('distribuir_os.idDistribuir,
        distribuir_os.idOs,
        usuarios.user,
        distribuir_os.quantidade,
        distribuir_os.dimensoes,
        distribuir_os.histo_alteracao,
        distribuir_os.obs,
        distribuir_os.data_cadastro,
        distribuir_os.data_alteracao as data_alt,
        distribuir_os.liberado_edit_compras,
        statuscompras.nomeStatus,
        statuscompras.idStatuscompras,
        pedido_cotacaoitens.idPedidoCompra,
        pedido_cotacaoitens.idCotacaoItens,
        pedido_cotacaoitens.idPedidoCotacao,
        insumos.descricaoInsumo
        ');
        $this->db->from($table);
        $this->db->join('usuarios', 'usuarios.idUsuarios = distribuir_os.usuario_cadastro');  
        $this->db->join('pedido_cotacaoitens', 'pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir', 'left');
        $this->db->join('insumos', 'insumos.idInsumos = distribuir_os.idInsumos');   
        $this->db->join('statuscompras', 'statuscompras.idStatuscompras = distribuir_os.idStatuscompras');   
        $this->db->order_by($table.'.data_cadastro','desc');
        $this->db->limit($perpage,$start);
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
	 function getdistribuidorcount($table,$fields,$where='')
	 {
          
        $this->db->select('distribuir_os.idDistribuir,
        distribuir_os.idOs,
        usuarios.user,
        distribuir_os.quantidade,
        distribuir_os.dimensoes,
        distribuir_os.histo_alteracao,
        distribuir_os.obs,
        distribuir_os.data_cadastro,
        distribuir_os.data_alteracao as data_alt,
        distribuir_os.liberado_edit_compras,
        statuscompras.nomeStatus,
        statuscompras.idStatuscompras,
        pedido_cotacaoitens.idPedidoCompra,
        pedido_cotacaoitens.idCotacaoItens,
        pedido_cotacaoitens.idPedidoCotacao,
        insumos.descricaoInsumo
        ');
        $this->db->from($table);
        $this->db->join('usuarios', 'usuarios.idUsuarios = distribuir_os.usuario_cadastro');   
        $this->db->join('pedido_cotacaoitens', 'pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir', 'left');
   
        $this->db->join('insumos', 'insumos.idInsumos = distribuir_os.idInsumos');   
        $this->db->join('statuscompras', 'statuscompras.idStatuscompras = distribuir_os.idStatuscompras');   
        $this->db->order_by($table.'.data_cadastro','desc');
       
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  $query->result();
        return $result;
    }

	public function getWhereLikeos($idOs = '', $idPedidoCotacao = '',$idStatuscompras = '',$query_usuario = '')
    {
		if($query_usuario <> '')
		{
			$usuarios_safe = implode(',', array_filter(array_map('intval', is_array($query_usuario) ? $query_usuario : explode(',', (string)$query_usuario))));
			$query_usuario1 = ($usuarios_safe !== '') ? " and  distribuir_os.usuario_cadastro in($usuarios_safe)" : '';
		}
		else
		{
			$query_usuario1 = '';
		}

		if($idOs <> '')
		{
			$idOs = (int) $idOs;
         $idOs1 = " and distribuir_os.idOs = $idOs";
		}
		else
		{
			$idOs1 = '';
		}


		if($idPedidoCotacao <> '')
		{
			$idPedidoCotacao = (int) $idPedidoCotacao;
			$idPedidoCotacao1 = " and  pedido_cotacaoitens.idPedidoCotacao = $idPedidoCotacao";
		}
		else
		{
			$idPedidoCotacao1 = '';
		}
		if($idStatuscompras <> '')
		{
			$idStatuscompras = (int) $idStatuscompras;
			$idStatuscompras1  = " and  distribuir_os.idStatuscompras = $idStatuscompras";
		}
		else
		{
			$idStatuscompras1 = '';
		}
		
		 
        $query = "
        SELECT distribuir_os.idDistribuir,
        usuarios.user,
        distribuir_os.idOs,
        distribuir_os.quantidade,
        distribuir_os.dimensoes,
        distribuir_os.obs,
        distribuir_os.histo_alteracao,
        distribuir_os.data_cadastro,
        distribuir_os.data_alteracao as data_alt,
        distribuir_os.liberado_edit_compras,
        statuscompras.nomeStatus,
        statuscompras.idStatuscompras,
        pedido_cotacaoitens.idPedidoCompra,
        pedido_cotacaoitens.idCotacaoItens,
        pedido_cotacaoitens.idPedidoCotacao,
        pedido_cotacao.data_cadastro as datacotacao,
        insumos.descricaoInsumo 
        FROM `distribuir_os` 
        inner join usuarios on distribuir_os.usuario_cadastro = usuarios.idUsuarios 
        left join pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
        left join pedido_cotacao on pedido_cotacao.idPedidoCotacao = pedido_cotacaoitens.idPedidoCotacao 
        inner join insumos on insumos.idInsumos = distribuir_os.idInsumos
        inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
        where 1=1 $idOs1 $idPedidoCotacao1 $idStatuscompras1 $query_usuario1 
        ORDER BY `distribuir_os`.`data_cadastro` desc
        ";
        
        return $this->db->query($query)->result();
       
    }
    public function numrowsWhereLikeos($idOs = '', $idPedidoCotacao = '',$idStatuscompras = '',$query_usuario = '')
    {
		if($query_usuario <> '')
		{
			$usuarios_safe = implode(',', array_filter(array_map('intval', is_array($query_usuario) ? $query_usuario : explode(',', (string)$query_usuario))));
			$query_usuario1 = ($usuarios_safe !== '') ? " and  distribuir_os.usuario_cadastro in($usuarios_safe)" : '';
		}
		else
		{
			$query_usuario1 = '';
		}

      if($idOs <> '')
		{
			$idOs = (int) $idOs;
         $idOs1 = " and distribuir_os.idOs = $idOs";
		}
		else
		{
			$idOs1 = '';
		}


		if($idPedidoCotacao <> '')
		{
			$idPedidoCotacao = (int) $idPedidoCotacao;
			$idPedidoCotacao1 = " and  pedido_cotacaoitens.idPedidoCotacao = $idPedidoCotacao";
		}
		else
		{
			$idPedidoCotacao1 = '';
		}
		if($idStatuscompras <> '')
		{
			$idStatuscompras = (int) $idStatuscompras;
			$idStatuscompras1  = " and  distribuir_os.idStatuscompras = $idStatuscompras";
		}
		else
		{
			$idStatuscompras1 = '';
		}
		
		
		
			
        $query = "
              SELECT distribuir_os.idDistribuir,
distribuir_os.idOs,
usuarios.user,
distribuir_os.quantidade,
distribuir_os.dimensoes,
distribuir_os.histo_alteracao,
distribuir_os.obs,
distribuir_os.data_cadastro,
distribuir_os.data_alteracao as data_alt,
distribuir_os.liberado_edit_compras,
 statuscompras.nomeStatus,
 statuscompras.idStatuscompras,
  pedido_cotacaoitens.idPedidoCompra,
 pedido_cotacaoitens.idCotacaoItens,
 pedido_cotacaoitens.idPedidoCotacao,
 insumos.descricaoInsumo FROM `distribuir_os` inner join usuarios on distribuir_os.usuario_cadastro = usuarios.idUsuarios left join pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras where distribuir_os.solicitacao = 1 $idOs1 $idPedidoCotacao1 $idStatuscompras1 $query_usuario1 ORDER BY `distribuir_os`.`data_cadastro` desc
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
	
// Atualização específica da Revisão PCP (status 22) garantindo idDistribuir + idOs.
public function updateRevisaoPCP($idDistribuir, $idOs, $observacao)
{
    $data = [
        'idStatuscompras'        => 22,
        'observacao_revisao_pcp' => $observacao,
        'data_revisao_pcp'       => date('Y-m-d H:i:s'),
    ];

    return $this->histAlteracaoWhere(
        'distribuir_os',
        $data,
        ['idDistribuir' => (int)$idDistribuir, 'idOs' => (int)$idOs]
    );
}
    public function autoCompleteProduto($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('descricao', $q);
        $query = $this->db->get('produtos');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricao'].' | Preço: R$ '.$row['precoVenda'].' | Estoque: '.$row['estoque'],'estoque'=>$row['estoque'],'id'=>$row['idProdutos'],'preco'=>$row['precoVenda']);
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteCliente($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nomeCliente', $q);
        $query = $this->db->get('clientes');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nomeCliente'].' | Telefone: '.$row['telefone'],'id'=>$row['idClientes']);
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteUsuario($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nome', $q);
        $this->db->where('situacao',1);
        $query = $this->db->get('usuarios');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome'].' | Telefone: '.$row['telefone'],'id'=>$row['idUsuarios']);
            }
            echo json_encode($row_set);
        }
    }

    public function autoCompleteServico($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nome', $q);
        $query = $this->db->get('servicos');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome'].' | Preço: R$ '.$row['preco'],'id'=>$row['idServicos'],'preco'=>$row['preco']);
            }
            echo json_encode($row_set);
        }
    }


    public function anexar($os, $anexo, $url, $thumb, $path){
        
        $this->db->set('anexo',$anexo);
        $this->db->set('url',$url);
        $this->db->set('thumb',$thumb);
        $this->db->set('path',$path);
        $this->db->set('os_id',$os);

        return $this->db->insert('anexos');
    }

    public function getAnexos($os){
        
        $this->db->where('os_id', $os);
        return $this->db->get('anexos')->result();
    }
    public function updateDistribuir($idEmitente, $idDistribuiros){
        $idEmitente = (int) $idEmitente;
        $idDistribuiros = (int) $idDistribuiros;
        $this->db->set('idEmitente', $idEmitente);
        $this->db->where('idDistribuir', $idDistribuiros);
        $this->db->update('distribuir_os');
    }
	 
}