{{-- Recent Activity Table --}}
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0">Recent Activity</h6>
                    <a href="{{ route('proposal.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Item(s)</th>
                                <th class="text-end">Proposed Price</th>
                                <th class="text-end">Difference</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentProposals as $p)
                                <tr>
                                    <td data-label="ID">
                                        <small>{{ $p->id_proposal }}</small>
                                    </td>
                                    <td data-label="Customer">
                                        <small>{{ $p->customer->name }}</small>
                                    </td>

                                    {{-- Satu proposal bisa punya banyak item --}}
                                    <td data-label="Item(s)">
                                        @foreach ($p->sales_proposal_details as $detail)
                                            <div>
                                                <small class="text-wrap">
                                                    {{ $detail->item->description ?? $detail->item_id }}
                                                </small>
                                                <small class="text-muted ms-1">
                                                    {{ number_format($detail->qty, 2) }} KG
                                                </small>
                                            </div>
                                        @endforeach
                                    </td>

                                    {{-- Proposed price: sum dari semua detail --}}
                                    <td data-label="Proposed Price" class="text-end text-nowrap">
                                        @foreach ($p->sales_proposal_details as $detail)
                                            <div>
                                                <small
                                                    class="{{ $detail->is_below_ssp ? 'text-danger' : 'text-success' }}">
                                                    {{ number_format($detail->proposed_price, 2) }}
                                                </small>
                                            </div>
                                        @endforeach
                                    </td>

                                    {{-- Difference per item --}}
                                    <td data-label="Difference" class="text-end text-nowrap">
                                        @foreach ($p->sales_proposal_details as $detail)
                                            <div>
                                                <small
                                                    class="{{ $detail->price_diff >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $detail->price_diff >= 0 ? '+' : '' }}{{ number_format($detail->price_diff, 2) }}
                                                </small>
                                            </div>
                                        @endforeach
                                    </td>

                                    <td data-label="Status" class="text-nowrap">
                                        <span class="badge {{ $p->status_badge }}" style="font-size:10px">
                                            {{ $p->status_label }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        Belum ada pengajuan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
