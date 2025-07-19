        <header
          class="top-header bg-white d-flex align-items-center justify-content-between position-sticky top-0"
        >
          <div class="header-left d-flex align-items-center gap-3">
            <button class="menu-toggle" id="menuToggle">
              <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title fw-semibold">Dashboard</h1>
          </div>
          <div class="header-right d-flex align-items-center gap-20">
            <div class="notifications">
              <button
                id="notificationBell"
                class="notification-btn position-relative p-2 rounded-circle border-0"
              >
                <i class="fas fa-bell"></i>
                <span
                  class="notification-badge position-absolute top-0 text-white rounded-circle d-flex align-items-center justify-content-center"
                  >5</span
                >
              </button>
            </div>
            <div class="user-profile d-flex align-items-center gap-10">
              <img
                src="{{ asset(Auth::user()->photo ?? 'upload/no_image.jpg') }}"
                alt="User Avatar"
                class="user-avatar rounded-circle object-fit-cover"
              />
              <span class="user-name fw-medium">{{ Auth::user()->username }}</span>
            </div>
          </div>
        </header>
