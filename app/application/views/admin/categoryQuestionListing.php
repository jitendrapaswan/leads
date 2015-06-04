<?php
if(!empty($questions)) 
{
    $i=1;
    $quesCount = count($questions);
    foreach($questions as $row) 
    {
        $options = $this->question_model->get_option_by_question_id($row->question_id); 
    
    ?> 
   
            <div class="panel panel-default" id="question_<?php echo $row->question_id; ?>" count="<?php echo $i; ?>" question_id="<?php echo $row->question_id; ?>">
                
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>"><?php echo $i; ?>. <?php echo ucfirst($row->question);?> ?</a>
                        <div class="pull-right"><i class="indicator fa fa-chevron-down"></i>&nbsp;&nbsp;</div>
                    </h4>
                </div>
                
                <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse">
                    <div class="panel-body" style="padding:5px !important;">
                            <ul style="text-align: left;" class="check">
                            <?php if(!empty($options)) {                                     
                                    
                                    foreach ($options as $options)  {?>
                                    
                                        <div class="radio">
                                            <?php
                                                if($i < $quesCount)
                                                {
                                            ?>
                                            <input type="radio" name="option_<?php echo $options->option_id; ?>" id="option_<?php echo $options->option_id; ?>" value="<?php echo $options->option_id; ?>" onclick="option_based_question('<?php echo $row->question_id; ?>',this)"><?php echo ucfirst($options->option_value); ?>                                                                                
                                            <select id="optionSelect_<?php echo $options->option_id; ?>" class="form-control ddclass input-md dropdown_<?php echo $row->question_id; ?>"  onchange="addDependentQuestion('<?php echo $row->question_id; ?>','<?php echo $options->option_id; ?>',this.value)">                                                
                                                <option value="">Next</option>
                                                                                        
                                            </select> 
                                            
                                            
                                            <?php
                                                }
                                                else
                                                    echo ucfirst($options->option_value);
                                            ?>
                                        </div>
                                    <?php }               
                                } else { echo "No options"; } ?>
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
<script>
function toggleChevron(e) {
    $(e.target)
        .prev('.panel-heading')
        .find("i.indicator")
        .toggleClass('fa fa-chevron-down fa fa-chevron-up');
}
$('#accordion').on('hidden.bs.collapse', toggleChevron);
$('#accordion').on('shown.bs.collapse', toggleChevron);
</script>
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





