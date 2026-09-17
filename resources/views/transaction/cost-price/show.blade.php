@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-basket"></i>
                </span> Edit Cost Price
            </h3>
        </div>
        <div class="row">
                {{-- Kolom 1 Header --}}
                <div class="col-md-5 mb-3 mb-md-0">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Form Edit</h4>
                            {{-- Inventory Arrival --}}
                            <div class="mb-3">
                                <label class="form-label">Inventory Arrival Transaction</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $costPrice->arrival_id }}" readonly>                                 
                                </div>
                            </div>

                            {{-- Cost Price --}}
                            <div class="mb-3">
                                <label class="form-label">Cost Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input class="form-control" type="text" id="price_display" placeholder="0"
                                        inputmode="numeric" autocomplete="off"
                                        value="{{ number_format($costPrice->cost_price, 0, '.', ',') }}" readonly>                                    
                                </div>
                                <input type="hidden" name="cost_price" id="price_real"
                                    value="{{ $costPrice->cost_price }}">
                            </div>

                            {{-- Manual Reference --}}
                            <div class="mt-3">
                                <label class="form-label">Manual Reference <code>(Optional)</code></label>
                                <textarea class="form-control" type="text" name="manual_reference" placeholder="Manual Reference" rows="3" readonly>{{ $costPrice->manual_reference }}</textarea>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-start gap-3 mt-4">
                                <a href="{{ route('cost-price.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom 2 Details --}}
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Details</h4>
                            {{-- Tanggal --}}
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label">Date</label>
                                    <input class="form-control" type="date" id="date_display" value="{{ $costPrice->date }}" readonly>
                                    <input type="hidden" id="date" name="date" value="{{ $costPrice->date }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <input class="form-control" type="text" id="status_display" value="{{ $costPrice->arrival->status ?? '' }}" readonly>
                                    <input type="hidden" id="status" name="status" value="{{ $costPrice->arrival->status ?? '' }}">
                                </div>
                            </div>
                            
                            {{-- Item --}}
                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <label class="form-label">Item ID</label>
                                    <input class="form-control" type="text" id="item_id_display" placeholder="Item ID"
                                        readonly value="{{ $costPrice->arrival->item_id ?? '' }}">
                                    <input type="hidden" id="item_id" name="item_id"
                                        value="{{ $costPrice->arrival->item_id ?? '' }}">
                                </div>

                                <div class="col-md-7">
                                    <label class="form-label">Description</label>
                                    <input class="form-control" id="description-item" readonly
                                        value="{{ $costPrice->arrival->item->description ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
