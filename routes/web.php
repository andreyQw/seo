<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->intended('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group([
    'prefix' => 'product',
//        'namespace' => 'Security',
    'middleware' => ['role:super_admin|admin', 'auth'],
],
    function () {
        Route::get('/list', 'ProductController@listProducts')->name('productList');
        Route::get('/addForm', 'ProductController@addFormProduct')->name('addFormProduct');
        Route::post('/addProduct', 'ProductController@saveNewProduct')->name('addNewProduct');

        Route::get('/editForm/{product}', 'ProductController@editFormProduct')->name('editFormProduct');
        Route::post('/editProduct/{product}', 'ProductController@editProduct')->name('editProduct');
        Route::post('editProd', 'ProductController@editProduct')->name('editProdPopup');
        Route::get('/delete/{product}', 'ProductController@deleteProduct')->name('product_delete');

        Route::post('/editProductStatus', 'ProductController@editProductStatus')->name('editProductStatus');
    });


Route::group([
    'prefix' => 'client',
    'middleware' => ['role:client|super_admin|admin|pm', 'auth'],
],
    function () {
        Route::resource('clients', 'ClientController');
//        Route::get('clients', 'AccountController@setAccountForm');
        Route::get('/websites/{id}', 'ClientController@web')->name('client.web');
        Route::post('/websites/add', 'ClientController@add_more')->name('placements.add_more');

        Route::get('/invoice/look/{id}', 'ClientController@look_invoice')->name('invoice.look');
        Route::get('/invoice/download/{id}', 'ClientController@download_invoice')->name('invoice.download');
        Route::post('websites/update', 'ClientController@load_updates')->name('load_updates_client');
        Route::post('websites/search', 'ClientController@search')->name('search_updates_client');
        Route::post('websites/store_comment', 'ClientController@store_comment')->name('store_comment_client');

});

Route::group([
    'prefix' => 'staff',
    'middleware' => ['auth', 'role:super_admin|admin|pm|production|partner|editor|writer'],
],
    function () {
        Route::resource('websites', 'WebsiteController');
        Route::post('websites/del_partner', 'WebsiteController@del_partner')->name('websites.del_partner');
        Route::post('websites/add_partner', 'WebsiteController@add_partner')->name('websites.add_partner');

        Route::post('websites/search', 'WebsiteController@search')->name('websites.search');
        Route::post('websites/update', 'WebsiteController@load_updates_nobs')->name('load_updates_nobs');
        Route::post('websites/store_comment_nobs', 'WebsiteController@store_comment_nobs')->name('store_comment_nobs');
        Route::post('websites/store_comment_with_client', 'WebsiteController@store_comment_client')->name('store_comment_with_client');

});
//Production
Route::group([
    'middleware' => ['role:super_admin|admin|pm|production|partner|editor|writer', 'auth'],
],
    function () {
        Route::resource('production', 'ProductionController');
        Route::post('/topic', 'ProductionController@topic_ajax')->name('production.topic_ajax');
        Route::post('/personalization_search', 'ProductionController@personalization_search')->name('personalization_search');
        Route::post('/content_search', 'ProductionController@content_search')->name('content_search');
        Route::post('/editor_search', 'ProductionController@editor_search')->name('editor_search');
        Route::post('/search_partner', 'ProductionController@search_partner')->name('search_partner');
        Route::post('/search_live', 'ProductionController@search_live')->name('search_live');
        Route::get('/content_manager', 'ProductionController@content_manager')->name('production.content_manager');
        Route::get('/editor_manager', 'ProductionController@editor_manager')->name('production.editor_manager');
        Route::get('/personalization_manager', 'ProductionController@personalization_manager')->name('production.personalization_manager');
        Route::get('/live_manager', 'ProductionController@live_manager')->name('production.live_manager');
    });



/* dev*/
Route::group(['prefix' => '/user', 'middleware' => ['role:super_admin|admin', 'auth']], function (){

    Route::get('/', 'ManagerStaffController@index')->name('staff_manager');
    Route::post('/create', 'ManagerStaffController@create_user')->name('createUser');
    Route::post('/card', 'ManagerStaffController@modal_user');
    Route::post('/delete', 'ManagerStaffController@delete_user')->name('deleteUser');
    Route::post('/edit', 'ManagerStaffController@edit_info_user')->name('edit');
    Route::post('/info', 'ManagerStaffController@info')->name('info');
    Route::group(['prefix' => '/sites', 'middleware' => ['role:super_admin|admin', 'auth']], function (){
    Route::post('/add', 'ManagerStaffController@add_site');
    Route::post('/delete', 'ManagerStaffController@delete_site');

    });

});

/* dev */
Route::group(['prefix' => '/settings', 'middleware' => ['auth']], function (){

    Route::get('/', 'UsersController@index')->name('settings');
    Route::post('/change_pass', 'UsersController@change_password')->name('change_pass');
    Route::post('/change_pi', 'UsersController@change_personal_info')->name('change_personal_info');
    Route::post('/change_notifi', 'UsersController@change_notifi')->name('change_notifi');
    Route::post('/stop_sending', 'UsersController@stop_sending')->name('stop_sending');

});

/* dev */
Route::group(['prefix' => '/link-anchor', 'middleware' => ['auth']], function () {

    Route::get('/{id?}', 'LinkAndAnchorController@index')->name('link_anchor');
    Route::post('/confirm', 'LinkAndAnchorController@confirm')->name('link_confirm');
    Route::post('/modal', 'LinkAndAnchorController@show_modal')->name('link_modal');
    Route::post('/admin/edit', 'LinkAndAnchorController@admin_edit')->name('admin_edit_anchors');
    Route::post('/client/edit', 'LinkAndAnchorController@client_edit')->name('client_edit_anchors');
    Route::post('/search', 'LinkAndAnchorController@search_project')->name('search_anchors');

});

/* dev*/
Route::group(['prefix' => '/bio', 'middleware' => ['auth']], function () {

    Route::get('/', 'BioManagerController@index')->name('bio_manager');
    Route::post('/help', 'BioManagerController@help_bio')->name('bio_help');
    Route::post('/confirm', 'BioManagerController@confirm')->name('bio_confirm');
    Route::get('/download/{id?}', 'BioManagerController@download_bio')->name('bio_download');
    Route::post('/modal', 'BioManagerController@view_modal')->name('bio_modal');
    Route::post('/edit', 'BioManagerController@edit_bio')->name('bio_edit')->middleware(['role:super_admin|admin|pm|']);
    Route::post('/search', 'BioManagerController@search_bio')->name('bio_search')->middleware(['role:super_admin|admin|pm|']);
    Route::get('/requests', 'BioManagerController@requests')->name('bio_request')->middleware(['role:super_admin|admin|pm|production']);
    Route::post('/requests/submit/{id}', 'BioManagerController@add_bio')->name('bio_add')->middleware(['role:super_admin|admin|pm|production']);

    Route::post('/requests/search', 'BioManagerController@search_request_bio')->name('bio_request_search')->middleware(['role:super_admin|admin|pm|production']);

});

/* dev*/
Route::group(['prefix' => '/partner', 'middleware' => ['auth', 'role:super_admin|admin|partner']], function (){

    Route::get('/', 'PartnersController@index')->name('partners');
    Route::post('/add', 'PartnersController@add')->name('add_partner');
    Route::post('/delete', 'PartnersController@delete')->name('delete_partner');
    Route::post('/search', 'PartnersController@search')->name('partner_search');
    Route::post('/edit', 'PartnersController@edit')->name('edit_info_partner');

});

/* dev */
Route::group(['prefix' => 'coupon', 'middleware' => ['auth', 'role:super_admin|admin']], function (){

    Route::resource('coupon', 'CouponController');
    Route::post('/status-change/{coupon}', 'CouponController@status_change')->name('coupon.status');
    Route::post('/search', 'CouponController@search')->name('coupon.search');

});

/* dev */
Route::group(['prefix' => '/sales', 'middleware' => ['auth', 'role:super_admin|admin']], function (){

    Route::get('/', 'SalesController@index')->name('sales');
    Route::post('/chart', 'SalesController@get_chart_data')->name('chart');

});

/* dev */
Route::group(['prefix' => '/feed', 'middleware' => ['auth']], function (){
    
    Route::get('/', 'FeedController@index')->name('feed');
    Route::post('/load', 'FeedController@load')->name('feed.load');
    
});

/* dev */
Route::group(['prefix' => '/account-manager', 'middleware' => ['auth', 'role:admin|super_admin|pm']], function (){

    Route::get('/', 'AccountController@index')->name('account.manager');
    Route::post('/add', 'AccountController@new_account')->name('account.manager.add');
    Route::post('/search', 'AccountController@search')->name('account.manager.search');

});

Route::get('/download/doc/{id}', 'ProductionController@download_doc_content')->name('download.doc.production')->middleware(['auth']);

Route::group([
    'prefix' => '/',
],
    function () {
        Route::get('/addFormOrder', 'OrderController@addFormOrder')->name('addFormOrder');
        Route::match(['get', 'post'], '/addOrder', 'OrderController@addOrder')->name('addOrder');

//        Route::post('pay', 'PayController@addPay')->name('addPay');
        Route::get('getPayForm/{order}', 'PayController@getPayForm')->name('getPayForm');

        Route::post('getCoupon', 'OrderController@getCoupon')->name('getCoupon');
        
        Route::match(['get', 'post'], 'payStripe/{order}', 'PayController@addPayStripe')->name('addPayStripe');

        Route::match(['get', 'post'], 'payPal/{order}', 'PaypalController@addPayTransaction')->name('addPaypal');
        Route::get('paypalPayment','PaypalController@getPaymentStatus')->name('paypal_status');
        Route::get('paypalCancel','PaypalController@getSubscriptionCancel')->name('paypalCancel');



        Route::group(
            ['prefix' => '/order', 'middleware' => ['auth']],
            function (){
//                Route::post('/ordersDateFilter', 'OrderController@ordersDateFilter')->name('ordersDateFilter');
//                Route::match(['get', 'post'], '/ordersDateFilter', 'OrderController@ordersDateFilter')->name('ordersDateFilter');
                Route::get( '/ordersDateFilter', 'OrderController@ordersDateFilter')->name('ordersDateFilter');
                Route::get( '/ordersNameFilter', 'OrderController@ordersNameFilter')->name('ordersNameFilter');
                Route::get( '/ordersOnHoldFilter', 'OrderController@ordersOnHoldFilter')->name('ordersOnHoldFilter');
                Route::get( '/ordersCompletedFilter', 'OrderController@ordersCompletedFilter')->name('ordersCompletedFilter');
                Route::get( '/ordersRefundedFilter', 'OrderController@ordersRefundedFilter')->name('ordersRefundedFilter');
                
                Route::post( '/approveOrder', 'OrderController@approveOrder')->name('approveOrder');
                Route::post( '/onHoldOrder', 'OrderController@onHoldOrder')->name('onHoldOrder');
                Route::post( '/refundedOrder', 'OrderController@refundedOrder')->name('refundedOrder');
                Route::post( '/deleteOrder', 'OrderController@deleteOrder')->name('deleteOrder');
                Route::get( '/getOrderAjax/{order_id}', 'OrderController@getOrderAjax')->name('getOrderAjax');

                Route::get('/invoice/look/{id}', 'ClientController@look_invoice')->name('orderInvoice');
                Route::get('/invoice/download/{id}', 'ClientController@download_invoice')->name('orderDownload');

                Route::post('/editOrder', 'OrderController@editOrder')->name('editOrder');

                Route::get('/overviewOrders', 'OrderController@overviewOrders')->name('overviewOrders');
                Route::get('/allOrdersClient', 'OrderController@allOrdersClient')->name('allOrdersClient');
                Route::get('/showOrder/{id}', 'OrderController@showOrder')->name('showOrder');
            });
    });

Route::group([
    'prefix' => 'account',
//        'namespace' => 'Security',
//    'middleware' => ['role:client|admin', 'auth'],
],
    function () {
//        Route::get('/setAccountForm', 'AccountController@setAccountForm')->name('setAccountForm');
        Route::get('/registration_success', 'AccountController@registrationSuccess')->name('registration_success');
        
        Route::get('/noBsDoBio/{project_id}', 'AccountController@noBsDoBio')->name('noBsDoBio');
        
        Route::get('/setAccountForm', 'AccountController@setAccountForm')
            ->name('setAccountForm')
            ->middleware(['role:client|admin', 'auth']);

        Route::post('/editAccount', 'AccountController@editAccount')
            ->name('editAccount')
            ->middleware(['role:client|admin', 'auth'])
        ;
        Route::post('/confirm_bio', 'AccountController@confirmBio')->name('confirmBio');

//            ->middleware(['role:client|admin', 'auth']);

    });


// TEST
Route::get('/testmail', 'HomeController@test_mails');

