<?php
class Estoque_model extends CI_Model {

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
	public function get_table($table,$order)
    {
		 
		$this->db->order_by($order);
		//$this->db->where('orcamento_item.idOrcamento_item',$item);
        return $this->db->get($table)->result();
       
    }
	public function gettable($table,$where,$campo)
    {
		 
		
		$this->db->where($where,$campo);
        return $this->db->get($table)->result();
       
    }
	public function OSCustom($idOs){
       
     
        
       
       $query = "SELECT emitente.url_logo as url_logoemi, emitente.imagem as imagememi,emitente.nome as nomeemi, clientes.idClientes as idcli, clientes.nomeCliente as nomecli , produtos.idProdutos , produtos.descricao , produtos.pn , orcamento_item.detalhe,grupo_servico.nome as grupo,status_os.nomeStatusOs,os.obs_os,os.obs_controle,unidade_execucao.status_execucao, unidade_faturamento.status_faturamento, os.`idOs`,os.`data_abertura`,os.`data_entrega`,os.`idStatusOs`,os.`data_reagendada`,os.`tiposervico`,os.`idOrcamentos`, os.qtd_os,orcamento_item.descricao_item FROM (`os`) join orcamento on orcamento.idOrcamentos = os.idOrcamentos JOIN orcamento_item ON orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `status_os` ON `status_os`.`idStatusOs` = `os`.`idStatusOs` join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao join unidade_faturamento on unidade_faturamento.id_unid_fat = os.unid_faturamento and os.idOs = $idOs";
		
        
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
	
	public function getpedido_os($id)
    {
	
		
			$this->db->where('idOs',$id);
	        return $this->db->get('anexo_pedido')->result();
		
    }
	
	public function getuser($id)
    {
	
		
			$this->db->where('idUsuarios',$id);
	        return $this->db->get('usuarios')->result();
		
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
	public function getmaterial_dist($id){
        
        $this->db->from('distribuir_os');
        $this->db->join('insumos','insumos.idInsumos = distribuir_os.idInsumos');
        $this->db->join('statuscompras','statuscompras.idStatuscompras = distribuir_os.idStatuscompras');
        $this->db->where('idOs',$id);
        return $this->db->get()->result();
    }
	public function calculadif($hora_inicial, $hora_final) {
$i = 1;
$tempo_total;

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
     function getos($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array')
	 {
		  
        $this->db->select($fields);
        $this->db->from($table);

    $this->db->join('subcategoriaInsumo', $table.'.idSubcategoria = subcategoriaInsumo.idSubcategoria');
 $this->db->join('categoriaInsumos', 'subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria');
 $this->db->join('estoque_entrada', $table.'.idInsumos = estoque_entrada.id_produto');

   $this->db->join('estoque_saida', 'estoque_entrada.id_estoque_saida = estoque_saida.idestoque_saida', 'left');  

 
 
 
   
        $this->db->order_by($table.'.descricaoInsumo','desc');
        $this->db->group_by('insumos.idInsumos');
        $this->db->group_by('estoque_entrada.dimensao');
		

       
             
       
		
        $this->db->limit($perpage,$start);
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
		
		
		
		
    }
	
	public function getWhereLikeos($idInsumos = '',$cat = '', $querydatacadastro = '', $codigo='')
    {
		if($codigo <> '')
		{
			$query_codigo = " and insumos.pn_insumo like '%".$codigo."%'";
		}
		else
		{
			$query_codigo = '';
		}
		if($querydatacadastro <> '')
		{
			$querydatacadastro1 = $querydatacadastro;
		}
		else
		{
			$querydatacadastro1 = '';
		}
		
		if($idInsumos <> '')
		{
			$query_insumo = " and estoque_entrada.id_produto = ".$idInsumos;
		}
		else
		{
			$query_insumo = '';
		}
		
		if($cat <> '')
		{
			$query_cat = " and categoriaInsumos.idCategoria in ".$cat;
		}
		else
		{
			$query_cat = '';
		}
		
         
        $query = "
		SELECT estoque_entrada.dimensao, insumos.pn_insumo, insumos.localizacao, categoriaInsumos.descricaoCategoria,subcategoriaInsumo.descricaoSubcategoria, insumos.idInsumos, insumos.descricaoInsumo, insumos.estoqueminimo, sum(estoque_entrada.quantidade) as qtd, sum(case when estoque_saida.qtd_saida = null then 0 else estoque_saida.qtd_saida end ) as qtd_saida, (sum(estoque_entrada.quantidade) - sum(estoque_saida.qtd_saida)) as atual , sum(CASE WHEN estoque_entrada.id_estoque_saida = 0 THEN estoque_entrada.vlr_unit ELSE 0 END) as media_unit, sum(CASE WHEN estoque_entrada.id_estoque_saida = 0 THEN estoque_entrada.vlr_unit ELSE 0 END) as valortotal  FROM `insumos` inner join subcategoriaInsumo on insumos.`idSubcategoria` = subcategoriaInsumo.idSubcategoria inner join categoriaInsumos on subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria inner join estoque_entrada on estoque_entrada.id_produto = insumos.idInsumos left join estoque_saida on estoque_entrada.id_estoque_saida = estoque_saida.idestoque_saida where 1 = 1 $query_insumo $query_cat $querydatacadastro1 $query_codigo group by insumos.idInsumos, estoque_entrada.dimensao ORDER BY `insumos`.`descricaoInsumo` desc    
		
		
          
        ";
        
        return $this->db->query($query)->result();
       
    }
	
	
	
	
    public function numrowsWhereLikeos($idInsumos = '',$cat = '', $querydatacadastro = '',$codigo = '')
    {
		if($codigo <> '')
		{
			$query_codigo = " and insumos.pn_insumo like '%".$codigo."%'";
		}
		else
		{
			$query_codigo = '';
		}
		if($querydatacadastro <> '')
		{
			$querydatacadastro1 = $querydatacadastro;
		}
		else
		{
			$querydatacadastro1 = '';
		}
		
		if($idInsumos <> '')
		{
			$query_insumo = " and estoque_entrada.id_produto = ".$idInsumos;
		}
		else
		{
			$query_insumo = '';
		}
		
		if($cat <> '')
		{
			$query_cat = " and categoriaInsumos.idCategoria in ".$cat;
		}
		else
		{
			$query_cat = '';
		}
			
        $query = "
           SELECT estoque_entrada.dimensao, insumos.pn_insumo, insumos.localizacao, categoriaInsumos.descricaoCategoria,subcategoriaInsumo.descricaoSubcategoria, insumos.idInsumos, insumos.descricaoInsumo, insumos.estoqueminimo, sum(estoque_entrada.quantidade) as qtd, sum(case when estoque_saida.qtd_saida = null then 0 else estoque_saida.qtd_saida end ) as qtd_saida, (sum(estoque_entrada.quantidade) - sum(estoque_saida.qtd_saida)) as atual , sum(CASE WHEN estoque_entrada.id_estoque_saida = 0 THEN estoque_entrada.vlr_unit ELSE 0 END) as media_unit, sum(CASE WHEN estoque_entrada.id_estoque_saida = 0 THEN estoque_entrada.vlr_unit ELSE 0 END) as valortotal  FROM `insumos` inner join subcategoriaInsumo on insumos.`idSubcategoria` = subcategoriaInsumo.idSubcategoria inner join categoriaInsumos on subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria inner join estoque_entrada on estoque_entrada.id_produto = insumos.idInsumos left join estoque_saida on estoque_entrada.id_estoque_saida = estoque_saida.idestoque_saida where 1 = 1 $query_insumo $query_cat $querydatacadastro1 $query_codigo group by insumos.idInsumos, estoque_entrada.dimensao ORDER BY `insumos`.`descricaoInsumo` desc 
		
        ";
       
       
        
        return $this->db->count_all();
       
    }
	function getestoqueentrada2($table,$fields,$where='')
	 {
          
        
        $this->db->from($table);
 
 $this->db->join('subcategoriaInsumo', $table.'.idSubcategoria = subcategoriaInsumo.idSubcategoria');
 $this->db->join('categoriaInsumos', 'subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria');
 $this->db->join('estoque_entrada', $table.'.idInsumos = estoque_entrada.id_produto');

   $this->db->join('estoque_saida', 'estoque_entrada.id_estoque_saida = estoque_saida.idestoque_saida', 'left');  

 
  
        $this->db->order_by($table.'.descricaoInsumo','desc');
        $this->db->group_by('insumos.idInsumos');
        $this->db->group_by('estoque_entrada.dimensao');
       
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
       
		
		
      
        return $query->result();
    }
	//estoque entrada
	function getosentrada($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array')
	 {
		  
        $this->db->select($fields);
        $this->db->from($table);

    $this->db->join('subcategoriaInsumo', $table.'.idSubcategoria = subcategoriaInsumo.idSubcategoria');
 $this->db->join('categoriaInsumos', 'subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria');
 $this->db->join('estoque_entrada', $table.'.idInsumos = estoque_entrada.id_produto');
$this->db->join('estoque_saida','estoque_saida.idestoque_saida = estoque_entrada.id_estoque_saida','left');


  
   
        $this->db->order_by($table.'.descricaoInsumo','desc');
             
       $this->db->order_by('estoque_entrada.dimensao','desc');
       $this->db->order_by('estoque_saida.idestoque_saida','asc');
		
        $this->db->limit($perpage,$start);
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
		
		
		
		
    }
	
	public function getWhereLikeosentrada($idInsumos = '',$cat = '', $querydatacadastro = '',$codigo = '')
    {
		if($codigo <> '')
		{
			$query_codigo = " and insumos.pn_insumo like '%".$codigo."%'";
		}
		else
		{
			$query_codigo = '';
		}
		if($querydatacadastro <> '')
		{
			$querydatacadastro1 = $querydatacadastro;
		}
		else
		{
			$querydatacadastro1 = '';
		}
		
		if($idInsumos <> '')
		{
			$query_insumo = " and estoque_entrada.id_produto = ".$idInsumos;
		}
		else
		{
			$query_insumo = '';
		}
		
		if($cat <> '')
		{
			$query_cat = " and categoriaInsumos.idCategoria in ".$cat;
		}
		else
		{
			$query_cat = '';
		}
		
         
        $query = "
		SELECT estoque_entrada.idestoque_entrada, estoque_entrada.data_entrada, estoque_saida.data_saida,estoque_entrada.usuario_cad as usercad, estoque_saida.user_cad as usersaida ,estoque_entrada.dimensao, estoque_entrada.id_compra, estoque_entrada.id_estoque_saida, insumos.pn_insumo, insumos.localizacao, categoriaInsumos.descricaoCategoria,subcategoriaInsumo.descricaoSubcategoria, insumos.idInsumos, insumos.descricaoInsumo, insumos.estoqueminimo, estoque_entrada.quantidade as qtd, estoque_entrada.vlr_unit FROM `insumos` inner join subcategoriaInsumo on insumos.`idSubcategoria` = subcategoriaInsumo.idSubcategoria inner join categoriaInsumos on subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria inner join estoque_entrada on estoque_entrada.id_produto = insumos.idInsumos left join estoque_saida on estoque_saida.idestoque_saida = estoque_entrada.id_estoque_saida where 1 = 1 $query_insumo $query_cat $querydatacadastro1 $query_codigo ORDER BY `insumos`.`descricaoInsumo`,estoque_entrada.dimensao,estoque_saida.idestoque_saida desc     
          
        ";
        
        return $this->db->query($query)->result();
       
    }
	
	
	
	
    public function numrowsWhereLikeosentrada($idInsumos = '',$cat = '', $querydatacadastro = '',$codigo = '')
    {
		if($codigo <> '')
		{
			$query_codigo = " and insumos.pn_insumo like '%".$codigo."%'";
		}
		else
		{
			$query_codigo = '';
		}
		
		if($querydatacadastro <> '')
		{
			$querydatacadastro1 = $querydatacadastro;
		}
		else
		{
			$querydatacadastro1 = '';
		}
		
		if($idInsumos <> '')
		{
			$query_insumo = " and estoque_entrada.id_produto = ".$idInsumos;
		}
		else
		{
			$query_insumo = '';
		}
		
		if($cat <> '')
		{
			$query_cat = " and categoriaInsumos.idCategoria in ".$cat;
		}
		else
		{
			$query_cat = '';
		}
			
        $query = "
          SELECT estoque_entrada.idestoque_entrada, estoque_entrada.data_entrada, estoque_saida.data_saida,estoque_entrada.usuario_cad as usercad, estoque_saida.user_cad as usersaida ,estoque_entrada.dimensao, estoque_entrada.id_compra, estoque_entrada.id_estoque_saida, insumos.pn_insumo, insumos.localizacao, categoriaInsumos.descricaoCategoria,subcategoriaInsumo.descricaoSubcategoria, insumos.idInsumos, insumos.descricaoInsumo, insumos.estoqueminimo, estoque_entrada.quantidade as qtd, estoque_entrada.vlr_unit FROM `insumos` inner join subcategoriaInsumo on insumos.`idSubcategoria` = subcategoriaInsumo.idSubcategoria inner join categoriaInsumos on subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria inner join estoque_entrada on estoque_entrada.id_produto = insumos.idInsumos left join estoque_saida on estoque_saida.idestoque_saida = estoque_entrada.id_estoque_saida where 1 = 1 $query_insumo $query_cat $querydatacadastro1 $query_codigo ORDER BY `insumos`.`descricaoInsumo`,estoque_entrada.dimensao, estoque_saida.idestoque_saida desc  
		
        ";
       
       
        
        return $this->db->count_all();
       
    }
	function getestoqueentrada2entrada($table,$fields,$where='')
	 {
          
        
        $this->db->from($table);
 
 $this->db->join('subcategoriaInsumo', $table.'.idSubcategoria = subcategoriaInsumo.idSubcategoria');
 $this->db->join('categoriaInsumos', 'subcategoriaInsumo.idCategoria = categoriaInsumos.idCategoria');
 $this->db->join('estoque_entrada', $table.'.idInsumos = estoque_entrada.id_produto');

  $this->db->join('estoque_saida','estoque_saida.idestoque_saida = estoque_entrada.id_estoque_saida','left');

 
  
        $this->db->order_by($table.'.descricaoInsumo','desc');
        $this->db->order_by('estoque_entrada.dimensao','desc');
        $this->db->order_by('estoque_saida.idestoque_saida','asc');
        
             
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
       
		
		
      
        return $query->result();
    }
	
	public function getestoquesaida($idInsumos)
    {
		if($idInsumos <> '')
		{
			$query_insumo = " and estoque_saida.id_produto = ".$idInsumos;
		}
		else
		{
			$query_insumo = '';
		}
		
		
         
        $query = "
          SELECT  sum(estoque_saida.qtd_saida) as qtdsaida FROM `estoque_saida` inner join insumos on estoque_saida.`id_produto` = insumos.idInsumos  WHERE 1 = 1 $query_insumo group by estoque_saida.`id_produto`  
        ";
        
        return $this->db->query($query)->result();
       
    }
	public function getestoqueentrada($idInsumos)
    {
		if($idInsumos <> '')
		{
			$query_insumo = " and estoque_entrada.id_produto = ".$idInsumos;
		}
		else
		{
			$query_insumo = '';
		}
		
		
         
        $query = "
          SELECT  sum(estoque_entrada.quantidade) as qtd FROM `estoque_entrada` inner join insumos on estoque_entrada.`id_produto` = insumos.idInsumos  WHERE 1 = 1 $query_insumo group by estoque_entrada.`id_produto`  
        ";
        
        return $this->db->query($query)->result();
       
    }
	public function getestoqueentrada_livre($idInsumos)
    {
		if($idInsumos <> '')
		{
			$query_insumo = " and estoque_entrada.id_produto = ".$idInsumos;
		}
		else
		{
			$query_insumo = '';
		}
		
		
         
        $query = "
          SELECT  * FROM `estoque_entrada` inner join insumos on estoque_entrada.`id_produto` = insumos.idInsumos  WHERE id_estoque_saida = 0  $query_insumo  ORDER BY `estoque_entrada`.`idestoque_entrada` ASC limit 1  
        ";
        
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
}