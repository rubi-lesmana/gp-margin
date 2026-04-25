{{-- Detail Information --}}
<div class="col-md-5 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detail Information</h4>

            @if (isset($status))
                <form action="{{ route('calculator.store') }}" method="POST">
                    @csrf
                    {{-- Hidden fields — kirim ulang data dari GET ke POST --}}
                    <input type="hidden" name="item_id" value="{{ $itemId }}">
                    <input type="hidden" name="quantity" value="{{ $quantity }}">
                    <input type="hidden" name="cost_price" value="{{ $costPrice }}">
                    <input type="hidden" name="top" value="{{ $top }}">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="hidden" name="gpmargin" value="{{ $calculation }}">
                    <input type="hidden" name="tgp_value" value="{{ $tgpValue }}">
                    <input type="hidden" name="tgp_margin" value="{{ $tgpMargin }}">

                    <table class="table">
                        <tr>
                            <td>Item ID</td>
                            <td>{{ $itemId }}</td>
                        </tr>
                        <tr>
                            <td>Quantity</td>
                            <td>{{ $quantity }} KG</td>
                        </tr>
                        <tr>
                            <td>Cost Price</td>
                            <td>{{ number_format($costPrice, 2) }}</td>
                        </tr>
                        <tr>
                            <td>TOP</td>
                            <td>{{ $top }} days</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><span class="badge bg-primary">{{ $status }}</span></td>
                        </tr>
                        @include('transaction.calculator.result.gpmargin')
                        @include('transaction.calculator.result.tgpmargin')
                        @include('transaction.calculator.result.tgpdoi')

                    </table>
                    <button type="submit" class="btn btn-gradient-primary mt-3">Save</button>
                </form>
            @else
                <p class="card-description">The calculation results will be displayed here.
                </p>
            @endif
        </div>
    </div>
</div>
