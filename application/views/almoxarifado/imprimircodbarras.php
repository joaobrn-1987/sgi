<html lang="en">
<head>
  <meta charset="utf-8">
  <script type="text/javascript" src="<?php echo base_url() ?>js/jsbarcode.all.min.js"></script>
  <style>
    body { width: 8.5in;  background:#e8e8e8; }
    /* Avery 5960 labels */
    .label{
        width: 3.25in; height: 1.25in; padding: .125in 0.1875in;  margin-right: .12in; /* the gutter */
        float: left;  overflow: hidden; background:#fff; outline: 1px dotted #999;
    }
    .page-break { clear: left; display:block; page-break-after:always; }
  </style>
</head>
<body>
    <?php 
    $contagem = 0;
    foreach($result as $r){
        for($x = 0; $x<$r->qtdTDProd;$x++ ){
            echo '<div class="label" align="center">';
                echo ''.date("d/m/Y H:i:s").'<br>';
                echo 'PN: '.$r->pn.'<br>';
                echo '<svg class="barcode"  jsbarcode-value="'.$r->pn.'" jsbarcode-textmargin="0" jsbarcode-fontoptions="bold" ></svg>';
            echo '</div>';
            $contagem ++;
            if($contagem >= 16){
                echo '<div class="page-break"></div>';
                $contagem = 0;
            }
        }
               
    }?>
    <!--
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="label">
    Name<br>
    Address<br>
    City, State Zip
  </div>
  <div class="page-break"></div>-->
  <script type="text/javascript"> JsBarcode(".barcode",null,{displayValue: false,height: 60}).init();</script>
</body>
</html>