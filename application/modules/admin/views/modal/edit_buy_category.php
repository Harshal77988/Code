<!-- modal for edit category of buy section -->
<style>
.select2-container.select2-container--bootstrap.select2-container--open{
    z-index: 99999999; 
}
.select2.select2-container{
    width: 100% !important;
}
</style>
<?php if (!empty($prodcut_cat_detail) && isset($prodcut_cat_detail)) {?>
<?php foreach ($prodcut_cat_detail as $key => $pData) { ?>
<div class="modal fade" tabindex="-1" data-width="500" id="edit_buy_category_<?=$pData['id'] ?>" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Buy - Edit Category</h4>
    </div><!-- /.modal-header -->
    <form class="form-horizontal" novalidate="novalidate" id="edit_buy_category_form_<?=$pData['id']?>">
        <input type="hidden" name="product_id" id="product_id_<?=$pData['id']?>" value="<?=$pData['id']?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="edit_error_msg_<?=$pData['id'] ?>"></div>
                    <p class="message_here"></p>
                    <div class="form-group">
                        <label for="category_name" class="control-label col-sm-4">Category Name *</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => "form-control", 'id' => "edit_category_name_".$pData['id'], 'name' => "category_name", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'value' => html_entity_decode(set_value('name', ($pData['name'])))))?>
                        </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label for="category_description" class="control-label col-sm-4">Description *</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => "form-control", 'id' => "edit_category_description_".$pData['id'], 'name' => "category_description", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'value' => html_entity_decode(set_value('name', ($pData['description'])))))?>
                        </div>
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div><!-- /.modal-body -->

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            <b class="btn_edit_category_<?=$pData['id'] ?>"><button type="button" class="btn btn-primary" id="edit_buy_category_btn_<?=$pData['id'] ?>" onclick = "edit_category(<?=$pData['id'] ?>)">Update Category</button></b>
        </div><!-- /.modal-footer -->
    </form>
</div>
<?php }
}?>