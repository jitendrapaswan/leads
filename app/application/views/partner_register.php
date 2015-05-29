<style type="text/css">
label.error {
    color: red;
    font-weight: bold;
}
</style>
<script type="text/javascript">
$(document).ready(function(){	
	$("#partnersignup").validate({
	errorClass: "error",	
    rules: 
    {
	    company_name: {
	        required: true
	    },
	    company_website: {
	        required: true
	    },	    
	    first_name: {
	        required: true
	    },
            country:{
                required: true
            },
	    email: {
	        required: true,
	        email: true,
          remote : 
          {
              url: "<?php echo base_url();?>user/check_email_exist",
              type: 'POST'                                      
          }
	    },
  	},
   	messages: 
   	{
            company_name: "Please enter company name.",
            country: "Please select your country.",
            company_website: "Please enter company website.",                    
            first_name : "Please enter first name.",
            email: {required:"Please enter email address.",email:"Please enter a valid email address." , remote:"Email already exist.Please change it." },
    },

    });
});
</script>

<div class="container" style="width:50%;">
	<?php $this->view('include/messages');  ?>
	<form action="<?php echo base_url(); ?>company/register" method="post" name="partnersignup" id="partnersignup">
		<div class="row">
			<div class="form-group col-md-12">
				<h3> Company Infomation</h3>
        <a href="<?php echo base_url(); ?>company/login" style="float:right;margin-top:-31px;"><button type="button" class="btn btn-info" name="submit">Login</button></a>				
			</div>

			<!-- <div class="form-group col-md-6">
				<a href="<?php echo base_url(); ?>home/partnerLogin" style="float:right;margin-top:-31px;"><button type="button" class="btn btn-info" name="submit">Login</button></a> 		
			</div> -->

			<div class="form-group col-md-6">
	            <label class="control-lable"></label>
	            <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name" value="<?php echo set_value('company_name');?>">            
	        </div>

	        <div class="form-group col-md-6">
	            <label class="control-lable"></label>
	            <input type="text" name="company_website" id="company_website" class="form-control" placeholder="Company Website" value="<?php echo set_value('company_website');?>">            
	        </div>

	        <div class="form-group col-md-12">
	            <label class="control-lable"></label>
	            <textarea name="company_summary" id="company_summary" class="form-control" placeholder="Company Summary" rows="2" cols="20"><?php echo set_value('company_summary');?></textarea>           
	        </div>
	  
		
		
        	<div class="form-group col-md-12"><h3>Primary Contact Infomation</h3></div>

        	<div class="form-group col-md-6">
                    <label class="control-lable"></label>           
<!--                    <select class="form-control" name="title" placehoder="Title">
                        <option value="">Select Title</option>
                        <option value="Mr.">Mr.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Miss.">Miss</option>
                    </select>
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?php echo set_value('first_name');?>">-->
                    <div class="input-group">
                        
                        <select class="form-control" name="title" placehoder="Title" style="width:33%">
                            <option value="">Title</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Miss.">Miss</option>
                        </select>
                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?php echo set_value('first_name');?>" style="width:66%">
                        
                    </div>
          	</div>
        	
        	<div class="form-group col-md-6">
            	<label class="control-lable"></label>
            	<input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?php echo set_value('last_name');?>">            
        	</div>

        	<div class="form-group col-md-6">
            	<label class="control-lable"></label>
            	<input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo set_value('email');?>">            	
        	</div>

                <div class="form-group col-md-6">
                    <label class="control-lable"></label>              
                    <input type="text" name="contact_phone" id="contact_phone" class="form-control" placeholder="Contact Phone" value="<?php echo set_value('contact_phone');?>">
                </div>
                
                <div class="form-group col-md-6">
                    <label class="control-lable"></label> 
                    <select name="country" id="country" class="form-control">
                        <option value="">Select Country</option>
                        <?php
                            $countryData = $this->utility_model->get_country_list();
                            if(!empty($countryData))
                            {
                                foreach($countryData as $countryVal)
                                {
                                    echo '<option value="'.$countryVal->country_id.'">'.$countryVal->name.'</option>';
                                }
                            }
                        ?>
                    </select>
          	</div>
        
        	<div class="form-group col-md-6">
                <label class="control-lable"></label>              
              	<input type="text" name="contact_address" id="contact_address" class="form-control" placeholder="Address Line 1" value="<?php echo set_value('contact_address');?>">                             
          	</div>
                
                <div class="form-group col-md-6">
                <label class="control-lable"></label>              
              	<input type="text" name="contact_address_2" id="contact_address_2" class="form-control" placeholder="Address Line 2" value="<?php echo set_value('contact_address_2');?>">                             
          	</div>
                
                
                
                <div class="form-group col-md-6">
                <label class="control-lable"></label>              
              	<input type="text" name="city" id="city" class="form-control" placeholder="City" value="<?php echo set_value('city');?>">                             
          	</div>
                
                <div class="form-group col-md-6">
                <label class="control-lable"></label>              
              	<input type="text" name="state" id="state" class="form-control" placeholder="State" value="<?php echo set_value('state');?>">                             
          	</div>
                
                <div class="form-group col-md-6">
                <label class="control-lable"></label>              
              	<input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zip Code" value="<?php echo set_value('zipcode');?>">                             
          	</div>

          	
        	<div class="col-md-6 col-md-offset-3" style="padding:20px;text-align:center;">              
              <button type="submit" class="btn btn-info" name="submit">Submit</button>              
        	</div>
	    </div>
</div>
