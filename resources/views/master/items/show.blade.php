@foreach ($data as $item)
    <div class="modal fade" id="show_item{{ $item->safe_item_id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">View Item</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">View Item: {{ $item->description }}</h4>
                            <p class="card-description">Detailed information about this resource.</p>

                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#gpmargin"
                                        role="tab" aria-controls="home" aria-selected="true">General Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="basemargin-tab" data-bs-toggle="tab" href="#basemargin"
                                        role="tab" aria-controls="profile" aria-selected="false">Base Margin</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                {{-- Tab Data Item (Read-Only) --}}
                                <div class="tab-pane fade show active m-3" id="gpmargin" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div class="form-group">
                                        <label class="fw-bold">Item ID</label>
                                        <p class="form-control-plaintext border-bottom">{{ $item->item_id }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="fw-bold">Description</label>
                                        <p class="form-control-plaintext border-bottom">{{ $item->description }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Tab Base Margin (Read-Only) --}}
                                <div class="tab-pane fade m-3" id="basemargin" role="tabpanel"
                                    aria-labelledby="basemargin-tab">
                                    <div class="form-group">
                                        <label class="fw-bold">Applied Base Margin</label>
                                        <p class="form-control-plaintext border-bottom">
                                            {{-- Menampilkan label dari relasi, bukan hanya ID --}}
                                            {{ $item->base_margin->margin_percentage ?? 'N/A' }}%
                                        </p>
                                    </div>
                                </div>

                                <div class="m-3">
                                    {{-- Tombol untuk kembali ke index --}}
                                    <a href="{{ route('items.index') }}" class="btn btn-light border">Back to List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
@endforeach
