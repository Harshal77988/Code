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
        <li class="active">Add Attribute</li>
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

                <div class="panel-body">
                    <form method="post" action="<?=base_url()?>admin/ajaxAddBuyAttribute" name="" novalidate="novalidate" id="add_buy_attribute_form">
                        <div class="form-layout">
                            <div class="form-layout-body">
                                <!-- <label><input type="radio" class="" id="is_attribute" value="0" name="is_brand" checked="checked"></label>&nbsp;&nbsp;None&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                                <label><input type="checkbox" class="icheck-minimal-grey" id="is_brand" value="1" name="is_brand"></label>&nbsp;&nbsp;Brand&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!-- <label><input type="radio" class="" id="is_subcategory" value="2" name="is_brand"></label>&nbsp;&nbsp;Sub-category&nbsp;&nbsp;&nbsp; -->
                                <br><br>
                                <div class="sub_cat_replace_div">
                                    <div class="hidden_div_2">
                                        <!-- <div class="form-group hidden_div_1" style="display: none">
                                            <label for="inputName1">Select the category *</label>
                                            <?=form_dropdown(array(
                                                    'id' => 'add_category_attribute',
                                                    'name' => 'category_attribute',
                                                    'class' => 'form-control', 'required' => 'required'
                                                    ), $product_category
                                                );
                                            ?>
                                        </div> -->
                                        <div class="form-group">
                                            <label for="inputName1">Value *</label>
                                            <input type="text" class="form-control" placeholder="Attribute value" name="attribute_value" id="attribute_value">
                                        </div>
                                        <!-- /.form-group -->
                                        <hr>
                                        <div class="form-group">
                                            <label for="category_name" class="control-label">Sub Attributes *</label>
                                            <div id="div_add_more">
                                                <div class="form-group">
                                                    <div for="category_description" class="col-sm-4">
                                                        <?=form_input(array('class' => "form-control", 'id' => "add_sub_attribute_name", 'name' => "add_sub_attribute_name[]", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => 'Enter the name'))?>                                
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <?=form_input(array('class' => "form-control", 'id' => "tags", 'name' => "tags[]", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => 'Enter the tag'))?>
                                                    </div>
                                                </div>
                                            </div><br>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="col-md-12" style="margin-top: 10px">
                                            <button type="button" class="btn btn-primary btn-xs pull-right" id="add_more_attribute_values" onclick="append_more()">Add More</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <!-- /.form-layout-body -->
                            <div class="form-layout-footer">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">Add</button>
                                    <!-- <button type="button" class="btn btn-default rippler">Cancel</button> -->
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.form-layout-footer -->
                        </div>
                        <!-- /.form-layout -->
                    </form>
                </div>
            <!-- /.panel-body -->
            </div>
        <!--/.panel-->
        </div>
    </div>
</div>