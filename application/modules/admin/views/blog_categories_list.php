<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Blog Categories List</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Blog Categories List</h2>
    <a href="<?=base_url('admin/add_blog_categories')?>" type="button" class="btn btn-danger pull-right rippler">Add Blog Category</a> 
    
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <form autocomplete="off">
            <div class="">
                <table class="table table-bordered" id="datatable-checkbox">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Category Title</th>                          
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($cat_data) && !empty($cat_data)) {
                            $count = 1;                        
                            foreach ($cat_data as $value) {?>
                      <tr id="id_delete_<?=$value['category_id']?>">
                         <td><?=$value['category_name']?></td>
                          <td><?=$value['category_title']?></td>
                           <td><!-- <a class="btn btn-default btn-sm btn-primary-outline rippler" title="View Product Detail"><i class="fa fa-eye"></i></a> -->    <a href="<?=base_url()?>admin/edit_blog_categories/<?=$value['category_id']?>" class="btn btn-default btn-xs btn-success-outline rippler" title="Edit Category"><i class="fa fa-pencil"></i></a>    <a onclick="deleteBlogCategory(<?=$value['category_id']?>)" class="btn btn-default btn-xs btn-danger-outline rippler"><i class="fa fa-remove" title="Delete Category"></i></a></td>
                       </tr>
                      <?php
                            $count++;
                        }
                    }?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </form>
    </div>
    <!-- /.col-sm-12 -->
</div>

<!-- /.row -->

<script>
    function deleteBlogCategory(id) { 
    var base_url = $('#base_url').val();
    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the blog category",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/deleteBuyBlogCategory',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 2000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + id).remove();
                    }, 2000);
                }
            }
        });
    });
}
    </script>