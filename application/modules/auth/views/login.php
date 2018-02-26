<section class="login_form_div">
    <div class="container">
    	<!-- <div class="col-md-12"><h2>Account Login</h2></div> -->
    	<div class="col-md-12">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
				<li class="breadcrumb-item active">Account Login</li>
			</ol>
		</div>
        <div class="col-md-6">
            <div class="title">
                <h2 style="text-transform: capitalize;">New Customer</h2>
            </div>
            <div class="form_center">
                <!-- <form method="post" class="login">
                    <p class="form-row form-row-wide">
                        <label for="username">Email address <span class="required">*</span></label>
                        <?=form_input(array('class' => 'form-control input-text',  'id' => 'input-email',  'placeholder' => 'E-Mail Address', 'name' => 'register_email',  'autocomplete' => 'off'))?>
                    </p>
                    <p class="form-row form-row-wide">
                        <label for="password">Password <span class="required">*</span></label>
                        <?=form_password(array('class' => 'form-control',  'id' => 'input-password',  'placeholder' => 'Password', 'name' => 'register_password',  'autocomplete' => 'off'))?>
                    </p>
                    <p class="form-row">
                        <input type="hidden" id="_wpnonce" name="_wpnonce" value="1e80f4051a">
                        <input type="hidden" name="_wp_http_referer" value="/wordpress/boutique2/my-account/">
                        <input type="submit" class="button" name="register" value="Register">
                    </p>
                </form> -->
                <div><strong>Register Account</strong></div>
                <div style="margin-bottom: 20px">By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</div>
                <div style="margin-bottom: 10px"><a style="text-transform:capitalize;font-size: 14px;padding: 6px 15px;" href="<?=base_url()?>register" class="new_wishlist">Register</a></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="title">
                <h2 style="text-transform: capitalize;">Returning Customer</h2>
            </div>
            <div class="form_center">
                <?php if(!empty($this->session->flashdata('message'))) {?>
                    <div class="alert alert-success"><?=$this->session->flashdata('message');?></div>
                <?php }?>
                <?=form_open("auth/login", array('id' => 'login_form', 'autocomplete' => 'off')); ?>
                    <p class="form-row form-row-wide">
                        <label for="username">Email address <span class="required">*</span></label>
                        <?=form_input(array('class' => 'form-control input-text',  'id' => 'email',  'placeholder' => 'E-Mail Address', 'name' => 'email',  'autocomplete' => 'off', 'value'=>set_value('email',(!empty($email) ? $email : ''))))?>
                        <?=form_error('email'); ?>
                    </p>
                    <p class="form-row form-row-wide">
                        <label for="password">Password <span class="required">*</span></label>
                        <?=form_password(array('class' => 'form-control',  'id' => 'password',  'placeholder' => 'Password', 'name' => 'password',  'autocomplete' => 'off', 'value'=>set_value('password',(!empty($password) ? $password : ''))))?>
                        <?=form_error('password'); ?>
                    </p>
                    <p class="form-row">
                        <button type="submit" class="button" name="login">Log In</button>
                    </p>
                    <p class="lost_password">
                        <div style="text-align: right;"><a href="<?=base_url()?>auth/forgot_password" class="forgot-pass">Forgotten Password ?</a></div>
                    </p>
                <?=form_close(); ?>
            </div>
        </div>
    </div>
</section>
<!-- deal-outer