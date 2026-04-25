{{-- Target GP Margin --}}
<tr data-bs-toggle="collapse" data-bs-target="#detailTgpMargin" style="cursor: pointer;">
    <td>Target GP</td>
    <td>
        <div class="d-flex justify-content-between align-items-center">
            <span>
                {{ number_format($tgpMargin, 2) }}%
            </span>
            <i class="mdi mdi-chevron-down"></i>
        </div>
    </td>
</tr>
{{-- Detail Calculation --}}
<tr>
    <td colspan="2" class="p-0">
        <div id="detailTgpMargin" class="collapse">
            <div class="p-3 bg-light border-top">
                <div class="d-flex align-items-center">
                    <span>Rumus </span>
                    <code class="text-dark">
                        = ({{ $top }} / 365 ×
                        {{ number_format($tgpValue, 2) }}% ) +
                        {{ number_format($gpmargin['final_margin'], 2) }}%
                    </code>
                </div>
            </div>
        </div>
    </td>
</tr>
{{-- End Target GP Margin --}}
