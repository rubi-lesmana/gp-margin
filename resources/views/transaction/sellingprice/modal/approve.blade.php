{{-- ── MODAL KONFIRMASI APPROVE ────────────────────────────────── --}}
<div class="modal fade" id="modalApprove" tabindex="-1" aria-labelledby="modalApproveLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalApproveLabel">
                    Konfirmasi Approve SSP
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan approve Suggested Selling Price untuk:</p>
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th style="width:40%">Item</th>
                        <td>{{ $header->item_id }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $header->description }}</td>
                    </tr>
                    <tr>
                        <th>Cost Price</th>
                        <td>{{ number_format($header->cost_price_snapshot, 2) }}</td>
                    </tr>
                    <tr>
                        <th>SSP Max</th>
                        <td>
                            <strong class="text-success">
                                {{ number_format($sspMax, 2) }}
                            </strong>
                        </td>
                    </tr>
                </table>
                <div class="alert alert-warning mt-3 mb-0 py-2">
                    <i class="mdi mdi-alert-outline me-1"></i>
                    Tindakan ini tidak dapat dibatalkan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <form method="POST"
                    action="{{ route('selling-price.approve', [
                        'itemId' => $header->item_id,
                        'costPriceId' => $header->id_cost_price,
                    ]) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="icon-check me-1"></i> Ya, Approve
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
