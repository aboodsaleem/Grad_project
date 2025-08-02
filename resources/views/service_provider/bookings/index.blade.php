
          <!-- Main Booking Content -->
<div class="tab-pane fade bookings-page" id="bookings" role="tabpanel">
  <div class="d-flex justify-content-between align-items-center page-header">
    <h2>All Bookings</h2>
    <ul class="nav nav-pills gap-2 flex-wrap d-flex gap-10 filter-tabs" id="bookingFilters" role="tablist">
      <li class="nav-item active" role="presentation">
        <button type="button" class="nav-link text-black bg-white tab-btn active" data-filter="all">All</button>
      </li>
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link text-black bg-white tab-btn" data-filter="pending">Pending</button>
      </li>
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link text-black bg-white tab-btn" data-filter="confirmed">Confirmed</button>
      </li>
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link text-black bg-white tab-btn" data-filter="completed">Completed</button>
      </li>
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link text-black bg-white tab-btn" data-filter="cancelled">Cancelled</button>
      </li>
    </ul>
  </div>

  <div class="bookings-table bg-white overflow-hidden">
    <div class="booking-row header d-grid align-items-center fw-semibold">
      <div>Service</div>
      <div>Customer</div>
      <div>Date</div>
      <div>Time</div>
      <div>Time</div>
      <div>Status</div>
      <div>Actions</div>
    </div>

    @forelse ($bookings as $booking)
      <div class="booking-row d-grid align-items-center grid tx-dark" data-status="{{ $booking->status }}">
        <div>{{ $booking->service->name ?? 'N/A' }}</div>
        <div>{{ $booking->customer->username ?? 'N/A' }}</div>
        <div>{{ $booking->booking_date }}</div>
        <div>{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</div>

        <div>
          <span class="status fw-medium text-center {{ $booking->status }}">
            {{ ucfirst($booking->status) }}
          </span>
        </div>
        <div>
  @if ($booking->status === 'pending')
    <form action="{{ route('provider.bookings.accept', $booking->id) }}" method="POST" class="d-inline">
      @csrf
      <button class="btn btn-success btn-sm">Accept</button>
    </form>
    <form action="{{ route('provider.bookings.reject', $booking->id) }}" method="POST" class="d-inline">
      @csrf
      <button class="btn btn-danger btn-sm">Reject</button>
    </form>
  @elseif ($booking->status === 'confirmed')
    <form action="{{ route('provider.bookings.complete', $booking->id) }}" method="POST" class="d-inline">
      @csrf
      <button class="btn btn-primary btn-sm">Mark as Completed</button>
    </form>
  @else
    <small class="text-muted">No Actions</small>
  @endif
</div>

      </div>
    @empty
      <div class="no-results-message text-center text-muted py-4">
        <i class="bi bi-search"></i> No bookings found.
      </div>
    @endforelse
  </div>
</div>
