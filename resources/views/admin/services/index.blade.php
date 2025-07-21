@extends('admin.admin_Dashboard')
@section('title', 'All Services')

@section('admin')
<div class="page-content">
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
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped align-middle text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Service Provider</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                                <img src="{{ asset($service->image ?? 'upload/no_img.jpg') }}"
                                    alt="Service Image"
                                    style="width: 80px; height: 70px; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td>{{ $service->title }}</td>
                            <td>{{ number_format($service->price, 2) }} $</td>
                            <td>{{ $service->serviceProvider->username ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
    data-url="{{ route('admin.services.destroy', $service->id) }}"
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
                        <tr><td colspan="6" class="text-center">  Not Found Services</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection
@section('js')
@include('admin.partials.sweetalert_actions')
@endsection
