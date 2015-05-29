<?php
ini_set("display_errors", 1);
error_reporting(0);
require_once("Rest.inc.php");

class API extends REST {

    public $data = "";
    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB = "partneralliance";

    private $db = NULL;

    public function __construct() {
        parent::__construct();    // Init parent contructor
        $this->dbConnect();     // Initiate Database connection
    }

    /*
     *  Database connection 
    */

    private function dbConnect(){
        $this->db = mysqli_connect(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
    }

    /*
     * Public method for access api.
     * This method dynmically call the method based on the query string
     *
     */

    public function processApi() {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'])));
        if ((int) method_exists($this, $func) > 0) {
            $this->$func();
        } else {
            $this->response('', 404);
        }    // If the method not exist with in this class, response would be "Page not found".
    }
    
    public function generate_random_password($length = 10) 
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
    
    public function register()
    {
        if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 200);
        }
        
        $CompanyName       = $this->_request['company_name'];
        $CompanyWebsite    = $this->_request['company_website'];
        $CompanySumm       = $this->_request['company_summary'];
        $investment_status = "Not Available"; 
        $created           = date('Y-m-d H:i:s');
        $Status            = 1;
        $first_name        = $this->_request['first_name'];
        $last_name         = $this->_request['last_name'];
        $email             = $this->_request['email'];
        $password          = md5($this->generate_random_password(10));   
        $title             = $this->_request['title'];
        $address           = $this->_request['contact_address'];
        $phone             = $this->_request['contact_phone'];
        $role_id           = 4;
        $active_status     = 1;    
        $created_date      = date('Y-m-d H:i:s');
        
        if(!empty($CompanyName) && !empty($CompanyWebsite) && !empty($first_name) && !empty($email))
        {
            if(!empty($email))
            {    
                $sqlCheckEmail = 'SELECT id FROM users WHERE email = "' . $email . '" ';                  
                $queryCheckEmail = mysqli_query($this->db, $sqlCheckEmail);               
                if (mysqli_num_rows($queryCheckEmail)>0) 
                {                   
                    $error = ['status' => 'Failed', 'msg' => 'Email already exist'];
                    $this->response($this->json($error),200);
                }
                else 
                {
                    $sqlCompanyInsert = "INSERT INTO companyinfo (`CompanyName`,`CompanyWebsite`,`CompanySumm`,`investment_status`,`LastUpdated`,`Status`)
                        values('" . $CompanyName . "','" . $CompanyWebsite . "','" . $CompanySumm . "','". $investment_status. "', '" . $created . "', '".$Status."')";
                        $rsInsert = mysqli_query($this->db, $sqlCompanyInsert);
                        $last_company_id = mysqli_insert_id($this->db);                         
                        if(!empty($last_company_id))
                        {
                           
                            $sqlUserInsert = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `role_id`, `title`, `address`, `phone`, `created_date`, `status`) 
                                                           VALUES ('". $first_name ."','". $last_name ."','". $email ."','". $password ."','". $role_id. "','" . $title ."','". $address. "','". $phone. "','". $created_date. "','". $active_status. "')";
                            $rsInsert = mysqli_query($this->db, $sqlUserInsert);
                            $last_user_id = mysqli_insert_id($this->db);         
                            if($last_user_id)
                            {
                               
                                $company_id    = $last_company_id;
                                $user_id       = $last_user_id;
                                $created_date1 = date('Y-m-d H:i:s');
                                
                                $sqlCompanyUserInsert = "INSERT INTO `company_users`(`company_id`, `user_id`, `created_date`) VALUES ('" . $company_id . "','" . $user_id . "','".$created_date1 ."')";   
                                $rsInsert = mysqli_query($this->db, $sqlCompanyUserInsert);                                    
                                $result = ['status' => 'Success','msg' => "Information has been saved successfully."];     
                                $this->response($this->json($result), 200);                               
                            }
                        }
                }
            }
        }
        else
        {
            $error = array('status' => "Failed", "msg" => "Empty Parameter");
            $this->response($this->json($error), 400);
        }
        
    }
    
    public function companylist()
    {
        if ($this->get_request_method() != "GET") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 200);
        }        
        $sqlCompanyInfo     = 'SELECT * FROM companyinfo WHERE Status = 1 ';                  
        $queryCompanyInfo   =  mysqli_query($this->db, $sqlCompanyInfo);  
        if (mysqli_num_rows($queryCompanyInfo)) {
                while ($result = mysqli_fetch_object($queryCompanyInfo)) {
                    $data[] = $result;
                }
                $response['status'] = "Success";
                $response['companyInfo'] = $data;                 
                $this->response($this->json($response), 200);

            } else {
                $response['status'] = "Failed";
                $response['msg'] = "Empty Data";
                $this->response($this->json($response), 400);
            }
    }
    
    public function getCompanyInfoById()
    {
      
        if ($this->get_request_method() != "GET") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 200);
        }   
        
        $company_id = $this->_request['company_id']; 
        
        if(!empty($company_id) && is_numeric($company_id))
        {
            $sqlCompanyInfoById     = 'SELECT * FROM companyinfo WHERE id = "'. $company_id .'" and Status = 1 ';                  
            $queryCompanyInfo   =  mysqli_query($this->db, $sqlCompanyInfoById);  
            if (mysqli_num_rows($queryCompanyInfo)) {
                    while ($result = mysqli_fetch_object($queryCompanyInfo)) {
                        $data[] = $result;
                    }
                    $response['status'] = "Success";
                    $response['companyInfo'] = $data;                 
                    $this->response($this->json($response), 200);

                } else {
                    $response['status'] = "Failed";
                    $response['msg'] = "Empty Data";
                    $this->response($this->json($response), 400);
                }
            }
    }
    
    public function editCompanyDetail()
    {       
        if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 200);
        } 
        
        $company_id = $this->_request['company_id'];
        
        $CompanyName       = $this->_request['CompanyName'];       
        $CompanyRating     = $this->_request['CompanyRating'];       
        $CompanyWebsite    = $this->_request['CompanyWebsite'];
        $ThemeAlign        = $this->_request['ThemeAlign'];
        $Source            = $this->_request['Source'];
        $BicLead           = $this->_request['BicLead'];
        $BicInvestment     = $this->_request['BicInvestment'];
        $InvestmentUSD 	   = $this->_request['InvestmentUSD']; 
        $InvestmentType	   = $this->_request['InvestmentType']; 
        $EquityPosition    = $this->_request['EquityPosition'];
        $CloseDate	   = $this->_request['CloseDate'];                          
        $CompanyType       = $this->_request['CompanyType'];
        $FinancingStatus   = $this->_request['FinancingStatus'];
        $valuation         = $this->_request['valuation'];
        $LastUpdated       = date('Y-m-d H:i:s');   
       
        
        if($BicInvestment == "no") 
        {
            $InvestmentUSD      = ''; 
            $InvestmentType 	= ''; 
            $EquityPosition 	= ''; 
            $CloseDate 		= '';
        }
        else
        {
            $InvestmentUSD 		=	$InvestmentUSD; 
            $InvestmentType		=	$InvestmentType	; 
            $EquityPosition		=	$EquityPosition	;
            $CloseDate                  =	$CloseDate;      
        }

        if($CompanyType == "public")
        {
            $FinancingStatus	=	'';
            $valuation		=	'';
        }
        else
        {	
            $FinancingStatus	=	$FinancingStatus;
            $valuation		=	$valuation;
        }    
       
        if(!empty($CompanyName) && !empty($CompanyWebsite) && !empty($company_id))
        {
            $sqlUpdateCompany = "UPDATE `companyinfo` SET   `CompanyName` = '". $CompanyName ."', `CompanyWebsite`    = '". $CompanyWebsite ."', `CompanyRating`     = '". $CompanyRating ."',`CompanyType`       = '". $CompanyType ."',`FinancingStatus`   = '". $FinancingStatus ."',
                                                            `valuation`         = '". $valuation ."', `ThemeAlign`        = '".$ThemeAlign ."', `BicInvestment`= '". $BicInvestment ."', `InvestmentUSD`= '". $InvestmentUSD ."', `InvestmentType`= '". $InvestmentType ."', `EquityPosition`= '". $EquityPosition ."',
                                                            `CloseDate`= '". $CloseDate ."', `Source`= '". $Source ."',  `BicLead`= '". $BicLead ."',  `LastUpdated`= '". $LastUpdated ."' 
                                                            where id = '". $company_id ."' ";
       
            $queryCompanyInfo   =  mysqli_query($this->db, $sqlUpdateCompany);              
            $response = ['status' => 'Success','msg' => "Information has been saved successfully"]; 
            $this->response($this->json($response), 202);
        } 
        else 
        {
                $response['status'] = "Failed";
                $response['msg'] = "Empty Data";
                $this->response($this->json($response), 400);
        }
        
    } 
        
    

    /*
     *  Encode array into JSON
    */

    private function json($data) {
        if (is_array($data)) {
            return json_encode($data);
        }
    }
   
}
//class end	
// Initiiate Library

$api = new API;
$api->processApi();
