<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Import Brands</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Import Brands</h2>
    <!-- <a class="btn btn-danger pull-right rippler" data-toggle="modal" data-target="#add_buy_product">Add Category</a> -->
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-4 col-md-offset-4" style="border: 1px solid #ccc;padding: 20px">
            <?=form_open_multipart('admin/importBrandsCSV', array('class' => "form-verticle m-bottom-30 add_brand_form", 'onsubmit' => 'return checkBrandFormValid()'))?>
                <div class="form-group">
                    <label for="inputName1">Select the CSV file for brands</label>
                </div><br>
                <div class="form-group" style="text-align: center;">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn btn-danger btn-file">
                            <span class="fileinput-new">Select file</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="import_brand_file" id="browse_brand" onchange="fileBrandValidation()">
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