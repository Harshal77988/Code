<!-- modal for add category of buy section -->
<style>
.select2-container.select2-container--bootstrap.select2-container--open{
    z-index: 99999999; 
}
.select2.select2-container{
    width: 100% !important;
}

</style>

<div class="modal fade" tabindex="-1" data-width="500" id="add_rent_category" style="display: none;" data-keyboard="false" data-backdrop="static">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Rent - Add Category</h4>
    </div><!-- /.modal-header -->
    <form class="form-horizontal" novalidate="novalidate" id="add_rent_category_form">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="add_rent_error_msg"></div>
                    <div class="form-group">
                        <label for="category_name" class="control-label col-sm-4">Category Name *</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => "form-control", 'id' => "add_rent_category_name", 'name' => "category_name", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => 'category name'))?>
                        </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label for="category_description" class="control-label col-sm-4">Description *</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => "form-control", 'id' => "add_rent_category_description", 'name' => "category_description", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => 'category description'))?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-body -->

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            <b class="rent_btn_add_category"><button type="button" class="btn btn-primary" id="add_rent_category_btn">Add Category</button></b>
        </div><!-- /.modal-footer -->
    </form>
</div>
<!-- modal for add category of buy section end -->