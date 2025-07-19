@extends('service_provider.serviceprovider_Dashboard')
@section('main')
<div class="tab-content page-content provider" id="pills-tabContent">
          <!-- Main Dashboard Content -->
          <div
            class="tab-pane fade show active dashboard-overview"
            id="dashboard"
            role="tabpanel">
            <div class="stats-grid d-grid gap-20">
              <div class="stat-card bg-white d-flex align-items-center gap-20">
                <div
                  class="stat-icon d-flex align-items-center justify-content-center text-white"
                >
                  <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                  <h3>Today's Bookings</h3>
                  <p class="stat-number fw-bold">12</p>
                  <span class="stat-change positive fw-medium">+15%</span>
                </div>
              </div>

              <div class="stat-card bg-white d-flex align-items-center gap-20">
                <div
                  class="stat-icon d-flex align-items-center justify-content-center text-white"
                >
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                  <h3>Monthly Earnings</h3>
                  <p class="stat-number fw-bold">2,450 $</p>
                  <span class="stat-change positive fw-medium">+8%</span>
                </div>
              </div>

              <div class="stat-card bg-white d-flex align-items-center gap-20">
                <div
                  class="stat-icon d-flex align-items-center justify-content-center text-white"
                >
                  <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                  <h3>Overall Rating</h3>
                  <p class="stat-number fw-bold">4.8</p>
                  <span class="stat-change positive fw-medium">+0.2</span>
                </div>
              </div>

              <div class="stat-card bg-white d-flex align-items-center gap-20">
                <div
                  class="stat-icon d-flex align-items-center justify-content-center text-white"
                >
                  <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                  <h3>New Customers</h3>
                  <p class="stat-number fw-bold">28</p>
                  <span class="stat-change positive fw-medium">+12%</span>
                </div>
              </div>
            </div>

            <!-- Upcoming Bookings -->
            <div class="upcoming-bookings bg-white mb-3">
              <h2 class="fs-3 fw-semibold pb-2 mb-3">Upcoming Bookings</h2>
              <div class="bookings-list d-flex flex-column gap-3">
                <div
                  class="booking-item p-20 d-flex justify-content-between align-items-center"
                >
                  <div class="booking-info">
                    <h4 class="fs-6 fw-semibold mb-1">AC Maintenance</h4>
                    <p>Client: Sara Ahmed</p>
                    <p>Time: Today 2:00 PM</p>
                  </div>
                  <div class="booking-actions">
                    <button gap-10 class="btn btn-primary">Accept</button>
                    <button class="btn btn-secondary">Reject</button>
                  </div>
                </div>

                <div
                  class="booking-item p-20 d-flex justify-content-between align-items-center"
                >
                  <div class="booking-info">
                    <h4 class="fs-6 fw-semibold mb-1">Home Cleaning</h4>
                    <p>Client: Mohamed Ali</p>
                    <p>Time: Tomorrow 10:00 AM</p>
                  </div>
                  <div class="booking-actions d-flex gap-10">
                    <button class="btn btn-primary">Accept</button>
                    <button class="btn btn-secondary">Reject</button>
                  </div>
                </div>

                <div
                  class="booking-item p-20 d-flex justify-content-between align-items-center"
                >
                  <div class="booking-info">
                    <h4 class="fs-6 fw-semibold mb-1">Plumbing Repair</h4>
                    <p>Client: Fatima Khalid</p>
                    <p>Time: Day after tomorrow 4:00 PM</p>
                  </div>
                  <div class="booking-actions">
                    <button gap-10 class="btn btn-primary">Accept</button>
                    <button class="btn btn-secondary">Reject</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Recent Reviews -->
            <div class="recent-reviews bg-white">
              <h2 class="fs-3 fw-semibold pb-2 mb-3">Recent Reviews</h2>
              <div class="reviews-list d-flex flex-column gap-3">
                <div class="review-item">
                  <div
                    class="review-header d-flex justify-content-between align-items-center mb-10"
                  >
                    <span class="customer-name fw-semibold">Ahmed Mahmoud</span>
                    <div class="rating d-flex">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                  </div>
                  <p class="review-text fw-light">
                    Excellent and fast service, highly recommended!
                  </p>
                </div>

                <div class="review-item">
                  <div
                    class="review-header d-flex justify-content-between align-items-center mb-10"
                  >
                    <span class="customer-name fw-semibold">Noura Salem</span>
                    <div class="rating d-flex">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="far fa-star"></i>
                    </div>
                  </div>
                  <p class="review-text fw-light">
                    Good work but arrived a bit late.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Services Content -->
          <div
            class="tab-pane fade services-page"
            id="services"
            role="tabpanel"
          >
            <div
              class="d-flex justify-content-between align-items-center page-header"
            >
              <h2 class="fw-semibold">My Available Services</h2>
              <button
                class="btn btn-primary add-btn"
                data-bs-toggle="modal"
                data-bs-target="#addServiceModal"
              >
                Add New Service
              </button>
            </div>
            <div class="services-grid d-grid gap-20">
              <div
                class="service-card p-20 d-flex flex-column justify-content-center align-items-center"
              >
                <div
                  class="service-icon text-white d-flex justify-content-center align-items-center rounded-circle mb-3"
                >
                  <i class="fas fa-broom"></i>
                </div>
                <h3 class="fw-bold fs-4">Pest Control</h3>
                <p>
                  Effective pest control services using safe and approved
                  chemicals.
                </p>
                <div class="service-price fw-medium text-success mb-2">
                  Base Price: $120
                </div>
                <div class="service-actions">
                  <button
                    class="btn btn-primary edit-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#editServiceModal"
                  >
                    Edit
                  </button>
                  <button class="btn btn-secondary delete-btn">Delete</button>
                </div>
              </div>
              <div
                class="service-card p-20 d-flex flex-column justify-content-center align-items-center"
              >
                <div
                  class="service-icon text-white d-flex justify-content-center align-items-center rounded-circle mb-3"
                >
                  <i class="fas fa-tools"></i>
                </div>
                <h3 class="fw-bold fs-4">Furniture Assembly</h3>
                <p>
                  Assembly services for all types of home and office furniture.
                </p>
                <div class="service-price fw-medium text-success mb-2">
                  Base Price: $120
                </div>

                <div class="service-actions">
                  <button
                    class="btn btn-primary edit-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#editServiceModal"
                  >
                    Edit
                  </button>
                  <button class="btn btn-secondary delete-btn">Delete</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Booking Content -->
          <div
            class="tab-pane fade bookings-page"
            id="bookings"
            role="tabpanel"
          >
            <div
              class="d-flex justify-content-between align-items-center page-header"
            >
              <h2>All Bookings</h2>
              <ul
                class="nav nav-pills gap-2 flex-wrap d-flex gap-10 filter-tabs"
                id="bookingFilters"
                role="tablist"
              >
                <li class="nav-item active" role="presentation">
                  <button
                    type="button"
                    class="nav-link text-black bg-white tab-btn active"
                    data-filter="all"
                  >
                    All
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    type="button"
                    class="nav-link text-black bg-white tab-btn"
                    data-filter="pending"
                  >
                    Pending
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    type="button"
                    class="nav-link text-black bg-white tab-btn"
                    data-filter="confirmed"
                  >
                    Confirmed
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    type="button"
                    class="nav-link text-black bg-white tab-btn"
                    data-filter="completed"
                  >
                    Completed
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    type="button"
                    class="nav-link text-black bg-white tab-btn"
                    data-filter="cancelled"
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
                <div>Client</div>
                <div>Date</div>
                <div>Time</div>
                <div>Status</div>
                <div>Actions</div>
              </div>

              <div
                class="booking-row d-grid align-items-center grid tx-dark"
                data-status="pending"
              >
                <div>AC Maintenance</div>
                <div>Sara Ahmed</div>
                <div>2024-01-15</div>
                <div>2:00 PM</div>
                <div>
                  <span class="status fw-medium text-center pending"
                    >Pending</span
                  >
                </div>
                <div>
                  <button class="btn btn-primary btn-sm">Accept</button>
                  <button class="btn btn-secondary btn-sm">Reject</button>
                </div>
              </div>

              <div
                class="booking-row d-grid align-items-center grid tx-dark"
                data-status="confirmed"
              >
                <div>Home Cleaning</div>
                <div>Mohamed Ali</div>
                <div>2024-01-16</div>
                <div>10:00 AM</div>
                <div>
                  <span class="status fw-medium text-center confirmed"
                    >Confirmed</span
                  >
                </div>
                <div>
                  <button
                    class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmedBookingDetailsModal"
                  >
                    Details
                  </button>
                </div>
              </div>

              <div
                class="booking-row d-grid align-items-center grid tx-dark"
                data-status="completed"
              >
                <div>Plumbing Repair</div>
                <div>Fatima Khalid</div>
                <div>2024-01-17</div>
                <div>4:00 PM</div>
                <div>
                  <span class="status fw-medium text-center completed"
                    >Completed</span
                  >
                </div>
                <div>
                  <button
                    class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#ratedBookingDetailsModal"
                  >
                    View Details
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

          <!-- Main Profile Content -->
          <div class="tab-pane fade profile-page" role="tabpanel" id="profile">
            <div
              class="profile-header bg-white d-flex align-items-center gap-20"
            >
              <img
                src="{{ asset($service_provider->photo ?? 'upload/no_image.jpg') }}"
                alt="Profile Image"
                class="object-fit-cover rounded-circle profile-avatar"
              />
              <div class="profile-info">
                <h2>{{ $service_provider->username }}</h2>
                <p>Home Service Provider</p>
                <div class="d-flex gap-20 text-gray mt-10 profile-stats">
                  <span>Rating: <b>4.8</b></span>
                  <span><b>156</b> Completed Bookings</span>
                  <span>Member since <b>2025</b></span>
                </div>
              </div>
              <button
                class="btn btn-primary"
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
                    <span>{{ $service_provider->username }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Phone Number</label>
                    <span>{{ $service_provider->phone }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Email</label>
                    <span>{{ $service_provider->email }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">City</label>
                    <span>{{ $service_provider->city }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Address</label>
                    <span>{{ $service_provider->address }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Date of Birth</label>
                    <span>{{ $service_provider->date_of_birth }}</span>
                  </div>
                </div>
              </div>

              <div class="profile-section bg-white mb-20">
                <h3>Specialized Services</h3>
                <div class="d-flex flex-wrap gap-10 specialties">
                  <span class="specialty-tag text-white">AC Maintenance</span>
                  <span class="specialty-tag text-white">Home Cleaning</span>
                  <span class="specialty-tag text-white">Plumbing Repair</span>
                  <span class="specialty-tag text-white">Electricity</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Earninigs Content -->
          <div
            class="tab-pane fade earnings-page"
            role="tabpanel"
            id="earnings"
          >
            <div class="earnings-summary d-grid gap-20">
              <div class="earning-card bg-white text-center">
                <h3 class="m-0 fs-6 fw-bolder">Today's Earnings</h3>
                <p class="earning-amount fw-bold mt-10 mb-0">$450</p>
              </div>
              <div class="earning-card bg-white text-center">
                <h3 class="m-0 fs-6 fw-bolder">This Week's Earnings</h3>
                <p class="earning-amount fw-bold mt-10 mb-0">$2,100</p>
              </div>
              <div class="earning-card bg-white text-center">
                <h3 class="m-0 fs-6 fw-bolder">This Month's Earnings</h3>
                <p class="earning-amount fw-bold mt-10 mb-0">$8,750</p>
              </div>
              <div class="earning-card bg-white text-center">
                <h3 class="m-0 fs-6 fw-bolder">Total Earnings</h3>
                <p class="earning-amount fw-bold mt-10 mb-0">$45,200</p>
              </div>
            </div>

            <div class="earnings-history bg-white">
              <h3 class="fs-6 fw-bolder mb-3">Earnings History</h3>
              <div class="earnings-table bg-white overflow-hidden">
                <div class="earning-row header d-grid align-items fw-semibold">
                  <div>Date</div>
                  <div>Service</div>
                  <div>Client</div>
                  <div>Amount</div>
                </div>
                <div class="earning-row d-grid align-items-center">
                  <div>2024-01-15</div>
                  <div>AC Maintenance</div>
                  <div>Sara Ahmed</div>
                  <div class="text-success fw-bold">$150</div>
                </div>
                <div class="earning-row d-grid align-items-center">
                  <div>2024-01-14</div>
                  <div>Home Cleaning</div>
                  <div>Mohamed Ali</div>
                  <div class="text-success fw-bold">$200</div>
                </div>
                <div class="earning-row d-grid align-items-center">
                  <div>2024-01-13</div>
                  <div>Plumbing Repair</div>
                  <div>Fatima Khalid</div>
                  <div class="text-success fw-bold">$120</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Reviews Content -->
          <div class="tab-pane fade reviews-page" role="tabpanel" id="reviews">
            <div class="reviews-summary bg-white">
              <div class="rating-overview text-center">
                <div class="overall-rating d-inline-block">
                  <h3 class="fw-bold text-dark">Average Of Rating:</h3>
                  <span class="rating-number d-block fw-bold">4.8</span>
                  <div class="rating-stars my-10">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                  </div>
                  <p class="fs-6 mt-2">
                    <span class="text-gray me-1"><b>Total Reviews:</b></span
                    >From 156 reviews
                  </p>
                </div>
              </div>
            </div>

            <div class="reviews-list flex-column d-flex">
              <div class="review-item">
                <div
                  class="review-header d-flex justify-content-between align-items-center mb-10 gap-3"
                >
                  <img
                    src="public/assest/ahmed.jpeg"
                    alt="Client Image"
                    class="reviewer-avatar rounded-circle object-fit-cover"
                    width="50px"
                    height="50px"
                  />
                  <div class="reviewer-info flex-grow-1">
                    <h4>Ahmed Mahmoud</h4>
                    <div class="d-flex align-items-center gap-2">
                      <div class="rating d-flex">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                      </div>
                      <span class="fw-semibold text-muted">4.6</span>
                    </div>
                    <span class="review-date text-gray">2 days ago</span>
                  </div>
                </div>
                <p class="review-text">
                  Excellent and fast service, highly recommended! Arrived on
                  time and completed the work perfectly.
                </p>
              </div>

              <div class="review-item">
                <div
                  class="review-header d-flex justify-content-between align-items-center mb-10 gap-3"
                >
                  <img
                    src="public/assest/sarah.jpg"
                    alt="Client Image"
                    class="reviewer-avatar rounded-circle object-fit-cover"
                    width="50px"
                    height="50px"
                  />
                  <div class="reviewer-info flex-grow-1">
                    <h4>Noura Salem</h4>
                    <div class="d-flex align-items-center gap-2">
                      <div class="rating d-flex">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                      </div>
                      <span class="fw-semibold text-muted">3.5</span>
                    </div>
                    <span class="review-date text-gray">1 week ago</span>
                  </div>
                </div>
                <p class="review-text">
                  Good work but arrived a bit late. Overall satisfied with the
                  service.
                </p>
              </div>
            </div>
          </div>

          <!-- Main Settings Content -->
          <div
            class="tab-pane fade settings-page"
            role="tabpanel"
            id="settings"
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
                class="setting-item d-flex justify-content-between align-items-center border-bottom-0"
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
                <label>Review Notifications</label>
                <input type="checkbox" checked />
              </div>
              <div
                class="setting-item d-flex justify-content-between align-items-center border-bottom-0"
              >
                <label>Message Notifications</label>
                <input type="checkbox" />
              </div>
            </div>
          </div>
        </div>
@endsection
