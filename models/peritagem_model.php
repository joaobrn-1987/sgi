<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Peritagem_model extends CI_Model {

	function __construct() {
        parent::__construct();
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

    function insert_batch($table,$data){
        if($this->db->insert_batch($table, $data)){
            return true;
        }
        return false;
    }

    function getEscopoById($id){
        $id = (int) $id;
        $query = "SELECT * FROM servico_escopo WHERE idServicoEscopo = $id";
        return $this->db->query($query)->row();
    }
    function getEscopoItensByIdEscopo($id){
        $id = (int) $id;
        $query = "SELECT servico_escopo_itens.*, produtos.*, classe_item_escopo.descricaoClasse,classe_item_escopo.nomeClasse FROM servico_escopo_itens join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto WHERE idServicoEscopo = $id and deletado = 0 order by idServicoEscopoItens asc";
        return $this->db->query($query)->result();
    }
    function getOnlyEscopoItensByIdEscopo($id){
        $id = (int) $id;
        $query = "SELECT * FROM servico_escopo_itens WHERE idServicoEscopo = $id order by idServicoEscopoItens asc";
        return $this->db->query($query)->result();
    }
    function getEscopoItemByIdEscopoItem($idEscopoItem){
        $idEscopoItem = (int) $idEscopoItem;
        $query = "SELECT * FROM servico_escopo_itens WHERE idServicoEscopoItens = $idEscopoItem";
        return $this->db->query($query)->row();
    }
    function getEscopoItemByIdOrcEscopoItem($idEscopoItem){
        $idEscopoItem = (int) $idEscopoItem;
        $query = "SELECT servico_escopo_itens.* FROM servico_escopo_itens join orc_servico_escopo_itens on orc_servico_escopo_itens.idServicoEscopoItens = servico_escopo_itens.idServicoEscopoItens WHERE idOrcServicoEscopoItens = $idEscopoItem";
        return $this->db->query($query)->row();
    }
    function getTypeClass(){
        $query = "SELECT * FROM classe_item_escopo";
        return $this->db->query($query)->result();
    }
    function autoCompleteItemServico($q){
        $this->db->select('*');
        $this->db->limit(5);
        $this->db->like('descricaoServicoItens', $q);
        $this->db->group_by('descricaoServicoItens');
        $query = $this->db->get('servico_escopo_itens');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['descricaoServicoItens']);
            }
            echo json_encode($row_set);
        }
    }
    function getEscopoByIdProduto($id,$serv){
        $id = (int) $id;
        $serv_escaped = $this->db->escape($serv);
        $query = "SELECT * FROM servico_escopo WHERE idProduto = $id and tipoServico = $serv_escaped LIMIT 1";
        return $this->db->query($query)->row();
    }
    function getEscopoByTipoServico($serv,$id){
        $serv_escaped = $this->db->escape($serv);
        $ids = is_array($id) ? $id : explode(',', $id);
        $ids_int = implode(',', array_filter(array_map('intval', $ids)));
        if (empty($ids_int)) $ids_int = '0';
        $query = "SELECT * FROM servico_escopo WHERE tipoServico = $serv_escaped and idServicoEscopo not in($ids_int)";
        return $this->db->query($query)->result();
    }
    function getEscopoOrcByidEscopoAndIdOrcItem($idEscopo,$idOrcamento){
        $idEscopo = (int) $idEscopo;
        $idOrcamento = (int) $idOrcamento;
        $query = "SELECT * FROM orc_servico_escopo WHERE idServicoEscopo = $idEscopo and idOrcItem = $idOrcamento";
        return $this->db->query($query)->row();
    }
    function getEscopoItensOrcByidEscopoAndIdOrcItem($idEscopo){
        $idEscopo = (int) $idEscopo;
        $query = "SELECT * FROM orc_servico_escopo_itens WHERE idOrcServicoEscopo = $idEscopo";
        return $this->db->query($query)->result();
    }
    function getEscopoItensOrcByidEscopoAndIdOrcItemAtivo($idEscopo){
        $idEscopo = (int) $idEscopo;
        $query = "SELECT * FROM orc_servico_escopo_itens WHERE idOrcServicoEscopo = $idEscopo and ativo = 1";
        return $this->db->query($query)->result();
    }
    function getEscopoItensOrcByidEscopoItem($idEscopo){
        $idEscopo = (int) $idEscopo;
        $query = "SELECT * FROM orc_servico_escopo_itens WHERE idOrcServicoEscopoItens = $idEscopo";
        return $this->db->query($query)->row();
    }
    function desativarEscoposOrcItem($idOrcItem,$idOrcServEsc){
        $idOrcItem = (int) $idOrcItem;
        $ids = is_array($idOrcServEsc) ? $idOrcServEsc : explode(',', $idOrcServEsc);
        $ids_int = implode(',', array_filter(array_map('intval', $ids)));
        if (empty($ids_int)) $ids_int = '0';
        $query = "UPDATE `orc_servico_escopo` SET `ativo`= 0 WHERE idOrcItem = $idOrcItem and idOrcServicoEscopo not in ($ids_int)";
        return $this->db->query($query);
    }
    function ativarEscoposOrcItem($idOrcServEsc){
        $ids = is_array($idOrcServEsc) ? $idOrcServEsc : explode(',', $idOrcServEsc);
        $ids_int = implode(',', array_filter(array_map('intval', $ids)));
        if (empty($ids_int)) return false;
        $query = "UPDATE `orc_servico_escopo` SET `ativo`= 1 WHERE idOrcServicoEscopo in ($ids_int)";
        return $this->db->query($query);
    }
    function getOrcEscopoActiveByOrcItem($idOrcItem){
        $idOrcItem = (int) $idOrcItem;
        $query = "SELECT * FROM orc_servico_escopo join status_peritagem on status_peritagem.idStatusPeritagem = orc_servico_escopo.idStatusPeritagem WHERE idOrcItem = $idOrcItem and ativo = 1";
        return $this->db->query($query)->row();
    }

    function getOrcEscopoActiveByidOrc($idOrc){
        $idOrc = (int) $idOrc;
        $query = "SELECT * FROM orc_servico_escopo join status_peritagem on status_peritagem.idStatusPeritagem = orc_servico_escopo.idStatusPeritagem join orcamento_item on orcamento_item.idOrcamento_item = orc_servico_escopo.idOrcItem WHERE orcamento_item.idOrcamentos = $idOrc and ativo = 1";
        return $this->db->query($query)->result();
    }
    function getOrcEscopoActiveByOrcItem2($idOrcItem){
        $idOrcItem = (int) $idOrcItem;
        $query = "SELECT * FROM orc_servico_escopo join servico_escopo on servico_escopo.idServicoEscopo = orc_servico_escopo.idServicoEscopo join status_peritagem on status_peritagem.idStatusPeritagem = orc_servico_escopo.idStatusPeritagem WHERE idOrcItem = $idOrcItem and ativo = 1";
        return $this->db->query($query)->row();
    }
    function getOrcEscopo($idOrcEsc){
        $idOrcEsc = (int) $idOrcEsc;
        $query = "SELECT * FROM orc_servico_escopo WHERE idOrcServicoEscopo = $idOrcEsc and ativo = 1";
        return $this->db->query($query)->row();
    }
    function getOrcEscopo2($idOrcEsc){
        $idOrcEsc = (int) $idOrcEsc;
        $query = "SELECT * FROM orc_servico_escopo join servico_escopo on servico_escopo.idServicoEscopo = orc_servico_escopo.idServicoEscopo WHERE idOrcServicoEscopo = $idOrcEsc and ativo = 1";
        return $this->db->query($query)->row();
    }
    function aguardandoPeritagem($tipo){
        $query =  'SELECT orc_servico_escopo.idOrcServicoEscopo, orcamento_item.idOrcamento_item,orcamento_item.statusDesenho, orcamento_item.descricao_item, status_peritagem.descricaoPeritagem,status_peritagem.perm, orc_servico_escopo.data_cadastro FROM `orc_servico_escopo` join servico_escopo on servico_escopo.idServicoEscopo = orc_servico_escopo.idServicoEscopo join orcamento_item on orcamento_item.idOrcamento_item = orc_servico_escopo.idOrcItem JOIN status_peritagem on status_peritagem.idStatusPeritagem = orc_servico_escopo.idStatusPeritagem WHERE orc_servico_escopo.ativo = 1 order by orc_servico_escopo.idOrcItem asc';
        return $this->db->query($query)->result();
    }

    function aguardandoPeritagem2($tipo,$where=''){
        if(empty($where)){
            $where = " and orc_servico_escopo.idStatusPeritagem in (2,7) ";
        }
        $query =  "SELECT orc_servico_escopo.idOrcServicoEscopo, GROUP_CONCAT(orcamento_item.idOrcamento_item SEPARATOR ';') as idOrcamento_item,
            GROUP_CONCAT(produtos.pn SEPARATOR ';') as pn,
            GROUP_CONCAT(orcamento_item.descricao_item SEPARATOR ';') as descricao_item,
            GROUP_CONCAT(vendedores.nomeVendedor SEPARATOR ';') as nomeVendedor, orcamento.*, clientes.* 
            FROM `orc_servico_escopo` 
            join servico_escopo on servico_escopo.idServicoEscopo = orc_servico_escopo.idServicoEscopo 
            join orcamento_item on orcamento_item.idOrcamento_item = orc_servico_escopo.idOrcItem 
            JOIN status_peritagem on status_peritagem.idStatusPeritagem = orc_servico_escopo.idStatusPeritagem 
            join orcamento on orcamento.idOrcamentos = orcamento_item.idOrcamentos 
            join clientes on clientes.idClientes = orcamento.idClientes 
            join produtos on produtos.idProdutos = orcamento_item.idProdutos 
            join vendedores on vendedores.idVendedor = orcamento.idVendedor 
            left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item 
            WHERE orc_servico_escopo.ativo = 1 $where and orcamento_item.tipoProd in ($tipo) and orcamento.idstatusOrcamento != 12 group by orcamento.idOrcamentos order by orc_servico_escopo.idOrcItem asc";
        return $this->db->query($query)->result();
    }
    function itensPeritagemDesenho($id){
        $id = (int) $id;
        $query =  "SELECT * FROM orc_servico_escopo_itens join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto WHERE idOrcServicoEscopo = $id and orc_servico_escopo_itens.ativo = 1 and servico_escopo_itens.idProduto is not null GROUP BY servico_escopo_itens.idProduto
            UNIon
            SELECT * FROM orc_servico_escopo_itens join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto WHERE idOrcServicoEscopo = $id and orc_servico_escopo_itens.ativo = 1 and servico_escopo_itens.idProduto is null ";
        return $this->db->query($query)->result();
    }
    function itensPeritagem($idEscopo){
        $idEscopo = (int) $idEscopo;
        $query =  "SELECT * FROM orc_servico_escopo_itens join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto WHERE idOrcServicoEscopo = $idEscopo and orc_servico_escopo_itens.ativo = 1 order by servico_escopo_itens.idServicoEscopoItens asc";
        return $this->db->query($query)->result();
    }
    function itensPeritagemIdProduto($idEscopo,$idProduto){
        $idEscopo = (int) $idEscopo;
        $idProduto = (int) $idProduto;
        $query =  "SELECT * FROM orc_servico_escopo_itens join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto WHERE idOrcServicoEscopo = $idEscopo and orc_servico_escopo_itens.ativo = 1 and servico_escopo_itens.idProduto = $idProduto order by servico_escopo_itens.idServicoEscopoItens asc";
        return $this->db->query($query)->result();
    }
    function itensPeritagem2($idEscopo){
        $idEscopo = (int) $idEscopo;
        $query =  "SELECT orc_servico_escopo_itens.*,classe_item_escopo.descricaoClasse,classe_item_escopo.nomeClasse, produtos.*, servico_escopo_itens.idServicoEscopo, servico_escopo_itens.tipoCampo, servico_escopo_itens.descricaoServicoItens, servico_escopo_itens.idClasse FROM orc_servico_escopo_itens join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto WHERE idOrcServicoEscopo = $idEscopo order by servico_escopo_itens.idServicoEscopoItens asc";
        return $this->db->query($query)->result();
    }
    function itensPeritagemOrcamento($idEscopo){
        $idEscopo = (int) $idEscopo;
        $query =  "SELECT servico_escopo.nomeServicoEscopo,classe_item_escopo.idClasse,classe_item_escopo.descricaoClasse,classe_item_escopo.nomeClasse,servico_escopo.*, servico_escopo_itens.descricaoServicoItens,orc_servico_escopo_itens.*,produtos.*,orc_servico_escopo.idOrcServicoEscopo,orc_servico_escopo.idServicoEscopo,orc_servico_escopo.idOrcItem,orc_servico_escopo.idStatusPeritagem FROM servico_escopo_itens join servico_escopo on servico_escopo.idServicoEscopo = servico_escopo_itens.idServicoEscopo join orc_servico_escopo on orc_servico_escopo.idServicoEscopo = servico_escopo.idServicoEscopo join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto join orc_servico_escopo_itens on orc_servico_escopo_itens.idOrcServicoEscopo = orc_servico_escopo.idOrcServicoEscopo and orc_servico_escopo_itens.idServicoEscopoItens =servico_escopo_itens.idServicoEscopoItens where orc_servico_escopo.idOrcServicoEscopo = $idEscopo order by servico_escopo_itens.idServicoEscopoItens asc";
        return $this->db->query($query)->result();
    }
    function getLaudoFotograficoByIdOrcItem($idOrcItem){
        $idOrcItem = (int) $idOrcItem;
        $query =  "SELECT * FROM anexo_laudo WHERE idOrc_item = $idOrcItem and deletado = 0";
        return $this->db->query($query)->result();
    }
    function getLaudoFotograficoByIdOrcItemAndDetails($idOrcItem){
        $idOrcItem = (int) $idOrcItem;
        $query =  "SELECT * FROM anexo_laudo left join orc_servico_escopo_itens on orc_servico_escopo_itens.idOrcServicoEscopoItens = anexo_laudo.idOrcServicoEscopoItens left join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto WHERE idOrc_item = $idOrcItem and anexo_laudo.deletado = 0";
        return $this->db->query($query)->result();
    }
    function getLaudoFotograficoByIdOrcItemAndIdOrcServEscopo($idOrcItem,$idOrcServEscopo){
        $idOrcItem = (int) $idOrcItem;
        $idOrcServEscopo = (int) $idOrcServEscopo;
        $query =  "SELECT * FROM anexo_laudo WHERE idOrc_item = $idOrcItem and idOrcServicoEscopoItens = $idOrcServEscopo and deletado = 0";
        return $this->db->query($query)->result();
    }
    function getLaudoByIdLaudo($idLaudo){
        $idLaudo = (int) $idLaudo;
        $query =  "SELECT * FROM anexo_laudo WHERE idAnexoLaudo = $idLaudo";
        return $this->db->query($query)->row();
    }
    function itensPeritagemSelected($idEscopo){
        $idEscopo = (int) $idEscopo;
        $query =  "SELECT * FROM orc_servico_escopo_itens join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto WHERE idOrcServicoEscopo = $idEscopo and selected = 1 order by servico_escopo_itens.idServicoEscopoItens asc";
        return $this->db->query($query)->result();
    }
    function itensPeritagemSelected2($idEscopo){
        $idEscopo = (int) $idEscopo;
        $query =  "SELECT * FROM orc_servico_escopo_itens join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto WHERE idOrcServicoEscopo = $idEscopo and selected = 1 and orc_servico_escopo_itens.ativo = 1 order by servico_escopo_itens.idServicoEscopoItens asc";
        return $this->db->query($query)->result();
    }
    function getStatusPeritagem(){
        $query =  "SELECT * FROM status_peritagem order by idStatusPeritagem asc";
        return $this->db->query($query)->result();
    }
    function getEscopoByIdProdutoAndTipoProd($tipoServ,$prod){
        $tipoServ_escaped = $this->db->escape($tipoServ);
        $prod = (int) $prod;
        $query = "SELECT * FROM servico_escopo join servico_escopo_itens on servico_escopo_itens.idServicoEscopo = servico_escopo.idServicoEscopo join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto where servico_escopo.tipoServico = $tipoServ_escaped and servico_escopo.idProduto = $prod order by produtos.pn desc,servico_escopo_itens.idServicoEscopoItens asc";
        return $this->db->query($query)->result();
    }
    function getCatalogos(){
        $query = "SELECT * FROM catalogo_produto join produtos on produtos.idProdutos = catalogo_produto.idProduto join usuarios on usuarios.idUsuarios = catalogo_produto.idUsuario";
        return $this->db->query($query)->result();
    }
    function getCatalogoById($id){
        $id = (int) $id;
        $query = "SELECT * FROM catalogo_produto join produtos on produtos.idProdutos = catalogo_produto.idProduto join usuarios on usuarios.idUsuarios = catalogo_produto.idUsuario WHERE catalogo_produto.idCatalogoProduto = $id";
        return $this->db->query($query)->row();
    }
    function getCatalogoItensByIdCatalogo($id){
        $id = (int) $id;
        $query = "SELECT * FROM catalogo_produto_itens join produtos on produtos.idProdutos = catalogo_produto_itens.idProduto join usuarios on usuarios.idUsuarios = catalogo_produto_itens.idUsuario WHERE catalogo_produto_itens.idCatalogoProduto = $id";
        return $this->db->query($query)->result();
    }
    function getCatalogoAtivosByIdProduto($id){
        $id = (int) $id;
        $query = "SELECT * FROM catalogo_produto join produtos on produtos.idProdutos = catalogo_produto.idProduto where catalogo_produto.idProduto = $id and catalogo_produto.ativo = 1";
        return $this->db->query($query)->result();
    }
    function getCatalogoAtivosByIdProduto2($id){
        $id = (int) $id;
        $query = "SELECT * FROM catalogo_produto join produtos on produtos.idProdutos = catalogo_produto.idProduto where catalogo_produto.idProduto = $id and catalogo_produto.ativo = 1 LIMIT 1";
        return $this->db->query($query)->row();
    }
    function getCatalogoItensAtivosByIdProduto($id){
        $id = (int) $id;
        $query = "SELECT * FROM catalogo_produto_itens join produtos on produtos.idProdutos = catalogo_produto_itens.idProduto join usuarios on usuarios.idUsuarios = catalogo_produto_itens.idUsuario WHERE catalogo_produto_itens.idCatalogoProduto = $id and catalogo_produto_itens.ativo = 1";
        return $this->db->query($query)->result();
    }
    function getOrcEscopoItemByIdEscopoItemAndIdOrcItem($itemServ,$orcItem){
        $itemServ = (int) $itemServ;
        $orcItem = (int) $orcItem;
        $query = "SELECT * FROM orc_servico_escopo join orc_servico_escopo_itens on orc_servico_escopo_itens.idOrcServicoEscopo = orc_servico_escopo.idOrcServicoEscopo WHERE orc_servico_escopo.idOrcItem = $orcItem and orc_servico_escopo_itens.idServicoEscopoItens = $itemServ and orc_servico_escopo.ativo = 1 LIMIT 1";
        return $this->db->query($query)->row();
    }
    function getOrcEscopoItemByIdOs($idOs){
        $idOs = (int) $idOs;
        $query = "SELECT orc_servico_escopo.*, orc_servico_escopo_itens.*, servico_escopo_itens.*,produtos.*,classe_item_escopo.* FROM orc_servico_escopo join orc_servico_escopo_itens on orc_servico_escopo_itens.idOrcServicoEscopo = orc_servico_escopo.idOrcServicoEscopo join orcamento_item on orcamento_item.idOrcamento_item = orc_servico_escopo.idOrcItem join os on os.idOrcamento_item = orcamento_item.idOrcamento_item join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto join classe_item_escopo on classe_item_escopo.idClasse = servico_escopo_itens.idClasse where os.idOs = $idOs";
        return $this->db->query($query)->result();
    }
    function getCatalogoItem($id){
        $id = (int) $id;
        $query = "SELECT * FROM catalogo_produto_itens where idCatalogoProdutoItens = $id";
        return $this->db->query($query)->row();
    }

    function getAnexoByIdProdutoLIMIT1($id){
        $id = (int) $id;
        $query = "SELECT anexo_desenho.* FROM `anexo_desenho` left join orcamento_item on orcamento_item.idOrcamento_item = anexo_desenho.idOrcamentos_item left join os on os.idOs = anexo_desenho.idOs where statusAnexo = 2 and (orcamento_item.statusDesenho = 3 or os.statusDesenho = 3) and idProduto = $id and anexo_desenho.tipo = 'DESENHO' LIMIT 1";
        return $this->db->query($query)->row();
    }
    function getAnexoByIdOsSub($id){
        $id = (int) $id;
        $query = "SELECT * FROM anexo_desenho WHERE idOsSub = $id";
        return $this->db->query($query)->result();
    }
    function getAnexoByIdOrcServItem ($id){
        $id = (int) $id;
        $query = "SELECT * FROM anexo_desenho WHERE idOrcServicoEscopoItens = $id";
        return $this->db->query($query)->result();
    }
    function getEscopoItensByIdEscopoAndIdProduto($idEscopo,$idProduto){
        $idEscopo = (int) $idEscopo;
        $idProduto = (int) $idProduto;
        $query = "SELECT * FROM servico_escopo_itens WHERE idServicoEscopo = $idEscopo and idProduto = $idProduto";
        return $this->db->query($query)->result();
    }
    function getInfoOrcServEscItem($idOrcServitem){
        $idOrcServitem = (int) $idOrcServitem;
        $query = "SELECT orc_servico_escopo_itens.*, produtos.*, orcamento_item.*, servico_escopo_itens.* FROM `orc_servico_escopo_itens` join orc_servico_escopo on orc_servico_escopo.idOrcServicoEscopo = orc_servico_escopo_itens.idOrcServicoEscopo join orcamento_item on orcamento_item.idOrcamento_item = orc_servico_escopo.idOrcItem join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto WHERE orc_servico_escopo_itens.idOrcServicoEscopoItens = $idOrcServitem ";
        return $this->db->query($query)->row();
    }
    function  getCatalogoItensByIdProdutoAndIdCatalogo($idProduto,$idCatalogo){
        $idProduto = (int) $idProduto;
        $idCatalogo = (int) $idCatalogo;
        $query = "SELECT * FROM catalogo_produto_itens WHERE idCatalogoProduto = $idCatalogo and idProduto = $idProduto LIMIT 1";
        return $this->db->query($query)->row();
    }

    function getProdutosByidCatalogoItens($idCatalogoItens){
        $idCatalogoItens = (int) $idCatalogoItens;
        $query = "SELECT * FROM produtos join catalogo_produto_itens on catalogo_produto_itens.idProduto = produtos.idProdutos WHERE catalogo_produto_itens.idCatalogoProdutoItens = $idCatalogoItens";
        return $this->db->query($query)->row();
    }

    function getServicoItensByIdOrcServicoEscopoItens($id){
        $id = (int) $id;
        $query = "SELECT * FROM servico_escopo_itens join orc_servico_escopo_itens on orc_servico_escopo_itens.idServicoEscopo = servico_escopo_itens.idServicoEscopo where orc_servico_escopo_itens.idOrcEscopoItens = $id";
        return $this->db->query($query)->result();
    }

    function getEscopoItensByIdOrcServItens($id){
        $id = (int) $id;
        $query = "SELECT servico_escopo_itens.* join orc_servico_escopo_itens on orc_servico_escopo_itens.idServicoEscopoItens = servico_escopo_itens.idServicoEscopoItens WHERE orc_servico_escopo_itens.idOrcServicoEscopoItens = $id";
        return $this->db->query($query)->row();
    }

    function getEscopoItensByIdEscopoItensAndIdProduto($idEscopoItem,$idProduto){
        $idEscopoItem = (int) $idEscopoItem;
        $idProduto = (int) $idProduto;
        $query = "SELECT servico_escopo_itens.* WHERE idServicoEscopOitens = $idEscopoItem and idProduto = $idProduto";
        return $this->db->query($query)->result();
    }

    function getOrcServicoItensByIdOrcEscopoByIdProduto($idOrcServItens, $idProduto){
        $idOrcServItens = (int) $idOrcServItens;
        $idProduto = (int) $idProduto;
        $query = "SELECT orc_servico_escopo_itens.* from orc_servico_escopo_itens join servico_escopo_itens on servico_escopo_itens.idServicoEscopoitens = orc_servico_escopo_itens.idServicoEscopOitens where servico_escopo_itens.idProduto = $idProduto and orc_servico_escopo_itens.idOrcServicoEscopo = $idOrcServItens";
        return $this->db->query($query)->result();
    }

    function getTipoServicoByIdOrcItem($idOrcServItens){
        $idOrcServItens = (int) $idOrcServItens;
        $query = "SELECT * FROM tiposservico_servitem join tiposservico on tiposservico.idTiposServico = tiposservico_servitem.idTiposServico WHERE idOrcServicoEscopoItem = $idOrcServItens";
        return $this->db->query($query)->result();
    }

    function getInfoTipoServico($id){
        $id = (int) $id;
        $query = "SELECT tiposservico.*,tiposservico_servitem.idTiposservico_servitem, servico_escopo_itens.*,orcamento_item.idOrcamentos, orcamento_item.descricao_item
        FROM tiposservico_servitem
        join tiposservico on tiposservico.idTiposServico = tiposservico_servitem.idTiposServico
        join orc_servico_escopo_itens on orc_servico_escopo_itens.idOrcServicoEscopoItens = tiposservico_servitem.idOrcServicoEscopoItem
        join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens
        join orc_servico_escopo on orc_servico_escopo.idOrcServicoEscopo = orc_servico_escopo_itens.idOrcServicoEscopo
        join orcamento_item on orcamento_item.idOrcamento_item = orc_servico_escopo.idOrcItem where tiposservico_servitem.idTiposservico_servitem = $id";
        return $this->db->query($query)->row();
    }

    function getInfoOrcServEscByIdOrcamentoItem($idOrcItem){
        $idOrcItem = (int) $idOrcItem;
        $query = "SELECT servico_escopo_itens.*, produtos.*, orc_servico_escopo_itens.* FROM orc_servico_escopo join orc_servico_escopo_itens on orc_servico_escopo_itens.idOrcServicoEscopo = orc_servico_escopo.idOrcServicoEscopo join orcamento_item on orcamento_item.idOrcamento_item = orc_servico_escopo.idOrcItem join servico_escopo_itens on servico_escopo_itens.idServicoEscopoItens = orc_servico_escopo_itens.idServicoEscopoItens left join produtos on produtos.idProdutos = servico_escopo_itens.idProduto where orc_servico_escopo.idOrcItem = $idOrcItem and orc_servico_escopo.ativo = 1";
        return $this->db->query($query)->result();
    }

    function getItemCatalogoItemByIdProdutoByIdCatalogo($idProduto,$idCatalogo){
        $idProduto = (int) $idProduto;
        $idCatalogo = (int) $idCatalogo;
        $query = "SELECT * FROM catalogo_produto_itens WHERE catalogo_produto_itens.idProduto = $idProduto and catalogo_produto_itens.idCatalogoProduto = $idCatalogo";
        return $this->db->query($query)->result();
    }

    function getAllEscopoByTipoProd(){
        $query = "SELECT * FROM servico_escopo WHERE tipoServico = \"cil\"";
        return $this->db->query($query)->result();
    }

    function getEscopoSePreenchido($idEscopo){
        $idEscopo = (int) $idEscopo;
        $query = "SELECT orc_servico_escopo_itens.* FROM orc_servico_escopo_itens join orc_servico_escopo on orc_servico_escopo.idOrcServicoEscopo = orc_servico_escopo_itens.idOrcServicoEscopo WHERE selected = 1 and orc_servico_escopo.idServicoEscopo = $idEscopo group by orc_servico_escopo.idServicoEscopo";
        return $this->db->query($query)->result();
    }

    function getAllOrcEscopoByIdEscopo($idEscopo){
        $idEscopo = (int) $idEscopo;
        $query = "SELECT * FROM orc_servico_escopo WHERE idServicoEscopo = $idEscopo";
        return $this->db->query($query)->result();
    }

    function getEscopoByIdEscopoItem($idItens){
        $idItens = (int) $idItens;
        $query = "SELECT servico_escopo.* FROM servico_escopo JOIN servico_escopo_itens on servico_escopo_itens.idServicoEscopo = servico_escopo.idServicoEscopo WHERE servico_escopo_itens.idServicoEscopoItens = $idItens";
        return $this->db->query($query)->row();
    }

}