@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-call-missed"></i>
                </span> Base Margin Management
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Base Margin Percentage</h4>
                <p class="card-description">Manage the base margin percentages for your calculations.</p>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#gpmargin" role="tab"
                            aria-controls="home" aria-selected="true">GP Margin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="targetgp-tab" data-bs-toggle="tab" href="#targetgp" role="tab"
                            aria-controls="profile" aria-selected="false">Target GP</a>
                    </li>
                </ul>

                {{-- Detail Tab Content --}}
                <div class="tab-content">
                    @include('configuration.basemargin.gpmargin.index')
                    @include('configuration.basemargin.targetgp.index')
                </div>
            </div>
        </div>
    </div>
@endsection
