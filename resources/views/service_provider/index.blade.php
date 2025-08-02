@extends('service_provider.serviceprovider_Dashboard')
@section('main')
@if(Auth::user()->status != 'active')
    {{-- Alert message for inactive account --}}
<div class="container mt-5" style="max-width: 500px;">
  <div class="card border-success shadow-sm rounded-3">
    <div class="card-body d-flex align-items-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="green" stroke-width="2" viewBox="0 0 24 24" class="me-3">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
      </svg>
      <div>
        <h4 class="text-success fw-bold mb-2">Your Vendor Account is notActive</h4>
        <p class="mb-0 text-secondary">Please wait while the admin reviews and approves your account.</p>
      </div>
    </div>
  </div>
</div>

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


@else
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

  @if($bookings->isEmpty())
    <p class="text-muted">No upcoming bookings.</p>
  @else
    <div class="bookings-list d-flex flex-column gap-3">
      @foreach($pendingBooking as $booking)
        <div class="booking-item p-20 d-flex justify-content-between align-items-center">
          <div class="booking-info">
            <h4 class="fs-6 fw-semibold mb-1">{{ $booking->service->name }}</h4>
            <p>Customer: {{ $booking->customer->username }}</p>
            <p>Time: {{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}
              {{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</p>
          </div>
          <div class="booking-actions d-flex gap-10">
            <form method="POST" action="{{ route('provider.bookings.accept', $booking->id) }}">
              @csrf
              <button type="submit" class="btn btn-primary">Accept</button>
            </form>
            <form method="POST" action="{{ route('provider.bookings.reject', $booking->id) }}">
              @csrf
              <button type="submit" class="btn btn-secondary">Reject</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  @endif
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
          @include('service_provider.services.index')
@include('service_provider.bookings.index')

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
                    src="{{ asset('frontend/public/assest/ahmed.jpeg') }}"
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
                    src="{{ asset('frontend/public/assest/sarah.jpg') }}"
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
@endif
@endsection

@section('js')
@include('admin.partials.sweetalert_actions')
@endsection
