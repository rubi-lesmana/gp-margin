@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-chart"></i>
                </span> Selling Price
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-2">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table table-hover dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="align-middle">ID</th>
                                        <th rowspan="2" class="align-middle">Date</th>
                                        <th rowspan="2" class="align-middle">Item</th>
                                        <th colspan="2" class="text-center">Suggested Selling Price</th>
                                        <th rowspan="2" class="align-middle">Status</th>
                                        <th rowspan="2" class="align-middle">Action</th>
                                    </tr>
                                    <tr>
                                        <th>Min</th>
                                        <th>Max</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($results as $row)
                                        <tr>
                                            {{-- ID --}}
                                            <td data-label="ID">
                                                @if ($row->status === 'draft')
                                                    {{ $row->id_cost_price }}
                                                @else
                                                    {{ $row->id_selling_price }}
                                                @endif
                                            </td>

                                            {{-- Date --}}
                                            <td data-label="Date">
                                                {{ $row->cost_price_date }}
                                            </td>

                                            {{-- Item --}}
                                            <td data-label="Item" class="text-wrap">
                                                {{ $row->item_id }} — {{ $row->description }}
                                            </td>

                                            {{-- SSP Min --}}
                                            <td data-label="Min">
                                                {{ $row->ssp_min ? number_format($row->ssp_min, 2) : '-' }}
                                            </td>

                                            {{-- SSP Max --}}
                                            <td data-label="Max">
                                                @if ($row->ssp_max)
                                                    <strong class="{{ $row->status === 'approved' ? 'text-success' : '' }}">
                                                        {{ number_format($row->ssp_max, 2) }}
                                                    </strong>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            {{-- Status --}}
                                            <td data-label="Status">
                                                @if ($row->status === 'draft')
                                                    <span class="badge badge-outline-warning badge-pill">Preview</span>
                                                @elseif($row->status === 'approved')
                                                    <span class="badge badge-outline-success badge-pill">Approved</span>
                                                @else
                                                    <span class="badge badge-outline-secondary badge-pill">Superseded</span>
                                                @endif
                                            </td>

                                            {{-- Action --}}
                                            <td data-label="Action">
                                                @if ($row->status === 'draft')
                                                    <a href="{{ route('selling-price.show', [
                                                        'itemId' => $row->item_id,
                                                        'costPriceId' => $row->id_cost_price,
                                                    ]) }}"
                                                        class="btn btn-gradient-warning btn-rounded btn-icon position-relative"
                                                        title="Review & Approve">
                                                        <i
                                                            class="icon-eye position-absolute top-50 start-50 translate-middle"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('selling-price.show.approved', [
                                                        'itemId' => $row->item_id,
                                                        'costPriceId' => $row->id_cost_price,
                                                        'sellingPriceId' => $row->id_selling_price,
                                                    ]) }}"
                                                        class="btn btn-gradient-info btn-rounded btn-icon position-relative"
                                                        title="Lihat Detail">
                                                        <i
                                                            class="icon-eye position-absolute top-50 start-50 translate-middle"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                Tidak ada data selling price.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            {{ $results->links('components.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
