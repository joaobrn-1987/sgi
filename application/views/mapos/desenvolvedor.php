<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Filtro</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">

                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2">
                                        <form action="<?php echo base_url() ?>index.php/mapos/gerarsubos" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Gerar SubOs: </label>
                                                <input type="text" name="idOs" id="idOs" >
                                                <button >Gerar</button>
                                            </div>
                                            
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form  action="<?php echo base_url() ?>index.php/mapos/gerarescopo" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Gerar Escopo: </label>
                                                <input type="file" name="userfile" id="arquivo" class="span12" accept=".csv">
                                                <button >Gerar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form  action="<?php echo base_url() ?>index.php/mapos/carregarPlanilhaMP" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Carregar Estq. MP: </label>
                                                <input type="file" name="userfile" id="arquivo" class="span12" accept=".csv">
                                                <button >Gerar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form  action="<?php echo base_url() ?>index.php/mapos/substituirEscopoPadraoCilindro" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Recarregar Escopo </label>
                                                <button>Gerar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form action="<?php echo base_url() ?>index.php/mapos/itenspn" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Buscar Itens: </label>
                                                <input type="file" name="userfile" id="arquivo" class="span12" accept=".csv">
                                                <button >Gerar</button>
                                            </div>
                                            
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form  action="<?php echo base_url() ?>index.php/mapos/cadastrarprodutos" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Cadastrar Produtos: </label>
                                                <input type="file" name="userfile" id="arquivo" class="span12" accept=".csv">
                                                <button >Gerar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span2" style="margin-left:0px">
                                        <form  action="<?php echo base_url() ?>index.php/mapos/listapndesenhos" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Lista de desenhos: </label>
                                                <input type="file" name="userfile" id="arquivo" class="span12" accept=".csv">
                                                <button >Gerar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form action="<?php echo base_url() ?>index.php/mapos/adicionarvalorentradaalmo" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Alterar Entrada: </label>
                                                <input type="file" name="userfile" id="arquivo" class="span12" accept=".csv">
                                                <button >Gerar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form action="<?php echo base_url() ?>index.php/mapos/carregarPlanilhaLoja" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Carregar LOJA: </label>
                                                <input type="file" name="userfile" id="arquivo" class="span12" accept=".csv">
                                                <button >Gerar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form action="<?php echo base_url() ?>index.php/mapos/carregarPlanilhaEP" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Carregar Est. Pec.: </label>
                                                <input type="file" name="userfile" id="arquivo" class="span12" accept=".csv">
                                                <button >Gerar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form action="<?php echo base_url() ?>index.php/mapos/carregarPlanilhaEP" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Carregar LOJA: </label>
                                                <input type="file" name="userfile" id="arquivo" class="span12" accept=".csv">
                                                <button >Gerar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form action="<?php echo base_url() ?>index.php/mapos/carregarSimplex" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Carregar Simplex </label>
                                                <button >Carregar</button>
                                            </div>
                                        </form>
                                    </div>                                    
                                    <div class="span2">
                                        <form action="<?php echo base_url() ?>index.php/mapos/queryfactory" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Query Factory</label>
                                                <button >Gerar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span2">
                                        <form action="<?php echo base_url() ?>index.php/mapos/listadesenhosbyos" method="post" name="form1" id="form1">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="span12" >
                                                <label for="idGrupoServico" class="control-label">Get Desenhos OS: </label>
                                                <input type="text" name="idOs" id="idOs" >
                                                <button >Gerar</button>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>