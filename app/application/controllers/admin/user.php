<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model(array('admin_model','partner_model'));                
        if ($this->admin_model->is_logged_in() == FALSE) {
            redirect('admin/login');
        } 
    }
    
    public function index() 
    {
        if ($this->admin_model->is_logged_in() == FALSE) {
            redirect('admin/login');
        }  else {
            redirect('admin/user/userlist');
        }
    }
   
    public function logout() 
    {
        $this->session->sess_destroy();
        redirect('admin/login');
    }

    public function userlist() 
    {   
        $data['users'] = $this->admin_model->getAllUsers();
        $this->load->view('admin/include/header_menu');
        $this->load->view('admin/userlist', $data);
    }

    public function add_user() 
    {  
        if(!empty($_POST) && isset($_POST))
        {
            $password     = $this->partner_model->generate_random_password(10);
            $fields     = array(
                                'first_name'   =>   $this->input->post('first_name'),
                                'last_name'    =>   $this->input->post('last_name'),
                                'password'     =>   md5($password) ,
                                'email'        =>   $this->input->post('email'),                
                                'role_id'      =>   2,   
                                'created_date' =>   date('Y-m-d H:i:s'),
                                'status'       =>   1
            );
            $this->db->insert('users',$fields);
            $last_user_id = $this->db->insert_id();
            if(!empty($last_user_id))
            {
              $to       = $this->input->post('email');
              $subject  = "KMBIC Partner Alliance" ;
              $message  = '<table>
                            <p>Your account has been registered successfully. Here are the login details -</p> 
                            <h4>Login Information </h4>
                            <tr>
                                <td><b>Name:</b></td>
                                <td>'.$this->input->post('first_name').' '.$this->input->post('last_name').'</td>
                            </tr>                           

                            <tr>
                                <td><b>Email:</b></td>
                                <td>'.$this->input->post('email').'</td>
                            </tr> 

                            <tr>
                                <td><b>Password:</b></td>
                                <td>'.$password.'</td>
                            </tr>      
                          </table>'; 
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <admin@lmsin.com>' . "\r\n";
                mail($to,$subject,$message,$headers);
            }     
            
            $users['data'] = $this->admin_model->getAllUsers();
            echo json_encode($users);
        }
        
    }
    
    public function getUserDataById()
    {
        $user_id = $this->input->post('id');
        $userData['data'] = $this->admin_model->getUserDataById($user_id);
        echo json_encode($userData);
    }
    
    public function edit_user($userId)
    {
        $userInfo = array(
            'first_name'   =>   $this->input->post('first_name'),
            'last_name'    =>   $this->input->post('last_name'),            
            'email'        =>   $this->input->post('email'),                
            'role_id'      =>   2,   
            'last_updated_date' =>   date('Y-m-d H:i:s'),
            'status'       =>   1
            );
            $this->db->update('users',$userInfo,array('id'=>$userId));
            $users['data'] = $this->admin_model->getAllUsers();
            echo json_encode($users); 
    }    
    public function delete_all_users() 
    {
        if(!empty($_POST) && isset($_POST))
        {
            $userArray = $this->input->post('user_id');
            $this->db->where_in('id', $userArray); 
            $this->db->delete('users'); 
            $this->session->set_flashdata('message', 'Users has been deleted successfully.');
            redirect('admin/user/userlist');
        }
    }

    public function delete_user() 
    {
       $user_id = $this->input->post('user_id');
        if(!empty($user_id))
        {
            $this->db->where('id',$user_id);
            $this->db->delete('users'); 
            echo "1";
        }
    }
}