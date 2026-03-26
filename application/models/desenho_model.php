<?php
class Desenho_model extends CI_Model {

    function __construct() {
        parent::__construct();
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
    
    function edit($table,$data,$fieldID,$ID){
        return $this->histAlteracao($table,$data,$fieldID,$ID);
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

    public function getPnWhereLike($field, $search){

        $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $query = "
            SELECT * FROM produtos
            WHERE `$field` LIKE ?
            ORDER BY `$field`
        ";

        return $this->db->query($query, ['%'.$this->db->escape_str($search).'%'])->result();

    }

    public function numrowsPnWhereLike($field, $search){

        $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $query = "
            SELECT * FROM produtos
            WHERE `$field` LIKE ?
            ORDER BY `$field`
        ";

        return $this->db->count_all();

    }

    function get_Pn($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idProdutos','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;

    }

    function count($table){
		return $this->db->count_all($table);
	}

    public function getPnProdutos($field, $search){

        $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $query = "
            SELECT * FROM produtos
            WHERE produtos.`$field` = ?
            ORDER BY produtos.`$field`
        ";

        return $this->db->query($query, [$this->db->escape_str($search)])->result();

    }

    public function getPnBusca($field, $search, $campo, $empresa, $versao_empresa){

        $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $campo = preg_replace('/[^a-zA-Z0-9_]/', '', $campo);
        $query = "

            SELECT produtos.idProdutos, produtos.pn, produto_desenho.descricao, produtos.referencia,
                produtos.fornecedor_original, produtos.equipamento, produtos.subconjunto,
                produtos.modelo, produto_desenho.master, produto_desenho.versao, produto_desenho.data_master,
                produto_desenho.user_alteracao, produto_desenho.user_criacao, produto_desenho.observacao,produto_desenho.empresa,
                produto_desenho.versaoEmpresa, produto_desenho.idPn, produto_desenho.idClientes, desenhos.idDesenhos, desenhos.data_ini,
                desenhos.data_fim, desenhos.nomeArquivoDwg, desenhos.caminhoDwg, desenhos.imagemDwg, desenhos.extensaoDwg,
                desenhos.tamanhoDwg, desenhos.nomeArquivoJpg, desenhos.caminhoJpg, desenhos.imagemJpg, desenhos.extensaoJpg,
                desenhos.tamanhoJpg, desenhos.user_proprietario, desenhos.user_alteracao, desenhos.data_alteracao,
                desenhos.ativo, usuarios.nome as nome_user FROM produtos
                LEFT JOIN produto_desenho ON produto_desenho.idProdutos = produtos.idProdutos
                LEFT JOIN desenhos ON desenhos.idPn = produto_desenho.idPn
                LEFT JOIN usuarios ON (usuarios.idUsuarios = produto_desenho.user_criacao OR usuarios.idUsuarios = produto_desenho.user_alteracao)
            WHERE produtos.`$field` = ? AND
                  produto_desenho.`$campo` = ? AND
                  produto_desenho.versaoEmpresa = ?
            GROUP BY produto_desenho.idPn
            ORDER BY produto_desenho.idPn DESC

        ";

        return $this->db->query($query, [$this->db->escape_str($search), $this->db->escape_str($empresa), $this->db->escape_str($versao_empresa)])->result();

    }

    public function getPn_vers_edit($field, $search, $campo, $empresa, $versao_empresa, $idPn){

        $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $campo = preg_replace('/[^a-zA-Z0-9_]/', '', $campo);
        $query = "

            SELECT produtos.idProdutos, produtos.pn, produto_desenho.descricao, produtos.referencia,
                produtos.fornecedor_original, produtos.equipamento, produtos.subconjunto,
                produtos.modelo, produto_desenho.master, produto_desenho.versao, produto_desenho.data_master,
                produto_desenho.user_alteracao, produto_desenho.user_criacao, produto_desenho.observacao,produto_desenho.empresa,
                produto_desenho.versaoEmpresa, produto_desenho.idPn, produto_desenho.idClientes, desenhos.idDesenhos, desenhos.data_ini,
                desenhos.data_fim, desenhos.nomeArquivoDwg, desenhos.caminhoDwg, desenhos.imagemDwg, desenhos.extensaoDwg,
                desenhos.tamanhoDwg, desenhos.nomeArquivoJpg, desenhos.caminhoJpg, desenhos.imagemJpg, desenhos.extensaoJpg,
                desenhos.tamanhoJpg, desenhos.user_proprietario, desenhos.user_alteracao, desenhos.data_alteracao,
                desenhos.ativo, usuarios.nome as nome_user FROM produtos
                LEFT JOIN produto_desenho ON produto_desenho.idProdutos = produtos.idProdutos
                LEFT JOIN desenhos ON desenhos.idPn = produto_desenho.idPn
                LEFT JOIN usuarios ON usuarios.idUsuarios = produto_desenho.user_criacao OR usuarios.idUsuarios = produto_desenho.user_alteracao
            WHERE produtos.`$field` = ? AND
                  produto_desenho.idPn = ? AND
                  produto_desenho.`$campo` = ? AND
                  produto_desenho.versaoEmpresa = ?
            GROUP BY produto_desenho.idPn
            ORDER BY produto_desenho.idPn DESC

        ";

        return $this->db->query($query, [$this->db->escape_str($search), (int)$idPn, $this->db->escape_str($empresa), $this->db->escape_str($versao_empresa)])->result();

    }

    public function getCompletoPn($field, $search, $idPn){

        $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $query = "

            SELECT produtos.*, produto_desenho.master, produto_desenho.versao, produto_desenho.data_master,
                produto_desenho.user_alteracao, produto_desenho.user_criacao, produto_desenho.observacao,produto_desenho.empresa,
                produto_desenho.versaoEmpresa, produto_desenho.idPn, produto_desenho.idClientes, desenhos.idDesenhos, desenhos.data_ini,
                desenhos.data_fim, desenhos.nomeArquivoDwg, desenhos.caminhoDwg, desenhos.imagemDwg, desenhos.extensaoDwg,
                desenhos.tamanhoDwg, desenhos.nomeArquivoJpg, desenhos.caminhoJpg, desenhos.imagemJpg, desenhos.extensaoJpg,
                desenhos.tamanhoJpg, desenhos.user_proprietario, desenhos.user_alteracao, desenhos.data_alteracao,
                desenhos.ativo, usuarios.nome as nome_user FROM produtos
                LEFT JOIN produto_desenho ON produto_desenho.idProdutos = produtos.idProdutos
                LEFT JOIN desenhos ON desenhos.idPn = produto_desenho.idPn
                LEFT JOIN usuarios ON usuarios.idUsuarios = produto_desenho.user_criacao OR usuarios.idUsuarios = produto_desenho.user_alteracao
            WHERE produtos.`$field` = ? AND
                  produto_desenho.idPn = ?
            GROUP BY produto_desenho.idPn
            ORDER BY produto_desenho.idPn DESC

        ";

        return $this->db->query($query, [$this->db->escape_str($search), (int)$idPn])->result();

    }

    public function getPnProduto_desenho($field, $search){

        $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $query = "
            SELECT * FROM produto_desenho
            WHERE produto_desenho.`$field` = ?
            ORDER BY produto_desenho.`$field`
        ";

        return $this->db->query($query, [$this->db->escape_str($search)])->result();

    }

    public function getPnDesenhos($field, $search){

        $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $query = "
            SELECT * FROM desenhos
            WHERE desenhos.`$field` = ?
            ORDER BY desenhos.`$field`
        ";

        $resultado = $this->db->query($query, [$this->db->escape_str($search)])->result();

        return $resultado[0];

    }

    public function getPnInicioPai(){

        $query = "

            SELECT produtos.idProdutos, produtos.pn, produto_desenho.descricao, produtos.referencia,
                   produtos.fornecedor_original, produtos.equipamento, produtos.subconjunto,
                   produtos.modelo, produto_desenho.versao, produto_desenho.data_master, 
                   produto_desenho.idPn, desenhos.nomeArquivoDwg, 
                   desenhos.caminhoDwg, desenhos.imagemDwg, usuarios.nome as nome_user
            FROM produtos
            LEFT JOIN produto_desenho ON produto_desenho.idProdutos = produtos.idProdutos
            LEFT JOIN desenhos ON desenhos.idPn = produto_desenho.idPn
            LEFT JOIN usuarios ON (usuarios.idUsuarios = produto_desenho.user_criacao OR usuarios.idUsuarios = produto_desenho.user_alteracao)
            WHERE produto_desenho.master = 1
            AND produto_desenho.empresa = ''
            GROUP BY produto_desenho.idPn
            ORDER BY produto_desenho.data_master DESC limit 10
        
        ";

        return $this->db->query($query)->result();

    }

    // FUNÇÃO RETORNANDO TUDO ACRESCENTANDO DESENHOS DE CORTE
    public function getPnInicioPaiB(){

        $query = "

            SELECT produtos.idProdutos, produtos.pn, produto_desenho.descricao, produtos.referencia,
                    produtos.fornecedor_original, produtos.equipamento, produtos.subconjunto,
                    produtos.modelo, produto_desenho.versao, produto_desenho.data_master, 
                    produto_desenho.idPn, desenhos.nomeArquivoDwg, 
                    desenhos.caminhoDwg, desenhos.imagemDwg, usuarios.nome as nome_user,
                    desenho_corte.idCorte, desenho_corte.descricao_corte, desenho_corte.observacao_corte, desenho_corte.nomeArquivo,
                    desenho_corte.caminho, desenho_corte.imagem, desenho_corte.extensao, desenho_corte.tamanho
            FROM produtos
                LEFT JOIN produto_desenho ON produto_desenho.idProdutos = produtos.idProdutos
                LEFT JOIN desenhos ON desenhos.idPn = produto_desenho.idPn
                LEFT JOIN usuarios ON (usuarios.idUsuarios = produto_desenho.user_criacao OR usuarios.idUsuarios = produto_desenho.user_alteracao)
                LEFT JOIN desenho_corte ON desenho_corte.idPn = produto_desenho.idPn
            WHERE produto_desenho.master = 1
            AND produto_desenho.empresa = ''
            GROUP BY produto_desenho.idPn
        
        ";

        return $this->db->query($query)->result();

    }

    public function getPnFilhoPrincipal(){

        $query = "

            SELECT log1.idProdutosHis, log1.idProdutos, log1.idPn, log1.pn,
                    log1.idDesenhos, produto_desenho.descricao, log1.referencia,
                    log1.fornecedor_original, log1.equipamento, log1.subconjunto,
                    log1.modelo, log1.versao, log1.idUserHis, log1.empresa, log1.versaoEmpresa,
                    log1.data_alteracaoHis, log1.imagemDwg, desenhos.nomeArquivoDwg,
                    log1.observacao, desenhos.caminhoDwg, usuarios.nome as nome_user
            FROM produto_history log1
                LEFT JOIN desenhos ON desenhos.idPn = log1.idPn
                LEFT JOIN produto_desenho ON produto_desenho.idPn = desenhos.idPn
                LEFT JOIN usuarios ON usuarios.idUsuarios = log1.idUserHis
            WHERE produto_desenho.master = 0 AND
            log1.idProdutosHis = (SELECT max(log2.idProdutosHis)
                            FROM produto_history log2
                            WHERE log2.idPn = log1.idPn)
            ORDER BY log1.idPn DESC LIMIT 50

        ";
       
        return $this->db->query($query)->result();
       
    }

    public function getPnNetoEmpresa(){

        $query = "

            SELECT log1.idProdutosHis, log1.idProdutos, log1.idPn, log1.pn,
                    log1.idDesenhos, produto_desenho.descricao, log1.referencia,
                    log1.fornecedor_original, log1.equipamento, log1.subconjunto,
                    log1.modelo, log1.versao, log1.idUserHis, log1.empresa, log1.versaoEmpresa,
                    log1.data_alteracaoHis, log1.imagemDwg, desenhos.nomeArquivoDwg,
                    log1.observacao, desenhos.caminhoDwg, usuarios.nome as nome_user
            FROM produto_history log1
                LEFT JOIN desenhos ON desenhos.idPn = log1.idPn
                LEFT JOIN produto_desenho ON produto_desenho.idPn = desenhos.idPn
                LEFT JOIN usuarios ON usuarios.idUsuarios = log1.idUserHis
            WHERE produto_desenho.empresa <> ''
            ORDER BY log1.idPn DESC LIMIT 50

        ";
       
        return $this->db->query($query)->result();

    }

    public function getPnInicioFilho(){

        $query = "

            SELECT produtos.*, produto_desenho.master, produto_desenho.versao, produto_desenho.data_master, 
                produto_desenho.user_alteracao, produto_desenho.user_criacao, produto_desenho.observacao, produto_desenho.empresa,
                produto_desenho.versaoEmpresa, produto_desenho.idPn, produto_desenho.idClientes, desenhos.idDesenhos, desenhos.data_ini, 
                desenhos.data_fim, desenhos.nomeArquivoDwg, desenhos.caminhoDwg, desenhos.imagemDwg, desenhos.extensaoDwg, 
                desenhos.tamanhoDwg, desenhos.nomeArquivoJpg, desenhos.caminhoJpg, desenhos.imagemJpg, desenhos.extensaoJpg, 
                desenhos.tamanhoJpg, desenhos.user_proprietario, desenhos.user_alteracao, desenhos.data_alteracao, 
                desenhos.ativo, usuarios.nome as nome_user FROM produtos
                LEFT JOIN produto_desenho ON produto_desenho.idProdutos = produtos.idProdutos
                LEFT JOIN desenhos ON desenhos.idPn = produto_desenho.idPn
                LEFT JOIN usuarios ON (usuarios.idUsuarios = produto_desenho.user_criacao OR usuarios.idUsuarios = produto_desenho.user_alteracao)
            
            GROUP BY produto_desenho.idPn
            ORDER BY produto_desenho.data_master DESC limit 100

        ";
        
        return $this->db->query($query)->result();
       
    }

    public function autoCompletePN($q){

        $query2 = 'SELECT produtos.* FROM produtos where produtos.pn like ?';

        $query = $this->db->query($query2, ['%'.$this->db->escape_str($q).'%'])->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->pn.' | Descrição: '. $row->descricao,
                                    'id'=>$row->idProdutos, 'pn'=>$row->pn, 'descricao'=>$row->descricao, 
                                    'referencia'=>$row->referencia, 'q'=>$q);
            }
			
            echo json_encode($row_set);
        }
    }

    public function autoCompletePNDescri($q){
        $query2 = 'SELECT produtos.* FROM produtos where produtos.descricao like ?';

        $query = $this->db->query($query2, ['%'.$this->db->escape_str($q).'%'])->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->descricao,
                                    'id'=>$row->idProdutos, 'pn'=>$row->pn, 'descricao'=>$row->descricao, 
                                    'referencia'=>$row->referencia);
            }
			
            echo json_encode($row_set);
        }
    }

    public function autoCompletePNRef($q){
        $query2 = 'SELECT produtos.* FROM produtos where produtos.referencia like ?';

        $query = $this->db->query($query2, ['%'.$this->db->escape_str($q).'%'])->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->referencia,
                                    'id'=>$row->idProdutos, 'pn'=>$row->pn, 'descricao'=>$row->descricao, 
                                    'referencia'=>$row->referencia);
            }
			
            echo json_encode($row_set);
        }
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

    public function autoCompleteEmpresa($q){

        $query_empresa = 'SELECT produto_desenho.empresa, produto_desenho.idClientes
                            FROM produtos
                                LEFT JOIN produto_desenho ON produto_desenho.idProdutos = produtos.idProdutos
                            WHERE produtos.pn like ?
                            GROUP BY produto_desenho.empresa
                            ORDER BY produto_desenho.empresa ASC
        ';
        $result = $this->db->query($query_empresa, ['%'.$this->db->escape_str($q).'%'])->result();
        $empresas = array();

        if(count($result) > 0){

            foreach ($result as $emp){

                if($emp->empresa !== null && $emp->empresa !== ""){

                    array_push($empresas, $emp);

                }

            }

        }

        return $empresas;

    }

    public function autoCompleteVersaoEmpresa($empresa, $pn){

        $query_empresa = 'SELECT produto_desenho.versaoEmpresa
                            FROM produto_desenho
                            LEFT JOIN produtos ON produtos.idProdutos = produto_desenho.idProdutos
                            WHERE produtos.pn = ? AND
                                  produto_desenho.idClientes = ?
                            GROUP BY produto_desenho.versaoEmpresa
                            ORDER BY produto_desenho.versaoEmpresa DESC
        ';

        $result = $this->db->query($query_empresa, [$this->db->escape_str($pn), $this->db->escape_str($empresa)])->result();
        $versaoEmpresa = array();

        if(count($result) > 0){

            foreach ($result as $emp){

                if($emp->versaoEmpresa !== null && $emp->versaoEmpresa !== ""){

                    array_push($versaoEmpresa, $emp->versaoEmpresa);

                }

            }

        }

        return $versaoEmpresa;

    }

    public function verificaEmpresa($idClientes, $idProdutos){

        $query = "

            SELECT empresa, versao, versaoEmpresa, idClientes
            FROM produto_desenho
            WHERE idProdutos = ? AND idClientes = ?

        ";

        $retorno = $this->db->query($query, [(int)$idProdutos, (int)$idClientes])->result();

        return end($retorno);

    }

    public function verifica_pn_edit($idPn){

        $query = "

            SELECT produtos.descricao, produtos.pn, produtos.referencia, produtos.fornecedor_original,
                    produtos.equipamento, produtos.subconjunto,  produtos.modelo,
                    produto_desenho.empresa, produto_desenho.idClientes, produto_desenho.observacao, produto_desenho.versao,
                    produto_desenho.versaoEmpresa, produto_desenho.master, desenhos.nomeArquivoDwg, desenhos.imagemDwg
            FROM produtos
                LEFT JOIN produto_desenho ON produto_desenho.idProdutos = produtos.idProdutos
                LEFT JOIN desenhos ON desenhos.idPn = produto_desenho.idPn
            WHERE produto_desenho.idPn = ?
            ORDER BY produto_desenho.idPn

        ";

        $resultado = $this->db->query($query, [(int)$idPn])->result();
        
        return $resultado[0];
       
    }

    public function historico($field, $search){

        $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $query = "

            SELECT log1.idProdutosHis, log1.idProdutos, log1.idPn, log1.pn,
                    log1.idDesenhos, produto_desenho.descricao, log1.referencia,
                    log1.fornecedor_original, log1.equipamento, log1.subconjunto,
                    log1.modelo, log1.versao, log1.idUserHis, log1.empresa, log1.versaoEmpresa,
                    log1.data_alteracaoHis, log1.imagemDwg, desenhos.nomeArquivoDwg,
                    log1.observacao, desenhos.caminhoDwg, usuarios.nome as nome_user
            FROM produto_history log1
                LEFT JOIN desenhos ON desenhos.idPn = log1.idPn
                LEFT JOIN produto_desenho ON produto_desenho.idPn = desenhos.idPn
                LEFT JOIN usuarios ON usuarios.idUsuarios = log1.idUserHis
            WHERE produto_desenho.`$field` = ?
            ORDER BY log1.idProdutosHis DESC

        ";

        $resultado = $this->db->query($query, [$this->db->escape_str($search)])->result();
        
        return $resultado;

    }

    public function verifica_versao_empresa($idProdutos, $idClientes, $versao){

        $query = "

            SELECT idPn, versaoEmpresa, data_master
            FROM produto_desenho
            WHERE idProdutos = ? AND
                  idClientes = ?
            ORDER BY idPn DESC

        ";

        $verifica = $this->db->query($query, [(int)$idProdutos, (int)$idClientes])->result();

        if(empty($verifica) || $verifica == "" || $verifica == null){

            $resultado = 0;

        }else{

            $resultado = $verifica[0];

        }
        
        return $resultado;

    }

    public function getDesenhoCorte($idPn){

        $query = "SELECT * FROM desenho_corte WHERE idPn = ?";

        return $this->db->query($query, [(int)$idPn])->result();

    }

    public function getLisaDesenhoCorte($idPn){

        $query = "
            SELECT DISTINCT(desenho_corte.idCorte), desenho_corte.idPn, desenho_corte.imagem, desenho_corte.descricao_corte,
                    desenho_corte.observacao_corte, usuarios.nome, desenho_corte.caminho
            FROM desenho_corte
                    LEFT JOIN produto_history ON produto_history.idPn = desenho_corte.idPn
                    LEFT JOIN usuarios ON usuarios.idUsuarios = produto_history.idUserHis
            WHERE desenho_corte.idPn = ? AND
            produto_history.idCorte <> ''
        ";

        return $this->db->query($query, [(int)$idPn])->result();

    }

    public function getListaPNDesenho($pn){
        $query = "SELECT * FROM `anexo_desenho` WHERE tipo = 'DESENHO' and anexo_desenho.idOs = (SELECT os.idOs FROM os JOIN orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item JOIN produtos on produtos.idProdutos = orcamento_item.idProdutos join anexo_desenho on anexo_desenho.idOs = os.idOs and anexo_desenho.tipo = 'DESENHO' WHERE produtos.pn = ? and os.idStatusOs in (6,89) and os.unid_execucao = 2 order by os.data_abertura_real desc LIMIT 1) ";
        return $this->db->query($query, [$this->db->escape_str($pn)])->result();
    }
    public function getListaDesenhoByIdOs($idOs){
        $query = "SELECT * FROM `anexo_desenho` WHERE idos = ?";
        return $this->db->query($query, [(int)$idOs])->result();
    }
    public function getDesenhoByIdOs($idOs){
        $query = "SELECT * FROM `anexo_desenho` WHERE idos = ? and tipo = 'DESENHO'";
        return $this->db->query($query, [(int)$idOs])->row();
    }
    public function getDesenhoRepositoryByIdProduto($idProdutos){
        $query = "SELECT * FROM desenhos WHERE idProdutos = ? LIMIT 1";
        return $this->db->query($query, [(int)$idProdutos])->row();
    }
}