<?php  $this->view('admin/include/header_menu'); 
       $textLength=100;
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(function ()
{
      show();
      company_type();
});
$(function() {
    $( "#CloseDate" ).datepicker();
  });

  function show()
  {
      var type = $("#BicInvestment").val();
      if(type=="yes"){
        $("#display").show();  
      } else {
            $("#display").hide(); 
      }
  }

  function company_type()
  {
    var type = $("#CompanyType").val();
      if(type=="private"){
        $("#company").show();  
      } else {
        $("#company").hide(); 
      }
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
  

  function toggle(divId)
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
  }

  function get_history(field,id,divId)
  {
      toggle(divId);      
      $("#"+divId).html('<div id="txaDevelopmentPlansDiv"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i></div>');
      $.ajax({ type:"POST", url:"<?php echo site_url('admin/company/get_field_complete_history'); ?>", data:{id:id,field:field,edit_icon:"0"},
               success:function(data) 
               {
                   $("#"+divId).html(data);
               }
      });
  }

  function get_history_toggle(field,id,divId)
  {
      $("#"+divId).html('<div id="txaDevelopmentPlansDiv"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i></div>');
      $.ajax({ type:"POST", url:"<?php echo site_url('admin/company/get_field_complete_history'); ?>", data:{id:id,field:field,edit_icon:"0"},
               success:function(data) 
               {
                   $("#"+divId).html(data);
               }
      });
  }

  function show_history_insert_box(historyDiv)
  {
      $("#create"+historyDiv).toggle();
      //$("#"+historyDiv).html("");
  }
  
  function create_hisotry(field,companyId,createDiv)
  {
      var divId = createDiv.replace('create','');       
      var fieldVal = $("#txa"+field).val();      
      $.ajax({ type:"POST", url:"<?php echo site_url('admin/company/create_new_history'); ?>", data:{id:companyId,field:field,fieldVal:fieldVal},
               success:function(flag) 
               {
                    if(flag==1)
                    {  
                        $("#txa"+field).val("");
                        $("#msg"+field).show();   
                        $("#"+createDiv).hide();                     
                        setTimeout(function(){ $("#msg"+field).hide(); }, 2000);  
                        $('#'+divId).css('display','none');
                        get_history(field,companyId,divId);                                       
                    }
               }
      });
  }
  
  function edit_field_value(field,id)
  {
      $.ajax({ type:"POST", url:"<?php echo site_url('admin/company/get_field_history_data'); ?>", data:{id:id,field:field},
               success:function(data) 
               {
                   $("#myModalEdit .modal-body").html('<textarea class="form-control" id="txa_'+field+'_'+id+'">'+data+'</textarea>');
                   $("#myModalEdit").modal('show');
               }
      });
  }
  
  function create_log_entry()
  {
      var textareaObj=$("#myModalEdit .modal-body textarea");
      var id = textareaObj.attr('id');
      var newId = id.split("_");
      var fieldVal = $("#"+id).val();
      var companyId = "<?php echo $companyDetail->id;  ?>";      
      $.ajax({ type:"POST", url:"<?php echo site_url('admin/company/create_log_entry'); ?>", data:{historyId:newId[2],field:newId[1],fieldVal:fieldVal,companyId:companyId},
               success:function(flag) 
               {
                    if(flag==1)
                    {    
                        $("#show_msg").show();
                        $("#show_msg").fadeOut(3000);                                                                                
                        setTimeout(function(){$('#myModalEdit').modal('hide'); }, 4000);                                                 
                        var divId=$('div[title|='+newId[1]+']').attr('id'); 
                        $('#'+divId).css('display','none');
                        get_history(newId[1],companyId,divId);    
                    }
               }
      });
  }
  
  function edit_log_field_value(field,logId,historyId)
  {
      $.ajax({ type:"POST", url:"<?php echo site_url('admin/company/get_log_field_data'); ?>", data:{id:logId,field:field},
               success:function(data) 
               {
                   $("#myModalEdit .modal-body").html('<textarea class="form-control" id="txa_'+field+'_'+historyId+'">'+data+'</textarea>');
                   $("#myModalEdit").modal('show');
               }
      });
  }

  function collapse_div()
  {
    get_history_toggle('DevelopmentPlans','<?php echo $companyDetail->id; ?>','developDiv');
    get_history_toggle('CustomerTarget','<?php echo $companyDetail->id; ?>','customerDiv');
    get_history_toggle('CompanyProgress','<?php echo $companyDetail->id; ?>','companyDiv');
    get_history_toggle('CompanySumm','<?php echo $companyDetail->id; ?>','summaryDiv');
    get_history_toggle('ValueProposition','<?php echo $companyDetail->id; ?>','valueDiv');
    if($("#txtchange").attr('type') == 1)
    {
        $(".history-class").show();
        $(".test").removeClass("fa fa-plus").addClass("fa fa-minus");
        $("#txtchange").text("Collapse All");  
        $("#txtchange").attr("type","0");
    }
    else
    {
        $(".history-class").hide();
        $(".test").removeClass("fa fa-minus").addClass("fa fa-plus");        
        $("#txtchange").text("Expand All"); 
        $("#txtchange").attr("type","1"); 
    }
    
    
  }
  
  </script>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2"><?php  $this->view('admin/include/sidebar'); ?></div> 
    <div class="col-md-10">      
        
        <?php $this->view('include/messages'); ?>
        
        <div class="panel panel-default" style="margin-top:20px;">
          <div class="panel-heading">
            <span class="panel-title">Edit Company - <b><?php echo $companyDetail->CompanyName; ?></b></span>
            <div class="pull-right">
              <a href="<?php echo base_url();?>admin/company/view_company_detail/<?php echo $companyDetail->id;?>"><button type="button" class="btn btn-xs btn-primary">View</button></a>
              <a href="<?php echo base_url();?>admin/partner/companyHistory/<?php echo $companyDetail->id;?>"><button type="button" class="btn btn-xs btn-primary">History</button></a>
              <button type="button" class="btn btn-xs btn-primary" onclick="collapse_div();"><span id="txtchange" type="1">Expand all</span></button>              
            </div>
          </div>
          <div class="panel-body">
            <form class="" role="form" method="post" action="<?php echo base_url(); ?>admin/partner/editCompanyDetail/<?php echo $companyDetail->id;?>">
            <div class="row" >                    
                <div class="col-md-3 form-group">
                  <label>Company Name</label>
                  <input type="text" name="CompanyName" class="form-control" placeholder="Company Name" value="<?php if(!empty($companyDetail->CompanyName)) { echo $companyDetail->CompanyName; } else {   echo set_value('CompanyName'); }?>" required>
                </div>                              

                <div class="col-md-3 form-group">
                  <label>Company Rating</label>
                   <select class="form-control" name="CompanyRating">
                      <?php for ($i=0; $i<=100; $i++)
                      {?>
                          <option value="<?php echo $i; ?>"<?php if($i == $companyDetail->CompanyRating) { echo 'selected=selected';} ?>><?php echo $i; ?></option>
                      <?php } ?>
                   </select>
                </div>                              
                
                <div class="col-md-6 form-group">
                  <label>Company Website</label>
                  <input type="text" name="CompanyWebsite" class="form-control" placeholder="Company Website" value="<?php if(!empty($companyDetail->CompanyWebsite)) { echo $companyDetail->CompanyWebsite; } else {   echo set_value('CompanyWebsite'); }?>" required>
                </div>
            </div>
                
            <div class="row">    
                <div class="col-md-6 form-group" >
                 <label>Theme Align</label>
                  <select class="form-control" name="ThemeAlign">
                    <option value="">--Select Theme Align--</option>
                    <option value="Cloud" <?php if("Cloud" == $companyDetail->ThemeAlign) { echo 'selected=selected';} ?>>Cloud</option>
                    <option value="3D Printing" <?php if("3D Printing" == $companyDetail->ThemeAlign) { echo 'selected=selected';} ?>>3D Printing</option>
                    <option value="Healthcare" <?php if("Healthcare" == $companyDetail->ThemeAlign) { echo 'selected=selected';} ?>>Healthcare</option>
                    <option value="Connected Intelligent Ecosystem" <?php if("Connected Intelligent Ecosystem" == $companyDetail->ThemeAlign) { echo 'selected=selected';} ?>>Connected Intelligent Ecosystem</option>
                    <option value="Robotics" <?php if("Robotics" == $companyDetail->ThemeAlign) { echo 'selected=selected';} ?>>Robotics</option>
                    <option value="Workplace of the Future" <?php if("Workplace of the Future" == $companyDetail->ThemeAlign) { echo 'selected=selected';} ?>>Workplace of the Future</option>
                  </select>
                </div>
                
                <div class="col-md-6 form-group">
                  <label>Source</label>
                  <input type="text" name="Source" class="form-control" placeholder="Source" value="<?php if(!empty($companyDetail->Source)) { echo $companyDetail->Source; } else {   echo set_value('Source'); }?>">
                </div>
            </div>
            
            <div class="row">    
                <div class="col-md-12 form-group">
                      <label>
                           <a class="" id="" href="javascript:void(0);" onclick="get_history('DevelopmentPlans',<?php echo $companyDetail->id; ?>,'developDiv');">
                            <i class="fa fa-plus test" id="icondevelopDiv"></i>Developement Plans  
                          </a> 
                          <a class="" id="dpAnchor" href="javascript:void(0);" onclick="show_history_insert_box('developDiv');" style="margin-left: 15px;">
                              <i class="fa fa-pencil-square-o"></i>&nbsp;New Entry
                          </a>&nbsp;                          
                      </label>
                      <span id="msgDevelopmentPlans" style="display:none;color:#3c763d;font-weight:bold;">Record has been saved successfully.</span>
                

                    <div id="createdevelopDiv" style="display:none;">   
                        <textarea name="txaDevelopmentPlans" id="txaDevelopmentPlans" class="form-control" placeholder="Development Plans"></textarea>
                        <br><button type="button" class="btn btn-primary" onclick="create_hisotry('DevelopmentPlans',<?php echo $companyDetail->id; ?>,'createdevelopDiv');">Add</button><br/><br/>
                    </div>
                    
                    <div class="history-class" id="developDiv" style="display:none;" title="DevelopmentPlans">

                    </div>


                </div>  
            </div> 

            <div class="row">   
                <div class="col-md-12 form-group">
                    <label>                        
                        <a class="" id="" href="javascript:void(0);" onclick="get_history('CustomerTarget',<?php echo $companyDetail->id; ?>,'customerDiv');">
                        <i class="fa fa-plus test" id="iconcustomerDiv"></i>Customer Target
                        </a>
                        <a class="" id="dpAnchor" href="javascript:void(0);" onclick="show_history_insert_box('customerDiv');" style="margin-left: 15px;">
                            <i class="fa fa-pencil-square-o"></i>&nbsp;New Entry
                        </a>&nbsp;
                    </label>
                    <span id="msgCustomerTarget" style="display:none;color:#3c763d;font-weight:bold;">Record has been saved successfully.</span>

                    <div id="createcustomerDiv" style="display:none;">   
                        <textarea name="txaCustomerTarget" id="txaCustomerTarget" class="form-control" placeholder="Customer Target" ></textarea>
                        <br><button type="button" class="btn btn-primary" onclick="create_hisotry('CustomerTarget',<?php echo $companyDetail->id; ?>,'createcustomerDiv');">Add</button><br/><br/>
                    </div>
                    
                    <div class="history-class" id="customerDiv" style="display:none;" title="CustomerTarget">

                    </div>
                    
                </div> 
                
            </div>
                
            <div class="row">    
                <div class="col-md-6 form-group">
                    <label>BIC Lead</label>
                    <select class="form-control" name="BicLead">
                        <option value="">--Select Bic Lead--</option>
                        <option value="Greg" <?php if("Greg" == $companyDetail->BicLead) { echo 'selected=selected';} ?>>Greg</option>
                        <option value="Ilan" <?php if("Ilan" == $companyDetail->BicLead) { echo 'selected=selected';} ?>>Ilan</option>
                        <option value="Nats" <?php if("Nats" == $companyDetail->BicLead) { echo 'selected=selected';} ?>>Nats</option>
                    </select>
                </div>
            

                <div class="col-md-6 form-group">
                  <label>BIC Investment</label>
                  <select class="form-control" name="BicInvestment" id="BicInvestment" onchange="show()">
                    <option value="">--Select BIC Investment--</option>
                    <option value="yes" <?php if("yes" == $companyDetail->BicInvestment) { echo 'selected=selected';} ?>>Yes</option>
                    <option value="no"  <?php if("no" == $companyDetail->BicInvestment) { echo 'selected=selected';} ?>>No</option>
                </select>
                </div>
            </div>

          <div id="display" style="display:none;">
            <div class="row" style="padding-bottom: 5px;">
                <div class="col-md-6 form-group">
                  <label>Investment USD</label>
                  <input type="text" id="InvestmentUSD" name="InvestmentUSD" class="form-control" placeholder="Investment - USD"  value="<?php if(!empty($companyDetail->InvestmentUSD)) { echo $companyDetail->InvestmentUSD; } else {   echo set_value('InvestmentUSD'); }?>">
                </div>

                <div class="col-md-6 form-group">
                  <label>Investment Type</label>                  
                    <select class="form-control" name="InvestmentType" id="InvestmentType">
                      <option value="">--Select Investment Type--</option>
                      <option value="Debt"     <?php if("Debt" == $companyDetail->InvestmentType) { echo 'selected=selected';} ?>>Debt</option>
                      <option value="Seed"     <?php if("Seed" == $companyDetail->InvestmentType) { echo 'selected=selected';} ?> >Seed</option>
                      <option value="series A" <?php if("series A" == $companyDetail->InvestmentType) { echo 'selected=selected';} ?>>Series A</option>
                      <option value="series B" <?php if("series B" == $companyDetail->InvestmentType) { echo 'selected=selected';} ?>>Series B</option>
                      <option value="series C" <?php if("series C" == $companyDetail->InvestmentType) { echo 'selected=selected';} ?>>Series C</option>
                      <option value="series D" <?php if("series D" == $companyDetail->InvestmentType) { echo 'selected=selected';} ?>>Series D</option>
                      <option value="other"    <?php if("other D"  == $companyDetail->InvestmentType) { echo 'selected=selected';} ?>>Other</option>
                    </select>
                </div>
            </div>
            <div class="row" style="padding-bottom: 5px;">  
                <div class="col-md-6 form-group">
                  <label>Equity Position</label>
                  <input type="text" id="EquityPosition" name="EquityPosition" class="form-control" placeholder="Equity Position"  value="<?php if(!empty($companyDetail->EquityPosition)) { echo $companyDetail->EquityPosition; } else {   echo set_value('EquityPosition'); }?>">
                </div>

                <div class="col-md-6 form-group">
                  <label>Close Date</label>
                  <input type="text" name="CloseDate" id="CloseDate" class="form-control" placeholder="Close Date"  value="<?php if(!empty($companyDetail->CloseDate)) { echo $companyDetail->CloseDate; } else {   echo set_value('CloseDate'); }?>">
                </div>             
              </div>                              
          </div>    

             
            <div class="row">
                <div class="col-md-12 form-group">
                    <label>                       
                        <a class="" id="" href="javascript:void(0);" onclick="get_history('CompanyProgress',<?php echo $companyDetail->id; ?>,'companyDiv');"> 
                          <i class="fa fa-plus test" id="iconcompanyDiv"></i>Company Progress 
                        </a>
                        <a class="" id="dpAnchor" href="javascript:void(0);" onclick="show_history_insert_box('companyDiv');" style="margin-left: 15px;">
                                <i class="fa fa-pencil-square-o"></i>&nbsp;New Entry
                        </a> &nbsp;  
                    </label>
                   <span id="msgCompanyProgress" style="display:none;color:#3c763d;font-weight:bold;">Record has been saved successfully.</span>

                    <div id="createcompanyDiv" style="display:none;">   
                        <textarea id="txaCompanyProgress" name="txaCompanyProgress" class="form-control" placeholder="Company Progress"></textarea>
                        <br><button type="button" class="btn btn-primary" onclick="create_hisotry('CompanyProgress',<?php echo $companyDetail->id; ?>,'createcompanyDiv');">Add</button><br/><br/>
                    </div>

                    <div class="history-class" id="companyDiv" style="display:none;" title="CompanyProgress">

                    </div>
                    
                </div>
                
            </div>
            
            <div class="row">    
                <div class="col-md-12 form-group">
                    <label>                       
                        <a class="" id="" href="javascript:void(0);" onclick="get_history('CompanySumm',<?php echo $companyDetail->id; ?>,'summaryDiv');">
                            <i class="fa fa-plus test" id="iconsummaryDiv"></i>Company Summary 
                        </a>
                        <a class="" id="dpAnchor" href="javascript:void(0);" onclick="show_history_insert_box('summaryDiv');" style="margin-left: 15px;">
                            <i class="fa fa-pencil-square-o"></i>&nbsp;New Entry
                        </a>&nbsp;
                    </label>
                    <span id="msgCompanySumm" style="display:none;color:#3c763d;font-weight:bold;">Record has been saved successfully.</span>


                    <div id="createsummaryDiv" style="display:none;">   
                        <textarea name="txaCompanySumm" id="txaCompanySumm" class="form-control" placeholder="Company Summary"></textarea>
                        <br><button type="button" class="btn btn-primary" onclick="create_hisotry('CompanySumm',<?php echo $companyDetail->id; ?>,'createsummaryDiv');">Add</button><br/><br/>
                    </div>

                    <div class="history-class" id="summaryDiv" style="display:none;" title="CompanySumm">

                    </div>
                    
                </div>
                
            </div>                            

            <div class="row">   
                <div class="col-md-12 form-group">
                    <label>                        
                        <a class="" id="" href="javascript:void(0);" onclick="get_history('ValueProposition',<?php echo $companyDetail->id; ?>,'valueDiv');">
                            <i class="fa fa-plus test" id="iconvalueDiv"></i>Value Proposition
                        </a>
                        <a class="" id="dpAnchor" href="javascript:void(0);" onclick="show_history_insert_box('valueDiv');" style="margin-left: 15px;">
                                <i class="fa fa-pencil-square-o"></i>&nbsp;New Entry
                        </a>&nbsp;
                    </label>
                      <span id="msgValueProposition" style="display:none;color:#3c763d;font-weight:bold;">Record has been saved successfully.</span>

                    <div id="createvalueDiv" style="display:none;">   
                        <textarea name="txaValueProposition" id="txaValueProposition" class="form-control" placeholder="Value Proposition"></textarea>
                        <br><button type="button" class="btn btn-primary" onclick="create_hisotry('ValueProposition',<?php echo $companyDetail->id; ?>,'createvalueDiv');">Add</button><br/><br/>
                    </div>

                    <div class="history-class" id="valueDiv" style="display:none;" title="ValueProposition">

                    </div>
                  
                </div>
            
                  
            </div>
                
            <div class="row">    
                  <div class="col-md-12 form-group">
                    <label>Company Type</label>                                            
                    <select class="form-control" name="CompanyType" onchange="company_type()" id="CompanyType">
                      <option value="">--Select Company Type--</option>
                      <option value="public" <?php if("public"   == $companyDetail->CompanyType) { echo 'selected=selected';} ?>>Public</option>
                      <option value="private"<?php if("private"  == $companyDetail->CompanyType) { echo 'selected=selected';} ?>  >Private</option>
                    </select>
                  </div>
            </div>   

              <div id="company">  
                <div class="row" style="padding-bottom: 5px;"> 
                    <div class="col-md-6 form-group"><label>Financing Status</label>                    
                    <select class="form-control" name="FinancingStatus" id="FinancingStatus">
                      <option value="">--Select Financing Status--</option>                        
                      <option value="private"  <?php if("private"  == $companyDetail->FinancingStatus) { echo 'selected=selected';} ?>>private</option>
                      <option value="seed"     <?php if("seed"     == $companyDetail->FinancingStatus) { echo 'selected=selected';} ?>>Seed</option>
                      <option value="series A" <?php if("series A" == $companyDetail->FinancingStatus) { echo 'selected=selected';} ?>>Series A</option>
                      <option value="series B" <?php if("series B" == $companyDetail->FinancingStatus) { echo 'selected=selected';} ?>>Series B</option>
                      <option value="series C" <?php if("series C" == $companyDetail->FinancingStatus) { echo 'selected=selected';} ?>>Series C</option>
                      <option value="series D" <?php if("series D" == $companyDetail->FinancingStatus) { echo 'selected=selected';} ?>>Series D</option>
                      <option value="other"    <?php if("other D"  == $companyDetail->FinancingStatus) { echo 'selected=selected';} ?>>Other</option>
                    </select>
                    </div>
                    <div class="col-md-6 form-group"><label>Valuation</label>
                    <input type ="text" name="valuation" class="form-control" id="valuation" placeholder="Valuation" value="<?php if(!empty($companyDetail->valuation)) { echo $companyDetail->valuation; } else {   echo set_value('valuation'); }?>"></div>
                </div> 
              </div>             
              <div class="row" style="padding: 5px;"> 
               <div class="col-md-1"> <button type="submit" class="btn btn-primary" name="submit">Update</button>  </div>  
              </div>
               </form>    
                      
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
     
        <!--modal starts--> 
        <div id="myModalEdit" class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true">
           <div class="modal-dialog">
             <div class="modal-content">             
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="gridSystemModalLabel">Edit Data</h4>
                  <div class="alert alert-success" style="margin:3px;display:none;" id="show_msg">Record has been saved successfully.</div>
               </div>               
               <div class="modal-body">

               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="btnFieldSave" onclick="create_log_entry();">Save</button>
               </div>
             </div><!-- /.modal-content -->
           </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->
         <!--modal ends--> 
    
     </div>
  </div>    
</div>
