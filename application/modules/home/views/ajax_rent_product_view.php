<?php if(isset($product_details) && !empty($product_details)) {
    foreach ($product_details as $value) {
        $image_url = json_decode($value['image_url'], true);?>
        <div class="col-xs-12 col-sm-6 col-md-4 product_link">
            <!-- .pro-text -->
            <div class="pro-text text-center">
                <!-- .pro-img -->
                <!-- <div class="pro-img" onclick="window.location.href='<?=base_url()?>product_detail/<?=$value['product_id']?>'">  -->
                <div class="pro-img"> 
                    <?php if(!empty($image_url[0])) {?>
                    <img class="img-responsive" src="<?=base_url() ?>frontend/assets/images/products/<?=$image_url[0]?>" alt="2">                                    
                    <?php } else {?>
                    <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                    <?php } ?>
                    <!-- .hover-icon -->
                    <div class="hover-icon"> <a onclick="addToWishList(<?=$value['product_id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>rent_product_detail/<?=$value['product_id']?>"><span class="icon icon-Search"></span></a> <!-- <a href="#"><span class="icon icon-Restart"></span></a> --> </div>
                    <!-- /.hover-icon -->
                </div>
                <!-- /.pro-img -->
                <div class="pro-text-outer"> 
                    <span><?=$value['category_name']?></span>
                    <a href="<?=base_url()?>rent_product_detail/<?=$value['product_id']?>">
                        <h4><?=substr($value['product_name'], 0, 20)?></h4>
                    </a>
                    <?=form_input(array("type" => "hidden", "id" => "item_id_".$value['product_id'], "name" => "item_id", "value" => $value['product_id']))?>
                    <?=form_input(array("type" => "hidden", "id" => "name_".$value['product_id'], "name" => "name", "value" => $value['product_name']))?>
                    <?=form_input(array("type" => "hidden", "id" => "price_".$value['product_id'], "name" => "rent", "value" => $value['rent']))?>
                    <?=form_input(array("type" => "hidden", "id" => "img_url_".$value['product_id'], "name" => "img_url", "value" => $image_url[0]))?>
                    <p class="wk-price1"><strong><?=(!empty($value["rent"]) ? '$'.$value["rent"] : '$0')?></strong><span>/<?php if($value['plan'] == '0') { echo 'week'; } elseif ($value['plan'] == '1') { echo 'month'; } elseif ($value['plan'] == '2') { echo "year"; } elseif ($value['plan'] == '3') { echo "Hour"; } elseif ($value['plan'] == '4') { echo "Day"; } ?></span></p>
                        <?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>
                        <a href="<?=base_url()?>rent_product_detail/<?=$value['product_id']?>" class="add-btn">View Detail</a>
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
    <?php }
?>