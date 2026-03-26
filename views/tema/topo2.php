<?
date_default_timezone_set('America/Fortaleza');
?>
<html class="" lang="en">

<head>

    <meta charset="UTF-8">
    <title>SGI</title>

    <meta name="robots" content="noindex">
    <!--
    <link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">
    <link rel="mask-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111">
    <link rel="canonical" href="https://codepen.io/corbpie/pen/LYNwGdE">
    -->

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/all.min.css">

    <style class="INLINE_PEN_STYLESHEET_ID">
        :root {
            --font-family-sans-serif: "Open Sans", -apple-system, BlinkMacSystemFont,
                "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji",
                "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        *,
        *::before,
        *::after {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        html {
            font-family: sans-serif;
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        nav {
            display: block;
        }

        body {
            margin: 0;
            font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI",
                Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji",
                "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #515151;
            text-align: left;
            background-color: #e9edf4;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        a {
            color: #3f84fc;
            text-decoration: none;
            background-color: transparent;
        }

        a:hover {
            color: #0458eb;
            text-decoration: underline;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: "Nunito", sans-serif;
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h1,
        .h1 {
            font-size: 2.5rem;
            font-weight: normal;
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0;
        }

        .card-body {
            -webkit-box-flex: 1;
            -webkit-flex: 1 1 auto;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            text-align: center;
        }

        .dashboard {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            min-height: 100vh;
        }

        .dashboard-app {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-flex: 2;
            -webkit-flex-grow: 2;
            -ms-flex-positive: 2;
            flex-grow: 2;
            margin-top: 84px;
        }

        .dashboard-content {
            -webkit-box-flex: 2;
            -webkit-flex-grow: 2;
            -ms-flex-positive: 2;
            flex-grow: 2;
            padding: 25px;
        }

        .dashboard-nav {
            min-width: 238px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            overflow: auto;
            background-color: #2e363f;
        }

        .dashboard-compact .dashboard-nav {
            display: none;
        }

        .dashboard-nav header {            
            /**/
            min-height: 84px;
            padding: 8px 27px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .dashboard-nav header .menu-toggle {
            display: none;
            margin-right: auto;
        }

        .dashboard-nav a {
            color: #515151;
        }

        .dashboard-nav a:hover {
            text-decoration: none;
        }

        .dashboard-nav {
            background-color: #2E363F;
        }

        .dashboard-nav a {
            color: #fff;
        }

        .brand-logo {
            font-family: "Nunito", sans-serif;
            font-weight: bold;
            font-size: 20px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            color: #515151;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .brand-logo:focus,
        .brand-logo:active,
        .brand-logo:hover {
            color: #dbdbdb;
            text-decoration: none;
        }

        .brand-logo i {
            color: #d2d1d1;
            font-size: 27px;
            margin-right: 10px;
        }

        .dashboard-nav-list {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .dashboard-nav-item {
            min-height: 56px;
            padding: 8px 20px 8px 70px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            letter-spacing: 0.02em;
            transition: ease-out 0.5s;
        }

        .dashboard-nav-item i {
            width: 36px;
            font-size: 19px;
            margin-left: -40px;
        }

        .dashboard-nav-item:hover {
            background: "rgba(255, 255, 255, 0.04)";
        }

        .active {
            background: "#ff1519";
        }

        .dashboard-nav-dropdown {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .dashboard-nav-dropdown.show {
            background: rgba(255, 255, 255, 0.04);
        }

        .dashboard-nav-dropdown.show>.dashboard-nav-dropdown-toggle {
            font-weight: bold;
        }

        .dashboard-nav-dropdown.show>.dashboard-nav-dropdown-toggle:after {
            -webkit-transform: none;
            -o-transform: none;
            transform: none;
        }

        .dashboard-nav-dropdown.show>.dashboard-nav-dropdown-menu {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }

        .dashboard-nav-dropdown-toggle:after {
            content: "";
            margin-left: auto;
            display: inline-block;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid rgba(81, 81, 81, 0.8);
            -webkit-transform: rotate(90deg);
            -o-transform: rotate(90deg);
            transform: rotate(90deg);
        }

        .dashboard-nav .dashboard-nav-dropdown-toggle:after {
            border-top-color: rgba(255, 255, 255, 0.72);
        }

        .dashboard-nav-dropdown-menu {
            display: none;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .dashboard-nav-dropdown-item {
            min-height: 40px;
            padding: 8px 20px 8px 70px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            transition: ease-out 0.5s;
        }

        .dashboard-nav-dropdown-item:hover {
            background: rgba(255, 255, 255, 0.04);
        }

        .menu-toggle {
            position: relative;
            width: 42px;
            height: 42px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            color: #fff;
        }

        .menu-toggle:hover,
        .menu-toggle:active,
        .menu-toggle:focus {
            text-decoration: none;
            color: #fff;
        }

        .menu-toggle i {
            font-size: 20px;
        }

        .dashboard-toolbar {
            min-height: 84px;
            background-color: #2e363f;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            padding: 8px 27px;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1000;
        }

        .nav-item-divider {
            height: 1px;
            margin: 1rem 0;
            overflow: hidden;
            background-color: rgba(236, 238, 239, 0.3);
        }
        .logo{
            background: url("<?php echo base_url()?>/assets/img/ubertec.png") no-repeat scroll 0 0 transparent;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }

        @media (min-width: 992px) {
            .dashboard-app {
                margin-left: 238px;
            }

            .dashboard-compact .dashboard-app {
                margin-left: 0;
            }
        }


        @media (max-width: 768px) {
            .dashboard-content {
                padding: 15px 0px;
            }
        }

        @media (max-width: 992px) {
            .dashboard-nav {
                display: none;
                position: fixed;
                top: 0;
                right: 0;
                left: 0;
                bottom: 0;
                z-index: 1070;
            }

            .dashboard-nav.mobile-show {
                display: block;
            }
        }

        @media (max-width: 992px) {
            .dashboard-nav header .menu-toggle {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
            }
        }

        @media (min-width: 992px) {
            .dashboard-toolbar {
                left: 238px;
            }

            .dashboard-compact .dashboard-toolbar {
                left: 0;
            }
        }
    </style>

        <!--
    <script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeConsoleRunner-7549a40147ccd0ba0a6b5373d87e770e49bb4689f1c2dc30cccc7463f207f997.js"></script>
    <script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeRefreshCSS-4793b73c6332f7f14a9b6bba5d5e62748e9d1bd0b5c52d7af6376f3d1c625d7e.js"></script>
    <script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeRuntimeErrors-4f205f2c14e769b448bcf477de2938c681660d5038bc464e3700256713ebe261.js"></script> -->
</head>

<body>
    <div class="dashboard">
        <div class="dashboard-nav">
            <header><a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a><a href="#" class="brand-logo"><i class="logo "></i> </a></header>
            <nav class="dashboard-nav-list">
                <a href="#" class="dashboard-nav-item active"><i class="fas fa-home"></i> Dashboard </a>
                <a href="#" class="dashboard-nav-item"><i class="fas fa-file-upload"></i> Orçamentos </a>
                <a href="#" class="dashboard-nav-item"><i class="fas fa-file-upload"></i> Ordem de Serviço </a>
                <a href="#" class="dashboard-nav-item"><i class="fas fa-file-upload"></i> Carteira de Serviço </a>
                <a href="#" class="dashboard-nav-item"><i class="fas fa-file-upload"></i> PCP </a>
                <div class="dashboard-nav-dropdown">
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-photo-video"></i> Suprimentos </a>
                    <div class="dashboard-nav-dropdown-menu">
                        <a href="#" class="dashboard-nav-dropdown-item">Autorizar Compra</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Suprimentos</a>
                    </div>
                </div>
                <div class="dashboard-nav-dropdown">
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-photo-video"></i> Almoxarifado </a>
                    <div class="dashboard-nav-dropdown-menu">
                        <a href="#" class="dashboard-nav-dropdown-item">Lançamentos</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Relatórios</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Compras</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Entrega MP</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Gerência</a>
                    </div>
                </div>
                <div class="dashboard-nav-dropdown">
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-photo-video"></i> Peritagem </a>
                    <div class="dashboard-nav-dropdown-menu">
                        <a href="#" class="dashboard-nav-dropdown-item">Aguardando</a>
                    </div>
                </div>
                <div class="dashboard-nav-dropdown">
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-photo-video"></i> Produção </a>
                    <div class="dashboard-nav-dropdown-menu">
                        <a href="#" class="dashboard-nav-dropdown-item">Apontamento</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Rel. Apontamento</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Cad. Máquinas</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Cad. Usuário</a>
                    </div>
                </div>
                <div class="dashboard-nav-dropdown">
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-photo-video"></i> Clientes </a>
                    <div class="dashboard-nav-dropdown-menu">
                        <a href="#" class="dashboard-nav-dropdown-item">Cad. Clientes</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Cad. Solicitantes</a>
                    </div>
                </div>
                
                <a href="#" class="dashboard-nav-item"><i class="fas fa-file-upload"></i> Fornecedor </a>                
                <a href="#" class="dashboard-nav-item"><i class="fas fa-file-upload"></i> PN </a> 
                <div class="dashboard-nav-dropdown">
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-photo-video"></i> Insumos </a>
                    <div class="dashboard-nav-dropdown-menu">
                        <a href="#" class="dashboard-nav-dropdown-item">Cadastrar</a>
                    </div>
                </div>      
                <div class="dashboard-nav-dropdown">
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-photo-video"></i> Estoque </a>
                    <div class="dashboard-nav-dropdown-menu">
                        <a href="#" class="dashboard-nav-dropdown-item">Estoque</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Saída Estoque</a>
                    </div>
                </div>  
                     
                <div class="dashboard-nav-dropdown">
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-photo-video"></i> Financeiro </a>
                    <div class="dashboard-nav-dropdown-menu">
                        <a href="#" class="dashboard-nav-dropdown-item">Autorizar compra</a>
                    </div>
                </div>
                <div class="dashboard-nav-dropdown">
                    <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle"><i class="fas fa-photo-video"></i> Relatórios </a>
                    <div class="dashboard-nav-dropdown-menu">
                        <a href="#" class="dashboard-nav-dropdown-item">Ordem Compra</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Compras</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Comercial</a>
                        <a href="#" class="dashboard-nav-dropdown-item">Orçamentos</a>
                    </div>
                </div>
                <div class="nav-item-divider"></div>
                <a href="#" class="dashboard-nav-item"><i class="fas fa-sign-out-alt"></i> Logout </a>
            </nav>
        </div>
        <div class="dashboard-app">
            <header class="dashboard-toolbar"><a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a></header>
            <div class="dashboard-content">
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
                    
                <!--
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <h1>Welcome back Jim</h1>
                        </div>
                        <div class="card-body">
                            <p>Your account type is: Administrator</p>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdpn.io/cpe/boomboom/pen.js?key=pen.js-cce4d8b2-985f-6bd1-9577-d5aa9fe8632b" crossorigin=""></script>
    <script type="text/javascript">
        const mobileScreen = window.matchMedia("(max-width: 990px )");
        $(document).ready(function() {
            $(".dashboard-nav-dropdown-toggle").click(function() {
                $(this).closest(".dashboard-nav-dropdown").
                toggleClass("show").
                find(".dashboard-nav-dropdown").
                removeClass("show");
                $(this).parent().
                siblings().
                removeClass("show");
            });
            $(".menu-toggle").click(function() {
                if (mobileScreen.matches) {
                    $(".dashboard-nav").toggleClass("mobile-show");
                } else {
                    $(".dashboard").toggleClass("dashboard-compact");
                }
            });
        });
    </script>


</body>

</html>