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
                                <th>Item</th>
                                <th class="text-end">SSP Min</th>
                                <th class="text-end">SSP Max</th>
                                <th class="text-end">Proposed Price</th>
                                <th class="text-end">Difference</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProposals as $p)
                                <tr>
                                    <td data-label="ID"><small>{{ $p->id_proposal }}</small></td>
                                    <td data-label="Customer"><small>{{ $p->customer->name }}</small></td>
                                    <td data-label="Item"><small class="text-wrap">{{ $p->item->description }}</small>
                                    </td>
                                    <td data-label="SSP Min" class="text-end text-nowrap">
                                        <small>{{ number_format($p->ssp_min_snapshot, 2) }}</small>
                                    </td>
                                    <td data-label="SSP Max" class="text-end text-nowrap">
                                        <small>{{ number_format($p->ssp_max_snapshot, 2) }}</small>
                                    </td>
                                    <td data-label="Proposed Price" class="text-end text-nowrap">
                                        <small class="{{ $p->is_below_ssp ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($p->proposed_price, 2) }}
                                        </small>
                                    </td>
                                    <td data-label="Difference" class="text-end text-nowrap">
                                        <small class="{{ $p->price_diff >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $p->price_diff >= 0 ? '+' : '' }}{{ number_format($p->price_diff, 2) }}
                                        </small>
                                    </td>
                                    <td data-label="Status" class="text-center text-nowrap">
                                        <span class="badge {{ $p->status_badge }}" style="font-size:10px">
                                            {{ $p->status_label }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-3">
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
