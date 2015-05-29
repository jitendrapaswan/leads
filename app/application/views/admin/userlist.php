<script type="text/javascript">
$(document).ready(function(){	        
    $("#adduser").validate({        
    errorClass: "error",	
    rules: 
    {    
	    first_name: 
            {  
	        required: true
	    },
	    email: 
            {
	        required: true,
	        email: true,	        
	    },	   	
  	},
   	messages: 
   	{                  
            first_name : "Please enter first name.",
            email: {required:"Please enter email address.",email:"Please enter a valid email address." , remote:"Email already exist.Please change it." },
        },
        submitHandler: function(form) 
        {  
            $.ajax({
                        url : "<?php echo base_url();?>admin/user/add_user",
                        type: "POST",                        
                        data :jQuery("#adduser").serialize(),                        
                        success:function(result)
                        {
                            var users=$.parseJSON(result);                                             
                            var i       =1;
                            var userTr  ='';
                            $.each(users.data,function(key,val)
                            {
                                userTr+='<tr><td>'+i+'</td>\n\
                                    <td>'+val.first_name+'</td>\n\
                                    <td>'+val.last_name+'</td>\n\
                                    <td>'+val.email+'</td>\n\
                                    <td><button onclick="get_user('+val.id+')" class="btn btn-primary" type="button"><i class="fa fa-pencil"></i></button></td></tr>';
                        
                                i++;
                            });                     
                            $("#userTbody").html(userTr);
                            $("#show_msg").show();
                            $("#show_msg").fadeOut(5000);  
                            $("#adduser input").val("");
                        }
                });                     
        }

    });
});

function get_user(id)
{
    $.ajax({ 
            type:"POST", 
            url:"<?php echo site_url('admin/user/getuserdatabyid'); ?>", 
            data:{id:id}, 
            success:function(result)   
            {
                result=$.parseJSON(result);
                var userData=result.data;                         
                        $("#first_name").val(userData.first_name);
                        $("#last_name").val(userData.last_name);
                        $("#email").val(userData.email);                     
                        $("#userDiv").html('<input type="hidden" id="hdnUserId" value="'+userData.id+'">\n\
                                                    <button onclick="edit_user('+userData.id+')" class="btn btn-primary" type="button" >Update User</button>\n\
                                                    <button onclick="reset_form()" class="btn btn-warning" type="button" >Reset</button>\n\
                                                    ');
            }
        });
}

function edit_user(id)
{
    $.ajax({ 
            type:"POST", 
            url:"<?php echo site_url('admin/user/edit_user'); ?>/"+id, 
            data :jQuery("#adduser").serialize(),           
            success:function(result)
            {
                var users=$.parseJSON(result);                                             
                var i       =1;
                var userTr  ='';              
                $.each(users.data,function(key,val)
                {
                    userTr+='<tr><td>'+i+'</td>\n\
                        <td>'+val.first_name+'</td>\n\
                        <td>'+val.last_name+'</td>\n\
                        <td>'+val.email+'</td>\n\
                        <td><button onclick="get_user('+val.id+')" class="btn btn-primary" type="button" ><i class="fa fa-pencil"></i></button></td></tr>';

                    i++;
                });                     
                $("#userTbody").html(userTr);
                $("#projectButtonDiv").html('<button type="submit" class="btn btn-primary>Add User</button>');
                $("#adduser input").val("");
                $("#show_msg").show();
                $("#show_msg").fadeOut(5000);  
            }
            
    });
}

function reset_form()
{
    $("#adduser input").val("");
    $("#userDiv").html('<button type="submit" class="btn btn-primary" type="button">Add user</button>');
}
</script>
<style type="text/css">
label.error {
    color: red;
    font-weight: bold;
}
</style>
<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-2">
            <?php  $this->view('admin/include/sidebar'); ?>
        </div>
        
        <div class="col-md-10">
            <h3>Users</h3>
            <div class="alert alert-success" style="display: none; " id="show_msg">
                    Information has been saved successfully.
            </div>
            <div class="panel panel-default" style="margin-top:20px;">
                <div class="panel-heading">
                    <h1 class="panel-title">Add Users</h1>
                </div>
                
                <div class="panel-body">
                    <form role="form" id="adduser">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                            </div>	

                            <div class="form-group col-md-4">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                            </div>	

                            <div class="form-group col-md-4">
                                <label for="email">Email</label>
                                <input type="email" class="form-control"  id="email" name="email" placeholder="Email">
                            </div>
                        </div>
                        
                        <div id="userDiv">
                            <input type="hidden" name="hdnMode" value="add">
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </div>                           	       
                    </form>
                    
                    <table class="table table-bordered table-hover" style="margin-top:20px;">
                        <thead>
                            <tr style="" class="active">
                                <th>#</th>
                                <th style="vertical-align: middle;">First Name</th>
                                <th style="vertical-align: middle;">Last Name</th>
                                <th style="vertical-align: middle;">Email</th>
                                <th style="vertical-align: middle;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="userTbody">
                           <?php if(!empty($users))
                            {
                               $i=1;
                                foreach($users as $user)
                                { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>  
                                        <td><?php echo !empty($user->first_name) ? $user->first_name : ""; ?></td>  
                                        <td><?php echo !empty($user->last_name)  ? $user->last_name  : ""; ?></td>  
                                        <td><?php echo !empty($user->email)      ? $user->email      : ""; ?></td>  
                                        <td><button onclick="get_user('<?php echo $user->id; ?>')"class="btn btn-primary" ><i class="fa fa-pencil"></i></button></td>  
                                    </tr>  
                                   
                          <?php  $i++; } 
                        } 
                        else {?>
                              <tr><td colspan="5" id="no">No records found!</td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
