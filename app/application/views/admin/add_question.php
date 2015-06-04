<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-2">
            <?php  $this->view('admin/include/sidebar'); ?>
        </div>
        
        <div class="col-md-10">
            <h3>Questions</h3>
            <div class="alert alert-success" style="display: none; " id="show_msg">
                    Information has been saved successfully.
            </div>
            <div class="panel panel-default" style="margin-top:20px;">
                <div class="panel-heading">
                    <h1 class="panel-title">Add Question</h1>
                    <div class="pull-right" style="margin-top:-20px;">
                        <a href="<?php echo base_url();?>admin/question/questionList"><button type="button" class="btn btn-xs btn-primary">View Questions</button></a>                        
                    </div>
                </div>
                
                <div class="panel-body">
                    <form id="surveyForm" class="form-horizontal" method="post">
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Question</label>
                            <div class="col-xs-5">
                                <input type="text" class="form-control" name="question" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label">Options</label>
                            <div class="col-xs-5">
                                <input type="text" class="form-control" name="option[]" />
                            </div>

                            <div class="col-xs-4">
                                <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <!-- The option field template containing an option field and a Remove button -->
                        <div class="form-group hide" id="optionTemplate">
                            <div class="col-xs-offset-3 col-xs-5">
                                <input class="form-control" type="text" name="option[]" />
                            </div>

                            <div class="col-xs-4">
                                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-5 col-xs-offset-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    
                
                    
                </div>
            </div>
            <div class="panel panel-default" style="margin-top:20px;">
                <div class="panel-heading">
                    <h1 class="panel-title">Question List</h1>
                </div>
                
                <div class="panel-body scroll">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="list-group" id="question_result"></div>
                    </div>
                </div> 
            </div>
        </div>      
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/formValidation.min.js"></script>   
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap1.min.js"></script>   
<script>
$(document).ready(function() {
    // The maximum number of options
    var MAX_OPTIONS = 20;
    display_questions();

    $('#surveyForm').formValidation({
            framework: 'bootstrap',
          
            fields: {
                question: {
                    validators: {
                        notEmpty: {
                            message: 'The question required and cannot be empty'
                        }
                    }
                },
                'option[]': {
                    validators: {
                        notEmpty: {
                            message: 'The option required and cannot be empty'
                        },
                        stringLength: {
                            max: 100,
                            message: 'The option must be less than 100 characters long'
                        }
                    }
                }
            }            
        })
        
               
         .on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();                
           

            // Use Ajax to submit form data
            $.ajax({
                url: "<?php echo base_url();?>admin/question/addQuestion",
                type: 'POST',
                data: $("#surveyForm").serialize(),
                success: function(result) {
                    if(result==1)
                    {
                        $("#show_msg").show();
                        $("#show_msg").fadeOut(5000);
                        $("#surveyForm input").val("");
                        display_questions();
                    }
                }
            });
        })
        

        // Add button click handler
        .on('click', '.addButton', function() {
            var $template = $('#optionTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template),
                $option   = $clone.find('[name="option[]"]');

            // Add new field
            $('#surveyForm').formValidation('addField', $option);
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row    = $(this).parents('.form-group'),
                $option = $row.find('[name="option[]"]');

            // Remove element containing the option
            $row.remove();

            // Remove field
            $('#surveyForm').formValidation('removeField', $option);
        })

        // Called after adding new field
        .on('added.field.fv', function(e, data) {
            // data.field   --> The field name
            // data.element --> The new field element
            // data.options --> The new field options

            if (data.field === 'option[]') {
                if ($('#surveyForm').find(':visible[name="option[]"]').length >= MAX_OPTIONS) {
                    $('#surveyForm').find('.addButton').attr('disabled', 'disabled');
                }
            }
        })

        // Called after removing the field
        .on('removed.field.fv', function(e, data) {
           if (data.field === 'option[]') {
                if ($('#surveyForm').find(':visible[name="option[]"]').length < MAX_OPTIONS) {
                    $('#surveyForm').find('.addButton').removeAttr('disabled');
                }
            }
        });
});
function display_questions()
{
    $.ajax({
                url : "<?php echo base_url();?>admin/question/questionListing",
                type: "POST",                                                            
                success: function(result) 
                {                   
                    $("#question_result").html('');
                    $("#question_result").html(result);	
                }
            });  
}

function delete_question(question_id)
{
    bootbox.confirm("Are you sure you want to delete this question ?", function(result) 
    {
        if(result == true)
        { 
            $.ajax({
                        url : "<?php echo base_url();?>admin/question/delete_question",
                        type: "POST",    
                        data: {question_id :question_id},
                        success: function(result) 
                        {
                            if(result!='')
                            {
                                if($.isNumeric(result))
                                {
                                   $("#question_"+question_id).remove();
                                }
                                else
                                {
                                    bootbox.alert('Question is associated with <b>'+result+'</b> set and cannot be removed. ');
                                    return false;
                                }
                            }
                        }
                    });  
        }
    });
}

function delete_question_option(option_id,question_id)
{
    bootbox.confirm("Are you sure you want to delete this question option ?", function(result) 
    {
        if(result == true)
        { 
            $.ajax({
                        url : "<?php echo base_url();?>admin/question/delete_question_option",
                        type: "POST",    
                        data: {option_id:option_id ,question_id :question_id},
                        success: function(result) 
                        {
                            if(result!='')
                            {
                                if($.isNumeric(result))
                                {
                                    $("#option_"+option_id).remove();
                                }
                                else
                                {
                                    bootbox.alert('Question is associated with <b>'+result+'</b> set and cannot be removed.');
                                    return false;
                                }
                            }
                        }
                    });  
        }
    });
}

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
.scroll {    
    max-height: 250px;    
    overflow: auto;
    border: 1px solid #DDD;
    padding: 15px;
}
</style>