<div class="modal fade" id="arrival" tabindex="-1" role="dialog" aria-labelledby="arrivalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="arrivalLabel">Search Arrival Transaction</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col">
                                <h4 class="card-title">Market Price List</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Arrival ID</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>ItemID</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Net Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($arrivals as $arrival)
                                            <tr>
                                                <td data-label="Arrival ID">{{ $arrival->id }}</td>
                                                <td data-label="Date">{{ $arrival->date }}</td>
                                                <td data-label="Status">{{ $arrival->status }}</td>
                                                <td data-label="ItemID">{{ $arrival->item_id }}</td>
                                                <td data-label="Description">{{ $arrival->item->description }}</td>
                                                <td data-label="Quantity">
                                                    {{ number_format($arrival->quantity, 0, ',', '.') . ' ' . $arrival->unit_id }}
                                                </td>
                                                <td data-label="Unit Price">
                                                    {{ number_format($arrival->unit_price, 0, ',', '.') }}
                                                </td>
                                                <td data-label="Net Amount">
                                                    {{ number_format($arrival->net_amount, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm select-arrival"
                                                        data-id="{{ $arrival->id }}"
                                                        data-date="{{ \Carbon\Carbon::parse($arrival->date)->format('Y-m-d') }}"
                                                        data-status="{{ $arrival->status }}"
                                                        data-item-id="{{ $arrival->item_id }}"
                                                        data-item-desc="{{ $arrival->item->description }}"
                                                        data-quantity="{{ $arrival->quantity }}"
                                                        data-unit-id="{{ $arrival->unit_id }}" data-bs-dismiss="modal">
                                                        Select
                                                    </button>
                                                </td>
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
</div>
