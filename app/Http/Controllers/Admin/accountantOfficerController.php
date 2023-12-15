<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\assignDDOsToAccountant;
use App\Models\Accountant;
use Carbon\Carbon;
use DataTables;
use App\Models\assignBudgetToDdo;
use Auth;
use App\Models\assignAdvanceToDdo;
use App\Models\expenseVouchers;
use App\Models\chartOfAccountsDetails;

class accountantOfficerController extends Controller
{
    public function assignDdosToAccountant(){
        $accountants = User::where('role', 'accountant')->orderBy('id', 'ASC')->get();
        $ddos = User::where('role', 'ddo')->where('user_assigned', 0)->orderBy('id', 'ASC')->get();
        return view('admin.account_officer.assign_ddo_to_accountant.index', compact('accountants', 'ddos'));
    } /// End Method

    public function approveDdoList(Request $request)
    {
        $query = Accountant::with('accountantName');

        return DataTables::of($query)
            ->addColumn('accountant_name', function ($accountant) {
                $accountantName = $accountant->accountantName ?? null;
                return $accountantName ? $accountantName->name.' '.$accountantName->last_name : null;
            })
            ->addColumn('status', function ($accountant) {
                $status = $accountant->status;
                return $status == 1 ? '<span class="mb-1 badge font-weight-medium bg-light-success text-success">Approved</span>' : '<span class="mb-1 badge font-weight-medium bg-light-danger text-danger">Pending</span>';
            })
            ->addColumn('action', function ($accountant) {
                return '<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-edit-button-id="'.$accountant->id.'" id="edit-button">Edit</button>
                <button class="btn btn-danger btn-sm" data-delete-button-id="'.$accountant->id.'" id="delete-button">Delete</button>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->input('search')['value'])) {
                    $searchValue = $request->input('search')['value'];
            
                    if ($searchValue === 'pending') {
                        $query->where('status', 0);
                    } elseif ($searchValue === 'approved') {
                        $query->where('status', 1);
                    } else {
                        $query->where(function ($subquery) use ($searchValue) {
                            $subquery->where('id', 'like', '%'.$searchValue.'%')
                                ->orWhereHas('accountantName', function ($subsubquery) use ($searchValue) {
                                    $subsubquery->where('name', 'like', '%'.$searchValue.'%')
                                        ->orWhere('last_name', 'like', '%'.$searchValue.'%');
                                });
                        });
                    }
                }
            })
        ->rawColumns(['action', 'status'])
        ->make(true);
    }


    public function createAssigned(Request $request){
        $accountant = $request->accountant;

        
        $accountand_last_id = Accountant::insertGetId([
            'accountant_id' => $accountant
        ]);

        $ddo = $request->ddo_id;

        for ($i=0; $i < count($ddo); $i++) { 
            assignDDOsToAccountant::insert([
                'accountant_id' => $accountant,
                'ddo_id' => $ddo[$i],
                'created_at' => Carbon::now(), 
            ]);
        }

        foreach ($ddo as $value) {
            User::where('id', $value)->update([
                'user_assigned' => 1
            ]);
        }

        $notification = array(
            'message' => 'DDOs request sended successfully!',
            'alert-type' => 'success'
        );

        return response()->json($notification);
        
    } /// End Method

    public function ddoDataForUpdateModal(){
        $ddos = User::where('role', 'ddo')->where('user_assigned', 0)->orderBy('id', 'ASC')->get();
        return json_encode($ddos);
    } /// End Method

    public function ddoToAccountantEditData($id){
        $editData = Accountant::findOrFail($id);
        return response()->json(array(
            'editData' => $editData
        ));
    } /// End Method

    public function displayPreviousDataofDDO(Request $request){
        $uid = $request->uid;
        $data = assignDDOsToAccountant::with('ddoName')->where('accountant_id', $uid)->get();
        return json_encode($data);
    } /// End Method

    public function deleteDDOData(Request $request){
        $dId = $request->dId;
        $delete = assignDDOsToAccountant::where('ddo_id', $dId)->delete();
        User::where('id', $dId)->update([
            'user_assigned' => 0
        ]);
        return response()->json([
            'success' => 'DDO Delete Successfully'
        ]);
    } /// End Method

    public function updateDDOToAccountant(Request $request){
        $accountand_last_id = $request->accountant_id;
        $ddo = $request->uDdo_id;

        for ($i=0; $i < count($ddo); $i++) { 
            assignDDOsToAccountant::insert([
                'accountant_id' => $accountand_last_id,
                'ddo_id' => $ddo[$i],
                'created_at' => Carbon::now(), 
            ]);
        }

        foreach ($ddo as $value) {
            User::where('id', $value)->update([
                'user_assigned' => 1
            ]);
        }

        $notification = array(
            'message' => 'DDOs updated successfully!',
            'alert-type' => 'success'
        );

        return response()->json($notification);
    } /// End Method

    public function deleteDataDDOToAccountant($id) {
        $ddo_to_accountant = assignDDOsToAccountant::where('accountant_id', $id)->get();
    
        foreach ($ddo_to_accountant as $value) {
            User::where('id', $value->ddo_id)->update([
                'user_assigned' => 0
            ]);
        }

        Accountant::findOrFail($id)->delete();
    
        return response()->json(['success' => 'Data Delete Successfully']);
    }  
    
    //- ------------------------------- Send Request For budget --------------------------------------- - //

    public function sendRequestForBudget(){
        $ddos = assignDDOsToAccountant::with('ddoName')->where('accountant_id', auth()->id())->where('status', 1)->get();
        return view('admin.account_officer.request_for_budget.index', compact('ddos'));
    } /// End Method

    public function createAssignedBudget(Request $request){
        $existingRecord = assignBudgetToDdo::where('ddo_id', $request->ddo)->first();
    
        if ($existingRecord) {
            $notification = [
                'message' => 'Budget request failed. Please Search DDO and assign new budget.',
                'alert-type' => 'error'
            ];
    
            return response()->json($notification);
        }
    
        assignBudgetToDdo::insert([
            'ddo_id' => $request->ddo,
            'budget' => $request->budget,
            'total' => $request->budget,
            'created_at' => now(),
        ]);
    
        $notification = [
            'message' => 'Budget request sent successfully!',
            'alert-type' => 'success'
        ];
    
        return response()->json($notification);
    }    
    
    public function requestedDDOList(Request $request){
        $query = assignBudgetToDdo::with('ddoName', 'BudgetData');

        return DataTables::of($query)
            ->addColumn('ddo_name', function ($ddo) {
                $ddoName = $ddo->ddoName ?? null;
                return $ddoName ? $ddoName->name.' '.$ddoName->last_name : null;
            })
            ->addColumn('status', function ($ddo) {
                $status = $ddo->status;
                return $status == 1 ? '<span class="mb-1 badge font-weight-medium bg-light-success text-success">Approved</span>' : '<span class="mb-1 badge font-weight-medium bg-light-danger text-danger">Pending</span>';
            })
            ->addColumn('action', function ($ddo) {
                return '<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-edit-button-id="'.$ddo->id.'" id="edit-button">Edit</button>
                <button class="btn btn-danger btn-sm" data-delete-button-id="'.$ddo->id.'" id="delete-button">Delete</button>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->input('search')['value'])) {
                    $searchValue = $request->input('search')['value'];
            
                    if ($searchValue === 'pending') {
                        $query->where('status', 0);
                    } elseif ($searchValue === 'approved') {
                        $query->where('status', 1);
                    } else {
                        $query->where(function ($subquery) use ($searchValue) {
                            $subquery->where('id', 'like', '%'.$searchValue.'%')
                            ->orWhere('budget', 'like', '%'.$searchValue.'%')
                                ->orWhereHas('ddoName', function ($subsubquery) use ($searchValue) {
                                    $subsubquery->where('name', 'like', '%'.$searchValue.'%')
                                        ->orWhere('last_name', 'like', '%'.$searchValue.'%');
                                });
                        });
                    }
                }
            })
        ->rawColumns(['action', 'status'])
        ->make(true);
    } /// End Method

    public function requestedBudgetEditData($id){
        $editData = assignBudgetToDdo::findOrFail($id);
        return response()->json(array(
            'editData' => $editData
        ));
    } /// End Method

    public function updateRequestedBudget(Request $request){
        $id = $request->ddo_id;
        assignBudgetToDdo::findOrFail($id)->update([
            'ddo_id' => $request->ddo,
            'budget' => $request->budget,
            'total' => $request->budget,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Budget request updated successfully!',
            'alert-type' => 'success'
        );
        return response()->json($notification);
    } /// End Method

    public function deleteBudget($id){
        assignBudgetToDdo::findOrFail($id)->delete();
        return response()->json([
            'success' => 'Data Deleted Successfully'
        ]);
    } /// End MEthod


    //- ------------------------- Send Request For Advance ---------------------------- -//


    public function requestForAdvance(Request $request, $id){
        assignBudgetToDdo::findOrFail($id)->update([
            'advance' => $request->advance,
        ]);
        $notification = array(
            'message' => 'Advance request sended successfully!',
            'alert-type' => 'success'
        );

        return response()->json($notification);
    } /// End Method

    public function sendRequestForAdvance(){
        $ddos = assignDDOsToAccountant::with('ddoName')->where('accountant_id', auth()->id())->where('status', 1)->get();
        return view('admin.account_officer.request_for_advance.index', compact('ddos'));
    } /// End Method

    public function requestedAdvanceList(Request $request){
        $query = assignAdvanceToDdo::with('ddoName');

        return DataTables::of($query)
            ->addColumn('ddo_name', function ($ddo) {
                $ddoName = $ddo->ddoName ?? null;
                return $ddoName ? $ddoName->name.' '.$ddoName->last_name : null;
            })
            ->addColumn('status', function ($ddo) {
                $status = $ddo->status;
                return $status == 1 ? '<span class="mb-1 badge font-weight-medium bg-light-success text-success">Approved</span>' : '<span class="mb-1 badge font-weight-medium bg-light-danger text-danger">Pending</span>';
            })
            ->addColumn('action', function ($ddo) {
                return '<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-edit-button-id="'.$ddo->id.'" id="edit-button">Edit</button>
                <button class="btn btn-danger btn-sm" data-delete-button-id="'.$ddo->id.'" id="delete-button">Delete</button>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->input('search')['value'])) {
                    $searchValue = $request->input('search')['value'];
            
                    if ($searchValue === 'pending') {
                        $query->where('status', 0);
                    } elseif ($searchValue === 'approved') {
                        $query->where('status', 1);
                    } else {
                        $query->where(function ($subquery) use ($searchValue) {
                            $subquery->where('id', 'like', '%'.$searchValue.'%')
                            ->orWhere('advance', 'like', '%'.$searchValue.'%')
                                ->orWhereHas('ddoName', function ($subsubquery) use ($searchValue) {
                                    $subsubquery->where('name', 'like', '%'.$searchValue.'%')
                                        ->orWhere('last_name', 'like', '%'.$searchValue.'%');
                                });
                        });
                    }
                }
            })
        ->rawColumns(['action', 'status'])
        ->make(true);
    } /// End Method

    public function createAssignedAdvance(Request $request){
        $ddoId = $request->ddo;
        $newAdvance = $request->advance;
    
        $existingData = assignAdvanceToDdo::where('ddo_id', $ddoId)->first();
    
        if ($existingData) {
            $existingData->update([
                'advance' => $existingData->advance + $newAdvance,
                'created_at' => Carbon::now(),
            ]);
        } else {
            assignAdvanceToDdo::create([
                'ddo_id' => $ddoId,
                'advance' => $newAdvance,
                'created_at' => Carbon::now(),
            ]);
        }
    
        $notification = [
            'message' => 'Advance request sent successfully!',
            'alert-type' => 'success'
        ];
    
        return response()->json($notification);
    }    

    public function requestedAdvanceEditData($id){
        $editData = assignAdvanceToDdo::findOrFail($id);
        return response()->json(array(
            'editData' => $editData
        ));
    } /// End Method

    public function updateRequestedAdvance(Request $request){
        $id = $request->ddo_id;
        assignAdvanceToDdo::findOrFail($id)->update([
            'ddo_id' => $request->ddo,
            'advance' => $request->advance,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Advance request updated successfully!',
            'alert-type' => 'success'
        );
        return response()->json($notification);
    } /// End Method

    public function deleteAdvance($id){
        assignAdvanceToDdo::findOrFail($id)->delete();
        return response()->json([
            'success' => 'Data Deleted Successfully'
        ]);
    } /// End MEthod

    //-------------------------- Expense Voucher -------------------------------//

    public function viewExpenceByAccountOfficer(){
        return view('admin.account_officer.expense_voucher');
    } /// End Method

    public function listExpenseVoucherOfAccountOfficer(Request $request){
        $query = expenseVouchers::with('expenseName', 'ddoName')->where('status', 2);

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

    public function approvedExpenseVoucherByAccountOfficer($id){
        expenseVouchers::findOrFail($id)->update([
            'status' => 3,
            'updated_at' => Carbon::now(),
        ]);
        return response()->json([
            'Success' => 'Voucher Approved Successfully!',
        ]);
    } /// End Method

    public function rejectExpenseVoucherByAccountOfficer($id){
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
