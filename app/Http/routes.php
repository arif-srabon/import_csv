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

route::post('/permanentarea', 'Setup\AreaController@permanentareaList');
route::post('/area', 'Setup\AreaController@areaList');
route::post('/presentarea', 'Setup\AreaController@presentareaList');

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



//// API for Mobile App
//$api = app('Dingo\Api\Routing\Router');
//$api->version('v1', function ($api) {
//    $api->get('manufacturer', 'App\Http\Controllers\Api\V1\AppController@manufacturer');
//    $api->get('divisions', 'App\Http\Controllers\Api\V1\AppController@divisions');
//    $api->get('generics', 'App\Http\Controllers\Api\V1\AppController@generics');
//    $api->get('medicines/{type?}/{id?}', 'App\Http\Controllers\Api\V1\AppController@medicines');
//    $api->get('medicineinfo/{id}', 'App\Http\Controllers\Api\V1\AppController@medicinesInfo');
//
//    $api->post('appuser', 'App\Http\Controllers\Api\V1\AppUserController@store');
//    $api->patch('appuserupdate', 'App\Http\Controllers\Api\V1\AppUserController@update');
//    $api->get('appuser/{id}', 'App\Http\Controllers\Api\V1\AppUserController@userInfo');
//
//    $api->post('complaint', 'App\Http\Controllers\Api\V1\ComplaintController@store');
//    $api->patch('complaintupdate', 'App\Http\Controllers\Api\V1\ComplaintController@update');
//    $api->get('complaints/{id}', 'App\Http\Controllers\Api\V1\ComplaintController@complaints');
//    $api->get('complaintscount/{id}', 'App\Http\Controllers\Api\V1\ComplaintController@complaintsCount');
//});
//Registration

Route::get('registration/create','Trans\RegistrationController@create');
Route::post('/registration/read','Trans\RegistrationController@read');
Route::post('/registration/getDepartmentCode','Trans\RegistrationController@getDepartmentCode');
Route::post('/registration/getAge','Trans\RegistrationController@getAge');
Route::resource('registration','Trans\RegistrationController');
// route for import
Route::get('importfile','Import\ImportController@index');
Route::post('importfile/store','Import\ImportController@store');
//