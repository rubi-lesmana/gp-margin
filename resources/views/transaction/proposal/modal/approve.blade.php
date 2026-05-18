{{-- Modal Approve --}}
@if (auth()->user()->role === 'admin' && $proposal->status === 'pending_approval')
    <div class="modal fade" id="modalApprove" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('proposal.approve', $proposal->id_proposal) }}">
                    @csrf
                    <div class="modal-body">
                        <p>Pengajuan: <strong>{{ $proposal->id_proposal }}</strong></p>
                        <div class="mb-3">
                            <span>Are you sure you want to approve this proposal?</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="icon-check me-1"></i> Approve Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
