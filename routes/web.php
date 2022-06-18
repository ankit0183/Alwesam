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

Auth::routes();

Route::get('/installation_form', function(){
    return view('Installer.index');
})->name('installation_form');

//instaltion
Route::post('/installation', ['as'=>'/instaltion','uses'=>'instaltionController@index']);
// Route::post('/installation',function(){echo"hello";});

// password
Route::post('/password/forgot','PasswordResetController@forgotpassword');
Route::get('passwords/reset/{token}/{email}','PasswordResetController@geturl');
Route::post('/passwordchange', 'PasswordResetController@passwordnew');



//Dashboard

Route::get('/', ['middleware'=>'auth','uses'=>'HomeController@dashboard']);

Route::get('/dashboard/openservice', ['as'=>'/dashboard/openservice','uses'=>'HomeController@openservice']);
Route::get('/dashboard/closeservice', ['as'=>'/dashboard/closeservice','uses'=>'HomeController@closeservice']);
Route::get('/dashboard/upservice', ['as'=>'/dashboard/upservice','uses'=>'HomeController@upservice']);
Route::get('/dashboard/open-modal', ['as'=>'/dashboard/open-modal','uses'=>'HomeController@openmodel']);
Route::get('/dashboard/view/com-modal', ['as'=>'/dashboard/view/com-modal','uses'=>'HomeController@closemodel']);
Route::get('/dashboard/view/up-modal', ['as'=>'/dashboard/view/up-modal','uses'=>'HomeController@upmodel']);

Route::auth();

//profile

Route::get('setting/profile','Profilecontroller@index');
Route::post('/setting/profile/update/{id}','Profilecontroller@update');




// Customer
Route::group(['prefix'=>'customer','middleware'=>'auth'],function(){


Route::get('/add',['as'=>'customer/add','uses'=>'Customercontroller@customeradd']);
Route::post('/store',['as'=>'customer/store','uses'=>'Customercontroller@storecustomer']);
Route::get('/list',['as'=>'customer/list','uses'=>'Customercontroller@index']);
Route::get('/list/{id}',['as'=>'customer/list/{id}','uses'=>'Customercontroller@customershow']);
Route::get('/list/delete/{id}',['as'=>'customer/list/delete/{id}','uses'=>'Customercontroller@destory']);
Route::get('/list/edit/{id}',['as'=>'customer/list/edit/{id}','uses'=>'Customercontroller@customeredit']);
Route::post('/list/edit/update/{id}',['as'=>'customer/list/edit/update/{id}','uses'=>'Customercontroller@customerupdate']);
Route::get('/free-open',['as'=>'customer/free-open','uses'=>'Customercontroller@free_open_model']);
Route::get('/paid-open',['as'=>'/customer/paid-open','uses'=>'Customercontroller@paid_open_model']);
Route::get('/Repeatjob-modal',['as'=>'/customer/Repeatjob-modal','uses'=>'Customercontroller@repeat_job_model']);


// Route::get('/view/modal',['as'=>'/customer/view/modal','uses'=>'Customercontroller@view']);
// Route::get('/view/salesmodal',['as'=>'/customer/view/salesmodal','uses'=>'Customercontroller@salesview']);
// Route::get('/view/com-modal',['as'=>'/customer/view/com-modal','uses'=>'Customercontroller@commodal']);
// Route::get('/view/completedservice',['as'=>'/customer/view/completedservice','uses'=>'Customercontroller@servicecompleted']);
// Route::get('/view/upservice',['as'=>'/customer/view/upservice','uses'=>'Customercontroller@upservice']);
// Route::get('/view/upcomingservice',['as'=>'/customer/view/upcomingservice','uses'=>'Customercontroller@upcomingservice']);

});


//Vehical

Route::group(['prefix'=>'vehicle','middleware'=>'auth'],function(){


	Route::get('/decription',['as'=>'vehical/decription','uses'=>'VehicalControler@decription']);

	Route::get('/add',['as'=>'vehicle/add','uses'=>'VehicalControler@index']);
	Route::post('/store',['as'=>'vehical/store','uses'=>'VehicalControler@vehicalstore']);
	Route::get('/list',['as'=>'vehicle/list','uses'=>'VehicalControler@vehicallist']);
	Route::get('/list/delete/{id}',['as'=>'vehical/list/delete/{id}','uses'=>'VehicalControler@destory']);
	Route::get('list/edit/{id}',['as'=>'vehical/list/edit/{id}','uses'=>'VehicalControler@editvehical']);
	Route::post('list/edit/update/{id}',['as'=>'/vehical/list/edit/update/{id}','uses'=>'VehicalControler@updatevehical']);
	Route::get('/list/view/{id}',['as'=>'vehical/list/view/{id}','uses'=>'VehicalControler@vehicalshow']);
    Route::get('/vehicaltypefrombrand','VehicalControler@vehicaltype');

   //vihical type,brand,fuel,model

	Route::get('vehicle_type_add',['as'=>'vehical/vehicle_type_add','uses'=>'VehicalControler@vehicaltypeadd']);
	Route::get('/vehicaltypedelete',['as'=>'vehical/vehicaltypedelete','uses'=>'VehicalControler@deletevehicaltype']);


	Route::get('vehicle_brand_add',['as'=>'vehical/vehicle_brand_add','uses'=>'VehicalControler@vehicalbrandadd']);
	Route::get('/vehicalbranddelete',['as'=>'/vehical/vehicalbranddelete','uses'=>'VehicalControler@deletevehicalbrand']);


	Route::get('vehicle_fuel_add',['as'=>'vehical/vehicle_fuel_add','uses'=>'VehicalControler@fueladd']);
	Route::get('fueltypedelete',['as'=>'vehical/fueltypedelete','uses'=>'VehicalControler@fueltypedelete']);


	Route::get('add/getDescription','VehicalControler@getDescription');
	Route::get('delete/getDescription','VehicalControler@deleteDescription');
	Route::get('add/getImages','VehicalControler@getImages');
	Route::get('delete/getImages','VehicalControler@deleteImages');
	Route::get('add/getcolor','VehicalControler@getcolor');
	Route::get('delete/getcolor','VehicalControler@deletecolor');

	Route::get('vehicle_model_add','VehicalControler@add_vehicle_model');
	Route::get('vehicle_model_delete','VehicalControler@delete_vehi_model');



});

// vehical type

 Route::group(['prefix'=>'vehicletype','middleware'=>'auth'],function(){

    Route::get('/vehicletypeadd',['as'=>'/vehicletype/add' ,'uses'=>'VehicaltypesControler@index']);
    Route::post('/vehicaltystore',['as'=>'/vehicletype/vehicletystore' ,'uses'=>'VehicaltypesControler@storevehicaltypes']);
    Route::get('/list',['as'=>'/vehical/list' ,'uses'=>'VehicaltypesControler@vehicaltypelist']);
    Route::get('/list/delete/{id}',['as'=>'/vehical/list/delete/{id}' ,'uses'=>'VehicaltypesControler@destory']);
    Route::get('/list/edit/{id}',['as'=>'/vehical/list/edit/{id}' ,'uses'=>'VehicaltypesControler@editvehicaltype']);
    Route::post('/list/edit/update/{id}',['as'=>'/vehical/list/edit/update/{id}' ,'uses'=>'VehicaltypesControler@updatevehicaltype']);


  });

 //vehical brand

  Route::group(['prefix'=>'vehiclebrand','middleware'=>'auth'],function(){

       Route::get('/add',['as'=>'/vehicalbrand/list','uses'=>'VehicalbransControler@index']);
       Route::get('/list',['as'=>'/vehicalbrand/list','uses'=>'VehicalbransControler@listvehicalbrand']);
       Route::post('/store',['as'=>'/vehicalbrand/store','uses'=>'VehicalbransControler@store']);
       Route::get('/list/delete/{id}',['as'=>'/vehicalbrand/list/delete','uses'=>'VehicalbransControler@destory']);
       Route::get('/list/edit/{id}',['as'=>'/vehicalbrand/list/edit/{id}','uses'=>'VehicalbransControler@editbrand']);
       Route::post('/list/edit/update/{id}',['as'=>'/vehicalbrand/list/edit/update{id}','uses'=>'VehicalbransControler@brandupdate']);


  });

// Vehical Discriptions

 Route::group(['prefix'=>'vehicaldiscriptions','middleware'=>'auth'],function(){

 	Route::get('/add',['as'=>'/vehicaldiscriptions/list','uses'=>'VehicalDiscriptionsControler@index']);
  Route::post('/store',['as'=>'/vehicaldiscriptions/list','uses'=>'VehicalDiscriptionsControler@vehicalstore']);
  Route::get('/list',['as'=>'/vehicaldiscriptions/list','uses'=>'VehicalDiscriptionsControler@vehicaldeslist']);
  Route::get('/list/delete/{id}',['as'=>'/vehicaldiscriptions/list/delete/{id}','uses'=>'VehicalDiscriptionsControler@destory']);
   Route::get('/list/edit/{id}',['as'=>'/vehicaldiscriptions/list/edit/{id}','uses'=>'VehicalDiscriptionsControler@editdescription']);
  Route::post('/list/edit/update/{id}',['as'=>'/vehicaldiscriptions/list/edit/update/{id}','uses'=>'VehicalDiscriptionsControler@updatedescription']);
 });







//Services
Route::group(['prefix'=>'service','middleware'=>'auth'],function(){

  Route::get('add',['as'=>'service/add','uses'=>'ServicesControler@index']);
  Route::get('get_vehi_name',['as'=>'service/add','uses'=>'ServicesControler@get_vehicle_name']);
  Route::post('store',['as'=>'service/store','uses'=>'ServicesControler@store']);
  Route::get('list',['as'=>'service/list','uses'=>'ServicesControler@servicelist']);
  Route::get('list/delete/{id}',['as'=>'service/list/delete/{id}','uses'=>'ServicesControler@destory']);
  Route::get('list/edit/{id}',['as'=>'service/list/edit/{id}','uses'=>'ServicesControler@serviceedit']);
  Route::post('list/edit/update/{id}',['as'=>'service/list/edit/update/{id}','uses'=>'ServicesControler@serviceupdate']);
  Route::get('list/view',['as'=>'service/list/view','uses'=>'ServicesControler@serviceview']);
  Route::post('add_jobcard','ServicesControler@add_jobcard');
  Route::get('select_checkpt','ServicesControler@select_checkpt');
  Route::get('get_obs','ServicesControler@Get_Observation_Pts');
  Route::get('used_coupon_data','ServicesControler@Used_Coupon_Data');
  Route::get('getregistrationno','ServicesControler@getregistrationno');

  Route::POST('/customeradd','ServicesControler@customeradd');
  Route::get('/vehicleadd','ServicesControler@vehicleadd');
});

//Invoice

Route::group(['prefix'=>'invoice','middleware'=>'auth'],function(){

	Route::get('/list','InvoiceController@showall');
	Route::get('/add','InvoiceController@index');
	Route::get('/add/{id}','InvoiceController@index');
	Route::get('/sale_part_invoice/add','InvoiceController@sale_part_index');
	Route::get('/sale_part_invoice/add/{id}','InvoiceController@sale_part_index');
	Route::post('/store','InvoiceController@store');
	Route::post('/sale_part_invoice/store','InvoiceController@store');
	Route::get('/get_jobcard_no','InvoiceController@get_jobcard_no');
	Route::get('/get_service_no','InvoiceController@get_service_no');
	Route::get('/get_invoice','InvoiceController@get_invoice');
	Route::get('/list/edit/{id}','InvoiceController@edit');
	Route::post('/list/edit/update/{id}','InvoiceController@update');
	Route::get('/list/delete/{id}','InvoiceController@destroy');
	Route::get('/sales_customer','InvoiceController@sales_customer');
	Route::get('/get_vehicle','InvoiceController@get_vehicle');
	Route::get('/get_part','InvoiceController@get_part');
	Route::get('/get_vehicle_total','InvoiceController@get_vehicle_total');
	Route::get('/pay/{id}','InvoiceController@pay');
	Route::post('/pay/update/{id}','InvoiceController@payupdate');
	Route::get('/payment/paymentview','InvoiceController@paymentview');
	Route::get('/sale_part','InvoiceController@viewSalePart');

});
Route::get('/invoice/servicepdf/{id}','InvoiceController@servicepdf');
Route::get('/invoice/salespdf/{id}','InvoiceController@salespdf');
Route::post('/invoice/stripe','InvoicePaymentController@stripe');
Route::post('/invoice/stripe','InvoicePaymentController@stripe');



//Change language and timezone and language direction

Route::group(['prefix'=>'setting','middleware'=>'auth'],function(){

Route::get('/list',['as'=>'listlanguage','uses'=>'Languagecontroller@index']);
Route::post('/language/store',['as'=>'storelanguage','uses'=>'Languagecontroller@store']);
Route::get('/timezone/list',['as'=>'timezonelist','uses'=>'Timezonecontroller@index']);
Route::post('/timezone/store',['as'=>'storetimezone','uses'=>'Timezonecontroller@store']);
Route::post('/date/store',['as'=>'storetimezone','uses'=>'Timezonecontroller@datestore']);
//language
Route::get('language/direction/list',['as'=>'listlanguagedirection','uses'=>'Languagecontroller@index1']);
Route::post('language/direction/store',['as'=>'storelanguagedirection','uses'=>'Languagecontroller@store1']);
//accessrights
Route::get('accessrights/list',['as'=>'accessrights/list','uses'=>'Accessrightscontroller@index']);
Route::GET('/accessrights/store',['as'=>'/accessrights/store','uses'=>'Accessrightscontroller@store']);
Route::GET('/accessrights/Employeestore',['as'=>'/accessrights/Employeestore','uses'=>'Accessrightscontroller@Employeestore']);
Route::GET('/accessrights/staffstore',['as'=>'/accessrights/staffstore','uses'=>'Accessrightscontroller@staffstore']);
Route::GET('/accessrights/Accountantstore',['as'=>'/accessrights/Accountantstore','uses'=>'Accessrightscontroller@Accountantstore']);

//general_setting
Route::get('general_setting/list','GeneralController@index');
Route::post('general_setting/store','GeneralController@store');
//hours
Route::get('hours/list','HoursController@index');
Route::post('hours/store','HoursController@hours');
Route::post('holiday/store','HoursController@holiday');
Route::get('deleteholiday/{id}','HoursController@deleteholiday');
Route::get('/deletehours/{id}','HoursController@deletehours');
//currancy
Route::post('currancy/store','Timezonecontroller@currancy');
//custom field
Route::get('/custom/list','Customcontroller@index');
Route::get('custom/add','Customcontroller@add');
Route::post('custom/store','Customcontroller@store');
Route::get('custom/list/edit/{id}','Customcontroller@edit');
Route::post('custom/list/edit/update/{id}','Customcontroller@update');
Route::get('custom/list/delete/{id}','Customcontroller@delete');


});

//Country City State ajax
Route::get('/getstatefromcountry','CountryAjaxcontroller@getstate');
Route::get('/getcityfromstate','CountryAjaxcontroller@getcity');

//employee module
Route::group(['prefix'=>'employee'],function(){
Route::get('/list',['as'=>'listemployeee','uses'=>'employeecontroller@employeelist']);
Route::get('/add',['as'=>'addemployeee','uses'=>'employeecontroller@addemployee']);
Route::post('/store',['as'=>'storeemployeee','uses'=>'employeecontroller@store']);
Route::get('/edit/{id}',['as'=>'editemployeee','uses'=>'employeecontroller@edit']);
Route::patch('/edit/update/{id}','employeecontroller@update');
Route::get('/view/{id}','employeecontroller@showemployer');
Route::get('/list/delete/{id}',['as'=>'/employee/list/delete/{id}','uses'=>'employeecontroller@destory']);
Route::get('/free_service',['as'=>'/employee/free_service','uses'=>'employeecontroller@free_service']);
Route::get('/paid_service',['as'=>'/employee/paid_service','uses'=>'employeecontroller@paid_service']);
Route::get('/repeat_service',['as'=>'/employee/repeat_service','uses'=>'employeecontroller@repeat_service']);
});









//Color List Module

Route::group(['prefix'=>'color'],function(){
Route::get('/list',['as'=>'listcolor','uses'=>'Colorcontroller@index']);
Route::get('/add',['as'=>'addcolor','uses'=>'Colorcontroller@addcolor']);
Route::post('/store',['as'=>'storecolor','uses'=>'Colorcontroller@store']);
Route::get('/list/delete/{id}','Colorcontroller@destroy');
Route::get('/list/edit/{id}','Colorcontroller@edit');
Route::post('/list/edit/update/{id}','Colorcontroller@update');
});







//Job Card Module

Route::group(['prefix'=>'jobcard'],function(){
Route::get('/list',['as'=>'list/jobcard','uses'=>'JobCardcontroller@index']);
Route::get('/list/jview/{id}',['as'=>'list/jview','uses'=>'JobCardcontroller@indexid']);
Route::get('/list/{id}',['as'=>'viewjobcard','uses'=>'JobCardcontroller@view']);
Route::get('/add',['as'=>'addjobcard','uses'=>'JobCardcontroller@jobcard_add']);

Route::post('/store',['as'=>'jobcard/store','uses'=>'JobCardcontroller@store']);
Route::get('/gatepass',['as'=>'jobcard/gatepass','uses'=>'JobCardcontroller@gatepass']);
Route::post('/insert_gatedata',['as'=>'jobcard/insert','uses'=>'JobCardcontroller@insert_gatepass_data']);
Route::get('/list/add_invoice/{id}','JobCardcontroller@add_invoice');

});
Route::get('/observation','JobCardcontroller@addobservation');
Route::get('/jobcard/addproducts','JobCardcontroller@addproducts');
Route::get('/jobcard/getprice','JobCardcontroller@getprice');
Route::get('/jobcard/gettotalprice','JobCardcontroller@gettotalprice');
Route::get('/jobcard/modalview','JobCardcontroller@modalview');
Route::get('/jobcard/gatepass/autofill_data','JobCardcontroller@getrecord');
Route::get('/jobcard/gatepass/{id}','JobCardcontroller@gatedata');
Route::get('/jobcard/add/getrecord','JobCardcontroller@getpoint');

Route::get('/jobcard/addcheckpoint','JobCardcontroller@pointadd');
Route::get('/jobcard/addcheckresult','JobCardcontroller@addcheckresult');
Route::get('/jobcard/commentpoint','JobCardcontroller@commentpoint');
Route::get('/jobcard/list/modalget','JobCardcontroller@getview');
Route::get('/getpassdetail','JobCardcontroller@getpassinvoice');
Route::get('/jobcard/select_checkpt','JobCardcontroller@select_checkpt');
Route::get('/jobcard/get_obs','JobCardcontroller@Get_Observation_Pts');
Route::get('/jobcard/delete_on_reprocess','JobCardcontroller@delete_on_reprocess');
Route::get('/jobcard/oth_pro_delete','JobCardcontroller@oth_pro_delete');
Route::get('//jobcard/stocktotal','JobCardcontroller@stocktotal');

//Report Module

Route::group(['prefix'=>'report'],function(){

Route::get('/servicereport','Reportcontroller@service');
Route::post('/record_service','Reportcontroller@record_service');

});



//Clear Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
