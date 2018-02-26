<script type="text/javascript">
    $(".deals-wk4").owlCarousel({     
          navigation : true, // Show next and prev buttons
          paginationSpeed : 400,
          singleItem:true     
  });
</script>
<!-- electonics -->
<!-- <div class="electonics" style="margin-bottom: 20px"> -->
    <div class="col-md-12">
        <div class="row">
            <!-- tab-content -->
            <div class="tab-content grid-shop">
                <!-- tab-pane -->
                <div id="phones" class="tab-pane fade in active">
                    <div class="owl-demo-outer">
                        <!-- #owl-demo -->
                        <div id="owl-demo3" class="deals-wk4">
                            <div class="item">
                                <?php
                                if(isset($bestseller_product) && !empty($bestseller_product)) {                                                
                                    $size_of = 0;
                                    foreach ($bestseller_product as $value) {
                                        $image_url = json_decode($value['image_url'], true);
                                        if($size_of > 0 && $size_of%4 == 0) {?>

                            </div>
                            <div class="item">
                                <?php } ?>
                                <div class="col-xs-12 col-sm-3 col-md-3 product_link">
                                    <!-- .pro-text -->
                                    <div class="pro-text text-center">
                                        <!-- .pro-img -->
                                        <div class="pro-img" onclick="window.location.href='<?=base_url()?>product_detail/<?=$value['product_id']?>'"> 
                                            <?php if(!empty($image_url[0])) {
                                                $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_url[0]);
                                                echo stripos($headers[0],"200 OK") ? '<img class="img-responsive" src="'.base_url().'frontend/assets/images/products/'.$image_url[0].'">' : '<img class="img-responsive" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>                                                   
                                                <!-- <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/products/<?=$image_url[0]?>"> -->
                                                <?php } else {?>
                                                <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                                <?php } ?>
                                                <!-- .hover-icon -->
                                                <div class="hover-icon"> <a onclick="addToWishList(<?=$value['product_id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>product_detail/<?=$value['product_id']?>"><span class="icon icon-Search"></span></a> <!--<a href="#"><span class="icon icon-Restart"></span></a>--> </div>
                                                <!-- /.hover-icon -->
                                            </div>
                                            <!-- /.pro-img -->
                                            <div class="pro-text-outer"> 
                                                <span><?=$value['category_name']?></span>
                                                <a href="<?=base_url().'product_detail/'.$value['product_id']?>">
                                                    <h4><?=$value['product_name']?></h4>
                                                </a>
                                                <input type="hidden" id="item_id_<?=$value['product_id'] ?>" name="item_id" value="<?=$value['product_id'] ?>"/>
                                                <input type="hidden" id="name_<?=$value['product_id'] ?>" name="name" value="<?=$value['product_name'] ?>"/>
                                                <?php if (isset($value['discounted_price']) && !empty($value['discounted_price'])) { ?>
                                                <input type="hidden" id="price_<?=$value['product_id'] ?>" name="price" value="<?=$value['discounted_price']?>"/>
                                                <?php } else { ?>
                                                <input type="hidden" id="price_<?=$value['product_id'] ?>" name="price" value="<?=$value['price'] ?>"/>
                                                <?php } ?>
                                                <input type="hidden" id="img_url_<?=$value['product_id'] ?>" name="img_url" value="<?=$image_url[0] ?>"/>
                                                <p class="wk-price">
                                                    <?php if(!empty($value['discounted_price'])) {?>
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
<!-- </div> -->
<!-- /electonics -->