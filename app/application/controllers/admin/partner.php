<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partner extends CI_Controller 
{ 
    public $data = array() ;
    public $allorderssss ;
    public function __construct() 
    {
        parent::__construct();        
        $this->load->model(array('company_model','user_model'));
        if ($this->utility_model->is_logged_in() == FALSE) {
            redirect('admin/user/login');
        }
		//$this -> userData = $this -> utility_model -> user_data($this -> session -> userdata('user_id'));		
            //$this->data['newtasks'] =  $this->utility_model->getMyNewTaskCount($this->session->userdata('user_id'));
            //$this->data['neworders'] = $this->utility_model->getMyNewOrdersCount($this->session->userdata('user_id'));  		
           $this->data['dPlansStatus']        = $this->company_model->getDPStatus();
           $this->data['approvedCompanies'] = count($this->company_model->getApprovedViewStatus());
				
	/*	$this->data['newTaskLastUpdatedTime'] 	=  $this->utility_model->getMyNewTaskLastUpdatedTime($this->session->userdata('user_id'));
		$this->data['newOrderLastUpdatedTime'] 	=  $this->utility_model->getMyNewOrdersUpdatedTime($this->session->userdata('user_id'));		
		$this->data['getNewCommentsCount'] 	=  $this->utility_model->getNewCommentsCount($this->session->userdata('user_id'));		
		$this->data['getRecentCommentTime'] 	=  $this->utility_model->getRecentCommentTime(); */
		
		
		
    }
    public function index() 
    {
        redirect('admin/partner/dashboard');
    }
    
    public function dashboard() 
    {
        $this->data['content']['title'] = 'Partner Alliance Detail';
	$this->data['title']            = 'Partner Alliance Detail';        
        $this->load->view('admin/dashboard', $this->data);
    }
    
    public function dashboardusers() 
    {
        $this->data['content']['title'] = 'Partner Alliance Detail';
        $this->data['title']            = 'Partner Alliance Detail';
        $this->data['companies']        = $this->company_model->get_companies();		   
        $this->load->view('admin/company_list', $this->data);
    }

    public function getApprovedPartners()
    {
	$this->data['content']['title'] = 'Partner Alliance Detail';
	$this->data['title']            = 'Partner Alliance Detail';
	$this->data['companies']        = $this->company_model->getApprovedViewStatus() ;	
	$this->load->view('admin/company_list', $this->data);
    }
    
    public function getDevelopementPlans()
    {
	$this->data['content']['title'] = 'Partner Alliance Detail';
	$this->data['title']            = 'Partner Alliance Detail';
	$this->data['companies']        = $this->company_model->getDevelopementPlans() ;	
	$this->load->view('admin/company_list', $this->data);
    }

    
   /* public function detail($companyId) 
    {
       	$cmpny_id =	$this->uri->segment(4);       	
       	$this->db->where('u_id',$this->session->userdata('user_id'));     
       	$this->db->where('comapny_id',$cmpny_id);       	
        $this->db->delete('comment_status');        

       	if($this->input->post('savecomment'))
        {
                $commentData = $this->input->post(); 						
                $commentArray = array(
                        'UserId'		=>	$commentData['hdnUserId'],
                        'CompanyId'		=>	$commentData['hdnCompanyId'],
                        'Comment'		=>	$commentData['comment'],
                        'Rating'		=>	$commentData['rating'],
                        'DateTime'		=>	date('Y-m-d H:i:s')
                );			
                $this->db->insert('comment',$commentArray);			
                $last_inserted_comment_id 	=	$this->db->insert_id();			
                $this->utility_model->checkCommentReadStaus($last_inserted_comment_id,$commentData['hdnCompanyId']);
                $this->session->set_flashdata('comment_success','Your comment is successfully added !');			
                redirect(uri_string());			
        }
        $this->utility_model->setCompanyViewed($this->session->userdata('user_id'), $companyId);				
        $companyDetail = $this->company_model->get_company_detail_by_id($companyId);      
	$this->data['content']['userData'] = $this -> userData;
        $this->data['content']['title'] = 'Partner Alliance Detail';
        $this->data['content']['companyDetail'] = $companyDetail;
        $this->data['commentData'] = $this->company_model->get_company_comments($companyId);
        
        $this->load->view('admin/view_company', $this->data);
    } */
	
   

    

    function editCompanyDetail()
    {
        $company_id   = $this->uri->segment(4);
        $this->data['companyDetail'] = $companyDetail = $this->company_model->get_company_detail_by_id($company_id);        
        $presentDetail = (array)$companyDetail;            
        unset($presentDetail['LastUpdated']);
        
        if(!empty($_POST) && isset($_POST))
        {
            $lastUpadated = date('Y-m-d H:i:s');
            if($this->input->post('BicInvestment')== "no") {
                $InvestmentUSD 		= ''; 
                $InvestmentType 	= ''; 
                $EquityPosition 	= ''; 
                $CloseDate 			= '';
            }
            else
            {
                $InvestmentUSD 		=	$this->input->post('InvestmentUSD'); 
                $InvestmentType		=	$this->input->post('InvestmentType'); 
                $EquityPosition		=	$this->input->post('EquityPosition');
                $CloseDate		=	$this->input->post('CloseDate');      
            }

            if($this->input->post('CompanyType')== "public")
            {
                $FinancingStatus	=	'';
                $valuation		=	'';
            }
            else
            {	
            	$FinancingStatus	=	$this->input->post('FinancingStatus');
            	$valuation		=	$this->input->post('valuation');
            }           
            $fields = array(
                            'CompanyName'       => $this->input->post('CompanyName'),
                            'CompanyWebsite'    => $this->input->post('CompanyWebsite'),  
                            'CompanyRating'     => $this->input->post('CompanyRating'),                         
                            'CompanyType'       => $this->input->post('CompanyType'),
                            'FinancingStatus'   => $FinancingStatus,
                            'valuation'         => $valuation,
                            'ThemeAlign'        => $this->input->post('ThemeAlign'),
                            'BicInvestment'     => $this->input->post('BicInvestment'),
                            'InvestmentUSD'     => $InvestmentUSD,
                            'InvestmentType'    => $InvestmentType,
                            'EquityPosition'    => $EquityPosition,
                            'CloseDate'         => $CloseDate,                           
                            'Source'            => $this->input->post('Source'),
                            'BicLead'           => $this->input->post('BicLead'),
                            'LastUpdated'       => $lastUpadated,
                            'Status'            => 1
                          );
             
            $this->db->where('id',$company_id);
            $this->db->update('companyinfo',$fields);
            
            unset($fields['LastUpdated']);
            $updateDetail	= $fields;     
            $result 		= array_diff($updateDetail,$presentDetail);            
            
            if(!empty($result))
            {
            	$editeddate 	= date('Y-m-d H:i:s');
		$edited_by	= $this->session->userdata('user_id');
            	$this->db->set('company_id', $company_id);
		$this->db->set('updated_time', $editeddate);
		$this->db->set('edited_by', $edited_by);
            	$this->db->set($result);
		$this->db->insert('company_history'); 					
            }            
            $this->session->set_flashdata('message', 'Information has been updated successfully.');
            redirect(base_url().'admin/partner/editCompanyDetail/'.$company_id);  
        }
        $this->load->view('admin/edit_company_detail',$this->data);
    }

    public function companyHistory()
    {
    	$company_id   	    = $this->uri->segment(4);
    	$this->data['info'] = $companyDetail = $this->company_model->get_company_detail_by_id($company_id);        
    	$this->load->view('admin/company_history',$this->data);
    }

    public function filter_history_records()
    {
    	$info  	     = $this->input->post('info');
    	$company_id  = $this->input->post('company_id');
    	$this->data['companyDetail'] 	= 	$companyDetail = $this->company_model->get_company_history_by_id($company_id);     	
    	if(!empty($info))
    	{
    		$fieldNames = implode(",",$info);    		
    		$this->data['companyDetail'] =	$companyDetail = $this->company_model->filter_history_records($fieldNames,$info,$company_id);
    	}
    	$this->load->view('admin/company_history_records',$this->data);
    	
    }
}



/* End of file partner.php */
/* Location: ./application/controllers/admin/partner.php */

