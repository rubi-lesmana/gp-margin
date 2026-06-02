<div class="row">
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('purple/src/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                    alt="circle-image" />
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div>
                        <h4 class="mb-0">Total Item</h4>
                        <small class="text-light-50">Has SSP</small>
                    </div>

                    <span class="bg-gradient-light p-2 rounded mb-1">
                        <i class="icon-tag text-success"></i>
                    </span>
                </div>

                <div class="row">
                    <div class="col-4">
                        <h2 class="fw-bold mb-0 text-light">{{ $totalItemWithSsp }}</h2>
                    </div>

                    <div class="col-8 d-flex justify-content-end align-items-center">
                        <small class="text-nowrap">
                            {{ $totalItem > 0 ? round(($totalItemWithSsp / $totalItem) * 100) : 0 }}% from total item
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Row 2 --}}
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('purple/src/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                    alt="circle-image" />
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div>
                        <h4 class="mb-0">Total Request</h4>
                        <small class="text-light-50">Proposed Price</small>
                    </div>

                    <span class="bg-gradient-light p-2 rounded mb-1">
                        <i class="icon-paper-plane text-info"></i>
                    </span>
                </div>

                <div class="row">
                    <div class="col-3">
                        <h2 class="fw-bold mb-0 text-light">{{ $totalProposal }}</h2>
                    </div>

                    <div class="col-9 d-flex justify-content-end align-items-center gap-3">
                        <div class="text-nowrap">
                            <i class="mdi mdi-arrow-down text-light me-1"></i>
                            <small>{{ $totalNegatif }}</small>
                        </div>
                        <div class="text-nowrap">
                            <i class="mdi mdi-arrow-up text-light me-1"></i>
                            <small>{{ $totalPositif }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('purple/src/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                    alt="circle-image" />
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div>
                        <h4 class="mb-0">Total</h4>
                        <small class="text-light-50">Pending Approval</small>
                    </div>

                    <span class="bg-gradient-light p-2 rounded mb-1">
                        <i class="icon-clock text-danger"></i>
                    </span>
                </div>

                <div class="row">
                    <div class="col-3">
                        <h2 class="fw-bold mb-0 text-light">{{ $totalProposalPending }}</h2>
                    </div>

                    <div class="col-9 d-flex justify-content-end align-items-center text-end">
                        @if ($totalProposalPending > 0)
                            <small class="text-light text-nowrap">
                                <i class="mdi mdi-alert-circle-outline me-1"></i>Need review
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-warning card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('purple/src/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                    alt="circle-image" />
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div>
                        <h4 class="mb-0">Total</h4>
                        <small class="text-light-50">Requestion Approved</small>
                    </div>

                    <span class="bg-gradient-light p-2 rounded mb-1">
                        <i class="icon-check text-warning"></i>
                    </span>
                </div>

                <div class="row">
                    <div class="col-3">
                        <h2 class="fw-bold mb-0 text-light">{{ $totalApproved }}</h2>
                    </div>

                    <div class="col-9 d-flex justify-content-end align-items-center">
                        <small class="text-nowrap">
                            {{ $totalProposal > 0 ? round(($totalApproved / $totalProposal) * 100) : 0 }}% from total
                            request
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('purple/src/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                    alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Weekly Orders <i
                        class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">45,6334</h2>
                <h6 class="card-text">Decreased by 10%</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('purple/src/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                    alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Visitors Online <i class="mdi mdi-diamond mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">95,5741</h2>
                <h6 class="card-text">Increased by 5%</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('purple/src/assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                    alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Visitors Online <i class="mdi mdi-diamond mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">95,5741</h2>
                <h6 class="card-text">Increased by 5%</h6>
            </div>
        </div>
    </div> --}}
</div>
