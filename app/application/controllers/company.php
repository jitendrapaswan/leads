<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller 
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('partner_model');
       
    }    
    
    public function index()
    {
        redirect(base_url().'company/register');
    }

    public function register()
    {   
        if(!empty($_POST) && isset($_POST))
        {
            $this->form_validation->set_rules($this->validation_partnerSignUp());              
            if ($this->form_validation->run() == TRUE) 
            {
              $lastUpadated = date('Y-m-d H:i:s');                              
              $password     = $this->partner_model->generate_random_password(10);
              $companyInfo  = array(
                                    'CompanyName'       => $this->input->post('company_name'),
                                    'CompanyWebsite'    => $this->input->post('company_website'),
                                    'CompanySumm'       => $this->input->post('company_summary'),
                                    'investment_status' => "Not Available", 
                                    'LastUpdated'       => $lastUpadated,                                      
                                    'Status'            => 1
                                  );

                              $this->db->insert('companyinfo',$companyInfo);
                              $last_company_id = $this->db->insert_id();

              $contactInfo  = array(
                                    'first_name'        => $this->input->post('first_name'),
                                    'last_name'         => $this->input->post('last_name'),
                                    'email'             => $this->input->post('email'),  
                                    'password'          => md5($password),  
                                    'title'             => $this->input->post('title'),
                                    'address'           => $this->input->post('contact_address'),
                                    'address_line_2'    => $this->input->post('contact_address_2'),
                                    'country'           => $this->input->post('country'),
                                    'state'             => $this->input->post('state'),
                                    'city'              => $this->input->post('city'),
                                    'zip_code'          => $this->input->post('zipcode'),
                                    'phone'             => $this->input->post('contact_phone'),  
                                    'role_id'           => 4,  
                                    'status'            => 1,    
                                    'created_date'      => date('Y-m-d H:i:s'),                     
                                  );
                              $this->db->insert('users',$contactInfo);
                              $last_user_id = $this->db->insert_id();

              $company_users = array(
                                  'company_id'          => $last_company_id,
                                  'user_id'             => $last_user_id,
                                  'created_date'        => date('Y-m-d H:i:s'),
                              );

                              $this->db->insert('company_users',$company_users);
                              
            if($this->input->post('country') && $this->input->post('country')!="")
            {
                 $countryId = $this->input->post('country');
                 $countryData = $this->utility_model->get_country_by_id($countryId);
                 $countryName = $countryData->name;
            }

                  // send mail to registerd user.
              if(!empty($last_company_id))
              {
                $from     = "admin@lmsin.com";
                $to       = $this->input->post('email');
                $subject  = "KMBIC Partner Alliance" ;
                $message  = '<table>
                                <p>Your comapny has been registered successfully. Here are the login details -</p> 
                                <h4>Company information</h4>
                                <tr>
                                    <td><b>Company Name:</b></td>
                                    <td>'.$this->input->post('company_name').'</td>
                                </tr>

                                <tr>
                                    <td><b>Company Website:</b></td>
                                    <td>'.$this->input->post('company_website').'</td>
                                </tr>

                                <tr>
                                    <td><b>Company Summary:</b></td>
                                    <td>'.$this->input->post('company_summary').'</td>
                                </tr>
                            </table>

                            <table>
                              <h4>Primary Contact Information </h4>
                              <tr>
                                  <td><b>Name:</b></td>
                                  <td>'.$this->input->post('title').' '.$this->input->post('first_name').' '.$this->input->post('last_name').'</td>
                              </tr>

                                <tr>
                                    <td><b>Country:</b></td>
                                    <td>'.$countryName.'</td>
                                </tr>
                                
                                <tr>
                                    <td><b>Address Line 1:</b></td>
                                    <td>'.$this->input->post('contact_address').'</td>
                                </tr>
                            
                                <tr>
                                   <td><b>Address Line 2:</b></td>
                                   <td>'.$this->input->post('contact_address_2').'</td>
                                </tr>
                                
                                <tr>
                                    <td><b>City:</b></td>
                                    <td>'.$this->input->post('city').'</td>
                                </tr>
                                
                                <tr>
                                    <td><b>State:</b></td>
                                    <td>'.$this->input->post('state').'</td>
                                </tr>
                                
                                <tr>
                                    <td><b>Zipcode:</b></td>
                                    <td>'.$this->input->post('zipcode').'</td>
                                </tr>
                                

                              <tr>
                                  <td><b>Phone:</b></td>
                                  <td>'.$this->input->post('contact_phone').'</td>
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
                
                    $this->send_html_email($to, $subject, $message); 
                    $this->session->set_flashdata('message', 'Company information has been added successfully.Please check your mail');
                    redirect(base_url().'company/register');
                }             
            }
        }       
        
        $this->load->view('include/before_login_header');
        $this->load->view('partner_register');
    }

    public function send_email($from, $to, $subject, $message)
    {
        $this->load->library('email');
        $this->email->from($from);
        $this->email->to($to);         
        $this->email->set_mailtype("html");
        $this->email->subject($subject);
        $this->email->message($message);    
        $this->email->send();       
    }
          

    // validation server side for partner signup form.
    public function validation_partnerSignUp()
    {
        $this->form_validation->set_rules('company_name','company name','required');
        $this->form_validation->set_rules('company_website','company website','required');
        $this->form_validation->set_rules('company_summary','company summary','');          
        $this->form_validation->set_rules('first_name','first name','required');
        $this->form_validation->set_rules('last_name','last name','');
        $this->form_validation->set_rules('contact_address','contact address','');
        $this->form_validation->set_rules('contact_phone','contact phone','');
        $this->form_validation->set_rules('email','email','required');
    }

    // Used for partner user login.
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
                    $loginInfo =  $this->partner_model->check_partner_login($email,$password);                
                    if (!empty($loginInfo)) 
                    {       
                        $session = array('user_id' => $loginInfo->id,'role_id' => $loginInfo->role_id, 'first_name' =>$loginInfo->first_name , 'last_name' =>$loginInfo->last_name);
                        $this->session->set_userdata($session);
                        $this->session->set_flashdata('message', 'Welcome user.');
                        redirect(base_url().'project/projectlistpartneruser');
                    } 
                    else 
                    {
                        $this->session->set_flashdata('error', 'Username or password wrong.');
                        redirect(base_url().'company/login');  
                    }
                }
            }
        }
        $this->load->view('include/before_login_header', $data);   
        $this->load->view('partner_login');
    }


    // Change password functionality for partner user
    public function partner_change_password()
    {
        $this->partner_model->check_login();
        $user_id = $this->session->userdata('user_id');   
        if(!empty($_POST) && isset($_POST))
        {
            $info = array('password' => md5($this->input->post('newpassword')));    
            $this->db->where('id', $user_id);
            $this->db->where('role_id',4);
            $this->db->update('users', $info);        
            $this->session->set_flashdata('message',"Password has been changed successfully"); 
            redirect(base_url().'company/partner_change_password'); 
        }
        $this->load->view('partner_change_password');
    }

    
    // Check old password for partner user
    public function partner_old_password()
    {
        $oldpassword    = md5($this->input->post('oldpassword'));
        $user_id        = $this->session->userdata('user_id');             
        if(!empty($oldpassword) && !empty($user_id))
        {
            $this->db->select('password')->from('users')->where('id',$user_id);
            $query  = $this->db->get();
            $result = $query->row();
            if($result->password == $oldpassword)
            {
                    echo "true";
            }
            else
            {
                   echo "false";
            }
                   
        }
    }

    public function partner_notes()
    {
        $this->partner_model->check_login();
        $project_id     = $this->uri->segment(3); 
        $sender_user_id = $this->session->userdata('user_id');  
        if(!empty($_POST) && isset($_POST))
        {
            $project_id = $this->input->post('project_id'); 
            $message    = $this->input->post('message'); 
            $userInfo   = $this->partner_model->getUsers();          
            if(!empty($userInfo))
            {
                foreach ($userInfo as $row) 
                {
                        $data = array('project_id'=>$project_id,'message' =>$message,'sender_user_id' =>$sender_user_id,'receiver_user_id'=>$row->sender_id,'created_date'=>date('Y-m-d H:i:s'));
                        $this->db->insert('message',$data);
                }
                $this->session->set_flashdata('message', 'Message has been added successfully.');
                redirect(base_url().'company/partner_notes/'.$project_id);  
            }
        }            
        $this->data['message'] =  $message  = $this->partner_model->getMessages($project_id);            
        $this->load->view('partner_notes',$this->data);
    }
    
    // destroy session for partner user.
    public function logout()
    {
        $this->session->sess_destroy();  
        redirect(base_url().'company/login');
    }
    
    public function send_html_email($to,$subject,$message)
    {
        $this->load->library('email');   
        $config['protocol'] = 'smtp';
        $config['mailtype'] = 'html'; 
        $config['validate'] = false;
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_user'] = 'kmbicusa@gmail.com';
        $config['smtp_pass'] = 'Kmbs1234';
        $config['smtp_port'] = 587;

        $this->email->initialize($config);

        $this->email->from('admin@gmail.com');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
//        if($this->email->send()) {
//            echo 'Sent';
//        } else {
//           echo $this->email->print_debugger();
//        }
                  
    }
   

}