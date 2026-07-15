<div class="card">
    <div class="card-body">

        <h6 class="card-title">Detail</h6>

        {{-- <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Qty (KG)</th>
                        <th>Proposed Price</th>
                        <th>Difference</th>
                        <th>SSP Min</th>
                        <th>SSP Max</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposal->sales_proposal_details as $detail)
                        <tr>
                            <td data-label="Item" class="text-wrap">{{ $detail->item->description }}</td>
                            <td data-label="Qty (KG)">{{ number_format($detail->qty, 2) }}</td>
                            <td data-label="Proposed Price">
                                <strong class="{{ $detail->is_below_ssp ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($detail->proposed_price, 2) }}
                                </strong>
                            </td>
                            <td data-label="Difference">
                                <span class="{{ $detail->price_diff >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $detail->price_diff >= 0 ? '+' : '' }}{{ number_format($detail->price_diff, 2) }}<br>
                                    <small>
                                        {{ $detail->price_diff >= 0 ? '+' : '' }}{{ number_format($detail->price_diff_pct, 2) }}%
                                    </small>
                                </span>
                            </td>
                            <td data-label="SSP Min">{{ number_format($detail->ssp_min_snapshot, 2) }}</td>
                            <td data-label="SSP Max">{{ number_format($detail->ssp_max_snapshot, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Qty (KG)</th>
                        <th>Proposed Price</th>
                        <th>Difference</th>
                        <th>SSP Min</th>
                        <th>SSP Max</th>
                        <th style="width:40px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposal->sales_proposal_details as $detail)
                        @php
                            $idx = $loop->index;
                            $categories = $sspDetails->get($detail->selling_price_id); // Collection grouped by category
                        @endphp

                        {{-- ── Baris Summary ────────────────────────────────────── --}}
                        <tr class="item-summary-row" style="cursor:pointer"
                            onclick="toggleDetailRow({{ $idx }}, this)">
                            <td data-label="Item" class="text-wrap">
                                {{ $detail->item->description }}
                                <br><small class="text-muted">{{ $detail->item_id }}</small>
                            </td>
                            <td data-label="Qty (KG)">
                                {{ number_format($detail->qty, 2) }}
                            </td>
                            <td data-label="Proposed Price">
                                <strong class="{{ $detail->is_below_ssp ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($detail->proposed_price, 2) }}
                                </strong>
                            </td>
                            <td data-label="Difference">
                                <span class="{{ $detail->price_diff >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $detail->price_diff >= 0 ? '+' : '' }}{{ number_format($detail->price_diff, 2) }}<br>
                                    <small>
                                        {{ $detail->price_diff >= 0 ? '+' : '' }}{{ number_format($detail->price_diff_pct, 2) }}%
                                    </small>
                                </span>
                            </td>
                            <td data-label="SSP Min">
                                {{ number_format($detail->ssp_min_snapshot, 2) }}
                            </td>
                            <td data-label="SSP Max">
                                {{ number_format($detail->ssp_max_snapshot, 2) }}
                            </td>
                            <td class="text-center">
                                <i id="chevron-{{ $idx }}" class="mdi mdi-chevron-down"
                                    style="transition:transform .2s;font-size:16px;color:var(--bs-secondary)">
                                </i>
                            </td>
                        </tr>

                        {{-- ── Baris Detail (tersembunyi) ───────────────────────── --}}
                        <tr id="detail-row-{{ $idx }}" style="display:none">
                            <td colspan="7" class="p-0">
                                <div class="card mb-0">
                                    <div class="card-body">

                                        {{-- Meta info --}}
                                        <div class="d-flex gap-4 mb-3 flex-wrap">
                                            <div>
                                                <div class="text-muted small mb-1">Price Position</div>
                                                @php
                                                    $positionBadge = match ($detail->price_position) {
                                                        'above_max' => 'bg-success',
                                                        'at_max' => 'bg-info',
                                                        'between' => 'bg-warning text-dark',
                                                        'below_min' => 'bg-danger',
                                                        default => 'bg-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $positionBadge }}">
                                                    {{ str_replace('_', ' ', $detail->price_position) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-muted small mb-1">Selling Price ID</div>
                                                <div class="fw-semibold">{{ $detail->selling_price_id }}</div>
                                            </div>
                                        </div>

                                        {{-- SSP Reference --}}
                                        @if ($categories && $categories->isNotEmpty())
                                            @if ($categories->count() > 1)
                                                {{-- ── Tabs lebih dari 1 kategori ─────────────────── --}}
                                                <ul class="nav nav-tabs" role="tablist">
                                                    @foreach ($categories as $categoryStatus => $rows)
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                                id="tab-{{ $idx }}-{{ $loop->index }}-tab"
                                                                data-bs-toggle="tab"
                                                                href="#tab-{{ $idx }}-{{ $loop->index }}"
                                                                role="tab"
                                                                aria-controls="tab-{{ $idx }}-{{ $loop->index }}"
                                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                                {{ $categoryStatus }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="tab-content">
                                                    @foreach ($categories as $categoryStatus => $rows)
                                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                            id="tab-{{ $idx }}-{{ $loop->index }}"
                                                            role="tabpanel"
                                                            aria-labelledby="tab-{{ $idx }}-{{ $loop->index }}-tab">
                                                            @include('transaction.proposal.show.ssp', [
                                                                'rows' => $rows,
                                                                'detail' => $detail,
                                                            ])
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                {{-- ── Langsung tabel jika 1 kategori ────────────── --}}
                                                @foreach ($categories as $categoryStatus => $rows)
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <span class="text-muted small">Category</span>
                                                        <span class="badge badge-outline-success badge-pill">
                                                            {{ $categoryStatus }}
                                                        </span>
                                                    </div>
                                                    @include('transaction.proposal.show.ssp', [
                                                        'rows' => $rows,
                                                        'detail' => $detail,
                                                    ])
                                                @endforeach
                                            @endif
                                        @else
                                            <div class="alert alert-warning py-2 px-3 mb-0" style="font-size:13px">
                                                Data SSP tidak tersedia untuk
                                                <strong>{{ $detail->selling_price_id }}</strong>.
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @push('scripts')
            <script>
                function toggleDetailRow(idx, summaryRow) {
                    const detailRow = document.getElementById('detail-row-' + idx);
                    const chevron = document.getElementById('chevron-' + idx);
                    const isOpen = detailRow.style.display !== 'none';

                    detailRow.style.display = isOpen ? 'none' : 'table-row';
                    summaryRow.style.background = isOpen ? '' : 'var(--bs-primary-bg-subtle)';

                    if (chevron) {
                        chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
                    }
                }
            </script>
        @endpush
    </div>
</div>
