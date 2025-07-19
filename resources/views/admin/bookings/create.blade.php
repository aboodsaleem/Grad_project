@extends('admin.admin_Dashboard')
@section('title', 'Create Booking')

@section('admin')
<div class="page-content">
    <div class="col-xl-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.bookings.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Client</label>
                        <select name="user_id" class="form-control">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Service</label>
                        <select name="service_id" class="form-control">
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Date</label>
                        <input type="datetime-local" name="booking_date" class="form-control" value="{{ old('booking_date') }}">
                    </div>

                    <!-- الحالة مخفية، تُحدد تلقائيًا بـ pending -->
                    <input type="hidden" name="status" value="pending">

                    <div class="mb-3">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
                    </div>

                    <button class="btn btn-success"><i class="fas fa-save"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
