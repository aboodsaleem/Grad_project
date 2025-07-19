<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home booking service</title>
    <!-- FONT AWESOME LIBRARY -->
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}" />
    <!-- BOOTSTRAP FRAMEWORK -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <!-- MAIN STYLE FILE -->
    <link rel="stylesheet" href="{{ asset('frontend/css/index.css') }}" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css"
    />
  </head>

  <body>
@include('frontend.body.header')

    <main class="main-content min-vh-100" id="mainContent">
@yield('main')
    </main>

@include('frontend.body.footer')

    <!-- Details Modal -->
    <div
      class="modal fade"
      id="detailsModal"
      tabindex="-1"
      aria-labelledby="detailsModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold" id="detailsModalLabel">
              Service Title
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>

          <div class="modal-body">
            <div class="text-center mb-3">
              <img
                id="modalImage"
                src="https://i.pravatar.cc/150"
                alt="Service Image"
                class="img-fluid rounded mb-2"
                style="max-height: 200px"
              />
            </div>

            <div class="mb-3 text-center">
              <div id="modalPrice" class="fs-5 fw-semibold text-success">
                From $100
              </div>
              <div id="modalRating" class="text-warning"></div>
            </div>

            <p id="modalDescription" class="text-muted text-center">
              Detailed service description goes here.
            </p>

            <hr />

            <div class="bg-light p-3 rounded">
              <h6 class="fw-bold">About This Service</h6>
              <p id="modalDetails" class="mb-0">
                This service helps homeowners book trusted professionals for
                tasks like cleaning, repairs, and more. It ensures quality,
                convenience, and fast response.
              </p>
            </div>
          </div>

          <div class="modal-footer justify-content-between">
            <a class="btn btn-primary" href="login.html">Book Now</a>
            <button class="btn btn-secondary" data-bs-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script type="module" src="{{ asset('frontend/js/main.js') }}"></script>
    <!-- For Each Service Details -->
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const detailsModal = new bootstrap.Modal(
          document.getElementById("detailsModal")
        );
        const titleEl = document.getElementById("detailsModalLabel");
        const descriptionEl = document.getElementById("modalDescription");
        const ratingEl = document.getElementById("modalRating");
        const priceEl = document.getElementById("modalPrice");

        document.querySelectorAll(".service-card").forEach((card, i) => {
          card.querySelector(".btn-secondary").addEventListener("click", () => {
            document.getElementById("detailsModalLabel").textContent =
              card.querySelector(".card-title").textContent;
            document.getElementById("modalDescription").textContent =
              card.querySelector(".description").textContent;
            document.getElementById(
              "modalImage"
            ).src = `https://i.pravatar.cc/150?u=${i}`;

            document.getElementById("modalRating").innerHTML =
              card.querySelector(".rating").outerHTML;
            document.getElementById("modalPrice").innerHTML =
              card.querySelector(".service-price").innerHTML;
            document.getElementById("modalDetails").textContent =
              "This service is part of our trusted home service platform, helping customers book professionals quickly and safely.";
          });
        });
      });
    </script>
  </body>
</html>
