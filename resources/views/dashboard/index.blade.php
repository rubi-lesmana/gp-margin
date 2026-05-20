@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-grid"></i>
                </span> Dashboard
            </h3>
        </div>

        {{-- Summary Cards --}}
        @include('dashboard.cards')

        {{-- ── ROW 2: CHART + ITEM NO SSP ─────────────────────────────── --}}
        {{-- <div class="row mb-4"> --}}

        {{-- Chart GP Compliance Distribution --}}
        {{-- <div class="col-12 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-title">Distribusi Posisi Harga Pengajuan</h6>
                        <canvas id="complianceChart" height="220"></canvas>
                    </div>
                </div>
            </div> --}}

        {{-- Chart Trend 6 Bulan --}}
        {{-- <div class="col-12 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-title">Trend Pengajuan 6 Bulan Terakhir</h6>
                        <canvas id="trendChart" height="220"></canvas>
                    </div>
                </div>
            </div> --}}

        {{-- </div> --}}

        {{-- ── ROW 3: PENDING + ITEM NO SSP ───────────────────────────── --}}
        <div class="row mb-4">
            {{-- Item SSP --}}
            {{-- Item Sudah Memiliki SSP --}}
            <div class="col-12 col-md-7 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">
                                Product already have SSP
                                @if ($totalItemWithSsp > 0)
                                    <span class="badge bg-primary ms-1">
                                        {{ $totalItemWithSsp }}
                                    </span>
                                @endif
                            </h6>
                            <!-- Link diarahkan ke halaman price-list utama dengan filter approved -->
                            <a href="{{ route('price-list.index', ['status' => 'approved']) }}"
                                class="btn btn-sm btn-outline-primary">View All</a>
                        </div>

                        @if ($itemsWithSsp->isEmpty())
                            <div class="text-center text-muted py-4">
                                <i class="mdi mdi-tag-off-outline" style="font-size:32px;color:#dc3545"></i>
                                <p class="mt-2">Belum ada item yang memiliki SSP disetujui.</p>
                            </div>
                        @else
                            {{-- Menggunakan scroll-box agar serasi dengan tabel 'Item Belum Ada SSP' --}}
                            <div style="max-height:280px;overflow-y:auto">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light text-nowrap" style="position: sticky; top: 0; z-index: 1;">
                                        <tr>
                                            <th>Item ID</th>
                                            <th>Description</th>
                                            <th class="text-end">SSP Min</th>
                                            <th class="text-end">SSP Max</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($itemsWithSsp as $item)
                                            <tr>
                                                <td>
                                                    <small class="font-weight-bold">{{ $item->item_id }}</small>
                                                </td>
                                                <td>
                                                    <small class="text-wrap d-block" style="max-width: 200px;">
                                                        {{ $item->description }}
                                                    </small>
                                                </td>
                                                <!-- Angka diformat mata uang dengan desimal sesuai struktur database -->
                                                <td class="text-end text-nowrap text-success">
                                                    <small>{{ number_format($item->ssp_min, 2) }}</small>
                                                </td>
                                                <td class="text-end text-nowrap text-danger">
                                                    <small>{{ number_format($item->ssp_max, 2) }}</small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Item tanpa SSP --}}
            <div class="col-12 col-md-5 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">
                                Item does not have SSP
                                @if ($totalItemWithoutSsp > 0)
                                    <span class="badge bg-warning text-dark ms-1">
                                        {{ $totalItemWithoutSsp }}
                                    </span>
                                @endif
                            </h6>
                            <a href="{{ route('price-list.index', ['status' => 'no_ssp']) }}"
                                class="btn btn-sm btn-outline-warning">View All</a>
                        </div>

                        @if ($itemsWithoutSsp->isEmpty())
                            <div class="text-center text-muted py-4">
                                <i class="mdi mdi-tag-check-outline" style="font-size:32px;color:#28a745"></i>
                                <p class="mt-2">Semua item sudah memiliki SSP.</p>
                            </div>
                        @else
                            <div style="max-height:280px;overflow-y:auto">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item ID</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($itemsWithoutSsp as $item)
                                            <tr>
                                                <td><small>{{ $item->item_id }}</small></td>
                                                <td>
                                                    <small class="text-wrap">{{ $item->description }}</small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- ── ROW 4: RECENT ACTIVITY ──────────────────────────────────── --}}
        @include('dashboard.table   ')

    </div>
@endsection

@push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script>
        // ── Chart 1: Distribusi posisi harga ─────────────────────────────────
        const complianceCtx = document.getElementById('complianceChart').getContext('2d');
        new Chart(complianceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Di atas Max', 'Tepat Max', 'Antara Min-Max', 'Di bawah Min'],
                datasets: [{
                    data: [
                        {{ $complianceChart['above_max'] }},
                        {{ $complianceChart['at_max'] }},
                        {{ $complianceChart['between'] }},
                        {{ $complianceChart['below_min'] }},
                    ],
                    backgroundColor: ['#0d6efd', '#198754', '#0dcaf0', '#dc3545'],
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                                return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });

        // ── Chart 2: Trend 6 bulan ────────────────────────────────────────────
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'bar',
            data: {
                labels: {!! $trendData->pluck('month')->toJson() !!},
                datasets: [{
                        label: 'Compliant',
                        data: {!! $trendData->pluck('compliant')->toJson() !!},
                        backgroundColor: '#198754',
                        borderRadius: 4,
                    },
                    {
                        label: 'Below Min',
                        data: {!! $trendData->pluck('below_min')->toJson() !!},
                        backgroundColor: '#dc3545',
                        borderRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
