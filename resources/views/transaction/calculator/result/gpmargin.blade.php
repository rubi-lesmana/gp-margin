{{-- GP Margin --}}
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
{{-- End GP Margin --}}
