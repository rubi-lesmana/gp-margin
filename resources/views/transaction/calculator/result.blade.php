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
                        <tr data-bs-toggle="collapse" data-bs-target="#detailCalculation" style="cursor: pointer;">
                            <td>GP Margin</td>
                            <td>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>
                                        {{ number_format($gpmargin['final_margin'], 2) }}%
                                    </span>
                                    <i class="mdi mdi-chevron-down"></i>
                                </div>
                            </td>
                        </tr>
                        {{-- Detail Calculation --}}
                        <tr>
                            <td colspan="2" class="p-0">
                                <div id="detailCalculation" class="collapse">
                                    <div class="p-3 bg-light border-top">
                                        <div class="d-flex align-items-center">
                                            <span>Rumus </span>
                                            <code class="text-dark">
                                                = {{ number_format($gpmargin['margin_percentage']) }}% ×
                                                {{ number_format($calculation) }}%
                                            </code>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
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
