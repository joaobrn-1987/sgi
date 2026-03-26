<?php
// application/views/os/cliente_os_view.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de OS - Ubertec</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />

    <style>
        body {
            background-color: #f0f2f5;
        }
        .main-card {
            margin-top: 2rem;
            margin-bottom: 2rem;
            border: none;
            box-shadow: 0 0 30px rgba(0,0,0,0.15);
            border-radius: 12px;
            /* Fundo branco semi-transparente para o card */
            background-color: rgba(255, 255, 255, 0.95);
        }
        .logos-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logos-container img {
            max-height: 60px;
        }
        .logos-container img:first-child {
            margin-right: 20px;
        }
        
        /* CSS para o Vídeo de Fundo */
		#bg-video {
			position: fixed;
			top: 50%;
			left: 50%;
			min-width: 100%;
			min-height: 100%;
			width: auto;
			height: auto;
			z-index: -100;
			transform: translateX(-50%) translateY(-50%);
			background-size: cover;
		}

		#video-overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.6);
			z-index: -99;
		}

		.content-wrapper {
			position: relative;
			z-index: 2;
		}
    </style>
</head>
<body>

<div id="video-overlay"></div>
<video autoplay muted loop id="bg-video">
    <source src="<?php echo base_url('assets/videos/background-video.mp4'); ?>" type="video/mp4">
</video>
 
             <!--<img src="<?php echo base_url()?>assets5_2/img/logo/ubertec_logo.png" alt="Ubertec Logo" height="60" style="margin-right: 20px;">-->
             
           
       
<div class="content-wrapper">
    <main class="container">
        <div class="card main-card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center p-3">
                <h4 class="mb-0">
					<img src="<?php echo base_url()?>assets5_2/img/logo/oz.png" alt="Cliente Logo" height="60">
                    <i class="bi bi-search"></i> Consulta de Ordem de Serviço
                </h4>
                <div>
                    <a href="<?php echo base_url();?>index.php/mapos/sair" class="btn btn-outline-danger">
                        <i class="bi bi-box-arrow-right"></i> Sair do Sistema
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form action="<?php echo base_url() ?>index.php/os/cliente_visualizar_os" method="post">
                    <div class="input-group mb-4">
                        <input type="number" name="idOs" value="<?php echo isset($os_info->idOs) ? $os_info->idOs : ''; ?>" class="form-control form-control-lg" placeholder="Digite o número da OS" autofocus required>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </form>

                <?php if(isset($os_info) && $os_info != null): ?>
                    <hr class="my-4">
                    <div class="results-container">
                        <h5>Arquivos para a OS: <strong class="text-primary"><?php echo $os_info->idOs; ?></strong></h5>
                        <p class="text-muted">Cliente: <?php echo htmlspecialchars($os_info->nomeCliente); ?></p>
                        <?php if(!empty($anexos)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nome do Arquivo</th>
                                            <th>Tipo</th>
                                            <th>Data de Cadastro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($anexos as $anexo): ?>
                                        <tr>
                                            <td>
                                                <a href='<?php echo base_url() . $anexo->caminho . $anexo->imagem; ?>' target='_blank' class="text-decoration-none">
                                                    <i class="bi bi-file-earmark-arrow-down"></i>
                                                    <?php echo htmlspecialchars($anexo->nomeArquivo . (isset($anexo->extensao) ? $anexo->extensao : '')); ?>
                                                </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($anexo->tipo_anexo); ?></td>
                                            <td><?php echo date("d/m/Y H:i:s", strtotime($anexo->data_cadastro)); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mt-3" role="alert">
                               <i class="bi bi-info-circle-fill"></i> Não há vídeos ou fotos disponíveis para esta OS.
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error') != null): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

</body>
</html>