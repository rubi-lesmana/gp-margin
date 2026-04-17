@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-tag"></i>
                </span> Item Management
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h4 class="card-title">List Data Item</h4>
                    </div>
                    <div class="col d-flex justify-content-end gap-2 p-2">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#add_item">
                            Add Data<i class=" mdi mdi-plus-box ms-1"></i>
                        </button>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->item_id }}</td>
                                            <td>{{ $item->description }}</td>
                                            {{-- <td>{{ $data->total_course }}</td> --}}
                                            <td>
                                                <span class="d-none">Edit</span>

                                                <a type="button"
                                                    class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#edit_item{{ $item->safe_item_id }}" title="Edit">
                                                    <i
                                                        class="mdi mdi-pencil-outline position-absolute top-50 start-50 translate-middle"></i>
                                                </a>
                                                <span class="d-none">Delete</span>

                                                <a type="button"
                                                    class="btn btn-gradient-danger btn-rounded btn-icon position-relative"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#delete_item{{ $item->safe_item_id }}" title="Delete">
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
                        @include('master.items.create')
                        @include('master.items.update')
                        @include('master.items.delete')
                        {{-- End Modal View Add Data --}}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
