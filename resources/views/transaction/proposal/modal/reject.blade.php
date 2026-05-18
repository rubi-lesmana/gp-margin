{{-- Modal Reject --}}
@if (auth()->user()->role === 'admin' && $proposal->status === 'pending_approval')
    <div class="modal fade" id="modalReject" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('proposal.reject', $proposal->id_proposal) }}">
                    @csrf
                    <div class="modal-body">
                        <p>Pengajuan: <strong>{{ $proposal->id_proposal }}</strong></p>
                        <div class="mb-3">
                            <label class="form-label">
                                Alasan Reject <span class="text-danger">*</span>
                            </label>
                            <textarea name="rejection_note" class="form-control @error('rejection_note') is-invalid @enderror" rows="3"
                                placeholder="Jelaskan alasan penolakan (min 10 karakter)..."></textarea>
                            @error('rejection_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="icon-close me-1"></i> Reject Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
