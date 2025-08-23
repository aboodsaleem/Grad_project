<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customer Dashboard - Home Services</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/dashboard.css') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>

<div class="dashboard-container d-flex min-vh-100">
  @include('customer.body.sidebar')

  <main class="main-content flex-grow-1" id="mainContent">
    @include('customer.body.header')

    <div class="tab-content page-content customer" id="pills-tabContent">

      <div class="tab-pane fade show active dashboard-overview" id="dashboard" role="tabpanel">

        <div class="quick-actions">
          <h2 class="fw-semibold mb-20 pb-10">Quick Actions</h2>
          <div class="actions-grid d-grid gap-20">
            <div class="action-card bg-white text-center">
              <div class="action-icon mt-0 mx-auto mb-3 d-flex align-items-center justify-content-center text-white">
                <i class="fas fa-plus"></i>
              </div>
              <h3 class="fw-semibold mb-2">Book New Service</h3>
              <p class="mb-3">Book a home service easily</p>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal">Book Now</button>
            </div>

            <div class="action-card bg-white text-center">
              <div class="action-icon mt-0 mx-auto mb-3 d-flex align-items-center justify-content-center text-white">
                <i class="fas fa-clock"></i>
              </div>
              <h3 class="fw-semibold mb-2">Upcoming Bookings</h3>
              <p class="mb-3">Track your upcoming bookings</p>
              <button class="btn btn-secondary" id="viewBookings">View Bookings</button>
            </div>

            <div class="action-card bg-white text-center">
              <div class="action-icon mt-0 mx-auto mb-3 d-flex align-items-center justify-content-center text-white">
                <i class="fas fa-star"></i>
              </div>
              <h3 class="fw-semibold mb-2">Rate Services</h3>
              <p class="mb-3">Rate completed services</p>
              <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#rateServiceModal">Rate</button>
            </div>

            <div class="action-card bg-white text-center">
              <div class="action-icon mt-0 mx-auto mb-3 d-flex align-items-center justify-content-center text-white">
                <i class="fas fa-headset"></i>
              </div>
              <h3 class="fw-semibold mb-2">Support</h3>
              <p class="mb-3">Contact our support team</p>
              <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#contactModal">Contact</button>
            </div>
          </div>
        </div>

        @php
          $recentBookings = $recentBookings ?? collect();
          $latestServices = $latestServices ?? collect();
        @endphp

        @if($recentBookings->isNotEmpty())
        <div class="recent-bookings mt-5 mb-5">
          <h2 class="fw-semibold mb-20 pb-10">Recent Bookings</h2>
          <div class="bookings-list d-flex flex-column gap-3">
            @foreach($recentBookings as $booking)
              <div class="booking-item p-20 d-flex justify-content-between align-items-center bg-white rounded">
                <div class="d-flex align-items-center gap-3 booking-info">
                  <div class="service-icon d-flex justify-content-center align-items-center text-white">
                    <i class="fas fa-tools"></i>
                  </div>
                  <div class="booking-details">
                    <h4 class="fs-6 fw-semibold">{{ $booking->service->name ?? 'Service Name' }}</h4>
                    <p class="mb-1">Service Provider: {{ $booking->serviceProvider->username ?? 'N/A' }}</p>
                    <p class="mb-1">Date: {{ \Carbon\Carbon::parse($booking->booking_date)->format('F d, Y') }}</p>
                    <p>Time: {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}</p>
                  </div>
                </div>

                <div class="d-flex flex-column align-items-center gap-10 booking-status">
                  <span class="status fw-medium text-center {{ $booking->status }}">
                    {{ ucfirst($booking->status) }}
                  </span>

                  @if($booking->status === 'completed')
                    @if($booking->review)
                      <div class="rating">
                        @php $stars = (int) ($booking->review->rating ?? 0); @endphp
                        @for($i = 1; $i <= 5; $i++)
                          @if($i <= $stars)
                            <i class="fas fa-star text-warning"></i>
                          @else
                            <i class="far fa-star text-warning"></i>
                          @endif
                        @endfor
                      </div>
                    @else
                      <button
                        class="btn btn-secondary btn-sm rate-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#ratingModal"
                        data-booking-id="{{ $booking->id }}"
                        data-provider-id="{{ $booking->service_provider_id }}"
                      >Rate</button>
                    @endif

                  @elseif($booking->status === 'confirmed')
                    <button
                      class="btn btn-secondary btn-sm details-btn"
                      data-bs-toggle="modal"
                      data-bs-target="#detailsModal"
                      data-avatar="{{ $booking->serviceProvider && $booking->serviceProvider->photo ? asset($booking->serviceProvider->photo) : asset('upload/no_image.jpg') }}"
                      data-service="{{ $booking->service->name ?? 'N/A' }}"
                      data-provider="{{ $booking->serviceProvider->username ?? 'N/A' }}"
                      data-date="{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('F j, Y') }}"
                      data-time="{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}"
                      data-price="{{ $booking->price ?? 'N/A' }}"
                      data-status="{{ ucfirst($booking->status) }}"
                    >Details</button>

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
        @endif

        <div class="popular-services bg-white">
          <h2 class="fw-semibold mb-20 pb-10">Popular Services</h2>
          <div class="services-grid d-grid gap-20">
            @forelse($latestServices as $service)
              @php
                $provider = $service->serviceProvider;
                $providerAvg = $provider ? round(($provider->reviewsReceived()->avg('rating') ?? 0), 1) : 0.0;
                $roundedHalf = round($providerAvg * 2) / 2;
              @endphp
              <div class="service-card p-20 bg-white text-center">
                <div class="service-image d-flex align-items-center justify-content-center text-white rounded-circle">
                  <i class="fas fa-tools"></i>
                </div>
                <h3 class="fw-semibold mb-2">{{ $service->serviceType }}</h3>
                <p class="mb-3">{{ $service->description }}</p>

                <div class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3">
                  <div class="rating">
                    @for($i=1;$i<=5;$i++)
                      @if($roundedHalf >= $i)
                        <i class="fas fa-star text-warning"></i>
                      @elseif($roundedHalf == $i - 0.5)
                        <i class="fas fa-star-half-alt text-warning"></i>
                      @else
                        <i class="far fa-star text-warning"></i>
                      @endif
                    @endfor
                  </div>
                  <span>{{ number_format($providerAvg,1) }}</span>
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
                >Book Now</button>
              </div>
            @empty
              <p class="m-0 p-2">No services available at the moment.</p>
            @endforelse
          </div>
        </div>

      </div>

      <div class="tab-pane fade services-page" id="services" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center page-header">
          <h2 class="fw-semibold">My Available Services</h2>
          <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add New Service</button>
        </div>

        <div class="services-grid d-grid gap-20">
          @forelse($services as $service)
            @php
              $provider   = $service->serviceProvider;
              $providerId = $provider->id ?? null;

              $providerAvg = $provider ? round(($provider->reviewsReceived()->avg('rating') ?? 0), 1) : 0.0;
              $roundedHalf = round($providerAvg * 2) / 2;

              $isFav = $providerId && in_array($providerId, $favoriteIds ?? []);
            @endphp
            <div class="service-card p-20 bg-white text-center position-relative" data-category="{{ $service->serviceType }}">
              <button type="button" class="btn p-0 fav-btn fav-toggle" data-provider-id="{{ $providerId ?? '' }}" style="position:absolute;top:10px;right:10px">
                <i class="{{ $isFav ? 'fas' : 'far' }} fa-heart fav-icon"></i>
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
                  @for($i=1;$i<=5;$i++)
                    @if($roundedHalf >= $i)
                      <i class="fas fa-star text-warning"></i>
                    @elseif($roundedHalf == $i - 0.5)
                      <i class="fas fa-star-half-alt text-warning"></i>
                    @else
                      <i class="far fa-star text-warning"></i>
                    @endif
                  @endfor
                </div>
                <span><b>{{ number_format($providerAvg,1) }}</b></span>
              </div>

              <div class="service-price fw-semibold mb-3">From {{ $service->price }} $</div>
              <div class="date mb-2 text-gray"><b>Available time</b>: 08:00am - 08:00pm</div>
              <div class="service-actions d-flex gap-10 justify-content-center">
                <button
                  class="btn btn-primary book-now-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#bookingModal"
                  data-service-id="{{ $service->id }}"
                  data-service-name="{{ $service->name }}"
                  data-provider-id="{{ $providerId ?? '' }}"
                  data-provider-name="{{ $provider->username ?? 'Unknown' }}"
                >Book Now</button>

                <button
                  class="btn btn-secondary view-details-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#serviceModal"
                  data-name="{{ $service->name }}"
                  data-description="{{ $service->description }}"
                  data-price="{{ $service->price }}"
                  data-provider="{{ $provider->username ?? 'Unknown' }}"
                  data-photo="{{ $provider && $provider->photo ? asset($provider->photo) : asset('upload/no_image.jpg') }}"
                  data-category="{{ $service->serviceType }}"
                  data-rating="{{ number_format($providerAvg,1) }}"
                  data-location="{{ $provider->location ?? 'Not specified' }}"
                  data-status="{{ $service->status ?? 'Available' }}"
                >Details</button>
              </div>
            </div>
          @empty
            <p>No services available at the moment.</p>
          @endforelse
        </div>
      </div>

      @include('customer.bookings.index')

      <div class="tab-pane fade favorites-page" id="favorites" role="tabpanel">
        <div class="page-header d-flex align-items-center justify-content-between">
          <h2>Favorite Service Providers</h2>
        </div>
        <div id="favoritesGrid"></div>
      </div>

      <div class="tab-pane fade profile-page" role="tabpanel" id="profile">
        <div class="profile-header bg-white d-flex align-items-center gap-20">
          <img
            src="{{ $userdata->photo ? asset($userdata->photo) : asset('upload/no_image.jpg') }}"
            alt="Profile Image"
            class="object-fit-cover rounded-circle profile-avatar"
            onerror="this.src='{{ asset('upload/no_image.jpg') }}';"
          />
          <div class="profile-info">
            <h2>{{ $userdata->username }}</h2>
            @php $isProvider = auth()->check() && in_array((string)auth()->user()->role, ['service_provider', 'provider']); @endphp
            <p>{{ $isProvider ? 'Home Service Provider' : 'Customer' }}</p>
            <div class="d-flex gap-20 text-gray mt-10 profile-stats">
              @if($isProvider)
                <span>Rating: <b>4.8</b></span>
                <span><b>156</b> Completed Bookings</span>
              @endif
              <span>Member since <b>{{ optional(Auth::user()->created_at)->format('Y') ?? '2025' }}</b></span>
            </div>
          </div>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profileModal">Create/Edit Profile</button>
        </div>

        <div class="profile-sections d-grid gap-20">
          <div class="profile-section bg-white mb-20">
            <h3>Personal Information</h3>
            <div class="info-grid d-grid gap-20 mt-20">
              <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Full Name</label><span>{{ $userdata->username }}</span></div>
              <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Phone Number</label><span>{{ $userdata->phone }}</span></div>
              <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Email</label><span>{{ $userdata->email }}</span></div>
              <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">City</label><span>{{ $userdata->city }}</span></div>
              <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Address</label><span>{{ $userdata->address }}</span></div>
              <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Date of Birth</label><span>{{ $userdata->date_of_birth }}</span></div>
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

      <div class="tab-pane fade notifications-page" id="notifications" role="tabpanel">
        @php
          $user = auth()->user();
          $unreadCount = $user ? $user->unreadNotifications()->count() : 0;
          $notifications = $user ? $user->notifications()->latest()->get() : collect();
        @endphp

        <div class="page-header d-flex align-items-center justify-content-between">
          <h2>Notifications</h2>

          @if($unreadCount > 0)
            <form method="POST" action="{{ route('customer.notifications.readAll') }}">
              @csrf
              <button class="btn btn-secondary">Mark All as Read</button>
            </form>
          @endif
        </div>

        <div class="notifications-list d-flex flex-column gap-3">
          @forelse($notifications as $n)
            @php
              $isUnread = is_null($n->read_at);
              $title = data_get($n->data, 'title') ?? 'Notification';
              $message = data_get($n->data, 'message') ?? '';
              $t = strtolower($title);
              $icon = match(true) {
                str_contains($t, 'confirm')   => 'fa-check-circle',
                str_contains($t, 'rate')      => 'fa-star',
                str_contains($t, 'offer')     => 'fa-gift',
                str_contains($t, 'reminder')  => 'fa-clock',
                default                       => 'fa-bell'
              };
            @endphp

            <div class="notification-item bg-white p-20 d-flex align-items-start {{ $isUnread ? 'unread' : '' }}">
              <div class="notification-icon rounded-circle d-flex justify-content-center align-items-center text-white me-3">
                <i class="fas {{ $icon }}"></i>
              </div>

              <div class="notification-content flex-fill">
                <h4 class="fs-6 fw-semibold d-flex align-items-center gap-2">
                  {{ $title }}
                  @if($isUnread)
                    <span class="d-inline-block rounded-circle" style="width:8px;height:8px;background:#0d6efd"></span>
                  @endif
                </h4>
                @if($message)
                  <p class="mb-1">{{ $message }}</p>
                @endif
                <span class="notification-time text-muted small">{{ $n->created_at->diffForHumans() }}</span>
              </div>

              @if($isUnread)
                <form method="POST" action="{{ route('customer.notifications.read', $n->id) }}" class="ms-3">
                  @csrf
                  <button class="btn btn-sm btn-outline-secondary">Read</button>
                </form>
              @endif
            </div>
          @empty
            <div class="bg-white p-20 rounded text-center text-muted">No notifications yet.</div>
          @endforelse
        </div>
      </div>

      <div class="tab-pane fade support-page" id="support" role="tabpanel">
        <div class="support-header text-center">
          <h2 class="mb-10">Support</h2>
          <p>We are here to help you anytime. Choose your preferred contact method</p>
        </div>

        <div class="support-options d-grid gap-20">
          <div class="support-card bg-white text-center">
            <div class="support-icon rounded-circle d-flex justify-content-center align-items-center text-white mt-0 mx-auto mb-20">
              <i class="fas fa-comments"></i>
            </div>
            <h3>Live Chat</h3>
            <p>Talk to our support team directly</p>
            <button class="btn btn-primary">Start Chat</button>
          </div>

          <div class="support-card bg-white text-center">
            <div class="support-icon rounded-circle d-flex justify-content-center align-items-center text-white mt-0 mx-auto mb-20">
              <i class="fas fa-phone"></i>
            </div>
            <h3>Phone Call</h3>
            <p>Call us at: 920012345</p>
            <button class="btn btn-secondary">Call Now</button>
          </div>

          <div class="support-card bg-white text-center">
            <div class="support-icon rounded-circle d-flex justify-content-center align-items-center text-white mt-0 mx-auto mb-20">
              <i class="fas fa-envelope"></i>
            </div>
            <h3>Email</h3>
            <p>Send us a message at: support@homeservices.com</p>
            <button class="btn btn-secondary">Send Message</button>
          </div>
        </div>

        <div class="faq-section bg-white">
          <h3>Frequently Asked Questions</h3>
          <div class="faq-list accordion d-flex flex-column mt-10" id="faqAccordion">
            <div class="faq-item overflow-hidden">
              <div class="faq-question d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                <h4 class="fs-6 fw-semibold text-dark">How can I book a service?</h4>
                <i class="fas fa-chevron-down"></i>
              </div>
              <div id="faq1" class="collapse faq-answer" data-bs-parent="#faqAccordion">
                <p>You can book a service by browsing available services, choosing the appropriate service, then selecting the service provider and a suitable time for you.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade settings-page" id="settings" role="tabpanel">
        <div class="settings-section bg-white mb-20">
          <h3>Account Settings</h3>
          <div class="setting-item d-flex justify-content-between align-items-center">
            <label>Change Password</label>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changePassModal" id="changePassword">Change</button>
          </div>
          <div class="setting-item d-flex justify-content-between align-items-center">
            <label>Update Email</label>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#updateEmailModal" id="updateEmail">Update</button>
          </div>
          <div class="setting-item d-flex justify-content-between align-items-center border-0">
            <label>Update Phone Number</label>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#updatePhoneModal" id="updatePhoneNumber">Update</button>
          </div>
        </div>

        <div class="settings-section bg-white">
          <h3>Notification Settings</h3>
          <div class="setting-item d-flex justify-content-between align-items-center">
            <label>New Booking Notifications</label>
            <input type="checkbox" checked />
          </div>
          <div class="setting-item d-flex justify-content-between align-items-center">
            <label>Booking Confirmation Notifications</label>
            <input type="checkbox" checked />
          </div>
          <div class="setting-item d-flex justify-content-between align-items-center">
            <label>Review Notifications</label>
            <input type="checkbox" checked />
          </div>
          <div class="setting-item d-flex justify-content-between align-items-center border-0">
            <label>SMS Messages</label>
            <input type="checkbox" />
          </div>
        </div>
      </div>

    </div>
  </main>

  @include('customer.bookings.create')

  <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content p-3 mx-auto">
        <div class="modal-header">
          <h2 class="fs-5 fw-semibold">Service Details</h2>
          <button type="button" class="btn-close position-absolute end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column flex-md-row align-items-center gap-20">
            <div class="modal-image rounded text-center">
              <img src="{{ asset('upload/no_image.jpg') }}" alt="provider-name" class="img-fluid rounded" width="150" onerror="this.src='{{ asset('upload/no_image.jpg') }}';"/>
            </div>
            <div class="modal-info flex-fill">
              <div class="content">
                <p><i class="fa-solid fa-user"></i> <b>Service Provider:</b> <span id="providerNameDetails" class="text-gray"></span></p>
                <p><i class="fas fa-align-left"></i> <strong>Description:</strong> <span id="descriptionDetails" class="text-gray"></span></p>
                <p><i class="fas fa-tags"></i> <strong>Category:</strong> <span id="category" class="text-gray"></span></p>
                <p><i class="fas fa-dollar-sign"></i> <strong>Price of this service:</strong> <span class="text-gray fw-bold" id="price">$</span></p>
                <p><i class="fas fa-star"></i> <strong>Avg Rating on this service:</strong> <span id="rating" class="text-gray"></span></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> <span id="location" class="text-gray"></span></p>
                <p><i class="fas fa-check-circle"></i> <strong>Status:</strong> <span id="status" class="text-gray"></span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @php
    $rateableBookings = \App\Models\Booking::with(['service','serviceProvider','review'])
        ->where('user_id', auth()->id())
        ->where('status','completed')
        ->whereDoesntHave('review')
        ->latest()
        ->limit(10)
        ->get();
  @endphp

  <div class="modal fade" id="rateServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-4">
        <div class="modal-header">
          <h5 class="modal-title">Rate a Completed Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form method="POST" action="{{ route('customer.reviews.store') }}">
          @csrf
          <div class="modal-body">

            <div class="mb-3">
              <label class="form-label fw-semibold">Select Booking</label>
              @if($rateableBookings->isNotEmpty())
                <select name="booking_id" class="form-select" required>
                  @foreach ($rateableBookings as $b)
                    <option value="{{ $b->id }}">
                      #{{ $b->id }} — {{ $b->service->name ?? 'Service' }}
                      ({{ optional($b->booking_date)->format('Y-m-d') }})
                      – Provider: {{ $b->serviceProvider->username ?? '-' }}
                    </option>
                  @endforeach
                </select>
                <div class="form-text">Select the completed booking you want to review.</div>
              @else
                <div class="alert alert-light mb-0">
                  There are no completed bookings awaiting review.
                </div>
              @endif
            </div>

            @if($rateableBookings->isNotEmpty())
            <div class="mb-3">
              <label class="form-label fw-semibold d-block">Your Rating</label>
              <div class="d-flex align-items-center gap-2">
                @for ($i=1; $i<=5; $i++)
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rating" id="rateModal{{ $i }}" value="{{ $i }}" {{ $i===5 ? 'checked' : '' }}>
                    <label class="form-check-label" for="rateModal{{ $i }}">
                      @for($s=1;$s<=5;$s++)
                        <i class="{{ $s <= $i ? 'fas' : 'far' }} fa-star text-warning"></i>
                      @endfor
                    </label>
                  </div>
                @endfor
              </div>
            </div>

            <div class="mb-0">
              <label class="form-label fw-semibold">Comment (optional)</label>
              <textarea name="comment" class="form-control" rows="3" placeholder="اكتب رأيك عن الخدمة..."></textarea>
            </div>
            @endif

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" {{ $rateableBookings->isEmpty() ? 'disabled' : '' }}>
              Submit Rating
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="ratingModal" class="modal fade" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-2">
        <div class="modal-header">
          <h2 class="modal-title fs-5 fw-semibold" id="ratingModalLabel">Rate Service</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="ratingForm" method="POST" action="{{ route('customer.reviews.store') }}">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="booking_id" id="rating_booking_id">
            <input type="hidden" name="service_provider_id" id="rating_provider_id">
            <div class="mb-3">
              <label for="rating_input" class="form-label">Rating (1 to 5)</label>
              <input type="number" min="1" max="5" name="rating" id="rating_input" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="comment_input" class="form-label">Comment</label>
              <textarea name="comment" id="comment_input" class="form-control" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit Rating</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="detailsModal" class="modal fade modal-details-grid" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content mx-auto py-3 px-2">
        <div class="modal-header mb-2">
          <h2 class="modal-title fs-5">Booking Details</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="text-center">
          <div class="modal-image text-center">
            <img src="{{ asset('upload/no_image.jpg') }}" alt="provider-name" class="rounded-circle object-fit-cover provider-image mt-2" id="detailsAvatar" onerror="this.src='{{ asset('upload/no_image.jpg') }}';" />
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Service:</strong> <span id="detailsService"></span></li>
            <li class="list-group-item"><strong>Provider:</strong> <span id="detailsProvider"></span></li>
            <li class="list-group-item"><strong>Date:</strong> <span id="detailsDate"></span></li>
            <li class="list-group-item"><strong>Time:</strong> <span id="detailsTime"></span></li>
            <li class="list-group-item"><strong>Price:</strong> <span id="detailsPrice" class="text-success fw-bold">$</span></li>
            <li class="list-group-item"><strong>Status:</strong> <span id="detailsStatus">Confirmed</span></li>
          </ul>
          <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content mx-auto p-3">
        <div class="modal-header">
          <h2 class="fs-5 fw-semibold mb-0">Edit Profile</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('customer.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3"><label class="form-label">Full Name</label><input name="username" type="text" class="form-control" value="{{ $userdata->username }}"></div>
            <div class="mb-3"><label class="form-label">Phone Number</label><input name="phone" type="text" class="form-control" value="{{ $userdata->phone }}"></div>
            <div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" class="form-control" value="{{ $userdata->email }}"></div>
            <div class="mb-3"><label class="form-label">City</label><input name="city" type="text" class="form-control" value="{{ $userdata->city }}"></div>
            <div class="mb-3"><label class="form-label">Address</label><input name="address" type="text" class="form-control" value="{{ $userdata->address }}"></div>
            <div class="mb-3"><label class="form-label">Date Of BirthDay</label><input name="date_of_birth" type="date" class="form-control" value="{{ $userdata->date_of_birth }}"></div>
            <div class="d-flex align-items-center justify-content-between"><label class="small mb-0" style="width: 150px">Upload Image</label><input name="photo" type="file" class="form-control form-control-sm" accept="image/*" /></div>
            <div class="d-flex justify-content-end mt-4">
              <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="changePassModal" tabindex="-1" aria-labelledby="changePassModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header"><h1 class="modal-title fs-5">Change Password</h1><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
          <form id="modalForm" method="POST" action="{{ route('customer.update.password',$userdata->id) }}">
            @csrf
            <div class="form-group">
              <label for="modalInput">Enter new value:</label>
              <input name="new_password" type="text" id="modalInput" class="form-control" required />
              @error('new_password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4 text-end">
              <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="saveBtn">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="updateEmailModal" tabindex="-1" aria-labelledby="updateEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header"><h1 class="modal-title fs-5">Update Email</h1><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
          <form id="emailUpdateForm" method="POST" action="{{ route('customer.update.email',$userdata->id) }}">
            @csrf
            <div class="form-group">
              <label for="emailInputNew">Enter new value:</label>
              <input name="email" type="text" id="emailInputNew" class="form-control emailInput" required value="{{ $userdata->email }}" />
            </div>
            <div class="mt-4 text-end">
              <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="saveBtn">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="updatePhoneModal" tabindex="-1" aria-labelledby="updatePhoneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header"><h1 class="modal-title fs-5">Update Phone Number</h1><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
          <form id="phoneUpdateForm" method="POST" action="{{ route('customer.update.phone',$userdata->id) }}">
            @csrf
            <div class="form-group">
              <label for="phoneInputNew">Enter new value:</label>
              <input name="phone" type="text" id="phoneInputNew" class="form-control" required value="{{ $userdata->phone }}" />
              @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4 text-end">
              <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="saveBtn">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>const notyf = new Notyf();</script>
<script type="module" src="{{ asset('frontend/js/dashboard.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
@if(Session::has('message'))
  var type = "{{ Session::get('alert-type','info') }}";
  switch(type){
    case 'info': toastr.info(" {{ Session::get('message') }} "); break;
    case 'success': toastr.success(" {{ Session::get('message') }} "); break;
    case 'warning': toastr.warning(" {{ Session::get('message') }} "); break;
    case 'error': toastr.error(" {{ Session::get('message') }} "); break;
  }
@endif
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.details-btn').forEach(button => {
    button.addEventListener('click', function () {
      document.getElementById('detailsAvatar').src   = this.getAttribute('data-avatar');
      document.getElementById('detailsService').textContent = this.getAttribute('data-service');
      document.getElementById('detailsProvider').textContent = this.getAttribute('data-provider');
      document.getElementById('detailsDate').textContent     = this.getAttribute('data-date');
      document.getElementById('detailsTime').textContent     = this.getAttribute('data-time');
      document.getElementById('detailsPrice').textContent    = this.getAttribute('data-price');
      document.getElementById('detailsStatus').textContent   = this.getAttribute('data-status');
    });
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.view-details-btn').forEach(button => {
    button.addEventListener('click', function () {
      document.querySelector('#serviceModal .modal-image img').src = this.dataset.photo;
      document.querySelector('#serviceModal .modal-header h2').textContent = this.dataset.name;
      document.getElementById('providerNameDetails').textContent = this.dataset.provider;
      document.getElementById('descriptionDetails').textContent  = this.dataset.description;
      document.getElementById('price').textContent               = '$' + this.dataset.price;
      document.getElementById('category').textContent            = this.dataset.category;
      document.getElementById('rating').textContent              = this.dataset.rating;
      document.getElementById('location').textContent            = this.dataset.location;
      document.getElementById('status').textContent              = this.dataset.status;
    });
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const serviceIdInput   = document.getElementById('serviceId');
  const providerIdInput  = document.getElementById('providerId');
  const serviceNameInput = document.getElementById('serviceName');
  const providerNameInput= document.getElementById('providerName');

  const fullNameInput    = document.getElementById('fullName');
  const emailInput       = document.getElementById('email');

  document.querySelectorAll('.book-now-btn').forEach(button => {
    button.addEventListener('click', function (event) {
      const now = new Date(), hour = now.getHours();
      if (hour < 8 || hour >= 20) {
        event.preventDefault();
        alert('Sorry, booking is only allowed between 08:00 AM and 08:00 PM.');
        return;
      }
      if(serviceIdInput)   serviceIdInput.value   = this.dataset.serviceId;
      if(serviceNameInput) serviceNameInput.value = this.dataset.serviceName;
      if(providerIdInput)  providerIdInput.value  = this.dataset.providerId;
      if(providerNameInput)providerNameInput.value= this.dataset.providerName;

      if(window.authUser){
        if(fullNameInput) fullNameInput.value = window.authUser.username;
        if(emailInput)    emailInput.value    = window.authUser.email;
      }else{
        if(fullNameInput) fullNameInput.value = '';
        if(emailInput)    emailInput.value    = '';
      }
    });
  });

  const ratingBookingInput = document.getElementById('rating_booking_id');
  const ratingProviderInput= document.getElementById('rating_provider_id');
  document.querySelectorAll('.rate-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      ratingBookingInput.value  = this.dataset.bookingId  || '';
      ratingProviderInput.value = this.dataset.providerId || '';
    });
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const bell = document.getElementById('bellBtn');
  if (bell) {
    bell.addEventListener('click', function (e) {
      e.preventDefault();
      if (location.hash !== '#notifications') {
        history.pushState(null, '', '#notifications');
      }
      const tabTrigger = document.querySelector('#tab-notifications');
      if (tabTrigger && window.bootstrap) {
        try { new bootstrap.Tab(tabTrigger).show(); } catch (e) {}
      }
      const pane = document.getElementById('notifications');
      pane && pane.scrollIntoView({ behavior: 'smooth' });
    });
  }
});
</script>

<script>
  window.authUser = @json(auth()->check() ? [
    'username' => auth()->user()->username,
    'email'    => auth()->user()->email,
  ] : null);
</script>

@include('admin.partials.sweetalert_actions')
@yield('js')

<script>
document.addEventListener('DOMContentLoaded', function () {
  if (window.location.hash) {
    const hash = window.location.hash;
    const trigger = document.querySelector(`[data-bs-target="${hash}"], a[href="${hash}"]`);
    if (trigger && window.bootstrap) {
      try { new bootstrap.Tab(trigger).show(); } catch(e){}
    }
    const pane = document.querySelector(hash);
    if (pane) {
      pane.classList.add('show','active');
      document.querySelectorAll('.tab-pane').forEach(p => {
        if (p !== pane) p.classList.remove('show','active');
      });
    }
  }
});
</script>

<script>
const FAV_TOGGLE_BASE = @json(route('customer.favorites.toggle', 0));

function starsHTML(avg) {
  const rounded = Math.round(Number(avg || 0) * 2) / 2;
  let html = '';
  for (let i=1;i<=5;i++) {
    if (rounded >= i) html += '<i class="fas fa-star text-warning"></i>';
    else if (rounded === i - 0.5) html += '<i class="fas fa-star-half-alt text-warning"></i>';
    else html += '<i class="far fa-star text-warning"></i>';
  }
  return html;
}

function renderFavorites(favs) {
  const wrap = document.getElementById('favoritesGrid');
  if (!wrap) return;
  if (!favs || favs.length === 0) {
    wrap.innerHTML = '<div class="bg-white p-20 rounded text-center text-muted">There are no favorite providers yet.</div>';
    return;
  }

  const items = favs.map(p => {
    const toggleUrl = FAV_TOGGLE_BASE.replace(/\/0$/, `/${p.id}`);
    return `
      <div class="favorite-provider bg-white p-20 d-flex align-items-center gap-20">
        <img src="${p.photo || '{{ asset('upload/no_image.jpg') }}'}" alt="provider-image" class="provider-avatar rounded-circle object-fit-cover" onerror="this.src='{{ asset('upload/no_image.jpg') }}';"/>
        <div class="provider-info flex-fill">
          <h3 class="fs-5 fw-semibold mb-1">${p.name}</h3>
          <div class="provider-stats d-flex align-items-center gap-10 my-10 mx-0">
            <div class="rating d-flex">${starsHTML(p.avg)}</div>
            <span>${Number(p.avg || 0).toFixed(1)}</span>
          </div>
          <div class="provider-details d-flex flex-column">
            <span>${p.city ?? ''}</span>
          </div>
        </div>
        <div class="provider-actions d-flex flex-column gap-10">
          <button class="btn btn-sm btn-secondary fav-toggle"
                  data-provider-id="${p.id}"
                  data-url="${toggleUrl}">
            Remove from Favorites
          </button>
        </div>
      </div>
    `;
  }).join('');

  wrap.innerHTML = `<div class="favorites-grid d-grid gap-20">${items}</div>`;
  bindFavToggle();
}

function bindFavToggle() {
  document.querySelectorAll('.fav-toggle').forEach(btn => {
    btn.onclick = async (e)=>{
      e.preventDefault();
      const pid = btn.dataset.providerId;
      const url = btn.dataset.url || FAV_TOGGLE_BASE.replace(/\/0$/, `/${pid}`);
      if (!pid || !url) return;

      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With':'XMLHttpRequest',
            'Accept':'application/json'
          }
        });
        if (!res.ok) throw new Error('Network');
        const data = await res.json();

        const icon = btn.querySelector('i');
        if (icon) {
          if (data.favorited) { icon.classList.remove('far'); icon.classList.add('fas'); }
          else { icon.classList.remove('fas'); icon.classList.add('far'); }
        }

        const activePane = document.querySelector('.tab-pane.show.active');
        if (activePane && activePane.id === 'favorites') loadFavorites();

        if (window.toastr) {
          data.favorited ? toastr.success('Added to Favorites') : toastr.info('Removed from Favorites');
        }
      } catch(_) {
        alert('Network error');
      }
    };
  });
}

async function loadFavorites() {
  try {
    const res = await fetch("{{ route('customer.favorites.list') }}", {
      headers: { 'Accept':'application/json' }
    });
    const data = await res.json();
    renderFavorites(data.favorites || []);
  } catch(e){ console.error(e); }
}

document.addEventListener('DOMContentLoaded', function () {
  bindFavToggle();
  const favTabTrigger = document.querySelector('[data-bs-target="#favorites"], a[href="#favorites"]');
  if (favTabTrigger) {
    favTabTrigger.addEventListener('shown.bs.tab', loadFavorites);
  }
});
</script>

</body>
</html>
