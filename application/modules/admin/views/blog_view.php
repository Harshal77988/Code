<style>
.error {
    color: red;
}
</style>
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">View Blog</li>
    </ol>
</div>
<br>
<!-- /.breadcrumb-wrapper -->
<div class="row">
    <div class="">
        <?php if(!empty($blog_detail)) { ?>
        <div class="col-md-4 padding_div">
            <h3>Blog Detail</h3>
            <img src="<?=base_url()?>backend/uploads/blogs/<?=$blog_detail[0]['blog_image']?>" class="img-responsive">
            <p><h4><?=$blog_detail[0]['post_title']?></h4></p>
            <p><?=$blog_detail[0]['post_content']?></p>
        </div>
        <?php } ?>
        <?php if(!empty($blog_detail[0]['blog_comments'])) {?>
        <div class="col-md-8 padding_div">
            <h3>Blog Comments</h3>
            <table class="table table-bordered" id="datatable">
                <tr>
                    <th>Comment</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($blog_detail[0]['blog_comments'] as $key => $value) {?>
                <tr>
                    <td><?=$value['comment']?></td>
                    <td><?=($value['status'] == '1' ? '<a title="Approved" onclick="changeCommentStatus('.$value['comment_id'].', '.$value['status'].', '.$value['post_id'].')"><span class="label label-success rounded"><i class="fa fa-check"></i></span></a>' : '<a title="Un-Approved" onclick="changeCommentStatus('.$value['comment_id'].', '.$value['status'].', '.$value['post_id'].')"><span class="label label-danger rounded"><i class="fa fa-close"></i></span></a>')?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <?php } ?>
        <!-- /.form-group -->
    </div>
</div>
<!-- /.row -->