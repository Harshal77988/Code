<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Manage Policies</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- /.page-titile-wrapper -->
<?php
$head = explode('-heading-', $post_info[0]['heading']);
$content = explode('-content-', $post_info[0]['content']);

//print_r($img);
?>
<?= form_open_multipart('admin/policy_cms', array('class' => "form-horizontal m-bottom-30", 'id' => "policy_cms")) ?>
<?= form_hidden(array('cms_id' => (!empty($post_info[0]['cms_id']) ? $post_info[0]['cms_id'] : ''))) ?>
<div class="col-md-6">
    <div class="form-group col-md-12">
        <h3>PRIVACY STATEMENT</h3>
        <div class="form-group">
            <label  class="control-label h5" for="heading1"> Heading </label>
         
            <input type="text" class="form-control"  id="heading1" name="heading1" value="<?= (!empty($post_info[0]['heading']) && !empty($head[0]) ? $head[0] : '') ?>" >
        </div>
       
        <div class="form-group">
            <label for="column_content_1" class="control-label h5"> Content</label>
            <textarea class="ckeditor form-control" required="required" id="column_content_1" name="column_content_1" ><?= (!empty($post_info[0]['content']) && !empty($content[0]) ? $content[0] : '') ?></textarea>
        </div>


    </div>
    <!-- column 1 title and content end -->
</div>



<div class="col-md-6">
  
    <div class="form-group col-md-12">
        <h3>RETURNS POLICY</h3>
        <div class="form-group">
            <label for="heading2" class="control-label h5"> Heading </label>
            <input type="text" class="form-control" required="required" id="heading2" name="heading2" value="<?= (!empty($post_info[0]['heading']) && !empty($head[1]) ? $head[1] : '') ?>" >
        </div>
        
        <div class="form-group">
            <label for="column_content_2" class="control-label h5">Content</label>
            <textarea class="ckeditor form-control" required="required" id="column_content_2" name="column_content_2" ><?= (!empty($post_info[0]['content']) && !empty($content[1]) ? $content[1] : '') ?></textarea>
        </div>
    </div>
    <!-- column 3 title and content end -->
</div>


<div class="col-md-12">
    <hr><br>
    <div class="form-group">
        <div class="text-center">
            <input type="submit" class="btn btn-success" name="Policy_cms" id="Policy_cms" value="Update">
            <a href="<?= base_url() ?>admin/manage_cms"><button type="button" class="btn btn-danger rippler">Cancel</button></a>

        </div>
    </div>
</div>
<?= form_close() ?>
<script type="text/javascript">
    function readURL(input, id) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                console.log(e.target.result);
                $('#prev_img' + id)
                        .attr('src', e.target.result)
                        .width(217)
                        .height(230);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeURL(id) {
        $('#prev_img' + id).attr('src', '<?= base_url() ?>frontend/assets/images/default_product.jpg');
    }


</script>