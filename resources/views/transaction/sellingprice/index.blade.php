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
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h4 class="card-title">List Data Selling Price</h4>
                    </div>
                </div>
                <div class="row">
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
                                        <th colspan="2" class="text-center">SuggestedSelling Price</th>
                                        <th rowspan="2" class="align-middle">Status</th>
                                        <th rowspan="2" class="align-middle">Action</th>
                                    </tr>
                                    <tr>
                                        <th>Min</th>
                                        <th>Max</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($drafts as $draft)
                                        <tr>
                                            <td data-label="ID">{{ $draft->id_cost_price }}</td>
                                            <td data-label="Date">{{ $draft->cost_price_date }}</td>
                                            <td data-label="Item" class="text-wrap">{{ $draft->item_id }} —
                                                {{ $draft->description }}</td>
                                            <td data-label="Min">{{ number_format($draft->ssp_min, 2) }}</td>
                                            <td data-label="Max">{{ number_format($draft->ssp_max, 2) }}</td>
                                            <td data-label="Status">
                                                <span class="badge badge-outline-warning badge-pill">Preview</span>
                                            </td>
                                            <td data-label="Action">
                                                <a href="{{ route('selling-price.show', [
                                                    'itemId' => $draft->item_id,
                                                    'costPriceId' => $draft->id_cost_price,
                                                ]) }}"
                                                    class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                                    title="Show"><i
                                                        class="icon-eye position-absolute top-50 start-50 translate-middle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                Tidak ada item yang menunggu approval.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            {{ $drafts->links('components.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
