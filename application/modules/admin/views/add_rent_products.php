<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Add Rent Product</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <?=form_open_multipart('admin/ajaxAddRentProduct', array('class' => "m-bottom-30 add_product_form", 'id' => "wizard-arrow"))?>
            <ul class="list-steps">
                <li class="col-sm-4 step-item-arrow active">
                    <a href="#arrow-one" data-toggle="tab">
                      <i class="fa fa-lock bg-danger"></i>
                      <span>Product Information</span>
                    </a>
                </li>
                <li class="col-sm-4 step-item-arrow">
                    <a href="#arrow-two" data-toggle="tab">
                      <i class="fa fa-lock bg-danger"></i>
                      <span>Product Categories</span>
                    </a>
                </li>
                <li class="col-sm-4 step-item-arrow">
                    <a href="#arrow-three" data-toggle="tab">
                      <i class="fa fa-paypal bg-danger"></i>
                      <span>Product Images</span>
                    </a>
                </li>
            </ul>
            <div class="row">
                <div class="tab-content">
                    <div class="tab-pane active" id="arrow-one">
                        <div class="col-md-6 padding_div">
                            <div class="form-group">
                                <label for="inputName1" class="control-label ">Product Name</label>
                                <div class="">
                                    <?=form_input($product_name);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName1" class="control-label">Short Description</label>
                                <div class="">
                                    <?=form_input($product_shortdescription);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName1" class="control-label ">Description</label>
                                <div class="">
                                    <?=form_input($product_description);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label ">Quantity</label>
                                <div class="">
                                    <?=form_input($product_quantity);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputRent" class="control-label">Rent</label>
                                <div class="">
                                    <?=form_input($rent_per_month);?>
                                    <select class='form-control' name="select_plan">
                                        <option selected="">Select ...</option>
                                        <!-- <option value="3">Hourly</option> -->
                                        <option value="4">Daily</option>
                                        <option value="0">Weekly</option>
                                        <option value="1">Monthly</option>
                                        <option value="2">Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label">Product SKU</label>
                                <div class="">
                                    <?=form_input($product_sku);?>
                                </div>
                                <p id="sku_error"></p>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label">Security Deposite</label>
                                <div class="">
                                    <?=form_input($product_security_deposite);?>
                                </div>
                                <p id="sku_error"></p>
                            </div>
                        </div>
                        <div class="col-md-6 padding_div">
                            <div class="form-group">
                                <label for="inputEmail1" class="control-label">Product Brand</label>
                                <div class="product-brands">
                                    <?=form_dropdown(array('name' => 'product_brands', 'id' => 'product_brands', 'class' => 'form-control'), $product_brands);?>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label ">Additional Information</label>
                                <div class="">
                                    <textarea class="ckeditor form-control col-md-7 col-xs-12" required="required" id="productdescription" name="inputPostDescription" ></textarea>
                                </div>
                            </div>
                        </div>                                
                        <!-- /.form-group -->
                    </div>
                    <!-- /.tab-pane -->
                    
                    <div class="tab-pane" id="arrow-two">
                        <div class="col-md-6 padding_div">
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label ">Documents Required</label>
                                <div class="">
                                    <textarea class="ckeditor form-control col-md-7 col-xs-12" required="required" id="documents" name="documents" ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 padding_div">
                            <div class="form-group">
                                <div class="main-tab">
                                    <div class="main-tab-head">
                                        <span>Product Category</span>
                                    </div>
                                    <div class="main-tab-body">
                                        <?php foreach ($product_categories as $value) {?>
                                        <div class="form-check">
                                            <label class="form-check-label"><input type="checkbox" class="icheck-minimal-grey" id="<?=$value['id']?>" name="product_category[]" value="<?=$value['id']?>"><?=$value['name']?></label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="main-tab">
                                    <div class="main-tab-head">
                                        <span>Product Sub-Category</span>
                                    </div>
                                    <div class="main-tab-body">
                                        <?php foreach ($product_subcategories as $value) {?>
                                        <div class="form-check">
                                            <label class="form-check-label"><input type="checkbox" class="icheck-minimal-grey" id="<?=$value['id']?>" name="product_subcategory[]" value="<?=$value['id']?>"><?=$value['name']?></label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="main-tab">
                                    <div class="main-tab-head">
                                        <span>Select product type</span>
                                    </div>
                                    <div class="main-tab-body">
                                        <div class="form-check">
                                            <label class="form-check-label"><input type="radio" class="icheck-minimal-grey" name="product_type" value="0">Furbished</label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label"><input type="radio" class="icheck-minimal-grey" name="product_type" value="1">New</label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label"><input type="radio" class="icheck-minimal-grey" name="product_type" value="2">Used</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <div class="main-tab">
                                    <div class="main-tab-head">
                                        <span>Product Category (Level 3)</span>
                                    </div>
                                    <div class="main-tab-body">
                                        <div class="form-check">
                                            <label class="form-check-label"><input type="checkbox" class="icheck-minimal-grey">Level 3</label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div><!-- /.tab-pane -->

                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="arrow-three">
                    	<div class="col-md-offset-3 col-md-6">
                        	<div class="form-group">
                                <label for="inputUrl1" class="control-label">Product Video Id</label>
                                <?=form_input($product_video);?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3 text-center">
                                <label for="inputPassword1" class="control-label">Image 1</label><hr>
                                <img style="border: 1px solid #ccc;" class="img-reponsive" field="1" id="prev_img1" src="<?=base_url()?>frontend/assets/images/default_product.jpg"><hr>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-primary btn-file">
                                <span class="fileinput-new">Select Image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="product_images[]" class="product_images" onchange="readURL(this, '1');" id="file1">
                                </span>
                                <span class="fileinput-filename"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" onclick="removeURL('1')" style="float: none">&times;</a>
                                </div><!-- /.fileinput -->
                            </div>
                            <div class="col-sm-3 text-center">
                                <label for="inputPassword1" class="control-label">Image 2</label><hr>
                                <img style="border: 1px solid #ccc;" class="img-reponsive" field="2" id="prev_img2" src="<?=base_url()?>frontend/assets/images/default_product.jpg"><hr>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-success btn-file">
                                <span class="fileinput-new">Select Image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="product_images[]" class="product_images" onchange="readURL(this, '2');" id="file2">
                                </span>
                                <span class="fileinput-filename"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" onclick="removeURL('2')" style="float: none">&times;</a>
                                </div><!-- /.fileinput -->
                            </div>
                            <div class="col-sm-3 text-center">
                                <label for="inputPassword1" class="control-label">Image 3</label><hr>
                                <img style="border: 1px solid #ccc;" class="img-reponsive" field="3" id="prev_img3" src="<?=base_url()?>frontend/assets/images/default_product.jpg"><hr>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-danger btn-file">
                                <span class="fileinput-new">Select Image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="product_images[]" class="product_images" onchange="readURL(this, '3');" id="file3">
                                </span>
                                <span class="fileinput-filename"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" onclick="removeURL('3')" style="float: none">&times;</a>
                                </div><!-- /.fileinput -->
                            </div>
                            <div class="col-sm-3 text-center">
                                <label for="inputPassword1" class="control-label">Image 4</label><hr>
                                <img style="border: 1px solid #ccc;" class="img-reponsive" field="4" id="prev_img4" src="<?=base_url()?>frontend/assets/images/default_product.jpg"><hr>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-info btn-file">
                                <span class="fileinput-new">Select Image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="product_images[]" class="product_images" onchange="readURL(this, '4');" id="file4">
                                </span>
                                <span class="fileinput-filename"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" onclick="removeURL('4')" style="float: none">&times;</a>
                                </div><!-- /.fileinput -->
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.row -->
            <br><br><br>                    
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-block btn-warning-outline btn-prev">Previous Step</button>
                        </div>
                        <!-- /.col-sm-6 -->
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-block btn-info btn-next">Next Step</button>
                            <button type="submit" class="btn btn-block btn-success btn-finish none">Finish</button>
                        </div>
                        <!-- /.col-sm-6 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.col-sm-12 -->
            </div>
            <!-- /.row -->
        <?=form_close()?>
        <hr>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<script type="text/javascript">
    function checkSKU() {
        var product_sku_value = document.getElementById("product_sku").value;
        var base_url = $('#base_url').val();
        var flag = true;
        $('#sku_error').html('');
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/validateSKUNumber',
            dataType:'json',
            data: {'sku_number':product_sku_value},
            success: function (response) {
                if(response.status == '0') {

                    $('#sku_error').html('<p style="color:#eb0000">SKU number is already exists</p>');
                    $("#product_sku").css('border-color','#eb0000');
                    $('.btn-next').attr("disabled", "disabled");
                } else {
                    $('.btn-next').removeAttr("disabled");
                    $('#sku_error').html('');
                    $("#product_sku").css('border-color','#357a38');
                }
            }
        });
    }


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