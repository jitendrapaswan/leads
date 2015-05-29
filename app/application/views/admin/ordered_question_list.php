<script type="text/javascript">
$(document).ready(function() {    
    category_questions(<?php echo $this->uri->segment(4); ?>);        
    //test(<?php echo $this->uri->segment(4); ?>);
    $(".lbl-category").click(function(){
        $(".active").removeClass("active");
        $(this).addClass("active");
    });
    $("#option").click(function(){
        alert($("#option").attr("question_id"));
        
    });
    
    
});

function category_questions(cat_id)
{
    if($.isNumeric(cat_id)) 
    {
        cat_id = cat_id;
    }   
    $.ajax({
        url : "<?php echo base_url();?>admin/question/sorted_category_questions/1",
        type: "POST",           
        data : { cat_id : cat_id},
        success: function(result) 
        {                   
            $("#question_result").html('');
            $("#question_result").html(result);	
        }
    }); 
}

function option_based_question(question_id)
{
    var option_id = $('input[name=option]:checked').val();     
    var currentQuestionCount = $("#question_"+question_id).attr('count');              
    currentQuestionCount++;
    var nxtQuestion_id = $('[count='+currentQuestionCount+']').attr("question_id");
    if($.isNumeric(nxtQuestion_id)) {
        nxtQuestion_id = nxtQuestion_id;
    } else {
        nxtQuestion_id ='';
    }
    currentQuestionCount++;
    var totalQuestionsCount = $('.check').length;    
    output =   '<option value="">Select</option>';  
    output+=   '<option value="'+nxtQuestion_id+'">Next</option>';  
    for (var i = currentQuestionCount; i<=totalQuestionsCount; i++)
    {  
        ddQuestion_id = $('[count='+i+']').attr("question_id");
        output+= '<option value="'+ddQuestion_id+'">'+i+'</option>';
    }
    $(".dropdown_"+question_id).html(output);
}

function addDependentQuestion(question_id,option_id,dependent_question)
{
    $.ajax({
        url : "<?php echo base_url();?>admin/question/insertDependentQuestionOnOption",
        type: "POST",           
        data : { question_id : question_id,option_id :option_id, dependent_question:dependent_question},
        success: function(result) 
        {                   
           if(result == 1)
           {
               console.log("suceess");
           }
        }
    }); 
    
}

function test(cat_id)
{
    $.ajax({
        url : "<?php echo base_url();?>admin/question/getDependencyQuestion",
        type: "POST",           
        data : { cat_id : cat_id},
        success: function(result) 
        {       
            //var data = $.parseJSON(result);
           // $.each(users.data,function(key,val)
            //{
                $(".dropdown_3").val(2);
           // }            
        }
    }); 
}
</script>



<style type="text/css">
label.error {
    color: red;
    font-weight: bold;
}
.scroll {
    min-height: 150px;    
    max-height: 500px;    
    overflow: auto;
    border: 1px solid #DDD;
    padding: 15px;
}
</style>
<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-2">
            <?php  $this->view('admin/include/sidebar'); ?>
        </div>
        
        <div class="col-md-10">
            <h3>Question List</h3>      
            <div class="alert alert-success" style="display: none; " id="show_msg">
                    Information has been saved successfully.
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">View Questions</h1>                    
                </div>
                
                <div class="panel-body">
                    <div class="col-md-2">                                  
                    <?php 
                            if(!empty($category))
                            {
                                foreach ($category as $row) 
                                {
                                    if($this->uri->segment(4)== $row->c_id) {
                                        $class = "active";
                                    }
                                    else {
                                        $class = "";
                                    }
                                    ?>
                                    <a href="javascript:void(0);" class="list-group-item lbl-category <?php echo $class; ?>" id="<?php echo $row->c_id; ?>" onclick="category_questions('<?php echo $row->c_id; ?>');"><?php echo !empty($row->category_name) ? $row->category_name : ""; ?></a>
                          <?php }     
                            } 
                            else 
                            {?>
                                <li class="list-group-item">No categories available.</li>
                      <?php }?>
                    </div>

                    <div class="col-md-10 scroll" id="question">
                         <div class="bs-example">
                            <div class="panel-group" id="accordion">
                                <div id="question_result">
                          
                                </div>
                            </div>
                         </div>
                    </div> 
                </div>
             </div>
            
            
        </div> 
        
        
        
    </div>                           
</div>