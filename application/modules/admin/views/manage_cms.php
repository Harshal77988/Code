<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Manage Pages</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Manage Pages</h2>
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
                            <th>Page Name</th>
                            <th>Updated Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($section) && !empty($section)) {
                        $count = 1;                        
                        foreach ($section as $value) {?>
                          <tr id="id_delete_<?=$value['cms_id']?>">
                            <td class="text-center" style="width: 8%;"><span><?=$count?></span></td>
                            <td><?=$value['page_alias']?></td>
                            <td><?=date('Y-m-d h:i:s A', strtotime($value['on_date']))?></td>
                            <td><a href="<?=base_url()?>admin/edit_cms_page/<?=$value['cms_id']?>" class="btn btn-default btn-xs btn-success-outline rippler" title="Edit Product"><i class="fa fa-pencil"></i></a></td>
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