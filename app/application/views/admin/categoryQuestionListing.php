<?php
if(!empty($questions)) 
{
    $i=1;
    foreach($questions as $row) 
    {
        $options = $this->question_model->get_option_by_question_id($row->question_id); 
    
    ?> 
   
            <div class="panel panel-default" id="question_<?php echo $row->question_id; ?>" count="<?php echo $i; ?>" question_id="<?php echo $row->question_id; ?>">
                
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>"><?php echo $i; ?>. <?php echo ucfirst($row->question);?> ?</a>
                    </h4>
                </div>
                
                <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse">
                    <div class="panel-body" style="padding:5px !important;">
                            <ul style="text-align: left;" class="check">
                            <?php if(!empty($options)) {                                     
                                    
                                    foreach ($options as $options)  {?>
                                        <div class="radio">
                                            <input type="radio" name="option" id="option" value="<?php echo $options->option_id; ?>" onclick="option_based_question('<?php echo $row->question_id; ?>')"><?php echo ucfirst($options->option_value); ?>                                                                                
                                            <select class="form-control ddclass input-md dropdown_<?php echo $row->question_id; ?>"  onchange="addDependentQuestion('<?php echo $row->question_id; ?>','<?php echo $options->option_id; ?>',this.value)">                                                
                                                <option value="">Select</option>
                                                <option value="1">Next</option>                                            
                                            </select> 
                                             </div>
                                    <?php }               
                                }?>
                            </ul>
                        
                    </div>
                </div>
                
            </div>

       
    <?php  $i++; }
    

} 
else 
{ 
    echo "No questions";
}
?>
<style>
.ddclass
{
    width:15% !important;
    float: right;
    clear:both;
    margin-bottom: 10px;
    height: 25px !important; 
    padding: 3px !important;
}
</style>





