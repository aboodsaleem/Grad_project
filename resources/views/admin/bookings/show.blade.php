@extends('admin.admin_Dashboard')
@section('title', 'Booking Details')

@section('admin')
<div class="page-content">
    <div class="col-xl-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Booking #{{ $booking->id }}</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Customer:</strong> {{ $booking->user->username }}</li>
                    <li class="list-group-item"><strong>Service:</strong> {{ $booking->service->title }}</li>
                    <li class="list-group-item"><strong>Date:</strong> {{ $booking->booking_date }}</li>
                    <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($booking->status) }}</li>
                    <li class="list-group-item"><strong>Notes:</strong> {{ $booking->notes ?? '-' }}</li>
                </ul>
                <div class="mt-3">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to list</a>
                    @can('update', $booking)
                    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning">Edit Booking</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
