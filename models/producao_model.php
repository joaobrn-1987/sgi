<?php
class Producao_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function getAllMotivosParada(){   
        $this->db->from('motivos_parada');
        $query = $this->db->get();
        
        $result =  $query->result();
        return $result;     
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
    function getAllMotivosPerda(){
        $this->db->from('motivos_perda');
        $query = $this->db->get();
        
        $result =  $query->result();
        return $result;             
    }
    function autoCompleteOnlyPN($q){

        $this->db->select('*');
        $this->db->limit(10);
        $this->db->like('pn', $q);
        $query = $this->db->get('produtos');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['pn'],'id'=>$row['idProdutos'],'descricao'=>$row['descricao'],'pn'=>$row['pn']);
            }
			
            echo json_encode($row_set);
        }
    }
    function autoCompleteOnlyOS($q){

        $this->db->select('*');
        $this->db->limit(10);
        $this->db->like('idOs', $q);
        $query = $this->db->get('os');
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['idOs'],'id'=>$row['idOs']);
            }
			
            echo json_encode($row_set);
        }
    }


    function autoCompleteIdOrcamento($q){
        $query2 = "SELECT * FROM controle_etapa JOIN produtos.idProdutos = controle_etapa.idProduto WHERE idOrcamento = $q";
        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->pn,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
            }
			
            echo json_encode($row_set);
        }
        
    }
    function autoCompleteidOs($q){
        $query2 = "SELECT * FROM controle_etapa JOIN produtos.idProdutos = controle_etapa.idProduto WHERE idOs = $q";
        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->pn,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
            }
			
            echo json_encode($row_set);
        }

    }
    function autoCompletePN($q){
        $query2 = "SELECT * FROM controle_etapa JOIN produtos.idProdutos = controle_etapa.idProduto WHERE produtos.pn = $q";
        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->pn,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
            }
			
            echo json_encode($row_set);
        }
    }
    function autoCompleteDescricao($q){
        $query2 = "SELECT * FROM controle_etapa JOIN produtos.idProdutos = controle_etapa.idProduto WHERE controle_etapa.descricaoItem like '%$q%'";
        $query = $this->db->query($query2)->result();
        if(count($query) > 0){
            foreach ($query as $row){
                $row_set[] = array('label'=>$row->pn,'id'=>$row->idProdutos,'produtos'=>$row->descricao,'pn'=>$row->pn,'referencia'=>$row->referencia,'qtdEstt'=>$row->qtdEstt);
            }
			
            echo json_encode($row_set);
        }
    }


    function findProdutoForPn($pn){
        $this->db->select('idProdutos');
        $this->db->limit(1);
        $this->db->where('pn = "'.$pn.'"');
        $query = $this->db->get('produtos');
        return $query->row();
    }    
    function insertHoramaquina($data){
        $this->db->insert('horas_maquinas', $data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("horas_maquinas");
		}		
		return FALSE; 
    }
    function insertHoraMaqParada($data){
        $this->db->insert('horas_maq_parada', $data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("horas_maq_parada");
		}		
		return FALSE; 
    }
    function insertMaqPerda($data){
        $this->db->insert('maq_perda', $data);
        if ($this->db->affected_rows() == '1')
		{
            return $this->db->insert_id("maq_perda");
		}		
		return FALSE; 
    }
    function getHoraMaqId($id){
        $this->db->select('horas_maquinas.*,produtos.pn');
        $this->db->join('produtos','produtos.idProdutos = horas_maquinas.idProduto');
        $this->db->where('horas_maquinas.idHorasMaquinas = '.$id);
        $query = $this->db->get('horas_maquinas');
        return $query->row();
    }
    function getHoraMaqParadaForIdHrMaq($id){
        $this->db->select('*');
        $this->db->where('idHorasMaquinas = '.$id);
        $query = $this->db->get('horas_maq_parada');
        $result =  $query->result();
        return $result;
    }
    function getHoraMaqParadaForIdMotParadaAndIdHrMaq($idMotPa,$id){
        $this->db->select('*');
        $this->db->limit(1);
        $this->db->where('idHorasMaquinas = '.$id.' and idMotivosParada = '.$idMotPa);
        $query = $this->db->get('horas_maq_parada');
        $result =  $query->row();
        return $result;
    }
    function getMaqPerdaForIdHrMaq($id){
        $this->db->select('*');
        $this->db->where('idHorasMaquina = '.$id);
        $query = $this->db->get('maq_perda');
        $result =  $query->result();
        return $result;
    }
    function getMaqPerdaForIdMotPerdaIdHrMaq($idMotPer,$id){
        $this->db->select('*');
        $this->db->where('idHorasMaquina = '.$id.' and idMotivosPerda = '.$idMotPer);
        $query = $this->db->get('maq_perda');
        $result =  $query->row();
        return $result;
    }
    function getAllHorasMaquinas($idHorasMaquinas = ''){
        if(!empty($idHorasMaquinas)){
            $where = ' and idHorasMaquinas not in ('.$idHorasMaquinas.')';
        }else{
            $where = "";
        }
        $query = "SELECT horas_maquinas.*, produtos.pn, maquinas.descricao
        FROM horas_maquinas 
        JOIN produtos on produtos.idProdutos = horas_maquinas.idProduto 
        JOIN maquinas on maquinas.idMaquinas = horas_maquinas.idMaquina
        WHERE (horaEntradaFabricacao is null or horaSaidaFabricacao is null or quantidadeFabricada is null) $where";
        return $this->db->query($query)->result(); 
    }
    function getHistoricoHoraMaquinaCompletado(){
        $query = "SELECT horas_maquinas.*, produtos.pn, maquinas.descricao
        FROM horas_maquinas 
        JOIN produtos on produtos.idProdutos = horas_maquinas.idProduto 
        JOIN maquinas on maquinas.idMaquinas = horas_maquinas.idMaquina
        WHERE ( horaEntradaFabricacao is not null and horaSaidaFabricacao is not null and quantidadeFabricada is not null) ";
        return $this->db->query($query)->result(); 
    }
    function getHoraMaqForIdOs($idOs){
        $this->db->select('horas_maquinas.*, produtos.pn, maquinas.descricao');
        $this->db->join('produtos','produtos.idProdutos = horas_maquinas.idProduto');
        $this->db->join('maquinas','maquinas.idMaquinas = horas_maquinas.idMaquina');
        $this->db->where('idOs = '.$idOs);
        $query = $this->db->get('horas_maquinas');
        $result =  $query->result();
        return $result;
    }
    function getHoraMaqForIdOsFinalizado($idOs){
        $this->db->select('horas_maquinas.*, produtos.pn, maquinas.descricao');
        $this->db->join('produtos','produtos.idProdutos = horas_maquinas.idProduto');
        $this->db->join('maquinas','maquinas.idMaquinas = horas_maquinas.idMaquina');
        $this->db->where('idOs = '.$idOs.' and (horaSaidaFabricacao is not null and horaEntradaFabricacao is not null)');
        $query = $this->db->get('horas_maquinas');
        $result =  $query->result();
        return $result;
    }
    function getRelatorio($dataInicio,$dataFim){
        $query = "SELECT produtos.idProdutos,
         produtos.pn,
         maquinas.nome,
         maquinas.descricao,
         horas_maquinas.horaEntradaFabricacao,
         horas_maquinas.idMaquina,
         horas_maquinas.quantidadeFabricada,
         horas_maquinas.horaSaidaFabricacao 
         FROM `horas_maquinas` 
         join produtos on produtos.idProdutos = horas_maquinas.idProduto 
         join maquinas on maquinas.idMaquinas = horas_maquinas.idMaquina 
         WHERE horas_maquinas.horaEntradaFabricacao between '$dataInicio' and '$dataFim' 
         and horas_maquinas.horaSaidaFabricacao between '$dataInicio' and '$dataFim'";
         $result =  $this->db->query($query)->result(); 
         return $result;
    }
    function getCustoInsumoPorPN($id){
        $query = "SELECT (select sum(pedido_comprasitens.valor_unitario*distribuir_os.quantidade*(1+pedido_comprasitens.ipi_valor/100)) 
        from distribuir_os 
        join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
        join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
        where distribuir_os.idOs = os.idOs and distribuir_os.idStatuscompras = 5) as somaInsumos, os.qtd_os
        FROM `os` 
        join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
        join produtos on produtos.idProdutos = orcamento_item.idProdutos 
        where produtos.idProdutos = '$id' and os.idStatusOs = 6 ORDER by idOs desc LIMIT 1";
        $result =  $this->db->query($query)->row(); 
        return $result;

    }
    function getCustoICMSPorPN($id){
        $query = "SELECT (select sum(pedido_comprasitens.icms) 
        from distribuir_os 
        join pedido_cotacaoitens on pedido_cotacaoitens.idDistribuir = distribuir_os.idDistribuir 
        join pedido_comprasitens on pedido_comprasitens.idPedidoCompraItens = pedido_cotacaoitens.idPedidoCompraItens 
        where distribuir_os.idOs = os.idOs and distribuir_os.idStatuscompras = 5) as somaIcms, os.qtd_os
        FROM `os` 
        join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
        join produtos on produtos.idProdutos = orcamento_item.idProdutos 
        where produtos.idProdutos = '$id' and os.idStatusOs = 6 ORDER by idOs desc LIMIT 1";
        $result =  $this->db->query($query)->row(); 
        return $result;

    }
    function getCustoFretePorPN($id){
        $query = "SELECT pedido_compras.idPedidoCompra,os.qtd_os,
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
        join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item
        WHERE orcamento_item.idProdutos = $id and distribuir_os.idStatuscompras = 5 and os.idOs = (select max(os2.idOs) from os as os2 join orcamento_item as orcamento_item2 on orcamento_item2.idOrcamento_item = os2.idOrcamento_item where orcamento_item2.idProdutos = orcamento_item.idProdutos and os2.idStatusOs = os.idStatusOs ORDER BY os.idOs desc limit 1) group by pedido_compras.idPedidoCompra";
        $result =  $this->db->query($query)->result(); 
        return $result;

    }
    function getCustoHrMaqPorPN($id){
        $query = "SELECT horas_maquinas.*, os.qtd_os
        from horas_maquinas 
        join os on os.idOs = horas_maquinas.idOs
        where horas_maquinas.idOs = (SELECT os.idOs 
        FROM `os` 
        join orcamento_item on orcamento_item.idOrcamento_item = os.idOrcamento_item 
        join produtos on produtos.idProdutos = orcamento_item.idProdutos 
        where produtos.idProdutos = '$id' and os.idStatusOs = '6' 
        ORDER by idOs desc LIMIT 1)";
        $result = $this->db->query($query)->result(); 
        return $result;
    }

    function getStatusEtapasServico(){
        $query = "SELECT * FROM status_etapas_servico";
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getControleEtapas($limit = '',$where = ''){
        if(!empty($limit)){
            $limit2 = "LIMIT 400";
        }else{
            $limit2 = "";
        }
        $query = "SELECT controle_etapa.*, produtos.*, status_etapas_servico.*, os.idOs,
            (SELECT almo_estoque_usuario.nome 
            from controle_etapa_hist_status 
            left join almo_estoque_usuario on almo_estoque_usuario.idAlmoEstoqueUsuario = controle_etapa_hist_status.idUsuarioAcao 
            where controle_etapa_hist_status.idControleEtapa = controle_etapa.idControleEtapa 
            ORDER BY controle_etapa_hist_status.idControleEtapaHistStatus desc 
            LIMIT 1) as nomeUser 
        FROM controle_etapa 
        join produtos on produtos.idProdutos = controle_etapa.idProduto
        left join os on os.idOrcamento_item = controle_etapa.idOrcamento_item
        join status_etapas_servico on status_etapas_servico.idStatusEtapasServico = controle_etapa.idStatusEtapaServico WHERE 1=1 $where $limit2";
        $result = $this->db->query($query)->result(); 
        return $result;
    }

    function getControleEtapaById($id){
        $query = "SELECT * from controle_etapa join produtos on produtos.idProdutos = controle_etapa.idProduto join  status_etapas_servico on status_etapas_servico.idStatusEtapasServico = controle_etapa.idStatusEtapaServico where controle_etapa.idControleEtapa = $id";
        $result = $this->db->query($query)->row(); 
        return $result;
    }
    function getOnlyControleEtapaById($id){
        $query = "SELECT * from controle_etapa where controle_etapa.idControleEtapa = $id";
        $result = $this->db->query($query)->row(); 
        return $result;
    }
    function getControleStatusHistByIdControleEtapa($id){
        $query = "SELECT * FROM controle_etapa_hist_status             
            where controle_etapa_hist_status.idControleEtapa = $id";
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getControleEtapaByIdOrcamento_item($id){
        $query = "SELECT * from controle_etapa where controle_etapa.idOrcamento_item = $id";
        $result = $this->db->query($query)->row(); 
        return $result;
    }
    function getAllControleEtapaByIdOrcamento_item($idOrc){
        $query = "SELECT * from controle_etapa 
            join produtos on produtos.idProdutos = controle_etapa.idProduto 
            join  status_etapas_servico on status_etapas_servico.idStatusEtapasServico = controle_etapa.idStatusEtapaServico 
            join  orcamento_item on orcamento_item.idOrcamento_item = controle_etapa.idOrcamento_item
            where controle_etapa.idOrcamento_item = $idOrc";
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getControleStatusHistByIdControleEtapa2($id){
        $query = "SELECT controle_etapa_hist_status.*, status_etapas_servico.*, almo_estoque_usuario.nome, usuarios.nome as sisnome FROM controle_etapa_hist_status 
            join status_etapas_servico on status_etapas_servico.idStatusEtapasServico = controle_etapa_hist_status.idStatusEtapaServico 
            left join almo_estoque_usuario on almo_estoque_usuario.idAlmoEstoqueUsuario = controle_etapa_hist_status.idUsuarioAcao
            join usuarios on usuarios.idUsuarios = controle_etapa_hist_status.idUsuarioSis
            where controle_etapa_hist_status.idControleEtapa = $id";
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getControleEtapaItens($id,$where = ""){
        $query = "SELECT controle_etapa_subitem.*, produtos.*, status_etapas_servico.*, os_sub.posicao,os_sub.idOs,
        (SELECT almo_estoque_usuario.nome 
            from controle_etapa_subitem_hist_status 
            left join almo_estoque_usuario on almo_estoque_usuario.idAlmoEstoqueUsuario = controle_etapa_subitem_hist_status.idUsuarioAcao 
            where controle_etapa_subitem_hist_status.idControleEtapaSubitem = controle_etapa_subitem.idControleEtapaSubitem
            ORDER BY controle_etapa_subitem_hist_status.idControleEtapaSubitemHistStatus desc 
            LIMIT 1) as nomeUser 
        FROM controle_etapa_subitem 
        join produtos on produtos.idProdutos = controle_etapa_subitem.idProduto
        join status_etapas_servico on status_etapas_servico.idStatusEtapasServico = controle_etapa_subitem.idStatusEtapaServico
        left join os_sub on os_sub.idOsSub = controle_etapa_subitem.idOsSub where controle_etapa_subitem.idControleEtapa = $id $where order by produtos.pn asc";
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getControleEtapaItens2($id,$where = ""){
        $query = "SELECT controle_etapa_subitem.*, produtos.*, status_etapas_servico.*, os_sub.posicao,os_sub.idOs
        FROM controle_etapa_subitem 
        join produtos on produtos.idProdutos = controle_etapa_subitem.idProduto
        join status_etapas_servico on status_etapas_servico.idStatusEtapasServico = controle_etapa_subitem.idStatusEtapaServico
        left join os_sub on os_sub.idOsSub = controle_etapa_subitem.idOsSub where controle_etapa_subitem.idControleEtapa = $id $where order by produtos.pn asc";
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getControleEtapaSubitemById($id){
        $query = "SELECT * from controle_etapa_subitem join produtos on produtos.idProdutos = controle_etapa_subitem.idProduto join status_etapas_servico on status_etapas_servico.idStatusEtapasServico = controle_etapa_subitem.idStatusEtapaServico where controle_etapa_subitem.idControleEtapaSubitem = $id";
        $result = $this->db->query($query)->row(); 
        return $result;
    }
    function getOnlyControleEtapaSubitemById($id){
        $query = "SELECT * from controle_etapa_subitem where controle_etapa_subitem.idControleEtapaSubitem = $id";
        $result = $this->db->query($query)->row(); 
        return $result;
    }

    function getControleStatusHistByIdControleEtapaSubitem($id){
        $query = "SELECT * FROM controle_etapa_subitem_hist_status
            where controle_etapa_subitem_hist_status.idControleEtapaSubitem = $id";
        $result = $this->db->query($query)->result(); 
        return $result;
    }

    function getControleStatusHistByIdControleEtapaSubitem2($id){
        $query = "SELECT controle_etapa_subitem_hist_status.*, status_etapas_servico.*, almo_estoque_usuario.nome, usuarios.nome as sisnome FROM controle_etapa_subitem_hist_status
            join status_etapas_servico on status_etapas_servico.idStatusEtapasServico = controle_etapa_subitem_hist_status.idStatusEtapaServico 
            left join almo_estoque_usuario on almo_estoque_usuario.idAlmoEstoqueUsuario = controle_etapa_subitem_hist_status.idUsuarioAcao     
            join usuarios on usuarios.idUsuarios = controle_etapa_subitem_hist_status.idUsuarioSis     
            where controle_etapa_subitem_hist_status.idControleEtapaSubitem = $id";
        $result = $this->db->query($query)->result(); 
        return $result;
    }

    function getOnlySubitensControleByIdControle($id){
        $query = "SELECT controle_etapa_subitem.* FROM controle_etapa_subitem WHERE idControleEtapa = $id";
        $result = $this->db->query($query)->result(); 
        return $result;
    }

    function procurarItensEntrada($where){
        $query = "SELECT controle_etapa.*,produtos.*,status_etapas_servico.*,orcamento_item.* from controle_etapa 
            join produtos on produtos.idProdutos = controle_etapa.idProduto 
            join status_etapas_servico on status_etapas_servico.idStatusEtapasServico = controle_etapa.idStatusEtapaServico join orcamento_item on orcamento_item.idOrcamento_item = controle_etapa.idOrcamento_item left join os on os.idOrcamento_item = controle_etapa.idOrcamento_item where 1=1 $where";
        $result = $this->db->query($query)->result(); 
        return $result;
    }

    function getProdutosEscopoByIdProduto($escopo,$excecao = ''){
        if(!empty($excecao)){
            $query = "SELECT produtos.* FROM produtos JOIN servico_escopo_itens on servico_escopo_itens.idProduto = produtos.idProdutos where produtos.idProdutos not in ($excecao) and servico_escopo_itens.idServicoEscopo = $escopo group by produtos.idProdutos order by produtos.pn asc";

        }else{
            $query = "SELECT produtos.* FROM produtos JOIN servico_escopo_itens on servico_escopo_itens.idProduto = produtos.idProdutos where  servico_escopo_itens.idServicoEscopo = $escopo group by produtos.idProdutos order by produtos.pn asc";

        }
        $result = $this->db->query($query)->result(); 
        return $result;
    }

    function getProdutosCatalogoByIdProduto($checklist,$excecao = ''){
        if(!empty($excecao)){
            $query = "SELECT produtos.* FROM produtos JOIN catalogo_produto_itens on catalogo_produto_itens.idProduto = produtos.idProdutos WHERE catalogo_produto_itens.idCatalogoProduto = $checklist and produtos.idProdutos not in ($excecao) group by produtos.idProdutos order by produtos.pn asc";

        }else{
            $query = "SELECT produtos.* FROM produtos JOIN catalogo_produto_itens on catalogo_produto_itens.idProduto = produtos.idProdutos WHERE catalogo_produto_itens.idCatalogoProduto = $checklist group by produtos.idProdutos order by produtos.pn asc";

        }
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getProdutobyId($id){
        $query = "SELECT * FROM produtos WHERE idProdutos = $id";
        $result = $this->db->query($query)->row(); 
        return $result;
    }
    function getOrcComItensAguardandoRecebimento($where = ""){
        $query = "SELECT orcamento.*, clientes.*, orcamento_item.data_previsao_chegada FROM `orcamento` JOIN clientes on clientes.idClientes = orcamento.idClientes join controle_etapa on controle_etapa.idOrcamento = orcamento.idOrcamentos join orcamento_item on orcamento_item.idOrcamento_item = controle_etapa.idOrcamento_item where controle_etapa.idStatusEtapaServico = 1  $where group by orcamento.idOrcamentos ";
        
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getOrcComItensAguardandoEntrada($where = ""){
        $query = "SELECT orcamento.*, clientes.* FROM `orcamento` JOIN clientes on clientes.idClientes = orcamento.idClientes join controle_etapa on controle_etapa.idOrcamento = orcamento.idOrcamentos where controle_etapa.idStatusEtapaServico not in (1,3)  $where group by orcamento.idOrcamentos ";
        
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getOrcComItensAguardandoSaida($where = ""){
        $query = "SELECT orcamento.*, clientes.* FROM `orcamento` JOIN clientes on clientes.idClientes = orcamento.idClientes join controle_etapa on controle_etapa.idOrcamento = orcamento.idOrcamentos where controle_etapa.idStatusEtapaServico in (3)  $where group by orcamento.idOrcamentos ";
        
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getOrcComItensCancelado($where = ''){
        $query = "SELECT orcamento.*, clientes.* FROM `orcamento` JOIN clientes on clientes.idClientes = orcamento.idClientes join controle_etapa on controle_etapa.idOrcamento = orcamento.idOrcamentos where controle_etapa.idStatusEtapaServico in (13)  $where group by orcamento.idOrcamentos ";
        
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getItemOrcComControleEtapa($id){
        $query = "SELECT orcamento_item.*, controle_etapa.idControleEtapa, controle_etapa.idStatusEtapaServico,status_etapas_servico.descricaoStatusEtapaServico,produtos.*,os.idOs FROM `orcamento_item` left join controle_etapa on controle_etapa.idOrcamento_item = orcamento_item.idOrcamento_item left join status_etapas_servico on status_etapas_servico.idStatusEtapasServico = controle_etapa.idStatusEtapaServico join produtos on produtos.idProdutos = orcamento_item.idProdutos left join os on os.idOrcamento_item = orcamento_item.idOrcamento_item WHERE orcamento_item.idOrcamentos  = $id";
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    function getControleByIdOrcamento($id){
        $query = "SELECT * FROM controle_etapa WHERE idOrcamento = $id";
        $result = $this->db->query($query)->result(); 
        return $result;
    }
    
}