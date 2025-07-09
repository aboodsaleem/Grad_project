@extends('admin.admin_Dashboard')
@section('title', 'All Services')

@section('admin')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Services</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Services</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('admin.services.create') }}" class="btn btn-success"> <i class="fas fa-plus"></i> Add New Service</a>
            {{-- تم حذف زر Trashed لأنه لم يعد موجود --}}
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Provider</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                                <img src="{{ asset($service->photo ?? 'upload/no_img.jpg') }}"
                                     alt="Service Image"
                                     style="width: 70px; height: 50px; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->category->name ?? '-' }}</td>
                            <td>{{ $service->price }}</td>
                            <td>{{ ucfirst($service->status) }}</td>
                            <td>{{ $service->provider->username ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-warning delete-btn"
                                        data-url="{{ route('admin.services.destroy', $service->id) }}"
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
                    @empty
                        <tr><td colspan="8" class="text-center">No services found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{ $services->links() }}
        </div>
    </div>
</div>

@include('admin.partials.sweetalert_actions')
@endsection
