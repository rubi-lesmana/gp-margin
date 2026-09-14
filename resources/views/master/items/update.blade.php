@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-call-missed"></i>
                </span> Create Item
            </h3>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="forms-sample" action="{{ route('items.update', $item->item_id) }}" method="POST">
            @csrf
            {{-- WAJIB: Tambahkan method PUT untuk update --}}
            @method('PUT')
            <div class="row">
                {{-- Kolom 1 Header --}}
                <div class="col-12 col-md-5 mb-md-0 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Form Create</h4>

                            <div class="mb-3">
                                <label class="form-label">ID Item</label>
                                <input class="form-control" name="item_id" placeholder="Item ID" readonly
                                       @error('item_id') is-invalid @enderror 
                                       value="{{ old('item_id', $item->item_id) }}">
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" placeholder="Description"
                                          rows="3">{{ old('description', $item->description) }}</textarea>
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
                                <label for="base_margin_id" class="col-sm-3 form-label">Base Margin</label>
                                <div class="col-sm-9">
                                    <select class="form-select select2"
                                            id="base_margin_id" name="base_margin_id">
                                        <option value="">Select Base Margin</option>
                                        @foreach ($base_margins as $key => $margin_percentage)
                                            <option value="{{ $key }}" {{ old('base_margin_id', $item->base_margin_id) == $key ? 'selected' : '' }}>
                                                {{ $margin_percentage }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3 align-items-center">
                                <label for="pareto_id" class="col-sm-3 form-label">Unit ID</label>
                                <div class="col-sm-9">
                                    <select class="form-select select2"
                                            id="unit_id" name="unit_id">
                                        <option value="">Select Unit</option>
                                        @foreach ($units as $key => $unit)
                                            <option value="{{ $key }}" {{ old('unit_id', $item->unit_id) == $key ? 'selected' : '' }}>
                                                {{ $unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                           
                            <div class="row mt-3 mb-3 align-items-center">
                                <label for="unit_conversion_id" class="col-sm-3 form-label">Unit Conversion</label>
                                <div class="col-sm-9">
                                    <select class="form-select select2"
                                            id="unit_conversion_id" name="unit_conversion_id">
                                        <option value="">Select Unit Conversion</option>
                                        @foreach ($unitConversions as $key => $conversion)
                                            <option value="{{ $key }}" {{ old('unit_conversion_id', $item->unit_conversion_id) == $key ? 'selected' : '' }}>
                                                {{ $conversion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                           
                            <div class="row mt-3 mb-3 align-items-center">
                                <label for="pareto_id" class="col-sm-3 form-label">Pareto</label>
                                <div class="col-sm-9">
                                    <select class="form-select select2"
                                            id="pareto_id" name="pareto_id">
                                        <option value="">Select Pareto</option>
                                        @foreach ($paretos as $key => $pareto)
                                            <option value="{{ $key }}" {{ old('pareto_id', $item->pareto_id) == $key ? 'selected' : '' }}>
                                                {{ $pareto }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                           
                            <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection