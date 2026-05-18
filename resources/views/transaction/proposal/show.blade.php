@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-paper-plane"></i>
                </span> Detail Pengajuan Harga
            </h3>
        </div>

        <div class="row">
            @include('transaction.proposal.detail.propose')

            {{-- ── CARD SSP REFERENSI ───────────────────────────────── --}}
            @include('transaction.proposal.detail.sellingprice')
        </div>
    </div>

    {{-- Modal Reject --}}
    @include('transaction.proposal.modal.reject')
    {{-- Modal Approve --}}
    @include('transaction.proposal.modal.approve')
@endsection
