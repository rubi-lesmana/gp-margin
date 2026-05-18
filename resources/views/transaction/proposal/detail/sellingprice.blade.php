<div class="col-12 col-md-7 mb-4">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Reference SSP</h6>
            <p class="text-muted small mb-3">
                SSP referensi untuk item <strong>{{ $proposal->item_id }}</strong> ({{ $proposal->item->description }})
                dengan selling price ID
                <strong>{{ $proposal->selling_price_id }}</strong>
            </p>

            @foreach ($sspDetails->groupBy('category_status') as $categoryStatus => $rows)
                <div class="card">
                    <div class="card-body p-3">
                        <h6 class="card-title mb-3">
                            <span class="fw-semibold small">Category:</span>
                            <span class="badge badge-outline-success badge-pill ms-1">{{ $categoryStatus }}</span>
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover dt-responsive nowrap w-100 mb-0">
                                <thead>
                                    <tr>
                                        <th>TOP <code>(Hari)</code></th>
                                        <th>GP Margin</th>
                                        <th>Target GP</th>
                                        <th>Adj GP Margin Price</th>
                                        <th>SSP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $ssp)
                                        <tr>
                                            <td data-label="TOP" class="text-wrap">{{ $ssp->top_days_snapshot }}</td>
                                            <td data-label="GP Margin" class="text-nowrap">
                                                {{ $ssp->gp_margin_pct }}
                                            </td>
                                            <td data-label="Target GP" class="text-nowrap">
                                                {{ $ssp->target_gp_pct }}
                                            </td>
                                            <td data-label="Adj GP Margin Price" class="text-nowrap">
                                                {{ number_format($ssp->adj_gp_margin_price, 2) }}
                                            </td>
                                            <td data-label="SSP" class="text-nowrap">
                                                {{ number_format($ssp->suggested_selling_price, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
