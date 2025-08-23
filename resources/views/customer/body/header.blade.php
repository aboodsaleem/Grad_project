<header
  class="top-header bg-white d-flex align-items-center justify-content-between position-sticky top-0"
>
  <div class="header-left d-flex align-items-center gap-3">
    <button class="menu-toggle" id="menuToggle">
      <i class="fas fa-bars"></i>
    </button>
    <h1 class="page-title fw-semibold" id="pageTitle">Dashboard</h1>
  </div>

  <div class="header-right d-flex align-items-center gap-20">
    @php
      $unreadCount = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;
      $lastNotifications = auth()->check()
        ? auth()->user()->notifications()->latest()->limit(5)->get()
        : collect();
    @endphp

    <div class="search-box d-flex align-items-center position-relative">
      <input type="text" placeholder="Search for a service..." />
      <i class="fas fa-search position-absolute"></i>
    </div>

    @auth
      {{-- 🔔 Dropdown الإشعارات --}}
      <div class="dropdown position-relative z-3">
        <button class="notification-btn position-relative p-2 rounded-circle border-0"
                type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-bell"></i>
          @if($unreadCount > 0)
            <span class="notification-badge position-absolute top-0 text-white rounded-circle d-flex align-items-center justify-content-center">
              {{ $unreadCount }}
            </span>
          @endif
        </button>

        <ul class="dropdown-menu dropdown-menu-end p-2 rounded-4" style="width:300px">
          <li class="fw-bold text-center mb-2">Latest Notifications</li>

          {{-- زر تحديد الكل كمقروء --}}
          @if($unreadCount > 0)
            <li class="px-2 mb-2">
              <form method="POST" action="{{ route('customer.notifications.readAll') }}">
                @csrf
                <button class="btn btn-sm w-100 btn-outline-primary">Mark all as read</button>
              </form>
            </li>
          @endif

          {{-- إشعارات آخر 5 --}}
          @forelse($lastNotifications as $n)
            <li class="px-1">
              <div class="dropdown-item text-wrap p-2 rounded-3 d-flex justify-content-between align-items-start gap-2">
                <div class="me-2">
                  <div class="d-flex align-items-center gap-1">
                    <span class="me-1">🔔</span>
                    @if(is_null($n->read_at))
                      <span class="d-inline-block rounded-circle" style="width:8px;height:8px;background:#0d6efd"></span>
                    @endif
                  </div>
                  <div class="mt-1">{{ data_get($n->data,'message','Notification') }}</div>
                  <div class="small text-muted">{{ $n->created_at->diffForHumans() }}</div>
                </div>

                @if(is_null($n->read_at))
                  <form method="POST" action="{{ route('customer.notifications.read', $n->id) }}">
                    @csrf
                    <button class="btn btn-sm btn-link text-decoration-none p-0">Mark as read</button>
                  </form>
                @endif
              </div>
            </li>
          @empty
            <li><div class="dropdown-item text-center text-muted">No notifications</div></li>
          @endforelse
        </ul>
      </div>
    @endauth

    @auth
      <div class="user-profile d-flex align-items-center gap-10">
        <img src="{{ asset(Auth::user()->photo ?? 'upload/no_image.jpg') }}"
             alt="User Avatar" class="user-avatar rounded-circle object-fit-cover" />
        <span class="user-name fw-medium">{{ Auth::user()->username }}</span>
      </div>
    @endauth

    @guest
      <a class="btn btn-sm btn-primary" href="{{ route('customer.login') }}">Login</a>
    @endguest
  </div>
</header>

{{--   تغيير العنوان حسب الصفحة --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
  const pageTitle = document.getElementById("pageTitle");
  if (!pageTitle) return;

  //  يغيّر العنوان فقط عند الضغط على روابط السايدبار
  const sidebarLinks = document.querySelectorAll(".sidebar a");
  sidebarLinks.forEach(link => {
    link.addEventListener("click", function () {
      const text = this.innerText.trim();
      pageTitle.textContent = text || "Dashboard";
    });
  });

});
</script>
