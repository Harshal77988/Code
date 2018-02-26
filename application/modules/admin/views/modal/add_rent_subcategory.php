<!-- modal for add category of buy section -->
<style>
.select2-container.select2-container--bootstrap.select2-container--open{
    z-index: 99999999; 
}
.select2.select2-container{
    width: 100% !important;
}

</style>

<div class="modal fade" tabindex="-1" data-width="500" id="add_rent_subcategory" style="display: none;" data-keyboard="false" data-backdrop="static">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Rent - Add Sub-Category</h4>
    </div><!-- /.modal-header -->
    <form class="form-horizontal" novalidate="novalidate" id="add_rent_subcategory_form">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="add_rent_error_msg"></div>
                    <div class="form-group">
                        <label for="rent_parent_category" class="control-label col-sm-4">Parent Category *</label>
                        <div class="col-sm-8">
                            <?php echo form_dropdown(array(
                                    'id' => 'rent_parent_category',
                                    'name' => 'rent_parent_category',
                                    'class' => 'form-control', 'required' => 'required'
                                    ), $attt_category
                                );
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subcategory_name" class="control-label col-sm-4">Sub-Category Name *</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => "form-control", 'id' => "add_rent_subcategory_name", 'name' => "subcategory_name", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => 'Sub category name'))?>
                        </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label for="subcategory_description" class="control-label col-sm-4">Description *</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => "form-control", 'id' => "add_rent_subcategory_description", 'name' => "subcategory_description", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => 'Sub-category description'))?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-body -->

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            <b class="rent_btn_add_subcategory"><button type="button" class="btn btn-primary" id="add_rent_subcategory_btn">Add Sub-Category</button></b>
        </div><!-- /.modal-footer -->
    </form>
</div>
<!-- modal for add category of buy section end -->