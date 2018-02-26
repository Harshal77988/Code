<section class="shopping-cart">
    <!-- My account section -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                    <li class="breadcrumb-item active">My Account</li>
                </ol>
            </div>
            <!-- Start Content -->
            <main id="main" class="site-main col-md-12">
                <article id="post-12" class="post-12 page type-page status-publish hentry">
                    <header class="entry-header"><h1 class="entry-title">Account details</h1></header>
                    <div class="entry-content">
                        <div class="woocommerce">
                            <div class="row">
                                <?=form_open('home/update_myaccount', array("class" => "woocommerce-EditAccountForm edit-account"))?>
                                <div class="col-xs-12 col-sm-3 myaccount-navigation">
                                    <ul class="nav">
                                        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account <?=($this->uri->segment(1) == 'my_account' ? ' is-active' : '')?>">
                                            <?=anchor('my_account', 'Account details', array('title' => 'Account details'));?>
                                        </li>
                                        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders <?=($this->uri->segment(1) == 'my_orders' ? ' is-active' : '')?>">
                                            <?=anchor('my_orders', 'Orders', array('title' => 'Orders'));?>
                                        </li>
                                        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address <?=($this->uri->segment(1) == 'track_order' ? ' is-active' : '')?>">
                                            <?=anchor('track_order', 'Track Order', array('title' => 'Track Order'));?>
                                        </li>
                                        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
                                            <?=anchor('auth/Logout', 'Logout', array('title' => 'Logout'));?>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-9 myaccount-content">
                                	<div class="myaccount-content rokan-product-heading">
			                            <h2>Basic Information</h2>  
                                        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first col-md-6">
                                            <?=form_label('First name <span class="required">*</span>', 'account_first_name');?>
                                            <?=form_input(array('class' => 'form-control', 'id' => 'my_firstname', 'placeholder' => 'First Name', 'value' => $account_details['first_name'], 'name' => 'my_first_name', 'maxlength' => '35', 'readonly' => 'readonly'))?>
                                        </p>
                                        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last col-md-6">
                                            <?=form_label('Last name <span class="required">*</span>', 'account_last_name');?>
                                            <?=form_input(array('class' => 'form-control', 'id' => 'my_lastname', 'placeholder' => 'Last Name', 'value' => $account_details['last_name'], 'name' => 'my_last_name', 'maxlength' => '35', 'readonly' => 'readonly'))?>
                                        </p>
                                        <div class="clear"></div>
                                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                            <?=form_label('Email address <span class="required">*</span>', 'account_email');?>
                                            <?=form_input(array('class' => 'form-control', 'id' => 'my_email', 'placeholder' => 'E-mail', 'value' => $account_details['email'], 'name' => 'my_email', 'maxlength' => '90', 'readonly' => 'readonly'))?>
                                        </p>
                                    </div>
                                    <div class="myaccount-content rokan-product-heading">
			                            <h2>Shipping address</h2>
			                            <div class="woocommerce-address-fields">
			                                <div class="woocommerce-address-fields__field-wrapper">
			                                    <p class="form-row form-row-first col-md-6 validate-required" id="shipping_first_name_field" data-priority="10">
                                                    <?=form_label('First name <span class="required">*</span>', 'shipping_first_name');?>
			                                        <?=form_input(array('class' => 'form-control', 'id' => 'shipping_firstname', 'placeholder' => 'First Name', 'value' => $get_address['s_first_name'], 'name' => 'shipping_first_name', 'maxlength' => '35'))?>
			                                    </p>
			                                    <p class="form-row form-row-last col-md-6 validate-required" id="shipping_last_name_field" data-priority="20">
			                                        <?=form_label('Last name <span class="required">*</span>', 'shipping_last_name');?>
			                                        <?=form_input(array('class' => 'form-control', 'id' => 'shipping_lastname', 'placeholder' => 'Last Name', 'value' => $get_address['s_last_name'], 'name' => 'shipping_last_name', 'maxlength' => '35'))?>
			                                    </p>
			                                    <p class="form-row form-row-first validate-phone col-md-12" id="shipping_phone_field" data-priority="100">
			                                        <?=form_label('Phone <span class="required">*</span>', 'shipping_phone');?>
			                                        <?=form_input(array('class' => 'form-control', 'id' => 'shipping_telephone', 'placeholder' => 'Telephone', 'value' => $get_address['s_phone'], 'name' => 'shipping_telephone', 'maxlength' => '25'))?>
			                                    </p>
			                                    <p class="form-row form-row-wide" id="shipping_company_field" data-priority="30">
			                                        <?=form_label('Company name <span class="required">*</span>', 'shipping_company');?>
			                                        <?=form_input(array('class' => 'form-control', 'id' => 'shipping_company', 'placeholder' => 'Company Name', 'value' => $get_address['s_company'], 'name' => 'shipping_company', 'maxlength' => '100'))?>
			                                    </p>
			                                    <p class="form-row form-row-wide address-field" id="shipping_address_1_field" data-priority="50">
			                                        <?=form_label('Street address <span class="required">*</span>', 'shipping_address_1');?>
			                                        <?=form_input(array('class' => 'form-control', 'id' => 'my_address', 'placeholder' => 'Address', 'value' => $get_address['s_address'], 'name' => 'shipping_address', 'maxlength' => '160'))?>
			                                    </p>
			                                    <p class="form-row form-row-wide address-field" id="shipping_city_field" data-priority="70" data-o_class="form-row form-row-wide address-field">
			                                        <?=form_label('Town / City <span class="required">*</span>', 'shipping_city');?>
			                                        <?=form_input(array('class' => 'form-control', 'id' => 'shipping_city', 'placeholder' => 'City', 'value' => $get_address['s_city'], 'name' => 'shipping_city', 'maxlength' => '35'))?>
			                                    </p>
			                                    <p class="form-row form-row-wide address-field update_totals_on_change" id="shipping_country_field" data-priority="40">
			                                        <?=form_label('Country <span class="required">*</span>', 'shipping_country');?>
			                                        <select class="form-control input-text" id="input-country" name="shipping_country_id">
						                                <option value="" selected="selected"> --- Please Select --- </option>
						                                <?php
						                                    foreach ($country_list as $value) {
						                                    	if (!empty($get_address['s_country_id'])) {
						                                    		if($value['id'] == $get_address['s_country_id']) {
						                                    			echo '<option value='.$value['id'].' selected>'.$value['name'].'</option>';
						                                    		} else {
						                                    			echo '<option value='.$value['id'].'>'.$value['name'].'</option>';
						                                    		}
						                                    	} else {
						                                        	echo '<option value='.$value['id'].'>'.$value['name'].'</option>';
						                                        }
						                                    }
						                                ?>
						                            </select>
			                                    </p>
			                                    <p class="form-row form-row-wide address-field validate-state" id="shipping_state_field" data-priority="80" data-o_class="form-row form-row-wide address-field validate-state">
			                                        <?=form_label('State <span class="required">*</span>', 'shipping_state');?>
			                                        <select class="form-control input-text" id="input-zone" name="shipping_zone_id">
						                                <?php
						                                foreach ($state_list as $list) {
							                                if (!empty($get_address['s_state_id'])) {
					                                    		if($list['id'] == $get_address['s_state_id']) {
					                                    			echo '<option value='.$list['id'].' selected>'.$list['name'].'</option>';
					                                    		}
					                                    	}					                                    		
					                                    } ?>
						                            </select>
			                                    </p>				                                    
			                                    <p class="form-row form-row-wide address-field validate-postcode" id="shipping_postcode_field" data-priority="90" data-o_class="form-row form-row-wide address-field validate-postcode">
			                                        <?=form_label('Zipcode <span class="required">*</span>', 'shipping_postcode');?>
			                                        <?=form_input(array('class' => 'form-control', 'id' => 'shipping_postcode', 'placeholder' => 'Zipcode', 'value' => $get_address['s_postcode'], 'name' => 'shipping_postcode', 'maxlength' => '15'))?>
			                                    </p>				                                    
			                                </div>
			                            </div>
				                    </div>
                                    <div class="clear"></div>
                                    <p>
                                        <?=form_submit(array("class" => "woocommerce-Button button", "name" => "save_account_details", "value" => "Save changes"))?>
                                    </p>
                                </div>
                                <?=form_close()?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </article>
            </main>
            <!-- End Content -->
        </div>
    </div>
    <!-- /.My account section -->
</section>