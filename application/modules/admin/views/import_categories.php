<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Import Categories</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Import Categories</h2>
    <!-- <a class="btn btn-danger pull-right rippler" data-toggle="modal" data-target="#add_buy_product">Add Category</a> -->
</div>
<?php $msg = $this->session->flashdata('msg');
if ($msg != '') {
    ?>
    <script>
        $(document).ready(function () {
            new PNotify({
                title: 'Success',
                text: '<?php echo $msg; ?>',
                type: 'success',
                styling: 'bootstrap3',
                nonblock: {
                    nonblock: false
                }
            });
        });
    </script>
<?php } ?>
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-4 col-md-offset-4" style="border: 1px solid #ccc;padding: 20px">
            <?=form_open_multipart('admin/importCategoriesCSV', array('class' => "form-verticle m-bottom-30 add_product_form", 'onsubmit' => 'return checkFormValid()'))?>
                <div class="form-group">
                    <label for="inputName1">Select the the file</label>
                </div><br>
                <div class="form-group">
                    <label for="inputName1">Select the zip file for category images</label>
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
                <div class="form-group">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn btn-danger btn-file">
                            <span class="fileinput-new">Select file</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="import_product_file" id="browse_product" onchange="fileValidation()">
                        </span>
                        <span class="fileinput-filename"></span>
                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                    </div>
                </div>
                <div style="text-align: center;">
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
    function fileValidation() {

        var fileInput = document.getElementById('browse_product');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.csv)$/i;
        
        if (fileInput.files && fileInput.files[0]) {
            if(!allowedExtensions.exec(filePath)) {
                swal("File type extension is invalid !", "Select the CSV file for upload");
                fileInput.value = '';
                return false;
            }
        }
    }


    // check the form validation
    function checkFormValid() {

        if (document.getElementById('browse_product').value == "") {
            swal("Browse the CSV file");
            return false;
        } else {
            return true;
        }

        return false;
    }
</script>