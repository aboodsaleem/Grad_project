<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password|| Home booking service</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"
    />
  </head>
  <body>
    <div class="auth-container bg-white w-100 position-relative">
      <div class="auth-card bg-white text-start">
        <div
          class="d-flex align-items-center justify-content-center gap-2 fw-bold fs-5 mb-4"
        >
          <i class="fas fa-home text-warning"></i>

          <span>Home Booking <span class="text-warning">Services</span></span>
        </div>

        <h2 class="fw-semibold fs-4">Reset Your Password</h2>

        <form>
          <div class="mb-3">
            <label for="newPass" class="form-label fw-medium"
              >New Password</label
            >
            <input type="password" id="newPass" class="form-control" />
          </div>
          <div class="mb-3">
            <label for="confirmPass" class="form-label fw-medium"
              >Confirm Password</label
            >
            <input type="password" id="confirmPass" class="form-control" />
          </div>

          <div>
            <button
              type="submit"
              class="btn btn-primary py-2"
              style="font-size: 14px"
            >
              Save New Password
            </button>
            <button type="reset" class="btn btn-secondary">Reset</button>
          </div>
        </form>
      </div>
    </div>

    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
  </body>
</html>
