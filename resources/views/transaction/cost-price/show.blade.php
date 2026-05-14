@foreach ($data as $cost_price)
    <div class="modal fade" id="show_cost_price{{ $cost_price->id_cost_price }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Detail Cost Price</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <tr>
                            <td><strong>ID Cost Price:</strong></td>
                            <td>{{ $cost_price->id_cost_price }}</td>
                        </tr>
                        <tr>
                            <td><strong>ID Inventory Arrival:</strong></td>
                            <td>{{ $cost_price->arrival_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Date:</strong></td>
                            <td>{{ $cost_price->date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Item:</strong></td>
                            <td>{{ $cost_price->item_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Description:</strong></td>
                            <td>{{ $cost_price->item->description }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cost Price:</strong></td>
                            <td>{{ number_format($cost_price->cost_price, 0, ',', '.') }} {{ $cost_price->unit_id }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Keterangan :</strong></td>
                            <td>{{ $cost_price->manual_reference }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
@endforeach
