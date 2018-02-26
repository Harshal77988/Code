<div class="breadcrumb-wrapper">
  <ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
    <li class="active">All Orders</li>
  </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
  <h2 class="page-title">All Orders</h2>
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
  <div class="col-sm-12">
        <form autocomplete="off">
          <div class="table-responsive">
            <table class="table table-bordered" id="datatable-checkbox">
              <thead>
                <tr>
                  <th>Order Id</th>
                  <th>Quantity</th>
                  <th>Order Date</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($all_orders) && !empty($all_orders)) {?>
                <?php foreach ($all_orders as $sid => $odata) { ?>
                <tr>
                  <td>#<?=$odata['ord_order_number'] ?></td>
                  <td><?=floatval($odata['ord_total_rows']) ?></td>
                  <td><?php echo date('d F y', strtotime($odata['ord_date'])); ?>
                  <?php echo date('H:i A', strtotime($odata['ord_date'])); ?></td>
                  <td>$<?php echo ($odata['ord_total'] + $odata['ord_tax_total']) ?></td>
                  <td><span class="label label-primary"><?=$odata['ord_status_description']?></span></td>
                  <td>
                      <a href="<?=base_url('admin_library/admin_order_details/'.$odata['ord_order_number'])?>" class="btn btn-default btn-sm btn-success-outline rippler" title="Edit Product"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                <?php }
                } ?>
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </form>
  </div>
  <!-- /.col-sm-12 -->
</div>
<!-- /.row -->