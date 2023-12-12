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
            Update Advance
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
                <input type="hidden" name="ddo_id" id="ddo_id">
                <div class="mb-3 form-group">
                    <label for="example-email" class="col-md-12">Select DDO</label>
                    <div class="col-md-12">
                        <select name="ddo" id="ddo" class="form-control">
                            <option value="">Please select DDO</option>
                            @foreach ($ddos as $ddo)
                                <option value="{{ $ddo->ddo_id }}">{{ $ddo->ddoName->name }} {{ $ddo->ddoName->last_name }}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3 form-group">
                    <label for="example-email" class="col-md-12">Enter Advance</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="advance" id="advance" placeholder="Enter Advance">
                    </div>
                </div>
            
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" type="button" id="updateButton">
                Save
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