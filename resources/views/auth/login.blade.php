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
    <div class="auth-container bg-white text-center w-100 position-relative">
      <h1
        class="logo d-flex align-items-center justify-content-center gap-3 fw-bold fs-5"
      >
        <i class="fas fa-home"></i>

        <span>Home Booking <span>Services</span></span>
      </h1>
      <div class="auth-card">
        <h2 class="text-dark fw-bold">Login</h2>
    <form  method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group">
            <i class="fas fa-user"></i>
            <input
              type="text"
              placeholder="Enter your Email"
              name="email"
              class="w-100 @error('email') is-invalid @enderror"
            />
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="input-group">
            <i class="fas fa-lock"></i>
            <input
              type="password"
              placeholder="Password"
              name="password"
              class="w-100 @error('password') is-invalid @enderror"
            />
            @error('password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
        <!-- <p><button class="btn btn-link text-decoration-none">Forgot Password?</button></p> -->
            <p>
                <a href="{{ route('password.request') }}" class="btn btn-link forget-btn">
                 Forgot Password?
                </a>
            </p>
      </div>
    </div>



    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
      const resetBySelect = document.getElementById("resetBy");
      const choices = new Choices(resetBySelect, {
        searchEnabled: false,
        itemSelectText: "",
      });
      const notyf = new Notyf();

      const inputCodes = document.querySelectorAll(".verf-code-item input");

      // For Verfication Code
      inputCodes.forEach((input, index) => {
        input.addEventListener("input", function (e) {
          const value = e.target.value;
          if (value && index < inputCodes.length - 1)
            inputCodes[index + 1].focus();
        });

        input.addEventListener("keydown", function (e) {
          if (e.key === "Backspace") {
            if (!e.target.value && index > 0) {
              inputCodes[index - 1].focus();
              inputCodes[index - 1].value = "";
              e.preventDefault();
            }
          }
        });
      });
    </script>
  </body>
</html>
