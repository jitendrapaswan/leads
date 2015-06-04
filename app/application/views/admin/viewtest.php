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

<script type="text/javascript">
$(document).ready(function() {
var cat_id = $("#setname").val();
getCategoryQuestions(cat_id);
$(".prev-button").hide();
});

// Display category wise test questions
function getCategoryQuestions(cat_id)
{
    var user_id = $("#user_id").val();
    $.ajax({
                url : "<?php echo base_url();?>admin/test/getCategoryQuestions",
                type: "POST",    
                data : { cat_id : cat_id},
                success: function(result) 
                {   
                    $("#test").html('');
                    $("#test").html(result);
                }
            }); 
}

// Used to get Dependent question id by option
function getDependentQuestion(cat_id,question_id,option_id)
{
    var user_id = $("#user_id").val();
    if(user_id!='') {
    $.ajax({
                url : "<?php echo base_url();?>admin/test/getDependentQuestion",
                type: "POST",    
                data : {cat_id : cat_id, question_id : question_id, option_id : option_id, user_id:user_id},
                success: function(result) 
                { 
                    if(result!=0)
                    {
                        $("#question_"+question_id).hide();
                        $("#question_"+result).show();
                    }
                    else
                    {
                        $("#test").text("no result");
                    }
                }
            }); 
    }
}

function getPrevQuestion(current_qid)
{
    $.ajax({
                url : "<?php echo base_url();?>admin/test/getPreviousQuestion",
                type: "POST",    
                data : {question_id : current_qid },
                success: function(result) 
                { 
                    var data = $.parseJSON(result);
                    //console.log(data.prevQid);
                    if(data.length!=0)
                    {
                        //console.log()
                        $("#question_"+current_qid).hide();
                        $("#question_"+data.prevQid).show();
                        //$("input[name=option_"+data.prevQid+"]").removeAttr('checked');
                        $("#option_"+data.prevOid).attr('checked',true);
                    }
                    else
                    {
                        $("#test").text("no result");
                    }
                }
            }); 
}
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php  $this->view('admin/include/sidebar'); ?>
        </div>
        
        <div class="col-md-10">
            <h3>Test</h3>                  
            <div class="panel panel-default" style="margin-top:20px;">
                <div class="panel-heading">
                    <h1 class="panel-title">Set</h1>                      
                </div>
                
                <div class="panel-body">
                    <form class="">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">User Id</label>
                            <input type="text" class="form-control" id="user_id" placeholder="User Id" name="user_id" value="2" readonly="">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="exampleInputFile">Set</label>
                            <select class="form-control" name="setname" onchange="getCategoryQuestions(this.value)" id="setname">
                                <option value="">--Select Set--</option>
                                <?php if(!empty($setInfo)) {
                                        foreach($setInfo as $row) {?>
                                            <option value="<?php echo $row->c_id; ?>"><?php echo $row->category_name; ?></option>
                                  <?php }
                                }?>
                            </select>               
                        </div>
                    </form>
                                    </div>
            </div>
            
            <div class="panel panel-default" style="margin-top:20px;">
                <div class="panel-heading">
                    <h1 class="panel-title">Test</h1>                      
                </div>
                
                <div class="panel-body" id="test">
                    
                </div>     
            </div>
        </div>
    </div>
</div>                          