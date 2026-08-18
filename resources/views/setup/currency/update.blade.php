@foreach ($data as $currency)
    <div class="modal fade" id="edit_currency{{ $currency->id_currency }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update Currency</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('currencies.update', $currency->id_currency) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="id_currency">Currency ID</label>
                            <input type="text" class="form-control" id="id_currency" name="id_currency"
                                placeholder="Currency ID" readonly
                                @error('id_currency') is-invalid                              
                             @enderror
                                value="{{ old('id_currency', $currency->id_currency) }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Description"
                                @error('description') is-invalid                              
                             @enderror
                                value="{{ old('description', $currency->description) }}">
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
