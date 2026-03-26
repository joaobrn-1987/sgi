<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/moment.js"></script>
<script src="<?php echo base_url() ?>js/jquery.inputmask.bundle.js"></script>
<!--
<script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>-->
<style>
    /* This parent can be any width and height */
.block {
  text-align: center;
  height: 100%;
}

/* The ghost, nudged to maintain perfect centering */
.block:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -0.25em; /* Adjusts for spacing */
}

/* The element to be centered, can
   also be of any width and height */ 
.centered {
  display: inline;
  vertical-align: middle;
  width: 99%;
}
#overlay {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.93);
  z-index: 2;
  cursor: zoom-out;
}

#text{
  position: absolute;
  top: 50%;
  left: 50%;
  font-size: 50px;
  color: white;
  transform: translate(-50%,-50%);
  -ms-transform: translate(-50%,-50%);
}
</style>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Laudo Fotográfico</h5>
            </div>
            <div class="widget-content nopadding">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
                        <div class="tab-pane active">
                            <div class="span12" id="divCadastrarOs">
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Orçamento: </label>
                                        <input type="text" class="span12"  value="<?php echo $orcamentoItem->idOrcamentos;?>" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Cliente: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->nomeCliente;?>" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Solicitante: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->nome;?>" readonly />
                                    </div>
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">PN: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->pn;?>" readonly />
                                    </div>
                                    <div class="span5" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Descrição Produto: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->descricao;?>" readonly />
                                    </div>
                                    <div class="span2" class="control-group">
                                        <label for="idGrupoServico" class="control-label">Ref.: </label>
                                        <input type="text" class="span12" value="<?php echo $orcamentoItem->referencia;?>" readonly />
                                    </div>
                                    <div class="span3" class="control-group">
                                        <label for="idGrupoServico" class="control-label">TAG: </label>
                                        <input type="text" class="span12" value="" readonly />
                                    </div>
                                    
                                </div>
                                <div class="span12" style="padding: 1%; margin-left: 0">
                                        
                                    <a class="btn btn-mini btn-inverse" href="<?php echo base_url().'index.php/orcamentos/laudoPrint/'.$orcamentoItem->idOrcamento_item?>"><i class="icon-print icon-white"></i> Imprimir</a>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="tab-content" style="background-color: white;border: 1px #cdcdcd solid;">
            <form id="formSalvar" action="<?php echo base_url(); ?>index.php/peritagem/salvarlaudo" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
                <input type="hidden" id="idOrcamentoItem" name="idOrcamentoItem" value="<?php echo $idOrcamentoItem;?>"/>
                <div class="tab-pane active" id="classFotograf">
                    <form></form>
                    <?php $contador = 0; 
                    if(!empty($fotografias)){                        
                        foreach($fotografias as $r){?>
                            <div class="span4" style="border: 1px solid #cdcdcd;border-top:0px; <?php if($contador % 3 == 0){echo 'margin-left: 0px';}?>">
                                <div style="min-height: 350px">
                                    <div class="file_<?php echo $contador?>" style="background-color: #cdcdcd;height: 300px;margin: 30px; display:none">
                                        <!--
                                        <form id="formDelete_<?php echo $contador;?>" action="<?php echo base_url(); ?>index.php/peritagem/deletelaudo" id="formAlterar" enctype="multipart/form-data" method="post" class="form-horizontal">
                                            --><div style="padding: 137px 25%">
                                                <input type="file" name="file<?php echo $r->idAnexoLaudo;?>" onchange="loadFile(<?php echo $contador;?>,event)" accept="image/*" capture="camera"> 
                                            </div><!--
                                        </form>-->
                                    </div>
                                    <div class="file_img_<?php echo $contador?>" style="/*background-color: #cdcdcd;*/height: 300px;margin: 30px; display:block"><!--
                                        <div class="span12">
                                            <div class="span3">

                                            </div>
                                            <div class="span6">
                                                texto
                                            </div>
                                            <div class="span3">
                                                <div style="text-align:right; margin-bottom:10px">
                                                    <button style="margin-right: 1%" data-toggle="modal"
                                                                        class="btn btn-warning tip-top " class="excluir"
                                                                        onclick="alterImag(<?php echo $contador;?>)">
                                                                        <font size=1>A</font>
                                                                    </button>    
                                                    <a style="margin-right: 1%" data-toggle="modal"
                                                                        class="btn btn-danger tip-top " class="excluir"
                                                                    onclick="deletImag(<?php echo $r->idAnexoLaudo;?>)" idFotoLaudo = "<?php echo $r->idAnexoLaudo;?>">
                                                                    <font size=1>X</font>
                                                    </a>
                                                    
                                                </div>
                                            </div>
                                        </div>-->
                                        <div style="margin-bottom:10px">
                                            <div style="width: 20%;display:inline-block"></div>
                                            <div style="text-align:center;width: 58%;display:inline-block"><?php if(!empty($r->pn)){echo "PN: ".$r->pn." - ";}echo $r->descricaoServicoItens; ?></div>
                                            <div style="text-align:right;width: 20%;display:inline-block">
                                                <button style="margin-right: 1%" data-toggle="modal"
                                                                        class="btn btn-warning tip-top " class="excluir"
                                                                        onclick="alterImag(<?php echo $contador;?>)">
                                                                        <font size=1>A</font>
                                                                    </button>    
                                                    <a style="margin-right: 1%" data-toggle="modal"
                                                                        class="btn btn-danger tip-top " class="excluir"
                                                                    onclick="deletImag(<?php echo $r->idAnexoLaudo;?>)" idFotoLaudo = "<?php echo $r->idAnexoLaudo;?>">
                                                                    <font size=1>X</font>
                                                    </a>
                                                </div>
                                           
                                            
                                        </div>
                                        <div class="block">
                                            <div class="centered">
                                                <img id="output_<?php echo $contador?>" src="<?php echo base_url().$r->caminho.$r->imagem?>" alt="your image" style="max-height: 99%;max-width: 99%; cursor: zoom-in" onclick="on(<?php echo $contador;?>)"/>
                                                <input type="hidden" name="idAnexoLaudo[]" id="idAnexoLaudo[]" value="<?php echo $r->idAnexoLaudo;?>">               
                                            </div>                                
                                        </div>
                                    </div>
                                    <div style="margin-top:50px; margin-bottom:15px">
                                        <div class="comentario_<?php echo $contador?>" style="margin-left: 30px;margin-right: 30px; text-align:center">
                                            <div style="text-align:left;margin-left:20px">
                                                <label>Comentários:</label>
                                            </div>
                                            <textarea name="inputComm[]" id="inputComm[]"  style="max-width:95%; width:90%; height: 130px;"><?php echo $r->comentarios ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        $contador = $contador + 1;
                        }                    
                    }else{ ?>
                        <div class="span4" style="border: 1px solid #cdcdcd;border-top:0px">
                            <div style="min-height: 350px">
                                <div class="file_0" style="background-color: #cdcdcd;height: 300px;margin: 30px;">
                                    <div style="padding: 137px 25%">
                                        <input type="file" name="fileToUpload[]" id="fileToUpload[]" onchange="loadFile(0,event)" accept="image/*" capture="camera">           
                                        <input type="hidden" name="idAnexoLaudo[]" id="idAnexoLaudo[]" value=""> 
                                    </div>
                                </div>
                                <div class="file_img_0" style="/*background-color: #cdcdcd;*/height: 300px;margin: 30px; display:none">
                                    <div style="text-align:right; margin-bottom:10px">
                                        <button style="margin-right: 1%" data-toggle="modal"
                                                            class="btn btn-warning tip-top " class="excluir"
                                                            onclick="alterImag(0)">
                                                            <font size=1>A</font>
                                                        </button>    
                                        <button style="margin-right: 1%" data-toggle="modal"
                                         class="btn btn-danger tip-top " class="excluir"
                                                        onclick="deletImag(0)">
                                                        <font size=1>X</font>
                                        </button>
                                        
                                    </div>
                                    <div class="block">
                                        <div class="centered">
                                            <img id="output_0" src="#" alt="your image" style="max-height: 99%;max-width: 99%; cursor: zoom-in" onclick="on(0)"/>     
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top:50px; margin-bottom:15px">
                                    <div class="comentario_0" style="margin-left: 30px;margin-right: 30px; text-align:center">
                                        <div style="text-align:left;margin-left:20px">
                                            <label>Comentários:</label>
                                        </div>
                                        <textarea  name="inputCommNew[]" style="max-width:95%; width:90%; height: 130px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> <?php
                        $contador = 1;
                    }   ?>
                                       
                </div>
            </form>
        </div>
    </div>
</div>
<div style="text-align: center;margin-top: 15px;">
    <a onclick="duplicar()" class="btn btn-warning"> Nova Foto</a>
    <a onclick="document.getElementById('formSalvar').submit();" class="btn btn-success"> Salvar Alterações</a>
</div>
<div id="overlay" onclick="off(0)">
    <div id="text">
        <img id="output2_0" src="#" />
    </div>
</div>
<div id="modalDeletarLaudo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url(); ?>index.php/peritagem/deletarLaudo<?php if(!empty($fotografias)){ echo '/'.$fotografias[0]->idOrc_item;} ?>"  enctype="multipart/form-data" method="post" class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Confirmar exclusão</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idFotoLaudo" name="idFotoLaudo" value="" />
            <h5 style="text-align: center">Deseja realmente excluir está fotográfia?</h5>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCancelExcluir">Cancelar</button>
        <button class="btn btn-success">Confirmar</button>
        </div>
    </form>
</div>
<script>
    var contador = <?php echo $contador?>;    
    function duplicar(){
        var html = '<div class="span4" style="border: 1px solid #cdcdcd;border-top:0px" id="delet_'+contador+'">';
        if(contador % 3 == 0){
            html = '<div class="span4" style="border: 1px solid #cdcdcd;border-top:0px; margin-left:0px" id="delet_'+contador+'">';
        }
        html += '<div style="min-height: 350px">'+
                    '<div class="file_'+contador+'" style="background-color: #cdcdcd;height: 300px;margin: 30px;">'+
                        '<div style="padding: 137px 25%">'+
                            '<input type="file" name="fileToUpload[]" id="fileToUpload[]" onchange="loadFile('+contador+',event)" accept="image/*" capture="camera">'+
                            '<input type="hidden" name="idAnexoLaudo[]" id="idAnexoLaudo[]" value="">'+
                        '</div>'+
                    '</div>'+
                    '<div class="file_img_'+contador+'" style="height: 300px;margin: 30px; display:none">'+
                        '<div style="text-align:right; margin-bottom:10px">'+
                            '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-warning tip-top " class="excluir" onclick="alterImag('+contador+')">'+
                                '<font size=1>A</font>'+
                            '</button>'+
                            '<button style="margin-right: 1%" data-toggle="modal" class="btn btn-danger tip-top " class="excluir" onclick="deletDiv('+contador+')">'+
                                '<font size=1>X</font>'+
                            '</button>'+                                
                        '</div>'+
                        '<div class="block">'+
                            '<div class="centered">'+
                                '<img id="output_'+contador+'" src="#" alt="your image" style="max-height: 99%;max-width: 99%; cursor: zoom-in" onclick="on('+contador+')"/>'+
                            '</div>'+                                
                        '</div>'+
                    '</div>'+
                    '<div style="margin-top:50px; margin-bottom:15px">'+
                        '<div  class="comentario_'+contador+'" style="margin-left: 30px;margin-right: 30px; text-align:center">'+
                            '<div style="text-align:left;margin-left:20px">'+
                                '<label>Comentários:</label>'+
                            '</div>'+                               
                            '<textarea  name="inputCommNew[]" style="max-width:95%; width:90%; height: 130px;"></textarea>'+
                        '</div>';
                    '</div>'+
                '</div>'+
            '</div>';
            $('#classFotograf').append(html);
        contador ++;
    }
    function loadFile (pos,event) {
        var output = document.getElementById('output_'+pos);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
        $('.file_'+pos).hide();
        $('.file_img_'+pos).show();
    };
    
    function deletDiv(pos){
        $("#delet_"+pos).remove(); 
    }

    function on(pos) {
        var output2 = document.getElementById('output2_0');
        origemOutput = document.getElementById('output_'+pos);
        output2.src = origemOutput.src;
        output2.onload = function() {
            URL.revokeObjectURL(output2.src) // free memory
        }
        document.getElementById("overlay").style.display = "block";
    }

    function deletImag(pos){
        $('#modalDeletarLaudo').modal('show');
    }
    function alterImag(pos){
        $('.file_'+pos).show();
        $('.file_img_'+pos).hide();        
    }

    function off(pos) {
        document.getElementById("overlay").style.display = "none";
    }
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var idFotoLaudo = $(this).attr('idFotoLaudo');
            $('#idFotoLaudo').val(idFotoLaudo);

        });
    });
</script>