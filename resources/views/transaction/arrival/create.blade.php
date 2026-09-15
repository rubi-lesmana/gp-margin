@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-basket"></i>
                </span> Create Inventory Arrival
            </h3>
        </div>
        <form action="{{ route('arrival-inventory.store') }}" method="POST">
            @csrf
            <div class="row">

                {{-- Kolom 1 Header --}}
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Form Create</h4>
                            {{-- Tanggal --}}
                            <div class="mb-3">
                                <label class="form-label">Date Arrival</label>
                                <input type="date" min="0" class="form-control" id="date" name="date"
                                    required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12 col-md-6 mb-3 mb-md-0">
                                    <label class="form-label">Status</label>
                                    <select class="form-select select2" id="status" name="status" required>
                                        <option value="">Status</option>
                                        @foreach ($arrivalStatuses as $code => $description)
                                            <option value="{{ $code }}">{{ $code }}</option>                                            
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Currency</label>
                                    <select class="form-select select2" id="currency" name="currency_id" required>
                                        <option value="">Currency</option>
                                        @foreach ($currency as $id_currency => $description)                                            
                                        <option value="{{ $id_currency }}">{{ $id_currency }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Status --}}

                            {{-- Manual Reference --}}
                            <div class="mb-3">
                                <label class="form-label">Manual Reference <code>(Optional)</code></label>
                                <input class="form-control" name="keterangan" placeholder="Enter manual reference">
                                </input>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom 2 Details --}}
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Details</h4>
                            <div class="row mb-3">
                                <div class="col-12 col-md-5 mb-3 mb-md-0">
                                    <label class="form-label">Item</label>
                                    <select class="form-select" id="item-id" name="item_id" required>
                                        <option value="">Select Item</option>
                                        @foreach ($item as $key => $title)
                                            <option value="{{ $key }}" data-description="{{ $title }}"
                                                {{ old('item_id') == $key ? 'selected' : '' }}>
                                                {{ $key }} - {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('item_id') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-7">
                                    <label class="form-label">Description</label>
                                    <input class="form-control" id="description-item" name="description" readonly>
                                    </input>
                                </div>
                            </div>

                            {{-- Quantity --}}
                            {{-- <div class="mb-3"> --}}
                            <div class="row mt-3">
                                <div class="col-md-8 mb-3 mb-md-0">
                                    <label class="form-label">Quantity</label>
                                    {{-- display: tampil format titik --}}
                                    <input type="text" class="form-control" id="quantity-display" placeholder="0">
                                    {{-- hidden: nilai asli untuk dikirim ke server --}}
                                    <input type="hidden" id="quantity" name="quantity">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Unit</label>
                                    <select class="form-select select2" id="unit-id" name="unit_id" required>
                                        <option value="">Select Unit</option>
                                    </select>
                                    @error('unit_id') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            {{-- </div> --}}

                            {{-- CostPrice & Net Amount --}}
                            <div class="row mt-3">
                                <div class="col-md-5 mb-3 mb-md-0">
                                    <label class="form-label">Unit Price</label>
                                    {{-- display: tampil format titik --}}
                                    <input type="text" class="form-control" id="unit-price-display" placeholder="0">
                                    {{-- hidden: nilai asli untuk dikirim ke server --}}
                                    <input type="hidden" id="unit-price" name="unit_price">
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label">Net Amount</label>
                                    {{-- display: tampil format titik --}}
                                    <input type="text" class="form-control" id="net-amount-display" readonly
                                        placeholder="0">
                                    {{-- hidden: nilai asli untuk dikirim ke server --}}
                                    <input type="hidden" id="net-amount" name="net_amount">
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-row justify-content-start gap-3 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    <script src="{{ asset('js/item-unit-conversion.js') }}"></script>
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

            // fetch & populate unit setiap kali item dipilih (logic dari module reusable)
            ItemUnitConversion.bindItemChange({
                itemSelector: '#item-id',
                unitSelector: '#unit-id',
                descriptionSelector: '#description-item'
            });

            // ==== Auto isi default currency berdasarkan status (Select2-safe) ====
            const statusDefaultCurrency = @json($defaultCurrency);

            $('#status').on('change', function () {
                const selectedCode = $(this).val();
                const defaultCurrencyValue = statusDefaultCurrency[selectedCode];

                $('#currency').val(defaultCurrencyValue ?? '').trigger('change');
            });

            // format angka dengan pemisah titik (1.000.000)
            function formatNumber(value) {
                if (!value || isNaN(value)) return '';
                return new Intl.NumberFormat('id-ID').format(value);
            }

            function parseNumber(value) {
                return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
            }

            function hitungNetAmount() {
                let quantity = parseNumber($('#quantity-display').val());
                let unitPrice = parseNumber($('#unit-price-display').val());
                let netAmount = quantity * unitPrice;

                $('#net-amount-display').val(netAmount > 0 ? formatNumber(netAmount) : '');

                $('#quantity').val(quantity);
                $('#unit-price').val(unitPrice);
                $('#net-amount').val(netAmount > 0 ? netAmount : '');
            }

            $('#quantity-display').on('input', function() {
                let raw = $(this).val().replace(/\D/g, '');
                let formatted = raw ? formatNumber(raw) : '';
                $(this).val(formatted);
                hitungNetAmount();
            });

            $('#unit-price-display').on('input', function() {
                let raw = $(this).val().replace(/[^\d,]/g, '');
                let formatted = raw ? formatNumber(parseNumber(raw)) : '';
                $(this).val(formatted);
                hitungNetAmount();
            });
        });
    </script>
@endpush
