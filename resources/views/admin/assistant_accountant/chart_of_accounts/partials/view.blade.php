@extends('admin.master_dashboard')
@section('main')
    <div class="container-fluid">
        <!-- multi-column ordering -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">Detail Chart Of Accounts</h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" value="{{ $chartOfAccount->id }}" name="id">
                        <input type="hidden" value="{{ $chartOfAccount->ddo_id }}" name="ddo_id">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered display" style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <select name="ddo" id="ddo" class="form-control" style="width: 100%; height: 36px" disabled>
                                                    <option value="">Please Select DDO</option>
                                                    @foreach ($ddos as $ddo)
                                                        <option value="{{ $ddo->ddo_id }}" {{ $ddo->ddo_id == $chartOfAccount->ddo_id ? 'selected' : '' }}>{{ $ddo->ddoName->name }} {{ $ddo->ddoName->last_name }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-striped table-bordered display" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="sorting" tabindex="0" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 325.188px;" aria-label="Office: activate to sort column ascending">Name</th>
                                        
                                        <th class="sorting text-center" tabindex="0" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 240.087px;" aria-label="Salary: activate to sort column ascending">Amount</th>
                    
                                    </tr>
                                    </thead>
                            </table>
                            <div class="dataTables_scrollBody" style="position: relative; overflow: auto; max-height: 300px; height: 300px; width: 100%;">
                                <table class="table table-striped table-bordered display" style="width: 100%">
                                    <thead>
                                        <tr style="height: 0px;">
                                            <th class="sorting" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 325.188px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Office: activate to sort column ascending">
                                                <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Name</div>
                                            </th>
                                            <th class="sorting text-center" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 240.087px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Salary: activate to sort column ascending">
                                                <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Amount</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="appendData">
                                        @foreach ($chartOfAccountDetails as $chartOfAccountDetail)
                                            <tr id="delete_add_more_items">
                                                <td>
                                                    <input type="text" class="form-control" name="name[]" placeholder="Enter Name" value="{{ $chartOfAccountDetail->name }}" disabled>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="amount[]" placeholder="Enter Amount" value="{{ $chartOfAccountDetail->amount }}" disabled>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('create.chart.of.account') }}" type="submit" class="btn btn-danger font-weight-medium rounded-pill px-4 mt-4">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection