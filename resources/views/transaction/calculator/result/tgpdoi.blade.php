{{-- Target GP Margin After DOI --}}
<tr data-bs-toggle="collapse" data-bs-target="#detailTgpMarginDoi" style="cursor: pointer;">
    <td>Target GP After DOI</td>
    <td>
        <div class="d-flex justify-content-between align-items-center">
            <span>
                {{ number_format($finalTgpMargin, 2) }}%
            </span>
            <i class="mdi mdi-chevron-down"></i>
        </div>
    </td>
</tr>
{{-- Detail Calculation --}}
<tr>
    <td colspan="2" class="p-0">
        <div id="detailTgpMarginDoi" class="collapse">
            <div class="p-3 bg-light border-top">
                <div class="row text-muted small">
                    <div class="col-6">
                        <span>DOI</span>
                        <strong class="d-block">{{ $doi['days'] }} Hari ({{ $doi['label'] }})</strong>
                    </div>
                    <div class="col-6">
                        <span>Potongan DOI</span>
                        <strong class="d-block text-danger">
                            {{ $doiDeduction > 0 ? '- ' . number_format($doiDeduction, 2) . '%' : '0%' }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
{{-- End Target GP Margin After DOI --}}
