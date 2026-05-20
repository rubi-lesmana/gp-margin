@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-basket"></i>
                </span> Create Cost Price
            </h3>
        </div>
        <form action="{{ route('cost-price.store') }}" method="POST">
            @csrf
            <div class="row">

                {{-- Kolom 1 Header --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Form Create</h4>
                            {{-- Tanggal --}}
                            <div class="mb-3">
                                <label class="form-label">Inventory Arrival Transaction</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="arrival_display"
                                        placeholder="Inventory Arrival ID" aria-label="arrival_id"
                                        aria-describedby="search-arrival" data-bs-toggle="modal" data-bs-target="#arrival"
                                        style="cursor: pointer;" readonly>
                                    <input type="hidden" id="arrival_id" name="arrival_id">
                                    <span class="input-group-text" id="search-arrival" data-bs-toggle="modal"
                                        data-bs-target="#arrival" style="cursor: pointer;">
                                        <i class=" icon-magnifier ms-1"></i>
                                    </span>
                                </div>
                            </div>

                            @include('transaction.cost-price.modal.arrival')

                            {{-- Cost Price --}}
                            <div class="mb-3">
                                <label class="form-label">Cost Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input class="form-control currency-input" type="text" name="cost_price"
                                        placeholder="0" inputmode="numeric" autocomplete="off">
                                    <span class="input-group-text px-3" id="unit_id-display">
                                        <span class="text-muted">unit</span>
                                    </span>
                                </div>
                                {{-- Hidden input tanpa value default, hanya terisi jika user mengetik --}}
                                {{-- <input type="hidden" name="cost_price" id="price_real"> --}}
                            </div>

                            {{-- <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const display = document.getElementById('price_display');
                                    const real = document.getElementById('price_real');

                                    display.addEventListener('input', function() {
                                        let raw = this.value.replace(/[^\d]/g, '');
                                        this.value = raw !== '' ? raw.replace(/\B(?=(\d{3})+(?!\d))/g, ',') : '';
                                        real.value = raw; // kosong jika tidak ada input
                                    });

                                    display.addEventListener('keydown', function(e) {
                                        const allowed = [8, 9, 35, 36, 37, 38, 39, 40, 46];
                                        if (allowed.includes(e.keyCode)) return;
                                        if (!/^\d$/.test(e.key)) e.preventDefault();
                                    });
                                });
                            </script> --}}

                            {{-- Manual Reference --}}
                            <div class="mt-3">
                                <label class="form-label">Manual Reference <code>(Optional)</code></label>
                                <textarea class="form-control" type="text" name="manual_reference" placeholder="Manual Reference" rows="3"></textarea>
                            </div>

                            <div class="d-flex justify-content-start mt-4">
                                <button type="submit" class="btn btn-primary me-3">Submit</button>
                                <a href="{{ route('cost-price.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom 2 Details --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Details</h4>
                            {{-- Status --}}
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input class="form-control" type="date" id="date_display">
                                {{-- hidden: nilai asli untuk dikirim ke server --}}
                                <input type="hidden" id="date" name="date">
                            </div>
                            {{-- Item --}}
                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <label class="form-label">Item ID</label>
                                    <input class="form-control" type="text" id="item_id_display" placeholder="Item ID"
                                        readonly>
                                    </input>
                                    {{-- hidden: nilai asli untuk dikirim ke server --}}
                                    <input type="hidden" id="item_id" name="item_id">
                                </div>

                                <div class="col-md-7">
                                    <label class="form-label">Description</label>
                                    <input class="form-control" id="description-item" readonly>
                                    </input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectButtons = document.querySelectorAll('.select-arrival');

            function formatRupiah(value) {
                value = Number(value || 0);

                return value.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function setValue(id, value) {
                const element = document.getElementById(id);

                if (element) {
                    element.value = value ?? '';
                }
            }

            selectButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const arrivalId = this.dataset.id;
                    const date = this.dataset.date;
                    const status = this.dataset.status;
                    const itemId = this.dataset.itemId;
                    const itemDesc = this.dataset.itemDesc;
                    const unitId = this.dataset.unitId;

                    setValue('arrival_id', arrivalId);
                    setValue('arrival_display', arrivalId);

                    setValue('date_display', date);
                    setValue('date', date);

                    setValue('item_id_display', itemId);
                    setValue('item_id', itemId);

                    setValue('description-item', itemDesc);

                    console.log('unitId raw:', this.dataset.unitId);
                    document.getElementById('unit_id-display').textContent = unitId;
                    setValue('unit_id', unitId);
                });
            });
        });
    </script>
@endsection
