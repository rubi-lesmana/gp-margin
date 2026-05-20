@foreach ($data as $row)
    <div class="modal fade" id="edit_item_history{{ $row->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update Item History</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('item-history.update', $row->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="date_report">Date</label>
                            <input type="date" class="form-control" id="date_report" name="date_report"
                                @error('date_report') is-invalid                              
                             @enderror
                                value="{{ old('date_report', $row->date_report) }}">
                        </div>
                        <div class="form-group">
                            <label for="item_id">Item ID</label>
                            <input type="text" class="form-control" id="item_id" name="item_id"
                                placeholder="Item ID" readonly
                                @error('item_id') is-invalid                              
                             @enderror
                                value="{{ old('item_id', $row->item_id) }}">
                        </div>
                        <div class="form-group">
                            <label for="ending_stock">Ending Stock</label>
                            <input type="number" class="form-control" id="ending_stock" name="ending_stock"
                                placeholder="Ending Stock"
                                @error('ending_stock') is-invalid                              
                             @enderror
                                value="{{ old('ending_stock', $row->ending_stock) }}">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Keterangan"
                                @error('keterangan') is-invalid                              
                             @enderror
                                value="{{ old('keterangan', $row->keterangan) }}">
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
