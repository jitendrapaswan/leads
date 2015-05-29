<style type="text/css">
label.error {
    color: red;
    font-weight: bold;
}
</style>
<script type="text/javascript">
$(document).ready(function(){	
	$("#partnerlogin").validate({
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

<div class="container">
	<?php $this->view('include/messages');  ?>
	<form action="<?php echo base_url(); ?>company/login" method="post" name="partnerlogin" id="partnerlogin">		
		<div class="row">
			<div class="col-md-6 col-md-offset-3"><h3>Partner Login</h3></div><br/><br/>		
			<div class="col-md-6 col-md-offset-3">
	            <label class="control-lable"></label>
	            <input type="text" name="email" id="email" class="form-control" placeholder="Email">            
	        </div>

	        <div class="col-md-6 col-md-offset-3">
	            <label class="control-lable"></label>
	            <input type="password" name="password" id="password" class="form-control" placeholder="Password">            
	        </div>	        

	        <div class="col-md-1 col-md-offset-3" style="margin-top:40px;text-align:center;">              
              <button type="submit" class="btn btn-info" name="submit">Login</button>                 
        	</div>

        	<div class="col-md-2 col-md-offset-3" style="margin-top:40px;text-align:center;">              
        		<a href="<?php echo base_url(); ?>company/register"><button type="button" class="btn btn-info" name="submit">Create an account</button></a>              
        	</div>
	    </div>
</div>