<div class="accordion" id="collapse-group">
    <div class="accordion-group widget-box">
        <div class="accordion-heading">
            <div class="widget-title">
                <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                    <span class="icon"><i class="icon-list"></i></span><h5>Dados do Produto PN</h5>
                </a>
            </div>
        </div>
        <div class="collapse in accordion-body">
            <div class="widget-content">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="text-align: right; width: 30%"><strong>Descrição</strong></td>
                            <td><?php echo $result->descricao ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>PN</strong></td>
                            <td><?php echo $result->pn ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right"><strong>Referencia</strong></td>
                            <td><?php echo $result->referencia; ?></td>
                        </tr>
                       
                       
                        
                  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

