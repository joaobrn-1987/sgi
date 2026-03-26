<table class="table table-bordered ">
    <thead>
        <tr>
        
        <th>Cód.</th>
        <th>Descrição</th>
        <th>Quantidade</th>
        <th>Empresa</th>
        <th>Local</th>         
        <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(isset($result))
        foreach($result as $r){?>
        <tr>
            <td>
                <?php echo $r->idAlmoEstoque;?>
                <input type='hidden' value='<?php echo $r->idAlmoEstoque;?>' name='idAlmoEstoque_[]'>
            </td>
            <td>
                <?php echo $r->descricaoInsumo;?>
            </td>
            <td>
                <?php echo $r->quantidade;?> Unid.<?php
                if($r->metrica == 1){
                ?> | <?php echo $r->comprimento; ?> CM<?php
                } else if($r->metrica == 2){
                ?> | <?php echo $r->volume; ?> ML<?php
                }
                ?>
            </td>
            <td>
                <?php echo $r->nome;?>
            </td>
            <td>
                <?php echo $r->local;?>
            </td>
        </tr>
        <?php 
        }?>
    </tbody>
</table>