<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('page_title','Service Provider Dashboard') - Home Services</title>

  <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/dashboard.css') }}" />

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>
<body>
  <div class="dashboard-container d-flex min-vh-100">

    @include('service_provider.body.sidebar')

    <!-- Main Content -->
    <main class="main-content flex-grow-1" id="mainContent">
      @include('service_provider.body.header')

      <!-- Page Content -->
      @yield('main')
    </main>

    {{-- Modals --}}
    @include('service_provider.services.create')

    @isset($services)
      @foreach ($services as $service)
        @include('service_provider.services.edit', ['service' => $service])
      @endforeach
    @endisset

    {{-- مثالين لمودال تفاصيل الحجز (ثابتين/ديمو) --}}
    <div class="modal fade" id="confirmedBookingDetailsModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content mx-auto p-4 rounded-4 shadow-sm border-0">
          <div class="modal-header border-0">
            <h2 class="fs-4 fw-semibold mb-0">Booking Details</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-4">
              <p class="mb-1"><strong>Service:</strong> Home Cleaning</p>
              <p class="mb-1"><strong>Client:</strong> Mohamed Ali</p>
              <p class="mb-1"><strong>Date:</strong> 2024-01-16</p>
              <p class="mb-1"><strong>Time:</strong> 10:00 AM</p>
              <p class="mb-0"><strong>Status:</strong> <span class="badge status confirmed">Confirmed</span></p>
            </div>
            <hr class="my-3" />
            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
              <div class="text-primary fs-3"><i class="fas fa-clock"></i></div>
              <div>
                <h6 class="fw-bold mb-1">Awaiting Completion</h6>
                <p class="mb-0 text-muted small">This booking has been confirmed. Once completed, you will receive a review from the customer.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="ratedBookingDetailsModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content mx-auto p-4 rounded-4 shadow-sm border-0">
          <div class="modal-header border-0">
            <h2 class="fs-4 fw-semibold mb-0">Booking Summary</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-4">
              <p class="mb-1"><strong>Service:</strong> Plumbing Repair</p>
              <p class="mb-1"><strong>Client:</strong> Fatima Khalid</p>
              <p class="mb-1"><strong>Date:</strong> 2025-07-16</p>
              <p class="mb-1"><strong>Time:</strong> <span class="start-time">4:00 PM</span> - <span class="end-time">6:00 PM</span></p>
              <p class="mb-0"><strong>Status:</strong> <span class="status fw-medium text-center completed">Completed</span></p>
            </div>
            <hr class="my-3" />
            <div class="d-flex align-items-start gap-3 bg-light rounded-3 p-3">
              <img src="https://via.placeholder.com/60x60?text=User" class="rounded-circle" width="60" height="60"
                   onerror="this.src='{{ asset('frontend/public/assest/default-customer-image.png') }}';" />
              <div class="flex-grow-1">
                <h6 class="fw-bold mb-1">Fatima Khalid</h6>
                <div class="text-warning mb-2 fs-5">
                  <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                  <span class="ms-2 text-muted fs-6">(4.0)</span>
                </div>
                <p class="mb-0 fst-italic text-muted">“Very cooperative and polite. Service was great and on time.”</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div> <!-- /.dashboard-container -->

  <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <script>const notyf = new Notyf();</script>
  <script type="module" src="{{ asset('frontend/js/providerDashboard.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  {{-- تفعيل تبويب حسب الهاش --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      function activateTabFromHash() {
        if (!location.hash) return;
        const selector = a[data-bs-toggle="pill"][href="${location.hash}"], a[data-bs-toggle="tab"][href="${location.hash}"];
        const trigger = document.querySelector(selector);
        if (trigger && window.bootstrap) new bootstrap.Tab(trigger).show();
      }
      activateTabFromHash();
      window.addEventListener('hashchange', activateTabFromHash);

      // لو فيه روابط داخلية href="#..." بدون data-bs-toggle، فعّل التبويب يدويًا
      document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', function (e) {
          const href = this.getAttribute('href');
          const t = document.querySelector(a[data-bs-toggle="pill"][href="${href}"], a[data-bs-toggle="tab"][href="${href}"]);
          if (t && window.bootstrap) {
            e.preventDefault();
            new bootstrap.Tab(t).show();
            history.replaceState(null, '', href);
          }
        });
      });
    });
  </script>

  {{-- تحديث عنوان الهيدر وعنوان الصفحة حسب التاب --}}
  <script>
    (function () {
      const titleMap = {
        '#dashboard': 'Dashboard',
        '#services': 'Browse Services',
        '#bookings': 'My Bookings',
        '#profile': 'Profile',
        '#earnings': 'Earnings',
        '#reviews': 'Reviews',
        '#settings': 'Settings'
      };

      function applyTitle(hash) {
        const text = titleMap[hash] || 'Dashboard';
        const headerTitle = document.querySelector('.page-title'); // تأكد أن الهيدر يحتوي عنصر بهذا الكلاس
        if (headerTitle) headerTitle.textContent = text;

        // حدّث <title> في التبويب
        document.title = ${text} - Home Services;
      }

      // أول تحميل
      document.addEventListener('DOMContentLoaded', () => {
        applyTitle(location.hash || '#dashboard');
      });

      // عند إظهار أي تبويب Bootstrap
      document.addEventListener('shown.bs.tab', function (e) {
        const href = e.target.getAttribute('href') || '#dashboard';
        applyTitle(href);
        history.replaceState(null, '', href);
      });

      // لو تغيّر الهاش مباشرة
      window.addEventListener('hashchange', () => applyTitle(location.hash || '#dashboard'));
    })();
  </script>

  <script>
    @if(Session::has('message'))
      var type = "{{ Session::get('alert-type','info') }}";
      switch(type){
        case 'info': toastr.info("{{ Session::get('message') }}"); break;
        case 'success': toastr.success("{{ Session::get('message') }}"); break;
        case 'warning': toastr.warning("{{ Session::get('message') }}"); break;
        case 'error': toastr.error("{{ Session::get('message') }}"); break;
      }
    @endif
  </script>

  @yield('js')
</body>
</html>