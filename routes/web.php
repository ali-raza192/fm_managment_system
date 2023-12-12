<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\adminProfileController;
use App\Http\Controllers\Admin\deputyDirectorFinanceController;
use App\Http\Controllers\admin\accountantOfficerController;
use App\Http\Controllers\admin\chartOfAccountsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Admin Profiler Controllers all routes //
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::controller(adminProfileController::class)->group(function(){
        Route::get('/profile','adminPrifileEdit')->name('admin.profile.edit');
        Route::post('/admin/profile/store', 'adminProfileStore')->name('admin.profile.store');
        Route::get('/setting', 'adminSetting')->name('admin.setting');
        Route::post('/admin/password/store', 'adminPasswordStore')->name('admin.password.store');
    });

    // Deputy Director Finance Controllers all routes //
    
    Route::controller(deputyDirectorFinanceController::class)->group(function(){
        Route::get('/accounts', 'manageAccounts')->name('manage.accounts');
        Route::get('/accounts/data', 'accountData')->name('accounts.data');
        Route::post('/accounts', 'create')->name('add.users');
        Route::get('/user/edit/data/{id}', 'editUserData');
        Route::post('/update/account', 'updateAccount')->name('update.user');
        Route::get('/delete-user/{id}', 'deleteUser');

        Route::get('/approve/ddo/assignment/to/accountant', 'approveDDOAssignToAccountant')->name('approve.ddo_assignment_to_accountant');
        Route::get('/deputy/approve/DDO', 'deputyDirectorApproveDDO')->name('deputy.director.approve.ddo');
        Route::get('/status/approve/ddo/{id}', 'statusApproveDDO');

        Route::get('/approve/budget', 'approveBudget')->name('approve.budget');
        Route::get('deputy/approve/budget', 'deputyApproveBudget')->name('deputy.director.approve.budget');
        Route::get('/status/approve/budget/{id}', 'statusApproveBudget');

        Route::get('/approve/advance', 'approveAdvance')->name('approve.advance');
        Route::get('/deputy/director/approve/advance', 'deputyDirectorApprovedAdvance')->name('deputy.director.approve.advance');
        Route::get('/status/approve/advance/{id}', 'statusApprovedAdvance');
    });

    // Accountant officer Controller all routes //

    Route::controller(accountantOfficerController::class)->group(function(){
        Route::get('/assign-ddo', 'assignDdosToAccountant')->name('assign.ddos.to.accountants');
        Route::get('/approve/ddo/list', 'approveDdoList')->name('approve.ddo.list');
        Route::post('/create/ddo', 'createAssigned')->name('create.assigned');
        Route::get('/ddo/data/for/update', 'ddoDataForUpdateModal');
        Route::get('/ddo-to-accountant/edit/data/{id}', 'ddoToAccountantEditData');
        Route::get('/display/previous-data/ddo-to-accountant', 'displayPreviousDataofDDO');
        Route::get('/delete/ddo-that-assigned-to-accountant', 'deleteDDOData');
        Route::post('/update/ddo/to/accountant', 'updateDDOToAccountant')->name('update.data.ddo.to.accountant');
        Route::get('/delete-data-ddo-to-accountant/{id}', 'deleteDataDDOToAccountant');
        
        Route::get('/send/request/for/budget', 'sendRequestForBudget')->name('send.request.to approve.budget');
        Route::post('create/assigned/budget', 'createAssignedBudget')->name('create.assigned.budget');
        Route::get('requested/ddo/list', 'requestedDDOList')->name('requested.ddo.list');
        Route::get('/requested/budget/edit/data/{id}', 'requestedBudgetEditData');
        Route::post('update/requested/budget', 'updateRequestedBudget')->name('update.data.of.requested.budget');
        Route::get('/delete/budget/{id}', 'deleteBudget');

        Route::post('/request/for/advance/{id}', 'requestForAdvance');

        Route::get('/send/request/for/advance', 'sendRequestForAdvance')->name('send.request.to approve.advance');
        Route::get('/requested/advance/list', 'requestedAdvanceList')->name('requested.advance.list');
        Route::post('/create/assigned/advance', 'createAssignedAdvance')->name('create.assigned.advance');
        Route::get('/requested/advance/edit/data/{id}', 'requestedAdvanceEditData');
        Route::post('update/requested/advance', 'updateRequestedAdvance')->name('update.data.of.requested.advance');
        Route::get('/delete/advance/{id}', 'deleteAdvance');
    });

    // Chart Of Account Controller all routes //
    
    Route::controller(chartOfAccountsController::class)->group(function(){
        Route::get('chart/of/accounts', 'createChartsOfAccounts')->name('create.chart.of.account');
        Route::get('add/chart/of/account', 'addChartOfAccount')->name('add.chart.of.accounts');
        Route::post('create/charts', 'createCharts')->name('create.charts');
        Route::get('chart/of/accounts/list', 'chartOfAccountsList')->name('chart.of.accounts.list');
        Route::get('edit/chart/of/account/{id}', 'editChartOfAccount')->name('edit.chart.of.account');
        Route::post('update/chart', 'updateChart')->name('update.charts');
        Route::get('/delete-data-of-chart-of-account/{id}', 'deleteChartOfAccount');
        Route::get('view/chart/of/account/{id}', 'viewChartOfAccount')->name('view.chart.of.account');
    });
    
});

require __DIR__.'/auth.php';
