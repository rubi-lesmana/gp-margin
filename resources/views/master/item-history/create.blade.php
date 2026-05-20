<div class="modal fade" id="add_item_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add Item History</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" action="{{ route('item-history.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="date_report">Date</label>
                        <input type="date" class="form-control" id="date_report" name="date_report"
                            @error('date_report') is-invalid                              
                                 @enderror
                            value="{{ old('date_report') }}">
                    </div>
                    <div class="form-group">
                        <label for="item_id">Item ID</label>
                        <select name="item_id" class="form-select @error('item_id') is-invalid @enderror">
                            <option value="">-- Pilih Item --</option>
                            @foreach ($items as $key => $name)
                                <option value="{{ $key }}" {{ old('item_id') == $key ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('item_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ending_stock">Stock</label>
                        <input type="number" class="form-control" id="ending_stock" name="ending_stock"
                            placeholder="ending_Stock"
                            @error('ending_stock') is-invalid                              
                                 @enderror
                            value="{{ old('ending_stock') }}">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan"
                            placeholder="Keterangan"
                            @error('keterangan') is-invalid                              
                                 @enderror
                            value="{{ old('keterangan') }}">
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}
