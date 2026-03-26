@include('partials.header')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-5 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            <img src="{{ asset('purple/src/assets/images/logo/agt.png') }}" style=" height: auto;">
                        </div>
                        <h4>Create Account</h4>
                        <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                        <form class="pt-3" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text"
                                    class="form-control form-control-lg @error('name')
                                     is-invalid @enderror"
                                    value="" name="name" placeholder="Username">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>
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
                            <div class="form-group">
                                <input type="password"
                                    class="form-control form-control-lg @error('password_confirmation')
                                     is-invalid @enderror"
                                    name="password_confirmation" placeholder="Confirm Password">
                                @error('password_confirmation')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input"> I agree to all Terms &
                                        Conditions </label>
                                </div>
                            </div>
                            <div class="mt-3 d-grid gap-2">
                                <button
                                    class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"
                                    type="submit">SIGN UP</button>
                            </div>
                            <div class="text-center mt-4 font-weight-light"> Already have an account?
                                <a href="{{ route('login') }}" class="text-primary">Login</a>
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
