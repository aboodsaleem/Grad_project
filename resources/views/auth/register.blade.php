<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Home Services</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"
    />
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}" />
  </head>
  <body>
    <div class="auth-container bg-white text-center w-100 position-relative">
      <h1
        class="logo d-flex align-items-center justify-content-center gap-3 fw-bold fs-5"
      >
        <i class="fas fa-home"></i>

        <span>Home Booking <span>Services</span></span>
      </h1>
      <div class="auth-card">
        <h2>Register</h2>
    <form  method="POST" action="{{ route('register') }}">
        @csrf

        <div class="input-group">
            <i class="fas fa-user"></i>
            <input
              type="text"
              placeholder="Full Name"
              name="username"
              class="w-100 @error('username') is-invalid @enderror "
            />
            @error('username')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input
              type="email"
              placeholder="Email"
              name="email"
              class="w-100 @error('email') is-invalid @enderror "
            />
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="input-group">
            <i class="fas fa-phone"></i>
            <input
              type="tel"
              placeholder="Phone Number"
              name="phone"
              class="w-100 @error('phone') is-invalid @enderror "
            />
            @error('phone')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="input-group">
            <i class="fas fa-lock"></i>
            <input
              type="password"
              placeholder="Password"
              name="password"
              class="w-100 @error('password') is-invalid @enderror "
            />
            @error('password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="input-group">
            <i class="fas fa-lock"></i>
            <input
              type="password"
              placeholder="Confirm Password"
              name="password_confirmation"
              class="w-100"
            />
          </div>
          <div class="input-group">
            <i class="fas fa-user-tag"></i>
            <select id="role" name="role">
              <option value="" disabled>Signup As:</option>
              <option value="customer">Customer</option>
              <option value="service_provider">Service Provider</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
      </div>
    </div>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
      const roleSelect = document.getElementById("role");
      const choices = new Choices(roleSelect, {
        searchEnabled: false,
        itemSelectText: "",
      });
      const notyf = new Notyf();
    </script>
  </body>
</html>
