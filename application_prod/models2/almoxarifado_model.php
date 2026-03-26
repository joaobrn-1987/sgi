<?php
class Almoxarifado_model extends CI_Model {

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
        if ($this->db->affected_rows() == '1')
		{
                        if($returnId == true){
                            return $this->db->insert_id($table);
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
        $query2 = 'SELECT insumos.*, subcategoriaInsumo.*,categoriaInsumos.* , (select SUM(quantidade) from almo_estoque where almo_estoque.idProduto = insumos.idInsumos and almo_estoque.idEmitente = 1 ) as qtdEst FROM `insumos` join subcategoriaInsumo on subcategoriaInsumo.idSubcategoria = insumos.idSubcategoria join categoriaInsumos on categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria where insumos.descricaoInsumo like "%'.$q.'%"';

        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->descricaoInsumo.' | ID: '.$row->idInsumos,'id'=>$row->idInsumos,'idCat'=>$row->idCategoria,'idSubcat'=>$row->idSubcategoria,'descricaoCategoria'=>$row->descricaoCategoria,'descricaoSubcategoria'=>$row->descricaoSubcategoria,'descricao'=>$row->descricaoInsumo,'qtdEst'=>$row->qtdEst,'pn'=>$row->pn_insumo);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompletePN($q){
        $query2 = 'SELECT insumos.*, subcategoriaInsumo.*,categoriaInsumos.* , (select SUM(quantidade) from almo_estoque where almo_estoque.idProduto = insumos.idInsumos and almo_estoque.idEmitente = 1 ) as qtdEst FROM `insumos` join subcategoriaInsumo on subcategoriaInsumo.idSubcategoria = insumos.idSubcategoria join categoriaInsumos on categoriaInsumos.idCategoria = subcategoriaInsumo.idCategoria where insumos.pn_insumo like "%'.$q.'%"';

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
        emitente.nome,emitente.nomeExibicao,
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
        $this->db->where("almo_estoque.idEmitente = '$e' and insumos.pn_insumo like '$q%' and almo_estoque.idDepartamento = '$d' and (almo_estoque.idOs is null or almo_estoque.idOs = '')");
        $query = $this->db->get();
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                if($row['local'] == null){
                    if($row['metrica'] == 0){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    } else if($row['metrica'] == 1){
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | '.$row['comprimento'].' CM','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
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
                        $row_set[] = array('label'=>$row['pn_insumo']." | Desc.: ".$row['descricaoInsumo'].' | '.$row['comprimento'].' CM'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
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

        $query2 = 'SELECT produtos.*,(select SUM(quantidade) from almo_estoque_produtos where almo_estoque_produtos.idProduto = produtos.idProdutos and almo_estoque_produtos.idEmitente = 1) as qtdEstt FROM produtos where produtos.pn like "%'.$q.'%" limit 20';

        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->pn.' | Descrição: '.$row->descricao.' | REF.: '.$row->referencia,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteREF2($q){
        $query2 = 'SELECT produtos.*,(select SUM(quantidade) from almo_estoque_produtos where almo_estoque_produtos.idProduto = produtos.idProdutos and almo_estoque_produtos.idEmitente = 1) as qtdEstt FROM produtos where produtos.referencia like "%'.$q.'%" limit 20';

        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->referencia.' | Descrição: '.$row->descricao.' | PN: '.$row->pn,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteProd($q){
        $query2 = 'SELECT produtos.*,(select SUM(quantidade) from almo_estoque_produtos where almo_estoque_produtos.idProduto = produtos.idProdutos and almo_estoque_produtos.idEmitente = 1) as qtdEstt FROM produtos where produtos.descricao like "%'.$q.'%" limit 20';
        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->descricao.' | PN: '.$row->pn.' | REF.: '.$row->referencia,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
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
         emitente.nome,emitente.nomeExibicao,
         almo_estoque_locais.idAlmoEstoqueLocais,
         almo_estoque_locais.local');
         $this->db->from('almo_estoque');
         $this->db->join('insumos','insumos.idInsumos = almo_estoque.idProduto');
         $this->db->join('emitente','emitente.id = almo_estoque.idEmitente');
         $this->db->join('almo_estoque_locais','almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal','left');
        $this->db->limit(10);/*
        $this->db->like('insumos.descricaoInsumo', $q);
        $this->db->where('almo_estoque.idEmitente',$e);
        $this->db->where('almo_estoque.idDepartamento',$d);*/
        $this->db->where("almo_estoque.idEmitente = '$e' and insumos.descricaoInsumo like '%$q%' and almo_estoque.idDepartamento = '$d' and (almo_estoque.idOs is null or almo_estoque.idOs = '')");
        $query = $this->db->get();
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                if($row['local'] == null){
                    if($row['metrica'] == 0){
                        $row_set[] = array('label'=>$row['descricaoInsumo'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
                    } else if($row['metrica'] == 1){
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['comprimento'].' CM','id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
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
                        $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['comprimento'].' CM'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo'],"pn"=>$row['pn_insumo']);
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
        emitente.nome,emitente.nomeExibicao');
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
        emitente.nome,emitente.nomeExibicao');
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
        emitente.nome,emitente.nomeExibicao');
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
    public function verificaPEDL($p,$emp,$dep,$l,$sp){
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
    public function verificaPMEL($p,$m,$c,$v,$ps,$dim,$e,$l,$dep,$idOs = null){
        $primeiro = true; 
        $where = "";
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
                } else if(!empty($dim) && $dim != ""){
                    $dim = explode('x',$dim);
                    $where = $where." metrica = ".$m." and dimensoesL = ".$dim[0]." and dimensoesC = ".$dim[1]." and dimensoesA = ".$dim[2];
                } 
                $primeiro = false;                            
            }else{
                if(!empty($v) && $v != ""){
                    $where = $where." and metrica = ".$m." and volume = ".$v;
                } else if(!empty($c) && $c != ""){
                    $where = $where." and metrica = ".$m." and comprimento = ".$c;
                } else if(!empty($ps) && $ps != ""){
                    $where = $where." and metrica = ".$m." and peso = ".$ps;
                } else if(!empty($dim) && $dim != ""){
                    $dim = explode('x',$dim);
                    $where = $where." and metrica = ".$m." and dimensoesL = ".$dim[0]." and dimensoesC = ".$dim[1]." and dimensoesA = ".$dim[2];
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
    public function criarEstoqueEntrada($p,$m,$c,$v,$ps,$dim,$e,$l,$qtd,$idUser,$nf,$idOs,$vu,$dep){
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
            $dim = explode('x',$dim);
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "dimensoesL" => $dim[0],
                "dimensoesC" => $dim[1],
                "dimensoesA" => $dim[2],
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
    public function criarEstoque($p,$m,$c,$v,$ps,$dim,$e,$l,$qtd,$dep,$idOs = null){
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
            $dim = explode('x',$dim);
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
            $dim = explode('x',$dim);
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "dimensoesL" => $dim[0],
                "dimensoesC" => $dim[1],
                "dimensoesA" => $dim[2],
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
            $where = "where emitente.id = $idEmpresa and almo_estoque_departamento = $idDepartamento  and almo_estoque.quantidade > 0";
        }else if(!empty($idEmpresa) && empty($idDepartamento)){
            $where = "where emitente.id = $idEmpresa  and almo_estoque.quantidade > 0";
        }else if(empty($idEmpresa) && !empty($idDepartamento)){
            $where = "where almo_estoque_departamento = $idDepartamento and almo_estoque.quantidade > 0";
        }else{
            $where = "where almo_estoque.quantidade > 0";
        }
        $query = "SELECT almo_estoque.idAlmoEstoque,
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
            emitente.nome,emitente.nomeExibicao,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque_departamento.descricaoDepartamento,
            almo_estoque.idDepartamento,
            almo_estoque_locais.local 
            FROM almo_estoque 
            INNER JOIN insumos on insumos.idInsumos = almo_estoque.idProduto
            INNER JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
            INNER JOIN emitente on emitente.id = almo_estoque.idEmitente
            LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal $where
            ORDER BY insumos.descricaoInsumo asc";
        return $this->db->query($query)->result();
    }
    public function getEstoqueProduto($idEmpresa = "",$idDepartamento = ""){
        $where = "";
        if(!empty($idEmpresa) && !empty($idDepartamento)){
            $where = "where emitente.id = $idEmpresa and almo_estoque_departamento = $idDepartamento and almo_estoque_produtos.quantidade > 0";
        }else if(!empty($idEmpresa) && empty($idDepartamento)){
            $where = "where emitente.id = $idEmpresa  and almo_estoque_produtos.quantidade > 0";
        }else if(empty($idEmpresa) && !empty($idDepartamento)){
            $where = "where almo_estoque_departamento = $idDepartamento  and almo_estoque_produtos.quantidade > 0";
        }else{
            $where = "where almo_estoque_produtos.quantidade > 0";
        }
        $query = "SELECT almo_estoque_produtos.idAlmoEstoqueProduto,
        almo_estoque_produtos.idProduto,
        almo_estoque_produtos.idEmitente,
        almo_estoque_produtos.idLocal,
        almo_estoque_produtos.quantidade,
        status_produto.descricaoStatusProduto,
        produtos.idProdutos,
        produtos.descricao,
        produtos.pn,
        emitente.id,
        emitente.nome,emitente.nomeExibicao,
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
        ORDER BY produtos.descricao asc";
        return $this->db->query($query)->result();
    }
    public function getDepartamento(){
        $query = "SELECT *
        FROM almo_estoque_departamento 
        ORDER BY descricaoDepartamento asc";
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
        empresa.nomeExibicao as destinoNomeExibicao, 
        emitente.nome,emitente.nomeExibicao,
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
        JOIN setor_empresa on setor_empresa.id_setor = almo_estoque_saida.idSetor $where
        order by almo_estoque_saida.data_saida desc
        LIMIT 100";
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
        insumos.descricaoInsumo, 
        insumos.pn_insumo,
        almo_estoque_locais.local, 
        almo_estoque_departamento.descricaoDepartamento,
        emitente.nome as nomeEmpresa,emitente.nomeExibicao, 
        usuarios.nome as username
        FROM `almo_estoque_entrada` 
        JOIN insumos on insumos.idInsumos = almo_estoque_entrada.idProduto
        LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_entrada.idLocal
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_entrada.idDepartamento
        JOIN emitente on emitente.id = almo_estoque_entrada.idEmitente
        JOIN usuarios on usuarios.idUsuarios = almo_estoque_entrada.idUsuario $where
        order by almo_estoque_entrada.data_entrada desc
        LIMIT 100";
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
        emitente.nomeExibicao, 
        usuarios.nome as username
        FROM `almo_estoque_p_entrada` 
        JOIN produtos on produtos.idProdutos = almo_estoque_p_entrada.idProduto
        LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_p_entrada.idLocal
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_p_entrada.idDepartamento
        JOIN emitente on emitente.id = almo_estoque_p_entrada.idEmitente
        JOIN usuarios on usuarios.idUsuarios = almo_estoque_p_entrada.idUsuario 
        JOIN status_produto on status_produto.idStatusProduto = almo_estoque_p_entrada.idStatusProduto $where
        order by almo_estoque_p_entrada.data_entrada desc
        LIMIT 100";
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
        produtos.idProdutos, 
        produtos.descricao, 
        produtos.pn, 
        almo_estoque_locais.local, 
        almo_estoque_departamento.descricaoDepartamento,
        empresa.nome as destinoNome, 
        empresa.nomeExibicao as destinoNomeExibicao,
        emitente.nome,emitente.nomeExibicao,
        usuarios.nome as username,
        almo_estoque_usuario.nome as getUsernome,
        setor_empresa.nomesetor
        FROM almo_estoque_p_saida 
        JOIN almo_estoque_produtos on almo_estoque_p_saida.idAlmoEstoqueProdutos = almo_estoque_produtos.idAlmoEstoqueProduto
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idEmitente
        JOIN produtos on almo_estoque_produtos.idProduto = produtos.idProdutos
        LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_produtos.idLocal
        JOIN emitente on almo_estoque_produtos.idEmitente = emitente.id
        JOIN emitente as empresa on almo_estoque_p_saida.idEmpresaDestino = empresa.id
        JOIN usuarios on usuarios.idUsuarios = almo_estoque_p_saida.idUserSis
        JOIN almo_estoque_usuario on almo_estoque_usuario.idAlmoEstoqueUsuario = almo_estoque_p_saida.idAlmoEstoqueUsuario
        JOIN setor_empresa on setor_empresa.id_setor = almo_estoque_p_saida.idSetor $where 
        order by almo_estoque_p_saida.data_saida desc
        LIMIT 100";
        return $this->db->query($query)->result();
    }
    public function getEstoqueFilter($where){        
        if(empty($where)){
            $query = "
            SELECT almo_estoque.idAlmoEstoque,
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
            emitente.nome,emitente.nomeExibicao,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque_departamento.descricaoDepartamento,
            almo_estoque.idDepartamento,
            almo_estoque_locais.local 
            FROM almo_estoque 
            INNER JOIN insumos on insumos.idInsumos = almo_estoque.idProduto
            INNER JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
            INNER JOIN emitente on emitente.id = almo_estoque.idEmitente
            LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal
            ORDER BY insumos.descricaoInsumo asc";
        }else{
            $query = "
            SELECT almo_estoque.idAlmoEstoque,
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
            emitente.nome,emitente.nomeExibicao,
            almo_estoque_departamento.descricaoDepartamento,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque.idDepartamento,
            almo_estoque_locais.local 
            FROM almo_estoque 
            INNER JOIN insumos on insumos.idInsumos = almo_estoque.idProduto
            INNER JOIN emitente on emitente.id = almo_estoque.idEmitente
            INNER JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento
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
            almo_estoque_produtos.quantidade,
            status_produto.descricaoStatusProduto,
            produtos.idProdutos,
            produtos.descricao,
            produtos.pn,
            emitente.id,
            emitente.nome,emitente.nomeExibicao,
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
            ORDER BY produtos.descricao asc";
        }else{
            $query = "
            SELECT almo_estoque_produtos.idAlmoEstoqueProduto,
            almo_estoque_produtos.idProduto,
            almo_estoque_produtos.idEmitente,
            almo_estoque_produtos.idLocal,
            almo_estoque_produtos.quantidade,
            status_produto.descricaoStatusProduto,
            produtos.idProdutos,
            produtos.descricao,
            produtos.pn,
            emitente.id,
            emitente.nome,emitente.nomeExibicao,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque_departamento.descricaoDepartamento,
            almo_estoque_produtos.idDepartamento,
            almo_estoque_locais.local 
            FROM almo_estoque_produtos 
            INNER JOIN produtos on produtos.idProdutos = almo_estoque_produtos.idProduto
            INNER JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento
            INNER JOIN emitente on emitente.id = almo_estoque_produtos.idEmitente
            INNER JOIN status_produto on status_produto.idStatusProduto = almo_estoque_produtos.idStatusProduto
            LEFT JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_produtos.idLocal WHERE $where
            ORDER BY produtos.descricao asc";
        }              
        return $this->db->query($query)->result();
    }
    public function cadastrarSaidas($est,$qtd,$emp,$set,$userSis,$user,$idOs,$obs){
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
            "data_saida" => date('Y-m-d H:i:s')
        );
       
        $this->db->insert("almo_estoque_saida",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_saida");        
		}
    }

    public function cadastrarSaidasProdutos($est,$qtd,$emp,$set,$userSis,$user,$idOs,$obs){
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
            "data_saida" => date('Y-m-d H:i:s')
        );
       
        $this->db->insert("almo_estoque_p_saida",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_p_saida");        
		}
    }
    public function getItemEstoque($id){
        $query = "SELECT *     
        FROM almo_estoque         
        WHERE idAlmoEstoque = $id";
        return $this->db->query($query)->result();
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
        emitente.nome,emitente.nomeExibicao,
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
        emitente.nome,emitente.nomeExibicao,
        almo_estoque_departamento.descricaoDepartamento
        FROM `almo_estoque_locais` 
        JOIN emitente on emitente.id = almo_estoque_locais.idEmitente
        JOIN almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_locais.idDepartamento
        WHERE almo_estoque_departamento.idAlmoEstoqueDep = $idDepartamento and emitente.id = $idEmitente and almo_estoque_locais.local = '$local'";
        return $this->db->query($query)->result();
    }
    public function getUsuario(){
        $query = "SELECT almo_estoque_usuario.idAlmoEstoqueUsuario,
        almo_estoque_usuario.nome,
        almo_estoque_usuario.cpf,
        setor_empresa.nomesetor,
        emitente.nome,emitente.nomeExibicao as nomeempresa
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
        WHERE almo_estoque_locais.idAlmoEstoqueLocais = $idLocal ";
        return $this->db->query($query)->result();
    }
    public function getRelatorioInicial(){
        $query = "SELECT insumos.idInsumos, 
        insumos.descricaoInsumo, 
        SUM(almo_estoque.quantidade) as quantidade_total, 
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto) as quantidade_entrada, 
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto) as 	quantidade_saida,
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto)*(SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto) as valor_total_entrada,
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto)*(SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
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
        order by insumos.descricaoInsumo asc";
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
        order by produtos.descricao asc";
        return $this->db->query($query)->result();
    }
    public function getRelatorioInicial2($where = ''){
        $query = "SELECT insumos.idInsumos, 
        insumos.descricaoInsumo, emitente.nome,emitente.nomeExibicao, insumos.pn_insumo,almo_estoque_departamento.descricaoDepartamento,
        SUM(almo_estoque.quantidade) as quantidade_total, 
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto) as quantidade_entrada, 
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto) as 	quantidade_saida,
        (select sum(almo_estoque_entrada.quantidade)
             from almo_estoque_entrada 
             where almo_estoque_entrada.idProduto = almo_estoque.idProduto)*(SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
            from almo_estoque_entrada 
            WHERE insumos.idInsumos = almo_estoque_entrada.idProduto) as valor_total_entrada,
        (select SUM(almo_estoque_saida.quantidade)
             from almo_estoque_saida 
             join almo_estoque as almo_estoque2 on almo_estoque2.idAlmoEstoque = almo_estoque_saida.idAlmoEstoque
            where almo_estoque2.idProduto = almo_estoque.idProduto)*(SELECT SUM(almo_estoque_entrada.valorUnitario*almo_estoque_entrada.quantidade)/SUM(almo_estoque_entrada.quantidade)
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
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque.idDepartamento $where
        group by insumos.idInsumos 
        order by insumos.descricaoInsumo asc";
        return $this->db->query($query)->result();
    }
    public function getRelatorioInicial2Produtos($where = ''){
        $query = "SELECT produtos.idProdutos, 
        produtos.descricao, produtos.pn, emitente.nome,emitente.nomeExibicao,almo_estoque_departamento.descricaoDepartamento,
        SUM(almo_estoque_produtos.quantidade) as quantidade_total, 
        (select sum(almo_estoque_p_entrada.quantidade)
             from almo_estoque_p_entrada 
             where almo_estoque_p_entrada.idProduto = almo_estoque_produtos.idProduto) as quantidade_entrada, 
        (select SUM(almo_estoque_p_saida.quantidade)
             from almo_estoque_p_saida 
             join almo_estoque_produtos as almo_estoque2_produtos on almo_estoque2_produtos.idAlmoEstoqueProduto = almo_estoque_p_saida.idAlmoEstoqueProdutos
            where almo_estoque2_produtos.idProduto = almo_estoque_produtos.idProduto) as 	quantidade_saida,
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
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = almo_estoque_produtos.idDepartamento $where
        group by produtos.idProdutos 
        order by produtos.descricao asc";
        return $this->db->query($query)->result();
    }
    
    public function getRelatorioPorInsumoEmpresa($idInsumos){
        $query = "SELECT insumos.idInsumos, emitente.nome,emitente.nomeExibicao, 
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
        where insumos.idInsumos =  $idInsumos 
        group by insumos.idInsumos, emitente.id";
        return $this->db->query($query)->result();
    }
    public function getRelatorioPorProdutoEmpresa($idProdutos){
        $query = "SELECT produtos.idProdutos as idInsumos, emitente.nome,emitente.nomeExibicao, 
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
        where produtos.idProdutos =  $idProdutos
        group by produtos.idProdutos, emitente.id";
        return $this->db->query($query)->result();
    }
    public function getRelatorioEntradaPorInsumo($idInsumos){
        $query = "SELECT insumos.descricaoInsumo, emitente.nome,emitente.nomeExibicao, sum(almo_estoque_entrada.quantidade) as quantidade_total, sum(almo_estoque_entrada.quantidade*almo_estoque_entrada.valorUnitario) as valor_total 
        FROM `almo_estoque_entrada` 
        JOIN emitente on emitente.id = almo_estoque_entrada.idEmitente
        JOIN insumos on insumos.idInsumos = almo_estoque_entrada.idProduto
        where insumos.idInsumos = $idInsumos
        GROUP BY almo_estoque_entrada.idProduto, almo_estoque_entrada.idEmitente";
        return $this->db->query($query)->result();
    }
    public function getRelatorioSaidaPorInsumo($idInsumos){
        $query = "SELECT insumos.descricaoInsumo, emitente.nome,emitente.nomeExibicao, sum(almo_estoque_saida.quantidade) as quantidade_total, 
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
                where insumos.idInsumos =  $idInsumos     
                GROUP BY insumos.idInsumos, almo_estoque.idEmitente";
        return $this->db->query($query)->result();
    }
    public function getDepartamentoUsuario($idUser){
        $query = "SELECT almo_estoque_departamento.idAlmoEstoqueDep,almo_estoque_departamento.descricaoDepartamento 
        FROM `usuario_departamento` 
        join almo_estoque_departamento on almo_estoque_departamento.idAlmoEstoqueDep = usuario_departamento.idDepartamento 
        where usuario_departamento.idUsuario = $idUser";
        return $this->db->query($query)->result();
    }
    public function getEmpresaUsuario($idUser){
        $query = "SELECT emitente.id,emitente.nome,emitente.nomeExibicao 
        FROM `usuario_empresa` 
        join emitente on emitente.id = usuario_empresa.idEmpresa 
        where usuario_empresa.idUsuario = $idUser";
        return $this->db->query($query)->result();
    }
    public function deleteLocal($idLocal){
        $query="DELETE FROM `almo_estoque_locais` WHERE idAlmoEstoqueLocais = $idLocal";
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
        $query = "SELECT *      
        FROM almo_estoque_produtos        
        WHERE idAlmoEstoqueProduto = $id";
        return $this->db->query($query)->result();
    }
    public function getPermCompra($idInsumo){
        $query = "SELECT *      
        FROM almo_permissao_suprimentos        
        WHERE idInsumo = $idInsumo";
        return $this->db->query($query)->result();
    }
    public function addPermCompra($data){
        $this->db->insert("almo_permissao_suprimentos",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_permissao_suprimentos");        
		}
    }
    public function getAgArmaz($data){
        $query = "SELECT *      
        FROM almo_aguardando_armazenamento        
        WHERE idDistribuirOs = $data";
        return $this->db->query($query)->result();
    }
    public function insertAgArmaz($data){
        $this->db->insert("almo_aguardando_armazenamento",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_aguardando_armazenamento");        
		}
    }
    public function getAgArmazInicial(){
        $query = "SELECT insumos.descricaoInsumo, emitente.nome,emitente.nomeExibicao, almo_aguardando_armazenamento.*, status_aguardando_armazenamento.descricaoAgArmaz,
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
        $query = "SELECT *
        FROM almo_estoque_departamento WHERE tipo = '$tipo'
        ORDER BY descricaoDepartamento asc";
        return $this->db->query($query)->result();
    }
    public function getAgArmazId($id){
        $query = "SELECT *      
        FROM almo_aguardando_armazenamento        
        WHERE idAlmoAgArmaz = $id";
        return $this->db->query($query)->result();
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
        join almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal 
        join emitente on almo_estoque.idEmitente = emitente.id
        where almo_estoque.idOs = $idOs and almo_estoque.idEmitente = $idEmpresa and almo_estoque.idDepartamento = $idDepart and almo_estoque.quantidade > 0";
        return $this->db->query($query)->result();
    }
}