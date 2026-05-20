@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class=" mdi mdi-currency-usd"></i>
                </span> Cost price Management
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h4 class="card-title">List Data Cost Price </h4>
                    </div>
                    <div class="col d-flex justify-content-end gap-2 p-2">
                        <a href="{{ route('cost-price.create') }}" class="btn btn-primary btn-sm">
                            Add Data<i class=" mdi mdi-plus-box ms-1"></i>
                        </a>
                    </div>
                </div>
                <!-- Modal starts -->
                <div class="row">
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

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No #</th>
                                        <th>ID</th>
                                        <th>Arrival ID</th>
                                        <th>Date</th>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $cost_price)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $cost_price->id_cost_price }}</td>
                                            <td>{{ $cost_price->arrival_id }}</td>
                                            <td>{{ $cost_price->date }}</td>
                                            <td class="text-wrap">{{ $cost_price->item->description }}</td>
                                            <td>{{ number_format($cost_price->cost_price, 2, '.', ',') }}</td>
                                            <td>
                                                <span class="d-none">Edit</span>

                                                <a type="button"
                                                    class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                                    href="{{ route('cost-price.edit', $cost_price->id_cost_price) }}"
                                                    title="Edit">
                                                    <i
                                                        class="mdi mdi-pencil-outline position-absolute top-50 start-50 translate-middle"></i>
                                                </a>
                                                <span class="d-none">Delete</span>

                                                <a type="button"
                                                    class="btn btn-gradient-danger btn-rounded btn-icon position-relative"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#delete_cost_price{{ $cost_price->id_cost_price }}"
                                                    title="Delete">
                                                    <i
                                                        class="mdi mdi-delete-outline position-absolute top-50 start-50 translate-middle"></i>
                                                </a>
                                                <span class="d-none">Show</span>

                                                <a type="button"
                                                    class="btn btn-gradient-warning btn-rounded btn-icon position-relative"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#show_cost_price{{ $cost_price->id_cost_price }}"
                                                    title="Show">
                                                    <i
                                                        class="mdi mdi-eye-outline position-absolute top-50 start-50 translate-middle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Modal View Add Data --}}
                        @include('transaction.cost-price.show')
                        @include('transaction.cost-price.delete')
                        {{-- End Modal View Add Data --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
