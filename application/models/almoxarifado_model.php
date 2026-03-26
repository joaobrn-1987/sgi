<?php
class Almoxarifado_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function get($table,$fields,$where='',$perpage=1,$start=0,$one=false,$array='array'){
        
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
    function get2($table,$fields,$where='',$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }
    function edit($table,$data,$fieldID,$ID){
        return $this->histAlteracao($table,$data,$fieldID,$ID);      
    }
    function edit2($table,$data,$where){/*
        $this->db->where($where);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
		{
			return $this->db->affected_rows();
		}
		
		return FALSE;   */
        return $this->histAlteracao($table,$data,false,false,false,$where);     
    }
    function getObj($table,$fieldID,$ID,$where = false){

        $this->db->select('*');
        $this->db->from($table);
        if($where){
            $this->db->where($where);
        }else if($fieldID == false){
			$ID_safe = implode(',', array_map('intval', explode(',', $ID)));
			$this->db->where('idOs in ('.$ID_safe.')');
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
	function histAlteracao($table,$data,$fieldID,$ID = false,$retorno = false,$where = ''){
		$itensAntes = $this->getObj($table,$fieldID,$ID,$where);
		$fields = $this->db->field_data($table);
		foreach ($fields as $field)
		{
			if($field->primary_key == 1){
				$primary_key = $field->name;
			}
		}
		if($where){
            $this->db->where($where);
        }else if($fieldID == false){
			$ID_safe = implode(',', array_map('intval', explode(',', $ID)));
			$this->db->where('idOs in ('.$ID_safe.')');
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
    public function autoCompleteLocais($q, $e,$d){

        $this->db->select('*');
        $this->db->limit(20);
        $this->db->like('local', $q);
        $this->db->where('idEmitente',$e);
        if(!empty($d)){
            $this->db->where('idDepartamento',$d);
        }
        $query = $this->db->get('almo_estoque_locais');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['local'],'id'=>$row['idAlmoEstoqueLocais']);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteFunc($q){

        $this->db->select('*');
        $this->db->limit(20);
        $this->db->like('almo_estoque_usuario.nome', $q);
        $this->db->join('setor_empresa', 'setor_empresa.id_setor = almo_estoque_usuario.idSetor');
        //$this->db->where('almo_estoque_usuario.idSetor',$e);
        $query = $this->db->get('almo_estoque_usuario');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome'].' | Setor.: '.$row['nomesetor'],'id'=>$row['idAlmoEstoqueUsuario'],'nomeSetor'=>$row['nomesetor'],'idSetor'=>$row['idSetor'],'nome'=>$row['nome']);
            }
			
            echo json_encode($row_set);
        }
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
    public function autoCompleteInsumos($q){
        $q_safe = $this->db->escape_like_str($q);
        $query2 = 'SELECT insumos.*, subcategoriaInsumo.*,categoriaInsumos.* , (select SUM(quantidade) from almo_estoque where almo_estoque.idProduto = insumos.idInsumos and almo_estoque.idEmitente = 1 ) as qtdEst FROM `insumos` join subcategoriaInsumo on subcategoriaInsumo.idSubcategoria = insumos.idSubcategoria join categoriaInsumos on categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria where insumos.descricaoInsumo like "%'.$q_safe.'%" and insumos.ativoIns = 1';

        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->descricaoInsumo,'id'=>$row->idInsumos,'idCat'=>$row->idCategoria,'idSubcat'=>$row->idSubcategoria,'descricaoCategoria'=>$row->descricaoCategoria,'descricaoSubcategoria'=>$row->descricaoSubcategoria,'descricao'=>$row->descricaoInsumo,'qtdEst'=>$row->qtdEst,'pn'=>$row->pn_insumo);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompletePN($q){
        $q_safe = $this->db->escape_like_str($q);
        $query2 = 'SELECT insumos.*, subcategoriaInsumo.*,categoriaInsumos.* , (select SUM(quantidade) from almo_estoque where almo_estoque.idProduto = insumos.idInsumos and almo_estoque.idEmitente = 1 ) as qtdEst FROM `insumos` join subcategoriaInsumo on subcategoriaInsumo.idSubcategoria = insumos.idSubcategoria join categoriaInsumos on categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria where insumos.pn_insumo like "%'.$q_safe.'%"  and insumos.ativoIns = 1';

        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->pn_insumo.' | Descrição: '.$row->descricaoInsumo,'id'=>$row->idInsumos,'idCat'=>$row->idCategoria,'idSubcat'=>$row->idSubcategoria,'descricaoCategoria'=>$row->descricaoCategoria,'descricaoSubcategoria'=>$row->descricaoSubcategoria,'descricao'=>$row->descricaoInsumo,'qtdEst'=>$row->qtdEst,'pn'=>$row->pn_insumo);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteInsumosPN($q,$e,$d){

        $this->db->select('almo_estoque.idAlmoEstoque,
        almo_estoque.idProduto,
        almo_estoque.idEmitente,
        almo_estoque.idLocal,
        almo_estoque.quantidade,
        almo_estoque.metrica,
        almo_estoque.volume,
        almo_estoque.comprimento,
        almo_estoque.peso,
        almo_estoque.dimensoesL,
        almo_estoque.dimensoesC,
        almo_estoque.dimensoesA,
        insumos.idInsumos,
        insumos.descricaoInsumo,
        insumos.pn_insumo,
        emitente.id,
        emitente.nome,
        almo_estoque_locais.idAlmoEstoqueLocais,
        almo_estoque_locais.local');
        $this->db->from('almo_estoque');
        $this->db->join('insumos','insumos.idInsumos = almo_estoque.idProduto');
        $this->db->join('emitente','emitente.id = almo_estoque.idEmitente');
        $this->db->join('almo_estoque_locais','almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal','left');
        $this->db->limit(10);/*
        $this->db->like('insumos.pn_insumo', $q);
        $this->db->where('almo_estoque.idEmitente',$e);
        $this->db->where('almo_estoque.idDepartamento',$d);*/
        $this->db->where("almo_estoque.idEmitente = ".(int)$e." and insumos.pn_insumo like ".$this->db->escape($q.'%')." and almo_estoque.idDepartamento = ".(int)$d." and (almo_estoque.idOs is null or almo_estoque.idOs = '')", null, false);
        $query = $this->db->get();
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                if($row['local'] == null){
                    if($row['metrica'] == 0){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    } else if($row['metrica'] == 1){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | '.$row['comprimento'].' MM','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 2){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | '.$row['volume'].' ML','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 3){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | '.$row['peso'].' G','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 4){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | '.$row['dimensoesL'].' mm X '.$row['dimensoesC'].' mm X '.$row['dimensoesA'].' mm ','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }
                }else{
                    if($row['metrica'] == 0){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    } else if($row['metrica'] == 1){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | '.$row['comprimento'].' MM'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 2){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | '.$row['volume'].' ML'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 3){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | '.$row['peso'].' G'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 4){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | '.$row['dimensoesL'].' mm X '.$row['dimensoesC'].' mm X '.$row['dimensoesA'].' mm '.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }
                }
                
                
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteInsumos2($q){

        $this->db->select('*');
        $this->db->limit(20);
        $this->db->like('produtos.descricao', $q);
        $this->db->order_by('produtos.descricao asc, produtos.pn asc, produtos.referencia asc');
        $query = $this->db->get('produtos');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricao'].' | PN: '.$row['pn'].' | REF.: '.$row['referencia'],'id'=>$row['idProdutos'],'pn'=>$row['pn']);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompletePN2($q){
        $q_safe = $this->db->escape_like_str($q);
        $query2 = 'SELECT produtos.*,(select SUM(quantidade) from almo_estoque_produtos where almo_estoque_produtos.idProduto = produtos.idProdutos and almo_estoque_produtos.idEmitente = 1) as qtdEstt FROM produtos where produtos.pn like "%'.$q_safe.'%" limit 20';

        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->pn.' | Descrição: '.$row->descricao.' | REF.: '.$row->referencia,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteREF2($q){
        $q_safe = $this->db->escape_like_str($q);
        $query2 = 'SELECT produtos.*,(select SUM(quantidade) from almo_estoque_produtos where almo_estoque_produtos.idProduto = produtos.idProdutos and almo_estoque_produtos.idEmitente = 1) as qtdEstt FROM produtos where produtos.referencia like "%'.$q_safe.'%" limit 20';

        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->referencia.' | Descrição: '.$row->descricao.' | PN: '.$row->pn,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteProd($q){
        $q_safe = $this->db->escape_like_str($q);
        $query2 = 'SELECT produtos.*,(select SUM(quantidade) from almo_estoque_produtos where almo_estoque_produtos.idProduto = produtos.idProdutos and almo_estoque_produtos.idEmitente = 1) as qtdEstt FROM produtos where produtos.descricao like "%'.$q_safe.'%" limit 20';
        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->descricao.' | PN: '.$row->pn.' | REF.: '.$row->referencia,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteProd2($q){
        $q_safe = $this->db->escape_like_str($q);
        $query2 = 'SELECT produtos.*,(select SUM(quantidade) from almo_estoque_produtos where almo_estoque_produtos.idProduto = produtos.idProdutos and almo_estoque_produtos.idEmitente = 1) as qtdEstt FROM produtos where produtos.pn like "'.$q_safe.'%" limit 20';
        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->pn,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteEstoqueSaida($q, $e,$d){

        $this->db->select('almo_estoque.idAlmoEstoque,
        almo_estoque.idProduto,
         almo_estoque.idEmitente,
         almo_estoque.idLocal,
         almo_estoque.quantidade,
         almo_estoque.metrica,
         almo_estoque.volume,
         almo_estoque.comprimento,
         almo_estoque.peso,
         almo_estoque.dimensoesL,
         almo_estoque.dimensoesC,
         almo_estoque.dimensoesA,
         insumos.idInsumos,
         insumos.descricaoInsumo,
         insumos.pn_insumo,
         emitente.id,
         emitente.nome,
         almo_estoque_locais.idAlmoEstoqueLocais,
         almo_estoque_locais.local');
         $this->db->from('almo_estoque');
         $this->db->join('insumos','insumos.idInsumos = almo_estoque.idProduto');
         $this->db->join('emitente','emitente.id = almo_estoque.idEmitente');
         $this->db->join('almo_estoque_locais','almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal','left');
        $this->db->limit(10);/*
        $this->db->like('insumos.descricaoInsumo', $q);
        $this->db->where('almo_estoque.idEmitente',$e);
        $this->db->where('almo_estoque.idDepartamento',$d);
		$this->db->where("almo_estoque.idEmitente = '$e' and insumos.descricaoInsumo like '%$q%' and almo_estoque.idDepartamento = '$d' and (almo_estoque.idOs is null or almo_estoque.idOs = '')");
		$this->db->where("almo_estoque.idEmitente = '$e' and insumos.descricaoInsumo like '%$q%' and almo_estoque.idDepartamento = '$d' ");*/
        $this->db->where("almo_estoque.idEmitente = ".(int)$e." and insumos.descricaoInsumo like ".$this->db->escape('%'.$q.'%')." and almo_estoque.idDepartamento = ".(int)$d, null, false);
        
        $query = $this->db->get();
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                if($row['local'] == null){
                    if($row['metrica'] == 0){
                        $row_set[] = array('label'=>$row['descricaoInsumo'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    } else if($row['metrica'] == 1){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['comprimento'].' MM','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 2){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['volume'].' ML','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 3){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['peso'].' G','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 4){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['dimensoesL'].' mm X '.$row['dimensoesC'].' mm X '.$row['dimensoesA'].' mm','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }
                }else{
                    if($row['metrica'] == 0){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    } else if($row['metrica'] == 1){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['comprimento'].' MM'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 2){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['volume'].' ML'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 3){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['peso'].' G'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 4){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['dimensoesL'].' mm X '.$row['dimensoesC'].' mm X '.$row['dimensoesA'].' mm'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }
                }
                
                
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteEstoqueSaidaLocal($q, $e,$d){

        $this->db->select('almo_estoque.idAlmoEstoque,
        almo_estoque.idProduto,
         almo_estoque.idEmitente,
         almo_estoque.idLocal,
         almo_estoque.quantidade,
         almo_estoque.metrica,
         almo_estoque.volume,
         almo_estoque.comprimento,
         almo_estoque.peso,
         almo_estoque.dimensoesL,
         almo_estoque.dimensoesC,
         almo_estoque.dimensoesA,
         insumos.idInsumos,
         insumos.descricaoInsumo,
         insumos.pn_insumo,
         emitente.id,
         emitente.nome,
         almo_estoque_locais.idAlmoEstoqueLocais,
         almo_estoque_locais.local');
         $this->db->from('almo_estoque');
         $this->db->join('insumos','insumos.idInsumos = almo_estoque.idProduto');
         $this->db->join('emitente','emitente.id = almo_estoque.idEmitente');
         $this->db->join('almo_estoque_locais','almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal','left');
        //$this->db->limit(30);
        /*
        $this->db->like('insumos.descricaoInsumo', $q);
        $this->db->where('almo_estoque.idEmitente',$e);
        $this->db->where('almo_estoque.idDepartamento',$d);*/
        $this->db->where("almo_estoque.idEmitente = ".(int)$e." and almo_estoque_locais.local like ".$this->db->escape('%'.$q.'%')." and almo_estoque.idDepartamento = ".(int)$d." and (almo_estoque.idOs is null or almo_estoque.idOs = '')", null, false);
        $query = $this->db->get();
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                if($row['local'] == null){
                    if($row['metrica'] == 0){
                        $row_set[] = array('label'=>$row['descricaoInsumo'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    } else if($row['metrica'] == 1){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['comprimento'].' MM','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 2){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['volume'].' ML','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 3){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['peso'].' G','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 4){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['dimensoesL'].' mm X '.$row['dimensoesC'].' mm X '.$row['dimensoesA'].' mm','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }
                }else{
                    if($row['metrica'] == 0){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    } else if($row['metrica'] == 1){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['comprimento'].' MM'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 2){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['volume'].' ML'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 3){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['peso'].' G'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }if($row['metrica'] == 4){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['dimensoesL'].' mm X '.$row['dimensoesC'].' mm X '.$row['dimensoesA'].' mm'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    }
                }
                
                
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteProdEstoque($q, $e,$d){
        $this->db->select('produtos.descricao, 
        produtos.pn, 
        produtos.referencia, 
        almo_estoque_departamento.idAlmoEstoqueDep, 
        almo_estoque_departamento.descricaoDepartamento, 
        almo_estoque_produtos.idAlmoEstoqueProduto, 
        almo_estoque_produtos.quantidade, 
        almo_estoque_produtos.idStatusProduto,
        almo_estoque_produtos.idOs,
        almo_estoque_locais.local,
        emitente.nome');
        $this->db->from('almo_estoque_produtos');
        $this->db->join('produtos','produtos.idProdutos = almo_estoque_produtos.idProduto');
        $this->db->join('almo_estoque_departamento','almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento');
        $this->db->join('emitente','emitente.id = almo_estoque_produtos.idEmitente ');
        $this->db->join('almo_estoque_locais','almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_produtos.idLocal','left');
        $this->db->limit(10);
        $this->db->like('produtos.descricao', $q);
        $this->db->where('almo_estoque_produtos.idEmitente',$e);
        $this->db->where('almo_estoque_produtos.idDepartamento',$d);
        $this->db->where('almo_estoque_produtos.quantidade >','0');
        $query = $this->db->get();
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){   
                $label =  $row['descricao'];
                $label = $label." | PN: ".$row['pn'];
                if(!empty($row['idOs'])){
                    $label = $label." | OS: ".$row['idOs'];
                }
                if(!empty($row['local'])){
                    $label = $label." | Local: ".$row['local'];
                }
                $row_set[] = array('label'=>$label,'id'=>$row['idAlmoEstoqueProduto'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricao'],"pn"=>$row['pn'],"referencia"=>$row['referencia']);
                
                
            }
			
            echo json_encode($row_set);
        }

    }
    public function autoCompletePnEstoque($q, $e,$d){
        $this->db->select('produtos.descricao, 
        produtos.pn, 
        produtos.referencia,
        almo_estoque_departamento.idAlmoEstoqueDep, 
        almo_estoque_departamento.descricaoDepartamento, 
        almo_estoque_produtos.idAlmoEstoqueProduto, 
        almo_estoque_produtos.quantidade, 
        almo_estoque_produtos.idStatusProduto,
        almo_estoque_produtos.idOs,
        almo_estoque_locais.local,
        status_produto.descricaoStatusProduto,
        emitente.nome');
        $this->db->from('almo_estoque_produtos');
        $this->db->join('produtos','produtos.idProdutos = almo_estoque_produtos.idProduto');
        $this->db->join('almo_estoque_departamento','almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento');
        $this->db->join('emitente','emitente.id = almo_estoque_produtos.idEmitente ');
        $this->db->join('almo_estoque_locais','almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_produtos.idLocal','left');
        $this->db->join('status_produto','status_produto.idStatusProduto = almo_estoque_produtos.idStatusProduto ');
        $this->db->limit(10);
        $this->db->like('produtos.pn', $q);
        $this->db->where('almo_estoque_produtos.idEmitente',$e);
        $this->db->where('almo_estoque_produtos.idDepartamento',$d);
        $this->db->where('almo_estoque_produtos.quantidade >','0');
        $query = $this->db->get();
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $label =  $row['pn'];
                $label = $label." | Descrição: ".$row['descricao'];
                if(!empty($row['idOs'])){
                    $label = $label." | OS: ".$row['idOs'];
                }
                if(!empty($row['local'])){
                    $label = $label." | Local: ".$row['local'];
                }
                $label = $label." | Status: ".$row['descricaoStatusProduto'];
                $row_set[] = array('label'=>$label,'id'=>$row['idAlmoEstoqueProduto'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricao'],"pn"=>$row['pn'],"referencia"=>$row['referencia']);
                
            }
			
            echo json_encode($row_set);
        }

    }
    public function autoCompleteREFEstoque($q, $e,$d){
        $this->db->select('produtos.descricao, 
        produtos.pn, 
        produtos.referencia,
        almo_estoque_departamento.idAlmoEstoqueDep, 
        almo_estoque_departamento.descricaoDepartamento, 
        almo_estoque_produtos.idAlmoEstoqueProduto, 
        almo_estoque_produtos.quantidade, 
        almo_estoque_produtos.idStatusProduto,
        almo_estoque_produtos.idOs,
        almo_estoque_locais.local,
        emitente.nome');
        $this->db->from('almo_estoque_produtos');
        $this->db->join('produtos','produtos.idProdutos = almo_estoque_produtos.idProduto');
        $this->db->join('almo_estoque_departamento','almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento');
        $this->db->join('emitente','emitente.id = almo_estoque_produtos.idEmitente ');
        $this->db->join('almo_estoque_locais','almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_produtos.idLocal','left');
        $this->db->limit(10);
        $this->db->like('produtos.referencia', $q);
        $this->db->where('almo_estoque_produtos.idEmitente',$e);
        $this->db->where('almo_estoque_produtos.idDepartamento',$d);
        $this->db->where('almo_estoque_produtos.quantidade >','0');
        $query = $this->db->get();
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){   
                $label =  $row['referencia'];
                $label = $label." | Descrição: ".$row['descricao'];
                $label = $label." | PN: ".$row['pn'];
                if(!empty($row['idOs'])){
                    $label = $label." | OS: ".$row['idOs'];
                }
                if(!empty($row['local'])){
                    $label = $label." | Local: ".$row['local'];
                }
                $row_set[] = array('label'=>$label,'id'=>$row['idAlmoEstoqueProduto'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricao'],"pn"=>$row['pn'],"referencia"=>$row['referencia']);
                
                
            }
			
            echo json_encode($row_set);
        }

    }
    public function verificaPEDL($p,$emp,$dep,$l,$sp){
        $p = (int)$p; $emp = (int)$emp; $dep = (int)$dep; $l = (int)$l; $sp = (int)$sp;
        $primeiro = true;
        $where = "";
        $this->db->select();
        $this->db->from("almo_estoque_produtos");
        if(!empty($p)){
            if($primeiro){
                $where = $where." idProduto = ".$p;
                $primeiro = false;
            }else{
                $where = $where." and idProduto = ".$p;
            }
        }
        if(!empty($emp)){
            if($primeiro){
                $where = $where." idEmitente = ".$emp;
                $primeiro = false;
            }else{
                $where = $where." and idEmitente = ".$emp;
            }
        }
        if(!empty($dep)){
            if($primeiro){
                $where = $where." idDepartamento = ".$dep;
                $primeiro = false;
            }else{
                $where = $where." and idDepartamento = ".$dep;
            }
        }
        if(!empty($l)){
            if($primeiro){
                $where = $where." idLocal = ".$l;
                $primeiro = false;
            }else{
                $where = $where." and idLocal = ".$l;
            }
        }
        if(!empty($sp)){
            if($primeiro){
                $where = $where." idStatusProduto = ".$sp;
                $primeiro = false;
            }else{
                $where = $where." and idStatusProduto = ".$sp;
            }
        }/*
        if(!empty($os)){
            if($primeiro){
                $where = $where." idOs = ".$os;
                $primeiro = false;
            }else{
                $where = $where." and idOs = ".$os;
            }
        }*/
        $this->db->where($where,null,false);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;

    }
    public function verificaPMEL($p,$m,$c,$v,$ps,$dimL,$dimC,$dimA,$e,$l,$dep,$idOs = null){
        $primeiro = true;
        $where = "";
        $m = (int)$m; $p = (int)$p; $e = (int)$e; $l = (int)$l; $dep = (int)$dep;
        $c = (float)$c; $v = (float)$v; $ps = (float)$ps;
        $dimL = (float)$dimL; $dimC = (float)$dimC; $dimA = (float)$dimA;
        if(!empty($idOs)) { $idOs = (int)$idOs; }
        $this->db->select();
        $this->db->from("almo_estoque");
        if($m != 0){
            if($primeiro){
                if(!empty($v) && $v != ""){
                    $where = $where." metrica = ".$m." and volume = ".$v;
                }else if(!empty($c) && $c != ""){
                    $where = $where." metrica = ".$m." and comprimento = ".$c;
                }else if(!empty($ps) && $ps != ""){
                    $where = $where." metrica = ".$m." and peso = ".$ps;
                } else if((!empty($dimL) && $dimL != "") || (!empty($dimC) && $dimC != "") || (!empty($dimA) && $dimA != "")){
                    //$dim = explode('x',$dim);
                    //$where = $where." metrica = ".$m." and dimensoesL = ".$dim[0]." and dimensoesC = ".$dim[1]." and dimensoesA = ".$dim[2];
                    $where = $where." metrica=".$m;
                    if(!empty($dimL)){
                        $where.= " and dimensoesL = ".$dimL;
                    }
                    if(!empty($dimC)){
                        $where.= " and dimensoesC = ".$dimC;
                    }
                    if(!empty($dimA)){
                        $where.= " and dimensoesA = ".$dimA;
                    }
                }
                $primeiro = false;
            }else{
                if(!empty($v) && $v != ""){
                    $where = $where." and metrica = ".$m." and volume = ".$v;
                } else if(!empty($c) && $c != ""){
                    $where = $where." and metrica = ".$m." and comprimento = ".$c;
                } else if(!empty($ps) && $ps != ""){
                    $where = $where." and metrica = ".$m." and peso = ".$ps;
                } else if((!empty($dimL) && $dimL != "") || (!empty($dimC) && $dimC != "") || (!empty($dimA) && $dimA != "")){
                    //$dim = explode('x',$dim);
                    //$where = $where." and metrica = ".$m." and dimensoesL = ".$dim[0]." and dimensoesC = ".$dim[1]." and dimensoesA = ".$dim[2];
                    $where = $where." and metrica=".$m;
                    if(!empty($dimL)){
                        $where.= " and dimensoesL = ".$dimL;
                    }
                    if(!empty($dimC)){
                        $where.= " and dimensoesC = ".$dimC;
                    }
                    if(!empty($dimA)){
                        $where.= " and dimensoesA = ".$dimA;
                    }
                }
            }
        }
        if(!empty($p)){
            if($primeiro){
                $where = $where." idProduto = ".$p;
                $primeiro = false;
            } else {
                $where = $where." and idProduto = ".$p;
            }
        }
        if(!empty($e)){
            if($primeiro){
                $where = $where." idEmitente = ".$e;
                $primeiro = false;
            } else{
                $where = $where." and idEmitente = ".$e;
            }
        }
        if(!empty($l)){
            if($primeiro){
                $where = $where." idLocal = ".$l;
                $primeiro = false;
            } else{
                $where = $where." and idLocal = ".$l;
            }
        }else{
            if($primeiro){
                $where = $where." idLocal IS NULL ";
                $primeiro = false;
            } else{
                $where = $where." and idLocal IS NULL";
            }
        }
        if(!empty($dep)){
            if($primeiro){
                $where = $where." idDepartamento = ".$dep;
                $primeiro = false;
            } else{
                $where = $where." and idDepartamento = ".$dep;
            }
        }
        if(!empty($idOs)){
            if($primeiro){
                $where = $where." idOs = ".$idOs;
                $primeiro = false;
            } else{
                $where = $where." and idOs = ".$idOs;
            }
        }
        $this->db->where($where,null,false);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
    public function criarEstoqueEntrada($p,$m,$c,$v,$ps,$dimL,$dimC,$dimA,$e,$l,$qtd,$idUser,$nf,$idOs,$vu,$dep){
        if(empty($nf)){
            $nf = null;
        }
        if(empty($idOs)){
            $idOs = null;
        }
        if($m == 0){
            $data = array(
                "idProduto" => $p,
                "metrica" => "0",
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idLocal" => $l,
                "idDepartamento" => $dep,
                "nf" => $nf,
                "idOs" => $idOs,
                "data_entrada" => date('Y-m-d H:i:s'),
                "idUsuario" => $idUser,
                "valorUnitario"=> $vu
            );
        } else if($m == 1){
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "comprimento" => $c,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idLocal" => $l,
                "idDepartamento" => $dep,
                "nf" => $nf,
                "idOs" => $idOs,
                "data_entrada" => date('Y-m-d H:i:s'),
                "idUsuario" => $idUser,
                "valorUnitario"=> $vu
            );
        } else if($m == 2){
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "volume" => $v,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idLocal" => $l,
                "idDepartamento" => $dep,
                "nf" => $nf,
                "idOs" => $idOs,
                "data_entrada" => date('Y-m-d H:i:s'),
                "idUsuario" => $idUser,
                "valorUnitario"=> $vu
            );
        }else if($m == 3){
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "peso" => $ps,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idLocal" => $l,
                "idDepartamento" => $dep,
                "nf" => $nf,
                "idOs" => $idOs,
                "data_entrada" => date('Y-m-d H:i:s'),
                "idUsuario" => $idUser,
                "valorUnitario"=> $vu
            );
        }else if($m == 4){
            //$dim = explode('x',$dim);
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "dimensoesL" => $dimL,
                "dimensoesC" => $dimC,
                "dimensoesA" => $dimA,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idLocal" => $l,
                "idDepartamento" => $dep,
                "nf" => $nf,
                "idOs" => $idOs,
                "data_entrada" => date('Y-m-d H:i:s'),
                "idUsuario" => $idUser,
                "valorUnitario"=> $vu
            );
        }
        $this->db->insert("almo_estoque_entrada",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_entrada");        
		}
    }
    public function criarEstoqueEntradaProduto($p,$qtd,$emp,$dep,$l,$nf,$vu,$os,$idUser,$sp){
        $data = array(
            "idProduto"=> $p,
            "quantidade"=> $qtd,
            "idEmitente"=> $emp,
            "idDepartamento"=> $dep,
            "idStatusProduto"=> $sp,
            "idLocal"=> $l,
            "data_entrada"=> date('Y-m-d H:i:s'),
            "nf"=> $nf,
            "valorUnitario"=> $vu,
            "idUsuario" => $idUser,
            "idOs"=> $os
        );
        $this->db->insert("almo_estoque_p_entrada",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_p_entrada");        
		}
    }
    public function criarEstoqueProduto($p,$qtd,$emp,$dep,$l,$os,$sp){
        $data = array(
            "idProduto"=> $p,
            "quantidade"=> $qtd,
            "idEmitente"=> $emp,
            "idDepartamento"=> $dep,
            "idStatusProduto"=> $sp,
            "idLocal"=> $l,
            "idOs"=> $os
        );
        $this->db->insert("almo_estoque_produtos",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_produtos");        
		}
    }
    public function criarEstoque($p,$m,$c,$v,$ps,$dimL,$dimC,$dimA,$e,$l,$qtd,$dep,$idOs = null){
        if($m == 0){
            $data = array(
                "idProduto" => $p,
                "metrica" => "0",
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idDepartamento" => $dep,
                "idLocal" => $l,
                "idOs" => $idOs
            );
        } else if($m == 1){
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "comprimento" => $c,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idDepartamento" => $dep,
                "idLocal" => $l,
                "idOs" => $idOs
            );
        } else if($m == 2){
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "volume" => $v,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idDepartamento" => $dep,
                "idLocal" => $l,
                "idOs" => $idOs
            );
        }  else if($m == 3){
            //$dim = explode('x',$dim);
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "peso" => $ps,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idDepartamento" => $dep,
                "idLocal" => $l,
                "idOs" => $idOs
            );
        } else if($m == 4){
            //$dim = explode('x',$dim);
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "dimensoesL" => $dimL,
                "dimensoesC" => $dimC,
                "dimensoesA" => $dimA,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idDepartamento" => $dep,
                "idLocal" => $l,
                "idOs" => $idOs
            );
            
        }
        $this->db->insert("almo_estoque",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque");        
		}
    }
    public function updateEstoque($id,$qtd){
        $data = array(
            "quantidade"=> $qtd
        );
        $this->db->where('idAlmoEstoque in ('.$id.')');
        $this->db->update("almo_estoque", $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
    }
    public function updateEstoqueProduto($id,$qtd){
        $data = array(
            "quantidade"=> $qtd
        );
        $this->db->where('idAlmoEstoqueProduto in ('.$id.')');
        $this->db->update("almo_estoque_produtos", $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
    }
    public function updateLocalEQuantidade($id,$qtd,$local){
        $data = array(
            //"quantidade"=> $qtd,
            "idLocal"=> $local
        );
        $this->db->where('idAlmoEstoque in ('.$id.')');
        $this->db->update("almo_estoque", $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
    }
    public function updateLocalEQuantidadeProduto($id,$qtd,$local){
        $data = array(
            //"quantidade"=> $qtd,
            "idLocal"=> $local
        );
        $this->db->where('idAlmoEstoqueProduto in ('.$id.')');
        $this->db->update("almo_estoque_produtos", $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
    }
    public function getEstoque($idEmpresa = "",$idDepartamento = ""){
        $where = "";
        if(!empty($idEmpresa) && !empty($idDepartamento)){
            $where = "where emitente.id = ".(int)$idEmpresa." and almo_estoque_departamento = ".(int)$idDepartamento."  and almo_estoque.quantidade > 0";
        }else if(!empty($idEmpresa) && empty($idDepartamento)){
            $where = "where emitente.id = ".(int)$idEmpresa."  and almo_estoque.quantidade > 0";
        }else if(empty($idEmpresa) && !empty($idDepartamento)){
            $where = "where almo_estoque_departamento = ".(int)$idDepartamento." and almo_estoque.quantidade > 0";
        }else{
            $where = "where almo_estoque.quantidade > 0";
        }
        $query = "SELECT almo_estoque.idAlmoEstoque,
            almo_estoque.idProduto,
            almo_estoque.idEmitente,
            almo_estoque.idLocal,
            almo_estoque.idOs,
            almo_estoque.quantidade,
            almo_estoque.metrica,
            almo_estoque.volume,
            almo_estoque.comprimento,
            almo_estoque.peso,
            almo_estoque.dimensoesL,
            almo_estoque.dimensoesC,
            almo_estoque.dimensoesA,
            insumos.idInsumos,
            insumos.descricaoInsumo,
            insumos.pn_insumo,
            emitente.id,
            emitente.nome,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque_departamento.descricaoDepartamento,
            almo_estoque.idDepartamento,
            almo_estoque_locais.local 
            FROM almo_estoque 
            INNER JOIN insumos on insumos.idInsumos = almo_estoque.idProduto
            INNER JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
            INNER JOIN emitente on emitente.id = almo_estoque.idEmitente
            LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal $where
            ORDER BY insumos.descricaoInsumo asc
            
            LIMIT 50
            ";
        return $this->db->query($query)->result();
    }
    public function getEstoqueProduto($idEmpresa = "",$idDepartamento = ""){
        $where = "";
        if(!empty($idEmpresa) && !empty($idDepartamento)){
            $where = "where emitente.id = ".(int)$idEmpresa." and almo_estoque_departamento = ".(int)$idDepartamento." and almo_estoque_produtos.quantidade > 0";
        }else if(!empty($idEmpresa) && empty($idDepartamento)){
            $where = "where emitente.id = ".(int)$idEmpresa."  and almo_estoque_produtos.quantidade > 0";
        }else if(empty($idEmpresa) && !empty($idDepartamento)){
            $where = "where almo_estoque_departamento = ".(int)$idDepartamento."  and almo_estoque_produtos.quantidade > 0";
        }else{
            $where = "where almo_estoque_produtos.quantidade > 0";
        }
        $query = "SELECT almo_estoque_produtos.idAlmoEstoqueProduto,
        almo_estoque_produtos.idProduto,
        almo_estoque_produtos.idEmitente,
        almo_estoque_produtos.idLocal,
        almo_estoque_produtos.idOs,
        almo_estoque_produtos.quantidade,
        status_produto.descricaoStatusProduto,
        produtos.idProdutos,
        produtos.descricao,
        produtos.pn,
        emitente.id,
        emitente.nome,
        almo_estoque_locais.idAlmoEstoqueLocais,
        almo_estoque_departamento.descricaoDepartamento,
        almo_estoque_produtos.idDepartamento,
        almo_estoque_locais.local 
        FROM almo_estoque_produtos 
        INNER JOIN produtos on produtos.idProdutos = almo_estoque_produtos.idProduto
        INNER JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento
        INNER JOIN status_produto on status_produto.idStatusProduto = almo_estoque_produtos.idStatusProduto
        INNER JOIN emitente on emitente.id = almo_estoque_produtos.idEmitente
       	LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_produtos.idLocal $where
        ORDER BY produtos.descricao asc
        
        LIMIT 50
        ";
        return $this->db->query($query)->result();
    }

    public function getEstoqueProduto2(){
        $query = "SELECT 
            almo_estoque_produtos.idProduto,
            sum(almo_estoque_produtos.quantidade) as quantidade,
            produtos.descricao,
            produtos.pn
            FROM almo_estoque_produtos 
            JOIN produtos on produtos.idProdutos = almo_estoque_produtos.idProduto
            WHERE quantidade is not null and quantidade != 0 
            and produtos.pn not like '%tec%'
            GROUP BY produtos.idProdutos,produtos.pn
            ORDER BY produtos.pn asc";
        return $this->db->query($query)->result();
    }
    public function getDepartamento(){
        $query = "SELECT *
        FROM almo_estoque_departamento 
        ORDER BY descricaoDepartamento asc";
        return $this->db->query($query)->result();
    }
    public function getEmitente(){
        $query = "SELECT *
        FROM emitente 
        ORDER BY id asc";
        return $this->db->query($query)->result();
    }
    public function getSaida($where  = ""){
        $query = "SELECT almo_estoque_saida.idAlmoEstoqueSaida, 
        almo_estoque_saida.idAlmoEstoque, 
        almo_estoque_saida.quantidade, 
        almo_estoque_saida.data_saida, 
        almo_estoque_saida.idEmpresaDestino, 
        almo_estoque_saida.idUserSis, 
        almo_estoque_saida.idSetor, 
        almo_estoque_saida.idOs, 
        almo_estoque_saida.idAlmoEstoqueUsuario, 
        almo_estoque_saida.obs, 
        almo_estoque_saida.assinatura, 
        insumos.idInsumos, 
        insumos.descricaoInsumo, 
        insumos.pn_insumo,
        almo_estoque.metrica, 
        almo_estoque.volume, 
        almo_estoque.comprimento, 
        almo_estoque.peso, 
        almo_estoque.dimensoesL,
        almo_estoque.dimensoesC,
        almo_estoque.dimensoesA,
        almo_estoque_locais.local, 
        almo_estoque_departamento.descricaoDepartamento,
        empresa.nome as destinoNome, 
        emitente.nome,
        usuarios.nome as username,
        almo_estoque_usuario.nome as getUsernome,
        setor_empresa.nomesetor
        FROM almo_estoque_saida 
        JOIN almo_estoque on almo_estoque_saida.idAlmoEstoque = almo_estoque.idAlmoEstoque
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
        JOIN insumos on almo_estoque.idProduto = insumos.idInsumos
        LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal
        JOIN emitente on almo_estoque.idEmitente = emitente.id
        JOIN emitente as empresa on almo_estoque_saida.idEmpresaDestino = empresa.id
        JOIN usuarios on usuarios.idUsuarios = almo_estoque_saida.idUserSis
        JOIN almo_estoque_usuario on almo_estoque_usuario.idAlmoEstoqueUsuario = almo_estoque_saida.idAlmoEstoqueUsuario
        JOIN setor_empresa on setor_empresa.id_setor = almo_estoque_saida.idSetor $where and almo_estoque_saida.ocultar = 0
        order by almo_estoque_saida.data_saida desc";
        return $this->db->query($query)->result();
    }
    public function getSaida2($where  = ""){
        $query = "SELECT almo_estoque_saida.idAlmoEstoqueSaida, 
        almo_estoque_saida.idAlmoEstoque, 
        almo_estoque_saida.quantidade, 
        almo_estoque_saida.data_saida, 
        almo_estoque_saida.idEmpresaDestino, 
        almo_estoque_saida.idUserSis, 
        almo_estoque_saida.idSetor, 
        almo_estoque_saida.idOs, 
        almo_estoque_saida.idAlmoEstoqueUsuario, 
        almo_estoque_saida.obs, 
        almo_estoque_saida.assinatura, 
        insumos.idInsumos, 
        insumos.descricaoInsumo, 
        insumos.pn_insumo,
        almo_estoque.metrica, 
        almo_estoque.volume, 
        almo_estoque.comprimento, 
        almo_estoque.peso, 
        almo_estoque.dimensoesL,
        almo_estoque.dimensoesC,
        almo_estoque.dimensoesA,
        almo_estoque_locais.local, 
        almo_estoque_departamento.descricaoDepartamento,
        empresa.nome as destinoNome, 
        emitente.nome,
        usuarios.nome as username,
        almo_estoque_usuario.nome as getUsernome,
        setor_empresa.nomesetor,
        (SELECT valorUnitario FROM `almo_estoque_entrada` WHERE almo_estoque_entrada.valorUnitario != 0 and almo_estoque_entrada.idProduto = almo_estoque.idProduto and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento LIMIT 1) as valorUnit
        FROM almo_estoque_saida 
        JOIN almo_estoque on almo_estoque_saida.idAlmoEstoque = almo_estoque.idAlmoEstoque
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
        JOIN insumos on almo_estoque.idProduto = insumos.idInsumos
        LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal
        JOIN emitente on almo_estoque.idEmitente = emitente.id
        JOIN emitente as empresa on almo_estoque_saida.idEmpresaDestino = empresa.id
        JOIN usuarios on usuarios.idUsuarios = almo_estoque_saida.idUserSis
        JOIN almo_estoque_usuario on almo_estoque_usuario.idAlmoEstoqueUsuario = almo_estoque_saida.idAlmoEstoqueUsuario
        JOIN setor_empresa on setor_empresa.id_setor = almo_estoque_saida.idSetor $where and almo_estoque_saida.ocultar = 0
        order by almo_estoque_saida.data_saida desc";
        return $this->db->query($query)->result();
    }
    public function getEntrada($where = ""){
        $query = "SELECT almo_estoque_entrada.idAlmoEstoqueEnt, 
        almo_estoque_entrada.idProduto, 
        almo_estoque_entrada.metrica, 
        almo_estoque_entrada.quantidade,
        almo_estoque_entrada.comprimento, 
        almo_estoque_entrada.volume,
        almo_estoque_entrada.peso, 
        almo_estoque_entrada.dimensoesL,
        almo_estoque_entrada.dimensoesC,
        almo_estoque_entrada.dimensoesA,
        almo_estoque_entrada.data_entrada, 
        almo_estoque_entrada.idOs, 
        almo_estoque_entrada.nf, 
        almo_estoque_entrada.idUsuario,
        almo_estoque_entrada.valorUnitario,
        insumos.descricaoInsumo, 
        insumos.pn_insumo,
        almo_estoque_locais.local, 
        almo_estoque_departamento.descricaoDepartamento,
        emitente.nome as nomeEmpresa, 
        usuarios.nome as username
        FROM `almo_estoque_entrada` 
        JOIN insumos on insumos.idInsumos = almo_estoque_entrada.idProduto
        LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_entrada.idLocal
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_entrada.idDepartamento
        JOIN emitente on emitente.id = almo_estoque_entrada.idEmitente
        LEFT JOIN os on os.idOs = almo_estoque_entrada.idOs
        JOIN usuarios on usuarios.idUsuarios = almo_estoque_entrada.idUsuario $where and almo_estoque_entrada.ocultar = 0
        order by almo_estoque_entrada.data_entrada desc";
        return $this->db->query($query)->result();
    }
    public function getEntradaProduto($where = ""){
        $query = "SELECT almo_estoque_p_entrada.idAlmoEstoquePEntrada, 
        almo_estoque_p_entrada.idProduto, 
        almo_estoque_p_entrada.quantidade,
        almo_estoque_p_entrada.data_entrada,
        almo_estoque_p_entrada.idStatusProduto,
        almo_estoque_p_entrada.idOs, 
        almo_estoque_p_entrada.nf, 
        almo_estoque_p_entrada.idUsuario,
        status_produto.descricaoStatusProduto,
        produtos.descricao, 
        produtos.pn,
        almo_estoque_locais.local, 
        almo_estoque_departamento.descricaoDepartamento,
        emitente.nome as nomeEmpresa, 
        usuarios.nome as username
        FROM `almo_estoque_p_entrada` 
        JOIN produtos on produtos.idProdutos = almo_estoque_p_entrada.idProduto
        LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_p_entrada.idLocal
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_p_entrada.idDepartamento
        JOIN emitente on emitente.id = almo_estoque_p_entrada.idEmitente
        JOIN usuarios on usuarios.idUsuarios = almo_estoque_p_entrada.idUsuario 
        LEFT JOIN os on os.idOs = almo_estoque_p_entrada.idOs
        JOIN status_produto on status_produto.idStatusProduto = almo_estoque_p_entrada.idStatusProduto $where and almo_estoque_p_entrada.ocultar = 0
        order by almo_estoque_p_entrada.data_entrada desc";
        return $this->db->query($query)->result();
    }
    public function getSaidaProduto($where = ""){
        $query = "SELECT almo_estoque_p_saida.idAlmoEstoquePSaida, 
        almo_estoque_p_saida.idAlmoEstoqueProdutos, 
        almo_estoque_p_saida.quantidade, 
        almo_estoque_p_saida.data_saida, 
        almo_estoque_p_saida.idEmpresaDestino, 
        almo_estoque_p_saida.idUserSis, 
        almo_estoque_p_saida.idSetor, 
        almo_estoque_p_saida.idOs, 
        almo_estoque_p_saida.idAlmoEstoqueUsuario,
        almo_estoque_p_saida.obs,  
        almo_estoque_p_saida.assinatura, 
        produtos.idProdutos, 
        produtos.descricao, 
        produtos.pn, 
        almo_estoque_locais.local, 
        almo_estoque_departamento.descricaoDepartamento,
        empresa.nome as destinoNome, 
        emitente.nome,
        usuarios.nome as username,
        almo_estoque_usuario.nome as getUsernome,
        setor_empresa.nomesetor
        FROM almo_estoque_p_saida 
        JOIN almo_estoque_produtos on almo_estoque_p_saida.idAlmoEstoqueProdutos = almo_estoque_produtos.idAlmoEstoqueProduto
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento
        JOIN produtos on almo_estoque_produtos.idProduto = produtos.idProdutos
        LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_produtos.idLocal
        JOIN emitente on almo_estoque_produtos.idEmitente = emitente.id
        JOIN emitente as empresa on almo_estoque_p_saida.idEmpresaDestino = empresa.id
        JOIN usuarios on usuarios.idUsuarios = almo_estoque_p_saida.idUserSis
        JOIN almo_estoque_usuario on almo_estoque_usuario.idAlmoEstoqueUsuario = almo_estoque_p_saida.idAlmoEstoqueUsuario
        JOIN setor_empresa on setor_empresa.id_setor = almo_estoque_p_saida.idSetor $where and almo_estoque_p_saida.ocultar = 0
        order by almo_estoque_p_saida.data_saida desc";
        return $this->db->query($query)->result();
    }
	
	
    public function getEstatisticasConsultasPorListaIdsAlmo($idsProdutos) {
        if (empty($idsProdutos)) {
            return [];
        }

        // Garante que os IDs estejam formatados para uso no IN clause (sem aspas invertidas extras)
        // O $this->db->escape() adiciona aspas simples para strings, mas para números, basta o intval
        $idsProdutosEscapados = array_map(function($id) {
            return (int) $id; // Garante que é um número inteiro, evitando problemas de aspas
        }, $idsProdutos);
        $idsProdutosIn = implode(',', $idsProdutosEscapados);


        // Usando $this->db->query() para ter controle total sobre a sintaxe SQL
        $sql = "
        SELECT
            t1.idProduto,
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
                idProduto IN (" . $idsProdutosIn . ")
            GROUP BY
                idProduto,
                data_consulta
        ) AS t1
        LEFT JOIN (
            SELECT
                idProduto,
                GROUP_CONCAT(DISTINCT idLocal) AS locais_com_estoque_raw
            FROM
                consulta_estoque_log
            WHERE
                idProduto IN (" . $idsProdutosIn . ")
                AND quantidade_estoque >= 1
            GROUP BY
                idProduto
        ) AS t2 ON t1.idProduto = t2.idProduto
        GROUP BY t1.idProduto
        ";

        $query = $this->db->query($sql);

        $resultado = [];
        foreach ($query->result() as $row) {
            // Se houver locais com estoque, converte a string para array para facilitar o uso na view
            $row->locais_com_estoque = !empty($row->locais_com_estoque_raw) ? explode(',', $row->locais_com_estoque_raw) : [];
            unset($row->locais_com_estoque_raw); // Remove a coluna raw para limpeza

            $resultado[$row->idProduto] = $row;
        }

        return $resultado;
    } //2 vezes voltar controlZ
	
	
	
	
	
    public function getEstoqueFilter($where){        
        if(empty($where)){
            $query = "
            SELECT almo_estoque.idAlmoEstoque,
            almo_estoque.idProduto,
            almo_estoque.idEmitente,
            almo_estoque.idLocal,
            almo_estoque.idOs,
            almo_estoque.quantidade,
            almo_estoque.metrica,
            almo_estoque.volume,
            almo_estoque.comprimento,
            almo_estoque.peso,
            almo_estoque.dimensoesL,
            almo_estoque.dimensoesC,
            almo_estoque.dimensoesA,
            insumos.idInsumos,
            insumos.descricaoInsumo,
            insumos.pn_insumo,
            emitente.id,
            emitente.nome,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque_departamento.descricaoDepartamento,
            almo_estoque.idDepartamento,
            almo_estoque_locais.local 
            FROM almo_estoque 
            INNER JOIN insumos on insumos.idInsumos = almo_estoque.idProduto
            INNER JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
            INNER JOIN emitente on emitente.id = almo_estoque.idEmitente
            LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal
            LEFT JOIN os on os.idOs = almo_estoque.idOs
            ORDER BY insumos.descricaoInsumo asc";
        }else{
            $query = "
            SELECT almo_estoque.idAlmoEstoque,
            almo_estoque.idProduto,
            almo_estoque.idEmitente,
            almo_estoque.idLocal,
            almo_estoque.idOs,
            almo_estoque.quantidade,
            almo_estoque.metrica,
            almo_estoque.volume,
            almo_estoque.comprimento,
            almo_estoque.peso,
            almo_estoque.dimensoesL,
            almo_estoque.dimensoesC,
            almo_estoque.dimensoesA,
            insumos.idInsumos,
            insumos.descricaoInsumo,
            insumos.pn_insumo,
            emitente.id,
            emitente.nome,
            almo_estoque_departamento.descricaoDepartamento,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque.idDepartamento,
            almo_estoque_locais.local 
            FROM almo_estoque 
            INNER JOIN insumos on insumos.idInsumos = almo_estoque.idProduto
            INNER JOIN emitente on emitente.id = almo_estoque.idEmitente
            INNER JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
            LEFT JOIN os on os.idOs = almo_estoque.idOs
            LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal WHERE $where
            ORDER BY insumos.descricaoInsumo asc";
        }              
        return $this->db->query($query)->result();
    }
    public function getEstoqueFilterProdutos($where){        
        if(empty($where)){
            $query = "
            SELECT almo_estoque_produtos.idAlmoEstoqueProduto,
            almo_estoque_produtos.idProduto,
            almo_estoque_produtos.idEmitente,
            almo_estoque_produtos.idLocal,
            almo_estoque_produtos.idOs,
            almo_estoque_produtos.quantidade,
            status_produto.descricaoStatusProduto,
            produtos.idProdutos,
            produtos.descricao,
            produtos.pn,
            emitente.id,
            emitente.nome,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque_departamento.descricaoDepartamento,
            almo_estoque_produtos.idDepartamento,
            almo_estoque_locais.local 
            FROM almo_estoque_produtos 
            INNER JOIN produtos on produtos.idProdutos = almo_estoque_produtos.idProduto
            INNER JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento
            INNER JOIN emitente on emitente.id = almo_estoque_produtos.idEmitente
            INNER JOIN status_produto on status_produto.idStatusProduto = almo_estoque_produtos.idStatusProduto
            LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_produtos.idLocal
            LEFT JOIN os on os.idOs = almo_estoque_produtos.idOs
            ORDER BY produtos.descricao asc";
        }else{
            $query = "
            SELECT almo_estoque_produtos.idAlmoEstoqueProduto,
            almo_estoque_produtos.idProduto,
            almo_estoque_produtos.idEmitente,
            almo_estoque_produtos.idLocal,
            almo_estoque_produtos.quantidade,
            almo_estoque_produtos.idOs,
            status_produto.descricaoStatusProduto,
            produtos.idProdutos,
            produtos.descricao,
            produtos.pn,
            emitente.id,
            emitente.nome,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque_departamento.descricaoDepartamento,
            almo_estoque_produtos.idDepartamento,
            almo_estoque_locais.local 
            FROM almo_estoque_produtos 
            INNER JOIN produtos on produtos.idProdutos = almo_estoque_produtos.idProduto
            INNER JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento
            INNER JOIN emitente on emitente.id = almo_estoque_produtos.idEmitente
            INNER JOIN status_produto on status_produto.idStatusProduto = almo_estoque_produtos.idStatusProduto
            LEFT JOIN os on os.idOs = almo_estoque_produtos.idOs
            LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_produtos.idLocal WHERE $where
            ORDER BY produtos.descricao asc";
        }              
        return $this->db->query($query)->result();
    }
    public function cadastrarSaidas($est,$qtd,$emp,$set,$userSis,$user,$idOs,$obs,$signature = null){
        if(empty($idOs)){
            $idOs = null;
        }
        $data = array(
            "idAlmoEstoque" => $est,
            "idEmpresaDestino" => $emp,
            "idSetor" => $set,
            "idUserSis" => $userSis,
            "idOs" => $idOs,
            "idAlmoEstoqueUsuario" => $user,
            "quantidade" => $qtd,
            "obs" => $obs,
            "assinatura" => $signature,
            "data_saida" => date('Y-m-d H:i:s')
        );
       
        $this->db->insert("almo_estoque_saida",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_saida");        
		}
    }

    public function cadastrarSaidasProdutos($est,$qtd,$emp,$set,$userSis,$user,$idOs,$obs,$signature = null){
        if(empty($idOs)){
            $idOs = null;
        }
        $data = array(
            "idAlmoEstoqueProdutos" => $est,
            "idEmpresaDestino" => $emp,
            "idSetor" => $set,
            "idUserSis" => $userSis,
            "idOs" => $idOs,
            "idAlmoEstoqueUsuario" => $user,
            "quantidade" => $qtd,
            "obs" => $obs,
            "assinatura" => $signature,
            "data_saida" => date('Y-m-d H:i:s')
        );
       
        $this->db->insert("almo_estoque_p_saida",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_p_saida");        
		}
    }
    public function getItemEstoque($id){
        $query = "SELECT * FROM almo_estoque WHERE idAlmoEstoque = ?";
        return $this->db->query($query, [(int)$id])->result();
    }
    public function cadastrarLocal($empresa, $local, $departamento){
        $data = array(
            "idEmitente" => $empresa,
            "idDepartamento" => $departamento,
            "local" => strtoupper($local)
        );
        $this->db->insert("almo_estoque_locais",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_locais");        
		}
    }
    public function cadastrarUsuario($empresa, $setor,$nome,$cpf){
        if(empty($cpf)){
            $data = array(
                "nome"=>strtoupper($nome),
                "idEmitente" => $empresa,
                "idSetor" => $setor
            );
        }else{
            $data = array(
                "nome"=>strtoupper($nome),
                "cpf"=>$cpf,
                "idEmitente" => $empresa,
                "idSetor" => $setor
            ); 
        }
        
        
        $this->db->insert("almo_estoque_usuario",$data);
        if ($this->db->affected_rows() == '1'){
            return $this->db->insert_id("almo_estoque_usuario");        
		}
    }
    public function cadastrarInsumos($descricao,$estoqueMinimo,$subcat,$pn ){
        if(empty($pn)){
            $pn = null;
        }
        $data = array(
            "descricaoInsumo"=>strtoupper($descricao),
            "estoqueminimo"=>$estoqueMinimo,
            "pn_insumo" => $pn,
            "idSubcategoria" => $subcat
        ); 
        
        $this->db->insert("insumos",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("insumos");        
		}
    }
    public function getLocais(){
        $query = "SELECT almo_estoque_locais.idAlmoEstoqueLocais,
        almo_estoque_locais.idEmitente,
        almo_estoque_locais.local,
        emitente.nome,
        almo_estoque_departamento.descricaoDepartamento
        FROM `almo_estoque_locais` 
        JOIN emitente on emitente.id = almo_estoque_locais.idEmitente
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_locais.idDepartamento
        ORDER BY almo_estoque_locais.local asc";
        return $this->db->query($query)->result();
    }
    public function getLocal($idEmitente, $idDepartamento,$local){
        $query = "SELECT almo_estoque_locais.idAlmoEstoqueLocais,
        almo_estoque_locais.idEmitente,
        almo_estoque_locais.local,
        emitente.nome,
        almo_estoque_departamento.descricaoDepartamento
        FROM `almo_estoque_locais` 
        JOIN emitente on emitente.id = almo_estoque_locais.idEmitente
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_locais.idDepartamento
        WHERE almo_estoque_departamento.idAlmoEstoqueDep = ? and emitente.id = ? and almo_estoque_locais.local = ?";
        return $this->db->query($query, [(int)$idDepartamento, (int)$idEmitente, $this->db->escape_str($local)])->result();
    }
    public function getLocal1($idEmitente, $idDepartamento,$local){
        $query = "SELECT almo_estoque_locais.idAlmoEstoqueLocais,
        almo_estoque_locais.idEmitente,
        almo_estoque_locais.local,
        emitente.nome,
        almo_estoque_departamento.descricaoDepartamento
        FROM `almo_estoque_locais`
        JOIN emitente on emitente.id = almo_estoque_locais.idEmitente
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_locais.idDepartamento
        WHERE almo_estoque_departamento.idAlmoEstoqueDep = ? and emitente.id = ? and almo_estoque_locais.local = ? LIMIT 1";
        return $this->db->query($query, [(int)$idDepartamento, (int)$idEmitente, $this->db->escape_str($local)])->row();
    }
    public function getUsuario(){
        $query = "SELECT almo_estoque_usuario.idAlmoEstoqueUsuario,
        almo_estoque_usuario.nome,
        almo_estoque_usuario.cpf,
        setor_empresa.nomesetor,
        emitente.nome as nomeempresa
        FROM `almo_estoque_usuario` 
        JOIN emitente on emitente.id = almo_estoque_usuario.idEmitente
        JOIN setor_empresa on setor_empresa.id_setor = almo_estoque_usuario.idSetor
        ORDER BY almo_estoque_usuario.nome asc";
        
        return $this->db->query($query)->result();
    }
    public function getEstoqueFromLocal($idLocal){
        $query = "SELECT almo_estoque.idAlmoEstoque, almo_estoque.quantidade
        FROM `almo_estoque_locais`
        JOIN almo_estoque on almo_estoque.idLocal = almo_estoque_locais.idAlmoEstoqueLocais
        WHERE almo_estoque_locais.idAlmoEstoqueLocais = ?";
        return $this->db->query($query, [(int)$idLocal])->result();
    }
    public function getRelatorioInicial(){
        $query = "SELECT insumos.idInsumos, 
        insumos.descricaoInsumo, 
        SUM(almo_estoque.quantidade) as quantidade_total, 
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto and almo_estoque_entrada.idUsuario != 51) as quantidade_entrada, 
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto and almo_estoque_saida.idUserSis != 51) as quantidade_saida,
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto and almo_estoque_entrada.idUsuario != 51)*(SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto and almo_estoque_entrada.idUsuario != 51) as valor_total_entrada,
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto and almo_estoque_saida.idUserSis != 51)*(SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto) as valor_total_saida,
        (SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto) as valor_unit_medio,
        SUM(almo_estoque.quantidade) * (SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            join insumos as insumos2 on insumos2.idInsumos = almo_estoque_entrada.idProduto 
            WHERE insumos.idInsumos = insumos2.idInsumos) as valor_total
        FROM `almo_estoque` join insumos on insumos.idInsumos = almo_estoque.idProduto 
        join emitente on emitente.id = almo_estoque.idEmitente 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento 
        group by insumos.idInsumos
        order by insumos.descricaoInsumo asc
        
        LIMIT 50
        ";
        return $this->db->query($query)->result();
    }
    public function getRelatorioInicialProdutos(){
        $query = "SELECT produtos.idProdutos, 
        produtos.descricao, 
        SUM(almo_estoque_produtos.quantidade) as quantidade_total, 
        (select sum(almo_estoque_p_entrada.quantidade)
             from almo_estoque_p_entrada 
             where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto) as quantidade_entrada, 
        (select SUM(almo_estoque_p_saida.quantidade)
             from almo_estoque_p_saida 
             join almo_estoque_produtos as almo_estoque2_produtos on almo_estoque2_produtos.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
            where almo_estoque2_produtos.idProduto = almo_estoque_produtos.idProduto) as quantidade_saida,
        (select sum(almo_estoque_p_entrada.quantidade)
             from almo_estoque_p_entrada 
             where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto)*(SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
            from almo_estoque_p_entrada 
            WHERE produtos.idProdutos = almo_estoque_p_entrada.idProduto) as valor_total_entrada,
        (select SUM(almo_estoque_p_saida.quantidade)
             from almo_estoque_p_saida 
             join almo_estoque_produtos as almo_estoque2_produtos on almo_estoque2_produtos.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
            where almo_estoque2_produtos.idProduto = almo_estoque_produtos.idProduto)*(SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
            from almo_estoque_p_entrada 
            WHERE produtos.idProdutos = almo_estoque_p_entrada.idProduto) as valor_total_saida,
        (SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
            from almo_estoque_p_entrada 
            WHERE produtos.idProdutos = almo_estoque_p_entrada.idProduto) as valor_unit_medio,
        SUM(almo_estoque_produtos.quantidade) * (SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
            from almo_estoque_p_entrada 
            join produtos as produtos2 on produtos2.idProdutos = almo_estoque_p_entrada.idProduto 
            WHERE produtos.idProdutos = produtos2.idProdutos) as valor_total
        FROM `almo_estoque_produtos` join produtos on produtos.idProdutos = almo_estoque_produtos.idProduto 
        join emitente on emitente.id = almo_estoque_produtos.idEmitente 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento 
        group by produtos.idProdutos
        order by produtos.descricao asc
        
        LIMIT 50
        ";
        return $this->db->query($query)->result();
    }
public function getRelatorioInicial2($where = ''){
        // CORREÇÃO: Adicionando a palavra WHERE dinamicamente se houver filtro
        $clausula_where = !empty($where) ? " WHERE " . $where : "";
        
        $query = "SELECT insumos.idInsumos, 
        insumos.descricaoInsumo, emitente.nome, insumos.pn_insumo,almo_estoque_departamento.descricaoDepartamento,
        SUM(almo_estoque.quantidade) as quantidade_total, 
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento) as quantidade_entrada, 
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto  and almo_estoque2.idEmitente = almo_estoque.idEmitente and almo_estoque2.idDepartamento = almo_estoque.idDepartamento) as 	quantidade_saida,
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto  and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento)*(SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto  and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento) as valor_total_entrada,
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto and almo_estoque2.idEmitente = almo_estoque.idEmitente and almo_estoque2.idDepartamento = almo_estoque.idDepartamento)*(SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento) as valor_total_saida,
        (SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto  and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento) as valor_unit_medio,
        SUM(almo_estoque.quantidade) * (SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            join insumos as insumos2 on insumos2.idInsumos = almo_estoque_entrada.idProduto 
            WHERE insumos.idInsumos = insumos2.idInsumos  and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento) as valor_total
        FROM `almo_estoque` join insumos on insumos.idInsumos = almo_estoque.idProduto 
        join emitente on emitente.id = almo_estoque.idEmitente 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento 
        $clausula_where 
        group by insumos.idInsumos 
        order by insumos.descricaoInsumo asc";
        return $this->db->query($query)->result();
    }
public function getRelatorioInicial2Produtos($where = ''){
        // CORREÇÃO: Adicionando a palavra WHERE
        $clausula_where = !empty($where) ? " WHERE " . $where : "";

        $query = "SELECT produtos.idProdutos, 
            produtos.descricao, produtos.pn, emitente.nome,almo_estoque_departamento.descricaoDepartamento,
            SUM(almo_estoque_produtos.quantidade) as quantidade_total, 
            (select sum(almo_estoque_p_entrada.quantidade)
                from almo_estoque_p_entrada 
                where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto and almo_estoque_p_entrada.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque_p_entrada.idDepartamento = almo_estoque_produtos.idDepartamento) as quantidade_entrada, 
            (select SUM(almo_estoque_p_saida.quantidade)
                from almo_estoque_p_saida 
                join almo_estoque_produtos as almo_estoque2_produtos on almo_estoque2_produtos.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
                where almo_estoque2_produtos.idProduto = almo_estoque_produtos.idProduto and almo_estoque2_produtos.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque2_produtos.idDepartamento = almo_estoque_produtos.idDepartamento ) as 	quantidade_saida,
            (select sum(almo_estoque_p_entrada.quantidade)
                from almo_estoque_p_entrada 
                where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto and almo_estoque_p_entrada.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque_p_entrada.idDepartamento = almo_estoque_produtos.idDepartamento)*(SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
                from almo_estoque_p_entrada 
                WHERE produtos.idProdutos = almo_estoque_p_entrada.idProduto and almo_estoque_p_entrada.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque_p_entrada.idDepartamento = almo_estoque_produtos.idDepartamento) as valor_total_entrada,
            (select SUM(almo_estoque_p_saida.quantidade)
                from almo_estoque_p_saida 
                join almo_estoque_produtos as almo_estoque2_produtos on almo_estoque2_produtos.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
                where almo_estoque2_produtos.idProduto = almo_estoque_produtos.idProduto and almo_estoque2_produtos.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque2_produtos.idDepartamento = almo_estoque_produtos.idDepartamento)*(SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
                from almo_estoque_p_entrada 
                WHERE produtos.idProdutos = almo_estoque_p_entrada.idProduto and almo_estoque_p_entrada.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque_p_entrada.idDepartamento = almo_estoque_produtos.idDepartamento) as valor_total_saida,
            (SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
                from almo_estoque_p_entrada 
                WHERE produtos.idProdutos = almo_estoque_p_entrada.idProduto and almo_estoque_p_entrada.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque_p_entrada.idDepartamento = almo_estoque_produtos.idDepartamento) as valor_unit_medio,
            SUM(almo_estoque_produtos.quantidade) * (SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
                from almo_estoque_p_entrada 
                join produtos as produtos2 on produtos2.idProdutos = almo_estoque_p_entrada.idProduto 
                WHERE produtos.idProdutos = produtos2.idProdutos and almo_estoque_p_entrada.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque_p_entrada.idDepartamento = almo_estoque_produtos.idDepartamento) as valor_total
            FROM `almo_estoque_produtos` join produtos on produtos.idProdutos = almo_estoque_produtos.idProduto 
            join emitente on emitente.id = almo_estoque_produtos.idEmitente 
            join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento 
            $clausula_where 
            group by produtos.idProdutos 
            order by produtos.descricao asc";
        return $this->db->query($query)->result();
    }
    
    public function getRelatorioPorInsumoEmpresa($idInsumos){
        $query = "SELECT insumos.idInsumos, emitente.nome, 
        insumos.descricaoInsumo, 
        SUM(almo_estoque.quantidade) as quantidade_total, 
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto and almo_estoque_entrada.idEmitente = emitente.id) as quantidade_entrada, 
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto and almo_estoque2.idEmitente = emitente.id) as quantidade_saida,
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto and almo_estoque_entrada.idEmitente = emitente.id)*(SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto and almo_estoque_entrada.idEmitente = emitente.id) as valor_total_entrada,
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto and almo_estoque2.idEmitente = emitente.id)*(SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto and almo_estoque_entrada.idEmitente = emitente.id) as valor_total_saida,
        (SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto and almo_estoque_entrada.idEmitente = emitente.id) as valor_unit_medio,
        SUM(almo_estoque.quantidade) * (SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            join insumos as insumos2 on insumos2.idInsumos = almo_estoque_entrada.idProduto 
            WHERE insumos.idInsumos = insumos2.idInsumos and almo_estoque_entrada.idEmitente = emitente.id) as valor_total
        FROM `almo_estoque` join insumos on insumos.idInsumos = almo_estoque.idProduto 
        join emitente on emitente.id = almo_estoque.idEmitente 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
        where insumos.idInsumos = ?
        group by insumos.idInsumos, emitente.id";
        return $this->db->query($query, [(int)$idInsumos])->result();
    }
    public function getRelatorioPorProdutoEmpresa($idProdutos){
        $query = "SELECT produtos.idProdutos as idInsumos, emitente.nome, 
        produtos.descricao as descricaoInsumo,
        SUM(almo_estoque_produtos.quantidade) as quantidade_total, 
        (select sum(almo_estoque_p_entrada.quantidade)
             from almo_estoque_p_entrada 
             where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto and almo_estoque_p_entrada.idEmitente = emitente.id) as quantidade_entrada, 
        (select SUM(almo_estoque_p_saida.quantidade)
             from almo_estoque_p_saida 
             join almo_estoque_produtos as almo_estoque2_produtos on almo_estoque2_produtos.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
            where almo_estoque2_produtos.idProduto = almo_estoque_produtos.idProduto and almo_estoque2_produtos.idEmitente = emitente.id) as 	quantidade_saida,
        (select sum(almo_estoque_p_entrada.quantidade)
             from almo_estoque_p_entrada 
             where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto and almo_estoque_p_entrada.idEmitente = emitente.id)*(SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
            from almo_estoque_p_entrada 
            WHERE produtos.idProdutos = almo_estoque_p_entrada.idProduto and almo_estoque_p_entrada.idEmitente = emitente.id) as valor_total_entrada,
        (select SUM(almo_estoque_p_saida.quantidade)
             from almo_estoque_p_saida 
             join almo_estoque_produtos as almo_estoque2_produtos on almo_estoque2_produtos.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
            where almo_estoque2_produtos.idProduto = almo_estoque_produtos.idProduto and almo_estoque2_produtos.idEmitente = emitente.id)*(SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
            from almo_estoque_p_entrada 
            WHERE produtos.idProdutos = almo_estoque_p_entrada.idProduto and almo_estoque_p_entrada.idEmitente = emitente.id) as valor_total_saida,
        (SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
            from almo_estoque_p_entrada 
            WHERE produtos.idProdutos = almo_estoque_p_entrada.idProduto and almo_estoque_p_entrada.idEmitente = emitente.id) as valor_unit_medio,
        SUM(almo_estoque_produtos.quantidade) * (SELECT SUM(almo_estoque_p_entrada.valorUnitario*almo_estoque_p_entrada.quantidade)/SUM(almo_estoque_p_entrada.quantidade)
            from almo_estoque_p_entrada 
            join produtos as produtos2 on produtos2.idProdutos = almo_estoque_p_entrada.idProduto 
            WHERE produtos.idProdutos = produtos2.idProdutos and almo_estoque_p_entrada.idEmitente = emitente.id) as valor_total
        FROM `almo_estoque_produtos` join produtos on produtos.idProdutos = almo_estoque_produtos.idProduto 
        join emitente on emitente.id = almo_estoque_produtos.idEmitente 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento        
        where produtos.idProdutos = ?
        group by produtos.idProdutos, emitente.id";
        return $this->db->query($query, [(int)$idProdutos])->result();
    }
    public function getRelatorioEntradaPorInsumo($idInsumos){
        $query = "SELECT insumos.descricaoInsumo, emitente.nome, sum(almo_estoque_entrada.quantidade) as quantidade_total, sum(almo_estoque_entrada.quantidade*almo_estoque_entrada.valorUnitario) as valor_total 
        FROM `almo_estoque_entrada` 
        JOIN emitente on emitente.id = almo_estoque_entrada.idEmitente
        JOIN insumos on insumos.idInsumos = almo_estoque_entrada.idProduto
        where insumos.idInsumos = ?
        GROUP BY almo_estoque_entrada.idProduto, almo_estoque_entrada.idEmitente";
        return $this->db->query($query, [(int)$idInsumos])->result();
    }
    public function getRelatorioSaidaPorInsumo($idInsumos){
        $query = "SELECT insumos.descricaoInsumo, emitente.nome, sum(almo_estoque_saida.quantidade) as quantidade_total, 
        (SELECT  SUM(almo_estoque_entrada.quantidade*almo_estoque_entrada.valorUnitario)/sum(almo_estoque_entrada.quantidade) 
        from almo_estoque_entrada 
        where almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idProduto = almo_estoque.idProduto) as valor_unit_medio, 
        sum(almo_estoque_saida.quantidade*(SELECT  SUM(almo_estoque_entrada.quantidade*almo_estoque_entrada.valorUnitario)/sum(almo_estoque_entrada.quantidade) 
        from almo_estoque_entrada 
        where almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idProduto = almo_estoque.idProduto)) as valor_total
                FROM `almo_estoque_saida` 
                JOIN almo_estoque on almo_estoque.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
                JOIN emitente on emitente.id = almo_estoque.idEmitente
                JOIN insumos on insumos.idInsumos = almo_estoque.idProduto
                where insumos.idInsumos = ?
                GROUP BY insumos.idInsumos, almo_estoque.idEmitente";
        return $this->db->query($query, [(int)$idInsumos])->result();
    }
    public function getDepartamentoUsuario($idUser){
        $query = "SELECT almo_estoque_departamento.idAlmoEstoqueDep,almo_estoque_departamento.descricaoDepartamento,almo_estoque_departamento.tipo ,usuario_departamento.idDepartamento
        FROM `usuario_departamento` 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = usuario_departamento.idDepartamento 
        where usuario_departamento.idUsuario = ?";
        return $this->db->query($query, [(int)$idUser])->result();
    }
    public function getEmpresaUsuario($idUser){
        // SEGURANÇA: parâmetro via bind evita SQL Injection
        $query = "SELECT emitente.id, emitente.nome FROM `usuario_empresa` JOIN emitente ON emitente.id = usuario_empresa.idEmpresa WHERE usuario_empresa.idUsuario = ?";
        return $this->db->query($query, [(int)$idUser])->result();
    }
    public function deleteLocal($idLocal){
        // SEGURANÇA: cast para inteiro evita SQL Injection
        $this->db->where('idAlmoEstoqueLocais', (int)$idLocal);
        return $this->db->delete('almo_estoque_locais');
    }
    public function cadastrarCategoria($desc){        
        $data = array(
            "descricaoCategoria" => strtoupper($desc)
        );
       
        $this->db->insert("categoriaInsumos",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("categoriaInsumos");        
		}
    }
    public function cadastrarSubcategoria($desc,$idCat){        
        $data = array(
            "descricaoSubcategoria" => strtoupper($desc),
            "idCategoria" => $idCat
        );
       
        $this->db->insert("subcategoriaInsumo",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("subcategoriaInsumo");        
		}
    }
    public function getStatusProduto(){
        $this->db->select();
        $this->db->from("status_produto");
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
    public function getItemEstoqueProdutos($id){
        $query = "SELECT * FROM almo_estoque_produtos WHERE idAlmoEstoqueProduto = ?";
        return $this->db->query($query, [(int)$id])->result();
    }
    public function getPermCompra($idInsumo){
        $query = "SELECT * FROM almo_permissao_suprimentos WHERE idInsumo = ?";
        return $this->db->query($query, [(int)$idInsumo])->result();
    }
    public function addPermCompra($data){
        $this->db->insert("almo_permissao_suprimentos",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_permissao_suprimentos");        
		}
    }
    public function getAgArmaz($data){
        $query = "SELECT * FROM almo_aguardando_armazenamento WHERE idDistribuirOs = ?";
        return $this->db->query($query, [(int)$data])->result();
    }
    public function insertAgArmaz($data){
        $this->db->insert("almo_aguardando_armazenamento",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_aguardando_armazenamento");        
		}
    }
    public function getAgArmazInicial(){
        $query = "SELECT insumos.descricaoInsumo, emitente.nome, almo_aguardando_armazenamento.*, status_aguardando_armazenamento.descricaoAgArmaz,
        almo_estoque_departamento.idAlmoEstoqueDep, almo_estoque_departamento.descricaoDepartamento, almo_estoque_locais.idAlmoEstoqueLocais, almo_estoque_locais.local, 
                (select almo_estoque.idLocal from almo_estoque join almo_estoque_departamento as almo_estoque_departamento2 on 
                almo_estoque_departamento2.idAlmoEstoqueDep = almo_estoque.idDepartamento join almo_estoque_locais as almo_estoque_locais2 on 
                almo_estoque_locais2.idAlmoEstoqueLocais = almo_estoque.idLocal where almo_estoque.idProduto = almo_aguardando_armazenamento.idInsumo and
                almo_estoque.idEmitente = almo_aguardando_armazenamento.idEmitente LIMIT 1) as idLocalSUG,
                (select almo_estoque_locais2.local from almo_estoque join almo_estoque_departamento as almo_estoque_departamento2 on 
                almo_estoque_departamento2.idAlmoEstoqueDep = almo_estoque.idDepartamento join almo_estoque_locais as almo_estoque_locais2 on 
                almo_estoque_locais2.idAlmoEstoqueLocais = almo_estoque.idLocal where almo_estoque.idProduto = almo_aguardando_armazenamento.idInsumo and
                almo_estoque.idEmitente = almo_aguardando_armazenamento.idEmitente LIMIT 1) as localSUG,
                (select almo_estoque.idDepartamento from almo_estoque join almo_estoque_departamento as almo_estoque_departamento2 on 
                almo_estoque_departamento2.idAlmoEstoqueDep = almo_estoque.idDepartamento join almo_estoque_locais as almo_estoque_locais2 on 
                almo_estoque_locais2.idAlmoEstoqueLocais = almo_estoque.idLocal where almo_estoque.idProduto = almo_aguardando_armazenamento.idInsumo and
                almo_estoque.idEmitente = almo_aguardando_armazenamento.idEmitente LIMIT 1) as idDepartamentoSUG,
                (select almo_estoque_departamento2.descricaoDepartamento from almo_estoque join almo_estoque_departamento as almo_estoque_departamento2 on 
                almo_estoque_departamento2.idAlmoEstoqueDep = almo_estoque.idDepartamento join almo_estoque_locais as almo_estoque_locais2 on 
                almo_estoque_locais2.idAlmoEstoqueLocais = almo_estoque.idLocal where almo_estoque.idProduto = almo_aguardando_armazenamento.idInsumo and
                almo_estoque.idEmitente = almo_aguardando_armazenamento.idEmitente LIMIT 1) as descricaoDepartamentoSUG 
            FROM `almo_aguardando_armazenamento` 
            join emitente on emitente.id = almo_aguardando_armazenamento.idEmitente 
            join insumos on insumos.idInsumos = almo_aguardando_armazenamento.idInsumo 
            left join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_aguardando_armazenamento.idDepartamento 
            left join almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_aguardando_armazenamento.idLocal
            join status_aguardando_armazenamento on status_aguardando_armazenamento.idStatusAgArmaz = almo_aguardando_armazenamento.idStatusAgArmaz
            WHERE almo_aguardando_armazenamento.idStatusAgArmaz = 2";
        return $this->db->query($query)->result();
    }
    public function getDepartamentoTipo($tipo){
        $query = "SELECT * FROM almo_estoque_departamento WHERE tipo = ? ORDER BY descricaoDepartamento asc";
        return $this->db->query($query, [$this->db->escape_str($tipo)])->result();
    }
    public function getAgArmazId($id){
        $query = "SELECT * FROM almo_aguardando_armazenamento WHERE idAlmoAgArmaz = ?";
        return $this->db->query($query, [(int)$id])->result();
    }
    public function updateAgArmazId($data,$id){        
        $this->db->where('idAlmoAgArmaz in ('.$id.')');
        $this->db->update("almo_aguardando_armazenamento", $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}
    }
    public function insertEditarLocal($data){
        $this->db->insert("almo_estoque_editarlocal",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_editarlocal");        
		}
    }
    public function insertPEditarLocal($data){
        $this->db->insert("almo_estoque_p_editarlocal",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_p_editarlocal");        
		}
    }
    public function getItensOs($idOs,$idEmpresa,$idDepart){
        $query = "SELECT * from almo_estoque
        join insumos on insumos.idInsumos = almo_estoque.idProduto
        left join almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal
        join emitente on almo_estoque.idEmitente = emitente.id
        where almo_estoque.idOs = ? and almo_estoque.idEmitente = ? and almo_estoque.idDepartamento = ? and almo_estoque.quantidade > 0";
        return $this->db->query($query, [(int)$idOs, (int)$idEmpresa, (int)$idDepart])->result();
    }
    function getEstoqueByIdEmitenteAndIdInsumo($idEmitente, $idInsumos){
        // SEGURANÇA: parâmetros via bind evitam SQL Injection
        $query = "SELECT * FROM `almo_estoque` WHERE idProduto = ? AND idEmitente = ? ORDER BY quantidade DESC";
        return $this->db->query($query, [(int)$idInsumos, (int)$idEmitente])->result();
    }
    function getItensReservadoOs($where = ""){
        $query = "SELECT almo_estoque.*, emitente.nome,almo_estoque_departamento.descricaoDepartamento,almo_estoque_locais.local,insumos.descricaoInsumo, status_os.nomeStatusOs 
            FROM almo_estoque 
            join insumos on almo_estoque.idProduto = insumos.idInsumos 
            join os on os.idOs = almo_estoque.idOs 
            join status_os on status_os.idStatusOs = os.idStatusOs 
            join emitente on emitente.id = almo_estoque.idEmitente 
            join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
            LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal
            WHERE almo_estoque.idOs is not null and almo_estoque.quantidade > 0 $where";
        return $this->db->query($query)->result();
    }
    function getOsTravadas($where = ""){
        $query = "SELECT os.idOs, os.data_abertura, clientes.nomeCliente, status_os.idStatusOs, os.qtd_os, orcamento_item.descricao_item, unidade_execucao.status_execucao,vendedores.nomeVendedor 
        FROM `os` 
        JOIN orcamento_item ON orcamento_item.idOrcamento_item = OS.idOrcamento_item 
        JOIN produtos ON produtos.idProdutos = orcamento_item.idProdutos 
        JOIN orcamento on orcamento.idOrcamentos = orcamento_item.idOrcamentos 
        join clientes on clientes.idClientes = orcamento.idClientes 
        join status_os on status_os.idStatusOs = os.idStatusOs 
        join unidade_execucao on unidade_execucao.id_unid_exec = os.unid_execucao 
        join vendedores on vendedores.idVendedor = orcamento.idVendedor
        left join pecas_mortas on pecas_mortas.idOs = os.idOs
        WHERE OS.fechadoPCP = 1  $where ORDER BY os.idOs DESC LIMIT 100";
        return $this->db->query($query)->result();
    }
    function getHistoricoVale(){
        $query = "SELECT * FROM `hist_vale` join usuarios on usuarios.idUsuarios = hist_vale.idUser
        join insumos on insumos.idInsumos = hist_vale.idInsumo  ORDER by hist_vale.data_insert desc limit 50";
        return $this->db->query($query)->result();
    }
    function getHistoricoPecasMortas(){
        $query = "SELECT pecas_mortas.*, insumos.*, usuarios.*, motivos_perda.* 
            FROM `pecas_mortas` join usuarios on usuarios.idUsuarios = pecas_mortas.usuario 
            join almo_estoque_saida on almo_estoque_saida.idAlmoEstoqueSaida = pecas_mortas.idAlmoEstoqueSaida 
            join motivos_perda on motivos_perda.idMotivosPerda = pecas_mortas.idMotivoPerda
            join almo_estoque on almo_estoque.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque 
            join insumos on insumos.idInsumos = almo_estoque.idProduto 
            order by pecas_mortas.data_cadastro desc limit 50";
        return $this->db->query($query)->result();
    }
    function getHistoricoLiberarPCP(){   
        $query = "SELECT hist_fechadopcp.*, orcamento_item.*, usuarios.* 
        FROM `hist_fechadopcp` 
        join usuarios on usuarios.idUsuarios = hist_fechadopcp.idUser 
        left join os on os.idOs = hist_fechadopcp.idOs 
        left join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
        WHERE hist_fechadopcp.fechadoPCP = 0 ORDER by data_insert desc limit 50";
        return $this->db->query($query)->result();     
    }
    function getEstoqueMorte(){
        $query = "SELECT *
        FROM `pecas_mortas_estoque` 
        JOIN insumos on insumos.idInsumos = pecas_mortas_estoque.idInsumo
        left JOIN motivos_perda on motivos_perda.idMotivosPerda = pecas_mortas_estoque.idMotivoPerda
        WHERE quantidade != 0 ";
        return $this->db->query($query)->result();   
    }
    public function autoCompleteCliente($q){

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
    public function autoCompleteVendedor($q){

        $this->db->select('*');
        $this->db->limit(10);
        $this->db->like('nomeVendedor', $q);
        $query = $this->db->get('vendedores');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nomeVendedor'],'id'=>$row['idVendedor'] );
            }
            echo json_encode($row_set);
        }
    }

    public function getPecaMortaEstoque($id){
        $query = "SELECT * from pecas_mortas_estoque
            join insumos on insumos.idInsumos = pecas_mortas_estoque.idInsumo
            join motivos_perda on motivos_perda.idMotivosPerda = pecas_mortas_estoque.idMotivoPerda
            where pecas_mortas_estoque.idPecasMortasEstoque = ?";
        return $this->db->query($query, [(int)$id])->row();
    }

    public function getPecaMortaEstoque2($id){
        $query = "SELECT * from pecas_mortas_estoque WHERE pecas_mortas_estoque.idPecasMortasEstoque = ?";
        return $this->db->query($query, [(int)$id])->row();
    }


    public function getDestinoPecas(){
        $query = "SELECT * from destino_pecas_mortas";
        return $this->db->query($query)->result();   
    }
    public function getDestinoPecasHis(){
        $query = "SELECT * FROM pecas_mortas_saida join destino_pecas_mortas on destino_pecas_mortas.idDestinoPecasMortas = pecas_mortas_saida.idDestino join insumos on insumos.idInsumos = pecas_mortas_saida.idInsumo";
        return $this->db->query($query)->result();   
    }
    public function getValeByOs($idOs){
        // SEGURANÇA: parâmetros via bind evitam SQL Injection
        $query = "SELECT hist_vale.*, usuarios.nome, insumos.* FROM `hist_vale` JOIN insumos ON insumos.idInsumos = hist_vale.idInsumo JOIN usuarios ON usuarios.idUsuarios = hist_vale.idUser WHERE idOsOrig = ? OR idOsDest = ?";
        return $this->db->query($query, [(int)$idOs, (int)$idOs])->result();
    }
    public function getValeByOsDestAndIdInsumo($idOs, $idInsumo){
        // SEGURANÇA: parâmetros via bind evitam SQL Injection
        $query = "SELECT * FROM `hist_vale` JOIN insumos ON insumos.idInsumos = hist_vale.idInsumo WHERE idOsDest = ? AND hist_vale.idInsumo = ? GROUP BY idOsDest ORDER BY data_insert ASC";
        return $this->db->query($query, [(int)$idOs, (int)$idInsumo])->result();
    }
    public function getOnlyValeByOsOrigem($idOs){
        // SEGURANÇA: parâmetro via bind evita SQL Injection
        $query = "SELECT * FROM `hist_vale` WHERE idOsOrig = ?";
        return $this->db->query($query, [(int)$idOs])->result();
    }
    public function compareEntradaSaidaNegativos(){
        $query ="SELECT insumos.idInsumos, 
        insumos.descricaoInsumo, emitente.nome, insumos.pn_insumo,almo_estoque_departamento.descricaoDepartamento,
        SUM(almo_estoque.quantidade) as quantidade_total, 
         (if((select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto)is null,0,(select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto)) - 
        if((select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto) is null,0,(select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto))) as subtracao,
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto) as quantidade_entrada, 
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto) as 	quantidade_saida
        FROM `almo_estoque` join insumos on insumos.idInsumos = almo_estoque.idProduto 
        join emitente on emitente.id = almo_estoque.idEmitente 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento 
        group by insumos.idInsumos HAVING quantidade_total != subtracao and subtracao < 0
        order by insumos.descricaoInsumo asc";
        return $this->db->query($query)->result();
    }
    public function compareEntradaSaida(){
        $query ="SELECT insumos.idInsumos, 
        insumos.descricaoInsumo, emitente.nome,emitente.id, insumos.pn_insumo,almo_estoque_departamento.descricaoDepartamento,almo_estoque_departamento.idAlmoEstoqueDep,almo_estoque.idAlmoEstoque,
        SUM(almo_estoque.quantidade) as quantidade_total, 
         (if((select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento)is null,0,(select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto  and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento)) - 
        if((select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto and almo_estoque2.idEmitente = almo_estoque.idEmitente and almo_estoque2.idDepartamento = almo_estoque.idDepartamento) is null,0,(select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto and almo_estoque2.idEmitente = almo_estoque.idEmitente and almo_estoque2.idDepartamento = almo_estoque.idDepartamento))) as subtracao,
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento) as quantidade_entrada, 
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto and almo_estoque2.idEmitente = almo_estoque.idEmitente and almo_estoque2.idDepartamento = almo_estoque.idDepartamento) as 	quantidade_saida
        FROM `almo_estoque` join insumos on insumos.idInsumos = almo_estoque.idProduto 
        join emitente on emitente.id = almo_estoque.idEmitente 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento 
        group by insumos.idInsumos,almo_estoque_departamento.idAlmoEstoqueDep,emitente.id HAVING quantidade_total != subtracao
        order by insumos.descricaoInsumo asc";
        return $this->db->query($query)->result();
    }
    public function compareEntradaSaidaProdutos(){
        $query ="SELECT produtos.idProdutos, 
        produtos.descricao, emitente.nome,emitente.id, produtos.pn,almo_estoque_departamento.descricaoDepartamento,almo_estoque_departamento.idAlmoEstoqueDep,almo_estoque_produtos.idAlmoEstoqueProduto,almo_estoque_produtos.idStatusProduto,
        SUM(almo_estoque_produtos.quantidade) as quantidade_total, 
         (if((select sum(almo_estoque_p_entrada.quantidade)
             from almo_estoque_p_entrada 
             where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto and almo_estoque_p_entrada.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque_p_entrada.idDepartamento = almo_estoque_produtos.idDepartamento and almo_estoque_p_entrada.idStatusProduto = almo_estoque_produtos.idStatusProduto)is null,0,(select sum(almo_estoque_p_entrada.quantidade)
             from almo_estoque_p_entrada 
             where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto  and almo_estoque_p_entrada.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque_p_entrada.idDepartamento = almo_estoque_produtos.idDepartamento and almo_estoque_p_entrada.idStatusProduto = almo_estoque_produtos.idStatusProduto)) - 
        if((select SUM(almo_estoque_p_saida.quantidade)
             from almo_estoque_p_saida 
             join almo_estoque_produtos as almo_estoque2 on almo_estoque2.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
            where almo_estoque2.idProduto = almo_estoque_produtos.idProduto and almo_estoque2.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque2.idDepartamento = almo_estoque_produtos.idDepartamento and almo_estoque2.idStatusProduto = almo_estoque_produtos.idStatusProduto) is null,0,(select SUM(almo_estoque_p_saida.quantidade)
             from almo_estoque_p_saida 
             join almo_estoque_produtos as almo_estoque2 on almo_estoque2.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
            where almo_estoque2.idProduto = almo_estoque_produtos.idProduto and almo_estoque2.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque2.idDepartamento = almo_estoque_produtos.idDepartamento and almo_estoque2.idStatusProduto = almo_estoque_produtos.idStatusProduto))) as subtracao,
        (select sum(almo_estoque_p_entrada.quantidade)
             from almo_estoque_p_entrada 
             where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto and almo_estoque_p_entrada.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque_p_entrada.idDepartamento = almo_estoque_produtos.idDepartamento and almo_estoque_p_entrada.idStatusProduto = almo_estoque_produtos.idStatusProduto) as quantidade_entrada, 
        (select SUM(almo_estoque_p_saida.quantidade)
             from almo_estoque_p_saida 
             join almo_estoque_produtos as almo_estoque2 on almo_estoque2.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
            where almo_estoque2.idProduto = almo_estoque_produtos.idProduto and almo_estoque2.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque2.idDepartamento = almo_estoque_produtos.idDepartamento and almo_estoque2.idStatusProduto = almo_estoque_produtos.idStatusProduto) as 	quantidade_saida
        FROM `almo_estoque_produtos` join produtos on produtos.idProdutos = almo_estoque_produtos.idProduto 
        join emitente on emitente.id = almo_estoque_produtos.idEmitente 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento 
        group by produtos.idProdutos,almo_estoque_departamento.idAlmoEstoqueDep,emitente.id HAVING quantidade_total != subtracao
        order by produtos.descricao asc";
        return $this->db->query($query)->result();
    }
    function getEstoqueNot0AndNotReservadoByIdInsumo($id){
        $query = "SELECT \"0\" as reservado, insumos.descricaoInsumo, 
            emitente.nome, 
            sum(almo_estoque.quantidade) as quantidade
            FROM `almo_estoque` 
            join insumos on insumos.idInsumos = almo_estoque.idProduto 
            join emitente on emitente.id = almo_estoque.idEmitente 
            where (idOs is null or idOs = 0) and insumos.idInsumos = ? GROUP by insumos.idInsumos,almo_estoque.idEmitente,almo_estoque.comprimento,almo_estoque.peso,almo_estoque.volume,almo_estoque.dimensoesL,almo_estoque.dimensoesC,almo_estoque.dimensoesA";
        return $this->db->query($query, [(int)$id])->result();
    }
    function getEstoqueNot0AndReservadoByIdInsumo($id){
        // SEGURANÇA: parâmetro via bind evita SQL Injection
        $query = "SELECT '1' as reservado, insumos.descricaoInsumo, emitente.nome, SUM(almo_estoque.quantidade) as quantidade
            FROM `almo_estoque`
            JOIN insumos ON insumos.idInsumos = almo_estoque.idProduto
            JOIN emitente ON emitente.id = almo_estoque.idEmitente
            WHERE idOs IS NOT NULL AND idOs != 0 AND insumos.idInsumos = ?
            GROUP BY insumos.idInsumos, almo_estoque.idEmitente, almo_estoque.comprimento, almo_estoque.peso, almo_estoque.volume, almo_estoque.dimensoesL, almo_estoque.dimensoesC, almo_estoque.dimensoesA";
        return $this->db->query($query, [(int)$id])->result();
    }
    function getAllEntradaByIdInsumoAndIdEmitenteAndIdDepartamento($idInsumo, $idEmitente, $idDepartamento){
        // SEGURANÇA: parâmetros via bind evitam SQL Injection
        $query = "SELECT 'Entrada' as tipo, almo_estoque_entrada.quantidade, almo_estoque_entrada.data_entrada as data_insert FROM almo_estoque_entrada WHERE almo_estoque_entrada.idProduto = ? AND almo_estoque_entrada.idEmitente = ? AND almo_estoque_entrada.idDepartamento = ?";
        return $this->db->query($query, [(int)$idInsumo, (int)$idEmitente, (int)$idDepartamento])->result();
    }
    function getAllSaidaByIdInsumoAndIdEmitenteAndIdDepartamento($idInsumo, $idEmitente, $idDepartamento){
        // SEGURANÇA: parâmetros via bind evitam SQL Injection
        $query = "SELECT 'Saida' as tipo, almo_estoque_saida.quantidade, almo_estoque_saida.data_saida as data_insert FROM almo_estoque_saida JOIN almo_estoque ON almo_estoque.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque WHERE almo_estoque.idProduto = ? AND almo_estoque.idEmitente = ? AND almo_estoque.idDepartamento = ?";
        return $this->db->query($query, [(int)$idInsumo, (int)$idEmitente, (int)$idDepartamento])->result();
    }
    public function getLinhaDotempo($data,$where){
        $data_safe = $this->db->escape_str($data);
        $query ="SELECT insumos.idInsumos,
            insumos.descricaoInsumo, emitente.nome,emitente.id, null as pn, insumos.pn_insumo,almo_estoque_departamento.descricaoDepartamento,almo_estoque_departamento.idAlmoEstoqueDep,almo_estoque.idAlmoEstoque,
            SUM(almo_estoque.quantidade) as quantidade_total,
            (select sum(almo_estoque_entrada.quantidade)
                from almo_estoque_entrada
                where almo_estoque_entrada.idProduto = almo_estoque.idProduto and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento and DATE(almo_estoque_entrada.data_entrada)<='".$data_safe."') as quantidade_entrada,
            (select SUM(almo_estoque_saida.quantidade)
                from almo_estoque_saida
                join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
                where almo_estoque2.idProduto = almo_estoque.idProduto and almo_estoque2.idEmitente = almo_estoque.idEmitente and almo_estoque2.idDepartamento = almo_estoque.idDepartamento and DATE(almo_estoque_saida.data_saida)<='".$data_safe."') as \tquantidade_saida
            FROM `almo_estoque` join insumos on insumos.idInsumos = almo_estoque.idProduto
            join emitente on emitente.id = almo_estoque.idEmitente
            join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento where 1=1 $where
            group by insumos.idInsumos,almo_estoque_departamento.idAlmoEstoqueDep,emitente.id HAVING quantidade_total !=0
            order by insumos.descricaoInsumo asc";
        return $this->db->query($query)->result();
    }
    public function getLinhaDotempo2($data,$where){
        $data_safe = $this->db->escape_str($data);
        $query ="SELECT insumos.idInsumos, (SELECT sum(distribuir_os.quantidade)/sum(distribuir_os.quantidade*pedido_comprasitens.valor_unitario) FROM `distribuir_os` JOIN pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir JOIN pedido_comprasitens on pedido_comprasitens.idCotacaoItens = pedido_cotacaoitens.idCotacaoItens and pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens WHERE distribuir_os.idStatuscompras = 5 and distribuir_os.idInsumos = insumos.idInsumos) as mediaValorUnit,
            insumos.descricaoInsumo, emitente.nome,emitente.id, null as pn, insumos.pn_insumo,almo_estoque_departamento.descricaoDepartamento,almo_estoque_departamento.idAlmoEstoqueDep,almo_estoque.idAlmoEstoque,
            SUM(almo_estoque.quantidade) as quantidade_total,
            (select sum(almo_estoque_entrada.quantidade)
                from almo_estoque_entrada
                where almo_estoque_entrada.idProduto = almo_estoque.idProduto and almo_estoque_entrada.idEmitente = almo_estoque.idEmitente and almo_estoque_entrada.idDepartamento = almo_estoque.idDepartamento and DATE(almo_estoque_entrada.data_entrada)<='".$data_safe."') as quantidade_entrada,
            (select SUM(almo_estoque_saida.quantidade)
                from almo_estoque_saida
                join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
                where almo_estoque2.idProduto = almo_estoque.idProduto and almo_estoque2.idEmitente = almo_estoque.idEmitente and almo_estoque2.idDepartamento = almo_estoque.idDepartamento and DATE(almo_estoque_saida.data_saida)<='".$data_safe."') as \tquantidade_saida
            FROM `almo_estoque` join insumos on insumos.idInsumos = almo_estoque.idProduto
            join emitente on emitente.id = almo_estoque.idEmitente
            join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento where 1=1 $where
            group by insumos.idInsumos,almo_estoque_departamento.idAlmoEstoqueDep,emitente.id HAVING quantidade_total !=0
            order by insumos.descricaoInsumo asc";
        return $this->db->query($query)->result();
    }
    public function getLinhaDotempoProd($data,$where){
        $data_safe = $this->db->escape_str($data);
        $query ="SELECT produtos.idProdutos,
            produtos.descricao as descricaoInsumo, emitente.nome,emitente.id, produtos.pn,almo_estoque_departamento.descricaoDepartamento,almo_estoque_departamento.idAlmoEstoqueDep,almo_estoque_produtos.idAlmoEstoqueProduto,
            SUM(almo_estoque_produtos.quantidade) as quantidade_total,
            (select sum(almo_estoque_p_entrada.quantidade)
                from almo_estoque_p_entrada
                where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto and almo_estoque_p_entrada.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque_p_entrada.idDepartamento = almo_estoque_produtos.idDepartamento and DATE(almo_estoque_p_entrada.data_entrada)<='".$data_safe."') as quantidade_entrada,
            (select SUM(almo_estoque_p_saida.quantidade)
                from almo_estoque_p_saida
                join almo_estoque_produtos as almo_estoque2 on almo_estoque2.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
                where almo_estoque2.idProduto = almo_estoque_produtos.idProduto and almo_estoque2.idEmitente = almo_estoque_produtos.idEmitente and almo_estoque2.idDepartamento = almo_estoque_produtos.idDepartamento and DATE(almo_estoque_p_saida.data_saida)<='".$data_safe."') as \tquantidade_saida
            FROM `almo_estoque_produtos` join produtos on produtos.idProdutos = almo_estoque_produtos.idProduto
            join emitente on emitente.id = almo_estoque_produtos.idEmitente
            join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento where 1=1 $where
            group by produtos.idProdutos,almo_estoque_departamento.idAlmoEstoqueDep,emitente.id HAVING quantidade_total !=0
            order by produtos.descricao asc";
        return $this->db->query($query)->result();
    }
    
}