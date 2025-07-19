@extends('admin.admin_Dashboard')
@section('title', 'Edit Booking')

@section('admin')
<div class="page-content">
    <div class="col-xl-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Client</label>
                        <select name="user_id" class="form-control">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $booking->user_id ? 'selected' : '' }}>{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Service</label>
                        <select name="service_id" class="form-control">
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ $service->id == $booking->service_id ? 'selected' : '' }}>{{ $service->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Date</label>
                        <input type="datetime-local" name="booking_date" class="form-control" value="{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d\TH:i') }}">
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control">{{ $booking->notes }}</textarea>
                    </div>

                    <button class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
