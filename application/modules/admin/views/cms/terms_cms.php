<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Manage Terms and Conditions CMS</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- /.page-titile-wrapper -->
<?=form_open_multipart('admin/update_terms', array('class' => "form-horizontal m-bottom-30 footer_cms_form", 'id' => "terms_cms", 'name' => "terms_cms", 'onsubmit'=>"return checkTermsContent()"))?>
    <?=form_hidden(array('cms_id' => (!empty($terms_data[0]['cms_id']) ? $terms_data[0]['cms_id']:'')))?>
    <div class="col-md-12">
        <!-- <div class="form-group col-md-12">
            <div class="">
                <label class="control-label" for="inputTitle1">Column 1 Title</label>
                <?//=form_input(array('class' => 'form-control', 'name' => 'column_title_1', 'placeholder' => 'Enter the title for Footer Column 1'))?>
            </div>
        </div> -->
        <div class="form-group col-md-12">
            <div class="">
                <label for="terms_content" class="control-label">Content</label>
                <textarea class="ckeditor form-control" required="required" id="terms_content" name="terms_content" ><?=(!empty($terms_data[0]['content']) ? $terms_data[0]['content']:'')?></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div id="err_msg"></div>
        <hr><br>
        <div class="form-group">
            <div class="text-center">
                <input type="submit" class="btn btn-success" name="updateTermsCMS" id="updateTermsCMS" value="Update">
                   <a href="<?=base_url()?>admin/manage_cms"><button type="button" class="btn btn-danger rippler">Cancel</button></a>
            </div>
        </div>
    </div>
<?=form_close()?>
