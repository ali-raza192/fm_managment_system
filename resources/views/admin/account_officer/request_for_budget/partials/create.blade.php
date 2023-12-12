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
            Request For Budget
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
            
            <form id="myForm">
                <div class="mb-3 form-group">
                    <label for="example-email" class="col-md-12">Select DDO</label>
                    <div class="col-md-12">
                        <select name="ddo" class="form-control">
                            <option value="">Please select DDO</option>
                            @foreach ($ddos as $ddo)
                                <option value="{{ $ddo->ddo_id }}">{{ $ddo->ddoName->name }} {{ $ddo->ddoName->last_name }}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3 form-group">
                    <label for="example-email" class="col-md-12">Enter Budget</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="budget" placeholder="Enter Budget">
                    </div>
                </div>
                
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info font-weight-medium rounded-pill px-4" id="addButton">
                <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send feather-sm fill-white me-2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                Send Request for approve
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
