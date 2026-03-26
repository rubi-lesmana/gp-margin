@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-basket"></i>
                </span> Market Price  Management
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h4 class="card-title">List Data Market Price </h4>
                    </div>
                    <div class="col d-flex justify-content-end gap-2 p-2">
                        <a href="{{ route('market-price.create') }}" class="btn btn-primary btn-sm">
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
                                    <th>Item ID</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $mp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mp->item_id }}</td>
                                        <td>{{ $mp->item->description }}</td>
                                        <td>Rp {{ number_format($mp->price, 0, ',', '.') }}</td>
                                        <td>{{ $mp->keterangan }}</td>
                                        <td>
                                            <span class="d-none">Edit</span>

                                            <a type="button"
                                                class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                                data-bs-toggle="modal" data-bs-target="#edit_mp{{ $mp->id }}"
                                                title="Edit">
                                                <i
                                                    class="mdi mdi-pencil-outline position-absolute top-50 start-50 translate-middle"></i>
                                            </a>
                                            <span class="d-none">Delete</span>

                                            <a type="button"
                                                class="btn btn-gradient-danger btn-rounded btn-icon position-relative"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete_mp{{ $mp->id }}" title="Delete">
                                                <i
                                                    class="mdi mdi-delete-outline position-absolute top-50 start-50 translate-middle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Modal View Add Data --}}
                        @include('master.market_price.update')
                        @include('master.market_price.delete')
                        {{-- End Modal View Add Data --}}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
