<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">    
    <title>Partner Alliance</title>    

    <base href="<?php echo base_url();?>"/>
    <link href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>css/sb-admin-2.css" rel="stylesheet">  
    <link href="<?=base_url()?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.9.1.min.js"></script>  
    <script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>

</head>
<body>
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a style="margin-top: -8px;" class="navbar-brand" href="#"><img src="<?=base_url()?>image/adminlogo.png"></a>
        </div>
        
        <ul class="nav navbar-top-links navbar-right">                
            <li><?=ucfirst($this->session->userdata('first_name')).' '.ucfirst($this->session->userdata('last_name'))?></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                    <li class="divider"></li>
                    <?php if($this->session->userdata('role_id') == 2)
                    {?>
                        <li><a href="<?php echo base_url(); ?>user/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>                        
              <?php } 
                    elseif ($this->session->userdata('role_id') == 4) 
                    {?>
                        <li><a href="<?php echo base_url(); ?>company/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>  
                    <?php } ?>
                    
                </ul>
            </li>
        </ul>
    </nav>
