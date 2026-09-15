@foreach ($data as $arrival)
    <div class="modal fade" id="show_arrival{{ $arrival->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Detail Inventory Arrival</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <tr>
                            <td><strong>Date Arrival:</strong></td>
                            <td>{{ $arrival->date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>{{ $arrival->status }}</td>
                        </tr>
                        <tr>
                            <td><strong>Description:</strong></td>
                            <td>{{ $arrival->item->description }}</td>
                        </tr>
                        <tr>
                            <td><strong>Quantity:</strong></td>
                            <td>{{ number_format($arrival->quantity, 0, ',', '.') }} {{ $arrival->unit_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Unit Price :</strong></td>
                            <td>{{ number_format($arrival->unit_price, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Net Amount :</strong></td>
                            <td>{{ number_format($arrival->net_amount, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Keterangan :</strong></td>
                            <td>{{ $arrival->keterangan }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
@endforeach
