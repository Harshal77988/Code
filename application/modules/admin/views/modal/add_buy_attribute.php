<!-- modal for add category of buy section -->
<style>
.select2-container.select2-container--bootstrap.select2-container--open{
    z-index: 99999999; 
}
.select2.select2-container{
    width: 100% !important;
}

</style>

<div class="modal fade" tabindex="-1" data-width="500" id="add_buy_attribute" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Buy - Add Attribute</h4>
    </div><!-- /.modal-header -->
    <form class="form-horizontal" novalidate="novalidate" id="add_buy_attribute_form">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="add_attr_error_msg"></div>
                    <div class="form-group">
                        <!-- <label for="terms1" class="control-label col-sm-4">Is Feature</label> -->
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <center>
                                    <label>None&nbsp;&nbsp;<input type="radio" class="icheck-minimal-grey" id="is_attribute" value="0" name="is_brand" checked="checked"></label>&nbsp;&nbsp;&nbsp;
                                    <label>Brand&nbsp;&nbsp;<input type="radio" class="icheck-minimal-grey" id="is_brand" value="1" name="is_brand"></label>&nbsp;&nbsp;&nbsp;
                                    <label>Sub-category&nbsp;&nbsp;<input type="radio" class="icheck-minimal-grey" id="is_subcategory" value="2" name="is_brand"></label>&nbsp;&nbsp;&nbsp;
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_name" class="control-label col-sm-4">Value *</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => "form-control", 'id' => "add_attribute_name", 'name' => "add_attribute_name", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required'))?>
                        </div>
                    </div>
                    <!-- /.form-group -->
                    <hr>
                    <div class="form-group">
                        <label for="category_name" class="control-label col-sm-4">Sub Attributes *</label>
                    </div>
                    <div class="col-md-12" id="div_add_more">
                        <div class="form-group">
                            <div for="category_description" class="col-sm-4">
                                <?=form_input(array('class' => "form-control", 'id' => "add_sub_attribute_name", 'name' => "add_sub_attribute_name[]", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => 'Enter the name'))?>                                
                            </div>
                            <div class="col-sm-8">
                                <?=form_input(array('class' => "form-control", 'id' => "tags", 'name' => "tags[]", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => 'Enter the tag'))?>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-xs pull-right" id="add_more_attribute_values">Add More</button>
                    <!-- /.form-group -->
                </div>
            </div>
        </div><!-- /.modal-body -->

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            <b class="btn_add_attribute"><button type="button" class="btn btn-primary" id="add_buy_attribute_btn">Add Category</button></b>
        </div><!-- /.modal-footer -->
    </form>
</div>
<!-- modal for add category of buy section end -->