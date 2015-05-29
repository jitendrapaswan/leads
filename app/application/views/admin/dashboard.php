<?php  $this->view('admin/include/header_menu'); ?> 

<link href="<?=base_url()?>css/morrisjs/morris.css" rel="stylesheet">
   
<script src="<?=base_url()?>css/raphael/raphael-min.js"></script>
<script src="<?=base_url()?>css/morrisjs/morris.min.js"></script>

<div class="container-fluid" style="padding-left:15px;padding-right:15px;">
    <div class="row"> 
        <div class="col-md-2">
                <?php  $this->view('admin/include/sidebar'); ?>   
             </div>     
             <div class="col-md-10"> 
               <?php    $this->view('admin/include/admin_dashboard_menu');
                        $this->view('include/messages');
                ?>
                <div class="col-lg-4 col-md-5" id="area" style="padding-left: 0;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Company Progress Chart                            
                            <div class="pull-right">
                                 <i class="fa fa-expand" onclick="expand_div(1);" style="cursor:pointer;" id="e1"></i>
                                <div class="btn-group" id="action1" style="display:none;">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="javascript:void(0);">Approved Investments</a></li>
                                        <li><a href="javascript:void(0);">Not Approved Investments</a></li>
                                    </ul>
                                </div>

                                <div class="pull-right" id="minimize1" style="cursor:pointer;display:none;"><a href=""><i class="fa fa-minus"></i></a></div>
                            </div>

                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="padding: 0px 15px 0px;">
                            <div id="area-example"></div>
                            
                        </div>
                    </div> 
                </div>
                
                <div class="col-lg-4 col-md-5" id="bar" style="padding-left: 0;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Company Progress Chart
                            <div class="pull-right">
                                 <i class="fa fa-expand" onclick="expand_div(2);" style="cursor:pointer;" id="e2"></i>
                                <div class="btn-group" id="action2" style="display:none;"> 
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="javascript:void(0);" onclick="barGraphMonthlyInvestment(1)">Approved Investments</a></li>
                                        <li><a href="javascript:void(0);" onclick="barGraphMonthlyInvestment(2)">Not Approved Investments</a></li>
                                    </ul>
                                 </div>
                                <div class="pull-right" id="minimize2" style="cursor:pointer;display:none;"><a href=""><i class="fa fa-minus"></i></a></div>
                            </div>
                        </div>

                        <div class="panel-body" style="padding: 0px 15px 0px;">
                            <div id="bar-example"></div>
                        </div>
                        <!-- /.panel-body -->
                    
                    <!-- /.panel -->
                </div> 
            </div>  

             <div class="col-lg-4 col-md-5" id="donut" style="padding-left: 0;padding-right: 0;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example
                            <div class="pull-right">
                                <i class="fa fa-expand" onclick="expand_div(3);" style="cursor:pointer;" id="e3"></i>
                                <div class="btn-group" id="action3" style="display:none;">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="javascript:void(0);" onclick="donutChartApprovedInvestment(1)">Approved Investments</a></li>
                                        <li><a href="javascript:void(0);" onclick="donutChartApprovedInvestment(2)">Not Approved Investments</a></li>
                                    </ul>
                                </div>
                                <div class="pull-right" id="minimize3" style="cursor:pointer;display:none;"><a href=""><i class="fa fa-minus"></i></a></div>
                            </div>                           
                        </div>
                        <div class="panel-body" style="padding: 0px 15px 0px;">
                            <div id="morris-donut-example"></div>                          
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div> 
                        <!-- /.panel-body -->
                      
             
           
             </div>
            
        </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    barGraphMonthlyInvestment(1);
    donutChartApprovedInvestment(1);
    areaChartInvestments(1);
});

function areaChartInvestments(status)
{
    $("#area-example").empty();   
    
                     Morris.Area({
                                    element: 'area-example',                                   
                                    data: [
                                        { y: '2006', a: 10, b: 20, c: 10, d:  20},
                                        { y: '2007', a: 75, b: 35, c: 10, d:  60},
                                        { y: '2008', a: 0,  b: 34, c: 10, d:  50},
                                        { y: '2009', a: 5,  b: 63, c: 10, d:  30},
                                        { y: '2010', a: 50, b: 44, c: 10, d:  20},
                                        { y: '2011', a: 75, b: 6,  c: 10, d:  10},
                                        { y: '2012', a: 10, b: 60, c: 10, d:  10}
                                    ],    
                                    xkey: 'y',
                                    ykeys: ['a', 'b','c','d'],
                                    labels: ['Cloud', '3D Printing','Healthcare', 'Robotics']
                                });
                   
             
}

// Used for ploting bar graph.
function barGraphMonthlyInvestment(status)
{
    $("#bar-example").empty();  
    $.ajax({
                type: 'POST',
                url: "<?php echo base_url();?>admin/company/fetchMonthlyInvestment",    
                data: { status : status},            
                dataType: "json",
                success: function(JSONObject) {
                for (var key in JSONObject) 
                {
                    var jan = JSONObject[key]["jan"]; 
                    if(jQuery.type(jan)=="null") { jan = 0;  } else { jan = jan; } 

                    var feb = JSONObject[key]["Feb"]; 
                    if(jQuery.type(feb)=="null") { feb = 0;  } else { feb = feb; } 

                    var mar = JSONObject[key]["Mar"];
                    if(jQuery.type(mar)=="null") { mar = 0;  } else { mar = mar; } 

                    var apr = JSONObject[key]["Apr"];
                    if(jQuery.type(apr)=="null") { apr = 0;  } else { apr = apr; } 

                     var may = JSONObject[key]["May"];
                    if(jQuery.type(may)=="null") { may = 0;  } else { may = may; } 
                    
                    var jun = JSONObject[key]["Jun"];
                    if(jQuery.type(jun)=="null") { jun = 0;  } else { jun = jun; } 
                    
                    var jul = JSONObject[key]["jul"];
                    if(jQuery.type(jul)=="null") { jul = 0;  } else { jul = jul; } 
                    
                    var aug = JSONObject[key]["Aug"];
                    if(jQuery.type(aug)=="null") { aug = 0;  } else { aug = aug; } 
                    
                    var sept= JSONObject[key]["Sep"];
                    if(jQuery.type(sept)=="null") { sept = 0; } else {sept = sept;} 
                    
                    var oct = JSONObject[key]["Oct"];
                    if(jQuery.type(oct)=="null") { oct = 0;  } else { oct = oct; } 
                    
                    var nov = JSONObject[key]["Nov"];
                    if(jQuery.type(nov)=="null") { nov = 0;  } else { nov = nov; } 
                    
                    var dec = JSONObject[key]["Dece"];        
                    if(jQuery.type(dec)=="null") { dec = 0;  } else { dec = dec; } 
                    
                }

                Morris.Bar({
                      xLabelMargin: 0,  
                      element: 'bar-example',
                      data: [
                        { y: 'Jan', a: jan},
                        { y: 'Feb', a: feb},
                        { y: 'Mar', a: mar},
                        { y: 'Apr', a: apr},
                        { y: 'May', a: may},
                        { y: 'June',a: jun},
                        { y: 'July',a: jul},
                        { y: 'Aug', a: aug},
                        { y: 'Sept',a: sept},
                        { y: 'Oct', a: oct},
                        { y: 'Nov', a: nov},
                        { y: 'Dec', a: dec}                        
                      ],
                      xkey: 'y',
                      ykeys: ['a'],
                      labels: ['Total Investments']
                    }); 
            }

        });
}

// Used for donut chart approved and not approved investments.
function donutChartApprovedInvestment(status)
{
     $("#morris-donut-example").empty();     
     $.ajax({
                type: 'POST',
                url: "<?php echo base_url();?>admin/company/donutChartInvestment",
                data: { status : status},
                dataType: "json",
                success: function(JSONObject) 
                {   
                    for (var key in JSONObject) 
                    {
                        var cloud       = JSONObject[key]["cloud"];                                               
                        if(jQuery.type(cloud)=="null") { 
                            cloud = 0;                                                       
                        } else {
                            
                            cloud = cloud;
                        }                        
                        var printing    = JSONObject[key]["printing"];                         
                        if(jQuery.type(printing) =="null") {                             
                             printing =0;                        
                        } else {
                            printing = printing;    
                        }                        
                        
                        var healthcare  = JSONObject[key]["Healthcare"];
                       if(jQuery.type(healthcare)=="null") {                             
                            healthcare =0;                           
                        } else {
                            healthcare = healthcare;
                        }                        
                        var ecosystem   = JSONObject[key]["Ecosystem"];
                        if(jQuery.type(ecosystem)=="null") {                             
                            ecosystem = 0;                           
                        } else {
                            ecosystem =ecosystem;
                        }                        
                        var robotics    = JSONObject[key]["Robotics"];
                        if(jQuery.type(robotics) =="null") {                             
                            robotics = 0;                           
                        } else {
                            robotics =robotics;
                        }                        
                        var workplace   = JSONObject[key]["Workplace"];
                        if(jQuery.type(workplace)=="null") {                             
                            workplace = 0;                           
                        } else {
                            workplace =workplace;
                        }                        
                    }                   

                   Morris.Donut({
                        element: 'morris-donut-example',
                        data: [
                            {label: "Cloud", value: cloud},
                            {label: "3D Printing", value: printing},
                            {label: "Healthcare",  value: healthcare},
                            {label: "Connected Intelligent Ecosystem", value: ecosystem},
                            {label: "Robotics", value: robotics},
                            {label: "Workplace of the Future", value: workplace}
                        ],
                        colors: ['#337AB7','#5CB85C','#A7B3BC'],
                    });
                }
            });
}


function expand_div(number)
{
    if(number==1)
    {

        $('#area').removeClass('col-lg-4').addClass('col-lg-12').css("padding-right","0px");
        $('#bar').hide();
        $('#donut').hide();
        $('#e1').hide();
        $('#action1').show();
        $('#action1').css("margin-right","15px"); 
        $('#minimize1').show();
        areaChartInvestments(1);

    }
    if(number==2)
    {
        $("#bar-example").empty();
        $('#bar').removeClass('col-lg-4').addClass('col-lg-12').css("padding-right","0px");
        $('#area').hide();
        $('#donut').hide();
        $('#e2').hide();
        $('#action2').show(); 
        $('#action2').css("margin-right","15px"); 
        $('#minimize2').show();               
        barGraphMonthlyInvestment(1);
    }
    if(number==3)
    {
        $('#donut').removeClass('col-lg-4').addClass('col-lg-12').css("padding-right","0px");
        $('#bar').hide();
        $('#area').hide();
        $('#e3').hide();
        $('#action3').show();
        $('#action3').css("margin-right","15px"); 
        $('#minimize3').show();
        donutChartApprovedInvestment(1);
    }
}
</script> 