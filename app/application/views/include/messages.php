<?php
if($this->session->flashdata('message')){
    echo '<div class="clearfix" style="margin-top:20px;"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$this->session->flashdata('message').'</div></div>';
}

if(validation_errors()){
?>
<div class="clearfix" style="margin-top:20px;"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo validation_errors();?></div></div>

<?php
}

if($this->session->flashdata('error')){
    
    echo '<div class="clearfix" style="margin-top:20px;"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$this->session->flashdata('error').'</div></div>';
}
if($this->session->flashdata('info')){
    
    echo '<div class="clearfix" style="margin-top:20px;"><div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$this->session->flashdata('info').'</div></div>';
}
// msg div ends

?>