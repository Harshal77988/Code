<style>
.select2-container.select2-container--bootstrap.select2-container--open{
    z-index: 99999999; 
}
.select2.select2-container{
    width: 100% !important;
}

</style>
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Edit Attribute</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- <div class="page-title-wrapper">
    <h2 class="page-title">Add Product</h2>
</div> -->
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-action">
                        <button class="btn btn-close rippler"></button>
                        <button class="btn btn-min rippler"></button>
                        <button class="btn btn-expand rippler"></button>
                    </div>
                    <!-- <div class="panel-title">Basic Form</div> -->
                </div>
                <!-- /.panel-heading -->
                <!-- <form class="form-horizontal" novalidate="novalidate" id="edit_buy_attribute_form"> -->
                <form method="post" action="<?=base_url()?>admin/updateBuyAttributes" name="" novalidate="novalidate" id="add_edit_attribute_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php foreach ($attribute_details as $value) {?>
                                <input type="hidden" name="attribute_id" value="<?=$value['id']?>" id="<?=$value['id']?>">
                                <div class="form-group">
                                    <label for="inputName1">Value *</label>
                                    <input type="text" class="form-control" placeholder="Attribute value" name="attribute_value" id="attribute_value" value="<?=$value['attrubute_value']?>">
                                </div>
                                <!-- /.form-group -->
                                <!-- <hr> -->
                                <div class="form-group">
                                    <label for="category_name" class="control-label">Sub Attributes *</label>
                                    <div id="div_add_more">
                                        <?php foreach ($value['sub_attribute_details'] as $sub_attr_list) {?>
                                            <div class="col-sm-4" style="margin-bottom: 10px;">
                                                <?=form_input(array('class' => "form-control", 'id' => "add_sub_attribute_name", 'name' => "add_sub_attribute_name[".$sub_attr_list['id']."]", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => 'Enter the name', 'value' => $sub_attr_list['sub_name']))?>                                
                                            </div>
                                            <div class="col-sm-8" style="margin-bottom: 10px;">
                                                <?=form_input(array('class' => "form-control", 'id' => "tags", 'name' => "tags[".$sub_attr_list['id']."]", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => 'Enter the tag', 'value' => $sub_attr_list['sub_value']))?>
                                            </div><br>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="col-md-12" style="margin: 10px 0">
                                    <button type="button" class="btn btn-primary btn-xs pull-right" id="add_more_attributes_value" onclick="append_more_edit()">Add More</button>
                                </div>
                                <div class="form-group" style="text-align: right;">
                                    <button type="submit" class="btn btn-primary" id="edit_buy_attribute_btn">Update Attribute</button>
                                    <a href="<?=base_url()?>admin/buy_attributes"><button type="button" class="btn btn-danger rippler">Cancel</button></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-body -->
                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal for add category of buy section end