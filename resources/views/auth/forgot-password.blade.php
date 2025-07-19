<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Home Services</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"
    />
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}" />
  </head>
  <body>
    <div class="auth-container bg-white w-100 position-relative text-start">
      <div class="auth-card">
        <h1
          class="logo d-flex align-items-center justify-content-center gap-3 fw-bold fs-5"
        >
          <i class="fas fa-home"></i>

          <span>Home Booking <span>Services</span></span>
        </h1>
        <div>
          <h2 class="fw-bold fs-5 my-0">Reset Your Password By Email</h2>
          <p class="mt-3 mb-4">
            Enter Your email, after that you will receive message in your
            mailBox ✌️
          </p>
        </div>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="mail" class="form-label fw-medium">Your Email</label>
            <input
              type="email"
              id="mail"
              class="form-control"
              placeholder="test@test.com"
              name="email"
            />
          </div>
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
          <div class="text-center">
            <button type="submit" class="btn btn-primary small py-2 px-5 fs-6">
              Sent
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
  </body>
</html>
