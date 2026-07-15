<div class="card">
    <div class="card-body">
        {{-- <h6 class="card-title">
            Detail Proposal
        </h6> --}}
        <span class="badge {{ $proposal->status_badge }} ms-1">
            {{ $proposal->status_label }}
        </span>

        <div class="p-3">
            <div class="mb-3">
                <label class="form-label text-muted small mb-1">ID Proposal</label>
                <div class="text-dark small">{{ $proposal->id_proposal }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted small mb-1">Customer</label>
                <div class="text-dark small">{{ $proposal->customer->name }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted small mb-1">TOP</label>
                <div class="text-dark small">
                    {{ $proposal->term_of_payment->description }}
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted small mb-1">Submitted By</label>
                <div class="text-dark small">{{ $proposal->submittedBy->name }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted small mb-1">Submitted At</label>
                <div class="text-dark small">{{ $proposal->submitted_at->format('d M Y H:i') }}</div>
            </div>

            @if ($proposal->reviewed_at)
                <div class="my-4">
                    <hr class="text-muted">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Reviewed By</label>
                    <div class="text-dark small">{{ $proposal->reviewedBy->name }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Reviewed At</label>
                    <div class="text-dark small">{{ $proposal->reviewed_at->format('d M Y H:i') }}</div>
                </div>

                @if ($proposal->rejection_note)
                    <div class="mb-3">
                        <label class="form-label text-danger small mb-1">Catatan Reject</label>
                        <div class="text-danger">
                            {{ $proposal->rejection_note }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
        {{-- Action untuk manager jika pending --}}
        @if (auth()->user()->role === 'admin' && $proposal->status === 'pending_approval')
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modalApprove">Approve
                    {{-- <i class="icon-check me-1"></i>  --}}
                </button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modalReject">Reject
                    {{-- <i class="icon-close me-1"></i>  --}}
                </button>
            </div>
        @endif

        <div class="mt-3">
            <a href="{{ route('proposal.index') }}" class="btn btn-outline-secondary btn-sm">
                Back
            </a>
        </div>
    </div>
</div>
