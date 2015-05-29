<div class="row">
    <div class="col-md-12 col-sm-12">   
        <div class="navbar-default sidebar" role="navigation">  
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn"><button class="btn btn-default" type="button" style="padding:9px;"><i class="fa fa-search"></i></button></span>
                        </div>
                    </li>

                    <!-- side bar for km user -->
                    <?php if($this->session->userdata('role_id') == 2) {?>
                        <li><a href="<?php echo base_url();?>user/dashboard"><i class="fa fa-key fa-fw"></i> Dashboard</a></li>                    
                        <li><a href="<?php echo base_url();?>project/projectlist"><i class="fa fa-inbox fa-fw"></i> Project</a></li>
                        <li><a href="<?php echo base_url();?>user/change_password"><i class="fa fa-key fa-fw"></i> Change password</a></li>
                    <?php } ?>

                    <!-- sidebar for partner user -->
                    <?php if($this->session->userdata('role_id') == 4) {?>                                  
                        <li><a href="<?php echo base_url();?>project/projectlistpartneruser"><i class="fa fa-inbox fa-fw"></i> Project</a></li>
                        <li><a href="<?php echo base_url();?>company/partner_change_password"><i class="fa fa-key fa-fw"></i> Change password</a></li>
                    <?php } ?> 
                </ul>
            </div> 
        </div> 
    </div>
</div>           
    
          
            
  
            
      