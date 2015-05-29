<?php  $this->view('admin/include/header_menu'); ?>    
<script type="text/javascript">
jQuery(document).ready(function ($)
{
	filter_records();
});
function filter_records() 
{
	if($("input:checked").length >= 1)
	{
		jQuery.post("<?php echo base_url();?>admin/partner/filter_history_records",jQuery("#historyform").serialize(),function(result)
		{
			jQuery("#search_results").html('');
			jQuery("#search_results").html(result);		

		});	
	}
	else
	{
		jQuery.post("<?php echo base_url();?>admin/partner/filter_history_records",jQuery("#historyform").serialize(),function(result)
		{
			jQuery("#search_results").html('');
			jQuery("#search_results").html(result);		

		});
	}
	
}


</script>
<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-2"><?php  $this->view('admin/include/sidebar'); ?></div> 
    	<div class="col-md-10">
    		<div class="panel panel-default" style="margin-top:20px;">
    			<div class="panel-heading">
    				<span class="panel-title">Company History - <b><?php echo ucfirst($info->CompanyName); ?></b></h1></span>
					<div class="pull-right">
              			<a href="<?php echo base_url();?>admin/company/view_company_detail/<?php echo $info->id;?>"><button type="button" class="btn btn-xs btn-primary">View</button></a>
              			<a href="<?php echo base_url();?>admin/partner/editCompanyDetail/<?php echo $info->id;?>"><button type="button" class="btn btn-xs btn-primary">Edit</button></a>
              			
            		</div>
					<ul class="list-group" style="margin-top:10px;">						
						<?php if(!empty($info))
						{?>
							<form id="historyform" name="historyform">
							<input type="hidden" name="company_id" value="<?php echo $info->id; ?>">	
							<li class="list-group-item">
							<?php 
								if(!empty($info->CompanyName)) 
								{?> 
									<input type="checkbox" name="info[]" id="CompanyName" value="CompanyName" onChange="filter_records();"> <b>Company Name</b> - <?php echo $info->CompanyName.'&nbsp;&nbsp';
								}?>

								<?php if(!empty($info->CompanyWebsite)) 
								{?> 
									<input type="checkbox" name="info[]" id="CompanyWebsite" value="CompanyWebsite" onChange="filter_records();" > <b>Company Website</b> - <?php echo $info->CompanyWebsite.'&nbsp;&nbsp';
								}?>

								<?php if(!empty($info->CompanyRating)) 
								{?> 
									<input type="checkbox" name="info[]" id="CompanyRating" value="CompanyRating" onChange="filter_records();" > <b>Company Rating</b> - <?php echo $info->CompanyRating.'&nbsp;&nbsp';
								}?>

								<?php if(!empty($info->ThemeAlign)) 
								{?> 
									<input type="checkbox" name="info[]" id="ThemeAlign" value="ThemeAlign" onChange="filter_records();"> <b>Theme Align</b> - <?php echo $info->ThemeAlign.'&nbsp;&nbsp';
								}?>

								<?php if(!empty($info->DevelopmentPlans)) 
								{?> 
									<input type="checkbox" name="info[]" id="DevelopmentPlans" value="DevelopmentPlans"  onChange="filter_records();"> <b>DevelopmentPlans</b> - <?php echo $info->DevelopmentPlans.'&nbsp;&nbsp';
								}?>

								<?php if(!empty($info->CustomerTarget)) 
								{?> 
									<input type="checkbox" name="info[]" id="CustomerTarget" value="CustomerTarget" onChange="filter_records();"> <b>Customer Target</b> - <?php echo $info->CustomerTarget.'&nbsp;&nbsp';
								}?>

								<?php if(!empty($info->Source)) 
								{?> 
									<input type="checkbox" name="info[]" id="Source" value="Source" onChange="filter_records();"> <b>Source</b> - <?php echo $info->Source.'&nbsp;&nbsp';
								}?>

								<?php if(!empty($info->BicLead)) 
								{?> 
									<input type="checkbox" name="info[]" id="BicLead" value="BicLead" onChange="filter_records();"> <b>Bic Lead</b> - <?php echo $info->BicLead.'&nbsp;&nbsp';
								}?>


								<?php if(!empty($info->BicInvestment) == "yes") 
								{
									if(!empty($info->InvestmentUSD))
									{?> 
										<input type="checkbox" name="info[]" id="InvestmentUSD" value="InvestmentUSD" onChange="filter_records();"> <b>InvestmentUSD</b> - <?php echo $info->InvestmentUSD.'&nbsp;&nbsp';
									}?>

									<?php if(!empty($info->InvestmentType)) 
									{?> 
										<input type="checkbox" name="info[]" id="InvestmentType" value="InvestmentType" onChange="filter_records();"> <b>Investment Type</b> - <?php echo $info->InvestmentType.'&nbsp;&nbsp';
									}?>

									<?php if(!empty($info->EquityPosition)) 
									{?> 
										<input type="checkbox" name="info[]" id="EquityPosition" value="EquityPosition" onChange="filter_records();"> <b>Equity Position</b> - <?php echo $info->EquityPosition.'&nbsp;&nbsp';
									}?>

									<?php if(!empty($info->CloseDate)) 
									{?> 
										<input type="checkbox" name="info[]" id="CloseDate" value="CloseDate" onChange="filter_records();"> <b>Close Date</b> - <?php echo $info->CloseDate.'&nbsp;&nbsp';
									}?>

								<?php } ?>

									<?php if(!empty($info->CompanyProgress)) 
									{?> 
										<input type="checkbox" name="info[]" id="CompanyProgress" value="CompanyProgress" onChange="filter_records();"> <b>Company Progress</b> - <?php echo $info->CompanyProgress.'&nbsp;&nbsp';
									}?>

									<?php if(!empty($info->CompanySumm)) 
									{?> 
										<input type="checkbox" name="info[]" id="CompanySumm" value="CompanySumm" onChange="filter_records();"> <b>CompanySummary</b> - <?php echo $info->CompanySumm.'&nbsp;&nbsp';
									}?>

									<?php if(!empty($info->ValueProposition)) 
									{?> 
										<input type="checkbox" name="info[]" id="ValueProposition" value="ValueProposition" onChange="filter_records();"> <b>Value Proposition</b> - <?php echo $info->ValueProposition.'&nbsp;&nbsp';
									}?>

									<?php if(!empty($info->CompanyType)) 
									{?> 
										<input type="checkbox" name="info[]" id="CompanyType" value="CompanyType" onChange="filter_records();"> <b>CompanyType</b> - <?php echo $info->CompanyType.'&nbsp;&nbsp';
									}?>
									
									<?php if(!empty($info->CompanyType) == "yes") 
									{
										if(!empty($info->FinancingStatus))
										{?> 
											<input type="checkbox" name="info[]" id="FinancingStatus" value="FinancingStatus" onChange="filter_records();"> <b>Financing Status</b> - <?php echo $info->FinancingStatus.'&nbsp;&nbsp';
										}?>

										<?php if(!empty($info->valuation)) 
										{?> 
											<input type="checkbox" name="info[]" id="valuation" value="valuation" onChange="filter_records();"> <b>valuation</b> - <?php echo $info->valuation.'&nbsp;&nbsp';
										}?>
								<?php } ?>
							
							</li>
						</form>
						<?php } ?>
					</ul>
                                
                                <ul class="list-group">
                                    <li class="list-group-item" id="search_results" style="margin-top:-14px;"></li>
                                </ul>
					
				</div>
			</div>
		</div>
	</div>
