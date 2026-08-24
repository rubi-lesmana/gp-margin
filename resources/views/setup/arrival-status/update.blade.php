@foreach ($data as $status)
    <div class="modal fade" id="edit_status{{ $status->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update Arrival Status</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('arrival-statuses.update', $status->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="code">Status <code>*</code></label>
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Code" readonly
                                @error('code') is-invalid                              
                             @enderror
                                value="{{ old('code', $status->code) }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description <code>*</code></label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Description"
                                @error('description') is-invalid                              
                             @enderror
                                value="{{ old('description', $status->description) }}">
                        </div>
                        <div class="form-group">
                            <label for="default_currency_id">Default Currency</label>
                            <select class="form-select form-select-lg" id="default_currency_id" name="default_currency_id">
                                <option value="" {{ is_null(old('default_currency_id', $status->default_currency_id)) ? 'selected' : '' }}>
                                    Select Currency
                                </option>
                                @foreach($currencies as $id => $description)
                                    <option value="{{ $id }}" 
                                        {{ old('default_currency_id', $status->default_currency_id) == $id ? 'selected' : '' }}>
                                        {{ $id }}
                                    </option>
                                @endforeach
                            </select>
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
