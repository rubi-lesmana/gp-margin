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
                        <h4>Calculator Suggested GP</h4>
                        <h6 class="font-weight-light">Sign in to continue.</h6>
                        <form class="pt-3" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="email"
                                    class="form-control form-control-lg  @error('email')
                                     is-invalid @enderror"
                                    value="" name="email" placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password"
                                    class="form-control form-control-lg  @error('password')
                                     is-invalid @enderror"
                                    name="password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-3 d-grid gap-2">
                                <button
                                    class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"
                                    type="submit">SIGN
                                    IN</button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                                </div>
                                <a href="#" class="auth-link text-primary">Forgot password?</a>
                            </div>
                            <div class="text-center mt-4 font-weight-light"> Don't have an account? <a
                                    href="{{ route('register') }}" class="text-primary">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

@include('partials.footer')
