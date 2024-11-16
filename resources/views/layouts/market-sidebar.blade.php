    <div class="sidebar">
        <div class="logo-details">
            <div class="logo_name">{{ env('APP_NAME') }}</div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">
            <!--
            <li>
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Search...">
                <span class="tooltip">{{ __('Search') }}</span>
            </li>
        -->
            <li>
                <a href="{{ route('marketplace') }}">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">{{ __('Marketplace') }}</span>
                </a>
                <span class="tooltip">{{ __('Marketplace') }}</span>
            </li>
            
            <li>
                <a href="{{ route('recommended') }}">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="links_name">{{ __('Recommended Products') }}</span>
                </a>
                <span class="tooltip">{{ __('Recommended Products') }}</span>
            </li>
            
            <li>
                <a href="{{ route('orders.index') }}">
                    <i class='bx bx-cart-alt'></i>
                    <span class="links_name">Orders</span>
                </a>
                <span class="tooltip">Orders</span>
            </li>
            <li>
                <a href="{{ route('cart.index') }}">
                    <i class='bx bx-cart'></i>
                    <span class="links_name">Cart</span>
                </a>
                <span class="tooltip">Cart</span>
            </li>
            

            <li>
                <a href="{{ route('profile.edit') }}">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">{{ __('User Settings') }}</span>
                </a>
                <span class="tooltip">{{ __('User Settings') }}</span>
            </li>
            @if (Auth::user()->role == 'site_manager')
            <li>
                <a href="{{ route('users') }}">
                    <i class='bx bx-group'></i>
                    <span class="links_name">{{ __('Users') }}</span>
                </a>
                <span class="tooltip">{{ __('Users') }}</span>
            </li>
            <li>
                <a href="{{ route('categories') }}">
                    <i class='bx bx-cabinet'></i>
                    <span class="links_name">{{ __('Categories') }}</span>
                </a>
                <span class="tooltip">{{ __('Categories') }}</span>
            </li>

            @endif




            <li class="profile">
                <div class="profile-details">
                    <img src="./images/profile.png" alt="profileImg">
                    <div class="name_job">
                        <div class="name">{{ Auth::user()->name }}</div>
                        <div class="job">{{ Auth::user()->role }}</div>
                    </div>
                </div>
                <i class='bx bx-log-out' id="log_out"></i>
            </li>
        </ul>
    </div>