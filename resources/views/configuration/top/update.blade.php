@foreach ($data as $top)
    <div class="modal fade" id="edit_top{{ $top->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update Term of Payment</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('term-of-payment.update', $top->id) }}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="days">Days</label>
                            <input type="number" step="0.01" class="form-control" id="days" name="days"
                                placeholder="Days"
                                @error('days') is-invalid                              
                             @enderror
                                value="{{ old('days', $top->days) }}">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Description"
                                @error('description') is-invalid                              
                             @enderror
                                value="{{ old('description', $top->description) }}">
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
