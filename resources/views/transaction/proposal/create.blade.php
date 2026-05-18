@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-paper-plane"></i>
                </span> Pengajuan Harga
            </h3>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Form Pengajuan Harga</h6>

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('proposal.store') }}">
                            @csrf

                            {{-- Customer --}}
                            <div class="mb-3">
                                <label class="form-label">Customer <span class="text-danger">*</span></label>
                                <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror">
                                    <option value="">-- Pilih Customer --</option>
                                    @foreach ($customers as $key => $name)
                                        <option value="{{ $key }}"
                                            {{ old('customer_id') == $key ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Item --}}
                            <div class="mb-3">
                                <label class="form-label">Item <span class="text-danger">*</span></label>
                                <select name="item_id" id="itemSelect"
                                    class="form-select @error('item_id') is-invalid @enderror"
                                    onchange="loadSspInfo(this.value)">
                                    <option value="">-- Pilih Item --</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->item_id }}"
                                            {{ old('item_id') == $item->item_id ? 'selected' : '' }}>
                                            {{ $item->item_id }} — {{ $item->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('item_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- SSP Info — muncul setelah item dipilih --}}
                            <div id="sspInfo" class="alert alert-info d-none mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-semibold">Suggested Selling Price</span>
                                    <small class="text-muted" id="sspApprovedAt"></small>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="p-2 bg-white rounded border text-center">
                                            <div class="text-muted" style="font-size:10px;letter-spacing:0.05em">SSP MIN
                                            </div>
                                            <div class="fw-semibold text-info" id="sspMinValue">-</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 bg-white rounded border text-center">
                                            <div class="text-muted" style="font-size:10px;letter-spacing:0.05em">SSP MAX
                                            </div>
                                            <div class="fw-bold text-success" id="sspMaxValue">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Proposed Price --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    Harga Pengajuan <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" name="proposed_price" id="proposedPrice"
                                        class="form-control currency-input @error('proposed_price') is-invalid @enderror"
                                        data-target="#proposedPriceReal" data-decimals="2"
                                        placeholder="Masukkan harga pengajuan" autocomplete="off">
                                    <input type="hidden" name="proposed_price" id="proposedPriceReal"
                                        value="{{ old('proposed_price') }}">
                                    @error('proposed_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror`
                                </div>
                            </div>


                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-gradient-primary">
                                    <i class="icon-paper-plane me-1"></i> Submit Pengajuan
                                </button>
                                <a href="{{ route('proposal.index') }}" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Panel info SSP detail --}}
            <div class="col-md-5">
                <div class="card" id="sspDetailPanel" style="display:none!important">
                    <div class="card-body">
                        <h6 class="card-title">Referensi SSP Item</h6>
                        <div id="sspDetailContent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function loadSspInfo(itemId) {
                if (!itemId) {
                    document.getElementById('sspInfo').classList.add('d-none');
                    return;
                }

                fetch(`/proposal/ssp-info/${itemId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.ssp_max) {
                            document.getElementById('sspMinValue').textContent = data.ssp_min_formatted;
                            document.getElementById('sspMaxValue').textContent = data.ssp_max_formatted;
                            document.getElementById('sspApprovedAt').textContent = 'Approved: ' + data.approved_at;
                            document.getElementById('sspInfo').classList.remove('d-none');
                        } else {
                            document.getElementById('sspInfo').classList.add('d-none');
                        }
                    });
            }
        </script>
    @endpush
@endsection
