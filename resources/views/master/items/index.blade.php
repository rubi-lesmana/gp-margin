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
                    <div class="col-auto">
                        <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
                            Add Data<i class="mdi mdi-plus-box ms-1"></i>
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
                                        <th>Inventory</th>
                                        <th>Conversion</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td data-label="No #">{{ $loop->iteration }}</td>
                                            <td data-label="Item ID">{{ $item->item_id }}</td>
                                            <td data-label="Description" class="text-wrap">{{ $item->description }}</td>
                                            <td data-label="Inventory">{{ $item->unit->description }}</td>
                                            <td data-label="Conversion">{{ $item->unit_conversion->description ?? '-' }}</td>
                                            <td data-label="Action"> 
                                                <span class="d-none">Edit</span>

                                                <a type="button" href="{{ route('items.edit', $item->item_id) }}"
                                                    class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                                    title="Edit">
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

                                                <span class="d-none">Show</span>
                                                <a type="button" href="{{ route('items.show', $item->item_id) }}" 
                                                    class="btn btn-gradient-warning btn-rounded btn-icon position-relative"
                                                    title="Show">
                                                    <i
                                                        class="icon-eye position-absolute top-50 start-50 translate-middle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Modal View Add Data --}}
                        @include('master.items.delete')
                        {{-- End Modal View Add Data --}}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
