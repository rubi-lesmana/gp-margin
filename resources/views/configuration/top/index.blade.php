@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-equalizer"></i>
                </span> Top Management
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h4 class="card-title">List Data Top</h4>
                    </div>
                    <div class="col d-flex justify-content-end gap-2 p-2">
                        <a type="button" href="{{ route('term-of-payment.create') }}" class="btn btn-primary btn-sm"
                            title="Add Data">
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
                    <div class="col-12 table-responsive">
                        <table id="order-listing" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>No #</th>
                                    <th>Days</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $top)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $top->days }}</td>
                                        <td>{{ $top->description }}</td>
                                        <td>
                                            <span class="d-none">Edit</span>

                                            <a type="button" href="{{ route('term-of-payment.edit', $top->id) }}"
                                                class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                                title="Edit">
                                                <i
                                                    class="mdi mdi-pencil-outline position-absolute top-50 start-50 translate-middle"></i>
                                            </a>
                                            <span class="d-none">Delete</span>

                                            <a type="button"
                                                class="btn btn-gradient-danger btn-rounded btn-icon position-relative"
                                                data-bs-toggle="modal" data-bs-target="#delete_top{{ $top->id }}"
                                                title="Delete">
                                                <i
                                                    class="mdi mdi-delete-outline position-absolute top-50 start-50 translate-middle"></i>
                                            </a>

                                            <a type="button"
                                                class="btn btn-gradient-warning btn-rounded btn-icon position-relative"
                                                data-bs-toggle="modal" data-bs-target="#show_top{{ $top->id }}"
                                                title="Show">
                                                <i class="icon-eye position-absolute top-50 start-50 translate-middle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Modal View Add Data --}}
                        {{-- @include('configuration.top.create') --}}
                        {{-- @include('configuration.top.update') --}}
                        @include('configuration.top.delete')
                        @include('configuration.top.show')
                        {{-- End Modal View Add Data --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
