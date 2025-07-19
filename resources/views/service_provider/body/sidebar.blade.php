      <aside
        class="sidebar text-white overflow-y-auto position-fixed vh-100 z-1"
      >
        <div class="sidebar-header p-20">
          <a
            class="logo text-decoration-none text-white d-flex align-items-center gap-10 fw-bold fs-5"
            href="/provider-dashboard.html"
          >
            <i class="fas fa-home"></i>
            <span>Home Services</span>
          </a>
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
                <i class="fas fa-tachometer-alt text-center"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                href="#services"
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-services"
                data-bs-toggle="pill"
                role="tab"
              >
                <i class="fas fa-search text-center"></i>
                <span>Browse Services</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                href="#bookings"
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-bookings"
                data-bs-toggle="pill"
                role="tab"
              >
                <i class="fas fa-calendar-check text-center"></i>
                <span>My Bookings</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                href="#profile"
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-profile"
                data-bs-toggle="pill"
                role="tab"
              >
                <i class="fas fa-user text-center"></i>
                <span>Profile</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                href="#earnings"
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-earnings"
                data-bs-toggle="pill"
                role="tab"
              >
                <i class="fas fa-dollar-sign text-center"></i>
                <span>Earnings</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                href="#reviews"
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-reviews"
                data-bs-toggle="pill"
                role="tab"
              >
                <i class="fas fa-star text-center"></i>
                <span>Reviews</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                href="#settings"
                class="nav-link text-decoration-none d-flex align-items-center"
                id="tab-settings"
                data-bs-toggle="pill"
                role="tab"
              >
                <i class="fas fa-cog"></i>
                <span>Settings</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link text-decoration-none d-flex align-items-center"
                href="{{ route('Service_Provider.logout') }}"
              >
                <i class="fas fa-sign-out-alt text-center"></i>
                <span>Logout</span>
              </a>
            </li>
          </ul>
        </nav>
      </aside>
