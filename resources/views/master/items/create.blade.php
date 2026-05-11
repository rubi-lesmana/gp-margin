@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-call-missed"></i>
                </span> Item Management
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Item</h4>
                <p class="card-description">Fill in the details below to add a new item.</p>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#gpmargin" role="tab"
                            aria-controls="home" aria-selected="true">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="basemargin-tab" data-bs-toggle="tab" href="#basemargin" role="tab"
                            aria-controls="profile" aria-selected="false">Base Margin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="setup-tab" data-bs-toggle="tab" href="#setup" role="tab"
                            aria-controls="profile" aria-selected="false">Setup</a>
                    </li>
                </ul>

                {{-- Detail Tab Content --}}
                <form class="forms-sample" action="{{ route('items.store') }}" method="POST">
                    @csrf
                    <div class="tab-content">
                        {{-- Tab Data Item --}}
                        <div class="tab-pane fade show active m-3" id="gpmargin" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="item_id">Item ID</label>
                                        <input type="text" class="form-control" id="item_id" name="item_id"
                                            placeholder="Item ID"
                                            @error('item_id') is-invalid                              
                                     @enderror
                                            value="{{ old('item_id') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" id="description" name="description"
                                            placeholder="Description"
                                            @error('description') is-invalid                              
                                     @enderror
                                            value="{{ old('description') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Tab base margin --}}
                        <div class="tab-pane fade m-3" id="basemargin" role="tabpanel" aria-labelledby="basemargin-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-select form-select-lg js-example-basic-single"
                                            id="base_margin_id" name="base_margin_id">
                                            <option value="">Select Base Margin</option>
                                            @foreach ($base_margins as $key => $margin_percentage)
                                                <option value="{{ $key }}">{{ $margin_percentage }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Tab Setup (Unit ID & Pareto ID) --}}
                        <div class="tab-pane fade m-3" id="setup" role="tabpanel" aria-labelledby="setup-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-select form-select-lg js-example-basic-single" id="unit_id"
                                            name="unit_id">
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $key => $unit)
                                                <option value="{{ $key }}">{{ $unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-select form-select-lg js-example-basic-single" id="pareto_id"
                                            name="pareto_id">
                                            <option value="">Select Pareto</option>
                                            @foreach ($paretos as $key => $pareto)
                                                <option value="{{ $key }}">{{ $pareto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-3">
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('items.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
