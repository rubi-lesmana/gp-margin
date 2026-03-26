@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-basket"></i>
                </span> Create Market Price
            </h3>
        </div>
        <div class="row grid-margin">
            <div class="col-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Create</h4>
                        <form action="{{ route('market-price.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                {{-- Row 1 --}}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Item</label>
                                            <select class="form-control select2" id="item-id" name="item_id" required>
                                                <option value="">Pilih Item</option>
                                                    @foreach ($availableItem as $key => $title)
                                                        <option value="{{ $key }}" data-description="{{ $title }}">
                                                            {{ $key }} - {{ $title }}
                                                        </option>
                                                    @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <input class="form-control" id="description-item"
                                                    name="description" readonly>
                                            </input>
                                        </div>
                                    </div>
                                </div>
                                {{-- Row 2 --}}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Price</label>
                                            <input type="number" min="0" class="form-control" id="price" name="price" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan <span>(Optional)</span></label>
                                            <textarea class="form-control"
                                                    name="keterangan" rows="3" required>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>                                
                            </div>

                            <div class="d-flex justify-content-left mt-4">
                                <button type="submit" class="btn btn-primary me-3">Submit</button>
                                <a href="{{ route('market-price.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        // kalau pakai select2 pastikan sudah di-init
        $('#item-id').select2();

        $('#item-id').on('change', function () {
            let description = $(this).find(':selected').data('description');
            $('#description-item').val(description ?? '');
        });

    });
</script>
@endpush
