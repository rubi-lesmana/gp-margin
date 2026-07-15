<div class="table-responsive" style="max-height:260px;overflow-y:auto">
    <table class="table table-hover mb-0" style="font-size:12px">
        <thead style="position:sticky;top:0;z-index:1">
            <tr>
                <th>TOP (Hari)</th>
                <th>Selling Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $ssp)
                <tr>
                    <td data-label="TOP (Hari)">{{ $ssp->top_days_snapshot }}</td>
                    <td class="fw-semibold" data-label="Selling Price">
                        {{ number_format($ssp->suggested_selling_price, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
