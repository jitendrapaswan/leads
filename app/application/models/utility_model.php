<?php

class Utility_model extends CI_Model {
    /*
     * constructor
     */

    public function __construct() {
        parent::__construct();
        $this->_prefix = $this->config->item('table_prefix');
        $this->_userTable = $this->_prefix . 'users';
        $this->_roleMapTable = $this->_prefix . 'role_map';
        $this->_roleTable = $this->_prefix . 'role';
        $this->_commentTable = $this->_prefix . 'comment';
        $this->_companyInfoTable = $this->_prefix . 'companyinfo';
        $this->_companyInfoTable = $this->_prefix . 'companyinfo';
        $this->_userCompanyMapTable = $this->_prefix . 'user_company_map';		
		$this->_user_comments_map = $this->_prefix . 'user_comments_map';
		
		
    }

   

    

// **************************************************************************************************************
    // Get All Roles
// **************************************************************************************************************    
    function get_roles() {
        $query = $this->db->get_where($this->_roleTable, array('status' => 1));
        return $query->result();
    }

    function getRoleNameById($rid) {
        if (empty($rid))
            return false;
        $this->db->select('RoleName');
        $query = $this->db->get_where($this->_roleTable, array('RoleId' => $rid));
        if ($query) {
            $data = $query->row();
            $query->free_result();
            return $data->RoleName;
        } else {
            return false;
        }
    }

    public function getCompaniesTotalCount() {
        $this->db->select('id');
        $this->db->where('Status', 1);
        $query1 = $this->db->get($this->_companyInfoTable);
        return $query1->num_rows();
    }

    public function getMyCommentsTotalCount($uid) {
        $this->db->select('id');
        $this->db->where('UserId', $uid);
        $this->db->group_by('CompanyId');
        $query = $this->db->get($this->_commentTable);
        return $query->num_rows();
    }

    public function getMyNewTaskCount($uid = false) {
        // 
        if (empty($uid)) {
            return 0;
        }
        $totalCompany = $this->getCompaniesTotalCount();
        $totalCompanyComment = $this->getMyCommentsTotalCount($uid);
        $newTasks = $totalCompany - $totalCompanyComment;
        if ($newTasks > 0) {
            return $newTasks;
        } else {
            return 0;
        }
    }

    public function getMyNewOrdersCount($uid) {
        if (empty($uid)) {
            return 0;
        }
        $this->db->select($this->_companyInfoTable . '.* ');
        //$this->db->join($this->_userCompanyMapTable, $this->_userCompanyMapTable . '.CompanyId = ' . $this->_companyInfoTable . '.id', 'left');
        //$this->db->where($this->_userCompanyMapTable.'.CompanyId', NULL);
        //$this->db->where('('.$this->_userCompanyMapTable.'.UserId != '.$uid.' AND '.$this->_userCompanyMapTable.'.CompanyId != NULL) OR ('.$this->_userCompanyMapTable.'.CompanyId = NULL)');
        $this->db->where('Status', 1);
        $query = $this->db->get($this->_companyInfoTable);
        $totalNumrows = $query->num_rows();
        $query->free_result();
        $query = $this->db->get_where($this->_userCompanyMapTable, array('UserId' => $uid));
        $mapNumRows = $query->num_rows();
        $query->free_result();
        $return = $totalNumrows - $mapNumRows;
        if ($return > 0) {
            return $return;
        } else {
            return 0;
        }
    }

    public function getMyNewOrdersDetail($uid) {
    	
        if (empty($uid)) {
            return 0;
        }		
		
		 $this->db->select($this->_userCompanyMapTable . '.CompanyId ');
		 $this->db->where('UserId', $uid);		 
		 $results = $this->db->get($this->_userCompanyMapTable)->result();
		
		$companyids = array();		
		foreach ($results as $result) {
			$companyids[] = (int)$result -> CompanyId;
		}
		
		$companyidsttt = implode(',', $companyids);	
				
        $this->db->select($this->_companyInfoTable . '.* ');       
        $this->db->where('Status', 1);		
        if(!empty($companyids))
		{
        $this->db->where_not_in('id', $companyids);		
		}			
        $query = $this->db->get($this->_companyInfoTable);
        $data = $query->result();		
		
		return $data ;		
		
    }
	
	
//Get all New task details of particular user	
	 public function getMyNewTaskDetail($uid) {
    	
        if (empty($uid)) {
            return 0;
        }
		
		
		$this->db->select('CompanyId');
        $this->db->where('UserId', $uid);
        $this->db->group_by('CompanyId');       
    
	    $results = $this->db->get($this->_commentTable)->result();		
		$companyids = array();		
		foreach ($results as $result) {
			$companyids[] = (int)$result -> CompanyId;
		}		
		$companyidsttt = implode(',', $companyids);							
        $this->db->select($this->_companyInfoTable . '.* ');       
        $this->db->where('Status', 1);		
        if(!empty($companyids))
		{
        $this->db->where_not_in('id', $companyids);		
		}			
        $query = $this->db->get($this->_companyInfoTable);
        $data = $query->result();				
		return $data ;		
		
    }

    public function getMyNewCommentDetail($uid) 
    {
        if (empty($uid)) 
        {
            return 0;
        }        
        
        $this->db->select('CompanyId');
        $this->db->join('comment_status','comment_status.comment_id = comment.id');
        $this->db->where('comment_status.status',0);
        $this->db->where('comment_status.u_id', $uid);
        $this->db->group_by('CompanyId');           
        $results = $this->db->get($this->_commentTable)->result();      
        
        $companyids = array();      
        foreach ($results as $result) {
            $companyids[] = (int)$result -> CompanyId;
        }

        if(!empty($companyids))
        {
            $this->db->select($this->_companyInfoTable . '.* ');
            $this->db->where_in('id', $companyids);             
            $this->db->where('Status', 1);    
            $query = $this->db->get($this->_companyInfoTable);           
            $data = $query->result();               
            return $data ; 
        }
    }

    // get the last time of new task
	 public function getMyNewTaskLastUpdatedTime($uid) {
    	
        if (empty($uid)) {
            return 0;
        }	
		
		
		$this->db->select('CompanyId');
        $this->db->where('UserId', $uid);
        $this->db->group_by('CompanyId');       
    
	    $results = $this->db->get($this->_commentTable)->result();		
		$companyids = array();		
		foreach ($results as $result) {
			$companyids[] = (int)$result -> CompanyId;
		}		
		
		
		$companyidsttt = implode(',', $companyids);							
        $this->db->select($this->_companyInfoTable . '.LastUpdated ');       
        $this->db->where('Status', 1);				
		if(!empty($companyids))
		{
        $this->db->where_not_in('id', $companyids);		
		}			
		$this->db->order_by('id','desc');
		$this->db->limit(1,0);
        $query = $this->db->get($this->_companyInfoTable);
        $data = $query->row();						
		return $data->LastUpdated ;				
    }
	 
	 
//Get the last time of new order
	     public function getMyNewOrdersUpdatedTime($uid) {
    	
        if (empty($uid)) {
            return 0;
        }		
		
		 $this->db->select($this->_userCompanyMapTable . '.CompanyId ');
		 $this->db->where('UserId', $uid);		 
		 $results = $this->db->get($this->_userCompanyMapTable)->result();
		
		$companyids = array();		
		foreach ($results as $result) {
			$companyids[] = (int)$result -> CompanyId;
		}
		
		$companyidsttt = implode(',', $companyids);	
				
        $this->db->select($this->_companyInfoTable . '.* ');       
        $this->db->where('Status', 1);		
        if(!empty($companyids))
		{
        $this->db->where_not_in('id', $companyids);		
		}
		$this->db->order_by('id','desc');
		$this->db->limit(1,0);		
        $query = $this->db->get($this->_companyInfoTable);
        $data = $query->row();		
		return $data->LastUpdated ;			
		
    }

        public function getTotalInvestments() 
        { 
            $this->db->select('*');
            $this->db->from('companyinfo');           
            $this->db->where('companyinfo.status',1);
            $this->db->where('companyinfo.investment_status',"Approved");            
            $query  = $this->db->get();
            $result =   count($query->result());            
            return $result;

        }
		
        public function getMyNewInvestments()
        {
            $this->db->select('*');
            $this->db->from('companyinfo');           
            $this->db->where('companyinfo.status',1);
            $this->db->where('companyinfo.investment_status',"Approved");            
            $query  = $this->db->get();
            $result =   $query->result();            
            return $result;
        } 
        //Get New Comments Count
        function getNewCommentsCount($uid)
		{		
		 
		$this->db->select('ucmap_id');
        $this->db->where('comment_by !=', $uid);
        //$this->db->group_by('company_id');
        $query = $this->db->get($this->_user_comments_map);
        return $query->num_rows();
	
		}
                
        public function is_logged_in() {
        return $this->session->userdata('user_id') ? $this->session->userdata('user_id') : false;
    }

    /*
     * login 
     * 
     */

    public function _login($loginId, $loginPassword) {
        $loginPassword = md5($loginPassword);
        
        $this->db->select($this->_userTable . '.* ,' . $this->_roleMapTable . '.rid');
        $this->db->join($this->_roleMapTable, $this->_roleMapTable . '.uid = ' . $this->_userTable . '.Id', 'inner');
        $this->db->where(array('Email' => $loginId, 'Password' => $loginPassword, $this->_userTable.'.Status' => 1));
        $query = $this->db->get($this->_userTable);        
        if ($query->num_rows() > 0) {
            $data = $query->row();
            $query->free_result();
            return $data;
        }
        return FALSE;
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

    /*
     * User Profile
     * 
     */

    public function user_profile() {
        //$this->db->where(array('status' => 1));
        if ($this->input->get('search') && $this->input->get('search') != '') {
           $string = $this->input->get('search'); 
            $s = "SELECT *
            FROM companyinfo
            WHERE CompanyName LIKE '%{$string}%' AND Status = '1';";
           $query = $this->db->query($s);
            $row = $query->result();
            return $row;   
           // $this->db->where("(CompanyName LIKE '%{$string}%')");
        }

        // $this->db->select_avg('Rating'); 
        // $this->db->count_all('comment.Comment'); 
//        $this->db->select('companyinfo.*,comment.*');
//       
//       $this->db->join('Comment', 'companyinfo.id = comment.CompanyId','left');
//       $this->db->group_by('companyinfo.id') ;
//       
//       
//       $query = $this->db->get('companyinfo'); 

        $sql = "SELECT companyinfo.*, count(comment.Comment) as commentCount, avg(comment.Rating) as rating
              FROM companyinfo
              LEFT JOIN comment
              ON companyinfo.id = comment.CompanyId
              WHERE companyinfo.Status = 1
              GROUP BY companyinfo.id";
        $query = $this->db->query($sql);
        $row = $query->result();
        return $row;



        //echo "<pre>" ;
//           print_r($row); die;
        //if($query->num_rows()>0){ 
//           $row =$query->result();
//           print_r($row); die;
//           
//           return $row;
//           }else{
//            return FALSE;
//           }
//        
//        
//       return $query->row();
//             
// 
// 
//         $query = $this->db->get('companyinfo');
//         $this->db->last_query();
//         if($query->num_rows()>0){ 
//           $row =$query->result();
//            return $row;
//        }else{
//            return FALSE;
//        }
//        
    }

    public function comment_count() {
        $user_id = $this->session->userdata('user_id');
        if(!empty($user_id))
        {
            $this->db->select('Comment');
            $this->db->from('comment');
            $this->db->join('comment_status','comment_status.comment_id = comment.id');
            $this->db->join('companyinfo','companyinfo.id = comment.CompanyId');
            $this->db->where('comment_status.status',0);
            $this->db->where('companyinfo.Status', 1);   
            $this->db->where('comment_status.u_id',$user_id);
            $query = $this->db->get();
            $total = count($query->result());
            return $total;
        }

        /*$sql = "SELECT count(Comment) as comment_count FROM comment;";
        $query = $this->db->query($sql);
        $row = $query->row();        
        return $row;*/
        
    }

    public function user_detail() {
        $this->db->where(array('status' => 1));
        if ($this->input->get('search') && $this->input->get('search') != '') {
            $string = $this->input->get('search');
            $this->db->where("(FirstName LIKE '%{$string}%')");
        }



        $query = $this->db->get('users');
        $this->db->last_query();
        if ($query->num_rows() > 0) {
            $row = $query->result();
          //   echo "<pre>"; print_r($row); die;
            return $row;
        } else {
            return FALSE;
        }
    }

    // public function user_detail($uid){
//        $this->db->where(array('id'=> $uid)); 
//        $query = $this->db->get('contactinfo');  
//        return $query->row();
//    }

    /*
     * Add user 
     * 
     */

    public function _add_user($fields) {

//        $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|min_legth[4]');
//        $this->form_validation->set_rules('email', 'Email Id', 'required|trim|xss_clean|valid_email');
//        $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
//        $this->form_validation->set_rules('contactno', 'Contact number', 'trim|xss_clean|min_length[10]|max_length[15]|numeric');
//        $this->form_validation->set_rules('device_token', 'Device token', 'trim|xss_clean');
//        	$image = $_FILES['file_name']['name']; 
//            $ext = explode('.', $image);           
//            $config['upload_path'] = './'.PROFILE_IMAGE_PATH; 
//            $config['allowed_types'] = 'gif|jpg|jpeg|png|txt|php|pdf';
//            $config['max_size'] = '40000000000000';
//            $config['max_width'] = '50770';
//            $config['max_height'] = '50770';
//            $config['file_name'] = "img".time().".".$ext[1];
//            $this->load->library('upload');
//            $this->upload->initialize($config);             
        // $image_data = $this->upload->data(); 
//            if (!$this->upload->do_upload('file_name')) {
//                $error = array('error' => $this->upload->display_errors());
//                echo '<div>'.$error['error'].'<div>';
//            }
        //$password = $this->input->post('password');
//            $password = $this->encrypt->sha1($password); 


        /*if ($this->db->insert('users', $fields)) {        	
			$uid = $this->db->insert_id();
			$roleId = 2 ;			
			$this->db->insert('role_map',array('uid'=>$uid,'rid'=>$roleId));			
            return TRUE;
        }*/
    }

    public function get_user_detail($uid) {      
       
        $this->db->select('companyinfo.*,contactinfo.*');
        $this->db->join('contactinfo', 'companyinfo.id = contactinfo.id');
        $this->db->where('companyinfo.id',$uid); 
        $query = $this->db->get('companyinfo');
        return $query->row();
    }

    public function _edit_user($uid, $profileImage) {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|min_legth[4]');
        $this->form_validation->set_rules('email', 'Email Id', 'required|trim|xss_clean|valid_email');
        $this->form_validation->set_rules('contactno', 'Contact number', 'trim|xss_clean|min_length[10]|max_length[15]|numeric');
        $this->form_validation->set_rules('device_token', 'Device token', 'trim|xss_clean');

        if ($this->form_validation->run()) {

            $image = $_FILES['file_name']['name'];
            if (!empty($image)) {

                $ext = explode('.', $image);
                $config['upload_path'] = './' . PROFILE_IMAGE_PATH;
                $config['allowed_types'] = 'gif|jpg|jpeg|png|txt|php|pdf';
                $config['max_size'] = '40000000000000';
                $config['max_width'] = '50770';
                $config['max_height'] = '50770';
                $config['file_name'] = "img" . time() . "." . $ext[1];
                $images = "img" . time() . "." . $ext[1];
                $this->load->library('upload');
                $this->upload->initialize($config);
                // $image_data = $this->upload->data(); 
                if (!$this->upload->do_upload('file_name')) {
                    $error = array('error' => $this->upload->display_errors());
                    echo '<div>' . $error['error'] . '<div>';
                }
            } else {
                $images = $profileImage;
            }

            $fields = array(
                'CompanyName' => $this->input->post('username'),
                'CompanyWebsite' => $this->input->post('email'),
                'CompanyType' => $this->input->post('contactno'),
                'ThemeAlign' => $images,
                'CompanySumm' => $this->input->post('city'),
                'ValueProposition' => $this->input->post('state'),
                'CompanyProgress' => $this->input->post('country'),
                'BicInvestment' => $this->input->post('zip'),
                'DevelopmentPlans' => $this->input->post('address'),
                'CustomerTarget' => $this->input->post('device_token'),
                'BicLead' => $this->input->post('device_token'),
                'LastUpdated' => $this->input->post('device_token'),
                'Source' => $this->input->post('device_token'),
                'status' => 1
            );

            $this->db->where('uid', $uid);
            if ($this->db->update('users', $fields)) {
                return TRUE;
            } else {
                $this->session->set_flashdata('error', 'database error !');
                redirect('admin/user/user/view');
            }
        }
        return FALSE;
    }

    /*
     * count all users (Users)
     * 
     */

    public function total_user_count() {
        $this->db->where(array('status' => 1));
        $users_count = $this->db->from('users')->count_all_results();

        return $users_count;
    }

    public function get_all_user() {
        $this->db->where('Status', 1);
        $query = $this->db->get('users');
        $this->db->last_query();
        if ($query->num_rows() > 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
    }
    
    public function setCompanyViewed($uid, $companyId){
        $query = $this->db->get_where($this->_userCompanyMapTable, array('UserId' => $uid, 'CompanyId' => $companyId));
        if($query->num_rows() > 0) {
            // Already set
            return true;
        }
        else {
            // set
            $data['UserId'] = $uid;
            $data['CompanyId'] = $companyId;
            $res = $this->db->insert($this->_userCompanyMapTable, $data);
            if($res) {
                return true;
            }
            else {
                return false;
            }
        }
    }
	
	
	function user_data($uid){		
		$userrow = $this->db->select('u.*,rmap.rid as roleId')		
			->where(array('u.Id'=>$uid,'u.Status'=>1))	
			 ->join('role_map as rmap', 'rmap.uid = u.Id')
			->get('users as u')
			->row();			
		return $userrow; 				
	}
	
	function checkCommentReadStaus($last_comment_id,$cmpny_id)
    {
        $user_id    = $this->session->userdata('user_id');    
        if(!empty($last_comment_id) && !empty($user_id) && !empty($cmpny_id))
        {
            $names = array($user_id);
            $this->db->select('Id')->from('users')->where_not_in('id',$names);
            $query = $this->db->get();                       
            $totalUsers = $query->result();
            if(!empty($totalUsers))                                        
            {
                foreach ($totalUsers as $row) 
                {   
                    $commentArray = array(
                                    'comment_id'        =>  $last_comment_id,
                                    'comapny_id'        =>  $cmpny_id,
                                    'u_id'              =>  $row->Id,
                                    'status'            =>  0
                        );          
                        $this->db->insert('comment_status',$commentArray);     
                }
            }
        }        
    }

    function getTotalCommentsOnComapny($company_id)
    {
        if(!empty($company_id))
        {
            $this->db->select('count(Comment) as total,avg(comment.Rating) as total_rating');
            $this->db->from('comment');
            $this->db->where('CompanyId',$company_id);           
            $query  =   $this->db->get();                     
            $result =   $query->row();            
            return $result;            
        }
    }

    function getRecentCommentTime()
    {
        $user_id = $this->session->userdata('user_id');
        if(!empty($user_id))
        {
            $this->db->select('DateTime');
            $this->db->from('comment');            
            $this->db->join('companyinfo','companyinfo.id = comment.CompanyId');
            $this->db->join('comment_status','comment_status.comment_id = comment.id');            
            $this->db->where('companyinfo.Status', 1);   
            $this->db->where_not_in('comment.UserId',$user_id);
            $this->db->order_by('DateTime','DESC');
            $this->db->limit(1);
            $query = $this->db->get();
            $total = $query->row();
            return $total->DateTime;
        }
    }

       
    public function get_country_list()
    {
        $this->db->select('country_id,name');
        $this->db->from('country');            
        $this->db->where('status', 1);   
        $this->db->order_by('name','asc');
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }
    
    public function get_country_by_id($countryId)
    {
        $this->db->select('*');
        $this->db->from('country');            
        $this->db->where(array('country_id'=>$countryId,'status'=>1));   
        $query = $this->db->get();
        $data = $query->row();
        return $data;
    }

}
