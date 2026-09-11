@foreach ($data as $unitConversion)
    <div class="modal fade" id="delete_unit{{ $unitConversion->id_unit_conversion }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Delete Unit Conversion</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample" action="{{ route('unit-conversions.destroy', $unitConversion->id_unit_conversion) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <p>Are you sure you want to delete this unit conversion: <b>{{ $unitConversion->description }}</b> ?</p>
                                <button type="submit" class="btn btn-gradient-primary me-2">Delete</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
@endforeach