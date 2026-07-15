@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-paper-plane"></i>
                </span> Price Proposal
            </h3>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('proposal.store') }}" id="proposalForm">
            @csrf

            <div class="row g-3">
                <div class="col-md-8 d-flex flex-column gap-3">

                    {{-- Card 1 : Proposal Info --}}
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Proposal Info</h6>
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3 mb-md-0">
                                    <label class="form-label">
                                        Customer <span class="text-danger">*</span>
                                    </label>
                                    <select name="customer_id"
                                        class="form-select fs-6 @error('customer_id') is-invalid @enderror">
                                        <option value="">-- Select Customer --</option>
                                        @foreach ($customers as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ old('customer_id') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">
                                        Term of Payment <span class="text-danger">*</span>
                                    </label>
                                    <select name="top_id" class="form-select @error('top_id') is-invalid @enderror">
                                        <option value="">-- Select TOP --</option>
                                        @foreach ($tops as $id => $days)
                                            <option value="{{ $id }}"
                                                {{ old('top_id') == $id ? 'selected' : '' }}>
                                                {{ $days }} hari
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('top_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2 : Item Detail --}}
                    <div class="card">
                        <div class="card-body">
                            @include('transaction.proposal.create.detail')
                        </div>
                    </div>

                </div>


                {{-- ── COL 3 : Informasi Selling Price ─────────────────────────── --}}
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Selling Price Reference</h6>

                            {{-- Placeholder saat belum ada item dipilih --}}
                            <div id="sspPlaceholder" class="text-center text-muted py-4">
                                <i class="ti ti-info-circle mb-2" style="font-size:2rem"></i>
                                <p style="font-size:13px">
                                    Select an item from the table to view suggested selling price references.
                                </p>
                            </div>

                            {{-- Panel SSP per item — muncul dinamis --}}
                            <div id="sspPanels" class="d-flex flex-column gap-3"></div>
                        </div>
                    </div>
                </div>

            </div>{{-- end .row --}}
        </form>
    </div>

    @push('scripts')
        <script>
            let rowIndex = {{ old('items') ? count(old('items')) : 1 }};

            function newRowHtml(i) {
                const options =
                    `<option value="">-- Select Item --</option>
                     @foreach ($items as $item)
                          <option value="{{ $item->item_id }}">
                               {{ $item->item_id }} — {{ addslashes($item->description) }}
                          </option>
                     @endforeach`;

                return `
                <tr class="item-row" data-index="${i}">
                     <td data-label="Item">
                          <select name="items[${i}][item_id]"
                               class="form-select form-select-sm item-select" data-index="${i}">
                               ${options}
                          </select>
                          <input type="hidden" name="items[${i}][selling_price_id]"
                               class="selling-price-id">
                     </td>
                     <td data-label="Qty">
                          <input type="number" step="0.0001" min="0.0001"
                               name="items[${i}][qty]"
                               class="form-control form-control-sm" placeholder="0">
                     </td>
                     <td data-label="Proposed Price">
                          <div class="input-group input-group-sm">
                               <span class="input-group-text">Rp</span>
                               <input type="text" class="form-control currency-input"
                                    data-target="#proposedPriceReal_${i}"
                                    placeholder="0" autocomplete="off">
                               <input type="hidden" id="proposedPriceReal_${i}"
                                    name="items[${i}][proposed_price]"
                                    class="proposed-price-real">
                          </div>
                     </td>
                     <td class="text-center">
                          <button type="button"
                               class="btn btn-sm btn-outline-danger btn-remove-row">
                               <i class="ti ti-trash"></i>
                          </button>
                     </td>
                </tr>`;
            }

            function sspPanelHtml(index, itemLabel, data) {
                return `
                    <div class="ssp-panel border rounded p-3" data-ssp-index="${index}" style="font-size:13px">
                        {{-- Item label --}}
                        <div class="mb-3">
                            <div class="text-muted small mb-1">Item</div>
                            <div class="fw-semibold text-wrap" title="${itemLabel}">${itemLabel}</div>
                        </div>                    

                        {{-- SSP Min & Max --}}
                        <div class="mb-3">
                            <div class="text-muted small mb-1">SSP Min</div>
                            <div class="text-info fw-semibold">${data.ssp_min_formatted}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small mb-1">SSP Max</div>
                            <div class="text-success fw-semibold">${data.ssp_max_formatted}</div>
                        </div>
                    </div>
                `;
            }

            function refreshSspPlaceholder() {
                const hasPanels = document.querySelectorAll('.ssp-panel').length > 0;
                document.getElementById('sspPlaceholder').classList.toggle('d-none', hasPanels);
            }

            document.getElementById('btnAddRow').addEventListener('click', () => {
                document.getElementById('itemRows')
                    .insertAdjacentHTML('beforeend', newRowHtml(rowIndex++));
            });

            document.getElementById('itemRows').addEventListener('click', e => {
                if (!e.target.closest('.btn-remove-row')) return;
                const rows = document.querySelectorAll('.item-row');
                if (rows.length === 1) return;

                const row = e.target.closest('.item-row');
                const index = row.dataset.index;

                document.querySelector(`.ssp-panel[data-ssp-index="${index}"]`)?.remove();
                row.remove();
                refreshSspPlaceholder();
            });

            document.getElementById('itemRows').addEventListener('change', e => {
                const select = e.target.closest('.item-select');
                if (!select) return;

                const row = select.closest('.item-row');
                const index = row.dataset.index;
                const itemId = select.value;
                const spInput = row.querySelector('.selling-price-id');

                document.querySelector(`.ssp-panel[data-ssp-index="${index}"]`)?.remove();

                if (!itemId) {
                    spInput.value = '';
                    refreshSspPlaceholder();
                    return;
                }

                fetch(`/proposal/ssp-info/${itemId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.ssp_max) {
                            spInput.value = data.selling_price_id;
                            const label = select.options[select.selectedIndex].text;
                            document.getElementById('sspPanels')
                                .insertAdjacentHTML('beforeend', sspPanelHtml(index, label, data));
                        } else {
                            spInput.value = '';
                        }
                        refreshSspPlaceholder();
                    })
                    .catch(() => {
                        spInput.value = '';
                        refreshSspPlaceholder();
                    });
            });

            refreshSspPlaceholder();
        </script>
    @endpush
@endsection
