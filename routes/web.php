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

// Route::resource('/home', 'HomeController');
Route::get('home', 'HomeController@index');
Route::get('home/lang/{one?}/{two?}/{three?}/{four?}/{five?}','HomeController@getLang');
Route::get('service', 'HomeController@index');
Route::get('about-us', 'HomeController@index');
Route::get('contact-us', 'HomeController@index');
Route::get('faq', 'HomeController@index');
Route::get('portpolio', 'HomeController@index');


// Route::resource('/user', 'UserController');
Route::get('/user/login', 'UserController@getlogin')->name('login');
Route::post('/user/signin', 'UserController@postSignin');
Route::post('/user/request/{one?}/{two?}/{three?}/{four?}/{five?}', 'UserController@postRequest');
Route::get('/user/profile', 'UserController@getProfile');
Route::get('/user/logout', 'UserController@getLogout');
Route::post('/user/saveprofile', 'UserController@postSaveprofile');
Route::post('/user/savepassword', 'UserController@postSavepassword');

//Route::controller('subscribers', 'SubscribersController');
Route::get('subscribers', 'SubscribersController@getIndex');
Route::get('subscribers/update/{id?}', 'SubscribersController@getUpdate');
Route::get('subscribers/show/{id}', 'SubscribersController@getShow');
Route::post('subscribers/save', 'SubscribersController@postSave');
Route::post('subscribers/delete', 'SubscribersController@postDelete');
Route::post('subscribers/comboselect', 'SubscribersController@postComboselect');
Route::get('subscribers/download', 'SubscribersController@getDownload');
Route::get('subscribers/download-active', 'SubscribersController@getDownloadActive');
Route::post('subscribers/multisearch', 'SubscribersController@postMultisearch');
Route::post('subscribers/filter', 'SubscribersController@postFilter');


// Route::controller('phonescategories', 'PhonescategoriesController');
Route::get('phonescategories', 'PhonescategoriesController@getIndex');
Route::get('phonescategories/update/{id?}', 'PhonescategoriesController@getUpdate');
Route::get('phonescategories/show/{id}', 'PhonescategoriesController@getShow');
Route::post('phonescategories/save', 'PhonescategoriesController@postSave');
Route::post('phonescategories/delete', 'PhonescategoriesController@postDelete');
Route::get('phonescategories/download', 'PhonescategoriesController@getDownload');
Route::post('phonescategories/multisearch', 'PhonescategoriesController@postMultisearch');
Route::post('phonescategories/filter', 'PhonescategoriesController@postFilter');

// Route::controller('phones', 'PhonesController');
Route::get('phones', 'PhonesController@getIndex');
Route::get('phone/fromFile', 'PhonesController@fromFileForm');
Route::get('phone/newSubscriberDownload', 'PhonesController@newSubscriberDownload');
Route::post('phone/saveFromFile', 'PhonesController@saveFromFile');
Route::post('phones/filter/{one?}/{two?}/{three?}/{four?}/{five?}', 'PhonesController@postFilter');
Route::post('phones/comboselect/{one?}/{two?}/{three?}/{four?}/{five?}', 'PhonesController@postComboselect');
Route::post('phones/save/{one?}/{two?}/{three?}/{four?}/{five?}', 'PhonesController@postSave');
Route::post('phones/delete/{one?}/{two?}/{three?}/{four?}/{five?}', 'PhonesController@postDelete');
Route::post('phones/multisearch/{one?}/{two?}/{three?}/{four?}/{five?}', 'PhonesController@postMultisearch');
Route::get('phones/update/{one?}/{two?}/{three?}/{four?}/{five?}', 'PhonesController@getUpdate');
Route::get('phones/show/{one?}/{two?}/{three?}/{four?}/{five?}', 'PhonesController@getShow');
Route::get('phones/download/{one?}/{two?}/{three?}/{four?}/{five?}', 'PhonesController@getDownload');

// Route::controller('subscriberhistory', 'SubscriberhistoryController');

Route::group(['middleware' => 'auth'], function () {

    Route::get('core/elfinder', 'Core\ElfinderController@getIndex');
    Route::post('core/elfinder', 'Core\ElfinderController@getIndex');

    // Route::controller('/dashboard', 'DashboardController');
    Route::get('/', 'DashboardController@getIndex');
    Route::get('/dashboard', 'DashboardController@getIndex');

    // Route::controllers([
    //     'core/logs' => 'Core\LogsController',
    //     'core/pages' => 'Core\PagesController',
    // ]);

    //'core/users'        => 'Core\UsersController',
    Route::get('/core/users', 'Core\UsersController@getIndex');
    Route::post('/core/users/filter', 'Core\UsersController@postFilter');
    Route::get('/core/users/update', 'Core\UsersController@getUpdate');
    Route::post('/core/users/delete', 'Core\UsersController@postDelete');
    Route::post('/core/users/save', 'Core\UsersController@postSave');
    Route::get('/core/users/show/{id}', 'Core\UsersController@getShow');
    Route::get('/core/users/update/{id}', 'Core\UsersController@getUpdate');

    //'core/groups'         => 'Core\GroupsController',
    Route::get('/core/groups', 'Core\GroupsController@getIndex');
    Route::post('/core/groups/filter', 'Core\GroupsController@postFilter');
    Route::get('/core/groups/update', 'Core\GroupsController@getUpdate');
    Route::get('/core/groups/download', 'Core\GroupsController@getDownload');
    Route::post('/core/groups/delete', 'Core\GroupsController@postDelete');
    Route::get('/core/groups/show/{id}', 'Core\GroupsController@getShow');
    Route::get('/core/groups/update/{id}', 'Core\GroupsController@getUpdate');
    Route::post('/core/groups/save', 'Core\GroupsController@postSave');

    //'core/template'     => 'Core\TemplateController',
    Route::get('/core/template', 'Core\TemplateController@getIndex');

});

Route::group(['middleware' => 'auth', 'middleware' => 'sximoauth'], function () {

    //'sximo/config'         => 'Sximo\ConfigController',
    Route::get('/sximo/config', 'Sximo\ConfigController@getIndex');
    Route::post('/sximo/config/save', 'Sximo\ConfigController@postSave');
    Route::get('/sximo/config/clearlog', 'Sximo\ConfigController@getClearlog');
    Route::get('/sximo/config/log', 'Sximo\ConfigController@getLog');

    //'sximo/module'         => 'Sximo\ModuleController',
    Route::get('/sximo/module', 'Sximo\ModuleController@getIndex');
    Route::get('/sximo/module/create', 'Sximo\ModuleController@getCreate');
    Route::get('/sximo/module/destroy/{id}', 'Sximo\ModuleController@getDestroy');
    Route::post('/sximo/module/create', 'Sximo\ModuleController@postCreate');
    Route::post('/sximo/module/create', 'Sximo\ModuleController@postCreate');
    Route::get('/sximo/module/config/{id}', 'Sximo\ModuleController@getConfig');
    Route::post('/sximo/module/saveconfig/{id}', 'Sximo\ModuleController@postSaveconfig');
    Route::post('/sximo/module/install', 'Sximo\ModuleController@postInstall');
    Route::post('/sximo/module/package', 'Sximo\ModuleController@postPackage');
    Route::post('/sximo/module/dopackage', 'Sximo\ModuleController@postDopackage');
    Route::get('/sximo/module/permission/{id}', 'Sximo\ModuleController@getPermission');
    Route::post('/sximo/module/savepermission/{id}', 'Sximo\ModuleController@postSavepermission');
    Route::get('/sximo/module/rebuild/{id}', 'Sximo\ModuleController@getRebuild');
    Route::get('/sximo/module/sql/{id}', 'Sximo\ModuleController@getSql');
    Route::post('/sximo/module/savesql/{id}', 'Sximo\ModuleController@postSavesql');
    Route::get('/sximo/module/table/{id}', 'Sximo\ModuleController@getTable');
    Route::post('/sximo/module/savetable/{id}', 'Sximo\ModuleController@postSavetable');
    Route::get('/sximo/module/conn/{id}', 'Sximo\ModuleController@getConn');
    Route::post('/sximo/module/conn/{id}', 'Sximo\ModuleController@postConn');
    Route::post('/sximo/module/combotable', 'Sximo\ModuleController@postCombotable');
    Route::post('/sximo/module/combotablefield', 'Sximo\ModuleController@postcombotablefield');
    Route::get('/sximo/module/form/{id}', 'Sximo\ModuleController@getForm');
    Route::post('/sximo/module/saveform/{id}', 'Sximo\ModuleController@postSaveform');
    Route::get('/sximo/module/editform/{id}', 'Sximo\ModuleController@getEditform');
    Route::get('/sximo/module/formdesign/{id}', 'Sximo\ModuleController@getFormdesign');
    Route::post('/sximo/module/formdesign/{id}', 'Sximo\ModuleController@postFormdesign');
    Route::get('/sximo/module/sub/{id}', 'Sximo\ModuleController@getSub');
    Route::get('/sximo/module/savesub/{id}', 'Sximo\ModuleController@postSavesub');
    Route::get('/sximo/module/build/{id}', 'Sximo\ModuleController@getBuild');
    Route::get('/sximo/module/dobuild/{id}', 'Sximo\ModuleController@postDobuild');

    //'sximo/tables'        => 'Sximo\TablesController'
    Route::get('/sximo/tables', 'Sximo\TablesController@getIndex');
    Route::get('/sximo/tables/tableconfig/{table}', 'Sximo\TablesController@getTableconfig');
    Route::get('/sximo/tables/sximo/tables/mysqleditor', 'Sximo\TablesController@getMysqleditor');

    //'sximo/menu'        => 'Sximo\MenuController',
    Route::get('/sximo/menu', 'Sximo\MenuController@getIndex');
    Route::get('/sximo/menu/index/{id}', 'Sximo\MenuController@getIndex');
    Route::post('/sximo/menu/saveorder', 'Sximo\MenuController@postSaveorder');
    Route::post('/sximo/menu/save', 'Sximo\MenuController@postSave');
    Route::get('/sximo/menu/destroy/{id}', 'Sximo\MenuController@getDestroy');

});

Route::group(['middleware' => 'auth'], function () {
    // apiAuth

    //Route::post('api/password/email', 'Api\Auth\PasswordController@postEmail');

    Route::get('api/news', 'Api\NewsController@getNews');
    //Route::post('api/news', 'Api\NewsController@postNews');

    Route::get('api/check', 'Api\ActivitiesController@getCheck');
    //Route::post('api/check', 'Api\ActivitiesController@postCheck');

    Route::get('api/exception', 'Api\ActivitiesController@getException');
    //Route::post('api/exception', 'Api\ActivitiesController@postException');

    Route::get('api/attendance', 'Api\ActivitiesController@getAttendance');
    //  Route::post('api/attendance', 'Api\ActivitiesController@postAttendance');

    Route::get('api/salary', 'Api\ActivitiesController@getSalary');
    //Route::post('api/salary', 'Api\ActivitiesController@postSalary');

});

Route::get('api/all', 'Api\ActivitiesController@getAll');
Route::get('api/password/email', 'Api\Auth\PasswordController@getEmail');
Route::post('api/password/email', 'Api\Auth\PasswordController@postEmail');
Route::post('api/check', 'Api\ActivitiesController@postCheck');
Route::post('api/exception', 'Api\ActivitiesController@postException');
Route::post('api/attendance', 'Api\ActivitiesController@postAttendance');
Route::post('api/salary', 'Api\ActivitiesController@postSalary');
Route::post('api/news', 'Api\NewsController@postNews');
Route::post('api/password/email', 'Api\Auth\PasswordController@postEmail');
Route::get('api/password/email', 'Api\Auth\PasswordController@getEmail');
Route::get('api/auth/login', 'Api\Auth\AuthController@getLogin');
Route::get('api/auth/logout', 'Api\Auth\AuthController@getLogout');
Route::post('api/auth/login', 'Api\Auth\AuthController@postLogin');
Route::get('api/inquiries', 'Api\InquiriesController@getInquiriesList');
Route::post('api/inquiriesList', 'Api\InquiriesController@postInquiriesList');
Route::get('api/inquiry', 'Api\InquiriesController@getInquiryView');
Route::post('api/inquiryView', 'Api\InquiriesController@postInquiryView');
Route::get('api/replay', 'Api\InquiriesController@getInquiryReply');
Route::post('api/replay', 'Api\InquiriesController@postInquiryReply');
Route::get('api/inquiryCreate', 'Api\InquiriesController@getInquiryCreate');
Route::post('api/inquiryCreate', 'Api\InquiriesController@postInquiryCreate');
Route::post('api/departments', 'Api\InquiriesController@postDepartments');
Route::post('api/employees', 'Api\InquiriesController@postEmployees');
Route::get('api/employees', 'Api\InquiriesController@getEmployees');
Route::get('api/checkApp', 'Api\DemoController@getAppStatus');
Route::post('api/checkApp', 'Api\DemoController@postAppStatus');
Route::get('api/last-activity', 'Api\ActivitiesController@getLastActivity');
Route::post('api/last-activity', 'Api\ActivitiesController@postLastActivity');
Route::get('api/username', 'Api\ProfileController@getUsername');
Route::post('api/username', 'Api\ProfileController@postUsername');
Route::get('api/avatar', 'Api\ProfileController@getAvatar');
Route::post('api/avatar', 'Api\ProfileController@postAvatar2');
Route::get('api/chat-login', 'Api\ActivitiesController@getChatLogin');
Route::post('api/chat-login', 'Api\ActivitiesController@postChatLogin');

//
Route::post('notifyclient', 'SubscribersController@notifyclient');
Route::post('notifyclient.php', 'SubscribersController@notifyclient');

Route::get('checksub', 'SubscribersController@checksub');
Route::get('checkphone', 'SubscribersController@checkphone');
Route::get('getPhone', 'SubscribersController@getPhone');

Route::get('addUpdateSubscriber', 'SubscribersController@addUpdateSubscriber');
Route::get('checkVcode', 'SubscribersController@checkVcode');
Route::get('setActiveWebLogin', 'SubscribersController@setActiveWebLogin');
Route::get('webAppLogin', 'SubscribersController@webAppLogin');
Route::get('setActiveWebLogout', 'SubscribersController@setActiveWebLogout');

// route by f
Route::get('phone/fromFile', 'PhonesController@fromFileForm');
Route::get('phone/newSubscriberDownload', 'PhonesController@newSubscriberDownload');
Route::post('phone/saveFromFile', 'PhonesController@saveFromFile');
Route::get('phone/newSubscriberDownload', 'PhonesController@newSubscriberDownload');

Route::post('api/checkExists', 'SubscribersController@checkExists');

Route::get('randomActiveSubscriber', 'SubscribersController@randomActiveSubscriber');
Route::get('downloadSubscribersCategory/{id}', 'PhonescategoriesController@downloadSub');

Route::get('updateSubscribers', 'SubscribersController@updateSubscribers');
//life time
Route::get('subscribe_liftime', 'SubscribersLifeTimeController@index');
Route::get('subscribe_liftime/search', 'SubscribersLifeTimeController@search');

require base_path('setting.php');