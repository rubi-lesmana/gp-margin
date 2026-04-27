@foreach ($data as $category)
    <div class="modal fade" id="edit_category{{ $category->status }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update Category</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('category.update', $category->status) }}"
                        method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" id="status" name="status"
                                placeholder="status"
                                @error('status') is-invalid                              
                             @enderror
                                value="{{ old('status', $category->status) }}">
                        </div>
                        <div class="form-group">
                            <label for="min_quantity">Min Quantity</label>
                            <input type="number" step="0.01" class="form-control" id="min_quantity"
                                name="min_quantity" placeholder="Min Quantity"
                                @error('min_quantity') is-invalid                              
                             @enderror
                                value="{{ old('min_quantity', $category->min_quantity) }}">
                        </div>
                        <div class="form-group">
                            <label for="max_quantity">Max Quantity<code>(opsional, kosong = tidak
                                    terbatas)</code></label>
                            <input type="number" step="0.01" class="form-control" id="max_quantity"
                                name="max_quantity" placeholder="Max Quantity"
                                @error('max_quantity') is-invalid                              
                             @enderror
                                value="{{ old('max_quantity', $category->max_quantity) }}">
                        </div>
                        <div class="form-group">
                            <label for="calculation">Calculation</label>
                            <input type="number" step="0.01" class="form-control" id="calculation"
                                name="calculation" placeholder="Margin Percentage"
                                @error('calculation') is-invalid                              
                             @enderror
                                value="{{ old('calculation', $category->calculation_formated) }}">
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
