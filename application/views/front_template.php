<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=(!empty($page_title) ? $page_title : 'Buy Sell Rent') ?></title>
        <!-- Standard -->
        <link rel="shortcut icon" href="<?= base_url() ?>frontend/assets/images/ficon.png">
        <!-- Latest Bootstrap min CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>frontend/assets/css/bootstrap.min.css" type="text/css">
        <!-- Dropdownhover CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>frontend/assets/css/bootstrap-dropdownhover.min.css" type="text/css">
        <!-- latest fonts awesome -->
        <link rel="stylesheet" href="<?= base_url() ?>frontend/assets/font/css/font-awesome.min.css" type="text/css">
        <!-- simple line fonts awesome -->
        <link rel="stylesheet" href="<?= base_url() ?>frontend/assets/simple-line-icon/css/simple-line-icons.css" type="text/css">
        <!-- stroke-gap-icons -->
        <link rel="stylesheet" href="<?= base_url() ?>frontend/assets/stroke-gap-icons/stroke-gap-icons.css" type="text/css">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>frontend/assets/css/animate.min.css" type="text/css">
        <!-- Style CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>frontend/assets/css/style.css" type="text/css">
        <!--  baguetteBox -->
        <link rel="stylesheet" href="<?= base_url() ?>frontend/assets/css/baguetteBox.css">
        <!-- Owl Carousel Assets -->
        <link href="<?= base_url() ?>frontend/assets/owl-carousel/owl.carousel.css" rel="stylesheet">
        <link href="<?= base_url() ?>frontend/assets/owl-carousel/owl.theme.css" rel="stylesheet">
        <!-- Style CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>frontend/assets/css/jcarousel.connected-carousels.css" type="text/css">
        <!--  baguetteBox -->
        <link rel="stylesheet" href="<?= base_url() ?>frontend/assets/css/baguetteBox.css">
        <!-- Owl Carousel Assets -->
        <link href="<?= base_url() ?>frontend/assets/owl-carousel/owl.carousel.css" rel="stylesheet">
        <link href="<?= base_url() ?>frontend/assets/owl-carousel/owl.theme.css" rel="stylesheet">
        <link href="<?= base_url() ?>frontend/assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>frontend/assets/css/ubislider.min612e.css" rel="stylesheet">
        <link href="<?= base_url() ?>frontend/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>frontend/assets/css/bootstrap-datetimepicker-standalone.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body>
        <div id="dvLoading"></div>

        <input type="hidden" name="base_url" value="<?=base_url()?>" id="base_url">
        <!--  Preloader  -->
        <div id="preloader">
            <div id="loading">
            </div>
        </div>
        <header>
            <!--  top-header  -->
            <div class="top-header">
                {top_header}
                <!--  /top-header  -->
            </div>
            <section class="top-md-menu top-home3">
                {main_menu}
            </section>
            <!-- header-outer -->            
            {slider}
            <!-- /header-outer -->
        </header>

        <section class="banner">
            {banner}
            
        </section>
        <!-- deal-outer -->
        {content}
        <!-- /deal-outer -->	
        <!-- newsletter -->
        <section class="newsletter">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <h6 class="sing-up-text">sign up to
                            <strong>newsletter</strong> &
                            <strong>free shipping</strong> for first shopping</h6>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="sing-up-input">
                            <input name="singup" type="text" placeholder="Your email address..." id="newsletter_email" maxlength="35">
                            <button class="newsletter_btn" id="newsletter_submit">Submit</button>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6" id="newsletter_message"></div>
                </div>
            </div>
        </section>
        <!-- /newsletter -->
        <footer>
            {footer}
        </footer>
        <!-- sticky-socia -->
        <aside id="sticky-social">
            <ul>
                <?php foreach ($social_links as $social_list) {?>
                <li><a href="<?=$social_list['link']?>" class="fa fa-<?=strtolower($social_list['name'])?>" target="_blank"><span><i class="fa fa-<?=strtolower($social_list['name'])?>" aria-hidden="true"></i> <?=ucfirst($social_list['name'])?></span></a></li>
                <?php } ?>
            </ul>
        </aside>

        <!--  buy section review popup form -->
        <div class="modal fade" id="reviewnew"  role="dialog" >
            <div class="modal-dialog" role="document">
                <div class="colorgraph"></div>
                <form class="review_form" action="" method="post">
                    <div class="modal-content">
                        <div class="modal-body">
                            <fieldset>
                                <h3 class="text-center">Write Your Review</h3>
                                <hr>
                                <div class="review_message_container"></div>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label>Review title</label>
                                    <div>
                                        <?=form_input(array('class' => 'form-control', 'id' => 'review_name', 'name' => 'review_name'))?>
                                    </div>
                                </div>

                                <!-- Email input-->
                                <!-- <div class="form-group">
                                    <label>Your E-mail</label>
                                    <div>
                                        <?=form_input(array('class' => 'form-control', 'id' => 'review_email', 'name' => 'review_email'))?>
                                    </div>
                                </div> -->

                                <!-- Message body -->
                                <div class="form-group">
                                    <label>Your message</label>
                                    <div>
                                        <?=form_textarea(array('class' => 'form-control', 'id' => 'review_message', 'name' => 'review_message', 'placeholder' => 'Please enter your message here...', 'rows' => '5'))?>
                                        <input type="hidden" id="selected_starts" name="selected_starts" value="0"/>
                                    </div>
                                </div>

                                <!-- Ratings -->
                                <div class="form-group">
                                    <div>
                                        <!-- Rating Stars Box -->
                                        <div class='rating-stars text-center'>
                                            <ul id='stars'>
                                                <li class='star' data-toggle="tooltip" title="Poor" data-value='1'><i class='fa fa-star fa-fw'></i></li>
                                                <li class='star' data-toggle="tooltip" title="Fair"  data-value='2'><i class='fa fa-star fa-fw'></i></li>
                                                <li class='star' data-toggle="tooltip" title="Good"  data-value='3'><i class='fa fa-star fa-fw'></i></li>
                                                <li class='star' data-toggle="tooltip" title="Excellent"  data-value='4'><i class='fa fa-star fa-fw'></i></li>
                                                <li class='star' data-toggle="tooltip" title="WOW!!!"  data-value='5'><i class='fa fa-star fa-fw'></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class='success-box'>
                                    <div class='clearfix'></div>
                                    <div class='text-message' style="text-align: center;"></div>
                                    <div class='clearfix'></div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer" id="review_submit_btn">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            <button type="button" id="submit_review" class="btn btn-primary">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- buy section Review for end -->

        <!-- rent section review popup form start -->
        <div class="modal fade" id="rentreviewnew"  role="dialog" >
            <div class="modal-dialog" role="document">
                <div class="colorgraph"></div>
                <form class="rent_review_form" action="" method="post">
                    <div class="modal-content">
                        <div class="modal-body">
                            <fieldset>
                                <h3 class="text-center">Write Your Review</h3>
                                <hr>
                                <div class="rent_review_message_container"></div>
                                <!-- Name input-->
                                <div class="form-group">
                                    <label>Review title</label>
                                    <div>
                                        <?=form_input(array('class' => 'form-control', 'id' => 'rent_review_name', 'name' => 'rent_review_name'))?>
                                    </div>
                                </div>
                                <!-- Message body -->
                                <div class="form-group">
                                    <label>Your message</label>
                                    <div>
                                        <?=form_textarea(array('class' => 'form-control', 'id' => 'rent_review_message', 'name' => 'rent_review_message', 'placeholder' => 'Please enter your message here...', 'rows' => '5'))?>
                                        <input type="hidden" id="rent_selected_starts" name="rent_selected_starts" value="0"/>
                                    </div>
                                </div>

                                <!-- Ratings -->
                                <div class="form-group">
                                    <div>
                                        <!-- Rating Stars Box -->
                                        <div class='rating-stars text-center'>
                                            <ul id='stars'>
                                                <li class='star' data-toggle="tooltip" title="Poor" data-value='1'><i class='fa fa-star fa-fw'></i></li>
                                                <li class='star' data-toggle="tooltip" title="Fair"  data-value='2'><i class='fa fa-star fa-fw'></i></li>
                                                <li class='star' data-toggle="tooltip" title="Good"  data-value='3'><i class='fa fa-star fa-fw'></i></li>
                                                <li class='star' data-toggle="tooltip" title="Excellent"  data-value='4'><i class='fa fa-star fa-fw'></i></li>
                                                <li class='star' data-toggle="tooltip" title="WOW!!!"  data-value='5'><i class='fa fa-star fa-fw'></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class='success-box'>
                                    <div class='clearfix'></div>
                                    <div class='text-message' style="text-align: center;"></div>
                                    <div class='clearfix'></div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer" id="rent_review_submit_btn">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            <button type="button" id="rent_submit_review" class="btn btn-primary">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- rent section review popup for end -->

        <!--Login popup-->
        <div class="modal fade modal-popup" id="login-new" data-keyboard="false" data-backdrop="static">
            <div id="login-overlay" class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="main-login">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Login</h4>
                        </div>
                        <hr class="colorgraph">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <p class="lead">REGISTER NOW </p>
                                    <ul class="list-unstyled" style="line-height: 2">
                                        <li><span class="fa fa-check text-success"></span> See all your orders</li>
                                        <li><span class="fa fa-check text-success"></span> Fast re-order</li>
                                        <li><span class="fa fa-check text-success"></span> Save your favorites</li>
                                        <li><span class="fa fa-check text-success"></span> Fast checkout</li>
                                    </ul>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vehicula tellus ac tincidunt vehicula.
                                    </p>
                                    <p style="margin-top: 16px;">
                                        <a class="add-btn btn-block show-register">Yes please, register now!</a></p>
                                </div>
                                <div class="col-xs-6">
                                    <div class="well">
                                        <div id="loginPopForm" class="loginPopForm">
                                            <div class="form-group">
                                                <label class="control-label">Email Id</label>
                                                <input type="email" id="pop_username" class="form-control" value="" placeholder="email id" autocomplete="off" maxlength="35">
                                                <span id="pop_username_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Password</label>
                                                <input type="password" id="pop_password" class="form-control" value="" placeholder="password" autocomplete="off" maxlength="35">
                                                <span id="pop_password_error"></span>
                                            </div>
                                            <span id="login_pop_error"></span>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="remember" id="remember"> Remember login
                                                </label>
                                            </div>
                                            <div class="form-group popup_login_submit">
                                                <button id="popup_login" class="add-btn btn-block popup_login">Login</button>
                                            </div>
                                            <a id="forget" href="javascript:;">Forgot password</a>
                                        </div>
                                        <form class="forget-pass">
                                            <div class="form-group">
                                                <label for="username" class="control-label">Email ID</label>
                                                <input type="text" class="form-control" value="" required="" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="add-btn btn-block">Login</button>
                                            </div>
                                            <a id="backtologin" href="javascript:;">Back to Login</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-register">
                        <form id="registerPopForm" method="POST" novalidate="novalidate">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Register</h4>
                            </div>
                            <hr class="colorgraph">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" required="" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Last Name</label>
                                            <input type="text" class="form-control" required="" name="last_name" id="last_name" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="text" class="form-control" value="" name="email_id" id="email_id" required="Email Id" placeholder="Email Id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username" class="control-label">Telephone</label>
                                            <input type="text" class="form-control" name="telephone" value="" required="" id="telephone" placeholder="Telephone Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username" class="control-label">Password</label>
                                            <input type="Password" class="form-control" name="password" value="" required="" id="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Confirm Password</label>
                                            <input type="Password" class="form-control" name="confirm_password" value="" required="" id="confirm_password" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <a id="backtomainlogin" href="javascript:;">Back to Login</a>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="modal-footer">
                                        <center>
                                            <button type="button" class="add-btn btn-md btn-block popup_register show-register">SUBMIT</button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End login popup -->

        <!-- coupons list popup -->
        <div class="modal fade" id="coupons_list" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="colorgraph"></div>
                <div class="modal-content">
                    <div class="modal-body">
                        <fieldset>
                            <h3 class="text-center">Active Coupons</h3>
                            <hr>
                            <ul>
                                <?php if(isset($all_coupons) && !empty($all_coupons)) {
                                    foreach ($all_coupons as $e => $coupon_list) {?>
                                        <li><?=($e+1).')';?>
                                            <span><b><?=$coupon_list['disc_code']?></b></span><br>
                                            <span style="padding-left: 20px"><?=$coupon_list['disc_description']?></span>
                                        </li><hr>
                                    <?php } ?>
                                <?php }?>
                            </ul>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <!-- coupons list popup end -->

<!--                 <button class="success-msg btn btn-success">Show success message</button>
         <button class="error-msg btn btn-success">Show Error message</button>
         <button class="right-msg btn btn-success">Show Error message</button> -->

        <!-- /sticky-socia -->
        <!-- Get Our Email Letter popup -->
        <?php //$this->load->view('_modal_news_letter'); ?>
        <!-- /Get Our Email Letter popup -->
        <p id="back-top">
            <a href="#top"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
        </p>

        <script src="<?= base_url() ?>frontend/assets/js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="<?= base_url() ?>frontend/assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>frontend/assets/js/bootstrap-dropdownhover.min.js"></script>
        <!--Product detail quantity-->
        <script src="<?= base_url() ?>frontend/assets/js/incrementing.js"></script>
        <!-- Plugin JavaScript -->
        <script src="<?= base_url() ?>frontend/assets/js/jquery.easing.min.js"></script>
        <script src="<?= base_url() ?>frontend/assets/js/wow.min.js"></script>
        <!-- Plugin JavaScript -->
        <script src="<?= base_url() ?>frontend/assets/js/jquery.easing.min.js"></script>
        <script src="<?= base_url() ?>frontend/assets/js/wow.min.js"></script>    
        <!-- owl carousel -->
        <script src="<?= base_url() ?>frontend/assets/owl-carousel/owl.carousel.js"></script>
        <!--  Custom Theme JavaScript  -->
        <script src="<?= base_url() ?>frontend/assets/js/custom.js"></script>
        <script src="<?= base_url() ?>frontend/assets/js/custom_events.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>frontend/assets/js/jquery.validate.min.js"></script>
        <script src="<?= base_url() ?>frontend/assets/js/validation.js"></script>
        <script type="text/javascript" src="<?=base_url()?>frontend/assets/js/jquery.toaster.js"></script>
        <script type="text/javascript" src="<?=base_url()?>frontend/assets/js/jquery.jcarousel.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>frontend/assets/js/jcarousel.connected-carousels.js"></script>
        <script type="text/javascript" src="<?=base_url()?>frontend/assets/js/jquery.elevatezoom.js"></script>
        <script type="text/javascript" src="<?=base_url()?>frontend/assets/js/jquery.mCustomScrollbar.js"></script>
        <script type="text/javascript" src="<?=base_url()?>frontend/assets/js/custom_alerts.js"></script>
        <script type="text/javascript" src="<?=base_url()?>frontend/assets/js/ubislider.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>frontend/assets/js/scripts.js"></script>
        <script type="text/javascript" src="https://unpkg.com/sweetalert2@7.1.2/dist/sweetalert2.all.js"></script>

    	<!-- js files for mega menu structure start -->
        <script src="<?=base_url()?>frontend/assets/js/jquery.menu-aim.js"></script>
    	<script src="<?=base_url()?>frontend/assets/js/main.js"></script>
        <!-- js files for mega menu structure end -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>frontend/assets/js/bootstrap-datetimepicker.min.js"></script>

        <script>
        (function($){
            $(window).on("load",function(){
               $(".scroll-drop-menu").mCustomScrollbar({
                    theme:"dark",
                    scrollInertia:400
                }); 
            });
        })(jQuery);
        </script>
        <script>        
            /* Start ratings */
            // Ratings 
            /* 1. Visualizing things on Hover - See next part for action on click */
            $('#stars li').on('mouseover', function() {

                var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
                // Now highlight all the stars that's not after the current hovered star
                $(this).parent().children('li.star').each(function(e) {
                    if (e < onStar) {
                        $(this).addClass('hover');
                    } else {
                        $(this).removeClass('hover');
                    }
                });

                }).on('mouseout', function() {
                    $(this).parent().children('li.star').each(function(e) {
                    $(this).removeClass('hover');
                });
            });

            /* 2. Action to perform on click */
            $('#stars li').on('click', function() {

                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                $('#selected_starts').val(onStar);
                $('#rent_selected_starts').val(onStar);
                var stars = $(this).parent().children('li.star');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

                // JUST RESPONSE (Not needed)
                var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                var msg = "";
                if (ratingValue > 1) {
                    msg = "Thanks! You rated this " + ratingValue + " stars.";
                } else {
                    msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
                }
                
                responseMessage(msg);
            });

            function responseMessage(msg) {
                $('.success-box').fadeIn(200);  
                $('.success-box div.text-message').html("<span>" + msg + "</span>");
            }

            /*End Ratings*/
            /*Blog new links hide and show*/
            $(".blog-btn").click(function(){
                $(".wrap-new-links").slideToggle("slow");
            });


            // Notification script
            $('.success-msg').on('click', function () {
                swal('Successfully submitted.', 'Thank you, We will get back to you soon!', 'success').catch(swal.noop)
              });

            $('.error-msg').on('click', function () {
                swal('Oops...', 'Something went wrong!', 'error').catch(swal.noop)
            });

            $('.right-msg').on('click', function () {
                swal({
                  position: 'top-right',
                  type: 'success',
                  title: 'Your work has been saved',
                  showConfirmButton: false,
                  //timer: 1500
                })
            });
               
            
    	</script>

        <script>
            $(window).load(function(){
              $('#dvLoading').fadeOut(2000);
            });
        </script>

        <script type="text/javascript">
            $('#slider4').ubislider({
                arrowsToggle: true,
                zoomType: "inner",
                type: 'ecommerce',
                hideArrows: true,
                autoSlideOnLastClick: true,
                modalOnClick: false,
                onTopImageChange: function(){
                    $('#imageSlider4 img').elevateZoom({
                        zoomType: "inner",
                        cursor: "crosshair"
                    });

                }
            });  


            /*Blog new links hide and show*/
            $(".blog-btn").click(function(){
                $(".wrap-new-links").slideToggle("slow");
            }); 
            
            $(document).on('click', '.append-new-video', function(e) {
                var video_id = $('#video_url').val();
                $(".zoomContainer").hide();
                $("#imageSlider4").html('<iframe class="product-v-img" style="width:100%;height:100%" src="https://www.youtube.com/embed/'+ video_id +'?autoplay=1" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>');
            });     


            $(function () {
                var dateToday = new Date();

                $("#datetimepicker1,#datetimepicker2").datetimepicker({
                    format: 'DD/MM/YYYY',
                    minDate: dateToday,
                });
                
                // $("#datetimepicker2").datetimepicker({
                //     format: 'DD/MM/YYYY',
                //     minDate: dateToday,
                //     beforeShowDay: function(d) {
                //         if( d.getDate() === 1 ) {
                //             return true;
                //         }
                //         return false;
                //     },
                // });

                // $("#datetimepicker1").on("dp.change", function (e) {
                //     // console.log(e.date);
                //     if(date_condition == '1') {
                //         var date = e.date._d;
                //         date.setDate(date.getDate() + 1);
                //         $("#datetimepicker2").data("DateTimePicker").minDate(date);
                //     } else if(date_condition == '7') {
                //         var date = e.date._d;
                //         date.setDate(date.getDate() + 7);
                //         $("#datetimepicker2").data("DateTimePicker").minDate(date);
                //     } else if(date_condition == '30') {
                //         var date = e.date._d;
                //         date.setDate(date.getDate() + 30);
                //         $("#datetimepicker2").data("DateTimePicker").minDate(date);
                //     } else if(date_condition == '365') {
                //         var date = e.date._d;
                //         date.setDate(date.getDate() + 365);
                //         $("#datetimepicker2").data("DateTimePicker").minDate(date);
                //     }

                //     // var start = $('#datetimepicker1').datetimepicker({'getDate'});
                //     // var end   = $('#datetimepicker2').datetimepicker({'getDate'});
                    
                //     // var days = (end - start)/1000/60/60/24;
                //     // $('#days').val(days);
                //     // var start = $("#datetimepicker1").val();
                //     // // var startD = new Date(start);
                //     // var end = $("#datetimepicker2").val();
                //     // // var endD = new Date(end);
                //     // var diff = parseInt((date.getTime()-dateToday.getTime())/(24*3600*1000));
                //     // console.log(diff);
                //     // $("#days").val(diff);
                // });

                // $("#datetimepicker2").on("dp.change", function (e) {
                //     var start = $("#datetimepicker1").val();
                //     // var startD = new Date(start);
                //     var end = $("#datetimepicker2").val();
                //     // var endD = new Date(end);
                //     var date = e.date._d;
                //     date.setDate(date.getDate());

                //     var diff = parseInt((date.getTime()-dateToday.getTime())/(24*3600*1000));

                //     var calculate_rent = $('#calculate_rent').val();

                //     if(date_condition == '1') {
                //         var total_rent = calculate_rent*diff;
                //         $("#rent_duration").val('For ' + diff + ' day(s)');
                //     } else if(date_condition == '7') {
                //         // var per_day_rent = calculate_rent/7; 
                //         // var total_rent = per_day_rent*diff;

                //         var quotient = Math.ceil(diff/7);
                //         var total_rent = calculate_rent*quotient;
                //         $("#rent_duration").val('For ' + quotient + ' Week(s)');

                //     } else if(date_condition == '30') {
                //         // var modulo = (calculate_rent%30);
                //         // console.log(modulo);
                //         // var per_day_rent = calculate_rent/30; 
                //         var quotient = Math.ceil(diff/30);
                //         var total_rent = calculate_rent*quotient;

                //         $("#rent_duration").val('For ' + quotient + ' Month(s)');

                //     } else if(date_condition == '365') {
                        
                //         var quotient = Math.ceil(diff/365);                        
                //         var total_rent = calculate_rent*quotient;
                //         $("#rent_duration").val('For ' + quotient + ' Year(s)');
                //     }


                //     console.log(total_rent);
                //     var rent_product_id = $('#rent_product_id').val();
                //     $("#price_"+ rent_product_id).val(total_rent);
                //     console.log(diff);
                // });
            });
        </script>
        <script>
            $(document).ready(function() {
                var owl = $('#feature-banner');
                owl.owlCarousel({
                    margin: 10,
                    items:3,
                    nav: true,
                    loop: true,
                    navigation:true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 2
                        },
                        1000: {
                            items: 3
                        }
                    }
                })
            })
        </script>
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API = Tawk_API||{}, Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/5a545cfbd7591465c7068f27/default';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
        <script src="<?=base_url()?>frontend/assets/js/popup.js"></script>
    </body>
</html>
