@extends('admin.admin_Dashboard')
@section('title', 'Trashed Services')

@section('admin')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Services</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Trashed Services</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('admin.services.index') }}" class="btn btn-primary">Back to Services</a>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="table-danger">
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Deleted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr class="table-danger">
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->category->name ?? '-' }}</td>
                            <td>{{ $service->deleted_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success restore-btn"
                                    data-url="{{ route('admin.services.restore', $service->id) }}"
                                    data-title="هل تريد استرجاع هذه الخدمة؟"
                                    data-confirm="نعم، استرجعها"
                                    data-cancel="إلغاء"
                                    title="Restore">
                                    <i class="fas fa-undo"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                    data-url="{{ route('admin.services.forceDelete', $service->id) }}"
                                    data-title="هل تريد الحذف النهائي لهذه الخدمة؟"
                                    data-confirm="نعم، احذفها نهائيًا"
                                    data-cancel="إلغاء"
                                    data-method="DELETE"
                                    title="Force Delete">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No trashed services.</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{ $services->links() }}
        </div>
    </div>
</div>

@include('admin.partials.sweetalert_actions')
@endsection
