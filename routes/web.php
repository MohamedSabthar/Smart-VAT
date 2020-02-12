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
Route::put('/mangae-employee/promote', 'AdminController@promoteAsAdmin')->name('promote-to-admin');
Route::post('/assign-vat', 'AdminController@assignVatCategories')->name('assign-vat');
Route::get('/gloabl-conf', 'GlobalConfigurationController@globalConfiguration')->name('global-conf');
Route::get('/global-conf/business', 'GlobalConfigurationController@updateBusinessTaxForm')->name('global-conf-business-update');
Route::put('/global-conf/business/update-percentage', 'GlobalConfigurationController@updateBusinessPercentage')->name('update-business-percentage');
Route::put('/global-conf/business/update-assement-ranges', 'GlobalConfigurationController@updateBusinessAssessmentRanges')->name('update-business-assessment-range');
Route::get('/global-conf/business/types/{id}', 'GlobalConfigurationController@viewBusinessRangeTypes')->name('view-business-range-types');
Route::post('/global-conf/business/add-type/{id}', 'GlobalConfigurationController@addBusinessType')->name('add-business-type');
Route::put('/global-conf/business/update-type', 'GlobalConfigurationController@updateBusinessType')->name('update-business-type');

Route::get('/global-conf/industrial', 'GlobalConfigurationController@updateIndustrialTaxForm')->name('global-conf-industrial-update');
Route::put('/global-conf/industrial/update-percentage', 'GlobalConfigurationController@updateIndustrialPercentage')->name('update-industrial-percentage');
Route::put('/global-conf/industrial/update-assement-ranges', 'GlobalConfigurationController@updateIndustrialAssessmentRanges')->name('update-industrial-assessment-range');
Route::get('/global-conf/industrial/types/{id}', 'GlobalConfigurationController@viewIndustrialRangeTypes')->name('view-industrial-range-types');
Route::post('/global-conf/industrial/add-type/{id}', 'GlobalConfigurationController@addIndustrialType')->name('add-industrial-type');
Route::put('/global-conf/industrial/update-type', 'GlobalConfigurationController@updateIndustrialType')->name('update-industrial-type');

Route::get('/global-conf/entertainment', 'GlobalConfigurationController@updateEntertainmentTaxForm')->name('global-conf-entertainment-update');






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
Route::post('/business/Tax-report-pdf', 'vat\BusinessTaxController@TaxPdf')->name('business-tax-report-pdf');
Route::post('/business/Summary-report-pdf', 'vat\BusinessTaxController@summaryPdf')->name('business-summary-report-pdf');


//business payment remove
Route::delete('/business/payment-remove/{id}', 'vat\BusinessTaxController@removePayment')->name('remove-payment');//soft delete business payment
Route::get('/business/payment-trash/{id}', 'vat\BusinessTaxController@trashPayment')->name('trash-payment');//trash business payment
Route::get('/business/payment-restore/{shop_id}', 'vat\BusinessTaxController@restorePayment')->name('restore-payment');//restore payment
Route::delete('/business/payment-remove-permanent/{id}', 'vat\BusinessTaxController@destory')->name('remove-payment-permanent');// permanent delete
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
Route::post('/industrial/check-payments', 'vat\IndustrialTaxController@checkPayments')->name('check-industrial-payments'); //check all industrial payments for a given vat payer for quick payment option
Route::post('/industrial/accept-quick-payments', 'vat\IndustrialTaxController@acceptQuickPayments')->name('industrial-quick-payments');
Route::delete('/industrial/payment-remove/{id}', 'vat\IndustrialTaxController@removePayment')->name('remove-industrial-payment');//soft delete industrial payment
Route::get('/industrial/payment-trash/{id}', 'vat\IndustrialTaxController@trashPayment')->name('industrial-trash-payment');//trash industrial payment
Route::get('/industrial/payment-restore/{id}', 'vat\IndustrialTaxController@restorePayment')->name('restore-industrial-payment');// restore industrial

Route::delete('/industrial/industrial-remove/{shop_id}', 'vat\IndustrialTaxController@removeIndustrialShop')->name('remove-inudstrial-shop'); // soft delete industrial route
Route::get('/industrial/industrial-trash/{payer_id}', 'vat\IndustrialTaxController@trashIndustrialShop')->name('trash-industrial-shop');// trash industrial
Route::get('/industrial/industrial-restore/{id}', 'vat\IndustrialTaxController@restoreIndustrialShop')->name('restore-industrial-shop'); // restore industrial
Route::delete('/industrial/payment-remove-permanent/{id}', 'vat\IndustrialTaxController@destory')->name('industrial-remove-payment-permanent');// permanent delete

Route::get('/industrial/generate-report', 'vat\IndustrialTaxController@industrialReportGeneration')->name('industrial-generate-report');
Route::post('/industrial/generation', 'vat\IndustrialTaxController@generateReport')->name('industrial-report-view');

Route::post('/industrial/tax-report-pdf', 'vat\IndustrialTaxController@taxPdf')->name('industrial-tax-report-pdf');
Route::post('/industrial/summary-report-pdf', 'vat\IndustrialTaxController@summaryPdf')->name('industrial-summary-report-pdf');


//shop rent tax

Route::get('/shop-rent/profile/{id}', 'vat\ShopRentTaxController@shoprentProfile')->name('shop-rent-profile');
Route::post('/shop-rent/shop-register/{id}', 'vat\ShopRentTaxController@registerShopRent')->name('shop-rent-register');
Route::get('/shop-rent/payments/{shop_id}', 'vat\ShopRentTaxController@shopRentPayments')->name('shop-rent-payments');
Route::post('/shop-rent/payments{shop_id}', 'vat\ShopRentTaxController@reciveshopRentPayments')->name('receive-shop-rent-payments');
Route::get('/shop-rent/quick-payments', 'vat\ShopRentTaxController@viewQuickPayments')->name('get-shop-rent-quick-payments');
Route::post('/shop-rent/check-payments', 'vat\ShopRentTaxController@checkPayments')->name('check-shop-rent-payments'); //check all business payments for a given vat payer for quick payment option
Route::post('/shop-rent/accept-quick-payments', 'vat\ShopRentTaxController@acceptQuickPayments')->name('shop-rent-quick-payments');

Route::delete('/shop-rent/payment-remove/{id}', 'vat\ShopRentTaxController@removePayment')->name('remove-shop-rent-payment');//soft delete business payment
Route::get('/shop-rent/payment-trash/{id}', 'vat\ShopRentTaxController@trashPayment')->name('shop-rent-trash-payment');//trash business payment
Route::get('/shop-rent/payment-restore/{id}', 'vat\ShopRentTaxController@restorePayment')->name('restore-shop-rent-payment');// restore business

Route::delete('/shop-rent/industrial-remove/{shop_id}', 'vat\ShopRentTaxController@removeShopRent')->name('remove-shop-rent'); // soft delete business route
Route::get('/shop-rent/industrial-trash/{payer_id}', 'vat\ShopRentTaxController@trashShopRent')->name('trash-shop-rent');// trash business
Route::get('/shop-rent/industrial-restore/{id}', 'vat\ShopRentTaxController@restoreShopRent')->name('restore-shop-rent'); // restore business




/**
 * Routes related to entertainment tax
 *
 * all entertainment tax related tax routes should starts with "/entertainment"
 */
Route::get('/entertainment/profile/{id}', 'vat\EntertainmentTaxController@entertainmentPayments')->name('entertainment-profile'); //profile only cosit of payments
Route::post('/entertainment/profile/{id}', 'vat\EntertainmentTaxController@reciveEntertainmentPayments')->name('receive-entertainment-payments');
Route::delete('/entertainment/ticket-payment-remove/{id}', 'vat\EntertainmentTaxController@removeTicketPayment')->name('remove-entertainment-payment');//soft delete entertainment payment
Route::get('/entertainment/ticket-payment-trash/{id}', 'vat\EntertainmentTaxController@trashTicketPayment')->name('entertainment-ticket-trash-payment');//trash entertainment payment
Route::get('/entertainment/ticket-payment-restore/{id}', 'vat\EntertainmentTaxController@restoreTicketPayment')->name('restore-entertainment-payment');// restore entertainment
Route::put('/entertainment/ticket-payment-update/{id}', 'vat\EntertainmentTaxController@updateTicketPayment')->name('update-entertainment-ticket-payments');

Route::get('/entertainment/performance-tax/{id}', 'vat\EntertainmentTaxController@showPerformanceTaxForm')->name('entertainment-performance-tax'); // restore industrial
Route::post('/entertainment/performance-payments/{id}', 'vat\EntertainmentTaxController@recievePerformancePayments')->name('receive-performance-entertainment-payments');
Route::delete('/entertainment/performance-payment-remove/{id}', 'vat\EntertainmentTaxController@removePerformancePayment')->name('remove-entertainment-performance-payment');//soft delete performance payment
Route::get('/entertainment/performance-payment-trash/{id}', 'vat\EntertainmentTaxController@trashPerformancePayment')->name('entertainment-performance-trash-payment');//trash performance payment
Route::get('/entertainment/performance-payment-restore/{id}', 'vat\EntertainmentTaxController@restorePerformancePayment')->name('restore-entertainment-performance-payment');// restore entertainment
Route::delete('/entertainment/payment-ticket-remove-permanent/{id}', 'vat\EntertainmentTaxController@destoryTicket')->name('entertainment-remove-ticket-payment-permanent');// permanent delete
Route::delete('/entertainment/payment-performance-remove-permanent/{id}', 'vat\EntertainmentTaxController@destoryPerformance')->name('entertainment-remove-ticket-performance-permanent');// permanent delete
Route::put('/entertainment/performance-payment-update/{id}', 'vat\EntertainmentTaxController@updatePerformancePayment')->name('update-entertainment-performance-payments');

Route::get('/entertainment/generate-ticket-report', 'vat\EntertainmentTaxController@entertainmentTicketReportGeneration')->name('entertainment-generate-ticket-report');
Route::post('/entertainment/ticket/generation', 'vat\EntertainmentTaxController@generateTicketReport')->name('entertainment-ticket-report-view');

Route::post('/entertainment/ticket-tax-report-pdf', 'vat\EntertainmentTaxController@ticketTaxPdf')->name('entertainment-ticket-tax-report-pdf');
Route::post('/entertainment/ticket-summary-report-pdf', 'vat\EntertainmentTaxController@ticketSummaryPdf')->name('entertainment-ticket-summary-report-pdf');


Route::get('/entertainment/generate-performance-report', 'vat\EntertainmentTaxController@entertainmentPerformanceReportGeneration')->name('entertainment-generate-performance-report');
Route::post('/entertainment/performance/generation', 'vat\EntertainmentTaxController@generatePerformanceReport')->name('entertainment-performance-report-view');

Route::post('/entertainment/performance-tax-report-pdf', 'vat\EntertainmentTaxController@performanceTaxPdf')->name('entertainment-performance-tax-report-pdf');
Route::post('/entertainment/performance-summary-report-pdf', 'vat\EntertainmentTaxController@performanceSummaryPdf')->name('entertainment-performance-summary-report-pdf');


/**
 * mailing routes
 */
Route::get('/business/business-notice/{id}', 'vat\BusinessTaxController@sendNotice')->name('business-send-notice');
Route::get('/retry-business-notification/{id}/{notify}', 'RetryNoticeController@retryBusinessNotice')->name('retry-business-notice');
Route::get('/retry-industrial-notification/{id}/{notify}', 'RetryNoticeController@retryIndustrialNotice')->name('retry-industrial-notice');


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
})->name('retry-mail');