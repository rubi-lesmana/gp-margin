@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-paper-plane"></i>
                </span> Price Proposal
            </h3>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Price Proposal List</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('proposal.create') }}" class="btn btn-gradient-primary btn-sm">
                            <i class="icon-plus me-1"></i> Create
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="order-listing" class="table table-hover dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Request ID</th>
                                <th>Customer</th>
                                <th>TOP (Days)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proposals as $row)
                                <tr>
                                    <td data-label="No">{{ $loop->iteration }}</td>

                                    <td data-label="ID" class="text-wrap">
                                        {{ $row->id_proposal }}
                                    </td>

                                    <td data-label="Customer" class="text-wrap">
                                        {{ $row->customer->name }}
                                    </td>

                                    <td data-label="TOP">
                                        {{ $row->top_days_snapshot }} hari
                                    </td>

                                    <td data-label="Status" class="badge-status">
                                        <span class="badge {{ $row->status_badge }}">
                                            {{ $row->status_label }}
                                        </span>
                                    </td>

                                    <td data-label="Action">
                                        <a href="{{ route('proposal.show', $row->id_proposal) }}"
                                            class="btn btn-gradient-info btn-rounded btn-icon position-relative"
                                            title="Detail">
                                            <i class="icon-eye position-absolute top-50 start-50 translate-middle"></i>
                                        </a>
                                        <a href="{{ route('proposal.edit', $row->id_proposal) }}"
                                            class="btn btn-gradient-warning btn-rounded btn-icon position-relative"
                                            title="Edit">
                                            <i class="icon-pencil position-absolute top-50 start-50 translate-middle"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
