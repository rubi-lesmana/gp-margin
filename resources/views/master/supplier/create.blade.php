<div class="modal fade" id="add_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add Supplier</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" action="{{ route('suppliers.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="id_supplier">Supplier ID</label>
                                        <input type="text" class="form-control" id="id_supplier" name="id_supplier"
                                            placeholder="Supplier ID"
                                            @error('id_supplier') is-invalid                              
                                                 @enderror
                                            value="{{ old('id_supplier') }}">
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="supplier_name">Name</label>
                                        <input type="text" class="form-control" id="supplier_name"
                                            name="supplier_name" placeholder="Supplier Name"
                                            @error('supplier_name') is-invalid                              
                                                 @enderror
                                            value="{{ old('supplier_name') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" placeholder="Address" rows="3"
                                        @error('address') is-invalid                              
                                                     @enderror
                                        value="{{ old('address') }}"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                        placeholder="Country"
                                        @error('country') is-invalid                              
                                                 @enderror
                                        value="{{ old('country') }}">
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-start gap-3 mt-4">
                                <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}
