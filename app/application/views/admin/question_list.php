<?php 
if(!empty($questions)) 
{   
    $i = 1;    
    foreach($questions as $row) 
    {
        $options = $this->question_model->get_option_by_question_id($row->id); ?>                 
        <li class="list-group-item">Question <?php echo $i; ?>: <?php echo ucfirst($row->question)." ?"; ?>
            <?php if($this->uri->segment(4)!= 1) { ?>
            <div class="pull-right"><button type="button" class="btn btn-xs btn-primary" onclick="category_questions('<?php echo $row->id; ?>');">ADD</button></div>
            <?php } ?>
            <ul style="text-align: left;">
                <?php if(!empty($options)) 
                { 
                    foreach ($options as $options) 
                    {?>
                        <li><?php echo ucfirst($options->option_value); ?></li>
                    <?php }               
                }?>
            </ul>
        </li> 
        <br/>
<?php  $i++;  } } else { 
    echo "No questions";
}?>

