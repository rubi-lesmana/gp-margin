@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-tag"></i>
                </span> Selling Price
            </h3>
        </div>

        <div class="row">
            <div class="col-md-5 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Selling Price</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th>Item ID</th>
                                    <td data-label="Item" class="text-wrap">
                                        {{ $header->item_id . ' — ' . $header->description }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td data-label="Date">{{ $header->cost_price_date }}</td>
                                </tr>
                                <tr>
                                    <th>Cost Price</th>
                                    <td data-label="Cost Price">{{ number_format($header->cost_price_snapshot, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Market Price</th>
                                    <td data-label="Market Price">
                                        @if ($header->market_price_snapshot)
                                            {{ number_format($header->market_price_snapshot, 2) }}
                                        @else
                                            <span class="badge bg-secondary">Belum ada</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            @if ($isDraft)
                                {{-- Draft → tampilkan tombol approve --}}
                                <form method="POST"
                                    action="{{ route('selling-price.approve', [
                                        'itemId' => $header->item_id,
                                        'costPriceId' => $header->id_cost_price,
                                    ]) }}">
                                    @csrf
                                    <button type="button" class="btn btn-gradient-danger" data-bs-toggle="modal"
                                        data-bs-target="#modalApprove">
                                        <i class="icon-check me-1"></i> Approve
                                    </button>

                                    @include('transaction.sellingprice.modal.approve')
                                </form>
                                <a href="{{ route('selling-price.index') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            @else
                                <a href="{{ route('selling-price.index') }}" class="btn btn-outline-secondary">
                                    Back
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Perhitungan berdasarkan Kategori --}}
            <div class="col-md-7 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Detail Suggested Selling Price</h6>

                        {{-- ── DETAIL PER CATEGORY ──────────────────────────────────────── --}}
                        @foreach ($detailsByCategory as $categoryStatus => $rows)
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        Category:
                                        <span class="badge bg-info">{{ $categoryStatus }}</span>
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>GP Margin</th>
                                                    <th>TOP (hari)</th>
                                                    <th class="text-wrap text-center">Target GP Margin</th>
                                                    <th class="text-wrap text-center">Adj GP Margin Price</th>
                                                    <th class="text-wrap text-center table-success">Suggested Selling Price
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rows as $row)
                                                    <tr data-bs-toggle="collapse"
                                                        data-bs-target="#detailCalculation{{ Str::slug($categoryStatus) }}{{ $loop->iteration }}"
                                                        style="cursor: pointer;">
                                                        <td data-label="GP Margin">{{ $row->gp_margin_pct }}</td>
                                                        <td data-label="TOP (hari)">{{ $row->top_days_snapshot }} hari</td>
                                                        <td data-label="Target GP Margin" class="text-wrap">
                                                            {{ $row->target_gp_pct }}</td>
                                                        <td data-label="Adj GP Margin Price">
                                                            {{ number_format($row->adj_gp_margin_price, 2) }}</td>
                                                        <td class="table-success d-flex justify-content-between align-items-center"
                                                            data-label="Suggested Selling Price">
                                                            <strong>
                                                                {{ number_format($row->suggested_selling_price, 2) }}
                                                            </strong>
                                                            <i class="mdi mdi-chevron-down"></i>
                                                        </td>
                                                    </tr>

                                                    {{-- Breakdown formula --}}
                                                    <tr class="detail-row">
                                                        <td colspan="5" class="p-0 border-0">
                                                            <div id="detailCalculation{{ Str::slug($categoryStatus) }}{{ $loop->iteration }}"
                                                                class="collapse">
                                                                <div class="p-3 bg-light border-top">
                                                                    <div class="d-flex flex-column gap-3">

                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-md-center border-bottom border-md-0 pb-2 pb-md-0">
                                                                            <div class="fw-bold text-secondary mb-1 mb-md-0"
                                                                                style="min-width: 180px;">
                                                                                GP Margin
                                                                            </div>
                                                                            <div class="text-nowrap overflow-x-auto py-1">
                                                                                <code
                                                                                    class="text-dark bg-white border rounded p-1 px-2 d-inline-block">
                                                                                    {{ $row->base_margin_pct }} &times;
                                                                                    {{ $row->category_calc_pct }} =
                                                                                    {{ $row->gp_margin_pct }}
                                                                                </code>
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-md-center border-bottom border-md-0 pb-2 pb-md-0">
                                                                            <div class="fw-bold text-secondary mb-1 mb-md-0"
                                                                                style="min-width: 180px;">
                                                                                Target GP Margin
                                                                            </div>
                                                                            <div class="text-nowrap overflow-x-auto py-1">
                                                                                <code
                                                                                    class="text-dark bg-white border rounded p-1 px-2 d-inline-block">
                                                                                    ({{ $row->top_days_snapshot }}/365 *
                                                                                    {{ $row->top_percentage }})
                                                                                    &plus; {{ $row->gp_margin_pct }} =
                                                                                    {{ $row->target_gp_pct }}
                                                                                </code>
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-md-center">
                                                                            <div class="fw-bold text-secondary mb-1 mb-md-0"
                                                                                style="min-width: 180px;">
                                                                                Adj GPM Price
                                                                            </div>
                                                                            <div class="text-nowrap overflow-x-auto py-1">
                                                                                <code
                                                                                    class="text-dark bg-white border rounded p-1 px-2 d-inline-block">
                                                                                    {{ number_format($header->cost_price_snapshot, 2) }}
                                                                                    &plus;
                                                                                    ({{ number_format($header->cost_price_snapshot, 2) }}
                                                                                    * {{ $row->target_gp_pct }}) =
                                                                                    {{ number_format($row->adj_gp_margin_price, 2) }}
                                                                                </code>
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-md-center">
                                                                            <div class="fw-bold text-secondary mb-1 mb-md-0"
                                                                                style="min-width: 180px;">
                                                                                SSP Basis
                                                                            </div>
                                                                            <div class="text-nowrap overflow-x-auto py-1">
                                                                                <code
                                                                                    class="text-dark bg-white border rounded p-1 px-2 d-inline-block">
                                                                                    @if ($row->ssp_basis === 'market_price')
                                                                                        <span class="badge bg-primary">
                                                                                            Market Price
                                                                                            ({{ number_format($header->market_price_snapshot, 2) }})
                                                                                        </span>
                                                                                    @else
                                                                                        <span
                                                                                            class="badge bg-warning text-dark">
                                                                                            Adj GP Margin Price
                                                                                        </span>
                                                                                    @endif
                                                                                </code>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
