@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-user"></i>
                </span> Customer Management
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h4 class="card-title">List Data Customer</h4>
                    </div>
                    <div class="col d-flex justify-content-end gap-2 p-2">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#add_customer">
                            Add Data<i class=" mdi mdi-plus-box ms-1"></i>
                        </button>
                    </div>
                </div>
                <!-- Modal starts -->
                <div class="row">
                    {{-- Notifikasi Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- TAMBAHKAN KODE INI: Notifikasi Sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="col-12 table-responsive">
                        <table id="order-listing" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>No #</th>
                                    <th>Customer ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $customer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $customer->id_customer }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>
                                            <span class="d-none">Edit</span>

                                            <a type="button"
                                                class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                                data-bs-toggle="modal"
                                                data-bs-target="#edit_customer{{ $customer->safe_id_customer }}"
                                                title="Edit">
                                                <i
                                                    class="mdi mdi-pencil-outline position-absolute top-50 start-50 translate-middle"></i>
                                            </a>
                                            <span class="d-none">Delete</span>

                                            <a type="button"
                                                class="btn btn-gradient-danger btn-rounded btn-icon position-relative"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete_customer{{ $customer->safe_id_customer }}"
                                                title="Delete">
                                                <i
                                                    class="mdi mdi-delete-outline position-absolute top-50 start-50 translate-middle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Modal View Add Data --}}
                        @include('master.customer.create')
                        @include('master.customer.update')
                        @include('master.customer.delete')
                        {{-- End Modal View Add Data --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
