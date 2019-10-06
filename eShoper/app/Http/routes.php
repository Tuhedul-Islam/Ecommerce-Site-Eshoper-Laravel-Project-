<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', function () {
    return view('layout');
});
*/


// Homepage Route..............................
Route::get('/', 'HomeController@index');
Route::get('/contact', 'HomeController@contact');
Route::get('/product_by_category/{category_id}', 'HomeController@show_product_by_category');
Route::get('/product_by_manufacture/{manufacture_id}', 'HomeController@show_product_by_manufacture');
Route::get('/view-single-product/{product_id}', 'HomeController@product_details_by_id');
//admin login page
Route::get('/admin', 'HomeController@admin_login_page');



//ManageOrder Related Route....................
Route::get('/manage-order', 'ManageOrderController@manage_order');
Route::get('/view-order-details/{order_id}', 'ManageOrderController@view_order_details');
Route::get('/delete-order/{order_id}', 'ManageOrderController@delete_order');
Route::get('/active-inactive-order/{order_id}', 'ManageOrderController@active_inactive_order');




//Checkout Related Route...........................
Route::get('/customer-login', 'CheckoutController@check_login'); //show login page only
Route::post('/customer-registration', 'CheckoutController@customer_registration');
Route::get('/checkout', 'CheckoutController@checkout');
Route::post('/save-shipping-details', 'CheckoutController@save_shipping_details');
Route::get('/payment', 'CheckoutController@payment');
Route::post('/order-place', 'CheckoutController@order_place');
//Customer Login & Logout
Route::get('/customer-logout', 'CheckoutController@customer_logout');
Route::post('/registered-customer-login', 'CheckoutController@registered_customer_login');




//Cart Related Route.................................
Route::post('/add-to-cart', 'CartController@add_to_cart');
Route::get('/show-cart', 'CartController@show_cart');
Route::get('/delete-cart-item/{rowId}', 'CartController@delete_cart_item');
Route::post('/update-cart-item', 'CartController@update_cart_item');




// Admin Route................................
Route::get('/dashbord', 'SuperAdminController@index');
Route::post('/admin-dashbord', 'AdminController@dashbord');
Route::get('/admin-profile', 'AdminController@admin_profile');
Route::post('/update-admin-profile/{admin_id}', 'AdminController@update_admin_profile');
Route::get('/logout', 'SuperAdminController@logout');




// Category Related Route
Route::get('/add-category', 'CategoryController@index');
Route::get('/all-category', 'CategoryController@all_category');
Route::post('/save-category', 'CategoryController@save_category');
Route::get('/edit-category/{category_id}', 'CategoryController@edit_category');
Route::post('/update-category/{category_id}', 'CategoryController@update_category');
Route::get('/delete-category/{category_id}', 'CategoryController@delete_category');
Route::get('/active-inactive-category/{category_id}/{status}', 'CategoryController@active_inactive_category');



//manufacture or Brand related route
Route::get('/add-manufacture', 'ManufactureController@index');
Route::post('/save-manufacture','ManufactureController@save_manufacture');
Route::get('/all-manufacture', 'ManufactureController@all_manufacture');
Route::get('/edit-manufacture/{manufacture_id}', 'ManufactureController@edit_manufacture');
Route::post('/update-manufacture/{manufacture_id}', 'ManufactureController@update_manufacture');
Route::get('/delete-manufacture/{manufacture_id}', 'ManufactureController@delete_manufacture');
Route::get('/active-inactive-manufacture/{manufacture_id}/{status}', 'ManufactureController@active_inactive_manufacture');



//Product related route
Route::get('/add-product', 'ProductController@index');
Route::post('/save-product','ProductController@save_product');
Route::get('/all-product','ProductController@all_product');
Route::get('/edit-product/{product_id}', 'ProductController@edit_product');
Route::post('/update-product/{product_id}', 'ProductController@update_product');
Route::get('/delete-product/{product_id}', 'ProductController@delete_product');
Route::get('/active-inactive-product/{product_id}/{status}', 'ProductController@active_inactive_product');




//Slider Related Route
Route::get('/add-slider', 'SliderController@index');
Route::post('/save-slider', 'SliderController@save_slider');
Route::get('/all-slider','SliderController@all_slider');
Route::get('/delete-slider/{slider_id}', 'SliderController@delete_slider');
Route::get('/active-inactive-slider/{slider_id}/{status}', 'SliderController@active_inactive_slider');




/*
//Route group
Route::group(['middleware'=>'CheckAdmin'], function (){

});
*/