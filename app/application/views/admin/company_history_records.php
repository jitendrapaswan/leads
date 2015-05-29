<?php
if(!empty($companyDetail)) 
{
foreach ($companyDetail as $companyDetail) 
{								
$name = $this->company_model->getReceiverName($companyDetail->edited_by); ?>
<li class="list-group-item" id="search_results">
<?php 	if(!empty($companyDetail->CompanyName)) 
{?> 
	<b>Company Name</b> - <?php echo $companyDetail->CompanyName.'&nbsp;&nbsp';
}

if(!empty($companyDetail->CompanyWebsite)) 
{?> 
	<b>Company Website</b> - <?php echo $companyDetail->CompanyWebsite.'&nbsp;&nbsp';
}

if(!empty($companyDetail->CompanyRating)) 
{?> 
	<b>Company Rating</b> - <?php echo $companyDetail->CompanyRating.'&nbsp;&nbsp';
}

if(!empty($companyDetail->ThemeAlign)) 
{?> 
	<b>Theme Align</b> - <?php echo $companyDetail->ThemeAlign.'&nbsp;&nbsp';
}

if(!empty($companyDetail->DevelopmentPlans)) 
{?> 
	<b>Development Plans</b> - <?php echo $companyDetail->DevelopmentPlans.'&nbsp;&nbsp';
}

if(!empty($companyDetail->CustomerTarget)) 
{?> 
	<b>Customer Target</b> - <?php echo $companyDetail->CustomerTarget.'&nbsp;&nbsp';
}

if(!empty($companyDetail->Source)) 
{?> 
	<b>Source</b> - <?php echo $companyDetail->Source.'&nbsp;&nbsp';
}										
if(!empty($companyDetail->BicLead)) 
{?> 
	<b>BicLead</b> - <?php echo $companyDetail->BicLead.'&nbsp;&nbsp';
}

if(!empty($companyDetail->BicInvestment)) 
{?> 
	<b>Bic Investment</b> - <?php echo $companyDetail->BicInvestment.'&nbsp;&nbsp';
}

if(!empty($companyDetail->InvestmentUSD)) 
{?> 
	<b>Investment USD</b> - <?php echo $companyDetail->InvestmentUSD.'&nbsp;&nbsp';
}
if(!empty($companyDetail->InvestmentType)) 
{?> 
	<b>Investment Type</b> - <?php echo $companyDetail->InvestmentType.'&nbsp;&nbsp';
}
if(!empty($companyDetail->EquityPosition)) 
{?> 
	<b>Equity Position</b> - <?php echo $companyDetail->EquityPosition.'&nbsp;&nbsp';
}
if(!empty($companyDetail->CloseDate)) 
{?> 
	<b>Close Date</b> - <?php echo $companyDetail->CloseDate.'&nbsp;&nbsp';
}
if(!empty($companyDetail->CompanyProgress)) 
{?> 
	<b>Company Progress</b> - <?php echo $companyDetail->CompanyProgress.'&nbsp;&nbsp';
}
if(!empty($companyDetail->CompanySumm)) 
{?> 
	<b>Company Summary</b> - <?php echo $companyDetail->CompanySumm.'&nbsp;&nbsp';
}
if(!empty($companyDetail->ValueProposition)) 
{?> 
	<b>Value Proposition</b> - <?php echo $companyDetail->ValueProposition.'&nbsp;&nbsp';
}
if(!empty($companyDetail->CompanyType)) 
{?> 
	<b>Company Type</b> - <?php echo $companyDetail->CompanyType.'&nbsp;&nbsp';
}
if(!empty($companyDetail->FinancingStatus)) 
{?> 
	<b>Financing Status</b> - <?php echo $companyDetail->FinancingStatus.'&nbsp;&nbsp';
}
if(!empty($companyDetail->valuation)) 
{?> 
	<b>Valuation</b> - <?php echo $companyDetail->valuation.'&nbsp;&nbsp';
} 
echo trim("has been updated by"); ?> <?php echo !empty($name->first_name) ? ucfirst($name->first_name).' '.ucfirst($name->last_name): "" ?> on <?php echo $companyDetail->updated_time; ?>
</li> 
<?php } 
} 
else { ?>
<li class="list-group-item">No history Available</li>
<?php }?>
