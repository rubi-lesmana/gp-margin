@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-basket"></i>
                </span> Edit Inventory Arrival
            </h3>
        </div>
        <form action="{{ route('arrival-inventory.update', $arrival->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">

                {{-- Kolom 1 Header --}}
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Form Edit</h4>

                            {{-- Tanggal --}}
                            <div class="mb-3">
                                <label class="form-label">Date Arrival</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    value="{{ old('date', $arrival->date) }}" required>
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="Local"
                                        {{ old('status', $arrival->status) == 'Local' ? 'selected' : '' }}>Local</option>
                                    <option value="Import"
                                        {{ old('status', $arrival->status) == 'Import' ? 'selected' : '' }}>Import</option>
                                </select>
                            </div>

                            {{-- Manual Reference --}}
                            <div class="mb-3">
                                <label class="form-label">Manual Reference <code>(Optional)</code></label>
                                <input class="form-control" name="keterangan" placeholder="Enter manual reference"
                                    value="{{ old('keterangan', $arrival->keterangan) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom 2 Details --}}
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Details</h4>

                            {{-- Item --}}
                            <div class="mb-3">
                                <label class="form-label">Item</label>
                                <select class="form-control" id="item-id" name="item_id" required>
                                    <option value="">Select Item</option>
                                    @foreach ($item as $key => $title)
                                        <option value="{{ $key }}" data-description="{{ $title }}"
                                            data-unit="{{ $itemUnits[$key] ?? '' }}"
                                            {{ old('item_id', $arrival->item_id) == $key ? 'selected' : '' }}>
                                            {{ $key }} - {{ $title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <input class="form-control" id="description-item" name="description" readonly
                                    value="{{ old('description', $arrival->item->description ?? '') }}">
                            </div>

                            {{-- Quantity --}}
                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <label class="form-label">Quantity</label>
                                    {{-- display: tampil format titik --}}
                                    <input type="text" class="form-control" id="quantity-display" placeholder="0">
                                    {{-- hidden: nilai asli untuk dikirim ke server --}}
                                    <input type="hidden" id="quantity" name="quantity"
                                        value="{{ old('quantity', $arrival->quantity) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Unit</label>
                                    <input type="text" class="form-control" id="unit_Id" name="unit_id" readonly
                                        value="{{ old('unit_id', $arrival->item->unit->unit_id ?? '') }}">
                                </div>
                            </div>

                            {{-- Cost Price & Net Amount --}}
                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <label class="form-label">Unit Price</label>
                                    {{-- display: tampil format titik --}}
                                    <input type="text" class="form-control" id="unit-price-display" placeholder="0">
                                    {{-- hidden: nilai asli untuk dikirim ke server --}}
                                    <input type="hidden" id="unit-price" name="unit_price"
                                        value="{{ old('unit_price', $arrival->unit_price) }}">
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label">Net Amount</label>
                                    {{-- display: tampil format titik --}}
                                    <input type="text" class="form-control" id="net-amount-display" readonly
                                        placeholder="0">
                                    {{-- hidden: nilai asli untuk dikirim ke server --}}
                                    <input type="hidden" id="net-amount" name="net_amount"
                                        value="{{ old('net_amount', $arrival->net_amount) }}">
                                </div>
                            </div>

                            <div class="d-flex justify-content-start mt-4">
                                <button type="submit" class="btn btn-primary me-3">Update</button>
                                <a href="{{ route('arrival-inventory.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#item-id').select2({
                width: '100%',
                templateResult: function(data) {
                    return data.text;
                },
                templateSelection: function(data) {
                    return data.id || data.text;
                }
            });

            // isi otomatis input description & unit
            $('#item-id').on('change', function() {
                let selected = $(this).find(':selected');
                let description = selected.attr('data-description');
                let unit = selected.attr('data-unit');

                $('#description-item').val(description ?? '');
                $('#unit_Id').val(unit ?? '');
            });

            // format angka dengan pemisah titik (1.000.000)
            function formatNumber(value) {
                if (!value || isNaN(value)) return '';
                return new Intl.NumberFormat('id-ID').format(value);
            }

            // ambil angka murni dari string berformat (hapus titik pemisah)
            function parseNumber(value) {
                return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
            }

            // hitung & update net amount
            function hitungNetAmount() {
                let quantity = parseNumber($('#quantity-display').val());
                let unitPrice = parseNumber($('#unit-price-display').val());
                let netAmount = quantity * unitPrice;

                $('#net-amount-display').val(netAmount > 0 ? formatNumber(netAmount) : '');

                $('#quantity').val(quantity);
                $('#unit-price').val(unitPrice);
                $('#net-amount').val(netAmount > 0 ? netAmount : '');
            }

            // format saat user mengetik di quantity
            $('#quantity-display').on('input', function() {
                let raw = $(this).val().replace(/\D/g, '');
                let formatted = raw ? formatNumber(raw) : '';
                $(this).val(formatted);
                hitungNetAmount();
            });

            // format saat user mengetik di unit price
            $('#unit-price-display').on('input', function() {
                let raw = $(this).val().replace(/[^\d,]/g, '');
                let formatted = raw ? formatNumber(parseNumber(raw)) : '';
                $(this).val(formatted);
                hitungNetAmount();
            });

            $('#status').select2({
                width: '100%',
            });

            // *** pre-fill display input dengan data existing saat halaman load ***
            let existingQty = $('#quantity').val();
            let existingPrice = $('#unit-price').val();

            if (existingQty) $('#quantity-display').val(formatNumber(existingQty));
            if (existingPrice) $('#unit-price-display').val(formatNumber(existingPrice));

            // hitung net amount dari data existing
            if (existingQty || existingPrice) hitungNetAmount();
        });
    </script>
@endpush
