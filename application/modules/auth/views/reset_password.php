<section class="login_form_div">
    <div class="container">
        <!-- <div class="col-md-12"><h2>Account Login</h2></div> -->
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                <li class="breadcrumb-item active">Reset Password</li>
            </ol>
        </div>        
        <div class="col-md-6 col-md-offset-3">
        	<div id="infoMessage"><?php echo $message;?></div>
            <div class="title">
                <h2 style="text-transform: capitalize;">Reset Password</h2>
            </div>
            <div class="form_center">
                <?php if(!empty($this->session->flashdata('message'))) {?>
                    <div class="alert alert-success"><?=$this->session->flashdata('message');?></div>
                <?php }?>
                <?php echo form_open('auth/reset_password/' . $code, array('id' => 'reset_pawd_form', 'autocomplete' => 'off'));?>
                    <p class="form-row form-row-wide">
                        <label for="username">New Password <span class="required">*</span></label>
                        <?php echo form_input($new_password);?>
                    </p>
                    <p class="form-row form-row-wide">
                        <label for="username">Confirm New Password <span class="required">*</span></label>
                        <?php echo form_input($new_password_confirm);?>
                    </p>
                    <p class="form-row">
                    	<?php echo form_input($user_id);?>
                        <!-- <?php echo form_submit('submit', lang('reset_password_submit_btn'),array('class'=>"button"));?> -->
                        <!-- <input type="submit" name="submit" value="Change" class="button"> -->
                        <button type="submit" class="button" name="submit">Update Password</button>
                    </p>
                <?=form_close(); ?>
            </div>
        </div>
    </div>
</section>
<!-- deal-outer