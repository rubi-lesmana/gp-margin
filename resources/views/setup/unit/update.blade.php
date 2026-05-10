@foreach ($data as $unit)
    <div class="modal fade" id="edit_unit{{ $unit->unit_id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update Unit</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('units.update', $unit->unit_id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="unit-id">Unit ID</label>
                            <input type="text" class="form-control" id="unit-id" name="unit_id"
                                placeholder="Unit ID" readonly
                                @error('unit_id') is-invalid                              
                             @enderror
                                value="{{ old('unit_id', $unit->unit_id) }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Description"
                                @error('description') is-invalid                              
                             @enderror
                                value="{{ old('description', $unit->description) }}">
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
