<div class="modal fade" id="add_doi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" action="{{ route('doi-percentage.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="min_days">From Day</label>
                        <input type="number" step="0.01" min="0" value="{{ old('min_days') }}"
                            class="form-control" id="min_days" name="min_days" placeholder="min_days"
                            @error('min_days') is-invalid                              
                             @enderror
                            value="{{ old('min_days') }}">
                    </div>
                    <div class="form-group">
                        <label for="max_days">To Day <code>Max Days (opsional, kosong = tidak terbatas)</code></label>
                        <input type="number" step="0.01" min="0" value="{{ old('max_days') }}"
                            class="form-control" id="max_days" name="max_days" placeholder="max_days"
                            @error('max_days') is-invalid                              
                             @enderror
                            value="{{ old('max_days') }}">
                    </div>
                    <div class="form-group">
                        <label for="percentage">Percentage</label>
                        <input type="number" step="0.01" value="{{ old('percentage') }}" class="form-control"
                            id="percentage" name="percentage" placeholder="percentage (%)"
                            @error('percentage') is-invalid                              
                             @enderror
                            value="{{ old('percentage') }}">
                    </div>

                    <div class="form-group">
                        <label for="label">Remarks</label>
                        <input type="text" class="form-control" id="label" name="label" placeholder="label"
                            @error('label') is-invalid                              
                                 @enderror
                            value="{{ old('label') }}">
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}
