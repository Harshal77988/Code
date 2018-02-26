<style>
    .error{
        color:red;
    }
</style>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Edit Blog</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- <div class="page-title-wrapper">
    <h2 class="page-title">Add Product</h2>
</div> -->
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <form  id="wizard-arrow" name="wizard-arrow"  class="form-horizontal m-bottom-30 add_product_form" novalidate action="<?php echo base_url() ?>admin/edit_blog/<?php echo $edit_id; ?>"  enctype="multipart/form-data"  method="POST">
           <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" id="edit_id" />
             <input type="hidden" id="old_inputName" name="old_inputName" value="<?php echo stripslashes($post_info[0]["post_title"]); ?>" />           
            <div class="row">
                <div class="tab-content">
                    <div class="tab-pane active" id="arrow-one">
                        <div class="col-md-6 padding_div">
                            <div class="form-group">
                                <label for="inputName1" class="control-label ">Title</label>
                                <div class="">
                                    <!-- <input type="text" class="form-control" id="inputName1" name="inputName1"> -->
                                   <input type="text" class="form-control col-md-7 col-xs-12" required="required" name="inputName" value="<?php echo stripslashes($post_info[0]["post_title"]); ?>"  id="name">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputName1" class="control-label"></label>
                                <div class="">
                                  <?php if ($post_info[0]["blog_image"] != '') { ?>
                                        <input type="hidden" name="old_img_file" id="old_img_file" value="<?php echo stripslashes($post_info[0]["blog_image"]); ?>">
                                        <br>
                                        <img width="100" height="100" src="<?php echo base_url(); ?>backend/uploads/blogs/395x250/<?php echo stripslashes($post_info[0]["blog_image"]); ?>" id="front_image_tag_id" title="image" > 
                                    <?php } ?>
                                   
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputName1" class="control-label">Image</label>
                                <div class="">
                                 <input class="form-control col-md-7 col-xs-12" id="img_file"  name="img_file" type="file" accept="image/*">
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName1" class="control-label ">Description</label>
                                <div class="">
                                    <!-- <input type="text" class="form-control" id="inputName1" name="inputName1"> -->
                                    <textarea class="ckeditor form-control col-md-7 col-xs-12" id="productdescription" name="inputPostDescription" ><?php echo stripslashes($post_info[0]['post_content']); ?></textarea>
                                    <div class="error hidden" id="labelProductError">Enter content length should be greater than 12. </div>
                                
                                </div>
                            </div>
                            <!-- /.form-group -->
                           
                           
                        </div>
                        <div class="col-md-6 padding_div">
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label ">Blog Category</label>
                                <div class="">
                                    <!-- <input type="password" class="form-control" id="inputPassword1" name="inputPassword1"> -->
                                  <select name="blog_category" required="required" class="form-control" autocomplete="off">
                                        <option value="">Select</option>
                                        <?php foreach($category as $category){?>
                                        <option <?php if ($post_info[0]["blog_category"] == $category['category_id']) echo 'selected="selected"';?> value="<?php echo $category['category_id']?>"><?php echo $category['category_name']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label">Status</label>
                                <div class="">
                                    <!-- <input type="password" class="form-control" id="inputPassword1" name="inputPassword1"> -->
                                <select required="required" name="blog_status" name="blog_status" class="form-control col-md-7 col-xs-12" autocomplete="off">
                                        <option value="">Select</option>
                                        <option <?php if ($post_info[0]["status"] == "1") echo 'selected="selected"'; ?> value="1">Published</option>
                                        <option <?php if ($post_info[0]["status"] == "0") echo 'selected="selected"'; ?> value="0">Unpublished</option>
                                </select>
                                </div>
                            </div>
                            
                           
                           
                        </div>                                
                        <!-- /.form-group -->
                    </div>
                    <!-- /.tab-pane -->
                    
                    <!-- /.tab-pane -->
                    
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.row -->
            <br><br><br>                    
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="row">
                        
                        <!-- /.col-sm-6 -->
                        <div class="col-sm-6">
                            <!--<button type="button" class="btn btn-block btn-info btn-next">Next Step</button>-->
                            <button id="btn_submit" name="btn_submit" type="submit" class="btn btn-block btn-success btn-finish none">Save</button>
                            <!-- <img style="display:none;" src="<?php echo base_url(); ?>backend/assets/img/loader.gif" name="loding_image" id="loding_image" /> -->
                        </div>
                        <!-- /.col-sm-6 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.col-sm-12 -->
            </div>
            <!-- /.row -->
        </form>
        <hr>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->


<script src="<?php echo base_url(); ?>backend/assets/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
     $("#wizard-arrow").validate({
        errorElement: "div",
        highlight: false,
        rules: {
            inputName: {
                required: true,
              remote:{
                    url: '<?php echo base_url(); ?>' + 'admin/chkBlogNameEdit',
                    method: 'post',
                    data: {old_inputName: $('#old_inputName').val()}
                }
            },
            img_file:{
                //required: true,
            },
             blog_category:{
                required: true,
            },
             blog_status:{
                required: true,
            },
            
            
        },
        messages: {
            inputName: {
                required: "Please enter title.",
        remote: "Title already available,please enter another one.",
                //lettersonly: "Please enter valid username."
            },
            img_file: {
                required: "Please select image.",
               // lettersonly: "Please enter valid password."
            },
            blog_category: {
                required: "Please select blog category.",
               // lettersonly: "Please enter valid password."
            },
            blog_status: {
                required: "Please select status.",
               // lettersonly: "Please enter valid password."
            },
            
        },
        submitHandler: function(form) {
            $("#btn_submit").hide();
            $('#loding_image').css('display','inline');
            form.submit();
        }
    });
   });
</script>