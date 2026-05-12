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

                            {{-- Status --}}
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="Local">Local</option>
                                    <option value="Import">Import</option>
                                </select>
                            </div>

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
                            {{-- Item --}}
                            <div class="mb-3">
                                <label class="form-label">Item</label>
                                <select class="form-control" id="item-id" name="item_id" required>
                                    <option value="">Select Item</option>
                                    @foreach ($item as $key => $title)
                                        <option value="{{ $key }}" data-description="{{ $title }}"
                                            data-unit="{{ $itemUnits[$key] ?? '' }}">
                                            {{ $key }} - {{ $title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <input class="form-control" id="description-item" name="description" readonly>
                                </input>
                            </div>

                            {{-- Quantity --}}
                            {{-- <div class="mb-3"> --}}
                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <label class="form-label">Quantity</label>
                                    {{-- display: tampil format titik --}}
                                    <input type="text" class="form-control" id="quantity-display" placeholder="0">
                                    {{-- hidden: nilai asli untuk dikirim ke server --}}
                                    <input type="hidden" id="quantity" name="quantity">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Unit</label>
                                    <input type="text" class="form-control" id="unit_Id" name="unit_id" readonly>
                                    </input>
                                </div>
                            </div>
                            {{-- </div> --}}

                            {{-- CostPrice & Net Amount --}}
                            <div class="row mt-3">
                                <div class="col-md-5">
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
                            <div class="d-flex justify-content-start mt-4">
                                <button type="submit" class="btn btn-primary me-3">Submit</button>
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
                    // tampilan DI dropdown list -> tetap "itemid - description"
                    return data.text;
                },
                templateSelection: function(data) {
                    // tampilan SETELAH dipilih (kotak select) -> hanya itemid
                    return data.id || data.text; // untuk placeholder
                }
            });

            // isi otomatis input description & unit
            $('#item-id').on('change', function() {
                // let description = $(this).find(':selected').attr('data-description');
                // $('#description-item').val(description ?? '');
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

                // simpan nilai asli ke hidden input untuk dikirim ke server
                $('#quantity').val(quantity);
                $('#unit-price').val(unitPrice);
                $('#net-amount').val(netAmount > 0 ? netAmount : '');
            }

            // format saat user mengetik di quantity
            $('#quantity-display').on('input', function() {
                let raw = $(this).val().replace(/\D/g, ''); // hanya angka
                let formatted = raw ? formatNumber(raw) : '';
                $(this).val(formatted);
                hitungNetAmount();
            });

            // format saat user mengetik di unit price
            $('#unit-price-display').on('input', function() {
                let raw = $(this).val().replace(/[^\d,]/g, ''); // angka & koma
                let formatted = raw ? formatNumber(parseNumber(raw)) : '';
                $(this).val(formatted);
                hitungNetAmount();
            });

            $('#status').select2({
                width: '100%',
            });
        });
    </script>
@endpush
