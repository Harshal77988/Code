<section class="login_form_div">
    <div class="container">
        <!-- <div class="col-md-12"><h2>Account Login</h2></div> -->
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                <li class="breadcrumb-item active">Forgot Password</li>
            </ol>
        </div>        
        <div class="col-md-6 col-md-offset-3">
            <div class="title">
                <h2 style="text-transform: capitalize;">Forgot Password</h2>
            </div>
            <div class="form_center">
                <?php if(!empty($this->session->flashdata('message'))) {?>
                    <div class="alert alert-success"><?=$this->session->flashdata('message');?></div>
                <?php }?>
                <?=form_open("auth/forgot_password", array('id' => 'login_form', 'autocomplete' => 'off')); ?>
                    <p class="form-row form-row-wide">
                        <label for="username">Email address <span class="required">*</span></label>
                        <?=form_input(array('type' => 'email', 'class' => 'form-control input-text',  'id' => 'email',  'placeholder' => 'E-Mail Address', 'name' => 'email',  'autocomplete' => 'off', 'value'=>set_value('email',(!empty($email) ? $email : ''))))?>
                        <?=form_error('email'); ?>
                    </p>
                    <p class="form-row">
                        <button type="submit" class="button" name="forgot_password">Submit</button>
                    </p>
                <?=form_close(); ?>
            </div>
        </div>
    </div>
</section>
<!-- deal-outer