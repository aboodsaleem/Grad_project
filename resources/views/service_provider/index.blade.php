
@extends('service_provider.serviceprovider_Dashboard')

@section('main')
@php
  // تأمين القيم الافتراضية حتى لو الكنترولر ما مرّرها
  $service_provider     = $service_provider     ?? Auth::user();
  $avgRating            = $avgRating            ?? 0;
  $completedCount       = $completedCount       ?? 0;
  $memberSinceYear      = $memberSinceYear      ?? (optional(Auth::user()->created_at)->format('Y') ?? '');
  $pendingBooking       = $pendingBooking       ?? collect();
  $recentReviews        = $recentReviews        ?? collect();
  $services             = $services             ?? collect();   // لتضمين services.index بأمان
  $bookings             = $bookings             ?? collect();   // لتضمين bookings.index بأمان

  // 🟢 المتغيرات الجديدة للكروت الديناميكية
  $todayBookings        = $todayBookings        ?? 0;
  $todayBookingsChange  = $todayBookingsChange  ?? 0;   // نسبة مئوية (موجب/سالب)
  $ratingDelta          = $ratingDelta          ?? 0;   // فرق التقييم (مثلاً +0.2)
  $newCustomers         = $newCustomers         ?? 0;
  $newCustomersChange   = $newCustomersChange   ?? 0;   // نسبة مئوية (موجب/سالب)

  // تنسيقات بسيطة للون وعلامة الموجب/السالب
  $todayChangeClass     = $todayBookingsChange >= 0 ? 'positive' : 'negative';
  $todayChangeSign      = $todayBookingsChange >= 0 ? '+' : '';

  $ratingDeltaClass     = $ratingDelta >= 0 ? 'positive' : 'negative';
  $ratingDeltaSign      = $ratingDelta >= 0 ? '+' : '';

  $newCustChangeClass   = $newCustomersChange >= 0 ? 'positive' : 'negative';
  $newCustChangeSign    = $newCustomersChange >= 0 ? '+' : '';
@endphp

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
    <div class="profile-header bg-white d-flex align-items-center gap-20">
      <img src="{{ asset($service_provider->photo ?? 'upload/no_image.jpg') }}" alt="Profile Image" class="object-fit-cover rounded-circle profile-avatar" />
      <div class="profile-info">
        <h2>{{ $service_provider->username }}</h2>
        <p>Home Service Provider</p>
        <div class="d-flex gap-20 text-gray mt-10 profile-stats">
          <span>Rating: <b>{{ number_format($avgRating, 1) }}</b></span>
          <span><b>{{ $completedCount }}</b> Completed Bookings</span>
          <span>Member since <b>{{ $memberSinceYear }}</b></span>
        </div>
      </div>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profileModal">Create/Edit Profile</button>
    </div>

    <div class="profile-sections d-grid gap-20">
      <div class="profile-section bg-white mb-20">
        <h3>Personal Information</h3>
        <div class="info-grid d-grid gap-20 mt-20">
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Full Name</label><span>{{ $service_provider->username }}</span></div>
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Phone Number</label><span>{{ $service_provider->phone }}</span></div>
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Email</label><span>{{ $service_provider->email }}</span></div>
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">City</label><span>{{ $service_provider->city }}</span></div>
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Address</label><span>{{ $service_provider->address }}</span></div>
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Date of Birth</label><span>{{ $service_provider->date_of_birth }}</span></div>
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
  <div class="tab-pane fade show active dashboard-overview" id="dashboard" role="tabpanel">
    <div class="stats-grid d-grid gap-20">

      {{-- ✅ Today’s Bookings (ديناميكي) --}}
      <div class="stat-card bg-white d-flex align-items-center gap-20">
        <div class="stat-icon d-flex align-items-center justify-content-center text-white">
          <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-info">
          <h3>Today's Bookings</h3>
          <p class="stat-number fw-bold">{{ $todayBookings }}</p>
          <span class="stat-change {{ $todayChangeClass }} fw-medium">
            {{ $todayChangeSign }}{{ $todayBookingsChange }}%
          </span>
        </div>
      </div>


      {{-- ✅ Overall Rating (ديناميكي) --}}
      <div class="stat-card bg-white d-flex align-items-center gap-20">
        <div class="stat-icon d-flex align-items-center justify-content-center text-white">
          <i class="fas fa-star"></i>
        </div>
        <div class="stat-info">
          <h3>Overall Rating</h3>
          <p class="stat-number fw-bold">{{ number_format($avgRating, 1) }}</p>
          <span class="stat-change {{ $ratingDeltaClass }} fw-medium">
            {{ $ratingDeltaSign }}{{ number_format($ratingDelta,1) }}
          </span>
        </div>
      </div>

      {{-- ✅ New Customers (ديناميكي) --}}
      <div class="stat-card bg-white d-flex align-items-center gap-20">
        <div class="stat-icon d-flex align-items-center justify-content-center text-white">
          <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
          <h3>New Customers</h3>
          <p class="stat-number fw-bold">{{ $newCustomers }}</p>
          <span class="stat-change {{ $newCustChangeClass }} fw-medium">
            {{ $newCustChangeSign }}{{ $newCustomersChange }}%
          </span>
        </div>
      </div>

    </div>

    <!-- Upcoming Bookings -->
    <div class="upcoming-bookings bg-white mb-3">
      <h2 class="fs-3 fw-semibold pb-2 mb-3">Upcoming Bookings</h2>

      @php $pending = ($pendingBooking ?? collect()); @endphp

      @if($pending->isEmpty())
        <p class="text-muted">No upcoming bookings.</p>
      @else
        <div class="bookings-list d-flex flex-column gap-3">
          @foreach($pending as $booking)
            <div class="booking-item p-20 d-flex justify-content-between align-items-center">
              <div class="booking-info">
                <h4 class="fs-6 fw-semibold mb-1">{{ $booking->service->name ?? 'N/A' }}</h4>
                <p>Customer: {{ $booking->customer->username ?? 'N/A' }}</p>
                <p>
                  Time:
                  {{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}
                  {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}
                  -
                  {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                </p>
              </div>
              <div class="booking-actions d-flex gap-10">
                <form method="POST" action="{{ route('provider.bookings.accept', $booking->id) }}">@csrf<button type="submit" class="btn btn-primary">Accept</button></form>
                <form method="POST" action="{{ route('provider.bookings.reject', $booking->id) }}">@csrf<button type="submit" class="btn btn-secondary">Reject</button></form>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>

    <!-- Recent Reviews -->
    <div class="recent-reviews bg-white">
      <h2 class="fs-3 fw-semibold pb-2 mb-3">Recent Reviews</h2>

      @php $list = $recentReviews; @endphp

      @if($list->isEmpty())
        <p class="text-muted m-0">No reviews yet.</p>
      @else
        <div class="reviews-list d-flex flex-column gap-3">
          @foreach($list as $review)
            <div class="review-item">
              <div class="review-header d-flex justify-content-between align-items-center mb-10 gap-3">
                <div class="d-flex align-items-center gap-3">
                  <img
                    src="{{ asset($review->user->photo ?? 'frontend/public/assest/default-customer-image.png') }}"
                    alt="Client"
                    class="reviewer-avatar rounded-circle object-fit-cover"
                    width="44" height="44"
                    onerror="this.src='{{ asset('frontend/public/assest/default-customer-image.png') }}';"
                  >
                  <div>
                    <div class="fw-semibold">{{ $review->user->username ?? 'Customer' }}</div>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                  </div>
                </div>

                <div class="rating d-flex align-items-center">
                  @for($i=1; $i<=5; $i++)
                    <i class="{{ $i <= (int)$review->rating ? 'fas' : 'far' }} fa-star text-warning"></i>
                  @endfor
                  <span class="ms-2 text-muted fw-semibold">{{ number_format($review->rating,1) }}</span>
                </div>
              </div>

              @if($review->comment)
                <p class="review-text mb-0">{{ $review->comment }}</p>
              @endif
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>

  <!-- Main Services Content -->
  @include('service_provider.services.index', ['services' => $services])

  <!-- Main Bookings Content -->
  @include('service_provider.bookings.index', ['bookings' => $bookings])

  <!-- Main Profile Content -->
  <div class="tab-pane fade profile-page" role="tabpanel" id="profile">
    <div class="profile-header bg-white d-flex align-items-center gap-20">
      <img src="{{ asset($service_provider->photo ?? 'upload/no_image.jpg') }}" alt="Profile Image" class="object-fit-cover rounded-circle profile-avatar" />
      <div class="profile-info">
        <h2>{{ $service_provider->username }}</h2>
        <p>Home Service Provider</p>
        <div class="d-flex gap-20 text-gray mt-10 profile-stats">
          <span>Average Rating: <b>{{ number_format($avgRating, 1) }}</b></span>
          <span><b>{{ $completedCount }}</b> Completed Bookings</span>
          <span>Member since <b>{{ $memberSinceYear }}</b></span>
        </div>
      </div>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profileModal">Create/Edit Profile</button>
    </div>

    <div class="profile-sections d-grid gap-20">
      <div class="profile-section bg-white mb-20">
        <h3>Personal Information</h3>
        <div class="info-grid d-grid gap-20 mt-20">
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Full Name</label><span>{{ $service_provider->username }}</span></div>
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Phone Number</label><span>{{ $service_provider->phone }}</span></div>
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Email</label><span>{{ $service_provider->email }}</span></div>
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">City</label><span>{{ $service_provider->city }}</span></div>
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Address</label><span>{{ $service_provider->address }}</span></div>
          <div class="info-item d-flex flex-column"><label class="text-gray fw-semibold">Date of Birth</label><span>{{ $service_provider->date_of_birth }}</span></div>
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
  <div class="tab-pane fade earnings-page" role="tabpanel" id="earnings">
    <div class="earnings-summary d-grid gap-20">
      <div class="earning-card bg-white text-center"><h3 class="m-0 fs-6 fw-bolder">Today's Earnings</h3><p class="earning-amount fw-bold mt-10 mb-0">$450</p></div>
      <div class="earning-card bg-white text-center"><h3 class="m-0 fs-6 fw-bolder">This Week's Earnings</h3><p class="earning-amount fw-bold mt-10 mb-0">$2,100</p></div>
      <div class="earning-card bg-white text-center"><h3 class="m-0 fs-6 fw-bolder">This Month's Earnings</h3><p class="earning-amount fw-bold mt-10 mb-0">$8,750</p></div>
      <div class="earning-card bg-white text-center"><h3 class="m-0 fs-6 fw-bolder">Total Earnings</h3><p class="earning-amount fw-bold mt-10 mb-0">$45,200</p></div>
    </div>

    <div class="earnings-history bg-white">
      <h3 class="fs-6 fw-bolder mb-3">Earnings History</h3>
      <div class="earnings-table bg-white overflow-hidden">
        <div class="earning-row header d-grid align-items fw-semibold"><div>Date</div><div>Service</div><div>Client</div><div>Amount</div></div>
        <div class="earning-row d-grid align-items-center"><div>2024-01-15</div><div>AC Maintenance</div><div>Sara Ahmed</div><div class="text-success fw-bold">$150</div></div>
        <div class="earning-row d-grid align-items-center"><div>2024-01-14</div><div>Home Cleaning</div><div>Mohamed Ali</div><div class="text-success fw-bold">$200</div></div>
        <div class="earning-row d-grid align-items-center"><div>2024-01-13</div><div>Plumbing Repair</div><div>Fatima Khalid</div><div class="text-success fw-bold">$120</div></div>
      </div>
    </div>
  </div>

  <!-- Main Reviews Content -->
<div class="tab-pane fade reviews-page" role="tabpanel" id="reviews">

  @php
    // تأمين المتغيّرات لو ما وصلت من الكنترولر
    $avg   = isset($avgRating) ? (float)$avgRating : 0;
    $count = $reviewsCount ?? 0;

    // لو عندك قائمة كاملة للريفيوز استخدمها، وإلا جرّب الـ recentReviews، وإلا خليها فاضية
    $list  = ($allReviews ?? null) ?: ($recentReviews ?? collect());
  @endphp

  <div class="reviews-summary bg-white">
    <div class="rating-overview text-center">
      <div class="overall-rating d-inline-block">
        <h3 class="fw-bold text-dark">Average Of Rating:</h3>
        <span class="rating-number d-block fw-bold">{{ number_format($avg, 1) }}</span>
        <div class="rating-stars my-10">
          @for($i=1;$i<=5;$i++)
            <i class="{{ $i <= round($avg) ? 'fas' : 'far' }} fa-star"></i>
          @endfor
        </div>
        <p class="fs-6 mt-2">
          <span class="text-gray me-1"><b>Total Reviews:</b></span>{{ $count }}
        </p>
      </div>
    </div>
  </div>

  {{-- قائمة التقييمات --}}
  @if($list instanceof \Illuminate\Support\Collection && $list->isNotEmpty())
    <div class="reviews-list flex-column d-flex">
      @foreach($list as $review)
        <div class="review-item">
          <div class="review-header d-flex justify-content-between align-items-center mb-10 gap-3">
            <img
              src="{{ asset(data_get($review,'user.photo','frontend/public/assest/default-customer-image.png')) }}"
              alt="Client Image"
              class="reviewer-avatar rounded-circle object-fit-cover"
              width="50" height="50"
              onerror="this.src='{{ asset('frontend/public/assest/default-customer-image.png') }}';"
            />
            <div class="reviewer-info flex-grow-1">
              <h4>{{ data_get($review,'user.username','Customer') }}</h4>
              <div class="d-flex align-items-center gap-2">
                <div class="rating d-flex">
                  @for($i=1;$i<=5;$i++)
                    <i class="{{ $i <= (int)($review->rating ?? 0) ? 'fas' : 'far' }} fa-star"></i>
                  @endfor
                </div>
                <span class="fw-semibold text-muted">{{ number_format((float)($review->rating ?? 0),1) }}</span>
              </div>
              <span class="review-date text-gray">
                {{ optional($review->created_at)->diffForHumans() }}
              </span>
            </div>
          </div>

          @if(!empty($review->comment))
            <p class="review-text">{{ $review->comment }}</p>
          @endif
        </div>
      @endforeach
    </div>
  @else
    {{-- أمثلة ثابتة (تظهر فقط إذا ما في بيانات) --}}
    <div class="reviews-list flex-column d-flex">
      <div class="review-item">
        <div class="review-header d-flex justify-content-between align-items-center mb-10 gap-3">
          <img src="{{ asset('frontend/public/assest/ahmed.jpeg') }}" alt="Client Image" class="reviewer-avatar rounded-circle object-fit-cover" width="50" height="50" />
          <div class="reviewer-info flex-grow-1">
            <h4>Ahmed Mahmoud</h4>
            <div class="d-flex align-items-center gap-2">
              <div class="rating d-flex">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
              </div>
              <span class="fw-semibold text-muted">4.6</span>
            </div>
            <span class="review-date text-gray">2 days ago</span>
          </div>
        </div>
        <p class="review-text">Excellent and fast service, highly recommended! Arrived on time and completed the work perfectly.</p>
      </div>

      <div class="review-item">
        <div class="review-header d-flex justify-content-between align-items-center mb-10 gap-3">
          <img src="{{ asset('frontend/public/assest/sarah.jpg') }}" alt="Client Image" class="reviewer-avatar rounded-circle object-fit-cover" width="50" height="50" />
          <div class="reviewer-info flex-grow-1">
            <h4>Noura Salem</h4>
            <div class="d-flex align-items-center gap-2">
              <div class="rating d-flex">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
              </div>
              <span class="fw-semibold text-muted">3.5</span>
            </div>
            <span class="review-date text-gray">1 week ago</span>
          </div>
        </div>
        <p class="review-text">Good work but arrived a bit late. Overall satisfied with the service.</p>
      </div>
    </div>
  @endif

</div>


  <!-- Main Settings Content -->
  <div class="tab-pane fade settings-page" role="tabpanel" id="settings">
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
      <div class="setting-item d-flex justify-content-between align-items-center border-bottom-0">
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
        <label>Review Notifications</label>
        <input type="checkbox" checked />
      </div>
      <div class="setting-item d-flex justify-content-between align-items-center border-bottom-0">
        <label>Message Notifications</label>
        <input type="checkbox" />
      </div>
    </div>
  </div>
</div>
@endif

{{-- =======================  MODALS  ======================= --}}

{{-- Profile Create/Edit --}}
<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Create / Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('provider.update', Auth::id()) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" name="username" class="form-control" value="{{ old('username',$service_provider->username ?? '') }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email',$service_provider->email ?? '') }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone',$service_provider->phone ?? '') }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">City</label>
            <input type="text" name="city" class="form-control" value="{{ old('city',$service_provider->city ?? '') }}">
          </div>
          <div class="col-md-12">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address',$service_provider->address ?? '') }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth',$service_provider->date_of_birth ?? '') }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Change Password --}}
<div class="modal fade" id="changePassModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('provider.update.password', Auth::id()) }}">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" required minlength="8">
          </div>
          <div class="mb-0">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" class="form-control" required minlength="8">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Password</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Update Email --}}
<div class="modal fade" id="updateEmailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Update Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('provider.update.email', Auth::id()) }}">
        @csrf
        <div class="modal-body">
          <div class="mb-0">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email',$service_provider->email ?? '') }}" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Email</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Update Phone --}}
<div class="modal fade" id="updatePhoneModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Update Phone Number</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('provider.update.phone', Auth::id()) }}">
        @csrf
        <div class="modal-body">
          <div class="mb-0">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone',$service_provider->phone ?? '') }}" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Phone</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- ===================== END MODALS ===================== --}}
@endsection

@section('js')
@include('admin.partials.sweetalert_actions')

{{-- تحديث عنوان الهيدر حسب التاب --}}
<script>
  (function() {
    const titleMap = {
      '#dashboard': 'Dashboard',
      '#services': 'Browse Services',
      '#bookings': 'My Bookings',
      '#profile': 'Profile',
      '#earnings': 'Earnings',
      '#reviews': 'Reviews',
      '#settings': 'Settings'
    };

    function setTitleByHash() {
      const h1 = document.querySelector('.page-title');
      if (!h1) return;
      const hash = window.location.hash || '#dashboard';
      h1.textContent = titleMap[hash] || 'Dashboard';
    }

    setTitleByHash();

    document.addEventListener('shown.bs.tab', function (e) {
      const h1 = document.querySelector('.page-title');
      if (!h1) return;
      const href = e.target.getAttribute('href') || '#dashboard';
      h1.textContent = titleMap[href] || 'Dashboard';
      history.replaceState(null, '', href);
    });
  })();
</script>
@endsection
