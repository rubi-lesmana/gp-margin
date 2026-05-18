@foreach ($data as $customer)
    <div class="modal fade" id="edit_customer{{ $customer->safe_id_customer }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update Customer</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('customers.update', $customer->id_customer) }}"
                        method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="id_customer">Customer ID</label>
                            <input type="text" class="form-control" id="id_customer" name="id_customer"
                                placeholder="Customer ID" readonly
                                @error('id_customer') is-invalid                              
                             @enderror
                                value="{{ old('id_customer', $customer->id_customer) }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                                @error('name') is-invalid                              
                             @enderror
                                value="{{ old('name', $customer->name) }}">
                        </div>


                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
@endforeach
