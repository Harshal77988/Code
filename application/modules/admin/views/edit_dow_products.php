<style>
.select2-container.select2-container--bootstrap.select2-container--open{
    z-index: 99999999; 
}
.select2.select2-container{
    width: 100% !important;
}

</style>
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Edit Deals of the week Product</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->

<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-action">
                        <button class="btn btn-close rippler"></button>
                        <button class="btn btn-min rippler"></button>
                        <button class="btn btn-expand rippler"></button>
                    </div>
                    <!-- <div class="panel-title">Basic Form</div> -->
                </div>
                <!-- /.panel-heading -->
                <!-- <form class="form-horizontal" novalidate="novalidate" id="edit_buy_attribute_form"> -->
                 <?=form_open_multipart('admin/updatedowProduct', array('class' => "m-bottom-30 add_product_form", 'id' => "wizard-arrow"))?>
                 <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php 
                                // echo "<pre>"; print_r($dow_product_details); die();
                            foreach ($dow_product_details as $value) {?>
                            <input type="hidden" name="dow_product_id" value="<?=$value['id']?>" id="<?=$value['id']?>">
                            <div class="form-group">
                                <label for="sale_type">Product Name *</label>
                                <input type="text" class="form-control" placeholder="Sale Type" name="sale_type" id="sale_type" value="<?=$value['product_name']?>" disabled>
                            </div>

                            <div class="form-group">
                                <label for="product_title" class="control-label">Start Date Time *</label>
                                 <input type="text" class="form-control" size="16" readonly name="start_date_time" id="start_date_time" value="<?=$value['start_date_time']?>">
                            </div>

                            <div class="form-group">
                                <label for="product_title" class="control-label">End Date Time *</label>
                                 <input type="text" class="form-control" size="16" readonly name="end_date_time" id="end_date_time" value="<?=$value['end_date_time']?>">
                            </div>

                            <?php } ?>
                            <div class="form-group" style="text-align: right;">
                                <button type="submit" class="btn btn-primary" id="edit_buy_attribute_btn">Update Details</button>
                                <a href="<?=base_url()?>admin/dow_products"><button type="button" class="btn btn-danger rippler">Cancel</button></a>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-body -->
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<!-- modal for add category of buy section end -->


<script type="text/javascript">
    function readURL(input, id)
    {
        var fileInput = document.getElementById('highlight_product_image');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

        if (input.files && input.files[0]) {

            if(!allowedExtensions.exec(filePath)){
                swal("File type extension is invalid !", "Allowed file types (.jpg, .png)");
                fileInput.value = '';
                return false;
            } else {

                var reader = new FileReader();
                reader.onload = function (e) {
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
</script>