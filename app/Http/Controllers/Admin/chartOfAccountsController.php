<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\assignDDOsToAccountant;
use App\Models\chartOfAccounts;
use App\Models\chartOfAccountsDetails;
use App\Models\expenseVouchers;
use App\Models\assignBudgetToDdo;
use Carbon\Carbon;
use DataTables;

class chartOfAccountsController extends Controller
{
    public function createChartsOfAccounts(){
        return view('admin.assistant_accountant.chart_of_accounts.index');
    } /// End Method

    public function addChartOfAccount(){
        $ddos = assignDDOsToAccountant::with('ddoName')->where('status', 1)->orderBy('id', 'ASC')->get();
        return view('admin.assistant_accountant.chart_of_accounts.partials.create', compact('ddos'));
    } /// End Method

    public function createCharts(Request $request){
        $chartId = chartOfAccounts::insertGetId([
            'ddo_id' => $request->ddo,
            'chart_no' => $request->chart_no,
            'created_at' => Carbon::now(),
        ]);
        $name = $request->name;
        for ($i=0; $i < count($name) ; $i++) { 
            chartOfAccountsDetails::create([
                'chart_id' => $chartId,
                'ddo_id' => $request->ddo,
                'name' => $request->name[$i],
                'amount' => $request->amount[$i],
                'created_at' => Carbon::now(),
            ]);
        }
        $notification = [
            'message' => 'Chart Of Account Created Successfully!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    } /// End Method

    public function chartOfAccountsList(Request $request){
        $query = chartOfAccounts::with('ddoName');

        return DataTables::of($query)
            ->addColumn('ddo_name', function ($charts) {
                $ddoName = $charts->ddoName ?? null;
                return $ddoName ? $ddoName->name.' '.$ddoName->last_name : null;
            })
            ->addColumn('date', function ($charts) {
                $date = $charts->created_at->format('d F Y');
                return $date;
            })
            ->addColumn('status', function ($charts) {
                $status = $charts->status;
                if ($status == 1) {
                    return '<span class="mb-1 badge font-weight-medium bg-light-warning text-warning">Approved</span>';
                } else {
                    return '<span class="mb-1 badge font-weight-medium bg-light-danger text-danger">Pending</span>';
                }
            })
            ->addColumn('action', function ($charts) {
                return '<a href="'.route("view.chart.of.account", $charts->id).'" class="btn btn-success btn-sm">View</a>
                <a href="'.route("edit.chart.of.account", $charts->id).'" class="btn btn-warning btn-sm">Edit</a>
                <button class="btn btn-danger btn-sm" data-delete-button-id="'.$charts->id.'" id="delete-button">Delete</button>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->input('search')['value'])) {
                    $searchValue = $request->input('search')['value'];
            
                    $query->where(function ($subquery) use ($searchValue) {
                        $subquery->where('id', 'like', '%'.$searchValue.'%')
                            ->orWhereRaw("DATE_FORMAT(created_at, '%d %M %Y') LIKE ?", ['%'.$searchValue.'%'])
                            ->orWhereHas('ddoName', function ($subsubquery) use ($searchValue) {
                                $subsubquery->where('name', 'like', '%'.$searchValue.'%')
                                    ->orWhere('last_name', 'like', '%'.$searchValue.'%');
                            });
                    });
                }
            })
        ->rawColumns(['action', 'status'])
        ->make(true);
    } /// End Method

    public function viewChartOfAccount($id){
        $ddos = assignDDOsToAccountant::with('ddoName')->where('status', 1)->orderBy('id', 'ASC')->get();
        $chartOfAccount = chartOfAccounts::find($id);
        $chartOfAccountDetails = chartOfAccountsDetails::where('chart_id', $id)->get();
        return view('admin.assistant_accountant.chart_of_accounts.partials.view', compact('ddos', 'chartOfAccount', 'chartOfAccountDetails'));
    } /// End Method

    public function editChartOfAccount($id){
        $ddos = assignDDOsToAccountant::with('ddoName')->where('status', 1)->orderBy('id', 'ASC')->get();
        $chartOfAccount = chartOfAccounts::find($id);
        $chartOfAccountDetails = chartOfAccountsDetails::where('chart_id', $id)->get();
        return view('admin.assistant_accountant.chart_of_accounts.partials.update', compact('ddos', 'chartOfAccount', 'chartOfAccountDetails'));
    } /// End Method

    public function updateChart(Request $request){
        // dd($request->name);
        $id = $request->id;
        chartOfAccounts::findOrFail($id)->update([
            'ddo_id' => $request->ddo,
            'chart_no' => $request->chart_no,
            'updated_at' => Carbon::now(),
        ]);

        chartOfAccountsDetails::where('chart_id', $id)->delete();

        for ($i=0; $i < count($request->name) ; $i++) { 
            chartOfAccountsDetails::insert([
                'chart_id' => $id,
                'ddo_id' => $request->ddo,
                'name' => $request->name[$i],
                'amount' => $request->amount[$i],
                'created_at' => Carbon::now(),
            ]);
        }

    
        $notification = [
            'message' => 'Chart Of Account Updated Successfully!',
            'alert-type' => 'success'
        ];
    
        return redirect()->back()->with($notification);
    } /// End Method

    public function deleteChartOfAccount($id){
        chartOfAccounts::findOrFail($id)->delete();
        chartOfAccountsDetails::where('chart_id', $id)->delete();
        return response()->json(['success' => 'Data Delete Successfully']);
    } /// End Method


    //--------------------------------------------- approved Expense Voucher -------------------------------------//

    public function viewExpenceByAssistantAccountant(){
        return view('admin.assistant_accountant.chart_of_accounts.partials.expense_voucher');
    } /// End Method

    public function listExpenseVoucherOfAssistantAccountant(Request $request){
        $query = expenseVouchers::with('expenseName', 'ddoName')->where('status', 1);

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

    public function approvedExpenseVoucherByAssistantAccountant($id){
        expenseVouchers::findOrFail($id)->update([
            'status' => 2,
            'updated_at' => Carbon::now(),
        ]);
        return response()->json([
            'Success' => 'Voucher Approved Successfully!',
        ]);
    } /// End Method

    public function rejectExpenseVoucherByAssistantAccountant($id){
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
