@foreach ($data as $top)
    <div class="modal fade" id="show_top{{ $top->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">View Term of Payment</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">View Item: {{ $top->description }}</h4>
                            <p class="card-description">Detailed information about this resource.</p>

                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        href="#generaltop{{ $top->id }}" role="tab" aria-controls="home"
                                        aria-selected="true">General Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="basemargin-tab" data-bs-toggle="tab"
                                        href="#basemargin{{ $top->id }}" role="tab" aria-controls="profile"
                                        aria-selected="false">Base Margin</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                {{-- Tab Data Item (Read-Only) --}}
                                <div class="tab-pane fade show active m-3" id="generaltop{{ $top->id }}"
                                    role="tabpanel" aria-labelledby="home-tab">
                                    <div class="form-group">
                                        <label class="fw-bold">Days</label>
                                        <p class="form-control-plaintext border-bottom">{{ $top->days }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="fw-bold">Description</label>
                                        <p class="form-control-plaintext border-bottom">{{ $top->description }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Tab Base Margin (Read-Only) --}}
                                <div class="tab-pane fade m-3" id="basemargin{{ $top->id }}" role="tabpanel"
                                    aria-labelledby="basemargin-tab">
                                    <div class="form-group">
                                        <label class="fw-bold">Applied Base Margin</label>
                                        <p class="form-control-plaintext border-bottom">
                                            {{ $top->tgp_margins->margin_percentage_format ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="m-3">
                                    {{-- Tombol untuk kembali ke index --}}
                                    <a href="{{ route('term-of-payment.index') }}" class="btn btn-light border">Back to
                                        List</a>
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
