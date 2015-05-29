<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{       
      public function __construct()
      {
          parent::__construct();        
          
      }
	   
	    public function index()
      {
          $data = array();
          $data['title'] = 'Home';   
		      $this->load->view('include/header', $data);
		      $this->load->view('front_user/partnerSignUp');
	    } 
     
     public function add_company_info(){  
          if(!empty($_POST) && isset($_POST))
          {        
            $lastUpadated = date('Y-m-d H:i:s');
            $fields = array(
                'CompanyName' => $this->input->post('CompanyName'),
                'CompanyWebsite' => $this->input->post('CompanyWebsite'),
                'investment_status' => 'Not Available',
                'CompanyType' => $this->input->post('CompanyType'),
                'FinancingStatus' => $this->input->post('FinancingStatus'),
                'valuation' => $this->input->post('valuation'),
                'ThemeAlign' => $this->input->post('ThemeAlign'),
                'CompanySumm' => $this->input->post('CompanySumm'),
                'ValueProposition' => $this->input->post('ValueProposition'),
                'CompanyProgress' => $this->input->post('CompanyProgress'),
                'BicInvestment' => $this->input->post('BicInvestment'),
                'InvestmentUSD' => $this->input->post('InvestmentUSD'),
                'InvestmentType' => $this->input->post('InvestmentType'),
                'EquityPosition' => $this->input->post('EquityPosition'),
                'CloseDate' => $this->input->post('CloseDate'),
                'DevelopmentPlans' => $this->input->post('DevelopmentPlans'),
                'CustomerTarget' => $this->input->post('CustomerTarget'),
                'Source' => $this->input->post('Source'),
                'BicLead' => $this->input->post('BicLead'),
                'LastUpdated' => $lastUpadated,
                'Status' => 1
            );
          
            
            $fields123 = array(
                'first_name' => $this->input->post('FirstName'),
                'last_name' => $this->input->post('LastName'),
                'title' => $this->input->post('Title'),
                'address' => $this->input->post('ContactAddress'),
                'phone' => $this->input->post('ContactPhone'),
                'email' => $this->input->post('Email'),
           ); 
            
            $companyId = $this->companyinfo_model->insert_company_info($fields, $fields123);
         
               $getUser = $this->user_model->get_all_user();
               if(!empty($getUser))
               {    
              foreach($getUser as $email){
                
                            $from ="admin@lmsin.com";
                            $to= $email->Email;
                            $subject="KMBIC Partner Alliance Request" ;
                            $message='<table style="">
                            <caption>Company information</caption>
                            <tr><td><b>Company Name:</b></td>
                                 <td>'.$fields['CompanyName'].'</td></tr>
                            <tr><td><b>Company Website:</b></td>
                                 <td>'.$fields['CompanyWebsite'].'</td></tr>
                            <tr><td><b>Company Summary:</b></td>
                                 <td>'.$fields['CompanySumm'].'</td></tr>
                            <tr><td><b>Customer Target:</b></td>
                                 <td>'.$fields['CustomerTarget'].'</td></tr>
                            <tr><td><b>Source:</b></td>
                                 <td>'.$fields['Source'].'</td></tr>
                            </table><br><br><table style="width:200px;"><caption>Primary Contact Information </caption>
                            <tr><td><b>First Name:</b></td>
                                <td>'.$fields123['FirstName'].'</td></tr>
                            <tr><td><b>Title:</b></td>
                                <td>'.$fields123['Title'].'</td></tr>
                            <tr><td><b>Adress:</b></td>
                                <td>'.$fields123['ContactAddress'].'</td></tr>
                             <tr><td><b>Phone:</b></td>
                                <td>'.$fields123['ContactPhone'].'</td></tr>
                            <tr><td><b>Email:</b></td>
                                <td>'.$fields123['Email'].'</td></tr>
                                         
                            </table><br>

                            <p> If you want to comment please click below link </p>
                            <a href="http://salusbank.ch/partnerAlliance/index.php/home/rat_comment/'.$companyId.'/'.$email->id.'">Click Here !</a>';
                            
                            $this->send_email($from,  $email->Email,$subject, $message);
               }}     
                $this->session->set_flashdata('message', 'Company information has been added.');
                 redirect(base_url().'home/add_company_info');
              }
              $this->load->view('include/header', $data);
              $this->load->view('include/front');
            
    }
    
    public function get_user(){  
           $getUser = array();         
        
           $getUser = $this->user_model->get_all_user();
              foreach($getUser as $email){
                echo $email->Email  ;
              }
       }
       
         public function primary_contact_info(){
          $fields = array(
                'first_name' => $this->input->post('FirstName'),
                'last_name' => $this->input->post('LastName'),
                'title' => $this->input->post('Title'),
                'address' => $this->input->post('ContactAddress'),
                'phone' => $this->input->post('ContactPhone'),
                'email' => $this->input->post('Email'),
           );
            $this->companyinfo_model->insert_contact_info($fields);
            redirect('home');
            
    }
    
        public function test_email(){
            
            $to      = 'vnd.tanwar1101@gmail.com';
            $subject = 'the subject';
            $message = 'hello';
            $headers = 'From: webmaster@example.com' . "\r\n" .
                'Reply-To: webmaster@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers); 
           
            }
    
          public function send_email($from, $to, $subject, $message)
          {
        
        $this->load->library('email');

        $this->email->from($from);
        $this->email->to($to); 
        //$this->email->cc('another@another-example.com'); 
       // $this->email->bcc('them@their-example.com'); 
        $this->email->set_mailtype("html");
        $this->email->subject($subject);
        $this->email->message($message);    

        $this->email->send();

       // echo $this->email->print_debugger();
            }
            
            
       // code for rating and comment     
            
            public function rat_comment($companyId){  
                //echo  $companyId ; die;            
               $data = array(); 
               $data['content']['title'] = 'All information'; 
               $data['content']['companyData'] = $this->rating_comment_model->view_information($companyId);
                              
               $this->load->view('include/header', $data); 
               $this->load->view('front/rating_comment', $data); 
       
            } 
            
            
            public function add_company_comment()
            {
                $commentData = $this->input->post(); 
                $commentArray = array(
                    'UserId'=>$commentData['hdnUserId'],
                    'CompanyId'=>$commentData['hdnCompanyId'],
                    'Comment'=>$commentData['comment'],
                    'Rating'=>$commentData['rating'],
                    'DateTime'=>date('Y-m-d H:i:s')
                    );
                //print_r($_POST);
                $this->db->insert('comment',$commentArray);
							
				$commentId = $this->db->insert_id();
				$companyId = $commentData['hdnCompanyId'];
				$commentBy = $commentData['hdnUserId'] ;
				
				 $commentUserdata = array(
                    'comment_id'=>$commentId,
                    'comment_by'=>$commentBy,
                    'company_id'=>$companyId                   
                  );
				  
				$this->db->insert('user_comments_map',$commentUserdata);				
				
                $this->session->set_flashdata('comment_success','Your comment is successfully added !');
                redirect('home/rat_comment/'.$commentData['hdnCompanyId'].'/'.$commentData['hdnUserId']);
            }
            
       public function add_rating_comment(){  
                             
                $fields = array(
                'Comment' => $this->input->post('Comment'),
               );
               $fields123 = array(
                'Comment' => $this->input->post('Rating'),
               );
               
               $this->companyinfo_model->insert_rating_comment($fields, $fields123);   
       } 

       

       
            
       

       // registration for partner signup 
     /*   function partnerSignUp()
       {
          if(!empty($_POST) && isset($_POST))
          {
              $this->form_validation->set_rules($this->validation_partnerSignUp());              
              if ($this->form_validation->run() == TRUE) 
              {
                $lastUpadated = date('Y-m-d H:i:s');                              
                $password     = $this->companyinfo_model->generate_random_password(10);
                $companyInfo  = array(
                                      'CompanyName'       => $this->input->post('company_name'),
                                      'CompanyWebsite'    => $this->input->post('company_website'),
                                      'CompanySumm'       => $this->input->post('company_summary'),
                                      'investment_status' => "Not Available", 
                                      'LastUpdated'       => $lastUpadated,                                      
                                      'Status'            => 1
                                    );
                $contactInfo  = array(
                                      'FirstName'         => $this->input->post('first_name'),
                                      'LastName'          => $this->input->post('last_name'),
                                      'Email'             => $this->input->post('email'),  
                                      'Password'          => md5($password),  
                                      'Title'             => $this->input->post('title'),
                                      'ContactAddress'    => $this->input->post('contact_address'),
                                      'ContactPhone'      => $this->input->post('contact_phone'),  
                                      'role_id'           => 3,                         
                                    );
                $companyId = $this->companyinfo_model->insert_company_info($companyInfo, $contactInfo); 
                // send mail to registerd user.
                if(!empty($companyId))
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
                                    <td><b>Address:</b></td>
                                    <td>'.$this->input->post('contact_address').'</td>
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
                              $this->send_email($from,  $email->Email,$subject, $message); 
                              $this->session->set_flashdata('message', 'Company information has been added successfully.Please check your mail');
                              redirect(base_url().'home/partnerSignUp');
                }             
              }
          }          
          $this->load->view('include/header', $data);
          $this->load->view('front_user/partnerSignUp');
        }

        // validation server side for partner signup form
        public function validation_partnerSignUp()
        {
          $this->form_validation->set_rules('company_name','company name','required');
          $this->form_validation->set_rules('company_website','company website','required');
          $this->form_validation->set_rules('company_summary','company summary','');          
          $this->form_validation->set_rules('first_name','first name','required');
          $this->form_validation->set_rules('last_name','last name','');
          $this->form_validation->set_rules('contact_address','contact address','');
          $this->form_validation->set_rules('contact_phone','contact phone','');
          $this->form_validation->set_rules('email','email','required|callback_check_duplicate_email['.$this->input->post('email').']');
          $this->form_validation->set_message('check_duplicate_email', 'This email is already exist. Please write a new email.');             
        }

        /* validation rules for partner signup 
        public function check_duplicate_email($post_email)
        {
            return $this->companyinfo_model->checkDuplicateEmail($post_email);
        }
        
        // check old password functionality for change password
       public function checkOldPassword()
        {
            $oldpassword    = md5($this->input->post('oldpassword'));
            $user_id        = $this->session->userdata('user_id');             
            if(!empty($oldpassword) && !empty($user_id))
            {
                $this->db->select('Password')->from('contactinfo')->where('id',$user_id);
                $query  = $this->db->get();
                $result = $query->row();
                if($result->Password == $oldpassword)
                {
                    echo "true";
                }
                else
                {
                   echo "false";
                }
                   
            }
        }

        public function partnerLogin()
        {
          if(!empty($_POST) && isset($_POST))
          {
              $email    = $this->input->post('email');
              $password = $this->input->post('password');
              if(!empty($email) && !empty($password))
              {
                $partnerInfo =  $this->companyinfo_model->checkPartnerLogin($email,$password); 
                if (!empty($partnerInfo)) 
                {                    
                    $session = array('user_id' => $partnerInfo->id,'role_id' => $partnerInfo->role_id, 'FirstName' =>$partnerInfo->FirstName , 'LastName' =>$partnerInfo->LastName);
                    $this->session->set_userdata($session);
                    $this->session->set_flashdata('message', 'Welcome user.');
                    redirect(base_url().'home/viewNotes');
                } 
                else 
                {
                    $this->session->set_flashdata('error', 'Username or password wrong.');
                    redirect(base_url().'home/partnerLogin');  
                }
              }
          }
          $this->load->view('include/header', $data);
          $this->load->view('front_user/partnerLogin');
        }       

        public function partnerChangePassword()
        {
            $this->companyinfo_model->check_login();
            $user_id = $this->session->userdata('user_id');   
            if(!empty($_POST) && isset($_POST))
            {
              $info = array('Password' => md5($this->input->post('newpassword')));    
              $this->db->where('id', $user_id);
              $this->db->update('contactInfo', $info);        
              $this->session->set_flashdata('message',"Password has been changed successfully"); 
              redirect(base_url().'home/partnerChangePassword'); 
            }
            $this->load->view('front_user/partnerChangePassword');
        }

        public function logout()
        {
            $this->session->sess_destroy();  
            redirect(base_url().'home/partnerLogin');
        } 

        public function viewNotes()
        {
          $this->companyinfo_model->check_login();
          $this->data['record'] = $topicDetail  = $this->companyinfo_model->getTopics();
          $this->load->view('front_user/viewNotes',$this->data);
        }


        

        public function addTopic()
        {
          $this->companyinfo_model->check_login();
          $user_id = $this->session->userdata('user_id');  
          if(!empty($_POST) && isset($_POST))
          { 
              $topic_name   = $this->input->post('topic_name');
              $data = array('topic_name' =>$topic_name,'created_by'=>$user_id,'created_date'=>date('Y-m-d H:i:s'));
              $this->db->insert('topics',$data);
              $this->session->set_flashdata('message', 'Topic has been added successfully.');
              redirect(base_url().'home/viewNotes');  
          }
            $this->load->view('front_user/addTopic',$this->data);
        } */
        
        

        
            
}
   