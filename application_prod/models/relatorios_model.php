<?php
class Relatorios_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    public function pedidoCustom($id=''){
       
	   if(!empty($id))
		 {
			 $tes1 = str_replace(".",",",$id); 
			$id1 = " and distribuir_os.idDistribuir in(".$tes1.")";
		 }
		 else
		 {
			 $id1 = '';
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
 insumos.descricaoInsumo FROM distribuir_os left join
pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras left join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens left join pedido_compras on 	pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra left join emitente on pedido_compras.	idEmitente = emitente.id left join fornecedores on fornecedores.idFornecedores = pedido_compras.	idFornecedores  where 1=1 $id1  ORDER BY distribuir_os.idOs desc
        ";		
        
        return $this->db->query($query)->result();
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
    
    public function clientesCustom($dataInicial = null,$dataFinal = null){
        
        if($dataInicial == null || $dataFinal == null){
            $dataInicial = date('Y-m-d');
            $dataFinal = date('Y-m-d');
        }
        $query = "SELECT * FROM clientes WHERE dataCadastro BETWEEN ? AND ?";
        return $this->db->query($query, array($dataInicial,$dataFinal))->result();
    }

    public function clientesRapid(){
        $this->db->order_by('nomeCliente','asc');
        return $this->db->get('clientes')->result();
    }
	public function fornecedoresRapid(){
        $this->db->order_by('nomeFornecedor','asc');
        return $this->db->get('fornecedores')->result();
    }
	public function insumoRapid(){
        $this->db->order_by('descricaoInsumo','asc');
        return $this->db->get('insumos')->result();
    }
	public function categoriaRapid(){
        $this->db->order_by('descricaoCategoria','asc');
        return $this->db->get('categoriaInsumos')->result();
    }

    public function produtosRapid(){
        $this->db->order_by('descricao','asc');
        return $this->db->get('produtos')->result();
    }

    public function servicosRapid(){
        $this->db->order_by('nome','asc');
        return $this->db->get('servicos')->result();
    }

	public function grupoCompraRapid(){
        $this->db->order_by('nomegrupo','asc');
        return $this->db->get('status_grupo_compra')->result();
    }

    public function osRapid(){
        $this->db->select('os.*,clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes','clientes.idClientes = os.clientes_id');
        return $this->db->get()->result();
    }

    public function produtosRapidMin(){
        $this->db->order_by('descricao','asc');
        $this->db->where('estoque < estoqueMinimo');
        return $this->db->get('produtos')->result();
    }

    public function produtosCustom($precoInicial = null,$precoFinal = null,$estoqueInicial = null,$estoqueFinal = null){
        $wherePreco = "";
        $whereEstoque = "";
        if($precoInicial != null){
            $wherePreco = "AND precoVenda BETWEEN ".$this->db->escape($precoInicial)." AND ".$this->db->escape($precoFinal);
        }
        if($estoqueInicial != null){
            $whereEstoque = "AND estoque BETWEEN ".$this->db->escape($estoqueInicial)." AND ".$this->db->escape($estoqueFinal);
        }
        $query = "SELECT * FROM produtos WHERE estoque >= 0 $wherePreco $whereEstoque";
        return $this->db->query($query)->result();
    }

    public function servicosCustom($precoInicial = null,$precoFinal = null){
        $query = "SELECT * FROM servicos WHERE preco BETWEEN ? AND ?";
        return $this->db->query($query, array($precoInicial,$precoFinal))->result();
    }


    public function osCustom($dataInicial = null,$dataFinal = null,$cliente = null,$responsavel = null,$status = null){
        $whereData = "";
        $whereCliente = "";
        $whereResponsavel = "";
        $whereStatus = "";
        if($dataInicial != null){
            $whereData = "AND dataInicial BETWEEN ".$this->db->escape($dataInicial)." AND ".$this->db->escape($dataFinal);
        }
        if($cliente != null){
            $whereCliente = "AND clientes_id = ".$this->db->escape($cliente);
        }
        if($responsavel != null){
            $whereResponsavel = "AND usuarios_id = ".$this->db->escape($responsavel);
        }
        if($status != null){
            $whereStatus = "AND status = ".$this->db->escape($status);
        }
        $query = "SELECT os.*,clientes.nomeCliente FROM os LEFT JOIN clientes ON os.clientes_id = clientes.idClientes WHERE idOs != 0 $whereData $whereCliente $whereResponsavel $whereStatus";
        return $this->db->query($query)->result();
    }


    public function financeiroRapid(){
        
        $dataInicial = date('Y-m-01');
        $dataFinal = date("Y-m-t");
        $query = "SELECT * FROM lancamentos WHERE data_vencimento BETWEEN ? and ? ORDER BY tipo";
        return $this->db->query($query, array($dataInicial,$dataFinal))->result();
    }


    public function financeiroCustom($dataInicial, $dataFinal, $tipo = null, $situacao = null){
        
        $whereTipo = "";
        $whereSituacao = "";

        if($dataInicial == null){
            $dataInicial = date('Y-m-01');
        }
        if($dataFinal == null){
            $dataFinal = date("Y-m-t");  
        }

        if($tipo == 'receita'){
            $whereTipo = "AND tipo = 'receita'";
        }
        if($tipo == 'despesa'){
            $whereTipo = "AND tipo = 'despesa'";
        }
        if($situacao == 'pendente'){
            $whereSituacao = "AND baixado = 0";
        }
        if($situacao == 'pago'){
            $whereSituacao = "AND baixado = 1";
        } 
        
        
        $query = "SELECT * FROM lancamentos WHERE data_vencimento BETWEEN ? and ? $whereTipo $whereSituacao";
        return $this->db->query($query, array($dataInicial,$dataFinal))->result();
    }


    public function vendasRapid(){
        $this->db->select('vendas.*,clientes.nomeCliente, usuarios.nome');
        $this->db->from('vendas');
        $this->db->join('clientes','clientes.idClientes = vendas.clientes_id');
        $this->db->join('usuarios', 'usuarios.idUsuarios = vendas.usuarios_id');
        return $this->db->get()->result();
    }


    public function vendasCustom($dataInicial = null,$dataFinal = null,$cliente = null,$responsavel = null){
        $whereData = "";
        $whereCliente = "";
        $whereResponsavel = "";
        $whereStatus = "";
        if($dataInicial != null){
            $whereData = "AND dataVenda BETWEEN ".$this->db->escape($dataInicial)." AND ".$this->db->escape($dataFinal);
        }
        if($cliente != null){
            $whereCliente = "AND clientes_id = ".$this->db->escape($cliente);
        }
        if($responsavel != null){
            $whereResponsavel = "AND usuarios_id = ".$this->db->escape($responsavel);
        }
       
        $query = "SELECT vendas.*,clientes.nomeCliente,usuarios.nome FROM vendas LEFT JOIN clientes ON vendas.clientes_id = clientes.idClientes LEFT JOIN usuarios ON vendas.usuarios_id = usuarios.idUsuarios WHERE idVendas != 0 $whereData $whereCliente $whereResponsavel";
        return $this->db->query($query)->result();
    }
	
	/*public function getWhereLikeos($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '', $numero_nf = '',$query_status_producao = '',$query_unid_execucao = '',$query_unid_faturamento = '',$querydataentrega = '',$querydatacadastro = '',$querydatareagendada = '',$query_clientes = '', $idStatuscompras = '', $idPedidoCompra = '',$idPedidoCotacao = '',$query_fornecedor = '',$notafiscal= '')
    { 
		if($query_fornecedor <> '')
		{
			$query_fornecedor1 = " and fornecedores.idFornecedores in ".$query_fornecedor;
		}
		else
		{
			$query_fornecedor1 = '';
		}
		if($notafiscal <> '')
		{
			$notafiscal1 = " and pedido_compras.notafiscal in ".$notafiscal;
		}
		else
		{
			$notafiscal1 = '';
		}
		
		if($query_clientes <> '')
		{
			$query_clientes1 = " and clientes.idClientes in ".$query_clientes;
		}
		else
		{
			$query_clientes1 = '';
		}
		
		if($querydataentrega <> '')
		{
			$querydataentrega1 = $querydataentrega;
		}
		else
		{
			$querydataentrega1 = '';
		}
		if($querydatacadastro <> '')
		{
			$querydatacadastro1 = $querydatacadastro;
		}
		else
		{
			$querydatacadastro1 = '';
		}
		if($querydatareagendada <> '')
		{
			$querydatareagendada1 = $querydatareagendada;
		}
		else
		{
			$querydatareagendada1 = '';
		}
		
		if($query_status_producao <> '')
		{
			$query_status_producao1 = " and os.idStatusOs in ".$query_status_producao;
		}
		else
		{
			$query_status_producao1 = '';
		}
		
		if($query_unid_execucao <> '')
		{
			$query_unid_execucao1 = " and os.unid_execucao in ".$query_unid_execucao;
		}
		else
		{
			$query_unid_execucao1 = '';
		}
		if($query_unid_faturamento <> '')
		{
			$query_unid_faturamento1 = " and os.unid_faturamento in ".$query_unid_faturamento;
		}
		else
		{
			$query_unid_faturamento1 = '';
		}
		
		if($cod_orc <> '')
		{
			$cod_orc1 = " and os.idOrcamentos = ".$cod_orc;
		}
		else
		{
			$cod_orc1 = '';
		}
		if($clientes_id <> '')
		{
			$clientes_id1  = " and orcamento.idClientes = ".$clientes_id;
		}
		else
		{
			$clientes_id1 = '';
		}
		if($idOs <> '')
		{
			
         $idOs1 = " and os.idOs = ".$idOs;
		}
		else
		{
			$idOs1 = '';
		}
		if($idProdutos <> '')
		{
			$idProdutos1 = " and produtos.idProdutos = ".$idProdutos;
		}
		else
		{
			$idProdutos1 = '';
		}
		if($numpedido_os <> '')
		{
			 $numpedido_os1 = " and os.numpedido_os = ".$numpedido_os;
		}
		else
		{
			$numpedido_os1 = '';
		}
		if($numero_nf <> '')
		{
			 $numero_nf1 = " and os.numero_nf = ".$numero_nf;
		}
		else
		{
			$numero_nf1 = '';
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
			$idStatuscompras1 = " and distribuir_os.idStatuscompras in ".$idStatuscompras;
		}
		else
		{
			$idStatuscompras1 = '';
		}
		
		
		
         
        $query = "
          SELECT  distribuir_os.idDistribuir,
distribuir_os.idOs,
distribuir_os.quantidade,
distribuir_os.dimensoes,
distribuir_os.obs,
distribuir_os.data_cadastro,
 statuscompras.nomeStatus,
 statuscompras.idStatuscompras,
  pedido_cotacaoitens.idPedidoCompra,
  pedido_cotacaoitens.idPedidoCompraItens,
pedido_cotacaoitens.idCotacaoItens,
 pedido_cotacaoitens.idPedidoCotacao,
 insumos.descricaoInsumo, fornecedores.idFornecedores, fornecedores.nomeFornecedor, 
os.idOs,os.`data_abertura`, os.`data_entrega`,os.`data_reagendada`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,os.subtot_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,status_os.nomeStatusOs, emitente.nome FROM  distribuir_os  inner join pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras left join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens inner join
(`os`) on os.idOs = distribuir_os.idOs left join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores  JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos join status_os on status_os.idStatusOs = os.idStatusOs join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento  where 1=1 $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $numero_nf1 $query_status_producao1 $query_unid_execucao1 $query_unid_faturamento1 $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 $idPedidoCotacao1 $idStatuscompras1 $idPedidoCompra1 $notafiscal1 $query_fornecedor1 ORDER BY `os`.`idOs` desc
        ";
        
        return $this->db->query($query)->result();
       
    }
    public function numrowsWhereLikeos($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '', $numero_nf = '',$query_status_producao = '',$query_unid_execucao = '',$query_unid_faturamento = '',$querydataentrega = '',$querydatacadastro = '',$querydatareagendada = '',$query_clientes = '', $idStatuscompras = '', $idPedidoCompra = '',$idPedidoCotacao = '')
    {
		if($query_clientes <> '')
		{
			$query_clientes1 = " and clientes.idClientes in ".$query_clientes;
		}
		else
		{
			$query_clientes1 = '';
		}
		
		if($querydataentrega <> '')
		{
			$querydataentrega1 = $querydataentrega;
		}
		else
		{
			$querydataentrega1 = '';
		}
		if($querydatacadastro <> '')
		{
			$querydatacadastro1 = $querydatacadastro;
		}
		else
		{
			$querydatacadastro1 = '';
		}
		if($querydatareagendada <> '')
		{
			$querydatareagendada1 = $querydatareagendada;
		}
		else
		{
			$querydatareagendada1 = '';
		}
		
		if($query_status_producao <> '')
		{
			$query_status_producao1 = " and os.idStatusOs in ".$query_status_producao;
		}
		else
		{
			$query_status_producao1 = '';
		}
		
		if($query_unid_execucao <> '')
		{
			$query_unid_execucao1 = " and os.unid_execucao in ".$query_unid_execucao;
		}
		else
		{
			$query_unid_execucao1 = '';
		}
		if($query_unid_faturamento <> '')
		{
			$query_unid_faturamento1 = " and os.unid_faturamento in ".$query_unid_faturamento;
		}
		else
		{
			$query_unid_faturamento1 = '';
		}
		
		if($cod_orc <> '')
		{
			$cod_orc1 = " and os.idOrcamentos = ".$cod_orc;
		}
		else
		{
			$cod_orc1 = '';
		}
		if($clientes_id <> '')
		{
			$clientes_id1  = " and orcamento.idClientes = ".$clientes_id;
		}
		else
		{
			$clientes_id1 = '';
		}
		if($idOs <> '')
		{
			
         $idOs1 = " and os.idOs = ".$idOs;
		}
		else
		{
			$idOs1 = '';
		}
		if($idProdutos <> '')
		{
			$idProdutos1 = " and produtos.idProdutos = ".$idProdutos;
		}
		else
		{
			$idProdutos1 = '';
		}
		if($numpedido_os <> '')
		{
			 $numpedido_os1 = " and os.numpedido_os = ".$numpedido_os;
		}
		else
		{
			$numpedido_os1 = '';
		}
		if($numero_nf <> '')
		{
			 $numero_nf1 = " and os.numero_nf = ".$numero_nf;
		}
		else
		{
			$numero_nf1 = '';
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
			$idStatuscompras1 = " and distribuir_os.idStatuscompras in ".$idStatuscompras;
		}
		else
		{
			$idStatuscompras1 = '';
		}
		
		
		
         
        $query = "
          SELECT  distribuir_os.idDistribuir,
distribuir_os.idOs,
distribuir_os.quantidade,
distribuir_os.dimensoes,
distribuir_os.obs,
distribuir_os.data_cadastro,
 statuscompras.nomeStatus,
 statuscompras.idStatuscompras,
  pedido_cotacaoitens.idPedidoCompra,
  pedido_cotacaoitens.idPedidoCompraItens,
pedido_cotacaoitens.idCotacaoItens,
 pedido_cotacaoitens.idPedidoCotacao,
 insumos.descricaoInsumo, 
os.idOs,os.`data_abertura`, fornecedores.idFornecedores, fornecedores.nomeFornecedor,  os.`data_entrega`,os.`data_reagendada`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,os.subtot_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,status_os.nomeStatusOs, emitente.nome FROM distribuir_os  inner join pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir  
inner join insumos on insumos.idInsumos = distribuir_os.idInsumos  inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras left join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens left join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores inner join
(`os`) on os.idOs = distribuir_os.idOs JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos join status_os on status_os.idStatusOs = os.idStatusOs join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento  where 1=1 $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $numero_nf1 $query_status_producao1 $query_unid_execucao1 $query_unid_faturamento1 $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 $idPedidoCotacao1 $idStatuscompras1 $idPedidoCompra1  ORDER BY `os`.`idOs` desc
        ";
        
        return $this->db->count_all();
       
    }*/
	public function getWhereLikeos($idOs, $idPedidoCotacao,$idStatuscompras,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo,$queryos1a1,$querydatacadastro = "",$querydatacompra = "")
    {
		if($queryos1a1 <> '')
		{
			$queryos13 = $queryos1a1;
		}
		else
		{
			$queryos13 = '';
		}
		
		if($idOs <> '')
		{
			
        	$idOs1 = " and distribuir_os.idOs in(".$idOs.")";
		}
		else
		{
			$idOs1 = '';
		}
		if($idPedidoCompra <> '')
		{
			$idPedidoCompra1 = " and  pedido_cotacaoitens.idPedidoCompra in(".$idPedidoCompra.")";
			
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
			$idStatuscompras1  = " and  distribuir_os.idStatuscompras in".$idStatuscompras;
		}
		else
		{
			$idStatuscompras1 = '';
		}
		if($fornecedor_id <> '')
		{
			
			$fornecedor_id1  = " and  (fornecedores.idFornecedores not in".$fornecedor_id." or fornecedores.idFornecedores is null)";
		}
		else
		{
			$fornecedor_id1 = '';
		}
		if($nf_fornecedor <> '')
		{
			$nf_fornecedor1  = " and  pedido_comprasitens.notafiscal in(".$nf_fornecedor.")";
		}
		else
		{
			$nf_fornecedor1 = '';
		}
		
         if($query_idgrupo <> '')
		{
			$query_idgrupo1  = " and  distribuir_os.id_status_grupo in".$query_idgrupo;
		}
		else
		{
			$query_idgrupo1 = '';
		}
        $query = "
         SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		distribuir_os.quantidade,
		distribuir_os.data_cadastro as data_dist,
		pedido_comprasitens.previsao_entrega,
		fornecedores.nomeFornecedor,
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
		pedido_cotacaoitens.idPedidoCompra,
		pedido_cotacaoitens.idPedidoCompraItens,
		pedido_cotacaoitens.idCotacaoItens,
		pedido_cotacaoitens.idPedidoCotacao,
		insumos.descricaoInsumo FROM distribuir_os inner join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras inner join insumos on insumos.idInsumos = distribuir_os.idInsumos left join
		pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir left join pedido_cotacao on pedido_cotacao.idPedidoCotacao = pedido_cotacaoitens.idPedidoCotacao left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  left join pedido_compras on pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra    left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores where 1 = 1 $fornecedor_id1 $nf_fornecedor1 $idOs1 $queryos13 $idStatuscompras1 $query_idgrupo1 $idPedidoCotacao1  $idPedidoCompra1 $querydatacadastro $querydatacompra ORDER BY distribuir_os.idOs asc
        ";
        return $this->db->query($query)->result();
    }
	
    public function numrowsWhereLikeos($idOs, $idPedidoCotacao,$idStatuscompras,$idPedidoCompra,$fornecedor_id,$nf_fornecedor,$query_idgrupo,$queryos1a1,$querydatacadastro,$querydatacadastro = "", $querydatacompra = "")
    {
		if($queryos1a1 <> '')
		{
		$queryos13 = $queryos1a1;
		}
		else
		{
			$queryos13 = '';
		}
if($nf_fornecedor <> '')
		{
			$nf_fornecedor1  = " and  pedido_comprasitens.notafiscal in(".$nf_fornecedor.")";
		}
		else
		{
			$nf_fornecedor1 = '';
		}
		
		
      if($idOs <> '')
		{
			
         $idOs1 = " and distribuir_os.idOs in(".$idOs.")";
		}
		else
		{
			$idOs1 = '';
		}
		
		if($idPedidoCompra <> '')
		{
			$idPedidoCompra1 = " and  pedido_cotacaoitens.idPedidoCompra in(".$idPedidoCompra.")";
		}
		else
		{
			$idPedidoCompra1 = '';
		}
		if($idPedidoCotacao <> '')
		{
			$idPedidoCotacao1 = " and  pedido_cotacaoitens.idPedidoCotacao in".$idPedidoCotacao;
		}
		else
		{
			$idPedidoCotacao1 = '';
		}
		if($idStatuscompras <> '')
		{
			$idStatuscompras1  = " and  distribuir_os.idStatuscompras in".$idStatuscompras;
		}
		else
		{
			$idStatuscompras1 = '';
		}
		
		if($fornecedor_id <> '')
		{
			$fornecedor_id1  = " and  (fornecedores.idFornecedores not in".$fornecedor_id." or fornecedores.idFornecedores is null)";
		}
		else
		{
			$fornecedor_id1 = '';
		}
		if($query_idgrupo <> '')
		{
			$query_idgrupo1  = " and  distribuir_os.id_status_grupo in".$query_idgrupo;
		}
		else
		{
			$query_idgrupo1 = '';
		}
			
        $query = "
         SELECT distribuir_os.idDistribuir,
distribuir_os.idOs,
distribuir_os.quantidade,
distribuir_os.dimensoes,
distribuir_os.data_cadastro as data_dist,
pedido_comprasitens.previsao_entrega,
pedido_comprasitens.valor_total,
pedido_comprasitens.desconto,
pedido_compras.frete,
pedido_comprasitens.outros,
distribuir_os.obs,
pedido_cotacaoitens.data_cadastro,
pedido_compras.data_cadastro as cadpedgerado,
fornecedores.nomeFornecedor,
 pedido_comprasitens.datastatusentregue,
pedido_comprasitens.notafiscal,
status_grupo_compra.nomegrupo,
pedido_comprasitens.obs as obscompras,
 statuscompras.nomeStatus,
 statuscompras.idStatuscompras,
  pedido_cotacaoitens.idPedidoCompra,
  pedido_cotacaoitens.idPedidoCompraItens,
pedido_cotacaoitens.idCotacaoItens,
 pedido_cotacaoitens.idPedidoCotacao,
 insumos.descricaoInsumo FROM distribuir_os inner join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo inner join statuscompras on statuscompras.idStatuscompras = distribuir_os.idStatuscompras inner join insumos on insumos.idInsumos = distribuir_os.idInsumos left join
pedido_cotacaoitens on distribuir_os.idDistribuir = pedido_cotacaoitens.idDistribuir left join pedido_cotacao on pedido_cotacao.idPedidoCotacao = pedido_cotacaoitens.idPedidoCotacao left join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens  left join pedido_compras on pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra    left join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores where 1 = 1 $fornecedor_id1 $nf_fornecedor1 $idOs1 $queryos13 $idStatuscompras1 $query_idgrupo1 $idPedidoCotacao1  $idPedidoCompra1 $querydatacadastro $querydatacompra ORDER BY distribuir_os.idOs asc
        ";
       
       
        
        return $this->db->count_all();
       
    }
	function getdistribuidor($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array')
	 {
          
        $this->db->select('distribuir_os.idDistribuir,
distribuir_os.idOs,
distribuir_os.quantidade,
distribuir_os.dimensoes,
pedido_comprasitens.valor_total,
distribuir_os.data_cadastro as data_dist,
pedido_comprasitens.previsao_entrega,
distribuir_os.obs,
pedido_cotacaoitens.data_cadastro,
pedido_compras.data_cadastro as cadpedgerado,
fornecedores.nomeFornecedor,
pedido_comprasitens.notafiscal,
pedido_comprasitens.desconto,
pedido_compras.frete,
pedido_comprasitens.outros,
status_grupo_compra.nomegrupo,
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
  $this->db->join('insumos', 'insumos.idInsumos = distribuir_os.idInsumos');   
    $this->db->join('status_grupo_compra', 'status_grupo_compra.idgrupo = distribuir_os.id_status_grupo');   
    $this->db->join('statuscompras', 'statuscompras.idStatuscompras = distribuir_os.idStatuscompras');        
 $this->db->join('pedido_cotacaoitens', 'pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir', 'left');
 $this->db->join('pedido_cotacao', 'pedido_cotacao.idPedidoCotacao = pedido_cotacaoitens.idPedidoCotacao', 'left');
  $this->db->join('pedido_comprasitens', 'pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens', 'left');
  $this->db->join('pedido_compras', 'pedido_cotacaoitens.idPedidoCompra = pedido_compras.idPedidoCompra', 'left');
 
 $this->db->join('fornecedores', 'fornecedores.idFornecedores = pedido_compras.idFornecedores', 'left');
    
        $this->db->order_by($table.'.idOs','asc');
        $this->db->limit($perpage,$start);
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
	
	public function tabela($table,$where)
	{
	  $this->db->from($table);
	 $this->db->where($where);
	  $query = $this->db->get();
	  $result = $query->result();
	 return $result;
	 
	}
	 
	public function getWhereLikeos2($cod_orc = '',$referencia = '',$num_pedido = '',$num_nf = '' ,$querydatacadastro = '',$query_statusorc = '',$query_clientes = '',$query_idGrupoServico = '',$query_idNatOperacao = '',$query_idstatusOrcamento = '',$idProdutos = '',$query_clientes3 = '' )
    {
		if($idProdutos <> '')
		{
			$queryitem = 1;
			$idProdutos1 = " and produtos.idProdutos = ".$idProdutos;
		}
		else
		{
			$queryitem = 0;
			$idProdutos1 = '';
		}
		if($query_idstatusOrcamento <> '')
		{
			$query_idstatusOrcamento1 = " and status_orcamento.idstatusOrcamento in ".$query_idstatusOrcamento;
		}
		else
		{
			$query_idstatusOrcamento1 = '';
		}
		if($query_idNatOperacao <> '')
		{
			$query_idNatOperacao1 = " and orcamento.idNatOperacao in ".$query_idNatOperacao;
		}
		else
		{
			$query_idNatOperacao1 = '';
		}
		
		if($query_idGrupoServico <> '')
		{
			$query_idGrupoServico1 = " and orcamento.idGrupoServico in ".$query_idGrupoServico;
		}
		else
		{
			$query_idGrupoServico1 = '';
		}
		
		if($query_clientes <> '')
		{
			$query_clientes1 = " and clientes.idClientes in ".$query_clientes;
		}
		else
		{
			$query_clientes1 = '';
		}
		
		
		
		if($querydatacadastro <> '')
		{
			$querydatacadastro1 = $querydatacadastro;
		}
		else
		{
			$querydatacadastro1 = '';
		}
		
		
		if($query_statusorc <> '')
		{
			$query_statusorc1 = " and orcamento.idstatusOrcamento in ".$query_statusorc;
		}
		else
		{
			$query_statusorc1 = '';
		}
		
		
		
		
		if($cod_orc <> '')
		{
			$cod_orc1 = " and orcamento.idOrcamentos in ( ".$cod_orc.")";
		}
		else
		{
			$cod_orc1 = '';
		}
		
		
		
		if($num_pedido <> '')
		{
			 $num_pedido1 = " and orcamento.num_pedido like '%".$num_pedido."%'";
		}
		else
		{
			$num_pedido1 = '';
		}
		if($num_nf <> '')
		{
			 $num_nf1 = " and orcamento.num_nf in ( ".$num_nf.")";
		}
		else
		{
			$num_nf1 = '';
		}
		if($referencia <> '')
		{
			 $referencia1 = " and orcamento.referencia like '% ".$referencia."%'";
		}
		else
		{
			$referencia1 = '';
		}
		
		 if($queryitem == 0)
		 {
		$query = " SELECT orcamento.idOrcamentos,orcamento.data_abertura,orcamento.validade,clientes.nomeCliente,vendedores.nomeVendedor,motivo_orcamento.motivo, status_orcamento.nome_status_orc,NatOperacao.nome as nomenat, grupo_servico.nome as nomeserv FROM (`orcamento`) JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `NatOperacao` ON `NatOperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` left join motivo_orcamento on motivo_orcamento.idMotivo = orcamento.idMotivo where 1=1 $query_idNatOperacao1 $query_idGrupoServico1 $query_clientes1 $querydatacadastro1 $query_statusorc1 $cod_orc1 $num_pedido1 $num_nf1 $referencia1 $query_idstatusOrcamento1 $idProdutos1 $query_clientes3 order by orcamento.`idOrcamentos`";
		 }
		 else
		 {
			 
         
        $query = "
           SELECT orcamento.idOrcamentos,orcamento.data_abertura,orcamento.validade,clientes.nomeCliente,vendedores.nomeVendedor,motivo_orcamento.motivo, status_orcamento.nome_status_orc,NatOperacao.nome as nomenat, grupo_servico.nome as nomeserv FROM (`orcamento`) join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos  JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `NatOperacao` ON `NatOperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos left join motivo_orcamento on motivo_orcamento.idMotivo = orcamento.idMotivo where 1=1 $query_idNatOperacao1 $query_idGrupoServico1 $query_clientes1 $querydatacadastro1 $query_statusorc1 $cod_orc1 $num_pedido1 $num_nf1 $referencia1 $query_idstatusOrcamento1 $query_clientes3 order by orcamento.`idOrcamentos`
        ";
		 }
         
        /*$query = "
         SELECT orcamento_item.valor_total,orcamento_item.descricao_item, natoperacao.nome as nomenat,grupo_servico.nome as nomeserv,status_orcamento.nome_status_orc, motivo_orcamento.motivo, orcamento.`idOrcamentos`,orcamento.data_abertura, orcamento.validade,clientes.nomeCliente, emitente.nome,vendedores.nomeVendedor FROM (`orcamento`) JOIN orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos JOIN vendedores ON orcamento.idVendedor = vendedores.idVendedor JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` join status_orcamento on status_orcamento.idstatusOrcamento = orcamento.idstatusOrcamento join natoperacao on natoperacao.idNatOperacao = orcamento.idNatOperacao join grupo_servico on grupo_servico.idGrupoServico = orcamento.idGrupoServico left join motivo_orcamento on motivo_orcamento.idMotivo = orcamento.idMotivo where 1=1  $query_idNatOperacao1 $query_idGrupoServico1 $query_clientes1 $querydatacadastro1 $query_statusorc1 $cod_orc1 $num_pedido1 $num_nf1 $referencia1 $query_idstatusOrcamento1 order by orcamento.`idOrcamentos` 
        ";
		$query = "
         SELECT natoperacao.nome as nomenat,grupo_servico.nome as nomeserv,status_orcamento.nome_status_orc, motivo_orcamento.motivo, orcamento.`idOrcamentos`,orcamento.data_abertura, orcamento.validade,clientes.nomeCliente, emitente.nome,vendedores.nomeVendedor FROM (`orcamento`) join  vendedores ON orcamento.idVendedor = vendedores.idVendedor JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` join status_orcamento on status_orcamento.idstatusOrcamento = orcamento.idstatusOrcamento join natoperacao on natoperacao.idNatOperacao = orcamento.idNatOperacao join grupo_servico on grupo_servico.idGrupoServico = orcamento.idGrupoServico left join motivo_orcamento on motivo_orcamento.idMotivo = orcamento.idMotivo where 1=1  $query_idNatOperacao1 $query_idGrupoServico1 $query_clientes1 $querydatacadastro1 $query_statusorc1 $cod_orc1 $num_pedido1 $num_nf1 $referencia1 $query_idstatusOrcamento1 order by orcamento.`idOrcamentos` 
        ";*/
        
        return $this->db->query($query)->result();
       
    }
	public function getWhereLikeos_status($cod_orc = '',$referencia = '',$num_pedido = '',$num_nf = '' ,$querydatacadastro = '',$query_statusorc = '',$query_clientes = '',$query_idGrupoServico = '',$query_idNatOperacao = '',$query_idstatusOrcamento = '', $idProdutos = '')
    {
		if($idProdutos <> '')
		{
			$queryitem = 1;
			$idProdutos1 = " and produtos.idProdutos = ".$idProdutos;
		}
		else
		{
			$queryitem = 0;
			$idProdutos1 = '';
		}
		if($query_idstatusOrcamento <> '')
		{
			$query_idstatusOrcamento1 = " and status_orcamento.idstatusOrcamento in ".$query_idstatusOrcamento;
		}
		else
		{
			$query_idstatusOrcamento1 = '';
		}
		if($query_idNatOperacao <> '')
		{
			$query_idNatOperacao1 = " and orcamento.idNatOperacao in ".$query_idNatOperacao;
		}
		else
		{
			$query_idNatOperacao1 = '';
		}
		
		if($query_idGrupoServico <> '')
		{
			$query_idGrupoServico1 = " and orcamento.idGrupoServico in ".$query_idGrupoServico;
		}
		else
		{
			$query_idGrupoServico1 = '';
		}
		
		if($query_clientes <> '')
		{
			$query_clientes1 = " and clientes.idClientes in ".$query_clientes;
		}
		else
		{
			$query_clientes1 = '';
		}
		
		
		
		if($querydatacadastro <> '')
		{
			$querydatacadastro1 = $querydatacadastro;
		}
		else
		{
			$querydatacadastro1 = '';
		}
		
		
		if($query_statusorc <> '')
		{
			$query_statusorc1 = " and orcamento.idstatusOrcamento in ".$query_statusorc;
		}
		else
		{
			$query_statusorc1 = '';
		}
		
		
		
		
		if($cod_orc <> '')
		{
			$cod_orc1 = " and orcamento.idOrcamentos in(".$cod_orc.")";
		}
		else
		{
			$cod_orc1 = '';
		}
		
		
		
		if($num_pedido <> '')
		{
			 $num_pedido1 = " and orcamento.num_pedido like '%".$num_pedido."%'";
		}
		else
		{
			$num_pedido1 = '';
		}
		if($num_nf <> '')
		{
			 $num_nf1 = " and orcamento.num_nf in( ".$num_nf.')';
		}
		else
		{
			$num_nf1 = '';
		}
		if($referencia <> '')
		{
			 $referencia1 = " and orcamento.referencia like '% ".$referencia."%'";
		}
		else
		{
			$referencia1 = '';
		}
		
		 if($queryitem == 0)
		 {
		$query = " SELECT orcamento.idOrcamentos,orcamento.data_abertura,orcamento.validade,clientes.nomeCliente,vendedores.nomeVendedor,motivo_orcamento.motivo, status_orcamento.nome_status_orc,NatOperacao.nome as nomenat, grupo_servico.nome as nomeserv FROM (`orcamento`) JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `NatOperacao` ON `NatOperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` left join motivo_orcamento on motivo_orcamento.idMotivo = orcamento.idMotivo where 1=1 $query_idNatOperacao1 $query_idGrupoServico1 $query_clientes1 $querydatacadastro1 $query_statusorc1 $cod_orc1 $num_pedido1 $num_nf1 $referencia1 $query_idstatusOrcamento1 $idProdutos1 order by orcamento.`idOrcamentos`";
		 }
		 else
		 {
			 
         
        $query = "
           SELECT orcamento.idOrcamentos,orcamento.data_abertura,orcamento.validade,clientes.nomeCliente,vendedores.nomeVendedor,motivo_orcamento.motivo, status_orcamento.nome_status_orc,NatOperacao.nome as nomenat, grupo_servico.nome as nomeserv FROM (`orcamento`) join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos  JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `NatOperacao` ON `NatOperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos left join motivo_orcamento on motivo_orcamento.idMotivo = orcamento.idMotivo where 1=1 $query_idNatOperacao1 $query_idGrupoServico1 $query_clientes1 $querydatacadastro1 $query_statusorc1 $cod_orc1 $num_pedido1 $num_nf1 $referencia1 $query_idstatusOrcamento1 order by orcamento.`idOrcamentos`
        ";
		 }
        /* 
        $query = "
         SELECT  natoperacao.nome as nomenat,grupo_servico.nome as nomeserv,status_orcamento.nome_status_orc, motivo_orcamento.motivo, orcamento.`idOrcamentos`,orcamento.data_abertura, orcamento.validade,clientes.nomeCliente, emitente.nome,vendedores.nomeVendedor FROM (`orcamento`) JOIN vendedores ON orcamento.idVendedor = vendedores.idVendedor JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` join status_orcamento on status_orcamento.idstatusOrcamento = orcamento.idstatusOrcamento join natoperacao on natoperacao.idNatOperacao = orcamento.idNatOperacao join grupo_servico on grupo_servico.idGrupoServico = orcamento.idGrupoServico left join motivo_orcamento on motivo_orcamento.idMotivo = orcamento.idMotivo where 1=1  $query_idNatOperacao1 $query_idGrupoServico1 $query_clientes1 $querydatacadastro1 $query_statusorc1 $cod_orc1 $num_pedido1 $num_nf1 $referencia1 $query_idstatusOrcamento1 group by status_orcamento.idstatusOrcamento order by status_orcamento.`nome_status_orc` 
        ";*/
        
        return $this->db->query($query)->result();
       
    }
	
	
	public function numrowsWhereLikeos2($cod_orc = '',$referencia = '',$num_pedido = '',$num_nf = '' ,$querydatacadastro = '',$query_statusorc = '',$query_clientes = '',$query_idGrupoServico = '',$query_idNatOperacao = '',$query_idstatusOrcamento = '',$idProdutos = '')
    {
		if($idProdutos <> '')
		{
			$queryitem = 1;
			$idProdutos1 = " and produtos.idProdutos = ".$idProdutos;
		}
		else
		{
			$queryitem = 0;
			$idProdutos1 = '';
		}
		if($query_idstatusOrcamento <> '')
		{
			$query_idstatusOrcamento1 = " and status_orcamento.idstatusOrcamento in ".$query_idstatusOrcamento;
		}
		else
		{
			$query_idstatusOrcamento1 = '';
		}
		if($query_idNatOperacao <> '')
		{
			$query_idNatOperacao1 = " and orcamento.idNatOperacao in ".$query_idNatOperacao;
		}
		else
		{
			$query_idNatOperacao1 = '';
		}
		
		if($query_idGrupoServico <> '')
		{
			$query_idGrupoServico1 = " and orcamento.idGrupoServico in ".$query_idGrupoServico;
		}
		else
		{
			$query_idGrupoServico1 = '';
		}
		
		if($query_clientes <> '')
		{
			$query_clientes1 = " and clientes.idClientes in ".$query_clientes;
		}
		else
		{
			$query_clientes1 = '';
		}
		
		
		
		if($querydatacadastro <> '')
		{
			$querydatacadastro1 = $querydatacadastro;
		}
		else
		{
			$querydatacadastro1 = '';
		}
		
		
		if($query_statusorc <> '')
		{
			$query_statusorc1 = " and orcamento.idstatusOrcamento in ".$query_statusorc;
		}
		else
		{
			$query_statusorc1 = '';
		}
		
		
		
		
		if($cod_orc <> '')
		{
			$cod_orc1 = " and orcamento.idOrcamentos = ".$cod_orc;
		}
		else
		{
			$cod_orc1 = '';
		}
		
		
		
		if($num_pedido <> '')
		{
			 $num_pedido1 = " and orcamento.num_pedido = ".$num_pedido;
		}
		else
		{
			$num_pedido1 = '';
		}
		if($num_nf <> '')
		{
			 $num_nf1 = " and orcamento.num_nf = ".$num_nf;
		}
		else
		{
			$num_nf1 = '';
		}
		if($referencia <> '')
		{
			 $referencia1 = " and orcamento.referencia = ".$referencia;
		}
		else
		{
			$referencia1 = '';
		}
		
		 if($queryitem == 0)
		 {
		$query = " SELECT orcamento.idOrcamentos,orcamento.data_abertura,orcamento.validade,clientes.nomeCliente,vendedores.nomeVendedor,motivo_orcamento.motivo, status_orcamento.nome_status_orc,NatOperacao.nome as nomenat, grupo_servico.nome as nomeserv FROM (`orcamento`) JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `NatOperacao` ON `NatOperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` left join motivo_orcamento on motivo_orcamento.idMotivo = orcamento.idMotivo where 1=1 $query_idNatOperacao1 $query_idGrupoServico1 $query_clientes1 $querydatacadastro1 $query_statusorc1 $cod_orc1 $num_pedido1 $num_nf1 $referencia1 $query_idstatusOrcamento1 $idProdutos1 order by orcamento.`idOrcamentos`";
		 }
		 else
		 {
			 
         
        $query = "
           SELECT orcamento.idOrcamentos,orcamento.data_abertura,orcamento.validade,clientes.nomeCliente,vendedores.nomeVendedor,motivo_orcamento.motivo, status_orcamento.nome_status_orc,NatOperacao.nome as nomenat, grupo_servico.nome as nomeserv FROM (`orcamento`) join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos  JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `NatOperacao` ON `NatOperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos left join motivo_orcamento on motivo_orcamento.idMotivo = orcamento.idMotivo where 1=1 $query_idNatOperacao1 $query_idGrupoServico1 $query_clientes1 $querydatacadastro1 $query_statusorc1 $cod_orc1 $num_pedido1 $num_nf1 $referencia1 $query_idstatusOrcamento1 order by orcamento.`idOrcamentos`
        ";
		 }
         
       /* $query = "
         SELECT  natoperacao.nome as nomenat,grupo_servico.nome as nomeserv,,status_orcamento.nome_status_orc, motivo_orcamento.motivo, orcamento.`idOrcamentos`,orcamento.data_abertura, orcamento.validade,clientes.nomeCliente, emitente.nome,vendedores.nomeVendedor FROM (`orcamento`) JOIN vendedores ON orcamento.idVendedor = vendedores.idVendedor JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` join status_orcamento on status_orcamento.idstatusOrcamento = orcamento.idstatusOrcamento join natoperacao on natoperacao.idNatOperacao = orcamento.idNatOperacao join grupo_servico on grupo_servico.idGrupoServico = orcamento.idGrupoServico left join motivo_orcamento on motivo_orcamento.idMotivo = orcamento.idMotivo where 1=1  $query_idNatOperacao1 $query_idGrupoServico1 $query_clientes1 $querydatacadastro1 $query_statusorc1 $cod_orc1 $num_pedido1 $num_nf1 $referencia1 $query_idstatusOrcamento1 order by orcamento.`idOrcamentos` 
        ";
        */
        return $this->db->count_all();
       
    }
	
	function getos($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array')
	 {
		
        
        $this->db->select($fields);
        $this->db->from($table);
       
        //$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = '.$table.'.idOrcamentos');
        $this->db->join('vendedores', 'vendedores.idVendedor = '.$table.'.idVendedor');
        $this->db->join('status_orcamento', 'status_orcamento.idstatusOrcamento = '.$table.'.idstatusOrcamento');
        $this->db->join('emitente', 'emitente.id = orcamento.idEmitente');
		$this->db->join('NatOperacao', 'NatOperacao.idNatOperacao = orcamento.idNatOperacao');
        $this->db->join('grupo_servico', 'grupo_servico.idGrupoServico = orcamento.idGrupoServico');
        $this->db->join('clientes', 'clientes.idClientes = orcamento.idClientes');
		
      
        $this->db->join('motivo_orcamento', 'motivo_orcamento.idMotivo = orcamento.idMotivo','left');
       
        
		
		
		
        $this->db->order_by($table.'.idOrcamentos');
        $this->db->limit($perpage,$start);
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
		
       
		
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
	function getos2($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array')
	 {
		
        
        $this->db->select($fields);
        $this->db->from($table);
       
        //$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = '.$table.'.idOrcamentos');
        $this->db->join('vendedores', 'vendedores.idVendedor = '.$table.'.idVendedor');
        $this->db->join('status_orcamento', 'status_orcamento.idstatusOrcamento = '.$table.'.idstatusOrcamento');
        $this->db->join('emitente', 'emitente.id = orcamento.idEmitente');
		$this->db->join('NatOperacao', 'NatOperacao.idNatOperacao = orcamento.idNatOperacao');
        $this->db->join('grupo_servico', 'grupo_servico.idGrupoServico = orcamento.idGrupoServico');
        $this->db->join('clientes', 'clientes.idClientes = orcamento.idClientes');
		
      
        $this->db->join('motivo_orcamento', 'motivo_orcamento.idMotivo = orcamento.idMotivo','left');
       
        
		
		
		
        $this->db->order_by($table.'.idOrcamentos');
        $this->db->limit(100);
             
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
distribuir_os.quantidade,
distribuir_os.dimensoes,
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
      
 $this->db->join('pedido_cotacaoitens', 'pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir', 'left');
 $this->db->join('pedido_compras', 'pedido_cotacaoitens.idPedidoCompra = pedido_compras.idPedidoCompra', 'left');
 $this->db->join('pedido_comprasitens', 'pedido_cotacaoitens.idCotacaoItens = pedido_comprasitens.idCotacaoItens', 'left');
 $this->db->join('fornecedores', 'fornecedores.idFornecedores = pedido_compras.idFornecedores', 'left');
    $this->db->join('insumos', 'insumos.idInsumos = distribuir_os.idInsumos');   
    $this->db->join('statuscompras', 'statuscompras.idStatuscompras = distribuir_os.idStatuscompras');   
        $this->db->order_by($table.'.idOs','asc');
       
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
       
		
		
      
        return $query->result();
    }

	function relatorioComprasMelhorado($select = '',$groupby = '',$where = ''){
		$query = "SELECT $select sum((pedido_comprasitens.ipi_valor/100)*(pedido_comprasitens.valor_unitario*pedido_comprasitens.quantidade)) as 'IPI',sum(pedido_comprasitens.icms) as 'ICMS',sum(pedido_comprasitens.valor_unitario*pedido_comprasitens.quantidade) as 'Total das compras realizadas' 
		FROM `distribuir_os` 
		left join insumos on insumos.idInsumos = distribuir_os.idInsumos 
		left join subcategoriaInsumo on subcategoriaInsumo.idSubcategoria = insumos.idSubcategoria 
		left join categoriaInsumos on categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria
		join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os.id_status_grupo 
		join os on os.idOs = distribuir_os.idOs 
		join orcamento on orcamento.idOrcamentos = os.idOrcamentos 
		join clientes on clientes.idClientes = orcamento.idClientes 
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
		join pedido_compras on pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra 
		join fornecedores on fornecedores.idFornecedores = pedido_compras.idFornecedores where distribuir_os.idStatuscompras in (1,2,3,4,5,6,7,8,9,10) $where $groupby";
		return $this->db->query($query)->result();
	}
	
	
	
	function relatorioEdivan($inicio,$fim){
		$query = "SELECT os.idOs, 
			sum(orcamento_item.qtd*orcamento_item.val_unit) as valorOrc, 
			sum(os.qtd_os*os.val_unit_os) as valorOS, 
			(SELECT sum(pedido_comprasitens.valor_unitario*distribuir_os.quantidade) 
				FROM `distribuir_os` 
				join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
				join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens 
				where distribuir_os.idOs = os.idOs) as valorInsumos 
			FROM `os` 
			join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
			WHERE idStatusOs = 6 and IF(os.data_nf_faturamento is not null and os.data_nf_faturamento != '',os.data_nf_faturamento BETWEEN '$inicio' and '$fim',IF(os.data_reagendada is null or os.data_reagendada = '',os.data_entrega BETWEEN '$inicio' and '$fim',os.data_reagendada BETWEEN '$inicio' and '$fim')) GROUP BY os.idOs";
		return $this->db->query($query)->result();
	}

	function relatorioBacklogPCP ($where = ''){
		$query = "SELECT distribuir_os.idDistribuir,
		distribuir_os.idOs,
		distribuir_os.quantidade,
		distribuir_os.data_reagendada,
		distribuir_os.ultJustificativa,
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
		join usuarios on usuarios.idUsuarios = distribuir_os.usuario_cadastro where 1 = 1 $where";
		return $this->db->query($query)->result();
	}
}