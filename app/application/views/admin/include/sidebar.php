 <div class="navbar-default sidebar" role="navigation">  
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                    <!-- /input-group -->
            </li>
            
            <li><a href="<?=site_url('admin/partner/dashboard')?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>                         
            <li><a href="<?=site_url('admin/partner/dashboardusers')?>"><i class="fa fa-table fa-fw "></i> Alliance Request</a></li>  
            <li><a href="<?=site_url('admin/question')?>"><i class="fa fa-question-circle"></i> Questions</a></li>
            <li><a href="<?=site_url('admin/user')?>"><i class="fa fa-users"></i> Users</a></li>   
         <!--   <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> User Management<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                           <li><a href="<?=site_url('admin/user/userlist')?>">All Users</a></li>
                           <li><a href="<?=site_url('admin/user/adduser')?>">Add User</a></li>
                    </ul>
                             /.nav-second-level 
            </li>-->
        </ul>
    </div>
</div>

<?php /* if($this->uri->segment(2)!='user') { ?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-default notifiaction-panel">
            <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> Notifications Panel
            </div>
                    <!-- /.panel-heading -->
            <div class="panel-body" style="padding: 9px!important;">
                <div class="list-group" >
                    <a href="<?=site_url('admin/partner/newcomments') ?>" class="list-group-item" style="padding: 10px 2px !important; font-size:11px;">
                        <i class="fa fa-comment fa-fw"></i> <?= $allComment;  ?> New Comment
                        <span class="pull-right text-muted small"><em><?php if(!empty($getRecentCommentTime)) { echo time_passed(strtotime($getRecentCommentTime)); }?></em></span>
                    </a>                                                          
                    
                    <a href="<?=site_url('admin/partner/newtasks') ?>" class="list-group-item" style="padding: 10px 2px !important;font-size:11px;">
                        <i class="fa fa-tasks fa-fw"></i> <?= $newtasks ?> New Task
                        <span class="pull-right text-muted small"><em><?php if(!empty($newTaskLastUpdatedTime)) { echo time_passed(strtotime($newTaskLastUpdatedTime)); } ?></em></span>
                    </a>                                                                                          
                    
                    <a href="<?=site_url('admin/partner/neworders') ?>" class="list-group-item" style="padding: 10px 2px !important;font-size:11px;">
                        <i class="fa fa-shopping-cart fa-fw"></i> <?= $neworders ?> New Order 
                        <span class="pull-right text-muted small"><em><?php if(!empty($newOrderLastUpdatedTime)) { echo time_passed(strtotime($newOrderLastUpdatedTime)); } ?></em></span>
                    </a>                               
                </div>
                    <!-- /.list-group -->
                <a href="<?=site_url('admin/partner/dashboardusers') ?>" class="btn btn-default btn-block">View All Alerts</a>
            </div>
                <!-- /.panel-body -->
        </div><!-- /.panel -->
    </div>         
</div>
<?php } */?>