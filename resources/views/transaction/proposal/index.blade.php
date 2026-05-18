@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-paper-plane"></i>
                </span> Pengajuan Harga
            </h3>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mb-3 align-items-center"> <!-- Ditambah align-items-center agar rata tengah vertikal -->
                    <div class="col">
                        <h4 class="card-title mb-0">List Pengajuan Harga</h4>
                        <!-- mb-0 dihapus margin bawaannya agar sejajar sempurna -->
                    </div>
                    <div class="col-auto">
                        <!-- Tambahkan d-flex dan gap di kontainer utama kolom agar form dan tombol bersebelahan -->
                        <div class="d-flex align-items-center gap-2">
                            {{-- Filter --}}
                            <!-- Hapus mb-3 pada form agar tidak merusak alignment vertikal -->
                            <form method="GET" class="d-flex align-items-center gap-2 mb-0">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        @if (request('status'))
                                            {{ request('status') }}
                                        @else
                                            Semua Status
                                        @endif
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item {{ !request('status') ? 'active' : '' }}"
                                            href="{{ route('proposal.index', request()->except(['status', 'page'])) }}">
                                            Semua
                                        </a>
                                        <a class="dropdown-item {{ request('status') === 'pending_approval' ? 'active' : '' }}"
                                            href="{{ route('proposal.index', array_merge(request()->except(['status', 'page']), ['status' => 'pending_approval'])) }}">
                                            Pending Approval
                                        </a>
                                        <a class="dropdown-item {{ request('status') === 'approved' ? 'active' : '' }}"
                                            href="{{ route('proposal.index', array_merge(request()->except(['status', 'page']), ['status' => 'approved'])) }}">
                                            Approved
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item {{ request('status') === 'rejected' ? 'active' : '' }}"
                                            href="{{ route('proposal.index', array_merge(request()->except(['status', 'page']), ['status' => 'rejected'])) }}">
                                            Rejected
                                        </a>
                                    </div>
                                </div>
                                @if (request('search') || request('status'))
                                    <a href="{{ route('proposal.index') }}"
                                        class="btn btn-sm btn-outline-secondary">Reset</a>
                                @endif
                            </form>

                            <!-- Tombol sekarang sejajar di sebelah kanan form filter -->
                            <a href="{{ route('proposal.create') }}" class="btn btn-gradient-primary btn-sm">
                                <i class="icon-plus me-1"></i> Buat Pengajuan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="order-listing" class="table table-hover dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Request</th>
                                <th>Customer</th>
                                <th>Item</th>
                                <th>Harga Pengajuan</th>
                                <th>Selisih</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proposals as $row)
                                <tr>
                                    <td data-label="No">{{ $loop->iteration }}</td>
                                    <td data-label="ID" class="text-wrap">{{ $row->id_proposal }}</td>
                                    <td data-label="Customer" class="text-wrap">{{ $row->customer->name }}</td>
                                    <td data-label="Item" class="text-wrap">{{ $row->item->description }}</td>
                                    <td data-label="Harga Pengajuan" class="text-nowrap">
                                        <strong class="{{ $row->is_below_ssp ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($row->proposed_price, 2) }}
                                        </strong>
                                    </td>
                                    <td data-label="Selisih" class="text-nowrap">
                                        <span class="{{ $row->price_diff >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $row->price_diff >= 0 ? '+' : '' }}{{ number_format($row->price_diff, 2) }}<br>
                                            <small>
                                                {{ $row->price_diff >= 0 ? '+' : '' }}{{ number_format($row->price_diff_pct, 2) }}%
                                            </small>
                                        </span>
                                    </td>
                                    <td data-label="Status" class="badge-status">
                                        <span class="badge {{ $row->status_badge }}">
                                            {{ $row->status_label }}
                                        </span>
                                    </td>
                                    <td data-label="Action">
                                        <a href="{{ route('proposal.show', $row->id_proposal) }}"
                                            class="btn btn-gradient-info btn-rounded btn-icon position-relative"
                                            title="Detail">
                                            <i class="icon-eye position-absolute top-50 start-50 translate-middle"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
