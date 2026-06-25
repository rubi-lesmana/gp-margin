@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class=" icon-list "></i>
                </span> Detail Price List
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <div class="col">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded"
                                style="width:40px; height:40px; background:#E6F1FB; flex-shrink:0;">
                                <i class="icon-tag" style="font-size:20px; color:#185FA5;"></i>
                            </div>
                            <div>
                                <h4 class="card-title mb-0">{{ $data->first()->description ?? '-' }}</h4>
                                <span class="text-muted" style="font-size:12px;">
                                    {{ $data->first()->item_id ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <a href="{{ route('price-list.index') }}" class="btn btn-gradient-primary btn-sm">
                            <i class="icon-action-undo ms-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="row">
                    @foreach ($detailsCategory as $categoryStatus => $row)
                        <div class="col-md-4">
                            <div class="border rounded p-3" style="border-color: #D0E4F7 !important;">
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="d-flex align-items-center justify-content-center rounded"
                                                style="width:32px; height:32px; background:#E6F1FB; flex-shrink:0;">
                                                <i class="ti ti-tag" style="font-size:18px; color:#185FA5;"></i>
                                            </div>
                                            <div class="fw-medium">{{ $categoryStatus }}</div>
                                            <span class="badge rounded-pill ms-auto"
                                                style="font-size:10px; background:#E6F1FB; color:#185FA5;">
                                                Category
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="text-muted">
                                                <tr>
                                                    <th>TOP</th>
                                                    <th class="text-wrap text-center">Adj GP Margin Price</th>
                                                    <th class="text-wrap text-center">Suggested Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($row as $detail)
                                                    <tr>
                                                        <td data-label="TOP">{{ $detail->top_days_snapshot }} Days
                                                        </td>
                                                        <td data-label="Adj GP Margin Price" class="text-end">
                                                            {{ number_format($detail->adj_gp_margin_price, 2) }}
                                                        </td>
                                                        <td data-label="Suggested Price" class="text-end">
                                                            {{ number_format($detail->suggested_selling_price, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
