   <aside class="sidebar text-white overflow-y-auto position-fixed vh-100 z-1">
  <div class="sidebar-header p-20">
    <a class="logo text-decoration-none text-white d-flex align-items-center gap-10 fw-bold fs-5"
       href="{{ route('provider.dashboard') }}">
      <i class="fas fa-home"></i>
      <span>Home Services</span>
    </a>
  </div>

  <nav class="sidebar-nav py-20 px-0">
    <ul class="list-unstyled nav flex-column" id="v-pills-tab" role="tablist">
      @php
        $onDashboard = request()->routeIs('provider.dashboard');
      @endphp

      @if(Auth::user()->status == 'active')

        {{-- Dashboard --}}
        <li class="nav-item">
          <a class="nav-link text-decoration-none d-flex align-items-center {{ $onDashboard ? 'active' : '' }}"
             id="tab-dashboard"
             @if($onDashboard) data-bs-toggle="pill" href="#dashboard" role="tab"
             @else href="{{ route('provider.dashboard') }}#dashboard" @endif>
            <i class="fas fa-tachometer-alt text-center"></i>
            <span>Dashboard</span>
          </a>
        </li>

        {{-- Services --}}
        <li class="nav-item">
          <a class="nav-link text-decoration-none d-flex align-items-center"
             id="tab-services"
             @if($onDashboard) data-bs-toggle="pill" href="#services" role="tab"
             @else href="{{ route('provider.dashboard') }}#services" @endif>
            <i class="fas fa-search text-center"></i>
            <span>Browse Services</span>
          </a>
        </li>

        {{-- Bookings --}}
        <li class="nav-item">
          <a class="nav-link text-decoration-none d-flex align-items-center"
             id="tab-bookings"
             @if($onDashboard) data-bs-toggle="pill" href="#bookings" role="tab"
             @else href="{{ route('provider.dashboard') }}#bookings" @endif>
            <i class="fas fa-calendar-check text-center"></i>
            <span>My Bookings</span>
          </a>
        </li>

        {{-- Profile --}}
        <li class="nav-item">
          <a class="nav-link text-decoration-none d-flex align-items-center"
             id="tab-profile"
             @if($onDashboard) data-bs-toggle="pill" href="#profile" role="tab"
             @else href="{{ route('provider.dashboard') }}#profile" @endif>
            <i class="fas fa-user text-center"></i>
            <span>Profile</span>
          </a>
        </li>

        {{-- Earnings --}}
        <li class="nav-item">
          <a class="nav-link text-decoration-none d-flex align-items-center"
             id="tab-earnings"
             @if($onDashboard) data-bs-toggle="pill" href="#earnings" role="tab"
             @else href="{{ route('provider.dashboard') }}#earnings" @endif>
            <i class="fas fa-dollar-sign text-center"></i>
            <span>Earnings</span>
          </a>
        </li>

        {{-- Reviews (راوت مستقل) --}}
        <li class="nav-item">
          <a class="nav-link text-decoration-none d-flex align-items-center" id="tab-reviews"
          @if(request()->routeIs('provider.dashboard'))   data-bs-toggle="pill" href="#reviews" role="tab"
         @else
           href="{{ route('provider.dashboard') }}#reviews"
        @endif >
    <i class="fas fa-star text-center"></i>
    <span>Reviews</span>
  </a>
        </li>

        {{-- Settings --}}
        <li class="nav-item">
          <a class="nav-link text-decoration-none d-flex align-items-center"
             id="tab-settings"
             @if($onDashboard) data-bs-toggle="pill" href="#settings" role="tab"
             @else href="{{ route('provider.dashboard') }}#settings" @endif>
            <i class="fas fa-cog"></i>
            <span>Settings</span>
          </a>
        </li>

        {{-- Logout (POST) --}}
        <li class="nav-item">
          <form action="{{ route('provider.logout') }}" method="POST" class="d-inline w-100">
            @csrf
            <button type="submit" class="nav-link text-decoration-none d-flex align-items-center border-0 bg-transparent w-100 text-start">
              <i class="fas fa-sign-out-alt text-center"></i>
              <span>Logout</span>
            </button>
          </form>
        </li>

      @else
        {{-- غير مفعّل: Dashboard + Profile + Logout فقط --}}
        <li class="nav-item">
          <a class="nav-link text-decoration-none d-flex align-items-center {{ $onDashboard ? 'active' : '' }}"
             id="tab-dashboard"
             @if($onDashboard) data-bs-toggle="pill" href="#dashboard" role="tab"
             @else href="{{ route('provider.dashboard') }}#dashboard" @endif>
            <i class="fas fa-tachometer-alt text-center"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-decoration-none d-flex align-items-center"
             id="tab-profile"
             @if($onDashboard) data-bs-toggle="pill" href="#profile" role="tab"
             @else href="{{ route('provider.dashboard') }}#profile" @endif>
            <i class="fas fa-user text-center"></i>
            <span>Profile</span>
          </a>
        </li>

        <li class="nav-item">
          <form action="{{ route('provider.logout') }}" method="POST" class="d-inline w-100">
            @csrf
            <button type="submit" class="nav-link text-decoration-none d-flex align-items-center border-0 bg-transparent w-100 text-start">
              <i class="fas fa-sign-out-alt text-center"></i>
              <span>Logout</span>
            </button>
          </form>
        </li>
      @endif
    </ul>
  </nav>
</aside>
