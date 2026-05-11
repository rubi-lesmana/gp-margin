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
                {{-- Perubahan Nama Judul --}}
                <h4 class="card-title">Edit Item</h4>
                <p class="card-description">Modify the details of the item.</p>

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

                {{-- Action diarahkan ke items.update dengan parameter ID --}}
                <form class="forms-sample" action="{{ route('items.update', $item->item_id) }}" method="POST">
                    @csrf
                    {{-- WAJIB: Tambahkan method PUT untuk update --}}
                    @method('PUT')

                    <div class="tab-content">
                        {{-- Tab Data Item --}}
                        <div class="tab-pane fade show active m-3" id="gpmargin" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="item_id">Item ID</label>
                                        <input type="text" class="form-control @error('item_id') is-invalid @enderror"
                                            id="item_id" name="item_id" placeholder="Item ID" readonly
                                            value="{{ old('item_id', $item->item_id) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text"
                                            class="form-control @error('description') is-invalid @enderror" id="description"
                                            name="description" placeholder="Description" {{-- Mengambil nilai dari database ($item->description) --}}
                                            value="{{ old('description', $item->description) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab base margin --}}
                        <div class="tab-pane fade m-3" id="basemargin" role="tabpanel" aria-labelledby="basemargin-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="base_margin_id">Base Margin</label>
                                        <select class="form-select form-select-lg js-example-basic-single"
                                            id="base_margin_id" name="base_margin_id">
                                            <option value="">Select Base Margin</option>
                                            @foreach ($base_margins as $id => $margin_percentage)
                                                {{-- Logic 'selected' untuk menandai pilihan saat ini --}}
                                                <option value="{{ $id }}"
                                                    {{ old('base_margin_id', $item->base_margin_id) == $id ? 'selected' : '' }}>
                                                    {{ $margin_percentage }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab Setup (unitID & ParetoID) --}}
                        <div class="tab-pane fade m-3" id="setup" role="tabpanel" aria-labelledby="setup-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unit_id">Unit</label>
                                        <select class="form-select form-select-lg js-example-basic-single" id="unit_id"
                                            name="unit_id">
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $id => $unit_name)
                                                <option value="{{ $id }}"
                                                    {{ old('unit_id', $item->unit_id) == $id ? 'selected' : '' }}>
                                                    {{ $unit_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pareto_id">Pareto</label>
                                        <select class="form-select form-select-lg js-example-basic-single" id="pareto_id"
                                            name="pareto_id">
                                            <option value="">Select Pareto</option>
                                            @foreach ($paretos as $id => $pareto_name)
                                                <option value="{{ $id }}"
                                                    {{ old('pareto_id', $item->pareto_id) == $id ? 'selected' : '' }}>
                                                    {{ $pareto_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-3">
                            <button type="submit" class="btn btn-primary me-2">Update Data</button>
                            <a href="{{ route('items.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
