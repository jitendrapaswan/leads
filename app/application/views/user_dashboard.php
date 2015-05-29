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
			<div class="panel panel-default" style="margin-top:20px;">
				<div class="panel-heading">
			    	<h1 class="panel-title">Partner List</h1>
			  	</div>

			  	<div class="panel-body">
                    
                    <!-- search by company -->
                    <div class="clearfix" style="margin-bottom:10px;">
                        <!-- <form class="form-inline" role="form" method="get" action="">
                            <div class="form-group">Filter:
                                <div class="form-group"><input type="text" name="search" class="form-control" id="search" placeholder="Company Name" required></div>
                            </div>
                            <button type="submit" class="btn btn-info">Filter</button>
                        </form> -->
                    </div>
                          
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr style="" class="active">                                
                                <th style="vertical-align: middle;">Company Name</th>
                                <th style="vertical-align: middle;">Company Website</th>
                                <th style="vertical-align: middle;">Company Summary</th>
                            </tr>
                            </thead>
                              	<tbody>
                              <?php if(!empty($companyInfo))
                              		{
                              			foreach ($companyInfo as $value) 
                              			{?>
	                              			<tr>
	                              				<td><?php echo !empty($value->CompanyName)    ? $value->CompanyName 	 : "";?></td>
	                              				<td><?php echo !empty($value->CompanyWebsite) ? $value->CompanyWebsite   : "";?></td>
	                              				<td><?php echo !empty($value->CompanySumm) 	  ? $value->CompanySumm      : "";?></td>	
	                              			</tr>                              			
                              	  <?php }
                              	    }
                              		else 
                              		{ ?>
                                		<tr>
                                			<td colspan="3">No record(s) found!</td>
                                		</tr>
                            		<?php } ?>                              
                              </tbody>                              
                          </table> 
                          <?php echo $link;?>                                               
			  		</div>

			</div>
		</div>
	</div>
</div>