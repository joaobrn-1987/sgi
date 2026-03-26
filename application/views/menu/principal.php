<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Ubertec - Área do Cliente</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link href="<?php echo base_url();?>assets5_2/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
		body { 
			background-image: url('<?php echo base_url()?>assets5_2/img/background/background.png');
			background-size: cover;
			background-attachment:fixed;
			padding-top: 80px; /* Espaço para o menu fixo */
			background-color: #f0f2f5; 
			font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
		}
		.navbar {
			box-shadow: 0 2px 4px rgba(0,0,0,.1);
		}
		.navbar-brand img {
			height: 40px;
		}
		.container { max-width: 900px; margin-top: 20px; margin-bottom: 40px; }
		.card {
			border: 0;
			border-radius: .75rem;
			box-shadow: 0 0.5rem 1.5rem 0 rgba(0, 0, 0, 0.1);
		}
		.card-header {
			background-color: #fff;
			border-bottom: 1px solid #dee2e6;
			padding: 1.5rem;
			text-align: center;
		}
		.card-body { padding: 2rem; }
	</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
        <img src="<?php echo base_url()?>assets5_2/img/logo/ubertec_logo.png" alt="Ubertec Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('index.php/os/cliente_visualizar_os'); ?>">Consultar OS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('index.php/mapos/estoque'); ?>">Consultar Estoque</a>
        </li>
      </ul>
      <a href="<?php echo base_url('index.php/mapos/sair'); ?>" class="btn btn-outline-secondary">
        <i class="fa fa-sign-out"></i> Sair do Sistema
      </a>
    </div>
  </div>
</nav>

<main role="main">
    <?php if(isset($view)){ $this->load->view($view); }?>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

</body>
</html>