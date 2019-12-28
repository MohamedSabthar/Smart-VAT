<?php
use Illuminate\Http\Request;

use App\Vat;
use App\Vat_payer;
use App\Jobs\BusinessTaxNoticeJob;
use App\Mail\BusinessTaxNotice;

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

/**
 * Routes related to authentication
*/
Route::get('/', 'Auth\LoginController@showLoginForm')->name('root');  //site root shows the login form
Auth::routes(['verify' => true]);                                     //authentication routes with email verification
Route::name('password.')->group(
    function () {
        Route::post('change-password/{useId}', 'Auth\ChangePasswordController@changePassword')->name('change'); //password reset post
    }
);

/**
 * Routes related to admin
*/
Route::get('/employee-profile/{id}', 'AdminController@employeeProfile')->name('employee-profile');
Route::put('/employee-profile/{id}', 'AdminController@updateEmployeeProfile')->name('update-employee');
Route::get('/mangae-employee', 'AdminController@manageEmployee')->name('manage-employee');
Route::post('/assign-vat', 'AdminController@assignVatCategories')->name('assign-vat');
Route::get('/gloabl-conf', 'AdminController@globalConfiguration')->name('global-conf');

/**
 * Routes common to admin and employee
*/
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/language/{locale}', 'LanguageController@changeLanguage');  //language switcher
Route::get('/profile', 'EmployeeController@myProfile')->name('my-profile'); //view profile
Route::get('/mark-notification', 'EmployeeController@markNotification')->name('mark-notification'); //read notification as read

/**
 * Routes related to vat category (return view of the vat category)
*/
try {
    foreach (Vat::all() as $vat) {      //routes for all vat categories, VatPagesController contains methodes which show the forms
        Route::get("/$vat->route", 'VatPagesController@'.$vat->route)->name($vat->route);
    }
} catch (Exception $e) {
    echo "dynamic routes will only work after migration";
}

/**
 * Routes related to buisness tax
 *
 * all business tax related tax routes should starts with "/buisness"
 */

Route::get('/business/profile/{id}', 'vat\BusinessTaxController@buisnessProfile')->name('business-profile');
Route::get('/business/latest', 'vat\BusinessTaxController@latestPayment')->name('latest');
Route::post('/business/business-register/{id}', 'vat\BusinessTaxController@registerBusiness')->name('business-register');
Route::get('/business/payments/{shop_id}', 'vat\BusinessTaxController@businessPayments')->name('business-payments');
Route::post('/business/payments/{shop_id}', 'vat\BusinessTaxController@reciveBusinessPayments')->name('receive-business-payments');
Route::post('/business/get-business-types', 'vat\BusinessTaxController@getBusinestypes')->name('get-business-types');
Route::post('/business/get-business-types', 'vat\BusinessTaxController@getBusinestypes')->name('get-business-types');
Route::post('/business/check-payments', 'vat\BusinessTaxController@checkPayments')->name('check-business-payments'); //check all business payments for a given vat payer for quick payment option
Route::get('/business/quick-payments', 'vat\BusinessTaxController@viewQuickPayments')->name('get-business-quick-payments');
Route::post('/business/accept-quick-payments', 'vat\BusinessTaxController@acceptQuickPayments')->name('business-quick-payments');
Route::get('/business/generate-report', 'vat\BusinessTaxController@businessReportGeneration')->name('business-generate-report');
Route::post('/business/generation', 'vat\BusinessTaxController@generateReport')->name('business-report-view');
Route::post('/business/report-pdf', 'vat\BusinessTaxController@pdf')->name('business-report-pdf');
//business payment remove
Route::delete('/business/payment-remove/{id}', 'vat\BusinessTaxController@removePayment')->name('remove-payment');//soft delete business payment
Route::get('/business/payment-trash/{id}', 'vat\BusinessTaxController@trashPayment')->name('trash-payment');//trash business payment
Route::get('/business/payment-restore/{shop_id}', 'vat\BusinessTaxController@restorePayment')->name('restore-payment');//restore payment
Route::get('/business/payment-remove-permanent/{id}', 'vat\BusinessTaxController@destory')->name('remove-payment-permanent');// permanent delete
//business remove
Route::delete('/business/business-remove/{shop_id}', 'vat\BusinessTaxController@removeBusiness')->name('remove-business'); // soft delete business route
Route::get('/business/business-trash/{payer_id}', 'vat\BusinessTaxController@trashBusiness')->name('trash-business');// trash business
Route::get('/business/business-restore/{id}', 'vat\BusinessTaxController@restoreBusiness')->name('restore-business'); // restore business



Route::put('/business-profile/{id}', 'PayerController@updateVATpayerProfile')->name('update-vat-payer');


/**
 * Routes related to VAT Payer
 */

Route::get('/vat-payer', 'PayerController@payer')->name('vat-payer');
Route::get('/vat-payerbusinessPayment-list', 'PayerController@businessPaymentList')->name('payment-list');
Route::get('/vat-payer/{requestFrom}', 'Auth\VATpayerRegisterController@viewFrom')->name('payer-registration');
Route::post('/vat-payer/Payer-Register/{requestFrom}', 'Auth\VATpayerRegisterController@register')->name('vat-payer-registration');
Route::post('/nic_available/check', 'Auth\VATpayerRegisterController@check')->name('nic_available.check'); //Ajax url option
Route::get('/vat-payer/register', 'PayerController@register')->name('register-vat-payer');
Route::get('/vat-payer-profile', 'PayerController@profile')->name('vat-payer-profile');
Route::get('/vat-payerbusinessPayment-list', 'PayerController@businessPaymentList')->name('payment-list');

/**
 * Routes related to industrial tax
 *
 * all industrial tax related tax routes should starts with "/industrial"
 */

Route::get('/industrial/profile/{id}', 'vat\IndustrialTaxController@industrialProfile')->name('industrial-profile');
Route::post('/industrial/industrial-register/{id}', 'vat\IndustrialTaxController@registerIndustrialShop')->name('industrial-shop-register');
Route::get('/industrial/payments/{shop_id}', 'vat\IndustrialTaxController@industrialPayments')->name('industrial-payments');
Route::post('/industrial/payments/{shop_id}', 'vat\IndustrialTaxController@reciveIndustrialPayments')->name('receive-industrial-payments');
Route::post('/industrial/get-industrial-types', 'vat\IndustrialTaxController@getIndustrialtypes')->name('get-industrial-types');
Route::get('/industrial/quick-payments', 'vat\IndustrialTaxController@viewQuickPayments')->name('get-industrial-quick-payments');
Route::post('/industrial/check-payments', 'vat\IndustrialTaxController@checkPayments')->name('check-industrial-payments'); //check all business payments for a given vat payer for quick payment option
Route::post('/industrial/accept-quick-payments', 'vat\IndustrialTaxController@acceptQuickPayments')->name('industrial-quick-payments');
Route::delete('/industrial/payment-remove/{id}', 'vat\IndustrialTaxController@removePayment')->name('remove-industrial-payment');//soft delete business payment
Route::get('/industrial/payment-trash/{id}', 'vat\IndustrialTaxController@trashPayment')->name('industrial-trash-payment');//trash business payment
Route::get('/industrial/payment-restore/{id}', 'vat\IndustrialTaxController@restorePayment')->name('restore-industrial-payment');// restore business

Route::delete('/industrial/industrial-remove/{shop_id}', 'vat\IndustrialTaxController@removeIndustrialShop')->name('remove-inudstrial-shop'); // soft delete business route
Route::get('/industrial/industrial-trash/{payer_id}', 'vat\IndustrialTaxController@trashIndustrialShop')->name('trash-industrial-shop');// trash business
Route::get('/industrial/industrial-restore/{id}', 'vat\IndustrialTaxController@restoreIndustrialShop')->name('restore-industrial-shop'); // restore business


//shop rent tax
Route::get('/shop-rent/profile/{id}', 'vat\ShopRentTaxController@shoprentProfile')->name('shop-rent-profile');
Route::post('/shop-rent/shop-register/{id}', 'vat\ShopRentTaxController@registerShopRent')->name('shop-rent-register');

/**
 * Routes related to entertainment tax
 *
 * all entertainment tax related tax routes should starts with "/entertainment"
 */
Route::get('/entertainment/profile/{id}', 'vat\EntertainmentTaxController@entertainmentPayments')->name('entertainment-profile'); //profile only cosit of payments
Route::post('/entertainment/profile/{id}', 'vat\EntertainmentTaxController@reciveEntertainmentPayments')->name('receive-entertainment-payments');

/**
 * temperory testing routes
 */
Route::get('/mail-me', function () {
    for ($id=1;$id<=3;$id++) {
        dispatch(new  BusinessTaxNoticeJob($id));
    }
    dd('hi');
});

Route::get('/notify', function () {
    Illuminate\Support\Facades\Notification::send(App\User::find(1), new App\Notifications\BusinessTaxNoticeJobFailedNotification(20));
    dd('done');
});

Route::get('/my-notification', function () {
    $user = App\User::find(1);
    foreach ($user->unreadNotifications as $notification) { // unread notification
        echo $notification->data['data'];
    }
    $user->unreadNotifications->markAsRead(); //marking as read
    foreach ($user->notifications as $notification) {   //all notifications
        echo $notification->data['data'];
    }
});


Route::get('/restart', function () {
    Artisan::call('queue:restart');
    dd('done');
});

Route::get('/retry', function () {
    Artisan::call('queue:retry all');
    dd('done');
});

Route::get('/retry/{$id}', function () {
    Artisan::call("queue:retry $id");
    dd('done');
});