<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('admin_model');       
    }
    
    public function index()
    {
        if(!empty($_POST) && isset($_POST))
        {
            $this->form_validation->set_rules('email',    'email',    'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            if ($this->form_validation->run() == TRUE) 
            {
                $email      = $this->input->post('email');
                $password   = $this->input->post('password');
                if(!empty($email) && !empty($password))
                {
                    $loginInfo =  $this->admin_model->check_admin_login($email,$password);                     
                    if (!empty($loginInfo)) 
                    {                    
                        $session = array('user_id' => $loginInfo->id,'role_id' => $loginInfo->role_id, 'first_name' =>$loginInfo->first_name , 'last_name' =>$loginInfo->last_name);
                        $this->session->set_userdata($session);
                        $this->session->set_flashdata('message', 'Welcome Admin.');                        
                        redirect(base_url().'admin/partner/dashboard');

                    } 
                    else 
                    {
                        $this->session->set_flashdata('error', 'Username or password wrong.');
                        redirect(base_url().'admin/login');  
                    }
                }
               
            }
        }
        $this->load->view('admin/login');
    }

}
