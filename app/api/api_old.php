<?php
ini_set("display_errors", 1);
// Turn off all error reporting
error_reporting(0);
require_once("Rest.inc.php");
require_once 'PHPMailer/PHPMailerAutoload.php';
//require 'PHPMailer/PHPMailerAutoload.php';
class API extends REST {

    public $data = "";
    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB = "mycityonmap";

    private $db = NULL;

    public function __construct() {
        parent::__construct();    // Init parent contructor
        $this->dbConnect();     // Initiate Database connection
        
        
        header('content-type: application/json; charset=utf-8');
        
        
        // Tables Deatils
        $this->_userTable = 'user'; 
        $this->_categoryTable = 'category'; 
        $this->_serviceTable = 'services';
        $this->_locationTable = 'location_info';
        $this->_workingHoursTable = 'working_hours'; 
        $this->_deviceTable = 'device';  
        $this->_staffTable = 'staff'; 
        $this->_businessTable = 'business_type'; 
        $this->_businessDetailsTable = 'business_details'; 
        $this->_locationInfoTable = 'location_info';  
        $this->_staffServiceMapTable = 'staff_service_map';
        $this->_workingHoursTable = 'working_hours';
        $this->_offDaysTable = 'off_days';  
    }

    /*
     *  Database connection 
     */

    private function dbConnect() {
        $this->db = mysqli_connect(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
        //if($this->db)
        //mysql_select_db(self::DB,$this->db);
    }

    /*
     * Public method for access api.
     * This method dynmically call the method based on the query string
     *
     */

    public function processApi() {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'])));
        if ((int) method_exists($this, $func) > 0)
            $this->$func();
        else
            $this->response('', 404);    // If the method not exist with in this class, response would be "Page not found".
    }


    /*
     *     Encode array into JSON
    */

    private function json($data) {
        if (is_array($data)) {
            return json_encode($data);
        }
    }
    
    
    /*     * * registration** 
        Url -> http://183.182.84.197/mycityonmap/api/user_registration 
    */
    
    private function user_registration() {

        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status

        if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 406);
        } 
        
        // Basic Parameter
        $name = $this->_request['inputName'];
        $email = $this->_request['inputEmail'];
        $password = $this->_request['inputPassword'];
        $mobile = $this->_request['inputMobile'];
        $role = 5;   
        $status = 0; 
        $created = time();
        
        // For Push Notification 
        //$deviceToken = $this->_request['inputDeviceToken'];
        //$deviceKey = $this->_request['inputDeviceKey'];
                      
        //$verifyCode = rand(1000, 9999);     
        
        //For Testing
        $verifyCode = 1234;
        $status = 1;

        /* 
        $status = 0;
        $created = time();
        $last_login = time();
        $mobile = "34$verifyCode";
        $name = 'Fatima';
        $email = "test5435345dd2rr3$verifyCode@gmail.com";
        $password = '12345';
        $role = '5';
        $deviceToken =  'd8e789190ecf1dd5119dc21f71c8520925fd873912c367c956c36184b167facb';
        $deviceKey = 1;   */
           

        
        if (!(empty($mobile)) && !(empty($email)) && !(empty($password))) {

            $emailFlag = true;
            $mobileFlag = true; 
            
            if($email != ''){     
                $sqlCheckEmail = 'SELECT user_id FROM '.$this->_userTable.' WHERE u_email = "' . $email . '" ';
                $queryCheckEmail = mysqli_query($this->db, $sqlCheckEmail);
                if (mysqli_num_rows($queryCheckEmail)>0) {
                   $emailFlag = false;
                }
            } 
            
            if($mobile != ''){ 
                $sqlCheckMobile = 'SELECT user_id FROM '.$this->_userTable.' WHERE u_mobile = "' . $mobile . '" ';
                $queryCheckMobile = mysqli_query($this->db, $sqlCheckMobile);
                if (mysqli_num_rows($queryCheckMobile)>0) {
                    $mobileFlag = false;
                } 
            } 
            
            if ( !$emailFlag ) {
                $error = array('status' => 'Failed', 'msg' => 'Email already exist!');
                $this->response($this->json($error), 400);
            }
            
            else if ( !$mobileFlag ) {
                $error = array('status' => 'Failed', 'msg' => 'Mobile already exist!');
                $this->response($this->json($error), 400);
            } 
            
            else {
                       
                        $password1 = sha1($password);
                        $sqlInsert = "insert into ".$this->_userTable." (`u_email`,`u_password`,`u_fname`,`u_mobile`,`u_role`, `u_created`,`u_lastlogin`, `u_status`)
                         values('" . $email . "','" . $password1 . "','" . $name . "', '" . $mobile . "', '" . $role . "', '" . $created . "', '".$last_login."', '" . $status . "')";
                        $rsInsert = mysqli_query($this->db, $sqlInsert);
                        $insertUserID = mysqli_insert_id($this->db);   

               
                
                
                if ($insertUserID) {

                    $verifyCodeValue = $verifyCode; 
                    
                   /*  
                   if($deviceKey == 1)  
                          $this->send_android_push_notification( $deviceKey, $name, $verifyCodeValue);
                   elseif($deviceKey == 2)
                          $this->send_ios_push_notification( $deviceKey, $name, $verifyCodeValue); */
                        
                    
                   /*  
                   // For Push Notification      
                    $sqlInsertDevice = "insert into ".$this->_deviceTable." (`dv_u_id`,`dv_verification_code`,`dv_device_token`,`dv_device_key`)
                                        values('" . $insertUserID . "','" . $verifyCodeValue . "','" . $deviceToken . "', '" . $deviceKey . "')";                
                    $rsInsert = mysqli_query($this->db, $sqlInsertDevice);         
                  */  
                    
                    
                    $result = array('status' => 'Success','userId' => $insertUserID);     
                    $this->response($this->json($result), 200);
                } else {
                   $error = array('status' => "Failed", "msg" => "User not register");
                   $this->response($this->json($error), 400);
                }
              }   
               
            }
        else {
            // If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Empty Parameter");
			$this->response($this->json($error), 400);
        }
    }
    
    
       /*     * * registration** 
        Url -> http://183.182.84.197/mycityonmap/api/user_registration 
    */
    
    private function user_social_media() {

        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status

        if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 406);
        } 
        
        // Basic Parameter
        $name = $this->_request['inputName'];
        $email = $this->_request['inputEmail'];
        $mobile = $this->_request['inputMobile'];
        $role = 5;   
        $status = 0; 
        $created = time();

        // For Social Site

        $socialKey = $this->_request['inputSocialKey'];    // For facebook is 1 and Twitter is 2 
        $socialIdentity = $this->_request['inputSocialIdentity'];    

        
        //$verifyCode = rand(1000, 9999);     
        
        //For Testing
        $verifyCode = 1234;
        $status = 1;

        /* 
        $status = 0;
        $created = time();
        $last_login = time();
        $mobile = "34$verifyCode";
        $name = 'Fatima';
        $email = "test5435345dd2rr3$verifyCode@gmail.com";
        $password = '12345';
        $role = '5';
        $deviceToken =  'd8e789190ecf1dd5119dc21f71c8520925fd873912c367c956c36184b167facb';
        $deviceKey = 1;   */
           

        
        if (!(empty($mobile)) && !(empty($email)) && !(empty($socialIdentity)) && !(empty($socialKey))) {
                    
                  
                   if($socialKey == 1){
                             $socialUserKey  =  "`u_fb_username`";
                             $socialUserValue  =  "$socialIdentity" ;
                   }
                   elseif($socialKey == 2){
                             $socialUserKey  =  "`u_tw_username`";
                             $socialUserValue  =  "$socialIdentity" ; 
                   }
                  
                  $sqlCheckUsername = "SELECT user_id FROM $this->_userTable WHERE $socialUserKey = '$socialIdentity'";        
                  $queryCheckSocial = mysqli_query($this->db, $sqlCheckUsername);
           
                  if (mysqli_num_rows($queryCheckSocial)>0) {
                      
                      
                          $sqlCheckUsername = "SELECT user_id FROM $this->_userTable WHERE $socialUserKey = '$socialIdentity' and `u_status` = 1";        
                          $queryCheckSocial = mysqli_query($this->db, $sqlCheckUsername);
                          if (mysqli_num_rows($queryCheckSocial)>0) {
                                   $userId = mysqli_fetch_object($queryCheckSocial); 
                                   $response['status'] = "Success";
                                   $response['msg'] = "username all ready exits";
                                   $response['userId'] = $userId->user_id;             
                                   $this->response($this->json($response), 200);
                          }
                         else{
                                   // account not verify
                                  $error = array('status' => "Failed", "msg" => "Please verify the Account");
                                  $this->response($this->json($error), 400);  
                         }
           
                  }
                  else{
              
                    if($email != ''){     
                        $sqlCheckEmail = 'SELECT user_id FROM '.$this->_userTable.' WHERE u_email = "' . $email . '" ';
                        $queryCheckEmail = mysqli_query($this->db, $sqlCheckEmail);
                        if (mysqli_num_rows($queryCheckEmail)>0) {
                            $userData = mysqli_fetch_object($queryCheckEmail);
                                
                            //Update User Table
                            $sqlUpdate = "update ".$this->_userTable." set $socialUserKey = '" . $socialUserValue . "' where user_id ='" . $userData->user_id . "'"; 
                            $updateUsername = mysqli_query($this->db, $sqlUpdate);
                            
                            $response['status'] = "Success";
                            $response['msg'] = "email all ready exits";
                            $response['userId'] = $userData->user_id;             
                            $this->response($this->json($response), 200);
             
                        }
                      else{
    
                          //Verification code Send to here
                          
                          
                          
                        $sqlInsert = "insert into ".$this->_userTable." (`u_email`,`u_fname`,`u_mobile`,`u_role`, `u_created`,`u_lastlogin`, `u_status`, ".$socialUserKey.")
                        values('" . $email . "','" . $name . "', '" . $mobile . "', '" . $role . "', '" . $created . "', '".$last_login."', '" . $status . "', '$socialUserValue')";
                        $rsInsert = mysqli_query($this->db, $sqlInsert);
                        $insertUserID = mysqli_insert_id($this->db);
                        
                        $result = array('status' => 'Success','userId' => $insertUserID);     
                        $this->response($this->json($result), 200);
                        
                    } 
                          
                          
                      }  
                        
                        
                        
                    } 
                 
                  } 
        else {
            // If invalid inputs "Bad Request" status message and reason
            $error = array('status' => "Failed", "msg" => "Empty Parameter");
            $this->response($this->json($error), 400);
        }
    } 
    
    
    
    

    /*   * * verification Function** 
         Url -> http://183.182.84.197/mycityonmap/api/user_verification 
    */
    
     private function user_verification() {
        
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
       
       if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 406);
        }   
        
        $status = 1;
        $verify = $this->_request['inputVerificationCode'];   
          
       
         /*
           $status = 1; 
           $verify = '372553';  
         */  

        if (!(empty($verify))) {

            $sqlCategory = "select dv_u_id from ".$this->_deviceTable." where dv_verification_code = '" . $verify ."'" ;
            $query = mysqli_query($this->db, $sqlCategory);
                 
            if (mysqli_num_rows($query)) {
                
                $result = mysqli_fetch_object($query);
                
                //Update User Table
                $sqlkey = "update ".$this->_userTable." set `u_status` = '" . $status . "' where user_id ='" . $result->dv_u_id . "'";
                $updatekey = mysqli_query($this->db, $sqlkey);
                
                //Update Device Table Table
                $sqlkey = "update ".$this->_deviceTable." set `dv_verification_code` = '' where dv_u_id ='" . $result->dv_u_id . "'";
                $updatekey = mysqli_query($this->db, $sqlkey);
                
                $response['status'] = "Success";
                $response['msg'] = "valid Code!!.. Now you are free for login";               
                $this->response($this->json($response), 200);

            } else {
                $response['status'] = "Failed";
                $response['msg'] = "invalid Code";
                $this->response($this->json($response), 400);
            }
        } else {
            $response['status'] = "Failed";  
            $response['msg'] = "Empty Parameter";
            $this->response($this->json($response), 400);
        }
    }

    
    
    
    /*   * * Send Push Notification For  Iphone** 
         Url -> http://183.182.84.197/mycityonmap/api/send_ios_push_notification 
    */
     function send_ios_push_notification( $deviceToken, $senderName, $verificationCode){ 

                     $message = '';
                    // My device token here (without spaces):
                    $deviceToken = $deviceToken;   
     
                    // My private key's passphrase here:
                     $passphrase = 'lms123';

                     $deviceToken = 'd8e789190ecf1dd5119dc21f71c8520925fd873912c367c956c36184b167facb'; 
                     $passphrase = 'lms123';   
                    
                    // My alert message here:
                    $message .= 'Hello '.$senderName;
                    $message .= 'New Push Notification Code : '.$verificationCode;

                    //badge
                    $badge = 1;
                    
                                            // Put your alert message here:
                    $message = 'New Push Notification Code';

                    ////////////////////////////////////////////////////////////////////////////////

                    $ctx = stream_context_create();
                    stream_context_set_option($ctx, 'ssl', 'local_cert', 'pemfile/mcomcertDev.pem');
                    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

                    // Open a connection to the APNS server
                    $fp = stream_socket_client(
                        'ssl://gateway.sandbox.push.apple.com:2195', $err,
                        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

                    if (!$fp)
                        exit("Failed to connect: $err $errstr" . PHP_EOL);


                   /* $ctx = stream_context_create();
                    stream_context_set_option($ctx, 'ssl', 'local_cert', 'pemfile/mcomcertDev.pem');
                    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

                    // Open a connection to the APNS server
                    $fp = stream_socket_client(
                        'ssl://gateway.sandbox.push.apple.com:2195', $err,
                        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); */

                    if (!$fp)
                      exit("Failed to connect: $err $errstr" . PHP_EOL);

                    //echo 'Connected to APNS' . PHP_EOL;

                    // Create the payload body
                    $body['aps'] = array(
                        'alert' => $message,
                        'badge' => $badge,
                        'sound' => 'newMessage.wav'
                    );

                    // Encode the payload as JSON
                    $payload = json_encode($body);

                    // Build the binary notification
                    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

                    // Send it to the server
                    $result = fwrite($fp, $msg, strlen($msg));
                      
                    if (!$result)
                        $result = 'Error, notification not sent' . PHP_EOL;
                    else
                        $result = 'notification sent!' . PHP_EOL;

                        
                        
                    // Close the connection to the server
                    fclose($fp);  
                      return $result;       
       }
    
   
   /*   * * Send Push Notification For  Android** 
         Url -> http://183.182.84.197/mycityonmap/api/send_android_push_notification 
    */    
    public function send_android_push_notification($deviceToken, $senderName, $verificationCode){         
                 
            // API access key from Google API's Console
            //define( 'API_ACCESS_KEY', 'YOUR-API-ACCESS-KEY-GOES-HERE' ); 
             
             define( 'API_ACCESS_KEY', 'AIzaSyBIJZh5QImrXcR_3hItok4QLq8mPrpR_Xg');           
             
             
            $msg = 'Hello '.$senderName; 
            $msg .= 'Verification Code :  '.$verificationCode;   
                 
            $fields = array
            (
            'registration_ids' => $deviceToken,
            'data'    => $msg
            );
             
            $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
            $result = curl_exec($ch );
            curl_close( $ch );
            return json_encode($fields);
            //echo $result;  
                   
        }
    
    
    
    
    /*     * * Login** 
        Url -> http://183.182.84.197/mycityonmap/api/user_login 
    */
    
    private function user_login() {
        
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
       if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 406);
        }  
        
       
        $identity = $this->_request['inputIdentity'];
        $password = $this->_request['inputPassword'];     
          
         
       /* $identity = 'test5435345dd2rr31486@gmail.com';
        $password = '12345'; */ 
       
        
        $pass = sha1($password); 
         
        if (!(empty($identity)) && !(empty($password))) {
            
            $sqlLogin = "select user_id, u_email, u_fname as name, u_mobile, u_status  from  ".$this->_userTable." where ( u_email='$identity' OR u_mobile = '$identity') and u_password='" . $pass . "'";
            $query = mysqli_query($this->db, $sqlLogin);

            if (mysqli_num_rows($query)) {
                
                $data = mysqli_fetch_object($query);  
                if ($data->u_status == 1) { 

                    $last_login = time();
                    $sqlkey = "update ".$this->_userTable." set `u_lastlogin` = '" . $last_login . "' where u_email='" . $data->u_email . "'";
                    $updatekey = mysqli_query($this->db, $sqlkey);

                    

                    $response = array();
                    $response['status'] = "Success";
                    $response['userId'] = $data->user_id;
                    $response['identity'] = $identity;
                   
                    $this->response($this->json($response), 200);
                }    
               else{
                $response['status'] = "Failed";
                $response['msg'] = "Please verify your registration";
                $this->response($this->json($response), 400);   
               }     
                
            } else {
                
                $response['status'] = "Failed";
                $response['msg'] = "invalid user";
                $this->response($this->json($response), 400);
                
            }
            
        } else {
            $response['status'] = "Failed";
            $response['msg'] = "Empty Parameter";
            $this->response($this->json($response), 400);
        }
    }
    
    
    /*     * * Forget Password** 
        Url -> http://183.182.84.197/mycityonmap/api/user_forget_password 
    */
    
    private function user_forget_password() {
        
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
      
        if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 406);
        }  

        $email = $this->_request['inputEmail'];
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, 6 );   
        
          
       /*  
        $email = 'test5435345dd2rr32572@gmail.com';
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, 6 ); 
       */

        if (!(empty($email))) {

            $sqlLogin = "select u_email, u_fname from  ".$this->_userTable." where u_email = '$email'";
            $query = mysqli_query($this->db, $sqlLogin);

            if (mysqli_num_rows($query)) {
                $data = mysqli_fetch_object($query);  
                
                
                //sending mail
                // Mail
                
                $ini_array = parse_ini_file("phpmailer/email_config.ini");
                //$isUserFound['mailerror'] = $ini_array['username'].' -'.$email;
                //require 'phpmailer/PHPMailerAutoload.php';
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $ini_array['username'];
                $mail->Password = $ini_array['password'];
                $mail->SMTPSecure = 'tls';
                $mail->From = $ini_array['username'];
                $mail->FromName = 'My City on Map';
                $nameEmail = $data->u_fname ;
                $mail->addAddress($data->u_email, $nameEmail);
                $mail->addReplyTo($ini_array['username'], 'BIC KMBS');
                $mail->WordWrap = 50;
                $mail->isHTML(true);
                $mail->Subject = 'Forget Password';
                $mail->Body = 'Hi ' . $nameEmail . ', <br> Changing your password is simple. Please use the link below to change password.<br>New Password : ' . $password ;
                $mailSattus = $mail->send();
                
                if($mailSattus){

                    
                $pass = sha1($password);   
                
                $last_login = time();
                $sqlkey = "update ".$this->_userTable." set `u_password` = '" . $pass . "' where u_email='" . $email . "'";
                $updatekey = mysqli_query($this->db, $sqlkey);

                $response = array();
                
                $response['status'] = "Success";
                $response['msg'] = "Please check your email for password";
                $response['identity'] = $email;
                $this->response($this->json($response), 200);
                }
                else{
                 
                $response['status'] = "Failed";
                $response['msg'] = "Please try again";
                $this->response($this->json($response), 400);
                    
                }  
            } else {
                
                $response['status'] = "Failed";
                $response['msg'] = "invalid identity";
                $this->response($this->json($response), 400);
                
            }
        } else {
            $response['status'] = "Failed";  
            $response['msg'] = "Empty Parameter";
            $this->response($this->json($response), 400);
        }
    }
       
   /*
   * Get Category and its all Services  
   * Url -> http://183.182.84.197/mycityonmap/api/categoryWithAllServices  
   */ 
    
   Public function category_with_all_services(){
        
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
    
       if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 406);
        }   
        
        $bussinessId = $this->_request['id'];   
        //$bussinessId = 1;   
        //$bussinessId = '8';

        if (!(empty($bussinessId))) {
            
            $dataCategoryArray = array();
            $dataServicesArray = array();
            
             
            $sqlCategory = "select * from ".$this->_categoryTable." where cat_u_id = " . $bussinessId ;
            $query = mysqli_query($this->db, $sqlCategory);
                 
            if (mysqli_num_rows($query)) {
                                
                $refs = '';
                $list = '';

                while($data = mysqli_fetch_assoc($query)) {
                    $thisref = &$refs[ $data['cat_id'] ];
            
                    $thisref['cat_id'] = $data['cat_id'];
                    $thisref['cat_name'] = $data['cat_name'];
                    //$thisref['details'] = $data;
                    
                    
                    $sqlServices = "select sr_name,sr_id,sr_duration,sr_cleanup,sr_price,sr_price_type from ".$this->_serviceTable." where sr_cat_id = " . $data['cat_id'] ;      
                    $queryService = mysqli_query($this->db, $sqlServices);
                         
                    if (mysqli_num_rows($queryService)) {
                        while ( $dataService = mysqli_fetch_assoc($queryService) ){
                                $dataServicesArray[] = $dataService; 
                      }
                    }   
                                          
                    $thisref['services'] = $dataServicesArray; 
                    
                    if ($data['cat_parent_id'] == 0) {
                    
                        $list[] = &$thisref;
                        
                    } else {
                        $refs[ $data['cat_parent_id'] ]['sub_category'][] = &$thisref;
                    }
                }   

                $response['status'] = "Success";  
                $response['response'] = $list;   
                $this->response($this->json($response), 200);

            } else {
                
                $response['status'] = "Failed";
                $response['msg'] = "Empty Parameter";
                $this->response($this->json($response), 400);
                
            }
        } else {
            $response['status'] = "Failed"; 
            $response['msg'] = "Empty Parameter";
            $this->response($this->json($response), 400);
        }
    }  
 
 
   /*
   * Get Sub Category   
   * Url -> http://183.182.84.197/mycityonmap/api/service/display_child_nodes  
   */ 
  
  function display_child_nodes($parent_id, $level, $data, $index) {
                 
            static $output;
            
            $parent_id = $parent_id == 0 ? "0" : $parent_id;
            
            if (isset($index[$parent_id])) {     
               
                foreach ($index[$parent_id] as $id) {          

 
                            $output1[] =   $data[$id];

                    $this->display_child_nodes($id, $level + 1, $data, $index);
                }
            }
            
            return $output;
    } 

  
  
  /*
   * Get Staff
   *  Url -> http://183.182.84.197/mycityonmap/api/get_business 
   */

   Public function get_business(){
       
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
        
        if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 406);
        }   

            $sqlBusiness = "select bty_id, bty_name from $this->_businessTable where bty_status = 1" ;
            $queryBusiness = mysqli_query($this->db, $sqlBusiness);
                 
            if (mysqli_num_rows($queryBusiness)) {
                while ( $result = mysqli_fetch_object($queryBusiness) ){
                    $data[] = $result;
                }
                $response['status'] = "Success";
                $response['businessType'] = $data; 
                
                $this->response($this->json($response), 200);

            } else {
                $response['status'] = "Failed";
                $response['msg'] = "Empty Data";
                $this->response($this->json($response), 400);
            }

    }
  
  /*
   * Get Branches  
   *  Url -> http://183.182.84.197/mycityonmap/api/location 
   */

   Public function get_branches(){
       
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
        
        if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 406);
        }   
        
        
        $searchBusinessId = $this->_request['id']; 
        $searchString = $this->_request['inputSearchString'];

        if (!(empty($searchBusinessId))){


            //Get All Off Days of branches  
               $sqlServicesIds = "select $this->_serviceTable.sr_id from $this->_serviceTable where sr_name LIKE '%$searchString%'";
              $queryServicesIds = mysqli_query($this->db, $sqlServicesIds);
              if (mysqli_num_rows($queryServicesIds)) {
                       while ( $ids = mysqli_fetch_array($queryServicesIds) ){
                                 $resultServiceIds[] = $ids['sr_id'];
                    }       
                    
                  $newarrayServices = '';  
                  if(is_array($resultServiceIds)) 
                     $newarrayServices = implode(", ", $resultServiceIds);  

                           
                    $sqlStaffIds = "select $this->_staffServiceMapTable.stsr_st_id from $this->_staffServiceMapTable where $this->_staffServiceMapTable.stsr_sr_id IN($newarrayServices) group by 
                  $this->_staffServiceMapTable.stsr_st_id order by $this->_staffServiceMapTable.stsr_st_id";
                  
                  $queryStaffIds = mysqli_query($this->db, $sqlStaffIds);
                      if (mysqli_num_rows($queryStaffIds)) {
                           while ( $sIds = mysqli_fetch_array($queryStaffIds) ){
                                     $staffIds[] = $sIds['stsr_st_id'];
                        } 
                      } 
                  
                $newarraySatffs = '';  
                  if(is_array($staffIds)) 
                     $newarraySatffs = implode(", ", $staffIds);  
               
               
                   $sqlLocationIds = "select $this->_staffTable.st_lo_id from $this->_staffTable where $this->_staffTable.st_u_id IN($newarraySatffs) group by 
                  $this->_staffTable.st_lo_id order by $this->_staffTable.st_lo_id";
                  
                  $queryLocationIds = mysqli_query($this->db, $sqlLocationIds);
                      if (mysqli_num_rows($queryLocationIds)) {
                           while ( $locIds = mysqli_fetch_array($queryLocationIds) ){
                                     $locationIds[] = $locIds['st_lo_id'];
                        } 
                      } 
                  
                 $newarrayLocations = '';  
                  if(is_array($locationIds)) 
                     $newarrayLocations = implode(", ", $locationIds);  
                  
                  
                
                 //Get All branches Information      
                   $sqlBranches = "select $this->_locationInfoTable.lo_name as branchname, $this->_locationInfoTable.lo_address1, $this->_locationInfoTable.lo_id,
                   $this->_locationInfoTable.lo_address2, $this->_locationInfoTable.lo_zip, $this->_locationInfoTable.lo_city, $this->_locationInfoTable.lo_about, $this->_locationInfoTable.lo_lat,   
                   $this->_locationInfoTable.lo_long, $this->_locationInfoTable.lo_main_branch, $this->_workingHoursTable.wh_mon, $this->_workingHoursTable.wh_tue, $this->_workingHoursTable.wh_wed,
                   $this->_workingHoursTable.wh_thu, $this->_workingHoursTable.wh_fri, $this->_workingHoursTable.wh_sat, $this->_workingHoursTable.wh_sun    
                   from $this->_locationInfoTable  inner join $this->_workingHoursTable on $this->_workingHoursTable.wh_lo_id =  $this->_locationInfoTable.lo_id 
                   where $this->_locationInfoTable.lo_id IN($newarrayLocations) and $this->_locationInfoTable.lo_bd_id = $searchBusinessId";
                 
                $queryBranches = mysqli_query($this->db, $sqlBranches);
                     
                if (mysqli_num_rows($queryBranches)) {
                    while ( $result = mysqli_fetch_array($queryBranches) ){
                        $branchesInformation[] = $result;
                    }
                
                
                $response['status'] = "Success";
                $response['branchesInformation'] = $branchesInformation; 
                $response['branchesOffDays'] = $branchesOffDays;
                
                $this->response($this->json($response), 200);
                
                
                
                    
              } 
   
               

            } else {
                $response['status'] = "Failed";
                $response['msg'] = "branches not available";
                $this->response($this->json($response), 400);
            }
        } 
        else {
            $response['status'] = "Failed";
            $response['msg'] = "Empty Parameter";
            $this->response($this->json($response), 400);
        }
    }
  
   /*
   * Get Staff  
   *  Url -> http://183.182.84.197/mycityonmap/api/location 
   */

   Public function get_staff(){
       
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
        
        if ($this->get_request_method() != "POST") {
            $response['status'] = "Failed";
            $response['msg'] = 'Please use proper method for sending variables';
            $this->response($this->json($response), 406);
        }   
        
        $locationId = $this->_request['inputLocationId']; 

        if (!(empty($locationId))) {

             $sqlCategory = "select $this->_userTable.user_id, $this->_userTable.u_email, $this->_userTable.u_fname, $this->_userTable.u_lname, $this->_userTable.u_picture
               from $this->_userTable right join $this->_staffTable  on $this->_staffTable.st_u_id = $this->_userTable.user_id where $this->_staffTable.st_lo_id = $locationId and $this->_staffTable.st_type = 4 
               and $this->_userTable.u_status = 1";
             
            $query = mysqli_query($this->db, $sqlCategory);
                 
            if (mysqli_num_rows($query)) {
                while ( $result = mysqli_fetch_array($query) ){
                    $data[] = $result;
                }
                $response['status'] = "Success";
                $response['data'] = $data; 
                
                $this->response($this->json($response), 200);

            } else {
                $response['status'] = "Failed";
                $response['msg'] = "Staff not available";
                $this->response($this->json($response), 400);
            }
        } 
        else {
            $response['status'] = "Failed";
            $response['msg'] = "Empty Parameter";
            $this->response($this->json($response), 400);
        }
    }
  
   /*
   * Get Owner Services  
   * Url -> http://183.182.84.197/mycityonmap/api/service  
   */ 
    
   Public function service(){
        
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
        
        if ($this->get_request_method() != "POST") {
            $this->response('Please use proper method for sending variables', 406);
        }   
        
        $brandId = $this->_request['id'];    
        
        //$categoryId = '1';

        if (!(empty($brandId))) {

            $sqlCategory = "select * from ".$this->_serviceTable." where sr_u_id = " . $brandId ;
            $query = mysqli_query($this->db, $sqlCategory);
                 
            if (mysqli_num_rows($query)) {
                
                while ( $data = mysqli_fetch_array($query) ){
                    $responce[] = $data;
                }
                $this->response($this->json($responce), 200);

            } else {
                
                $response['status'] = "Failed";
                $response['error'] = "invalid Category";
                $this->response($this->json($response), 400);
                
            }
        } else {
            $response['status'] = "Empty Parameter";
            $this->response($this->json($response), 400);
        }
    }  
  
   /*
   * Get Owner Location  
   *  Url -> http://183.182.84.197/mycityonmap/api/location 
   */

   Public function location(){
        
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
        if ($this->get_request_method() != "POST") {
            $this->response('Please use proper method for sending variables', 406);
        }   
        
        
        $ownerId = $this->_request['id']; 
        
        //$ownerId = '1';

        if (!(empty($ownerId))) {

            $sqlCategory = "select lo_id, lo_name, lo_phone, lo_address1, lo_address2, lo_zip, lo_city, lo_about, lo_lat, lo_long from ".$this->_locationTable." where lo_u_id = " . $ownerId ;
            $query = mysqli_query($this->db, $sqlCategory);
                 
            if (mysqli_num_rows($query)) {
                while ( $data = mysqli_fetch_array($query) ){
                    $responce[] = $data;
                }
                
                $this->response($this->json($responce), 200);

            } else {
                $response['status'] = "Failed";
                $response['error'] = "invalid ";
                $this->response($this->json($response), 400);
            }
        } else {
            $response['status'] = "Empty Parameter";
            $this->response($this->json($response), 400);
        }
    } 
    
   /*
   * Get Owner Category  
   * Url -> http://183.182.84.197/mycityonmap/api/category  
   */ 
                                                                                                                  
   Public function category(){
        
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
        if ($this->get_request_method() != "GET") {
            $this->response('Please use proper method for sending variables', 406);
        }  
        
        
        $shopId = $this->_request['id'];   
        
        //$ownerId = '1';

        if (!(empty($ownerId))) {

            $sqlCategory = "select * from ".$this->_categoryTable." where cat_u_id = " . $ownerId ;
            $query = mysqli_query($this->db, $sqlCategory);
                 
            if (mysqli_num_rows($query)) {
                while ( $data = mysqli_fetch_array($query) ){
                    $responce[] = $data;
                }
                
                $this->response($this->json($responce), 200);

            } else {
                $response['status'] = "Failed";
                $response['error'] = "invalid Category";
                $this->response($this->json($response), 400);
            }
        } else {
            $response['status'] = "Empty Parameter";
            $this->response($this->json($response), 400);
        }
    }
    

   
   /*
   * Get Owner Working Hours  
   * Url -> http://183.182.84.197/mycityonmap/api/working_hours  
   */ 
    
   public function  working_hours(){
        
        //global $link;
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
       if ($this->get_request_method() != "GET") {
            $this->response('Please use proper method for sending variables', 406);
        }  

        $LocationId = $this->_request['inputLocationId'];   
        
        //$LocationId = '1';

        if (!(empty($LocationId))) {

            echo $sqlCategory = "select * from ".$this->_workingHoursTable." where wh_lo_id = " . $LocationId ;
            $query = mysqli_query($this->db, $sqlCategory);
                 
            if (mysqli_num_rows($query)) {
                while ( $data = mysqli_fetch_array($query) ){
                    $responce[] = $data;
                }
                
                $this->response($this->json($responce), 200);

            } else {
                $response['status'] = "Failed";
                $response['error'] = "invalid Location";
                $this->response($this->json($response), 400);
            }
        } else {
            $response['status'] = "Empty Parameter";
            $this->response($this->json($response), 400);
        }
    }


  function formatMilliseconds($milliseconds,$accident_time = 0) {
         $seconds = $milliseconds / 1000;
         $sec = $seconds - $accident_time;
        return date("d-m-Y H:i:s A", $sec);
    }
    
    
     /*
     *    Simple ADD Document API
     *  document must be POST method 
     * http://216.117.39.226//poc64rest/createDocument?DocId=2&QRDocId=hfj23423&ProcessTime=300      */

    private function createDocument() {
        
        
        
        
        
        $DocId = $this->_request['DocId'];
        $QRDocId = $this->_request['QRDocId'];
        $ProcessDate = date("Y-m-d H:i:s");
        $ProcessTime = $this->_request['ProcessTime'];
        $Status = 'INP';

       //$test = $DocId.'-----'.$QRDocId.'-----'.$ProcessTime;
        //file_put_contents('create.txt', $test);
        
        //getting uplo$testzaded user email
        $sqlGetEmail = "SELECT `email` from users where id=(select `CreatedBy` from tbl_document where `DocName` = '".$DocId."')";
        $rsGet = mysqli_query($this->db, $sqlGetEmail);
        $data = mysqli_fetch_array($rsGet, MYSQLI_ASSOC);
        $email = $data['email'];
        
         //getting recepeint user email
                $sqlGetEmail = "SELECT `email` from contacts where id=(select `RecepientId` from tbl_document where `DocName` = '".$DocId."')";
                
                $rsGet = mysqli_query($this->db, $sqlGetEmail);
                $data = mysqli_fetch_array($rsGet, MYSQLI_ASSOC);
                $recepientEmail = $data['email'];

        // Input validations

        if (!empty($DocId) and ! empty($QRDocId) and ! empty($ProcessTime) and ! empty($ProcessTime)) {

            $sqlUpdate = "UPDATE  `tbl_document` set `QRDocId`='" . $QRDocId . "',`ProcessDate`='" . $ProcessDate . "',`ProcessTime`=" . $ProcessTime . ",`Status` ='" . $Status . "' ,`lastUpdated`='".$ProcessDate."' where `DocName`='".$DocId."'";
            //echo $sqlUpdate;die;
            $rsUpdate = mysqli_query($this->db, $sqlUpdate);
            if (mysqli_affected_rows($this->db)) {

                //creating download link 
                $random = md5(rand());
                $link = 'http://216.117.39.226/poc64rest/download?c=' . $random;
                $sqldownload = "insert into download (`download_link`,`docname`) values ('" . $random . "','" . $DocId . "')";
                $rsInsert = mysqli_query($this->db, $sqldownload);

                $mailBody = '';


                $mailBody = "Dear Member, As you requested, New file is uploaded.<br>
                                                    You can Download the file by using below link.<br><a href='" . $link . "'> Download Document</a><br><br>Thanks";
                $this->sendmail($email, '', 'New Document uploaded', $mailBody);
                $this->sendmail($recepientEmail, '', 'New Document uploaded', $mailBody);
                //echo $t.'-------'.$email;
               

                //send mail
                //sending response
                $error = array('status' => 'success', "msg" => "Document inserted successfully");
                $this->response($this->json($error), 200);
            } else {
                $error = array('status' => 'failure', "msg" => "Document inserted fail");
                $this->response($this->json($error), 200);
            }
        } //var_dump($this->_request);
        // If invalid inputs "Bad Request" status message and reason
        $error = array('status' => 0, "msg" => "Invalid Parameter");
        $this->response($this->json($error), 400);
    }

    private function verifyDocument() {

        //require 'PHPMailer/PHPMailerAutoload.php';
        //$DocId = $this->_request['DocId'];
        $DocName = $this->_request['DocId'];
        $DiscrepancyCnt = $this->_request['DiscrepancyCnt'];
        $VerifyDate = date("Y-m-d H:i:s");
        $VerifyProcessTime = $this->_request['VerifyProcessTime'];
        $Status = 'PRO';
        $IsRead = 0;
        //$a = $DocName.'----'.$DiscrepancyCnt.'----'.$VerifyProcessTime;
        //file_put_contents('a.txt', $a);
        $sqlUpdate = "UPDATE  `tbl_document` set `Status` ='" . $Status . "',`IsRead` =" . $IsRead . ",`lastUpdated`='" . $VerifyDate . "' where `DocName`= '".$DocName."'";
        //echo $sqlUpdate;die;
        //echo $sqlUpdate;die;
        $rsUpdate = mysqli_query($this->db, $sqlUpdate);

        //insert data in verify table
        if (mysqli_affected_rows($this->db) > 0) {
            //getting DocId
            $sqlDocId = "SELECT `DocId` from tbl_document where `DocName`= '".$DocName."'";
                $rsGet = mysqli_query($this->db, $sqlDocId);
                $data = mysqli_fetch_array($rsGet, MYSQLI_ASSOC);
                $DocId = $data['DocId'];

            $sqlInsert = "INSERT into `tbl_verify_detail` (`DocId`,`DiscrepancyCnt`,`VerifyDate`,`VerifyProcessTime`) values (" . $DocId . ", " . $DiscrepancyCnt . ",'" . $VerifyDate . "', " . $VerifyProcessTime . " )";
            $rsInsert = mysqli_query($this->db, $sqlInsert);


            if ($rsInsert) {

                //getting uploaded user email
                $sqlGetEmail = "SELECT `email` from users where id=(select `CreatedBy` from tbl_document where `DocId` = $DocId)";
                $rsGet = mysqli_query($this->db, $sqlGetEmail);
                $data = mysqli_fetch_array($rsGet, MYSQLI_ASSOC);
                $email = $data['email'];

                //getting recepeint user email
//                $sqlGetEmail = "SELECT `email` from contacts where id=(select `RecepientId` from tbl_document where `DocId` = $DocId)";
//                $rsGet = mysqli_query($this->db, $sqlGetEmail);
//                $data = mysqli_fetch_array($rsGet, MYSQLI_ASSOC);
//                $recepientEmail = $data['email'];

                //creating download link 
                $random = md5(rand());
                $link = 'http://216.117.39.226/poc64rest/download?v=' . $random;
                $fileName = end($this->get_verify_document($DocId));
               // var_dump($fileName['verifyDocName']);die;
                $sqldownload = "insert into download (`download_link`,`docname`) values ('" . $random . "','" . $fileName['verifyDocName'] . "')";
                $rsInsert = mysqli_query($this->db, $sqldownload);

                $mailBody = '';


                $mailBody = "Dear Member, As you requested, New file is uploaded.<br>
                                                    You can Download the file by using below link.<br><a href='
                                                    " . $link . "'>Download File </a><br><br>Thanks";
                $this->sendmail($email, '', 'New Document uploaded', $mailBody);
                //$this->sendmail($recepientEmail, '', 'New Document uploaded', $mailBody);

                //send mail
                //sending response
                $error = array('status' => 'success', "msg" => "Document inserted successfully");
                $this->response($this->json($error), 200);
            } else {
                $error = array('status' => 'failure', "msg" => "Document inserted fail");
                $this->response($this->json($error), 200);
            }
        } else {
            $error = array('status' => 'failure', "msg" => "DocId is not in the database");
            $this->response($this->json($error), 200);
        }

        //changing file name in case of verify
        /*
          if ($processType == 'verify') {
          $temp_name = explode('.', $docName);
          $docName = $temp_name[0] . '_diff' . '.' . $temp_name[1];
          } */
    }

    
    private function getVerifyFilename($DocId){
        
        
    }
    /*
     *    Simple Get Document API
     * http://183.182.84.197/poc64rest/get_document?email=dsolankimca@gmail.com
     */

    private function get_document() {
        $email = $this->_request['email'];
        if (!empty($email)) {
            $sqlGetDocument = "SELECT * from documents where email='$email' ";
            $rsGetDocument = mysqli_query($this->db, $sqlGetDocument);
            if (mysqli_num_rows($rsGetDocument) > 0) {
                $i = 0;
                $output = array();
                while ($data = mysqli_fetch_array($rsGetDocument, MYSQLI_ASSOC)) {
                    $output[$i]['id'] = $data['id'];
                    $output[$i]['doc_name'] = $data['doc_name'];
                    $output[$i]['file_name'] = $data['file_name'];
                    $output[$i]['date_of_processing'] = $data['date_of_processing'];
                    $output[$i]['duration_of_processing'] = $data['duration_of_processing'];
                    $output[$i]['email'] = $data['email'];
                    $output[$i]['email_of_receiver'] = $data['email_of_receiver'];
                    $output[$i]['process_type'] = $data['process_type'];
                    $output[$i]['parent_doc_id'] = $data['parent_doc_id'];
                    $i++;
                }
                //$output['link']=$output;
                // If success everythig is good send header as "OK" and return list of users in JSON format
                //$this->response($this->json($output), 200);

                $this->response('{"link":' . $this->json($output) . '}', 200);
            }
            $this->response('', 204);    // If no records "No Content" status
        }
        $error = array('status' => 'fail', "msg" => "No Record");
        $this->response($this->json($error), 400);
    }

    private function users() {
        // Cross validation if the request method is GET else it will return "Not Acceptable" status
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);
        }
        $sql = mysql_query("SELECT user_id, user_fullname, user_email FROM users WHERE user_status = 1", $this->db);
        if (mysql_num_rows($sql) > 0) {
            $result = array();
            while ($rlt = mysql_fetch_array($sql, MYSQL_ASSOC)) {
                $result[] = $rlt;
            }
            // If success everythig is good send header as "OK" and return list of users in JSON format
            $this->response($this->json($result), 200);
        }
        $this->response('', 204); // If no records "No Content" status
    }

    private function deleteUser() {
        // Cross validation if the request method is DELETE else it will return "Not Acceptable" status
        if ($this->get_request_method() != "DELETE") {
            $this->response('', 406);
        }
        $id = (int) $this->_request['id'];
        if ($id > 0) {
            mysql_query("DELETE FROM users WHERE user_id = $id");
            $success = array('status' => "Success", "msg" => "Successfully one record deleted.");
            $this->response($this->json($success), 200);
        } else
            $this->response('', 204); // If no records "No Content" status
    }



//reset password
    private function reset_password() {
        //global $link;
        $mail_id = $_REQUEST['email'];
        $pass = '';

        if (!(empty($mail_id))) {

            $sql = "select * from users where email='$mail_id'";
            $rs = mysqli_query($this->db, $sql);
            if (mysqli_num_rows($rs)) {
                $pass = $this->generateRandomString();
                $sqlUpdate = "update users set  password='" . md5($pass) . "' where email='" . $mail_id . "'";
                $updatePassword = mysqli_query($this->db, $sqlUpdate);

                // MAIL

                $ini_array = parse_ini_file("email_config.ini");
                require 'PHPMailer/PHPMailerAutoload.php';
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $ini_array['username'];
                $mail->Password = $ini_array['password'];
                $mail->SMTPSecure = 'tls';
                $mail->From = $ini_array['username'];
                $mail->FromName = 'BIC KMBS';
                $mail->addAddress($mail_id, ''); // sent mail email address and name
                $mail->addReplyTo($ini_array['username'], 'BIC KMBS');
                $mail->WordWrap = 50;
                $mail->isHTML(true);
                $mail->Subject = 'Konica Reset Password';
                $mail->Body = "Dear Member,
                    As you requested, we have reset your password. Your new password is given below: <br>
                    password: $pass <br>
                    You can login with these details.<br>Please dont forgot to change this password.<br>
                    Thanks  ";

                //$mail->Body    = 'Hi I am using PHPMailer library to sent SMTP mail from localhost';
                //$mail->addAttachment('D:\test.jpg');///for attachment

                if ($mail->Send()) {
                    $response = array();
                    $response['ChangePassword'] = "success";
                    $response['MailSend'] = "Success";

                    echo ('{"data":' . json_encode($response) . '}');
                } else {
                    $response['ChangePassword'] = "success";
                    $response['MailSend'] = "Failure";
                    echo ('{"data":' . json_encode($response) . '}');
                }
            } else {
                $response['ChangePassword'] = "Failure";
                $response['MailSend'] = "mail does not exist!";
                echo ('{"data":' . json_encode($response) . '}');
            }
        } else {
            $response['authentication'] = "empty Perameter";
            echo ('{"data":' . json_encode($response) . '}');
        }
    }

    /*
     *    Simple Get contact API
     * http://183.182.84.197/poc64rest/get_contact?email=arvihyd@gmail.com
     */

    private function get_contact() {
        $email = $this->_request['email'];
        $uid = $this->getUid($email);
        if (!empty($email)) {
            $uid = $this->getUid($email);

            if ($uid) {

                $sqlGetDocument = "SELECT * from contacts where uid='$uid' ";
                $rsGetDocument = mysqli_query($this->db, $sqlGetDocument);
                $i = 0;
                $output = array();
                while ($data = mysqli_fetch_array($rsGetDocument, MYSQLI_ASSOC)) {

                    $output[$i]['contact_id'] = $data['id'];
                    $output[$i]['first_name'] = $data['name'];
                    $output[$i]['last_name'] = $data['last_name'];
                    $output[$i]['phone'] = $data['phone'];
                    $output[$i]['email'] = $data['email'];
                    $i++;
                }
                //$output['link']=$output;
                // If success everythig is good send header as "OK" and return list of users in JSON format
                //$this->response($this->json($output), 200);
                $this->response('{"link":' . $this->json($output) . '}', 200);
                //$this->response($this->json($output),200);
            }
            $error = array('status' => 'fail', "msg" => "No Record");
            $this->response($this->json($error), 400);    // If no records "No Content" status
        }
        $error = array('status' => 'fail', "msg" => "Email Blank");
        $this->response($this->json($error), 400);
    }

//add contact

    private function add_contact() {

        $email = $this->_request['uemail'];
        $uid = $this->getUid($email);
        //$contact_id = $this->_request['contact_id'];
        $name = $this->_request['first_name'];
        $last_name = $this->_request['last_name'];
        $email = $this->_request['email'];
        $phone = $this->_request['phone'];




        $sqlInsert = "insert into contacts (`uid`,`name`,`last_name`,`email`,`phone`) values('" . $uid . "','" . $name . "','" . $last_name . "','" . $email . "','" . $phone . "')";
        $rsInsert = mysqli_query($this->db, $sqlInsert);

        if ($rsInsert) {

            $error = array('response' => 'success');
            $this->response($this->json($error), 200);
        } else {

            $error = array('response' => 'fail');
            $this->response($this->json($error), 400);
        }
    }

//update contact

    private function update_contact() {

        //$email = $this->_request['uemail'];
        $contact_id = $this->_request['contact_id'];
        $name = $this->_request['first_name'];
        $last_name = $this->_request['last_name'];
        $email = $this->_request['email'];
        $phone = $this->_request['phone'];




        $sqlUpdate = "update contacts set  name='" . $name . "',last_name='" . $last_name . "',email='" . $email . "',phone='" . $phone . "' where id='" . $contact_id . "'";
        $r = $updatePassword = mysqli_query($this->db, $sqlUpdate);

        if ($r) {

            $error = array('response' => 'success');
            $this->response($this->json($error), 200);
        } else {

            $error = array('response' => 'fail');
            $this->response($this->json($error), 400);
        }
    }

//delete contact
    private function delete_contact() {

        $contact_id = $this->_request['contact_id'];

        $sqlDelete = "Delete from contacts where id='" . $contact_id . "'";
        $r = $updatePassword = mysqli_query($this->db, $sqlDelete);

        if ($r) {

            $error = array('response' => 'success');
            $this->response($this->json($error), 200);
        } else {

            $error = array('response' => 'fail');
            $this->response($this->json($error), 400);
        }
    }

//update profile
    private function updateProfile() {

        $uemail = $this->_request['uemail'];

        $id = $this->getUid($uemail);
        $name = $this->_request['first_name'];
        $last_name = $this->_request['last_name'];
        $phone = $this->_request['phone'];




        $sqlUpdate = "update users set  first_name='" . $name . "',last_name='" . $last_name . "',phone='" . $phone . "' where id='" . $id . "'";
        $r = $updatePassword = mysqli_query($this->db, $sqlUpdate);

        if ($r) {

            $error = array('response' => 'success');
            $this->response($this->json($error), 200);
        } else {

            $error = array('response' => 'fail');
            $this->response($this->json($error), 400);
        }
    }

//get uid for email
    private function getUid($email) {
        $sql = "SELECT `id` from users where email='$email' ";
        $rsGetUid = mysqli_query($this->db, $sql);
        $data = mysqli_fetch_array($rsGetUid, MYSQLI_ASSOC);
        return $data['id'];
    }
    
    private function getRecepientId($recepientEmail, $uid){
   //global $conn;
    $sql = "select `id` from contacts where email='".$recepientEmail."' and `uid`=$uid";
    $rs = mysqli_query($this->db,$sql);
    if(mysqli_num_rows($rs) > 0){
        
        $uid = mysqli_fetch_array($rs);
        return $uid['id'];
        
    }else{
        
        $sql = "INSERT into contacts (`uid`,`email`) values ('".$uid."','".$recepientEmail."')";
        $rs = mysqli_query($this->db,$sql);
        return mysqli_insert_id($rs);
    }
    
}

    private function getEmail($user_id) {
        $sql = "SELECT `email` from contacts where `id`=$user_id ";
        $rsGetUid = mysqli_query($this->db, $sql);
        $data = mysqli_fetch_array($rsGetUid, MYSQLI_ASSOC);
        return $data['email'];
    }
    
    private function getUserEmail($user_id) {
        $sql = "SELECT `email` from users where `id`=$user_id ";
        $rsGetUid = mysqli_query($this->db, $sql);
        $data = mysqli_fetch_array($rsGetUid, MYSQLI_ASSOC);
        return $data['email'];
    }

//get uid for email
    private function getDocCount() {

        $email = $this->_request['email'];
        $user_id = $this->getUid($email);
        $sql = "SELECT count(DocId) as total FROM `tbl_document` WHERE `CreatedBy`=" . $user_id . " and `IsRead`=0 and `Status` !='NOP'";
        //echo $sql;die;
        $rsGetUid = mysqli_query($this->db, $sql);
        $data = mysqli_fetch_array($rsGetUid, MYSQLI_ASSOC);
        echo $data['total'];
    }

    private function updateDocCount() {

        $rowid = $this->_request['rowid'];
        //$email = $this->_request['rowid'];
        $sql = "UPDATE ` tbl_document` set `IsRead`=1 WHERE `DocId`='" . $rowid . "'";
        $rsGetUid = mysqli_query($this->db, $sql);

        echo $rsGetUid;
    }

//get inbox
    private function getInboxList() {
        $user_id = $this->_request['userId'];

        if (!empty($user_id)) {
            $sqlGetDocument = "SELECT *  FROM `tbl_document` where `CreatedBy` =$user_id and `Status` !='NOP' order by `lastUpdated` DESC";

            $rsGetDocument = mysqli_query($this->db, $sqlGetDocument) or die(mysqli_error($this->db));
            if (mysqli_num_rows($rsGetDocument) > 0) {
                $i = 0;
                $output = array();
                while ($data = mysqli_fetch_array($rsGetDocument, MYSQLI_ASSOC)) {
                    $output[$i]['DocId'] = $data['DocId'];
                    $output[$i]['QRDocId'] = $data['QRDocId'];
                    $output[$i]['Title'] = $data['Title'];
                    $output[$i]['DocName'] = $data['DocName'];
                    $output[$i]['DocSize'] = $data['DocSize'];
                    $output[$i]['DocType'] = $data['DocType'];
                    $output[$i]['CreatedBy'] = $data['CreatedBy'];
                    $output[$i]['RecepientId'] = $data['RecepientId'];
                    $output[$i]['RecepientEmail'] = $this->getEmail($data['RecepientId']);
                    $output[$i]['DateCreated'] = $data['DateCreated'];
                    $output[$i]['ProcessDate'] = $data['ProcessDate'];
                    $output[$i]['ProcessTime'] = gmdate("i:s", $data['ProcessTime']);
                    //$output[$i]['VerifyDate'] = $data['VerifyDate'];
                    //$output[$i]['VerifyProcessTime'] = gmdate("i:s", $data['VerifyProcessTime']);
                    //$output[$i]['DiscrepancyCnt'] = $data['DiscrepancyCnt'];
                    $output[$i]['IsRead'] = $data['IsRead'];
                    $output[$i]['verify_document'] = $this->get_verify_document($data['DocId']);
                    $i++;
                }
                //$output['link']=$output;
                // If success everythig is good send header as "OK" and return list of users in JSON format
                //$this->response($this->json($output), 200);
                //echo '<pre>';
                //print_r($output);die;
                $this->response('{"link":' . $this->json($output) . '}', 200);
            }
            $this->response('', 204);    // If no records "No Content" status
        }
        $error = array('status' => 'fail', "msg" => "No Record");
        $this->response($this->json($error), 400);
    }

    private function getMobileInboxList() {
        $user_id = $this->_request['userId'];

        if (!empty($user_id)) {
            $sqlGetDocument = "SELECT * FROM `tbl_document` where `CreatedBy` =$user_id and `Status` !='NOP' order by GREATEST(IFNULL(`DateCreated`, 0),IFNULL(`ProcessDate`, 0)) DESC";

            $rsGetDocument = mysqli_query($this->db, $sqlGetDocument) or die(mysqli_error($this->db));
            if (mysqli_num_rows($rsGetDocument) > 0) {
                $i = 0;
                $output = array();
                while ($data = mysqli_fetch_array($rsGetDocument, MYSQLI_ASSOC)) {
                    $output[$i]['DocId'] = $data['DocId'];
                    $output[$i]['QRDocId'] = $data['QRDocId'];
                    $output[$i]['Title'] = $data['Title'];
                    $output[$i]['DocName'] = $data['DocName'];
                    $output[$i]['DocSize'] = $data['DocSize'];
                    $output[$i]['DocType'] = $data['DocType'];
                    $output[$i]['CreatedBy'] = $data['CreatedBy'];
                    $output[$i]['RecepientId'] = $data['RecepientId'];
                    $output[$i]['RecepientEmail'] = $this->getEmail($data['RecepientId']);
                    $output[$i]['DateCreated'] = $data['DateCreated'];
                    $output[$i]['ProcessDate'] = $data['ProcessDate'];
                    $output[$i]['ProcessTime'] = gmdate("i:s", $data['ProcessTime']);
                    //$output[$i]['VerifyDate'] = $data['VerifyDate'];
                    // $output[$i]['VerifyProcessTime'] = gmdate("i:s",$data['VerifyProcessTime']);
                    //$output[$i]['DiscrepancyCnt'] = $data['DiscrepancyCnt'];
                    $output[$i]['IsRead'] = $data['IsRead'];
                    $verify = array();
                    $verify[0]['id'] = $data['DocId'];
                    $verify[0]['VerifyDate'] = $data['VerifyDate'];
                    $verify[0]['VerifyProcessTime'] = gmdate("i:s", $data['VerifyProcessTime']);
                    $verify[0]['DiscrepancyCnt'] = $data['DiscrepancyCnt'];


                    $output[$i]['verify_document'] = $verify;
                    $i++;
                }
                //$output['link']=$output;
                // If success everythig is good send header as "OK" and return list of users in JSON format
                //$this->response($this->json($output), 200);
                //echo '<pre>';
                //print_r($output);die;
                $this->response('{"link":' . $this->json($output) . '}', 200);
            }
            $this->response('', 204);    // If no records "No Content" status
        }
        $error = array('status' => 'fail', "msg" => "No Record");
        $this->response($this->json($error), 400);
    }

    // 
//    private function get_verify_document($doc_id) {
//        $sqlGetDocument = "SELECT * from tbl_verify_detail where DocId=".$doc_id." order by VerifyDate desc ";
//        $rsGetDocument = mysqli_query($this->db, $sqlGetDocument); //or die(mysqli_error($this->db));
//        if (mysqli_num_rows($rsGetDocument) > 0) {
//            $output = array();
//            $i = 0;
//            while ($data = mysqli_fetch_array($rsGetDocument, MYSQLI_ASSOC)) {
//                $output[$i]['id'] = $data['id'];
//                //$output[$i]['DocId'] = $data['DocId'];
//                $output[$i]['DiscrepancyCnt'] = $data['DiscrepancyCnt'];
//                $output[$i]['VerifyDate'] = $data['VerifyDate'];
//                $output[$i]['VerifyProcessTime'] = $data['VerifyProcessTime'];
//             
//                $i++;
//            }
//            //var_dump($output);
//            return $output;
//        } else {
//            return array();
//        }
//    }
    
    private function get_verify_document($doc_id) {
        //$sqlGetDocument = "SELECT * from tbl_verify_detail where DocId=".$doc_id." order by VerifyDate desc ";
        $sqlGetDocument = "SELECT tbl_verify_detail.*, tbl_document.Title, tbl_document.DocName, tbl_document.DocType FROM tbl_verify_detail INNER JOIN tbl_document ON tbl_document.DocId=tbl_verify_detail.DocId WHERE tbl_verify_detail.DocId=" . $doc_id . " ORDER BY tbl_verify_detail.VerifyDate ";
        $rsGetDocument = mysqli_query($this->db, $sqlGetDocument); //or die(mysqli_error($this->db));
        if (mysqli_num_rows($rsGetDocument) > 0) {
            $output = array();
            $i = 0;
            while ($data = mysqli_fetch_array($rsGetDocument, MYSQLI_ASSOC)) {
                $output[$i]['id'] = $data['id'];
                //$output[$i]['DocId'] = $data['DocId'];
                $output[$i]['DiscrepancyCnt'] = $data['DiscrepancyCnt'];
                $output[$i]['VerifyDate'] = $data['VerifyDate'];
                $output[$i]['VerifyProcessTime'] = $data['VerifyProcessTime'];

                $output[$i]['Title'] = $data['Title'];
                $output[$i]['DocType'] = $data['DocType'];
                
                $nameTodisplay = $data['Title'];
                if(empty($data['Title'])) {
                    $nameTodisplay = $data['DocName'];
                }
                $output[$i]['DocName'] = $nameTodisplay . '_' . $i;
                
                $output[$i]['verifyDocName'] = $data['DocName'] . '_' . $i . '_diff.' . $data['DocType'];
                if ($i == 0) {
                    $output[$i]['DocName'] = $nameTodisplay;
                    $output[$i]['verifyDocName'] = $data['DocName'] . '_diff.' . $data['DocType'];
                }

                $i++;
            }
            //var_dump($output);
            return $output;
        } else {
            return array();
        }
    }

// generate random string
    private function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

//send mail

    private function sendmail($email, $name, $subject, $body, $attachment = 0) {

        $ini_array = parse_ini_file("email_config.ini");

        $mail = new PHPMailer;
        $mail->isSMTP();
        //$mail->SMTPDebug  = 2;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $ini_array['username'];
        $mail->Password = $ini_array['password'];
        $mail->SMTPSecure = 'tls';
        $mail->From = $ini_array['username'];
        $mail->FromName = 'BIC KMBS';
        $mail->addAddress($email, $name); // sent mail email address and name
        $mail->addReplyTo($ini_array['username'], 'BIC KMBS');
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        if ($attachment) {
            $mail->addAttachment($attachment);
        }
        $status = $mail->Send();
        return $status;
    }
    
//    private function test(){
//      
//    $t = $this->sendmail('jitendra.paswan@lmsin.com', 'jitendra paswan', 'konica', 'This is test');
//    echo $t;
//     echo 'coming'; 
//    }

//secure download
    private function download() {

        $file = '';
        
          if ($this->_request['c']) {
            $docId = $this->_request['c'];
           // $file = 'C:\wamp\www\poc64\create'.DIRECTORY_SEPARATOR.$email;
        } else {
            $docId = $this->_request['v'];
            //$file = 'C:\wamp\www\poc64\verify'.DIRECTORY_SEPARATOR.$email;
        }
       

        $sql = "SELECT `docname` from download where download_link='" . $docId . "' ";
        $rs = mysqli_query($this->db, $sql); //or die(mysqli_error($this->db));;
        $data = mysqli_fetch_array($rs, MYSQLI_ASSOC);
        $doc_name = $data['docname'];
        
        $sql = "SELECT `CreatedBy`, `DocType` from tbl_document where `DocName`='" . $doc_name . "' ";
        $rs = mysqli_query($this->db, $sql); //or die(mysqli_error($this->db));;
        $data = mysqli_fetch_array($rs, MYSQLI_ASSOC);
        $email = $this->getUserEmail($data['CreatedBy']);
        $DocType = $data['DocType'];
        
          if ($this->_request['c']) {
           // $docId = $this->_request['c'];
            $file = 'C:\wamp\www\poc64\create'.DIRECTORY_SEPARATOR.$email;
            $file = $file.DIRECTORY_SEPARATOR.$doc_name.'.'.$DocType;
        } else {
            //$docId = $this->_request['v'];
            $file = 'C:\wamp\www\poc64\verify'.DIRECTORY_SEPARATOR.$email;
            $file = $file.DIRECTORY_SEPARATOR.$doc_name;
        }
        
       


        $file = $file.DIRECTORY_SEPARATOR.$doc_name.'.'.$DocType;
        //echo $file;die;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }

//    private function updateDocName() {
//        $fname = $this->_request['fname'];
//        $rid = $this->_request['docId'];
//        ///$ext = $this->_request['fileext'];
//        if ($fname && $rid) {
//            /*        
//            $sql = "SELECT `process_type`,`doc_name` from documents where id='" . $rid . "' ";
//            $rs = mysqli_query($this->db, $sql); //or die(mysqli_error($this->db));;
//            $data = mysqli_fetch_array($rs, MYSQLI_ASSOC);
//            $process_type = $data['process_type'];
//            $old_docname = $data['doc_name'];
//
//            if ($process_type == 'create') {
//                $oldpath = 'C:\wamp\www\poc64\create\/' . $old_docname;
//                $newpath = 'C:\wamp\www\poc64\create\/' . $fname . '.' . $ext;
//                rename($oldpath, $newpath);
//            } else {
//
//                $oldpath = 'C:\wamp\www\poc64\verify\/' . $old_docname;
//                $newpath = 'C:\wamp\www\poc64\verify\/' . $fname . '.' . $ext;
//                rename($oldpath, $newpath);
//            }
//                   */
//            $sqlUpdate = "update tbl_document set  `DocName`='" . $fname  . "' where `DocId`=". $rid;
//     
//            $updatePassword = mysqli_query($this->db, $sqlUpdate);
//            $error = array('response' => 'success');
//            $this->response($this->json($error), 200);
//        } else {
//            $error = array('response' => 'fail');
//            $this->response($this->json($error), 400);
//        }
//        
//        
//
//    }

 private function updateDocName() {
        $fname = $this->_request['fname'];
        $rid = $this->_request['docId'];
        ///$ext = $this->_request['fileext'];
        if ($fname && $rid) {
            /*
              $sql = "SELECT `process_type`,`doc_name` from documents where id='" . $rid . "' ";
              $rs = mysqli_query($this->db, $sql); //or die(mysqli_error($this->db));;
              $data = mysqli_fetch_array($rs, MYSQLI_ASSOC);
              $process_type = $data['process_type'];
              $old_docname = $data['doc_name'];

              if ($process_type == 'create') {
              $oldpath = 'C:\wamp\www\poc64\create\/' . $old_docname;
              $newpath = 'C:\wamp\www\poc64\create\/' . $fname . '.' . $ext;
              rename($oldpath, $newpath);
              } else {

              $oldpath = 'C:\wamp\www\poc64\verify\/' . $old_docname;
              $newpath = 'C:\wamp\www\poc64\verify\/' . $fname . '.' . $ext;
              rename($oldpath, $newpath);
              }
             */
            $sqlUpdate = "update tbl_document set  `Title`='" . $fname . "' where `DocId`=" . $rid;

            $updatePassword = mysqli_query($this->db, $sqlUpdate);
            $error = array('response' => 'success');
            $this->response($this->json($error), 200);
        } else {
            $error = array('response' => 'fail');
            $this->response($this->json($error), 400);
        }
    }
    
//    private function deleteDoc() {
//
//        $rid = $this->_request['docId'];
//        if ($rid) {
//            /*
//            $sql = "SELECT `process_type`,`doc_name` from documents where id='" . $rid . "' ";
//            $rs = mysqli_query($this->db, $sql); //or die(mysqli_error($this->db));;
//            $data = mysqli_fetch_array($rs, MYSQLI_ASSOC);
//            $process_type = $data['process_type'];
//            $old_docname = $data['doc_name'];
//
//            if ($process_type == 'create') {
//                $oldpath = 'C:\wamp\www\poc64\create\/' . $old_docname;
//
//                //unlink($oldpath);
//            } else {
//
//                $oldpath = 'C:\wamp\www\poc64\verify\/' . $old_docname;
//
//                //unlink($oldpath);
//            }
//               */
//            $sqlDelete = "DELETE FROM tbl_document where `DocId`='" . $rid . "'";
//            $updatePassword = mysqli_query($this->db, $sqlDelete);
//            $error = array('response' => 'success');
//            $this->response($this->json($error), 200);
//        } else {
//             $error = array('response' => 'fail');
//            $this->response($this->json($error), 400);
//        }
//        
//        
//    }
    
private function deleteDoc() {

        $rid = $this->_request['docId'];
        $arrRid = json_decode($rid);
        $element = $arrRid[0];
        $arrTypeId = explode("_", $element);
        $userEmail = $_COOKIE['email'];
        if ($arrTypeId[1]) {
            $rid = $arrTypeId[1];
            if ($arrTypeId[0] == 'c') {

                $sql = "SELECT `DocName`,`DocType` FROM tbl_document WHERE DocId='" . $rid . "'";
                $rs = mysqli_query($this->db, $sql); //or die(mysqli_error($this->db));;
                $data = mysqli_fetch_array($rs, MYSQLI_ASSOC);
                $docName = $data['DocName'];
                $docType = $data['DocType'];

                $sqlV = "SELECT * FROM tbl_verify_detail WHERE DocId='" . $rid . "'";
                $rsV = mysqli_query($this->db, $sqlV);
                //$dataV = mysqli_fetch_array($rsV, MYSQLI_ASSOC);
                $verifyRows = mysqli_num_rows($rsV);

                $sqlDelete = "DELETE FROM tbl_document where `DocId`='" . $rid . "'";
                $sqlVerifyDelete = "DELETE FROM tbl_verify_detail where `DocId`='" . $rid . "'";
                $rsVerifyDelete = mysqli_query($this->db, $sqlVerifyDelete);


                // Create Unlink
                $fileName = $docName . '.' . $docType;
                $pathToUnlink = 'C:\wamp\www\poc64\create\/' . $userEmail . '\/' . $fileName;
                if (file_exists($pathToUnlink)) {
                    @unlink($pathToUnlink);
                }
                // End Create
                // Verify Unlink
                $fileName = $docName . '_diff.' . $docType;
                $pathToUnlink = 'C:\wamp\www\poc64\verify\/' . $userEmail . '\/' . $fileName;
                if (file_exists($pathToUnlink)) {
                    @unlink($pathToUnlink);
                }
                for ($i = 1; $i < $verifyRows; $i++) {
                    $fileName = $docName . '_' . $i . '_diff.' . $docType;
                    $pathToUnlink = 'C:\wamp\www\poc64\verify\/' . $userEmail . '\/' . $fileName;
                    if (file_exists($pathToUnlink)) {
                        @unlink($pathToUnlink);
                    }
                }
                // End Verify Unlink
            } else {
                // Only Verify delete
                $ress = $this->unlinkVerifyDocById($rid);
                $sqlDelete = "DELETE FROM tbl_verify_detail where `id`='" . $rid . "'";
            }
            $updatePassword = mysqli_query($this->db, $sqlDelete);
            $error = array('response' => 'success');
            $this->response($this->json($error), 200);
        } else {
            $error = array('response' => 'fail');
            $this->response($this->json($error), 400);
        }
    }
    
private function unlinkVerifyDocById($rid) {
       
        $userEmail = $_COOKIE['email'];
        $sqlV = "SELECT * FROM tbl_verify_detail WHERE id='" . $rid . "'";
        $rsV = mysqli_query($this->db, $sqlV);
        $dataV = mysqli_fetch_array($rsV, MYSQLI_ASSOC);
        $verifyRows = mysqli_num_rows($rsV);

        $docId = $dataV['DocId'];

        $sql = "SELECT `DocName`,`DocType` FROM tbl_document WHERE DocId='" . $docId . "'";
        $rs = mysqli_query($this->db, $sql); //or die(mysqli_error($this->db));;
        $data = mysqli_fetch_array($rs, MYSQLI_ASSOC);
        $docName = $data['DocName'];
        $docType = $data['DocType'];

        $sqlV = "SELECT * FROM tbl_verify_detail WHERE DocId='" . $docId . "' ORDER BY VerifyDate";
        $rsV = mysqli_query($this->db, $sqlV);

        //$verifyRows = mysqli_num_rows($rsV);
        $j = 0;
        $fileName = $docName . '_diff.' . $docType;
        $pathToUnlink = 'C:\wamp\www\poc64\verify\/' . $userEmail . '\/' . $fileName;

        while ($dataV = mysqli_fetch_array($rsV, MYSQLI_ASSOC)) {
            if ($dataV['id'] == $rid && !empty($j)) {
                $fileName = $docName . '_' . $j . '_diff.' . $docType;
                $pathToUnlink = 'C:\wamp\www\poc64\verify\/' . $userEmail . '\/' . $fileName;
                break;
            }
            $j++;
        }
        if (file_exists($pathToUnlink)) {
            @unlink($pathToUnlink);
            return true;
        }
        return false;
    }    

    
    
}

//class end	
// Initiiate Library

$api = new API;
$api->processApi();
?>