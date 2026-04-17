@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-calculator"></i>
                </span> Calculator
            </h3>
        </div>
        <div class="row and d-flex justify-content-left">
            {{-- Input Fields --}}
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="item" class="form-label">Item</label>
                                <select class="form-select" id="item">
                                    <option selected disabled>Choose an item</option>
                                    {{-- @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" placeholder="Enter quantity">
                            </div>
                        </div>
                        <!-- Modal starts -->

                    </div>
                </div>
            </div>

            {{-- Detail Information --}}
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="card-title">Detail Information</div>
                            <div class="col-md-6">
                                <label for="item" class="form-label">Item</label>
                                <select class="form-select" id="item">
                                    <option selected disabled>Choose an item</option>
                                    {{-- @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" placeholder="Enter quantity">
                            </div>
                        </div>
                        <!-- Modal starts -->

                    </div>
                </div>
            </div>
        </div>
        <div class="row and d-flex justify-content-left">

        </div>
    </div>
@endsection
