<style type="text/css">
label.error {
    color: red;
    font-weight: bold;
}
</style>
<div class="container-fluid" style="padding:0;">
   <?php $this->view('include/header'); ?>    
</div>   

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
          	<?php  $this->view('include/sidebar'); ?>   
        </div>
        <div class="col-md-10">       
        	
			<?php $this->view('include/messages'); ?>
			<div class="panel panel-default" style="margin-top:20px;">
				<div class="panel-heading">
			    	<h1 class="panel-title">Change Password</h1>
			  	</div>

			  	<div class="panel-body">
			  		<form class="form-horizontal" role="form" action="<?php echo base_url(); ?>company/partner_change_password" method="post" name="partnerchangepwd" id="partnerchangepwd">			  			
			  			<div class="form-group">
						    <label for="username" class="col-sm-2 control-label">Old Password</label>
						    <div class="col-sm-3">
						    	<input type="password" name="oldpassword" id="oldpassword" class="form-control" placeholder="Old Password"> 
						    </div>
					  	</div>	
					  	
					  	<div class="form-group">
						    <label for="" class="col-sm-2 control-label">New Password</label>
						    <div class="col-sm-3">
						    	<input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="New Password">  
						    </div>
					  	</div>	
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Confirm New Password</label>
                            <div class="col-sm-3">
                                <input type="password" name="cnewpassword" id="cnewpassword" class="form-control" placeholder="Confirm New Password">         
                            </div>
                        </div>
					
                        <div class="form-group">
                            <div class="col-sm-3 col-sm-offset-2">
                                <input type="submit" class="btn btn-info" name="submit" value="Submit">
                            </div>
                        </div>     	       
					</form>
			  	</div>
			</div>
		</div>
	</div>
</div>
 
<script type="text/javascript" src="<?php echo base_url(); ?>theme/js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){	
	$("#partnerchangepwd").validate({
	errorClass: "error",	
    rules: 
    {
	    oldpassword: {
	        required: true,
	        remote : 
	        {
	            url: "<?php echo base_url();?>company/partner_old_password",
	            type: 'POST'                                      
	        }
	    },
	    newpassword: {
	        required: true
	    },	    
	    cnewpassword: {
	        required: true,
	        equalTo:'#newpassword'
	    },	   
  	},
   	messages: 
   	{
            oldpassword: { required :"Please enter old password.", remote : "old password does not match."},
            newpassword: "Please enter new password.",                                
            cnewpassword: {required:"Please enter confirm new password.",equalTo:"Please enter same value again." },
    },

    });
});
</script>
