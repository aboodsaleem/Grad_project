@extends('admin.admin_Dashboard')
@section('title', 'All Bookings')

@section('admin')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Bookings</div>
    </div>

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="mb-0">All Bookings</h5>
                        <div class="ms-auto">
                            <a href="{{ route('admin.bookings.create') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> Create Booking
                            </a>
                        </div>
                    </div>

                    @include('admin.msg')

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->user->username }}</td>
                                    <td>{{ $booking->service->title }}</td>
                                    <td>{{ $booking->booking_date }}</td>
                                    <td>
                                        <span class="badge bg-{{
                                            $booking->status == 'pending' ? 'warning' :
                                            ($booking->status == 'confirmed' ? 'info' :
                                            ($booking->status == 'cancelled' ? 'danger' : 'success'))
                                        }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $booking->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                        data-url="{{ route('admin.bookings.destroy', $booking->id) }}"
                                        data-title="هل أنت متأكد من حذف الخدمة؟"
                                        data-confirm="نعم، احذف"
                                        data-cancel="إلغاء"
                                        data-method="DELETE"
                                        title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 float-end">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.partials.sweetalert_actions')
@endsection
