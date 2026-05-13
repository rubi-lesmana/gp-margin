@foreach ($data as $market_price)
    <div class="modal fade" id="delete_market_price_{{ $market_price->id_market_price }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Delete Market Price</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample"
                        action="{{ route('market-price.destroy', $market_price->id_market_price) }}" method="POST">
                        @method('DELETE')
                        @csrf

                        <p>Are you sure want to delete Market Price for effective date
                            <b>{{ $market_price->effective_date }}</b>
                        </p>
                        <button type="submit" class="btn btn-gradient-primary me-2">Delete</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        {{-- @endif --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
@endforeach
