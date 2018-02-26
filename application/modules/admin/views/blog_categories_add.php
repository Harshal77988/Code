<style>
    .error{
        color:red;
    }
</style>
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Add Blog Categories</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- <div class="page-title-wrapper">
    <h2 class="page-title">Add Product</h2>
</div> -->
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <form  id="wizard-arrow" name="wizard-arrow"  class="form-horizontal m-bottom-30 add_product_form" novalidate action="<?php echo base_url() ?>admin/add_blog_categories"  enctype="multipart/form-data"  method="POST">
            <div class="row">
                <div class="tab-content">
                    <div class="tab-pane active" id="arrow-one">
                        <div class="col-md-6 padding_div">
                            <div class="form-group">
                                <label for="inputName1" class="control-label ">Category Name</label>
                                <div class="">
                                    <!-- <input type="text" class="form-control" id="inputName1" name="inputName1"> -->
                                   <input type="text" class="form-control"   name="category_name" id="category_name" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName1" class="control-label">Category Title</label>
                                <div class="">
                                    <!-- <input type="text" class="form-control" id="inputName1" name="inputName1"> -->
                                    <input type="text" class="form-control" name="category_title" id="category_title" value="" />
                                   
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label">Status</label>
                                <div class="">
                                    <!-- <input type="password" class="form-control" id="inputPassword1" name="inputPassword1"> -->
                                   <select name="status" required="required" name="status" class="form-control" autocomplete="off">
                                        <option value="">Select</option>
                                        <option value="1">Published</option>
                                        <option value="0">Unpublished</option>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="inputName1" class="control-label"></label>
                                <div class="" style="width:40%">
                                    <!-- <input type="text" class="form-control" id="inputName1" name="inputName1"> -->
                                   <button type="submit" id="btn_submit" name="btn_submit" class="btn btn-block btn-success btn-finish none">Save</button> 
                                   <img style="display:none;" src="<?php echo base_url(); ?>backend/assets/img/loader.gif" name="loding_image" id="loding_image" />
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
     $("#wizard-arrow").validate({
        errorElement: "div",
        highlight: false,
        rules: {
            category_name: {
                required: true,
                    minlength:5,
                maxlength:50,
                 remote:{
                    url: '<?php echo base_url(); ?>' + 'admin/chkBlogCategoryName',
                    method: 'post',
                    //data: {old_user_name: $('#old_user_name').val()}
                }
              // lettersonly: true,
            },
            category_title:{
                required: true,
                    minlength:5,
                maxlength:50,
            },
            status:{
                required: true,
            },
            
            
        },
        messages: {
            category_name: {
                required: "Please enter category name.",
               remote : "Blog category already available,please enter another one.",
                //lettersonly: "Please enter valid username."
            },
             	category_title: {
                required: "Please enter category title.",
               
               // lettersonly: "Please enter valid password."
            },
            status:{
                required: "Please select status",
            },
            
        },
        submitHandler: function(form) {
            $("#btn_submit").hide();
            
            form.submit();
        }
    });
   }); 
    
   
</script>

