<div class="breadcrumb-wrapper">
  <ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
    <li class="active">Daily Order Report</li>
  </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
  <div class="panel-title">
      <div class="panel-tools">
        <h2 class="page-title">Daily Order Report</h2>
        <div class="col-sm-4 pull-right">
            <?=form_open('admin/daily_reports', array())?>
            <div class="col-sm-10" style="padding: 15px 0;">
                <?=form_input(array('class' => "form-control", "placeholder" => "Select the date", "name" => "start_date", "data-provide" => "datepicker", 'value' => set_value('page_title', (!empty($this->input->post('start_date')) ? $this->input->post('start_date') : ''))))?>
            </div>
            <div class="col-sm-2">
              <?=form_submit(array('value' => "Show", "class" => "btn btn-default btn-default-outline"))?>
            </div>
            <?=form_close()?>
          </div>
        <div class="tools-content"></div>
      </div><!-- /.panel-tools -->
    </div><!-- /.panel-title -->
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-default">
      <!-- /.panel-heading -->
      <div class="panel-body">
        <table class="table table-striped table-bordered" id="datatable-dropdown">
          <thead>
            <tr>
              <th>Order Id</th>
              <th>Quantity</th>
              <th>Order Date</th>
              <th>Total Amount</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Order Id</th>
              <th>Quantity</th>
              <th>Order Date</th>
              <th>Total Amount</th>
            </tr>
          </tfoot>
          <tbody>
            <?php if (isset($all_report_detail) && !empty($all_report_detail)) {?>
            <?php foreach ($all_report_detail as $sid => $odata) { ?>
            <tr>
              <td>#<?=$odata['ord_order_number'] ?></td>
              <td><?=floatval($odata['ord_total_rows']) ?></td>
              <td><?php echo date('d F Y H:i A', strtotime($odata['ord_date'])); ?></td>
              <td>$<?php echo ($odata['ord_total'] + $odata['ord_tax_total']) ?></td>
            </tr>
            <?php }
            } ?>
          </tbody>
        </table>
      </div>
      <!-- /.panel-body -->
    </div>
    <!--/.panel-->
  </div>
  <!-- /.col-sm-12 -->
</div>
<!-- /.row -->