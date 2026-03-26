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
	public function OSCustom($idOs){
       
     
        
       
       $query = "SELECT emitente.url_logo as url_logoemi, emitente.imagem as imagememi,emitente.nome as nomeemi, clientes.idClientes as idcli, clientes.nomeCliente as nomecli , produtos.idProdutos,os.idSimplexAtividade , produtos.descricao , produtos.pn , orcamento_item.detalhe,grupo_servico.nome as grupo,status_os.nomeStatusOs,os.obs_os,os.numpedido_os,os.tag,os.obs_controle,unidade_execucao.status_execucao, unidade_faturamento.status_faturamento, os_tipo.nome_tipo, os.`idOs`, os.`data_abertura`,os.`data_entrega`,os.`idStatusOs`,os.`data_reagendada`,os.`tiposervico`,os.`idOrcamentos`, os.qtd_os,orcamento_item.descricao_item,(SELECT anexo_desenho.idAnexo from anexo_desenho where anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue FROM (`os`) join orcamento on orcamento.idOrcamentos = os.idOrcamentos JOIN orcamento_item ON orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `status_os` ON `status_os`.`idStatusOs` = `os`.`idStatusOs` join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento left join os_tipo on os_tipo.id_tipo = os.id_tipo left join anexo_desenho on anexo_desenho.idOs = os.idOs where os.idOs = $idOs group by anexo_desenho.idOs";
		
        
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
	public function getStatusOs()
    {
        $this->db->order_by('ordem','asc');
        return $this->db->get('status_os')->result();
       
    }
	 public function get_table($table)
    {
		 return $this->db->get($table)->result();
	 }
	public function getdesenho_os($id)
    {
	 $query = "SELECT * FROM `anexo_desenho`, usuarios WHERE `user_proprietario` = idUsuarios and `idOs` =  $id";
		
        
        return $this->db->query($query)->result();
		
			
	       
		
    }
	public function getnf_os($id,$table)
    {
	
		
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

		$query2 = 'SELECT insumos.*, (select SUM(quantidade) from almo_estoque where almo_estoque.idProduto = insumos.idInsumos and almo_estoque.idEmitente = 1 ) as qtdEst FROM `insumos` where insumos.descricaoInsumo like "%'.$q.'%"';
        $query = $this->db->query($query2)->result();

        
        if(count($query) > 0){
			 
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->descricaoInsumo.' | ID: '.$row->idInsumos,'id'=>$row->idInsumos, 'estoque'=>$row->qtdEst );
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
	public function getmaterial_dist($id,$ordertipo='',$campo = '',$limit = '',$where = ''){
		
       	$this->db->select('insumos.*,distribuir_os.*,distribuir_os.data_cadastro as datacadastro,produtos.*,status_grupo_compra.*,pedido_comprasitens.previsao_entrega,pedido_comprasitens.valor_unitario,pedido_comprasitens.valor_total,pedido_comprasitens.ipi_valor ,usuarios.*,statuscompras.*');
        $this->db->from('distribuir_os');
        $this->db->join('insumos','insumos.idInsumos = distribuir_os.idInsumos');
        $this->db->join('produtos','produtos.idProdutos = distribuir_os.idProdutos','left');
        $this->db->join('status_grupo_compra','status_grupo_compra.idgrupo = distribuir_os.id_status_grupo','left');
		$this->db->join('pedido_cotacaoitens','pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir','left');
		$this->db->join('pedido_comprasitens','pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens','left');
		 $this->db->join('usuarios','usuarios.idUsuarios = distribuir_os.usuario_cadastro','left');
        $this->db->join('statuscompras','statuscompras.idStatuscompras = distribuir_os.idStatuscompras');
		if(!empty($where)){
			$where = $where.' and idOs = '.$id;
		}else{
			$where = 'idOs = '.$id;
		}
        $this->db->where($where);
		if(!empty($limit)){
			$this->db->limit(150);
		}
		if(!empty($ordertipo) && !empty($campo))
		{
		 $this->db->order_by($campo,$ordertipo);
		}
        return $this->db->get()->result();
    }
	public function calculadif($hora_inicial, $hora_final) {
		$i = 1;
		$tempo_total = 0;

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
        
       $query = "
          SELECT horasmaquinas.idHoramaquinas, horasmaquinas.`obs`, horasmaquinas.`horainicio`, horasmaquinas.`horafim`, maquinas.nome, maquinasusuarios.nome_UserMaquinas FROM `horasmaquinas`,  maquinas, maquinasusuarios WHERE horasmaquinas.`idMaquinas` = 	maquinas.idMaquinas and horasmaquinas.`idUserMaquinas` = maquinasusuarios.idUserMaquinas and horasmaquinas.idos = $id
        ";
        
        return $this->db->query($query)->result();
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
        $this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
        $this->db->join('emitente', 'emitente.id = orcamento.idEmitente');
        $this->db->join('clientes', 'clientes.idClientes = orcamento.idClientes');
        $this->db->join('status_os', 'status_os.idStatusOs = os.idStatusOs');
		$this->db->join('verificacao_controle', 'verificacao_controle.idVerificacaoControle = os.idVerificacaoControle');
        $this->db->join('unidade_execucao', 'unidade_execucao.id_unid_exec = os.unid_execucao');
		$this->db->join('anexo_desenho', 'anexo_desenho.idOs = os.idOs','left');
        $this->db->join('unidade_faturamento', 'unidade_faturamento.id_unid_fat = os.unid_faturamento');
        $this->db->join('os_tipo', 'os_tipo.id_tipo = os.id_tipo','left');
        
		
		
		
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
								
	public function getWhereLikeos($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '', $tag = '',$numero_nf = '',$descricao_item = '',$tipo = '',$unidade_execucao = '',$query_status_producao = '',$query_unid_execucao = '',$query_unid_faturamento = '',$querydataentrega = '',$querydatacadastro = '',$querydatareagendada = '',$query_clientes = '' ,$queryentrega_reagendada = '', $query_tipoos='',$query_desenhoTrue = '',$query_clientes3 = '',$query_verifControl = '',$numero_nffab = '',$numero_nfserv = '')
    {
		if($query_tipoos <> '')
		{
			$query_tipoos1 = " and os.id_tipo in ".$query_tipoos;
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
			 $numpedido_os1 = " and os.numpedido_os = '".$numpedido_os."'";
		}
		else
		{
			$numpedido_os1 = '';
		}
		if($tag <> '')
		{
			 $tag1 = " and os.tag like '%".$tag."%'";
		}
		else
		{
			$tag1 = '';
		}
		if($numero_nf <> '')
		{
			  $numero_nf1 = " and os.nf_cliente = ".$numero_nf;
		}
		else
		{
			$numero_nf1 = '';
		}
		if($numero_nfserv <> '')
		{
			  $numero_nfserv1 = " and os.numero_nf = ".$numero_nfserv;
		}
		else
		{
			$numero_nfserv1 = '';
		}
		if($numero_nffab <> '')
		{
			  $numero_nffab1 = " and os.nf_venda_dev = ".$numero_nffab;
		}
		else
		{
			$numero_nffab1 = '';
		}
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$descricao_item."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
		if($unidade_execucao <> '')
		{
			$unidade_execucao1 = " and os.unid_execucao = ".$unidade_execucao;
		}
		else
		{
			$unidade_execucao1 = '';
		}
		
         
        $query = "
			SELECT verificacao_controle.descricaoControle,verificacao_controle.idVerificacaoControle,os.numpedido_os,os.val_ipi_os,os.tag,os.idOs,os.`data_abertura`,os.`data_entrega`,os.`data_reagendada`, os.statusDesenho, os.obsDesenho, os.nf_venda_dev, os.numero_nf, os.nf_venda_dev, os.nf_canhoto,
			os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,os.val_unit_os,grupo_servico.idGrupoServico,
			os.desconto_os,os.subtot_os, (SELECT anexo_desenho.idAnexo from anexo_desenho where anexo_desenho.idOs = os.idOs and (anexo_desenho.user_proprietario =12 OR anexo_desenho.user_proprietario =13) LIMIT 1) as desenhoTrue,
			unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,
			os_tipo.nome_tipo,status_os.nomeStatusOs, emitente.nome, nf_cliente, nomeArquivo
			FROM (`os`) JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos 
			JOIN grupo_servico on grupo_servico.idGrupoServico = orcamento.idGrupoServico JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` 
			JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos 
			join status_os on status_os.idStatusOs = os.idStatusOs join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao 
			join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento left join os_tipo on os_tipo.id_tipo = os.id_tipo 
			join verificacao_controle on verificacao_controle.idVerificacaoControle = os.idVerificacaoControle
			LEFT JOIN anexo_nfcliente ON anexo_nfcliente.idOs = os.idOs
			where 1=1 $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $tag1 $numero_nf1 $query_status_producao1 $query_unid_execucao1 
			$query_unid_faturamento1 $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 $queryentrega_reagendada1 $descricao_item1
			$query_tipoos1 $unidade_execucao1 $query_desenhoTrue $query_clientes3 $query_verifControl $numero_nffab1 $numero_nfserv1 GROUP BY os.idOs ORDER BY `os`.`idOs` $order";
        
        return $this->db->query($query)->result();
       
    }
	
	
	
	public function getWhereLikeos_status($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '',$tag = '', $numero_nf = '',$descricao_item = '',$tipo = '',$unidade_execucao = '',$query_status_producao = '',$query_unid_execucao = '',$query_unid_faturamento = '',$querydataentrega = '',$querydatacadastro = '',$querydatareagendada = '',$query_clientes = '' ,$queryentrega_reagendada = '',$status1 = '',$query_tipoos = '',$desenhoTrue = '',$query_clientes3 = '')
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
		if($query_tipoos <> '')
		{
			$novotipo = " and os.id_tipo in ".$query_tipoos;
			
		}
		else
		{
			$novotipo = '';
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
		if($tag <> '')
		{
			 $tag1 = " and os.tag like '%".$tag."%'";
		}
		else
		{
			$tag1 = '';
		}
		if($numero_nf <> '')
		{
			 $numero_nf1 = " and os.nf_cliente = ".$numero_nf;
		}
		else
		{
			$numero_nf1 = '';
		}
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$descricao_item."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
		if($unidade_execucao <> '')
		{
			$unidade_execucao1 = " and os.unid_execucao = ".$unidade_execucao;
		}
		else
		{
			$unidade_execucao1 = '';
		}
        
        $query = "
          SELECT sum(((os.qtd_os * os.val_unit_os) - os.desconto_os) + ((os.qtd_os * os.val_unit_os) - os.desconto_os) * os.`val_ipi_os`/100) as soma,unidade_execucao.status_execucao,status_os.nomeStatusOs, count(os.idOs) as qtdos FROM (`os`) JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos join status_os on status_os.idStatusOs = os.idStatusOs join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento where 1=1 $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $tag1 $numero_nf1 $query_status_producao1 $query_unid_execucao1 $query_unid_faturamento1 $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 $queryentrega_reagendada1 $descricao_item1  $status1 $novotipo $unidade_execucao1 $query_clientes3 group by os.unid_execucao,os.idStatusOs ORDER BY unidade_execucao.status_execucao,status_os.nomeStatusOs
        ";
        
        return $this->db->query($query)->result();
       
    }
    public function numrowsWhereLikeos($idOs = '', $cod_orc = '', $clientes_id = '', $idProdutos = '', $numpedido_os = '',$tag = '', $numero_nf = '',$descricao_item = '',$tipo = '',$unidade_execucao = '',$query_status_producao = '',$query_unid_execucao = '',$query_unid_faturamento = '',$querydataentrega = '',$querydatacadastro = '',$querydatareagendada = '',$query_clientes = '',$queryentrega_reagendada = '', $query_tipoos='')
    {
		if($query_tipoos <> '')
		{
			$query_tipoos1 = " and os.id_tipo in ".$query_tipoos;
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
		if($tag <> '')
		{
			 $tag1 = " and os.tag like '%".$tag."%'";
		}
		else
		{
			$tag1 = '';
		}
		if($numero_nf <> '')
		{
			  $numero_nf1 = " and os.nf_cliente = ".$numero_nf;
		}
		else
		{
			$numero_nf1 = '';
		}
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$descricao_item."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
		if($unidade_execucao <> '')
		{
			$unidade_execucao1 = " and os.unid_execucao = ".$unidade_execucao;
		}
		else
		{
			$unidade_execucao1 = '';
		}
        $query = "
             SELECT os.numpedido_os,os.val_ipi_os,os.tag,os.idOs,os.`data_abertura`,os.`data_entrega`,os.`data_reagendada`,os.`idOrcamentos`,clientes.nomeCliente,produtos.pn,orcamento_item.descricao_item,os.qtd_os,os.desconto_os,os.val_unit_os,os.subtot_os,unidade_execucao.status_execucao,unidade_faturamento.status_faturamento,os_tipo.nome_tipo,status_os.nomeStatusOs,emitente.nome FROM (`os`) JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN orcamento ON orcamento.idOrcamentos = os.idOrcamentos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos join status_os on status_os.idStatusOs = os.idStatusOs join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento left join os_tipo on os_tipo.id_tipo = os.id_tipo where 1=1 $idOs1 $cod_orc1 $clientes_id1 $idProdutos1 $numpedido_os1 $tag1 $numero_nf1 $query_status_producao1 $query_unid_execucao1 $query_unid_faturamento1 $querydataentrega1 $querydatacadastro1 $querydatareagendada1 $query_clientes1 $queryentrega_reagendada1 $descricao_item1 $query_tipoos1 $unidade_execucao1 ORDER BY `os`.`idOs` $order 
        ";
       
       
        
        return $this->db->count_all();
       
    }
	
	
	 function edit_concatena($table,$data2,$fieldID,$ID,$data3){
		//$data['histo_alteracao'] = "CONCAT(histo_alteracao, $data2)";

		
		$this->db->where($fieldID,$ID);
$this->db->set("histo_alteracao", "CONCAT('$data3', '$data2')", false);
$this->db->update($table, $data);



		
		if ($this->db->affected_rows() >= 0)
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
	
	function edit2($table,$data,$fieldID,$ID){
        $this->db->where('idOs in ('.$ID.')');
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
			WHERE os.idOs = '.$id.' and distribuir_os.idStatuscompras = 5 group by pedido_compras.idPedidoCompra';
		return $this->db->query($query)->result();
	}
	public function getPedidosCompraIcms($id){
		$query = 'SELECT pedido_comprasitens.idPedidoCompra, pedido_comprasitens.icms 
		from os 
		join distribuir_os on distribuir_os.idOs = os.idOs 
		join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
		join pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens 
		where os.idOs = '.$id.' and distribuir_os.idStatuscompras = 5';
		return $this->db->query($query)->result();
	}
	public function insertOSHis($os){
		$os2 = (array) $os;
		$os2['data_alteracaoHis '] = date('Y-m-d H:i:s');
		$os2['idUserHis '] = $this->session->userdata('idUsuarios');
		$os2['url'] = $this->uri->uri_string();
		$this->db->insert('os_history',$os2);
		if ($this->db->affected_rows() == '1')
		{			
			return true;			
		}		
		return FALSE;
	}
	public function getHisStatusOs($idOs){
		$query = "SELECT usuarios.nome,status_os.nomeStatusOs,verificacao_controle.descricaoControle,os_history.data_alteracaoHis,os_history.statusDesenho
		FROM `os_history` 
		join status_os on status_os.idStatusOs = os_history.idStatusOs 
		join usuarios on usuarios.idUsuarios = os_history.idUserHis 
		join verificacao_controle on verificacao_controle.idVerificacaoControle = os_history.idVerificacaoControle
		WHERE os_history.idOs = $idOs order by os_history.data_alteracaoHis desc";
		return $this->db->query($query)->result();
	}

	public function os_vinculada($idOs){
		$query = "SELECT * FROM os JOIN os_vinculada on os_vinculada.idOs_principal = os.idOs or os_vinculada.idOs_gerada = os.idOs where os.idOs = $idOs";
		return $this->db->query($query)->result();
	}

	public function getOsIN($listOs,$one = false){
		$query = "SELECT * FROM os WHERE os.idOs in ($listOs)";
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
			join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao WHERE os.idOs = $idOs";
		return $this->db->query($query)->row();
	}
	
}