<?php /*
if(!empty($questions)) 
{   
    $i = 1;    
    foreach($questions as $row) 
    {
        $options = $this->question_model->get_option_by_question_id($row->id); ?>                 
        <li class="list-group-item">Question <?php echo $i; ?>: <?php echo ucfirst($row->question)." ?"; ?>
            <?php if($this->uri->segment(4)!= 1) { ?>
            <div class="pull-right"><button type="button" class="btn btn-xs btn-primary" onclick="category_questions('<?php echo $row->id; ?>');">ADD</button></div>
            <?php } ?>
            <ul style="text-align: left;">
                <?php if(!empty($options)) 
                { 
                    foreach ($options as $options) 
                    {?>
                        <li><?php echo ucfirst($options->option_value); ?></li>
                    <?php }               
                }?>
            </ul>
        </li> 
        <br/>
<?php  $i++;  } } else { 
    echo "No questions";
} */ ?>
<link href="<?=base_url()?>css/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?=base_url()?>css/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

<script src="<?=base_url()?>css/DataTables/media/js/jquery.dataTables.js"></script>
<script src="<?=base_url()?>css/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<script>
    var oTable;
  $(document).ready(function() {
      
    oTable = $('#dataTables-example').DataTable({
                "bDestroy" : true, //<-- add this option
                responsive: true ,
                "bInfo" : false,
                "columnDefs": [{"targets": [2], "orderable": false }],
        });
    });
</script>
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr>                  
            <th>S.No</th>
            <th>Question</th>                  
            <th>Action</th>
        </tr>
    </thead>              
    <tbody id="companyTbody">
        <?php   if(!empty($questions))
                {
                    $i=1;
                    foreach($questions as $row)
                    {
                         $options = $this->question_model->get_option_by_question_id($row->id); ?>
                       
                        <tr id="question_<?php echo $row->id; ?>">
                          <td><?php echo $i; ?></td>
<!--                          <td><?php //echo $row->question; ?></td>-->
                          <td>
                               
                                    
                                        <a style="color: #333;" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>"><?php echo ucfirst($row->question);?> ?</a>                                       
                                  
                                
            <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">       
                    <ol style="list-style-type: lower-alpha;">
                        <?php if(!empty($options)) {                                    
                                foreach ($options as $options) {?>
                                    <li id="option_<?php echo $options->option_id; ?>"><?php echo ucfirst($options->option_value); ?>                                        
                                    </li>                                      
                                <?php }   
                            } else { echo "no options"; }?>
                    </ol>
                </div>
            </div>
        </td>
                          <td><a href="javascript:void(); "type="button" class="" onclick="category_questions('<?php echo $row->id; ?>');">ADD</a></td>
                        </tr>
              <?php $i++; }    
                }
                else {?>
                    <tr><td colspan="3">No record found!</td></tr>
                <?php } ?>
              </tbody>
            </table>

