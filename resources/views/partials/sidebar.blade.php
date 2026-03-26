<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- Dashboard --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <span class="menu-title">Dashboard</span>
                <i class="icon-home menu-icon"></i>
            </a>
        </li>

        {{-- Seection Transaction --}}
        <li class="nav-item  mt-3">
            <span class="menu-title text-secondary">Transaction</span>
            <div class="border-bottom mt-2">
            </div>
        </li>
        {{-- USer COurse --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('suggested-gp.index') }}">
                <span class="menu-title">Suggested GP</span>
                <i class="icon-calculator menu-icon"></i>
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
                <span class="menu-title">Item</span>
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

        {{-- Inventory Arrival --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('arrival-inventory.index') }}">
                <span class="menu-title">Inventory Arrival</span>
                <i class="icon-calendar menu-icon"></i>
            </a>
        </li>

        {{-- Configuration Section --}}
        <li class="nav-item mt-3">
            <span class="menu-title text-secondary">Configuration</span>
            <div class="border-bottom mt-2">
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('base-margin.index') }}">
                <span class="menu-title">Base Margin</span>
                <i class="mdi mdi-call-missed menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('category.index') }}">
                <span class="menu-title">Category</span>
                <i class="icon-equalizer menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
