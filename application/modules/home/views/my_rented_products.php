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
                                            <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address <?=($this->uri->segment(1) == 'rented_products' ? ' is-active' : '')?>">
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
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Preview</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">#Order Id</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Rent</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Duration</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Start Date</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">End Date</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Total Rent</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($my_rented_list)) {
                                                    foreach ($my_rented_list as $sid => $odata) {
                                                        $image_url = json_decode($odata['image_url'], true);
                                                        if($odata['param'] == 'day') {
                                                            // $end_date = date($odata['start_date'], time() + 86400);
                                                            $end_date = strtotime(date("Y-m-d", strtotime($odata['start_date'])) . " +".$odata['duration']." day");
                                                        } else if($odata['param'] == 'week') {
                                                            $end_date = strtotime(date("Y-m-d", strtotime($odata['start_date'])) . " +".$odata['duration']." week");
                                                        } else if($odata['param'] == 'month') {
                                                            // $end_date = date($odata['start_date'], strtotime("+1 month", $time));
                                                            $end_date = strtotime(date("Y-m-d", strtotime($odata['start_date'])) . " +".$odata['duration']." month");
                                                        } else if($odata['param'] == 'year') {
                                                            $end_date = strtotime(date("Y-m-d", strtotime($odata['start_date'])) . " +".$odata['duration']." year");
                                                        }
                                                    ?>
                                                <tr>
                                                    <td style="width: 10%;"><?php if(!empty($image_url[0])) {?>
                                                        <img class="img-responsive" src="<?=base_url() ?>frontend/assets/images/products/<?=$image_url[0]?>" alt="2">
                                                        <?php } else {?>
                                                        <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                                        <?php } ?>
                                                    </td>
                                                    <td>#<?=$odata['order_id']?></td>
                                                    <td><?='$'.$odata['rent'].'/'.$odata['param']?></td>
                                                    <td><?=$odata['duration'].' '.$odata['param'].'(s)'?></td>
                                                    <td><?=date('d F y', strtotime($odata['start_date']))?></td>
                                                    <td><?=date('d F y', $end_date)?></td>
                                                    <td><?='$'.$odata['duration']*$odata['rent']?></td>
                                                </tr>
                                                <?php } } else { ?>
                                                <tr>
                                                    <td colspan="5">No product fount in Rent list</td>
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