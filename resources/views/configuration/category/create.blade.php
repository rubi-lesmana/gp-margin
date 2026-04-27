<div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="status">Status Name</label>
                        <input type="text" class="form-control" id="status" name="status" placeholder="Status"
                            @error('status') is-invalid                              
                                 @enderror
                            value="{{ old('status') }}">
                    </div>
                    <div class="form-group">
                        <label for="min_quantity">Min Quantity</label>
                        <input type="number" step="0.01" min="0" value="{{ old('min_quantity') }}"
                            class="form-control" id="min_quantity" name="min_quantity" placeholder="Min Quantity"
                            @error('min_quantity') is-invalid                              
                             @enderror
                            value="{{ old('min_quantity') }}">
                    </div>
                    <div class="form-group">
                        <label for="max_quantity">Max Quantity<code>(opsional, kosong = tidak terbatas)</code></label>
                        <input type="number" step="0.01" min="0" value="{{ old('max_quantity') }}"
                            class="form-control" id="max_quantity" name="max_quantity" placeholder="Max Quantity"
                            @error('max_quantity') is-invalid                              
                             @enderror
                            value="{{ old('max_quantity') }}">
                    </div>

                    <div class="form-group">
                        <label for="calculation">Calculation</label>
                        <input type="number" step="0.01" value="{{ old('calculation') }}" class="form-control"
                            id="calculation" name="calculation" placeholder="Calculation (%)"
                            @error('calculation') is-invalid                              
                             @enderror
                            value="{{ old('calculation') }}">
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}
