<?php
class Os_model extends CI_Model {

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
	 public function get_item($item)
    {
		 
		$this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
		$this->db->where('orcamento_item.idOrcamento_item',$item);
        return $this->db->get('orcamento_item')->result();
       
    }
	 function getstatus_grupo()
    {
	$this->db->order_by('nomegrupo','asc');
		
        
		
        return $this->db->get('status_grupo_compra')->result();
		
		
    }
	
public function getObsHistoryByIdOs($idOs) {
    $this->db->select('os_history.idOsHis, os_history.idUserHis, os_history.data_alteracaoHis, os_history.obs_os, usuarios.nome');
    $this->db->from('os_history');
    $this->db->join('usuarios', 'usuarios.idUsuarios = os_history.idUserHis', 'left');
    $this->db->where('os_history.idOs', $idOs);
    $this->db->where('os_history.obs_os IS NOT NULL'); // Exclui valores nulos
    $this->db->where('os_history.obs_os !=', ''); // Exclui valores vazios
    $this->db->order_by('os_history.data_alteracaoHis', 'DESC'); // Ordena do mais recente para o mais antigo
    return $this->db->get()->result();
}

	
	public function OSCustom($idOs){
		$idOs = (int)$idOs;
		$query = "SELECT emitente.url_logo as url_logoemi, emitente.imagem as imagememi,emitente.nome as nomeemi, clientes.idClientes as idcli, clientes.nomeCliente as nomecli , produtos.idProdutos,os.idSimplexAtividade , produtos.descricao , produtos.pn , orcamento_item.detalhe,grupo_servico.nome as grupo,status_os.nomeStatusOs,os.obs_os,os.numpedido_os,os.tag,os.obsDesenho,os.obs_controle,unidade_execucao.status_execucao, unidade_faturamento.status_faturamento, os_tipo.nome_tipo, os.`idOs`, os.`data_abertura`,os.`data_entrega`,os.`data_expedicao`,os.`data_canhoto`,os.`idStatusOs`,os.`data_reagendada`,os.`data_planejada`,os.`tiposervico`,os.`idOrcamentos`, os.qtd_os,orcamento_item.descricao_item,(SELECT anexo_desenho.idAnexo from anexo_desenho where anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue FROM (`os`)
			join orcamento on orcamento.idOrcamentos = os.idOrcamentos
			JOIN orcamento_item ON orcamento_item.idOrcamento_item = os.idOrcamento_item
			JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos
			JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente`
			JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes`
			JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico`
			JOIN `status_os` ON `status_os`.`idStatusOs` = `os`.`idStatusOs`
			left join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
			left join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento left join os_tipo on os_tipo.id_tipo = os.id_tipo left join anexo_desenho on anexo_desenho.idOs = os.idOs where os.idOs = ? group by anexo_desenho.idOs";

        return $this->db->query($query, array($idOs))->result();
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
	public function getStatusOs()
    {
        $this->db->order_by('nomeStatusOs','asc');
        return $this->db->get('status_os')->result();
       
    }
	 public function get_table($table)
    {
		 return $this->db->get($table)->result();
	 }
	public function getdesenho_os($id)
    {
		$id = (int)$id;
	 	$query = "SELECT * FROM `anexo_desenho`, usuarios WHERE `user_proprietario` = idUsuarios and `idOs` = ?";
        return $this->db->query($query, array($id))->result();
    }
	public function getdesenho_os2($id){
		$id = (int)$id;
	 	$query = "SELECT * FROM `os`
			join anexo_desenho on anexo_desenho.idOs = os.idOs or anexo_desenho.idOrcamentos_item = os.idOrcamento_item
			join usuarios on usuarios.idUsuarios = anexo_desenho.user_proprietario
			WHERE os.idOs = ? and (anexo_desenho.statusAnexo = 2 or anexo_desenho.statusAnexo is null) group by anexo_desenho.imagem";
        return $this->db->query($query, array($id))->result();
    }
	public function getnf_os($id,$table){
		$this->db->where('idOs',$id);
		return $this->db->get($table)->result();
    }
	function getByid_table($id,$table,$campo){
        $this->db->where($campo,$id);
        $this->db->limit(1);
        return $this->db->get($table)->row();
    }
	function getByid_table_in($id,$table,$campo){
        $this->db->select('data_reagendada');
        $this->db->where($campo,$id);
        
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

		$q_escaped = '%' . $this->db->escape_like_str($q) . '%';
		$query2 = 'SELECT insumos.*, (select SUM(quantidade) from almo_estoque where almo_estoque.idProduto = insumos.idInsumos and almo_estoque.idEmitente = 1 ) as qtdEst FROM `insumos` where insumos.descricaoInsumo like ?';
        $query = $this->db->query($query2, array($q_escaped))->result();

        
        if(count($query) > 0){
			 
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->descricaoInsumo.' | ID: '.$row->idInsumos,'id'=>$row->idInsumos, 'estoque'=>$row->qtdEst );
            }
			
            echo json_encode($row_set);
        }
    }
	public function autoCompleteDistribuir2($q){

		$q_escaped = '%' . $this->db->escape_like_str($q) . '%';
		$query2 = 'SELECT insumos.*, (select SUM(quantidade) from almo_estoque where almo_estoque.idProduto = insumos.idInsumos and quantidade >0) as qtdEst FROM `insumos` where insumos.descricaoInsumo like ?';
        $query = $this->db->query($query2, array($q_escaped))->result();

        
        if(count($query) > 0){
			 
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->descricaoInsumo,'id'=>$row->idInsumos, 'estoque'=>$row->qtdEst );
            }
			
            echo json_encode($row_set);
        }
    }
	
	
	public function autoCompleteMaquina($u){

        $this->db->select('*');
        //$this->db->limit(10);
        $this->db->like('nome', $u);
        $query = $this->db->get('maquinas');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome'].' | ID: '.$row['idMaquinas'],'id'=>$row['idMaquinas'] );
            }
			
            echo json_encode($row_set);
        }
    }
	
	public function autoCompleteMaquinauser($q){

        $this->db->select('*');
        //$this->db->limit(10);
        $this->db->like('nome_UserMaquinas', $q);
        $query = $this->db->get('maquinasusuarios');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome_UserMaquinas'].' | ID: '.$row['idUserMaquinas'],'id'=>$row['idUserMaquinas'] );
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
public function getmaterial_dist($id, $ordertipo = '', $campo = '', $limit = '', $where = '')
	{
		$this->db->select('
			insumos.*,
			distribuir_os.*,
			distribuir_os.tipo_compra,
			distribuir_os.comprimento,
			distribuir_os.dimensoes,
			distribuir_os.metrica,
			distribuir_os.volume,
			distribuir_os.peso,
			distribuir_os.dimensoesL,
			distribuir_os.dimensoesA,
			distribuir_os.dimensoesC,
			distribuir_os.data_cadastro as datacadastro,
			userORc.nome as nomeUserOrc,
			produtos.*,
			status_grupo_compra.*,
			
			pedido_comprasitens.previsao_entrega,
			pedido_comprasitens.valor_unitario,
			pedido_comprasitens.valor_total,
			pedido_comprasitens.ipi_valor,
			pedido_comprasitens.icms,
			pedido_comprasitens.outros,
			pedido_comprasitens.desconto,
			pedido_comprasitens.idPedidoCompra,
			
			pedido_compras.frete,

			usuarios.*,
			statuscompras.*
		');
		
		$this->db->from('distribuir_os');
		$this->db->join('insumos', 'insumos.idInsumos = distribuir_os.idInsumos');
		$this->db->join('produtos', 'produtos.idProdutos = distribuir_os.idProdutos', 'left');
		$this->db->join('status_grupo_compra', 'status_grupo_compra.idgrupo = distribuir_os.id_status_grupo', 'left');
		
		$this->db->join('pedido_cotacaoitens', 'pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir', 'left');
		$this->db->join('pedido_comprasitens', 'pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens', 'left');
		
		$this->db->join('pedido_compras', 'pedido_compras.idPedidoCompra = pedido_comprasitens.idPedidoCompra', 'left');

		$this->db->join('usuarios', 'usuarios.idUsuarios = distribuir_os.usuario_cadastro', 'left');
		$this->db->join('usuarios userORc', 'userORc.idUsuarios = distribuir_os.idUser_aguardandoOrc', 'left');
		$this->db->join('statuscompras', 'statuscompras.idStatuscompras = distribuir_os.idStatuscompras');

		if (!empty($where)) {
			$where = $where . ' and distribuir_os.idOs = ' . (int)$id;
		} else {
			$where = 'distribuir_os.idOs = ' . (int)$id;
		}
		
		$this->db->where($where);
		
		if (!empty($limit)) {
			$this->db->limit(150);
		}
		
		if (!empty($ordertipo) && !empty($campo)) {
			$this->db->order_by($campo, $ordertipo);
		}
		
		return $this->db->get()->result();
	}
	public function calculadif($hora_inicial, $hora_final) {
		$i = 1;
		//$tempo_total;

		$tempos = array($hora_final, $hora_inicial);

		foreach($tempos as $tempo) {
			$segundos = 0;

			list($h, $m, $s) = explode(':', $tempo);

			$segundos += $h * 3600;
			$segundos += $m * 60;
			$segundos += $s;

			$tempo_total[$i] = $segundos;

			$i++;
		}
		$segundos = $tempo_total[1] - $tempo_total[2];

		$horas = floor($segundos / 3600);
		$segundos -= $horas * 3600;
		$minutos = str_pad((floor($segundos / 60)), 2, '0', STR_PAD_LEFT);
		$segundos -= $minutos * 60;
		$segundos = str_pad($segundos, 2, '0', STR_PAD_LEFT);


		return $horas.":".$minutos.":".$segundos;
	}
	public function gethoramaquina($id){
		$id = (int)$id;
       $query = "
          SELECT horasmaquinas.idHoramaquinas, horasmaquinas.`obs`, horasmaquinas.`horainicio`, horasmaquinas.`horafim`, maquinas.nome, maquinasusuarios.nome_UserMaquinas FROM `horasmaquinas`,  maquinas, maquinasusuarios WHERE horasmaquinas.`idMaquinas` = 	maquinas.idMaquinas and horasmaquinas.`idUserMaquinas` = maquinasusuarios.idUserMaquinas and horasmaquinas.idos = ?
        ";

        return $this->db->query($query, array($id))->result();
    }
 	public function getitemcompra($id)
    {
		
		
		
		
		$this->db->where('idDistribuir',$id);
        
        return $this->db->get('pedido_comprasitens')->result();
       
    }
	public function getitemcotacaoitem($id)
    {
		
		
		$this->db->where('idDistribuir',$id);
        
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
        $id = $this->db->insert_id();   
        $this->histAlteracaoAdd($table,$id);     
        if ($this->db->affected_rows() == '1')
		{
            if($returnId == true){
                return $id;
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
	function getos($table,$fields,$where='',$tipo = '',$perpage=0,$start=0,$one=false,$array='array')
	{
		if($tipo == 'c')
		{
			$order = "asc";
		}
		else
		{
			$order = "desc";
		}        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->join('orcamento_item', 'orcamento_item.idOrcamento_item = '.$table.'.idOrcamento_item');
        $this->db->join('orcamento', 'orcamento.idOrcamentos = '.$table.'.idOrcamentos');
        $this->db->join('vendedores', 'vendedores.idVendedor = orcamento.idVendedor');
        $this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
        $this->db->join('emitente', 'emitente.id = orcamento.idEmitente');
        $this->db->join('clientes', 'clientes.idClientes = orcamento.idClientes');
        $this->db->join('status_os', 'status_os.idStatusOs = os.idStatusOs');
		$this->db->join('verificacao_controle', 'verificacao_controle.idVerificacaoControle = os.idVerificacaoControle','left');
        $this->db->join('unidade_execucao', 'unidade_execucao.id_unid_exec = os.unid_execucao','left');
		$this->db->join('anexo_desenho', 'anexo_desenho.idOs = os.idOs','left');
		$this->db->join('grupo_servico', 'grupo_servico.idGrupoServico = orcamento.idGrupoServico','left');
        $this->db->join('unidade_faturamento', 'unidade_faturamento.id_unid_fat = os.unid_faturamento','left');
        $this->db->join('os_tipo', 'os_tipo.id_tipo = os.id_tipo','left');
        $this->db->join('tipo_qtd', 'tipo_qtd.idTipoQtd = orcamento_item.idTipoQtd','left');
		$this->db->join('orc_servico_escopo', 'orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item and orc_servico_escopo.ativo=1','left');
		$this->db->join('status_escopo', 'status_escopo.idStatusEscopo = orc_servico_escopo.idStatusEscopo','left');
		$this->db->join('anexo_nfcliente', 'anexo_nfcliente.idOs = os.idOs','left');
        $this->db->order_by($table.'.idOs',$order);
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
		$this->db->group_by("os.idOs");
        $query = $this->db->get();
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
	
	
	function getos2($perpage = 5, $start = 0, $where = '') // $where recebe o $filtro_padrao_where
	{
        // --- CORREÇÃO APLICADA AQUI ---
        // Adiciona "AND" na frente da condição $where apenas se ela não estiver vazia.
        $where_condition = '';
        if (!empty(trim($where))) {
            // Garante que não haja múltiplos ANDs caso $where já comece com um (pouco provável aqui, mas seguro)
            $where_clean = ltrim(trim($where), 'AND');
            $where_condition = " AND " . $where_clean;
        }
        // --- FIM DA CORREÇÃO ---

        // A query agora usa $where_condition que já tem o AND (se necessário)
		$query = "
		SELECT os.data_abertura_real,
		os.data_insert,
		verificacao_controle.descricaoControle,
		verificacao_controle.idVerificacaoControle,
		os.numpedido_os,
		os.val_ipi_os,os.tag,
		os.idOs,
		os.`data_abertura`,
		os.`data_entrega`,os.`data_expedicao`,os.`data_canhoto`,
		os.`data_reagendada`,
		os.`data_planejada`,
		os.statusDesenho,
		os.obsDesenho,
		os.nf_venda_dev,
		os.numero_nf,
		os.nf_venda_dev,
		os.nf_canhoto,
		os.`idOrcamentos`,
		clientes.nomeCliente,
		produtos.pn,
		orcamento_item.descricao_item,
		os.qtd_os,
		os.val_unit_os,
		grupo_servico.idGrupoServico,
		tipo_qtd.descricaoTipoQtd,
		os.desconto_os,
		os.subtot_os,
		status_peritagem.descricaoPeritagem,
		(SELECT anexo_desenho.idAnexo from anexo_desenho where anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue,
		unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,
		os_tipo.nome_tipo,status_os.nomeStatusOs, emitente.nome, nf_cliente, nomeArquivo,
		vendedores.nomeVendedor,
		status_escopo.descricaoEscopo
		FROM (`os`)
		JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item
		JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos
		JOIN grupo_servico on grupo_servico.idGrupoServico = orcamento.idGrupoServico
		JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente`
		JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes`
		JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos
		JOIN vendedores on vendedores.idVendedor = orcamento.idVendedor
		join status_os on status_os.idStatusOs = os.idStatusOs
		left join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
		left join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento
		left join os_tipo on os_tipo.id_tipo = os.id_tipo
		left join verificacao_controle on verificacao_controle.idVerificacaoControle = os.idVerificacaoControle
		left join orc_servico_escopo on orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item and orc_servico_escopo.ativo = 1
		left join status_escopo on status_escopo.idStatusEscopo = orc_servico_escopo.idStatusEscopo
		left join status_peritagem on status_peritagem.idStatusPeritagem = orcamento_item.idStatusPeritagem
		left join tipo_qtd on tipo_qtd.idTipoQtd = orcamento_item.idTipoQtd
		LEFT JOIN anexo_nfcliente ON anexo_nfcliente.idOs = os.idOs
		WHERE 1=1 {$where_condition} -- AQUI foi corrigido para usar $where_condition
        GROUP BY os.idOs ORDER BY `os`.`idOs` desc LIMIT {$start},{$perpage}"; // Use {} para variáveis no LIMIT

		return $this->db->query($query)->result();
    }
								
	public function getWhereLikeos($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '', $tag = '',$numero_nf = '',$descricao_item = '',$tipo = '',$unidade_execucao = '',$query_status_producao = '',$query_unid_execucao = '',$query_unid_faturamento = '',$querydataentrega = '',$querydatacadastro = '',$querydatareagendada = '',$query_clientes = '' ,$queryentrega_reagendada = '', $query_tipoos='',$query_desenhoTrue = '',$query_clientes3 = '',$query_verifControl = '',$numero_nffab = '', $numero_nfserv = '', $vendedor = '', $status_escopo = '', $abertura = '')
    {
		if($query_tipoos <> '')
		{
			$query_tipoos1 = " and os.id_tipo in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_tipoos, '()'))))).")";
		}
		else
		{
			$query_tipoos1 = '';
		}
		if($tipo == 'c')
		{
			$order = "asc";
		}
		else
		{
			$order = "desc";
		}
		if($query_clientes <> '')
		{
			$query_clientes1 = " and clientes.idClientes in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_clientes, '()'))))).")";
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
		if($queryentrega_reagendada <> '')
		{
			$queryentrega_reagendada1 = $queryentrega_reagendada;
		}
		else
		{
			$queryentrega_reagendada1 = '';
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
			$query_status_producao1 = " and os.idStatusOs in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_status_producao, '()'))))).")";
		}
		else
		{
			$query_status_producao1 = '';
		}
		
		if($query_unid_execucao <> '')
		{
			$query_unid_execucao1 = " and os.unid_execucao in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_unid_execucao, '()'))))).")";
		}
		else
		{
			$query_unid_execucao1 = '';
		}
		if($query_unid_faturamento <> '')
		{
			$query_unid_faturamento1 = " and os.unid_faturamento in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_unid_faturamento, '()'))))).")";
		}
		else
		{
			$query_unid_faturamento1 = '';
		}
		
		if($cod_orc <> '')
		{
			$cod_orc1 = " and os.idOrcamentos = ".(int)$cod_orc;
		}
		else
		{
			$cod_orc1 = '';
		}
		if($clientes_id <> '')
		{
			$clientes_id1  = " and orcamento.idClientes = ".(int)$clientes_id;
		}
		else
		{
			$clientes_id1 = '';
		}
		if($idOs <> '')
		{
			
         $idOs1 = " and os.idOs = ".(int)$idOs;
		}
		else
		{
			$idOs1 = '';
		}
		if($idProdutos <> '')
		{
			$idProdutos1 = " and produtos.idProdutos = ".(int)$idProdutos;
		}
		else
		{
			$idProdutos1 = '';
		}
		if($numpedido_os <> '')
		{
			 $numpedido_os1 = " and os.numpedido_os = '".$this->db->escape_str($numpedido_os)."'";
		}
		else
		{
			$numpedido_os1 = '';
		}
		if($tag <> '')
		{
			 $tag1 = " and os.tag like '%".$this->db->escape_like_str($tag)."%'";
		}
		else
		{
			$tag1 = '';
		}
		if($numero_nf <> '')
		{
			  $numero_nf1 = " and os.nf_cliente = ".(int)$numero_nf;
		}
		else
		{
			$numero_nf1 = '';
		}
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$this->db->escape_like_str($descricao_item)."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
		if($unidade_execucao <> '')
		{
			$unidade_execucao1 = " and os.unid_execucao = ".(int)$unidade_execucao;
		}
		else
		{
			$unidade_execucao1 = '';
		}
		if($numero_nffab <> '')
		{
			  $numero_nffab1 = " and os.nf_venda_dev = ".(int)$numero_nffab;
		}
		else
		{
			$numero_nffab1 = '';
		}
		if($numero_nfserv <> '')
        {
              $numero_nfserv1 = " and os.numero_nf = ".(int)$numero_nfserv;
        }
        else
        {
            $numero_nfserv1 = '';
        }
		if($status_escopo <> ''){
			$status_per = " and orcamento_item.idStatusPeritagem in (".implode(',', array_filter(array_map('intval', (array)$status_escopo))).") ";
		}else{
			$status_per = "";
		}
         
        $query = "

		SELECT os.data_abertura_real,
		os.data_insert,
		verificacao_controle.descricaoControle,
		verificacao_controle.idVerificacaoControle,
		os.numpedido_os,
		os.data_nf_faturamento,
		os.val_ipi_os,os.tag,os.idOs,os.`data_abertura`,os.`data_entrega`,os.`data_expedicao`,os.`data_canhoto`,os.`data_reagendada`,os.`data_planejada`, os.statusDesenho, os.obsDesenho, os.nf_venda_dev, os.numero_nf, os.nf_venda_dev, os.nf_canhoto,
		os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,os.val_unit_os,grupo_servico.idGrupoServico,
		os.desconto_os,os.subtot_os, (SELECT anexo_desenho.idAnexo from anexo_desenho where anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue,
		unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,
		os_tipo.nome_tipo,status_os.nomeStatusOs, emitente.nome, nf_cliente, nomeArquivo,
		vendedores.nomeVendedor,
		status_escopo.descricaoEscopo,
		tipo_qtd.descricaoTipoQtd,
		status_peritagem.descricaoPeritagem
		FROM (`os`)
		JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos 
		JOIN grupo_servico on grupo_servico.idGrupoServico = orcamento.idGrupoServico 
		JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` 
		JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` 
		JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos 
		JOIN vendedores on vendedores.idVendedor = orcamento.idVendedor 
		join status_os on status_os.idStatusOs = os.idStatusOs 
		left join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao 
		left join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento 
		left join os_tipo on os_tipo.id_tipo = os.id_tipo 
		left join verificacao_controle on verificacao_controle.idVerificacaoControle = os.idVerificacaoControle
		left join orc_servico_escopo on orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item and orc_servico_escopo.ativo = 1
		left join status_escopo on status_escopo.idStatusEscopo = orc_servico_escopo.idStatusEscopo
		left join status_peritagem on status_peritagem.idStatusPeritagem = orcamento_item.idStatusPeritagem
		left join tipo_qtd on tipo_qtd.idTipoQtd = orcamento_item.idTipoQtd
		LEFT JOIN anexo_nfcliente ON anexo_nfcliente.idOs = os.idOs
			where 1=1 $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $tag1 $numero_nf1 $query_status_producao1 $query_unid_execucao1 
			$query_unid_faturamento1 $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 $queryentrega_reagendada1 $descricao_item1
			$query_tipoos1 $unidade_execucao1 $query_desenhoTrue $query_clientes3 $query_verifControl $numero_nffab1 $numero_nfserv1 $vendedor $status_per $abertura  GROUP BY os.idOs ORDER BY `os`.`idOs` $order";

		//echo $query;
		//exit;
        
        return $this->db->query($query)->result();
       
    }
	
	
	
public function getWhereLikeos_status($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '',$tag = '', $numero_nf = '',$descricao_item = '',$tipo = '',$unidade_execucao = '',$query_status_producao = '',$query_unid_execucao = '',$query_unid_faturamento = '',$querydataentrega = '',$querydatacadastro = '',$querydatareagendada = '',$query_clientes = '' ,$queryentrega_reagendada = '',$status1 = '',$query_tipoos = '',$desenhoTrue = '',$query_clientes3 = '',$query_verifControl = '',$numero_nffab = '', $numero_nfserv = '', $vendedor = '', $status_escopo = '', $idGrupoServico = '', $queryDataProducao = '', $queryDataReprog = '')
    {
		
		if($tipo == 'c')
		{
			$order = "asc";
		}
		else
		{
			$order = "desc";
		}
		if($query_clientes <> '')
		{
			$query_clientes1 = " and clientes.idClientes in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_clientes, '()'))))).")";
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
		if($queryentrega_reagendada <> '')
		{
			$queryentrega_reagendada1 = $queryentrega_reagendada;
		}
		else
		{
			$queryentrega_reagendada1 = '';
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
			$query_status_producao1 = " and os.idStatusOs in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_status_producao, '()'))))).")";
		}
		else
		{
			$query_status_producao1 = '';
		}
		
		if($query_unid_execucao <> '')
		{
			$query_unid_execucao1 = " and os.unid_execucao in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_unid_execucao, '()'))))).")";
		}
		else
		{
			$query_unid_execucao1 = '';
		}
		if($query_tipoos <> '')
		{
			$novotipo = " and os.id_tipo in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_tipoos, '()'))))).")";
			
		}
		else
		{
			$novotipo = '';
		}
		
		
		if($query_unid_faturamento <> '')
		{
			$query_unid_faturamento1 = " and os.unid_faturamento in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_unid_faturamento, '()'))))).")";
		}
		else
		{
			$query_unid_faturamento1 = '';
		}
		
		if($cod_orc <> '')
		{
			$cod_orc1 = " and os.idOrcamentos = ".(int)$cod_orc;
		}
		else
		{
			$cod_orc1 = '';
		}
		if($clientes_id <> '')
		{
			$clientes_id1  = " and orcamento.idClientes = ".(int)$clientes_id;
		}
		else
		{
			$clientes_id1 = '';
		}
		if($idOs <> '')
		{
			
         $idOs1 = " and os.idOs in (".implode(',', array_filter(array_map('intval', explode(',', $idOs)))).") ";
		}
		else
		{
			$idOs1 = '';
		}
		if($idProdutos <> '')
		{
			$idProdutos1 = " and produtos.idProdutos = ".(int)$idProdutos;
		}
		else
		{
			$idProdutos1 = '';
		}
		if($numpedido_os <> '')
		{
			 $numpedido_os1 = " and os.numpedido_os = ".(int)$numpedido_os;
		}
		else
		{
			$numpedido_os1 = '';
		}
		if($tag <> '')
		{
			 $tag1 = " and os.tag like '%".$this->db->escape_like_str($tag)."%'";
		}
		else
		{
			$tag1 = '';
		}
		if($numero_nf <> '')
		{
			 $numero_nf1 = " and os.nf_cliente = ".(int)$numero_nf;
		}
		else
		{
			$numero_nf1 = '';
		}
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$this->db->escape_like_str($descricao_item)."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
		if($unidade_execucao <> '')
		{
			$unidade_execucao1 = " and os.unid_execucao = ".(int)$unidade_execucao;
		}
		else
		{
			$unidade_execucao1 = '';
		}
        
		if($numero_nffab <> '')
		{
			  $numero_nffab1 = " and os.nf_venda_dev = ".(int)$numero_nffab;
		}
		else
		{
			$numero_nffab1 = '';
		}
		if($numero_nfserv <> '')
        {
              $numero_nfserv1 = " and os.numero_nf = ".(int)$numero_nfserv;
        }
        else
        {
            $numero_nfserv1 = '';
        }
		if($status_escopo <> ''){
			$status_per = " and orc_servico_escopo.idStatusEscopo in (".implode(',', array_filter(array_map('intval', (array)$status_escopo))).") ";
		}else{
			$status_per = "";
		}
		if($idGrupoServico <> '')
		{
			$idGrupoServico1 = " and orcamento.idGrupoServico = ".(int)$idGrupoServico;
		}
		else
		{
			$idGrupoServico1 = '';
		}
		
		// --- NOVO FILTRO: REPROGRAMAÇÃO ---
		if($queryDataReprog <> '')
		{
			$queryDataReprog1 = " " . $queryDataReprog;
		}
		else
		{
			$queryDataReprog1 = '';
		}
		// ----------------------------------

        $query = "
          SELECT sum(((os.qtd_os * os.val_unit_os) - os.desconto_os) + ((os.qtd_os * os.val_unit_os) - os.desconto_os) * os.`val_ipi_os`/100) as soma,unidade_execucao.status_execucao,status_os.nomeStatusOs, count(os.idOs) as qtdos FROM (`os`) JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos join status_os on status_os.idStatusOs = os.idStatusOs join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento left join orc_servico_escopo on orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item and orc_servico_escopo.ativo = 1 left join status_escopo on status_escopo.idStatusEscopo = orc_servico_escopo.idStatusEscopo where 1=1 $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $tag1 $numero_nf1 $query_status_producao1 $query_unid_execucao1 $query_unid_faturamento1 $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 $queryentrega_reagendada1 $descricao_item1  $status1 $novotipo $unidade_execucao1 $query_clientes3 $query_verifControl $numero_nffab1 $numero_nfserv1 $vendedor $status_per $idGrupoServico1 $queryDataProducao $queryDataReprog1 group by os.unid_execucao,os.idStatusOs ORDER BY unidade_execucao.status_execucao,status_os.nomeStatusOs
        ";
        
        return $this->db->query($query)->result();
       
    }
public function getWhereLikeos_status2($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '', $tag = '', $numero_nf = '', $descricao_item = '', $tipo = '', $unidade_execucao = '', $query_status_producao = '', $query_unid_execucao = '', $query_unid_faturamento = '', $querydataentrega = '', $querydatacadastro = '', $querydatareagendada = '', $query_clientes = '', $queryentrega_reagendada = '', $status1 = '', $query_tipoos = '', $desenhoTrue = '', $query_clientes3 = '', $query_verifControl = '', $numero_nffab = '', $numero_nfserv = '', $vendedor = '', $status_escopo = '', $idGrupoServico = '', $queryDataProducao = '', $queryDataReprog = '')
    {
		
		if($tipo == 'c')
		{
			$order = "asc";
		}
		else
		{
			$order = "desc";
		}
		if($query_clientes <> '')
		{
			$query_clientes1 = " and clientes.idClientes in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_clientes, '()'))))).")";
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
		if($queryentrega_reagendada <> '')
		{
			$queryentrega_reagendada1 = $queryentrega_reagendada;
		}
		else
		{
			$queryentrega_reagendada1 = '';
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
			$query_status_producao1 = " and os.idStatusOs in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_status_producao, '()'))))).")";
		}
		else
		{
			$query_status_producao1 = '';
		}
		
		if($query_unid_execucao <> '')
		{
			$query_unid_execucao1 = " and os.unid_execucao in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_unid_execucao, '()'))))).")";
		}
		else
		{
			$query_unid_execucao1 = '';
		}
		if($query_tipoos <> '')
		{
			$novotipo = " and os.id_tipo in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_tipoos, '()'))))).")";
			
		}
		else
		{
			$novotipo = '';
		}
		
		
		if($query_unid_faturamento <> '')
		{
			$query_unid_faturamento1 = " and os.unid_faturamento in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_unid_faturamento, '()'))))).")";
		}
		else
		{
			$query_unid_faturamento1 = '';
		}
		
		if($cod_orc <> '')
		{
			$cod_orc1 = " and os.idOrcamentos = ".(int)$cod_orc;
		}
		else
		{
			$cod_orc1 = '';
		}
		if($clientes_id <> '')
		{
			$clientes_id1  = " and orcamento.idClientes = ".(int)$clientes_id;
		}
		else
		{
			$clientes_id1 = '';
		}
		if($idOs <> '')
		{
			
         $idOs1 = " and os.idOs in (".implode(',', array_filter(array_map('intval', explode(',', $idOs)))).") ";
		}
		else
		{
			$idOs1 = '';
		}
		if($idProdutos <> '')
		{
			$idProdutos1 = " and produtos.idProdutos = ".(int)$idProdutos;
		}
		else
		{
			$idProdutos1 = '';
		}
		if($numpedido_os <> '')
		{
			 $numpedido_os1 = " and os.numpedido_os = ".(int)$numpedido_os;
		}
		else
		{
			$numpedido_os1 = '';
		}
		if($tag <> '')
		{
			 $tag1 = " and os.tag like '%".$this->db->escape_like_str($tag)."%'";
		}
		else
		{
			$tag1 = '';
		}
		if($numero_nf <> '')
		{
			 $numero_nf1 = " and os.nf_cliente = ".(int)$numero_nf;
		}
		else
		{
			$numero_nf1 = '';
		}
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$this->db->escape_like_str($descricao_item)."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
		if($unidade_execucao <> '')
		{
			$unidade_execucao1 = " and os.unid_execucao = ".(int)$unidade_execucao;
		}
		else
		{
			$unidade_execucao1 = '';
		}
        if($numero_nffab <> '')
		{
			  $numero_nffab1 = " and os.nf_venda_dev = ".(int)$numero_nffab;
		}
		else
		{
			$numero_nffab1 = '';
		}
		if($numero_nfserv <> '')
        {
              $numero_nfserv1 = " and os.numero_nf = ".(int)$numero_nfserv;
        }
        else
        {
            $numero_nfserv1 = '';
        }
		if($status_escopo <> ''){
			$status_per = " and orc_servico_escopo.idStatusEscopo in (".implode(',', array_filter(array_map('intval', (array)$status_escopo))).") ";
		}else{
			$status_per = "";
		}
		if($idGrupoServico <> '')
		{
			$idGrupoServico1 = " and orcamento.idGrupoServico = ".(int)$idGrupoServico;
		}
		else
		{
			$idGrupoServico1 = '';
		}

		// --- NOVO FILTRO: REPROGRAMAÇÃO ---
		if($queryDataReprog <> '')
		{
			$queryDataReprog1 = " " . $queryDataReprog;
		}
		else
		{
			$queryDataReprog1 = '';
		}
		// ----------------------------------

        $query = "
          SELECT sum(((os.qtd_os * os.val_unit_os) - os.desconto_os) + ((os.qtd_os * os.val_unit_os) - os.desconto_os) * os.`val_ipi_os`/100) as soma,unidade_execucao.status_execucao,status_os.nomeStatusOs, count(os.idOs) as qtdos FROM (`os`) JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos join status_os on status_os.idStatusOs = os.idStatusOs left join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao left join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento left join orc_servico_escopo on orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item and orc_servico_escopo.ativo = 1
		  left join status_escopo on status_escopo.idStatusEscopo = orc_servico_escopo.idStatusEscopo where 1=1 and orcamento_item.status_item = 0 $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $tag1 $numero_nf1 $query_status_producao1 $query_unid_execucao1 $query_unid_faturamento1 $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 $queryentrega_reagendada1 $descricao_item1  $status1 $novotipo $unidade_execucao1 $query_clientes3 $query_verifControl $numero_nffab1 $numero_nfserv1 $vendedor $status_per $idGrupoServico1 $queryDataProducao $queryDataReprog1 group by os.unid_execucao,os.idStatusOs ORDER BY unidade_execucao.status_execucao,status_os.nomeStatusOs
        ";
        
        return $this->db->query($query)->result();
       
    }
    public function numrowsWhereLikeos($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '',$tag = '', $numero_nf = '',$descricao_item = '',$tipo = '',$unidade_execucao = '',$query_status_producao = '',$query_unid_execucao = '',$query_unid_faturamento = '',$querydataentrega = '',$querydatacadastro = '',$querydatareagendada = '',$query_clientes = '',$queryentrega_reagendada = '', $query_tipoos='')
    {
		if($query_tipoos <> '')
		{
			$query_tipoos1 = " and os.id_tipo in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_tipoos, '()'))))).")";
		}
		else
		{
			$query_tipoos1 = '';
		}
		if($tipo == 'c')
		{
			$order = "asc";
		}
		else
		{
			$order = "desc";
		}
		if($query_clientes <> '')
		{
			$query_clientes1 = " and clientes.idClientes in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_clientes, '()'))))).")";
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
		if($queryentrega_reagendada <> '')
		{
			$queryentrega_reagendada1 = $queryentrega_reagendada;
		}
		else
		{
			$queryentrega_reagendada1 = '';
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
			$query_status_producao1 = " and os.idStatusOs in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_status_producao, '()'))))).")";
		}
		else
		{
			$query_status_producao1 = '';
		}
		
		if($query_unid_execucao <> '')
		{
			$query_unid_execucao1 = " and os.unid_execucao in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_unid_execucao, '()'))))).")";
		}
		else
		{
			$query_unid_execucao1 = '';
		}
		if($query_unid_faturamento <> '')
		{
			$query_unid_faturamento1 = " and os.unid_faturamento in (".implode(',', array_filter(array_map('intval', explode(',', trim($query_unid_faturamento, '()'))))).")";
		}
		else
		{
			$query_unid_faturamento1 = '';
		}
      if($cod_orc <> '')
		{
			$cod_orc1 = " and os.idOrcamentos = ".(int)$cod_orc;
		}
		else
		{
			$cod_orc1 = '';
		}
		if($clientes_id <> '')
		{
			$clientes_id1  = " and orcamento.idClientes = ".(int)$clientes_id;
		}
		else
		{
			$clientes_id1 = '';
		}
		if($idOs <> '')
		{
			
         $idOs1 = " and os.idOs = ".(int)$idOs;
		}
		else
		{
			$idOs1 = '';
		}
		if($idProdutos <> '')
		{
			$idProdutos1 = " and produtos.idProdutos = ".(int)$idProdutos;
		}
		else
		{
			$idProdutos1 = '';
		}
		if($numpedido_os <> '')
		{
			 $numpedido_os1 = " and os.numpedido_os = ".(int)$numpedido_os;
		}
		else
		{
			$numpedido_os1 = '';
		}
		if($tag <> '')
		{
			 $tag1 = " and os.tag like '%".$this->db->escape_like_str($tag)."%'";
		}
		else
		{
			$tag1 = '';
		}
		if($numero_nf <> '')
		{
			  $numero_nf1 = " and os.nf_cliente = ".(int)$numero_nf;
		}
		else
		{
			$numero_nf1 = '';
		}
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$this->db->escape_like_str($descricao_item)."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
		if($unidade_execucao <> '')
		{
			$unidade_execucao1 = " and os.unid_execucao = ".(int)$unidade_execucao;
		}
		else
		{
			$unidade_execucao1 = '';
		}
        $query = "
             SELECT os.numpedido_os,os.val_ipi_os,os.tag,os.idOs,os.`data_abertura`,os.`data_entrega`,os.`data_expedicao`,os.`data_canhoto`,os.`data_reagendada`,os.`data_planejada`,os.`idOrcamentos`, clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,os.desconto_os,os.val_unit_os,os.subtot_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,os_tipo.nome_tipo,status_os.nomeStatusOs,emitente.nome FROM (`os`) JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos join status_os on status_os.idStatusOs = os.idStatusOs join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento left join os_tipo on os_tipo.id_tipo = os.id_tipo where 1=1 $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $tag1 $numero_nf1 $query_status_producao1 $query_unid_execucao1 $query_unid_faturamento1 $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 $queryentrega_reagendada1 $descricao_item1 $query_tipoos1 $unidade_execucao1 ORDER BY `os`.`idOs` $order 
        ";
       
       
        
        return $this->db->count_all();
       
    }
	
	
	 function edit_concatena($table,$data2,$fieldID,$ID,$data3){
		//$data['histo_alteracao'] = "CONCAT(histo_alteracao, $data2)";

		
		$this->db->where($fieldID,$ID);
		$this->db->set("histo_alteracao", "CONCAT('$data3', '$data2')", false);
		$this->db->update($table);



		
		if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;


       
      
    }
	
	
    function edit($table,$data,$fieldID,$ID){
        return $this->histAlteracao($table,$data,$fieldID,$ID);       
    }
	
	function edit2($table,$data,$fieldID,$ID){/*
        $this->db->where('idOs in ('.$ID.')');
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
		
		return FALSE;    */
		return $this->histAlteracao($table,$data,false,$ID);   
    }
    function getObj($table,$fieldID,$ID){
        
        $this->db->select('*');
        $this->db->from($table);
		if($fieldID == false){
			$this->db->where('idOs in ('.$ID.')');
		}else{
			$this->db->where($fieldID,$ID);
		}
		
        
        
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
	function getObjONE($table,$fieldID,$ID){
		$this->db->select('*');
        $this->db->from($table);
		$this->db->where($fieldID,$ID);
        
        
        $query = $this->db->get();
        
        $result = $query->row();
        return $result;
	}
	function histAlteracao($table,$data,$fieldID,$ID,$retorno = false){
		$itensAntes = $this->getObj($table,$fieldID,$ID);
		$fields = $this->db->field_data($table);
		foreach ($fields as $field)
		{
			if($field->primary_key == 1){
				$primary_key = $field->name;
			}
		}
		if($fieldID == false){
			$this->db->where('idOs in ('.$ID.')');
		}else{
			$this->db->where($fieldID,$ID);
		}
        $this->db->update($table, $data);
		if($retorno){
            $retorno2 = $this->db->last_query();
        }
        if ($this->db->affected_rows() >= 0)
		{
			$retorno2 = TRUE;
		}else{
			$retorno2 = FALSE;
		}
		foreach($itensAntes as $r){
			$itensAgora = $this->getObjONE($table,$primary_key,$r->{$primary_key});
			$arrayDif = array_diff_assoc((array)$itensAgora,(array)$r);
			if($arrayDif){
				$dataHistorico = array(
					"idUser"=>$this->session->userdata('idUsuarios'),
					"url"=>$this->uri->uri_string(),
					"data_alteracao"=>date('Y-m-d H:i:s'),
					"tipo"=>"UPDATE",
					"alt_table"=>$table,
					"alt_primary_key"=>$primary_key,
					"alt_id"=>$r->{$primary_key},
					"alt_obj"=>json_encode($itensAgora),
					"alt"=>json_encode($arrayDif)
				);
				$this->db->insert("historico_alteracoes", $dataHistorico);   
			}
		}
		return $retorno2;
	}
	function histAlteracaoAdd($table,$id){
		$fields = $this->db->field_data($table);
		foreach ($fields as $field)
		{
			if($field->primary_key == 1){
				$primary_key = $field->name;
			}
		}
		$itensAntes = $this->getObjONE($table,$primary_key,$id);
		$dataHistorico = array(
			"idUser"=>$this->session->userdata('idUsuarios'),
			"url"=>$this->uri->uri_string(),
			"data_alteracao"=>date('Y-m-d H:i:s'),
			"tipo"=>"INSERT",
			"alt_table"=>$table,
			"alt_primary_key"=>$primary_key,
			"alt_id"=>$id,
			"alt_obj"=>json_encode($itensAntes),
			"alt"=>json_encode($itensAntes)
		);
		$this->db->insert("historico_alteracoes", $dataHistorico);   
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
                $row_set[] = array('label'=>$row['descricao'].' | Preço: R$ '.$row['precoVenda'].' | Estoque: '.$row['estoque'],'estoque'=>$row['estoque'],'id'=>$row['idProdutos'],'preco'=>$row['precoVenda'],'pn'=>$row['pn']);
            }
            echo json_encode($row_set);
        }
    }
	public function autoCompleteProduto2($q){

        $this->db->select('*');
        //$this->db->limit(5);
        $this->db->like('descricao', $q);
        $query = $this->db->get('produtos');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricao'].' | ID: '.$row['idProdutos'],'id'=>$row['idProdutos'],'pn'=>$row['pn']);
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

	public function getVerificacaoControle(){
		$this->db->select('*');
		$this->db->from('verificacao_controle');
		return $this->db->get()->result();
	}
	public function getPedidosCompraFrete($id){
		$query = 'SELECT pedido_compras.idPedidoCompra, 
			(select sum(distribuir_os2.quantidade) 
			from distribuir_os as distribuir_os2 
			join pedido_cotacaoitens as pedido_cotacaoitens2 on pedido_cotacaoitens2.idDistribuir = distribuir_os2.idDistribuir 
			join pedido_compras as pedido_compras2 on pedido_compras2.idPedidoCompra = pedido_cotacaoitens2.idPedidoCompra 
			where pedido_compras2.idPedidoCompra = pedido_compras.idPedidoCompra and distribuir_os2.idStatuscompras = 5) as quantidadeProdutos,
			(select sum(distribuir_os2.quantidade) 
			from distribuir_os as distribuir_os2 
			join pedido_cotacaoitens as pedido_cotacaoitens2 on pedido_cotacaoitens2.idDistribuir = distribuir_os2.idDistribuir 
			join pedido_compras as pedido_compras2 on pedido_compras2.idPedidoCompra = pedido_cotacaoitens2.idPedidoCompra 
			where distribuir_os2.idOs = os.idOs and pedido_compras2.idPedidoCompra = pedido_compras.idPedidoCompra and distribuir_os2.idStatuscompras = 5) as quantidadeProdutosOs,
			pedido_compras.frete
			FROM `os` 
			join distribuir_os on distribuir_os.idOs = os.idOs 
			join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
			join pedido_compras on pedido_compras.idPedidoCompra = pedido_cotacaoitens.idPedidoCompra 
			WHERE os.idOs = ? and distribuir_os.idStatuscompras = 5 group by pedido_compras.idPedidoCompra';
		return $this->db->query($query, array((int)$id))->result();
	}
	public function getPedidosCompraIcms($id){
		$query = 'SELECT pedido_comprasitens.idPedidoCompra, pedido_comprasitens.icms 
		from os 
		join distribuir_os on distribuir_os.idOs = os.idOs 
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens 
		where os.idOs = ? and distribuir_os.idStatuscompras = 5';
		return $this->db->query($query, array((int)$id))->result();
	}
	public function insertOSHis($os,$user = ""){
		$os2 = (array) $os;
		$os2['data_alteracaoHis'] = date('Y-m-d H:i:s');
		if(empty($user)){
			$os2['idUserHis'] = $this->session->userdata('idUsuarios');
		}else{
			$os2['idUserHis'] = $user;
		}
		
		$os2['url'] = $this->uri->uri_string();
		$this->db->insert('os_history',$os2);
		if ($this->db->affected_rows() == '1')
		{			
			return true;			
		}		
		return FALSE;
	}
	
	
public function getHistoricoDataProducao($idOs)
{
    $this->db->select('idHistAlteracao, idUser, data_alteracao, alt');
    $this->db->from('historico_alteracoes');
    $this->db->where('alt_table', 'os');
    $this->db->where('alt_primary_key', 'idOs');
    $this->db->where('alt_id', $idOs);
    $this->db->where('url', 'os/dataproducaoPCP'); // FILTRA SOMENTE ALTERAÇÃO DO PCP
    $this->db->order_by('idHistAlteracao', 'DESC');

    $result = $this->db->get()->result();

    // Converter JSON do campo ALT
    foreach ($result as &$r) {
        $json = json_decode($r->alt);

        if (isset($json->data_producao)) {
            $r->data_producao = $json->data_producao;
        } else {
            $r->data_producao = null;
        }

        // Buscar nome do usuário
        $this->db->where('idUsuarios', $r->idUser);
        $user = $this->db->get('usuarios')->row();
        $r->nomeUsuario = $user ? $user->nome : 'Desconhecido';
    }

    return $result;
}

	
	public function getHisStatusOs($idOs){
		$query = "SELECT usuarios.nome,status_os.nomeStatusOs,verificacao_controle.descricaoControle,os_history.data_alteracaoHis,os_history.statusDesenho,os_history.data_entrega,os_history.data_reagendada,os_history.data_planejada
		FROM `os_history` 
		join status_os on status_os.idStatusOs = os_history.idStatusOs 
		join usuarios on usuarios.idUsuarios = os_history.idUserHis 
		join verificacao_controle on verificacao_controle.idVerificacaoControle = os_history.idVerificacaoControle
		WHERE os_history.idOs = ? order by os_history.data_alteracaoHis desc";
		return $this->db->query($query, array((int)$idOs))->result();
	}
	public function getHistVale(){
		$query = "SELECT * from hist_vale 
			join insumos on insumos.idInsumos = hist_vale.idInsumo 
			join usuarios on usuarios.idUsuarios = hist_vale.idUser 
			order by hist_vale.data_insert desc LIMIT 20";
		return $this->db->query($query)->result();
	}
	function getSubOsByIdOs($id){
		$query = "SELECT os_sub.*, produtos.*, classe_item_escopo.nomeClasse, classe_item_escopo.descricaoClasse FROM os_sub left join produtos on produtos.idProdutos = os_sub.idProduto_sub join classe_item_escopo on classe_item_escopo.idClasse = os_sub.idClasse WHERE idOs = ?";
		return $this->db->query($query, array((int)$id))->result();
	}
	function getSubOsByIdOs2($id){
		$query = "SELECT os_sub.*, produtos.*,orc_servico_escopo_itens.dimenExt,orc_servico_escopo_itens.dimenInt,orc_servico_escopo_itens.dimenComp,orc_servico_escopo_itens.obs, classe_item_escopo.nomeClasse, classe_item_escopo.descricaoClasse FROM os_sub left join produtos on produtos.idProdutos = os_sub.idProduto_sub join classe_item_escopo on classe_item_escopo.idClasse = os_sub.idClasse left join orc_servico_escopo_itens on orc_servico_escopo_itens.idOrcServicoEscopoItens = os_sub.idOrcServicoEscopoItens WHERE idOs = ? and os_sub.ativo = 1";
		return $this->db->query($query, array((int)$id))->result();
	}
	function getSubOsByIdOrcamentoItem($id){
		$query = "SELECT os_sub.*, produtos.*, orcamento_item.tipoOrc, classe_item_escopo.nomeClasse , classe_item_escopo.descricaoClasse FROM os_sub left join produtos on produtos.idProdutos = os_sub.idProduto_sub join classe_item_escopo on classe_item_escopo.idClasse = os_sub.idClasse join os on os.idOs = os_sub.idOs join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item WHERE os.idOrcamento_item = ? and os_sub.ativo = 1";
		return $this->db->query($query, array((int)$id))->result();
	}
	function getSubOsByIdOrcamentoItemByPosicao($id,$posicao){
		$query = "SELECT os_sub.*, produtos.*, orcamento_item.tipoOrc, classe_item_escopo.nomeClasse , classe_item_escopo.descricaoClasse FROM os_sub left join produtos on produtos.idProdutos = os_sub.idProduto_sub join classe_item_escopo on classe_item_escopo.idClasse = os_sub.idClasse join os on os.idOs = os_sub.idOs join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item WHERE os.idOrcamento_item = ? and os_sub.ativo = 1 and os_sub.posicao = ?";
		return $this->db->query($query, array((int)$id, (int)$posicao))->result();
	}
	function getSubOsByIdOrcamentoItem2($id){
		$query = "SELECT os_sub.*, produtos.*, orcamento_item.tipoOrc, classe_item_escopo.nomeClasse , classe_item_escopo.descricaoClasse FROM os_sub left join produtos on produtos.idProdutos = os_sub.idProduto_sub join classe_item_escopo on classe_item_escopo.idClasse = os_sub.idClasse join os on os.idOs = os_sub.idOs join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item WHERE os.idOrcamento_item = ? and os_sub.ativo = 1 GROUP BY produtos.idProdutos";
		return $this->db->query($query, array((int)$id))->result();
	}
	function getSubOsByIdProduto($idProduto){
        $query = "SELECT * FROM os_sub join os on os.idOs = os_sub.idOs  WHERE idProduto_sub = ? order by os_sub.idOsSub desc limit 1";
		return $this->db->query($query, array((int)$idProduto))->row();
    }
	function getMaterialByIdOsSub($idOsSub){
        $query = "SELECT * FROM distribuir_os where idOsSub = ? and idStatuscompras = 5";
		return $this->db->query($query, array((int)$idOsSub))->result();
    }
	function getSugestaoOsSub($idOsSub){
		$query = "SELECT * FROM distribuir_os_sugestao join insumos on insumos.idInsumos = distribuir_os_sugestao.idInsumos join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os_sugestao.id_status_grupo WHERE idOsSub = ? and respondeu = 0";
		return $this->db->query($query, array((int)$idOsSub))->result();
	}
	function getInforDistribuirSugestao($idDistribuirSugestao){
		$query = "SELECT distribuir_os_sugestao.*, insumos.*,status_grupo_compra.*,os_sub.posicao FROM distribuir_os_sugestao join os_sub on os_sub.idOsSub = distribuir_os_sugestao.idOsSub join insumos on insumos.idInsumos = distribuir_os_sugestao.idInsumos join status_grupo_compra on status_grupo_compra.idgrupo = distribuir_os_sugestao.id_status_grupo WHERE idDistribuirSugestao = ?";
		return $this->db->query($query, array((int)$idDistribuirSugestao))->row();
	}
	function getStatusF(){
		$query = "SELECT * FROM `status_os` WHERE nomeStatusOs like '%(F)%' ";
		return $this->db->query($query)->result();
	}
	public function os_vinculada($idOs){
		$query = "SELECT * FROM os JOIN os_vinculada on os_vinculada.idOs_principal = os.idOs or os_vinculada.idOs_gerada = os.idOs where os.idOs = ?";
		return $this->db->query($query, array((int)$idOs))->result();
	}

	public function getOsIN($listOs,$one = false){
		$query = "SELECT * FROM os WHERE os.idOs in (".implode(',', array_filter(array_map('intval', explode(',', $listOs)))).") ";
		if($one){
			return $this->db->query($query)->row();
		}else{
			return $this->db->query($query)->result();
		}
		
	}
	public function getInfoOs($idOs){
		$query = "SELECT * FROM `os` 
			join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
			join orcamento on orcamento.idOrcamentos = orcamento_item.idOrcamentos
			join clientes on clientes.idClientes = orcamento.idClientes 
			join produtos on produtos.idProdutos = orcamento_item.idProdutos 
			join clientes_solicitantes on clientes_solicitantes.idSolicitante = orcamento.idSolicitante 
			join vendedores on vendedores.idVendedor = orcamento.idVendedor
			join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao WHERE os.idOs = ?";
		return $this->db->query($query, array((int)$idOs))->row();
	}
	public function getOrcamentoItemByIdOs($idOs){
		$query = "SELECT orcamento_item.* FROM `orcamento_item` join os on os.idOrcamento_item = orcamento_item.idOrcamento_item WHERE os.idOs = ?";

		return $this->db->query($query, array((int)$idOs))->row();
	}
	public function getOsSubSemSub($where = ''){
		$query = "SELECT os.*, orcamento_item.descricao_item, orcamento_item.idProdutos FROM `os` left join os_sub on os_sub.idOs = os.idOs join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item WHERE os.idStatusOs != 200 and os_sub.idOsSub is null $where";
		return $this->db->query($query)->result();
	}

	
	public function getStatusPeritagem(){
		$query = "SELECT * FROM status_escopo order by ordem asc";
		return $this->db->query($query)->result();
	}

	public function getStatusPeritagem2(){
		$query = "SELECT * FROM status_peritagem";
		return $this->db->query($query)->result();
	}

	public function getDistribuirByIdOs($idOs){
		$query = "SELECT * FROM distribuir_os WHERE idOs = ? ORDER BY data_cadastro asc";
		return $this->db->query($query, array((int)$idOs))->result();
	}

public function getOsAberta($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '', $tag = '', $numero_nf = '', $descricao_item = '', $tipo = '', $unidade_execucao = '', $query_status_producao = '', $query_unid_execucao = '', $query_unid_faturamento = '', $querydataentrega = '', $querydatacadastro = '', $querydatareagendada = '', $query_clientes = '', $queryentrega_reagendada = '', $query_tipoos = '', $query_desenhoTrue = '', $query_clientes3 = '', $query_verifControl = '', $numero_nffab = '', $numero_nfserv = '', $vendedor = '', $status_escopo = '', $idGrupoServico = '', $queryDataProducao = '', $queryDataReprog = '')
{
    // ===== Filtros originais preservados =====
    $query_tipoos1 = ($query_tipoos <> '') ? " and os.id_tipo in " . $query_tipoos : '';
    $order = ($tipo == 'c') ? "asc" : "desc";
    $query_clientes1 = ($query_clientes <> '') ? " and clientes.idClientes in " . $query_clientes : '';
    $querydataentrega1 = ($querydataentrega <> '') ? $querydataentrega : '';
    $queryentrega_reagendada1 = ($queryentrega_reagendada <> '') ? $queryentrega_reagendada : '';
    $querydatacadastro1 = ($querydatacadastro <> '') ? $querydatacadastro : '';
    $querydatareagendada1 = ($querydatareagendada <> '') ? $querydatareagendada : '';
    $query_status_producao1 = ($query_status_producao <> '') ? " and os.idStatusOs in " . $query_status_producao : '';
    $query_unid_execucao1 = ($query_unid_execucao <> '') ? " and os.unid_execucao in " . $query_unid_execucao : '';
    $query_unid_faturamento1 = ($query_unid_faturamento <> '') ? " and os.unid_faturamento in " . $query_unid_faturamento : '';
    $cod_orc1 = ($cod_orc <> '') ? " and os.idOrcamentos = ".(int)$cod_orc : '';
    $clientes_id1 = ($clientes_id <> '') ? " and orcamento.idClientes = ".(int)$clientes_id : '';
    $idOs1 = ($idOs <> '') ? " and os.idOs in (".implode(',', array_filter(array_map('intval', explode(',', $idOs)))).")": '';
    $idProdutos1 = ($idProdutos <> '') ? " and produtos.idProdutos = ".(int)$idProdutos : '';
    $numpedido_os1 = ($numpedido_os <> '') ? " and os.numpedido_os = '".$this->db->escape_str($numpedido_os)."'" : '';
    $tag1 = ($tag <> '') ? " and os.tag like '%".$this->db->escape_like_str($tag)."%'" : '';
    $numero_nf1 = ($numero_nf <> '') ? " and os.nf_cliente = ".(int)$numero_nf : '';
    $descricao_item1 = ($descricao_item <> '') ? " and orcamento_item.descricao_item like '%".$this->db->escape_like_str($descricao_item)."%'" : '';
    $unidade_execucao1 = ($unidade_execucao <> '') ? " and os.unid_execucao = ".(int)$unidade_execucao : '';
    $numero_nffab1 = ($numero_nffab <> '') ? " and os.nf_venda_dev = ".(int)$numero_nffab : '';
    $numero_nfserv1 = ($numero_nfserv <> '') ? " and os.numero_nf = ".(int)$numero_nfserv : '';
    $status_per = ($status_escopo <> '') ? " and orc_servico_escopo.idStatusEscopo in (".implode(',', array_filter(array_map('intval', (array)$status_escopo))). ")" : '';
    $idGrupoServico1 = ($idGrupoServico <> '') ? " and orcamento.idGrupoServico = ".(int)$idGrupoServico : '';
    
    // NOVO FILTRO CIRÚRGICO: Reprogramação
    $queryDataReprog1 = ($queryDataReprog <> '') ? $queryDataReprog : '';

    // ===== Consulta principal preservada e ampliada =====
    $query = "
        SELECT 
            os.data_abertura_real,
            os.data_insert,
            verificacao_controle.descricaoControle,
            verificacao_controle.idVerificacaoControle,
            os.data_nf_faturamento,
            os.data_devolucao,
            clientes_solicitantes.nome as clisol,
            orcamento.idSolicitante,
            os.numpedido_os,
            os.val_ipi_os, os.tag, os.idOs, os.data_abertura, os.data_entrega, 
            os.data_expedicao, os.data_canhoto, os.data_reagendada, os.data_planejada, 
            os.data_producao, os.statusDesenho, os.obsDesenho, os.nf_venda_dev, 
            os.numero_nf, os.nf_canhoto, os.idOrcamentos, clientes.nomeCliente, 
            clientes.nomeClienteCart, produtos.pn, orcamento_item.descricao_item, 
            os.qtd_os, os.val_unit_os, grupo_servico.idGrupoServico, 
            grupo_servico.nome as nomeServico, os.desconto_os, os.subtot_os,
            (SELECT anexo_desenho.idAnexo 
                FROM anexo_desenho 
                WHERE anexo_desenho.idOs = os.idOs 
                AND (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) 
                LIMIT 1) as desenhoTrue,
            unidade_execucao.status_execucao, unidade_faturamento.status_faturamento,
            os_tipo.nome_tipo, status_os.nomeStatusOs, emitente.nome, nf_cliente, nomeArquivo,
            vendedores.nomeVendedor, status_escopo.descricaoEscopo, tipo_qtd.descricaoTipoQtd,
            usuarios.nome AS usuario_nf
        FROM os
        JOIN orcamento_item ON orcamento_item.idOrcamento_item = os.idOrcamento_item
        JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos
        JOIN grupo_servico ON grupo_servico.idGrupoServico = orcamento.idGrupoServico
        JOIN emitente ON emitente.id = orcamento.idEmitente
        JOIN clientes ON clientes.idClientes = orcamento.idClientes
        JOIN clientes_solicitantes ON clientes_solicitantes.idSolicitante = orcamento.idSolicitante
        JOIN produtos ON produtos.idProdutos = orcamento_item.idProdutos
        JOIN vendedores ON vendedores.idVendedor = orcamento.idVendedor
        JOIN status_os ON status_os.idStatusOs = os.idStatusOs
        LEFT JOIN unidade_execucao ON unidade_execucao.id_unid_exec = os.unid_execucao
        LEFT JOIN unidade_faturamento ON unidade_faturamento.id_unid_fat = os.unid_faturamento
        LEFT JOIN os_tipo ON os_tipo.id_tipo = os.id_tipo
        LEFT JOIN tipo_qtd ON tipo_qtd.idTipoQtd = orcamento_item.idTipoQtd
        LEFT JOIN verificacao_controle ON verificacao_controle.idVerificacaoControle = os.idVerificacaoControle
        LEFT JOIN orc_servico_escopo ON orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item AND orc_servico_escopo.ativo = 1
        LEFT JOIN status_escopo ON status_escopo.idStatusEscopo = orc_servico_escopo.idStatusEscopo
        LEFT JOIN anexo_nfcliente ON anexo_nfcliente.idOs = os.idOs

        -- === Novo JOIN: busca o usuário emissor da NF (apenas se NF existir) ===
        LEFT JOIN (
            SELECT h1.idOs, h1.idUserHis
            FROM os_history h1
            INNER JOIN (
                SELECT idOs, MAX(idOsHis) AS max_id
                FROM os_history
                WHERE idUserHis IS NOT NULL
                GROUP BY idOs
            ) h2 ON h1.idOs = h2.idOs AND h1.idOsHis = h2.max_id
        ) AS ult_hist 
            ON ult_hist.idOs = os.idOs
            AND os.numero_nf IS NOT NULL 
            AND os.numero_nf <> 0 
            AND os.data_nf_faturamento IS NOT NULL
        LEFT JOIN usuarios ON usuarios.idUsuarios = ult_hist.idUserHis

        WHERE 1=1 
            AND orcamento_item.status_item = 2 
            $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $tag1 $numero_nf1 
            $query_status_producao1 $query_unid_execucao1 $query_unid_faturamento1 
            $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 
            $queryentrega_reagendada1 $descricao_item1 $query_tipoos1 $unidade_execucao1 
            $query_desenhoTrue $query_clientes3 $query_verifControl $numero_nffab1 
            $numero_nfserv1 $vendedor $status_per $idGrupoServico1 $queryDataProducao $queryDataReprog1
        GROUP BY os.idOs 
        ORDER BY os.idOs $order
    ";

    return $this->db->query($query)->result();
}

function getOsPendente($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '', $tag = '', $numero_nf = '', $descricao_item = '', $tipo = '', $unidade_execucao = '', $query_status_producao = '', $query_unid_execucao = '', $query_unid_faturamento = '', $querydataentrega = '', $querydatacadastro = '', $querydatareagendada = '', $query_clientes = '', $queryentrega_reagendada = '', $query_tipoos = '', $query_desenhoTrue = '', $query_clientes3 = '', $query_verifControl = '', $numero_nffab = '', $numero_nfserv = '', $vendedor = '', $status_escopo = '', $idGrupoServico = '', $queryDataProducao = '', $queryDataReprog = '')

{
    // === Filtros existentes preservados ===
    $query_tipoos1 = ($query_tipoos <> '') ? " and os.id_tipo in " . $query_tipoos : '';
    $order = ($tipo == 'c') ? "asc" : "desc";
    $query_clientes1 = ($query_clientes <> '') ? " and clientes.idClientes in " . $query_clientes : '';
    $querydataentrega1 = ($querydataentrega <> '') ? $querydataentrega : '';
    $queryentrega_reagendada1 = ($queryentrega_reagendada <> '') ? $queryentrega_reagendada : '';
    $querydatacadastro1 = ($querydatacadastro <> '') ? $querydatacadastro : '';
    $querydatareagendada1 = ($querydatareagendada <> '') ? $querydatareagendada : '';
    $query_status_producao1 = ($query_status_producao <> '') ? " and os.idStatusOs in " . $query_status_producao : '';
    $query_unid_execucao1 = ($query_unid_execucao <> '') ? " and os.unid_execucao in " . $query_unid_execucao : '';
    $query_unid_faturamento1 = ($query_unid_faturamento <> '') ? " and os.unid_faturamento in " . $query_unid_faturamento : '';
    $cod_orc1 = ($cod_orc <> '') ? " and os.idOrcamentos = ".(int)$cod_orc : '';
    $clientes_id1 = ($clientes_id <> '') ? " and orcamento.idClientes = ".(int)$clientes_id : '';
    $idOs1 = ($idOs <> '') ? " and os.idOs in (".implode(',', array_filter(array_map('intval', explode(',', $idOs)))).")": '';
    $idProdutos1 = ($idProdutos <> '') ? " and produtos.idProdutos = ".(int)$idProdutos : '';
    $numpedido_os1 = ($numpedido_os <> '') ? " and os.numpedido_os = '".$this->db->escape_str($numpedido_os)."'" : '';
    $tag1 = ($tag <> '') ? " and os.tag like '%".$this->db->escape_like_str($tag)."%'" : '';
    $numero_nf1 = ($numero_nf <> '') ? " and os.nf_cliente = ".(int)$numero_nf : '';
    $descricao_item1 = ($descricao_item <> '') ? " and orcamento_item.descricao_item like '%".$this->db->escape_like_str($descricao_item)."%'" : '';
    $unidade_execucao1 = ($unidade_execucao <> '') ? " and os.unid_execucao = ".(int)$unidade_execucao : '';
    $numero_nffab1 = ($numero_nffab <> '') ? " and os.nf_venda_dev = ".(int)$numero_nffab : '';
    $numero_nfserv1 = ($numero_nfserv <> '') ? " and os.numero_nf = ".(int)$numero_nfserv : '';
    $status_per = ($status_escopo <> '') ? " and orc_servico_escopo.idStatusEscopo in (".implode(',', array_filter(array_map('intval', (array)$status_escopo))). ")" : '';
    $idGrupoServico1 = ($idGrupoServico <> '') ? " and orcamento.idGrupoServico = ".(int)$idGrupoServico : '';
    
    // === NOVO FILTRO CIRÚRGICO: Reprogramação ===
    $queryDataReprog1 = ($queryDataReprog <> '') ? $queryDataReprog : '';

    // === Consulta principal preservada e ampliada ===
    $query = "
        SELECT 
            os.data_abertura_real,
            os.data_insert,
            verificacao_controle.descricaoControle,
            verificacao_controle.idVerificacaoControle,
            os.numpedido_os,
            os.data_devolucao,
            clientes_solicitantes.nome as clisol,
            os.data_nf_faturamento,
            os.val_ipi_os, os.tag, os.idOs, os.data_abertura, os.data_entrega, 
            os.data_expedicao, os.data_canhoto, os.data_reagendada, os.data_planejada,
            os.statusDesenho, os.obsDesenho, os.data_producao, os.nf_venda_dev, os.numero_nf, 
            os.nf_canhoto, os.idOrcamentos, clientes.nomeCliente, clientes.nomeClienteCart,
            produtos.pn, orcamento_item.descricao_item, os.qtd_os, os.val_unit_os, 
            grupo_servico.idGrupoServico, grupo_servico.nome as nomeServico,
            os.desconto_os, os.subtot_os, 
            (SELECT anexo_desenho.idAnexo 
                FROM anexo_desenho 
                WHERE anexo_desenho.idOs = os.idOs 
                AND (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) 
                LIMIT 1) as desenhoTrue,
            unidade_execucao.status_execucao, unidade_faturamento.status_faturamento,
            os_tipo.nome_tipo, status_os.nomeStatusOs, emitente.nome, nf_cliente, nomeArquivo,
            vendedores.nomeVendedor, status_escopo.descricaoEscopo, tipo_qtd.descricaoTipoQtd,
            usuarios.nome AS usuario_nf
        FROM os
        JOIN orcamento_item ON orcamento_item.idOrcamento_item = os.idOrcamento_item
        JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos
        JOIN grupo_servico ON grupo_servico.idGrupoServico = orcamento.idGrupoServico
        JOIN emitente ON emitente.id = orcamento.idEmitente
        JOIN clientes ON clientes.idClientes = orcamento.idClientes
        JOIN clientes_solicitantes ON clientes_solicitantes.idSolicitante = orcamento.idSolicitante
            AND clientes_solicitantes.idClientes = clientes.idClientes
        JOIN produtos ON produtos.idProdutos = orcamento_item.idProdutos
        JOIN vendedores ON vendedores.idVendedor = orcamento.idVendedor
        JOIN status_os ON status_os.idStatusOs = os.idStatusOs
        LEFT JOIN unidade_execucao ON unidade_execucao.id_unid_exec = os.unid_execucao
        LEFT JOIN unidade_faturamento ON unidade_faturamento.id_unid_fat = os.unid_faturamento
        LEFT JOIN os_tipo ON os_tipo.id_tipo = os.id_tipo
        LEFT JOIN verificacao_controle ON verificacao_controle.idVerificacaoControle = os.idVerificacaoControle
        LEFT JOIN orc_servico_escopo ON orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item AND orc_servico_escopo.ativo = 1
        LEFT JOIN status_escopo ON status_escopo.idStatusEscopo = orc_servico_escopo.idStatusEscopo
        LEFT JOIN tipo_qtd ON tipo_qtd.idTipoQtd = orcamento_item.idTipoQtd
        LEFT JOIN anexo_nfcliente ON anexo_nfcliente.idOs = os.idOs

        -- === Novo JOIN para identificar o usuário emissor da NF ===
        LEFT JOIN (
            SELECT h1.idOs, h1.idUserHis
            FROM os_history h1
            INNER JOIN (
                SELECT idOs, MAX(idOsHis) AS max_id
                FROM os_history
                WHERE idUserHis IS NOT NULL
                GROUP BY idOs
            ) h2 ON h1.idOs = h2.idOs AND h1.idOsHis = h2.max_id
        ) AS ult_hist 
            ON ult_hist.idOs = os.idOs
            AND os.numero_nf IS NOT NULL 
            AND os.numero_nf <> 0 
            AND os.data_nf_faturamento IS NOT NULL
        LEFT JOIN usuarios ON usuarios.idUsuarios = ult_hist.idUserHis

        WHERE 1=1 
            AND orcamento_item.status_item = 0 
            
            $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $tag1 $numero_nf1 
            $query_status_producao1 $query_unid_execucao1 $query_unid_faturamento1 
            $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 
            $queryentrega_reagendada1 $descricao_item1 $query_tipoos1 $unidade_execucao1 
            $query_desenhoTrue $query_clientes3 $query_verifControl $numero_nffab1 
            $numero_nfserv1 $vendedor $status_per $idGrupoServico1 $queryDataProducao $queryDataReprog1
        GROUP BY os.idOs 
        ORDER BY os.idOs $order
    ";

    return $this->db->query($query)->result();
}
	function getLastSaleByIdProdutos($idProduto){
		$query = "SELECT sum(os.val_unit_os*os.qtd_os) as valor_total, sum(os.qtd_os) as quantidade FROM os JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item WHERE os.idStatusOs in (6,89) and os.unid_execucao = 2 and orcamento_item.idProdutos = ?";
		return $this->db->query($query, array((int)$idProduto))->row();
	}
	function getLastOsByPn($pn){
		$query = "SELECT os.idOs, os.qtd_os FROM orcamento_item JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos join os on os.idOrcamento_item = orcamento_item.idOrcamento_item and os.idStatusOs in (6,89) and os.unid_execucao = 2 JOIN distribuir_os on distribuir_os.idOs = os.idOs and distribuir_os.idStatuscompras = 5 WHERE distribuir_os.idDistribuir is not null and produtos.pn = ? 
			order by os.data_abertura_real desc LIMIT 1 ";
		return $this->db->query($query, array($pn))->row();
	}
	function getMaterialEntregueByIdOs($idOs){
		$query = "SELECT insumos.descricaoInsumo,distribuir_os.dimensoes,distribuir_os.dimensoesL,distribuir_os.dimensoesC,distribuir_os.dimensoesA,distribuir_os.quantidade as quantidade_insumo FROM distribuir_os join insumos on insumos.idInsumos = distribuir_os.idInsumos where distribuir_os.idOs = ?";
		return $this->db->query($query, array((int)$idOs))->result();
	}

	function getOSSemMateriais($where = ''){
		$query = "SELECT os.data_abertura_real,
		os.data_insert,
		verificacao_controle.descricaoControle,
		verificacao_controle.idVerificacaoControle,
		os.numpedido_os,
		os.val_ipi_os,os.tag,os.idOs,os.`data_abertura`,
		os.`data_entrega`,os.`data_expedicao`,
		os.`data_canhoto`,os.`data_reagendada`, 
		os.`data_planejada`,
		os.statusDesenho, os.obsDesenho, 
		os.nf_venda_dev, os.numero_nf, 
		os.nf_venda_dev, os.nf_canhoto,
		os.`data_producao`,
		os.`idOrcamentos`,clientes.nomeCliente,clientes.nomeClienteCart,produtos.pn,orcamento_item.descricao_item,os.qtd_os,os.val_unit_os,grupo_servico.idGrupoServico,grupo_servico.nome as nomeServico,
		os.desconto_os,os.subtot_os, (SELECT anexo_desenho.idAnexo from anexo_desenho where anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue,
		unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,
		os_tipo.nome_tipo,status_os.nomeStatusOs, emitente.nome, nf_cliente, nomeArquivo,
		vendedores.nomeVendedor,
		status_escopo.descricaoEscopo,
		tipo_qtd.descricaoTipoQtd
		FROM (`os`)
		JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
		JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos 
		JOIN grupo_servico on grupo_servico.idGrupoServico = orcamento.idGrupoServico 
		JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` 
		JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` 
		JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos 
		JOIN vendedores on vendedores.idVendedor = orcamento.idVendedor 
		join status_os on status_os.idStatusOs = os.idStatusOs 
		left join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao 
		left join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento 
		left join os_tipo on os_tipo.id_tipo = os.id_tipo 
		left join verificacao_controle on verificacao_controle.idVerificacaoControle = os.idVerificacaoControle
		left join orc_servico_escopo on orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item and orc_servico_escopo.ativo = 1
		left join status_escopo on status_escopo.idStatusEscopo = orc_servico_escopo.idStatusEscopo
		left join tipo_qtd on tipo_qtd.idTipoQtd = orcamento_item.idTipoQtd 
		LEFT JOIN anexo_nfcliente ON anexo_nfcliente.idOs = os.idOs
		left join distribuir_os on distribuir_os.idOs = os.idOs
			where 1=1 and distribuir_os.idDistribuir is null $where";
		return $this->db->query($query)->result();
	}

	function getOsFactory(){																																																																																																																																																										  																					
		$query = "SELECT os.idOs,produtos.pn,unidade_execucao.status_execucao, os.qtd_os, clientes.nomeCliente, orcamento_item.descricao_item, os.data_entrega, orcamento.idClientes,tipo_qtd.descricaoTipoQtd FROM os join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao join produtos on produtos.idProdutos = orcamento_item.idProdutos join orcamento on orcamento.idOrcamentos = orcamento_item.idOrcamentos join clientes on clientes.idClientes = orcamento.idClientes join tipo_qtd on tipo_qtd.idTipoQtd = orcamento_item.idTipoQtd WHERE idStatusOs in (5,20,25,28,90,100,101,208) and os.idOs > 10000";
		return $this->db->query($query)->result();
	}

	function getOsReagendada(){
		$query = 'SELECT DISTINCT os.idOs FROM `historico_alteracoes` JOIN os on os.idOs = historico_alteracoes.alt_id and alt_table = "os" WHERE alt like "%data_reagendada%" and os.data_reagendada is not null and os.idStatusOs in (5,9,12,20,25,28,30,32,40,42,71,78,85,86,87,88,90,92,93,94,95,100) ORDER BY historico_alteracoes.data_alteracao desc';
		return $this->db->query($query)->result();
	}
	
		function getOsPlanejada(){
		$query = 'SELECT DISTINCT os.idOs FROM `historico_alteracoes` JOIN os on os.idOs = historico_alteracoes.alt_id and alt_table = "os" WHERE alt like "%data_planejada%" and os.data_planejada is not null and os.idStatusOs in (5,9,12,20,25,28,30,32,40,42,71,78,85,86,87,88,90,92,93,94,95,100) ORDER BY historico_alteracoes.data_alteracao desc';
		return $this->db->query($query)->result();
	}
	
	
	
	
	
	//NOVA FUNÇÃO ADICIONADA PARA TRANSFERÊNCIA DE INSUMOS
function transferirInsumoOs($idDistribuirOrigem, $qtdTransferir, $idOsDestino, $idOsOrigem)
{
    $this->db->trans_begin();

    $itemOrigem = $this->getByid_table($idDistribuirOrigem, 'distribuir_os', 'idDistribuir');

    if (!$itemOrigem) {
        $this->db->trans_rollback();
        return "Erro: O item de origem (#" . $idDistribuirOrigem . ") não foi encontrado.";
    }

    $quantidadeOriginal = isset($itemOrigem->quantidade) ? (float)$itemOrigem->quantidade : 0;
    if ($quantidadeOriginal < $qtdTransferir) {
        $this->db->trans_rollback();
        return "Erro: A quantidade a transferir (" . $qtdTransferir . ") é maior que a disponível (" . $quantidadeOriginal . ").";
    }

    $osDestinoObj = $this->getById($idOsDestino);
    if (!$osDestinoObj) {
        $this->db->trans_rollback();
        return "Erro: A OS de Destino (#" . $idOsDestino . ") não existe.";
    }

    // --- Lógica das Observações (mantida como estava correta) ---
    $dataHoraTransferencia = date('d/m/Y H:i:s');
    $nomeUsuario = $this->session->userdata('nome') ? $this->session->userdata('nome') : 'Sistema';
    $obsOriginalAntiga = isset($itemOrigem->obs) ? $itemOrigem->obs : '';
    $notaTransferenciaOrigem = " [Transferido " . $qtdTransferir . " un. para OS #" . $idOsDestino . " por " . $nomeUsuario . " em " . $dataHoraTransferencia . "]";
    $novaObsOrigem = $obsOriginalAntiga . $notaTransferenciaOrigem;
    $notaTransferenciaDestino = "[Transferência de " . $qtdTransferir . " un. para OS #" . $idOsDestino . " por " . $nomeUsuario . " em " . $dataHoraTransferencia . "]";
    $novaObsDestino = "Transferido da OS #" . $idOsOrigem . ". Obs original: " . ($obsOriginalAntiga ?: '(nenhuma)') . " " . $notaTransferenciaDestino;

    // --- Atualiza o item na OS de origem ---
    $novaQtdOrigem = $quantidadeOriginal - $qtdTransferir;
    $dadosUpdateOrigem = array(
        'quantidade' => $novaQtdOrigem,
        'data_alteracao' => date('Y-m-d H:i:s'),
        'obs' => $novaObsOrigem
    );
    if (!$this->edit('distribuir_os', $dadosUpdateOrigem, 'idDistribuir', $idDistribuirOrigem)) {
        $this->db->trans_rollback(); return "Erro ao atualizar o item na OS de origem.";
    }

    // --- Prepara os dados para o novo item 'distribuir_os' na OS de destino ---
    $dadosNovoItemDistribuirOs = (array) $itemOrigem;
    unset($dadosNovoItemDistribuirOs['idDistribuir']); // Remove PK para nova inserção
    $dadosNovoItemDistribuirOs['idOs'] = $idOsDestino;
    $dadosNovoItemDistribuirOs['quantidade'] = $qtdTransferir;
    $dadosNovoItemDistribuirOs['data_cadastro'] = date('Y-m-d H:i:s');
    $dadosNovoItemDistribuirOs['usuario_cadastro'] = $this->session->userdata('idUsuarios');
    $dadosNovoItemDistribuirOs['data_alteracao'] = null;
    $dadosNovoItemDistribuirOs['obs'] = $novaObsDestino;
    $dadosNovoItemDistribuirOs['idStatuscompras'] = 1; // Resetar status
    // ... (resetar outros campos de status/aprovação conforme necessário) ...

    $idDistribuirNovo = $this->add('distribuir_os', $dadosNovoItemDistribuirOs, true);
    if (!$idDistribuirNovo) {
        $this->db->trans_rollback(); return "Erro ao criar o novo item de distribuição na OS de destino.";
    }

    // --- Lógica para vincular ao custo de pedido_comprasitens ---
    $originalCotacaoItem = $this->db->get_where('pedido_cotacaoitens', array('idDistribuir' => $idDistribuirOrigem))->row();

    if ($originalCotacaoItem && isset($originalCotacaoItem->idCotacaoItens)) {
        // 1. Buscar o pedido_comprasitens original para obter o valor_unitario
        $originalCompraItem = $this->db->get_where('pedido_comprasitens', array('idCotacaoItens' => $originalCotacaoItem->idCotacaoItens))->row();

        if ($originalCompraItem) {
            // 2. Criar um novo pedido_cotacaoitens para o novo distribuir_os
            $dadosNovaCotacaoItem = (array) $originalCotacaoItem;
            $pkCotacaoItens = 'idCotacaoItens'; // Chave Primária de pedido_cotacaoitens
            if (isset($dadosNovaCotacaoItem[$pkCotacaoItens])) {
                unset($dadosNovaCotacaoItem[$pkCotacaoItens]); // Remove PK para gerar uma nova
            }
            $dadosNovaCotacaoItem['idDistribuir'] = $idDistribuirNovo;
            // Copiar outros campos relevantes de $originalCotacaoItem para $dadosNovaCotacaoItem, se houver
            
            $idCotacaoItensNovo = $this->add('pedido_cotacaoitens', $dadosNovaCotacaoItem, true); // Obter o novo PK gerado

            if ($idCotacaoItensNovo) {
                // 3. Criar um NOVO pedido_comprasitens, copiando dados do original, mas apontando para o NOVO idCotacaoItens
                $dadosNovaCompraItem = (array) $originalCompraItem;
                
                // !!! IMPORTANTE: Verifique o nome da PK da sua tabela 'pedido_comprasitens' !!!
                $pkCompraItens = 'idPedidoCompraItens'; // Exemplo, substitua pelo nome correto se for diferente
                if (isset($dadosNovaCompraItem[$pkCompraItens])) {
                    unset($dadosNovaCompraItem[$pkCompraItens]); // Remove PK para gerar uma nova
                }
                
                $dadosNovaCompraItem['idCotacaoItens'] = $idCotacaoItensNovo; // Aponta para o NOVO pedido_cotacaoitens
                // Copiar valor_unitario e outros campos relevantes de $originalCompraItem para $dadosNovaCompraItem
                // $dadosNovaCompraItem['valor_unitario'] já está em $originalCompraItem e será copiado
                // Se houver outros campos importantes em pedido_comprasitens, eles também serão copiados.

                if (!$this->add('pedido_comprasitens', $dadosNovaCompraItem, false)) {
                    $this->db->trans_rollback();
                    log_message('error', 'Falha ao duplicar pedido_comprasitens para idCotacaoItensNovo: ' . $idCotacaoItensNovo);
                    return "Erro ao duplicar os dados de compra para o item transferido.";
                }
            } else {
                $this->db->trans_rollback();
                log_message('error', 'Falha ao inserir novo pedido_cotacaoitens para idDistribuirNovo: ' . $idDistribuirNovo);
                return "Erro ao replicar os dados de cotação para o item transferido.";
            }
        } else {
            log_message('warn', 'Transferência: pedido_comprasitens original não encontrado para idCotacaoItens: ' . $originalCotacaoItem->idCotacaoItens . '. Custo não pode ser vinculado.');
            // Considerar se deve dar rollback ou permitir a transferência sem custo vinculado
        }
    } else {
        log_message('info', 'Transferência: Item de cotação original (pedido_cotacaoitens) não encontrado para idDistribuir: ' . $idDistribuirOrigem . '. O vínculo com a compra/custo não será replicado.');
    }

    if ($this->db->trans_status() === false) {
        $this->db->trans_rollback();
        return "Ocorreu um erro no banco de dados e a operação foi cancelada.";
    } else {
        $this->db->trans_commit();
        return true;
    }
}


	public function getOsForClient($idOs, $idCliente) {
		if (is_array($idCliente)) {
			$idCliente = reset($idCliente);
		}
		$idCliente = (int)$idCliente;
		$this->db->select('os.*, orcamento.idClientes, clientes.nomeCliente');
		$this->db->from('os');
		$this->db->join('orcamento', 'os.idOrcamentos = orcamento.idOrcamentos');
		$this->db->join('clientes', 'orcamento.idClientes = clientes.idClientes');
		$this->db->where('os.idOs', $idOs);
		$this->db->where('orcamento.idClientes', $idCliente);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	
		// Nova função para buscar os motivos da reprogramação que implementamos
public function getMotivosReagendamento($idOs) {
    $this->db->select('os_reagendada_motivo.*, usuarios.nome as usuario_nome');
    $this->db->from('os_reagendada_motivo');

	// Correção: idUsuarios alterado para usuario_id
	$this->db->join('usuarios', 'os_reagendada_motivo.usuario_id = usuarios.idUsuarios');
    $this->db->where('os_reagendada_motivo.idOs', $idOs);
    // ✅ ISSO É VITAL: Garante que o último clique (mesmo vazio) venha primeiro
    $this->db->order_by('idMotivoReag', 'DESC'); 
    return $this->db->get()->result();
}

// Busca a última data de reprogramação da tabela de motivos para uma OS específica
public function getLastReagendada($idOs) {
    $this->db->select('data_reagendada');
    $this->db->from('os_reagendada_motivo');
    $this->db->where('idOs', $idOs);
    $this->db->order_by('idMotivoReag', 'DESC'); // Essencial para pegar o último clique
    $this->db->limit(1);
    $query = $this->db->get();
    return ($query->num_rows() > 0) ? $query->row()->data_reagendada : null;
}
// Verifica se a OS já possui uma reprogramação com o motivo 'Ajuste de Data'
    public function checkMotivoAjusteData($idOs) {
        $this->db->where('idOs', $idOs);
        // Usa LIKE para evitar problemas com letras maiúsculas/minúsculas
        $this->db->like('motivo', 'Ajuste de Data'); 
        $query = $this->db->get('os_reagendada_motivo');
        
        // Retorna TRUE se já existir, FALSE se não existir
        return $query->num_rows() > 0;
    }
}