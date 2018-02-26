<div class="main-container no-sidebar">
    <div class="container">
        <div class="main-content">
            <div class="body-top-margin"></div>
            <div class="page-title">
                <h3>YOUR WISHLIST</h3>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="shop_table cart wishlist_table">
                        <tbody>
                        	<?php if(!empty($wishlist_data)) {
                        		foreach ($wishlist_data as $value) {
                        			$image_url = json_decode($value['image_url'], true);
                        	?>
                            <tr id="remove_tr_<?=$value['wid']?>">
                                <td class="product-thumbnail">
                                    <?php if(!empty($image_url[0])) {
                                        $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_url[0]);
                                        echo stripos($headers[0],"200 OK") ? '<img class="img-responsive" src="'.base_url().'frontend/assets/images/products/'.$image_url[0].'">' : '<img class="img-responsive" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                                    <?php } else {?>
                                    <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                    <?php } ?>
                                </td>
                                <td class="product-name"><a href="<?=base_url().'product_detail/'.$value['id']?>"><?=$value['product_name']?></a></td>
                                <td><?=($value['price'] ? '&dollar;'.$value['price'] : '&dollar;0') ?></td>
                                <td>Instock</td>
                                <td class="product-remove"><a href="javascript:;" onclick="removeFromWishlist(<?=$value['wid']?>)"><i class="fa fa-close"></i></a></td>
                                <td class="text-right">
                                	<input type="hidden" id="item_id_<?=$value['id'] ?>" name="item_id" value="<?=$value['id'] ?>"/>
                                    <input type="hidden" id="name_<?=$value['id'] ?>" name="name" value="<?=$value['product_name'] ?>"/>
                                    <?php if (isset($value['discounted_price']) && !empty($value['discounted_price'])) { ?>
                                    <input type="hidden" id="price_<?=$value['id'] ?>" name="price" value="<?=$value['discounted_price']?>"/>
                                    <?php } else { ?>
                                    <input type="hidden" id="price_<?=$value['id'] ?>" name="price" value="<?=$value['price'] ?>"/>
                                    <?php } ?>
                                    <input type="hidden" id="img_url_<?=$value['id'] ?>" name="img_url" value="<?=$image_url[0] ?>"/>
                                	<a onclick="addToCart(<?=$value['id'] ?>)" class="add-btn">Add to cart</a></td>
                            </tr>
                            <?php } } else {?>
                            <tr>
                            	<td>Your Wishlist is empty</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>