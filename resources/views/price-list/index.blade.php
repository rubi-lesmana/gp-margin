@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class=" icon-list "></i>
                </span> Price List
            </h3>
            <form method="GET" class="d-flex justify-content-end gap-2">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-ls"
                    style="max-width:220px" placeholder="Cari item ID / nama...">

                <div class="dropdown">
                    <button class="btn btn-light btn-md dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class=" mdi mdi-filter-outline"></i>
                        @if (request('status') === 'approved')
                            <span>Has SSP</span>
                        @elseif(request('status') === 'no_ssp')
                            <span>No SSP</span>
                        @else
                            <span>All</span>
                        @endif
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{ !request('status') ? 'active' : '' }}"
                            href="{{ route('price-list.index', request()->except(['status', 'page'])) }}">
                            All Item
                        </a>
                        <a class="dropdown-item {{ request('status') === 'approved' ? 'active' : '' }}"
                            href="{{ route('price-list.index', array_merge(request()->except(['status', 'page']), ['status' => 'approved'])) }}">
                            Approved
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ request('status') === 'no_ssp' ? 'active' : '' }}"
                            href="{{ route('price-list.index', array_merge(request()->except(['status', 'page']), ['status' => 'no_ssp'])) }}">
                            No SSP yet
                        </a>
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="icon-magnifier"></i>
                </button>

                @if (request('search') || request('status'))
                    <a href="{{ route('price-list.index') }}" class="btn btn-md btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th rowspan="2">Item</th>
                                <th rowspan="2">Description</th>
                                <th rowspan="2">Market Price</th>
                                <th colspan="2" class="text-center">Selling Price</th>
                                <th rowspan="2">Approved At</th>
                                <th rowspan="2">Status</th>
                            </tr>
                            <tr>
                                <th class="text-end">Min</th>
                                <th class="text-end">Max</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $row)
                                <tr>
                                    <td data-label="Item">{{ $row->item_id }}</td>
                                    <td data-label="Description" class="text-wrap">{{ $row->description }}</td>
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

                <div class="mt-3 justify-content-end d-flex">
                    {{ $items->links('components.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
