<!-- modal for add category of buy section -->
<style>
.select2-container.select2-container--bootstrap.select2-container--open{
    z-index: 99999999; 
}
.select2.select2-container{
    width: 100% !important;
}
</style>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<div class="modal fade" tabindex="-1" data-width="700" id="newsletter_modal" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Send Newsletter</h4>
    </div><!-- /.modal-header -->
    <form class="form-horizontal" novalidate="novalidate" id="newsletter_form">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="add_error_msg"></div>
                    <div class="form-group">
                        <label for="email_subject" class="control-label col-sm-2">Subject *</label>
                        <div class="col-sm-10">
                            <?=form_input(array('class' => "form-control", 'id' => "email_subject", 'name' => "email_subject", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required'))?>
                        </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label for="email_content" class="control-label col-sm-2">Message *</label>
                        <div class="col-sm-10">
                            <?=form_textarea(array('class' => "form-control", 'id' => "email_content", 'name' => "email_content", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required'))?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-body -->

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            <b class="btn_send_email"><button type="button" class="btn btn-primary" id="send_email_btn">Send Email</button></b>
        </div><!-- /.modal-footer -->
    </form>
</div>
<!-- modal for add category of buy section end -->