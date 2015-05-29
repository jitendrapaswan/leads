<?php 
        $pagedata = $content;
        $companyDetail = $pagedata['companyDetail'];        
        $this->view('admin/include/header_menu',$pagedata); 
        $textLength=100;
?>
<style>
.hide-textarea{display: none;}    
</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-2"><?php  $this->view('admin/include/sidebar'); ?></div> 
    <div class="col-md-10">      
        
        <?php $this->view('include/messages'); ?>
        
        <div class="panel panel-default" style="margin-top:20px;">
          <div class="panel-heading">
            <span class="panel-title">View Company - <b><?php echo $companyDetail->CompanyName; ?></b></span>
            <div class="pull-right">
              <a href="<?php echo base_url();?>admin/partner/editCompanyDetail/<?php echo $companyDetail->id;?>"><button type="button" class="btn btn-xs btn-primary">Edit</button></a>
              <a href="<?php echo base_url();?>admin/partner/companyHistory/<?php echo $companyDetail->id;?>"><button type="button" class="btn btn-xs btn-primary">History</button></a>             
            </div>
          </div>
          <div class="panel-body">            
            <div class="row" >                    
                <div class="col-md-3 form-group">
                  <label>Company Name</label>
                  <p><?= set_value('CompanyName', $companyDetail->CompanyName) ?></p>
                </div>                              

                <div class="col-md-3 form-group">
                  <label>Company Rating</label>
                  <p><?= set_value('CompanyRating', $companyDetail->CompanyRating) ?></p>
                </div>                              
                
                <div class="col-md-3 form-group">
                  <label>Company Website</label>
                  <p><?= set_value('CompanyWebsite', $companyDetail->CompanyWebsite) ?></p>
                </div>

                <div class="col-md-3 form-group" >
                  <label>Theme Align</label>
                  <p><?= set_value('ThemeAlign', $companyDetail->ThemeAlign) ?></p> 
                </div>            
            </div>
                
            <div class="row">
                <div class="col-md-3 form-group">
                  <label>Source</label>
                  <p><?= set_value('Source', $companyDetail->Source) ?></p>                
                </div>

                <div class="col-md-3 form-group">
                    <label>BIC Lead</label>
                    <p><?= set_value('BicLead', $companyDetail->BicLead) ?></p>
                </div>
                
                <div class="col-md-3 form-group">
                    <label>Company Status</label>
                    <p><?= set_value('investment_status', $companyDetail->investment_status) ?></p>
                </div>
            

                <div class="col-md-3 form-group">
                  <label>BIC Investment</label>
                  <p><?= set_value('BicInvestment', $companyDetail->BicInvestment) ?></p>
                </div>
            </div>

            <?php if($companyDetail->BicInvestment =="yes")
            {?>
              <div class="row">
                                      
                <div class="col-md-3 form-group">
                  <label>Investment USD</label>
                  <p><?= set_value('InvestmentUSD', $companyDetail->InvestmentUSD) ?></p>
                </div>                              

                <div class="col-md-3 form-group">
                  <label>Investment Type</label>
                  <p><?= set_value('InvestmentType', $companyDetail->InvestmentType) ?></p>
                </div>                              
                
                <div class="col-md-3 form-group">
                  <label>Equity Position</label>
                  <p><?= set_value('EquityPosition', $companyDetail->EquityPosition) ?></p>
                </div>

                <div class="col-md-3 form-group" >
                  <label>Close Date</label>
                  <p><?= set_value('CloseDate', $companyDetail->CloseDate) ?></p> 
                </div>    
              </div>


            <?php } ?>

            <div class="row">    
                  <div class="col-md-3 form-group">
                    <label>Company Type</label>                                            
                    <p><?= set_value('CompanyType', $companyDetail->CompanyType) ?></p>
                  </div>

                  <?php if($companyDetail->CompanyType =="private")
                  {?>
                    <div class="col-md-3 form-group">
                      <label>Financing Status</label>                                            
                      <p><?= set_value('CompanyType', $companyDetail->FinancingStatus) ?></p>
                  </div>

                  <div class="col-md-3 form-group">
                      <label>Valuation</label>                                            
                      <p><?= set_value('CompanyType', $companyDetail->valuation) ?></p>
                  </div>
                  <?php }?>
            </div> 
            
            <div class="row">    
              <div class="col-md-12 form-group">
                <label>Developement Plans</label>                      
                <div class="history-class" id="developDiv" title="DevelopmentPlans"></div>
              </div>  
            </div> 

            <div class="row">   
                <div class="col-md-12 form-group">
                    <label>Customer Target</label> 
                    <div class="history-class" id="customerDiv"  title="CustomerTarget"></div>
                </div> 
            </div>

             
            <div class="row">
              <div class="col-md-12 form-group">
                <label>Company Progress</label>   
                <div class="history-class" id="companyDiv"  title="CompanyProgress"></div>
              </div>
                
            </div>
            
            <div class="row">    
                <div class="col-md-12 form-group">
                    <label>Company Summary</label>
                    <div class="history-class" id="summaryDiv" title="CompanySumm"></div>
                </div>
            </div>                            

            <div class="row">   
                <div class="col-md-12 form-group">
                    <label>Value Proposition</label>
                    <div class="history-class" id="valueDiv"  title="ValueProposition"></div>
                </div>
            </div>
              
            <div class="row">   
                <div class="col-md-12 form-group">
                    <a class="btn btn-primary" href="<?php echo site_url('admin/company/pdf_company_detail/'.$companyDetail->id); ?>">Download PDF</a>
                </div>
            </div>  
              
          </div>
      </div>
     </div>
  </div>    
    
    


</div>

  <!--modal starts--> 
    <div id="myModal" class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title" id="gridSystemModalLabel">History Data</h4>
           </div>
           <div class="modal-body">

           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
         </div><!-- /.modal-content -->
       </div><!-- /.modal-dialog -->
     </div><!-- /.modal -->
     <!--modal ends--> 
<script>
jQuery(document).ready(function ($)
{
   get_history('DevelopmentPlans','<?php echo $companyDetail->id; ?>','developDiv');
   get_history('CustomerTarget','<?php echo $companyDetail->id; ?>','customerDiv');
   get_history('CompanyProgress','<?php echo $companyDetail->id; ?>','companyDiv');
   get_history('CompanySumm','<?php echo $companyDetail->id; ?>','summaryDiv');
   get_history('ValueProposition','<?php echo $companyDetail->id; ?>','valueDiv');
});  
  
function show_history_data(field,id)
  {
      $.ajax({ type:"POST", url:"<?php echo site_url('admin/company/get_field_history_data'); ?>", data:{id:id,field:field},
               success:function(data) 
               {
                   $("#myModal .modal-body").html(data);
                   $("#myModal").modal('show');
               }
      });
  }
  
  
  
  function show_history_data(field,id)
  {
      $.ajax({ type:"POST", url:"<?php echo site_url('admin/company/get_field_history_data'); ?>", data:{id:id,field:field},
               success:function(data) 
               {
                   $("#myModal .modal-body").html(data);
                   $("#myModal").modal('show');
               }
      });
  }
  
  /*function toggle(divId)
  {
      if($('#'+divId).css('display') == 'block')
      {
           $("#"+divId).hide();
           $("#icon"+divId).removeClass("fa fa-minus").addClass("fa fa-plus");
           
      }
      else
      {
          $("#"+divId).show();
          $("#icon"+divId).removeClass("fa fa-plus").addClass("fa fa-minus");
      }
  }*/

  function get_history(field,id,divId)
  {
      //toggle(divId);      
      $("#"+divId).html('<div id="txaDevelopmentPlansDiv"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i></div>');
      $.ajax({ type:"POST", url:"<?php echo site_url('admin/company/get_field_complete_history'); ?>", data:{id:id,field:field,edit_icon:"1"},
               success:function(data) 
               {
                   $("#"+divId).html(data);
               }
      });
  }
</script>