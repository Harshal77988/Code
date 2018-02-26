<section class="login_form_div">
    <div class="container">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                <li class="breadcrumb-item active">Account Registration</li>
            </ol>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="title">
                <h2 style="text-transform: capitalize;">Register Account</h2>
            </div>
            <div class="form_center">
                <?php if(!empty($this->session->flashdata('message'))) {?>
                    <div class="alert alert-danger"><?=$this->session->flashdata('message');?></div>
                <?php }?>
                <?=form_open("auth/register_user", array('id' => 'registration_form', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
                    <div class="form-group required">
                        <label for="first name" class="col-sm-3 control-label">First Name <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => 'form-control input-text',  'id' => 'input-firstname',  'placeholder' => 'First Name', 'name' => 'firstname',  'autocomplete' => 'off'))?>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label for="last name" class="col-sm-3 control-label">Last Name <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => 'form-control input-text',  'id' => 'input-lastname',  'placeholder' => 'Last Name', 'name' => 'lastname',  'autocomplete' => 'off'))?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="email address" class="col-sm-3 control-label">Email address <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => 'form-control input-text',  'id' => 'input-email',  'placeholder' => 'E-Mail', 'name' => 'email',  'autocomplete' => 'off'))?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="telephone" class="col-sm-3 control-label">Telephone <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => 'form-control input-text',  'id' => 'input-telephone',  'placeholder' => 'Telephone', 'name' => 'telephone',  'autocomplete' => 'off'))?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="fax" class="col-sm-3 control-label">Fax</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => 'form-control input-text',  'id' => 'input-fax',  'placeholder' => 'Fax', 'name' => 'fax',  'autocomplete' => 'off'))?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="company" class="col-sm-3 control-label">Company</label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => 'form-control input-text',  'id' => 'input-company',  'placeholder' => 'Company name', 'name' => 'company',  'autocomplete' => 'off'))?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="address" class="col-sm-3 control-label">Address <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => 'form-control input-text',  'id' => 'input-address-1',  'placeholder' => 'Address', 'name' => 'address_1',  'autocomplete' => 'off'))?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="city" class="col-sm-3 control-label">City <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => 'form-control input-text', 'id' => 'input-city', 'placeholder' => 'City name', 'name' => 'city',  'autocomplete' => 'off'))?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="city" class="col-sm-3 control-label">Postcode <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <?=form_input(array('class' => 'form-control input-text', 'id' => 'input-postcode', 'placeholder' => 'Postcode', 'name' => 'postcode',  'autocomplete' => 'off'))?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="country" class="col-sm-3 control-label">Country <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control input-text" id="input-country" name="country_id">
                                <option value="" selected="selected"> --- Please Select --- </option>
                                <?php
                                    foreach ($country_list as $value) {
                                        echo '<option value='.$value['id'].'>'.$value['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="country" class="col-sm-3 control-label">State / Region <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control input-text" id="input-zone" name="zone_id">
                                <option value="" selected="selected"> --- Please Select --- </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label for="city" class="col-sm-3 control-label">Password <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <?=form_password(array('class' => 'form-control input-text',  'id' => 'input-password',  'placeholder' => 'Password', 'name' => 'password',  'autocomplete' => 'off'))?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="city" class="col-sm-3 control-label">Confirm Password <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <?=form_password(array('class' => 'form-control input-text',  'id' => 'input-confirm',  'placeholder' => 'Password Confirm', 'name' => 'confirm',  'autocomplete' => 'off'))?>
                        </div>
                    </div>
                    <p class="form-row">
                        <button type="submit" class="button" name="register">Register</button>
                    </p>
                <?=form_close(); ?>
            </div>
        </div>
    </div>
</section>
<!-- deal-outer