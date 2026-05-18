<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add Customer</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="id_customer">Customer ID</label>
                        <input type="text" class="form-control" id="id_customer" name="id_customer"
                            placeholder="Customer ID"
                            @error('id_customer') is-invalid                              
                                 @enderror
                            value="{{ old('id_customer') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="name"
                            @error('name') is-invalid                              
                                 @enderror
                            value="{{ old('name') }}">
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}
