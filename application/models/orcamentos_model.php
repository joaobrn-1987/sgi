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
        $this->db->order_by('orcamento.idOrcamentos','desc');
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
	function getOnlyOrcamento($id){
		$id = (int)$id;
		$query = "SELECT * FROM orcamento WHERE idOrcamentos = ?";
		return $this->db->query($query, array($id))->row();
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
        $this->db->join('natoperacao', 'natoperacao.idNatOperacao = '.$table.'.idNatOperacao');
        


        $this->db->order_by($table.'.idOrcamentos','desc');
        $this->db->limit($perpage,$start);
      
       
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }


	


	
	function getorc2($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
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
        $this->db->join('natoperacao', 'natoperacao.idNatOperacao = '.$table.'.idNatOperacao');
		$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = '.$table.'.idOrcamentos');
		$this->db->join('solicitacao_alterar_pn', 'solicitacao_alterar_pn.idOrcamento_item = orcamento_item.idOrcamento_item');
        


        $this->db->order_by($table.'.idOrcamentos','desc');
        $this->db->limit($perpage,$start);
      
       
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
	function getorc3($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
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
        $this->db->join('natoperacao', 'natoperacao.idNatOperacao = '.$table.'.idNatOperacao');
		$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = '.$table.'.idOrcamentos');
        $this->db->group_by('orcamento_item.idOrcamentos');


        $this->db->order_by($table.'.idOrcamentos','desc');
        $this->db->limit($perpage,$start);
      
       
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
	
	public function getOrcamento($id){
		$query = "SELECT * FROM orcamento 
		join clientes on clientes.idClientes = orcamento.idClientes 
		join clientes_solicitantes on clientes_solicitantes.idClientes = clientes.idClientes 
		join vendedores on vendedores.idVendedor = orcamento.idVendedor where orcamento.idOrcamentos = ?";
		return $this->db->query($query, array((int)$id))->row();
	}
	 public function getPN($field ='', $search='')
    {
		$allowed_fields = array('pn', 'descricao', 'referencia');
		if($field <> '' && $search <> '' && in_array($field, $allowed_fields))
		{
			$search_escaped = '%' . $this->db->escape_like_str($search) . '%';
			 $query = "
            SELECT * FROM produtos
            WHERE $field LIKE ?
            ORDER BY $field
        ";
			return $this->db->query($query, array($search_escaped))->result();
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
		$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = '.$table.'.idOrcamentos');
        $this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
        $this->db->join('emitente', 'emitente.id = '.$table.'.idEmitente');
        $this->db->join('motivo_orcamento', 'motivo_orcamento.idMotivo = '.$table.'.idMotivo', 'left');
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.idClientes');
        $this->db->join('clientes_solicitantes', 'clientes_solicitantes.idSolicitante = '.$table.'.idSolicitante');
        $this->db->join('grupo_servico', 'grupo_servico.idGrupoServico = '.$table.'.idGrupoServico');
        $this->db->join('gerente', 'gerente.idGerente = '.$table.'.idGerente');
        $this->db->join('status_orcamento', 'status_orcamento.idstatusOrcamento = '.$table.'.idstatusOrcamento');
        $this->db->join('vendedores', 'vendedores.idVendedor = '.$table.'.idVendedor');
        $this->db->join('natoperacao', 'natoperacao.idNatOperacao = '.$table.'.idNatOperacao');
        $this->db->where('orcamento.idOrcamentos',$id);
		
     
        return $this->db->get()->row();
    }
	function getById2($table,$id){
		
		 $this->db->from($table);
		$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = '.$table.'.idOrcamentos');
        $this->db->join('emitente', 'emitente.id = '.$table.'.idEmitente');
        $this->db->join('motivo_orcamento', 'motivo_orcamento.idMotivo = '.$table.'.idMotivo', 'left');
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.idClientes');
        $this->db->join('clientes_solicitantes', 'clientes_solicitantes.idSolicitante = '.$table.'.idSolicitante');
        $this->db->join('grupo_servico', 'grupo_servico.idGrupoServico = '.$table.'.idGrupoServico');
        $this->db->join('gerente', 'gerente.idGerente = '.$table.'.idGerente');
        $this->db->join('status_orcamento', 'status_orcamento.idstatusOrcamento = '.$table.'.idstatusOrcamento');
        $this->db->join('vendedores', 'vendedores.idVendedor = '.$table.'.idVendedor');
        $this->db->join('natoperacao', 'natoperacao.idNatOperacao = '.$table.'.idNatOperacao');
        $this->db->where('orcamento.idOrcamentos',$id);
		
     
        return $this->db->get()->row();
    }

	function getById3($table,$id){
		
		$this->db->from($table);
	   $this->db->join('emitente', 'emitente.id = '.$table.'.idEmitente');
	   $this->db->join('motivo_orcamento', 'motivo_orcamento.idMotivo = '.$table.'.idMotivo', 'left');
	   $this->db->join('clientes', 'clientes.idClientes = '.$table.'.idClientes');
	   $this->db->join('clientes_solicitantes', 'clientes_solicitantes.idSolicitante = '.$table.'.idSolicitante');
	   $this->db->join('grupo_servico', 'grupo_servico.idGrupoServico = '.$table.'.idGrupoServico');
	   $this->db->join('gerente', 'gerente.idGerente = '.$table.'.idGerente');
	   $this->db->join('status_orcamento', 'status_orcamento.idstatusOrcamento = '.$table.'.idstatusOrcamento');
	   $this->db->join('vendedores', 'vendedores.idVendedor = '.$table.'.idVendedor');
	   $this->db->join('natoperacao', 'natoperacao.idNatOperacao = '.$table.'.idNatOperacao');
	   $this->db->where('orcamento.idOrcamentos',$id);
	   
	
	   return $this->db->get()->row();
   }

	 public function orcCustom($idOrcamentos, $dataInicial = null){
       
      /* $query = "SELECT * FROM (`orcamento`)  JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` and orcamento.idOrcamentos =  $idOrcamentos";*/
        
       
       $query = "SELECT emitente.url_logo as url_logoemi, emitente.imagem as imagememi,emitente.nome as nomeemi, emitente.cnpj as cnpjemi, emitente.ie as ieemi, emitente.rua as ruaemi, emitente.numero	as numeroemi,emitente.bairro as bairroemi, emitente.cidade   as cidadeemi, emitente.uf as ufemi, emitente.email as emailemi, emitente.telefone as telefoneemi, orcamento.idOrcamentos as idorc, orcamento.data_abertura as data_abert_orc, clientes.idClientes as idcli, clientes.nomeCliente as nomecli ,  clientes.rua as ruacli ,  clientes.numero as numerocli ,  clientes.bairro as bairrocli ,  clientes.cidade as cidadecli,  clientes.estado as estadocli,  clientes.cep as cepcli,  clientes.telefone as telefonecli, clientes.documento as documentocli,  clientes.ie as iecli, produtos.idProdutos , produtos.descricao , produtos.pn ,orcamento_item.descricao_item,  orcamento_item.prazo , orcamento_item.desconto , orcamento_item.qtd , orcamento_item.val_unit , orcamento_item.subtot , orcamento_item.val_ipi , orcamento_item.valor_total,clientes_solicitantes.email_solici as emailsolicitante,clientes_solicitantes.nome as nomesolici, orcamento_item.detalhe,orcamento.obs , orcamento.cond_pgto ,orcamento.garantia_servico, orcamento.status_orc, orcamento.idstatusOrcamento,orcamento.validade ,orcamento.referencia, orcamento.entregaoutros , orcamento.entrega , natoperacao.nome as nomenat, vendedores.nomeVendedor as nomevendedo ,vendedores.assinatura,gerente.caminho_assinatura, gerente.nome as nomegerente  FROM (`orcamento`) JOIN orcamento_item ON orcamento_item.idOrcamentos = orcamento.idOrcamentos JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` and orcamento_item.idOrcamentos =  ?";
		
        //return $this->db->query($query)->row();
        return $this->db->query($query, array((int)$idOrcamentos))->result();
    }
	public function orcCustom2($idOrcamentos, $dataInicial = null){
       
		/* $query = "SELECT * FROM (`orcamento`)  JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` and orcamento.idOrcamentos =  $idOrcamentos";*/
		  
		 
		 $query = "SELECT tipo_entrega.descricaoTipoEntrega,emitente.url_logo as url_logoemi, emitente.imagem as imagememi,emitente.nome as nomeemi, emitente.cnpj as cnpjemi, emitente.ie as ieemi, emitente.rua as ruaemi, emitente.numero	as numeroemi,emitente.bairro as bairroemi, emitente.cidade   as cidadeemi, emitente.uf as ufemi, emitente.email as emailemi, emitente.telefone as telefoneemi, orcamento.idOrcamentos as idorc, orcamento.data_abertura as data_abert_orc, clientes.idClientes as idcli, clientes.nomeCliente as nomecli ,  clientes.rua as ruacli ,  clientes.numero as numerocli ,  clientes.bairro as bairrocli ,  clientes.cidade as cidadecli,  clientes.estado as estadocli,  clientes.cep as cepcli,  clientes.telefone as telefonecli, clientes.documento as documentocli,  clientes.ie as iecli, produtos.idProdutos , produtos.descricao , produtos.pn ,orcamento_item.descricao_item,  orcamento_item.prazo , orcamento_item.desconto , orcamento_item.frete, orcamento_item.qtd , orcamento_item.val_unit , orcamento_item.subtot , orcamento_item.val_ipi , orcamento_item.valor_total,clientes_solicitantes.email_solici as emailsolicitante,clientes_solicitantes.nome as nomesolici, orcamento_item.detalhe,orcamento.obs , orcamento.cond_pgto ,orcamento.garantia_servico, orcamento.status_orc, orcamento.idstatusOrcamento,orcamento.validade ,orcamento.referencia, orcamento.entregaoutros , orcamento.entrega , natoperacao.nome as nomenat, vendedores.nomeVendedor as nomevendedo ,vendedores.assinatura,gerente.caminho_assinatura, gerente.nome as nomegerente, orcamento_item.idOrcamento_item, orcamento.valorCotacao, orcamento.moedaCotacao, orcamento_item.descricao_item_imprimir, tipo_qtd.descricaoTipoQtd  FROM (`orcamento`) JOIN orcamento_item ON orcamento_item.idOrcamentos = orcamento.idOrcamentos join tipo_qtd on tipo_qtd.idTipoQtd = orcamento_item.idTipoQtd JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` join os on os.idOrcamento_item = orcamento_item.idOrcamento_item LEFT JOIN tipo_entrega on tipo_entrega.idTipoEntrega = orcamento.entrega JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` and orcamento_item.idOrcamentos =  ?";
		  
		  //return $this->db->query($query)->row();
		  return $this->db->query($query, array((int)$idOrcamentos))->result();
	  }
	public function orcItemCustom($idOrcamentosItem, $dataInicial = null){
       
		/* $query = "SELECT * FROM (`orcamento`)  JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` and orcamento.idOrcamentos =  $idOrcamentos";*/
		  
		 
		 $query = "SELECT emitente.url_logo as url_logoemi, emitente.imagem as imagememi,emitente.nome as nomeemi, emitente.cnpj as cnpjemi, emitente.ie as ieemi, emitente.rua as ruaemi, emitente.numero	as numeroemi,emitente.bairro as bairroemi, emitente.cidade   as cidadeemi, emitente.uf as ufemi, emitente.email as emailemi, emitente.telefone as telefoneemi, orcamento.idOrcamentos as idorc, orcamento.data_abertura as data_abert_orc, clientes.idClientes as idcli, clientes.nomeCliente as nomecli ,  clientes.rua as ruacli ,  clientes.numero as numerocli ,  clientes.bairro as bairrocli ,  clientes.cidade as cidadecli,  clientes.estado as estadocli,  clientes.cep as cepcli,  clientes.telefone as telefonecli, clientes.documento as documentocli,  clientes.ie as iecli, produtos.idProdutos , produtos.descricao , produtos.pn ,orcamento_item.descricao_item,  orcamento_item.prazo , orcamento_item.desconto , orcamento_item.qtd , orcamento_item.val_unit , orcamento_item.subtot , orcamento_item.val_ipi , orcamento_item.valor_total,clientes_solicitantes.email_solici as emailsolicitante,clientes_solicitantes.nome as nomesolici, orcamento_item.detalhe,orcamento.obs , orcamento.cond_pgto ,orcamento.garantia_servico, orcamento.status_orc, orcamento.idstatusOrcamento,orcamento.validade ,orcamento.referencia, orcamento.entregaoutros , orcamento.entrega , natoperacao.nome as nomenat, vendedores.nomeVendedor as nomevendedo ,vendedores.assinatura,gerente.caminho_assinatura, gerente.nome as nomegerente  FROM (`orcamento`) JOIN orcamento_item ON orcamento_item.idOrcamentos = orcamento.idOrcamentos JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` and orcamento_item.idOrcamento_item =  ?";
		  
		  //return $this->db->query($query)->row();
		  return $this->db->query($query, array((int)$idOrcamentosItem))->result();
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
    
    function edit($table,$data,$fieldID,$ID,$retorno = false){     
		
		return $this->histAlteracao($table,$data,$fieldID,$ID,$retorno);       
    }
	function getObj($table,$fieldID,$ID){
        
        $this->db->select('*');
        $this->db->from($table);
		$this->db->where($fieldID,$ID);
        
        
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
		$this->db->where($fieldID,$ID);
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
                $row_set[] = array('label'=>$row['descricao'].' | Preço: R$ '.$row['precoOrcamento'].' | Estoque: '.$row['estoque'],'estoque'=>$row['estoque'],'id'=>$row['idProdutos'],'preco'=>$row['precoOrcamento']);
            }
            echo json_encode($row_set);
        }
    }
	public function getorc_os($orcamento){
		$query = "SELECT * FROM `orcamento` join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos join os on os.idOrcamento_item = orcamento_item.idOrcamento_item WHERE orcamento_item.status_item = 2 and orcamento.idOrcamentos = ?";

        return $this->db->query($query, array((int)$orcamento))->row();

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


	public function autoCompleteCliente2($q){

        $this->db->select('*');
        $this->db->limit(10);
        $this->db->like('nomeCliente', $q);
        $query = $this->db->get('clientes');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nomeCliente'],'id'=>$row['idClientes'] );
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
		$query2 = 'SELECT produtos.*,(select SUM(quantidade) from almo_estoque_produtos where almo_estoque_produtos.idProduto = produtos.idProdutos and almo_estoque_produtos.idEmitente = 1) as qtdEstt FROM produtos where produtos.pn like ? limit 20';
        $q_escaped = '%' . $this->db->escape_like_str($q) . '%';

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
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$this->db->escape_like_str($descricao_item)."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
		if($idProdutos <> '')
		{
			
			$idProdutos1 = " and produtos.idProdutos = ".(int)$idProdutos;
		}
		else
		{
			
			$idProdutos1 = '';
		}
		if($cod_orc <> '')
		{
			$cod_orc1 = " and orcamento.idOrcamentos = ".(int)$cod_orc;
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
		if($idstatusOrcamento <> '')
		{
			
         $idstatusOrcamento1 = " and orcamento.idstatusOrcamento = ".(int)$idstatusOrcamento;
		}
		else
		{
			$idstatusOrcamento1 = '';
		}
		if($idGrupoServico <> '')
		{
			$idGrupoServico1 = " and orcamento.idGrupoServico = ".(int)$idGrupoServico;
		}
		else
		{
			$idGrupoServico1 = '';
		}
		if($idNatOperacao <> '')
		{
			 $idNatOperacao1 = " and orcamento.idNatOperacao = ".(int)$idNatOperacao;
		}
		else
		{
			$idNatOperacao1 = '';
		}
		if($referencia <> '')
		{
			 $referencia1 = " and orcamento.referencia = '".$this->db->escape_str($referencia)."'";
		}
		else
		{
			$referencia1 = '';
		}
		if($num_pedido <> '')
		{
			 $num_pedido1 = " and orcamento.num_pedido = ".(int)$num_pedido;
		}
		else
		{
			$num_pedido1 = '';
		}
		if($num_nf <> '')
		{
			$num_nf1 = " and orcamento.num_nf = ".(int)$num_nf;
		}
		else
		{
			$num_nf1 = '';
		}
		
		if($status <> '')
		{
			$status1 = " and orcamento.status_orc = ".(int)$status;
		}
		else
		{
			$status1 = '';
		}
		
		 $query = "
           SELECT * FROM (`orcamento`) join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos  JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos  where 1=1 $cod_orc1 $clientes_id1 $idstatusOrcamento1 $idGrupoServico1 $idNatOperacao1 $referencia1 $num_pedido1 $num_nf1 $status1 $idProdutos1 $descricao_item1 ORDER BY `orcamento`.`idOrcamentos` desc
        ";
		
        return $this->db->query($query)->result();
       
    }
	public function getWhereLikeorc2($cod_orc, $clientes_id, $idstatusOrcamento,$idGrupoServico, $idNatOperacao,$referencia, $num_pedido,$num_nf,$status,$idProdutos,$descricao_item,$os,$abertura)
    {	/**/
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$this->db->escape_like_str($descricao_item)."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
		if($idProdutos <> '')
		{
			$idProdutos1 = " and produtos.idProdutos = ".(int)$idProdutos;
		}
		else
		{
			$idProdutos1 = '';
		}
		if($cod_orc <> '')
		{
			$cod_orc1 = " and orcamento.idOrcamentos = ".(int)$cod_orc;
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
		if($idstatusOrcamento <> '')
		{
			
         $idstatusOrcamento1 = " and orcamento.idstatusOrcamento = ".(int)$idstatusOrcamento;
		}
		else
		{
			$idstatusOrcamento1 = '';
		}
		if($idGrupoServico <> '')
		{
			$idGrupoServico1 = " and orcamento.idGrupoServico = ".(int)$idGrupoServico;
		}
		else
		{
			$idGrupoServico1 = '';
		}
		if($idNatOperacao <> '')
		{
			 $idNatOperacao1 = " and orcamento.idNatOperacao = ".(int)$idNatOperacao;
		}
		else
		{
			$idNatOperacao1 = '';
		}
		if($referencia <> '')
		{
			 $referencia1 = " and orcamento.referencia = '".$this->db->escape_str($referencia)."'";
		}
		else
		{
			$referencia1 = '';
		}
		if($num_pedido <> '')
		{
			 $num_pedido1 = " and orcamento.num_pedido = ".(int)$num_pedido;
		}
		else
		{
			$num_pedido1 = '';
		}
		if($num_nf <> '')
		{
			$num_nf1 = " and orcamento.num_nf = ".(int)$num_nf;
		}
		else
		{
			$num_nf1 = '';
		}
		
		if($status <> '')
		{
			$status1 = " and orcamento.status_orc = ".(int)$status;
		}
		else
		{
			$status1 = '';
		}

		if($os <> ''){
			$os1 = " and os.idOs = ".(int)$os;
		}else{
			$os1 = "";
		}
		
		 $query = "SELECT *, orcamento.idOrcamentos as id_Orcam,orcamento.data_abertura, grupo_servico.nome as nomeGrupoServ FROM (`orcamento`) JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item join produtos on produtos.idProdutos = orcamento_item.idProdutos where 1=1  $cod_orc1 $clientes_id1 $idstatusOrcamento1 $idGrupoServico1 $idNatOperacao1 $referencia1 $num_pedido1 $num_nf1 $status1 $idProdutos1 $os1 $descricao_item1 $abertura group by orcamento.idOrcamentos ORDER BY `orcamento`.`idOrcamentos` desc";
		
        return $this->db->query($query)->result();

		//var_dump($this->db->query($query)->result()); exit;
       
    }
	public function getWhereLikeorc3($cod_orc, $clientes_id, $idstatusOrcamento,$idGrupoServico, $idNatOperacao,$referencia, $num_pedido,$num_nf,$status,$idProdutos,$descricao_item,$os)
    {	
		if($idProdutos <> '')
		{
			$idProdutos1 = " and produtos.idProdutos = ".(int)$idProdutos;
		}
		else
		{
			$idProdutos1 = '';
		}
		if($cod_orc <> '')
		{
			$cod_orc1 = " and orcamento.idOrcamentos = ".(int)$cod_orc;
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
		if($idstatusOrcamento <> '')
		{
			
         $idstatusOrcamento1 = " and orcamento.idstatusOrcamento = ".(int)$idstatusOrcamento;
		}
		else
		{
			$idstatusOrcamento1 = '';
		}
		if($idGrupoServico <> '')
		{
			$idGrupoServico1 = " and orcamento.idGrupoServico = ".(int)$idGrupoServico;
		}
		else
		{
			$idGrupoServico1 = '';
		}
		if($idNatOperacao <> '')
		{
			 $idNatOperacao1 = " and orcamento.idNatOperacao = ".(int)$idNatOperacao;
		}
		else
		{
			$idNatOperacao1 = '';
		}
		if($referencia <> '')
		{
			 $referencia1 = " and orcamento.referencia = '".$this->db->escape_str($referencia)."'";
		}
		else
		{
			$referencia1 = '';
		}
		if($num_pedido <> '')
		{
			 $num_pedido1 = " and orcamento.num_pedido = ".(int)$num_pedido;
		}
		else
		{
			$num_pedido1 = '';
		}
		if($num_nf <> '')
		{
			$num_nf1 = " and orcamento.num_nf = ".(int)$num_nf;
		}
		else
		{
			$num_nf1 = '';
		}
		
		if($status <> '')
		{
			$status1 = " and orcamento.status_orc = ".(int)$status;
		}
		else
		{
			$status1 = '';
		}

		if($os <> ''){
			$os1 = " and os.idOs = ".(int)$os;
		}else{
			$os1 = "";
		}
		
		 $query = "SELECT *, orcamento.idOrcamentos as id_Orcam,orcamento.data_abertura, grupo_servico.nome as nomeGrupoServ FROM (`orcamento`) JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item join produtos on produtos.idProdutos = orcamento_item.idProdutos join solicitacao_alterar_pn on solicitacao_alterar_pn.idOrcamento_item = orcamento_item.idOrcamento_item where 1=1 and solicitacao_alterar_pn.idStatusSolicitacao = 1  $cod_orc1 $clientes_id1 $idstatusOrcamento1 $idGrupoServico1 $idNatOperacao1 $referencia1 $num_pedido1 $num_nf1 $status1 $idProdutos1 $os1 group by orcamento.idOrcamentos ORDER BY `orcamento`.`idOrcamentos` desc";
		
        return $this->db->query($query)->result();
       
    }
    public function numrowsWhereLikeorc($cod_orc, $clientes_id, $idstatusOrcamento,$idGrupoServico, $idNatOperacao,$referencia, $num_pedido,$num_nf,$status,$idProdutos,$descricao_item)
    {
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$this->db->escape_like_str($descricao_item)."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
       if($idProdutos <> '')
		{
			$queryitem = 1;
			$idProdutos1 = " and produtos.idProdutos = ".(int)$idProdutos;
		}
		else
		{
			$queryitem = 0;
			$idProdutos1 = '';
		}
		if($cod_orc <> '')
		{
			$cod_orc1 = " and orcamento.idOrcamentos = ".(int)$cod_orc;
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
		if($idstatusOrcamento <> '')
		{
			
         $idstatusOrcamento1 = " and orcamento.idstatusOrcamento = ".(int)$idstatusOrcamento;
		}
		else
		{
			$idstatusOrcamento1 = '';
		}
		if($idGrupoServico <> '')
		{
			$idGrupoServico1 = " and orcamento.idGrupoServico = ".(int)$idGrupoServico;
		}
		else
		{
			$idGrupoServico1 = '';
		}
		if($idNatOperacao <> '')
		{
			 $idNatOperacao1 = " and orcamento.idNatOperacao = ".(int)$idNatOperacao;
		}
		else
		{
			$idNatOperacao1 = '';
		}
		if($referencia <> '')
		{
			 $referencia1 = " and orcamento.referencia = '".$this->db->escape_str($referencia)."'";
		}
		else
		{
			$referencia1 = '';
		}
		if($num_pedido <> '')
		{
			 $num_pedido1 = " and orcamento.num_pedido = ".(int)$num_pedido;
		}
		else
		{
			$num_pedido1 = '';
		}
		if($num_nf <> '')
		{
			$num_nf1 = " and orcamento.num_nf = ".(int)$num_nf;
		}
		else
		{
			$num_nf1 = '';
		}
		 if($status <> '')
		{
			$status1 = " and orcamento.status_orc = ".(int)$status;
		}
		else
		{
			$status1 = '';
		}
		
		$query = "
           SELECT * FROM (`orcamento`) join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos where 1=1 $cod_orc1 $clientes_id1 $idstatusOrcamento1 $idGrupoServico1 $idNatOperacao1 $referencia1 $num_pedido1 $num_nf1 $status1 $idProdutos1 $descricao_item1 ORDER BY `orcamento`.`idOrcamentos` desc
        ";
        
        return $this->db->count_all();
       
    }
	public function numrowsWhereLikeorc2($cod_orc, $clientes_id, $idstatusOrcamento,$idGrupoServico, $idNatOperacao,$referencia, $num_pedido,$num_nf,$status,$idProdutos,$descricao_item,$os, $abertura)
    {
		if($os <> ''){
			$os1 = " and os.idOs = ".(int)$os;
		}else{
			$os1 = "";
		}
		if($descricao_item <> '')
		{
			 $descricao_item1 = " and orcamento_item.descricao_item like '%".$this->db->escape_like_str($descricao_item)."%'";
		}
		else
		{
			$descricao_item1 = '';
		}
       if($idProdutos <> '')
		{
			$queryitem = 1;
			$idProdutos1 = " and produtos.idProdutos = ".(int)$idProdutos;
		}
		else
		{
			$queryitem = 0;
			$idProdutos1 = '';
		}
		if($cod_orc <> '')
		{
			$cod_orc1 = " and orcamento.idOrcamentos = ".(int)$cod_orc;
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
		if($idstatusOrcamento <> '')
		{
			
         $idstatusOrcamento1 = " and orcamento.idstatusOrcamento = ".(int)$idstatusOrcamento;
		}
		else
		{
			$idstatusOrcamento1 = '';
		}
		if($idGrupoServico <> '')
		{
			$idGrupoServico1 = " and orcamento.idGrupoServico = ".(int)$idGrupoServico;
		}
		else
		{
			$idGrupoServico1 = '';
		}
		if($idNatOperacao <> '')
		{
			 $idNatOperacao1 = " and orcamento.idNatOperacao = ".(int)$idNatOperacao;
		}
		else
		{
			$idNatOperacao1 = '';
		}
		if($referencia <> '')
		{
			 $referencia1 = " and orcamento.referencia = '".$this->db->escape_str($referencia)."'";
		}
		else
		{
			$referencia1 = '';
		}
		if($num_pedido <> '')
		{
			 $num_pedido1 = " and orcamento.num_pedido = ".(int)$num_pedido;
		}
		else
		{
			$num_pedido1 = '';
		}
		if($num_nf <> '')
		{
			$num_nf1 = " and orcamento.num_nf = ".(int)$num_nf;
		}
		else
		{
			$num_nf1 = '';
		}
		 if($status <> '')
		{
			$status1 = " and orcamento.status_orc = ".(int)$status;
		}
		else
		{
			$status1 = '';
		}
		
		$query = "
           SELECT * FROM (`orcamento`) JOIN `emitente` ON `emitente`.`id` = `orcamento`.`idEmitente` JOIN `clientes` ON `clientes`.`idClientes` = `orcamento`.`idClientes` JOIN `clientes_solicitantes` ON `clientes_solicitantes`.`idSolicitante` = `orcamento`.`idSolicitante` JOIN `grupo_servico` ON `grupo_servico`.`idGrupoServico` = `orcamento`.`idGrupoServico` JOIN `gerente` ON `gerente`.`idGerente` = `orcamento`.`idGerente` JOIN `status_orcamento` ON `status_orcamento`.`idstatusOrcamento` = `orcamento`.`idstatusOrcamento` JOIN `vendedores` ON `vendedores`.`idVendedor` = `orcamento`.`idVendedor` JOIN `natoperacao` ON `natoperacao`.`idNatOperacao` = `orcamento`.`idNatOperacao` join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item join produtos on produtos.idProdutos = orcamento_item.idProdutos where 1=1  $cod_orc1 $clientes_id1 $idstatusOrcamento1 $idGrupoServico1 $idNatOperacao1 $referencia1 $num_pedido1 $num_nf1 $status1 $idProdutos1 $os1 $descricao_item1 $abertura group by orcamento.idOrcamentos ORDER BY `orcamento`.`idOrcamentos` desc
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
		$this->db->join('os', 'os.idOrcamento_item = orcamento_item.idOrcamento_item');
		$this->db->join('status_os', 'status_os.idStatusOs = os.idStatusOs');

		$this->db->where('orcamento.idOrcamentos',$orc);
        $this->db->order_by('orcamento_item.idOrcamento_item','asc');

		return $this->db->get('orcamento')->result();
       
    }

	public function getorc_item4($orc)
    {
		 
		$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = orcamento.idOrcamentos');
		$this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
		$this->db->join('os', 'os.idOrcamento_item = orcamento_item.idOrcamento_item');
		$this->db->join('status_os', 'status_os.idStatusOs = os.idStatusOs');
		$this->db->join('orc_servico_escopo', 'orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item and orc_servico_escopo.ativo = 1','left');

		$this->db->where('orcamento.idOrcamentos',$orc);
        $this->db->order_by('orcamento_item.idOrcamento_item','asc');

		return $this->db->get('orcamento')->result();
       
    }

	function getorc_itemB($orc){

		$query = "
		
			SELECT orcamento_item.*, orcamento.*, produtos.*, os.idOs, os.unid_execucao,os.id_tipo, os.fechadoPCP, status_os.* FROM orcamento
				LEFT JOIN orcamento_item ON orcamento_item.idOrcamentos = orcamento.idOrcamentos
				LEFT JOIN produtos ON produtos.idProdutos = orcamento_item.idProdutos
				LEFT JOIN os ON os.idOrcamento_item = orcamento_item.idOrcamento_item
				LEFT JOIN status_os ON status_os.idStatusOs = os.idStatusOs
			WHERE orcamento.idOrcamentos = ?
			ORDER BY orcamento_item.idOrcamento_item ASC
	

		";

		return $this->db->query($query, array((int)$orc))->result();

	}

	function getorc_itemBC($orc){

		$query = "
		
			SELECT orcamento_item.*, orcamento.*, produtos.*, os.idOs, os.unid_execucao,os.id_tipo, os.fechadoPCP, status_os.*,status_peritagem.descricaoPeritagem FROM orcamento
				JOIN orcamento_item ON orcamento_item.idOrcamentos = orcamento.idOrcamentos
				LEFT JOIN produtos ON produtos.idProdutos = orcamento_item.idProdutos
				LEFT JOIN os ON os.idOrcamento_item = orcamento_item.idOrcamento_item
				LEFT JOIN status_os ON status_os.idStatusOs = os.idStatusOs
				LEFT JOIN status_peritagem ON status_peritagem.idStatusPeritagem = orcamento_item.idStatusPeritagem
			WHERE orcamento.idOrcamentos = ?
			ORDER BY orcamento_item.idOrcamento_item ASC
	

		";

		return $this->db->query($query, array((int)$orc))->result();

	}

	public function getorc_item2($orc)
    {
		$query = "SELECT orcamento.*, orcamento_item.*, produtos.*, os.idOs FROM orcamento 
		JOIN orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos
		JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos
		LEFT JOIN os on os.idOrcamento_item = orcamento_item.idOrcamento_item 
		WHERE orcamento.idOrcamentos = ?";
        return $this->db->query($query, array((int)$orc))->result();
       
    }
	public function getorc_item5($orc)
    {
		$query = "SELECT orcamento.*, orcamento_item.*, produtos.*, os.idOs, usuarios.*, orc_servico_escopo.idStatusEscopo FROM orcamento 
		JOIN orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos
		JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos
		LEFT JOIN os on os.idOrcamento_item = orcamento_item.idOrcamento_item 
		LEFT JOIN orc_servico_escopo on orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item and orc_servico_escopo.ativo = 1
		LEFT JOIN usuarios on usuarios.idUsuarios = orcamento_item.idUserFinalizarDesenho
		WHERE orcamento.idOrcamentos = ?";
        return $this->db->query($query, array((int)$orc))->result();
       
    }
	public function getorc_item5list($orcItem)
    {
		$query = "SELECT orcamento.*, orcamento_item.*, produtos.*, os.idOs, usuarios.*, orc_servico_escopo.idStatusEscopo FROM orcamento 
		JOIN orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos
		JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos
		LEFT JOIN os on os.idOrcamento_item = orcamento_item.idOrcamento_item 
		LEFT JOIN orc_servico_escopo on orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item and orc_servico_escopo.ativo = 1
		LEFT JOIN usuarios on usuarios.idUsuarios = orcamento_item.idUserFinalizarDesenho
		WHERE orcamento_item.idOrcamento_item in (".implode(',', array_filter(array_map('intval', explode(',', $orcItem)))).")"; 
        return $this->db->query($query)->result();
       
    }
	public function getorc_item3($orc)
    {
		$query = "SELECT orcamento.*, orcamento_item.*, produtos.*, os.idOs, os.nf_cliente FROM orcamento 
		JOIN orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos
		JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos
		left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item
		WHERE orcamento.idOrcamentos = ?";
        return $this->db->query($query, array((int)$orc))->result();
    }
	public function get_item_orc($item)
    {
		 
		$this->db->join('orcamento_item', 'orcamento_item.idOrcamento_item = os.idOrcamento_item');
		$this->db->join('tipo_qtd', 'tipo_qtd.idTipoQtd = orcamento_item.idTipoQtd','left');
		$this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
		$this->db->where('orcamento_item.idOrcamento_item',$item);
        
        return $this->db->get('os')->row();
       
    }
	public function get_item_orc2($item)
    {		 
		$this->db->join('orcamento_item', 'orcamento_item.idOrcamentos = orcamento.idOrcamentos');
		$this->db->join('produtos', 'produtos.idProdutos = orcamento_item.idProdutos');
		$this->db->where('orcamento_item.idOrcamento_item',$item);
        
        return $this->db->get('orcamento')->row();
       
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
	public function getos_item2($orc)
    {
		$this->db->where('os.idOrcamento_item',$orc);
        return $this->db->get('os')->result();
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
		if($id <> ''){
			$this->db->where('idClientes',$id);
			return $this->db->get('clientes')->row();
		}
		else{
         	return $this->db->get('clientes')->result();
		}
		
		
        
       
       
    }
	public function getorc_itemList($orcItem)
    {
		$query = "SELECT orcamento.*, orcamento_item.*, produtos.*, os.idOs, os.nf_cliente FROM orcamento 
		JOIN orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos
		JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos
		left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item
		WHERE orcamento_item.idOrcamento_item in (".implode(',', array_filter(array_map('intval', explode(',', $orcItem)))).")"; 
        return $this->db->query($query)->result();
       
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
	public function getitemos2($id)
    {
		$this->db->where('os.idOrcamento_item = '.(int)$id.' and status_item = 2');
		$this->db->join('orcamento_item',"orcamento_item.idOrcamento_item = os.idOrcamento_item");
        return $this->db->get('os')->result();
    }
	
	
public function getVendedorAuxiliar($id = '') {
    if (empty($id) || !is_numeric($id)) {
        return []; // Retorna um array vazio se $id for inválido
    }

    $sql = "SELECT vendedores_auxiliar.*, usuarios.nome 
            FROM vendedores_auxiliar 
            JOIN vendedores_vend_auxiliar 
            ON vendedores_vend_auxiliar.idVendedoresAuxiliar = vendedores_auxiliar.idVendedorAuxiliar 
            JOIN usuarios 
            ON usuarios.idUsuarios = vendedores_auxiliar.idUsuario 
            WHERE vendedores_vend_auxiliar.idVendedores = ?";

    $query = $this->db->query($sql, array($id)); // 🛠️ Usando $id corretamente aqui

    return $query->result(); // Retorna os resultados
}
	
	/*public function getVendedoresComAuxiliares()
	{
		// Atualizando a consulta SQL conforme sua nova consulta
		$this->db->select('v.idVendedor, v.nomeVendedor, u.nome AS nomeVendedorAuxiliar, va.idVendedorAuxiliar, u.idUsuarios AS idUsuarioAuxiliar');
		$this->db->from('vendedores v');
		$this->db->join('vendedores_vend_auxiliar vva', 'v.idVendedor = vva.idVendedores', 'left');
		$this->db->join('vendedores_auxiliar va', 'vva.idVendedoresAuxiliar = va.idVendedorAuxiliar', 'left');
		$this->db->join('usuarios u', 'va.idUsuario = u.idUsuarios', 'left');
		$this->db->join('vendedores v_aux', 'va.idUsuario = v_aux.idUsuario', 'left'); // Adicionando junção para obter o nome do auxiliar, se necessário
		$this->db->order_by('v.nomeVendedor', 'ASC');

		$query = $this->db->get();
		$result = $query->result();

		// Organizando os dados para retorno
		$vendedores = [];
		foreach ($result as $row) {
			// Adicionando o vendedor principal
			$vendedores[$row->idVendedor]['idVendedor'] = $row->idVendedor;
			$vendedores[$row->idVendedor]['nomeVendedor'] = $row->nomeVendedor;

			// Adicionando os vendedores auxiliares
			if (!empty($row->idVendedorAuxiliar)) {
				$vendedores[$row->idVendedor]['auxiliares'][] = [
					'idVendedorAuxiliar' => $row->idVendedorAuxiliar,
					'nomeVendedorAuxiliar' => $row->nomeVendedorAuxiliar,
					'idUsuarioAuxiliar' => $row->idUsuarioAuxiliar
				];
			} else {
				$vendedores[$row->idVendedor]['auxiliares'] = [];
			}
		}

		return array_values($vendedores);
	}*/
	
// orcamentos_model.php (Model)
/*public function getVendedoresComAuxiliares() {
    $this->db->select('v.idVendedor, v.nomeVendedor, u.nome AS nomeVendedorAuxiliar, va.idVendedorAuxiliar');
    $this->db->from('vendedores v');
    $this->db->join('vendedores_vend_auxiliar vva', 'v.idVendedor = vva.idVendedores', 'left');
    $this->db->join('vendedores_auxiliar va', 'vva.idVendedoresAuxiliar = va.idVendedorAuxiliar', 'left');
    $this->db->join('usuarios u', 'va.idUsuario = u.idUsuarios', 'left');
    $this->db->order_by('v.nomeVendedor', 'ASC');

    $query = $this->db->get();
    $result = $query->result();

    $vendedores = [];
    foreach ($result as $row) {
        $vendedor_id = $row->idVendedor;
        if (!isset($vendedores[$vendedor_id])) {
            $vendedores[$vendedor_id] = [
                'idVendedor' => $row->idVendedor,
                'nomeVendedor' => $row->nomeVendedor,
                'auxiliares' => []
            ];
        }

        if (!empty($row->idVendedorAuxiliar)) {
            $vendedores[$vendedor_id]['auxiliares'][] = [
                'idVendedorAuxiliar' => $row->idVendedorAuxiliar,
                'nomeVendedorAuxiliar' => $row->nomeVendedorAuxiliar
            ];
        }
    }

    return array_values($vendedores);
}

public function getVendedor($id = '') {
    $this->db->order_by('nomeVendedor', 'asc');
    if (!empty($id)) {
        $this->db->where('idVendedor', $id);
        return $this->db->get('vendedores')->row();
    } else {
        return $this->db->get('vendedores')->result();
    }
}

public function getGerente($id = '') {
    $this->db->order_by('nome', 'asc');
    if (!empty($id)) {
        $this->db->where('idGerente', $id);
        return $this->db->get('gerente')->row();
    } else {
        return $this->db->get('gerente')->result();
    }
}*/


public function getVendedoresComAuxiliares() {
    $this->db->select('v.idVendedor, v.nomeVendedor, u.nome AS nomeVendedorAuxiliar, va.idVendedorAuxiliar');
    $this->db->from('vendedores v');
    $this->db->join('vendedores_vend_auxiliar vva', 'v.idVendedor = vva.idVendedores', 'left');
    $this->db->join('vendedores_auxiliar va', 'vva.idVendedoresAuxiliar = va.idVendedorAuxiliar', 'left');
    $this->db->join('usuarios u', 'va.idUsuario = u.idUsuarios', 'left');
    $this->db->order_by('v.nomeVendedor', 'ASC');

    $query = $this->db->get();
    $result = $query->result();

    $vendedores = [];
    foreach ($result as $row) {
        $vendedor_id = $row->idVendedor;
        if (!isset($vendedores[$vendedor_id])) {
            $vendedores[$vendedor_id] = [
                'idVendedor' => $row->idVendedor,
                'nomeVendedor' => $row->nomeVendedor,
                'auxiliares' => []
            ];
        }

        if (!empty($row->idVendedorAuxiliar)) {
            $vendedores[$vendedor_id]['auxiliares'][] = [
                'idVendedorAuxiliar' => $row->idVendedorAuxiliar,
                'nomeVendedorAuxiliar' => $row->nomeVendedorAuxiliar
            ];
        }
    }

    return array_values($vendedores);
}

public function getVendedor($id = '') {
    $this->db->order_by('nomeVendedor', 'asc');
    if (!empty($id)) {
        $this->db->where('idVendedor', $id);
        return $this->db->get('vendedores')->row();
    } else {
        return $this->db->get('vendedores')->result();
    }
}

public function getGerente($id = '') {
    $this->db->order_by('nome', 'asc');
    if (!empty($id)) {
        $this->db->where('idGerente', $id);
        return $this->db->get('gerente')->row();
    } else {
        return $this->db->get('gerente')->result();
    }
}


///se der certo deixar somente este
/*voltar este feito em 07022025
public function getVendedores() {
    $this->db->select('idVendedor, nomeVendedor');
    $this->db->from('vendedores');
    $this->db->order_by('nomeVendedor', 'ASC');
    return $this->db->get()->result();
}
*/

//novo reescrito 07022025

public function getVendedores($idsParaExcluir = []) {
    $this->db->select('idVendedor, nomeVendedor');
    $this->db->from('vendedores');

    if (!empty($idsParaExcluir)) {
        $this->db->where_not_in('idVendedor', $idsParaExcluir);
    }

    $this->db->order_by('nomeVendedor', 'ASC');
    return $this->db->get()->result();
}


public function buscarAuxiliares($idVendedor) {
    $this->db->select('va.idVendedorAuxiliar AS idVendedorAuxiliar, u.nome AS nomeVendedorAuxiliar');
    $this->db->from('vendedores_vend_auxiliar vva');
    $this->db->join('vendedores_auxiliar va', 'vva.idVendedoresAuxiliar = va.idVendedorAuxiliar', 'left');
    $this->db->join('usuarios u', 'va.idUsuario = u.idUsuarios', 'left');
    $this->db->join('orcamento o', 'o.idVendedorAuxiliar = vva.idVendedoresAuxiliar AND o.idVendedor = '.(int)$idVendedor, 'left');

    // Adicionando condição para verificar o idVendedor na tabela vendedores_vend_auxiliar
    $this->db->where('vva.idVendedores', $idVendedor);

    // Adicionando cláusula GROUP BY
    $this->db->group_by('va.idVendedorAuxiliar, u.nome');

    $this->db->order_by('va.idVendedorAuxiliar', 'DESC');
    return $this->db->get()->result();
}





 /*public function getVendedoresAuxiliares($idVendedores) {
    if (empty($idVendedores)) {
        return [];
    }

    $this->db->select('vva.idVendedores, va.idVendedorAuxiliar, u.nome AS nomeVendedorAuxiliar');
    $this->db->from('vendedores_vend_auxiliar vva');
    $this->db->join('vendedores_auxiliar va', 'vva.idVendedoresAuxiliar = va.idVendedorAuxiliar', 'left');
    $this->db->join('usuarios u', 'va.idUsuario = u.idUsuarios', 'left');
    $this->db->where_in('vva.idVendedores', $idVendedores);
    $this->db->order_by('u.nome', 'ASC');

    $query = $this->db->get();
    return $query->result_array();
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
		
       
       
    }*/
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
	
    public function getGrupoServico($id = ''){
		
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
			return $this->db->get('natoperacao')->row();
		}
		else{
           return $this->db->get('natoperacao')->result();
		}
    }
	public function getOrcItemDetailsById($id){
		$query = "SELECT * FROM orcamento_item 
			join orcamento on orcamento.idOrcamentos = orcamento_item.idOrcamentos 
			join produtos on produtos.idProdutos = orcamento_item.idProdutos 
			join clientes on clientes.idClientes = orcamento.idClientes 
			join clientes_solicitantes on clientes_solicitantes.idSolicitante = orcamento.idSolicitante 
			left join orc_servico_escopo on orc_servico_escopo.idOrcItem = orcamento_item.idOrcamento_item
			left join status_peritagem on status_peritagem.idStatusPeritagem = orcamento_item.idStatusPeritagem
			where orcamento_item.idOrcamento_item = ?";
		return $this->db->query($query, array((int)$id))->row();
	}

	public function getOrcItemDetailsById2($id){
		$query = "SELECT orcamento_item.*,orcamento.* ,produtos.*,clientes.*,clientes_solicitantes.*,os.idOs FROM orcamento_item 
			join orcamento on orcamento.idOrcamentos = orcamento_item.idOrcamentos 
			left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item 
			join produtos on produtos.idProdutos = orcamento_item.idProdutos 
			join clientes on clientes.idClientes = orcamento.idClientes 
			join clientes_solicitantes on clientes_solicitantes.idSolicitante = orcamento.idSolicitante 
			where orcamento_item.idOrcamento_item = ? group by orcamento_item.idOrcamento_item";
		return $this->db->query($query, array((int)$id))->row();
	}
	public function getOrcItemWithOs($idOrcamentosItem){
		$query = "SELECT * FROM `orcamento_item` join produtos on produtos.idProdutos = orcamento_item.idProdutos left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item where orcamento_item.idOrcamento_item = ?";
		return $this->db->query($query, array((int)$idOrcamentosItem))->row();
	}

	public function getUsuariosComPermissaoPeritagem($like){
		$query = "SELECT usuarios.* FROM `permissoes` join usuarios on usuarios.permissoes_id = permissoes.idPermissao WHERE permissoes like ? and (permissoes like '%\"cPeritagem\";s:1:\"1\";%' or permissoes like '%\"aPeritagem\";s:1:\"1\";%')";
		$like_escaped = '%' . $this->db->escape_like_str($like) . '%';
		return $this->db->query($query, array($like_escaped))->result();
	}

	/**/
	public function getUsuariosComPermissaoPeritagemEPermissaoFinalizar($like){
		$query = "SELECT usuarios.* FROM `permissoes` join usuarios on usuarios.permissoes_id = permissoes.idPermissao WHERE permissoes like ? and permissoes like '%\"cPeritagem\";s:1:\"1\";%'";
		$like_escaped = '%' . $this->db->escape_like_str($like) . '%';
		return $this->db->query($query, array($like_escaped))->result();
	}
	

	public function getAnexoDesenhoAguardandoAprovacao($idOrcItem){
		$query = "SELECT * FROM anexo_desenho join orcamento_item on orcamento_item.idOrcamento_item = anexo_desenho.idOrcamentos_item left join produtos on produtos.idProdutos = orcamento_item.idProdutos join usuarios on usuarios.idUsuarios = anexo_desenho.user_proprietario where orcamento_item.idOrcamento_item = ?";
		return $this->db->query($query, array((int)$idOrcItem))->result();
	}

	public function getAnexoDesenhoAguardandoAprovacao2($idEscopoItem,$idOrcItem){
		$query = "SELECT * FROM anexo_desenho join orcamento_item on orcamento_item.idOrcamento_item = anexo_desenho.idOrcamentos_item left join produtos on produtos.idProdutos = orcamento_item.idProdutos join usuarios on usuarios.idUsuarios = anexo_desenho.user_proprietario where orcamento_item.idOrcamento_item = ? and anexo_desenho.idOrcServicoEscopoItens = ?";
		return $this->db->query($query, array((int)$idOrcItem, (int)$idEscopoItem))->result();
	}

	public function getAnexoDesenhoAguardandoAprovacao3($idOsSub,$idOs){
		$query = "SELECT * FROM anexo_desenho left join orcamento_item on orcamento_item.idOrcamento_item = anexo_desenho.idOrcamentos_item left join produtos on produtos.idProdutos = orcamento_item.idProdutos join usuarios on usuarios.idUsuarios = anexo_desenho.user_proprietario where anexo_desenho.idOsSub = ? and anexo_desenho.idOs = ?";
		return $this->db->query($query, array((int)$idOsSub, (int)$idOs))->result();
	}

	public function getAnexoDesenhoAguardandoAprovacao4($idOs){
		$query = "SELECT * FROM anexo_desenho left join orcamento_item on orcamento_item.idOrcamento_item = anexo_desenho.idOrcamentos_item left join produtos on produtos.idProdutos = orcamento_item.idProdutos join usuarios on usuarios.idUsuarios = anexo_desenho.user_proprietario where anexo_desenho.idOs = ?";
		return $this->db->query($query, array((int)$idOs))->result();
	}

	public function getAnexoDesenhoAguardandoAprovacao5($idOrcItem,$idCatItem){
		$query = "SELECT * FROM anexo_desenho left join orcamento_item on orcamento_item.idOrcamento_item = anexo_desenho.idOrcamentos_item left join produtos on produtos.idProdutos = orcamento_item.idProdutos join usuarios on usuarios.idUsuarios = anexo_desenho.user_proprietario where anexo_desenho.idOrcamentos_item = ? and anexo_desenho.idCatItem = ?";
		return $this->db->query($query, array((int)$idOrcItem, (int)$idCatItem))->result();
	}

	public function getAnexoDesenhoByIdOrcItem($idOrcItem){
		$query = "SELECT * FROM anexo_desenho join usuarios on usuarios.idUsuarios = anexo_desenho.user_proprietario WHERE idOrcamentos_item = ?";
		return $this->db->query($query, array((int)$idOrcItem))->result();
	}
	public function getAnexoDesenhoByIdOs($idOs){
		$query = "SELECT * FROM anexo_desenho join usuarios on usuarios.idUsuarios = anexo_desenho.user_proprietario WHERE idOs = ?";
		return $this->db->query($query, array((int)$idOs))->result();
	}

	/*public function getOrçAguardandoDesenho($where){
		$query = "SELECT orcamento_item.*, os.idOs, produtos.*, vendedores.* FROM orcamento_item join produtos on produtos.idProdutos = orcamento_item.idProdutos left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item join orcamento on orcamento.idOrcamentos = orcamento_item.idOrcamentos join vendedores on vendedores.idVendedor = orcamento.idVendedor  $where";
		return $this->db->query($query)->result();
	}*/
	
public function getOrçAguardandoDesenho($where) {
    $query = "SELECT orcamento_item.*, os.idOs, produtos.*, vendedores.*
              FROM orcamento_item
              JOIN produtos ON produtos.idProdutos = orcamento_item.idProdutos
              LEFT JOIN os ON os.idOrcamento_item = orcamento_item.idOrcamento_item
              JOIN orcamento ON orcamento.idOrcamentos = orcamento_item.idOrcamentos
              JOIN vendedores ON vendedores.idVendedor = orcamento.idVendedor         
              $where and (os.idStatusOs NOT IN (89, 44, 97, 210, 91, 6) OR os.unid_execucao IN (3, 5)) ";
    return $this->db->query($query)->result();
}	

	public function getOrçAguardandoDesenho2($where){
		$query = "SELECT orcamento.idOrcamentos,
		clientes.nomeCliente,
		status_orcamento.nome_status_orc,
		orcamento.data_abertura,
		GROUP_CONCAT(orcamento_item.idOrcamento_item SEPARATOR ';') as idOrcamento_item,
		GROUP_CONCAT(produtos.pn SEPARATOR ';') as pn,
		GROUP_CONCAT(orcamento_item.descricao_item SEPARATOR ';') as descricao_item,
		GROUP_CONCAT(IF(os.idOs is null,' ',IF(os.idOs = ' ','',os.idOs)) SEPARATOR ';') as idOs,
		GROUP_CONCAT(vendedores.nomeVendedor SEPARATOR ';') as nomeVendedor
		FROM orcamento_item 
		JOIN produtos ON produtos.idProdutos = orcamento_item.idProdutos 
		LEFT JOIN os ON os.idOrcamento_item = orcamento_item.idOrcamento_item 
		JOIN orcamento ON orcamento.idOrcamentos = orcamento_item.idOrcamentos 
		JOIN vendedores ON vendedores.idVendedor = orcamento.idVendedor 
		JOIN status_orcamento ON status_orcamento.idstatusOrcamento = orcamento.idstatusOrcamento
		JOIN clientes ON clientes.idClientes = orcamento.idClientes 
		$where AND (os.idStatusOs NOT IN (89, 44, 97, 210, 91, 6) OR os.unid_execucao IN (3, 5))
		GROUP BY orcamento.idOrcamentos";
		return $this->db->query($query)->result();
	}
 //A mostrar registos de 0 - 24 (8449 total, A consulta demorou 0,3995 segundos.) com unid execucao
 // A mostrar registos de 0 - 24 (2681 total, A consulta demorou 0,1562 segundos.) sem und execucao
	
	

	public function getOrçAguardandoDesenho3($where){
		$query = "SELECT DISTINCT unidade_execucao.status_execucao,os.unid_execucao
		FROM orcamento_item 
		join produtos on produtos.idProdutos = orcamento_item.idProdutos 
		left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item 
		join orcamento on orcamento.idOrcamentos = orcamento_item.idOrcamentos 
		join vendedores on vendedores.idVendedor = orcamento.idVendedor 
		join status_orcamento on status_orcamento.idstatusOrcamento = orcamento.idstatusOrcamento
		left join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao
		join clientes on clientes.idClientes = orcamento.idClientes 
		$where and (os.idStatusOs NOT IN (89, 44, 97, 210, 91, 6) OR os.unid_execucao IN (3, 5))
		group by orcamento.idOrcamentos order by unidade_execucao.status_execucao asc";
		//echo $query;
		//exit;
		return $this->db->query($query)->result();
	}

	public function getSubOsbyidOs($id){
		$query = "SELECT * FROM os_sub WHERE idOs = ?";
		return $this->db->query($query, array((int)$id))->result();
	}
	public function getUsuariosComPermissao($like){
		$query = 'SELECT * FROM `permissoes` join usuarios on usuarios.permissoes_id = permissoes.idPermissao WHERE permissoes like ?';
		$like_escaped = '%' . $this->db->escape_like_str($like) . '%';
		return $this->db->query($query, array($like_escaped))->result();
	}

	public function getUsuariosComidPermissao($id){
		$query = "SELECT usuarios.* FROM `permissoes` join usuarios on usuarios.permissoes_id = permissoes.idPermissao WHERE usuarios.permissoes_id = ?";
		return $this->db->query($query, array((int)$id))->result();
	}

	public function getEscopoItem($idOrcItem){
		$query = 'SELECT servico_escopo_itens.* FROM `orc_servico_escopo_itens` join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens where orc_servico_escopo_itens.idOrcServicoEscopoItens = ?';
		return $this->db->query($query, array((int)$idOrcItem))->row();
	}
	public function getAnexoDesenhoByIdAnexo($id){
		$query = "SELECT * FROM anexo_desenho where idAnexo = ?";
		return $this->db->query($query, array((int)$id))->row();
	}
	public function getOrcamentoByidOrcItem($idOrc){
		$query = "SELECT orcamento.* FROM orcamento join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos where orcamento_item.idOrcamento_item = ?";
		return $this->db->query($query, array((int)$idOrc))->row();
	}
	public function getOrcamentoByidOrcItem2($idOrc){
		$query = "SELECT orcamento.*, produtos.*, orcamento_item.descricao_item FROM orcamento join orcamento_item on orcamento_item.idOrcamentos = orcamento.idOrcamentos join produtos on produtos.idProdutos = orcamento_item.idProdutos where orcamento_item.idOrcamento_item = ?";
		return $this->db->query($query, array((int)$idOrc))->row();
	}
	public function getAnexoDesenhoByIdOsSub($idOsSub){
		$query = "SELECT * FROM anexo_desenho left join orcamento_item on orcamento_item.idOrcamento_item = anexo_desenho.idOrcamentos_item left join produtos on produtos.idProdutos = orcamento_item.idProdutos join usuarios on usuarios.idUsuarios = anexo_desenho.user_proprietario where anexo_desenho.idOsSub = ?";
		return $this->db->query($query, array((int)$idOsSub))->result();
	}
	public function getAnexoDesenhoByIdOsSubAndPos0($idOsSub,$idOs){
		$query = "SELECT * FROM anexo_desenho left join orcamento_item on orcamento_item.idOrcamento_item = anexo_desenho.idOrcamentos_item left join produtos on produtos.idProdutos = orcamento_item.idProdutos join usuarios on usuarios.idUsuarios = anexo_desenho.user_proprietario where anexo_desenho.idOsSub = ? or (anexo_desenho.idOs = ? and anexo_desenho.idOsSub is null)";
		return $this->db->query($query, array((int)$idOsSub, (int)$idOs))->result();
	}
   
	function getEstoqueProd($idProd){
		$query = "SELECT sum(almo_estoque_produtos.quantidade) as quantidade FROM `almo_estoque_produtos` where idOs is null and idProduto = ? group by almo_estoque_produtos.idProduto";
		return $this->db->query($query, array((int)$idProd))->row();
	}

	public function getSubOsbyIdOsSub($id){
		$query = "SELECT * FROM os_sub WHERE idOsSub = ?";
		return $this->db->query($query, array((int)$id))->row();
	}
	public function getAllSubOsbyIdOsAndIdProd($idOs,$idProd){
		$query = "SELECT * FROM os_sub WHERE idOs = ? and idProduto_sub = ?";
		return $this->db->query($query, array((int)$idOs, (int)$idProd))->result();
	}
	public function getOrcDetail($id = ''){
		$query = "SELECT * FROM orcamento left join clientes on clientes.idClientes = orcamento.idClientes left join clientes_solicitantes on clientes_solicitantes.idSolicitante = orcamento.idSolicitante left join vendedores on vendedores.idVendedor = orcamento.idVendedor where orcamento.idOrcamentos = ?";
		return $this->db->query($query, array((int)$id))->row();

	}


	public function getSolicitacoesPendente($idOrcItem){
		$query = "SELECT prodnovo.descricao as descricaoNovo, prodnovo.pn as pnNovo,  prodatual.descricao as descricaoAtual, prodatual.pn as pnAtual,solicitacao_alterar_pn.idSolicitacaoAltPn FROM solicitacao_alterar_pn JOIN produtos as prodnovo on prodnovo.idProdutos = solicitacao_alterar_pn.idProdutoNovo JOIN produtos as prodatual on prodatual.idProdutos = solicitacao_alterar_pn.idProduto WHERE idOrcamento_item = ? and idStatusSolicitacao = 1";
		return $this->db->query($query, array((int)$idOrcItem))->result();
	}
	public function getSolicitacoesPendenteByIdOrcItem($idOrcItem){
		$query = "SELECT prodatual.idProdutos as idProdutosAtual, prodnovo.idProdutos as idProdutosNovo,prodnovo.descricao as descricaoNovo, prodnovo.pn as pnNovo,  prodatual.descricao as descricaoAtual, prodatual.pn as pnAtual,solicitacao_alterar_pn.idSolicitacaoAltPn FROM solicitacao_alterar_pn JOIN produtos as prodnovo on prodnovo.idProdutos = solicitacao_alterar_pn.idProdutoNovo JOIN produtos as prodatual on prodatual.idProdutos = solicitacao_alterar_pn.idProduto WHERE idOrcamento_item = ? and idStatusSolicitacao = 1";
		return $this->db->query($query, array((int)$idOrcItem))->row();
	}
	public function getInfoOrcItem($idOrcItem){
		$query = "SELECT * FROM orcamento_item join produtos on produtos.idProdutos = orcamento_item.idProdutos where orcamento_item.idOrcamento_item = ?";
		return $this->db->query($query, array((int)$idOrcItem))->row();
	}
	public function getAllTiposServico(){
		$query = "SELECT * FROM tiposservico";
		return $this->db->query($query)->result();
	}

	public function addHistTransfOrc($item){
		$item['idUsuario'] = $this->session->userdata('idUsuarios');
		$item['url'] = $this->uri->uri_string();
		$this->db->insert('orcamento_transferencia',$item);
		if ($this->db->affected_rows() == '1')
		{			
			return true;			
		}		
		return FALSE;
	}
	function getAllTipoQtd(){
		$query = "SELECT * FROM tipo_qtd";
		return $this->db->query($query)->result();
	}

	function getAllTipoEntrega(){
		$query = "SELECT * FROM tipo_entrega";
		return $this->db->query($query)->result();
	}
}

/* End of file vendas_model.php */
/* Location: ./application/models/vendas_model.php */