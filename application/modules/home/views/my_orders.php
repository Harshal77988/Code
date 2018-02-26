<section class="shopping-cart">
    <!-- .shopping-cart -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                    <li class="breadcrumb-item active">My Orders</li>
                </ol>
            </div>
            <!-- Start Content -->
            <div class="col-xs-12 content-area" id="main-column">
                <main id="main" class="site-main">
                    <article id="post-12" class="post-12 page type-page status-publish hentry">
                        <header class="entry-header">
                            <h1 class="entry-title">My Orders</h1></header>
                        <div class="entry-content">
                            <div class="woocommerce">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3 myaccount-navigation">
                                        <ul class="nav">
                                            <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account <?=($this->uri->segment(1) == 'my_account' ? ' is-active' : '')?>">
                                                <a href="<?=base_url('my_account')?>">Account details</a>
                                            </li>
                                            <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders <?=($this->uri->segment(1) == 'my_orders' ? ' is-active' : '')?>">
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
                                        <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
                                            <thead>
                                                <tr>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">#Order Id</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Quantity</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Order Date</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Status</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-total"><span class="nobr">Total Amount</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions text-center"><span class="nobr">Action</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($my_orders as $sid => $odata) {
                                                    $order_total = $odata['ord_item_summary_total'];
                                                    $discount_per = ($order_total/100)*(int)$odata['ord_reward_voucher_desc'];
                                                    ?>
                                                <tr>
                                                    <td>
                                                        <p>#<?=$odata['ord_order_number']?></p>
                                                        <?=($odata['order_type'] == '2' ? '<p class="rent-label">(Pre-order)</p>':'')?>
                                                    </td>
                                                    <td><?=(int)$odata['ord_det_quantity']?></td>
                                                    <td><?=date('d F y', strtotime($odata['ord_date']))?></td>
                                                    <td><?php
                                                        if($odata['ord_status'] == '1') {
                                                            echo "<button class='btn btn-warning'>Awaiting Payment</button>";
                                                        } else if($odata['ord_status'] == '2') {
                                                            echo "<button class='btn btn-primary'>New Order</button>";
                                                        } else if($odata['ord_status'] == '3') {
                                                            echo "<button class='btn btn-inverse'>Processing Order</button>";
                                                        } else if($odata['ord_status'] == '4') { 
                                                            echo "<button class='btn btn-success'>Order Complete</button>";
                                                        } else {
                                                            echo "<button class='btn btn-danger'>Order Cancelled</button>";
                                                        }?></td>
                                                    <td>&dollar;<?=number_format((float)($order_total + $odata['ord_tax_total'] + $odata['ord_shipping_total']-$discount_per), 2, '.', '')?></td>
                                                    <td class="text-center"><a class="btn btn-xs woocommerce-button button view" title="" data-toggle="tooltip" href="<?=base_url()?>admin_library/order_details/<?=$odata['ord_order_number']?>" data-original-title="View"><i class="fa fa-eye"></i></a></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </article>
                </main>
            </div>
            <!-- End Content -->
        </div>
    </div>
    <!-- /.shopping-cart -->
</section>