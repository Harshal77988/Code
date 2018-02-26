<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Add Coupon</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- /.page-titile-wrapper -->
        <div class="col-sm-12">
            <?=form_open_multipart('admin_library/insert_discount/', array('id' => 'wizard-arrow', 'class' => 'form-horizontal  m-bottom-30 add_product_form', 'data-parsley-validate'));?>
                <div class="tab-content">
                    <div class="tab-pane active" id="arrow-one">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?=form_label(lang('coupon_type'), 'coupon_type', array('for' => 'coupon_type', 'class' => 'control-label')); ?>
                                <div class="">
                                   <?php echo form_dropdown(array(
                                        'id' => 'coupon_type',
                                        'name' => 'coupon_type',
                                        'class' => 'form-control',
                                        'placeholder' => 'Select coupon type'), $coupon_type
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?=form_label(lang('coupon_method'), 'coupon_method', array('for' => 'coupon_method', 'class' => 'control-label')); ?>
                                <div class="">
                                    <?php
                                        echo form_dropdown(array(
                                            'id' => 'coupon_method',
                                            'name' => 'coupon_method',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Select Coupon Method'
                                                ), $coupon_method
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <!-- <label for="inputName1" class="control-label ">Coupon Type</label> -->
                                <?=form_label(lang('tax_method'), 'tax_method', array('for' => 'tax_method', 'class' => 'control-label')); ?>
                                <div class="">
                                    <?php
                                        echo form_dropdown(array(
                                            'id' => 'tax_method',
                                            'name' => 'tax_method',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Select Coupon Method'
                                                ), $coupon_method_tax
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?=form_label(lang('coupon_code'), 'coupon_code', array('for' => 'coupon_code', 'class' => 'control-label')); ?>
                                <div class="">
                                   <?php echo form_input(array(
                                        'type' => 'coupon_code',
                                        'id' => 'coupon_code',
                                        'name' => 'coupon_code',
                                        'placeholder' => 'Coupon Code',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'min' => '0',
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?=form_label(lang('coupon_desc'), 'coupon_desc', array('for' => 'coupon_desc', 'class' => 'control-label')); ?>
                                <div class="">
                                   <?php echo form_textarea(array(
                                        'id' => 'coupon_desc',
                                        'name' => 'coupon_desc',
                                        'placeholder' => 'Description',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?=form_label(lang('quantity'), 'quantity', array('for' => 'quantity', 'class' => 'control-label')); ?>
                                <div class="">
                                   <?php echo form_input(array(
                                        'id' => 'quantity',
                                        'name' => 'quantity',
                                        'placeholder' => 'Quantity',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?=form_label(lang('coupon_quantity'), 'coupon_quantity', array('for' => 'coupon_quantitycoupon_quantity', 'class' => 'control-label')); ?>
                                <div class="">
                                   <?php echo form_input(array(
                                        'id' => 'coupon_quantity',
                                        'name' => 'coupon_quantity',
                                        'placeholder' => 'coupon_quantity',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?=form_label(lang('coupon_value_a'), 'coupon_value_a', array('for' => 'coupon_quantity', 'class' => 'control-label')); ?>
                                <div class="">
                                   <?php echo form_input(array(
                                        'id' => 'coupon_value_a',
                                        'name' => 'coupon_quantity_a',
                                        'placeholder' => 'Value Required to Activate',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?=form_label(lang('coupon_value'), 'coupon_value', array('for' => 'coupon_value', 'class' => 'control-label')); ?>
                                <div class="">
                                   <?php echo form_input(array(
                                        'id' => 'coupon_value',
                                        'name' => 'coupon_value',
                                        'placeholder' => 'coupon value',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ));
                                    ?>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <?=form_label(lang('custom_status'), 'custom_status', array('for' => 'coupon_value', 'class' => 'control-label')); ?>
                                <div class="">
                                    <?php
                                    echo form_input(array(
                                        'id' => 'custom_status',
                                        'name' => 'custom_status',
                                        'placeholder' => 'Status',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ));
                                    ?>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <?=form_label(lang('uses_limit'), 'uses_limit', array('for' => 'uses_limit', 'class' => 'control-label')); ?>
                                <div class="">
                                   <?php echo form_input(array(
                                        'id' => 'uses_limit',
                                        'name' => 'uses_limit',
                                        'placeholder' => 'Uses Limit',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?=form_label(lang('start_d'), 'start_d', array('for' => 'start_d', 'class' => 'control-label')); ?>
                                <div class="">
                                    <?=form_input(array("type" => "date", "min" => date("Y-m-d"), "name" => "from_date", "class" => "form-control", "value" => $effectiveDate = date("Y-m-d")))?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?=form_label(lang('end_d'), 'end_d', array('for' => 'end_d', 'class' => 'control-label')); ?>
                                <div class="">
                                    <?=form_input(array("type" => "date", "min" => date("Y-m-d"), "name" => "to_date", "class" => "form-control", "value" => date('Y-m-d', strtotime("+3 months", strtotime($effectiveDate)))))?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?=form_label(lang('a_status'), 'a_status', array('for' => 'a_status', 'class' => 'control-label')); ?>
                                <div class="">
                                    <input type="checkbox" name="isactive" id="isactive" value="0"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tab-content -->
                <div class="col-md-offset-3 col-md-6">
                    <div class="row">                            
                        <!-- /.col-sm-6 -->
                        <div class="col-md-offset-3 col-sm-6">
                            <button id="btn_submit" name="btn_submit" type="submit" class="btn btn-block btn-success btn-finish none">Save</button>
                        </div>
                        <!-- /.col-sm-6 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.col-sm-12 -->
            </form>
    <!-- /.col-sm-12 -->
</div>
<!-- /.row -->