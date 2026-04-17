@foreach ($data as $basemargin)
    <div class="modal fade" id="edit_item{{ $basemargin->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update Base Margin</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('base-margin.update', $basemargin->id) }}"
                        method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="margin_percentage">Margin Percentage</label>
                            <input type="number" step="0.01" min="1" max="100" class="form-control"
                                id="margin_percentage" name="margin_percentage" placeholder="Margin Percentage"
                                @error('margin_percentage') is-invalid                              
                             @enderror
                                value="{{ old('margin_percentage', $basemargin->margin_percentage_formated) }}">
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
