<div class="breadcrumb-wrapper">
  <ol class="breadcrumb">
    <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
    <li class="active">Product Categories</li>
  </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
  <h2 class="page-title">Products Categories</h2><a class="btn btn-danger pull-right rippler" data-toggle="modal" data-target="#add_buy_product">Add Category</a> <a style="margin-right: 10px;" href="<?=base_url('admin/import_categories')?>" type="button" class="btn btn-success pull-right rippler">Import Categories</a>
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
  <div class="col-sm-12">
    <div class="table-responsive">
      <table class="table table-bordered" id="datatable-checkbox">
        <thead>
          <tr>
            <th width="10%">Sr No</th>
            <th>Category Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($prodcut_cat_detail) && !empty($prodcut_cat_detail)) {
$count = 1;                        
foreach ($prodcut_cat_detail as $value) {?>
          <tr id="id_delete_<?=$value['id']?>">
            <td class="text-center"><span><?=$count?></span></td>
            <td>
              <?=$value['name']?>
            </td>
            <td><a data-toggle="modal" data-target="#edit_buy_category_<?=$value['id']?>" class="btn btn-xs btn-primary-outline rippler"><i class="fa fa-pencil"></i></a> <a href="#" class="btn btn-xs btn-danger-outline rippler" onclick="deleteBuyCategory(<?=$value['id']?>)"><i class="fa fa-remove"></a></td>
          </tr>
          <?php
$count++;
}
}?>
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
  </div>
  <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
</div>
<!-- CONTENT ENDS-->
<?=$this->load->view('admin/modal/add_buy_category')?>
<?=$this->load->view('admin/modal/edit_buy_category')?>