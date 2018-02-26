<!-- modal for add category of buy section -->
<style>
.select2-container.select2-container--bootstrap.select2-container--open{
    z-index: 99999999; 
}
.select2.select2-container{
    width: 100% !important;
}

</style>

<div class="modal fade" tabindex="-1" data-width="500" id="add_buy_brands" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Buy - Add Brand</h4>
    </div><!-- /.modal-header -->
    <form class="form-horizontal" novalidate="novalidate" id="add_buy_brand_form">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="add_brand_error_msg"></div>                    
                    <div class="form-group">
                        <label for="brand_name" class="control-label col-sm-4">Brand Name *</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => "form-control", 'id' => "add_brand_name", 'name' => "brand_name", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required'))?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-body -->

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            <b class="btn_add_brand"><button type="button" class="btn btn-primary" id="add_buy_brand_btn">Add Brand</button></b>
        </div><!-- /.modal-footer -->
    </form>
</div>
<!-- modal for add category of buy section end -->