<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Product List</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Product List</h2>
    <a href="<?=base_url('admin/add_products')?>" type="button" class="btn btn-danger pull-right rippler">Add Product</a> <a style="margin-right: 10px;" href="<?=base_url('admin/import_products')?>" type="button" class="btn btn-success pull-right rippler">Import Products</a>
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
                            <th>Price</th>
                            <th>Discounted Price</th>
                            <th>Quantity</th>
                            <th>Highlight</th>
                            <th>Deal of Week</th>
                            <th>On Sale
                                 <!-- <input type="text" class="form-control" value="01/01/2015 1:30 PM - 01/01/2015 2:00 PM" id="daterangepicker-example1"> -->
                             </th>
                            <!-- <th>Status</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($product_details) && !empty($product_details)) {
                        $count = 1;                        
                        foreach ($product_details as $value) {
                          $image_url = json_decode($value['image_url'], true);
                          $hp_chk_id='hp'.$value['id'];
                          $dow_chk_id='dow'.$value['id'];
                          $os_chk_id='os'.$value['id'];
                          if($value['highlighted']==1){ $hp_chk_status=1;}else{$hp_chk_status=0;}
                          if($value['deals_of_the_week']==1){ $dow_chk_status=1;}else{$dow_chk_status=0;}
                          if($value['on_sale']==1){ $os_chk_status=1;}else{$os_chk_status=0;}

                          ?>
                          <tr id="id_delete_<?=$value['id']?>">
                            <td class="text-center"><span><?=$count?></span></td>
                            <td style="width: 70px;"><img class="img-responsive" src="<?=base_url()?>frontend/assets/images/products/<?=$image_url[0]?>"></td>
                            <td><?=$value['product_name']?></td>
                            <td><?=($value['price'] ? '&dollar;'.$value['price'] : '&dollar;0') ?></td>
                            <td><?=($value['discounted_price'] ? '&dollar;'.$value['discounted_price'] : '&dollar;0') ?></td>
                            <td><?=$value['quantity']?></td>
                            <!-- <td><?=($value['isactive'] == '0' ? '<button class="btn btn-xs btn-default"><i class="fa fa-check"></i><a href="'.base_url().'auth/deactivate/1">Active</a></button>' : '<button class="btn btn-xs btn-default"><i class="fa fa-check"></i><a href="'.base_url().'auth/deactivate/1">In-active</a></button>') ?></td> -->

                            <!-- class="icheck-minimal-grey" -->
                            <td align="center">
                                <label><input type="checkbox"  id="<?=$hp_chk_id?>" class="highlight-product" onclick="markAsHighlightedProduct('<?=$hp_chk_status?>',<?=$value['id']?>,'<?=$value['product_name']?>','Default Sale Type','<?=$value['discounted_price']?>')" <?php if($value['highlighted']==1){ echo 'checked';}?>></label>
                            </td>
                            <td align="center">
                                <label><input type="checkbox"  id="<?=$dow_chk_id?>" class="deal-of-week-product" onclick="markAsDealOfWeekProduct('<?=$dow_chk_status?>',<?=$value['id']?>)" <?php if($value['deals_of_the_week']==1){ echo 'checked';}?>></label>
                            </td>
                            <td align="center">
                                <label><input type="checkbox" id="<?=$os_chk_id?>" class="on-sale-product" onclick="markAsOnSaleProduct('<?=$os_chk_status?>',<?=$value['id']?>)" <?php if($value['on_sale']==1){ echo 'checked';}?>></label>
                            </td>

                            <td><!-- <a class="btn btn-default btn-sm btn-primary-outline rippler" title="View Product Detail"><i class="fa fa-eye"></i></a> -->    <a href="<?=base_url()?>admin/edit_buy_products/<?=$value['id']?>" class="btn btn-default btn-xs btn-success-outline rippler" title="Edit Product"><i class="fa fa-pencil"></i></a>    <a onclick="deleteBuyProduct(<?=$value['id']?>)" class="btn btn-default btn-xs btn-danger-outline rippler"><i class="fa fa-remove" title="Delete Product"></i></a></td>
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