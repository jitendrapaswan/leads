<script type="text/javascript">
$(document).ready(function() {
$(".lbl-category").click(function(){
        $(".active").removeClass("active");
        $(this).addClass("active");
    });
});
</script>
<?php 
if(!empty($category))
{
    foreach ($category as $row) 
    {?>
        <a href="javascript:void(0);" class="list-group-item lbl-category " id="<?php echo $row->c_id; ?>" onclick="fetch_category_questions('<?php echo $row->c_id; ?>');"><?php echo !empty($row->category_name) ? $row->category_name : ""; ?></a>
    <?php }     
} 
else 
{?>
    <li class="list-group-item">No categories available.</li>
<?php }?>