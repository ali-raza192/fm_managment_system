<div
    class="modal fade"
    id="bs-update-modal"
    tabindex="-1"
    aria-labelledby="bs-update-modal"
    aria-hidden="true"
    >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
            <h4 class="modal-title" id="myLargeModalLabel">
            Create Account
            </h4>
            <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            id="closeUpdateModal"
            ></button>
        </div>
        <div class="modal-body">
           
            <form id="updateForm">
                <table class="table table-striped table-bordered display" style="width: 100%">
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="accountant_id" id="accountant_id">
                                <div class="form-group">
                                    <select name="uAccountant" id="uAccountant" class="form-control" style="width: 100%; height: 36px" disabled>
                                        <option value="">Please Select Accountant</option>
                                        @foreach ($accountants as $accountant)
                                            <option value="{{ $accountant->id }}">{{ $accountant->name }} {{ $accountant->last_name }}</option>   
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <h4 class="card-title mb-0"><button type="button" class="btn btn-success" style="float: right;" id="uAddEvent"><i class="mdi mdi-plus"></i></button></h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-bordered display" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="sorting" tabindex="0" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 325.188px;" aria-label="Office: activate to sort column ascending">DDOs</th>

                            <th class="sorting text-center" tabindex="0" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 240.087px;" aria-label="Salary: activate to sort column ascending">Action</th>

                        </tr>
                      </thead>
                </table>
                <div class="dataTables_scrollBody" style="position: relative; overflow: auto; max-height: 300px; height: 300px; width: 100%;">
                    <table class="table table-striped table-bordered display" style="width: 100%">
                        <thead>
                            <tr style="height: 0px;">
                                <th class="sorting" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 325.188px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Office: activate to sort column ascending">
                                    <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">DDOs</div>
                                </th>
                                <th class="sorting text-center" aria-controls="show_hide_col" rowspan="1" colspan="1" style="width: 240.087px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" aria-label="Salary: activate to sort column ascending">
                                    <div class="dataTables_sizing" style="height: 0px; overflow: hidden;">Action</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="addDDOData">
                            {{-- <tr id="uDelete_add_more_items">
                                <td>
                                    <select class="form-control" name="uDdo_id[]">
                                        
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm" id="removerow"><i class="mdi mdi-minus-circle-outline"></i></button>
                                </td>
                            </tr> --}}
                            </tbody>
                    </table>
                </div>
            
        </div>
        <div class="modal-footer">
            <div class="display-button" style="display: none">
                <button class="btn btn-success" type="button" id="updateButton">
                    Save
                </button>
            </div>
            <button
                type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start"
                data-bs-dismiss="modal">
                Close
            </button>
        </div>
    </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>