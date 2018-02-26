<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="dashboard1.html"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Dashboard</h2>
    <div class="btn btn-danger-outline border-right-bold circle rippler">
        <?=(!empty($order_amount_total[0]['order_total']) ? 'Total Amount  :  $'.$order_amount_total[0]['order_total'] : '$0')?>
        <!-- <i class="fa fa-calendar m-right-5"></i>
        <span></span>
        <i class="fa fa-angle-down m-left-5"></i> -->
    </div>
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-4">
        <div class="panel panel-primary panel-chart">
            <div class="panel-heading">
                <div class="panel-title"><i class="fa fa-bar-chart"></i> Total Orders</div>
            <!-- <div class="panel-title">Total Amount : <?=(!empty($order_amount_total[0]['order_total']) ? '$'.$order_amount_total[0]['order_total'] : '$0')?></div> -->
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <h4 class="chart-heading"><span class="label label-success"><?=(isset($total_orders) && !empty($total_orders) ? $total_orders : '0')?></span>
                <!-- Total Amount : <span class="label label-success"><?=(!empty($order_amount_total[0]['order_total']) ? '$'.$order_amount_total[0]['order_total'] : '$0')?></span> -->
                </h4>
            </div>
            <!-- /.panel-body -->
        </div>
        <!--/.panel-->
    </div>
    <!-- /.col-sm-4 -->
    <div class="col-sm-4">
        <div class="panel panel-primary panel-chart">
            <div class="panel-heading">
                <div class="panel-title"><i class="fa fa-users"></i> Total Customers</div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <h4 class="chart-heading"><span class="label label-primary"><?=(!empty($total_customers) ? $total_customers : '0')?></span></h4>
            </div>
            <!-- /.panel-body -->
        </div>
        <!--/.panel-->
    </div>
    <!-- /.col-sm-4 -->

    <!-- /.col-sm-4 -->
    <div class="col-sm-4">
        <div class="panel panel-primary panel-chart">
            <div class="panel-heading">
                <div class="panel-title"><i class="fa fa-bar-chart"></i> Total Rent Orders</div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <h4 class="chart-heading"><span class="label label-primary"><?=(!empty($rent_order_count[0]['total_orders']) ? $rent_order_count[0]['total_orders'] : '0')?></span></h4>
            </div>
            <!-- /.panel-body -->
        </div>
        <!--/.panel-->
    </div>
    <!-- /.col-sm-4 -->
</div>
<!-- /.row -->

<!-- /.row -->
<div class="row">
    
    <?php if(!empty($orders_this_day)) {?>
    <div class="col-sm-6 col-lg-4">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-title">Daily Orders</div>
            </div>
            <div class="panel-body">
                <h2><?=$orders_this_day[0]['tot_day']?> 
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php } ?>

    <?php if(!empty($orders_this_month)) {?>
    <div class="col-sm-6 col-lg-4">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-title">Monthly Orders</div>
            </div>
            <div class="panel-body">
                <h2><?=$orders_this_month[0]['tot_month']?> 
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php } ?>

    <?php if(!empty($orders_this_year)) {?>
    <div class="col-sm-6 col-lg-4">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-title">Yearly Orders</div>
            </div>
            <div class="panel-body">
                <h2><?=$orders_this_year[0]['tot_year']?> 
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php } ?>
</div>
<!-- /.row -->

<div class="row">
    <?php if(!empty($order_status_count)) {?>
    <div class="col-sm-6 col-md-4-5 col-lg-1-5">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="panel-title"><?=$order_status_count[0]['ord_status_description']?></div>
            </div>
            <div class="panel-body">
                <h2><?=$order_status_count[0]['total_order']?> 
                    <!-- <span class="pull-right text-info">17% <i class="fa fa-level-up"></i></span></h2> -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <div class="col-sm-6 col-md-4-5 col-lg-1-5">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="panel-title"><?=$order_status_count[1]['ord_status_description']?></div>
            </div>
            <div class="panel-body">
                <h2><?=$order_status_count[1]['total_order']?> 
                    <!-- <span class="pull-right text-info">17% <i class="fa fa-level-up"></i></span></h2> -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <div class="col-sm-6 col-md-4-5 col-lg-1-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title"><?=$order_status_count[2]['ord_status_description']?></div>
            </div>
            <div class="panel-body">
                <h2><?=$order_status_count[2]['total_order']?> 
                    <!-- <span class="pull-right text-info">17% <i class="fa fa-level-up"></i></span></h2> -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <div class="col-sm-6 col-md-4-5 col-lg-1-5">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><?=$order_status_count[3]['ord_status_description']?></div>
            </div>
            <div class="panel-body">
                <h2><?=$order_status_count[3]['total_order']?> 
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <div class="col-sm-6 col-md-4-5 col-lg-1-5">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="panel-title"><?=$order_status_count[4]['ord_status_description']?></div>
            </div>
            <div class="panel-body">
                <h2><?=$order_status_count[4]['total_order']?> 
                    <!-- <span class="pull-right text-info">17% <i class="fa fa-level-up"></i></span></h2> -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php } ?>
</div>
<!-- /.row -->

<div class="panel panel-default-light border-default panel-chart">
    <div class="panel-heading">
        <i class="fa fa-bar-chart m-right-5"></i> Orders: Monthly
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <h4 class="chart-heading"><span class="label label-success"><?=(!empty($order_amount_total[0]['order_total']) ? 'Total Amount  :  $'.$order_amount_total[0]['order_total'] : '$0')?></span></h4>
        <!-- NOTE; Chartjs doesn't respond css height property so the height is controlling by html height attribute of canvas element -->
        <canvas class="chart-body" id="chart-orders" height="116"></canvas>
    </div>
    <!-- /.panel-body -->
</div>
<!--/.panel-->


<!-- REQUIRED SCRIPTS -->
<script src="<?=base_url()?>backend/vendor/dist/material/js/jquery.min.js"></script>
<script src="<?=base_url()?>backend/vendor/dist/material/js/bootstrap.min.js"></script>
<!-- REQUIRED PLUGINS -->
<script src="<?=base_url()?>backend/vendor/dist/material/plugins/jquery.sparkline/js/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/moment/js/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-daterangepicker/js/bootstrap-daterangepicker.min.js"></script>
<script src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url()?>backend/vendor/dist/material/plugins/chart.js/js/chart.min.js"></script>
<!-- dashboard-demo1.min.js - DASHBOARD DEMO SCRIPT -->
<script type="text/javascript" src="<?=base_url()?>backend/assets/js/dashboard-demo1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>backend/assets/js/dashboard-demo5.min.js"></script>