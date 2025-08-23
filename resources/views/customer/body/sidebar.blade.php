<aside class="sidebar text-white overflow-y-auto position-fixed vh-100 z-1">
  <div class="sidebar-header p-20">
    <a class="logo text-decoration-none text-white d-flex align-items-center gap-10 fw-bold fs-5"
       href="{{ route('customer.dashboard') }}">
      <i class="fas fa-home"></i>
      <span>Home Services</span>
    </a>
  </div>

  @php
    // عدد الإشعارات غير المقروءة لإظهار الشارة في السايدبار
    $sidebarUnreadCount = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;

    // هل أنا حالياً على صفحة الداشبورد؟
    $onDashboard = request()->routeIs('customer.dashboard');
  @endphp

  <nav class="sidebar-nav py-20 px-0">
    <ul class="list-unstyled nav flex-column" id="v-pills-tab" role="tablist">

      {{-- Dashboard --}}
      <li class="nav-item">
        <a
          class="nav-link text-decoration-none d-flex align-items-center {{ $onDashboard ? 'active' : '' }}"
          id="tab-dashboard"
          @if($onDashboard)
            data-bs-toggle="pill" href="#dashboard" role="tab"
          @else
            href="{{ route('customer.dashboard') }}#dashboard"
          @endif
        >
          <i class="fas fa-tachometer-alt text-center"></i>
          <span>Dashboard</span>
        </a>
      </li>

      {{-- Browse Services --}}
      <li class="nav-item">
        <a
          class="nav-link text-decoration-none d-flex align-items-center"
          id="tab-services"
          @if($onDashboard)
            data-bs-toggle="pill" href="#services" role="tab"
          @else
            href="{{ route('customer.dashboard') }}#services"
          @endif
        >
          <i class="fas fa-search text-center"></i>
          <span>Browse Services</span>
        </a>
      </li>

      {{-- My Bookings --}}
      <li class="nav-item">
        <a
          class="nav-link text-decoration-none d-flex align-items-center"
          id="tab-bookings"
          @if($onDashboard)
            data-bs-toggle="pill" href="#bookings" role="tab"
          @else
            href="{{ route('customer.dashboard') }}#bookings"
          @endif
        >
          <i class="fas fa-calendar-check text-center"></i>
          <span>My Bookings</span>
        </a>
      </li>

      {{-- Favorites --}}
      <li class="nav-item">
        <a
          class="nav-link text-decoration-none d-flex align-items-center"
          id="tab-favorites"
          @if($onDashboard)
            data-bs-toggle="pill" href="#favorites" role="tab"
          @else
            href="{{ route('customer.dashboard') }}#favorites"
          @endif
        >
          <i class="fas fa-heart text-center"></i>
          <span>Favorites</span>
        </a>
      </li>

      {{-- Profile --}}
      <li class="nav-item">
        <a
          class="nav-link text-decoration-none d-flex align-items-center"
          id="tab-profile"
          @if($onDashboard)
            data-bs-toggle="pill" href="#profile" role="tab"
          @else
            href="{{ route('customer.dashboard') }}#profile"
          @endif
        >
          <i class="fas fa-user text-center"></i>
          <span>Profile</span>
        </a>
      </li>

      {{-- Notifications (يفتح تبويب dashboard#notifications دائماً عند عدم التواجد على الداشبورد) --}}
      <li class="nav-item">
        <a
          class="nav-link text-decoration-none d-flex align-items-center"
          id="tab-notifications"
          @if($onDashboard)
            data-bs-toggle="pill" href="#notifications" role="tab"
          @else
            href="{{ route('customer.dashboard') }}#notifications"
          @endif
        >
          <i class="fas fa-bell text-center"></i>
          <span class="d-flex align-items-center">
            Notifications
            @if($sidebarUnreadCount > 0)
              <span class="ms-2 badge bg-danger rounded-pill">{{ $sidebarUnreadCount }}</span>
            @endif
          </span>
        </a>
      </li>

      {{-- Support --}}
      <li class="nav-item">
        <a
          class="nav-link text-decoration-none d-flex align-items-center"
          id="tab-support"
          @if($onDashboard)
            data-bs-toggle="pill" href="#support" role="tab"
          @else
            href="{{ route('customer.dashboard') }}#support"
          @endif
        >
          <i class="fas fa-headset text-center"></i>
          <span>Support</span>
        </a>
      </li>

      {{-- Settings --}}
      <li class="nav-item">
        <a
          class="nav-link text-decoration-none d-flex align-items-center"
          id="tab-settings"
          @if($onDashboard)
            data-bs-toggle="pill" href="#settings" role="tab"
          @else
            href="{{ route('customer.dashboard') }}#settings"
          @endif
        >
          <i class="fas fa-cog text-center"></i>
          <span>Settings</span>
        </a>
      </li>

      {{-- Logout --}}
      <li class="nav-item">
        <a
          href="{{ route('customer.logout') }}"
          class="nav-link text-decoration-none d-flex align-items-center"
          onclick="event.preventDefault(); document.getElementById('customer-logout-form').submit();"
        >
          <i class="fas fa-sign-out-alt text-center"></i>
          <span>Logout</span>
        </a>
        <form id="customer-logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  </nav>
</aside>
