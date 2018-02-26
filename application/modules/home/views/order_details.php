<section class="shopping-cart">
    <!-- .shopping-cart -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                    <li class="breadcrumb-item active">Order Detail</li>
                </ol>
            </div>
            <!-- Start Content -->
            <main id="main" class="site-main">
                <article id="post-12" class="post-12 page type-page status-publish hentry">
                    <!-- <header class="entry-header">
                        <h1 class="entry-title">Order Id #<?= $summary_data['ord_order_number'] ?></h1></header> -->
                    <div class="entry-content">
                        <div class="woocommerce">
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 myaccount-navigation">
                                    <ul class="nav">
                                        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account <?=($this->uri->segment(1) == 'my_account' ? ' is-active' : '')?>">
                                            <a href="<?=base_url('my_account')?>">Account details</a>
                                        </li>
                                        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders <?=($this->uri->segment(1) == 'my_orders' || $this->uri->segment(2) == 'order_details' ? ' is-active' : '')?>">
                                            <a href="<?=base_url('my_orders')?>">Orders</a>
                                        </li>
                                        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address <?=($this->uri->segment(1) == 'track_order' ? ' is-active' : '')?>">
                                            <a href="<?=base_url('rented_products')?>">Rented Products</a>
                                        </li>
                                        <!-- <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address <?=($this->uri->segment(1) == 'track_order' ? ' is-active' : '')?>">
                                            <a href="<?=base_url('track_order')?>">Track Order</a>
                                        </li> -->
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-9 myaccount-content">
                                    <?php if (isset($item_data) && !empty($item_data)) { ?>
                                    <section class="woocommerce-order-details">
                                        <p class="pull-left"><b>Order Id :</b>
                                        <mark class="order-number"><b>#<?= $summary_data['ord_order_number'] ?></b></mark> was placed on
                                        <mark class="order-date"><?=date('d F y', strtotime($summary_data['ord_date']))?></mark> and order status is
                                        <mark class="order-status"><?php
                                                        if($summary_data['ord_status'] == '1') {
                                                            echo "Awaiting Payment";
                                                        } else if($summary_data['ord_status'] == '2') {
                                                            echo "New Order";
                                                        } else if($summary_data['ord_status'] == '3') {
                                                            echo "Processing Order";
                                                        } else if($summary_data['ord_status'] == '4') { 
                                                            echo "Order Complete";
                                                        } else {
                                                            echo "Order Cancelled";
                                                        }?></mark>.</p>
                                        <!-- <h2 class="pull-left woocommerce-order-details__title">Order details</h2> -->
                                        <h2 class="pull-right alert-danger">(Pre-order)</h2>
                                        <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                                            <thead>
                                                <tr>
                                                    <th class="woocommerce-table__product-name product-name">Product Name</th>
                                                    <th class="woocommerce-table__product-name product-name">Quantity</th>
                                                    <th class="woocommerce-table__product-name product-name">Price</th>
                                                    <th class="woocommerce-table__product-table product-total text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($item_data as $row) {?>
                                                    <tr>
                                                        <td><span><?=$row['ord_det_item_name'] ?></span></td>
                                                        <td><span><?=round($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity')], 2); ?></span></td>
                                                        <td>
                                                            <span>
                                                                <?php
                                                                // If an item discount exists.
                                                                if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0) {
                                                                    // If the quantity of non discounted items is zero, strike out the standard price.
                                                                    if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_non_discount_quantity')] == 0) {
                                                                        echo '<span class="strike">' . $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE) . '</span><br/>';
                                                                    }
                                                                    // Else, display the quantity of items that are at the standard price.
                                                                    else {
                                                                        echo number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_non_discount_quantity')]) . ' @ ' .
                                                                        $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE) . '<br/>';
                                                                    }

                                                                    // If there are discounted items, display the quantity of items that are at the discount price.
                                                                    if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0) {
                                                                        echo number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')]) . ' @ ' .
                                                                        $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price')], TRUE, 2, TRUE);
                                                                    }
                                                                }
                                                                // Else, display price as normal.
                                                                else {
                                                                    echo '&dollar;'.$row[$this->flexi_cart_admin->db_column('order_details', 'item_price')];
                                                                }
                                                                ?>                                                                    
                                                                </span>
                                                            </td>                                
                                                            <td class="text-center">
                                                                <span data-prefix>
                                                                    <?php
                                                                    // If an item discount exists, strike out the standard item total and display the discounted item total.
                                                                    if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0) {
                                                                        echo '<span class="strike">' . $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE) . '</span><br/>';
                                                                        echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price_total')], TRUE, 2, TRUE);
                                                                    }
                                                                    // Else, display item total as normal.
                                                                    else {
                                                                        echo '&dollar;'.$row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')];
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <?php
                                                    $order_total = $summary_data['ord_item_summary_total'];
                                                    $discount_per = (!empty($summary_data['ord_reward_voucher_desc']) ? ($order_total/100)*(int)$summary_data['ord_reward_voucher_desc'] : '0');
                                                ?>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th scope="row">Subtotal:</th>
                                                    <td class="text-center"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?=number_format((float)($order_total), 2, '.', '')?></span>
                                                    </td>
                                                </tr>
                                                <?php if(!empty($summary_data['ord_reward_voucher_desc'])) {?>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th scope="row">Discount(<?=(int)$summary_data['ord_reward_voucher_desc']?>%):</th>
                                                    <td class="text-center"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?=number_format((float)($discount_per), 2, '.', '')?></span>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th scope="row">Tax :</th>
                                                    <td class="text-center">&dollar;<?=$summary_data['ord_tax_total'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th scope="row">Shipping Total :</th>
                                                    <td class="text-center">&dollar;<?= $summary_data['ord_shipping_total'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th scope="row">Total:</th>
                                                    <td class="text-center"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?=number_format((float)($order_total+$summary_data['ord_shipping_total'] + $summary_data['ord_tax_total'] -$discount_per), 2, '.', '')?>
                                                    </span>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <section class="woocommerce-customer-details">
                                            <h2>Delivery Information</h2>
                                            <table class="woocommerce-table woocommerce-table--customer-details shop_table customer_details">
                                                <tbody>
                                                    <tr>
                                                        <th>Billing Address:</th>
                                                        <td class="text-left"><?= $summary_data['ord_demo_bill_name'] . '<br>' . $summary_data['ord_demo_bill_company'] . ' ' . $summary_data['ord_demo_bill_address_01'] . ' ' . $summary_data['ord_demo_bill_address_02'] . '<br> ' . $summary_data['ord_demo_bill_city'] . ' - ' . $summary_data['ord_demo_bill_post_code'] . ' <br> ' . $summary_data['ord_demo_ship_state'] . '<br> ' . $summary_data['ord_demo_ship_country'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Shipping Address:</th>
                                                        <td class="text-left"><?= $summary_data['ord_demo_ship_name'] . '<br>' . $summary_data['ord_demo_ship_company'] . ' ' . $summary_data['ord_demo_ship_address_01'] . ' ' . $summary_data['ord_demo_ship_address_02'] . '<br> ' . $summary_data['ord_demo_ship_city'] . ' - ' . $summary_data['ord_demo_ship_post_code'] . ' <br> ' . $summary_data['ord_demo_ship_state'] . '<br> ' . $summary_data['ord_demo_ship_country'] ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- <h3 class="woocommerce-column__title">Billing address</h3>
                                            <address> test Last name
                                                <br>Abc
                                                <br>Make your payment directly into our bank account
                                                <br>sd
                                                <br>asdadsad, WA 98335
                                                <br>United States (US) </address> -->
                                        </section>
                                    </section>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </article>
            </main>
            <!-- End Content -->
        </div>
    </div>
    <!-- /.shopping-cart -->
</section>