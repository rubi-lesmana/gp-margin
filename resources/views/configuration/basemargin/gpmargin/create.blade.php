<div class="modal fade" id="add_basemargin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add Base Margin</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" action="{{ route('base-margin.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="margin_percentage">Margin Percentage</label>
                        <input type="number" step="0.01" min="1" max="100"
                            value="{{ old('margin_percentage') }}" class="form-control" id="margin_percentage"
                            name="margin_percentage" placeholder="1 - 100 %"
                            @error('margin_percentage') is-invalid                              
                             @enderror
                            value="{{ old('margin_percentage') }}">
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}
