// Ajax request for delete the user
function deleteUser(id) {
    var base_url = $('#base_url').val();
// $('#delete-user').on('click', function() {
    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the user",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'auth/delete_user',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 2000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + id).remove();
                    }, 2000);
                }
            }
        });
    });
}

// Ajax request for delete the product
function deleteBuyProduct(id) {
    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the Product",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/deleteBuyProduct',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 5000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + id).remove();
                        window.location.href = base_url + 'admin/products';
                    }, 5000);
                }
            }
        });
    });
}

// $('#add_buy_category_form').click(function() {
$('#add_buy_category_form').on('click', '#add_buy_category_btn', function() {

    var base_url = $('#base_url').val();

    $('.btn_add_category').html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

    var category_name = $('#add_category_name').val().trim();
    var category_description = $('#add_category_description').val().trim(); 
    var category_attribute =  $('#add_category_attribute').val().trim();

    // check the response status
    var MessageManager = {
        show: function(content) {
            $('#add_error_msg').html(content);
            setTimeout(function() {
                $('#add_error_msg').html('');
                $('.btn_add_category').html('<button type="button" class="btn btn-primary" id="add_buy_category_btn">Add Category</button>');
                window.location.href = base_url + 'admin/buy_categories';
            }, 5000);
        }
    };

    var MessageErrorManager = {
        show: function(content) {
            $('#add_error_msg').html(content);
            setTimeout(function() {
                $('#add_error_msg').html('');
                $('.btn_add_category').html('<button type="button" class="btn btn-primary" id="add_buy_category_btn">Add Category</button>');
            }, 5000);
        }
    };

    if(category_name == "" || category_description == '') {
        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
    } else {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/ajaxAddBuyCategory',
            dataType:'json',
            data: {'category_name': category_name, 'category_attribute':category_attribute, 'category_description':category_description},
            success: function (response) {
                // console.log(response);
                if(response.status == '1') {
                    MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                } else {
                    MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                }
            }
        });
    }
});

/* edit the category in popup */
function edit_category(id) {
    // edit category of buy section
    $('#edit_buy_category_form_'+ id).on('click', '#edit_buy_category_btn_'+ id, function() {
        
        var base_url = $('#base_url').val();
        $('.btn_edit_category_'+ id).html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

        // console.log($('#edit_category_name_'+ id).val());
        // console.log($('#edit_category_description_'+ id).val());
        var category_name = $('#edit_category_name_'+ id).val().trim();
        var category_description = $('#edit_category_description_'+ id).val().trim();

        // check the response status
        var MessageManager = {
            show: function(content) {
                $('#edit_error_msg_'+ id).html(content);
                setTimeout(function() {
                    $('#edit_error_msg_'+ id).html('');
                    $('.btn_edit_category_'+ id).html('<button type="button" class="btn btn-primary" id="edit_buy_category_btn">Update Category</button>');
                    window.location.href = base_url + 'admin/buy_categories';
                }, 5000);
            }
        };

        var MessageErrorManager = {
            show: function(content) {
                $('#edit_error_msg_'+ id).html(content);
                setTimeout(function() {
                    $('#edit_error_msg_'+ id).html('');
                    $('.btn_edit_category_'+ id).html('<button type="button" class="btn btn-primary" id="edit_buy_category_btn">Add Category</button>');
                }, 5000);
            }
        };

        if(category_name == "" || category_description == '') {
            // alert('here i am');
            MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
        } else {
            // alert('here ia m');
            var product_id = $('#product_id_'+ id).val();
            // ajax call
            $.ajax({
                type: "POST",
                url: base_url + 'admin/ajaxEditBuyCategory',
                dataType:'json',
                data: {'category_name': category_name, 'category_description':category_description, 'product_id':product_id},
                success: function (response) {
                    // console.log(response);
                    if(response.status == '1') {
                        MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                    } else {
                        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                    }
                }
            });
        }
    });
}


/* add brand from popup */
$('#add_buy_brand_form').on('click', '#add_buy_brand_btn', function() {

    var base_url = $('#base_url').val();

    $('.btn_add_brand').html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

    var brand_name = $('#add_brand_name').val().trim();

    // check the response status
    var MessageManager = {
        show: function(content) {
            $('#add_brand_error_msg').html(content);
            setTimeout(function() {
                $('#add_brand_error_msg').html('');
                $('.btn_add_brand').html('<button type="button" class="btn btn-primary" id="add_buy_brand_btn">Add Brand</button>');
                window.location.href = base_url + 'admin/buy_brands';
            }, 5000);
        }
    };

    var MessageErrorManager = {
        show: function(content) {
            $('#add_brand_error_msg').html(content);
            setTimeout(function() {
                $('#add_brand_error_msg').html('');
                $('.btn_add_brand').html('<button type="button" class="btn btn-primary" id="add_buy_brand_btn">Add Brand</button>');
            }, 5000);
        }
    };

    if(brand_name == "") {
        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
    } else {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/ajaxAddBuyBrand',
            dataType:'json',
            data: {'brand_name': brand_name},
            success: function (response) {
                if(response.status == '1') {
                    MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                } else {
                    MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                }
            }
        });
    }
});

/* edit the category in popup */
function edit_brand(id) {
    // edit category of buy section
    $('#edit_buy_brand_form_'+ id).on('click', '#edit_buy_brand_btn_'+ id, function() {
        
        var base_url = $('#base_url').val();
        $('.btn_edit_brand_'+ id).html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

        var brand_name = $('#edit_brand_name_'+ id).val().trim();

        // check the response status
        var MessageManager = {
            show: function(content) {
                $('#edit_error_msg_'+ id).html(content);
                setTimeout(function() {
                    $('#edit_error_msg_'+ id).html('');
                    $('.btn_edit_brand_'+ id).html('<button type="button" class="btn btn-primary" id="edit_buy_brand_btn">Update Brand</button>');
                    window.location.href = base_url + 'admin/buy_brands';
                }, 5000);
            }
        };

        var MessageErrorManager = {
            show: function(content) {
                $('#edit_error_msg_'+ id).html(content);
                setTimeout(function() {
                    $('#edit_error_msg_'+ id).html('');
                    $('.btn_edit_brand_'+ id).html('<button type="button" class="btn btn-primary" id="edit_buy_brand_btn">Update Brand</button>');
                }, 5000);
            }
        };

        if(brand_name == "") {
            // alert('here i am');
            MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
        } else {
            
            var brand_id = $('#brand_id_'+ id).val();

            // ajax call
            $.ajax({
                type: "POST",
                url: base_url + 'admin/ajaxEditBuyBrand',
                dataType:'json',
                data: {'brand_name': brand_name, 'brand_id':brand_id},
                success: function (response) {

                    if(response.status == '1') {
                        MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                    } else {
                        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                    }
                }
            });
        }
    });
}

// Ajax request for delete the brand
function deleteBuyBrand(id) {

    var base_url = $('#base_url').val();
    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the Brand",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/deleteBuyBrand',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 5000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + id).remove();
                        window.location.href = base_url + 'admin/buy_brands';
                    }, 5000);
                }
            }
        });
    });
}


/* add attribute using popup */
$('#add_buy_attribute_form').on('click', '#add_buy_attribute_btn', function() {

    var base_url = $('#base_url').val();

    $('.btn_add_attribute').html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

    var selected_type = $('#is_brand').val();
    var category_name = $('#add_attribute_name').val().trim();
    var category_description = $('#add_sub_attribute_name').val().trim();
    
    // check the response status
    var MessageManager = {
        show: function(content) {
            $('#add_attr_error_msg').html(content);
            setTimeout(function() {
                $('#add_attr_error_msg').html('');
                $('.btn_add_attribute').html('<button type="button" class="btn btn-primary" id="add_buy_category_btn">Add Category</button>');
                window.location.href = base_url + 'admin/buy_attributes';
            }, 5000);
        }
    };

    var MessageErrorManager = {
        show: function(content) {
            $('#add_attr_error_msg').html(content);
            setTimeout(function() {
                $('#add_attr_error_msg').html('');
                $('.btn_add_attribute').html('<button type="button" class="btn btn-primary" id="add_buy_category_btn">Add Category</button>');
            }, 5000);
        }
    };

    if(category_name == "" || category_description == '' || category_attribute == "") {
        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
    } else {
        // ajax call
        // $.ajax({
        //     type: "POST",
        //     url: base_url + 'admin/ajaxAddBuyAttribute',
        //     dataType:'json',
        //     data: {'category_name': category_name, 'category_attribute':category_attribute, 'category_description':category_description},
        //     success: function (response) {
        //         console.log(response);
        //         if(response.status == '1') {
        //             MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
        //         } else {
        //             MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
        //         }
        //     }
        // });
    }
});


/**************************** Rent section start here ****************************/
/**
* @author     : Harshal Borse<harshalb@rebelute.com>
* @date       : 18 Jan 2018
* add category for rent section
*/
// $('#add_buy_category_form').click(function() {
$('#add_rent_category_form').on('click', '#add_rent_category_btn', function() {

    var base_url = $('#base_url').val();

    $('.rent_btn_add_category').html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

    var rent_category_name = $('#add_rent_category_name').val().trim();
    var rent_category_description = $('#add_rent_category_description').val().trim();

    // check the response status
    var MessageManager = {
        show: function(content) {
            $('#add_rent_error_msg').html(content);
            setTimeout(function() {
                $('#add_rent_error_msg').html('');
                $('.rent_btn_add_category').html('<button type="button" class="btn btn-primary" id="add_rent_category_btn">Add Category</button>');
                window.location.href = base_url + 'admin/rent_categories';
            }, 5000);
        }
    };

    var MessageErrorManager = {
        show: function(content) {
            $('#add_rent_error_msg').html(content);
            setTimeout(function() {
                $('#add_rent_error_msg').html('');
                $('.rent_btn_add_category').html('<button type="button" class="btn btn-primary" id="add_rent_category_btn">Add Category</button>');
            }, 5000);
        }
    };

    if(rent_category_name == "" || rent_category_description == '') {
        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
    } else {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/ajaxAddRentCategory',
            dataType:'json',
            data: {'category_name': rent_category_name, 'category_description':rent_category_description},
            success: function (response) {
                if(response.status == '1') {
                    MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                } else {
                    MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                }
            }
        });
    }
});

/* edit the category in popup */
function edit_rent_category(id) {
    // edit category of buy section
    $('#edit_rent_category_form_'+ id).on('click', '#edit_rent_category_btn_'+ id, function() {
        
        var base_url = $('#base_url').val();
        $('.btn_rent_edit_category_'+ id).html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

        var rent_category_name = $('#edit_rent_category_name_'+ id).val().trim();
        var rent_category_description = $('#edit_rent_category_description_'+ id).val().trim();

        // check the response status
        var MessageManager = {
            show: function(content) {
                $('#edit_rent_error_msg_'+ id).html(content);
                setTimeout(function() {
                    $('#edit_error_msg_'+ id).html('');
                    $('.btn_rent_edit_category_'+ id).html('<button type="button" class="btn btn-primary" id="edit_rent_category_btn">Update Category</button>');
                    window.location.href = base_url + 'admin/rent_categories';
                }, 5000);
            }
        };

        var MessageErrorManager = {
            show: function(content) {
                $('#edit_rent_error_msg_'+ id).html(content);
                setTimeout(function() {
                    $('#edit_error_msg_'+ id).html('');
                    $('.btn_rent_edit_category_'+ id).html('<button type="button" class="btn btn-primary" id="edit_rent_category_btn">Add Category</button>');
                }, 5000);
            }
        };

        if(rent_category_name == "" || rent_category_description == '') {
            MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
        } else {

            var cat_id = $('#cat_id_'+ id).val();

            // ajax call
            $.ajax({
                type: "POST",
                url: base_url + 'admin/ajaxEditRentCategory',
                dataType:'json',
                data: {'category_name': rent_category_name, 'category_description':rent_category_description, 'cat_id':cat_id},
                success: function (response) {
                    if(response.status == '1') {
                        MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                    } else {
                        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                    }
                }
            });
        }
    });
}


// Ajax request for delete the categories of rent section
function deleteRentCategory(id) {

    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the category",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/ajaxdeleteRentCategory',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    swal({title: response.message, type: "success"},
                    function() {
                       location.reload();
                    });
                } else {
                    swal({title: response.message, type: "success"},
                    function() {
                       location.reload();
                    });
                }
            }
        });
    });
}



/**
* @author     : Harshal Borse<harshalb@rebelute.com>
* @date       : 18 Jan 2018
* add category for rent section
*/
// $('#add_buy_category_form').click(function() {
$('#add_rent_subcategory_form').on('click', '#add_rent_subcategory_btn', function() {

    var base_url = $('#base_url').val();

    $('.rent_btn_add_subcategory').html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

    var rent_parent_category = $('#rent_parent_category').val().trim();
    var rent_subcategory_name = $('#add_rent_subcategory_name').val().trim();
    var rent_subcategory_description = $('#add_rent_subcategory_description').val().trim();

    // check the response status
    var MessageManager = {
        show: function(content) {
            $('#add_rent_error_msg').html(content);
            setTimeout(function() {
                $('#add_rent_error_msg').html('');
                $('.rent_btn_add_subcategory').html('<button type="button" class="btn btn-primary" id="add_rent_category_btn">Add Sub-Category</button>');
                window.location.href = base_url + 'admin/rent_subcategories';
            }, 5000);
        }
    };

    var MessageErrorManager = {
        show: function(content) {
            $('#add_rent_error_msg').html(content);
            setTimeout(function() {
                $('#add_rent_error_msg').html('');
                $('.rent_btn_add_subcategory').html('<button type="button" class="btn btn-primary" id="add_rent_subcategory_btn">Add Sub-Category</button>');
            }, 5000);
        }
    };

    if(rent_parent_category == "" || rent_subcategory_name == "" || rent_subcategory_description == '') {
        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
    } else {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/ajaxAddRentSubCategory',
            dataType:'json',
            data: {'rent_parent_category':rent_parent_category, 'category_name': rent_subcategory_name, 'category_description':rent_subcategory_description},
            success: function (response) {
                if(response.status == '1') {
                    MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                } else {
                    MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                }
            }
        });
    }
});

/* edit the category in popup */
function edit_rent_subcategory(id) {
    // edit category of buy section
    $('#edit_rent_subcategory_form_'+ id).on('click', '#edit_rent_subcategory_btn_'+ id, function() {
        
        var base_url = $('#base_url').val();
        $('.btn_rent_edit_subcategory_'+ id).html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

        var rent_subcategory_name = $('#edit_rent_subcategory_name_'+ id).val().trim();
        var rent_subcategory_description = $('#edit_rent_subcategory_description_'+ id).val().trim();

        // check the response status
        var MessageManager = {
            show: function(content) {
                $('#edit_rent_error_msg_'+ id).html(content);
                setTimeout(function() {
                    $('#edit_error_msg_'+ id).html('');
                    $('.btn_rent_edit_subcategory_'+ id).html('<button type="button" class="btn btn-primary" id="edit_rent_subcategory_btn">Update Sub-Category</button>');
                    window.location.href = base_url + 'admin/rent_subcategories';
                }, 5000);
            }
        };

        var MessageErrorManager = {
            show: function(content) {
                $('#edit_rent_error_msg_'+ id).html(content);
                setTimeout(function() {
                    $('#edit_error_msg_'+ id).html('');
                    $('.btn_rent_edit_subcategory_'+ id).html('<button type="button" class="btn btn-primary" id="edit_rent_subcategory_btn">Add Sub-Category</button>');
                }, 5000);
            }
        };

        if(rent_subcategory_name == "" || rent_subcategory_description == '') {
            MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
        } else {

            var subcat_id = $('#subcat_id_'+ id).val();

            // ajax call
            $.ajax({
                type: "POST",
                url: base_url + 'admin/ajaxEditRentSubCategory',
                dataType:'json',
                data: {'category_name': rent_subcategory_name, 'category_description':rent_subcategory_description, 'subcat_id':subcat_id},
                success: function (response) {
                    if(response.status == '1') {
                        MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                    } else {
                        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                    }
                }
            });
        }
    });
}


// Ajax request for delete the categories of rent section
function deleteRentSubCategory(id) {

    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the category",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/ajaxdeleteRentSubCategory',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    swal({title: response.message, type: "success"},
                    function() {
                       location.reload();
                    });
                } else {
                    swal({title: response.message, type: "success"},
                    function() {
                       location.reload();
                    });
                }
            }
        });
    });
}


// Ajax request for delete the product
function deleteRentProduct(id) {

    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the Product",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/deleteRentProduct',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 5000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + id).remove();
                        window.location.href = base_url + 'admin/rent_products';
                    }, 5000);
                }
            }
        });
    });
}
/************************** Rent section end here *************************/

/**
* @author : Jinal rathod <jinalr@rebelute.com>
* validation for the about us, privacy policy, contact us cms page
*/
var validateInputGroups = $("#about_cms").validate({
    // Validation rules
    // Selecting input by name attribute
    rules: {
        heading1: {
            required: true,
            minlength: 5,
            maxlength: 50
        },
        heading2: {
            minlength: 5,
            required: true,
            maxlength: 50
        },
        heading3: {
            required: true,
            minlength: 5,
            maxlength: 50
        },
        name1: {
            required: true,
            minlength: 5,
            maxlength: 50
        },
        name2: {
            required: true,
            minlength: 5,
            maxlength: 50
        },
        name3: {
            required: true,
            minlength: 5,
            maxlength: 50
        },

    },
    // Error messages
    messages: {
        heading1: "Heading is required (min :5 characters ,max :50 characters)",
        heading2: "Heading is required (min :5 characters ,max :50 characters)",
        heading3: "Heading is required (min :5 characters ,max :50 characters)",
        name1: "Name is required (min :5 characters ,max :50 characters)",
        name2: "Name is required (min :5 characters ,max :50 characters)",
        name3: "Name is required (min :5 characters ,max :50 characters)",
        designation1: 'Designation is required (min :5 characters ,max :50 characters)',
        designation2: 'Designation is required (min :5 characters ,max :50 characters)',
        designation3: 'Designation is required (min :5 characters ,max :50 characters)',

    },
    highlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').addClass('has-error').find('label').addClass('control-label');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error');
    },
    // Class that wraps error message
    errorClass: "help-block",
    // Element that wraps error message
    errorElement: "div",
    errorPlacement: function (error, element) {
        $(element).closest(".form-group").append(error);

        // Select2 validation
        $("select").on("change", function () {
            var select2Valid = $(this).valid();
            // If clicked on clear button
            if (!select2Valid) {
                $(this).parent().removeClass("has-success").addClass("has-error");
            }
        });
    },
    success: function (helpBlock) {
        if ($(helpBlock).closest(".form-group").hasClass('has-error')) {
            $(helpBlock).closest(".form-group").removeClass("has-error").addClass("has-success");
        }
    }
});

var validateInputGroups = $("#policy_cms").validate({
    // Validation rules
    // Selecting input by name attribute
       ignore: [],
    rules: {
        heading1: {
            required: true,
            minlength: 5,
            maxlength: 50
        },
        heading2: {
            minlength: 5,
            required: true,
            maxlength: 50
        },
        column_content_1:{
                 required: function() {
       CKEDITOR.instances.updateElement();
       var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
       return editorcontent.length === 0;
     }
        },

    },
    // Error messages
    messages: {
        heading1: "Heading is required (min :5 characters ,max :50 characters)",
        heading2: "Heading is required (min :5 characters ,max :50 characters)",

    },
    highlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').addClass('has-error').find('label').addClass('control-label');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error');
    },
    // Class that wraps error message
    errorClass: "help-block",
    // Element that wraps error message
    errorElement: "div",
    errorPlacement: function (error, element) {
        $(element).closest(".form-group").append(error);

        // Select2 validation
        $("select").on("change", function () {
            var select2Valid = $(this).valid();
            // If clicked on clear button
            if (!select2Valid) {
                $(this).parent().removeClass("has-success").addClass("has-error");
            }
        });
    },
    success: function (helpBlock) {
        if ($(helpBlock).closest(".form-group").hasClass('has-error')) {
            $(helpBlock).closest(".form-group").removeClass("has-error").addClass("has-success");
        }
    }
});

var validateInputGroups = $("#contact_cms").validate({
    // Validation rules
    // Selecting input by name attribute
    rules: {
        heading1: {
            required: true,
            minlength: 5,
            maxlength: 50
        },
        content: {
            minlength: 5,
            required: true,
            maxlength: 250
        },
        addr: {
            minlength: 5,
            required: true,
            maxlength: 250
        },
        map: {
            minlength: 5,
            required: true,

        },
        phone: {
            digits: true,
            minlength: 10,
            maxlength: 10
        },
        fax: {
            digits: true,
            minlength: 10,
            maxlength: 10
        },
        mail1: {
            required: true,
            email: true,

        },
        mail2: {
            required: true,
            email: true,

        },
        text1: {
            minlength: 5,
            required: true,
            maxlength: 250
        },
        text2: {
            minlength: 5,
            required: true,
            maxlength: 50
        },
        text3: {
            minlength: 5,
            required: true,
            maxlength: 50
        },
        startdate1: {

            required: true,

        },

        startdate2: {
            required: true,

        },

        startdate3: {
            required: true,

        },

    },
    // Error messages
    messages: {
        heading: "heading is required (min :5 characters ,max :50 characters)",
        content: "content is required (min :5 characters ,max :50 characters)",
        addr: "address is required (min :5 characters ,max :250 characters)",
        map: "map is required ",
        mail1: "email is required",
        mail2: "email is required",
        text1: "text is required (min :5 characters ,max :50 characters)",
        text2: "text is required (min :5 characters ,max :50 characters)",
        text3: "text is required (min :5 characters ,max :50 characters)",

        phone: {
            required: "phone is required",
            minlength: "Please enter at least 10 digits.",
            maxlength: "Please enter no more than 10 digits",
            digits: "Please enter only digits."
        },
        fax: {
            required: "fax is required",
            minlength: "Please enter at least 10 digits.",
            maxlength: "Please enter no more than 10 digits",
            digits: "Please enter only digits."
        },
    },
    highlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').addClass('has-error').find('label').addClass('control-label');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error');
    },
    // Class that wraps error message
    errorClass: "help-block",
    // Element that wraps error message
    errorElement: "div",
    errorPlacement: function (error, element) {
        $(element).closest(".form-group").append(error);

        // Select2 validation
        $("select").on("change", function () {
            var select2Valid = $(this).valid();
            // If clicked on clear button
            if (!select2Valid) {
                $(this).parent().removeClass("has-success").addClass("has-error");
            }
        });
    },
    success: function (helpBlock) {
        if ($(helpBlock).closest(".form-group").hasClass('has-error')) {
            $(helpBlock).closest(".form-group").removeClass("has-error").addClass("has-success");
        }
    }
});

/* newsletter subscription from footer in frontend */
$('#newsletter_form').on('click', '#send_email_btn', function() {

    var base_url = $('#base_url').val();

    $('.btn_send_email').html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

    var email_subject = $('#email_subject').val().trim();
    var email_content = $('#email_content').val().trim();

    // check the response status
    var MessageManager = {
        show: function(content) {
            $('#add_error_msg').html(content);
            setTimeout(function() {
                $('#add_error_msg').html('');
                $('.btn_send_email').html('<button type="button" class="btn btn-primary" id="send_email_btn">Send Email</button>');
                window.location.href = base_url + 'admin/newsletter';
            }, 5000);
        }
    };

    var MessageErrorManager = {
        show: function(content) {
            $('#add_error_msg').html(content);
            setTimeout(function() {
                $('#add_error_msg').html('');
                $('.btn_send_email').html('<button type="button" class="btn btn-primary" id="send_email_btn">Send Email</button>');
            }, 5000);
        }
    };

    if(email_subject == "" || email_content == '') {
        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
    } else {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/send_newsletter',
            dataType:'json',
            data: {'email_subject': email_subject, 'email_content':email_content},
            success: function (response) {
                
                if(response.status == '1') {
                    MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                } else {
                    MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                }
            }
        });
    }
});


// Ajax request for delete the categories of Buy section
function deleteBuyCategory(id) {
    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the category",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/ajaxdeleteBuyCategory',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 5000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + id).remove();
                        window.location.href = base_url + 'admin/buy_categories';
                    }, 5000);
                }
            }
        });
    });
}

// Ajax request for delete the attributes of Buy section
function deleteBuyAttribute(id) {
    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the attribute",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/ajaxdeleteBuyAttribute',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 2000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + id).remove();
                        window.location.href = base_url + 'admin/buy_attributes';
                    }, 2000);
                }
            }
        });
    });
}

/* add social link from popup */
$('#id_form_social_link').on('click', '#add_social_link_btn', function() {

    var base_url = $('#base_url').val();

    $('.btn_add_social').html('<button class="btn">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');

    var social_id = $('#social_id').val().trim();
    var social_link = $('#social_link').val().trim();

    // check the response status
    var MessageManager = {
        show: function(content) {
            $('#add_social_error_msg').html(content);
            setTimeout(function() {
                $('#add_social_error_msg').html('');
                $('.btn_add_social').html('<button type="button" class="btn btn-primary" id="add_buy_brand_btn">Add Social Link</button>');
                window.location.href = base_url + 'admin/manage_social_links';
            }, 5000);
        }
    };

    var MessageErrorManager = {
        show: function(content) {
            $('#add_social_error_msg').html(content);
            setTimeout(function() {
                $('#add_social_error_msg').html('');
                $('.btn_add_social').html('<button type="button" class="btn btn-primary" id="add_buy_brand_btn">Add Social Link</button>');
            }, 5000);
        }
    };

    if(social_link == "" || social_id == "") {
        MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>Enter the values of required fields</div>');
    } else {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/addSocialLink',
            dataType:'json',
            data: {'social_id': social_id, 'social_link': social_link},
            success: function (response) {
                if(response.status == '1') {
                    MessageManager.show('<div class="alert alert-success border-success alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                } else {
                    MessageErrorManager.show('<div class="alert alert-danger border-danger alert-dismissible fade in"><button type="button" class="close" data-dismiss="alert"><span>×</span></button>'+ response.message +'</div>');
                }
            }
        });
    }
});


// Ajax request for delete the attributes of Buy section
function deleteSocialLink(id) {

    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before deleting the Social Link",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/deleteSocialLinks',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 2000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + id).remove();
                        window.location.href = base_url + 'admin/manage_social_links';
                    }, 2000);
                }
            }
        });
    });
}

// $(".form-group select").on("change", function() {
//     console.log("change");
//     console.log($(this).val());
// });
// $(document).ready(function () {
//     $('#add_more_attribute_values').click( function(e) {
//         alert('here i am');
//         e.preventDefault();
//         $('#div_add_more').append('<div class="form-group"><div for="add_sub_attribute_name" class="col-sm-4"><input type="text" name="add_sub_attribute_name[]" value="" class="form-control" id="add_sub_attribute_name" maxlength="50" minlength="2" required="required" placeholder="Enter the name"></div><div class="col-sm-8"><input type="text" name="tags[]" value="" class="form-control" id="tags" maxlength="50" minlength="2" required="required" placeholder="Enter the tag"></div></div><br>');
//     });
// });

function append_more() {
    $('#div_add_more').append('<div class="form-group"><div for="add_sub_attribute_name" class="col-sm-4"><input type="text" name="add_sub_attribute_name[]" value="" class="form-control" id="add_sub_attribute_name" maxlength="50" minlength="2" required="required" placeholder="Enter the name"></div><div class="col-sm-8"><input type="text" name="tags[]" value="" class="form-control" id="tags" maxlength="50" minlength="2" required="required" placeholder="Enter the tag"></div></div><br>');
    // alert('here i am');
}

function append_more_edit() {
    $('#div_add_more').append('<div class="form-group"><div for="add_sub_attribute_name" class="col-sm-4"><input type="text" name="add_sub_attribute_name_new[]" value="" class="form-control" id="add_sub_attribute_name" maxlength="50" minlength="2" required="required" placeholder="Enter the name"></div><div class="col-sm-8"><input type="text" name="tags_new[]" value="" class="form-control" id="tags" maxlength="50" minlength="2" required="required" placeholder="Enter the tag"></div></div><br>');
    // alert('here i am');
}

$("#product_category").change(function () {
    var base_url = $('#base_url').val();
    // var product_category_id = $("select#product_category option:selected").val();
    var product_category_id = $(this).val();
    // console.log($(this).val());
    $.ajax({
        type: "POST",
        url: base_url + 'admin/getAttributes',
        data: {'product_category_id': product_category_id},
        success: function (data) {
            var parsed = $.parseJSON(data);
            $('#_div_attr_view').html('')
            $('#_div_attr_view').html(parsed.content);
        }
    });
});


$("#product_attribute").change(function () {
    var base_url = $('#base_url').val();
    // var product_category_id = $("select#product_category option:selected").val();
    var product_category_id = $(this).val();
    // console.log($(this).val());
    $.ajax({
        type: "POST",
        url: base_url + 'admin/getAttributesById',
        data: {'product_category_id': product_category_id},
        success: function (data) {
            var parsed = $.parseJSON(data);
            $('#_div_attr_details').html('')
            $('#_div_attr_details').html(parsed.content);
        }
    });
});


$("#add_category_attribute").change(function () {
    var base_url = $('#base_url').val();
    // var product_category_id = $("select#product_category option:selected").val();
    var product_category_id = $(this).val();
    // console.log($(this).val());
    $.ajax({
        type: "POST",
        url: base_url + 'admin/getSubCategories',
        data: {'product_category_id': product_category_id},
        success: function (data) {
            var parsed = $.parseJSON(data);
            $('#_div_attr_view').html('')
            $('#_div_attr_view').html(parsed.content);
        }
    });
});

// $('input[type="radio"]').on('click change', function(e) {
//     console.log(e.type);
// });

// function test() {
//     alert('here i ma');
// }
$("#is_subcategory").click(function () {

    $('.hidden_div_1').show();
    // $('.hidden_div_2').hide();
});

$("#is_attribute").click(function () {
    $('.hidden_div_1').hide();
    // $('.hidden_div_2').show();
});

$("#is_brand").click(function () {
    $('.hidden_div_1').hide();
    // $('.hidden_div_2').show();
});


// Added by ranjit P on 19 Dec 3017 start
// Ajax request for delete highlighted products
function deleteHighlightedProduct(product_id) {
    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before removing the Highlighted Product",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/deleteHighlightedProduct',
            dataType:'json',
            data: {'product_id': product_id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 5000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + product_id).remove();
                        window.location.href = base_url + 'admin/highlight_products';
                    }, 5000);
                }
            }
        });
    });
}


// Added by ranjit P on 19 Dec 3017 start
// Ajax request for delete dow products
function deleteDOWProduct(product_id) {

    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",

        text: "Please confirm before removing the Deals of week Product",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/deleteDOWProduct',
            dataType:'json',
            data: {'product_id': product_id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 5000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + product_id).remove();
                        window.location.href = base_url + 'admin/dow_products';
                    }, 5000);
                }
            }
        });
    });
}

/*function deleteDowProduct(product_id) {
    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before removing the Deals of the day Product",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/deleteDowProduct',
            dataType:'json',
            data: {'product_id': product_id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 5000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        $('#id_delete_' + product_id).remove();
                        window.location.href = base_url + 'admin/dow_products';
                    }, 5000);
                }
            }
        });
    });
}*/



function markAsHighlightedProduct(chk_status,id,sale_type,product_name,price) {

    var base_url = $('#base_url').val();
    if(chk_status==1){
        var add_remove_flag=0;
        var alertMessage="Please confirm before remove product from Highlighted Product list";
    }else{
        var add_remove_flag=1;
        var alertMessage="Please confirm before marking as Highlighted Product";
    }

    swal({
        title: "Are you sure ?",
        text: alertMessage,
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {

            // ajax call
            $.ajax({
                type: "POST",
                url: base_url + 'admin/markAsHighlightedProduct',
                dataType:'json',
                data: {'highlighted_product_id': id,'sale_type':sale_type,'product_title':product_name,'price':price,'img_url':'banner-img4.jpg','add_remove_flag':add_remove_flag},
                success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 5000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        // $('#id_delete_' + id).remove();
                        window.location.href = base_url + 'admin/products';
                    }, 5000);
                }
            }
        });

        } else {           
           if($("#hp"+id).prop("checked")){
            $("#hp"+id).prop("checked",false);
        }else{
            $("#hp"+id).prop("checked",true);
        }

    }
});
}



function markAsDealOfWeekProduct(dow_chk_status,id){

    var base_url = $('#base_url').val();

    if(dow_chk_status==1){
        var add_remove_flag=0;
        var alertMessage="Please confirm before remove product from Deal of Week Product list";
    }else{
        var add_remove_flag=1;
        var alertMessage="Please confirm before marking as Deal of Week Product";
    }

    swal({
        title: "Are you sure ?",
        text: alertMessage,
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function (isConfirm) {

        if(isConfirm){
            // ajax call
            $.ajax({
                type: "POST",
                url: base_url + 'admin/markAsDOW',
                dataType:'json',
                data: {'dow_product_id': id,'add_remove_flag':add_remove_flag},
                success: function (response) {
                    // check the response status
                    if(response.status == '0') {
                        setTimeout(function () {
                            swal(response.message);
                        }, 5000);
                    } else {
                        setTimeout(function () {
                            swal(response.message);
                        // $('#id_delete_' + id).remove();
                        window.location.href = base_url + 'admin/products';
                    }, 5000);
                    }
                }
            });

        } else {           
            if($("#dow"+id).prop("checked")){
                $("#dow"+id).prop("checked",false);
            }else{
                $("#dow"+id).prop("checked",true);
            }
        }

    });
}


function markAsOnSaleProduct(os_chk_status,id){

    var base_url = $('#base_url').val();

    if(os_chk_status==1){
        var add_remove_flag=0;
        var alertMessage="Please confirm before remove product from On Sale Product list";
    }else{
        var add_remove_flag=1;
        var alertMessage="Please confirm before marking as On Sale Product";
    }

    swal({
        title: "Are you sure ?",
        text: alertMessage,
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function (isConfirm) {

        if(isConfirm){
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/markAsOS',
            dataType:'json',
            data: {'os_product_id': id,'add_remove_flag':add_remove_flag},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    setTimeout(function () {
                        swal(response.message);
                    }, 5000);
                } else {
                    setTimeout(function () {
                        swal(response.message);
                        // $('#id_delete_' + id).remove();
                        window.location.href = base_url + 'admin/products';
                    }, 5000);
                }
            }
        });
    } else {           
        if($("#os"+id).prop("checked")){
            $("#os"+id).prop("checked",false);
        }else{
            $("#os"+id).prop("checked",true);
        }
    }
});
}

//Added by ranjit on 22 dec 2017
function readURL1(input, image_id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + image_id)
            .attr('src', e.target.result)
            //.width(width)
            //.height(height);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// Added by ranjit P on 19 Dec 3017 End

function lp_cms_validation(){

    if(!fileValidation('headerBanner')){
        swal('Please select valid Header Banner image');
        return false;
    }else if(!fileValidation('footerBanner')){
        swal('Please select valid Footer Banner image');
        return false;
    }else{
        $("#wizard-arrow").submit();
    }

}

function fileValidation(fileid){
    var fileInput = document.getElementById(fileid);
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath) && filePath!=''){
        return false;
    } else {
        return true;
    }
}

/* validation of file for import brands using CSV */
function fileBrandValidation() {

    var fileInput = document.getElementById('browse_brand');
    // console.log(fileInput);
    var filePath = fileInput.value;
    var allowedExtensions = /(\.csv)$/i;
    
    if (fileInput.files && fileInput.files[0]) {
        if(!allowedExtensions.exec(filePath)) {
            swal("File type extension is invalid !", "Select the CSV file for upload");
            fileInput.value = '';
            return false;
        }
    }
}


// check the form validation
function checkBrandFormValid() {

    if (document.getElementById('browse_brand').value == "") {
        swal("Browse the CSV file");
        return false;
    } else {
        return true;
    }

    return false;
}

/******************* import products using CSV file validation ***********************/
function fileTaxesValidation() {

    var fileInput = document.getElementById('browse_taxes');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.csv)$/i;
    
    if (fileInput.files && fileInput.files[0]) {
        if(!allowedExtensions.exec(filePath)) {
            swal("File type extension is invalid !", "Select the CSV file for upload");
            fileInput.value = '';
            return false;
        }
    } else {
        $('#id_submit_tax').html('<button id="id_submit_tax" type="submit" name="submit" class="btn btn-info">Loading <img style="width: 40px;height: 20px;" src="'+ base_url + 'backend/assets/img/loader.svg"></button>');
    }
}

function fileProductValidation() {

    var fileInput = document.getElementById('browse_product');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.csv)$/i;
    
    if (fileInput.files && fileInput.files[0]) {
        if(!allowedExtensions.exec(filePath)) {
            swal("File type extension is invalid !", "Select the CSV file for upload");
            fileInput.value = '';
            return false;
        }
    }
}


function imageZipValidation() {

    var fileInput = document.getElementById('browse_product_images');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.zip)$/i;
    
    if (fileInput.files && fileInput.files[0]) {
        if(!allowedExtensions.exec(filePath)) {
            swal("File type extension is invalid !", "Select the Zip file of product images");
            fileInput.value = '';
            return false;
        }
    }
}


// check the form validation
function checkProductFormValid() {

    if (document.getElementById('product_category').value == "") {
        swal("Select the category");
        return false;
    } else if (document.getElementById('browse_product').value == "") {
        swal("Browse the CSV file");
        return false;
    } else if(document.getElementById('browse_product_images').value == "") {
      swal("Browse the zip file of product images");
        return false;
    } else {
        return true;
    }

    return false;
}


//terms and condition CMS form validation
function checkTermsContent() {

    var contentLength = CKEDITOR.instances['terms_content'].getData().replace(/<[^>]*>/gi, '').length;
    if(contentLength == 0) {
        //swal("No content in ckeditor");
        $('#err_msg').html('<div class="alert alert-danger">No content in Editor. Please Enter Content Detail </div>')
        return false;            
    } else {
        return true;
    }
    return false;
}

function changeCommentStatus(comment_id, comment_status, blog_id) {

    var base_url = $('#base_url').val();

    $.ajax({
        type: "POST",
        url: base_url + 'admin/changeCommentStatus',
        dataType:'json',
        data: {'comment_id':comment_id, 'comment_status': comment_status},
        success: function (response) {
            // check the response status
            if(response.status == '0') {
                swal({title: response.message, type: "success"},
                    function() {
                       location.reload();
                });
            } else {
                swal({title: response.message, type: "success"},
                    function() {
                       location.reload();
                });
            }
        }
    });
}

function getArchievePost(date) {

}


function searchTaxFilter(page_num, filter = null) {

    var base_url = $('#base_url').val();
    page_num = page_num ? page_num : 0;

    $.ajax({
        type: 'POST',
        url: base_url + 'admin/ajaxPeginationTax/' + page_num,
        data: 'page=' + page_num,
        beforeSend: function () {
            $('.loading').show();
        },
        success: function (html) {
            $('#id_tax_view').html('');
            $('#id_tax_view').html(html);
            $('.loading').fadeOut("slow");
        }
    });
}

function deleteTax(tax_id) {
    $.ajax({
        type: "POST",
        url: base_url + 'admin/manage_tax/delete/' + tax_id,
        success: function (data) {
            $("#attr_" + tax_id).remove();

            new PNotify({
                title: 'Success',
                text: 'Tax record deletet Successfully',
                type: 'error',
                styling: 'bootstrap3',
                nonblock: {
                    nonblock: false
                }
            });
        }
    });
}


// Ajax request to clear the taxes table data
function clearTaxesData(id) {
    
    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before clearing all data from taxes table",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/clearTaxesData',
            dataType:'json',
            data: {'id': id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    swal({title: response.message, type: "danger"},
                        function() {
                           location.reload();
                    });
                } else {
                    swal({title: response.message, type: "success"},
                        function() {
                           location.reload();
                    });
                }
            }
        });
    });
}

// change status of the order from backend
function changeOrderStatus(status, order_id) {

    var base_url = $('#base_url').val();

    swal({
        title: "Are you sure ?",
        text: "Please confirm before changing status of the order",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }, function () {
        // ajax call
        $.ajax({
            type: "POST",
            url: base_url + 'admin/changeOrderStatus',
            dataType:'json',
            data: {'status': status, 'order_id':order_id},
            success: function (response) {
                // check the response status
                if(response.status == '0') {
                    swal({title: response.message, type: "danger"},
                        function() {
                           location.reload();
                    });
                } else {
                    swal({title: response.message, type: "success"},
                        function() {
                           location.reload();
                    });
                }
            }
        });
    });
}