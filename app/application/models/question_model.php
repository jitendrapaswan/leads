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
            $this->db->join('question_options','question.id = question_options.question_id');
            $this->db->group_by('question.id');        
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
    
}
