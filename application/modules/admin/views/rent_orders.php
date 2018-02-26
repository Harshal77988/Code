<div class="breadcrumb-wrapper">
  <ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
    <li class="active">All Rent Orders</li>
  </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
  <h2 class="page-title">All Rent Orders</h2>
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
                  <th>Order Date</th>
                  <th>Rent</th>
                  <th>Duration</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($all_orders) && !empty($all_orders)) {?>
                <?php foreach ($all_orders as $sid => $odata) { ?>
                <tr>
                  <td>#<?=$odata['order_id'] ?></td>
                  <td><?=date('d F y', strtotime($odata['start_date']));?></td>
                  <td>$<?=($odata['rent']) ?></td>
                  <td><?=$odata['duration'].' '.$odata['param']?></td>
                  <td>
                      <a href="<?=base_url('admin_library/admin_order_details/'.$odata['order_id'])?>" class="btn btn-default btn-sm btn-success-outline rippler" title="Edit Product"><i class="fa fa-eye"></i></a>
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