// Example of adding a item to the cart via a link.
function addToCart(id) {

    var base_url = $('#base_url').val();
    var item_id = $('#item_id_' + id).val();
    var name = $('#name_' + id).val();
    var price = $('#price_' + id).val();
    var item_url = $('#img_url_' + id).val();
    var quantity = $('#input-quantity').val();
    var rent_product_id = $('#rent_product_id').val();

    if(rent_product_id === null || rent_product_id === undefined) {        
        var rent_id = '0';
        var rent_duration = '0';
        var rent_basic = '0';
        var rent_duration_val = '0';
        var rent_duration_param = '0';
    } else {
        var rent_id = '1';
        // var rent_start_date = $('#rent_start_date_'+ id).val();
        var rent_basic = $('#rent_basic_' + id).val();
        var start_date = $('#datetimepicker1').val();
        var rent_duration = $('#rent_duration_'+ id).val();
        var rent_duration_val = $('#rent_duration_val').val();
        var rent_duration_param = $('#rent_duration_param').val();
    }

    var stock_quantity = $('#stock_' + id).val();

    if($('#check_rent_date').val() == '1') {
        var duration = $('#duration').val();

        if(start_date == "" || duration == "") {
            $.toaster({priority: 'danger', title: 'Cart', message: 'Select the Start Date & Duration'});
            return false;
        }
    }

    if (stock_quantity < 1) {
        $.toaster({priority: 'danger', title: 'Cart', message: 'Product is out of Stock.'});
        return false;
    }

    // ajax call
    $.ajax({
        method: "POST",
        data: {'item_id': item_id, 'price': price, 'name': name, 'item_url': item_url, 'quantity':quantity, 'rent_id':rent_id, 'rent_duration':rent_duration, 'rent_start_date':start_date, 'rent_duration_val':rent_duration_val, 'rent_duration_param':rent_duration_param, 'rent_basic':rent_basic},
        url: base_url + "standard_library/insert_ajax_link_item_to_cart/" + id,
        success: function(data) {
            console.log(data);

            var parsed = $.parseJSON(data);

            // update the mini cart dropdown after adding item in to the cart
            fucnUpdateMiniCart(item_id, null, price, null);

            // set the count for cart
            $('.subno').text(parsed.cart_count);

            $.toaster({ priority: 'success', title: 'Cart', message: 'Product has added to the cart.' });
            return false;
        }
    });
}

$('.checkout_btn_preorder').click(function(e) {

    e.preventDefault();
    
    var base_url = $('#base_url').val();

    // ajax call
    $.ajax({
        method: "POST",
        data: {},
        url: base_url + "home/checkOrderInCart",
        success: function(data) {
            console.log(data);
            var parsed = $.parseJSON(data);

            if(parsed.status == '1') {
                $('.multiple_order_message').html('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> '+ parsed.message +'</div>');
            } else if(parsed.status == '0' && parsed.message !== "" || parsed.message == 'undefined') {
                $('.multiple_order_message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> '+ parsed.message +'</div>');
            } else {
                console.log($('#shipping_zipcode').val());
                if($('#shipping_zipcode').val() == "") {
                    $('#shipping_zipcode').focus();
                    $('#shipping_zipcode').css('border', '1px solid red');
                } else {
                    // redirect to the checkout page
                    window.location.href = base_url + 'home/checkout';
                }
            }
        }
    });        
});

function getSelectedDuration(product_id) {

    var date_condition = $('#date_condition').val();
    var calculate_rent = $('#calculate_rent').val();
    
    var duration = $('#duration').val();
    var start_date = $('#datetimepicker1').val();

    // if(start_date == "" || start_date == 'undefined') {
    //     $('#datetimepicker1').focus();
    // } else {

        $('#rent_duration_val').val(duration);

        $('#rent_start_date_'+ product_id).val(start_date);

        if(date_condition == '1') {
            var total_rent = calculate_rent*duration;
            $("#rent_duration_" + product_id).val('For ' + duration + ' day(s)');
            $('#rent_duration_param').val('day');

        } else if(date_condition == '7') {
            var total_rent = calculate_rent*duration;
            $("#rent_duration_" + product_id).val('For ' + duration + ' Week(s)');
            $('#rent_duration_param').val('week');

        } else if(date_condition == '30') {
            var total_rent = calculate_rent*duration;
            $("#rent_duration_" + product_id).val('For ' + duration + ' Month(s)');
            $('#rent_duration_param').val('month');

        } else if(date_condition == '365') {
            var total_rent = calculate_rent*duration;
            $("#rent_duration_" + product_id).val('For ' + duration + ' Year(s)');
            $('#rent_duration_param').val('year');
        }


        console.log(total_rent);
        // var rent_product_id = $('#rent_product_id').val();
        $("#price_"+ product_id).val(total_rent);
    // }
}


// update the mini cart dropdown after adding item in to the cart 
function fucnUpdateMiniCart(item_id, name, price, item_url)
{
    var base_url = $('#base_url').val();
    // ajax request
    $.ajax({
        method: "POST",
        url: base_url + "home/update_header_cart/",
        success: function (data)
        {
            // parse json
            var parsed = $.parseJSON(data);
            // set the header content
            $('#mini_cart_data').html('');
            $('#mini_cart_data').html(parsed.content);
            return false;
        }
    });
}


// remove item from cart
function funDeleteCartProduct(itemId, delete_price)
{
    var base_url = $('#base_url').val();
    var total_pre_price = parseInt($("#total_price").text());
    $("#total_price").text(total_pre_price - delete_price);
    $('.multiple_order_message').html('');

    $.ajax({
        method: "POST",
        data: {'item_id': itemId},
        url: base_url + "standard_library/delete_item/" + itemId,
        success: function (data)
        {
            var parsed = $.parseJSON(data);

            $("#delete_cart_" + itemId).remove();

            // update the mini cart dropdown after adding item in to the cart
            fucnUpdateMiniCart(itemId, null, total_pre_price, null);

            // set the count for cart
            $('.subno').text(parsed.cart_count);

            $('.box-cart-total .sub_total strong').text(parseInt($('.box-cart-total .sub_total strong').text()) - delete_price);
            $('.order-total .grand_total strong').text(parseInt($('.order-total .grand_total strong').text()) - delete_price);

            if(parsed.cart_count == 0) {
                $('.cart_detail_view_hide').html('<div class="page-title-wrapper cart_detail_view rokan-product-heading col-md-12"><h2>Shopping Cart</h2><p>Your shopping cart is empty</p><br><br><a href="' + base_url + '" class="button red">CONTINUE SHOPPING</a></div>');
                // $('.cart_detail_view').html();
            }

            $.toaster({priority: 'danger', title: 'Cart', message: 'Product has removed from cart.'});

        }
    });
}


// Example of adding a item to the cart via a link.
function addToWishList(product_id, category_id) {

    var base_url = $('#base_url').val();

    // ajax call
    $.ajax({
        method: "POST",
        data: {'category_id': category_id, 'product_id': product_id},
        url: base_url + "home/addToWishList",
        success: function(response) {

            var parsed = $.parseJSON(response);

            // console.log(parsed);
            if(parsed.status == '0') {
                $.toaster({ priority: 'danger', title: 'Wishlist', message: parsed.message });
                return false;
            } else {
                // set the count for cart
                var wishlist_count = parseInt($('.wish_subno').text());
                $('.wish_subno').text(parsed.data);

                $.toaster({ priority: 'success', title: 'Wishlist', message: parsed.message });
                return false;
            }
        }
    });
}

// remove product from wishlist
function removeFromWishlist(id) {
    // get the base url
    var base_url = $('#base_url').val();

    // ajax call
    $.ajax({
        method: "POST",
        data: {'product_id': id},
        url: base_url + "home/removeWishListProduct",
        success: function(data) {

            var parsed = $.parseJSON(data);
            // console.log(parsed);
            if(parsed.status == '0') {
                $.toaster({ priority: 'danger', title: 'Wishlist', message: parsed.message });
                return false;
            } else {

                $('#remove_tr_'+id).remove();

                // set the count for wishlist
                var wishlist_count = parseInt($('.wish_subno').text());
                wishlist_count = wishlist_count-1;
                $('.wish_subno').text(wishlist_count);

                if(wishlist_count <= 0) {
                    $('.wishlist_table tbody').html('<tr><td>Your Wishlist is empty</td></tr>');
                }

                $.toaster({ priority: 'success', title: 'Wishlist', message: parsed.message });
                return false;
            }
        }
    });
}

$('select[name="shipping_country_id"]').change(function () {
    
    var country_id = $(this).val();
    // get the base url
    var base_url = $('#base_url').val();

    $.ajax({
        type: "POST",
        url: base_url + 'home/getStateList',
        data: {'country_id': country_id},
        success: function (data) {
            if (data) {
                $('select[name="shipping_zone_id"]').html(data.content).trigger('liszt:updated').val(country_id);
            }
        }
    });
});

$('select[name="country_id"]').change(function () {
    
    var country_id = $(this).val();
    // get the base url
    var base_url = $('#base_url').val();

    $.ajax({
        type: "POST",
        url: base_url + 'home/getStateList',
        data: {'country_id': country_id},
        success: function (data) {
            if (data) {
                $('select[name="zone_id"]').html(data.content).trigger('liszt:updated').val(country_id);
            }
        }
    });
});


$('select[name="billing_country_id"]').change(function () {
    
    var country_id = $(this).val();
    // get the base url
    var base_url = $('#base_url').val();

    $.ajax({
        type: "POST",
        url: base_url + 'home/getStateList',
        data: {'country_id': country_id},
        success: function (data) {
            if (data) {
                $('select[name="billing_zone_id"]').html(data.content).trigger('liszt:updated').val(country_id);
            }
        }
    });
});


// save address on checkkout page
$('.checkout_save_address').click(function(e) {

    e.preventDefault();

    // get the base url
    var base_url = $('#base_url').val();

    $('.checkout_save_address').text('Loading . . .');

    // get the billing address
    var shippingaddress = $('#shippingaddress').val();
    // var shippingcountry = $('#shipping_input_country').val();
    var shippingcity = $('#shippingcity').val();
    var shippingstate = $('#shipping_input_zone').val();
    var shippingpostcode = $('#shippingpostcode').val();
    var shippingtelephone = $('#shippingtelephone').val();

    // get the shiping address
    var billingaddress = $('#billingaddress').val();
    // var billingcountry = $('#billing_input_country').val();
    var billingcity = $('#billingcity').val();
    var billingstate = $('#billing_input_zone').val();
    var billingpostcode = $('#billingpostcode').val();
    var billingtelephone = $('#billingtelephone').val();
    
    if(shippingaddress == "" || shippingcity == "" || shippingstate == "" || shippingpostcode == "" || shippingtelephone == "") {
        $.toaster({priority: 'danger', title: 'Checkout', message: 'Enter all the values of shipping address'});
        return false;
    } else if(billingaddress == "" || billingcity == "" || billingstate == "" || billingpostcode == "" || billingtelephone == "") {
        $.toaster({priority: 'danger', title: 'Checkout', message: 'Enter all the values of billing address'});
        return false;
    } else {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'home/saveCheckoutAddress',
            datType:'json',
            data: {'shippingaddress':shippingaddress, 'shippingcity':shippingcity, 'shippingstate':shippingstate, 'shippingpostcode':shippingpostcode, 'shippingtelephone':shippingtelephone, 'billingaddress':billingaddress,'billingcity':billingcity, 'billingstate':billingstate, 'billingpostcode':billingpostcode, 'billingtelephone':billingtelephone},
            success: function (data) {

                // var parsed = $.parseJSON(data);
                setTimeout(function () {
                    $.toaster({priority: 'success', title: 'Checkout', message: data.message});
                    window.location.href = base_url + "home/checkout";
                }, 3000);

                // $('.checkout_save_address').text('Address Saved');
                // var parsed = $.parseJSON(data);
                // console.log(parsed.content);
                // $('.product_filter').html(parsed.content);
            }
        });
    }
});

// rate the product and write the comments for it
$('.review_form').on('click', '#submit_review', function (e) {
// $('#submit_review').click(function(e) {

    e.preventDefault();

     // get the base url
    var base_url = $('#base_url').val();

    // alert('here iam');
    $('#review_submit_btn').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button><button type="button" id="submit_review" class="btn btn-primary"><img style="height: 20px;" src="'+ base_url +'frontend/assets/images/loading.svg"></button>');

    var review_name = $("#review_name").val();
    // var review_email = $("#review_email").val();
    var review_message = $("#review_message").val();
    var product_id = $("#review_product_id").val();
    var selected_starts = $("#selected_starts").val();

    var MessageManager = {
        show: function (content) {
            $('.review_message_container').html(content);
            setTimeout(function () {
                $('.review_message_container').html('');
                $('#review_submit_btn').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button><button type="button" id="submit_review" class="btn btn-primary">SUBMIT</button>');
                window.location.href = base_url + "home/product_detail/" + product_id ;
            }, 2000);

        }
    };

    var MessageErrorManager = {
        show: function (content) {
            $('.review_message_container').html(content);
            setTimeout(function () {
                $('.review_message_container').html('');
                $('#review_submit_btn').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button><button type="button" id="submit_review" class="btn btn-primary">SUBMIT</button>');
            }, 4000);
        }
    };

    if(review_name == "" || review_message == "" || selected_starts == "0") {
        MessageErrorManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> All fields are required </div>');
    } else {

        // ajax call for adding the product reviews
        $.ajax({
            url: base_url + 'home/addProductReview',
            data: {'review_name': review_name, 'review_message': review_message, 'product_id':product_id, 'selected_starts':selected_starts},
            type: 'POST',
            dataType: 'JSON',
            success: function (response) {
                if (response.status === '1') {
                    MessageManager.show('<div class="alert alert-success"><i class="fa fa-check-circle"></i> Thank you ! Your review added successfully.</div>');
                } else {
                    MessageErrorManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + response.message + '</div>');
                    // $('.update_shipping_rate').html('<input type="button" value="Get Quotes" id="button-quote" data-loading-text="Loading..." class="btn btn-primary getShippingInfo">');
                }
            }, error: function (error) {
                console.log(error);
            }
        });
    }
});


// rate the product and write the comments for it
$('.rent_review_form').on('click', '#rent_submit_review', function (e) {
// $('#submit_review').click(function(e) {

    e.preventDefault();

     // get the base url
    var base_url = $('#base_url').val();

    // alert('here iam');
    $('#rent_review_submit_btn').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button><button type="button" id="rent_submit_review" class="btn btn-primary"><img style="height: 20px;" src="'+ base_url +'frontend/assets/images/loading.svg"></button>');

    var review_name = $("#rent_review_name").val();
    // var review_email = $("#review_email").val();
    var review_message = $("#rent_review_message").val();
    var product_id = $("#review_product_id").val();
    var selected_starts = $("#rent_selected_starts").val();

    var MessageManager = {
        show: function (content) {
            $('.rent_review_message_container').html(content);
            setTimeout(function () {
                $('.rent_review_message_container').html('');
                $('#rent_review_submit_btn').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button><button type="button" id="rent_submit_review" class="btn btn-primary">SUBMIT</button>');
                window.location.href = base_url + "home/rent_product_detail/" + product_id ;
            }, 2000);

        }
    };

    var MessageErrorManager = {
        show: function (content) {
            $('.review_message_container').html(content);
            setTimeout(function () {
                $('.rent_review_message_container').html('');
                $('#rent_review_submit_btn').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button><button type="button" id="rent_submit_review" class="btn btn-primary">SUBMIT</button>');
            }, 4000);
        }
    };

    if(review_name == "" || review_message == "" || selected_starts == "0") {
        MessageErrorManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> All fields are required </div>');
    } else {

        // ajax call for adding the product reviews
        $.ajax({
            url: base_url + 'home/addRentProductReview',
            data: {'review_name': review_name, 'review_message': review_message, 'product_id':product_id, 'selected_starts':selected_starts},
            type: 'POST',
            dataType: 'JSON',
            success: function (response) {               

                if (response.status === '1') {
                    MessageManager.show('<div class="alert alert-success"><i class="fa fa-check-circle"></i> Thank you ! Your review added successfully.</div>');
                } else {
                    // alert("here i am");
                    MessageErrorManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + response.message + '</div>');
                    // $('.update_shipping_rate').html('<input type="button" value="Get Quotes" id="button-quote" data-loading-text="Loading..." class="btn btn-primary getShippingInfo">');
                }
            }, error: function (error) {
                console.log(error);
            }
        });
    }
});

// product_filter
$('.filter_price').click(function() {
    // get the base url
    var base_url = $('#base_url').val();

    // alert('here i am');
    $('.product_filter').html('');
    $('.product_filter').html('<center><img style="max-width: 10%;margin: 20% 0;" src="'+ base_url +'frontend/assets/images/loading.svg"></center>');

    var start_price = $('#start_price').val();
    var end_price = $('#end_price').val();
    var category_id = $('#category_id').val();
    var subcategory_id = $('#subcategory_id').val();

    var ischecked = $('#stock_checkbox').is(':checked');
    var checkbox_status;
    if(!ischecked) {
        checkbox_status = 0;
        // alert('uncheckd ' + $(this).val());
    } else {
        checkbox_status = 1;
        // alert('checkd ' + $(this).val());
    }

    // get the checkbox values of selected attributes
    var favorite = [];
    $.each($("input[name='attribute_filter']:checked"), function() {            
        favorite.push($(this).val());
    });

    var search_param = favorite.join(",");

    // get the checkbox values of selected brands
    var favorite_brand = [];
    $.each($("input[name='brand_filter']:checked"), function() {            
        favorite_brand.push($(this).val());
    });

    var brand_search_param = favorite_brand.join(",");

    $.ajax({
        type: "POST",
        url: base_url + 'home/filterProductList',
        datType:'json',
        data: {'instock_search': checkbox_status, 'attribute_search': search_param, 'brand_search': brand_search_param,'start_price': start_price, 'end_price': end_price, 'category_id':category_id, 'subcategory_id':subcategory_id},
        success: function (data) {

            var parsed = $.parseJSON(data);
            // console.log(parsed.content);
            $('.product_filter').html(parsed.content);
        }
    });
});

// oncheck checkbox of filter - show in stock items only
$("#stock_checkbox").change(function() {

    // get the base url
    var base_url = $('#base_url').val();

    $('.product_filter').html('');
    $('.product_filter').html('<center><img style="max-width: 10%;margin: 20% 0;" src="'+ base_url +'frontend/assets/images/loading.svg"></center>');

    var start_price = $('#start_price').val();
    var end_price = $('#end_price').val();
    var category_id = $('#category_id').val();
    var subcategory_id = $('#subcategory_id').val();

    var ischecked = $(this).is(':checked');
    var checkbox_status;
    if(!ischecked) {
        checkbox_status = 0;
        // alert('uncheckd ' + $(this).val());
    } else {
        checkbox_status = 1;
        // alert('checkd ' + $(this).val());
    }

    // get the checkbox values of selected attributes
    var favorite = [];
    $.each($("input[name='attribute_filter']:checked"), function() {            
        favorite.push($(this).val());
    });

    var search_param = favorite.join(",");

    // get the checkbox values of selected brands
    var favorite_brand = [];
    $.each($("input[name='brand_filter']:checked"), function() {            
        favorite_brand.push($(this).val());
    });

    var brand_search_param = favorite_brand.join(",");

    $.ajax({
        type: "POST",
        url: base_url + 'home/filterProductList',
        datType:'json',
        data: {'instock_search': checkbox_status, 'attribute_search': search_param, 'brand_search': brand_search_param,'start_price': start_price, 'end_price': end_price, 'category_id':category_id, 'subcategory_id':subcategory_id},
        success: function (data) {

            var parsed = $.parseJSON(data);
            // console.log(parsed.content);
            $('.product_filter').html(parsed.content);
        }
    });
    // alert("My favourite sports are: " + favorite.join(", "));
});

// attribute filter when clicked on checkbox
$("input[name='attribute_filter']").change(function() {

    // get the base url
    var base_url = $('#base_url').val();

    $('.product_filter').html('');
    $('.product_filter').html('<center><img style="max-width: 10%;margin: 20% 0;" src="'+ base_url +'frontend/assets/images/loading.svg"></center>');

    var start_price = $('#start_price').val();
    var end_price = $('#end_price').val();
    var category_id = $('#category_id').val();
    var subcategory_id = $('#subcategory_id').val();

    var ischecked = $(this).is(':checked');
    var checkbox_status;
    if(!ischecked) {
        checkbox_status = 0;
        // alert('uncheckd ' + $(this).val());
    } else {
        checkbox_status = 1;
        // alert('checkd ' + $(this).val());
    }

    // get the checkbox values of selected attributes
    var favorite = [];
    $.each($("input[name='attribute_filter']:checked"), function() {            
        favorite.push($(this).val());
    });

    var search_param = favorite.join(",");

    // get the checkbox values of selected brands
    var favorite_brand = [];
    $.each($("input[name='brand_filter']:checked"), function() {            
        favorite_brand.push($(this).val());
    });

    var brand_search_param = favorite_brand.join(",");

    $.ajax({
        type: "POST",
        url: base_url + 'home/filterProductList',
        datType:'json',
        data: {'instock_search': checkbox_status, 'attribute_search': search_param,'brand_search': brand_search_param, 'start_price': start_price, 'end_price': end_price, 'category_id':category_id, 'subcategory_id':subcategory_id},
        success: function (data) {
            var parsed = $.parseJSON(data);
            $('.product_filter').html(parsed.content);
        }
    });

    // alert("My favourite sports are: " + favorite.join(", "));
});


// attribute filter when clicked on checkbox
$("input[name='brand_filter']").change(function() {

    // get the base url
    var base_url = $('#base_url').val();

    $('.product_filter').html('');
    $('.product_filter').html('<center><img style="max-width: 10%;margin: 20% 0;" src="'+ base_url +'frontend/assets/images/loading.svg"></center>');

    var start_price = $('#start_price').val();
    var end_price = $('#end_price').val();
    var category_id = $('#category_id').val();
    var subcategory_id = $('#subcategory_id').val();

    var ischecked = $(this).is(':checked');
    var checkbox_status;
    if(!ischecked) {
        checkbox_status = 0;
        // alert('uncheckd ' + $(this).val());
    } else {
        checkbox_status = 1;
        // alert('checkd ' + $(this).val());
    }

    // get the checkbox values of selected attributes
    var favorite = [];
    $.each($("input[name='attribute_filter']:checked"), function() {            
        favorite.push($(this).val());
    });

    var search_param = favorite.join(",");

    // get the checkbox values of selected brands
    var favorite_brand = [];
    $.each($("input[name='brand_filter']:checked"), function() {            
        favorite_brand.push($(this).val());
    });

    var brand_search_param = favorite_brand.join(",");

    $.ajax({
        type: "POST",
        url: base_url + 'home/filterProductList',
        datType:'json',
        data: {'attribute_search': search_param,'brand_search': brand_search_param,'instock_search': checkbox_status,'start_price': start_price, 'end_price': end_price, 'category_id':category_id, 'subcategory_id':subcategory_id},
        success: function (data) {
            var parsed = $.parseJSON(data);
            $('.product_filter').html(parsed.content);
        }
    });

    // alert("My favourite sports are: " + favorite.join(", "));
});




/* rent product list filter */
// attribute filter when clicked on checkbox
$("input[name='rent_brand_filter']").change(function() {

    // get the base url
    var base_url = $('#base_url').val();

    $('.product_filter').html('');
    $('.product_filter').html('<center><img style="max-width: 10%;margin: 20% 0;" src="'+ base_url +'frontend/assets/images/loading.svg"></center>');

    var start_price = $('#start_price').val();
    var end_price = $('#end_price').val();
    var category_id = $('#category_id').val();
    var subcategory_id = $('#subcategory_id').val();

    var ischecked = $(this).is(':checked');
    var checkbox_status;
    if(!ischecked) {
        checkbox_status = 0;
        // alert('uncheckd ' + $(this).val());
    } else {
        checkbox_status = 1;
        // alert('checkd ' + $(this).val());
    }

    // get the checkbox values of selected brands
    var favorite_brand = [];
    $.each($("input[name='rent_brand_filter']:checked"), function() {            
        favorite_brand.push($(this).val());
    });

    var brand_search_param = favorite_brand.join(",");

    $.ajax({
        type: "POST",
        url: base_url + 'home/filterRentProductList',
        datType:'json',
        data: {'brand_search': brand_search_param,'start_price': start_price, 'end_price': end_price, 'category_id':category_id, 'subcategory_id':subcategory_id},
        success: function (data) {
            var parsed = $.parseJSON(data);
            $('.product_filter').html(parsed.content);
        }
    });

    // alert("My favourite sports are: " + favorite.join(", "));
});

// attribute filter when clicked on checkbox
$("input[name='rent_attribute_filter']").change(function() {

    // get the base url
    var base_url = $('#base_url').val();

    $('.product_filter').html('');
    $('.product_filter').html('<center><img style="max-width: 10%;margin: 20% 0;" src="'+ base_url +'frontend/assets/images/loading.svg"></center>');

    var start_price = $('#start_price').val();
    var end_price = $('#end_price').val();
    var category_id = $('#category_id').val();
    var subcategory_id = $('#subcategory_id').val();

    // var ischecked = $(this).is(':checked');
    // var checkbox_status;
    // if(!ischecked) {
    //     checkbox_status = 0;
    //     // alert('uncheckd ' + $(this).val());
    // } else {
    //     checkbox_status = 1;
    //     // alert('checkd ' + $(this).val());
    // }

    // get the checkbox values of selected attributes
    var favorite = [];
    $.each($("input[name='rent_attribute_filter']:checked"), function() {            
        favorite.push($(this).val());
    });

    var search_param = favorite.join(",");

    // get the checkbox values of selected brands
    var favorite_brand = [];
    $.each($("input[name='rent_brand_filter']:checked"), function() {            
        favorite_brand.push($(this).val());
    });

    var brand_search_param = favorite_brand.join(",");

    $.ajax({
        type: "POST",
        url: base_url + 'home/filterRentProductList',
        datType:'json',
        data: {'attribute_search': search_param,'brand_search': brand_search_param, 'start_price': start_price, 'end_price': end_price, 'category_id':category_id, 'subcategory_id':subcategory_id},
        success: function (data) {
            var parsed = $.parseJSON(data);
            $('.product_filter').html(parsed.content);
        }
    });

    // alert("My favourite sports are: " + favorite.join(", "));
});


// ajax request for newsletter subscription
$('#newsletter_submit').click(function (e) {

    e.preventDefault();

    // get the base url
    var base_url = $('#base_url').val();
    var email = $('#newsletter_email').val();

    var MessageManager = {
        show: function (content) {
            $('#newsletter_message').html(content);
            setTimeout(function () {
                $('#newsletter_message').html('');
                $('#newsletter_email').val('');
                // $('.update_shipping_rate').html('<input type="button" value="Get Quotes" id="button-quote" data-loading-text="Loading..." class="btn btn-primary getShippingInfo">');
            }, 5000);
        }
    };

    if(email === "") {
        MessageManager.show('<p style="margin-left: 10px;color: #fcb040">Enter the email id for subscription</p>');
    } else {
        $.ajax({
            type: "POST",
            url: base_url + 'home/subscribeNewsletter',
            datType:'json',
            data: {'email': email},
            success: function (response) {
                // parse the json response
                var parsed = $.parseJSON(response);

                MessageManager.show('<div class="alert alert-success"><i class="fa fa-check-circle"></i> Cart total updated succesfully</div>');
                $('.update_shipping_rate').html('<input type="button" value="Get Quotes" id="button-quote" data-loading-text="Loading..." class="btn btn-primary getShippingInfo">');

                if(parsed.status == 0) {
                    MessageManager.show('<p style="margin-left: 10px;color: #fcb040">'+ parsed.message +'</p>');
                } else {
                    MessageManager.show('<p style="margin-left: 10px;color: #64de64">'+ parsed.message +'</p>');
                }
            }
        });
    }     
});

// out of stock notification
$('#notify_me_btn').click(function (e) {

    // get the base url
    var base_url = $('#base_url').val();

    e.preventDefault();

    $('#notify_me_btn').html('');
    $('#notify_me_btn').html('<center><img style="max-width: 10%;margin: 20% 0;" src="'+ base_url +'frontend/assets/images/loading.svg"></center>');

    var notify_me_email = $('#notify_me').val();
    var rent_product_id = $('#rent_product_id').val();
    
    var MessageManager = {
        show: function (content) {
            $('#notification_message').html(content);
            setTimeout(function () {
                $('#notification_message').html('');
            }, 5000);

        }
    };

    if(notify_me_email == "" || notify_me_email == "undefined") {
        $('.notify_error').html('Enter the email id');
    } else {
        $.ajax({
            type: "POST",
            url: base_url + 'home/outOfStockNotification',
            datType:'json',
            data: {'email': notify_me_email, 'rent_product_id':rent_product_id},
            success: function (response) {
                
                $('#notify_me_btn').html('');
                $('#notify_me').val('');
                $('.notify_error').html('');
                if(response.status == '1') {
                    MessageManager.show('<div class="alert alert-success"><i class="fa fa-check-circle"></i> '+ response.message +'</div>');
                } else {
                    MessageManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> '+ response.message +'</div>');
                }
            }
        });
    }

    // alert(notify_me);
});

// get the shipping rate based on the zipcode
// $('.zipcode_form').on('click', '.update_shipping_rate', function (e) {
//     e.preventDefault();

//      // get the base url
//     var base_url = $('#base_url').val();

//     // alert('here iam');
//     $('.update_shipping_rate').html('<img style="height: 25px;" src="'+ base_url +'frontend/assets/images/loading.svg">');
//     var cust_zipcode = $(".cust_zipcode").val();

//     // alert(cust_zipcode);
//     $.ajax({
//         url: base_url + 'admin/ups/getRates',
//         data: {'cust_zipcode': cust_zipcode},
//         type: 'POST',
//         dataType: 'JSON',
//         success: function (response) {
//             var MessageManager = {
//                 show: function (content) {
//                     $('#zip_message_container').html(content);
//                     setTimeout(function () {
//                         $('#zip_message_container').html('');
//                         $('.update_shipping_rate').html('<input type="button" value="Get Quotes" id="button-quote" data-loading-text="Loading..." class="btn btn-primary getShippingInfo">');
//                     }, 5000);
//                 }
//             };

//             if (response.status === '1') {
            
//                 $(".shippingRateFromUps").html(response.data);
//                 $(".TaxRate").html(response.tax);
//                 $("#total_price").html(response.total);

//                 MessageManager.show('<div class="alert alert-success"><i class="fa fa-check-circle"></i> Cart total updated succesfully</div>');
//                 $('.update_shipping_rate').html('<input type="button" value="Get Quotes" id="button-quote" data-loading-text="Loading..." class="btn btn-primary getShippingInfo">');
//             } else {
//                 MessageManager.show('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + response.message + '</div>');
//                 $('.update_shipping_rate').html('<input type="button" value="Get Quotes" id="button-quote" data-loading-text="Loading..." class="btn btn-primary getShippingInfo">');
//             }
//         }, error: function (error) {
//             console.log(error);
//         }
//     });
// });


    function loadBestSellerProducts(category_id) {
        var base_url = $('#base_url').val();
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'home/loadBestsellerProductsByCategory',
            dataType:'json',
            data: {'category_id':category_id},
            success: function (response) {
                // alert(response.status);
                // var parsed = $.parseJSON(response);
                $('.replace_bestseller_div').html('');
                $('.replace_bestseller_div').html(response.content);
            }
        });
    }
    
    function loadFeaturedProducts(category_id) {
        var base_url = $('#base_url').val();
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'home/loadFeaturedProductsByCategory',
            dataType:'json',
            data: {'category_id':category_id},
            success: function (response) {
                // alert(response.status);
                // var parsed = $.parseJSON(response);
                $('.replace_featured_div').html('');
                $('.replace_featured_div').html(response.content);
            }
        });
    }

    // calculate the shipping address from USPS shipping
    $('.calculate_shipping').click(function() {
        // get the base url
        var base_url = $('#base_url').val();
        
        // get the zipcode value
        var cust_zipcode = $('.zipcode_val').val();        
        console.log(cust_zipcode);

        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'home/USPSParcelRate',
            dataType:'json',
            data: {'weight':'50', 'zipcode':cust_zipcode},
            success: function (response) {
                var parsed = $.parseJSON(response);
                console.log(parsed);
                $('.box-cart-total .price strong').html('');
                $('.box-cart-total .price strong').html(parsed.shipping_cost);
            }
        });
    });


    // login from popup when user is on checkout page
    // $('.popup_login').click(function(e) {
    $('.loginPopForm').on('click', '.popup_login', function (e) {

        e.preventDefault();

        // get the base url
        var base_url = $('#base_url').val();

        $('.popup_login_submit').html('<button id="popup_login" class="add-btn btn-block popup_login"><img style="height: 25px;" src="'+ base_url +'frontend/assets/images/loader.gif"></button>');

        $('#pop_username_error').text('');
        $('#pop_password_error').text('');

        var username = $('#pop_username').val();
        var password = $('#pop_password').val();

        if(username == "") {

            $('#pop_username_error').html('Enter the value of username');
            setTimeout(function () {
                $('#pop_username_error').html('');
                $('.popup_login_submit').html('<button id="popup_login" class="add-btn btn-block popup_login">Login</button>');
            }, 3000);
            // $('#pop_username_error').text('Enter the value of username');

        } else if (password == "") {

            $('#pop_password_error').html('Enter the value of password');
            setTimeout(function () {
                $('#pop_password_error').html('');
                $('.popup_login_submit').html('<button id="popup_login" class="add-btn btn-block popup_login">Login</button>');
            }, 3000);

            // $('#pop_password_error').text('Enter the value of password');
        } else {
            // ajax call
            $.ajax({
                type: "POST",
                url: base_url + 'auth/popupLogin',
                dataType:'json',
                data: {'username':username, 'password':password},
                success: function (response) {
                    // var parsed = $.parseJSON(response);
                    console.log(response);
                    if(response.status == '0') {
                        $('#login_pop_error').text(response.message);
                        $('.popup_login_submit').html('<button id="popup_login" class="add-btn btn-block popup_login">Login</button>');
                    } else {
                        // $('#login_pop_error').text(response.message);
                        // $('.popup_login_submit').html('<button id="popup_login" class="add-btn btn-block popup_login">Login</button>');
                        window.location.href = base_url + 'home/cart';
                    }
                }
            });
        }
    });


    // registration for on checkout page popup
    $('.registerPopForm').on('click', '.popup_register', function (e) {

        e.preventDefault();

        // get the base url
        var base_url = $('#base_url').val();

        $('.popup_register_submit').html('<button id="popup_login" class="add-btn btn-block popup_login"><img style="height: 25px;" src="'+ base_url +'frontend/assets/images/loader.gif"></button>');

        $('#pop_username_error').text('');
        $('#pop_password_error').text('');

        var username = $('#pop_username').val();
        var password = $('#pop_password').val();

        if(username == "") {

            $('#pop_username_error').html('Enter the value of username');
            setTimeout(function () {
                $('#pop_username_error').html('');
                $('.popup_register_submit').html('<button id="popup_login" class="add-btn btn-block popup_login">Login</button>');
            }, 3000);
            // $('#pop_username_error').text('Enter the value of username');

        } else if (password == "") {

            $('#pop_password_error').html('Enter the value of password');
            setTimeout(function () {
                $('#pop_password_error').html('');
                $('.popup_register_submit').html('<button id="popup_login" class="add-btn btn-block popup_login">Login</button>');
            }, 3000);

            // $('#pop_password_error').text('Enter the value of password');
        } else {
            // ajax call
            $.ajax({
                type: "POST",
                url: base_url + 'auth/popupLogin',
                dataType:'json',
                data: {'username':username, 'password':password},
                success: function (response) {
                    // var parsed = $.parseJSON(response);
                    console.log(response);
                    if(response.status == '0') {
                        $('#login_pop_error').text(response.message);
                        $('.popup_register_submit').html('<button id="popup_login" class="add-btn btn-block popup_login">Login</button>');
                    } else {
                        // $('#login_pop_error').text(response.message);
                        // $('.popup_login_submit').html('<button id="popup_login" class="add-btn btn-block popup_login">Login</button>');
                        window.location.href = base_url + 'home/cart';
                    }
                }
            });
        }
    });

    // copy the billing address in to the shipping address on checkout page
    function InputInformation(n) {   
        
        if(n.checked === false) {

            document.checkout_address_form.shippingaddress.value = '';
            // document.checkout_address_form.shipping_country_id.value = '';
            // document.checkout_address_form.shipping_zone_id.value = '';
            document.checkout_address_form.shippingcity.value = '';
            document.checkout_address_form.shippingpostcode.value = '';
            document.checkout_address_form.shippingtelephone.value = '';
            document.getElementById("shipping_input_zone").value = '';

            document.getElementById("shippingaddress").disabled = false;
            document.getElementById("shipping_input_zone").disabled = false;
            document.getElementById("shippingcity").disabled = false;
            document.getElementById("shippingpostcode").disabled = false;
            document.getElementById("shippingtelephone").disabled = false;
            return false;
        }
        
        document.checkout_address_form.shippingaddress.value = document.checkout_address_form.billingaddress.value;
        console.log(document.checkout_address_form.billing_zone_id.value);
        document.checkout_address_form.shippingcity.value = document.checkout_address_form.billingcity.value;
        document.checkout_address_form.shippingpostcode.value = document.checkout_address_form.billingpostcode.value;
        document.checkout_address_form.shippingtelephone.value = document.checkout_address_form.billingtelephone.value;
        
        document.getElementById("shipping_input_zone").value = document.checkout_address_form.billing_zone_id.value;
        document.getElementById("shippingaddress").disabled = true;
        document.getElementById("shipping_input_zone").disabled = true;
        document.getElementById("shippingcity").disabled = true;
        document.getElementById("shippingpostcode").disabled = true;
        document.getElementById("shippingtelephone").disabled = true;
    }