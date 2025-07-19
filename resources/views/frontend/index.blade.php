@extends('frontend.master_dashboard')
@section('main')


<div class="tab-content page-content">
        <!-- Home Page -->
        <div
          class="tab-pane fade show active home-page"
          id="home"
          role="tabpanel"
        >
          <section class="landing">
            <div
              class="container d-flex justify-content-lg-between justify-content-center align-items-center gap-5 flex-wrap flex-lg-nowrap text-center text-md-start"
            >
              <div class="col-lg-6 col intro">
                <h1>Professional Home Services at Your Fingertips</h1>
                <p class="fs-5 mb-5">
                  Book trusted professionals for all your home maintenance
                  needs. Quick, reliable, and hassle-free.
                </p>
                <div
                  class="bg-white p-3 d-flex align-items-center gap-2 flex-column flex-md-row mb-4"
                >
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
                  <div
                    class="flex-fill d-flex align-items-center position-relative"
                  >
                    <input
                      type="text"
                      placeholder="Your location"
                      class="input-group border border-light border-1 rounded-2 py-2 px-3 d-flex align-items-center location"
                      id="location"
                      name="location"
                    />
                    <button
                      class="btn btn-outline-success get-location-btn position-absolute"
                    >
                      Get location
                    </button>
                  </div>
                </div>
                <a class="btn booking-btn" href="login.html">Book a Service</a>
              </div>
              <div class="wrapper-image">
                <img
                  src="{{ asset('frontend/public/assest/home-repair-concept-illustration_114360-7200.avif') }}"
                  alt="landing_page"
                />
              </div>
            </div>
          </section>
          <section class="services py-section">
            <div class="container">
              <div class="title-section text-center mb-5">
                <h2 class="m-0">Our Services</h2>
                <p class="fs-5 mt-3 mb-0">
                  We offer a wide range of professional home services
                </p>
              </div>
              <div class="d-grid">
                <div class="row flex-column flex-md-row gap-5">
                  <div class="col text-center bg-white p-4 shadow rounded-2">
                    <div class="content center-flex flex-column">
                      <span class="icon center-flex mb-3">
                        <i class="fa-solid fa-wrench fa-2x"></i>
                      </span>
                      <h3 class="fs-4">Plumbing</h3>
                      <p>Professional plumbing services for your home</p>
                      <a
                        class="btn btn-link text-decoration-none"
                        href="login.html"
                      >
                        Book now
                      </a>
                    </div>
                  </div>
                  <div class="col text-center bg-white p-4 shadow rounded-2">
                    <div class="content center-flex flex-column">
                      <span class="icon center-flex mb-3">
                        <i class="fa-solid fa-bolt fa-2x"></i>
                      </span>
                      <h3 class="fs-4">Electrical</h3>
                      <p>Reliable electrical repairs and installations</p>
                      <a
                        class="btn btn-link text-decoration-none"
                        href="login.html"
                      >
                        Book now
                      </a>
                    </div>
                  </div>
                  <div class="col text-center bg-white p-4 shadow rounded-2">
                    <div class="content center-flex flex-column">
                      <span class="icon center-flex mb-3">
                        <i class="fa-solid fa-broom fa-2x"></i>
                      </span>
                      <h3 class="fs-4">Cleaning</h3>
                      <p>Thorough home cleaning services</p>
                      <a
                        class="btn btn-link text-decoration-none"
                        href="login.html"
                      >
                        Book now
                      </a>
                    </div>
                  </div>
                  <div class="col text-center bg-white p-4 shadow rounded-2">
                    <div class="content center-flex flex-column">
                      <span class="icon center-flex mb-3">
                        <i class="fa-solid fa-palette fa-2x"></i>
                      </span>
                      <h3 class="fs-4">Painting</h3>
                      <p>Professional interior and exterior painting</p>
                      <a
                        class="btn btn-link text-decoration-none"
                        href="login.html"
                      >
                        Book now
                      </a>
                    </div>
                  </div>
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
                  href="#"
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
                <a href="register.html" class="btn btn-warning text-white"
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
            <div class="mb-4 text-center">
              <input
                type="text"
                id="searchInput"
                class="form-control w-50 mx-auto"
                placeholder="Search by name or description..."
              />
            </div>
            <div
              id="servicesContainer"
              class="row row-cols-1 row-cols-md-3 g-4"
            >
              <div class="col">
                <div
                  class="card bg-white text-center position-relative service-card"
                  data-category="Cleaning"
                >
                  <div class="card-body">
                    <div
                      class="card-img service-icon mx-auto d-flex align-items-center justify-content-center text-white rounded-circle mb-3"
                    >
                      <i class="fas fa-broom"></i>
                    </div>
                    <div class="card-text">
                      <h3 class="card-title fw-semibold fs-4">Deep Cleaning</h3>
                      <p class="mb-3 description">
                        Comprehensive deep cleaning for homes and offices.
                      </p>
                    </div>
                    <div
                      class="d-flex align-items-center justify-content-center mb-3 service-rating gap-2"
                    >
                      <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i
                        ><i class="fas fa-star"></i
                        ><i class="fas fa-star-half-alt"></i
                        ><i class="far fa-star"></i>
                      </div>
                      <span><b>4.2</b></span>
                    </div>
                    <div class="fw-semibold mb-3 service-price">
                      From <span class="text-success">$110</span>
                    </div>
                    <div class="service-actions">
                      <button class="btn btn-primary booking-now-btn">
                        Book Now
                      </button>
                      <button
                        class="btn btn-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#detailsModal"
                      >
                        Details
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div
                  class="card bg-white text-center position-relative service-card"
                  data-category="Electrical"
                >
                  <div class="card-body">
                    <div
                      class="card-img mx-auto d-flex align-items-center justify-content-center text-white rounded-circle mb-3 service-icon"
                    >
                      <i class="fas fa-plug"></i>
                    </div>
                    <div class="card-text">
                      <h3 class="card-title fw-semibold mb-2 fs-4">
                        Socket Replacement
                      </h3>
                      <p class="mb-3 description">
                        Safe replacement of electrical outlets and sockets.
                      </p>
                    </div>
                    <div
                      class="d-flex align-items-center justify-content-center mb-3 service-rating gap-2"
                    >
                      <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i
                        ><i class="fas fa-star"></i><i class="far fa-star"></i
                        ><i class="far fa-star"></i>
                      </div>
                      <span><b>3.8</b></span>
                    </div>
                    <div class="fw-semibold mb-3 service-price">
                      From <span class="text-success">$75</span>
                    </div>
                    <div class="service-actions">
                      <button class="btn btn-primary booking-now-btn">
                        Book Now
                      </button>
                      <button
                        class="btn btn-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#detailsModal"
                      >
                        Details
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div
                  class="card bg-white text-center position-relative service-card"
                  data-category="Handyman"
                >
                  <div class="card-body">
                    <div
                      class="card-img mx-auto d-flex align-items-center justify-content-center text-white rounded-circle mb-3 service-icon"
                    >
                      <i class="fas fa-hammer"></i>
                    </div>
                    <div class="card-text">
                      <h3 class="card-title fw-semibold mb-2 fs-4">
                        Wall Mounting
                      </h3>
                      <p class="mb-3 description">
                        TVs, shelves, mirrors — safely mounted and secured.
                      </p>
                    </div>
                    <div
                      class="d-flex align-items-center justify-content-center mb-3 gap-2 service-rating"
                    >
                      <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i
                        ><i class="fas fa-star-half-alt"></i
                        ><i class="far fa-star"></i><i class="far fa-star"></i>
                      </div>
                      <span><b>3.5</b></span>
                    </div>
                    <div class="fw-semibold mb-3 service-price">
                      From <span class="text-success">$95</span>
                    </div>
                    <div class="service-actions">
                      <button class="btn btn-primary booking-now-btn">
                        Book Now
                      </button>
                      <button
                        class="btn btn-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#detailsModal"
                      >
                        Details
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div
                  class="card bg-white text-center position-relative service-card"
                  data-category="rapair"
                >
                  <div class="card-body">
                    <div
                      class="card-img mx-auto d-flex align-items-center justify-content-center text-white rounded-circle mb-3 service-icon"
                    >
                      <i class="fas fa-blender"></i>
                    </div>
                    <div class="card-text">
                      <h3 class="card-title fw-semibold mb-2 fs-4">
                        Microwave Repair
                      </h3>
                      <p class="mb-3 description">
                        Quick and affordable microwave and kitchen appliance
                        fixes.
                      </p>
                    </div>
                    <div
                      class="d-flex align-items-center justify-content-center mb-3 gap-2 service-rating"
                    >
                      <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i
                        ><i class="fas fa-star"></i><i class="fas fa-star"></i
                        ><i class="far fa-star"></i>
                      </div>
                      <span><b>4.1</b></span>
                    </div>
                    <div class="fw-semibold mb-3 service-price">
                      From <span class="text-success">$80</span>
                    </div>
                    <div class="service-actions">
                      <button class="btn btn-primary booking-now-btn">
                        Book Now
                      </button>
                      <button
                        class="btn btn-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#detailsModal"
                      >
                        Details
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div
                  class="card service-card bg-white text-center position-relative"
                  data-category="Plumbing"
                >
                  <div class="card-body">
                    <div
                      class="card-img service-icon mx-auto d-flex align-items-center justify-content-center text-white rounded-circle mb-3"
                    >
                      <i class="fas fa-faucet"></i>
                    </div>
                    <div class="card-text">
                      <h3 class="card-title fw-semibold mb-2 fs-4">
                        Leak Detection
                      </h3>
                      <p class="mb-3 description">
                        Identify and repair hidden water leaks quickly and
                        cleanly.
                      </p>
                    </div>
                    <div
                      class="d-flex align-items-center justify-content-center mb-3 gap-2 service-rating"
                    >
                      <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i
                        ><i class="fas fa-star-half-alt"></i
                        ><i class="far fa-star"></i><i class="far fa-star"></i>
                      </div>
                      <span><b>3.7</b></span>
                    </div>
                    <div class="fw-semibold mb-3 service-price">
                      From <span class="text-success">$105</span>
                    </div>
                    <div class="service-actions">
                      <button class="btn btn-primary booking-now-btn">
                        Book Now
                      </button>
                      <button
                        class="btn btn-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#detailsModal"
                      >
                        Details
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div
                  class="card service-card bg-white text-center position-relative"
                  data-category="Cleaning"
                >
                  <div class="card-body">
                    <div
                      class="card-img service-icon mx-auto d-flex align-items-center justify-content-center text-white rounded-circle mb-3"
                    >
                      <i class="fas fa-spray-can-sparkles"></i>
                    </div>
                    <div class="card-text">
                      <h3 class="card-title fw-semibold mb-2 fs-4">
                        Window Cleaning
                      </h3>
                      <p class="mb-3 description">
                        Crystal-clear windows inside and out, for homes and
                        offices.
                      </p>
                    </div>
                    <div
                      class="d-flex align-items-center justify-content-center mb-3 gap-2 service-rating"
                    >
                      <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i
                        ><i class="fas fa-star"></i><i class="fas fa-star"></i
                        ><i class="far fa-star"></i>
                      </div>
                      <span><b>4.0</b></span>
                    </div>
                    <div class="fw-semibold mb-3 service-price">
                      From <span class="text-success">$70</span>
                    </div>
                    <div class="service-actions">
                      <button class="btn btn-primary booking-now-btn">
                        Book Now
                      </button>
                      <button
                        class="btn btn-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#detailsModal"
                      >
                        Details
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!--
              <div class="col">
                <div
                  class="card service-card bg-white text-center position-relative"
                  data-category="Cleaning"
                >
                  <div
                    class="card service-icon mx-auto d-flex align-items-center justify-content-center text-white rounded-circle"
                  >
                    <i class="fas fa-spray-can-sparkles"></i>
                  </div>
                  <h3 class="fw-semibold mb-2">Window Cleaning</h3>
                  <p class="mb-3">
                    Crystal-clear windows inside and out, for homes and offices.
                  </p>
                  <div
                    class="service-rating d-flex align-items-center justify-content-center mb-3"
                  >
                    <div class="rating">
                      <i class="fas fa-star"></i><i class="fas fa-star"></i
                      ><i class="fas fa-star"></i><i class="fas fa-star"></i
                      ><i class="far fa-star"></i>
                    </div>
                    <span><b>4.0</b></span>
                  </div>
                  <div class="service-price fw-semibold mb-3">From 70 $</div>
                  <div
                    class="service-actions d-flex gap-10 justify-content-center"
                  >
                    <button
                      class="btn btn-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#bookingModal"
                    >
                      Book Now
                    </button>
                    <button
                      class="btn btn-secondary"
                      data-bs-toggle="modal"
                      data-bs-target="#serviceModal"
                    >
                      Details
                    </button>
                  </div>
                </div>
              </div> -->
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
