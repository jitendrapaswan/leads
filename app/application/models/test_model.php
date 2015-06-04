<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Test_model extends CI_Model {

    function getAllSet()
    {
        $query = $this->db->get('category');
        $result   = $query->result();
        return $result;
    }
    
    public function categoryTestQuestions($cat_id)
    {
        if(!empty($cat_id))
        {
            $this->db->select('question.id,question,c_id');
            $this->db->from('question');
            $this->db->join('category_question','question.id = category_question.question_id');
            $this->db->where('c_id',$cat_id);
            $this->db->order_by('order','ASC');            
            $query  = $this->db->get();
            $data   = $query->result();
            return($data);
        }
    }
    
    public function getDependentQuestion($cid,$qid,$oid)
    {
        if(!empty($cid)&& !empty($qid) && !empty($oid))
        {
            $this->db->select('dependent_question_id');
            $this->db->from('question_dependency');   
            $this->db->join('category_question','question_dependency.question_id = category_question.question_id');
            $this->db->where(array('c_id'=>$cid,'question_dependency.question_id'=>$qid,'option_id'=>$oid));
            $query  = $this->db->get();            
            $data   = $query->row();
            if(!empty($data)) {
                return $data->dependent_question_id;
            } else {
                return 0;
            }
        }
    }
    
    public function getPreviousQuestion($qid)
    {
        if(!empty($qid))
        {
            $this->db->select('question_dependency.question_id as depQ,user_test.option_id');
            $this->db->from('question_dependency');
            $this->db->join('user_test','question_dependency.option_id = user_test.option_id');
            $this->db->where('dependent_question_id',$qid);        
            $query  = $this->db->get();            
            $data   = $query->row();            
            if(!empty($data)) {
                $arr = array('prevQid'=>$data->depQ,'prevOid'=>$data->option_id);
                return json_encode($arr);
            } else {
                return 0;
            }
        }
    }
    
    public function getMaxTimestamp($qid)
    {
        if(!empty($qid))
        {
            $this->db->select('max("timestamp") as timestamp, question_dependency.question_id as depQ,question_dependency.option_id');
            $this->db->from('question_dependency');
            $this->db->where('dependent_question_id',$qid);        
                $query  = $this->db->get();            
                $data   = $query->row();            
                if(!empty($data)) {
                    $arr = array('prevQid'=>$data->depQ,'prevOid'=>$data->option_id);
                    return json_encode($arr);
                } else {
                    return 0;
                }
        }
    }
}