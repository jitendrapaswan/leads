
<?php  $this->view('admin/include/header_menu'); ?>
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
                "order": [[1, 'desc']],   
                "columnDefs": [{"targets": [0,8,9], "orderable": false }],
               
        });
    });
</script>
<div class="container-fluid" style="padding-left:15px;padding-right:15px;">
<div class="row"> 
  <div class="col-md-2">
    <?php  $this->view('admin/include/sidebar'); ?>   
  </div>     
  <div class="col-md-10"> 
    <?php $this->view('admin/include/admin_dashboard_menu'); ?> 
    <?php $this->view('include/messages'); ?>
    <div class="clearfix" style="margin-top:20px;display:none;" id="msg">
          <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Company has been deleted successfully.</div>
    </div>                
    <div class="panel panel-default">
      <div class="panel-heading">
        Company List
        <div class="pull-right"><button type="button" class="btn btn-danger btn-xs" id="delcompany">Delete</button></div>
      </div>

       <div class="panel-body">
          <div class="dataTable_wrapper">
          <form name="companyform" id="companyform">    
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th><input type="checkbox" name="selectall" id="selectall"></th>
                  <th>Company Name</th>
                  <th>Website</th>
                  <th>Company Progress</th>
                  <th>Customer Target</th>
                  <th>Company Type</th>
                  <th>Development Plans</th>
                  <th>Rating</th>
                  <th>Status</th>
                  <th>Edit</th>
                </tr>
              </thead>              
              <tbody id="companyTbody">
                <?php
                  if(!empty($companies))
                  {
                    foreach($companies as $company)
                      { ?>
                        <tr id="company_<?php echo $company->id; ?>">
                          <td>&nbsp;&nbsp;<input type="checkbox" name="company_id[]" id="company_id" value="<?php echo $company->id; ?>"></td>
                          <td><?php echo $company->CompanyName; ?></td>
                          <td><?php echo $company->CompanyWebsite;?></td>
                          <td><?php echo substr($company->CompanyProgress,0,25);  if(strlen($company->CompanyProgress)> 25)  { echo '..'; } ?></td>
                          <td><?php echo ucfirst($company->CompanyType);?></td>
                          <td><?php echo substr($company->CustomerTarget,0,25);   if(strlen($company->CustomerTarget)> 25)   { echo '..'; } ?></td>
                          <td><?php echo substr($company->DevelopmentPlans,0,25); if(strlen($company->DevelopmentPlans)> 25) { echo '..'; }?></td>
                          <td align="center"><?php echo !empty($company->CompanyRating) ? $company->CompanyRating : 0; ?></td>                                          
                          <td>
                            <select class="form-control" id="status_<?php echo $company->id ?>" name="Title" placehoder="Title" style="width:135px;" onchange="change_status(this.value,'<?php echo $company->id ?>');" current_status ="<?php echo $company->investment_status; ?>">
                              <option <?php if($company->investment_status =="Not Available") { echo "selected='selected'"; } ?> value="Not Available">Not Available</option>
                              <option <?php if($company->investment_status =="Approved") { echo "selected='selected'"; } ?> value="Approved">Approved</option>
                              <option <?php if($company->investment_status =="Waiting") { echo "selected='selected'"; } ?> value="Waiting">Waiting</option>
                              <option <?php if($company->investment_status =="Not Approved") { echo "selected='selected'"; } ?> value="Not Approvedd">Not Approved</option>
                            </select>
                          </td>
                          <td><a href ="<?php echo base_url();?>admin/partner/editCompanyDetail/<?php echo $company->id;?>"><button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i></button></a></td> 
                        </tr>
                    <?php }    
                  }
                  else 
                  {?>
                    <tr><td colspan="9">No record found!</td></tr>
                  <?php } ?>
              </tbody>
            </table>
            </form>          
        </div>
      </div>
    </div>            
  </div>
</div>
</div>
<script type="text/javascript">
function change_status(val,company_id)
{       
    bootbox.confirm("Are you sure you want to change the status?", function(result) 
    {
        if(result == true && val!='')
        {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url();?>admin/company/change_status", 
                data: { status : val,company_id :company_id},
                success: function(result)
                {
                      if(result!='')
                      {
                        $("#status_"+company_id).val(result);
                      }
                }
            });
        }        
        else
        {
            $("#status_"+company_id).val($("#status_"+company_id).attr('current_status'));
        }
    });
}



$(function () {
     $('input#selectall').on('click', function(){
        var re = $('input#selectall:checked').length, checkbox = $('input#company_id');  
        re == 1 ? checkbox.prop('checked', true) : checkbox.prop('checked', false);
    });
    
    $('#delcompany').on('click', function(){
        var u = $('input#company_id:checked').length;        
        if(u > 0)
        {
            bootbox.confirm("Are you sure you want to delete company ?", function(result) 
            {
                if(result == true)
                {  
                  jQuery.post("<?php echo base_url();?>admin/company/delete_company",jQuery("#companyform").serialize(),function(result)
                  {                   
                    if(result = 1)
                    {
                      //jQuery("#company_"+company_id).hide();                      
                      //window.location.reload();
                      $('#msg').show();
                      load_company_data();
                    }
                  });  
                 
                }
            });
        }
        else
        {
            bootbox.alert('Please select atleast one user!');
            return false;
        }
            
    });
    
    function load_company_data()
    {
        $.ajax({ type:"POST", url:"<?php echo site_url('admin/company/load_company_data');?>", data:{}, 
                 success:function(data)
                 {
                     $("#companyTbody").html(data);
                     //oTable.draw();
                     //$('.dataTables-example').DataTable('update');
                 }
        });     
    }
});
</script>