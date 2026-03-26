<?
date_default_timezone_set('America/Fortaleza');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>SGI</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />

<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />


<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" /> 

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

<!--
Retornar este quando o CDN nao funfar
-->
<!--
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
   
    <li class=""><a title="" href="<?php echo base_url();?>index.php/mapos/minhaConta"><i class="icon icon-star"></i> <span class="text">Minha Conta</span></a></li>
    
	 <li class=""><a title="" href="#"><i class="icon icon-user"></i> <span class="text">Usuario: <b><?php echo $this->session->userdata('user');?></b></span></a></li>
	 
   <li class=""><a title="" href="<?php echo base_url();?>index.php/mapos/sair"><i class="icon icon-share-alt"></i> <span class="text">Sair do Sistema</span></a></li>
  </ul>
</div>

<!--start-top-serch-->
<!--<div id="search">
  <form action="<?php echo base_url()?>index.php/mapos/pesquisar">
    <input type="text" name="termo" placeholder="Pesquisar..."/>
    <button type="submit"  class="tip-bottom" title="Pesquisar"><i class="icon-search icon-white"></i></button>
    
  </form>
</div>-->
<!--close-top-serch--> 

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i> Menu</a>
  <ul>


    <li class="<?php if(isset($menuPainel)){echo 'active';};?>"><a href="<?php echo base_url()?>"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
    
	 <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vOrcamento')){ ?>
        <li class="<?php if(isset($menuOrcamentos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/orcamentos"><i class="icon-fixed-width icon-book"></i> <span>Orçamentos</span></a></li>
    <?php } ?>
	
	<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){ ?>
        <li class="<?php if(isset($menuOs)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/os"><i class="icon-fixed-width icon-cogs"></i> <span>Ordem de Serviço</span></a></li>
		
		<li class="<?php if(isset($menucarteira)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/os/carteiraservico"> <i class="icon-tasks"></i></i> <span>Carteira de Serviço</span></a></li>
    <?php } ?>
	<?php if($this->session->userdata('permissao') <> 6)
	{
		?>
	<?php /*if($this->permission->checkPermission($this->session->userdata('permissao'),'vCotacao')){ ?>
        <li class="<?php if(isset($menuCotacao)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/cotacao"><i class="icon-paste"></i> <span>Suprimentos_old</span></a></li>
    <?php }*/ ?>
	 <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedCompra')){ ?>
        <li class="<?php if(isset($menuPedidoCompra)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/suprimentos"><i class="icon icon-file"></i> <span>Suprimentos</span></a></li>
    <?php } ?>
	<?php
	}
	?><!--
  <li class=""><a href="<?php echo base_url()?>index.php/registrodescarte"><i class="icon-fixed-width icon-cogs"></i> <span>Registro de Descarte</span></a></li>-->
		
	 <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vAlmoxarifado')){ ?>
    <li class="submenu <?php if(isset($menuAlmoxarifado)){echo 'active open';};?>">
          <a href="<?php echo base_url()?>index.php/almoxarifado/relatorioAlmoxarifado"><i class="icon icon-tags"></i> <span>Almoxarifado</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aAlmoxarifado')){ ?>
              <li><a href="<?php echo base_url()?>index.php/almoxarifado">Lançamentos</a></li>
            <?php } ?>
            <li><a href="<?php echo base_url()?>index.php/almoxarifado/relatorioAlmoxarifado">Relatórios</a></li><!--
            <li><a href="<?php echo base_url()?>index.php/almoxarifado/reldetalhado">Relatório detalhado</a></li>-->
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedidocompraalmox')){ ?>
              <li><a href="<?php echo base_url()?>index.php/suprimentos/almoxarifado_compras">Compras</a></li>
            <?php } ?>
          </ul>
        </li><!--
        <li class="<?php if(isset($menuAlmoxarifado)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/almoxarifado"><i class="icon-tags"></i> <span>Almoxarifado</span></a></li>-->
    <?php } ?>
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vBacklog')){ ?>
    <li class="submenu  <?php if(isset($menuPcp)){echo 'active open';};?>">
      <a href="<?php echo base_url()?>index.php/pcp/backlog"><i class="icon icon-tags"></i> <span>PCP</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
      <ul>
        <li><a href="<?php echo base_url()?>index.php/pcp/backlog">Backlog</a></li>
      </ul>
    </li><?php } ?>

    <li class="submenu <?php if(isset($menuProducao)){echo 'active open';};?>">
      <a href="<?php echo base_url()?>index.php/producao/adicionarhoramaquina"><i class="icon icon-tags"></i> <span>Produção</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
      <ul>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'aApontamento')){ ?>
        <li><a href="<?php echo base_url()?>index.php/producao/adicionarhoramaquina">Apontamento</a></li>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vApontamento')){ ?>
        <li><a href="<?php echo base_url()?>index.php/producao/rel_apontamento">Rel. Apontamento</a></li>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vMaquina')){ ?>
        <li><a href="<?php echo base_url()?>index.php/maquinas">Cad. Máquinas</a></li>
        <?php } ?>
        <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vMaquinausuario')){ ?>
        <li><a href="<?php echo base_url()?>index.php/maquinasusuarios">Cad. Usuário Máq.</a></li>
        <?php } ?>
      </ul>
    </li>


	 <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vPedidocompraalmox')){ ?>
        <!--<li class="<?php if(isset($menuPedidocompraalmox)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/suprimentos/almoxarifado"><i class="icon-truck"></i> <span>Almoxarifado P.C.</span></a></li>
    --><?php } ?>
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){ ?>
		<li class="submenu <?php if(isset($menuClientes)){echo 'active open';};?>">
          <a href="<?php echo base_url()?>index.php/clientes"><i class="icon icon-group"></i> <span>Clientes</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <li><a href="<?php echo base_url()?>index.php/clientes">Cad. Clientes</a></li>
            <li><a href="<?php echo base_url()?>index.php/clientes/solicitantes">Cad. Solicitantes</a></li>
            
          </ul>
        </li>
		
		
        
    <?php } ?>
	
	  <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vFornecedor')){ ?>
        <li class="<?php if(isset($menuFornecedores)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/fornecedores"><i class="icon icon-group"></i> <span>Fornecedor</span></a></li>
    <?php } ?>
	
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){ ?>
        <li class="<?php if(isset($menuProdutos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/produtos"><i class="icon icon-barcode"></i> <span>PN</span></a></li>
    <?php } ?>
	
	 

   <?php 
  // echo "---".$this->permission->checkPermission($this->session->userdata('permissao'),'vInsumo');
   
   if($this->permission->checkPermission($this->session->userdata('permissao'),'vInsumo')){ ?>
        <li class="submenu <?php if(isset($menuInsumos)){echo 'active open';};?>">
          <a href="<?php echo base_url()?>index.php/insumos"><i class="icon-shopping-cart"></i> <span>Insumos</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <li><a href="<?php echo base_url()?>index.php/insumos">Cadastrar</a></li><!--
            <li><a href="<?php echo base_url()?>index.php/insumos/categoria">Categoria</a></li>
            <li><a href="<?php echo base_url()?>index.php/insumos/subcategoria">Subcategoria</a></li>-->
			</ul>
        </li>
    <?php } 
	/*
	 if($this->permission->checkPermission($this->session->userdata('permissao'),'vEstoque')){ ?>
        <li class="submenu ">
          <a href="<?php echo base_url()?>index.php/estoque"><i class="icon icon-barcode"></i> <span>Estoque</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <li class="<?php if(isset($menuEstoque)){echo 'active open';};?>"><a href="<?php echo base_url()?>index.php/estoque/estoque">Estoque</a></li>
            
            <li class="<?php if(isset($menuSaidaEstoque)){echo 'active open';};?>"><a href="<?php echo base_url()?>index.php/estoque/estoquesaida">Saída Estoque</a></li>
          
			</ul>
        </li>
    <?php } */ ?>
	
	
 
    <!--
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vMaquina')){ ?>
        <li class="<?php if(isset($menuMaquinas)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/maquinas"><i class="icon icon-wrench"></i> <span>Maquinas</span></a></li>
    <?php } ?>
  <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vMaquinausuario')){ ?>
        <li class="<?php if(isset($menuMaquinasusuarios)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/maquinasusuarios"><i class="icon icon-user"></i> <span>Maquinas Usuarios</span></a></li>
    <?php } ?>
  -->
    
	
	

   
    
    <!--<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vArquivo')){ ?>
        <li class="<?php if(isset($menuArquivos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/arquivos"><i class="icon icon-hdd"></i> <span>Arquivos</span></a></li>
    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vLancamento')){ ?>
        <li class="submenu <?php if(isset($menuFinanceiro)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-money"></i> <span>Financeiro</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <li><a href="<?php echo base_url()?>index.php/financeiro/lancamentos">Lançamentos</a></li>
          </ul>
        </li>
    <?php } ?>-->

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rCliente') || $this->permission->checkPermission($this->session->userdata('permissao'),'rProduto') || $this->permission->checkPermission($this->session->userdata('permissao'),'rServico') || $this->permission->checkPermission($this->session->userdata('permissao'),'rOs') || $this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro') || $this->permission->checkPermission($this->session->userdata('permissao'),'rOrdemcompra') || $this->permission->checkPermission($this->session->userdata('permissao'),'rOrcamento')){ ?>
        
        <li class="submenu <?php if(isset($menuRelatorios)){echo 'active open';};?>" >
          <a href="<?php echo base_url()?>index.php/relatorios/ordemdecompra"><i class="icon icon-list-alt"></i> <span>Relatórios</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
			  <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rOrdemcompra')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/ordemdecompra">Ordem de compra</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rOrdemcompra')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/relcompras">Compras</a></li>
            <?php } ?>
            <!--<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rCliente')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/clientes">Clientes</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rProduto')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/produtos">Produtos</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rServico')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/servicos">Serviços</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){ ?>
                 <li><a href="<?php echo base_url()?>index.php/relatorios/os">Ordem de Serviço</a></li>
            <?php } ?>
			<?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/financeiro">Financeiro</a></li>
            <?php } ?>
			
			-->
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rOrcamento')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/rel_orcamento">Orçamentos</a></li>
            <?php } ?>
            
            
          </ul>
        </li>

    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')  || $this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente') || $this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao') || $this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="<?php echo base_url()?>index.php/permissoes"><i class="icon icon-cog"></i> <span>Configurações</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')){ ?>
                <li><a href="<?php echo base_url()?>index.php/usuarios">Usuários</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){ ?>
                <li><a href="<?php echo base_url()?>index.php/mapos/emitente">Emitente</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao')){ ?>
                <li><a href="<?php echo base_url()?>index.php/permissoes">Permissões</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
                <li><a href="<?php echo base_url()?>index.php/mapos/backup">Backup</a></li>
            <?php } ?><!--
            <li><a href="<?php echo base_url()?>index.php/email">Email</a></li>-->
          </ul>
        </li>
    <?php } ?>
    
    
  </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?php echo base_url()?>" title="Dashboard" class="tip-bottom"><i class="icon-home"></i> Dashboard</a> <?php if($this->uri->segment(1) != null){?><a href="<?php echo base_url().'index.php/'.$this->uri->segment(1)?>" class="tip-bottom" title="<?php echo ucfirst($this->uri->segment(1));?>"><?php echo ucfirst($this->uri->segment(1));?></a> <?php if($this->uri->segment(2) != null){?><a href="<?php echo base_url().'index.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2) ?>" class="current tip-bottom" title="<?php echo ucfirst($this->uri->segment(2)); ?>"><?php echo ucfirst($this->uri->segment(2));} ?></a> <?php }?></div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
          <?php if($this->session->flashdata('error') != null){?>
                            <div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('error');?>
                           </div>
                      <?php }?>

                      <?php if($this->session->flashdata('success') != null){?>
                            <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('success');?>
                           </div>
                      <?php }?>
                          
                      <?php if(isset($view)){echo $this->load->view($view);}?>


      </div>
    </div>
  </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2020 &copy; SGI</div>
</div>
<!--end-Footer-part-->


<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/matrix.js"></script> 


</body>
</html>







