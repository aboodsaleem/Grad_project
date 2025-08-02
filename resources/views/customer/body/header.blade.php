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
            <div id="searchOverlay" class="search-overlay d-none">
              <div
                class="custom-alert alert alert-light text-center d-flex align-items-center"
                role="alert"
              >
                <span>After ending writing, please press Enter ✌️</span>
                <button class="btn-close ms-3"></button>
              </div>
            </div>
            <div class="search-box d-flex align-items-center position-relative">
              <input type="text" placeholder="Search for a service..." />
              <i class="fas fa-search position-absolute"></i>
            </div>
            <!-- Notification Bell Dropdown -->
            <div class="dropdown position-relative z-3">
              <button
                class="notification-btn position-relative p-2 rounded-circle border-0"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="fas fa-bell"></i>
                <!-- Bootstrap Icon -->
                <span
                  class="notification-badge position-absolute top-0 text-white rounded-circle d-flex align-items-center justify-content-center"
                >
                  3
                </span>
              </button>

              <ul
                class="dropdown-menu dropdown-menu-end p-2 rounded-4"
                style="width: 300px"
              >
                <li class="fw-bold text-center mb-2">Latest Notifications</li>

                <li>
                  <a class="dropdown-item text-wrap p-2 rounded-3" href="#"
                    ><span class="me-1">🔔</span> Your Booking is Confirmed
                  </a>
                </li>
                <li>
                  <a class="dropdown-item text-wrap p-2 rounded-3" href="#"
                    ><span class="me-1">⭐</span> Rate Your Service
                  </a>
                </li>
                <li>
                  <a class="dropdown-item text-wrap p-2 rounded-3" href="#"
                    ><span class="me-1">📅</span> Booking Reminder
                  </a>
                </li>

                <li>
                  <hr class="dropdown-divider mt-3 mb-3" />
                </li>

                <li class="text-center">
                  <button
                    class="btn btn-sm btn-primary"
                    id="viweNotificationBtn"
                  >
                    View All Notifications
                  </button>
                </li>
              </ul>
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
