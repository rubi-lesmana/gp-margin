@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-call-missed"></i>
                </span> Term Of Payment Management
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                {{-- Perubahan Nama Judul --}}
                <h4 class="card-title">Edit Term of Payment</h4>
                <p class="card-description">Modify the details of the term of payment.</p>

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#generaltop" role="tab"
                            aria-controls="home" aria-selected="true">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="basemargin-tab" data-bs-toggle="tab" href="#basemargin" role="tab"
                            aria-controls="profile" aria-selected="false">Base Margin</a>
                    </li>
                </ul>

                {{-- Action diarahkan ke term-of-payment.update dengan parameter ID --}}
                <form class="forms-sample" action="{{ route('term-of-payment.update', $top->id) }}" method="POST">
                    @csrf
                    {{-- WAJIB: Tambahkan method PUT untuk update --}}
                    @method('PUT')

                    <div class="tab-content">
                        {{-- Tab Data Item --}}
                        <div class="tab-pane fade show active m-3" id="generaltop" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="days">Days</label>
                                        <input type="text" class="form-control @error('days') is-invalid @enderror"
                                            id="days" name="days" placeholder="Days" readonly
                                            value="{{ old('days', $top->days) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text"
                                            class="form-control @error('description') is-invalid @enderror" id="description"
                                            name="description" placeholder="Description" {{-- Mengambil nilai dari database ($item->description) --}}
                                            value="{{ old('description', $top->description) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab base margin --}}
                        <div class="tab-pane fade m-3" id="basemargin" role="tabpanel" aria-labelledby="basemargin-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="percent_id">Base Margin</label>
                                        <select class="form-select form-select-lg js-example-basic-single" id="percent_id"
                                            name="percent_id">
                                            <option value="">Select Base Margin</option>
                                            @foreach ($tgp_margins as $id => $margin_percentage)
                                                {{-- Logic 'selected' untuk menandai pilihan saat ini --}}
                                                <option value="{{ $id }}"
                                                    {{ old('percent_id', $top->percent_id) == $id ? 'selected' : '' }}>
                                                    {{ $margin_percentage }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="m-3">
                            <button type="submit" class="btn btn-primary me-2">Update Data</button>
                            <a href="{{ route('term-of-payment.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
