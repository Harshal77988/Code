<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Manage Footer CMS</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- /.page-titile-wrapper -->
<?=form_open_multipart('admin/updateFooterCMS', array('class' => "form-horizontal m-bottom-30 footer_cms_form", 'id' => "footer_cms"))?>
    <?=form_hidden(array('cms_id' => (!empty($footer_cms[0]['id']) ? $footer_cms[0]['id']:'')))?>
    <div class="col-md-6">
        <!-- column 1 title and content start -->
        <!-- <div class="form-group col-md-12">
            <div class="">
                <label class="control-label" for="inputTitle1">Column 1 Title</label>
                <?=form_input(array('class' => 'form-control', 'name' => 'column_title_1', 'placeholder' => 'Enter the title for Footer Column 1'))?>
            </div>
        </div> -->
        <div class="form-group col-md-12">
            <div class="">
                <label for="inputTitle2" class="control-label">Column 1 Content</label>
                <textarea class="ckeditor form-control" required="required" id="column_content_1" name="column_content_1" ><?=(!empty($footer_cms[0]['column_content_1']) ? $footer_cms[0]['column_content_1']:'')?></textarea>
            </div>
        </div>
        <!-- column 1 title and content end -->
    </div>

    <div class="col-md-6">
        <!-- column 2 title and content start -->
        <!-- <div class="form-group col-md-12">
            <div class="">
                <label class="control-label" for="inputTitle1">Column 2 Title</label>
                <?=form_input(array('class' => 'form-control', 'name' => 'column_title_1', 'placeholder' => 'Enter the title for Footer Column 1'))?>
            </div>
        </div> -->
        <div class="form-group col-md-12">
            <div class="">
                <label for="inputTitle2" class="control-label">Column 2 Content</label>
                <textarea class="ckeditor form-control" required="required" id="column_content_2" name="column_content_2" ><?=(!empty($footer_cms[0]['column_content_2']) ? $footer_cms[0]['column_content_2']:'')?></textarea>
            </div>
        </div>
        <!-- column 2 title and content end -->
    </div>

    <div class="col-md-6">
        <!-- column 3 title and content start -->
        <!-- <div class="form-group col-md-12">
            <div class="">
                <label class="control-label" for="inputTitle1">Column 3 Title</label>
                <?=form_input(array('class' => 'form-control', 'name' => 'column_title_1', 'placeholder' => 'Enter the title for Footer Column 1'))?>
            </div>
        </div> -->
        <div class="form-group col-md-12">
            <div class="">
                <label for="inputTitle2" class="control-label">Column 3 Content</label>
                <textarea class="ckeditor form-control" required="required" id="column_content_3" name="column_content_3" ><?=(!empty($footer_cms[0]['column_content_3']) ? $footer_cms[0]['column_content_3']:'')?></textarea>
            </div>
        </div>
        <!-- column 3 title and content end -->
    </div>

    <div class="col-md-6">
        <!-- column 4 title and content start -->
        <!-- <div class="form-group col-md-12">
            <div class="">
                <label class="control-label" for="inputTitle1">Column 4 Title</label>
                <?=form_input(array('class' => 'form-control', 'name' => 'column_title_1', 'placeholder' => 'Enter the title for Footer Column 1'))?>
            </div>
        </div> -->
        <div class="form-group col-md-12">
            <div class="">
                <label for="inputTitle2" class="control-label">Column 4 Content</label>
                <textarea class="ckeditor form-control" required="required" id="column_content_4" name="column_content_4" ><?=(!empty($footer_cms[0]['column_content_4']) ? $footer_cms[0]['column_content_4']:'')?></textarea>
            </div>
        </div>
        <!-- column 4 title and content end -->
    </div>
    <div class="col-md-12">
        <hr><br>
        <div class="form-group">
            <div class="text-center">
                <input type="submit" class="btn btn-success" name="updateFooterCMS" id="updateFooterCMS" value="Update">
            </div>
        </div>
    </div>
<?=form_close()?>