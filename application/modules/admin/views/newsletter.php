<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Newsletter</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Subscribed Email List</h2>
    <a class="btn btn-danger pull-right rippler" data-toggle="modal" data-target="#newsletter_modal">Send Newsletter</a>
</div>
<!-- /.page-titile-wrapper -->
<div class="row">
    <div class="col-sm-12">
        <form autocomplete="off">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable-checkbox">
                    <thead>
                        <tr>
                            <th width="auto">Sno.</th>
                            <th>Email Id</th>
                            <th>Subscription Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($newsletter_list) && !empty($newsletter_list)) {
                        $count = 1;                        
                        foreach ($newsletter_list as $value) {?>
                          <tr id="id_delete_<?=$value['id']?>">
                            <td class="text-center"><span><?=$count?></span></td>
                            <td><?=$value['email']?></td>
                            <td><?=$value['subscription_date']?></td>
                            <td><a onclick="deleteNewsletter(<?=$value['id']?>)" class="btn btn-default btn-xs btn-danger-outline rippler"><i class="fa fa-remove" title="Delete Product"></i></a></td>
                        </tr>
                        <?php $count++;
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
<?=$this->load->view('admin/modal/send_newsletter')?>