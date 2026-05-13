@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-basket"></i>
                </span> Market Price Management
            </h3>
        </div>
        <div class="row">
            {{-- Market Price List (kiri) --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col">
                                <h4 class="card-title">Market Price List</h4>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#add_market_price">
                                    Add Data<i class="mdi mdi-plus-box ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>No #</th>
                                            <th>Effective Date</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $market_price)
                                            <tr>
                                                <td>{{ $market_price->id_market_price }}</td>
                                                <td>{{ $market_price->effective_date }}</td>
                                                <td class="text-wrap" style="max-width: 300px;">
                                                    {{ $market_price->keterangan }}</td>
                                                <td>
                                                    <div class="d-flex gap-1 flex-wrap">
                                                        <button type="button"
                                                            class="btn btn-gradient-success btn-rounded btn-icon"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit_market_price{{ $market_price->id_market_price }}"
                                                            title="Edit">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-gradient-danger btn-rounded btn-icon"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete_market_price_{{ $market_price->id_market_price }}"
                                                            title="Delete">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>

                                                        {{-- Hanya ambil ID --}}
                                                        <button type="button"
                                                            class="btn btn-gradient-warning btn-rounded btn-icon btn-setup"
                                                            data-id="{{ $market_price->id_market_price }}" title="Setup">
                                                            <i class="icon-wrench"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @include('master.market_price.create')
                            @include('master.market_price.update')
                            @include('master.market_price.delete')
                        </div>
                    </div>
                </div>
            </div>

            {{-- Market Price Detail (kanan) - HIDDEN BY DEFAULT --}}
            <div class="col-md-6" id="detail-section" style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Market Price Detail</h4>
                            <button type="button" class="btn-close" id="btn-close-detail" title="Close"></button>
                        </div>

                        <p class="text-muted">
                            ID: <strong id="detail-id">-</strong>
                        </p>

                        {{-- Form input di sini --}}
                        <form action="{{ route('market-price.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_market_price" id="form-id">

                            {{-- Tambahkan field form sesuai kebutuhan --}}
                            <div class="mb-3">
                                <label class="form-label">Field 1</label>
                                <input type="text" class="form-control" name="field1">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Field 2</label>
                                <input type="text" class="form-control" name="field2">
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Klik Setup → tampilkan panel kanan + isi ID
        document.querySelectorAll('.btn-setup').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;

                // Isi ID ke tampilan dan hidden input form
                document.getElementById('detail-id').textContent = id;
                document.getElementById('form-id').value = id;

                // Tampilkan kolom kanan
                document.getElementById('detail-section').style.display = 'block';

                // Highlight button aktif
                document.querySelectorAll('.btn-setup').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Klik tombol X → sembunyikan panel kanan
        document.getElementById('btn-close-detail').addEventListener('click', function() {
            document.getElementById('detail-section').style.display = 'none';
            document.querySelectorAll('.btn-setup').forEach(b => b.classList.remove('active'));
        });
    </script>
@endsection
