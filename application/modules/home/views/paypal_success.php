<html>
  <body>
    <div style="margin:0;border:none;background:#f5f5f5;">
      <div>
      </div>
      <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
        <tbody>
          <tr>
            <td align="center" valign="top">
              <table class="m_2325894079705929180m_-187537962896113558contenttable" border="0" cellpadding="0" cellspacing="0" width="600" bgcolor="#ffffff" style="border-width:8px;border-style:solid;border-collapse:separate;border-color:#ececec;margin-top:40px;font-family:Arial, Helvetica, sans-serif;">
                <tbody>
                  <tr>
                    <td>
                      <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                          <tr>
                            <td valign="top" align="center">
                              <a href="#m_2325894079705929180_m_-187537962896113558_">
                                <img alt="BuySellandRent.co" src="<?=base_url()?>frontend/assets/images/email_logo.png" style="padding-bottom:0;display:inline!important;width:100%" class="CToWUd"></a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tbody>
                            <tr>
                              <td bgcolor="#ef4136" align="center" style="padding:16px 10px;line-height:24px;color:#ffffff;font-weight:bold;"> Hi <?=$this->data['user_name']?> <br>
                                Thank you for your order!
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td class="m_2325894079705929180m_-187537962896113558tablepadding" style="padding:20px;font-size:19px;line-height:28px;text-align:center;color:#888;">Here's a summary of your purchase. When we ship the item, we will send an update with details.</td>
                    </tr>
                    <tr>
                      <td class="m_2325894079705929180m_-187537962896113558tablepadding" style="border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;padding:13px 20px;">
                        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                          <tbody>
                            <tr>
                              <td style="font-size:13px;font-family:Arial, Helvetica, sans-serif;color:#676767;">
                                <span style="color:#707070">Order ID: </span>#<?=$this->data['order_id']?></td>
                                <td style="font-size:13px;font-family:Arial, Helvetica, sans-serif;color:#676767;" align="right">
                                  <span style="color:#707070">Placed on: </span><span style="color:#000000;display:inline-block"><?=$this->data['order_date']?></span>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tbody>
                              <tr>
                                <td>
                                  <table class="m_2325894079705929180m_-187537962896113558tablefull" width="50%" cellpadding="0" cellspacing="0" border="0" align="left">
                                    <tbody>
                                      <tr>
                                        <td class="m_2325894079705929180m_-187537962896113558tablepadding" style="padding:20px;">
                                          <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                                            <tbody>
                                              <tr>
                                                <td style="font-size:13.5px;font-family:Arial, Helvetica, sans-serif;line-height:1.5;color:#000000;">
                                                  <span><span style="color:#909090">Billing Address</span>
                                                  <br>
                                                  <?=$this->data['checkout']['billing']['name']?><br>
                                                  <?=$this->data['checkout']['billing']['add_01']?><br>
                                                  <?=$this->data['checkout']['billing']['city'].' '.$this->data['checkout']['billing']['state'].' '.$this->data['checkout']['billing']['country']?><br></span>
                                                  <?=$this->data['checkout']['billing']['post_code']?><br>
                                                </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table><span>
                                    <table class="m_2325894079705929180m_-187537962896113558tablefull" width="50%" cellpadding="0" cellspacing="0" border="0" align="left">
                                      <tbody>
                                        <tr>
                                          <td class="m_2325894079705929180m_-187537962896113558tablepadding" style="padding:20px;">
                                            <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                                              <tbody>
                                                <tr>
                                                  <td style="font-size:13.5px;font-family:Arial, Helvetica, sans-serif;line-height:1.5;color:#000000;">
                                                      <span><span style="color:#909090">Shipping Address</span>
                                                      <br>
                                                      <?=$this->data['checkout']['billing']['name']?><br>
                                                      <?=$this->data['checkout']['billing']['add_01']?><br>
                                                      <?=$this->data['checkout']['billing']['city'].' '.$this->data['checkout']['billing']['state'].' '.$this->data['checkout']['billing']['country']?><br></span>
                                                      <?=$this->data['checkout']['billing']['post_code']?><br>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>

                                      <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                          <tr>
                                              <td class="tablepadding" style="padding:20px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
                                                  <thead>
                                                    <tr>
                                                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Product</td>
                                                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Qty</td>
                                                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Price</td>
                                                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Total</td>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php if (isset($this->data['cart_items']) && !empty($this->data['cart_items'])) { ?>
                                                        <?php foreach ($this->data['cart_items'] as $sid => $cData) { ?>
                                                        <tr>
                                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px"><?= $cData['name']; ?><br />
                                                              <!-- <span style="font-size:11px; color:#555;">Model: Product 114</span></td> -->
                                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><?= $cData['quantity'] ?></td>
                                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$<?= $cData['internal_price']; ?></td>
                                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$<?= (floatval($cData['internal_price']) * floatval($cData['quantity'])) ?></td>
                                                        </tr>
                                                    <?php } }?>
                                                  </tbody>
                                                  <tfoot>
                                                    <tr>
                                                      <td colspan="3" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><b>Sub-Total:</b></td>
                                                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$<?= ($cart_summary['item_summary_total'] ? $cart_summary['item_summary_total'] : '0'); ?></td>
                                                    </tr>
                                                    <?php
                                                    $discount_per = 0;
                                                    if(!empty($cart_summary['discount_data'])) {
                                                      $order_total = $cart_summary['item_summary_total'];
                                                      $discount_per = ($order_total/100)*(int)$cart_summary['discount_data']['value_desc'];
                                                      ?>
                                                    <tr>
                                                      <td colspan="3" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><b>Discount(<?=(int)$cart_summary['discount_data']['value_desc'].'%'?>):</b></td>
                                                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$<?=($cart_summary['discount_data'] ? number_format((float)($discount_per), 2, '.', ''): '0'); ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr>
                                                      <td colspan="3" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><b>Tax:</b></td>
                                                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$<?=$tax=($cart_summary['tax_total'] ? number_format((float)($cart_summary['item_summary_total']/100*$cart_summary['tax_total']), 2, '.', ''): '0'); ?></td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="3" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><b>Total Shipping:</b></td>
                                                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$<?=($cart_summary['shipping_total'] ? $cart_summary['shipping_total']: '0'); ?></td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="3" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><b>Total:</b></td>
                                                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><?=($cart_summary['item_summary_total'] ? '$'.number_format($cart_summary['item_summary_total'] + $tax + $cart_summary['shipping_total']-$discount_per, 2, '.', '') : '$0'); ?></td>
                                                    </tr>
                                                  </tfoot>
                                                </table></td>
                                            </tr>
                                      </table>
                                      <table width="100%" cellpadding="0" cellspacing="0" border="0" align="left">
                                        <tbody>
                                          <tr>
                                            <td class="m_2325894079705929180m_-187537962896113558tablepadding" style="border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;padding:13px 20px;font-size:13.5px;font-family:Arial, Helvetica, sans-serif;line-height:1.5;color:#676767;">
                                              <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                                                <tbody>
                                                  <tr>
                                                    <td>
                                                      <span style="color:#909090">Payment Type</span>
                                                    </td>
                                                    <td align="right">
                                                      <span style="color:#000000"><?=$this->data['payment_type']?></span>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                        </table></span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td class="m_2325894079705929180m_-187537962896113558tablepadding" style="padding:20px;">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#555555;font-family:Arial, Helvetica, sans-serif;">
                                  <tbody>
                                    <tr>
                                      <td class="m_2325894079705929180m_-187537962896113558tablepadding" align="center" style="font-size:14px;line-height:22px;padding:20px;border-top:1px solid #ececec;"> Any Questions? Get in touch with our 24x7 Customer Care team.<br>
                                        866-748-4737 | 626-821-9400 | 626-821-9401
                                      </td>
                                      
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#999999;font-family:Arial, Helvetica, sans-serif;">
                          <tbody>
                            <tr>
                              <td class="m_2325894079705929180m_-187537962896113558tablepadding" align="center" style="line-height:20px;padding:20px;"> 2017 © COPYRIGHT 2017 - BuyRentSell - ALL RIGHTS RESERVED </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </body>
</html>

<!-- <div>Success</div> -->
<!-- <div class="entry-content">
    <div class="woocommerce">
        <p>Thank you. Your order has been received.</p>
        <ul class="order_details">
            <li class="order"> Order Number: <strong>2674</strong></li>
            <li class="date"> Date: <strong>November 22, 2017</strong></li>
            <li class="total"> Total: <strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>103.00</span></strong></li>
            <li class="method"> Payment Method: <strong>Direct bank transfer</strong></li>
        </ul>
        <div class="clear"></div>
        <section class="woocommerce-order-details">
            <h2 class="woocommerce-order-details__title">Order details</h2>
            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                <thead>
                    <tr>
                        <th class="woocommerce-table__product-name product-name">Product</th>
                        <th class="woocommerce-table__product-table product-total">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="woocommerce-table__line-item order_item">
                        <td class="woocommerce-table__product-name product-name"> <a href="http://demo.lion-themes.net/complex/shop/skmei-luxury-brand/">Skmei Luxury Brand</a> <strong class="product-quantity">× 1</strong></td>
                        <td class="woocommerce-table__product-total product-total"> <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>100.00</span>
                        </td>
                    </tr>
                    <tr class="woocommerce-table__line-item order_item">
                        <td class="woocommerce-table__product-name product-name"> <a href="http://demo.lion-themes.net/complex/shop/dual-sim-unlocked/">Dual Sim Unlocked</a> <strong class="product-quantity">× 1</strong></td>
                        <td class="woocommerce-table__product-total product-total"> <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>3.00</span>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="row">Subtotal:</th>
                        <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>103.00</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Payment method:</th>
                        <td>Direct bank transfer</td>
                    </tr>
                    <tr>
                        <th scope="row">Total:</th>
                        <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>103.00</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </section>
        <section class="woocommerce-customer-details">
            <h2>Customer details</h2>
            <table class="woocommerce-table woocommerce-table--customer-details shop_table customer_details">
                <tbody>
                    <tr>
                        <th>Note:</th>
                        <td>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>testing123@gmail.com</td>
                    </tr>
                </tbody>
            </table>
            <h3 class="woocommerce-column__title">Billing address</h3><address> test Last name<br>Abc<br>Make your payment directly into our bank account<br>sd<br>asdadsad, WA 98335<br>United States (US) </address></section>
        </section>
    </div>
    <div class="clearfix"></div>
</div> -->