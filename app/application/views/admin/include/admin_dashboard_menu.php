<div class="row">
    <div class="col-lg-12">
        <h3 style="margin-bottom: -12px;margin-top: 12px !important;">Dashboard</h3>
        <hr style="margin-bottom:5px;">
    </div>

</div>

<div class="row">

    <div class="col-lg-6 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-comments fa-x"></i>
                    </div>
                    <div class="col-xs-10 text-right">
                        <div class="huge"><?php echo $dPlansStatus; ?> &nbsp; Development Plans!</div>
                       </div>
                </div>
            </div>
            <a href="<?=site_url('admin/partner/getDevelopementPlans')?>">
                <div class="panel-footer" style="padding:0px 15px;">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <?php /* <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-tasks fa-x"></i>
                    </div>
                    <div class="col-xs-10 text-right">
                        <div class="huge"><?php echo $newtasks ?> &nbsp; New Tasks!</div>
                        
                    </div>
                </div>
            </div>
            <a href="<?=site_url('admin/partner/newtasks') ?>">
                <div class="panel-footer" style="padding:0px 15px;">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-shopping-cart fa-x"></i>
                    </div>
                    <div class="col-xs-10 text-right">
                        <div class="huge"><?php echo $neworders  ?> &nbsp; New Orders! </div>
                      
                    </div>
                </div>
            </div>
            <a href="<?=site_url('admin/partner/neworders') ?>">
                <div class="panel-footer" style="padding:0px 15px;">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div> */ ?>

    <div class="col-lg-6 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-support fa-x"></i>
                    </div>
                    <div class="col-xs-10 text-right">
                        <div class="huge"><?php echo $approvedCompanies; ?> &nbsp; Approved Companies!</div>

                    </div>
                </div>
            </div>
             <a href="<?=site_url('admin/partner/getApprovedPartners') ?>">
                <div class="panel-footer" style="padding:0px 15px;">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>