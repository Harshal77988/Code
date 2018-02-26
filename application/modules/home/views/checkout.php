<section class="shopping-cart">
   <!-- .shopping-cart -->
   <div class="container">
   	<div class="row">
   		<div class="col-md-12">
      		<ol class="breadcrumb">
      			<li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
      			<li class="breadcrumb-item active">Checkout</li>
      		</ol>
         </div>
   		   <div class="col-md-12">
            <?php if (!empty($cart_items)) {?>
            <div class="row">
               <div class="col-sm-6 cart_div" style="margin-top: 0px;">
                  <form id="checkout_address_form" name="checkout_address_form">                  
                      <div class="form-checkout">
                          <h5 class="form-title">BILLING ADDRESS</h5>
                          <p>
                            <?=form_input(array("name" => "billingaddress", "id" => "billingaddress", "value" => "", "placeholder" => "Address", "value" => (!empty($get_billing_address[0]['address']) ? $get_billing_address[0]['address'] : '')))?>
                          </p>
                          <div class="row">
                              <!-- <div class="col-sm-6">
                                  <p>
                                    <select class="form-control input-text" id="billing_input_country" name="billing_country_id" value="" placeholder="Country">
                                        <option value="" selected="selected"> --- Please Select Country --- </option>
                                        <?php
                                            foreach ($country_list as $value) {
                                            if($value['id'] == $get_billing_address[0]['country']) {?>
                                            <option value='<?=$value['id']?>' selected><?=$value['name']?></option>
                                        <?php } ?>
                                            <option value='<?=$value['id']?>'><?=$value['name']?></option>
                                        <?php } ?>
                                    </select>
                                  </p>
                              </div> -->
                              <div class="col-sm-6">
                                  <p>
                                    <select class="form-control input-text" id="billing_input_zone" name="billing_zone_id" placeholder="State">
                                        <option value="" selected="selected"> --- Please Select State --- </option>
                                        <?php
                                            foreach ($state_list as $value) {
                                              if($value['id'] == $get_billing_address[0]['state']) {?>
                                                <option value='<?=$value['id']?>' selected><?=$value['name']?></option>
                                            <?php } else { ?>
                                                <option value='<?=$value['id']?>'><?=$value['name']?></option>
                                        <?php } } ?>
                                    </select>
                                  </p>
                              </div>
                              <div class="col-sm-6">
                                  <?=form_input(array("id" => "billingcity", "name" => "billingcity", "value" => "", "placeholder" => "Town / City", "value" => (!empty($get_billing_address[0]['city']) ? $get_billing_address[0]['city'] : '')))?>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6">
                                  <p><?=form_input(array("name" => "billingpostcode", "id" => "billingpostcode", "value" => "", "placeholder" => "PostCode", "value" => (!empty($get_billing_address[0]['postcode']) ? $get_billing_address[0]['postcode'] : '')))?></p>
                              </div>
                              <div class="col-sm-6">
                                  <p><?=form_input(array("name" => "billingtelephone", "id" => "billingtelephone", "value" => "", "placeholder" => "Telephone number", "value" => (!empty($get_billing_address[0]['phone']) ? $get_billing_address[0]['phone'] : '')))?></p>
                              </div>
                          </div>
                      </div>
                      <div class="form-checkout rokan-product-heading">
                          <h5 class="form-title">SHIPPING ADDRESS</h5>
                          <span>Same as Billing Address <input type="checkbox" id="same_as_billing" name="" onchange="InputInformation(this)"></span>
                          <p><?=form_input(array("name" => "shippingaddress", "class" => "form-control", "id" => "shippingaddress", "value" => "", "placeholder" => "Address", "value" => (!empty($get_shipping_address['s_address']) ? $get_shipping_address['s_address'] : '')))?></p>
                          <div class="row">
                              <div class="col-sm-6">
                                  <p>
                                    <select class="form-control input-text" id="shipping_input_zone" name="shipping_input_zone" value="" placeholder="State">
                                        <option value="" selected="selected"> --- Please Select State --- </option>
                                        <?php
                                            foreach ($state_list as $value) {
                                              if($value['id'] == $get_shipping_address['s_state_id']) {?>
                                                <option value='<?=$value['id']?>' selected><?=$value['name']?></option>
                                            <?php } else { ?>
                                                <option value='<?=$value['id']?>'><?=$value['name']?></option>
                                        <?php } } ?>
                                    </select> 
                                  </p>
                              </div>
                              <div class="col-sm-6">
                                  <?=form_input(array("id" => "shippingcity", "class" => "form-control", "name" => "shippingcity", "value" => "", "placeholder" => "Town / City", "value" => (!empty($get_shipping_address['s_city']) ? $get_shipping_address['s_city'] : '')))?>
                              </div>
                          </div>
                          <div class="row">
                             <div class="col-sm-6">
                                <p>
                                  <?=form_input(array("name" => "shippingpostcode", "class" => "form-control", "id" => "shippingpostcode", "value" => "", "placeholder" => "PostCode", "value" => (!empty($get_shipping_address['s_postcode']) ? $get_shipping_address['s_postcode'] : '')))?>
                                </p>
                             </div>
                             <div class="col-sm-6">
                                <p>
                                  <?=form_input(array("name" => "shippingtelephone", "class" => "form-control", "id" => "shippingtelephone", "value" => "", "placeholder" => "Telephone number", "value" => (!empty($get_shipping_address['s_phone']) ? $get_shipping_address['s_phone'] : '')))?>
                                </p>
                             </div>
                          </div>
                          <button class="button btn-primary medium proceed_checkout checkout_save_address">Save Address</button>
                      </div>
                  </form>
               </div>
               <div class="col-sm-6">                  
                  <br>
                  <div class="form-checkout order rokan-product-heading">
                      <!-- <h2>YOUR ORDER</h2> -->
                      <table class="shop-table checkout-table order">
                          <thead> 
                              <tr>
                                 <th>PREVIEW</th>
                                  <th class="product-name">PRODUCT</th>
                                  <th>PRICE</th>
                                  <th>QUANTITY</th>
                                  <th class="total">TOTAL</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php if (isset($cart_items) && !empty($cart_items)) {?>
                                 <?php foreach ($cart_items as $sid => $cData) { ?>
                              <tr>
                                 <td width="100px">
                                    <?php if(!empty($cData['item_url'])) {
                                        $headers = get_headers(base_url().'frontend/assets/images/products/'.$cData['item_url']);
                                        echo stripos($headers[0],"200 OK") ? '<img style="width: 70px;" class="img-responsive" src="'.base_url().'frontend/assets/images/products/'.$cData['item_url'].'">' : '<img style="width: 70px;" class="img-responsive" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>                                                   
                                    <!-- <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/products/<?=$image_url[0]?>"> -->
                                    <?php } else {?>
                                    <img style="width: 70px;" class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                    <?php } ?>
                                  </td>
                                  <td class="product-name"><?=$cData['name']?></td>
                                  <td>$<?=$cData['internal_price']?></td>
                                  <td class="text-center"><?=$cData['quantity']?></td>
                                  <td class="total"><span class="price">$<?=($cData['internal_price'] ? $cData['internal_price']*$cData['quantity'] : '0')?></span></td>
                              </tr>
                              <?php }
                              } ?>
                              <tr>
                                  <td colspan="4" class="subtotal">Subtotal</td>
                                  <td class="total"><span class="price">$<?=($cart_summary['item_summary_total'] ? $cart_summary['item_summary_total'] : '0')?></span></td>
                              </tr>
                              <tr>
                                  <td colspan="4" class="subtotal">Tax</td>
                                  <td class="total"><span class="price">$<?=$tax = (!empty($cart_summary['tax_total']) ? number_format(($cart_summary['item_summary_total']/100)*$cart_summary['tax_total'], 2, '.', '') : '0')?></span></td>
                              </tr>
                              <?php if (isset($discounts['total']['value_desc'])) { ?>
                                    <tr>
                                        <td colspan="4">Discount Coupon (<?php echo (int)$discounts['total']['value_desc'];?>%)</td>
                                        <td class="text-left" colspan="2">
                                            <span id="shipping_price" class="text-danger"><b><?='$'.($cart_summary['item_summary_total']/100)*(int)$discounts['total']['value_desc'];?></b></span>
                                        </td>
                                    </tr>
                                <hr>
                              <?php } ?>
                              <tr>
                                  <td colspan="4" class="subtotal">Shipping Charges</td>
                                  <td class="total"><span class="price">$<?=$shipping_charges = ($cart_summary['shipping_total'] ? $cart_summary['shipping_total'] : '0'); ?></span></td>
                              </tr>
                              <tr class="order-total">
                                  <td colspan="4" class="subtotal"><b>Order Total</b></td>
                                  <td class="total">
                                    <span class="price">
                                      $<?php
                                        if (!empty($discounts['total']['value'])) {
                                            $dis = $discounts['total']['value_desc'];
                                            $discount_val = ($cart_summary['item_summary_total'] * $dis) / 100;
                                            if ($cart_summary['shipping_total'] && $cart_summary['shipping_total'] != '' && $cart_summary['shipping_total'] != '0')
                                                echo $cart_total_amount = $cart_summary['item_summary_total'] - $discount_val + ($tax ? $tax :'0') ;
                                            else
                                                echo $cart_total_amount = $cart_summary['item_summary_total'] - $discount_val + ($tax ? $tax :'0');
                                        } else {

                                            if (isset($cart_summary['zip_code']) && $cart_summary['tax_total'] != '0') {
                                                if ($cart_summary['shipping_total'] && $cart_summary['shipping_total'] != '' && $cart_summary['shipping_total'] != '0')
                                                    echo $cart_total_amount = $cart_total_amount = ($cart_summary['item_summary_total'] + $cart_summary['tax_total'] + $cart_summary['shipping_total']);
                                            } else {

                                                echo $cart_total_amount = $cart_total_amount = number_format($cart_summary['item_summary_total'] + ($tax ? $tax :'0'), 2, '.', '');
                                            }
                                        }
                                        ?>
                                    </span>
                                  </td>
                              </tr>
                              <tr>
                                  <td colspan="5">
                                    <div class="col-sm-6">
                                      <a href="<?=base_url('home/paypal_buy')?>"><button class="button btn-primary medium proceed_checkout">Proceed via Paypal</button></a>
                                    </div>
                                    <div class="col-sm-6">
                                      <!-- stripe payment code start -->
                                      <form action="<?php echo site_url('home/stripe_payment');?>" method="POST">
                                          <!-- <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="pk_test_xeisPeUTiHBhkJ2gSrabkPA3" data-name="BuySellandRent.co" data-description="Stripe Transaction (<?='$'.$cart_total_amount?>)" data-label="Pay via Stripe" />
                                          </script> -->
                                          <noscript>You must <a href="http://www.enable-javascript.com" target="_blank">enable JavaScript</a> in your web browser in order to pay via Stripe.</noscript>

                                          <input style="max-width: 100%" type="submit" class="button btn-primary medium proceed_checkout" value="Pay via Stripe" data-key="pk_test_xeisPeUTiHBhkJ2gSrabkPA3"  data-currency="usd" data-name="BuySellandRent" data-description="Stripe payment for <?='$'.$cart_total_amount?>" />

                                          <script src="https://checkout.stripe.com/checkout.js"></script>
                                          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                                          <script>
                                            $(document).ready(function() {
                                              $(':submit').on('click', function(event) {
                                                  event.preventDefault();
                                                  var $button = $(this),
                                                  $form = $button.parents('form');
                                                  var opts = $.extend({}, $button.data(), {
                                                      token: function(result) {
                                                          $form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id })).submit();
                                                      }
                                                  });
                                                  StripeCheckout.open(opts);
                                              });
                                            });
                                          </script>
                                      </form>
                                      <!-- stripe payment code end -->
                                    </div>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>                  
                  <div class="form-checkout checkout-payment">
                      <!-- <h5 class="form-title">YOUR PAYMENT</h5>
                      <div class="payment_methods">
                          <div class="payment_method">
                              <label><input name="payment_method" type="radio">DIRECT BANK TRANSFER</label>
                          </div>
                          <div class="payment_method">
                              <label><input name="payment_method" type="radio">CASH ON DELIVERY</label>
                          </div>
                          <div class="payment_method">
                              <label><input name="payment_method" type="radio">PAYPAL</label>
                          </div> -->
                           <!-- <a href="<?=base_url('home/paypal_buy')?>"><button class="button btn-primary medium proceed_checkout">PROCEED TO PAYMENT</button></a> -->
                           <!-- <a style="margin:0px 20px 0 0" href="<?=base_url('home/cart')?>" title="Place Order"><button class="button btn-primary medium proceed_checkout">Back To Cart</button></a> -->
                      <!-- </div> -->

                      <?php if (isset($discounts['total']['value_desc'])) { ?>
                        <div class="panel" style="border-style: dashed; border-color: green; padding:  10px">
                            <div class="coupon_code_entry">
                                <p class="title_code">Promo Code Applied</p>
                                <b class="input_code"><?php echo $discounts['total']['code']; ?></b>
                                <?php if (isset($discounts['total']['id'])) { ?>
                                    <a class="btn btn-sm" href="<?php echo base_url(); ?>standard_library/unset_discount/<?php echo $discounts['total']['id']; ?>" title="Remove Coupon Code"><i class="fa fa-remove text-danger"></i></a>
                                <?php } ?>
                                <p><small><?php echo $discounts['total']['description']; ?></small></p>
                            </div>
                        </div>
                      <?php } else { ?>
                          <div class="box-cart-total1">
                              <h2 class="title">Redeem Coupon</h2>
                              <div class="payment_methods">
                                  Have Coupon Code?
                                      <?php echo form_open('standard_library/view_cart'); ?>
                                      <?php ?>
                                      <div class="row">
                                          <div class="col-sm-10">
                                            <?=form_input(array('class' => "form-control coupon_code", 'name' => "discount[0]", 'placeholder' => "Enter the coupon code", 'maxlength' => "25", 'style'=> "height: 35px", 'autocomplete' => "off"))?>
                                              <!-- <input type="text" name="discount[0]" class="form-control" value="" placeholder="Coupon code here" style="height: 35px" autocomplete="off"/> -->
                                          </div>
                                          <div class="col-sm-1 col-sm-pull-1">
                                              <button type="submit" class=" btn"  name="update_discount" value="Add Coupon Code"><i class="fa fa-check"></i></button>
                                          </div>
                                      </div>
                                  <?php echo form_close(); ?>
                                  <!-- <p>
                                    <a data-toggle="modal" href="#coupons_list">
                                      Show all Coupons
                                    </a>
                                  </p> -->
                              </div>
                          </div>
                      <?php } ?>
                  </div>
               </div>
            </div>
            <?php } else { ?>
            <div class="row">
               <div class="col-md-12">
                  <p>No item in cart</p>
               </div>
            </div>
            <?php } ?>            
         </div>               
      </div>
   </div>
<!-- /.shopping-cart -->
</section>