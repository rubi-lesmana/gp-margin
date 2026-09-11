@foreach ($data as $unitConversion)
    <div class="modal fade" id="show_unit{{ $unitConversion->id_unit_conversion }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Show Unit Conversion</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Unit ID</th>
                                            <th>Unit Name</th>
                                            <th>Conversion Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($unitConversion->details as $detail)
                                            <tr>
                                                <td data-label="Unit ID">{{ $detail->unit_id }}</td>
                                                <td data-label="Unit Name">{{ $detail->unit->description }}</td>
                                                <td data-label="Conversion Value">{{ $detail->conversion_value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
@endforeach