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
                    <form action="{{ route('calculator.calculate') }}" method="GET">
                        <div class="card-body m-3">
                            <h4 class="card-title">Calculator Suggested</h4>
                            <p class="card-description">Additional details about the selected item will be displayed here.
                            </p>
                            {{-- Row 1 --}}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="item" class="form-label">Item</label>
                                    <select class="form-select select2" id="item" name="item_id">
                                        <option selected disabled>Choose an item</option>
                                        @foreach ($items as $key => $item)
                                            <option value="{{ $key }}"
                                                {{ request('item_id') == $key ? 'selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="quantity" class="form-label">Quantity (KG)</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity"
                                        placeholder="Enter quantity" value="{{ request('quantity') }}">
                                </div>
                            </div>

                            {{-- Row 2 --}}
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label for="cost_price" class="form-label">Cost Price</label>
                                    <input type="number" class="form-control" id="cost_price" name="cost_price"
                                        placeholder="Enter Cost Price" value="{{ request('cost_price') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="top" class="form-label">TOP</label>
                                    <input type="number" class="form-control" id="top" name="top"
                                        placeholder="TOP in days" value="{{ request('top') }}">
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col d-flex justify-content-end">
                                    <button type="submit" class="btn btn-gradient-primary">Calculate</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @include('transaction.calculator.result')
        </div>
    </div>
@endsection
