<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Deals of the Week Products List</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Products List</h2>
    <!-- <a href="<?=base_url('admin/add_products')?>" type="button" class="btn btn-danger pull-right rippler">Add Products</a> -->
    <!-- <a style="margin-right: 10px;" href="<?=base_url('admin/import_products')?>" type="button" class="btn btn-success pull-right rippler">Import Products</a> -->
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
                            <th>Product Image</th>
                            <th>Product&nbsp;Name</th>
                            <th>Price</th>
                            <th>Discounted Price</th>
                            <th>Quantity</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <!-- <th>Status</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($dow_product_details) && !empty($dow_product_details)) {
                        $count = 1;                        
                        foreach ($dow_product_details as $value) {
                          $image_url = json_decode($value['image_url'], true);
                          ?>
                          <tr id="id_delete_<?=$value['id']?>">
                            <td class="text-center"><span><?=$count?></span></td>
                            <td style="width: 70px;"><img class="img-responsive" src="<?=base_url()?>frontend/assets/images/products/<?=$image_url[0]?>"></td>
                            <td><?=$value['product_name']?></td>
                            <td><?=($value['price'] ? '&dollar;'.$value['price'] : '&dollar;0') ?></td>
                            <td><?=($value['discounted_price'] ? '&dollar;'.$value['discounted_price'] : '&dollar;0') ?></td>
                            <td><?=$value['quantity']?></td>
                            <!-- <td><?=($value['isactive'] == '0' ? '<button class="btn btn-xs btn-default"><i class="fa fa-check"></i><a href="'.base_url().'auth/deactivate/1">Active</a></button>' : '<button class="btn btn-xs btn-default"><i class="fa fa-check"></i><a href="'.base_url().'auth/deactivate/1">In-active</a></button>') ?></td> -->
                           
                            <td><?=$value['start_date_time']?></td>
                            <td><?=$value['end_date_time']?></td>

                            <td><!-- <a class="btn btn-default btn-sm btn-primary-outline rippler" title="View Product Detail"><i class="fa fa-eye"></i></a> -->    <a href="<?=base_url()?>admin/edit_dow_product/<?=$value['id']?>" class="btn btn-default btn-xs btn-success-outline rippler" title="Edit Product"><i class="fa fa-pencil"></i></a>    <a onclick="deleteDOWProduct(<?=$value['product_id']?>)" class="btn btn-default btn-xs btn-danger-outline rippler"><i class="fa fa-remove" title="Delete Product"></i></a></td>
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