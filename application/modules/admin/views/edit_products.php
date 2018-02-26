<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Edit Product</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- <div class="page-title-wrapper">
    <h2 class="page-title">Add Product</h2>
</div> -->
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <?=form_open_multipart('admin/ajaxUpdateProduct', array('class' => "m-bottom-30 update_product_form", 'id' => "wizard-arrow"))?>
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
                            <input type="hidden" name="product_id" value="<?=$product_details[0]['product_id']?>">
                            <div class="form-group">
                                <label for="inputName1" class="control-label ">Product Name</label>
                                <div class="">
                                    <?=form_input(array('class' => 'form-control','id' => 'product_name','name' => 'product_name','type' => 'text','placeholder' => 'Product name','value' => $product_details[0]['product_name']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName1" class="control-label">Short Description</label>
                                <div class="">
                                    <?=form_input(array('class' => 'form-control','id' => 'short_description','name' => 'short_description','type' => 'text','placeholder' => 'Enter the Short description','value' => (!empty($product_details[0]['short_description']) ? $product_details[0]['short_description'] : '')));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName1" class="control-label ">Description</label>
                                <div class="">
                                    <?=form_input(array('class' => 'form-control','id' => 'description','name' => 'description','type' => 'text','placeholder' => 'Description','value' => $product_details[0]['description']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label ">Quantity</label>
                                <div class="">
                                    <?=form_input(array('class' => 'form-control', 'id' => 'product_quantity', 'name' => 'product_quantity', 'type' => 'text', 'placeholder' => 'Product Quantity', 'value' => $product_details[0]['quantity']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label">Price</label>
                                <div class="">
                                    <?=form_input(array('class' => 'form-control', 'id' => 'product_price', 'name' => 'product_price', 'type' => 'text', 'placeholder' => 'Product price', 'value' => $product_details[0]['price']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label">Discounted Price</label>
                                <div class="">
                                    <?=form_input(array('class' => 'form-control','id' => 'product_discounted_price','name' => 'product_discounted_price','type' => 'text','placeholder' => 'Discounted Product price','value' => $product_details[0]['discounted_price']));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label">Product SKU</label>
                                <div class="">
                                    <?=form_input(array('class' => 'form-control','id' => 'product_sku','name' => 'product_sku', 'onkeyup' => 'checkSKU(\''.$product_details[0]['product_sku'].'\')', 'type' => 'text','placeholder' => 'Product SKU','value' => $product_details[0]['product_sku']));?>
                                </div>
                                <p id="sku_error"></p>
                            </div>
                            <!-- /.form-group -->                           
                        </div>
                        <div class="col-md-6 padding_div">                            
                            <div class="form-group">
                                <div class="">
                                    <label for="terms1" class="control-label">Is Feature</label>&nbsp;
                                    <input type="checkbox" class="icheck-minimal-grey" id="is_feature" name="is_feature" <?=($product_details[0]['product_is_feature'] == '1' ? 'checked' : '')?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="control-label">Product Brand</label>
                                <div class="product-brands">
                                    <?=form_dropdown(array('name' => 'product_brands', 'id' => 'product_brands', 'class' => 'form-control'), $product_brands, $product_details[0]['brand']);?>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="inputPassword1" class="control-label ">Additional Information</label>
                                <div class="">
                                    <textarea class="ckeditor form-control col-md-7 col-xs-12" required="required" id="productdescription" name="inputPostDescription"><?=($product_details[0]['additional_information'] ? $product_details[0]['additional_information']: '')?></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="arrow-two">
                        <div class="col-md-offset-3 col-md-6 padding_div">
                            <!-- /.form-group -->
                            <?php if(!empty($product_category_0)) {?>
                            <div class="form-group">
                                <label for="inputEmail1" class="control-label">Product Category (Level 1)</label>
                                <div class="product-cat">
                                    <!-- <input type="email" class="form-control" id="inputEmail1" name="inputEmail1"> -->
                                    <?=form_dropdown(array('name' => 'product_category', 'id' => 'product_category', 'class' => 'form-control'), $product_category_0);?>

                                    <!-- <?=form_multiselect(array('name' => 'product_category', 'id' => 'product_category', 'class' => 'form-control'), $product_category);?> -->
                                </div>
                            </div>
                            <?php } ?>
                            <?php if(!empty($product_category_1)) {?>
                            <div class="form-group">
                                <div id="_div_attr_view">
                                    <label for="inputEmail1" class="control-label">Product Category (Level 2)</label>
                                    <div class="product-cat">
                                    	<?=form_dropdown(array('name' => 'id_select_sub_part2', 'id' => 'id_select_sub_part2', 'class' => 'form-control'), $product_category_1);?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if(!empty($product_category_2)) {?>
                            <div class="form-group">
                                <div id="_div_sub_attr_view">
                                    <label for="inputEmail1" class="control-label">Product Category (Level 3)</label>
                                    <div class="product-cat">
                                    	<?=form_dropdown(array('name' => 'id_select_sub_part3', 'id' => 'id_select_sub_part3', 'class' => 'form-control'), $product_category_2);?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if(!empty($product_category_3)) {?>
                            <div class="form-group">
                                <div id="_div_sub_attr_view4">
                                    <label for="inputEmail1" class="control-label">Product Category (Level 4)</label>
                                    <div class="product-cat">
                                    	<?=form_dropdown(array('name' => 'id_select_sub_part4', 'id' => 'id_select_sub_part4', 'class' => 'form-control'), $product_category_3);?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="inputEmail1" class="control-label">Product Attributes</label>
                                <div class="product-cat">
                                    <?=form_dropdown(array('name' => 'product_attribute', 'id' => 'product_attribute', 'class' => 'form-control'), $attt_category, (!empty($product_attr_details[0]['attribute_id']) ? $product_attr_details[0]['attribute_id'] : ''));?>
                                    <!-- <input type="hidden" name="product_attribute" value="<?=$product_attr_details[0]['attribute_id']?>"> -->
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="inputEmail1" class="control-label">Product Attributes</label>
                                <input type="hidden" name="product_attribute" value="<?=$product_attr_details[0]['attribute_id']?>">
                            </div> -->
                            <div class="form-group">
                                <div id="_div_attr_details">
                                    <?php if (isset($product_attr_details)) {?>
                                    <?php foreach ($product_attr_details as $key => $attr_data) {?>
                                    <div for="category_description" class="col-sm-4">
                                        <?=$attr_data['attribute_value']?>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="sub_attribute_id[]" value="<?=$attr_data['id']?>">
                                        <?=form_input(array('class' => "form-control", 'id' => "tags", 'name' => "tags[]", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => $attr_data['sub_attribute_value'], 'value' => $attr_data['sub_attribute_value']))?>
                                    </div>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="_div_attr_details">

                                </div>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->
                    
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="arrow-three">
                        <div class="col-md-offset-3 col-md-6">
                            <div class="form-group">
                                <label for="inputUrl1" class="control-label">Product Video Id</label>
                                <?=form_input(array('class' => "form-control", 'id' => "product_video", 'name' => "product_video", 'placeholder' => 'Ex. Id : xxxxxxxxxxx', 'value' => (!empty($product_details[0]['product_video']) ? $product_details[0]['product_video'] : '')))?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <?php $image_preview = (array)(json_decode($product_details[0]['image_url']));?>
                            <div class="col-md-3 text-center">
                                <label for="inputPassword1" class="control-label">Preview 1</label><hr>
                                <?php if (!empty($image_preview[0])) {
                                    $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_preview[0]);
                                    echo stripos($headers[0],"200 OK") ? '<img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="1" id="prev_img1" src="'.base_url().'frontend/assets/images/products/'.$image_preview[0].'"><hr>' : '<img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="1" id="prev_img1" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                                <hr>
                                <?php } else {?>
                                <img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="1" id="prev_img1" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                <hr>
                                <?php } ?>
                                <input type="hidden" name="replace_img1" id="replace_img1">
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
                                <label for="inputPassword1" class="control-label">Preview 2</label><hr>
                                <?php if (!empty($image_preview[1])) {
                                    $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_preview[1]);
                                    echo stripos($headers[0],"200 OK") ? '<img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="2" id="prev_img2" src="'.base_url().'frontend/assets/images/products/'.$image_preview[1].'"><hr>' : '<img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="2" id="prev_img2" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                                <hr>
                                <?php } else {?>
                                <img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="2" id="prev_img2" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                <hr>
                                <?php } ?>
                                <input type="hidden" name="replace_img2" id="replace_img2">
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
                                <label for="inputPassword1" class="control-label">Preview 3</label><hr>
                                <?php if (!empty($image_preview[2])) {
                                    $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_preview[2]);
                                    echo stripos($headers[0],"200 OK") ? '<img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="3" id="prev_img3" src="'.base_url().'frontend/assets/images/products/'.$image_preview[2].'"><hr>' : '<img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="3" id="prev_img3" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                                <hr>
                                <?php } else {?>
                                <img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="3" id="prev_img3" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                <hr>
                                <?php } ?>

                                <input type="hidden" name="replace_img3" id="replace_img3">
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
                                <label for="inputPassword1" class="control-label">Preview 4</label><hr>
                                <?php if (!empty($image_preview[3])) {
                                    $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_preview[3]);
                                    echo stripos($headers[0],"200 OK") ? '<img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="4" id="prev_img4" src="'.base_url().'frontend/assets/images/products/'.$image_preview[3].'">' : '<img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="4" id="prev_img4" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                                <hr>
                                <?php } else {?>
                                <img style="border: 1px solid #ccc;width:100%;" class="img-reponsive" field="4" id="prev_img4" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                <hr>
                                <?php } ?>
                                <input type="hidden" name="replace_img4" id="replace_img4">
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
        <?=form_close()?><hr>
    </div>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<script type="text/javascript">

    function checkSKU(current_sku) {

        var product_sku_value = document.getElementById("product_sku").value;

        if(product_sku_value !== current_sku) {

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

        return false;
    }

    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
              console.log(e.target.result);
                $('#prev_img'+id)
                    .attr('src', e.target.result)
                    .width(217)
                    .height(230);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeURL(id) {
        $('#prev_img' + id).attr('src', $('#replace_img' + id).val());
    }
</script>