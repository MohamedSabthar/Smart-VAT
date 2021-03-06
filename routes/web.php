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
Route::put('/my-profile/{id}', 'EmployeeController@updateProfile')->name('update-profile');
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

Route::get('/global-conf/entertainment', 'GlobalConfigurationController@viewEntertainmentTicketTax')->name('global-conf-entertainment-update');

Route::get('/global-conf/land', 'GlobalConfigurationController@updateLandTaxForm')->name('global-conf-land-update');
Route::put('/global-conf/land/update-percentage', 'GlobalConfigurationController@updateLandPercentage')->name('update-land-percentage');

Route::get('/global-conf/club-licence', 'GlobalConfigurationController@updateClubLicenceTaxForm')->name('global-conf-club-licence-update');
Route::put('/global-conf/club-licence/update-percentage', 'GlobalConfigurationController@updateClubLicencePercentage')->name('update-club-licence-percentage');
Route::post('/global-conf/industrial/add-range', 'GlobalConfigurationController@addIndustrialRange')->name('industrial-add-range');
Route::post('/global-conf/business/add-range', 'GlobalConfigurationController@addBusinessRange')->name('business-add-range');

Route::post('/global-conf/entertainment/add-ticket-type', 'GlobalConfigurationController@addEnterainmentTicketType')->name('add-entertainment-ticket-type');
Route::put('/global-conf/entertainment/update-ticket-type', 'GlobalConfigurationController@updateEntertainmentTicketPercentage')->name('update-entertainment-ticket-type');

Route::get('/global-conf/entertainment-performance', 'GlobalConfigurationController@viewEntertainmentPerformanceTax')->name('global-conf-entertainment-performance-update');
Route::post('/global-conf/entertainment/add-performance-type', 'GlobalConfigurationController@addEnterainmentPerformanceType')->name('add-entertainment-performance-type');
Route::put('/global-conf/entertainment/update-performance-type', 'GlobalConfigurationController@updateEntertainmentPerformanceTaxDetails')->name('update-entertainment-performance-type');

Route::get('/global-conf/license', 'GlobalConfigurationController@updateLicenseTaxForm')->name('global-conf-license-update');
Route::put('/global-conf/license/update-percentage', 'GlobalConfigurationController@updateLicensePercentage')->name('update-license-percentage');
Route::post('/global-conf/license/add-range', 'GlobalConfigurationController@addLicenseRange')->name('license-add-range');
Route::get('/global-conf/license/types/{id}', 'GlobalConfigurationController@viewLicenseRangeTypes')->name('view-license-range-types');
Route::post('/global-conf/license/add-type/{id}', 'GlobalConfigurationController@addLicenseType')->name('add-license-type');
Route::get('/global-conf/license/types/{id}', 'GlobalConfigurationController@viewLicenseRangeTypes')->name('view-license-range-types');

Route::get('/global-conf/shop-rent', 'GlobalConfigurationController@updateShopRentTaxForm')->name('global-conf-shop-rent-update');
Route::put('/global-conf/shop-rent/update-percentage', 'GlobalConfigurationController@updateShopRentPercentage')->name('update-shop-rent-percentage');

Route::get('/global-conf/advertisement', 'GlobalConfigurationController@updateAdvertisementTaxForm')->name('global-conf-advertisement-update');
Route::put('/global-conf/advertisement/update-percentage', 'GlobalConfigurationController@updateAdvertisementPercentage')->name('update-advertisement-percentage');







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
        Route::get("/$vat->route", 'VatPagesController@' . $vat->route)->name($vat->route);
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
Route::put('/business-profile/{id}', 'vat\BusinessTaxController@updateBusinessProfile')->name('update-business');  //update business details
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
Route::get('/business/get-unpaid-vat-payers', 'vat\BusinessTaxController@getUnpaidVatPayer')->name('business-un-paid-payers');
Route::get('/business/get-unpaid-vat-payers-pdf', 'vat\BusinessTaxController@getUnpaidVatPayerPdf')->name('business-un-paid-payers-pdf');

//business payment remove
Route::delete('/business/payment-remove/{id}', 'vat\BusinessTaxController@removePayment')->name('remove-payment'); //soft delete business payment
Route::get('/business/payment-trash/{id}', 'vat\BusinessTaxController@trashPayment')->name('trash-payment'); //trash business payment
Route::get('/business/payment-restore/{shop_id}', 'vat\BusinessTaxController@restorePayment')->name('restore-payment'); //restore payment
Route::delete('/business/payment-remove-permanent/{id}', 'vat\BusinessTaxController@destroy')->name('remove-payment-permanent'); // permanent delete
//business remove
Route::delete('/business/business-remove/{shop_id}', 'vat\BusinessTaxController@removeBusiness')->name('remove-business'); // soft delete business route
Route::get('/business/business-trash/{payer_id}', 'vat\BusinessTaxController@trashBusiness')->name('trash-business'); // trash business
Route::get('/business/business-restore/{id}', 'vat\BusinessTaxController@restoreBusiness')->name('restore-business'); // restore business

//all business tax related tax routes should starts with "/buisness"
Route::get('/vat-payer', 'PayerController@payer')->name('vat-payer');
Route::get('/vat-payerbusinessPayment-list', 'PayerController@businessPaymentList')->name('payment-list');
Route::put('/business-profile/{id}', 'vat\BusinessTaxController@updateBusinessProfile')->name('update-business');


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
Route::get('/vat-payer-profile/{id}', 'PayerUpdateController@vatPayerProfile')->name('vat-payer-profile');
Route::post('/vat-payer/{id}', 'PayerUpdateController@updateVATpayerProfile')->name('update-vat-payer');

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
Route::delete('/industrial/payment-remove/{id}', 'vat\IndustrialTaxController@removePayment')->name('remove-industrial-payment'); //soft delete industrial payment
Route::get('/industrial/payment-trash/{id}', 'vat\IndustrialTaxController@trashPayment')->name('industrial-trash-payment'); //trash industrial payment
Route::get('/industrial/payment-restore/{id}', 'vat\IndustrialTaxController@restorePayment')->name('restore-industrial-payment'); // restore industrial

Route::delete('/industrial/industrial-remove/{shop_id}', 'vat\IndustrialTaxController@removeIndustrialShop')->name('remove-inudstrial-shop'); // soft delete industrial route
Route::get('/industrial/industrial-trash/{payer_id}', 'vat\IndustrialTaxController@trashIndustrialShop')->name('trash-industrial-shop'); // trash industrial
Route::get('/industrial/industrial-restore/{id}', 'vat\IndustrialTaxController@restoreIndustrialShop')->name('restore-industrial-shop'); // restore industrial
Route::delete('/industrial/payment-remove-permanent/{id}', 'vat\IndustrialTaxController@destory')->name('industrial-remove-payment-permanent'); // permanent delete

Route::get('/industrial/generate-report', 'vat\IndustrialTaxController@industrialReportGeneration')->name('industrial-generate-report');
Route::post('/industrial/generation', 'vat\IndustrialTaxController@generateReport')->name('industrial-report-view');

Route::post('/industrial/tax-report-pdf', 'vat\IndustrialTaxController@taxPdf')->name('industrial-tax-report-pdf');
Route::post('/industrial/summary-report-pdf', 'vat\IndustrialTaxController@summaryPdf')->name('industrial-summary-report-pdf');

Route::get('/industrial/get-unpaid-vat-payers', 'vat\IndustrialTaxController@getUnpaidVatPayer')->name('industrial-un-paid-payers');
Route::get('/industrial/get-unpaid-vat-payers-pdf', 'vat\IndustrialTaxController@getUnpaidVatPayerPdf')->name('industrial-un-paid-payers-pdf');
Route::put('/industrial-profile/{id}', 'vat\IndustrialTaxController@updateIndustrialShop')->name('update-industrial');


//shop rent tax
Route::get('/shop-rent/profile/{id}', 'vat\ShopRentTaxController@shoprentProfile')->name('shop-rent-profile');
Route::post('/shop-rent/shop-register/{id}', 'vat\ShopRentTaxController@registerShopRent')->name('shop-rent-register');
Route::get('/shop-rent/payments/{shop_id}', 'vat\ShopRentTaxController@shopRentPayments')->name('shop-rent-payments');
Route::put('/shop-rent-profile/{id}', 'vat\ShopRentTaxController@updateShopRentProfile')->name('update-shop-rent');
Route::post('/shop-rent/payments/{shop_id}', 'vat\ShopRentTaxController@reciveshopRentPayments')->name('receive-shop-rent-payments');
Route::get('/shop-rent/quick-payments', 'vat\ShopRentTaxController@viewQuickPayments')->name('get-shop-rent-quick-payments');
Route::post('/shop-rent/check-payments', 'vat\ShopRentTaxController@checkPayments')->name('check-shop-rent-payments'); //check all business payments for a given vat payer for quick payment option
Route::post('/shop-rent/accept-quick-payments', 'vat\ShopRentTaxController@acceptQuickPayments')->name('shop-rent-quick-payments');
Route::delete('/shop-rent/payment-remove/{id}', 'vat\ShopRentTaxController@removePayment')->name('remove-shop-rent-payment'); //soft delete business payment
Route::get('/shop-rent/payment-trash/{id}', 'vat\ShopRentTaxController@trashPayment')->name('shop-rent-trash-payment'); //trash business payment
Route::get('/shop-rent/payment-restore/{id}', 'vat\ShopRentTaxController@restorePayment')->name('restore-shop-rent-payment'); // restore business
Route::delete('/shop-rent/shop-rent-remove/{shop_id}', 'vat\ShopRentTaxController@removeShopRent')->name('remove-shop-rent'); // soft delete business route
Route::get('/shop-rent/shop-rent-trash/{payer_id}', 'vat\ShopRentTaxController@trashShopRent')->name('trash-shop-rent'); // trash business
Route::get('/shop-rent/shop-rent-restore/{id}', 'vat\ShopRentTaxController@restoreShopRent')->name('restore-shop-rent'); // restore business
Route::get('/shop-rent/generate-report', 'vat\ShopRentTaxController@shopRentReportGeneration')->name('shop-rent-generate-report');
Route::post('/shop-rent/generation', 'vat\ShopRentTaxController@generateReport')->name('shop-rent-report-view');
Route::post('/shop-rent/Tax-report-pdf', 'vat\ShopRentTaxController@TaxPdf')->name('shop-rent-tax-report-pdf');
//Route::get('/shop-rent/shop-rent-notice/{id}', 'vat\ShopRentTaxController@sendNotice')->name('shop-rent-send-notice');
//booking tax
Route::get('/booking/profile/{id}', 'vat\BookingTaxController@bookingprofile')->name('booking-profile');
Route::post('/booking/booking-register/{id}', 'vat\BookingTaxController@registerBooking')->name('booking-register');
Route::get('/booking/payments/{shop_id}', 'vat\BookingTaxController@bookingPayments')->name('booking-payments');
Route::post('/booking/payments{shop_id}', 'vat\BookingTaxController@recivebookingPayments')->name('receive-booking-payments');
Route::post('/booking/check-payments', 'vat\BookingTaxController@checkPayments')->name('check-booking-payments'); //check all business payments for a given vat payer for quick payment option
Route::post('/booking/get-booking-types', 'vat\BookingTaxController@getBookingType')->name('get-booking-types');

Route::delete('/booking/payment-remove/{id}', 'vat\BookingTaxController@removePayment')->name('remove-booking-payment'); //soft delete business payment
Route::get('/booking/payment-trash/{id}', 'vat\BookingTaxController@trashPayment')->name('booking-trash-payment'); //trash business payment
Route::get('/booking/payment-restore/{id}', 'vat\BookingTaxController@restorePayment')->name('restore-booking-payment'); // restore business

Route::delete('/booking/booking-remove/{shop_id}', 'vat\BookingTaxController@removeBooking')->name('remove-booking'); // soft delete business route
Route::get('/booking/booking-trash/{payer_id}', 'vat\BookingTaxController@trashBooking')->name('trash-booking'); // trash business
Route::get('/booking/booking-restore/{id}', 'vat\BookingTaxController@restoreBooking')->name('restore-booking'); // restore business

//advertisement
Route::post('/advertisement/advertisement-register/{id}', 'vat\AdvertisementTaxController@registerAdvertisementPayment')->name('advertisement-register');
Route::get('/advertisement/profile/{payer_id}', 'vat\AdvertisementTaxController@advertisementProfile')->name('advertisement-profile');
Route::delete('/advertisement/payment-remove/{id}', 'vat\AdvertisementTaxController@removePayment')->name('remove-advertisement-payment'); //soft delete business payment
Route::get('/advertisement/payment-trash/{id}', 'vat\AdvertisementTaxController@trashPayment')->name('advertisement-trash-payment'); //trash business payment
Route::get('/advertisement/payment-restore/{id}', 'vat\AdvertisementTaxController@restorePayment')->name('restore-advertisement-payment'); // restore business
Route::get('/advertisement/generate-report', 'vat\AdvertisementTaxController@advertisementReportGeneration')->name('advertisement-generate-report');
Route::post('/advertisement/generation', 'vat\AdvertisementTaxController@generateReport')->name('advertisement-report-view');
Route::post('/advertisement/Tax-report-pdf', 'vat\AdvertisementTaxController@TaxPdf')->name('advertisement-tax-report-pdf');
Route::put('/advertisement/payment-update', 'vat\AdvertisementTaxController@updatePayment')->name('update-advertisement-payments');
/**
 * Routes related to entertainment tax
 *
 * all entertainment tax related tax routes should starts with "/entertainment"
 */
Route::get('/entertainment/profile/{id}', 'vat\EntertainmentTaxController@entertainmentPayments')->name('entertainment-profile'); //profile only cosit of payments
Route::post('/entertainment/profile/{id}', 'vat\EntertainmentTaxController@reciveEntertainmentPayments')->name('receive-entertainment-payments');
Route::delete('/entertainment/ticket-payment-remove/{id}', 'vat\EntertainmentTaxController@removeTicketPayment')->name('remove-entertainment-payment'); //soft delete entertainment payment
Route::get('/entertainment/ticket-payment-trash/{id}', 'vat\EntertainmentTaxController@trashTicketPayment')->name('entertainment-ticket-trash-payment'); //trash entertainment payment
Route::get('/entertainment/ticket-payment-restore/{id}', 'vat\EntertainmentTaxController@restoreTicketPayment')->name('restore-entertainment-payment'); // restore entertainment
Route::put('/entertainment/ticket-payment-update/{id}', 'vat\EntertainmentTaxController@updateTicketPayment')->name('update-entertainment-ticket-payments');

Route::get('/entertainment/performance-tax/{id}', 'vat\EntertainmentTaxController@showPerformanceTaxForm')->name('entertainment-performance-tax'); // restore industrial
Route::post('/entertainment/performance-payments/{id}', 'vat\EntertainmentTaxController@recievePerformancePayments')->name('receive-performance-entertainment-payments');
Route::delete('/entertainment/performance-payment-remove/{id}', 'vat\EntertainmentTaxController@removePerformancePayment')->name('remove-entertainment-performance-payment'); //soft delete performance payment
Route::get('/entertainment/performance-payment-trash/{id}', 'vat\EntertainmentTaxController@trashPerformancePayment')->name('entertainment-performance-trash-payment'); //trash performance payment
Route::get('/entertainment/performance-payment-restore/{id}', 'vat\EntertainmentTaxController@restorePerformancePayment')->name('restore-entertainment-performance-payment'); // restore entertainment
Route::delete('/entertainment/payment-ticket-remove-permanent/{id}', 'vat\EntertainmentTaxController@destoryTicket')->name('entertainment-remove-ticket-payment-permanent'); // permanent delete
Route::delete('/entertainment/payment-performance-remove-permanent/{id}', 'vat\EntertainmentTaxController@destoryPerformance')->name('entertainment-remove-ticket-performance-permanent'); // permanent delete
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
Route::get('/land/land-notice/{id}', 'vat\LandTaxController@sendNotice')->name('land-send-notice');
Route::get('/club-licence/land-notice/{id}','vat\ClubLicenceTaxController@sendNotice')->name('club-licence-send-notice');
Route::get('/retry-business-notification/{id}/{notify}', 'RetryNoticeController@retryBusinessNotice')->name('retry-business-notice');
Route::get('/retry-industrial-notification/{id}/{notify}', 'RetryNoticeController@retryIndustrialNotice')->name('retry-industrial-notice');


/**
 * Routes related to Land tax
 *
 * all taxes related to land tax should starts with "/land"
 */
Route::get('/land/profile/{id}', 'vat\LandTaxController@landProfile')->name('land-profile');
Route::post('/land/land-register/{id}', 'vat\LandTaxController@registerLand')->name('land-register');
Route::put('/land-profile/{id}', 'vat\LandTaxController@updateLandProfile')->name('update-premises');  //update Premises(Land) details
Route::get('/land/payments/{land_id}', 'vat\LandTaxController@landPayments')->name('land-payments');
Route::post('/land/payments/{land_id}', 'vat\LandTaxController@receiveLandPayments')->name('receive-land-payments');

Route::post('/land/check-payments', 'vat\LandTaxController@checkPayments')->name('check-land-payments'); //check all land payments for a given vat payer for quick payment option
Route::get('/land/quick-payments', 'vat\LandTaxController@viewQuickPayments')->name('get-land-quick-payments');
Route::post('/land/accept-quick-payments', 'vat\LandTaxController@acceptQuickPayments')->name('land-quick-payments');

Route::delete('/land/payment-remove/{id}', 'vat\LandTaxController@removePayment')->name('remove-land-payment');//soft delete land payment
Route::get('/land/payment-trash/{id}', 'vat\LandTaxController@trashPayment')->name('land-trash-payment');//trash land payments
Route::get('/land/payment-restore/{id}', 'vat\LandTaxController@restorePayment')->name('restore-land-payment');// restore land payments
Route::delete('/land/payment-remove-permanent/{id}', 'vat\LandTaxController@destroy')->name('land-remove-payment-permanent'); // permanent delete

Route::delete('/land/land-remove/{land_id}', 'vat\LandTaxController@removeLandPremises')->name('remove-land-premises'); // soft delete land route
Route::get('/land/land-trash/{payer_id}', 'vat\LandTaxController@trashLandPremises')->name('trash-land-premises');// trash land
Route::get('/land/land-restore/{id}', 'vat\LandTaxController@restoreLandPremises')->name('restore-land-premises'); // restore land

// Land tax report generation
Route::get('/land/generate-report', 'vat\LandTaxController@landReportGeneration')->name('land-generate-report'); // Summary report generation
Route::post('/land/generation', 'vat\LandTaxController@generateReport')->name('land-report-view');
Route::post('/land/Tax-report-pdf', 'vat\LandTaxController@TaxPdf')->name('land-tax-report-pdf');
Route::post('/land/Summary-report-pdf', 'vat\LandTaxController@summaryPdf')->name('land-summary-report-pdf');

/**
 * Routes related to Club Licece tax
 *
 * all taxes related to land tax should starts with "/club-licence"
 */
Route::get('/club-licence/profile/{id}', 'vat\ClubLicenceTaxController@clubLicenceProfile')->name('club-licence-profile');
//Route::put('/club-licence-profile/{id}', 'PayerController@updateVATpayerProfile')->name('update-vat-payer');  //update VAT payer profile
Route::post('/club-licence/club-register/{id}', 'vat\ClubLicenceTaxController@registerClubLicence')->name('club-licence-register');
Route::put('/club-profile/{id}', 'vat\ClubLicenceTaxController@updateClubLicenceProfile')->name('update-club');
Route::get('/club-licence/payments/{club_id}', 'vat\ClubLicenceTaxController@clubLicencePayments')->name('club-licence-payments');
Route::post('/club-licence/payments/{club_id}', 'vat\ClubLicenceTaxController@receiveClubLicencePayment')->name('receive-club-licence-payments');

Route::post('/club-licence/check-payments', 'vat\ClubLicenceTaxController@checkPayments')->name('check-club-licence-payments'); //check all business payments for a given vat payer for quick payment option
Route::get('/club-licence/quick-payments', 'vat\ClubLicenceTaxController@viewQuickPayments')->name('get-club-licence-quick-payments');
Route::post('/club-licence/accept-quick-payments', 'vat\ClubLicenceTaxController@acceptQuickPayments')->name('club-licence-quick-payments');

Route::delete('/club-licence/payment-remove/{id}', 'vat\ClubLicenceTaxController@removePayment')->name('remove-club-licence-payment');//soft delete club licence payment
Route::get('/club-licence/payment-trash/{id}', 'vat\ClubLicenceTaxController@trashPayment')->name('club-licence-trash-payment');//trash land payments
Route::get('/club-licence/payment-restore/{id}', 'vat\ClubLicenceTaxController@restorePayment')->name('restore-club-licence-payment');// restore land payments
Route::delete('/club-licence/payment-remove-permanent/{id}', 'vat\ClubLicenceTaxController@destroy')->name('club-licence-remove-payment-permanent'); // permanent delete

Route::delete('/club-licence/clubLicence-remove/{club_id}', 'vat\ClubLicenceTaxController@removeClubLicence')->name('remove-club-licence'); // soft delete club licence route
Route::get('/club-licence/clubLicence-trash/{payer_id}', 'vat\ClubLicenceTaxController@trashClubLicence')->name('trash-club-licence');// trash land
Route::get('/club-licence/clubLicence-restore/{id}', 'vat\ClubLicenceTaxController@restoreClubLicence')->name('restore-club-licence'); // restore land

// Club Licence tax report generation
Route::get('/club-licence/generate-report', 'vat\ClubLicenceTaxController@clubLicenceReportGeneration')->name('club-licence-generate-report');
Route::post('/club-licence/generation', 'vat\ClubLicenceTaxController@generateReport')->name('club-licence-report-view');
Route::post('/club-licence/Tax-report-pdf', 'vat\ClubLicenceTaxController@TaxPdf')->name('club-licence-tax-report-pdf');


/**
 * Routes related to Vehicle Park tax
 *
 * all taxes related to Vehicle Park tax should starts with "/vehicle-park"
 */
Route::get('/vehicle-park/officers', 'vat\VehicleParkTaxController@ticketingOfficers')->name('vehicle-park-ticketing-officers');
Route::get('/vehicle-park/payments', 'vat\VehicleParkTaxController@vehicleParkPayments')->name('vehicle-park-vehicleParkPayments');


/**
 * Routes related to license tax
 *
 * all license tax related tax routes should starts with "/license"
 */
Route::get('/license/profile/{id}', 'vat\LicenseTaxController@licenseProfile')->name('license-profile');
Route::post('/license/licenfse-register/{id}', 'vat\LicenseTaxController@registerLisenceDuty')->name('license-duty-register');
Route::get('/license/payments/{shop_id}', 'vat\LicenseTaxController@licensePayments')->name('license-payments');
Route::post('/license/payments/{shop_id}', 'vat\LicenseTaxController@reciveLicensePayments')->name('receive-license-payments');
Route::post('/license/generation', 'vat\LicenseTaxController@generateReport')->name('license-report-view');
Route::get('/license/generate-report', 'vat\LicenseTaxController@licenseReportGeneration')->name('license-generate-report');
Route::post('/license/Tax-report-pdf', 'vat\LicenseTaxController@TaxPdf')->name('license-tax-report-pdf');
Route::post('/license/Summary-report-pdf', 'vat\LicenseTaxController@summaryPdf')->name('license-summary-report-pdf');
Route::post('/license/get-license-types', 'vat\LicenseTaxController@getLicensetypes')->name('get-license-types');
Route::delete('/license/payment-remove/{id}', 'vat\LicenseTaxController@removePayment')->name('remove-license-payment');//soft delete industrial payment

/**
 * Routes related to Slaughtering tax
 *
 * all slaughtering tax related tax routes should starts with "/slaughtering"
 */
Route::get('/slaughtering/profile/{id}', 'vat\SlaughteringTaxController@sloughteringProfile')->name('slaughtering-profile');
Route::post('/slaughtering/profile/{id}', 'vat\SlaughteringTaxController@reciveSlaughteringPayments')->name('receive-slaughtering-payments');
Route::put('/slaughtering/slaughtering-payment-update/{id}', 'vat\SlaughteringTaxController@updateSlaughteringPayment')->name('update-slaughtering-payments');


Route::get('/test', function () {
    return view('vat.license.test');
});

/**
 * temperory testing routes
 */
Route::get('/mail-me', function () {
    for ($id = 1; $id <= 3; $id++) {
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