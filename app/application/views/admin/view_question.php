<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<script type="text/javascript">
$(document).ready(function() {
    
    addCategory();
    display_questions();    
    fetch_category_questions();
    display_category();
    
    $("#category_question_result").sortable({
        stop : function(event, ui){
        var data  = $(this).sortable('serialize' );      
        var cat_id = $("#category_result a.active").attr('id');  
      
        $.ajax({type:"POST",url:"<?php echo base_url();?>admin/question/sort_cat_ques/"+cat_id, data : data,
            success:function(data)
            {

            }
        });
        }
    });
  $("#category_question_result").disableSelection();

});

function addCategory()
{
    $.ajax({
                url : "<?php echo base_url();?>admin/question/addCategory",
                type: "POST",                        
                data :jQuery("#addCategory").serialize(),                        
                success: function(result) 
                {  
                    var data = $.parseJSON(result);
                    //console.log(data);
                    if(data.flag == 'success')
                    {
                         //alert(result);
                         $("#lblCatMsg").html(data.msg).css({color:'#3C8C8F','font-weight':'bold'});
                         $("#lblCatMsg").show();
                         setTimeout(function(){$("#lblCatMsg").fadeOut('slow');},2000);
                         $("#addCategory input").val("");
                         display_category();
                    }
                    else if(data.flag == 'error')
                    {
                        // alert(result);
                        $("#lblCatMsg").html(data.msg).css({color:'#f00','font-weight':'bold'});
                        $("#lblCatMsg").show();
                        setTimeout(function(){$("#lblCatMsg").fadeOut('slow');},2000);
                    }
                   

                }
            });       
    
}

function display_category()
{
    $.ajax({
                url : "<?php echo base_url();?>admin/question/category_listing",
                type: "POST",          
                success: function(result) 
                {   
                    $("#category_result").html('');
                    $("#category_result").html(result);	
                   
                }
            }); 
}

function display_questions()
{
    var cat_id = $("#category_result a.active").attr('id');  
    if($.isNumeric(cat_id)) 
    {
        cat_id = cat_id;
    }
    else
    {
        cat_id ='';
    }    
    $.ajax({
                url : "<?php echo base_url();?>admin/question/display_question",
                type: "POST",           
                data : { cat_id : cat_id},
                success: function(result) 
                {                   
                    $("#question_result").html('');
                    $("#question_result").html(result);	
                }
            });  
}

function category_questions(question_id)
{
    var cat_id = $("#category_result a.active").attr('id');    
    if($.isNumeric(cat_id) && question_id!=='')
    {
        $.ajax({
                url : "<?php echo base_url();?>admin/question/add_category_wise_questions",
                type: "POST",  
                data : { cat_id : cat_id, question_id : question_id },
                success: function(result) 
                {                   
                  if(result ==1)
                  {
                      fetch_category_questions(cat_id);
                  }
                }
            });  
    }
    else
    {
        bootbox.alert('Please select atleast one category!');
        return false;
    }
}

function fetch_category_questions(cat_id)
{
    if($.isNumeric(cat_id))
    {
        $.ajax({
                url : "<?php echo base_url();?>admin/question/view_category_wise_questions/1",
                type: "POST",  
                data : { cat_id : cat_id },
                success: function(result) 
                {                   
                  $("#category_question_result").html('');
                  $("#category_question_result").html(result);	
                  display_questions();
                }
            });  
    }
    else
    {
        $("#category_question_result").html('No records found');
    }
}

function delete_category_question(question_id)
{
    var cat_id = $("#category_result a.active").attr('id'); 
    if($.isNumeric(cat_id))
    {
        bootbox.confirm("Are you sure you want to delete this question?", function(result) 
        {
            if(result == true)
            {
                $.ajax({
                    url : "<?php echo base_url();?>admin/question/delete_category_question",
                    type: "POST",  
                    data : { cat_id : cat_id, question_id: question_id},
                    success: function(result) 
                    {     
                        if(result ==1){
                            $("#questionId-"+question_id).hide();
                            $("#questionId-"+question_id).addClass('active'); 
                            fetch_category_questions(cat_id);
                            display_questions();
                        }
                    }
                });  
            }
        });
    }
    
}


</script>



<style type="text/css">
label.error {
    color: red;
    font-weight: bold;
}
.scroll {
    min-height: 150px;    
    max-height: 200px;    
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
            <div class="panel panel-default" style="margin-top:20px;">
                <div class="panel-heading">
                    <h1 class="panel-title">Add Set</h1>  
                    <div style="margin-top:-20px;" class="pull-right">
                        <a href="<?php echo site_url('admin/question/viewQuestion'); ?>">
                            <button class="btn btn-xs btn-primary">Back</button>                  
                        </a>
                    </div>
                </div>
                
                <div class="panel-body">
                    <form class="form-inline" id="addCategory">
                        <div class="form-group">
                            <label for="exampleInputName2">Set Name</label>
                            &nbsp;&nbsp;<input type="text" class="form-control"name="category_name" id="category_name" placeholder="Enter Set Name" required="">
                        </div>                                 
                        <input type="hidden" id="orderList">
                        <button type="button" class="btn btn-primary" onclick="addCategory();">Add</button>
                    </form>
                    <p id="lblCatMsg" style="display: none; margin-top:10px;"></p>
                </div>
            </div>
            
            
             <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-2 scroll">                                  
                        <div class="list-group" id="category_result"></div>
                    </div>

                    <div class="col-md-10 scroll" id="accordion">
                        <ul class="list-group" id="question_result"></ul>
                    </div> 
                </div>
             </div>
            
             <div class="panel panel-default">
                <div class="panel-body">                  
                    
                    <div class="col-md-12 scroll" id="category_question">
                        <ul class="list-group" id="category_question_result">
                          
                        </ul>
                        
                    </div> 
                   
                </div>
             </div>
        </div> 
        
        
        
    </div>                           
</div>