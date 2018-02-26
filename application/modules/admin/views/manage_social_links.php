<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Manage Social Links</li>
    </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
    <h2 class="page-title">Manage Social Links</h2>
    <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target=".id_mdl_add_social_link"><i class="fa fa-plus"></i> Add New</a>
</div>
<!-- /.page-titile-wrapper -->

<div class="row">
    <div class="col-sm-12">
        <?=form_open('admin/updateAllSocialLinks', array('autocomplete' => 'off'))?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Link</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($social_list) && !empty($social_list)) {
                        $count = 1;
                        foreach ($social_list as $value) {?>
                        <tr id="attr_">
                            <td class="text-center" style="width: 8%;"><?=$count?></td>
                            <td><?=ucfirst($value['name'])?></td>
                            <td><input type="text" name="link_arry[]" class="form-control" value="<?=$value['link']?>" placeholder="<?=ucfirst($value['name'])?> social link">
                                <input type="hidden" name="id_arry[]" value="<?=$value['id']?>">
                            </td>
                            <td class="text-center"><a href="#" class="btn btn-xs btn-danger-outline rippler" onclick="deleteSocialLink(<?=$value['id']?>)"><i class="fa fa-remove"></a></td>
                        </tr>
                        <?php
                            $count++;
                            }
                        }
                    ?>
                    </tbody>
                </table><br><hr>
                <div class="col-sm-12 text-center">
                    <button type="submit" id="btn_submit" class="btn btn-success">Update Links</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $this->load->view('modal/modal_add_social_link'); ?>