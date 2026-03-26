@include('partials.header')
<div class="container-scroller">
    @include('partials.navbar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">

        @include('partials.sidebar')
        <!-- partial -->
        <div class="main-panel">
            @yield('content')
            <!-- content-wrapper ends -->
            @include('partials.copyright')
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
@include('partials.footer')
