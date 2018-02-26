<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=(!empty($page_title) ? $page_title : '')?></title>
        <!-- REQUIRED STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <!-- REQUIRED PLUGINS -->
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/icheck/css/skins/all.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/select2/select2-bootstrap-theme/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-daterangepicker/css/bootstrap-daterangepicker.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css">    
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/datatables/css/dataTables.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/rippler/css/rippler.min.css" rel="stylesheet" type="text/css">
        <!-- main.min.css - WISEBOARD CORE CSS -->
        <link href="<?=base_url()?>backend/vendor/dist/material/css/main.min.css" rel="stylesheet" type="text/css">
        <!-- plugins.min.css - ALL PLUGINS CUSTOMIZATIONS -->
        <link href="<?=base_url()?>backend/vendor/dist/material/css/plugins.min.css" rel="stylesheet" type="text/css">
        <!-- admin.min.css - ADMIN LAYOUT -->
        <link href="<?=base_url()?>backend/assets/css/admin.min.css" rel="stylesheet" type="text/css">
        <!-- theme-default.min.css - DEFAULT THEME -->
        <link href="<?=base_url()?>backend/assets/css/theme-default.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/assets/css/page-ecommerce.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-sweetalert/css/sweetalert.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css">
        <!-- Dashboard css -->
        <link href="<?=base_url()?>backend/assets/css/page-dashboard1.min.css" rel="stylesheet" type="text/css">
        <link href="<?=base_url()?>backend/assets/css/page-dashboard5.min.css" rel="stylesheet" type="text/css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            #settings {
                display: none !important;
            }
        </style>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body>
        <!-- <div id="dvLoading"></div> -->
        <input type="hidden" name="base_url" id="base_url" value="<?=base_url()?>">       
        <!-- modal for edit user end -->
        <!-- TOP NAVIGATION STARTS -->
        <nav class="navbar navbar-fixed-top navbar-top">
            {top_header}
        </nav>
        <!-- TOP NAVIGATION ENDS -->

        <!-- CONTENT WRAPPER STARTS ( INCLUDES LEFT SIDEBAR AND CONTENT PART OF THE PAGE ) -->
        <div class="content-wrapper">
            <!-- SIDEBAR STARTS -->
                {sidebar}
            <!-- SIDEBAR ENDS -->

            <!-- CONTENT STARTS -->
            <div class="content">
                {content}
            </div>
            <!-- CONTENT ENDS -->
        </div>
        <!-- CONTENT WRAPPER ENDS -->

        <!-- FOOTER STARTS -->
        <div class="footer">
            {footer}
        </div>
        <!-- FOOTER ENDS -->

        <!-- import the js file for CKEditor -->
        <script src="<?=base_url()?>backend/vendor/ckeditor/ckeditor.js"></script>

        <!-- REQUIRED SCRIPTS -->
        <script src="<?=base_url()?>backend/vendor/dist/material/js/jquery.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/js/bootstrap.min.js"></script>
        <!-- REQUIRED PLUGINS -->
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/jquery.sparkline/js/jquery.sparkline.min.js"></script>
        <!-- REQUIRED PLUGINS -->
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/jquery.slimscroll/js/jquery.slimscroll.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/basil.js/js/basil.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/jquery.succinct/js/jquery.succinct.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/select2/js/select2.full.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/moment/js/moment.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-daterangepicker/js/bootstrap-daterangepicker.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/chart.js/js/chart.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/jquery.searchable/js/jquery.searchable.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/flot/js/jquery.flot.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/flot/js/jquery.flot.resize.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/flot/js/jquery.flot.time.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/flot/js/jquery.flot.pie.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/flot/js/plugins/jquery.flot.tooltip.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/easy-pie-chart/js/jquery.easypiechart.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/rippler/js/jquery.rippler.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/jquery.succinct/js/jquery.succinct.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-maxlength/js/bootstrap-maxlength.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/jasny-bootstrap/js/fileinput.js"></script>
        <!-- main.min.js - WISEBOARD CORE SCRIPT -->
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/js/main.min.js"></script>
        <!-- admin.min.js - GENERAL CONFIGURATION SCRIPT FOR THE PAGES -->
        <script type="text/javascript" src="<?=base_url()?>backend/assets/js/admin.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/assets/js/ecommerce-table-demo.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/assets/js/ecommerce-product-add-edit-demo.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/assets/js/demo/demo-plugin-datatables-basic.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-sweetalert/js/sweetalert.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/moment/js/moment.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-daterangepicker/js/bootstrap-daterangepicker.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/clockface/js/clockface.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/plugins/rippler/js/jquery.rippler.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/vendor/dist/material/js/main.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/assets/js/admin.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/assets/js/demo/demo-plugins-bootstrap-date-time-pickers.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/icheck/js/icheck.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/select2/js/select2.full.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/bootstrap-wizard/js/jquery.bootstrap.wizard.min.js"></script>
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/jquery.validate/js/jquery.validate.min.js"></script>    
        <script type="text/javascript" src="<?=base_url()?>backend/assets/js/demo/demo-plugin-bootstrap-modal.js"></script>
        <script src="<?=base_url()?>backend/assets/js/demo/demo-form-wizard-with-validation.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/assets/js/custom.js"></script>        
        <script src="<?=base_url()?>backend/vendor/dist/material/plugins/datatables/js/dataTables.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>backend/assets/js/demo/demo-plugin-datatables-extensions.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.start').daterangepicker({
                    timePicker: true,
                    datePicker: false,                      
                       locale: {
                        format: 'h:mm A'
                    }              
                });

                $('.start').on('click', function(ev) {
                    $('.calendar-table').hide();            
                });

                var validExt = ".png, .gif, .jpeg, .jpg";
                $("input[type='file'][name='section_image[]']").bind('change', function () {
                var filePath = this.value;
                var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
                var pos = validExt.indexOf(getFileExt);
                if (pos < 0) {
                    swal('', "This file is not allowed, please upload valid file.", 'error');
                    setInterval(function () {
                        location.reload();
                    }, 1000);
                        return false;
                    } else {
                        return true;
                    }
                });
            });
        </script>        
        <div>
        <?php if(!empty($this->session->flashdata('message'))) {?>
        <script type="text/javascript">
            var myFunc = function() {
                swal({
                    position: 'top-right',
                    type: 'success',
                    title: '<?=$this->session->flashdata('message')?>',
                    showConfirmButton: false,
                    timer: 5000
                    })
            } ();
            myFunc();
        </script>
        <?php } ?>


        <?php if(!empty($this->session->flashdata('error'))) {?>
        <script type="text/javascript">
            var myFunc = function() {
                swal({
                    position: 'top-right',
                    type: 'danger',
                    title: '<?=$this->session->flashdata('error')?>',
                    showConfirmButton: false,
                    timer: 5000
                    })
            }();

            myFunc();
        </script>
        <?php } ?>
    </div>
    <script type="text/javascript">
        $(window).load(function() {
            $('#dvLoading').fadeOut(2000);
        });
    </script>
</body>
</html>