<style>

</style>
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Manage About CMS</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- /.page-titile-wrapper -->
<?php
$head = explode('-heading-', $post_info[0]['heading']);
$content = explode('-content-', $post_info[0]['content']);
$img = (json_decode($post_info[0]['cms_img']));
//print_r($post_info);
?>
<?= form_open_multipart('admin/about_cms', array('class' => "form-horizontal m-bottom-30", 'id' => "about_cms")) ?>
<?= form_hidden(array('cms_id' => (!empty($post_info[0]['cms_id']) ? $post_info[0]['cms_id'] : ''))) ?>
<div class="col-md-6">
    <div class="form-group col-md-12">
        <h2>Section 1</h2>
        <div class="form-group">
            <label  class="control-label h5" for="heading1"> Heading </label>
            <input type="text" class="form-control"  id="heading1" name="heading1" value="<?= (!empty($post_info[0]['heading']) && !empty($head[0]) ? $head[0] : '') ?>" >
        </div>
        <div class="form-group text-center">
            <label  class="control-label h5" style="margin-left: -443px;">Image</label><hr>
            <input type="hidden" name="replace_img[]" value="<?= (!empty($img[0]) ? $img[0] : 'default_product.jpg') ?>">    
            <img style="border: 1px solid #ccc;" class="img-reponsive" height="217" width="217" field="1" id="prev_img1" src="<?php
            if (!empty($img)) {
                echo base_url() . 'backend/assets/img/cms/' . $img[0];
            } else {
                echo base_url() . 'backend/assets/img/cms/default_product.jpg';
            }
            ?>"><hr>
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <span class="btn btn-primary btn-file">
                    <span class="fileinput-new">Select Image</span>
                    <span class="fileinput-exists">Change</span>
                    <input type="file" name="section_image[]" class="section1_image" onchange="readURL(this, '1');" id="section1_image">
                </span>
                <span class="fileinput-filename"></span>
                <!--<a href="#" class="reset fileinput-exists"   onclick="rem('1','<?php echo (!empty($img[0])?$img[0]:'default_product.jpg')?>')" style="float: none">&times;</a>-->
            </div><!-- /.fileinput -->
        </div>
        <div class="">
            <label for="column_content_1" class="control-label h5">Content</label>
            <textarea class="ckeditor form-control" required="required" id="column_content_1" name="column_content_1" ><?= (!empty($post_info[0]['content']) && !empty($content[0]) ? $content[0] : '') ?></textarea>
        </div>


    </div>
    <!-- column 1 title and content end -->
</div>



<div class="col-md-6">
    <!-- column 3 title and content start -->
    <!-- <div class="form-group col-md-12">
        <div class="">
            <label class="control-label" for="inputTitle1">Column 3 Title</label>
    <?= form_input(array('class' => 'form-control', 'name' => 'column_title_1', 'placeholder' => 'Enter the title for Footer Column 1')) ?>
        </div>
    </div> -->
    <div class="form-group col-md-12">
        <h2>Section 2</h2>
        <div class="form-group">
            <label for="heading3" class="control-label h5"> Heading </label>
            <input type="text" class="form-control" required="required" id="heading3" name="heading3" value="<?= (!empty($post_info[0]['heading']) && !empty($head[1]) ? $head[1] : '') ?>" >
        </div>
        <div class="form-group text-center">
            <label  class="control-label h5" style="margin-left: -443px;">Image</label><hr>
            <input type="hidden" name="replace_img[]" value="<?= (!empty($img[1]) ? $img[1] : 'default_product.jpg') ?>">   
            <img style="border: 1px solid #ccc;" class="img-reponsive"  height="217" width="217" field="2" id="prev_img2" src="<?php
            if (!empty($img[1])) {
                echo base_url() . 'backend/assets/img/cms/' . $img[1];
            } else {
                echo base_url() . 'backend/assets/img/cms/default_product.jpg';
            }
            ?>"><hr>
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <span class="btn btn-primary btn-file">
                    <span class="fileinput-new">Select Image</span>
                    <span class="fileinput-exists">Change</span>
                    <input type="file" name="section_image[]" class="section3_image" onchange="readURL(this, '2');" id="section3_image">
                </span>
                <span class="fileinput-filename"></span>
                <!--<a href="#" class="close fileinput-exists" data-dismiss="fileinput" onclick="removeURL('2','<?php echo (!empty($img[1])?$img[1]:'default_product.jpg')?>')" style="float: none">&times;</a>-->
            </div><!-- /.fileinput -->
        </div>
        <div class="">
            <label for="" class="control-label h5">Content</label>
            <textarea class="ckeditor form-control" required="required" id="column_content_3" name="column_content_3" ><?= (!empty($post_info[0]['content']) && !empty($content[1]) ? $content[1] : '') ?></textarea>
        </div>
    </div>
    <!-- column 3 title and content end -->
</div>
<div class="row">
    <div class="col-md-12">
        <!-- column 2 title and content start -->


        <h2>Team Members</h2>


        <div class="col-md-4">
            <div class=" text-center">
                <!--<label  class="control-label">Image</label>-->
                <hr>
                <input type="hidden" name="replace_img[]" value="<?= (!empty($img[2]) ? $img[2] : 'default_product.jpg') ?>">   
                <img style="border: 1px solid #ccc;" class="img-reponsive"  height="217" width="217" field="3" id="prev_img3" src="<?php
                if (!empty($img[2])) {
                    echo base_url() . 'backend/assets/img/cms/' . $img[2];
                } else {
                    echo base_url() . 'backend/assets/img/cms/default_product.jpg';
                }
                ?>"><hr>
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <span class="btn btn-primary btn-file">
                        <span class="fileinput-new">Select Image</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="section_image[]" class="section3_image" onchange="readURL(this, '3');" id="section3_image">
                    </span>
                    <span class="fileinput-filename"></span>
                    <!--<a href="#" class="close fileinput-exists" data-dismiss="fileinput" onclick="removeURL('3','<?php echo (!empty($img[2])?$img[2]:'default_product.jpg')?>')" style="float: none">&times;</a>-->
                </div><!-- /.fileinput -->
            </div>
            <div class="form-group col-md-12">
                <label  class="control-label h5" for="name1"> Name </label>
                <input type="text" class="form-control" required="required" id="name1" name="name1"  value="<?= (!empty($post_info[0]['heading']) && !empty($head[2]) ? $head[2] : '') ?>" >
            </div>
            <div class="form-group col-md-12">
                <label  class="control-label h5"> Designation</label>
                <textarea class=" form-control" required="required" id="designation1" name="designation1" ><?= (!empty($post_info[0]['content']) && !empty($content[2]) ? $content[2] : '') ?></textarea>
            </div>
        </div>

        <div class="col-md-4">
            <div class=" text-center">
                <!--<label  class="control-label" >Image</label><hr>-->
               <hr>
                <input type="hidden" name="replace_img[]" value="<?= (!empty($img[3]) ? $img[3] : 'default_product.jpg') ?>">   
                <img style="border: 1px solid #ccc;" class="img-reponsive"  height="217" width="217" field="4" id="prev_img4" src="<?php
                if (!empty($img[3])) {
                    echo base_url() . 'backend/assets/img/cms/' . $img[3];
                } else {
                    echo base_url() . 'backend/assets/img/cms/default_product.jpg';
                }
                ?>"><hr>
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <span class="btn btn-primary btn-file">
                        <span class="fileinput-new">Select Image</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="section_image[]" class="section3_image" onchange="readURL(this, '4');" id="section3_image">
                    </span>
                    <span class="fileinput-filename"></span>
                    <!--<a href="#" class="close fileinput-exists" data-dismiss="fileinput" onclick="removeURL('4','<?php echo (!empty($img[3])?$img[3]:'default_product.jpg')?>')" style="float: none">&times;</a>-->
                </div><!-- /.fileinput -->
            </div>
            <div class="form-group col-md-12">
                <label  class="control-label h5" for="name2"> Name </label>
                <input type="text" class="form-control" required="required" id="name2" name="name2"  value="<?= (!empty($post_info[0]['heading']) && !empty($head[3]) ? $head[3] : '') ?>" >
            </div>
            <div class="form-group col-md-12">
                <label  class="control-label h5" for="designation2"> Designation</label>
                <textarea class=" form-control" required="required" id="designation2" name="designation2" ><?= (!empty($post_info[0]['content']) && !empty($content[3]) ? $content[3] : '') ?></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class=" text-center">
                <!--<label  class="control-label">Image</label><hr>-->
                <hr>
                <input type="hidden" name="replace_img[]" value="<?= (!empty($img[4]) ? $img[4] : 'default_product.jpg') ?>">   
                <img style="border: 1px solid #ccc;" class="img-reponsive"  height="217" width="217" field="5" id="prev_img5" src="<?php
                if (!empty($img[4])) {
                    echo base_url() . 'backend/assets/img/cms/' . $img[4];
                } else {
                    echo base_url() . 'backend/assets/img/cms/default_product.jpg';
                }
                ?>"><hr>
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <span class="btn btn-primary btn-file">
                        <span class="fileinput-new">Select Image</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="section_image[]" class="section3_image" onchange="readURL(this, '5');" id="section3_image">
                    </span>
                    <span class="fileinput-filename"></span>
                    <!--<a href="#" class="close fileinput-exists" data-dismiss="fileinput" onclick="removeURL('5','<?php echo (!empty($img[4])?$img[4]:'default_product.jpg')?>')" style="float: none">&times;</a>-->
                </div><!-- /.fileinput -->
            </div>
            <div class="form-group col-md-12">
                <label  class="control-label h5"> Name </label>
                <input type="text" class="form-control" required="required" id="name3" name="name3" value="<?= (!empty($post_info[0]['heading']) && !empty($head[4]) ? $head[4] : '') ?>" >
            </div>
            <div class="form-group col-md-12">
                <label  class="control-label h5"> Designation</label>
                <textarea class=" form-control" required="required" id="designation3" name="designation3" ><?= (!empty($post_info[0]['content']) && !empty($content[4]) ? $content[4] : '') ?></textarea>
            </div>
        </div>

        <!-- column 2 title and content end -->
    </div>
</div>

<!--    <div class="col-md-6">
         column 4 title and content start 
         <div class="form-group col-md-12">
            <div class="">
                <label class="control-label" for="inputTitle1">Column 4 Title</label>
<?= form_input(array('class' => 'form-control', 'name' => 'column_title_1', 'placeholder' => 'Enter the title for Footer Column 1')) ?>
            </div>
        </div> 
        <div class="form-group col-md-12">
            <div class="">
                <label for="inputTitle2" class="control-label">Column 4 Content</label>
                <textarea class="ckeditor form-control" required="required" id="column_content_4" name="column_content_4" ><?= (!empty($footer_cms[0]['column_content_4']) ? $footer_cms[0]['column_content_4'] : '') ?></textarea>
            </div>
        </div>
         column 4 title and content end 
    </div>-->
<div class="col-md-12">
    <hr><br>
    <div class="form-group">
        <div class="text-center">
            <input type="submit" class="btn btn-success" name="About_cms" id="updateFooterCMS" value="Update">
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

    function rem(id,img) {

    $('#prev_img' + id).attr('src', '<?= base_url() ?>backend/assets/img/cms/'+img);
     
        
  
    }


</script>