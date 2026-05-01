@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-calendar"></i>
                </span> Selling Price Product
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
                            <table id="order-listing" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No #</th>
                                        <th>Item ID</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>GP Margin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($gpMargins as $gpMargin)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $gpMargin->item_id }}</td>
                                            <td>{{ $gpMargin->description }}</td>
                                            <td>
                                                <span
                                                    class="badge 
                                                    @if ($gpMargin->status === 'Low') bg-warning
                                                    @elseif($gpMargin->status === 'High') bg-danger
                                                    @else bg-secondary @endif">
                                                    {{ $gpMargin->status }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($gpMargin->gp_margin, 2, ',', '.') }}%</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
