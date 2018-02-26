<?php
    $flag = '0';
    $options = '';
?>
<?php if (isset($this->data['prodcut_cat_detail']) && !empty($this->data['prodcut_cat_detail'])) {?>    
    <div id="cat_level_5">
        <label for="attributes" class="control-label">Sub-category (Level 4)</label>
        <select class="form-control" id="id_select_sub_part5" name="id_select_sub_part5">
            <option>Select Sub Category </option>
            <?php foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) { ?>        
            <option id="<?=$attr_data['id']?>" value="<?=$attr_data['id']?>"><?=$attr_data['name']?></option>
        <?php } ?>
        </select>
    </div>
<?php } ?>