<?php
if(!empty($questions))
{  
    $i = 1;   
    foreach($questions as $row)
    {
        $options = $this->question_model->get_option_by_question_id($row->id); ?>
        <div class="panel panel-default" id="question_<?php echo $row->id; ?>">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>"><?php echo $i; ?>. <?php echo ucfirst($row->question);?> ?</a>
                    <div class="pull-right"><i class="fa fa-trash-o" onclick="delete_question('<?php echo $row->id; ?>')" style="cursor:pointer;"></i></div>
                </h4>
            </div>
            <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">       
                    <ol style="list-style-type: lower-alpha;">
                        <?php if(!empty($options)) {                                    
                                foreach ($options as $options) {?>
                                    <li id="option_<?php echo $options->option_id; ?>"><?php echo ucfirst($options->option_value); ?>
                                        <div class="pull-right"><i class="fa fa-trash-o fa-fw" style="cursor: pointer;" onclick="delete_question_option('<?php echo $options->option_id; ?>','<?php echo $row->id; ?>');"></i></div>
                                    </li>                                      
                                <?php }   
                            } else { echo "no options"; }?>
                    </ol>
                </div>
            </div>
        </div>
    <?php $i++; }
 } else {
        echo "No questions";
     } ?>