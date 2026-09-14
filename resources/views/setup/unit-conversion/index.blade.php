@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-wrench"></i>
                </span> Unit Conversion Management
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h4 class="card-title">List Data Unit Conversion</h4>
                    </div>
                    <div class="col-auto">
                        <a type="button" href="{{ route('unit-conversions.create') }}" class="btn btn-gradient-primary btn-sm">
                            Add Data<i class=" mdi mdi-plus-box ms-1"></i>
                        </a>
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

                    <div class="col-12 table-responsive">
                        <table id="order-listing" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>No #</th>
                                    <th>Unit Conversion ID</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $unitConversion)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $unitConversion->id_unit_conversion }}</td>
                                        <td>{{ $unitConversion->description }}</td>
                                        <td>
                                            <span class="d-none">Edit</span>

                                            <a type="button"
                                                class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                                href="{{ route('unit-conversions.edit', $unitConversion->id_unit_conversion) }}"
                                                title="Edit">
                                                <i
                                                    class="mdi mdi-pencil-outline position-absolute top-50 start-50 translate-middle"></i>
                                            </a>                                            

                                            <span class="d-none">Delete</span>

                                            <a type="button"
                                                class="btn btn-gradient-danger btn-rounded btn-icon position-relative"
                                                data-bs-toggle="modal" data-bs-target="#delete_unit{{ $unitConversion->id_unit_conversion }}"
                                                title="Delete">
                                                <i
                                                    class="mdi mdi-delete-outline position-absolute top-50 start-50 translate-middle"></i>
                                            </a>

                                            <span class="d-none">Show</span>

                                            <a type="button"
                                                class="btn btn-gradient-info btn-rounded btn-icon position-relative"
                                                data-bs-toggle="modal" data-bs-target="#show_unit{{ $unitConversion->id_unit_conversion }}"
                                                title="Show">
                                                <i
                                                    class="mdi mdi-eye position-absolute top-50 start-50 translate-middle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Modal View Add Data --}}
                        @include('setup.unit-conversion.show')                        
                        @include('setup.unit-conversion.delete')
                        {{-- End Modal View Add Data --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
