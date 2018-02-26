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
        <li class="active">Landing Page CMS</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- /.page-titile-wrapper -->
<?=form_open_multipart('admin/update_landing_page_cms', array('class' => "form-horizontal m-bottom-30 add_product_form", 'id' => "wizard-arrow"))?>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Header Banner image <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="file" class="" name="headerBanner" id="headerBanner" accept="image/*" onchange="readURL1(this, 'siteLogoImg');">
            <br>
            <img id="siteLogoImg" src="<?php
            if (!empty($site_settings['header_banner'])) {
                echo base_url() .'/backend/assets/img/'. $site_settings['header_banner'];
            } else {
                echo '#';
            }
            ?>" alt="" height="150" width="100%"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Footer Banner Image<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="file" class="" name="footerBanner" id="footerBanner" accept="image/*" onchange="readURL1(this, 'loginPageLogoImg');">
            <br>
            <img id="loginPageLogoImg" src="<?php
            if (!empty($site_settings['footer_banner'])) {
                echo base_url() .'/backend/assets/img/'. $site_settings['footer_banner'];
            } else {
                echo '#';
            }
         ?>" alt="" height="150" width="100%" />
        </div>
        
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Landing page slider images<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php  $ls_count = 1;
                foreach($login_slider as $l_slider) {?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Slider <?php echo $ls_count; ?></strong>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 m-bottom-15">                                                
                        Lablel1 : <input type="text" class="form-control" name="label1_<?php echo $l_slider['field_key']; ?>" id="label1_<?php echo $l_slider['field_key']; ?>" value="<?php echo $l_slider['label1']; ?>">
                            </div>
                            <div class="col-md-6 m-bottom-15">
                                Lablel2 : <input type="text" class="form-control" name="label2_<?php echo $l_slider['field_key']; ?>" id="label2_<?php echo $l_slider['field_key']; ?>" value="<?php echo $l_slider['label2']; ?>">
                            </div>
                            <div class="col-md-6 m-bottom-15">
                                Lablel3 : <input type="text" class="form-control" name="label3_<?php echo $l_slider['field_key']; ?>" id="label3_<?php echo $l_slider['field_key']; ?>" value="<?php echo $l_slider['label3']; ?>">
                            </div>
                            <div class="col-md-6 m-bottom-15">
                                Lablel4 : <input type="text" class="form-control" name="label4_<?php echo $l_slider['field_key']; ?>" id="label4_<?php echo $l_slider['field_key']; ?>" value="<?php echo $l_slider['label4']; ?>">
                            </div>
                            <div class="col-md-12 m-bottom-15">
                                product Link  : <input type="text" class="form-control" name="link_<?php echo $l_slider['field_key']; ?>" id="link_<?php echo $l_slider['field_key']; ?>" value="<?php echo $l_slider['link']; ?>">
                            </div>
                        </div>
                       <input type="file" class="" name="<?php echo $l_slider['field_key']; ?>" id="<?php echo $l_slider['field_key']; ?>" accept="image/*" onchange="readURL1(this, '<?php echo $l_slider['field_key']; ?>Img');">
                       <br>
                       <img id="<?php echo $l_slider['field_key']; ?>Img" src="<?php
                       if (!empty($l_slider['field_output_value'])) {
                        echo base_url() .'/backend/assets/img/'. $l_slider['field_output_value'];
                    } else {
                        echo '#';
                    }
                    ?>" alt="" width='100%' height='120' />
                    <br><br>
                </div>
            </div>
            <?php $ls_count++; } ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <input type="button" class="btn btn-success" name="updateSiteSettings" id="updateSiteSettings" value="Update" onclick="lp_cms_validation()">
        </div>
    </div>
<?=form_close()?>
    
<script type="text/javascript">
    function readURL1(input, id)
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