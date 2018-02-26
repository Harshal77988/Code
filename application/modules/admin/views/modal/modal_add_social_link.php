<!-- modal for add social links  -->
<style>
.select2-container.select2-container--bootstrap.select2-container--open{
    z-index: 99999999; 
}
.select2.select2-container{
    width: 100% !important;
}

</style>
<div class="modal fade id_mdl_add_social_link" tabindex="-1" data-width="500" id="add_buy_brands" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Social Link</h4>
    </div><!-- /.modal-header -->

    <form id="id_form_social_link" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="post">
        <div class="modal-body">
            <?php if(isset($social_list_disabled) && !empty($social_list_disabled)) { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div id="add_social_error_msg"></div>                    
                    <div class="form-group">
                        <label for="social_link_name" class="control-label col-sm-4">Select Social Link*</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="social_id" id="social_id">
                            <?php foreach ($social_list_disabled as $value) { ?>
                                <option value="<?=$value['id']?>"><?=$value['name']?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="social_link" class="control-label col-sm-4">Link*</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => "form-control", 'placeholder' => 'Ex. link : http://sociallink.com', 'id' => "social_link", 'name' => "social_link", 'maxlength' => '150', 'minlength' => '2', 'required' => 'required'))?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
                <b class="btn_add_social"><button type="button" class="btn btn-primary" id="add_social_link_btn">Add Social Link</button></b>
            </div><!-- /.modal-footer -->
            <?php } else { ?>
                <div class="text-center">Oops ! Please contact the support of <a href="http://rebelute.com">Rebelute Digital Solutions</a> to add more social icons.</div>
            <?php } ?>
        </div>
    </form>
</div>