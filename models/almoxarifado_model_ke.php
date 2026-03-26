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
    public function autoCompleteLocais($q, $e){

        $this->db->select('*');
        $this->db->limit(10);
        $this->db->like('local', $q);
        $this->db->where('idEmitente',$e);
        $query = $this->db->get('almo_estoque_locais');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['local'],'id'=>$row['idAlmoEstoqueLocais']);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteFunc($q, $e){

        $this->db->select('*');
        $this->db->limit(10);
        $this->db->like('almo_estoque_usuario.nome', $q);
        $this->db->join('setor_empresa', 'setor_empresa.id_setor = almo_estoque_usuario.idSetor');
        $this->db->where('almo_estoque_usuario.idSetor',$e);
        $query = $this->db->get('almo_estoque_usuario');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['nome'].' | Cod.: '.$row['idAlmoEstoqueUsuario'],'id'=>$row['idAlmoEstoqueUsuario']);
            }
			
            echo json_encode($row_set);
        }
    }

    public function autoCompleteCategoriaSubCategoria($q){

        $this->db->select('*');
        $this->db->limit(10);
        $this->db->like('categoriainsumos.descricaoCategoria', $q);
        $this->db->join('categoriainsumos', 'categoriainsumos.idCategoria = subcategoriainsumo.idCategoria');
        $query = $this->db->get('subcategoriainsumo');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricaoCategoria'].' | '.$row['descricaoSubcategoria'],'id'=>$row['idSubcategoria']);
            }
			
            echo json_encode($row_set);
        }
    }
    public function autoCompleteEstoqueSaida($q, $e){

        $this->db->select('almo_estoque.idAlmoEstoque,
        almo_estoque.idProduto,
         almo_estoque.idEmitente,
         almo_estoque.idLocal,
         almo_estoque.quantidade,
         almo_estoque.metrica,
         almo_estoque.volume,
         almo_estoque.comprimento,
         almo_estoque.peso,
         insumos.idInsumos,
         insumos.descricaoInsumo,
         emitente.id,
         emitente.nome,
         almo_estoque_locais.idAlmoEstoqueLocais,
         almo_estoque_locais.local');
         $this->db->from('almo_estoque');
         $this->db->join('insumos','insumos.idInsumos = almo_estoque.idProduto');
         $this->db->join('emitente','emitente.id = almo_estoque.idEmitente');
         $this->db->join('almo_estoque_locais','almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal');
        $this->db->limit(10);
        $this->db->like('insumos.descricaoInsumo', $q);
        $this->db->where('almo_estoque.idEmitente',$e);
        $query = $this->db->get();
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                if($row['metrica'] == 0){
                    $row_set[] = array('label'=>$row['descricaoInsumo'].' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo']);
                } else if($row['metrica'] == 1){
                    $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['comprimento'].' CM'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo']);
                }if($row['metrica'] == 2){
                    $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['volume'].' ML'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo']);
                }if($row['metrica'] == 3){
                    $row_set[] = array('label'=>$row['descricaoInsumo'].' | '.$row['peso'].' G'.' | Local: '.$row['local'],'id'=>$row['idAlmoEstoque'],'local'=>$row['local'],'quantidade'=>$row['quantidade'],"nome"=>$row['descricaoInsumo']);
                }
                
            }
			
            echo json_encode($row_set);
        }
    }
    public function verificaPMEL($p,$m,$c,$v,$ps,$e,$l){
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
                } 
                $primeiro = false;                            
            }else{
                if(!empty($v) && $v != ""){
                    $where = $where." and metrica = ".$m." and volume = ".$v;
                } else if(!empty($c) && $c != ""){
                    $where = $where." and metrica = ".$m." and comprimento = ".$c;
                } else if(!empty($ps) && $ps != ""){
                    $where = $where." and metrica = ".$m." and peso = ".$ps;
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
        }
        $this->db->where($where,null,false);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }
    public function criarEstoqueEntrada($p,$m,$c,$v,$ps,$e,$l,$qtd,$idUser,$nf,$idOs,$vu){
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
    public function criarEstoque($p,$m,$c,$v,$ps,$e,$l,$qtd){
        if($m == 0){
            $data = array(
                "idProduto" => $p,
                "metrica" => "0",
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idLocal" => $l
            );
        } else if($m == 1){
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "comprimento" => $c,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idLocal" => $l
            );
        } else if($m == 2){
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "volume" => $v,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idLocal" => $l
            );
        }  else if($m == 3){
            $data = array(
                "idProduto" => $p,
                "metrica" => $m,
                "peso" => $ps,
                "quantidade" => $qtd,
                "idEmitente" => $e,
                "idLocal" => $l
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
    public function getEstoque(){
        $query = "SELECT almo_estoque.idAlmoEstoque,
        almo_estoque.idProduto,
        almo_estoque.idEmitente,
        almo_estoque.idLocal,
        almo_estoque.quantidade,
        almo_estoque.metrica,
        almo_estoque.volume,
        almo_estoque.comprimento,
        almo_estoque.peso,
        insumos.idInsumos,
        insumos.descricaoInsumo,
        emitente.id,
        emitente.nome,
        almo_estoque_locais.idAlmoEstoqueLocais,
        almo_estoque_locais.local 
        FROM almo_estoque 
        INNER JOIN insumos on insumos.idInsumos = almo_estoque.idProduto
        INNER JOIN emitente on emitente.id = almo_estoque.idEmitente
        INNER JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal
        ORDER BY insumos.descricaoInsumo asc";
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
        almo_estoque_saida.idOs, 
        insumos.idInsumos, 
        insumos.descricaoInsumo, 
        almo_estoque.metrica, 
        almo_estoque.volume, 
        almo_estoque.comprimento, 
        almo_estoque.peso, 
        almo_estoque_locais.local, 
        empresa.nome as destinoNome, 
        emitente.nome,
        usuarios.nome as username,
        setor_empresa.nomesetor
        FROM almo_estoque_saida 
        JOIN almo_estoque on almo_estoque_saida.idAlmoEstoque = almo_estoque.idAlmoEstoque
        JOIN insumos on almo_estoque.idProduto = insumos.idInsumos
        JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal
        JOIN emitente on almo_estoque_locais.idEmitente = emitente.id
        JOIN emitente as empresa on almo_estoque_saida.idEmpresaDestino = empresa.id
        JOIN usuarios on usuarios.idUsuarios = almo_estoque_saida.idUserSis
        JOIN setor_empresa on setor_empresa.id_setor = almo_estoque_saida.idSetor $where";
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
        almo_estoque_entrada.data_entrada, 
        almo_estoque_entrada.idOs, 
        almo_estoque_entrada.nf, 
        almo_estoque_entrada.idUsuario,
        insumos.descricaoInsumo, 
        almo_estoque_locais.local, 
        emitente.nome as nomeEmpresa, 
        usuarios.nome as username
        FROM `almo_estoque_entrada` 
        JOIN insumos on insumos.idInsumos = almo_estoque_entrada.idProduto
        JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque_entrada.idLocal
        JOIN emitente on emitente.id = almo_estoque_entrada.idEmitente
        JOIN usuarios on usuarios.idUsuarios = almo_estoque_entrada.idUsuario $where";
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
            insumos.idInsumos,
            insumos.descricaoInsumo,
            emitente.id,
            emitente.nome,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque_locais.local 
            FROM almo_estoque 
            INNER JOIN insumos on insumos.idInsumos = almo_estoque.idProduto
            INNER JOIN emitente on emitente.id = almo_estoque.idEmitente
            INNER JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal
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
            insumos.idInsumos,
            insumos.descricaoInsumo,
            emitente.id,
            emitente.nome,
            almo_estoque_locais.idAlmoEstoqueLocais,
            almo_estoque_locais.local 
            FROM almo_estoque 
            INNER JOIN insumos on insumos.idInsumos = almo_estoque.idProduto
            INNER JOIN emitente on emitente.id = almo_estoque.idEmitente
            INNER JOIN almo_estoque_locais on almo_estoque_locais.idAlmoEstoqueLocais = almo_estoque.idLocal WHERE $where
            ORDER BY insumos.descricaoInsumo asc";
        }              
        return $this->db->query($query)->result();
    }
    public function cadastrarSaidas($est,$qtd,$emp,$set,$userSis,$user,$idOs){
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
            "data_saida" => date('Y-m-d H:i:s')
        );
       
        $this->db->insert("almo_estoque_saida",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("almo_estoque_saida");        
		}
    }
    public function getItemEstoque($id){
        $query = "SELECT idAlmoEstoque,quantidade       
        FROM almo_estoque         
        WHERE idAlmoEstoque = $id";
        return $this->db->query($query)->result();
    }
    public function cadastrarLocal($empresa, $local){
        $data = array(
            "idEmitente" => $empresa,
            "local" => strtoupper($local)
        );
        $this->db->insert("almo_estoque_locais",$data);
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
    }
    public function getLocais(){
        $query = "SELECT almo_estoque_locais.idAlmoEstoqueLocais,
        almo_estoque_locais.idEmitente,
        almo_estoque_locais.local,
        emitente.nome
        FROM `almo_estoque_locais` 
        JOIN emitente on emitente.id = almo_estoque_locais.idEmitente
        ORDER BY almo_estoque_locais.local asc";
        return $this->db->query($query)->result();
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
        WHERE almo_estoque_locais.idAlmoEstoqueLocais = $idLocal ";
        return $this->db->query($query)->result();
    }
    public function deleteLocal($idLocal){
        $query="DELETE FROM `almo_estoque_locais` WHERE idAlmoEstoqueLocais = $idLocal";
    }
    public function cadastrarCategoria($desc){        
        $data = array(
            "descricaoCategoria" => strtoupper($desc)
        );
       
        $this->db->insert("categoriainsumos",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("categoriainsumos");        
		}
    }
    public function cadastrarSubcategoria($desc,$idCat){        
        $data = array(
            "descricaoSubcategoria" => strtoupper($desc),
            "idCategoria" => $idCat
        );
       
        $this->db->insert("subcategoriainsumo",$data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("subcategoriainsumo");        
		}
    }
}