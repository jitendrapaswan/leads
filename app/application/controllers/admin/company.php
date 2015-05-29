<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller {
       
    public function __construct(){
        parent::__construct();        
        $this->load->model('company_model'); 
    }
    
    public function change_status()
    {
        $status =	$this->input->post('status');
        $company_id =	$this->input->post('company_id');
        if(!empty($status) && !empty($company_id))
        {
                if($status == "Approved")
                {
                    $statusInfo = array('investment_status'=> $status,'approved_view_status'=>1);
                }
                else
                {
                    $statusInfo = array('investment_status'=> $status,'approved_view_status'=>0);
                }
                
                $this->db->where('id', $company_id);
                $this->db->update('companyinfo',$statusInfo);
                echo $status;
        }
    }
      
    public function get_field_history_data()
    {
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $data = $this->company_model->get_field_history_by_id($id,$field);
        echo $data->field_text;
    }
    
    public function get_field_complete_history()
    {
        $field = $this->input->post('field');
        $edit_icon = $this->input->post('edit_icon');
        if($edit_icon == 0)
        {
            $edit_icon = '<i class="fa fa-pencil-square-o"></i>';
        }
        else
        {
            $edit_icon ='';
        }
        $companyId = $this->input->post('id');
        $developHistory = $this->company_model->get_company_field_history($field,$companyId);    
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
                            if(strlen($logData['field_value']) > $textLength )
                            {    
                                $text=substr(nl2br($historyVal['change']),0,$textLength).'..<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" '
                                    . 'onclick="show_history_data(\''.$field.'\','.$historyVal['id'].');">Read More</a>';
                            }
                            else
                            {
                                $text=nl2br($logData['field_value']);
                            }

                            echo '<li class="list-group-item"><span class="badge">Updated On: '.date('d-M-Y h:i A',strtotime($logData['created_date'])).'&nbsp;-&nbsp; '
                                    . 'Updated By: '.$logData['user_name'].'</span>'.$text.' '
                                    . '&nbsp;&nbsp;<a href="javascript:void(0);" data-toggle="modal" data-target="#myModalEdit" onclick="edit_log_field_value(\''.$field.'\','.$logData['log_id'].','.$logData['history_id'].');">'.$edit_icon.'</a></li>';     
                        }
                        else 
                        {
                            if(strlen($historyVal['change']) > $textLength )
                            {    
                                $text=substr(nl2br($historyVal['change']),0,$textLength).'..<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" '
                                    . 'onclick="show_history_data(\''.$field.'\','.$historyVal['id'].');">Read More</a>';
                            }
                            else
                            {
                                $text=nl2br($historyVal['change']);
                            }

                            echo '<li class="list-group-item"><span class="badge">Created On: '.date('d-M-Y h:i A',strtotime($historyVal['updated'])).'&nbsp;-&nbsp; '
                                    . 'Created By: '.$historyVal['updated_by'].'</span>'.$text.' '
                                    . '&nbsp;&nbsp;<a href="javascript:void(0);" data-toggle="modal" data-target="#myModalEdit" onclick="edit_field_value(\''.$field.'\','.$historyVal['id'].');">'.$edit_icon.'</a></li>';     
                        }
                        
                    }    
                }
                else
                {
                    echo '<li class="list-group-item">No History Found !</li>'; 
                } 
            
        echo '</ul>';
    }
    
    public function create_new_history()
    {
        $field = $this->input->post('field');
        $fieldVal = $this->input->post('fieldVal');
        $companyId = $this->input->post('id');
        $userId = $this->session->userdata('user_id'); 
        $this->db->update('companyinfo',array($field=>$fieldVal),array('id'=>$companyId));
        $this->db->insert('company_history',array('company_id'=>$companyId,$field=>$fieldVal,'updated_time'=>date('Y-m-d H:i:s'),'edited_by'=>$userId));
        $inserted_id = $this->db->insert_id();
        if($field=="DevelopmentPlans")
        {  
            $this->db->insert('display_status',array('status'=>0,'history_id'=>$inserted_id,'company_id'=>$companyId));
        }
        echo '1';
    }  
    
    public function create_log_entry()
    {
        $historyId = $this->input->post('historyId');
        $field = $this->input->post('field');
        $fieldVal = $this->input->post('fieldVal');
        $userId = $this->session->userdata('user_id'); 
        $companyId = $this->input->post('companyId');        
        $logData = array('history_id'=>$historyId,'field_name'=>$field,'field_value'=>$fieldVal,'created_date'=>date('Y-m-d H:i:s'),'created_by'=>$userId);
        $this->db->insert('company_log',$logData);        
        $this->db->update('companyinfo',array($field=>$fieldVal),array('id'=>$companyId));    
        if($field=="DevelopmentPlans")
        {
            $this->db->update('display_status',array('status'=>0,'company_id'=>$companyId),array('history_id'=>$historyId));
        }
        echo "1";
    }  
    
    public function get_log_field_data()
    {
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $data = $this->company_model->get_log_field_value_by_id($id,$field);
        echo $data->field_value;
    }

    public function view_company_detail($companyId)
    {
        $this->db->update('companyinfo',array('approved_view_status' =>0),array('id'=>$companyId));
        $this->db->update('display_status',array('status' =>1),array('company_id'=>$companyId));
        $companyDetail = $this->company_model->get_company_detail_by_id($companyId);            
        $this->data['content']['title'] = 'Partner Alliance Detail';
        $this->data['content']['companyDetail'] = $companyDetail;
        $this->load->view('admin/view_company', $this->data);
    }
    
    public function pdf_company_detail($companyId)
    {
        $companyDetail = $this->company_model->get_company_detail_by_id($companyId);  
        //print_r($companyDetail);
        //exit;
        $companyName = $companyDetail->CompanyName;
                
        $this->data['content']['title'] = 'Partner Alliance Detail';
        $this->data['content']['companyDetail'] = $companyDetail;
        
        $html = $this->load->view('admin/company_pdf', $this->data,true);
        
        $this->load->library('mpdf');
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output('Company_Detail_'.$companyName.'_'.date('d-m-Y-His').'.pdf','D');
        
    }

    public function delete_company()
    {
        $companyArray = $this->input->post('company_id');                        
        $this->db->where_in('id', $companyArray);
        $this->db->update('companyinfo',array('Status'=>0));    
        echo 1;
    }
    
    public function load_company_data()
    {
        $companies = $this->company_model->get_companies();	
        if(!empty($companies))
        {
          foreach($companies as $company)
            { ?>
              <tr id="company_<?php echo $company->id; ?>">
                <td>&nbsp;&nbsp;<input type="checkbox" name="company_id[]" id="company_id" value="<?php echo $company->id; ?>"></td>
                <td><?php echo $company->CompanyName ?></td>
                <td><?php echo $company->CompanyWebsite?></td>
                <td><?php echo $company->CompanyProgress?></td>
                <td><?php echo $company->CustomerTarget?></td>
                <td><?php echo $commentsCount; ?> <?php if($commentsCount!=0) { echo "comment"; } else { echo "No comments "; }?></td>
                <td align="center"><?php echo !empty($company->CompanyRating) ? $company->CompanyRating : 0; ?></td>                                          
                <td>
                  <select class="form-control" id="status_<?php echo $company->id ?>" name="Title" placehoder="Title" style="width:135px;" onchange="change_status(this.value,'<?php echo $company->id ?>');" current_status ="<?php echo $company->investment_status; ?>">
                    <option <?php if($company->investment_status =="Not Available") { echo "selected='selected'"; } ?> value="Not Available">Not Available</option>
                    <option <?php if($company->investment_status =="Approved") { echo "selected='selected'"; } ?> value="Approved">Approved</option>
                    <option <?php if($company->investment_status =="Waiting") { echo "selected='selected'"; } ?> value="Waiting">Waiting</option>
                    <option <?php if($company->investment_status =="Not Approved") { echo "selected='selected'"; } ?> value="Not Approvedd">Not Approved</option>
                  </select>
                </td>
                <td><a href ="<?php echo base_url();?>admin/partner/editCompanyDetail/<?php echo $company->id;?>"><button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i></button></a></td> 
              </tr>
          <?php }    
        }
    }    
    
    function fetchMonthlyInvestment()
    {
            $status 	=	$this->input->post('status');
            $query 	=	$this->company_model->barGraphMonthlyInvestment($status);
            echo json_encode($query);
            exit;
    }

    // Used for donut chart approved and not approved investments.
    function donutChartInvestment()
    {
        $status 	=	$this->input->post('status');
        $result 	=	$this->company_model->donutChartInvestment($status);
        echo json_encode($result);
        exit;	
    }

    function areaChartInvestments()
    {
        $status 	=	$this->input->post('status');
        $result 	=	$this->company_model->areaChartInvestments($status);
        echo json_encode($result);
        exit;	
    }
}
   