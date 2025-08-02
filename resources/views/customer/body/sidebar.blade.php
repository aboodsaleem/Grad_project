      <aside
        class="sidebar text-white overflow-y-auto position-fixed vh-100 z-1"
      >
        <div class="sidebar-header p-20">
          <a
            class="logo text-decoration-none text-white d-flex align-items-center gap-10 fw-bold fs-5"
            href="#"
            ><i class="fas fa-home"></i><span>Home Services</span></a
          >
        </div>
        <nav class="sidebar-nav py-20 px-0">
          <ul
            class="list-unstyled nav flex-column"
            id="v-pills-tab"
            role="tablist"
          >
            <li class="nav-item">
              <a
                class="nav-link text-decoration-none d-flex align-items-center active"
                id="tab-dashboard"
                data-bs-toggle="pill"
                href="#dashboard"
                role="tab"
              >
                <i class="fas fa-tachometer-alt text-center"></i> Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-services"
                data-bs-toggle="pill"
                href="#services"
                role="tab"
              >
                <i class="fas fa-search text-center"></i> Browse Services
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-bookings"
                data-bs-toggle="pill"
                href="#bookings"
                role="tab"
              >
                <i class="fas fa-calendar-check text-center"></i> My Bookings
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-favorites"
                data-bs-toggle="pill"
                href="#favorites"
                role="tab"
              >
                <i class="fas fa-heart text-center"></i> Favorites
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-profile"
                data-bs-toggle="pill"
                href="#profile"
                role="tab"
              >
                <i class="fas fa-user text-center"></i> Profile
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-notifications"
                data-bs-toggle="pill"
                href="#notifications"
                role="tab"
              >
                <i class="fas fa-bell text-center"></i> Notifications
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-support"
                data-bs-toggle="pill"
                href="#support"
                role="tab"
              >
                <i class="fas fa-headset text-center"></i> Support
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-settings"
                data-bs-toggle="pill"
                href="#settings"
                role="tab"
              >
                <i class="fas fa-cog text-center"></i> Settings
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link text-decoration-none d-flex align-items-center"
                href="{{ route('customer.logout') }}"
              >
                <i class="fas fa-sign-out-alt text-center"></i>
                <span>Logout</span>
              </a>
            </li>
          </ul>
        </nav>
      </aside>
