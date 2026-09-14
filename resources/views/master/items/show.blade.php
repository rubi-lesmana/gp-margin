@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-call-missed"></i>
                </span> Item Detail
            </h3>
        </div>

        <div class="row">
            {{-- Kolom 1 Header --}}
            <div class="col-12 col-md-5 mb-md-0 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Item Info</h4>

                        <div class="mb-3">
                            <label class="form-label">ID Item</label>
                            <input class="form-control" value="{{ $item->item_id }}" readonly>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" readonly>{{ $item->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom 2 Details --}}
            <div class="col-12 col-md-7 mb-md-0 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">Setup</h6>
                        </div>

                        <div class="row mt-3 mb-3 align-items-center">
                            <label class="col-sm-3 form-label">Base Margin</label>
                            <div class="col-sm-9">
                                <input class="form-control" value="{{ $item->base_margin->margin_percentage ?? '-' }}" readonly>
                                {{-- sesuaikan 'margin_percentage' dengan nama kolom asli di tabel base_margin --}}
                            </div>
                        </div>

                        <div class="row mt-3 mb-3 align-items-center">
                            <label class="col-sm-3 form-label">Unit Inventory</label>
                            <div class="col-sm-9">
                                <input class="form-control" value="{{ $item->unit->description ?? '-' }}" readonly>
                            </div>
                        </div>

                        <div class="row mt-3 mb-3 align-items-center">
                            <label class="col-sm-3 form-label">Unit Conversion</label>
                            <div class="col-sm-9">
                                <input class="form-control" value="{{ $item->unit_conversion->description ?? '-' }}" readonly>
                            </div>
                        </div>

                        <div class="row mt-3 mb-3 align-items-center">
                            <label class="col-sm-3 form-label">Pareto</label>
                            <div class="col-sm-9">
                                <input class="form-control" value="{{ $item->pareto->description ?? '-' }}" readonly>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
                            <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection