<div class="breadcrumb-wrapper">
  <ol class="breadcrumb">
    <li><a href="dashboard1.html"><i class="fa fa-home"></i>Home</a></li>
    <li class="active">Pre-order Details</li>
  </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
  <h2 class="page-title">Pre-order Details - <b>#<?=$summary_data['ord_order_number']?></b></h2>
  <div class="tools-content">
    <div class="btn-group pull-right">
      <?php
        $button_status = 'btn-success';
        if($summary_data['ord_status_id'] == 1) {
            $button_status = 'btn-warning';
        } else if($summary_data['ord_status_id'] == 2) {
            $button_status = 'btn-primary';
        } else if($summary_data['ord_status_id'] == 3) {
            $button_status = 'btn-inverse';
        } else if($summary_data['ord_status_id'] == 4) {
            $button_status = 'btn-success';
        } else if($summary_data['ord_status_id'] == 5) {
            $button_status = 'btn-danger';
        } ?>
      <button type="button" class="btn <?=$button_status?> dropdown-toggle btn-sm" data-toggle="dropdown">
        <i class="fa fa-bullhorn m-right-5"></i>
        <span><?=$summary_data['ord_status_description']?></span>
        <i class="fa fa-angle-down m-left-5"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-right">
        <?php if(!empty($all_order_status)) {
          foreach ($all_order_status as $k => $v) {
              if($v['ord_status_id'] !== $summary_data['ord_status_id']) {?>
              <li><a onclick="changeOrderStatus('<?=$v['ord_status_id']?>', '<?=$summary_data['ord_order_number']?>')"><?=$v['ord_status_description']?></a></li>      
          <?php }
          }
        }?>
      </ul>
    </div><!-- /.btn-group -->
  </div>
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
  <div class="col-sm-12">
        <div class="row">
            <?php if (isset($item_data) && !empty($item_data)) {?>
              <div class="col-sm-12">
                <div class="panel panel-inverse">
                  <div class="panel-heading">
                    <div class="panel-title">
                      <i class="fa fa-home m-right-5"></i> Order Content
                    </div>
                    <!-- /.panel-title -->
                  </div>
                  <!-- /.panel-heading -->
                  <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($item_data as $row) {?>
                        <tr>
                            <td><?=$row['ord_det_item_name'] ?></td>
                            <td><?=round($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity')], 2); ?></td>
                            <td>
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
                            </td>
                            <td>
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
                            </td>
                        </tr>
                        <?php }?>
                      </tbody>
                      <tfoot>
                          <tr>
                              <th colspan="2"></th>
                              <th scope="row">Subtotal:</th>
                              <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?=$summary_data['ord_item_summary_total'] ?></span>
                              </td>
                          </tr>
                          <tr>
                              <th colspan="2"></th>
                              <th scope="row">Tax :</th>
                              <td>&dollar;<?=$summary_data['ord_tax_total'] ?></td>
                          </tr>
                          <?php
                              $order_total = $summary_data['ord_item_summary_total'];
                              $discount_per = (!empty($summary_data['ord_reward_voucher_desc']) ? ($order_total/100)*(int)$summary_data['ord_reward_voucher_desc'] : '0');
                            if(!empty($summary_data['ord_reward_voucher_desc'])) {?>
                          <tr>
                              <th colspan="2"></th>
                              <th scope="row">Discount(<?=(int)$summary_data['ord_reward_voucher_desc']?>%):</th>
                              <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?=number_format((float)($discount_per), 2, '.', '')?></span>
                              </td>
                          </tr>
                          <?php } ?>
                          <tr>
                              <th colspan="2"></th>
                              <th scope="row">Shipping Total :</th>
                              <td>&dollar;<?=$summary_data['ord_shipping_total'] ?></td>
                          </tr>
                          <tr>
                              <th colspan="2"></th>
                              <th scope="row">Total:</th>
                              <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span><?=($summary_data['ord_shipping_total'] + $summary_data['ord_tax_total'] - $discount_per + $summary_data['ord_item_summary_total'])?></span>
                              </td>
                          </tr>
                      </tfoot>
                  </table>
                </div>
            </div>
          <!-- /.col-sm-6 -->
          <?php }?>
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-sm-6">
            <div class="panel panel-inverse">
              <div class="panel-heading">
                <div class="panel-title">
                  <i class="fa fa-home m-right-5"></i> Billing Address
                </div>
                <!-- /.panel-title -->
              </div>
              <!-- /.panel-heading -->
              <table class="table table-bordered">
                  <tbody>
                      <tr>
                        <td>Name:</td>
                        <td><?= $summary_data['ord_demo_bill_name']?></td>
                      </tr>
                      <tr>
                        <td>Address:</td>
                        <td><?=$summary_data['ord_demo_bill_company'].'   '.$summary_data['ord_demo_bill_address_01'] . ' ' . $summary_data['ord_demo_bill_address_02']?></td>
                      </tr>
                      <tr>
                        <td>Postal Code:</td>
                        <td><?=$summary_data['ord_demo_bill_post_code']?></td>
                      </tr>
                      <tr>
                        <td>City &amp; State :</td>
                        <td><?=$summary_data['ord_demo_bill_city'] .'   '.$summary_data['ord_demo_ship_country']?></td>
                      </tr>
                      <tr>
                        <td>Country:</td>
                        <td><?=$summary_data['ord_demo_ship_state']?></td>
                      </tr>
                  </tbody>
              </table>
            </div>
            <!--/.panel-->
          </div>
          <!-- /.col-sm-6 -->
          <div class="col-sm-6">
            <div class="panel panel-inverse">
              <div class="panel-heading">
                <div class="panel-title">
                  <i class="fa fa-home m-right-5"></i> Shipping Address
                </div>
                <!-- /.panel-tools -->
              </div>
              <!-- /.panel-heading -->
              <table class="table table-bordered">
                  <tbody>
                    <tr>
                        <td>Name:</td>
                        <td><?= $summary_data['ord_demo_bill_name']?></td>
                      </tr>
                      <tr>
                        <td>Address:</td>
                        <td><?=$summary_data['ord_demo_bill_company'].'   '.$summary_data['ord_demo_bill_address_01'] . ' ' . $summary_data['ord_demo_bill_address_02']?></td>
                      </tr>
                      <tr>
                        <td>Postal Code:</td>
                        <td><?=$summary_data['ord_demo_bill_post_code']?></td>
                      </tr>
                      <tr>
                        <td>City &amp; State :</td>
                        <td><?=$summary_data['ord_demo_bill_city'] .'   '.$summary_data['ord_demo_ship_country']?></td>
                      </tr>
                      <tr>
                        <td>Country:</td>
                        <td><?=$summary_data['ord_demo_ship_state']?></td>
                      </tr>
                  </tbody>
              </table>
            </div>
            <!--/.panel-->
          </div>
          <!-- /.col-sm-6 -->
        </div>
        <!-- /.row -->
  </div>
  <!-- /.col-sm-12 -->
</div>
<!-- /.row -->