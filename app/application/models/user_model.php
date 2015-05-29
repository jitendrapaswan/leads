<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model 
{
	// Check user is logged in or not.
    public function check_login()
    {       
        if($this->session->userdata('user_id') =='')
        {
            $this->session->sess_destroy();  
            redirect(base_url().'user/login');
        }
    }

    // used for km user login
	public function check_user_login($email,$password)
    {
        if(!empty($email) && !empty($password))
        {
            $this->db->select('id,first_name,last_name,role_id');
            $this->db->from('users');
            $this->db->where('email',$email);
            $this->db->where('password',md5($password));
            $this->db->where('role_id',2);
            $this->db->where('status',1);
            $query      =   $this->db->get();   
            if($query->num_rows()>0)
            {
                $results = $query->row();
                return $results; 
            }
            else
            {
                return false;   
            }
        }
        else
        {
                return false;
        }
    }

    // used for display list of approved companies for KM_user.
    public function getApprovedPartners()
    {
        $this->db->select('*')->from('companyinfo')->where(array('investment_status'=>'Approved','Status'=>1))->order_by('LastUpdated','DESC');        
        $query      =   $this->db->get();
        $result     =   $query->result(); 
        return $result;
    }
    
}	