<?php if(isset($product_details) && !empty($product_details)) {
    foreach ($product_details as $value) {
        $image_url = json_decode($value['image_url'], true);?>
        <div class="col-xs-12 col-sm-6 col-md-3 product_link">
            <!-- .pro-text -->
            <div class="pro-text text-center">
                <!-- .pro-img -->
                <div class="pro-img" onclick="window.location.href='<?=base_url()?>product_detail/<?=$value['product_id']?>'">
                    <?php if(!empty($image_url[0])) {
                    $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_url[0]);
                        echo stripos($headers[0],"200 OK") ? '<img class="img-responsive" src="'.base_url().'frontend/assets/images/products/'.$image_url[0].'">' : '<img class="img-responsive" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                    <!-- <img class="img-responsive" src="<?=base_url() ?>frontend/assets/images/products/<?=$image_url[0]?>" alt="2"> -->
                    <?php } else {?>
                    <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                    <?php } ?>
                    <!-- .hover-icon -->
                    <div class="hover-icon"> <a onclick="addToWishList(<?=$value['product_id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>product_detail/<?=$value['product_id']?>"><span class="icon icon-Search"></span></a> <!-- <a href="#"><span class="icon icon-Restart"></span></a> --> </div>
                    <!-- /.hover-icon -->
                </div>
                <!-- /.pro-img -->
                <div class="pro-text-outer"> 
                    <span><?=$value['category_name']?></span>
                    <a href="<?=base_url()?>product_detail/<?=$value['product_id']?>">
                        <h4><?=substr($value['product_name'], 0, 20)?></h4>
                    </a>
                    <input type="hidden" id="item_id_<?=$value['product_id'] ?>" name="item_id" value="<?=$value['product_id'] ?>"/>
                    <input type="hidden" id="name_<?=$value['product_id'] ?>" name="name" value="<?=$value['product_name'] ?>"/>
                    <?php if (isset($value['discounted_price']) && !empty($value['discounted_price'])) { ?>
                    <input type="hidden" id="price_<?=$value['product_id'] ?>" name="price" value="<?=$value['discounted_price']?>"/>
                    <?php } else { ?>
                    <input type="hidden" id="price_<?=$value['product_id'] ?>" name="price" value="<?=$value['price'] ?>"/>
                    <?php } ?>
                    <input type="hidden" id="img_url_<?=$value['product_id'] ?>" name="img_url" value="<?=$image_url[0] ?>"/>
                    <p class="wk-price"><?php if(!empty($value['discounted_price'])) {?>
                        &dollar;<?=$value['discounted_price']?> <span class="line-through">$<?=$value["price"]?></span>
                        <?php } else { ?>
                        &dollar;<?=$value['price']?>
                        <?php } ?></p>
                        <?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>
                        <!-- <a class="new_wishlist" onclick="addToWishList(<?=$value['product_id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart icon-heart-new"></span></a>  -->
                        <a onclick="addToCart(<?=$value['product_id'] ?>)" class="add-btn">Add to cart</a>
                        <!-- <a class="new_wishlist" href="<?=base_url()?>product_detail/<?=$value['product_id']?>"><span class="icon icon-Search icon-heart-new"></span></a> -->
                        <?php } else {?>
                            <a class="add-btn">Out of stock</a>
                        <?php } ?>
                </div>
            </div>
            <!-- /.pro-text -->
        </div>
    <?php }
    } else {?>
        <div class="col-sm-8 col-md-offset-2" style="margin-top: 20px">
            <center><img src="<?=base_url()?>frontend/assets/images/no-product-found.png" class="img-responsive"></center>
            <center>
                The category you have selected does not contain products. Perhaps you can select another category
                <!-- <a href="#" style="color: #B11E22;">Homepage</a>  -->
                and see if you can find what you are looking for.
            </center>
            <!-- <p>Product not found for this category</p> -->
        </div>
    <?php } ?>

    <div class="col-xs-12">
        <div class="grid-spr pag">
            <?php echo $this->ajax_pagination->create_links(); ?>
        </div>
    </div>