<?php
    $flag = '0';
    $options = '';
?>
<?php if (isset($this->data['prodcut_cat_detail']) && !empty($this->data['prodcut_cat_detail'])) {?>
    <label for="attributes" class="control-label">Sub-category (Level 3)</label>
    <select class="form-control" id="id_select_sub_part3" name="id_select_sub_part3">
        <option>Select Sub Category </option>
        <?php foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) { ?>        
        <option id="<?=$attr_data['id']?>" value="<?=$attr_data['id']?>"><?=$attr_data['name']?></option>
    <?php } ?>
    </select>

<?php } ?>

<script>
    $("#id_select_sub_part3").change(function () {

        // var selected_cat = $('#category_level_2').val();

        var selected_id = $(this).find('option:selected').attr('id');
        var base_url = $('#base_url').val();
        // var product_category_id = $("select#product_category option:selected").val();
        var product_category_id = $(this).val();
        // console.log($(this).val());

        $.ajax({
            type: "POST",
            url: base_url + 'admin/getSubSubSubCategories',
            data: {'product_category_id': product_category_id},
            success: function (data) {
                var parsed = $.parseJSON(data);
                $('#_div_sub_attr_view4').html('')
                $('#_div_sub_attr_view4').html(parsed.content);
            }
        });
    });
</script>