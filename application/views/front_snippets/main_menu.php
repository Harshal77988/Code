<div class="container">
    <div class="col-sm-3">
        <div class="logo">
            <h6><a href="<?=base_url()?>"><img src="<?=base_url()?>frontend/assets/images/logo.png" alt="logo" /></a></h6>
        </div>
    </div>
    <div class="col-sm-6">
        <!-- Search box Start -->
        <div class="well carousel-search hidden-phone">
            <div class="btn-group">
                <?php if(!empty($prodcut_cat_detail)) {?>
                <a class="btn dropdown-toggle btn-select" data-toggle="dropdown" href="#"><?=(!empty($category_title) ? $category_title : 'All Categories')?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php foreach ($prodcut_cat_detail as $value) {?>
                    <li class=""><a id="<?=$value['id']?>" style="<?php if(!empty($category_title)) { if($value['name'] == $category_title) { echo 'font-weight: 600'; } } ?>"><?=$value['name']?></a></li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </div>
            <div class="search">
                <input type="text" placeholder="Search here" id="search_param" name="search_param" />
            </div>
            <div class="btn-group">
                <button type="submit" id="btnSearch" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
        <!-- Search box End -->
    </div>
    <div class="col-sm-3">
        <!-- cart-menu -->
        <div class="cart-menu">
            <ul>
                <li><a href="<?=base_url('wishlist')?>"><i class="icon-heart icons" aria-hidden="true"></i></a><span class="wish_subno"><?=(!empty($wishlist_count) ? $wishlist_count : '0')?></span><strong>Your Wishlist</strong></li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="icon-basket-loaded icons" aria-hidden="true"></i></a>                    
                    <span class="subno"><?php echo!empty($cart_summary['total_rows']) ? $cart_summary['total_rows'] : '0' ?></span>
                    <strong>Your Cart</strong>
                    <div class="dropdown-menu cart-outer" id="mini_cart_data">
                        <?php if (isset($cart_items) && !empty($cart_items)) {
                            foreach ($cart_items as $sid => $cData) { ?>
                        <div class="cart-content">
                            <div class="col-sm-4 col-md-4">
                                <?php if(!empty($cData['item_url'])) {
                                    $headers = get_headers(base_url().'frontend/assets/images/products/'.$cData['item_url']);
                                    echo stripos($headers[0],"200 OK") ? '<img class="img-responsive" src="'.base_url().'frontend/assets/images/products/'.$cData['item_url'].'">' : '<img class="img-responsive" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                                <?php } else {?>
                                <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                <?php } ?>
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <div class="pro-text">
                                    <a><?php if (strlen($cData['name']) > 20) { ?>
                                            <?=substr($cData['name'], 0, 18) . '..'; ?>
                                        <?php } else { ?>
                                            <?=$cData['name'] ?>
                                        <?php } ?></a>
                                    <div class="close">
                                        <a class="btn btn-xs remove" title="Remove" onclick="funDeleteCartProduct('<?=$sid; ?>', '<?=floatval($cData['internal_price']) ?>');" type="button"><i class="fa fa-times"></i></a>
                                    </div>
                                    <strong><?=$cData['quantity'];?> × $<?=(floatval($cData['internal_price'])); ?></strong>
                                    <strong><?=(!empty($cData['rent_duration']) ? $cData['rent_duration']:'');?></strong>
                                </div>
                            </div>
                        </div>
                        <?php }}?>
                        <?php if (!empty($this->data['cart_items'])) { ?>
                        <div class="total">
                            <div class="col-md-6 text-left">
                                <?php if (!empty($cart_summary['shipping_total']) || $cart_summary['shipping_total'] != 0) { ?>
                                <span>Shipping :</span>
                                <?php } ?>
                                <strong>Total :</strong>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php if (!empty($cart_summary['shipping_total']) || $cart_summary['shipping_total'] != 0) { ?>
                                <span>$<?=$cart_summary['shipping_total']?></span>
                                <?php } ?>
                                <?php if (!empty($cart_summary['item_summary_total'])) { ?>
                                    <strong>$<?php echo $cart_summary['item_summary_total'] ?></strong>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if($this->ion_auth->logged_in()) {?>
                        <!-- <a href="<?=base_url('home/checkout')?>" class="cart-btn">CHECKOUT</a> -->
                        <?php } ?> <a href="<?=base_url('home/cart')?>" class="cart-btn">VIEW CART </a>
                        <?php } else {?>
                        <div class="total text-center">
                            <strong>Your cart is empty</strong>
                        </div>
                        <?php } ?>
                    </div>
                </li>
            </ul>
        </div>
        <!-- cart-menu End -->
    </div>
</div>
<div class="main-menu menu2">
    <div class="container">
    <!--  nav  -->
    <nav class="navbar navbar-inverse navbar-default">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" data-hover="dropdown" data-animations=" fadeInLeft fadeInUp fadeInRight">
            <ul class="nav navbar-nav">                
                <li class="dropdown">
                    <a class="<?=($this->uri->segment(1) == "" ? 'active' : '')?>" href="<?=base_url()?>" role="button" aria-expanded="false"><span>Home</span></a>
                </li>
                <li>
                    <div class="cd-dropdown-wrapper">
                        <a class="cd-dropdown-trigger" href="#">buy</a>
                        <nav class="cd-dropdown">
                            <h2>Buy</h2>
                            <a href="#" class="cd-close">Close</a>
                            <ul class="cd-dropdown-content">
                                <?php if (isset($product_categories) && !empty($product_categories)) {
                                    // echo "<pre>";
                                    // print_r($product_categories); die;
                                foreach ($product_categories as $productCat) {?>
                                <li class="has-children">
                                    <a href="#"><?=$productCat['name'];?></a>
                                    <ul class="cd-secondary-dropdown is-hidden ">
                                        <div class="align-img-megamenu">
                                            <img src="<?=base_url()?>frontend/assets/images/category_images/<?=$productCat['img_url']?>" class="megamenu-bottom-img"/>
                                        </div>
                                        <li class="go-back"><a href="#">Menu</a></li>
                                        <!-- <li class="see-all"><a href="#">All Products</a></li> -->
                                        <?php if (isset($productCat['sub_categories']) && !empty($productCat['sub_categories'])) {
                                        $subattr_count = 1;
                                        foreach ($productCat['sub_categories'] as $paData) {
                                            if($subattr_count <= 5) {?>
                                        <li class="has-children">
                                            <a href="#"><?=$paData['name']?></a>
                                            <ul class="is-hidden">
                                                <!-- <li class="go-back"><a href="javascript:;">Echo & Alexa</a></li>
                                                <li class="see-all"><a href="javascript:;">All Echo & Alexa</a></li> -->
                                                <?php if (isset($paData['third_level']) && !empty($paData['third_level'])) {
                                                foreach ($paData['third_level'] as $key => $pathirdData) {?>
                                                <li class="<?php if (isset($pathirdData['forth_level']) && !empty($pathirdData['forth_level'])) { echo 'has-children'; } ?>">
                                                    <a href="<?=base_url().'home/product_list/'.$pathirdData['id']?>"><?=$pathirdData['name']?></a>
                                                    <?php if (isset($pathirdData['forth_level']) && !empty($pathirdData['forth_level'])) {?>
                                                    <ul class="is-hidden">
                                                        <li class="go-back"><a href="javascript:;">Back</a></li>
                                                        <!-- <li class="see-all"><a href="javascript:;">All Option1</a></li> -->
                                                        <?php foreach ($pathirdData['forth_level'] as $paforthData) {?>
                                                        <li><a href="<?=base_url().'home/product_list/'.$paforthData['id']?>"><?=$paforthData['name']?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                    <?php } ?>                                                            
                                                </li>
                                                <?php }
                                                }?>
                                            </ul>
                                        </li>
                                        <?php }
                                            $subattr_count++;
                                        }
                                        if(count($productCat['sub_categories']) > 5) { ?>
                                            <a href="<?=base_url() . 'home/categories/' . $productCat['id']; ?>" >All <?=$productCat['name']; ?></a>
                                        <?php }
                                        }
                                        ?>
                                    </ul> <!-- .cd-secondary-dropdown -->
                                </li> <!-- .has-children -->
                                <?php }
                                }
                                ?>
                            </ul> <!-- .cd-dropdown-content -->
                        </nav> <!-- .cd-dropdown -->
                    </div>
                </li>                
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle <?=($this->uri->segment(2) == "rent_product_list" || $this->uri->segment(1) == "rent_product_detail" ? 'active' : '')?>" data-toggle="dropdown" role="button" aria-expanded="false"><span>Rent</span> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <div class="dropdown-menu dropdownhover-bottom mega-menu" role="menu">
                        <div class="col-sm-12 col-md-12 scroll-drop-menu">
                            <?php if (isset($rent_product_categories) && !empty($rent_product_categories)) {?>
                            <?php
                                $sub_count = 1;
                                foreach ($rent_product_categories as $productCat) {?>
                                <ul>
                                    <li><a href="#"><strong><?=$productCat['name']; ?></strong></a></li>
                                    <?php if (isset($productCat['sub_categories']) && !empty($productCat['sub_categories'])) {
                                        $subattr_count = 1;
                                        foreach ($productCat['sub_categories'] as $paData) {
                                            if($subattr_count <= 5) {?>
                                            <li><a href="<?=base_url(); ?>home/rent_product_list/<?=$productCat['id']?>/<?=$paData['id'] ?>" ><?=$paData['name'] ?></a> </li>
                                            <?php }
                                            $subattr_count++;
                                        }

                                        if(count($productCat['sub_categories']) > 5) { ?>
                                        <a href="<?=base_url() . 'home/categories/' . $productCat['id']; ?>" >All <?=$productCat['name']; ?></a>
                                        <?php }
                                    } ?>
                                </ul>
                                <?php
                                    $sub_count++;
                                } ?>
                            <?php } ?>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a class="<?=($this->uri->segment(1) == "about_us" ? 'active' : '')?>" href="<?=base_url('about_us')?>"><span> About Us</span></a>
                </li>

                <li class="dropdown">
                    <a class="<?=($this->uri->segment(1) == "blog" || $this->uri->segment(1) == "blog-details" || $this->uri->segment(1) == "blog-category-details-main" ? 'active' : '')?>" href="<?=base_url('blog')?>" role="button" aria-expanded="false"><span>Blog</span></a>
                </li>
                <li class="dropdown">
                    <a class="<?=($this->uri->segment(1) == "contact_us" ? 'active' : '')?>" href="<?=base_url('contact_us')?>"><span>contact</span></a>
                </li>
            </ul>
            <!-- /.navbar-collapse -->
        </div>
    </nav>
    <!-- /nav end -->
    </div>
</div>