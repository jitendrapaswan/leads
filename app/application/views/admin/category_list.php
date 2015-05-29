<script type="text/javascript">
$(document).ready(function() {
$(".lbl-category").click(function(){
        $(".active").removeClass("active");
        $(this).addClass("active");
    });
});
</script>
<style>
#category_result > div.cat-action {
  float: right;
  position: relative;
  top: -33px;
  width: 22%;
  z-index: 9;
}
</style>
<?php 
if(!empty($category))
{
    foreach ($category as $row) 
    {?>
        <a href="javascript:void(0);" class="list-group-item lbl-category " id="<?php echo $row->c_id; ?>" onclick="fetch_category_questions('<?php echo $row->c_id; ?>');">
            
            <label class="cat-label" id="catLabel_<?php echo $row->c_id; ?>"><?php echo !empty($row->category_name) ? $row->category_name : ""; ?></label>
            
        </a>
        <div class="cat-action">
            <a class="badge" style="background:none; color: #000; padding: 0;" href="javascript:void(0);" onclick="show_category(<?php echo $row->c_id; ?>,'<?php echo $row->category_name; ?>');"><i class="fa fa-pencil"></i></a>
            <a class="badge" style="background:none; color: #000; padding: 0;" href="javascript:void(0);" onclick="delete_category(<?php echo $row->c_id; ?>);"><i class="fa fa-trash"></i></a>
        </div>
        
    <?php }     
} 
else 
{?>
    <li class="list-group-item">No categories available.</li>
<?php }?>

<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="myCatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Set Edit</h4>
      </div>
      <div class="modal-body">
          <div class="row">
                <div class="col-md-12">
                      <form id="frmCategory" method="post">
                          <label >Set Name</label>
                          <input type="text" class="form-control" name="txtCatName" id="txtCatName" value="">
                          <input type="hidden" name="txtCatId" id="txtCatId" value="">
                          <label id="lblErrorMsg"></label>
                      </form>

                </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="edit_category();">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="myCatDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
<!--      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Set Edit</h4>
      </div>-->
      <div class="modal-body">
          <div class="row">
                <div class="col-md-12">
                    <label id="lblDeleteMsg"></label>
                </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
    
<script>
   
function show_category(catId,catName)
{
    //alert(catId);
    $("#myCatModal .modal-body #txtCatName").val(catName);
    $("#myCatModal .modal-body #txtCatId").val(catId);
    $("#myCatModal").modal('show');
}

function edit_category()
{
    var formdata = $("#frmCategory").serialize();
    //console.log(formdata);
    $.ajax({ type:"POST", url:"<?php echo site_url('admin/question/edit_category'); ?>", data:formdata,
             success:function(data)
             {
                 var newdata = $.parseJSON(data);
                 //console.log(newdata.flag);
                 if(newdata.flag == "success")
                 {
                     $("#lblErrorMsg").html(newdata.msg).css({color:'#3C8C8F'});
                     
                     setTimeout(function(){
                         $("#myCatModal").modal('hide');
                         display_category();
                     },1000);
                 }
                 else
                 {
                     $("#lblErrorMsg").html(newdata.msg).css({color:'#f00'});
                     return false;
                 }
             }
    });
}

function delete_category(catId)
{
   
    
    $.ajax({ type:"POST", url:"<?php echo site_url('admin/question/delete_category'); ?>", data:{catId:catId},
             success:function(data)
             {
                 var newdata = $.parseJSON(data);
                 //console.log(newdata.flag);
                 if(newdata.flag == "success")
                 {
                     $("#lblDeleteMsg").html(newdata.msg).css({color:'#3C8C8F'});
                     $("#myCatDeleteModal").modal('show');
                     setTimeout(function(){
                         $("#myCatDeleteModal").modal('hide');
                         display_category();
                     },1000);
                 }
                 else
                 {
                     $("#lblDeleteMsg").html(newdata.msg).css({color:'#f00'});
                     $("#myCatDeleteModal").modal('show');
                 }
             }
             
           });
}
</script>