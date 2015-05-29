<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() 
    {
        redirect(base_url().'user/login');
    }

    // Used for km_user login.
    public function login()
    {
        if(!empty($_POST) && isset($_POST))
        {
            $this->form_validation->set_rules('email',    'email',    'required|trim');
            $this->form_validation->set_rules('password', 'password', 'required|trim');
            if ($this->form_validation->run() == TRUE) 
            {
                $email    = $this->input->post('email');
                $password = $this->input->post('password');
                if(!empty($email) && !empty($password))
                {
                    $loginInfo =  $this->user_model->check_user_login($email,$password);                
                    if (!empty($loginInfo)) 
                    {                  
                        $session = array('user_id' => $loginInfo->id,'role_id' => $loginInfo->role_id, 'first_name' =>$loginInfo->first_name , 'last_name' =>$loginInfo->last_name);
                        $this->session->set_userdata($session);
                        $this->session->set_flashdata('message', 'Welcome user.');
                        redirect(base_url().'user/dashboard');
                    } 
                    else 
                    {
                        $this->session->set_flashdata('error', 'Username or password wrong.');
                        redirect(base_url().'user/login');  
                    }
                }
            }
        }
        $this->load->view('include/before_login_header', $data);   
        $this->load->view('user_login');
    }


    // Display list of approved companies for KM_user.
    public function dashboard()
    {
        $this->user_model->check_login(); 
        $this->data['companyInfo']  = $this->user_model->getApprovedPartners();
        $this->load->view('user_dashboard',$this->data);
    }


    // Change password functionality for km user
    public function change_password()
    {
        $this->user_model->check_login();
        $user_id = $this->session->userdata('user_id');   
        if(!empty($_POST) && isset($_POST))
        {
            $info = array('password' => md5($this->input->post('newpassword')));    
            $this->db->where('id', $user_id);
            $this->db->where('role_id',2);
            $this->db->update('users', $info);        
            $this->session->set_flashdata('message',"Password has been changed successfully"); 
            redirect(base_url().'user/change_password'); 
        }
        $this->load->view('user_change_password');
    }

    
    // Check old password for km user
    public function check_old_password()
    {
        $this->user_model->check_login();
        $user_id        = $this->session->userdata('user_id');                 
        $oldpassword    = md5($this->input->post('oldpassword'));
        if(!empty($oldpassword) && !empty($user_id))
        {
            $this->db->select('password')->from('users')->where('id',$user_id);
            $query  = $this->db->get();
            $result = $query->row();
            if($result->password == $oldpassword) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }

    // check duplicacy for email.
    public function check_email_exist()
    {
        $post_email   =  $this->input->post('email');
        $this->db->where('email', $post_email);
        $query = $this->db->get('users');
        $count_row = $query->num_rows();
        if ($count_row > 0) {      
          echo "false";
        } else {        
          echo "true";
        }
    }

    // destroy session for km user.
    public function logout()
    {
        $this->session->sess_destroy();  
        redirect(base_url().'user/login');
    }

}

