<!-- modal for edit category of buy section -->
<style>
.select2-container.select2-container--bootstrap.select2-container--open{
    z-index: 99999999; 
}
.select2.select2-container{
    width: 100% !important;
}
</style>
<?php if (!empty($prodcut_brand_list) && isset($prodcut_brand_list)) {?>
<?php foreach ($prodcut_brand_list as $key => $pData) { ?>
<div class="modal fade" tabindex="-1" data-width="500" id="edit_buy_brand_<?=$pData['id'] ?>" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Buy - Edit Brand</h4>
    </div><!-- /.modal-header -->
    <form class="form-horizontal" novalidate="novalidate" id="edit_buy_brand_form_<?=$pData['id']?>">
        <input type="hidden" name="brand_id" id="brand_id_<?=$pData['id']?>" value="<?=$pData['id']?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="edit_error_msg_<?=$pData['id'] ?>"></div>
                    <p class="message_here"></p>
                    <div class="form-group">
                        <label for="brand_name" class="control-label col-sm-4">Brand Name *</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => "form-control", 'id' => "edit_brand_name_".$pData['id'], 'name' => "brand_name", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'value' => html_entity_decode(set_value('brand_name', ($pData['brand_name'])))))?>
                        </div>
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div><!-- /.modal-body -->

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            <b class="btn_edit_brand_<?=$pData['id'] ?>"><button type="button" class="btn btn-primary" id="edit_buy_brand_btn_<?=$pData['id'] ?>" onclick = "edit_brand(<?=$pData['id'] ?>)">Update Brand</button></b>
        </div><!-- /.modal-footer -->
    </form>
</div>
<?php }
}?>