<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model 
{
	public function is_logged_in() 
    {
        return $this->session->userdata('user_id') ? $this->session->userdata('user_id') : false;
    }

    public function check_admin_login($email,$password)
    {
        if(!empty($email) && !empty($password))
        {
            $this->db->select('id,first_name,last_name,role_id');
            $this->db->from('users');
            $this->db->where('email',$email);
            $this->db->where('password',md5($password));
            $this->db->where('role_id',1);
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

    public function getAllUsers() 
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('role_id',2);
        $this->db->where('status',1);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getUserDataById($user_id)
    {
        if(!empty($user_id))
        {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('id',$user_id);
            $this->db->where('role_id',2);
            $this->db->where('status',1);
            $query = $this->db->get();
            return $query->row();
        }
    }

    public function search_by_user($searchterm)
    {
        if(!empty($searchterm))
        {
            $where = "first_name like '%$searchterm%' or last_name like '%$searchterm%'";
            $this->db->select('*');
            $this->db->from('users');            
            $this->db->where('role_id',2);
            $this->db->where('status',1);
            $this->db->where($where);
            $query = $this->db->get();            
            return $query->result();
        }
    }
}
