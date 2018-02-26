<style>
    .error{
        color:red;
    }
</style>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Add Blog</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <form id="wizard-arrow" name="wizard-arrow" class="form-horizontal m-bottom-30 add_product_form" novalidate action="<?=base_url()?>admin/add_blog" enctype="multipart/form-data"  method="POST">
            <div class="row">
                <div class="tab-content">
                    <div class="tab-pane active" id="arrow-one">
                        <div class="col-md-6 padding_div">
                            <div class="form-group">
                                <label for="inputName1" class="control-label ">Title</label>
                                <div class="">
                                    <!-- <input type="text" class="form-control" id="inputName1" name="inputName1"> -->
                                   <input type="text" class="form-control col-md-7 col-xs-12" name="inputName"  required="required"  id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName1" class="control-label">Image</label>
                                <div class="">
                                 <input class="form-control col-md-7 col-xs-12" id="img_file" required="required" name="img_file" type="file" accept="image/*">
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName1" class="control-label ">Description</label>
                                <div class="">
                                    <!-- <input type="text" class="form-control" id="inputName1" name="inputName1"> -->
                                   <textarea class="ckeditor form-control col-md-7 col-xs-12" required="required" data-validate-length-range="5,100" id="productdescription" name="inputPostDescription" ></textarea>
                                    <div class="error hidden" id="labelProductError">Enter content length should be greater than 12. </div>
                                
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6 padding_div">
                            <div class="form-group">
                                <label class="control-label ">Blog Category</label>
                                <select name="blog_category" required="required" class="form-control">
                                    <option value="">Select</option>
                                    <?php foreach($category as $category) { ?>
                                    <option value="<?php echo $category['category_id']?>"><?php echo $category['category_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label">Status</label>
                                <div class="">
                                    <!-- <input type="password" class="form-control" id="inputPassword1" name="inputPassword1"> -->
                                   <select name="blog_status" required="required" name="blog_status" class="form-control" autocomplete="off">
                                        <option value="">Select</option>
                                        <option value="1">Published</option>
                                        <option value="0">Unpublished</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label">Tags</label>
                                <div class="">
                                   <?=form_input(array('class' => 'form-control col-md-7 col-xs-12','name' => 'tags', 'required' => 'required', 'id' => 'tags', 'placeholder' => 'Enter the tags with comma separated values (ex. camera, phone)'))?>
                                </div>
                            </div>
                        </div>                                
                        <!-- /.form-group -->
                    </div>
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
                            <img style="display:none;" src="<?php echo base_url(); ?>backend/assets/img/loader.gif" name="loding_image" id="loding_image" />
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

<script type="text/javascript">
    function readURL(input, id)
    {
        var fileInput = document.getElementById('file' + id);
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        
        if (input.files && input.files[0]) {

            if(!allowedExtensions.exec(filePath)){
                // alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
                swal("File type extension is invalid !", "Allowed file types (.jpg, .png)");
                fileInput.value = '';
                return false;
            } else {

                var reader = new FileReader();
                reader.onload = function (e) {
                  // console.log(e.target.result);
                    $('#prev_img'+id)
                        .attr('src', e.target.result)
                        .width(217)
                        .height(243);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    function removeURL(id) {
        $('#prev_img'+id).attr('src', '<?=base_url()?>frontend/assets/images/default_product.jpg');
    }



    // function fileValidation() {

    //     var fileInput = document.getElementById('file');
    //     var filePath = fileInput.value;
    //     var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    //     if(!allowedExtensions.exec(filePath)){
    //         alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
    //         fileInput.value = '';
    //         return false;
    //     }else{
    //         //Image preview
    //         if (fileInput.files && fileInput.files[0]) {
    //             var reader = new FileReader();
    //             reader.onload = function(e) {
    //                 document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
    //             };
    //             reader.readAsDataURL(fileInput.files[0]);
    //         }
    //     }
    // }

// $(document).ready(function () {
//     $("#product_category").change(function () {

//         var product_category_id = $("select#product_category option:selected").val();

//         $.ajax({
//             type: "POST",
//             url: '<?php echo base_url(); ?>admin/get_attributes',
//             data: {'product_category_id': product_category_id},
//             success: function (data) {
//                 var parsed = $.parseJSON(data);
//                 $('#_div_attr_view').html('')
//                 $('#_div_attr_view').html(parsed.content);
//             }
//         });
//     });
// });
</script>

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
                    url: '<?php echo base_url(); ?>' + 'admin/chkBlogName',
                    method: 'post',
                    //data: {old_user_name: $('#old_user_name').val()}
                }
              // lettersonly: true,
            },
            img_file:{
                required: true,
            },
             blog_category:{
                required: true,
            },
             blog_status:{
                required: true,
            },
            tags:{
                required: true,
            },
            
        },
        messages: {
            inputName: {
                required: "Please enter title.",
                remote: "Title already available,please enter another one.",
            },
            img_file: {
                required: "Please select image.",
            },
            blog_category: {
                required: "Please select blog category.",
            },
            blog_status: {
                required: "Please select status.",
            },
            tags: {
                required: "Enter the value of tags",
            }
            
        },
        submitHandler: function(form) {
            $("#btn_submit").hide();
            $('#loding_image').css('display','inline');
            form.submit();
        }
    });
   }); 
    
   
</script>