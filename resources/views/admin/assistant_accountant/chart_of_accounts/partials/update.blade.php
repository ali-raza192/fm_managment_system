@extends('admin.master_dashboard')
@section('main')
    <div class="container-fluid">
        <!-- multi-column ordering -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">Update Chart Of Accounts</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update.charts') }}" method="POST" id="myForm">
                            @csrf
                            <input type="hidden" value="{{ $chartOfAccount->id }}" name="id">
                            <input type="hidden" value="{{ $chartOfAccount->ddo_id }}" name="ddo_id">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered display" style="width: 100%">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <select name="ddo" id="ddo" class="form-control select2" style="width: 100%; height: 36px">
                                                        <option value="">Please Select DDO</option>
                                                        @foreach ($ddos as $ddo)
                                                            <option value="{{ $ddo->ddo_id }}" {{ $ddo->ddo_id == $chartOfAccount->ddo_id ? 'selected' : '' }}>{{ $ddo->ddoName->name }} {{ $ddo->ddoName->last_name }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <h4 class="card-title mb-0"><button type="button" class="btn btn-success addEvent" style="float: right;" id="addEvent"><i class="mdi mdi-plus"></i></button></h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered display" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="sorting" tabindex="0" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 325.188px;" aria-label="Office: activate to sort column ascending">Name</th>
                                            
                                            <th class="sorting text-center" tabindex="0" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 240.087px;" aria-label="Salary: activate to sort column ascending">Amount</th>
    
                                            <th class="sorting text-center" tabindex="0" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 240.087px;" aria-label="Salary: activate to sort column ascending">Action</th>
                        
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
                                                <th class="sorting text-center" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 240.087px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Salary: activate to sort column ascending">
                                                    <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Action</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="appendData">
                                            @foreach ($chartOfAccountDetails as $chartOfAccountDetail)
                                                <tr id="delete_add_more_items">
                                                    <td>
                                                        <input type="text" class="form-control" name="name[]" placeholder="Enter Name" value="{{ $chartOfAccountDetail->name }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="amount[]" placeholder="Enter Amount" value="{{ $chartOfAccountDetail->amount }}">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm" id="removerow"><i class="mdi mdi-minus-circle-outline"></i></button>
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
                                </a> &nbsp;&nbsp;&nbsp;
                                <button type="submit" class="btn btn-info font-weight-medium rounded-pill px-4 mt-4">
                                    <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send feather-sm fill-white me-2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                    Update Chart Of Account
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#addEvent', function() {
                var html = '';
                html += `<tr id="delete_add_more_items">
                    <td>
                        <input type="text" class="form-control" name="name[]" placeholder="Enter Name">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="amount[]" placeholder="Enter Amount">
                    </td>
                    <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm" id="removerow"><i class="mdi mdi-minus-circle-outline"></i></button>
                    </td>
                </tr>`;
                $("#appendData").append(html);
            });
            $(document).on("click", "#removerow", function(e) {
                $(this).closest("#delete_add_more_items").remove();
            });
            // validate assign ddos form input feilds
            $('#myForm').validate({
                rules: {
                    ddo: {
                        required: true,
                    },
                    'name[]': {
                        required: true,
                    },
                    'amount[]': {
                        required: true,
                        number: true,
                    },
                },
                messages: {
                    ddo: {
                        required: 'Please select DDO',
                    },
                    'name[]': {
                        required: 'Please Enter Name',
                    },
                    'amount[]': {
                        required: 'Please Enter Amount',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection