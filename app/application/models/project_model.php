<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model {
    
    /*
     * constructor
     */
    public function __construct(){
        parent::__construct();
    }
  
    public function getProjectList()
    {
        $this->db->select('project.*,DATE_FORMAT(start_date, "%d-%m-%Y") as start_date,DATE_FORMAT(end_date, "%d-%m-%Y") as end_date, companyinfo.CompanyName as company_name',FALSE);
        $this->db->from('project');
        $this->db->join('companyinfo','project.company_id=companyinfo.id');
        $this->db->where('project_status',1);
        $this->db->order_by('project_id','ASC'); 
        $query = $this->db->get();
        $result = $query->result(); 
        return $result;
    } 
    
    public function getProjectDataById($projectId)
    {
        $this->db->select('project.*,DATE_FORMAT(start_date, "%d-%m-%Y") as start_date,DATE_FORMAT(end_date, "%d-%m-%Y") as end_date,companyinfo.CompanyName as company_name',FALSE);
        $this->db->from('project');
        $this->db->join('companyinfo','project.company_id=companyinfo.id');
        $this->db->where(array('project_id'=>$projectId,'project_status'=>1));
        $this->db->order_by('project_id','ASC'); 
        $query = $this->db->get();
        $result = $query->row(); 
        return $result;
    } 
    
    public function getPartnerProjectList($partnerId)
    {
        $query = "select company_id from company_users where user_id=".$partnerId;
        $result = $this->db->query($query);
        if($result->num_rows > 0)
        {    
            $data = $result->row_array();            
            
            $this->db->select('project.*,DATE_FORMAT(start_date, "%d-%m-%Y") as start_date,DATE_FORMAT(end_date, "%d-%m-%Y") as end_date, companyinfo.CompanyName as company_name',FALSE);
            $this->db->from('project');
            $this->db->join('companyinfo','project.company_id=companyinfo.id');
            $this->db->where(array('project_status'=>1,'company_id'=>$data['company_id']));
            $this->db->order_by('project_id','ASC'); 
            $query = $this->db->get();
            $result = $query->result(); 
            return $result;
        }
    }         
}