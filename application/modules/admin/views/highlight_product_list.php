<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Highlighted Products List</li>
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
                            <th>Image</th>
                            <th>Actual Product Image</th>
                            <th>Sale&nbsp;Type</th>
                            <th>Product&nbsp;Title</th>
                            <th>Product&nbsp;Name</th>
                            <th>Price</th>
                            <th>Discounted Price</th>
                            <th>Quantity</th>
                            <!-- <th>Status</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($highlighted_product_details) && !empty($highlighted_product_details)) {
                            $count = 1;                        
                            foreach ($highlighted_product_details as $value) {
                                if(!empty($value['product_id'])){
                              $image_url = json_decode($value['image_url'], true);
                      ?>
                      <tr id="id_delete_<?=$value['id']?>">
                        <td class="text-center"><span><?=$count?></span></td>
                        <td style="width: 70px;"><img class="img-responsive" src="<?php if(!empty($value['img_url'])){ echo base_url().'/frontend/assets/images/products/highlighted_products/'.$value['img_url']; }else{ echo base_url().'/frontend/assets/images/default_product.jpg';}?>"></td>
                        <td style="width: 70px;"><img class="img-responsive" src="<?=base_url()?>frontend/assets/images/products/<?=$image_url[0]?>"></td>
                        <td><?=$value['sale_type']?></td>
                        <td><?=$value['product_title']?></td>
                        <td><?=$value['product_name']?></td>
                        <td><?=($value['price'] ? '&dollar;'.$value['price'] : '&dollar;0') ?></td>
                        <td><?=($value['discounted_price'] ? '&dollar;'.$value['discounted_price'] : '&dollar;0') ?></td>
                        <td><?=$value['quantity']?></td>
                        <!-- <td><?=($value['isactive'] == '0' ? '<button class="btn btn-xs btn-default"><i class="fa fa-check"></i><a href="'.base_url().'auth/deactivate/1">Active</a></button>' : '<button class="btn btn-xs btn-default"><i class="fa fa-check"></i><a href="'.base_url().'auth/deactivate/1">In-active</a></button>') ?></td> -->
                        <td><!-- <a class="btn btn-default btn-sm btn-primary-outline rippler" title="View Product Detail"><i class="fa fa-eye"></i></a> -->    <a href="<?=base_url()?>admin/edit_highlighted_product/<?=$value['id']?>" class="btn btn-default btn-xs btn-success-outline rippler" title="Edit Product"><i class="fa fa-pencil"></i></a>    <a onclick="deleteHighlightedProduct(<?=$value['product_id']?>)" class="btn btn-default btn-xs btn-danger-outline rippler"><i class="fa fa-remove" title="Delete Product"></i></a></td>
                      </tr>
                      <?php
                            $count++;
                        }
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