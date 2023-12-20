<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\adminProfileController;
use App\Http\Controllers\Admin\deputyDirectorFinanceController;
use App\Http\Controllers\Admin\accountantOfficerController;
use App\Http\Controllers\Admin\chartOfAccountsController;
use App\Http\Controllers\Admin\expenseVouchersController;
use App\Http\Controllers\Admin\accountantController;
use App\Http\Controllers\Admin\roleController;

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

        Route::get('view/expense/of/deputy/director', 'viewExpenceByDeputyDirector')->name('view.expense.voucher.of.deputy.director'); 
        Route::get('lis/expense/voucher/of/depty/director', 'listExpenseVoucherOfDeputyDirector')->name('expense.vouchers.list.of.deputy.director');
        Route::get('/approve/expense/voucher/by/deputy/director/{id}', 'approvedExpenseVoucherByDeputyDirector');
        Route::get('/reject/expense/voucher/by/deputy/director/{id}', 'rejectExpenseVoucherByDeputyDirector');


        Route::get('approve/chart/of/account', 'approveChartOfAccount')->name('approve.chart.of.account');
        Route::get('list/approve/chart/of/account', 'listApproveChartOfAccount')->name('list.approve.chart.of.account');
        Route::get('deputy/approve/chart/of/account/{id}', 'deputyApproveChartOfAccount')->name('deputy.approve.chart.of.account');
        Route::get('deputy/view/chart/of/account/{id}', 'deputyViewChartOfAccount')->name('deputy.view.chart.of.account');

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

        Route::get('view/expense/of/account/officer', 'viewExpenceByAccountOfficer')->name('view.expense.voucher.of.account.officer');
        Route::get('lis/expense/voucher/of/account/officer', 'listExpenseVoucherOfAccountOfficer')->name('expense.vouchers.list.of.account.officer');
        Route::get('/approve/expense/voucher/by/account/officer/{id}', 'approvedExpenseVoucherByAccountOfficer');
        Route::get('/reject/expense/voucher/by/account/officer/{id}', 'rejectExpenseVoucherByAccountOfficer');
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

        Route::get('view/expense/of/assistant/accountant', 'viewExpenceByAssistantAccountant')->name('view.expense.voucher.of.assistant.accountant');
        Route::get('lis/expense/voucher/of/assistant/accountant', 'listExpenseVoucherOfAssistantAccountant')->name('expense.vouchers.list.of.assistant.accountant');
        Route::get('/approve/expense/voucher/by/assistant/accountant/{id}', 'approvedExpenseVoucherByAssistantAccountant');
        Route::get('/reject/expense/voucher/by/assistant/accountant/{id}', 'rejectExpenseVoucherByAssistantAccountant');
    });

    // Expense Voucher all routes //

    Route::controller(expenseVouchersController::class)->group(function(){
        Route::get('expense/vouchers', 'expenseVouchers')->name('expence.vouchers.all');
        Route::get('list/expense/vouchers', 'listExpenseVouchers')->name('expense.vouchers.list');
        Route::get('list/chart/{id}/account', 'listChartOfAccoun')->name('view.chart.of.account.for.expense');
        Route::post('create/expense/voucher', 'createExpenseVoucher')->name('create.expense.voucher');
    });

    // Accountant all routes //

    Route::controller(accountantController::class)->group(function(){
        Route::get('view/expense/of/accountant', 'viewExpenceByAccountant')->name('view.expense.voucher.of.accountant');
        Route::get('lis/expense/voucher/of/accountant', 'listExpenseVoucherOfAccountant')->name('expense.vouchers.list.of.accountant');
        Route::get('/approve/expense/voucher/by/accountant/{id}', 'approvedExpenseVoucherByAccountant');
        Route::get('/reject/expense/voucher/by/accountant/{id}', 'rejectExpenseVoucherByAccountant');
    });

    // All Routes of roles and permissions

    Route::controller(roleController::class)->group(function(){
        Route::get('all/permissions', 'permissionsAll')->name('permissions.all');
        Route::post('store/permission', 'storePermission')->name('store.permission');
        Route::get('all/roles', 'rolesAll')->name('roles.all');
        Route::post('store/role', 'storeRole')->name('store.role');
        Route::get('add/roles/and/permissions', 'addRolesAndPermissions')->name('add.roles.and.permissions');
        Route::post('store/roles/and/permissions', 'storeRoleAndPermission')->name('store.role.and.permission');
    });
    
});

require __DIR__.'/auth.php';
