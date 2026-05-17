<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- Section Transaction --}}
        <li class="nav-item  mt-5">
            <span class="menu-title text-secondary">Home</span>
            <div class="border-bottom mt-2">
            </div>
        </li>

        {{-- Dashboard --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Dashboard</span>
                <i class="icon-home menu-icon"></i>
            </a>
        </li>

        {{-- Price List --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('price-list.index') }}">
                <span class="menu-title">Price List</span>
                <i class="icon-list menu-icon"></i>
            </a>
        </li>

        {{-- Section Transaction --}}
        <li class="nav-item  mt-3">
            <span class="menu-title text-secondary">Transaction</span>
            <div class="border-bottom mt-2">
            </div>
        </li>

        {{-- Requestion --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Requestion</span>
                <i class="icon-directions menu-icon"></i>
            </a>
        </li>

        {{-- Inventory Arrival --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('arrival-inventory.index') }}">
                <span class="menu-title">Inventory Arrival</span>
                <i class="icon-calendar menu-icon"></i>
            </a>
        </li>

        {{-- Cost Price --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cost-price.index') }}">
                <span class="menu-title">Cost Price</span>
                <i class=" mdi mdi-currency-usd menu-icon"></i>
            </a>
        </li>

        {{-- List Transaction --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('selling-price.index') }}">
                <span class="menu-title">Selling Price</span>
                <i class="icon-chart menu-icon"></i>
            </a>
        </li>

        {{-- Master Data section --}}
        <li class="nav-item  mt-3">
            <span class="menu-title text-secondary">Master Data</span>
            <div class="border-bottom mt-2">
            </div>
        </li>

        {{-- Item --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('items.index') }}">
                <span class="menu-title">Product</span>
                <i class="icon-tag menu-icon"></i>
            </a>
        </li>

        {{-- Market Price --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('market-price.index') }}">
                <span class="menu-title">Market Price</span>
                <i class="icon-basket menu-icon"></i>
            </a>
        </li>

        {{-- Configuration Section --}}
        <li class="nav-item mt-3">
            <span class="menu-title text-secondary">Configuration</span>
            <div class="border-bottom mt-2">
            </div>
        </li>

        {{-- Base Margin --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('base-margin.index') }}">
                <span class="menu-title">Base Margin</span>
                <i class="mdi mdi-call-missed menu-icon"></i>
            </a>
        </li>

        {{-- Category --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('category.index') }}">
                <span class="menu-title">Category</span>
                <i class="icon-equalizer menu-icon"></i>
            </a>
        </li>

        {{-- Term of Payment --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('term-of-payment.index') }}">
                <span class="menu-title">TOP</span>
                <i class="icon-credit-card menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#Setup" aria-expanded="false" aria-controls="Setup">
                <span class="menu-title">Setup</span>
                <i class="menu-arrow"></i>
                <i class="icon-wrench menu-icon"></i>
            </a>
            <div class="collapse" id="Setup">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('units.index') }}">Unit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pareto.index') }}">Pareto</a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('doi-percentage.index') }}">
                <span class="menu-title">DOI Percentage</span>
                <i class=" icon-graph menu-icon"></i>
            </a>
        </li> --}}
    </ul>
</nav>
