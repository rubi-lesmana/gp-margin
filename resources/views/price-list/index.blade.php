@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class=" icon-list "></i>
                </span> Price List
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="price-list-table" class="table table-hover dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle">ID</th>
                                <th rowspan="2" class="align-middle">Item</th>
                                <th rowspan="2" class="align-middle">Market Price</th>
                                <th colspan="2" class="text-center">Selling Price</th>
                                <th rowspan="2" class="align-middle">Approved At</th>
                                <th rowspan="2" class="align-middle">Status</th>
                            </tr>
                            <tr>
                                <th class="text-end">Min</th>
                                <th class="text-end">Max</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $row)
                                <tr>
                                    <td data-label="ID">{{ $row->id_selling_price }}</td>
                                    <td data-label="Item" class="text-wrap">{{ $row->item_id }} - {{ $row->description }}
                                    </td>
                                    <td data-label="Market Price" class=" text-nowrap">
                                        @if ($row->market_price_snapshot)
                                            {{ number_format($row->market_price_snapshot, 2) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- SSP Min --}}
                                    <td data-label="Selling Price Min" class="text-end text-nowrap">
                                        @if ($row->ssp_min)
                                            {{ number_format($row->ssp_min, 2) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- SSP Max --}}
                                    <td data-label="Selling Price Max" class="text-end text-nowrap">
                                        @if ($row->ssp_max)
                                            <strong class="text-success">
                                                {{ number_format($row->ssp_max, 2) }}
                                            </strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- Approved At --}}
                                    <td data-label="Approved At" class="text-nowrap">
                                        @if ($row->approved_at)
                                            {{ \Carbon\Carbon::parse($row->approved_at)->format('d M Y') }}<br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($row->approved_at)->format('H:i') }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td data-label="Status">
                                        @if ($row->id_selling_price)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-secondary">Belum ada SSP</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Tidak ada data item.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- <div class="mt-3 justify-content-end d-flex">
                    {{ $items->links('components.pagination') }}
                </div> --}}
            </div>
        </div>
    </div>
@endsection
