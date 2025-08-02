<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customer Dashboard - Home Services</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/dashboard.css') }}" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

  </head>
  <body>
    <div class="dashboard-container d-flex min-vh-100">
      <!-- Sidebar -->
@include('customer.body.sidebar')

      <!-- Main Content -->
      <main class="main-content flex-grow-1" id="mainContent">
        <!-- Top Header -->
@include('customer.body.header')
        <!-- Page Content -->
        <div class="tab-content page-content customer" id="pills-tabContent">
          <!-- Main Dashboard Content -->
          <div
            class="tab-pane fade show active dashboard-overview"
            id="dashboard"
            role="tabpanel"
          >
            <!-- Quick Actions -->
            <div class="quick-actions">
              <h2 class="fw-semibold mb-20 pb-10">Quick Actions</h2>
              <div class="actions-grid d-grid gap-20">
                <div class="action-card bg-white text-center">
                  <div
                    class="action-icon mt-0 mx-auto mb-3 d-flex align-items-center justify-content-center text-white"
                  >
                    <i class="fas fa-plus"></i>
                  </div>
                  <h3 class="fw-semibold mb-2">Book New Service</h3>
                  <p class="mb-3" p>Book a home service easily</p>
                  <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#bookingModal"
                  >
                    Book Now
                  </button>
                </div>

                <div class="action-card bg-white text-center">
                  <div
                    class="action-icon mt-0 mx-auto mb-3 d-flex align-items-center justify-content-center text-white"
                  >
                    <i class="fas fa-clock"></i>
                  </div>
                  <h3 class="fw-semibold mb-2">Upcoming Bookings</h3>
                  <p class="mb-3">Track your upcoming bookings</p>
                  <button class="btn btn-secondary" id="viewBookings">
                    View Bookings
                  </button>
                </div>

                <div class="action-card bg-white text-center">
                  <div
                    class="action-icon mt-0 mx-auto mb-3 d-flex align-items-center justify-content-center text-white"
                  >
                    <i class="fas fa-star"></i>
                  </div>
                  <h3 class="fw-semibold mb-2">Rate Services</h3>
                  <p class="mb-3">Rate completed services</p>
                  <button class="btn btn-secondary" id="rateBtn">Rate</button>
                </div>

                <div class="action-card bg-white text-center">
                  <div
                    class="action-icon mt-0 mx-auto mb-3 d-flex align-items-center justify-content-center text-white"
                  >
                    <i class="fas fa-headset"></i>
                  </div>
                  <h3 class="fw-semibold mb-2">Support</h3>
                  <p class="mb-3">Contact our support team</p>
                  <button
                    class="btn btn-secondary"
                    data-bs-toggle="modal"
                    data-bs-target="#contactModal"
                  >
                    Contact
                  </button>
                </div>
              </div>
            </div>

            <!-- Recent Bookings -->
            <div class="recent-bookings mt-5 mb-5">
              <h2 class="fw-semibold mb-20 pb-10">Recent Bookings</h2>
              <div class="bookings-list d-flex flex-column gap-3">
                <div
                  class="booking-item p-20 d-flex justify-content-between align-items-center bg-white"
                >
                  <div class="d-flex align-items-center gap-3 booking-info">
                    <div
                      class="service-icon d-flex justify-content-center align-items-center text-white"
                    >
                      <i class="fas fa-wrench"></i>
                    </div>
                    <div class="booking-details">
                      <h4 class="fs-6 fw-semibold">AC Maintenance</h4>
                      <p class="mb-1">Service Provider: Ahmed Mohamed</p>
                      <p class="mb-1">Date: January 15, 2024</p>
                      <p>Time: 2:00 PM</p>
                    </div>
                  </div>
                  <div
                    class="d-flex flex-column align-items-center gap-10 booking-status"
                  >
                    <span class="status fw-medium text-center completed"
                      >Completed</span
                    >
                    <div class="rating">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                  </div>
                </div>

                <div
                  class="booking-item p-20 d-flex justify-content-between align-items-center rounded bg-white"
                >
                  <div class="d-flex align-items-center gap-3 booking-info">
                    <div
                      class="service-icon d-flex justify-content-center align-items-center text-white"
                    >
                      <i class="fas fa-broom"></i>
                    </div>
                    <div class="booking-details">
                      <h4 class="fs-6 fw-semibold">Home Cleaning</h4>
                      <p class="mb-1">Service Provider: Fatima Ali</p>
                      <p class="mb-1">Date: January 18, 2024</p>
                      <p>Time: 10:00 AM</p>
                    </div>
                  </div>
                  <div
                    class="d-flex flex-column align-items-center gap-10 booking-status"
                  >
                    <span class="status fw-medium text-center confirmed"
                      >Confirmed</span
                    >
                    <button
                      class="btn btn-sm btn-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#detailsModal"
                    >
                      Details
                    </button>
                  </div>
                </div>

                <div
                  class="booking-item p-20 d-flex justify-content-between align-items-center rounded bg-white"
                >
                  <div class="d-flex align-items-center gap-3 booking-info">
                    <div
                      class="service-icon d-flex justify-content-center align-items-center text-white"
                    >
                      <i class="fas fa-tools"></i>
                    </div>
                    <div class="booking-details">
                      <h4 class="fs-6 fw-semibold">Plumbing Repair</h4>
                      <p class="mb-1">Service Provider: Mohamed Khaled</p>
                      <p class="mb-1">Date: January 20, 2024</p>
                      <p>Time: 4:00 PM</p>
                    </div>
                  </div>
                  <div
                    class="d-flex flex-column align-items-center gap-10 booking-status"
                  >
                    <span class="status fw-medium text-center pending"
                      >Pending</span
                    >
                    <button class="btn btn-sm btn-secondary">Cancel</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Popular Services -->
            <div class="popular-services bg-white">
              <h2 class="fw-semibold mb-20 pb-10">Popular Services</h2>
              <div class="services-grid d-grid gap-20">
                <div class="service-card p-20 bg-white text-center">
                  <div
                    class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                  >
                    <i class="fas fa-wrench"></i>
                  </div>
                  <h3 class="fw-semibold mb-2">AC Maintenance</h3>
                  <p class="mb-3">Cleaning and maintenance of AC units</p>
                  <div
                    class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                  >
                    <div class="rating">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <span>4.8 (156 reviews)</span>
                  </div>
                  <div class="service-price fw-semibold mb-3">From 150 $</div>
                  <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#bookingModal"
                  >
                    Book Now
                  </button>
                </div>

                <div class="service-card p-20 bg-white text-center">
                  <div
                    class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                  >
                    <i class="fas fa-broom"></i>
                  </div>
                  <h3 class="fw-semibold mb-2">Home Cleaning</h3>
                  <p class="mb-3">
                    Comprehensive cleaning for homes and offices
                  </p>
                  <div
                    class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                  >
                    <div class="rating">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="far fa-star"></i>
                    </div>
                    <span>4.6 (89 reviews)</span>
                  </div>
                  <div class="service-price fw-semibold mb-3">From 200 $</div>
                  <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#bookingModal"
                  >
                    Book Now
                  </button>
                </div>

                <div class="service-card p-20 bg-white text-center">
                  <div
                    class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                  >
                    <i class="fas fa-tools"></i>
                  </div>
                  <h3 class="fw-semibold mb-2">Plumbing Repair</h3>
                  <p class="mb-3">
                    Repair and maintenance of pipes and faucets
                  </p>
                  <div
                    class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                  >
                    <div class="rating">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <span>4.9 (203 reviews)</span>
                  </div>
                  <div class="service-price fw-semibold mb-3">From 120 $</div>
                  <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#bookingModal"
                  >
                    Book Now
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Service Content -->
          <div
            class="tab-pane fade services-page"
            id="services"
            role="tabpanel"
          >
            <div
              class="page-header d-flex align-items-center justify-content-between"
            >
              <h2>All Available Services</h2>
              <div class="filter-options d-flex">
                <select class="filter-select bg-white">
                  <option value="all">All Categories</option>
                  <option value="Cleaning">Cleaning</option>
                  <option value="Appliance Repair">Appliance Repair</option>
                  <option value="Electrical">Electrical</option>
                  <option value="Handyman">Handyman</option>
                  <option value="Plumbing">Plumbing</option>
                </select>
                <select class="sort-select bg-white">
                  <option value="rating">Top Rated</option>
                  <option value="price-low">Price Low to High</option>
                  <option value="price-high">Price High to Low</option>
                  <option value="popular">Most Popular</option>
                </select>
              </div>
            </div>
            <div class="services-grid d-grid gap-20">
              <div
                class="service-card p-20 bg-white text-center position-relative"
                data-category="Electrical"
              >
                <button class="btn p-0 fav-btn">
                  <i class="far fa-heart fav-icon"></i>
                </button>
                <div
                  class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                >
                  <i class="fas fa-bolt"></i>
                </div>
                <h3 class="fw-semibold mb-2 title">Electrical Installation</h3>
                <p class="mb-3 description">
                  Safe and professional electrical installation for home
                  appliances.
                </p>
                <div
                  class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                >
                  <div class="rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i>
                  </div>
                  <span><b>4.8</b></span>
                </div>
                <div class="service-price fw-semibold mb-3">From 150 $</div>
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

              <div
                class="service-card p-20 bg-white text-center position-relative"
                data-category="Plumbing"
              >
                <button class="btn p-0 fav-btn">
                  <i class="far fa-heart fav-icon"></i>
                </button>
                <div
                  class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                >
                  <i class="fas fa-tools"></i>
                </div>
                <h3 class="fw-semibold mb-2 title">Plumbing Repair</h3>
                <p class="mb-3 description">
                  Fixing leaks, broken pipes, and bathroom issues.
                </p>
                <div
                  class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                >
                  <div class="rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star-half-alt"></i>
                  </div>
                  <span><b>4.6</b></span>
                </div>
                <div class="service-price fw-semibold mb-3">From 100 $</div>
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

              <div
                class="service-card p-20 bg-white text-center position-relative"
                data-category="Appliance Repair"
              >
                <button class="btn p-0 fav-btn">
                  <i class="far fa-heart fav-icon"></i>
                </button>
                <div
                  class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                >
                  <i class="fas fa-tools"></i>
                </div>
                <h3 class="fw-semibold mb-2 title">
                  Air Conditioner Maintenance
                </h3>
                <p class="mb-3 description">
                  Regular AC maintenance and filter cleaning services.
                </p>
                <div
                  class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                >
                  <div class="rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star-half-alt"></i>
                  </div>
                  <span><b>4.7</b></span>
                </div>
                <div class="service-price fw-semibold mb-3">From 130 $</div>
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

              <div
                class="service-card p-20 bg-white text-center position-relative"
                data-category="Cleaning"
              >
                <button class="btn p-0 fav-btn">
                  <i class="far fa-heart fav-icon"></i>
                </button>
                <div
                  class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                >
                  <i class="fas fa-broom"></i>
                </div>
                <h3 class="fw-semibold mb-2 title">House Cleaning</h3>
                <p class="mb-3 description">
                  Thorough house cleaning service for apartments and villas.
                </p>
                <div
                  class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                >
                  <div class="rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i>
                  </div>
                  <span><b>4.9</b></span>
                </div>
                <div class="service-price fw-semibold mb-3">From 90 $</div>
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

              <div
                class="service-card p-20 bg-white text-center position-relative"
                data-category="Plumbing"
              >
                <button class="btn p-0 fav-btn">
                  <i class="far fa-heart fav-icon"></i>
                </button>
                <div
                  class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                >
                  <i class="fas fa-tools"></i>
                </div>
                <h3 class="fw-semibold mb-2 title">
                  Water Heater Installation
                </h3>
                <p class="mb-3 description">
                  Safe and quick installation of all types of water heaters.
                </p>
                <div
                  class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                >
                  <div class="rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="far fa-star"></i>
                  </div>
                  <span><b>4.5</b></span>
                </div>
                <div class="service-price fw-semibold mb-3">From 170 $</div>
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

              <div
                class="service-card p-20 bg-white text-center position-relative"
                data-category="Appliance Repair"
              >
                <button class="btn p-0 fav-btn">
                  <i class="far fa-heart fav-icon"></i>
                </button>
                <div
                  class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                >
                  <i class="fas fa-tools"></i>
                </div>
                <h3 class="fw-semibold mb-2 title">Washing Machine Repair</h3>
                <p class="mb-3 description">
                  Repair services for all brands of washing machines.
                </p>
                <div
                  class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                >
                  <div class="rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="far fa-star"></i>
                  </div>
                  <span><b>4.4</b></span>
                </div>
                <div class="service-price fw-semibold mb-3">From 140 $</div>
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

              <div
                class="service-card p-20 bg-white text-center position-relative"
                data-category="Cleaning"
              >
                <button class="btn p-0 fav-btn">
                  <i class="far fa-heart fav-icon"></i>
                </button>
                <div
                  class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                >
                  <i class="fas fa-broom"></i>
                </div>
                <h3 class="fw-semibold mb-2 title">Pest Control</h3>
                <p class="mb-3 description">
                  Effective pest control services using safe and approved
                  chemicals.
                </p>
                <div
                  class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                >
                  <div class="rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star-half-alt"></i>
                  </div>
                  <span><b>4.3</b></span>
                </div>
                <div class="service-price fw-semibold mb-3">From 120 $</div>
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

              <div
                class="service-card p-20 bg-white text-center position-relative"
                data-category="Handyman"
              >
                <button class="btn p-0 fav-btn">
                  <i class="far fa-heart fav-icon"></i>
                </button>
                <div
                  class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                >
                  <i class="fas fa-wrench"></i>
                </div>
                <h3 class="fw-semibold mb-2 title">Furniture Assembly</h3>
                <p class="mb-3 description">
                  Assembly services for all types of home and office furniture.
                </p>
                <div
                  class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                >
                  <div class="rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star-half-alt"></i>
                  </div>
                  <span><b>4.6</b></span>
                </div>
                <div class="service-price fw-semibold mb-3">From 85 $</div>
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

              <div
                class="service-card p-20 bg-white text-center position-relative"
                data-category="plumbing"
              >
                <button class="btn p-0 fav-btn">
                  <i class="far fa-heart fav-icon"></i>
                </button>
                <div
                  class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
                >
                  <i class="fas fa-tools"></i>
                </div>
                <h3 class="fw-semibold mb-2 title">Furniture Assembly</h3>
                <p class="mb-3 description">
                  Assembly services for all types of home and office furniture.
                </p>
                <div
                  class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3"
                >
                  <div class="rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star"></i><i class="fas fa-star"></i
                    ><i class="fas fa-star-half-alt"></i>
                  </div>
                  <span><b>4.6</b></span>
                </div>
                <div class="service-price fw-semibold mb-3">From 100 $</div>
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
            </div>
          </div>

          <!-- Main Bookings Content -->
          <div
            class="tab-pane fade bookings-page"
            id="bookings"
            role="tabpanel"
          >
            <div
              class="page-header d-flex align-items-center justify-content-between"
            >
              <h2>All Bookings</h2>
              <ul
                class="nav nav-pills gap-2 flex-wrap d-flex gap-10 filter-tabs"
                id="bookingFilters"
                role="tablist"
              >
                <li class="nav-item active" role="presentation">
                  <button
                    class="nav-link text-black bg-white tab-btn"
                    data-filter="all"
                    type="button"
                  >
                    All
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link text-black bg-white tab-btn"
                    data-filter="pending"
                    type="button"
                  >
                    Pending
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link text-black bg-white tab-btn"
                    data-filter="confirmed"
                    type="button"
                  >
                    Confirmed
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link text-black bg-white tab-btn"
                    data-filter="completed"
                    type="button"
                  >
                    Completed
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link text-black bg-white tab-btn"
                    data-filter="cancelled"
                    type="button"
                  >
                    Cancelled
                  </button>
                </li>
              </ul>
            </div>

            <div class="bookings-table bg-white overflow-hidden">
              <div
                class="booking-row header d-grid align-items-center fw-semibold"
              >
                <div>Service</div>
                <div>Service Provider</div>
                <div>Date</div>
                <div>Time</div>
                <div>Price</div>
                <div>Status</div>
                <div>Actions</div>
              </div>

              <div
                class="booking-row d-grid align-items-center grid tx-dark"
                data-status="completed"
              >
                <div>AC Maintenance</div>
                <div>Ahmed Mohamed</div>
                <div>2024-01-15</div>
                <div>2:00 PM</div>
                <div class="text-success fw-semibold">$150</div>
                <div>
                  <span class="status fw-medium text-center completed"
                    >Completed</span
                  >
                </div>
                <div>
                  <button
                    class="btn btn-primary btn-sm details-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#detailsModal"
                  >
                    Details
                  </button>
                </div>
              </div>

              <div
                class="booking-row d-grid align-items-center grid tx-dark"
                data-status="confirmed"
              >
                <div>Home Cleaning</div>
                <div>Fatima Ali</div>
                <div>2024-01-18</div>
                <div>10:00 AM</div>
                <div class="text-success fw-semibold">$200</div>
                <div>
                  <span class="status fw-medium text-center confirmed"
                    >Confirmed</span
                  >
                </div>
                <div>
                  <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#ratingModal"
                    id="ratingBtn"
                  >
                    Rate
                  </button>
                  <button
                    class="btn btn-secondary btn-sm details-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#detailsModal"
                  >
                    Details
                  </button>
                </div>
              </div>

              <div
                class="booking-row d-grid align-items-center grid tx-dark"
                data-status="pending"
              >
                <div>Plumbing Repair</div>
                <div>Mohamed Khaled</div>
                <div>2024-01-20</div>
                <div>4:00 PM</div>
                <div class="text-success fw-semibold">$120</div>
                <div>
                  <span class="status fw-medium text-center pending"
                    >Pending</span
                  >
                </div>
                <div>
                  <button class="btn btn-primary btn-sm confirm-btn">
                    Confirm
                  </button>
                  <button
                    class="btn btn-secondary btn-sm details-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#detailsModal"
                  >
                    Details
                  </button>
                </div>
              </div>

              <div
                class="booking-row d-grid align-items-center tx-dark"
                data-status="confirmed"
              >
                <div>Electrical Works</div>
                <div>Ali Hassan</div>
                <div>2024-01-22</div>
                <div>11:00 AM</div>
                <div class="text-success fw-semibold">$180</div>
                <div>
                  <span class="status fw-medium text-center confirmed"
                    >Confirmed</span
                  >
                </div>
                <div>
                  <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#ratingModal"
                    id="ratingBtn"
                  >
                    Rate
                  </button>
                  <button
                    class="btn btn-secondary btn-sm details-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#detailsModal"
                  >
                    Details
                  </button>
                </div>
              </div>

              <!-- No results message, display when No bookings in the any status  -->
              <div
                class="no-results-message d-none text-center text-muted py-4"
              >
                <i class="bi bi-search"></i> No bookings found with this status.
              </div>
            </div>
          </div>

          <!-- Main Favorites Content -->
          <div
            class="tab-pane fade favorites-page"
            id="favorites"
            role="tabpanel"
          >
            <div
              class="page-header d-flex align-items-center justify-content-between"
            >
              <h2>Favorite Service Providers</h2>
            </div>
            <div class="favorites-grid d-grid gap-20">
              <div
                class="favorite-provider bg-white p-20 d-flex align-items-center gap-20"
              >
                <img
                  src="{{ asset('frontend/public/assest/ahmed.jpeg') }}"
                  alt="provider-image"
                  class="provider-avatar rounded-circle object-fit-cover"
                />
                <div class="provider-info flex-fill">
                  <h3 class="fs-5 fw-semibold">Ahmed Mohamed</h3>
                  <p class="text-gray">AC Maintenance Specialist</p>
                  <div
                    class="provider-stats d-flex align-items-center gap-10 my-10 mx-0"
                  >
                    <div class="rating d-flex">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <span>4.8 (156 reviews)</span>
                  </div>
                  <div class="provider-details d-flex flex-column">
                    <span>15 completed services with you</span>
                    <span>Member since 2022</span>
                  </div>
                </div>
                <div class="provider-actions d-flex flex-column gap-10">
                  <a class="btn btn-primary" href="mailto:abood@hotmail.com"
                    >Message</a
                  >
                  <button class="btn btn-sm btn-secondary">
                    Remove from Favorites
                  </button>
                </div>
              </div>

              <div
                class="favorite-provider bg-white p-20 d-flex align-items-center gap-20"
              >
                <img
                  src="{{ asset('frontend/public/assest/anime-boy-chill-digital-art-hd-wallpaper-uhdpaper.com-284@0@j.jpg') }}"
                  alt="provider-image"
                  class="provider-avatar rounded-circle object-fit-cover"
                />
                <div class="provider-info flex-fill">
                  <h3 class="fs-5 fw-semibold">Fatima Ali</h3>
                  <p class="text-gray">Home Cleaning Specialist</p>
                  <div
                    class="provider-stats d-flex align-items-center gap-10 my-10 mx-0"
                  >
                    <div class="rating d-flex">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="far fa-star"></i>
                    </div>
                    <span>4.6 (89 reviews)</span>
                  </div>
                  <div class="provider-details d-flex flex-column">
                    <span>8 completed services with you</span>
                    <span>Member since 2023</span>
                  </div>
                </div>
                <div class="provider-actions d-flex flex-column gap-10">
                  <a class="btn btn-primary" href="mailto:eissam@hotmail.com"
                    >Message</a
                  >
                  <button class="btn btn-sm btn-secondary">
                    Remove from Favorites
                  </button>
                </div>
              </div>

              <div
                class="favorite-provider bg-white p-20 d-flex align-items-center gap-20"
              >
                <img
                  src="{{ asset('frontend/public/assest/DavidChen.jpg') }}"
                  alt="provider-image"
                  class="provider-avatar rounded-circle object-fit-cover"
                />
                <div class="provider-info flex-fill">
                  <h3 class="fs-5 fw-semibold">Mohamed Khaled</h3>
                  <p class="text-gray">Plumbing Repair Specialist</p>
                  <div
                    class="provider-stats d-flex align-items-center gap-10 my-10 mx-0"
                  >
                    <div class="rating d-flex">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <span>4.9 (203 reviews)</span>
                  </div>
                  <div class="provider-details d-flex flex-column">
                    <span>12 completed services with you</span>
                    <span>Member since 2021</span>
                  </div>
                </div>
                <div class="provider-actions d-flex flex-column gap-10">
                  <a class="btn btn-primary" href="mailto:bilalQat@hotmail.com">
                    Message
                  </a>
                  <button class="btn btn-sm btn-secondary">
                    Remove from Favorites
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Profile Content -->
          <div class="tab-pane fade profile-page" id="profile" role="tabpanel">
            <div
              class="profile-header bg-white d-flex align-items-center gap-20"
            >
              <img
                src="{{ asset(Auth::user()->photo ?? 'upload/no_image.jpg') }}"
                alt="Profile Image"
                class="object-fit-cover rounded-circle profile-avatar"
              />
              <div class="profile-info">
                <h2>{{ $customer->username }}</h2>
                <p>Customer since 2025</p>
                <div class="d-flex gap-20 text-gray mt-10 profile-stats">
                  <span>10 Completed Bookings</span>
                  <span>Average Rating: 4.7</span>
                  <span>Member since June 2025</span>
                </div>
              </div>
              <button
                class="btn btn-primary edit-btn"
                data-bs-toggle="modal"
                data-bs-target="#profileModal"
              >
                Create/Edit Profile
              </button>
            </div>

            <div class="profile-sections d-grid gap-20">
              <div class="profile-section bg-white mb-20">
                <h3>Personal Information</h3>
                <div class="info-grid d-grid gap-20 mt-20">
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Full Name</label>
                    <span>{{ $customer->username }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Phone Number</label>
                    <span>{{ $customer->phone }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Email</label>
                    <span>{{ $customer->email }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">City</label>
                    <span>{{ $customer->city }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Address</label>
                    <span>{{ $customer->address }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Date of Birth</label>
                    <span>{{ $customer->date_of_birth }}</span>
                  </div>
                </div>
              </div>

              <div class="profile-section bg-white mb-20">
                <h3>Account Statistics</h3>
                <div class="account-stats d-grid gap-20 mt-20">
                  <div class="stat-item text-center p-20">
                    <div class="stat-number fw-bold">20</div>
                    <div class="stat-label">Completed Bookings</div>
                  </div>
                  <div class="stat-item text-center p-20">
                    <div class="stat-number fw-bold">4.7</div>
                    <div class="stat-label">Average Rating</div>
                  </div>
                  <div class="stat-item text-center p-20">
                    <div class="stat-number fw-bold">12</div>
                    <div class="stat-label">Favorite Service Providers</div>
                  </div>
                  <div class="stat-item text-center p-20">
                    <div class="stat-number fw-bold">2,450</div>
                    <div class="stat-label">Total Amount Paid ($)</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Notifications Content -->
          <div
            class="tab-pane fade notifications-page"
            id="notifications"
            role="tabpanel"
          >
            <div
              class="page-header d-flex align-items-center justify-content-between"
            >
              <h2>Notifications</h2>
              <button class="btn btn-secondary" id="markAll">
                Mark All as Read
              </button>
            </div>

            <div class="notifications-list d-flex flex-column">
              <div
                class="notification-item bg-white p-20 d-flex align-items-center unread"
              >
                <div
                  class="notification-icon rounded-circle d-flex justify-content-center align-items-center text-white"
                >
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="notification-content flex-fill">
                  <h4 class="fs-6 fw-semibold">Your Booking is Confirmed</h4>
                  <p>
                    Your home cleaning service booking with Fatima Ali for
                    January 18 at 10:00 AM is confirmed.
                  </p>
                  <span class="notification-time">2 hours ago</span>
                </div>
                <button
                  class="btn btn-sm btn-secondary mark-read-btn"
                  id="markRead"
                >
                  Mark as Read
                </button>
              </div>

              <div
                class="notification-item bg-white p-20 d-flex align-items-center unread"
              >
                <div
                  class="notification-icon rounded-circle d-flex justify-content-center align-items-center text-white"
                >
                  <i class="fas fa-star"></i>
                </div>
                <div class="notification-content flex-fill">
                  <h4 class="fs-6 fw-semibold">Rate Your Service</h4>
                  <p>
                    Don't forget to rate the AC maintenance service completed by
                    Ahmed Mohamed. Your feedback matters!
                  </p>
                  <span class="notification-time">4 hours ago</span>
                </div>
                <button
                  class="btn btn-sm btn-secondary mark-read-btn"
                  id="markRead"
                >
                  Mark as Read
                </button>
              </div>

              <div
                class="notification-item bg-white p-20 d-flex align-items-center"
              >
                <div
                  class="notification-icon rounded-circle d-flex justify-content-center align-items-center text-white"
                >
                  <i class="fas fa-gift"></i>
                </div>
                <div class="notification-content flex-fill">
                  <h4 class="fs-6 fw-semibold">Special Offer</h4>
                  <p>
                    Get 20% off on cleaning services this week. Use code:
                    CLEAN20
                  </p>
                  <span class="notification-time">1 day ago</span>
                </div>
              </div>

              <div
                class="notification-item bg-white p-20 d-flex align-items-center"
              >
                <div
                  class="notification-icon rounded-circle d-flex justify-content-center align-items-center text-white"
                >
                  <i class="fas fa-clock"></i>
                </div>
                <div class="notification-content flex-fill">
                  <h4 class="fs-6 fw-semibold">Booking Reminder</h4>
                  <p>
                    Reminder: You have a plumbing repair booking tomorrow at
                    4:00 PM
                  </p>
                  <span class="notification-time">2 days ago</span>
                </div>
              </div>

              <div
                class="notification-item bg-white p-20 d-flex align-items-center"
              >
                <div
                  class="notification-icon rounded-circle d-flex justify-content-center align-items-center text-white"
                >
                  <i class="fas fa-user-plus"></i>
                </div>
                <div class="notification-content flex-fill">
                  <h4 class="fs-6 fw-semibold">New Service Provider</h4>
                  <p>
                    A new service provider specializing in painting works has
                    joined in your area. Browse their services now!
                  </p>
                  <span class="notification-time">3 days ago</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Support Content -->
          <div class="tab-pane fade support-page" id="support" role="tabpanel">
            <div class="support-header text-center">
              <h2 class="mb-10">Support</h2>
              <p>
                We are here to help you anytime. Choose your preferred contact
                method
              </p>
            </div>

            <div class="support-options d-grid gap-20">
              <div class="support-card bg-white text-center">
                <div
                  class="support-icon rounded-circle d-flex justify-content-center align-items-center text-white mt-0 mx-auto mb-20"
                >
                  <i class="fas fa-comments"></i>
                </div>
                <h3>Live Chat</h3>
                <p>Talk to our support team directly</p>
                <button class="btn btn-primary">Start Chat</button>
              </div>

              <div class="support-card bg-white text-center">
                <div
                  class="support-icon rounded-circle d-flex justify-content-center align-items-center text-white mt-0 mx-auto mb-20"
                >
                  <i class="fas fa-phone"></i>
                </div>
                <h3>Phone Call</h3>
                <p>Call us at: 920012345</p>
                <button class="btn btn-secondary">Call Now</button>
              </div>

              <div class="support-card bg-white text-center">
                <div
                  class="support-icon rounded-circle d-flex justify-content-center align-items-center text-white mt-0 mx-auto mb-20"
                >
                  <i class="fas fa-envelope"></i>
                </div>
                <h3>Email</h3>
                <p>Send us a message at: support@homeservices.com</p>
                <button class="btn btn-secondary">Send Message</button>
              </div>
            </div>

            <div class="faq-section bg-white">
              <h3>Frequently Asked Questions</h3>
              <div
                class="faq-list accordion d-flex flex-column mt-10"
                id="faqAccordion"
              >
                <div class="faq-item overflow-hidden">
                  <div
                    class="faq-question d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq1"
                    aria-expanded="false"
                    aria-controls="faq1"
                  >
                    <h4 class="fs-6 fw-semibold text-dark">
                      How can I book a service?
                    </h4>
                    <i class="fas fa-chevron-down"></i>
                  </div>
                  <div
                    id="faq1"
                    class="collapse faq-answer"
                    data-bs-parent="#faqAccordion"
                  >
                    <p>
                      You can book a service by browsing available services,
                      choosing the appropriate service, then selecting the
                      service provider and a suitable time for you.
                    </p>
                  </div>
                </div>

                <div class="faq-item overflow-hidden">
                  <div
                    class="faq-question d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq2"
                    aria-expanded="false"
                    aria-controls="faq2"
                  >
                    <h4 class="fs-6 fw-semibold text-dark">
                      How can I cancel a booking?
                    </h4>
                    <i class="fas fa-chevron-down"></i>
                  </div>
                  <div
                    id="faq2"
                    class="collapse faq-answer"
                    data-bs-parent="#faqAccordion"
                  >
                    <p>
                      You can cancel a booking from the "My Bookings" page at
                      least 24 hours before the service time.
                    </p>
                  </div>
                </div>

                <div class="faq-item overflow-hidden">
                  <div
                    class="faq-question d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq3"
                    aria-expanded="false"
                    aria-controls="faq3"
                  >
                    <h4 class="fs-6 fw-semibold text-dark">
                      What payment methods are available?
                    </h4>
                    <i class="fas fa-chevron-down"></i>
                  </div>
                  <div
                    id="faq3"
                    class="collapse faq-answer"
                    data-bs-parent="#faqAccordion"
                  >
                    <p>We accept cash on delivery</p>
                  </div>
                </div>

                <div class="faq-item overflow-hidden">
                  <div
                    class="faq-question d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq4"
                    aria-expanded="false"
                    aria-controls="faq4"
                  >
                    <h4 class="fs-6 fw-semibold text-dark">
                      What if I am not satisfied with the service?
                    </h4>
                    <i class="fas fa-chevron-down"></i>
                  </div>
                  <div
                    id="faq4"
                    class="collapse faq-answer"
                    data-bs-parent="#faqAccordion"
                  >
                    <p>
                      We guarantee service quality. If you are not satisfied,
                      you can contact us within 24 hours and we will work to
                      resolve the issue or refund the amount.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Settings Content -->
          <div
            class="tab-pane fade settings-page"
            id="settings"
            role="tabpanel"
          >
            <div class="settings-section bg-white mb-20">
              <h3>Account Settings</h3>
              <div
                class="setting-item d-flex justify-content-between align-items-center"
              >
                <label>Change Password</label>
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#changePassModal"
                  id="changePassword"
                >
                  Change
                </button>
              </div>
              <div
                class="setting-item d-flex justify-content-between align-items-center"
              >
                <label>Update Email</label>
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#updateEmailModal"
                  id="updateEmail"
                >
                  Update
                </button>
              </div>
              <div
                class="setting-item d-flex justify-content-between align-items-center border-0"
              >
                <label>Update Phone Number</label>
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#updatePhoneModal"
                  id="updatePhoneNumber"
                >
                  Update
                </button>
              </div>
            </div>

            <div class="settings-section bg-white">
              <h3>Notification Settings</h3>
              <div
                class="setting-item d-flex justify-content-between align-items-center"
              >
                <label>New Booking Notifications</label>
                <input type="checkbox" checked />
              </div>
              <div
                class="setting-item d-flex justify-content-between align-items-center"
              >
                <label>Booking Confirmation Notifications</label>
                <input type="checkbox" checked />
              </div>
              <div
                class="setting-item d-flex justify-content-between align-items-center"
              >
                <label>Review Notifications</label>
                <input type="checkbox" checked />
              </div>
              <div
                class="setting-item d-flex justify-content-between align-items-center border-0"
              >
                <label>SMS Messages</label>
                <input type="checkbox" />
              </div>
            </div>
          </div>
        </div>
      </main>

      <!-- Booking Service Modal -->
      <div
        class="modal fade"
        id="bookingModal"
        tabindex="-1"
        aria-labelledby="bookingModalLabel"
        aria-hidden="true"
      >
        <div
          class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
        >
          <div class="modal-content mx-auto p-2">
            <div class="modal-header">
              <h2 class="fw-semibold fs-5">Booking Service</h2>
              <button
                type="button"
                class="btn-close position-absolute end-0 m-3"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>

            <div class="modal-body p-4">
              <form class="booking-form">
                <div class="input-group align-items-center mb-3">
                  <label for="serviceName" class="me-2">Service</label>
                  <input
                    type="text"
                    class="form-control flex-grow-1 rounded-2"
                    id="serviceName"
                    placeholder="Enter the name of service"
                    required
                  />
                </div>
                <div class="input-group align-items-center mb-3">
                  <label for="location" class="me-2">Location</label>
                  <input
                    type="text"
                    class="form-control flex-grow-1 rounded-2"
                    id="Location"
                    placeholder="Your full location address"
                    required
                  />
                  <button
                    class="btn btn-outline-success get-location-btn position-absolute"
                    id="getLocation"
                  >
                    Get location
                  </button>
                </div>
                <div class="input-group align-items-center mb-3">
                  <label for="providerName" class="me-2"
                    >Service Provider</label
                  >
                  <input
                    type="text"
                    class="form-control flex-grow-1 rounded-2"
                    id="providerName"
                    placeholder="Enter the name of provider this service"
                    required
                  />
                </div>
                <div class="input-group align-items-center mb-3">
                  <label for="fullName" class="me-2">Your Name</label>
                  <input
                    type="text"
                    name="fullName"
                    class="form-control flex-grow-1 rounded-2"
                    id="fullName"
                    placeholder="Enter your name"
                    required
                  />
                </div>
                <div class="input-group align-items-center mb-3">
                  <label for="email" class="me-2">Email</label>
                  <input
                    type="text"
                    name="email"
                    id="email"
                    class="form-control flex-grow-1 rounded-2"
                    placeholder="Your Email"
                    required
                  />
                </div>

                <div class="input-group align-items-center mb-3">
                  <label for="date" class="me-2">Date</label>
                  <input
                    type="date"
                    name="date"
                    id="date"
                    class="form-control flex-grow-1 rounded-2"
                    title="Enter the Date you booking service in it"
                    required
                  />
                </div>

                <div class="input-group align-items-center mb-3">
                  <label for="startTime" class="me-2">Start time</label>
                  <input
                    type="time"
                    id="startTime"
                    name="startTime"
                    class="form-control flex-grow-1 rounded-2"
                    title="The time you need the service start work in your date"
                    required
                  />
                </div>

                <div class="input-group align-items-center mb-3">
                  <label for="endTime" class="me-2">End time</label>
                  <input
                    type="time"
                    id="endTime"
                    name="endTime"
                    class="form-control flex-grow-1 rounded-2"
                    title="The time you need the service end work in your date"
                    required
                  />
                </div>

                <div class="input-group align-items-start mb-3">
                  <label for="specialRequests" class="me-2"
                    >Special Requests</label
                  >
                  <textarea
                    id="specialRequests"
                    name="specialRequests"
                    class="form-control flex-grow-1 rounded-2"
                    placeholder="If you need a special thing"
                  ></textarea>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary me-2">
                    Confirm
                  </button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Service Details Modal -->
      <div
        class="modal fade"
        id="serviceModal"
        tabindex="-1"
        aria-labelledby="serviceModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content p-3 mx-auto">
            <div class="modal-header">
              <h2 class="fs-5 fw-semibold">Service Details</h2>
              <button
                type="button"
                class="btn-close position-absolute end-0 m-3"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>

            <div class="modal-body">
              <div
                class="d-flex flex-column flex-md-row align-items-center gap-20"
              >
                <div class="modal-image rounded text-center">
                  <img
                    src="{{ asset('frontend/public/assest/sarah.jpg') }}"
                    alt="provider-name"
                    class="img-fluid rounded"
                    width="150"
                  />
                </div>

                <div class="modal-info flex-fill">
                  <div class="content">
                    <h2 class="fw-bold">Service Title</h2>
                    <p>
                      <i class="fas fa-align-left"></i>
                      <strong>Description:</strong>
                      <span id="description">Example description</span>
                    </p>
                    <p>
                      <i class="fas fa-tags"></i>
                      <strong>Category:</strong>
                      <span id="category">Plumbing</span>
                    </p>
                    <p>
                      <i class="fas fa-dollar-sign"></i>
                      <strong>Price:</strong>
                      <span class="text-success fw-bold" id="price">150$</span>
                    </p>
                    <p>
                      <i class="fas fa-star"></i>
                      <strong>Rating:</strong> <span id="rating">4.8</span>
                    </p>
                    <p>
                      <i class="fas fa-map-marker-alt"></i>
                      <strong>Location:</strong> <span id="location">Gaza</span>
                    </p>
                    <p>
                      <i class="fas fa-check-circle"></i>
                      <strong>Status:</strong>
                      <span id="status">Available</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Rating Modal -->
      <div
        id="ratingModal"
        class="modal fade"
        tabindex="-1"
        aria-labelledby="ratinfModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content p-2">
            <div class="modal-header">
              <h2
                class="modal-title fs-5 fw-semibold"
                id="updatePhoneModalLabel"
              >
                Rate Service
              </h2>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>

            <div class="modal-body">
              <form id="ratingForm">
                <div
                  class="input-group d-flex flex-column justify-content-start mb-3"
                >
                  <label for="rating" class="form-label">Rating (1 to 5)</label>
                  <input
                    type="number"
                    min="1"
                    max="5"
                    id="rating"
                    class="form-control w-100 rounded-2"
                    required
                  />
                </div>
                <div
                  class="input-group d-flex flex-column justify-content-start"
                >
                  <label for="comment" class="form-label">Comment</label>
                  <textarea
                    id="comment"
                    class="form-control w-100 rounded-2"
                  ></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-4">
                  Submit Rating
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Booking Details Modal  -->
      <div
        id="detailsModal"
        class="modal fade modal-details-grid"
        tabindex="-1"
        aria-labelledby="detailsModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content mx-auto py-3 px-2">
            <div class="modal-header mb-2">
              <h2 class="modal-title fs-5">Booking Details</h2>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>

            <div class="text-center">
              <div class="modal-image text-center">
                <img
                  src="{{ asset('frontend//public/assest/6991150.jpg') }}"
                  alt="provider-name"
                  class="rounded-circle object-fit-cover provider-image mt-2"
                  id="detailsAvatar"
                />
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <strong>Service:</strong>
                  <span id="detailsService">Home Cleaning </span>
                </li>
                <li class="list-group-item">
                  <strong>Provider:</strong>
                  <span id="detailsProvider">Bilal Khaled</span>
                </li>
                <li class="list-group-item">
                  <strong>Date:</strong>
                  <span id="detailsDate">January 18, 2024</span>
                </li>
                <li class="list-group-item">
                  <strong>Time:</strong> <span id="detailsTime">10:00 AM</span>
                </li>
                <li class="list-group-item">
                  <strong>Price:</strong>
                  <span id="detailsPrice" class="text-success fw-bold"
                    >150$</span
                  >
                </li>
                <li class="list-group-item">
                  <strong>Status:</strong>
                  <span id="detailsStatus">Confirmed</span>
                </li>
              </ul>

              <button class="btn btn-primary mt-3" id="cancelBookingBtn">
                Cancel
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Profle Modal -->
      <div
        id="profileModal"
        class="modal fade"
        tabindex="-1"
        aria-labelledby="profileModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content p-2">
            <div class="modal-header">
              <h2 class="modal-title">Edit Profile</h2>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
               <form action="{{ route('customer.update',$customer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Full Name -->
                <div class="mb-3">
                  <label for="fullName" class="form-label">Full Name</label>
                  <input
                    name="username"
                    type="text"
                    class="form-control"
                    id="fullName"
                    placeholder="Enter full name"
                    value="{{ $customer->username }}"
                  />
                </div>

                <!-- Phone -->
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input
                    name="phone"
                    type="tel"
                    class="form-control"
                    id="phone"
                    placeholder="+966 50 123 4567"
                    value="{{ $customer->phone }}"
                  />
                </div>

                <!-- Email -->
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    name="email"
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="eissam@example.com"
                    value="{{ $customer->email }}"
                  />
                </div>

                <!-- City -->
                <div class="mb-3">
                  <label for="city" class="form-label">City</label>
                  <input
                    name="city"
                    type="text"
                    class="form-control"
                    id="city"
                    placeholder="City"
                    value="{{ $customer->city }}"
                  />
                </div>

                <!-- Address -->
                <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <input
                    name="address"
                    type="text"
                    class="form-control"
                    id="address"
                    placeholder="Address"
                    value="{{ $customer->address }}"
                  />
                </div>

                <!-- Data Of Birthday -->
                <div class="mb-3">
                  <label for="dob" class="form-label">Date Of BirthDay</label>
                  <input
                    name="date_of_birth"
                    type="date"
                    class="form-control"
                    id="dob"
                    placeholder="Date Of BirthDay"
                    value="{{ $customer->date_of_birth }}"
                  />
                </div>

                <!-- Profile Image Upload -->
                <div class="d-flex align-items-center justify-content-between">
                  <label
                    for="profileImageInput"
                    class="small mb-0"
                    style="width: 150px"
                    >Upload Image</label
                  >
                  <input
                    name="photo"
                    type="file"
                    class="form-control form-control-sm flex-fill"
                    accept="image/*"
                    id="profileImageInput"
                  />
                </div>

                <!-- Save Button -->
                <div class="d-flex justify-content-end mt-5">
                  <button type="submit" class="btn btn-primary">
                    Save Changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Change password modal -->
      <div
        class="modal fade"
        id="changePassModal"
        tabindex="-1"
        aria-labelledby="changePassModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="updatePhoneNumberModalLabel">
                Change Password
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <form id="modalForm" method="POST" action="{{ route('customer.update.password',$customer->id) }}">
                @csrf
                <div class="form-group">
                  <label for="modalInput">Enter new value:</label>
                  <input
                    name="new_password"
                    type="text"
                    id="modalInput"
                    class="form-control"
                    required
                    style="width: 100%; padding: 8px; margin-top: 5px"
                  />
                    @error('new_password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-4 text-end">
                  <button
                    type="reset"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary" id="saveBtn">
                    Save changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Update email modal -->
      <div
        class="modal fade"
        id="updateEmailModal"
        tabindex="-1"
        aria-labelledby="updateEmailModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="updateEmailModalLabel">
                Update Email
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
        <form id="emailUpdateForm" method="POST" action="{{ route('customer.update.email',$customer->id) }}">
            @csrf
            <div class="form-group">
                  <label for="modalInput">Enter new value:</label>
                  <input
                    name="email"
                    type="text"
                    id="emailInput"
                    class="form-control emailInput"
                    required
                    style="width: 100%; padding: 8px; margin-top: 5px"
                    value="{{ $customer->email}}"
                  />
                </div>

                <div class="mt-4 text-end">
                  <button
                    type="reset"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary" id="saveBtn">
                    Save changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Update phone_number modal -->
      <div
        class="modal fade"
        id="updatePhoneModal"
        tabindex="-1"
        aria-labelledby="updatePhoneModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="updatePhoneModalLabel">
                Update Phone Number
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
            <form id="phoneUpdateForm" method="POST" action="{{ route('customer.update.phone',$customer->id) }}">
                @csrf
                <div class="form-group">
                  <label for="phoneInput">Enter new value:</label>
                  <input
                    name="phone"
                    type="text"
                    id="phoneInput"
                    class="form-control"
                    required
                    style="width: 100%; padding: 8px; margin-top: 5px"
                    value="{{ $customer->phone}}"
                  />
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>

                <div class="mt-4 text-end">
                  <button
                    type="reset"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary" id="saveBtn">
                    Save changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Connect modal -->
      <div
        class="modal fade"
        id="contactModal"
        tabindex="-1"
        aria-labelledby="contactModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title fs-6 fw-bold text-center">
                Welcome, If you have any issue sent to us, and we'll contact
                with you ✌️
              </h2>
              <button
                type="button"
                class="btn-close ms-auto"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="input-group p-10">
                  <label for="fullName" class="form-label">Full Name</label>
                  <input
                    type="text"
                    id="fullName"
                    placeholder="Abood Eissam"
                    required
                  />
                </div>
                <div class="input-group p-10">
                  <label for="email" class="form-label">Email Address</label>
                  <input
                    type="email"
                    id="email"
                    class="form-text"
                    placeholder="test@test.com"
                    required
                  />
                </div>

                <div class="input-group p-10">
                  <label for="notes" class="form-label"
                    >Tell us Anything you want</label
                  >
                  <textarea
                    id="notes"
                    class="form-text"
                    placeholder="Notes"
                  ></textarea>
                </div>

                <div class="form-actions text-center">
                  <button type="submit" class="btn btn-primary me-2">
                    Sent
                  </button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
      const notyf = new Notyf();
    </script>
    <script type="module" src="{{ asset('frontend/js/dashboard.js') }}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

@if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;

    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;

    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;

    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break;
 }
 @endif
</script>
  </body>
</html>
