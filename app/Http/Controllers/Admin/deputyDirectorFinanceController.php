<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\assignDDOsToAccountant;
use App\Models\Accountant;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Hash;
use App\Models\assignBudgetToDdo;
use App\Models\assignAdvanceToDdo;
use App\Models\expenseVouchers;
use App\Models\chartOfAccountsDetails;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\chartOfAccounts;

class deputyDirectorFinanceController extends Controller
{
    public function manageAccounts(){
        $users = User::latest()->get();
        $roles = Role::all();
        return view('admin.deputy_director_finance.index', compact('users', 'roles'));
    } /// End Method

    public function accountData(){
        return DataTables::of(User::query())
        ->addColumn('action', function ($user) {
            return '<div class="text-center"><button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-edit-button-id="'.$user->id.'" id="edit-button">Edit</button>
            <button class="btn btn-danger btn-sm" data-delete-button-id="'.$user->id.'" id="delete-button">Delete</button></div>';
        })
        ->rawColumns(['action'])
        ->make(true);
    } /// End Method

    public function view(){
        return view('admin.deputy_director_finance.view');
    } /// End Method

    public function create(Request $request)
    {
        try {
            // Check if the user with the provided email already exists
            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                // User with this email already exists
                $notification = [
                    'message' => 'This email is already taken.',
                    'alert-type' => 'error',
                ];
            } else {
                // Create a new user
                $user = new User();
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->password = Hash::make($request->password);
                $user->role = $request->role;
                $user->address = $request->address;

                $user->save();

                // Assign role if provided
                if ($request->role) {
                    $user->assignRole($request->role);
                }

                $notification = [
                    'message' => 'User account created successfully!',
                    'alert-type' => 'success',
                ];
            }

            return response()->json($notification);
        } catch (\Exception $e) {
            \Log::error('Error in create method:', ['message' => $e->getMessage(), 'trace' => $e->getTrace()]);
            return response()->json(['message' => 'An error occurred while creating the account.', 'alert-type' => 'error']);
        }
    }
 /// End Method

    public function editUserData($id){
        $editUser = User::findOrFail($id);
        return response()->json(array(
            'editUser' => $editUser
        ));
    } /// End Method

    public function updateAccount(Request $request)
    {
        try {

            $eId = $request->id;
            $existingUser = User::where('email', $request->input('email'))->where('id', '!=', $eId)->first();
            if ($existingUser) {
                $notification = [
                    'message' => 'This email is already taken.',
                    'alert-type' => 'error',
                ];
                return response()->json($notification);
            } else {
                if ($request->password) {
                    $user = User::findOrFail($eId);
                    $user->name = $request->name;
                    $user->last_name = $request->last_name;
                    $user->email = $request->email;
                    $user->phone = $request->phone;
                    $user->password = Hash::make($request->password);
                    $user->role = $request->role;
                    $user->address = $request->address;
                    $user->save();
                    $user->roles()->detach();
                    if ($request->role) {
                        $user->assignRole($request->role);
                    }
                    $notification = [
                        'message' => 'User account update successfully.',
                        'alert-type' => 'success',
                    ];
                    return response()->json($notification);
                } else {
                    $user = User::findOrFail($eId);
                    $user->name = $request->name;
                    $user->last_name = $request->last_name;
                    $user->email = $request->email;
                    $user->phone = $request->phone;
                    $user->role = $request->role;
                    $user->address = $request->address;
                    $user->save();
                    $user->roles()->detach();
                    if ($request->role) {
                        $user->assignRole($request->role);
                    }
                    $notification = [
                        'message' => 'User account update successfully.',
                        'alert-type' => 'success',
                    ];
                    return response()->json($notification);
                }
                
            }
        } catch (\Exception $e) {
            \Log::error('Error in create method:', ['message' => $e->getMessage(), 'trace' => $e->getTrace()]);
            return response()->json(['message' => 'An error occurred while updating this account.', 'alert-type' => 'error']);
        }
    } /// End Method

    public function deleteUser($id){
        $deleteUser = User::findOrFail($id);
        $deleteUser->delete();
        return response()->json(['success' => 'User Delete Successfully']);
    } /// end Method


    public function approveDDOAssignToAccountant(){
        $accountants = User::where('role', 'accountant')->orderBy('id', 'ASC')->get();
        return view('admin.deputy_director_finance.approve_ddo_assign_to_accountant.index', compact('accountants'));
    } /// End Method

    public function deputyDirectorApproveDDO(Request $request)
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
                return '<div class="text-center"><button class="btn btn-success btn-sm" data-status-button-id="'.$accountant->accountant_id.'" id="status-button">Approve</button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-view-button-id="'.$accountant->id.'" id="view-button">View</button></div>';
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
    } /// End Method

    public function statusApproveDDO($id)
    {
        try {

            Accountant::where('accountant_id', $id)->update([
                'status' => 1,
                'updated_at' => now(),
            ]);

            $ddoData = assignDDOsToAccountant::where('accountant_id', $id)->get();

            foreach ($ddoData as $ddo) {
                $ddo->update([
                    'status' => 1,
                    'updated_at' => now(),
                ]);
            }

            $notification = [
                'message' => 'DDO assigned successfully to this accountant!',
                'alert-type' => 'success'
            ];

            return response()->json($notification);
            
        } catch (\Exception $e) {
            
            $notification = [
                'message' => 'An error occurred: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    } /// End Method

    public function approveBudget(){
        $ddos = assignDDOsToAccountant::with('ddoName')->where('status', 1)->get();
        return view('admin.deputy_director_finance.approve_budget.index', compact('ddos'));
    } /// ENd Method

    public function deputyApproveBudget(Request $request){
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
                return '<div class="text-center"><button class="btn btn-success btn-sm" data-status-button-id="'.$ddo->id.'" id="status-button">Approve</button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-view-button-id="'.$ddo->id.'" id="view-button">View</button>
                <button class="btn btn-danger btn-sm" data-delete-button-id="'.$ddo->id.'" id="delete-button">Delete</button></div>';
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
    }

    public function statusApproveBudget($id){
        $ifNewBudget = assignBudgetToDdo::find($id);
        if ($ifNewBudget->new_budget == NULL) {
            assignBudgetToDdo::findOrFail($id)->update([
                'status' => 1,
                'updated_at' => Carbon::now(),
            ]);
            $notification = [
                'message' => 'Budget Approved successfully to this DDO!',
                'alert-type' => 'success'
            ];
        } else {
            assignBudgetToDdo::findOrFail($id)->update([
                'total' => $ifNewBudget->new_budget + $ifNewBudget->total,
                'new_budget' => null,
                'status' => 1,
                'updated_at' => Carbon::now(),
            ]);
            $notification = [
                'message' => 'New Budget Approved successfully to this DDO!',
                'alert-type' => 'success'
            ];
        }
        
        

        return response()->json($notification);
    } /// End Method

    //- -------------------------------- Approve Advance ----------------------------------- -//

    public function approveAdvance(){
        $ddos = assignDDOsToAccountant::with('ddoName')->where('status', 1)->get();
        return view('admin.deputy_director_finance.approve_advance.index', compact('ddos'));
    } /// End Method


    public function deputyDirectorApprovedAdvance(Request $request){
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
                return '<div class="text-center"><button class="btn btn-success btn-sm" data-status-button-id="'.$ddo->id.'" id="status-button">Approve</button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-view-button-id="'.$ddo->id.'" id="view-button">View</button>
                <button class="btn btn-danger btn-sm" data-delete-button-id="'.$ddo->id.'" id="delete-button">Delete</button></div>';
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

    public function statusApprovedAdvance($id){
        $getadvance = assignAdvanceToDdo::find($id);
        $budgetAmount = assignBudgetToDdo::where('ddo_id', $getadvance->ddo_id)->first();
        assignBudgetToDdo::where('ddo_id', $getadvance->ddo_id)->update([
            'advance' => $getadvance->advance,
            'total' => $getadvance->advance + $budgetAmount->total,
        ]);
        assignAdvanceToDdo::findOrFail($id)->update([
            'status' => 1,
            'updated_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Advance Approved successfully to this DDO!',
            'alert-type' => 'success'
        ];

        return response()->json($notification);
    } /// End Method


    // --------------------------------------- Expense Voucher ----------------------------------//

    public function viewExpenceByDeputyDirector(){
        return view('admin.deputy_director_finance.expense_voucher');
    } /// End Method

    public function listExpenseVoucherOfDeputyDirector(Request $request){
        $query = expenseVouchers::with('expenseName', 'ddoName')->where('status', 3);

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

    public function approvedExpenseVoucherByDeputyDirector($id){
        expenseVouchers::findOrFail($id)->update([
            'status' => 4,
            'updated_at' => Carbon::now(),
        ]);
        return response()->json([
            'Success' => 'Voucher Approved Successfully!',
        ]);
    } /// End Method

    public function rejectExpenseVoucherByDeputyDirector($id){
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

    //- -------------------------------- Approve Chart Of accounts --------------------------------//

    public function approveChartOfAccount(){
        return view('admin.deputy_director_finance.approve_chart_of_account.index');
    } /// End Method

    public function listApproveChartOfAccount(Request $request){
        $query = chartOfAccounts::with('ddoName')->where('status', 0);

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
                return '<div class="text-center"><a href="'.route("deputy.view.chart.of.account", $charts->id).'" class="btn btn-success btn-sm">View</a>
                <a href="'.route("deputy.approve.chart.of.account", $charts->id).'" class="btn btn-warning btn-sm">Approve</a>
                <button class="btn btn-danger btn-sm" data-delete-button-id="'.$charts->id.'" id="delete-button">Reject</button></div>';
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

    public function deputyApproveChartOfAccount($id){
        chartOfAccounts::findOrFail($id)->update([
            'status' => 1,
            'updated_at' => Carbon::now(),
        ]);
        chartOfAccountsDetails::where('chart_id', $id)->update([
            'status' => 1,
            'updated_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Status Approved Successfully!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);

    } /// End Method

    public function deputyViewChartOfAccount($id){
        $ddos = assignDDOsToAccountant::with('ddoName')->where('status', 1)->orderBy('id', 'ASC')->get();
        $chartOfAccount = chartOfAccounts::find($id);
        $chartOfAccountDetails = chartOfAccountsDetails::where('chart_id', $id)->get();
        return view('admin.deputy_director_finance.approve_chart_of_account.partials.view', compact('ddos', 'chartOfAccount', 'chartOfAccountDetails'));
    } /// End Method

}
