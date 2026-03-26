<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Ubertec</title>
	<link href="<?php echo base_url()?>assets5_2/css/bootstrap.min.css" rel="stylesheet" >
</head>

<body style="background-image: url('<?php echo base_url()?>assets5_2/img/background/background.png');background-size: cover;background-attachment:fixed;">
<?php if(isset($view)){echo $this->load->view($view);}?>
</body>
</html>