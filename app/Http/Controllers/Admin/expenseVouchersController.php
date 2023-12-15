<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\assignDDOsToAccountant;
use App\Models\chartOfAccounts;
use App\Models\chartOfAccountsDetails;
use App\Models\expenseVouchers;
use App\Models\assignBudgetToDdo;
use App\Models\assignAdvanceToDdo;
use Carbon\Carbon;
use DataTables;

class expenseVouchersController extends Controller
{
    public function expenseVouchers(){
        $budget = assignBudgetToDdo::where('ddo_id', auth()->user()->id)->first();
        $charts = chartOfAccounts::where('ddo_id', auth()->user()->id)->get();
        $expenses = chartOfAccountsDetails::where('ddo_id', auth()->user()->id)->get();
        return view('admin.ddo.index', compact('charts', 'expenses', 'budget'));
    } /// End Method

    public function listExpenseVouchers(Request $request){
        $query = expenseVouchers::with('expenseName')->where('ddo_id', auth()->user()->id);

        return DataTables::of($query)
            ->addColumn('expense_name', function ($expense) {
                $expenseName = $expense->expenseName ?? null;
                return $expenseName ? $expenseName->name : null;
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
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->input('search')['value'])) {
                    $searchValue = $request->input('search')['value'];
            
                    $query->where(function ($subquery) use ($searchValue) {
                        $subquery->where('id', 'like', '%'.$searchValue.'%')
                            ->orWhere('amount', 'like', '%'.$searchValue.'%')
                            ->orWhereRaw("DATE_FORMAT(created_at, '%d %M %Y') LIKE ?", ['%'.$searchValue.'%'])
                            ->orWhereHas('expenseName', function ($subsubquery) use ($searchValue) {
                                $subsubquery->where('name', 'like', '%'.$searchValue.'%');
                        });
                    });
                }
            })
        ->rawColumns(['action', 'status'])
        ->make(true);
    } /// End Method

    public function listChartOfAccoun($id){
        $ddos = assignDDOsToAccountant::with('ddoName')->where('status', 1)->orderBy('id', 'ASC')->get();
        $chartOfAccount = chartOfAccounts::find($id);
        $chartOfAccountDetails = chartOfAccountsDetails::where('chart_id', $id)->get();
        return view('admin.ddo.partials.view', compact('ddos', 'chartOfAccount', 'chartOfAccountDetails'));
    } /// End Method

    public function createExpenseVoucher(Request $request){
        $ddo_id = auth()->user()->id;
        $expense_id = $request->expense;
        $amount = $request->amount;
        $detail = $request->detail;
    
        $expenseDetails = chartOfAccountsDetails::find($expense_id);
    
        if (!$expenseDetails) {
            $notification = [
                'message' => 'Invalid Expense ID!',
                'alert-type' => 'error'
            ];
            return response()->json($notification);
        }
    
        $checkOverAllBudget = assignBudgetToDdo::where('ddo_id', $ddo_id)->first();
    
        if ($amount > $checkOverAllBudget->total) {
            $notification = [
                'message' => 'Not Enough Budget Available!',
                'alert-type' => 'error'
            ];
            return response()->json($notification);
        }
    
        if ($amount > $expenseDetails->amount) {
            $notification = [
                'message' => 'Not Enough Cash Available!',
                'alert-type' => 'error'
            ];
            return response()->json($notification);
        }

        chartOfAccountsDetails::where('id', $expenseDetails->id)->update([
            'amount' => $expenseDetails->amount - $amount,
        ]);

        assignBudgetToDdo::where('ddo_id', $ddo_id)->update([
            'total' => $checkOverAllBudget->total - $amount,
        ]);
    
        expenseVouchers::insert([
            'expense_id' => $expense_id,
            'ddo_id' => $ddo_id,
            'amount' => $amount,
            'detail' => $detail,
            'created_at' => now(),
        ]);
    
        $notification = [
            'message' => 'Expense Voucher Created Successfully!',
            'alert-type' => 'success'
        ];
    
        return response()->json($notification);
    }
    
}
