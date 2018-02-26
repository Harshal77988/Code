<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Rent Product List</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Rent Product List</h2>
    <a href="<?=base_url('admin/add_rent_products')?>" type="button" class="btn btn-danger pull-right rippler">Add Product</a>
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <form autocomplete="off">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable-checkbox">
                    <thead>
                        <tr>
                            <th width="auto">Sr No</th>
                            <th>Image</th>
                            <th>Product&nbsp;Name</th>
                            <th>Type</th>
                            <th>Rent</th>
                            <th>Plan</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($product_details) && !empty($product_details)) {
                        $count = 1;                        
                        foreach ($product_details as $value) {
                          $image_url = json_decode($value['image_url'], true);
                          ?>
                          <tr id="id_delete_<?=$value['id']?>">
                            <td class="text-center" style="width: 30px;"><span><?=$count?></span></td>
                            <td style="width: 70px;"><img class="img-responsive" src="<?=base_url()?>frontend/assets/images/rent_products/<?=$image_url[0]?>"></td>
                            <td><?=$value['product_name']?></td>
                            <td><?php if($value['product_type'] == '0') { echo 'Furbished'; } elseif ($value['product_type'] == '1') {
                                echo 'New'; } elseif ($value['product_type'] == '2') { echo "Used"; } ?></td>
                            <td><?=($value['rent'] ? '&dollar;'.$value['rent'] : '&dollar;0') ?></td>
                            <td><?php if($value['plan'] == '0') { echo 'Week'; } elseif ($value['plan'] == '1') {
                                echo 'Month'; } elseif ($value['plan'] == '2') { echo "Year"; } elseif ($value['plan'] == '4') { echo "Day"; } ?></td>
                            <td><?=$value['quantity']?></td>
                            <td style="width: 70px;"><a href="<?=base_url()?>admin/edit_rent_products/<?=$value['id']?>" class="btn btn-default btn-xs btn-success-outline rippler" title="Edit Product"><i class="fa fa-pencil"></i></a>    <a onclick="deleteRentProduct(<?=$value['id']?>)" class="btn btn-default btn-xs btn-danger-outline rippler"><i class="fa fa-remove" title="Delete Product"></i></a></td>
                        </tr>
                        <?php
                        $count++;
                    }
                }?>
            </tbody>
        </table>
    </div>
    <!-- /.table-responsive -->
</form>
</div>
<!-- /.col-sm-12 -->
</div>
<!-- /.row -->