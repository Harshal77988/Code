<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Blog List</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Blog List</h2>
    <a href="<?=base_url('admin/add_blog')?>" type="button" class="btn btn-danger pull-right rippler">Add Blog</a> 
    
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <form autocomplete="off">
            <div class="">
                <table class="table table-bordered" id="datatable-checkbox">
                    <thead>
                        <tr>
                            <th>Blog Title</th>
                            <th>Posted By</th>
                            <th>Posted On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($blog_data) && !empty($blog_data)) {
                            $count = 1;                        
                            foreach ($blog_data as $value) {?>
                        <tr id="id_delete_<?=$value['post_id']?>">
                            <td><?=substr($value['post_title'], 0, 50); ?></td>
                            <td><?=$value['first_name'].' '.$value['last_name']?></td>
                            <td><?=$value['posted_on']?></td>
                            <td><a href="<?=base_url()?>admin/view_blog/<?=$value['post_id']?>" class="btn btn-default btn-xs btn-primary-outline rippler" title="View Blog"><i class="fa fa-eye"></i></a>    <a href="<?=base_url()?>admin/edit_blog/<?=$value['post_id']?>" class="btn btn-default btn-xs btn-success-outline rippler" title="Edit Category"><i class="fa fa-pencil"></i></a>    <a onclick="deleteBlog(<?=$value['post_id']?>)" class="btn btn-default btn-xs btn-danger-outline rippler"><i class="fa fa-remove" title="Delete Category"></i></a>
                            </td>
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
    function deleteBlog(id) { 
    var base_url = $('#base_url').val();
    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the blog",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/deleteBuyBlog',
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