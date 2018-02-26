jQuery(document).ready(function () {

    var url = $(location).attr('href');
    var segments = url.split('/');
    var http_path = segments[0];
    var site_url = segments[2];

    const base_url = http_path + '//' + site_url + '/';


    // validate the firstname
    jQuery.validator.addMethod("valid_firstname", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Enter the valid first name");

    // validate the fullname
    jQuery.validator.addMethod("valid_fullname", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Enter the valid name");

    // validate the manufacturer
    jQuery.validator.addMethod("valid_manufacturer", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Enter the valid manufacturer name");


    // validate the lastname
    jQuery.validator.addMethod("valid_lastname", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Enter the valid last name");


    // validate the telephone number
    jQuery.validator.addMethod("valid_telephone", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && phone_number.length < 15 &&
                phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
    }, "Enter the valid phone number");


    // validate the fax number
    jQuery.validator.addMethod("valid_fax", function (value, element) {
        return this.optional(element) || (/^\+?[0-9]+$/).test(value);
    }, "Enter the valid fax number");


    // validate the company name
    jQuery.validator.addMethod("valid_company", function (value, element) {
        return this.optional(element) || (/^[a-z\s]+$/i).test(value);
    }, "Enter the valid company name");


    // validate the address
    jQuery.validator.addMethod("valid_address1", function (value, element) {
        return this.optional(element) || (/^[a-zA-Z0-9\s,'-]*$/i).test(value);
    }, "Enter the valid address");

    // validate the model no
    jQuery.validator.addMethod("valid_modelno", function (value, element) {
        return this.optional(element) || (/^[a-zA-Z0-9\s,'-]*$/i).test(value);
    }, "Enter the valid model no");


    // validate the postcode
    $.validator.addMethod('valid_postcode', function (value) {
        if (value.match('^[0-9]{1,10}$') && Number(value) > 0) {
            return true;
        } else {
            return false;
        }
    }, 'Enter the valid postcode number.');



    // validate the country name
    // jQuery.validator.addMethod("valid_country", function (value, element) {
    //     return this.optional(element) || (/^[a-z\s]+$/i).test(value);
    // }, "Enter the valid country name");



    // validate the state name
    // jQuery.validator.addMethod("valid_state", function (value, element) {
    //     return this.optional(element) || (/^[a-z\s]+$/i).test(value);
    // }, "Enter the valid state name");


    // validate the confirm password field
    jQuery.validator.addMethod("password_strenth", function (value, element) {
        return this.optional(element) || (/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/).test(value);
    }, "Password must be atleast 8 chars long, atleast 1 lowercase letter, 1 capital letter, 1 number, 1 special character => !@#$%^&");


    // validate the confirm password field
    jQuery.validator.addMethod("confirm_password", function (val, element) {
        var pass1 = document.getElementById("input-password").value;
        var pass2 = document.getElementById("input-confirm").value;
        console.log(pass1);
        console.log(pass2);
        if (pass1 != pass2) {
            return false;
        } else {
            return true;
        }
    }, "Confirm password didn't match");


    // validate the confirm password field
    jQuery.validator.addMethod("register_confirm_password", function (val, element) {
        var pass1 = document.getElementById("reg_password").value;
        var pass2 = document.getElementById("password_confirm").value;
        // console.log(pass1);
        // console.log(pass2);
        if (pass1 != pass2) {
            return false;
        } else {
            return true;
        }
    }, "Confirm password didn't match");


    // validate the confirm password field in reset password form
    jQuery.validator.addMethod("reset_confirm_password", function (val, element) {

        var pass1 = document.getElementById("new").value;
        var pass2 = document.getElementById("new_confirm").value;

        if (pass1 != pass2) {
            return false;
        } else {
            return true;
        }
    }, "Confirm password didn't match");



    $.validator.addMethod('positiveNumber', function (value) {
        return Number(value) > 0;
    }, 'Enter the positive number.');

    jQuery.validator.addMethod('chk_username_field', function (value, element, param) {
        if (value.match('^[a-zA-Z0-9-_.]{5,20}$')) {
            return true;
        } else {
            return false;
        }

    }, "");

    jQuery.validator.addMethod('chk_name', function (value, element, param) {
        if (value.match('^[a-zA-Z]{1,20}$')) {
            return true;
        } else {
            return false;
        }

    }, "");

    jQuery.validator.addMethod('email', function (value, element, param) {
        // if ($("#input-email").val() == value) {
        //     return false;
        // } else {
        //     return true;
        // }
        return this.optional(element) || (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/).test(value);

    }, "Please enter the valid email id");

    jQuery.validator.addMethod("numbersonly", function (value, element) {
        return this.optional(element) || /^\$?[0-9][0-9\,]*(\.\d{1,2})?$|^\$?[\.]([\d][\d]?)$/.test(value);
    }, "Please enter valid price.");

    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Please enter valid name");

    jQuery.validator.addMethod("noSpace", function (value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "Please enter valid characters");


    jQuery.validator.addMethod('chk_full_name', function (value, element, param) {
        if (value.match("^[a-zA-Z]([-']?[a-zA-Z]+)*( [a-zA-Z]([-']?[a-zA-Z']+)*)+$")) {
            return true;
        } else {
            return false;
        }

    }, "");
    jQuery.validator.addMethod("validUrl", function (value, element) {
        return this.optional(element) || /^(http(s)?:\/\/)?(www\.)[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/i.test(value);
    }, "Please enter valid url.");

    jQuery.validator.addMethod("phoneno", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && phone_number.length < 15 &&
                phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
    }, "Please enter a valid phone number");


    jQuery.validator.addMethod("specialChars", function (value, element) {
        var regex = new RegExp("^[a-zA-Z0-9.@_-]+$");
        var key = value;
        if (!regex.test(key)) {
            return false;
        }
        return true;
    }, "please enter a valid value for the field.");

    // apply validation rules for login 
    jQuery("#login_form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            },
        },
        messages: {
            product_name: {
                required: 'Please enter product name.',
                lettersonly: "Please enter valid name."
            },
            product_category: {
                required: 'Please select product category.',
                //lettersonly: "Please enter valid name."
            },
            product_quantity: {
                required: 'Please enter product quantity.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            product_price: {
                required: 'Please enter product price.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            product_sku: {
                required: 'Please enter product SKU.',
            },
            product_shipping_region: {
                required: 'Please enter product shipping region.',

            },
            "product_images[]": "Please select product image",
            hover_images: {
                required: 'Please select product hover image.',
            },
            product_desc: {
                required: 'Please enter product description.',
            },
        },
        submitHandler: function (form) {
            //form.submit();
            // $('#btn_submit').css('display', 'none');
            // $('#loader').css('display', 'inline');
            document.getElementById('login_form').submit();
        }
    });


    // apply validation rules for reset password form 
    jQuery("#reset_pwd_form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            new: {
                required: true,
                password_strenth: true
            },
            new_confirm: {
                required: true,
                reset_confirm_password: true
            },
        },
        messages: {            
            product_desc: {
                required: 'Please enter product description.',
            },
        },
        submitHandler: function (form) {
            //form.submit();
            // $('#btn_submit').css('display', 'none');
            // $('#loader').css('display', 'inline');
            document.getElementById('reset_pwd_form').submit();
        }
    });

    // apply validation rules for login 
    jQuery("#login_popup_Form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            },
        },
        messages: {
            product_name: {
                required: 'Please enter product name.',
                lettersonly: "Please enter valid name."
            },
        },
        submitHandler: function (form) {

            // submit form after validation
            $('#st_message').html('');
            $('.login_button').html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="' + base_url + 'image/loader.svg"></button>');

            var MessageManager = {
                show: function (content) {
                    $('#st_message').html(content);
                    window.setTimeout(function () {
                        $('#st_message').html('');
                        $('.login_button').html('<button type="submit" id="login_popup_submit" class="btn kopaBtn btn btn-primary">Submit</button>');
                        // redirect to the checkout page
                        window.location.href = base_url + 'home/checkout';
                    }, 5000);
                }
            };

            var datastring = $("#login_popup_Form").serialize();

            $.ajax({
                url: base_url + 'auth/ajaxLoginSubmit',
                data: datastring,
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if (response.status === '1') {

                        MessageManager.show('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + response.msg + ' <img style="width: 70px;height: 45px;top: 2px;position: absolute;right: 0;" src="' + base_url + 'image/loader.svg"></div>');
                        $('.login_button').html('<button type="submit" id="login_popup_submit" class="btn kopaBtn btn btn-primary">Submit</button>');

                    } else {
                        MessageManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + response.msg + '</div>');
                        $('.login_button').html('<button type="submit" id="login_popup_submit" class="btn kopaBtn btn btn-primary">Submit</button>');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });


    // apply validation rules for registration
    jQuery("#registration_popup_Form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            first_name: {
                required: true,
                valid_firstname: true
            },
            last_name: {
                required: true,
                valid_lastname: true
            },
            register_email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                valid_telephone: true
            },
            reg_password: {
                required: true,
                password_strenth: true
            },
            password_confirm: {
                required: true,
                register_confirm_password: true
            },
        },
        messages: {
            product_name: {
                required: 'Please enter product name.',
                lettersonly: "Please enter valid name."
            },
        },
        submitHandler: function (form) {

            // submit form after validation
            $('#st_message').html('');
            $('.register_button').html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="' + base_url + 'image/loader.svg"></button>');

            var MessageManager = {
                show: function (content) {
                    $('#st_message').html(content);
                    window.setTimeout(function () {
                        $('#st_message').html('');
                        $('.register_button').html('<button type="submit" id="login_popup_submit" class="btn kopaBtn btn btn-primary">Register</button>');
                        // location.reload();
                        window.location.href = base_url + 'home/checkout';
                    }, 5000);
                }
            };

            var datastring = $("#registration_popup_Form").serialize();

            $.ajax({
                url: base_url + 'auth/ajaxUserRegisterSubmit',
                data: datastring,
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if (response.status === '1') {

                        MessageManager.show('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + response.msg + ' <img style="width: 70px;height: 45px;top: 2px;position: absolute;right: 0;" src="' + base_url + 'image/loader.svg"></div>');
                        $('.register_button').html('<button type="submit" id="login_popup_submit" class="btn kopaBtn btn btn-primary">Register</button>');

                    } else {
                        MessageManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + response.msg + '</div>');
                        $('.register_button').html('<button type="submit" id="login_popup_submit" class="btn kopaBtn btn btn-primary">Register</button>');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    // apply validation rules for register user 
    jQuery("#registration_form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            firstname: {
                required: true,
                valid_firstname: true
            },
            lastname: {
                required: true,
                valid_lastname: true
            },
            email: {
                required: true,
                email: true
            },
            telephone: {
                required: true,
                valid_telephone: true
            },
            fax: {
                valid_fax: true
            },
            company: {
                valid_company: true
            },
            address_1: {
                required: true,
                valid_address1: true
            },
            city: {
                required: true
            },
            postcode: {
                required: true,
                valid_postcode: true
            },
            country_id: {
                required: true
            },
            zone_id: {
                required: true
            },
            password: {
                required: true,
                password_strenth: true
            },
            confirm: {
                required: true,
                confirm_password: true
            },
        },
        messages: {
            product_name: {
                required: 'Please enter product name.',
                lettersonly: "Please enter valid name."
            },
            product_category: {
                required: 'Please select product category.',
                //lettersonly: "Please enter valid name."
            },
            product_quantity: {
                required: 'Please enter product quantity.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            product_price: {
                required: 'Please enter product price.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            product_sku: {
                required: 'Please enter product SKU.',
            },
            product_shipping_region: {
                required: 'Please enter product shipping region.',

            },
            "product_images[]": "Please select product image",
            hover_images: {
                required: 'Please select product hover image.',
            },
            product_desc: {
                required: 'Please enter product description.',
            },
        },
        submitHandler: function (form) {
            //form.submit();
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('registration_form').submit();
        }
    });



        // apply validation rules for register user 
    jQuery("#myaccount_form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            my_first_name: {
                required: true,
                valid_firstname: true
            },
            my_last_name: {
                required: true,
                valid_lastname: true
            },
            my_email: {
                required: true,
                email: true
            },
            my_telephone: {
                required: true,
                valid_telephone: true
            },
            my_company: {
                valid_company: true
            },
            my_address: {
                required: true,
                valid_address1: true
            },
            my_city: {
                required: true
            },
            my_state: {
                required: true
            },
            my_postcode: {
                required: true,
                valid_postcode: true
            },
        },
        messages: {
            product_name: {
                required: 'Please enter product name.',
                lettersonly: "Please enter valid name."
            },
        },
        submitHandler: function (form) {
            //form.submit();
            // $('#btn_submit').css('display', 'none');
            // $('#loader').css('display', 'inline');
            document.getElementById('myaccount_form').submit();
        }
    });

    // apply validation rules for forgot password
    jQuery("#forgot_pwd_form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            product_name: {
                required: 'Please enter product name.',
                lettersonly: "Please enter valid name."
            },
            product_category: {
                required: 'Please select product category.',
                //lettersonly: "Please enter valid name."
            },
            product_quantity: {
                required: 'Please enter product quantity.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            product_price: {
                required: 'Please enter product price.',
                numbersonly: "Please enter only digits.",
                positiveNumber: "Please enter positive number only."
            },
            product_sku: {
                required: 'Please enter product SKU.',
            },
            product_shipping_region: {
                required: 'Please enter product shipping region.',

            },
            "product_images[]": "Please select product image",
            hover_images: {
                required: 'Please select product hover image.',
            },
            product_desc: {
                required: 'Please enter product description.',
            },
        },
        submitHandler: function (form) {
            //form.submit();
            $('#btn_submit').css('display', 'none');
            $('#loader').css('display', 'inline');
            document.getElementById('forgot_pwd_form').submit();
        }
    });

    // apply validation rules for forgot password
    jQuery("#services_form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            fullname: {
                required: true,
                valid_fullname: true
            },
            mobile: {
                required: true,
                valid_telephone: true
            },
            manufacturer: {
                required: true,
                valid_manufacturer: true
            },
            modelno: {
                required: true,
                valid_modelno: true
            },
            description: {
                required: true
            }
        },
        messages: {
            product_name: {
                required: 'Please enter product name.',
                lettersonly: "Please enter valid name."
            },
        },
        submitHandler: function (form) {

            // set the loader
            $('.loader').html('<button type="submit" name="services_submit" class="btn" id="services_submit">Loading <img style="width: 40px;height: 20px;" src="image/loader.svg"></button>');

            // get the values here
            var full_name = $('#input-fullname').val();
            var mobile_no = $('#input-mobile').val();
            var model_no = $('#input-modelno').val();
            var manufacturer = $('#input-manufacturer').val();
            var description = $('#input-description').val();
            var selected_store = $("input[name='selected_store']:checked").val();

            var MessageManager = {
                show: function (content) {
                    $('#message_container').html(content);
                    setTimeout(function () {
                        $('#message_container').html('');
                    }, 5000);
                }
            };

            if (selected_store == "" || typeof selected_store === 'undefined') {
                MessageManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> Select the store you want to get the service from.</div>');
                $('.loader').html('<input type="submit" name="services_submit" value="Submit" class="btn btn-primary" id="services_submit">');
                $("input[name='selected_store']").focus();
            } else {
                // set the loader
                $('.loader').html('<button type="submit" name="services_submit" class="btn" id="services_submit">Loading <img style="width: 40px;height: 20px;" src="image/loader.svg"></button>');

                // ajax call
                $.ajax({
                    type: "POST",
                    url: 'home/addServiceRecord',
                    data: {'full_name': full_name, 'mobile_no': mobile_no, 'model_no': model_no, 'manufacturer': manufacturer, 'description': description, 'selected_store': selected_store},
                    dataType: 'json',
                    success: function (response) {
                        // chec if the response status is success
                        if (response.status == 1) {

                            // set the message after successful response
                            MessageManager.show('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + response.message + '</div>');

                            $('.loader').html('<input type="submit" name="services_submit" value="Submit" class="btn btn-primary" id="services_submit">');
                            $('.success_message').css('display', 'block');
                            $('#input-fullname').val('');
                            $('#input-mobile').val('');
                            $('#input-modelno').val('');
                            $('#input-manufacturer').val('');
                            $('#input-description').val('');

                        } else {

                            // set the message after failure response
                            MessageManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + response.message + '</div>');

                            $('.loader').html('<input type="submit" name="services_submit" value="Submit" class="btn btn-primary" id="services_submit">');
                        }
                    }
                });
            }
        }
    });

    // apply validation rules for contact is page
    jQuery("#commentform").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            name: {
                required: true,
                valid_fullname: true
            },
            email: {
                required: true,
                email: true
            },
            enquiry: {
                required: true,
            }
        },
        submitHandler: function (form) {

            // set the loader
            $('.loader').html('<button type="submit" name="contactus_submit" class="btn" id="contactus_submit">Loading <img style="width: 40px;height: 20px;" src="'+ base_url +'frontend/assets/images/loading.svg"></button>');

            // get the values here
            var name = $('#author').val();
            var email = $('#email').val();
            var enquiry = $('#comment').val();

            // ajax call
            $.ajax({
                type: "POST",
                url: 'home/addContactUs',
                data: {'name': name, 'email': email, 'enquiry': enquiry},
                dataType: 'json',
                success: function (response) {
                    var MessageManager = {
                        show: function (content) {
                            $('#message_container').html(content);
                            // setTimeout(function () {
                            //     $('#message_container').html('');
                            // }, 5000);
                        }
                    };

                    if (response.status == 1) {

                        $('.success_message').css('display', 'block');
                        $('#author').val('');
                        $('#email').val('');
                        $('#comment').val('');

                        // set the message after successful response
                        MessageManager.show('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + response.message + '</div>');
                        $('.loader').html('<input type="submit" name="contactus_submit" value="Submit" class="btn btn-primary" id="contactus_submit">');

                    } else {
                        // set the message after failure response
                        MessageManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + response.message + '</div>');
                        $('.loader').html('<input type="submit" name="contactus_submit" value="Submit" class="btn btn-primary" id="contactus_submit">');
                    }
                }
            });
        }
    });



    // apply validation rules for blog post comment form
    jQuery("#blogcommentform").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            blog_author: {
                required: true,
                valid_fullname: true
            },
            blog_email: {
                required: true,
                email: true
            },
            blog_comment: {
                required: true,
            }
        },messages: {
            blog_author: {
                required: 'Please enter the name',
                valid_fullname: "Please enter valid name"
            },
            blog_email: {
                required: 'Please enter the email id',
                email: "Please enter valid email id"
            },
            blog_comment: {
                required: 'Please enter the comment for blog',
            },
        },
        submitHandler: function (form) {

            // set the loader            
            $('.loader_blog').html('<button type="submit" name="blog_comment" value="Post Comment" class="btn btn-secondary">Loading <img style="width: 40px;height: 30px;" src="'+ base_url +'frontend/assets/images/loading.svg"></button>');

            // get the values here
            var blog_author = $('#blog_author').val();
            var blog_email = $('#blog_email').val();
            var blog_comment = $('#blog_comment').val();
            var post_id = $('#post_id').val();

            // ajax call
            $.ajax({
                type: "POST",
                url: base_url + 'home/addBlogComment',
                data: {'blog_author': blog_author, 'blog_email': blog_email, 'blog_comment': blog_comment, 'post_id':post_id},
                dataType: 'json',
                success: function (response) {
                    var MessageManager = {
                        show: function (content) {
                            $('#blog_message').html(content);
                            // setTimeout(function () {
                            //     $('#blog_message').html('');
                            // }, 5000);
                        }
                    };

                    if (response.status == 1) {

                        $('.blog_message').css('display', 'block');
                        $('#blog_author').val('');
                        $('#blog_email').val('');
                        $('#blog_comment').val('');

                        // set the message after successful response
                        MessageManager.show('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + response.message + '</div>');
                        $('.loader_blog').html('<button type="submit" name="blog_comment" value="Post Comment" id="blog_submit" class="btn btn-secondary">POST COMMENT</button>');

                    } else {
                        // set the message after failure response
                        MessageManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + response.message + '</div>');
                        $('.loader_blog').html('<button type="submit" name="blog_comment" value="Post Comment" id="blog_submit" class="btn btn-secondary">POST COMMENT</button>');
                    }
                }
            });
        }
    });

    // apply validation rules for order return page 
    jQuery("#order_return_form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            firstname: {
                required: true,
                valid_firstname: true
            },
            lastname: {
                required: true,
                valid_lastname: true
            },
            email: {
                required: true,
                email: true
            },
            order_id: {
                required: true
            },
            telephone: {
                required: true,
                valid_telephone: true
            },
            product_name: {
                required: true
            },
            product_code: {
                required: true
            },
            quantity: {
                required: true,
                positiveNumber: true
            }
        },
        messages: {
            product_desc: {
                required: 'Please enter product description.',
            },
        },
        submitHandler: function (form) {

            $('.success_message').html('');
            $('.error_message').html('');

            // get the values here
            var firstName = $('#input-firstname').val();
            var lastName = $('#input-lastname').val();
            var email = $('#input-email').val();
            var telephone = $('#input-telephone').val();
            var orderId = $('#input-order-id').val();
            var orderDate = $('#input-date-ordered').val();
            var productName = $('#input-product-name').val();
            var productCode = $('#input-product-code').val();
            var quantity = $('#input-quantity').val();
            var returnReasonId = $("input[name='return_reason_id']:checked").val();
            var productOpened = $("input[name='opened']:checked").val();
            var comments = $('#input-comment').val();

            // ajax call
            $.ajax({
                type: "POST",
                url: 'home/orderReturn',
                data: {'firstname': firstName, 'lastname': lastName, 'email': email, 'telephone': telephone, 'orderId': orderId, 'orderDate': orderDate,
                    'productName': productName, 'productCode': productCode, 'quantity': quantity, 'returnReasonId': returnReasonId, 'productOpened': productOpened,
                    'comments': comments},
                dataType: 'json',
                success: function (response) {
                    if (response.status == 1) {
                        $('.success_message').css('display', 'block');

                        // make all inputs blank after successful submission of form
                        $('#input-firstname').val('');
                        $('#input-lastname').val('');
                        $('#input-email').val('');
                        $('#input-telephone').val('');
                        $('#input-order-id').val('');
                        $('#input-date-ordered').val('');
                        $('#input-product-name').val('');
                        $('#input-product-code').val('');
                        $('#input-quantity').val('');
                        $('#input-comment').val('');

                        $('.success_message').html('<div id="infoMessage" class="alert alert-success">' + response.message + '</div>');
                    } else {
                        $('.error_message').css('display', 'block');
                        $('.error_message').html('<div id="infoMessage" class="alert alert-danger">' + response.message + '</div>');
                    }
                }
            });
        }
    });


    // apply validation rules for checkout page
    jQuery("#checkout_form").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            firstname: {
                required: true
            },
            lastname: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            telephone: {
                required: true,
                positiveNumber: true,
                phoneno: true
            },
            company: {
                required: true
            },
            address_1: {
                required: true,
            },
            city: {
                required: true
            },
            postcode: {
                required: true
            },
            zone_id: {
                required: true
            },
            confirm_agree: {
                required: true
            }
        },
        messages: {
            product_desc: {
                required: 'Please enter product description.',
            },
            confirm_agree: {
                required: 'You need to agree the Terms & Conditions',
            }
        },
        submitHandler: function (form) {

            // check if the paypal payment method is selected
            if ($('#id-paypal').prop('checked')) {
                window.location.replace(base_url + "paypal_buy");

            } else if ($('#id-authorized').prop('checked')) {
                $('#id-confirm-order').prop('disabled',true);
//                return false;
                var data = '';
                // check if the values are blank
                if ($('#card_number').val() == "" || $('#expiry_month').val() == "" || $('#expiry_year').val() == "" || $('#cvv').val() == "") {
                    $('#paypal_message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Enter the card details to continue.</div>');
                    window.scrollTo(1000, 250);
                } else {

                    $('#paypal_message').html('');
                    // var data = $('#payment-form').serialize();
                    var card_number = $('#card_number').val();
                    var expiry_month = $('#expiry_month').val();
                    var expiry_year = $('#expiry_year').val();
                    var cvv = $('#cvv').val();

                    var email = $('#input-payment-email').val();
                    var city = $('#input-payment-city').val();
                    var postcode = $('#input-payment-postcode').val();
                    var address_1 = $('#input-payment-address-1').val();
                    var address_2 = $('#input-payment-address-2').val();

                    $.ajax({
                        url: base_url + 'home/authorized_pay',
                        type: 'POST',
                        data: {'card_number': card_number, 'months': expiry_month, 'year': expiry_year, 'cvv': cvv, 'city': city, 'postcode': postcode, 'address_1': address_1, 'address_2': address_2, 'email': email},
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data);
                            if (data.status === '0') {
                                $('#card_number').val("");
                                $('#expiry_month').val("");
                                $('#expiry_year').val("");
                                $('#cvv').val("");
                                $('#paypal_message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + data.message + ' <b>Note: </b> ' + data.error_message + '</div>');
                                window.scrollTo(1000, 250);
                            } else {
                                window.location.href = base_url + 'authorized_success';
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }

            } else {
                // $('#paypal_message').css("color", 'red');

                $('#card_number').val("");
                $('#expiry_month').val("");
                $('#expiry_year').val("");
                $('#cvv').val("");
                if (data)
                    $('#paypal_message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + data.message + ' <b>Note: </b> ' + data.error_message + '</div>');
                else
                    $('#paypal_message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Note : Please complete validation</div>');
                window.scrollTo(1000, 250);
            }
        }
    });

    // smooth scroll after validation
    function SmoothScroll() {
        $('a.scrollToTop').click(function () {
            $('html, body').animate({
                scrollTop: 0
            }, 2500);

            return false;
        });
    }

    // apply validation rules for review
    jQuery("#form_review_id").validate({
        debug: true,
        errorElement: 'div',
        errorClass: 'text-danger',
        rules: {
            rating: {
                required: true,
            },
            input_review: {
                required: true,
            },

        },
        messages: {

        },
        submitHandler: function (form) {

        }
    });
});