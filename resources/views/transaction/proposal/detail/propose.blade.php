<div class="col-12 col-md-5 mb-4">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">
                Detail Pengajuan
                <span class="badge {{ $proposal->status_badge }} ms-1">
                    {{ $proposal->status_label }}
                </span>
            </h6>

            <div class="table-detail-responsive">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th>ID Pengajuan</th>
                        <td>{{ $proposal->id_proposal }}</td>
                    </tr>
                    <tr>
                        <th>Customer</th>
                        <td>{{ $proposal->customer->name }}</td>
                    </tr>
                    <tr>
                        <th>Item</th>
                        <td>
                            {{ $proposal->item_id }}<br>
                            <small class="text-muted">{{ $proposal->item->description }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>SSP Min</th>
                        <td>{{ number_format($proposal->ssp_min_snapshot, 2) }}</td>
                    </tr>
                    <tr>
                        <th>SSP Max</th>
                        <td>{{ number_format($proposal->ssp_max_snapshot, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Harga Pengajuan</th>
                        <td>
                            <strong class="{{ $proposal->is_below_ssp ? 'text-danger' : 'text-success' }}">
                                {{ number_format($proposal->proposed_price, 2) }}
                            </strong>
                            @if ($proposal->is_below_ssp)
                                <span class="badge bg-danger ms-1">Di bawah SSP</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Selisih vs SSP</th>
                        <td class="{{ $proposal->price_diff >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $proposal->price_diff >= 0 ? '+' : '' }}{{ number_format($proposal->price_diff, 2) }}
                            ({{ $proposal->price_diff >= 0 ? '+' : '' }}{{ number_format($proposal->price_diff_pct, 2) }}%)
                        </td>
                    </tr>
                    <tr>
                        <th>Submitted By</th>
                        <td>{{ $proposal->submittedBy->name }}</td>
                    </tr>
                    <tr>
                        <th>Submitted At</th>
                        <td>{{ $proposal->submitted_at->format('d M Y H:i') }}</td>
                    </tr>

                    @if ($proposal->reviewed_at)
                        <tr>
                            <td colspan="2">
                                <hr class="my-1">
                            </td>
                        </tr>
                        <tr>
                            <th>Reviewed By</th>
                            <td>{{ $proposal->reviewedBy->name }}</td>
                        </tr>
                        <tr>
                            <th>Reviewed At</th>
                            <td>{{ $proposal->reviewed_at->format('d M Y H:i') }}</td>
                        </tr>
                        @if ($proposal->rejection_note)
                            <tr>
                                <th>Catatan Reject</th>
                                <td class="text-danger">{{ $proposal->rejection_note }}</td>
                            </tr>
                        @endif
                    @endif
                </table>
            </div>

            {{-- Action untuk manager jika pending --}}
            @if (auth()->user()->role === 'admin' && $proposal->status === 'pending_approval')
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalApprove">
                        <i class="icon-check me-1"></i> Approve
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalReject">
                        <i class="icon-close me-1"></i> Reject
                    </button>
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('proposal.index') }}" class="btn btn-outline-secondary btn-sm">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
