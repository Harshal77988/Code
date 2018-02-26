<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Import Products</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Import Products</h2>
    <!-- <a class="btn btn-danger pull-right rippler" data-toggle="modal" data-target="#add_buy_product">Add Category</a> -->
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-4 col-md-offset-4" style="border: 1px solid #ccc;padding: 20px">
            <?=form_open_multipart('admin/importProductCSV', array('class' => "form-verticle m-bottom-30 add_product_form", 'onsubmit' => 'return checkProductFormValid()'))?>
                <div class="form-group">
                    <label for="inputName1">Select the category</label>
                    <?=form_dropdown(array(
                            'id' => 'product_category',
                            'name' => 'category_name',
                            'class' => 'form-control'
                            ), $product_category
                        );
                    ?>
                </div>
                <div class="form-group">
                    <div id="_div_attr_view">

                    </div>
                </div>

                <div class="form-group">
                    <div id="_div_sub_attr_view">

                    </div>
                </div>

                <div class="form-group">
                    <div id="_div_sub_attr_view2">

                    </div>
                </div>
                <div class="form-group">
                    <div id="_div_sub_attr_view4">

                    </div>
                </div>
                <div class="form-group">
                    <div id="_div_sub_attr_view5">

                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label for="inputName1">Select the CSV file for products</label><br>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-danger btn-file">
                                <span class="fileinput-new">Select CSV file</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="import_product_file" id="browse_product" onchange="fileProductValidation()">
                            </span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputName1">Select the zip file for product images</label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-danger btn-file">
                                <span class="fileinput-new">Select Zip file</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="zip_file" id="browse_product_images" onchange="imageZipValidation()">
                            </span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                        </div>
                    </div>
                    <!-- /.form-layout-body -->
                    <div class="form-layout-footer" id="hide_butn">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload File</button>
                            <!-- <button type="button" class="btn btn-default rippler">Cancel</button> -->
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.form-layout-footer -->
            </form>
        </div>
    </div>
    <!-- /.form-layout -->
</div>

<script type="text/javascript">
    // function fileValidation() {

    //     var fileInput = document.getElementById('browse_product');
    //     var filePath = fileInput.value;
    //     var allowedExtensions = /(\.csv)$/i;
        
    //     if (fileInput.files && fileInput.files[0]) {
    //         if(!allowedExtensions.exec(filePath)) {
    //             swal("File type extension is invalid !", "Select the CSV file for upload");
    //             fileInput.value = '';
    //             return false;
    //         }
    //     }
    // }


    // function imageZipValidation() {

    //     var fileInput = document.getElementById('browse_product_images');
    //     var filePath = fileInput.value;
    //     var allowedExtensions = /(\.zip)$/i;
        
    //     if (fileInput.files && fileInput.files[0]) {
    //         if(!allowedExtensions.exec(filePath)) {
    //             swal("File type extension is invalid !", "Select the Zip file of product images");
    //             fileInput.value = '';
    //             return false;
    //         }
    //     }
    // }


    // // check the form validation
    // function checkFormValid() {

    //     if (document.getElementById('product_category').value == "") {
    //         swal("Select the category");
    //         return false;
    //     } else if (document.getElementById('browse_product').value == "") {
    //         swal("Browse the CSV file");
    //         return false;
    //     } else if(document.getElementById('browse_product_images').value == "") {
    //       swal("Browse the zip file of product images");
    //         return false;
    //     } else {
    //         return true;
    //     }

    //     return false;
    // }
</script>