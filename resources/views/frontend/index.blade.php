@extends('frontend.master_dashboard')
@section('main')


<div class="tab-content page-content">
        <!-- Home Page -->
<div class="tab-pane fade show active home-page" id="home" role="tabpanel">
  <section class="landing">
    <div class="container d-flex justify-content-lg-between justify-content-center align-items-center gap-5 flex-wrap flex-lg-nowrap text-center text-md-start">
      <div class="col-lg-6 col intro">
        <h1>Professional Home Services at Your Fingertips</h1>
        <p class="fs-5 mb-5">
          Book trusted professionals for all your home maintenance needs. Quick, reliable, and hassle-free.
        </p>
        <div class="bg-white p-3 d-flex align-items-center gap-2 flex-column flex-md-row mb-4">
          <select
                    name="service"
                    id="service"
                    class="custom-select border border-light border-1 rounded-2 py-2 px-3 flex-md-grow-0"
                  >
                    <option value="">Select a Service</option>
                    <option value="plumbing">Plumbing</option>
                    <option value="electrical">Electrical</option>
                    <option value="cleaning">Cleaning</option>
                    <option value="painting">Painting</option>
                  </select>
          <div class="flex-fill d-flex align-items-center position-relative">
            <input type="text" placeholder="Your location" class="input-group border border-light border-1 rounded-2 py-2 px-3 d-flex align-items-center location" id="location" name="location" />
            <button class="btn btn-outline-success get-location-btn position-absolute">Get location</button>
          </div>
        </div>
        <a class="btn booking-btn" href="{{ route('customer.login') }}">Book a Service</a>
      </div>
      <div class="wrapper-image">
        <img src="{{ asset('frontend/public/assest/home-repair-concept-illustration_114360-7200.avif') }}" alt="landing_page" />
      </div>
    </div>
  </section>

  <section class="services py-section">
    <div class="container">
      <div class="title-section text-center mb-5">
        <h2 class="m-0">Our Services</h2>
        <p class="fs-5 mt-3 mb-0">We offer a wide range of professional home services</p>
      </div>
      <div class="d-grid">
        <div class="row flex-column flex-md-row gap-5">
          @foreach($homeServices as $service)
            @php
              switch(strtolower($service->serviceType)) {
                case 'electrical': $icon = 'fa-bolt'; break;
                case 'maintenance': $icon = 'fa-screwdriver-wrench'; break;
                case 'repairing': $icon = 'fa-tools'; break;
                case 'cleaning': $icon = 'fa-broom'; break;
                case 'washing': $icon = 'fa-soap'; break;
                default: $icon = 'fa-cogs'; break;
              }
            @endphp
            <div class="col text-center bg-white p-4 shadow rounded-2">
              <div class="content center-flex flex-column">
                <span class="icon center-flex mb-3">
                  <i class="fa-solid {{ $icon }} fa-2x"></i>
                </span>
                <h3 class="fs-4">{{ $service->serviceType }}</h3>
                <p>{{ $service->description ?? 'High quality service' }}</p>
                <a class="btn btn-link text-decoration-none" href="{{ route('customer.login') }}">Book now</a>
              </div>
            </div>
          @endforeach
        </div>
<button
                  class="btn btn-outline-primary w-fit mx-auto mt-5 view-services-btn"
                  id="viewServices"
                >
                  View All Services
                </button>
            </div>
    </div>
  </section>
   <section class="works py-section">
            <div class="container">
              <div class="title-section text-center mb-5">
                <h2 class="m-0">How It Works</h2>
                <p class="fs-5 mt-3 mb-0">
                  Book a service in just a few simple steps
                </p>
              </div>
              <div class="d-grid">
                <div class="row flex-column flex-md-row gap-4">
                  <div class="col rounded-3 bg-white">
                    <div
                      class="content center-flex flex-column text-center p-4"
                    >
                      <span class="icon mb-3">
                        <i class="fa-solid fa-magnifying-glass"></i>
                      </span>
                      <h3 class="fs-5 fw-semibold mb-2">
                        Search for a service
                      </h3>
                      <p class="mb-0">
                        Browse through our wide range of professional home
                        services
                      </p>
                    </div>
                  </div>
                  <div class="col rounded-3 bg-white">
                    <div
                      class="content center-flex flex-column text-center p-4"
                    >
                      <span class="icon mb-3">
                        <i class="fa-solid fa-calendar"></i>
                      </span>
                      <h3 class="fs-5 fw-semibold mb-2">Book an appointment</h3>
                      <p class="mb-0">
                        Select your preferred date and time for the service
                      </p>
                    </div>
                  </div>
                  <div class="col rounded-3 bg-white">
                    <div
                      class="content center-flex flex-column text-center p-4"
                    >
                      <span class="icon mb-3">
                        <i class="fa-regular fa-circle-check"></i>
                      </span>
                      <h3 class="fs-5 fw-semibold mb-2">Get the job done</h3>
                      <p class="mb-0">
                        Our professionals will arrive and complete the service
                      </p>
                    </div>
                  </div>
                </div>
                <a
                  href="{{ route('login') }}"
                  class="rounded-2 ms-auto me-auto mt-5 bg-primary text-white"
                  >Get Started</a
                >
              </div>
            </div>
          </section>
          <section class="reviews py-section bg-body">
            <div class="container">
              <div class="title-section text-center mb-5">
                <h2 class="m-0">What Our Customers Say</h2>
                <p class="fs-5 mt-3 mb-0">Hear from our satisfied customers</p>
              </div>
              <div class="text-center">
                <button class="btn btn-outline-primary" id="testimoialsBtn">
                  See Testimoials
                </button>
              </div>
            </div>
          </section>
          <section class="get-started py-section">
            <div class="container">
              <div class="title-section text-center">
                <h2 class="m-0 mb-3 text-white">Ready to get started?</h2>
                <p class="fs-5 mb-4">
                  Join thousands of satisfied customers who use our services
                  every day
                </p>
              </div>
              <div class="center-flex flex-wrap gap-3 btns">
                <a href="{{ route('register') }}" class="btn btn-warning text-white"
                  >Sign Up Now</a
                >
                <button
                  class="btn rounded-2 bg-white text-primary view-services-btn"
                >
                  Browser Services
                </button>
              </div>
            </div>
          </section>

  <!-- Keep remaining sections as-is -->
  <!-- ... works, reviews, get-started ... -->
</div>

        <!-- Services Page -->
        <div
          class="tab-pane fade py-5 services-page"
          id="services"
          role="tabpanel"
        >
          <div class="container">
            <div class="text-center mb-4">
              <h2>Available Home Services</h2>
              <p class="fs-5">Browse our trusted service providers</p>
            </div>

        <div class="mb-4">
            <form method="GET" action="{{ route('frontend.home') }}" class="row g-2 justify-content-center align-items-center">
                {{-- حقل البحث --}}
                <div class="col-md-4">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search by name, description, provider..."
                    />
                </div>

                {{-- السعر الأقصى --}}
                <div class="col-md-2">
                    <input
                        type="number"
                        name="maxPrice"
                        value="{{ request('maxPrice') }}"
                        class="form-control"
                        placeholder="Max Price"
                        min="0"
                    />
                </div>

                {{-- نوع الخدمة --}}
                <div class="col-md-3">
                    <select name="serviceType" class="form-control">
                        <option value="">All Types</option>
                        <option value="Electrical" {{ request('serviceType') == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                        <option value="Maintenance" {{ request('serviceType') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="Repairing" {{ request('serviceType') == 'Repairing' ? 'selected' : '' }}>Repairing</option>
                        <option value="Cleaning" {{ request('serviceType') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                        <option value="Washing" {{ request('serviceType') == 'Washing' ? 'selected' : '' }}>Washing</option>
                    </select>
                </div>

                {{-- زر البحث --}}
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Search
                    </button>
                </div>
            </form>
    </div>



            <div
              id="servicesContainer"
              class="row row-cols-1 row-cols-md-3 g-4"
            >
            @foreach ($services as $service)
  <div class="col">
    <div class="card bg-white text-center position-relative service-card" data-category="Cleaning">
      <div class="card-body">
        <img src="{{ asset($service->image ?? 'upload/no_img.jpg') }}"
             alt="Service Image"
             class="service-image d-none"
             style="max-height: 200px; width: 100%; object-fit: cover;" />

        <div class="card-img service-icon mx-auto d-flex align-items-center justify-content-center text-white rounded-circle mb-3">
          <i class="fas fa-broom"></i>
        </div>

        <div class="card-text">
          <h3 class="card-title fw-semibold fs-4">{{ $service->serviceType }}</h3>

          <h5 class="text-primary-emphasis mb-2">
            <i class="fas fa-user-circle me-1 text-secondary"></i>
            <span class="fw-semibold">{{ $service->serviceProvider->username }}</span>
          </h5>

          <p class="mb-3 description">{{ $service->description }}</p>
        </div>

        <div class="d-flex align-items-center justify-content-center mb-3 service-rating gap-2">
          <div class="rating">
            <i class="fas fa-star"></i><i class="fas fa-star"></i>
            <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            <i class="far fa-star"></i>
          </div>
          <span><b>4.2</b></span>
        </div>

        <div class="fw-semibold mb-3 service-price">
          From <span class="text-success">{{ $service->price }}$</span>
        </div>

        <div class="service-actions">
          <a href="{{ route('login') }}" class="btn btn-primary booking-now-btn">Book Now</a>
          <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#detailsModal">Details</button>
        </div>
      </div>
    </div>
  </div>
@endforeach


            </div>
          </div>
        </div>

        <!-- Testimonials Page -->
        <div
          class="tab-pane fade py-5 testimoials-page"
          id="testimonials"
          role="tabpanel"
        >
          <!-- <div>Testimoials Hello Worlds</div> -->
          <div class="container">
            <h2 class="text-center mb-4">What Our Customers Say</h2>
            <p class="text-center text-muted mb-5">
              Read honest reviews from people who used our services.
            </p>

            <div
              id="testimonialContainer"
              class="row row-cols-1 row-cols-md-3 g-4"
            >
              <!-- Testimonial Card 1 -->
              <div class="col">
                <div class="card h-100 shadow-sm p-3 bg-white rounded-3">
                  <div class="d-flex align-items-center mb-3">
                    <img
                      src="{{ asset('frontend/public/assest/ahmed.jpeg') }}"
                      alt="User"
                      class="rounded-circle me-3 object-fit-cover"
                      width="50px"
                      height="50px"
                    />
                    <div>
                      <h5 class="mb-0">Sarah Ahmed</h5>
                      <small class="text-muted">Deep Cleaning</small>
                    </div>
                  </div>
                  <p class="mb-2">
                    The team was amazing—on time, friendly, and extremely
                    thorough! My home has never looked better.
                  </p>
                  <div class="text-warning">★★★★☆</div>
                </div>
              </div>

              <!-- Testimonial Card 2 -->
              <div class="col">
                <div class="card h-100 shadow-sm p-3 bg-white rounded-3">
                  <div class="d-flex align-items-center mb-3">
                    <img
                      src="{{ asset('frontend/public/assest/mike.jpg') }}"
                      alt="User"
                      class="rounded-circle me-3 object-fit-cover"
                      width="50px"
                      height="50px"
                    />
                    <div>
                      <h5 class="mb-0">Omar Khaled</h5>
                      <small class="text-muted">Socket Replacement</small>
                    </div>
                  </div>
                  <p class="mb-2">
                    Quick service and the electrician was very knowledgeable. I
                    would definitely use this again!
                  </p>
                  <div class="text-warning">★★★★★</div>
                </div>
              </div>

              <!-- Testimonial Card 3 -->
              <div class="col">
                <div class="card h-100 shadow-sm p-3 bg-white rounded-3">
                  <div class="d-flex align-items-center mb-3">
                    <img
                      src="{{ asset('frontend/public/assest/yasser.jpg') }}"
                      alt="User"
                      class="rounded-circle me-3 object-fit-cover"
                      width="50px"
                      height="50px"
                    />
                    <div>
                      <h5 class="mb-0">Layla Nassar</h5>
                      <small class="text-muted">Wall Mounting</small>
                    </div>
                  </div>
                  <p class="mb-2">
                    Perfect job mounting my TV. They even helped me clean up
                    afterward. Highly recommended!
                  </p>
                  <div class="text-warning">★★★★☆</div>
                </div>
              </div>

              <!-- Testimonial Card 4 -->
              <div class="col">
                <div class="card h-100 shadow-sm p-3 bg-white rounded-3">
                  <div class="d-flex align-items-center mb-3">
                    <img
                      src="{{ asset('frontend/public/assest/amiii.png') }}"
                      alt="User"
                      class="rounded-circle me-3 object-fit-cover"
                      width="50px"
                      height="50px"
                    />
                    <div>
                      <h5 class="mb-0">Hassan Darwish</h5>
                      <small class="text-muted">Microwave Repair</small>
                    </div>
                  </div>
                  <p class="mb-2">
                    Excellent service—fixed my microwave within an hour and
                    explained how to avoid future issues.
                  </p>
                  <div class="text-warning">★★★★☆</div>
                </div>
              </div>

              <!-- Testimonial Card 5 -->
              <div class="col">
                <div class="card h-100 shadow-sm p-3 bg-white rounded-3">
                  <div class="d-flex align-items-center mb-3">
                    <img
                      src="{{ asset('frontend/public/assest/DavidChen.jpg') }}"
                      alt="User"
                      class="rounded-circle me-3"
                      style="width: 50px; height: 50px; object-fit: cover"
                    />
                    <div>
                      <h5 class="mb-0">Maya Al‑Masri</h5>
                      <small class="text-muted">Window Cleaning</small>
                    </div>
                  </div>
                  <p class="mb-2">
                    My windows are sparkling! The crew was polite and worked
                    quickly without disturbing anyone.
                  </p>
                  <div class="text-warning">★★★★★</div>
                </div>
              </div>

              <!-- Testimonial Card 6 -->
              <div class="col">
                <div class="card h-100 shadow-sm p-3 bg-white rounded-3">
                  <div class="d-flex align-items-center mb-3">
                    <img
                      src="{{ asset('frontend/public/assest/sally.jpg') }}"
                      alt="User"
                      class="rounded-circle me-3 object-fit-cover"
                      width="50px"
                      height="50px"
                    />
                    <div>
                      <h5 class="mb-0">Karim Suleiman</h5>
                      <small class="text-muted">Leak Detection</small>
                    </div>
                  </div>
                  <p class="mb-2">
                    Found and repaired a hidden pipe leak fast—saved me from a
                    huge water bill!
                  </p>
                  <div class="text-warning">★★★★☆</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
