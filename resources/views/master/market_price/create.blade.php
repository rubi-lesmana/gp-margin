<div class="modal fade" id="add_market_price" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add Market Price</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" action="{{ route('market-price.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="effective_date">Effective Date</label>
                        <input type="date" class="form-control" id="effective_date" name="effective_date"
                            @error('effective_date') is-invalid                              
                                 @enderror
                            value="{{ old('effective_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" value="{{ old('keterangan') }}" class="form-control" id="keterangan"
                            name="keterangan" placeholder="Keterangan"
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
