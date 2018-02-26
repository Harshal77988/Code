<section class="banner">
    <div class="container">
        <div class="row">
            <div class="deal-section deal-section2">
                <div class="title"><h2>Highlighted Products</h2></div>
                <div id="feature-banner" class="owl-carousel owl-theme">
                    <?php if(isset($highlighted_products) && !empty($highlighted_products)) {
                        $size_of = 0;
                        foreach ($highlighted_products as $value) {
                            $highlighted_discount=(($value['price']-$value['highlighted_price'])/$value['price'])*100;
                            $img_url = $value['img_url'];
                            ?>
                            <div class="item">
                                <div class="">
                                    <!-- banner-img -->
                                    <a href="<?=base_url()?>product_detail/<?=$value['product_id']?>" class="banner-img" style="background-image: url('<?=base_url()?>frontend/assets/images/products/highlighted_products/<?=$img_url?>');">
                                        <!-- banner-text -->
                                        <div class="banner-text">
                                            <span class="hot-text"><?=$value['sale_type']?></span>
                                            <h5><?=$value['product_title']?></h5>
                                            <p>Sale up to
                                                <?=round($highlighted_discount,2)?>% off</p>
                                            <span class="price"><span>Price:</span> $
                                            <?=$value['highlighted_price']?>
                                                </span>
                                        </div>
                                        <!-- /banner-text -->
                                    </a>
                                    <!-- /banner-img -->
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="deal-section deal-section2">
<div class="container">
<div class="row">
<div class="col-md-3">
    <?php if(!empty($dow_products)){ ?>
    <div class="deal-week deal-week2">
        <div class="title">
            <h2>Deals Of The Week</h2>
        </div>
        <div class="owl-demo-outer">
            <!-- #owl-demo -->
            <div id="owl-demo" class="deals-wk">
                <?php 
                $dow_details = array();
                if(!empty($dow_products)){
                    foreach($dow_products as $value){
                        array_push($dow_details,array('product_id'=>$value['product_id'], 'date_time'=>$value['end_date_time']));
                        
                        $image_url = json_decode($value['image_url'], true);?>
                <div class="item">
                    <div class="col-md-12">
                        <div class="pro-text text-center">
                            <div class="pro-img" onclick="window.location.href='<?=base_url()?>product_detail/<?=$value['product_id']?>'">
                                <img src="<?php if(!empty($image_url)){echo base_url().'frontend/assets/images/products/'.$image_url['0'];}else{echo base_url().'frontend/assets/images/wk-deal-img.jpg';}?>" alt="2" />
                            </div>
                            <div class="text-text">
                                <span><?=substr($value['category_name'], 0,25)?></span>
                                <h4> <?=$value['product_name']?></h4>
                                <p class="wk-price"><?=(!empty($value['price']) ? '$'.$value['price']:'')?><span class="line-through"><?=(!empty($value['discounted_price']) ? '$'.$value['discounted_price']:'')?></span>
                                </p>
                                <a href="#" onclick="addToCart('<?=$value['product_id']?>')" class="add-btn">Add to cart</a>
                            </div>
                            <div id="clockdiv">
                                <h4>Hurry Up! Offer ends in:</h4>
                                <div>
                                    <span class="days" id="dow_days_<?=$value['product_id']?>">14</span>
                                    <div class="smalltext">Days</div>
                                </div>
                                <div>
                                    <span class="hours" id="dow_hours_<?=$value['product_id']?>">23</span>
                                    <div class="smalltext">Hours</div>
                                </div>
                                <div>
                                    <span class="minutes" id="dow_minutes_<?=$value['product_id']?>">59</span>
                                    <div class="smalltext">Minutes</div>
                                </div>
                                <div>
                                    <span class="seconds" id="dow_seconds_<?=$value['product_id']?>">47</span>
                                    <div class="smalltext">Seconds</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }
                } ?>                
                <!-- /#owl-demo -->
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- <div class="weight">                        
        <div class="ads-lft2">
            <img src="<?=base_url()?>frontend/assets/images/add-banner2.jpg" alt="add-banner2"> 
        </div>
    </div> -->
    <!-- on-sale -->
    <?php if(!empty($os_products)) { ?>
    <div class="on-sale">
        <!-- title -->
        <div class="title">
            <h2>On-Sale Products</h2>
        </div>
        <!-- /title -->
        <!-- electonics -->
        <div class="electonics ">
            <div class="col-md-12">
                <div class="row">
                    <!-- tab-pane -->
                    <div class="owl-demo-outer">
                        <!-- #owl-demo -->
                        <div id="owl-demo4" class="deals-wk2">
                            <div class="item">
                                <div class="row">
                                    <?php if(!empty($os_products)) {
                                    $p_counter = 0;
                                    foreach($os_products as $value){ //echo $p_counter.': '.$value['product_name'];
                                    $image_url = json_decode($value['image_url'], true);
                                    ?>
                                    <?php if($p_counter>0 && $p_counter%2==0){ //echo 'NEW_TAB  '.$value['product_name']; ?>
                                </div>
                            </div>
                            <div class="item">
                                <div class="row">
                                    <?php } ?>
                                    <div class="col-sm-6 col-md-12">
                                        <div class="e-product e-product2">
                                            <div class="pro-img">
                                                <img src="<?php if(!empty($image_url)){echo base_url().'frontend/assets/images/products/'.$image_url['0'];}else{echo base_url().'frontend/assets/images/products/digital/5.jpg';}?>" alt="2">
                                            </div>
                                            <div class="pro-text-outer">
                                                <span><?=$value['product_name']?></span>
                                                <a href="<?=base_url()?>product_detail/<?=$value['product_id']?>">
                                                    <h4> <?=$value['short_description']?> </h4>
                                                </a>
                                                <p class="wk-price"><?=(!empty($value['price']) ? '$'.$value['price']:'')?><span class="line-through"><?=(!empty($value['discounted_price']) ? '$'.$value['discounted_price']:'')?></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $p_counter++;}
                                } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- /on-sale -->
    <!-- BLOG -->
    <div class="home-blog latest-blog">
        <!-- title -->
        <div class="title">
            <h2>Latest Blog</h2>
        </div>
        <!-- /title -->
        <div class="col-md-12">
            <div class="row">
                <div class="owl-demo-outer">
                    <!-- #owl-demo -->
                    <div id="owl-demo2" class="deals-wk2">
                        <?php foreach($blog_posts as $value){?>
                        <div class="item">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-12">
                                    <div class="blog-outer">
                                        <div class="blog-img">
                                            <img src="<?php if(!empty($value['blog_image'])){ echo base_url().'/backend/uploads/blogs/395x250/'.$value['blog_image'];}else{ echo 'frontend/assets/images/lt-blog-img1.jpg';}?>" alt="lt-blog-img1">
                                        </div>
                                        <div class="blog-text-outer">
                                            <a href="#">
                                                <h4><?=$value['post_title']?></h4>
                                            </a>
                                            <p><span class="dt"><?=$value['posted_on']?></span> by <span class="ath"><?=$value['first_name'].' '.$value['last_name']?></span></p>
                                            <p class="content-text">
                                                <?=substr($value['post_content'],0,100).'...'?>
                                            </p>
                                            <a href="<?=base_url().'/blog-details/'.$value['post_id']?>" class="add-btn">read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /BLOG -->
</div>
<div class="col-md-9">
    <!-- title -->
    <div class="title">
        <h2>Bestseller Products</h2>
        <ul class="nav nav-tabs etabs">
            <?php if (isset($product_categories) && !empty($product_categories)) {?>
            <?php $count_cat = 0;
            for ($i = 0; $i < 5 ; $i++) {?>
                <li class="<?=(!empty($active) ? $active : '')?>">
                    <a onclick="loadBestSellerProducts(<?=$product_categories[$i]['id']?>)" data-toggle="tab">
                        <?=substr($product_categories[$i]['name'], 0, 17); ?>
                    </a>
                </li>
            <?php }
            } ?>
        </ul>
    </div>
    <!-- /title -->
    <!-- electonics -->
    <div class="electonics replace_bestseller_div" style="margin-bottom: 20px">
        <div class="col-md-12">
            <div class="row">
                <!-- tab-content -->
                <div class="tab-content grid-shop">
                    <!-- tab-pane -->
                    <div id="phones" class="tab-pane fade in active">
                        <div class="owl-demo-outer">
                            <!-- #owl-demo -->
                            <div id="owl-demo3" class="deals-wk2">
                                <div class="item">
                                    <?php
                                if(isset($bestseller_product) && !empty($bestseller_product)) {
                                    $size_of = 0;
                                    foreach ($bestseller_product as $value) {
                                        $image_url = json_decode($value['image_url'], true);?>                                        
                                    <div class="col-sm-20 product_link">
                                        <!-- .pro-text -->
                                        <div class="pro-text text-center">
                                            <!-- .pro-img -->
                                            <div class="pro-img" onclick="window.location.href='<?=base_url()?>product_detail/<?=$value['id']?>'">
                                                <?php if(!empty($image_url[0])) {
                                                        $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_url[0]);
                                                        echo stripos($headers[0],"200 OK") ? '<img class="img-responsive" src="'.base_url().'frontend/assets/images/products/'.$image_url[0].'">' : '<img class="img-responsive" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                                                <!-- <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/products/<?=$image_url[0]?>"> -->
                                                <?php } else {?>
                                                <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                                <?php } ?>
                                                <!-- .hover-icon -->
                                                <div class="hover-icon"> <a onclick="addToWishList(<?=$value['id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>product_detail/<?=$value['id']?>"><span class="icon icon-Search"></span></a>
                                                    <!--<a href="#"><span class="icon icon-Restart"></span></a>-->
                                                </div>
                                                <!-- /.hover-icon -->
                                            </div>
                                            <!-- /.pro-img -->
                                            <div class="pro-text-outer">
                                                <span><?=substr($value['category_name'], 0,20)?></span>
                                                <a href="<?=base_url().'product_detail/'.$value['id']?>">
                                                    <h4><?=$value['product_name']?></h4>
                                                </a>
                                                <input type="hidden" id="item_id_<?=$value['id'] ?>" name="item_id" value="<?=$value['id'] ?>" />
                                                <input type="hidden" id="name_<?=$value['id'] ?>" name="name" value="<?=$value['product_name'] ?>" />
                                                <?php if (isset($value['discounted_price']) && !empty($value['discounted_price'])) { ?>
                                                <input type="hidden" id="price_<?=$value['id'] ?>" name="price" value="<?=$value['discounted_price']?>" />
                                                <?php } else { ?>
                                                <input type="hidden" id="price_<?=$value['id'] ?>" name="price" value="<?=$value['price'] ?>" />
                                                <?php } ?>
                                                <input type="hidden" id="img_url_<?=$value['id'] ?>" name="img_url" value="<?=$image_url[0] ?>" />
                                                <p class="wk-price"><?php if(!empty($value['discounted_price'])) {?> &dollar;<?=$value['discounted_price']?> <span class="line-through">$<?=$value["price"]?></span><?php } else { ?> $<?=$value['price']?><?php } ?>
                                                </p>
                                                <?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>
                                                <!-- <a class="new_wishlist" onclick="addToWishList(<?=$value['id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart icon-heart-new"></span></a>  -->
                                                <a onclick="addToCart(<?=$value['id'] ?>)" class="add-btn">Add to cart</a>
                                                <!-- <a class="new_wishlist" href="<?=base_url()?>product_detail/<?=$value['id']?>"><span class="icon icon-Search icon-heart-new"></span></a> -->
                                                <?php } else {?>
                                                <a onclick="addToCart(<?=$value['id'] ?>)" class="add-btn">Out of stock</a>
                                                <!-- <a class="add-btn">Out of stock</a> -->
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- /.pro-text -->
                                    </div>
                                    <?php
                                        $size_of++;
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /tab-pane -->
                </div>
                <!-- /tab-content -->
            </div>
        </div>
    </div>
    <!-- /electonics -->
    <!-- half-banner -->
    <div class="half-banner">
        <div class="row">
            <div class="col-md-12">
                <a href="#" class="banner half-banner5" style="background-image: url('<?php if(!empty($site_settings['header_banner'])){ echo base_url().'/backend/assets/img/'.$site_settings['header_banner'];} else { echo base_url().'frontend/assets/images/products/highlighted_products/42/banner-img5.jpg';} ?>');">
                    <!-- <div class="text">
                            <h4>best digital</h4>
                            <h3>sale smartwatch</h3>
                            <div class="banner-price">
                                $620.00 <span>$60.00  </span>
                            </div>
                        </div> -->
                </a>
            </div>
        </div>
    </div>
    <!-- /half-banner -->
    <!-- title -->
    <div class="title">
        <h2>Featured Products</h2>
        <ul class="nav nav-tabs etabs">
            <?php if (isset($product_categories) && !empty($product_categories)) {
                for ($i = 0; $i < 5 ; $i++) {?>
                <li class="<?=(!empty($active) ? $active : '')?>">
                    <a onclick="loadFeaturedProducts(<?=$product_categories[$i]['id']?>)" data-toggle="tab">
                        <?=substr($product_categories[$i]['name'], 0, 17); ?>
                    </a>
                </li>
                <?php }
                } ?>
        </ul>
    </div>
    <!-- /title -->
    <!-- electonics -->
    <div class="electonics replace_featured_div" style="margin-bottom: 20px">
        <div class="col-md-12">
            <div class="row">
                <!-- tab-content -->
                <div class="tab-content grid-shop">
                    <!-- tab-pane -->
                    <div id="phones2" class="tab-pane fade in active">
                        <div class="owl-demo-outer">
                            <!-- #owl-demo -->
                            <div id="owl-demo6" class="deals-wk2">
                                <div class="item">
                                    <?php if(isset($featured_products) && !empty($featured_products)) {
                                            $size_of = 0;
                                            foreach ($featured_products as $value) {
                                                $image_url = json_decode($value['image_url'], true);
                                                if($size_of > 0 && $size_of%4 == 0) {?>
                                </div>
                                <div class="item">
                                    <?php } ?>
                                    <div class="col-sm-20 product_link">
                                        <!-- .pro-text -->
                                        <div class="pro-text text-center">
                                            <!-- .pro-img -->
                                            <div class="pro-img" onclick="window.location.href='<?=base_url()?>product_detail/<?=$value['id']?>'">
                                                <?php if(!empty($image_url[0])) {
                                                    $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_url[0]);
                                                    echo stripos($headers[0],"200 OK") ? '<img class="img-responsive" src="'.base_url().'frontend/assets/images/products/'.$image_url[0].'">' : '<img class="img-responsive" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                                                <!-- <img class="img-responsive" src="<?=base_url() ?>frontend/assets/images/products/<?=$image_url[0]?>" alt="2"> -->
                                                <?php } else {?>
                                                <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                                <?php } ?>
                                                <!-- .hover-icon -->
                                                <div class="hover-icon"> <a onclick="addToWishList(<?=$value['id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>product_detail/<?=$value['id']?>"><span class="icon icon-Search"></span></a>
                                                    <!--<a href="#"><span class="icon icon-Restart"></span></a>--></div>
                                                <!-- /.hover-icon -->
                                            </div>
                                            <!-- /.pro-img -->
                                            <div class="pro-text-outer">
                                                <span><?=substr($value['category_name'], 0,20)?></span>
                                                <a href="<?=base_url().'product_detail/'.$value['id']?>">
                                                    <h4><?=$value['product_name']?></h4>
                                                </a>
                                                <input type="hidden" id="item_id_<?=$value['id'] ?>" name="item_id" value="<?=$value['id'] ?>" />
                                                <input type="hidden" id="name_<?=$value['id'] ?>" name="name" value="<?=$value['product_name'] ?>" />
                                                <?php if (isset($pData['discounted_price']) && !empty($pData['discounted_price'])) { ?>
                                                <input type="hidden" id="price_<?=$value['id'] ?>" name="price" value="<?=$value['discounted_price']?>" />
                                                <?php } else { ?>
                                                <input type="hidden" id="price_<?=$value['id'] ?>" name="price" value="<?=$value['price'] ?>" />
                                                <?php } ?>
                                                <input type="hidden" id="img_url_<?=$value['id'] ?>" name="img_url" value="<?=$image_url[0] ?>" />
                                                <p class="wk-price">
                                                    <?php if(!empty($value['discounted_price'])) {?> &dollar;<?=$value['discounted_price']?> <span class="line-through">$<?=$value["price"]?></span><?php } else { ?> &dollar;<?=$value['price']?><?php } ?>
                                                </p>
                                                <?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>
                                                <!-- <a class="new_wishlist" onclick="addToWishList(<?=$value['id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart icon-heart-new"></span></a>  -->
                                                <a onclick="addToCart(<?=$value['id'] ?>)" class="add-btn">Add to cart</a>
                                                <!-- <a class="new_wishlist" href="<?=base_url()?>product_detail/<?=$value['id']?>"><span class="icon icon-Search icon-heart-new"></span></a> -->
                                                <?php } else {?>
                                                <a class="add-btn">Out of stock</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- /.pro-text -->
                                    </div>
                                    <?php
                                                        $size_of++;
                                                    }
                                                }
                                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /tab-pane -->
                </div>
                <!-- /tab-content -->
            </div>
        </div>
    </div>
    <!-- /electonics -->
    <!-- full-banner -->
    <div class="half-banner">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <a href="#" class="banner half-banner">
                    <img src="<?php if(!empty($site_settings['footer_banner'])){ echo base_url().'/backend/assets/img/'.$site_settings['footer_banner'];}else{ echo base_url().'frontend/assets/images/products/highlighted_products/42/banner-img5.jpg';} ?>" alt="add banner large">
                </a>
            </div>
        </div>
    </div>
    <!-- /full-banner -->
    <div class="title">
        <h2>On Rent Products</h2>
        <!-- <ul class="nav nav-tabs etabs">
            <li class="active"><a data-toggle="tab" href="#phones3">Cell Phones</a></li>
            <li><a data-toggle="tab" href="#laptop3">Laptop</a></li>
            <li><a data-toggle="tab" href="#desktop3">Desktop</a></li>
            <li><a data-toggle="tab" href="#tV3">TV &amp; Video</a></li>
            <li><a data-toggle="tab" href="#tablets3">Tablets</a></li>
        </ul> -->
    </div>
    <div class="electonics replace_featured_div" style="margin-bottom: 20px">
        <div class="col-md-12">
            <div class="row">
                <!-- tab-content -->
                <div class="tab-content grid-shop">
                    <!-- tab-pane -->
                    <div id="phones2" class="tab-pane fade in active">
                        <div class="owl-demo-outer">
                            <!-- #owl-demo -->
                            <div id="owl-demo6" class="deals-wk2">
                                <div class="item">
                                    <?php if(isset($on_rent_products) && !empty($on_rent_products)) {
                                    $size_of = 0;
                                    foreach ($on_rent_products as $value) {
                                        $image_url = json_decode($value['image_url'], true);
                                        if($size_of > 0 && $size_of%4 == 0) {?>
                                </div>
                                <div class="item">
                                    <?php } ?>
                                    <?php 
                                        $arr = explode(",", $value['subcategory_id']);
                                        $first = $arr[0];
                                    ?>
                                    <div class="col-xs-12 col-sm-3 col-md-3 product_link">
                                        <!-- .pro-text -->
                                        <div class="pro-text text-center">
                                            <!-- .pro-img -->
                                            <div class="pro-img" onclick="window.location.href='<?=base_url()?>home/rent_product_detail/<?=$value['id']?>/<?=$first?>'">
                                                <?php if(!empty($image_url[0])) {
                                                    $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_url[0]);
                                                    echo stripos($headers[0],"200 OK") ? '<img class="img-responsive" src="'.base_url().'frontend/assets/images/products/'.$image_url[0].'">' : '<img class="img-responsive" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                                                <?php } else {?>
                                                <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                                <?php } ?>
                                                <!-- .hover-icon -->
                                                <div class="hover-icon"> <a onclick="addToWishList(<?=$value['id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>home/rent_product_detail/<?=$value['id']?>/<?=$first?>"><span class="icon icon-Search"></span></a>
                                                </div>
                                                <!-- /.hover-icon -->
                                            </div>
                                            <!-- /.pro-img -->
                                            <div class="pro-text-outer">
                                                <!-- <span><?=$value['category_name']?></span> -->
                                                <a href="<?=base_url()?>home/rent_product_detail/<?=$value['id']?>/<?=$first?>">
                                                    <h4><?=$value['product_name']?></h4>
                                                </a>
                                                <input type="hidden" id="item_id_<?=$value['id'] ?>" name="item_id" value="<?=$value['id'] ?>" />
                                                <input type="hidden" id="name_<?=$value['id'] ?>" name="name" value="<?=$value['product_name'] ?>" />
                                                <input type="hidden" id="price_<?=$value['id'] ?>" name="price" value="<?=$value['rent'] ?>" />
                                                <input type="hidden" id="img_url_<?=$value['id'] ?>" name="img_url" value="<?=$image_url[0] ?>" />
                                                <p class="wk-price1">&dollar;<?=$value['rent']?><span>/<?php if($value['plan'] == '0') { echo $per = 'week'; } elseif ($value['plan'] == '1') { echo $per = 'month'; } elseif ($value['plan'] == '2') { echo $per = "year"; } elseif ($value['plan'] == '3') { echo $per = "Hour"; } elseif ($value['plan'] == '4') { echo $per = "Day"; }?></span>
                                                </p>
                                                <a href="<?=base_url()?>home/rent_product_detail/<?=$value['id']?>/<?=$first?>" class="add-btn">View Detail</a>
                                            </div>
                                        </div>
                                        <!-- /.pro-text -->
                                    </div>
                                    <?php
                                        $size_of++;
                                    }
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /tab-pane -->
                </div>
                <!-- /tab-content -->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- free-shipping -->
    <div class="free-shipping">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="icon-shipping">
                    <i class="icon-rocket icons"></i>
                </div>
                <div class="shipping-text">
                    <h4>free shipping </h4>
                    <p>Free Shipping On All Order</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="icon-shipping">
                    <i class="icon-earphones-alt icons"></i>
                </div>
                <div class="shipping-text">
                    <h4>online support 24/7</h4>
                    <p>Technical Support 24/7</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="icon-shipping">
                    <i class="icon-refresh icons"></i>
                </div>
                <div class="shipping-text">
                    <h4>MONEY BACK GUARANTEE </h4>
                    <p>30 Day Money Back</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="icon-shipping">
                    <i class="icon-badge icons"></i>
                </div>
                <div class="shipping-text">
                    <h4>MEMBER DISCOUNT</h4>
                    <p>Upto 40% Discount</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /free-shipping -->
</div>
</div>
</section>
<script type="text/javascript">

    // function loadBestSellerProducts(category_id) {
    //     var base_url = $('#base_url').val();
    //     // ajax call
    //     $.ajax({
    //         type: "POST",
    //         url: base_url + 'home/loadBestsellerProductsByCategory',
    //         dataType:'json',
    //         data: {'category_id':category_id},
    //         success: function (response) {
    //             // alert(response.status);
    //             // var parsed = $.parseJSON(response);
    //             $('.replace_bestseller_div').html('');
    //             $('.replace_bestseller_div').html(response.content);
    //         }
    //     });
    // }
    
    // function loadFeaturedProducts(category_id) {
    //     var base_url = $('#base_url').val();
    //     // ajax call
    //     $.ajax({
    //         type: "POST",
    //         url: base_url + 'home/loadFeaturedProductsByCategory',
    //         dataType:'json',
    //         data: {'category_id':category_id},
    //         success: function (response) {
    //             // alert(response.status);
    //             // var parsed = $.parseJSON(response);
    //             $('.replace_featured_div').html('');
    //             $('.replace_featured_div').html(response.content);
    //         }
    //     });
    // }

function countdownTimer(countDownDate, product_id_flag) {
// Update the count down every 1 second
var x = setInterval(function() {

// Get todays date and time
var now = new Date().getTime();

// Find the distance between now an the count down date
var distance = countDownDate - now;

// Time calculations for days, hours, minutes and seconds
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);

// Output the result in an element with id="demo"

// document.getElementById("demo").innerHTML = days + "d " + hours + "h "+ minutes + "m " + seconds + "s ";

document.getElementById("dow_days_" + product_id_flag).innerHTML = days;
document.getElementById("dow_hours_" + product_id_flag).innerHTML = hours;
document.getElementById("dow_minutes_" + product_id_flag).innerHTML = minutes;
document.getElementById("dow_seconds_" + product_id_flag).innerHTML = seconds;

// If the count down is over, write some text 
if (distance < 0) {
clearInterval(x);
// document.getElementById("demo").innerHTML = "EXPIRED";
document.getElementById("dow_days_" + product_id_flag).innerHTML = '0';
document.getElementById("dow_hours_" + product_id_flag).innerHTML = '0';
document.getElementById("dow_minutes_" + product_id_flag).innerHTML = '0';
document.getElementById("dow_seconds_" + product_id_flag).innerHTML = '0';


}
}, 1000);
}


var users = <?php echo json_encode($dow_details); ?>;

for (var i = 0; i < users.length; i++) {
var product_id_flag = users[i]['product_id'];
// alert(users[i]['product_id']+ ' date_time : '+users[i]['date_time']);

// Set the date we're counting down to
// var countDownDate = new Date("jan 21, 2018 15:37:25").getTime();
var countDownDate = new Date(users[i]['date_time']).getTime();
countdownTimer(countDownDate, product_id_flag);
}
</script>