<div
    class="modal fade"
    id="bs-add-modal"
    tabindex="-1"
    aria-labelledby="bs-add-modal"
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
            id="closeAddModal"
            ></button>
        </div>
        <div class="modal-body">
            
            <form id="myForm" autocomplete="off">
                <div class="mb-3 form-group">
                    <label for="example-email" class="col-md-12">Select Expense</label>
                    <div class="col-md-12">
                        <select name="expense" class="form-control">
                            <option value="">Please choose Expense</option>
                            @foreach ($charts as $chart)
                                <optgroup label="{{ $chart->chart_no }}" data-select2-id="select2-data-445-usob">
                                    @foreach ($expenses as $expense)
                                        <option value="{{ $expense->id }}" data-select2-id="select2-data-446-ro5t">{{ $expense->name }} (RS {{ $expense->amount }})</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div> 
                
                <div class="mb-3 form-group">
                    <label for="example-email" class="col-md-12">Amount</label>
                    <div class="col-md-12">
                        <input type="number" class="form-control" placeholder="Enter Amount" name="amount">
                    </div>
                </div> 

                <div class="mb-3 form-group">
                    <label for="example-email" class="col-md-12">Detail</label>
                    <div class="col-md-12">
                        <textarea name="detail" class="form-control" rows="5"></textarea>
                    </div>
                </div> 
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info font-weight-medium rounded-pill px-4" id="addButton">
                <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send feather-sm fill-white me-2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                Create An Expense
                </div>
            </button>
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