<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Stock On Hand</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h4 class="mb-4">Stock On Hand</h4>

        {{-- Form Filter --}}
        <form method="GET" action="{{ route('stock.get') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="date" value="{{ $date }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Location ID</label>
                <input type="text" name="locationId" value="{{ $locationId }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Item ID</label>
                <input type="text" name="itemId" value="{{ $itemId }}" class="form-control">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </form>

        {{-- Hasil --}}
        @if (!$result['success'])
            <div class="alert alert-danger">
                ⚠️ {{ $result['message'] ?? 'Terjadi kesalahan.' }}
                @isset($result['status'])
                    <small class="d-block text-muted">HTTP Status: {{ $result['status'] }}</small>
                @endisset
            </div>
        @else
            <div class="alert alert-success">Data berhasil dimuat.</div>

            <div class="card">
                <div class="card-header fw-bold">Hasil Stock On Hand</div>
                <div class="card-body">
                    <pre class="mb-0">{{ json_encode($result['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            </div>
        @endif
    </div>
</body>

</html>
