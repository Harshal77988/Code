<div class="breadcrumb-wrapper">
  <ol class="breadcrumb">
    <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
    <li class="active">Product Categories</li>
  </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
  <h2 class="page-title">Products Categories</h2><a class="btn btn-danger pull-right rippler" href="<?=base_url()?>admin/addBuyAttribute">Add Sub Category</a>
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
  <div class="col-sm-12">
    <div class="table-responsive">
      <table class="table table-bordered" id="datatable-checkbox">
        <thead>
          <tr>
            <th width="10%"></th>
            <th>Category Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($sub_categories) && !empty($sub_categories)) {
          $count = 1;                        
          foreach ($sub_categories as $value) {?>
          <tr id="id_delete_<?=$value['id']?>">
            <td class="text-center"><span><?=$count?></span></td>
            <td>
              <?=$value['attrubute_value']?>
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