<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller 
{       
    public function __construct()
    {
        parent::__construct();        
       $this->load->model(array('project_model','partner_model'));
    }
	
    public function projectList()
    {
        $data['companyData'] = $this->partner_model->getCompanyList();
        $data['projectData'] = $this->project_model->getProjectList();
        $this->load->view('projectList',$data);
    }   
    
    public function projectListPartnerUser()
    {
        $data['companyData'] = $this->partner_model->getCompanyList();
        $data['projectData'] = $this->project_model->getPartnerProjectList($this->session->userdata('user_id'));
        $this->load->view('projectListPartnerUser',$data);
    }   
    
    public function projectAdd()
    {
        $projectSql = array(
            'project_name'=>$this->input->post('txtProjectName'),
            'company_id'=>$this->input->post('selCompany'),
            'start_date'=>date('Y-m-d',strtotime($this->input->post('txtStartDate'))),
            'end_date'=>date('Y-m-d',strtotime($this->input->post('txtEndDate'))),
            'hours'=>$this->input->post('txtHours'),
            'lead'=>$this->input->post('txtLead'),
            'description'=>$this->input->post('txtDescription'),
            'created_by'=>$this->session->userdata('user_id'),
            'created_date'=>date('Y-m-d H:i:s'),
        );
        
        $this->db->insert('project',$projectSql);
        $projectData['data'] = $this->project_model->getProjectList();
        
        echo json_encode($projectData);
    }    
    
    public function getProjectDataById()
    {
        $data = $this->input->post('id');
        $projectData['data'] = $this->project_model->getProjectDataById($data);
        echo json_encode($projectData);
    }
    
    public function projectEdit($projectId)
    {
        $projectSql = array(
            'project_name'=>$this->input->post('txtProjectName'),
            'company_id'=>$this->input->post('selCompany'),
            'start_date'=>date('Y-m-d',strtotime($this->input->post('txtStartDate'))),
            'end_date'=>date('Y-m-d',strtotime($this->input->post('txtEndDate'))),
            'hours'=>$this->input->post('txtHours'),
            'lead'=>$this->input->post('txtLead'),
            'description'=>$this->input->post('txtDescription'),
            );
        
        $this->db->update('project',$projectSql,array('project_id'=>$projectId));
        $projectData['data'] = $this->project_model->getProjectList();
        echo json_encode($projectData);
    }        
}
   