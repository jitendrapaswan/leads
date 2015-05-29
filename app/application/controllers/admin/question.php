<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends CI_Controller {
       
   public function __construct() 
    {
        parent::__construct();
        $this->load->model(array('admin_model','question_model'));                
        if ($this->admin_model->is_logged_in() == FALSE) {
            redirect('admin/login');
        } 
    }
    
    public function index() 
    {
        redirect('admin/question/viewQuestion');
    }
    
    public function viewQuestion()
    {
        $this->load->view('admin/include/header_menu');
        $this->load->view('admin/add_question');
    }
    
    public function addQuestion()
    {
        if(!empty($_POST) && isset($_POST))
        {
            $question = $this->input->post('question');
            $options  = $this->input->post('option');
            $values = array_pop($options);            
            $this->db->insert('question',array('question'=>$question,'created_date'=>date("Y-m-d")));
            $inserted_question_id = $this->db->insert_id();
            $optionArray    =   array(		                                            
                                            'question_id'	=>  $inserted_question_id,
                                            'created_date'	=>  date("Y-m-d"),
                                        );	        				
	        			for($i=0;$i<count($options); $i++)
	        			{
	        			    $optionArray['option_value'] = $options[$i];
	        			    $this->db->insert('question_options',$optionArray);
	        			}                                       
            echo 1;
        }
    }
    
    public function questionList()
    {
        $this->load->view('admin/include/header_menu');
        $this->load->view('admin/view_question');
    }
    
    public function addCategory()
    {
        if(!empty($_POST) && isset($_POST))
        {
            $category = $this->input->post('category_name');     
            if(!empty($category)){
                $this->db->insert('category',array('category_name'=>$category));                 
            }
        }
        $this->data['category'] = $this->question_model->getCategories();
        $this->load->view('admin/category_list',$this->data);
    }
    
    public function add_category_wise_questions()
    {
        if(!empty($_POST) && isset($_POST))
        {
            $cat_id = $this->input->post('cat_id');     
            $question_id = $this->input->post('question_id');
            if(!empty($cat_id) && !empty($question_id)){
                $this->db->insert('category_question',array('c_id'=>$cat_id,'question_id'=>$question_id,'created_date'=>date("Y-m-d")));  
                echo 1;
            }
        }
    }
    
    public function view_category_wise_questions()
    {
        $this->data['cat_id'] = $cat_id = $this->input->post('cat_id');   
        $this->data['questions'] = $this->question_model->category_wise_questions($cat_id);
        $this->load->view("admin/categorywise_question_list",$this->data);
    }
    
    public function display_question()
    {
        $cat_id = $this->input->post('cat_id'); 
        $this->data['questions'] = $this->question_model->getQuestions($cat_id);        
        $this->load->view('admin/question_list',$this->data);
    }
    
    public function sort_cat_ques($cat_id)
    {  
        $this->db->delete('category_question',array('c_id'=>$cat_id));
        $questionArray = $this->input->post('questionId');
        $i = 0;
        foreach ($questionArray as $value) 
        {
            $this->db->insert('category_question',array('c_id'=>$cat_id,'question_id'=>$value,'order'=>$i,'created_date'=>date("Y-m-d")));
            $i++;
        }
    }
    
    public function ordered_category_question_list()
    {
        $this->data['category'] = $this->question_model->getCategories();
        $this->load->view('admin/include/header_menu');
        $this->load->view('admin/ordered_question_list',$this->data);
    }
    
    public function sorted_category_questions()
    {  
        $cat_id = $this->input->post('cat_id'); 
        $this->data['questions'] = $this->question_model->getCategoryQuestions($cat_id);   
        //echo $this->db->last_query(); die("dd");
        $this->load->view('admin/categoryQuestionListing',$this->data);
    }
    
    public function delete_category_question()
    {
        if(!empty($_POST) && isset($_POST))
        {
            $cat_id = $this->input->post('cat_id');     
            $question_id = $this->input->post('question_id');
            if(!empty($cat_id) && !empty($question_id)){
                $this->db->delete('category_question',array('c_id'=>$cat_id,'question_id'=>$question_id));
                echo 1;
            }
        }
    }
    
    public function insertDependentQuestionOnOption()
    {
        if(!empty($_POST) && isset($_POST))
        {     
            $question_id = $this->input->post('question_id');
            $option_id = $this->input->post('option_id');
            $dependent_question = $this->input->post('dependent_question');
            if(!empty($option_id) && !empty($question_id) && !empty($dependent_question)){
                $this->db->select('*')->from('question_dependency')->where('question_id',$question_id)->where('option_id',$option_id);
                $query = $this->db->get();
                if($query->num_rows() > 0)
                {
                    $this->db->update('question_dependency',array('dependent_question_id'=>$dependent_question),array('question_id'=>$question_id,'option_id'=>$option_id));
                    //echo $this->db->last_query(); die("Dfs");   
                }
                else
                {
                    $this->db->insert('question_dependency',array('question_id'=>$question_id,'option_id'=>$option_id,'dependent_question_id'=>$dependent_question,'created_date'=>date("Y-m-d")));
                    echo 1;
                }
            }
        }
    }
    
    public function getDependencyQuestion()
    {
        $cat_id = $this->input->post('cat_id');  
        if(!empty($cat_id))
            {
                $this->db->select('dependent_question_id, question_dependency.question_id,question_dependency.option_id');
                $this->db->from('question_dependency');
                $this->db->join('question','question.id = question_dependency.question_id');
                $this->db->join('category_question','category_question.question_id =question_dependency.question_id');
                $this->db->where('c_id',$cat_id);
                $query = $this->db->get();               
                $result = $query->result();
                echo json_encode($result);
        }
       
    }
}