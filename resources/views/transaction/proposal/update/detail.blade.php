<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="card-title mb-0">Item Detail</h6>
    <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddRow">
        <i class="ti ti-plus me-1"></i> Add Item
    </button>
</div>

@error('items')
    <div class="alert alert-danger py-1 px-2 mb-2" style="font-size:13px">
        {{ $message }}
    </div>
@enderror

<div class="table-responsive">
    <table class="table align-middle mb-0" id="itemTable">
        <thead class="table-light">
            <tr>
                <th>Item</th>
                <th>Qty (KG)</th>
                <th>Proposed Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="itemRows">

            {{-- Prioritas: old() saat validasi gagal, fallback ke data existing --}}
            @if (old('items'))
                @foreach (old('items') as $i => $oldItem)
                    <tr class="item-row" data-index="{{ $i }}">
                        <td data-label="Item">
                            <select name="items[{{ $i }}][item_id]"
                                class="form-select form-select-sm item-select
                                       @error("items.{$i}.item_id") is-invalid @enderror"
                                data-index="{{ $i }}">
                                <option value="">-- Select Item --</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->item_id }}"
                                        {{ $oldItem['item_id'] == $item->item_id ? 'selected' : '' }}>
                                        {{ $item->item_id }} — {{ $item->description }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="items[{{ $i }}][selling_price_id]"
                                class="selling-price-id" value="{{ $oldItem['selling_price_id'] ?? '' }}">
                            @error("items.{$i}.item_id")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                        <td data-label="Qty (KG)">
                            <input type="number" step="0.0001" min="0.0001" name="items[{{ $i }}][qty]"
                                class="form-control form-control-sm
                                       @error("items.{$i}.qty") is-invalid @enderror"
                                value="{{ $oldItem['qty'] ?? '' }}" placeholder="0">
                            @error("items.{$i}.qty")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                        <td data-label="Proposed Price">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="proposedPrice_{{ $i }}"
                                    class="form-control currency-input
                                           @error("items.{$i}.proposed_price") is-invalid @enderror"
                                    data-target="#proposedPriceReal_{{ $i }}" placeholder="0"
                                    inputmode="numeric" autocomplete="off"
                                    value="{{ isset($oldItem['proposed_price']) ? number_format((float) $oldItem['proposed_price'], 0, ',', '.') : '' }}">
                                <input type="hidden" id="proposedPriceReal_{{ $i }}"
                                    name="items[{{ $i }}][proposed_price]" class="proposed-price-real"
                                    value="{{ $oldItem['proposed_price'] ?? '' }}">
                            </div>
                            @error("items.{$i}.proposed_price")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                {{-- Data existing dari database --}}
                @foreach ($proposal->sales_proposal_details as $i => $detail)
                    <tr class="item-row" data-index="{{ $i }}">
                        <td data-label="Item">
                            <select name="items[{{ $i }}][item_id]"
                                class="form-select form-select-sm item-select" data-index="{{ $i }}">
                                <option value="">-- Select Item --</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->item_id }}"
                                        {{ $detail->item_id == $item->item_id ? 'selected' : '' }}>
                                        {{ $item->item_id }} — {{ $item->description }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="items[{{ $i }}][selling_price_id]"
                                class="selling-price-id" value="{{ $detail->selling_price_id }}">
                        </td>
                        <td data-label="Qty (KG)">
                            <input type="number" step="0.0001" min="0.0001" name="items[{{ $i }}][qty]"
                                class="form-control form-control-sm" value="{{ $detail->qty }}" placeholder="0">
                        </td>
                        <td data-label="Proposed Price">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="proposedPrice_{{ $i }}"
                                    class="form-control currency-input"
                                    data-target="#proposedPriceReal_{{ $i }}" placeholder="0"
                                    inputmode="numeric" autocomplete="off"
                                    value="{{ number_format((float) $detail->proposed_price, 0, ',', '.') }}">
                                <input type="hidden" id="proposedPriceReal_{{ $i }}"
                                    name="items[{{ $i }}][proposed_price]" class="proposed-price-real"
                                    value="{{ $detail->proposed_price }}">
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-gradient-primary">Update</button>
    <a href="{{ route('proposal.index') }}" class="btn btn-outline-secondary">
        Cancel
    </a>
</div>
