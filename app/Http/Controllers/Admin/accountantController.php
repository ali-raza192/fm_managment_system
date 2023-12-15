<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\expenseVouchers;
use App\Models\chartOfAccountsDetails;
use App\Models\assignBudgetToDdo;
use Carbon\Carbon;
use DataTables;

class accountantController extends Controller
{
    public function viewExpenceByAccountant(){
        return view('admin.accountant.approve_expense_voucher');
    } /// End Method

    public function listExpenseVoucherOfAccountant(Request $request){
        $query = expenseVouchers::with('expenseName', 'ddoName')->where('status', 0);

        return DataTables::of($query)
            ->addColumn('expense_name', function ($expense) {
                $expenseName = $expense->expenseName ?? null;
                return $expenseName ? $expenseName->name : null;
            })
            ->addColumn('ddo_name', function ($expense) {
                $ddoName = $expense->ddoName ?? null;
                return $ddoName ? $ddoName->name. ' '. $ddoName->last_name  : null;
            })
            ->addColumn('date', function ($expense) {
                $date = $expense->created_at->format('d F Y');
                return $date;
            })
            ->addColumn('status', function ($expense) {
                $status = $expense->status;
                if ($status == 1) {
                    return '<span class="mb-1 badge font-weight-medium bg-light-warning text-warning">Accountant Approved</span>';
                } elseif ($status == 2) {
                    return '<span class="mb-1 badge font-weight-medium bg-light-warning text-warning">Assistant Accountant Approved</span>';
                } elseif ($status == 3) {
                    return '<span class="mb-1 badge font-weight-medium bg-light-warning text-warning">Account Officer Approved</span>';
                } elseif ($status == 4) {
                    return '<span class="mb-1 badge font-weight-medium bg-light-success text-success">Approved</span>';
                } else {
                    return '<span class="mb-1 badge font-weight-medium bg-light-danger text-danger">Pending</span>';
                }
            })
            ->addColumn('action', function ($expense) {
                return '<div class="text-center"><button class="btn btn-warning btn-sm" data-approve-button-id="'.$expense->id.'" id="approve-button">Approve</button>
                <button class="btn btn-danger btn-sm" data-reject-button-id="'.$expense->id.'" id="reject-button">Reject</button></div>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->input('search')['value'])) {
                    $searchValue = $request->input('search')['value'];
            
                    $query->where(function ($subquery) use ($searchValue) {
                        $subquery->where('id', 'like', '%'.$searchValue.'%')
                            ->orWhere('amount', 'like', '%'.$searchValue.'%')
                            ->orWhereRaw("DATE_FORMAT(created_at, '%d %M %Y') LIKE ?", ['%'.$searchValue.'%'])
                            ->orWhereHas('expenseName', function ($subsubquery) use ($searchValue) {
                                $subsubquery->where('name', 'like', '%'.$searchValue.'%');
                            })
                            ->orWhereHas('ddoName', function ($subsubsubquery) use ($searchValue) {
                                $subsubsubquery->where('name', 'like', '%'.$searchValue.'%')
                                ->orWhere('last_name', 'like', '%'.$searchValue.'%');
                            });
                    });
                }
            })            
        ->rawColumns(['action', 'status'])
        ->make(true);
    } /// End Method

    public function approvedExpenseVoucherByAccountant($id){
        expenseVouchers::findOrFail($id)->update([
            'status' => 1,
            'updated_at' => Carbon::now(),
        ]);
        return response()->json([
            'Success' => 'Voucher Approved Successfully!',
        ]);
    } /// End Method

    public function rejectExpenseVoucherByAccountant($id){
        $expenseVoucher = expenseVouchers::find($id);
        $chartOfAccountDetailAmount = chartOfAccountsDetails::where('id', $expenseVoucher->expense_id)->first();
        chartOfAccountsDetails::findOrFail($chartOfAccountDetailAmount->id)->update([
            'amount' => $chartOfAccountDetailAmount->amount + $expenseVoucher->amount,
            'updated_at' => Carbon::now(),
        ]);
        $budgetAmount = assignBudgetToDdo::where('ddo_id', $expenseVoucher->ddo_id)->first();
        assignBudgetToDdo::findOrFail($budgetAmount->id)->update([
            'total' => $budgetAmount->total + $expenseVoucher->amount,
            'updated_at' => Carbon::now(),
        ]);
        expenseVouchers::findOrFail($id)->delete();
        return response()->json([
            'Success' => 'Voucher Rejected Successfully!',
        ]);
    } /// End Method
}
