<?php

use App\Helpers\Helper;
use App\Http\Controllers\AutoreplyController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OutboxController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PayLinkGateway;
use App\Http\Controllers\PhonebookController;
use App\Http\Controllers\RestApiController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SendmsgController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
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
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/auth/userid', function () { return view('auth/userid'); });
Route::post('/query', [Helper::class, 'query'])->name('query');
Route::post('/user-changephone', [UserController::class, 'changephone'])->name('user.changephone');
Route::get('/user-verify', [UserController::class, 'verify'])->name('user.verify');
Route::get('/user-verifynow/{id}/{code}', [UserController::class, 'verifynow'])->name('user.verifynow');

Route::post('/payLink', [PayLinkGateway::class, 'CreateNewInvoice'])->name('payLink');
Route::get('/payLink', [PayLinkGateway::class, 'payLinkSuccess']);

Route::group(['middleware' => ['auth', 'verified', 'wa.verified']], function() {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    Route::get('/autoreply-destroy', [AutoreplyController::class, 'destroy'])->name('autoreply.destroy');
    Route::get('/autoreply-list', [AutoreplyController::class, 'list'])->name('autoreply.list');
    Route::get('/autoreply-search', [AutoreplyController::class, 'search'])->name('autoreply.search');
    Route::post('/autoreply-store', [AutoreplyController::class, 'store'])->name('autoreply.store');
    Route::post('/autoreply-update', [AutoreplyController::class, 'update'])->name('autoreply.update');

    Route::get('/device-destroy', [DeviceController::class, 'destroy'])->name('device.destroy');
    Route::get('/device-list', [DeviceController::class, 'list'])->name('device.list');
    Route::get('/device-search', [DeviceController::class, 'search'])->name('device.search');
    Route::get('/device-show', [DeviceController::class, 'show'])->name('device.show');
    Route::get('/device-showcontacts', [DeviceController::class, 'showContacts'])->name('device.showcontacts');
    Route::post('/device-store', [DeviceController::class, 'store'])->name('device.store');
    Route::get('/device-webhook', [DeviceController::class, 'webhook'])->name('device.webhook');
    Route::post('/device-webhookedit', [DeviceController::class, 'webhookedit'])->name('device.webhookedit');
    Route::post('/device-webhookupdate', [DeviceController::class, 'webhookupdate'])->name('device.webhookupdate');

    Route::post('/createpreference', [Helper::class, 'createPreference'])->name('helper.createpreference');
    Route::post('/topup', [Helper::class, 'topup'])->name('helper.topup');
    Route::post('/topupsuccess', [Helper::class, 'topupSuccess'])->name('helper.topupsuccess');
    Route::get('/mpsuccess', [Helper::class, 'mpSuccess'])->name('helper.mpsuccess');
    Route::get('/transaction', [Helper::class, 'transaction'])->name('helper.transaction');
    Route::post('/transfer', [Helper::class, 'transfer'])->name('helper.transfer');
    Route::post('/upgrade', [Helper::class, 'upgrade'])->name('helper.upgrade');
    Route::get('/renew', [Helper::class, 'renew'])->name('helper.renew');

    Route::group(['middleware' => ['admin']], function() {
        Route::get('/module-destroy', [ModuleController::class, 'destroy'])->name('module.destroy');
        Route::get('/module-disable', [ModuleController::class, 'disable'])->name('module.disable');
        Route::get('/module-enable', [ModuleController::class, 'enable'])->name('module.enable');
        Route::get('/module-list', [ModuleController::class, 'list'])->name('module.list');
        Route::post('/module-store', [ModuleController::class, 'store'])->name('module.store');
    });

    Route::get('/outbox-destroyjob', [OutboxController::class, 'destroyjob'])->name('outbox.destroyjob');
    Route::get('/outbox-destroyobx', [OutboxController::class, 'destroyobx'])->name('outbox.destroyobx');
    Route::get('/outbox-destroyall', [OutboxController::class, 'destroyall'])->name('outbox.destroyall');
    Route::get('/outbox-destroystatus', [OutboxController::class, 'destroystatus'])->name('outbox.destroystatus');
    Route::get('/outbox-list', [OutboxController::class, 'list'])->name('outbox.list');
    Route::get('/outbox-resendfailed', [OutboxController::class, 'resendfailed'])->name('outbox.resendfailed');
    Route::get('/outbox-search', [OutboxController::class, 'search'])->name('outbox.search');
    Route::get('/outbox-show', [OutboxController::class, 'show'])->name('outbox.show');

    Route::group(['middleware' => ['admin']], function() {
        Route::get('/package-destroy', [PackageController::class, 'destroy'])->name('package.destroy');
        Route::get('/package-list', [PackageController::class, 'list'])->name('package.list');
        Route::post('/package-store', [PackageController::class, 'store'])->name('package.store');
        Route::post('/package-update', [PackageController::class, 'update'])->name('package.update');
    });

    Route::get('/phonebook-addcontact', [PhonebookController::class, 'addcontact'])->name('phonebook.addcontact');
    Route::get('/phonebook-destroy', [PhonebookController::class, 'destroy'])->name('phonebook.destroy');
    Route::get('/phonebook-destroycontact', [PhonebookController::class, 'destroycontact'])->name('phonebook.destroycontact');
    Route::get('/phonebook-editcontact', [PhonebookController::class, 'editcontact'])->name('phonebook.editcontact');
    Route::get('/phonebook-list', [PhonebookController::class, 'list'])->name('phonebook.list');
    Route::get('/phonebook-search', [PhonebookController::class, 'search'])->name('phonebook.search');
    Route::get('/phonebook-show', [PhonebookController::class, 'show'])->name('phonebook.show');
    Route::post('/phonebook-store', [PhonebookController::class, 'store'])->name('phonebook.store');
    Route::get('/phonebook-storeparticipants', [PhonebookController::class, 'storeParticipants'])->name('phonebook.storeparticipants');
    Route::get('/phonebook-storegroups', [PhonebookController::class, 'storeGroups'])->name('phonebook.storegroups');
    Route::post('/phonebook-update', [PhonebookController::class, 'update'])->name('phonebook.update');

    Route::get('/restapi', [RestApiController::class, 'index'])->name('restapi.index');

    Route::get('/template-destroy', [TemplateController::class, 'destroy'])->name('template.destroy');
    Route::get('/template-list', [TemplateController::class, 'list'])->name('template.list');
    Route::get('/template-search', [TemplateController::class, 'search'])->name('template.search');
    Route::post('/template-store', [TemplateController::class, 'store'])->name('template.store');
    Route::post('/template-update', [TemplateController::class, 'update'])->name('template.update');

    Route::group(['middleware' => ['active']], function() {
        Route::get('/sendmsg', [SendmsgController::class, 'index'])->name('sendmsg.index');
        Route::post('/sendmsg-store', [SendmsgController::class, 'store'])->name('sendmsg.store');
    });

    Route::group(['middleware' => ['admin']], function() {
        Route::get('/setting-clearcache', [SettingController::class, 'clearcache'])->name('setting.clearcache');
        Route::get('/setting-destroy', [SettingController::class, 'destroy'])->name('setting.destroy');
        Route::get('/setting-list', [SettingController::class, 'list'])->name('setting.list');
        Route::get('/setting-search', [SettingController::class, 'search'])->name('setting.search');
        Route::post('/setting-store', [SettingController::class, 'store'])->name('setting.store');
        Route::post('/setting-update', [SettingController::class, 'update'])->name('setting.update');
    });

    Route::get('/user-destroy', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/user-expired', [UserController::class, 'expired'])->name('user.expired');
    Route::get('/user-list', [UserController::class, 'list'])->name('user.list');
    Route::get('/user-locale', [UserController::class, 'locale'])->name('user.locale');
    Route::get('/user-search', [UserController::class, 'search'])->name('user.search');
    Route::get('/user-show', [UserController::class, 'show'])->name('user.show');
    Route::post('/user-store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user-update', [UserController::class, 'update'])->name('user.update');
    Route::get('/{user}/impersonate', [UserController::class, 'impersonate'])->name('user.impersonate');
    Route::get('/leave-impersonate', [UserController::class, 'leaveImpersonate'])->name('user.leaveimpersonate');
});
require __DIR__.'/auth.php';
