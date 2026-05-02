{{-- <div class="modal fade" id="add_top" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-2">Add TOP</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" action="{{ route('term-of-payment.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="days">Days</label>
                        <input type="number" class="form-control" id="days" name="days" placeholder="Days"
                            @error('days') is-invalid
                                 @enderror
                            value="{{ old('days') }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Description"
                            @error('description') is-invalid                              
                                 @enderror
                            value="{{ old('description') }}">
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}
{{-- End Modal --}}

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
                <h4 class="card-title">Add Term Of Payment</h4>
                <p class="card-description">Fill in the details below to add a new term of payment.</p>
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

                {{-- Detail Tab Content --}}
                <form class="forms-sample" action="{{ route('term-of-payment.store') }}" method="POST">
                    @csrf
                    <div class="tab-content">
                        {{-- Tab Data Item --}}
                        <div class="tab-pane fade show active m-3" id="generaltop" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="days">Days</label>
                                        <input type="number" class="form-control" id="days" name="days"
                                            placeholder="Days"
                                            @error('days') is-invalid
                                 @enderror
                                            value="{{ old('days') }}">
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
                                        <select class="form-select form-select-lg js-example-basic-single" id="percent_id"
                                            name="percent_id">
                                            <option value="">Select Base Margin</option>
                                            @foreach ($tgp_margins as $key => $margin_percentage)
                                                <option value="{{ $key }}">{{ $margin_percentage }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="m-3">
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('term-of-payment.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
