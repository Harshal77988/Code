<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/* Frontend - routing start */
$route['default_controller'] = 'home/';
$route['login'] = 'auth/login';
$route['register'] = 'auth/register_user';
$route['categories'] = 'home/categories';
$route['my_account'] = 'home/my_account';
$route['track_order'] = 'home/track_order';
$route['my_orders'] = 'home/orderList';
$route['rented_products'] = 'home/myRentedProducts';
$route['order_details'] = 'home/orderDetails';
$route['about_us'] = 'home/aboutUs';
$route['contact_us'] = 'home/contact_us';
$route['privacy_policy'] = 'home/privacy_policy';

$route['blog-category-details-main/(:any)']  = 'home/blogCategoryDetailsMain/$1';
$route['blog-category-details']  = 'home/blogCategoryDetails';
$route['blog-category-details/(:any)']  = 'home/blogCategoryDetails/$1';
$route['blog-category-details/(:any)/(:any)']  = 'home/blogCategoryDetails/$1/$2';
$route['blog'] = 'home/blog';

$route['checkout'] = 'home/checkout';
$route['cart'] = 'home/cart';
// $route['home/product_list/(:num)/(:num)'] = 'home/product_list/$1/$1';
$route['product_detail/(:any)'] = 'home/product_detail/$1';
$route['404_override'] = 'home/error_404';
$route['paypal_buy'] = 'home/paypal_buy';
$route['wishlist'] = 'home/wishlist';
$route['blog/(:any)'] = 'home/blog/$1';
$route['payment_status'] = 'home/payment_success_status';
$route['returns_policy'] = 'home/returns_policy';
$route['terms'] = 'home/terms';


/* rent section routing */
// $route['rent_product_detail/(:any)/(:any)'] = 'home/rent_product_detail/$1/$1';


/* Frontend - routing end */



/* Backend - routing start */
$route['admin'] = 'admin';
$route['auth/customers'] = 'auth/customers';
$route['auth/edit_customer/(:any)'] = 'auth/edit_user/$1';

/* buy section routing */
$route['admin/products'] = 'admin/products';
$route['admin/import_products'] = 'admin/importProducts';
$route['admin/import_categories'] = 'admin/importCategories';
$route['admin/import_attributes'] = 'admin/importAttributes';
$route['admin/buy_categories'] = 'admin/buyProductCategories';
$route['admin/buy_sub_categories'] = 'admin/buyProductSubCategories';
$route['admin/buy_attributes'] = 'admin/buyProductAttributes';
$route['admin/buy_brands'] = 'admin/buyProductBrands';
$route['admin/import_brands'] = 'admin/importBrands';
$route['admin/edit_buy_attribute/(:any)'] = 'admin/ajaxEditBuyAttribute/$1';
$route['admin/add_products'] = 'admin/add_products';
$route['admin/edit_buy_products/(:any)'] = 'admin/editBuyProducts/$1';
$route['attribute_list'] = 'admin/attributes';
$route['admin/orders'] = 'admin/orders';
$route['admin/pre_orders'] = 'admin/preorders';
$route['admin/daily_reports'] = 'admin/dailyReports';
$route['admin/monthly_reports'] = 'admin/monthlyReports';
$route['admin/yearly_reports'] = 'admin/yearlyReports';
$route['admin/weekly_reports'] = 'admin/weeklyReports';
$route['admin/quarterly_reports'] = 'admin/quarterlyReports';
$route['admin/sales_report'] = 'admin/salesReport';
$route['admin/taxes'] = 'admin/manageTaxes';
$route['admin/order_details'] = 'admin/order_details';
$route['admin/rent_order_details'] = 'admin/rent_order_details';
$route['admin/notifications'] = 'admin/manageNotifications';
/* Buy section routing end */

/* Rent section routing */
$route['admin/rent_products'] = 'admin/rentProducts';
$route['admin/edit_rent_products/(:any)'] = 'admin/editRentProducts/$1';
$route['admin/add_rent_products'] = 'admin/addRentProducts';
$route['admin/rent_categories'] = 'admin/rentProductCategories';
$route['admin/rent_subcategories'] = 'admin/rentProductSubCategories';
$route['admin/coupons'] = 'admin_library/summary_discounts';
$route['admin/add_coupon'] = 'admin/addCoupon';
$route['admin/edit_coupon'] = 'admin/editCoupon';
$route['admin/rent_orders'] = 'admin/rentOrders';


/* Rent section routing end */

$route['admin/manage_footer'] = 'admin/manageFooterCMS';
$route['admin/manage_cms'] = 'admin/manageCMS';
$route['admin/manage_social_links'] = 'admin/manageSocialLinks';
$route['admin/highlight_products'] = 'admin/highlight_products';
$route['admin/edit_highlighted_product/(:any)'] = 'admin/editHighlightedProduct/$1';
$route['admin/edit_dow_product/(:any)'] = 'admin/editDOWProduct/$1';
$route['admin/landing_page_slider_cms'] = 'admin/landing_page_slider_cms';
$route['admin/update_landing_page_cms'] = 'admin/update_landing_page_cms';

//CMS section for about us page
$route['admin/about_cms']='admin/manage_cms/about';
$route['admin/policy_cms']='admin/manage_cms/policy';
$route['admin/contact_cms']='admin/manage_cms/contact';
$route['admin/edit_cms_page/(:any)'] ='admin/manage_cms/index/$1';
$route['admin/update_terms'] = 'admin/manage_cms/updateTerms';
/* Backend - routing end */



$route['blog-details/(:any)'] = 'home/blogDetails/$1';
$route['admin/blog_list'] = 'admin/viewBlogList';
$route['admin/add_blog'] = 'admin/addBlog';
$route['admin/edit_blog/(:any)'] = 'admin/editBlog/$1';
$route['admin/view_blog/(:any)'] = 'admin/viewBlog/$1';
$route['admin/blog_categories_list'] = 'admin/viewBlogCategoriesList';
$route['admin/add_blog_categories'] = 'admin/addBlogCategories';
$route['admin/edit_blog_categories/(:any)'] = 'admin/editBlogCategories/$1';


//$route['default_controller'] = 'welcome';
// $route['404_override'] = '';
//$route['translate_uri_dashes'] = FALSE;
