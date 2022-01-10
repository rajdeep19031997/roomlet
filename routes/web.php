<?php
use App\Http\Controllers\Allcontroller;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\DB;
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


  // Route::get('admin/feed', function () {
  //            // $feedback= DB::table('feedback')->get();
  //             // return $feedback;
  //        return view('feedback');
  //       })->name('admin.feed');

 //  Route::get('admin/edit', function (){
 // 	return view('editFeedback');
 // })->name('admin.edit');
 Route::get('admin/feed','App\Http\Controllers\TestController@showData')->name('admin.feed');
 Route::get('admin/feed/edit/{id}','App\Http\Controllers\TestController@fetchData')->name('admin.feed.edit');
 Route::get('admin/pay-description','App\Http\Controllers\TestController@pay_description')->name('admin.pay-description');
 Route::post('admin/pay-description/add','App\Http\Controllers\TestController@add_pay_description')->name('admin.pay-description.add');

// Route::get('admin/delete', function (){
// 	// $delete = DB::table('feedback')->delete;
//   echo "hello";
// })->name('admin.delete');

 // Route::post('admin/deletes',[Allcontroller::class,'updateData'])->name('admin.deletes');
  Route::post('admin/updates','App\Http\Controllers\TestController@updateData')->name('admin.updates');
  Route::get('admin/delete/{id}','App\Http\Controllers\TestController@destroy')->name('admin.delete');
 // Route::get('admin/updates', function (){
 // 	//$update = DB::table('feedback')->update;
 //    echo "hello";
 // })->name('admin.updates');

 // Route::get('/user', 'Allcontroller@updateData');
 Route::get('admin/packers_inserts','App\Http\Controllers\TestController@insert_packers')->name('admin.movers');
 Route::post('admin/insert','App\Http\Controllers\TestController@insertmaintenanceData')->name('admin.insert');
 Route::get('property-report/{type}/{name}','App\Http\Controllers\TestController@propertyReportFunction');
 Route::get('admin/property-report/list', function (){
 	return view('property-report');
 });
 Route::post('admin/add','App\Http\Controllers\TestController@pointsadd')->name('admin.add');

 
Route::get('/admin/maintenance/{show}', function (){
    return view('maintenance');
});

Route::get('/admin/maintenance/{show}/{id}', function (){
    return view('/maintenance');
});

Route::get('/services/{slug}', function (){
    return view('services');
});

Route::post('admin/maintenanceUpdate','App\Http\Controllers\TestController@maintenanceUpdateFunction');
Route::get('deleteMaintenance/{id}','App\Http\Controllers\TestController@deleteMaintenanceFunction');
 Route::post('/section','App\Http\Controllers\TestController@insert')->name('section');
 Route::post('/packers-movers','App\Http\Controllers\TestController@packers_email_insert')->name('packers_movers');

 Route::post('/test','App\Http\Controllers\TestController@testMail');
 Route::post('/razorpay-payment','App\Http\Controllers\TestController@paymentRent')->name('razorpay.payment');
 Route::get('/demo','App\Http\Controllers\DemoController@test_gateway');
  Route::get('/cronSave','App\Http\Controllers\TestController@cronSave');
  Route::get('/getSearchWise/{type}','App\Http\Controllers\TestController@getSearchWiseFunction');
  Route::post('admin/offerImageAdd','App\Http\Controllers\TestController@offerImageAddFunction');
  Route::post('admin/offerImageUpdate','App\Http\Controllers\TestController@offerImageUpdateFunction');
  Route::get('/deleteOffer/{id}','App\Http\Controllers\TestController@deleteOfferFunction');
  Route::post('admin/bankAccountUpdate','App\Http\Controllers\TestController@bankAccountUpdateFunction');
  Route::get('/activetionKyc/{userId}/{authorId}','App\Http\Controllers\TestController@activetionKycFunction');
  Route::get('/activeOwner/{userId}','App\Http\Controllers\TestController@activeOwnerFunction');

//  Route::get('/bookNow',function(){
//   return view('razorpay');
//   })->name('bookProperty');


  Route::get('/admin/packers', function () {
    return view('packers');
})->name('admin.packers');

  Route::get('/admin/points',function () {
    return view('points');
})->name('admin.points');


Route::get('/admin/offer-section/{show}', function (){
    return view('offer-section');
});

Route::post('/admin/offerImageAdd','App\Http\Controllers\TestController@offerImageAddFunction');


Route::get('/admin/offer-section/{show}/{id}', function (){
    return view('/offer-section');
});

Route::get('/admin/acc-details/{show}', function (){
    return view('acc-details');
});



Route::get('/admin/coupon-section/{show}', function (){
    return view('coupon-section');
});

Route::get('/admin/coupon-section/{show}/{id}', function (){
    return view('/coupon-section');
});


Route::post('admin/couponAdd','App\Http\Controllers\TestController@couponAddFunction');
Route::post('admin/couponUpdate','App\Http\Controllers\TestController@couponUpdateFunction');
Route::get('/deleteCoupon/{id}','App\Http\Controllers\TestController@deleteCouponFunction');
Route::post('admin/couponApply','App\Http\Controllers\TestController@couponApplyFunction');
Route::get('/searchSection','App\Http\Controllers\TestController@searchSectionFunction');
Route::get('/getDetailsSearch','App\Http\Controllers\TestController@getDetailsSearchFunction');

 

 

