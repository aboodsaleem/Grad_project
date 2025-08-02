@extends('admin.admin_Dashboard')
@section('title', 'All Bookings')

@section('admin')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Bookings</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Bookings</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="d-flex align-items-center mb-3">

                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="btn btn-warning">
                    Pending <span class="badge bg-dark">{{ $countPending }}</span>
                </a>&nbsp;&nbsp;

                <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}" class="btn btn-primary">
                    Confirmed <span class="badge bg-dark">{{ $countConfirmed }}</span>
                </a>&nbsp;&nbsp;

                <a href="{{ route('admin.bookings.index', ['status' => 'completed']) }}" class="btn btn-success">
                    Completed <span class="badge bg-dark">{{ $countCompleted }}</span>
                </a>&nbsp;&nbsp;

                <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}" class="btn btn-danger">
                    Cancelled <span class="badge bg-dark">{{ $countCancelled }}</span>
                </a>&nbsp;&nbsp;

                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                    Total <span class="badge bg-dark">{{ $countTotal }}</span>
                </a>

            </div>
        </div>
    </div>

    <form id="bookings-form" action="{{ route('admin.bookings.deleteMultiple') }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0">All Bookings</h5>
                    </div>

                </div>




    <input type="hidden" name="selected_ids[]" id="selected-ids" value="">

    <div id="bulk-action-buttons" class="mb-3" style="display: none;">
        <button type="button" class="btn btn-danger" id="delete-selected-btn"
            data-url="{{ route('admin.bookings.deleteMultiple') }}"
            data-title="Are you sure you want to delete the selected bookings?"
            data-confirm="Yes, delete"
            data-cancel="Cancel">
            Delete Selected
        </button>
    </div>


                <hr>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" title="Select All">
                                </th>
                                <th>ID</th>
                                <th>Service Name</th>
                                <th>Service Type</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected_ids[]" value="{{ $booking->id }}" class="select-booking">
                                    </td>
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
                                            <form action="{{ route('admin.bookings.accept', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-success btn-sm">Accept</button>
                                            </form>
                                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        @elseif ($booking->status === 'confirmed')
                                            <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-primary btn-sm">Completed</button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-warning btn-sm delete-btn"
                                                    data-url="{{ route('admin.bookings.destroy', $booking->id) }}"
                                                    data-title="هل أنت متأكد من حذف هذه الخدمة؟"
                                                    data-confirm="نعم، احذف"
                                                    data-cancel="إلغاء"
                                                    data-method="DELETE"
                                                    title="حذف">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="text-center">Not Found Bookings</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>



                {{ $bookings->links() }}
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')
@include('admin.partials.sweetalert_actions')

<script>
    const checkboxes = document.querySelectorAll('.select-booking');
    const selectAll = document.getElementById('select-all');
    const bulkButtons = document.getElementById('bulk-action-buttons');
    const selectedIdsInput = document.getElementById('selected-ids');
    const deleteBtn = document.getElementById('delete-selected-btn');

    function updateSelected() {
        const selected = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        selectedIdsInput.value = selected.join(',');

        bulkButtons.style.display = selected.length > 0 ? 'block' : 'none';
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateSelected));

    selectAll.addEventListener('change', function () {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelected();
    });

    deleteBtn.addEventListener('click', function () {
        const url = this.dataset.url;
        const title = this.dataset.title;
        const confirmText = this.dataset.confirm;
        const cancelText = this.dataset.cancel;

        if (!selectedIdsInput.value) return;

        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: confirmText,
            cancelButtonText: cancelText
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('bulk-actions-form');
                form.action = url;
                form.submit();
            }
        });
    });
</script>



@endsection
