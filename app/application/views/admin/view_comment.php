<?php
$pagedata = $content;
//print_r($companyData);

?>

<?php $this->view('admin/include/header', $pagedata); ?>

<link href="<?php echo base_url('theme/css/jquery.raty.css');?>" rel="stylesheet">
<script src="<?php echo base_url('theme/js/jquery.raty.js');?>"></script> 

<div class="container-fluid">
	
	<div class="dashboard-container" style="margin-top:50px !important;">
		 <div class="top-nav">
            <ul class="nav nav-tabs">
             <li role="presentation" class="active"><a href="<?=site_url('admin/user/view')?>">Company Management</a></li>  
              <li role="presentation" class=""><a href="<?=site_url('admin/user/view_user')?>">User Management</a></li>
             
            </ul>
            <div class="clearfix sub-nav" style="">
                <ul class="">
                 <!-- <li role="presentation" class="active"><a href="<?=site_url('admin/user/view')?>">Users</a></li>    -->
                  <li role="presentation"><a href="<?=site_url('admin/user/add')?>">Add User</a></li>
                </ul>
            </div>
        </div>      
	</div>
	
	<div class="clearfix" style="background:#e4e4e4; min-height:400px;">
		<div class="col-md-12">
                    
			<?php
                        //print_r($companyData);echo $companyData->CompanyName;
			$this->view('include/messages');
			?>
                    
			<div class="panel panel-default" style="margin-top:20px;">
				<div class="panel-heading">
			    	<h1 class="panel-title">Company Information</h1>
			  	</div>
			  	<div class="panel-body">
			  	
			  			<input type="hidden" name="editUser" value="1" />
			  	<div class="row" style="padding-left:30px;padding-top:30px;">		
			  			<div class="col-md-2"><label>Company Name :</label></div>
						<div class="col-md-2"><?= set_value('CompanyName', $companyData->CompanyName) ?></div>
					  	
					  	<div class="col-md-2"><label>Company Website</label></div>
						<div class="col-md-2"><?= set_value('CompanyWebsite', $companyData->CompanyWebsite) ?></div>
					  	
					  	<div class="col-md-2"><label>Company type</label></div>
						<div class="col-md-2"><?= set_value('contactno', $companyData->CompanyType) ?></div>
				</div>
                <div class="row" style="padding-left:30px;padding-top:30px;">						  	
					  	<div class="col-md-2"><label>BIC Theme alignment </label></div>
						<div class="col-md-2"><?= set_value('ThemeAlign', $companyData->ThemeAlign) ?></div>
				            	
					  	
					  	<div class="col-md-2"><label>Company summary</label></div>
						<div class="col-md-2"><?= set_value('CompanySumm', $companyData->CompanySumm) ?></div>
				
					  	<div class="col-md-2"><label>Value proposition to KM</label></div>
						<div class="col-md-2"><?= set_value('ValueProposition', $companyData->ValueProposition) ?></div>
				</div>
                <div class="row" style="padding-left:30px;padding-top:30px;">	  	
					  	<div class="col-md-2"><label>BIC Investment</label></div>
                        <div class="col-md-2"><?= set_value('ValueProposition', $companyData->BicInvestment) ?></div>
                          
					  	<div class="col-md-2"><label>Company progress / updates</label></div>
                        <div class="col-md-2"><?= set_value('CompanyProgress', $companyData->CompanyProgress) ?></div>
              
                        <div class="col-md-2"><label>KM business development plans</label></div>
						<div class="col-md-2"><?= set_value('DevelopmentPlans', $companyData->DevelopmentPlans) ?></div>
				  </div>
                <div class="row" style="padding-left:30px;padding-top:30px;">          	  	
					  	<div class="col-md-2"><label>Customer target</label></div>
                        <div class="col-md-2"><?= set_value('CustomerTarget', $companyData->CustomerTarget) ?></div>
                          
                        <div class="col-md-2"><label>Source</label></div>
                        <div class="col-md-2"><?= set_value('Source', $companyData->Source) ?></div>
                          
                        <div class="col-md-2"><label>Bic Lead</label></div>
                        <div class="col-md-2"><?= set_value('BicLead', $companyData->BicLead) ?></div>
                </div>
                <div class="row" style="padding-left:30px;padding-top:30px;">        
                        <div class="col-md-2"><label>Last Updated</label></div>
                        <div class="col-md-2"><?= set_value('LastUpdated', $companyData->LastUpdated) ?></div>
                          
                        <div class="col-md-2"><label>Status</label></div>
                        <div class="col-md-2"><?= set_value('Status', $companyData->Status) ?></div>
                </div>
                
              </div>
		    </div>
            
                        <div class="panel panel-default" style="margin-top:20px;">
				<div class="panel-heading">
			    	<h1 class="panel-title">Comments </h1>
			  	</div>
			  	<div class="panel-body">
                                    <?php 
                                        //print_r($commentData);
                                        if(!empty($commentData))
                                        {
                                            $count=0;
                                            foreach($commentData as $commentVal)
                                            {
                                                $count++;
                                            ?>    
                                                <div class="well well-sm">
                                                    <h4 style="font-size:14px;font-weight: bold;"><?php echo $commentVal['FirstName'].' '.$commentVal['LastName'].' ('.$commentVal['Email'].')'; ?></h4>
                                                    <div id="userRating_<?php echo $count; ?>"></div>
                                                    <p><?php echo date('d-M-Y',strtotime($commentVal['DateTime'])); ?></p>
                                                    <p><?php echo $commentVal['Comment']; ?></p>
                                                </div>
                                                <script>
                                                    var rating = <?php echo $commentVal['Rating']; ?> || 0;
                                                    $.fn.raty.defaults.path = '<?php echo base_url('theme/images'); ?>';
                                                    $("#userRating_<?php echo $count; ?>").raty({
                                                        scoreName: 'rating',
                                                        score:rating,
                                                        readOnly:true     
                                                    }); 
                                                </script>
                                            <?php    
                                            }    
                                        }    
                                     ?>
                                </div>
                        </div>
            
                </div>
        </div>
</div>
                

<?php $this->view('admin/include/footer', $pagedata); ?>

