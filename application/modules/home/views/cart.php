<section class="shopping-cart">
    <!-- .shopping-cart -->
    <div class="container">
		<div class="row">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
					<li class="breadcrumb-item active">Shopping Cart</li>
				</ol>
			</div>
			<?php if (isset($cart_items) && !empty($cart_items)) { ?>
			<div class="cart_detail_view_hide">
				<div class="col-sm-12 col-md-8">
			          <h2>You cart items</h2>
			          <table>
			             <tr>
			                <th class="text-center">Image</th>
			                <th>Product name</th>
			                <th>Price</th>
			                <th>Quantity</th>
			                <th>Total Price</th>
			                <th></th>
			             </tr>
						<?php
						// echo "<pre>";
						// print_r($_SESSION);
						// print_r($cart_items); die;
						foreach ($cart_items as $sid => $cData) { ?>
			             <tr id="delete_cart_<?=$sid?>">
			                <td style="width: 15%">
			                	<?=(!empty($cData['rent_id']) && $cData['rent_id'] == 1 ? '<span class="rent-tag">rent!</span>':'')?>
			                	<img class="img-responsive" src="<?=base_url()?>frontend/assets/images/products/<?=$cData['item_url']?>" alt="<?=base_url() ?>frontend/assets/images/products/<?=$cData['item_url']?>">
			                </td>
			                <td>
			                	<a href="<?=base_url().'product_detail/'.$cData['id']?>"><?=$cData['name']?></a>
			                	<span>
			                		<?php if (isset($cData['stock_quantity']) && $cData['stock_quantity'] > 0) { ?>
			                		<p id="in-stock-label">In Stock</p>
			                		<?php } else {?>
			                		<p id="out-of-stock-label">Out of stock</p>
			                		<p id="out-of-stock-label">(Pre-order Item)</p>
			                		<?php } ?>
			                		<p class="rent-label"><?=(!empty($cData['rent_duration']) ? 'Duration : '.$cData['rent_duration'] : '')?></p>
			                	</span>
			                </td>
			                <td><strong>$<?=$cData['internal_price']?></strong></td>
			                <td>
			                	<?=form_open('home/update_cart', array('class' => '', 'data-parsley-validate', 'method' => 'post')); ?>
			                	<?=form_input(array('type' => 'hidden','name' => 'item_id[]', 'value' => $cData['id']))?>
			                	<?=form_input(array('type' => 'hidden','name' => 'session_id_'.$cData['id'], 'value' => $sid))?>
			                	<input type="number" name="quantity_<?php echo $cData['id']; ?>" id="quantity_<?php echo $cData['id']; ?>" min="1" max="<?php echo $cData['stock_quantity'] > 1 ? $cData['stock_quantity'] : '0' ?>" value="<?php echo $cData['quantity'] ?>"> <button type="submit" data-toggle="tooltip" title="" class="update_cart_btn" data-original-title="Update"><i class="fa fa-refresh"></i></button>
			                	<?=form_close()?>
			                </td>
			                <td><strong>$<?=$cData['internal_price']*$cData['quantity']?></strong></td>
			                <td><a class="btn btn-xs remove" title="Remove" onclick="funDeleteCartProduct('<?=$sid; ?>', '<?=(floatval($cData['internal_price']) * floatval($cData['quantity'])) ?>');" type="button"><span class="red"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></span></a></td>
			             </tr>
			             <?php }?>
			          </table>
			          <div class="col-sm-12 col-md-12 multiple_order_message"></div>
			          <div class="col-sm-6 col-md-6">
			             <a href="<?=base_url()?>" class="button red">CONTINUE SHOPPING</a>
			          </div>			          
		       	</div>
		       	<div class="col-sm-12 col-md-4">
	                <!-- <div class="box-cart-total">
	                    <h2 class="title">Calculate Shipping</h2>
	                    <table>
	                        <tbody>
		                        <tr>
		                            <td>Zipcode</td>
		                            <td class="text-right">
		                            	<?=form_input(array('class' => 'zipcode_val', 'name' => 'zipcode', 'placeholder' => 'Enter the zipcode', 'maxlength' => '7', 'style' => 'max-width: 100% !important;width: 100%;'))?>
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
	                    <button class="button medium calculate_shipping">Update Shipping</button>
	                </div><br> -->
	                 <div class="box-cart-total1">
						<h2 class="title">CALCULATE SHIPPING</h2>
						<div class="payment_methods">
						  Zipcode
					      <div class="row">
					          <div class="col-sm-10">
					            <?=form_input(array('class' => "form-control zipcode_val", 'id' => 'shipping_zipcode', 'name' => "zipcode", 'placeholder' => "Enter the zipcode", 'maxlength' => "10", 'style'=> "height: 35px", 'autocomplete' => "off"))?>
					          </div>
					          <div class="col-sm-1 col-sm-pull-1">
					              <button type="submit" class=" btn"  name="update_discount" value="Add Coupon Code"><i class="fa fa-check"></i></button>
					          </div>
					      </div>
						</div>
					</div>

	                <div class="box-cart-total">
	                    <h2 class="title">Cart Totals</h2>
	                    <table>
	                        <tbody>
	                        	<tr>
		                            <td>Subtotal</td>
		                            <td class="text-right"><span class="price sub_total">$<strong><?=$cart_summary['item_summary_total']?></strong></span></td>
		                        </tr>
		                        <tr>
		                            <td>Shipping</td>
		                            <td class="text-right"><span class="price">$<strong><?=$shipping_charges = ($cart_summary['shipping_total'] ? $cart_summary['shipping_total'] : '0'); ?></strong></span></td>
		                        </tr>
		                        <tr class="order-total">
		                            <td>Total</td>
		                            <td class="text-right"><span class="price grand_total">$<strong><?=number_format($cart_summary['item_summary_total'] + $shipping_charges, 2, '.', '')?></strong></span></td>
		                        </tr>
		                    </tbody>
		                </table>
	                    <!-- <button class="button medium update_btn">Update Cart</button> -->
	                    <!-- <button class="button btn-primary medium checkout-button checkout_btn">PROCEED TO CHECKOUT</button> -->
	                    <?php if($this->ion_auth->logged_in()) {?>
	                    <a href="javascript:void(0)"><button class="button btn-primary medium checkout-button checkout_btn<?=(count($cart_items) > 1 ? ' checkout_btn_preorder':'')?>" <?=(count($cart_items) == 1 ? 'onclick="return checkZipcode()"':'')?>>Proceed to checkout</button></a>
	                    <?php } else {?>
	                    <!-- <a href="javascript(0);"><button class="button btn-primary medium checkout-button checkout_btn">Proceed to checkout</button></a> -->
	                    <a data-toggle="modal" href="#login-new"><button class="button btn-primary medium checkout-button checkout_btn">Proceed to checkout</button>
						</a>
	                    <?php } ?>
	                </div>
	            </div>
            </div>
            <?php } else {?>
            <div class="page-title-wrapper cart_detail_view rokan-product-heading col-md-12">
				<h2>Shopping Cart</h2>
				<p>Your shopping cart is empty</p><br><br>
			    <!-- <h1 class="page-title"><span class="base" data-ui-id="page-title-wrapper">Shopping Cart</span></h1> -->
			    <a href="<?=base_url()?>" class="button red">CONTINUE SHOPPING</a>
			</div>
	        <?php }?>
		</div>               
	</div>
 <!-- /.shopping-cart -->
</section>
<!-- newsletter -->

<script type="text/javascript">
	function checkZipcode() {
		var shipping_zipcode = $('#shipping_zipcode').val();
		if(shipping_zipcode == "") {
			// alert('zipcode blank');

			$('.multiple_order_message').html('');
			$('#shipping_zipcode').focus();
			$('#shipping_zipcode').css('border', '1px solid red');
			return false;
		} else {
			var base_url = $('#base_url').val();

			window.location.href = base_url + 'home/checkout';
			// alert('zipcode not blank');
			return true;
		}
	}
</script>