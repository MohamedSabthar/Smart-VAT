<?php

use App\Vat;
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
Route::get('/profile', 'EmployeeController@myProfile')->name('my-profile');
Route::get('/mark-notification', function () {   //marking notification as read
    Auth::User()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('mark-notification');

/**
 * Routes related to vat category (return view of the vat category)
*/
try {
    foreach (Vat::all() as $vat) {      //routes for all vat categories, VatPagesController contains methodes which show the forms
        Route::get('/'.$vat->route, 'VatPagesController@'.$vat->route)->name($vat->route);
    }
} catch (Exception $e) {
    echo "dynamic routes will only work after migration \n";
}

/**
 * Routes related to buisness tax
 */
Route::get('/business/profile/{id}', 'vat\BusinessTaxController@buisnessProfile')->name('business-profile');
Route::get('/latest', 'vat\BusinessTaxController@latestPayment')->name('latest');
Route::post('/business/business-register/{id}', 'vat\BusinessTaxController@registerBusiness')->name('business-register');
Route::get('/business/payments/{shop_id}', 'vat\BusinessTaxController@businessPayments')->name('business-payments');
Route::post('/business/payments/{shop_id}', 'vat\BusinessTaxController@reciveBusinessPayments')->name('receive-business-payments');
//all business tax related tax routes should starts with "/buisness"


Route::get('/vat-payer', 'PayerController@payer')->name('vat-payer'); //
Route::get('/vat-payer/register', 'PayerController@register')->name('register-vat-payer');
Route::get('/vat-payer-profile', 'PayerController@profile')->name('vat-payer-profile');
Route::get('/vat-payerbusinessPayment-list', 'PayerController@businessPaymentList')->name('payment-list');


//mail test
Route::get('/mail-me', function () {
    for ($id=2;$id<=3;$id++) {
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