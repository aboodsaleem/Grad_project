<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - Home Services</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" />
  </head>
  <body>
    <div class="auth-container bg-white w-100 position-relative text-start">
      <div class="auth-card">
        <h1 class="logo d-flex align-items-center justify-content-center gap-3 fw-bold fs-5">
          <i class="fas fa-home text-warning"></i>
          <span>Home Booking <span class="text-warning">Services</span></span>
        </h1>

        <div>
          <h2 class="fw-bold fs-5 my-0">Reset Your Password By Email</h2>
          <p class="mt-3 mb-4">
            Enter your email, and you will receive a reset link in your inbox ✌️
          </p>
        </div>

        <!-- عرض رسائل النجاح أو الخطأ داخل الكارت -->
        @if (session('status'))
          <div class="alert alert-success mt-3">
            {{ session('status') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger mt-3">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- نموذج الإرسال -->
        <form method="POST" action="{{ route('password.email') }}">
          @csrf
          <div class="mb-4">
            <label for="mail" class="form-label fw-medium">Your Email</label>
            <input
              type="email"
              id="mail"
              name="email"
              class="form-control"
              placeholder="test@test.com"
              required
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </div>

          <div class="text-center">
            <button
              type="submit"
              id="submitBtn"
              class="btn btn-primary small py-2 px-5 fs-6"
            >
              <span id="btnText">Send</span>
              <span
                id="spinner"
                class="spinner-border spinner-border-sm d-none"
                role="status"
                aria-hidden="true"
              ></span>
            </button>
            <button
              type="reset"
              class="btn btn-outline-secondary small py-2 px-5 fs-6"
            >
              Reset
            </button>
          </div>
        </form>
      </div>
    </div>

    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>

    <!-- سكربت بسيط لتفعيل التحميل -->
    <script>
      const form = document.querySelector("form");
      const btnText = document.getElementById("btnText");
      const spinner = document.getElementById("spinner");

      form.addEventListener("submit", () => {
        btnText.textContent = "Sending...";
        spinner.classList.remove("d-none");
      });
    </script>
  </body>
</html>
