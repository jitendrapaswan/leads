<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
        $this->load->model(array('test_model','question_model'));
        if ($this->utility_model->is_logged_in() == FALSE) {
            redirect('admin/user/login');
        }
    }
    
    public function index()
    {
         redirect('admin/test/viewTest');
    }
    
    // Display set list.
    public function viewTest()
    {
        $this->data['setInfo'] = $this->test_model->getAllSet();
        $this->load->view('admin/include/header_menu');
        $this->load->view('admin/viewtest',$this->data);
    }
    
    // Get question according to category.
    public function getCategoryQuestions()
    {
        $cat_id = $this->input->post('cat_id');
        $this->data['catQuestions'] =  $catQuestions = $this->test_model->categoryTestQuestions($cat_id);
        $this->load->view('admin/attempt_test',$this->data);
    }
    
    // used to get dependent question according to option id
    public function getDependentQuestion()
    {
        $cat_id         = $this->input->post('cat_id');
        $question_id    = $this->input->post('question_id');
        $option_id      = $this->input->post('option_id');
        $user_id      = $this->input->post('user_id');
        
        $this->db->select('option_id')->from('user_test')->where(array('c_id'=>$cat_id,'question_id'=>$question_id,'user_id'=>$user_id));
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
             $this->db->update('user_test',array('option_id'=>$option_id),array('question_id'=>$question_id,'user_id'=>$user_id,'c_id'=>$cat_id));
        }
        else
        {
            $this->db->insert('user_test',array('c_id'=>$cat_id,'question_id'=>$question_id,'option_id'=>$option_id,'user_id'=>$user_id));
        }
        $dep_qid        = $this->test_model->getDependentQuestion($cat_id,$question_id,$option_id);
        echo $dep_qid;
    }
    
    public function getPreviousQuestion()
    {
        $question_id = $this->input->post('question_id');
        //$prevData = $this->test_model->getMaxTimestamp($question_id); 
        $prevData = $this->test_model->getPreviousQuestion($question_id);         
        echo $prevData;
    }
}