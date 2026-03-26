<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.maskedinput.js"></script>

<div>
    <h3>Use the form below to send email</h3>
    <form method="post" action="<?php echo base_url()?>index.php/email/send" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <input type="email" id="to" name="to" placeholder="Receiver Email">
        <br><br>
        <input type="text" id="subject" name="subject" placeholder="Subject">
        <br><br>
        <textarea rows="6" id="message" name="message" placeholder="Type your message here"></textarea>
        <br><br>
        <input type="submit" value="Send Email" />
    </form>
</div>
 