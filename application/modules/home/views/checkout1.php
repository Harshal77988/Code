<?php $status = '' ?>
<?php $Astatus = '' ?>
<!--<div id="kopa-top-page">        
    <div class="top-page-above">
        <div class="mask"></div>            
        <div class="page-title">
            <h1>Checkout</h1>  
            <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
        </div> 
    </div>  
     top page above 
</div>-->
<!-- kopa top page -->
<?php // echo '<pre>', print_r($_SESSION),"</pre>";?>
<div class="kopa-shop-product-page pt-40 mb-40 checkOutSteps">
    <div class="container">
        <div class="row">
            <div id="main-col" class="col-md-9">    
                <div class="kopa-tab-1">              
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php if ($this->uri->segment(3) == 'success' || $this->uri->segment(3) == 'cancel') { ?>
                            <li role="presentation" class="member_details disabled"><a aria-controls="memberDetails" role="tab"><i class="fa fa-edit"></i> Member Details</a></li>

                            <?php
                            $status = "active";
                        } else {
                            ?>
                            <li role="presentation" class="member_details active"><a aria-controls="memberDetails" role="tab"><i class="fa fa-edit"></i> Member Details</a></li>
                            <?php
                            $Astatus = "active";
                        }
                        ?>
                        <li role="presentation" class="payment_details disabled"><a aria-controls="payment" role="tab"><i class="fa fa-money"></i> Payment</a></li>
                        <?php if ($this->uri->segment(3) == 'success' || $this->uri->segment(3) == 'cancel') { ?>
                            <li role="presentation" class="status_details active"><a aria-controls="status" role="tab"><i class="fa fa-check"></i> Status</a></li>
                        <?php } else { ?>
                            <li role="presentation" class="status_details disabled"><a aria-controls="status" role="tab"><i class="fa fa-check"></i> Status</a></li>
                        <?php } ?>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content mb-40">
                        <div role="tabpanel" class="tab-pane member_details <?php echo $Astatus ?>" id="memberDetails">
                            <form id="memberDetailsForm" role="form" action="" method="post" novalidate="novalidate" autocomplete="off" autocorrect="off">
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <h4>STEP #1: Tell us about yourself</h4>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <?php echo form_label(lang('first_name'), 'first_name', array('for' => 'first_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                        <?php
                                        echo form_input(array(
                                            'type' => 'text',
                                            'id' => 'first_name',
                                            'name' => 'first_name',
                                            'placeholder' => 'Last Name',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'value' => set_value('first_name', $dataHeader['first_name']),
                                            'readonly' => 'readonly'
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <?php echo form_label(lang('last_name'), 'last_name', array('for' => 'last_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                        <?php
                                        echo form_input(array(
                                            'type' => 'text',
                                            'id' => 'last_name',
                                            'name' => 'last_name',
                                            'placeholder' => 'Last Name',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'value' => set_value('last_name', $dataHeader['last_name']),
                                            'readonly' => 'readonly'
                                        ));
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Country code</label>
                                        <?php
                                        echo form_dropdown(array(
                                            'id' => 'billing_country1',
                                            'name' => 'billing_country',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'class' => 'form-control'
                                                ), $country_list
                                        );
                                        ?>

                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Phone Number</label>
                                        <?php
                                        echo form_input(array(
                                            'autocomplete' => 'off',
                                            'type' => 'number',
                                            'id' => 'phone',
                                            'name' => 'phone',
                                            'placeholder' => 'Phone',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'value' => set_value('phone', $dataHeader['phone']),
                                        ));
                                        ?>
                                        <!--<input name="phone" class="form-control" id="phone" required="required" type="text" maxlength="10" onkeydown="return isNumberKey(event);" placeholder="Phone Number" value="">-->
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Email</label>
                                        <?php
                                        echo form_input(array(
                                            'type' => 'email',
                                            'id' => 'email',
                                            'name' => 'email',
                                            'placeholder' => 'Last Name',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'value' => set_value('email', $dataHeader['email']),
                                            'readonly' => 'readonly'
                                        ));
                                        ?>
                                    </div>

                                    <?php if (!$this->ion_auth->logged_in()) { ?>
                                        <div class="col-sm-6 form-group">
                                            <label>Password</label>
                                            <input name="password" id="password" class="form-control" required="required" type="password" placeholder="Password" >
                                        </div>
                                    <?php } ?>

                                </div>
                                <?php if (!$this->ion_auth->logged_in()) { ?>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Confirm Password</label>
                                            <input name="confirmpassword" id="confirmpassword" class="form-control" required="required" type="password" placeholder="Confirm Password" >
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="div_billing_address">

                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <hr>
                                            <h4>STEP #2: Billing Address</h4>
                                        </div>
                                    </div>


                                    <div class="_div_billing_address">
                                        <div class="row">
                                            <div class="col-sm-12 form-group">

                                                <label>Zip Code</label>
                                                <input name="zip_2" class="form-control" id="billing_zip_2" required="required" type="text" onkeydown="return isNumberKey(event);" placeholder="Billing Zip" value="<?php echo isset($_SESSION['temp_billing_zip']) ? $_SESSION['temp_billing_zip'] : '' ?>" maxlength="5">
                                                <div id="error-message" class="error"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <label>Address</label>
<!--                                                <input id="autocomplete" placeholder="Enter your address"
                                                        type="text"/>-->
                                                <input name="address_2" onFocus="geolocate()" class="form-control" id="billing_address_2" required="required" type="text" placeholder="Billing Address" value="<?php echo isset($_SESSION['temp_billing_address_2']) ? $_SESSION['temp_billing_address_2'] : '' ?>" maxlength="35">
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label>City</label>
                                                <input name="billing_city_2" class="form-control" id="billing_city_2" required="required" type="text" placeholder="Billing City" value="<?php echo isset($_SESSION['temp_billing_city_2']) ? $_SESSION['temp_billing_city_2'] : '' ?>" maxlength="35">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 form-group">

                                                <?php
                                                echo form_input(array(
                                                    'id' => 'billing_country',
                                                    'name' => 'billing_country',
                                                    'class' => 'form-control',
                                                    'required' => 'required',
                                                    'class' => 'form-control',
                                                    'type' => 'hidden'
                                                        )
                                                );
                                                ?>


                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <?php
                                                echo form_input(array(
                                                    'id' => 'billing_state',
                                                    'name' => 'billing_state',
                                                    'class' => 'form-control',
                                                    'required' => 'required',
                                                    'class' => 'form-control',
                                                    'type' => 'hidden'
                                                        )
                                                );
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="div_shipping_address">

                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <hr>
                                            <h4>STEP #3: Shipping Address</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <input type="checkbox" id="_id_same_as"> Same as Billing Address 

                                        </div>                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 form-group">

                                            <hr>
                                            <label>Zip Code</label>
                                            <input name="zip" class="form-control" id="billing_zip" required="required" type="text" onkeydown="return isNumberKey(event);" placeholder="Zip" value="<?php echo isset($cart_summary['zip_code']) ? $cart_summary['zip_code'] : '' ?>">
                                              <!--<button type="button" class="btn btn-default" id="id_estimation">Get Quote  <i class="fa fa-exclamation-circle" title="Estimation of Tax & Shipping Rates"> </i></button>-->
                                            <div id="error-message" class="error"></div>
                                        </div>

                                        <div class="col-sm-6 form-group">
                                            <div id="id-estimate-address" style="display: none">
                                                <label>State | Region | Country | ZIP</label>
                                                <h5 id="id-estimate-sc"></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Address</label>
                                            <input name="address" class="form-control" id="billing_address" required="required" type="text" placeholder="Address" value="<?php echo isset($_SESSION['temp_billing_address']) ? $_SESSION['temp_billing_address'] : '' ?>"  autocomplete="off" maxlength="35">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>City</label>
                                            <input name="billing_city" class="form-control" id="billing_city" required="required" type="text" placeholder="City" value="<?php echo isset($_SESSION['temp_billing_city']) ? $_SESSION['temp_billing_city'] : '' ?>"  autocomplete="off" maxlength="35">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">

                                            <?php
                                            echo form_input(array(
                                                'id' => 'billing_country',
                                                'name' => 'billing_country',
                                                'class' => 'form-control',
                                                'required' => 'required',
                                                'class' => 'form-control',
                                                'type' => 'hidden'
                                                    )
                                            );
                                            ?>


                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <?php
                                            echo form_input(array(
                                                'id' => 'billing_state',
                                                'name' => 'billing_state',
                                                'class' => 'form-control',
                                                'required' => 'required',
                                                'class' => 'form-control',
                                                'type' => 'hidden'
                                                    )
                                            );
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="will_call_div">

                                    <p>
                                    <h4><input id="id_chk_wc" class="" type="checkbox" name="method"> <b class="">Will call</b></h4>
                                    </p>
                                    <p id="div_wc" hidden="">
                                        <span class="kp-dropcap radius red">
                                            <i class="fa fa-map-marker"></i>
                                        </span>
                                    <p>You can pick the product directly from the pickup store. Click on <span class="text-danger "><b>"WIll Call"</b> </span>option to check available pickup stores details below</p>

                                    <div id="div_store_info" hidden="">
                                        <b>Please find the Pick-up stores details below</b> <p  id="id_store_info" class=""></p>
                                    </div>
                                    <p id="div_wc_error" hidden="">
                                        <span class="kp-dropcap radius red">
                                            <i class="fa fa-map-marker"></i>
                                        </span>
                                        <span class="text-danger "><b>"Sorry! There are no pickup store near by you"</b> </span>
                                    </p>
                                    <div class="clearfix"></div>
                                    <hr>
                                </div>
                                <ul class="list-inline">
                                    <li><button type="submit" class="btn kopaBtn next" >Next</button></li>
                                </ul>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane payment_details" id="payment">
                            <div class="row">
                                <form id="paymentDetailsForm" role="form" action="" method="post" novalidate="novalidate" class="">
                                    <div class="col-sm-12 form-group">
                                        <h4>STEP #3: Enter payment details</h4>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <ul class="list-inline">
                                            <li>
                                                <label class="radio-inline">
                                                    <input type="radio" id="id_visa" name="paymentOption" data-payment-type="card" class="paymentOpt" checked> 
                                                    <img src="<?php echo base_url() ?>assets/images/visa.png" width="40">
                                                    <img src="<?php echo base_url() ?>assets/images/mastercard.png" width="40">
                                                    <img src="<?php echo base_url() ?>assets/images/american-express.png" width="40">
                                                    <img src="<?php echo base_url() ?>assets/images/discover.png" width="40">
                                                </label>
                                            </li>
                                            <li>
                                                <label class="radio-inline">
                                                    <input type="radio" id="id_paypal" name="paymentOption" data-payment-type="paypal" class="paymentOpt">
                                                    <img src="<?php echo base_url() ?>assets/images/paypal.png" width="40">
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6 form-group creaditCardInfo">
                                        <label>Card Number</label>
                                        <input name="credit_number" id="credit_number" class="form-control"  size="20" data-stripe="number" required="required" type="number" onkeydown="return isNumberKey(event);" placeholder="Card Number">
                                    </div>
                                    <div class="col-sm-6 form-group securityCode creaditCardInfo">
                                        <label>Security Code 
                                            <span data-toggle="popover" data-trigger="hover" data-html="true" title="CVV" data-content="
                                                  <p>Your card code is a 3 or 4 digit number that is found in these locations:</p>
                                                  <div class='clearfix'>
                                                  <div class='contents'>
                                                  <p><strong>Visa/Mastercard</strong></p>
                                                  <p>The security code is a 3 digit number on the back of your credit card. It immediately follows your main card number.</p>
                                                  <p><strong>American Express</strong></p>
                                                  <p>The security code is a 4 digit number on the front of your card, just above and to the right of your main card number.</p>
                                                  </div>
                                                  <div class='imgBlock'>
                                                  <img src='<?php echo base_url() ?>assets/images/cvv.png' class=''>
                                                  </div>
                                                  </div>
                                                  ">
                                                <i class="fa fa-info-circle"></i>
                                            </span>
                                        </label>
                                        <input name="security_code" class="form-control" id="cvc" required="required" type="password" data-stripe="cvc" onkeydown="return isNumberKey(event);" placeholder="Security Code">
                                    </div>
                                    <div class="col-sm-6 form-group creaditCardInfo">
                                        <label>Expiration Date</label>
                                        <div>
                                            <input name="exp_month" size="2" data-stripe="exp_month" id="exp_month" class="form-control" required="required" type="text" placeholder="MM" style="float:left; width:25%;">
                                            <input name="exp_year" size="2" data-stripe="exp_year" id="exp_year" class="form-control" required="required" type="text" placeholder="YY" style="float:left;width:25%;">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="terms" checked> I accept <a href="" target="_blank">terms and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <span id="paystatus"></span>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="text-center">

                                            <a class="btn kopaBtn paypal-btn" style="display:none" href="<?php echo base_url() . 'home/buy/'; ?>">Place Order</a>
                                            <button type="submit" class="btn kopaBtn strip-btn" >Place Order</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane status_details <?php echo $status ?>" id="status" >
                            <?php if ($this->uri->segment(3) == 'success') { ?>
                                <?php $this->load->view('product/success'); ?>
                            <?php } ?>
                            <?php if ($this->uri->segment(3) == 'cancel') { ?>
                                <?php $this->load->view('product/cancel'); ?>
                            <?php } ?>
                            <!-- <ul class="list-inline">
                                <li><button type="button" class="btn btnRed prev-step">Previous</button></li>
                            </ul> -->
                        </div>
                    </div>
                </div>  
            </div>
            <!-- main column -->

            <div id="sidebar" class="col-md-3">  
                <div class="widget kopa-product-list-widget checkoutOrderWrap">
                    <div class="widget-title title-s2">
                        <h3>ORDER SUMMARY</h3>
                    </div>
                    <div class="widget-content">
                        <table class="table checkoutOrdertable">
                            <tbody>
                                <tr>
                                    <?php if (isset($discounts['total']['value_desc'])) { ?>
                                <div class="panel" style="border-style: dashed; border-color: green; padding:  10px">
                                    <div class="coupon_code_entry">
                                        <p class="title_code">Promo Code Applied</p>


                                        <b class="input_code"><?php echo $discounts['total']['code']; ?></b>
                                        <?php if (isset($discounts['total']['id'])) { ?>
                                            <a class="btn btn-sm" href="<?php echo base_url(); ?>standard_library/unset_discount/<?php echo $discounts['total']['id']; ?>" title="Remove Coupon Code"><i class="fa fa-remove text-danger"></i></a>
                                        <?php } ?>

                                        <p><small><?php echo $discounts['total']['description']; ?></small></p>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div id="">                                    
                                    Have Coupon Code?
                                    <fieldset>
                                        <?php echo form_open('standard_library/view_cart'); ?>
                                        <?php ?>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <input type="text" name="discount[0]" class="form-control" value="" placeholder="Coupon code here" style="height: 35px" autocomplete="off"/>
                                            </div>
                                            <div class="col-sm-1 col-sm-pull-1">
                                                <button type="submit" class=" btn"  name="update_discount" value="Add Coupon Code"><i class="fa fa-check"></i></button>
                                            </div>
                                        </div>  
                                    </fieldset>

                                    <?php echo form_close(); ?>
                                </div>
                            <?php } ?>
                            </tr>
                            <tr>
                                <th>Subtotal<span class="text-danger">  <?php echo!empty($cart_summary['total_items']) ? $cart_summary['total_items'] : '0' ?> item(s)  </span></th>
                                <td class="text-right">$<span >
                                        <?php
                                        echo $cart_summary['item_summary_total'];

//                                    echo!empty($cart_summary['item_summary_total']) 
//                                    ? $cart_summary['item_summary_total']-str_replace('US $', ' ', $discounts['total']['value']) : '0' 
                                        ?>
                                    </span> </td>
                            </tr>

<!--                                <tr>
                                <th>Shipping</th>
                                <td class="text-right">$<?php echo!empty($cart_summary['shipping_total']) ? $cart_summary['shipping_total'] : '0' ?></td>
                            </tr>
                            <tr>
                                <th>Estimated Tax</th>
                                <td class="text-right">$<?php echo!empty($cart_summary['tax_total']) ? round($cart_summary['tax_total']) : '0' ?></td>
                            </tr>-->
                            </tbody>
                            <tfoot>

                                <tr>
                                    <th>Shipping</th>
                                    <td class="text-right">
                                        <span id="shipping_price">-</span>
                                    </td>
                                </tr>
                                <?php if (isset($discounts['total']['value_desc'])) { ?>
                                    <tr>
                                        <th>Coupon Applied</th>
                                        <td class="text-right">
                                            <span id="shipping_price" class="text-danger"><b>- %<?php echo $discounts['total']['value_desc']; ?></b></span>
                                        </td>
                                    </tr>
                                <hr>
                            <?php } ?>
                            <tr>
                                <th>Estimated Tax <span id="id_tax_per"></sapn></th>
                                <td class="text-right">
                                    <span id="tax_amount">
                                        $<?php echo isset($cart_summary['zip_code']) ? $cart_summary['tax_total'] : "0" ?>
                                    </span>
                                </td>
                            </tr>

                            <tr class="">
                                <th>Total Price:</th>
                                <td class="text-right"> 
                                    <span id="total_amount">
                                        $<?php
                                        if (!empty($discounts['total']['value'])) {
                                            $dis = $discounts['total']['value_desc'];
                                            $discount_val = ($cart_summary['item_summary_total'] * $dis) / 100;
                                            if ($cart_summary['shipping_total'] && $cart_summary['shipping_total'] != '' && $cart_summary['shipping_total'] != '0')
                                                echo $cart_summary['item_summary_total'] - $discount_val ;
                                            else
                                                echo $cart_summary['item_summary_total'] - $discount_val;
//                                                echo ($cart_summary['item_summary_total']) - str_replace('US $', ' ', $discounts['total']['value']);
                                        } else {

                                            if (isset($cart_summary['zip_code']) && $cart_summary['tax_total'] != '0') {
                                                if ($cart_summary['shipping_total'] && $cart_summary['shipping_total'] != '' && $cart_summary['shipping_total'] != '0')
                                                    echo ($cart_summary['item_summary_total'] + $cart_summary['tax_total'] + $cart_summary['shipping_total']);
                                            } else {

                                                echo $cart_summary['item_summary_total'];
                                            }
                                        }
                                        ?>
                                    </span>
                                </td>
                                <!--<td class="text-right">$<?php // echo ($cart_summary['shipping_total']) + round($cart_summary['tax_total']) + ($cart_summary['total'])                                                                                                                                                                                       ?></td>-->
                            </tr>


                            </tfoot>
                        </table>

                    </div>
                </div>
                <!-- kopa product list widget -->
            </div>
            <!-- sidebar -->

        </div>
        <!-- row -->
    </div>   
    <!-- container -->    
</div>
<!-- main content -->
<div class="modal fade id_will_call" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Add Tax Rate</h4>
            </div>
            <?php echo form_open('admin/manage_tax/add/', array('id' => 'id_form_tax_add', 'class' => 'form-horizontal form-label-left', 'data-parsley-validate')); ?>
            <div class="modal-body">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zipcode">Zip Code<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                        echo form_input(array(
                            'type' => 'text',
                            'name' => 'zipcode',
                            'id' => 'zipcode',
                            'placeholder' => 'zipcode',
                            'required' => 'required',
                            'class' => 'form-control'
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Check</button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
                                            $(window).load(function () {

                                                if ($('input[id="id_paypal"]').is(':checked')) {
                                                    $("#id_paypal").removeAttr("checked");
                                                    $("#id_visa").prop("checked", true);
                                                }
<?php if ($this->session->flashdata('message_des')) { ?>
                                                    $.toaster({priority: 'info', title: 'Discounts', message: '<?php echo $this->session->flashdata('message_des') ?>'});
<?php } ?>
                                            });
                                            $(document).ready(function () {

                                                zip_code = $("#billing_zip_2").val();
                                                if (zip_code) {

                                                    if ($('input[name="method"]').is(':checked')) {
                                                        $("#div_wc_error").hide();
                                                        $("#div_wc").show();
                                                        $("#shipping_price").html("$0");
                                                        $.ajax({
                                                            type: "POST",
                                                            url: '<?php echo base_url(); ?>home/check_will_Call',
                                                            data: {'zipcode': zip_code},
                                                            success: function (data) {
                                                                var obj = JSON.parse(data);
                                                                if (obj.status == "false") {
                                                                    $('input[name=method]').attr('checked', false);
                                                                    $("#div_wc").hide();
                                                                    $("#div_wc_error").show();
                                                                    $("#div_store_info").hide();
                                                                }
                                                                if (obj.status == "true") {
                                                                    $("#div_store_info").show();
                                                                    $("#id_store_info").html(obj.data);
                                                                    $("#div_wc").show();
                                                                    $("#div_wc_error").hide();
                                                                }
                                                            }
                                                        });
                                                    } else {
                                                        calculateShippingRate();
                                                    }

                                                    var w_flag = "";
                                                    if ($('input[name="method"]').is(':checked')) {
                                                        w_flag = "true";
                                                    } else
                                                    {
                                                        w_flag = "false";
                                                    }

                                                    $.ajax({
                                                        // url: '/index.php/members/userExist',
                                                        url: base_url + 'home/calculateTax/',
                                                        type: 'POST',
                                                        data: {zip_code: zip_code, w_flag: w_flag},
                                                        success: function (res) {
                                                            var obj = JSON.parse(res);
                                                            if (obj.status == "1") {
                                                                $("#error-message").html("");
                                                                //$("#id_tax_per").html("(" + obj.per + "%)");
                                                                $("#tax_amount").html("$ " + obj.tax_amount);
//                                                                alert(obj.shipping_total);return false;
                                                                if ($('input[name="method"]').is(':checked')) {

                                                                    var total = obj.tax_amount + obj.item_summary_total;
                                                                } else {

                                                                    var total = obj.tax_amount + obj.item_summary_total + parseFloat(obj.shipping_total);
                                                                }
//                                                                alert(total);
//                                                                var total = parseFloat(obj.tax_amount + obj.item_summary_total + parseFloat(obj.shipping_total));
                                                                $("#total_amount").html("$ " + total.toFixed(2));


                                                                $("#billing_country").val("US");
                                                                $("#billing_state").val(obj.state);
//                    $("#id-estimate-address").show();
//                    $("#id-estimate-sc").html(obj.state +" | "+ obj.region +" | US "+" | "+ zip_code  );




                                                            } else {
                                                                $("#id-estimate-address").hide();
                                                                $("#id-estimate-sc").html("");
                                                                $("#billing_country").val("US");
                                                                $("#billing_state").val("");
                                                                $("#billing_zip_2").focus();
                                                                $("#billing_zip_2").val("");
                                                                $("#id_tax_per").html("");
                                                                $("#tax_amount").html("0.00");
                                                                $("#total_amount").html(obj.item_summary_total);
                                                                custom_status = "fail";
                                                                custom_message = obj.content;
                                                                $("#error-message").html(custom_message);
                                                                return false;
                                                            }
                                                        }
                                                    });
                                                }


                                                $('#id_chk_wc').click(function () {
                                                    var zipcode = $("#billing_zip_2").val();
                                                    var old_shipping = $("#shipping_price").text();

//                                                    if (zipcode == "") {
//                                                        $("#billing_zip").focus();
//                                                        $("#billing_zip").attr("placeholder", "Place zipcode to check with pickup avalability");
//                                                        return false;
//                                                    }
                                                    if ($('input[name="method"]').is(':checked')) {
                                                        $("#shipping_price").html("$0");
                                                        $("#div_wc_error").hide();
                                                        $("#div_wc").show();
                                                        if ($('input[name="method"]').is(':checked')) {

                                                            $.ajax({
                                                                type: "POST",
                                                                url: '<?php echo base_url(); ?>home/check_will_Call',
                                                                data: {'zipcode': zipcode, 'status': "checked"},
                                                                success: function (data) {
                                                                    var obj = JSON.parse(data);
                                                                    if (obj.status == "false") {

                                                                        $('input[name=method]').attr('checked', false);
                                                                        $("#div_wc").hide();
                                                                        $("#div_wc_error").show();
                                                                        $("#div_store_info").hide();
                                                                        calculateShippingRate();
                                                                    }
                                                                    if (obj.status == "true") {
                                                                        $("#div_store_info").show();
                                                                        $("#id_store_info").html(obj.data);
                                                                        $("#div_wc").show();
                                                                        $("#div_wc_error").hide();
                                                                    }
                                                                }
                                                            });
                                                        }
                                                        calculateShippingRate();
                                                    } else {
                                                        $(".div_shipping_address").show();
                                                        calculateShippingRate();

                                                        $("#div_wc").hide();
                                                        $("#div_store_info").hide();
                                                        $("#billing_zip_2").attr("placeholder", "Zipcode");
                                                    }
                                                    calculateTax();
                                                });



                                                $('#id_paypal').click(function () {

                                                    $('.paypal-btn').show();
                                                    $('.strip-btn').hide();
                                                });
                                                $('#id_visa').click(function () {

                                                    $('.strip-btn').show();
                                                    $('.paypal-btn').hide();
                                                });
                                                $('select[id="billing_country"]').change(function () {
                                                    $('select[id="billing_state"]').prop("disabled", false);
                                                    var country_id = $(this).val();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '<?php echo base_url(); ?>home/getStateList',
                                                        data: {'country_id': country_id},
                                                        success: function (data) {
                                                            if (data) {
                                                                $('select[name="billing_state"]').html(data.content).trigger('liszt:updated').val(country_id);
                                                            }
                                                        }
                                                    });
                                                });

                                                $('select[name="state_id"]').change(function () {
                                                    var state_id = $(this).val();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '<?php echo base_url(); ?>employee/getCityList',
                                                        data: {'state_id': state_id},
                                                        success: function (data) {
                                                            if (data) {
                                                                $('select[name="city_id"]').html(data.content).trigger('liszt:updated').val(state_id);
                                                            }
                                                        }
                                                    });
                                                });

                                                $('select[name="c_country_id"]').change(function () {
                                                    var country_id = $(this).val();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '<?php echo base_url(); ?>employee/getStateList',
                                                        data: {'country_id': country_id},
                                                        success: function (data) {
                                                            if (data) {
                                                                $('select[name="c_state_id"]').html(data.content).trigger('liszt:updated').val(country_id);
                                                            }
                                                        }
                                                    });
                                                });
                                                $('select[name="c_state_id"]').change(function () {
                                                    var state_id = $(this).val();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '<?php echo base_url(); ?>employee/getCityList',
                                                        data: {'state_id': state_id},
                                                        success: function (data) {
                                                            if (data) {
                                                                $('select[name="c_city_id"]').html(data.content).trigger('liszt:updated').val(state_id);
                                                            }
                                                        }
                                                    });
                                                });
                                            });


</script>
<script>
    function funStoreClick(store_id) {
        $(".div_shipping_address").hide();
    }
</script>
<script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    var placeSearch, autocomplete, autocomplete2, autocomplete3, autocomplete4;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };
    
    
    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        // 
        var options = {
            types: ['(cities)'],
            componentRestrictions: {country: "us"}
        };
        
        var options2 = {
            types: ['geocode'],
            componentRestrictions: {country: "us"}
        };
        
        //billing address
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('billing_address_2')),
                options2);
        //billing city       

        autocomplete2 = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('billing_city_2')),
                options);
        //shipping address
        autocomplete3 = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('billing_address')),
                options2);

        //shipping city
        autocomplete4 = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('billing_city')),
                options);

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', function() {
        	fillInAddress(autocomplete, "billing_address_2");
        });
         
        autocomplete2.addListener('place_changed', function() {
        	fillInCity(autocomplete2, "billing_city_2");
        });
         
        autocomplete3.addListener('place_changed', function() {
        	fillInAddress(autocomplete3, "billing_address");
        });
         
        autocomplete4.addListener('place_changed', function() {
        	fillInCity(autocomplete4, "billing_city");
        });         
}

    	function fillInAddress(autocomplete, componentID) {
    		
	  // Get the place details from the autocomplete object.
	  var place = autocomplete.getPlace();
	
	  // Get each component of the address from the place details
	  // and fill the corresponding field on the form.
	  var finalValue = '';
	  for (var i = 0; i < place.address_components.length; i++) {
	    var addressType = place.address_components[i].types[0];
	    //alert('addressType = ' + addressType)
	    if (componentForm[addressType] && (addressType == 'street_number' || addressType == 'route')){
	      var val = place.address_components[i][componentForm[addressType]];
	      finalValue += val + ' ';
	    }
	    if(finalValue.length > 35)
	    	finalValue = finalValue.substring(0, 35);
	    
	    document.getElementById(componentID).value = finalValue;
	  }
	}
	
	function fillInCity(autocomplete, componentID) {
	  // Get the place details from the autocomplete object.
	  var place = autocomplete.getPlace();
	
	  // Get each component of the address from the place details
	  // and fill the corresponding field on the form.
	  var finalValue = '';
	  for (var i = 0; i < place.address_components.length; i++) {
	    var addressType = place.address_components[i].types[0];
	    if (componentForm[addressType] && (addressType == 'locality' || addressType == 'administrative_area_level_1' || addressType == 'country')) {
	      var val = place.address_components[i][componentForm[addressType]];
	      if(addressType == 'administrative_area_level_1')
		      finalValue += val + ', ';
	      else 
		      finalValue += val + ' ';
	    }
	    if(finalValue.length > 35)
	    	finalValue = finalValue.substring(0, 35);
	    	
	    document.getElementById(componentID).value = finalValue;
	  }
	}

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBE2-SaFvenGEoY1dqYkINjeaA97cvuBJk&libraries=places&callback=initAutocomplete"
async defer></script>