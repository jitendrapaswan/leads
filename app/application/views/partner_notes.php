<style type="text/css">
label.error {
    color: red;
    font-weight: bold;
}
</style>
 <script type="text/javascript">
    setInterval("loadContent();",5000); 
    function loadContent(){
    	
      $('#main').load(location.href + ' #chat');
    }
  </script>


<div class="container-fluid" style="padding:0;">
   <?php $this->view('include/header'); ?>    
</div>   

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
          	<?php  $this->view('include/sidebar'); ?>   
        </div>
        <div class="col-md-10">
			<?php $this->view('include/messages'); ?>
			<div class="chat-panel panel panel-default" style="margin-top:20px;"> 
                <div class="panel-heading"><i class="fa fa-inbox fa-fw"></i> Inbox</div>                        
                <div id="main">
                <div class="panel-body" style="min-height:530px;" id="chat">
                    <ul class="chat">
                    	<?php if(!empty($message)) 
                    	{	
                            foreach ($message as $value) 
                            {
                            	if($value->sender_user_id == $value->receiver_user_id)
	                            	{?>                            
			                        <li class="right clearfix">                            
			                            <div class="chat-body clearfix">
			                                <div class="header">
			                                    <strong class="primary-font"><?php echo "me"; ?></strong>
			                                    <small class="pull-right text-muted"><i class="fa fa-clock-o fa-fw"></i><?php echo time_passed(strtotime($value->created_date)); ?></small>
			                                </div>
			                                <p><?php echo $value->message; ?></p>
			                            </div>
			                        </li>
			                    	<?php } elseif ($value->sender_user_id!= $this->session->userdata('user_id')) 
			                    	{
			                    		$name = $this->partner_model->getReceiverName($value->sender_user_id);
			                    		?>
			                    		<li class="right clearfix">                            
				                            <div class="chat-body clearfix">
				                                <div class="header">
				                                    <strong class="primary-font"><?php echo !empty($name->first_name) ? ucfirst($name->first_name).' '.ucfirst($name->last_name): "" ?></strong>
				                                    <small class="pull-right text-muted"><i class="fa fa-clock-o fa-fw"></i><?php echo time_passed(strtotime($value->created_date)); ?></small>
				                                </div>
				                                <p><?php echo $value->message; ?></p>
				                            </div>
			                        </li>			                        
			                    	<?php } 
		                		}
		                	} 
		                else 
		                {
		                	echo "No messages";
		                }?>
                    </ul>                    
                </div>                        
                </div>
                <div class="panel-footer">
                	<form role="form" method="post" action="<?php echo base_url(); ?>company/partner_notes">
	                    <div class="input-group">
	                        <input id="btn-input" class="form-control input-sm" placeholder="Type your message here..." type="text" name="message" id="message">
	                        <input type="hidden" name="project_id" value="<?php echo $this->uri->segment(3);?>">
	                        <span class="input-group-btn"><button class="btn btn-info" id="btn-chat"style="padding:4px;">Add</button></span>
	                    </div>
                    </form>
                </div>
            </div>   
		</div>
	</div>
</div>
 