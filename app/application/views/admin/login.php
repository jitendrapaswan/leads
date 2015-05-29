<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>

        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.9.1.min.js"></script>      
        <script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>    
    
        <link href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url();?>css/bootstrap-responsive.css" rel="stylesheet">
        <link href="<?php echo base_url();?>css/adminstyle.css" rel="stylesheet">

<script type="text/javascript">
$(document).ready(function()
{
    $("#login").validate({
    errorClass: "error",	
    rules: 
    {
	    password: {
	        required: true
	    },	    
	    email: {
	        required: true,
	        email: true,
	    },	   
  	},
   	messages: 
   	{
        password: "Please enter password.",                                
        email: {required:"Please enter email address.",email:"Please enter a valid email address." },
    },

    });
});
</script>

<style>
img
{
    height: 40px;
}
</style>

</head>

<body class="login">
    <noscript><div class="alert alert-error">Enable JAVASCRIPT in your browser to view full contents of this site.</div></noscript>
    <div class="signin-form">
        <?=$this->view('include/messages')?>
        <form method="post" accept-charset="utf-8" action=""  class="form-horizontal"  id="login" name="frmlogin" autocomplete = "off" role="form" />
            <h2 align="center">Partner Alliance Admin &nbsp;<img src="<?php echo base_url() ?>image/lock.jpg" /></h2><br /><br />
        
            <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Email<em>*</em></label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="email" id="email" placeholder="Email Id"/>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Password<em>*</em></label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password"/>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="<?php echo site_url('company/register'); ?>" class="btn btn-primary">Sign Up</a>
                </div>
            </div>
        </form> 
    </div>
</body>
</html>
