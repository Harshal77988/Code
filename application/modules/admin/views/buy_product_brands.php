<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Manage Brands</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Manage Brands</h2><a class="btn btn-danger pull-right rippler" data-toggle="modal" data-target="#add_buy_brands">Add Brand</a> <a style="margin-right: 10px;" href="<?=base_url('admin/import_brands')?>" type="button" class="btn btn-success pull-right rippler">Import Brands</a>
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered" id="datatable-checkbox">
                <thead>
                    <tr>
                        <th width="10%">Sr No</th>
                        <th>Brand Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($prodcut_brand_list) && !empty($prodcut_brand_list)) {
                      $count = 1;
                      foreach ($prodcut_brand_list as $value) {?>
                      <tr id="id_delete_<?=$value['id']?>">
                          <td class="text-center"><span><?=$count?></span></td>
                          <td>
                              <?=$value['brand_name']?>
                          </td>
                          <td><a data-toggle="modal" data-target="#edit_buy_brand_<?=$value['id']?>" class="btn btn-xs btn-primary-outline rippler"><i class="fa fa-pencil"></i></a> <a href="#" class="btn btn-xs btn-danger-outline rippler" onclick="deleteBuyBrand(<?=$value['id']?>)"><i class="fa fa-remove"></a></td>
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
<?=$this->load->view('admin/modal/add_buy_brands')?>
<?=$this->load->view('admin/modal/edit_buy_brands')?>