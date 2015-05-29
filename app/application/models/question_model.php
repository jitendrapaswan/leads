<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Question_model extends CI_Model {
    
    public function getCategories()
    {
        $this->db->select('*');        
        $this->db->from('category');               
        $query  = $this->db->get();
        $data   = $query->result();
        return($data);
    }
    
    public function getQuestions($cat_id)
    {
        if(!empty($cat_id))
        {   
            $this->db->select('*')->from('question');
            $this->db->where('id NOT IN (SELECT `question_id` FROM `category_question` where c_id = '.$cat_id.')', NULL, FALSE);           
            $query  = $this->db->get();            
            $data   = $query->result();
            return($data);
        }
        else
        {
            $this->db->select('*');
            $this->db->from('question');
           // $this->db->join('question_options','question.id = question_options.question_id');
            $this->db->group_by('question.id'); 
            $this->db->order_by('question.id','ASC'); 
            $query  = $this->db->get();
            $data   = $query->result();
            return($data);
        }
        
    }
    
    public function get_option_by_question_id($question_id)
    {   
        if(!empty($question_id))
        {
            $this->db->select('option_value,option_id');
            $this->db->from('question_options');
            $this->db->join('question','question.id = question_options.question_id');
            $this->db->where('question_id',$question_id);
            $query  = $this->db->get();
            $data   = $query->result();
            return($data);            
        }
        
    }
    
    public function category_wise_questions($cat_id)
    {
        if(!empty($cat_id))
        {
            $this->db->select('*');
            $this->db->from('question');
            $this->db->join('category_question','question.id = category_question.question_id');
            $this->db->where('c_id',$cat_id);
            $this->db->order_by('order','ASC');
            $query  = $this->db->get();
            $data   = $query->result();
            return($data);
        }
    }
    
    public function getCategoryQuestions($cat_id)
    {
        if(!empty($cat_id))
        {   
            $this->db->select('*');
            $this->db->from('question');
            $this->db->join('category_question','question.id = category_question.question_id');
            $this->db->where('c_id',$cat_id);
            $this->db->order_by('order','ASC');            
            $query  = $this->db->get();
            $data   = $query->result();
            return($data);
        }
    }
    
    public function check_duplicate_category($cat_name)
    {
        $this->db->where('category_name', $cat_name);
        $query = $this->db->get('category');        
        $count_row = $query->num_rows();
        if ($count_row > 0) {      
          return 1;
        } else {        
          return 0;
        }
    }
    
    public function category_question_options($cat_id)
    {
        $this->db->select('option_id');
        $this->db->from('category_question');
        $this->db->join('question_options','category_question.question_id = question_options.question_id');
        $this->db->where('c_id',$cat_id);
        $query  = $this->db->get();
        $data   = $query->result();
        return($data);
                
    }    
    public function is_question_belongs_category($question_id)
    {
        if(!empty($question_id))
        {
            $this->db->select('question_id,category_name');
            $this->db->from('question');
            $this->db->join('category_question','question.id = category_question.question_id');
            $this->db->join('category','category.c_id = category_question.c_id');
            $this->db->where('category_question.question_id',$question_id);                     
            $query  = $this->db->get();            
            $result = $query->row();
            return $result;
        }
    }
    
    public function is_questionoption_belongs_category($option_id,$question_id)
    {
        if(!empty($question_id)&& !empty($option_id))
        {
            $this->db->select('option_id,category_name');
            $this->db->from('question');            
            $this->db->join('question_options','question.id = question_options.question_id');
            $this->db->join('category_question','question.id = category_question.question_id');
            $this->db->join('category','category.c_id = category_question.c_id');
            $this->db->where('question_options.option_id',$option_id);                     
            $query  = $this->db->get();            
            $result = $query->row();
            return $result;
        }
    }
    
}
