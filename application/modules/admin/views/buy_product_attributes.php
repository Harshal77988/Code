<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Product Attribute</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Products Attribute</h2>
    <a class="btn btn-danger pull-right rippler" href="<?=base_url()?>admin/addBuyAttribute">Add Attribute</a> 
    <!-- <a style="margin-right: 10px;" href="<?=base_url('admin/import_attributes')?>" type="button" class="btn btn-success pull-right rippler">Import Attributes</a> -->
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
  <div class="col-sm-12">
    <form autocomplete="off">
      <div class="table-responsive">
        <table class="table table-bordered" id="datatable-checkbox">
          <thead>
            <tr>
              <th width="10%">Sr No</th>
              <th>Value</th>
              <th>Sub Attributes</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if(isset($attribute_details) && !empty($attribute_details)) {
                $count = 1;                        
                foreach ($attribute_details as $value) {?>
            <tr id="id_delete_<?=$value['id']?>">
              <!-- <td class="text-center">
                <button type="button" class="btn btn-hexagon btn-hexagon-danger btn-xs"><span><?=$count?></span></button>
              </td> -->
              <td class="text-center"><span><?=$count?></span></td>
              <td>
                <?=$value['attrubute_value']?>
              </td>
              <td>
                <?php if (!empty($value['sub_attribute_details']) && isset($value['sub_attribute_details'])) { ?>
                <table class="table table-bordered">
                  <tr>
                    <th width="50%">Name</th>
                    <th>Value</th>
                  </tr>
                  <?php foreach ($value['sub_attribute_details'] as $attr_sub_data) { ?>
                  <tr>
                    <td>
                      <?=$attr_sub_data['sub_name'] ?>
                    </td>
                    <td>
                      <?=$attr_sub_data['sub_value'] ?>
                    </td>
                  </tr>
                  <?php } ?>
                </table>
                <?php } ?>
              </td>
              <td><a href="<?=base_url()?>admin/edit_buy_attribute/<?=$value['id']?>" class="btn btn-xs btn-primary-outline rippler"><i class="fa fa-pencil"></i></a> <a href="#" class="btn btn-xs btn-danger-outline rippler" onclick="deleteBuyAttribute(<?=$value['id']?>)"><i class="fa fa-remove"></a></td>
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
    <!-- </div> -->
    <!-- /.panel-body -->
    <!-- </div> -->
    <!--/.panel-->
  </div>
  <!-- /.col-sm-12 -->
</div>
<!-- /.row -->
<?=$this->load->view('admin/modal/add_buy_attribute')?>
  <?=$this->load->view('admin/modal/edit_buy_attribute')?>