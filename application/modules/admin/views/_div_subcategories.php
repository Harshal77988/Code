<?php
    $flag = '0';
    $options = '';
?>
<?php if (isset($this->data['prodcut_cat_detail']) && !empty($this->data['prodcut_cat_detail'])) {?>
    
    <div id="cat_level_2">
        <label for="attributes" class="control-label">Sub-category (Level 2)</label>
        <select class="form-control" id="id_select_sub_part2" name="id_select_sub_part2">
            <option>Select Sub Category </option>
            <?php foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) { ?>        
            <option id="<?=$attr_data['id']?>" value="<?=$attr_data['id']?>"><?=$attr_data['name']?></option>
        <?php } ?>
        </select>
    </div>
<?php } ?>

<script>
    $("#id_select_sub_part2").change(function () {

        // var selected_cat = $('#category_level_2').val();

        var selected_id = $(this).find('option:selected').attr('id');
        var base_url = $('#base_url').val();
        // var product_category_id = $("select#product_category option:selected").val();
        var product_category_id = $(this).val();
        // console.log($(this).val());

        $.ajax({
            type: "POST",
            url: base_url + 'admin/getSubSubCategories',
            data: {'product_category_id': product_category_id},
            success: function (data) {
                var parsed = $.parseJSON(data);
                $('#_div_sub_attr_view').html('')
                $('#_div_sub_attr_view').html(parsed.content);
            }
        });
    });

    // $(document).ready(function () {
    //     $("#id_select_sub_part").change(function () {

    //         var selected_id = $(this).find('option:selected').attr('id');
    //         // alert(selected_id);
    //         // $('.test').hide();
    //         // $('#div_lbl').remove();
    //         // $(["input:hidden, textarea:hidden, select:hidden"]).attr("disabled", true);
    //         // $('#show_id_' + selected_id).show();
    //         // var id = '#show_id_' + selected_id;

    //         // $(".test input").attr("disabled", "true");
    //         // $(".test input").removeAttr("required");
    //         // $(id + " input").attr("required", "true");
    //         // $(id + " input").removeAttr("disabled");

    //     });
    // });
</script>