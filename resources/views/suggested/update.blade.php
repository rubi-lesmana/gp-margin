@foreach ($data as $arrival)
    <div class="modal fade" id="edit_arrival{{ $arrival->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update Inventory Arrival</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('arrival-inventory.update', $arrival->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="item_id">Item ID</label>
                            <input type="text" class="form-control" id="item_id" name="item_id"
                                placeholder="Item ID" value="{{ old('item_id', $arrival->item_id . " ( " . $arrival->item->description . " ) ") }}" disabled>
                        </div>
                        {{-- Row 2 --}}
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Local" @selected(old('status', $arrival->status) == 'Local')>Local</option>
                                        <option value="Import" @selected(old('status', $arrival->status) == 'Import')>Import</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" min="0" class="form-control" id="quantity" name="quantity"
                                        placeholder="Quantity"
                                        @error('quantity') is-invalid                              
                                     @enderror
                                        value="{{ old('quantity', $arrival->quantity) }}">
                                </div>
                            </div>
                        </div>
                        {{-- Row 3 --}}
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="date">Date Arrival</label>
                                    <input type="date" min="0" class="form-control" id="date" name="date"
                                        placeholder="Date"
                                        @error('date') is-invalid                              
                                     @enderror
                                        value="{{ old('date', $arrival->date) }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea type="text" class="form-control" id="keterangan" name="keterangan"
                                        placeholder="Keterangan" rows="3"
                                        @error('keterangan') is-invalid                              
                                     @enderror
                                        >{{ old('keterangan', $arrival->keterangan) }}</textarea>
                                </div>
                            </div>
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
