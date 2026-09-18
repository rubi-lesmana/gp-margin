@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-basket"></i>
                </span> Show Inventory Arrival
            </h3>
        </div>
        <div class="row">

            {{-- Kolom 1 Header --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Edit</h4>

                        {{-- Tanggal --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Date Arrival</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    value="{{ $arrival->date }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Supplier</label>
                                <select class="form-select select2" name="supplier_id" required>
                                    <option value="{{ $arrival->supplier->id_supplier ?? '' }}">
                                        {{ $arrival->supplier->supplier_name ?? 'Null' }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Status</label>
                                <select class="form-select select2" id="status" name="status" required>
                                    <option>{{ $arrival->status }}</option>

                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Currency</label>
                                <select class="form-select select2" id="currency" name="currency_id" required>
                                    <option value="">{{ $arrival->currency_id ?? 'Null' }}</option>
                                </select>
                            </div>
                        </div>

                        {{-- Manual Reference --}}
                        <div class="mb-3">
                            <label class="form-label">Manual Reference <code>(Optional)</code></label>
                            <textarea class="form-control" name="keterangan" rows="3" placeholder="Enter manual reference">{{ old('keterangan', $arrival->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom 2 Details --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Details</h4>

                        <div class="row mb-3">
                            <div class="col-12 col-md-5 mb-3 mb-md-0">
                                <label class="form-label">Item</label>
                                <select class="form-select select2" id="item-id">
                                    <option value="{{ $arrival->item_id }}" selected>
                                        {{ $arrival->item_id }}
                                    </option>
                                </select>
                                {{-- item_id tidak diubah, tapi tetap perlu dikirim kalau controller butuh referensi (opsional) --}}
                                <input type="hidden" name="item_id" value="{{ $arrival->item_id }}">
                            </div>
                            <div class="col-12 col-md-7">
                                <label class="form-label">Description</label>
                                <input class="form-control" id="description-item" value="{{ $arrival->item->description }}"
                                    readonly>
                            </div>
                        </div>

                        {{-- Quantity --}}
                        <div class="row mt-3">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label class="form-label">Quantity</label>
                                <input type="text" class="form-control" id="quantity-display"
                                    value="{{ number_format($arrival->quantity, 0, ',', '.') }}">
                                <input type="hidden" id="quantity" name="quantity" value="{{ $arrival->quantity }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Unit</label>
                                <select class="form-select select2" id="unit-id" name="unit_id" required>
                                    <option value="">{{ $arrival->unit_id }}</option>
                                </select>
                            </div>
                        </div>

                        {{-- Cost Price & Net Amount --}}
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <label class="form-label">Unit Price</label>
                                {{-- display: tampil format titik --}}
                                <input type="text" class="form-control" id="unit-price-display" placeholder="0"
                                    value="{{ number_format($arrival->unit_price, 0, ',', '.') }}">
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Net Amount</label>
                                {{-- display: tampil format titik --}}
                                <input type="text" class="form-control" id="net-amount-display" readonly placeholder="0"
                                    value="{{ number_format($arrival->net_amount, 0, ',', '.') }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-start mt-4">
                            <a href="{{ route('arrival-inventory.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
