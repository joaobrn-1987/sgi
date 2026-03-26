<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orcamentos_model extends CI_Model {

	function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields.', clientes.nomeCliente, clientes.idClientes, clientes.idSimplexCliente,clientes.documento,clientes.cep');
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.idClientes');
        $this->db->order_by('idOrcamentos','desc');
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
	function get2($table,$fields,$where="",$perpage=0,$start=0,$one=false,$array='array'){
        
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
	function get_number_linhas($table,$where,$fields){
         $this->db->select($fields);
         $this->db->from($table);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
		//return $this->db->count_all($query);
		
        $result =  $query->result();
        return $result;
    }

    function getorc($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
       
        //$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = '.$table.'.idOrcamentos');
        //$this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
        $this->db->join('emitente', 'emitente.id = '.$table.'.idEmitente');
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.idClientes');
        $this->db->join('clientes_solicitantes', 'clientes_solicitantes.idSolicitante = '.$table.'.idSolicitante');
        $this->db->join('grupo_servico', 'grupo_servico.idGrupoServico = '.$table.'.idGrupoServico');
        $this->db->join('gerente', 'gerente.idGerente = '.$table.'.idGerente');
        $this->db->join('status_orcamento', 'status_orcamento.idstatusOrcamento = '.$table.'.idstatusOrcamento');
        $this->db->join('vendedores', 'vendedores.idVendedor = '.$table.'.idVendedor');
        $this->db->join('NatOperacao', 'NatOperacao.idNatOperacao = '.$table.'.idNatOperacao');
        


        $this->db->order_by($table.'.idOrcamentos','desc');
        $this->db->limit($perpage,$start);
      
       
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
	 public function getPN($field ='', $search='')
    {
		if($field <> '' && $search <> '')
		{
			 $query = "
            SELECT * FROM produtos
            WHERE $field LIKE '%$search%'
            ORDER BY $field 
        ";
		}
		else
		{
			$query = "
            SELECT * FROM produtos
            
            ORDER BY pn limit 20
        ";
		}

       
        
        return $this->db->query($query)->result();
       
    }
	function getsolicitante($table,$where){
        
		 
		$this->db->where($where);
        $this->db->from($table);
       
           $this->db->join('clientes_solicitantes', 'clientes_solicitantes.idClientes = '.$table.'.idClientes');
        $this->db->order_by('clientes_solicitantes.nome','asc');
        
        $query = $this->db->get();
        
        $result =  $query->result();
        return $result;
    }
	
	
    function getById($table,$id){
		
		 $this->db->from($table);
		//$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = '.$table.'.idOrcamentos');
        //$this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
        $this->db->join('emitente', 'emitente.id = '.$table.'.idEmitente');
        $this->db->join('motivo_orcamento', 'motivo_orcamento.idMotivo = '.$table.'.idMotivo', 'left');
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.idClientes');
        $this->db->join('clientes_solicitantes', 'clientes_solicitantes.idSolicitante = '.$table.'.idSolicitante');
        $this->db->join('grupo_servico', 'grupo_servico.idGrupoServico = '.$table.'.idGrupoServico');
        $this->db->join('gerente', 'gerente.idGerente = '.$table.'.idGerente');
        $this->db->join('status_orcamento', 'status_orcamento.idstatusOrcamento = '.$table.'.idstatusOrcamento');
        $this->db->join('vendedores', 'vendedores.idVendedor = '.$table.'.idVendedor');
        $this->db->join('NatOperacao', 'NatOperacao.idNatOperacao = '.$table.'.idNatOperacao');
        $this->db->where('orcamento.idOrcamentos',$id);
		
     
        return $this->db->get()->row();
    }

	 public function orcCustom($dataInicial = null,$idOrcamentos){
       
      /* $query = "SELECT * FROM (`orcamento`)  JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `NatOperacao` ON `NatOperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` and orcamento.idOrcamentos =  $idOrcamentos";*/
        
       
       $query = "SELECT emitente.url_logo as url_logoemi, emitente.imagem as imagememi,emitente.nome as nomeemi, emitente.cnpj as cnpjemi, emitente.ie as ieemi, emitente.rua as ruaemi, emitente.numero	as numeroemi,emitente.bairro as bairroemi, emitente.cidade   as cidadeemi, emitente.uf as ufemi, emitente.email as emailemi, emitente.telefone as telefoneemi, orcamento.idOrcamentos as idorc, orcamento.data_abertura as data_abert_orc, clientes.idClientes as idcli, clientes.nomeCliente as nomecli ,  clientes.rua as ruacli ,  clientes.numero as numerocli ,  clientes.bairro as bairrocli ,  clientes.cidade as cidadecli,  clientes.estado as estadocli,  clientes.cep as cepcli,  clientes.telefone as telefonecli, clientes.documento as documentocli,  clientes.ie as iecli, produtos.idProdutos , produtos.descricao , produtos.pn ,orcamento_item.descricao_item,  orcamento_item.prazo , orcamento_item.desconto , orcamento_item.qtd , orcamento_item.val_unit , orcamento_item.subtot , orcamento_item.val_ipi , orcamento_item.valor_total,clientes_solicitantes.email_solici as emailsolicitante,clientes_solicitantes.nome as nomesolici, orcamento_item.detalhe,orcamento.obs , orcamento.cond_pgto ,orcamento.garantia_servico, orcamento.status_orc, orcamento.idstatusOrcamento,orcamento.validade ,orcamento.referencia, orcamento.entregaoutros , orcamento.entrega , NatOperacao.nome as nomenat, vendedores.nomeVendedor as nomevendedo ,vendedores.assinatura,gerente.caminho_assinatura, gerente.nome as nomegerente  FROM (`orcamento`) JOIN orcamento_item ON orcamento_item.idOrcamentos = orcamento.idOrcamentos JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `NatOperacao` ON `NatOperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` and orcamento_item.idOrcamentos =  $idOrcamentos";
		
        //return $this->db->query($query)->row();
        return $this->db->query($query)->result();
    }
	

   /* public function getProdutos($id = null){
        $this->db->select('itens_de_orcamentos.*, produtos.*');
        $this->db->from('itens_de_orcamentos');
        $this->db->join('produtos','produtos.idProdutos = itens_de_orcamentos.produtos_id');
        $this->db->where('orcamentos_id',$id);
        return $this->db->get()->result();
    }*/

    
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
                $row_set[] = array('label'=>$row['descricao'].' | Preço: R$ '.$row['precoOrcamento'].' | Estoque: '.$row['estoque'],'estoque'=>$row['estoque'],'id'=>$row['idProdutos'],'preco'=>$row['precoOrcamento']);
            }
            echo json_encode($row_set);
        }
    }
	public function getorc_os($orcamento){
		 $query = "SELECT * FROM `orcamento`, orcamento_item, os WHERE orcamento.`idOrcamentos` = orcamento_item.`idOrcamentos` and orcamento_item.idOrcamento_item = os.idOrcamento_item and orcamento.idOrcamentos = $orcamento";
        
        return $this->db->query($query)->row();
	  
          
    }

	
    public function autoCompleteCliente($q){

        $this->db->select('*');
        $this->db->limit(10);
        $this->db->like('nomeCliente', $q);
        $query = $this->db->get('clientes');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nomeCliente'].' | CNPJ: '.$row['documento'],'id'=>$row['idClientes'] );
            }
			
            echo json_encode($row_set);
        }
    }
	public function autoCompletePN($q){

        $this->db->select('*');
        $this->db->limit(10);
        $this->db->like('pn', $q);
        $query = $this->db->get('produtos');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['pn'].' | Descrição: '.$row['descricao'],'id'=>$row['idProdutos'],'descricao'=>$row['descricao'],'pn'=>$row['pn']);
            }
			
            echo json_encode($row_set);
        }
    }
	public function autoCompletePN2($q){
		$query2 = 'SELECT produtos.*,(select SUM(quantidade) from almo_estoque_produtos where almo_estoque_produtos.idProduto = produtos.idProdutos and almo_estoque_produtos.idEmitente = 1) as qtdEstt FROM produtos where produtos.pn like "%'.$q.'%" limit 20';

        $query = $this->db->query($query2)->result();

        
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>'Pn:'.$row->pn.' - '.$row->descricao.' - Ref.: '.$row->referencia,'id'=>$row->idProdutos,'qtdEst'=>$row->qtdEstt,'no'=>$row->descricao.' PN: '.$row->pn.' Ref.: '.$row->referencia);
            }
			
            echo json_encode($row_set);
        }
    }
	public function getWhereLikeorc($cod_orc, $clientes_id, $idstatusOrcamento,$idGrupoServico, $idNatOperacao,$referencia, $num_pedido,$num_nf,$status,$idProdutos,$descricao_item)
    {
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$descricao_item."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
		if($idProdutos <> '')
		{
			
			$idProdutos1 = " and produtos.idProdutos = ".$idProdutos;
		}
		else
		{
			
			$idProdutos1 = '';
		}
		if($cod_orc <> '')
		{
			$cod_orc1 = " and orcamento.idOrcamentos = ".$cod_orc;
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
		if($idstatusOrcamento <> '')
		{
			
         $idstatusOrcamento1 = " and orcamento.idstatusOrcamento = ".$idstatusOrcamento;
		}
		else
		{
			$idstatusOrcamento1 = '';
		}
		if($idGrupoServico <> '')
		{
			$idGrupoServico1 = " and orcamento.idGrupoServico = ".$idGrupoServico;
		}
		else
		{
			$idGrupoServico1 = '';
		}
		if($idNatOperacao <> '')
		{
			 $idNatOperacao1 = " and orcamento.idNatOperacao = ".$idNatOperacao;
		}
		else
		{
			$idNatOperacao1 = '';
		}
		if($referencia <> '')
		{
			 $referencia1 = " and orcamento.referencia = '".$referencia."'";
		}
		else
		{
			$referencia1 = '';
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
		
		if($status <> '')
		{
			$status1 = " and orcamento.status_orc = ".$status;
		}
		else
		{
			$status1 = '';
		}
		
		 $query = "
           SELECT * FROM (`orcamento`) join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos  JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `NatOperacao` ON `NatOperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos  where 1=1 $cod_orc1 $clientes_id1 $idstatusOrcamento1 $idGrupoServico1 $idNatOperacao1 $referencia1 $num_pedido1 $num_nf1 $status1 $idProdutos1 $descricao_item1 ORDER BY `orcamento`.`idOrcamentos` desc
        ";
		
        return $this->db->query($query)->result();
       
    }
    public function numrowsWhereLikeorc($cod_orc, $clientes_id, $idstatusOrcamento,$idGrupoServico, $idNatOperacao,$referencia, $num_pedido,$num_nf,$status,$idProdutos,$descricao_item)
    {
if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$descricao_item."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
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
		if($cod_orc <> '')
		{
			$cod_orc1 = " and orcamento.idOrcamentos = ".$cod_orc;
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
		if($idstatusOrcamento <> '')
		{
			
         $idstatusOrcamento1 = " and orcamento.idstatusOrcamento = ".$idstatusOrcamento;
		}
		else
		{
			$idstatusOrcamento1 = '';
		}
		if($idGrupoServico <> '')
		{
			$idGrupoServico1 = " and orcamento.idGrupoServico = ".$idGrupoServico;
		}
		else
		{
			$idGrupoServico1 = '';
		}
		if($idNatOperacao <> '')
		{
			 $idNatOperacao1 = " and orcamento.idNatOperacao = ".$idNatOperacao;
		}
		else
		{
			$idNatOperacao1 = '';
		}
		if($referencia <> '')
		{
			 $referencia1 = " and orcamento.referencia = ".$referencia;
		}
		else
		{
			$referencia1 = '';
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
		 if($status <> '')
		{
			$status1 = " and orcamento.status_orc = ".$status;
		}
		else
		{
			$status1 = '';
		}
		
		$query = "
           SELECT * FROM (`orcamento`) join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `NatOperacao` ON `NatOperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos where 1=1 $cod_orc1 $clientes_id1 $idstatusOrcamento1 $idGrupoServico1 $idNatOperacao1 $referencia1 $num_pedido1 $num_nf1 $status1 $idProdutos1 $descricao_item1 ORDER BY `orcamento`.`idOrcamentos` desc
        ";
        
        return $this->db->count_all();
       
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


	 public function getorc_item($orc)
    {
		 
		$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = orcamento.idOrcamentos');
		$this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
		$this->db->where('orcamento.idOrcamentos',$orc);
        $this->db->order_by('orcamento_item.idOrcamento_item','asc');
        return $this->db->get('orcamento')->result();
       
    }
	 public function get_item_orc($item)
    {
		 
		$this->db->join('orcamento_item', 'orcamento_item.idOrcamento_item = os.idOrcamento_item');
		$this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
		$this->db->where('orcamento_item.idOrcamento_item',$item);
        
        return $this->db->get('os')->row();
       
    }
	public function get_pn_orcamento($pn)
    {
		 
		$this->db->join('orcamento_item', 'orcamento_item.idOrcamento_item = os.idOrcamento_item');
		$this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
		$this->db->where('orcamento_item.idProdutos',$pn);
        
        return $this->db->get('os')->row();
       
    }
	 public function getos_item($orc)
    {
		 
		$this->db->where('os.idOrcamento_item',$orc);
        return $this->db->get('os')->row();
       
    }
    public function getEmitente($id = '')
    {
		$this->db->order_by('nome','asc');
		if($id <> '')
		{
			$this->db->where('id',$id);
			return $this->db->get('emitente')->row();
		}
		else{
        
		
        return $this->db->get('emitente')->result();
		}
    }
	public function getEmitente2($id = '')
    {
		$this->db->order_by('id','asc');
		if($id <> '')
		{
			$this->db->where('id',$id);
			return $this->db->get('emitente')->row();
		}
		else{
        
		
        return $this->db->get('emitente')->result();
		}
    }
	 public function getmotivo()
    {
        $this->db->order_by('motivo','asc');
        return $this->db->get('motivo_orcamento')->result();
       
    }
    public function getCliente($id = '')
    {
		$this->db->order_by('nomeCliente','asc');
		if($id <> '')
		{
			$this->db->where('idClientes',$id);
			return $this->db->get('clientes')->row();
		}
		else{
        
		
         return $this->db->get('clientes')->result();
		}
		
		
        
       
       
    }
	public function getCliente2()
    {
		$query = "SELECT * from clientes where idClientes in(706,702,711,528,540,519,543,581,684,635,517,580,575,532,516,10,551) order by nomeCliente asc";
		
        
		return $this->db->query($query)->result();
       
    }
	public function getCliente3()
    {
		$query = "SELECT * from clientes where idClientes not in(706,702,711,528,540,519,543,581,684,635,517,580,575,532,516,10,551) order by nomeCliente asc";
		
        
		return $this->db->query($query)->result();
       
    }
	public function getSolici($id = '')
    {
		$this->db->order_by('nome','asc');
		if($id <> '')
		{
			$this->db->where('idSolicitante',$id);
			return $this->db->get('clientes_solicitantes')->row();
		}
		else{
        
		
         return $this->db->get('clientes_solicitantes')->result();
		}
		
		
        
       
       
    }
	 public function getitemorc($orc)
    {
		 
		
		$this->db->where('orcamento_item.idOrcamentos',$orc);
        $this->db->order_by('orcamento_item.idOrcamento_item','asc');
        return $this->db->get('orcamento_item')->result();
       
    }
	
	 public function getitem($item)
    {
		 
		
		$this->db->where('idOrcamento_item',$item);
        
        return $this->db->get('orcamento_item')->row();
       
    }
	
	
	
	 public function getitemos($id)
    {
		$this->db->where('idOrcamento_item',$id);
        
        return $this->db->get('os')->result();
       
    }
	
	
	
	
    public function getVendedor($id = '')
    {
		$this->db->order_by('nomeVendedor','asc');
		if($id <> '')
		{
			$this->db->where('idVendedor',$id);
			return $this->db->get('vendedores')->row();
		}
		else{
        
		
         return $this->db->get('vendedores')->result();
		}
		
		
		
        
        
       
    }
    public function getGerente($id = '')
    {
        $this->db->order_by('nome','asc');
		if($id <> '')
		{
			$this->db->where('idGerente',$id);
			return $this->db->get('gerente')->row();
		}
		else{
        
		
          return $this->db->get('gerente')->result();
		}
		
       
       
    }
    public function getStatusOrcamento()
    {
        $this->db->order_by('nome_status_orc','asc');
        return $this->db->get('status_orcamento')->result();
       
    }
	public function getStatusOs()
    {
        $this->db->order_by('ordem','asc');
        return $this->db->get('status_os')->result();
       
    }
	
    public function getGrupoServico($id = '')
    {
		
        $this->db->order_by('nome','asc');
		if($id <> '')
		{
			$this->db->where('idGrupoServico',$id);
			return $this->db->get('grupo_servico')->row();
		}
		else{
        
		
           return $this->db->get('grupo_servico')->result();
		}
		
       
       
    }
    public function getNatOperacao($id = '')
    {
        $this->db->order_by('nome','asc');
		if($id <> '')
		{
			$this->db->where('idNatOperacao',$id);
			return $this->db->get('NatOperacao')->row();
		}
		else{
        
		
           return $this->db->get('NatOperacao')->result();
		}
		
       
       
    }
   
	

}

/* End of file vendas_model.php */
/* Location: ./application/models/vendas_model.php */