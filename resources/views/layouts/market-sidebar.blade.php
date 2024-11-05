    <div class="sidebar">
        <div class="logo-details">
            <div class="logo_name">{{ env('APP_NAME') }}</div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Search...">
                <span class="tooltip">{{ __('Search') }}</span>
            </li>
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">{{ __('Dashboard') }}</span>
                </a>
                <span class="tooltip">{{ __('Dashboard') }}</span>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}">
                    <i class='bx bx-user'></i>
                    <span class="links_name">{{ __('User') }}</span>
                </a>
                <span class="tooltip">{{ __('User') }}</span>
            </li>
            
            <li>
                <a href="">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="links_name">{{ __('Analytics') }}</span>
                </a>
                <span class="tooltip">{{ __('Analytics') }}</span>
            </li>
            
            <li>
                <a href="">
                    <i class='bx bx-cart-alt'></i>
                    <span class="links_name">Orders</span>
                </a>
                <span class="tooltip">Orders</span>
            </li>
            <li>
                <a href="">
                    <i class='bx bx-heart'></i>
                    <span class="links_name">Saved</span>
                </a>
                <span class="tooltip">Saved</span>
            </li>
            <li>
                <a href="">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">Settings</span>
                </a>
                <span class="tooltip">Settings</span>
            </li>
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