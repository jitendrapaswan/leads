<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partner_model extends CI_Model 
{
	// Check user is logged in or not.
    public function check_login()
    {       
        if($this->session->userdata('user_id') =='')
        {
            $this->session->sess_destroy();  
            redirect(base_url().'partner/login');
        }
    }

    // used for partner login
	public function check_partner_login($email,$password)
    {
        if(!empty($email) && !empty($password))
        {
            $this->db->select('id,first_name,last_name,role_id');
            $this->db->from('users');
            $this->db->where('email',$email);
            $this->db->where('password',md5($password));
            $this->db->where('role_id',4);
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

    public function getUsers()
    {
        $this->db->select('id as sender_id');
        $this->db->from('users');            
        $this->db->where('status',1);            
        $query      =   $this->db->get();  
        $result     =   $query->result(); 
        return $result;
    }

    public function getMessages($project_id)
    {
        $user_id = $this->session->userdata('user_id');
        if(!empty($user_id) && !empty($project_id))
        {
            $where = "(project_id = $project_id) AND (sender_user_id = $user_id OR receiver_user_id = $user_id)";
            $this->db->select('project_id,message,created_date,sender_user_id,receiver_user_id');
            $this->db->from('message');     
            $this->db->where($where);       
            $this->db->order_by('created_date','ASC'); 
            $query      =   $this->db->get();           
            $result     =   $query->result(); 
            return $result;
        } 
    }

    public function getReceiverName($user_id)
    {
        if(!empty($user_id))
        {
            $this->db->select('first_name,last_name');
            $this->db->from('users');
            $this->db->where('id',$user_id);
            $query      =   $this->db->get();  
            $result     =   $query->row(); 
            return $result;
        }
    }

    function generate_random_password($length = 10) 
    {
        $password = '';
        $alphabets =  range('A','Z');
        $numbers   =  range('0','9');        
        $final_array = array_merge($alphabets,$numbers);         
        while($length--) 
        {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }  
        return $password;
    }
    
    public function getCompanyList()
    {
        $this->db->select('id,CompanyName');
        $this->db->from('companyinfo');
        $this->db->where('companyinfo.Status',1);
        $this->db->order_by('CompanyName','ASC'); 
        $query = $this->db->get();
        $result = $query->result(); 
        return $result;
    } 
    
    
}	