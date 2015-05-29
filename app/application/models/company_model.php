<?php
class Company_model extends CI_Model
{
    public function get_company_detail_by_id($companyId)
    {
        $this->db->select('*');        
        $this->db->from('companyinfo');
        $this->db->where('id',$companyId);        
        $query  = $this->db->get();
        $data   = $query->row();
        return($data);
    }        
    
    public function get_company_history_by_id($companyId)
    {
        $this->db->select('*');        
        $this->db->from('company_history');
        $this->db->where('company_id',$companyId);        
        $query  = $this->db->get();
        $data   = $query->result();
        return($data);
    }
    
    public function get_companies()
    {
        $this->db->select('*');        
        $this->db->from('companyinfo');
        $this->db->where('Status',1);
        $query  = $this->db->get();        
        $data = $query->result();
        return $data;       
    }   
    public function get_field_history_by_id($id,$field)
    {
        $query = "select $field as field_text from company_history where id=".$id;
        $result = $this->db->query($query);
        $data = $result->row();
        return $data;
    }   
    
    public function get_log_by_field_id($fieldId)
    {
        $query = "select company_log.*,concat_ws(' ',users.first_name,users.last_name) as user_name from company_log "
                . "join users on company_log.created_by=users.id "
                . "where history_id=".$fieldId." order by created_date desc,log_id asc limit 1";
        $result = $this->db->query($query);
        $data = $result->row_array();
        return $data;
    }
    
    public function get_log_field_value_by_id($id,$field)
    {
        $query = "select field_value from company_log where log_id=".$id;
        $result = $this->db->query($query);
        $data = $result->row();
        return $data;
    }
    

    // Used for donut chart approved and not approved investments.
    function donutChartInvestment($status)
    {
        if(!empty($status))
        {
            $year = date("Y"); 
            if($status == 2)
            {
                $where = "investment_status ='Not Approved' and year(LastUpdated) = $year";
            }
            else
            {
                $where = "investment_status ='Approved' and year(LastUpdated) = $year";
            }
            $query = "select
                            sum(case when ThemeAlign='cloud'                            then InvestmentUSD else 0 end) cloud,
                            sum(case when ThemeAlign='3D Printing'                      then InvestmentUSD else 0 end) printing,
                            sum(case when ThemeAlign='Healthcare'                       then InvestmentUSD else 0 end) Healthcare,
                            sum(case when ThemeAlign='Connected Intelligent Ecosystem'  then InvestmentUSD else 0 end) Ecosystem,
                            sum(case when ThemeAlign='Robotics'                         then InvestmentUSD else 0 end) Robotics,
                            sum(case when ThemeAlign='Workplace of the Future'          then InvestmentUSD else 0 end) Workplace
                    FROM companyinfo where $where";
                    $result = $this->db->query($query);
                    return  $result->result();
        }
    }

    function barGraphMonthlyInvestment($status)
    {
        if(!empty($status))
        {
            $year = date("Y"); 
            if($status == 2)
            {
                $where = "investment_status ='Not Approved' and year(LastUpdated) = $year";
            }
            else
            {
                $where = "investment_status ='Approved' and year(LastUpdated) = $year";
            }
            $query = "select 
                        sum(case when month(LastUpdated)=1  then InvestmentUSD else 0 end) jan,
                        sum(case when month(LastUpdated)=2  then InvestmentUSD else 0 end) Feb,
                        sum(case when month(LastUpdated)=3  then InvestmentUSD else 0 end) Mar,
                        sum(case when month(LastUpdated)=4  then InvestmentUSD else 0 end) Apr,
                        sum(case when month(LastUpdated)=5  then InvestmentUSD else 0 end) May,
                        sum(case when month(LastUpdated)=6  then InvestmentUSD else 0 end) Jun,
                        sum(case when month(LastUpdated)=7  then InvestmentUSD else 0 end) jul,
                        sum(case when month(LastUpdated)=8  then InvestmentUSD else 0 end) Aug,
                        sum(case when month(LastUpdated)=9  then InvestmentUSD else 0 end) Sep,
                        sum(case when month(LastUpdated)=10 then InvestmentUSD else 0 end) Oct,
                        sum(case when month(LastUpdated)=11 then InvestmentUSD else 0 end) Nov,
                        sum(case when month(LastUpdated)=12 then InvestmentUSD else 0 end) Dece
                FROM companyinfo where $where ";
            $query = $this->db->query($query);                  
            return  $query->result();
        }
    } 

    public function getReceiverName($user_id)
    {
        if(!empty($user_id))
        {
            $this->db->select('first_name,last_name');
            $this->db->from('users');
            $this->db->where('id',$user_id);
            $query      =   $this->db->get();  
            $result     =   $query->row(); 
            return $result;
        }
    }

    //SELECT $fieldNames,edited_by,updated_time FROM company_history where company_id = $company_id";
    public function filter_history_records($fieldNames,$info,$company_id)
    {
        $this->db->select('*');        
        $this->db->from('company_history');
        $this->db->where('company_id',$company_id);
        $query_condition = $this->db->get();
        $condition = $this->db->last_query();
        $k  = count($info);        
        for($i=0; $i<=$k; $i++)
        {
            if($i == 0)
            {
                $operator =" AND";
            }
            else if($i>=1)
            {
                $operator =" OR";   
            }
        
            if($info[$i])
            {   
                $condition .= "$operator $info[$i]!='' ";    
            }   
            $query = $this->db->query("$condition");
        }
        $this->db->last_query();
        $results= $query->result();
        return $results;
    }
    
    public function get_company_field_history($field,$companyId)
    {
        $historyData = array();
        $query = "select company_history.id,$field,updated_time,concat_ws(' ',users.first_name,users.last_name) as edited_by from company_history "
                . "join users on company_history.edited_by=users.Id "
                . "where company_id=".$companyId." order by updated_time desc,id asc";
        $result = $this->db->query($query);
        if($result->num_rows() > 0)
        {
            $data = $result->result_array();
            foreach($data as $historyVal)
            {
                if(!empty($historyVal[$field]))
                {
                    $historyData[] = array('id'=>$historyVal['id'],'change'=>$historyVal[$field],'updated'=>$historyVal['updated_time'],'updated_by'=>$historyVal['edited_by']);
                }    
            }    
            return $historyData;
        }
        else
        {
            $data = array();
            return $data;
        }
    }
    
    function getApprovedViewStatus()
    {
        $this->db->select('*');        
        $this->db->from('companyinfo');
        $this->db->where('approved_view_status',1);        
        $query  = $this->db->get();
        $data   = $query->result();
        return($data);
            
    }
    
    function getDPStatus()
    {
        $this->db->select('*');        
        $this->db->from('display_status');
        $this->db->where('status',0);        
        $query  = $this->db->get();
        $data   = $query->result();
        return count($data);
    }
    
    function getDevelopementPlans()
    {
        $this->db->select('*');        
        $this->db->from('display_status');        
        $this->db->join('companyinfo','display_status.company_id = companyinfo.id');
        $this->db->where('display_status.status',0);      
        $this->db->group_by('companyinfo.id');
        $query  = $this->db->get();        
        $data   = $query->result();
        return $data;
    }
    
    
}