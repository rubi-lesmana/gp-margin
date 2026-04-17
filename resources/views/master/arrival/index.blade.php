@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-calendar"></i>
                </span> Inventory Arrival Management
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h4 class="card-title">List Data Inventory Arrival </h4>
                    </div>
                    <div class="col d-flex justify-content-end gap-2 p-2">
                        <a href="{{ route('arrival-inventory.create') }}" class="btn btn-primary btn-sm">
                            Add Data<i class=" mdi mdi-plus-box ms-1"></i>
                        </a>
                    </div>
                </div>
                <!-- Modal starts -->
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
                                        <th>Quantity</th>
                                        <th>Date Arrival</th>
                                        <th class="col-wrap">Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $arrival)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $arrival->item_id }}</td>
                                            <td>{{ $arrival->item->description }}</td>
                                            <td>{{ $arrival->status }}</td>
                                            <td>{{ number_format($arrival->quantity, 0, ',', '.') }}</td>
                                            <td>{{ $arrival->date }}</td>
                                            <td class="col-wrap">{{ $arrival->keterangan }}</td>
                                            <td>
                                                <span class="d-none">Edit</span>

                                                <a type="button"
                                                    class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                                    data-bs-toggle="modal" data-bs-target="#edit_arrival{{ $arrival->id }}"
                                                    title="Edit">
                                                    <i
                                                        class="mdi mdi-pencil-outline position-absolute top-50 start-50 translate-middle"></i>
                                                </a>
                                                <span class="d-none">Delete</span>

                                                <a type="button"
                                                    class="btn btn-gradient-danger btn-rounded btn-icon position-relative"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#delete_arrival{{ $arrival->id }}" title="Delete">
                                                    <i
                                                        class="mdi mdi-delete-outline position-absolute top-50 start-50 translate-middle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Modal View Add Data --}}
                        @include('master.arrival.update')
                        @include('master.arrival.delete')
                        {{-- End Modal View Add Data --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
