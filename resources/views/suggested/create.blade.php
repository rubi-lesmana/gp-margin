@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-basket"></i>
                </span> Create Inventory Arrival
            </h3>
        </div>
        <div class="row grid-margin">
            <div class="col-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Create</h4>
                        <form action="{{ route('arrival-inventory.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                {{-- Row 1 --}}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Item</label>
                                            <select class="form-control select2" id="item-id" name="item_id" required>
                                                <option value="">Select Item</option>
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
                                            <label class="form-label">Status</label>
                                            <select class="form-control select2" type="text" min="0" class="form-control" id="status" name="status" required>
                                                <option value="">Select Status</option>
                                                <option value="Local">Local</option>
                                                <option value="Import">Import</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" min="0" class="form-control"
                                                    name="quantity" required>
                                            </input>
                                        </div>
                                    </div>
                                </div>                                
                                {{-- Row 3 --}}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date Arrival</label>
                                            <input type="date" min="0" class="form-control" id="date" name="date" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Manual Reference <span>(Optional)</span></label>
                                            <textarea class="form-control"
                                                    name="keterangan" rows="3">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>                                
                            </div>

                            <div class="d-flex justify-content-left mt-4">
                                <button type="submit" class="btn btn-primary me-3">Submit</button>
                                <a href="{{ route('arrival-inventory.index') }}" class="btn btn-danger">Cancel</a>
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
$(function () {
  $('#item-id').select2({
    width: '100%',
    templateResult: function (data) {
      // tampilan DI dropdown list -> tetap "itemid - description"
      return data.text;
    },
    templateSelection: function (data) {
      // tampilan SETELAH dipilih (kotak select) -> hanya itemid
      return data.id || data.text; // untuk placeholder
    }
  });

  // isi otomatis input description
  $('#item-id').on('change', function () {
    let description = $(this).find(':selected').attr('data-description');
    $('#description-item').val(description ?? '');
  });
});
</script>
@endpush

