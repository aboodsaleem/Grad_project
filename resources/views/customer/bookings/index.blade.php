
<!-- Main Bookings Content -->
<div
            class="tab-pane fade bookings-page"
            id="bookings"
            role="tabpanel"
          >    <div class="page-header d-flex align-items-center justify-content-between">
        <h2>All Bookings</h2>
        <ul class="nav nav-pills gap-2 flex-wrap d-flex gap-10 filter-tabs" id="bookingFilters" role="tablist">
            @foreach(['all', 'pending', 'confirmed', 'completed', 'cancelled'] as $status)
                <li class="nav-item @if($loop->first) active @endif" role="presentation">
                    <button
                        class="nav-link text-black bg-white tab-btn"
                        data-filter="{{ $status }}"
                        type="button">
                        {{ ucfirst($status) }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="bookings-table bg-white overflow-hidden">
        <div class="booking-row header d-grid align-items-center fw-semibold">
            <div>Service</div>
            <div>Service Provider</div>
            <div>Date</div>
            <div>Time</div>
            <div>Status</div>
            <div>Actions</div>
        </div>

        @forelse ($bookings as $booking)
            <div class="booking-row d-grid align-items-center grid tx-dark"
                 data-status="{{ $booking->status }}">
                <div>{{ $booking->service->name ?? 'N/A' }}</div>
                <div>{{ $booking->serviceProvider->username ?? 'N/A' }}</div>
                <div>{{ $booking->booking_date }}</div>
                <div>{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</div>
                <div>
                    <span class="status fw-medium text-center {{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                <div class="d-flex gap-1">
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


                   @if($booking->status === 'pending')
    <button
        type="button"
        class="btn btn-danger btn-sm delete-btn"
        data-title="هل أنت متأكد من إلغاء هذا الحجز؟"
        data-confirm="نعم، إلغاء"
        data-cancel="إلغاء"
        data-method="DELETE"
        data-url="{{ route('customer.bookings.destroy', $booking->id) }}"
    >
        Cancel
    </button>
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


