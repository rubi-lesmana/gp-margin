@foreach ($data as $doi)
    <div class="modal fade" id="edit_doi{{ $doi->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update DOI Percentage</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('doi-percentage.update', $doi->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="min_days">Min Days</label>
                            <input type="number" class="form-control" id="min_days" name="min_days"
                                placeholder="Min Days" value="{{ old('min_days', $doi->min_days) }}">
                        </div>
                        <div class="form-group">
                            <label for="max_days">Max Days</label>
                            <input type="number" class="form-control" id="max_days" name="max_days"
                                placeholder="Max Days" value="{{ old('max_days', $doi->max_days) }}">
                        </div>
                        <div class="form-group">
                            <label for="percentage">Percentage</label>
                            <input type="number" class="form-control" id="percentage" name="percentage"
                                placeholder="Percentage" value="{{ old('percentage', $doi->percentage) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="label">Remarks</label>
                            <input type="text" class="form-control" id="label" name="label"
                                placeholder="Remarks" value="{{ old('label', $doi->label) }}" required>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    {{-- End Modal --}}
@endforeach
