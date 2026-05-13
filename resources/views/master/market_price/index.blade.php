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
            <div class="col-md-7">
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
                                                <td data-label="No #">{{ $market_price->id_market_price }}</td>
                                                <td data-label="Effective Date">{{ $market_price->effective_date }}</td>
                                                <td class="text-wrap" style="max-width: 300px;" data-label="Description">
                                                    {{ $market_price->keterangan }}
                                                </td>
                                                <td data-label="Action">
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
            @include('master.market_price.detail.create')
        </div>
    </div>


    <script>
        const allDetails = @json($details);
        const updateBaseUrl = "{{ url('market-price-detail') }}";

        // ======= FORMAT NUMBER =======
        function formatNumber(value) {
            if (value === null || value === '' || value === undefined) return '';

            // Parse ke float lalu fix 2 desimal
            let parts = parseFloat(value).toFixed(2).split('.');

            // Pemisah ribuan: koma
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            // Gabung dengan titik sebagai desimal
            return parts[0] + '.' + parts[1];
        }

        function unformatNumber(value) {
            if (value === null || value === '' || value === undefined) return '';

            // Hapus koma (pemisah ribuan), titik tetap sebagai desimal
            return value.toString().replace(/,/g, '');
        }

        function applyFormatToInput(displayInput, hiddenInput) {
            displayInput.addEventListener('input', function() {
                // Ambil hanya angka dan titik
                let raw = this.value.replace(/,/g, '').replace(/[^0-9.]/g, '');

                // Pisahkan integer dan desimal
                let parts = raw.split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                // Maksimal 2 angka di belakang titik
                if (parts[1] !== undefined) {
                    parts[1] = parts[1].substring(0, 2);
                    this.value = parts[0] + '.' + parts[1];
                } else {
                    this.value = parts[0];
                }

                // Simpan nilai raw ke hidden input
                hiddenInput.value = unformatNumber(this.value);
            });
        }

        // Terapkan ke form CREATE
        document.querySelectorAll('#form-create tbody tr').forEach(function(row) {
            const displayInput = row.querySelector('.price-display');
            const hiddenInput = row.querySelector('.raw-price');
            if (displayInput && hiddenInput) {
                applyFormatToInput(displayInput, hiddenInput);
            }
        });

        // ======= BUTTON SETUP =======
        document.querySelectorAll('.btn-setup').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;

                document.getElementById('detail-id').textContent = id;
                document.getElementById('form-id-create').value = id;
                document.getElementById('form-id-edit').value = id;
                document.getElementById('detail-section').style.display = 'block';

                const existingDetails = allDetails.filter(d => d.market_price_id == id);

                if (existingDetails.length > 0) {
                    // ======= FORM EDIT (muncul meski price null) =======
                    document.getElementById('form-create').style.display = 'none';
                    document.getElementById('form-edit').style.display = 'block';
                    document.getElementById('form-edit-action').action = `${updateBaseUrl}/${id}`;

                    const tbody = document.getElementById('edit-tbody');
                    tbody.innerHTML = '';

                    existingDetails.forEach(function(detail, index) {
                        const itemDescription = detail.item ? detail.item.description : '-';

                        // ← Jika price null, tampilkan kosong bukan error
                        const rawPrice = (detail.price !== null && detail.price !== undefined) ?
                            unformatNumber(detail.price) :
                            '';
                        const formattedPrice = formatNumber(rawPrice);

                        tbody.innerHTML += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td data-label="Description" class="text-wrap" style="max-width: 300px;">
                            <input type="hidden"
                                name="details[${index}][id_detail]"
                                value="${detail.id}">
                            <input type="hidden"
                                name="details[${index}][item_id]"
                                value="${detail.item_id}">
                            ${itemDescription}
                        </td>
                        <td data-label="Price">
                            <input type="hidden"
                                name="details[${index}][price]"
                                class="raw-price-edit"
                                value="${rawPrice}">
                            <input type="text"
                                class="form-control form-control-sm price-display-edit"
                                value="${formattedPrice}"
                                placeholder="0"
                                autocomplete="off">
                        </td>
                    </tr>
                `;
                    });

                    // Bind format ke baris edit
                    document.querySelectorAll('#edit-tbody tr').forEach(function(row) {
                        const displayInput = row.querySelector('.price-display-edit');
                        const hiddenInput = row.querySelector('.raw-price-edit');
                        if (displayInput && hiddenInput) {
                            applyFormatToInput(displayInput, hiddenInput);
                        }
                    });

                } else {
                    // ======= FORM CREATE (belum ada data sama sekali) =======
                    document.getElementById('form-create').style.display = 'block';
                    document.getElementById('form-edit').style.display = 'none';
                }

                document.querySelectorAll('.btn-setup').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Tutup panel
        document.getElementById('btn-close-detail').addEventListener('click', function() {
            document.getElementById('detail-section').style.display = 'none';
            document.querySelectorAll('.btn-setup').forEach(b => b.classList.remove('active'));
        });
    </script>
@endsection
