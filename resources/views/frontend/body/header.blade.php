    <header class="header">
      <nav
        class="navbar navbar-expand-lg bg-white d-flex justify-content-between align-items-center"
      >
        <div class="container">
          <a
            class="navbar-brand d-flex align-items-center gap-2 logo-link"
            href="index.html"
          >
            <span class="logo center-flex">
              <i class="fa-solid fa-house logo-icon"></i>
            </span>
            <span class="fw-bold">Home Services</span>
          </a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <spa1 class="navbar-toggler-icon"></spa1>
          </button>
          <div
            class="collapse navbar-collapse justify-content-center"
            id="navbarNav"
          >
            <ul
              class="nav navbar-nav d-flex align-items-center gap-5"
              id="v-pills-tab"
              role="tablist"
            >
              <li class="nav-item">
                <a
                  class="nav-link"
                  id="tab-home"
                  data-bs-toggle="pill"
                  href="#home"
                  role="tab"
                >
                  How it works
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  id="tab-services"
                  data-bs-toggle="pill"
                  href="#services"
                  role="tab"
                >
                  Services
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  id="tab-testimonials"
                  data-bs-toggle="pill"
                  href="#testimonials"
                  role="tab"
                >
                  Testimonials
                </a>
              </li>
            </ul>
          </div>
          <div class="d-flex gap-2 btns">
            <a
              href="{{ route('login') }}"
              class="btn btn-primary toggle-login"
              id="login-btn"
              >Login</a
            >
            <a
              href="{{ route('register') }}"
              class="btn btn-outline-primary register-btn"
              id="register-btn"
              >Register</a
            >
          </div>
        </div>
      </nav>
    </header>
