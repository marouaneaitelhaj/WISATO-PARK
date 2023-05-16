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


Auth::routes(['verify' => true, 'register' => false]);

Route::get('/', 'HomeController@welcome')->name('site.home')->middleware(['install', 'update']);

Route::middleware(['installed','auth','xss_clean'])->group(function () {

	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('profile', 'UserController@profile')->name('user.profile');
	Route::put('profile/{user}', 'UserController@profileUpdate')->name('user.profile.update');


	Route::middleware('roles:admin')->group(function () {

		Route::get('user-list', 'UserController@index')->name('user.list');
		Route::get('user-status/{user}', 'UserController@status')->name('user.status');

		Route::get('user/getListForDataTable', 'UserController@getListForDataTable')->name('userListJson');

		Route::get('user-create', 'UserController@create')->name('user.create');
		Route::post('user-create', 'UserController@store')->name('user.store');

		Route::get('user-edit/{user}', 'UserController@edit')->name('user.edit');
		Route::put('user-edit/{user}', 'UserController@update')->name('user.update');

		Route::resource('category', 'CategoryController')->except(['show']);

		Route::resource('tariff', 'TariffController')->except(['show']);

		Route::get('reports', 'ReportController@index')->name('reports.index');
		Route::get('reports/pdf', 'ReportController@pdf_report')->name('reports.pdf_report');
		Route::get('general-settings', 'SiteController@generalSettings')->name('settings.create');
		Route::post('general-settings', 'SiteController@storeGeneralSettings')->name('settings.store');
		Route::resource('floors', 'FloorController')->except(['show']);
		// Route::get('floors', 'FloorController@index')->name('floors.list');

		Route::get('floors/change-status/{floor}', 'FloorController@statusChange')->name('floors.status_changes');
		Route::resource('parking-settings', 'CategoryWiseFloorSlotController', ['names' => 'parking_settings']);
		Route::get('parking-settings/change-status/{parking_setting}', 'CategoryWiseFloorSlotController@statusChange')->name('parking_settings.status_changes');
	});

	Route::middleware('roles:operator|admin')->group(function () {

		Route::resource('parking-crud', 'ParkingController', ['names' => 'parking'])->except(['show']);
		Route::get('parking/get-current', 'ParkingController@currentList')->name('parking.current_list');
		Route::get('parking/get-ended', 'ParkingController@endedList')->name('parking.ended_list');
		Route::get('parking/{parking}/end', 'ParkingController@end')->name('parking.end');
		Route::get('parking/{parking}/barcode', 'ParkingController@barcode')->name('parking.barcode');
		Route::post('parking/{parking}/pay', 'ParkingController@pay')->name('parking.pay');
		Route::post('parking/quick-end', 'ParkingController@quick_end')->name('parking.quick_end');
		Route::get('parking/slot/{category_id}', 'ParkingController@parkingSlot')->name('parking.slot');
	});
});

Route::fallback(function () {
	return response()->view('errors.404', ['error' => "Sorry! This page doesn't exist."], 404);
});
