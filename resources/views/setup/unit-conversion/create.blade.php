@extends('partials.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="icon-basket"></i>
                </span> Create Unit Conversion
            </h3>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('unit-conversions.store') }}" method="POST">
            @csrf
            <div class="row">

                {{-- Kolom 1 Header --}}
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Form Create</h4>

                            <div class="mb-3">
                                <label class="form-label">ID Unit Conversion</label>
                                <input class="form-control" name="id_unit_conversion" readonly
                                       value="{{ old('id_unit_conversion', $nextId ) }}" />
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" placeholder="Description"
                                          rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom 2 Details --}}
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="card-title mb-0">Detail</h6>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddRow">
                                    <i class="ti ti-plus me-1"></i> Add Row
                                </button>
                            </div>

                            <div id="detailWrapper">
                                {{-- Baris pertama (default, tidak bisa dihapus) --}}
                                <div class="row detail-row mb-3">
                                    <div class="col-12 col-md-4 mb-3 mb-md-0">
                                        <label class="form-label">Unit ID</label>
                                        <select class="form-select select2" name="unit_id[]" required>
                                            <option value="">-- Select Unit --</option>
                                            @foreach($unit as $description => $unit_id)
                                                <option value="{{ $unit_id }}">{{ $description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                                        <label class="form-label">Conversion Value</label>
                                        <input class="form-control" type="number" name="conversion_value[]"
                                               placeholder="Conversion Value" step="0.01" min="0" required>
                                    </div>
                                    <div class="col-12 col-md-2 d-flex flex-column">
                                        <label class="form-label d-none d-md-block">&nbsp;</label>
                                        <button type="button" class="btn btn-inverse-danger btn-icon btn-remove-row" disabled>
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
                                <button type="submit" class="btn btn-primary w-sm-auto">Save</button>
                                <a href="{{ route('unit-conversions.index') }}" class="btn btn-secondary w-sm-auto">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Template baris baru, dipakai untuk cloning --}}
    <template id="rowTemplate">
        <div class="row detail-row mb-3">
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                {{-- <label class="form-label">Unit ID</label> --}}
                <select class="form-select select2" name="unit_id[]" required>
                    <option value="">-- Select Unit --</option>
                    @foreach($unit as $description => $unit_id)
                        <option value="{{ $unit_id }}">{{ $description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 mb-3 mb-md-0">
                {{-- <label class="form-label">Conversion Value</label> --}}
                <input class="form-control" type="number" name="conversion_value[]"
                       placeholder="Conversion Value" step="0.01" min="0" required>
            </div>
            <div class="col-12 col-md-2 d-flex flex-column">
                {{-- <label class="form-label d-none d-md-block">&nbsp;</label> --}}
                <button type="button" class="btn btn-inverse-danger btn-icon btn-remove-row">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        </div>
    </template>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const wrapper  = document.getElementById('detailWrapper');
        const template = document.getElementById('rowTemplate');
        const btnAdd   = document.getElementById('btnAddRow');

        function initSelect2(scope) {
            if (window.jQuery && jQuery.fn.select2) {
                jQuery(scope).find('.select2').select2({
                    width: '100%'
                });
            }
        }

        function toggleRemoveButtons() {
            const rows = wrapper.querySelectorAll('.detail-row');
            rows.forEach(function (row) {
                row.querySelector('.btn-remove-row').disabled = rows.length <= 1;
            });
        }

        // Init select2 untuk baris pertama yang sudah ada di DOM
        initSelect2(wrapper);

        btnAdd.addEventListener('click', function () {
            const clone = template.content.cloneNode(true);
            wrapper.appendChild(clone);

            const lastRow = wrapper.querySelector('.detail-row:last-child');
            initSelect2(lastRow);
            toggleRemoveButtons();
        });

        wrapper.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-remove-row');
            if (btn) {
                const row = btn.closest('.detail-row');
                const select = row.querySelector('.select2');
                if (window.jQuery && jQuery.fn.select2) {
                    jQuery(select).select2('destroy');
                }
                row.remove();
                toggleRemoveButtons();
            }
        });

        toggleRemoveButtons();
    });
</script>
@endpush