<?php if(!empty($catQuestions)){
        $i=1;
     foreach ($catQuestions as $value) {
        if($i == 1) { $style ="display:block"; } else { $style ="display:none";}
        if($i == 1) { $style1 ="display:none"; } else { $style1 ="display:block";}
        $options = $this->question_model->get_option_by_question_id($value->id); ?>      
        <div id="question_<?php echo $value->id;?>" style="<?php echo $style; ?>">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title"><?php echo trim($value->question).' ?'; ?></h1>                      
                </div>

                <div class="panel-body">
                    <ul style="text-align: left;">
                        <?php if(!empty($options)) {                            
                                foreach ($options as $options) {?>                                    
                                    <div class="radio">
                                        <input type="radio" name="option_<?php echo $value->id;?>" id="option_<?php echo $options->option_id; ?>" onclick="getDependentQuestion('<?php echo $value->c_id; ?>','<?php echo $value->id; ?>','<?php echo $options->option_id; ?>')" ><?php echo ucfirst($options->option_value); ?> 
                                    </div>
                          <?php }               
                            } 
                            else { echo "No options"; } ?>
                    </ul>
                </div>     
            </div>&nbsp;
            <button type="button" class="btn btn-primary pull-right prev-button" id="btnPrev" onclick="getPrevQuestion('<?php echo $value->id; ?>');" style="<?php echo $style1; ?>" >Prev</button>
        </div>
        
    <?php $i++; } ?>

<?php }else {
    echo "No questions"; 
}?>
