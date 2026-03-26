<?php
class Pedidocompra_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
   
	function get($table,$where){
        
       
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
	public function OSCustom($idOs){
       	$query = "SELECT emitente.url_logo as url_logoemi, emitente.imagem as imagememi,emitente.nome as nomeemi,  clientes.idClientes as idcli, clientes.nomeCliente as nomecli , produtos.idProdutos , produtos.descricao , produtos.pn ,  orcamento_item.detalhe  FROM (`os`) join orcamento on orcamento.idOrcamentos = os.idOrcamentos JOIN orcamento_item ON orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes`  JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `status_os` ON `status_os`.`idStatusOs` = `os`.`idStatusOs` and os.idOs =  $idOs";
		return $this->db->query($query)->result();
    }
	public function getstatus_os($id = '')
    {
		$this->db->order_by('nomeStatusOs','asc');
		if($id <> ''){
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
		$this->db->where('idPedidoCompra',$id);
        
        return $this->db->get('pedido_comprasitens')->result();
       
    }
public function getqtditens($id)
    {
		
           $this->db->where('idPedidoCompra',$id);    
       return $this->db->get('pedido_comprasitens')->result();
		
		
       
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
		usuarios.user,
		distribuir_os.idOs,
		distribuir_os.quantidade,
		distribuir_os.histo_alteracao,
		distribuir_os.dimensoes,
		insumos.idInsumos,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.valor_unitario,
		pedido_compras.idEmitente,
		distribuir_os.obs,
		status_grupo_compra.nomegrupo,
		status_grupo_compra.idgrupo,
		pedido_cotacaoitens.data_cadastro,
		pedido_compras.data_cadastro as cadpedgerado,
		fornecedores.nomeFornecedor,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		pedido_comprasitens.datastatusentregue,
		statuscompras.nomeStatus,
		statuscompras.idStatuscompras,
		pedido_cotacaoitens.idPedidoCompra,
		pedido_cotacaoitens.idPedidoCompraItens,
		pedido_cotacaoitens.idCotacaoItens,
		pedido_cotacaoitens.idPedidoCotacao,
		insumos.descricaoInsumo
		');
        $this->db->from($table);
       
		$this->db->join('distribuir_os', 'pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir', 'left');
		$this->db->join('usuarios', 'usuarios.idUsuarios = distribuir_os.usuario_cadastro');  
		$this->db->join('pedido_compras', 'pedido_cotacaoitens.idPedidoCompra = pedido_compras.idPedidoCompra', 'left');
		$this->db->join('pedido_comprasitens', 'pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens', 'left');
		$this->db->join('fornecedores', 'fornecedores.idFornecedores = pedido_compras.idFornecedores', 'left');
		$this->db->join('insumos', 'insumos.idInsumos = distribuir_os.idInsumos');   
		$this->db->join('statuscompras', 'statuscompras.idStatuscompras = distribuir_os.idStatuscompras'); 
	
    	$this->db->join('status_grupo_compra', 'status_grupo_compra.idgrupo = distribuir_os.id_status_grupo');   
        $this->db->order_by($table.'.idPedidoCotacao','desc');
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
		insumos.idInsumos,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.valor_unitario,
		pedido_compras.idEmitente,
		distribuir_os.histo_alteracao,
		distribuir_os.obs,
		pedido_cotacaoitens.data_cadastro,
		pedido_compras.data_cadastro as cadpedgerado,
		fornecedores.nomeFornecedor,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		statuscompras.nomeStatus,
		statuscompras.idStatuscompras,
		pedido_comprasitens.datastatusentregue,
		pedido_cotacaoitens.idPedidoCompra,
		pedido_cotacaoitens.idPedidoCompraItens,
		pedido_cotacaoitens.idCotacaoItens,
		pedido_cotacaoitens.idPedidoCotacao,
		insumos.descricaoInsumo
		');
        $this->db->from($table);
      
	$this->db->join('distribuir_os', 'pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir', 'left');
	$this->db->join('usuarios', 'usuarios.idUsuarios = distribuir_os.usuario_cadastro');  
	$this->db->join('pedido_compras', 'pedido_cotacaoitens.idPedidoCompra = pedido_compras.idPedidoCompra', 'left');
	$this->db->join('pedido_comprasitens', 'pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens', 'left');
	$this->db->join('fornecedores', 'fornecedores.idFornecedores = pedido_compras.idFornecedores', 'left');
    $this->db->join('insumos', 'insumos.idInsumos = distribuir_os.idInsumos');   
    $this->db->join('statuscompras', 'statuscompras.idStatuscompras = distribuir_os.idStatuscompras');   
        $this->db->order_by($table.'.idPedidoCotacao','desc');
       
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
       
		
		
      
        return $query->result();
    }
	function getDistribuirById($id){
		$query = "SELECT * FROM distribuir_os WHERE distribuir_os.idDistribuir = $id";
		return $this->db->query($query)->row(); 
	}
	
	function getpedidocomprafornece($id,$group = '',$statuscompra = '')
	{
         if(!empty($group))
		 {
			 if($group == 1)
			 {
				 $group1 = " group by pedido_comprasitens.notafiscal"; 
			 }
			 else
			 {
				 $group1 = " group by distribuir_os.idOs"; 
			 }
			
		}
		else
		{
			$group1 = ""; 
		}

		if(!empty($statuscompra))
		{
			$pegacampo = explode('-', $statuscompra);
			if($pegacampo[0] == 'st')
			{
				$statuscompra1 = " and statuscompras.idStatuscompras = ".$pegacampo[1]; 
			}
			elseif($pegacampo[0] == 'os')
			{
				$statuscompra1 = " and distribuir_os.idOs = ".$pegacampo[1];
				
			}
			else
			{
				$statuscompra1  = " and pedido_comprasitens.notafiscal = ".$pegacampo[1]; 
			}
		}
		else
		{
			$statuscompra1 = ""; 
		}			
         
        $query = "
         	SELECT distribuir_os.idDistribuir,
			distribuir_os.idOs,
			distribuir_os.quantidade,
			distribuir_os.liberado_edit_compras,
			distribuir_os.dimensoes,
			distribuir_os.aprovacaoPCP,
			insumos.idInsumos,
			distribuir_os.histo_alteracao,
			distribuir_os.obs,
			pedido_comprasitens.datastatusentregue,
			status_grupo_compra.nomegrupo,
			status_grupo_compra.idgrupo,
			statuscompras.nomeStatus,
			statuscompras.idStatuscompras,
			statuscompras.etapa,
			pedido_cotacaoitens.idPedidoCompra,
			pedido_cotacaoitens.idPedidoCompraItens,
			pedido_cotacaoitens.idCotacaoItens,
			pedido_cotacaoitens.idPedidoCotacao,
			pedido_comprasitens.`valor_unitario`,
			pedido_comprasitens.`ipi_valor`,
			pedido_comprasitens.`valor_total`,
			pedido_comprasitens.`quantidade` as qtdrecebida,
			pedido_compras.`idFornecedores`,
			pedido_comprasitens.`prazo_entrega`,
			pedido_compras.`idEmitente`,
			pedido_comprasitens.`previsao_entrega`,
			pedido_compras.`data_cadastro`,
			pedido_comprasitens.`idCondPgto`,
			status_cond_pgt.`nome_status_cond_pgt`,
			pedido_comprasitens.`cod_pgto`,
			pedido_comprasitens.`obs` as obscompras,

			pedido_comprasitens.`desconto`,
			pedido_comprasitens.`outros`,
			pedido_compras.`frete`,
			pedido_comprasitens.`icms`,
			pedido_comprasitens.`porcentagem`,
			pedido_comprasitens.`icmsPorcentagem`,
			pedido_comprasitens.`autorizadoCompra`,
			pedido_comprasitens.`idUsuarioAutorizacao`,
			pedido_comprasitens.`data_autorizacao`,
			pedido_comprasitens.`notafiscal`,
			pedido_comprasitens.`datanf`,
			pedido_comprasitens.`id_status_grupo`,
			emitente.nome, 
			emitente.id,
			fornecedores.nomeFornecedor,
			fornecedores.idFornecedores,
			insumos.descricaoInsumo FROM
			pedido_cotacaoitens inner join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
			inner join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras inner join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens inner join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra left join emitente on pedido_compras.idEmitente = emitente.id left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores left join status_cond_pgt on status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.idCondPgto  where pedido_comprasitens.idPedidoCompra = $id $statuscompra1 $group1 ORDER BY pedido_compras.idPedidoCompra desc
		";
        
        return $this->db->query($query)->result(); 
      
    }


    function verificaos($idDistribuir){
		
		$query = "
		SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		usuarios.user,
		distribuir_os.quantidade,
		insumos.idInsumos,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.valor_unitario,
		pedido_compras.idEmitente,
		fornecedores.nomeFornecedor,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		distribuir_os.dimensoes,
		distribuir_os.histo_alteracao,
		distribuir_os.obs,
		status_grupo_compra.nomegrupo,
		status_grupo_compra.idgrupo,
		pedido_cotacaoitens.data_cadastro,
		pedido_compras.data_cadastro as cadpedgerado,
		statuscompras.nomeStatus,
		statuscompras.idStatuscompras,
		pedido_comprasitens.datastatusentregue,
		pedido_cotacaoitens.idPedidoCompra,
		pedido_cotacaoitens.idPedidoCompraItens,
		pedido_cotacaoitens.idCotacaoItens,
		pedido_cotacaoitens.idPedidoCotacao,
		insumos.descricaoInsumo 
		FROM
		pedido_cotacaoitens RIGHT JOIN distribuir_os 
		ON distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
		INNER JOIN usuarios 
		ON distribuir_os.usuario_cadastro = usuarios.idUsuarios 
		INNER JOIN status_grupo_compra 
		on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo  
		INNER JOIN insumos 
		ON insumos.idInsumos = distribuir_os.idInsumos  
		INNER JOIN 
		statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras   
		LEFT JOIN pedido_compras 
		ON pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra
		LEFT JOIN emitente 
		ON pedido_compras.idEmitente = emitente.id 
		LEFT JOIN fornecedores 
		ON fornecedores.idFornecedores = pedido_compras.idFornecedores 
		LEFT JOIN pedido_comprasitens 
		ON pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
		WHERE
		statuscompras.idStatuscompras not in(0) AND distribuir_os.idDistribuir = $idDistribuir
	";
		
  
		
   		return $this->db->query($query)->result(); 
	}
	

	function getpedidocomprafornece2($ids=array(), $group = '',$statuscompra = '')
	{
		$idsDistribuir = '';
		foreach($ids as $x=>$idsDist)
		{          
			if($x == 0){
				$idsDistribuir = $idsDist;
			}else{
				$idsDistribuir .= ', ' . $idsDist; 
			}

		}		

		if(!empty($group))
		 {
			 if($group == 1)
			 {
				 $group1 = " group by pedido_comprasitens.notafiscal"; 
			 }
			 else
			 {
				 $group1 = " group by distribuir_os.idOs"; 
			 }
			
		}
		else
		{
			$group1 = ""; 
		}

		if(!empty($statuscompra))
		{
			$pegacampo = explode('-', $statuscompra);
			if($pegacampo[0] == 'st')
			{
				$statuscompra1 = " and statuscompras.idStatuscompras = ".$pegacampo[1]; 
			}
			elseif($pegacampo[0] == 'os')
			{
				$statuscompra1 = " and distribuir_os.idOs = ".$pegacampo[1];
				
			}
			else
			{
				$statuscompra1  = " and pedido_comprasitens.notafiscal = ".$pegacampo[1]; 
			}
		}
		else
		{
			$statuscompra1 = ""; 
		}

		$query = "
         	SELECT 
			distribuir_os.idDistribuir,
			distribuir_os.idOs,
			distribuir_os.quantidade,
			distribuir_os.liberado_edit_compras,
			distribuir_os.dimensoes,
			distribuir_os.comprimento,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			distribuir_os.aprovacaoPCP,
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			insumos.idInsumos,
			distribuir_os.histo_alteracao,
			distribuir_os.obs,
			pedido_comprasitens.datastatusentregue,
			status_grupo_compra.nomegrupo,
			status_grupo_compra.idgrupo,
			statuscompras.nomeStatus,
			statuscompras.idStatuscompras,
			statuscompras.etapa,
			pedido_cotacaoitens.idPedidoCompra,
			pedido_cotacaoitens.idPedidoCompraItens,
			pedido_cotacaoitens.idCotacaoItens,
			pedido_cotacaoitens.idPedidoCotacao,
			pedido_comprasitens.`valor_unitario`,
			pedido_comprasitens.`ipi_valor`,
			pedido_comprasitens.`valor_total`,
			pedido_comprasitens.`quantidade` as qtdrecebida,
			pedido_compras.`idFornecedores`,
			pedido_comprasitens.`prazo_entrega`,
			pedido_compras.`idEmitente`,
			pedido_comprasitens.`previsao_entrega`,
			distribuir_os.`data_cadastro`,
			pedido_comprasitens.`idCondPgto`,
			status_cond_pgt.`nome_status_cond_pgt`,
			pedido_comprasitens.`cod_pgto`,
			pedido_comprasitens.`obs` as obscompras,
			pedido_comprasitens.`desconto`,
			pedido_comprasitens.`outros`,
			pedido_compras.`frete`,
			pedido_comprasitens.`icms`,
			pedido_comprasitens.`porcentagem`,
			pedido_comprasitens.`icmsPorcentagem`,
			pedido_comprasitens.`notafiscal`,
			pedido_comprasitens.`datanf`,
			pedido_comprasitens.`autorizadoCompra`,
			pedido_comprasitens.`id_status_grupo`,
			pedido_comprasitens.`autorizadoCompra`,
			emitente.nome, 
			emitente.id,
			fornecedores.nomeFornecedor,
			fornecedores.idFornecedores,
			fornecedores.sem_cotacao,
			insumos.descricaoInsumo 
			FROM
			pedido_cotacaoitens inner join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
			inner join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo 
			inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  
			inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
			inner join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
			inner join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra 
			left join emitente on pedido_compras.idEmitente = emitente.id 
			left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores 
			left join status_cond_pgt on status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.idCondPgto  
			where distribuir_os.idDistribuir in($idsDistribuir) $statuscompra1 $group1 
			ORDER BY pedido_compras.idPedidoCompra asc, insumos.descricaoInsumo asc
		";
		        
        return $this->db->query($query)->result(); 
	}
	 
	 
	function getstatus_compra2($id)
    {
		$this->db->order_by('ordem','asc');
		if($id <> ''){
			$this->db->where('idStatuscompras > ',$id);
			return $this->db->get('statuscompras')->result();
		}
		else{
        	return $this->db->get('statuscompras')->result();
		}
		
    }

	
	 function getstatus_grupo()
    {
	$this->db->order_by('nomegrupo','asc');
		
        
		
        return $this->db->get('status_grupo_compra')->result();
		
		
    }
	  function getstatus_cond_pg($id)
    {
	$this->db->order_by('nome_status_cond_pgt','asc');
		if($id <> '')
		{
			$this->db->where('id_status_cond_pgt',$id);
			return $this->db->get('status_cond_pgt')->row();
		}
		else{
        
		
        return $this->db->get('status_cond_pgt')->result();
		}
		
    }
	
	
	 function getdistribuidor_editar($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array')
	 {
          
        $this->db->select('distribuir_os.idDistribuir,
distribuir_os.idOs,
distribuir_os.quantidade,
distribuir_os.dimensoes,
distribuir_os.histo_alteracao,
distribuir_os.obs,
distribuir_os.data_cadastro,
 statuscompras.nomeStatus,
 statuscompras.idStatuscompras,
 pedido_cotacaoitens.idPedidoCompra,
 pedido_cotacaoitens.idPedidoCompraItens,
 pedido_cotacaoitens.idCotacaoItens,
 pedido_cotacaoitens.idPedidoCotacao,
 insumos.descricaoInsumo
');
        $this->db->from($table);
       
 $this->db->join('pedido_cotacaoitens', 'pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens');
 $this->db->join('distribuir_os', 'pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir');
    $this->db->join('insumos', 'insumos.idInsumos = distribuir_os.idInsumos');   
    $this->db->join('statuscompras', 'statuscompras.idStatuscompras = distribuir_os.idStatuscompras');   
        $this->db->order_by($table.'.idPedidoCompra','desc');
        $this->db->limit($perpage,$start);
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
	
	public function getWhereLikeos($idOs, $idPedidoCotacao ='',$idStatuscompras,$idPedidoCompra='',$fornecedor_id='',$nf_fornecedor='',$query_idgrupo='',$solicitacao='',$query_usuario='', $numPedido='', $empresaNum1='', $empresaNum2='', $descricao='',$retirarOs='',$dataEntrega='',$autorizacaoPCP='', $unid_exec = '', $responsabilidadePCP = '',$usuario_orc = '')
    {

		if($query_usuario <> '')
		{
			$query_usuario1 = " and distribuir_os.usuario_cadastro in(".$query_usuario.")";			
		}
		else
		{
			$query_usuario1 = '';
		}/*
		if($solicitacao <> '')
		{
			
         $solicitacao1 = 'and distribuir_os.solicitacao = 2';
		}
		else
		{
			$solicitacao1 = "and distribuir_os.solicitacao = 1";
		}*/
		if($idOs <> '')
		{
			
         $idOs1 = " and distribuir_os.idOs in( ".$idOs.")";
		}
		else
		{
			$idOs1 = '';
		}
		if($idPedidoCompra <> '')
		{
			$idPedidoCompra1 = " and pedido_cotacaoitens.idPedidoCompra in( ".$idPedidoCompra.")";
			
		}
		else
		{
			$idPedidoCompra1 = '';
		}
		
		if($idPedidoCotacao <> '')
		{
			$idPedidoCotacao1 = " and  pedido_cotacaoitens.idPedidoCotacao in (".$idPedidoCotacao.")";
		}
		else
		{
			$idPedidoCotacao1 = '';
		}
		if($query_idgrupo <> '')
		{
			$query_idgrupo1  = " and  distribuir_os.id_status_grupo in ".$query_idgrupo;
		}
		else
		{
			$query_idgrupo1 = '';
		}
		if($idStatuscompras <> '')
		{
			$idStatuscompras1  = " and  distribuir_os.idStatuscompras in ".$idStatuscompras;
		}
		else
		{
			$idStatuscompras1 = '';
		}
		if($fornecedor_id <> '')
		{
			$fornecedor_id1  = " and  fornecedores.idFornecedores = ".$fornecedor_id;
		}
		else
		{
			$fornecedor_id1 = '';
		}
		if($nf_fornecedor <> '')
		{
			$nf_fornecedor1  = " and  pedido_comprasitens.notafiscal in( ".$nf_fornecedor.")";
		}
		else
		{
			$nf_fornecedor1 = '';
		}

		if($numPedido <> '')
		{			
			$numPedido1  = " and  pedido_cotacaoitens.idPedidoCotacao = ".$numPedido;
		}
		else
		{
			$numPedido1 = '';
		}
		//-----------------------------------------
		if($empresaNum1 <> '' && $empresaNum2 <> '')
		{			
			$empresaNum  = " and os.unid_faturamento BETWEEN ".$empresaNum1. " and ". $empresaNum2;
		}
		else
		{
			$empresaNum = '';
		}	
		
		if($descricao <> ''){
			$descricao = " and insumos.descricaoInsumo LIKE '%".$descricao."%'";
		}else{
			$descricao = '';
		}/*
		if($dataEntrega <> ''){
			$dataEntrega = " and pedido_comprasitens.datastatusentregue = '".$dataEntrega."'";
		}else{
			$dataEntrega = '';
		}*/
		if($autorizacaoPCP <> ''){
			$autorizacaoPCP = " and distribuir_os.finalizado = '".$autorizacaoPCP."'";
		}else{
			$autorizacaoPCP = '';
		}
		if(!empty($unid_exec))
		{
			$unid_exec1  = " and  os.unid_execucao in ".$unid_exec."";
		}else{
			$unid_exec1 = '';
		}
        
		if($responsabilidadePCP <> ''){
			$responsabilidadePCP = " and distribuir_os.responsabilidadePCP = '".$responsabilidadePCP."'";
		}else{
			$responsabilidadePCP = '';
		}
		if($usuario_orc <> ''){
			$usuario_orc = " and distribuir_os.idUser_aguardandoOrc in ".$usuario_orc;
		}else{
			$usuario_orc = "";
		}
        $query = "
			SELECT distribuir_os.idDistribuir,
				distribuir_os.idOs,
				usuarios.user,
				distribuir_os.quantidade,
				insumos.idInsumos,
				pedido_comprasitens.idPedidoCompraItens,
				pedido_comprasitens.valor_unitario,
				pedido_compras.idEmitente,				
				fornecedores.nomeFornecedor,
				pedido_comprasitens.notafiscal,
				pedido_comprasitens.obs as obscompras,
				distribuir_os.data_revisao_pcp, 
				distribuir_os.observacao_revisao_pcp, 
				distribuir_os.data_alteracao,
				distribuir_os.data_cadastro as datacadastrodist,
				distribuir_os.dimensoes,
				distribuir_os.histo_alteracao,
				distribuir_os.obs,
				distribuir_os.metrica,
				distribuir_os.comprimento,
				distribuir_os.volume,
				distribuir_os.peso,
				distribuir_os.dimensoesL,
				distribuir_os.dimensoesA,
				distribuir_os.dimensoesC,
				usuarios3.nome as nomePCP,
				usuarios4.nome as nomeSUP,
				usuarios5.nome as nomeDirTec,
				usuarios6.nome as nomeDir,
				distribuir_os.data_autorizacaoPCP,
				distribuir_os.data_autorizacaoDir,
				distribuir_os.data_autorizacaoSUP,
				status_grupo_compra.nomegrupo,
				status_grupo_compra.idgrupo,
				pedido_cotacaoitens.data_cadastro,
				pedido_compras.data_cadastro as cadpedgerado,
				pedido_comprasitens.data_autorizacao,
				statuscompras.nomeStatus,
				statuscompras.cor,
				statuscompras.idStatuscompras,
				almo_permissao_suprimentos.statusPermissao,
				almo_permissao_suprimentos.idAlmoPermSupr,
				pedido_comprasitens.datastatusentregue,
				pedido_cotacaoitens.idPedidoCompra,
				pedido_cotacaoitens.idPedidoCompraItens,
				pedido_cotacaoitens.idCotacaoItens,
				pedido_cotacaoitens.idPedidoCotacao,
				usuarios2.nome as nomeAgOrc,
				insumos.descricaoInsumo,
				unidade_execucao.status_execucao
				FROM
				pedido_cotacaoitens RIGHT JOIN distribuir_os 
				ON distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
				INNER JOIN usuarios 
				ON distribuir_os.usuario_cadastro = usuarios.idUsuarios 
				INNER JOIN status_grupo_compra 
				on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo  
				INNER JOIN insumos 
				ON insumos.idInsumos = distribuir_os.idInsumos  
				INNER JOIN statuscompras 
				ON statuscompras.idStatuscompras = distribuir_os.idStatuscompras   
				LEFT JOIN pedido_compras 
				ON pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra
				LEFT JOIN emitente 
				ON pedido_compras.idEmitente = emitente.id 
				LEFT JOIN fornecedores 
				ON fornecedores.idFornecedores = pedido_compras.idFornecedores 
				LEFT JOIN pedido_comprasitens 
				ON pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
				INNER JOIN os
				ON os.idOs = distribuir_os.idOs
				LEFT JOIN almo_permissao_suprimentos 
				ON almo_permissao_suprimentos.idInsumo = distribuir_os.idInsumos
				LEFT JOIN usuarios as usuarios2 on usuarios2.idUsuarios = distribuir_os.idUser_aguardandoOrc
				LEFT JOIN usuarios as usuarios3 on usuarios3.idUsuarios = distribuir_os.idUserAprovacao
				LEFT JOIN usuarios as usuarios4 on usuarios4.idUsuarios = distribuir_os.idUserAprovacaoSUP
				LEFT JOIN usuarios as usuarios5 on usuarios5.idUsuarios = distribuir_os.idUserAprovacaoDir
				LEFT JOIN usuarios as usuarios6 on usuarios6.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao

				LEFT JOIN unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
				WHERE
				statuscompras.idStatuscompras not in(0) $idOs1 $idPedidoCotacao1 $idStatuscompras1 $query_idgrupo1 $idPedidoCompra1 $fornecedor_id1 $nf_fornecedor1 $numPedido1 $empresaNum $descricao $query_usuario1 $retirarOs $dataEntrega $unid_exec1 $usuario_orc ORDER BY distribuir_os.data_alteracao desc

		";
		//print_r($query); exit;
        //echo $query;
		//exit;
        return $this->db->query($query)->result();
       
    }
	
    public function numrowsWhereLikeos($idOs, $idPedidoCotacao,$idStatuscompras,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo,$solicitacao,$query_usuario,$numPedido, $empresaNum1, $empresaNum2)
    {
		if($query_usuario <> '')
		{
			$query_usuario1 = " and  distribuir_os.usuario_cadastro in(".$query_usuario.")";
			
		}
		else
		{
			$query_usuario1 = '';
		}
		if($solicitacao <> '')
		{
			
         $solicitacao1 = 'and distribuir_os.solicitacao = 2';
		}
		else
		{
			$solicitacao1 = "and distribuir_os.solicitacao = 1";
		}
if($nf_fornecedor <> '')
		{
			$nf_fornecedor1  = " and  pedido_comprasitens.notafiscal in( ".$nf_fornecedor.")";
		}
		else
		{
			$nf_fornecedor1 = '';
		}
		
		
      if($idOs <> '')
		{
			
         $idOs1 = " and distribuir_os.idOs in( ".$idOs.")";
		}
		else
		{
			$idOs1 = '';
		}
		
		if($idPedidoCompra <> '')
		{
			$idPedidoCompra1 = " and  pedido_cotacaoitens.idPedidoCompra in( ".$idPedidoCompra.")";
		}
		else
		{
			$idPedidoCompra1 = '';
		}
		if($idPedidoCotacao <> '')
		{
			$idPedidoCotacao1 = " and  pedido_cotacaoitens.idPedidoCotacao in (".$idPedidoCotacao.")";
		}
		else
		{
			$idPedidoCotacao1 = '';
		}
		if($idStatuscompras <> '')
		{
			$idStatuscompras1  = " and  distribuir_os.idStatuscompras in ".$idStatuscompras;
		}
		else
		{
			$idStatuscompras1 = '';
		}
		if($query_idgrupo <> '')
		{
			$query_idgrupo1  = " and  distribuir_os.id_status_grupo in ".$query_idgrupo;
		}
		else
		{
			$query_idgrupo1 = '';
		}
		
		if($fornecedor_id <> '')
		{
			$fornecedor_id1  = " and  fornecedores.idFornecedores = ".$fornecedor_id;
		}
		else
		{
			$fornecedor_id1 = '';
		}
		
			
        $query = "
			SELECT distribuir_os.idDistribuir,
			usuarios.user,
			distribuir_os.idOs,
			distribuir_os.quantidade,
			distribuir_os.dimensoes,
			distribuir_os.histo_alteracao,
			distribuir_os.data_cadastro as datacadastrodist,
			distribuir_os.obs,
			status_grupo_compra.nomegrupo,
			status_grupo_compra.idgrupo,
			pedido_cotacaoitens.data_cadastro,
			pedido_compras.data_cadastro as cadpedgerado,
			fornecedores.nomeFornecedor,
			pedido_comprasitens.datastatusentregue,
			pedido_comprasitens.notafiscal,
			pedido_comprasitens.obs as obscompras,
			statuscompras.nomeStatus,
			statuscompras.idStatuscompras,
			statuscompras.cor,
			pedido_cotacaoitens.idPedidoCompra,
			pedido_cotacaoitens.idPedidoCompraItens,
			pedido_cotacaoitens.idCotacaoItens,
			pedido_cotacaoitens.idPedidoCotacao,
			insumos.descricaoInsumo FROM pedido_cotacaoitens inner join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir inner join usuarios on distribuir_os.usuario_cadastro = usuarios.idUsuarios inner join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo  inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras left join pedido_compras on pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra  left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  where statuscompras.idStatuscompras not in(1) $solicitacao1  $idOs1 $idPedidoCotacao1 $idStatuscompras1 $query_idgrupo1 $idPedidoCompra1 $fornecedor_id1 $nf_fornecedor1 $query_usuario1 ORDER BY pedido_cotacaoitens.idPedidoCotacao desc
		";
       
        return $this->db->query($query)->num_rows();
       
    }
	public function getWhereLikeos_editar($idOs, $idPedidoCotacao,$idStatuscompras,$idPedidoCompra,$query_usuario)
    {
		if($idOs <> '')
		{
			
         $idOs1 = " and distribuir_os.idOs = ".$idOs;
		}
		else
		{
			$idOs1 = '';
		}
		if($idPedidoCompra <> '')
		{
			$idPedidoCompra1 = " and  pedido_cotacaoitens.idPedidoCompra = ".$idPedidoCompra;
		}
		else
		{
			$idPedidoCompra1 = '';
		}
		
		if($idPedidoCotacao <> '')
		{
			$idPedidoCotacao1 = " and  pedido_cotacaoitens.idPedidoCotacao = ".$idPedidoCotacao;
		}
		else
		{
			$idPedidoCotacao1 = '';
		}
		if($idStatuscompras <> '')
		{
			$idStatuscompras1  = " and  distribuir_os.idStatuscompras = ".$idStatuscompras;
		}
		else
		{
			$idStatuscompras1 = '';
		}
		
		
         
        $query = "
         	SELECT distribuir_os.idDistribuir,
			distribuir_os.idOs,
			distribuir_os.quantidade,
			distribuir_os.dimensoes,
			distribuir_os.histo_alteracao,
			distribuir_os.obs,
			distribuir_os.data_cadastro,
			statuscompras.nomeStatus,
			statuscompras.idStatuscompras,
			pedido_cotacaoitens.idPedidoCompra,
			pedido_cotacaoitens.idPedidoCompraItens,
			pedido_cotacaoitens.idCotacaoItens,
			pedido_cotacaoitens.idPedidoCotacao,
			insumos.descricaoInsumo FROM
			pedido_cotacaoitens inner join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
			inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras inner join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens   where 1 = 1 $idOs1 $idPedidoCotacao1 $idStatuscompras1 $idPedidoCompra1 ORDER BY pedido_comprasitens.idPedidoCompra desc
		";
        
        return $this->db->query($query)->result();
       
    }
	 public function numrowsWhereLikeos_editar($idOs, $idPedidoCotacao,$idStatuscompras,$idPedidoCompra)
    {

      if($idOs <> '')
		{
			
         $idOs1 = " and distribuir_os.idOs = ".$idOs;
		}
		else
		{
			$idOs1 = '';
		}
		
		if($idPedidoCompra <> '')
		{
			$idPedidoCompra1 = " and  pedido_cotacaoitens.idPedidoCompra = ".$idPedidoCompra;
		}
		else
		{
			$idPedidoCompra1 = '';
		}
		if($idPedidoCotacao <> '')
		{
			$idPedidoCotacao1 = " and  pedido_cotacaoitens.idPedidoCotacao = ".$idPedidoCotacao;
		}
		else
		{
			$idPedidoCotacao1 = '';
		}
		if($idStatuscompras <> '')
		{
			$idStatuscompras1  = " and  distribuir_os.idStatuscompras = ".$idStatuscompras;
		}
		else
		{
			$idStatuscompras1 = '';
		}
		
		
		
			
        $query = "
         SELECT distribuir_os.idDistribuir,
distribuir_os.idOs,
distribuir_os.quantidade,
distribuir_os.dimensoes,
distribuir_os.obs,
distribuir_os.histo_alteracao,
distribuir_os.data_cadastro,
status_grupo_compra.nomegrupo,
status_grupo_compra.idgrupo,
 statuscompras.nomeStatus,
 statuscompras.idStatuscompras,
  pedido_cotacaoitens.idPedidoCompra,
  pedido_cotacaoitens.idPedidoCompraItens,
pedido_cotacaoitens.idCotacaoItens,
 pedido_cotacaoitens.idPedidoCotacao,
 insumos.descricaoInsumo FROM pedido_cotacaoitens inner join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir inner join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras inner join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens  where 1 = 1 $idOs1 $idPedidoCotacao1 $idStatuscompras1 $idPedidoCompra1 ORDER BY pedido_cotacaoitens.idPedidoCompra desc
        ";
       
       
        
        return $this->db->count_all();
       
    }

	public function getOc($itens)
    {		
         
        $query = "
         SELECT
			pedido_cotacaoitens.idPedidoCompra,
			pedido_cotacaoitens.idPedidoCompraItens
			FROM
			pedido_cotacaoitens RIGHT JOIN distribuir_os 
			ON distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
			INNER JOIN usuarios 
			ON distribuir_os.usuario_cadastro = usuarios.idUsuarios 
			INNER JOIN status_grupo_compra 
			on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo  
			INNER JOIN insumos 
			ON insumos.idInsumos = distribuir_os.idInsumos  
			INNER JOIN statuscompras 
			ON statuscompras.idStatuscompras = distribuir_os.idStatuscompras   
			LEFT JOIN pedido_compras 
			ON pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra
			LEFT JOIN emitente 
			ON pedido_compras.idEmitente = emitente.id 
			LEFT JOIN fornecedores 
			ON fornecedores.idFornecedores = pedido_compras.idFornecedores 
			LEFT JOIN pedido_comprasitens 
			ON pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
			INNER JOIN os
			ON os.idOs = distribuir_os.idOs
			WHERE
			statuscompras.idStatuscompras not in(0) and distribuir_os.idDistribuir in ($itens)
		";
		//print_r($query); exit;
        
        return $this->db->query($query)->result();
       
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
	
	function gettable($table,$where,$varios = '',$one=false){
       
        $this->db->from($table);
       
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        if($varios == 1){
			$result =  $query->result();
		}
		else
		{
			$result =  $query->row();
		}
			
        
        return $result;
    }
	public function gettable2($table,$where,$campo)
    {
		 
		
		$this->db->where($where,$campo);
        return $this->db->get($table)->result();
       
    }
    public function pedidoCustom($id='',$itens='',$statuscompra = ''){
       
	   if(!empty($id))
		 {
			 $tes1 = str_replace(".",",",$id); 
			$id1 = " and pedido_comprasitens.idPedidoCompra in(".$tes1.")";
		 }
		 else
		 {
			 $id1 = '';
		 }
		 
	 
	  if(!empty($statuscompra))
		 {
			 $pegacampo = explode('-', $statuscompra);
			 if($pegacampo[0] == 'st')
			 {
				 $statuscompra1 = " and statuscompras.idStatuscompras = ".$pegacampo[1]; 
			 }
			 elseif($pegacampo[0] == 'os')
			 {
				  $statuscompra1 = " and distribuir_os.idOs = ".$pegacampo[1];
				 
			 }
			 elseif($pegacampo[0] == 'itens')
			 {
				 $tes = str_replace(".",",",$pegacampo[1]);
				  $statuscompra1 = "and pedido_comprasitens.idPedidoCompraItens in(".$tes.")";
				 
			 }
			 else
			 {
				 $statuscompra1  = " and pedido_comprasitens.notafiscal = ".$pegacampo[1]; 
			 }
					
					 
			
		 }
		else
		{
			$statuscompra1 = ""; 
		}
		
	   if(!empty($itens))
	   {
		   $itens1 = "and pedido_comprasitens.idPedidoCompraItens in(".$itens.")";
	   }
	   else
	   {
		   $itens1 = '';
	   }
			$query = "
			SELECT distribuir_os.idDistribuir,
			distribuir_os.idOs,
			distribuir_os.quantidade,
			distribuir_os.liberado_edit_compras,
			distribuir_os.dimensoes,
			distribuir_os.comprimento,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			distribuir_os.histo_alteracao,
			distribuir_os.obs,
				pedido_comprasitens.ipi_valor,

			statuscompras.nomeStatus,
			statuscompras.idStatuscompras,
			pedido_cotacaoitens.idPedidoCompra,
			pedido_cotacaoitens.idPedidoCompraItens,
			pedido_cotacaoitens.idCotacaoItens,
			pedido_cotacaoitens.idPedidoCotacao,
			pedido_comprasitens.`valor_unitario`,
			pedido_comprasitens.`valor_total`,
			pedido_comprasitens.`quantidade` as qtdrecebida,
			pedido_compras.`idFornecedores`,
			pedido_compras.`idEmitente`,
			pedido_comprasitens.`previsao_entrega`,
			pedido_comprasitens.`prazo_entrega`,
			pedido_compras.`data_cadastro`,
			pedido_comprasitens.`idCondPgto`,
			pedido_comprasitens.`cod_pgto`,
			pedido_comprasitens.`obs` as obscompras,

			pedido_comprasitens.`desconto`,
			pedido_comprasitens.`outros`,
			pedido_compras.`frete`,
			pedido_comprasitens.`icms`,
			emitente.nome, 
			emitente.id,
			emitente.url_logo,
			emitente.imagem,
			emitente.nome,
			emitente.cnpj,
			emitente.rua,
			emitente.numero,
			emitente.cidade,
			emitente.email_compras,
			emitente.ie,
			emitente.bairro,
			emitente.uf,
			emitente.telefone,
			fornecedores.nomeFornecedor,
			fornecedores.idFornecedores,
			fornecedores.documento,
			fornecedores.telefone as telforne,
			fornecedores.rua as ruaforne,
			fornecedores.bairro as bforne,
			insumos.descricaoInsumo,
			status_os.nomeStatusOs,
			unidade_execucao.status_execucao FROM
			pedido_cotacaoitens inner join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
			inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  
			inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
			inner join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
			inner join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra 
			inner join os on os.idOs = distribuir_os.idOs
			inner join status_os on status_os.idStatusOs = os.idStatusOs
			inner join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
			left join emitente on pedido_compras.idEmitente = emitente.id 
			left join fornecedores on fornecedores.idFornecedores = pedido_compras.	idFornecedores  
			where 1=1 $id1 $itens1 $statuscompra1 ORDER BY insumos.descricaoInsumo asc
        ";		//print_r($query); exit;
        
        return $this->db->query($query)->result();
    }

	public function pedidoCustom2($id='',$itens='',$statuscompra = ''){
       
		if(!empty($id))
		  {
			  $tes1 = str_replace(".",",",$id); 
			 $id1 = " and pedido_comprasitens.idPedidoCompra in(".$tes1.")";
		  }
		  else
		  {
			  $id1 = '';
		  }
		  
	  
	   if(!empty($statuscompra))
		  {
			  $pegacampo = explode('-', $statuscompra);
			  if($pegacampo[0] == 'st')
			  {
				  $statuscompra1 = " and statuscompras.idStatuscompras = ".$pegacampo[1]; 
			  }
			  elseif($pegacampo[0] == 'os')
			  {
				   $statuscompra1 = " and distribuir_os.idOs = ".$pegacampo[1];
				  
			  }
			  elseif($pegacampo[0] == 'itens')
			  {
				  $tes = str_replace(".",",",$pegacampo[1]);
				   $statuscompra1 = "and pedido_comprasitens.idPedidoCompraItens in(".$tes.")";
				  
			  }
			  else
			  {
				  $statuscompra1  = " and pedido_comprasitens.notafiscal = ".$pegacampo[1]; 
			  }
					 
					  
			 
		  }
		 else
		 {
			 $statuscompra1 = ""; 
		 }
		 
		if(!empty($itens))
		{
			$itens1 = "and pedido_comprasitens.idPedidoCompraItens in(".$itens.")";
		}
		else
		{
			$itens1 = '';
		}
	   $query = "
		 SELECT distribuir_os.idDistribuir,
		 distribuir_os.idOs,
		 distribuir_os.quantidade,
		 distribuir_os.liberado_edit_compras,
		 distribuir_os.dimensoes,
		 distribuir_os.histo_alteracao,
		 distribuir_os.obs,
			 pedido_comprasitens.ipi_valor,
 
		 statuscompras.nomeStatus,
		 statuscompras.idStatuscompras,
		 pedido_cotacaoitens.idPedidoCompra,
		 pedido_cotacaoitens.idPedidoCompraItens,
		 pedido_cotacaoitens.idCotacaoItens,
		 pedido_cotacaoitens.idPedidoCotacao,
		 pedido_comprasitens.`valor_unitario`,
		 pedido_comprasitens.`valor_total`,
		 pedido_comprasitens.`quantidade` as qtdrecebida,
		 pedido_compras.`idFornecedores`,
		 pedido_compras.`idEmitente`,
		 pedido_comprasitens.`previsao_entrega`,
		 pedido_comprasitens.`prazo_entrega`,
		 pedido_compras.`data_cadastro`,
		 pedido_comprasitens.`idCondPgto`,
		 pedido_comprasitens.`cod_pgto`,
		 pedido_comprasitens.`obs` as obscompras,
 
		 pedido_comprasitens.`desconto`,
		 pedido_comprasitens.`outros`,
		 pedido_compras.`frete`,
		 pedido_comprasitens.`icms`,
		 emitente.nome, 
		 emitente.id,
		 emitente.url_logo,
		 emitente.imagem,
		 emitente.nome,
		 emitente.cnpj,
		 emitente.rua,
		 emitente.numero,
		 emitente.cidade,
		 emitente.email_compras,
		 emitente.ie,
		 emitente.bairro,
		 emitente.uf,
		 emitente.telefone,
		 fornecedores.nomeFornecedor,
		 fornecedores.idFornecedores,
		 fornecedores.documento,
		 fornecedores.telefone as telforne,
		 fornecedores.rua as ruaforne,
		 fornecedores.bairro as bforne,
		 insumos.descricaoInsumo FROM
		 pedido_cotacaoitens inner join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
		 inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  
		 inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		 inner join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
		 inner join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra 
		 left join emitente on pedido_compras.idEmitente = emitente.id 
		 left join fornecedores on fornecedores.idFornecedores = pedido_compras.	idFornecedores  
		 where 1=1 $id1 $itens1 $statuscompra1 ORDER BY distribuir_os.idOs desc
		 ";		
		 
		 return $this->db->query($query)->result();
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
	
	 public function autoCompleteEmitente($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nome', $q);
        $query = $this->db->get('emitente');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome'],'id'=>$row['id']);
            }
            echo json_encode($row_set);
        }
    }
	
	public function autoCompleteFornecedor($q){

        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('nomeFornecedor', $q);
        $query = $this->db->get('fornecedores');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nomeFornecedor'],'id'=>$row['idFornecedores']);
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

	public function getWhereLikeos2($parPedidoCotacao = ''){
		/*
		if($parPedidoCotacao <> '')
		{
			$parPedidoCotacao1 = " and  pedido_cotacaoitens.idPedidoCotacao in(".$parPedidoCotacao.")";
		}
		else
		{
			$parPedidoCotacao1 = '';
		}*/

		if($parPedidoCotacao <> '')
		{
			
			$parPedidoCotacao1 = " and distribuir_os.idDistribuir in (".$parPedidoCotacao.")";
		}
		else
		{
			$parPedidoCotacao1 = '';
		}

		$query = "
        SELECT distribuir_os.idDistribuir,
        usuarios.user,
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
        distribuir_os.histo_alteracao,
        distribuir_os.data_cadastro,
        distribuir_os.data_alteracao as data_alt,
        distribuir_os.liberado_edit_compras,
        statuscompras.nomeStatus,
        statuscompras.idStatuscompras,
        insumos.descricaoInsumo,
		pedido_cotacao.data_cadastro as datacotacao,
		pedido_cotacao.idPedidoCotacao
        FROM `distribuir_os` 
        inner join usuarios on distribuir_os.usuario_cadastro = usuarios.idUsuarios 
        inner join insumos on insumos.idInsumos = distribuir_os.idInsumos
        inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
		join pedido_cotacao on pedido_cotacao.idPedidoCotacao = pedido_cotacaoitens.idPedidoCotacao
        where 1=1 $parPedidoCotacao1
        ORDER BY `distribuir_os`.`data_cadastro` desc
        ";
        
        return $this->db->query($query)->result();

	}

	public function cotacaoCustom($idEmitente = '', $itensimprimir = ''){
           
    	$imprimir = "distribuir_os.idDistribuir in(".$itensimprimir.")";
       
		$query = "
		SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		distribuir_os.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.obs,
		distribuir_os.data_cadastro,
		statuscompras.nomeStatus,
		statuscompras.idStatuscompras,
		insumos.descricaoInsumo 
		FROM `distribuir_os`
		inner join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		where $imprimir ORDER BY `distribuir_os`.`data_cadastro` desc			
		";
		
        
        return $this->db->query($query)->result();
    }
	public function pedidoCustom3($itens = ''){
		$query = "
		SELECT distribuir_os.idDistribuir, distribuir_os.idOs, distribuir_os.quantidade, distribuir_os.liberado_edit_compras, distribuir_os.dimensoes, 
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,distribuir_os.histo_alteracao, distribuir_os.obs, statuscompras.nomeStatus, statuscompras.idStatuscompras, pedido_cotacaoitens.idPedidoCompra, pedido_cotacaoitens.idPedidoCompraItens, pedido_cotacaoitens.idCotacaoItens, pedido_cotacaoitens.idPedidoCotacao, pedido_comprasitens.`valor_unitario`, pedido_comprasitens.`valor_total`, pedido_comprasitens.`quantidade` as qtdrecebida, pedido_compras.`idFornecedores`, pedido_compras.`idEmitente`, pedido_comprasitens.`previsao_entrega`, pedido_comprasitens.`prazo_entrega`, pedido_compras.`data_cadastro`, pedido_comprasitens.`idCondPgto`, pedido_comprasitens.`cod_pgto`, pedido_comprasitens.`obs` as obscompras, pedido_comprasitens.`desconto`, pedido_comprasitens.`outros`, pedido_compras.`frete`, pedido_comprasitens.`icms`, emitente.nome, emitente.id, emitente.url_logo, emitente.imagem, emitente.nome, emitente.cnpj, emitente.rua, emitente.numero, emitente.cidade, emitente.email_compras, emitente.ie, emitente.bairro, emitente.uf, emitente.telefone, fornecedores.nomeFornecedor, fornecedores.idFornecedores, fornecedores.documento, fornecedores.telefone as telforne, fornecedores.rua as ruaforne, fornecedores.bairro as bforne, insumos.descricaoInsumo,
        status_os.nomeStatusOs,
        unidade_execucao.status_execucao
		FROM pedido_cotacaoitens RIGHT JOIN distribuir_os 
		ON distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
		INNER JOIN usuarios 
		ON distribuir_os.usuario_cadastro = usuarios.idUsuarios 
		INNER JOIN status_grupo_compra 
		on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo  
		INNER JOIN insumos 
		ON insumos.idInsumos = distribuir_os.idInsumos  
		INNER JOIN statuscompras 
		ON statuscompras.idStatuscompras = distribuir_os.idStatuscompras   
		LEFT JOIN pedido_compras 
		ON pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra
		LEFT JOIN emitente 
		ON pedido_compras.idEmitente = emitente.id 
		LEFT JOIN fornecedores 
		ON fornecedores.idFornecedores = pedido_compras.idFornecedores 
		LEFT JOIN pedido_comprasitens 
		ON pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
		INNER JOIN os
		ON os.idOs = distribuir_os.idOs
        inner join status_os on status_os.idStatusOs = os.idStatusOs
        inner join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
		WHERE
		statuscompras.idStatuscompras not in(0) and distribuir_os.idDistribuir in($itens)
		";
		//print_r($query); exit;
        
        return $this->db->query($query)->result();
	}
	public function getIdsDisitribuir($itens = ''){
		$query = "
		SELECT distribuir_os.idDistribuir, distribuir_os.idOs, pedido_cotacaoitens.idPedidoCompra,statuscompras.idStatuscompras, pedido_cotacaoitens.idPedidoCompraItens, pedido_cotacaoitens.idCotacaoItens, pedido_cotacaoitens.idPedidoCotacao
		FROM pedido_cotacaoitens RIGHT JOIN distribuir_os 
		ON distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
		INNER JOIN usuarios 
		ON distribuir_os.usuario_cadastro = usuarios.idUsuarios 
		INNER JOIN status_grupo_compra 
		on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo  
		INNER JOIN insumos 
		ON insumos.idInsumos = distribuir_os.idInsumos  
		INNER JOIN statuscompras 
		ON statuscompras.idStatuscompras = distribuir_os.idStatuscompras   
		LEFT JOIN pedido_compras 
		ON pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra
		LEFT JOIN emitente 
		ON pedido_compras.idEmitente = emitente.id 
		LEFT JOIN fornecedores 
		ON fornecedores.idFornecedores = pedido_compras.idFornecedores 
		LEFT JOIN pedido_comprasitens 
		ON pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
		INNER JOIN os
		ON os.idOs = distribuir_os.idOs
		WHERE
		statuscompras.idStatuscompras not in(0) and distribuir_os.idDistribuir in($itens)
		";
        
        return $this->db->query($query)->result();
	}
	public function ultimasComprasLIMIT10($idOs){
		if($idOs <> '')
		{
			
         $idOs1 = " and distribuir_os.idOs in (".$idOs.")";
		}
		else
		{
			$idOs1 = '';
		}
		$query = 'SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		usuarios.user,
		distribuir_os.quantidade,
		insumos.idInsumos,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.valor_unitario,
		pedido_compras.idEmitente,
		fornecedores.nomeFornecedor,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		distribuir_os.data_alteracao,
		distribuir_os.data_cadastro as datacadastrodist,
		distribuir_os.dimensoes,
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,
		distribuir_os.histo_alteracao,
		distribuir_os.obs,
		status_grupo_compra.nomegrupo,
		status_grupo_compra.idgrupo,
		pedido_cotacaoitens.data_cadastro,
		pedido_compras.data_cadastro as cadpedgerado,
		statuscompras.nomeStatus,
		statuscompras.cor,
		statuscompras.idStatuscompras,
		almo_permissao_suprimentos.statusPermissao,
		almo_permissao_suprimentos.idAlmoPermSupr,
		pedido_comprasitens.datastatusentregue,
		pedido_cotacaoitens.idPedidoCompra,
		pedido_cotacaoitens.idPedidoCompraItens,
		pedido_cotacaoitens.idCotacaoItens,
		pedido_cotacaoitens.idPedidoCotacao,
		insumos.descricaoInsumo 
		FROM
		pedido_cotacaoitens RIGHT JOIN distribuir_os 
		ON distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		INNER JOIN usuarios 
		ON distribuir_os.usuario_cadastro = usuarios.idUsuarios 
		INNER JOIN status_grupo_compra 
		on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo 
		INNER JOIN insumos 
		ON insumos.idInsumos = distribuir_os.idInsumos 
		INNER JOIN statuscompras 
		ON statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		LEFT JOIN pedido_compras 
		ON pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra 
		LEFT JOIN emitente 
		ON pedido_compras.idEmitente = emitente.id 
		LEFT JOIN fornecedores 
		ON fornecedores.idFornecedores = pedido_compras.idFornecedores 
		LEFT JOIN pedido_comprasitens 
		ON pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
		INNER JOIN os
		ON os.idOs = distribuir_os.idOs
		LEFT JOIN almo_permissao_suprimentos 
		ON almo_permissao_suprimentos.idInsumo = distribuir_os.idInsumos
		WHERE
		statuscompras.idStatuscompras '.$idOs1.' ORDER BY distribuir_os.idDistribuir DESC LIMIT 10';

		return $this->db->query($query)->result();
	}
	public function itensautorizacaocompra($min,$max){
		if(!empty($max)){
			$where = " and pedido_comprasitens.quantidade*pedido_comprasitens.valor_unitario between '".$min."' and '".$max."'";
		}else{
			$where = " and pedido_comprasitens.quantidade*pedido_comprasitens.valor_unitario >= '".$min."'";
		}
		$query = 'select distribuir_os.idDistribuir,
			distribuir_os.idOs,
			distribuir_os.dimensoes,
			insumos.descricaoInsumo, 
			pedido_comprasitens.valor_unitario, 
			pedido_comprasitens.quantidade,
			pedido_comprasitens.idPedidoCompraItens, 
			pedido_comprasitens.idPedidoCompra, 
			distribuir_os.data_cadastro, 
			pedido_comprasitens.data_autorizacao,
			pedido_comprasitens.autorizadoCompra
			from distribuir_os 
			join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
			join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			where distribuir_os.idStatuscompras = 10 
			and (pedido_comprasitens.valor_unitario is not null 
			and pedido_comprasitens.valor_unitario != "" 
			and pedido_comprasitens.valor_unitario != 0) 
			and distribuir_os.data_cadastro > "2022-03-25"'.$where;
		return $this->db->query($query)->result();
	}
	
	function getInsumosByPedidoComprasItens($id){
		$query = "SELECT insumos.idInsumos,distribuir_os.quantidade,distribuir_os.idOs from pedido_comprasitens join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir join insumos on insumos.idInsumos = distribuir_os.idInsumos where pedido_comprasitens.idPedidoCompraItens = $id";
		return $this->db->query($query)->row();
	}
	function getByIdOrdemCompra($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
			distribuir_os.idOs,
			pedido_comprasitens.idPedidoCompraItens,
			distribuir_os.idDistribuir,
			distribuir_os.comprimento,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			unidade_execucao.status_execucao,
			statuscompras.nomeStatus,
			insumos.descricaoInsumo,
			distribuir_os.dimensoes,
			status_os.nomeStatusOs,
			distribuir_os.quantidade
			FROM `pedido_compras` 
			join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
			join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
			join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
			join os on os.idOs = distribuir_os.idOs
			join status_os on status_os.idStatusOs = os.idStatusOs
			join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
			WHERE pedido_compras.idPedidoCompra = $id and distribuir_os.idStatuscompras in (5,4,14) and distribuir_os.entradaMp = 0";
		return $this->db->query($query)->result();
	}
	
	function getByIdDistribuir($id){
		$query = "SELECT * FROM `distribuir_os` WHERE distribuir_os.idDistribuir = $id";
		return $this->db->query($query)->row();
	}
	function getbyIdPedidoComprasItens($id){
		$query = "SELECT * FROM `pedido_comprasitens` WHERE idPedidoCompraItens = $id";
		return $this->db->query($query)->row();
	}
	function getValorInsumoByIdInsumo($id){
		$query = "SELECT * FROM `distribuir_os` 
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		WHERE distribuir_os.idInsumos = $id and distribuir_os.idStatuscompras = 5 ORDER by distribuir_os.data_cadastro desc limit 1";
		return $this->db->query($query)->row();
	}
	function getDistribuirByIdOs($idOs){
		$query = "SELECT sum(pedido_comprasitens.valor_unitario*distribuir_os.quantidade) as 'somaInsumo' FROM distribuir_os 
		JOIN pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens
		where distribuir_os.idStatuscompras = 5 and distribuir_os.idOs = $idOs";		
		return $this->db->query($query)->row();
	 }
	 function getDistribuirByIdOs2($idOs){
		$query = "SELECT distribuir_os.data_cadastro as dataDistribuir, pedido_comprasitens.data_cadastro as dataPedido FROM distribuir_os 
		JOIN pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens
		where distribuir_os.idStatuscompras = 5 and distribuir_os.idOs = $idOs";		
		return $this->db->query($query)->result();
	 }
	 
	 function getPedidoCompraItensByIdDistribuir($id){
		$query = "SELECT * FROM pedido_cotacaoitens WHERE idDistribuir = $id";
		return $this->db->query($query)->result();
	 }
	 function getPedidoCompraItensByIdCotacaoItem($id){
		$query = "SELECT * FROM pedido_comprasitens WHERE idCotacaoItens = $id";
		return $this->db->query($query)->result();
	 }
	 function getdistribuidorById($id){
		$query = "SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		distribuir_os.idInsumos,
		distribuir_os.quantidade,
		distribuir_os.data_reagendada,
		distribuir_os.justificativa,
		distribuir_os.data_cadastro as data_dist,
		pedido_comprasitens.previsao_entrega,
		fornecedores.nomeFornecedor,
		usuarios.nome,
		produtos.pn,
		fornecedores.telefone,
		orcamento_item.descricao_item,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		pedido_comprasitens.desconto,
		pedido_compras.frete,
		pedido_comprasitens.outros,
		pedido_comprasitens.data_cadastro as cadpedgerado,
		distribuir_os.dimensoes,
		distribuir_os.obs,
		status_grupo_compra.nomegrupo,
		pedido_cotacaoitens.data_cadastro,
		pedido_comprasitens.valor_total,
		pedido_comprasitens.datastatusentregue,
		statuscompras.nomeStatus,
		statuscompras.idStatuscompras,
		pedido_comprasitens.valor_unitario,
		pedido_cotacaoitens.idPedidoCompra,
		pedido_cotacaoitens.idPedidoCompraItens,
		pedido_cotacaoitens.idCotacaoItens,
		pedido_cotacaoitens.idPedidoCotacao,
		insumos.descricaoInsumo FROM distribuir_os 
		inner join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo 
		inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		inner join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		left join pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		left join pedido_cotacao on pedido_cotacao.idPedidoCotacao = pedido_cotacaoitens.idPedidoCotacao 
		left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
		left join pedido_compras on pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra    
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores 
		join os on os.idOs = distribuir_os.idOs 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		join produtos on produtos.idProdutos = orcamento_item.idProdutos
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro where 1 = 1 and distribuir_os.idDistribuir = $id";
		return $this->db->query($query)->row();
	 }
	 function getComprasRespPCP($idOs, $idPedidoCotacao ='',$idStatuscompras,$idPedidoCompra='',$fornecedor_id='',$nf_fornecedor='',$query_idgrupo='',$solicitacao='',$query_usuario='', $numPedido='', $empresaNum1='', $empresaNum2='', $descricao='',$retirarOs='',$dataEntrega='',$autorizacaoPCP='', $unid_exec = ''){
		if($query_usuario <> '')
		{
			$query_usuario1 = " and distribuir_os.usuario_cadastro in(".$query_usuario.")";			
		}
		else
		{
			$query_usuario1 = '';
		}/*
		if($solicitacao <> '')
		{
			
         $solicitacao1 = 'and distribuir_os.solicitacao = 2';
		}
		else
		{
			$solicitacao1 = "and distribuir_os.solicitacao = 1";
		}*/
		if($idOs <> '')
		{
			
         $idOs1 = " and distribuir_os.idOs in( ".$idOs.")";
		}
		else
		{
			$idOs1 = '';
		}
		if($idPedidoCompra <> '')
		{
			$idPedidoCompra1 = " and  pedido_cotacaoitens.idPedidoCompra in( ".$idPedidoCompra.")";
			
		}
		else
		{
			$idPedidoCompra1 = '';
		}
		
		if($idPedidoCotacao <> '')
		{
			$idPedidoCotacao1 = " and  pedido_cotacaoitens.idPedidoCotacao in (".$idPedidoCotacao.")";
		}
		else
		{
			$idPedidoCotacao1 = '';
		}
		if($query_idgrupo <> '')
		{
			$query_idgrupo1  = " and  distribuir_os.id_status_grupo in ".$query_idgrupo;
		}
		else
		{
			$query_idgrupo1 = '';
		}
		if($idStatuscompras <> '')
		{
			$idStatuscompras1  = " and  distribuir_os.idStatuscompras in ".$idStatuscompras;
		}
		else
		{
			$idStatuscompras1 = '';
		}
		if($fornecedor_id <> '')
		{
			$fornecedor_id1  = " and  fornecedores.idFornecedores = ".$fornecedor_id;
		}
		else
		{
			$fornecedor_id1 = '';
		}
		if($nf_fornecedor <> '')
		{
			$nf_fornecedor1  = " and  pedido_comprasitens.notafiscal in( ".$nf_fornecedor.")";
		}
		else
		{
			$nf_fornecedor1 = '';
		}

		if($numPedido <> '')
		{			
			$numPedido1  = " and  pedido_cotacaoitens.idPedidoCotacao = ".$numPedido;
		}
		else
		{
			$numPedido1 = '';
		}
		//-----------------------------------------
		if($empresaNum1 <> '' && $empresaNum2 <> '')
		{			
			$empresaNum  = " and os.unid_faturamento BETWEEN ".$empresaNum1. " and ". $empresaNum2;
		}
		else
		{
			$empresaNum = '';
		}	
		
		if($descricao <> ''){
			$descricao = " and insumos.descricaoInsumo LIKE '%".$descricao."%'";
		}else{
			$descricao = '';
		}/*
		if($dataEntrega <> ''){
			$dataEntrega = " and pedido_comprasitens.datastatusentregue = '".$dataEntrega."'";
		}else{
			$dataEntrega = '';
		}*/
		if($autorizacaoPCP <> ''){
			$autorizacaoPCP = " and distribuir_os.finalizado = '".$autorizacaoPCP."'";
		}else{
			$autorizacaoPCP = '';
		}
		if(!empty($unid_exec))
		{
			$unid_exec1  = " and  os.unid_execucao in ".$unid_exec."";
		}else{
			$unid_exec1 = '';
		}
		
		
		$query = "SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		usuarios.user,
		distribuir_os.quantidade,
		insumos.idInsumos,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.valor_unitario,
		pedido_compras.idEmitente,
		fornecedores.nomeFornecedor,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		distribuir_os.data_alteracao,
		distribuir_os.data_cadastro as datacadastrodist,
		distribuir_os.dimensoes,
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,
		distribuir_os.histo_alteracao,
		distribuir_os.obs,
		distribuir_os.finalizado,
		status_grupo_compra.nomegrupo,
		status_grupo_compra.idgrupo,
		pedido_cotacaoitens.data_cadastro,
		pedido_compras.data_cadastro as cadpedgerado,
		statuscompras.nomeStatus,
		statuscompras.cor,
		statuscompras.idStatuscompras,
		almo_permissao_suprimentos.statusPermissao,
		almo_permissao_suprimentos.idAlmoPermSupr,
		pedido_comprasitens.datastatusentregue,
		pedido_cotacaoitens.idPedidoCompra,
		pedido_cotacaoitens.idPedidoCompraItens,
		pedido_cotacaoitens.idCotacaoItens,
		pedido_cotacaoitens.idPedidoCotacao,
		usuarios2.nome as nomeAgOrc,
		insumos.descricaoInsumo 
		FROM
		pedido_cotacaoitens RIGHT JOIN distribuir_os 
		ON distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
		INNER JOIN usuarios 
		ON distribuir_os.usuario_cadastro = usuarios.idUsuarios 
		INNER JOIN status_grupo_compra 
		on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo  
		INNER JOIN insumos 
		ON insumos.idInsumos = distribuir_os.idInsumos  
		INNER JOIN statuscompras 
		ON statuscompras.idStatuscompras = distribuir_os.idStatuscompras   
		LEFT JOIN pedido_compras 
		ON pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra
		LEFT JOIN emitente 
		ON pedido_compras.idEmitente = emitente.id 
		LEFT JOIN fornecedores 
		ON fornecedores.idFornecedores = pedido_compras.idFornecedores 
		LEFT JOIN pedido_comprasitens 
		ON pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
		INNER JOIN os
		ON os.idOs = distribuir_os.idOs
		LEFT JOIN almo_permissao_suprimentos 
		ON almo_permissao_suprimentos.idInsumo = distribuir_os.idInsumos
		LEFT JOIN usuarios as usuarios2 on usuarios2.idUsuarios = distribuir_os.idUser_aguardandoOrc
		WHERE
		statuscompras.idStatuscompras not in(0) and distribuir_os.responsabilidadePCP = 1  $idOs1 $idPedidoCotacao1 $idStatuscompras1 $query_idgrupo1 $idPedidoCompra1 $fornecedor_id1 $nf_fornecedor1 $numPedido1 $empresaNum $descricao $query_usuario1 $retirarOs $dataEntrega $autorizacaoPCP $unid_exec1";
		return $this->db->query($query)->result();
	 }
	 function getComprasRespPCP2(){
		$query = "SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		distribuir_os.quantidade,
		distribuir_os.data_reagendada,
		distribuir_os.justificativa,
		distribuir_os.data_alteracao,
		distribuir_os.data_cadastro as data_dist,
		pedido_comprasitens.previsao_entrega,
		fornecedores.nomeFornecedor,
		usuarios.nome,
		produtos.pn,
		fornecedores.telefone,
		orcamento_item.descricao_item,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		pedido_comprasitens.desconto,
		pedido_compras.frete,
		pedido_comprasitens.outros,
		pedido_comprasitens.data_cadastro as cadpedgerado,
		distribuir_os.dimensoes,
		distribuir_os.obs,
		status_grupo_compra.nomegrupo,
		pedido_cotacaoitens.data_cadastro,
		pedido_comprasitens.valor_total,
		pedido_comprasitens.datastatusentregue,
		statuscompras.nomeStatus,
		statuscompras.etapa,
		statuscompras.idStatuscompras,
		pedido_comprasitens.valor_unitario,
		pedido_cotacaoitens.idPedidoCompra,
		pedido_cotacaoitens.idPedidoCompraItens,
		pedido_cotacaoitens.idCotacaoItens,
		pedido_cotacaoitens.idPedidoCotacao,
		insumos.descricaoInsumo FROM distribuir_os 
		inner join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo 
		inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		inner join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		left join pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		left join pedido_cotacao on pedido_cotacao.idPedidoCotacao = pedido_cotacaoitens.idPedidoCotacao 
		left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
		left join pedido_compras on pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra    
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores 
		join os on os.idOs = distribuir_os.idOs 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		join produtos on produtos.idProdutos = orcamento_item.idProdutos
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro where 1 = 1 and distribuir_os.responsabilidadePCP = 1";
		return $this->db->query($query)->result();
	 }
	 public function getPermissaoCompraByIdPermissao($id){
		$query = "SELECT * FROM permissao_compra where idPermissao = $id";
		return $this->db->query($query)->row();
	}	 

	public function getComprasSolicitadasPcp(){
		$query = "SELECT distribuir_os.*,insumos.*,usuarios.*,distribuir_os.quantidade*(select pedido_comprasitens.valor_unitario from distribuir_os as dist2 join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = dist2.idDistribuir join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens where dist2.idStatuscompras = 5 and pedido_comprasitens.valor_unitario > 0 and distribuir_os.idInsumos = dist2.idInsumos order by dist2.idDistribuir desc limit 1) as valor_estimado FROM distribuir_os join insumos on insumos.idInsumos = distribuir_os.idInsumos join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro where distribuir_os.idStatuscompras = 1 and distribuir_os.idOs not in (10,11,12) order by distribuir_os.data_cadastro asc";
		return $this->db->query($query)->result();
	}
	public function itensautorizacaocompra2($min,$max){
		if(!empty($max)){
			$where = " and soma between '".$min."' and '".$max."'";
		}else{
			$where = " and soma >= '".$min."'";
		}
		$query = "select sum(pedido_comprasitens.valor_unitario* 
		pedido_comprasitens.quantidade) as soma,
		GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
		GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
		GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
		GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
		GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
		GROUP_CONCAT(distribuir_os.aprovacaoSUP SEPARATOR ';') as aprovacaoSUP2,
		GROUP_CONCAT(distribuir_os.aprovacaoDir SEPARATOR ';') as aprovacaoDir,
		status_cond_pgt.nome_status_cond_pgt as nomePgto,
		pedido_comprasitens.cod_pgto as condPgto,
		pedido_comprasitens.idPedidoCompra,
		fornecedores.nomeFornecedor,
		distribuir_os.data_cadastro, 
		distribuir_os.aprovacaoSUP,
		pedido_comprasitens.data_autorizacao,
		pedido_comprasitens.autorizadoCompra
		from distribuir_os 
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
		left join status_cond_pgt on status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.idCondPgto
			where ((distribuir_os.idStatuscompras = 10 or distribuir_os.idStatuscompras = 12 or distribuir_os.idStatuscompras = 13 or distribuir_os.idStatuscompras = 16) or distribuir_os.aprovacaoSUP = 1)
			and (pedido_comprasitens.valor_unitario is not null 
			and pedido_comprasitens.valor_unitario != '' 
			and pedido_comprasitens.valor_unitario != 0) 
			GROUP by pedido_comprasitens.idPedidoCompra having aprovacaoDir not like \"%0%\" and aprovacaoPCP not like \"%0%\" and aprovacaoSUP2  like \"%0%\" $where";
		return $this->db->query($query)->result();
	}
	public function itensautorizacaocompra2_where($min,$max,$where2){
		if(!empty($max)){
			$where = " and soma between '".$min."' and '".$max."'";
		}else{
			$where = " and soma >= '".$min."'";
		}
		$query = "select sum(pedido_comprasitens.valor_unitario* 
		pedido_comprasitens.quantidade) as soma,
		GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
		GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
		GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
		GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
		GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
		GROUP_CONCAT(distribuir_os.aprovacaoSUP SEPARATOR ';') as aprovacaoSUP2,
		GROUP_CONCAT(distribuir_os.aprovacaoDir SEPARATOR ';') as aprovacaoDir,
		status_cond_pgt.nome_status_cond_pgt as nomePgto,
		pedido_comprasitens.cod_pgto as condPgto,
		pedido_comprasitens.idPedidoCompra,
		fornecedores.nomeFornecedor,
		distribuir_os.data_cadastro, 
		distribuir_os.aprovacaoSUP,
		pedido_comprasitens.data_autorizacao,
		pedido_comprasitens.autorizadoCompra
		from distribuir_os 
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
		left join status_cond_pgt on status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.idCondPgto
			where ((distribuir_os.idStatuscompras = 10 or distribuir_os.idStatuscompras = 12 or distribuir_os.idStatuscompras = 13 or distribuir_os.idStatuscompras = 16) or distribuir_os.aprovacaoSUP = 1)
			and (pedido_comprasitens.valor_unitario is not null 
			and pedido_comprasitens.valor_unitario != '' 
			and pedido_comprasitens.valor_unitario != 0) $where2
			GROUP by pedido_comprasitens.idPedidoCompra having aprovacaoDir not like \"%0%\" and aprovacaoPCP not like \"%0%\" and aprovacaoSUP2  like \"%0%\" $where";
		return $this->db->query($query)->result();
	}
	public function itensautorizacaocompra4($min,$max,$where2 = ''){
		if(!empty($max)){
			$where = " and soma between '".$min."' and '".$max."'";
		}else{
			$where = " and soma >= '".$min."'";
		}
		$query = "select sum(pedido_comprasitens.valor_unitario* 
			pedido_comprasitens.quantidade) as soma,
			GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
			GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
			GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
			GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
			GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
			GROUP_CONCAT(distribuir_os.aprovacaoDir SEPARATOR ';') as aprovacaoDir2,
			status_cond_pgt.nome_status_cond_pgt as nomePgto,
			pedido_comprasitens.cod_pgto as condPgto,
			pedido_comprasitens.idPedidoCompra,
			fornecedores.nomeFornecedor,
			distribuir_os.data_cadastro, 
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			pedido_comprasitens.data_autorizacao,
			pedido_comprasitens.autorizadoCompra
			from distribuir_os 
			join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
			join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos
			join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
			join os on os.idOs = distribuir_os.idOs
			left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
			left join status_cond_pgt on status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.idCondPgto
			where ((distribuir_os.idStatuscompras = 10 or distribuir_os.idStatuscompras = 12 or distribuir_os.idStatuscompras = 13 or distribuir_os.idStatuscompras = 16) or distribuir_os.aprovacaoDir = 1)
			and (pedido_comprasitens.valor_unitario is not null 
			and pedido_comprasitens.valor_unitario != '' 
			and pedido_comprasitens.valor_unitario != 0) 
			and os.unid_execucao in (1,2,4) $where2
			GROUP by pedido_comprasitens.idPedidoCompra having aprovacaoPCP not like \"%0%\" and aprovacaoDir2 like \"%0%\" $where";
		return $this->db->query($query)->result();
	}
	public function itensautorizacaocompra4_2($min,$max,$where2 = ''){
		if(!empty($max)){
			$where = " and soma between '".$min."' and '".$max."'";
		}else{
			$where = " and soma >= '".$min."'";
		}
		$query = "select sum(pedido_comprasitens.valor_unitario* 
			pedido_comprasitens.quantidade) as soma,
			GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
			GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
			GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
			GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
			GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
			GROUP_CONCAT(distribuir_os.aprovacaoDir SEPARATOR ';') as aprovacaoDir2,
			status_cond_pgt.nome_status_cond_pgt as nomePgto,
			pedido_comprasitens.cod_pgto as condPgto,
			pedido_comprasitens.idPedidoCompra,
			fornecedores.nomeFornecedor,
			distribuir_os.data_cadastro, 
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			pedido_comprasitens.data_autorizacao,
			pedido_comprasitens.autorizadoCompra
			from distribuir_os 
			join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
			join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos
			join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
			join os on os.idOs  = distribuir_os.idOs
			left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
			left join status_cond_pgt on status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.idCondPgto
			where ((distribuir_os.idStatuscompras = 10 or distribuir_os.idStatuscompras = 12 or distribuir_os.idStatuscompras = 13 or distribuir_os.idStatuscompras = 16) or distribuir_os.aprovacaoDir = 1)
			and (pedido_comprasitens.valor_unitario is not null 
			and pedido_comprasitens.valor_unitario != '' 
			and pedido_comprasitens.valor_unitario != 0) 
			and (os.unid_execucao in (3) or distribuir_os.idOs in (2,11)) $where2
			GROUP by pedido_comprasitens.idPedidoCompra having aprovacaoPCP not like \"%0%\" and aprovacaoDir2 like \"%0%\" $where";
		return $this->db->query($query)->result();
	}
	public function itensautorizacaocompra4_3($min,$max,$where2 = ''){
		if(!empty($max)){
			$where = " and soma between '".$min."' and '".$max."'";
		}else{
			$where = " and soma >= '".$min."'";
		}
		$query = "select sum(pedido_comprasitens.valor_unitario* 
			pedido_comprasitens.quantidade) as soma,
			GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
			GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
			GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
			GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
			GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
			GROUP_CONCAT(distribuir_os.aprovacaoDir SEPARATOR ';') as aprovacaoDir2,
			status_cond_pgt.nome_status_cond_pgt as nomePgto,
			pedido_comprasitens.cod_pgto as condPgto,
			pedido_comprasitens.idPedidoCompra,
			fornecedores.nomeFornecedor,
			distribuir_os.data_cadastro, 
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			pedido_comprasitens.data_autorizacao,
			pedido_comprasitens.autorizadoCompra
			from distribuir_os 
			join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
			join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos
			join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
			join os on os.idOs  = distribuir_os.idOs
			left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
			left join status_cond_pgt on status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.idCondPgto
			where ((distribuir_os.idStatuscompras = 10 or distribuir_os.idStatuscompras = 12 or distribuir_os.idStatuscompras = 13 or distribuir_os.idStatuscompras = 16) or distribuir_os.aprovacaoDir = 1)
			and (pedido_comprasitens.valor_unitario is not null 
			and pedido_comprasitens.valor_unitario != '' 
			and pedido_comprasitens.valor_unitario != 0) 
			and (os.unid_execucao in (5) or distribuir_os.idOs in (6,13)) $where2
			GROUP by pedido_comprasitens.idPedidoCompra having aprovacaoPCP not like \"%0%\" and aprovacaoDir2 like \"%0%\" $where";
		return $this->db->query($query)->result();
	}
	public function itensautorizacaocompra4_4($min,$max,$where2 = ''){
		if(!empty($max)){
			$where = " and soma between '".$min."' and '".$max."'";
		}else{
			$where = " and soma >= '".$min."'";
		}
		$query = "select sum(pedido_comprasitens.valor_unitario* 
			pedido_comprasitens.quantidade) as soma,
			GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
			GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
			GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
			GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
			GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
			GROUP_CONCAT(distribuir_os.aprovacaoDir SEPARATOR ';') as aprovacaoDir2,
			status_cond_pgt.nome_status_cond_pgt as nomePgto,
			pedido_comprasitens.cod_pgto as condPgto,
			pedido_comprasitens.idPedidoCompra,
			fornecedores.nomeFornecedor,
			distribuir_os.data_cadastro, 
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			pedido_comprasitens.data_autorizacao,
			pedido_comprasitens.autorizadoCompra
			from distribuir_os 
			join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
			join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos
			join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
			join os on os.idOs  = distribuir_os.idOs
			left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
			left join status_cond_pgt on status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.idCondPgto
			where ((distribuir_os.idStatuscompras = 10 or distribuir_os.idStatuscompras = 12 or distribuir_os.idStatuscompras = 13 or distribuir_os.idStatuscompras = 16) or distribuir_os.aprovacaoDir = 1)
			and (pedido_comprasitens.valor_unitario is not null 
			and pedido_comprasitens.valor_unitario != '' 
			and pedido_comprasitens.valor_unitario != 0) 
			and os.unid_execucao in (6,1)  $where2
			GROUP by pedido_comprasitens.idPedidoCompra having aprovacaoPCP not like \"%0%\" and aprovacaoDir2 like \"%0%\" $where";
		return $this->db->query($query)->result();
	}
	public function itensautorizacaocompra4Admin($min,$max,$where2 = ''){
		if(!empty($max)){
			$where = " and soma between '".$min."' and '".$max."'";
		}else{
			$where = " and soma >= '".$min."'";
		}
		$query = "select sum(pedido_comprasitens.valor_unitario* 
			pedido_comprasitens.quantidade) as soma,
			GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
			GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
			GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
			GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
			GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
			GROUP_CONCAT(distribuir_os.aprovacaoDir SEPARATOR ';') as aprovacaoDir2,
			status_cond_pgt.nome_status_cond_pgt as nomePgto,
			pedido_comprasitens.cod_pgto as condPgto,
			pedido_comprasitens.idPedidoCompra,
			fornecedores.nomeFornecedor,
			distribuir_os.data_cadastro, 
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			pedido_comprasitens.data_autorizacao,
			pedido_comprasitens.autorizadoCompra
			from distribuir_os 
			join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
			join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos
			join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
			left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
			left join status_cond_pgt on status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.idCondPgto
			where ((distribuir_os.idStatuscompras = 10 or distribuir_os.idStatuscompras = 12 or distribuir_os.idStatuscompras = 13 or distribuir_os.idStatuscompras = 16) or distribuir_os.aprovacaoDir = 1)
			and (pedido_comprasitens.valor_unitario is not null 
			and pedido_comprasitens.valor_unitario != '' 
			and pedido_comprasitens.valor_unitario != 0) $where2
			GROUP by pedido_comprasitens.idPedidoCompra having aprovacaoPCP not like \"%0%\" and aprovacaoDir2 like \"%0%\" $where";
		return $this->db->query($query)->result();
	}
	public function itensautorizacaocompra3($min,$max,$where2 = ''){
		if(!empty($max)){
			$where = " and soma between '".$min."' and '".$max."'";
		}else{
			$where = " and soma >= '".$min."'";
		}
		$query = "select sum(pedido_comprasitens.valor_unitario* 
		pedido_comprasitens.quantidade) as soma,
		GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
		GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
		GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
		GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
		GROUP_CONCAT(distribuir_os.aprovacaoSUP SEPARATOR ';') as aprovacaoSUP,
		GROUP_CONCAT(distribuir_os.aprovacaoDir SEPARATOR ';') as aprovacaoDir,
		GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
		GROUP_CONCAT(pedido_comprasitens.autorizadoCompra SEPARATOR ';') as aprovacaoFIN,
		status_cond_pgt.nome_status_cond_pgt as nomePgto,
		pedido_comprasitens.cod_pgto as condPgto,
		pedido_comprasitens.idPedidoCompra,
		fornecedores.nomeFornecedor,
		distribuir_os.data_cadastro, 
		pedido_comprasitens.data_autorizacao,
		pedido_comprasitens.autorizadoCompra
		from distribuir_os 
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
		left join status_cond_pgt on status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.idCondPgto
		where (distribuir_os.idStatuscompras = 10 or distribuir_os.idStatuscompras = 12 or distribuir_os.idStatuscompras = 13 or distribuir_os.idStatuscompras = 14)
		and (pedido_comprasitens.valor_unitario is not null
		and pedido_comprasitens.valor_unitario != ''
		and pedido_comprasitens.valor_unitario != 0) $where2
		GROUP by pedido_comprasitens.idPedidoCompra HAVING (aprovacaoSUP not like \"%0%\" and aprovacaoDir not like \"%0%\" and aprovacaoPCP not like \"%0%\") and aprovacaoFIN like \"%0%\" $where";
			
		$this->db->simple_query('SET SESSION group_concat_max_len=50000');
		return $this->db->query($query)->result();
	}
	public function getComprasParaAprovarPcpCopy(){
		$query = "SELECT distribuir_os.idOs,
		os.qtd_os,
		orcamento_item.descricao_item,
		GROUP_CONCAT(if(distribuir_os.quantidade is not null,distribuir_os.quantidade,'') ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as qtd,
		GROUP_CONCAT(if(distribuir_os.dimensoes is not null,distribuir_os.dimensoes,'' ) ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as dimensoes,
		GROUP_CONCAT(if(distribuir_os.idDistribuir is not null,distribuir_os.idDistribuir,'') ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as idDistribuir, 
		GROUP_CONCAT(if(distribuir_os.data_cadastro is not null,distribuir_os.data_cadastro,'') ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as data_cadastro,
		GROUP_CONCAT(if(distribuir_os.aprovacaoPCP is not null,distribuir_os.aprovacaoPCP,'') ORDER BY distribuir_os.aprovacaoPCP asc SEPARATOR '?/') as aprovacaoPCP,
		GROUP_CONCAT(if(distribuir_os.data_autorizacaoPCP is not null,distribuir_os.data_autorizacaoPCP,'') ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as data_autorizacaoPCP,
		GROUP_CONCAT(if(distribuir_os.idUserAprovacao is not null,distribuir_os.idUserAprovacao,'') ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as idUserAprovacao,
		GROUP_CONCAT(if(user2.nome is not null,user2.nome,'')ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as nomeUserPCP,
        GROUP_CONCAT(if(pedido_comprasitens.valor_unitario is not null,pedido_comprasitens.valor_unitario,'') ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as valor_unitario,
		GROUP_CONCAT(if(insumos.descricaoInsumo is not null,insumos.descricaoInsumo,'') ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as descricaoInsumo,
		GROUP_CONCAT(if(usuarios.nome is not null,usuarios.nome,'') ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as nomeUsuario,
        GROUP_CONCAT(if(statuscompras.nomeStatus is not null,statuscompras.nomeStatus,'') ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as nomeStatus,
        GROUP_CONCAT(if(statuscompras.etapa is not null,statuscompras.etapa,'') ORDER BY distribuir_os.aprovacaoPCP SEPARATOR '?/') as etapaStatus
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where  distribuir_os.idOs not in (10,11,12,13)
		group by distribuir_os.idOs having aprovacaoPCP like '%0%' and etapaStatus like '%3%'
		order by distribuir_os.idOs asc";
		$this->db->simple_query('SET SESSION group_concat_max_len=50000');
		return $this->db->query($query)->result();
	}
	public function getComprasParaAprovarPcp_old(){
		$query = "SELECT distribuir_os.idOs,
			os.qtd_os,
			sum(pedido_comprasitens.quantidade*pedido_comprasitens.valor_unitario) as valorTotal,
			orcamento_item.descricao_item		
			FROM distribuir_os join os on os.idOs = distribuir_os.idOs 
			join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
			join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
         	join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
			where  distribuir_os.idOs not in (10,11,12,13) and statuscompras.etapa = 3 and distribuir_os.aprovacaoPCP = 0 and os.unid_execucao in (1,2,4)
			group by distribuir_os.idOs 
			order by distribuir_os.idOs asc";
		return $this->db->query($query)->result();
	}
	public function getComprasParaAprovarPcp(){
		$query = "SELECT os.idOs, (select sum(distribuir_os.quantidade*pedido_comprasitens.valor_unitario) FROM distribuir_os join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens and pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras where os.idOs = distribuir_os.idOs and statuscompras.etapa = 3 and distribuir_os.aprovacaoPCP = 0 and os.unid_execucao in (1,2,4)) as valorTotal,
		os.qtd_os,			
        status_os.nomeStatusOs,
		orcamento_item.descricao_item		
		FROM os 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item
        join status_os on status_os.idStatusOs = os.idStatusOs
		where  os.idOs not in (10,11,12,13) 
		group by os.idOs 
		having valorTotal is not null
		order by os.idOs asc";
		return $this->db->query($query)->result();
	}
	public function getComprasParaAprovarPcpAdmin_old(){
		$query = "SELECT distribuir_os.idOs,
			os.qtd_os,
			sum(pedido_comprasitens.quantidade*pedido_comprasitens.valor_unitario) as valorTotal,
			orcamento_item.descricao_item		
			FROM distribuir_os join os on os.idOs = distribuir_os.idOs 
			join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
			join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
         	join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
			where  distribuir_os.idOs not in (10,11,12,13) and statuscompras.etapa = 3 and distribuir_os.aprovacaoPCP = 0 
			group by distribuir_os.idOs 
			order by distribuir_os.idOs asc";
		return $this->db->query($query)->result();
	}
	public function getComprasParaAprovarPcpAdmin(){
		$query = "SELECT os.idOs, (select sum(distribuir_os.quantidade*pedido_comprasitens.valor_unitario) FROM distribuir_os join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens and pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras where os.idOs = distribuir_os.idOs and statuscompras.etapa = 3 and distribuir_os.aprovacaoPCP = 0) as valorTotal,
		os.qtd_os,			
        status_os.nomeStatusOs,
		orcamento_item.descricao_item		
		FROM os 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item
        join status_os on status_os.idStatusOs = os.idStatusOs
			where  os.idOs not in (10,11,12,13) 
			group by os.idOs 
			having valorTotal is not null
			order by os.idOs asc";
		return $this->db->query($query)->result();
	}
	public function getComprasParaAprovarPcp2_old(){
		$query = "SELECT distribuir_os.idOs,
			os.qtd_os,
			sum(pedido_comprasitens.quantidade*pedido_comprasitens.valor_unitario) as valorTotal,
			orcamento_item.descricao_item		
			FROM distribuir_os join os on os.idOs = distribuir_os.idOs 
			join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
			join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
         	join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
			where  distribuir_os.idOs not in (10,11,12,13) and statuscompras.etapa = 3 and distribuir_os.aprovacaoPCP = 0 and os.unid_execucao in (3)
			group by distribuir_os.idOs 
			order by distribuir_os.idOs asc";
		return $this->db->query($query)->result();
	}
	public function getComprasParaAprovarPcp2(){
		$query = "SELECT os.idOs, (select sum(distribuir_os.quantidade*pedido_comprasitens.valor_unitario) FROM distribuir_os join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens and pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras where os.idOs = distribuir_os.idOs and statuscompras.etapa = 3 and distribuir_os.aprovacaoPCP = 0 and os.unid_execucao in (3)) as valorTotal,
		os.qtd_os,			
        status_os.nomeStatusOs,
		orcamento_item.descricao_item		
		FROM os 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item
        join status_os on status_os.idStatusOs = os.idStatusOs
		where  os.idOs not in (10,11,12,13) 
		group by os.idOs 
		having valorTotal is not null
		order by os.idOs asc";
		return $this->db->query($query)->result();
	}
	public function getComprasParaAprovarPcp3(){
		$query = "SELECT os.idOs, (select sum(distribuir_os.quantidade*pedido_comprasitens.valor_unitario) FROM distribuir_os join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens and pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras where os.idOs = distribuir_os.idOs and statuscompras.etapa = 3 and distribuir_os.aprovacaoPCP = 0 and os.unid_execucao in (5)) as valorTotal,
		os.qtd_os,			
        status_os.nomeStatusOs,
		orcamento_item.descricao_item		
		FROM os 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item
        join status_os on status_os.idStatusOs = os.idStatusOs
		where  os.idOs not in (10,11,12,13) 
		group by os.idOs 
		having valorTotal is not null
		order by os.idOs asc";
		return $this->db->query($query)->result();
	}
	public function getComprasParaAprovarPcp4(){
		$query = "SELECT os.idOs, (select sum(distribuir_os.quantidade*pedido_comprasitens.valor_unitario) FROM distribuir_os join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens and pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras where os.idOs = distribuir_os.idOs and statuscompras.etapa = 3 and distribuir_os.aprovacaoPCP = 0 and os.unid_execucao in (6,1)) as valorTotal,
		os.qtd_os,			
        status_os.nomeStatusOs,
		orcamento_item.descricao_item		
		FROM os 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item
        join status_os on status_os.idStatusOs = os.idStatusOs
		where  os.idOs not in (10,11,12,13) and os.unid_execucao in (6,1)
		group by os.idOs 
		having valorTotal is not null
		order by os.idOs asc";
		return $this->db->query($query)->result();
	}
	public function getHistAprovacaoPCP(){
		$query = "SELECT distribuir_os.idOs,
		os.qtd_os,
		orcamento_item.descricao_item,
		GROUP_CONCAT(if(distribuir_os.quantidade is not null,distribuir_os.quantidade,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as qtd,
		GROUP_CONCAT(if(distribuir_os.dimensoes is not null,distribuir_os.dimensoes,'' ) ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as dimensoes,
		GROUP_CONCAT(if(distribuir_os.idDistribuir is not null,distribuir_os.idDistribuir,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as idDistribuir, 
		GROUP_CONCAT(if(distribuir_os.data_cadastro is not null,distribuir_os.data_cadastro,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as data_cadastro,
		GROUP_CONCAT(if(distribuir_os.aprovacaoPCP is not null,distribuir_os.aprovacaoPCP,'') ORDER BY distribuir_os.data_autorizacaoPCP desc  SEPARATOR '?/') as aprovacaoPCP,
		GROUP_CONCAT(if(distribuir_os.data_autorizacaoPCP is not null,distribuir_os.data_autorizacaoPCP,'') ORDER BY distribuir_os.data_autorizacaoPCP desc  SEPARATOR '?/') as data_autorizacaoPCP,
		GROUP_CONCAT(if(distribuir_os.idUserAprovacao is not null,distribuir_os.idUserAprovacao,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as idUserAprovacao,
		GROUP_CONCAT(if(user2.nome is not null,user2.nome,'')ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeUserPCP,
        GROUP_CONCAT(if(pedido_comprasitens.valor_unitario is not null,pedido_comprasitens.valor_unitario,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as valor_unitario,
		GROUP_CONCAT(if(insumos.descricaoInsumo is not null,insumos.descricaoInsumo,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as descricaoInsumo,
		GROUP_CONCAT(if(usuarios.nome is not null,usuarios.nome,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeUsuario,
        GROUP_CONCAT(if(statuscompras.nomeStatus is not null,statuscompras.nomeStatus,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeStatus,
        GROUP_CONCAT(if(statuscompras.etapa is not null,statuscompras.etapa,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as etapaStatus
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where  distribuir_os.idOs not in (10,11,12,13,1,2,3,6) and distribuir_os.data_autorizacaoPCP is not null and os.unid_execucao in (1,2,4)
		group by distribuir_os.idOs 
		order by distribuir_os.data_autorizacaoPCP desc limit 50";
		$this->db->simple_query('SET SESSION group_concat_max_len=50000');
		return $this->db->query($query)->result();
	}
	public function getHistAprovacaoPCPAdmin(){
		$query = "SELECT distribuir_os.idOs,
		os.qtd_os,
		orcamento_item.descricao_item,
		GROUP_CONCAT(if(distribuir_os.quantidade is not null,distribuir_os.quantidade,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as qtd,
		GROUP_CONCAT(if(distribuir_os.dimensoes is not null,distribuir_os.dimensoes,'' ) ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as dimensoes,
		GROUP_CONCAT(if(distribuir_os.idDistribuir is not null,distribuir_os.idDistribuir,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as idDistribuir, 
		GROUP_CONCAT(if(distribuir_os.data_cadastro is not null,distribuir_os.data_cadastro,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as data_cadastro,
		GROUP_CONCAT(if(distribuir_os.aprovacaoPCP is not null,distribuir_os.aprovacaoPCP,'') ORDER BY distribuir_os.data_autorizacaoPCP desc  SEPARATOR '?/') as aprovacaoPCP,
		GROUP_CONCAT(if(distribuir_os.data_autorizacaoPCP is not null,distribuir_os.data_autorizacaoPCP,'') ORDER BY distribuir_os.data_autorizacaoPCP desc  SEPARATOR '?/') as data_autorizacaoPCP,
		GROUP_CONCAT(if(distribuir_os.idUserAprovacao is not null,distribuir_os.idUserAprovacao,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as idUserAprovacao,
		GROUP_CONCAT(if(user2.nome is not null,user2.nome,'')ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeUserPCP,
        GROUP_CONCAT(if(pedido_comprasitens.valor_unitario is not null,pedido_comprasitens.valor_unitario,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as valor_unitario,
		GROUP_CONCAT(if(insumos.descricaoInsumo is not null,insumos.descricaoInsumo,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as descricaoInsumo,
		GROUP_CONCAT(if(usuarios.nome is not null,usuarios.nome,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeUsuario,
        GROUP_CONCAT(if(statuscompras.nomeStatus is not null,statuscompras.nomeStatus,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeStatus,
        GROUP_CONCAT(if(statuscompras.etapa is not null,statuscompras.etapa,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as etapaStatus,
		distribuir_os.data_autorizacaoPCP as data_autorizacaoPCP2
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where  distribuir_os.idOs not in (10,11,12,13,1,2,3,6) and distribuir_os.data_autorizacaoPCP is not null
		group by distribuir_os.idOs 
		order by data_autorizacaoPCP2 desc limit 50";
		$this->db->simple_query('SET SESSION group_concat_max_len=50000');
		return $this->db->query($query)->result();
	}
	public function getHistAprovacaoPCP2(){
		$query = "SELECT distribuir_os.idOs,
		os.qtd_os,
		orcamento_item.descricao_item,
		GROUP_CONCAT(if(distribuir_os.quantidade is not null,distribuir_os.quantidade,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as qtd,
		GROUP_CONCAT(if(distribuir_os.dimensoes is not null,distribuir_os.dimensoes,'' ) ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as dimensoes,
		GROUP_CONCAT(if(distribuir_os.idDistribuir is not null,distribuir_os.idDistribuir,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as idDistribuir, 
		GROUP_CONCAT(if(distribuir_os.data_cadastro is not null,distribuir_os.data_cadastro,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as data_cadastro,
		GROUP_CONCAT(if(distribuir_os.aprovacaoPCP is not null,distribuir_os.aprovacaoPCP,'') ORDER BY distribuir_os.data_autorizacaoPCP desc  SEPARATOR '?/') as aprovacaoPCP,
		GROUP_CONCAT(if(distribuir_os.data_autorizacaoPCP is not null,distribuir_os.data_autorizacaoPCP,'') ORDER BY distribuir_os.data_autorizacaoPCP desc  SEPARATOR '?/') as data_autorizacaoPCP,
		GROUP_CONCAT(if(distribuir_os.idUserAprovacao is not null,distribuir_os.idUserAprovacao,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as idUserAprovacao,
		GROUP_CONCAT(if(user2.nome is not null,user2.nome,'')ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeUserPCP,
        GROUP_CONCAT(if(pedido_comprasitens.valor_unitario is not null,pedido_comprasitens.valor_unitario,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as valor_unitario,
		GROUP_CONCAT(if(insumos.descricaoInsumo is not null,insumos.descricaoInsumo,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as descricaoInsumo,
		GROUP_CONCAT(if(usuarios.nome is not null,usuarios.nome,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeUsuario,
        GROUP_CONCAT(if(statuscompras.nomeStatus is not null,statuscompras.nomeStatus,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeStatus,
        GROUP_CONCAT(if(statuscompras.etapa is not null,statuscompras.etapa,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as etapaStatus
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where  distribuir_os.idOs not in (10,11,12,13,1,2,3,6) and distribuir_os.data_autorizacaoPCP is not null and os.unid_execucao in (3)
		group by distribuir_os.idOs 
		order by distribuir_os.data_autorizacaoPCP desc limit 50";
		$this->db->simple_query('SET SESSION group_concat_max_len=50000');
		return $this->db->query($query)->result();
	}
	public function getHistAprovacaoPCP3(){
		$query = "SELECT distribuir_os.idOs,
		os.qtd_os,
		orcamento_item.descricao_item,
		GROUP_CONCAT(if(distribuir_os.quantidade is not null,distribuir_os.quantidade,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as qtd,
		GROUP_CONCAT(if(distribuir_os.dimensoes is not null,distribuir_os.dimensoes,'' ) ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as dimensoes,
		GROUP_CONCAT(if(distribuir_os.idDistribuir is not null,distribuir_os.idDistribuir,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as idDistribuir, 
		GROUP_CONCAT(if(distribuir_os.data_cadastro is not null,distribuir_os.data_cadastro,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as data_cadastro,
		GROUP_CONCAT(if(distribuir_os.aprovacaoPCP is not null,distribuir_os.aprovacaoPCP,'') ORDER BY distribuir_os.data_autorizacaoPCP desc  SEPARATOR '?/') as aprovacaoPCP,
		GROUP_CONCAT(if(distribuir_os.data_autorizacaoPCP is not null,distribuir_os.data_autorizacaoPCP,'') ORDER BY distribuir_os.data_autorizacaoPCP desc  SEPARATOR '?/') as data_autorizacaoPCP,
		GROUP_CONCAT(if(distribuir_os.idUserAprovacao is not null,distribuir_os.idUserAprovacao,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as idUserAprovacao,
		GROUP_CONCAT(if(user2.nome is not null,user2.nome,'')ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeUserPCP,
        GROUP_CONCAT(if(pedido_comprasitens.valor_unitario is not null,pedido_comprasitens.valor_unitario,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as valor_unitario,
		GROUP_CONCAT(if(insumos.descricaoInsumo is not null,insumos.descricaoInsumo,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as descricaoInsumo,
		GROUP_CONCAT(if(usuarios.nome is not null,usuarios.nome,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeUsuario,
        GROUP_CONCAT(if(statuscompras.nomeStatus is not null,statuscompras.nomeStatus,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeStatus,
        GROUP_CONCAT(if(statuscompras.etapa is not null,statuscompras.etapa,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as etapaStatus
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where  distribuir_os.idOs not in (10,11,12,13,1,2,3,6) and distribuir_os.data_autorizacaoPCP is not null and os.unid_execucao in (5)
		group by distribuir_os.idOs 
		order by distribuir_os.data_autorizacaoPCP desc limit 50";
		$this->db->simple_query('SET SESSION group_concat_max_len=50000');
		return $this->db->query($query)->result();
	}
	public function getHistAprovacaoPCP4(){
		$query = "SELECT distribuir_os.idOs,
		os.qtd_os,
		orcamento_item.descricao_item,
		GROUP_CONCAT(if(distribuir_os.quantidade is not null,distribuir_os.quantidade,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as qtd,
		GROUP_CONCAT(if(distribuir_os.dimensoes is not null,distribuir_os.dimensoes,'' ) ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as dimensoes,
		GROUP_CONCAT(if(distribuir_os.idDistribuir is not null,distribuir_os.idDistribuir,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as idDistribuir, 
		GROUP_CONCAT(if(distribuir_os.data_cadastro is not null,distribuir_os.data_cadastro,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as data_cadastro,
		GROUP_CONCAT(if(distribuir_os.aprovacaoPCP is not null,distribuir_os.aprovacaoPCP,'') ORDER BY distribuir_os.data_autorizacaoPCP desc  SEPARATOR '?/') as aprovacaoPCP,
		GROUP_CONCAT(if(distribuir_os.data_autorizacaoPCP is not null,distribuir_os.data_autorizacaoPCP,'') ORDER BY distribuir_os.data_autorizacaoPCP desc  SEPARATOR '?/') as data_autorizacaoPCP,
		GROUP_CONCAT(if(distribuir_os.idUserAprovacao is not null,distribuir_os.idUserAprovacao,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as idUserAprovacao,
		GROUP_CONCAT(if(user2.nome is not null,user2.nome,'')ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeUserPCP,
        GROUP_CONCAT(if(pedido_comprasitens.valor_unitario is not null,pedido_comprasitens.valor_unitario,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as valor_unitario,
		GROUP_CONCAT(if(insumos.descricaoInsumo is not null,insumos.descricaoInsumo,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as descricaoInsumo,
		GROUP_CONCAT(if(usuarios.nome is not null,usuarios.nome,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeUsuario,
        GROUP_CONCAT(if(statuscompras.nomeStatus is not null,statuscompras.nomeStatus,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as nomeStatus,
        GROUP_CONCAT(if(statuscompras.etapa is not null,statuscompras.etapa,'') ORDER BY distribuir_os.data_autorizacaoPCP desc SEPARATOR '?/') as etapaStatus
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where  distribuir_os.idOs not in (10,11,12,13,1,2,3,6) and distribuir_os.data_autorizacaoPCP is not null and os.unid_execucao in (6)
		group by distribuir_os.idOs 
		order by distribuir_os.data_autorizacaoPCP desc limit 50";
		$this->db->simple_query('SET SESSION group_concat_max_len=50000');
		return $this->db->query($query)->result();
	}
	public function getItensByIdos($idOs){
		$query = "SELECT pedido_comprasitens.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.idDistribuir,
		distribuir_os.data_cadastro,
		distribuir_os.aprovacaoPCP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.idUserAprovacao,
		distribuir_os.data_enviadopcp,
		distribuir_os.rejeitado,
		pedido_comprasitens.valor_unitario,
		pedido_comprasitens.idPedidoCompra,
		user2.nome as nomeUserPCP,
        pedido_comprasitens.valor_unitario,
        pedido_comprasitens.previsao_entrega,
		insumos.descricaoInsumo,
		usuarios.nome,
        statuscompras.nomeStatus,
        statuscompras.etapa
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where distribuir_os.idOs = $idOs and os.unid_execucao in (1,2,4) order by distribuir_os.data_enviadopcp desc,distribuir_os.aprovacaoPCP asc";
		return $this->db->query($query)->result();
	}
	public function getItensByIdosAdmin($idOs){
		$query = "SELECT pedido_comprasitens.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.idDistribuir,
		distribuir_os.data_cadastro,
		distribuir_os.aprovacaoPCP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.idUserAprovacao,
		distribuir_os.data_enviadopcp,
			distribuir_os.rejeitado,
		pedido_comprasitens.valor_unitario,
		pedido_comprasitens.idPedidoCompra,
		user2.nome as nomeUserPCP,
        pedido_comprasitens.valor_unitario,
        pedido_comprasitens.previsao_entrega,
		insumos.descricaoInsumo,
		usuarios.nome,
        statuscompras.nomeStatus,
        statuscompras.etapa
		FROM distribuir_os 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where distribuir_os.idOs = $idOs  order by distribuir_os.data_enviadopcp desc,distribuir_os.aprovacaoPCP asc";
		return $this->db->query($query)->result();
	}
	public function getItensByIdos2($idOs){
		$query = "SELECT pedido_comprasitens.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.idDistribuir,
		distribuir_os.data_cadastro,
		distribuir_os.aprovacaoPCP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.idUserAprovacao,
		distribuir_os.data_enviadopcp,
			distribuir_os.rejeitado,
		pedido_comprasitens.valor_unitario,
		pedido_comprasitens.idPedidoCompra,
		user2.nome as nomeUserPCP,
        pedido_comprasitens.valor_unitario,
        pedido_comprasitens.previsao_entrega,
		insumos.descricaoInsumo,
		usuarios.nome,
        statuscompras.nomeStatus,
        statuscompras.etapa
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where distribuir_os.idOs = $idOs and (os.unid_execucao in (3) or distribuir_os.idOs in (2,11)) order by distribuir_os.data_enviadopcp desc,distribuir_os.aprovacaoPCP asc";
		return $this->db->query($query)->result();
	}
	public function getItensByIdos3($idOs){
		$query = "SELECT pedido_comprasitens.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.idDistribuir,
		distribuir_os.data_cadastro,
		distribuir_os.aprovacaoPCP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.idUserAprovacao,
		distribuir_os.data_enviadopcp,
			distribuir_os.rejeitado,
		pedido_comprasitens.valor_unitario,
		pedido_comprasitens.idPedidoCompra,
		user2.nome as nomeUserPCP,
        pedido_comprasitens.valor_unitario,
        pedido_comprasitens.previsao_entrega,
		insumos.descricaoInsumo,
		usuarios.nome,
        statuscompras.nomeStatus,
        statuscompras.etapa
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where distribuir_os.idOs = $idOs and (os.unid_execucao in (5) or distribuir_os.idOs in (2,11)) order by distribuir_os.data_enviadopcp desc,distribuir_os.aprovacaoPCP asc";
		return $this->db->query($query)->result();
	}
	public function getItensByIdos4($idOs){
		$query = "SELECT pedido_comprasitens.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.idDistribuir,
		distribuir_os.data_cadastro,
		distribuir_os.aprovacaoPCP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.idUserAprovacao,
		distribuir_os.data_enviadopcp,
			distribuir_os.rejeitado,
		pedido_comprasitens.valor_unitario,
		pedido_comprasitens.idPedidoCompra,
		user2.nome as nomeUserPCP,
        pedido_comprasitens.valor_unitario,
        pedido_comprasitens.previsao_entrega,
		insumos.descricaoInsumo,
		usuarios.nome,
        statuscompras.nomeStatus,
        statuscompras.etapa
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where distribuir_os.idOs = $idOs and os.unid_execucao in (6,1) order by distribuir_os.data_enviadopcp desc,distribuir_os.aprovacaoPCP asc";
		return $this->db->query($query)->result();
	}
	public function getItensByIdosLimited($idOs){
		$query = "SELECT pedido_comprasitens.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.idDistribuir,
		distribuir_os.data_cadastro,
		distribuir_os.aprovacaoPCP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.idUserAprovacao,
		distribuir_os.data_enviadopcp,
			distribuir_os.rejeitado,
		pedido_comprasitens.valor_unitario,
		pedido_comprasitens.idPedidoCompra,
		user2.nome as nomeUserPCP,
        pedido_comprasitens.valor_unitario,
        pedido_comprasitens.previsao_entrega,
		insumos.descricaoInsumo,
		usuarios.nome,
        statuscompras.nomeStatus,
        statuscompras.etapa
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where distribuir_os.idOs = $idOs and distribuir_os.aprovacaoPCP = 0 and os.unid_execucao in (1,2,4) order by distribuir_os.data_enviadopcp desc,distribuir_os.aprovacaoPCP asc";
		return $this->db->query($query)->result();
	}
	public function getItensByIdosLimitedAdmin($idOs){
		$query = "SELECT pedido_comprasitens.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.idDistribuir,
		distribuir_os.data_cadastro,
		distribuir_os.aprovacaoPCP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.idUserAprovacao,
		distribuir_os.data_enviadopcp,
			distribuir_os.rejeitado,
		pedido_comprasitens.valor_unitario,
		pedido_comprasitens.idPedidoCompra,
		user2.nome as nomeUserPCP,
        pedido_comprasitens.valor_unitario,
        pedido_comprasitens.previsao_entrega,
		insumos.descricaoInsumo,
		usuarios.nome,
        statuscompras.nomeStatus,
        statuscompras.etapa
		FROM distribuir_os 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where distribuir_os.idOs = $idOs and distribuir_os.aprovacaoPCP = 0 order by distribuir_os.data_enviadopcp desc,distribuir_os.aprovacaoPCP asc";
		return $this->db->query($query)->result();
	}
	public function getItensByIdosLimited2($idOs){
		$query = "SELECT pedido_comprasitens.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.idDistribuir,
		distribuir_os.data_cadastro,
		distribuir_os.aprovacaoPCP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.idUserAprovacao,
		distribuir_os.data_enviadopcp,
			distribuir_os.rejeitado,
		pedido_comprasitens.valor_unitario,
		pedido_comprasitens.idPedidoCompra,
		user2.nome as nomeUserPCP,
        pedido_comprasitens.valor_unitario,
        pedido_comprasitens.previsao_entrega,
		insumos.descricaoInsumo,
		usuarios.nome,
        statuscompras.nomeStatus,
        statuscompras.etapa
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where distribuir_os.idOs = $idOs and distribuir_os.aprovacaoPCP = 0 and (os.unid_execucao in (3) or distribuir_os.idOs in (2,11)) order by distribuir_os.data_enviadopcp desc,distribuir_os.aprovacaoPCP asc";
		return $this->db->query($query)->result();
	}
	public function getItensByIdosLimited3($idOs){
		$query = "SELECT pedido_comprasitens.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.idDistribuir,
		distribuir_os.data_cadastro,
		distribuir_os.aprovacaoPCP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.idUserAprovacao,
		distribuir_os.data_enviadopcp,
			distribuir_os.rejeitado,
		pedido_comprasitens.valor_unitario,
		pedido_comprasitens.idPedidoCompra,
		user2.nome as nomeUserPCP,
        pedido_comprasitens.valor_unitario,
        pedido_comprasitens.previsao_entrega,
		insumos.descricaoInsumo,
		usuarios.nome,
        statuscompras.nomeStatus,
        statuscompras.etapa
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where distribuir_os.idOs = $idOs and distribuir_os.aprovacaoPCP = 0 and (os.unid_execucao in (5) or distribuir_os.idOs in (2,11)) order by distribuir_os.data_enviadopcp desc,distribuir_os.aprovacaoPCP asc";
		return $this->db->query($query)->result();
	}
	public function getItensByIdosLimited4($idOs){
		$query = "SELECT pedido_comprasitens.quantidade,
		distribuir_os.dimensoes,
		distribuir_os.idDistribuir,
		distribuir_os.data_cadastro,
		distribuir_os.aprovacaoPCP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.idUserAprovacao,
		distribuir_os.data_enviadopcp,
			distribuir_os.rejeitado,
		pedido_comprasitens.valor_unitario,
		pedido_comprasitens.idPedidoCompra,
		user2.nome as nomeUserPCP,
        pedido_comprasitens.valor_unitario,
        pedido_comprasitens.previsao_entrega,
		insumos.descricaoInsumo,
		usuarios.nome,
        statuscompras.nomeStatus,
        statuscompras.etapa
		FROM distribuir_os join os on os.idOs = distribuir_os.idOs
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
        join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro 
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao 
        left join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir
        left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens
		where distribuir_os.idOs = $idOs and distribuir_os.aprovacaoPCP = 0 and os.unid_execucao in (6,1) order by distribuir_os.data_enviadopcp desc,distribuir_os.aprovacaoPCP asc";
		return $this->db->query($query)->result();
	}
	function getByIdOrdemCompra2($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
			distribuir_os.idOs,
			pedido_comprasitens.idPedidoCompraItens,
			pedido_comprasitens.autorizadoCompra,
			pedido_comprasitens.valor_unitario,
			distribuir_os.idDistribuir,
			distribuir_os.comprimento,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			distribuir_os.dimensoes,
			distribuir_os.aprovacaoSUP,
			distribuir_os.rejeitado,
			distribuir_os.data_autorizacaoPCP,
			distribuir_os.data_autorizacaoSUP,
			distribuir_os.data_autorizacaoDir,
			pedido_comprasitens.data_autorizacao,
			unidade_execucao.status_execucao,
			statuscompras.nomeStatus,
			insumos.descricaoInsumo,
			distribuir_os.dimensoes,
			status_os.nomeStatusOs,
			distribuir_os.quantidade,
			usuarios.nome,
			user2.nome as nomeUserPCP,
			user3.nome as nomeUserSUP,
			user4.nome as nomeUserFIN,
			user5.nome as nomeUserDir,
			status_grupo_compra.nomegrupo
			FROM `pedido_compras` 
			join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
			join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
			join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
			join os on os.idOs = distribuir_os.idOs
			join status_os on status_os.idStatusOs = os.idStatusOs
			join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
			join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo
			left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
			left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
			left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
			left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
			left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
			WHERE pedido_compras.idPedidoCompra = $id ";
		return $this->db->query($query)->result();
	}

	function getByIdOrdemCompra3($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
			distribuir_os.idOs,
			pedido_comprasitens.idPedidoCompraItens,
			pedido_comprasitens.autorizadoCompra,
			pedido_comprasitens.valor_unitario,
			distribuir_os.idDistribuir,
			distribuir_os.comprimento,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			distribuir_os.dimensoes,
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			distribuir_os.rejeitado,
			distribuir_os.data_autorizacaoPCP,
			distribuir_os.data_autorizacaoSUP,
			distribuir_os.data_autorizacaoDir,
			pedido_comprasitens.data_autorizacao,
			unidade_execucao.status_execucao,
			statuscompras.nomeStatus,
			insumos.descricaoInsumo,
			distribuir_os.dimensoes,
			status_os.nomeStatusOs,
			distribuir_os.quantidade,
			usuarios.nome,
			user2.nome as nomeUserPCP,
			user3.nome as nomeUserSUP,
			user4.nome as nomeUserFIN,
			user5.nome as nomeUserDir
			FROM `pedido_compras` 
			join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
			join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
			join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
			join os on os.idOs = distribuir_os.idOs
			join status_os on status_os.idStatusOs = os.idStatusOs
			join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
			left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
			left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
			left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
			left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
			left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
			WHERE pedido_compras.idPedidoCompra = $id and os.unid_execucao in (1,2,4) ";
		return $this->db->query($query)->result();
	}

	function getByIdOrdemCompra3_2($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
			distribuir_os.idOs,
			pedido_comprasitens.idPedidoCompraItens,
			pedido_comprasitens.autorizadoCompra,
			pedido_comprasitens.valor_unitario,
			distribuir_os.idDistribuir,
			distribuir_os.comprimento,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			distribuir_os.dimensoes,
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			distribuir_os.rejeitado,
			distribuir_os.data_autorizacaoPCP,
			distribuir_os.data_autorizacaoSUP,
			distribuir_os.data_autorizacaoDir,
			pedido_comprasitens.data_autorizacao,
			unidade_execucao.status_execucao,
			statuscompras.nomeStatus,
			insumos.descricaoInsumo,
			distribuir_os.dimensoes,
			status_os.nomeStatusOs,
			distribuir_os.quantidade,
			usuarios.nome,
			user2.nome as nomeUserPCP,
			user3.nome as nomeUserSUP,
			user4.nome as nomeUserFIN,
			user5.nome as nomeUserDir
			FROM `pedido_compras` 
			join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
			join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
			join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
			join os on os.idOs = distribuir_os.idOs
			join status_os on status_os.idStatusOs = os.idStatusOs
			join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
			left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
			left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
			left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
			left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
			left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
			WHERE pedido_compras.idPedidoCompra = $id and (os.unid_execucao in (3) or distribuir_os.idOs in (2,11))";
		return $this->db->query($query)->result();
	}

	function getByIdOrdemCompra3_3($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
			distribuir_os.idOs,
			pedido_comprasitens.idPedidoCompraItens,
			pedido_comprasitens.autorizadoCompra,
			pedido_comprasitens.valor_unitario,
			distribuir_os.idDistribuir,
			distribuir_os.comprimento,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			distribuir_os.dimensoes,
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			distribuir_os.rejeitado,
			distribuir_os.data_autorizacaoPCP,
			distribuir_os.data_autorizacaoSUP,
			distribuir_os.data_autorizacaoDir,
			pedido_comprasitens.data_autorizacao,
			unidade_execucao.status_execucao,
			statuscompras.nomeStatus,
			insumos.descricaoInsumo,
			distribuir_os.dimensoes,
			status_os.nomeStatusOs,
			distribuir_os.quantidade,
			usuarios.nome,
			user2.nome as nomeUserPCP,
			user3.nome as nomeUserSUP,
			user4.nome as nomeUserFIN,
			user5.nome as nomeUserDir
			FROM `pedido_compras` 
			join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
			join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
			join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
			join os on os.idOs = distribuir_os.idOs
			join status_os on status_os.idStatusOs = os.idStatusOs
			join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
			left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
			left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
			left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
			left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
			left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
			WHERE pedido_compras.idPedidoCompra = $id and (os.unid_execucao in (5) or distribuir_os.idOs in (6,13))";
		return $this->db->query($query)->result();
	}

	function getByIdOrdemCompra3_4($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
			distribuir_os.idOs,
			pedido_comprasitens.idPedidoCompraItens,
			pedido_comprasitens.autorizadoCompra,
			pedido_comprasitens.valor_unitario,
			distribuir_os.idDistribuir,
			distribuir_os.comprimento,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			distribuir_os.dimensoes,
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			distribuir_os.rejeitado,
			distribuir_os.data_autorizacaoPCP,
			distribuir_os.data_autorizacaoSUP,
			distribuir_os.data_autorizacaoDir,
			pedido_comprasitens.data_autorizacao,
			unidade_execucao.status_execucao,
			statuscompras.nomeStatus,
			insumos.descricaoInsumo,
			distribuir_os.dimensoes,
			status_os.nomeStatusOs,
			distribuir_os.quantidade,
			usuarios.nome,
			user2.nome as nomeUserPCP,
			user3.nome as nomeUserSUP,
			user4.nome as nomeUserFIN,
			user5.nome as nomeUserDir
			FROM `pedido_compras` 
			join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
			join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
			join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
			join os on os.idOs = distribuir_os.idOs
			join status_os on status_os.idStatusOs = os.idStatusOs
			join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
			left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
			left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
			left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
			left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
			left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
			WHERE pedido_compras.idPedidoCompra = $id and os.unid_execucao in (6,1)";
		return $this->db->query($query)->result();
	}

	function getByIdOrdemCompra3Admin($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
			distribuir_os.idOs,
			pedido_comprasitens.idPedidoCompraItens,
			pedido_comprasitens.autorizadoCompra,
			pedido_comprasitens.valor_unitario,
			distribuir_os.idDistribuir,
			distribuir_os.comprimento,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			distribuir_os.dimensoes,
			distribuir_os.aprovacaoSUP,
			distribuir_os.aprovacaoDir,
			distribuir_os.rejeitado,
			distribuir_os.data_autorizacaoPCP,
			distribuir_os.data_autorizacaoSUP,
			distribuir_os.data_autorizacaoDir,
			pedido_comprasitens.data_autorizacao,
			unidade_execucao.status_execucao,
			statuscompras.nomeStatus,
			insumos.descricaoInsumo,
			distribuir_os.dimensoes,
			status_os.nomeStatusOs,
			distribuir_os.quantidade,
			usuarios.nome,
			user2.nome as nomeUserPCP,
			user3.nome as nomeUserSUP,
			user4.nome as nomeUserFIN,
			user5.nome as nomeUserDir
			FROM `pedido_compras` 
			join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
			join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
			join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
			join os on os.idOs = distribuir_os.idOs
			join status_os on status_os.idStatusOs = os.idStatusOs
			join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
			left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
			left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
			left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
			left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
			left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
			WHERE pedido_compras.idPedidoCompra = $id";
		return $this->db->query($query)->result();
	}
	
	function getInsumosByIdDistribuir($id){
		$query = "SELECT insumos.idInsumos,distribuir_os.quantidade,distribuir_os.idOs from pedido_comprasitens join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir join insumos on insumos.idInsumos = distribuir_os.idInsumos where distribuir_os.idDistribuir = $id";
		return $this->db->query($query)->row();
	}
	public function getRelatorioPorInsumoEmpresa($idInsumos,$idOs){
        $query = "SELECT insumos.idInsumos, emitente.nome, 
        insumos.descricaoInsumo, 
		emitente.nome,
		emitente.id,
        sum(IF(almo_estoque.idOs is null or almo_estoque.idOs = '',almo_estoque.quantidade,0)) as quantidade_total,
        sum(IF(almo_estoque.idOs = $idOs,almo_estoque.quantidade,0)) as quantidade_reservada
        FROM `almo_estoque` join insumos on insumos.idInsumos = almo_estoque.idProduto 
        join emitente on emitente.id = almo_estoque.idEmitente 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
        where insumos.idInsumos =  $idInsumos
        group by insumos.idInsumos,emitente.id";
        return $this->db->query($query)->result();
    }	
	function getDistribuirByIdComprasItens($id){
		$query = "SELECT distribuir_os.* FROM pedido_comprasitens join pedido_cotacaoitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  where pedido_comprasitens.idPedidoCompraItens = $id";	
		return $this->db->query($query)->row();
	 }
	 
	 function getDistribuirDetails($id){
		$query = "SELECT pedido_comprasitens.idPedidoCompra,pedido_comprasitens.idPedidoCompraItens,pedido_comprasitens.idCotacaoItens, pedido_cotacaoitens.idDistribuir FROM pedido_cotacaoitens join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens and pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens where pedido_cotacaoitens.idDistribuir  = $id";
		return $this->db->query($query)->row();
	 }
	 function getDistribuirDetails2($id){
		$query = "SELECT distribuir_os.idStatuscompras,distribuir_os.aprovacaoPCP,distribuir_os.aprovacaoDir,distribuir_os.aprovacaoSUP,pedido_comprasitens.autorizadoCompra,pedido_comprasitens.idPedidoCompra,pedido_comprasitens.idPedidoCompraItens,pedido_comprasitens.idCotacaoItens, pedido_cotacaoitens.idDistribuir FROM pedido_cotacaoitens join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens and pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir where pedido_cotacaoitens.idDistribuir in ($id)";
		return $this->db->query($query)->result();
	 }
	 function getItensDoPedidoCompra($id){
		$query = "SELECT pedido_comprasitens.*, distribuir_os.idStatuscompras, statuscompras.etapa FROM pedido_compras JOIN pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra JOIN pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras where pedido_compras.idPedidoCompra = $id";
		return $this->db->query($query)->result();
	 }

	 function getPedidoCompraItensByIdDistribuir2($id){
		$query = "SELECT pedido_comprasitens.* FROM pedido_comprasitens join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir where distribuir_os.idDistribuir = $id ";
		return $this->db->query($query)->row();
	 }

	 function getHistoricoAprovacaoFinanceiro(){
		$query = "select sum(pedido_comprasitens.valor_unitario* 
		pedido_comprasitens.quantidade) as soma,
		GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
		GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
		GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
		GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
		GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
		pedido_comprasitens.idPedidoCompra,
		fornecedores.nomeFornecedor,
		distribuir_os.data_cadastro, 
		distribuir_os.aprovacaoSUP,
		pedido_comprasitens.data_autorizacao,
		pedido_comprasitens.autorizadoCompra
		from distribuir_os 
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
		where 
		distribuir_os.aprovacaoSUP = 1
		and distribuir_os.idUserAprovacaoSUP != 51
		and distribuir_os.data_cadastro > '2022-03-25'   GROUP by pedido_comprasitens.idPedidoCompra order by distribuir_os.data_autorizacaoSUP desc limit 20";
		return $this->db->query($query)->result();
	 }
	 
	 function getByIdOrdemCompra2Hist($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
		distribuir_os.idOs,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.autorizadoCompra,
		pedido_comprasitens.valor_unitario,
		distribuir_os.idDistribuir,
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,
		distribuir_os.aprovacaoSUP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.data_autorizacaoSUP,
		distribuir_os.data_autorizacaoDir,
		pedido_comprasitens.data_autorizacao,
		unidade_execucao.status_execucao,
		statuscompras.nomeStatus,
		insumos.descricaoInsumo,
		distribuir_os.dimensoes,
		status_os.nomeStatusOs,
		distribuir_os.quantidade,
		usuarios.nome,
		user2.nome as nomeUserPCP,
		user3.nome as nomeUserSUP,
		user4.nome as nomeUserFIN,
		user5.nome as nomeUserDir
		FROM `pedido_compras` 
		join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
		join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
		join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		join os on os.idOs = distribuir_os.idOs
		join status_os on status_os.idStatusOs = os.idStatusOs
		join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
		left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
		left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
		left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
		left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
		WHERE distribuir_os.aprovacaoSUP = 1 and pedido_compras.idPedidoCompra = $id";
		return $this->db->query($query)->result();
	 }
	 function getHistoricoAprovacaoDiretor(){
		$query = "select sum(pedido_comprasitens.valor_unitario* 
		pedido_comprasitens.quantidade) as soma,
		GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
		GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
		GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
		GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
		GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
		pedido_comprasitens.idPedidoCompra,
		fornecedores.nomeFornecedor,
		distribuir_os.data_cadastro, 
		distribuir_os.aprovacaoSUP,
		pedido_comprasitens.data_autorizacao,
		pedido_comprasitens.autorizadoCompra
		from distribuir_os join os on os.idOs = distribuir_os.idOs
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
		where 
		distribuir_os.aprovacaoDir = 1
		and distribuir_os.idUserAprovacaoDir != 51
		and os.unid_execucao in (1,2,4)
		GROUP by pedido_comprasitens.idPedidoCompra order by distribuir_os.data_autorizacaoDir desc limit 20";
		return $this->db->query($query)->result();
	 }
	 function getHistoricoAprovacaoDiretor2(){
		$query = "select sum(pedido_comprasitens.valor_unitario* 
		pedido_comprasitens.quantidade) as soma,
		GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
		GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
		GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
		GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
		GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
		pedido_comprasitens.idPedidoCompra,
		fornecedores.nomeFornecedor,
		distribuir_os.data_cadastro, 
		distribuir_os.aprovacaoSUP,
		pedido_comprasitens.data_autorizacao,
		pedido_comprasitens.autorizadoCompra
		from distribuir_os join os on os.idOs = distribuir_os.idOs
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
		where 
		distribuir_os.aprovacaoDir = 1
		and distribuir_os.idUserAprovacaoDir != 51 
		and (os.unid_execucao in (3) or distribuir_os.idOs in (2,11))   GROUP by pedido_comprasitens.idPedidoCompra order by distribuir_os.data_autorizacaoDir desc limit 20";
		return $this->db->query($query)->result();
	 }
	 function getHistoricoAprovacaoDiretor3(){
		$query = "select sum(pedido_comprasitens.valor_unitario* 
		pedido_comprasitens.quantidade) as soma,
		GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
		GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
		GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
		GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
		GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
		pedido_comprasitens.idPedidoCompra,
		fornecedores.nomeFornecedor,
		distribuir_os.data_cadastro, 
		distribuir_os.aprovacaoSUP,
		pedido_comprasitens.data_autorizacao,
		pedido_comprasitens.autorizadoCompra
		from distribuir_os join os on os.idOs = distribuir_os.idOs
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
		where 
		distribuir_os.aprovacaoDir = 1
		and distribuir_os.idUserAprovacaoDir != 51 
		and (os.unid_execucao in (5) or distribuir_os.idOs in (6,13))   GROUP by pedido_comprasitens.idPedidoCompra order by distribuir_os.data_autorizacaoDir desc limit 20";
		return $this->db->query($query)->result();
	 }
	 function getHistoricoAprovacaoDiretor4(){
		$query = "select sum(pedido_comprasitens.valor_unitario* 
		pedido_comprasitens.quantidade) as soma,
		GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
		GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
		GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
		GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
		GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
		pedido_comprasitens.idPedidoCompra,
		fornecedores.nomeFornecedor,
		distribuir_os.data_cadastro, 
		distribuir_os.aprovacaoSUP,
		pedido_comprasitens.data_autorizacao,
		pedido_comprasitens.autorizadoCompra
		from distribuir_os join os on os.idOs = distribuir_os.idOs
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
		where 
		distribuir_os.aprovacaoDir = 1
		and distribuir_os.idUserAprovacaoDir != 51 
		and os.unid_execucao in (6)   GROUP by pedido_comprasitens.idPedidoCompra order by distribuir_os.data_autorizacaoDir desc limit 20";
		return $this->db->query($query)->result();
	 }
	 function getHistoricoAprovacaoDiretorAdmin(){
		$query = "select sum(pedido_comprasitens.valor_unitario* 
		pedido_comprasitens.quantidade) as soma,
		GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
		GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
		GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
		GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
		GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
		pedido_comprasitens.idPedidoCompra,
		fornecedores.nomeFornecedor,
		distribuir_os.data_cadastro, 
		distribuir_os.aprovacaoSUP,
		pedido_comprasitens.data_autorizacao,
		pedido_comprasitens.autorizadoCompra
		from distribuir_os 
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
		where 
		distribuir_os.aprovacaoDir = 1
		and distribuir_os.idUserAprovacaoDir != 51 GROUP by pedido_comprasitens.idPedidoCompra order by distribuir_os.data_autorizacaoDir desc limit 20";
		return $this->db->query($query)->result();
	 }
	 function getByIdOrdemCompra3Hist($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
		distribuir_os.idOs,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.autorizadoCompra,
		pedido_comprasitens.valor_unitario,
		distribuir_os.idDistribuir,
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,
		distribuir_os.aprovacaoSUP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.data_autorizacaoSUP,
		distribuir_os.data_autorizacaoDir,
		pedido_comprasitens.data_autorizacao,
		unidade_execucao.status_execucao,
		statuscompras.nomeStatus,
		insumos.descricaoInsumo,
		distribuir_os.dimensoes,
		status_os.nomeStatusOs,
		distribuir_os.quantidade,
		usuarios.nome,
		user2.nome as nomeUserPCP,
		user3.nome as nomeUserSUP,
		user4.nome as nomeUserFIN,
		user5.nome as nomeUserDir
		FROM `pedido_compras` 
		join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
		join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
		join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		join os on os.idOs = distribuir_os.idOs
		join status_os on status_os.idStatusOs = os.idStatusOs
		join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
		left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
		left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
		left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
		left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
		WHERE distribuir_os.aprovacaoDir = 1 and pedido_compras.idPedidoCompra = $id  
		and os.unid_execucao in (1,2,4)";
		return $this->db->query($query)->result();
	 }
	 function getByIdOrdemCompra3Hist2($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
		distribuir_os.idOs,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.autorizadoCompra,
		pedido_comprasitens.valor_unitario,
		distribuir_os.idDistribuir,
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,
		distribuir_os.aprovacaoSUP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.data_autorizacaoSUP,
		distribuir_os.data_autorizacaoDir,
		pedido_comprasitens.data_autorizacao,
		unidade_execucao.status_execucao,
		statuscompras.nomeStatus,
		insumos.descricaoInsumo,
		distribuir_os.dimensoes,
		status_os.nomeStatusOs,
		distribuir_os.quantidade,
		usuarios.nome,
		user2.nome as nomeUserPCP,
		user3.nome as nomeUserSUP,
		user4.nome as nomeUserFIN,
		user5.nome as nomeUserDir
		FROM `pedido_compras` 
		join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
		join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
		join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		join os on os.idOs = distribuir_os.idOs
		join status_os on status_os.idStatusOs = os.idStatusOs
		join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
		left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
		left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
		left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
		left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
		WHERE distribuir_os.aprovacaoDir = 1 and pedido_compras.idPedidoCompra = $id 
		and (os.unid_execucao = 3 or distribuir_os.idOs in (2,11))";
		return $this->db->query($query)->result();
	 }
	 function getByIdOrdemCompra3Hist3($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
		distribuir_os.idOs,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.autorizadoCompra,
		pedido_comprasitens.valor_unitario,
		distribuir_os.idDistribuir,
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,
		distribuir_os.aprovacaoSUP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.data_autorizacaoSUP,
		distribuir_os.data_autorizacaoDir,
		pedido_comprasitens.data_autorizacao,
		unidade_execucao.status_execucao,
		statuscompras.nomeStatus,
		insumos.descricaoInsumo,
		distribuir_os.dimensoes,
		status_os.nomeStatusOs,
		distribuir_os.quantidade,
		usuarios.nome,
		user2.nome as nomeUserPCP,
		user3.nome as nomeUserSUP,
		user4.nome as nomeUserFIN,
		user5.nome as nomeUserDir
		FROM `pedido_compras` 
		join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
		join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
		join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		join os on os.idOs = distribuir_os.idOs
		join status_os on status_os.idStatusOs = os.idStatusOs
		join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
		left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
		left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
		left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
		left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
		WHERE distribuir_os.aprovacaoDir = 1 and pedido_compras.idPedidoCompra = $id 
		and (os.unid_execucao = 5 or distribuir_os.idOs in (6,13))";
		return $this->db->query($query)->result();
	 }
	 function getByIdOrdemCompra3Hist4($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
		distribuir_os.idOs,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.autorizadoCompra,
		pedido_comprasitens.valor_unitario,
		distribuir_os.idDistribuir,
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,
		distribuir_os.aprovacaoSUP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.data_autorizacaoSUP,
		distribuir_os.data_autorizacaoDir,
		pedido_comprasitens.data_autorizacao,
		unidade_execucao.status_execucao,
		statuscompras.nomeStatus,
		insumos.descricaoInsumo,
		distribuir_os.dimensoes,
		status_os.nomeStatusOs,
		distribuir_os.quantidade,
		usuarios.nome,
		user2.nome as nomeUserPCP,
		user3.nome as nomeUserSUP,
		user4.nome as nomeUserFIN,
		user5.nome as nomeUserDir
		FROM `pedido_compras` 
		join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
		join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
		join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		join os on os.idOs = distribuir_os.idOs
		join status_os on status_os.idStatusOs = os.idStatusOs
		join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
		left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
		left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
		left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
		left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
		WHERE distribuir_os.aprovacaoDir = 1 and pedido_compras.idPedidoCompra = $id 
		and os.unid_execucao = 6 ";
		return $this->db->query($query)->result();
	 }
	 function getByIdOrdemCompra3HistAdmin($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
			distribuir_os.idOs,
			pedido_comprasitens.idPedidoCompraItens,
			pedido_comprasitens.autorizadoCompra,
			pedido_comprasitens.valor_unitario,
			distribuir_os.idDistribuir,
			distribuir_os.comprimento,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			distribuir_os.aprovacaoSUP,
			distribuir_os.data_autorizacaoPCP,
			distribuir_os.data_autorizacaoSUP,
			distribuir_os.data_autorizacaoDir,
			pedido_comprasitens.data_autorizacao,
			unidade_execucao.status_execucao,
			statuscompras.nomeStatus,
			insumos.descricaoInsumo,
			distribuir_os.dimensoes,
			status_os.nomeStatusOs,
			distribuir_os.quantidade,
			usuarios.nome,
			user2.nome as nomeUserPCP,
			user3.nome as nomeUserSUP,
			user4.nome as nomeUserFIN,
			user5.nome as nomeUserDir
			FROM `pedido_compras` 
			join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
			join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
			join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
			join insumos on insumos.idInsumos = distribuir_os.idInsumos 
			join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
			join os on os.idOs = distribuir_os.idOs
			join status_os on status_os.idStatusOs = os.idStatusOs
			join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
			left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
			left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
			left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
			left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
			left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
			WHERE distribuir_os.aprovacaoDir = 1 and pedido_compras.idPedidoCompra = $id";
		return $this->db->query($query)->result();
	 }
	 function getHistoricoAprovacaoDiretoria(){
		$query = "select sum(pedido_comprasitens.valor_unitario* 
		pedido_comprasitens.quantidade) as soma,
		GROUP_CONCAT(pedido_comprasitens.idPedidoCompraItens SEPARATOR ';') as idPedidoCompraItens,
		GROUP_CONCAT(distribuir_os.idDistribuir  SEPARATOR ';') as idDistribuir,
		GROUP_CONCAT(distribuir_os.idOs SEPARATOR ';') as idOs,
		GROUP_CONCAT(insumos.descricaoInsumo SEPARATOR ';') as descricaoInsumo,
		GROUP_CONCAT(distribuir_os.aprovacaoPCP SEPARATOR ';') as aprovacaoPCP,
		pedido_comprasitens.idPedidoCompra,
		fornecedores.nomeFornecedor,
		distribuir_os.data_cadastro, 
		distribuir_os.aprovacaoSUP,
		pedido_comprasitens.data_autorizacao,
		pedido_comprasitens.autorizadoCompra
		from distribuir_os 
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_cotacaoitens.idPedidoCompraItens = pedido_comprasitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores
		where 
		pedido_comprasitens.autorizadoCompra = 1
		and pedido_comprasitens.idUsuarioAutorizacao != 51
		and distribuir_os.data_cadastro > '2022-03-25'   GROUP by pedido_comprasitens.idPedidoCompra order by pedido_comprasitens.data_autorizacao desc limit 20";
		return $this->db->query($query)->result();
	 }
	 function getByIdOrdemCompra4Hist($id){
		$query = "SELECT pedido_compras.idPedidoCompra,
		distribuir_os.idOs,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.autorizadoCompra,
		pedido_comprasitens.valor_unitario,
		distribuir_os.idDistribuir,
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,
		distribuir_os.aprovacaoSUP,
		distribuir_os.data_autorizacaoPCP,
		distribuir_os.data_autorizacaoSUP,
		distribuir_os.data_autorizacaoDir,
		pedido_comprasitens.data_autorizacao,
		unidade_execucao.status_execucao,
		statuscompras.nomeStatus,
		insumos.descricaoInsumo,
		distribuir_os.dimensoes,
		status_os.nomeStatusOs,
		distribuir_os.quantidade,
		usuarios.nome,
		user2.nome as nomeUserPCP,
		user3.nome as nomeUserSUP,
		user4.nome as nomeUserFIN,
		user5.nome as nomeUserDir
		FROM `pedido_compras` 
		join pedido_comprasitens on pedido_comprasitens.idPedidoCompra = pedido_compras.idPedidoCompra 
		join pedido_cotacaoitens on pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
		join distribuir_os on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		join os on os.idOs = distribuir_os.idOs
		join status_os on status_os.idStatusOs = os.idStatusOs
		join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
		left join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro
		left join usuarios as user2 on user2.idUsuarios = distribuir_os.idUserAprovacao
		left join usuarios as user3 on user3.idUsuarios = distribuir_os.idUserAprovacaoSUP
		left join usuarios as user4 on user4.idUsuarios = pedido_comprasitens.idUsuarioAutorizacao
		left join usuarios as user5 on user5.idUsuarios = distribuir_os.idUserAprovacaoDir
		WHERE distribuir_os.aprovacaoDir = 1 and pedido_compras.idPedidoCompra = $id";
		return $this->db->query($query)->result();
	 }
	 function getInfoOC($idPedidoCompra){
		$query = "SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		usuarios.user,
		distribuir_os.quantidade,
		insumos.idInsumos,
		pedido_comprasitens.idPedidoCompraItens,
		pedido_comprasitens.valor_unitario,
		pedido_compras.idEmitente,
		pedido_compras.frete,
		fornecedores.nomeFornecedor,
		emitente.nome,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		distribuir_os.data_alteracao,
		distribuir_os.data_cadastro as datacadastrodist,
		distribuir_os.dimensoes,
		distribuir_os.histo_alteracao,
		distribuir_os.obs,
		distribuir_os.metrica,
		distribuir_os.comprimento,
		distribuir_os.volume,
		distribuir_os.peso,
		distribuir_os.dimensoesL,
		distribuir_os.dimensoesA,
		distribuir_os.dimensoesC,
		status_grupo_compra.nomegrupo,
		status_grupo_compra.idgrupo,
		pedido_cotacaoitens.data_cadastro,
		pedido_compras.data_cadastro as cadpedgerado,
		statuscompras.nomeStatus,
		statuscompras.cor,
		statuscompras.idStatuscompras,
		almo_permissao_suprimentos.statusPermissao,
		almo_permissao_suprimentos.idAlmoPermSupr,
		pedido_comprasitens.datastatusentregue,
		pedido_comprasitens.previsao_entrega,
		pedido_comprasitens.prazo_entrega,
		pedido_comprasitens.cod_pgto,
		pedido_comprasitens.desconto,
		pedido_comprasitens.outros,
		pedido_cotacaoitens.idPedidoCompra,
		pedido_cotacaoitens.idPedidoCompraItens,
		pedido_cotacaoitens.idCotacaoItens,
		pedido_cotacaoitens.idPedidoCotacao,
		status_cond_pgt.nome_status_cond_pgt,
		usuarios2.nome as nomeAgOrc,
		insumos.descricaoInsumo,
		unidade_execucao.status_execucao
		FROM
		pedido_cotacaoitens RIGHT JOIN distribuir_os 
		ON distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
		INNER JOIN usuarios 
		ON distribuir_os.usuario_cadastro = usuarios.idUsuarios 
		INNER JOIN status_grupo_compra 
		on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo  
		INNER JOIN insumos 
		ON insumos.idInsumos = distribuir_os.idInsumos  
		INNER JOIN statuscompras 
		ON statuscompras.idStatuscompras = distribuir_os.idStatuscompras   
		LEFT JOIN pedido_compras 
		ON pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra
		LEFT JOIN emitente 
		ON pedido_compras.idEmitente = emitente.id 
		LEFT JOIN fornecedores 
		ON fornecedores.idFornecedores = pedido_compras.idFornecedores 
		LEFT JOIN pedido_comprasitens 
		ON pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
		LEFT JOIN status_cond_pgt 
		ON status_cond_pgt.id_status_cond_pgt = pedido_comprasitens.cod_pgto  
		INNER JOIN os
		ON os.idOs = distribuir_os.idOs
		LEFT JOIN almo_permissao_suprimentos 
		ON almo_permissao_suprimentos.idInsumo = distribuir_os.idInsumos
		LEFT JOIN usuarios as usuarios2 on usuarios2.idUsuarios = distribuir_os.idUser_aguardandoOrc
		JOIN unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
		WHERE
		statuscompras.idStatuscompras not in(0) and pedido_compras.idPedidoCompra = $idPedidoCompra ORDER BY insumos.descricaoInsumo asc";
		return $this->db->query($query)->result();
	 }
	 function getIdPedidoCompraItens($id){
		$query = "SELECT * FROM pedido_comprasitens WHERE idPedidoCompraItens = $id";
		return $this->db->query($query)->row();
	 }
	 function getdistribuidorByIdPedidoCompra($id){
		$query = "SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		distribuir_os.quantidade,
		distribuir_os.data_reagendada,
		distribuir_os.justificativa,
		distribuir_os.data_cadastro as data_dist,
		pedido_comprasitens.previsao_entrega,
		fornecedores.nomeFornecedor,
		usuarios.nome,
		produtos.pn,
		fornecedores.telefone,
		orcamento_item.descricao_item,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		pedido_comprasitens.desconto,
		pedido_compras.frete,
		pedido_comprasitens.outros,
		pedido_comprasitens.data_cadastro as cadpedgerado,
		distribuir_os.dimensoes,
		distribuir_os.obs,
		status_grupo_compra.nomegrupo,
		pedido_cotacaoitens.data_cadastro,
		pedido_comprasitens.valor_total,
		pedido_comprasitens.datastatusentregue,
		statuscompras.nomeStatus,
		statuscompras.etapa,
		statuscompras.idStatuscompras,
		pedido_comprasitens.valor_unitario,
		pedido_cotacaoitens.idPedidoCompra,
		pedido_cotacaoitens.idPedidoCompraItens,
		pedido_cotacaoitens.idCotacaoItens,
		pedido_cotacaoitens.idPedidoCotacao,
		insumos.descricaoInsumo FROM distribuir_os 
		inner join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo 
		inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras 
		inner join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		left join pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		left join pedido_cotacao on pedido_cotacao.idPedidoCotacao = pedido_cotacaoitens.idPedidoCotacao 
		left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  
		left join pedido_compras on pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra    
		left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores 
		join os on os.idOs = distribuir_os.idOs 
		join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		join produtos on produtos.idProdutos = orcamento_item.idProdutos
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro where 1 = 1 and pedido_compras.idPedidoCompra = $id";
		return $this->db->query($query)->result();
	 }
	 function getUsuariosOrc(){
		$query = "SELECT DISTINCT idUser_aguardandoOrc, usuarios.nome FROM `distribuir_os` join usuarios on usuarios.idUsuarios = distribuir_os.idUser_aguardandoOrc";
		return $this->db->query($query)->result();
	 }
	 function getDescricaoInsumo($descricao){
		$query = 'SELECT DISTINCT replace(replace(replace(concat(insumos.descricaoInsumo, "",distribuir_os.dimensoes)," ",""),"mm",""),"MM","") as produto, distribuir_os.idDistribuir FROM `distribuir_os` join insumos on insumos.idInsumos = distribuir_os.idInsumos where distribuir_os.idStatuscompras = 5 having produto like "%'.$descricao.'%" order by insumos.descricaoInsumo asc, distribuir_os.dimensoes asc limit 1';
		return $this->db->query($query)->row();
	 }
	 function getDescricaoInsumo2($descricao){
		$query = 'SELECT DISTINCT replace(replace(replace(insumos.descricaoInsumo," ",""),"mm",""),"MM","") as produto, idInsumos FROM `insumos`  having produto like "%'.$descricao.'%" order by insumos.descricaoInsumo asc limit 1';
		return $this->db->query($query)->row();
	 }

	 function getUltimosOrc($where){
		$query = "SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		distribuir_os.quantidade,
		distribuir_os.data_reagendada,
		distribuir_os.dimensoes,
		distribuir_os.justificativa,
		distribuir_os.data_cadastro as data_dist,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		pedido_comprasitens.desconto,
		pedido_comprasitens.outros,
		pedido_comprasitens.data_cadastro as cadpedgerado,
		statuscompras.nomeStatus,
		statuscompras.etapa,
		statuscompras.idStatuscompras,
		pedido_comprasitens.valor_unitario,
		insumos.descricaoInsumo,
		pedido_comprasitens.idPedidoCompra
		FROM distribuir_os 
		JOIN pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		WHERE distribuir_os.idStatuscompras in (5,4,14) $where order by pedido_comprasitens.data_cadastro desc limit 5";
		return $this->db->query($query)->result();
	 }
	 function getUltimosOrcLimitedOne($where){
		$query = "SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		distribuir_os.quantidade,
		distribuir_os.data_reagendada,
		distribuir_os.dimensoes,
		distribuir_os.justificativa,
		distribuir_os.data_cadastro as data_dist,
		pedido_comprasitens.notafiscal,
		pedido_comprasitens.obs as obscompras,
		pedido_comprasitens.desconto,
		pedido_comprasitens.outros,
		pedido_comprasitens.data_cadastro as cadpedgerado,
		statuscompras.nomeStatus,
		statuscompras.etapa,
		statuscompras.idStatuscompras,
		pedido_comprasitens.valor_unitario,
		insumos.descricaoInsumo,
		pedido_comprasitens.idPedidoCompra
		FROM distribuir_os 
		JOIN pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
		join insumos on insumos.idInsumos = distribuir_os.idInsumos
		join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras
		WHERE distribuir_os.idStatuscompras in (5,4,14) $where order by pedido_comprasitens.data_cadastro desc limit 1";
		return $this->db->query($query)->row();
	 
	 }
	 function getAnexoCotacaoSuprimentosByIdPedidoCompra($id){
		$query = "SELECT * FROM anexo_cotacao_suprimentos join pedido_compras on pedido_compras.idPedidoCompra = anexo_cotacao_suprimentos.idPedidoCompra where pedido_compras.idPedidoCompra = $id";
		return $this->db->query($query)->result();
	 }
}