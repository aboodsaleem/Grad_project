<header class="top-header bg-white d-flex align-items-center justify-content-between position-sticky top-0">
  <div class="header-left d-flex align-items-center gap-3">
    <button class="menu-toggle" id="menuToggle" type="button" aria-label="Toggle Menu">
      <i class="fas fa-bars"></i>
    </button>

    {{-- العنوان: افتراضي من yield، وبعدين بنحدّثه بالـ JS حسب التبويب الحالي/المسار --}}
    <h1 class="page-title fw-semibold m-0">
       @yield('page_title','Dashboard')
    </h1>
  </div>

  <div class="header-right d-flex align-items-center gap-20">
    @php
      $unreadCount = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;
      $lastNotifications = auth()->check()
        ? auth()->user()->notifications()->latest()->limit(5)->get()
        : collect();
    @endphp

    @auth
      {{-- الإشعارات --}}
      <div class="dropdown position-relative">
        <button
          id="notificationBell"
          class="notification-btn position-relative p-2 rounded-circle border-0"
          type="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"
          aria-label="Notifications"
        >
          <i class="fas fa-bell"></i>
          @if($unreadCount > 0)
            <span
              class="notification-badge position-absolute top-0 text-white rounded-circle d-flex align-items-center justify-content-center"
              style="min-width:18px;height:18px;font-size:12px;"
            >{{ $unreadCount }}</span>
          @endif
        </button>

        {{-- قائمة الإشعارات (مرتبطة بزر الجرس أعلاه) --}}
        <ul class="dropdown-menu dropdown-menu-end p-2" style="width: 320px;" aria-labelledby="notificationBell">
          {{-- العنوان + زر الكل --}}
          <li class="d-flex justify-content-between align-items-center mb-2 px-1">
            <strong>Latest Notifications</strong>
            @if($unreadCount > 0)
              <form method="POST" action="{{ route('provider.notifications.readAll') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-link p-0">Mark all as read</button>
              </form>
            @endif
          </li>

          {{-- العناصر --}}
          @forelse($lastNotifications as $n)
            @php
              $isUnread = is_null($n->read_at);
              $title   = data_get($n->data, 'title', 'Notification');
              $message = data_get($n->data, 'message', '');
            @endphp

            <li class="px-1">
              <div class="dropdown-item d-flex align-items-start gap-2 py-2 {{ $isUnread ? 'bg-light rounded-3' : '' }}">
                <span>🔔</span>

                <div class="flex-fill">
                  <div class="d-flex align-items-center gap-2">
                    <span class="fw-semibold">{{ $title }}</span>
                    @if($isUnread)
                      <span class="d-inline-block rounded-circle" style="width:8px;height:8px;background:#0d6efd"></span>
                    @endif
                  </div>
                  @if($message)
                    <div class="small text-muted">{{ $message }}</div>
                  @endif
                  <div class="small text-muted">{{ $n->created_at->diffForHumans() }}</div>
                </div>

                {{-- زر "Mark as read" لكل إشعار --}}
                @if($isUnread)
                  <form method="POST" action="{{ route('provider.notifications.read', $n->id) }}" class="ms-2">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-link p-0">Read</button>
                  </form>
                @endif
              </div>
            </li>
          @empty
            <li><div class="dropdown-item text-center text-muted">No notifications</div></li>
          @endforelse

          {{-- لو بدك زر View all افتح صفحة خاصة لاحقاً --}}
          {{-- <li><a class="dropdown-item text-center fw-semibold" href="{{ route('provider.notifications.index') }}">View all</a></li> --}}
        </ul>
      </div>

      {{-- المستخدم --}}
      <div class="user-profile d-flex align-items-center gap-10">
        <img
          src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : asset('upload/no_image.jpg') }}"
          alt="User Avatar"
          class="user-avatar rounded-circle object-fit-cover"
          width="40" height="40"
        />
        <span class="user-name fw-medium">{{ Auth::user()->username }}</span>
      </div>
    @endauth

    @guest
      <a class="btn btn-sm btn-primary" href="{{ route('provider.login') }}">Login</a>
    @endguest
  </div>
</header>

{{-- ===== تحديث عنوان الصفحة ديناميكياً حسب التبويب أو الصفحة ===== --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const titleEl = document.querySelector('.page-title');
    if (!titleEl) return;

    // خريطة أسماء التبويبات -> عنوان الهيدر (عبر الهاش)
    const hashTitles = {
      '#dashboard': 'Dashboard',
      '#services' : 'Browse Services',
      '#bookings' : 'My Bookings',
      '#profile'  : 'Profile',
      '#earnings' : 'Earnings',
      '#reviews'  : 'Reviews',
      '#settings' : 'Settings'
    };

    // مطابقة المسارات (pathname) -> عنوان الهيدر
    const pathMatchers = [
      { test: p => p.includes('/provider/dashboard'), title: 'Dashboard' },
      { test: p => p.includes('/provider/services'),  title: 'Browse Services' },
      { test: p => p.includes('/provider/bookings'),  title: 'My Bookings' },
      { test: p => p.includes('/provider/profile'),   title: 'Profile' },
      { test: p => p.includes('/provider/earnings'),  title: 'Earnings' },
      { test: p => p.includes('/provider/reviews'),   title: 'Reviews' },
      { test: p => p.includes('/provider/settings'),  title: 'Settings' },
    ];

    function applyTitle() {
      // 1) من الهاش لو موجود ومطابق
      const hash = (location.hash || '').toLowerCase();
      if (hashTitles[hash]) {
        titleEl.textContent = hashTitles[hash];
        return;
      }

      // 2) من المسار (pathname)
      const path = (location.pathname || '').toLowerCase();
      const match = pathMatchers.find(m => m.test(path));
      if (match) {
        titleEl.textContent = match.title;
        return;
      }

      // 3) من رابط التبويب النشط (لو موجود)
      const activeTab =
        document.querySelector('.sidebar a.nav-link.active') ||
        document.querySelector('.sidebar .nav-link[aria-selected="true"]');
      if (activeTab) {
        const txt = activeTab.textContent.trim();
        titleEl.textContent = txt || 'Dashboard';
        return;
      }

      // 4) افتراضي
      titleEl.textContent = 'Dashboard';
    }

    // أول تحميل
    applyTitle();

    // عند تغيير الهاش
    window.addEventListener('hashchange', applyTitle);

    // عند إظهار تبويب Bootstrap
    document.addEventListener('shown.bs.tab', applyTitle);

    // عند الرجوع/التقدّم في المتصفح (تغيّر الـpathname من SPA جزئياً)
    window.addEventListener('popstate', applyTitle);
  });
</script>

