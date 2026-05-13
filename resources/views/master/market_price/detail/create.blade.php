<div class="col-md-6" id="detail-section" style="display: none;">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Market Price Detail</h4>
                <button type="button" class="btn-close" id="btn-close-detail" title="Close"></button>
            </div>

            <p class="text-muted">
                ID: <strong id="detail-id">-</strong>
            </p>

            {{-- ======= FORM CREATE (jika belum ada detail) ======= --}}
            <div id="form-create">
                <form action="{{ route('market-price-detail.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_market_price" id="form-id-create">

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="40">No</th>
                                    <th>Description</th>
                                    <th width="180">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <input type="hidden" name="details[{{ $index }}][item_id]"
                                                value="{{ $item->item_id }}">
                                            {{ $item->description }}
                                        </td>
                                        <td>
                                            {{-- Hidden input untuk nilai asli (tanpa titik) --}}
                                            <input type="hidden" name="details[{{ $index }}][price]"
                                                class="raw-price">

                                            {{-- Input tampilan (dengan format titik) --}}
                                            <input type="text" class="form-control form-control-sm price-display"
                                                placeholder="0" autocomplete="off">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save me-1"></i> Save
                        </button>
                    </div>
                </form>
            </div>

            {{-- ======= FORM EDIT (jika sudah ada detail) ======= --}}
            <div id="form-edit" style="display: none;">
                <form action="" method="POST" id="form-edit-action"> {{-- action diisi JS --}}
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_market_price" id="form-id-edit">

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="40">No</th>
                                    <th>Description</th>
                                    <th width="150">Price</th>
                                </tr>
                            </thead>
                            <tbody id="edit-tbody">
                                {{-- Diisi oleh JavaScript --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-warning">
                            <i class="mdi mdi-content-save me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
