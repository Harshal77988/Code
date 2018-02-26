<div class="breadcrumb-wrapper">
	<ol class="breadcrumb">
		<li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
		<li class="active">Manage Coupons</li>
	</ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
	<h2 class="page-title">Manage Coupons</h2>
	<a href="<?=base_url('admin/add_coupon')?>" type="button" class="btn btn-danger pull-right rippler">Add Coupon</a>
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
	<div class="col-sm-12">
		<?=form_open("admin_library/summary_discounts", array('class' => "form-horizontal"))?>
		<table class="table table-striped table-bordered" id="datatable-checkbox">
			<thead>
				<tr>
					<th>Coupon</th>
					<th>Usage Limit</th>
					<th>Valid Date</th>
					<th>Expiry Date</th>
					<th>Discount (%)</th>
					<th>Status</th>
					<th width="5%">Remove</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($discount_data) && !empty($discount_data)) {
					$count = 1;
					foreach ($discount_data as $row) {
						$discount_id = $row[$this->flexi_cart_admin->db_column('discounts', 'id')];
				?>
				<tr>
					<td><?=$row[$this->flexi_cart_admin->db_column('discounts', 'code')]; ?></td>
					<td><?=$row[$this->flexi_cart_admin->db_column('discounts', 'usage_limit')]; ?></td>
					<td><?=date('d-m-Y', strtotime($row[$this->flexi_cart_admin->db_column('discounts', 'valid_date')])); ?></td>
					<td><?=date('d-m-Y', strtotime($row[$this->flexi_cart_admin->db_column('discounts', 'expire_date')])); ?></td>
					<td><?=(int)$row[$this->flexi_cart_admin->db_column('discounts', 'value_discounted')]; ?></td>
					<td>
						<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('discounts', 'status')]; ?>
						<!-- <input type="hidden" name="update[<?=$discount_id?>][status]" value="<?=$status?>"> -->
						<div class="checkbox">
							<label>
								<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('discounts', 'status')]; ?>
								<input type="hidden" name="update[<?php echo $discount_id; ?>][status]" value="0"/>
								<input type="checkbox" class="icheck" name="update[<?php echo $discount_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$discount_id.'][status]','1', $status); ?>/>
							</label>
						</div>
					</td>					
					<td>
						<input type="hidden" name="update[<?php echo $discount_id; ?>][delete]" value="0"/>
								<input type="checkbox" class="icheck" name="update[<?php echo $discount_id; ?>][delete]" value="1"/>
					</td>
					<td>
						<input type="hidden" name="update[<?php echo $discount_id; ?>][id]" value="<?php echo $discount_id; ?>"/>
						<a href="<?=base_url()?>admin_library/update_discount/<?=$discount_id?>" type="button" class="btn btn-xs btn-primary-outline"><i class="fa fa-pencil"></i></a>
					</td>
				</tr>
				<?php $count++;
				}
			} ?>
			</tbody>
		</table>
		<div class="col-sm-12 text-center">
			<?=form_submit(array("name" => "update_discounts", "value" => "Update Discounts", "class" => "btn btn-primary link_button large "))?>
		</div>
		<?=form_close()?>
	</div>
	<!-- /.panel-body -->
</div>