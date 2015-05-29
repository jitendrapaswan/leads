<div class="container-fluid" style="padding:0;">
    <?php $this->view('include/header'); ?>     
</div>   

<link href="<?php echo base_url('css/bootstrap-datepicker.css'); ?>">
<script src="<?php echo base_url('js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('js/angular.js'); ?>"></script>

<div class="container-fluid">
    <div class="row"> 
        <div class="col-md-2">
            <?php $this->view('include/sidebar'); ?>  
        </div>     
        <div class="col-md-10">            
            <h3>Projects</h3>
            <?php $this->view('include/messages'); ?>
            <div class="panel panel-default" style="margin-top:20px;">
                <div class="panel-heading">
                    <h1 class="panel-title">Projects List</h1>
                </div>

                <div class="panel-body">
                    
                    <div ng-app="myApp" ng-controller="projectCtrl">
                      
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr style="" class="active">
                                <th><div class="checkbox" align="center"><label>#</label></div></th>
                                <th style="vertical-align: middle;">Project Name</th>
                                <th style="vertical-align: middle;">Company</th>
                                <th style="vertical-align: middle;">Start Date</th>
                                <th style="vertical-align: middle;">End Date</th>
                                <th style="vertical-align: middle;">Action</th>


                            </tr>
                        </thead>
                        <tbody id="projectTbody">
                            <?php
                                if(!empty($projectData))
                                {
                                    $count=0;
                                    foreach($projectData as $projectVal)
                                    {
                                        $count++;
                                    ?>
                                        <tr>
                                            <td align="center"><?php echo $count; ?></td>
                                            <td><?php echo $projectVal->project_name; ?></td>
                                            <td><?php echo $projectVal->company_name; ?></td>
                                            <td><?php echo $projectVal->start_date; ?></td>
                                            <td><?php echo $projectVal->end_date; ?></td>
                                            <td>
                                                <a href="<?php echo base_url();?>company/partner_notes/<?php echo $projectVal->project_id; ?>"><img src="<?php echo base_url();?>image/notes.png"></a>
                                            </td>
                                        </tr>
                                    <?php
                                    }    
                                } 
                                else 
                                {
                                    echo '<tr><td colspan="6">No record found !</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>

                <?php
                if (!empty($pagedata['pagination'])) {
                    echo '<div class="clearfix" style="text-align:center;">' . $pagedata['pagination'] . '</div>';
                }
                ?>
            </div>


        </div>

    </div>
</div>

<script type="text/javascript">
    
    
                    
    $().ready(function(){
    
            $("#txtStartDate,#txtEndDate").datepicker({format:'dd-mm-yyyy'});
            
    });
    
    function submit_project()
    {
        var formData = $("#frmAddProject").serialize();
        //console.log(formData);
        $.ajax({ type:"POST", url:"<?php echo site_url('project/projectadd'); ?>", data:formData,
                 success:function(result)   
                 {
                     var projectData=$.parseJSON(result);//console.log(data);
                     var i=0;
                     var projectTr='';
                     $.each(projectData.data,function(key,val){
                        
                        projectTr+='<tr><td><input type="checkbox" name="selectall" id="selectall"></td><td>'+val.project_name+'</td><td>'+val.company_name+'</td><td>'+val.start_date+'</td><td>'+val.end_date+'</td>\n\
                            <td><button onclick="get_project('+val.project_id+')" class="btn btn-primary" ><i class="fa fa-pencil"></i></button></td></tr>';
                        
                        i++;
                     });
                     
                     $("#projectTbody").html(projectTr);
                     $("#frmAddProject input,select,textarea").val("");
                 }
        });
    }
    
    var app = angular.module('myApp', []);
    app.controller('projectCtrl', function($scope,$http,$compile) {

        $scope.get_project=function (id)
        {
            $http({ method:"POST", url:"<?php echo site_url('project/getprojectdatabyid'); ?>", data:{id:id} }).
                     success(function(result)   
                     {
                        $scope.txtProjectName=result.data.project_name;
                        $scope.selCompany=result.data.company_id;
                        $scope.txtStartDate=result.data.start_date;
                        $scope.txtEndDate=result.data.end_date;
                        $scope.txtHours=result.data.hours;
                        $scope.txtLead=result.data.lead;
                        $scope.txtDescription=result.data.description;
                        $("#projectButtonDiv").html('<input type="hidden" id="hdnProjectId" value="'+result.data.project_id+'">\n\
                                                        <button onclick="edit_project('+result.data.project_id+')" class="btn btn-primary" >Update Project</button>\n\
                                                        <button onclick="reset_form()" class="btn btn-warning" >Reset</button>\n\
                                                    ');
                     }
            );
        }
       
    });
    
    function get_project(id)
    {
        $.ajax({ type:"POST", url:"<?php echo site_url('project/getprojectdatabyid'); ?>", data:{id:id}, 
                     success:function(result)   
                     {
                        result=$.parseJSON(result);
                        var projectData=result.data; 
                        //console.log(projectData.project_name);
                        $("#txtProjectName").val(projectData.project_name);
                        $("#selCompany").val(projectData.company_id);
                        $("#txtStartDate").val(projectData.start_date);
                        $("#txtEndDate").val(projectData.end_date);
                        $("#txtHours").val(projectData.hours);
                        $("#txtLead").val(projectData.lead);
                        $("#txtDescription").val(projectData.description);
                       
                        $("#projectButtonDiv").html('<input type="hidden" id="hdnProjectId" value="'+projectData.project_id+'">\n\
                                                    <button onclick="edit_project('+projectData.project_id+')" class="btn btn-primary" >Update Project</button>\n\
                                                    <button onclick="reset_form()" class="btn btn-warning" >Reset</button>\n\
                                                    ');
                     }
                     });
    }
    
    function edit_project(id)
    {
        var formData = $("#frmAddProject").serializeArray();
        //formData = formData.push({name:'projectId',value:id});
        //console.log(formData);
        $.ajax({ type:"POST", url:"<?php echo site_url('project/projectedit'); ?>/"+id, data:formData,
                 success:function(result)   
                 {
                     var projectData=$.parseJSON(result);//console.log(data);
                     var i=0;
                     var projectTr='';
                     $.each(projectData.data,function(key,val){
                        
                        projectTr+='<tr><td><input type="checkbox" name="selectall" id="selectall"></td>\n\
                                    <td>'+val.project_name+'</td>\n\
                                    <td>'+val.company_name+'</td>\n\
                                    <td>'+val.start_date+'</td>\n\
                                    <td>'+val.end_date+'</td>\n\
                                    <td><button onclick="get_project('+val.project_id+')" class="btn btn-primary" ><i class="fa fa-pencil"></i></button></td></tr>';
                        
                        i++;
                     });
                     
                     $("#projectTbody").html(projectTr);
                     $("#frmAddProject input,select,textarea").val("");
                     $("#projectButtonDiv").html('<button onclick="submit_project();" class="btn btn-primary" type="button">Add Project</button>');
                 }
        });
    }
    
    function reset_form()
    {
        $("#frmAddProject input,select,textarea").val("");
        $("#projectButtonDiv").html('<button onclick="submit_project();" class="btn btn-primary" type="button">Add Project</button>');
    }
    
</script>