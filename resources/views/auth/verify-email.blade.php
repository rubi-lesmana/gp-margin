@include('partials.header')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            <img src="{{ asset('purple/src/assets/images/logo/agt.png') }}" style="height: auto;">
                        </div>
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success" role="alert">
                                A new email verification link has been emailed to you!
                            </div>
                        @endif
                        <h4>Verify Account !</h4>
                        <h6 class="font-weight-light text-center">Please Verify Your Email Addresss
                            {{ auth()->user()->email }}</h6>

                        {{-- Form Verify Account --}}
                        <div class="mt-3 d-grid gap-2">
                            <a class="btn btn-primary" href="{{ route('verification.send') }}" style="cursor: pointer"
                                onclick="event.preventDefault(); document.getElementById('verify-form').submit()">
                                <i class="mdi mdi-email me-2 text-primary"></i> Resend Verification Email </a>
                            <form action="{{ route('verification.send') }}" method="POST" style="display: none"
                                id="verify-form">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

@include('partials.footer')
