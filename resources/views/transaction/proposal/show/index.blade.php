@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-paper-plane"></i>
                </span> Detail Proposal
            </h3>
        </div>

        <div class="row">
            {{-- Header --}}
            <div class="col-12 col-md-4 mb-4">
                @include('transaction.proposal.show.header')
            </div>

            {{-- Detail Item --}}
            <div class="col-12 col-md-8 mb-4">
                @include('transaction.proposal.show.detail')
            </div>

            {{-- ── CARD SSP REFERENSI ───────────────────────────────── --}}
            {{-- @include('transaction.proposal.show.sellingprice') --}}
        </div>
    </div>

    {{-- Modal Reject --}}
    @include('transaction.proposal.modal.reject')
    {{-- Modal Approve --}}
    @include('transaction.proposal.modal.approve')
@endsection
