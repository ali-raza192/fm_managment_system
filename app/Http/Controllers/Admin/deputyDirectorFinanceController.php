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
use Auth;

class deputyDirectorFinanceController extends Controller
{
    public function manageAccounts(){
        $users = User::latest()->get();
        return view('admin.deputy_director_finance.index', compact('users'));
    } /// End Method

    public function accountData(){
        return DataTables::of(User::query())
        ->addColumn('action', function ($user) {
            return '<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-edit-button-id="'.$user->id.'" id="edit-button">Edit</button>
            <button class="btn btn-danger btn-sm" data-delete-button-id="'.$user->id.'" id="delete-button">Delete</button>';
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

            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'address' => $request->address,
                ]
            );

            $notification = [
                'message' => $user->wasRecentlyCreated ? 'User account created successfully!' : 'This email is already taken.',
                'alert-type' => $user->wasRecentlyCreated ? 'success' : 'error',
            ];

            return response()->json($notification);
        } catch (\Exception $e) {
            \Log::error('Error in create method:', ['message' => $e->getMessage(), 'trace' => $e->getTrace()]);
            return response()->json(['message' => 'An error occurred while creating the account.', 'alert-type' => 'error']);
        }
    } /// End Method

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
                User::findOrFail($eId)->update([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'address' => $request->address,
                ]);
                $notification = [
                    'message' => 'User account update successfully.',
                    'alert-type' => 'success',
                ];
                return response()->json($notification);
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
                return '<button class="btn btn-success btn-sm" data-status-button-id="'.$accountant->accountant_id.'" id="status-button">Approve</button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-view-button-id="'.$accountant->id.'" id="view-button">View</button>';
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
        $ddos = assignDDOsToAccountant::with('ddoName')->where('accountant_id', auth()->id())->where('status', 1)->get();
        return view('admin.deputy_director_finance.approve_budget.index', compact('ddos'));
    } /// ENd Method

    public function deputyApproveBudget(Request $request){
        $query = assignBudgetToDdo::with('ddoName', 'BudgetData');

        return DataTables::of($query)
            ->addColumn('ddo_name', function ($ddo) {
                $ddoName = $ddo->ddoName ?? null;
                return $ddoName ? $ddoName->name.' '.$ddoName->last_name : null;
            })
            ->addColumn('budget_price', function ($ddo) {
                $advancePrice = $ddo->BudgetData->advance ?? 0;
                $status = $ddo->BudgetData->status ?? 0;
                $budgetPrice = $ddo->budget;

                return $status == 1 ? $advancePrice + $budgetPrice : $budgetPrice;
            })
            ->addColumn('status', function ($ddo) {
                $status = $ddo->status;
                return $status == 1 ? '<span class="mb-1 badge font-weight-medium bg-light-success text-success">Approved</span>' : '<span class="mb-1 badge font-weight-medium bg-light-danger text-danger">Pending</span>';
            })
            ->addColumn('action', function ($ddo) {
                return '<button class="btn btn-success btn-sm" data-status-button-id="'.$ddo->id.'" id="status-button">Approve</button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-view-button-id="'.$ddo->id.'" id="view-button">View</button>
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
    }

    public function statusApproveBudget($id){
        assignBudgetToDdo::findOrFail($id)->update([
            'status' => 1,
            'updated_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Budget Approved successfully to this DDO!',
            'alert-type' => 'success'
        ];

        return response()->json($notification);
    } /// End Method

    //- -------------------------------- Approve Advance ----------------------------------- -//

    public function approveAdvance(){
        $ddos = assignDDOsToAccountant::with('ddoName')->where('accountant_id', auth()->id())->where('status', 1)->get();
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
                return '<button class="btn btn-success btn-sm" data-status-button-id="'.$ddo->id.'" id="status-button">Approve</button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bs-update-modal" data-view-button-id="'.$ddo->id.'" id="view-button">View</button>
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

    public function statusApprovedAdvance($id){
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




}
