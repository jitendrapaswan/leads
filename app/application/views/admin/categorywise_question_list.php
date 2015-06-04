<?php if(!empty($questions)) 
{   
    $i = 1;    
    foreach($questions as $row) 
    {?>
        <li class="list-group-item cat" id ="questionId-<?php echo $row->question_id;?>">Question <?php echo $i; ?>: <?php echo ucfirst($row->question)." ?"; ?> 
            <div class="pull-right"><i class="fa fa-trash-o fa-fw" onclick="delete_category_question('<?php echo $row->question_id;?>');" style="cursor:pointer;"></i></a>    
</div>    
        

            
            
        </li>         
<?php  $i++;  } ?>
            <br/>
            <div align="center"><a href="<?php echo base_url(); ?>admin/question/ordered_category_question_list/<?php echo $cat_id; ?>"><button type="button" class="btn btn-xs btn-primary" >GO</button></a></div>

<?php     } else {
    echo "No questions found.";
}
?>


