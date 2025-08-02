@extends('admin.admin_Dashboard')
@yield('title', 'Admin Dashboard')

@section('css')

@endsection
@section('admin')
<div class="page-content">

					<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

    <!-- عدد المستخدمين -->
    <div class="col">
        <a href="{{ route('admin.users.list') }}" style="text-decoration:none;">
            <div class="card radius-10 bg-gradient-deepblue cursor-pointer">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 text-white">{{ $countUsers }}</h5>
                        <div class="ms-auto">
                            <i class='fas fa-users fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">Total Users</p>
                        <p class="mb-0 ms-auto">+4.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- عدد الحجوزات -->
    <div class="col">
        <a href="{{ route('admin.bookings.index') }}" style="text-decoration:none;">
            <div class="card radius-10 bg-gradient-orange cursor-pointer">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 text-white">{{ $countBookings }}</h5>
                        <div class="ms-auto">
                            <i class='fas fa-calendar-check fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">Total Bookings</p>
                        <p class="mb-0 ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- عدد الخدمات -->
    <div class="col">
        <a href="{{ route('admin.services.index') }}" style="text-decoration:none;">
            <div class="card radius-10 bg-gradient-ibiza cursor-pointer">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 text-white">{{ $countServices }}</h5>
                        <div class="ms-auto">
                            <i class="fas fa-tools fs-3 text-white"></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">Total Services</p>
                        <p class="mb-0 ms-auto">+2.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>









					 <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center">
				<div>
					<h5 class="mb-0">All Bookings</h5>
				</div>
				<div class="font-22 ms-auto">
                    {{-- <a href="{{ route('admin.bookings.create') }}" class="btn btn-success"> <i class="fas fa-plus"></i> Add New Service</a> --}}
				</div>
				</div>
				<hr>
            <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Service Type</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="fw-bold">{{ $booking->id }}</td>
                            <td>{{ $booking->service->name ?? 'N/A' }}</td>
                            <td>{{ $booking->service->serviceType ?? 'N/A' }}</td>
                            <td>{{ $booking->customer->username ?? '-' }}</td>
                            <td>{{ $booking->booking_date }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</td>
                            <td>{{ $booking->service->price ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $status = $booking->status;
                                    $bgClass = match($status) {
                                        'pending' => 'badge rounded-pill bg-light-warning text-warning w-100',
                                        'confirmed' => 'badge rounded-pill bg-light-info text-info w-100',
                                        'completed' => 'badge rounded-pill bg-light-success text-success w-100',
                                        'cancelled' => 'badge rounded-pill bg-light-danger text-danger w-100',
                                        default => 'bg-secondary text-white',
                                    };
                                @endphp
                                <span class="badge {{ $bgClass }} p-2">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>
    @if ($booking->status === 'pending')
        <form action="{{ route('admin.bookings.accept', $booking->id) }}" method="POST" class="d-inline me-1">
            @csrf
            <button class="btn btn-success btn-sm">Accept</button>
        </form>
        <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" class="d-inline me-1">
            @csrf
            <button class="btn btn-danger btn-sm">Reject</button>
        </form>
    @elseif ($booking->status === 'confirmed')
        <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" class="d-inline me-1">
            @csrf
            <button class="btn btn-primary btn-sm">Mark as Completed</button>
        </form>
    @else
        <span class="text-muted">{{ ucfirst($booking->status) }}</span>
    @endif

    {{-- زر الحذف موجود دائماً لكن بحجم صغير ومنفصل --}}
    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline ms-2">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-warning btn-sm delete-btn"
            data-url="{{ route('admin.bookings.destroy', $booking->id) }}"
            data-title="هل أنت متأكد من حذف هذا الحجز؟"
            data-confirm="نعم، احذف"
            data-cancel="إلغاء"
            data-method="DELETE"
            title="حذف">
            <i class="fas fa-trash-alt mb-0 mt-0"></i>
        </button>
    </form>
</td>

                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">  Not Found Bookings</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

@endsection

@section('js')
@include('admin.partials.sweetalert_actions')

@endsection
