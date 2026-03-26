@foreach ($data as $mp)
    <div class="modal fade" id="edit_mp{{ $mp->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Update Market Price</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('market-price.update', $mp->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="item_id">Item ID</label>
                            <input type="text" class="form-control" id="item_id" name="item_id"
                                placeholder="Item ID" value="{{ old('item_id', $mp->item_id . " ( " . $mp->item->description . " ) ") }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" min="0" class="form-control" id="price" name="price"
                                placeholder="Price"
                                @error('price') is-invalid                              
                             @enderror
                                value="{{ old('price', $mp->price) }}">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Keterangan" rows="3"
                                @error('keterangan') is-invalid                              
                             @enderror
                                >{{ old('keterangan', $mp->keterangan) }}</textarea>
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
