<div id="main-content">
    <div class="section-element vc_custom_1487151215120 vc_row-has-fill">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">About Us</li>
                    </ol>
                </div>

                <?php
                $head = explode('-heading-', $post_info[0]['heading']);
                $content = explode('-content-', $post_info[0]['content']);
                $img = (json_decode($post_info[0]['cms_img']));
//print_r($img);
                ?>
               
            </div>
        </div>
    </div>
    <div class="section-element vc_custom_1452526618788">
        <div class="container">
            <div class="row">
                <div class="wpb_column column_container col-sm-6">
                    <div class="vc_column-inner ">
                        <div class="wpb_wrapper">
                            <h2 style="font-size: 35px;text-align: left;font-family:Montserrat;font-weight:400;font-style:normal;margin-bottom: 20px;" class="vc_custom_heading vc_custom_1492450870599"><?= (!empty($post_info[0]['heading']) && !empty($head[0]) ? $head[0] : '') ?></h2>
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper">
                                    <!--<p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>-->
                                    <!--<p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>-->
                                    <?= (!empty($post_info[0]['content']) && !empty($content[0]) ? $content[0] : '') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wpb_column column_container col-sm-6">
                    <div class="vc_column-inner ">
                        <div class="wpb_wrapper">
                            <div class="vc_row wpb_row vc_inner vc_row-fluid">
                                <div class="wpb_column column_container col-sm-12">
                                    <div class="vc_column-inner ">
                                        <div class="wpb_wrapper">
                                            <div class="wpb_single_image wpb_content_element vc_align_left  wpb_animate_when_almost_visible wpb_top-to-bottom top-to-bottom wpb_start_animation animated">
                                                <figure class="wpb_wrapper vc_figure">
                                                    <div class="vc_single_image-wrapper vc_box_shadow_3d  vc_box_border_grey"><img height="359" src="<?php echo (!empty($img[0])) ? base_url() . 'backend/assets/img/cms/' . $img[0] : base_url() . 'frontend/assets/images/about.jpg'; ?>" class="img-responsive vc_single_image-img attachment-full" alt=""></div>
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-element">
        <div class="container">
            <div class="row">
                <div class="wpb_column column_container col-sm-12">
                    <div class="vc_column-inner ">
                        <div class="wpb_wrapper">
                            <h2 style="text-align: left;font-family:Montserrat;font-weight:400;font-style:normal" class="vc_custom_heading vc_custom_1452527436573">Meet Our Team</h2>
                            <div class="vc_row wpb_row vc_inner vc_row-fluid vc_custom_1452527242260">
                                <div class="wpb_column column_container col-sm-4">
                                    <div class="vc_column-inner ">
                                        <div class="wpb_wrapper">
                                            <div class="wpb_single_image wpb_content_element vc_align_center  wpb_animate_when_almost_visible wpb_top-to-bottom top-to-bottom vc_custom_1487151159765">
                                                <figure class="wpb_wrapper vc_figure">
                                                    <div class="vc_single_image-wrapper vc_box_border_grey">
                                                        <img width="450" height="450" src="<?php echo (!empty($img[2])) ? base_url() . 'backend/assets/img/cms/' . $img[2] : base_url() . 'frontend/assets/images/about.jpg'; ?>" class="vc_single_image-img attachment-full" alt=""></div>
                                                </figure>
                                            </div>
                                            <div class="wpb_text_column wpb_content_element  vc_custom_1452527091697">
                                                <div class="wpb_wrapper">
                                                    <h3><?= (!empty($post_info[0]['heading']) && !empty($head[2]) ? $head[2] : '') ?></h3>
                                                    <p>   <?= (!empty($post_info[0]['content']) && !empty($content[2]) ? ($content[2]) : '') ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wpb_column column_container col-sm-4">
                                    <div class="vc_column-inner ">
                                        <div class="wpb_wrapper">
                                            <div class="wpb_single_image wpb_content_element vc_align_center  wpb_animate_when_almost_visible wpb_top-to-bottom top-to-bottom vc_custom_1487151169184">
                                                <figure class="wpb_wrapper vc_figure">
                                                    <div class="vc_single_image-wrapper   vc_box_border_grey">
                                                        <img width="450" height="450" src="<?php echo (!empty($img[3])) ? base_url() . 'backend/assets/img/cms/' . $img[3] : base_url() . 'frontend/assets/images/about.jpg'; ?>" class="vc_single_image-img attachment-full" alt=""></div>
                                                </figure>
                                            </div>
                                            <div class="wpb_text_column wpb_content_element  vc_custom_1452527293081">
                                                <div class="wpb_wrapper">
                                                    <h3><?= (!empty($post_info[0]['heading']) && !empty($head[3]) ? $head[3] : '') ?></h3>
                                                    <p>   <?= (!empty($post_info[0]['content']) && !empty($content[3]) ? ($content[3]) : '') ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wpb_column column_container col-sm-4">
                                    <div class="vc_column-inner ">
                                        <div class="wpb_wrapper">
                                            <div class="wpb_single_image wpb_content_element vc_align_center  wpb_animate_when_almost_visible wpb_top-to-bottom top-to-bottom vc_custom_1487151178858">
                                                <figure class="wpb_wrapper vc_figure">
                                                    <div class="vc_single_image-wrapper vc_box_border_grey"><img width="450" height="450" src="<?php echo (!empty($img[4])) ? base_url() . 'backend/assets/img/cms/' . $img[4] : base_url() . 'frontend/assets/images/about.jpg'; ?>" class="vc_single_image-img attachment-full" alt=""></div>
                                                </figure>
                                            </div>
                                            <div class="wpb_text_column wpb_content_element  vc_custom_1452527312165">
                                                <div class="wpb_wrapper">
                                                    <h3><?= (!empty($post_info[0]['heading']) && !empty($head[4]) ? $head[4] : '') ?></h3>
                                                    <p>   <?= (!empty($post_info[0]['content']) && !empty($content[4]) ? ($content[4]) : '') ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-element vc_custom_1452526631034" style="margin-top: 50px;margin-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="wpb_column column_container col-sm-6">
                    <div class="vc_column-inner ">
                        <div class="wpb_wrapper">
                            <div class="vc_row wpb_row vc_inner vc_row-fluid">
                                <div class="wpb_column column_container col-sm-12">
                                    <div class="vc_column-inner ">
                                        <div class="wpb_wrapper">
                                            <div class="wpb_single_image wpb_content_element vc_align_left  wpb_animate_when_almost_visible wpb_top-to-bottom top-to-bottom wpb_start_animation animated">
                                                <figure class="wpb_wrapper vc_figure">
                                                    <div class="vc_single_image-wrapper vc_box_shadow_3d  vc_box_border_grey"><img width="561" height="359" src="<?php echo (!empty($img[1])) ? base_url() . 'backend/assets/img/cms/' . $img[1] : base_url() . 'frontend/assets/images/about.jpg'; ?>" class="vc_single_image-img attachment-full" alt=""></div>
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wpb_column column_container col-sm-6">
                    <div class="vc_column-inner ">
                        <div class="wpb_wrapper">
                            <h2 style="color: #444444;text-align: left;font-family:Montserrat;font-weight:400;font-style:normal;font-size: 30px;margin-top: 20px;margin-bottom: 30px !important;" class="vc_custom_heading vc_custom_1452525629634"><?= (!empty($post_info[0]['heading']) && !empty($head[1]) ? $head[1] : '') ?></h2>
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper">
                                    <?= (!empty($post_info[0]['content']) && !empty($content[1]) ? ($content[1]) : '') ?>

                                    <!--                                    <h5><em>Ut enim ad minim veniam, quis nostrud exerctation ullamco .</em></h5>
                                                                        <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
                                                                        </p>
                                                                        <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                                                                        </p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>