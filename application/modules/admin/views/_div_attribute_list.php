<?php
    $flag = '0';
    $options = '';
?>
<?php if (isset($this->data['prodcut_cat_detail'])) {?>
    <?php foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) {?>
        <div for="category_description" class="col-sm-4">
            <?=$attr_data['sub_name']?>                                
        </div>
        <div class="col-sm-8">
            <input type="hidden" name="sub_attribute_id[]" value="<?=$attr_data['id']?>">
            <?=form_input(array('class' => "form-control", 'id' => "tags", 'name' => "tags[]", 'maxlength' => '50', 'minlength' => '2', 'required' => 'required', 'placeholder' => $attr_data['sub_name'].' value'))?>
        </div>
        <!-- <div class="form-group">
            <label><?=$attr_data['sub_name']?></label>
            <?php echo form_input(array(
                'type' => 'text',
                'id' => 'id_tags_' . $attr_data['id'],
                'name' => 'attr_input_' . $attr_data['attribute_id'] . '_' . $attr_data['id'],
                'placeholder' => $attr_data['sub_name'],
                'required' => 'required',
                'class' => 'tags form-control'
            )); ?>
        </div> -->
    <?php }
} ?>