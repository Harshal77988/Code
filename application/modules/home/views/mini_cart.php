<?php if (isset($cart_items) && !empty($cart_items)) {
        foreach ($cart_items as $sid => $cData) {?>
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
                <a href="<?=base_url()?>product/<?=$cData['id']?>/<?=$cData['category_id'] ?>"><?php if (strlen($cData['name']) > 20) { ?>
                        <?=substr($cData['name'], 0, 18) . '..'; ?>
                    <?php } else { ?>
                        <?=$cData['name'] ?>
                    <?php } ?></a>
                <div class="close"><a class="btn btn-xs remove" title="Remove" onclick="funDeleteCartProduct('<?=$sid; ?>', '<?=floatval($cData['internal_price']) ?>');" type="button"><i class="fa fa-times"></i></a></div>
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
    <a href="<?=base_url('home/cart')?>" class="cart-btn">VIEW CART </a> 
    <!-- <a href="<?=base_url('home/checkout')?>" class="cart-btn">CHECKOUT</a> -->
    <?php } else {?>
    <div class="total text-center">
        <strong>Your cart is empty</strong>
    </div>
    <?php } ?>