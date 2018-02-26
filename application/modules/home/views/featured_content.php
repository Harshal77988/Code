<script type="text/javascript">
    $(".deals-wk3").owlCarousel({     
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
        <div id="phones2" class="tab-pane fade in active">
            <div class="owl-demo-outer">
                <!-- #owl-demo -->
                <div id="owl-demo6" class="deals-wk3">
                    <div class="item">
                        <?php if(isset($featured_products) && !empty($featured_products)) {
                            $size_of = 0;
                            foreach ($featured_products as $value) {
                                $image_url = json_decode($value['image_url'], true);
                                if($size_of > 0 && $size_of%4 == 0) {?>
                            </div>
                            <div class="item">
                                <?php } ?>
                                <div class="col-xs-12 col-sm-3 col-md-3 product_link">
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
                                                <div class="hover-icon"> <a onclick="addToWishList(<?=$value['id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>product_detail/<?=$value['id']?>"><span class="icon icon-Search"></span></a> <!--<a href="#"><span class="icon icon-Restart"></span></a>--> </div>
                                                <!-- /.hover-icon -->
                                            </div>
                                            <!-- /.pro-img -->
                                            <div class="pro-text-outer"> 
                                                <span><?=$value['category_name']?></span>
                                                <a href="<?=base_url().'product_detail/'.$value['id']?>">
                                                    <h4><?=$value['product_name']?></h4>
                                                </a>
                                                <input type="hidden" id="item_id_<?=$value['id'] ?>" name="item_id" value="<?=$value['id'] ?>"/>
                                                <input type="hidden" id="name_<?=$value['id'] ?>" name="name" value="<?=$value['product_name'] ?>"/>
                                                <?php if (isset($pData['discounted_price']) && !empty($pData['discounted_price'])) { ?>
                                                <input type="hidden" id="price_<?=$value['id'] ?>" name="price" value="<?=$value['discounted_price']?>"/>
                                                <?php } else { ?>
                                                <input type="hidden" id="price_<?=$value['id'] ?>" name="price" value="<?=$value['price'] ?>"/>
                                                <?php } ?>
                                                <input type="hidden" id="img_url_<?=$value['id'] ?>" name="img_url" value="<?=$image_url[0] ?>"/>
                                                <p class="wk-price"><?php if(!empty($value['discounted_price'])) {?>
                                                    &dollar;<?=$value['discounted_price']?> <span class="line-through">$<?=$value["price"]?></span>
                                                    <?php } else { ?>
                                                    &dollar;<?=$value['price']?>
                                                    <?php } ?></p> 
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
<!-- </div> -->
<!-- /electonics -->