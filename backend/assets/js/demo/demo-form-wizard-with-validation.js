(function($) {
  "use strict";
  
  $(function(){
    // Initializing Icheck
    $('input.icheck-minimal-grey').iCheck({
      checkboxClass: 'icheckbox_minimal-grey',
      radioClass: 'iradio_minimal-grey'
    });

    // Initializing Select2
    $("select").select2({
      theme: "bootstrap",
      allowClear: true,
      placeholder: 'Select...'
    });

    // Bootstrap wizard default settings
    $.fn.bootstrapWizard.defaults.tabClass = "";
    $.fn.bootstrapWizard.defaults.previousSelector = ".btn-prev";
    $.fn.bootstrapWizard.defaults.nextSelector = ".btn-next";
    $.fn.bootstrapWizard.defaults.lastSelector = ".btn-finish";

    jQuery.validator.addMethod("compare_price", function (val, element) {
        var pass1 = parseFloat(document.getElementById("product_price").value);
        var pass2 = parseFloat(document.getElementById("product_discounted_price").value);

        if(pass2 !== "" && !isNaN(pass2)) {
          // console.log("here i am"+pass2);

          if (pass1 > pass2) {
              return true;
          } else {
              return false;
          }
        } else {
            return true;
        }
    });

    // jQuery.validator.addMethod("validateSKU", function (val, element) {

    //     var product_sku_value = document.getElementById("product_sku").value;
    //     var base_url = $('#base_url').val();
    //     var flag = true;
    //     // ajax call
    //     $.ajax({
    //         type: "POST",
    //         url: base_url + 'admin/validateSKUNumber',
    //         dataType:'json',
    //         data: {'sku_number':product_sku_value},
    //         success: function (response) {
    //             // alert(response.status);
    //             flag = response.status;
    //             // if(response.status == '0') {
    //             //   flag = false;
    //               // alert('true');

    //               // return false;
    //             // }
    //             // } else {
    //             //   alert('false');
    //             //     return false;
    //             // }
    //             // console.log(response);
    //         }
    //     });

    //     // alert(flag);
    //     return flag;

    //     // if (pass1 > pass2) {
    //     //     return true;
    //     // } else {
    //     //     return false;
    //     // }
    // });

    jQuery.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    });
   

    // Example #1
    // Creating validation rules
    var wizardArrow = $("#wizard-arrow");
    var validatorArrow = wizardArrow.validate({
      // Validation rules
      // Selecting input by name attribute
      rules: {
        product_name: {
            required: true,
            minlength: 5,
            maxlength: 50
        },
        short_description: {
          required: true,
          minlength: 5,
          maxlength: 100
        },
        description: {
          required: true,
          minlength: 5,
          // maxlength: 300
        },
        product_category: {
          required: true
        },
        // product_subcategory: {
        //   required: true
        // },
        product_quantity: {
          required: true,
          digits: true,
          maxlength: 5
        },
        product_price: {
          required: true,
          number: true,
          maxlength: 9
        },
        product_discounted_price: {
          // required: true,
          number: true,
          maxlength: 9,
          compare_price:true
        },
        product_sku: {
          required: true,
          // remote: {
          //     message: 'The SKU is not available',
          //     url: $('#base_url').val() + 'admin/validateSKUNumber',
          //     data: {'sku_number':document.getElementById("product_sku").value},
          //     type: 'POST',
              
          // }
        },
        inputZip1: {
          required: true,
          minlength: 2,
          digits: true
        },
        inputCreditCard1: {
          required: true,
          minlength: 16,
          digits: true
        },
        year1: {
          required: true
        },
        terms1: {
          required: true
        },    
        rent_per_month: {
          required: true
        },
        select_plan: {
          required: true
        },
        product_security_deposite: {
          required: true
        },
        product_brands:{
          required: true
        }
      },
      // Error messages
      messages: {
        product_name: "Product Name - ( required | min 5 chars | max 50 chars )",
        short_description: "Product Short Description - ( required | min 5 chars | max 100 chars )",
        description: "Product Description - ( required )",
        product_category: "Product Category - ( required)",
        // product_subcategory: "Product Subcategory - ( required )",
        product_quantity: "Product Quantity - ( required | digits only )",
        product_price: "Product Price - ( required | numbers only )",
        product_discounted_price: {
            // required : "Product Discounted Price - ( required | numbers only )",
            compare_price:"Product discounted price must be less than price"
        },
        product_sku: {
          required:"Product SKU - ( required )",
          valid:"SKU number is already exists"
        },
        year1: "Credit card year of expiration is required",
        terms1: "You should agree to our Terms Of Use"
      },
      highlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').addClass('has-error');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error');
      },
      // Class that wraps error message
      errorClass: "help-block",
      // Element that wraps error message
      errorElement: "div",
      errorPlacement: function(error, element) {
        $(element).closest(".form-group").find('> :last-child').append(error);

        // Select2 validation
        $("select").on("change", function() {
          // alert('here i am');
          var select2Valid = $(this).valid();
          // If clicked on clear button
          if(!select2Valid){
            $(this).closest('.form-group').removeClass("has-success").addClass("has-error");
          }
        });

        // For Icheck we need revalidate
        if( $(element).is(':checkbox') || $(element).is(':radio') ){
          $(element).on('ifChecked ifUnchecked', function(e){
            validatorArrow.element($(element));
          });
        }
      },
      success: function(helpBlock) {
        if( $(helpBlock).closest(".form-group").hasClass('has-error') ){
          $(helpBlock).closest(".form-group").removeClass("has-error").addClass("has-success");
        }
      }
    });

    // Initializing Bootstrap-wizard plugin
    wizardArrow.bootstrapWizard({
      onTabShow: function(tab, navigation, index){
        // Showing/hiding finish button
        var $total = navigation.children().length;
        var $current = index+1;
        // If it's the last tab then hide the last button and show the finish instead
        if($current >= $total) {
          wizardArrow.find('.btn-next').addClass("none");
          wizardArrow.find('.btn-finish').removeClass("none");
        }else{
          wizardArrow.find('.btn-next').removeClass("none");
          wizardArrow.find('.btn-finish').addClass("none");
        }
      },
      onTabClick: function(tab, navigation, index) {
        return false;
      },
      onNext: function(tab, navigation, index) {
        var valid = wizardArrow.valid();
        if(!valid) {
          validatorArrow.focusInvalid();
          return false;
        }
      },
      onLast: function(tab, navigation, index) {
          var valid = wizardArrow.valid();
          if(!valid) {
            validatorArrow.focusInvalid();
            return false;
          } else {
              
              // var form_data = $('#payment-form').serialize();

              // var base_url = $('#base_url').val();

              // // ajax call
              // $.ajax({
              //     url: base_url + 'admin/ajaxAddProduct',
              //     data: form_data,
              //     contentType: false,
              //     cache: false,
              //     processData:false,
              //     success: function (response) {
              //         // console.log(response);
              //     }
              // });
              // alert("You have successfully finished the step wizard");
          }
        }
    });


        // Example #1
    // Creating validation rules
    // var popupBuyCategory = $("#add_buy_category");
    // var validatorArrow = popupBuyCategory.validate({
    //   // Validation rules
    //   // Selecting input by name attribute
    //   rules: {
    //     category_name: {
    //       required: true,
    //       minlength: 5,
    //       maxlength: 50
    //     },
    //     category_description: {
    //       required: true,
    //       minlength: 5,
    //       maxlength: 50
    //     },
    //     category_attribute: {
    //       required: true,
    //     },
    //   },
    //   // Error messages
    //   messages: {
    //       category_name: "Product Name - ( required | min 5 chars | max 50 chars )",
    //       category_description: "Product Short Description - ( required | min 5 chars | max 50 chars )",
    //       category_attribute: "Product Description - ( required )",
    //   },
    //   highlight: function(element, errorClass, validClass) {
    //     $(element).closest('.form-group').addClass('has-error');
    //   },
    //   unhighlight: function(element, errorClass, validClass) {
    //     $(element).closest('.form-group').removeClass('has-error');
    //   },
    //   // Class that wraps error message
    //   errorClass: "help-block",
    //   // Element that wraps error message
    //   errorElement: "div",
    //   errorPlacement: function(error, element) {
    //     $(element).closest(".form-group").find('> :last-child').append(error);

    //     // Select2 validation
    //     $("select").on("change", function(){
    //       var select2Valid = $(this).valid();
    //       // If clicked on clear button
    //       if(!select2Valid){
    //         $(this).closest('.form-group').removeClass("has-success").addClass("has-error");
    //       }
    //     });

    //   },
    //   success: function(helpBlock) {
    //     if( $(helpBlock).closest(".form-group").hasClass('has-error') ){
    //       $(helpBlock).closest(".form-group").removeClass("has-error").addClass("has-success");
    //     }
    //   }
    // });

    // // Initializing Bootstrap-wizard plugin
    // popupBuyCategory.bootstrapWizard({
    //   onTabShow: function(tab, navigation, index){
    //     // Showing/hiding finish button
    //     var $total = navigation.children().length;
    //     var $current = index+1;
    //     // If it's the last tab then hide the last button and show the finish instead
    //     if($current >= $total) {
    //       popupBuyCategory.find('.btn-next').addClass("none");
    //       popupBuyCategory.find('.btn-finish').removeClass("none");
    //     }else{
    //       popupBuyCategory.find('.btn-next').removeClass("none");
    //       popupBuyCategory.find('.btn-finish').addClass("none");
    //     }
    //   },
    //   onTabClick: function(tab, navigation, index) {
    //     return false;
    //   },
    //   onNext: function(tab, navigation, index) {
    //     var valid = popupBuyCategory.valid();
    //     if(!valid) {
    //       validatorArrow.focusInvalid();
    //       return false;
    //     }
    //   },
    //   onLast: function(tab, navigation, index) {
    //       var valid = popupBuyCategory.valid();
    //       if(!valid) {
    //         validatorArrow.focusInvalid();
    //         return false;
    //       } else {
              
    //           // var form_data = $('#payment-form').serialize();

    //           // var base_url = $('#base_url').val();

    //           // // ajax call
    //           // $.ajax({
    //           //     url: base_url + 'admin/ajaxAddProduct',
    //           //     data: form_data,
    //           //     contentType: false,
    //           //     cache: false,
    //           //     processData:false,
    //           //     success: function (response) {
    //           //         // console.log(response);
    //           //     }
    //           // });
    //           // alert("You have successfully finished the step wizard");
    //       }
    //     }
    // });
    
    // Example #2
    // Creating validation rules
    var wizardRect = $("#wizard-rect");
    var validatorRect = wizardRect.validate({
      // Validation rules
      // Selecting input by name attribute
      rules: {
        inputName2: {
          required: true,
          minlength: 5
        },
        inputEmail2: {
          email: true,
          required: true,
          minlength: 5
        },
        inputPassword2: {
          required: true,
          minlength: 5
        },
        inputAddress2: {
          required: true
        },
        inputCity2: {
          required: true
        },
        country2: {
          required: true
        },
        inputZip2: {
          required: true,
          minlength: 2,
          digits: true
        },
        inputCreditCard2: {
          required: true,
          minlength: 16,
          digits: true
        },
        year2: {
          required: true
        },
        terms2: {
          required: true
        }
      },
      // Error messages
      messages: {
        inputName2: "Full Name is required ( at least 5 characters )",
        inputEmail2: "Email is required ( at least 5 characters )",
        inputPassword2: "Password is required ( at least 5 characters )",
        inputAddress2: "Address is required",
        inputCity2: "City is required",
        country2: "Country is required",
        inputZip2: "Zip is required",
        inputCreditCard2: "Credit card number is required ( 16 digits )",
        year2: "Credit card year of expiration is required",
        terms2: "You should agree to our Terms Of Use"
      },
      highlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').addClass('has-error');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error');
      },
      // Class that wraps error message
      errorClass: "help-block",
      // Element that wraps error message
      errorElement: "div",
      errorPlacement: function(error, element) {
        $(element).closest(".form-group").find('> :last-child').append(error);

        // Select2 validation
        $("select").on("change", function(){
          var select2Valid = $(this).valid();
          // If clicked on clear button
          if(!select2Valid){
            $(this).closest('.form-group').removeClass("has-success").addClass("has-error");
          }
        });

        // For Icheck we need revalidate
        if( $(element).is(':checkbox') || $(element).is(':radio') ){
          $(element).on('ifChecked ifUnchecked', function(e){
            validatorArrow.element($(element));
          });
        }
      },
      success: function(helpBlock) {
        if( $(helpBlock).closest(".form-group").hasClass('has-error') ){
          $(helpBlock).closest(".form-group").removeClass("has-error").addClass("has-success");
        }
      }
    });

    // Initializing Bootstrap-wizard plugin
    wizardRect.bootstrapWizard({
      onTabShow: function(tab, navigation, index){
        // Showing/hiding finish button
        var $total = navigation.children().length;
        var $current = index+1;
        // If it's the last tab then hide the last button and show the finish instead
        if($current >= $total) {
          wizardRect.find('.btn-next').addClass("none");
          wizardRect.find('.btn-finish').removeClass("none");
        }else{
          wizardRect.find('.btn-next').removeClass("none");
          wizardRect.find('.btn-finish').addClass("none");
        }
      },
      onTabClick: function(tab, navigation, index) {
        return false;
      },
      onNext: function(tab, navigation, index) {
        var valid = wizardRect.valid();
        if(!valid) {
          validatorRect.focusInvalid();
          return false;
        }
      },
      onLast: function(tab, navigation, index) {
        var valid = wizardRect.valid();
        if(!valid) {
          validatorRect.focusInvalid();
          return false;
        }else{
          alert("You have successfully finished the step wizard");
        }
      }
    });

    // Example #3
    // Creating validation rules
    var wizardCircle = $("#wizard-circle");
    var validatorCircle = wizardCircle.validate({
      // Validation rules
      // Selecting input by name attribute
      rules: {
        inputName3: {
          required: true,
          minlength: 5
        },
        inputEmail3: {
          email: true,
          required: true,
          minlength: 5
        },
        inputPassword3: {
          required: true,
          minlength: 5
        },
        inputAddress3: {
          required: true
        },
        inputCity3: {
          required: true
        },
        country3: {
          required: true
        },
        inputZip3: {
          required: true,
          minlength: 2,
          digits: true
        },
        inputCreditCard3: {
          required: true,
          minlength: 16,
          digits: true
        },
        year3: {
          required: true
        },
        terms3: {
          required: true
        }
      },
      // Error messages
      messages: {
        inputName3: "Full Name is required ( at least 5 characters )",
        inputEmail3: "Email is required ( at least 5 characters )",
        inputPassword3: "Password is required ( at least 5 characters )",
        inputAddress3: "Address is required",
        inputCity3: "City is required",
        country3: "Country is required",
        inputZip3: "Zip is required",
        inputCreditCard3: "Credit card number is required ( 16 digits )",
        year3: "Credit card year of expiration is required",
        terms3: "You should agree to our Terms Of Use"
      },
      highlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').addClass('has-error');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error');
      },
      // Class that wraps error message
      errorClass: "help-block",
      // Element that wraps error message
      errorElement: "div",
      errorPlacement: function(error, element) {
        $(element).closest(".form-group").find('> :last-child').append(error);

        // Select2 validation
        $("select").on("change", function(){
          var select2Valid = $(this).valid();
          // If clicked on clear button
          if(!select2Valid){
            $(this).closest('.form-group').removeClass("has-success").addClass("has-error");
          }
        });

        // For Icheck we need revalidate
        if( $(element).is(':checkbox') || $(element).is(':radio') ){
          $(element).on('ifChecked ifUnchecked', function(e){
            validatorCircle.element($(element));
          });
        }
      },
      success: function(helpBlock) {
        if( $(helpBlock).closest(".form-group").hasClass('has-error') ){
          $(helpBlock).closest(".form-group").removeClass("has-error").addClass("has-success");
        }
      }
    });

    // Initializing Bootstrap-wizard plugin
    wizardCircle.bootstrapWizard({
      onTabShow: function(tab, navigation, index){
        // Showing/hiding finish button
        var $total = navigation.children().length;
        var $current = index+1;
        // If it's the last tab then hide the last button and show the finish instead
        if($current >= $total) {
          wizardCircle.find('.btn-next').addClass("none");
          wizardCircle.find('.btn-finish').removeClass("none");
        }else{
          wizardCircle.find('.btn-next').removeClass("none");
          wizardCircle.find('.btn-finish').addClass("none");
        }
      },
      onTabClick: function(tab, navigation, index) {
        return false;
      },
      onNext: function(tab, navigation, index) {
        navigation.find(".step-item-circle").eq(index - 1).addClass("done");

        var valid = wizardCircle.valid();
        if(!valid) {
          validatorCircle.focusInvalid();
          return false;
        }
      },
      onLast: function(tab, navigation, index) {
        var valid = wizardCircle.valid();
        if(!valid) {
          validatorCircle.focusInvalid();
          return false;
        }else{
          alert("You have successfully finished the step wizard");
        }
      },
      onPrevious: function(tab, navigation, index) {
        tab.removeClass("done");
      }
    });

    // Example #4
    // Creating validation rules
    var wizardLine = $("#wizard-line");
    var validatorLine = wizardLine.validate({
      // Validation rules
      // Selecting input by name attribute
      rules: {
        inputName4: {
          required: true,
          minlength: 5
        },
        inputEmail4: {
          email: true,
          required: true,
          minlength: 5
        },
        inputPassword4: {
          required: true,
          minlength: 5
        },
        inputAddress4: {
          required: true
        },
        inputCity4: {
          required: true
        },
        country4: {
          required: true
        },
        inputZip4: {
          required: true,
          minlength: 2,
          digits: true
        },
        inputCreditCard4: {
          required: true,
          minlength: 16,
          digits: true
        },
        year4: {
          required: true
        },
        terms4: {
          required: true
        }
      },
      // Error messages
      messages: {
        inputName4: "Full Name is required ( at least 5 characters )",
        inputEmail4: "Email is required ( at least 5 characters )",
        inputPassword4: "Password is required ( at least 5 characters )",
        inputAddress4: "Address is required",
        inputCity4: "City is required",
        country4: "Country is required",
        inputZip4: "Zip is required",
        inputCreditCard4: "Credit card number is required ( 16 digits )",
        year4: "Credit card year of expiration is required",
        terms4: "You should agree to our Terms Of Use"
      },
      highlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').addClass('has-error');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error');
      },
      // Class that wraps error message
      errorClass: "help-block",
      // Element that wraps error message
      errorElement: "div",
      errorPlacement: function(error, element) {
        $(element).closest(".form-group").find('> :last-child').append(error);

        // Select2 validation
        $("select").on("change", function(){
          var select2Valid = $(this).valid();
          // If clicked on clear button
          if(!select2Valid){
            $(this).closest('.form-group').removeClass("has-success").addClass("has-error");
          }
        });

        // For Icheck we need revalidate
        if( $(element).is(':checkbox') || $(element).is(':radio') ){
          $(element).on('ifChecked ifUnchecked', function(e){
            validatorLine.element($(element));
          });
        }
      },
      success: function(helpBlock) {
        if( $(helpBlock).closest(".form-group").hasClass('has-error') ){
          $(helpBlock).closest(".form-group").removeClass("has-error").addClass("has-success");
        }
      }
    });

    // Initializing Bootstrap-wizard plugin
    wizardLine.bootstrapWizard({
      onTabShow: function(tab, navigation, index){
        // Showing/hiding finish button
        var $total = navigation.children().length;
        var $current = index+1;
        // If it's the last tab then hide the last button and show the finish instead
        if($current >= $total) {
          wizardLine.find('.btn-next').addClass("none");
          wizardLine.find('.btn-finish').removeClass("none");
        }else{
          wizardLine.find('.btn-next').removeClass("none");
          wizardLine.find('.btn-finish').addClass("none");
        }
      },
      onTabClick: function(tab, navigation, index) {
        return false;
      },
      onNext: function(tab, navigation, index) {
        var valid = wizardLine.valid();
        if(!valid) {
          validatorLine.focusInvalid();
          return false;
        }
      },
      onLast: function(tab, navigation, index) {
        var valid = wizardLine.valid();
        if(!valid) {
          validatorLine.focusInvalid();
          return false;
        }else{
          alert("You have successfully finished the step wizard");
        }
      }
    });
  })
})(jQuery);