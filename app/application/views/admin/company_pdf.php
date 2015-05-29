<?php 
      $pagedata = $content;
      $companyDetail = $pagedata['companyDetail'];
      $userdata = $pagedata['userData'] ; 
?>    
<!DOCTYPE>
<html>
    <head>
        <link rel="stylesheet" href="<?php echo base_url().'/css/bootstrap.min.css'; ?>" >
    </head>
    <body>
        <div class="container">
            <div class="row">

              <div class="col-xs-12">      

                  <?php //$this->view('include/messages'); 
                      $companyId = $companyDetail->id;
                  ?>

                  <div class="panel panel-default" style="margin-top:20px;">
                      <div class="panel-heading"><h1 class="panel-title">Company Detail - <strong><?php echo $companyDetail->CompanyName; ?></strong></h1></div>
                    <div class="panel-body">            
                      <div class="row" >                    
                          <div class="col-xs-3 form-group">
                            <label><strong>Company Name</strong></label>
                            <p><?= set_value('CompanyName', $companyDetail->CompanyName) ?></p>
                          </div>                              

                          <div class="col-xs-3 form-group">
                            <label>Company Rating</label>
                            <p><?= set_value('CompanyRating', $companyDetail->CompanyRating) ?></p>
                          </div>                              

                          <div class="col-xs-3 form-group">
                            <label>Company Website</label>
                            <p><?= set_value('CompanyWebsite', $companyDetail->CompanyWebsite) ?></p>
                          </div>

                          <div class="col-xs-3 form-group" >
                            <label>Theme Align</label>
                            <p><?= set_value('ThemeAlign', $companyDetail->ThemeAlign) ?></p> 
                          </div>            
                      </div>

                      <div class="row">
                          <div class="col-xs-3 form-group">
                            <label>Source</label>
                            <p><?= set_value('Source', $companyDetail->Source) ?></p>                
                          </div>

                          <div class="col-xs-3 form-group">
                              <label>BIC Lead</label>
                              <p><?= set_value('BicLead', $companyDetail->BicLead) ?></p>
                          </div>


                          <div class="col-xs-3 form-group">
                            <label>BIC Investment</label>
                            <p><?= set_value('BicInvestment', $companyDetail->BicInvestment) ?></p>
                          </div>
                      </div>

                      <?php if($companyDetail->BicInvestment =="yes")
                      {?>
                        <div class="row">

                          <div class="col-xs-3 form-group">
                            <label>Investment USD</label>
                            <p><?= set_value('InvestmentUSD', $companyDetail->InvestmentUSD) ?></p>
                          </div>                              

                          <div class="col-xs-3 form-group">
                            <label>Investment Type</label>
                            <p><?= set_value('InvestmentType', $companyDetail->InvestmentType) ?></p>
                          </div>                              

                          <div class="col-xs-3 form-group">
                            <label>Equity Position</label>
                            <p><?= set_value('EquityPosition', $companyDetail->EquityPosition) ?></p>
                          </div>

                          <div class="col-xs-3 form-group" >
                            <label>Close Date</label>
                            <p><?= set_value('CloseDate', $companyDetail->CloseDate) ?></p> 
                          </div>    
                        </div>


                      <?php } ?>

                      <div class="row">    
                            <div class="col-xs-3 form-group">
                              <label>Company Type</label>                                            
                              <p><?= set_value('CompanyType', $companyDetail->CompanyType) ?></p>
                            </div>

                            <?php if($companyDetail->CompanyType =="private")
                            {?>
                              <div class="col-xs-3 form-group">
                                <label>Financing Status</label>                                            
                                <p><?= set_value('CompanyType', $companyDetail->FinancingStatus) ?></p>
                            </div>

                            <div class="col-xs-3 form-group">
                                <label>Valuation</label>                                            
                                <p><?= set_value('CompanyType', $companyDetail->Valuation) ?></p>
                            </div>
                            <?php }?>
                      </div> 

                      <div class="row">    
                        <div class="col-xs-12 form-group">
                          <label>Developement Plans</label>                      
                          <div class="history-class" id="developDiv" title="DevelopmentPlans">
                              <?php

                                  $developHistory = $this->company_model->get_company_field_history('DevelopmentPlans',$companyId);    
                                  $textLength = 100;
                                  echo '<ul class="list-group">';
                                          if(!empty($developHistory))
                                          {
                                              foreach($developHistory as $historyVal)
                                              {

                                                  $logData=$this->company_model->get_log_by_field_id($historyVal['id']);
                                                  //print_r($logData);
                                                  if(!empty($logData))
                                                  {
                                                      echo '<li class="list-group-item"><span class="badge">Updated On: '.date('d-M-Y h:i A',strtotime($logData['created_date'])).'&nbsp;-&nbsp; '
                                                              . 'Updated By: '.$logData['user_name'].'</span>'.$historyVal['change'].' '
                                                              . '</li>';     
                                                  }
                                                  else 
                                                  {
                                                      echo '<li class="list-group-item"><span class="badge">Created On: '.date('d-M-Y h:i A',strtotime($historyVal['updated'])).'&nbsp;-&nbsp; '
                                                              . 'Created By: '.$historyVal['updated_by'].'</span>'.$historyVal['change'].' '
                                                              . '</li>';     
                                                  }

                                              }    
                                          }
                                          else
                                          {
                                              echo '<li class="list-group-item">No History Found !</li>'; 
                                          } 

                                  echo '</ul>';
                              ?>
                          </div>
                        </div>  
                      </div> 

                      <div class="row">   
                          <div class="col-xs-12 form-group">
                              <label>Customer Target</label> 
                              <div class="history-class" id="customerDiv"  title="CustomerTarget">
                                  <?php

                                  $developHistory = $this->company_model->get_company_field_history('CustomerTarget',$companyId);    
                                  $textLength = 100;
                                  echo '<ul class="list-group">';
                                          if(!empty($developHistory))
                                          {
                                              foreach($developHistory as $historyVal)
                                              {

                                                  $logData=$this->company_model->get_log_by_field_id($historyVal['id']);
                                                  //print_r($logData);
                                                  if(!empty($logData))
                                                  {
                                                      echo '<li class="list-group-item"><span class="badge">Updated On: '.date('d-M-Y h:i A',strtotime($logData['created_date'])).'&nbsp;-&nbsp; '
                                                              . 'Updated By: '.$logData['user_name'].'</span>'.$historyVal['change'].' '
                                                              . '</li>';     
                                                  }
                                                  else 
                                                  {
                                                      echo '<li class="list-group-item"><span class="badge">Created On: '.date('d-M-Y h:i A',strtotime($historyVal['updated'])).'&nbsp;-&nbsp; '
                                                              . 'Created By: '.$historyVal['updated_by'].'</span>'.$historyVal['change'].' '
                                                              . '</li>';     
                                                  }

                                              }    
                                          }
                                          else
                                          {
                                              echo '<li class="list-group-item">No History Found !</li>'; 
                                          } 

                                  echo '</ul>';
                              ?>
                              </div>
                          </div> 
                      </div>


                      <div class="row">
                        <div class="col-xs-12 form-group">
                          <label>Company Progress</label>   
                          <div class="history-class" id="companyDiv"  title="CompanyProgress">
                              <?php

                                  $developHistory = $this->company_model->get_company_field_history('CompanyProgress',$companyId);    
                                  $textLength = 100;
                                  echo '<ul class="list-group">';
                                          if(!empty($developHistory))
                                          {
                                              foreach($developHistory as $historyVal)
                                              {

                                                  $logData=$this->company_model->get_log_by_field_id($historyVal['id']);
                                                  //print_r($logData);
                                                  if(!empty($logData))
                                                  {
                                                      echo '<li class="list-group-item"><span class="badge">Updated On: '.date('d-M-Y h:i A',strtotime($logData['created_date'])).'&nbsp;-&nbsp; '
                                                              . 'Updated By: '.$logData['user_name'].'</span>'.$historyVal['change'].' '
                                                              . '</li>';     
                                                  }
                                                  else 
                                                  {
                                                      echo '<li class="list-group-item"><span class="badge">Created On: '.date('d-M-Y h:i A',strtotime($historyVal['updated'])).'&nbsp;-&nbsp; '
                                                              . 'Created By: '.$historyVal['updated_by'].'</span>'.$historyVal['change'].' '
                                                              . '</li>';     
                                                  }

                                              }    
                                          }
                                          else
                                          {
                                              echo '<li class="list-group-item">No History Found !</li>'; 
                                          } 

                                  echo '</ul>';
                              ?>
                          </div>
                        </div>

                      </div>

                      <div class="row">    
                          <div class="col-xs-12 form-group">
                              <label>Company Summary</label>
                              <div class="history-class" id="summaryDiv" title="CompanySumm">
                                  <?php

                                  $developHistory = $this->company_model->get_company_field_history('CompanySumm',$companyId);    
                                  $textLength = 100;
                                  echo '<ul class="list-group">';
                                          if(!empty($developHistory))
                                          {
                                              foreach($developHistory as $historyVal)
                                              {

                                                  $logData=$this->company_model->get_log_by_field_id($historyVal['id']);
                                                  //print_r($logData);
                                                  if(!empty($logData))
                                                  {
                                                      echo '<li class="list-group-item"><span class="badge">Updated On: '.date('d-M-Y h:i A',strtotime($logData['created_date'])).'&nbsp;-&nbsp; '
                                                              . 'Updated By: '.$logData['user_name'].'</span>'.$historyVal['change'].' '
                                                              . '</li>';     
                                                  }
                                                  else 
                                                  {
                                                      echo '<li class="list-group-item"><span class="badge">Created On: '.date('d-M-Y h:i A',strtotime($historyVal['updated'])).'&nbsp;-&nbsp; '
                                                              . 'Created By: '.$historyVal['updated_by'].'</span>'.$historyVal['change'].' '
                                                              . '</li>';     
                                                  }

                                              }    
                                          }
                                          else
                                          {
                                              echo '<li class="list-group-item">No History Found !</li>'; 
                                          } 

                                  echo '</ul>';
                              ?>
                              </div>
                          </div>
                      </div>                            

                      <div class="row">   
                          <div class="col-xs-12 form-group">
                              <label>Value Proposition</label>
                              <div class="history-class" id="valueDiv"  title="ValueProposition">
                                  <?php

                                  $developHistory = $this->company_model->get_company_field_history('ValueProposition',$companyId);    
                                  $textLength = 100;
                                  echo '<ul class="list-group">';
                                          if(!empty($developHistory))
                                          {
                                              foreach($developHistory as $historyVal)
                                              {

                                                  $logData=$this->company_model->get_log_by_field_id($historyVal['id']);
                                                  //print_r($logData);
                                                  if(!empty($logData))
                                                  {
                                                      echo '<li class="list-group-item"><span class="badge">Updated On: '.date('d-M-Y h:i A',strtotime($logData['created_date'])).'&nbsp;-&nbsp; '
                                                              . 'Updated By: '.$logData['user_name'].'</span>'.$historyVal['change'].' '
                                                              . '</li>';     
                                                  }
                                                  else 
                                                  {
                                                      echo '<li class="list-group-item"><span class="badge">Created On: '.date('d-M-Y h:i A',strtotime($historyVal['updated'])).'&nbsp;-&nbsp; '
                                                              . 'Created By: '.$historyVal['updated_by'].'</span>'.$historyVal['change'].' '
                                                              . '</li>';     
                                                  }

                                              }    
                                          }
                                          else
                                          {
                                              echo '<li class="list-group-item">No History Found !</li>'; 
                                          } 

                                  echo '</ul>';
                              ?>
                              </div>
                          </div>
                      </div>

                    </div>
                </div>
               </div>
            </div>    
        </div>
    </body>
</html>

 