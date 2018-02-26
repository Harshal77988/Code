<div class="breadcrumb-wrapper">
	<ol class="breadcrumb">
		<li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
		<li class="active">Customers</li>
	</ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
	<h2 class="page-title">All Customers</h2>
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped table-bordered" id="datatable-checkbox">
			<thead>
				<tr>
					<!-- <th width="10%"></th> -->
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Group</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($customers) && !empty($customers)) {
					$count = 1;
					foreach ($customers as $value) {?>
				<tr id="id_delete_<?=$value->id?>">
					<!-- <td class="text-center">
						<button type="button" class="btn btn-hexagon btn-hexagon-danger btn-xs"><span><?=$count?></span></button>
					</td> -->
					<td>
						<?=$value->first_name?>
					</td>
					<td>
						<?=$value->last_name?>
					</td>
					<td>
						<?=$value->email?>
					</td>
					<td>
						<?php foreach ($value->groups as $group): ?>
						<button type="button" class="btn btn-xs btn-success-outline" id="delete-user"><i class="fa fa-users"></i>
							<?=$group->name?>
						</button>
						<?php endforeach ?>
					</td>
					<td>
						<?=($value->active == '1' ? '<button type="button" class="btn btn-xs btn-success-outline" data-toggle="modal" data-target="#de-activate">Active</button>' : '<button type="button" class="btn btn-xs btn-danger-outline" data-toggle="modal" data-target="#de-activate">De-Active</button>')?>
					</td>
					<td>
						<a href="<?=base_url()?>auth/edit_customer/<?=$value->id?>" type="button" class="btn btn-xs btn-primary-outline"><i class="fa fa-pencil"></i></a>
						<button type="button" class="btn btn-xs btn-danger-outline" id="delete-user" onclick="deleteUser(<?=$value->id?>)"><i class="fa fa-remove" title="Delete Product"></i></button>
					</td>
				</tr>
				<?php $count++;
				}
			} ?>
			</tbody>
		</table>
	</div>
	<!-- /.panel-body -->
</div>