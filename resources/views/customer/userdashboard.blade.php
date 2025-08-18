<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"  />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
        @foreach($recentBookings as $booking)
            <div class="booking-item p-20 d-flex justify-content-between align-items-center bg-white rounded">
                <div class="d-flex align-items-center gap-3 booking-info">
                    <div class="service-icon d-flex justify-content-center align-items-center text-white">
                        <i class="fas fa-tools"></i> {{-- يمكنك تغيير الأيقونة حسب نوع الخدمة --}}
                    </div>
                    <div class="booking-details">
                        <h4 class="fs-6 fw-semibold">{{ $booking->service->name ?? 'Service Name' }}</h4>
                        <p class="mb-1">Service Provider: {{ $booking->serviceProvider->username ?? 'N/A' }}</p>
                        <p class="mb-1">Date: {{ \Carbon\Carbon::parse($booking->date)->format('F d, Y') }}</p>
                        <p>Time: {{ \Carbon\Carbon::parse($booking->time)->format('g:i A') }}</p>
                    </div>
                </div>

                <div class="d-flex flex-column align-items-center gap-10 booking-status">
                    <span class="status fw-medium text-center {{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </span>

                    @if($booking->status === 'completed')
                        <div class="rating">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                        </div>
                    @elseif($booking->status === 'confirmed')
                        <button class="btn btn-secondary btn-sm details-btn"
        data-bs-toggle="modal"
        data-bs-target="#detailsModal"
        data-avatar="{{ asset($booking->serviceProvider->photo ?? 'default.jpg') }}"
        data-service="{{ $booking->service->name ?? 'N/A' }}"
        data-provider="{{ $booking->serviceProvider->username ?? 'N/A' }}"
        data-date="{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('F j, Y') }}"
        data-time="{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}"
        data-price="{{ $booking->price ?? 'N/A' }}"
        data-status="{{ ucfirst($booking->status) }}">
    Details
</button>
                    @elseif($booking->status === 'pending')
                        <form method="POST" action="{{ route('customer.bookings.destroy', $booking->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-secondary">Cancel</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>


            <!-- Popular Services -->
<div class="popular-services bg-white">
  <h2 class="fw-semibold mb-20 pb-10">Popular Services</h2>
  <div class="services-grid d-grid gap-20">
    @foreach($latestServices as $service)
    <div class="service-card p-20 bg-white text-center">
      <div
        class="service-image d-flex align-items-center justify-content-center text-white rounded-circle"
      >
        <i class="fas fa-tools"></i> <!-- يمكنك تخصيص الأيقونة حسب نوع الخدمة -->
      </div>
      <h3 class="fw-semibold mb-2">{{ $service->serviceType }}</h3>
      <p class="mb-3">{{ $service->description }}</p>

      {{-- تقييم افتراضي لأن التقييم غير موجود --}}
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
        <span>4.7 (50 reviews)</span>
      </div>

      <div class="service-price fw-semibold mb-3">From {{ $service->price }} $</div>

      <button
                    class="btn btn-primary book-now-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#bookingModal"
                    data-service-id="{{ $service->id }}"
                    data-service-name="{{ $service->name }}"
                    data-provider-id="{{ $service->serviceProvider->id ?? '' }}"
                    data-provider-name="{{ $service->serviceProvider->username ?? 'Unknown' }}"
                >
                    Book Now
                </button>
    </div>
    @endforeach
  </div>
</div>
</div>

<!-- Main Services Content -->
<div class="tab-pane fade services-page" id="services" role="tabpanel">
    <div class="d-flex justify-content-between align-items-center page-header">
        <h2 class="fw-semibold"> Available Services</h2>
    </div>

    <div class="services-grid d-grid gap-20">
    @forelse($services as $service)
        <div class="service-card p-20 bg-white text-center position-relative" data-category="{{ $service->serviceType }}">
            <button class="btn p-0 fav-btn">
            <a aria-label="Add To favorite" class="action-btn" id="{{ $service->id }}" onclick="addTofavorite(this.id)"  ><i class="far fa-heart fav-icon"></i></a>

            </button>

            <div class="service-image d-flex align-items-center justify-content-center text-white rounded-circle">
                @switch($service->serviceType)
                    @case('Electrical') <i class="fas fa-bolt"></i> @break
                    @case('Maintenance') <i class="fas fa-tools"></i> @break
                    @case('Repairing') <i class="fas fa-wrench"></i> @break
                    @case('Cleaning') <i class="fas fa-broom"></i> @break
                    @case('Washing') <i class="fas fa-tint"></i> @break
                    @default <i class="fas fa-cog"></i>
                @endswitch
            </div>

            <h3 class="fw-semibold mb-2 title">{{ $service->name }}</h3>
            <p class="mb-3 description">{{ $service->description }}</p>

            <div class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3">
                <div class="rating">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <span><b>4.5</b></span>
            </div>

            <div class="service-price fw-semibold mb-3">From {{ $service->price }} $</div>
            <div class="date mb-2 text-gray">
                  <b>Available time</b>: 08:00am - 08:00pm
                </div>


            <div class="service-actions d-flex gap-10 justify-content-center">
                <button
                    class="btn btn-primary book-now-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#bookingModal"
                    data-service-id="{{ $service->id }}"
                    data-service-name="{{ $service->name }}"
                    data-provider-id="{{ $service->serviceProvider->id ?? '' }}"
                    data-provider-name="{{ $service->serviceProvider->username ?? 'Unknown' }}"
                >
                    Book Now
                </button>

                <button
    class="btn btn-secondary view-details-btn"
    data-bs-toggle="modal"
    data-bs-target="#serviceModal"
    data-name="{{ $service->name }}"
    data-description="{{ $service->description }}"
    data-price="{{ $service->price }}"
    data-provider="{{ $service->serviceProvider->username ?? 'Unknown' }}"
    data-photo="{{ asset($service->serviceProvider->photo ?? 'upload/no_img.jpg') }}"
    data-category="{{ $service->serviceType }}"
    data-rating="4.5"
    data-location="{{ $service->serviceProvider->location ?? 'Not specified' }}"
    data-status="{{ $service->status ?? 'Available' }}"
>
    Details
</button>
            </div>
        </div>
    @empty
        <p>No services available at the moment.</p>
    @endforelse
    </div>
</div>



@include('customer.bookings.index')

          <!-- Main Favorites Content -->
@include('customer.favorite.favorite')


          <!-- Main Profile Content -->
          <div class="tab-pane fade profile-page" role="tabpanel" id="profile">
            <div
              class="profile-header bg-white d-flex align-items-center gap-20"
            >
              <img
                src="{{ asset($userdata->photo ?? 'upload/no_image.jpg') }}"
                alt="Profile Image"
                class="object-fit-cover rounded-circle profile-avatar"
              />
              <div class="profile-info">
                <h2>{{ $userdata->username }}</h2>
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
                    <span>{{ $userdata->username }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Phone Number</label>
                    <span>{{ $userdata->phone }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Email</label>
                    <span>{{ $userdata->email }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">City</label>
                    <span>{{ $userdata->city }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Address</label>
                    <span>{{ $userdata->address }}</span>
                  </div>
                  <div class="info-item d-flex flex-column">
                    <label class="text-gray fw-semibold">Date of Birth</label>
                    <span>{{ $userdata->date_of_birth }}</span>
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

@include('customer.bookings.create')

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
  src=""
  alt="provider-name"
  class="img-fluid rounded-circle"
  width="200"
  height="200"
/>
                </div>

                <div class="modal-info flex-fill">
                  <div class="content">
                    <p>
                      <i class="fa-solid fa-user"></i>
                      <b>Service Provider:</b>
                      <span id="providerNameDetails" class="text-gray"></span>
                    </p>
                    <p>
                      <i class="fas fa-align-left"></i>
                      <strong>Description:</strong>
                      <span id="descriptionDetails" class="text-gray"
                        ></span
                      >
                    </p>
                    <p>
                      <i class="fas fa-tags"></i>
                      <strong>Category:</strong>
                      <span id="category" class="text-gray"></span>
                    </p>
                    <p>
                      <i class="fas fa-dollar-sign"></i>
                      <strong>Price of this service:</strong>
                      <span class="text-gray fw-bold" id="price">$</span>
                    </p>
                    <p>
                      <i class="fas fa-star"></i>
                      <strong>Avg Rating on this service:</strong>
                      <span id="rating" class="text-gray"></span>
                    </p>
                    <p>
                      <i class="fas fa-map-marker-alt"></i>
                      <strong>Location:</strong>
                      <span id="location" class="text-gray"></span>
                    </p>
                    <p>
                      <i class="fas fa-check-circle"></i>
                      <strong>Status:</strong>
                      <span id="status" class="text-gray"></span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- <!-- Service Details Modal -->
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
                <!-- Provider Image & Name -->
          <div class="text-center">
  <div class="modal-image rounded overflow-hidden mb-2">
    <img
      src=""
      alt="provider-photo"
      class="img-fluid rounded-circle border"
      width="150"
      height="150"
    />
  </div>
  <h5 class="fw-bold text-primary mb-0">

  </h5>
</div>

                <div class="modal-info flex-fill">
                  <div class="content">
                    <h2 class="fw-bold"></h2>

                    <p>
                      <i class="fas fa-align-left"></i>
                      <strong>Description:</strong>
                      <span id="description"></span>
                    </p>

                    <p>
                      <i class="fas fa-dollar-sign"></i>
                      <strong>Price:</strong>
                      <span class="text-success fw-bold" id="price">$</span>
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
      </div> --}}

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
                  <span id="detailsService"></span>
                </li>
                <li class="list-group-item">
                  <strong>Provider:</strong>
                  <span id="detailsProvider"></span>
                </li>
                <li class="list-group-item">
                  <strong>Date:</strong>
                  <span id="detailsDate"></span>
                </li>
                <li class="list-group-item">
                  <strong>Time:</strong> <span id="detailsTime"></span>
                </li>
                <li class="list-group-item">
                  <strong>Price:</strong>
                  <span id="detailsPrice" class="text-success fw-bold"
                    >$</span
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

       <!-- Edit Profile Modal -->
      <div
        class="modal fade"
        id="profileModal"
        tabindex="-1"
        aria-labelledby="profileModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content mx-auto p-3">
            <div class="modal-header">
              <h2 class="fs-5 fw-semibold mb-0">Edit Profile</h2>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>

            <div class="modal-body">
              <form action="{{ route('customer.update',$userdata->id) }}" method="POST" enctype="multipart/form-data">

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
                    value="{{ $userdata->username }}"
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
                    value="{{ $userdata->phone }}"

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
                    value="{{ $userdata->email }}"
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
                    value="{{ $userdata->city }}"

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
                    value="{{ $userdata->address }}"

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
                    value="{{ $userdata->date_of_birth }}"

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
              <form id="modalForm" method="POST" action="{{ route('customer.update.password',$userdata->id) }}">
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
        <form id="emailUpdateForm" method="POST" action="{{ route('customer.update.email',$userdata->id) }}">
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
                    value="{{ $userdata->email}}"
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
            <form id="phoneUpdateForm" method="POST" action="{{ route('customer.update.phone',$userdata->id) }}">
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
                    value="{{ $userdata->phone}}"
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailsButtons = document.querySelectorAll('.details-btn');

        detailsButtons.forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('detailsAvatar').src = this.getAttribute('data-avatar');
                document.getElementById('detailsService').textContent = this.getAttribute('data-service');
                document.getElementById('detailsProvider').textContent = this.getAttribute('data-provider');
                document.getElementById('detailsDate').textContent = this.getAttribute('data-date');
                document.getElementById('detailsTime').textContent = this.getAttribute('data-time');
                document.getElementById('detailsPrice').textContent = this.getAttribute('data-price');
                document.getElementById('detailsStatus').textContent = this.getAttribute('data-status');
            });
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailButtons = document.querySelectorAll('.view-details-btn');

    detailButtons.forEach(button => {
        button.addEventListener('click', function () {
            const name = this.getAttribute('data-name');
            const description = this.getAttribute('data-description');
            const price = this.getAttribute('data-price');
            const provider = this.getAttribute('data-provider');
            const photo = this.getAttribute('data-photo');
            const category = this.getAttribute('data-category');
            const rating = this.getAttribute('data-rating');
            const location = this.getAttribute('data-location');
            const status = this.getAttribute('data-status');

            // تعبئة بيانات المودال
            document.querySelector('.modal-image img').src = photo;
            document.querySelector('#serviceModal .modal-header h2').textContent = name;
            document.getElementById('providerNameDetails').textContent = provider;
            document.getElementById('descriptionDetails').textContent = description;
            document.getElementById('price').textContent = `$${price}`;
            document.getElementById('category').textContent = category;
            document.getElementById('rating').textContent = rating;
            document.getElementById('location').textContent = location;
            document.getElementById('status').textContent = status;
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const bookButtons = document.querySelectorAll('.book-now-btn');

    const serviceIdInput = document.getElementById('serviceId');
    const providerIdInput = document.getElementById('providerId');
    const serviceNameInput = document.getElementById('serviceName');
    const providerNameInput = document.getElementById('providerName');
    const fullNameInput = document.getElementById('fullName');
    const emailInput = document.getElementById('email');

    bookButtons.forEach(button => {
        button.addEventListener('click', function () {
            const now = new Date();
            const hour = now.getHours();

            if (hour < 8 || hour >= 20) {
                event.preventDefault(); // يمنع فتح المودال
                alert('Sorry, booking is only allowed between 08:00 AM and 08:00 PM.');
                return; // يوقف باقي تنفيذ الحدث
            }
            const serviceId = this.getAttribute('data-service-id');
            const serviceName = this.getAttribute('data-service-name');
            const providerId = this.getAttribute('data-provider-id');
            const providerName = this.getAttribute('data-provider-name');

            serviceIdInput.value = serviceId;
            serviceNameInput.value = serviceName;
            providerIdInput.value = providerId;
            providerNameInput.value = providerName;

            if(window.authUser){
                fullNameInput.value = window.authUser.username;
                emailInput.value = window.authUser.email;
            } else {
                fullNameInput.value = "";
                emailInput.value = "";
            }
        });
    });
});

</script>

<script>
    window.authUser = @json(auth()->check() ? [
        'username' => auth()->user()->username,
        'email' => auth()->user()->email,
    ] : null);
</script>

 <script type="text/javascript">

        function addTofavorite(service_id){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: 'json',
                url: "/customer/add-to-favorite/"+service_id,

                success:function(data){

                     // Start Message

            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',

                  showConfirmButton: false,
                  timer: 3000
            })
            if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                    type: 'success',
                    icon: 'success',
                    title: data.success,
                    })

            }else{

           Toast.fire({
                    type: 'error',
                    icon: 'error',
                    title: data.error,
                    })
                }

              // End Message


                }
            })
        }


    </script>

    <script>
$(document).ready(function(){
    $('.remove-favorite-btn').click(function(e){
        e.preventDefault();

        let serviceId = $(this).data('service-id');
        let button = $(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/customer/remove-from-favorite/' + serviceId,
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.success) {
                    // رسالة نجاح
                    toastr.success(data.success);

                    // إزالة بطاقة الخدمة من الصفحة (اختياري)
                    button.closest('.service-card').remove();

                } else if(data.error) {
                    toastr.error(data.error);
                }
            },
            error: function(xhr, status, error){
                toastr.error('Something went wrong. Please try again.');
            }
        });
    });
});
</script>




@include('admin.partials.sweetalert_actions')
@yield('js')

  </body>
</html>
