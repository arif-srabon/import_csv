<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/setlang/{lang}', function ($lang) {
    Session::put('locale', $lang);
    return Redirect::back();
});

Route::get('/setColor/{color}', function ($color) {
    Session::put('color', $color);
    return Redirect::back();
});


Route::get('dashboard/{locale}', function ($locale) {
    session(['Lang' => $locale]);
    return redirect('/dashboard');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

/*
 * User and Auth module
 */

// security check
//Route::get('dashboard', [
//    'middleware' => ['permission:gpms.settings.deptdesignmap.view'],
//    'as' => 'dashboard', 'uses' => 'Jpuf\DashboardController@index'
//]);

Route::group(['middleware' => 'web'], function () {

    // security modules (user + role + permission + profile)
    Route::get('/', 'User\LoginController@index'); //login
    Route::post('/logincheck', 'User\LoginController@logincheck');
    Route::get('/logout', 'User\LoginController@logout');

    Route::get('/profile', 'User\ProfileController@edit');
    Route::patch('/saveprofile/{user}', 'User\ProfileController@update');
    Route::get('/passwd', 'User\ProfileController@changepassword');
    Route::patch('/savepasswd', 'User\ProfileController@updatePasswd');
    Route::get('/myaccesslog', 'User\ProfileController@index');
    ////////////////////////////////

    route::resource('/district', 'Setup\DistrictuiController');
    Route::resource('thanaupazilla', 'Setup\ThanaUpazillaiController');
    Route::resource('unionward', 'Setup\UnionWardController');
    Route::resource('thanaunionward', 'Setup\ThanaUnionWardController');

    //Manufacturer Router
    route::resource('/manufacturer', 'Setup\ManufacturerController');

});


//Route::get('/profile', 'User\ProfileController@edit');
//Route::patch('/saveprofile/{user}', 'User\ProfileController@update');
//Route::get('/passwd', 'User\ProfileController@changepassword');
//Route::patch('/savepasswd', 'User\ProfileController@updatePasswd');
//Route::get('/myaccesslog', 'User\ProfileController@index');

// security modules (user + role + permission + profile)
Route::post('/myaccesslog/read/{id}', 'User\ProfileController@read');


Route::get('/user', [
    'middleware' => ['permission:dss.security.users.view'],
    'as' => '/user', 'uses' => 'User\UserController@index'
]);
Route::post('/user/read', [
    'middleware' => ['permission:dss.security.users.view'],
    'as' => '/user/read', 'uses' => 'User\UserController@read'
]);
Route::get('/user/create', [
    'middleware' => ['permission:dss.security.users.add'],
    'as' => '/user/create', 'uses' => 'User\UserController@create'
]);
Route::post('/user', [
    'middleware' => ['permission:dss.security.users.add', 'web'],
    'as' => '/user', 'uses' => 'User\UserController@store'
]);
Route::get('/user/{id}/edit', [
    'middleware' => ['permission:dss.security.users.edit'],
    'as' => '/user/{id}/edit', 'uses' => 'User\UserController@edit'
]);
Route::patch('/user/{id}', [
    'middleware' => ['permission:dss.security.users.edit', 'web'],
    'as' => '/user/{id}', 'uses' => 'User\UserController@update'
]);
Route::post('/user/destroy', [
    'middleware' => ['permission:dss.security.users.del'],
    'as' => '/user/destroy', 'uses' => 'User\UserController@destroy'
]);

Route::get('/userpermission/{role}/edit', [
    'middleware' => ['permission:dss.security.users.permission'],
    'as' => '/userpermission/{role}/edit', 'uses' => 'User\PermissionController@editUserPermission'
]);

Route::post('/userpermissionsave', [
    'middleware' => ['permission:dss.security.users.permission'],
    'as' => '/userpermissionsave', 'uses' => 'User\PermissionController@updateUserPermssion'
]);

// end user routes

/**
 * User Routes
 */

//Route::get('/role', 'User\RoleController@index');
Route::post('/role/{type}', 'User\RoleController@operation');

Route::get('/role', [
    'middleware' => ['permission:dss.security.role.view'],
    'as' => '/role', 'uses' => 'User\RoleController@index'
]);
Route::post('/role/read', [
    'middleware' => ['permission:dss.security.role.view'],
    'as' => '/role/read', 'uses' => 'User\UserController@read'
]);
Route::get('/permission/{role}/edit', [
    'middleware' => ['permission:dss.security.role.permission'],
    'as' => '/permission/{role}/edit', 'uses' => 'User\PermissionController@edit'
]);

Route::post('/permissionsave', [
    'middleware' => ['permission:dss.security.role.permission'],
    'as' => '/permissionsave', 'uses' => 'User\PermissionController@update'
]);

// end user routes
//////////////////////////////////////////////////////

//
////common config router
Route::get('commonconfig', 'Setup\CommonConfigController@index');
Route::post('commonconfig/index/{category_id}', 'Setup\CommonConfigController@commonConfigList');
Route::post('/commonconfig/{type}/{table_name}', 'Setup\CommonConfigController@commonConfigData');
//
Route::get('dashboard', 'DashboardController@index');

//
// Setting -> Area
//
Route::get('/division', 'Setup\DivisionController@index');
Route::post('/division/{type}', 'Setup\DivisionController@division_data');
//
route::post('/district/read', 'Setup\DistrictuiController@read');
route::post('/district/destroy', 'Setup\DistrictuiController@destroy');
//
route::post('/thanaupazilla/read', 'Setup\ThanaUpazillaiController@read');
route::post('/thanaupazilla/destroy', 'Setup\ThanaUpazillaiController@destroy');
Route::get('/thanaupazilla/getDistrict/{id?}', 'Setup\ThanaUpazillaiController@getDistrict');

Route::get('/unionward/getUnionByThana/{id?}', 'Setup\ThanaUnionWardController@getUnionByThana');

//
Route::resource('/unionward', 'setup\UnionWardController');
route::post('/unionward/read', 'Setup\UnionWardController@read');
route::post('/unionward/destroy', 'Setup\UnionWardController@destroy');
Route::get('/unionward/getDistrict/{id?}', 'Setup\UnionWardController@getDistrict');
Route::get('/unionward/getThanaUpazillaByDistrict/{id?}', 'Setup\UnionWardController@getThanaUpazillaByDistrict');
Route::get('/unionward/getPaurasavaByDistrict/{id?}', 'Setup\UnionWardController@getPaurasavaByDistrict');
Route::get('/unionward/getCityCorpByDistrict/{id?}', 'Setup\UnionWardController@getCityCorpByDistrict');


/// Manufacturer ////////////////////////////////////////////////////////

Route::get('/manufacturer', [
    'middleware' => ['permission:settings.manufacturer.view'],
    'as'         => '/manufacturer',
    'uses'       => 'Setup\ManufacturerController@index'
]);
Route::post('/manufacturer/read', [
    'middleware' => ['permission:settings.manufacturer.view'],
    'as'         => '/manufacturer/read',
    'uses'       => 'Setup\ManufacturerController@read'
]);
Route::post('/manufacturer/destroy', [
    'middleware' => ['permission:settings.manufacturer.del'],
    'as'         => '/manufacturer/destroy',
    'uses'       => 'Setup\ManufacturerController@destroy'
]);

///////////////////////////////////////////////////////// Manufacturer //


/// ADR Reporting ///////////////////////////////////////////////////////

Route::get('/adrreporting', [
    'middleware' => ['permission:transactions.adrreporting.view'],
    'as'         => '/adrreporting/read',
    'uses'       => 'ADRReportingController@index'
]);
Route::post('/adrreporting/read', [
    'middleware' => ['permission:transactions.adrreporting.view'],
    'as'         => '/adrreporting/read',
    'uses'       => 'ADRReportingController@read'
]);
Route::get('/adrreporting/{id}/edit', [
    'middleware' => ['permission:transactions.adrreporting.edit'],
    'as'         => '/adrreporting/{id}/edit',
    'uses'       => 'ADRReportingController@edit'
]);
Route::get('/adrreporting/{id}/print', [
    'middleware' => ['permission:transactions.adrreporting.print'],
    'as'         => '/adrreporting/{id}/print',
    'uses'       => 'ADRReportingController@printADRReport'
]);
Route::resource('adrreporting', 'ADRReportingController');

/////////////////////////////////////////////////////// ADR Reporting ///

//////////////// medicine ///////////////////////////////////////////////
//Route::post('medicine/read', 'Setup\MedicineController@read');
//Route::post('medicine/destroy', 'Setup\MedicineController@destroy');

Route::get('/medicine', [
    'middleware' => ['permission:settings.medicine.view'],
    'as' => '/medicine', 'uses' => 'Setup\MedicineController@index'
]);
Route::post('/medicine/read', [
    'middleware' => ['permission:settings.medicine.view'],
    'as' => '/medicine/read', 'uses' => 'Setup\MedicineController@read'
]);
Route::get('/medicine/{role}/edit', [
    'middleware' => ['permission:settings.medicine.edit'],
    'as' => '/medicine/{role}/edit', 'uses' => 'Setup\MedicineController@edit'
]);
Route::post('/medicine/destroy', [
    'middleware' => ['permission:settings.medicine.del'],
    'as' => '/medicine/destroy', 'uses' => 'Setup\MedicineController@destroy'
]);
Route::resource('medicine', 'Setup\MedicineController');

////////////////////////////////////////////////////////////////////////////////

///////////// complaint ////////////////////////////////////////////////////////
//Route::post('complaint/read', 'Trans\ComplaintController@read');
//Route::get('complaint/{id}/print', 'Trans\ComplaintController@printComplaint');

Route::get('/complaint', [
    'middleware' => ['permission:transactions.complaint.view'],
    'as' => '/complaint', 'uses' => 'Trans\ComplaintController@index'
]);
Route::post('/complaint/read', [
    'middleware' => ['permission:transactions.complaint.view'],
    'as' => '/complaint/read', 'uses' => 'Trans\ComplaintController@read'
]);
Route::get('/complaint/{id}/edit', [
    'middleware' => ['permission:transactions.complaint.edit'],
    'as' => '/complaint/{id}/edit', 'uses' => 'Trans\ComplaintController@edit'
]);
Route::get('/complaint/{id}/print', [
    'middleware' => ['permission:transactions.complaint.print'],
    'as' => '/complaint/{id}/print', 'uses' => 'Trans\ComplaintController@printComplaint'
]);

Route::resource('complaint', 'Trans\ComplaintController');
/////////////////////////////////////////////////////////

//////////////////// new ////////////////////////////
//Route::post('news/read', 'Trans\NewsController@read');
//Route::post('news/destroy', 'Trans\NewsController@destroy');

Route::get('/news', [
    'middleware' => ['permission:transactions.news.view'],
    'as' => '/news', 'uses' => 'Trans\NewsController@index'
]);
Route::post('/news/read', [
    'middleware' => ['permission:transactions.news.view'],
    'as' => '/news/read', 'uses' => 'Trans\NewsController@read'
]);
Route::get('/news/{id}/edit', [
    'middleware' => ['permission:transactions.news.edit'],
    'as' => '/news/{id}/edit', 'uses' => 'Trans\NewsController@edit'
]);
Route::post('/news/destroy', [
    'middleware' => ['permission:transactions.news.del'],
    'as' => '/news/destroy', 'uses' => 'Trans\NewsController@destroy'
]);

Route::resource('news', 'Trans\NewsController');

///////////////////////////////////////////////////


/// Counterfeit Reporting ///////////////////////////////////////////////

Route::get('/counterfeit', [
    'middleware' => ['permission:transactions.counterfeit.view'],
    'as'         => '/counterfeit',
    'uses'       => 'CounterfeitReportingController@index'
]);
Route::post('/counterfeit/read', [
    'middleware' => ['permission:transactions.counterfeit.view'],
    'as'         => '/counterfeit/read',
    'uses'       => 'CounterfeitReportingController@read'
]);
Route::get('/counterfeit/{id}/edit', [
    'middleware' => ['permission:transactions.counterfeit.edit'],
    'as'         => '/counterfeit/{id}/edit',
    'uses'       => 'CounterfeitReportingController@edit'
]);
Route::get('/counterfeit/{id}/print', [
    'middleware' => ['permission:transactions.counterfeit.print'],
    'as'         => '/counterfeit/{id}/print',
    'uses'       => 'CounterfeitReportingController@printCounterfeitReport'
]);
Route::resource('counterfeit', 'CounterfeitReportingController');

/////////////////////////////////////////////// Counterfeit Reporting ///


// API for Mobile App
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->get('manufacturer', 'App\Http\Controllers\Api\V1\AppController@manufacturer');
    $api->get('divisions', 'App\Http\Controllers\Api\V1\AppController@divisions');
    $api->get('generics', 'App\Http\Controllers\Api\V1\AppController@generics');
    $api->get('medicines/{type?}/{id?}', 'App\Http\Controllers\Api\V1\AppController@medicines');
    $api->get('medicineinfo/{id}', 'App\Http\Controllers\Api\V1\AppController@medicinesInfo');

    $api->post('appuser', 'App\Http\Controllers\Api\V1\AppUserController@store');
    $api->patch('appuserupdate', 'App\Http\Controllers\Api\V1\AppUserController@update');
    $api->get('appuser/{id}', 'App\Http\Controllers\Api\V1\AppUserController@userInfo');

    $api->post('complaint', 'App\Http\Controllers\Api\V1\ComplaintController@store');
    $api->patch('complaintupdate', 'App\Http\Controllers\Api\V1\ComplaintController@update');
    $api->get('complaints/{id}', 'App\Http\Controllers\Api\V1\ComplaintController@complaints');
    $api->get('complaintscount/{id}', 'App\Http\Controllers\Api\V1\ComplaintController@complaintsCount');
});


//Web (Front End)
Route::get('home', 'Web\HomeController@index');
Route::get('login', 'Web\LoginController@index');
Route::post('/web/logincheck', 'Web\LoginController@logincheck');
Route::get('/web/logout', 'Web\LoginController@logout');
Route::get('register', 'Web\RegisterController@index');
Route::post('/register', [
    'middleware' => ['web'],
    'as' => '/register', 'uses' => 'Web\RegisterController@store'
]);

Route::get('/myprofile', 'Web\RegisterController@edit');
Route::patch('/savemyprofile/{user}', 'Web\RegisterController@update');
Route::get('/change-password', 'Web\RegisterController@changepassword');
Route::patch('/savechangepasswd', 'Web\RegisterController@updatePasswd');

Route::get('passwordreset/{id}/{token}', ['as' => 'reminders.edit', 'uses' => 'ReminderController@edit']);
Route::post('passwordreset/{id}/{token}', ['as' => 'reminders.update', 'uses' => 'ReminderController@update']);
Route::get('passwordreset', 'ReminderController@create');
Route::post('passwordreset', 'ReminderController@store');


Route::resource('complaints/complain', 'Web\ComplaintController');
Route::get('auto/profession', 'Web\ComplaintController@autoProfession');
Route::resource('complaints/counterfeit', 'Web\CounterfeitController');
Route::resource('complaints/counterfeit-mobile', 'Web\CounterfeitControllerMobile');

Route::resource('complaints/adr', 'Web\ADRController');
Route::resource('complaints/adr-mobile', 'Web\ADRControllerMobile');
Route::get('auto/medicinename', 'Web\ADRController@autoMedicineName');
Route::get('auto/medicinegeneric', 'Web\ADRController@autoMedicineGeneric');
Route::get('auto/manufacturername', 'Web\ADRController@autoManufacturerName');

Route::get('companies', 'Web\CompaniesController@index');
Route::post('companies/search', 'Web\CompaniesController@search');
Route::get('medicines', 'Web\MedicinesController@index');
Route::post('medicines/search', 'Web\MedicinesController@search');

Route::get('all-news', 'Web\NewsController@index');
Route::get('all-news/{id}', 'Web\NewsController@show');

Route::get('/area/getThanaUpazillaByDistrict/{id?}', 'Web\RegisterController@getThanaUpazillaByDistrict');
Route::get('/area/getUnionByThana/{id?}', 'Web\RegisterController@getUnionByThana');

Route::post('web/check-fake-medicine', 'Web\HomeController@fakeMedicineChecker');



///////////////// Manufacturer //////////////////////////////////////
//Route::post('medicinecode/read', 'Manufacturer\UniqueNumberController@read');
//Route::post('medicinecode/destroy', 'Manufacturer\UniqueNumberController@destroy');

Route::get('/medicinecode', [
    'middleware' => ['permission:manufacturer.uniquenumber.view'],
    'as' => '/medicinecode', 'uses' => 'Manufacturer\UniqueNumberController@index'
]);
Route::post('/medicinecode/read', [
    'middleware' => ['permission:manufacturer.uniquenumber.view'],
    'as' => '/medicinecode/read', 'uses' => 'Manufacturer\UniqueNumberController@read'
]);
Route::get('/medicinecode/{id}/edit', [
    'middleware' => ['permission:manufacturer.uniquenumber.edit'],
    'as' => '/medicinecode/{id}/edit', 'uses' => 'Manufacturer\UniqueNumberController@edit'
]);
Route::post('/medicinecode/destroy', [
    'middleware' => ['permission:manufacturer.uniquenumber.del'],
    'as' => '/medicinecode/destroy', 'uses' => 'Manufacturer\UniqueNumberController@destroy'
]);
Route::resource('medicinecode', 'Manufacturer\UniqueNumberController');

////////////////////////////////////////////////////////

// route for import
Route::get('importfile','Import\ImportController@index');
Route::post('importfile/store','Import\ImportController@store');
//