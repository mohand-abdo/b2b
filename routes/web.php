<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
// Route::post('/register', [RegisterController::class, 'createUser'])->name('register');

//Auth::routes(['register'=>false]);
//  route auth

Route::group(['middleware' => ['auth','check.user']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // الراوتات الخاصة بنظام العمرة

    Route::resource('campaigns', App\Http\Controllers\CampaignsController::class);
    Route::post('campaigns/toggle-status/{id}', [App\Http\Controllers\CampaignsController::class, 'toggleStatus'])->name('campaigns.toggleStatus');
    //  الراوت الخاص بمراحل الحج او العمرة
    Route::resource('Stages', App\Http\Controllers\StagesController::class);
    //  إضافة حجاج للمرحلة
    Route::resource('Plus', App\Http\Controllers\PlusController::class);
    Route::resource('Pilgrims', App\Http\Controllers\StagesController::class);
    // Route::post('Stages/toggle-status/{id}', [App\Http\Controllers\CampaignsController::class, 'toggleStatus'])->name('campaigns.toggleStatus');
    // اضافة الحاج لبياناته
    // Route::get('add_client',[]);
    Route::get('client_report', [App\Http\Controllers\Client_ReportController::class, 'index'])->name('client_report');
    Route::post('client_report', [App\Http\Controllers\Client_ReportController::class, 'show'])->name('client_report.show');

    Route::group(['middleware' => ['auth']], function () {
        Route::resource('roles', App\Http\Controllers\RoleController::class);
        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::post('users/password_reset', [App\Http\Controllers\UserController::class,'password_reset'])->name('users.reset.password');
        // Route::get('users',[App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    });

    Route::get('customers_report', [App\Http\Controllers\Customers_Report::class, 'index']);
    Route::post('Search_customers', [App\Http\Controllers\Customers_Report::class, 'Search_customers']);

    // tree account route
    Route::resource('tree1', App\Http\Controllers\Tree1Controller::class);
    Route::resource('tree2', App\Http\Controllers\Tree2Controller::class);
    Route::resource('tree3', App\Http\Controllers\Tree3Controller::class);
    Route::resource('tree4', App\Http\Controllers\Tree4Controller::class);

    // إدارة قيود اليومية
    Route::resource('Alldaily', App\Http\Controllers\AlldailyController::class);
    // تقرير قيد يومية
    Route::resource('DailyReport', App\Http\Controllers\DailyReportController::class);
    //عرض قيد يومية
    Route::get('Print_Daily/{id}', [App\Http\Controllers\DailyReportController::class, 'show']);
    // إدارة الارصدة الافتتاحية
    Route::resource('Allbalance', App\Http\Controllers\AllbalanceController::class);
    // route Operation in accounts
    Route::resource('Operation', App\Http\Controllers\OperationController::class);
    Route::resource('Balance', App\Http\Controllers\BalanceController::class);
    Route::resource('Restrictions', App\Http\Controllers\RestrictionsController::class);
    // القيود المركبة
    Route::resource('Vehicle', App\Http\Controllers\VehicleController::class);
    //القيود المركبة
    Route::get('statement', [App\Http\Controllers\StatementController::class, 'index'])->name('statement');
    Route::post('statement', [App\Http\Controllers\StatementController::class, 'show'])->name('statement.show');
    // تقرير ميزان المراجعة بالنسبة للحسابات الرئيسية

    // route for show Account General
    Route::get('General', [App\Http\Controllers\GeneralController::class, 'index'])->name('General');
    Route::post('General', [App\Http\Controllers\GeneralController::class, 'show'])->name('General.show');

    // التقارير المحاسبية تقرير دفتر اليومية
    Route::get('Journal', [App\Http\Controllers\JournalController::class, 'index'])->name('Journal');
    Route::post('Journal', [App\Http\Controllers\JournalController::class, 'show'])->name('Journal.show');

    // التقارير الدفاتر المحاسبية
    Route::get('Books', [App\Http\Controllers\BooksController::class, 'index'])->name('Books');
    Route::post('Books', [App\Http\Controllers\BooksController::class, 'show'])->name('Books.show');

    // start route Profile
    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'profile'])->name('profile');
    Route::put('profile', [App\Http\Controllers\ProfileController::class, 'profile_edit'])->name('profile_edit');
    // end route Profile

    Route::resource('Drivers', App\Http\Controllers\DriversController::class);
    // route Drivers payment
    Route::resource('Drivers_Pay', App\Http\Controllers\DriverspayController::class);
    //  drivers statements كشف حساب السائقين
    Route::get('Driver_statement', [App\Http\Controllers\DriversController::class, 'search'])->name('Driver_statement');
    Route::post('Driver_statement', [App\Http\Controllers\DriversController::class, 'show'])->name('Driver_statement.show');
    // route client
    Route::resource('Clients', App\Http\Controllers\ClientsController::class);
    Route::get('Clients_inactive', [App\Http\Controllers\ClientsController::class, 'inactive'])->name('Clients.inactive');
    Route::post('Clients_add', [App\Http\Controllers\ClientsController::class, 'add'])->name('Clients.add');
    Route::get('Clients_pic', [App\Http\Controllers\ClientsController::class, 'show_pic'])->name('Clients.pic');
    Route::post('Clients/toggle-status/{id}', [App\Http\Controllers\ClientsController::class, 'toggleStatus'])->name('Clients.toggleStatus');
    // route client payment
    Route::resource('ClientPay', App\Http\Controllers\ClientPayController::class);
    Route::get('client-print/{id}', [App\Http\Controllers\ClientPayController::class, 'show'])->name('client-print');
    // route show client account
    Route::get('client_statement', [App\Http\Controllers\ClientsController::class, 'search'])->name('client_statement');
    Route::post('client_statement', [App\Http\Controllers\ClientsController::class, 'show'])->name('client_statement.show');
    Route::get('campaign_statement', [App\Http\Controllers\StagesController::class, 'search'])->name('campaign_statement');
    Route::post('campaign_statement', [App\Http\Controllers\StagesController::class, 'search_post'])->name('campaign_statement.store');
    Route::get('client_myStatement', [App\Http\Controllers\ClientsController::class, 'my_statment'])->name('client_myStatement');
    // end route client

    Route::post('add_file', [App\Http\Controllers\FileController::class, 'store'])->name('add_file');
    Route::get('file/{id}', [App\Http\Controllers\FileController::class, 'show'])->name('file.show');
    Route::put('file', [App\Http\Controllers\FileController::class, 'update'])->name('file.update');
    Route::post('file_delete', [App\Http\Controllers\FileController::class, 'destroy'])->name('file.destroy');

    //إضافة سائق في شاشة  عقودات النقل  إدارة النقل
    Route::post('Transport_driver_add_contract', [App\Http\Controllers\ContractController::class, 'transport_driver_add_contract'])->name('Transport_driver_add_contract');
    //إضافة سيارة في شاشة عقودات النقل إدارة النقل
    Route::post('Transport_car_add_contract', [App\Http\Controllers\ContractController::class, 'transport_car_add_contract'])->name('Transport_car_add_contract');
    //إضافة رحلة في شاشة عقودات النقل إدارة النقل
    Route::post('Transport_travel_add', [App\Http\Controllers\ContractController::class, 'transport_travel_add_contract'])->name('Transport_travel_add_contract');
    // route client payment

    // route Cars

    /////////////////////////////////////////all invoices new in transport mangemaent ///////////////////////////////////////////////
    // المسارات الخاصة ب عقودات النقل
    Route::resource('Contract', App\Http\Controllers\ContractController::class);
    // route Pakage invoices
    Route::get('Add_Contract', [App\Http\Controllers\ContractController::class, 'create']);
    // Pakage invoice Print
    Route::get('Contract-print/{id}', [App\Http\Controllers\ContractController::class, 'contract_print'])->name('Contract-print');
    // المسارات الخاصة ب عقودات النقل

    Route::resource('Setting', App\Http\Controllers\SettingController::class);
    Route::put('Setting', [App\Http\Controllers\SettingController::class, 'update'])->name('settings_update');

    // المسارات الخاصة بالوكيل
    Route::resource('agent', App\Http\Controllers\AgentController::class)->except('show');
    // end route auth

    // عمل select2
    Route::get('get/select', [App\Http\Controllers\ClientPayController::class, 'getSelect'])->name('select2.search');
    Route::get('get/statement', [App\Http\Controllers\ClientsController::class, 'getStatement'])->name('select2.getStatement');
    Route::get('get/campaign', [App\Http\Controllers\StagesController::class, 'getCampaign'])->name('select2.getCampaign');
    Route::get('get/vehicle', [App\Http\Controllers\VehicleController::class, 'getVehicle'])->name('select2.getVehicle');
    Route::get('get/book', [App\Http\Controllers\BooksController::class, 'getBook'])->name('select2.getBook');
});
//////////////////////////////////////////////qrcode//////////////////////////////////////////

// qr code show for contract   invoice
Route::get('Contract_scan/{id}', [App\Http\Controllers\ContractController::class, 'Contract_scan']);
// route profile
// Route::resource('profile', App\Http\Controllers\ProfileController::class);
// rote all page
Route::get('/{page}', [App\Http\Controllers\AdminController::class, 'index']);
Route::get('authrize', [App\Http\Controllers\AdminController::class,'authrize'])->name('authrize');

Route::get('/email', function () {});
